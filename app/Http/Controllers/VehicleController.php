<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Driver;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with('drivers', 'maintenance');
        if ($request->filled('startDate')) {
            $query->whereDate('created_at', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }
        $vehicles = $query->orderByDesc('id')->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $drivers = Driver::where('status', 'Active')->get();
        return view('vehicles.create', compact('drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plate' => 'required|string|max:12|unique:vehicles',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'yearManufacture' => 'required|integer|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:30',
            'loadCapacity' => 'required|integer|min:1',
            'status' => 'required|in:Available,UnderMaintenance,Unavailable',
            'driverId' => 'nullable|exists:drivers,id',
            'notes' => 'nullable|string',
        ]);

        $vehicle = Vehicle::create($data);

        if ($request->filled('driverId')) {
            $vehicle->drivers()->attach($request->driverId, ['startDate' => now()]);
        }

        return redirect()->route('vehicles.index')->with('msg', 'Viatura cadastrada com sucesso.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('drivers', 'maintenance');
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $drivers = Driver::where('status', 'Active')->get();
        return view('vehicles.edit', compact('vehicle', 'drivers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'plate' => 'required|string|max:12|unique:vehicles,plate,' . $vehicle->id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'yearManufacture' => 'required|integer|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:30',
            'loadCapacity' => 'required|integer|min:1',
            'status' => 'required|in:Available,UnderMaintenance,Unavailable',
            'driverId' => 'nullable|exists:drivers,id',
            'notes' => 'nullable|string',
        ]);

        $vehicle->update($data);

        if ($request->filled('driverId') && $request->driverId != $vehicle->driverId) {
            // Lógica para trocar driver se necessário
            $vehicle->drivers()->detach();
            $vehicle->drivers()->attach($request->driverId, ['startDate' => now()]);
        }

        return redirect()->route('vehicles.edit', $vehicle)->with('msg', 'Viatura atualizada com sucesso.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->drivers()->detach();
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('msg', 'Viatura excluída com sucesso.');
    }

    // PDFs (similar a outros; adicione filtros se quiser)
    public function pdfAll(Request $request)
    {
        $query = Vehicle::with('drivers', 'maintenance');
        if ($request->filled('startDate')) {
            $query->whereDate('created_at', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }
        $filtered = $query->orderByDesc('id')->get();

        $filename = 'Viaturas' . (
            $request->filled('startDate') || $request->filled('endDate')
            ? '_Filtradas' : ''
        ) . '.pdf';

        $pdf = PDF::loadView('vehicles.vehicles_pdf', compact('filtered'))->setPaper('a4', 'portrait');
        return $pdf->stream($filename);
    }

    public function showPdf(Vehicle $vehicle)
    {
        $vehicle->load('drivers', 'maintenance');
        $pdf = PDF::loadView('vehicles.vehicle_pdf_individual', compact('vehicle'))->setPaper('a4', 'portrait');
        return $pdf->stream("Viatura_{$vehicle->id}.pdf");
    }
}