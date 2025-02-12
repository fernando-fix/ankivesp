@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Configurações
                </h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                    @can('cadastrar_configuracoes')
                        @include('admin.configs.create_modal')
                    @endcan
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Chave</th>
                            <th scope="col">Valor</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($configs as $config)
                            <tr>
                                <td class="align-middle">{{ $config->id }}</td>
                                <td class="align-middle">{{ $config->name }}</td>
                                <td class="align-middle">{{ $config->key }}</td>
                                <td class="align-middle">{{ Str::limit($config->value, 40) }}</td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    @canany(['editar_configuracoes', 'excluir_configuracoes'])
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-toggle="dropdown" title="Mais Opções">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                @can('editar_configuracoes')
                                                    <li>
                                                        @include(
                                                            'admin.configs.edit_modal_trigger',
                                                            $config)
                                                    </li>
                                                @endcan
                                                @can('excluir_configuracoes')
                                                    <li>
                                                        <form action="{{ route('admin.configs.destroy', $config) }}" method="post">
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
                                @can('editar_configuracoes')
                                    @include('admin.configs.edit_modal_body', $config)
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
                        {{ $configs->appends($filter)->links() }}
                    @else
                        {{ $configs->links() }}
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
