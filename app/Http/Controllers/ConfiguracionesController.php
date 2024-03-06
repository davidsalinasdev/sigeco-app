<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{

    // Metodo que mostrara la vista de configuraciones
    function updated_esp_tecnicas()
    {
        return view('configuraciones.configuracion');
    }


    // Metodo buscar datos
    function buscarDatos()
    {
    }
}
