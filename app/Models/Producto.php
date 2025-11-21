<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Productos';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Codigo',
        'Nombre',
        'PrecioVenta',
        'PrecioVenta2',
        'PrecioVenta3',
        'Id_Categoria',
        'Activo',
        'SeVende',
        'Destacado',
    ];

    protected $casts = [
        'Activo' => 'boolean',
        'SeVende' => 'boolean',
        'SeCompra' => 'boolean',
        'Destacado' => 'boolean',
        'EsCombo' => 'boolean',
        'Inventariable' => 'boolean',
        'EsFraccion' => 'boolean',
        'VentaPorValor' => 'boolean',
        'Transmitir' => 'boolean',
        'SumarOtroImpuestoEnVenta' => 'boolean',
        'PrecioVenta' => 'decimal:2',
        'PrecioVenta2' => 'decimal:2',
        'PrecioVenta3' => 'decimal:2',
        'PrecioCompra' => 'decimal:2',
        'Actualizado' => 'datetime',
        'Creado' => 'datetime',
    ];

    // Relación: Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'Id_Categoria');
    }

    // Scope para obtener solo productos activos
    public function scopeActivos($query)
    {
        return $query->where('Activo', true);
    }

    // Scope para obtener solo productos que se venden
    public function scopeVendibles($query)
    {
        return $query->where('SeVende', true);
    }
}
