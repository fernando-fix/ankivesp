<!-- Modal -->
<div class="modal fade" id="editQuestionModal-{{ $question->id }}" tabindex="-1"
    aria-labelledby="editQuestionModalLabel-{{ $question->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuestionModalLabel-{{ $question->id }}">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('questions.update', $question) }}" id="editQuestionForm-{{ $question->id }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="modal_trigger" value="#editQuestionModal-{{ $question->id }}">
                    <input type="hidden" name="id" value="{{ $question->id }}">
                    @include('questions.form', ['question' => $question])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="location.reload()">Fechar</button>
                <button type="submit" class="btn btn-primary"
                    form="editQuestionForm-{{ $question->id }}">Alterar</button>
            </div>
        </div>
    </div>
</div>
