<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.select.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<style>
    hr.style-seven {
        overflow: visible; /* For IE */
        height: 30px;
        border-style: solid;
        border-color: black;
        border-width: 1px 0 0 0;
        border-radius: 20px;
    }
    hr.style-seven:before { /* Not really supposed to work, but does */
        display: block;
        content: "";
        height: 30px;
        margin-top: -31px;
        border-style: solid;
        border-color: black;
        border-width: 0 0 1px 0;
        border-radius: 20px;
    }
    hr.style-three {
        border: 0;
        border-bottom: 1px dashed #ccc;
        background: #999;
    }
    .nav-tabs { border-bottom: 2px solid #DDD; }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
    .nav-tabs > li > a { border: none; color: #666; }
        .nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none; color: #4285F4 !important; /*background: transparent;*/ }
        .nav-tabs > li > a::after { content: ""; background: #4285F4; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
    .nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }
    .tab-nav > li > a::after { background: #21527d none repeat scroll 0% 0%; color: #fff; }
    .tab-pane { padding: 15px 0; }
    .tab-content{padding:20px}

    .card {background: #FFF none repeat scroll 0% 0%; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-bottom: 30px; }

    .radiotextsty {
        color: #000;
        font-size: 16px;
        font-weight: bold;
    }

    .customradio {
        display: block;
        position: relative;
        padding-left: 30px;
        margin-bottom: 0px;
        cursor: pointer;
        font-size: 18px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .customradio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: white;
        border-radius: 50%;
        border:1px solid #BEBEBE;
    }

    /* On mouse-over, add a grey background color */
    .customradio:hover input ~ .checkmark {
        background-color: transparent;
    }

    /* When the radio button is checked, add a blue background */
    .customradio input:checked ~ .checkmark {
        background-color: white;
        border:1px solid #BEBEBE;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .customradio input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .customradio .checkmark:after {
        top: 2px;
        left: 2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #3A8DF7;
    }
    
    h1.retroshadow {
        color: #2c2c2c;
        letter-spacing: 0.05em;
        text-shadow: 4px 4px 0px #d5d5d5;
    }


   
</style>
<section class="content">
    
    <div class = "row">
        <div class ="col-md-12" > 
            <div class="box box-warning">
				<div class="box-header with-border borde_box">
					<div class="row">
						<div class="col-md-12">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; GENERACIÓN  DE RECIBOS </h2>
						</div>
					</div>
			    </div>
                <div class="box-body">
                <div class ='row'>
                    <div class ='col-md-12'>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#recibo_masivo" aria-controls="home" role="tab" data-toggle="tab"><strong>  RECIBOS MASIVOS </strong>  </a></li>
                            <li role="presentation"><a href="#recibo_rango" aria-controls="profile" role="tab" data-toggle="tab"><strong>RECIBO POR RANGO </strong> </a></li>
                            <li role="presentation"><a href="#recibo_individual" aria-controls="messages" role="tab" data-toggle="tab"><strong>RECIBO INDIVIDUAL</strong> </a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="recibo_masivo">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='col-md-12' style='margin-top:10px;'>
                                            <div class='row'>
                                                <center>
                                                    <h1 class ='retroshadow'>
                                                        GENERADOR DE RECIBOS MASIVOS 
                                                    </h1>
                                                </center>
                                            </div>
                                            <div class ='row'>
                                                <div class='col-md-12' style='margin-top:10px;'>
                                                    <div class="panel panel-info"> 
                                                        <div class="panel-heading">
                                                            PROCESO  
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class ='row'>
                                                                <div class='col-md-12'>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                        <div class="form-group">
                                                                            <label for="email">AÑO</label>
                                                                            <input type="text" class="form-control dato-estatico" id="control_anio" value='<?php echo date("Y"); ?>' >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                        <div class="form-group">
                                                                            <label for="email">MES</label>
                                                                            <select class="form-control" id="control_mes">
                                                                                <option value ='01'>ENERO</option>
                                                                                <option value ='02'>FEBRERO</option>
                                                                                <option value ='03'>MARZO</option>
                                                                                <option value ='04'>ABRIL</option>
                                                                                <option value ='05'>MAYO</option>
                                                                                <option value ='06'>JUNIO</option>
                                                                                <option value ='07'>JULIO</option>
                                                                                <option value ='08'>AGOSTO</option>
                                                                                <option value ='09'>SETIEMBRE</option>
                                                                                <option value ='10'>OCTUBRE</option>
                                                                                <option value ='11'>NOVIEMBRE</option>
                                                                                <option value ='12'>DICIEMBRE</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                        <div class="form-group">
                                                                            <label for="email">CICLO DE FACTURACIÓN</label>
                                                                            <select class="form-control" id="control_factura">
                                                                                <?php $i = 0; while($i< count($Ciclos)) {?>
                                                                                <option value='<?php echo $Ciclos[$i]['FACCICCOD']; ?>'><?php echo $Ciclos[$i]['FACCICDES']; ?></option>
                                                                                <?php $i++; } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                        <button class='btn btn-warning' style ='width:100%; margin-top:23px;' id ='buscar_rangos'>
                                                                            <i class="fa fa-search"></i> BUSCAR
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <center>
                                                        <h4>
                                                            <strong>
                                                                RANGOS DE IMPRESIÓN
                                                            </strong>
                                                        </h4>
                                                    </center>
                                                </div>
                                            </div>

                                            <div class='row'>
                                                <div class='col-md-12'>
                                                <hr class='style-seven'>
                                                </div>
                                            </div>

                                            <div class= 'row'>
                                                <div class='col-md-12'>
                                                    <div class='col-md-8' id='contendor'>
                                                        <table class="table" id='tabla_rango'>
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                    N°
                                                                    </th>
                                                                    <th>
                                                                    INICIAL
                                                                    </th>
                                                                    <th>
                                                                    FINAL
                                                                    </th>
                                                                    <th>
                                                                        DESDE-HASTA
                                                                    </th>
                                                                    <th>
                                                                        TOTAL
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class='col-md-4' style ='background-color: #e0eaed;'>
                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <center>
                                                                <h4>
                                                                    <strong>
                                                                        OPERACIONES 
                                                                    </strong>
                                                                </h4>
                                                                </center>
                                                            </div>
                                                            <div class='col-md-12'>
                                                            <hr class='style-three'>
                                                            </div>
                                                            <div class='col-md-12' style='margin-top:20px;'>
                                                                <div class='col-md-6'>
                                                                    <h4>
                                                                        <strong>
                                                                            TOTAL RECIBOS
                                                                        </strong>
                                                                    </h4>
                                                                </div>
                                                                <div class='col-md-6'>
                                                                    <input type="text" class="form-control dato-estatico" id="numero_recibos_ciclo" placeholder="NUM. RECIBOS" readonly="readonly">
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12' style ='margin-top:15px' >
                                                                <strong>
                                                                    FORMATO 
                                                                </strong>
                                                            </div>
                                                            
                                                            <div class='col-md-12' style='margin-top:20px;'>
                                                                <div class ='col-md-6'>
                                                                    
                                                                    <label class="radio-inline customradio"><span class="radiotextsty">SIN FONDO</span>
                                                                        <input type="radio" name="masivo_recibo_fondo" value="0" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class ='col-md-6'>
                                                                    <label class="radio-inline customradio"><span class="radiotextsty">CON FONDO</span>
                                                                        <input type="radio" name="masivo_recibo_fondo" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class='col-md-12'>
                                                                <button class ='btn btn-info' style ='width:100%; margin-top:25px; margin-bottom :15px;' id='generar_recibo_pdf' disabled>
                                                                <i class="far fa-file-pdf"></i>  GENERAR RECIBOS
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="recibo_rango">
                                <div class="content">
                                    <div class ='row'>
                                        <div class='col-md-12'>
                                            <center>
                                                <h1 class ='retroshadow'>
                                                    GENERADOR DE RECIBO INDIVIDUAL POR RANGO
                                                </h1>
                                            </center>
                                        </div>
                                        <div class ='col-md-12' style='margin-top:5px;'>
                                            <div class="panel panel-info"> 
                                                <div class="panel-heading">
                                                    PROCESO  
                                                </div>
                                                <div class="panel-body">
                                                    <div class ='row'>
                                                        <div class ='col-md-12'>
                                                            <div class='col-md-8 col-sm-8 col-xs-8'>
                                                                <div class="form-group">
                                                                    <label for="email">SUMINISTRO</label>
                                                                    <input type="text" class="form-control dato-estatico" id="suministro_recibo_rango" >
                                                                </div>       
                                                            </div>
                                                            <div class='col-md-4 col-sm-4 col-xs-4'>
                                                                <button class='btn btn-warning' style ='width:100%; margin-top:23px;' id ='buscar_suministro_recibo_rango'>
                                                                    <i class="fa fa-search"></i> BUSCAR
                                                                </button>      
                                                            </div>
                                                        </div>
                                                        <div class = 'col-md-12'>
                                                            <div class ='col-md-6'>
                                                                
                                                                <div class ='col-md-12'>
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="email">AÑO</label>
                                                                            <input type="number" class="form-control dato-estatico" id="anio_recibo_rango_inicio" value='<?php echo date("Y"); ?>' >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="email">MES</label>
                                                                            <select class="form-control" id="mes_recibo_rango_inicio">
                                                                                <option value ='01'>ENERO</option>
                                                                                <option value ='02'>FEBRERO</option>
                                                                                <option value ='03'>MARZO</option>
                                                                                <option value ='04'>ABRIL</option>
                                                                                <option value ='05'>MAYO</option>
                                                                                <option value ='06'>JUNIO</option>
                                                                                <option value ='07'>JULIO</option>
                                                                                <option value ='08'>AGOSTO</option>
                                                                                <option value ='09'>SETIEMBRE</option>
                                                                                <option value ='10'>OCTUBRE</option>
                                                                                <option value ='11'>NOVIEMBRE</option>
                                                                                <option value ='12'>DICIEMBRE</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <hr class='style-three'>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <center>
                                                                        <h4>
                                                                            <strong>
                                                                                DESDE 
                                                                            </strong>
                                                                        </h4>
                                                                    </center>
                                                                </div>
                                                            </div>
                                                            <div class ='col-md-6'>
                                                                
                                                                <div class ='col-md-12'>
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="email">AÑO</label>
                                                                            <input type="number" class="form-control dato-estatico" id="anio_recibo_rango_fin" value='<?php echo date("Y"); ?>' >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="email">MES</label>
                                                                            <select class="form-control" id="mes_recibo_rango_fin">
                                                                                <option value ='01'>ENERO</option>
                                                                                <option value ='02'>FEBRERO</option>
                                                                                <option value ='03'>MARZO</option>
                                                                                <option value ='04'>ABRIL</option>
                                                                                <option value ='05'>MAYO</option>
                                                                                <option value ='06'>JUNIO</option>
                                                                                <option value ='07'>JULIO</option>
                                                                                <option value ='08'>AGOSTO</option>
                                                                                <option value ='09'>SETIEMBRE</option>
                                                                                <option value ='10'>OCTUBRE</option>
                                                                                <option value ='11'>NOVIEMBRE</option>
                                                                                <option value ='12'>DICIEMBRE</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <hr class='style-three'>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <center>
                                                                        <h4>
                                                                            <strong>
                                                                                HASTA 
                                                                            </strong>
                                                                        </h4>
                                                                    </center>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class ='col-md-12'>
                                            <center>
                                                <h4>
                                                    <strong>
                                                        RANGO DE RECIBOS A IMPRIMIR 
                                                    </strong>
                                                </h4>
                                            </center>
                                        </div>
                                        <div class='col-md-12'>
                                            <hr class='style-seven'>
                                        </div>
                                        <div class ='col-md-12'>
                                            <div class ='col-md-7' id ='tabla_rango_contenedor'>
                                                <table class="table" id='tabla_rango_individual'>
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                N°
                                                            </th>
                                                            <th>
                                                                PERIODO
                                                            </th>
                                                            <th>
                                                                AÑO 
                                                            </th>
                                                            <th>
                                                                MES
                                                            </th>
                                                            <th>
                                                                SERIE
                                                            </th>   
                                                            <th>
                                                                NUMERO 
                                                            </th>
                                                            <th>
                                                                MONTO 
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                                
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class ='col-md-5' style ='background-color: #e0eaed;'>
                                                <div class='col-md-12'>
                                                    <center>
                                                        <H4>
                                                            <strong>
                                                                OPERACIONES
                                                            </strong>
                                                        </H4>
                                                    </center>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <hr class='style-three'>
                                                </div>
                                                <div class='col-md-12' style ='margin-top:15px' >
                                                    <strong>
                                                        FORMATO 
                                                    </strong>
                                                </div>
                                                <div class='col-md-12' style='margin-top:20px;'>
                                                        <div class ='col-md-6'>
                                                            <label class="radio-inline customradio"><span class="radiotextsty">SIN FONDO</span>
                                                                <input type="radio" name="rango_recibo_fondo" value='0' checked>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class ='col-md-6'>
                                                            <label class="radio-inline customradio"><span class="radiotextsty">CON FONDO</span>
                                                                <input type="radio" name="rango_recibo_fondo" value='1' >
                                                                <span class="checkmark"></span>
                                                             </label>
                                                        </div>                    
                                                </div>
                                                <div class='col-md-12' style ='margin-top:15px' >
                                                    <strong>
                                                        CANTIDAD
                                                    </strong>
                                                </div>
                                                <div class='col-md-12' style='margin-top:20px;'>
                                                        <div class ='col-md-6'>
                                                            <label class="radio-inline customradio"><span class="radiotextsty">TODOS</span>
                                                                <input type="radio" name="rango_recibo_cantidad" value='0' checked>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class ='col-md-6'>
                                                            <label class="radio-inline customradio"><span class="radiotextsty">SOLO MARCADOS</span>
                                                                <input type="radio" name="rango_recibo_cantidad" value='1' >
                                                                <span class="checkmark"></span>
                                                             </label>
                                                        </div>                    
                                                </div>
                                                <div class='col-md-12' style='margin-top:20px;'>
                                                    <button class ='btn btn-info' style ='width:100%; margin-top:25px; margin-bottom :15px;' id='generar_recibo_rango_pdf' disabled>
                                                        <i class="far fa-file-pdf"></i>  GENERAR RECIBOS
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="recibo_individual">
                                <div class="content">
                                    <div class ='row'>
                                        <div class='col-md-12'>
                                            <center>
                                                <h1 class ='retroshadow'>
                                                    GENERADOR DE RECIBO INDIVIDUAL 
                                                </h1>
                                            </center>
                                        </div>
                                        <div class ='col-md-12' style='margin-top:5px;'>
                                            <div class="panel panel-info"> 
                                                <div class="panel-heading">
                                                    PROCESO  
                                                </div>
                                                <div class="panel-body">
                                                    <div class ='row'>
                                                        <div class ='col-md-12'>
                                                            <div class='col-md-8 col-sm-8 col-xs-8'>
                                                                <div class="form-group">
                                                                    <label for="email">SUMINISTRO</label>
                                                                    <input type="text" class="form-control dato-estatico" id="suministro_recibo_individual" >
                                                                </div>       
                                                            </div>
                                                            
                                                            <div class='col-md-4 col-sm-4 col-xs-4'>
                                                                <button class='btn btn-warning' style ='width:100%; margin-top:23px;' id ='buscar_recibo_individual'>
                                                                    <i class="fa fa-search"></i> BUSCAR
                                                                </button>      
                                                            </div>
                                                        </div>
                                                        <div class = 'col-md-12'>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="form-group">
                                                                    <label for="email">AÑO</label>
                                                                    <input type="number" class="form-control dato-estatico" id="anio_recibo_individual" value='2018' >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="form-group">
                                                                    <label for="email">MES</label>
                                                                    <select class="form-control" id="mes_recibo_individual">
                                                                        <option value ='01'>ENERO</option>
                                                                        <option value ='02'>FEBRERO</option>
                                                                        <option value ='03'>MARZO</option>
                                                                        <option value ='04'>ABRIL</option>
                                                                        <option value ='05'>MAYO</option>
                                                                        <option value ='06'>JUNIO</option>
                                                                        <option value ='07'>JULIO</option>
                                                                        <option value ='08'>AGOSTO</option>
                                                                        <option value ='09'>SETIEMBRE</option>
                                                                        <option value ='10'>OCTUBRE</option>
                                                                        <option value ='11'>NOVIEMBRE</option>
                                                                        <option value ='12'>DICIEMBRE</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class ='col-md-12'>
                                            <center>
                                                <h4>
                                                    <strong>
                                                        DATOS Y OPERACIONES EN RECIBOS
                                                    </strong>
                                                </h4>
                                            </center>
                                        </div>
                                        <div class='col-md-12'>
                                            <hr class='style-seven'>
                                        </div>
                                        <div class='col-md-12'>
                                            <div class='col-md-7'>
                                                <div class ='col-md-12'>
                                                    <center>
                                                        <h4>
                                                            <strong>
                                                                DATOS GENERALES 
                                                            </strong>
                                                        </h4>
                                                    </center>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <hr class='style-three'>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <div class='col-md-6 col-sm-6 col-xs-6'>
                                                        <div class="form-group">
                                                            <label for="email">SERIE</label>
                                                            <input type="text" class="form-control dato-estatico" id="individual_serie" disabled>
                                                        </div>       
                                                    </div>
                                                    <div class='col-md-6 col-sm-6 col-xs-6'>
                                                        <div class="form-group">
                                                            <label for="email">NUMERO </label>
                                                            <input type="text" class="form-control dato-estatico" id="individual_numero" disabled>
                                                        </div>       
                                                    </div>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <div class='col-md-12 col-sm-12 col-xs-12'>
                                                        <div class="form-group">
                                                            <label for="email">NOMBRE</label>
                                                            <input type="text" class="form-control dato-estatico" id="individual_nombre" disabled>
                                                        </div>       
                                                    </div>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <div class='col-md-12 col-sm-12 col-xs-12'>
                                                        <div class="form-group">
                                                            <label for="email">DIRECCIÓN</label>
                                                            <input type="text" class="form-control dato-estatico" id="individual_direccion" disabled>
                                                        </div>       
                                                    </div>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <div class='col-md-6 col-sm-6 col-xs-6'>
                                                        <div class="form-group">
                                                            <label for="email">MONTO</label>
                                                            <input type="text" class="form-control dato-estatico" id="individual_monto" disabled>
                                                        </div>       
                                                    </div>
                                                    <div class='col-md-6 col-sm-6 col-xs-6'>
                                                        <div class="form-group">
                                                            <label for="email">TARIFA</label>
                                                            <input type="text" class="form-control dato-estatico" id="individual_tarifa" disabled>
                                                        </div>       
                                                    </div>
                                                </div>

                                            </div>
                                            <div class='col-md-5' style =' background-color: #e0eaed;'>
                                                <div class ='col-md-12'>
                                                    <center>
                                                        <h4>
                                                            <strong>
                                                                OPERACIONES
                                                            </strong>
                                                        </h4>
                                                    </center>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <hr class='style-three'>
                                                </div>
                                                <div class ='col-md-12'>
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li role="presentation" class="active"><a href="#formato_a5" aria-controls="home" role="tab" data-toggle="tab">TAMAÑO A5 </a></li>
                                                        <li role="presentation"><a href="#formato_a4" aria-controls="profile" role="tab" data-toggle="tab"> TAMAÑO A4 </a></li>
                                                        
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="formato_a5">
                                                            <div class='row'>
                                                                <div class='col-md-12' >
                                                                    <strong>
                                                                        FORMATO 
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12' style ='margin-top:10px;' >
                                                                    <div class ='col-md-6'>
                                                                        <label class="radio-inline customradio"><span class="radiotextsty">SIN FONDO</span>
                                                                            <input type="radio" name="reciboa5_tam_individual" value='0' checked>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class ='col-md-6'>
                                                                        <label class="radio-inline customradio"><span class="radiotextsty">CON FONDO</span>
                                                                            <input type="radio" name="reciboa5_tam_individual" value='1'>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <button class ='btn btn-info' style ='width:100%; margin-top:25px;' id='generar_recibo_a5_pdf' disabled>
                                                                    <i class="far fa-file-pdf"></i>  GENERAR RECIBOS
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="formato_a4">
                                                            <div class='row'>
                                                                <div class='col-md-12' >
                                                                    <strong>
                                                                        FORMATO 
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12' style ='margin-top:10px;' >
                                                                    <div class ='col-md-6'>
                                                                        <label class="radio-inline customradio"><span class="radiotextsty">SIN FONDO</span>
                                                                            <input type="radio" name="reciboa4_tam_individual" value='0' checked>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class ='col-md-6'>
                                                                        <label class="radio-inline customradio"><span class="radiotextsty">CON FONDO</span>
                                                                            <input type="radio" name="reciboa4_tam_individual" value='1'>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12' style ='margin-top:15px' >
                                                                    <strong>
                                                                        POSICIÓN
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12' style ='margin-top:10px;' >
                                                                    <div class ='col-md-4'>
                                                                        <label class="radio-inline customradio"><span class="radiotextsty">IZQUIERDA</span>
                                                                            <input type="radio" name="reciboa4_posicion_individual" value='1' checked>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class ='col-md-4'>
                                                                        <label class="radio-inline customradio"><span class="radiotextsty">AMBOS</span>
                                                                            <input type="radio" name="reciboa4_posicion_individual" value='2' >
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class ='col-md-4'>
                                                                        <label class="radio-inline customradio"><span class="radiotextsty">DERECHA</span>
                                                                            <input type="radio" name="reciboa4_posicion_individual" value='3' >
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <button class ='btn btn-info' style ='width:100%; margin-top:25px;' id='generar_recibo_a4_pdf' disabled>
                                                                    <i class="far fa-file-pdf"></i>  GENERAR RECIBOS
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script>
var tabla_rangos;
var tabla_rango_inidividual ;
var periodo_general ;
var ciclo_factura_general;
var desde_hasta_general ;
var anio_actual = "<?php echo date("Y"); ?>";
$(document).ready(function ()
{

    tabla_rangos = $('#tabla_rango').DataTable({retrieve: true, paging: true,bFilter: true,  bSort:false,"lengthMenu": [[ 15, 50, 100, -1],[ 15, 50, 100, "Todos"]],});
    tabla_rango_inidividual = $('#tabla_rango_individual').DataTable({retrieve: true, paging: true,bFilter: true,  bSort:false,"lengthMenu": [[ 15, 50, 100, -1],[ 15, 50, 100, "Todos"]],});
    $("#buscar_rangos").on("click", function(){
        var anio = $("#control_anio").val();
        anio = anio.trim();
        var mes = $("#control_mes").val();
        var perido = anio+mes;
        var factura  = $("#control_factura").val();
        var i=0;
		var bandera = 0;
        if(anio ==''){
            swal("Atención", "Falta ingresar el año", "error");
        }else{
            while( i< perido.length ){
                if(perido.charCodeAt(i)< 48 ||   perido.charCodeAt(i) > 57 ){
                    bandera = 1;
                }
                i++;
            }
            if(bandera == 0){
                if( anio > anio_actual){
                    swal("Atención", "Ingresó un año mayor al actual", "error");
                }else{
                    obtener_rangos(perido, factura);
                }
            }else{
                swal("Atención", "Ingrese de manera correcta el año", "error");
            }
        }
		
        
	});
    $('#tabla_rango tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');                    
            $( "#generar_recibo_pdf" ).prop( "disabled", true );
        }
        else {
            tabla_rangos.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $( "#generar_recibo_pdf" ).prop( "disabled", false );
            var datos  = tabla_rangos.row('.selected').data();
            desde_hasta_general = datos[3];
            /*var datos  = tabla_rangos.row('.selected').data();
            suministro = datos[2];
            ciclo_catastral = datos[1];*/
        }
    });
    $('#tabla_rango_individual tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    });
    $("#generar_recibo_pdf").on("click", function(){
        generando_pdf();
	});
    $("#buscar_suministro_recibo_rango").on("click", function(){
        buscar_recibo_rango();
	});
    $("#generar_recibo_rango_pdf").on("click", function(){
        generando_recibos_rango();
	});
    $("#buscar_recibo_individual").on("click", function(){
        generando_recibos_individual();
	});
    $("#generar_recibo_a5_pdf").on("click", function(){
        impresion_recibos_individual(5);
	});
    $("#generar_recibo_a4_pdf").on("click", function(){
        impresion_recibos_individual(4);
	});
});

function impresion_recibos_individual(tipo_formato){
    var serie = $('#individual_serie').val();
    var numero = $('#individual_numero').val();
    if(tipo_formato == 5){
        var Valor_fondo =  $('input:radio[name=reciboa5_tam_individual]:checked').val();
        var json = JSON.stringify(new Array(tipo_formato, serie, numero ,Valor_fondo));
    }else{
        var Valor_fondo =  $('input:radio[name=reciboa4_tam_individual]:checked').val();
        var Valor_posicion =  $('input:radio[name=reciboa4_posicion_individual]:checked').val();
        var json = JSON.stringify(new Array(tipo_formato, serie, numero ,Valor_fondo, Valor_posicion));
    }
    
    event.preventDefault();
    var form = jQuery('<form>', {
                    'action': '<?php echo $this->config->item('ip');?>recibo/suministro/imprimir/recibo/individual',
                    'target': '_blank',
                    'method': 'post',
                    'type': 'hidden'
            }).append(jQuery('<input>', {
                    'name': 'recibo_individual',
                    'value': json,
                    'type': 'hidden'
            }));
    $('body').append(form);
    form.submit();
}

function generando_recibos_individual(){
    var suministro_individual = $('#suministro_recibo_individual').val();
    var anio_inicio = $('#anio_recibo_individual').val();
    var mes_inicio = $('#mes_recibo_individual').val(); 
    var periodo  = anio_inicio+mes_inicio;
    suministro_individual = suministro_individual.trim();
    if (suministro_individual !="") {
    	if (suministro_individual.length ==11 || suministro_individual.length ==7) {
			var i=0;
			var bandera = 0;
			while( i< suministro_individual.length ){
				if(suministro_individual.charCodeAt(i)< 48 ||   suministro_individual.charCodeAt(i)> 57 ){
					bandera = 1;
				}
				i++;
			}
					
			if(bandera == 0){
                if(anio_inicio > anio_actual ){
                    swal("Atención", "El año de inicio es mayor al año actual", "error");
                }else{
                    swal({
                        title: "BUSCAR RECIBO ",
                        text: "¿Esta seguro de buscar el recibo ?",
                        type: "info",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                    },
                    function(){
                        cargando_recibo_individual(suministro_individual, periodo);
                    });    
                }
                
			}else{
				swal("Atención", "Ingresó Codigo de suministro Incorrecto", "error");
			}
    	}else{
    		swal("Atención", "Ingresó Codigo de suministro Incorrecto", "error");
    	}
    }else{
		swal("Atención", "Ingresó Codigo de suministro Incorrecto", "error");
	}
    
}


function cargando_recibo_individual(suministro_individual, periodo){
    $( "#generar_recibo_a5_pdf" ).prop( "disabled", true );
    $( "#generar_recibo_a4_pdf" ).prop( "disabled", true );
    $.ajax({
          type: 'POST',
          url : '<?php echo $this->config->item('ip'); ?>recibo/rango/suministro_individual?ajax=true',
          data: ({
            suministro_fac : suministro_individual,
            peri_inicio : periodo
          }),
          cache: false,
          dataType: 'json',
          success: function(data){
            if(data.result){
                swal.close();
                console.log(data.datos);
                $('#individual_serie').val(data.datos[0].FACSERNRO);
                $('#individual_numero').val(data.datos[0].FACNRO);
                $('#individual_nombre').val(data.datos[0].CLINOMBRE);
                $('#individual_direccion').val(data.datos[0].DESURBA.trim() + ' ' + data.datos[0].DESCALLE.trim());
                $('#individual_monto').val(data.datos[0].FACTOTAL + data.datos[0].FACSALDO);
                $('#individual_tarifa').val(data.datos[0].FACTARIFA);
                $( "#generar_recibo_a5_pdf" ).prop( "disabled", false );
                $( "#generar_recibo_a4_pdf" ).prop( "disabled", false );
            }
            
          },
         error : function(jqHRX, textStatus, errorThrown){
            swal("Atención", "Ocurrio un problema en la busqueda", "error");
            $('#individual_serie').val('');
            $('#individual_numero').val('');
            $('#individual_nombre').val('');
            $('#individual_direccion').val('');
            $('#individual_monto').val('');
            $('#individual_tarifa').val('');
          }
    });
}

function generando_recibos_rango(){
    var Valor_cantidad =  $('input:radio[name=rango_recibo_cantidad]:checked').val();
    if(Valor_cantidad == 0){
        var datos_rangos  = tabla_rango_inidividual.data();
    }else{
        var datos_rangos  = tabla_rango_inidividual.rows('.selected').data();
    }
    if(datos_rangos.length > 0){
        var Valor_fondo =  $('input:radio[name=rango_recibo_fondo]:checked').val();
        var json = JSON.stringify(new Array(datos_rangos, Valor_fondo));
        event.preventDefault();
        var form = jQuery('<form>', {
                    'action': '<?php echo $this->config->item('ip');?>recibo/suministro/rango_recibo',
                    'target': '_blank',
                    'method': 'post',
                    'type': 'hidden'
            }).append(jQuery('<input>', {
                    'name': 'detalle_rango_recibo',
                    'value': json,
                    'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }else{
        if(Valor_cantidad == 0){
            swal("Recibos", "NO HAY NINGUN ELEMENTO EN LA TABLA", "error");
        }else{
            swal("Recibos", "DEBE DE SELECCIONAR ALGUN ELEMENTO EN LA TABLA PARA PODER SER IMPRESO", "error");
        }
    }
    
    
}

function buscar_recibo_rango(){
    var suministro_rango = $('#suministro_recibo_rango').val();
    var anio_inicio = $('#anio_recibo_rango_inicio').val();
    anio_inicio = anio_inicio.trim();
    var mes_inicio = $('#mes_recibo_rango_inicio').val();  
    var periodo_inicio = anio_inicio+mes_inicio;
    var anio_fin = $('#anio_recibo_rango_fin').val();
    anio_fin = anio_fin.trim();
    var mes_fin = $('#mes_recibo_rango_fin').val();
    var periodo_fin = anio_fin + mes_fin;
    suministro_rango = suministro_rango.trim();
    if (suministro_rango !="") {
    	if (suministro_rango.length ==11 || suministro_rango.length ==7) {
			var i=0;
			var bandera = 0;
			while( i< suministro_rango.length ){
				if(suministro_rango.charCodeAt(i)< 48 ||   suministro_rango.charCodeAt(i)> 57 ){
					bandera = 1;
				}
				i++;
			}
					
			if(bandera == 0){
                if(anio_inicio > anio_actual ){
                    swal("Atención", "El año de inicio es mayor al año actual", "error");
                }else{
                    if(anio_fin > anio_actual ){
                        swal("Atención", "El año de fin es mayor al año actual", "error");
                    }else{
                        swal({
                            title: "BUSCAR RECIBOS POR RANGOS ",
                            text: "¿Esta seguro de buscar los rangos del recibo ?",
                            type: "info",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                        },
                        function(){
                            cargando_rango_recibo(suministro_rango, periodo_inicio, periodo_fin);
                        });
                    }
                }
                	
			}else{
				swal("Atención", "Ingresó Codigo de suministro Incorrecto", "error");
			}
    	}else{
    		swal("Atención", "Ingresó Codigo de suministro Incorrecto", "error");
    	}
    }else{
		swal("Atención", "Ingresó Codigo de suministro Incorrecto", "error");
	}
                                       
    
}

function cargando_rango_recibo(suministro_rango, periodo_inicio, periodo_fin){
    $( "#generar_recibo_rango_pdf" ).prop( "disabled", true );
    $.ajax({
          type: 'POST',
          url : '<?php echo $this->config->item('ip'); ?>recibo/rango/mando_suministro?ajax=true',
          data: ({
            suministro_fac : suministro_rango,
            peri_inicio : periodo_inicio,
            peri_fin : periodo_fin
          }),
          cache: false,
          dataType: 'json',
          beforeSend: function(){
                       
                    $('#tabla_rango_individual').hide();
                    $("#tabla_rango_contenedor").append("<img src='<?php echo base_url(); ?>./img/loading.gif' style='margin-left:45%;  margin-top:10%;' id='imagen_carga_rango' />");
                   },
          success: function(data){
                swal.close();
                $('#imagen_carga_rango').remove();
                tabla_rango_inidividual.clear().draw();
                $('#tabla_rango_individual').show();
                var i = 0;
                if(i< data.datos.length){
                    $( "#generar_recibo_rango_pdf" ).prop( "disabled", false ); 
                }
                while(i< data.datos.length){
                    tabla_rango_inidividual.row.add( [
                                            (i+1),
                                            data.datos[i].PERIODO, 
                                            data.datos[i].PERIODO.substring(0, 4), 
                                            data.datos[i].DESMES, 
											data.datos[i].FACSERNRO, // promedio
                                            data.datos[i].FACNRO, 
											data.datos[i].FACTOTAL + data.datos[i].FACSALDO
                    ] ).draw(false);
                  i++;
                }
                
          },
          error : function(jqHRX, textStatus, errorThrown){
            swal("Atención", "Ocurrio un problema en la busqueda", "error");
            tabla_rango_inidividual.clear().draw();
            $('#tabla_rango_individual').show();
            $('#imagen_carga_rango').remove();
          }

    });
}

function generando_pdf(){
    swal({
        title: "RECIBOS MASIVOS ",
        text: "¿Esta seguro de generar los recibos?",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
          cargando_imagenes();
      });
    
    /*var desde_hasta_reemplazo = desde_hasta_general.replace("-", "_");
    window.open('<?php echo $this->config->item('ip');?>recibo/masivo/recibos_rango/'+periodo_general+'/'+ciclo_factura_general+'/'+desde_hasta_reemplazo,'popUpWindow','height=900,width=1400,left=1,top=1,,scrollbars=yes,menubar=no').print(); 
    return false;*/
}

function cargando_imagenes(){
    $.ajax({
          type: 'POST',
          url : '<?php echo $this->config->item('ip'); ?>recibo/masivo/genero_imagenes?ajax=true',
          data: ({
            ciclo_fac : ciclo_factura_general,
            periodo_fac : periodo_general,
            rango : desde_hasta_general
          }),
          cache: false,
          dataType: 'json',
          beforeSend: function(){
           
          },
          success: function(data){
            if(data.result){
                swal.close();
                var desde_hasta_reemplazo = desde_hasta_general.replace("-", "_");
                var Valor_fondo =  $('input:radio[name=masivo_recibo_fondo]:checked').val();
                //window.open('<?php echo $this->config->item('ip');?>recibo/masivo/recibos_rango/'+periodo_general+'/'+ciclo_factura_general+'/'+desde_hasta_reemplazo,'popUpWindow','height=900,width=1400,left=1,top=1,,scrollbars=yes,menubar=no').print();
                window.open('<?php echo $this->config->item('ip');?>recibo/masivo/recibos_rango/'+periodo_general+'/'+ciclo_factura_general+'/'+desde_hasta_reemplazo+'/'+Valor_fondo,'popUpWindow','height=900,width=1400,left=1,top=1,,scrollbars=yes,menubar=no'); 
                return false;
                /*var desde_hasta_reemplazo = desde_hasta_general.replace("-", "_");
                var json = JSON.stringify(new Array(data.detalle));
                event.preventDefault();
                var form = jQuery('<form>', {
                                'action': '<?php echo $this->config->item('ip');?>recibo/masivo/recibos_rango/'+periodo_general+'/'+ciclo_factura_general+'/'+desde_hasta_reemplazo,
                                'target': '_blank',
                                'method': 'post',
                                'type': 'hidden'
                            }).append(jQuery('<input>', {
                                'name': 'detalle_recibo',
                                'value': json,
                                'type': 'hidden'
                            }));
                $('body').append(form);
                form.submit();*/
                /*form.submit()= function() {
                    var w = window.open('about:_blank','popUpWindow','height=900,width=1400,left=1,top=1,,scrollbars=yes,menubar=no').print();
                    this.target = 'Popup_Window';
                };*/
            }
          },
          error : function(jqHRX, textStatus, errorThrown){
            console.log('ocurrio un problema con el servidor');
          }
    }); 
}

function obtener_rangos(perido, factura){
    $.ajax({
          type: 'POST',
          url : '<?php echo $this->config->item('ip'); ?>recibo/masivo/mando_masivo?ajax=true',
          data: ({
            ciclo_fac : factura,
            periodo_fac : perido
          }),
          cache: false,
          dataType: 'json',
          beforeSend: function(){
                       
                    $('#tabla_rango').hide();
                    $("#contendor").append("<img src='<?php echo base_url(); ?>./img/loading.gif' style='margin-left:45%;  margin-top:10%;' id='imagen_carga' />");
                   },
          success: function(data){
            if(data.result){
              
              $('#imagen_carga').remove();
              //var rangos_cantidad = 2000;
              var i = 0 ;
              tabla_rangos.clear().draw();
              $('#tabla_rango').show();
              console.log(data);
               periodo_general = data.periodo ;
               ciclo_factura_general = data.ciclo;
              while(i< data.respuesta.length){
                    tabla_rangos.row.add( [
                                            (i+1),
                                            data.respuesta[i][0].MINCODIGO, 
											data.respuesta[i][0].MAXCODIGO, // promedio
                                            data.respuesta[i][0].DESDE_HASTA, 
											data.respuesta[i][0].CANTIDAD
                    ] ).draw(false);
                  i++;
              }
              $('#numero_recibos_ciclo').val(data.cantidad);
                         
            }else{
              
            } 
          },
          error : function(jqHRX, textStatus, errorThrown){
            swal("Atención", "Ocurrio un problema en la busqueda", "error");
            tabla_rangos.clear().draw();
            $('#tabla_rango').show();
            $('#imagen_carga').remove();
          }
    });
}
</script>