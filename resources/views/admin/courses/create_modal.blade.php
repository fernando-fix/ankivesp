<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary ml-1" data-toggle="modal" data-target="#createCourseModal"
    title="Adicionar/Cadastrar">
    <i class="fas fa-plus"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCourseModalLabel">Cadastrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.courses.store') }}" id="createCourseForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="modal_trigger" value="#createCourseModal">
                    @include('admin.courses.form')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="createCourseForm">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
