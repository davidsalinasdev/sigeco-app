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
            @php
            use App\Models\Unidadesorg;
            use App\Models\Modalidades;
            use App\Models\Procesoscont;
            use App\Models\Docstec;
            use App\Models\Det_docstec;


            $proceso = Procesoscont::find($doctec->id_proc);
            $usolic = Unidadesorg::find($proceso->id_unid);
            $modalidad = Modalidades::find($proceso->id_mod);

            $detdocs = Det_docstec::select("*")
            ->where('id_docstec',$doctec->id)
            ->orderBy('id', 'asc')
            ->get();

            $cont = 1;
            $total = 0;
            @endphp
            <table id="detallecen">
                <tr>
                    <td>
                        <img width="100" src="img/escudo.png">
                    </td>
                    <td>
                        <p class="titulogob">GOBIERNO AUTÓNOMO DEPARTAMENTAL DE COCHABAMBA</p>
                        <h1 class="tituloimp">ORDEN DE COMPRA</h1>
                        <h2 class="subtituloimp">GESTIÓN: {{$proceso->gestion}}</h2>
                    </td>
                </tr>
            </table>
            <hr width="100%">
            <!-- <p align="right">Cochabamba,&nbsp;{{date("d/m/Y")}}</p> -->
            <p align="right">Cochabamba,&nbsp;{{$fecha}}</p>
            <table>
                <tr>
                    <td>
                        <label><b>Señor(es):&nbsp;</b></label>
                        {{$proceso->benef}}
                    </td>
                </tr>

                <tr>
                    <td>
                        <label><b>Documento de Referencia:&nbsp;</b></label>
                        {{$proceso->docref}}
                    </td>
                    <td>
                        <label><b>Código:&nbsp;</b></label>
                        {{$proceso->codigo}}
                    </td>
                </tr>
                {{-- <tr>
                    <td>
                        <label><b>Unidad Solicitante:&nbsp;</b></label>
                        {{$usolic->nombre}}
                </td>
                </tr>
                <tr>
                    <td>
                        <label><b>Modalidad:&nbsp;</b></label>
                        {{$modalidad->nombre}}
                    </td>
                </tr> --}}
                <tr>
                    <td>
                        <label><b>Objeto:&nbsp;</b></label>
                        {{$proceso->objeto}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><b>Plazo de Ejecución:&nbsp;</b></label>
                        {{$doctec->plazo_ent}}
                    </td>
                </tr>
                {{-- <tr>
                    <td>
                        <label><b>Observación:&nbsp;</b></label>
                        {!! nl2br(e($doctec->observacion)) !!}
                    </td>
                </tr> --}}
            </table>
            <br>
            <label><b>Agradecemos entregar de acuerdo a su cotización lo siguiente:</b></label>
            <table id="detalle">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detdocs as $detdoc)

                    <!-- Primera opción -->
                    @if($detdoc->cant_no_disponible != NULL )

                    @if($detdoc->cant_no_disponible != 0)
                    <tr>
                        <td align="center" width="3%">{{$detdoc->item}}</td>

                        <td align="center" width="8%">
                            {{$detdoc->cant_no_disponible}}
                        </td>
                        <td align="center" width="8%">{{$detdoc->unidad}}</td>
                        <td align="left" width="30%">{!! nl2br(e($detdoc->descripcion)) !!}</td>
                        <td align="right" width="8%">
                            {{number_format($detdoc->precio,2,',','.')}}
                        </td>
                        <td align="right" width="8%">
                            {{number_format($detdoc->new_sub_total,2,',','.')}}
                        </td>
                        @php

                        $subtotal = $detdoc->new_sub_total;
                        $total += $subtotal;

                        @endphp
                    </tr>
                    @endif

                    @endif

                    <!-- Segunda opción -->
                    @if(is_null($detdoc->cant_no_disponible))

                    @if($detdoc->cantidad != 0)
                    <tr>
                        <td align="center" width="3%">{{$detdoc->item}}</td>

                        <td align="center" width="8%">
                            {{$detdoc->cantidad}}
                        </td>
                        <td align="center" width="8%">{{$detdoc->unidad}}</td>
                        <td align="left" width="30%">{!! nl2br(e($detdoc->descripcion)) !!}</td>
                        <td align="right" width="8%">
                            {{number_format($detdoc->precio,2,',','.')}}
                        </td>
                        <td align="right" width="8%">
                            {{number_format($detdoc->subtotal,2,',','.')}}
                        </td>
                        @php

                        $subtotal = $detdoc->subtotal;
                        $total += $subtotal;

                        @endphp
                    </tr>
                    @endif

                    @endif


                    @endforeach
                </tbody>
            </table>
            <p align="right">TOTAL Bs.&nbsp;{{number_format($total,2,',','.')}}</p>
            <br>
            <br>
            <br>
            <center>.................................................</center {{-- <h2 class="subtituloimp">{{ Auth::user()->name }}</h2>
            <h2 class="pdependencia">{{ Auth::user()->dependencia }}</h2> --}}
        </div>
    </div>
</div>