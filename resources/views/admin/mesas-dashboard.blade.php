@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1>Estado de Mesas</h1>

        <div class="row">

            @foreach ($mesas as $mesa)
                <div class="col-md-3">

                    <div class="card mb-3">

                        <div class="card-body text-center">

                            <h3>
                                Mesa {{ $mesa->numero }}
                            </h3>

                            @switch($mesa->estado)
                                @case('libre')
                                    <span class="badge bg-success">
                                        Libre
                                    </span>
                                @break

                                @case('pendiente')
                                    <span class="badge bg-warning">
                                        Pendiente
                                    </span>
                                @break

                                @case('preparando')
                                    <span class="badge bg-danger">
                                        Preparando
                                    </span>
                                @break

                                @case('listo')
                                    <span class="badge bg-primary">
                                        Listo
                                    </span>
                                @break

                                @default
                                    <span class="badge bg-secondary">
                                        {{ $mesa->estado }}
                                    </span>
                            @endswitch

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection
