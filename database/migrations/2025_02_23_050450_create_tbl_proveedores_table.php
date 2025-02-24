<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProveedoresTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_proveedores', function (Blueprint $table) {
            $table->bigIncrements('id_proveedor'); 
            $table->string('nombre_comercial');  
            $table->string('telefono_1')->nullable(); 
            $table->string('telefono_2')->nullable();  
            $table->string('email')->nullable();     
            $table->text('direccion_1')->nullable();  
            $table->text('direccion_2')->nullable();  
            $table->string('ciudad')->nullable();   
            $table->enum('estado_proveedor', ['activo', 'inactivo', 'suspendido'])->default('activo');  // Estado con valores específicos
            $table->text('comentarios')->nullable();  
            $table->timestamps();                     
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_proveedores');
    }
}