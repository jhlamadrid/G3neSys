<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SISTEMA  COMERCIAL GENESYS</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="description" content="GeneSys">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="index,follow,noodp,noydir"/>
        <meta name="google-site-verification" content="T_M_Ym5DQ-cEQQhx_jswyCBTssIdgtewICcvb3sgh8g" />
        <meta name="Keywords" content="GeneSys" />
        <meta property="og:title" content="GeneSys" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="icon.png" />
        <meta property="og:description" content="GeneSys" />
        <link rel="stylesheet" href="./frontend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./frontend/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./frontend/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="./frontend/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./frontend/dist/css/estilos.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="./frontend/dist/img/favicon.ico" />
		<link rel="stylesheet" href="<?php echo $this->config->item('url') ?>frontend/plugins/alertify/css/alertify.min.css"/>
		<link rel="stylesheet" href="<?php echo $this->config->item('url') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>	
        <script src="./frontend/plugins/sweetalert/sweetalert2.min.js"></script>
        <script src="./frontend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="./frontend/dist/js/flowtype.js"></script>
        <script>
            $('body').flowtype({
               minimum : 500,
               maximum : 1200,
               minFont   : 12,
               maxFont   : 40,
               fontRatio : 30
            });

        </script>
        <style>
        @font-face {font-family: "Ubuntu";src: url(./frontend/font/UbuntuCondensed-Regular.ttf) format("truetype");  }
        *{ font-family: 'Ubuntu', sans-serif;  }
        #padre { position: relative; }
        #hijo { position: absolute; top: 50%; left: 50%;height: 100%;width: 90%;margin: 5% 0 0 -45%;}
        </style>
    </head>
    <body id="fondo" class="sidebar-mini layout-boxed skin-green-light">
      <div id='padre'>
        <div id="hijo">
          <center> <img id="title-scd" src="./img/logo.png" style="width:35%;height:auto;margin-top:40px"></center>
          <div style="margin:25px">
            <center>
              <a href="./login" class="text-green" style="font-size:3vw"><b>BIENVENIDO AL SISTEMA COMERCIAL GENESYS</b></a>
            </center>
          </div>
          <div class="login-box">
            <div class="login-box-body" style="border: 1px solid green;">
              <p class="login-box-msg">Escriba su cuenta de usuario y su contraseña correctamente.</p>
              <?php if($this->session->flashdata('error') != null) { ?>
                <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <?php echo $this->session->flashdata('error');?>
                </div>
              <?php } ?>
              <form id="formLogin" method="post">
                <div class="lockscreen-item" style="border:1px solid #008d4c;width: 100%;">
                  <div class="lockscreen-credentials"  style="margin-left: 10px;">
                    <div class="input-group">
                      <input type="text" class="form-control" style="font-weight: bold;" name="username" id="username" placeholder="Usuario">
                      <div class="input-group-btn">
                        <a class="btn" style="color:#3c8dbc"><i class="fa fa-user text-muted" style="color:#3c8dbc"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="lockscreen-item" style="border:1px solid #008d4c;width: 100%;">
                  <div class="lockscreen-credentials" style="margin-left: 10px;">
                    <div class="input-group">
                      <input type="password" class="form-control" style="font-weight: bold;" name="password" id="emailAgain" placeholder="Contraseña">
                      <div class="input-group-btn">
                        <a  style='text-decoration:none;color:#3c8dbc' class="btn"><i class="fa fa-lock" style="color:#3c8dbc"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-hand-o-right" aria-hidden="true"></i> INGRESAR</button>
                  </div>
                </div>
              </form><br>
              <hr>
              <center>
                <strong>Copyright &copy; 2016 - SUBGERENCIA DE INFORMACIÓN E INFORMÁTICA - <a href="http://www.sedalib.com.pe/"><b>SEDALIB S.A.</b></a></strong>
              </center>
            </div>
          </div>
      </div>
  </div>
		<script src="<?php echo $this->config->item('url') ?>frontend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<script src="<?php echo $this->config->item('url') ?>frontend/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->config->item('url') ?>frontend/plugins/validation/jqBootstrapValidation.js"></script>
		<script src="<?php echo $this->config->item('url') ?>frontend/plugins/validation/validate.js"></script>
		<script src="<?php echo $this->config->item('url') ?>frontend/plugins/alertify/alertify.js"></script>
		<script src="<?php echo $this->config->item('url') ?>frontend/dist/js/app/global.js"></script>
		<script src="<?php echo $this->config->item('url') ?>frontend/dist/js/app/login.js"></script>

   </body>
</html>
