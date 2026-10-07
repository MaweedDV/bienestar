<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Solicitud Registrada</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f6f9; padding:20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

        <!-- HEADER -->
        <div style="background:#2d89ef; color:#ffffff; padding:15px;">
            <h2 style="margin:0;">Solicitud de Gas Registrada</h2>
        </div>

        <!-- INFO -->
        <div style="padding:20px;">
            <p><strong>Funcionario:</strong> {{ $solicitud->nombre_funcionario }}</p>
            <p><strong>Fecha:</strong> {{ $solicitud->fecha_solicitud }}</p>
            <p><strong>Total Vales:</strong> {{ $solicitud->cantidadTotalVales }}</p>
        </div>

        <!-- TABLA -->
        <div style="padding:0 20px 20px 20px;">
            <h3 style="margin-bottom:10px;">Detalle de la Solicitud</h3>

            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <thead>
                    <tr style="background:#f1f1f1;">
                        {{-- <th style="padding:10px; border:1px solid #ddd; text-align:left;">#</th> --}}
                        <th style="padding:10px; border:1px solid #ddd; text-align:left;">Tipo Gas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitud->detalles as $index => $detalle)
                        <tr>
                            {{-- <td style="padding:10px; border:1px solid #ddd;">{{ $index + 1 }}</td> --}}
                            <td style="padding:10px; border:1px solid #ddd;">
                                {{ $detalle->tipoGas->descripcion ?? 'Sin nombre' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top:15px; font-size:14px; color:#555;">
                 <p style="margin-top:20px; font-size:14px; color:#555;">Tu solicitud ha sido ingresada. Puedes recoger tus vales a partir del mes de {{ ucfirst(\Carbon\Carbon::now()->addMonth()->locale('es')->translatedFormat('F')) }}</p>
                {{-- <p style="margin-top:20px; font-size:14px; color:#555;">Tu solicitud ha sido ingresada. Puedes recoger tus vales a partir del mes de {{today()->format("F")+1}}</p> --}}
            </div>
            <!-- Agrega un mensaje adicional si es necesario -->
            <!-- Por ejemplo, puedes informar al funcionario sobre el estado de su solicitud -->
            <!-- <p style="margin-top:20px; font-size:14px; color:#555;">Tu solicitud está siendo procesada y te notificaremos cuando esté lista para ser recogida.</p> -->
            <!-- O puedes incluir un mensaje personalizado basado en la información de la solicitud -->
            <!-- Por ejemplo, si la solicitud tiene un estado específico, puedes mostrar un mensaje diferente -->

            <!--     <p style="margin-top:20px; font-size:14px; color:#555;">Tu solicitud está pendiente de revisión. Te notificaremos cuando haya una actualización.</p> -->

            <!--     <p style="margin-top:20px; font-size:14px; color:#555;">Tu solicitud ha sido aprobada. Puedes recoger tus vales a partir del -->
            <!-- FOOTER -->
            <div style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;">
                Sistema de Solicitudes - Municipalidad
            </div>
        </div>



    </div>

</body>
</html>
