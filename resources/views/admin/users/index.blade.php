@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Usuários
                </h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                    @can('cadastrar_usuarios')
                        @include('admin.users.create_modal')
                    @endcan
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Cadastro</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="align-middle">{{ $user->id }}</td>
                                <td class="align-middle">{{ $user->name }}</td>
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle">{{ date('d/m/Y H:i:s', strtotime($user->created_at)) }}</td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    @canany(['excluir_usuarios', 'associar_papeis', 'editar_usuarios'])
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-toggle="dropdown" title="Mais Opções">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                @can('editar_usuarios')
                                                    <li>
                                                        @include('admin.users.edit_modal_trigger', $user)
                                                    </li>
                                                @endcan
                                                @can('associar_papeis')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.users.edit_roles', $user) }}">
                                                            <i class="fas fa-user-tag text-primary"></i>
                                                            Associar papéis
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('excluir_usuarios')
                                                    <li>
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="post">
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
                                @can('editar_usuarios')
                                    @include('admin.users.edit_modal_body', $user)
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
                        {{ $users->appends($filter)->links() }}
                    @else
                        {{ $users->links() }}
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
