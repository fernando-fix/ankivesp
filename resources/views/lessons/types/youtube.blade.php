<div id="video-container" class="mb-2">
    <div id="video">
        <iframe src="https://www.youtube.com/embed/{{ $lesson->video_id }}" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
        </iframe>
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

    <!-- Botão para mostrar as perguntas -->
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"
            title="Mais Opções">
            <i class="fas fa-question"></i>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" target="_blank"
                    href="{{ route('questions.index', ['course_id' => $lesson->course->id]) }}" role="button">
                    <i class="fas fa-question-circle text-primary"></i>
                    Ver questões deste curso
                    <span class="badge badge-primary ml-1">
                        {{ count($lesson->course->questions) }}
                    </span>
                </a>
                <a class="dropdown-item" target="_blank"
                    href="{{ route('questions.index', ['lesson_id' => $lesson->id]) }}" role="button">
                    <i class="fas fa-question-circle text-primary"></i>
                    Ver questões desta aula
                    <span class="badge badge-primary ml-1">
                        {{ count($lesson->questions) }}
                    </span>
                </a>
                <form action="{{ route('reviews.by-lesson', $lesson->id) }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-play-circle text-primary"></i>
                        Praticar questões desta aula
                        <span class="badge badge-primary ml-1">
                            {{ count($lesson->questions) }}
                        </span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

@push('css')
    <style>
        #video-container {
            width: 900px;
        }

        #video {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
        }

        #video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        @media screen and (max-width: 1240px) {
            #video-container {
                width: 100%;
            }
        }

        @media screen and (max-height: 700px) {
            #video-container {
                max-width: 750px;
            }
        }
    </style>
@endpush
