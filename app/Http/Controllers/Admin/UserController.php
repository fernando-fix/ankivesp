<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogAndFlash;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public $pagination = 15;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('visualizar_usuarios')) {
            $users = User::paginate($this->pagination)->withQueryString();
            return view('admin/users.index', compact('users'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('cadastrar_usuarios')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        if (Gate::allows('cadastrar_usuarios')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $user = User::create($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro criado com sucesso!', $user);
                return redirect()->route('admin.users.index');
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
    public function show(User $user)
    {
        if (Gate::allows('visualizar_usuarios')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (Gate::allows('editar_usuarios')) {
            return redirect()->back();
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        if (Gate::allows('editar_usuarios')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $user->update($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $user);
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
    public function destroy(User $user)
    {
        if (Gate::allows('excluir_usuarios')) {
            DB::beginTransaction();
            $errors = [];

            if ($user->is_admin == 1) {
                $errors[] = 'O administrador não pode ser excluido!';
            }

            try {
                $user->delete();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro excluido com sucesso!', $user);
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

    public function editRoles(User $user)
    {
        if (Gate::allows('associar_papeis')) {
            $roles = Role::orderBy('name', 'asc')->get();
            return view('admin/users.edit_roles', compact('user', 'roles'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    public function updateRoles(Request $request, User $user)
    {
        if (Gate::allows('associar_papeis')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $user->roles()->sync($request->roles);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $user->roles);
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
