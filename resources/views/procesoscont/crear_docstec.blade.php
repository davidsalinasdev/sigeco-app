@extends('adminlte::page')

@section('title', 'Crear Documento Técnico')

@section('content_header')
@stop

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Especificaciones Técnicas</h3>
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
                            @php
                                use App\Models\Unidadesorg;
                                use App\Models\Modalidades;
                                use App\Models\Procesoscont;
                                use App\Models\Etapasproc;
                                use App\Models\Listaverif;
                                use App\Models\Docsgen;
                
                                $proceso = Procesoscont::find($idp);
                                $usolic = Unidadesorg::find($proceso->id_unid);
                                $modalidad = Modalidades::find($proceso->id_mod);
                            @endphp
                            {!! Form::open(array('route'=>'procesoscont.store_docstec', 'method'=>'POST')) !!}
                            <div class="row">
                                <div class="col-12 col-xl-6 card">{{-- col-12 col-xl-4 card PRIMERA COLUMNA--}}
                                    <div class="card-header">
                                        Formulario de Registro
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Unidad Solicitante</label>
                                                {{$usolic->nombre}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Objeto</label>
                                                {{$proceso->objeto}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Modalidad</label>
                                                {{$modalidad->nombre}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="plazo_ent">Plazo de entrega</label>
                                                {!! Form::textarea('plazo_ent', null, array('class'=>'form-control', 'required' => 'required', 'rows' => 3, 'style' => 'width: 60%;')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="garantia">Garantía</label>
                                                {!! Form::textarea('garantia', null, array('class'=>'form-control', 'required' => 'required', 'rows' => 3, 'style' => 'width: 60%;')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6 card">{{-- SEGUNDA COLUMNA--}}
                                    <div class="card-header">
                                        .
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="lugmed_ent">Lugar y medio de entrega</label>
                                                {!! Form::textarea('lugmed_ent', null, array('class'=>'form-control', 'required' => 'required', 'rows' => 3, 'style' => 'width: 60%;')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="otro1">Otra información (1)</label>
                                                {!! Form::textarea('otro1', null, array('class'=>'form-control', 'rows' => 3, 'style' => 'width: 60%;')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="otro2">Otra información (2)</label>
                                                {!! Form::textarea('otro2', null, array('class'=>'form-control', 'rows' => 3, 'style' => 'width: 60%;')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 table-responsive bg-white p-4 mt-3">
                                <table id="doctec" class="table table-striped mt-2" style="width: 100%;">
                                    <thead class="table-header">
                                        <tr class="table-header__encabezado">
                                            <th style="display: #fff;">Bien / Servicio</th>
                                            <th style="display: #fff;">Cantidad</th>
                                            {{-- <th style="display: #fff;">Precio Unitario</th>
                                            <th style="display: #fff;">Total</th> --}}
                                            <th style="display: #fff;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="producto[]" required></td>
                                            <td><input type="number" name="cantidad[]" required></td>
                                            {{-- <td><input type="number" name="precio[]" required></td>
                                            <td><input type="number" name="total[]" readonly></td> --}}
                                            <td><button type="button" class="eliminar-fila btn btn-success">-</button></td>

                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" id="agregar-fila" class="btn btn-success">+</button>
                            </div>
                            <hr>
                            {!! Form::hidden('idp', $idp) !!}
                            {!! Form::hidden('nomdoc', 'ESPECIFICACIONES TÉCNICAS') !!}
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
    </section>
    @stop
    
    @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @stop
    
    @section('js')
    <script>
        $(document).ready(function () {
            // Agregar fila
            $('#agregar-fila').click(function () {
                var nuevaFila = $('#doctec tbody tr:first').clone();
                nuevaFila.find('input').val('');
                $('#doctec tbody').append(nuevaFila);
            });

            // Eliminar fila
            $(document).on('click', '.eliminar-fila', function () {
                if ($('#doctec tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                }
            });

            // // Calcular el total
            // $('#doctec tbody').on('input', 'input[name^="cantidad"], input[name^="precio"]', function () {
            //     var fila = $(this).closest('tr');
            //     var cantidad = parseFloat(fila.find('input[name^="cantidad"]').val()) || 0;
            //     var precio = parseFloat(fila.find('input[name^="precio"]').val()) || 0;
            //     var total = cantidad * precio;
            //     fila.find('input[name^="total"]').val(total.toFixed(2));
            // });
        });
    </script>
    @stop
