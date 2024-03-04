@extends('adminlte::page')

@section('title', 'Bandeja de Procesos')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Bandeja | Trayectoria</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <hr>
            <div class="col-12 table-responsive bg-white p-4 mt-3">
                <table id="trayectos" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: #fff;">Código</th> 
                            <th style="display: #fff;">Objeto</th>
                            <th style="display: #fff;">Etapa en Remitente</th>
                            <th style="display: #fff;">Etapa actual</th>
                            <th style="display: #fff;">Unid. Remitente</th>
                            <th style="display: #fff;">Fecha Ingreso</th>
                            <th style="display: #fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                           use App\Models\Unidadesorg;
                           use App\Models\Modalidades;
                           use App\Models\Etapasproc;
                        @endphp
                        @foreach($procesosconts as $procesoscont)
                            <tr>
                                <td style="display: none;">{{$procesoscont->id}}</td>
                                <td>{{$procesoscont->codigo}}</td>
                                @php
                                    $eant = Etapasproc::find($procesoscont->id_eanterior);
                                    $eact = Etapasproc::find($procesoscont->id_eactual);
                                    $esgte = Etapasproc::find($procesoscont->id_esgte);
                                    $uant = Unidadesorg::find($procesoscont->id_uorigen);
                                    $uact = Unidadesorg::find($procesoscont->id_uactual);
                                    $udes = Unidadesorg::find($procesoscont->id_udestino);
                                @endphp
                                <td>{{$procesoscont->objeto}}</td>
                                <td>{{$eant->nom_etapa}}</td>
                                <td>{{$eact->nom_etapa}}</td>
                                <td>{{$uant->nombre}}</td>
                                <td>{{$procesoscont->fecha_ing}}</td>
                                @if ($procesoscont->estadotray == 'iniciado' or $procesoscont->estadotray == 'derivado')
                                    <td>
                                        {{--Recibir--}}
                                        <a href="{{ route('trayectoria.recibirproc', $procesoscont->idtray) }}" alt="Recibir">
                                            <button class="btn btn-success">
                                                <i class="fas fa-download"></i> 
                                            </button>
                                        </a>
                                        {{--Seguimiento--}}
                                        <a href="{{ route('trayectoria.seguirproc', ['idproc' => $procesoscont->idproc, 'deproc' => '3']) }}" alt="Seguimiento">
                                            <button class="btn btn-primary">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                @else{{--   estadotray="recibido"   --}}
                                   <td>
                                        {{--Derivar--}}
                                        <a href="{{ route('trayectoria.derivarproc', $procesoscont->idtray) }}" alt="Derivar">
                                            <button class="btn btn-success">
                                                <i class="fas fa-share-square"></i> 
                                            </button>
                                        </a>
                                        {{--Finalizar--}}
                                        {{-- <a href="{{ route('trayectoria.finalizarproc', $procesoscont->idtray) }}" alt="Finalizar">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-file-archive"></i>
                                            </button>
                                        </a> --}}
                                        {{--Seguimiento--}}
                                        <a href="{{ route('trayectoria.seguirproc', ['idproc' => $procesoscont->idproc, 'deproc' => '3']) }}" alt="Seguimiento">
                                            <button class="btn btn-primary">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

<script>
    var table = new DataTable('#trayectos', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
    console.log('Hi!');
</script>
@stop