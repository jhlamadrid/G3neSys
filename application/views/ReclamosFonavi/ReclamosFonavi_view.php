


<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="panel panel-primary">
        		<div class="panel-heading">
          			<h4 style="font-family:'Ubuntu';font-weight:bold" class="text-white"> <i class="fa fa-universal-access"></i> FORMULARO DE RECLAMOS - FONAVI</h4>
        		</div>
        		<div class="panel-body">
				<!-- Cabecera y Caja de Busqueda -->
					<div class="row">
						<div class="col-md-2" style="margin-top:10px">
							<div class="input-group">
								<span class="input-group-addon">OFICINA</span>
								<input class="form-control" type="text" id='oficina' value="<?php echo  $_SESSION['OFICOD'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-2" style="margin-top:10px">
							<div class="input-group">
								<span class="input-group-addon">AGENCIA</span>
								<input class="form-control" type="text" id='agencia' value="<?php echo  $_SESSION['OFIAGECOD'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-6" style="margin-top:10px">
							<div class="input-group">
								<span class="input-group-addon">RESPONSABLE</span>
								<input class="form-control" type="text" id='nombre' value="<?php echo $_SESSION['user_id']." ".$_SESSION['user_nom'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-2" style="margin-top:10px">
							<div class="input-group">
								<span class="input-group-addon">FECHA RECEPCION</span>
								<input class="form-control" type="text" id='agencia' value="<?php $fechaActual = date('d-m-Y'); echo $fechaActual; ?>" disabled>
							</div>
						</div>
          			</div>
					<div class="row">
						<div class="col-md-12">
							<h4 style="font-family:'Ubuntu'; margin-bottom:0px" class="text-blue"><i class="fa fa-search" aria-hidden="true"></i> BUSCAR RECIBO</h4>
							<small>Ingrese la serie y número del recibo o el suministro</small>
						</div>
					</div>
          			<div class="row">
						<div class="col-md-3 col-sm-3" id="opt_srn_nro">
							<div class="form-group">
								<label for="">Tipo: </label>
								<select class="form-control" name="tipo" id='tipo'  style="border: 1px solid;">
									<option value="0">RECIBO</option>
									<option value="1">SUMINISTRO</option>
									<option value="2">COD PRESTATARIO</option>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-sm-6" id="cuerpo_busqueda">
							<div class="row">
								<div class="col-md-6 col-sm-6" id="opt_srn_nro">
									<div class="form-group">
										<label >Serie: </label>
										<input type="number" class="form-control" onkeypress="return justNumbers(event);" style="border: 1px solid;" id="serie" name="serie" required="">
									</div>
								</div>
								<div class="col-md-6 col-sm-6" id="opt_srn_nro">
									<div class="form-group">
										<label >Número: </label>
										<input type="number" class="form-control" onkeypress="return justNumbers(event);" style="border: 1px solid;" id="numero" name="numero" required="">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-3" style="line-height: 4;">
							<div class="form-group">
								<a class="btn btn-primary btn-sm" style="margin-top:20px;width: 100%;" id="buscar"><i class="fa fa-search" aria-hidden="true" ></i> Buscar</a>
							</div>
						</div>
          			</div>
				<!-- End-->	

				<!-- Pestañas de Opciones -->
					<div class="box-body" id="GeneralForm" style="display:none">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">DATOS GENERALES</a></li>
							<li role="presentation" ><a href="#formulario" aria-controls="formulario" role="tab" data-toggle="tab">FORMULARIO DE REGISTRO</a></li>
						</ul>
      					<div class="tab-content">
        					<div role="tabpanel" class="tab-pane fade in active" id="general"><br>
								<div class="panel panel-success">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<h5 style="font-family:'Ubuntu'; margin-bottom:0px" class="text-success"><i class="fa fa-cubes" aria-hidden="true"></i> DEL PROYECTO</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 col-sm-4" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">NOMBRE <span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='idProNombre' value="" disabled>
												</div>
											</div>
											<div class="col-md-4 col-sm-4" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">CODIGO <span class="text-blue">**</span></span>
													<input type="text" class="form-control" id='idProCodigo' value="" disabled>
												</div>
											</div>
											<div class="col-md-4 col-sm-4" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">CONCESIONARIA <span class="text-blue">**</span></span>
													<input type="text" class="form-control" id='idProConcesionaria' value="" disabled>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">UBICACION <span class="text-blue">**</span></span>
													<input type="text" class="form-control" id='idProUbicacion' value="" disabled>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<h5 style="font-family:'Ubuntu'; margin-bottom:0px" class="text-success"><i class="fa fa-user" aria-hidden="true"></i> DEL PRESTATARIO</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-md-2 col-sm-2" style="margin-top:10px;">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">CODIGO <span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='codPrest' value="" disabled>
												</div>
											</div>
											<div class="col-md-2 col-sm-2" style="margin-top:10px; display: none;">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">DNI <span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='idPrtDni' value="" disabled>
												</div>
											</div>
											<div class="col-md-6 col-sm-6" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">NOMBRE <span class="text-blue">**</span></span>
													<input type="text" class="form-control" id='idPrtNombre' value="" disabled>
												</div>
											</div>
											<div class="col-md-6 col-sm-6" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">DIRECCION <span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='idPrtDireccion' value="" disabled>
												</div>
											</div>
										</div>
									</div>
					  			</div>
							</div>
							
							<div role="tabpanel" class="tab-pane" id="formulario"><br>
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-1 col-sm-1" style="margin-top:3px">
												<a id="Form-Edit" data-toggle="tooltip" data-placement="bottom" title data-original-title="Editar datos del usuario"><i class="fa fa-pencil"></i></a>
												<a id="Form-Reset" data-toggle="tooltip" data-placement="bottom" title data-original-title="Remover usuario de formulario"><i class="fa fa-times"></i></a>
											</div>
										</div>
										<div class="row">
											<div class="col-md-2 col-sm-2" style="display:none;">
												<div class="controls">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-file-text"></i>
														</div>
														<select class="form-control" id="Form-TDIdent" name="tipo-comprobante">
																<option value="1"  longitud="8" tipo="N" >DNI</option>
														</select>
													</div>

												</div>
											</div>
											<div class="col-md-2 col-sm-2" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
												
													<span class="input-group-addon">DNI <span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='Form-Id' >
												</div>
											</div>
											
											<div class="col-md-6 col-sm-6" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">NOMBRE SOLICITANTE<span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='Form-Nom' value="" disabled>
												</div>
											</div>
											<div class="col-md-2 col-sm-2" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">TELEFONO <span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='idSolTelefono' value="" disabled>
												</div>
											</div>
											<div class="col-md-2 col-sm-2" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">EMAIL <span class="text-blue">*</span></span>
													<input type="text" class="form-control" id='idSolEmail' value="" disabled>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">MOTIVO DEL RECLAMO <span class="text-blue">*</span></span>
													<textarea class="form-control" aria-label="With textarea" id="txtSolMotivo"></textarea>
												</div>
											</div>
										</div><br>	
										<div class="row">
											<div class="col-md-12">
												<h5 style="font-family:'Ubuntu'; margin-bottom:0px" class="text-success"><i class="fa fa-book" aria-hidden="true"></i> MEDIOS PROBATORIOS: Adjunto los siguientes documentos de sustento:</h5>
											</div>
										</div>
										<div class="row">
											<div class="form-check col-md-8 col-sm-8" style="margin-top:10px; margin-left: 20px;">
												<input type="checkbox" class="DocMedios form-check-input" value="1">
												<label class="form-check-label" for="exampleCheck1">Copia legible del documento de identidad </label>
											</div>
											<div class="input-group col-md-2 col-sm-2" style="display:none;">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="customFileLang" lang="pl-Pl">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-check col-md-8 col-sm-8" style="margin-top:10px; margin-left: 20px;">
												<input type="checkbox" class="DocMedios form-check-input" value="2">
												<label class="form-check-label" for="exampleCheck1">Copia de la liquidación por conexión domiciliaria objetivo del reclamo</label>
											</div>
											<div class="input-group col-md-2 col-sm-2" style="display:none;">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="customFileLang" lang="pl-Pl">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-check col-md-8 col-sm-8" style="margin-top:10px; margin-left: 20px;">
												<input type="checkbox" class="DocMedios form-check-input" value="3">
												<label class="form-check-label" for="exampleCheck1">Recibos de consumo (copia simple)</label>
											</div>
											<div class="input-group col-md-2 col-sm-2" style="display:none;">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="customFileLang" lang="pl-Pl">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-check col-md-8 col-sm-8" style="margin-top:10px; margin-left: 20px;">
												<input type="checkbox" class="DocMedios form-check-input" value="4">
												<label class="form-check-label" for="exampleCheck1">Constancia de pago otorgada por la concesionaria o quien haga sus veces (original y solo en caso no presenten recibos) </label>
											</div>
											<div class="input-group col-md-2 col-sm-2" style="display:none;">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="customFileLang" lang="pl-Pl">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-check col-md-8 col-sm-8" style="margin-top:10px; margin-left: 20px;">
												<input type="checkbox" class="DocMedios form-check-input" value="5">
												<label class="form-check-label" for="exampleCheck1">Depósitos bancarios y otros ( copia simple de cada recibo), de ser el caso</label>
											</div>
											<div class="input-group col-md-2 col-sm-2" style="display:none;">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="customFileLang" lang="pl-Pl">
												</div>
											</div>
										</div>
									
										<br>

										<div class="row">
											<div class="col-md-12 col-sm-12" style="margin-top:10px">
												<div class="input-group" style="border: 1px solid green;">
													<span class="input-group-addon">OBSERVACIONES <span class="text-blue">*</span></span>
													<textarea class="form-control" aria-label="With textarea" id="txtObserv"></textarea>
												</div>
											</div>
										</div>

									</div>
					  			</div>
								  	
							</div>
						</div>
					</div>	
				<!-- End Pestañas-->

						<div class="row">
							<div class="col-md-12 table-responsive">
								<table id="tblRecibos" class="table table-bordered table-striped" style="display:none">
									<thead>
										<tr role="row">
											<th>OPCION</th>
											<th>COD. FAC.</th>
											<th>SERIE</th>
											<th>NUMERO</th>
											<th>SUMINISTRO</th>
											<th>F. EMISIÓN</th>
											<th>PERIODO</th>
											<th>NOMBRE</th>
											<th>ESTADO</th>
											<th>MONTO</th>
										</tr>
									</thead>
									<tbody id="recibos">
									</tbody>
								</table>
							</div>
						</div><br>
						<div class="row">
							<div class="col-sm-4 col-sm-offset-8">
								<a class="btn btn-success btn-md" style="width:100%" id='save_reclamo' onclick='enviar_reclamo()' >
									<i class="fa fa-paper-plane-o" aria-hidden="true"></i> Realizar Reclamo
								</a>
							</div>
						</div>
				
        			</div>
      			</div>
    	</div>
  	</div>

	  <div class="row" id="pnListReclamos" >
    	<div class="col-md-12">
     		<div class="panel panel-danger">
        		<div class="panel-heading">
          			<h4 style="font-family:'Ubuntu';font-weight:bold" class="text-red"><i class="fa fa-list-ol" aria-hidden="true"></i> LISTA DE RECLAMOS</h4>
        		</div>
        		<div class="panel-body">
          			<div class="row">
            			<div class="col-md-12 table-responsive">
							<table id="tblRecibosReclamados" class="table table-bordered table-striped">
								<thead>
                    				<tr role="row">
										<th>COD.</th>
										<th>FECHA</th>
										<th>HORA</th>
										<th>SUMINISTRO</th>
										<th>PROYECTO</th>
										<th>PRESTATARIO</th>
										<th>SOLICITANTE</th>
										<th>USUARIO</th>
										<th>ESTADO</th>
										<th>[...]</th>
                    				</tr>
                  				</thead>
								<tbody id="reclamados">
								</tbody>
                			</table>
              			</div>
            		</div>
          		</div>
        	</div>
      	</div>
  	</div>



