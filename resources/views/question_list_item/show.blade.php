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
                                        <span class="mt-1 btn btn-success px-3 py-1">{{ $key + 1 }}</span>
                                    @else
                                        <span class="mt-1 btn btn-primary px-3 py-1">{{ $key + 1 }}</span>
                                    @endif
                                @else
                                    @if ($questionListItem->question_id == $question->id)
                                        <span class="mt-1 btn btn-success px-3 py-1">{{ $key + 1 }}</span>
                                    @else
                                        <span class="mt-1 btn btn-secondary px-3 py-1">{{ $key + 1 }}</span>
                                    @endif
                                @endif
                            </a>
                        @endforeach
                        <div class="mt-2 h4">
                            Prazo:
                            <span id="countdown" class="text-secondary">
                                @php
                                    $time = (new DateTime())->diff(new DateTime($questionList->datetime_limit));
                                    $minutes = str_pad($time->format('%i'), 2, '0', STR_PAD_LEFT);
                                    $seconds = str_pad($time->format('%s'), 2, '0', STR_PAD_LEFT);
                                @endphp
                                {{ $minutes }}m {{ $seconds }}s
                            </span> | <span class="text-danger">Ao encerrar o prazo o questionário será excluído</span>
                        </div>
                    </div>
                    <div class="mr-3 ml-3">
                        <h2>Legenda:</h2>
                        <span class="badge badge-primary px-2 py-1">Respondido</span> <br>
                        <span class="badge badge-secondary px-2 py-1">Não respondido</span><br>
                        <span class="badge badge-success px-2 py-1">Pergunta atual</span>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    {{-- Pergunta --}}
                    <div>
                        <small>
                            <p class="mb-1">
                                <a href="{{ route('lessons.show', [$question->lesson]) }}" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                    Aula de referência
                                </a>
                            </p>
                        </small>
                        <h4>{!! $question->question !!}</h4>
                    </div>

                    {{-- Botão entregar questionário --}}
                    <div class="d-flex flex-column">
                        <div class="mt-2">
                            <form action="{{ route('reviews.check-all-answers', $questionList) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                    Entregar questionário
                                </button>
                            </form>
                        </div>
                        <div class="mt-2">
                            <form action="{{ route('reviews.give-up', $questionList) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fas fa-ban"></i>
                                    Desistir do questionário
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <hr>

                <form action="{{ route('reviews.check-answer', $questionListItemActive) }}" method="post">
                    @csrf
                    @foreach ($question->answers as $answer)
                        <div class="form-check input-hover">
                            <input class="form-check-input" role="button" type="radio" name="answer_id"
                                id="answer-{{ $answer->id }}" value="{{ $answer->id }}" required
                                @if ($questionListItemActive->answer_id == $answer->id) checked @endif>
                            <label class="form-check-label mb-2" role="button"
                                for="answer-{{ $answer->id }}">{!! $answer->answer !!}</label>
                        </div>
                    @endforeach

                    <hr>
                    <input type="hidden" name="myacc" id="myacc" value="0">
                    <input type="checkbox" name="myacc" id="myacc" value="1" checked>
                    <label for="myacc">Associar na minha conta</label>
                    <button type="submit" class="btn btn-sm btn-primary ml-3">
                        <i class="fas fa-save"></i>
                        Responder e avançar
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // const agora = new Date();
        // const dataFinal = new Date(agora.getFullYear(), agora.getMonth(), agora.getDate(), agora.getHours(), agora.getMinutes() + 1).getTime();

        const dataFinal = new Date('{{ $questionList->datetime_limit }}').getTime();

        const intervalo = setInterval(() => {
            const agora = new Date().getTime();
            const distancia = dataFinal - agora;

            let dias = Math.floor(distancia / (1000 * 60 * 60 * 24));
            let horas = Math.floor((distancia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60));
            let segundos = Math.floor((distancia % (1000 * 60)) / 1000);

            minutos = Math.max(minutos, 0);
            segundos = Math.max(segundos, 0);

            // Adicionar zero à esquerda se minutos ou segundos forem menores que 10
            minutos = minutos < 10 ? '0' + minutos : minutos;
            segundos = segundos < 10 ? '0' + segundos : segundos;

            document.getElementById('countdown').innerHTML = `${minutos}m ${segundos}s`;

            if (minutos < 5) {
                if (!document.getElementById('countdown').classList.contains('bg-danger')) {
                    document.getElementById('countdown').classList.add('bg-danger');
                }
            }

            if (distancia <= 0) {

                clearInterval(intervalo);

                alert('Tempo esgotado! Redirecionando para página inicial...');

                window.location.href = "{{ route('reviews.index') }}";
            }
        }, 1000);
    </script>
@endpush
