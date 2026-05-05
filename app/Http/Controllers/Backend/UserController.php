<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('backend.sections.users.index');
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
       // dd($request->all());

        $this->validate($request, [
            'nombre' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'password_confirmation' => 'required|string|min:8|max:255',
        ]);

        $user = User::create([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'rut' => $request->rut,
                'id_direccion' => $request->id_direccion,
                'id_area' => $request->id_area,
                'telefono' => $request->telefono,
                'id_calidadJuridica' => $request->id_calidadJuridica,
                'role' => $request->role,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'estado' => 1,
            ]);


        if ($user instanceof Model) {
            toastr()->warning('Data has been saved successfully!');

            return to_route('users.index')->with('flash', 'Registro creado exitosamente!');
        }

        toastr()->error('An error has occurred please try again later.');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $id = decrypt($id);

        $user = User::findOrFail($id);

        if ($user instanceof Model) {
            $user->delete();

            toastr()->warning('Data has been deleted successfully!');

            return to_route('users.index')->with('flash', 'Registro eliminado exitosamente!');
        }
    }
}
