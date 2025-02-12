<!-- Modal -->
<div class="modal fade" id="editConfigModal-{{ $config->id }}" tabindex="-1"
    aria-labelledby="editConfigModalLabel-{{ $config->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editConfigModalLabel-{{ $config->id }}">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.configs.update', $config) }}" id="editConfigForm-{{ $config->id }}"
                    method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="modal_trigger" value="#editConfigModal-{{ $config->id }}">
                    <input type="hidden" name="id" value="{{ $config->id }}">
                    @include('admin.configs.form', ['config' => $config])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="location.reload()">Fechar</button>
                <button type="submit" class="btn btn-primary"
                    form="editConfigForm-{{ $config->id }}">Alterar</button>
            </div>
        </div>
    </div>
</div>
