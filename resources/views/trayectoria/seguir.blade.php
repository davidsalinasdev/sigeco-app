@extends('adminlte::page')

@section('title', 'Seguimiento a Proceso')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Seguimiento a Proceso</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <hr>
            @php
                use App\Models\Unidadesorg;
                use App\Models\Modalidades;
                use App\Models\Procesoscont;
                use App\Models\Etapasproc;
                use App\Models\Listaverif;
                use App\Models\Docsgen;
                use App\Models\Docstec;
                
                $proceso = Procesoscont::find($idproc);
                $usolic = Unidadesorg::find($proceso->id_unid);
                $modalidad = Modalidades::find($proceso->id_mod);
            @endphp
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
                        <label>Modalidad</label>
                        {{$modalidad->nombre}}
                    </div>
                </div>
            </div>
            <div class="col-12 table-responsive bg-white p-4 mt-3">
                <table id="trays" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: #fff;">Etapa en Remitente</th>
                            <th style="display: #fff;">Etapa en Destinatario</th>
                            <th style="display: #fff;">Unid. Remitente</th>
                            <th style="display: #fff;">Unid. Destinatario</th>
                            <th style="display: #fff;">Fecha Ingreso</th>
                            <th style="display: #fff;">Fecha Salida</th>
                            <th style="display: #fff;">Archivos Adjuntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trayects as $trayect)
                            <tr>
                                @php
                                    //$unidad = Unidadesorg::find($procesoscont->id_unid);
                                    //$modalidad = Modalidades::find($procesoscont->id_mod);
                                    
                                    $id_esgte = $trayect->id_esgte;

                                    $eact = Etapasproc::find($trayect->id_eactual);
                                    $esig = Etapasproc::find($id_esgte);
                                    
                                    $uact = Unidadesorg::find($trayect->id_uactual);
                                    if ($trayect->id_udestino !== null && $trayect->id_udestino !== '') {
                                        $udes = Unidadesorg::find($trayect->id_udestino);
                                        $nomudes = $udes->nombre;
                                    } else{
                                        $nomudes = "";
                                    }

                                    $etapafiles = Listaverif::select("*")
                                        ->where('id_tray',$trayect->id)
                                        ->get();
                                    
                                    //documento generado en etapa actual
                                    $docgen = Docsgen::select("*")
                                                            ->where('id_etapa', $eact->id)
                                                            ->first();
                                    $nom_doc = $docgen->nom_doc;
                                @endphp
                                
                                <td>{{$eact->nom_etapa}}</td>
                                
                                @if ($id_esgte <> 0){{--si no es etapa final--}}
                                    <td>{{$esig->nom_etapa}}</td>
                                @else
                                    <td>Fin del proceso</td>
                                @endif

                                <td>{{$uact->nombre}}</td>
                                <td>{{$nomudes}}</td>
                                <td>{{$trayect->fecha_ing}}</td>
                                <td>{{$trayect->fecha_env}}</td>
                                <td>
                                    
                                    @switch($nom_doc)
                                        @case('ESPECIFICACIONES TÉCNICAS')
                                            @php
                                                $doctec = Docstec::select("*")
                                                            ->where('id_proc', $proceso->id)
                                                            ->where('nom_doc', $nom_doc)
                                                            ->first();
                                            @endphp
                                            
                                            @if ($doctec)
                                                {{--BOTON Ver/Imprimir--}}
                                                <a class="btn btn-primary" href="{{route('procesoscont.pdfdt', $doctec->id)}}" target="_blank">
                                                    <i class="far fa-file-pdf"></i>
                                                    Esp.Tec.
                                                </a>
                                            @endif

                                            @break
                                        @case('INICIO DE ACTIVIDADES PREVIAS')
                                            {{--BOTON Ver/Imprimir--}}
                                            <a class="btn btn-primary" href="{{route('procesoscont.pdf_proc', $proceso->id)}}" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                                Proceso
                                            </a>
                                            @break
                                        @case('PAC')
                                            {{--BOTON Ver/Imprimir--}}
                                            <a class="btn btn-primary" href="{{route('pacs.pdfpac', $proceso->id_pac)}}" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                                PAC
                                            </a>
                                            
                                            @break
                                        @case('AUTORIZACIÓN DE INICIO')
                                                                    
                                            @if ($proceso->autorizado == 1)
                                                <label  style="font-size: 13px; color:rgb(56, 141, 116);">
                                                    INICIO AUTORIZADO
                                                </label>
                                            @endif
                    
                                            @break
                                        @case('INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE SERVICIO')
                                            
                                            @php
                                            $nomd = "ESPECIFICACIONES TÉCNICAS";
                                            $doctec = Docstec::select("*")
                                                        ->where('id_proc', $proceso->id)
                                                        ->where('nom_doc', $nomd)
                                                        ->first();
                                            @endphp
                                            
                                            @if ($doctec)
                                                {{--BOTON Ver/Imprimir--}}
                                                <a class="btn btn-primary" href="{{route('procesoscont.pdfos', $doctec->id)}}" target="_blank">
                                                    <i class="far fa-file-pdf"></i>
                                                    Ord.Serv.
                                                </a>
                                            @endif

                                            @break
                                        @case('REPORTE DE PRECIOS E INEXISTENCIAS - INFORME DE SELECCIÓN DE PROVEEDOR - ORDEN DE COMPRA')
                                            
                                            @php
                                            $nomd = "ESPECIFICACIONES TÉCNICAS";
                                            $doctec = Docstec::select("*")
                                                        ->where('id_proc', $proceso->id)
                                                        ->where('nom_doc', $nomd)
                                                        ->first();
                                            @endphp
                                            
                                            @if ($doctec)
                                                {{--BOTON Ver/Imprimir--}}
                                                <a class="btn btn-primary" href="{{route('procesoscont.pdfoc', $doctec->id)}}" target="_blank">
                                                    <i class="far fa-file-pdf"></i>
                                                    Ord.Compra
                                                </a>
                                            @endif

                                            @break                                        

                                    @endswitch
                                    
                                    {{--si existe archivos adjuntos--}}
                                    @foreach ($etapafiles as $etapafile)
                                        <a href="{{ route('trayectoria.descargararch', ['id' => $etapafile->id]) }}">{{$etapafile->namefile}}</a>
                                        &nbsp;&nbsp;&nbsp
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($deproc == '1')
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a class="btn btn-primary" href="{{route('procesoscont.index')}}">Volver</a>
                    </div>
                @elseif ($deproc == '2')
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <a class="btn btn-primary" href="{{route('pacs.index')}}">Volver</a>
                        </div>
                    @else
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <a class="btn btn-primary" href="{{route('trayectoria.index')}}">Volver</a>
                        </div>
                @endif
                {{-- <div class="pagination justify-content-end">
                    {!! $trayects->links() !!}
                </div> --}}

            </div>
        </div>
    </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

{{-- <script>
    var table = new DataTable('#trays', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
    console.log('Hi!');
</script> --}}
@stop