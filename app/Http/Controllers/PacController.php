<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Procesoscont;
use App\Models\Docstec;
use App\Models\Det_docstec;
use App\Models\Pac;
use App\Models\Unidadesorg;

//use Barryvdh\DomPDF\PDF;
//use Barryvdh\DomPDF\Facade as PDF;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Support\Facades\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PacController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crud-pac', ['only' => ['index']]);
        $this->middleware('permission:crud-pac', ['only' => ['create', 'store']]);
        $this->middleware('permission:crud-pac', ['only' => ['edit', 'update']]);
        $this->middleware('permission:crud-pac', ['only' => ['destroy']]);
        $this->middleware('permission:crud-pac', ['only' => ['pdfpac']]);
    }

    public function index()
    {
        //listar todos los pacs no iniciados como procesos estado=0 y los aprobados con estado=1
        //pacs de todas las unidades
        //habilitado para usuario administrador de unidad de contrataciones

        //09-02-2024 registra cada unidad sus PACs

        //buscamos en la BD la dependencia/unidad organizacional del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_miuni = $unidadorg->id; //22;

        $programas = Pac::select("*")
            ->where('id_unid', $id_miuni)

            ->orderBy('fecha_reg', 'desc')
            ->get();
        //->paginate(10);

        // echo '<pre>';
        // print_r($programas);
        // echo '</pre>';
        // die();

        return view('pacs.index', compact('programas'));
    }

    public function create()
    {
        return view('pacs.crear');
    }

    public function store(Request $request)
    {
        $programa = new Pac();

        $this->validate($request, [
            'objeto' => 'required',
        ]);

        //09-02-2024 registra cada unidad sus PACs

        //buscamos en la BD la dependencia/unidad organizacional del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_miuni = $unidadorg->id; //22;

        $programa->id_unid = $id_miuni; //$request->unidades;//unidad solicitante
        $programa->id_mod = $request->opciones;
        $programa->tipo_cont = "";
        $programa->cuce = "";
        $programa->objeto = $request->objeto;
        $programa->precio_ref = floatval($request->precio_ref);
        $programa->forma_pago = "";
        $programa->org_finan = $request->org_finan;
        $programa->gestion = date('Y');
        $programa->mes_ini = $request->mes_ini;
        $programa->mes_pub = $request->mes_pub;
        $programa->fecha_reg = date('Y-m-d');
        $programa->estado = 0;
        $programa->observacion = "";

        $programa->save();

        return redirect()->route('pacs.index');
    }

    public function edit($id)
    {
        $programa = Pac::find($id);
        return view('pacs.editar', compact('programa'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'objeto' => 'required',
        ]);

        //09-02-2024 registra cada unidad sus PACs

        //buscamos en la BD la dependencia/unidad organizacional del usuario logueado
        $user = auth()->user();
        $nameUnidadorg = $user->dependencia;
        $unidadorg = Unidadesorg::where('nombre', $nameUnidadorg)->first();
        //UNIDAD
        $id_miuni = $unidadorg->id; //22;

        $programa = Pac::find($id);

        $programa->id_unid = $id_miuni; //$request->unidades;//unidad solicitante
        $programa->id_mod = $request->opciones;
        $programa->tipo_cont = "";
        $programa->cuce = "";
        $programa->objeto = $request->objeto;
        $programa->precio_ref = floatval($request->precio_ref);
        $programa->forma_pago = "";
        $programa->org_finan = $request->org_finan;
        $programa->gestion = date('Y');
        $programa->mes_ini = $request->mes_ini;
        $programa->mes_pub = $request->mes_pub;
        $programa->fecha_reg = date('Y-m-d');
        $programa->estado = 0;
        $programa->observacion = "";

        $programa->save();

        return redirect()->route('pacs.index');
    }

    public function destroy(string $id)
    {
        Pac::find($id)->delete();
        return redirect()->route('pacs.index');
    }

    public function pdfpac($id)
    {
        $programa = Pac::find($id);
        $pdf = PDF::loadView('pacs.pdfpac', compact('programa'));
        $pdf->setPaper('Letter');

        $filename = 'programa.pdf';
        return $pdf->stream($filename);
    }
}
