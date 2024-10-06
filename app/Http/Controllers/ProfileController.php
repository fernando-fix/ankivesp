<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Http\Requests\ProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = User::find(auth()->user()->id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        return redirect()->route('profiles.edit', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return redirect()->route('home');
        if ($user->id != $this->loggedUser->id) {
            LogAndFlash::warning('Sem permissão de acesso!');
            return redirect()->back();
        }

        return view('profiles.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->id != $this->loggedUser->id) {
            LogAndFlash::warning('Sem permissão de acesso!');
            return redirect()->back();
        }

        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, User $user)
    {
        if ($user->id != $this->loggedUser->id) {
            LogAndFlash::warning('Sem permissão de acesso!');
            return redirect()->back();
        }

        try {
            if ($request->password || $request->password_confirmation) {
                $user->update([
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                ]);
            }
        } catch (\Exception $e) {
            LogAndFlash::error('Erro ao tentar atualizar o perfil', $e->getMessage());
        }

        LogAndFlash::success('Registro atualizado com sucesso!', $user);
        return redirect()->route('profiles.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id != $this->loggedUser->id) {
            LogAndFlash::warning('Sem permissão de acesso!');
            return redirect()->back();
        }

        return redirect()->route('profiles.show', $user->id);
    }
}
