<!-- Modal -->
<div class="modal fade" id="editCourseModal-{{ $course->id }}" tabindex="-1"
    aria-labelledby="editCourseModalLabel-{{ $course->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel-{{ $course->id }}">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('courses.update', $course) }}" id="editCourseForm-{{ $course->id }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="modal_trigger" value="#editCourseModal-{{ $course->id }}">
                    <input type="hidden" name="id" value="{{ $course->id }}">
                    @include('courses.form', ['course' => $course])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Fechar</button>
                <button type="submit" class="btn btn-primary" form="editCourseForm-{{ $course->id }}">Alterar</button>
            </div>
        </div>
    </div>
</div>
