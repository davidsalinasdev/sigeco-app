@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Usuarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            @can('crud-usuario')
            {{-- <a class="btn btn-primary" href="{{route('users.create')}}"><i class="fa fa-plus"></i> Crear usuario</a> --}}
            @endcan
            <hr>

            <div class="col-12 table-responsive bg-white p-4 mt-3">


                <table id="usuarios" class="table table-striped mt-2" style="width: 100%;">
                    <thead class="table-header">
                        <tr class="table-header__encabezado">
                            <th style="display: none;">ID</th>
                            <th style="display: #fff;">Nombre Completo</th>
                            <th style="display: #fff;">Usuario</th>
                            <th style="display: #fff;">Rol</th>
                            <th style="display: #fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="display: none;">{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $rolname)
                                <h5><span class="badge badge-dark">{{$rolname}}</span></h5>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-info" href="{{ route('users.edit', $user->id) }}">Editar</a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style'=>'display:inline']) !!}
                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
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
<link rel="stylesheet" href="/sigeco/public/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    var table = new DataTable('#usuarios', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
    console.log('Hi!');
</script>
@stop