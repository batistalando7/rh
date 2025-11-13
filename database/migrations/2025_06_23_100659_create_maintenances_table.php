<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicleId');
            $table->enum('type', ['Preventive', 'Corrective', 'Repair']);
            $table->string('subType', 50)->nullable();
            $table->date('maintenanceDate');
            $table->integer('mileage')->nullable();
            $table->decimal('cost', 10, 2);
            $table->text('description')->nullable();
            $table->text('piecesReplaced')->nullable();
            $table->json('services')->nullable();
            $table->date('nextMaintenanceDate')->nullable();
            $table->integer('nextMileage')->nullable();
            $table->string('responsibleName', 100)->nullable();
            $table->string('responsiblePhone', 20)->nullable();
            $table->string('responsibleEmail', 100)->nullable();
            $table->text('observations')->nullable();
            $table->string('invoice_pre')->nullable();
            $table->string('invoice_post')->nullable();
            $table->timestamps();

            $table->foreign('vehicleId')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance');
    }
}