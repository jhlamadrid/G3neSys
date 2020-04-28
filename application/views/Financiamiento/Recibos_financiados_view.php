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
						<div class="col-md-5">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; RECIBOS  FINANCIADOS</h2>
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
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <div class="col-md-6 col-sm-12" >
                                                <label>FECHA INICIO</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="NSUM-INI" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
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
                    </div>
                    
                    <div class = "row">
                       
                        <div class = "col-md-12">
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    TABLA
                                </div>
                                <div class="panel-body">
                                    <div class = "col-md-12"  style='margin-button:20px;'>
                                        <div class="col-md-6">
                                            <button class ="btn btn-info" style='width:100%' id="repo_pdf" >
                                                Reporte PDF 
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class ="btn btn-info" style='width:100%' id="repo_excel">
                                                Reporte EXCEL
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class='col-md-12' style="margin-top:15px;">
                                        <table class=' table display' id='reporte' >
                                            <thead>
                                                <th>Item</th>
                                                <th>Oficina</th>
                                                <th>Agencia</th>
                                                <th>Nro. Credito</th>
                                                <th>Codigo de Suministro</th>
                                                <th>Fecha</th>
                                                <th>Inicial</th>
                                                <th>Total</th>
                                                <th>Opciones</th>
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
			</div>
		</div>
	</div>
</section>

<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/excel/jszip.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/excel/myexcel.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/excel/FileSaver.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/pdf_js/jsPDF.js"></script>
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
        	swal({
	            title: "BUSCANDO FINANCIAMIENTOS ...",
	            text: "",
	            showConfirmButton: false
	        });   
	        Busca_financiamiento();
            swal.close();
        });
        $("#NSUM-FIN").change(function(){
        	swal({
	            title: "BUSCANDO FINANCIAMIENTOS ...",
	            text: "",
	            showConfirmButton: false
	        });
	        Busca_financiamiento();
            swal.close();
        });
        
        $("#repo_excel").on("click", function(){
              crear_excel();
        });
        
        $("#repo_pdf").on("click", function(){
            /*var pdf = new jsPDF('landscape');
			var graf_PDF = Graficar_Pdf(pdf);
            graf_PDF.autoPrint();
	        var blob = graf_PDF.output("blob");
		    window.open(URL.createObjectURL(blob));*/
            cargar_pdf();
        });
        Busca_financiamiento();
    });

    function cargar_pdf(){
        alert("hola PDF");
    }
  
    
    function crear_excel(){
        
        alert("hola Excel");                                        
    }


    function Busca_financiamiento(){
        
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/recibos_financiados/reporte?ajax=true",
            data: {
            		inicio: $("#NSUM-INI").val(), 
            		fin: $("#NSUM-FIN").val()  
            	  },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    console.log(data.respuesta);   
                    table.clear().draw();
                    for(var i=0; i<data.respuesta.length;i++){

	                        table.row.add( [ 
	                            i+1,
                                data.respuesta[i]['AGENCI_OFICIN_OFICOD'],
                                data.respuesta[i]['AGENCI_OFIAGECOD'],
	                            data.respuesta[i]['CREDNRO'],
	                            data.respuesta[i]['CLIUNICOD'],
	                            data.respuesta[i]['CREDFECHA'],
	                            data.respuesta[i]['CTAINICIAL'],
	                            data.respuesta[i]['DEUDATOTAL'],
                                "<button onclick='report_unitario("+data.respuesta[i]['AGENCI_OFICIN_OFICOD']+","+data.respuesta[i]['AGENCI_OFIAGECOD']+","+data.respuesta[i]['CREDNRO']+")'><i class='fa fa-file-pdf-o' style='font-size:24px'></i></button>"
	                        ] ).draw(false);

                    	}

                }else{
                    table.clear().draw();
                }
            }
        });
    }

    function report_unitario(oficina, agencia, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip').'financiamiento/mostrar_pdf/recibos_reporte/'; ?>"+oficina+"/"+agencia+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
        return true;
    }

</script>