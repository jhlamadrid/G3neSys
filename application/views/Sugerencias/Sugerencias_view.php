<link rel="stylesheet" href="<?php echo $this->config->item('ip')?>frontend/plugins/sweetalert2/animate.css" >
<link rel="stylesheet" href="<?php echo $this->config->item('ip')?>frontend/plugins/sweetalert2/sweetalert2.min.css" >
<section class="content">
  <div class="row">
    <?php if (isset($_SESSION['mensaje'])) { ?>
      <div class="col-md-12">


       <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
           <?php echo $_SESSION['mensaje'][1]; ?>
       </div>
       </div>
       <br>
  <?php } ?>
    <div class="col-md-4 col-md-offset-4">
      <strong><h3 class="text-success text-center">SUGERENCIAS</h3></strong>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h4>Tiene x sugerencias pendientes</h4>
          <span class="pull-right badge bg-green" style="margin-left:10px">Atendidos</span>&nbsp;&nbsp;
          <span class="pull-right badge bg-yellow" >Pendientes</span>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id='sugerencias' class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                    <th>CÓDIGO</th>
                    <th>ASUNTO</th>
                    <th>NOMBRE</th>
                    <th>EMAIL</th>
                    <th>FECHA</th>
                    <th>TIPO</th>
                    <th>MEDIO</th>
                    <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($sugerencias as $sugerencia) {?>
                  <tr style="<?php $valor = (($sugerencia['PTGTTICK_ESTADO'] == 0) ? 'background-color: rgba(236, 163, 47, 0.52) !important;color:#000 !important' : 'background-color: rgba(0, 166, 90, 0.33) !important;color:#000 !important'); echo $valor; ?>">
                    <td><?php echo $sugerencia['PTGTTICK_CODE'];?></td>
                    <td><?php echo $sugerencia['PTGTTICK_ASUNTO'];?></td>
                    <td><?php echo $sugerencia['PTGTTICK_APELLIDOS']." ".$sugerencia['PTGTTICK_NOMBRES'];?></td>
                    <td><?php echo $sugerencia['PTGTTICK_EMAIL'];?></td>
                    <td><?php echo $sugerencia['FECHA'];?></td>
                    <td><?php echo $sugerencia['PTGTTICK_TAGS'];?></td>
                    <td><?php echo (($sugerencia['PTGTTICK_TTISO_CODE'] == 'MOV') ? 'MOVIL' : 'WEB');?></td>
                    <td style="text-align: center;">
                      <?php if($sugerencia['PTGTTICK_ESTADO'] == 0) {?>
                        <a href="<?php echo $this->config->item('ip')?>sugerencias/responder/<?php echo $sugerencia['PTGTTICK_CODE']?>" class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="bottom" title="Responder"><i class="fa fa-envelope"></i></a>
                        <a class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="bottom" title="Ver Respuesta" onclick="ver_respuesta()" ><i class="fa fa-eye"></i></a>
                        <?php } else { ?>
                          <a  class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="bottom" title="Responder"  disabled><i class="fa fa-envelope"></i></a>
                          <a class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="bottom" title="Ver Respuesta" onclick="ver_respuesta()" ><i class="fa fa-eye"></i></a>
                        <?php } ?>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      </di>
    </div>
  </div>
</div>
</section>
<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Detalle de la Sugerencia</h4>
            <span class="pull-right badge bg-red" id='fecha_denucia'></span>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
          </div>
        </div>
    </div>
</div>

<script src="<?php echo $this->config->item('ip');  ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip');  ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $('#sugerencias').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
  var ver_respuesta = () => {
    $("#myModal").modal('show');
  }
</script>
