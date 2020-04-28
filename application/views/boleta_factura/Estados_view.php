<!-- sweetAlert. -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
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
                            <div class="form-group col-md-4 col-sm-12">
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
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>FECHA INICIO</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" class="form-control" id="NSUM-INI" readonly>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>FECHA FIN</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" class="form-control" id="NSUM-FIN" readonly>
                                </div>
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
                                    <th>Ser.Nro. SUNAT</th>
                                    <th>Tip. Doc.</th>
                                    <th style="text-align:center">Estado</th>

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
            url: "<?php echo $this->config->item('ip'); ?>buscar/buscar_comprobante_estados?ajax=true",
            data: {inicio: $("#NSUM-INI").val(), fin:$("#NSUM-FIN").val(), tipo:tip},
            dataType: 'json',
            success: function(data) {
                //alert(data.result);
                if(data.result) {
                    //EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, ORPNRO, ORPFCHEMI, ORPNOMREF, ORPDIRREF, ORPDOCREF, SORCOD, USRCOD, STUSROOPUPD, ORPFCHUPD, ORPHRAUPD, CLICOD, ORPTOT
                    table.clear();
                    //alert(data.oordpag.length);
                    //console.log(data.comprobante);
                    for(var i=0; i<data.comprobante.length;i++){
                        var estado="";
                        switch (data.comprobante[i]['SUNESTADO']) {
                            case '1':
                                estado= '<p><span class="label label-warning">EMITIDO, PENDIENTE DE FIRMA</span></p><a href="'+'<?php echo $this->config->item('ip')."documentos/boletas_facturas/mostrar_pago/";?>'+data.comprobante[i]['FSCTIPO']+'/'+data.comprobante[i]['FSCSERNRO']+'/'+data.comprobante[i]['FSCNRO']+'"><button class="btn btn-warning  btn-flat">Continuar Proceso</button></a>';
                                break;
                            case '2':
                                estado= '<p><span class="label label-warning">SE ENVIO EN ESPERA DE FIRMA</span></p><a href="'+'<?php echo $this->config->item('ip')."documentos/boletas_facturas/mostrar_pago/";?>'+data.comprobante[i]['FSCTIPO']+'/'+data.comprobante[i]['FSCSERNRO']+'/'+data.comprobante[i]['FSCNRO']+'"><button class="btn btn-warning  btn-flat">Continuar Proceso</button></a>';
                                break;
                            case '3':
                                estado= '<span class="label label-success">EMITIDO Y ACEPTADO POR SUNAT</span>';
                                break;
                            case '4':
                                estado= '<p><span class="label label-warning">EMITIDO Y RECHAZADO POR SUNAT </span></p><a href="'+'<?php echo $this->config->item('ip')."documentos/boletas_facturas/mostrar_pago/";?>'+data.comprobante[i]['FSCTIPO']+'/'+data.comprobante[i]['FSCSERNRO']+'/'+data.comprobante[i]['FSCNRO']+'"><button class="btn btn-warning  btn-flat">Continuar Proceso</button></a>';
                                break;
                            case '5':
                                estado= '<p><span class="label label-warning">EMITIDO Y CON OBSERVACIONES POR SUNAT</span></p><a href="'+'<?php echo $this->config->item('ip')."documentos/boletas_facturas/mostrar_pago/";?>'+data.comprobante[i]['FSCTIPO']+'/'+data.comprobante[i]['FSCSERNRO']+'/'+data.comprobante[i]['FSCNRO']+'"><button class="btn btn-warning  btn-flat">Continuar Proceso</button></a>';
                                break;
                            case '6':
                                estado= '<p><span class="label label-warning">EMITIDO PERO NO SE CONECTO CON SUNAT</span></p><a href="'+'<?php echo $this->config->item('ip')."documentos/boletas_facturas/mostrar_pago/";?>'+data.comprobante[i]['FSCTIPO']+'/'+data.comprobante[i]['FSCSERNRO']+'/'+data.comprobante[i]['FSCNRO']+'"><button class="btn btn-danger  btn-flat">Continuar Proceso</button></a>';
                                break;
                            case '7':
                                estado= '<p><span class="label label-danger">EMITIDO, FIRMADO PERO SIN ENVIAR A SUNAT</span></p><a href="'+'<?php echo $this->config->item('ip')."documentos/boletas_facturas/mostrar_pago/";?>'+data.comprobante[i]['FSCTIPO']+'/'+data.comprobante[i]['FSCSERNRO']+'/'+data.comprobante[i]['FSCNRO']+'"><button class="btn btn-danger  btn-flat">Continuar Proceso</button></a>';
                                break;
                            case '8':
                                estado= '<p><span class="label label-danger">PENDIENTE DE ENVIO </span></p><a href="'+'<?php echo $this->config->item('ip')."documentos/boletas_facturas/mostrar_pago/";?>'+data.comprobante[i]['FSCTIPO']+'/'+data.comprobante[i]['FSCSERNRO']+'/'+data.comprobante[i]['FSCNRO']+'"><button class="btn btn-danger  btn-flat" >Continuar Proceso</button></a>';
                                break;
                            default:
                                estado= 'NO ESPECIFICADO';
                                break;
                            }

                        table.row.add( [
                            i+1,
                            data.comprobante[i]['FSCSERNRO']+'-'+data.comprobante[i]['FSCNRO'],
                            data.comprobante[i]['FSCFECH'],
                            data.comprobante[i]['FSCCLIUNIC'],
                            data.comprobante[i]['FSCCLINOMB'],
                            data.comprobante[i]['SUNSERNRO']+'*'+data.comprobante[i]['SUNFACNRO'],
                            data.comprobante[i]['FSCTIPDOC']+' '+((data.comprobante[i]['FSCTIPDOC']==1)? 'DNI':'RUC'),
                             estado

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

</script>
