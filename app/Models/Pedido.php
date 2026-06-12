<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    //
    protected $fillable = [
        'mesa_id',
        'numero_pedido',
        'estado',
        'subtotal',
        'impuestos',
        'total',
        'editable_hasta',
        'observaciones'
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}
