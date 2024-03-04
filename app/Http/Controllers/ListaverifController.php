<?php

namespace App\Http\Controllers;

use App\Models\Trayectoria;
use App\Models\Docsgen;
use App\Models\Listaverif;
use Illuminate\Http\Request;

class ListaverifController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crud-listaverif', ['only' => ['index']]);
        $this->middleware('permission:crud-listaverif', ['only' => ['create', 'store']]);
        $this->middleware('permission:crud-listaverif', ['only' => ['edit', 'update']]);
        $this->middleware('permission:crud-listaverif', ['only' => ['destroy']]);
    }

    public function index(){
        //return view(Listaverif.index);
    }

    public function store(Request $request){

        $idtray = $request->idtray;
        $trayec = Trayectoria::find($idtray);

        //documentos generados de la etapa actual
        $ideact = $trayec->id_eactual;
        $resultados1 = Docsgen::where('id_etapa', $ideact)->get();

        foreach ($resultados1 as $resultado1) {
            $lista1[] = $resultado1->id;

        }

        // Verificamos si se enviaron archivos
        if ($request->hasFile('files')) {
            $archivos = $request->file('files');
            $cont = 0;
            $i = 0;
            // Procesamos cada archivo
            foreach ($archivos as $archivo) {
                $cont++;
                // Verificamos si el archivo es válido
                if ($archivo->isValid()) {
                    // Obtenemos el nombre original del archivo
                    $namefile = $archivo->getClientOriginalName();
                    $fechcrea = date('dmYHis');
                    $namefile = $namefile.$fechcrea.$cont;
                    
                    // Guardamos el archivo en una ubicación específica
                    //'public/files'
                    //'public/files/'
                    $archivo->move('files', $namefile);
                    $path = 'files/' . $namefile;

                    $save = new Listaverif;
                    
                    $save->id_tray = 1;//recien se creo el registro de ñña trayectoria
                    $save->id_doc = $lista1[$i];

                    $save->namefile = $namefile;
                    $save->path = $path;
                    $save->ok = 1;
                    $save->observacion = "";
            
                    $save->save();

                }
                $i++;
            }

        }
        return $archivo."  ".$save->path."<br>".$save->id_doc;
        //return redirect('')
    }
}
