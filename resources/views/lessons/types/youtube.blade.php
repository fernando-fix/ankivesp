<div id="video" class="">
    <iframe src="{{ $lesson->url }}" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
    </iframe>
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
    <a href="#" class="btn btn-sm btn-secondary" style="width:35px" title="Marcar como visto">
        <i class="fas fa-eye"></i>
    </a>

    <!-- Botão para mostrar as aulas -->
    @include('lessons.lessons_modal')

    <!-- Botão para mostrar as perguntas -->
    <a href="#" class="btn btn-sm btn-primary" style="width:35px" title="Mostrar perguntas">
        <i class="fas fa-question"></i>
    </a>
</div>

@push('css')
    <style>
        #video iframe {
            width: 900px;
            height: 600px;
        }

        @media screen and (max-width: 1200px) {
            #video iframe {
                width: 100%;
                height: calc(100vw * 0.5625);
            }
        }
    </style>
@endpush
