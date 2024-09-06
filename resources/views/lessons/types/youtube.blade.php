<div id="video-container" class="mb-2">
    <div id="video">
        <iframe src="{{ $lesson->url }}" frameborder="0"
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
    <a href="#" class="btn btn-sm btn-primary" style="width:35px" title="Mostrar perguntas">
        <i class="fas fa-question"></i>
    </a>
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
