@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Minhas revisões</h3>
                <div class="card-tools">
                    @include('question_lists.create_modal')
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Total de perguntas</th>
                            <th scope="col">Total de acertos</th>
                            <th scope="col">Acertos (%)</th>
                            <th scope="col">Prazo</th>
                            <th scope="col">Status</th>
                            <th scope="col" width=1>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questionLists as $questionList)
                            <tr>
                                <td class="align-middle">{{ $questionList->id }}</td>
                                <td class="align-middle">
                                    @if ($questionList->type == 'review')
                                        Revisão
                                    @elseif($questionList->type == 'simulation')
                                        Simulado
                                    @endif
                                </td>
                                <td class="align-middle">{{ $questionList->count_total }}</td>
                                <td class="align-middle">{{ $questionList->count_correct }}</td>
                                <td class="align-middle">
                                    @if ($questionList->count_total > 0)
                                        {{ number_format(($questionList->count_correct / $questionList->count_total) * 100, 2) }}
                                        %
                                    @else
                                        0 %
                                    @endif
                                </td>
                                <td class="align-middle">{{ date('d/m/Y H:i:s', strtotime($questionList->datetime_limit)) }}
                                </td>
                                <td class="align-middle">
                                    @if ($questionList->finished == 1)
                                        Respondida
                                    @elseif ($questionList->finished == 0 && $questionList->datetime_limit > now())
                                        Em andamento
                                    @elseif ($questionList->finished == 0 && $questionList->datetime_limit < now())
                                        Cancelada
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                            data-toggle="dropdown" title="Mais Opções">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('reviews.show', $questionList) }}">
                                                    <i class="fas fa-eye text-info"></i>
                                                    Visualizar
                                                </a>
                                            </li>
                                            @if ($questionList->finished == 0 && $questionList->datetime_limit > now())
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('reviews.first-question', $questionList) }}">
                                                        <i class="fas fa-play text-success"></i>
                                                        Continuar revisão
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-1">
                    {{ $questionLists->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
