<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogAndFlash;
use App\Http\Requests\ModuleRequest;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public $pagination = 15;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('visualizar_modulos')) {
            $courses = Course::get();
            $modules = Module::with('course')->paginate($this->pagination);
            return view('admin.modules.index', compact('modules', 'courses'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('cadastrar_modulos')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request)
    {
        if (Gate::allows('cadastrar_modulos')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $lastPosition = Module::where('course_id', $data['course_id'])->max('position');
                $data['position'] = $lastPosition + 1;

                $module = Module::create($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            // Atualizar contagem de módulos do curso
            try {
                $module->course->modules_count = $module->course->modules()->count();
                $module->course->save();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro criado com sucesso!', $module);
                return redirect()->back();
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
    public function show(Module $module)
    {
        if (Gate::allows('visualizar_modulos')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        if (Gate::allows('editar_modulos')) {
            $courses = Course::all();
            $lessons = Lesson::where('module_id', $module->id)->orderBy('position', 'asc')->get();
            $course = $module->course;
            return view('admin.modules.edit', compact('module', 'courses', 'lessons', 'course'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, Module $module)
    {
        if (Gate::allows('editar_modulos')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $module->update($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            // Atualizar contagem de módulos do curso
            try {
                $module->course->modules_count = $module->course->modules()->count();
                $module->course->save();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $module);
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
    public function destroy(Module $module)
    {
        if (Gate::allows('excluir_modulos')) {
            DB::beginTransaction();
            $errors = [];

            try {
                $module->delete();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            // Atualizar contagem de módulos do curso
            try {
                $module->course->modules_count = $module->course->modules()->count();
                $module->course->save();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro excluido com sucesso!', $module);
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

    public function indexJson(Course $course)
    {
        if (Gate::allows('visualizar_modulos')) {
            $modules = Module::where('course_id', $course->id)->get(['id', 'name', 'position']);
            return response()->json($modules);
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return response()->json(null, 403);
    }

    public function reorder(Request $request): JsonResponse
    {
        $ids = $request->input('ids');
        DB::beginTransaction();
        $errors = [];
        try {
            foreach ($ids as $key => $id) {
                Module::where('id', $id)->update(['position' => $key]);
            }
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }
        if (count($errors) == 0) {
            DB::commit();
            LogAndFlash::success('Ordem alterada com sucesso!');
            return response()->json([
                'success' => true,
                'message' => 'Ordem alterada com sucesso'
            ]);
        } else {
            DB::rollBack();
            LogAndFlash::error('Erro ao tentar alterar a ordem!', $errors);
            return response()->json([
                'success' => false,
                'message' => 'Erro ao tentar alterar a ordem!'
            ]);
        }
    }
}
