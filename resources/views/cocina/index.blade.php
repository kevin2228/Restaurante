@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1>Cocina</h1>

        <div class="row">

            @foreach ($pedidos as $pedido)
                <div class="col-md-4">

                    <div class="card mb-4">

                        <div class="card-header">

                            Pedido
                            {{ $pedido->numero_pedido }}

                        </div>

                        <div class="card-body">

                            <h5>
                                Mesa
                                {{ $pedido->mesa->numero }}
                            </h5>

                            <hr>

                            @foreach ($pedido->detalles as $detalle)
                                <p>

                                    <strong>
                                        {{ $detalle->cantidad }}
                                    </strong>

                                    x

                                    {{ $detalle->producto->nombre }}

                                </p>
                            @endforeach

                            <hr>

                            <p>

                                Estado:

                                <strong>
                                    {{ strtoupper($pedido->estado) }}
                                </strong>

                            </p>

                            <form action="{{ route('cocina.estado', $pedido->id) }}" method="POST">

                                @csrf

                                <button class="btn btn-warning">

                                    Cambiar Estado

                                </button>

                            </form>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection
