<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Definir la tabla relacionada (si no sigue la convención de nombres pluralizados)
    protected $table = 'tbl_clientes';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'email_1',
        'email_2',
        'telefono_1',
        'telefono_2',
        'direccion_1',
        'direccion_2',
        'informacion_adicional',
        'estado_cliente',
    ];

    // Si deseas utilizar las fechas personalizadas, puedes añadirlas aquí:
    protected $dates = [
        'creado_en',
        'actualizado_en',
    ];
}
