<?php

namespace App\Http\Controllers\BackendFuncionario;

use App\Http\Controllers\Controller;
use App\Models\DetalleSolicitud;
use App\Models\SolicitudGas;
use App\Models\ValesDeGas;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudRegistrada;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SolicitudFuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitudes = SolicitudGas::where('rut_funcionario', auth()->user()->rut)->orderBy('created_at', 'desc')->get();

        return view('backendFuncionario.sections.gasBienestar.index', compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoGas = ValesDeGas::all();

        return view('backendFuncionario.sections.gasBienestar.create', compact('tipoGas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = auth()->user();
        $solicitudes = SolicitudGas::where('rut_funcionario', $usuario->rut)
            ->whereMonth('fecha_solicitud', date('m'))
            ->whereYear('fecha_solicitud', date('Y'))
            ->Where('estado', 'pendiente')
            ->get();


        if ($solicitudes->isEmpty()) {
            $cantidadTotal = 0;

            foreach ($request->items as $item) {
                $cantidadTotal = $cantidadTotal + $item['cantidad'];
            }



            $solicitud = SolicitudGas::create([
                'rut_funcionario' => $usuario->rut,
                'nombre_funcionario' => $usuario->nombre . " " . $usuario->apellido_paterno . " " . $usuario->apellido_materno,
                'estado' => 'pendiente',
                'cantidadTotalVales' => $cantidadTotal,
                'fecha_solicitud' => now(),
                'retira_tercero' => 'no', // Valor predeterminado, puedes cambiarlo según tus necesidades
            ]);


            foreach ($request->items as $item) {
                for ($i = 0; $i < $item['cantidad']; $i++) {
                    $detalleSolicitud = DetalleSolicitud::create([
                        'solicitud_gas_id' => $solicitud->id,
                        'id_tipo_gas' => $item['tipoGas'],
                        'retira_tercero' => 'no', // Valor predeterminado, puedes cambiarlo según tus necesidades
                    ]);
                }
            }

            // $detalleSolicitud = DetalleSolicitud::create([
            //     'solicitud_gas_id' => $solicitud->id,
            //     'cantidad' => 2,
            //     'id_tipo_gas' => 1,
            // ]);
            $mail = User::find(auth()->id())->email;

            $solicitud->load('detalles'); // Cargar los detalles de la solicitud para incluirlos en el correo
            $solicitud->detalles->load('tipoGas'); // Cargar la relación con el tipo de gas para cada detalle

            //->>>enviar correo notificando nueva solicitud
            Mail::to($mail)->send(new SolicitudRegistrada($solicitud));

            return redirect()->route('solicitudFuncionario.index')->with('success', 'Solicitud ingresada correctamente');
        } else {
            return redirect()->route('solicitudFuncionario.index')->with('error', 'No se pueden ingresar nuevas solicitudes mientras haya una pendiente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $solicitud = SolicitudGas::findOrFail($id);
        // $detalles = DetalleSolicitud::select(
        //     'id_tipo_gas',
        //     DB::raw('COUNT(*) as total')
        // )
        // ->where('solicitud_gas_id', $id)
        // ->groupBy('id_tipo_gas')
        // ->orderBy('id_tipo_gas', 'asc')
        // ->get();

        // $cantidadTotal = DetalleSolicitud::where('solicitud_gas_id', $id)->count();
        // $tipoGas = ValesDeGas::all()->keyBy('id');


        // return view('backendFuncionario.sections.gasBienestar.show', compact('solicitud', 'detalles', 'tipoGas', 'cantidadTotal'));

        $detalles = DetalleSolicitud::where('solicitud_gas_id', $id)->get();
        $solicitud = SolicitudGas::findOrFail($id);
        $tipoGas = ValesDeGas::all()->keyBy('id');
        $cantidadTotal = DetalleSolicitud::where('solicitud_gas_id', $id)->count();

        return view('backendFuncionario.sections.gasBienestar.show', compact('detalles', 'solicitud', 'tipoGas', 'cantidadTotal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $solicitud = SolicitudGas::where('id', $id)
            ->where('rut_funcionario', auth()->user()->rut)
            ->firstOrFail();


        $detalles = DetalleSolicitud::select(
            'id_tipo_gas',
            DB::raw('COUNT(*) as cantidad')
        )
            ->where('solicitud_gas_id', $id)
            ->groupBy('id_tipo_gas')
            ->get();


        $tipoGas = ValesDeGas::all();


        return view(
            'backendFuncionario.sections.gasBienestar.edit',
            compact(
                'solicitud',
                'detalles',
                'tipoGas'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $solicitud = SolicitudGas::where('id', $id)
            ->where('rut_funcionario', auth()->user()->rut)
            ->firstOrFail();


        /*
     * Validación del retiro por tercero y PDF.
     */
        $reglasPdf = [
            'nullable',
            'file',
            'mimes:pdf',
            'max:5120',
        ];

        /*
     * Si selecciona "Sí" y todavía no existe un PDF,
     * obligamos a adjuntar uno.
     */
        if (
            $request->retira_tercero === 'si' &&
            empty($solicitud->pdf_tercero)
        ) {
            $reglasPdf[0] = 'required';
        }


        $request->validate([

            'retira_tercero' => [
                'required',
                'in:si,no',
            ],

            'pdf_tercero' => $reglasPdf,

        ], [

            'retira_tercero.required' =>
            'Debes indicar si retira un tercero.',

            'pdf_tercero.required' =>
            'Debes adjuntar la autorización cuando retira un tercero.',

            'pdf_tercero.mimes' =>
            'La autorización debe ser un archivo PDF.',

            'pdf_tercero.max' =>
            'El PDF no puede superar los 5 MB.',

        ]);


        /*
     * Validamos que tenga al menos un vale.
     */
        if (!$request->has('items') || empty($request->items)) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'La solicitud debe contener al menos un vale de gas.'
                );
        }


        /*
     * Calculamos cantidad total de vales.
     */
        $cantidadTotal = 0;


        foreach ($request->items as $item) {

            $cantidadTotal += (int) $item['cantidad'];
        }


        /*
     * Máximo 3 vales.
     */
        if ($cantidadTotal > 3) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No puedes agregar más de 3 vales en total.'
                );
        }


        /*
     * Guardamos el PDF nuevo, si corresponde.
     */
        $nuevoPdf = null;

        if (
            $request->retira_tercero === 'si' &&
            $request->hasFile('pdf_tercero')
        ) {

            $nuevoPdf = $request
                ->file('pdf_tercero')
                ->store(
                    'autorizaciones_terceros',
                    'public'
                );
        }


        /*
     * Guardamos temporalmente la ruta del PDF anterior.
     */
        $pdfAnterior = $solicitud->pdf_tercero;


        DB::transaction(function () use (
            $request,
            $solicitud,
            $cantidadTotal,
            $nuevoPdf
        ) {

            /*
         * Datos que se actualizarán en la solicitud.
         */
            $datosActualizar = [

                'cantidadTotalVales' => $cantidadTotal,

                'retira_tercero' =>
                $request->retira_tercero,

            ];


            /*
         * Si retira un tercero y adjuntó un nuevo PDF,
         * guardamos la nueva ruta.
         */
            if (
                $request->retira_tercero === 'si' &&
                $nuevoPdf
            ) {

                $datosActualizar['pdf_tercero'] =
                    $nuevoPdf;
            }


            /*
         * Si NO retira un tercero,
         * quitamos el PDF de la solicitud.
         */
            if ($request->retira_tercero === 'no') {

                $datosActualizar['pdf_tercero'] =
                    null;
            }


            /*
         * Actualizamos la solicitud.
         */
            $solicitud->update(
                $datosActualizar
            );


            /*
         * Eliminamos todos los vales anteriores.
         */
            DetalleSolicitud::where(
                'solicitud_gas_id',
                $solicitud->id
            )->delete();


            /*
         * Guardamos nuevamente los vales
         * que quedaron en la tabla.
         */
            foreach ($request->items as $item) {

                for (
                    $i = 0;
                    $i < (int) $item['cantidad'];
                    $i++
                ) {

                    DetalleSolicitud::create([

                        'solicitud_gas_id' =>
                        $solicitud->id,

                        'id_tipo_gas' =>
                        $item['tipoGas'],

                    ]);
                }
            }
        });


        /*
     * Eliminamos el PDF anterior después de que
     * la actualización de base de datos fue exitosa.
     */

        // Si cambió de Sí a No.
        if (
            $request->retira_tercero === 'no' &&
            $pdfAnterior
        ) {

            if (
                Storage::disk('public')
                ->exists($pdfAnterior)
            ) {

                Storage::disk('public')
                    ->delete($pdfAnterior);
            }
        }


        /*
     * Si cargó un nuevo PDF, eliminamos
     * el anterior.
     */
        if (
            $nuevoPdf &&
            $pdfAnterior &&
            $nuevoPdf !== $pdfAnterior
        ) {

            if (
                Storage::disk('public')
                ->exists($pdfAnterior)
            ) {

                Storage::disk('public')
                    ->delete($pdfAnterior);
            }
        }


        return redirect()
            ->route('solicitudFuncionario.index')
            ->with(
                'success',
                'Solicitud actualizada correctamente'
            );
    }

    public function verPdfTercero(string $id)
    {
        $solicitud = SolicitudGas::where('id', $id)
            ->where('rut_funcionario', auth()->user()->rut)
            ->firstOrFail();

        if (!$solicitud->pdf_tercero) {
            abort(404, 'La solicitud no tiene un PDF adjunto.');
        }

        $ruta = storage_path(
            'app/public/' . $solicitud->pdf_tercero
        );

        if (!file_exists($ruta)) {
            abort(404, 'El archivo PDF no existe.');
        }

        return response()->file($ruta, [
            'Content-Type' => 'application/pdf',

            'Content-Disposition' =>
            'inline; filename="' . basename($ruta) . '"',

            'Cache-Control' =>
            'no-store, no-cache, must-revalidate, max-age=0',

            'Pragma' => 'no-cache',

            'Expires' => '0',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
