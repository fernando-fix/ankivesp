<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Models\User;
use Illuminate\Http\Request;

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
        return redirect()->route('profiles.show', $this->loggedUser->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
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
    public function update(Request $request, User $user)
    {
        if ($user->id != $this->loggedUser->id) {
            LogAndFlash::warning('Sem permissão de acesso!');
            return redirect()->back();
        }

        return redirect()->route('profiles.show', $user->id);
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
