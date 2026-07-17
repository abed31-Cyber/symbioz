<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * DECIMAL(10,2) pour le montant — jamais de FLOAT (ADR-010).
     * sent_at : date d'envoi du devis au client.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['draft', 'sent', 'accepted', 'refused', 'paid'])->default('draft');
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
            $table->index('status', 'quotes_status_index');
            $table->index('sent_at', 'quotes_sent_at_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
