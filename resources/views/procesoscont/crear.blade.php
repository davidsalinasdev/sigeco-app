@extends('adminlte::page')

@section('title', 'Solicitud Proceso de Contratación')

@section('content_header')
@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h4 class="page__heading text-uppercase p-3">Solicitud Proceso de Contratación</h3>
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
                        <div class="row">
                            <div class="col-12 col-xl-4 card">
                                <div class="card-header">
                                    Formulario de Registro
                                </div>
                                <div class="card-body">
                                    {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                    @php
                                    use App\Models\Unidadesorg;
                                    use App\Models\Modalidades;
                                    @endphp
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            @php
                                            //$options = Modalidades::all();//todas las modalidades
                                            $options = Modalidades::select("*")
                                            ->where('nombre', '=', 'Contratación Menor Bienes (1-20.000)')
                                            ->orwhere('nombre', '=', 'Contratación Menor Servicio (1-20.000)')
                                            ->orwhere('nombre', '=', 'Contratación Menor de Consultores Individuales de Linea (1-20.000)')
                                            ->orwhere('nombre', '=', 'Contratación Menor de Consultorias por Producto (1-20.000)')
                                            ->orwhere('nombre', '=', 'Contratación Menor Directa de Servicios (1-20.000)')
                                            ->orderBy('id', 'asc')
                                            ->get();
                                            @endphp
                                            <label for="opciones">Modalidad</label>
                                            <select name="opciones" id="opciones" required style="width: 500px;">
                                                <option value="">Selecciona una opción</option>
                                                @foreach($options as $option)
                                                <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <label id=titform name=titform></label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="objeto">Objeto de la Contratación</label>
                                            {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
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
                                        <button type="submit" class="btn btn-primary" id="crear-proceso">Crear</button>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#opciones').select2(); // Inicializar Select2 en tu select con el ID "opciones"
    });

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

<!-- Validando el boton crear proceso -->
<script>
    $(document).ready(function() {
        $('form').submit(function() {
            // Deshabilita el botón de enviar después del clic
            $('#crear-proceso').prop('disabled', true);
        });
    });
</script>
@stop