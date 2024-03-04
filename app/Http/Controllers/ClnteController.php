<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clnte;
use Illuminate\Http\Request;

use Exception;

class ClnteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Clnte::all();
       
    }
    public function autenticar(Request $request)
    {
        $login = $request->login;
        $password = $request->password;

        $clnte = Clnte::select("*")
                        ->where('login', $login)
                        ->where('password', $password)
                        ->get();

        try {
            $datos = [
                'code' => 200,
                'status' => 'success',
                'message' => 'autenticación exitosa',
                'clnte' => $clnte,
                
            ];
        } catch (Exception $e) {
            $datos = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No existe el usuario',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($datos);

    }    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //recibe un request para guardar en la tabla clntes

        //validación en request
        /*
        $request->validate([
            'ci'      => 'required',
            'nombres' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
        ]);
        */

        //dd($request->all());//función que devuelve el valor de Request, parámetros solo muestra antes de grabar
        $clnte = new Clnte();
        $clnte->ci = $request->ci;
        $clnte->nombres = $request->nombres;
        $clnte->paterno =   $request->paterno;
        $clnte->materno = $request->materno;
        $clnte->celular = $request->celular;
        $clnte->domicilio = $request->domicilio;
        $clnte->cargo = $request->cargo;
        $clnte->dependencia = $request->dependencia;
        $clnte->estado = $request->estado;
        $clnte->save();
        return $clnte;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clnte $clnte
     * @return \Illuminate\Http\Response
     */
    public function show(Clnte $clnte)
    {
        return $clnte;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Clnte  $clnte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clnte $clnte)
    {
        //validación en request
        /*
        $request->validate([
            'ci'      => 'required',
            'nombres' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
        ]);
        */

        $clnte->ci = $request->ci;
        $clnte->nombres = $request->nombres;
        $clnte->paterno = $request->paterno;
        $clnte->materno = $request->materno;
        $clnte->celular = $request->celular;
        $clnte->domicilio = $request->domicilio;
        $clnte->cargo = $request->cargo;
        $clnte->dependencia = $request->dependencia;
        $clnte->estado = $request->estado;
        $clnte->update();

        return $clnte;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clnte  $clnte
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $clnte = Clnte::find($id);
        if(is_null($clnte))
        {
            return response()->json('No se pudo realizar correctamente la eliminacion',404);
        }
        $clnte->delete();
        return response()->noContent();//status Q 204, el servidor ha procesado con éxito la solicitud pero que nos devolverá en un contenido
    }
}
