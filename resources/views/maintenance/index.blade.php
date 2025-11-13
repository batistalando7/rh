@extends('layouts.admin.layout')
@section('title', 'Manutenções')
@section('content')
<div class="card mb-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-tools me-2"></i>Registros de Manutenção</span>
        <div>
            <a href="{{ route('maintenance.pdfAll', request()->only(['startDate', 'endDate', 'type'])) }}" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-file-pdf"></i> Baixar PDF ({{ request()->filled('startDate') || request()->filled('endDate') || request()->filled('type') ? 'Filtrado' : 'Todos' }})
            </a>
            <a href="{{ route('maintenance.create') }}" class="btn btn-outline-light btn-sm" title="Novo Registro de Manutenção">
                Novo <i class="fas fa-plus-circle"></i>
            </a>
        </div>
    </div>
    <form method="GET" action="{{ route('maintenance.index') }}" class="row g-3 mb-4 p-3 bg-light">
        <div class="col-md-2">
            <div class="form-floating">
                <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                <label>Data Início</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating">
                <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                <label>Data Fim</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating">
                <select name="type" class="form-select">
                    <option value="">Todos Tipos</option>
                    <option value="Preventive" {{ request('type') == 'Preventive' ? 'selected' : '' }}>Preventiva</option>
                    <option value="Corrective" {{ request('type') == 'Corrective' ? 'selected' : '' }}>Corretiva</option>
                    <option value="Repair" {{ request('type') == 'Repair' ? 'selected' : '' }}>Reparo</option>
                </select>
                <label>Tipo</label>
            </div>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        @if(request()->hasAny(['startDate', 'endDate', 'type']))
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('maintenance.index') }}" class="btn btn-secondary w-100"><i class="fas fa-times"></i> Limpar</a>
            </div>
        @endif
    </form>
    <div class="card-body">
        @if (session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif
        <div class="table-responsive">
            <table id="datatablesSimple" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Tipo/Subtipo</th>
                        <th>Data</th>
                        <th>Quilometragem</th>
                        <th>Custo</th>
                        <th>Responsável</th>
                        <th>Próxima Data de Manutenção</th>
                        <th style="width: 58px;">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->vehicle->plate ?? '-' }} ({{ $r->vehicle->brand ?? '-' }})</td>
                            <td>{{ $r->type == 'Preventive' ? 'Preventiva' : ($r->type == 'Corrective' ? 'Corretiva' : 'Reparo') }} / {{ $r->subType ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->maintenanceDate)->format('d/m/Y') }}</td>
                            <td>{{ number_format($r->mileage ?? 0, 0, ',', '.') }} km</td>
                            <td>{{ number_format($r->cost ?? 0, 2, ',', '.') }} Kz</td>
                            <td>{{ $r->responsibleName ?? '-' }}</td>
                            <td>{{ $r->nextMaintenanceDate ? \Carbon\Carbon::parse($r->nextMaintenanceDate)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('maintenance.show', $r->id) }}" class="btn btn-warning btn-sm" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('maintenance.edit', $r->id) }}" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <a href="#" data-url="{{ route('maintenance.destroy', $r->id) }}" class="btn btn-danger btn-sm delete-btn" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection