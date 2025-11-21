<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrdenDetalle extends Model
{
    protected $table = 'ComandaOrdenDetalles';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'OrdenId',
        'LlaveOrden',
        'CodigoProducto',
        'NombreProducto',
        'CategoriaId',
        'Cantidad',
        'Precio',
        'Observacion',
        'Llave',
        'MesaId',
        'Estado',
    ];

    protected $casts = [
        'Precio' => 'decimal:2',
        'Cantidad' => 'integer',
    ];

    protected $attributes = [
        'Estado' => 'Pendiente',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generar automáticamente la llave única al crear un detalle
        static::creating(function ($detalle) {
            if (empty($detalle->Llave)) {
                $detalle->Llave = (string) Str::uuid();
            }
        });
    }

    // Relación: Un detalle pertenece a una orden
    public function orden()
    {
        return $this->belongsTo(Orden::class, 'OrdenId');
    }

    // Relación: Un detalle puede tener referencia a un producto (opcional, solo lectura)
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'CodigoProducto', 'Codigo');
    }

    // Relación: Un detalle pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'CategoriaId');
    }

    // Relación: Un detalle pertenece a una mesa
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'MesaId');
    }

    // Calcular el subtotal del detalle
    public function getSubtotalAttribute()
    {
        return $this->Cantidad * $this->Precio;
    }
}
