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
    Schema::create('tbl_kardex', function (Blueprint $table) {
        $table->id('id_kardex');
        $table->unsignedBigInteger('id_producto');
        $table->unsignedBigInteger('id_venta')->nullable();
        $table->unsignedBigInteger('id_compra')->nullable();
        $table->unsignedBigInteger('id_proveedor')->nullable(); // Columna para el proveedor
        $table->unsignedBigInteger('id_usuario')->nullable();
        $table->enum('tipo', ['venta', 'compra']);
        $table->integer('cantidad');
        $table->decimal('total', 10, 2);
        
        // Claves foráneas
        $table->foreign('id_producto')->references('id_producto')->on('tbl_productos');
        $table->foreign('id_venta')->references('id_venta')->on('tbl_ventas');
        $table->foreign('id_compra')->references('id_compra')->on('tbl_compras');
        $table->foreign('id_proveedor')->references('id_proveedor')->on('tbl_proveedores'); // Relación con la tabla de proveedores
        $table->foreign('id_usuario')->references('id')->on('tbl_ms_usuarios');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kardex');
    }
};
