@extends('layouts.admin.layout')
@section('title', 'Editar Viatura')
@section('content')
<div class="card my-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-truck me-2"></i>Editar Viatura #{{ $vehicle->id }}</span>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-list"></i>
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="plate" id="plate" class="form-control" maxlength="12" placeholder="" value="{{ old('plate', $vehicle->plate) }}" required>
                        <label for="plate">Matrícula</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="brand" id="brand" class="form-control" placeholder="" value="{{ old('brand', $vehicle->brand) }}" required>
                        <label for="brand">Marca</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="model" id="model" class="form-control" placeholder="" value="{{ old('model', $vehicle->model) }}" required>
                        <label for="model">Modelo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" name="yearManufacture" id="yearManufacture" class="form-control" placeholder="" value="{{ old('yearManufacture', $vehicle->yearManufacture) }}" required min="1900" max="{{ date('Y') }}">
                        <label for="yearManufacture">Ano</label>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="color" id="color" class="form-control" placeholder="" value="{{ old('color', $vehicle->color) }}" required>
                        <label for="color">Cor</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" name="loadCapacity" id="loadCapacity" class="form-control" placeholder="" value="{{ old('loadCapacity', $vehicle->loadCapacity) }}" required min="1">
                        <label for="loadCapacity">Total de Lugares</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="status" id="status" class="form-select">
                            <option value="Available" {{ old('status', $vehicle->status) == 'Available' ? 'selected' : '' }}>Disponível</option>
                            <option value="UnderMaintenance" {{ old('status', $vehicle->status) == 'UnderMaintenance' ? 'selected' : '' }}>Em Manutenção</option>
                            <option value="Unavailable" {{ old('status', $vehicle->status) == 'Unavailable' ? 'selected' : '' }}>Indisponível</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="driverId" id="driverId" class="form-select">
                            <option value="">Sem Motorista</option>
                            @foreach($drivers as $d)
                                <option value="{{ $d->id }}" {{ old('driverId', $vehicle->drivers->first()->id ?? '') == $d->id ? 'selected' : '' }}>{{ $d->fullName }}</option>
                            @endforeach
                        </select>
                        <label for="driverId">Atribuir Motorista</label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-floating">
                        <textarea name="notes" id="notes" class="form-control" placeholder="" style="height:80px">{{ old('notes', $vehicle->notes) }}</textarea>
                        <label for="notes">Observações</label>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-check-circle me-2"></i>Atualizar Viatura
                </button>
            </div>
        </form>
    </div>
</div>
@endsection