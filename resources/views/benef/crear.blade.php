@extends('adminlte::page')

@section('title', 'Registrar Beneficiarios')

@section('content_header')
@stop

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Beneficiarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
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
    
                            {!! Form::open(array('route'=>'benef.store', 'method'=>'POST')) !!}
                            <div class="row">
                                <div class="col-12 col-xl-4 card">
    
                                    <div class="card-header">
                                        Formulario de Registro
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="name">Nombre/Razón Social</label>
                                                {!! Form::text('razonsocial', null, array('class'=>'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>CI/NIT</label>
                                                {!! Form::number('cinit', null, ['class' => 'form-control', 'pattern' => '[0-9]+', 'title' => 'Ingrese solo números', 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="name">Domicilio Fiscal</label>
                                                {!! Form::text('domicilio_fiscal', null, array('class'=>'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="name">Tipo NIT</label>
                                                {!! Form::text('tipo_nit', null, array('class'=>'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
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