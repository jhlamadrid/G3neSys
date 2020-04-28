<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.min.css">
<section class="content">
    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu"> <i class="fa fa-file-text" aria-hidden="true"></i> CREAR SOLICITUD DE REQUERIMIENTO </h3>
                </div>
                <div class="box-body">
                    <div class='row'>
                        <div class ='col-md-12'>
							<div class ='col-md-12' style="margin-top:12px;">
								<h3 class='text-center'>
									<strong>
										CREAR SOLICITUD DE REQUERIMIENTO <span style ='color:red;'> (<?php echo $recla_descripcion[0]['CPDESC']; ?>)</span>
									</strong>
								</h3>
							</div>
						</div>
                    </div>
                    <br>
                    <div class ='row'>
                        <div class ='col-md-12'>
                            <div class="row">
								<div class ='col-md-12'>
                                    <div class="col-md-4">
										<div class="form-group">
											<label for="text">EMPRESA</label>
										    <input type="text" class="form-control" id="empresa_cliente" value='<?php echo $empresa['EMPCOD'].'-'.$empresa['EMPDES']; ?>' readonly="readonly">
										</div>
									</div>
                                    <div class="col-md-4">
										<div class="form-group">
											<label for="text">OFICINA</label>
											<input type="text" class="form-control" id="oficina_cliente" value ="<?php  echo $_SESSION['NSOFICOD'].'-'.$_SESSION['oficina']; ?>"  readonly="readonly">
									    </div>
								    </div>
                                    <div class="col-md-4">
										<div class="form-group">
											<label for="text">ÁREA</label>
											<input type="text" class="form-control" id="area_cliente" value ="<?php  echo $_SESSION['NSARECOD'].'-'.$_SESSION['area']; ?>"  readonly="readonly">
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="form-group">
											<label for="text">CATEGORIA DOCUMENTO</label>
											<input type="text" class="form-control" id="categoria_documento" value="2-DOCUMENTOS DEL GESTOR"  readonly="readonly">
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="form-group">
											<label for="text">DOCUMENTO</label>
											<input type="text" class="form-control" id="tipo_documento" value="1-SOLICITUD DE REQUERIMIENTO"  readonly="readonly">
										</div>
									</div>
                                </div>
							</div>
                            <div class="panel panel-warning"> 
                                <div class="panel-heading">
                                    <i class="fa fa-university fa-lg" aria-hidden="true"></i>
                                </div>
                                <div class="panel-body">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>1. DATOS DE UBICACIÓN</td></tr></table>
                                        </div>
                                    </div>
                                    <div class ='row'>
                                        <div class="col-md-12">
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Departamento</label>
													<input type="text" class="form-control" id="departamento_ubica" value="<?php echo $direccion['CDPCOD'].'-'.$direccion['CDPDES']?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Provincia</label>
													<input type="text" class="form-control" id="provincia_ubica" value="<?php echo $direccion['CPVCOD'].'-'.$direccion['CPVDES']?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Distrito</label>
													<input type="text" class="form-control" id="distrito_ubica" value="<?php echo $direccion['CDSCOD'].'-'.$direccion['CDSDES']?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Grupo Poblacional</label>
													<input type="text" class="form-control" id="grupo_pobla_ubica" value="<?php echo $direccion['CGPCOD'].'-'.$direccion['CGPDES']?>"  readonly="readonly">
												</div>
											</div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
												<div class="form-group">
													<label for="text">Calle o Via</label>
													<input type="text" class="form-control" id="calle_via_ubica" value="<?php echo $direccion['MVICOD'].'-'.$direccion['MVIDES']?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-6">
												<div class="form-group">
													<label for="text">Nro, Mz, Lote</label>
													<input type="text" class="form-control" id="mza_lote_ubica"  value ='<?php echo (($tipo =='1') ? (  ((is_null($solicitud['RECDPNMUN']) ? '': $solicitud['RECDPNMUN'] )) .((is_null($solicitud['RECDPMZN']) ? '': ', '.$solicitud['RECDPMZN'] )). ((is_null($solicitud['RECDPLOTE']) ? '': ', '.$solicitud['RECDPLOTE'] ))) :''); ?>'  readonly="readonly">
												</div>
											</div>
                                            
                                        </div>
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="form-group">
													<label for="text">Referencia de la Dirección</label>
													<input type="text" class="form-control" id="ref_dire_ubica"  readonly="readonly">
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>2. DATOS DEL CLIENTE</td></tr></table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
												<div class="form-group">
													<label for="text">Apellido Paterno Solicitante</label>
													<input type="text" class="form-control" id="ape_pat_sol" value="<?php echo $Nombre_Solicitante['APEPAT']; ?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-4">
												<div class="form-group">
													<label for="text">Apellido Materno Solicitante</label>
													<input type="text" class="form-control" id="ape_mat_sol" value="<?php echo $Nombre_Solicitante['APEMAT']; ?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-4">
												<div class="form-group">
													<label for="text">Nombres del Solicitante</label>
													<input type="text" class="form-control" id="nombre_sol" value="<?php echo $Nombre_Solicitante['NOMBRE']; ?>"  readonly="readonly">
												</div>
											</div>
                                        </div>
                                        <div class ='col-md-12'>
                                            <div class="col-md-2">
												<div class="form-group">
													<label for="text">Nro. de Suministro</label>
													<input type="text" class="form-control" id="numero_sum" value="<?php echo ((is_null($solicitud['UUCOD']) ) ? '' : $solicitud['UUCOD']); ?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-2">
												<div class="form-group">
													<label for="text">Nro. Doc. Identidad</label>
													<input type="text" class="form-control" id="doc_ident"  value="<?php echo ((is_null($solicitud['DOCIDENT_NRODOC']) ) ? '' : $solicitud['DOCIDENT_NRODOC']); ?>" readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-2">
												<div class="form-group">
													<label for="text">Razón Social</label>
													<input type="text" class="form-control" id="raz_social"  value="<?php echo ((is_null($solicitud['RAZSOCIAL']) ) ? '' : $solicitud['RAZSOCIAL']); ?>" readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-2">
												<div class="form-group">
													<label for="text">Teléfono</label>
													<input type="text" class="form-control" id="tel_solicitante" value="<?php echo ((is_null($solicitud['RECDPTELF']) ) ? '' : $solicitud['RECDPTELF']); ?>"  readonly="readonly">
													<input type="text" class="form-control" id="inp_ruta" value="<?php echo base_url();?>" style='visibility:hidden'>
													<input type="text" class="form-control" id="inp_cadena" value="<?php echo $cadena;?>" style='visibility:hidden'>
												</div>
											</div>
                                            <div class="col-md-4">
												<div class="form-group">
													<label for="text">Correo Electrónico</label>
													<input type="text" class="form-control" id="correo_solicitante"  value="<?php echo ((is_null($solicitud['RECDPMAIL']) ) ? '' : $solicitud['RECDPMAIL']); ?>" readonly="readonly">
												</div>
											</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>3. DATOS DEL PROBLEMA</td></tr></table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Categoría</label>
													<input type="text" class="form-control" id="cate_problem"  value='<?php echo  $recla_descripcion[0]['CPID'].'-'.$recla_descripcion[0]['CPDESC'] ?>'  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Sub Categoría</label>
													<input type="text" class="form-control" id="sub_cat_problem" value='<?php echo $recla_descripcion[0]['SCATPROBID'].'-'.$recla_descripcion[0]['SCATPROBDESC'] ?>'  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Fecha Registro</label>
													<input type="text" class="form-control" id="fecha_problem" value="<?php echo $solicitud['RECFCH']; ?>"  readonly="readonly">
												</div>
											</div>
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="text">Hora Registro</label>
													<input type="text" class="form-control" id="hora_problem" value="<?php echo $solicitud['RECHRA']; ?>"   readonly="readonly">
												</div>
											</div>
                                        </div>
                                        <div class ='col-md-12'>
                                            <div class="col-md-12">
												<div class="form-group">
													<label for="text">Problema</label>
													<input type="text" class="form-control" id="problem" value='<?php echo $recla_descripcion[0]['PROBID'].'-'.$recla_descripcion[0]['PROBDESC'] ?>'  readonly="readonly">
												</div>
											</div>
                                        </div>
                                        <div class ='col-md-12'>
                                            <div class="col-md-12">
												<div class="form-group">
													<label for="text">Breve Descripción del Problema</label>
													<input type="text" class="form-control" id="descri_problem" value="<?php echo $solicitud['RECDESC']; ?>"  readonly="readonly">
												</div>
											</div>
                                        </div>
										<div class ='col-md-12'>
											<div class="col-md-12">
												<div class="form-group">
													<label class="control-label text-blue">Área de Derivación</label>
													<div class="input-group" style="    margin: 0px 0px 5px 10px;">
														<div class="input-group-addon">
															<i class="fa fa-exclamation-circle"></i> 
														</div>
													
														<select class="form-control select2" id="area" name="area">
															<?php $k = 0; foreach($areas as $r){?>
																<option value="<?php echo $r['ARECOD']; ?>" <?php (($k == 0) ? "selected" : "") ?>><?php echo $r['AREDES']; ?></option>
															<?php $k++;} ?>
														</select>
													</div>
												</div>
											</div>
										</div>
                                        <div class ='col-md-12'>
                                            <div class="col-md-12">
												<div class="form-group">
													<label for="text">Glosa 1 - max 100 caracteres</label>
													<textarea class="form-control" rows="5" id="glosa_problem"></textarea>
												</div>
											</div>
                                        </div>
                                        <div class ='col-md-12'>
											<div class ='col-md-6 col-md-offset-6'>
												<button id ="grabar_orden_servicio" class='btn btn-primary btn-block'>
													GENERAR ORDEN DE SERVICIO
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
</section>


<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.full.min.js"></script>
<script  type="text/javascript"  src="<?php echo $this->config->item('ip') ?>frontend/js/reclamos/jsCrea_Solicitud_reclamo.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        Crea_Solicitud_reclamo.init();
    });
</script>

