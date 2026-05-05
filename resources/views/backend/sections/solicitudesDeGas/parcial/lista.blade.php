                        <div class="block-content">
                           <table class="table table-bordered" id="tablaDetalle">
                                <thead>
                                    <tr>
                                        <th>N° solicitud</th>
                                        <th>Rut Funcionario</th>
                                        <th>Nombre Funcionario</th>
                                        <th>Cantidad Total de Vales</th>
                                        <th>Fecha de Solicitud</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudes as $solicitud)
                                        <tr>
                                            <td>{{ $solicitud->id }}</td>
                                            <td>{{ $solicitud->rut_funcionario }}</td>
                                            <td>{{ $solicitud->nombre_funcionario." ".$solicitud->apellido_funcionario }}</td>
                                            <td>{{ $solicitud->cantidadTotalVales }}</td>
                                            <td>{{ $solicitud->fecha_solicitud }}</td>
                                            <td>{{ $solicitud->estado }}</td>
                                            <td>
                                                <a href="{{ route('solicitudesDeGas.show', $solicitud->id) }}" class="btn btn-sm btn-primary">Entregar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
