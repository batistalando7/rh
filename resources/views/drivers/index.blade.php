@extends('layouts.admin.layout')
@section('title', 'Motoristas')
@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-person-badge-fill me-2"></i>Todos os Motoristas</span>
            <div>
                <a href="{{ route('drivers.pdfAll', request()->only('startDate', 'endDate')) }}"
                    class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-file-pdf"></i>
                    Baixar PDF ({{ request()->filled('startDate') || request()->filled('endDate') ? 'Filtrado' : 'Todos' }})
                </a>
                <a href="{{ route('drivers.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo Motorista">
                    Novo <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('drivers.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                    <label class="form-label">Data Início</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                    <label class="form-label">Data Fim</label>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
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
                            <th>Nome</th>
                            <th>B.I.</th>
                            <th>Nº Carta</th>
                            <th>Categoria</th>
                            <th>Validade</th>
                            <th>Status</th>
                            <th style="width: 58px;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drivers as $d)
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td>{{ $d->employee ? $d->employee->fullName : $d->fullName }}</td>
                                <td>{{ $d->bi ?? '-' }}</td>
                                <td>{{ $d->licenseNumber }}</td>
                                <td>{{ optional($d->licenseCategory)->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($d->licenseExpiry)->format('d/m/Y') }}</td>
                                <td>{{ $d->status == 'Active' ? 'Ativo' : 'Inativo' }}</td>
                                <td>
                                    <a href="{{ route('drivers.show', $d->id) }}" class="btn btn-warning btn-sm"
                                        title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('drivers.edit', $d->id) }}" class="btn btn-info btn-sm"
                                        title="Editar">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <a href="#" data-url="{{ route('drivers.destroy', $d->id) }}"
                                        class="btn btn-danger btn-sm delete-btn" title="Excluir">
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