<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/facturacion/facturacion.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/select2/select2.min.css">
<script>
    var servidor = '<?php echo $this->config->item('ip'); ?>';
</script>
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-success'>
                <div class='box-header box_border'>
                    <div class='row'>
                        <div class='col-md-4 col-sm-5'>
                            <h4 class='title titulo text-blue'><i class="fa fa-file-text" aria-hidden="true"></i> &nbsp; Ordenes de Trabajo</h4>
                        </div>
                        <div class='col-md-4 col-sm-2'></div>
                        <div class='col-md-4 col-sm-5 btn-centrado'>
                            <a class='btn btn-success btn-sm btn-total' id='btnAddInstancia' data-toggle="collapse" data-target="#agregarOT" aria-expanded="false"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; NUEVA OT</a>   
                        </div>
                    </div>
                </div>
                <div class='box-body'>
                    <div class="collapse" id="agregarOT">
                        <div class="well">
                            <div class="row">
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="iperiodo"><i class="fa fa-calendar" aria-hidden="true"></i> PERIODO LECTURAS</label>
                                        <select id="iperiodo" class="form-control">
                                            <?php $mes = date('m'); $year = date('Y'); $periodoActual = $year.$mes; $mes1 = $mes - 1; if($mes1 == 0) { $mes1 = 12; $year1 = $year - 1; } else {$year1 = $year; }
                                                $periodoAnterior = $year1.(($mes1 < 10) ? "0".$mes1 : $mes1);
                                                $mes2 = $mes + 1; if($mes2 == 13 ) { $mes2 = 1;  $year2 = $year + 1;} else { $year2 = $year; }
                                                $periodoSiguiente = $year2.(($mes2 < 10) ? "0".$mes2 : $mes2);
                                            ?>
                                            <option value="<?php echo $periodoAnterior ?>"><?php echo $periodoAnterior; ?></option>
                                            <option value="<?php echo $periodoActual ?>"><?php echo $periodoActual; ?></option>
                                            <option value="<?php echo $periodoSiguiente ?>"><?php echo $periodoSiguiente; ?></option>
                                        </select>
                                        <span class="help-block">Ingrese el periodo de la orden <b>(Obligatorio)</b> </span>
                                    </div>
                                </div>
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="iciclos"><i class="fa fa-search" aria-hidden="true"></i> CICLOS</label>
                                        <select id="gruposPredio" class="select2" multiple="multiple" data-placeholder="Seleccione ciclo"  style="width: 100%;">
                                            <?php foreach( $ciclos as $c ) { ?>
                                                <option value="<?php echo $c['FACCICCOD'] ?>"><?php echo $c['FACCICDES']; ?></option> 
                                            <?php } ?>
                                        </select>
                                        <span class="help-block">Seleccione los ciclos a trabajar <b>(Obligatorio)</b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="ifecha"><i class="fa fa-calendar" aria-hidden="true"></i> Fecha de Inspección</label>
                                        <input type="text" class="form-control" id="ifecha" > 
                                        <span class="help-block">Ingrese la fecha de inspección <b>(Obligatorio)</b> </span>
                                    </div>
                                </div>
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="ihoras"><i class="fa fa-clock-o" aria-hidden="true"></i> Número de Inspecciones por Hora</label>
                                        <input type="number" class="form-control" id="ihoras" value="3"> 
                                        <span class="help-block">Ingrese numero de inspecciones por hora <b>(Obligatorio)</b> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="idescripcion"><i class="fa fa-file-text" aria-hidden="true"></i> Descripción</label>
                                        <textarea name="idescripcion" class="form-control" id="idescripcion"></textarea> 
                                       
                                    </div>
                                </div>
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="iobservaciones"><i class="fa fa-eye" aria-hidden="true"></i> Observaciones</label>
                                        <textarea class="form-control" id="iobservaciones" > </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="ifechaMaxNot"><i class="fa fa-calendar" aria-hidden="true"></i> Fecha Máxima de Recepción de Información de Notificacion</label>
                                        <input type="text" class="form-control" id="ifechaMaxNot" > 
                                        <span class="help-block">Ingrese Fecha Máxima de Recepción <b>(Obligatorio)</b> </span>
                                    </div>
                                </div>
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <div class="form-group has-success">
                                        <label class="control-label" for="ifechaMaxInsp"><i class="fa fa-calendar" aria-hidden="true"></i> Fecha Máxima de Recepción de Información de Inspección</label>
                                        <input type="text" class="form-control" id="ifechaMaxInsp" > 
                                        <span class="help-block">Ingrese Fecha Máxima de Recepción <b>(Obligatorio)</b> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                </div>
                                <div class='col-md-6 col-sm-6 col-xs-12'>
                                    <a class="btn btn-blue-ligth btn-md btn-total" id='generarOT' onclick="generarOT()"><i class="fa fa-spinner" aria-hidden="true"></i> &nbsp; GENERAR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-xs-12 table-responsive'>
                                <table id="OTs" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>N° OT</th>
                                            <th>PERIODO</th>
                                            <th>METRADO</th>
                                            <th>FECHAS</th>
                                            <th>ESTADO / AVANCE</th>
                                            <th>OPCIONES </th>
                                        </tr>
                                    </thead>
                                    <tbody id='cuerpo_instancia'>
                                        <?php foreach($ordenes as $o) { ?>
                                            <tr>
                                                <td><?php echo $o['OrtNum'] ?></td>
                                                <td><?php echo intval(substr($o['NtPrd'],4,2))." (".obtener_mes(intval(substr($o['NtPrd'],4,2))).") / ".substr($o['NtPrd'],0,4); ?></td>
                                                <td><?php echo "<b>TOTAL: </b>".$o['CANT']; ?></td>
                                                <td><?php echo "<b>Fecha Inicio Ejecución: </b>".$o['OrtFchEj']."<br>"."<b>Fecha Máxima Ejecución: </b>".$o['OrtFchFin']."<br><b>Fecha Máxima Recepción: </b>".$o['OrtFchEm']; ?></td>
                                                <td></td>
                                                <td style="text-align:center">
                                                    <?php
                                                    $cad_ciclos = '';
                                                    $conta = 0;
                                                    foreach($o['ciclos'] as $c) { ?>
                                                        <?php
                                                            if($conta == 0){
                                                                $cad_ciclos = $cad_ciclos.$c["NtPreCic"];
                                                            }else{
                                                                $cad_ciclos = $cad_ciclos.'-'.$c["NtPreCic"];
                                                            }
                                                            $conta = $conta + 1;
                                                        ?>    
                                                    <?php } ?>
                                                    <a class="btn btn-sm btn-danger" style='margin-top:5px ; width:100%;' target='_blank' href="<?php echo $this->config->item('ip').'facturacion/crear_atipico/'.$o['NtPrd'].'/'.$cad_ciclos; ?>"> <i class="fa fa-print" aria-hidden="true"></i> Generar Notificaciones ciclo <?php echo $cad_ciclos; ?></a>
                                                    <a class="btn btn-sm btn-success" style='margin-top:5px ; width:100%;' target='_blank' href="<?php echo $this->config->item('ip').'facturacion/crear_excel/'.$o['NtPrd'].'/'.$cad_ciclos; ?>"> <i class="fa fa-print" aria-hidden="true"></i> Generar Excel ciclo <?php echo $cad_ciclos; ?></a>
                                                </td>
                                            </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> 
    </div>
</section> 
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css"/>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/js/Genesys/facturacion/facturacion.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!--<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>-->
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<?php 
    function obtener_mes($m){
        switch($m){
            case 1 : return "ENERO";break;
            case 2 : return "FEBRERO";break;
            case 3 : return "MARZO";break;
            case 4 : return "ABRIL";break;
            case 5 : return "MAYO";break;
            case 6 : return "JUNIO";break;
            case 7 : return "JULIO";break;
            case 8 : return "AGOSTO";break;
            case 9 : return "SETIEMBRE";break;
            case 10 : return "OCTUBRE";break;
            case 11 : return "NOVIEMBRE";break;
            case 12 : return "DICIEMBRE";break;
        }
    }
?>
<script>
    var SubCiclos = $(".select2").select2({
        language: "es"
    });
    datetime_data = {
        "showDropdowns": true,
        "autoApply": true,
        "timePickerIncrement": 1,
        "singleDatePicker": true,
        "timePicker": true,
        "timePicker12Hour": false,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "autoclose": true,
        "format": "DD-MM-YYYY HH:mm:ss",
        "startDate": null,
        "minDate": null,
        "maxDate" : '31/12/2022',
        "drops": "down",
        "locale": {
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
        }
    };
    var now = new Date();
    minDate = new Date(now.getFullYear() - 1, now.getMonth(), now.getDate()),
    datetime_data['startDate'] =  now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();
    datetime_data['minDate'] = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();
    $("#ifecha").focus(function() {
        
        $("#ifecha").datepicker({ language: 'es', autoclose: true,startDate:"+3d"}).datepicker("show");
    });
    $("#ifechaMaxNot").focus(function() {
        $('#ifechaMaxNot').daterangepicker(datetime_data);
        //$("#ifechaMaxNot").datepicker({ language: 'es', autoclose: true,startDate:"+0d"}).datepicker("show");
    });
    $("#ifechaMaxInsp").focus(function() {
        $('#ifechaMaxInsp').daterangepicker(datetime_data);
        //$("#ifechaMaxInsp").datepicker({ language: 'es', autoclose: true,startDate:"+0d"}).datepicker("show");
    });
</script>