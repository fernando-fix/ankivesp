@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Editar Curso - {{ $course->name }}
                </h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-primary ml-1" title="Voltar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">

                <form action="{{ route('admin.courses.update', $course) }}" method="post">
                    @csrf
                    @method('PUT')

                    @include('admin.courses.form')

                    <button type="submit" class="btn btn-sm btn-primary ml-1" title="Salvar">
                        <i class="fas fa-save"></i>
                        Atualizar
                    </button>

                </form>

                <div class="card card-outline card-info mt-2">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i>
                            Módulos
                        </h3>
                        <div class="card-tools">
                            @can('cadastrar_modulos')
                                @include('admin.courses.modules.create_modal')
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">

                        <table  class="table table-sm table-hover table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Posição</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col">Aulas</th>
                                    <th scope="col">Prazo</th>
                                    <th scope="col" width=1>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-table" data-route="{{ route('admin.modules.reorder', $course) }}">
                                @forelse ($modules as $module)
                                    <tr class="sortable-item" data-id="{{ $module->id }}" style="cursor: move;">
                                        <td class="align-middle">
                                            <i class="fas fa-arrows-alt"></i>
                                        </td>
                                        <td class="align-middle">{{ $module->name }}</td>
                                        <td class="align-middle">{{ $module->course->name }}</td>
                                        <td class="align-middle">{{ $module->lessons_count }}</td>
                                        <td class="align-middle">{{ date('d/m/Y', strtotime($module->due_date)) }}</td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            @canany(['excluir_modulos', 'editar_modulos'])
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" title="Mais Opções">
                                                        <i class="fas fa-bars"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        @can('editar_modulos')
                                                            <li>
                                                                @include(
                                                                    'admin.modules.edit_modal_trigger',
                                                                    $module)
                                                            </li>
                                                        @endcan
                                                        @can('excluir_modulos')
                                                            <li>
                                                                <form action="{{ route('admin.modules.destroy', $module) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item" href="#"
                                                                        title="Excluir"
                                                                        onclick="return confirm('Deseja realmente excluir este registro?');">
                                                                        <i class="fas fa-trash text-danger"></i>
                                                                        Excluir
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            @endcanany
                                        </td>
                                        @can('editar_modulos')
                                            @include('admin.modules.edit_modal_body', $module)
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="align-middle" colspan="100%" class="text-center">Nenhum registro
                                            encontrado</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        new Sortable(document.getElementById('sortable-table'), {
            animation: 150,
            onSort: function(evt) {
                const ids = Array.from(document.querySelectorAll('.sortable-item'))
                    .map(item => item.getAttribute('data-id'));
                const route = document.getElementById('sortable-table').getAttribute('data-route');
                fetch(route, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ids
                    })
                }).then(result => result.json()).then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        console.error(data.message);
                    }
                });
            }
        });
    </script>
@endpush