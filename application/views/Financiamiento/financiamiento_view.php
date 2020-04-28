<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/iCheck/all.css">
<style type="text/css">
	/*empieza */
	.with-nav-tabs.panel-primary .nav-tabs > li > a{
		font-size: 1.7rem;
	}
	.with-nav-tabs.panel-primary .nav-tabs > li > a,
	.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
	.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
		color: #fff;
	}
	.with-nav-tabs.panel-primary .nav-tabs > .open > a,
	.with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
	.with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
	.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
	.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
		color: #fff;
		background-color: #3071a9;
		border-color: transparent;
	}
	.with-nav-tabs.panel-primary .nav-tabs > li.active > a,
	.with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
	.with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
		color: #428bca;
		background-color: #fff;
		border-color: #428bca;
		border-bottom-color: transparent;
	}
	.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
		background-color: #428bca;
		border-color: #3071a9;
	}
	.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
		color: #fff;   
	}
	.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
	.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
		background-color: #3071a9;
	}
	.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
	.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
	.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
		background-color: #4a9fe9;
	}
	/*termina clases de panel */
	/*clase para la tabla*/
	
	.selected {
    background-color: #367FA9;
    color: #FFF;
	}
	.modal-header, h5, .close {
      background-color: #3C8DBC;
      color:white !important;
      text-align: center;
      font-size: 20px;
	  }
	.modal-footer {
	      background-color:#3C8DBC;
	  }
	.well{
    border: 1px solid #5ca6b7 !important;
    background: #e6e6e6 !important;
	}
	hr {
		height: 1px;
		border: 0;
		background-color: #337ab7;
	}

	/* .slideThree */
	.slideThree {
	width: 80px;
	height: 26px;
	background: #333;
	margin: 20px auto;
	position: relative;
	border-radius: 50px;
	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
	}
	.slideThree::before {
		content: 'SI';
		color: #337ab7;
		position: absolute;
		left: 10px;
		z-index: 0;
		font: 12px/26px Arial, sans-serif;
		font-weight: bold;
	}
	.slideThree::after {
		content: 'NO';
		color: #fff;
		position: absolute;
		right: 10px;
		z-index: 0;
		font: 12px/26px Arial, sans-serif;
		font-weight: bold;
		text-shadow: 1px 1px 0px rgba(255,255,255,.15);
	}
	.slideThree>label {
		display: block;
		width: 34px;
		height: 20px;
		cursor: pointer;
		position: absolute;
		top: 3px;
		left: 3px;
		z-index: 1;
		background: #fcfff4;
		background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
		border-radius: 50px;
		transition: all 0.4s ease;
		box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
	}
	.slideThree > input[type=checkbox] {
		visibility: hidden;
	}
	.slideThree > input[type=checkbox]:checked + label {
		left: 43px;
	}    
	.titular {
	width: 80px;
	height: 26px;
	background: #333;
	margin: 20px auto;
	position: relative;
	border-radius: 50px;
	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
	}
	.titular::before {
		content: 'SI';
		color: #337ab7;
		position: absolute;
		left: 10px;
		z-index: 0;
		font: 12px/26px Arial, sans-serif;
		font-weight: bold;
	}
	.titular::after {
		content: 'NO';
		color: #000;
		position: absolute;
		right: 10px;
		z-index: 0;
		font: 12px/26px Arial, sans-serif;
		font-weight: bold;
		text-shadow: 1px 1px 0px rgba(255,255,255,.15);
	}
	.titular>label {
		display: block;
		width: 34px;
		height: 20px;
		cursor: pointer;
		position: absolute;
		top: 3px;
		left: 3px;
		z-index: 1;
		background: #fcfff4;
		background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
		border-radius: 50px;
		transition: all 0.4s ease;
		box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
	}
	.titular > input[type=checkbox] {
		visibility: hidden;
	}
	.titular > input[type=checkbox]:checked + label {
		left: 43px;
	}
	.button {
		display: inline-block;
		padding: 10px 35px;
		font-size: 15px;
		cursor: pointer;
		text-align: center;
		text-decoration: none;
		outline: none;
		color: #fff;
		background-color: #337ab7;
		border: none;
		border-radius: 15px;
		box-shadow: 0 9px #999;
	}

	.button:hover {background-color: #337ab9}

	.button:active {
		background-color: #337ab9;
		box-shadow: 0 5px #666;
		transform: translateY(4px);
	}
	/*input[type=text] {
		border: 1px dotted #999;
		border-radius: 15px;
	}*/
	
	.style-input{
		border: 1px solid #367fa9;
	}
	.dato-estatico{
		-webkit-box-shadow: 0px 0px 25px -6px rgba(0,0,0,0.75);
		-moz-box-shadow: 0px 0px 25px -6px rgba(0,0,0,0.75);
		box-shadow: 0px 0px 25px -6px rgba(0,0,0,0.75);
	}
	.dato-fondo{
		background-color: #18A0CE;	
	}
	/* end .slideThree */
</style>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border borde_box">
					<div class="row">
						<div class="col-md-5">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; GENERACIÓN DE FINANCIAMIENTO</h2>
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class ="row">
                        <div class="col-md-12">
                            <div class="panel panel-danger"> 
                                <div class="panel-heading">
                                       CODIGO DE SUMINISTRO  
                                </div>
                                <div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="form-group">
												<label for="email">Codigo</label>
												<input type="text" class="form-control style-input" id="suministro">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-3">
											<div class="form-group">
												<label for="email">Operación</label>
												<button class="btn btn-primary form-control dato-estatico" id="Buscar_suministro">
													BUSCAR
												</button>
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-3">
											<div class="form-group">
												<label for="email"></label>
												<button class="btn btn-primary form-control dato-estatico" id="Limpiar_suministro">
													LIMPIAR
												</button>
											</div>
										</div>
									</div>
									<div class="col-md-4">
				                		<div class="checkbox">
										   <label id="text_convenio"  style="color: red;  font-size: 18px;"><input type="checkbox"   id="convenio" checked><b> Si quiero considerar en el convenio de recibo pendiente de pago que aun no vence </b> </label>
										</div>	
				                	</div>
									<div class="col-md-4">
										<div class="checkbox">
										   <label id="text_reclamo" style ="font-size: 18px;"><input type="checkbox" id="reclamo" > <b> Si quiero que los recibos con reclamo vigente formen parte de la deuda financiera </b></label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="checkbox">
										   <label id="text_pendiente"  style="color: red; font-size: 18px; "><input type="checkbox" id="pendiente"  checked> <b> Si quiero que las cuotas pendientes de facturar (por capital) se incluyan en el financiamiento (*) </b>  </label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class = "row">
                        <div class= "col-md-12">
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    DATOS CATASTRALES DE USUARIO  
                                </div>
                                <div class="panel-body">
									<div class="row" >
										<div class= "col-md-6 col-md-offset-6">
											<a class= "btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" style="width:100%" id='ocult_most'>
												OCULTAR DATOS 
											</a>
										</div>
									</div>
									<div class="row collapse in"  id="collapseExample">
										<div class="col-md-12" style="margin-top:15px;">
											<div class="col-md-5 col-sm-5 col-xs-5">
												<div class="form-group">
													<label for="email">NOMBRE</label>
													<input type="text" class="form-control dato-estatico" id="nombre_cliente" placeholder="Nombre de cliente" readonly="readonly">
												</div>
											</div>
											<div class="col-md-7 col-sm-7 col-xs-7">
												<div class="form-group">
													<label for="email">DIRECCIÓN</label>
													<input type="text" class="form-control dato-estatico" id="direccion_cliente" placeholder="Dirección de cliente" readonly="readonly">
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">LOCALIDAD</label>
													<input type="text" class="form-control dato-estatico" id="localidad_cliente" placeholder="Localidad" readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">EST. CLIENTE</label>
													<input type="text" class="form-control dato-estatico" id="estado_cliente" placeholder="Estado de cliente" readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">CONEX. AGUA</label>
													<input type="text" class="form-control dato-estatico" id="conexionAgua_cliente" placeholder="Conex. Agua" readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">CONEX. DESAGUE</label>
													<input type="text" class="form-control dato-estatico" id="conexionDes_cliente" placeholder="Conex. Desague" readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">TIP. SER.</label>
													<input type="text" class="form-control dato-estatico" id="tipo_Servicio" placeholder="Tipo de Servicio" readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">CICLO</label>
													<input type="text" class="form-control dato-estatico" id="Ciclo_cliente" placeholder="Ciclo" readonly="readonly">
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">TARIFA</label>
													<input type="text" class="form-control dato-estatico" id="tarifa_cliente"  readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">TIP. INMUEBLE</label>
													<input type="text" class="form-control dato-estatico" id="tipInmueble_cliente" placeholder="Tip. Inmueble" readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-4">
												<div class="form-group">
													<label for="email">USO INMUEBLE</label>
													<input type="text" class="form-control dato-estatico" id="usoInmueble_cliente" placeholder="Uso Inmueble" readonly="readonly">
												</div>
											</div>
											<div class="col-md-3 col-sm-4 col-xs-4 ">
												<div class="form-group">
													<label for="email">ABAS. DE AGUA</label>
													<input type="text" class="form-control dato-estatico" id="abasAgua_cliente" placeholder="Abs. Agua" readonly="readonly">
												</div>
											</div>
											<div class="col-md-3 col-sm-6 col-xs-6">
												<div class="form-group">
													<label for="email">ABAS. DE DESAGUE</label>
													<input type="text" class="form-control dato-estatico" id="abasDesa_cliente" placeholder="Abs. Desague" readonly="readonly">
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-2 col-sm-6 col-xs-6">
												<div class="form-group">
													<label for="email">GRUPO</label>
													<input type="text" class="form-control dato-estatico" id="grupo_cliente" placeholder="Grupo" readonly="readonly">
												</div>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-6">
												<div class="form-group">
													<label for="email"> SUB-GRUPO</label>
													<input type="text" class="form-control dato-estatico" id="Subgrupo_cliente" placeholder="Sub-Grupo" readonly="readonly">
												</div>
											</div>
											<div class="col-md-8 col-sm-6 col-xs-6">
												<div class="form-group">
													<label for="email"> PLAN DE FINANCIAMIENTO</label>
													<input type="text" class="form-control dato-estatico" id="plan_financiamiento_descri" placeholder="Plan de Financiamiento" readonly="readonly">
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-4 col-sm-6 col-xs-6">
												<div class="form-group">
													<label for="email">MESES DE DEUDA</label>
													<input type="text" class="form-control dato-estatico" id="Cab_mes_deuda" placeholder="Meses de Deuda" readonly="readonly">
												</div>
											</div>
											<div class="col-md-4 col-sm-6 col-xs-6">
												<div class="form-group">
													<label for="email">DEUDA CAPITAL</label>
													<input type="text" class="form-control dato-estatico" id="Cab_deuda_capital" placeholder="Deuda Capital" readonly="readonly">
												</div>
											</div>
											<div class="col-md-4 col-sm-6 col-xs-6">
												<div class="form-group">
													<label for="email">CUOTA POR EMITIR</label>
													<input type="text" class="form-control dato-estatico" id="Cab_cuota_emitir" placeholder="Cuota por Emitir" readonly="readonly">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
				        <div class="col-md-12">
				          <!-- Custom Tabs -->
						  	<div class="panel with-nav-tabs panel-primary">
								<div class="panel-heading">
									<ul class="nav nav-tabs color">
										<!--<li class="active"><a href="#seteos" data-toggle="tab">(0)Seteos</a></li>-->
										<li class="active" ><a  href="#evaluacion" data-toggle="tab" >(1)Evaluación</a></li>
										<li><a href="#plan_f" data-toggle="tab">(2)Plan de Financiamiento</a></li>
										<li><a href="#acta_r" data-toggle="tab">(3)Acta de Reconocimiento</a></li>
										<li><a href="#calculo" data-toggle="tab">(4)Calculo</a></li>
										<li><a href="#nota_d" data-toggle="tab">(5)Nota de debito</a></li>
										<li><a href="#recibos" data-toggle="tab">(6)Recibos</a></li>
									</ul>
								</div>
								<div class="panel-body">
									<div class="tab-content">
										<!--seteos -->
										<!--<div class="tab-pane active" id="seteos">
										<div class="row">
											<h3 class="text-center box-title">
												Consideraciones especiales para la Ejecución de este convenio
											</h3>
											<div class="col-md-12">
												<div class="checkbox">
													<label id="text_convenio"  style="color: red;  font-size: 18px;"><input type="checkbox"   id="convenio" checked> Si quiero considerar en el convenio de recibo pendiente de pago que aun no vence </label>
												</div>
												<div class="checkbox">
													<label id="text_reclamo" style ="font-size: 18px;"><input type="checkbox" id="reclamo" > Si quiero que los recibos con reclamo vigente formen parte de la deuda financiera </label>
												</div>
												<div class="checkbox">
													<label id="text_pendiente"  style="color: red; font-size: 18px; "><input type="checkbox" id="pendiente"  checked> Si quiero que las cuotas pendientes de facturar (por capital) se incluyan en el financiamiento (*)</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<button id="pas_evaluacion" class="btn  btn-success btn-flat pull-right"  disabled>
													SIGUIENTE
												</button>	
											</div>
											
										</div>
										</div>-->
										<!--evaluacion -->
										<div class="tab-pane active " id="evaluacion">
											<div class="row">
												<div class="col-md-12">
													<!--<button id="ant_seteos" class="btn   btn-success btn-flat pull-left">
														ANTERIOR
													</button>-->
													<button id="pas_financiamiento" class=" pull-right button" disabled>
														SIGUIENTE
													</button>
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-12" style="margin-top: 15px; overflow-y:hidden; overflow-x: scroll;" >
													<h4>
														<ul style="list-style-type:circle">
															<li>
																<b>CONVENIOS POR DEUDA (DEUDAS POR CONVENIO ANTERIORES )</b>
															</li>
														</ul>
														
													</h4>
													<hr>
													<table class="table table-bordered" id="tab_evaluacion">
														<thead >
															<tr >
															<th>Oficina</th>
															<th>Agencia</th>
															<th>Credito</th>
															<th>Fecha</th>
															<th>Estado</th>
															<th>Deuda Total</th>
															<th>Inicial</th>
															<th>Nro Letra</th>
															<th>Concepto</th>
															<th>Descri. Concepto</th>
															<th>Fecha Estado</th>
															<th>Referencia</th>
															<th>Digitador</th>
															</tr>
														</thead>
														<tbody>
															
															
														</tbody>
													</table>
												</div>
												<div class="col-md-12" style="margin-top: 15px;">
													<h4>
														<ul style="list-style-type:circle">
															<li>
																<b>ESTRUCTURA DE LAS CUOTAS POR CONVENIOS ANTERIORES</b>
															</li>
														</ul>
													</h4>
													<hr>
													<div class="col-md-12">
														<table class="table table-bordered" id="Tab_Est_Cuotas">
															<thead>
																<tr >
																<th><b>Oficina</b></th>
																<th><b>Agencia</b></th>
																<th><b>Credito</b></th>
																<th><b>Letra</b></th>
																<th><b>Monto cuota</b></th>
																<th><b>Vencimiento</b></th>
																<th><b>Estado</b></th>
																<th><b>Fecha Estado</b></th>
																<th><b>Serie Recibo</b></th>
																<th><b>Nro Recibo</b></th>
																</tr>
															</thead>
															<tbody>
																
																
															</tbody>
														</table>
													</div>
													
												</div>
											</div>
										 
										</div>
										<!-- plan de financiamiento -->
										<div class="tab-pane" id="plan_f">
											<div class="row" >
												<div class="col-md-12">
													<button id="ant_evaluacion" class="button pull-left">
														ANTERIOR
													</button>
													<button id="pas_reconocimiento" class="button pull-right">
														SIGUIENTE
													</button>
												</div>
												<div class='col-md-12'>
													<h3 class="text-center">
														<span style="color:red;" > ENTIDAD PUBLICA : </span> <span id="entidad_publica"> </span>
													</h3>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12" style="margin-top: 20px;">
													<div class="col-md-4">
														<div class="form-group">
															<label for="email">MESES DE DEUDA</label>
															<input type="text" class="form-control dato-estatico" id="plan_f_mes" readonly="true">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="email">TARIFA</label>
															<input type="text" class="form-control dato-estatico" id="plan_f_tarifa" readonly="true">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="email">CATEGORIA</label>
															<input type="text" class="form-control dato-estatico" id="plan_f_categoria" readonly="true">
														</div>
													</div>
												</div>
			
												<div class="col-md-12">
													<div class="col-md-12" style="overflow-y:hidden; overflow-x: scroll;">
														<h4 class="box-title">
															<ul style="list-style-type:circle">
																<li>
																	<b>SELECCIONE UN PLAN DE FINANCIAMIENTO DISPONIBLE PARA EL USUARIO</b>
																</li>
															</ul>
														</h4>
														<hr>
														<table class="table table-bordered" id="tab_plan_financiamiento" >
															<thead class="thead-inverse">
																<tr >
																<th width="30">Nro</th>
																<th width="50">Tipo Cliente</th>
																<th width="50">Cartera</th>
																<th width="70">Desde MD</th>
																<th width="70">Hasta MD</th>
																<th width="70">Plazo Max.</th>
																<th width="80">% Inicial-Ini</th>
																<th width="80">Interes Descuento</th>
																<th width="80">G cobranza-Descuento</th>
																<th width="190">Descripción</th>
																<th>Valido Hasta</th>
																
																</tr>
															</thead>
															<tbody >
																
																
															</tbody>
														</table>
													</div>
									
													
													<div class="row">
														<div class="col-md-12">
															<div class="box">
																<div class="box-header">
																	<h4 class="box-title" style = "margin-top:20px;">
																		<ul style="list-style-type:circle">
																			<li>
																				<b> PLAN ASIGNADO</b>
																			</li>
																		</ul>
																	</h4>
																	<hr>
																</div>
																<div class="box-body">
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="email">EL CLIENTE SE ACOGIO AL PLAN</label>
																			<input type="text" class="form-control dato-estatico" id="inp_plan_financia" placeholder="Plan" readonly="true">
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="email">EL NUMERO MAXIMO DE CUOTAS SERÁ</label>
																			<input type="text" class="form-control dato-estatico" id="inp_cuota_financia" placeholder="Cuotas" readonly="true">
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="email">LA INICIAL SERA NO MENOR <b class="fa fa-arrow-circle-down"></b> % DE LA INICIAL</label>
																			<input type="text" class="form-control dato-estatico" id="inp_porcentaje_financia" placeholder="Porcentaje" readonly="true">
																		</div>
																	</div>
																</div>
																</div>
														</div>
													</div>
												
													
												</div>
											</div>
										</div>
										<!-- actas de reconocimiento -->
										<div class="tab-pane " id="acta_r">
											<div class="row" >
												<div class="col-md-12">
													<button id="ant_financiamiento" class="button pull-left">
														ANTERIOR
													</button>
													<button id="pas_calculo" class="button pull-right">
														SIGUIENTE
													</button>
												</div>
											</div>
											<h4 class="box-title" style="margin-top: 20px;">
												<ul style="list-style-type:circle">
													<li>
														<b> INGRESE LOS DATOS GENERALES PARA EL FINANCIAMIENTO</b>
													</li>
												</ul>
											</h4>
											<hr>
											<div class="row">
												<div class="col-md-12" style = "margin-top:20px;">
													<div class="col-md-3">
														<p style="font-size: 18px; margin-top:10px; margin-left:20px;">
															<b>DOCUMENTO FACULTATIVO</b>
														</p>
													</div>
													<div class="col-md-9">
														<input type="text" class="form-control style-input" id="recono_obs" style="width: 100%;">
													</div>
												</div>
												<div class="col-md-12" style="margin-top: 15px;">
													<div class="col-md-1">
															<!-- .slideThree -->
															<div class="titular">  
															<input type="checkbox" value="None" id="titular" checked="true" disabled="true" />
															<label for="titular"></label>
															</div>
															<!-- end .slideThree -->
													</div>
													<div class="col-md-2">
														<p style="font-size: 18px; margin-top:20px; ">
															<b>TITULAR</b>
														</p>
													</div>
													<div class="col-md-1">
															<!-- .slideThree -->
															<div class="slideThree">  
															<input type="checkbox" id="slideThree" name="check" />
															<label for="slideThree"></label>
															</div>
															<!-- end .slideThree -->
													</div>
													<div class="col-md-2">
														<p style="font-size: 18px; margin-top:20px; ">
															<b>REPRESENTANTE</b>
														</p>
													</div>
													<!--<div class="col-md-2">
														<div>
																<label><input type="checkbox"  name="recono_repre" >REPRESENTANTE</label>
														</div>
													</div>-->
													<div class="col-md-4">
															<div class="form-group">
																<label for="email"><b>SUMINISTRO</b></label>
																<input type="text" class="form-control dato-estatico" id="sum_recibo" placeholder="Cuotas" readonly="true">
															</div>
													</div>
												</div>
												
												<div class="col-md-12" style="margin-top: 15px;">
													<table class="table table-condensed" id="recono_table">
															<thead>
																<tr >
																<th>Codigo</th>
																<th>Nombre</th>
																<th>Dirección</th>
																<th>DNI</th>
																<th>RUC</th>
																<th>Telefono</th>
																<th>Correo</th>
																<th>Documento</th>
																
																</tr>
															</thead>
															<tbody>

															</tbody>
													</table>
												</div>
												
											</div>
											<div class="row">
												<div class="col-md-12" style="margin-top: 15px;">
													<h3 class="box-title">
													<ul style="list-style-type:circle">
														<li>
															<b>OBSERVACIONES :</b>
														</li>
													</ul>
													</h3>
													<hr>
												</div>
												<div class="col-md-12" style="margin-top: 15px;">
														<div class="col-xs-5">
															<select name="from[]" id="search" class="form-control " size="8" multiple="multiple">
																
															</select>
														</div>
														
														<div class="col-xs-2">
															<button type="button" id="search_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
															<button type="button" id="search_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
															<button type="button" id="search_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
															<button type="button" id="search_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
														</div>
														
														<div class="col-xs-5">
															<select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple"></select>
														</div>
												</div>
											</div>
										</div>
										<!--calculo -->
										<div class="tab-pane" id="calculo" >
											<div class="row">
												<div class="col-md-12">
													<button id="ant_AcReconocimiento" class="button pull-left">
														ANTERIOR
													</button>
													<button id="pas_NotDebito" class="button pull-right">
														SIGUIENTE
													</button>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12" style="margin-top: 20px;">
															<div class="col-md-3">
																<div class="form-group">
																	<label for="email">FECHA REGISTRO</label>
																	<input type="text" class="form-control dato-estatico" id="Cal_fecha" placeholder="Tipo de Servicio" readonly="true">
																</div>
															</div>
															<div class="col-md-5">
																<div class="form-group">
																	<label for="email">USUARIO</label>
																	<input type="text" class="form-control dato-estatico" id="Cal_usuario" placeholder="Tipo de Servicio" readonly="true" value="<?php echo $_SESSION['user_nom']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="form-group">
																	<label for="email">OFICINA</label>
																	<input type="text" class="form-control dato-estatico" id="Cal_Oficina" placeholder="Tipo de Servicio" readonly="true" value="<?php echo $_SESSION['OFICOD']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="form-group">
																	<label for="email">AGENCIA</label>
																	<input type="text" class="form-control dato-estatico" id="Cal_agencia" placeholder="Tipo de Servicio" readonly="true" value="<?php echo $_SESSION['OFIAGECOD']; ?>">
																</div>
															</div>
												</div>
												<div class="col-md-12">
													<div class="col-md-12">
																<div class="form-group">
																	<label for="email">PLAN</label>
																	<input type="text" class="form-control dato-estatico" id="cal_descri_plan" readonly="true">
																</div>
													</div>
												</div>
												<div class="col-md-12">
															
															<div class="col-md-6">
																<div class="form-group">
																	<label for="email">TASA DE INTERESES</label>
																	<input type="text" class="form-control dato-estatico" id="cal_tasa_interes" readonly="true" >
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="email">FRC</label>
																	<input type="text" class="form-control dato-estatico" id="cal_frc" readonly="true">
																</div>
															</div>
														
												</div>
												
													<div class="col-md-6">
														<div class="col-md-12">
															<div class="col-md-4">
																DEUDA CAPITAL
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="Cal_deuda_capital" style="width: 100%;text-align:right; " readonly="true">
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico dato-fondo" id="fi_deuda_capital" style="width: 100%;text-align:right; background-color: #909A9D; color: #fff; " readonly="true">
															</div>
														</div>
														<div class="col-md-12" style="margin-top: 15px; ">
															<div class="col-md-4">
																CUOTAS POR EMITIR
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="Cal_cuota_emitir" style="width: 100%;text-align:right;  " readonly="true">
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="fi_cuota_emitir" style="width: 100%;text-align:right; background-color: #909A9D; color: #fff; " readonly="true">
															</div>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<div class="col-md-4">
																CARGOS VARIOS 
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="cal_cargos_varios" style="width: 100%; text-align:right;" readonly="true">
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="fi_cargos_varios" style="width: 100%; text-align:right; background-color: #909A9D; color: #fff;" readonly="true">
															</div>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<div class="col-md-4">
																GASTOS DE COBRANZA
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="cal_gasto_cobranza" style="width: 100%;text-align:right; " readonly="true">
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="fi_gasto_cobranza" style="width: 100%;text-align:right; background-color: #909A9D; color: #fff; " readonly="true">
															</div>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<div class="col-md-4">
																INTERES MORATORIO
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="cal_int_moratorio" style="width: 100%; text-align:right;" readonly="true">
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="fi_int_moratorio" style="width: 100%; text-align:right; background-color: #909A9D; color: #fff;" readonly="true">
															</div>
														</div>
														
														<div class="col-md-12" style="margin-top: 15px;">
															<div class="col-md-4">
																DEUDA TOTAL
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="Cal_deuda_total" style="width: 100%; text-align:right;" readonly="true">
															</div>
															<div class="col-md-4">
																<input type="text" class="form-control dato-estatico" id="fi_deuda_total" style="width: 100%; text-align:right; background-color: #909A9D; color: #fff;" readonly="true">
															</div>
														</div>
													</div>
													<div class=" col-md-6">
															<h4 class="box-title">
																<ul style="list-style-type:circle">
																	<li>
																		<b>DEFINA LA INICIAL</b>
																	</li>
																</ul>
															</h4>
															<hr>
															<div class="col-md-12">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="email">INICIAL</label>
																		<input type="text" class="form-control dato-estatico" id="Cal_inicial" placeholder="Tipo de Servicio" readonly="true">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="email">SALDO</label>
																		<input type="text" class="form-control dato-estatico" id="Cal_saldo" placeholder="Tipo de Servicio" readonly="true">
																	</div>
																</div>
															</div>
															<div class="col-md-12">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="email">NRO. CUOTAS</label>
																		<input type="text" class="form-control dato-estatico" id="Cal_nro_cuota" placeholder="Tipo de Servicio" readonly="true">
																	</div>
																</div>
																
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="email">VENCIMIENTO</label>
																		<input type="text" class="form-control dato-estatico" id="Cal_vencimiento" placeholder="Tipo de Servicio" readonly="true">
																	</div>
																</div>
															</div>
															
															
														
															<div class="col-md-12">
																<button class="btn btn-primary" style="width:100%;" id="cal_recalcular">
																<i class="fa fa-line-chart"></i> RECALCULAR
																</button>
																<button class="btn btn-danger" style="width:100%; margin-top:15px;" id="cal_proforma">
																<i class="fa fa-file-excel-o"></i> PROFORMA
																</button>
															</div>
															<!--<div class="col-md-6">
																<button class="btn btn-primary" style="width:100%;" id="Cal_simular">
																	SIMULAR
																</button>
															</div>-->
														
													</div>
												
												<div class="col-md-12" style ="margin-top:20px;">
													<h4 class="box-title">
														<ul style="list-style-type:circle">
															<li>
																<b>ESTRUCTURA DEL FINANCIAMIENTO</b>
															</li>
														</ul>
													</h4>
													<hr>
													<div class="col-md-9" style="overflow-y:scroll;  height: 400px !important; overflow-x: hidden;">
														<table class="table table-bordered" id="Cal_simulador" >
															<thead >
																<tr >
																<th>Cuota</th>
																<th>Saldo</th>
																<th>Interes Compensatorio</th>
																<th>Amortización de Capita</th>
																<th>Importe Cuota Final</th>
																<th>Acumulación</th>
																<th>Vencimiento</th>
																</tr>
															</thead>
															<tbody>
																
																
															</tbody>
														</table>
													</div>
													<div class="col-md-3">
														<div class="col-md-12">
															<button class="btn btn-primary" style="width: 100%;" id="Grabar_datos">
															<i class="fa fa-save"></i> GRABAR
															</button>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<button class="btn btn-primary" style="width: 100%;" id="cal_acta" disabled="true">
															<i class="fa fa-file-pdf-o"></i> ACTA
															</button>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<button class="btn btn-primary" style="width: 100%;" id="cal_cronograma" disabled="true">
															<i class="	fa fa-file-excel-o"></i> CRONOGRAMA
															</button>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<button class="btn btn-primary" style="width: 100%;" id="cal_not_debito" disabled="true">
															<i class="fa fa-file-o"></i> N/DEBITO
															</button>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<button class="btn btn-primary" style="width: 100%;" id="cal_det_recibo" disabled="true">
															<i class="fa fa-file-text"></i> DET. RECIBOS
															</button>
														</div>
														<div class="col-md-12" style="margin-top: 15px;">
															<button class="btn btn-primary" style="width: 100%;" id="cal_recibo_caja" disabled="true">
															<i class="fa fa-line-chart"></i> RECIBO CAJA
															</button>
														</div>
													</div>
												</div>
												<div class="col-md-12" style="margin-top: 20px;">
													<div class="col-md-2" >
														<div class="form-group">
															<label for="email">NRO. CUOTAS</label>
															<input type="text" class="form-control dato-estatico" id="cal_base_nro_cuota" readonly="true" >
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">INTERESES</label>
															<input type="text" class="form-control dato-estatico" id="cal_base_interes" readonly="true">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">SALDO</label>
															<input type="text" class="form-control dato-estatico" id="cal_base_saldo" readonly="true" >
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="email">AMORTIZACIONES</label>
															<input type="text" class="form-control dato-estatico" id="cal_base_amortiza" readonly="true">
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="email">TOTAL A PAGAR</label>
															<input type="text" class="form-control dato-estatico" id="cal_base_tot_pagar" readonly="true" >
														</div>
														<input type="text" id="numero_credito" style="visibility:hidden"> 
														<input type="text" id="rut_carpeta" style="visibility:hidden"> 
													</div>
												</div>
											</div>
										</div>
										<!-- nota de debito -->
										<div class="tab-pane" id="nota_d">
											<div class="row">
												<div class="col-md-12">
													<button id="ant_NotaD" class="button pull-left">
														ANTERIOR
													</button>
													<button id="pas_recibo" class="button pull-right">
														SIGUIENTE
													</button>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12" style="margin-top: 20px;">
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">FECHA REGISTRO</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_fecha" readonly="true" >
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">USUARIO</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_usuario" readonly="true" value="<?php echo $_SESSION['user_nom']; ?>">
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label for="email">OFI.</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_oficina" readonly="true" value="<?php echo $_SESSION['OFICOD']; ?>">
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label for="email">AGE.</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_agencia" readonly="true" value="<?php echo $_SESSION['OFIAGECOD']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="email">CONCEPTO</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_concepto" readonly="true">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">INTERESES</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_intereses" readonly="true" value = "0.00">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">G. COBRANZA</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_cobranza" readonly="true" value = "0.00">
														</div>
													</div>
													<div class="col-md-8">
														<div class="form-group">
															<label for="email">REFERENCIA</label>
															<input type="text" class="form-control dato-estatico" id="nota_d_referencia" readonly="true">
														</div>
													</div>
												</div>
			
												<div class="col-md-12">
													<h4 class="box-title">
														<ul style="list-style-type:circle">
															<li>
																SELECCIONE UN RECIBO PARA APLICAR <b> NOTA DE DEBITO </b>
															</li>
														</ul>
													</h4>
													<hr>
													<table class="table " id="tab_nota_debito">
															<thead class="thead-inverse">
																<tr >
																<th>Serie</th>
																<th>Nro</th>
																<th>Emision</th>
																<th>Vencimiento</th>
																<th>Sub Total</th>
																<th>IGV</th>
																<th>Total</th>
																<th >N/C</th>
																<th>N/D</th>
																<th>Real</th>
																</tr>
															</thead>
															<tbody>
																
															</tbody>
													</table>
												</div>
												<div class="col-md-12">
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">Sub-Total N/D</label>
															<input type="text" class="form-control dato-estatico" id="nota_deb_subtotal" readonly="true">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">I.G.V N/D</label>
															<input type="text" class="form-control dato-estatico" id="nota_deb_igv" readonly="true">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="email">Total NOTA DE DEBITO</label>
															<input type="text" class="form-control dato-estatico" id="nota_deb_total" readonly="true">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="email">ESTADO:</label>
															<input type="text" class="form-control dato-estatico" id="estado_nota_debito" readonly="true">
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- recibos -->
										<div class="tab-pane" id="recibos">
										<h4 class="box-title">
											<ul style="list-style-type:circle">
												<li>
													 <b> RECIBOS PENDIENTE DE PAGO </b>  <span id="contador_recibo"></span>
												</li>
											</ul>
										</h4>
										<hr>
										<div class="col-md-12" style="margin-top: 20px; height: 500px !important;overflow: scroll;">
											<table class="table " id="tab_deuda_recibo">
												<thead class="thead-inverse">
													<tr >
														<th>Serie</th>
														<th>Nro</th>
														<th>Emision</th>
														<th>Vencimiento</th>
														<th>Int. Moratorio</th>
														<th>Sub Total</th>
														<th>IGV</th>
														<th>Total</th>
														<th >N/C</th>
														<th>N/D</th>
														<th>Real</th>
														<th>Estado</th>
													</tr>
												</thead>
												<tbody>
															
															
												</tbody>
											</table>
										</div>
										</div>
										<!-- /.tab-pane -->
									</div>
								</div>
						    </div>
							<!-- ***********************  -->	
				        </div>
							        
			        </div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
    if (isset($modal_persona)) {
        $this->load->view($modal_persona);
    }
?>
<script src="<?php echo $this->config->item('ip') ?>frontend/multi_select/multi_select.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/moment/moment.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/pdf_js/jsPDF.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/js/locales/es.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/themes/explorer/theme.js" type="text/javascript"></script>
  
<script>

    /*$('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue'
    })*/
    
    var recibo_pendiente = 1;
    var recibo_Reclamo_Vigente = 0;
    var recibo_pendiente_facturar = 1; 
    var usr = null;
    var bandera_interes = 0;
    var nuevo_inicial ;
    var nuevo_num_letras;
    var ruta_representante;
    var guardo  = 0; 
    var nro_credit = "";
    var nro_amortiza = "";
    var Servidor  = "";
    var tip_financiamiento = "";
	var recibo_pendiente = 1;
	var recibo_reclamo_vigente = 0;
	var cuotas_pendientes  = 1;
	var gerente;
	var es_entidad;
	var entidad_publica;
	var nota_credito_debito;
	var credito_1_cuota = 0; 
	var table_deuda_suministros;
	$( document ).ready(function() {
		table_deuda_suministros = $('#deuda_suministro').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
	    $('.nav li').not('.active').addClass('disabled');
		$('.nav li').not('.active').find('a').removeAttr("data-toggle");
		$("#suministro").keypress(function(e) {
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        });
		/*$('#collapseExample').collapse({
		toggle: true
		});*/
		/*------- Bontones de entrada ----- */
	    $("#convenio").click(function() {  
	        if($("#convenio").is(':checked')) {  
	            $("#text_convenio").css({"color": "red"}); 
				recibo_pendiente = 1; 
	        } else {  
	            $("#text_convenio").css({"color": ""});
				recibo_pendiente = 0;  
	        }  
    	});
    	$("#reclamo").click(function() {  
	        if($("#reclamo").is(':checked')) {  
	            $("#text_reclamo").css({"color": "red"});
				recibo_reclamo_vigente = 1;  
	        } else {  
	            $("#text_reclamo").css({"color": ""});
				recibo_reclamo_vigente = 0 ;  
	        }  
    	});
    	$("#pendiente").click(function() {  
	        if($("#pendiente").is(':checked')) {  
	            $("#text_pendiente").css({"color": "red"});
				cuotas_pendientes = 1; 		 
	        } else {  
	            $("#text_pendiente").css({"color": ""});
				cuotas_pendientes = 0 ;  
	        }  
		});
		/* Fin de boton de entrada  */

		/* ------- Botones de anterior y siguiente  en los tabs -------  */
    	$("#pas_evaluacion").click(function(){
    		$('.nav li.active').next('li').removeClass('disabled');
        	$('.nav li.active').next('li').find('a').attr("data-toggle","tab")
        	$('.nav-tabs > .active').next('li').find('a').trigger('click');
    	}) 
    	$("#pas_financiamiento").click(function(){
    		$('.nav li.active').next('li').removeClass('disabled');
        	$('.nav li.active').next('li').find('a').attr("data-toggle","tab")
        	$('.nav-tabs > .active').next('li').find('a').trigger('click');
    	})
    	$("#ant_seteos").click(function(){
    		 $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    	})
    	$("#pas_reconocimiento").click(function(){
    		var plan=$('#inp_plan_financia').val();
    		if(plan != ""){
    			$('.nav li.active').next('li').removeClass('disabled');
	        	$('.nav li.active').next('li').find('a').attr("data-toggle","tab")
	        	$('.nav-tabs > .active').next('li').find('a').trigger('click');
    		}else{
				swal("Atención", "Favor de Seleccionar un Plan de Financiamiento dando click en un elemento de la tabla", "error");
    		}
    		
    	})
    	$("#ant_evaluacion").click(function(){
    		 $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    	})
    	$("#pas_calculo").click(function(){
    		var tam = 0;
    		for(i=1; i<$("#recono_table tr").length; i++){
            	tam++
	         }
    		
    		if(tam == 1){
    			var dni;
	    		$('#recono_table  tr').eq(1).each(function () {
	                var fila = {};
	                $(this).find('td').each(function (index) {
	                                 
		                switch (index){
		                    case 0: break;
		                    case 1: break;
		                    case 2: break;
		                    case 3: dni = $(this).text(); break;
		                    case 4: break;
		                    case 5: break;
		                    case 6: break;
		                }
	              	});      
	            });

	            if(dni.length == 8){
	            	$('.nav li.active').next('li').removeClass('disabled');
		        	$('.nav li.active').next('li').find('a').attr("data-toggle","tab")
		        	$('.nav-tabs > .active').next('li').find('a').trigger('click');
	            	
	            }else{
	            	swal('Alerta','Favor de Ingresar el DNI del Titular','error' );		
	            }
    		}else{
    			var dni;
	    		$('#recono_table  tr').eq(2).each(function () {
	                var fila = {};
	                $(this).find('td').each(function (index) {
	                                 
		                switch (index){
		                    case 0: break;
		                    case 1: break;
		                    case 2: break;
		                    case 3: dni = $(this).text(); break;
		                    case 4: break;
		                    case 5: break;
		                    case 6: break;
		                }
	              	});      
	            });
				var dni_titular;
	    		$('#recono_table  tr').eq(1).each(function () {
	                var fila = {};
	                $(this).find('td').each(function (index) {
	                                 
		                switch (index){
		                    case 0: break;
		                    case 1: break;
		                    case 2: break;
		                    case 3: dni_titular = $(this).text(); break;
		                    case 4: break;
		                    case 5: break;
		                    case 6: break;
		                }
	              	});      
	            });
				if(dni.length == 8){
					$('.nav li.active').next('li').removeClass('disabled');
		        	$('.nav li.active').next('li').find('a').attr("data-toggle","tab")
		        	$('.nav-tabs > .active').next('li').find('a').trigger('click');
				}else{
					swal('Alerta','Falta ingresar el DNI del Representante o Titular','error' );
				}
	            
    		}
    			
    	})
    	$("#ant_financiamiento").click(function(){
    		 $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    	})
    	$("#pas_NotDebito").click(function(){
    		$('.nav li.active').next('li').removeClass('disabled');
        	$('.nav li.active').next('li').find('a').attr("data-toggle","tab")
        	$('.nav-tabs > .active').next('li').find('a').trigger('click');
    	})
    	$("#ant_AcReconocimiento").click(function(){
    		 $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    	})
    	$("#pas_recibo").click(function(){
    		$('.nav li.active').next('li').removeClass('disabled');
        	$('.nav li.active').next('li').find('a').attr("data-toggle","tab")
        	$('.nav-tabs > .active').next('li').find('a').trigger('click');
    	})
    	$("#ant_NotaD").click(function(){
    		 $('.nav-tabs > .active').prev('li').find('a').trigger('click');
		})
		/* Fin de los Botones anterior y siguiente  en los tab */
		$('#collapseExample').on('shown.bs.collapse', function () {
			
			$('#ocult_most').text('OCULTAR DATOS');
			//console.log("mostrando");
		});
		$('#collapseExample').on('hidden.bs.collapse', function () {
			//console.log("cerrando");
			$('#ocult_most').text('MOSTRAR DATOS');
		});
		/* ---------- Evento de click para buscar suministro -----------  */
    	$("#Buscar_suministro").click(function(){
    		var Num_suministro = $("#suministro").val();
			Num_suministro = Num_suministro.trim();
    		if (Num_suministro !="") {
    			if (Num_suministro.length ==11 || Num_suministro.length ==7) {
					var i=0;
					var bandera = 0;
					while( i< Num_suministro.length ){
						if(Num_suministro.charCodeAt(i)< 48 ||   Num_suministro.charCodeAt(i)> 57 ){
							bandera = 1;
						}
						i++;
					}
					
					if(bandera == 0){
						buscar_suministro(Num_suministro);
					}else{
						swal("Atención", "Ingreso Codigo de suministro Incorrecto", "error");
					}
    				
    			}else{
    				swal("Atención", "Ingreso Codigo de suministro Incorrecto", "error");
    			}
    		}else{
				swal("Atención", "Ingreso Codigo de suministro Incorrecto", "error");
			}
		});
		/* Fin del evento  buscar suministro  */

		/* ------ Evento para limpiar la pantalla --------  */
    	$("#Limpiar_suministro").click(function(){
    		swal({
	                title: "FINANCIAMIENTO",
	                text: "¿Desea limpiar los campos ?",
	                type: "warning",
	                showCancelButton: true,
	                closeOnConfirm: true,
	                confirmButtonColor: "#296fb7",
	                confirmButtonText: "Aceptar",
	                showConfirmButton : true,
	                allowOutsideClick: false,
	                allowEscapeKey: false,
	                }, function(valor){
						if(valor){
							window.location.replace('<?php echo $this->config->item('ip')."financiamiento/calculo"?>');
						}
	                    
	                });
		});
		/* fin del evento de limpiar la pantalla  */
		
		/* ------ Botones para crear los reportes ------ */
    	$("#cal_acta").click(function(){
    		documento_acta();
    	});
    	$("#cal_recibo_caja").click(function(){
    		documento_caja();
    	});
    	$("#cal_cronograma").click(function(){
    		documento_cronograma();
    	});
		$("#cal_proforma").click(function(){
    		proforma_cronograma();
    	});
    	$("#cal_det_recibo").click(function(){
    		documento_recibos();
		});
		/* Fin de los botones  para crear reporte */
    	$("#Grabar_datos").click(function(){
    		cargo_dato_cliente();
    	});

    	/* ------ Convenios Por Deuda ( deudas anteriores  ) ------  */
    	$("#tab_evaluacion").on('click','tr',function(){
		      
		   var oficod, ageCod,CredNro;
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 0: oficod = $(this).text();
                            break;
                    case 1: ageCod = $(this).text();
                            break;
                    case 2: CredNro = $(this).text();
                            break;
                   
                }
            })
            if (oficod === undefined) {
            	swal('NO SELECIONE LA CABECERA  '  );

            }else{
				if(guardo == 0){
					$(this).addClass('selected').siblings().removeClass('selected');
					swal('SELECCIONO EL CREDITO NUMERO  ' + CredNro);
					Busca_Cuota(oficod,ageCod,CredNro);
				}else{
					swal({
						title: "FINANCIAMIENTO",
						text: "SE GUARDO FINANCIAMIENTO (NO PUEDE SELECCIONAR DESPUES DE GUARDAR )",
						type: "warning",
						showCancelButton: false,
						closeOnConfirm: true,
						confirmButtonColor: "#296fb7",
						confirmButtonText: "Aceptar",
						showConfirmButton : true,
						allowOutsideClick: false,
						allowEscapeKey: false,
						}, function(valor){
							console.log("financiamiento guardado");
							//window.location.replace('<?php echo $this->config->item('ip')."financiamiento/calculo"?>');
						});
				}
            	

            }      
		});
		/* Fin de convenios por Deuda ( deudas anteriores  )  */
		
		/* ----- Evento Tabla para escoger los tipos de planes de financiamiento ------  */
    	$("#tab_plan_financiamiento").on('click','tr',function(){
		      
		   var campo1, TIP_client, plazo_max,por_ini, g_cobranza ,fi_total_deuda ,descri_plan , int_des;
           if (guardo ==0) {
           		$(this).children("td").each(function (index2) 
	            {
	                switch (index2) 
	                {
	                    case 0: campo1 = $(this).text();
	                            break;
	                    case 1: TIP_client = $(this).text();
	                            break;
	                    case 5: plazo_max = $(this).text();
	                            break;
	                    case 6: por_ini = $(this).text();
	                            break;
	                    case 7: int_des = $(this).text();
	                            break;
	                    case 8: g_cobranza = $(this).text();
	                            break;
	                    case 9: descri_plan = $(this).text();
	                            break; 
	                }
	            })

	            if (campo1 === undefined) {
	            	swal('NO SELECIONE LA CABECERA');

	            }else{
	            	tip_financiamiento = campo1;
	            	$(this).addClass('selected').siblings().removeClass('selected');
	            	
	            	//formula de gasto de cobranza pero con plan de financiamiento
	            	var gast_cobr =parseFloat($('#cal_gasto_cobranza').val()) - ((parseFloat(g_cobranza)* parseFloat($('#cal_gasto_cobranza').val()))/100) ;
	            	//fin formula 
	            	//formula interes descuento
	            	var des_interes = (1 - parseFloat(int_des)/100)* parseFloat($('#cal_int_moratorio').val());
	            	//fin interes descuento
	            	if (bandera_interes == 0){
	            		fi_total_deuda = parseFloat($('#fi_deuda_total').val()) + parseFloat(gast_cobr.toFixed(2)) + parseFloat(des_interes.toFixed(2));
	            	}else{
	            		var int_actual = $('#fi_int_moratorio').val();
	            		fi_total_deuda = parseFloat($('#fi_deuda_total').val()) - parseFloat(int_actual);
	            		fi_total_deuda = parseFloat(fi_total_deuda.toFixed(2)) + parseFloat(gast_cobr.toFixed(2)) + parseFloat(des_interes.toFixed(2)) ;

	            	}
	            	$('#fi_deuda_total').val(fi_total_deuda.toFixed(2));
	            	$('#cal_base_tot_pagar').val(fi_total_deuda.toFixed(2));
	            	var inicial = (parseFloat($('#fi_deuda_total').val()) * por_ini)/100;
	            	console.log("Inicial -> " + inicial );
	            	var saldo = parseFloat($('#fi_deuda_total').val()) - parseFloat(inicial.toFixed(2)) ;
		            $('#inp_plan_financia').val(TIP_client);
		            $('#inp_cuota_financia').val(plazo_max);
		            $('#inp_porcentaje_financia').val(por_ini);
		            $('#fi_int_moratorio').val(des_interes.toFixed(2));
		            $('#fi_gasto_cobranza').val(gast_cobr.toFixed(2));
					$('#nota_deb_subtotal').val(des_interes.toFixed(2));
					$('#nota_deb_igv').val(0.00);
					$('#nota_deb_total').val(des_interes.toFixed(2));
		            $('#Cal_nro_cuota').val(plazo_max);
		            $('#cal_base_nro_cuota').val(plazo_max);
		            $('#Cal_inicial').val(inicial.toFixed(2));
		            $('#Cal_saldo').val(saldo.toFixed(2));
		            $('#cal_base_saldo').val(saldo.toFixed(2));
		            $('#cal_descri_plan').val(descri_plan);
		            nuevo_inicial = $('#Cal_inicial').val();
		            nuevo_num_letras = $('#Cal_nro_cuota').val();
		            //**************
		            // calculando el FRC  formula
		            //**************
		            var i= parseFloat($('#cal_tasa_interes').val());
		            var n= parseFloat(plazo_max);
		            var resultado_frc = (i * Math.pow((1+ i),n))/(Math.pow((1+i),n)-1);

		            $('#cal_frc').val(resultado_frc.toFixed(7));
		            bandera_interes = 1;
		            simular_financiamiento();
		            swal("Atención",'FILA SELECCIONADA NUMERO ' + campo1 ,"success");
		          
	            }
           }else{
				swal({
						title: "FINANCIAMIENTO",
						text: "SE GUARDO FINANCIAMIENTO (NO PUEDE SELECCIONAR DESPUES DE GUARDAR )",
						type: "warningp",
						showCancelButton: false,
						closeOnConfirm: true,
						confirmButtonColor: "#296fb7",
						confirmButtonText: "Aceptar",
						showConfirmButton : true,
						allowOutsideClick: false,
						allowEscapeKey: false,
						}, function(valor){
							console.log("financiamiento guardado");
							//window.location.replace('<?php echo $this->config->item('ip')."financiamiento/calculo"?>');
					});
           }   
		});
		/* Fin de Tabla para escoger los tipos de planes de financiamiento */

		/* -------- Modal para agregar al representante ---------  */
    	$('#slideThree').on('change', function() {
	        if ($(this).is(':checked') ) {
				if (guardo ==0){
					$("#REPRESENTANTE").modal();
				}else{
					swal({
						title: "FINANCIAMIENTO",
						text: "SE GUARDO FINANCIAMIENTO (NO PUEDE SELECCIONAR DESPUES DE GUARDAR )",
						type: "warning",
						showCancelButton: false,
						closeOnConfirm: true,
						confirmButtonColor: "#296fb7",
						confirmButtonText: "Aceptar",
						showConfirmButton : true,
						allowOutsideClick: false,
						allowEscapeKey: false,
						}, function(valor){
							console.log("financiamiento guardado");
							//window.location.replace('<?php echo $this->config->item('ip')."financiamiento/calculo"?>');
					});
				}
	            
	        } else {
	        	
	        	swal({
				  title: "Quitar Representante",
				  text: "¿Esta seguro que quiere quitar al representante?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonColor: "#296fb7",
				  confirmButtonText: "Si, Estoy seguro!",
				  closeButtonText: "Cancelar",
				  closeOnConfirm: false
				},
				function(isConfirm){
					if (isConfirm) {
						$('#Repre_doc').attr('readonly',false);
			            $('#Repre_doc').val("");
			            $('#Repre_nom').val("");
			            $('#Repre_correo').val("");
			            $('#Repre_dire').val("");
			            $('#Repre_tel').val("");
			            $("#representante-es").fileinput('clear');
			            usr = null;
					    var nFilas = $("#recono_table tr").length;
		        		$("#recono_table tr:eq("+(nFilas-1)+")").remove();
					    swal.close();
					} else {
						$("#slideThree").prop('checked', true);
					    swal.close();
					}
				});
	        }
	    });
	    /* Fin de  Modal para agregar al representante  */

		/* ------- Evento de teclado para buscar  DNI de representante ------  */
	   $('#Repre_doc').keyup(function (e) {
		    if (e.keyCode === 13) {
		       buscar_persona($('#Repre_doc').val());
		    }
		});
		/* Fin de Evento de teclado para buscar  DNI de representante  */

		/* ---------- Evento de teclado para editar datos de titular --------- */
	   $('#MODEDITITU-DNI-NUEVO').keyup(function (e) {
		    if (e.keyCode === 13) {
		       var dni  =  $('#MODEDITITU-DNI-NUEVO').val();
		       if((dni == '') || ( dni != '' && dni.length != 8 )){
		            if (dni == '') {
		              //alert("DNI VACIO");
		              $('#MODEDITITU_mensaje').text('EL CAMPO DE DNI SE ENCUENTRA VACIO');
		              setTimeout(Mostra_mensaje, 200);
		              return false;
		            }else{
		              if(dni.length != 8){
		                //alert("DNI INCORRECTO");
		                $('#MODEDITITU_mensaje').text('TAMAÑO INCORRECTO DE DNI');
		                console.log(dni.length);
		                setTimeout(Mostra_mensaje, 200);
		                return false;
		              }
		            }
		        }else{
		        	buscar_titular($('#MODEDITITU-DNI-NUEVO').val());
		        }  
		    }
		});
		/* Fin de Evento de teclado para editar datos de titular */

		/* ----- Modal para editar el titular ------ */
	    $("#Form-Edit").on("click", function(){
            if(usr != null){

                cambiar_tipo_modregper('editar');
                $("#MODREGPER-TIPDOC").attr('codigo', $('#Tip_documento_ident').val());
                $("#MODREGPER-TIPDOC").val($('#Tip_documento_ident option:selected').text());
                $("#MODREGPER-DNI").val($('#Repre_doc').val());
                $('#MODREGPER').modal("show");
                
            }else{
                swal("Atención", "No tiene a ningun usuario para editar", "error");
            }
		});
		/* Fin de  Modal para editar el titular  */
		
		/* ------ caja para poner las observaciones del titular -------- */
	    $('#search').multiselect({
		    search: {
		        left: '<input type="text" name="q" class="form-control dato-estatico" placeholder="Buscar Observación" />',
		        right: '<input type="text" name="q" class="form-control dato-estatico" placeholder="Buscar Observación" />',
		    },
		    fireSearch: function(value) {
		        return value.length > 3;
		    }
		});
		/* caja para poner las observaciones del titular */

	    $("#cal_recalcular").on("click", function(){
            $("#MOD_RECALCULAR").modal();
            $('#Mod_inicial').val($('#Cal_inicial').val());
            $('#Mod_num_cuotas').val($('#Cal_nro_cuota').val());
        });
        

		/*$("#ver_plan_fin").click(function() {
			var pdf = new jsPDF();
			var graf_PDF = Graficar_Pdf(pdf);
	        var blob = graf_PDF.output("blob");
		    window.open(URL.createObjectURL(blob));
    	});*/

    	
	});

	/*function Graficar_Pdf(pdf){
		var fecha = new Date();
		pdf.setFontSize(12);
		pdf.text(10, 10, 'SEDALIB S.A.');
		pdf.setFontSize(12);
		pdf.text(55, 24, 'LISTADO DE PLANDES DE FINANCIAMIENTO');
		pdf.setFontSize(9);
		pdf.text(150, 10, 'Impreso el : ' +' '+ fecha.getDate()+'/'+(fecha.getMonth() + 1)+'/'+ fecha.getFullYear() +' '+ fecha.getHours()+':'+fecha.getMinutes()+':'+fecha.getSeconds());
		pdf.text(150, 15, 'Pag. Nro. : '+ pdf.internal.getNumberOfPages() );
		pdf.text(10, 35, 'Referencia para  Cliente : ' + $("#suministro").val() );
		pdf.text(10, 39, 'Recibos Impago : ');
		pdf.text(47, 39, $("#plan_f_mes").val());
		pdf.text(100, 39, 'Tarifa : ' + $("#plan_f_tarifa").val()+' - '+ $("#plan_f_categoria").val() );
		return pdf;
	}*/

	function documento_cronograma(){
		// TITULAR || REPRESENTANTE 
        var SolRepre = [];
		for(i=1; i<$("#recono_table tr").length; i++){
            
            $('#recono_table  tr').eq(i).each(function () {
                var fila_repre = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila_repre['Codigo']=$(this).text(); break;
                        case 1: fila_repre['Nombre']=$(this).text(); break;
                        case 2: fila_repre['Direccion']=$(this).text(); break;
                        case 3: fila_repre['DNI']=$(this).text(); break;
                        case 4: fila_repre['RUC']=$(this).text();break;
                        case 5: fila_repre['Telefono']=$(this).text();break;
                        case 6: fila_repre['Correo']=$(this).text();break;
                    }
                });
                SolRepre.push(fila_repre);
            });
        }
        //cuerpo de la tabla 
		var tabla = [];
        
         for(i=1; i<$("#Cal_simulador tr").length; i++){
            
            $('#Cal_simulador  tr').eq(i).each(function () {
                var fila = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila['Cuota']=$(this).text(); break;
                        case 1: fila['Saldo']=$(this).text(); break;
                        case 2: fila['Int_comp']=$(this).text(); break;
                        case 3: fila['Amo_cap']=$(this).text(); break;
                        case 4: fila['Imp_cuota']=$(this).text(); break;
                        case 5: fila['Acumulacion']=$(this).text(); break;
                        case 6: fila['Vencimiento']=$(this).text(); break;
                        
                    }
                });
                tabla.push(fila);
            });
        }
		var json = JSON.stringify(new Array(  $('#sum_recibo').val() , $('#direccion_cliente').val() , SolRepre[0]['Nombre'], $('#fi_deuda_total').val(), $('#Cal_inicial').val(), $('#Cal_nro_cuota').val(),  $('#Cal_Oficina').val() , $('#Cal_agencia').val(), tabla , $('#Cal_saldo').val(), $('#Cal_vencimiento').val(), $('#cal_tasa_interes').val() , nro_credit,1,$('#nombre_cliente').val()));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporte/cronograma'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_cronograma',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
	}

	function proforma_cronograma(){
		// TITULAR || REPRESENTANTE 
        var SolRepre = [];
		for(i=1; i<$("#recono_table tr").length; i++){
            
            $('#recono_table  tr').eq(i).each(function () {
                var fila_repre = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila_repre['Codigo']=$(this).text(); break;
                        case 1: fila_repre['Nombre']=$(this).text(); break;
                        case 2: fila_repre['Direccion']=$(this).text(); break;
                        case 3: fila_repre['DNI']=$(this).text(); break;
                        case 4: fila_repre['RUC']=$(this).text();break;
                        case 5: fila_repre['Telefono']=$(this).text();break;
                        case 6: fila_repre['Correo']=$(this).text();break;
                    }
                });
                SolRepre.push(fila_repre);
            });
        }
        //cuerpo de la tabla 
		var tabla = [];
        
         for(i=1; i<$("#Cal_simulador tr").length; i++){
            
            $('#Cal_simulador  tr').eq(i).each(function () {
                var fila = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila['Cuota']=$(this).text(); break;
                        case 1: fila['Saldo']=$(this).text(); break;
                        case 2: fila['Int_comp']=$(this).text(); break;
                        case 3: fila['Amo_cap']=$(this).text(); break;
                        case 4: fila['Imp_cuota']=$(this).text(); break;
                        case 5: fila['Acumulacion']=$(this).text(); break;
                        case 6: fila['Vencimiento']=$(this).text(); break;
                        
                    }
                });
                tabla.push(fila);
            });
         }
		var json = JSON.stringify(new Array(  $('#sum_recibo').val() , $('#direccion_cliente').val() , SolRepre[0]['Nombre'], $('#fi_deuda_total').val(), $('#Cal_inicial').val(), $('#Cal_nro_cuota').val(),  $('#Cal_Oficina').val() , $('#Cal_agencia').val(), tabla , $('#Cal_saldo').val(), $('#Cal_vencimiento').val(), $('#cal_tasa_interes').val(), $('#nombre_cliente').val() ) );
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporte/proforma'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'proforma_cronograma',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
	}

	function documento_recibos(){
		// TITULAR || REPRESENTANTE 
        var SolRepre = [];
		for(i=1; i<$("#recono_table tr").length; i++){
            
            $('#recono_table  tr').eq(i).each(function () {
                var fila_repre = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila_repre['Codigo']=$(this).text(); break;
                        case 1: fila_repre['Nombre']=$(this).text(); break;
                        case 2: fila_repre['Direccion']=$(this).text(); break;
                        case 3: fila_repre['DNI']=$(this).text(); break;
                        case 4: fila_repre['RUC']=$(this).text();break;
                        case 5: fila_repre['Telefono']=$(this).text();break;
                        case 6: fila_repre['Correo']=$(this).text();break;
                    }
                });
                SolRepre.push(fila_repre);
            });
        }

		var tabla = [];
        for(i=1; i<$("#tab_deuda_recibo tr").length; i++){
            
            $('#tab_deuda_recibo  tr').eq(i).each(function () {
                var fila = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila['Serie']=$(this).text(); break;
                        case 1: fila['Numero']=$(this).text(); break;
                        case 2: fila['Emision']=$(this).text(); break;
                        case 3: fila['Vencimiento']=$(this).text(); break;
                        case 5: fila['Sub_total']=$(this).text(); break;
                        case 6: fila['Igv']=$(this).text(); break;
                        case 7: fila['Total']=$(this).text(); break;
                        case 8: fila['Not_cre']=$(this).text(); break;
                        case 9: fila['Not_deb']=$(this).text(); break;
                        case 10: fila['Real']=$(this).text(); break;
                        case 11: fila['Estado']=$(this).text(); break;                
                    }
                });
                //fila['Vencimiento'] = 
                tabla.push(fila);
            });

        }
        var json = JSON.stringify(new Array( $('#sum_recibo').val() , $('#direccion_cliente').val() , SolRepre[0]['Nombre'], tabla , $('#fi_deuda_total').val(), $('#Cal_inicial').val(), $('#Cal_nro_cuota').val(), $('#Cal_vencimiento').val(), $('#Cal_Oficina').val(), $('#Cal_agencia').val(), nro_credit , $('#fi_int_moratorio').val() , $('#fi_gasto_cobranza').val(), $('#nombre_cliente').val() ));
         event.preventDefault();
         var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporte/recibo_reporte'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_recibo',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
	}

	function documento_acta(){
		// TITULAR || REPRESENTANTE 
        var SolRepre = [];
		for(i=1; i<$("#recono_table tr").length; i++){
            
            $('#recono_table  tr').eq(i).each(function () {
                var fila_repre = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila_repre['Codigo']=$(this).text(); break;
                        case 1: fila_repre['Nombre']=$(this).text(); break;
                        case 2: fila_repre['Direccion']=$(this).text(); break;
                        case 3: fila_repre['DNI']=$(this).text(); break;
                        case 4: fila_repre['RUC']=$(this).text();break;
                        case 5: fila_repre['Telefono']=$(this).text();break;
                        case 6: fila_repre['Correo']=$(this).text();break;
                    }
                });
                SolRepre.push(fila_repre);
            });
        }

		var tabla = [];
        
        for(i=1; i<$("#recono_table tr").length; i++){
            
            $('#recono_table  tr').eq(i).each(function () {
                var fila = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila['Codigo']=$(this).text(); break;
                        case 1: fila['Nombre']=$(this).text(); break;
                        case 2: fila['Direccion']=$(this).text(); break;
                        case 3: fila['DNI']=$(this).text(); break;
                        
                    }
                });
                tabla.push(fila);
            });
         }
		var json = JSON.stringify(new Array(  $('#sum_recibo').val() , $('#direccion_cliente').val() , SolRepre[0]['Nombre'] , tabla , $('#fi_deuda_total').val(), $('#Cal_inicial').val(), $('#Cal_nro_cuota').val(), $('#Cal_vencimiento').val() ,$('#Cal_Oficina').val(), $('#Cal_agencia').val(), nro_credit,$('#nombre_cliente').val(),1 ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporte/acta'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_acta',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
	}

	function documento_caja(){
		// TITULAR || REPRESENTANTE 
        var SolRepre = [];
		for(i=1; i<$("#recono_table tr").length; i++){
            
            $('#recono_table  tr').eq(i).each(function () {
                var fila_repre = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila_repre['Codigo']=$(this).text(); break;
                        case 1: fila_repre['Nombre']=$(this).text(); break;
                        case 2: fila_repre['Direccion']=$(this).text(); break;
                        case 3: fila_repre['DNI']=$(this).text(); break;
                        case 4: fila_repre['RUC']=$(this).text();break;
                        case 5: fila_repre['Telefono']=$(this).text();break;
                        case 6: fila_repre['Correo']=$(this).text();break;
                    }
                });
                SolRepre.push(fila_repre);
            });
        }
        
		var json = JSON.stringify(new Array( SolRepre[0]['Nombre'] , $('#direccion_cliente').val(), $('#fi_deuda_total').val(), $('#Cal_inicial').val(), $('#Cal_nro_cuota').val(), $('#Cal_saldo').val(), $('#Cal_Oficina').val() , $('#Cal_agencia').val(), nro_credit , nro_amortiza , $('#sum_recibo').val(), 1, $('#nombre_cliente').val() ));
         event.preventDefault();
         var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporte/caja'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_caja',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
	}

	function grabas_datos_financiamiento(nro_credit){
		console.log(nro_credit);
		var suministro = $('#sum_recibo').val();
		var archi_nro_credito = nro_credit;
		
		$('#titular-es').fileinput("upload");

		$('#titular-es').on('filebatchuploaderror', function(event, data, previewId, index) {
		    var form = data.form, files = data.files, extra = data.extra, 
		    response = data.response, reader = data.reader;
		});
		var resultado ; 
		$('#titular-es').on('filebatchuploadsuccess', function(event, data) { 
		    var respuesta = data.response ;//, reader = data.reader;
		    //resultado = respuesta["estado"];
		    cargo_representante(respuesta);
		});
	}

	function cargo_representante(respuesta){
		ruta_representante = respuesta["ruta"];
		$('#rut_carpeta').val(ruta_representante);
		$('#representante-es').fileinput("upload");	
		$('#representante-es').on('filebatchuploadsuccess', function(event, data){ 
		    var resultado = data.response;//, reader = data.reader;
		});
		
	}

	function cargo_dato_cliente(){
		swal({
                title: "Registrar Financiamiento",
                text: " ¿ Esta seguro que desea registrar el financiamiento ? ",
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#296fb7",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmLoadingButtonColor: true,
            }, function(isConfirm){
                if(isConfirm) {
                    swal.disableButtons();
                    Guardo_datos();                 
                }
            });
		
	}

	function Guardo_datos(){
		var tabla = [];
        
        //TABLA DE SIMULADOR
		var band_negativo = 0;
        for(i=1; i<$("#Cal_simulador tr").length; i++){
            $('#Cal_simulador  tr').eq(i).each(function () {
                var fila = {};
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila['Num_cuota']=$(this).text(); break;
                        case 1: fila['Saldo']=$(this).text(); break;
                        case 2: fila['Int_comp']=$(this).text(); break;
                        case 3: fila['Amort_Cap']=$(this).text(); break;
                        case 4: fila['Imp_Cuota_fin']=$(this).text();break;
                        case 5: fila['Acumulacion']=$(this).text();break;
                        case 6: fila['Vencimiento']=$(this).text();break;
                    }
                });
				if(parseFloat(fila['Saldo'])<0){
					band_negativo=1;
				}
				if(parseFloat(fila['Int_comp'])<0){
					band_negativo=1;
				}
				if(parseFloat(fila['Amort_Cap'])<0){
					band_negativo=1;
				}
				if(parseFloat(fila['Imp_Cuota_fin'])<0){
					band_negativo=1;
				}
                tabla.push(fila);
            });
        }
		if(band_negativo == 1){
			swal({
	                title: "FINANCIAMIENTO",
	                text: "En la simulación hay un dato negativo , favor de comunicarse con INFORMATICA",
	                type: "warning",
	                showCancelButton: false,
	                closeOnConfirm: true,
	                confirmButtonColor: "#296fb7",
	                confirmButtonText: "Aceptar",
	                showConfirmButton : true,
					showCancelButton: true,
	                allowOutsideClick: false,
	                allowEscapeKey: false,
	                }, function(valor){
	                    console.log("dato negativo");
	            });
		}else{
			/*if(credito_1_cuota > 2){
				swal({
	                title: "FINANCIAMIENTO",
	                text: "El cliente tiene más de 2 financiamientos por una cuota en el año ",
	                type: "warning",
	                showCancelButton: false,
	                closeOnConfirm: true,
	                confirmButtonColor: "#296fb7",
	                confirmButtonText: "Aceptar",
	                showConfirmButton : true,
					showCancelButton: true,
	                allowOutsideClick: false,
	                allowEscapeKey: false,
	                }, function(valor){
	                    console.log("mas de 2 creditos por 1 cuota ");
	                });
			}else{*/
				// REPRESENTANTE 
				var SolRepre = [];
				for(i=1; i<$("#recono_table tr").length; i++){
					
					$('#recono_table  tr').eq(i).each(function () {
						var fila = {};
						$(this).find('td').each(function (index) {
							
							switch (index){
								case 0: fila['Codigo']=$(this).text(); break;
								case 1: fila['Nombre']=$(this).text(); break;
								case 2: fila['Direccion']=$(this).text(); break;
								case 3: fila['DNI']=$(this).text(); break;
								case 4: fila['RUC']=$(this).text();break;
								case 5: fila['Telefono']=$(this).text();break;
								case 6: fila['Correo']=$(this).text();break;
							}
						});
						SolRepre.push(fila);
					});
				}

				// RECIBO 
				var Deuda_recibo = [];
				for(i=1; i<$("#tab_deuda_recibo tr").length; i++){
					
					$('#tab_deuda_recibo  tr').eq(i).each(function () {
						var fila = {};
						$(this).find('td').each(function (index) {
							
							switch (index){
								case 0: fila['Serie']=$(this).text(); break;
								case 1: fila['Nro']=$(this).text(); break;
								case 2: fila['Emision']=$(this).text(); break;
								case 3: fila['Vencimiento']=$(this).text(); break;
								case 4: fila['Int_moratorio']=$(this).text(); break;
								case 5: fila['Sub_total']=$(this).text(); break;
								case 6: fila['IGV']=$(this).text();break;
								case 7: fila['Total']=$(this).text();break;
								case 8: fila['Not_cred']=$(this).text();break;
								case 9: fila['Not_deb']=$(this).text();break;
								case 10: fila['Real']=$(this).text();break;
								case 11: fila['Estado']=$(this).text();break;
							}
						});
						Deuda_recibo.push(fila);
					});
				}

				// DEUDA ANTERIOR 
				var Deuda_anterior = [] ;
				for(i=1; i<$("#tab_evaluacion tr").length; i++){
					$('#tab_evaluacion  tr').eq(i).each(function () {
						var fila = {};
						$(this).find('td').each(function (index) {
							
							switch (index){
								case 0: fila['Oficina']=$(this).text(); break;
								case 1: fila['Agencia']=$(this).text(); break;
								case 2: fila['Credito']=$(this).text(); break;
								case 3: fila['Fecha']=$(this).text(); break;
								case 4: fila['Estado']=$(this).text();break;
								case 5: fila['Deuda_total']=$(this).text();break;
								case 6: fila['Inicial']=$(this).text();break;
								case 7: fila['Nro_letra']=$(this).text();break;
								case 8: fila['Concepto']=$(this).text();break;
								case 9: fila['Descri_concep']=$(this).text();break;
								case 10: fila['Fecha_estado']=$(this).text();break;
								case 11: fila['Referencia']=$(this).text();break;
								case 12: fila['Digitador']=$(this).text();break;
							}
						});
						Deuda_anterior.push(fila);
					});
				}

				console.log(Deuda_anterior);
				var Observaciones = "";
				var contador = 1;
				
				$('#search_to').find('option').each(function() {
					if (contador == 0) {
						Observaciones = Observaciones + contador + " "+$(this).text().trim();
					}else{
						Observaciones = Observaciones + "," + contador + " " + $(this).text().trim();
					}
					contador++;
					
				});
				if( parseFloat($('#Cal_saldo').val()) == 0 ){
					$('#Cal_nro_cuota').val(0);
				}
				$.ajax({
						type: "POST",
						url: "<?php echo $this->config->item('ip') ?>financiamiento/guarda_datos_texto?ajax=true",
						data: {	
								oficina: $("#Cal_Oficina").val(), 
								agencia: $("#Cal_agencia").val(),
								suministro: $('#suministro').val(),
								inicial: $('#Cal_inicial').val(),
								nro_cuota: $('#Cal_nro_cuota').val(), 
								saldo: $('#Cal_saldo').val(),
								descri_plan : $('#cal_descri_plan').val(),
								int_moratorio: $('#fi_int_moratorio').val(),
								gasto_cobranza: $('#fi_gasto_cobranza').val(),
								observacion : $('#recono_obs').val(),
								tabla_simulacion : tabla,
								tasa_int : $('#cal_tasa_interes').val(),
								tasa_frc : $('#cal_frc').val(),
								fecha_vencimiento : $('#Cal_vencimiento').val(),
								tabla_SolRepre : SolRepre,
								tabla_recibo : Deuda_recibo,
								Anterior_Deuda : Deuda_anterior,
								Servidor_suministro : Servidor,
								Observacion : Observaciones,
								num_fina : tip_financiamiento,
								gere : gerente,
								//not_cred_deb : nota_credito_debito,
								deuda_financiamiento : $('#Cab_cuota_emitir').val()
							},
						dataType: 'json',
						success: function(data) {
							if(data.result) {
								console.log(data.Nro_credit);

								swal({
									title: "FINANCIAMIENTO",
									text: "El financiamiento fue registrado con exito",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: true,
									confirmButtonColor: "#296fb7",
									confirmButtonText: "Aceptar",
									showConfirmButton : true,
									allowOutsideClick: false,
									allowEscapeKey: false,
								}, function(valor){
									guardo = 1;
									//window.location.replace('<?php echo $this->config->item('ip')."financiamiento/calculo"?>');
									$( "#cal_acta" ).prop( "disabled", false);
									$( "#cal_recibo_caja" ).prop( "disabled", false);
									$( "#cal_cronograma" ).prop( "disabled", false);
									$( "#cal_not_debito" ).prop( "disabled", false);
									$( "#cal_det_recibo" ).prop( "disabled", false);
									$( "#Grabar_datos" ).prop( "disabled", true);
									$( "#cal_proforma" ).prop( "disabled", true);
									$( ".btn_archivo_titular" ).prop( "disabled", true);
									$( ".btn_editar_titular" ).prop( "disabled", true);
									if($(".btn_archivo_representante").length > 0){
										$(".btn_archivo_representante").prop( "disabled", true);
									}
									$( "#cal_recalcular" ).prop( "disabled", true);
									$( "#slideThree" ).prop("disabled", true);
									nro_credit = data.Nro_credit;
									var temporal = nro_credit[0]['MAXIMO'];
									$('#numero_credito').val(temporal);
									nro_amortiza = data.Nro_amortiza;
									console.log(data.Ser_not_debito);
									if(typeof data.Ser_not_debito === 'undefined' ){
										$('#estado_nota_debito').val("-------");
									}else{
										$('#estado_nota_debito').val("NOTA DE DEBITO << "+data.Ser_not_debito+"-"+data.num_not_debito+" >> GENERADA OK ..!!");
									}
									
									grabas_datos_financiamiento(nro_credit);
								});

							}else{
							swal({
									title: "FINANCIAMIENTO",
									text: "No se pudo registrar el finanaciamiento"+ data.mensaje ,
									type: "error",
									showCancelButton: false,
									closeOnConfirm: true,
									confirmButtonColor: "#296fb7",
									confirmButtonText: "Aceptar",
									showConfirmButton : true,
									allowOutsideClick: false,
									allowEscapeKey: false,
								}, function(valor){
									
								});     
							}
						},
						error: function(data){
							swal({
								title: "FINANCIAMIENTO",
								text: "NO SE PUDO GRABAR FINANCIAMIENTO " ,
								type: "error",
								showCancelButton: false,
								closeOnConfirm: true,
								confirmButtonColor: "#296fb7",
								confirmButtonText: "Aceptar",
								showConfirmButton : true,
								allowOutsideClick: false,
								allowEscapeKey: false,
							}, function(valor){
								console.log("error de grabado en servidor");
							});
							
						}

				});	
			//}
			
		}

        
	}
	function simular_financiamiento(){

		var deuda_total = parseFloat($('#Cal_saldo').val()) + parseFloat($('#Cal_inicial').val());
        var inicial = parseFloat($('#Cal_inicial').val());
        var saldo_inicial = parseFloat($('#Cal_saldo').val());
		if(saldo_inicial == 0 ){
			$("#Cal_simulador").find("tr:gt(0)").remove();
			swal({
	                title: "FINANCIAMIENTO",
	                text: "El saldo es 0.00 , Por lo que no se genera ninguna letra ",
	                type: "warning",
	                showCancelButton: false,
	                closeOnConfirm: true,
	                confirmButtonColor: "#296fb7",
	                confirmButtonText: "Aceptar",
	                showConfirmButton : true,
					//showCancelButton: true,
	                allowOutsideClick: false,
	                allowEscapeKey: false,
	                }, function(valor){
	                    //console.log("saldo =0");
	                });
		}else{
			var num_letras = parseFloat($('#Cal_nro_cuota').val()); // numero de letras 
			var tasa_tam  = parseFloat($('#cal_tasa_interes').val());
			var frc =  parseFloat($('#cal_frc').val());
			var cuota_sin_interes = (saldo_inicial / num_letras) ; 
			var cuota_final = (saldo_inicial * frc);
			var deuda_final_con_interes = (cuota_final * num_letras);
			var saldo_interes  = deuda_final_con_interes - saldo_inicial ;
			var interes_inicial = parseFloat (saldo_interes.toFixed(2) ) ; 
			// PARA SALTAR  FECHAS 
			if(moment().day()>24){
				var cuenta_fecha = 2;
			}else{
				var cuenta_fecha = 1;
			}
			$("#Cal_simulador").find("tr:gt(0)").remove();
			var i= 1; 
			var registro = [];
			var suma_simulada = 0 ;
			var suma_interes = 0 ;
			while(i <= num_letras){
				registro[i] =[];
				if(i == 1 ){
					var queda_saldo = saldo_inicial;
					var queda_saldo_interes = saldo_interes;
					if(es_entidad == 1){
						if(entidad_publica[0].EP_EXON_INTCOMP == 1){
							var interes_cuota = 0;   /// ESTOY AGREGANDO
							var amortiza_cuota  = parseFloat(saldo_inicial.toFixed(2))/num_letras;  // ESTOY AGREGANDO
						}else{
							var interes_cuota = queda_saldo * tasa_tam;
							var amortiza_cuota = cuota_final - interes_cuota;
						}
					}else{
						var interes_cuota = queda_saldo * tasa_tam;
						var amortiza_cuota = cuota_final - interes_cuota;
					}
					
					var en_cuotas = amortiza_cuota;
					var en_cuotas_sin_int = interes_cuota;
					var queda_saldo_ambos = queda_saldo - queda_saldo_interes;
					registro[i]['Letra'] = i ;
					registro[i]['Saldo'] = parseFloat(queda_saldo.toFixed(2)); 
					registro[i]['cta_interes'] = parseFloat(interes_cuota.toFixed(2));
					registro[i]['cta_deuda'] =  parseFloat(amortiza_cuota.toFixed(2)); 
					registro[i]['cta_total'] = parseFloat((parseFloat(interes_cuota.toFixed(2)) + parseFloat(amortiza_cuota.toFixed(2))).toFixed(2)); 
					registro[i]['vence'] = moment().add(cuenta_fecha, 'month').format('DD/MM/YYYY'); 
					console.log(registro[i]);
					suma_simulada = suma_simulada + parseFloat(amortiza_cuota.toFixed(2));
					suma_interes = suma_interes + parseFloat(interes_cuota.toFixed(2));
				}else{
					queda_saldo = queda_saldo - amortiza_cuota ;
					queda_saldo_interes = saldo_interes - en_cuotas_sin_int;
					if(es_entidad == 1){
						if(entidad_publica[0].EP_EXON_INTCOMP == 1){
							interes_cuota = 0;      // ESTOY AGREGANDO
							amortiza_cuota  = saldo_inicial/num_letras;   // ESTOY AGREGANDO
						}else{
							interes_cuota =  queda_saldo * tasa_tam;
							amortiza_cuota = cuota_final - interes_cuota;
						}
					}else{
						interes_cuota =  queda_saldo * tasa_tam;
						amortiza_cuota = cuota_final - interes_cuota;
					}
					
					
					en_cuotas = en_cuotas +  amortiza_cuota ; 
					en_cuotas_sin_int = en_cuotas_sin_int + interes_cuota;
					queda_saldo_ambos = queda_saldo + queda_saldo_interes;
					registro[i]['Letra'] = i ;
					registro[i]['Saldo'] = parseFloat(queda_saldo.toFixed(2)); 
					registro[i]['cta_interes'] = parseFloat(interes_cuota.toFixed(2));
					registro[i]['cta_deuda'] = parseFloat(amortiza_cuota.toFixed(2)); 
					registro[i]['cta_total'] = parseFloat((parseFloat(interes_cuota.toFixed(2)) + parseFloat(amortiza_cuota.toFixed(2))).toFixed(2)); 
					registro[i]['vence'] = moment().add(cuenta_fecha, 'month').format('DD/MM/YYYY'); 
							
					suma_simulada = suma_simulada + parseFloat(amortiza_cuota.toFixed(2));
					suma_interes = suma_interes + parseFloat(interes_cuota.toFixed(2));
				}
				cuenta_fecha = cuenta_fecha + 1;
				i++;
			}
			//console.log("el registro es : ");
			//console.log(registro);
			//console.log("LA SUMA SIMULADA ES : ");
			//console.log(suma_simulada.toFixed(2));
			//console.log("EL SALDO INICIAL ES : ");
			//console.log(saldo_inicial.toFixed(2));
			//console.log("EL INTERES  SIMULADA ES : ");
			//console.log(suma_interes.toFixed(2));
			//console.log("EL INTERES  INICIAL  ES : ");
			//console.log(interes_inicial.toFixed(2));
			var ope;
			var ope_interes;
			var diferencia;
			if( parseFloat(suma_simulada.toFixed(2)) >=   parseFloat(saldo_inicial.toFixed(2)) ){
				diferencia = parseFloat(suma_simulada.toFixed(2)) - parseFloat(saldo_inicial.toFixed(2));
				console.log("la diferencia dentro del if ");
				console.log(diferencia);
				ope = true;
			}else{
				diferencia =  parseFloat(saldo_inicial.toFixed(2)) - parseFloat(suma_simulada.toFixed(2));
				ope = false;
			}
			var dif_inte;
			if(parseFloat(suma_interes.toFixed(2))>= parseFloat(interes_inicial.toFixed(2)) ){
				dif_inte = parseFloat(suma_interes.toFixed(2)) - parseFloat(interes_inicial.toFixed(2)) ;
				ope_interes = true ; 
			}else{
				dif_inte = parseFloat(interes_inicial.toFixed(2)) - parseFloat(suma_interes.toFixed(2)) ;
				ope_interes = false ;
			}
			console.log("DIFERENCIA DE SUMA : ");
			console.log(diferencia.toFixed(2));
			console.log(" DIFERENCIA DE INTERES  : ");
			console.log(dif_inte.toFixed(2));
			i = 1;
			var saldo_nuevo = saldo_inicial ;
			var acumulacion;
			var suma_interes = 0 ;
			var suma_amortizacion = 0;
			while ( i <= num_letras ){
				if ( i == 1){
					if(ope){
						registro[i]['cta_deuda'] = registro[i]['cta_deuda'] - parseFloat(diferencia.toFixed(2));
						registro[i]['cta_interes'] = registro[i]['cta_total'] - registro[i]['cta_deuda'];
						if(ope_interes){
							if(es_entidad == 1){
								if(entidad_publica[0].EP_EXON_INTCOMP == 1){
									registro[i]['cta_interes'] = 0;   // ESTOY AGREGANDO 
								}else{
									registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) - parseFloat(dif_inte.toFixed(2));
								}
							}else{
								registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) - parseFloat(dif_inte.toFixed(2));
							} 
							registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda'];
						}else{
							if(es_entidad == 1){
								if(entidad_publica[0].EP_EXON_INTCOMP == 1){
									registro[i]['cta_interes'] = 0;   // ESTOY AGREGANDO 
								}else{
									registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) + parseFloat(dif_inte.toFixed(2));
								}
							}else{
								registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) + parseFloat(dif_inte.toFixed(2));
							} 
							registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda']; 
						}
							
					}else{
						registro[i]['cta_deuda'] = registro[i]['cta_deuda'] + parseFloat(diferencia.toFixed(2));
						registro[i]['cta_interes'] = registro[i]['cta_total'] - registro[i]['cta_deuda'];
						if(ope_interes){
							if(es_entidad == 1){
								if(entidad_publica[0].EP_EXON_INTCOMP == 1){
									registro[i]['cta_interes'] = 0;   // ESTOY AGREGANDO 
								}else{
									registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) - parseFloat(dif_inte.toFixed(2));
								}
							}else{
								registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) - parseFloat(dif_inte.toFixed(2));
							} 
							
							registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda'];
						}else{


							if(es_entidad == 1){
								if(entidad_publica[0].EP_EXON_INTCOMP == 1){
									registro[i]['cta_interes'] = 0;   // ESTOY AGREGANDO 
								}else{
									registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) + parseFloat(dif_inte.toFixed(2));
								}
							}else{
								registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) + parseFloat(dif_inte.toFixed(2));
							} 
							registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda']; 
						}
					}
						
					saldo_nuevo =  saldo_nuevo   - registro[i]['cta_deuda'];  
					acumulacion   = parseFloat(registro[i]['cta_deuda'].toFixed(2));              
				}else{
					registro[i]['Saldo'] = saldo_nuevo ; 
					registro[i]['cta_interes'] = registro[i]['cta_total'] - registro[i]['cta_deuda'];
					saldo_nuevo =  saldo_nuevo   - registro[i]['cta_deuda']; 
					acumulacion   = acumulacion +  parseFloat(registro[i]['cta_deuda'].toFixed(2));
				}
				if(i < num_letras){
					$('#Cal_simulador tr:last').after('<tr><td>'+
							registro[i]['Letra']+'</td><td>'+ 
							registro[i]['Saldo'].toFixed(2) +'</td><td>'+
							registro[i]['cta_interes'].toFixed(2)+'</td><td>'+
							registro[i]['cta_deuda'].toFixed(2)+'</td><td>'+
							registro[i]['cta_total'].toFixed(2)+'</td><td>'+
							acumulacion.toFixed(2)+'</td><td>'+
							registro[i]['vence']+'</td></tr>');
					
					suma_interes = suma_interes + parseFloat(registro[i]['cta_interes'].toFixed(2));
					suma_amortizacion = suma_amortizacion  +  parseFloat(registro[i]['cta_deuda'].toFixed(2));
				}else{
					
					$('#Cal_simulador tr:last').after('<tr><td>'+
							registro[i]['Letra']+'</td><td>'+ 
							registro[i]['Saldo'].toFixed(2) +'</td><td>'+
							registro[i]['cta_interes'].toFixed(2)+'</td><td>'+
							registro[i]['Saldo'].toFixed(2)+'</td><td>'+
							registro[i]['cta_total'].toFixed(2)+'</td><td>'+
							saldo_inicial.toFixed(2)+'</td><td>'+
							registro[i]['vence']+'</td></tr>');
					
					suma_interes = suma_interes + parseFloat(registro[i]['cta_interes'].toFixed(2));
					suma_amortizacion = suma_amortizacion  +  parseFloat(registro[i]['cta_deuda'].toFixed(2));
				}
					
				i++;
			}
			
			$('#cal_base_interes').val(suma_interes.toFixed(2));
			var sum_amorti = parseFloat($('#cal_base_interes').val()) + parseFloat($('#cal_base_saldo').val());
			$('#cal_base_amortiza').val(sum_amorti.toFixed(2));
		}
        
			
	}

	function Busca_Cuota(oficod,ageCod,CredNro){
		swal({
		  title: "FINANCIAMIENTO",
		  text: "Selecciono el credito numero"+CredNro,
		  type: "info",
		  showCancelButton: true,
		  closeOnConfirm: false,
		  showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
                  	type: "POST",
                    url: "<?php echo $this->config->item('ip');?>financiamiento/buscar_cuotas?ajax=true",
                    data: {oficina: oficod, agencia:ageCod, CreditoNro:CredNro  },
                    dataType: 'json',
                    success: function(data) {
                        if(data.result) {
                        	$("#Tab_Est_Cuotas").find("tr:gt(0)").remove();
                            swal.close();
                            var i = 0;
	                        while(i< data.num_cuotas.length){
	                            	
	                            $('#Tab_Est_Cuotas tr:last').after('<tr><td>'+data.num_cuotas[i].OFIC_CREDITO+'</td><td>'+data.num_cuotas[i].AGEN_CREDITO+'</td><td>'+data.num_cuotas[i].NROCREDITO+'</td><td>'+data.num_cuotas[i].LTCUOTA+'</td><td>'+data.num_cuotas[i].LTNUM+'</td><td>'+data.num_cuotas[i].LTVENCIM+'</td><td>'+data.num_cuotas[i].LTSTATUS+'</td><td>'+data.num_cuotas[i].LTSTAFEC+'</td><td>'+data.num_cuotas[i].SERRECIBO+'</td><td>'+data.num_cuotas[i].NRORECIBO+'</td></tr>');
	                            	
	                            i++;
	                        }
	                        console.log(data.num_cuotas);
                        }else{
                            
                        }
                    }
                });
		  
		});
	}

	function subir_Representante(){
		$('#ModalRepresentante').modal("show");
	}

	function Agregar_Representante(){
		$('#recono_table tr:last').after('<tr><td>'+$('#sum_recibo').val()+'</td><td>'+$('#Repre_nom').val()+'</td><td>'+$('#Repre_dire').val()+'</td><td>'+$('#Repre_doc').val()+'</td><td></td><td>'+$('#Repre_tel').val()+'</td><td>'+$('#Repre_correo').val()+'</td><td>'+'<button class="btn btn-primary btn_archivo_representante" onclick="subir_Representante()" data-toggle="tooltip" data-placement="top" title="SUBIR ARCHIVO"><span class="fa fa-upload"></span></button>'+'</td></tr>');
		/*$('#recono_table tr:last').after('<tr><td>'+$('#sum_recibo').val()+'</td><td>'+$('#Repre_nom').val()+'</td><td>'+$('#Repre_dire').val()+'</td><td>'+$('#Repre_doc').val()+'</td><td></td><td>'+$('#Repre_tel').val()+'</td><td>'+$('#Repre_correo').val()+'</td><td>'+'</td></tr>');*/
	}

	function subir_titular(){
		//alert("hola mund0");
		$('#ModalTitular').modal("show");
	}

	function Editar_titular(){

		$('#recono_table  tr').eq(1).each(function () {
            var fila = {};
            $(this).find('td').each(function (index) {
                   
                    switch (index){
                        case 0: break;
                        case 1: $('#MODEDITITU-NOMBRE').val($(this).text()); break;
                        case 2: $('#MODEDITITU-DIRECCION').val($(this).text()); break;
                        case 3: $('#MODEDITITU-DNI').val($(this).text()); break;
                        case 4: $('#MODEDITITU-RUC').val($(this).text());break;
                        case 5: $('#MODEDITITU-TELEFONO').val($(this).text());break;
                        case 6: $('#MODEDITITU-CORREO').val($(this).text());break;
                    }
        	});
        });
		$('#MODEDITITU').modal("show");
	}

	function Data_deuda (deuda,detalle,plan_financiamiento,observaciones,credito_Pendiente,tasa_interes,tipo_financiamiento){
		var i = 0;
	    var fecha = new Date();
	    var deuda_capital = 0;
	    var num_recibo = 0;
	    var int_mora = 0;
	    var gasto_cobranza = 0;
	    var total_calculo = 0 ;
	    var fi_total_calculo = 0;
	    while(i< deuda.length){
	        var nota_credito_estado = (deuda[i].NC < 0) ? 'style="color:#D9534F;"' :'';
	        $('#tab_deuda_recibo tr:last').after('<tr><td>'+deuda[i].FACSERNRO+'</td><td>'+deuda[i].FACNRO+'</td><td>'+deuda[i].FACEMIFEC+'</td><td>' + deuda[i].FACVENFEC + '</td><td>'+parseFloat(deuda[i].INTMORA)+'</td><td>'+parseFloat(deuda[i].FACTOTSUB)+'</td><td>'+parseFloat(deuda[i].FACIGV)+'</td><td>'+parseFloat(deuda[i].FACTOTAL)+'</td><td '+nota_credito_estado+' >'+deuda[i].NC+'</td><td >'+deuda[i].ND+'</td><td>'+parseFloat(deuda[i].IMPREAL)+'</td><td>'+deuda[i].FACESTADO+'</td></tr>');
	        deuda_capital = deuda_capital + parseFloat(deuda[i].IMPREAL);
	        int_mora = int_mora + parseFloat(deuda[i].INTMORA);
	        gasto_cobranza = gasto_cobranza + parseFloat(deuda[i].GASTOCOBRANZA);
	        num_recibo = num_recibo + 1;
	        i++;
		}
	    if (i>0) {
	    	i = i-1 ;
	    	$('#tab_nota_debito tr:last').after('<tr><td>'+deuda[i].FACSERNRO+'</td><td>'+deuda[i].FACNRO+'</td><td>'+deuda[i].FACEMIFEC+'</td><td>' + deuda[i].FACVENFEC + '</td><td>'+parseFloat(deuda[i].FACTOTSUB)+'</td><td>'+parseFloat(deuda[i].FACIGV)+'</td><td>'+parseFloat(deuda[i].FACTOTAL)+'</td><td '+nota_credito_estado+' >'+deuda[i].NC+'</td><td >'+deuda[i].ND+'</td><td>'+parseFloat(deuda[i].IMPREAL)+'</td></tr>');
	    }
	    $('#Cab_deuda_capital').val(deuda_capital.toFixed(2));
	    $('#Cal_deuda_capital').val(deuda_capital.toFixed(2));
	    $('#fi_deuda_capital').val(deuda_capital.toFixed(2));
	    $('#cal_int_moratorio').val(int_mora.toFixed(2));
	    $('#cal_gasto_cobranza').val(gasto_cobranza.toFixed(2));

	    total_calculo = total_calculo + deuda_capital +int_mora + gasto_cobranza ;
		fi_total_calculo = fi_total_calculo + deuda_capital ;
		$("#contador_recibo").text(" (" +num_recibo +")");
	    $('#Cab_mes_deuda').val(num_recibo);
	    if(tipo_financiamiento == 11){
	        $( '#plan_financiamiento_descri' ).css( "background-color", "#5BC0DE" );
	        $('#plan_financiamiento_descri').val("DEUDA DEL PERIODO");
	    }
	    if(tipo_financiamiento == 10){
	        $( '#plan_financiamiento_descri' ).css( "background-color", "#5CB85C" );
	        $('#plan_financiamiento_descri').val("DEUDA NO PROVISIONADA");
	    }
	    if(tipo_financiamiento == 9){
	        $( '#plan_financiamiento_descri' ).css( "background-color", "#D9534F" );
	        $('#plan_financiamiento_descri').val("DEUDA PROVISIONADA");
	    }
	    //Plan de Financiamiento
	    $("#plan_f_mes").val(deuda.length);
	    $("#plan_f_tarifa").val(detalle.TARIFA);
	    $("#plan_f_categoria").val(detalle.CATEGTARIF);
	    //LLenado de tabla 
	    var i = 0;
	    while(i< plan_financiamiento.length){
	       $('#tab_plan_financiamiento tr:last').after('<tr><td>'+plan_financiamiento[i].CORRELA+'</td><td >'+plan_financiamiento[i].TIPOCLIENT+'</td><td >'+plan_financiamiento[i].CARTERA+'</td><td >'+plan_financiamiento[i].MESESDEUDA+'</td><td >'+plan_financiamiento[i].MDHASTA+'</td><td >'+plan_financiamiento[i].PLAZOMAX+'</td><td >'+plan_financiamiento[i].PORINICIAL+'</td><td >'+plan_financiamiento[i].PORINTMOR+'</td><td >'+plan_financiamiento[i].PORINTGST+'</td><td >'+plan_financiamiento[i].DESCRIPLAN+'</td><td >'+plan_financiamiento[i].VENCE+'</td></tr>');
	           //data.deuda[i]
	            i++;
	    }
	    // ACTA DE RECONOCIMIENTO
		var dato_suministro_ver = $('#suministro').val();
		if(dato_suministro_ver.trim() == 11){
			$('#sum_recibo').val(detalle.CLICODFAC);
	    	$('#recono_table tr:last').after('<tr><td>'+detalle.CLICODFAC+'</td><td>'+detalle.NOMBRE+'</td><td>'+detalle.DIRECCION+'</td><td>'+detalle.DNI+'</td><td>'+detalle.RUC+'</td><td>'+''+'</td><td>'+''+'</td><td>'+'<button  class="btn btn-primary btn_editar_titular" onclick="Editar_titular()" data-toggle="tooltip" data-placement="top" title="EDITAR"><span class="fa fa-pencil"></span> </button> <button  class="btn btn-primary btn_archivo_titular" onclick="subir_titular()" data-toggle="tooltip" data-placement="top" title="SUBIR ARCHIVO"><span class="fa fa-upload"></span></button>'+'</td></tr>');
		}else{
			$('#sum_recibo').val(dato_suministro_ver.trim());
	    $('#recono_table tr:last').after('<tr><td>'+dato_suministro_ver.trim()+'</td><td>'+detalle.NOMBRE+'</td><td>'+detalle.DIRECCION+'</td><td>'+detalle.DNI+'</td><td>'+detalle.RUC+'</td><td>'+''+'</td><td>'+''+'</td><td>'+'<button  class="btn btn-primary btn_editar_titular" onclick="Editar_titular()" data-toggle="tooltip" data-placement="top" title="EDITAR"><span class="fa fa-pencil"></span> </button> <button  class="btn btn-primary btn_archivo_titular" onclick="subir_titular()" data-toggle="tooltip" data-placement="top" title="SUBIR ARCHIVO"><span class="fa fa-upload"></span></button>'+'</td></tr>');
		}
	    
	    /*$('#recono_table tr:last').after('<tr><td>'+detalle.CLICODFAC+'</td><td>'+detalle.NOMBRE+'</td><td>'+detalle.DIRECCION+'</td><td>'+detalle.DNI+'</td><td>'+detalle.RUC+'</td><td>'+''+'</td><td>'+''+'</td><td>'+'<button  class="btn btn-primary" onclick="Editar_titular()" data-toggle="tooltip" data-placement="top" title="EDITAR"><span class="fa fa-pencil"></span> </button>'+'</td></tr>');*/
	    // CARGO LAS OBSERVACIONES 
	    i= 0;
	    while(i< observaciones.length){
	        $('#search').append('<option value="'+observaciones[i].VALPAR+'">'+observaciones[i].DESPAR+'</option>');
	        i++;
	    }

	    //SECCION DE EVALUACION
	    var i = 0;
	    var cuota_emitir = 0;
	    while(i< credito_Pendiente.length){
	        cuota_emitir = cuota_emitir + parseFloat(credito_Pendiente[i].TOTCUOTA);
	        $('#tab_evaluacion tr:last').after('<tr><td>'+credito_Pendiente[i].OFIC_CREDITO+'</td><td>'+credito_Pendiente[i].AGEN_CREDITO+'</td><td>'+credito_Pendiente[i].NROCREDITO+'</td><td>'+credito_Pendiente[i].CREDFECHA+'</td><td>'+credito_Pendiente[i].ESTADO+'</td><td>'+credito_Pendiente[i].DEUDATOTAL+'</td><td>'+credito_Pendiente[i].INICIAL+'</td><td>'+credito_Pendiente[i].NROLTS+'</td><td>'+credito_Pendiente[i].CONCEPTO+'</td><td>'+credito_Pendiente[i].FACCONDES+'</td><td>'+credito_Pendiente[i].CREDSTFEC+'</td><td>'+((credito_Pendiente[i].CREDREFE == null) ? "" : credito_Pendiente[i].CREDREFE ) +'</td><td>'+credito_Pendiente[i].DIGCOD+'</td></tr>');
	        i++;
	    }
	    $('#Cab_cuota_emitir').val(cuota_emitir.toFixed(2));
	    $('#Cal_cuota_emitir').val(cuota_emitir.toFixed(2));
	    $('#fi_cuota_emitir').val(cuota_emitir.toFixed(2));
	    total_calculo = total_calculo + cuota_emitir;
	    fi_total_calculo = fi_total_calculo + cuota_emitir ;
	    $('#Cal_deuda_total').val(total_calculo.toFixed(2));
	    $('#fi_deuda_total').val(fi_total_calculo.toFixed(2));
	    $('#cal_cargos_varios').val(0);
	    $('#fi_cargos_varios').val(0);
	    //tasas  de intereses 
	    var tasa = parseFloat(tasa_interes[0].TAMTASA)/100;
	    $('#cal_tasa_interes').val(tasa.toFixed(7));
	    //CALCULO
	    $('#Cal_fecha').val(moment().format('DD/MM/YYYY'));
	    if(moment().day()>24){
	       $('#Cal_vencimiento').val( moment().add(2, 'month').format('DD/MM/YYYY'));
	    }else{
	        $('#Cal_vencimiento').val( moment().add(1, 'month').format('DD/MM/YYYY'));
	    }

	    //NOTA DE DEBITO 
	    $('#nota_d_fecha').val(moment().format('DD/MM/YYYY'));
		// VERIFICANDO DEUDAS
		var tot_deuda = parseFloat(cuota_emitir.toFixed(2)) + parseFloat(deuda_capital.toFixed(2));
		if(tot_deuda == 0){
			swal({
	                title: "FINANCIAMIENTO",
	                text: "EL SUMINISTRO NO CUENTA CON DEUDAS PENDIENTE ",
	                type: "warning",
	                showCancelButton: false,
	                closeOnConfirm: true,
	                confirmButtonColor: "#296fb7",
	                confirmButtonText: "Aceptar",
	                showConfirmButton : true,
	                allowOutsideClick: false,
	                allowEscapeKey: false,
	                }, function(valor){
	                    $('#pas_financiamiento').prop('disabled', true);
	                });	
		}else{
			$('#pas_financiamiento').prop('disabled', false);
			swal.close();
		}
	    //FUNCION PARA SUBIR ARCHIVOS 
	    cargar_libreria_subida_archivos();
	}

	function cargar_libreria_subida_archivos() {
		console.log(nro_credit);
		var suministro = $('#sum_recibo').val();
		var archi_nro_credito = nro_credit;	
		$('#titular-es').fileinput({
            language: 'es',
            showUpload: false,
            uploadAsync: false,
            uploadUrl: '<?php echo $this->config->item('ip') ?>financiamiento/guarda_datos_titular',
            maxFileCount: 3,
            showRemove: false,
            allowedFileExtensions: ['jpg', 'png', 'pdf'],
            uploadExtraData: function (previewId, index) {
	            var info = {
	            			"num_suministro": $('#sum_recibo').val(),
	            			"num_credito": $('#numero_credito').val()
	        			   };
	            return info;
	        }
            /*uploadExtraData: {
            	num_suministro: suministro,
                nro_credito: archi_nro_credito
            }*/
            //layoutTemplates: {footer: ''}
        });
        $('#representante-es').fileinput({
            language: 'es',
            showUpload: false,
            uploadAsync: false,
            uploadUrl: '<?php echo $this->config->item('ip') ?>financiamiento/guarda_datos_representante',
            maxFileCount: 3,
            showRemove: false,
            allowedFileExtensions: ['jpg', 'png', 'pdf'],
           uploadExtraData: function (previewId, index) {
	            var info = {
	            			"num_suministro": $('#sum_recibo').val(),
	            			"rut_carpeta": $('#rut_carpeta').val(),
							"num_credito": $('#numero_credito').val()
	        			   };
	            return info;
	        }
            //layoutTemplates: {footer: ''}
        });
	}
	
	function buscar_suministro(suministro){
		swal({
		  title: "FINANCIAMIENTO",
		  text: "¿Esta seguro de realizar financiamiento al suministro?",
		  type: "info",
		  showCancelButton: true,
		  closeOnConfirm: false,
		  showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
                  	type: "POST",
                    url: "<?php echo $this->config->item('ip');?>financiamiento/buscar_suministro?ajax=true",
                    data: {codigo_suministro: suministro,
						   rec_pendiente: recibo_pendiente, 
						   reclamo_vigente: recibo_reclamo_vigente, 
						   cuot_pendiente: cuotas_pendientes
					},
                    dataType: 'json',
                    success: function(data) {
                        if(data.result) {
                        	if(data.tam==7){
                        		//swal.close();
	                            console.log(data.detalle);
	                            console.log(data.deuda);
	                            console.log(data.plan_financiamiento);
	                            console.log(data.credito_Pendiente);
								console.log(data.credit_1_cuota);
								$("#suministro").prop( "disabled", true );
	                            if (data.tasa_interes.length > 0 ) {
	                            	$("#nombre_cliente").val(data.nombre[0].CLINOMBRE);
		                            $("#direccion_cliente").val(data.detalle.DIRECCION);
		                            $("#localidad_cliente").val(data.detalle.LOCALIDAD);
		                            $("#estado_cliente").val(data.detalle.ESTADOCLI);
		                            $("#conexionAgua_cliente").val(data.detalle.ESTADOCONXAG);
		                            $("#conexionDes_cliente").val(data.detalle.CONDESDES);
		                            $("#tipo_Servicio").val(data.detalle.TIPOSERVICIO);
		                            $("#Ciclo_cliente").val(data.detalle.CICLO);
		                            $("#tarifa_cliente").val(data.detalle.TARIFA);
		                            $("#tipInmueble_cliente").val(data.detalle.TIPOINMUEBLE);
		                            $("#usoInmueble_cliente").val(data.detalle.USOINMUEB);
		                            $("#abasAgua_cliente").val(data.detalle.ABASTECAGUA);
		                            $("#abasDesa_cliente").val(data.detalle.ABASTECDSG);
		                            $("#grupo_cliente").val(data.detalle.GRUPO);
		                            $("#Subgrupo_cliente").val(data.detalle.SUBGRUPO);
		                            $("#suministro").val(suministro);
		                            //añadiendo datos a recibos
		                            Servidor = data.detalle.ZONASECSRV;
									$( "#Buscar_suministro" ).prop( "disabled", true );
									$("#convenio").prop("disabled", true);
									$("#reclamo").prop("disabled", true);
									$("#pendiente").prop("disabled", true);
									gerente = data.gerente;
									es_entidad = data.es_entidad;
									entidad_publica = data.entidad_publica;
									if(es_entidad == 1){
										console.log("pinto");
										$("#entidad_publica").text(" "+entidad_publica[0].NOMBRE);
									}
									
									if(data.credit_1_cuota.length>0){
										credito_1_cuota = parseInt(data.credit_1_cuota[0]['NUMEROS']);
									}
		                           	Data_deuda (data.deuda,data.detalle,data.plan_financiamiento,data.observaciones,data.credito_Pendiente,data.tasa_interes, data.tipo_financiamiento);
							    }else{
	                            	swal("Atención!", "Tasa TAM falta actualizar", "error");
	                            	$( "#Buscar_suministro" ).prop( "disabled", false );
	                            }
	                            
	                            
                        	}
                        	if(data.tam==11){
                        		//swal.close();
                        		console.log(data.detalle);
                        		console.log(data.deuda);
                        		console.log(data.plan_financiamiento);
                        		console.log(data.observaciones);
                        		console.log(data.credito_Pendiente);
                        		console.log(data.tasa_interes);
								console.log(data.credit_1_cuota);
								$("#suministro").prop( "disabled", true );
                        		if (data.tasa_interes.length > 0) {
                        			$("#nombre_cliente").val(data.detalle[0].NOMBRE);
		                            $("#direccion_cliente").val(data.detalle[0].DIRECCION);
		                            $("#localidad_cliente").val(data.detalle[0].LOCALIDAD);
		                            $("#estado_cliente").val(data.detalle[0].ESTADOCLI);
		                            $("#conexionAgua_cliente").val(data.detalle[0].ESTADOCONXAG);
		                            $("#conexionDes_cliente").val(data.detalle[0].CONDESDES);
		                            $("#tipo_Servicio").val(data.detalle[0].TIPOSERVICIO);
		                            $("#Ciclo_cliente").val(data.detalle[0].CICLO);
		                            $("#tarifa_cliente").val(data.detalle[0].TARIFA);
		                            $("#tipInmueble_cliente").val(data.detalle[0].TIPOINMUEBLE);
		                            $("#usoInmueble_cliente").val(data.detalle[0].USOINMUEB);
		                            $("#abasAgua_cliente").val(data.detalle[0].ABASTECAGUA);
		                            $("#abasDesa_cliente").val(data.detalle[0].ABASTECDSG);
		                            $("#grupo_cliente").val(data.detalle[0].GRUPO);
		                            $("#Subgrupo_cliente").val(data.detalle[0].SUBGRUPO);
		                            $("#suministro").val(suministro);
		                            Servidor = data.detalle[0].ZONASECSRV;
									$("#convenio").prop("disabled", true);
									$("#reclamo").prop("disabled", true);
									$("#pendiente").prop("disabled", true);
									$("#Buscar_suministro").prop( "disabled", true);
									gerente = data.gerente;
									es_entidad = data.es_entidad;
									entidad_publica = data.entidad_publica;
									if(es_entidad == 1){
										console.log("pinto");
										$("#entidad_publica").text(" "+entidad_publica[0].NOMBRE);
									}
									
									if(data.credit_1_cuota.length>0){
										credito_1_cuota = parseInt(data.credit_1_cuota[0]['NUMEROS']);
									}
		                           	Data_deuda (data.deuda,data.detalle[0],data.plan_financiamiento,data.observaciones,data.credito_Pendiente,data.tasa_interes,data.tipo_financiamiento);
								}else{
	                            	swal("Atención!", "Tasa TAM falta actualizar", "error");
	                            	$( "#Buscar_suministro" ).prop( "disabled", false );
	                            }
	                            
	                            
                        	}
                            
                        }else{
							if (typeof data.recibos_deuda != "undefined"){
								swal({
									title: "FINANCIAMIENTO",
									text: data.mensaje,
									type: "error",
									showCancelButton: false,
									closeOnConfirm: true,
									confirmButtonColor: "#296fb7",
									confirmButtonText: "Aceptar",
									showConfirmButton : true,
									showCancelButton: false,
									allowOutsideClick: false,
									allowEscapeKey: false,
									}, function(valor){
										$('#sum_deuda').modal('show');
										var suma_capital = 0;
										table_deuda_suministros.clear().draw();
										for(var i=0; i<data.recibos_deuda.length;i++){
											table_deuda_suministros.row.add( [ 
												i+1,
												data.recibos_deuda[i]['CLICODFAX'],
												data.nombre_usuario[0]['CLINOMBRE'],
												data.recibos_deuda[i]['FACEMIFEC'],
												data.recibos_deuda[i]['FACVENFEC'],
												data.recibos_deuda[i]['FACSERNRO'],
												data.recibos_deuda[i]['FACNRO'],
												data.recibos_deuda[i]['IMPREAL'],
												data.recibos_deuda[i]['FACESTADO']
											] ).draw(false);

											suma_capital = suma_capital + parseFloat(data.recibos_deuda[i]['IMPREAL']);
										}
										$('#Suministro_deuda_capital').val(suma_capital);
									
								});
							}else{
								swal("Atención", data.mensaje, "error");
                            	$( "#Buscar_suministro" ).prop( "disabled", false);
							}	
                        }
                    }
                });
		});
	}
</script>