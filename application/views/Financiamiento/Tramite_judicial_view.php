<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- date-picker -->
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>

<style>
    .modal-header, h5, .close {
      background-color: #3C8DBC;
      color:white !important;
      text-align: center;
      font-size: 20px;
	  }
	.modal-footer {
	      background-color:#3C8DBC;
	  }
</style>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border borde_box">
					<div class="row">
						<div class="col-md-12">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; SUMINISTROS QUE SE ENCUENTRAN EN PROCESO JUDICIAL</h2>
						</div>
					</div>
				</div>
				<div class="box-body">
                    
                    <div class = "row">
                        <div class= "col-md-12">
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    FILTROS
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12" style="margin-top: 15px;" >
                                            <button class = "btn btn-primary btn-lg btn-flat pull-right" id="Agregar_suministro">
                                                Agregar Nuevo Suministro
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12" style="margin-top: 15px;" >
                                            <label>FECHA INICIO</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                                <input type="text" class="form-control" id="NSUM-INI" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12" style="margin-top: 15px;" >
                                            <label>FECHA FIN</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                                    <input type="text" class="form-control" id="NSUM-FIN" readonly>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 15px;" >
                            <table class=' table display' id='reporte'>
                                <thead>
                                    <th>Item</th>
                                    <th>Cod. Suministro</th>
                                    <th>Nombre</th>
                                    <th>Localidad</th>
                                    <th>Est. Cliente</th>
                                    <th>Fech. Registro</th>
                                    <th>Fech. Modificado</th>
                                    <th>Est. Judicial</th>
                                    <th>Opción</th>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>            
				</div>
			</div>
		</div>
	</div>
</section>


<!-- MODAL EDITAR -->
<div class="modal fade" id="JudicialEdit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">EDITAR ESTADO JUDICIAL</h5>
      </div>
      <div class="modal-body">
            <div class = "row">
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <div class="form-group">
                        <label for="email">Nombre</label>
                        <input type="text" class="form-control" id="nombre_cliente" placeholder="Nombre de cliente" readonly="readonly">
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label for="email">Estado Cliente</label>
                        <input type="text" class="form-control" id="estado_cliente" placeholder="Ciclo de cliente" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="email">Codigo de Suministro</label>
                        <input type="text" class="form-control" id="suministro_cliente" placeholder="Suministro" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label for="email">Fecha registro</label>
                        <input type="text" class="form-control" id="Fregistro_cliente" placeholder="Fecha registro" readonly="readonly">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label for="email">Fecha Ultima Modifiacación</label>
                        <input type="text" class="form-control" id="Fmodificacion_cliente" placeholder="Fecha edición" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="email">Estado Judicial</label>
                        <input type="text" class="form-control" id="estado_juridico_cliente" placeholder="Estado" readonly="readonly">
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" title="" id="Gardar_tramite_judicial">Guardar</button>
        <button type="button" class="btn btn-danger" title=""  onclick="close_modal()">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DEL MODAL EDITAR-->

