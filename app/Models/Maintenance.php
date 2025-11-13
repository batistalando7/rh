<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenance';

    protected $fillable = [
        'vehicleId',
        'type',
        'subType',
        'maintenanceDate',
        'mileage',
        'cost',
        'description',
        'piecesReplaced',
        'services',
        'nextMaintenanceDate',
        'nextMileage',
        'responsibleName',
        'responsiblePhone',
        'responsibleEmail',
        'observations',
        'invoice_pre',
        'invoice_post'
    ];

    protected $casts = [
        'services' => 'array',
        'maintenanceDate' => 'date',
        'nextMaintenanceDate' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicleId');
    }
}