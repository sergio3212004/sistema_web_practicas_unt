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
        Schema::create('cronogramas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ficha_id');
            $table->foreign('ficha_id')
                ->references('id')
                ->on('fichas_registro')
                ->onDelete('cascade');
            // Estados de firma
            $table->timestamp('firma_practicante_at')->nullable();
            $table->timestamp('firma_jefe_directo_at')->nullable();
            $table->timestamp('firma_profesor_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cronogramas');
    }
};
