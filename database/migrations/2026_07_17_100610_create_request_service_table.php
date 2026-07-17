<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot N-N n°1 : une demande concerne 1 à N services.
     * PK composite — pas de colonne `id`.
     */
    public function up(): void
    {
        Schema::create('request_service', function (Blueprint $table) {
            $table->foreignId('request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();

            $table->primary(['request_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_service');
    }
};
