<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class UpdateController extends Controller
{
    public function index()
    {
        if (Gate::allows('visualizar_atualizacoes')) {
            $repo_name = env('UPDATES_REPO_NAME');
            $repo_owner = env('UPDATES_REPO_OWNER');
            $repo_url = "https://api.github.com/repos/$repo_owner/$repo_name/commits";
            $updates = Http::get($repo_url)->json();

            if (isset($updates['message']) && $updates['message'] == 'Not Found') {
                $updates = [];
            }

            return view('updates.index', compact('updates'));
        }
    }
}
