<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/datepicker3.css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<style>
	.modal {
	overflow-y:auto;
	}
	.nav-tabs
	{
	border-color:#1A3E5E;
	}

	.nav-tabs > li a { 
		border: 1px solid #1A3E5E;
		background-color:#2F71AB; 
		color:#fff;
		}

	.nav-tabs > li.active > a,
	.nav-tabs > li.active > a:focus,
	.nav-tabs > li.active > a:hover{
		background-color:#fff;
		color:#000;
		border: 1px solid #1A3E5E;
		border-bottom-color: transparent;
		}

	.nav-tabs > li > a:hover{
	background-color: #fff !important;
		border-radius: 5px;
		color:#000;

	} 

	.tab-pane {
		border:solid 1px #1A3E5E;
		border-top: 0; 
		background-color:#fff;
		padding:5px;

	}
	.daterangepicker{z-index:1151 !important;}
</style>

<section class="content">
    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">Registrar Reclamo</h3>
                </div>
                <div class="box-body">
                    <div class="row">
						<div class="col-md-12" style="margin-top:15px;">
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<label for="nombre_trab">USUARIO</label>
									<input type="text" class="form-control dato-estatico" id="nombre_trab" value='<?php echo $userdata['NNOMBRE']; ?>'  readonly="readonly">
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									
									<label for="empresa_trab">EMPRESA</label>
									<input type="text" class="form-control dato-estatico" id="empresa_trab" value='<?php echo $empresa['EMPCOD'].'-'.$empresa['EMPDES']; ?>'  readonly="readonly">
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<label for="oficina_trab">OFICINA</label>
									<input type="text" class="form-control dato-estatico" id="oficina_trab" value ="<?php  echo $_SESSION['oficina']; ?>"  readonly="readonly">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<label for="area_trab">ÁREA</label>
									<input type="text" class="form-control dato-estatico" id="area_trab" value ="<?php  echo $_SESSION['area']; ?>" readonly="readonly">
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="form-group">
									<label for="serie_trab">SERIE</label>
									<input type="text" class="form-control dato-estatico" id="serie_trab" value ="<?php echo $ultimo_reclamo['SERNRO']; ?>"  readonly="readonly">
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="form-group">
									<label for="ult_nro_emitido">ULTIMO NRO EMITIDO</label>
									<input type="text" class="form-control dato-estatico" id="ult_nro_emitido" value = "<?php echo $ultimo_reclamo['ULTNRORECLAMO'];?>"  readonly="readonly">
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="form-group">
									<label for="numero_reclamo">NÚMERO RECLAMO</label>
									<input type="text" class="form-control dato-estatico" id="numero_reclamo" value = "<?php echo ((int)$ultimo_reclamo['ULTNRORECLAMO']+1);?>"  readonly="readonly">
								</div>
							</div>
						</div>
						<div class ='col-md-12'>
							<div class ='row'>
								<div class ='col-md-12'>
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="tab" href="#registrar_reclamo">REGISTRAR RECLAMOS </a></li>
										<li><a data-toggle="tab" href="#lista_reclamo">LISTA DE RECLAMOS</a></li>
									</ul>
									<div class="tab-content">
										<div id="registrar_reclamo" class="tab-pane fade in active">
											<div class='row'>
												<div class ='col-md-12'>
													<div class ='col-md-12' style="margin-top:12px;">
														<h3 class='text-center'>
															<strong>
																REGISTRAR RECLAMO
															</strong>
														</h3>
													</div>
													<div class ='col-md-12' style="margin-top:12px;" >
														<div class="panel panel-danger"> 
															<div class="panel-heading">
																BUSCAR SOLICITUD DE RECLAMO 
															</div>
															<div class="panel-body">
																<div class="col-md-12">
																	
																	<div class="col-md-8 col-sm-8 col-xs-8">
																		<div class="form-group">
																			<label for="text_busqueda"> INGRESE SUMINISTRO</label>
																			<input type="text" class="form-control style-input" id="text_busqueda">
																		</div>
																	</div>
																	<div class="col-md-2 col-sm-2 col-xs-2">
																		<div class="form-group">
																			<label for="email">Operación</label>
																			<button class="btn btn-primary form-control dato-estatico" id="Buscar_suministro">
																				BUSCAR
																			</button>
																		</div>
																	</div>
																	<div class="col-md-2 col-sm-2 col-xs-2">
																		<div class="form-group">
																			<label for="email"></label>
																			<button class="btn btn-primary form-control dato-estatico" id="Limpiar_suministro">
																				LIMPIAR
																			</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class ='col-md-12' style="margin-top:12px;">
														<div class="panel panel-primary"> 
															<div class="panel-heading">
																DATOS DE RECLAMO
															</div>
															<div class="panel-body">
																<div class="col-md-12" style="margin-top:10px;">
																	<div class="col-md-4 col-sm-4 col-xs-4">
																		<div class="form-group">
																			<label for="nombre_cliente">CLIENTE</label>
																			<input type="text" class="form-control dato-estatico" id="nombre_cliente"readonly="readonly">
																		</div>
																	</div>
																	<div class="col-md-4 col-sm-4 col-xs-4">
																		<div class="form-group">
																			<label for="dire_cliente">DIRECIÓN</label>
																			<input type="text" class="form-control dato-estatico" id="dire_cliente"readonly="readonly">
																		</div>
																	</div>
																	<div class="col-md-2 col-sm-2 col-xs-2">
																		<div class="form-group">
																			<label for="medidor_cliente">MEDIDOR</label>
																			<input type="text" class="form-control dato-estatico" id="medidor_cliente"readonly="readonly">
																		</div>
																	</div>
																	<div class="col-md-1 col-sm-1 col-xs-1">
																		<div class="form-group">
																			<label for="tarifa_cliente">TARIFA</label>
																			<input type="text" class="form-control dato-estatico" id="tarifa_cliente"readonly="readonly">
																		</div>
																	</div>
																	<div class="col-md-1 col-sm-1 col-xs-1">
																		<div class="form-group">
																			<label for="ciclo_cliente">CICLO</label>
																			<input type="text" class="form-control dato-estatico" id="ciclo_cliente"readonly="readonly">
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<h4 style ='color:#337ab7;'>
																		<strong>
																			TIPO DE PROBLEMA
																		</strong>
																	</h4>
																</div>
																<div class ='col-md-12'>
																	<div class="col-md-4 col-sm-4 col-xs-4">
																		<div class="form-group">
																			<label for="categoria_cliente">CATEGORIA</label>
																			<input type="text" class="form-control dato-estatico" id="categoria_cliente"  readonly="readonly">
																		</div>
																	</div>
																	<div class="col-md-4 col-sm-4 col-xs-4">
																		<div class="form-group">
																			<label for="sub_cate_cliente">SUB-CATEGORIA</label>
																			<input type="text" class="form-control dato-estatico" id="sub_cate_cliente"  readonly="readonly">
																		</div>
																	</div>
																	<div class="col-md-4 col-sm-4 col-xs-4">
																		<div class="form-group">
																			<label for="tip_problema_cliente">TIPO PROBLEMA</label>
																			<input type="text" class="form-control dato-estatico" id="tip_problema_cliente" readonly="readonly">
																		</div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12">
																		<div class="form-group">
																			<label for="problema_cliente">PROBLEMA</label>
																			<input type="text" class="form-control dato-estatico" id="problema_cliente" readonly="readonly">
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<h4 style ='color:#337ab7;'>
																		<strong>
																			FUNDAMENTO DE RECLAMO
																		</strong>
																	</h4>
																</div>
																<div class ='col-md-12'>
																	<div class='col-md-5'>
																		<div class="form-group">
																			<label for="fecha_reclamo">FECHA DE RECLAMO</label>
																			<input type="text" class="form-control dato-estatico" id="fecha_reclamo"  readonly="readonly">
																		</div>
																		<div class="form-group">
																			<label for="plazo_reclamo">PLAZO MAX. DE ATENCIÓN RECLAMO (DIAS) </label>
																			<input type="text" class="form-control dato-estatico" id="plazo_reclamo"  readonly="readonly">
																		</div>
																		<div class="form-group">
																			<label for="fecha_max_atencion">FECHA MAX. DE ATENCIÓN </label>
																			<input type="text" class="form-control dato-estatico" id="fecha_max_atencion" readonly="readonly">
																		</div>
																		<div class="form-group">
																			<label for="estado_reclamo">ESTADO DE RECLAMO </label>
																			<input type="text" class="form-control dato-estatico" id="estado_reclamo"   readonly="readonly">
																		</div>
																		<div class="form-group">
																			<label for="usuario_atiende_reclamo">USUARIO QUE ATIENDE </label>
																			<input type="text" class="form-control dato-estatico" id="usuario_atiende_reclamo" value ='<?php echo $userdata['NNOMBRE']; ?>' readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-7'>
																			<div class="form-group">
																				<label for="descri_reclamo_cliente">DESCRIPCIÓN DE RECLAMO</label>
																				<textarea class="form-control" rows="5" id="descri_reclamo_cliente"></textarea>
																			</div>
																			<div class="form-group">
																				<label for="fundamento_reclamo_cliente">FUNDAMENTO DE RECLAMO</label>
																				<textarea class="form-control" rows="5" id="fundamento_reclamo_cliente"></textarea>
																			</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="etapa_reclamo">TIPO DE ETAPA RECLAMO</label>
																			<input type="text" class="form-control dato-estatico" id="etapa_reclamo"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="fecha_etapa_reclamo">FECHA DE CAMBIO DE ETAPA</label>
																			<input type="text" class="form-control dato-estatico" id="fecha_etapa_reclamo"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="instancia_reclamo">TIPO DE INSTANCIA</label>
																			<input type="text" class="form-control dato-estatico" id="instancia_reclamo"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="fecha_instancia_reclamo">FECHA DE CAMBIO DE INSTANCIA</label>
																			<input type="text" class="form-control dato-estatico" id="fecha_instancia_reclamo"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-4'>
																		<div class="form-group">
																			<label for="situacion_reclamo">SITUACIÓN RECLAMO</label>
																			<input type="text" class="form-control dato-estatico" id="situacion_reclamo"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-4'>
																		<div class="form-group">
																			<label for="fecha_cierre_reclamo">FECHA DE CIERRE RECLAMO</label>
																			<input type="text" class="form-control dato-estatico" id="fecha_cierre_reclamo"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-4'>
																		<div class="form-group">
																			<label for="motivo_cierre_reclamo">MOTIVO DE CIERRE</label>
																			<input type="text" class="form-control dato-estatico" id="motivo_cierre_reclamo"  readonly="readonly">
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<h4 class='text-left' style ='color:#337ab7;'>
																		<strong>
																			DATOS DE RECLAMANTE
																		</strong>
																	</h4>
																</div>
																<div class ='col-md-12'>
																	<div class='form-group control-group col-md-3 col-sm-12'>
																		<div class="form-group">
																			<label for="correo_reclamante">TIPO DOCUMENTO</label>
																			<select class="form-control" id="tipo_doc_reclamante">
																				<?php foreach ($tipo_documento as &$valor) { ?>
																					<option value="<?php echo  $valor['TDICOD']; ?>"><?php echo  $valor['TDIDES']; ?></option>
																				<?php
																					}
																				?>
																			</select>
															
																		</div>
																	</div>
																	<div class="form-group control-group col-md-3 col-sm-12">
																		<label for="documento" >
																			<span id ='texto_documento_reclamante'> DOCUMENTO(DNI): </span>  
																			<a  id="Form-Edit" data-toggle="tooltip"  title data-original-title="Editar datos del usuario"><i class="fa fa-pencil"></i></a>
																			<a  id="Form-Reset" data-toggle="tooltip" title data-original-title="Remover usuario de formulario"><i class="fa fa-times"></i></a>
																		</label>
																		<div class="controls input-group">
																			<div class="input-group-addon">
																				<i class="fa fa-user" aria-hidden="true"></i>
																			</div>
																			<input class="form-control" id="Form-Id" data-codigo="" type="text" maxlength="15" readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="correo_reclamante">CORREO</label>
																			<input type="text" class="form-control dato-estatico" id="correo_reclamante"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="telefono_reclamante">TELEFONO</label>
																			<input type="text" class="form-control dato-estatico" id="telefono_reclamante"  readonly="readonly">
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<div class='col-md-6'>
																		<div class="form-group">
																			<label for="nombre_reclamante">NOMBRE DE RECLAMANTE</label>
																			<input type="text" class="form-control dato-estatico" id="nombre_reclamante"  readonly="readonly">
																		</div>
																	</div>
																	<div class='col-md-6'>
																		<div class="form-group">
																			<label for="direccion_reclamante">DIRECCIÓN DE RECLAMANTE</label>
																			<input type="text" class="form-control dato-estatico" id="direccion_reclamante"  readonly="readonly">
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="atencion_reclamante">MODALIDAD DE ATENCIÓN</label>
																			<select class="form-control" id="atencion_reclamante">
																				<?php foreach ($moda_atencion as &$valor) { ?>
																					<option value="<?php echo  $valor['MOACOD']; ?>"><?php echo  $valor['MOADES']; ?></option>
																				<?php
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="tipo_representacio_reclamante">REPRESENTACIÓN DE RECLAMANTE</label>
																			<select class="form-control" id="tipo_representacio_reclamante">
																				<?php foreach ($repre_reclamante as &$valor) { ?>
																					<option value="<?php echo  $valor['TREPCOD']; ?>"><?php echo  $valor['TREPDES']; ?></option>
																				<?php
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="doc_representacion">NRO. DOC. DE REPESENTACIÓN</label>
																			<input type="text" class="form-control dato-estatico" id="doc_representacion" >
																		</div>
																	</div>
																	<div class='col-md-3'>
																		<div class="form-group">
																			<label for="vig_doc_representacion">FECHA DE VIG. DOC. DE REPRESENTACIÓN</label>
																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-calendar" aria-hidden="true"></i>
																				</span>
																				<input type="text" class="form-control" id="vig_doc_representacion" readonly>
																			</div>
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="vig_doc_representacion">ENTREGO CARTILLA</label>
																			<div class='controls input-group'>
																				<label class="radio-inline">
																					<input type="radio" name="cartillaRadio" value ='S' checked>SI
																				</label>
																				<label class="radio-inline">
																					<input type="radio" name="cartillaRadio" value ='N'>NO
																				</label>
																			</div>
																			
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="vig_doc_representacion">ACEPTA PRUEBA DE CONTRASTACIÓN</label>
																			<div class='controls input-group'>
																				<label class="radio-inline">
																					<input type="radio" name="contrastaRadio" value ='S' checked>SI
																				</label>
																				<label class="radio-inline">
																					<input type="radio" name="contrastaRadio" value ='N'>NO
																				</label>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="vig_doc_representacion">ENVIAR CORREO</label>
																			<div class='controls input-group'>
																				<label class="radio-inline">
																					<input type="radio" name="enviaCorreoRadio" value ='S' checked>SI
																				</label>
																				<label class="radio-inline">
																					<input type="radio" name="enviaCorreoRadio" value ='N'>NO
																				</label>
																			</div>
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<h4 class='text-left' style ='color:#337ab7;'>
																		<strong>
																			DATOS PARA CONCILIACIÓN
																		</strong>
																	</h4>
																</div>
																<div class ='col-md-12' >
																	<div class='col-md-6'>
																		<div class="form-group">
																			<label for="fecha_conciliacion" >FECHA DE CONCILIACIÓN <span style ='color:red' id='nom_fecha_conciliacion'></span> </label>
																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-calendar" aria-hidden="true"></i>
																				</span>
																				<input type="text" class="form-control" id="fecha_conciliacion" readonly>
																			</div>
																		</div>
																	</div>
																	<div class='col-md-6'>
																		<div class="form-group">
																			<label for="hora_conciliacion">HORA DE INICIO</label>
																			<select class="form-control" id="hora_conciliacion">
																				<?php foreach ($interva_horas as &$valor) { ?>
																					<option value="<?php echo  $valor['PSECOD']; ?>"><?php echo  $valor['PSETXTACT']; ?></option>
																				<?php
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class ='col-md-12'>
																		<div class="form-group">
																			<label for="descri_conciliacion">DESCRIPCIÓN DE CONCILIACIÓN</label>
																			<textarea class="form-control" rows="5" id="descri_conciliacion"></textarea>
																		</div>
																	</div>
																</div>
																<div class ='col-md-12'>
																	<div class ='col-md-4 col-md-offset-4'>
																		<button class='btn btn-primary btn-block' id='guarda_reclamo_envio'>
																			GUARDAR RECLAMO
																		</button>
																	</div>
																	<div class ='col-md-4'>
																		<button class='btn btn-primary btn-block' id='imprimir_reclamo'>
																			IMPRIMIR RECLAMO
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="lista_reclamo" class="tab-pane fade">
											<div class ='row'>
												<div class ='col-md-12'>
													<div class ='col-md-12' style="margin-top:12px;">
														<h3 class='text-center'>
															<strong>
																LISTA DE  RECLAMOS
															</strong>
														</h3>
													</div>
												</div>
												<div class ='col-md-12'>
													<div class="form-group control-group col-md-6 col-sm-12">
														<label>FECHA INICIO</label>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" aria-hidden="true"></i>
															</span>
															<input type="text" class="form-control" id="NSUM-INI" readonly>
														</div>
													</div>
													<div class="form-group control-group col-md-6 col-sm-12">
														<label>FECHA FIN</label>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" aria-hidden="true"></i>
															</span>
															<input type="text" class="form-control" id="NSUM-FIN" readonly>
														</div>
													</div>
												</div>
												<div class ='col-md-12'>
													<div class ='col-md-12'>
														<table class=' table display' id='tbl_lista_reclamo'>
															<thead>
																<th>Serie</th>
																<th>Nro Reclamo</th>
																<th>Suministro</th>
																<th>Descripción</th>
																<th>Fecha Registro</th>
																<th>Ape. Paterno</th>
																<th>Ape. Materno</th>
																<th>Nombre</th>
																<th>Cate. Problema</th>	
																<th>Tipo Instancia</th>	
																<th>Estado Reclamo</th>	
															</thead>
															<tbody>
															</tbody>
														</table>
													</div>
													<div class ='row'>
														<div class ='col-md-3'>
															<button class ='btn btn-primary btn-block' id="list_recla_derivar" style ='margin:15px;' disabled>
																Derivar
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
</section>

<!--  MODAL PARA REGISTRAR A LA PERSONA-->
<div class="modal fade" id="MODREGPER" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content panel-primary">
                <div class="modal-header panel-heading">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title" id="MODREGPER-TITULO">REGISTRAR PERSONA</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                            <div class="col-md-12" id="MODREGPER-MSJ" style="display:hidden"></div>
							<div class="col-md-12" id="MODREGPER-MSJ-ERROR" style="display:hidden"></div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>DOC. IDENTIDAD: <a target="_blank" href="<?php echo $rutabsq1; ?>"><i class="fa fa-eye"></i></a></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-TIPDOC" type="text" codigo="-1" tipo="-1" longitud="-1" disabled/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>DOCUMENTO: </label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
									<select class="form-control" id="MODREGPER-DNI">
										<?php foreach ($tipo_documento as &$valor) { ?>
											<option value="<?php echo  $valor['TDICOD']; ?>"><?php echo  $valor['TDIDES']; ?></option>
										<?php
											}
										?>
									</select>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO PATERNO*:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-AP" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO MATERNO*:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-AM" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-5 col-sm-12">
                                <label>NOMBRE*:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-NM" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>EMAIL*:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-EMAIL" type="email"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-3 col-sm-12">
                                <label>CELULAR*:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-CELULAR" type="text" maxlength="9" />
                                </div>  
                            </div>
							<div class="form-group control-group col-md-12 col-sm-12">
                                <label>RAZÓN SOCIAL*:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-RZSOCIAL" type="text" />
                                </div>  
                            </div>
							<div class="form-group control-group col-md-4 col-sm-12">
                                <label>OPERADOR TELEFONICO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
									<select class="form-control" id="MODREGPER_OPERADOR_TELEFONICO">
										<?php foreach ($operador_telefonico as &$valor) { ?>
											<option value="<?php echo  $valor['TOTELCOD']; ?>"><?php echo  $valor['TOTELDES']; ?></option>
										<?php
											}
										?>
									</select>
                                </div>  
                            </div>
							<div class="form-group control-group col-md-4 col-sm-12">
                                <label>TIPO DE PERSONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
									<select class="form-control" id="MODREGPER_TIPO_PERSONA">
										<?php foreach ($tipo_persona as &$valor) { ?>
											<option value="<?php echo  $valor['TPERSCOD']; ?>"><?php echo  $valor['TPERSDES']; ?></option>
										<?php
											}
										?>
									</select>
                                </div>  
                            </div>
							<div class="form-group control-group col-md-4 col-sm-12">
                                <label> ESTADO PERSONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
									<select class="form-control" id="MODREGPER_ESTADO_PERSONA">
										<?php foreach ($estado_persona as &$valor) { ?>
											<option value="<?php echo  $valor['SSOLPCOD']; ?>"><?php echo  $valor['SSOLPDES']; ?></option>
										<?php
											}
										?>
									</select>
                                    
                                </div>  
                            </div>
							<div class="form-group control-group col-md-12 col-sm-12">
                                <label style ='color:#337ab7;'>
									DIRECCIÓN DE RECLAMANTE*:
									<a  id="MODREGPER_BUSCAR_DIRECCIÓN" data-toggle="tooltip"  title data-original-title="BUSCAR DIRECCIÓN"><i class="fa fa-pencil"></i></a>
									<a  data-toggle="collapse" href="#ocult_dire_reclamante" role="button" aria-expanded="true"  id='ocult_dire_recla'>
										<i class="fa fa-reply-all"></i> 
									</a>
								</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-DIRECCI0N" type="text" readonly="readonly"  style='text-transform:uppercase;'/>
                                </div>  
                            </div>
							<div class="collapse in"  id="ocult_dire_reclamante">
								<div class="form-group control-group col-md-6 col-sm-12">
									<label style ='color:#337ab7;'>
										GRUPO POBLACIONAL:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER-GRUPO_POBLA" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-6 col-sm-12">
									<label style ='color:#337ab7;'>
										VIA:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER-VIA" type="text" readonly="readonly"  style='text-transform:uppercase;'/>
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#337ab7;'>
										DISTRITO:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER-DISTRITO" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#337ab7;'>
										PROVINCIA:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER-PROVINCIA" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#337ab7;'>
										DEPARTAMENTO:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER-DEPARTAMENTO" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#337ab7;'>NUMERO MUNICIPAL:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control" id="MODREGPER-NRO" type="text" style='text-transform:uppercase;'/>
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#337ab7;'>MANZANA:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control" id="MODREGPER-MNZ" type="text" style='text-transform:uppercase;'/>
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#337ab7;'>LOTE:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control" id="MODREGPER-LT" type="text" style='text-transform:uppercase;'/>
									</div>  
								</div>
							</div>
							
                            <div class="form-group control-group col-md-12 col-sm-12">
                                <label style ='color:#D1E71C;'>
									DOMICILIO PROCESAL:
									<a  id="MODREGPER_BUSCAR_DIRE_PROCESAL" data-toggle="tooltip"  title data-original-title="BUSCAR DIRECCIÓN PROCESAL"><i class="fa fa-pencil"></i></a>
									<a  data-toggle="collapse" href="#ocult_dire_proce" role="button" aria-expanded="true"  id='ocult_dire_procesal'>
										<i class="fa fa-reply-all"></i> 
									</a>
								</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER_DIRECCI0N_PROCESAL" type="text" readonly="readonly"  style='text-transform:uppercase;'/>
                                </div>  
                            </div>
							<div class="collapse in"  id="ocult_dire_proce">
								<div class="form-group control-group col-md-6 col-sm-12">
									<label style ='color:#D1E71C;'>
										GRUPO POBLACIONAL:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER-GRUPO_POBLA_PROCESAL" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-6 col-sm-12">
									<label style ='color:#D1E71C;'>
										VIA:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER_VIA_PROCESAL" type="text" readonly="readonly"  style='text-transform:uppercase;'/>
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#D1E71C;'>
										DISTRITO:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER_DISTRITO_PROCESAL" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#D1E71C;'>
										PROVINCIA:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER_PROVINCIA_PROCESAL" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#D1E71C;'>
										DEPARTAMENTO:
									</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control sin_espacio" id="MODREGPER_DEPARTAMENTO_PROCESAL" type="text" readonly="readonly" style='text-transform:uppercase;' />
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#D1E71C;'>NUMERO MUNICIPAL:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control" id="MODREGPER_NRO_PROCESAL" type="text" style='text-transform:uppercase;'/>
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#D1E71C;'>MANZANA:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control" id="MODREGPER_MNZ_PROCESAL" type="text" style='text-transform:uppercase;'/>
									</div>  
								</div>
								<div class="form-group control-group col-md-4 col-sm-12">
									<label style ='color:#D1E71C;'>LOTE:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-file-text"></i>
										</div>
										<input class="form-control" id="MODREGPER_LT_PROCESAL" type="text" style='text-transform:uppercase;'/>
									</div>  
								</div>
							</div>
							
                        
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="MODREGPER-OK"> Registrar</button>
                    <button type="button" class="btn btn-danger" id="MODREGPER-CANCEL" >Cancelar</button>
                </div>
            </div>
        </div>
</div>
<!--  FIN MODAL REGISTRAR-->
<!-- modal para buscar la direccion-->

<!--  MODAL PARA REGISTRAR A LA PERSONA-->
<div class="modal fade" id="BUSCAR_GRUPO_POBLA" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content panel-primary">
                <div class="modal-header panel-heading">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title" id="BUSCAR_GRUPO_POBLA-TITULO">VIAS POR GRUPO POBLACIONAL</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
							<div class="col-md-12" id="BUSCAR_GRUPO_POBLA_MSJ_ERROR" style="display:hidden"></div>
							<div class="form-group control-group col-md-4 col-sm-12">
								<label>DESCRI. GRUPO POBLACIONAL: </label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-file-text"></i>
									</div>
									<input class="form-control" id="BUSCAR_POBLA_GRUPO" type="text" style='text-transform:uppercase;'/>
								</div>  
							</div>
							<div class="form-group control-group col-md-4 col-sm-12">
								<label>DESCRI. VIA: </label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-file-text"></i>
									</div>
									<input class="form-control" id="BUSCAR_POBLA_VIA" type="text" style='text-transform:uppercase;'/>
								</div>  
							</div>
							<div class="form-group control-group col-md-4 col-sm-12">
								<button class ='btn btn-primary btn-block' style ='margin-top:20px;'  id='BUSCAR_OPERACION'> BUSCAR </button>
							</div> 
							<div class="col-md-12" id="TABLA_BUSQUEDA" style ='margin-top:15px;'>
								<table class=' table display' id='tbl_busqueda_grupo'>
									<thead>
										<th>Codigo</th>
										<th>Grupo Poblacional</th>
										<th>Via</th>
										<th>Distrito</th>
										<th>Provincia</th>
										<th>Departamento</th>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>    
                    
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="BUSCAR_GRUPO_POBLA-OK">Agregar</button>
                    <button type="button" class="btn btn-danger" id="BUSCAR_GRUPO_POBLA-CANCEL" >Cancelar</button>
                </div>
            </div>
        </div>
</div>
<!-- fin modal buscar la direccion-->

<!-- MODAL PARA MOSTRAR CUANDO HAY MÁS DE UNA SOLICITUD-->
<div class="modal fade" id="MODAL_SOLICITUD" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content panel-primary">
                <div class="modal-header panel-heading">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title" id="MODAL_SOLICITUD_TITULO">SOLICITUDES DE RECLAMO</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
						<div class="col-md-12" id="MODAL_SOLICITUD_MSJ_ERROR" style="display:hidden"></div>
						<div class="col-md-12" id="TABLA_SOLICITUD" style ='margin-top:15px;'>
							<table class=' table display' id='tbl_busqueda_solicitud'>
								<thead>
									<th>DESCRIPCIÓN</th>
									<th>FECHA DE SOLICITUD</th>	
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="MODAL_SOLICITUD_OK">Trabajar</button>
                    <button type="button" class="btn btn-danger" id="MODAL_SOLICITUD_CANCEL" >Cancelar</button>
                </div>
            </div>
        </div>
</div>
<!-- FIN DE MODAL PARA MÁS DE UNA SOLICITUD -->

<!-- MODAL PARA LA DERIVACIÓN-->
<div class="modal fade" id="MODAL_DERIVACION" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content panel-primary">
                <div class="modal-header panel-heading">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title text-center"  id="MODAL_DERIVACION_TITULO">MANTENIMIENTO DERIVACIONES</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
						<div class="col-md-12" id="MODAL_DERIVACION_MSJ_ERROR" style="display:hidden"></div>
							<div  id="TABLA_DERIVACION" style ='margin-top:15px;'>
								<div class="col-md-2 col-sm-8 col-xs-8">
									<div class="form-group">
										<label for="text_busqueda">EMPRESA</label>
										<input type="text" class="form-control style-input" value ='<?php echo $empresa['EMPCOD'].'-'.$empresa['EMPDES']; ?>' id="modal_deriva_empresa" readonly>
									</div>
								</div>	
								<div class="col-md-4 col-sm-8 col-xs-8">
									<div class="form-group">
										<label for="text_busqueda">OFICINA</label>
										<input type="text" class="form-control style-input"  id="modal_deriva_oficina" readonly>
									</div>
								</div>
								<div class="col-md-4 col-sm-8 col-xs-8">
									<div class="form-group">
										<label for="text_busqueda">AREA</label>
										<input type="text" class="form-control style-input"  id="modal_deriva_area" readonly>
									</div>
								</div>
								<div class="col-md-2 col-sm-8 col-xs-8">
									<div class="form-group">
										<label for="text_busqueda">SERIE</label>
										<input type="text" class="form-control style-input"  id="modal_deriva_serie" readonly>
									</div>
								</div>
								<div class="col-md-4 col-sm-8 col-xs-8">
									<div class="form-group">
										<label for="text_busqueda">TIPO</label>
										<input type="text" class="form-control style-input" value='4-DOCUMENTO RECLAMOS' id="modal_deriva_tipo" readonly>
									</div>
								</div>
								<div class="col-md-4 col-sm-8 col-xs-8">
									<div class="form-group">
										<label for="text_busqueda">DOCUMENTO</label>
										<input type="text" class="form-control style-input" value ='5 - RECLAMOS'  id="modal_deriva_documento" readonly>
									</div>
								</div>
								<div class="col-md-4 col-sm-8 col-xs-8">
									<div class="form-group">
										<label for="text_busqueda">NRO. DOCUMENTO</label>
										<input type="text" class="form-control style-input"  id="modal_deriva_nro_documento" readonly>
									</div>
								</div>
								<hr>
								<div class ='col-md-12' id='seccion_tabla_derivacion' style ='margin-top:15px;'>
									<table class=' table display' id='tbl_reclamo_deriva'>
										<thead>
											<th>Codigo</th>
											<th>Fecha de Registro</th>
											<th>Descripción</th>
											<th>Plazo Respuesta</th>
											<th>Estado</th>
											<th>Area Destino</th>
											<th>Oficina Destino</th>
											<th>Empresa</th>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
								<div class ='col-md-12' id='seccion_botones_derivacion' style ='margin-top:15px;' >
									<div class ='col-md-3'>
										<button class='btn btn-primary btn-block' id='btn_deriva_agrega'>
											Agregar
										</button>
									</div>
									<div class ='col-md-3' >
										<button class='btn btn-primary btn-block' id='btn_deriva_editar' disabled>
											Editar
										</button>
									</div>
									<div class ='col-md-3'>
										<button class='btn btn-primary btn-block' id='btn_deriva_anular' disabled>
											Anular
										</button>
									</div>
								</div>

								<div class ='col-md-12' id='seccion_detalle_derivacion' style ='margin-top:15px; display: none;' >
									<div class='row'>
										<div class="form-group control-group col-md-6 col-sm-12">
											<label>FECHA EN QUE SE DERIVA: </label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar-o"></i>
												</div>
												<input class="form-control" id="inp_fch_derivacion" type="text" style='text-transform:uppercase;' readonly/>
											</div>  
										</div>
										<div class="form-group control-group col-md-6 col-sm-12">
											<label for="inp_fch_derivacion_mx" >PLAZO MAX. RESPUESTA: <span style ='color:red' id='lbl_fch_derivacion_mx'></span> </label>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</span>
												<input type="text" class="form-control" id="inp_fch_derivacion_mx" readonly>
											</div> 
										</div>
										<div class="form-group control-group col-md-12 col-sm-12">
											<label>SELECCIONE AREA: </label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-file-text"></i>
												</div>
												<select class="form-control select2" style="width:100%;" id="selec_area_deriva" name="selec_area_deriva" >
													<?php foreach ($Ofi_areas as &$valor) { ?>
														<option value="<?php echo  $valor['ARECOD'].'*'.$valor['OFICOD'].'*'.$valor['EMPCOD']; ?>"><?php echo  $valor['AREDES'].' * '.$valor['OFIDES'].' * '.$valor['EMPDES']; ?></option>
													<?php
														}
													?>
												</select>
												
											</div>  
										</div>
										<div class="form-group control-group col-md-12 col-sm-12">
											<label>AREA DESTINO: </label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-print"></i>
												</div>
												<input class="form-control" id="inp_deriva_area_destino" type="text" style='text-transform:uppercase;' readonly/>
											</div>  
										</div>
										<div class="form-group control-group col-md-6 col-sm-12">
											<label> OFICINA DESTINO: </label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-tty"></i>
												</div>
												<input class="form-control" id="inp_deriva_oficina_destino" type="text" style='text-transform:uppercase;' readonly/>
											</div>  
										</div>
										<div class="form-group control-group col-md-6 col-sm-12">
											<label>EMPRESA DESTINO: </label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-empire"></i>
												</div>
												<input class="form-control" id="inp_deriva_empresa_destino" type="text" style='text-transform:uppercase;' readonly/>
											</div>  
										</div>
										<div class="form-group control-group col-md-12 col-sm-12">
											<label>DESCRIPCIÓN DE SOLICITUD: </label>
											<textarea class="form-control" rows="5" id="txt_area_deriva_descripcion"></textarea> 
										</div>
									</div>
									<div class='row'>
										<div class='col-md-3 col-md-offset-6'>
											<button class ='btn btn-warning btn-block' id='btn_derivacion_atras'> Atrás </button>
										</div>
										<div class ='col-md-3'>
											<button class='btn btn-primary btn-block' id='btn_derivacion_guardar'> Guardar</button>
										</div>
									</div>
								</div>
								
							</div>
                    	</div>     
                	</div>
				
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" id="MODAL_DERIVACION_CANCEL" >Cancelar</button>
					</div>
            	</div>
        	</div>
</div>
<!-- FIN MODAL DERIVACION-->
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/jquery.numeric.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/reclamos/registrar_reclamo.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        registrar_reclamos.init();
    });
</script>