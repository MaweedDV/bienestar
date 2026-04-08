<?php

namespace App\Http\Controllers\BackendFuncionario;

use App\Http\Controllers\Controller;
use App\Models\DetalleSolicitud;
use App\Models\SolicitudGas;
use App\Models\ValesDeGas;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class SolicitudFuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitudes = SolicitudGas::all();

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
        $cantidadTotal = 0;

        foreach ($request->items as $item) {
           $cantidadTotal = $cantidadTotal + $item['cantidad'];
        }


        $solicitud = SolicitudGas::create([
            'rut_funcionario' => '18935579-3',
            'nombre_funcionario' => 'Funcionario de Prueba',
            'estado' => 'pendiente',
            'cantidadTotalVales' => $cantidadTotal,
            'fecha_solicitud' => now(),
        ]);


        foreach ($request->items as $item) {
            $detalleSolicitud = DetalleSolicitud::create([
                'solicitud_gas_id' => $solicitud->id,
                'cantidad' => $item['cantidad'],
                'id_tipo_gas' => $item['tipoGas'],
            ]);
        }

        // $detalleSolicitud = DetalleSolicitud::create([
        //     'solicitud_gas_id' => $solicitud->id,
        //     'cantidad' => 2,
        //     'id_tipo_gas' => 1,
        // ]);

        dd($detalleSolicitud, $solicitud);

        return redirect()->route('solicitudFuncionario.index')->with('success', 'Solicitud ingresada correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $solicitud = SolicitudGas::findOrFail($id);
        $detalles = DetalleSolicitud::where('solicitud_gas_id', $id)->get();
        $tipoGas = ValesDeGas::all()->keyBy('id');
        $cantidadTotal = 0;

        foreach ($detalles as $item) {
           $cantidadTotal = $cantidadTotal + $item->cantidad;
        }


        return view('backendFuncionario.sections.gasBienestar.show', compact('solicitud', 'detalles', 'tipoGas', 'cantidadTotal'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
