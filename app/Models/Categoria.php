<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'Categorias';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'PadreCategoriaId',
        'Jerarquia',
        'Activo',
    ];

    protected $casts = [
        'Activo' => 'boolean',
        'Actualizado' => 'datetime',
        'Creado' => 'datetime',
    ];

    // Relación: Una categoría puede tener muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'Id_Categoria');
    }

    // Relación: Una categoría puede tener una categoría padre
    public function padre()
    {
        return $this->belongsTo(Categoria::class, 'PadreCategoriaId');
    }

    // Relación: Una categoría puede tener muchas categorías hijas
    public function hijas()
    {
        return $this->hasMany(Categoria::class, 'PadreCategoriaId');
    }

    // Scope para obtener solo categorías activas
    public function scopeActivas($query)
    {
        return $query->where('Activo', true);
    }
}
