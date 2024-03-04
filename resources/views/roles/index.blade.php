@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Roles</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        @can('crear-rol')
                        <a class="btn btn-primary" href="{{ route('roles.create') }}">Crear rol</a>
                        @endcan
                        <hr>
                        <table id="roles" class="table table-striped mt-2" style="width: 100%;">
                            <thead style="background-color: #6777ef;">
                                <tr>
                                    <th style="display: #fff;">Rol</th>
                                    <th style="display: #fff;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td style="width: 80%;">{{$role->name}}</td>
                                    <td style="width: 20%;">
                                        @can('editar-rol')
                                        <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Editar</a>
                                        @endcan

                                        @can('borrar-rol')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style'=>'display:inline']) !!}
                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-end">
                            {!! $roles->links() !!}
                        </div>
                    </div>
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
    var table = new DataTable('#roles', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },

    });
</script>
<script>
    console.log('Hi!');
</script>
@stop