<script type="text/javascript">

    <?php $mxd = date("d-m-Y"); ?>
    <?php 
          $mnd = strtotime ( '-2 day' , strtotime ( $mxd ) ) ;
          $mnd = date ( 'd-m-Y' , $mnd );
    ?>
    var hoy = '<?php echo $mxd; ?>';
    var max = hoy;
    var min = '<?php echo $mnd; ?>';
    var table = null;
    var estado  = 1;
    var data;
    $(document).ready(function() {
        
        table = $('#reporte').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
        
        $("#NSUM-INI").inputmask("d-m-y");
        $("#NSUM-INI").val(min);

        $("#NSUM-FIN").inputmask("d-m-y");
        $("#NSUM-FIN").val(max);

        $('#NSUM-FIN').daterangepicker({
            "showDropdowns": true,
            "autoApply": true,
            "timePickerIncrement": 1,
            "singleDatePicker": true,
            "timePicker": false,
            "timePicker12Hour": false,
            "timePicker24Hour": false,
            "timePickerSeconds": false,
            "autoclose": true,
            "format": "DD-MM-YYYY",
            "startDate": hoy,
            //"minDate": convert_dmy(get_date(min)),
            "maxDate" : hoy,
            "locale": {
                "format": "DD-MM-YYYY HH:mm:ss",
                "separator": " - ",
                "applyLabel": "Aceptar",
                "cancelLabel": "Cancelar",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "autoclose": true,
                "daysOfWeek": [
                    "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"
                ],
                "monthNames": [
                    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ],
                "firstDay": 1
            }//,
            //onSelect: function() {  alert("dd"); }
        });

        $('#NSUM-INI').daterangepicker({
            "showDropdowns": true,
            "autoApply": true,
            "timePickerIncrement": 1,
            "singleDatePicker": true,
            "timePicker": false,
            "timePicker12Hour": false,
            "timePicker24Hour": false,
            "timePickerSeconds": false,
            "autoclose": true,
            "format": "DD-MM-YYYY",
            "startDate": min,
            "maxDate": hoy,
            //"maxDate" : convert_dmy(sumar_date(get_date(max), (-1*24*60*1000))),
            "locale": {
                "format": "DD-MM-YYYY",
                "separator": " - ",
                "applyLabel": "Aceptar",
                "cancelLabel": "Cancelar",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "autoclose": true,
                "daysOfWeek": [
                    "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"
                ],
                "monthNames": [
                    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ],
                "firstDay": 1
            }//,
            //onSelect: function() {  alert("dd"); }
        });

        $("#NSUM-INI").change(function(){
        	if (estado ==1) {
        		
	            suministros_judiciales();
                
        	}
            
        });

        $("#NSUM-FIN").change(function(){
            if (estado ==1) {
        		
	            suministros_judiciales();
        	}
        });

        $("#Agregar_suministro").on("click", function(){
            window.location.replace('<?php echo $this->config->item('ip')."financiamiento/tramite_judicial/nuevo"?>');
        });

        $("#Gardar_tramite_judicial").on("click", function(){
            guardar_edicion();
        });

        suministros_judiciales();
    });

    function guardar_edicion(){
        $.ajax({
					type: "POST",
					url: "<?php echo $this->config->item('ip') ?>financiamiento/tramite_judicial/suministro_guardo_edicion?ajax=true",
					data: {	
						    suministro: $("#suministro_cliente").val(),
                            estado : $("#estado_juridico_cliente").val()
						},
					dataType: 'json',
					success: function(data) {
						if(data.result){
							swal({
                                title: "Tramite Judicial",
                                text: "Edición guardada correctamente" ,
                                type: "info",
                                showCancelButton: false,
                                closeOnConfirm: true,
                                confirmButtonColor: "#296fb7",
                                confirmButtonText: "Aceptar",
                                showConfirmButton : true,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            },function(valor){
                                window.location.replace('<?php echo $this->config->item('ip')."financiamiento/tramite_judicial"?>');
                        });
						}
					},
					error: function(data){
						swal({
							title: "Tramite Judicial",
							text: " NO SE PUDO EDITAR " ,
							type: "error",
							showCancelButton: false,
							closeOnConfirm: true,
							confirmButtonColor: "#296fb7",
							confirmButtonText: "Aceptar",
							showConfirmButton : true,
							allowOutsideClick: false,
							allowEscapeKey: false,
						}, function(valor){
							console.log("error de grabado en servidor");
						});
						
					}

		});
    }

    function suministros_judiciales(){
        swal({
	              title: "Buscando Suministros ...",
	              text: "",
	              showConfirmButton: false
	    });
        var fecha_inicio =  $("#NSUM-INI").val();
        var fecha_fin = $("#NSUM-FIN").val();
        $.ajax({
					type: "POST",
					url: "<?php echo $this->config->item('ip') ?>financiamiento/tramite_judicial/suministros?ajax=true",
					data: {	
						    f_inicio: fecha_inicio, 
							f_fin: fecha_fin
						},
					dataType: 'json',
					success: function(data) {
						if(data.result) {
                            console.log(data.respuesta);
							table.clear().draw();
                            
                            for(var i=0; i<data.respuesta.length;i++){
                                var descripcion= "";
                                if(data.respuesta[i]['ESTJUDICIAL']== 1){
                                    descripcion = descripcion +"<span class='label label-danger' > EN TRAMITE</span>"; 
                                }else{
                                    descripcion = descripcion +"<span class='label label-success' >TRAMITE LEVANTADO</span>";
                                }
                                var suministro = data.respuesta[i]['CLICODFAC'];
                                table.row.add( [ 
                                    i+1,
                                    data.respuesta[i]['CLICODFAC'],
                                    data.respuesta[i]['CLINOMBRE'],
                                    data.respuesta[i]['CLILOCALI'],
                                    data.respuesta[i]['CLIESTA'],
                                    data.respuesta[i]['FECHREG'],
                                    data.respuesta[i]['FECHUPD'],
                                    descripcion,
                                    "<button class='btn btn-primary' onclick='open_modal(\""+suministro+"\")'> <i class='fa fa-edit'></i> </button>"
                                   
                                ] ).draw(false);
                                console.log(suministro);
                            }
                            swal.close();

						}else{
                            table.clear().draw();
                            swal.close();
                        }
                        /*else{
                            swal({
                                    title: "Tramite Judicial",
                                    text: "No se encontraron suministros que esten en tramite judicial en este periodo de tiempo " ,
                                    type: "error",
                                    showCancelButton: false,
                                    closeOnConfirm: true,
                                    confirmButtonColor: "#296fb7",
                                    confirmButtonText: "Aceptar",
                                    showConfirmButton : true,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                }, function(valor){
                                    table.clear().draw();
                                    swal.close();
							});     
						}*/
					},
					error: function(data){
						swal({
							title: "Tramite Judicial",
							text: "OCURRIO UN PROBLEMA EN EL SERVIDOR " ,
							type: "error",
							showCancelButton: false,
							closeOnConfirm: true,
							confirmButtonColor: "#296fb7",
							confirmButtonText: "Aceptar",
							showConfirmButton : true,
							allowOutsideClick: false,
							allowEscapeKey: false,
						}, function(valor){
							console.log("error de grabado en servidor");
						});
						
					}

		});
    }
    function open_modal(codigo){
        console.log(codigo);
        $.ajax({
					type: "POST",
					url: "<?php echo $this->config->item('ip') ?>financiamiento/tramite_judicial/suministro_editar?ajax=true",
					data: {	
						    suministro: codigo
						},
					dataType: 'json',
					success: function(data) {
						if(data.result){
							console.log(data.respuesta);
                            $("#nombre_cliente").val(data.respuesta[0]['CLINOMBRE']);
                            $("#estado_cliente").val(data.respuesta[0]['CLIESTA']);
                            $("#suministro_cliente").val(data.respuesta[0]['CLICODFAC']);
                            $("#Fregistro_cliente").val(data.respuesta[0]['FECHREG']);
                            $("#Fmodificacion_cliente").val(data.respuesta[0]['FECHUPD']);
                            if(data.respuesta[0]['ESTJUDICIAL'] == 1){
                                //levantar tramite
                                $('#Gardar_tramite_judicial').removeClass("btn-info").addClass("btn-warning");
                                $("#Gardar_tramite_judicial").text('LEVANTAR TRAMITE');
                                $("#estado_juridico_cliente").val("EN TRAMITE");
                            }else{
                                $('#Gardar_tramite_judicial').removeClass("btn-warning").addClass("btn-info");
                                $("#Gardar_tramite_judicial").text('INICIAR TRAMITE');
                                $("#estado_juridico_cliente").val("TRAMITE LEVANTADO");
                            }
                            
                            $('#JudicialEdit').modal("show");
						}else{
                            swal({
                                    title: "Tramite Judicial",
                                    text: "No se encontraron suministros que esten en tramite judicial en este periodo de tiempo" ,
                                    type: "error",
                                    showCancelButton: false,
                                    closeOnConfirm: true,
                                    confirmButtonColor: "#296fb7",
                                    confirmButtonText: "Aceptar",
                                    showConfirmButton : true,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                },function(valor){
								
							});     
						}
					},
					error: function(data){
						swal({
							title: "Tramite Judicial",
							text: " NO SE PUDO EDITAR " ,
							type: "error",
							showCancelButton: false,
							closeOnConfirm: true,
							confirmButtonColor: "#296fb7",
							confirmButtonText: "Aceptar",
							showConfirmButton : true,
							allowOutsideClick: false,
							allowEscapeKey: false,
						}, function(valor){
							console.log("error de grabado en servidor");
						});
						
					}

		});
        
    }

    function close_modal(){
        $('#JudicialEdit').modal("hide");
    }
</script>