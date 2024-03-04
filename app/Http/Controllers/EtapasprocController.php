<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Etapasproc;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EtapasprocController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crud-etapasproc', ['only' => ['index']]);
        $this->middleware('permission:crud-etapasproc', ['only' => ['create', 'store']]);
        $this->middleware('permission:crud-etapasproc', ['only' => ['edit', 'update']]);
        $this->middleware('permission:crud-etapasproc', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $etapasprocs = Etapasproc::paginate(10); //Mostrar 5 registros por página
        return view('etapasproc.index', compact('etapasprocs'));
    }

    public function create()
    {
        return view('etapasproc.crear');
    }

    public function store(Request $request)
    {

        $etapasp = new Etapasproc();

        $this->validate($request, [
            'nro_etapa' => 'required',
            'nom_etapa' => 'required',
        ]);

        //$etapasp = $request->all();
        $etapasp->id_mod = $request->opciones;
        $etapasp->nro_etapa = $request->nro_etapa;
        $etapasp->nom_etapa = $request->nom_etapa;
        $etapasp->observacion = "";
        
        $etapasp->save();
        
        return redirect()->route('etapasproc.index');
     
    }

    public function edit($id)
    {
        $etapasp = Etapasproc::find($id);
        return view('etapasproc.editar', compact('etapasp'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nro_etapa' => 'required',
            'nom_etapa' => 'required',
        ]);

        //$input = $request->all();
        
        $etapasp = Etapasproc::find($id);
        $etapasp->id_mod = $request->opciones;
        $etapasp->nro_etapa = $request->nro_etapa;
        $etapasp->nom_etapa = $request->nom_etapa;
        $etapasp->observacion = "";
        
        $etapasp->save();

        return redirect()->route('etapasproc.index');
    }

    public function destroy(string $id)
    {
        Etapasproc::find($id)->delete();
        return redirect()->route('etapasproc.index');
    }
    

}
