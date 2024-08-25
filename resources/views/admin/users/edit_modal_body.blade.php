<!-- Modal -->
<div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
    aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.update', $user) }}" id="editUserForm-{{ $user->id }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="modal_trigger" value="#editUserModal-{{ $user->id }}">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    @include('admin.users.form', ['user' => $user])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Fechar</button>
                <button type="submit" class="btn btn-primary" form="editUserForm-{{ $user->id }}">Alterar</button>
            </div>
        </div>
    </div>
</div>
