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
                <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">Reclamos de Alcance General</h3>
                <?php if($_SESSION['accesoReclamos'] != null && $_SESSION['accesoReclamos']['ARECOD'] != null) {?>
                    <a class="btn btn-success pull-right" href="<?php echo $this->config->item('ip')?>relativo_no_facturacion/solicitud_general/nuevo">Nueva Solicitud</a>
                <?php } ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="reclamos" class="table table-bordered table-striped">
                            <thead>
                                <tr role="row">
                                    <th>Código</th>
                                    <th>DNI</th>
                                    <th>Suministro</th>
                                    <th>Fecha/Hora</th>
                                    <th>Descripción</th>
                                    <th>Quedan</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reclamos as $r) {?>
                                    <tr>
                                        <td><?php echo $r['EMPCOD']."-".$r['OFICOD']."-".$r['ARECOD']."-".$r['CTDCOD']."-".$r['DOCCOD']."-".$r['SERNRO']."-".$r['RECID'] ?></td>
                                        <td><?php echo $r['DOCIDENT_NRODOC']; ?></td>
                                        <td><?php echo $r['UUCOD']; ?></td>
                                        <td><?php echo $r['RECFCH']." ".$r['RECHRA']; ?></td>
                                        <td><?php echo $r['RECDESC']; ?></td>
                                        <td></td>
                                        <td class="text-center">
                                            <a  class="btn btn-default btn-flat" 
                                                href="<?php echo $this->config->item('url')."relativo_no_facturacion/solicitud_general/ver/".$r['EMPCOD']."/".$r['OFICOD']."/".$r['ARECOD']."/".$r['CTDCOD']."/".$r['DOCCOD']."/".$r['SERNRO']."/".$r['RECID'] ?>"    
                                            >               
                                                <i class="fa fa-print" aria-hidden="true"></i>
                                            </a>
                                        </td> 
                                    </tr>
                                <?php }?>
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

if(document.querySelector("#reclamos") !== null) $('#reclamos').DataTable({responsive: true,bSort:false,bInfo: false,"autoWidth": true,});
</script>