<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>
<style>
	#psw:focus,
	#psw1:focus,
	#psw2:focus{
		border: 1px solid #008d4c;
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
	}
</style>
<section class="content">
  	<div class="box box-success">
    	<div class="box-header with-border">
      		<div class="row">
        		<div class="col-md-6 col-sm-6 col-sx-6">
         	 		<h4 class="text-red"><b>Tus datos personales</b></h4>
        		</div>
        		<div class="col-md-6 col-sm-6 col-sx-6" style="text-align:center">
         			<img  src="<?php echo $this->config->item('ip').$usuario['RUTIMAGEN']; ?>" alt="IMAGEN USUARIO" style="width:30%" class="img-responsive img-thumbnail">
        		</div>
      		</div>
    	</div>
    	<div class="box-body">
      		<div class="row">
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Nombre</b>
						<input type="text" value="<?php echo $usuario['NNOMBRE'] ?>" class="form-control" readonly>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Dirección</b>
						<input type="text" class="form-control" value="<?php echo $usuario['NDIRECC'] ?>" readonly>
					</div>
				</div>
     		</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Celular</b>
						<input type="text" name="" class="form-control" value="<?php echo $usuario['NTELEFO'] ?>" disabled="disabled">
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>D.N.I.</b>
						<input type="text" name="" class="form-control" value="<?php echo $usuario['NDNI'] ?>" disabled="disabled">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Login</b>
						<input type="text" class="form-control" name="" value="<?php echo $usuario['LOGIN'] ?>" disabled="disabled">
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Contraseña</b>
						<input type="text" class="form-control" name="" value="<?php echo $usuario['NCLAVE'] ?>" disabled="disabled">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Oficina</b>
						<input type="text" name="" class='form-control' value="<?php echo $_SESSION['OFICINA'] ?>" disabled="disabled">
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Área</b>
						<input type="text" name="" class="form-control" value="<?php echo $_SESSION['AREA'] ?>" disabled="disabled">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Fecha termino</b>
						<input type="text" class="form-control" name="" value="<?php echo $usuario['NENDS']; ?>" disabled="disabled">
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-sx-6">
					<div class="form-group">
						<b>Rol</b>
						<input type="text" class="form-control" name="" value="<?php echo $rol ?>" disabled="disabled">
					</div>
				</div>
			</div><br>
      		<div class="row">
        		<div class="col-md-6 col-sx-6 col-sm-6">
        		</div>
				<div class="col-dm-6 col-sm-6 col-sx-6">
					<a class="btn btn-info btn-md" style="width:100%" id='btn_cambiar_psw'><i class="fa fa-key" aria-hidden="true"></i> &nbsp;&nbsp; Cambiar contraseña</a>
				</div>
      		</div>
    	</div>
  	</div>
</section>
<div id="cambiar" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content" style="border-radius:5px">
      		<div class="modal-header bg-info" style="border-radius:5px">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-family:'Ubuntu'"><i class="fa fa-key"></i> &nbsp; Cambiar contraseña</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
          			<div class="col-md-2 col-sm-2 col-sx-2"></div>
          			<div class="col-md-8 col-sm-8 col-sx-8">
            			<div class="form-group">
							<b class="text-green">Contraseña antigua</b><br>
							<small>Ingrese su contraseña antigua</small>
							<div class="input-group">
								<span class="input-group-addon bg-green" style="border:none;border-radius: 4px 0px 0px 4px;"><i class="fa fa-key" aria-hidden="true"></i></span>
								<input type="password" id="psw" class="form-control" placeholder="contraseña" style="border-radius: 0px 4px 4px 0px;">
							</div>
            			</div>
          			</div>
        		</div>
				<div class="row">
					<div class="col-md-2 col-sm-2 col-sx-2"></div>
					<div class="col-md-8 col-sm-8 col-sx-8">
						<div class="form-group">
							<b class="text-green">Contraseña nueva</b><br>
							<small>Debe contener un minimo de 8 caracteres</small>
							<div class="input-group">
								<span class="input-group-addon bg-green" style="border:none;border-radius: 4px 0px 0px 4px;"><i class="fa fa-key" aria-hidden="true"></i></span>
								<input type="password" id="psw1" class="form-control" placeholder="contraseña" style="border-radius: 0px 4px 4px 0px;">
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-sx-2">
						<i style="display: none;margin-top: 45px;" id='verificar1' class="fa fa-times" aria-hidden="true"></i>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-sm-2 col-sx-2"></div>
					<div class="col-md-8 col-sm-8 col-sx-8">
						<div class="form-group">
							<b class="text-green">Repetir contraseña nueva</b><br>
							<small>Ingrese nuevamente su nueva contraseña</small>
							<div class="input-group">
								<span class="input-group-addon bg-green" style="color:#FFF;border:none;border-radius: 4px 0px 0px 4px;"><i class="fa fa-key" aria-hidden="true"></i></span>
								<input type="password" id="psw2" class="form-control" placeholder="contraseña" style="border-radius: 0px 4px 4px 0px;">
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-sx-2">
						<i style="display: none;margin-top: 45px;" id='verificar2' class="fa fa-times" aria-hidden="true"></i>
					</div>
				</div>
      		</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-sx-4">
						<button type="button" class="btn btn-danger btn-sm" style="width:100%" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
					</div>
					<div class="col-md-4 col-sm-4 col-sx-4"></div>
					<div class="col-md-4 col-sm-4 col-sx-4">
						<button type="button" class="btn btn-success btn-sm" style="width:100%" id='btn_save' ><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
					</div>
				</div>
			</div>
    	</div>
  	</div>
