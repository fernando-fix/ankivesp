@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Papéis</h3>
                <div class="card-tools">

                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <div class="d-flex justify-content-between">
                    <div>
                        <b>Usuário:</b> {{ $user->name }}
                    </div>
                    <div>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary ml-1" title="Voltar">
                            <i class="fas fa-arrow-left"></i>
                            Voltar
                        </a>
                        <button class="btn btn-sm btn-primary ml-1" form="updateRolesForm">
                            <i class="fas fa-sync-alt"></i>
                            Atualizar papéis
                        </button>
                    </div>
                </div>
                <hr>

                <form action="{{ route('admin.users.update_roles', $user->id) }}" method="post" id="updateRolesForm">

                    @csrf

                    @method('put')

                    @foreach ($roles as $role)
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                    @checked(
                                        (old('roles') && in_array($role->id, old('roles'))) ||
                                            (!old('roles') && in_array($role->id, $user->roles->pluck('id')->toArray())))>
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach

                </form>
            </div>
        </div>
    </div>
@endsection

@if ($errors->any() && old('modal_trigger'))
    @push('js')
        <script>
            // Reabre o modal
            $(document).ready(function() {
                function reopenModal() {
                    $('{{ old('modal_trigger') }}').modal('show');
                }
                reopenModal();
            });

            // Recarrega a página caso o modal feche
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                $(modal).on('hidden.bs.modal', function(e) {
                    location.reload();
                })
            })
        </script>
    @endpush
@endif
