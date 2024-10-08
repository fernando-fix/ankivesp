@extends('adminlte::page')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Home
                </h3>
                <div class="card-tools">
                    {{-- botões --}}
                </div>
            </div>
            <div class="card-body" style="height: calc(100vh - 160px); overflow-y: auto">
                {{-- conteúdo --}}
                <h1>Bem vindo à plataforma Ankivesp</h1>
                <hr>
                <p>Plataforma desenvolvida para apoiar o aprendizado da Universidade Univesp</p>
                <hr>
                <p>Utilize o menu lateral para navegar dentre as opções</p>
            </div>
        </div>
    </div>
@endsection