</div>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>
<script type="text/javascript">
  	$("#btn_cambiar_psw").click(function(){
    	$("#cambiar").modal({backdrop: 'static', keyboard: false,show : 'show'});
  	})


$("#psw1").keyup(function(){
    var val = $("#psw1").val();
    if(val.length < 8 || val == $("#psw").val()){
		$("#verificar1").css('color','#F00')
		$("#verificar1").attr('class', 'fa fa-times');
		$("#verificar1").css('display','block')
    } else {
		$("#verificar1").css('color','#0F0')
		$("#verificar1").attr('class', 'fa fa-check');
		$("#verificar1").css('display','block')
    }
})

$("#psw2").keyup(function(){
    var val = $("#psw2").val();
    var val1 = $("#psw1").val();
    if(val != val1){
		$("#verificar2").css('color','#F00')
		$("#verificar2").attr('class', 'fa fa-times');
		$("#verificar2").css('display','block')
    } else {
		$("#verificar2").css('color','#0F0')
		$("#verificar2").attr('class', 'fa fa-check');
		$("#verificar2").css('display','block')
    }
})


$("#btn_save").click(function(){
  	if ( $("#verificar1").hasClass('fa fa-check') && $("#verificar2").hasClass('fa fa-check')){
    	$.ajax({
			type : 'post',
			url : '<?php echo $this->config->item("ip"); ?>update_psw?ajax=true',
			data : ({
				'psw' : $("#psw").val(),
				'new' : $("#psw1").val(),
				'usuario' : '<?php echo $usuario["NCODIGO"]; ?>'
			}),
			cache :  false,
			dataType : 'json',
			success : function(data){
				if(data.result){
					alertify.alert('<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i> Ok!</span>', '<strong>'+data.mensaje+'</strong>');
					setTimeout(function(){
						location.assign('<?php echo $this->config->item('ip')."inicio"; ?>');
					},500)
				} else {
          			swal({title : "",text : data.mensaje, type:"warning",html:true})
        		}
			}, error :  function(jqXHR,textStatus,errorThrown){
				_error(jqXHR, textStatus, errorThrown);
			}
    	})
  	} else {
		if(!$("#verificar").hasClass('fa fa-check')){
			alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe ingresar su contraseña antigua.</strong>');
		} else if(!$("#verificar1").hasClass('fa fa-check')){
			alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>La contraseña debe contener mínimo 8 caracteres.</strong>');
		} else if(!$("#verificar2").hasClass('fa fa-check')){
			alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>Las contraseñas nuevas deben de coincidir.</strong>');
		}
  	}
})

function _error(jqXHR,textStatus,errorThrown){
    waitingDialog.hide(); 
    if (jqXHR.status === 0)  
      alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Verifique su conexión a internet, o verifique su sesión de usuario.</strong>');
    else if (jqXHR.status == 404) 
      alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>El recursos solicitado no se puede encontrar, pero puede estar disponible en el futuro.</strong>');
    else if (jqXHR.status == 500) 
      alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Ocurrió un error interno en el servidor, comuniquese con soporte del sistema.</strong>');
    else if (textStatus === 'parsererror')
      alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Hubo un error interno, intente en unos minutos.</strong>');
    else if (textStatus === 'timeout')
      alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>El tiempo de conexión ha finalizado.</strong>');
    else if (textStatus === 'abort') 
      alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>El recurso solicitado ha sido cancelado.</strong>');
    else 
      alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Error desconocido: '+jqXHR.responseText+'.</strong>');
}

</script>
