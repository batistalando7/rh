@extends('layouts.admin.pdf')
@section('pdfTitle', "Manutenção #{$maintenance->id}")
@section('titleSection')
<style>
@page { margin: 1.5in; }
table { width: 100%; font-size: 10pt; }
th, td { padding: 5pt; border: 1px solid #ddd; }
</style>
<h4>Detalhes da Manutenção</h4>
@endsection
@section('contentTable')
<table>
    <tbody>
        <tr><th>Viatura</th><td>{{ $maintenance->vehicle->plate ?? '-' }} ({{ $maintenance->vehicle->brand ?? '-' }} {{ $maintenance->vehicle->model ?? '-' }})</td></tr>
        <tr><th>Tipo/Subtipo</th><td>{{ $maintenance->type == 'Preventive' ? 'Preventiva' : ($maintenance->type == 'Corrective' ? 'Corretiva' : 'Reparo') }} / {{ $maintenance->subType ?? '-' }}</td></tr>
        <tr><th>Data</th><td>{{ \Carbon\Carbon::parse($maintenance->maintenanceDate)->format('d/m/Y') }}</td></tr>
        <tr><th>Quilometragem</th><td>{{ number_format($maintenance->mileage ?? 0, 0, ',', '.') }} km</td></tr>
        <tr><th>Custo</th><td>{{ number_format($maintenance->cost ?? 0, 2, ',', '.') }} Kz</td></tr>
        <tr><th>Descrição</th><td>{{ $maintenance->description ?? '-' }}</td></tr>
        <tr><th>Peças Substituídas</th><td>{{ $maintenance->piecesReplaced ?? '-' }}</td></tr>
        <tr><th>Serviços</th><td>
            @if($maintenance->services && is_array($maintenance->services))
                @foreach($maintenance->services as $s => $det)
                    @if($s == 'outros')
                        Outros Detalhes: {{ $det['outros_details'] ?? $det ?? '' }}<br>
                    @else
                        {{ ucfirst(str_replace('_', ' ', $s)) }}: 
                        @if(is_array($det))
                            @foreach($det as $k => $v)
                                {{ ucfirst(str_replace('_', ' ', $k)) }}: {{ $v }} 
                            @endforeach
                        @else
                            {{ $det }}
                        @endif<br>
                    @endif
                @endforeach
            @else
                -
            @endif
        </td></tr>
        <tr><th>Próxima Manutenção</th><td>{{ $maintenance->nextMaintenanceDate ? \Carbon\Carbon::parse($maintenance->nextMaintenanceDate)->format('d/m/Y') : '-' }} ({{ number_format($maintenance->nextMileage ?? 0, 0, ',', '.') }} km)</td></tr>
        <tr><th>Responsável</th><td>{{ $maintenance->responsibleName ?? '-' }}<br>{{ $maintenance->responsiblePhone ?? '' }} | {{ $maintenance->responsibleEmail ?? '' }}</td></tr>
        <tr><th>Observações</th><td>{{ $maintenance->observations ?? '-' }}</td></tr>
    </tbody>
</table>
@endsection