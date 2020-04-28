<?php 
$data = 'http://ourcodeworld.com';
// QRCode size
$size = '500x500';
// Path to image (web or local)
$logo = $this->config->item('ip').'img/sedalito2.png';

// Get QR Code image from Google Chart API
// http://code.google.com/apis/chart/infographics/docs/qr_codes.html
$QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));

// START TO DRAW THE IMAGE ON THE QR CODE
$logo = imagecreatefromstring(file_get_contents($logo));
$QR_width = imagesx($QR);
$QR_height = imagesy($QR);

$logo_width = imagesx($logo);
$logo_height = imagesy($logo);

// Scale logo to fit in the QR Code
$logo_qr_width = $QR_width/3;
$scale = $logo_width/$logo_qr_width;
$logo_qr_height = $logo_height/$scale;

imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

// END OF DRAW

/**
 * As this example is a plain PHP example, return
 * an image response.
 *
 * Note: you can save the image if you want.
 */
//header('Content-type: image/png');
imagepng($QR, 'myqrcodewithlogo.png');
imagedestroy($QR);


?>

<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
       		<?php if (isset($_SESSION['mensaje'])) { ?>
        		<div class="alert bg-<?php echo $_SESSION['mensaje'][0]; ?> alert-dismissible">
            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            		<?php echo $_SESSION['mensaje'][1]; ?>
        		</div><br>
        	<?php } ?>
            <div class="panel  panel-primary">
				<div class="panel-heading borde_box">
                    <h4 class="titulo_box" style="font-family: Ubuntu"><i class="fa fa-book"></i> Administración del Libro de Observaciones</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo">Tipo documento</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <?php $k = 0; foreach($tipos as $t) {?>
                                        <option value="<?php echo $t['TIPDOCCOD']?>" <?php echo (($k == 0) ? 'selected' : '' )?>><?php echo $t['TIPDOCDESC']?></option>
                                    <?php $k++;} ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo">N° documento</label>         
                                <input type="text" class="form-control" id="nroDoc">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-success btn-md" style="width:100%;margin-top:20px" onclick="buscarObs()"> <i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
            			<div class="col-md-12 table-responsive">
              				<table id="obsS" class="table table-bordered table-striped">
                				<thead>
                  					<tr>
                    					<th>N° Ficha</th>
                    					<th>Documento</th>
                    					<th>Nombre</th>
                    					<th>Fecha Registro</th>
                    					<th>Estado</th>
                                        <th>Fecha Respuesta</th>
                    					<th>Opciones</th>
                  					</tr>
                				</thead> 
                				<tbody id='cuerpo_obs'>
                    				<?php foreach ($obs as $o) { ?>
                  						<tr>
                    						<td style="text-align:right"><?php echo str_pad( $o['CODIGO'], 6, '0', STR_PAD_LEFT)."-".$o['ANIO']; ?></td>
                                            <td>
                                                <?php echo $o['TIPDOCDESC']; ?>: <br> <b><?php echo $o['NRODOC']?></b>
                                            </td>
                    						<td><?php echo $o['NOMBRE']." ".$o['APEPAT']." ".$o['APEMAT']; ?></td>
                    						<td style="text-align:right"><?php echo $o['FECREG']; ?></td>
                    						<td style="text-align:center"><?php echo (($o['ESTADO'] == 1) ? '<span class="badge bg-red">En proceso</span>' : '<span class="badge bg-green">Atendido</span>'); ?></td>
                                            <td style="text-align:right"><?php echo $o['FECRPTA']; ?></td>
                    						<td style="text-align:center">
                                                <?php if($o['ESTADO'] == 1) {?>
                                                    <a href="<?php echo  $this->config->item('ip')."libro_obs/administrar/detalle/".$o['LOBSCOD']?>" class="btn btn-success btn-xs"> 
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Responder
                                                    </a>
                                                <?php } else {?>
                                                    <a  class="btn btn-info btn-xs" href="<?php echo  $this->config->item('ip').'libro_observaciones/pdf/'.$o['LOBSCOD']; ?>" target="_blank"> 
                                                        <i class="fa fa-eye" aria-hidden="true"></i> Detalle
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

</section>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script>
    $('#obsS').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});

     var waitingDialog = waitingDialog || (function ($) { 'use strict';
        var $dialog = $('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;"><div class="modal-dialog modal-m"><div class="modal-content" style="border-radius:5px">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>');
        return { show: function (message, options) { if (typeof options === 'undefined') options = {}; if (typeof message === 'undefined') message = 'Cargando Recibos'; var settings = $.extend({ dialogSize: 'm', progressType: '', onHide: null  }, options);$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);$dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType); $dialog.find('h3').text(message);
            if (typeof settings.onHide === 'function') { $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) { settings.onHide.call($dialog); }); } $dialog.modal();},hide: function () { $dialog.modal('hide'); }
        };})(jQuery);

    function buscarObs(){
        if($("#nroDoc").val() != ""){
            waitingDialog.show("Buscando observaciones....");
            $.ajax({ 
                type : "POST",
                url : "<?php echo base_url(); ?>libro_obs/administrar/buscar?ajax=true", 
                data : ({ 
                    tipo : $("#tipo").val(), 
                    numero: $("#nroDoc").val()
                }),
                cache : false, 
                dataType  : 'json',
                success : function(resultado){ 
                    waitingDialog.hide();
                    $("#cuerpo").html("");
                    if(resultado.result){
                        $("#obsS").dataTable().fnDestroy(); 
                        $("#cuerpo_obs").html(""); 
                        let contenido = '';
                        var pad = "000000"
                        for(let i = 0; i < resultado.obs.length; i++){
                            contenido += `<tr >
                                            <td class="text-right">${pad.substring(0, pad.length - resultado.obs[i]['CODIGO'].length) + resultado.obs[i]['CODIGO']}-${resultado.obs[i]['ANIO']}</td>
                                            <td>
                                                ${resultado.obs[i]['TIPDOCDESC']}: <b>${resultado.obs[i]['NRODOC']}</b>
                                            </td>
                                            <td>${resultado.obs[i]['NOMBRE']} ${resultado.obs[i]['APEPAT']} ${resultado.obs[i]['APEMAT']}</td>
                                            <td class="text-right">${resultado.obs[i]['FECREG']}</td>
                                            <td class="text-center"><span class="badge bg-${(resultado.obs[i]['ESTADO'] == 1) ? 'red': 'green'}">${(resultado.obs[i]['ESTADO'] == 1) ? 'En proceso': 'Atendido'}</span></td>
                                            <td class="text-right">${resultado.obs[i]['FECRPTA']}</td>
                                            <td class="text-center">`;
                            if(resultado.obs[i]['ESTADO'] == 1){
                                contenido += `<a class="btn btn-success btn-xs" href="<?php echo base_url().'libro_obs/administrar/detalle/'; ?>${resultado.obs[i]['LOBSCOD']}" > 
                                                    <i class="fa fa-pencil" aria-hidden="true"></i> Responder 
                                                </a>`;
                            } else {
                                contenido += `<a class="btn btn-info btn-xs"  href="<?php echo base_url().'libro_observaciones/pdf/'; ?>${o['LOBSCOD']}" target="_blank"> 
                                                    <i class="fa fa-eye" aria-hidden="true"></i> Detalle 
                                                </a>`;
                            }
                            contenido += `</td>
                                        <tr>`;
                        }
                        $("#cuerpo_obs").html(contenido);
                        $('#obsS').DataTable({ bInfo: false,"ordering": false,lengthMenu: [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
                    } else { 
                        waitingDialog.hide();
                        swal({title : "", text : resultado.mensaje, type: "warning"}) 
                        
                    }
                }, error : function(jqXHR,textStatus,errorThrown){ 
                    _error(jqXHR,textStatus,errorThrown);
                }
            })
        } else {
            swal({title : "", text : "Debe completar el número del documento", type: "warning"}) 
        }
    }
</script>