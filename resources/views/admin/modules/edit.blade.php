@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Editar Módulo - {{ $module->name }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.modules.index') }}" class="btn btn-sm btn-primary ml-1" title="Voltar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">

                <form action="{{ route('admin.modules.update', $module) }}" method="post">
                    @csrf
                    @method('PUT')

                    @include('admin.modules.form')

                    <button type="submit" class="btn btn-sm btn-primary ml-1" title="Salvar">
                        <i class="fas fa-save"></i>
                        Atualizar
                    </button>

                </form>

                <div class="card card-outline card-info mt-2">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i>
                            Aulas
                        </h3>
                        <div class="card-tools">
                            @can('cadastrar_aulas')
                                @include('admin.modules.lessons.create_modal')
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-sm table-hover table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Posição</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Questões</th>
                                    <th scope="col" width=1>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-table" data-route="{{ secure_url(route('admin.lessons.reorder', $module)) }}">
                                @forelse ($lessons as $lesson)
                                    <tr class="sortable-item" data-id="{{ $lesson->id }}" style="cursor: move;">
                                        <td class="align-middle">
                                            <i class="fas fa-arrows-alt"></i>
                                        </td>
                                        <td class="align-middle">{{ $lesson->name }}</td>
                                        <td class="align-middle">{{ $lesson->questions_count }}</td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            @canany(['excluir_aulas', 'editar_aulas'])
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" title="Mais Opções">
                                                        <i class="fas fa-bars"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        @can('editar_aulas')
                                                            <li>
                                                                @include(
                                                                    'admin.lessons.edit_modal_trigger',
                                                                    $lesson)
                                                            </li>
                                                        @endcan
                                                        @can('excluir_aulas')
                                                            <li>
                                                                <form action="{{ route('admin.lessons.destroy', $lesson) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item" href="#"
                                                                        title="Excluir"
                                                                        onclick="return confirm('Deseja realmente excluir este registro?');">
                                                                        <i class="fas fa-trash text-danger"></i>
                                                                        Excluir
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            @endcanany
                                        </td>
                                        @can('editar_modulos')
                                            @include('admin.lessons.edit_modal_body', $lesson)
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="align-middle" colspan="100%" class="text-center">Nenhum registro
                                            encontrado</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        new Sortable(document.getElementById('sortable-table'), {
            animation: 150,
            onSort: function(evt) {
                const ids = Array.from(document.querySelectorAll('.sortable-item'))
                    .map(item => item.getAttribute('data-id'));
                const route = document.getElementById('sortable-table').getAttribute('data-route');
                fetch(route, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ids
                    })
                }).then(result => result.json()).then(data => {
                    if (data.success) {
                        // location.reload();
                    } else {
                        console.error(data.message);
                    }
                });
            }
        });
    </script>
@endpush

@push('js')
    <script>
        $('.modal').on('shown.bs.modal', function() {
            var modal = $(this);
            modal.find('#course_id').on('change', function() {
                let course_id = $(this).val();
                let url = "/admin/json/modules/:course_id";
                url = url.replace(':course_id', course_id);

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        course_id: course_id
                    },
                    success: function(response) {
                        modal.find('#module_id').empty();
                        // se a resposta for vazia
                        if (response.length > 0) {
                            modal.find('#module_id').append(
                                '<option value="">Selecione</option>');
                            response.forEach(element => {
                                modal.find('#module_id').append('<option value="' +
                                    element
                                    .id + '">' + element
                                    .name + '</option>');
                            })
                        } else {
                            modal.find('#module_id').append(
                                '<option value="">Cadastre um módulo para este curso</option>'
                            );
                        }
                    }
                });
            });
        });
    </script>
@endpush
