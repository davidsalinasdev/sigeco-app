@extends('adminlte::page')

@section('title', 'Procesos de Contratación')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h4 class="page__heading p-3 text-uppercase">Procesos de Contratación</h4>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a class="btn btn-primary text-sm text-uppercase" href="{{route('procesoscont.crear')}}"><i class="fa fa-plus"></i> Nueva Solicitud de Proceso</a>
            </div>
            <div class="col-12 table-responsive bg-white p-4 mt-3">
                <table id="proces" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-info table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: #fff; width: 8%;">Código</th>
                            <th style="display: #fff;">Unidad</th>
                            <th style="display: #fff;">Modalidad</th>
                            <th style="display: #fff;">Objeto</th>
                            <th style="display: #fff;">Precio Ref.</th>
                            <th style="display: #fff;">Estado</th>
                            <th style="display: #fff; width: 7%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        use App\Models\Unidadesorg;
                        use App\Models\Modalidades;
                        @endphp

                        @foreach($procesosconts as $procesoscont)
                        <tr>
                            <td style="display: none;">{{$procesoscont->id}}</td>
                            <td>{{$procesoscont->codigo}}</td>
                            @php
                            $unidad = Unidadesorg::find($procesoscont->id_unid);
                            $modalidad = Modalidades::find($procesoscont->id_mod);
                            @endphp
                            <td>{{$unidad->nombre}}</td>
                            <td>{{$modalidad->nombre}}</td>
                            <td>{{$procesoscont->objeto}}</td>
                            <td>{{$procesoscont->precio_ref}}</td>
                            <td>{{$procesoscont->estado}}</td>
                            @if ($procesoscont->estado == 0)
                            <td>
                                {{--Editar--}}
                                <a href="{{ route('procesoscont.editar', $procesoscont->id) }}" alt="Editar" class="btn btn-warning" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                {{--Eliminar--}}
                                <form action="{{route('procesoscont.destroy',$procesoscont->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Está seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit" title="Eliminar">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                                {{--Iniciar--}}
                                <a href="{{ route('trayectoria.iniciarproc', $procesoscont->id) }}" class="btn btn-success mt-1" alt="Iniciar" title="Iniciar">
                                    <i class="far fa-play-circle"></i>
                                </a>
                            </td>
                            @else
                            <td>
                                {{--BOTON Ver/Imprimir--}}
                                <a class="btn btn-primary" href="{{route('procesoscont.pdf_proc', $procesoscont->id)}}" target="_blank" title="Archivo">
                                    <i class="fas fa-file-pdf"></i>
                                </a>

                                {{--Seguimiento--}}
                                <a href="{{ route('trayectoria.seguirproc', ['idproc' => $procesoscont->id, 'deproc' => '1']) }}" class="btn btn-info" alt="Seguimiento" title="Seguimiento">
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="pagination justify-content-end">
                    {!! $procesosconts->links() !!}
                </div> --}}
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
        $('#proces').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>

@stop