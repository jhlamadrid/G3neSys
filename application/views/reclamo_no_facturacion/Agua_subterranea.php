<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="<?php echo $this->config->item('url')?>frontend/appbuild/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('url')?>frontend/appbuild/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

<?php if(isset($_SESSION['mensaje'])) { ?>
    <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-<?php echo ($_SESSION['mensaje'][0] == 'error') ? "ban" : "check" ?>"></i> <?php echo  ($_SESSION['mensaje'][0] == 'error') ? 'Error' : 'Ok'; ?></h4>
        <?php echo $_SESSION['mensaje'][1]; ?>
    </div>
<?php } ?>
<div class="row font-text">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Reclamos por Aguas Subterraneas
                    
                </h3>
                <a class="btn btn-success pull-right" href="<?php echo $this->config->item('url')?>relativo_no_facturacion/agua_subterranea/nuevo">Nuevo Reclamo</a>
            </div>
            <div class="box-body">
                
            </div>
        </div>
    </div>
</div>