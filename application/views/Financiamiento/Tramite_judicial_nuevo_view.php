<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- date-picker -->
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border borde_box">
					<div class="row">
						<div class="col-md-12">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; NUEVO SUMINISTRO EN TRAMITE JUDICIAL </h2>
						</div>
					</div>
			    </div>
                <div class="box-body">
                    <div class ="row">
                        <div class="col-md-12">
                            <div class="panel panel-danger"> 
                                <div class="panel-heading">
                                       CODIGO DE SUMINISTRO  
                                </div>
                                <div class="panel-body">
                                        <div class = "row">
                                            <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top:25px;">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="Codigo_Suministro">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <label for="email">Operación</label>
                                                    <button class="btn btn-primary form-control" id="Buscar_suministro">
                                                        BUSCAR
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <label for="email"></label>
                                                        <button class="btn btn-primary form-control" id="Limpiar_suministro">
                                                            LIMPIAR
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class= "col-md-12">
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    DATOS CATASTRALES DE USUARIO  
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="email">Codigo de Suministro</label>
                                                    <input type="text" class="form-control" id="suministro_cliente" placeholder="suministro" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <div class="form-group">
                                                    <label for="email">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre_cliente" placeholder="Nombre de cliente" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <div class="form-group">
                                                    <label for="email">Dirección</label>
                                                    <input type="text" class="form-control" id="direccion_cliente" placeholder="Dirección de cliente" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Localidad</label>
                                                    <input type="text" class="form-control" id="localidad_cliente" placeholder="Localidad" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Est. Cliente</label>
                                                    <input type="text" class="form-control" id="estado_cliente" placeholder="Estado de cliente" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Conex. Agua</label>
                                                    <input type="text" class="form-control" id="conexionAgua_cliente" placeholder="Conex. Agua" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Conex. Desague</label>
                                                    <input type="text" class="form-control" id="conexionDes_cliente" placeholder="Conex. Desague" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Tip. Ser.</label>
                                                    <input type="text" class="form-control" id="tipo_Servicio" placeholder="Tipo de Servicio" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Ciclo</label>
                                                    <input type="text" class="form-control" id="Ciclo_cliente" placeholder="Ciclo" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Tarifa</label>
                                                    <input type="text" class="form-control" id="tarifa_cliente"  readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Tip. Inmueble</label>
                                                    <input type="text" class="form-control" id="tipInmueble_cliente" placeholder="Tip. Inmueble" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Uso Inmueble</label>
                                                    <input type="text" class="form-control" id="usoInmueble_cliente" placeholder="Uso Inmueble" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-xs-4 ">
                                                <div class="form-group">
                                                    <label for="email">Abas. de Agua</label>
                                                    <input type="text" class="form-control" id="abasAgua_cliente" placeholder="Abs. Agua" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="email">Abas. de desague</label>
                                                    <input type="text" class="form-control" id="abasDesa_cliente" placeholder="Abs. Desague" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="email">Grupo</label>
                                                    <input type="text" class="form-control" id="grupo_cliente" placeholder="Grupo" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="email"> Sub-Grupo</label>
                                                    <input type="text" class="form-control" id="Subgrupo_cliente" placeholder="Sub-Grupo" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
					<div class="row">
                        <div class="col-md-12 col-sm-12" style="margin-top: 15px;" >
                            <button class = "btn btn-primary btn-flat pull-right" id="Agregar_suministro" style ="width:40%;" disabled="true">
                                INGRESAR
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var estado = 0;
    $(document).ready(function() {
        $("#Buscar_suministro").on("click", function(){
              validar_entrada();
        });
        $("#Codigo_Suministro").keypress(function(e) {
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        });
        $("#Limpiar_suministro").click(function(){
            swal({
                    title: "FINANCIAMIENTO",
                    text: "¿ Desea limpiar los campos ?",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonColor: "#296fb7",
                    confirmButtonText: "Aceptar",
                    showConfirmButton : true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                    }, function(valor){
                        window.location.replace('<?php echo $this->config->item('ip')."financiamiento/tramite_judicial/nuevo"?>');
                    });
        });
        $("#Agregar_suministro").click(function(){
    		//grabar_datos();
            alerta_registro();
    	});
    });

    function alerta_registro(){
        swal({
                title: "GRABAR SUMINISTRO JUDICIAL ",
                text: "¿ Esta seguro que desea grabar suministro en tramite judicial ?",
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#296fb7",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                            //showLoaderOnConfirm: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmLoadingButtonColor: true,
                }, function(isConfirm){
                    if(isConfirm) {
                        swal.disableButtons();
                        grabar_datos();                
                    }
            });
    }

    function grabar_datos(){
        $.ajax({
					type: "POST",
					url: "<?php echo $this->config->item('ip') ?>financiamiento/tramite_judicial/suministro_guardar?ajax=true",
					data: {	
                            suministro : $('#suministro_cliente').val(),
						    nombre: $('#nombre_cliente').val(),
                            direccion : $('#direccion_cliente').val(),
                            localidad : $('#localidad_cliente').val(),
                            estado_cliente : $('#estado_cliente').val(),
                            conex_agua : $('#conexionAgua_cliente').val(),
                            conex_desague : $('#conexionDes_cliente').val(),
                            tip_servicio : $('#tipo_Servicio').val(),
                            ciclo_cliente : $('#Ciclo_cliente').val(),
                            tarifa_cliente : $('#tarifa_cliente').val(),
                            tip_inmueble : $('#tipInmueble_cliente').val(),
                            uso_inmueble : $('#usoInmueble_cliente').val(),                            
                            abas_agua : $('#abasAgua_cliente').val(),
                            abas_desague : $('#abasDesa_cliente').val(),                            
                            grupo_cliente : $('#grupo_cliente').val(),
                            sub_grupo_cliente : $('#Subgrupo_cliente').val()
						},
					dataType: 'json',
					success: function(data) {
						if(data.result){
							swal({
                                    title: "Tramite Judicial",
                                    text: "Datos guardados correctamente " ,
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
						}else{
                            swal({
                                    title: "Tramite Judicial",
                                    text: data.Mensaje ,
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
							text: " OCURRIO UN ERROR EN EL SERVIDOR" ,
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
    function validar_entrada(){
		var entrada = $('#Codigo_Suministro').val();
        entrada = entrada.trim();
		if ( entrada.length == 7 || entrada.length == 11 ) {
			var i = 0;
			var bandera = 0;
			while(i < entrada.length){
				if( entrada.charCodeAt(i)<48 || entrada.charCodeAt(i) >= 58 ){
					bandera = 1 ; 
				}
				i++;
			}
			if (bandera == 0) {
				swal({
	              title: "Buscando Creditos",
	              text: "",
	              showConfirmButton: false
	            });
				$("#Codigo_Suministro").prop("readonly",true);
				$( "#Buscar_suministro" ).prop( "disabled", false );
				Buscar_suministro(entrada);
			}else{
				swal(
				  'Alerta !!',
				  'Codigo de suministro incorrecto ',
				  'error'
				);
			}
		}else{
			swal(
				  'Alerta !!',
				  'Codigo de suministro incorrecto ',
				  'error'
				);
		}
	}

    function limpia_simulacion(){
        //PARA LIMPIAR TABLA 
        table.clear().draw();
        $("#fecha_facturacion").val('');
        $("#fe_vencimiento").val('');
        $("#mont_sin_igv").prop('readonly', false);
        $("#nro_cuotas").prop('readonly', false);
        $("#btn_simular").prop('disabled', false);
        $("#btn_limpia_simulacion").prop('disabled', true);
        $("#btn_registrar").prop('disabled', true);
    }

    function Buscar_suministro(entrada){
		$.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/judicial/busca_suministro?ajax=true",
            data: {
            		suministro: entrada
            	  },
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {
                    if (data.tam == 7) {
                        
                            $('#nombre_cliente').val(data.nombre['CLINOMBRE']);
                            $('#direccion_cliente').val(data.detalle.DIRECCION);
                            $('#localidad_cliente').val(data.detalle.LOCALIDAD);
                            $('#estado_cliente').val(data.detalle.ESTADOCLI);
                            $('#conexionAgua_cliente').val(data.detalle.ESTADOCONXAG);
                            $('#conexionDes_cliente').val(data.detalle.CONDESDES);
                            $('#tipo_Servicio').val(data.detalle.TIPOSERVICIO);
                            $('#Ciclo_cliente').val(data.detalle.CICLO);
                            $('#tarifa_cliente').val(data.detalle.TARIFA);
                            $('#tipInmueble_cliente').val(data.detalle.TIPOINMUEBLE);
                            $('#usoInmueble_cliente').val(data.detalle.USOINMUEB);
                            $('#abasAgua_cliente').val(data.detalle.ABASTECAGUA);
                            $('#abasDesa_cliente').val(data.detalle.ABASTECDSG);
                            $('#grupo_cliente').val(data.detalle.GRUPO);
                            $('#Subgrupo_cliente').val(data.detalle.SUBGRUPO);
                            $('#suministro_cliente').val(data.detalle.CLICODFAC);
                            $('#Buscar_suministro').prop('disabled', true);
                            $('#Agregar_suministro').prop('disabled', false);
                            console.log(data.nombre);
                            console.log(data.detalle);
                            swal.close();
                       
                    			
                    }

                    if (data.tam == 11) {
                            $('#nombre_cliente').val(data.detalle.NOMBRE);
                            $('#direccion_cliente').val(data.detalle.DIRECCION);
                            $('#localidad_cliente').val(data.detalle.LOCALIDAD);
                            $('#estado_cliente').val(data.detalle.ESTADOCLI);
                            $('#conexionAgua_cliente').val(data.detalle.ESTADOCONXAG);
                            $('#conexionDes_cliente').val(data.detalle.CONDESDES);
                            $('#tipo_Servicio').val(data.detalle.TIPOSERVICIO);
                            $('#Ciclo_cliente').val(data.detalle.CICLO);
                            $('#tarifa_cliente').val(data.detalle.TARIFA);
                            $('#tipInmueble_cliente').val(data.detalle.TIPOINMUEBLE);
                            $('#usoInmueble_cliente').val(data.detalle.USOINMUEB);
                            $('#abasAgua_cliente').val(data.detalle.ABASTECAGUA);
                            $('#abasDesa_cliente').val(data.detalle.ABASTECDSG);
                            $('#grupo_cliente').val(data.detalle.GRUPO);
                            $('#Subgrupo_cliente').val(data.detalle.SUBGRUPO);
                            $('#suministro_cliente').val(data.detalle.CLICODFAC);
                            $('#Buscar_suministro').prop('disabled', true); 
                            $('#Agregar_suministro').prop('disabled', false);  
                            console.log(data.detalle);
                            swal.close();	
                    }

                }else{
                	swal.close();
                    
                    return false;
                }
            }
        });
	}
</script>