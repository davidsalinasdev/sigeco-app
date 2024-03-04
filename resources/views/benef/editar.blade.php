@extends('adminlte::page')

@section('title', 'Editar Beneficiarios')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Editar Beneficiarios</h3>
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
                        
                        {!! Form::model($benef, ['method' => 'PUT', 'route' => ['benef.update', $benef->id]]) !!}
                        <div class="row">
                            <div class="col-12 col-xl-4 card">
                                <div class="card-header">
                                    Modificar Datos
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="name">Nombre/Razón Social</label>
                                        {!! Form::text('razonsocial', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>CI/NIT</label>
                                        {!! Form::text('cinit', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Domicilio Fiscal</label>
                                        {!! Form::text('domicilio_fiscal', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tipo NIT</label>
                                        {!! Form::text('tipo_nit', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a class="btn btn-danger" href="{{route('benef.index')}}">Cancelar</a>

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