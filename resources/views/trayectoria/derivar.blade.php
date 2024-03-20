@extends('adminlte::page')

@section('title', 'Derivar Proceso')

@section('content_header')
@stop

@section('content')

<!-- Estilos de pagina -->
<style>
    @media (min-width: 1200px) {
        .modal-xl {
            max-width: 1400px !important;
        }
    }
</style>

<section class="section">
    <div class="section-header">
        <h4 class="page__heading p-3 text-uppercase">Derivar Proceso</h3>
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
                        use App\Models\Procesoscont;
                        use App\Models\Etapasproc;
                        use App\Models\Docsgen;
                        use App\Models\Docstec;
                        use App\Models\Det_docstec;
                        @endphp
                        {!! Form::open(array('route'=>'trayectoria.storeder', 'method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                        {{-- {!! Form::open(array('route'=>'listaverif.store', 'method'=>'POST', 'enctype'=>'multipart/form-data')) !!} --}}
                        <div class="row">
                            <div class="col-12 col-xl-6">{{--PRIMERA COLUMNA--}}
                                <div class="card">
                                    <div class="card-header">
                                        Formulario: Derivar Proceso
                                    </div>
                                    <div class="card-body">
                                        {{--para dos columnas: class="row" class="col-xs-12 col-sm-6 col-md-6"--}}
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
                                                <label>Etapa actual:</label>
                                                {{$eact->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $esig = Etapasproc::find($trayec->id_esgte);
                                                @endphp
                                                <label>Etapa siguiente:</label>
                                                {{$esig->nom_etapa}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $uorigen = Unidadesorg::find($trayec->id_uorigen);
                                                @endphp
                                                <label>Unidad Org. Anterior:</label>
                                                {{$uorigen->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                $uactual = Unidadesorg::find($trayec->id_uactual);
                                                @endphp
                                                <label>Unidad Org. Actual:</label>
                                                {{$uactual->nombre}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-xl-6">{{--SEGUNDA COLUMNA--}}
                                <div class="card">
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
                                                <label>NºEtapa&nbsp;&nbsp;&nbsp;Doc.Generado</label>


                                                @php


                                                @endphp

                                                <!-- Iteracion de una lista -->
                                                @foreach ($verifs as $verif)


                                                <!-- Logica para cada checkbox -->
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
                                                        document.addEventListener('DOMContentLoaded', function() {
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

                                                    // Consulta
                                                    $doctec = Docstec::select("*")
                                                    ->where('id_proc', $procesosc->id)
                                                    ->where('nom_doc', $nom_doc)
                                                    ->first();


                                                    // print_r($doctec);
                                                    @endphp

                                                    {{-----SI EXISTE EL DOC ESPECIFICACIONES TÉCNICAS-----}}
                                                    @if ($doctec)

                                                    {{--BOTON Ver/Imprimir--}}
                                                    <a class="btn btn-primary btn-sm" id="impBtn" href="{{route('procesoscont.pdfdt', $doctec->id)}}" target="_blank">
                                                        <i class="far fa-file-pdf"></i>
                                                        Imprimir
                                                    </a>
                                                    @else
                                                    <!-- Modificado por DavidSP -->
                                                    {{--SI NO EXISTE EL DOCUMENTO TENEMOS QUE ELABORAR DESPLEGANDO  MODAL--}}
                                                    <button type="button" class="btn btn-primary btn-sm" id="crearBtn" data-toggle="modal" data-target="#modal-xl">
                                                        <i class="fa fa-plus"></i> Elaborar
                                                    </button>

                                                    <!-- Botón oculto que se mostrará después de cerrar el modal -->
                                                    <a class="btn btn-primary d-none btn-sm" id="impBtn2" href="{{route('procesoscont.pdfdt2', $procesosc->id)}}" target="_blank">
                                                        <i class="far fa-file-pdf"></i>
                                                        Imprimir
                                                    </a>
                                                    @endif

                                                    @break


                                                    <!-- Aqui se deb modificar la Inexistencia de archivos -->
                                                    @case('INFORME DE INEXISTENCIA DE ACTIVOS')
                                                    {{-- Script para ocultar el select de unidad de destino --}}
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            // Ocultar el elemento por defecto al cargar la página
                                                            var unidadOrgContainer = document.getElementById('unidadOrgContainer');
                                                            if (unidadOrgContainer) {
                                                                unidadOrgContainer.style.display = 'none';
                                                            }
                                                            $('#opciones').removeAttr('required');
                                                        });
                                                    </script>

                                                    <!-- Guarda el nombre de la etapa en una variable global -->
                                                    @php
                                                    $nom_doc = $verif['nom_doc'];
                                                    @endphp


                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#evaluacion"><i class="fas fa-pen"></i> Evaluar</a>
                                                    <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-print"></i> Imprimir</a>

                                                    <!-- <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple> -->
                                                    @error('file')
                                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                    @enderror

                                                    @break




                                                    @case('CERTIFICACIÓN PRESUPUESTARIA')
                                                    {{-- Script para ocultar el elemento --}}
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
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
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @error('file')
                                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                    @enderror

                                                    @break
                                                    @case('AUTORIZACIÓN DE INICIO')
                                                    @if ($procesosc->autorizado == 1)
                                                    <label style="font-size: 13px; color:rgb(56, 141, 116);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        INICIO AUTORIZADO
                                                    </label>
                                                    @else
                                                    {{--BOTON Autorizar--}}
                                                    <a class="btn btn-success text-white btn-sm" onclick="confirmarAutorizacion()">
                                                        <i class="fas fa-check-double"></i>Autorizar
                                                    </a>

                                                    <script>
                                                        function confirmarAutorizacion() {
                                                            // if (confirm('¿Está seguro de autorizar el inicio?')) {
                                                            //     console.log('autorizará');
                                                            //     window.location.href = "{{ route('procesoscont.autorizar', ['idproc' => $procesosc->id, 'idtray' => $trayec->id]) }}";
                                                            // }

                                                            Swal.fire({
                                                                title: "Esta seguro de autorizar el inicio?",
                                                                text: "Esto no se podra revertir!",
                                                                icon: "warning",
                                                                showCancelButton: true,
                                                                confirmButtonColor: "#3085d6",
                                                                cancelButtonColor: "#d33",
                                                                confirmButtonText: "Si, autorizar!",
                                                                cancelButtonText: "Cancelar" // Aquí cambiamos el texto del botón "Cancelar" al español
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {

                                                                    setTimeout(() => {
                                                                        window.location.href = "{{ route('procesoscont.autorizar', ['idproc' => $procesosc->id, 'idtray' => $trayec->id]) }}";
                                                                    }, 4000);

                                                                    Swal.fire({
                                                                        title: "Autorizado!",
                                                                        text: "El proceso se autorizó correctamente",
                                                                        icon: "success"
                                                                    });

                                                                }
                                                            });

                                                        }
                                                    </script>
                                                    @endif

                                                    @break

                                                    @case('INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE SERVICIO')
                                                    {{-- Script para ocultar el elemento --}}
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
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
                                                    <a class="btn btn-primary btn-sm" id="impBtnOS" href="{{route('procesoscont.pdfos', ['doctec' => $doctec->id, 'fecha' => 'dateCustom'])}}" target="_blank">
                                                        <i class="far fa-file-pdf"></i>
                                                        Imprimir
                                                    </a>
                                                    @else
                                                    {{--BOTON MODAL--}}
                                                    <button type="button" class="btn btn-primary" id="crearBtnOS" data-toggle="modal" data-target="#modalOS">
                                                        + Elaborar
                                                    </button>

                                                    <!-- Botón oculto que se mostrará después de cerrar el modal -->
                                                    <a class="btn btn-primary d-none btn-sm" id="impBtn2OS" href="{{route('procesoscont.pdfos2', $procesosc->id)}}" target="_blank">
                                                        <i class="far fa-file-pdf"></i>
                                                        Imprimir
                                                    </a>
                                                    @endif

                                                    @break
                                                    @case('REPORTE DE PRECIOS E INEXISTENCIAS - INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE COMPRA')
                                                    {{-- Script para ocultar el elemento --}}
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
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
                                                    <a class="btn btn-primary" id="impBtnOC" href="{{route('procesoscont.pdfoc', ['doctec' => $doctec->id, 'fecha' => 'dateCustom'])}}" target="_blank">
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

                                                    @case('SOLICITUD CERTIFICACIÓN PRESUPUESTARIA')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('SOLICITUD DE AUTORIZACIÓN DE INICIO')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('ACTA DE RECEPCIÓN - FACTURA DECLARADA - INGRESO Y SALIDA DE ALMACEN')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('SOLICITUD DE PAGO')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('VERIFICACIÓN DE DOCUMENTOS')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('REVISIÓN DE DOCUMENTOS')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('FIRMA ELECTRÓNICA')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('REGISTRO DE PAGO')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @case('REMISIÓN A ARCHIVOS INSTITUCIONALES')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break


                                                    <!-- Servicios -->
                                                    @case('ACTA DE CONFORMIDAD - FACTURA DECLARADA')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    <!-- Servicios consultoria >  20000 -->
                                                    @case('TERMINOS DE REFERENCIA TDR')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break


                                                    <!-- CMENCP -->
                                                    @case('INVITACIÓN AL CONSULTOR - INFORME DE SELECCIÓN DE PROVEEDOR - NOTA DE ADJUDICACIÓN - INFORME DE VERIFICACIÓN DE DOCUMENTOS')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    <!-- CMENCP -->
                                                    @case('CONTRATO')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    <!-- CMENCP -->
                                                    @case('MEMORANDUM DE CONTRAPARTE DE SERVICIO')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    <!-- CMENCP -->
                                                    @case('FORMULARIO 400 - SOLICITUD DE NOMBRAMIENTO DE RESPONSABLE DE RECEPCIÓN O COMISIÓN DE RECEPCIÓN')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    <!-- CMENCP -->
                                                    @case('MEMORANDUMS NOMBRAMIENTO DE RESPONSABLE DE RECEPCION O COMISIÓN DE RECEPCION')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    <!-- CMENCP -->
                                                    @case('INFORME DE CONFORMIDAD')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    <!-- CMENCP -->
                                                    @case('LLENADO DE FORMULARIO 500')
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple>
                                                    @break

                                                    @default


                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <!-- <input type="file" name="files[]" placeholder="Selecciona archivo" id="file" multiple> -->
                                                    <a href="{{route('procesoscont.pdfinexact', $procesosc->id)}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
                                                    @error('file')
                                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                    @enderror
                                                    <br>
                                                    <label class="text-cyan" style="font-size: 11px; color:rgb(189, 141, 68);">
                                                        <!-- ADJUNTAR{{" ".$verif['nom_doc']}} -->
                                                        Partida 40000; ACTIVOS REALES <span class="text-red">(Derivar a la UNIDAD DE ADMINISTRACION DE BIENES).</span><br>
                                                        Partida 30000; MATERIALES Y SUMINISTROS <span class="text-red">(Derivar al AREA DE ALAMACENES).</span>
                                                    </label>

                                                    @endswitch

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
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>


        <!-- ********* 1.- MODAL ESPECIFICACIONES TÉCNICAS******* -->
        <div class="modal fade show" id="modal-xl" style="padding-right: 17px; display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="formul">
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase">Crear Especificaciones Técnicas</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="">
                                    <div class="card-body">

                                        @php
                                        $idp = $procesosc->id;
                                        $proceso = Procesoscont::find($idp);
                                        $usolic = Unidadesorg::find($proceso->id_unid);
                                        $modalidad = Modalidades::find($proceso->id_mod);
                                        $cont = 1;
                                        $total = 0;

                                        $sigla = $modalidad->sigla;

                                        @endphp

                                        <div class="row">
                                            <div class="col-12 col-xl-6 card">{{-- col-12 col-xl-4 card MODAL PRIMERA COLUMNA--}}
                                                <div class="card-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Código:</label>
                                                            {{$proceso->codigo}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Solicitante:</label>
                                                            {{$usolic->nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Objeto:</label>
                                                            {{$proceso->objeto}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Precio Referencial:</label>
                                                            <span id="precioReferencial">{{$proceso->precio_ref}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Modalidad:</label>
                                                            {{$modalidad->nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Unidad Org. Destino:</label>
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
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="observaciontray">Observación:</label>
                                                            <textarea id="observaciontray" name="observaciontray" class="form-control" rows="2" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-xl-6 card">{{--MODAL SEGUNDA COLUMNA--}}
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        @if($sigla=='CMB' || $sigla=='CMBCP' || $sigla=='ANPEB' || $sigla=='LPNB')
                                                        <label for="plazo_ent">Plazo de entrega<span class="text-danger">*</span></label><br>
                                                        @endif

                                                        @if($sigla=='CMS' || $sigla=='CMSCP' || $sigla=='ANPES' || $sigla=='LPNS' || $sigla=='CMDS' )
                                                        <!-- Servicio -->
                                                        <label for="plazo_ent">Plazo del servicio<span class="text-danger">*</span></label><br>
                                                        @endif

                                                        <input id="plazo_entrega" name="plazo_entrega" type="number" style="width: 70px;" min="1" value="1">


                                                        @if($sigla=='CMB' || $sigla=='CMBCP' || $sigla=='ANPEB' || $sigla=='LPNB')
                                                        <!-- Bienes -->
                                                        <span id="bys"> dia(s) calendario, a partir del dia siguiente habil a la suscripción <span id="contrato">de la órden de compra</span></span>
                                                        @endif

                                                        @if($sigla=='CMS' || $sigla=='CMSCP' || $sigla=='ANPES' || $sigla=='LPNS' || $sigla=='CMDS' )
                                                        <!-- Servicio -->
                                                        <span id="bys"> dia(s) calendario, a partir del dia siguiente habil a la suscripción <span id="contrato">de la órden de servicio</span></span>
                                                        @endif

                                                        <!-- Input que maneja la sigla -->
                                                        <input type="hidden" value="{{$sigla}}" id="sigla">

                                                        <!-- <textarea id="plazo_ent" name="plazo_ent" class="form-control" required rows="2" style="width: 90%;"></textarea> -->

                                                        <div class="invalid-feedback">
                                                            Este campo es obligatorio.
                                                        </div>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="garantia">Garantía<span class="text-danger">*</span></label>

                                                        <div class="form-group" bis_skin_checked="1">
                                                            <p>1 documento escrito por la empresa:</p>
                                                            <select id="garantia_escrito" name="garantia_escrito" class="form-control">
                                                                <option selected="" disabled>-seleccionar-</option>
                                                                <option>Requiere</option>
                                                                <option>No requiere</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group" bis_skin_checked="1">
                                                            <p for="garantia_funcionamiento">Garantia de funcionamiento:</p>
                                                            <select id="garantia_funcionamiento" name="garantia_funcionamiento" class="form-control">
                                                                <option selected="" disabled>-selecionar-</option>
                                                                <option>Requiere</option>
                                                                <option>No requiere</option>
                                                            </select>
                                                        </div>


                                                        <!-- <textarea id="garantia" name="garantia" class="form-control" required="required" rows="2" style="width: 90%;"></textarea> -->


                                                        <div class="invalid-feedback">
                                                            Este campo es obligatorio.
                                                        </div>
                                                    </div>


                                                    <div class="form-group">


                                                        @if($sigla=='CMB' || $sigla=='CMBCP' || $sigla=='ANPEB' || $sigla=='LPNB')
                                                        <label for="lugmed_ent">Lugar y medio de entrega<span class="text-danger">*</span></label>
                                                        @endif

                                                        @if($sigla=='CMS' || $sigla=='CMSCP' || $sigla=='ANPES' || $sigla=='LPNS' || $sigla=='CMDS' )
                                                        <!-- Servicio -->
                                                        <label for="lugmed_ent">Lugar del servicio<span class="text-danger">*</span></label>
                                                        @endif


                                                        <script>
                                                            // Función para habilitar o deshabilitar el textarea según la opción seleccionada
                                                            function gestionarOpcion() {

                                                                const lugarEntregaOtro = document.getElementById("lugar_entrega_otros");
                                                                const lugarEntregaUno = document.getElementById("lugar_entrega_uno");
                                                                const lugarEntregaDos = document.getElementById("lugar_entrega_dos");

                                                                lugarEntregaOtro.disabled = !lugarEntregaDos.checked;

                                                                if (lugarEntregaDos.checked) {
                                                                    lugarEntregaOtro.focus();
                                                                }
                                                                if (lugarEntregaUno.checked) {
                                                                    lugarEntregaOtro.disabled = lugarEntregaUno.checked;
                                                                    lugarEntregaOtro.value = "";
                                                                }
                                                            }
                                                        </script>

                                                        <!-- Seleccionar lugar de entrega -->
                                                        <div class="bd-example">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="lugar_entrega" id="lugar_entrega_uno" value="option1" checked="" onchange="gestionarOpcion()">
                                                                <label class="form-check-label" for="lugar_entrega_uno">

                                                                    @if($sigla=='CMB' || $sigla=='CMBCP' || $sigla=='ANPEB' || $sigla=='LPNB')
                                                                    Av. Aroma Nº 327, frente a la Plaza San Sebastian(Almacenes de la gobernación).
                                                                    @endif

                                                                    @if($sigla=='CMS' || $sigla=='CMSCP' || $sigla=='ANPES' || $sigla=='LPNS' || $sigla=='CMDS' )
                                                                    <!-- Servicio -->
                                                                    Av. Aroma Nº 327, frente a la Plaza San Sebastian.
                                                                    @endif

                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="lugar_entrega" id="lugar_entrega_dos" value="option2" onchange="gestionarOpcion()">
                                                                <label class="form-check-label" for="lugar_entrega_dos">
                                                                    Otro
                                                                </label>
                                                            </div>
                                                            <textarea id="lugar_entrega_otros" name="lugar_entrega_otros" class="form-control" required="required" rows="2" style="width: 90%;" disabled></textarea>
                                                        </div>


                                                        <div class="invalid-feedback">
                                                            Este campo es obligatorio.
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 table-responsive bg-white p-4 mt-3">{{--DETALLE PRODUCTOS--}}
                                            <table id="doctec" class="table table-striped mt-2" style="width: 100%;">
                                                <thead class="table-info">
                                                    <tr class="">
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
                                                        <td><input id="item" type="text" name="item[]" class="form-control col-md-auto item" value="1" disabled></td>
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
                            <button id="enviarFormulario" type="button" class="btn btn-primary">Derivar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->

                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        // Garantia
                        let garantia_escrito = document.getElementById('garantia_escrito');
                        let garantia_funcionamiento = document.getElementById('garantia_funcionamiento');

                        // Lugar de entrega
                        let lugar_entrega_otros = document.getElementById('lugar_entrega_otros');
                        const lugar_entrega = document.querySelector('input[name="lugar_entrega"]:checked')

                        // Sigla de la modalidad
                        const sigla = document.querySelector('#sigla').value;

                        // Plazo de entrega
                        let plazo_entrega = document.getElementById('plazo_entrega');
                        let plazo_entrega_bys = document.getElementById('bys');

                        // Mayor a 15
                        const contratoB = document.getElementById('contrato');


                        // Logica para plazo de entrega
                        plazo_entrega.addEventListener('input', () => {


                            if (Number(plazo_entrega.value) > 15) {

                                plazo_entrega_bys = document.getElementById('bys');
                                plazo_entrega = document.getElementById('plazo_entrega');
                                contrato.innerText = 'del contrato.';
                                console.log('uno');
                            }
                            if (Number(plazo_entrega.value) <= 15) {

                                console.log('dos');
                                console.log(sigla);
                                plazo_entrega_bys = document.getElementById('bys');
                                plazo_entrega = document.getElementById('plazo_entrega');
                                if (sigla === 'CMB' || sigla === 'CMBCP' || sigla === 'ANPEB' || sigla === 'LPNB') {
                                    contrato.innerText = 'de la órden de compra.';
                                }

                                if (sigla === 'CMS' || sigla === 'CMSCP' || sigla === 'ANPES' || sigla === 'LPNS' || sigla === 'CMDS') {
                                    contrato.innerText = 'de la órden de servicio.';
                                }

                            }
                            // console.log(bys.innerText);
                        });


                        // Evento btn para enviarel formulario a guardar
                        document.getElementById("enviarFormulario").addEventListener("click", () => {

                            // document.getElementById('enviarFormulario').setAttribute('disabled', 'true');

                            // Muestra de datos
                            // console.log(plazo_entrega.value);
                            // console.log(garantia_escrito.value);
                            // console.log(garantia_funcionamiento.value);
                            // console.log(lugar_entrega.value);
                            // console.log(lugar_entrega_otros.value);
                            // console.log(sigla.value);

                            let selectores = [];

                            // 3.- Datos de lugar y medio de entrega
                            let entrega_uno = document.getElementById('lugar_entrega_uno');
                            let entrega_dos = document.getElementById('lugar_entrega_dos');
                            let otro = document.getElementById('lugar_entrega_otros');

                            if (entrega_uno.checked) {
                                selectores = ['#plazo_entrega'] //'#doctec tbody tr']
                            }
                            if (entrega_dos.checked) {
                                selectores = ['#plazo_entrega', '#lugar_entrega_otros'] //'#doctec tbody tr']
                            }

                            if (validarCamposRequeridos(selectores)) {
                                if (validarFormularioSelection()) {


                                    let direccion = '';

                                    // 1.- Datos plazo de entrega
                                    const dias = document.getElementById('plazo_entrega');
                                    const texto_entrega = document.getElementById('bys');

                                    const plzo_entrega = {
                                        dias: dias.value,
                                        textoEntrega: texto_entrega.innerText
                                    }

                                    const jsonPlzoEntrega = JSON.stringify({
                                        plzo_entrega
                                    });

                                    // console.log(jsonPlzoEntrega);

                                    // 2.- Datos garantia escrito
                                    garantia_escrito = document.getElementById('garantia_escrito');
                                    garantia_funcionamiento = document.getElementById('garantia_funcionamiento');

                                    // console.log(garantia_escrito.value);
                                    // console.log(garantia_funcionamiento.value);

                                    const garantia_texto = `1 documento escrito por la empresa: ${garantia_escrito.value}\nGarantia de funcionamiento: ${garantia_funcionamiento.value}`;

                                    // console.log(garantia_texto);

                                    // 3.- Datos de lugar y medio de entrega
                                    entrega_uno = document.getElementById('lugar_entrega_uno');
                                    entrega_dos = document.getElementById('lugar_entrega_dos');
                                    otro = document.getElementById('lugar_entrega_otros');

                                    // Sigla de la modalidad
                                    let siglas = document.querySelector('#sigla').value;

                                    if (entrega_uno.checked) {

                                        if (siglas === 'CMB' || siglas === 'CMBCP' || siglas === 'ANPEB' || siglas === 'LPNB') {
                                            direccion = 'Av.Aroma Nº 327, frente a la Plaza San Sebastian(Almacenes de la gobernación).'
                                        }

                                        if (siglas === 'CMS' || siglas === 'CMSCP' || siglas === 'ANPES' || siglas === 'LPNS' || siglas === 'CMDS') {
                                            direccion = 'Av.Aroma Nº 327, frente a la Plaza San Sebastian.'
                                        }

                                    }
                                    if (entrega_dos.checked) {
                                        direccion = otro.value;
                                    }
                                    // console.log(direccion);
                                    // return;


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

                                    // Datos de formulario modificados
                                    datosFormulario['plazo_entrega'] = jsonPlzoEntrega;
                                    datosFormulario['garantia'] = garantia_texto;
                                    datosFormulario['lugar_entrega'] = direccion;

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

                                    // console.log(datosFormulario);

                                    // return;

                                    // Realizar la petición AJAX
                                    $.ajax({
                                        url: '{{route("procesoscont.store_docstec")}}',
                                        type: 'POST',

                                        data: datosFormulario,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },

                                        success: function(respuesta) {
                                            // Manejar la respuesta exitosa del servidor aquí
                                            // console.log(respuesta);

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
                                            toastr.success('Se derivo correctamente', 'SIGECO');

                                        },

                                        error: function(error) {
                                            console.log(error);
                                            // Manejar cualquier error que ocurra durante la solicitud
                                        }
                                    });
                                }
                            } else {
                                toastr.error('Por favor, complete todos los campos requeridos', ' SIGECO');
                            }

                            // Función para validar campos requeridos en todas las ubicaciones
                            function validarCamposRequeridos(selectores) {

                                var validacionExitosa = true;

                                selectores.forEach(function(selector) {
                                    var elementos = $(selector);

                                    elementos.each(function() {
                                        // Verificar si es un textarea o input
                                        if ($(this).is('textarea, input')) {
                                            if (!$(this).val()) {
                                                validacionExitosa = false;
                                                return false; // Salir del bucle each si se encuentra un campo vacío
                                            }
                                        } else {
                                            // Verificar otros elementos (si es necesario)
                                            var camposRequeridos = $(this).find('[required]');

                                            camposRequeridos.each(function() {
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

                            // Validación de seleción
                            function validarFormularioSelection() {
                                var garantiaEscrito = document.getElementById("garantia_escrito").value;
                                var garantiaFuncionamiento = document.getElementById("garantia_funcionamiento").value;

                                if (garantiaEscrito === "-seleccionar-" || garantiaFuncionamiento === "-selecionar-") {
                                    toastr.error('Por favor, complete todos los campos requeridos', ' SIGECO');
                                    return false; // Evitar que el formulario se envíe
                                }
                                // Si todo está bien, el formulario se enviará
                                return true;
                            }

                        });

                    });
                </script>

            </div>
            <!-- /.modal-dialog -->

        </div>
        <!-- /.modal-dialog -->



        <!-- ********** 2.- MODAL ORDEN DE SERVICIO************* -->
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

                                        @php
                                        $idp = $procesosc->id;
                                        $proceso = Procesoscont::find($idp);
                                        $usolic = Unidadesorg::find($proceso->id_unid);
                                        $modalidad = Modalidades::find($proceso->id_mod);
                                        $cont = 1;
                                        $total = 0;
                                        @endphp

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
                                                            <input type="text" name="benef" id="benef" class="form-control" required style="width: 85%">
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12" id="docrefContainer">
                                                        <div class="form-group">
                                                            <label>Documento de Referencia<span class="text-danger">*</span></label>
                                                            <input type="text" name="docref" id="docref" class="form-control" required style="width: 85%">
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

                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="observaciontray">Observación</label>
                                                            <textarea id="observaciontray" name="observaciontray" class="form-control" rows="2" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div>

                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <input type="file" name="filem[]" placeholder="Selecciona archivo" id="filem" multiple>
                                                            @error('filem')
                                                            <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                            @enderror
                                                            <br>
                                                            <label style="font-size: 11px; color:rgb(189, 141, 68);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                            <button id="enviarFormulariOS" type="button" class="btn btn-primary">Derivar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->

                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        document.getElementById("enviarFormulariOS").addEventListener("click", () => {
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

                                    success: function(respuesta) {
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

                                    error: function(error) {
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

                                selectores.forEach(function(selector) {
                                    var elementos = $(selector);

                                    elementos.each(function() {
                                        // Verificar si es un textarea o input
                                        if ($(this).is('textarea, input, select')) {
                                            if (!$(this).val()) {
                                                validacionExitosa = false;
                                                return false; // Salir del bucle each si se encuentra un campo vacío
                                            }
                                        } else {
                                            // Verificar otros elementos (si es necesario)
                                            var camposRequeridos = $(this).find('[required]');

                                            camposRequeridos.each(function() {
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



        <!-- *********** 3.- MODAL ORDEN DE COMPRA*************** -->
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

                                        @php
                                        $idp = $procesosc->id;
                                        $proceso = Procesoscont::find($idp);
                                        $usolic = Unidadesorg::find($proceso->id_unid);
                                        $modalidad = Modalidades::find($proceso->id_mod);
                                        $cont = 1;
                                        $total = 0;
                                        @endphp

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
                                                            <input type="text" name="benefoc" id="benefoc" class="form-control" required style="width: 85%">
                                                            <div class="invalid-feedback">
                                                                Este campo es obligatorio.
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12" id="docrefContainer">
                                                        <div class="form-group">
                                                            <label>Documento de Referencia<span class="text-danger">*</span></label>
                                                            <input type="text" name="docrefoc" id="docrefoc" class="form-control" required style="width: 85%">
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

                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="observaciontray">Observación</label>
                                                            <textarea id="observaciontrayoc" name="observaciontrayoc" class="form-control" rows="2" style="width: 90%;"></textarea>
                                                        </div>
                                                    </div>

                                                    {{--se sube un archivo lleno, debe tener extensión--}}
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <input type="file" name="filemoc[]" placeholder="Selecciona archivo" id="filemoc" multiple>
                                                            @error('filemoc')
                                                            <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                                            @enderror
                                                            <br>
                                                            <label style="font-size: 11px; color:rgb(189, 141, 68);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                                    <div id="editor" class="w-100" style="height: 200px; border: 1px solid #ccc;"></div>

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
                            <button id="enviarFormulariOC" type="button" class="btn btn-primary">Derivar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->

                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        //editor QUILL
                        var quill = new Quill('#editor', {
                            theme: 'snow' // Puedes ajustar el tema según tus preferencias
                        });

                        document.getElementById("enviarFormulariOC").addEventListener("click", () => {

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

                                    success: function(respuesta) {
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

                                    error: function(error) {
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

                                selectores.forEach(function(selector) {
                                    var elementos = $(selector);

                                    elementos.each(function() {
                                        // Verificar si es un textarea o input
                                        if ($(this).is('textarea, input, select')) {
                                            if (!$(this).val()) {
                                                validacionExitosa = false;
                                                return false; // Salir del bucle each si se encuentra un campo vacío
                                            }
                                        } else {
                                            // Verificar otros elementos (si es necesario)
                                            var camposRequeridos = $(this).find('[required]');

                                            camposRequeridos.each(function() {
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




        <!-- ********** 2.- MODAL EVALUAR INEXISTENCIA De ACTIVOS FIJOS ************* -->
        <div class="modal fade show" id="evaluacion" style="padding-right: 17px; display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="formulOS">
                        <div class="modal-header">
                            <h4 class="modal-title text-uppercase">Evaluación para informe de inexistencia</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        @php
                                        $idp = $procesosc->id;
                                        $proceso = Procesoscont::find($idp);
                                        $usolic = Unidadesorg::find($proceso->id_unid);
                                        $modalidad = Modalidades::find($proceso->id_mod);


                                        $cont = 1;
                                        $total = 0;
                                        @endphp

                                        <!-- Tabla de evaluación -->
                                        <div class="col-12 table-responsive bg-white p-4 mt-3">
                                            <span>Lista de Especificciones Técnicas</span>
                                            <table id="inexistencia" class="table table-striped mt-2" style="width: 100%;">
                                                <thead class="table-info">
                                                    <tr class="">
                                                        <!-- <th style="display: none;">ID</th> -->
                                                        <th style="display: #fff; width: 8%;">Item</th>
                                                        <th style="display: #fff;">Descripción</th>
                                                        <th style="display: #fff;">Cantidad solicitada</th>
                                                        <th style="display: #fff;">Disponibilidad</th>
                                                        <th style="display: #fff;">Cantidad no disponible</th>
                                                        <!-- <th style="display: #fff;">Estado</th> -->
                                                        <th style="display: #fff; width: 15%;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($arrayDetalleTec as $detalleTec)
                                                    @if($detalleTec->item != null)
                                                    <tr>
                                                        <td>{{$detalleTec->item}}</td>
                                                        <td>{{$detalleTec->descripcion}}</td>
                                                        <td>{{$detalleTec->cantidad}}</td>
                                                        <!-- Disponibilidad -->
                                                        <td>
                                                            <input class="form-control" value="0" type="number" min="0" step="1">
                                                        </td>
                                                        <td>{{$detalleTec->cantidad}}</td>
                                                        <td>
                                                            <a href="#" class=" btn btn-primary text-uppercase btn-sm"><i class="fas fa-save"></i> guardar</a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                            <button id="enviarFormulariOS" type="button" class="btn btn-primary">Derivar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {



                        document.getElementById("enviarFormulariOS").addEventListener("click", () => {
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

                                    success: function(respuesta) {
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

                                    error: function(error) {
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

                                selectores.forEach(function(selector) {
                                    var elementos = $(selector);

                                    elementos.each(function() {
                                        // Verificar si es un textarea o input
                                        if ($(this).is('textarea, input, select')) {
                                            if (!$(this).val()) {
                                                validacionExitosa = false;
                                                return false; // Salir del bucle each si se encuentra un campo vacío
                                            }
                                        } else {
                                            // Verificar otros elementos (si es necesario)
                                            var camposRequeridos = $(this).find('[required]');

                                            camposRequeridos.each(function() {
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
    $(document).ready(function() {

        // Inicializar AdminLTE
        $('.dropdown-toggle').dropdown();

        // Escuchar el evento de mostrar el menú desplegable
        $('.dropdown-toggle').on('shown.bs.dropdown', function() {
            // Actualizar aria-expanded a true
            $(this).attr('aria-expanded', 'true');
        });

        // Función para inicializar Select2
        function inicializarSelect2() {
            $('#opciones, #opcionesm, #opcionesmoc').select2(); // Inicializar Select2 en tu select con el ID "opciones"
        }

        function configurarAgregarEliminarFilas() {
            // Contador para ítems
            var contadorItems = obtenerUltimoNumeroItem() + 1;

            // Agregar fila
            $('#agregar-fila').click(function() {
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

                filas.each(function() {
                    var camposRequeridos = $(this).find('[required]');

                    camposRequeridos.each(function() {
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
            $('#doctec').on('click', '.eliminar-fila', function() {
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
                filas.each(function(index) {
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
                filas.each(function() {
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

                // console.log(precioReferencial);

                $('#doctec tbody tr').each(function() {
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
            $('#doctec tbody').on('input', 'input[name^="cantidad"], input[name^="precio"]', function() {
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