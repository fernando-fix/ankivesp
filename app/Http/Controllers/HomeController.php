<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('login');
    }

    public function home()
    {
        return view('statics.home');
    }

    public function dashboard()
    {
        if (Gate::allows('visualizar_dashboard')) {
            return view('statics.dashboard');
        }
        LogAndFlash::warning('Sem permissão de acesso!');
        return redirect()->back();
    }
}
