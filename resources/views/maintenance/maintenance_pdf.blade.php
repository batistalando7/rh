@extends('layouts.admin.pdf')
@section('pdfTitle', 'Relatório de Manutenções')
@section('titleSection')
    <h4>Relatório de Manutenções</h4>
    <p style="text-align: center;"><strong>Total de Registros:</strong> {{ $filtered->count() }}</p>
@endsection
@section('contentTable')
    @if($filtered->count())
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Viatura</th><th>Tipo/Subtipo</th><th>Data</th><th>Quilometragem</th><th>Custo</th><th>Responsável</th><th>Próxima Data de Manutenção</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filtered as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->vehicle->plate ?? '-' }}</td>
                        <td>{{ $r->type }} / {{ $r->subType ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->maintenanceDate)->format('d/m/Y') }}</td>
                        <td>{{ $r->mileage ?? '-' }} km</td>
                        <td>{{ number_format($r->cost ?? 0, 2, ',', '.') }}</td>
                        <td>{{ $r->responsibleName ?? '-' }}</td>
                        <td>{{ $r->nextMaintenanceDate ? \Carbon\Carbon::parse($r->nextMaintenanceDate)->format('d/m/Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center;">Nenhum registro encontrado.</p>
    @endif
@endsection