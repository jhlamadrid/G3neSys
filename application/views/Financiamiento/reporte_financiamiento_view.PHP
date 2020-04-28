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
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<style type="text/css">
    .gallery
    {
        display: inline-block;
        margin-top: 20px;
    }
</style>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border borde_box">
					<div class="row">
						<div class="col-md-5">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; REPORTE DE FINANCIAMIENTOS</h2>
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6 col-sm-6 col-xs-6" style = "margin-top:25px;">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="Codigo_Suministro">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <label for="email">Operación</label>
                                                    <button class="btn btn-primary form-control" id="Buscar_suministro">
                                                        VALIDA CLIENTE
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
                    </div>
                    <div class = "row">
                        <div class= "col-md-12">
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    DATOS CATASTRALES DE USUARIO  
                                </div>
                                <div class="panel-body">
                                    <div class="row" >
										<div class= "col-md-6 col-md-offset-6">
											<a class= "btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" style="width:100%" id='ocult_most' >
											OCULTAR DATOS 
											</a>
										</div>
									</div>
                                    <div class="row collapse in"  id="collapseExample">
                                        <div class="col-md-7" style="margin-top:15px;">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            SUMINISTRO
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="COD_SUMINISTRO" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            NOMBRE
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="NOMBRE" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            DIRECCIÓN
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="Direccion" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            CICLO
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="Ciclo" value="" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5" style="margin-top:15px;">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            FECHA
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="Direccion" value="<?php echo date('d/m/Y'); ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            OPERADOR
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="Direccion" value="<?php echo $_SESSION['user_nom']; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            OFICINA
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="Direccion" value=" <?php echo $_SESSION['OFICOD']; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                            AGENCIA
                                                            </button>
                                                        </div>
                                                                <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="Direccion" value="<?php  echo $_SESSION['OFIAGECOD']; ?>" disabled>
                                                    </div>
                                                </div>
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
                                    FILTROS  
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <div class="col-md-4 col-sm-12" >
                                                <label>FECHA INICIO</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="NSUM-INI" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <label>FECHA FIN</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="NSUM-FIN" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <label>TIPO CONVENIO</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                    </span>
                                                    <select class="form-control" id="tipo_deuda">
                                                        <option value="Z">Deuda Recibo</option>
                                                        <option value="Y">Colateral</option>
                                                    </select>
                                                </div>
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
                                    <th>item</th>
                                    <th>Oficina</th>
                                    <th>Agencia</th>
                                    <th>Credito</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Tipo</th>
                                    <th>Inicial</th>
                                    <th>Nro. Letras</th>
                                    <th>Concepto</th>
                                    <th>Fecha Estado</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
						</div>
					</div>
                    
                    <div class = "row">
                        <div class= "col-md-12">
                            <div class="panel panel-danger"> 
                                <div class="panel-heading">
                                    BOTONES PARA DUPLICADOS DE DOCUMENTOS   
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12"  style="margin-top: 15px;" >
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" disabled="true" style="width: 100%" id="reco_deuda">
                                                    Acta de Reconocimiento de Deuda
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" disabled="true" style="width: 100%" id="cro_pagos">
                                                    Cronograma de pago de Cuotas
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" disabled="true" style="width: 100%" id="corriente_convenio">
                                                    Detalle de la CTA. Corriente al hacer convenio
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12"  style="margin-top: 15px;" >
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" disabled="true" style="width: 100%" id="not_debito">
                                                    Nota de Debito
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" disabled="true" style="width: 100%" id="rec_caja">
                                                    Recibo de Caja
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-12">
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    DOCUMENTOS RELACIONADOS 
                                </div>
                                <div class="panel-body">
                                    <div class= "col-md-6">
                                        <div class="panel panel-primary"> 
                                            <div class="panel-heading">
                                                TITULAR
                                            </div>
                                            <div class="panel-body" id="archi_titular">
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "col-md-6">
                                    <div class="panel panel-primary"> 
                                            <div class="panel-heading">
                                                REPRESENTANTE
                                            </div>
                                            <div class="panel-body" id="archi_representante">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>




				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">

    <?php $mxd = date("d-m-Y"); ?>
    <?php $mnd = strtotime ( '-2 day' , strtotime ( $mxd ) ) ;
          $mnd = date ( 'd-m-Y' , $mnd );
    ?>
    var hoy = '<?php echo $mxd; ?>';
    var max = hoy;
    var min = '<?php echo $mnd; ?>';
    var table = null;
    var estado  = 0;
    var data;
    $(document).ready(function() {
        

        table = $('#reporte').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
        $('#reporte tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
            if (table.cell('.selected', 0).index()) {

                var idx = table.cell('.selected', 0).index();
                var dato = table.rows( idx.row ).data();
                console.log(dato.length);
                var i = 0 ;
                while(i < dato.length ){
                    dato [i][12] = 2;
                    i++;
                }
                data = dato;
                
                validar_busqueda_imprimir(data);

            }
            else{
                $("#reco_deuda").attr("disabled", true);
                $("#cro_pagos").attr("disabled", true);
                $("#corriente_convenio").attr("disabled", true);
                $("#not_debito").attr("disabled", true);
                $("#rec_caja").attr("disabled", true);
                $('#archi_titular').empty();
                $('#archi_representante').empty();
            }
            
        } );

        $("#NSUM-INI").inputmask("d-m-y");
        $("#NSUM-INI").val(min);

        $("#NSUM-FIN").inputmask("d-m-y");
        $("#NSUM-FIN").val(max);
        $("#Codigo_Suministro").keypress(function(e) {
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        });
        $("#PRINTREP1").on("click", function(){
            //alert("hola mundo");
            imprimir1();
        });

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
        		swal({
	              title: "BUSCANDO FINANCIAMIENTOS ...",
	              text: "",
	              showConfirmButton: false
	            });
	            var entrada = $("#Codigo_Suministro").val();
                $("#reco_deuda").attr("disabled", true);
                $("#cro_pagos").attr("disabled", true);
                $("#corriente_convenio").attr("disabled", true);
                $("#not_debito").attr("disabled", true);
                $("#rec_caja").attr("disabled", true);
	            Buscar_suministro(entrada);
        	}
            
        });

        $("#NSUM-FIN").change(function(){
            if (estado ==1) {
        		swal({
	              title: "BUSCANDO FINANCIAMIENTOS ...",
	              text: "",
	              showConfirmButton: false
	            });
	            var entrada = $("#Codigo_Suministro").val();
                $("#reco_deuda").attr("disabled", true);
                $("#cro_pagos").attr("disabled", true);
                $("#corriente_convenio").attr("disabled", true);
                $("#not_debito").attr("disabled", true);
                $("#rec_caja").attr("disabled", true);
	            Buscar_suministro(entrada);
        	}
        });

        $("#tipo_deuda").change( function(){
        	if (estado ==1) {
        		swal({
	              title: "BUSCANDO FINANCIAMIENTOS ...",
	              text: "",
	              showConfirmButton: false
	            });
	            var entrada = $("#Codigo_Suministro").val();
                $("#reco_deuda").attr("disabled", true);
                $("#cro_pagos").attr("disabled", true);
                $("#corriente_convenio").attr("disabled", true);
                $("#not_debito").attr("disabled", true);
                $("#rec_caja").attr("disabled", true);
	            Buscar_suministro(entrada);
        	}
        });
        
        $("#Buscar_suministro").on("click", function(){
              validar_entrada();
        });

        $("#reco_deuda").on("click", function(){
            Impr_recono_deuda();
        });

        $("#cro_pagos").on("click", function(){
            Impr_cro_pagos();
        });

        $("#corriente_convenio").on("click", function(){
            Impr_corri_convenio();
        });

        $("#not_debito").on("click", function(){
            Impr_not_debito();
        });

        $("#rec_caja").on("click", function(){
            Impr_rec_caja();
        });

        $('#collapseExample').on('shown.bs.collapse', function () {
			
			$('#ocult_most').text('OCULTAR DATOS');
			//console.log("mostrando");
		});
		$('#collapseExample').on('hidden.bs.collapse', function () {
			//console.log("cerrando");
			$('#ocult_most').text('MOSTRAR DATOS');
		});
        
        $("#Limpiar_suministro").click(function(){
            swal({
                    title: "FINANCIAMIENTO",
                    text: "¿Desea limpiar los campos ?",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonColor: "#296fb7",
                    confirmButtonText: "Aceptar",
                    showConfirmButton : true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                    }, function(valor){
                        window.location.replace('<?php echo $this->config->item('ip')."financiamiento/reporte_financiamiento"?>');
                    });
        });
        
    });
    
    function Impr_recono_deuda(){
        var json = JSON.stringify(new Array( data ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporteador/recono_deuda'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'recono_deuda',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }

    function Impr_cro_pagos(){
        var nombre = $('#NOMBRE').val();
        var direccion = $('#Direccion').val();
        var suministro = $('#Codigo_Suministro').val();
        var json = JSON.stringify(new Array( data ,nombre,direccion,suministro  ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporteador/crono_pagos'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'crono_pagos',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }

    function Impr_corri_convenio(){
        var json = JSON.stringify(new Array( data ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporteador/Cta_Corri_convenio'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'CTA_corri_convenio',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    } 

    function Impr_not_debito(){

    }

    function Impr_rec_caja(){
        var json = JSON.stringify(new Array( data ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/reporteador/Reci_caja'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'Reci_caja',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }

    function validar_busqueda_imprimir(data){
        swal({
          title: "FINANCIAMIENTO",
          text: "¿ Esta seguro que desea buscar el credito numero : "+data[0][3]+ " ?",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
            var tip = $('#tipo_deuda').val();
            if(tip == 'Y'){
                $("#cro_pagos").attr("disabled", false);
                busco_archivos_relacionados(data[0][3]);
            }else{
                $("#reco_deuda").attr("disabled", false);
                $("#cro_pagos").attr("disabled", false);
                $("#corriente_convenio").attr("disabled", false);
                $("#not_debito").attr("disabled", false);
                $("#rec_caja").attr("disabled", false);
                busco_archivos_relacionados(data[0][3]);
            }
            swal.close();
          
        });
    }

    function busco_archivos_relacionados(credito){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/buscar/suministro_archivos?ajax=true",
            data: {
            		num_credito: credito, 
            		num_suministro: $("#COD_SUMINISTRO").val()
            	  },
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {
                    /* PARA LA IMAGEN  */
                        //titular
                        $('#archi_titular').empty();
                        if(data.respuesta[0]['DIRE_ARCH_TITULAR'] != null){
                            var arreglo_direccion = data.respuesta[0]['DIRE_ARCH_TITULAR'].split("*****");
                            var cadena_mostrar = "<div class='row'> <div class='list-group gallery'>";
                            var cadena_documento = "<div class='row'><div class= 'col-md-12'> <table class='table table-bordered'> <tr><td>Descripción</td><td>Enlace</td></tr>";
                            var i=0;
                            while(i< arreglo_direccion.length){
                                var tip_arch = arreglo_direccion[i].split(".");
                                console.log(tip_arch);
                                if( (tip_arch[1] != "pdf") && (tip_arch[1] != "PDF") ){
                                    cadena_mostrar = cadena_mostrar + "<div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'> <a class= 'thumbnail fancybox' rel='ligthbox' href='<?php echo $this->config->item('ip');?>"+arreglo_direccion[i]+"'> <img class='img-responsive'   alt=''  src='<?php echo $this->config->item('ip');?>"+arreglo_direccion[i]+"' /> <div class='text-right'> <small class='text-muted'>IMAGEN</small> </div>  </a></div>";
                                }else{
                                    cadena_documento = cadena_documento + "<tr><td> ARCHIVO " + i + "</td><td><a target='_blank' href='<?php echo $this->config->item('ip');?>"+arreglo_direccion[i]+"'> <img src='<?php echo $this->config->item('ip'); ?>frontend/recibo/pdf-icon.png'></a></td></tr>";
                                }
                                i++;
                            }
                            cadena_mostrar = cadena_mostrar +"</div></div>";
                            cadena_documento = cadena_documento + "</table></div></div>";
                            $('#archi_titular').append( cadena_mostrar );
                            $('#archi_titular').append( cadena_documento );
                            //console.log(arreglo_direccion);
                        }

                        //representante
                        $('#archi_representante').empty();
                        if(data.respuesta[0]['DIRE_ARCH_REPRE'] != null){
                            var arreglo_direccion = data.respuesta[0]['DIRE_ARCH_REPRE'].split("*****");
                            var cadena_mostrar = "<div class='row'> <div class='list-group gallery'>";
                            var cadena_documento = "<div class='row'><div class= 'col-md-12'> <table class='table table-bordered'> <tr><td>Descripción</td><td>Enlace</td></tr>";
                            var i=0;
                            while(i< arreglo_direccion.length){
                                var tip_arch = arreglo_direccion[i].split(".");
                                if( (tip_arch[1] != "pdf") && (tip_arch[1] != "PDF") ){
                                    cadena_mostrar = cadena_mostrar + "<div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'> <a class= 'thumbnail fancybox' rel='ligthbox' href='<?php echo $this->config->item('ip');?>"+arreglo_direccion[i]+"'> <img class='img-responsive'   alt=''  src='<?php echo $this->config->item('ip');?>"+arreglo_direccion[i]+"' /> <div class='text-right'> <small class='text-muted'>IMAGEN</small> </div>  </a></div>";
                                }
                                else{
                                    cadena_documento = cadena_documento + "<tr><td> ARCHIVO " + i + "</td><td><a  target='_blank' href='<?php echo $this->config->item('ip');?>"+arreglo_direccion[i]+"'> <img src='<?php echo $this->config->item('ip'); ?>frontend/recibo/pdf-icon.png'></a></td></tr>";
                                }
                                i++;
                            }
                            cadena_documento = cadena_documento + "</table></div></div>";
                            cadena_mostrar = cadena_mostrar +"</div></div>";
                            $('#archi_representante').append( cadena_mostrar );
                            $('#archi_representante').append( cadena_documento );
                            //console.log(arreglo_direccion);
                        }
                        /* FIN DE LA IMAGEN  */
                    
                }
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
				estado = 1;
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

	function Buscar_suministro(entrada){
		var tip = $('#tipo_deuda').val();
		$.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/buscar/suministro_reporte?ajax=true",
            data: {
            		inicio: $("#NSUM-INI").val(), 
            		fin:$("#NSUM-FIN").val(), 
            		tipo:tip,
            		suministro: entrada
            	  },
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {
                    if (data.tam == 7) {
                        $("#COD_SUMINISTRO").val(data.detalle[0]['CLICODFAC']);
                    	$("#NOMBRE").val(data.detalle[0]['NOMBRE']);
                    	$("#Direccion").val(data.detalle[0]['DIRECCION']);
                    	$("#Ciclo").val(data.detalle[0]['CICLO']);
                    	table.clear().draw();
                    	for(var i=0; i<data.respuesta.length;i++){

	                        table.row.add( [ 
	                            i+1,
	                            data.respuesta[i]['AGENCI_OFICIN_OFICOD'],
	                            data.respuesta[i]['AGENCI_OFIAGECOD'],
	                            data.respuesta[i]['CREDNRO'],
	                            data.detalle[0]['NOMBRE'],
	                            data.respuesta[i]['CREDFECHA'],
	                            data.respuesta[i]['CREDSTATUS'],
	                            data.respuesta[i]['CREDTIPO'],
	                            data.respuesta[i]['CTAINICIAL'],
	                            data.respuesta[i]['NROLTS'],
                                data.respuesta[i]['CONCEP_FACCONCOD'],
                                data.respuesta[i]['CREDSTFEC']
	                        ] ).draw(false);

                    	}
                        $( "#Buscar_suministro" ).prop( "disabled", true );
                    	console.log(data.detalle);
                    	console.log(data.respuesta);		
                    }

                    if (data.tam == 11) {
                        console.log(data);
                        $("#COD_SUMINISTRO").val(data.detalle[0]['CLICODFAC']);
                    	$("#NOMBRE").val(data.detalle[0]['NOMBRE']);
                    	$("#Direccion").val(data.detalle[0]['DIRECCION']);
                    	$("#Ciclo").val(data.detalle[0]['CICLO']);
                        table.clear().draw();
                        for(var i=0; i<data.respuesta.length;i++){

                            table.row.add( [ 
                                i+1,
                                data.respuesta[i]['AGENCI_OFICIN_OFICOD'],
                                data.respuesta[i]['AGENCI_OFIAGECOD'],
                                data.respuesta[i]['CREDNRO'],
                                data.detalle[0]['NOMBRE'],
                                data.respuesta[i]['CREDFECHA'],
                                data.respuesta[i]['CREDSTATUS'],
                                data.respuesta[i]['CREDTIPO'],
                                data.respuesta[i]['CTAINICIAL'],
                                data.respuesta[i]['NROLTS'],
                                data.respuesta[i]['CONCEP_FACCONCOD'],
                                data.respuesta[i]['CREDSTFEC']
                            ] ).draw( false );

                        }

                        
                        /*  DOCUMENTOS RELACIONADOS AL CREDITO */
                        $( "#Buscar_suministro" ).prop( "disabled", true );
                    	console.log(data.detalle);
                    	console.log(data.respuesta);
                    }
                    
                    swal.close();
                    
                    return true;
                }else{
                	swal.close();
                    
                    return false;
                }
            }
        });
	}

    function cargar_comprobante_intervalo(){
        var tip = $("#Form-TComp option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>buscar/buscar_comprobante_intervalo_diario?ajax=true",
            data: {inicio: $("#NSUM-INI").val(), fin:$("#NSUM-FIN").val(), tipo:tip},
            dataType: 'json',
            success: function(data) {
                //alert(data.result);
                if(data.result) {
                    //EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, ORPNRO, ORPFCHEMI, ORPNOMREF, ORPDIRREF, ORPDOCREF, SORCOD, USRCOD, STUSROOPUPD, ORPFCHUPD, ORPHRAUPD, CLICOD, ORPTOT
                    table.clear();
                    //alert(data.oordpag.length);
                    console.log(data.comprobante);
                    for(var i=0; i<data.comprobante.length;i++){

                        table.row.add( [ 
                            i+1,
                            data.comprobante[i]['FSCSERNRO']+' '+data.comprobante[i]['FSCNRO'],
                            data.comprobante[i]['FSCFECH'],
                            data.comprobante[i]['FSCCLIUNIC'],
                            data.comprobante[i]['FSCCLINOMB'],
                            data.comprobante[i]['FSCTIPDOC']+' '+((data.comprobante[i]['FSCTIPDOC']==1)? 'DNI':'RUC'),
                            ((data.comprobante[i]['FSCTIPDOC']==1)? data.comprobante[i]['FSCNRODOC']:data.comprobante[i]['FSCCLIRUC']),
                            parseFloat(data.comprobante[i]['FSCSUBTOTA']).toFixed(2),
                            parseFloat(data.comprobante[i]['FSCSUBIGV']).toFixed(2),
                            parseFloat(data.comprobante[i]['FSCTOTAL']).toFixed(2)
                        ] ).draw( false );

                    }
                    swal.close();
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function imprimir1(){
        var tip = $("#Form-TComp option:selected").val();
        var json = JSON.stringify(new Array(tip, $("#NSUM-INI").val(), $("#NSUM-FIN").val()));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'documentos/reporte/reporte2'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'reporte',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }
</script>