@extends('adminlte::page')

@section('title', 'Beneficiarios')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Beneficiarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <a class="btn btn-primary" href="{{route('benef.crear')}}"><i class="fa fa-plus"></i>Registrar Beneficiario</a>
            <hr>

            <div class="col-12 table-responsive bg-white p-4 mt-3">


                <table id="bens" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: #fff;">Nombre/Razón Social</th>
                            <th style="display: #fff;">CI/NIT</th>
                            <th style="display: #fff;">Domicilio</th>
                            <th style="display: #fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($benefs as $benef)
                        <tr>
                            <td style="display: none;">{{$benef->id}}</td>
                            <td>{{$benef->razonsocial}}</td>
                            <td>{{$benef->cinit}}</td>
                            <td>{{$benef->domicilio_fiscal}}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('benef.editar', $benef->id) }}">Editar</a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['benef.destroy', $benef->id], 'style'=>'display:inline']) !!}
                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination justify-content-end">
                    {!! $benefs->links() !!}
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
    var table = new DataTable('#bens', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
    console.log('Hi!');
</script>
@stop