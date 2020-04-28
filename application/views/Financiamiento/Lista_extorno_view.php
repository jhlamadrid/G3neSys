<!-- sweetAlert. -->
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
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>

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
                                    <h4>EXTORNAR</h4>
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
                                                <th>FECHA</th>
                                                <th>CREDITO</th>
                                                <th>SUMINISTRO</th>
                                                <th>OFICINA-AGENCIA</th>
                                                <th>NOMBRE</th>
                                                <th>DNI</th>
                                                <th>MONTO</th>
                                                <th>OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($datos_user as $comprobante){ ?>
                                            <tr>
                                                <td><?php echo $comprobante['FECHA']; ?></td>
                                                <td>
                                                    <?php echo $comprobante['CREDNRO']; ?>
                                                </td>
                                                <td><?php echo $comprobante['CLICODFAC']; ?></td>
                                                <td><?php echo $comprobante['OFICOD'].'-'.$comprobante['OFIAGECOD']; ?></td>
                                                <td>
                                                    <?php echo ($comprobante['REPSOLNOM']!= NULL)? $comprobante['REPSOLNOM'] : $comprobante['SOLICINOM']; ?>
                                                </td>
                                                <td>
                                                    <?php echo ($comprobante['REPSOLDNI']!= NULL)? $comprobante['REPSOLDNI'] : $comprobante['SOLICIDNI']; ?>
                                                </td>
                                                <td style="text-align:right;">
                                                    <?php echo number_format($comprobante['INICIAL'],2); ?>
                                                </td>
                                                <td style="text-align:center">
                                                    
                                                    <?php if($comprobante['AUT_EST']==1) { ?>
                                                        <span class="label label-info">Extornado</span>
                                                    <?php } else { ?>
                                                        <a class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-placement="bottom" title="Extornar" href="<?php echo $this->config->item('ip').'financiamiento/extorna/inicial/'.$comprobante['OFICOD'].'/'.$comprobante['OFIAGECOD'].'/'.$comprobante['CREDNRO'].'/1'; ?>">
                                                            EXTORNAR 
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
        var myWindow = window.open("<?php echo $this->config->item('ip').'financiamiento/mostrar_ticket/'; ?>"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
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

</script>