@extends('adminlte::page')

@section('title', 'Editar Proceso de Contratación')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading p-3">Editar Proceso de Contratación</h3>
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
                        <div class="row">
                            <div class="col-12 col-xl-4 card">
                                <div class="card-header">
                                    Modificar Datos
                                </div>
                                <div class="card-body">
                                    {!! Form::model($procesosc, ['method' => 'PUT', 'route' => ['procesoscont.update', $procesosc->id]]) !!}
                                    @php
                                        use App\Models\Unidadesorg;
                                        use App\Models\Modalidades;
                                    @endphp
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label >Código</label>
                                            {{$procesosc->codigo}}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            @php
                                            $modalidad = Modalidades::find($procesosc->id_mod);
                                            @endphp
                                            <label>Modalidad</label>
                                            {{$modalidad->nombre}}
                                            {{--
                                            //cuando puede elegir otra modalidad
                                            @php
                                            //$options = Modalidades::all();//todas las modalidades
                                            $options = Modalidades::select("*")
                                                    ->where('nombre', '=', 'Contratación Menor Bienes (1-20.000)')
                                                    ->orwhere('nombre', '=', 'Contratación Menor Servicio (1-20.000)')
                                                    ->get();
                                            @endphp
                                            <label for="name">Modalidad</label>
                                            <select name="opciones" id="opciones" style="width: 500px;" disabled>
                                                @foreach($options as $option)
                                                    <option value="{{ $option->id }}" {{ $option->id == $procesosc->id_mod ? 'selected' : '' }}>{{ $option->nombre }}</option>
                                                @endforeach
                                            </select>
                                            --}}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="objeto">Objeto de la Contratación</label>
                                            {!! Form::textarea('objeto', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Precio Referencial (estimado en Bs.)</label>
                                            {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required', 'oninput' => 'validarPrecio(this)')) !!}
                                            <small id="errorPrecioRef" style="color: red;"></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
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
@stop

@section('js')
<script>
    console.log('Hi!');

    var valorMinimo = 1; // Define el valor mínimo permitido
    var valorMaximo = 20000; // Define el valor máximo permitido

    function validarPrecio(input) {
        // Obtener el valor ingresado
        var valor = input.value.trim();

        // Verificar si es un número y está dentro de los límites especificados
        if (isNaN(valor) || parseFloat(valor) < valorMinimo || parseFloat(valor) > valorMaximo) {
            document.getElementById('errorPrecioRef').innerHTML = 'Ingrese un número válido entre ' + valorMinimo + ' y ' + valorMaximo + '.';
            input.setCustomValidity('Inválido');
        } else {
            document.getElementById('errorPrecioRef').innerHTML = '';
            input.setCustomValidity('');
        }
    }

</script>
@stop