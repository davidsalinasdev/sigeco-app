@extends('adminlte::page')

@section('title', 'Derivar Proceso')

@section('content_header')
@stop

@section('content')

<!-- CSS PARA ESTA PAGINA -->
<style>
    .buscar-sigeco {
        border: 1px solid #e7e8e9;
        border-radius: 10px;
        padding: 30px;
    }
</style>

<section class="section">
    <div class="section-header">
        <h4 class="page__heading p-3 text-uppercase">Modificar especificaciones tecnicas</h3>
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
                                    <h4>
                                        <i class="fas fa-globe"></i> Cofiguraciones SIGECO
                                        <small class="float-right">Fecha: 2/10/2024</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info justify-content-center">
                                <div class="col-sm-4 invoice-col">
                                    <address class="buscar-sigeco">
                                        <strong>Buscar proceso</strong><br>
                                        <input type="text" class="form-control">
                                        <button class="btn btn-primary mt-2"><i class="fa fa-search"></i> BUSCAR</button>
                                    </address>
                                </div>

                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Codigo</th>
                                                <th>Objeto</th>
                                                <th>Precio referencial</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Call of Duty</td>
                                                <td>455-981-221</td>
                                                <td>El snort testosterone trophy driving gloves handsome</td>
                                                <td>$64.50</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop