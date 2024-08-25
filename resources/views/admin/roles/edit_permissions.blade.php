@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Associar permissões
                </h3>
                <div class="card-tools">

                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <div class="d-flex justify-content-between">
                    <div>
                        <b>Papel:</b> {{ $role->name }}
                    </div>
                    <div>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-primary ml-1" title="Voltar">
                            <i class="fas fa-arrow-left"></i>
                            Voltar
                        </a>
                        <button class="btn btn-sm btn-primary ml-1" form="updatePermissionsForm">
                            <i class="fas fa-sync-alt"></i>
                            Atualizar permissões
                        </button>
                    </div>
                </div>
                <hr>

                <form action="{{ route('admin.roles.update_permissions', $role->id) }}" method="post" id="updatePermissionsForm">

                    @csrf

                    @method('put')

                    @foreach ($permissions as $permission)
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    @checked(
                                        (old('permissions') && in_array($permission->id, old('permissions'))) ||
                                            (!old('permissions') && in_array($permission->id, $role->permissions->pluck('id')->toArray())))>
                                {{ $permission->name }}
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
