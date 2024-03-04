@extends('adminlte::page')

@section('title', 'Iniciar PAC')

@section('content_header')
@stop

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Iniciar PAC</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                <strong>¡Revise los campos!</strong>
                                @foreach ($errors->all() as $error)
                                <span class="badge badge-danger">{{$error}}</span>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            @php
                                use App\Models\Unidadesorg;
                                use App\Models\Modalidades;
                                use App\Models\Etapasproc;
                                use App\Models\Docsgen;
                            @endphp
                            {!! Form::open(array('route'=>'trayectoria.storenewp', 'method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                            <div class="row">
                                <div class="col-12 col-xl-6 card">{{--PRIMERA COLUMNA--}}
                                    <div class="card-header">
                                        Formulario: Iniciar PAC
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $usolic = Unidadesorg::find($programa->id_unid);
                                                @endphp
                                                <label >Unidad Solicitante</label>
                                                {{$usolic->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label >Objeto</label>
                                                {{$programa->objeto}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $modalidad = Modalidades::find($programa->id_mod);
                                                @endphp
                                                <label>Modalidad</label>
                                                {{$modalidad->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Etapa anterior</label>
                                                Ninguna
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $idmod=$programa->id_mod;
                                                $eact = Etapasproc::select("*")
                                                                    ->where('id_mod',$idmod)
                                                                    ->where('nro_etapa',1)
                                                                    ->first();
                                                @endphp
                                                <label>Etapa Actual</label>
                                                {{$eact->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $nesig=$eact->sig_etapa;
                                                $esig = Etapasproc::select("*")
                                                                    ->where('id_mod',$idmod)
                                                                    ->where('nro_etapa',$nesig)
                                                                    ->first();
                                                @endphp
                                                <label>Etapa Sgte.</label>
                                                {{$esig->nom_etapa}}
                                            </div>
                                        </div>                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $uorigen = Unidadesorg::find($programa->id_unid);
                                                @endphp
                                                <label >Unidad Org. Anterior</label>
                                                {{$uorigen->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label >Unidad Org. Actual</label>
                                                {{$uorigen->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $options = Unidadesorg::all();
                                                @endphp
                                                <label for="opciones">Unidad Org. Destino</label>
                                                <select name="opciones" id="opciones" required style="width: 500px;">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-primary">Iniciar</button>
                                            <a class="btn btn-danger" href="{{route('pacs.index')}}">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6 card">{{--SEGUNDA COLUMNA--}}
                                    <div class="card-header">
                                        Lista de Verificación de Requisitos
                                    </div>
                                    <div class="card-body">
                                        {{--para dos columnas: class="row" class="col-xs-12 col-sm-6 col-md-6"--}}
                                        @php
                                            $idmod = $programa->id_mod;
                                            //etapa actual
                                            $eact = Etapasproc::select("*")
                                                                ->where('id_mod',$idmod)
                                                                ->where('nro_etapa',1)
                                                                ->first();//mejorar para mostrar lista y no solo el primero
                                            
                                            //documentos generados de la etapa actual
                                            $ideact = $eact->id;
                                            $resultados1 = Docsgen::where('id_etapa', $ideact)->get();
                                            
                                            foreach ($resultados1 as $resultado1) {
                                                $lista1[] = $resultado1->id;

                                            }

                                            //documentos generados de todas las etapas del proceso
                                            $resultados = DB::table('etapasprocs')
                                                ->join('docsgens', 'etapasprocs.id', '=', 'docsgens.id_etapa')
                                                ->where('etapasprocs.id_mod', $idmod)
                                                ->selectRaw('*, docsgens.id as iddoc') // Puedes seleccionar las columnas que desees aquí
                                                ->orderBy('nro_etapa', 'asc')
                                                ->get(); 
                                            
                                            $verifs = [];

                                            foreach ($resultados as $resultado) {
                                                $verifs[] = [
                                                    'iddoc' => $resultado->iddoc,
                                                    'nro_etapa' => $resultado->nro_etapa,
                                                    'nom_doc' => $resultado->nom_doc,
                                                ];
                                            }
                                        @endphp
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label >NºEtapa&nbsp;&nbsp;&nbsp;Doc.Generado</label>
                                                @foreach ($verifs as $verif)
                                                    <div class="form-check">
                                                        {{--se verifica si el documento está en la lista de documentos de la etapa, se tickea y se pinta de azul--}}
                                                        @if (in_array($verif['iddoc'], $lista1))
                                                            {!! Form::checkbox('verifs[]', $verif['iddoc'], true, ['class' => 'form-check-input', 'disabled' => 'disabled']) !!}
                                                            
                                                            {{$verif['nro_etapa']}}&nbsp;&nbsp;
                                                            {!! Form::label($verif['iddoc'], $verif['nom_doc'], ['class' => 'form-check-label', 'style' => 'color: blue;']) !!}
                                                            
                                                            @switch($verif['nom_doc'])
                                                    
                                                                @case('REGISTRO EN EL PAC')

                                                                    {{--se descarga un archivo reporte .pdf--}}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <a class="btn btn-primary" href="{{route('pacs.pdfpac', $programa->id)}}" target="_blank"><i class="fas fa-file-pdf">Ver</i></a>

                                                                    @break

                                                            @endswitch
                                                        @else
                                                            {{--si el documento no está en la lista de documentos de la etapa--}}
                                                            {{--se verifica si el iddoc es menor al mínimo id de los docs generados en la etapa, se tickea y no se pinta de azul--}}
                                                            @if ($verif['iddoc'] < min($lista1))
                                                                {!! Form::checkbox('verifs[]', $verif['iddoc'], true, ['class' => 'form-check-input', 'disabled' => 'disabled']) !!}
                                                            @else
                                                                {{--el id es mayor entonces no se tickea y no se pinta de azul--}}
                                                                {!! Form::checkbox('verifs[]', $verif['iddoc'], false, ['class' => 'form-check-input', 'disabled' => 'disabled']) !!}
                                                            @endif
                                                            
                                                            {{$verif['nro_etapa']}}&nbsp;&nbsp;
                                                            {!! Form::label($verif['iddoc'], $verif['nom_doc'], ['class' => 'form-check-label']) !!}
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="idp" value="{{$programa->id}}" />
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @stop
    
    @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stop
    
    @section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function () {
                $('#opciones').select2(); // Inicializar Select2 en tu select con el ID "opciones"
        });

    </script>
    @stop