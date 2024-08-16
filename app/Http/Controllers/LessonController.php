<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Http\Requests\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LessonController extends Controller
{
    public $pagination = 15;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('visualizar_aulas')) {
            $courses = Course::get();
            $modules = Module::get();
            $lessons = Lesson::paginate($this->pagination)->withQueryString();
            return view('lessons.index', compact('courses', 'modules', 'lessons'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('cadastrar_aulas')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        if (Gate::allows('cadastrar_aulas')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $lastPosition = Lesson::where('module_id', $data['module_id'])->max('position');
                $data['position'] = $lastPosition + 1;

                $lesson = Lesson::create($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            // Atualizar contagem de módulos do curso
            try {
                $lesson->module->lessons_count = $lesson->module->lessons()->count();
                $lesson->module->save();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro criado com sucesso!', $lesson);
                return redirect()->route('lessons.index');
            } else {
                DB::rollBack();
                LogAndFlash::error('Erro ao tentar criar o registro!', $errors);
                return redirect()->back();
            }
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        if (Gate::allows('visualizar_aulas')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        if (Gate::allows('editar_aulas')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        if (Gate::allows('editar_aulas')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $lesson->update($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            // Atualizar contagem de módulos do curso
            try {
                $lesson->module->lessons_count = $lesson->module->lessons()->count();
                $lesson->module->save();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $lesson);
                return redirect()->back();
            } else {
                DB::rollBack();
                LogAndFlash::error('Erro ao tentar atualizar o registro!', $errors);
                return redirect()->back();
            }
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        if (Gate::allows('excluir_aulas')) {
            DB::beginTransaction();
            $errors = [];

            try {
                $lesson->delete();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            // Atualizar contagem de módulos do curso
            try {
                $lesson->module->lessons_count = $lesson->module->lessons()->count();
                $lesson->module->save();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro excluido com sucesso!', $lesson);
                return redirect()->back();
            } else {
                DB::rollBack();
                LogAndFlash::error('Erro ao tentar excluir o registro!', $errors);
                return redirect()->back();
            }
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }
}
