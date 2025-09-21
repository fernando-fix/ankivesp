<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogAndFlash;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Att;
use App\Models\Module;

class CourseController extends Controller
{
    public $pagination = 15;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('visualizar_cursos')) {
            $courses = Course::with('image')->paginate($this->pagination);
            return view('admin/courses.index', compact('courses'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('cadastrar_cursos')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        if (Gate::allows('cadastrar_cursos')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $course = Course::create($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (isset($data['image']) && count($errors) == 0) {
                $att = Att::attachFile($request->file('image'), 'courses', 'courses', $course->id, 'image');
                if (!$att) {
                    $errors[] = 'Erro ao salvar imagem!';
                }
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro criado com sucesso!', $course);
                return redirect()->route('admin.courses.index');
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
    public function show(Course $course)
    {
        if (Gate::allows('visualizar_cursos')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        if (Gate::allows('editar_cursos')) {
            $courses = Course::all();
            $modules = Module::where('course_id', $course->id)->orderBy('position')->get();
            return view('admin.courses.edit', compact('course', 'modules', 'courses'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        if (Gate::allows('editar_cursos')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $course->update($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (isset($data['image']) && count($errors) == 0) {
                $att = Att::attachFile($request->file('image'), 'courses', 'courses', $course->id, 'image');
                if (!$att) {
                    $errors[] = 'Erro ao salvar imagem!';
                }
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $course);
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
    public function destroy(Course $course)
    {
        if (Gate::allows('excluir_cursos')) {
            DB::beginTransaction();
            $errors = [];

            try {
                $course->delete();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            // Deletar Imagem
            if (count($errors) == 0) {
                $deleteImage = Att::deleteFile('courses', $course->id, 'image');
                if (!$deleteImage) {
                    $errors[] = 'Erro ao remover imagem!';
                }
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro excluido com sucesso!', $course);
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
