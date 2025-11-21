<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'PuestosConsumo';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'IdPiso',
        'Nombre',
        'Estado',
        'FechaHora',
        'Transmitir',
    ];

    protected $casts = [
        'Transmitir' => 'boolean',
        'FechaHora' => 'datetime',
    ];

    // Relación: Una mesa puede tener muchas órdenes
    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'MesaId');
    }

    // Scope para obtener mesas libres
    public function scopeLibres($query)
    {
        return $query->where('Estado', 'Libre');
    }

    // Scope para obtener mesas ocupadas
    public function scopeOcupadas($query)
    {
        return $query->where('Estado', 'Ocupada');
    }
}
