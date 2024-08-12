@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Cursos
                </h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                    @can('cadastrar_cursos')
                        @include('courses.create_modal')
                    @endcan
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Ano</th>
                            <th scope="col">Semestre</th>
                            <th scope="col">Módulos</th>
                            <th scope="col">Cadastro</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr>
                                <td class="align-middle">{{ $course->id }}</td>
                                <td class="align-middle">{{ $course->name }}</td>
                                <td class="align-middle">{{ $course->year }}</td>
                                <td class="align-middle">{{ $course->semester }}</td>
                                <td class="align-middle">{{ $course->modules_count }}</td>
                                <td class="align-middle">{{ date('d/m/Y', strtotime($course->created_at)) }}</td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    @canany(['excluir_cursos', 'editar_cursos'])
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-toggle="dropdown" title="Mais Opções">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                @can('editar_cursos')
                                                    <li>
                                                        @include('courses.edit_modal_trigger', $course)
                                                    </li>
                                                @endcan
                                                @can('reorganizar_modulos')
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-sort-numeric-up-alt text-info"></i>
                                                            Reorganizar módulos
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('excluir_cursos')
                                                    <li>
                                                        <form action="{{ route('courses.destroy', $course) }}" method="post">
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
                                @can('editar_cursos')
                                    @include('courses.edit_modal_body', $course)
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
                        {{ $courses->appends($filter)->links() }}
                    @else
                        {{ $courses->links() }}
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
