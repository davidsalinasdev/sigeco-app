@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Panel Administrador</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="card bg-gradient-primary mb-3">
                                    <div class="card-header">Usuarios</div>
                                    @php
                                    use App\Models\User;
                                    $quant_user = User::count();
                                    @endphp
                                    <div class="card-body">
                                        <!-- <h5 class="card-title"><i class="fa fa-users f-right"><span>{{$quant_user}}</span></i></h5> -->
                                        <h5 class="card-title"><i class="fa fa-users f-right"><span class=""> {{$quant_user}}</span></i></h5>
                                        <p class="card-text text-right"><a href="/users" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card bg-gradient-indigo mb-3">
                                    <div class="card-header">Roles</div>
                                    @php
                                    use Spatie\Permission\Models\Role;
                                    $quant_roles = Role::count();
                                    @endphp
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fa fa-user-lock f-left"><span class=""> {{$quant_roles}}</span></i></h5>
                                        <p class="card-text text-right"><a href="/roles" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card bg-gradient-indigo mb-3">
                                    <div class="card-header">Beneficiarios</div>
                                    @php
                                    use App\Models\Benef;
                                    $quant_benef = Benef::count();
                                    @endphp
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fa fa-user-lock f-left"><span class=""> {{$quant_benef}}</span></i></h5>
                                        <p class="card-text text-right"><a href="/benef" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card bg-gradient-primary mb-3">
                                    <div class="card-header">Unidades Organizacionales</div>
                                    @php
                                    use App\Models\Unidadesorg;
                                    $quant_unidadesorg = Unidadesorg::count();
                                    @endphp
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fa fa-user-lock f-left"><span class=""> {{$quant_unidadesorg}}</span></i></h5>
                                        <p class="card-text text-right"><a href="/unidadesorg" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card bg-gradient-primary mb-3">

                                    <div class="card-header">Etapas de un Proceso de Contratación</div>
                                    @php
                                    use App\Models\Etapasproc;
                                    $quant_etapasproc = Etapasproc::count();
                                    @endphp
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fa fa-user-lock f-left"><span class=""> {{$quant_etapasproc}}</span></i></h5>
                                        <p class="card-text text-right"><a href="/etapasproc" class="text-white">Ver más</a></p>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('js')

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    new DataTable('#usuarios');
    console.log('Hi!');
</script>
@stop