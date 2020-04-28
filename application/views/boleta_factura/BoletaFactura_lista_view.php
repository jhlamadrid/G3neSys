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

<script type="text/javascript">
    var data = new Array();

    function imprimir(tipo, serie, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip').'documentos/boletas_facturas/mostrar_pdf/'; ?>"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        //myWindow.document.close();
        myWindow.focus();
        myWindow.print();
        //myWindow.close();
    }
</script>


<style>
    #boletas tr{
        cursor: pointer;
    }
</style>
<section class="content" >
    <div class="col-md-12">
        <div class="col-md-12">
            <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $_SESSION['mensaje'][1]; ?>
                </div><br>
            <?php } ?>

            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $titulo; ?></h3>
                </div>
                <div class="box-body ">
                    <div class="row">
                        <div class="col-md-12">
                           <div class="container-fluid">
                        <ul class="nav nav-tabs" role="tablist" id="TABPROFORMA">
                            <li role="presentation" class="active">
                                <a href="#proformas" aria-controls="Proformas" role="tab" data-toggle="tab">
                                    <h4>Proforma</h4>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#boletas_facturas" aria-controls="Comprobantes" role="tab" data-toggle="tab">
                                    <h4>Boletas-Facturas</h4>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="proformas">
                                <div class="container-fluid">
                                    <br>
                                    <table id="proformas2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th>EMISION</th>
                                                <th>TIPO</th>
                                                <th>SERIE - NUMERO</th>
                                                <th>NOMBRE USUARIO</th>
                                                <th>DOCUMENTO</th>

                                                <th>TOTAL</th>
                                                <th>OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($comprobantes as $comprobante){ ?>
                                            <tr>
                                                <td><?php echo $comprobante['FSCFECH']; ?></td>
                                                <td>
                                                    <?php echo ($comprobante['FSCTIPO'] == 1)? 'FACTURA':'BOLETA'; ?>
                                                </td>
                                                <td><?php echo $comprobante['FSCSERNRO'].'-'.str_pad($comprobante['FSCNRO'], 6, "0", STR_PAD_LEFT); ?></td>
                                                <td><?php echo $comprobante['FSCCLINOMB']; ?></td>
                                                <td>
                                                    <?php echo ($comprobante['FSCTIPDOC']!=6)? '<b>'.$comprobante['TIPDOCDESCABR'].': </b><br>'.$comprobante['FSCNRODOC']:'<b>RUC: </b><br>'.$comprobante['FSCCLIRUC']; ?>
                                                </td>
                                                <td style="text-align:right;">
                                                    <?php echo number_format($comprobante['FSCTOTAL'],2); ?>
                                                    <br>
                                                    <?php if($comprobante['CONORDPAG']==1){ ?>
                                                        <span class="label label-default">Con Orden de Pago</span>
                                                    <?php } else if($comprobante['CONORDPAG']==0) { ?>
                                                        <span class="label label-default">Sin Orden de Pago</span>
                                                    <?php } else { ?>
                                                        <span class="label label-error">Error</span>
                                                    <?php } ?>
                                                </td>
                                                <td style="text-align:center">
                                                    <?php if($comprobante['FSCESTADO']==1) { ?>
                                                        <span class="label label-info">Emitido</span>
                                                    <?php } else { ?>
                                                        <a class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-placement="bottom" title="Pagar" href="<?php echo $this->config->item('ip').'documentos/boletas_facturas/mostrar_pago/'.$comprobante['FSCTIPO'].'/'.$comprobante['FSCSERNRO'].'/'.$comprobante['FSCNRO']; ?>">
                                                            Pagar
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="boletas_facturas">
                                <div class="container-fluid">
                                    <br>
                                    <table id="comprobantes" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th>EMISION</th>
                                                <th>TIPO</th>
                                                <th>SER-NUM(SEDALIB)</th>
                                                <th>SER-NUM(SUNAT)</th>
                                                <th>NOMBRE USUARIO</th>
                                                <th>DNI/RUC</th>
                                                <th>TOTAL</th>
                                                <th>OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($boletas_facturas as $bf) { ?>
                                                <tr>
                                                    <td><?php echo $bf['FSCFECH']; ?></td>
                                                    <td>
                                                        <?php echo ($bf['FSCTIPO'] == 1)? 'FACTURA':'BOLETA'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $bf['FSCSERNRO'].'-'.str_pad($bf['FSCNRO'], 6, "0", STR_PAD_LEFT); ?>
                                                    </td>
                                                    <td>
                                                     <?php echo $bf['SUNSERNRO'].'-'.$bf['SUNFACNRO']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $bf['FSCCLINOMB']; ?>
                                                    </td>
                                                    <td style="text-align:right;">
                                                        <?php echo ($bf['FSCTIPDOC']==1)? '<b>DNI: </b>'.$bf['FSCNRODOC']:'<b>RUC: </b>'.$bf['FSCCLIRUC']; ?>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <?php echo number_format($bf['FSCTOTAL'],2); ?><br>
                                                        <?php if($bf['FSCESTADO']==0){ ?>
                                                            <span class="label label-warning">Pendiente de Pago</span>
                                                        <?php } else if($bf['FSCESTADO']==1){ ?>
                                                            <span class="label label-default">Pagado</span>
                                                        <?php } else if($bf['FSCESTADO']==2){ ?>
                                                            <span class="label label-default">Anulado</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <?php if($bf['DIRARCHPDF']!=null) { ?>
                                                            <a class="btn btn-default btn-flat" onclick="imprimir(<?php echo $bf['FSCTIPO'].', '.$bf['FSCSERNRO'].', '.$bf['FSCNRO'];?>)">
                                                               <i class="fa fa-print"></i>
                                                            </a>
                                                            <a class="btn btn-default btn-flat" onclick="imprimir_copia(<?php echo $bf['FSCTIPO'].', '.$bf['FSCSERNRO'].', '.$bf['FSCNRO'];?>)">
                                                                <i class="fa fa-ticket" aria-hidden="true"></i>
                                                            </a>
                                                        <?php } ?>

                                                    </td>

                                                </tr>
                                            <?php } ?>
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
    </div>
</section>
</div>


<script type="text/javascript">

    var table_ordpag;
    var table;

    function imprimir_copia(tipo, serie, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip').'documentos/boletas_facturas/mostrar_copia_ticket/'; ?>"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
    }

    function get_date(dmy){
        var parts = dmy.split("-");
        parts[2]+'-'+parts[1]+'-'+parts[0];
        return new Date(parts[2]+'-'+parts[1]+'-'+parts[0]);
    }

    function sumar_date(date, milisec){
        return new Date(date.getTime() + milisec);
    }

    function convert_dmy(milisec){
        var d = new Date(milisec);
        //alert(d);
        var dia = d.getDate();
        var mes = d.getMonth();
        var anio = d.getFullYear();
        alert(((dia>9)? '':'0')+dia+'-'+((mes>9)? '':'0')+mes+'-'+anio);
        return ((dia>9)? '':'0')+dia+'-'+((mes>9)? '':'0')+mes+'-'+anio;
    }

    <?php $mxd = date("d-m-Y"); ?>
    <?php $mnd = strtotime ( '-30 day' , strtotime ( $mxd ) ) ;
          $mnd = date ( 'd-m-Y' , $mnd );
    ?>
    var hoy = '<?php echo $mxd; ?>';
    var max = hoy;
    var min = '<?php echo $mnd; ?>';

    $(document).ready(function(){

        /*table_ordpag = $("#proformas2").DataTable({scrollX: true, bFilter: false, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]], "autoWidth": false,}).columns.adjust();
        table = $('#comprobantes').DataTable({scrollX: true, bFilter: false, bInfo: false, bSort:false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]], "autoWidth": false,});
        */
        $('#proformas2').DataTable({
              responsive: true,
              bSort:false,
              bInfo: false,
              scrollX: true,
              "autoWidth": true,
           });

           $('#comprobantes').DataTable({
              responsive: true,
              bSort:false,
              bInfo: false,
              scrollX: true,
              "autoWidth": true,
           });

           $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
              $($.fn.dataTable.tables(true)).DataTable()
                 .columns.adjust();
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

        $("#NSUM-INI").focusout(function(){
            cargar_nuevos_suministros();
        });
        $("#NSUM-FIN").focusout(function(){
            cargar_nuevos_suministros();
        });
    });

    function pagar_oordpag(EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, ORPNRO){
        json = JSON.stringify(new Array(EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, ORPNRO));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'documentos/proformas/proforma-orden-pago/nuevo'; ?>",
                'target': '_top',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'codigo_orden_pago',
                'value': json,
                'type': 'hidden'
            }));
        form.submit();
    }

    /*function cargar_nuevos_suministros(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>buscar/buscar_oordpag?ajax=true",
            data: {inicio: $("#NSUM-INI").val(), fin:$("#NSUM-FIN").val()},
            dataType: 'json',
            success: function(data) {
                //alert(data.result);
                if(data.result) {
                    //EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, ORPNRO, ORPFCHEMI, ORPNOMREF, ORPDIRREF, ORPDOCREF, SORCOD, USRCOD, STUSROOPUPD, ORPFCHUPD, ORPHRAUPD, CLICOD, ORPTOT
                    table_ordpag.clear();
                    //alert(data.oordpag.length);
                    for(var i=1; i<data.oordpag.length;i++){
                        table_ordpag.row.add( [
                            data.oordpag[i]['ORPFCHEMI'],
                            data.oordpag[i]['SERNRO'],
                            data.oordpag[i]['ORPNRO'],
                            data.oordpag[i]['ORPNOMREF'],
                            data.oordpag[i]['ORPDOCREF'],
                            data.oordpag[i]['ORPTOT'],
                            "<div class='btn-group btn-group-xs'>"+
                                "<a class='btn btn-default btn-flat btn-group-sm' data-placement='bottom'"+
                                " title='Pagar' type='button' onclick=\"pagar_oordpag(" +
                                data.oordpag[i]['EMPCOD']+", " +
                                data.oordpag[i]['OFICOD']+", " +
                                data.oordpag[i]['ARECOD']+", " +
                                data.oordpag[i]['CTDCOD']+", " +
                                data.oordpag[i]['DOCCOD']+", " +
                                data.oordpag[i]['SERNRO']+", " +
                                data.oordpag[i]['ORPNRO']+")\"" +
                                " >"+
                                    "<i class='fa fa-file'></i> " +
                                "</a>"+
                            "</div>"
                        ] ).draw( false );

                    }

                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }*/
</script>