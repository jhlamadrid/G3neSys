<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="panel panel-primary">
        		<div class="panel-heading">
          			<h4 style="font-family:'Ubuntu';font-weight:bold" class="text-white"> <i class="fa fa-universal-access"></i> AUTORIZACIÓN DE NOTAS DE CRÉDITO A RECIBOS</h4>
        		</div>
        		<div class="panel-body">
					<div class="row">
						<div class="col-md-3" style="margin-top:10px">
							<div class="input-group">
								<span class="input-group-addon">OFICINA</span>
								<input class="form-control" type="text" id='oficina' value="<?php echo  $_SESSION['OFICOD'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-3" style="margin-top:10px">
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
          			<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="notas_credito" class="table table-bordered table-striped" style="display:none">
								<thead>
									<tr role="row">
										<th>OPCION</th>
										<th>SERIE</th>
										<th>NUMERO</th>
										<th>SUMINISTRO</th>
										<th>F. EMISIÓN</th>
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
						<div class="col-md-4 col-sm-4" style="margin-top:10px">
							<div class="input-group" style="border: 1px solid green;">
								<span class="input-group-addon">VIGENCIA <span class="text-blue">*</span></span>
								<input type="text" class="form-control" id='vigencia' value="" disabled>
							</div>
						</div>
						<div class="col-md-4 col-sm-4" style="margin-top:10px">
							<div class="input-group" style="border: 1px solid green;">
								<span class="input-group-addon">GLOSA <span class="text-blue">**</span></span>
								<input type="text" class="form-control" id='gloasa' value="" disabled>
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
          			</div> <br>
					<div class="row">
						<div class="col-md-12">
							<small><span class="text-blue">(*) VIGENCIA: Seleccione la fecha máxima en la que se puede generar la nota de crédito</span></small><br>
							<small><span class="text-blue">(**) GLOSA:  Ingrese el motivo porque est autorizando la nota de crédito</span></small><br>
							<small><span class="text-blue">(***) USUARIO:  Seleccione el usuario al cual autorizara para que realice la nota de crédito</span></small>
						</div>
					</div>
          			<div class="row">
            			<div class="col-sm-4 col-sm-offset-8">
              				<a class="btn btn-success btn-md" style="width:100%" id='save_autorizacion' onclick='enviar_autorizacion()' >
								<i class="fa fa-spinner" aria-hidden="true"></i> Generar Autorización
							</a>
            			</div>
          			</div>
        		</div>
      		</div>
    	</div>
  	</div>
  	<div class="row">
    	<div class="col-md-12">
     		<div class="panel panel-danger">
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
										<th>SUMINISTRO</th>
										<th>VIGENCIA</th>
										<th>OPERADOR</th>
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
											<td><?php echo $aut['CLIUNICOD']; ?></td>
											<td><?php echo $aut['AUT_VIGFEC']; ?></td>
											<td><?php echo (($aut['NNOMBRE']) ? $aut['NNOMBRE'] : "CUALQUIERA"); ?></td>
											<td style="text-align:right"><?php echo $aut['AUT_SER']."-".$aut['AUT_REC']; ?></td>
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
<script type="text/javascript">
 	$('#autorizaciones').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
  	$("#tipo").change(function(){
    	var valor = $("#tipo").val()
    	if(valor == 1){
			$("#cuerpo_busqueda").empty();
			$("#cuerpo_busqueda").append(`<div class='col-md-12'>
											<div class="form-group">
												<label>Suministro: </label>
												<input type="text" style="border: 1px solid;" class="form-control" id="suministro" required="">
											</div>
											</div>`);
    	} else {
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
              			<input type="number" class="form-control" style="border: 1px solid;" onkeypress="return justNumbers(event);" id="numero" required="">
            		</div>
          		</div>
        	</div>`);
    	}
  	});

  	$("#buscar").click(function(){
    	var tipo = $("#tipo").val();
    	if($("#suministro").val() != "" || ($("#serie").val() != "" && $("#numero").val() != "")){
			waitingDialog.show('BUSCANDO DOCUMENTO...', {dialogSize: 'lg', progressType: 'warning'});
			$("#notas_credito").fadeOut();
			if(tipo == 1){
				data = ({tipo : tipo , suministro : $("#suministro").val()})
			} else {
				data = ({tipo : tipo, serie : $("#serie").val() , numero : $("#numero").val() })
			}
      		$.ajax({
				type: 'POST',
				url : '<?php echo $this->config->item('ip') ?>autorizacion/recibos/busqueda?ajax=true',
				data : data,
				cache : false,
				dataType : 'json',
				success :  function (data) {
          if(data.result){
            waitingDialog.hide();
            $("#notas_credito").dataTable().fnDestroy();
            $("#recibos").empty();
            $("#recibos").append(data.recibos);
            $('#notas_credito').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
            $("#notas_credito").fadeIn(300)
            $("#vigencia").attr('disabled',false)
            $("#gloasa").attr('disabled',false)
            $("#usuario").attr('disabled',false)
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
  })
  var recibos = new Array();
  function enviar_autorizacion(){
    recibos.length = 0;
    $(".chekeado").each(function(){
      if($(this).prop('checked')){
        data = ({
          serie: $(this).parent().parent().get(0).childNodes[1].textContent,
          numero : $(this).parent().parent().get(0).childNodes[2].textContent,
          suministro : $(this).parent().parent().get(0).childNodes[3].textContent
        })
        recibos.push(data);
      }
    });
    if(recibos.length > 0 && $("#vigencia").val() != "" && $("#gloasa").val() != ""){
      $("#save_autorizacion").attr('disabled',true)
      $("#save_autorizacion").attr('onclick','')
      waitingDialog.show('CREANDO AUTORIZACIONES...', {dialogSize: 'lg', progressType: 'warning'});
      $.ajax({
        type: 'POST',
        url : '<?php echo $this->config->item('ip') ?>autorizacion/recibos/autorizar_recibos?ajax=true',
        data : ({
           recibos : recibos,
           vigencia : $("#vigencia").val(),
           glosa : $("#gloasa").val(),
           usuario : $("#usuario").val()
         }),
        cache : false,
        dataType : 'json',
        success :  function (data) {
          if(data.result){
            waitingDialog.hide();
            swal("",data.mensaje,"success");
            location.reload();
          } else {
            waitingDialog.hide();
            swal("",data.mensaje,"warning");
            $("#save_autorizacion").attr('disabled',false)
            $("#save_autorizacion").attr('onclick','enviar_autorizacion')
          }
        }, error :  function (jqXHR,textStatus,errorThrown){
          waitingDialog.hide();
          $("#save_autorizacion").attr('disabled',false)
          $("#save_autorizacion").attr('onclick','enviar_autorizacion')
          swal("","HUBO UN ERROR EN EL SERVIDOR","error")
        }
      })
    } else {
      if(recibos.length <= 0){
        swal("","DEBE SELECCIONAR LOS RECIBOS QUE SE GENERAR NOTA DE CRÉDITO","warning")
      } else if($("#vigencia").val() == ""){
        swal("","DEBE SELECCIONAR LA FECHA DE VIGENCIA DE LA NOTA DE CRÉDITO","warning")
      } else if($("#gloasa").val() == ""){
        swal("","DEBE SELECCIONAR EL MOTIVO PORQUE SE EST AUTORIZANDO","warning")
      }
    }
  }

  $("#vigencia").focus(function() {
    $("#vigencia").datepicker({ language: 'es', autoclose: true,startDate:"1d"}).datepicker("show");
  });
  function justNumbers(e){
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46)) return true;
    return /\d/.test(String.fromCharCode(keynum));
  }

</script>
