<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 150);
            $table->string('email')->nullable();
            $table->string('phone', 20);
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->enum('status', ['prospect', 'client'])->default('prospect');
            $table->timestamps();

            $table->index('city', 'idx_city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
