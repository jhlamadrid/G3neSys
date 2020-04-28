<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>


<section class="content">


<?php if(isset($_SESSION['mensaje'])) { ?>
    <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-<?php echo ($_SESSION['mensaje'][0] == 'error') ? "ban" : "check" ?>"></i> <?php echo  ($_SESSION['mensaje'][0] == 'error') ? 'Error' : 'Ok'; ?></h4>
        <?php echo $_SESSION['mensaje'][1]; ?>
    </div>
<?php } ?>

<div class="row font-text">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">Respuestas a Solicitudes de Reclamo</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="reclamos" class="table table-bordered table-striped">
                            <thead>
                                <tr role="row">
                                    <th>Código</th>
                                    <th>DNI</th>
                                    <th>Fecha/Hora</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Quedan</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reclamos as $r) {?>  
                                    <tr>
                                        <td><?php echo $r['EMPCOD']."-".$r['OFICOD']."-".$r['ARECOD']."-".$r['CTDCOD']."-".$r['DOCCOD']."-".$r['SERNRO']."-".$r['RECID'] ?></td>
                                        <td><?php echo $r['DOCIDENT_NRODOC']; ?></td>
                                        <td><?php echo $r['RECFCH']." ".$r['RECHRA']; ?></td>
                                        <td><?php echo $r['RECDESC']; ?></td>
                                        <td><?php echo ($r['PROBID'] == null ? '<span class="badge bg-blue">General</span>' : '<span class="badge bg-green">Particular</span>') ?></td>
                                        <td><?php echo ($r['SRECCOD'] == 1 ? '<span class="badge badge-warning">Pendiente</span>' : '<span class="badge bg-info">Atendido</span>')?></td>
                                        <td><?php echo "" ?></td>
                                        <td class="text-center">
                                            <?php if($r['PROBID'] == null )  {?>
                                            <a  class="btn btn-default btn-xs" 
                                                href="<?php echo $this->config->item('url')."relativo_no_facturacion/solicitud_general/ver/".$r['EMPCOD']."/".$r['OFICOD']."/".$r['ARECOD']."/".$r['CTDCOD']."/".$r['DOCCOD']."/".$r['SERNRO']."/".$r['RECID'] ?>"    
                                            >               
                                                <i class="fa fa-print" aria-hidden="true"></i>
                                            </a>
                                            <?php } else { ?>
                                                <a  class="btn btn-default btn-xs" 
                                                    href="<?php echo $this->config->item('ip')."relativo_no_facturacion/solicitud_particular/ver/".$r['EMPCOD']."/".$r['OFICOD']."/".$r['ARECOD']."/".$r['CTDCOD']."/".$r['DOCCOD']."/".$r['SERNRO']."/".$r['RECID'] ?>"    
                                                >               
                                                    <i class="fa fa-print" aria-hidden="true"></i>
                                                </a>
                                            <?php } ?>
                                            <a  class="btn btn-default btn-xs" onclick="escribirRespuesta('<?php echo $r['EMPCOD'] ?>', '<?php echo $r['OFICOD'] ?>', '<?php echo $r['ARECOD'] ?>', '<?php echo $r['CTDCOD'] ?>', '<?php echo $r['DOCCOD'] ?>', '<?php echo $r['SERNRO'] ?>', '<?php echo $r['RECID'] ?>', '<?php echo $r['RECDESC']?>')">               
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
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
    <div id="respuesta" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content contenido_modal" >
				<div class="modal-header bg-info" style="border-radius:4px">
				    <button type="button" class="close" data-dismiss="modal">&times;</button>
				    <h4 class="modal-title titulo_modal"> <i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Respuesta a la solicitud <span id="codReclamo"></span></h4>
				</div>
				<div class="modal-body">
				    <div class="row">
						<div class="col-md-12">
						<div class="callout bg-success cuadro_dialogo">
								
								<p id="descripcionSolicitud"> </p>
						</div>
					</div>
				</div><br>
				<div class="row">
                        <div class="col-md-2"></div>
						<div class="col-md-8 ">
							<div class="form-group has-error">
							    <label class="control-label" for="serie"><i class="fa fa-check"></i> Respuesta a la Solicitud</label>
							    <textarea class="form-control" name="descripcion" id="descripcion"  rows="5" style="width:100%"></textarea>
                            </div>
						</div>
				</div>
				<div class="modal-footer borde_footer">
				<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-6">
						<button type="button" class="btn btn-danger btn-sm" style="width:100%" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; Cancelar</button>
						</div>
					<div class="col-md-6 col-sm-6">
					</div>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<button type="button" class="btn btn-success btn-sm" style="width:100%" onclick="guardarRespuesta()"><i class="fa fa-save" aria-hidden="true"></i> &nbsp; Guardar</button>
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

var EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, RECID, DESC;
var base_url = window.location.origin
var app = `GeneSys` 

if(document.querySelector("#reclamos") !== null) $('#reclamos').DataTable({responsive: true,bSort:false,bInfo: false,"autoWidth": true,});
function escribirRespuesta(EMPCOD1, OFICOD1, ARECOD1, CTDCOD1, DOCCOD1, SERNRO1, RECID1, DESC1){ 
    EMPCOD  = EMPCOD1;
    OFICOD  = OFICOD1;
    ARECOD = ARECOD1;
    CTDCOD = CTDCOD1;
    DOCCOD = DOCCOD1;
    SERNRO = SERNRO1;
    RECID = RECID1;
    DESC = DESC1;
    $("#respuesta").modal({backdrop: 'static', keyboard: false, show:"show"});  
    $("#codReclamo").html(EMPCOD+"-"+OFICOD+"-"+ARECOD+"-"+CTDCOD+"-"+DOCCOD+"-"+SERNRO+"-"+RECID);
    $("#descripcionSolicitud").html(DESC);
};  

function guardarRespuesta(){
    let  desc = $("#descripcion").val();
    $.ajax({ 
	  	type : 'POST', 
          url  : base_url+'/'+app+'/relativo_no_facturacion/almacenarRespuesta?ajax=true', 
          data : ({
            EMPCOD : EMPCOD,
              OFICOD: OFICOD,
              ARECOD : ARECOD, 
              CTDCOD: CTDCOD, 
              DOCCOD: DOCCOD,
              SERNRO: SERNRO,
              RECID: RECID, 
              desc : desc
        }),
	  	cache : false,
	  	dataType : 'json',
	  	success : function(resultado){
			//waitingDialog.hide();
			if(resultado.res){
				
				setTimeout(() => {
                    window.location.reload();
				}, 500);
			} else {
                alert(resultado.msg)
				//alertify.alert('<span class="text-yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</span>', '<strong>'+resultado.mensaje+'</strong>');    
			}
	  	}, error : function(jqXHR , textStatus, errorThrown){
			 _error(jqXHR , textStatus, errorThrown);
		}
	});
}
</script>