<div class="modal inmodal fade" id="view_ModalDetalle" tabindex="-1" role="dialog" data-keyboard="false"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" style="font-family:'Ubuntu'">DETALLE DE LA SOLICITUD N° <span id="numSol"></span> <span id="nombre_rol1"></span></h4>
      </div>
      <div class="modal-body">


	  		<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="input-group" style="margin-top:5px">
						<div class="input-group-btn">
						<button type="button" class="btn btn-primary" style="width:100px">CODIGO</button>
						</div>
						<input type="text" class="form-control" id="viewCodSol" disabled>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="input-group" style="margin-top:5px">
						<div class="input-group-btn">
						<button type="button" class="btn btn-primary" style="width:100px">FECHA</button>
						</div>
						<input type="text" class="form-control" id="viewFechaReg" disabled>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="input-group" style="margin-top:5px">
						<div class="input-group-btn">
						<button type="button" class="btn btn-primary" style="width:100px">HORA</button>
						</div>
						<input type="text" class="form-control" id="viewHoraReg" disabled>
					</div>
				</div>
            </div> 
			<!-- DEL PROYECTO -->
			<div class="row" style="margin-top:25px; margin-left:10px;">
				<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">PROYECTO</span>
								<input type="text" class="form-control" id='viewProyecto' value="" disabled>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">CONCESIONARIA</span>
								<input type="text" class="form-control" id='viewConces' value="" disabled>
							</div>
						</div>
				</div> 
			</div>


			<div class="row" style="margin-top:25px; margin-left:10px;">
				<div class="row">
						<div class="col-md-3 col-sm-3">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">COD. PREST.</span>
								<input type="text" class="form-control" id='viewCodPrest' value="" disabled>
							</div>
						</div>
						<div class="col-md-7 col-sm-7">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">PRESTATARIO</span>
								<input type="text" class="form-control" id='viewNombPrest' value="" disabled>
							</div>
						</div>
				</div> 
				<div class="row" style="margin-top:2px">
						<div class="col-md-8 col-sm-8">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">DIRECCION</span>
								<input type="text" class="form-control" id='viewDirPrest' value="" disabled>
							</div>
						</div>
				</div> 
			</div>

			<div class="row" style="margin-top:25px; margin-left:10px;">
				<div class="row">
						<div class="col-md-3 col-sm-3">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">DNI</span>
								<input type="text" class="form-control" id='viewSolDni' value="" disabled>
							</div>
						</div>
						<div class="col-md-7 col-sm-7">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">SOLICITANTE</span>
								<input type="text" class="form-control" id='viewSolNombre' value="" disabled>
							</div>
						</div>
				</div> 
				<div class="row" style="margin-top:2px">
						<div class="col-md-4 col-sm-4">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">TELEFONO</span>
								<input type="text" class="form-control" id='viewSolTelef' value="" disabled>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">EMAIL</span>
								<input type="text" class="form-control" id='viewSolEmail' value="" disabled>
							</div>
						</div>
				</div> 
				<div class="row" style="margin-top:2px">
						<div class="col-md-10 col-sm-10">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">MOTIVO</span>
								<textarea class="form-control" aria-label="With textarea" id="viewSolMotivo" disabled></textarea>
							</div>
						</div>
				</div> 
			</div>


			<div class="row" style="margin-top:25px; margin-left:10px;">
				<div class="row">
						<div class="col-md-12">
							<h5 style="font-family:'Ubuntu'; margin-bottom:0px" class="text-success"><i class="fa fa-book" aria-hidden="true"></i> MEDIOS PROBATORIOS: Documentos de sustento:</h5>
						</div>
				</div>
				<div class="row" style="margin-top:2px">
						<div class="col-md-8 col-sm-8" style="margin-left: 15px;" id="viewDocument">
							
						</div>
				</div> 
				<div class="row" style="margin-top:2px">
						<div class="col-md-8 col-sm-8">
							<div class="input-group" style="border: 1px solid #036889;">
								<span class="input-group-addon">OBSERVACIONES</span>
								<textarea class="form-control" aria-label="With textarea" id="viewSolObs" disabled></textarea>
							</div>
						</div>
				</div> 
			</div>
			<br>
			<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tblDetReclamo" class="table table-bordered table-striped" style="display:none">
								<thead>
									<tr role="row">
										<th>COD. FAC.</th>
										<th>RECIBO</th>
										<th>SUMINISTRO</th>
										<th>F. EMISIÓN</th>
										<th>PERIODO</th>
										<th>ESTADO</th>
										<th>MONTO</th>
										<th>LOCALIDAD</th>
										<th>MONTO FONV.</th>
                    				</tr>
                  				</thead>
								<tbody id="viewTblDetalle">
								</tbody>
                			</table>
            			</div>
          		</div><br>


      <div class="modal-footer">
        <div class="row">
          <div class="col-md-2 col-sm-12">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; SALIR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</section>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/Waiting.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>


