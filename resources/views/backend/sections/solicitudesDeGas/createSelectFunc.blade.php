@extends('layouts.backend')

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
               <form method="POST" action="{{ route('solicitudAdminsselected.create') }}">
                    @csrf
                    <div class="block-content">
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label" for=tan"example-ltf-email2">Fecha: {{ date('d-m-Y') }}</label>
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="example-select-floating"></label>
                            </div>
                            <div class="col-3">
                                    <label for="funcionario" class="form-label ">Seleccione funcionario:</label>
                                        <select class="form-select @error('funcionario') is-invalid @enderror"
                                        id="funcionario" name="funcionario" value="{{ old('funcionario') }}">
                                        <option value="" selected>Seleccione una opción</option>
                                        @foreach ($funcionarios as $funcionario)
                                            <option {{ old('funcionario') == $funcionario->id ? 'selected' : '' }} value="{{ $funcionario->id }}"> {{ $funcionario->nombre}} {{ $funcionario->apellido_paterno }} {{ $funcionario->apellido_materno }}</option>
                                        @endforeach
                                    </select>
                                    @error('funcionario')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary mt-4">Seleccionar Funcionario</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
