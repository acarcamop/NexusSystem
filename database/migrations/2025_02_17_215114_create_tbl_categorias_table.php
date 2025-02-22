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
        Schema::create('tbl_categorias', function (Blueprint $table) {
            $table->id('id_categoria');  
            $table->string('nombre_categoria');  
            $table->text('descripcion')->nullable(); 
            $table->enum('estado_categoria', ['activa', 'inactiva', 'suspendida'])->default('activa'); 
            $table->timestamps();  
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_categorias');
    }
};