<script type="text/javascript">
 	$('#autorizaciones').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
  	$("#tipo").change(function(){
    	var valor = $("#tipo").val()
    	if(valor == 1){
			$("#cuerpo_busqueda").empty();
			$("#cuerpo_busqueda").append(`<div class='col-md-12'>
											<div class="form-group">
												<label>Suministro: </label>
												<input type="text" style="border: 1px solid;" onkeypress="buscar_recibos(); return justNumbers(event);" class="form-control" id="suministro" required="">
											</div>
											</div>`);
		} 
		else if(valor == 2){
			$("#cuerpo_busqueda").empty();
			$("#cuerpo_busqueda").append(`<div class='col-md-12'>
											<div class="form-group">
												<label>Cod. Prestatario: </label>
												<input type="text" style="border: 1px solid;" onkeypress="buscar_recibos(); return justNumbers(event);" class="form-control" id="prestatario" required="">
											</div>
											</div>`);
		}else {
        	$("#cuerpo_busqueda").empty();
        	$("#cuerpo_busqueda").append(`<div class="row">
          		<div class="col-md-6 col-sm-6" id="opt_srn_nro">
            		<div class="form-group">
              			<label >Serie: </label>
              			<input type="number" class="form-control" style="border: 1px solid;" onkeypress="return justNumbers(event);" id="serie" required="">
            		</div>
          		</div>
          		<div class="col-md-6 col-sm-6" id="opt_srn_nro">
            		<div class="form-group">
              			<label >Número: </label>
              			<input type="number" class="form-control" style="border: 1px solid;" onkeypress="buscar_recibos(); return justNumbers(event);" id="numero" required="">
            		</div>
          		</div>
        	</div>`);
    	}
  	});

 function buscar_recibos(){
	$("#general").removeClass();  
	$("#formulario").removeClass();  
	$("#general").addClass('tab-pane fade in active');  
	$("#formulario").addClass('tab-pane'); 

	var tipo = $("#tipo").val();
    	if($("#prestatario").val() != "" || $("#suministro").val() != "" || ($("#serie").val() != "" && $("#numero").val() != "")){
			waitingDialog.show('BUSCANDO DOCUMENTO...', {dialogSize: 'lg', progressType: 'warning'});
			$("#tblRecibos").fadeOut();
			$("#tblRecibosReclamados").fadeOut();
			$("#tblDetReclamo").fadeOut();
			$("#GeneralForm").fadeOut();
			$("#pnListReclamos").fadeOut();
			if(tipo == 1){
				data = ({tipo : tipo , suministro : $("#suministro").val()})
			} 
			else if(tipo == 2){
				data = ({tipo : tipo , prestatario : $("#prestatario").val()})
			}
			else {
				data = ({tipo : tipo, serie : $("#serie").val() , numero : $("#numero").val() })
			}
      		$.ajax({
				type: 'POST',
				url : '<?php echo $this->config->item('ip') ?>Reporte_Reclamo/BusquedaRecibo?ajax=true',
				data : data,
				cache : false,
				dataType : 'json',
				success :  function (data) {
          if(data.result){

            waitingDialog.hide();
            $("#tblRecibos").dataTable().fnDestroy();
            $("#tblDetReclamo").dataTable().fnDestroy();
            $("#tblRecibosReclamados").dataTable().fnDestroy();
            $("#recibos").empty();
			$("#recibos").append(data.recibos);
			$("#reclamados").empty();
            $("#reclamados").append(data.reclamados);
            $('#tblRecibos').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
            $('#tblRecibosReclamados').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
            
            $("#tblRecibos").fadeIn(300)
            $("#tblRecibosReclamados").fadeIn(300)
            $("#tblDetReclamo").fadeIn(300)
			$("#pnListReclamos").fadeIn(300)
			$("#GeneralForm").fadeIn(300)
			// alert(JSON.stringify(data.general));
			if(data.general){
				$('.nav>li>a[href="#general"]').parent().addClass('active');
				$('.nav>li>a[href="#formulario"]').parent().removeClass('active');

				$("#codPrest").val(data.general[0]['CODIGO']);
				$("#idProCodigo").val(data.general[0]['CODIGO_PROYECTO']);
				$("#idProNombre").val(data.general[0]['DESCRIPCION']);
				$("#idProUbicacion").val(data.general[0]['DESCRIPCION']);
				$("#idProConcesionaria").val(data.general[0]['CONCESIONARIO']);
				$("#idPrtNombre").val(data.general[0]['NOMBRE']);
				$("#idPrtDireccion").val(data.general[0]['DIRECCION']);

				for(var i=0;i<data.general.	length;i++){
					if(data.general[i]['PREST'] != null && data.general[i]['PREST'] != 0){
						$('.nav li').not('.active').addClass('disabled');
						$('.nav li').not('.active').find('a').removeAttr("data-toggle");
						swal("Atención ¡¡", "No existen recibos a reclamar.", "warning");
						
					}else{
						$('.nav>li>a[href="#general"]').trigger('click');
						$('.nav li').not('.active').removeClass('disabled');
						$('.nav li').not('.active').find('a').attr("data-toggle","tab");
					}

				}
			}
			
          } else {
            $("#vigencia").attr('disabled',true)
            $("#gloasa").attr('disabled',true)
            $("#usuario").attr('disabled',true)
            waitingDialog.hide();
            swal("",data.mensaje,"warning")
          }
        }, error : function(jqXHR, textStatus,errorThrown){
          waitingDialog.hide();
          $("#vigencia").attr('disabled',true)
          $("#gloasa").attr('disabled',true)
          $("#usuario").attr('disabled',true)
          swal("","HUBO UN ERROR EN EL SERVIDOR","error")
        }
      })
    } else {
      if(tipo == 1){
        swal("","DEBE RELLENAR EL SUMINISTRO","warning");
      } else {
        if($("#serie").val() == "" && $("#numero").val() == ""){
          swal("","DEBE RELLENAR LA SERIE Y NÚMERO DEL RECIBO","warning");
        } else if($("#serie").val() == ""){
          swal("","DEBE RELLENAR LA SERIE DEL RECIBO","warning");
        } else {
          swal("","DEBE RELLENAR EL NUMERO DEL RECIBO","warning");
        }
      }
    }
 }

  	$("#buscar").click(function(){
    	buscar_recibos();
	})
	
	document.getElementById('Form-Id').onkeypress = function(e){
				if (!e) e = window.event;
                buscar_recibos();
	}

  var recibos = new Array();
  var mediosProb = "";
  var chkDocs = "";
  var userId = "";
  function enviar_reclamo(){ //Funcion de registro de RECLAMOS FONAVI
	$('#save_reclamo').unbind();
	recibos.length = 0;
    $(".chekeado").each(function(){
      if($(this).prop('checked')){
        data = ({
          codFac: $(this).parent().parent().get(0).childNodes[1].textContent,
          serie: $(this).parent().parent().get(0).childNodes[2].textContent,
          numero : $(this).parent().parent().get(0).childNodes[3].textContent,
          suministro : $(this).parent().parent().get(0).childNodes[4].textContent,
          periodo : $(this).parent().parent().get(0).childNodes[6].textContent
        })
        recibos.push(data);
      }
	});
	$(".DocMedios").each(function(){
		if($(this).prop('checked')){
			mediosProb = mediosProb + $(this).val() + "-";
      	}
    });
	chkDocs = (mediosProb!="") ? mediosProb.slice(0,-1) : "";
	userId = <?php echo $_SESSION['user_id'] ?>;
    if(recibos.length > 0 && $("#Form-Nom").val() != "" && $("#txtSolMotivo").val() != ""){
      $("#save_reclamo").attr('disabled',true)
      $("#save_reclamo").attr('onclick','')
      waitingDialog.show('ENVIANDO RECLAMO...', {dialogSize: 'lg', progressType: 'warning'});
      $.ajax({
        type: 'POST',
        url : '<?php echo $this->config->item('ip') ?>Reporte_Reclamo/EnvioReclamo?ajax=true',
        data : ({
           recibos : recibos,
           dniSolic : $("#Form-Id").val(),
           motivo : $("#txtSolMotivo").val(),
           documentos : chkDocs,	
           observ : $("#txtObserv").val(),
		   suminist : recibos[0]["suministro"],
		   usuario : parseInt(userId), 
           prestatario : parseInt($("#codPrest").val())
           
         }),
        cache : false,
        dataType : 'json',
        success :  function (data) {
			console.log(data);
          if(data.result){
            waitingDialog.hide();
            swal("",data.mensaje,"success");
            location.reload();
          } else {
            waitingDialog.hide();
            swal("",data.mensaje,"warning");
            $("#save_reclamo").attr('disabled',false)
            $("#save_reclamo").attr('onclick','enviar_reclamo')
          }
        }, error :  function (jqXHR,textStatus,errorThrown){
          waitingDialog.hide();
          $("#save_reclamo").attr('disabled',false)
          $("#save_reclamo").attr('onclick','enviar_reclamo')
		  swal("","HUBO UN ERROR EN EL SERVIDOR","error")
        }
      })
    } else {
      if(recibos.length <= 0){
        swal("","DEBE SELECCIONAR LOS RECIBOS QUE PASARAN AL PROCESO DE RECLAMO","warning")
      } else if($("#Form-Nom").val() == ""){
        swal("","DEBE INGRESAR LOS DATOS DEL SOLICITANTE","warning")
      } else if($("#txtSolMotivo").val() == ""){
        swal("","INGRESE EL MOTIVO DEL RECLAMO","warning")
      }
    }
  }

  function justNumbers(e){
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46)) return true;
    return /\d/.test(String.fromCharCode(keynum));
  }

  // ****************** REMOVER USUARIO *********************** //
  $("#Form-Reset").on("click", function(){
                swal({
                        title: "Desea restaurar datos del cliente",
                        text: "Perdera algunos datos del formulario",
                        type: "warning",
                        confirmButtonColor: "#296fb7",
                        showCancelButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                    }, function(valor){
                        if(valor==true){
                            reset_form_rec();
                        }
                });
			});

	function reset_form_rec(){
            usr = null;
            $("#Form-Nom").attr('disabled', true);
            $("#Form-Id").attr('disabled', false);
			$("#Form-Nom").val('');
            $("#Form-Id").val('');
	}
	// *************** END ************************** //

	document.getElementById('Form-Id').onkeypress = function(e){
                if (!e) e = window.event;
                var keyCode = e.keyCode || e.which;
                if (keyCode == '13'){
                    if(validar_documento()){
                        buscar_persona_reclamante($('#Form-Id').val());
                    }else{
                        $('#Form-Id').css();
                    }
                    return false;
                }
	}
			
	function validar_documento(){
        var tf = false;

            $('#Form-Id').inputmask('Regex', {
                regex:'[0-9]{8}'
            });
            var er = new RegExp('[0-9]{8}');
            tf = validar_campo(er, $('#Form-Id').val());

        return tf;
	}
	function validar_campo(exp_reg, texto){
        // texto = texto.toUpperCase();
        str = exp_reg.exec(texto);
        if(str == null){
            return false;
        }
        return (str[0] == texto);
	}

	function show_swal(tipo, titulo, mensaje, cancelbtn, clsconfirm, shconfirmbtn){
        swal({
            title: titulo,
            text: mensaje,
            type: tipo,
            showCancelButton: cancelbtn,
            closeOnConfirm: clsconfirm,
            confirmButtonColor: "#296fb7",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showConfirmButton : shconfirmbtn
        }, function(valor){
            return valor;
        });
	}

	function invalidar_solicitud(codReclamo){
		userId = <?php echo $_SESSION['user_id'] ?>;
		swal({   title: "¿Está usted seguro de invalidar la solicitud?",  
         text: "Los reclamos invalidaos podran ser utilizados para una proxima solicitud.",   
         type: "warning",  
          showCancelButton: true,   
          confirmButtonColor: "#296fb7",  
           confirmButtonText: "¡Sí!, Estoy seguro",   
		   closeOnConfirm: false }, function(){   
			waitingDialog.show('ANULANDO SOLICITUD...', {dialogSize: 'lg', progressType: 'warning'});
					var docTipo = 1;
						show_swal('info', 'Invalidar Solicitud Nro: '+ codReclamo, 'Espere porfavor...', false, false, false);
						$.ajax({
							type: "POST",
							url: "<?php echo $this->config->item('ip'); ?>Reporte_Reclamo/InvalidarSolicitud?ajax=true",
							data: {codRec: codReclamo, codUser: userId},
							dataType: 'json',
							success: function(data) {
								if(data.result) {
									sweetAlert(data.titulo, data.mensaje, data.tipo);
									swal.close();
									waitingDialog.hide();
            						location.reload();
									//sweetAlert(data.titulo, data.mensaje, data.tipo);
									return true;
								}else{
									waitingDialog.hide();
									sweetAlert(data.titulo, data.mensaje, data.tipo);
									swal.close();
									return false;
								}
							}
						});	
		    });
	}
	
	function buscar_persona_reclamante(nro_dni){
		var docTipo = 1;
        show_swal('info', 'Buscando DNI: '+nro_dni, 'Espere mientras buscamos al usuario', false, false, false);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>consulta/buscar-dni?ajax=true",
            data: {dni: nro_dni, tipdoc: docTipo},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.dni){
                        usr = data.persona;
                        $('#Form-Id').val(usr['NRODOC']);
                        $('#Form-Nom').val(usr['APEPAT']+' '+usr['APEMAT']+' '+usr['NOMBRE']);
						$('#idSolEmail').val(usr['EMAIL']);
						$('#idSolTelefono').val(usr['TELFIJ']);
                        // swal.close();
                        sweetAlert(usr['NRODOC'] +" "+ data.titulo, data.mensaje, data.tipo);
                    }else{
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                        put_modregper_message(data.tipo, data.mensaje);
                        accion_modregper = 'registrar';
                        //console.log($('Form-TDIdent option:selected').attr('tipo'));
                        $('#MODREGPER-TIPDOC').val($('#Form-TDIdent option:selected').text());
                        $('#MODREGPER-TIPDOC').attr('codigo', $('#Form-TDIdent option:selected').val());
                        $('#MODREGPER-TIPDOC').attr('tipo', $('#Form-TDIdent option:selected').attr('tipo'));
                        $('#MODREGPER-TIPDOC').attr('longitud', $('#Form-TDIdent option:selected').attr('longitud'));
                        $('#MODREGPER-DNI').val(nro_dni);
                        cambiar_tipo_modregper('registrar');
                        $('#MODREGPER').modal("show");//CLIAPELLPE, CLIAPELLM, CLINOMBR1, CLINOMBR2
                        
                        swal.close();
                        //$('#MODREGPER-NM').focus();
                        $("#Form-Id").val(nro_dni);
                    }
                    //sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
	}
	// ************ MODAL PARA LA ACTUALIZACION DE DATOS DE LA PERSONA ************** //
	$("#Form-Edit").on("click", function(){
		
                if(usr != null){
                    cambiar_tipo_modregper('editar');
                    $('#MODREGPER').modal("show");
                }
			});
	// *************************** END MODAL *************************************** //

	var DetSolicRec = new Array();
	function detalle_solicitud(cod){
		var htmlDet = "";
		var textDoc = "";
		$.ajax({
		type : 'POST',
		url: "<?php echo $this->config->item('ip'); ?>Reporte_Reclamo/ViewSolicDetalle?ajax=true",
		data : ({
			codPrest : cod
		}),
		cache :false,
		dataType : 'json',
		success : function(data){
			DetSolicRec = data.ResulDetalle;
			if(data.result){
				$("#view_ModalDetalle").modal('show');
				$("#viewCodSol").val(DetSolicRec[0].COD_REC);
				$("#numSol").html(DetSolicRec[0].COD_REC);
				$("#viewFechaReg").val(DetSolicRec[0].FEC_REG);
				$("#viewHoraReg").val(DetSolicRec[0].HORA_REG);

				$("#viewProyecto").val(DetSolicRec[0].PROYECTO);
				$("#viewConces").val(DetSolicRec[0].CONCESIONARIO);

				$("#viewCodPrest").val(DetSolicRec[0].CODIGO);
				$("#viewNombPrest").val(DetSolicRec[0].PRESTATARIO);
				$("#viewDirPrest").val(DetSolicRec[0].DIRECCION_P);

				$("#viewSolDni").val(DetSolicRec[0].NRODOC);
				$("#viewSolNombre").val(DetSolicRec[0].NOMBRE +", "+ DetSolicRec[0].APEPAT +" "+ DetSolicRec[0].APEMAT);
				$("#viewSolTelef").val(DetSolicRec[0].TELFIJ);
				$("#viewSolEmail").val(DetSolicRec[0].EMAIL);
				$("#viewSolMotivo").val(DetSolicRec[0].REC_MOTIV);
				$("#viewSolObs").val(DetSolicRec[0].REC_OBS);

				var docSol = (DetSolicRec[0].REC_DOC != "") ? DetSolicRec[0].REC_DOC.split('-') : "";
				console.log(docSol);
				if(docSol != []){
					
					for(var i=0;i<docSol.length;i++){
						switch(docSol[i]) {
							case '1':
							    textDoc = textDoc + '<label>* Copia legible del documento de identidad</label><br>';
							break;
							case '2':
								textDoc = textDoc + '<label>* Copia de la liquidación por conexión domiciliaria objetivo del reclamo</label><br>';
							break;
							case '3':
								textDoc = textDoc + '<label>* Recibos de consumo (copia simple)</label><br>';
							break;
							case '4':
								textDoc = textDoc + '<label>* Constancia de pago otorgada por la concesionaria o quien haga sus veces (original y solo en caso no presenten recibos)</label><br>';
							break;
							case '5':
								textDoc = textDoc + '<label>* Depósitos bancarios y otros ( copia simple de cada recibo), de ser el caso</label><br>';
							break;
							default:
							// code to be executed if n is different from case 1 and 2
						}  
					}
					$("#viewDocument").html(textDoc);
				}else{
					$("#viewDocument").html(docSol);
				}
				
				

				for (i = 0; i < DetSolicRec.length; ++i) {
					htmlDet = '<tr class="detSolicitud">'+
								'<td>' + DetSolicRec[i].RECIBOS_FACT_FONAVI_CODIGO + '</td>'+
								'<td>' + DetSolicRec[i].SERIE_RECIBO + ' - ' + DetSolicRec[i].NUMERO_RECIBO + '</td>'+
								'<td>' + DetSolicRec[i].SUMINISTRO + '</td>'+
								'<td>' + DetSolicRec[i].FECHA_EMISION_RECIBO + '</td>'+
								'<td>' + DetSolicRec[i].PERIODO + '</td>'+
								'<td style="text-align:center">';
						if(DetSolicRec[i].ESTADO_RECIBO == "I")
					htmlDet = htmlDet + "<span class='badge bg-red'>PENDIENTE</span></td>"; 
						if(DetSolicRec[i].ESTADO_RECIBO == "P")
					htmlDet = htmlDet + "<span class='badge bg-green'>PAGADO</span></td>";		
						if(DetSolicRec[i].ESTADO_RECIBO == "R")
					htmlDet = htmlDet + "<span class='badge bg-yellow'>REFINANCIADO</span></td>";	
						if(DetSolicRec[i].ESTADO_RECIBO == "C")
					htmlDet = htmlDet + "<span class='badge bg-info'>CONVENIO</span></td>";
					htmlDet = htmlDet + '<td>' + DetSolicRec[i].TOTAL_RECIBO + '</td>';
					htmlDet = htmlDet + '<td>' + DetSolicRec[i].LOCALIDAD + '</td>';
					htmlDet = htmlDet + '<td><p class="text-primary"><b>' + DetSolicRec[i].IMPORTE_FONAVI + '</b></p></td>';
					htmlDet = htmlDet + "</tr>";	   
				}
				$("#viewTblDetalle").html(htmlDet);

			} else {
				swal("",data.mensaje,"warning")
			}
		}, error :  function(jqXHR,textStatus,errorThrown){
			swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
		}
		})
	}
	function SendReportPDF(codRec){
        var codigo  = codRec;
        var tipo  = 'pdf';
        
        var json = JSON.stringify(new Array(codigo,tipo));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'Reporte_Reclamo/Reporte_Fonavi/Reporte_pdf'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_reporte',
                'value': json,
                'type': 'hidden'
            }));
            $('body').append(form);
                    form.submit();
    }
	  
</script>
<?php
    if (isset($modal_persona)) {
        $this->load->view($modal_persona);
    }
?>