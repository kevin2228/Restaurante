@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h2>Mi Pedido</h2>

        @php
            $total = 0;
        @endphp

        <table class="table">

            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($carrito as $item)
                    @php
                        $subtotal = $item['cantidad'] * $item['precio'];

                        $total += $subtotal;
                    @endphp

                    <tr>

                        <td>
                            {{ $item['nombre'] }}
                        </td>

                        <td>
                            {{ $item['cantidad'] }}
                        </td>

                        <td>
                            ${{ $item['precio'] }}
                        </td>

                        <td>
                            ${{ number_format($subtotal, 2) }}
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

        <h3>Total: ${{ number_format($total, 2) }}</h3>

        <form action="{{ route('pedido.confirmar') }}" method="POST">

            @csrf

            <button class="btn btn-primary">
                Confirmar Pedido
            </button>

        </form>

    </div>
@endsection
