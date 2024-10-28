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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();                              // ID unique pour chaque dépense
            $table->foreignId('user_id')               // Associe chaque dépense à un utilisateur
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('profile_id')            // Associe chaque dépense à un profil
                  ->constrained()
                  ->onDelete('cascade');
            $table->enum('category', ['subscriptions', 'housing', 'food']); // Catégorie de la dépense
            $table->decimal('amount', 10, 2);          // Montant de la dépense
            $table->timestamps();                      // Horodatage automatique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
