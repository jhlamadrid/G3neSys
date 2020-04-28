<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>/frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip');?>frontend/dist/js/tinymce.min.js"></script>


<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
          <div class="col-md-12 text-blue" style="font-size: 24px; text-align: center">
            <label>Formulario de Respuesta</label>
          </div>
			</div>
		</div>
	</div>
  <div class="box box-success">
    <div class="box-header with-border">
      <span class="text-warning text-uppercase" style="font-size:1.25em">Sugerencia / Consulta del Cliente</span>
    </div>
    <div class="box-body">
      <div class="input-group">
        <div class="input-group-addon bg-blue" >Nombre</div>
        <input type="text" class="form-control" id="nombre_cliente" value="<?php echo $usr_sugerencia['PTGTTICK_APELLIDOS'].", ".$usr_sugerencia["PTGTTICK_NOMBRES"] ?>" placeholder="Amount" disabled="">
      </div><br>
      <div class="form-group">
        <label for="inputDestinario" class="col-sm-2 control-label" >Mensaje</label>
        <div class="col-sm-10">
          <textarea class="form-control" rows="3" disabled><?php echo $usr_sugerencia['PTGTTICK_ASUNTO']; ?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="box box-success">
    <div class="box-body">
	   <div class="row">
    		<div class="col-xs-12 col-md-12">
    			<div class="row">
    				<div class="col-xs-12">
    					<?php if (isset($_SESSION['mensaje'])) { ?>
    						<script>
    							swal("!Mensaje¡", "<?php echo $_SESSION['mensaje'][1]; ?>" , "<?php echo $_SESSION['mensaje'][0]; ?>");
    						</script>
    					<?php } ?>
    					<form class="form-horizontal" method="post" enctype="multipart/form-data">
    					<div class="form-group">
    						<label for="inputDestinario" class="col-sm-2 control-label">Destinario</label>
    						<div class="col-sm-10">
    						  <input type="email" class="form-control" name="inputDestinario1" value="<?php echo $usr_sugerencia['PTGTTICK_EMAIL'] ?>" disabled required>
    						</div>
    					</div>
    					 <div class="form-group">
    					 	<label for="inputRemitente" class="col-sm-2 control-label">Remitente</label>
    					 	<div class="col-sm-10">
    					 		<input type="email" class="form-control" name="inputRemitente" value="soporte@sedalib.com.pe" disabled required>
    					 	</div>
    					 </div>
    					 <div class="form-group">
    					 	<label for="inputMotivo" class="col-sm-2 control-label">Motivo</label>
    					 	<div class="col-sm-10">
    					 		<input type="text" class="form-control" name="inputMotivo">
    					 	</div>
    					 </div>
    					 <div class="form-group">
    					     <label class="col-sm-2 control-label">Archivo Adjunto</label>
    					     <div class="col-sm-10">
    					         <input type="file" name="archivo" class="form-control" />
    					     </div>
    					 </div>
    					 <div class="form-group">
    					 	<label for="inputMensaje" class="col-sm-2 control-label">Mensaje</label>
    					 	<div class="col-sm-10">
    					 		<textarea name="text_manesaje1" id="text_mensaje" height="400px">
    					 		<img src="http://pekin.sedalib.com.pe:90/logo.png" width="200px">
    					 		<br>
    					 		<br>
    					 		<span>Estimado Cliente de Sedalib</span><br>
    					 		<span>Sr.(a) : </span> <span><?php echo $usr_sugerencia['PTGTTICK_APELLIDOS'].", ".$usr_sugerencia["PTGTTICK_NOMBRES"] ?></span>
    					 		<br><br><br><br><br><br><br><br><br><br><br><br>
    					 			<hr style="background:#296fb7;border:none;height:1px">
    					 			<h6 style="margin-top: 5px;color:#000 !important;font-family:'Comic Sans MS', cursive, sans-serif">Subgerencia de Información y al Cliente</h6>
    					 			<h6 style="margin-top: -10px;color:#000 !important;font-family:'Comic Sans MS', cursive, sans-serif">SEDALIB S.A&copy; - Derechos Reservados - 2017</h6>
    					 		</textarea>
    					 	</div>
    					 </div>
    					 <div class="for-group">
    					 	<div class="col-sm-3"></div>
    					 	<div class="col-sm-6">
    					 		<button type="submit" class="btn btn-success btn-block btn-flat" value="Enviar" onclick="enviar_correo()">Enviar</button>
    					 	</div>
    					 </div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
  </div>
</section>


<script>
tinymce.init({
	selector: '#text_mensaje',
		height: 400,
		plugins: [
	'advlist autolink autosave lists link image charmap print preview anchor',
	'searchreplace visualblocks code fullscreen',
	'insertdatetime media table contextmenu paste code textcolor colorpicker textpattern'
		],
		toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncentalignright alignjustify |  styleselect formatselect fontselect fontsizeselect | bullist numlist outdent indent | link image | forecolor backcolor',
		content_css: [
	'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
	'//www.tinymce.com/css/codepen.min.css'
		]
});


enviar_correo = function(){
  swal({
      title: '<i>ENVIANDO CORREO</i>',
      type: 'info',
      text:
        '<img src="<?php echo $this->config->item('ip'); ?>img/ring.gif"><br>El correo se está enviando espere un momento por favor.',
			html: true
    })
}
</script>
