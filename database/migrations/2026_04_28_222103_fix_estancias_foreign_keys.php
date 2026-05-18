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
        Schema::table('estancias', function (Blueprint $table) {

            $table->dropForeign(['habitacion_id']);

            $table->foreign('habitacion_id')
                ->references('id_habitacion')
                ->on('habitaciones')
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
