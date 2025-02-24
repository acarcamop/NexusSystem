<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up(): void{Schema::create('tbl_ventas', function (Blueprint $table) {
    $table->id('id_venta');
    $table->unsignedBigInteger('id_cliente');
    $table->foreign('id_cliente')->references('id')->on('tbl_clientes')->onDelete('cascade');
    $table->decimal('total', 10, 2);$table->string('estado')->default('pendiente');
    $table->timestamps();});}

  public function down(): void{Schema::dropIfExists('tbl_ventas');}
};