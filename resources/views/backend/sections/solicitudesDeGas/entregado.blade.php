@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">

            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div>
                    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Solicitudes de Gas (ENTREGADAS)</h1>

                </div>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Gas Bienestar</li>
                        <li class="breadcrumb-item active" aria-current="page">Solicitudes de Gas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12">
                <div class="block-content" style="text-align: center;">
                        <div class="block block-rounded">
                            <h3>DETALLE DE SOLICITUDES</h3>
                            <label>(SOLICITUDES ENTREGADAS)</label>
                            <br>
                            <div class="block-content block-content-full">
                                <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar...">
                            </div>
                            <div class="row items-push">
                                <div class="col-md-12">
                                     <div class="block-content">
                                        <table class="table table-bordered" id="tablaDetalle">
                                            <thead>
                                                <tr>
                                                    <th>N° solicitud</th>
                                                    <th>Rut Funcionario</th>
                                                    <th>Nombre Funcionario</th>
                                                    <th>Total de Vales</th>
                                                    <th>Fecha de Solicitud</th>
                                                    <th>Fecha de Entrega</th>
                                                    <th>Estado</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($solicitudes as $solicitud)
                                                    <tr>
                                                        <td>{{ $solicitud->id }}</td>
                                                        <td>{{ $solicitud->rut_funcionario }}</td>
                                                        <td>{{ $solicitud->nombre_funcionario }}</td>
                                                        <td>{{ $solicitud->cantidadTotalVales }}</td>
                                                        <td>{{ $solicitud->fecha_solicitud }}</td>
                                                        <td>{{ $solicitud->fecha_entrega }}</td>
                                                        <td>{{ $solicitud->estado }}</td>
                                                        <td>
                                                            <a href="{{ route('solicitudesDeGas.entregadoDetalle', $solicitud->id) }}" class="btn btn-sm btn-primary">Detalle</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="block-content block-content-full" style="text-align: left">
                                    <div class="block-content block-content-full" style="text-align: left">
                                        <a href="{{ route('solicitudesDeGas.index') }}" class="btn btn-sm btn-primary">Volver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

<script>
document.getElementById('buscador').addEventListener('keyup', function() {
    let query = this.value;

    fetch(`/solicitudes/buscar?q=${query}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('resultados').innerHTML = data;
        });
});
</script>
