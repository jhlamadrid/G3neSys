<!-- sweetAlert. -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>

<section class="content">
    <div class="row">
        <div class="col-md-12 text-blue">
          <?php if (isset($_SESSION['mensaje'])) { ?>
           <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <?php echo $_SESSION['mensaje'][1]; ?>
           </div><br>
           <?php } ?>
        </div>
    </div>
    <?php echo var_dump($_SESSION['user_comercial']); ?>
    <div class='row'>
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo $this->config->item('ip').$userdata['RUTIMAGEN']; ?>" style="    height: 100px;"alt="Imagen Usuario">
                    <h3 class="profile-username text-center" style="font-family:'Ubuntu'"><?php echo $userdata['NNOMBRE'] ?></h3>
                    <p class="text-muted text-center"><?php echo $rol; ?></p>
                    <ul class="list-group list-group-unbordered">
                        <?php echo $cuerpo; ?>
                    </ul>
                <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
                </div>
            <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-default">
                <div class="box-header with-border">
                    <i class="fa fa-bullhorn"></i>
                    <h3 class="box-title" style="font-family:'Ubuntu'">ALERTAS</h3>
                </div>
            <!-- /.box-header -->
                <div class="box-body">

                    <div class="callout callout-success">
                        <h4 style="font-family:'Ubuntu'">Solicitud de Reclamo General y Particular!</h4>
                        <p>Se podrá realizar solicitudes de Reclamos Operacionales y Comerciales con respecto a la no Facturación. <br>
                        Ya se encuentran asignados los permisos para este módulo.</p>
                    </div>

                    <div class="callout callout-info">
                        <h4 style="font-family:'Ubuntu'">Se agregaron nuevas funcionalidades!</h4>
                        <p>Se podrá visualizar el histórico de consumo dentro de la cuenta Corriente, en la opción de VARIOS. <br>
                        También tendrá la posibilidad de ver el predio de la persona a traves de la herramienta GIS en la opción de APLICATIVOS EXTERNOS.</p>
                    </div>
                
                </div>
            <!-- /.box-body -->
            </div>
        <!-- /.box -->
        </div>
    </div>
</section>
