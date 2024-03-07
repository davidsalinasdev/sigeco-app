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
        <h4 class="page__heading p-3 text-uppercase">Modificar especificaciones técnicas</h3>
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
                                        Gestión modificar especificaciones técnicas
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
                                    <table id="editar-esp" class="table table-striped">
                                        <thead class="table-info">
                                            <tr>
                                                <th style="width: 8%;">ID</th>
                                                <th style="width: 10%;">Codigo</th>
                                                <th style="width: 40%;">Objeto</th>
                                                <th style="width: 15%;">Precio referencial</th>
                                                <th style="width: 7%;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista-proceso">

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

        // Evento keydown en el campo de entrada para utilizar ENTER
        $('#input_buscar_proceso').keydown(function(e) {

            if (input_buscar_proceso.value === '') {

                console.log('Vacio');
            } else
            if (e.keyCode === 13) { // 13 es el código de la tecla "Enter"
                e.preventDefault(); // Evita el comportamiento predeterminado del "Enter"
                realizarBusqueda();
            }
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

                    const {
                        code,
                        status,
                        proceso
                    } = response;

                    if (proceso == null) {
                        toastr.error('No se encontro ningun dato', 'Sistema de contrataciones');
                    } else {

                        console.log(proceso);
                        toastr.success('Proceso encontrado', 'Sistema de contrataciones');

                        $('#lista-proceso').empty();
                        let newRow = '<tr>' +
                            '<td>' + proceso.id + '</td>' +
                            '<td>' + proceso.codigo + '</td>' +
                            '<td>' + proceso.objeto + '</td>' +
                            '<td>' + proceso.precio_ref + '</td>' +
                            `<td> <a href="/editaresptecnicas/${proceso.id}" alt="Editar" class="btn btn-warning" title="Editar"><i class = "fas fa-pencil-alt"> </i></a></td >` +
                            '</tr>';
                        $('#lista-proceso').append(newRow);

                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        }

    });
</script>

@parent
<!-- Tu script de DataTables -->
<script>
    $(document).ready(function() {
        // Inicializa DataTable
        $('#editar-esp').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },
            lengthChange: false, // Oculta el mensaje de registros por página
            searching: false // Deshabilita la caja de búsqueda
            // info: false, // Oculta el contador de registros
        });
    });
</script>
@stop
<!-- FIN Seccion javaScript -->