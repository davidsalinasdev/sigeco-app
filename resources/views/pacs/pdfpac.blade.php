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
                .padre-secc-son-3{
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
                .padre-secc-son-22{
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
                .titulogob{
                    font-size: 17px;
                    margin-bottom: 0px;
                    text-align: center;
                }
                .tituloimp{
                    font-size: 14px;
                    margin-bottom: 0px;
                    text-align: center;
                }
                .subtituloimp{
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
                .pdependencia{
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
                        <h1 class="tituloimp">PROGRAMA ANUAL DE CONTRATACIONES - PAC</h1>
                        <h2 class="subtituloimp">GESTIÓN: {{$programa->gestion}}</h2>
                    </td>
                </tr>
            </table>
            <hr width="100%">
            @php
                use App\Models\Unidadesorg;
                use App\Models\Modalidades;
                use App\Models\Procesoscont;

                $usolic = Unidadesorg::find($programa->id_unid);
                $modalidad = Modalidades::find($programa->id_mod);

                if ($programa->estado == 1) {
                    $proceso = Procesoscont::select("*")
                        ->where('id_pac', $programa->id)
                        ->first();

                    $codigo = $proceso->codigo;
                }else{
                    $codigo = "";
                }

            @endphp
            
            <p align="right">Cochabamba,&nbsp;{{date('d/m/Y', strtotime($programa->fecha_reg))}}</p>
            <table>
                <tr>
                    <td>
                        <label><b>Código:&nbsp;</b></label>
                        {{$codigo}}
                    </td>
                </tr>                
                <tr>
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
                </tr>
                <tr>
                    <td>
                        <label><b>Objeto:&nbsp;</b></label>
                        {{$programa->objeto}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><b>Organismo Financiador:&nbsp;</b></label>
                        {{$programa->org_finan}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><b>Mes Solicitud de Inicio:&nbsp;</b></label>
                        {{$programa->mes_ini}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><b>Mes Publicación Convocatoria:&nbsp;</b></label>
                        {{$programa->mes_pub}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><b>Precio Referencial:&nbsp;</b></label>
                        {{number_format($programa->precio_ref,2,',','.')}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><b>Estado PAC:&nbsp;</b></label>
                        @php
                            if ($programa->estado == 0)
                                $estado="Sin aprobación";
                            else
                                $estado="Aprobado";
                        @endphp
                        {{$estado}}
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <h2 class="subtituloimp">{{ Auth::user()->name }}</h2>
            <h2 class="pdependencia">{{ Auth::user()->dependencia }}</h2>
        </div>
    </div>
</div> 


