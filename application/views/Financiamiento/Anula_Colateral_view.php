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
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border borde_box">
					<div class="row">
						<div class="col-md-12">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; ANULA CREDITOS POR COLATERALES O POR INTERES DE FINANCIAMIENTO</h2>
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
                                    <div class="row" >
										<div class= "col-md-6 col-md-offset-6">
											<a class= "btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" style="width:100%" id='ocult_most'>
											OCULTAR DATOS 
											</a>
										</div>
									</div>
                                    <div class="row collapse in"  id="collapseExample" >
                                        <div class="col-md-12">
                                            <div class="row" >
                                                <div class="col-md-7" style="margin-top:15px;">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
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
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:100px">
                                                                LOCALIDAD
                                                            </button>
                                                        </div>
                                                            <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="LOCALIDAD" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:120px">
                                                                ESTADO CLIENTE
                                                            </button>
                                                        </div>
                                                            <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="EST-CLIENTE" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:120px">
                                                                CONEX. AGUA
                                                            </button>
                                                        </div>
                                                            <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="CON-AGUA" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:120px">
                                                                CONEX. DESAGUE
                                                            </button>
                                                        </div>
                                                            <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="CON-DESAGUE" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:120px">
                                                                TIP. SERVICIO
                                                            </button>
                                                        </div>
                                                            <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="TIP-SERVICIO" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:120px">
                                                                GRUPO
                                                            </button>
                                                        </div>
                                                            <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="GRUPO" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success" style="width:120px">
                                                                SUB-GRUPO
                                                            </button>
                                                        </div>
                                                            <!-- /btn-group -->
                                                        <input type="text" class="form-control" id="SUB-GRUPO" value="" disabled>
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
                                        <div class="col-md-4 col-sm-12" style="margin-top: 15px;" >
                                            <label>FECHA INICIO</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                                <input type="text" class="form-control" id="NSUM-INI" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12" style="margin-top: 15px;" >
                                            <label>FECHA FIN</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                                    <input type="text" class="form-control" id="NSUM-FIN" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12" style="margin-top: 15px;">
                                            <label>TIPO CONVENIO</label>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                    </span>
                                                <select class="form-control" id="tipo_deuda">
                                                    <!--<option value="Z">Deuda Recibo</option>-->
                                                    <option value="Y">Colateral</option>
                                                </select>
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
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    OPERACIONES 
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                            <button class="btn btn-primary"  id="ANULAR_EXTORNAR"  style=" width: 100%;">
                                                ANULAR
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 15px;">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                        REFERENCIA
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control" id="referencia" value="" >
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-md-12" style=" margin-top: 15px;">
                            <h4>
                                Estructura de las Cuotas (Solo se anularán las pendientes a facturar)
                            </h4>
                            <table class=' table display' id='cuotas'>
                                <thead>
                                    <th>Oficina</th>
                                    <th>Agencia</th>
                                    <th>Credito</th>
                                    <th>Letra</th>
                                    <th>Monto Cuota</th>
                                    <th>Vencimiento</th>
                                    <th>Estado</th>
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
    var estado  = 0;
    var data;
    $(document).ready(function() {
        
        table = $('#reporte').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
        table2 = $('#cuotas').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});

        $('#reporte tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
            //alert( table.rows('.selected').data().length +' row(s) selected' );
            var datos = table.rows('.selected').data() ; 
            verifico_registros(datos);
        });
        $("#Codigo_Suministro").keypress(function(e) {
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        });
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
        		swal({
	              title: "Buscando Financiamientos ...",
	              text: "",
	              showConfirmButton: false
	            });
	            var entrada = $("#Codigo_Suministro").val();
	            Buscar_suministro(entrada);
        	}
            
        });

        $("#NSUM-FIN").change(function(){
            if (estado ==1) {
        		swal({
	              title: "Buscando Financiamientos ...",
	              text: "",
	              showConfirmButton: false
	            });
	            var entrada = $("#Codigo_Suministro").val();
	            Buscar_suministro(entrada);
        	}
        });

        $("#Buscar_suministro").on("click", function(){
              validar_entrada();
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
                        window.location.replace('<?php echo $this->config->item('ip')."financiamiento/anu_colaterales"?>');
                    });
        });
        $('#collapseExample').on('shown.bs.collapse', function () {
			
			$('#ocult_most').text('OCULTAR DATOS');
			//console.log("mostrando");
		});
		$('#collapseExample').on('hidden.bs.collapse', function () {
			//console.log("cerrando");
			$('#ocult_most').text('MOSTRAR DATOS');
		});
        $("#tipo_deuda").change( function(){
            if (estado ==1) {
                swal({
                  title: "Buscando Financiamientos ...",
                  text: "",
                  showConfirmButton: false
                });
                var entrada = $("#Codigo_Suministro").val();
                Buscar_suministro(entrada);
            }
        });

        $("#ANULAR_EXTORNAR").on("click", function(){
              Realiza_operacion();
        });
   
    } );

    function ejecuta_proceso(tip, datos, refere){
        var sumi =  $("#Codigo_Suministro").val();
        var Dato_de_tabla = [];
        var i = 0;
        while (i <datos.length){
            Dato_de_tabla[i] = datos[i]; 
            i++;
        } 
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/anula_fina/ejecuta_proceso?ajax=true",
            data: {
                Datos_tabla: Dato_de_tabla,
                tipo_deuda : tip,
                suministro : sumi,
                referencia : refere
            },
            dataType: 'json',
            success: function(data) {
                    
                if(data.result) {
                 
                 swal({
                    title: "FINANCIAMIENTO",
                    text: "Se modifico con exito ",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonColor: "#296fb7",
                    confirmButtonText: "Aceptar",
                    showConfirmButton : true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                    }, function(valor){
                        window.location.replace('<?php echo $this->config->item('ip')."financiamiento/anu_colaterales"?>');
                    });
                 //swal.close();
                 //alert("Bien guardado");       
                    
                }else{
                    swal({
                    title: "FINANCIAMIENTO",
                    text: "Ocurrio un error al momento de Anular Colateral",
                    type: "error",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonColor: "#296fb7",
                    confirmButtonText: "Aceptar",
                    showConfirmButton : true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                    }, function(valor){
                        //window.location.replace('<?php echo $this->config->item('ip')."financiamiento/anu_colaterales"?>');
                    });
                }
                //swal.close();    
                //return true;
            }
        });
    }

    function Realiza_operacion(){

        var tip = $('#tipo_deuda').val();
        if (tip != 'Y') {

            var datos = table.rows('.selected').data();
            var referencia = $('#referencia').val();
            if(datos.length > 0 ){
                if(referencia.length>0){
                    swal({
                      title: "FINANCIAMIENTO",
                      text: "¿ ESTA SEGURO QUE DESEA REVERTIR DEUDA ?",
                      type: "info",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      showLoaderOnConfirm: true,
                    },
                    function(){
                           
                            ejecuta_proceso(tip, datos, referencia);
                          
                    });
                }else{
                    swal(
                      'FINANCIAMIENTO',
                      'INGRESE LA REFERENCIA',
                      'warning'
                    );
                }
                
            }else{
                swal(
                  'FINANCIAMIENTO',
                  'NO SELECCIONO NINGUNA DEUDA ',
                  'warning'
                );
            }
            
        }else{
            var datos = table.rows('.selected').data();
            var referencia = $('#referencia').val();
            if(datos.length > 0 ){
                if(referencia.length>0){
                    swal({
                      title: "FINANCIAMIENTO",
                      text: "¿ ESTA SEGURO QUE DESEA ANULAR COLATERAL ?",
                      type: "info",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      showLoaderOnConfirm: true,
                    },
                    function(){
                       ejecuta_proceso(tip, datos, referencia); 
                    });
                }else{
                    swal(
                      'FINANCIAMIENTO',
                      'INGRESE LA REFERENCIA',
                      'warning'
                    );
                }
                
            }else{
                swal(
                  'FINANCIAMIENTO',
                  'NO SELECCIONO NINGUN COLATERAL',
                  'warning'
                );
            }
        }
    }

    function verifico_registros(datos){
        
        if(datos.length > 0){
            swal({
                title: "Buscando Letras",
                text: "",
                showConfirmButton: false
            });
            
            var Dato_de_tabla = [];
            var i = 0;
            while (i <datos.length){
                Dato_de_tabla[i] = datos[i]; 
                i++;
            } 
            $.ajax({
                type: "POST",
                url: "<?php echo $this->config->item('ip');?>financiamiento/anula_fina/busca_letras?ajax=true",
                data: {
                    Datos_tabla: Dato_de_tabla
                },
                dataType: 'json',
                success: function(data) {
                    
                    if(data.result) {
                        
                        console.log(data.respuesta);
                        table2.clear().draw();
                        for(var i=0; i<data.respuesta.length;i++){
                            var j = 0 ;
                            console.log(data.respuesta[i].length);
                            while(j< data.respuesta[i].length ){
                                table2.row.add( [ 
                                    data.respuesta[i][j]['CREDIT_AGENCI_OFIAGECOD'],
                                    data.respuesta[i][j]['CREDIT_AGENCI_OFICIN_OFICOD'],
                                    data.respuesta[i][j]['CREDIT_CREDNRO'],
                                    data.respuesta[i][j]['LTNUM'],
                                    parseFloat(data.respuesta[i][j]['LTSALDO']),
                                    data.respuesta[i][j]['LTVENCIM'],
                                    data.respuesta[i][j]['LTSTATUS']
                                ] ).draw(false);
                                j++;
                            }
                            

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
        else{
            table2.clear().draw();
        }
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
        var inicio = $('#NSUM-INI').val();
        var final = $('#NSUM-FIN').val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/anula_fina/suministro?ajax=true",
            data: {
                    suministro: entrada,
                    tipo : tip ,
                    fecha_inicio : inicio,
                    fecha_final : final 
                  },
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {
                    if (data.tam == 7) {
                        $("#NOMBRE").val(data.detalle[0]['NOMBRE']);
                        $("#Direccion").val(data.detalle[0]['DIRECCION']);
                        $("#Ciclo").val(data.detalle[0]['CICLO']);
                        $("#LOCALIDAD").val(data.detalle[0]['LOCALIDAD']);
                        $("#EST-CLIENTE").val(data.detalle[0]['ESTADOCLI']);
                        $("#CON-AGUA").val(data.detalle[0]['ESTADOCONXAG']);
                        $("#CON-DESAGUE").val(data.detalle[0]['CONDESDES']);
                        $("#TIP-SERVICIO").val(data.detalle[0]['TIPOSERVICIO']);
                        $("#GRUPO").val(data.detalle[0]['GRUPO']);
                        $("#SUB-GRUPO").val(data.detalle[0]['SUBGRUPO']);
                        $("#Buscar_suministro").prop( "disabled", true );
                        estado = 1;
                        table.clear().draw();
                        table2.clear().draw();
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

                        if (tip != 'Y') {
                            $("#ANULAR_EXTORNAR").text("REVERTIR DEUDA");
                        }else{
                            $("#ANULAR_EXTORNAR").text("ANULAR COLATERAL");
                        }

                        //console.log(data.detalle);
                           
                    }

                    if (data.tam == 11) {
                        $("#NOMBRE").val(data.detalle[0]['NOMBRE']);
                        $("#Direccion").val(data.detalle[0]['DIRECCION']);
                        $("#Ciclo").val(data.detalle[0]['CICLO']);
                        $("#LOCALIDAD").val(data.detalle[0]['LOCALIDAD']);
                        $("#EST-CLIENTE").val(data.detalle[0]['ESTADOCLI']);
                        $("#CON-AGUA").val(data.detalle[0]['ESTADOCONXAG']);
                        $("#CON-DESAGUE").val(data.detalle[0]['CONDESDES']);
                        $("#TIP-SERVICIO").val(data.detalle[0]['TIPOSERVICIO']);
                        $("#GRUPO").val(data.detalle[0]['GRUPO']);
                        $("#SUB-GRUPO").val(data.detalle[0]['SUBGRUPO']);
                        $( "#Buscar_suministro" ).prop( "disabled", true );
                        estado = 1;
                        table.clear().draw();
                        table2.clear().draw();
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

                        if (tip != 'Y') {
                            $("#ANULAR_EXTORNAR").text("REVERTIR DEUDA");
                        }else{
                            $("#ANULAR_EXTORNAR").text("ANULAR COLATERAL");
                        }
                        //console.log(data.detalle);
                        
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

</script>
