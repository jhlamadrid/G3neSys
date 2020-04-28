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
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; REPORTE DE FINANCIAMIENTOS</h2>
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
                                        <div class="col-md-12" style="margin-top: 3px;">
                                            <div class="col-md-3 col-sm-12" >
                                                <label class="checkbox-inline" style = 'margin-top:15px; font-size: 16px; color:#FF0000;' id="Todas_Oficinas" ><input type="checkbox"  value=""  id="valor_Todas_Oficinas">TODAS LAS OFICINAS</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <div class="col-md-3 col-sm-12" >
                                                <label>FECHA INICIO</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="NSUM-INI" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <label>FECHA FIN</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="NSUM-FIN" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
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
                                            <div class="col-md-3 col-sm-12" id="estados_financia">
                                                <label>ESTADOS</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-bookmark-o" aria-hidden="true"></i>
                                                    </span>
                                                    <select class="form-control" id="estado_deuda">
                                                        <option value="T">Todos</option>
                                                        <option value="IM">Impagos</option>
                                                        <option value="PAG">Pagados</option>
                                                        <option value="EXT">Extornado</option>
                                                        <!--<option value="ANU">Anulados</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class = "col-md-12" style = "margin-top: 15px;">
                                            <div class="col-md-3 col-sm-12" >
                                                <label class="checkbox-inline" style = 'margin-top:15px; font-size: 16px;' id="Fina_Anulados" ><input type="checkbox" value=""  id="valor_fina_anulado">MOSTRAR ANULADOS</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12" >
                                                <label class="checkbox-inline" style = 'margin-top:15px; font-size: 16px;' id="concep_847" ><input type="checkbox" value=""  id="valor_concep_847">CONCEPTOS 847</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12" >
                                                <label class="checkbox-inline" style = 'margin-top:15px; font-size: 16px;' id="concepto_redondeo" ><input type="checkbox" value=""  id="valor_check">CONCEPTO REDONDEO 939-940</label>
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
                                                <th>Fecha</th>
                                                <th>Codigo</th>
                                                <th>Titular</th>
                                                <th>N° Convenio</th>
                                                <th>Deuda Total</th>
                                                <th>Inicial</th>
                                                <th>Saldo Deuda</th>
                                                <th>Tipo</th>
                                                <th>Concepto</th>
                                                <th>N° de cuotas</th>
                                                <th>Estado Pago Inicial</th>
                                                <th>Ejecutor</th>
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
<!-- script para excel -->
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
        $("#concepto_redondeo").hide();
        $("#concep_847").hide();
        $("#Fina_Anulados").hide();
        table = $('#reporte').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
        $("#NSUM-INI").inputmask("d-m-y");
        $("#NSUM-INI").val(min);
        $("#NSUM-FIN").inputmask("d-m-y");
        $("#NSUM-FIN").val(max);
        $("#Codigo_Suministro").keypress(function(e) {
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
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
        $("#tipo_deuda").change( function(){
        	swal({
	            title: "BUSCANDO FINANCIAMIENTOS ...",
	            text: "",
	            showConfirmButton: false
	        });
            var tipo_fina = $("#tipo_deuda").val();
            if(tipo_fina=='Y'){
                $("#estados_financia").hide();
                $("#concepto_redondeo").show();
                $("#concep_847").show();
                $("#Fina_Anulados").show();
            }else{
                $("#estados_financia").show();
                $("#valor_check").removeAttr('checked');
                $("#valor_fina_anulado").removeAttr('checked');
                $("#concepto_redondeo").hide();
                $("#concep_847").hide();
                $("#Fina_Anulados").hide();
                $("#valor_concep_847").removeAttr('checked');
            }
	        Busca_financiamiento();
        	swal.close();
        });
        $("#estado_deuda").change( function(){
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
        $('#valor_check').change(function() {
            Busca_financiamiento();
        });
        $('#valor_fina_anulado').change(function() {
            Busca_financiamiento();
        });
        $("#valor_concep_847").change(function() {
            Busca_financiamiento();
        });
        $("#valor_Todas_Oficinas").change(function() {
            swal({
	            title: "BUSCANDO FINANCIAMIENTOS ...",
	            text: "",
	            showConfirmButton: false
	        });
            Busca_financiamiento();
            swal.close();
        });
        $("#repo_pdf").on("click", function(){
            
            cargar_pdf();
        });
        Busca_financiamiento();
    });

    function cargar_pdf(){
        var data_table = table .rows().data();
        var fecha_ini = $('#NSUM-INI').val();
        var fecha_fin = $('#NSUM-FIN').val();
        var tipo  = $('#tipo_deuda').val();
        if(data_table.length > 0){
            var json = JSON.stringify(new Array(data_table, fecha_ini, fecha_fin, tipo));
            event.preventDefault();
            var form = jQuery('<form>', {
                    'action': "<?php echo $this->config->item('ip').'financiamiento/excel/reporte/pdf'; ?>",
                    'target': '_blank',
                    'method': 'post',
                    'type': 'hidden'
                }).append(jQuery('<input>', {
                    'name': 'reporte_pdf',
                    'value': json,
                    'type': 'hidden'
                }));
            $('body').append(form);
            form.submit();
        }else{
            swal(
				  'Alerta !!',
				  ' La tabla se encuentra vacia',
				  'error'
				);
        }
        
    }
    /*function Graficar_Pdf(pdf){
		var fecha = new Date();
		/*pdf.setFontSize(12);
		pdf.text(10, 10, 'SEDALIB S.A.');
		pdf.setFontSize(12);
		pdf.text(110, 14, 'REPORTE  DE FINANCIAMIENTO');
		pdf.setFontSize(9);
		pdf.text(250, 7, 'Impreso el : ' +' '+ fecha.getDate()+'/'+(fecha.getMonth() + 1)+'/'+ fecha.getFullYear() +' '+ fecha.getHours()+':'+fecha.getMinutes()+':'+fecha.getSeconds());
		pdf.text(250, 11, 'Pag. Nro. : '+ pdf.internal.getNumberOfPages() );*/
    /*    var reporte; 
        var cabecera = "<table><tr><td>campo1</td><td>campo2</td><td>campo3</td><td>campo4</td><td>campo5</td></tr>";
        var cuerpo = "";
        var i= 0;
        while(i<=500){
            cuerpo = cuerpo +  "<tr><td width='70'>cuerpo1</td><td width='70'>cuerpo1</td><td width='70'>cuerpo1</td><td width='70' >campo4</td><td width='70'>campo5</td></tr>"
            i++;
        }
        var header_footer = "<header style = 'color:red;'>CABECERA </header>";
        reporte = header_footer + cabecera + cuerpo + "</table>";
        $("#contenido").append(reporte);
        specialElementHandlers = {
            '#bypassme': function (element, renderer) {
                return true
            }
        };
        margins = {
            top: 0,
            bottom: 110,
            left: 5,
            width: 722
        };
        pdf.fromHTML(
        $("#contenido").html(), // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'margin': 1,
            'pagesplit': true,
            'elementHandlers': specialElementHandlers
        });
		return pdf;
	}*/
    
    function crear_excel(){
        var data_table = table.rows().data();
        if(data_table.length > 0){
            var excel = $JExcel.new("Arial light 10 #333333");            
            //excel.set( {sheet:0,value:"This is Sheet 0" } );                                                             
            
            var headers=["N°","FECHA","CODIGO SUMINISTRO","USUARIO TITULAR","N° DE CONVENIO", "DEUDA TOTAL", "INICIAL", "SALDO", "TIPO", "CONCEPTO" , "N° DE CUOTAS", "ESTADO","EJECUTOR"];                            
            var formatHeader=excel.addStyle ( {
                border: "none,none,none,thin #333333",font: "Arial 11 #0000AA B"}
            );                                                         

            for (var i=0;i<headers.length;i++){                       // Loop headers
                excel.set(0,i,0,headers[i],formatHeader);             // Set CELL header text & header format
                excel.set(0,i,undefined,"auto");                      // Set COLUMN width to auto 
            }        

            for(i=0; i < data_table.length; i++){
                excel.set(0,0,(i+1),data_table[i][0]);
                excel.set(0,1,(i+1),data_table[i][1]);
                if(data_table[i][2].length  == 11 ){
                    excel.set(0,2,(i+1),data_table[i][2] , excel.addStyle( {format:"00000000000"}));
                }else{
                    excel.set(0,2,(i+1),data_table[i][2] , excel.addStyle( {format:"0000000"}));
                }
                
                if(data_table[i][3] == undefined){
                    excel.set(0,3,(i+1)," ");
                }else{
                    excel.set(0,3,(i+1),data_table[i][3]);
                }
                excel.set(0,4,(i+1),data_table[i][4]);
                excel.set(0,5,(i+1),data_table[i][5]);
                excel.set(0,6,(i+1),data_table[i][6]);
                excel.set(0,7,(i+1),data_table[i][7]);
                excel.set(0,8,(i+1),data_table[i][8]);
                excel.set(0,9,(i+1),data_table[i][9]);
                excel.set(0,10,(i+1),data_table[i][10]);
                excel.set(0,11,(i+1),data_table[i][11]);
                excel.set(0,12,(i+1),data_table[i][12]);
            }                                                                
            excel.generate("Reporte_excel.xlsx");
        }else{
            swal(
				  'Alerta !!',
				  ' La tabla se encuentra vacia',
				  'error'
				);
        }
                                                          

    }

    function Busca_financiamiento(){
        var concep_redon , fina_anulado, concep_847;
        var  estado_fina, valor_oficinas;
        if ($('#valor_check').prop('checked') ) {
            concep_redon = 1;
        }else{
            concep_redon = 0;
        }
        
        if ($('#valor_fina_anulado').prop('checked') ) {
            fina_anulado = 1;
        }else{
            fina_anulado = 0;
        }
        
        if ($('#valor_concep_847').prop('checked')) {
            concep_847 = 1;
        }else{
            concep_847 = 0;
        }

        if ($('#valor_Todas_Oficinas').prop('checked')){
            valor_oficinas = 1;
        }else{
            valor_oficinas = 0;
        }

        estado_fina = $("#estado_deuda").val();
        if(estado_fina=='EXT'){
            estado_fina ='IM';
        }
        //var nombre_select = $("#estado_deuda option:selected").text();
        console.log($("#NSUM-INI").val(), $("#NSUM-FIN").val(), $("#tipo_deuda").val(), estado_fina, concep_redon, fina_anulado, concep_847, valor_oficinas   );
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>financiamiento/excel/reporte?ajax=true",
            data: {
            		inicio: $("#NSUM-INI").val(), 
            		fin: $("#NSUM-FIN").val(),
                    tipo: $("#tipo_deuda").val(),
                    esta_deuda : estado_fina,
                    concepto_redondeo: concep_redon,
                    financiamiento_anulado: fina_anulado, 
                    concepto_847: concep_847,
                    oficinas: valor_oficinas  
            	  },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    //console.log(data.respuesta);
                       
                    table.clear().draw();
                    
                    for(var i=0; i<data.respuesta.length;i++){
                            if($("#tipo_deuda").val() =='Z' && data.respuesta[i]['ESTADO']==0 && data.respuesta[i]['ESTADO_EXTORNO']=='I' ){
                                data.respuesta[i]['CREDSTATUS'] ='I';
                            }
                            if($("#tipo_deuda").val() =='Z' && data.respuesta[i]['ESTADO']==1 && data.respuesta[i]['ESTADO_EXTORNO']=='I' ){
                                data.respuesta[i]['CREDSTATUS'] ='P';
                            }
                            if($("#tipo_deuda").val() =='Z' && data.respuesta[i]['ESTADO']==0 && data.respuesta[i]['ESTADO_EXTORNO']=='R' ){
                                data.respuesta[i]['CREDSTATUS'] ='E';
                            }
                            //console.log( i+" -> "+data.respuesta[i]['CREDSTATUS']+" -> "+ $("#estado_deuda").val());
                            if(data.respuesta[i]['CREDSTATUS'] =='I' && $("#estado_deuda").val() =='IM' ){
                                table.row.add( [ 
                                    i+1,
                                    data.respuesta[i]['CREDFECHA'],
                                    data.respuesta[i]['CLIUNICOD'],
                                    data.respuesta[i]['TITULAR'],
                                    data.respuesta[i]['AGENCI_OFICIN_OFICOD']+'-'+data.respuesta[i]['AGENCI_OFIAGECOD']+'-'+data.respuesta[i]['CREDNRO'],
                                    (parseFloat(data.respuesta[i]['DEUDATOTAL'])).toFixed(2),
                                    parseFloat(data.respuesta[i]['CTAINICIAL']).toFixed(2),
                                    parseFloat(data.respuesta[i]['SALDO']).toFixed(2),
                                    data.respuesta[i]['CREDTIPO'],
                                    data.respuesta[i]['CONCEP_FACCONCOD'],
                                    data.respuesta[i]['NROLTS'],
                                    data.respuesta[i]['CREDSTATUS'], 
                                    data.respuesta[i]['OPERADOR']
                                ] ).draw(false);
                            }else{
                                if(data.respuesta[i]['CREDSTATUS'] =='E' && $("#estado_deuda").val() =='EXT' ){
                                    table.row.add( [ 
                                        i+1,
                                        data.respuesta[i]['CREDFECHA'],
                                        data.respuesta[i]['CLIUNICOD'],
                                        data.respuesta[i]['TITULAR'],
                                        data.respuesta[i]['AGENCI_OFICIN_OFICOD']+'-'+data.respuesta[i]['AGENCI_OFIAGECOD']+'-'+data.respuesta[i]['CREDNRO'],
                                        (parseFloat(data.respuesta[i]['DEUDATOTAL'])).toFixed(2),
                                        parseFloat(data.respuesta[i]['CTAINICIAL']).toFixed(2),
                                        parseFloat(data.respuesta[i]['SALDO']).toFixed(2),
                                        data.respuesta[i]['CREDTIPO'],
                                        data.respuesta[i]['CONCEP_FACCONCOD'],
                                        data.respuesta[i]['NROLTS'],
                                        data.respuesta[i]['CREDSTATUS'], 
                                        data.respuesta[i]['OPERADOR']
                                    ] ).draw(false);
                                }else{
                                    if(data.respuesta[i]['CREDSTATUS'] =='P' && $("#estado_deuda").val() =='PAG'){
                                        table.row.add( [ 
                                            i+1,
                                            data.respuesta[i]['CREDFECHA'],
                                            data.respuesta[i]['CLIUNICOD'],
                                            data.respuesta[i]['TITULAR'],
                                            data.respuesta[i]['AGENCI_OFICIN_OFICOD']+'-'+data.respuesta[i]['AGENCI_OFIAGECOD']+'-'+data.respuesta[i]['CREDNRO'],
                                            (parseFloat(data.respuesta[i]['DEUDATOTAL'])).toFixed(2),
                                            parseFloat(data.respuesta[i]['CTAINICIAL']).toFixed(2),
                                            parseFloat(data.respuesta[i]['SALDO']).toFixed(2),
                                            data.respuesta[i]['CREDTIPO'],
                                            data.respuesta[i]['CONCEP_FACCONCOD'],
                                            data.respuesta[i]['NROLTS'],
                                            data.respuesta[i]['CREDSTATUS'], 
                                            data.respuesta[i]['OPERADOR']
                                        ] ).draw(false);
                                    }else{
                                        if($("#estado_deuda").val() =='T'){
                                            table.row.add( [ 
                                                i+1,
                                                data.respuesta[i]['CREDFECHA'],
                                                data.respuesta[i]['CLIUNICOD'],
                                                data.respuesta[i]['TITULAR'],
                                                data.respuesta[i]['AGENCI_OFICIN_OFICOD']+'-'+data.respuesta[i]['AGENCI_OFIAGECOD']+'-'+data.respuesta[i]['CREDNRO'],
                                                (parseFloat(data.respuesta[i]['DEUDATOTAL'])).toFixed(2),
                                                parseFloat(data.respuesta[i]['CTAINICIAL']).toFixed(2),
                                                parseFloat(data.respuesta[i]['SALDO']).toFixed(2),
                                                data.respuesta[i]['CREDTIPO'],
                                                data.respuesta[i]['CONCEP_FACCONCOD'],
                                                data.respuesta[i]['NROLTS'],
                                                data.respuesta[i]['CREDSTATUS'], 
                                                data.respuesta[i]['OPERADOR']
                                            ] ).draw(false);
                                        }
                                    }
                                    
                                }
                            }
	                        
                    	}

                }else{
                    table.clear().draw();
                }
            }
        });
    }

</script>