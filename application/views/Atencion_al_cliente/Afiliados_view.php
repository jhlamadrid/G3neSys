<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<section class="content">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <strong><h3 class="text-success text-center">TOTAL DE AFILIADOS</h3></strong>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h4>Lista de todos los Afiliados</h4>
          
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id='afiliados' class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                    <th>SUMINISTRO</th>
                    <th>NOMBRE</th>
                    <th>DOC. DE IDENT.</th>
                    <th>ESTADO</th>
                    <th>DOCUMENTO</th>
                    
                </tr>
              </thead>
              <tbody >
                <?php foreach ($afiliados as $afiliado) {?>

                    <tr>
                    <td><?php echo $afiliado['CLICODFAC']?></td>
                    <td><?php echo $afiliado['CLINOM']?></td>
                    <td><?php echo $afiliado['CLIDOCIDENT']?> </td>
                    <?php if($afiliado['ESTADO']=='A'){?>
                      <td> Afiliado </td>
                    <?php }else{?>
                      <td> Desafiliado </td>
                    <?php }?>
                     <?php if($afiliado['DOCADJ']=='1'){?>
                      <td> <a href="<?php echo $this->config->item('ip').$afiliado['DIRARCH'] ?>" target="_blank"  ><button class="btn btn-success btn-block btn-flat"> ADJUNTADO</button> </td> </a> 
                    <?php }else{?>
                      <td> <a href="<?php echo $this->config->item('ip').'Atencion_al_cliente/adjunta_doc/'.$afiliado['CLICODFAC'] ?>"><button class="btn btn-danger btn-block btn-flat"> ADJUNTAR</button> </a> </td>
                    <?php }?>   
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
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script>
  $('#afiliados').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
  
</script>