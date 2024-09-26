<button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar" data-toggle="modal"
    data-target="#filterQuestionModal">
    @if ($filter)
        <i class="fas fa-spell-check"></i>
    @else
        <i class="fas fa-filter"></i>
    @endisset
</button>


<!-- Modal -->
<div class="modal fade" id="filterQuestionModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="">Filtrar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" id="filterQuestionForm" method="get">
                @include('questions.form_filter')
            </form>
        </div>
        <div class="modal-footer">
            @if ($filter)
                <a href="{{ route('questions.index') }}" class="btn btn-reset ml-1">Limpar filtro</a>
            @endif
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">
                Fechar
            </button>
            <button type="submit" class="btn btn-primary" form="filterQuestionForm">
                Filtrar
            </button>
        </div>
    </div>
</div>
</div>
