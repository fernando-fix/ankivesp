@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    {{ $lesson->course->name }} / {{ $lesson->module->name }} / {{ $lesson->name }}
                </h3>
                <div class="card-tools">
                    {{-- botões --}}
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">

                @if ($lesson->type == 'youtube')
                    @include('lessons.types.youtube')
                @elseif($lesson->type == 'pdf')
                    @include('lessons.types.pdf')
                @elseif($lesson->type == 'link')
                    @include('lessons.types.link')
                @endif

            </div>
        </div>
    </div>
@endsection
