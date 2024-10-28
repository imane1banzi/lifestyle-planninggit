<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCategoryInExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Changer la colonne 'category' pour une longueur plus grande
            $table->string('category')->change(); // Par exemple, ici on utilise 255
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Revenir à la définition précédente si nécessaire
            $table->string('category')->change(); // Ajustez selon vos besoins
        });
    }
}

