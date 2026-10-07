<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\SolicitudEntregada;
use App\Mail\SolicitudRegistrada;
use App\Models\DetalleSolicitud;
use App\Models\SolicitudGas;
use App\Models\User;
use App\Models\ValesDeGas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $solicitudes = SolicitudGas::with('detalles')
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.sections.solicitudesDeGas.index', compact('solicitudes'));
    }

    public function historial()
    {

        $solicitudes = SolicitudGas::with('detalles')
            ->where('estado', 'entregado')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.sections.solicitudesDeGas.entregado', compact('solicitudes'));
    }

    public function buscar(Request $request)
    {
        $buscar = $request->get('q');

        $solicitudes = SolicitudGas::with('detalles')
            ->where('rut_funcionario', 'like', "%$buscar%")
            ->orWhere('nombre_funcionario', 'like', "%$buscar%")
            ->orWhere('fecha_solicitud', 'like', "%$buscar%")
            ->get();

        return view('backend.sections.solicitudesDeGas.parcial.lista', compact('solicitudes'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $funcionarios = User::where('role', 'funcionario')->where('estado', 1)->get();

        return view('backend.sections.solicitudesDeGas.createSelectFunc', compact('funcionarios'));
    }

    public function solicitudGasAdmin(request $request)
    {
        $tipoGas = ValesDeGas::all();
        $funcionario = User::where('id', $request->funcionario)->where('estado', 1)->first();

        return view('backend.sections.solicitudesDeGas.create', compact('funcionario', 'tipoGas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = User::where('id', $request->idFuncionario)->first();
        $solicitudes = SolicitudGas::where('rut_funcionario', $usuario->rut)->whereMonth('fecha_solicitud', date('m'))->whereYear('fecha_solicitud', date('Y'))->get();
        // dd($usuario);

        if($solicitudes->isEmpty() ) {
            $cantidadTotal = 0;

            foreach ($request->items as $item) {
            $cantidadTotal = $cantidadTotal + $item['cantidad'];
            }



            $solicitud = SolicitudGas::create([
                'rut_funcionario' => $usuario->rut,
                'nombre_funcionario' => $usuario->nombre." ".$usuario->apellido_paterno." ".$usuario->apellido_materno,
                'estado' => 'pendiente',
                'cantidadTotalVales' => $cantidadTotal,
                'fecha_solicitud' => now(),
            ]);


            foreach ($request->items as $item) {
                for ( $i = 0; $i < $item['cantidad']; $i++) {
                    $detalleSolicitud = DetalleSolicitud::create([
                        'solicitud_gas_id' => $solicitud->id,
                        'id_tipo_gas' => $item['tipoGas'],
                    ]);
                }
            }

            // $detalleSolicitud = DetalleSolicitud::create([
            //     'solicitud_gas_id' => $solicitud->id,
            //     'cantidad' => 2,
            //     'id_tipo_gas' => 1,
            // ]);
            $mail = $usuario->email;

            $solicitud->load('detalles'); // Cargar los detalles de la solicitud para incluirlos en el correo
            $solicitud->detalles->load('tipoGas'); // Cargar la relación con el tipo de gas para cada detalle

            //->>>enviar correo notificando nueva solicitud
            Mail::to($mail)->send(new SolicitudRegistrada($solicitud));

            return redirect()->route('dashboard')->with('success', 'Solicitud ingresada correctamente');

        }else{
            return redirect()->route('dashboard')->with('error', 'No se pueden ingresar nuevas solicitudes mientras haya una pendiente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detalles = DetalleSolicitud::where('solicitud_gas_id', $id)->get();
        $solicitud = SolicitudGas::findOrFail($id);
        $tipoGas = ValesDeGas::all()->keyBy('id');
        $cantidadTotal = DetalleSolicitud::where('solicitud_gas_id', $id)->count();

        // foreach ($detalles as $item) {
        //    $cantidadTotal = $cantidadTotal + $item->cantidad;
        // }
        return view('backend.sections.solicitudesDeGas.show', compact('detalles', 'solicitud', 'tipoGas', 'cantidadTotal'));
    }

    public function indexStock()
    {

        return view('backend.sections.solicitudesDeGas.stock.index');
    }

    public function entregadoDetalle(string $id)
    {
        $detalles = DetalleSolicitud::where('solicitud_gas_id', $id)->get();
        $solicitud = SolicitudGas::findOrFail($id);
        $tipoGas = ValesDeGas::all()->keyBy('id');
         $cantidadTotal = DetalleSolicitud::where('solicitud_gas_id', $id)->count();

        return view('backend.sections.solicitudesDeGas.entregadoDetalle', compact('detalles', 'solicitud', 'tipoGas', 'cantidadTotal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $solicitud = SolicitudGas::findOrFail($id);

        // 🔹 Actualizar códigos
        if ($request->has('codigos')) {
            foreach ($request->codigos as $detalleId => $codigo) {
                DetalleSolicitud::where('id', $detalleId)
                    ->update([
                        'codigo_gas' => $codigo
                    ]);
            }
        }

        // 🔹 Actualizar solicitud
        $solicitud->update([
            'fecha_entrega' => now(),
            'estado' => 'entregado',
            'observaciones' => $request->observaciones,
        ]);

        // 🔹 Obtener usuario
        $usuario = User::where('rut', $solicitud->rut_funcionario)->first();

        if ($usuario && $usuario->email) {

            // 🔹 Cargar relaciones
            $solicitud->load(['detalles.tipoGas']);

            // 🔹 Enviar correo
            Mail::to($usuario->email)
                ->send(new SolicitudEntregada($solicitud));
        }

        return redirect()
            ->route('solicitudesDeGas.index')
            ->with('success', 'Códigos guardados correctamente');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
