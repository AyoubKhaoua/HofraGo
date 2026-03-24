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
        Schema::create('historique_statuts', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('ancien_statut');
            $table->string('nouveau_statut');
            $table->date('date_changement');
            $table->foreignId('signalement_id')->constrained('signalements')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_statuts');
    }
};
