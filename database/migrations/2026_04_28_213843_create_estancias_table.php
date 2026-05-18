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
        Schema::create('estancias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('habitacion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reserva_id')->nullable()->constrained()->nullOnDelete();

            $table->dateTime('fecha_checkin');
            $table->dateTime('fecha_checkout')->nullable();

            $table->integer('adultos')->default(1);
            $table->integer('ninos')->default(0);

            $table->decimal('tarifa_noche', 10, 2)->nullable();
            $table->integer('noches')->default(1);

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->string('estado')->default('check_in');

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estancias');
    }
};
