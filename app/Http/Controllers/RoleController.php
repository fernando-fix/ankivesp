<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public $pagination = 15;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('visualizar_papeis')) {
            $roles = Role::paginate($this->pagination)->withQueryString();
            return view('roles.index', compact('roles'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('cadastrar_papeis')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        if (Gate::allows('cadastrar_papeis')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $role = Role::create($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro criado com sucesso!', $role);
                return redirect()->route('roles.index');
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
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        if (Gate::allows('visualizar_papeis')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if (Gate::allows('editar_papeis')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        if (Gate::allows('editar_papeis')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $role->update($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $role);
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
    public function destroy(Role $role)
    {
        if (Gate::allows('excluir_papeis')) {
            DB::beginTransaction();
            $errors = [];

            try {
                $role->delete();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro excluido com sucesso!', $role);
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

    public function editPermissions(Role $role)
    {
        if (Gate::allows('associar_permissoes')) {
            $permissions = Permission::orderBy('name', 'asc')->get();
            return view('roles.edit_permissions', compact('role', 'permissions'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    public function updatePermissions(Request $request, Role $role)
    {
        if (Gate::allows('associar_permissoes')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $role->permissions()->sync($request->permissions);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $role->permissions);
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
}
