<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableUsersStructure extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        // Renombrar una tabla
        Schema::rename('users', 'tbl_ms_usuarios');

        // Renombrar una columna en una tabla
        Schema::table('tbl_ms_usuarios', function (Blueprint $table) {
          $table->renameColumn('name', 'nombre');
        });
    }
    /**
     * Deshacer las migraciones.
     *
     * @return void
     */
    public function down()
    {
        // Renombrar la tabla de nuevo
        Schema::rename('tbl_ms_usuarios', 'users');

        // Renombrar la columna de nuevo
        Schema::table('tbl_ms_usuarios', function (Blueprint $table) {
            $table->renameColumn('nombre', 'name');
        });
    }
}
