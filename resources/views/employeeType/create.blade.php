@extends('layouts.admin.layout')
@section('title', 'Novo Tipo de Funcionário')
@section('content')

    <div class="card my-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-plus-circle me-2"></i>Novo Tipo de Funcionário</span>
            <a href="{{ route('employeeType.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
                <i class="fa-solid fa-list"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('employeeType.store') }}">
                        @csrf

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="" required>
                                <label for="name">Nome do Tipo de Funcionário</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="description" id="description" class="form-control" style="height: 100px;" placeholder="">{{ old('description') }}</textarea>
                                <label for="description">Descrição (opcional)</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
