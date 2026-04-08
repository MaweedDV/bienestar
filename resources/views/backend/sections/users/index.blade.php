@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">

            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div>
                    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Usuarios</h1>

                </div>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Mantenedores</li>
                        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary push mb-md-0" data-bs-toggle="modal"
                    data-bs-target="#modal-block-fromleft">Crear Usuario</button>
            </div>
            <div class="col-md-12">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@include('backend.sections.users.modal')

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
