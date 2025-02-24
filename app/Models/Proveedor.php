<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

   // Nombre de la tabla asociada
    protected $table = 'tbl_proveedores';
 protected $primaryKey = 'id_proveedor';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'informacion_adicional',
        'estado_proveedor',
    ];

    // Si deseas utilizar las fechas personalizadas, puedes añadirlas aquí:
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}