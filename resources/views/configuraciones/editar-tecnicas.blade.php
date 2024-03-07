@extends('adminlte::page')

@section('title', 'Derivar Proceso')

@section('content_header')
@stop

@section('content')

@php
use App\Models\Unidadesorg;
use App\Models\Modalidades;
use App\Models\Procesoscont;
use App\Models\Etapasproc;
use App\Models\Docsgen;
use App\Models\Docstec;
@endphp

<section class="section">
    <div class="section-header">
        <h4 class="page__heading p-3 text-uppercase">Detalle de especificaciones técnicas</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-uppercase">
                                        Gestión modificar especificaciones técnicas
                                    </p>
                                </div>
                                <!-- Modificar especificaciones tecnicas -->
                                <div class="col-12">
                                    <form id="formul">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">

                                                        @php
                                                        $proceso = Procesoscont::find($id);
                                                        $usolic = Unidadesorg::find($proceso->id_unid);
                                                        $modalidad = Modalidades::find($proceso->id_mod);

                                                        $tecnico = Docstec::find($proceso->id);

                                                        $cont = 1;
                                                        $total = 0;
                                                        @endphp



                                                        <div class="row">
                                                            <div class="col-12 col-xl-6 card">{{-- col-12 col-xl-4 card MODAL PRIMERA COLUMNA--}}
                                                                <div class="card-body">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Código:</label>
                                                                            {{$proceso->codigo}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Unidad Solicitante:</label>
                                                                            {{$usolic->nombre}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Objeto:</label>
                                                                            {{$proceso->objeto}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Precio Referencial:</label>
                                                                            <span id="precioReferencial"> {{$proceso->precio_ref}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Modalidad:</label>
                                                                            {{$modalidad->nombre}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Unidad Org. Destino:</label>
                                                                            {{$usolic->nombre}}
                                                                            {{-- @php
                                                            $options = Unidadesorg::all();
                                                            @endphp
                                                            <label for="opcionesm">Unidad Org. Destino</label><span class="text-danger">*</span></label>
                                                            <select name="opcionesm" id="opcionesm" required style="width: 400px;">
                                                                <option value="">Selecciona una opción</option>
                                                                @foreach($options as $option)
                                                                    <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                                                            @endforeach
                                                                            </select> --}}

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="observaciontray">Observación</label>
                                                                            <textarea id="observaciontray" name="observaciontray" class="form-control" rows="2" style="width: 90%;"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-xl-6 card">{{--MODAL SEGUNDA COLUMNA--}}
                                                                <div class="card-body">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="plazo_ent">Plazo de entrega<span class="text-danger">*</span></label>
                                                                            <textarea id="plazo_ent" name="plazo_ent" class="form-control" required rows="2" style="width: 90%;"></textarea>
                                                                            <div class="invalid-feedback">
                                                                                Este campo es obligatorio.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="garantia">Garantía<span class="text-danger">*</span></label>
                                                                            <textarea id="garantia" name="garantia" class="form-control" required="required" rows="2" style="width: 90%;"></textarea>
                                                                            <div class="invalid-feedback">
                                                                                Este campo es obligatorio.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="lugmed_ent">Lugar y medio de entrega<span class="text-danger">*</span></label>
                                                                            <textarea id="lugmed_ent" name="lugmed_ent" class="form-control" required="required" rows="2" style="width: 90%;"></textarea>
                                                                            <div class="invalid-feedback">
                                                                                Este campo es obligatorio.
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>


                                                        <div class="col-12 table-responsive p-4 mt-3">{{--DETALLE PRODUCTOS--}}
                                                            <table id="doctec" class="table table-striped mt-2" style="width: 100%;">
                                                                <thead class="table-info">
                                                                    <tr class="">
                                                                        <th class="col-md-auto">Item</th>
                                                                        <th class="col-md-4">Descripción</th>
                                                                        <th class="col-md-auto">Unidad</th>
                                                                        <th class="col-md-auto">Cantidad</th>
                                                                        <th class="col-md-auto">Precio Unitario</th>
                                                                        <th class="col-md-auto">Subtotal</th>
                                                                        <th class="col-md-auto">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><input id="item" type="text" name="item[]" class="form-control col-md-auto item" value="1"></td>
                                                                        <td><textarea id="producto" name="producto[]" class="form-control" rows="4" class="form-control col-md-4"></textarea></td>
                                                                        <td><input id="unidad" type="text" name="unidad[]" class="form-control col-md-auto"></td>
                                                                        <td><input id="cantidad" type="number" name="cantidad[]" class="form-control col-md-auto"></td>
                                                                        <td><input id="precio" type="number" name="precio[]" class="form-control col-md-auto"></td>
                                                                        <td><input id="subtotal" type="number" name="subtotal[]" readonly class="form-control col-md-auto"></td>
                                                                        <td><button type="button" class="eliminar-fila btn btn-success">-</button></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <p align="right">TOTAL Bs.&nbsp;<label id="total"></label></p>
                                                            <button type="button" id="agregar-fila" class="btn btn-success">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <input type="hidden" name="idp" value="{{ $id }}">
                                            <input type="hidden" name="nomdoc" value="ESPECIFICACIONES TÉCNICAS">

                                            <!-- No se necesita solo se va a editar -->
                                            {{-- <input type="hidden" name="idtray" value="{{$trayec->id}}"/> --}}

                                            <button type="button" class="btn btn-primary text-uppercase" data-dismiss="modal"><i class="fas fa-chevron-left"></i> regresar</button>
                                            <button id="enviarFormulario" type="button" class="btn btn-warning text-uppercase"><i class="far fa-save"></i> Modificar especificaciones técnicas</button>
                                        </div>
                                    </form>


                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => {

                                            document.getElementById("enviarFormulario").addEventListener("click", () => {

                                                // document.getElementById('enviarFormulario').setAttribute('disabled', 'true');

                                                var selectores = ['#plazo_ent', '#garantia', '#lugmed_ent'] //'#doctec tbody tr']
                                                if (validarCamposRequeridos(selectores)) {
                                                    //todos los elementos
                                                    var formulario = document.getElementById("formul");
                                                    //console.log(formulario);
                                                    var elementos = formulario.elements;
                                                    //console.log(elementos);
                                                    var datosFormulario = {};

                                                    for (var i = 0; i < elementos.length; i++) {
                                                        var elemento = elementos[i];
                                                        if (elemento.type !== "button") {
                                                            datosFormulario[elemento.name] = elemento.value;
                                                        }
                                                    }

                                                    // var datosJSON = JSON.stringify(datosFormulario);
                                                    // console.log(datosJSON);

                                                    var items = document.getElementsByName("item[]");
                                                    var productos = document.getElementsByName("producto[]");
                                                    var unidades = document.getElementsByName("unidad[]");
                                                    var cantidades = document.getElementsByName("cantidad[]");
                                                    var precios = document.getElementsByName("precio[]");
                                                    var subtotales = document.getElementsByName("subtotal[]");

                                                    datosFormulario['total'] = 0;

                                                    datosFormulario['item1'] = [];
                                                    datosFormulario['producto1'] = [];
                                                    datosFormulario['unidad1'] = [];
                                                    datosFormulario['cantidad1'] = [];
                                                    datosFormulario['precio1'] = [];
                                                    datosFormulario['subtotal1'] = [];

                                                    for (var i = 0; i < items.length; i++) {
                                                        var itemValue = items[i].value;
                                                        datosFormulario['item1'][i] = itemValue;
                                                    }
                                                    for (var i = 0; i < productos.length; i++) {
                                                        var productoValue = productos[i].value;
                                                        datosFormulario['producto1'][i] = productoValue;
                                                    }
                                                    for (var i = 0; i < unidades.length; i++) {
                                                        var unidadValue = unidades[i].value;
                                                        datosFormulario['unidad1'][i] = unidadValue;
                                                    }
                                                    for (var i = 0; i < cantidades.length; i++) {
                                                        var cantidadValue = cantidades[i].value;
                                                        datosFormulario['cantidad1'][i] = cantidadValue;
                                                    }
                                                    for (var i = 0; i < precios.length; i++) {
                                                        var precioValue = precios[i].value;
                                                        datosFormulario['precio1'][i] = precioValue;
                                                    }

                                                    let sumtotal = 0;
                                                    for (var i = 0; i < subtotales.length; i++) {
                                                        var subtotalValue = subtotales[i].value;
                                                        datosFormulario['subtotal1'][i] = subtotalValue;

                                                        sumtotal += subtotalValue;
                                                    }
                                                    datosFormulario['total'] = sumtotal;

                                                    console.log(datosFormulario);

                                                    // Realizar la petición AJAX
                                                    $.ajax({
                                                        url: '{{route("procesoscont.store_docstec")}}',
                                                        type: 'POST',

                                                        data: datosFormulario,
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },

                                                        success: function(respuesta) {
                                                            // Manejar la respuesta exitosa del servidor aquí
                                                            console.log(respuesta);

                                                            //MODAL
                                                            // Cerrar el modal usando Bootstrap y jQuery
                                                            $('#modal-xl').modal('hide');
                                                            // Eliminar la clase 'show' del modal y del backdrop
                                                            $('#modal-xl').removeClass('show');
                                                            $('.modal-backdrop').remove(); // Elimina completamente el backdrop
                                                            // Eliminar la clase 'modal-open' del body
                                                            $('body').removeClass('modal-open');

                                                            //SIENDO QUE SE GUARDÓ CORRECTAMENTE EN LA BASE DE DATOS
                                                            // Ocultar el botón de crear y mostrar el nuevo botón
                                                            $('#crearBtn').addClass('d-none');
                                                            $('#impBtn2').removeClass('d-none');

                                                            // Puedes mostrar un mensaje al usuario o redirigirlo a otra página después de guardar los datos

                                                        },

                                                        error: function(error) {
                                                            console.log(error);
                                                            // Manejar cualquier error que ocurra durante la solicitud
                                                        }
                                                    });
                                                } else {
                                                    alert('Por favor, complete todos los campos requeridos');
                                                }

                                                // Función para validar campos requeridos en todas las ubicaciones
                                                function validarCamposRequeridos(selectores) {
                                                    var validacionExitosa = true;

                                                    selectores.forEach(function(selector) {
                                                        var elementos = $(selector);

                                                        elementos.each(function() {
                                                            // Verificar si es un textarea o input
                                                            if ($(this).is('textarea, input')) {
                                                                if (!$(this).val()) {
                                                                    validacionExitosa = false;
                                                                    return false; // Salir del bucle each si se encuentra un campo vacío
                                                                }
                                                            } else {
                                                                // Verificar otros elementos (si es necesario)
                                                                var camposRequeridos = $(this).find('[required]');

                                                                camposRequeridos.each(function() {
                                                                    if (!$(this).val()) {
                                                                        validacionExitosa = false;
                                                                        return false; // Salir del bucle each si se encuentra un campo vacío
                                                                    }
                                                                });
                                                            }

                                                            if (!validacionExitosa) {
                                                                return false; // Salir del bucle each si se encuentra una fila con campos vacíos
                                                            }
                                                        });
                                                    });

                                                    return validacionExitosa;
                                                }

                                            });

                                        });
                                    </script>
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
    document.addEventListener("DOMContentLoaded", () => {
        // Contador para ítems
        var contadorItems = obtenerUltimoNumeroItem() + 1;

        // Agregar fila
        $('#agregar-fila').click(function() {
            // Validar todos los campos requeridos en todas las filas
            //if (validarCamposRequeridos()) {//no validar

            agregarNuevaFila();

            // } else {
            //     alert('Por favor, complete todos los campos requeridos en las filas existentes.');
            // }
        });

        // Función para validar campos requeridos en todas las filas
        function validarCamposRequeridos() {
            var filas = $('#doctec tbody tr');
            var validacionExitosa = true;

            filas.each(function() {
                var camposRequeridos = $(this).find('[required]');

                camposRequeridos.each(function() {
                    if (!$(this).val()) {
                        validacionExitosa = false;
                        return false; // Salir del bucle each si se encuentra un campo vacío
                    }
                });

                if (!validacionExitosa) {
                    return false; // Salir del bucle each de filas si se encuentra una fila con campos vacíos
                }
            });

            return validacionExitosa;
        }

        // Eliminar fila
        $('#doctec').on('click', '.eliminar-fila', function() {
            // Solo eliminar si hay más de una fila
            if ($('#doctec tbody tr').length > 1) {
                $(this).closest('tr').remove();
                actualizarNumerosItem();
            }
        });

        function agregarNuevaFila() {
            var primeraFila = $('#doctec tbody tr:first');
            var nuevaFila = primeraFila.clone();

            // Limpiar los valores de los campos en la nueva fila, excluyendo la celda "Item"
            nuevaFila.find('input:not(.item), textarea:not(.item)').val('');

            // Obtener el último número de "Item"
            var ultimoNumero = obtenerUltimoNumeroItem();

            // Incrementar el número solo si la celda "Item" no está vacía
            var itemInput = nuevaFila.find('.item');
            if (itemInput.val() === '') {
                // Mantener vacía si la celda "Item" está vacía en la fila anterior
                itemInput.val('');
            } else {
                itemInput.val(ultimoNumero + 1);
            }

            // Habilitar el botón de eliminar en la nueva fila
            nuevaFila.find('.eliminar-fila').prop('disabled', false);

            // Agregar la nueva fila al final de la tabla
            $('#doctec tbody').append(nuevaFila);
        }

        function actualizarNumerosItem() {
            var filas = $('#doctec tbody tr');
            filas.each(function(index) {
                // Asignar el número actualizado a la celda "Item", manteniendo vacías las celdas con valor vacío
                var itemInput = $(this).find('.item');
                if (itemInput.val() !== '') {
                    itemInput.val(index + 1);
                }
            });

            // Actualizar el contador de ítems después de eliminar una fila
            contadorItems = obtenerUltimoNumeroItem() + 1;
        }

        function obtenerUltimoNumeroItem() {
            var filas = $('#doctec tbody tr');
            var ultimoNumero = 0;

            // Buscar el último número no vacío de "Item"
            filas.each(function() {
                var numero = parseInt($(this).find('.item').val());
                if (!isNaN(numero) && numero > ultimoNumero) {
                    ultimoNumero = numero;
                }
            });

            return ultimoNumero;
        }

        // Función para calcular el total
        function calcularTotal() {
            var total = 0;

            var precioReferencial = parseFloat($('#precioReferencial').text()) || 0;

            console.log(precioReferencial);

            $('#doctec tbody tr').each(function() {
                total += parseFloat($(this).find('input[name^="subtotal"]').val()) || 0;
            });

            $('#total').text(total.toFixed(2));

            if (total > precioReferencial) {
                alert('¡El total no puede ser mayor que el precio referencial!');
            }
            // También puedes limpiar el total o hacer alguna otra acción según tus necesidades
            //$('#total').text('0.00');

        }

        // Calcular el total
        $('#doctec tbody').on('input', 'input[name^="cantidad"], input[name^="precio"]', function() {
            var fila = $(this).closest('tr');
            var cantidad = parseFloat(fila.find('input[name^="cantidad"]').val()) || 0;
            var precio = parseFloat(fila.find('input[name^="precio"]').val()) || 0;
            var subtotal = cantidad * precio;
            fila.find('input[name^="subtotal"]').val(subtotal.toFixed(2));

            calcularTotal();
        });

    });
</script>
@stop