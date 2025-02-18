<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Ejecutar la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_clientes', function (Blueprint $table) {
            $table->id(); 
            $table->string('primer_nombre'); 
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('email_1')->unique(); 
            $table->string('email_2')->nullable(); 
            $table->string('telefono_1')->unique();
            $table->string('telefono_2')->nullable(); 
            $table->string('direccion_1'); 
            $table->string('direccion_2')->nullable(); 
            $table->text('informacion_adicional')->nullable();
            $table->enum('estado_cliente', ['activo', 'inactivo', 'suspendido'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_clientes');
    }
}
