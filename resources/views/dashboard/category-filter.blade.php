@extends('layouts.admin.layout')

@section('title', 'Filtro por Categoria')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Funcionários - Categoria: {{ $categoryId }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Filtro por Categoria</li>
    </ol>

    @if($academicLevel)
        <h4>Nível Acadêmico: {{ $academicLevel }}</h4>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Lista de Funcionários</h5>
        </div>
        <div class="card-body">
            @if($employees->isEmpty())
                <p>Nenhum funcionário encontrado para esta categoria e nível acadêmico.</p>
            @else
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Nível Acadêmico</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->fullName }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->academicLevel }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection