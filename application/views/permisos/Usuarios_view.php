<!-- sweetAlert. -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/permisos/index_permisos.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<section class="content">
  <div class="col-md-12 text-blue">
    <?php if (isset($_SESSION['mensaje'])) { ?>
     <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $_SESSION['mensaje'][1]; ?>
     </div><br>
     <?php } ?>
  </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Últimos miembros</h3>
              <div class="box-tools pull-right">
                <span class="label label-danger">8 Nuevos Miembros</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                <?php foreach ($last_user as $user ) { ?>
                  <li>
                    <img src="<?php  echo $this->config->item('ip').'/assets/uploads/usuarios/default.jpg' ?>" alt="User Image" width="64">
                    <a class="users-list-name" href="#"><?php echo $user['NNOMBRE']; ?></a>
                    <span class="users-list-date">F.R.: <?php echo $user['NFECHAE']; ?></span>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
      </div>
      <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">
                <a type="button" href='<?php echo $this->config->item('ip').'permisos/administrar_usuarios/agregar'; ?>' class="btn btn-success font-new">
                  <i class="fa fa-plus" aria-hidden="true"></i> NUEVO USUARIO
                </a>
              </h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                      <table id="lista_usuarios" class="table table-bordered table-striped">
                          <thead>
                              <tr role="row">
                                <th>NOMBRE</th>
                                <th>USUARIO</th>
                                <th>DIRECCION</th>
                                <th>FECHA INICIO</th>
                                <th>FECHA FIN</th>
                                <th>ESTADO</th>
                                <th>OPCIONES</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($usuarios as $user) { ?>
                              <tr>
                                <td><?php echo $user['NNOMBRE']; ?></td>
                                <td><?php echo $user['LOGIN']; ?></td>
                                <td><?php echo $user['NDIRECC']; ?></td>
                                <td><?php echo $user['NFECHAE']; ?></td>
                                <td><?php echo $user['NENDS']; ?></td>
                                <td><?php if($user['NESTADO'] == 0) { ?>
                                  <span class="label label-warning">INACTIVO</span>
                                  <?php }  else if ($user['NESTADO'] == 1) {?>
                                    <span class="label label-success">ACTIVO</span>
                                  <?php } else if ($user['NESTADO'] == 2) { ?>
                                    <span class="label label-danger">ELIMINADO</span>
                                  <?php } else if($user['NESTADO'] == 3) { ?>
                                    <span class="label label-info">MANTENIMIENTO</span>
                                <?php } ?>
                                </td>
                                <td style="text-align:center">
                                  <a class="btn btn-default" href="<?php $cod= intval($user['NCODIGO']*4152); echo $this->config->item('ip').'permisos/administrar_usuarios/editar/'.$cod;  ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
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
    </div>
</section>

<!--<script src="./frontend/dist/js/Genesys/permisos/index_admin_user.min.js"></script>-->
<script src="<?php echo $this->config->item('ip'); ?>/frontend/dist/js/Genesys/permisos/index_admin_user.js"></script>
