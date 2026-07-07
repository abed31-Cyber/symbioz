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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->string('address', 255)->nullable();
            $table->enum('service_type', ['plomberie', 'electricite', 'peinture', 'platrerie', 'menuiserie']);
            $table->text('description'); // min 10 caractères, validé côté Form Request
            $table->decimal('budget_estimate', 10, 2)->nullable();
            $table->enum('status', ['nouveau', 'en_cours', 'traite', 'perdu'])->default('nouveau');
            $table->text('admin_notes')->nullable();
            $table->text('lost_reason')->nullable(); // obligatoire si status=perdu (RG-2)
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('created_at');
        });
    }

     /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
