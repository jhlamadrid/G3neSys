<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<section class="content">
    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">CONCILIAR RECLAMO </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class ='col-md-12' style="margin-top:12px;">
							<h3 class='text-center'>
								<strong>
									CONCILIAR  RECLAMO
								</strong>
							</h3>
						</div>
                    </div>

                    <div class ='row'>
                        <div class ='col-md-12'>
                            <div class="panel panel-danger"> 
                                <div class="panel-heading">
                                    BUSCAR RECLAMOS PENDIENTES 
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
                    </div>

                    <div class='row'>
                        <div class ='col-md-12'>
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    RESULTADO DE BUSQUEDA
                                </div>
                                <div class="panel-body">
                                    <!-- datos para cabecera -->
                                    <div class ='row'>
                                        <div class ='col-md-2'>
                                            <div class="form-group">
												<label for="emresa_cliente">Empresa</label>
												<input type="text" class="form-control dato-estatico" id="empresa_cliente"readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-1'>
                                            <div class="form-group">
												<label for="oficina_cliente">Oficina</label>
												<input type="text" class="form-control dato-estatico" id="oficina_cliente"readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-1'>
                                            <div class="form-group">
												<label for="area_cliente">Area</label>
												<input type="text" class="form-control dato-estatico" id="area_cliente"readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-2'>
                                            <div class="form-group">
												<label for="cate_cliente">Categoria</label>
												<input type="text" class="form-control dato-estatico" id="cate_cliente"readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-2'>
                                            <div class="form-group">
												<label for="doc_cliente">Documento</label>
												<input type="text" class="form-control dato-estatico" id="doc_cliente"readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-1'>
                                            <div class="form-group">
												<label for="serie_cliente">Serie</label>
												<input type="text" class="form-control dato-estatico" id="serie_cliente"readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-2'>
                                            <div class="form-group">
												<label for="nroReclamo_cliente">Nro. Reclamo</label>
												<input type="text" class="form-control dato-estatico" id="nroReclamo_cliente" readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-1'>
                                            <div class="form-group">
												<label for="negocia_cliente">Negocia</label>
												<input type="text" class="form-control dato-estatico" id="negocia_cliente" readonly="readonly">
											</div>
                                        </div>
                                    </div>

                                    <div class ='row'>
                                        <div class ='col-md-12'>
                                            <h4 class='text-left' style ='color:#337ab7;'>
                                                <strong>
                                                    DATOS DE LAS FORMULAS PROPUESTAS
                                                </strong>
                                            </h4>
                                        </div>
                                    </div>

                                    <div class='row'>
                                        <div class = "col-md-6">
                                            <div class="form-group">
												<label for="txtAreaTrabajaEps">Formula de negociacion propuesta por la EPS (*)</label>
												<textarea class="form-control" rows="5" id="txtAreaTrabajaEps" readonly="readonly"></textarea>
											</div>
                                        </div>
                                        <div class = "col-md-6">
                                            <div class="form-group">
												<label for="txtAreaTrabajaReclamante">Formula de negociacion propuesta por el reclamante (*)</label>
												<textarea class="form-control" rows="5" id="txtAreaTrabajaReclamante" readonly="readonly"></textarea>
											</div>
                                        </div>
                                    </div>

                                    <div class ='row'>
                                        <div class ='col-md-12'>
                                            <div class="form-group">
												<label for="costo_proceso">Costo del Proceso</label>
												<input type="text" class="form-control dato-estatico" id="costo_proceso" readonly="readonly">
											</div>
                                        </div>
                                    </div>

                                    <div class='row'>
                                        <div class = "col-md-6">
                                            <div class="form-group">
												<label for="puntos_en_acuerdo">Puntos en acuerdo (*)</label>
												<textarea class="form-control" rows="5" id="puntos_en_acuerdo" readonly="readonly"></textarea>
											</div>
                                        </div>
                                        <div class = "col-md-6">
                                            <div class="form-group">
												<label for="puntos_en_desacuerdo">Puntos en desacuerdo (*)</label>
												<textarea class="form-control" rows="5" id="puntos_en_desacuerdo" readonly="readonly"></textarea>
											</div>
                                        </div>
                                    </div>


                                    <div class ='row'>
                                        <div class ='col-md-12'>
                                            <h4 class='text-left' style ='color:#337ab7;'>
                                                <strong>
                                                    DATOS DE LA HORA DE NEGOCIACIÓN
                                                </strong>
                                            </h4>
                                        </div>
                                    </div>

                                    <div class ='row'>
                                        <div class ='col-md-6'>
                                            <div class="form-group">
												<label for="hora_conciliacion">Hora Programada de la negociación</label>
												<input type="text" class="form-control dato-estatico" id="hora_conciliacion" readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-6'>
                                            <div class="form-group">
												<label for="hora_real_concilia">Hora de Inicio Real	</label>
												<input type="text" class="form-control dato-estatico" id="hora_real_concilia" readonly="readonly">
											</div>
                                        </div>
                                    </div>
                                    <div class ='row'>
                                        <div class ='col-md-6'>
                                            <div class="form-group">
												<label for="tipo_de_resultado">Tipo de resultado</label>
												<select class="form-control" id="tipo_de_resultado">
                                                    <?php foreach ($resultado as &$valor) { ?>
														<option value="<?php echo  $valor['TRACUCOD']; ?>"><?php echo  $valor['TRACUDES']; ?></option>
													<?php
														}
													?>
												</select>
											</div>
                                        </div>
                                        <div class ='col-md-6'>
                                            <div class="form-group">
												<label style='color:red; font-size:18px'  for="hora_real_concilia"> (*) SUBSISTE EL RECLAMO </label>
												<div class='controls input-group'>
													<label class="radio-inline">
														<input  type="radio" name="subsisteReclamo" value ='S' checked> <span style='color:red ; font-size:18px;'> <strong> SI SUBSISTE EL RECLAMO </strong> </span> 
													</label>
													<label class="radio-inline">
														<input type="radio" name="subsisteReclamo" value ='N'><span style='color:red ; font-size:18px;'> <strong>NO SUBSISTE EL RECLAMO </strong> </span>
													</label>
												</div>
											</div>
                                        </div>
                                    </div>
                                    <div class ='row'>
                                        <div class ='col-md-12'>
                                            <h4 class='text-left' style ='color:#337ab7;'>
                                                <strong>
                                                    DATOS DEL CONCILIADOR O RECLAMANTE (Editar los datos si no es el reclamante quien se apersonó)
                                                    <a  id="editar_reclamante" data-toggle="tooltip"  title data-original-title="Editar datos del usuario"><i class="fa fa-pencil"></i></a>
                                                    <a  id="cerrar_reclamante" data-toggle="tooltip" title data-original-title="Remover usuario de formulario"><i class="fa fa-times"></i></a>
                                                </strong>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class ='row'>
                                        <div class ='col-md-3'>
                                            <div class="form-group">
												<label for="tip_negocia_cliente"> Tipo de negociador en el cliente </label>
												<select class="form-control" id="tip_negocia_cliente">
                                                    <?php foreach ($repre_reclamante as &$valor) { ?>
														<option value="<?php echo  $valor['TPCOCOD']; ?>"><?php echo  $valor['TPCODES']; ?></option>
													<?php
														}
													?>
												</select>
											</div>
                                        </div>
                                        <div class ='col-md-6'>
                                            <div class="form-group">
												<label for="nombre_reclamante">Nombre del reclamante</label>
												<input type="text" class="form-control dato-estatico" id="nombre_reclamante" readonly="readonly">
											</div>
                                        </div>
                                        <div class ='col-md-3'>
                                            <div class="form-group">
												<label for="DNI_reclamante">DNI del reclamante</label>
												<input type="text" class="form-control dato-estatico" id="DNI_reclamante" readonly="readonly">
											</div>
                                        </div>
                                    </div>

                                    <div class ='row'>
                                        <div class ='col-md-6'>
                                            <div class="form-group">
												<label for="nombre_reclamante">Negociador mediante carta poder</label>
												<div class='controls input-group'>
													<label class="radio-inline">
														<input  type="radio" name="cataPoder_negocia" value ='S' checked> <span style=' font-size:18px;'> <strong> SI </strong> </span> 
													</label>
													<label class="radio-inline">
														<input type="radio" name="cataPoder_negocia" value ='N'><span style=' font-size:18px;'> <strong>NO </strong> </span>
													</label>
												</div>
											</div>
                                        </div>
                                        <div class ='col-md-6'>
                                            <div class="form-group">
												<label for="numero_descripcion_reclamante">Numero o descripción de reclamante</label>
												<input type="text" class="form-control dato-estatico" id="numero_descripcion_reclamante" readonly="readonly">
											</div>
                                        </div>
                                    </div>

                                    <div class ='row'>
                                        <div class ='col-md-12'>
                                            <div class="form-group">
												<label for="observaciones_reclamante">Observaciones del reclamante</label>
												<textarea class="form-control" rows="5" id="observaciones_reclamante" readonly="readonly"></textarea>
											</div>
                                        </div>
                                    </div>

                                    <div class ='row' style='margin-top:20px;'>
                                        <div class ='col-md-3 col-md-offset-6'>
											<button class='btn btn-success btn-block' id='registrar_negocia' disabled>
												REGISTRAR
											</button>
										</div>
                                        <!--
                                        <div class ='col-md-3'>
											<button class='btn btn-primary btn-block' id='registar_y_cerrar_negocia' disabled>
												REGISTRAR Y CERRAR NEGOCIACIÓN 
											</button>
										</div> -->
                                        <div class ='col-md-3'>
											<button class='btn btn-primary btn-block' id='imprimir_negociacion' disabled>
												IMPRIMIR 
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
</section>

<!-- MODAL PARA MOSTRAR CUANDO HAY MÁS DE UNA SOLICITUD-->
<div class="modal fade" id="MODAL_SOLICITUD" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title" id="MODAL_SOLICITUD_TITULO">RECLAMOS PENDIENTES</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
						<div class="col-md-12" id="MODAL_SOLICITUD_MSJ_ERROR" style="display:hidden"></div>
						<div class="col-md-12" id="TABLA_SOLICITUD" style ='margin-top:15px;'>
							<table class=' table display' id='tbl_busqueda_solicitud'>
								<thead>
									<th>DESCRIPCIÓN</th>
									<th>FECHA DE RECLAMO</th>	
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
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/reclamos/conciliar_reclamo.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        conciliar_reclamo.init();
    });
</script>
