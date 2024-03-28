<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">

            <style>
                /* Seccion-1 */
                .contenedor-fla-1 {
                    background-color: #4FC3F7;
                }

                .padre {
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: center;
                }

                .padre-flex {
                    padding: 15px;
                }

                .padre-son-2 {
                    width: 30%;
                }

                .padre-info {
                    padding: 15px;
                }

                /* Seccion-2 */
                .padre-seccion-2 {
                    display: flex;
                    flex-direction: row;
                }

                .seccion2-son {
                    width: 280px;
                    margin-bottom: 0px;
                }

                .seccion2-son-parrafo {
                    font-size: 14px;
                }

                .seccion2-son:nth-child(1) {
                    margin-right: 20px;
                }

                .seccion2-son:nth-child(2) {
                    margin-right: 20px;
                }

                .seccion2-son:nth-child(3) {
                    margin-right: 20px;
                }

                .seccion2-son {
                    margin-bottom: 10px;
                }

                .secc-form {
                    width: 100%;
                }

                /* Seccion-3 */
                .padre-seccion-3 {
                    display: flex;
                    flex-direction: row;
                }

                .parrafo-contruyente {
                    margin-bottom: 0px;
                }

                .padre-secc-son-3 {
                    margin-right: 25px;
                }

                .parrafo-contruyente {
                    margin-bottom: 10px;
                    padding-left: 15px;
                }

                /* Seccion-5 */
                .contenedor-fla-gris {
                    background-color: #e0e7ff;
                }

                .padre-gris {
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: center;
                }

                .padre-info-gris {
                    padding: 15px;
                }

                /* Seccion-22 */
                .padre-seccion-22 {
                    display: flex;
                    flex-direction: row;
                    padding: 0px 15px 15px 15px;
                }

                .parrafo-contruyente-22 {
                    margin-bottom: 10px;
                    padding-left: 15px;
                }

                .padre-secc-son-22 {
                    margin-right: 25px;
                }

                /* Seccion-31 */
                .contenedor-fla-osc {
                    background-color: #d6d3d1;
                }

                .padre-osc {
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: left;
                }

                .padre-info-osc {
                    padding: 15px;
                }

                /*cabecera*/
                .titulogob {
                    font-size: 17px;
                    margin-bottom: 0px;
                    text-align: center;
                }

                .tituloimp {
                    font-size: 14px;
                    margin-bottom: 0px;
                    text-align: center;
                }

                .subtituloimp {
                    font-size: 13px;
                    margin-bottom: 0px;
                    text-align: center;
                }

                #detallecen {
                    width: 100%;
                    border-collapse: collapse;
                }

                #detallecen td {
                    vertical-align: top;
                    padding: 5px;
                }

                #detallecen label {
                    font-size: 20px;
                    font-weight: bold;
                }

                #detalle {
                    width: 100%;
                    border-collapse: collapse;
                }

                #detalle th {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                    font-size: 12px;
                }

                #detalle td {
                    border: 1px solid black;
                    padding: 8px;
                    font-size: 11px;
                }

                .pdependencia {
                    font-size: 11px;
                    margin-bottom: 0px;
                    text-align: center;
                }
            </style>

            <table id="detallecen">
                <tr>
                    <td>
                        <img width="100" src="img/escudo.png">
                    </td>
                    <td>
                        <p class="titulogob">GOBIERNO AUTÓNOMO DEPARTAMENTAL DE COCHABAMBA</p>
                        <h1 class="tituloimp">INFORME DE INEXISTENCIA <span style="text-transform: uppercase;">{{$proceso->objeto}}</span></h1>
                        <h2 class="subtituloimp">GESTIÓN: {{$proceso->gestion}}</h2>
                    </td>
                </tr>
            </table>

            <hr width="100%">
            <div>
                <p style="float: right;">Cochabamba,&nbsp;{{date('d/m/Y', strtotime($docstec->fecha_evaluacion))}}</p>
                <p style="float: left;">CODIGO: {{$proceso->codigo}}</p>
            </div>
            <br>
            <br>
            <p>De mi mayor consideración:</p>
            <p>Se procedio a la revisión segun las especificaciones técnicas <span style="text-transform: lowercase;">{{$proceso->objeto}}</span>, debo indicar que no contamos con el requerimiento solicitado que requiere la unidad solicitante <span style="font-weight: bold; font-size: 14px;">{{$unidadSolicitante}}</span> para su disposición.</p>
            <br>
            <table id="detalle">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descripción</th>
                        <th>Cantidad solicitada</th>
                        <th>Cantidad disponible</th>
                        <th>Cantidad no disponible</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($det_docstec as $detdoc)
                    <tr>
                        <td align="center" width="3%">{{$detdoc->item}}</td>
                        <td align="left" width="30%">{!! nl2br(e($detdoc->descripcion)) !!}</td>

                        <td align="center" width="8%">
                            {{$detdoc->cantidad}}
                        </td>
                        <td align="center">{{$detdoc->disponibilidad}}</td>
                        <td align="center">{{$detdoc->cant_no_disponible}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            @if ($docstec->obs_evaluacion != "" || $docstec->obs_evaluacion != NULL)
            <span><span style="font-weight: bold;">Nota aclaratoria:</span> {!! nl2br(e($docstec->obs_evaluacion)) !!}</span>
            @endif
            <p>Es cuanto informo para fines consiguientes</p>
            <p>Atentamente.</p>
            <br>
            <br>
            <br>
            <br>
            <h2 class="subtituloimp">{{$nombres}}</h2>
            <h3 class="pdependencia">{{$dependencia}}</h3>
        </div>
    </div>
</div>