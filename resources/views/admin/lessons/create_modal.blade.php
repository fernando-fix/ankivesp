<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary ml-1" data-toggle="modal" data-target="#createLessonModal"
    title="Adicionar/Cadastrar">
    <i class="fas fa-plus"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="createLessonModal" tabindex="-1" aria-labelledby="createLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLessonModalLabel">Cadastrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.lessons.store') }}" id="createLessonForm" method="post">
                    @csrf
                    <input type="hidden" name="modal_trigger" value="#createLessonModal">
                    @include('admin.lessons.form')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="createLessonForm">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
