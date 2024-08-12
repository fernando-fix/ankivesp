<!-- Modal -->
<div class="modal fade" id="editModuleModal-{{ $module->id }}" tabindex="-1"
    aria-labelledby="editModuleModalLabel-{{ $module->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModuleModalLabel-{{ $module->id }}">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('modules.update', $module) }}" id="editModuleForm-{{ $module->id }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="modal_trigger" value="#editModuleModal-{{ $module->id }}">
                    <input type="hidden" name="id" value="{{ $module->id }}">
                    @include('modules.form', ['module' => $module])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Fechar</button>
                <button type="submit" class="btn btn-primary" form="editModuleForm-{{ $module->id }}">Alterar</button>
            </div>
        </div>
    </div>
</div>
