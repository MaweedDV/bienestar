<div class="modal fade" id="modal-block-fromleft" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromleft"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Nuevo Usuario</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="block-content">
                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="form-label" for="example-ltf-email2">Nombres</label>
                                <input type="text" class="form-control form-control" id="nombre" name="nombre"
                                    placeholder="Ingrese su nombre">
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-ltf-email2">Apellido Paterno</label>
                                <input type="text" class="form-control form-control" id="apellido_paterno" name="apellido_paterno"
                                    placeholder="Ingrese su apellido paterno">
                                @error('apellido_paterno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-ltf-email2">Apellido Materno</label>
                                <input type="text" class="form-control form-control" id="apellido_materno" name="apellido_materno"
                                    placeholder="Ingrese su apellido materno">
                                @error('apellido_materno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-ltf-email2">RUT</label>
                                <input type="text" class="form-control form-control" id="rut" name="rut"
                                    placeholder="Ingrese su RUT">
                                @error('rut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-select-floating">Dirección</label>
                                <select class="form-select" id="example-select-floating" name="id_direccion"
                                    aria-label="Floating label select example">
                                    <option selected="" disabled>Seleccione una dirección</option>
                                    <option value="1">Dirección 1</option>
                                    <option value="2">Dirección 2</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-select-floating">Area</label>
                                <select class="form-select" id="example-select-floating" name="id_area"
                                    aria-label="Floating label select example">
                                    <option selected="" disabled>Seleccione un área</option>
                                    <option value="1">Área 1</option>
                                    <option value="2">Área 2</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-select-floating">Calidad Juridica</label>
                                <select class="form-select" id="example-select-floating" name="id_calidadJuridica"
                                    aria-label="Floating label select example">
                                    <option selected="" disabled>Seleccione una calidad jurídica</option>
                                    <option value="1">Calidad Jurídica 1</option>
                                    <option value="2">Calidad Jurídica 2</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-select-floating">Rol</label>
                                <select class="form-select" id="example-select-floating" name="role"
                                    aria-label="Floating label select example">
                                    <option selected="" disabled>Seleccione un rol</option>
                                    <option value="admin">Admin</option>
                                    <option value="funcionario">Funcionario</option>
                                </select>
                            </div>
                              <div class="col-6">
                                <label class="form-label" for="example-ltf-email2">Telefono</label>
                                <input type="text" class="form-control form-control" id="telefono" name="telefono"
                                    placeholder="Ingrese su telefono">
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="example-ltf-email2">Correo electronico</label>
                                <input type="email" class="form-control form-control" id="email" name="email"
                                    placeholder="Ingrese su correo electronico">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="example-ltf-email2">Contraseña</label>
                                <input type="password" class="form-control form-control" id="password"
                                    name="password" placeholder="Ingrese su contraseña">
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="example-ltf-email2">Confirmar contraseña</label>
                                <input type="password" class="form-control form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirme su contraseña" />
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
