<?php

namespace App\Http\Controllers;

use App\Models\Procesoscont;
use Exception;
use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{

    // Metodo que mostrara la vista de configuraciones
    function updated_esp_tecnicas()
    {
        return view('configuraciones.configuracion');
    }


    // Metodo buscar datos
    function buscarDatos(Request $request)
    {

        // 1.-Recoger los datos por post
        $params = (object) $request->all(); // Devulve un obejto
        $paramsArray = $request->all(); // Devulve un Array

        // echo '<pre>';
        // print_r($params->gestion_buscar);
        // echo '</pre>';
        // die();

        try {
            // Búsqueda que no distinga entre mayúsculas y minúsculas en Laravel Eloquent
            $proceso = Procesoscont::whereRaw('LOWER(codigo) = ?', strtolower($params->gestion_buscar))->first();

            $data = array(
                'code' => 200,
                'status' => 'success',
                'proceso' => $proceso
            );
        } catch (Exception $e) {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'error' => $e->getMessage(),
            );
        }
        return response()->json($data, $data['code']);
        // return view('configuracion', compact('procesosc'));
    }


    function editarEspTecnicas($id)
    {
        return view('configuraciones.editar-tecnicas', compact('id'));
    }
}
