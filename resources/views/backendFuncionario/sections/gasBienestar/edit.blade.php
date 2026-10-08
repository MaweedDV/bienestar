@extends('layouts.backendFuncionario')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div>
                    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">
                        Editar solicitud
                    </h1>
                </div>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Gas Bienestar</li>
                        <li class="breadcrumb-item">Solicitudes de Gas</li>
                        <li class="breadcrumb-item active">
                            Editar solicitud
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row items-push">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <form method="POST" action="{{ route('solicitudFuncionario.update', $solicitud->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="block-content">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label">
                                        Fecha ingreso solicitud:
                                        {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d-m-Y') }}
                                    </label>
                                </div>
                                <div class="col-3">
                                </div>
                                <div class="col-3">
                                    <label for="tipoGas" class="form-label">
                                        Seleccione Tipo de Gas:
                                    </label>
                                    <select class="form-select" id="tipoGas">
                                        <option value="">
                                            Seleccione una opción
                                        </option>
                                        @foreach ($tipoGas as $gas)
                                            <option value="{{ $gas->id }}">
                                                {{ $gas->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label class="form-label" for="cantidadGas">
                                        Cantidad:
                                    </label>
                                    <select class="form-select" id="cantidadGas">
                                        <option value="">
                                            Seleccione la cantidad
                                        </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">
                                        &nbsp;
                                    </label>
                                    <button type="button" class="btn btn-primary mt-4" onclick="agregarItem()">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr style="border: 0; border-top: 2px solid #000000; margin: 20px 0;">

                        <div class="block-content block-content-full text-center">
                            <h4>Detalle</h4>
                            <div class="block-content">
                                <table class="table table-bordered" id="tablaDetalle">
                                    <thead>
                                        <tr>
                                            <th>Tipo Gas</th>
                                            <th>Cantidad</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detalles as $index => $detalle)
                                            <tr>
                                                <td>
                                                    {{ $tipoGas->firstWhere('id', $detalle->id_tipo_gas)->descripcion ?? 'Sin información' }}
                                                </td>
                                                <td>
                                                    {{ $detalle->cantidad }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="eliminarFila(this)">
                                                        Eliminar
                                                    </button>

                                                    <input type="hidden" name="items[{{ $index }}][tipoGas]"
                                                        value="{{ $detalle->id_tipo_gas }}">

                                                    <input type="hidden" name="items[{{ $index }}][cantidad]"
                                                        value="{{ $detalle->cantidad }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row mb-4">
                                    <div class="col-4"></div>

                                    <div class="col-4">
                                        <h5>Retira un tercero</h5>

                                        <select name="retira_tercero" id="retira_tercero" class="form-control">

                                            <option value="no"
                                                {{ old('retira_tercero', $solicitud->retira_tercero) == 'no' ? 'selected' : '' }}>
                                                No
                                            </option>

                                            <option value="si"
                                                {{ old('retira_tercero', $solicitud->retira_tercero) == 'si' ? 'selected' : '' }}>
                                                Sí
                                            </option>

                                        </select>


                                        {{-- Contenedor del PDF --}}
                                        <div id="contenedor_pdf_tercero" class="mt-3" style="display: none;">

                                            {{-- Si ya existe un PDF --}}
                                            @if ($solicitud->pdf_tercero)
                                                <div class="alert alert-info mb-3">

                                                    <strong>
                                                        Autorización actual:
                                                    </strong>

                                                    <br>

                                                    <a href="{{ route('solicitudFuncionario.pdfTercero', $solicitud->id) }}?v={{ $solicitud->updated_at->timestamp }}"
                                                        target="_blank" class="btn btn-sm btn-info mt-2">

                                                        <i class="fa fa-file-pdf"></i>
                                                        Ver PDF actual

                                                    </a>

                                                </div>

                                                <label for="pdf_tercero" class="form-label">

                                                    Reemplazar autorización

                                                </label>
                                            @else
                                                <label for="pdf_tercero" class="form-label">

                                                    Adjuntar autorización en PDF

                                                </label>
                                            @endif


                                            <input type="file" name="pdf_tercero" id="pdf_tercero"
                                                class="form-control @error('pdf_tercero') is-invalid @enderror"
                                                accept="application/pdf">


                                            @error('pdf_tercero')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror


                                            <small class="text-muted">
                                                Solo se permiten archivos PDF de máximo 5 MB.
                                            </small>

                                        </div>

                                    </div>

                                    <div class="col-4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end">
                            <a href="{{ route('solicitudFuncionario.index') }}" class="btn btn-sm btn-alt-secondary">
                                volver
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    let contador = {{ $detalles->count() }};

    function obtenerTotal() {
        let total = 0;
        document.querySelectorAll('#tablaDetalle tbody tr')
            .forEach(fila => {
                let cantidad =
                    parseInt(fila.children[1].innerText);
                total += cantidad;
            });
        return total;
    }

    function agregarItem() {
        let tipoGas =
            document.getElementById('tipoGas').value;
        let cantidad =
            parseInt(
                document.getElementById('cantidadGas').value
            );

        if (!tipoGas || !cantidad) {
            alert(
                'Debes seleccionar tipo de gas y cantidad'
            );
            return;
        }

        let totalActual = obtenerTotal();

        if (totalActual + cantidad > 3) {
            alert(
                'No puedes agregar más de 3 vales en total'
            );
            return;
        }

        let tabla =
            document
            .getElementById('tablaDetalle')
            .getElementsByTagName('tbody')[0];

        let textoGas =
            document
            .getElementById('tipoGas')
            .selectedOptions[0]
            .text;

        let fila = tabla.insertRow();

        fila.innerHTML = `
            <td>${textoGas}</td>
            <td>${cantidad}</td>
            <td>
                <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    onclick="eliminarFila(this)">
                    Eliminar
                </button>

                <input
                    type="hidden"
                    name="items[${contador}][tipoGas]"
                    value="${tipoGas}">

                <input
                    type="hidden"
                    name="items[${contador}][cantidad]"
                    value="${cantidad}">
            </td>
        `;

        contador++;

        document.getElementById('tipoGas').value = "";
        document.getElementById('cantidadGas').value = "";
    }

    function eliminarFila(boton) {
        let fila = boton.closest('tr');
        fila.remove();
    }

    document.addEventListener('DOMContentLoaded', function() {

        const retiraTercero =
            document.getElementById('retira_tercero');

        const contenedorPdf =
            document.getElementById('contenedor_pdf_tercero');

        const inputPdf =
            document.getElementById('pdf_tercero');


        function mostrarOcultarPdf() {

            if (retiraTercero.value === 'si') {

                contenedorPdf.style.display = 'block';

            } else {

                contenedorPdf.style.display = 'none';

                /*
                 * Si había seleccionado un archivo nuevo
                 * y cambia nuevamente a "No",
                 * limpiamos el input.
                 */
                inputPdf.value = '';
            }
        }


        /*
         * Revisamos el valor cuando se carga
         * la página de edición.
         */
        mostrarOcultarPdf();


        /*
         * Revisamos cada vez que cambia
         * Sí / No.
         */
        retiraTercero.addEventListener(
            'change',
            mostrarOcultarPdf
        );

    });
</script>
