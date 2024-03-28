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


            $proceso = Procesoscont::find($doctec[0]->id_proc);
            $usolic = Unidadesorg::find($proceso->id_unid);
            $modalidad = Modalidades::find($proceso->id_mod);

            $detdocs = Det_docstec::select("*")
            ->where('id_docstec',$doctec[0]->id)
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
                        <h1 class="tituloimp">SOLICITUD DE INEXISTENCIA <span style="text-transform: uppercase;">{{$proceso->objeto}}</span></h1>
                        <h2 class="subtituloimp">GESTIÓN: {{$proceso->gestion}}</h2>
                    </td>
                </tr>
            </table>
            <hr width="100%">
            <div>
                <p style="float: right;">Cochabamba,&nbsp;{{date('d/m/Y', strtotime($doctec[0]->updated_at))}}</p>
                <p style="float: left;">CODIGO: {{$proceso->codigo}}</p>
            </div>
            <br>
            <br>
            <p>De mi mayor consideración:</p>
            <p>Mediante la presente, solicito que por la unidad que corresponda se emita el informe de inexistencia para <span style="text-transform: lowercase;">{{$proceso->objeto}}</span></p>
            <br>
            <table id="detalle">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descripción</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detdocs as $detdoc)
                    <tr>
                        <td align="center" width="3%">{{$detdoc->item}}</td>
                        <td align="left" width="30%">{!! nl2br(e($detdoc->descripcion)) !!}</td>

                        <td align="center" width="8%">{{$detdoc->unidad}}</td>
                        <td align="center" width="8%">
                            @if ($detdoc->cantidad <> 0)
                                {{$detdoc->cantidad}}
                                @endif
                        </td>
                        <td align="right" width="8%">
                            @if ($detdoc->precio <> 0)
                                {{number_format($detdoc->precio,2,',','.')}}
                                @endif
                        </td>
                        <td align="right" width="8%">
                            @if ($detdoc->subtotal <> 0)
                                {{number_format($detdoc->subtotal,2,',','.')}}
                                @endif
                        </td>
                        @php
                        $subtotal = $detdoc->subtotal;
                        $total = $total + $subtotal;
                        @endphp
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p align="right">TOTAL Bs.&nbsp;{{number_format($total,2,',','.')}}</p>

            @if ($doctec[0]->observacion <> "")
                <span><span style="font-weight: bold;">Nota aclaratoria:</span> {!! nl2br(e($doctec[0]->observacion)) !!}</span>
                @endif
                <br>
                <p>Con este motivo, saludo a usted atentamente.</p>
                <br>
                <br>
                <br>
                <br>
                <h2 class="subtituloimp">{{ Auth::user()->name }}</h2>
                <h3 class="pdependencia">{{ Auth::user()->dependencia }}</h3>
        </div>
    </div>
</div>