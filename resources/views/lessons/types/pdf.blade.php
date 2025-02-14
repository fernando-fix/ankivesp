<div id="pdf-container" class="mb-2">
    <div id="pdf">
        <object data="{{ asset('storage/' . $lesson->pdf->file_path) }}" type="application/pdf" width="100%" height="600">
            <p>Your web browser doesn't have a PDF plugin. Instead you can <a href="{{ asset('storage/' . $lesson->pdf->file_path) }}">click here to download the PDF file.</a></p>
        </object>

    </div>
</div>
<div>
    <!-- Botão Anterior -->
    <a href="{{ isset($previousLesson) ? route('lessons.show', $previousLesson) : '#' }}"
        class="btn btn-sm {{ isset($previousLesson) ? 'btn-primary' : 'btn-secondary' }}" style="width:35px"
        title="Anterior">
        <i class="fas fa-backward"></i>
    </a>

    <!-- Botão Próximo -->
    <a href="{{ isset($nextLesson) ? route('lessons.show', $nextLesson) : '#' }}"
        class="btn btn-sm {{ isset($nextLesson) ? 'btn-primary' : 'btn-secondary' }}" style="width:35px"
        title="Próximo">
        <i class="fas fa-forward"></i>
    </a>

    <!-- Botão Marcar como Visto -->
    @if ($watchedLesson)
        <a href="{{ route('markUnWatched', $lesson) }}" class="btn btn-sm btn-primary" style="width:35px"
            title="Marcar como não visto">
            <i class="fas fa-eye"></i>
        </a>
    @else
        <a href="{{ route('markWatched', $lesson) }}" class="btn btn-sm btn-secondary" style="width:35px"
            title="Marcar como visto">
            <i class="fas fa-eye"></i>
        </a>
    @endif

    <!-- Botão para mostrar as aulas -->
    @include('lessons.lessons_modal')

    {{-- Botão para gerar perguntas --}}
    @can('gerar_perguntas')
        @if ($lesson->questions->count() == 0 && $lesson->transcription)
            <form action="{{ route('generate-questions', $lesson->id) }}" method="post" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary" style="width:35px" title="Gerar perguntas">
                    <i class="fas fa-robot"></i>
                </button>
            </form>
        @endif
    @endcan

    @if ($lesson->course->questions->count() > 0 || count($lesson->questions) > 0)

        <!-- Botão para mostrar as perguntas -->
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"
                title="Mais Opções">
                <i class="fas fa-question"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    @if ($lesson->course->questions->count() > 0)
                        <a class="dropdown-item" target="_blank"
                            href="{{ route('questions.index', ['course_id' => $lesson->course->id]) }}" role="button">
                            <i class="fas fa-question-circle text-primary"></i>
                            Ver questões deste curso
                            <span class="badge badge-primary ml-1">
                                {{ count($lesson->course->questions) }}
                            </span>
                        </a>
                    @endif
                    @if (count($lesson->questions) > 0)
                        <a class="dropdown-item" target="_blank"
                            href="{{ route('questions.index', ['lesson_id' => $lesson->id]) }}" role="button">
                            <i class="fas fa-question-circle text-primary"></i>
                            Ver questões desta aula
                            <span class="badge badge-primary ml-1">
                                {{ count($lesson->questions) }}
                            </span>
                        </a>
                    @endif
                    @if (count($lesson->questions) > 0)
                        <form action="{{ route('reviews.by-lesson', $lesson->id) }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-play-circle text-primary"></i>
                                Praticar questões desta aula e marcar como vista
                                <span class="badge badge-primary ml-1">
                                    {{ count($lesson->questions) }}
                                </span>
                            </button>
                        </form>
                    @endif
                </li>
            </ul>
        </div>

    @endif
</div>
