<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cliente')->after('id');
            $table->unsignedBigInteger('id_habitacion')->after('id_cliente');
            $table->date('fecha_ingreso')->after('id_habitacion');
            $table->date('fecha_salida')->after('fecha_ingreso');
            $table->integer('numero_huespedes')->after('fecha_salida');
            $table->decimal('adelanto', 8, 2)->after('numero_huespedes');
            $table->text('notas')->nullable()->after('adelanto');
            $table->tinyInteger('estado')->default(1)->after('notas');

            $table->foreign('id_cliente')->references('id_cliente')->on('clientes');
            $table->foreign('id_habitacion')->references('id_habitacion')->on('habitaciones');
        });
    }

    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']);
            $table->dropForeign(['id_habitacion']);
            $table->dropColumn(['id_cliente', 'id_habitacion', 'fecha_ingreso', 'fecha_salida', 'numero_huespedes', 'adelanto', 'notas', 'estado']);
        });
    }
};
