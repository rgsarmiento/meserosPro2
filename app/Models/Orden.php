<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Orden extends Model
{
    protected $table = 'ComandaOrdenes';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Llave',
        'FechaHora',
        'UsuarioId',
        'MesaId',
        'Total',
        'Estado',
        'Impreso',
    ];

    protected $casts = [
        'FechaHora' => 'datetime',
        'FechaCreacion' => 'datetime',
        'Total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generar automáticamente la llave única al crear una orden
        static::creating(function ($orden) {
            if (empty($orden->Llave)) {
                $orden->Llave = (string) Str::uuid();
            }
            if (empty($orden->FechaHora)) {
                $orden->FechaHora = now();
            }
            if (empty($orden->Estado)) {
                $orden->Estado = 'Pendiente';
            }
        });
    }

    // Relación: Una orden pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioId');
    }

    // Relación: Una orden pertenece a una mesa
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'MesaId');
    }

    // Relación: Una orden tiene muchos detalles
    public function detalles()
    {
        return $this->hasMany(OrdenDetalle::class, 'OrdenId');
    }

    // Scope para obtener órdenes pendientes
    public function scopePendientes($query)
    {
        return $query->where('Estado', 'Pendiente');
    }

    // Scope para obtener órdenes completadas
    public function scopeCompletadas($query)
    {
        return $query->where('Estado', 'Completada');
    }
}
