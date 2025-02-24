<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kardex;
use App\Models\DetalleVenta; // Asegúrate de que este modelo existe y tiene los campos adecuados

class Venta extends Model
{
    // Definir la columna primaria
    protected $primaryKey = 'id_venta'; // Asegúrate de que la columna primaria se llama 'id_venta'

    protected $fillable = [
        'id_cliente',
        'total',
        'estado',
    ];

    protected $table = 'tbl_ventas';

    // Relación con los detalles de venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public static function boot()
    {
        parent::boot();
    
        // Evento saving que ya tienes
        static::saving(function ($venta) {
            $total = $venta->detalles->sum(function ($detalle) {
                return $detalle->subtotal; // Asegúrate de que cada detalle tenga el campo 'subtotal'
            });
            $venta->total = $total;
        });
    
        // Evento created para crear registros en el Kardex
        static::created(function ($venta) {
            foreach ($venta->detalles as $detalle) {
                Kardex::create([
                    'id_producto' => $detalle->id_producto, // Asegúrate de que detalle tenga 'id_producto'
                    'id_venta' => $venta->id_venta,
                    'tipo' => 'venta',
                    'cantidad' => $detalle->cantidad,
                    'total' => $detalle->cantidad * $detalle->precio_unitario, // Verifica que 'precio_unitario' exista en DetalleVenta
                    'descripcion' => 'Venta de producto',
                    'id_usuario' => $venta->id_usuario,  // Asegúrate de que 'id_usuario' esté disponible
                    'id_cliente' => $venta->id_cliente,  // Asocia el cliente de la venta al Kardex
                ]);
            }
        });
    }
}
