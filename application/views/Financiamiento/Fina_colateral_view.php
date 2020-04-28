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
<link href="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
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
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; FINANCIAMIENTO PARA COLATERALES </h2>
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
											<a class= "btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" style="width:100%" id='ocult_most' >
											OCULTAR DATOS 
											</a>
										</div>
									</div>
                                    <div class="row collapse in"  id="collapseExample">
                                        <div class="col-md-12" style="margin-top:15px;"> 
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
                                                    <input type="text" id="numero_credito" style="visibility:hidden"> 
													<input type="text" id="cod_suministro" style="visibility:hidden"> 
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
					
                    <div class="row">
                        <div class = "col-md-12">
                            <div class = "col-md-12">
                                <h3>
                                    <b>
                                        ZONA DE GENERACIÓN DE LA CUOTA POR COLATERAL
                                    </b>
                                </h3>
                            </div>
                        </div>
                        <div class = "col-md-12">
                            <div class = "col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class = "col-md-12">
                            <div class="panel panel-primary"> 
                                    <div class="panel-heading">
                                        DATOS GENERALES  
                                    </div>
                                    <div class="panel-body">
                                        <div class = "col-md-12">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">FECHA REGISTRO</label>
                                                    <input type="text" class="form-control" id="fech_registro" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">USUARIO</label>
                                                    <input type="text" class="form-control" id="usuario_registro" value="<?php echo $_SESSION['user_nom']; ?>"  disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <div class="form-group">
                                                    <label for="email">OFICINA</label>
                                                    <input type="text" class="form-control" id="oficina_registro" value="<?php echo $_SESSION['OFICOD']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <div class="form-group">
                                                    <label for="email">AGENCIA</label>
                                                    <input type="text" class="form-control" id="agencia_registro" value="<?php echo $_SESSION['OFIAGECOD']; ?>" disabled>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class= "col-md-12">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label for="email">Conceptos de Facturación</label>
                                                    <select class="form-control" id="concep_facturacion">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <label for="email">Referencia</label>
                                                    <input type="text" class="form-control" id="referencia_colateral">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!--ZONA DE SIMULACION  -->
                        <div class = "col-md-12">
                            <div class = "col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class = "col-md-12">
                            <div class = "col-md-3 ">
                                <div class="panel panel-primary"> 
                                    <div class="panel-heading">
                                        MONTOS COLATERAL 
                                    </div>
                                    <div class="panel-body">
                                        <div class = "row">
                                            <div class="col-md-6">
                                                <p style="margin-top:30px;">
                                                    <b>
                                                        MONTO SIN IGV
                                                    </b>
                                                </p>
                                            </div>
                                            <div class="col-md-6" style="margin-top:20px;">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="mont_sin_igv" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "row">
                                            <div class="col-md-6">
                                                <p style="margin-top:30px;">
                                                    <b>
                                                        FACTURAR EL 
                                                    </b>
                                                </p>
                                            </div>
                                            <div class="col-md-6" style="margin-top:20px;">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="fecha_facturacion"  readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "row">
                                            <div class = "col-md-12">
                                                <button class="btn btn-danger" style="width: 100%; margin-top:22px;" id = "btn_archivo" disabled>
                                                    CARGAR ARCHIVO
                                                </button>
                                            </div>
                                        </div>
                                        <div class = "row">
                                            <div class="col-md-12" style="margin-top:30px;">
                                                <div class="form-group">
                                                    <label for="email">Asignar Interés a </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="margin-top:10px;">
                                                
                                                <select class="form-control" id="Intereses_facturacion" >
                        
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                    </div>
                                </div>
                                
                            </div>
                            <div class = "col-md-7 "> 
                                
                                <div class="panel panel-primary"> 
                                    <div class="panel-heading">
                                        ZONA DE SIMULACIÓN 
                                    </div>
                                    <div class="panel-body">
                                                    <div class="row">
                                                        <div class ="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">N° Cuotas</label>
                                                                <input type="text" class="form-control" id="nro_cuotas">
                                                            </div>
                                                        </div>
                                                        <div class ="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">1° Vencimiento</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    </span>
                                                                    <input type="text" class="form-control" id="fe_vencimiento" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "row">
                                                            <div class = "col-md-12">
                                                                <table id="tabla_letras" class="stripe row-border order-column" cellspacing="0" width="100%" style = "margin-top:20px;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>LETRA</th>
                                                                            <th>SALDO</th>
                                                                            <th>CUOTA INTERÉS</th>
                                                                            <th>CUOTA DEUDA</th>
                                                                            <th>CUOTA TOTAL</th>
                                                                            <th>VENCIMIENTO</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                             
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                    </div>
                                                    <div class = "row">
                                                            <div class = "col-md-4" style = "margin-top: 15px;" >
                                                                <div class="form-group">
                                                                    <label for="email">Monto a Financiar</label>
                                                                    <input type="text" class="form-control" id="Monto_a_financiar" readonly>
                                                                </div>
                                                            </div>
                                                            <div class = "col-md-4" style = "margin-top: 15px;">
                                                                <div class="form-group">
                                                                    <label for="email">Intereses</label>
                                                                    <input type="text" class="form-control" id="monto_interes" readonly>
                                                                </div>
                                                            </div>
                                                            <div class = "col-md-4" style = "margin-top: 15px;">
                                                                <div class="form-group">
                                                                    <label for="email">Monto a pagar Financiado</label>
                                                                    <input type="text" class="form-control" id="Monto_financiado" readonly>
                                                                </div>
                                                            </div>
                                                    </div>
                                    </div>
                                    <div class="panel-footer"></div>
                                        
                                </div>
                                
                                
                            </div>
                            <div class = "col-md-2 ">
                                <div class = "row">
                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading">
                                            BOTONES 
                                        </div>
                                        <div class="panel-body">
                                            <div class = "col-md-12">
                                                <button class="btn btn-primary" style="width: 100%; margin-top:22px;" id="btn_simular" disabled>
                                                    SIMULAR
                                                </button>
                                            </div>
                                            <div class = "col-md-12">
                                                <button class="btn btn-primary" style="width: 100%; margin-top:22px;" id="btn_limpia_simulacion" disabled>
                                                    LIMPIAR
                                                </button>
                                            </div>
                                            <div class = "col-md-12">
                                                <button class="btn btn-danger" style="width: 100%; margin-top:22px;" id = "btn_registrar" disabled>
                                                    REGISTRAR
                                                </button>
                                            </div>
                                            <div class = "col-md-12">
                                                <button class="btn btn-danger" style="width: 100%; margin-top:22px;" id = "btn_cronograma" disabled>
                                                    CRONOGRAMA
                                                </button>
                                            </div>
                                        </div>
                                        <div class="panel-footer"></div>
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

