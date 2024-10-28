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
                                    <a href="{{ route('lessons.last-watched', $course->id) }}">
                                        @if ($course->image)
                                            <img class="card-img-top rounded" style="height: 222px; width: 334px"
                                                src="{{ asset('storage/' . $course->image->file_path) }}"
                                                alt="Card image cap">
                                        @else
                                            <img class="card-img-top rounded" style="height: 222px; width: 334px"
                                                src="https://picsum.photos/id/{{ $course->id }}/334/222"
                                                alt="Card image cap">
                                        @endif
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column justify-content-between h-100">
                                        <h5 class="card-title">
                                            <i class="fas fa-graduation-cap"></i>
                                            {{ $course->name }}
                                        </h5>
                                        <p class="card-text">
                                            <hr>
                                            Módulos: {{ $course->modules_count }}
                                            <br>
                                            Aulas assistidas: {{ $course->countWatchedLesssons() }} /
                                            {{ $course->modules->sum('lessons_count') }}
                                        </p>

                                        @if ($course->modules->sum('lessons_count') > 0)
                                            <div class="progress my-2 rounded">
                                                <div class="progress-bar" role="progressbar"
                                                    aria-valuenow="{{ ($course->countWatchedLesssons() / $course->modules->sum('lessons_count')) * 100 }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: {{ ($course->countWatchedLesssons() / $course->modules->sum('lessons_count')) * 100 }}%">
                                                    @if ($course->modules->sum('lessons_count') > 0)
                                                        {{ number_format(($course->countWatchedLesssons() / $course->modules->sum('lessons_count')) * 100, 2) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="progress my-2 rounded">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="0"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-2">
                                            <a href="{{ route('lessons.last-watched', $course->id) }}"
                                                class="btn btn-sm btn-primary">
                                                Acessar
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
