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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('statut');
            $table->date('date_signalement');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('citoyen_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agent_municipal_id')->nullable()->constrained('agent_municipals')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
