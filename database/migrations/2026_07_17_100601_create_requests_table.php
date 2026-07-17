<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table fusionnée devis + urgence.
     * is_quick = canal d'arrivée (immuable).
     * project_id nullable : une demande peut exister sans chantier.
     * ON DELETE SET NULL sur project_id : supprimer un chantier ne supprime pas ses demandes.
     */
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference', 20)->unique();
            $table->text('description');
            $table->boolean('is_quick')->default(false);
            $table->enum('priority', ['normal', 'urgent'])->default('normal');
            $table->decimal('budget_estimate', 10, 2)->nullable();
            $table->enum('status', ['nouveau', 'en_cours', 'traite', 'perdu'])->default('nouveau');
            $table->text('closing_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status', 'requests_status_index');
            $table->index('is_quick', 'requests_is_quick_index');
            $table->index('is_archived', 'requests_is_archived_index');
            $table->index('created_at', 'requests_created_at_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
