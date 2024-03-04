<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unidadesorg;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UnidadesorgController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crud-unidadesorg', ['only' => ['index']]);
        $this->middleware('permission:crud-unidadesorg', ['only' => ['create', 'store']]);
        $this->middleware('permission:crud-unidadesorg', ['only' => ['edit', 'update']]);
        $this->middleware('permission:crud-unidadesorg', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $unidadesorgs = Unidadesorg::paginate(10); //Mostrar 5 registros por página
        return view('unidadesorg.index', compact('unidadesorgs'));
    }

    public function create()
    {
        return view('unidadesorg.crear');
    }

    public function store(Request $request)
    {

        $unidadesorg = new Unidadesorg();

        $this->validate($request, [
            'numuni' => 'required | numeric',
            'nombre' => 'required',
        ]);

        //$etapasp = $request->all();
        
        $unidadesorg->numuni = $request->numuni;
        $unidadesorg->nombre = $request->nombre;
        $unidadesorg->sigla = $request->sigla;
        $unidadesorg->dependencia = $request->dependencia;
        $unidadesorg->observacion = "";
        
        $unidadesorg->save();
        
        return redirect()->route('unidadesorg.index');
     
    }

    public function edit($id)
    {
        $unidadesorg = Unidadesorg::find($id);
        return view('unidadesorg.editar', compact('unidadesorg'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'numuni' => 'required',
            'nombre' => 'required',
        ]);

        //$input = $request->all();
        
        $unidadesorg = Unidadesorg::find($id);

        $unidadesorg->numuni = $request->numuni;
        $unidadesorg->nombre = $request->nombre;
        $unidadesorg->sigla = $request->sigla;
        $unidadesorg->dependencia = $request->dependencia;
        $unidadesorg->observacion = "";
        
        $unidadesorg->save();
        
        return redirect()->route('unidadesorg.index');

    }

    public function destroy(string $id)
    {
        Unidadesorg::find($id)->delete();
        return redirect()->route('unidadesorg.index');
    }

}
