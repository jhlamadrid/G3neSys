<!-- sweetAlert. -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.numeric.extensions.js" type="text/javascript"></script>

<!-- date-range-picker -->
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- date-picker -->
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/datepicker3.css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>

<style>
    #boletas tr{
        cursor: pointer;
    }
</style>
<section class="content">
    <div class="row">
        <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="col-md-12">
            <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $_SESSION['mensaje'][1]; ?>
            </div><br>
        </div>
        <?php } ?>
        <div class="col-md-12">
            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Reporte de los Reclamos por FONAVI</h3>
                </div>
                <div class="box-body">
                    <div class="container-fluid">
                        <!--h5><b>REPORTES:</b></h5-->
                        <div class='container-fluid'>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="tipo-comprobante">ESTADO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <select class="form-control" id="Form-REstado">
                                        <!--option value='-1'>TODOS</option-->
                                        <option value='2'>TODOS</option>
                                        <option value='1'>REGISTADOS</option>
                                        <option value='0'>ANULADOS</option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group control-group col-md-3 col-sm-12">
                                <label>FECHA INICIO</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" class="form-control" id="NSUM-INI" readonly>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-3 col-sm-12">
                                <label>FECHA FIN</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" class="form-control" id="NSUM-FIN" readonly>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-10 col-sm-12" style="text-align:right;" >
                                <button id="RptExcel" type="button" class="btn btn-success btn-md" onclick="ReporteExcel();">
                                    <i class="fa fa-table" aria-hidden="true"></i>&nbsp; GENERAR EXCEL
                                </button>
                            </div>
                            <div class="form-group control-group col-md-1 col-sm-12" style="text-align:right;" >
                                <button id="GENERAR" type="button" class="btn btn-primary btn-md">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;&nbsp; GENERAR REPORTE
                                </button>
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-8" id="dvdTotal"></div>
                        </div>
                        <div class='container-fluid'>
                            <table class='table table-bordered table-striped' id='reporte'>
                                <thead>
                                        <th>N°</th>
                                        <th>COD.</th>
                                        <th>COD. PREST.</th>
										<th>FECHA REG.</th>
										<!-- <th>HORA</th> -->
										<th>SUMINISTRO</th>
										<th>PROYECTO</th>
										<th>PRESTATARIO</th>
										<th>SOLICITANTE</th>
										<th>USUARIO</th>
										<th>ESTADO</th>
										<th>[...]</th>
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
    <?php $mnd = strtotime ( '-2 day' , strtotime ( $mxd ) ) ;
          $mnd = date ( 'd-m-Y' , $mnd );
    ?>
    var hoy = '<?php echo $mxd; ?>';
    var max = hoy;
    var min = '<?php echo $mnd; ?>';
    var table = null;

    $(document).ready(function() {
        table = $('#reporte').DataTable({scrollX: true, bFilter: true, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});

        $("#NSUM-INI").inputmask("d-m-y");
        $("#NSUM-INI").val(min);

        $("#NSUM-FIN").inputmask("d-m-y");
        $("#NSUM-FIN").val(max);

        $("#PRINTREP1").on("click", function(){
            imprimir1();
        });

        $("#GENERAR").on("click", function(){
            generarReporteReclamos();
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
        
    } );

    function generarReporteReclamos(){
        var estado = $("#Form-REstado option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>Reporte_Reclamo/Reporte_Fonavi/Reporte?ajax=true",
            data: {inicio: $("#NSUM-INI").val(), fin:$("#NSUM-FIN").val(), EstadoRec: estado},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    table.clear();
                    
                    $("#dvdTotal").html(
                        '<p class="text-primary"><b>Se encontraron ' + data.total + ' registros</b></p>'
                    );
                    for(var i=0; i<data.reclamosRep.length;i++){
                                              
                        table.row.add( [
                            i+1,
                            data.reclamosRep[i]['COD_REC'],
                            data.reclamosRep[i]['CODIGO'],
                            data.reclamosRep[i]['FEC_REG'],
                            // data.reclamosRep[i]['HORA_REG'],
                            data.reclamosRep[i]['SUMINISTRO'],
                            data.reclamosRep[i]['PROYECTO'],
                            data.reclamosRep[i]['PRESTATARIO'],
                            data.reclamosRep[i]['NOMBRE'] +' '+ data.reclamosRep[i]['APEPAT'] +' '+ data.reclamosRep[i]['APEMAT'],
                            data.reclamosRep[i]['USUARIO'],
                            ((data.reclamosRep[i]['ESTADO']==1)? '<span class="badge bg-green">REGISTRADO</span>':'<span class="badge bg-red">ANULADO</span>'),
                            ((data.reclamosRep[i]['ESTADO']==1)? '<button onclick="SendReportPDF(' + data.reclamosRep[i]['COD_REC'] +');" style="border-radius:10px;outline:none;" type="button" class=".btn-primary-outline"><i style="color:#A12F10; font-size:30px;"  class="fa fa-file-pdf-o" aria-hidden="true"></i></button>':'')
                            // ((data.reclamosRep[i]['FSCTIPDOC']==1)? data.reclamosRep[i]['FSCNRODOC']:data.reclamosRep[i]['FSCCLIRUC'])
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
    // Reporte de la informacion en EXCEL
    function ReporteExcel(){
        if(table.row().data() != null){
                    var estado = $("#Form-REstado option:selected").val();
                    var fecInicio = $("#NSUM-INI").val();
                    var fecFinal = $("#NSUM-FIN").val();
                    var json = JSON.stringify(new Array(estado,fecInicio,fecFinal));
                    event.preventDefault();
                    var form = jQuery('<form>', {
                            'action': "<?php echo $this->config->item('ip').'Reporte_Reclamo/Reporte_Fonavi/Genera_Excel'; ?>",
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
                    swal("Generando Archivo", "Puede consultar en sus archivos de descarga", "success");   
           }else{
             swal("Alerta!", "No se encuentran registros para generar el reporte");
           }
    }


    function SendReportPDF(codRec){
        var codigo  = codRec;
        var tipo  = 'pdf';
        
        var json = JSON.stringify(new Array(codigo,tipo));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'Reporte_Reclamo/Reporte_Fonavi/Reporte_pdf'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_reporte',
                'value': json,
                'type': 'hidden'
            }));
            $('body').append(form);
                    form.submit();
    }
</script>
