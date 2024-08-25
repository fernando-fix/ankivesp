@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Papéis
                </h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                    @include('admin.roles.create_modal')
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Usuários associados</th>
                            <th scope="col">Permissões associadas</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td class="align-middle">{{ $role->id }}</td>
                                <td class="align-middle">{{ $role->name }}</td>
                                <td class="align-middle">{{ $role->users->count() }}</td>
                                <td class="align-middle">{{ $role->permissions->count() }}</td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    @canany(['excluir_papeis', 'associar_permissoes', 'editar_papeis'])
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-toggle="dropdown" title="Mais Opções">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                {{-- <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-eye text-info"></i>
                                                    Visualizar
                                                </a>
                                            </li> --}}
                                                @can('editar_papeis')
                                                    <li>
                                                        @include('admin.roles.edit_modal_trigger', $role)
                                                    </li>
                                                @endcan
                                                @can('associar_permissoes')
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.roles.edit_permissions', $role) }}">
                                                            <i class="fas fa-user-tag text-primary"></i>
                                                            Associar permissões
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('excluir_papeis')
                                                    <li>
                                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="post">
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
                                @can('editar_papeis')
                                    @include('admin.roles.edit_modal_body', $role)
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
                        {{ $roles->appends($filter)->links() }}
                    @else
                        {{ $roles->links() }}
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
