@extends('adminlte::page')

@section('title', 'Recibir Proceso')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h4 class="page__heading p-3 text-uppercase">Recibir Proceso</h3>
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
                        {!! Form::open(array('route'=>'trayectoria.storerec', 'method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-12 col-xl-6">
                                <div class="card p-2">
                                    <div class="card-header">
                                        Formulario: Recibir Proceso
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Código:</label>
                                                {{$procesosc->codigo}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $usolic = Unidadesorg::find($procesosc->id_unid);
                                                @endphp
                                                <label>Unidad Solicitante:</label>
                                                {{$usolic->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Objeto:</label>
                                                {{$procesosc->objeto}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $modalidad = Modalidades::find($procesosc->id_mod);
                                                @endphp
                                                <label>Modalidad:</label>
                                                {{$modalidad->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Etapa anterior:</label>
                                                @php
                                                $eant = Etapasproc::find($trayec->id_eactual);
                                                @endphp
                                                {{$eant->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $eact = Etapasproc::find($trayec->id_esgte);
                                                @endphp
                                                <label>Etapa Actual:</label>
                                                {{$eact->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $idmod = $procesosc->id_mod;
                                                $nesig = $eact->sig_etapa;
                                                if ($nesig <> 0){
                                                    $esig = Etapasproc::select("*")
                                                    ->where('id_mod',$idmod)
                                                    ->where('nro_etapa',$nesig)
                                                    ->first();
                                                    }
                                                    @endphp
                                                    <label>Etapa Siguiente:</label>
                                                    @if ($nesig <> 0)
                                                        {{$esig->nom_etapa}}
                                                        @else
                                                        Fin del proceso
                                                        @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $uorigen = Unidadesorg::find($trayec->id_uactual);
                                                @endphp
                                                <label>Unidad Org. Anterior:</label>
                                                {{$uorigen->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $uactual = Unidadesorg::find($trayec->id_udestino);
                                                @endphp
                                                <label>Unidad Org. Actual:</label>
                                                {{$uactual->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="observaciontray">Observación:</label>
                                                {!! Form::textarea('observaciontray', null, array('class'=>'form-control', 'rows' => 4, 'style' => 'width: 60%;')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-primary" id="recibir-proceso">Recibir</button>
                                            <a class="btn btn-danger" href="{{route('trayectoria.index')}}">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">

                                <div class="card p-2">
                                    <div class="card-header">
                                        Lista de Verificación de Requisitos
                                    </div>
                                    <div class="card-body">
                                        {{--para dos columnas: class="row" class="col-xs-12 col-sm-6 col-md-6"--}}
                                        @php
                                        //documentos generados de la etapa actual
                                        $ideact = $eact->id;
                                        $resultados1 = Docsgen::where('id_etapa', $ideact)->get();

                                        foreach ($resultados1 as $resultado1) {
                                        $lista1[] = $resultado1->id;
                                        }

                                        //documentos generados de todas las etapas del proceso
                                        $idmod = $procesosc->id_mod;
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
                                                <label>NºEtapa&nbsp;&nbsp;&nbsp;Doc.Generado</label>
                                                @foreach ($verifs as $verif)
                                                <div class="form-check">

                                                    {{--se verifica si el documento está en la lista de documentos de la etapa, se tickea y se pinta de azul--}}
                                                    @if (in_array($verif['iddoc'], $lista1))
                                                    {!! Form::checkbox('verifs[]', $verif['iddoc'], false, ['class' => 'form-check-input', 'disabled' => 'disabled']) !!}

                                                    {{$verif['nro_etapa']}}&nbsp;&nbsp;

                                                    @if ($verif['nom_doc'] <> 'FIN')
                                                        {!! Form::label($verif['iddoc'], $verif['nom_doc'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."Requisito a completar..", ['class' => 'form-check-label', 'style' => 'color: blue;']) !!}
                                                        @else
                                                        {!! Form::label($verif['iddoc'], $verif['nom_doc'], ['class' => 'form-check-label', 'style' => 'color: blue;']) !!}
                                                        @endif
                                                        @else
                                                        {{--si el documento no está en la lista de documentos de la etapa--}}
                                                        {{--se verifica si el iddoc es menor al mínimo id de los docs generados en la etapa, se tickea y no se pinta de azul--}}

                                                        {{--se verifica si se tickea o no--}}
                                                        @if ($verif['iddoc'] < min($lista1)) {!! Form::checkbox('verifs[]', $verif['iddoc'], true, ['class'=> 'form-check-input', 'disabled' => 'disabled']) !!}
                                                            @else
                                                            {{--el id es mayor entonces no se tickea y no se pinta de azul--}}
                                                            {!! Form::checkbox('verifs[]', $verif['iddoc'], false, ['class' => 'form-check-input', 'disabled' => 'disabled']) !!}
                                                            @endif

                                                            {{--no se pinta de azul--}}
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
                        </div>
                        <input type="hidden" name="idtray" value="{{$trayec->id}}" />
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
@stop

@section('js')
<!-- Validando el boton recibir proceso al iniciar -->
<script>
    $(document).ready(function() {
        $('form').submit(function() {
            // Deshabilita el botón de enviar después del clic
            $('#recibir-proceso').prop('disabled', true);
        });
    });
</script>
@stop