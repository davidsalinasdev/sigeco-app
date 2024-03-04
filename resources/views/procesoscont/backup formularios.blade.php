@extends('adminlte::page')

@section('title', 'Registrar Proceso de Contratación')

@section('content_header')
@stop

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Solicitud Proceso de Contratación</h3>
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
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @php
                                                use App\Models\Modalidades;
                                                $options = Modalidades::all();
                                                @endphp
                                                <label for="opciones">Modalidad</label>
                                                <select name="opciones" id="opciones" required onchange="mostrarFormulario()">
                                                    <option value="">Selecciona una opción</option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                                        @endforeach
                                                </select>
                                                <label id=titform name=titform></label>
                                            </div>
                                        </div>

                                        <div id="formulario1" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            {!! Form::hidden('idmod', '1') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    
                                        <div id="formulario2" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            {!! Form::hidden('idmod', '2') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    
                                        <div id="formulario3" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
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
                                            {!! Form::hidden('idmod', '3') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        
                                        <div id="formulario4" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
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
                                            {{-- Hidden --}}
                                            {{-- <input type="hidden" name="" id="form-4"> --}}
                                            {{-- {!! Form::hidden('form-4', null, array('id' => 'form-4')) !!} --}}
                                            {!! Form::hidden('idmod', '4') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>

                                        <div id="formulario5" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
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
                                            {!! Form::hidden('idmod', '5') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    
                                        <div id="formulario6" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
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
                                            {!! Form::hidden('idmod', '6') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    
                                        <div id="formulario7" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
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
                                            {!! Form::hidden('idmod', '7') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>

                                        <div id="formulario8" style="display: none;">
                                            {!! Form::open(array('route'=>'procesoscont.store', 'method'=>'POST')) !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="objeto">Objeto de la Contratación</label>
                                                    {!! Form::textarea('objeto', null, array('class'=>'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Precio Referencial (estimado en Bs.)</label>
                                                    {!! Form::text('precio_ref', null, array('class'=>'form-control', 'required' => 'required')) !!}
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
                                            {!! Form::hidden('idmod', '8') !!}
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                                <a class="btn btn-danger" href="{{route('procesoscont.index')}}">Cancelar</a>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>

                                        <div id="formulario9" style="display: none;">
                                            <form>
                                                <!-- Agrega los campos del segundo formulario aquí -->
                                                <label for="campo9">Campo 9:</label>
                                                <input type="text" id="campo9" name="campo9">
                                                
                                            </form>
                                        </div>
                                    
                                        <div id="formulario10" style="display: none;">
                                            <form>
                                                <!-- Agrega los campos del tercer formulario aquí -->
                                                <label for="campo10">Campo 10:</label>
                                                <input type="text" id="campo10" name="campo10">
                                                
                                            </form>
                                        </div>

                                        <div id="formulario11" style="display: none;">
                                            <form>
                                                <!-- Agrega los campos del tercer formulario aquí -->
                                                <label for="campo11">Campo 11:</label>
                                                <input type="text" id="campo11" name="campo11">
                                                
                                            </form>
                                        </div>

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
                $('#opciones').select2(); // Inicializar Select2 en tu select con el ID "opciones"
        });

        function mostrarFormulario() {

            var seleccion = document.getElementById("opciones").value;
            
            var formulario1 = document.getElementById("formulario1");
            var formulario2 = document.getElementById("formulario2");
            var formulario3 = document.getElementById("formulario3");
            var formulario4 = document.getElementById("formulario4");
            var formulario5 = document.getElementById("formulario5");
            var formulario6 = document.getElementById("formulario6");
            var formulario7 = document.getElementById("formulario7");
            var formulario8 = document.getElementById("formulario8");
            var formulario9 = document.getElementById("formulario9");
            var formulario10 = document.getElementById("formulario10");
            var formulario11 = document.getElementById("formulario11");

            var lab_titform = document.getElementById("titform");

            formulario1.style.display = "none";
            formulario2.style.display = "none";
            formulario3.style.display = "none";
            formulario4.style.display = "none";
            formulario5.style.display = "none";
            formulario6.style.display = "none";
            formulario7.style.display = "none";
            formulario8.style.display = "none";
            formulario9.style.display = "none";
            formulario10.style.display = "none";
            formulario11.style.display = "none";
            
            switch (seleccion) {
                case "1":
                    lab_titform.textContent = "Contratación Menor Bienes (1-20.000)";
                    formulario1.style.display = "block";
                    break;

                case "2":
                    lab_titform.textContent = "Contratación Menor Servicio (1-20.000)";
                    formulario2.style.display = "block";
                    break;

                case "3":
                    lab_titform.textContent = "Contratación Menor Bienes (20.001-50.000)";
                    formulario3.style.display = "block";
                    break;

                case "4":
                    // const form_4 = document.getElementById("form-4");
                    // form_4.value = "4";
                    lab_titform.textContent = "Contratación Menor Servicio (20.001-50.000)";
                    formulario4.style.display = "block";
                    break;

                case "5":
                    lab_titform.textContent = "Apoyo Nacional a la Producción y Empleo Bienes (50.001-1.000.000)";
                    formulario5.style.display = "block";
                    break;

                case "6":
                    lab_titform.textContent = "Apoyo Nacional a la Producción y Empleo Servicio (50.001-1.000.000)";
                    formulario6.style.display = "block";
                    break;

                case "7":
                    lab_titform.textContent = "Licitación Pública Nacional Bienes (>1.000.000)";
                    formulario7.style.display = "block";
                    break;

                case "8":
                    lab_titform.textContent = "Licitación Pública Nacional Servicio (>1.000.000)";
                    formulario8.style.display = "block";
                    break;

                case "9":
                    lab_titform.textContent = "Contratación por Excepción";
                    formulario9.style.display = "block";
                    break;

                case "10":
                    lab_titform.textContent = "Contratación por Emergencia";
                    formulario10.style.display = "block";
                    break;

                case "11":
                    lab_titform.textContent = "Contratación Directo de Bienes y Servicios";
                    formulario11.style.display = "block";
                    break;
                // default:
                //     // Manejar el caso en el que seleccion no coincida con ningún valor
                //     break;
            }
        }
    </script>
    @stop