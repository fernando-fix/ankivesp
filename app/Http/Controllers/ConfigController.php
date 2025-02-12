<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Http\Requests\ConfigRequest;
use App\Models\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('visualizar_configuracoes')) {
            $configs = Config::orderBy('id', 'asc')->paginate(15);
            return view('admin.configs.index', compact('configs'));
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConfigRequest $request)
    {
        if (Gate::allows('cadastrar_configuracoes')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $config = Config::create($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro criado com sucesso!', $config);
                return redirect()->route('admin.configs.index');
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
    public function show(Config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConfigRequest $request, Config $config)
    {
        if (Gate::allows('editar_configuracoes')) {
            DB::beginTransaction();
            $data = $request->except(['_token', 'modal_trigger']);
            $errors = [];

            try {
                $config->update($data);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro atualizado com sucesso!', $config);
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
    public function destroy(Config $config)
    {
        if (Gate::allows('excluir_configuracoes')) {
            DB::beginTransaction();
            $errors = [];

            try {
                $config->delete();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (count($errors) == 0) {
                DB::commit();
                LogAndFlash::success('Registro excluido com sucesso!', $config);
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
