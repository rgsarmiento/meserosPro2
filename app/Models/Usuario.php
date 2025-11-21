<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Identificacion',
        'NombreUsuario',
        'Contrasena',
        'Id_Rol',
        'Estado',
    ];

    protected $hidden = [
        'Contrasena',
    ];

    protected $casts = [
        'Creado' => 'datetime',
        'Actualizado' => 'datetime',
    ];

    // Relación: Un usuario puede tener muchas órdenes
    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'UsuarioId');
    }

    // Scope para obtener usuarios activos
    public function scopeActivos($query)
    {
        return $query->where('Estado', 1);
    }
}
