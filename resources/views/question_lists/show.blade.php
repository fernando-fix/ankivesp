@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Questionário - {{ date('d/m/Y', strtotime($questionList->created_at)) }}</h3>
                <div class="card-tools">
                    {{-- botão voltar --}}
                    <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-primary ml-1" title="Voltar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                <table class="table table-sm table-hover table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Perguntas</th>
                            <th scope="col">Respostas</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($questionList) --}}

                        @forelse ($questionList->questionListItems as $key => $questionListItem)
                            <tr>
                                <td>{{ $questionListItem->id }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div>
                                            <span class="mr-2 badge badge-primary">{{ $key + 1 }}
                                            </span>
                                        </div>
                                        {!! $questionListItem->question->question !!}
                                    </div>
                                </td>
                                <td>
                                    @forelse ($questionListItem->question->answers as $key => $answer)
                                        {!! $key == 0 ? '' : '<hr class="m-0">' !!}
                                        <div class="d-flex">
                                            <div>
                                                @if ($questionList->finished)
                                                    @if ($answer->id == $questionListItem->question->correctAnswer()->id)
                                                        <span class="mr-2 badge badge-success">{{ $key + 1 }} </span>
                                                    @else
                                                        @if ($answer->id == $questionListItem->answer_id)
                                                        <span class="mr-2 badge badge-danger">{{ $key + 1 }}
                                                        </span>
                                                        @else
                                                        <span class="mr-2 badge badge-secondary">{{ $key + 1 }}
                                                        </span>
                                                        @endif
                                                    @endif
                                                @else
                                                    <span class="mr-2 badge badge-primary">{{ $key + 1 }} </span>
                                                @endif
                                            </div>
                                            {!! $answer->answer !!}
                                        </div>
                                    @empty
                                        <span class="text-danger">Nenhuma resposta encontrada</span>
                                    @endforelse
                                </td>
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
