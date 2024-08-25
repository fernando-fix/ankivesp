<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary ml-1" data-toggle="modal" data-target="#createUserModal"
    title="Adicionar/Cadastrar">
    <i class="fas fa-plus"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Cadastrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.store') }}" id="createUserForm" method="post">
                    @csrf
                    <input type="hidden" name="modal_trigger" value="#createUserModal">
                    @include('admin.users.form')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="createUserForm">Cadastrar</button>
            </div>
        </div>
    </div>
</div>


