@php
    $carrito = session('carrito', []);
    $total = 0;
@endphp

@forelse($carrito as $item)
    @php
        $subtotal = $item['precio'] * $item['cantidad'];
        $total += $subtotal;
    @endphp

    <div class="producto-card mb-2">

        <div class="producto-name">{{ $item['nombre'] }}</div>

        <div class="producto-footer" style="margin-top: .75rem;">
            <span class="producto-precio">${{ number_format($subtotal, 2) }}</span>

            <div class="d-flex align-items-center gap-2">

                <form class="disminuir-form" data-id="{{ $item['id'] }}">
                    @csrf
                    <button class="btn-agregar" style="padding: .25rem .75rem;">−</button>
                </form>

          
                <span data-cantidad="{{ $item['cantidad'] }}"
                    style="font-weight: 600; min-width: 1.5rem; text-align:center;">
                    {{ $item['cantidad'] }}
                </span>

                <form class="aumentar-form" data-id="{{ $item['id'] }}">
                    @csrf
                    <button class="btn-agregar" style="padding: .25rem .75rem;">+</button>
                </form>

            </div>
        </div>

        <div style="margin-top: .75rem;">
            <form class="eliminar-form" data-id="{{ $item['id'] }}">
                @csrf
                <button class="btn btn-danger" style="width: 100%; padding: .4rem;">
                    🗑 Eliminar
                </button>
            </form>
        </div>

    </div>

@empty
    <div class="producto-card" style="text-align:center; color: #999;">
        🛒 No hay productos en el pedido
    </div>
@endforelse

<hr style="border-color: rgba(255,255,255,0.1);">

<div class="producto-card" style="margin-bottom: 1rem;">
    <div class="producto-footer" style="font-size: 1.1rem; font-weight: 700;">
        <span>Total</span>
        <span class="producto-precio">${{ number_format($total, 2) }}</span>
    </div>
</div>

@if (count($carrito))
    <form action="{{ route('pedido.confirmar') }}" method="POST">
        @csrf
        <button class="btn btn-success" style="width: 100%; padding: .75rem; text-align:center">
            Confirmar Pedido
        </button>
    </form>
@endif
