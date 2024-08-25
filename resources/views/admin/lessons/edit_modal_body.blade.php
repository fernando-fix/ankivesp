<!-- Modal -->
<div class="modal fade" id="editLessonModal-{{ $lesson->id }}" tabindex="-1"
    aria-labelledby="editLessonModalLabel-{{ $lesson->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLessonModalLabel-{{ $lesson->id }}">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.lessons.update', $lesson) }}" id="editLessonForm-{{ $lesson->id }}"
                    method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="modal_trigger" value="#editLessonModal-{{ $lesson->id }}">
                    <input type="hidden" name="id" value="{{ $lesson->id }}">
                    @include('admin.lessons.form', ['lesson' => $lesson])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="location.reload()">Fechar</button>
                <button type="submit" class="btn btn-primary"
                    form="editLessonForm-{{ $lesson->id }}">Alterar</button>
            </div>
        </div>
    </div>
</div>
