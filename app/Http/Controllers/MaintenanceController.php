<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with('vehicle');
        if ($request->filled('startDate')) {
            $query->whereDate('maintenanceDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('maintenanceDate', '<=', $request->endDate);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $records = $query->orderByDesc('maintenanceDate')->get();
        return view('maintenance.index', compact('records'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', '!=', 'Unavailable')->get();
        return view('maintenance.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicleId' => 'required|exists:vehicles,id',
            'type' => 'required|in:Preventive,Corrective,Repair',
            'subType' => 'required|string|max:50',
            'maintenanceDate' => 'required|date|before_or_equal:today',
            'mileage' => 'required|numeric|min:0',  // Numeric para 4.000
            'cost' => 'required|numeric|min:0',  // Numeric para 50.000
            'description' => 'nullable|string',
            'piecesReplaced' => 'nullable|string',
            'services' => 'required|array|min:1',
            'nextMaintenanceDate' => 'nullable|date|after:maintenanceDate',
            'nextMileage' => 'nullable|numeric|gt:mileage',  // Numeric
            'responsibleName' => 'required|string|max:100',
            'responsiblePhone' => 'nullable|string|max:20',
            'responsibleEmail' => 'nullable|email|max:100',
            'observations' => 'nullable|string',
            'invoice_pre' => 'nullable|file|mimes:pdf,jpg,png',  // Sem max
            'invoice_post' => 'nullable|file|mimes:pdf,jpg,png',  // Sem max
        ], [
            'services.min' => 'Selecione pelo menos um serviço.',
            'nextMileage.gt' => 'Próxima quilometragem deve ser maior que atual.',
        ]);

        if ($request->hasFile('invoice_pre')) {
            $file = $request->file('invoice_pre');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('frontend/docs/maintenance/pre'), $name);
            $data['invoice_pre'] = $name;
        }
        if ($request->hasFile('invoice_post')) {
            $file = $request->file('invoice_post');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('frontend/docs/maintenance/post'), $name);
            $data['invoice_post'] = $name;
        }

        $record = Maintenance::create($data);

        $vehicle = Vehicle::find($data['vehicleId']);
        $vehicle->update([
            'currentMileage' => $data['mileage'],
            'lastMaintenanceDate' => $data['maintenanceDate'],
            'nextMaintenanceDate' => $data['nextMaintenanceDate'],
        ]);

        return redirect()->route('maintenance.index')->with('msg', 'Manutenção registrada com sucesso.');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load('vehicle');
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        $vehicles = Vehicle::all();
        return view('maintenance.edit', compact('maintenance', 'vehicles'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $data = $request->validate([
            'vehicleId' => 'required|exists:vehicles,id',
            'type' => 'required|in:Preventive,Corrective,Repair',
            'subType' => 'required|string|max:50',
            'maintenanceDate' => 'required|date|before_or_equal:today',
            'mileage' => 'required|numeric|min:0',  // Numeric
            'cost' => 'required|numeric|min:0',  // Numeric
            'description' => 'nullable|string',
            'piecesReplaced' => 'nullable|string',
            'services' => 'required|array|min:1',
            'nextMaintenanceDate' => 'nullable|date|after:maintenanceDate',
            'nextMileage' => 'nullable|numeric|gt:mileage',  // Numeric
            'responsibleName' => 'required|string|max:100',
            'responsiblePhone' => 'nullable|string|max:20',
            'responsibleEmail' => 'nullable|email|max:100',
            'observations' => 'nullable|string',
            'invoice_pre' => 'nullable|file|mimes:pdf,jpg,png',  // Sem max
            'invoice_post' => 'nullable|file|mimes:pdf,jpg,png',  // Sem max
        ]);

        if ($request->hasFile('invoice_pre')) {
            if ($maintenance->invoice_pre && file_exists(public_path('frontend/docs/maintenance/pre/' . $maintenance->invoice_pre))) {
                unlink(public_path('frontend/docs/maintenance/pre/' . $maintenance->invoice_pre));
            }
            $file = $request->file('invoice_pre');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('frontend/docs/maintenance/pre'), $name);
            $data['invoice_pre'] = $name;
        }
        if ($request->hasFile('invoice_post')) {
            if ($maintenance->invoice_post && file_exists(public_path('frontend/docs/maintenance/post/' . $maintenance->invoice_post))) {
                unlink(public_path('frontend/docs/maintenance/post/' . $maintenance->invoice_post));
            }
            $file = $request->file('invoice_post');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('frontend/docs/maintenance/post'), $name);
            $data['invoice_post'] = $name;
        }

        $maintenance->update($data);

        $vehicle = Vehicle::find($data['vehicleId']);
        $vehicle->update([
            'currentMileage' => $data['mileage'],
            'lastMaintenanceDate' => $data['maintenanceDate'],
            'nextMaintenanceDate' => $data['nextMaintenanceDate'],
        ]);

        return redirect()->route('maintenance.edit', $maintenance)->with('msg', 'Manutenção atualizada com sucesso.');
    }

    public function destroy(Maintenance $maintenance)
    {
        if ($maintenance->invoice_pre && file_exists(public_path('frontend/docs/maintenance/pre/' . $maintenance->invoice_pre))) {
            unlink(public_path('frontend/docs/maintenance/pre/' . $maintenance->invoice_pre));
        }
        if ($maintenance->invoice_post && file_exists(public_path('frontend/docs/maintenance/post/' . $maintenance->invoice_post))) {
            unlink(public_path('frontend/docs/maintenance/post/' . $maintenance->invoice_post));
        }
        $maintenance->delete();
        return redirect()->route('maintenance.index')->with('msg', 'Manutenção excluída com sucesso.');
    }

    public function exportFilteredPDF(Request $request)
    {
        $query = Maintenance::with('vehicle');
        if ($request->filled('startDate')) {
            $query->whereDate('maintenanceDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('maintenanceDate', '<=', $request->endDate);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $filtered = $query->orderByDesc('id')->get();

        $pdf = PDF::loadView('maintenance.maintenance_pdf', compact('filtered'))->setPaper('a4', 'portrait');
        return $pdf->download('Manutencoes_Filtradas.pdf');
    }

    public function pdfAll(Request $request)
    {
        $query = Maintenance::with('vehicle');
        if ($request->filled('startDate')) {
            $query->whereDate('maintenanceDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('maintenanceDate', '<=', $request->endDate);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $all = $query->orderByDesc('id')->get();

        $filename = 'Manutencoes' . (
            $request->filled('startDate') || $request->filled('endDate') || $request->filled('type')
            ? '_Filtradas' : ''
        ) . '.pdf';

        $pdf = PDF::loadView('maintenance.maintenance_pdf', ['filtered' => $all])->setPaper('a4', 'portrait');
        return $pdf->stream($filename);
    }

    public function showPdf(Maintenance $maintenance)
    {
        $maintenance->load('vehicle');
        $pdf = PDF::loadView('maintenance.maintenance_pdf_individual', compact('maintenance'))->setPaper('a4', 'landscape');
        return $pdf->stream("Manutencao_{$maintenance->id}.pdf");
    }
}