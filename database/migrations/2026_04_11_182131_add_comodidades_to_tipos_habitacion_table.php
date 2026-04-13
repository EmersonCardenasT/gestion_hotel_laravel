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
    Schema::table('tipos_habitacion', function (Blueprint $table) {
        $table->text('comodidades')->nullable()->after('descripcion');
    });
}

public function down(): void
{
    Schema::table('tipos_habitacion', function (Blueprint $table) {
        $table->dropColumn('comodidades');
    });
}
};
