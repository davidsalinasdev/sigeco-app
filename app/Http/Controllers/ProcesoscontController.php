<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Unidadesorg;
use App\Models\Modalidades;
use App\Models\Procesoscont;
use App\Models\Trayectoria;
use App\Models\Docsgen;
use App\Models\Docstec;
use App\Models\Det_docstec;
use App\Models\Listaverif;
use App\View\Components\Prueba;
//use Barryvdh\DomPDF\PDF;
//use Barryvdh\DomPDF\Facade as PDF;
//use PDF;
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class ProcesoscontController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crud-procesoscont', ['only' => ['index']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['create', 'store']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['edit', 'update']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['destroy']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['crear_docstec']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['store_docstec']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['store_docstec_os']]);
        //$this->middleware('permission:crud-procesoscont', ['only' => ['storeder_modal']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['pdfdt']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['pdfdt2']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['pdfos']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['pdfos2']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['pdfoc']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['pdfoc2']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['pdf_proc']]);
        $this->middleware('permission:crud-procesoscont', ['only' => ['autorizar']]);
    }

    public function index()
    {
        //buscamos en la BD la dependencia/unidad organizacional del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_miuni = $unidadorg->id; //22;

        $procesosconts = Procesoscont::select("*")
            ->where('id_unid', $id_miuni)
            //->where('estado',0)
            ->orderBy('fecha_reg', 'desc')
            ->get();

        return view('procesoscont.index', compact('procesosconts'));
    }

    public function create()
    {
        return view('procesoscont.crear');
    }

    public function store(Request $request)
    {
        $procesosc = new Procesoscont();

        $this->validate($request, [
            'objeto' => 'required',
        ]);

        //buscamos en la BD la dependencia/unidad organizaciones del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_miuni = $unidadorg->id; //22;

        $procesosc->id_unid = $id_miuni;

        $procesosc->id_mod = $request->opciones;

        //$procesosc->id_pac = $request->id_pac;

        //formamos el nuevo codigo a asignar 
        $mod = Modalidades::find($request->opciones);
        $sigla = $mod->sigla;
        $cantregmod = Procesoscont::withTrashed()->where('id_mod', '=', $request->opciones)->count();
        $pcodigo = $cantregmod + 1;
        $gestion = date('Y');
        $procesosc->codigo = $sigla . $gestion . "-" . $pcodigo;

        $procesosc->tipo_cont = ""; //$request->tipo_cont;
        $procesosc->objeto = $request->objeto;
        $procesosc->precio_ref = floatval($request->precio_ref);
        $procesosc->gestion = date('Y');
        $procesosc->fecha_reg = date('Y-m-d');
        $procesosc->estado = 0;
        $procesosc->observacion = "";
        $procesosc->autorizado = 0;

        $procesosc->save();

        return redirect()->route('procesoscont.index');
    }

    public function edit($id)
    {
        $procesosc = Procesoscont::find($id);
        return view('procesoscont.editar', compact('procesosc'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'objeto' => 'required',
        ]);

        $procesosc = Procesoscont::find($id);

        //buscamos en la BD la dependencia/unidad organizaciones del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_miuni = $unidadorg->id; //22;

        $procesosc->id_unid = $id_miuni;

        //$procesosc->id_mod = $request->opciones;
        //$procesosc->id_pac = $request->id_pac;
        $procesosc->tipo_cont = ""; //$request->tipo_cont;
        $procesosc->objeto = $request->objeto;
        $procesosc->precio_ref = floatval($request->precio_ref);
        $procesosc->gestion = date('Y');
        $procesosc->fecha_reg = date('Y-m-d');
        $procesosc->estado = 0;
        $procesosc->observacion = "";

        $procesosc->save();

        return redirect()->route('procesoscont.index');
    }

    public function destroy(string $id)
    {
        Procesoscont::find($id)->delete();
        return redirect()->route('procesoscont.index');
    }

    public function crear_docstec($idp)
    {
        return view('procesoscont.crear_docstec', compact('idp'));
    }

    public function store_docstec(Request $request)
    {

        $doctec = new Docstec();

        $idproc = $request->idp;

        $doctec->id_proc = $idproc;
        $doctec->nom_doc = $request->nomdoc;
        $doctec->fecha_crea = date('Y-m-d');
        $doctec->plazo_ent = $request->plazo_entrega;
        $doctec->garantia = $request->garantia;
        $doctec->lugmed_ent = $request->lugar_entrega;
        $doctec->otro1 = $request->otro1;
        $doctec->otro2 = $request->otro2;
        $doctec->observacion = $request->observacion;
        $doctec->total = floatval($request->total); //completar


        DB::beginTransaction();

        try {

            $doctec->save();
            $items1 = $request->item1;
            $productos1 = $request->producto1;
            $unidades1 = $request->unidad1;
            $cantidades1 = $request->cantidad1;
            $precios1 = $request->precio1;
            $subtotales1 = $request->subtotal1;

            $litems1 = count($items1);
            $lproductos1 = count($productos1);
            $lunidades1 = count($unidades1);
            $lcantidades1 = count($cantidades1);
            $lprecios1 = count($precios1);
            $lsubtotales1 = count($subtotales1);

            $longs = [$litems1, $lproductos1, $lunidades1, $lcantidades1, $lprecios1, $lsubtotales1];
            $maximo = max($longs);

            for ($indice = 0; $indice < $maximo; $indice++) {

                $det_doctec = new Det_docstec();

                $det_doctec->id_docstec = $doctec->id; //recien creado
                $det_doctec->item = isset($items1[$indice]) ? $items1[$indice] : null;
                $det_doctec->descripcion = isset($productos1[$indice]) ? $productos1[$indice] : null;
                $det_doctec->unidad = isset($unidades1[$indice]) ? $unidades1[$indice] : null;
                $det_doctec->cantidad = isset($cantidades1[$indice]) ? $cantidades1[$indice] : null;
                $det_doctec->precio = isset($precios1[$indice]) ? $precios1[$indice] : null;
                $det_doctec->subtotal = isset($subtotales1[$indice]) ? $subtotales1[$indice] : null;

                // Codigo añadido por DAVID-UGE
                $det_doctec->disponibilidad = 0;
                $det_doctec->cant_no_disponible = isset($cantidades1[$indice]) ? $cantidades1[$indice] : null;
                $det_doctec->new_sub_total = isset($subtotales1[$indice]) ? $subtotales1[$indice] : null;

                $det_doctec->save();
            }

            //recibimos datos para derivar
            $idtray = $request->idtray;

            //22-01-2024
            $nom_doc = $request->nomdoc;

            //22-01-2024
            switch ($nom_doc) {
                case 'ESPECIFICACIONES TÉCNICAS':
                    //obtener el id de la unidad solicitante
                    $proceso = Procesoscont::find($idproc);
                    $idunid_dest = $proceso->id_unid; //en especificaciones técnicas retorna a la unidad solicitante 
                    break;
                default:
                    $idunid_dest = $request->opcionesm; // se deriva a la unidad seleccionada
                    break;
            }

            $obstray = $request->observaciontray;
            $resulder = $this->storeder_modal($idtray, $idunid_dest, $obstray, "");

            $iddoc = $doctec->id;

            DB::commit();

            $datos = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Se guardó correctamente',
                //'iddoc' => $iddoc,
                //'doctec' =>  $doctec,
                'derivacion' => $resulder,

            ];
        } catch (Exception $e) {

            DB::rollback();
            $datos = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se guardó correctamente',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($datos);
    }

    public function store_docstec_os(Request $request)
    {
        // //muestra los datos que llegan del formulario
        // $data = $request->all();
        // dd($data);

        $idproc = $request->idp;

        try {
            //recibimos datos para derivar
            $idtray = $request->idtray;

            //22-01-2024
            $nom_doc = $request->nomdoc;
            $benef = $request->benef;
            $docref = $request->docref;

            if ($nom_doc == 'INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE SERVICIO') {
                //se actualiza BD Procesos, columna beneficiario, columnan doc referencial
                $procesob = Procesoscont::find($idproc);
                $procesob->benef = $benef;
                $procesob->docref = $docref;
                $procesob->save();
            }

            //22-01-2024
            switch ($nom_doc) {
                case 'ESPECIFICACIONES TÉCNICAS':
                    //obtener el id de la unidad solicitante
                    $proceso = Procesoscont::find($idproc);
                    $idunid_dest = $proceso->id_unid; //en especificaciones técnicas retorna a la unidad solicitante 
                    break;
                default:
                    $idunid_dest = $request->opcionesm; // se deriva a la unidad seleccionada
                    break;
            }

            $obstray = $request->observaciontray;

            $archivos = "no entra";

            //prepramos achivos recibidos para mandar en storeder_modal

            $archivos = $request->filem1;
            // if ($request->hasFile('filem1')) {
            //     $archivos = $request->file('filem1');
            // }

            $resulder = $this->storeder_modal($idtray, $idunid_dest, $obstray, $archivos);

            $datos = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Se guardó correctamente',
                //'iddoc' => $iddoc,
                //'doctec' =>  $doctec,
                'idtray' => $idtray,
                'idunid_dest' => $idunid_dest,
                'obstray' => $obstray,
                'derivacion' => $archivos,
                'resulder' => $resulder,
            ];
        } catch (Exception $e) {
            $datos = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se guardó correctamente',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($datos);
    }

    public function store_docstec_oc(Request $request)
    {
        // //muestra los datos que llegan del formulario
        // $data = $request->all();
        // dd($data);

        $contenido = $request->contenido;

        $idproc = $request->idp;

        // Iniciar la transacción
        DB::beginTransaction();

        try {

            //recibimos datos para derivar
            $idtray = $request->idtray;

            //22-01-2024
            $nom_doc = $request->nomdoc;
            $benef = $request->benefoc;
            $docref = $request->docrefoc;

            if ($nom_doc == 'REPORTE DE PRECIOS E INEXISTENCIAS - INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE COMPRA') {
                //se actualiza BD Procesos, columna beneficiario, columnan doc referencial
                $procesob = Procesoscont::find($idproc);
                $procesob->benef = $benef;
                $procesob->docref = $docref;
                $procesob->save();
            }

            //22-01-2024
            switch ($nom_doc) {
                case 'ESPECIFICACIONES TÉCNICAS':
                    //obtener el id de la unidad solicitante
                    $proceso = Procesoscont::find($idproc);
                    $idunid_dest = $proceso->id_unid; //en especificaciones técnicas retorna a la unidad solicitante 
                    break;
                default:
                    $idunid_dest = $request->opcionesmoc; // se deriva a la unidad seleccionada
                    break;
            }

            $obstray = $contenido; //observaciontrayoc;

            $archivos = "no entra";

            //prepramos achivos recibidos para mandar en storeder_modal

            $archivos = $request->filem1;
            // if ($request->hasFile('filem1')) {
            //     $archivos = $request->file('filem1');
            // }

            $resulder = $this->storeder_modal($idtray, $idunid_dest, $obstray, $archivos);

            // Finalizar la transacción
            DB::commit();

            $datos = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Se guardó correctamente',
                //'iddoc' => $iddoc,
                //'doctec' =>  $doctec,
                'idtray' => $idtray,
                'idunid_dest' => $idunid_dest,
                'obstray' => $obstray,
                'derivacion' => $archivos,
                'resulder' => $resulder,
                'contenido' => $contenido,
            ];
        } catch (Exception $e) {

            // En caso de error, revertir la transacción
            DB::rollBack();

            $datos = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se guardó correctamente',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($datos);
    }

    public function storeder_modal($idtray, $idunid_dest, $obstray, $archivos)
    {

        $trayant = Trayectoria::find($idtray); //idtray viene como parámetro

        $trayect = new Trayectoria();

        $trayect->id_proceso = $trayant->id_proceso;
        $trayect->id_eanterior = $trayant->id_eanterior;
        $trayect->id_eactual = $trayant->id_eactual;
        $trayect->id_esgte = $trayant->id_esgte;
        $trayect->id_uorigen = $trayant->id_uorigen;
        $trayect->id_uactual = $trayant->id_uactual;
        $trayect->id_udestino = $idunid_dest; //viene como parámetro
        $trayect->fecha_ing = $trayant->fecha_ing;
        $trayect->fecha_env = date('Y-m-d');
        $trayect->estado = "derivado";
        $trayect->observacion = $obstray; //viene como parámetro
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
        if ($archivos != null && $archivos != '') {
            $cont = 0;
            $i = 0;

            // Procesamos cada archivo
            foreach ($archivos as $namefile) {
                $cont++;

                // Limpiamos la cadena para extraer solo el nombre del archivo
                $namefile = basename($namefile);

                // Verificamos si el archivo es válido
                if (!empty($namefile)) {
                    // Obtenemos el nombre original del archivo
                    //$namefile = $archivo->getClientOriginalName();

                    $solonombre = pathinfo($namefile, PATHINFO_FILENAME);
                    $extension = pathinfo($namefile, PATHINFO_EXTENSION);

                    $fechcrea = date('dmYHis');
                    $namefile = $solonombre . $fechcrea . $cont . "." . $extension;

                    // Guardamos el archivo en una ubicación específica
                    //'public/files'
                    //'public/files/'

                    // $archivo->move('files', $namefile);
                    // $path = 'files/' . $namefile;

                    //$archivo->storeAs('filesm', $namefile); // Almacenar en la carpeta "public" de "storage"
                    $path = 'app/files/' . $namefile; // Ruta para acceder al archivo
                    $path1 = 'files/' . $namefile; // Ruta para acceder al archivo

                    //Storage::put($path, '');
                    Storage::put($path1, '');

                    $listaver = new Listaverif;

                    $listaver->id_tray = $trayect->id; //recien se creo el registro de la trayectoria
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
        return "procesado"; //redirect()->route('trayectoria.index');
    }

    public function pdfdt($id)
    {

        $doctec = Docstec::find($id);

        // Decodificar la cadena JSON en un array PHP
        $entrega = json_decode($doctec->plazo_ent, true);

        $valorDias = $entrega['plzo_entrega']['dias'] ?? null;
        $valorTextoEntrega = $entrega['plzo_entrega']['textoEntrega'] ?? null;

        if ($valorDias !== null && $valorTextoEntrega !== null) {
            // Ambas partes de la concatenación no son nulas
            $doctec->plazo_ent = $valorDias . ' ' . $valorTextoEntrega;
        }


        $pdf = PDF::loadView('procesoscont.pdfdt', compact('doctec'));
        $pdf->setPaper('Letter');

        $filename = 'doctec.pdf';
        return $pdf->stream($filename);
    }

    public function pdfdt2($id)
    {
        $nomd = "ESPECIFICACIONES TÉCNICAS";
        $doctec = Docstec::select("*")
            ->where('id_proc', $id)
            ->where('nom_doc', $nomd)
            ->first();

        // Decodificar la cadena JSON en un array PHP
        $entrega = json_decode($doctec->plazo_ent, true);

        $valorDias = $entrega['plzo_entrega']['dias'] ?? null;
        $valorTextoEntrega = $entrega['plzo_entrega']['textoEntrega'] ?? null;

        if ($valorDias !== null && $valorTextoEntrega !== null) {
            // Ambas partes de la concatenación no son nulas
            $doctec->plazo_ent = $valorDias . ' ' . $valorTextoEntrega;
        }

        $pdf = PDF::loadView('procesoscont.pdfdt', compact('doctec'));
        $pdf->setPaper('Letter');

        $filename = 'doctec.pdf';
        return $pdf->stream($filename);
    }

    public function pdfos($id, $fecha)
    {

        if ($fecha == 'dateCustom') {
            // Obtener la fecha actual
            $fechaActual = Carbon::now();
            // Formatear la fecha según tus necesidades
            $fechaFormateada = $fechaActual->toDateString(); // Formato: YYYY-MM-DD
            // También puedes formatear la fecha en otros formatos
            $fecha = $fechaActual->format('d/m/Y'); // Formato: DD/MM/YYYY
        }

        $fecha = Carbon::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');

        $doctec = Docstec::find($id);

        // Decodificar la cadena JSON en un array PHP
        $entrega = json_decode($doctec->plazo_ent, true);
        $valorDias = $entrega['plzo_entrega']['dias'] ?? null;
        $valorTextoEntrega = $entrega['plzo_entrega']['textoEntrega'] ?? null;

        if ($valorDias !== null && $valorTextoEntrega !== null) {
            // Ambas partes de la concatenación no son nulas
            $doctec->plazo_ent = $valorDias . ' ' . $valorTextoEntrega;
        }

        $pdf = PDF::loadView('procesoscont.pdfos', compact('doctec', 'fecha'));
        $pdf->setPaper('Letter');

        $filename = 'doctec.pdf';
        return $pdf->stream($filename);
    }

    public function pdfos2($id)
    {
        $nomd = "ESPECIFICACIONES TÉCNICAS";

        $doctec = Docstec::select("*")
            ->where('id_proc', $id)
            ->where('nom_doc', $nomd)
            ->first();

        // Decodificar la cadena JSON en un array PHP
        $entrega = json_decode($doctec->plazo_ent, true);
        $valorDias = $entrega['plzo_entrega']['dias'] ?? null;
        $valorTextoEntrega = $entrega['plzo_entrega']['textoEntrega'] ?? null;

        if ($valorDias !== null && $valorTextoEntrega !== null) {
            // Ambas partes de la concatenación no son nulas
            $doctec->plazo_ent = $valorDias . ' ' . $valorTextoEntrega;
        }

        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        // Formatear la fecha según tus necesidades
        $fechaFormateada = $fechaActual->toDateString(); // Formato: YYYY-MM-DD

        // También puedes formatear la fecha en otros formatos
        $fecha = $fechaActual->format('d/m/Y'); // Formato: DD/MM/YYYY

        $pdf = PDF::loadView('procesoscont.pdfos', compact('doctec', 'fecha'));
        $pdf->setPaper('Letter');

        $filename = 'doctec.pdf';
        return $pdf->stream($filename);
    }

    public function pdfoc($id, $fecha)
    {

        if ($fecha == 'dateCustom') {
            // Obtener la fecha actual
            $fechaActual = Carbon::now();
            // Formatear la fecha según tus necesidades
            $fechaFormateada = $fechaActual->toDateString(); // Formato: YYYY-MM-DD
            // También puedes formatear la fecha en otros formatos
            $fecha = $fechaActual->format('d/m/Y'); // Formato: DD/MM/YYYY
        }

        $fecha = Carbon::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');

        $doctec = Docstec::find($id);

        // Decodificar la cadena JSON en un array PHP
        $entrega = json_decode($doctec->plazo_ent, true);
        $valorDias = $entrega['plzo_entrega']['dias'] ?? null;
        $valorTextoEntrega = $entrega['plzo_entrega']['textoEntrega'] ?? null;

        if ($valorDias !== null && $valorTextoEntrega !== null) {
            // Ambas partes de la concatenación no son nulas
            $doctec->plazo_ent = $valorDias . ' ' . $valorTextoEntrega;
        }

        $pdf = PDF::loadView('procesoscont.pdfoc', compact('doctec', 'fecha'));
        $pdf->setPaper('Letter');

        $filename = 'doctec.pdf';
        return $pdf->stream($filename);
    }

    public function pdfoc2($id)
    {
        $nomd = "ESPECIFICACIONES TÉCNICAS";
        $doctec = Docstec::select("*")
            ->where('id_proc', $id)
            ->where('nom_doc', $nomd)
            ->first();

        // Decodificar la cadena JSON en un array PHP
        $entrega = json_decode($doctec->plazo_ent, true);
        $valorDias = $entrega['plzo_entrega']['dias'] ?? null;
        $valorTextoEntrega = $entrega['plzo_entrega']['textoEntrega'] ?? null;

        if ($valorDias !== null && $valorTextoEntrega !== null) {
            // Ambas partes de la concatenación no son nulas
            $doctec->plazo_ent = $valorDias . ' ' . $valorTextoEntrega;
        }

        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        // Formatear la fecha según tus necesidades
        $fechaFormateada = $fechaActual->toDateString(); // Formato: YYYY-MM-DD

        // También puedes formatear la fecha en otros formatos
        $fecha = $fechaActual->format('d/m/Y'); // Formato: DD/MM/YYYY

        $pdf = PDF::loadView('procesoscont.pdfoc', compact('doctec', 'fecha'));
        $pdf->setPaper('Letter');

        $filename = 'doctec.pdf';
        return $pdf->stream($filename);
    }

    public function pdf_proc($id)
    {
        $proceso = Procesoscont::find($id);

        // echo '<pre>';
        // print_r($proceso);
        // echo '</pre>';
        // die();

        $pdf = PDF::loadView('procesoscont.pdf_proc', compact('proceso'));
        $pdf->setPaper('Letter');

        $filename = 'proceso.pdf';
        return $pdf->stream($filename);
    }

    public function autorizar($idproc, $idtray)
    {
        try {
            $procesosc = Procesoscont::find($idproc);
            if (!$procesosc) {
                abort(404); // O manejar de otra manera, como redirigir o mostrar un mensaje de error.
            }

            $procesosc->autorizado = 1;
            $procesosc->save();

            $trayec = Trayectoria::find($idtray);
            return view('trayectoria.derivar', compact('trayec', 'procesosc',));

            //return redirect()->route('trayectoria.index');
            //return redirect()->route('trayectoria/'.$idtray.'/derivar');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Generación de pdf DSP-UGE
    function pdfInexAct($id)
    {
        $doctec = Docstec::where('id_proc', $id)->get();



        // Envia datos a la vista
        $pdf = PDF::loadView('procesoscont.pdf_inex_act', compact('doctec'));
        $pdf->setPaper('Letter');

        $filename = 'doctinexact.pdf';
        return $pdf->stream($filename);
    }
}
