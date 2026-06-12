<?php

namespace App\Http\Controllers;

use App\Models\Pedido;

class CocinaController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with([
            'mesa',
            'detalles.producto'
        ])
            ->whereIn('estado', [
                'pendiente',
                'preparando',
                'listo'
            ])
            ->orderBy('created_at')
            ->get();

        return view(
            'cocina.index',
            compact('pedidos')
        );
    }

    public function cambiarEstado(Pedido $pedido)
    {
        $mesa = $pedido->mesa;
        switch ($pedido->estado) {
            case 'pendiente':
                $pedido->estado = 'preparando';
                $mesa->estado = 'preparando';
                break;

            case 'preparando':
                $pedido->estado = 'listo';
                $mesa->estado = 'listo';
                break;

            case 'listo':
                $pedido->estado = 'entregado';
                $mesa->estado = 'libre';
                break;
        }

        $pedido->save();

        return back();
    }
}
