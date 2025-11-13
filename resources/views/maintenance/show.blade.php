@extends('layouts.admin.layout')
@section('title', 'Ver Manutenção')
@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-8">
            <h3><i class="fas fa-tools me-2"></i>Ver Manutenção #{{ $maintenance->id }}</h3>
        </div>
        <div class="col-4 text-end">
            <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <a href="{{ route('maintenance.showPdf', $maintenance->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                <i class="fas fa-download"></i> Baixar PDF
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white text-center">
                    <strong>Detalhes da Manutenção</strong>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr><th class="ps-0">Viatura</th><td>{{ $maintenance->vehicle->plate ?? '-' }} – {{ $maintenance->vehicle->brand ?? '-' }} {{ $maintenance->vehicle->model ?? '-' }}</td></tr>
                            <tr><th class="ps-0">Tipo/Subtipo</th><td>{{ $maintenance->type == 'Preventive' ? 'Preventiva' : ($maintenance->type == 'Corrective' ? 'Corretiva' : 'Reparo') }} / {{ $maintenance->subType ?? '-' }}</td></tr>
                            <tr><th class="ps-0">Data</th><td>{{ \Carbon\Carbon::parse($maintenance->maintenanceDate)->format('d/m/Y') }}</td></tr>
                            <tr><th class="ps-0">Quilometragem Atual</th><td>{{ number_format($maintenance->mileage ?? 0, 0, ',', '.') }} km</td></tr>
                            <tr><th class="ps-0">Custo</th><td>{{ number_format($maintenance->cost ?? 0, 2, ',', '.') }} Kz</td></tr>
                            <tr><th class="ps-0">Descrição</th><td>{{ $maintenance->description ?? '-' }}</td></tr>
                            <tr><th class="ps-0">Peças Substituídas</th><td>{{ $maintenance->piecesReplaced ?? '-' }}</td></tr>
                            <tr><th class="ps-0">Serviços Realizados</th><td>
                                @if($maintenance->services && is_array($maintenance->services))
                                    <ul class="mb-0">
                                        @foreach($maintenance->services as $s => $det)
                                            @if($s == 'outros')
                                                <li><strong>Outros Detalhes:</strong> {{ $det['outros_details'] ?? $det ?? '' }}</li>
                                            @else
                                                <li><strong>{{ ucfirst(str_replace('_', ' ', $s)) }}:</strong>
                                                    @if(is_array($det))
                                                        @foreach($det as $k => $v)
                                                            {{ ucfirst(str_replace('_', ' ', $k)) }}: {{ $v }} 
                                                        @endforeach
                                                    @else
                                                        {{ $det }}
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    -
                                @endif
                            </td></tr>
                            <tr><th class="ps-0">Próxima Manutenção</th><td>Data: {{ $maintenance->nextMaintenanceDate ? \Carbon\Carbon::parse($maintenance->nextMaintenanceDate)->format('d/m/Y') : '-' }} | Km: {{ number_format($maintenance->nextMileage ?? 0, 0, ',', '.') }}</td></tr>
                            <tr><th class="ps-0">Responsável</th><td>{{ $maintenance->responsibleName ?? '-' }}<br>Telefone: {{ $maintenance->responsiblePhone ?? '-' }} | Email: {{ $maintenance->responsibleEmail ?? '-' }}</td></tr>
                            <tr><th class="ps-0">Observações</th><td>{{ $maintenance->observations ?? '-' }}</td></tr>
                            @if($maintenance->invoice_pre)
                                <tr><th class="ps-0">Fatura Prévia</th><td><a href="{{ asset('frontend/docs/maintenance/pre/' . $maintenance->invoice_pre) }}" target="_blank">Ver/Download</a></td></tr>
                            @endif
                            @if($maintenance->invoice_post)
                                <tr><th class="ps-0">Fatura Concluída</th><td><a href="{{ asset('frontend/docs/maintenance/post/' . $maintenance->invoice_post) }}" target="_blank">Ver/Download</a></td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection