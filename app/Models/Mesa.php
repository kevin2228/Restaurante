<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable = [
        'restaurante_id',
        'codigo_qr',
        'numero',
        'capacidad',
        'estado'
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
