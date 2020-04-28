<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/> 
<script type="text/javascript">
  	var servidor = '<?php  echo $this->config->item('ip'); ?>';
</script>
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
       		<?php if (isset($_SESSION['mensaje'])) { ?>
        		<div class="alert bg-<?php echo $_SESSION['mensaje'][0]; ?> alert-dismissible">
            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            		<?php echo $_SESSION['mensaje'][1]; ?>
        		</div><br>
        	<?php } ?>
        	<div class="panel  panel-warning">
				<div class="panel-heading borde_box">
					<div class='row'>
						<div class="col-md-6 col-sm-6 col-sx-12">
							<h5 class="box-title text-uppercase text-info titulo_box" style="margin:0px"><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; Lista de Clientes</h5>
						</div>
						<div class="col-md-3 col-sm-3 hidden-xs">
							<?php if (isset($busqueda2)) { ?>
								<a 	class="btn btn-info btn-md" 
									style="width:100%" 
									id='btn_busqueda_m' 
									data-toggle="tooltip" 
									title="Puedes realizar búsquedas por urbanización, dirección, número municipal y/o nombre del cliente." 
									disabled>
										<i class="fa fa-object-group" aria-hidden="true"></i> &nbsp; Búqueda Múltiple
								</a>
							<?php } ?>
						</div>
						<div class="col-md-3 col-sm-3 hidden-xs">
							<?php if (isset($busqueda1)) { ?>
								<a 	class="btn btn-danger btn-md" 
									style="width:100%" 
									id='btn_busqueda_r' 
									data-toggle="tooltip" 
									title="Puedes realizar búsquedas por cualquier recibo, mediante la serie y número del recibo." 
									disabled>
										<i class="fa fa-file-text-o" aria-hidden="true" disabled></i> &nbsp; Buscar por recibo
								</a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
            		<div class="row" style="margin:10px 0px">
              			<div class="col-md-12">
                			<form id="formSugerencia" method="post" class="form-horizontal" action="">
                  				<div class="row">
                    				<div class="col-md-4 col-sm-4 col-sx-12 ">
                      					<div class="form-group">
											<select class="form-control" name="tipo_busqueda" style="border-radius: 4px;" id="tipo_busqueda" onchange="cambiar_tipo()">
												<option value="suministro">Suministro</option>
												<option value="nombre">Nombre</option>
												<option value="dni">D.N.I.</option>
												<option value="ruc">R.U.C.</option>
												<option value="direccion">Dirección</option>
											</select>
                      					</div>
                    				</div>
                    				<div class="col-md-5 col-sm-5 col-sx-12 ">
										<div class="form-group has-success" style="padding: 0px 10px;margin-bottom: 0px;">
											<input 
												class="form-control" 
												style="border-radius: 4px;" 
												id="campo_busqueda"
												onKeyUp="return limitar(event,this.value,11)"
												onKeyDown="return limitar(event,this.value,11)"  
												name="suministro"  
												placeholder="Ejm: 01016304160" 
												type="number" 
												disabled />
											<span class="help-block" id="referencia_busqueda">Ingrese un suministro</span>
										</div>
                    				</div>
                    				<div class="col-md-3 col-sm-3 col-sx-12 row_top">
                      					<button type="submit" class="btn btn-success btn-sm" style="width:100%" id='btn_buscar' disabled> <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Buscar </button>
                    				</div>
                  				</div>
                			</form>
              			</div>
            		</div>
					<hr>
					<div class="row">
            			<div class="col-md-12 table-responsive">
              				<table id="clientes" class="table table-bordered table-striped">
                				<thead>
                  					<tr>
                    					<th>Suministro</th>
                    					<th>Nombre</th>
                    					<th class="hidden-sm hidden-xs">R.U.C. / D.N.I.</th>
                    					<th class="hidden-sm hidden-xs">Clase</th>
                    					<th>Urbanización</th>
                    					<th>Dirección</th>
                    					<th class="hidden-xs">N° Municipal</th>
                    					<th class="hidden-sm hidden-xs">Tarifa</th>
                    					<th>Opciones</th>
                  					</tr>
                				</thead>
                				<tbody id='cuerpo_cliente'>
                  					<?php if($consulta == 'unica'){ ?>
                    					<?php foreach ($one_cliente as $cliente) { ?>
                  							<tr>
											  	<td class="text-right"><?php echo ( ( substr($cliente['CLICODFAC'], 3,4) == '0000') ? substr($cliente['CLICODFAC'],0,3).substr($cliente['CLICODFAC'], 7,4) : $cliente['CLICODFAC']) ?></td>
                    							<td><?php echo $cliente['CLINOMBRE']; ?></td>
                    							<td class="hidden-sm hidden-xs" ><?php echo (($cliente['CLIELECT'] != NULL) ? $cliente['CLIELECT'] : $cliente['CLIRUC']); ?></td>
                    							<td class="hidden-sm hidden-xs"><?php echo $cliente['tipo']; ?></td>
                    							<td><?php echo $cliente['URBDES']; ?></td>
                    							<td><?php echo $cliente['CALDES']; ?></td>
                    							<td class="hidden-xs" ><?php echo $cliente['CLIMUNNRO']; ?></td>
                    							<td class="hidden-sm hidden-xs"><?php echo $cliente['TARIFA']; ?></td>
                    							<td class="center">
                      								<?php if($ver_cuenta) {?>
                      									<a id="btn_cta_corriente" onclick="enviar_suministro('<?php echo $cliente['CLICODFAC']; ?>')" class="btn btn-success btn-xs" >
                         									<i class="fa fa-eye"></i> Cuenta corriente
                      									</a>
                      								<?php } ?>
                      								<?php if($ver_gis) { ?>
                      									<a id='btn_cta_gis' 
														  	href="https://land.sedalib.com.pe/gis-sedalib/GisCorporativo/map_genexus.phtml?config=configs\grales\config_metropolitano&xlocal=03&xlocal2=03&resetsession=ALL&sumi=<?php echo ((substr($cliente['CLICODFAC'],3,4) == "0000") ? substr($cliente['CLICODFAC'],0,3).substr($cliente['CLICODFAC'],7,4) : $cliente['CLICODFAC'] ) ?>" 
														  	target="_blank" 
															class="btn btn-info btn-xs">
                        									<i class="fa fa-map-marker"></i> Ubicación GIS
                      									</a>
                      								<?php }  ?>
                    							</td>
                  							</tr>
                    					<?php } ?>
                  					<?php } else {?>
                   						<?php foreach($clientes as $cliente){ ?>
                    						<tr>
                        						<td class="text-right"><?php echo ( ( substr($cliente['CLICODFAC'], 3,4) == '0000') ? substr($cliente['CLICODFAC'],0,3).substr($cliente['CLICODFAC'], 7,4) : $cliente['CLICODFAC']) ?></td>
                        						<td><?php echo $cliente['CLINOMBRE']; ?></td>
                        						<td class="hidden-sm hidden-xs" ><?php echo (($cliente['CLIELECT'] != NULL) ? $cliente['CLIELECT'] : $cliente['CLIRUC']); ?></td>
                        						<td class="hidden-sm hidden-xs"><?php echo $cliente['tipo']; ?></td>
                        						<td><?php echo $cliente['URBDES']; ?></td>
                        						<td><?php echo $cliente['CALDES']; ?></td>
                        						<td class="hidden-xs"><?php echo $cliente['CLIMUNNRO']; ?></td>
                        						<td class="hidden-sm hidden-xs"><?php echo $cliente['TARIFA']; ?></td>
                        						<td class="center" style="vertical-align:middle">
                        							<?php if($ver_cuenta) {?>
                          								<a id="btn_cta_corriente" onclick="enviar_suministro('<?php echo $cliente['CLICODFAC']; ?>')" class="btn btn-success btn-xs" >
                             								<i class="fa fa-eye"></i> Cuenta corriente
                          								</a>
                          							<?php } ?>
                          							<?php if($ver_gis) { ?>
                          								<a 
														  	id='btn_cta_gis' 
															href="https://land.sedalib.com.pe/gis-sedalib/GisCorporativo/map_genexus.phtml?config=configs\grales\config_metropolitano&xlocal=03&xlocal2=03&resetsession=ALL&sumi=<?php echo ((substr($cliente['CLICODFAC'],3,4) == "0000") ? substr($cliente['CLICODFAC'],0,3).substr($cliente['CLICODFAC'],7,4) : $cliente['CLICODFAC'] ) ?>" 
															target="_blank" 
															class="btn btn-info btn-xs">
                            								<i class="fa fa-map-marker"></i> Ubicación GIS
                          								</a>
                          							<?php } ?>
                        						</td>
                    						</tr>
                    					<?php } ?>
									<?php } ?>
               					</tbody>
              				</table>
           				</div>
					</div>
         		</div>
        	</div>
    	</div>
  	</div>
	<?php 
	if (isset($busqueda1)) { 
	?> 
	<div id="buscar_recibo" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content contenido_modal" >
				<div class="modal-header bg-info" style="border-radius:4px">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title titulo_modal"> <i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp; Buscar por recibo</h4>
				</div>
				<div class="modal-body">
				<div class="row">
						<div class="col-md-12">
						<div class="callout bg-success cuadro_dialogo">
								<h5 class="dialogo_titulo"><i class="fa fa-info"></i> IMPORTANTE</h5>
								<p class="sin_margen">Para buscar la cuenta corriente de un cliente, debe ingrese la <b>SERIE</b> Y <b>NUMERO</b> de algún recibo del cliente, sin importar el estado del recibo (Pagado, Impago, Refinanciado, etc.). </p>
						</div>
					</div>
				</div><br>
				<div class="row">
						<div class="col-md-4 col-sm-4 col-md-offset-2">
							<div class="form-group has-error">
							<label class="control-label" for="serie"><i class="fa fa-check"></i> Serie recibo</label>
							<input class="form-control" style="border-radius:4px" id="serie" placeholder="Ejm: 106" type="number" onKeyUp="return limitar(event,this.value,3)" onKeyDown="return limitar(event,this.value,3)">
							<span class="help-block">Solo 3 dígitos</span>
						</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group has-error">
							<label class="control-label" for="numero"><i class="fa fa-check"></i> Número recibo</label>
							<input class="form-control" style="border-radius:4px"  id="numero" placeholder="Ejm: 14178144" type="number" >
							<span class="help-block"></span>
						</div>
						</div>
				</div>
				</div>
				<div class="modal-footer borde_footer">
				<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-6">
						<button type="button" class="btn btn-danger btn-sm" style="width:100%" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; Cancelar</button>
						</div>
					<div class="col-md-6 col-sm-6">
					</div>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<button type="button" class="btn btn-success btn-sm" style="width:100%" onclick="buscar_persona()"><i class="fa fa-search" aria-hidden="true"></i> &nbsp; Buscar</button>
						</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php 
	if (isset($busqueda2)) {
	?>
	<div id="busqueda_multiple" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content contenido_modal">
				<div class="modal-header bg-info" style="border-radius:4px">
					<button type="button" class="close" data-dismiss='modal'>&times;</button>
					<h4 class="modal-title titulo_modal"> <i class="fa fa-object-group" aria-hidden="true"></i> &nbsp; Búqueda Múltiple</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="callout bg-success cuadro_dialogo">
								<h5 class="dialogo_titulo"><i class="fa fa-info"></i> IMPORTANTE</h5>
								<p class="sin_margen">Para buscar la cuenta corriente de un cliente, rellene al menos 1 de los campos que esta en la parte inferior. </p>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-md-5 col-sm-5 col-xs-12 col-sm-offset-1">
							<div class="form-group has-success">
								<label class="control-label" for="urbanizacion"><i class="fa fa-check"></i> Urbanización</label>
								<input class="form-control" id="urbanizacion" style="border-radius:4px" placeholder="Ejm: Primavera" type="text">
								<span class="help-block">Nombre de la urbanización.</span>
							</div>
						</div>
						<div class="col-md-5 col-sm-5 col-xs-12">
							<div class="form-group has-success">
								<label class="control-label" for="direccion"><i class="fa fa-check"></i> Dirección</label>
								<input class="form-control" id="direccion" style="border-radius:4px" placeholder="Ejm: Tulipanes" type="text">
								<span class="help-block">Nombre de la dirección.</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 col-sm-5 col-xs-12 col-sm-offset-1">
							<div class="form-group has-success">
								<label class="control-label" for="numero2"><i class="fa fa-check"></i> Número</label>
								<input class="form-control" id="numero2" style="border-radius:4px" placeholder="Ejm: 3-5" type="text">
								<span class="help-block">Número municipal de la casa.</span>
							</div>
						</div>
						<div class="col-md-5 col-sm-5 col-xs-12">
							<div class="form-group has-success">
								<label class="control-label" for="nombre_cliente"><i class="fa fa-check"></i> Nombre</label>
								<input class="form-control" id="nombre_cliente" style="border-radius:4px" placeholder="Ejm: Moreno" type="text">
								<span class="help-block">Apellido del cliente.</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer borde_footer">
					<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-6">
							<button type="button" class="btn btn-danger btn-sm" style="width:100%" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; Cancelar</button>
						</div>
						<div class="col-md-6 col-sm-6">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<button type="button" class="btn btn-success btn-sm" style="width:100%" id="buscar_combinado"><i class="fa fa-search" aria-hidden="true"></i> &nbsp; Buscar</button>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
	<?php } ?>
</section>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/cuenta_corriente/app.css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/dist/js/Genesys/cuenta_corriente/app.min.js"></script>
