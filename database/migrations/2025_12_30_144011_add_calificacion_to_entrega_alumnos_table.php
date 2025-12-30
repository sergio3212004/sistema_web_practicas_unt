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
        Schema::table('entrega_alumnos', function (Blueprint $table) {
            //
            $table->text('comentario_profesor')->nullable()->after('fecha_subida');
            $table->decimal('nota', 5, 2)->nullable()->after('comentario_profesor');
            $table->timestamp('fecha_revision')->nullable()->after('nota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrega_alumnos', function (Blueprint $table) {
            //
        });
    }
};
