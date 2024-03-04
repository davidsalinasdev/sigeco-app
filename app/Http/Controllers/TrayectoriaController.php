<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Unidadesorg;
use App\Models\Modalidades;
use App\Models\Procesoscont;
use App\Models\Pac;
use App\Models\Trayectoria;
use App\Models\Etapasproc;
use App\Models\Docsgen;
use App\Models\Listaverif;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TrayectoriaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crud-trayectoria', ['only' => ['index']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['create', 'store']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['edit', 'update']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['destroy']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['iniciarproc']]);
        //$this->middleware('permission:crud-trayectoria', ['only' => ['iniciarpac']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['recibirproc']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['derivarproc']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['seguirproc']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['storenew']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['storenewp']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['storerec']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['storeder']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['descargararch']]);
        $this->middleware('permission:crud-trayectoria', ['only' => ['descargarplanti']]);

    }

    public function index()
    {
        //buscamos en la BD la dependencia/unidad organizaciones del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_miuni = $unidadorg->id; //22;
        
        $procesosconts = DB::table('procesosconts')
        ->selectRaw('*, procesosconts.id as idproc, trayectorias.id as idtray, procesosconts.estado as estadoproc, trayectorias.estado as estadotray, procesosconts.observacion as observacionproc, trayectorias.observacion as observaciontray')
        ->join('trayectorias', 'procesosconts.id', '=', 'trayectorias.id_proceso')
        ->where(function ($query) use ($id_miuni) {
            $query->where('trayectorias.id_udestino', $id_miuni)
                  ->where('procesosconts.estado', 1)
                  ->where('trayectorias.atendido', 0)
                  ->whereIn('trayectorias.estado', ['iniciado', 'derivado']);//para recibir
        })
        ->orWhere(function ($query) use ($id_miuni) {
            $query->where('trayectorias.id_uactual', $id_miuni)
                  ->where('procesosconts.estado', 1)
                  ->where('trayectorias.atendido', 0)
                  ->where('trayectorias.estado', 'recibido');//para derivar o finalizar
        })
        //->paginate(10);
        ->orderBy('trayectorias.fecha_ing', 'desc')
        ->get();
               
        // echo '<pre>';
        // print_r($procesosconts);
        // echo '</pre>';
        // die();
        
        return view('trayectoria.index', compact('procesosconts'));
    }

    public function iniciarproc($id)
    {
        $procesosc = Procesoscont::find($id);
        return view('trayectoria.iniciar', compact('procesosc'));
    }

    public function iniciarpac($id)//no está en uso
    {
        $programa = Pac::find($id);
        return view('trayectoria.iniciarpac', compact('programa'));
    }

    public function recibirproc($idtray)
    {
        $trayec = Trayectoria::find($idtray);
        $procesosc = Procesoscont::find($trayec->id_proceso);
        return view('trayectoria.recibir', compact('trayec','procesosc'));
    }

    public function derivarproc($idtray)
    {
        $trayec = Trayectoria::find($idtray);
        $procesosc = Procesoscont::find($trayec->id_proceso);
        return view('trayectoria.derivar', compact('trayec','procesosc',));
    }

    public function seguirproc($idproc, $deproc)
    {
        
        $trayects = Trayectoria::select('*')
        ->where('id_proceso', '=', $idproc)
        ->where(function ($query) {
            $query->where('estado', 'iniciado')
                ->orWhere('estado', 'derivado')
                ->orWhere('estado', 'finalizado')
                ->orWhere(function ($query1) {
                    $query1->where('estado', '=', 'recibido')
                        ->where('atendido', '=', 0);
                });
        })
        ->orderBy('id_eactual')
        ->get();

        return view('trayectoria.seguir', compact('trayects','idproc', 'deproc'));
    }

    public function storenew(Request $request)
    {
        $idp = $request->idp;//id del proceso

        $procesosc = Procesoscont::find($idp);
        $procesosc->estado = 1;
        $procesosc->save();

        //registrar el inicio en la tabla trayectorias
        $idmod=$procesosc->id_mod;
        
        //etapa actual
        $eact = Etapasproc::select("*")
                            ->where('id_mod',$idmod)
                            ->where('nro_etapa',1)
                            ->first();

        //etapa siguiente
        $nesig=$eact->sig_etapa;
        $esig = Etapasproc::select("*")
                            ->where('id_mod',$idmod)
                            ->where('nro_etapa',$nesig)
                            ->first();

        $trayect = new Trayectoria();

        $trayect->id_proceso = $idp;
        $trayect->id_eanterior = $eact->id;
        $trayect->id_eactual = $eact->id;
        $trayect->id_esgte = $esig->id;
        $trayect->id_uorigen = $procesosc->id_unid;
        $trayect->id_uactual = $procesosc->id_unid;
        $trayect->id_udestino = $request->opciones;
        $trayect->fecha_ing = date('Y-m-d');
        $trayect->fecha_env = date('Y-m-d');
        $trayect->estado = "iniciado";
        $trayect->observacion = "";
        $trayect->atendido = 0;
        
        $trayect->save();

        //LISTA DE VERIFICACIÓN***********

        //documentos generados de la etapa actual
        $ideact = $eact->id;
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

                    $solonombre = pathinfo($namefile, PATHINFO_FILENAME);
                    $extension = pathinfo($namefile, PATHINFO_EXTENSION);

                    $fechcrea = date('dmYHis');
                    $namefile = $solonombre.$fechcrea.$cont.".".$extension;
                    
                    // Guardamos el archivo en una ubicación específica
                    //'public/files'
                    //'public/files/'
                    
                    // $archivo->move('files', $namefile);
                    // $path = 'files/' . $namefile;

                    $archivo->storeAs('files', $namefile); // Almacenar en la carpeta "public" de "storage"
                    $path = 'app/files/' . $namefile; // Ruta para acceder al archivo

                    $listaver = new Listaverif;
                    
                    $listaver->id_tray = $trayect->id;//recien se creo el registro de la trayectoria
                    $listaver->id_doc = $lista1[$i];

                    $listaver->namefile = $namefile;
                    $listaver->path = $path;
                    $listaver->ok = 1;
                    $listaver->observacion = "";
            
                    $listaver->save();

                }
                $i++;
            }
        }
   
        return redirect()->route('trayectoria.index');
    }

    public function storenewp($id)
    {
        //registrar el pac en la tabla procesosconts

        $programa = Pac::find($id);//id del pac

        $procesosc = new Procesoscont();
        
        $procesosc->id_unid = $programa->id_unid;//unidad solicitante
        $procesosc->id_mod = $programa->id_mod;
        $procesosc->id_pac = $programa->id;

        //formamos el nuevo codigo a asignar 
        $mod = Modalidades::find($programa->id_mod);
        $sigla = $mod->sigla;
        $cantregmod = Procesoscont::withTrashed()->where('id_mod', '=', $programa->id_mod)->count();
        $pcodigo = $cantregmod + 1;
        $gestion = date('Y');
        $procesosc->codigo = $sigla.$gestion."-".$pcodigo;

        $procesosc->tipo_cont = $programa->tipo_cont;
        $procesosc->objeto = $programa->objeto;
        $procesosc->precio_ref = $programa->precio_ref;
        $procesosc->gestion = $programa->gestion;
        $procesosc->fecha_reg = date('Y-m-d');
        $procesosc->estado = 1;
        $procesosc->observacion = $programa->observacion;
        $procesosc->save();

        //actualiza el estado de la tabla pacs
        //pac aprobado
        $programa->estado = 1;
        $programa->save();
        
        //registrar el inicio en la tabla trayectorias
        $idmod=$procesosc->id_mod;
                
        //etapa actual
        $eact = Etapasproc::select("*")
                            ->where('id_mod',$idmod)
                            ->where('nro_etapa',1)
                            ->first();

        //etapa siguiente
        $nesig=$eact->sig_etapa;
        $esig = Etapasproc::select("*")
                            ->where('id_mod',$idmod)
                            ->where('nro_etapa',$nesig)
                            ->first();

        $trayect = new Trayectoria();

        $trayect->id_proceso = $procesosc->id;//id del proceso recientemente registrado
        $trayect->id_eanterior = $eact->id;
        $trayect->id_eactual = $eact->id;
        $trayect->id_esgte = $esig->id;

        // //obtener id de unidad de contrataciones donde se origina el PAC
        // $nameUnidadorg = "ÁREA DE CONTRATACIONES MAYORES Y LICITACIONES"; //"UNIDAD DE CONTRATACIONES Y ADQUISICIONES";
        // $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        // //UNIDAD
        // $id_uorigen = $unidadorg->id; //22;

        //buscamos en la BD la dependencia/unidad organizaciones del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_uorigen = $unidadorg->id; //22;


        $trayect->id_uorigen = $id_uorigen; //unidad del administrador que da inicio al pac aprobado
        $trayect->id_uactual = $procesosc->id_unid;
        $trayect->id_udestino = $procesosc->id_unid;//unidad solicitante
        $trayect->fecha_ing = date('Y-m-d');
        $trayect->fecha_env = date('Y-m-d');
        $trayect->estado = "iniciado";
        $trayect->observacion = "";
        $trayect->atendido = 0;

        $trayect->save();

        // //LISTA DE VERIFICACIÓN***********

        // //documentos generados de la etapa actual
        // $ideact = $eact->id;
        // $resultados1 = Docsgen::where('id_etapa', $ideact)->get();

        // foreach ($resultados1 as $resultado1) {
        //     $lista1[] = $resultado1->id;

        // }

        
        // // Verificamos si se enviaron archivos
        // if ($request->hasFile('files')) {
        //     $archivos = $request->file('files');
        //     $cont = 0;
        //     $i = 0;
            
        //     // Procesamos cada archivo
        //     foreach ($archivos as $archivo) {
        //         $cont++;
        //         // Verificamos si el archivo es válido
        //         if ($archivo->isValid()) {
        //             // Obtenemos el nombre original del archivo
        //             $namefile = $archivo->getClientOriginalName();

        //             $solonombre = pathinfo($namefile, PATHINFO_FILENAME);
        //             $extension = pathinfo($namefile, PATHINFO_EXTENSION);

        //             $fechcrea = date('dmYHis');
        //             $namefile = $solonombre.$fechcrea.$cont.".".$extension;
                    
        //             // Guardamos el archivo en una ubicación específica
        //             //'public/files'
        //             //'public/files/'
                    
        //             // $archivo->move('files', $namefile);
        //             // $path = 'files/' . $namefile;

        //             $archivo->storeAs('files', $namefile); // Almacenar en la carpeta "public" de "storage"
        //             $path = 'app/files/' . $namefile; // Ruta para acceder al archivo

        //             $listaver = new Listaverif;
                    
        //             $listaver->id_tray = $trayect->id;//recien se creo el registro de la trayectoria
        //             $listaver->id_doc = $lista1[$i];

        //             $listaver->namefile = $namefile;
        //             $listaver->path = $path;
        //             $listaver->ok = 1;
        //             $listaver->observacion = "";
            
        //             $listaver->save();
        //         }
        //         $i++;
        //     }
        // }
 
        return redirect()->route('trayectoria.index');
    }

    public function storerec(Request $request)
    {
        $idtray = $request->idtray;

        $trayant = Trayectoria::find($idtray);
        $proceso = Procesoscont::find($trayant->id_proceso);
       
        $idmod = $proceso->id_mod;
        
        //etapa actual
        $eact = Etapasproc::select("*")
                            ->where('id_mod',$idmod)
                            ->where('id',$trayant->id_esgte)
                            ->first();
        
        //etapa siguiente
        $nesig = $eact->sig_etapa;
        if ($nesig <> 0){//si no es etapa final
            $esig = Etapasproc::select("*")
                                ->where('id_mod',$idmod)
                                ->where('nro_etapa',$nesig)
                                ->first();
        }

        $trayect = new Trayectoria();

        $trayect->id_proceso = $trayant->id_proceso;
        $trayect->id_eanterior = $trayant->id_eactual;
        $trayect->id_eactual = $trayant->id_esgte;
        
        if ($nesig <> 0){//si no es etapa final
            $trayect->id_esgte = $esig->id;
            $trayect->atendido = 0;
            $trayect->estado = "recibido";
        }else{//si es etapa final
            $trayect->id_esgte = 0;
            $trayect->atendido = 1;
            $trayect->estado = "finalizado";
        }
        
        $trayect->id_uorigen = $trayant->id_uactual;
        $trayect->id_uactual = $trayant->id_udestino;
        //$trayect->id_udestino = "";
        $trayect->fecha_ing = date('Y-m-d');
        //$trayect->fecha_env = "";
        $trayect->observacion = $request->observaciontray;
        
        $trayect->save();

        //se actualiza atendido=1 de trayectoria anterior 
        $trayant->atendido = 1;
        $trayant->save();

        return redirect()->route('trayectoria.index');
    }

    public function storeder(Request $request)
    {
        //muestra los datos que llegan del formulario
        // $data = $request->all();
        // dd($data);
        
        $idtray = $request->idtray;

        $trayant = Trayectoria::find($idtray);
       
        $trayect = new Trayectoria();

        $trayect->id_proceso = $trayant->id_proceso;
        $trayect->id_eanterior = $trayant->id_eanterior;
        $trayect->id_eactual = $trayant->id_eactual;
        $trayect->id_esgte = $trayant->id_esgte;
        $trayect->id_uorigen = $trayant->id_uorigen;
        $trayect->id_uactual = $trayant->id_uactual;

        //obtener el id de la unidad solicitante
        $proceso = Procesoscont::find($trayant->id_proceso);
        //obtener el nombre del documento
        $nom_doc = $request->nom_doc;
        
        //11-01-2024
        switch($nom_doc){
            case 'INFORME DE INEXISTENCIA DE ACTIVOS':
                $trayect->id_udestino =  $proceso->id_unid; //vuelve a la unidad solicitante
                break;
            case 'CERTIFICACIÓN PRESUPUESTARIA':
                $trayect->id_udestino =  $proceso->id_unid; //vuelve a la unidad solicitante
                break;
            default:
                $trayect->id_udestino = $request->opciones;
                break;
        }

        $trayect->fecha_ing = $trayant->fecha_ing;
        $trayect->fecha_env = date('Y-m-d');
        $trayect->estado = "derivado";
        $trayect->observacion = $request->observaciontray;
        $trayect->atendido = 0;
        
        $trayect->save();

        //se actualiza atendido=1 de trayectoria anterior 
        $trayant->atendido = 1;
        $trayant->save();

        //LISTA DE VERIFICACIÓN
        //documentos generados de la etapa actual
        $ideact = $trayant->id_eactual;
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

                    $solonombre = pathinfo($namefile, PATHINFO_FILENAME);
                    $extension = pathinfo($namefile, PATHINFO_EXTENSION);

                    $fechcrea = date('dmYHis');
                    $namefile = $solonombre.$fechcrea.$cont.".".$extension;
                    
                    // Guardamos el archivo en una ubicación específica
                    //'public/files'
                    //'public/files/'
                    
                    // $archivo->move('files', $namefile);
                    // $path = 'files/' . $namefile;

                    $archivo->storeAs('files', $namefile); // Almacenar en la carpeta "public" de "storage"
                    $path = 'app/files/' . $namefile; // Ruta para acceder al archivo

                    $listaver = new Listaverif;

                    $listaver->id_tray = $trayect->id;//recien se creo el registro de ñña trayectoria
                    $listaver->id_doc = $lista1[$i];

                    $listaver->namefile = $namefile;
                    $listaver->path = $path;
                    $listaver->ok = 1;
                    $listaver->observacion = "";
            
                    $listaver->save();

                }
                $i++;
            }
        }

        return redirect()->route('trayectoria.index');
        //return $idtray."hola".$nom_doc;
    }

    public function descargararch($id)
    {
        $archivo = Listaverif::find($id);

        if (!$archivo) {
            return abort(404); // Puede que quieras manejar el caso en que el archivo no se encuentra.
        }
    
        // Obten la ruta del archivo
        $ruta = $archivo->path; // Asumiendo que la ruta del archivo se almacena en la columna 'path'
    
        // Genera las cabeceras para la descarga
        $headers = [
            'Content-Type' => 'application/octet-stream', // Tipo MIME adecuado para tu archivo
            'Content-Disposition' => "attachment; filename={$archivo->namefile}", // Nombre del archivo
        ];
    
        return response()->download(storage_path($ruta), $archivo->namefile, $headers);

    }

    public function descargarplanti()
    {
        $arch = "informe de seleccion.docx";
        
        // Obten la ruta del archivo
        $ruta = "app/files/INFORME DE SELECCION DE PROVEEDOR.docx"; // Asumiendo que la ruta del archivo se almacena en la columna 'path'
    
        // Genera las cabeceras para la descarga
        $headers = [
            //'application/msword'); // o 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' para archivos DOCX
            'Content-Type' => 'octet-stream', // Tipo MIME adecuado para tu archivo
            'Content-Disposition' => "attachment; filename={$arch}", // Nombre del archivo
        ];
    
        //return response()->download(storage_path($ruta), $arch, $headers);
        return response()->file(storage_path($ruta), $headers);

    }
  
}
