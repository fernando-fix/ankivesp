@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Atualizações</h3>
                <div class="card-tools">
                    {{-- <button class="btn btn-sm btn-primary ml-1" title="Pesquisar/Filtrar">
                        <i class="fas fa-filter"></i>
                    </button> --}}
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Responsável</th>
                            <th scope="col">Mensagem/Alteração</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($updates as $update)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($update['commit']['committer']['date'] ?? '')->format('d/m/Y') ?? '' }}
                                </td>
                                <td>{{ $update['commit']['committer']['name'] ?? '' }}</td>
                                <td>{{ $update['commit']['message'] ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
