
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Búsqueda de Derivaciones Pendientes</h3>
                </div>
                <div class="box-body">
                   <form role="form" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Estado:</label>
                                <div class="form-group">
                                    <div class="control-group">
                                        <select name="estados" id="estados" class="form-control">
                                            <option value="0" selected>TODOS LOS ESTADOS</option>
                                            <?php foreach($estados as $estado) {?>
                                               <?php if($est == $estado['SARDCOD']){ ?>
                                                    <option value="<?php echo $estado['SARDCOD']; ?>" selected><?php  echo $estado['SARDDES']; ?></option>
                                                <?php } else { ?>
                                                     <option value="<?php echo $estado['SARDCOD']; ?>"><?php  echo $estado['SARDDES']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <label>Area:</label>
                                <div class="form-group">
                                    <div class="control-group">
                                        <input type="text" class="form-control" name="area" id="area" value="FACTURACIÓN" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label>Fecha Inicio: </label>
                                           <div class="input-group">
                                               <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                               <?php if(isset($FIn)){?>
                                                   <input type="text" id="FchIn" name='FchIn' value='<?php echo $FIn; ?>' class="form-control">
                                               <?php } else { ?>
                                                   <input type="text" id="FchIn" name='FchIn' class="form-control">
                                               <?php } ?>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha Fin: </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <?php if(isset($FIn)) {?>
                                                   <?php if(isset($FFn)) { ?>
                                                    <input type="text" id="FchFn" name='FchFn' class="form-control" value="<?php echo $FFn; ?>">
                                                    <?php } else { ?>
                                                    <input type="text" id="FchFn" name='FchFn' class="form-control">
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <input type="text" id="FchFn" name='FchFn' class="form-control" disabled>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Oficina Origen: </label>
                                <div class="form-group">
                                    <div class="control-group">
                                        <select name="oficinas" id="oficinas" class="form-control">
                                            <option value="0" selected>TODAS LAS OFICINAS</option>
                                            <?php foreach($oficinas as $oficina) {?>
                                               <?php if($ofi == $oficina['OFICOD']) {?>
                                               <option value="<?php echo $oficina['OFICOD']; ?>" selected><?php echo $oficina['OFIDES']; ?></option>
                                               <?php } else {?>
                                               <option value="<?php echo $oficina['OFICOD']; ?>"><?php echo $oficina['OFIDES']; ?></option>
                                               <?php } ?>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <label for="">Suministro:</label>
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-compass"></i>
                                            </div>
                                            <?php if(isset($sumi)){ ?>
                                                <input type="number" class="form-control" value='<?php echo $sumi; ?>' name="suministro" id='suministro'>
                                            <?php } else { ?>
                                                 <input type="number" class="form-control" placeholder="12345678910" name="suministro" id='suministro'>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-2"></div>
                            <div class="col-md-4 col-xs-12">
                                <a href="<?php echo $this->config->item('ip').'facturacion/ver_regimenes' ?>" class="btn btn-success btn-block" value='Buscar'>Ver Todos</a>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <input type="submit" class="btn btn-warning btn-block" value='Buscar'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $cantidad_regimenes; ?> RECLAMOS POR REGIMEN ENCONTRADOS</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="regimenes" class="table table-bordered table-striped">
                            <thead>
                                <tr class="nivel1" role="row">
                                    <th>Nº Reclamo</th>
                                    <th>Derivación</th>
                                    <th>Suministro</th>
                                    <th>Derivado</th>
                                    <th>Solicitud</th>
                                    <th>Respuesta Máxima</th>
                                    <th>Respondido</th>
                                    <th>Estado Derivación</th>
                                    <th>Area Destino</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reclamos as $reclamo) {?>
                                    <tr>
                                        <td><?php echo $reclamo['RECID']; ?></td>
                                        <td><?php echo $reclamo['ARDCOD']; ?></td>
                                        <td><?php echo $reclamo['UUCOD']; ?></td>
                                        <td><?php echo $reclamo['FECHA1']; ?></td>
                                        <td><?php echo $reclamo['SOLUCION']; ?></td>
                                        <td><?php echo $reclamo['DRVFPZO']; ?></td>
                                        <td><?php echo ($reclamo['DRVFRES'] != '01/01/0001') ? $reclamo['DRVFRES'] : "//" ?></td>
                                        <td><?php switch($reclamo['SARDCOD']){ case "1" : echo "PENDIENTE";break; case "2" : echo "ATENDIDO";break; default: echo "ANULADO";break;  } ?></td>
                                        <td><?php echo ($reclamo['OFICODDE'] == "1") ? "SEDALIB CENTRAL" : "--" ?></td>
                                        <td style='text-align:center'>
                                           <?php #if($reclamo['SARDCOD'] == "1"){ ?>
                                                <a href="<?php echo $this->config->item('ip').'regimen/ver_regimen/'.$reclamo['EMPCOD']."-".$reclamo['OFICOD']."-".$reclamo['ARECOD']."-".$reclamo['CTDCOD']."-".$reclamo['DOCCOD']."-".$reclamo['SERNRO']."-".$reclamo['RECID']."-".$reclamo['UUCOD'];  ?>" class='btn btn-default btn-flat' data-toggle='tooltip' data-placement='bottom' title="GENERAR REGIMEN">
                                                    <i class="fa fa-spinner"></i>
                                                </a>
                                            <?php #} else if($reclamo['SARDCOD'] == "2"){ ?>
                                                <!--<a href="<?php #echo $this->config->item('ip').'regimen/visualizar_regimen/'.$reclamo['EMPCOD']."-".$reclamo['OFICOD']."-".$reclamo['ARECOD']."-".$reclamo['CTDCOD']."-".$reclamo['DOCCOD']."-".$reclamo['SERNRO']."-".$reclamo['RECID']."-".$reclamo['UUCOD'];  ?>" class='btn btn-default btn-flat' data-toggle='tooltip' data-placement='bottom' title="VER REGIMEN">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            <?php #} else { ?>
                                                <a href="#" class='btn btn-default btn-flat' data-toggle='tooltip' data-placement='bottom' title="VER REGIMEN">
                                                    <i class="fa fa-ban"></i>
                                                </a>-->
                                            <?php #} ?>
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
</section>

<!-- InputMask -->
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>


<!-- date-range-picker -->
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function (){
        $("#regimenes").dataTable({
  		"bSort": false,
        "lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, "Todos"]]
  	     });
    });
    $(document).ready(function(){
        $("#FchIn").inputmask("dd/mm/yyyy");
        $("#FchFn").inputmask("dd/mm/yyyy");
        var fechaStart = "'" + '<?php echo date('d/m/Y') ?>' + "'";
        //$('#FchFn').attr("disabled",true);
        $('#FchIn').daterangepicker({
            "showDropdowns": true,
            "singleDatePicker": true,
            "autoApply": false,
            "autoclose": true,
            "format": "DD/MM/YYYY",
            "separator": " / ",
            "startDate": fechaStart,
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " / ",
                "autoclose": true,
                "daysOfWeek": [
                    "Dom","Lun","Mar","Mie","Jue","Vie","Sab"
                ],
                "monthNames": [
                    "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                    "Agosto","Septiembre","Octubre","Noviembre","Diciembre"
                ],
                "firstDay": 1
            }
        }).on('apply.daterangepicker', function(ev, picker) {
            var fechaFchIn = picker.startDate.format('DD/MM/YYYY');
            var ini = moment(fechaFchIn, "DD/MM/YYYY");
            var fechaMin = moment(ini, "DD/MM/YYYY").add( 1 , 'days');
            $('#FchFn').val('');
            $('#FchFn').attr("disabled",false);
            $('#FchFn').daterangepicker({
                "showDropdowns": true,
                "singleDatePicker": true,
                "autoApply": false,
                "autoclose": true,
                "format": "DD/MM/YYYY",
                "separator": " / ",
                "startDate": fechaMin,
                "minDate": fechaMin,
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " / ",
                    "autoclose": true,
                    "daysOfWeek": [
                        "Dom","Lun","Mar","Mie","Jue","Vie","Sab"
                    ],
                    "monthNames": [
                        "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                        "Agosto","Septiembre","Octubre","Noviembre","Diciembre"
                    ],
                    "firstDay": 1
                }
            });
        });
    });

     var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	// Creating modal dialog's DOM
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content">' +
			'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
			'<div class="modal-body">' +
				'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
			'</div>' +
		'</div></div></div>');

	return {
		/**
		 * Opens our dialog
		 * @param message Custom message
		 * @param options Custom options:
		 * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
		 * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
		 */
		show: function (message, options) {
			// Assigning defaults
			if (typeof options === 'undefined') {
				options = {};
			}
			if (typeof message === 'undefined') {
				message = 'Cargando Recibos';
			}
			var settings = $.extend({
				dialogSize: 'm',
				progressType: '',
				onHide: null // This callback runs after the dialog was hidden
			}, options);

			// Configuring dialog
			$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
			$dialog.find('.progress-bar').attr('class', 'progress-bar');
			if (settings.progressType) {
				$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
			}
			$dialog.find('h3').text(message);
			// Adding callbacks
			if (typeof settings.onHide === 'function') {
				$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					settings.onHide.call($dialog);
				});
			}
			// Opening dialog
			$dialog.modal();
		},
		/**
		 * Closes dialog
		 */
		hide: function () {
			$dialog.modal('hide');
		}
	};

})(jQuery);

</script>
