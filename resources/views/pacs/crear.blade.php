@extends('adminlte::page')

@section('title', 'Registrar Programa Anual de Contrataciones')

@section('content_header')
@stop

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registrar Programa Anual de Contrataciones</h3>
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
                                        {!! Form::open(array('route'=>'pacs.store', 'method'=>'POST', 'id' => 'formCrear')) !!}
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                use App\Models\Unidadesorg;
                                                use App\Models\Modalidades;
                                                $units = Unidadesorg::all();
                                                @endphp
                                                {{-- <label for="unidades">Unidad Solicitante</label>
                                                <select name="unidades" id="unidades" required style="width: 500px;">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->nombre }}</option>
                                                    @endforeach
                                                </select> --}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                //$options = Modalidades::all();//todas las modalidades
                                                $options = Modalidades::select("*")
                                                    ->where('nombre', '<>', 'Contratación Menor Bienes (1-20.000)')
                                                    ->where('nombre', '<>', 'Contratación Menor Servicio (1-20.000)')
                                                    ->where('nombre', '<>', 'Contratación Menor Consultoría (1-20.000)')
                                                    ->where('nombre', '<>', 'Contratación Directa de Bienes y Servicios')
                                                    ->get();
                                                @endphp
                                                <label for="opciones">Modalidad</label>
                                                <select name="opciones" id="opciones" required style="width: 500px;" onchange = "validarPrecio(document.getElementById('precio_ref'))">
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
                                                {!! Form::text('precio_ref', null, array('class'=>'form-control', 'id' => 'precioInput', 'required' => 'required', 'oninput' => 'validarPrecio(this)')) !!}
                                                <small id="errorPrecioRef" style="color: red;"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Principal Organismo Financiador</label>
                                                {!! Form::text('org_finan', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="mes_ini">Mes programado para la solicitud de inicio</label>
                                                <select name="mes_ini" id="mes_ini" required>
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="enero">Enero</option>
                                                    <option value="febrero">Febrero</option>
                                                    <option value="marzo">Marzo</option>
                                                    <option value="abril">Abril</option>
                                                    <option value="mayo">Mayo</option>
                                                    <option value="junio">Junio</option>
                                                    <option value="julio">Julio</option>
                                                    <option value="agosto">Agosto</option>
                                                    <option value="septiembre">Septiembre</option>
                                                    <option value="octubre">Octubre</option>
                                                    <option value="noviembre">Noviembre</option>
                                                    <option value="diciembre">Diciembre</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="mes_pub">Mes programado para la publicación</label>
                                                <select name="mes_pub" id="mes_pub" required>
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="enero">Enero</option>
                                                    <option value="febrero">Febrero</option>
                                                    <option value="marzo">Marzo</option>
                                                    <option value="abril">Abril</option>
                                                    <option value="mayo">Mayo</option>
                                                    <option value="junio">Junio</option>
                                                    <option value="julio">Julio</option>
                                                    <option value="agosto">Agosto</option>
                                                    <option value="septiembre">Septiembre</option>
                                                    <option value="octubre">Octubre</option>
                                                    <option value="noviembre">Noviembre</option>
                                                    <option value="diciembre">Diciembre</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                            <a class="btn btn-danger" href="{{route('pacs.index')}}">Cancelar</a>
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

        $(document).ready(function () {

            inicializarSelect2();
           
            // Manejar el envío del formulario
            // $('#formCrear').on('submit', function (event) {
            //     // Validar el precio antes de enviar el formulario
            //     var precioInput = document.getElementById('precioInput');
            //     if (!validarPrecio(precioInput)) {
            //         event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            //     }
            // });
                
        });

        function inicializarSelect2() {
            // Inicializar Select2 en tus selects con los IDs "opciones" y "unidades"
            $('#opciones, #unidades').select2();

            // Manejar el evento change del select con el ID "opciones"
            $('#opciones').on('change', function () {

            $(this).select2('close');

            var precioInput = document.getElementById('precioInput');
            validarPrecio(precioInput);

            });
        }

        function validarPrecio(input) {
            // Verificar si el elemento existe
            if (!input) {
                console.error('Elemento no encontrado');
                return;
            }
            
            // Obtener el valor ingresado
            var valor = input.value.trim();

            // Obtener la opción seleccionada en el select de modalidad
            var op = document.getElementById('opciones').value;

            // Definir los límites de acuerdo a la modalidad seleccionada
            var valorMinimo;
            var valorMaximo;

            // Establecer límites según la modalidad
            switch (op) {
                case '3':
                    valorMinimo = 20001;
                    valorMaximo = 50000;
                    break;
                case '4':
                    valorMinimo = 20001;
                    valorMaximo = 50000;
                    break;
                case '5':
                    valorMinimo = 50001;
                    valorMaximo = 1000000;
                    break;
                case '6':
                    valorMinimo = 50001;
                    valorMaximo = 1000000;
                    break;
                case '7':
                    valorMinimo = 1000000;
                    valorMaximo = 2000000;
                    break;
                case '8':
                    valorMinimo = 1000000;
                    valorMaximo = 2000000;
                    break;

            }

            // Verificar si es un número y está dentro de los límites especificados
            if (isNaN(valor) || parseFloat(valor) < valorMinimo || parseFloat(valor) > valorMaximo) {
                document.getElementById('errorPrecioRef').innerHTML = 'Ingrese un número válido entre ' + valorMinimo + ' y ' + valorMaximo + '.';
                input.setCustomValidity('Inválido');
            } else {
                document.getElementById('errorPrecioRef').innerHTML = '';
                input.setCustomValidity('');
            }

            reinicializarSelect2();
            
        }

        function reinicializarSelect2() {
            $('#opciones').select2('destroy');

            setTimeout(function () {
                // Cambia el contenido del select según sea necesario
                // Después de cambiar el contenido, vuelve a aplicar Select2
                $('#opciones').select2();
            }, 0);
        }
    </script>
    @stop