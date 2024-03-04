@extends('adminlte::page')

@section('title', 'Etapas')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Etapas de un Proceso de Contratación</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <a class="btn btn-primary" href="{{route('etapasproc.crear')}}"><i class="fa fa-plus"></i> Crear Etapa</a>
            <hr>

            <div class="col-12 table-responsive bg-white p-4 mt-3">
                <table id="etapas" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: #fff;">Modalidad</th>
                            <th style="display: #fff;">Nro. Etapa</th>
                            <th style="display: #fff;">Etapa</th>
                            <th style="display: #fff;">Sgte. Etapa</th>
                            <th style="display: #fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                           use App\Models\Modalidades;
                        @endphp
                        @foreach($etapasprocs as $etapa)
                        <tr>
                            <td style="display: none;">{{$etapa->id}}</td>
                            @php
                                $modalidad = Modalidades::find($etapa->id_mod);
                            @endphp
                            <td>{{$modalidad->nombre}}</td>
                            <td>{{$etapa->nro_etapa}}</td>
                            <td>{{$etapa->nom_etapa}}</td>
                            <td>{{$etapa->sig_etapa}}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('etapasproc.editar', $etapa->id) }}">Editar</a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['etapasproc.destroy', $etapa->id], 'style'=>'display:inline']) !!}
                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination justify-content-end">
                    {!! $etapasprocs->links() !!}
                </div>

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
    var table = new DataTable('#etapas', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
    console.log('Hi!');
</script>
@stop