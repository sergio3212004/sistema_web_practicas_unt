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
        Schema::table('firma_tokens', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('firma_tokens', 'cronograma_id')) {
                $table->foreignId('cronograma_id')
                    ->nullable()
                    ->after('ficha_registro_id')
                    ->constrained('cronogramas')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('firma_tokens', 'contexto')) {
                $table->string('contexto')
                    ->default('ficha_registro')
                    ->after('tipo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('firma_tokens', function (Blueprint $table) {
            //
            if (Schema::hasColumn('firma_tokens', 'cronograma_id')) {
                $table->dropForeign(['cronograma_id']);
                $table->dropColumn('cronograma_id');
            }

            if (Schema::hasColumn('firma_tokens', 'contexto')) {
                $table->dropColumn('contexto');
            }
        });
    }
};
