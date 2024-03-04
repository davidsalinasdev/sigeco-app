@extends('adminlte::page')

@section('title', 'Editar Unidades Organizacionales')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Editar Unidades Organizacionales</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>
                            @foreach ($errors->all() as $error)
                            <span class="badge badge-danger">{{$error}}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        
                        {!! Form::model($unidadesorg, ['method' => 'PUT', 'route' => ['unidadesorg.update', $unidadesorg->id]]) !!}
                        <div class="row">
                            <div class="col-12 col-xl-4 card">
                                <div class="card-header">
                                    Modificar Datos
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="name">Número de Unidad</label>
                                        {!! Form::text('numuni', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Nombre Unidad</label>
                                            {!! Form::text('nombre', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Sigla</label>
                                            {!! Form::text('sigla', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Dependencia</label>
                                        {!! Form::text('dependencia', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Observación</label>
                                        {!! Form::text('observacion', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a class="btn btn-danger" href="{{route('unidadesorg.index')}}">Cancelar</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop