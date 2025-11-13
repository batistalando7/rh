@extends('layouts.admin.layout')
@section('title', 'Novo Destacamento')
@section('content')

    <div class="card my-4 shadow">
        <div class="card-header bg-secondary text-white">
            <span><i class="fas fa-id-badge me-2"></i>Novo Destacamento</span>
            <a href="{{ route('secondment.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
        <div class="card-body">
            <!-- Formulário para buscar funcionário por ID ou Nome -->
            <form action="{{ route('secondment.searchEmployee') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-floating">
                            <input type="text" name="employeeSearch" id="employeeSearch" class="form-control"
                                placeholder="" value="{{ old('employeeSearch') }}">
                            <label for="employeeSearch">ID ou Nome do Funcionário</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100 mt-0">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>

            @isset($employee)
                <hr>
                <form action="{{ route('secondment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- ID do Funcionário-->
                    <input type="hidden" name="employeeId" value="{{ $employee->id }}">

                    <div class="container">
                        <!-- Linha 1: Informações do Funcionário -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" class="form-control"
                                            value="{{ $employee->fullName }}" readonly>
                                        <label for="text">Nome do Funcionário</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" class="form-control"
                                            value="{{ $employee->department->title ?? '-' }}" readonly>
                                        <label for="text">Departamento</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Linha 2: Instituição e Documento de Suporte -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="institution" id="institution" class="form-control"
                                        placeholder="" value="{{ old('institution') }}" required>
                                    <label for="institution">Instituição</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="file" name="supportDocument" class="form-control"
                                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        <label class="form-label">Documento de Suporte</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Linha 3: Causa da Transferência -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <textarea name="causeOfTransfer" placeholder="" style="height: 100px;" class="form-control">{{ old('causeOfTransfer') }}</textarea>
                                            <label for="causeOfTransfer">Causa da Transferência</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check-circle"></i> Salvar Destacamento
                                    </button>
                                </div>
                            </div>
                        </div>
                </form>
            @endisset

        </div>
    </div>

@endsection
