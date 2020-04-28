<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SISTEMA COMERCIAL GENESYS</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="GeneSys">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="index,follow,noodp,noydir"/>
        <meta name="google-site-verification" content="T_M_Ym5DQ-cEQQhx_jswyCBTssIdgtewICcvb3sgh8g" />
        <meta name="Keywords" content="GeneSys" />
        <meta property="og:title" content="GeneSys" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="icon.png" />
        <meta property="og:description" content="GeneSys" />
        <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/ionicons.min.css" rel="stylesheet" type="text/css">-->
        <!--<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/estilos.css" rel="stylesheet" type="text/css">
        <!--<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/estilos_detalle_recibo.css" rel="stylesheet" type="text/css">-->
        <link rel="icon" type="image/png" href="<?php echo $this->config->item('ip'); ?>frontend/dist/img/favicon.ico" />
		<link rel="stylesheet" href="<?php echo $this->config->item('url') ?>frontend/plugins/alertify/css/alertify.min.css"/>
		<link rel="stylesheet" href="<?php echo $this->config->item('url') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>	
        <script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo $this->config->item('ip'); ?>frontend/bootstrap/js/bootstrap.min.js"></script>
        <style>
        @font-face {font-family: "Ubuntu";src: url(<?php echo $this->config->item('ip'); ?>frontend/font/UbuntuCondensed-Regular.ttf) format("truetype");  }
        *{ font-family: 'Ubuntu', sans-serif;  }
        </style>
    </head>
    <body class="sidebar-mini skin-green-light" style="padding-right:0px !important">
      <div class="wrapper">
        <header class="main-header">
          <a href="<?php echo $this->config->item('ip'); ?>inicio" class="logo">
            <span class="logo-mini"><b>G</b>Sys</span>
            <span class="logo-lg"><b>GeneSys</b></span>
          </a>
          <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav" id="notificaciones">
              <li class="dropdown messages-menu">
                <a class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-primary">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tiene 4 mensajes</li>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="<?php echo $this->config->item('ip'); ?>img/sedalito.png" class="img-circle" alt="Sedalito Image">
                          </div>
                          <h4>  Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">Ver todos los Mensajes</a></li>
                </ul>
              </li>
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tiene 10 Notificaciones</li>
                  <li>

                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">Ver todo</a></li>
                </ul>
              </li>
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tiene 9 Tareas</li>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">Ver todos los Tareas</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo $this->config->item('ip') . $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs" style="font-size:1.2em"><?php echo $userdata['NNOMBRE']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header" style="height: 195px;">
                  <img src="<?php echo $this->config->item('ip') . $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
					<?php echo  $_SESSION['user_nom']; ?>
                                        <small>Mienbro desde <?php echo $_SESSION['fchReg'] ?></small>
										<small>OFICINA: <?php  echo $_SESSION['oficina']; ?></small>
										<small>ÁREA: <?php  echo $_SESSION['area']; ?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a class="btn btn-default"  href="<?php echo $this->config->item('ip'); ?>configurar/usuario"><i class="fa fa-cogs" aria-hidden="true"></i> CONFIGURACIÓN</a>
                    </div>
                    <div class="pull-right">
                      <a onclick="salir()" class="btn btn-default btn-flat"><i class="fa fa-fw fa-power-off"></i> SALIR</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
              <img src="<?php echo $this->config->item('ip') . $_SESSION['imagen']; ?>" class="img-circle" style="width: 50px;height: 50px;" alt="Imagen del Usuario">
          </div>
          <div class="pull-left info">
            <p><?php echo $userdata['NNOMBRE']; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
          </div>
          
        </div>
        <ul class="sidebar-menu" style="margin: -5px 0px;">
          <li class="header">
            <small style="color: #296fb7;font-weight: bold;">OFICINA: <?php  echo $_SESSION['OFICINA']."-".$_SESSION['user_data']['NSEMPCOD'].'-'.$_SESSION['user_data']['NSOFICOD'].'-'.$_SESSION['user_data']['NSARECOD'].'-'.$_SESSION['user_id']; ?></small><br>
            <small style="color: #296fb7;font-weight: bold;">ÁREA: <?php  echo $_SESSION['AREA']; ?></small><br>
            <hr>
            NAVEGACIÓN PRINCIPAL <hr>
          </li>
		  <?php if($menuG) {?>
                <?php foreach($menuG as $m) {?>
                            <li class="treeview <?php echo ($m['MENUGENPDR'] == $menu['padre']) ? ' active' : '' ?>">
                                <a href="#" >
                                    <i class="<?php echo $m['MENUGENICON'] ?>"></i>
                                    <span><?php echo trim($m['MENUGENNOM']); ?></span>

                                        <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu ">
                                    <?php foreach ($m['actividades'] as $a){ ?>
                                        <li class="<?php echo ($a['ACTIVIHJO'] == $menu['hijo']) ? ' active' : '' ?>">
                                            <a href="<?php echo $this->config->item('url').$a['ACTIVIRUTA']; ?>">
                                                <i class="<?php echo $a['ACTIVIICON'].($a['ACTIVIHJO'] == $menu['hijo'] ? ' text-red' : ''); ?>"></i> <?php echo trim($a['ACTIVINOMB']); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }?>
                    <?php }?>
          <!-- <?php #if($_SESSION['MENU']) {
                 # foreach ($_SESSION['MENU'] as $menu1) { ?>
                    <li class="treeview<?php echo ($menu1['MENUGENPDR'] == $menu['padre']) ? ' active' : '' ?>">
                         <a href="#">
                             <i class="<?php echo $menu1['MENUGENICON'] ?>"></i><span><?php echo $menu1['MENUGENNOM']; ?></span><i class="fa fa-angle-left pull-right"></i>
                         </a>
                      <ul class="treeview-menu">
                        <?php foreach ($menu1['actividades'] as $actividad){ ?>
                          <li class="<?php echo ($actividad['ACTIVIHJO'] == $menu['hijo']) ? ' active' : '' ?>">
                              <a href="<?php echo $this->config->item('ip'); ?><?php echo $actividad['ACTIVIRUTA']; ?>">
                                  <i class="<?php echo $actividad['ACTIVIICON']; ?> <?php echo ($actividad['ACTIVIHJO'] == $menu['hijo']) ? ' text-red' : '' ?>"></i> <?php echo $actividad['ACTIVINOMB']; ?>
                              </a>
                          </li>
                        <?php } ?>
                      </ul>
                    </li>
          <?php # }
          #} ?> -->
          <li class="header">OPCIONES <hr> </li>
          <li><a onclick="salir()"><i class="fa fa-sign-out text-red" aria-hidden="true"></i> <span>SALIR</span></a></li>
        </ul>
      </section>
    </aside>
    <div id="fondo" class="content-wrapper hold-transition login-page">
      <section class="content-header">
        <p>
          <b> PROCESO: </b><small style="text-transform: uppercase;"> <?php echo $proceso; ?></small>
        </p>
        <ol class="breadcrumb" style="font-size:1.1 em">
          <li class="breadcrumb-item" ><a  style="color:#00a65a !important" href="<?php echo $this->config->item('ip'); ?>"><i class="fa fa-home"></i> Inicio</a></li>
          <?php foreach ($breadcrumbs as $bcItem) {
              if ($bcItem[1] != '') echo '<li class="breadcrumb-item" style="color:#00a65a"><a  href="' . $this->config->item('ip') . $bcItem[1] . '" > ' . $bcItem[0] . '</a></li>';
              else echo '<li class="breadcrumb-item active" >' . $bcItem[0] . '</li>';   } ?>
        </ol>
      </section>
      <?php if (isset($view)) $this->load->view($view); ?>
    </div>
    <footer class="main-footer">
      <div class="pull-right hidden-xs"> GeneSys | <b>Versión  0.1.0</b> </div>
      <strong>Copyright &copy; 2019 - SUBGERENCIA DE INFORMACIÓN E INFORMÁTICA - <a href="http://www.sedalib.com.pe/"><b>SEDALIB S.A.</b></a></strong>
    </footer>
    <div class="control-sidebar-bg"></div>
  </div>
  <script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/fastclick/fastclick.js"></script>
  <script src="<?php echo $this->config->item('ip'); ?>frontend/dist/js/app.min.js"></script>
  <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
  <script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
  <script> function salir() { swal({ title: "<h1 style='font-family:\"Ubuntu\"'>¿Seguro que desea Salir?</h1>", text: "Saldrá del sistema sin guardar los cambios que haya realizado!",
                 type: "warning", html: true, showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                 confirmButtonText: "Si, deseo Salir", cancelButtonText: "Cancelar", closeOnConfirm: false },
               function(isConfirm) {
                if (isConfirm) { swal({ title: 'Ha salido del Sistema', text: 'Ha Salido del Sistema.', type: 'success', showConfirmButton: false }),
                    window.location.href = "<?php echo $this->config->item('ip'); ?>logout"; }
    }); }
   </script>
  </body>
</html>
