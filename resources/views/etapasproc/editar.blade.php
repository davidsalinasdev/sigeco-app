@extends('adminlte::page')

@section('title', 'Editar Usuarios')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Editar Etapas de un Proceso de Contratación</h3>
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
                        
                        {!! Form::model($etapasp, ['method' => 'PUT', 'route' => ['etapasproc.update', $etapasp->id]]) !!}
                        <div class="row">
                            <div class="col-12 col-xl-4 card">
                                <div class="card-header">
                                    Modificar Datos
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nro. Etapa</label>
                                        {!! Form::text('nro_etapa', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Etapa</label>
                                        {!! Form::text('nom_etapa', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Sgte. Etapa</label>
                                        {!! Form::text('sig_etapa', null, array('class'=>'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        @php
                                        use App\Models\Modalidades;
                                        $options = Modalidades::all();
                                        @endphp
                                        <label for="name">Modalidad</label>
                                        <select name="opciones" id="opciones">
                                            @foreach($options as $option)
                                                <option value="{{ $option->id }}" {{ $option->id == $etapasp->id_mod ? 'selected' : '' }}>{{ $option->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a class="btn btn-danger" href="{{route('etapasproc.index')}}">Cancelar</a>
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