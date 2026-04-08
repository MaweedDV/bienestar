@extends('layouts.backendFuncionario')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">

            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div>
                    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Ingresar solicitud</h1>

                </div>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Gas Bienestar</li>
                        <li class="breadcrumb-item active" aria-current="page">Solicitudes de Gas</li>
                        <li class="breadcrumb-item active" aria-current="page">Ingresar solicitud</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12">
                <div class="block block-rounded">
               <form method="POST" action="{{ route('solicitudFuncionario.store') }}">
                    @csrf
                    <div class="block-content">
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label" for=tan"example-ltf-email2">Fecha: 30-03-2026</label>
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="example-select-floating"></label>
                            </div>
                            <div class="col-3">
                                    <label for="tipoGas" class="form-label ">Seleccione Tipo de Gas:</label>
                                        <select class="form-select @error('tipoGas') is-invalid @enderror"
                                        id="tipoGas" name="tipoGas" value="{{ old('tipoGas') }}">
                                        <option value="" selected>Seleccione una opción</option>
                                        @foreach ($tipoGas as $gas)
                                            <option {{ old('tipoGas') == $gas->id ? 'selected' : '' }} value="{{ $gas->id }}"> {{ $gas->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    @error('tipoGas')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="example-ltf-email2">Cantidad:</label>
                                <select class="form-select" id="cantidadGas" name="cantidadGas">
                                    <option value="">Seleccione la cantidad</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="example-ltf-email2"></label>
                                <button type="button" class="btn btn-primary mt-4" onclick="agregarItem()">Agregar</button>
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
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-end ">
                        <button type="button" class="btn btn-sm btn-alt-secondary"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Guardar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    let contador = 0;

    function obtenerTotal() {
        let total = 0;

        document.querySelectorAll('#tablaDetalle tbody tr').forEach(fila => {
            let cantidad = parseInt(fila.children[1].innerText);
            total += cantidad;
        });

        return total;
    }

    function agregarItem() {
        let tipoGas = document.getElementById('tipoGas').value;
        let cantidad = parseInt(document.getElementById('cantidadGas').value);

        if (!tipoGas || !cantidad) {
            alert('Debes seleccionar tipo de gas y cantidad');
            return;
        }

        let totalActual = obtenerTotal();

        if (totalActual + cantidad > 3) {
            alert('No puedes agregar más de 3 vales en total');
            return;
        }

        let tabla = document.getElementById('tablaDetalle').getElementsByTagName('tbody')[0];

        let textoGas = document.getElementById('tipoGas').selectedOptions[0].text;

        let fila = tabla.insertRow();

        fila.innerHTML = `
            <td>${textoGas}</td>
            <td>${cantidad}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>

                <input type="hidden" name="items[${contador}][tipoGas]" value="${tipoGas}">
                <input type="hidden" name="items[${contador}][cantidad]" value="${cantidad}">
            </td>
        `;

        contador++;

        // limpiar campos
        document.getElementById('tipoGas').value = "";
        document.getElementById('cantidadGas').value = "";
    }

    function eliminarFila(boton) {
        let fila = boton.closest('tr');
        fila.remove();
    }
</script>

{{-- <script>
    let contador = 0;

    function agregarItem() {
        let idGas = document.getElementById('tipoGas').value;
        let tipoGas = document.getElementById('tipoGas').selectedOptions[0].text;
        let cantidad = document.getElementById('cantidadGas').value;

        if (!tipoGas || !cantidad) {
            alert('Debes seleccionar tipo de gas y cantidad');
            return;
        }

        let tabla = document.getElementById('tablaDetalle').getElementsByTagName('tbody')[0];

        let fila = tabla.insertRow();

        fila.innerHTML = `
            <td>${tipoGas}</td>
            <td>${cantidad}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>

                <input type="hidden" name="items[${contador}][tipoGas]" value="${tipoGas}">
                <input type="hidden" name="items[${contador}][idGas]" value="${idGas}">
                <input type="hidden" name="items[${contador}][cantidad]" value="${cantidad}">
            </td>
        `;

        contador++;

        // limpiar campos
        document.getElementById('tipoGas').value = "";
        document.getElementById('cantidadGas').value = "";
         document.getElementById('idGas').value = "";
    }

    function eliminarFila(boton) {
        let fila = boton.closest('tr');
        fila.remove();
    }
</script> --}}

