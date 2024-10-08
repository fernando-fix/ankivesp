@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Módulos
                </h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                    @can('cadastrar_modulos')
                        @include('admin.modules.create_modal')
                    @endcan
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Aulas</th>
                            <th scope="col">Prazo</th>
                            <th scope="col">Cadastro</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($modules as $module)
                            <tr>
                                <td class="align-middle">{{ $module->id }}</td>
                                <td class="align-middle">{{ $module->name }}</td>
                                <td class="align-middle">{{ $module->course->name }}</td>
                                <td class="align-middle">{{ $module->lessons_count }}</td>
                                <td class="align-middle">{{ date('d/m/Y', strtotime($module->due_date)) }}</td>
                                <td class="align-middle">{{ date('d/m/Y', strtotime($module->created_at)) }}</td>
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
                                                        @include('admin.modules.edit_modal_trigger', $module)
                                                    </li>
                                                @endcan
                                                @can('reorganizar_aulas')
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-sort-numeric-up-alt text-info"></i>
                                                            Reorganizar aulas
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('excluir_modulos')
                                                    <li>
                                                        <form action="{{ route('admin.modules.destroy', $module) }}" method="post">
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
                                <td class="align-middle" colspan="100%" class="text-center">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- paginação --}}
                <div class="paginacao mt-2">
                    @if (isset($filter))
                        {{ $modules->appends($filter)->links() }}
                    @else
                        {{ $modules->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@if ($errors->any() && old('modal_trigger'))
    @push('js')
        <script>
            // Reabre o modal
            $(document).ready(function() {
                function reopenModal() {
                    $('{{ old('modal_trigger') }}').modal('show');
                }
                reopenModal();
            });

            // Recarrega a página caso o modal feche
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                $(modal).on('hidden.bs.modal', function(e) {
                    location.reload();
                })
            })
        </script>
    @endpush
@endif
