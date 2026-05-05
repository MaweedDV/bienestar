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
        $cantidadTotal = 0;

        foreach ($request->items as $item) {
           $cantidadTotal = $cantidadTotal + $item['cantidad'];
        }

        $usuario = auth()->user();

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
        $mail = User::find(auth()->id())->email;

        $solicitud->load('detalles'); // Cargar los detalles de la solicitud para incluirlos en el correo
        $solicitud->detalles->load('tipoGas'); // Cargar la relación con el tipo de gas para cada detalle

        //->>>enviar correo notificando nueva solicitud
        Mail::to($mail)->send(new SolicitudRegistrada($solicitud));

        return redirect()->route('solicitudFuncionario.index')->with('success', 'Solicitud ingresada correctamente');

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
