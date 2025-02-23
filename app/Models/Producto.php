<?php

// app/Models/Producto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'tbl_productos';
    protected $primaryKey = 'id_producto';
    // Si deseas asignar masivamente estos campos
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'estado_producto',
        'id_categoria',
        'proveedor_id',
    ];

    // Relación con la categoría (Cada producto pertenece a una categoría)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    // Relación con el proveedor (Cada producto pertenece a un proveedor)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id_proveedor');  
    }
}

