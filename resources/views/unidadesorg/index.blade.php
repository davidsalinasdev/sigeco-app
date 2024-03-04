@extends('adminlte::page')

@section('title', 'Unidades Organizacionales')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Unidades Organizacionales</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <a class="btn btn-primary" href="{{route('unidadesorg.crear')}}"><i class="fa fa-plus"></i>Registrar Unidad Organizacional</a>
            <hr>

            <div class="col-12 table-responsive bg-white p-4 mt-3">


                <table id="orgs" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: #fff;">Número Unidad</th>
                            <th style="display: #fff;">Nombre Unidad</th>
                            <th style="display: #fff;">Sigla</th>
                            <th style="display: #fff;">Dependencia</th>
                            <th style="display: #fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unidadesorgs as $unidadesorg)
                        <tr>
                            <td style="display: none;">{{$unidadesorg->id}}</td>
                            <td>{{$unidadesorg->numuni}}</td>
                            <td>{{$unidadesorg->nombre}}</td>
                            <td>{{$unidadesorg->sigla}}</td>
                            <td>{{$unidadesorg->dependencia}}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('unidadesorg.editar', $unidadesorg->id) }}">Editar</a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['unidadesorg.destroy', $unidadesorg->id], 'style'=>'display:inline']) !!}
                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination justify-content-end">
                    {!! $unidadesorgs->links() !!}
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
    var table = new DataTable('#orgs', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
    console.log('Hi!');
</script>
@stop