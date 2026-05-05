@extends('layouts.backendFuncionario')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">

            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div>
                    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Solicitudes de Gas</h1>

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
                  <a type="submit" class="btn btn-primary push mb-md-0" href="{{ route('solicitudFuncionario.create') }}"><i
                    class="fas fa-check"></i>
                Ingresar solicitud
                </a>
            </div>
            <div class="col-md-12">
                <div class="block-content">
                            <table class="table table-bordered" id="tablaDetalle">
                                <thead>
                                    <tr>
                                        <th>N° solicitud</th>
                                        <th>Estado</th>
                                        <th>Cantidad total de vales</th>
                                        <th>Fecha de ingreso</th>
                                        <th>Fecha de entrega</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudes as $solicitud)
                                        <tr>
                                            <td>{{ $solicitud->id }}</td>
                                            <td>{{ $solicitud->estado }}</td>
                                            <td>{{ $solicitud->cantidadTotalVales }}</td>
                                            <td>{{ $solicitud->fecha_solicitud }}</td>
                                            <td>{{ $solicitud->fecha_entrega ?? 'Pendiente' }}</td>
                                            <td>
                                                <a href="{{ route('solicitudFuncionario.show', $solicitud->id) }}" class="btn btn-sm btn-primary">Ver detalle</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
    </div>
@endsection

