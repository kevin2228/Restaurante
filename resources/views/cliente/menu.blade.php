@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h2>Mesa {{ $mesa->numero }}</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('carrito') }}" class="btn btn-primary mb-3">
            Ver Pedido
        </a>

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

                                <form action="{{ route('agregar.carrito') }}" method="POST">

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
@endsection
