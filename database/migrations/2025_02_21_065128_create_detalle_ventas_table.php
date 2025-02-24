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
        Schema::create('tbl_detalle_ventas', function (Blueprint $table) {
                $table->bigIncrements('id_detalle_ventas');
                $table->unsignedBigInteger('id_venta');
                $table->foreign('id_venta')->references('id_venta')->on('tbl_ventas')->onDelete('cascade');
                $table->unsignedBigInteger('id_producto');
                $table->foreign('id_producto')->references('id_producto')->on('tbl_productos')->onDelete('cascade');
                $table->integer('cantidad')->check('cantidad > 0');
                $table->decimal('precio_unitario', 10, 2)->default(0);
                $table->decimal('subtotal', 10, 2)->default(0); // Nuevo campo para el subtotal
                $table->decimal('descuento', 10, 2)->default(0); // Nuevo campo para el descuento
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_detalle_ventas');
    }
};
