<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalle Recibo</title>
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <!-- Morris charts -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/morris/morris.css" rel="stylesheet" type="text/css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/estilos.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="<?php echo $this->config->item('ip'); ?>frontend/dist/img/favicon.ico" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $this->config->item('ip');?>frontend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $this->config->item('ip');?>frontend/bootstrap/js/bootstrap.min.js"></script>
    <script>
        function imprimir(doccod, sernro, cmpnro){
            var myWindow = window.open("<?php echo $this->config->item('ip').'documentos/boletas_facturas/imprimir/'; ?>"+doccod+"/"+sernro+"/"+cmpnro, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
            //myWindow.document.close();
            myWindow.focus();
            myWindow.print();
            //myWindow.close();
        }
    </script>

</head>

<body style="margin:20px;">

    <section class="content">
        <div class="row">
            <!--div class="col-md-12">
            <?php if (isset($_SESSION['mensaje'])) { ?>
                    <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $_SESSION['mensaje'][1]; ?>
                    </div><br>
            <?php } ?>
            </div-->
            <div class="row">
                <div class="col-md-4 col-sm-3 col-sx-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon3">SERIE:</span>
                      <input type="text" class="form-control" id="basic-url" value="<?php echo $cliente['FSCSERNRO'] ?>" aria-describedby="basic-addon3" disabled>
                    </div><br>
                </div>
                <div class="col-md-4 col-sm-3 col-sx-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon3">NUMERO:</span>
                      <input type="text" class="form-control" id="deuda_capital" value="<?php echo $cliente['FSCNRO'] ?>" aria-describedby="basic-addon3" disabled>
                    </div><br>
                </div>
                <div class="col-md-4 col-sm-6 col-sx-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon3">FECHA:</span>
                      <input type="text" class="form-control" id="deuda_final" value="<?php echo $cliente['FSCFECH'] ?>" aria-describedby="basic-addon3" disabled>
                    </div><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon3">NOMBRE:</span>
                      <input type="text" class="form-control" id="basic-url" value="<?php echo $cliente['FSCCLINOMB'] ?>" aria-describedby="basic-addon3" disabled>
                    </div><br>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon3">DIRECCION:</span>
                      <input type="text" class="form-control" id="basic-url" value=" " aria-describedby="basic-addon3" disabled>
                    </div><br>
                </div>
                <!--div class="col-md-6 col-sm-6">

                </div-->
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="recibos_pendientes" class="table table-bordered table-striped">
                        <thead>
                            <tr role="row">
                                <th>CODIGO</th>
                                <th>DESCRIPCION</th>
                                <th>CANTIDAD</th>
                                <th>P. UNIT.</th>
                                <th>IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach($descripcion as $fila) { ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $fila['FACCONCOD']; ?></td>
                                    <td><?php echo $fila['FACCONDES']; ?></td>
                                    <td style="text-align: right;"><?php echo $fila['CANT']; ?></td>
                                    <td style="text-align: right;"><?php echo number_format($fila['PUNIT'],2); ?></td>
                                    <td style="text-align: right;"><?php echo number_format($fila['FSCPRECIO'],2); ?></td>
                                </tr>
                            <?php } ?>
                            <!--tr>
                                <td style="text-align:right;padding-right:30px" colspan="4">SUB TOTAL</td>
                                <td style="text-align:right"><?php echo number_format(floatval($cliente['CMPSUMVTA']),2); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;padding-right:30px" colspan="4">I.G.V.</td>
                                <td style="text-align:right"><?php echo number_format(floatval($cliente['CMPSUMIGV']), 2, '.', ''); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;padding-right:30px" colspan="4">TOTAL</td>
                                <td style="text-align:right;color:#f00;font-size:20px"><?php echo number_format(floatval($cliente['CMPTOTGRL']), 2, '.', ''); ?></td>
                            </tr-->
                        </tbody>
                     </table>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-md-offset-8 col-sm-offset-8">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th style="text-align:right;padding-right:30px" colspan="4">SUB TOTAL</th>
                                    <td style="text-align:right"><?php echo number_format(floatval($cliente['FSCSUBTOTA']),2); ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align:right;padding-right:30px" colspan="4">I.G.V.</th>
                                    <td style="text-align:right"><?php echo number_format(floatval($cliente['FSCSUBIGV']), 2, '.', ''); ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align:right;padding-right:30px" colspan="4">TOTAL</th>
                                    <td style="text-align:right;color:#f00;font-size:20px"><?php echo number_format(floatval($cliente['FSCTOTAL']), 2, '.', ''); ?></td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
