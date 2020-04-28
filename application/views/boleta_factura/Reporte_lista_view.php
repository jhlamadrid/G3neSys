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
                    <h3 class="box-title"><?php echo $titulo; ?></h3>
                </div>
                <div class="box-body">
                    <div class="container-fluid">
                        <!--h5><b>REPORTES:</b></h5-->
                        <div class='container-fluid'>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="tipo-comprobante">TIPO DE COMPROBANTE:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <select class="form-control" id="Form-TComp">
                                        <!--option value='-1'>TODOS</option-->
                                        <option value='0'>BOLETA</option>
                                        <option value='1'>FACTURA</option>
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
                            <div class="form-group control-group col-md-3 col-sm-12">
                                <label><input type="checkbox" id="habilitar" > MONTO MAYOR A </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" class="form-control" id="Monto" readonly="true" value="0">
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-sm-12" style="text-align:right;" >
                                <?php if ($ROL !=22){?>
                                <button id="PRINTREP1" type="button" class="btn btn-primary btn-md">
                                    IMPRIMIR SOLO DE OFICINA
                                </button>
                                <?php }?>
                                <button id="PRINTREP2" type="button" class="btn btn-primary btn-md">
                                    IMPRIMIR  SEDALIB
                                </button>
                                <button id="PRINTREP3" type="button" class="btn btn-primary btn-md">
                                    IMPRIMIR  SUNAT
                                </button>
                            </div>
                        </div>
                        <div class='container-fluid'>
                            <table class='table table-bordered table-striped' id='reporte'>
                                <thead>
                                    <th>item</th>
                                    <th>Ser. Nro.</th>
                                    <th>Fecha emision</th>
                                    <th>Codigo cliente</th>
                                    <th>Nombre</th>
                                    <th>Tip. Doc.</th>
                                    <th>Numero</th>
                                    <th>Sub. Total</th>
                                    <th>I.G.V.</th>
                                    <th>Total</th>
                                    <th>Documento</th>
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
        $("#PRINTREP2").on("click", function(){
            imprimir_formato_2();
        });
        $("#PRINTREP3").on("click", function(){
            imprimir_formato_3();
        });
        $('#Monto').inputmask('integer');

        $("#habilitar").change(function(){
             if ( $(this).prop('checked') ) {
                $("#Monto").attr('readonly', false);
             }else{
                $("#Monto").attr('readonly', true);
             }
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
              title: "Buscando comprobantes",
              text: "",
              showConfirmButton: false
            });
            cargar_comprobante_intervalo();
        });

        $("#NSUM-FIN").change(function(){
            swal({
              title: "Buscando comprobantes",
              text: "",
              showConfirmButton: false
            });
            cargar_comprobante_intervalo();
        });

        $("#Form-TComp").change(function(){
            swal({
              title: "Buscando comprobantes",
              text: "",
              showConfirmButton: false
            });
            cargar_comprobante_intervalo();
        });

        $("#Monto").change(function(){

            if($("#Monto").val()<0){
                swal("Alerta!", "El monto debe de ser mayor que 0");
            }else{
                swal({
                    title: "Buscando comprobantes",
                    text: "",
                    showConfirmButton: false
                });
                cargar_comprobante_intervalo();
            }



            //alert($("#Monto").val());
        });

        /*$("#NSUM-INI").onchange(function(){
            cargar_comprobante_intervalo();
        });
        /*$("#NSUM-INI").focusout(function(){
            cargar_comprobante_intervalo();
        });
        $("#NSUM-FIN").focusout(function(){
            cargar_comprobante_intervalo();
        });*/
        cargar_comprobante_intervalo();
        //cargar_comprobante_intervalo();
    } );

    function cargar_comprobante_intervalo(){
        var tip = $("#Form-TComp option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>buscar/buscar_comprobante_intervalo?ajax=true",
            data: {inicio: $("#NSUM-INI").val(), fin:$("#NSUM-FIN").val(), tipo:tip, monto:$("#Monto").val()},
            dataType: 'json',
            success: function(data) {
                //alert(data.result);
                if(data.result) {
                    //EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, ORPNRO, ORPFCHEMI, ORPNOMREF, ORPDIRREF, ORPDOCREF, SORCOD, USRCOD, STUSROOPUPD, ORPFCHUPD, ORPHRAUPD, CLICOD, ORPTOT
                    table.clear();
                    //alert(data.oordpag.length);
                    //console.log(data.comprobante);
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
                            parseFloat(data.comprobante[i]['FSCTOTAL']).toFixed(2),
                            "<a class='btn btn-default btn-flat' onclick='imprimirDoc("+data.comprobante[i]['FSCTIPO']+","+ data.comprobante[i]['FSCSERNRO']+","+data.comprobante[i]['FSCNRO']+")'> <i class='fa fa-print'></i> </a>"
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
        if($("#Monto").val().length !=0){
                if($("#Monto").val()<0){
                swal("Alerta!", "El monto debe de ser mayor que 0");
                }else{
                    var tip = $("#Form-TComp option:selected").val();
                    var json = JSON.stringify(new Array(tip, $("#NSUM-INI").val(), $("#NSUM-FIN").val(), $("#Monto").val() ));
                    event.preventDefault();
                    var form = jQuery('<form>', {
                            'action': "<?php echo $this->config->item('ip').'documentos/reporte/reporte1'; ?>",
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
           }else{
             swal("Alerta!", "Debe de ingresar un numero mayor a 0 en MONTO");
           }
       

    }

    function imprimir_formato_2(){
        if($("#Monto").val().length !=0){
                if($("#Monto").val()<0){
                swal("Alerta!", "El monto debe de ser mayor que 0");
                }else{
                    var tip = $("#Form-TComp option:selected").val();
                    var json = JSON.stringify(new Array(tip, $("#NSUM-INI").val(), $("#NSUM-FIN").val(), $("#Monto").val() ));
                    event.preventDefault();
                    var form = jQuery('<form>', {
                            'action': "<?php echo $this->config->item('ip').'documentos/reporte/reporte_formato_2'; ?>",
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
           }else{
             swal("Alerta!", "Debe de ingresar un numero mayor a 0 en MONTO");
           }
    }

    function imprimir_formato_3(){
        if($("#Monto").val().length !=0){
                if($("#Monto").val()<0){
                swal("Alerta!", "El monto debe de ser mayor que 0");
                }else{
                    var tip = $("#Form-TComp option:selected").val();
                    var json = JSON.stringify(new Array(tip, $("#NSUM-INI").val(), $("#NSUM-FIN").val(), $("#Monto").val() ));
                    event.preventDefault();
                    var form = jQuery('<form>', {
                            'action': "<?php echo $this->config->item('ip').'documentos/reporte/reporte_sunat'; ?>",
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
           }else{
             swal("Alerta!", "Debe de ingresar un numero mayor a 0 en MONTO");
           }
    }

    
    function imprimirDoc(tipo, serie, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip').'documentos/boletas_facturas/mostrar_pdf/'; ?>"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        //myWindow.document.close();
        myWindow.focus();
        myWindow.print();
        //myWindow.close();
    }
</script>
