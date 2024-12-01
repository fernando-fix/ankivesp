<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        // HOME E DASHBOARD
        ['Visualizar dashboard',    'Permite visualizar dashboard'],
        // USUARIOS
        ['Visualizar usuários',     'Permite visualizar usuários'],
        ['Cadastrar usuários',      'Permite cadastrar usuários'],
        ['Editar usuários',         'Permite editar usuários'],
        ['Excluir usuários',        'Permite excluir usuários'],
        // ROLES
        ['Visualizar papéis',       'Permite visualizar papéis'],
        ['Cadastrar papéis',        'Permite cadastrar papéis'],
        ['Editar papéis',           'Permite editar papéis'],
        ['Excluir papéis',          'Permite excluir papéis'],
        // PERMISSIONS
        ['Visualizar permissões',   'Permite visualizar permissões'],
        // ASSOCIACOES
        ['Associar papéis',         'Permite associar papéis'],
        ['Associar permissões',     'Permite associar permissões'],
        // LOGS
        ['Visualizar logs',         'Permite visualizar logs'],
        // CURSOS
        ['Visualizar cursos',       'Permite visualizar cursos'],
        ['Cadastrar cursos',        'Permite cadastrar cursos'],
        ['Editar cursos',           'Permite editar cursos'],
        ['Excluir cursos',          'Permite excluir cursos'],
        // MODULOS
        ['Visualizar módulos',      'Permite visualizar módulos'],
        ['Cadastrar módulos',       'Permite cadastrar módulos'],
        ['Editar módulos',          'Permite editar módulos'],
        ['Excluir módulos',         'Permite excluir módulos'],
        // AULAS
        ['Visualizar aulas',        'Permite visualizar aulas'],
        ['Cadastrar aulas',         'Permite cadastrar aulas'],
        ['Editar aulas',            'Permite editar aulas'],
        ['Excluir aulas',           'Permite excluir aulas'],
        // ATUALIZACOES
        ['Visualizar atualizações', 'Permite visualizar atualizações'],
        // QUESTIONS
        ['Cadastrar perguntas',      'Permite cadastrar perguntas'],
        ['Editar perguntas',         'Permite editar perguntas'],
        ['Excluir perguntas',        'Permite excluir perguntas'],
        ['Gerar perguntas',          'Permite gerar perguntas'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            $slug = Str::slug($permission[0]);
            $slug_underscore = Str::of($slug)->replace('-', '_');
            if (!Permission::where('slug', $slug_underscore)->exists()) { // Changed to check against slug_underscore
                Permission::create([
                    'name' => $permission[0],
                    'description' => $permission[1],
                    'slug' => $slug_underscore
                ]);
            }
        }
    }
}
