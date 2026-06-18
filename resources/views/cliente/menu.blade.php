@extends('layouts.app')

@section('content')
    <div id="mensaje-toast"></div>
    <div class="container mt-4">

        <h2>Mesa {{ $mesa->numero }}</h2>

        <button class="btn btn-primary position-fixed" style="bottom:20px; right:20px; z-index:999;" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#carritoOffcanvas">

            🛒

            <span id="contador-carrito" class="badge bg-danger">

                {{ collect(session('carrito', []))->sum('cantidad') }}

            </span>

        </button>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!--<a href="{{ route('carrito') }}" class="btn btn-primary mb-3">
                                                                                                                                                                    Ver Pedido
                                                                                                                                                                </a>-->
        @foreach ($categorias as $categoria)
            <div class="card mb-3">

                <div class="card-header">
                    {{ $categoria->nombre }}
                </div>

                <div class="card-body">

                    @foreach ($categoria->productos as $producto)
                        <div class="row mb-3">

                            <div class="col-md-8">

                                <h5>{{ $producto->nombre }}</h5>

                                <small>
                                    {{ $producto->descripcion }}
                                </small>

                            </div>

                            <div class="col-md-2">

                                ${{ number_format($producto->precio, 2) }}

                            </div>

                            <div class="col-md-2">

                                <form class="agregar-carrito-form">

                                    @csrf

                                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                                    <input type="hidden" name="mesa_id" value="{{ $mesa->id }}">

                                    <button class="btn btn-success">
                                        Agregar
                                    </button>

                                </form>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>
        @endforeach

    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="carritoOffcanvas">

        <div class="offcanvas-header">

            <h5>
                Mi Pedido
            </h5>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas">
            </button>

        </div>

        <div class="offcanvas-body">

            <div id="contenido-carrito">

                @include('cliente.partials.carrito')

            </div>

        </div>

    </div>

    <script>
        async function actualizarCarrito() {
            let response =
                await fetch(
                    "{{ route('carrito.parcial') }}"
                );

            let html =
                await response.text();

            document
                .getElementById(
                    'contenido-carrito'
                )
                .innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', function() {

            actualizarCarrito();

            document.querySelectorAll(
                '.agregar-carrito-form'
            ).forEach(form => {

                form.addEventListener(
                    'submit',
                    async function(e) {

                        e.preventDefault();

                        try {

                            let formData =
                                new FormData(this);

                            let response =
                                await fetch(
                                    "{{ route('agregar.carrito') }}", {
                                        method: 'POST',

                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]'
                                            ).content,

                                            'Accept': 'application/json'
                                        },

                                        body: formData
                                    }
                                );

                            let data =
                                await response.json();

                            console.log(data);

                            if (data.success) {

                                // Actualizar contador
                                document
                                    .getElementById(
                                        'contador-carrito'
                                    )
                                    .innerText = data.items;

                                // Obtener carrito actualizado
                                await actualizarCarrito();

                                // Mostrar mensaje
                                document
                                    .getElementById(
                                        'mensaje-toast'
                                    )
                                    .innerHTML = `
                                    <div class="alert alert-success alert-dismissible fade show">
                                        ${data.message}
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="alert">
                                        </button>
                                    </div>
                                `;

                                setTimeout(() => {

                                    document
                                        .getElementById(
                                            'mensaje-toast'
                                        )
                                        .innerHTML = '';

                                }, 2000);
                            }

                        } catch (error) {

                            console.error(error);

                            document
                                .getElementById(
                                    'mensaje-toast'
                                )
                                .innerHTML = `
                                <div class="alert alert-danger">
                                    Error al agregar producto
                                </div>
                            `;
                        }
                    }
                );

            });

        });

        // Aumentar cantidad
        document.querySelectorAll('.aumentar-form')
            .forEach(form => {

                form.addEventListener(
                    'submit',
                    async function(e) {
                        e.preventDefault();

                        let id =
                            this.dataset.id;

                        await fetch(
                            '/carrito/aumentar/' + id, {
                                method: 'POST',

                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content,

                                    'Accept': 'application/json'
                                }
                            }
                        );

                        //location.reload();
                        await actualizarCarrito();
                    }
                );

            });

        // Disminuir cantidad
        document.querySelectorAll('.disminuir-form')
            .forEach(form => {

                form.addEventListener(
                    'submit',
                    async function(e) {
                        e.preventDefault();

                        let id =
                            this.dataset.id;

                        await fetch(
                            '/carrito/disminuir/' + id, {
                                method: 'POST',

                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content,

                                    'Accept': 'application/json'
                                }
                            }
                        );

                        await actualizarCarrito();
                    }
                );

            });

        // Eliminar producto
        document.querySelectorAll('.eliminar-form')
            .forEach(form => {

                form.addEventListener(
                    'submit',
                    async function(e) {
                        e.preventDefault();

                        let id =
                            this.dataset.id;

                        await fetch(
                            '/carrito/eliminar/' + id, {
                                method: 'POST',

                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content,

                                    'Accept': 'application/json'
                                }
                            }
                        );

                        await actualizarCarrito();
                    }
                );

            });
    </script>
@endsection
