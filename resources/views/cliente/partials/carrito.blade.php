@php
    $carrito = session('carrito', []);
    $total = 0;
@endphp

@forelse($carrito as $item)
    @php
        $subtotal = $item['precio'] * $item['cantidad'];
        $total += $subtotal;
    @endphp

    <div class="card mb-2">

        <div class="card-body">

            <strong>
                {{ $item['nombre'] }}
            </strong>

            <div class="mt-3 d-flex align-items-center">

                <form class="disminuir-form" data-id="{{ $item['id'] }}">

                    @csrf

                    <button class="btn btn-outline-danger btn-sm">
                        -
                    </button>

                </form>

                <span class="mx-3">

                    {{ $item['cantidad'] }}

                </span>

                <form class="aumentar-form" data-id="{{ $item['id'] }}">

                    @csrf

                    <button class="btn btn-outline-success btn-sm">
                        +
                    </button>

                </form>

            </div>

            <div class="mt-3">

                <form class="eliminar-form" data-id="{{ $item['id'] }}">

                    @csrf

                    <button class="btn btn-danger btn-sm">
                        🗑 Eliminar
                    </button>

                </form>

            </div>

            <div class="mt-3">

                ${{ number_format($subtotal, 2) }}

            </div>

        </div>

    </div>

@empty

    <p>No hay productos</p>
@endforelse

<hr>

<h4>
    Total: ${{ number_format($total, 2) }}
</h4>

@if (count($carrito))
    <form action="{{ route('pedido.confirmar') }}" method="POST">

        @csrf

        <button class="btn btn-success w-100">
            Confirmar Pedido
        </button>

    </form>
@endif
