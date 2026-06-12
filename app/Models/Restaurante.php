<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    protected $fillable = [
        'nombre',
        'logo',
        'color_primario',
        'color_secundario',
        'telefono',
        'direccion',
        'activo'
    ];

    public function mesas()
    {
        return $this->hasMany(Mesa::class);
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }
}
