<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'tbl_proveedores';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = true;

    protected $fillable = [
        'nombre_comercial',
        'telefono_1',
        'telefono_2',
        'email',
        'direccion_1',
        'direccion_2',
        'ciudad',
        'estado_proveedor',
        'comentarios',
    ];
}
