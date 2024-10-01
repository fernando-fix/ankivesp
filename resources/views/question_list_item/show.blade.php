@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Questionário</h3>
                <div class="card-tools">
                    {{-- botão voltar --}}
                    <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-primary ml-1" title="Voltar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">

                <div class="d-flex justify-content-between">
                    <div>
                        <h2>Perguntas:</h2>
                        @foreach ($questionList->questionListItems as $key => $questionListItem)
                            <a
                                @if ($questionListItem->question_id == $question->id) href="#"
                                @else
                                href="{{ route('reviews.answer-questions', [$questionList, $questionListItem->question]) }}" @endif>
                                @if ($questionListItem->answer_id != null)
                                    @if ($questionListItem->question_id == $question->id)
                                        <span class="btn btn-success px-3 py-1">{{ $key + 1 }}</span>
                                    @else
                                        <span class="btn btn-primary px-3 py-1">{{ $key + 1 }}</span>
                                    @endif
                                @else
                                    @if ($questionListItem->question_id == $question->id)
                                        <span class="btn btn-success px-3 py-1">{{ $key + 1 }}</span>
                                    @else
                                        <span class="btn btn-secondary px-3 py-1">{{ $key + 1 }}</span>
                                    @endif
                                @endif
                            </a>
                        @endforeach
                    </div>
                    <div class="mr-3">
                        <h2>Legenda:</h2>
                        <span class="badge badge-primary px-2 py-1">Respondido</span> <br>
                        <span class="badge badge-secondary px-2 py-1">Não respondido</span><br>
                        <span class="badge badge-success px-2 py-1">Pergunta atual</span>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    {{-- Pergunta --}}
                    <h4>{!! $question->question !!}</h4>

                    {{-- Botão entregar questionário --}}
                    <div>
                        <form action="{{ route('reviews.check-all-answers', $questionList) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                                Entregar questionário
                            </button>
                        </form>
                    </div>
                </div>

                <hr>

                <form action="{{ route('reviews.check-answer', $questionListItemActive) }}" method="post">
                    @csrf
                    @foreach ($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer_id" id="answer-{{ $answer->id }}"
                                value="{{ $answer->id }}" required @if ($questionListItemActive->answer_id == $answer->id) checked @endif>
                            <label class="form-check-label mb-2"
                                for="answer-{{ $answer->id }}">{!! $answer->answer !!}</label>
                        </div>
                    @endforeach

                    <hr>
                    <input type="hidden" name="myacc" id="myacc" value="0">
                    <input type="checkbox" name="myacc" id="myacc" value="1" checked>
                    <label for="myacc">Associar na minha conta</label>
                    <button type="submit" class="btn btn-sm btn-primary ml-3">Responder</button>
                </form>

            </div>
        </div>
    </div>
@endsection
