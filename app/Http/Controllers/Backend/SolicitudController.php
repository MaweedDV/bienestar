<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\SolicitudEntregada;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            'estado' => 'entregado'
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
