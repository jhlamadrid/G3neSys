<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="<?php echo $this->config->item('ip') ?>img/favicon.ico">
    <link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" />
    <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo $this->config->item('ip') ?>frontend/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js" type="text/javascript"></script>
    <style type="text/css" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/cuenta_corriente/template.css"></style>
    <style>
    @font-face { font-family: "Ubuntu";
                src: url(<?php echo $this->config->item('ip'); ?>frontend/font/UbuntuCondensed-Regular.ttf) format("truetype");
    }
    *{ font-family: 'Ubuntu'; }
    </style>
</head>
<body style="padding-right: 0px !important">
  <?php (isset($view) ? $this->load->view($view) : ''); ?>
</body>
</html>
