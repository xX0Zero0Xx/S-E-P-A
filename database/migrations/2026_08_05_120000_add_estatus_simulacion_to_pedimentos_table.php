<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * chingadera para agregar el estatus del flujo de simulacion aduanal
     */
    public function up(): void
    {
        Schema::table('pedimentos', function (Blueprint $table) {
            $table->enum('estatus_simulacion', ['Borrador', 'Validado', 'Pagado', 'Despachado'])
                  ->default('Borrador')
                  ->after('total_general');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedimentos', function (Blueprint $table) {
            $table->dropColumn('estatus_simulacion');
        });
    }
};
