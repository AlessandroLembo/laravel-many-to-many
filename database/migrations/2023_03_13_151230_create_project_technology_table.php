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
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();

            // Metto le colonne alla tabella ponte
            // $table->unsignedBigInteger('project_id');
            // $table->unsignedBigInteger('technology_id');

            // Definisco la relazione tra le tabelle project e technology
            // $table->foreign('project_id')->references('id')->on('projects');
            // $table->foreign('technology_id')->references('id')->on('technologies');

            /* Mettere le colonne e definire la relazione congiuntamente
               Nel caso di cancellazione di un progetto o di una tecnlogia cade a cascata anche la relazione 'cascade'
            */
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('technology_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /* Nella relazione many-to-many posso buttare giù l'intera tabella ponte perchè senza relazione 
           tra progetto e tecnologia non ha motivo di esserci.
        */
        Schema::dropIfExists('project_technology');
    }
};
