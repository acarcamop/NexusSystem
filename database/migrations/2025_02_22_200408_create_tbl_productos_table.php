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
        Schema::create('tbl_productos', function (Blueprint $table) {
            $table->id('id_producto'); 
            $table->string('nombre'); 
            $table->text('descripcion')->nullable(); 
            $table->decimal('precio', 10, 2); 
            $table->integer('cantidad');
            $table->enum('estado_producto', ['activo', 'inactivo', 'agotado'])->default('activo'); 
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id_categoria')->on('tbl_categorias')->onDelete('cascade');  
            $table->unsignedBigInteger('proveedor_id')->nullable(); 
            $table->foreign('proveedor_id')->references('id_proveedor')->on('tbl_proveedores')->onDelete('cascade'); 
            $table->timestamps(); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_productos');
    }
};
