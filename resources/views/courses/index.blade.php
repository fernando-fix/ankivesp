@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Cursos
                </h3>
                <div class="card-tools">
                    {{-- botões --}}
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">

                <div class="d-flex justify-content-around flex-wrap">

                    @foreach ($courses as $course)
                        @if ($course->lessons->count() > 0)
                            {{-- add hover --}}
                            <div class="card mx-1 shadow" style="width: 350px;">
                                <div class="p-2">
                                    <a href="{{ route('lessons.last-watched') }}">
                                        <img class="card-img-top rounded"
                                            src="https://picsum.photos/id/{{ $course->id }}/300/200/"
                                            alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-graduation-cap"></i>
                                        {{ $course->name }}
                                    </h5>
                                    <p class="card-text">
                                        <hr>
                                        Módulos: {{ $course->modules_count }}
                                        <br>
                                        Aulas: {{ $course->modules->sum('lessons_count') }}
                                    </p>
                                    <a href="{{ route('lessons.last-watched') }}" class="btn btn-primary">
                                        Acessar
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