<!-- MODAL TITULAR -->
<div class="modal fade" id="ModalTitular" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR ARCHIVOS </h5>
      </div>
      <div class="modal-body">
        <div class="file-loading">
          <input id="titular-es" name="titular-es[]" type="file" multiple>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" title="" id="Gardar_File_titular">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DEL MODAL TITULAR-->
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/js/locales/es.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap_upload_file/themes/explorer/theme.js" type="text/javascript"></script>
<script>
    <?php $mxd = date("d/m/Y"); ?>
    <?php 
        $mnd = strtotime ( '-2 day' , strtotime ( $mxd ) ) ;
        $mnd = date ( 'd/m/Y' , $mnd );
    ?>
    var hoy = '<?php echo $mxd; ?>';
    var max = hoy;
    var min = '<?php echo $mnd; ?>';
    var table;
    var tasa_tam = 0; 
    var servidor = "";
    var numero_credito;
    var estado = 0;
    var frc;
    var Bandera_colateral;
    $(document).ready(function() {
        table = $('#tabla_letras').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
        $('#concep_facturacion').select2();
        $("#fech_registro").val(hoy);
        $("#Codigo_Suministro").keypress(function(e) {
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        });
        $("#fe_vencimiento").val(hoy);
        $("#fecha_facturacion").val(hoy);
        $('#fe_vencimiento').daterangepicker({
            "showDropdowns": true,
            "autoApply": true,
            "timePickerIncrement": 1,
            "singleDatePicker": true,
            "timePicker": false,
            "timePicker12Hour": false,
            "timePicker24Hour": false,
            "timePickerSeconds": false,
            "autoclose": true,
            "format": "DD/MM/YYYY",
            "startDate": hoy,
            "minDate": hoy,
            //"maxDate": hoy,
            //"maxDate" : convert_dmy(sumar_date(get_date(max), (-1*24*60*1000))),
            "locale": {
                "format": "DD/MM/YYYY",
                //"separator": " - ",
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
        $("#fe_vencimiento").prop('disabled', true);
        $("#nro_cuotas").inputmask('integer');
        $('#mont_sin_igv').inputmask('currency', {
            prefix: "",
            groupSeparator: "",
            allowPlus: false,
            allowMinus: false,
        });

        $("#Buscar_suministro").on("click", function(){
              validar_entrada();
        });
        $("#btn_simular").on("click", function(){
            simular_fina_colateral();
        });
        $("#btn_archivo").on("click", function(){
            subir_archivo();
        });
        $("#Gardar_File_titular").on("click", function(){
            guardar_archivo();
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
                        window.location.replace('<?php echo $this->config->item('ip')."financiamiento/colateral"?>');
                    });
        });
        $("#btn_cronograma").click(function(){
    		documento_cronograma();
    	});
        $("#btn_registrar").click(function(){
    		//grabar_datos();
            alerta_registro();
    	});
        $("#btn_limpia_simulacion").click(function(){
    		limpia_simulacion();
    	});
        $("#concep_facturacion").change(function(){
            if(estado != 1){
                $("#mont_sin_igv").prop('readonly', false);
                $("#btn_simular").prop('disabled', false);
                $("#btn_archivo").prop('disabled', false);
                $("#fe_vencimiento").prop('disabled', false);
                $('#titular-es').fileinput({
                    language: 'es',
                    showUpload: false,
                    uploadAsync: false,
                    uploadUrl: '<?php echo $this->config->item('ip') ?>financiamiento/colateral/guardo_archivo',
                    maxFileSize: 3000,
                    maxFileCount: 1,
                    showRemove: false,
                    allowedFileExtensions: ['pdf'],
                    uploadExtraData: function (previewId, index) {
                        var info = {
                                    "num_suministro": $('#cod_suministro').val(),
                                    "num_credito": $('#numero_credito').val()
                                };
                        return info;
                    }
                });
            }
        });

        $('#collapseExample').on('shown.bs.collapse', function () {
			
			$('#ocult_most').text('OCULTAR DATOS');
			//console.log("mostrando");
		});
		$('#collapseExample').on('hidden.bs.collapse', function () {
			//console.log("cerrando");
			$('#ocult_most').text('MOSTRAR DATOS');
		});
        
    });

    function alerta_registro(){
        var referencia = $("#referencia_colateral").val();
        
        if(referencia.trim() == ''){
            swal("ESTIMADO USUARIO", "TIENE QUE INGRESAR LA REFERENCIA DEL COLATERAL " , "error");
        }else{
            swal({
                    title: "GRABAR COLATERAL ",
                    text: "¿ Esta seguro que desea grabar colateral ?",
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
        
    }

    function limpia_simulacion(){
        //PARA LIMPIAR TABLA 
        table.clear().draw();
        $("#fecha_facturacion").val(hoy);
        $("#fe_vencimiento").val(hoy);
        $("#mont_sin_igv").prop('readonly', false);
        $("#nro_cuotas").prop('readonly', false);
        $("#btn_simular").prop('disabled', false);
        $("#btn_limpia_simulacion").prop('disabled', true);
        $("#btn_registrar").prop('disabled', true);
        $("#fe_vencimiento").prop('disabled', false);
    }

    function grabar_datos(){
        //cabecera de grabado 
        var oficina = $("#oficina_registro").val();
        var agencia = $("#agencia_registro").val();
        var suministro = $("#Codigo_Suministro").val();
        suministro = suministro.trim();
        var nombre  = $("#nombre_cliente").val();
        var direccion = $("#direccion_cliente").val();
        var monto = $("#mont_sin_igv").val();
        var nro_cuotas = $("#nro_cuotas").val();
        var monto_inicial = parseFloat(0);
        var capi_financiar = $("#mont_sin_igv").val();
        var concepto = $('#concep_facturacion').val();
        var tasa_interes = tasa_tam ;
        var referencia = $("#referencia_colateral").val();
        // detalle del grabado  
        var data_table = table .rows().data();
        //alert( 'The table has '+data_table.length+' records' );
        //console.log(data_table);
        var tabla = [];
        for(i=0; i < data_table.length; i++){
            tabla[i] = [];

            tabla[i][0] = data_table[i][0];
            tabla[i][1] = data_table[i][1];
            tabla[i][2] = data_table[i][2];
            tabla[i][3] = data_table[i][3];
            tabla[i][4] = data_table[i][4];
            tabla[i][5] = data_table[i][5];
        }

        //console.log(tabla);
        var fecha_sin_parse = $("#fecha_facturacion").val();
        var dia = fecha_sin_parse.substring(0, 2);
        var mes = parseInt(fecha_sin_parse.substring(3, 5));
        var anio = parseInt(fecha_sin_parse.substring(6, 10));
        var fecha_mandar = anio + "-" + mes;
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/colateral/grabar_dato?ajax=true",
            data: {
                ofi : oficina,
                age : agencia,  
                sumi : suministro,
                nom : nombre,
                dire : direccion,
                mont :  monto ,
                numero_cuota : nro_cuotas, 
                mont_inicial: monto_inicial ,
                capital_financiar :  capi_financiar, 
                concep :  concepto, 
                tas_interes :  tasa_interes,
                servi : servidor ,
                letras  : tabla,
                refe : referencia,
                texto_concepto : $("#concep_facturacion").text(),
                tasa_frc : frc,
                fecha : fecha_mandar
            	  },
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {

                    registro_exitoso(data.respuesta);
                    //console.log(data.respuesta);
                    
                }
            }
        });


    }

    function registro_exitoso(respuesta){
        $("#btn_limpia_simulacion").prop('disabled', true);
        $("#btn_registrar").prop('disabled', true);
        $("#btn_archivo").prop('disabled', true);
        $("#btn_cronograma").prop('disabled', false);
        $("#numero_credito").val(respuesta[2]);
        subir_archivo_red();
        estado =1;
        swal("EXITO EN REGISTRO DE COLATERAL", "EL COLATERAL " +respuesta[2]+ "  FUE REGISTRADO CON EXITO" , "success");
        numero_credito = respuesta[2];
    }
    
    function subir_archivo_red(){
        $('#titular-es').fileinput("upload");
		$('#titular-es').on('filebatchuploaderror', function(event, data, previewId, index) {
		    var form = data.form, files = data.files, extra = data.extra, 
		    response = data.response, reader = data.reader;
		});
		$('#titular-es').on('filebatchuploadsuccess', function(event, data) { 
            console.log(data.response);
		    //var respuesta = data.response ;//, reader = data.reader;
		    //resultado = respuesta["estado"];
		    //cargo_representante(respuesta);
		});
    }

    function documento_cronograma(){
        // cabecera  del cronograma
        var suministro = $("#Codigo_Suministro").val();
        var nombre  = $("#nombre_cliente").val();
        var direccion = $("#direccion_cliente").val();
        var monto = $("#mont_sin_igv").val();
        var nro_cuotas = $("#nro_cuotas").val();
        var monto_inicial = parseFloat(0);
        var capi_financiar = $("#mont_sin_igv").val();
        var concepto = $('#concep_facturacion').val();
        var tasa_interes = tasa_tam ;
        var oficina = $("#oficina_registro").val();
        var agencia = $("#agencia_registro").val();
        var n_credito = numero_credito ;
        // detalle del cronograma 
        var data_table = table .rows().data();
        var tabla = [];
        for(i=0; i < data_table.length; i++){
            tabla[i] = [];

            tabla[i][0] = data_table[i][0];
            tabla[i][1] = data_table[i][1];
            tabla[i][2] = data_table[i][2];
            tabla[i][3] = data_table[i][3];
            tabla[i][4] = data_table[i][4];
            tabla[i][5] = data_table[i][5];
        }

        console.log(tabla);
        var json = JSON.stringify(new Array(suministro, nombre, direccion, monto, nro_cuotas, monto_inicial, capi_financiar, concepto, tasa_interes, tabla, oficina, agencia, n_credito ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'financiamiento/colateral/reporte_cronograma'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_cronograma',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
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

    function simular_fina_colateral(){

        if($('#mont_sin_igv').val() == "" || $('#nro_cuotas').val() ==""){            
            swal(
				  'Alerta !!',
				  'Se encontraron espacios vacios en el monto o cantidad de letras ',
				  'error'
				);
        }else{
            var casilla_monto = parseFloat($('#mont_sin_igv').val());
            var casilla_letras = parseFloat($('#nro_cuotas').val());
            if( casilla_monto <= 0 || casilla_letras <= 0 ){
                swal(
				  'Alerta !!',
				  'El monto y numero de letras tienen que ser mayor que 0',
				  'error'
				);
            }else{
                var saldo_2_dig 
                var deuda_total = casilla_monto;
                var inicial = 0;
                var saldo_inicial = deuda_total - inicial ;  
                var num_letras = casilla_letras ; // numero de letras 
                //calculo FRC
                var calculo_frc = (tasa_tam * Math.pow((1+ tasa_tam),num_letras))/(Math.pow((1+tasa_tam),num_letras)-1);
                frc = parseFloat(calculo_frc.toFixed(7));
                var cuota_sin_interes = (saldo_inicial / num_letras) ; 
                var cuota_final = (saldo_inicial * frc);
                var deuda_final_con_interes = (cuota_final * num_letras);
                var saldo_interes  = deuda_final_con_interes - saldo_inicial ;
                var fecha_sin_parse = $("#fe_vencimiento").val();
                var dia = fecha_sin_parse.substring(0, 2);
                var mes = parseInt(fecha_sin_parse.substring(3, 5));
                var anio = parseInt(fecha_sin_parse.substring(6, 10));
                
                var dia2 =parseInt(dia);
                var cuenta_fecha = 0;
                if(dia2 > 24){
                    cuenta_fecha = 1;
                }
                $('#fecha_facturacion').val($("#fe_vencimiento").val());
                console.log(cuenta_fecha);
                //PARA LIMPIAR TABLAS 
                table.clear().draw();
                if (Bandera_colateral == 0 && num_letras == 1 ){
                    mes = mes + cuenta_fecha;
                    if(mes > 12){
                        mes = 1;
                        anio = anio + 1;
                    }
                    if(mes<10){
                        mes1 = "0"+mes;
                    }else{
                        mes1 = mes;
                    }
                    table.row.add( [ 
                                    1,
                                    saldo_inicial,
                                    0,
                                    saldo_inicial,
                                    saldo_inicial,
                                    dia+"/"+mes1+"/"+anio
                            ]).draw(false);
                    $("#Monto_a_financiar").val(saldo_inicial.toFixed(2));
                    $("#monto_interes").val(0.00);
                    $("#Monto_financiado").val(saldo_inicial.toFixed(2));
                    $("#fe_vencimiento").prop('disabled', true);
                }else{
                    var registro = [];
                    var i = 1;
                    var suma_simulada = 0 ;
                    var suma_interes = 0 ; 
                    while ( i <= num_letras ){
                        registro[i] =[];
                        mes = mes + cuenta_fecha;
                        if(mes > 12){
                            mes = 1;
                            anio = anio + 1;
                        }
                        if(mes<10){
                            mes1 = "0"+mes;
                        }else{
                            mes1 = mes; 
                        }
                        if(i == 1 ){
                            cuenta_fecha = 1;
                            var queda_saldo = saldo_inicial;
                            var queda_saldo_interes = saldo_interes;
                            var interes_cuota = queda_saldo * tasa_tam;
                            var amortiza_cuota = cuota_final - interes_cuota;
                            var en_cuotas = amortiza_cuota;
                            var en_cuotas_sin_int = interes_cuota;
                            var queda_saldo_ambos = queda_saldo - queda_saldo_interes ;
                            registro[i]['Letra'] = i ;
                            registro[i]['Saldo'] = parseFloat(queda_saldo.toFixed(2)); 
                            registro[i]['cta_interes'] = parseFloat(interes_cuota.toFixed(2));
                            registro[i]['cta_deuda'] = parseFloat(amortiza_cuota.toFixed(2)); 
                            registro[i]['cta_total'] = parseFloat((parseFloat(interes_cuota.toFixed(2)) + parseFloat(amortiza_cuota.toFixed(2))).toFixed(2)); 
                            registro[i]['vence'] = dia+"/"+mes1+"/"+anio; 
                            
                            suma_simulada = suma_simulada + parseFloat(amortiza_cuota.toFixed(2));
                            suma_interes = suma_interes + parseFloat(interes_cuota.toFixed(2));
                            
                        }else{
                            
                                saldo_2_dig = parseFloat(queda_saldo.toFixed(2)) - parseFloat(amortiza_cuota.toFixed(2));
                                queda_saldo = queda_saldo - amortiza_cuota ;
                                queda_saldo_interes = saldo_interes - en_cuotas_sin_int;
                                interes_cuota =  queda_saldo * tasa_tam;
                                amortiza_cuota = cuota_final - interes_cuota;
                                en_cuotas = en_cuotas +  amortiza_cuota ; 
                                en_cuotas_sin_int = en_cuotas_sin_int + interes_cuota;
                                queda_saldo_ambos = queda_saldo + queda_saldo_interes;
                                registro[i]['Letra'] = i ;
                                registro[i]['Saldo'] = parseFloat(queda_saldo.toFixed(2)); 
                                registro[i]['cta_interes'] = parseFloat(interes_cuota.toFixed(2));
                                registro[i]['cta_deuda'] = parseFloat(amortiza_cuota.toFixed(2)); 
                                registro[i]['cta_total'] = parseFloat((parseFloat(interes_cuota.toFixed(2)) + parseFloat(amortiza_cuota.toFixed(2))).toFixed(2)); 
                                registro[i]['vence'] = dia+"/"+mes1+"/"+anio; 
                                
                                suma_simulada = suma_simulada + parseFloat(amortiza_cuota.toFixed(2));
                                suma_interes = suma_interes + parseFloat(interes_cuota.toFixed(2));                   
                        }
                        //cuenta_fecha = cuenta_fecha + 1;
                        i++;
                    }
                    var ope;
                    var ope_interes;
                    if(parseFloat(suma_simulada.toFixed(2))>= saldo_inicial ){
                        diferencia = parseFloat(suma_simulada.toFixed( )) - saldo_inicial;
                        ope = true;
                    }else{
                        diferencia =  saldo_inicial - parseFloat(suma_simulada.toFixed(2));
                        ope = false;
                    }
                    var dif_inte;
                    if(parseFloat(suma_interes.toFixed(2))>= parseFloat(saldo_interes.toFixed(2)) ){
                        dif_inte = parseFloat(suma_interes.toFixed(2)) - parseFloat(saldo_interes.toFixed(2)) ;
                        ope_interes = true ; 
                    }else{
                        dif_inte = parseFloat(saldo_interes.toFixed(2)) - parseFloat(suma_interes.toFixed(2)) ;
                        ope_interes = false ;
                    }
                    i = 1;
                    var saldo_nuevo = saldo_inicial ;
                    while ( i <= num_letras ){
                        if ( i == 1){
                            if(ope){
                                registro[i]['cta_deuda'] = registro[i]['cta_deuda'] - parseFloat(diferencia.toFixed(2));
                                registro[i]['cta_interes'] = registro[i]['cta_total'] - registro[i]['cta_deuda'];
                                if(ope_interes){
                                    registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) - parseFloat(dif_inte.toFixed(2));
                                    registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda'];
                                }else{
                                    registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) + parseFloat(dif_inte.toFixed(2));
                                    registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda']; 
                                } 
                            }else{
                                registro[i]['cta_deuda'] = registro[i]['cta_deuda'] + parseFloat(diferencia.toFixed(2));
                                registro[i]['cta_interes'] = registro[i]['cta_total'] - registro[i]['cta_deuda'];
                                if(ope_interes){
                                    registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) - parseFloat(dif_inte.toFixed(2));
                                    registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda'];
                                }else{
                                    registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) + parseFloat(dif_inte.toFixed(2));
                                    registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['cta_deuda']; 
                                }
                            }
                            
                            saldo_nuevo =  saldo_nuevo   - registro[i]['cta_deuda'];                    
                        }else{
                            registro[i]['Saldo'] = saldo_nuevo ; 
                            registro[i]['cta_interes'] = registro[i]['cta_total'] - registro[i]['cta_deuda'];
                            saldo_nuevo =  saldo_nuevo   - registro[i]['cta_deuda']; 
                        }
                        if(i < num_letras){
                            table.row.add( [ 
                                    registro[i]['Letra'],
                                    registro[i]['Saldo'].toFixed(2),
                                    registro[i]['cta_interes'].toFixed(2),
                                    registro[i]['cta_deuda'].toFixed(2),
                                    registro[i]['cta_total'].toFixed(2),
                                    registro[i]['vence']
                            ]).draw(false);
                        }else{
                            if(ope_interes){
                                registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) - parseFloat(dif_inte.toFixed(2));
                                registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['Saldo'];
                            }else{
                                registro[i]['cta_interes'] = parseFloat(registro[i]['cta_interes'].toFixed(2)) + parseFloat(dif_inte.toFixed(2));
                                registro[i]['cta_total'] = registro[i]['cta_interes'] + registro[i]['Saldo']; 
                            }
                            table.row.add([ 
                                    registro[i]['Letra'],
                                    registro[i]['Saldo'].toFixed(2),
                                    registro[i]['cta_interes'].toFixed(2),
                                    registro[i]['Saldo'].toFixed(2),
                                    registro[i]['cta_total'].toFixed(2),
                                    registro[i]['vence']
                            ]).draw(false);
                        }
                        
                        i++;
                    }
                    $("#Monto_a_financiar").val(saldo_inicial.toFixed(2));
                    $("#monto_interes").val(saldo_interes.toFixed(2));
                    $("#Monto_financiado").val(deuda_final_con_interes.toFixed(2));
                    $("#fe_vencimiento").prop('disabled', true);
                    console.log(registro);
                    console.log("la diferencia es  " + diferencia.toFixed(2) + " " +  ope  );
                }
                
            }
        
            
            $("#btn_simular").prop('disabled', true);
            $("#btn_limpia_simulacion").prop('disabled', false);
            $("#btn_registrar").prop('disabled', false);
            $("#mont_sin_igv").prop('readonly', true);
            $("#nro_cuotas").prop('readonly', true);
        }
    }
    function Buscar_suministro(entrada){
		$.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/colateral/busca_suministro?ajax=true",
            data: {
            		suministro: entrada
            	  },
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {
                    if (data.tam == 7) {
                        if(data.tasa_tam.length > 0 ){
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
                            $('#cod_suministro').val(data.detalle.CLICODFAC);
                            $('#Buscar_suministro').prop('disabled', true);
                            
                            agregar_concepto(data.concepto, data.Interes_847);
                            //tasa tam 
                            Bandera_colateral = data.bandera_colateral.VALPAR;
                            tasa_tam  = parseFloat(data.tasa_tam[0].TAMTASA)/100;
                            servidor  = data.detalle.ZONASECSRV;
                            console.log(data.nombre);
                            console.log(data.detalle);
                            console.log(data.concepto);
                            swal.close();
                        }else{
                            swal("Atención!", "Tasa TAM falta actualizar", "error");
	                        $("#Codigo_Suministro").prop("readonly", false);
				            $( "#Buscar_suministro" ).prop( "disabled",false );
                        }
                    			
                    }

                    if (data.tam == 11) {
                        if(data.tasa_tam.length > 0 ){
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
                            $('#cod_suministro').val(data.detalle.CLICODFAC);
                            $('#Buscar_suministro').prop('disabled', true);
                            console.log(data.bandera_colateral);
                            agregar_concepto(data.concepto, data.Interes_847);
                            //tasa tam 
                            Bandera_colateral = data.bandera_colateral.VALPAR;
                            tasa_tam  = parseFloat(data.tasa_tam[0].TAMTASA)/100;
                            servidor  = data.detalle.ZONASECSRV;
                            console.log(data.detalle);
                            console.log(data.concepto);
                            swal.close();
                        }else{
                            swal("Atención!", "Tasa TAM falta actualizar", "error");
	                        $("#Codigo_Suministro").prop("readonly", false);
				            $( "#Buscar_suministro" ).prop( "disabled", false );
                        }
                    	
                    }

                }else{
                	swal.close();
                    
                    return false;
                }
            }
        });
	}

    function agregar_concepto(conceptos, interes){
        conceptos.forEach(function(concepto) {
            $('#concep_facturacion').append($('<option>', { 
                value: concepto['FACCONCOD'],
                text : concepto['FACCONCOD']+'-'+concepto['FACCONDES'] 
            }));
        });

        $('#Intereses_facturacion').append($('<option>', { 
                value: interes.FACCONCOD,
                text : interes.FACCONCOD+'-'+interes.FACCONDES 
        }));

        console.log(interes);
    }

    function subir_archivo(){
        $('#ModalTitular').modal("show");
    }
    
    function guardar_archivo(){
        $('#ModalTitular').modal("hide");
    }
</script>