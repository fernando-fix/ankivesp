<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        // USUARIOS
        ['Visualizar Usuários',     'Permite visualizar Usuários'],
        ['Cadastrar Usuários',      'Permite Cadastrar Usuários'],
        ['Editar Usuários',         'Permite editar Usuários'],
        ['Excluir Usuários',        'Permite excluir Usuários'],
        // ROLES
        ['Visualizar Papéis',       'Permite visualizar Papéis'],
        ['Cadastrar Papéis',        'Permite Cadastrar Papéis'],
        ['Editar Papéis',           'Permite editar Papéis'],
        ['Excluir Papéis',          'Permite excluir Papéis'],
        // PERMISSIONS
        ['Visualizar Permissões',   'Permite visualizar Permissões'],
        // ASSOCIACOES
        ['Associar papeis',         'Permite associar papeis'],
        ['Associar permissoes',     'Permite associar permissoes'],
        // LOGS
        ['Visualizar Logs',         'Permite visualizar Logs'],
        // CURSOS
        ['Visualizar Cursos',       'Permite visualizar Cursos'],
        ['Cadastrar Cursos',        'Permite Cadastrar Cursos'],
        ['Editar Cursos',           'Permite editar Cursos'],
        ['Excluir Cursos',          'Permite excluir Cursos'],

    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            $slug = Str::slug($permission[0]);
            $slug_underscore = Str::of($slug)->replace('-', '_');
            if (!Permission::where('slug', $slug)->exists()) {
                Permission::create([
                    'name' => $permission[0],
                    'description' => $permission[1],
                    'slug' => $slug_underscore
                ]);
            }
        }
    }
}
