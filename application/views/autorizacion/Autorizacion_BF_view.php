<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="panel panel-success">
        		<div class="panel-heading">
          			<h4 style="font-family:'Ubuntu';font-weight:bold" class="text-blue"> <i class="fa fa-universal-access"></i> AUTORIZACIÓN DE NOTAS DE CRÉDITO PARA BOLETAS Y FACTURAS</h4>
        		</div>
        		<div class="panel-body">
					<div class="row">
						<div class="col-md-3" style="margin-top:5px">
							<div class="input-group">
								<span class="input-group-addon">OFICINA</span>
								<input class="form-control" type="text" id='oficina' value="<?php echo  $_SESSION['OFICOD'] ?>" disabled>
							</div>
						</div>
            			<div class="col-md-3" style="margin-top:5px">
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
          			</div>
         			<div class="row">
            			<div class="col-md-12">
              				<h4 style="font-family:'Ubuntu'; margin-bottom:0px" class="text-blue"><i class="fa fa-search" aria-hidden="true"></i> BUSCAR FACTURA O BOLETA</h4>
							<small>Ingrese la serie y número interno de la Boleta o Factura</small>
            			</div>
          			</div>
          			<div class="row">
            			<div class="col-md-3 col-sm-3" id="opt_srn_nro">
              				<div class="form-group">
                				<label for="tipo">Tipo: </label>
                				<select class="form-control" name="tipo" id='tipo' style="border: 1px solid;">
                  					<option value="1">FACTURA</option>
                  					<option value="0">BOLETA</option>
                				</select>
              				</div>
            			</div>
            			<div class="col-md-3 col-sm-3" id="opt_srn_nro">
              				<div class="form-group">
                				<label for="serie">Serie: </label>
                				<input type="number" class="form-control" style="border: 1px solid;" onkeypress="return justNumbers(event);" id="serie" name="serie" required="">
              				</div>
            			</div>
						<div class="col-md-3 col-sm-3" id="opt_srn_nro">
							<div class="form-group">
								<label for="">Número: </label>
								<input type="number" class="form-control" style="border: 1px solid;" onkeypress="return justNumbers(event);" id="numero" name="numero" required="">
							</div>
						</div>
						<div class="col-md-3 col-sm-3" style="line-height: 4;">
							<div class="form-group">
								<a class="btn btn-primary btn-sm" style="margin-top:10px;width: 100%; " onclick="buscar_factura_boleta()"><i class="fa fa-search" aria-hidden="true" ></i> BUSCAR</a>
							</div>
						</div>
          			</div>
          			<div class="row">
            			<div class="col-md-12 table-responsive">
							<table id="notas_credito" class="table table-bordered table-striped" style="display:none">
								<thead>
									<tr role="row">
										<th>SERIE</th>
										<th>NUMERO</th>
										<th>DNI / RUC</th>
										<th>NOMBRE</th>
										<th>MONTO</th>
									</tr>
								</thead>
								<tbody id="factura">
                  				</tbody>
                			</table>
            			</div>
          			</div><br>
          			<div class="row">
            			<div class="col-md-4 col-sm-4" style="margin-top:10px">
							<div class="input-group" style="border: 1px solid green;">
								<span class="input-group-addon">VIGENCIA <span class="text-blue">*</span></span>
								<input class="form-control" type="text" id='vigencia' value="" disabled>
							</div>
            			</div>
						<div class="col-md-4 col-sm-4" style="margin-top:10px">
							<div class="input-group" style="border: 1px solid green;">
								<span class="input-group-addon">GLOSA <span class="text-blue">**</span></span>
								<input class="form-control" type="text" id='gloasa' value="" disabled>
							</div>
						</div>
						<div class="col-sm-4 col-md-4" style="margin-top:10px">
							<div class="input-group" style="border: 1px solid green;">
								<span class="input-group-addon">USUARIO <span class="text-blue">***</span></span>
								<select class="form-control" id="usuario" disabled="">
									<option value="0">CUALQUIER USUARIO</option>
									<?php foreach ($usuarios as $user) { ?>
										<option value="<?php echo $user['NCODIGO'] ?>"><?php echo $user['NNOMBRE'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
          			</div><br>
					<div class="row">
						<div class="col-md-12">
							<small><span class="text-blue">(*) VIGENCIA: Seleccione la fecha máxima en la que se puede generar la nota de crédito</span></small><br>
							<small><span class="text-blue">(**) GLOSA:  Ingrese el motivo porque est autorizando la nota de crédito</span></small><br>
							<small><span class="text-blue">(***) USUARIO:  Seleccione el usuario al cual autorizara para que realice la nota de crédito</span></small>
						</div>
					</div>
          			<div class="row">
            			<div class="col-sm-4 col-sm-offset-8">
              				<a class="btn btn-success btn-md" style="width:100%" onclick="guardar_autorizacion()"><i class="fa fa-spinner" aria-hidden="true"></i> Generar Autorización</a>
            			</div>
          			</div>
        		</div>
      		</div>
    	</div>
  	</div>
  	<div class="row">
    	<div class="col-md-12">
      		<div class="panel panel-warning">
        		<div class="panel-heading">
          			<h4 style="font-family:'Ubuntu';font-weight:bold" class="text-red"><i class="fa fa-list-ol" aria-hidden="true"></i> LISTA DE AUTORIZACIONES</h4>
        		</div>
        		<div class="panel-body">
          			<div class="row">
            			<div class="col-md-12 table-responsive">
                			<table id="autorizaciones" class="table table-bordered table-striped">
                  				<thead>
									<tr role="row">
										<th>NÚMERO</th>
										<th>FECHA</th>
										<th>HORA</th>
										<th>VIGENCIA</th>
										<th>OPERADOR</th>
										<th>TIPO DOCUMENTO</th>
										<th>SERIE NÚMERO</th>
										<th>ESTADO</th>
									</tr>
                  				</thead>
                  				<tbody id="autorizacion">
                    				<?php foreach ($autorizaciones as $aut) { ?>
                      					<tr>
                        					<td><?php echo $aut['AUT_NRO']; ?></td>
                        					<td><?php echo $aut['AUT_FEC']; ?></td>
                        					<td><?php echo $aut['AUT_HRA']; ?></td>
                        					<td><?php echo $aut['AUT_VIG']; ?></td>
                        					<td><?php echo (($aut['NNOMBRE']) ? $aut['NNOMBRE'] : "CUALQUIERA"); ?></td>
                        					<td><?php echo (($aut['AUT_TIPC'] == 0 ) ? 'BOLETA' : 'FACTURA'); ?></td>
                        					<td style="text-align:right"><?php echo $aut['AUT_NCASER']."-".$aut['AUT_NCANRO']; ?></td>
                        					<td style="text-align:center">
                          						<?php if($aut['AUT_EST'] == 2) { ?>
                          							<span class="badge bg-yellow">Pendiente</span>
                          						<?php } else if($aut['AUT_EST'] == 1) { ?>
                            						<span class="badge bg-green">Atendido</span>
                          						<?php } else {?>
                            						<span class="badge bg-red">Vencido</span>
                          						<?php } ?>
											</td>
                      					</tr>
                    				<?php } ?>
                  				</tbody>
                			</table>
            			</div>
          			</div>
        		</div>
      		</div>
    	</div>
  	</div>
</section>
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/Waiting.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>
<script type="text/javascript">
 	$('#autorizaciones').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
  	function buscar_factura_boleta(){
    	var serie = $("#serie").val();
    	var numero = $("#numero").val();
    	if(serie != "" && numero != ""){
        	waitingDialog.show('Buscando el documento...', {dialogSize: 'sm', progressType: 'warning'});
      		$("#notas_credito").fadeOut(100);
      		var val = $("#tipo").val()
      		$.ajax({
        		type:"POST",
        		url: "<?php echo $this->config->item('ip'); ?>autorizacion/buscar_factura_boleta?ajax=true",
        		data:({
          			'tipo' : val,
          			'serie' : serie,
          			'numero' : numero
        		}),
        		cache : false,
        		dataType : "json",
        		success :  function(data){
					waitingDialog.hide()
          			if(data.result){
            			if(parseFloat(data.monto)> 0){
              				if(data.autorizaciones){
                				$("#factura").empty();
                				$("#vigencia").attr("disabled",true)
                				$("#gloasa").attr("disabled",true)
                				$("#usuario").attr("disabled",true)
                				$("#vigencia").val("")
                				$("#gloasa").val("")
								$("#usuario").val("")
								alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>El docuemnto ya se encuentra con una autorización.</strong>');
              				} else {
                				$("#factura").empty();
                  				cuerpo = "<tr>"+
                            				"<td id='resp_serie'>"+data.resp['FSCSERNRO']+"</td>"+
                            				"<td id='resp_numero'>"+data.resp['FSCNRO']+"</td>"+
                            				"<td>"+((data.resp['FSCNRODOC']) ? "<b>DNI: </b>" : "<b>RUC: </b>")+((data.resp['FSCNRODOC']) ? data.resp['FSCNRODOC'] : data.resp['FSCCLIRUC'])+"</td>"+
                            				"<td>"+data.resp['FSCCLINOMB']+"</td>"+
                            				"<td>"+parseFloat(data.monto).toFixed(2)+"</td>"+
                            			"</tr>";
                				$("#factura").append(cuerpo);
                				$("#notas_credito").fadeIn(1000);
                				$("#vigencia").attr("disabled",false)
                				$("#gloasa").attr("disabled",false)
                				$("#usuario").attr("disabled",false)
              				}
            			} else {
              				$("#factura").empty();
              				$("#vigencia").attr("disabled",true)
              				$("#gloasa").attr("disabled",true)
              				$("#usuario").attr("disabled",true)
              				$("#vigencia").val("")
              				$("#gloasa").val("")
							$("#usuario").val("")
							alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>El docuemnto ya se encuentra anulado totalmente por una nota de crédito.</strong>');
            			}
          			} else {
						alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>'+data.mensaje+'</strong>');
            			$("#vigencia").attr("disabled",true)
            			$("#gloasa").attr("disabled",true)
						$("#usuario").attr("disabled",true)
            			$("#vigencia").val("")
            			$("#gloasa").val("")
            			$("#usuario").val("")
          			}	
        		}, error: function(jqXHR,textStatus,errorThrown){
					_error( jqXHR, textStatus,  errorThrown);
        		}
      		})
    	} else {
      		if(serie == "" && numero == ""){
				alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar la serie y número del documento.</strong>');
      		} else if(serie == ""){
				alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar la serie del documento.</strong>');
      		} else {
        		alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe rellenar el número del documento.</strong>');
      		}
    	}
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

  	function justNumbers(e){
      	var keynum = window.event ? window.event.keyCode : e.which;
      	if ((keynum == 8) || (keynum == 46))
      		return true;
      	return /\d/.test(String.fromCharCode(keynum));
    }

	$("#vigencia").focus(function() {
		$("#vigencia").datepicker({ language: 'es', autoclose: true,startDate:"+0d"}).datepicker("show");
	});

	function guardar_autorizacion(){
  		var vigencia = $("#vigencia").val();
  		var serie = $("#resp_serie").html();
  		var numero = $("#resp_numero").html();
  		if(vigencia != "" && serie != "" && numero != ""){
    		waitingDialog.show('Generando autorizacion...', {dialogSize: 'sm', progressType: 'warning'});
    		var glosa =  $("#gloasa").val();
    		var usuario = $("#usuario").val();
    		var tipo = $("#tipo").val();
    		$.ajax({
      			type : "POST",
      			url : "<?php echo $this->config->item('ip'); ?>autorizacion/registrar_autorizacion?ajax=true",
      			data : ({
        			'serie' : serie,
        			'numero' : numero,
        			'vigencia' : vigencia,
        			'glosa' :  glosa,
        			'usuario' : usuario,
        			'tipo' :  tipo
      			}),
      			cache : false,
      			dataType : "json",
      			success :  function(data){
					waitingDialog.hide()
        			if(data.result){
						alertify.alert('<span class="text-gren"><i class="fa fa-check-square-o" aria-hidden="true"></i> Ok</span>', '<strong>'+data.mensaje+'</strong>');
            			setTimeout(function(){  window.location.href = "<?php echo $this->config->item('ip').'autorizacion/boletas_facturas'; ?>"; }, 1000);
        			} else {
						alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>'+data.mensaje+'</strong>');
        			}
      			}, error :  function(jqXHR,textStatus,errorThrown){
					_error( jqXHR, textStatus,  errorThrown);
      			}
    		})
  		} else {
    		if(vigencia == "" && serie == undefined && numero == undefined){
				alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe buscar un documento y colocar una vigencia para poder generar una autorización</strong>');
    		} else if(serie == "" && numero == ""){
				alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe buscar un documento para poder generar una autorización</strong>');
    		} else if(vigencia == ""){
				alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe colocar una vigencia para poder generar una autorización</strong>');
    		}
  		}
	}
</script>
