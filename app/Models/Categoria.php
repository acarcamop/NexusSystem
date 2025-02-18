<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'tbl_categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre_categoria',
        'descripcion',
        'estado_categoria',
    ];

    // Relación con los productos (Un categoria tiene muchos productos)
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}

