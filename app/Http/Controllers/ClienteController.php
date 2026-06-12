<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoDetalle;

class ClienteController extends Controller
{
    public function menu($codigo_qr)
    {
        $mesa = Mesa::where('codigo_qr', $codigo_qr)
            ->firstOrFail();

        $categorias = Categoria::with('productos')
            ->where('activo', true)
            ->get();

        return view('cliente.menu', compact(
            'mesa',
            'categorias'
        ));
    }

    public function agregarCarrito(Request $request)
    {
        $producto = Producto::findOrFail(
            $request->producto_id
        );

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad']++;
        } else {
            $carrito[$producto->id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1
            ];
        }

        session()->put('carrito', $carrito);

        session()->put('mesa_id', $request->mesa_id);

        return back()
            ->with('success', 'Producto agregado');
    }

    public function carrito()
    {
        $carrito = session()
            ->get('carrito', []);

        return view(
            'cliente.carrito',
            compact('carrito')
        );
    }

    public function confirmarPedido()
    {
        $carrito = session()->get('carrito');

        if (!$carrito) {
            return back();
        }

        $mesaId = session()->get('mesa_id');

        $subtotal = 0;

        foreach ($carrito as $item) {

            $subtotal +=
                $item['precio'] *
                $item['cantidad'];
        }

        $pedido = Pedido::create([

            'mesa_id' => $mesaId,

            'numero_pedido' =>
            'PED-' . time(),

            'estado' =>
            'pendiente',

            'subtotal' =>
            $subtotal,

            'impuestos' =>
            0,

            'total' =>
            $subtotal,

            'editable_hasta' =>
            now()->addMinutes(5)

        ]);

        foreach ($carrito as $item) {

            PedidoDetalle::create([

                'pedido_id' =>
                $pedido->id,

                'producto_id' =>
                $item['id'],

                'cantidad' =>
                $item['cantidad'],

                'precio_unitario' =>
                $item['precio'],

                'subtotal' =>
                $item['cantidad'] *
                    $item['precio']

            ]);
        }

        // Actualizar estado de la mesa
        $mesa = Mesa::findOrFail($mesaId);

        $mesa->estado = 'pendiente';

        $mesa->save();

        // Limpiar sesión
        session()->forget([
            'carrito',
            'mesa_id'
        ]);

        return redirect()
            ->route('menu', $mesa->codigo_qr)
            ->with(
                'success',
                'Pedido enviado a cocina'
            );
    }
}
