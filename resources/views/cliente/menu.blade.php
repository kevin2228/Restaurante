@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endpush

@push('scripts')
    <script>
        window.ROUTES = {
            carritoParcial: "{{ route('carrito.parcial') }}",
            agregarCarrito: "{{ route('agregar.carrito') }}"
        };
    </script>
    <script src="{{ asset('js/Menu.js') }}" defer></script>
@endpush

@section('content')
    {{-- notificación --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="mensaje-toast" class="toast align-items-center text-white border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toast-mensaje"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <div class="page-title">Mesa {{ $mesa->numero }}</div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="menu-wrapper" style="padding-bottom:0; margin-bottom:1rem;">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="menu-hero">
        <h2 style="text-align:center">Menú</h2>
        <p>Elige tus platillos favoritos y agrégalos a tu pedido</p>
    </div>

    <!-- Product listing -->
    <div class="menu-wrapper">
        @foreach ($categorias as $categoria)
            <div class="categoria-block">
                <div class="section-heading">
                    <span class="section-badge">{{ $categoria->nombre }}</span>
                    <span class="section-divider"></span>
                </div>

                <div class="productos-grid">
                    @foreach ($categoria->productos as $producto)
                        <div class="producto-card">
                            <div class="producto-img">
                                @php
                                    $imagenes = [
                                        'Hamburguesas' => asset('img/hamburguesa.jpg'),
                                        'Sodas' => asset('img/soda.jpg'),
                                        'Postres' => asset('img/postre.jpg'),
                                    ];
                                @endphp
                                <img src="{{ $imagenes[$categoria->nombre] ?? asset('img/soda.jpg') }}"
                                    alt="{{ $categoria->nombre }}">
                            </div>
                            <div class="producto-name">{{ $producto->nombre }}</div>
                            @if ($producto->descripcion)
                                <div class="producto-desc">{{ $producto->descripcion }}</div>
                            @endif
                            <div class="producto-footer">
                                <span class="producto-precio">${{ number_format($producto->precio, 2) }}</span>
                                <form class="agregar-carrito-form">
                                    @csrf
                                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                    <input type="hidden" name="mesa_id" value="{{ $mesa->id }}">
                                    <button class="btn-agregar" type="submit">+ Agregar</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- FAB carrito -->
    <button class="fab-carrito" type="button" data-bs-toggle="offcanvas" data-bs-target="#carritoOffcanvas">
        🛒 <span>Pedido</span>
        <span id="contador-carrito" class="badge">
            {{ collect(session('carrito', []))->sum('cantidad') }}
        </span>
    </button>

    <!-- Offcanvas carrito -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="carritoOffcanvas">
        <div class="offcanvas-header">
            <h5>Mi Pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div id="contenido-carrito">
                @include('cliente.partials.carrito')
            </div>
        </div>
    </div>
@endsection
