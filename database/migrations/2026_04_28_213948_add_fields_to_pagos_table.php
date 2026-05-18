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
        Schema::table('pagos', function (Blueprint $table) {
            $table->foreignId('estancia_id')->constrained()->cascadeOnDelete();

            $table->decimal('monto', 10, 2);

            $table->string('metodo_pago');
            $table->string('tipo')->default('parcial');
            $table->string('estado')->default('confirmado');

            $table->string('referencia')->nullable();

            $table->dateTime('fecha_pago')->nullable();

            $table->text('observaciones')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn([
                'estancia_id',
                'monto',
                'metodo_pago',
                'tipo',
                'estado',
                'referencia',
                'fecha_pago',
                'observaciones',
                'user_id',
            ]);
        });
    }
};
