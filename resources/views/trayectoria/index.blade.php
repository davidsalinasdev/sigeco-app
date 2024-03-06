@extends('adminlte::page')

@section('title', 'Bandeja de Procesos')

@section('content_header')
@stop



@section('content')
<section class="section">
    <div class="section-header">
        <h4 class="page__heading p-3 text-uppercase">Bandeja | Trayectoria</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <hr>
            <div class="col-12 table-responsive bg-white p-4 mt-3">
                <table id="trayectos" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header table-info">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: none;">Fecha creacion</th>
                            <th style="display: #fff;width: 8%;">Código</th>
                            <th style="display: #fff;">Objeto</th>
                            <th style="display: #fff;">Etapa en Remitente</th>
                            <th style="display: #fff;">Etapa actual</th>
                            <th style="display: #fff;">Unid. Remitente</th>
                            <th style="display: #fff;">Fecha Ingreso</th>
                            <th style="display: #fff; width: 8%;">Acciones</th>
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
                            <td style="display: none;">{{$procesoscont->created_at}}</td>
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
                                <a href="{{ route('trayectoria.recibirproc', $procesoscont->idtray) }}" alt="Recibir" title="Recibir" class="btn btn-success">
                                    <i class="fas fa-download"></i>
                                </a>
                                {{--Seguimiento--}}
                                <a href="{{ route('trayectoria.seguirproc', ['idproc' => $procesoscont->idproc, 'deproc' => '3']) }}" class="btn btn-info" alt="Seguimiento" title="Seguimiento">
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                            @else{{-- estadotray="recibido"   --}}
                            <td>
                                {{--Derivar--}}
                                <a href="{{ route('trayectoria.derivarproc', $procesoscont->idtray) }}" alt="Derivar" title="Derivar" class="btn btn-warning">
                                    <i class="fas fa-share-square"></i>
                                </a>
                                {{--Finalizar--}}
                                {{-- <a href="{{ route('trayectoria.finalizarproc', $procesoscont->idtray) }}" class="btn btn-primary" alt="Finalizar" title="Finalizar">
                                <i class="fas fa-file-archive"></i>
                                </a> --}}
                                {{--Seguimiento--}}
                                <a href="{{ route('trayectoria.seguirproc', ['idproc' => $procesoscont->idproc, 'deproc' => '3']) }}" class="btn btn-info" alt="Seguimiento" title="Seguimiento">
                                    <i class="far fa-eye"></i>
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

@section('js')
@parent
<!-- Tu script de DataTables -->
<script>
    $(document).ready(function() {
        // Inicializa DataTable
        $('#trayectos').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },
            order: [
                [1, 'desc']
            ] // La columna de "Fecha Ingreso" es la séptima columna (índice 6 en base cero)
        });
    });
</script>

@stop