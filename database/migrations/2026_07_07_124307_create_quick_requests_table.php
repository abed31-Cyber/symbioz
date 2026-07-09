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
        Schema::create('quick_requests', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name', 100);
            $table->string('contact_phone', 20);
            $table->string('contact_email', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->enum('service_type', ['plomberie', 'electricite', 'peinture', 'platrerie', 'menuiserie']);
            $table->text('description');
            $table->enum('status', ['nouveau', 'en_cours', 'traite', 'perdu'])->default('nouveau');
            $table->text('admin_notes')->nullable();
            $table->text('lost_reason')->nullable();
            $table->timestamps();
            // softdelet genére la colonne deleted_at pour SoftDeletesEloquent.

            $table->softDeletes();
            //ondex pour les colonnes qui seront utilisées pour les recherches et les tris dans le dashboard admin.
            $table->index('status');
            $table->index('created_at');
        });
    }

     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_requests');
    }
};


//verification avec la command:
// sail artisan tinker --execute="echo Schema::hasTable('quote_requests') ? 'OK quote_requests' :
// 'MANQUANT'; echo PHP_EOL; echo Schema::hasTable('quick_requests') ? 'OK quick_requests' : 'MANQUANT';"



