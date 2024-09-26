@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Perguntas
                </h3>
                <div class="card-tools">
                    @include('questions.filter_modal')
                    @include('questions.create_modal')
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Módulo</th>
                            <th scope="col">Aula</th>
                            <th scope="col">Pergunta</th>
                            <th scope="col">Respostas</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questions as $question)
                            <tr>
                                <td class="align-middle">{{ $question->id }}</td>
                                <td class="align-middle">{{ $question->course->name }}</td>
                                <td class="align-middle">{{ $question->module->name }}</td>
                                <td class="align-middle">{{ $question->lesson->name }}</td>
                                <td class="align-middle">{{ strip_tags($question->question) }}</td>
                                <td class="align-middle">{{ count($question->answers) }}</td>
                                <td class="align-middle" style="white-space: nowrap$question->question ;">
                                    {{-- botões --}}
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                            data-toggle="dropdown" title="Mais Opções">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                @include('questions.edit_modal_trigger', [
                                                    'question' => $question,
                                                ])
                                            </li>
                                            {{-- deletar pergunta --}}
                                            <li>
                                                <form action="{{ route('questions.destroy', $question) }}" method="post">
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
                                        </ul>
                                    </div>
                                </td>
                                @include('questions.edit_modal_body', ['question' => $question])
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
                        {{ $questions->appends($filter)->links() }}
                    @else
                        {{ $questions->links() }}
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
