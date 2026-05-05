@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">

            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div>
                    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Solicitudes de Gas (PENDIENTES)</h1>

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
                            <label>(SOLICITUDES PENDIENTES)</label>
                            <div class="block-content block-content-full" style="text-align: left">
                                <a type="button" class="btn btn-primary push mb-md-0" href="{{ route('solicitudes.historial') }}">Historial entregados</a>
                                <br>
                                <br>
                                <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar...">
                            </div>

                                <div class="col-md-12">
                                    @include('backend.sections.solicitudesDeGas.parcial.lista')
                                </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection


