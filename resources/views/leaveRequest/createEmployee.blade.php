@extends('layouts.admin.layout')
@section('title', 'Novo Pedido de Licença')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mb-4 shadow">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-file-alt me-2"></i>Novo Pedido de Licença</span>
                    <a href="{{ route('leaveRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">
                    <!-- Dados do Funcionário -->
                    <h5 class="mb-2">Seus Dados:</h5>
                    <p class="mb-1"><strong>Nome:</strong> {{ $employee->fullName }}</p>
                    <p class="mb-1"><strong>Departamento:</strong> {{ $employee->department->title ?? '-' }}</p>
                    <hr>
                    <form method="POST" action="{{ route('leaveRequest.store') }}">
                        @csrf
                        <input type="hidden" name="employeeId" value="{{ $employee->id }}">
                        <input type="hidden" name="departmentId" value="{{ $employee->department->id ?? '' }}">
                        <div class="mb-3">
                            <div class="form-floating">
                                <select name="leaveTypeId" id="leaveTypeId" class="form-select" required>
                                    <option value="">-- Selecione o Tipo de Licença --</option>
                                    @foreach ($leaveTypes as $lt)
                                        <option value="{{ $lt->id }}"
                                            {{ old('leaveTypeId') == $lt->id ? 'selected' : '' }}>
                                            {{ $lt->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="leaveTypeId">Tipo de Licença</label>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" name="leaveStart" id="leaveStart" class="form-control"
                                        value="{{ old('leaveStart') }}" required>
                                    <label for="leaveStart">Data de Início</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" name="leaveEnd" id="leaveEnd" class="form-control"
                                        value="{{ old('leaveEnd') }}" required>
                                    <label for="leaveEnd">Data de Término</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2">
                            <div class="form-floating">
                                <textarea name="reason" id="reason" placeholder="" style="height: 100px;" class="form-control">{{ old('reason') }}</textarea>
                                <label for="reason">Razão</label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" style="width: auto;">
                                <i class="fas fa-check-circle"></i> Enviar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
