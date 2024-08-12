@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Aulas
                </h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                    @can('cadastrar_aulas')
                        @include('lessons.create_modal')
                    @endcan
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Aula</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Módulo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Posição</th>
                            <th scope="col">Cadastro</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lessons as $lesson)
                            <tr>
                                <td class="align-middle">{{ $lesson->id }}</td>
                                <td class="align-middle">{{ $lesson->name }}</td>
                                <td class="align-middle">{{ $lesson->course->name }}</td>
                                <td class="align-middle">{{ $lesson->module->name }}</td>
                                <td class="align-middle">{{ $lesson->type }}</td>
                                <td class="align-middle">{{ $lesson->position }}</td>
                                <td class="align-middle">{{ date('d/m/Y', strtotime($lesson->created_at)) }}</td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    @canany(['visualizar_aulas', 'editar_aulas', 'excluir_aulas'])
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-toggle="dropdown" title="Mais Opções">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                @can('visualizar_aulas')
                                                    <li>
                                                        @if ($lesson->type == 'youtube')
                                                            <a type="button" href="{{ $lesson->url }}" target="_blank"
                                                                class="btn btn-reset ml-1 w-100 text-left">
                                                                <i class="fab fa-youtube text-danger"></i>
                                                                Acessar o vídeo
                                                            </a>
                                                        @elseif ($lesson->type == 'pdf')
                                                            <a type="button" href="{{ $lesson->url }}" target="_blank"
                                                                class="btn btn-reset ml-1 w-100 text-left">
                                                                <i class="far fa-file-pdf text-info"></i>
                                                                Acessar o arquivo
                                                            </a>
                                                        @elseif ($lesson->type == 'link')
                                                            <a type="button" href="{{ $lesson->url }}" target="_blank"
                                                                class="btn btn-reset ml-1 w-100 text-left">
                                                                <i class="fas fa-link text-primary"></i>
                                                                Acessar o link
                                                            </a>
                                                        @endif
                                                    </li>
                                                @endcan
                                                @can('editar_aulas')
                                                    <li>
                                                        @include('lessons.edit_modal_trigger', $lesson)
                                                    </li>
                                                @endcan
                                                @can('excluir_aulas')
                                                    <li>
                                                        <form action="{{ route('lessons.destroy', $lesson) }}" method="post">
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
                                @can('editar_aulas')
                                    @include('lessons.edit_modal_body', $lesson)
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
                        {{ $lessons->appends($filter)->links() }}
                    @else
                        {{ $lessons->links() }}
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
