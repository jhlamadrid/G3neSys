<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>
<section class="content">
  	<div class="row">
      	<div class="col-md-12 text-blue">
        	<?php if (isset($_SESSION['mensaje'])) { ?>
         		<div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
             		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            		<?php echo $_SESSION['mensaje'][1]; ?>
         		</div><br>
         	<?php } ?>
      	</div>
  	</div>
  	<div class="row">
    	<div class="col-md-12">
      		
    	</div>
    	<div class="col-md-12">
      		<div class="panel panel-success">
        		<div class="panel-heading">
          			<div class="row">
						<div class="col-sm-6 col-xs-12">
							<h4 class="text-primary text-left" style="font-family:'Ubuntu';font-weight:bold"> <i class="fa fa-file-text"></i> NOTAS DE CRÉDITO BOLETAS Y FACTURAS</h4>  
						</div>
						<?php if(isset($notas_autorizadas) ){ ?>
            				<div class="col-sm-6 col-xs-12 text-left">
              					<a class="btn btn-danger" style="float: right;margin-top: 2%;" onclick="obtener_autorizaciones()"> <span class="fa fa-eye" aria-hidden="true"></span> Visualizar autorizaciones</a>
             				</div>
						<?php } ?>
          			</div>
        		</div>
        		<div class="panel-body">
          			<div class="row">
           		 		<div class="col-md-3 col-sm-3">
              				<div class="form-group">
                				<label >BUSCAR  POR:</label>
								<select  class="form-control" id='tipo' onchange="cambio_tipo()">
									<option value='1'>SERIE-NÚMERO FACTURA INTERNA</option>
									<option value='2'>SERIE-NÚMERO FACTURA SUNAT</option>
									<option value='3'>SERIE-NÚMERO BOLETA INTERNA</option>
									<option value='4'>SERIE-NÚMERO BOLETA SUNAT</option>
									<option value='5'>SERIE-NÚMERO NOTA CREDITO</option>
									<option value='6'>DNI</option>
									<option value='7'>RUC</option>
								</select>
              				</div>
            			</div>
            			<div class="col-md-3 col-sm-3" id='opt_srn_nro'>
              				<div class="form-group">
								<label>SERIE: </label>
								<input type="number" class="form-control" onkeypress="return justNumbers(event);" id="serie" name='serie' required>
							</div>
            			</div>
            			<div class="col-md-3 col-sm-3" id='opt_srn_nro1'>
							<div class="form-group">
								<label for="">NÚMERO: </label>
								<input type="number" class="form-control" onkeypress="return justNumbers(event);" id="numero" name='numero'  required>
							</div>
            			</div>
						<div class="col-md-6 col-sm-6" id="opt_documento" style="display:none">
							<div class="form-group">
								<label id='tip-doc'></label>
								<input type="number" class="form-control" id="documento" value="">
							</div>
						</div>
						<div class="col-md-3 col-sm-3">
							<div class="form-group">
								<a class="btn btn-success btn-sm" style="margin-top: 15px;width:100%" onclick="buscar_nota_credito()"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
							</div>
						</div>
          			</div>
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="notas_credito" class="table table-bordered table-striped">
								<thead>
									<tr role="row">
									<th>SERIE NOTA</th>
									<th>N° NOTA</th>
									<th>SERIE DOCUMENTO</th>
									<th>N° DOCUMENTO</th>
									<th>SERIE SUNAT</th>
									<th>NUMERO SUNAT</th>
									<th>FECHA EMISIÓN</th>
									<th>MONTO</th>
									<th>ESTADO</th>
									<th>OPCIONES</th>
									</tr>
								</thead>
								<tbody id="notas_credito1">
									<?php foreach($notas as $nota) {?>
										<tr>
											<td><?php echo $nota['BFNCATLET'].$nota['BFNCASERNRO'] ?></td>
											<td><?php echo $nota['BFNCANRO'] ?></td>
											<td><?php echo $nota['SFACTURA_FSCSERNRO'] ?></td>
											<td><?php echo $nota['SFACTURA_FSCNRO'] ?></td>
											<td><?php echo $nota['BFNCASUNSERNRO'] ?></td>
											<td><?php echo $nota['BFNCASUNFACNRO'] ?></td>
											<td><?php echo $nota['BFNCAFECHEMI']." ".$nota['BFNCAHRAEMI'] ?></td>
											<td style="text-align:right"><?php echo number_format($nota['BFNCATOTDIF'],2,'.',''); ?></td>
											<td style='text-align:center'>
												<?php 
													if($nota['BFNCAESTSUN'] == 1) { echo "<span class='badge bg-yellow'>Emitida</span>"; } 
													elseif($nota['BFNCAESTSUN'] == 3) { echo "<span class='badge bg-green'>Aceptada</span>"; }
													elseif($nota['BFNCAESTSUN'] == 4){echo "<span class='badge bg-red'>Rechazada</span>"; } 
													elseif($nota['BFNCAESTSUN'] == 5) { echo "<span class='badge bg-gray'>Observada</span>";}
													elseif($nota['BFNCAESTSUN'] == 6) { echo "<span class='badge bg-orange'>No atendido</span>";}
												?>
											</td>
											<td style='text-align:center'>
												<a onclick="visualizar_detalle_nota_credito('<?php echo $nota['BFNCATIPO'] ?>','<?php echo $nota['BFNCATLET'] ?>',<?php echo intval($nota['BFNCASERNRO'])*958 ?>,<?php echo intval($nota['BFNCANRO'])*235 ?>)" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="VISUALIZAR NOTA CRÉDITO">
													<i class="fa fa-eye"></i>
												</a>
												<?php if($nota['BFSFACDIRARCHPDF']){ ?>
													<a class="btn btn-default" href="<?php echo $this->config->item('ip').$nota['BFSFACDIRARCHPDF'] ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="IMPRIMIR NOTA CRÉDITO">
														<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
													</a>
												<?php } ?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div><br>
					</div>
        		</div>
      		</div>
    	</div>
  	</div>
</section>
<?php if(isset($notas_autorizadas)){ ?>
	<div class="modal fade" id="Autorizaciones" role="dialog">
  		<div class="modal-dialog modal-lg">
    		<div class="modal-content" style="border-radius:5px">
      			<div class="modal-header bg-success" style="border-radius:5px">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-info" style="font-family:'Ubuntu'">NOTAS DE CRÉDITOS AUTORIZADAS</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="notas_credito" class="table table-bordered table-striped">
								<thead>
									<tr role="row">
										<th>SERIE</th>
										<th>NÚMERO</th>
										<th>TIPO</th>
										<th>F. EMISIÓN</th>
										<th>CLIENTE</th>
										<th>MONTO</th>
										<th>AUTORIZADO PARA</th>
										<th>OPCIONES</th>
									</tr>
								</thead>
								<tbody id='cuerpo2'>
								</tbody>
							</table>
						</div>
					</div>
      			</div>
      			<span id='ik' style="display:none"></span>
      			<div class="modal-footer">
        			<div class="row">
          				<div class="col-md-4 col-sm-4"></div>
          				<div class="col-md-4 col-sm-4"></div>
          				<div class="col-md-4 col-sm-4">
            				<button type="button" class="btn btn-danger btn-sm" style="width:100%" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> CANCELAR</button>
          				</div>
        			</div>
      			</div>
    		</div>
    	</div>
  	</div>
<?php } ?>
<div class="modal fade" id="detalleNC" role="dialog">
  	<div class="modal-dialog modal-lg">
    	<div class="modal-content" style="border-radius:5px">
      		<div class="modal-header bg-success"  style="border-radius:5px">
        		<div class="row">
          			<div class="col-md-6">
            			<h4 class="modal-title text-info" style="font-family:'Ubuntu'">DETALLE DE LA NOTA DE CRÉDITO <span id='deta_serie'></span>-<span id='deta_numero'></span></h4>
          			</div>
        		</div><br>
        		<div class="row">
          			<div class="col-md-3 col-md-offset-3">
            			<div class="input-group pull-right">
              				<div class="input-group-btn">
                				<button type="button" style="width:100px" class="btn btn-success">SUBTOTAL: </button>
              				</div>
              				<input type="text" class="form-control" id='deta_sub_total' style="text-align:right" readonly>
            			</div>
          			</div>
          			<div class="col-md-3">
            			<div class="input-group pull-right">
              				<div class="input-group-btn">
                				<button type="button" style="width:100px" class="btn btn-success">IGV: </button>
              				</div>
              				<input type="text" class="form-control" id='deta_igv' style="text-align:right" readonly>
            			</div>
          			</div>
          			<div class="col-md-3">
            			<div class="input-group pull-right">
              				<div class="input-group-btn">
                				<button type="button" style="width:100px" class="btn btn-success">TOTAL: </button>
              				</div>
              				<input type="text" class="form-control" id='deta_monta' style="text-align:right">
            			</div>
          			</div>
        		</div>
      		</div>
      		<div class="modal-body">
        		<div class="panel panel-danger">
          			<div class="panel-heading">
            			<div class="row">
              				<div class="col-md-6">
                				<div class="input-group">
                  					<div class="input-group-btn">
                    					<button type="button" style="width:100px" class="btn btn-success">CLIENTE: </button>
                  					</div>
                  					<input type="text" class="form-control" id='deta_cliente' readonly>
                				</div>
              				</div>
              				<div class="col-md-3">
                				<div class="input-group">
                  					<div class="input-group-btn">
                    					<button type="button" style="width:100px" class="btn btn-success">SER. & NUM: </button>
                  					</div>
                  					<input type="text" class="form-control" id='deta_ser_num' readonly>
                				</div>
              				</div>
              				<div class="col-md-3">
                				<div class="input-group">
                  					<div class="input-group-btn">
                    					<button type="button" style="width:100px" class="btn btn-success">SUNAT: </button>
                  					</div>
                  					<input type="text" class="form-control" id='deta_sunat' readonly>
                				</div>
              				</div>
            			</div>
          			</div>
          			<div class="panel-body">
            			<h5 style="font-family:'Ubuntu'">CONCEPTOS: </h5><hr>
						<div class="row">
							<div class="col-md-12 table-responsive">
								<table id="notas_credito" class="table table-bordered table-striped">
									<thead>
										<tr role="row">
											<th>CONCEPTO</th>
											<th>DESCRIPCIÓN</th>
											<th>MONTO</th>
											<th>DESCUENTO</th>
											<th>RESTO</th>
										</tr>
									</thead>
									<tbody id='conceptos_nc'>
									</tbody>
								</table>
							</div>
						</div>
         			</div>
        		</div>
      		</div>
      		<div class="modal-footer">
        		<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4"></div>
					<div class="col-md-4 col-sm-4">
						<button type="button" class="btn btn-danger btn-sm" style="width:100%" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</button>
					</div>
        		</div>
      		</div>
    	</div>
  	</div>
</div>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/Waiting.min.js" type="text/javascript"></script>
<script>
	var servidor = "<?php echo $this->config->item('ip'); ?>";	
	var waitingDialog = waitingDialog || (function ($) { 'use strict';
	var $dialog = $('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;"><div class="modal-dialog modal-m"><div class="modal-content" style="border-radius:5px">' +
		'<div class="modal-header"><h3 style="margin:0;font-family:\'Ubuntu\'"></h3></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>');
		return { show: function (message, options) { if (typeof options === 'undefined') options = {}; if (typeof message === 'undefined') message = 'Cargando Recibos'; var settings = $.extend({ dialogSize: 'm', progressType: '', onHide: null  }, options);$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);$dialog.find('.progress-bar').attr('class', 'progress-bar');
		if (settings.progressType) $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType); $dialog.find('h3').text(message);
		if (typeof settings.onHide === 'function') { $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) { settings.onHide.call($dialog); }); } $dialog.modal();},hide: function () { $dialog.modal('hide'); }
	};})(jQuery);
	$('#notas_credito').DataTable({bFilter: false, bInfo: false,"bLengthChange": false,"bSort": false});

  	function cambio_tipo(){
    	val = $("#tipo").val();
    	if(val == 1 || val == 2 || val == 3 || val == 4 || val == 5){
      		$("#opt_documento").css('display','none')
      		$("#opt_srn_nro1").css('display','block')
      		$("#opt_srn_nro").css('display','block')
			if(val == 4 || val == 5){
				$("#serie").attr("type","text")
				$("#serie").attr("onkeypress","")
				$("#numero").attr("type","text")
				$("#numero").attr("onkeypress","")
			} else {
				$("#serie").attr("type","number")
				$("#serie").attr("onkeypress","return justNumbers(event);")
				$("#numero").attr("type","number")
				$("#numero").attr("onkeypress","return justNumbers(event);")
			}
		} else {
			$("#opt_documento").css('display','block')
			$("#opt_srn_nro1").css('display','none')
			$("#opt_srn_nro").css('display','none')
			if(val == 6){
				$("#tip-doc").html("DNI: ")
			} else {
				$("#tip-doc").html("RUC: ")
			}
    	}
		$("#serie").val("")
		$("#numero").val("")
		$("#documento").val("")
   	}

  	function buscar_nota_credito(){
    	val = $("#tipo").val();
    	serie = $("#serie").val();
    	numero = $("#numero").val();
    	documento = $("#documento").val();
    	if((serie != "" && numero != "") || documento != ""){
			waitingDialog.show('Buscando la(s) nota(s) de crédito ...', {dialogSize: 'lg', progressType: 'warning'});
        	$.ajax({
          		type : "POST",
          		url : servidor+"nota_credito/busqueda_nota_credito?ajax=true",
          		data : ({
            		'tipo' : val,
            		'serie' : serie,
            		'numero' : numero,
            		'documento' :documento
          		}),
          		cache : false,
          		dataType : 'json',
         	 	success : function(respuesta){
					waitingDialog.hide();
            		if(respuesta.result){
              			$("#notas_credito").dataTable().fnDestroy();
              			$("#notas_credito1").empty();
              			var tam = respuesta.notas.length;
              			var cuerpo = "";
              			for (var i = 0; i < tam; i++) {
                			cuerpo += `<tr>
                          				<td>${respuesta.notas[i]['BFNCATLET']} ${respuesta.notas[i]['BFNCASERNRO']}</td>
                          				<td>${respuesta.notas[i]['BFNCANRO']}</td>
                          				<td>${respuesta.notas[i]['SFACTURA_FSCSERNRO']}</td>
                          				<td>${respuesta.notas[i]['SFACTURA_FSCNRO']}</td>
                          				<td>${respuesta.notas[i]['BFNCASUNSERNRO']}</td>
                          				<td>${respuesta.notas[i]['BFNCASUNFACNRO']}</td>
                          				<td>${respuesta.notas[i]['BFNCAFECHEMI']}</td>
                          				<td style='text-align:right'>${parseFloat(respuesta.notas[i]['BFNCATOTDIF']).toFixed(2)}</td><td>`;
							if(respuesta.notas[i]['BFNCAESTSUN'] == 1) cuerpo += "<span class='badge bg-yellow'>EMITIDA</span>";
							else if(respuesta.notas[i]['BFNCAESTSUN'] == 3) cuerpo += "<span class='badge bg-green'>ACEPTADA</span>";
							else if(respuesta.notas[i]['BFNCAESTSUN'] == 4) cuerpo += "<span class='badge bg-red'>RECHAZADO</span>";
							else if(respuesta.notas[i]['BFNCAESTSUN'] == 5) cuerpo += "<span class='badge bg-gray'>OBSERVADO</span>";
                			else if($nota['BFNCAESTSUN'] == 6) cuerpo += "<span class='badge bg-orange'>NO ATENDIDO</span>";
                			cuerpo += "</td><td style='text-align:center'>";
                			cuerpo += "<a onclick=\"visualizar_detalle_nota_credito('"+respuesta.notas[i]['BFNCATIPO']+"','"+respuesta.notas[i]['BFNCATLET']+"',"+(parseInt(respuesta.notas[i]['BFNCASERNRO'])*958)+","+(parseInt(respuesta.notas[i]['BFNCANRO'])*235)+")\" class='btn btn-default' data-toggle='tooltip' data-placement='bottom' title='VISUALIZAR NOTA CRÉDITO'><i class='fa fa-eye'></i></a>"
                 			if (respuesta.notas[i]['BFSFACDIRARCHPDF']) cuerpo += "<a class='btn btn-default' data-toggle='tooltip' data-placement='bottom' title='IMPRIMIR NOTA CRÉDITO'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>"
                 			cuerpo += "</td></tr>";
              			}
              			$("#notas_credito1").append(cuerpo);
              			$('#notas_credito').DataTable({bFilter: false, bInfo: false,"bLengthChange": false,"bSort": false});
            		} else {
						alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>'+respuesta.mensaje+'</strong>');
            		}
          		}, error: function(jqXHR,textStatus,errorThrown){
            		_error(jqXHR, textStatus, errorThrown)
          		}
        	})
    	} else{
			if(val == 1 || val == 2 || val == 3 || val == 4 || val == 5){
				if(serie == "" && numero == ""){
					alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar la serie y numero del documento.</strong>');
				} else if (serie == ""){
					alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar la serie del documento.</strong>');
				} else if(numero == ""){
					alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar el numero del documento.</strong>');
				}
			} else if(val == 6) {
				alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar el dni de la persona.</strong>');
			} else {
				alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar el ruc de la persona.</strong>');
				swal("","DEBE RELLENAR EL RUC","warning")
			}
    	}
  	}

  	function obtener_autorizaciones(){
		waitingDialog.show('Buscando Autorizaciones...', {dialogSize: 'lg', progressType: 'warning'});
    	$.ajax({
			type : "POST",
			url : servidor+"nota_credito/get_autorizaciones?ajax=true",
			data : ({   }),
			cache : false,
			dataType : 'json',
			success :  function (data){
				waitingDialog.hide();
				if(data.result){
					$("#cuerpo2").empty()
					$("#cuerpo2").append(data.autorizacion)
					$("#Autorizaciones").modal('show')
				} else {
					alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>'+data.mensaje+'</strong>');
				}
      		}, error :  function (jqXHR,textStatus,errorThrown){
				_error(jqXHR, textStatus, errorThrown)
      		}
    	})
  	}

	function _error(jqXHR,textStatus,errorThrown){
		waitingDialog.hide();
		if (jqXHR.status === 0)  alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Verifique su conexión a Internet. No se ha podido conectar con el Servidor.</strong>');
		else if (jqXHR.status == 404) alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>El recurso solicitado no se puede encontrar, pero puede estar disponible en el futuro.</strong>');
		else if (jqXHR.status == 500) alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Se encontro un error interno en el servidor, intente en unos minutos.</strong>');
		else if (textStatus === 'parsererror') alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Hubo un error en el servidor, el recurso solicitado tiene unos pequeños problemas.</strong>');
		else if (textStatus === 'timeout') alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Tiempo de conexión agotado.</strong>');
		else if (textStatus === 'abort') alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Petición cancelada.</strong>');
		else alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Error desconocido: '+jqXHR.responseText+'</strong>');
	}

    function visualizar_detalle_nota_credito(tipo,letra,serie,numero){
		waitingDialog.show('Cargando la nota de crédito...', {dialogSize: 'lg', progressType: 'warning'});
      	$.ajax({
	        type : "POST",
        	url : servidor+"nota_credito/detalle_nota_credito?ajax=true",
        	data : ({
          		'tipo' : tipo,
          		'letra' : letra,
          		'serie' : serie,
          		'numero' : numero
        	}),
        	cache : false,
        	dataType : 'json',
        	success : function(data){
				waitingDialog.hide();
          		if(data.result){
            		$("#deta_serie").html(data.cabecera['BFNCATLET']+data.cabecera['BFNCASERNRO'])
            		$("#deta_numero").html(data.cabecera['BFNCANRO'])
            		$("#deta_cliente").val(data.cabecera['FSCCLINOMB'])
            		$("#deta_monta").val(parseFloat(data.cabecera['BFNCATOTDIF']).toFixed(2))
            		$("#deta_igv").val(parseFloat(data.cabecera['BFNCAIGVDIF']).toFixed(2))
            		$("#deta_sub_total").val(parseFloat(data.cabecera['BFNCASUBDIF']).toFixed(2))
            		$("#deta_sunat").val(data.cabecera['BFNCASUNSERNRO']+"-"+data.cabecera['BFNCASUNFACNRO'])
            		$("#deta_ser_num").val(data.cabecera['SFACTURA_FSCSERNRO']+"-"+data.cabecera['SFACTURA_FSCNRO'])
            		$("#conceptos_nc").empty()
            		$("#conceptos_nc").append(data.detalle)
            		$("#detalleNC").modal("show");
          		} else {
					alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>'+data.mensaje+'</strong>');
          		}
        	}, error :  function(jqXHR,textStatus,errorThrown){
				_error(jqXHR, textStatus, errorThrown)
        	}
      	})
    }

    function justNumbers(e){
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;

        return /\d/.test(String.fromCharCode(keynum));
    }

</script>
