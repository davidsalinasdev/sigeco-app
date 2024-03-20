<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Benef;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class BenefController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:crud-benef', ['only' => ['index']]);
        $this->middleware('permission:crud-benef', ['only' => ['create', 'store']]);
        $this->middleware('permission:crud-benef', ['only' => ['edit', 'update']]);
        $this->middleware('permission:crud-benef', ['only' => ['destroy']]);
    }

    public function index()
    {
        $benefs = Benef::paginate(10); //Mostrar 5 registros por página
        return view('benef.index', compact('benefs'));
    }

    public function create()
    {
        return view('benef.crear');
    }

    public function store(Request $request)
    {

        $benef = new Benef();

        $this->validate($request, [
            'razonsocial' => 'required',
            'cinit' => 'required',
            'domicilio_fiscal' => 'required',
            'tipo_nit' => 'required',
        ]);

        //$etapasp = $request->all();

        $benef->razonsocial = $request->razonsocial;
        $benef->cinit = $request->cinit;
        $benef->domicilio_fiscal = $request->domicilio_fiscal;
        $benef->tipo_nit = $request->tipo_nit;

        $benef->observacion = "";

        $benef->save();

        return redirect()->route('benef.index');
    }

    public function edit($id)
    {
        $benef = Benef::find($id);
        return view('benef.editar', compact('benef'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'razonsocial' => 'required',
            'cinit' => 'required',
            'domicilio_fiscal' => 'required',
            'tipo_nit' => 'required',
        ]);

        //$input = $request->all();

        $benef = Benef::find($id);

        $benef->razonsocial = $request->razonsocial;
        $benef->cinit = $request->cinit;
        $benef->domicilio_fiscal = $request->domicilio_fiscal;
        $benef->tipo_nit = $request->tipo_nit;

        $benef->observacion = "";

        $benef->save();

        return redirect()->route('benef.index');
    }

    public function destroy(string $id)
    {
        Benef::find($id)->delete();
        return redirect()->route('benef.index');
    }
}
