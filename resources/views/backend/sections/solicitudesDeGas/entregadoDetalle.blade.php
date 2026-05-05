@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">

            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div>
                    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Detalle de Solicitud</h1>

                </div>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Gas Bienestar</li>
                        <li class="breadcrumb-item active" aria-current="page">Solicitudes de Gas</li>
                        <li class="breadcrumb-item active" aria-current="page">Detalle de Solicitud</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12">
            <form method="POST" action="{{ route('solicitudes.update', $solicitud->id) }}">
                @csrf
                @method('PUT')
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="row mb-4" style="text-align: center; align-items: center;">
                            <h3>Solicitud N° {{ $solicitud->id }}</h3>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-center">
                        <div class="block-content">
                            <table class="table table-bordered" id="tablaDetalle">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Tipo Gas</th>
                                        <th>Codigo de Vale</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalles as $detalle)
                                        <tr>
                                            <td>{{ $detalle->id }}</td>
                                            <td>{{ $tipoGas[$detalle->id_tipo_gas]->descripcion }}</td>
                                            <td>{{ $detalle->codigo_gas ?? '' }}</td>
                                            {{-- <td><input type="text" name="codigos[{{$detalle->id}}]" class="form-control codigo-vale" placeholder="Codigo de Vale" value="{{$detalle->codigo_gas ?? ''}}"></td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$cantidadTotal}} vales de gas solicitados
                        </div>
                    </div>
                    <div class="block-content block-content-full text-end ">
                        <a href="{{ route('solicitudes.historial') }}" class="btn btn-sm btn-primary">Volver</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const inputs = document.querySelectorAll(".codigo-vale");

            inputs.forEach((input, index) => {

                input.addEventListener("keydown", function (e) {

                    if (e.key === "Enter") {
                        e.preventDefault(); // 🚫 evita que el form se envíe

                        // No avanzar si está vacío
                        if (this.value.trim() === "") return;

                        // Bloquear el input actual
                        this.readOnly = true;

                        // Ir al siguiente
                        if (inputs[index + 1]) {
                            inputs[index + 1].focus();
                        }
                    }

                });

            });

        });
    </script>
@endsection

