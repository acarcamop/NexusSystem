<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'descuento'
        
    ];

    protected $table = 'tbl_detalle_ventas';  // Nombre de la tabla
    protected $primaryKey = 'id_detalle_ventas'; // Clave primaria personalizada

    // Relación con Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

  protected static function booted()
{
    static::creating(function ($detalleVenta) {
        \Log::info($detalleVenta);  // Verifica que datos están siendo recibidos

        $precio_unitario = $detalleVenta->precio_unitario;
        $cantidad = $detalleVenta->cantidad;
        $descuento = $detalleVenta->descuento ?? 0;

        // Calcula el precio con descuento
        $precio_con_descuento = $precio_unitario - ($precio_unitario * ($descuento / 100));

        // Calcula el subtotal
        $detalleVenta->subtotal = $precio_con_descuento * $cantidad;

        \Log::info('Subtotal calculado: ' . $detalleVenta->subtotal);  // Verifica si el subtotal es calculado correctamente
    });
}


}