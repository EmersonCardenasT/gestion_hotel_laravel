<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id('id_habitacion');
            $table->string('numero')->unique();
            $table->unsignedBigInteger('id_tipo');
            $table->integer('piso');
            $table->enum('estado', [
                'disponible',
                'ocupada',
                'limpieza',
                'mantenimiento'
            ])->default('disponible');

            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_tipo')
                ->references('id_tipo')
                ->on('tipos_habitacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacions');
    }
};
