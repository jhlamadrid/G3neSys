<script type="text/javascript">
    var servidor = '<?php echo $this->config->item('ip'); ?>';
</script>
<style>
    .colorWarning{
        color: #f39c12;
    }
	.head_green{
		background: #00a65a;
    	border-radius: 5px 5px 0px 0px;
    	color: #FFF
	}
	.contenido_modal{
		border-radius: 5px !important;
	}
	.titulo_modal {
    	font-family: 'Ubuntu' !important;
	}
	.title_label {
    	background: #3c8dbc !important;
    	color: #FFF;
    	border: none !important;
	}
	.label_input {
		margin-top: 5px !important;
	}
	.derecha{
		text-align: right;
	}
	.btn-total {
		width: 100% !important;
	}
	.cuerpo_scroll {
		height: 440px;
		overflow-y: auto;
	}
</style>
<section class="content">
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 col-sm-3" >
                    <label style="color:#00a65a;font-size:20px !important"> <i class="fa fa-wrench" aria-hidden="true"></i> ACCIONES COERCITVAS</label>
                </div>
                <div class="col-md-3 col-sm-3" style="margin-top:5px">
                    <button type="button" class="btn btn-info btn-total" style='width:100%' onclick="ver_detalle_deuda('<?php echo $suministro; ?>')"> 
                        <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; DETALLE DE DEUDA
                    </button>
                </div>
                <div class="col-md-3 col-sm-3" style="margin-top:5px">
                    <button type="button" class="btn btn-info btn-total" style='width:100%' onclick="imprimir_acciones('<?php echo $suministro; ?>')">
                        <i class="fa fa-print" aria-hidden="true"></i> &nbsp; IMPRIMIR ACCIONES
                    </button>
                </div>
                <div class="col-md-3 col-sm-3" style="margin-top:5px">
                    <button type="button"class="btn btn-info btn-total" style='width:100%' onclick="ver_mas_acciones('<?php echo $suministro; ?>')">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; ACCIONES REALIZDAS
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="box box-primary">
                <div class="box-body">
                     <div class="table-responsive">
                        <table id="resumen" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th colspan="9" style="text-align:center;background: #296fb7;color:#FFF">CORTES</th>
                                    <th colspan="8" style="text-align:center;background: #75a96f;">REAPERTURAS</th>
                                </tr>
                                <tr role="row">
                                    <th style="color:#296fb7;background: #e4e4e4;">OF.</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">AG.</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">NRO.</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">CARTERA</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">FECHA / HORA GENERACIÓN</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">NIVEL CORTE</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">OBSERVACIÓN</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">FECHA / HORA ACCIÓN</th>
                                    <th style="color:#296fb7;background: #e4e4e4;">FECHA / HORA REGULARIZO</th>
                                    <th style="background: #e4e4e4;">OF</th>
                                    <th style="background: #e4e4e4;">AGE</th>
                                    <th style="background: #e4e4e4;">NRO. REPAERT.</th>
                                    <th style="background: #e4e4e4;">COD</th>
                                    <th style="background: #e4e4e4;">SERVICE</th>
                                    <th style="background: #e4e4e4;">FECHA / HORA GEN. REPERT.</th>
                                    <th style="background: #e4e4e4;">OBSERVACION</th>
                                    <th style="background: #e4e4e4;">FECHA / HORA EJECUCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($acciones  as $accion) {?>
                                    <tr>
                                        <td style="color:#0756a9"><?php echo $accion['ORDENCOR_OC_OFI']; ?></td>
                                        <td style="color:#0756a9"><?php echo $accion['ORDENCOR_OC_AGE']; ?></td>
                                        <td style="color:#0756a9"><?php echo $accion['ORDENCOR_ORC_NUM']; ?></td>
                                        <td style="color:#0756a9"><?php echo $accion['cartera']; ?></td>
                                        <td style="color:#0756a9;text-align: right;"><?php echo $accion['orden_corte']['ORC_FECH']."<br/>".$accion['orden_corte']['ORC_HORA']; ?></td>
                                        <td style="color:#0756a9"><?php echo (($accion['ACCIADO'] != NULL) ? $accion['ACCIADO'][0]['nivel'] : "") ?></td>
                                        <td style="color:#0756a9"><?php echo (($accion['ACCIADO'] != NULL) ? $accion['ACCIADO'][0]['OBSERVACION'] : "") ?></td>
                                        <td style="color:#0756a9;text-align: right;"><?php echo (($accion['ACCIADO'] != NULL) ? $accion['ACCIADO'][0]['DONEFECH'] : "")."<br />".(($accion['ACCIADO'] != NULL) ? $accion['ACCIADO'][0]['DONEHORA'] : "") ?></td>
                                        <td style="color:#0756a9;text-align: right;"><?php echo (($accion['ACCIADO'] != NULL) ? $accion['ACCIADO'][0]['deuda']['NW_FECHA'] : "")."<br/>".(($accion['ACCIADO'] != NULL) ? $accion['ACCIADO'][0]['LOADHORA'] : "") ?></td>
                                        <td><?php echo $accion['reconexion']['REA_CAB_REA_OFI']; ?></td>
                                        <td><?php echo $accion['reconexion']['REA_CAB_REA_AGE']; ?></td>
                                        <td><?php echo $accion['reconexion']['REA_CAB_REA_NRO']; ?></td>
                                        <td><?php echo $accion['reconexion']['REA_CRT']; ?></td>
                                        <td><?php echo $accion['reconexion']['service']; ?></td>
                                        <td style="text-align: right;"><?php echo $accion['reconexion']['REA_FEC'].'<br/>'.$accion['reconexion']['REA_HRA']; ?></td>
                                        <td><?php echo $accion['reconexion']['OBS_DETA']; ?></td>
                                        <td style="text-align: right;"><?php echo $accion['reconexion']['REA_FOB']."<br />".(($accion['reconexion']['REA_HOB'] != '00:00:00') ? $accion['reconexion']['REA_HOB'] : ""); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div><br>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top:5px">
        <div class='col-md-12 col-sm-12'>
            <div class="callout callout-success">
                <p>Para ver los recibos por los cuales se genero el corte. <b>"SELECCIONE UNA FILA"</b> de la tabla inferior y de click en el boton de <b>"DETALLE DE DEUDA DEL CLIENTE".</b></p>
            </div>
        </div>
    </div>
</section>
<div id='modal_deuda' class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
    	<div class="modal-content contenido_modal">
      		<div class="modal-header head_green">
        		<button type="button" class="close" name="button" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-family:'Ubuntu'"><i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp; DETALLE DE CORTE</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
          			<div class="col-md-12 col-sm-12">
            			<div class="box box-success">
              				<div class="box-header with-border">
                				<span class="title text-blue"> DETALLE DE RECIBOS CAUSA DE CORTE</span>
              				</div>
              				<div class="box-body">
                				<div class="row">
                  					<div class="col-md-6 col-sm-6" style="text-align:center">
                    					<div class="input-group">
                      						<span class="input-group-addon" id="basic-addon3" style="background:#990000;color:#FFF">SALDO POR EL CORTE :</span>
                      						<input type="text" class="form-control" id="saldo_corte" value="" style="text-align:right"  disabled>
                    					</div>
                  					</div>
                  					<div class="col-md-6 col-sm-6" style="text-align:center">
                    					<div class="input-group">
                      						<span class="input-group-addon" id="basic-addon3" style="background:#990000;color:#FFF">CANTIDAD DE RECIBOS :</span>
                      						<input type="text" class="form-control" id="cantidad_recibos" value="" style="text-align:right" disabled>
                    					</div>
                  					</div>
                				</div>
              				</div>
            			</div>
          			</div>
        		</div>
        		<div class="row" id='deuda_detallada'>
          			<div class="col-md-12 col-sm-12">
            			<div class="box box-primary">
              				<div class="box-header with-border">
                				<span class="title text-blue">DETALLE DE LA DEUDA</span>
              				</div>
              				<div class="box-body">
                				<div class="table-responsive">
                    				<table id="deuda_corte" class="table table-bordered table-striped">
                      					<thead>
                          					<tr role="row">
                            					<th>Serie</th>
                            					<th>Número</th>
                            					<th>F. Actualización</th>
                            					<th>Saldo de Corte</th>
                            					<th>Estado Actual</th>
                            					<th>Opciones</th>
                          					</tr>
                      					</thead>
                      					<tbody id='cuerpo_deuda'>
                      					</tbody>
                    				</table>
                				</div>
              				</div>
            			</div>
          			</div>
        		</div>
      		</div>
      		<div class="modal-footer">
				<div class='row'>
					<div class='col-md-4 col-sm-4'>
						<button type="button" class="btn btn-danger btn-total" style="width: 100%" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i> &nbsp; Cerrar</button>
					</div>
					<div class='col-md-4 col-sm-4'></div>
					<div class='col-md-4 col-sm-4'>
					</div>
				</div>	 
      		</div>
    	</div>
  	</div>
</div>
<div id="otras_acciones" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
    	<div class="modal-content contenido_modal" >
      		<div class="modal-header head_green">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-family:'Ubuntu'"> <i class="fa fa-wrench" aria-hidden="true"></i> &nbsp; DETALLE DE CORTES REALIZADOS</h4>
      		</div>
      		<div class="modal-body cuerpo_scroll">
        		<div class="table-responsive">
          			<table id="otros_cortes_cuerpo" class="table table-bordered table-striped">
            			<thead>
              				<tr role="row">
                				<th>FECHA / HORA EJECUCIÓN</th>
                				<th>NIVEL</th>
                				<th>DESCRIPCIÓN</th>
                				<th>OBSERVACIÓN</th>
                				<th>DETALLE</th>
                				<th>OFICINA</th>
                				<th>AGENCIA</th>
                				<th>NÚMERO</th>
                				<th>SERVICE</th>
              				</tr>
            			</thead>
            			<tbody id='otros_cuerpo'>
            			</tbody>
          			</table>
        		</div>
      		</div>
      		<div class="modal-footer">
			  	<div class='col-md-4 col-sm-4'>
					<button type="button" class="btn btn-danger btn-total" style="width: 100%" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i> &nbsp; Cerrar</button>
				</div>
				<div class='col-md-4 col-sm-4'></div>
				<div class='col-md-4 col-sm-4'>
				</div>
      		</div>
    	</div>
  	</div>
</div>
<?php 
if ($ver_detalle) { 
  #Validamos que el usuario tenga acceso a la opción de "VER DETALLE DEL RECIBO"
?>
<div id="detalle_recibo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('detalle_recibo')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp; DETALLE DEL RECIBO <span id='serie_numero_recibo'></span></h4>
      </div>
      <div class="modal-body cuerpo_scroll">
        <div class="box-primary">
          <div class="box-body" id='cabecera_detalle_recibo'>
            
          </div>
        </div>
        <div class="box-warning">
          <div class="box-body" id='cuerpo_detalle_recibo'></div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('detalle_recibo')"> <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/dist/js/Genesys/cuenta_corriente/acciones_ejecutadas.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>
<style>
    .ajs-button.ajs-ok {
        background: rgba(200,200,200,0) !important;
        border: 1px solid rgba(41, 111, 183, 0.73) !important;
        border-radius: 2px;
    }
</style>


