<style media="screen">
  .seleccionado {background:#e0e0e0;}
</style>
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="text-blue text-center" style="font-family: 'Ubuntu'">ADMINISTRACIÓN DE OPCIONES</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						ROL
						<select class="form-control" id='roles'>
							<option value='-1'>SELECCIONE UN ROL</option>
							<?php foreach ($roles as $rol) { ?>
							<option value="<?php echo $rol['ID_ROL']; ?>"><?php echo $rol['ROLDESC']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-5 col-sm-6 col-xs-12">
					<div class="form-group">
						ACTIVIDAD
						<select class="form-control" id='actividades'></select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="box box-primary" id='cuerpo_resultado' style="display: none">
		<div class='box-body'>
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
					<div class="table-container">
                  <ul class="list-group" id='lista_actividades'>
                  </ul>
                </div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
					<div class="table-container">
                  <ul class="list-group" id='lista_actividades1'>
                  </ul>
                </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"></div>
				<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
					<button type="button" class="btn btn-success btn-block" id='btn_save'><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; GUARDAR</button>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/Waiting.min.js"></script>
<script type="text/javascript">
var botones_agregar = new Array();
var botones_quitar = new Array();
	$("#roles").change(function(){
		$("#cuerpo_resultado").fadeOut();
		var val = $("#roles").val();
		if(val != -1){
			waitingDialog.show('Cargando Información...', {dialogSize: 'lg', progressType: 'warning'});
			$.ajax({
				type : 'POST',
				url : '<?php echo $this->config->item('ip'); ?>permisos/administrar_opciones/get_actividades?ajax=true',
				data : ({
					rol : val
				}), 
				cache :  false,
				dataType : 'json',
				success :  function(data){
					waitingDialog.hide()
					if(data.result){
						$("#actividades").empty();
						$("#actividades").append(data.actividades);
					} else {
						swal({title : "", text : data.mensaje, type : 'warning',html : true})
					}
				},
				error : function(jqXHR, textStatus,errorThrown){
					waitingDialog.hide()
					swal({title: "",text : "<b>ERROR<b/><br>OCURRIÓ UN ERROR EN EL SERVIDOR",type : 'error',html: true})
				}
			})
		} else {
			swal({title: "",text : "<b>ALERTA</b><br>DEBE SELECCIONAR UN ROL VALIDO",type: 'warning',html:true})
			("#actividades").empty();
		}
	})
	$("#actividades").change(function(){
		var val = $("#roles").val();
		var val1 = $("#actividades").val();
		console.log(val1);
		if(val != -1 && val1 != -1){
			waitingDialog.show('Cargando Información...', {dialogSize: 'lg', progressType: 'warning'});
			$("#cuerpo_resultado").fadeOut();
			$.ajax({
				type : 'POST',
				url : '<?php echo $this->config->item('ip'); ?>permisos/administrar_opciones/get_botones?ajax=true',
				data : ({
					rol : val,
					actividad : val1
				}), 
				cache :  false,
				dataType : 'json',
				success :  function(data){
					waitingDialog.hide()
					if(data.result){
						$("#lista_actividades").empty();
						$("#lista_actividades1").empty();
						$("#lista_actividades").append(data.lista1);
						$("#lista_actividades1").append(data.lista2);
						$("#cuerpo_resultado").fadeIn(500);
					} else {
						swal({title : "", text : data.mensaje, type : 'warning',html : true})
						$("#cuerpo_resultado").fadeOut();
					}
				},
				error : function(jqXHR, textStatus,errorThrown){
					$("#cuerpo_resultado").fadeOut();
					waitingDialog.hide()
					swal({title: "",text : "<b>ERROR<b/><br>OCURRIÓ UN ERROR EN EL SERVIDOR",type : 'error',html: true})
				}
			})
		} else {
			$("#lista_actividades").empty();
			$("#lista_actividades1").empty();
			$("#cuerpo_resultado").fadeOut();
			if(val == -1){
				swal({title: "",text : "<b>ALERTA</b><br>DEBE SELECCIONAR UN ROL VALIDO",type: 'warning',html:true})
			} else {
				swal({title: "",text : "<b>ALERTA</b><br>DEBE SELECCIONAR UNA ACTIVIDAD VALIDA",type: 'warning',html:true})
			}
		}	
	})

	function quitar (id){
		var indice = botones_agregar.indexOf(id);
		if(indice >= 0) botones_agregar.splice(indice,1)
		var indice1 = botones_quitar.indexOf(id);
 		if(indice >= 0) botones_quitar.splice(indice1,1)
 		else botones_quitar.push(id)
 		$("#lista_"+id).removeClass('seleccionado');
 		$("#asignar_"+id).html('SIN ASIGNAR');
 		$("#asignar_"+id).removeClass('text-green').addClass('text-red');
 		$("#btn_"+id).attr('onclick','agregar('+id+')')
 		$("#icono_"+id).attr('class','fa fa-plus')
	}

	function agregar(id){
		var indice = botones_quitar.indexOf(id);
		if(indice >= 0) botones_quitar.splice(indice,1)
		var indice1 = botones_agregar.indexOf(id);
 		if(indice >= 0) botones_agregar.splice(indice1,1)
 		else botones_agregar.push(id)
		$("#lista_"+id).addClass('seleccionado');
		$("#asignar_"+id).html('ASIGNADO');
		$("#asignar_"+id).removeClass('text-red').addClass('text-green');
		$("#btn_"+id).attr('onclick','quitar('+id+')')
		$("#icono_"+id).attr('class','fa fa-minus')
	}

	$("#btn_save").click(function(){
		if(botones_agregar.length > 0 || botones_quitar.length > 0){
			var text = "<h4 style='font-weight:bold;font-family:\"Ubuntu\"'>OPCIONES A AGREGAR</h4><ul style='margin-left: -40px;'>";
			console.log(botones_agregar.length)
			for (var i = 0; i < botones_agregar.length; i++) {
				text += "<li style='list-style: none;'>"+(i+1)+"- "+$("#nombre_"+botones_agregar[i]).text()+"</li>";
			}
			text += "</ul><h4 style='font-weight:bold;font-family:\"Ubuntu\"'>OPCIONES A QUITAR</h4><ul style='margin-left: -40px;'>"
			for (var i = 0; i < botones_quitar.length; i++) {
				console.log($("#nombre_"+botones_quitar[i]).text());
				text += "<li style='list-style: none;'>"+(i+1)+"- "+$("#nombre_"+botones_quitar[i]).text()+"</li>";	
			}
			text += "<ul>";			
			 swal({
              title: "<span style='fontt:family:\"Ubuntu\"'>¿Deseas actualizar el rol ?</span>",
              text: text,
              type: "warning",
              html: true,
              showCancelButton: true,
              closeOnConfirm: false,
              confirmButtonText: "SÍ!",
              showLoaderOnConfirm: true,
              confirmButtonColor: "#296fb7"
              }, function() {
              		$.ajax({
              			type : 'POST',
              			url : '<?php echo $this->config->item('ip'); ?>permisos/administrar_opciones/save_botones?ajax=true',
              			data : ({
              				agregar : botones_agregar,
              				quitar : botones_quitar,
              				rol : $("#roles").val(),
              				actividad : $("#actividades").val()
              			}),
              			cache :  false,
              			dataType : 'json',
              			success : function(data){
              				if(data.result){
              					swal({ title : "",text : data.mensaje, type : 'success', html: true })
              					setTimeout(
              						function(){
              							location.reload()
              						},
              					500);
              				} else {
              					swal({title: "",text : data.mensaje ,type : 'warning',html: true })
              				}
              			}, error :  function(jqXHR,textStatus,errorThrown){
              				swal({title: "",text : "<b>ERROR<b/><br>OCURRIÓ UN ERROR EN EL SERVIDOR",type : 'error',html: true})
              			}
              		})
              })
		} else {
			swal({title:'',text : '<b>ALERTA</b><br>DEBE AGREGAR O QUITAR ALGUNAS OPCIONES PARA EL PERFIL',type : 'warning',html : true})
		}
	})
</script>