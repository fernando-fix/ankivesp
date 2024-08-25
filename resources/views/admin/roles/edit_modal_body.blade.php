<!-- Modal -->
<div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1"
    aria-labelledby="editRoleModalLabel-{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel-{{ $role->id }}">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.roles.update', $role) }}" id="editRoleForm-{{ $role->id }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="modal_trigger" value="#editRoleModal-{{ $role->id }}">
                    <input type="hidden" name="id" value="{{ $role->id }}">
                    @include('admin.roles.form', ['role' => $role])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Fechar</button>
                <button type="submit" class="btn btn-primary" form="editRoleForm-{{ $role->id }}">Alterar</button>
            </div>
        </div>
    </div>
</div>
