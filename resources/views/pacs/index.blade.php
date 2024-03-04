@extends('adminlte::page')

@section('title', 'Programa Anual de Contrataciones')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">PACs Procesos mayores a 20.000Bs</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <a class="btn btn-primary" href="{{route('pacs.crear')}}"><i class="fa fa-plus"></i>Registrar PAC</a>
            <hr>

            <div class="col-12 table-responsive bg-white p-4 mt-3">


                <table id="progs" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: #fff;">Código</th>
                            <th style="display: #fff;">Unidad Solicitante</th>
                            <th style="display: #fff;">Modalidad</th>
                            <th style="display: #fff;">Objeto</th>
                            <th style="display: #fff;">Precio Ref.</th>
                            <th style="display: #fff;">Estado</th>
                            <th style="display: #fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                           use App\Models\Unidadesorg;
                           use App\Models\Modalidades;
                           use App\Models\Procesoscont;
                        @endphp
                        @foreach($programas as $programa)
                            <tr>
                                <td style="display: none;">{{$programa->id}}</td>
                                @php
                                    $unidad = Unidadesorg::find($programa->id_unid);
                                    $modalidad = Modalidades::find($programa->id_mod);
                                    
                                    if ($programa->estado == 1) {
                                        $proceso = Procesoscont::select("*")
                                            ->where('id_pac', $programa->id)
                                            ->first();

                                        $codigo = $proceso->codigo;
                                    }else{
                                        $codigo = "";
                                    }
                                
                                @endphp
                                <td>{{$codigo}}</td>
                                <td>{{$unidad->nombre}}</td>
                                <td>{{$modalidad->nombre}}</td>
                                <td>{{$programa->objeto}}</td>
                                <td>{{$programa->precio_ref}}</td>
                                @if ($programa->estado == 0)
                                    <td>Sin aprobar</td>
                                @else
                                    <td>Aprobado</td>
                                @endif
                                @if ($programa->estado == 0)
                                    <td>
                                        {{--Editar--}}
                                        <a href="{{ route('pacs.editar', $programa->id) }}" alt="Editar">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-pencil-alt"></i> 
                                            </button>
                                        </a>
                                        {{--Eliminar--}}
                                        <form action="{{route('pacs.destroy',$programa->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Está seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-primary" type="submit">
                                                <i class="far fa-trash-alt"></i> 
                                            </button>
                                        </form>
                                        {{--Aprobar/Iniciar--}}
                                        <a href="{{ route('trayectoria.storenewp', $programa->id) }}" alt="Aprobar" onclick="return confirm('¿Está seguro de aprobar el PAC?')">
                                            <button class="btn btn-success">
                                                <i class="fas fa-check-double"></i> 
                                            </button>
                                        </a>

                                    </td>
                                @else
                                    <td>
                                        {{--BOTON Ver/Imprimir--}}
                                        <a class="btn btn-primary" href="{{route('pacs.pdfpac', $programa->id)}}" target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        
                                        @php
                                            $proceso = Procesoscont::where('id_pac', $programa->id)->first();
                                            $idproc = $proceso->id;
                                        @endphp
                                        {{--Seguimiento--}}
                                        <a href="{{ route('trayectoria.seguirproc', ['idproc' => $idproc, 'deproc' => '2']) }}" alt="Seguimiento">
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
    var table = new DataTable('#progs', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
    console.log('Hi!');
</script>
@stop