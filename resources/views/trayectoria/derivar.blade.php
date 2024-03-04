@extends('adminlte::page')

@section('title', 'Derivar Proceso')

@section('content_header')
@stop

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Derivar Proceso</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    {{-- <div class="card"> --}}
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
                                use App\Models\Procesoscont;
                                use App\Models\Etapasproc;
                                use App\Models\Docsgen;
                                use App\Models\Docstec;
                            @endphp
                            {!! Form::open(array('route'=>'trayectoria.storeder', 'method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                            {{-- {!! Form::open(array('route'=>'listaverif.store', 'method'=>'POST', 'enctype'=>'multipart/form-data')) !!} --}}
                            <div class="row">
                                <div class="col-12 col-xl-6 card">{{--PRIMERA COLUMNA--}}
                                    <div class="card-header">
                                        Formulario: Derivar Proceso
                                    </div>
                                    <div class="card-body">
                                        {{--para dos columnas: class="row" class="col-xs-12 col-sm-6 col-md-6"--}}
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label >Código</label>
                                                {{$procesosc->codigo}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $usolic = Unidadesorg::find($procesosc->id_unid);
                                                @endphp
                                                <label >Unidad Solicitante</label>
                                                {{$usolic->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label >Objeto</label>
                                                {{$procesosc->objeto}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $modalidad = Modalidades::find($procesosc->id_mod);
                                                @endphp
                                                <label>Modalidad</label>
                                                {{$modalidad->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Etapa anterior</label>
                                                @php
                                                $eant = Etapasproc::find($trayec->id_eanterior);
                                                @endphp
                                                {{$eant->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $eact = Etapasproc::find($trayec->id_eactual);
                                                @endphp
                                                <label>Etapa actual</label>
                                                {{$eact->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $esig = Etapasproc::find($trayec->id_esgte);
                                                @endphp
                                                <label>Etapa siguiente</label>
                                                {{$esig->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $uorigen = Unidadesorg::find($trayec->id_uorigen);
                                                @endphp
                                                <label >Unidad Org. Anterior</label>
                                                {{$uorigen->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $uactual = Unidadesorg::find($trayec->id_uactual);
                                                @endphp
                                                <label >Unidad Org. Actual</label>
                                                {{$uactual->nombre}}
                                            </div>
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
                                            $nom_doc = "";
                                            
                                            //documentos generados de la etapa actual
                                            $ideact = $trayec->id_eactual;
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
                                        
                                        {{--CHECKLIST--}}
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
                                                                @case('INICIO DE ACTIVIDADES PREVIAS')
                                                                    {{--BOTON Ver/Imprimir--}}
                                                                    <a class="btn btn-primary" id="impBtn" href="{{route('procesoscont.pdf_proc', $procesosc->id)}}" target="_blank">
                                                                        <i class="far fa-file-pdf"></i>
                                                                        Ver Proceso
                                                                    </a>

                                                                    @break
                                                                @case('ESPECIFICACIONES TÉCNICAS')
                                                                    {{-- Script para ocultar el elemento --}}
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            // Ocultar el elemento al cargar la página
                                                                            var unidadOrgContainer = document.getElementById('unidadOrgContainer');
                                                                            if (unidadOrgContainer) {
                                                                                unidadOrgContainer.style.display = 'none';
                                                                            }
                                                                            var observacionContainer = document.getElementById('observacionContainer');
                                                                            if (observacionContainer) {
                                                                                observacionContainer.style.display = 'none';
                                                                            }
                                                                            var btnDerivar = document.getElementById('btnDerivar');
                                                                            if (btnDerivar) {
                                                                                btnDerivar.style.display = 'none';
                                                                            }
                                                                            var btnCancelar = document.getElementById('btnCancelar');
                                                                            if (btnCancelar) {
                                                                                btnCancelar.style.display = 'none';
                                                                            }
                                                                        });
                                                                    </script>

                                                                    {{--verificamos si ya existe el documento técnico en la BD--}}
                                                                    @php
                                                                        $nom_doc = $verif['nom_doc'];
                                                                        $doctec = Docstec::select("*")
                                                                                            ->where('id_proc', $procesosc->id)
                                                                                            ->where('nom_doc', $nom_doc)
                                                                                            ->first();
                                                                            
                                                                        
                                                                        //print_r($doctec);
                                                                    @endphp

                                                                    {{-----SI EXISTE EL DOC ESPECIFICACIONES TÉCNICAS-----}}
                                                                    @if ($doctec)

                                                                        {{--BOTON Ver/Imprimir--}}
                                                                        <a class="btn btn-primary" id="impBtn" href="{{route('procesoscont.pdfdt', $doctec->id)}}" target="_blank">
                                                                            <i class="far fa-file-pdf"></i>
                                                                            Imprimir
                                                                        </a>
                                                                    @else
                                                                        {{--BOTON MODAL--}}
                                                                        <button type="button" class="btn btn-primary" id="crearBtn" data-toggle="modal" data-target="#modal-xl">
                                                                            + Elaborar
                                                                        </button>

                                                                        <!-- Botón oculto que se mostrará después de cerrar el modal -->
                                                                        <a class="btn btn-primary d-none" id="impBtn2" href="{{route('procesoscont.pdfdt2', $procesosc->id)}}" target="_blank">
                                                                            <i class="far fa-file-pdf"></i>
                                                                            Imprimir
                                                                        </a>
                                                                    @endif
                                                                    
                                                                    @break
                                                                @case('INFORME DE INEXISTENCIA DE ACTIVOS')
                                                                    {{-- Script para ocultar el elemento --}}
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            // Ocultar el elemento por defecto al cargar la página
                                                                            var unidadOrgContainer = document.getElementById('unidadOrgContainer');
                                                                            if (unidadOrgContainer) {
                                                                                unidadOrgContainer.style.display = 'none';
                                                                            }
                                                                            $('#opciones').removeAttr('required');
                                                                        });
                                                                    </script>
                                                                    @php
                                                                        $nom_doc = $verif['nom_doc'];
                                                                    @endphp
                                                                    
                                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple >
                                                                    @error('file')
                                                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                                    @enderror
                                                                    
                                                                    @break
                                                                @case('CERTIFICACIÓN PRESUPUESTARIA')
                                                                    {{-- Script para ocultar el elemento --}}
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            // Ocultar el elemento por defecto al cargar la página
                                                                            var unidadOrgContainer = document.getElementById('unidadOrgContainer');
                                                                            if (unidadOrgContainer) {
                                                                                unidadOrgContainer.style.display = 'none';
                                                                            }
                                                                            $('#opciones').removeAttr('required');
                                                                        });
                                                                    </script>
                                                                    @php
                                                                        $nom_doc = $verif['nom_doc'];
                                                                    @endphp
                                                                    
                                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple >
                                                                    @error('file')
                                                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                                    @enderror

                                                                    @break
                                                                @case('AUTORIZACIÓN DE INICIO')
                                                                    @if ($procesosc->autorizado == 1)
                                                                        <label  style="font-size: 13px; color:rgb(56, 141, 116);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            INICIO AUTORIZADO
                                                                        </label>              
                                                                    @else
                                                                        {{--BOTON Autorizar--}}
                                                                        <a href="{{ route('procesoscont.autorizar', ['idproc' => $procesosc->id, 'idtray' => $trayec->id]) }}"
                                                                            class="btn btn-success"
                                                                            onclick="confirmarAutorizacion()">
                                                                            <i class="fas fa-check-double"></i>Autorizar
                                                                        </a>

                                                                        <script>
                                                                            function confirmarAutorizacion() {
                                                                                if (confirm('¿Está seguro de autorizar el inicio?')) {
                                                                                    console.log('autorizará');
                                                                                    window.location.href = "{{ route('procesoscont.autorizar', ['idproc' => $procesosc->id, 'idtray' => $trayec->id]) }}";
                                                                                }
                                                                            }
                                                                        </script>
                                                                    @endif
                                                                    
                                                                    @break
                                                                
                                                                @case('INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE SERVICIO')
                                                                    {{-- Script para ocultar el elemento --}}
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            // Ocultar el elemento al cargar la página
                                                                            var unidadOrgContainer = document.getElementById('unidadOrgContainer');
                                                                            if (unidadOrgContainer) {
                                                                                unidadOrgContainer.style.display = 'none';
                                                                            }
                                                                            var observacionContainer = document.getElementById('observacionContainer');
                                                                            if (observacionContainer) {
                                                                                observacionContainer.style.display = 'none';
                                                                            }
                                                                            var btnDerivar = document.getElementById('btnDerivar');
                                                                            if (btnDerivar) {
                                                                                btnDerivar.style.display = 'none';
                                                                            }
                                                                            var btnCancelar = document.getElementById('btnCancelar');
                                                                            if (btnCancelar) {
                                                                                btnCancelar.style.display = 'none';
                                                                            }
                                                                        });
                                                                    </script>
                                                                    
                                                                    {{--verificamos si ya existe el beneficiario en la BD--}}
                                                                    @php
                                                                    $proc = Procesoscont::find($procesosc->id);
                                                                    $benef = $proc->benef;
                                                                    
                                                                    //se envía las especificacines técnicas para generar orden de servicio
                                                                    $doctec = Docstec::select("*")
                                                                                        ->where('id_proc', $procesosc->id)
                                                                                        ->where('nom_doc', "ESPECIFICACIONES TÉCNICAS")
                                                                                        ->first();

                                                                    @endphp

                                                                    {{-----SI EXISTE EL BENEFICIARIO-----}}
                                                                    @if ($benef)
                                                                        {{--BOTON Ver/Imprimir--}}
                                                                        <a class="btn btn-primary" id="impBtnOS" href="{{route('procesoscont.pdfos', $doctec->id)}}" target="_blank">
                                                                            <i class="far fa-file-pdf"></i>
                                                                            Imprimir
                                                                        </a>
                                                                    @else
                                                                        {{--BOTON MODAL--}}
                                                                        <button type="button" class="btn btn-primary" id="crearBtnOS" data-toggle="modal" data-target="#modalOS">
                                                                            + Elaborar
                                                                        </button>

                                                                        <!-- Botón oculto que se mostrará después de cerrar el modal -->
                                                                        <a class="btn btn-primary d-none" id="impBtn2OS" href="{{route('procesoscont.pdfos2', $procesosc->id)}}" target="_blank">
                                                                            <i class="far fa-file-pdf"></i>
                                                                            Imprimir
                                                                        </a>
                                                                    @endif
                                                                  
                                                                    @break
                                                                @case('REPORTE DE PRECIOS E INEXISTENCIAS - INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE COMPRA')
                                                                    {{-- Script para ocultar el elemento --}}
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            // Ocultar el elemento al cargar la página
                                                                            var unidadOrgContainer = document.getElementById('unidadOrgContainer');
                                                                            if (unidadOrgContainer) {
                                                                                unidadOrgContainer.style.display = 'none';
                                                                            }
                                                                            var observacionContainer = document.getElementById('observacionContainer');
                                                                            if (observacionContainer) {
                                                                                observacionContainer.style.display = 'none';
                                                                            }
                                                                            var btnDerivar = document.getElementById('btnDerivar');
                                                                            if (btnDerivar) {
                                                                                btnDerivar.style.display = 'none';
                                                                            }
                                                                            var btnCancelar = document.getElementById('btnCancelar');
                                                                            if (btnCancelar) {
                                                                                btnCancelar.style.display = 'none';
                                                                            }
                                                                        });
                                                                    </script>
                                                                    
                                                                    {{--verificamos si ya existe el beneficiario en la BD--}}
                                                                    @php
                                                                    $proc = Procesoscont::find($procesosc->id);
                                                                    $benef = $proc->benef;
                                                                    
                                                                    //se envía las especificacines técnicas para generar orden de servicio
                                                                    $doctec = Docstec::select("*")
                                                                                        ->where('id_proc', $procesosc->id)
                                                                                        ->where('nom_doc', "ESPECIFICACIONES TÉCNICAS")
                                                                                        ->first();

                                                                    @endphp

                                                                    {{-----SI EXISTE EL BENEFICIARIO-----}}
                                                                    @if ($benef)
                                                                        {{--BOTON Ver/Imprimir--}}
                                                                        <a class="btn btn-primary" id="impBtnOC" href="{{route('procesoscont.pdfoc', $doctec->id)}}" target="_blank">
                                                                            <i class="far fa-file-pdf"></i>
                                                                            Imprimir
                                                                        </a>
                                                                    @else
                                                                        {{--BOTON MODAL--}}
                                                                        <button type="button" class="btn btn-primary" id="crearBtnOC" data-toggle="modal" data-target="#modalOC">
                                                                            + Elaborar
                                                                        </button>

                                                                        <!-- Botón oculto que se mostrará después de cerrar el modal -->
                                                                        <a class="btn btn-primary d-none" id="impBtn2OC" href="{{route('procesoscont.pdfoc2', $procesosc->id)}}" target="_blank">
                                                                            <i class="far fa-file-pdf"></i>
                                                                            Imprimir
                                                                        </a>
                                                                    @endif
                                                                  
                                                                    @break
                                                     
                                                                @default
                                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple >
                                                                    @error('file')
                                                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                                    @enderror
                                                                    <br>
                                                                    <label  style="font-size: 11px; color:rgb(189, 141, 68);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        ADJUNTAR{{" ".$verif['nom_doc']}}
                                                                    </label>

                                                            @endswitch
                                                            
                                                        @else
                                                            {{--si el documento no está en la lista de documentos de la etapa--}}
                                                            {{--se verifica si el iddoc es menor al mínimo id de los docs generados en la etapa, se tickea y no se pinta de azul--}}

                                                            {{--se verifica si se tickea o no--}}
                                                            @if ($verif['iddoc'] < min($lista1))
                                                                {!! Form::checkbox('verifs[]', $verif['iddoc'], true, ['class' => 'form-check-input', 'disabled' => 'disabled']) !!}
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
                                
                                        <div class="col-xs-12 col-sm-12 col-md-12" id="unidadOrgContainer">
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
                                        <div class="col-xs-12 col-sm-12 col-md-12" id="observacionContainer">
                                            <div class="form-group">
                                                <label for="observaciontray">Observación</label>
                                                {!! Form::textarea('observaciontray', null, array('id' => 'observaciontray', 'class'=>'form-control', 'rows' => 3, 'style' => 'width: 60%;')) !!}
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <input type="hidden" name="idtray" value="{{$trayec->id}}" />
                                            <input type="hidden" name="nom_doc" value="{{$nom_doc}}" />
                                            <button type="submit" id="btnDerivar" class="btn btn-primary">Derivar</button>
                                            <a class="btn btn-danger" id="btnCancelar" href="{{route('trayectoria.index')}}">Cancelar</a>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                             {!! Form::close() !!}
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        {{--MODAL ESPECIFICACIONES TÉCNICAS--}}
        <div class="modal fade show" id="modal-xl" style="padding-right: 17px; display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="formul">
                        <div class="modal-header">
                            <h4 class="modal-title">Crear Especificaciones Técnicas</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <?php
                                            $idp = $procesosc->id;
                                            $proceso = Procesoscont::find($idp);
                                            $usolic = Unidadesorg::find($proceso->id_unid);
                                            $modalidad = Modalidades::find($proceso->id_mod);
                                            $cont = 1;
                                            $total = 0;
                                        ?>
                                        
                                        <div class="row">
                                            <div class="col-12 col-xl-6 card">{{-- col-12 col-xl-4 card MODAL PRIMERA COLUMNA--}}
                                                <div class="card-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Código</label>
                                                            {{$proceso->codigo}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Solicitante</label>
                                                            {{$usolic->nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Objeto</label>
                                                            {{$proceso->objeto}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Precio Referencial</label>
                                                            <label id="precioReferencial">{{$proceso->precio_ref}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Modalidad</label>
                                                            {{$modalidad->nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Org. Destino</label>
                                                            {{$usolic->nombre}}
                                                            
                                                            {{-- @php
                                                            $options = Unidadesorg::all();
                                                            @endphp
                                                            <label for="opcionesm">Unidad Org. Destino</label><span class="text-danger">*</span></label>
                                                            <select name="opcionesm" id="opcionesm" required style="width: 400px;">
                                                                <option value="">Selecciona una opción</option>
                                                                @foreach($options as $option)
                                                                    <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                                                @endforeach
                                                            </select> --}}
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <label for="observaciontray">Observación</label>
                                                            <textarea id="observaciontray" name="observaciontray" class="form-control" rows="2" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-6 card">{{--MODAL SEGUNDA COLUMNA--}}
                                                <div class="card-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="plazo_ent">Plazo de entrega<span class="text-danger">*</span></label>
                                                            <textarea id="plazo_ent" name="plazo_ent" class="form-control" required rows="2" style="width: 90%;"></textarea>
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="garantia">Garantía<span class="text-danger">*</span></label>
                                                            <textarea id="garantia" name="garantia" class="form-control" required="required" rows="2" style="width: 90%;"></textarea>
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="lugmed_ent">Lugar y medio de entrega<span class="text-danger">*</span></label>
                                                            <textarea id="lugmed_ent" name="lugmed_ent" class="form-control" required="required" rows="2" style="width: 90%;"></textarea>
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="otro1">Otra información (1)</label>
                                                            <textarea id="otro1" name="otro1" class="form-control" rows="3" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="otro2">Otra información (2)</label>
                                                            <textarea id="otro2" name="otro2" class="form-control" rows="3" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 table-responsive bg-white p-4 mt-3">{{--DETALLE PRODUCTOS--}}
                                            <table id="doctec" class="table table-striped mt-2" style="width: 100%;">
                                                <thead class="table-header">
                                                    <tr class="table-header__encabezado">
                                                        <th style="display: #fff;" class="col-md-auto">Item</th>
                                                        <th style="display: #fff;" class="col-md-4">Descripción</th>
                                                        <th style="display: #fff;" class="col-md-auto">Unidad</th>
                                                        <th style="display: #fff;" class="col-md-auto">Cantidad</th>
                                                        <th style="display: #fff;" class="col-md-auto">Precio Unitario</th>
                                                        <th style="display: #fff;" class="col-md-auto">Subtotal</th>
                                                        <th style="display: #fff;" class="col-md-auto">Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input id="item" type="text" name="item[]" class="form-control col-md-auto item" value="1"></td>
                                                        <td><textarea id="producto" name="producto[]" class="form-control" rows="4" class="form-control col-md-4"></textarea></td>
                                                        <td><input id="unidad" type="text" name="unidad[]" class="form-control col-md-auto"></td>
                                                        <td><input id="cantidad" type="number" name="cantidad[]" class="form-control col-md-auto"></td>
                                                        <td><input id="precio" type="number" name="precio[]" class="form-control col-md-auto"></td>
                                                        <td><input id="subtotal" type="number" name="subtotal[]" readonly class="form-control col-md-auto"></td>
                                                        <td><button type="button" class="eliminar-fila btn btn-success">-</button></td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p align="right">TOTAL Bs.&nbsp;<label id="total"></label></p>
                                            <button type="button" id="agregar-fila" class="btn btn-success">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <input type="hidden" name="idp" value="{{ $idp }}">
                            <input type="hidden" name="nomdoc" value="ESPECIFICACIONES TÉCNICAS">
                            <input type="hidden" name="idtray" value="{{$trayec->id}}" />

                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button id="enviarFormulario" type="button"  class="btn btn-primary">Derivar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
       
                <script>

                    document.addEventListener('DOMContentLoaded', ()=> {

                        document.getElementById("enviarFormulario").addEventListener("click", ()=> {
                            
                            // document.getElementById('enviarFormulario').setAttribute('disabled', 'true');
                            
                            var selectores = ['#plazo_ent', '#garantia', '#lugmed_ent'] //'#doctec tbody tr']
                            if (validarCamposRequeridos(selectores)) {
                                //todos los elementos
                                var formulario = document.getElementById("formul");
                                //console.log(formulario);
                                var elementos = formulario.elements;
                                //console.log(elementos);
                                var datosFormulario = {};

                                for (var i = 0; i < elementos.length; i++) {
                                    var elemento = elementos[i];
                                    if (elemento.type !== "button") {
                                        datosFormulario[elemento.name] = elemento.value;
                                    }
                                }

                                // var datosJSON = JSON.stringify(datosFormulario);
                                // console.log(datosJSON);

                                var items = document.getElementsByName("item[]");
                                var productos = document.getElementsByName("producto[]");
                                var unidades = document.getElementsByName("unidad[]");
                                var cantidades = document.getElementsByName("cantidad[]");
                                var precios = document.getElementsByName("precio[]");
                                var subtotales = document.getElementsByName("subtotal[]");

                                datosFormulario['total'] = 0;

                                datosFormulario['item1'] = [];
                                datosFormulario['producto1'] = [];
                                datosFormulario['unidad1'] = [];
                                datosFormulario['cantidad1'] = [];
                                datosFormulario['precio1'] = [];
                                datosFormulario['subtotal1'] = [];
                                
                                for (var i = 0; i < items.length; i++) {
                                    var itemValue = items[i].value;
                                    datosFormulario['item1'][i] = itemValue;
                                }
                                for (var i = 0; i < productos.length; i++) {
                                    var productoValue = productos[i].value;
                                    datosFormulario['producto1'][i] = productoValue;
                                }
                                for (var i = 0; i < unidades.length; i++) {
                                    var unidadValue = unidades[i].value;
                                    datosFormulario['unidad1'][i] = unidadValue;
                                }
                                for (var i = 0; i < cantidades.length; i++) {
                                    var cantidadValue = cantidades[i].value;
                                    datosFormulario['cantidad1'][i] = cantidadValue;
                                }
                                for (var i = 0; i < precios.length; i++) {
                                    var precioValue = precios[i].value;
                                    datosFormulario['precio1'][i] = precioValue;
                                }
                                
                                let sumtotal = 0;
                                for (var i = 0; i < subtotales.length; i++) {
                                    var subtotalValue = subtotales[i].value;
                                    datosFormulario['subtotal1'][i] = subtotalValue;
                                    
                                    sumtotal += subtotalValue;
                                }
                                datosFormulario['total'] = sumtotal;

                                console.log(datosFormulario);

                                // Realizar la petición AJAX
                                $.ajax({
                                    url: '{{route("procesoscont.store_docstec")}}',
                                    type: 'POST',
                                    
                                    data: datosFormulario,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    
                                    success: function (respuesta) {
                                        // Manejar la respuesta exitosa del servidor aquí
                                        console.log(respuesta);
                                        
                                        //MODAL
                                        // Cerrar el modal usando Bootstrap y jQuery
                                        $('#modal-xl').modal('hide');
                                        // Eliminar la clase 'show' del modal y del backdrop
                                        $('#modal-xl').removeClass('show');
                                        $('.modal-backdrop').remove(); // Elimina completamente el backdrop
                                        // Eliminar la clase 'modal-open' del body
                                        $('body').removeClass('modal-open');

                                        //SIENDO QUE SE GUARDÓ CORRECTAMENTE EN LA BASE DE DATOS
                                        // Ocultar el botón de crear y mostrar el nuevo botón
                                        $('#crearBtn').addClass('d-none');
                                        $('#impBtn2').removeClass('d-none');
  
                                        // Puedes mostrar un mensaje al usuario o redirigirlo a otra página después de guardar los datos
                                        
                                    },

                                    error: function (error) {
                                        console.log(error);
                                        // Manejar cualquier error que ocurra durante la solicitud
                                    }
                                });
                            } else {
                                alert('Por favor, complete todos los campos requeridos');
                            }

                            // Función para validar campos requeridos en todas las ubicaciones
                            function validarCamposRequeridos(selectores) {
                                var validacionExitosa = true;

                                selectores.forEach(function (selector) {
                                    var elementos = $(selector);

                                    elementos.each(function () {
                                        // Verificar si es un textarea o input
                                        if ($(this).is('textarea, input')) {
                                            if (!$(this).val()) {
                                                validacionExitosa = false;
                                                return false; // Salir del bucle each si se encuentra un campo vacío
                                            }
                                        } else {
                                            // Verificar otros elementos (si es necesario)
                                            var camposRequeridos = $(this).find('[required]');

                                            camposRequeridos.each(function () {
                                                if (!$(this).val()) {
                                                    validacionExitosa = false;
                                                    return false; // Salir del bucle each si se encuentra un campo vacío
                                                }
                                            });
                                        }

                                        if (!validacionExitosa) {
                                            return false; // Salir del bucle each si se encuentra una fila con campos vacíos
                                        }
                                    });
                                });

                                return validacionExitosa;
                            }

                        });

                    });
                </script>

            </div>
            <!-- /.modal-dialog -->
        
        </div>
        <!-- /.modal-dialog -->

        <!-- MODAL ORDEN DE SERVICIO -->
        <div class="modal fade show" id="modalOS" style="padding-right: 17px; display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="formulOS">
                        <div class="modal-header">
                            <h4 class="modal-title">Crear Orden de Servicio</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <?php
                                            $idp = $procesosc->id;
                                            $proceso = Procesoscont::find($idp);
                                            $usolic = Unidadesorg::find($proceso->id_unid);
                                            $modalidad = Modalidades::find($proceso->id_mod);
                                            $cont = 1;
                                            $total = 0;
                                        ?>
                                        
                                        <div class="row">
                                            <div class="col-12 col-xl-6 card">{{-- col-12 col-xl-4 card MODAL PRIMERA COLUMNA--}}
                                                <div class="card-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Código</label>
                                                            {{$proceso->codigo}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Solicitante</label>
                                                            {{$usolic->nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Objeto</label>
                                                            {{$proceso->objeto}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Precio Referencial</label>
                                                            <label id="precioReferencial">{{$proceso->precio_ref}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Modalidad</label>
                                                            {{$modalidad->nombre}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-6 card">{{--MODAL SEGUNDA COLUMNA--}}
                                                <div class="card-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12" id="benefContainer">
                                                        <div class="form-group">
                                                            <label>Beneficiario<span class="text-danger">*</span></label>
                                                            <input type="text" name="benef" id="benef" class="form-control" required style ="width: 85%">
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12" id="docrefContainer">
                                                        <div class="form-group">
                                                            <label>Documento de Referencia<span class="text-danger">*</span></label>
                                                            <input type="text" name="docref" id="docref" class="form-control" required style ="width: 85%">
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Org. Destino</label>
                                                            {{-- {{$usolic->nombre}} --}}
                                                            
                                                            @php
                                                            $options = Unidadesorg::all();
                                                            @endphp
                                                            <label for="opcionesm">Unidad Org. Destino</label><span class="text-danger">*</span></label>
                                                            <select name="opcionesm" id="opcionesm" style="width: 400px;" required>
                                                                <option value="">Selecciona una opción</option>
                                                                @foreach($options as $option)
                                                                    <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xs-12 col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <label for="observaciontray">Observación</label>
                                                            <textarea id="observaciontray" name="observaciontray" class="form-control" rows="2" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div>

                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                    <div class="col-xs-12 col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <input type="file" name="filem[]" placeholder="Selecciona archivo" id="filem" multiple>
                                                            @error('filem')
                                                            <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                            @enderror
                                                            <br>
                                                            <label  style="font-size: 11px; color:rgb(189, 141, 68);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                ADJUNTAR{{" "."INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE SERVICIO"}}
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <input type="hidden" name="idp" value="{{ $idp }}">
                            <input type="hidden" name="nomdoc" value="INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE SERVICIO">
                            <input type="hidden" name="idtray" value="{{$trayec->id}}" />

                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button id="enviarFormulariOS" type="button"  class="btn btn-primary">Derivar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
       
                <script>

                    document.addEventListener('DOMContentLoaded', ()=> {

                        document.getElementById("enviarFormulariOS").addEventListener("click", ()=> {
                            var selectores = ['#benef', '#docref', '#opcionesm'] //'#doctec tbody tr']
                            if (validarCamposRequeridos(selectores)) {
                                //todos los elementos
                                var formulario = document.getElementById("formulOS");
                                //console.log(formulario);
                                var elementos = formulario.elements;
                                //console.log(elementos);
                                var datosFormulario = {};

                                for (var i = 0; i < elementos.length; i++) {
                                    var elemento = elementos[i];
                                    if (elemento.type !== "button") {
                                        datosFormulario[elemento.name] = elemento.value;
                                    }
                                }

                                // var datosJSON = JSON.stringify(datosFormulario);
                                // console.log(datosJSON);

                                var filesm = document.getElementsByName("filem[]");
                                datosFormulario['filem1'] = [];
                                for (var i = 0; i < filesm.length; i++) {
                                    var filemValue = filesm[i].value;
                                    datosFormulario['filem1'][i] = filemValue;
                                }

                                console.log(datosFormulario);

                                // Realizar la petición AJAX
                                $.ajax({
                                    url: '{{route("procesoscont.store_docstec_os")}}',
                                    type: 'POST',
                                    
                                    data: datosFormulario,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    
                                    success: function (respuesta) {
                                        // Manejar la respuesta exitosa del servidor aquí
                                        console.log(respuesta);
                                        
                                        //MODAL
                                        // Cerrar el modal usando Bootstrap y jQuery
                                        $('#modalOS').modal('hide');
                                        // Eliminar la clase 'show' del modal y del backdrop
                                        $('#modalOS').removeClass('show');
                                        $('.modal-backdrop').remove(); // Elimina completamente el backdrop
                                        // Eliminar la clase 'modal-open' del body
                                        $('body').removeClass('modal-open');

                                        //SIENDO QUE SE GUARDÓ CORRECTAMENTE EN LA BASE DE DATOS
                                        // Ocultar el botón de crear y mostrar el nuevo botón
                                        $('#crearBtnOS').addClass('d-none');
                                        $('#impBtn2OS').removeClass('d-none');
  
                                        // Puedes mostrar un mensaje al usuario o redirigirlo a otra página después de guardar los datos
                                        
                                    },

                                    error: function (error) {
                                        console.log(error);
                                        // Manejar cualquier error que ocurra durante la solicitud
                                    }
                                });
                            } else {
                                alert('Por favor, complete todos los campos requeridos');
                            }

                            // Función para validar campos requeridos en todas las ubicaciones
                            function validarCamposRequeridos(selectores) {
                                var validacionExitosa = true;

                                selectores.forEach(function (selector) {
                                    var elementos = $(selector);

                                    elementos.each(function () {
                                        // Verificar si es un textarea o input
                                        if ($(this).is('textarea, input, select')) {
                                            if (!$(this).val()) {
                                                validacionExitosa = false;
                                                return false; // Salir del bucle each si se encuentra un campo vacío
                                            }
                                        } else {
                                            // Verificar otros elementos (si es necesario)
                                            var camposRequeridos = $(this).find('[required]');

                                            camposRequeridos.each(function () {
                                                if (!$(this).val()) {
                                                    validacionExitosa = false;
                                                    return false; // Salir del bucle each si se encuentra un campo vacío
                                                }
                                            });
                                        }

                                        if (!validacionExitosa) {
                                            return false; // Salir del bucle each si se encuentra una fila con campos vacíos
                                        }
                                    });
                                });

                                return validacionExitosa;
                            }

                        });

                    });
                </script>

            </div>
            <!-- /.modal-dialog -->
        
        </div>
        <!-- /.modal-dialog -->

        <!-- MODAL ORDEN DE COMPRA -->
        <div class="modal fade show" id="modalOC" style="padding-right: 17px; display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="formulOC">
                        <div class="modal-header">
                            <h4 class="modal-title">Crear Orden de Compra</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <?php
                                            $idp = $procesosc->id;
                                            $proceso = Procesoscont::find($idp);
                                            $usolic = Unidadesorg::find($proceso->id_unid);
                                            $modalidad = Modalidades::find($proceso->id_mod);
                                            $cont = 1;
                                            $total = 0;
                                        ?>
                                        
                                        <div class="row">
                                            <div class="col-12 col-xl-6 card">{{-- col-12 col-xl-4 card MODAL PRIMERA COLUMNA--}}
                                                <div class="card-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Código</label>
                                                            {{$proceso->codigo}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Solicitante</label>
                                                            {{$usolic->nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Objeto</label>
                                                            {{$proceso->objeto}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Precio Referencial</label>
                                                            <label id="precioReferencial">{{$proceso->precio_ref}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Modalidad</label>
                                                            {{$modalidad->nombre}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-6 card">{{--MODAL SEGUNDA COLUMNA--}}
                                                <div class="card-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12" id="benefContainer">
                                                        <div class="form-group">
                                                            <label>Beneficiario<span class="text-danger">*</span></label>
                                                            <input type="text" name="benefoc" id="benefoc" class="form-control" required style ="width: 85%">
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12" id="docrefContainer">
                                                        <div class="form-group">
                                                            <label>Documento de Referencia<span class="text-danger">*</span></label>
                                                            <input type="text" name="docrefoc" id="docrefoc" class="form-control" required style ="width: 85%">
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Org. Destino</label>
                                                            {{-- {{$usolic->nombre}} --}}
                                                            
                                                            @php
                                                            $options = Unidadesorg::all();
                                                            @endphp
                                                            <label for="opcionesmoc">Unidad Org. Destino</label><span class="text-danger">*</span></label>
                                                            <select name="opcionesmoc" id="opcionesmoc" style="width: 400px;" required>
                                                                <option value="">Selecciona una opción</option>
                                                                @foreach($options as $option)
                                                                    <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xs-12 col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <label for="observaciontray">Observación</label>
                                                            <textarea id="observaciontrayoc" name="observaciontrayoc" class="form-control" rows="2" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div>

                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                    <div class="col-xs-12 col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <input type="file" name="filemoc[]" placeholder="Selecciona archivo" id="filemoc" multiple>
                                                            @error('filemoc')
                                                            <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                            @enderror
                                                            <br>
                                                            <label  style="font-size: 11px; color:rgb(189, 141, 68);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                ADJUNTAR{{" "."REPORTE DE PRECIOS E INEXISTENCIAS - INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE COMPRA"}}
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{--editor QUILL--}}
                                                    {{-- <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            var quill = new Quill('#editor', {
                                                                theme: 'snow' // Puedes ajustar el tema según tus preferencias
                                                            });

                                                            //Función para guardar el contenido en algún lugar (por ejemplo, en la consola)
                                                            window.guardarContenido = function() {
                                                                var contenidoQuill = quill.root.innerHTML;
                                                                console.log(contenidoQuill);
                                                                // Aquí podrías enviar el contenido a tu servidor usando AJAX o cualquier otro método.
                                                            };
                                                        });
                                                    </script> --}}
                                                    {{--editor QUILL--}}
                                                    <div id="editor" class="w-100" style="height: 200px; border: 1px solid #ccc;">hola</div>

                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <input type="hidden" name="idp" value="{{ $idp }}">
                            <input type="hidden" name="nomdoc" value="REPORTE DE PRECIOS E INEXISTENCIAS - INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE COMPRA">
                            <input type="hidden" name="idtray" value="{{$trayec->id}}" />

                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button id="enviarFormulariOC" type="button"  class="btn btn-primary">Derivar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->

                <script>

                    document.addEventListener('DOMContentLoaded', ()=> {

                        //editor QUILL
                        var quill = new Quill('#editor', {
                                theme: 'snow' // Puedes ajustar el tema según tus preferencias
                            });

                        document.getElementById("enviarFormulariOC").addEventListener("click", ()=> {

                            var selectores = ['#benefoc', '#docrefoc', '#opcionesmoc'] //'#doctec tbody tr']
                            if (validarCamposRequeridos(selectores)) {

                                var contenidoQuill = quill.root.innerHTML.trim();

                                //todos los elementos
                                var formulario = document.getElementById("formulOC");
                                //console.log(formulario);
                                var elementos = formulario.elements;
                                //console.log(elementos);
                                var datosFormulario = {};

                                for (var i = 0; i < elementos.length; i++) {
                                    var elemento = elementos[i];
                                    if (elemento.type !== "button") {
                                        datosFormulario[elemento.name] = elemento.value;
                                    }
                                }
                                // Agregar la propiedad "contenido" al objeto datosFormulario
                                datosFormulario['contenido'] = contenidoQuill;

                                // var datosJSON = JSON.stringify(datosFormulario);
                                // console.log(datosJSON);

                                var filesm = document.getElementsByName("filemoc[]");
                                datosFormulario['filem1'] = [];
                                for (var i = 0; i < filesm.length; i++) {
                                    var filemValue = filesm[i].value;
                                    datosFormulario['filem1'][i] = filemValue;
                                }

                                console.log(datosFormulario);

                                // Realizar la petición AJAX
                                $.ajax({
                                    url: '{{route("procesoscont.store_docstec_oc")}}',
                                    type: 'POST',
                                    
                                    data: datosFormulario, 
                                    

                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    
                                    success: function (respuesta) {
                                        // Manejar la respuesta exitosa del servidor aquí
                                        console.log(respuesta);
                                        
                                        //MODAL
                                        // Cerrar el modal usando Bootstrap y jQuery
                                        $('#modalOC').modal('hide');
                                        // Eliminar la clase 'show' del modal y del backdrop
                                        $('#modalOC').removeClass('show');
                                        $('.modal-backdrop').remove(); // Elimina completamente el backdrop
                                        // Eliminar la clase 'modal-open' del body
                                        $('body').removeClass('modal-open');

                                        //SIENDO QUE SE GUARDÓ CORRECTAMENTE EN LA BASE DE DATOS
                                        // Ocultar el botón de crear y mostrar el nuevo botón
                                        $('#crearBtnOC').addClass('d-none');
                                        $('#impBtn2OC').removeClass('d-none');

                                        // Puedes mostrar un mensaje al usuario o redirigirlo a otra página después de guardar los datos
                                        
                                    },

                                    error: function (error) {
                                        console.log(error);
                                        // Manejar cualquier error que ocurra durante la solicitud
                                    }
                                });
                            } else {
                                alert('Por favor, complete todos los campos requeridos');
                            }

                            // Función para validar campos requeridos en todas las ubicaciones
                            function validarCamposRequeridos(selectores) {
                                var validacionExitosa = true;

                                selectores.forEach(function (selector) {
                                    var elementos = $(selector);

                                    elementos.each(function () {
                                        // Verificar si es un textarea o input
                                        if ($(this).is('textarea, input, select')) {
                                            if (!$(this).val()) {
                                                validacionExitosa = false;
                                                return false; // Salir del bucle each si se encuentra un campo vacío
                                            }
                                        } else {
                                            // Verificar otros elementos (si es necesario)
                                            var camposRequeridos = $(this).find('[required]');

                                            camposRequeridos.each(function () {
                                                if (!$(this).val()) {
                                                    validacionExitosa = false;
                                                    return false; // Salir del bucle each si se encuentra un campo vacío
                                                }
                                            });
                                        }

                                        if (!validacionExitosa) {
                                            return false; // Salir del bucle each si se encuentra una fila con campos vacíos
                                        }
                                    });
                                });

                                return validacionExitosa;
                            }

                        });

                    });
                </script>

            </div>
            <!-- /.modal-dialog -->

        </div>
        <!-- /.modal-dialog -->        




    </section>
@stop
    
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
   
    $(document).ready(function () {

            // Inicializar AdminLTE
            $('.dropdown-toggle').dropdown();

            // Escuchar el evento de mostrar el menú desplegable
            $('.dropdown-toggle').on('shown.bs.dropdown', function () {
                // Actualizar aria-expanded a true
                $(this).attr('aria-expanded', 'true');
            });

            // Función para inicializar Select2
            function inicializarSelect2(){
                $('#opciones, #opcionesm, #opcionesmoc').select2(); // Inicializar Select2 en tu select con el ID "opciones"
            }
            
            function configurarAgregarEliminarFilas() {
                // Contador para ítems
                var contadorItems = obtenerUltimoNumeroItem() + 1;

                // Agregar fila
                $('#agregar-fila').click(function () {
                    // Validar todos los campos requeridos en todas las filas
                    //if (validarCamposRequeridos()) {//no validar
                        
                          agregarNuevaFila();

                    // } else {
                    //     alert('Por favor, complete todos los campos requeridos en las filas existentes.');
                    // }
                });

                // Función para validar campos requeridos en todas las filas
                function validarCamposRequeridos() {
                    var filas = $('#doctec tbody tr');
                    var validacionExitosa = true;

                    filas.each(function () {
                        var camposRequeridos = $(this).find('[required]');

                        camposRequeridos.each(function () {
                            if (!$(this).val()) {
                                validacionExitosa = false;
                                return false; // Salir del bucle each si se encuentra un campo vacío
                            }
                        });

                        if (!validacionExitosa) {
                            return false; // Salir del bucle each de filas si se encuentra una fila con campos vacíos
                        }
                    });

                    return validacionExitosa;
                }

                // Eliminar fila
                $('#doctec').on('click', '.eliminar-fila', function () {
                        // Solo eliminar si hay más de una fila
                        if ($('#doctec tbody tr').length > 1) {
                            $(this).closest('tr').remove();
                            actualizarNumerosItem();
                        }
                });

                function agregarNuevaFila() {
                    var primeraFila = $('#doctec tbody tr:first');
                    var nuevaFila = primeraFila.clone();

                    // Limpiar los valores de los campos en la nueva fila, excluyendo la celda "Item"
                    nuevaFila.find('input:not(.item), textarea:not(.item)').val('');

                    // Obtener el último número de "Item"
                    var ultimoNumero = obtenerUltimoNumeroItem();

                    // Incrementar el número solo si la celda "Item" no está vacía
                    var itemInput = nuevaFila.find('.item');
                    if (itemInput.val() === '') {
                        // Mantener vacía si la celda "Item" está vacía en la fila anterior
                        itemInput.val('');
                    } else {
                        itemInput.val(ultimoNumero + 1);
                    }

                    // Habilitar el botón de eliminar en la nueva fila
                    nuevaFila.find('.eliminar-fila').prop('disabled', false);

                    // Agregar la nueva fila al final de la tabla
                    $('#doctec tbody').append(nuevaFila);
                }

                function actualizarNumerosItem() {
                    var filas = $('#doctec tbody tr');
                    filas.each(function (index) {
                        // Asignar el número actualizado a la celda "Item", manteniendo vacías las celdas con valor vacío
                        var itemInput = $(this).find('.item');
                        if (itemInput.val() !== '') {
                            itemInput.val(index + 1);
                        }
                    });

                    // Actualizar el contador de ítems después de eliminar una fila
                    contadorItems = obtenerUltimoNumeroItem() + 1;
                }

                function obtenerUltimoNumeroItem() {
                    var filas = $('#doctec tbody tr');
                    var ultimoNumero = 0;

                    // Buscar el último número no vacío de "Item"
                    filas.each(function () {
                        var numero = parseInt($(this).find('.item').val());
                        if (!isNaN(numero) && numero > ultimoNumero) {
                            ultimoNumero = numero;
                        }
                    });

                    return ultimoNumero;
                }
 
                // Función para calcular el total
                function calcularTotal() {
                    var total = 0;

                    var precioReferencial = parseFloat($('#precioReferencial').text()) || 0;

                    console.log(precioReferencial);
                    
                    $('#doctec tbody tr').each(function () {
                        total += parseFloat($(this).find('input[name^="subtotal"]').val()) || 0;
                    });

                    $('#total').text(total.toFixed(2));

                    if (total > precioReferencial) {
                        alert('¡El total no puede ser mayor que el precio referencial!');
                    }
                    // También puedes limpiar el total o hacer alguna otra acción según tus necesidades
                    //$('#total').text('0.00');
                    
                    
                }

                // Calcular el total
                $('#doctec tbody').on('input', 'input[name^="cantidad"], input[name^="precio"]', function () {
                    var fila = $(this).closest('tr');
                    var cantidad = parseFloat(fila.find('input[name^="cantidad"]').val()) || 0;
                    var precio = parseFloat(fila.find('input[name^="precio"]').val()) || 0;
                    var subtotal = cantidad * precio;
                    fila.find('input[name^="subtotal"]').val(subtotal.toFixed(2));

                    calcularTotal();
                });
            }
            
            function inicializarQuill(selector) {
                return new Quill(selector, {
                    theme: 'snow'
                });
            }

                // Llama a la función para inicializar Select2
            inicializarSelect2();

            configurarAgregarEliminarFilas();

    });

</script>

@stop