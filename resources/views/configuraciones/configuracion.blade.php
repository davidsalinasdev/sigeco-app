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
                                    <p>
                                        <img width="20" src="img/sigeco.png"> Gestión buscar y modificar procesos
                                    </p>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info justify-content-center">

                                <div class="col-xl-4 invoice-col">
                                    <div class="buscar-sigeco">
                                        <label>Buscar proceso</label><br>
                                        <input type="text" id="input_buscar_proceso" class="form-control" placeholder="Ingrese un número de proceso">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary mt-2 " id="btn_buscar_proceso"><i class="fa fa-search"></i> BUSCAR</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row mt-3">
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

<!-- Seccion javaScript -->
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const input_buscar_proceso = document.getElementById('input_buscar_proceso');

        // Evento click button
        $('#btn_buscar_proceso').click(function(e) {
            e.preventDefault();

            realizarBusqueda();

        });


        // Funcion buscar proceso
        function realizarBusqueda() {

            $.ajax({
                type: 'POST',
                url: '{{ route("configuraciones.buscardatos") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    gestion_buscar: input_buscar_proceso.value
                },
                beforeSend: function() {
                    console.log('Esta buscando....aqui_ubicacion');
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        }

    });
</script>
@stop
<!-- FIN Seccion javaScript -->