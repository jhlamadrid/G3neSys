<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>
<?php $moratorio = 0; ?>
<script type="text/javascript">
  let servidor = '<?php echo $this->config->item('ip'); ?>';
  let suministro = '<?php echo $user_datos['CLICODFAC']; ?>';
  var  suministro1 = '<?php echo $sum_real; ?>';
</script>
<?php 
    $grupo = "";
    switch (strlen($datos_usuario['CLIGRUCOD'])) {
        case 0:
            $grupo = "000";
            break;
        case 1:
            $grupo = "00".$datos_usuario['CLIGRUCOD'];
            break;
        case 2:
            $grupo = "0".$datos_usuario['CLIGRUCOD'];
            break;
        case 3:
            $grupo = $datos_usuario['CLIGRUCOD'];
            break;
    }
    $subgrupo = "";
        switch (strlen($datos_usuario['CLIGRUSUB'])) {
            case 0:
                $subgrupo = "0000";
                break;
            case 1: 
                $subgrupo = "000".$datos_usuario['CLIGRUSUB'];
                break;
            case 2:
                $subgrupo = "00".$datos_usuario['CLIGRUSUB'];
                break;
            case 3:
                $subgrupo = "0".$datos_usuario['CLIGRUSUB'];
                    break;
            case 4:
                $subgrupo = $datos_usuario['CLIGRUSUB'];
                break;
            }
     $grupo .= $subgrupo; 
    $grupo1 = $grupo;
?>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/cuenta_corriente/app.css">
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <nav class="navbar navbar-default border_nav">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style="color:#000;font-weight: bold">OPCIONES </a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" style="font-weight: bold">
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-cc-visa" aria-hidden="true"></i> &nbsp;PAGOS <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php if (in_array(array("BTNGENNOMRE" => "VER_PAGOS"), $opciones)) { ?>
                        <li>
                            <a onclick="ver_pagos('<?php echo $key ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; VER PAGOS</a>
                        </li>
                  <?php } ?>
                  <?php if(in_array(array("BTNGENNOMRE" => "IMPRIMIR_PAGOS"), $opciones))?>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a class="cursor" onclick="imprimir_pagos('<?php echo $key; ?>')" style="font-weight: bold"><i class="fa fa-print" aria-hidden="true"></i> &nbsp;IMPRIMIR PAGOS</a>
                        </li>
                  <?php ?>
                  <?php if(in_array(array("BTNGENNOMRE" => "IMPRIMIR_PAGOS_RANGOS"), $opciones))?>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a class="cursor" onclick="imprimir_rangos('<?php echo $sum_real; ?>')" style="font-weight: bold"><i class="fa fa-print" aria-hidden="true"></i> &nbsp;IMPRIMIR POR RANGOS</a>
                        </li>
                  <?php ?>
                </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa fa-wpforms" aria-hidden="true"></i> &nbsp; NOTAS CRÉDITO<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php if (in_array(array("BTNGENNOMRE" => "AUTORIZACIONES"), $opciones)) { ?>
                        <li><a onclick="ver_recibos_autorizaciones('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-gavel" aria-hidden="true"></i> &nbsp;AUTORIZACIONES</a></li>
                    <?php } ?>
                  <?php if (in_array(array("BTNGENNOMRE" => "ANULACIONES"), $opciones)) { ?>
                  <li role="separator" class="divider"></li>
                  <li><a id='generar_nota_debito' class="cursor" onclick="get_anulaciones('<?php echo $user_datos['CLICODFAC']; ?>')" style="font-weight: bold"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp;NOTAS ANULADAS</a></li>
                  <?php } ?>
                </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-files-o" aria-hidden="true"></i> &nbsp;CONVENIOS<span class="caret"></span></a>
                <ul class="dropdown-menu">
                <?php if (in_array(array("BTNGENNOMRE" => "VER_CONVENIOS"), $opciones)) { ?>
                    <li><a onclick="consultar_convenios()" class="cursor" style="font-weight: bold"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp;VER CONVENIOS</a></li>
                <?php } ?>
                </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-compass" aria-hidden="true"></i> &nbsp;CORTES<span class="caret"></span></a>
                <ul class="dropdown-menu" style="font-weight: bold">
                <?php if (in_array(array("BTNGENNOMRE" => "CAMBIOS_CATASTRALES"), $opciones)) { ?>
                    <li><a onclick="ver_cambios_catastrales('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-compress" aria-hidden="true"></i> &nbsp;CAMBIOS CATASTRALES</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "ESTADOS_CATASTRALES"), $opciones)) { ?>
                    <li role="separator" class="divider"></li>
                    <li><a onclick="ver_estados_catastrales('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-bookmark" aria-hidden="true"></i> &nbsp;ESTADOS CATASTRALES</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "ACCIONES_EJECUTADAS"), $opciones)) { ?>
                    <li role="separator" class="divider"></li>
                    <li><a onclick="acciones_ejecutadas('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-wrench" aria-hidden="true"></i> &nbsp;ACCIONES EJECUTADAS</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "IMPRIMIR_ACCIONES"), $opciones)) { ?>
                    <li role="separator" class="divider"></li>
                    <li><a onclick="imprimir_acciones('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-print" aria-hidden="true"></i> &nbsp;IMPRIME ACCIONES</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "IMPRIMIR_ACCIONES_DETALLADAS"), $opciones)) { ?>
                    <li role="separator" class="divider"></li>
                    <li><a  onclick="imprimir_acciones_detalladas('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-print" aria-hidden="true"></i> &nbsp;IMPRIME ACCIONES DETALLADAS</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "AMPLIAR_PLAZOS_DE_CORTES"), $opciones)) { ?>
                    <li role="separator" class="divider"></li>
                    <li><a onclick="ampliar_cortes('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> &nbsp; AMPLIAR PLAZOS DE CORTES</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "VER_AMPLIACIONES"), $opciones)) { ?>
                    <li role="separator" class="divider"></li>
                    <li><a onclick="ver_ampliaciones('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> &nbsp; AMPLIACIONES</a></li>
                <?php } ?>
                </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bitbucket" aria-hidden="true"></i> &nbsp;VARIOS<span class="caret"></span></a>
                <ul class="dropdown-menu">
                <?php if (in_array(array("BTNGENNOMRE" => "IMPRIMIR_CUENTA_CORRIENTE"), $opciones)) { ?>
                    <li><a onclick="imprimir_cuenta_corriente('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-print" aria-hidden="true"></i> &nbsp;IMPRIMIR CUENTA CORRIENTE</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "FACTURACION"), $opciones)) { ?>
                  <li role="separator" class="divider"></li>
                  <li><a onclick="ver_faturacion('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-clipboard" aria-hidden="true"></i> FACTURACION</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "DUPLICADO_DE_RECIBO"), $opciones)) { ?>
                  <li role="separator" class="divider"></li>
                  <li><a onclick="ver_duplicado()" class="cursor" style="font-weight: bold"><i class="fa fa-file-text" aria-hidden="true"></i> &nbsp;DUPLICADO DE RECIBO</a></li>
                <?php } ?>
                <?php if (in_array(array("BTNGENNOMRE" => "VER_HISTORIAL_DE_CONSUMOS"), $opciones)) {?>
                  <li role="separator" class="divider"></li>
                  <li><a onclick="consumos('<?php echo $user_datos['CLICODFAC']; ?>')" class="cursor" style="font-weight: bold"><i class="fa fa-bar-chart" aria-hidden="true"></i> &nbsp;HISTORIAL DE CONSUMO</a></li>
                <?php } ?>
                </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-link" aria-hidden="true"></i> &nbsp;APLICATIVOS EXTERNOS<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php if (in_array(array("BTNGENNOMRE" => "VER_GIS"), $opciones)) { ?>
                      <li><a href="https://land.sedalib.com.pe/gis-sedalib/GisCorporativo/map_genexus.phtml?config=configs\grales\config_metropolitano&xlocal=03&xlocal2=03&resetsession=ALL&sumi=<?php echo ((substr($user_datos['CLICODFAC'],3,4) == "0000") ? substr($user_datos['CLICODFAC'],0,3).substr($user_datos['CLICODFAC'],7,4) : $user_datos['CLICODFAC'] ) ?>" target="_blank" class="cursor" style="font-weight: bold"><i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp; GIS</a></li>
                  <?php } ?>
                  <?php if (in_array(array("BTNGENNOMRE" => "INFORMACION_CAMPO"), $opciones)) { ?>
                      <li><a class="cursor" style="font-weight: bold" onclick="obtener_informacion_siac()"><i class="fa fa-map-pin" aria-hidden="true"></i> &nbsp; INFORMACIÓN CAMPO (SIAC)</a></li>
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
  <!-- pasar a producción -->
  <div class="row" id="datos_externos" style="display:none">
    <div class="col-md-12">
      <div class="panel-danger">
        <div class="panel-heading">
          <h5 style="margin:5px;font-weight:bold;font-family:Ubuntu">INFORMACIÓN DE CAMPO <button onclick="cerrar_siac()" class="btn btn-box-tool pull-right" ><i class="fa fa-times"></i></button></h5>
        </div>
        <div class="panel-body" style="background:#FFF">
          <div class="row">
            <div class="col-md-12">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#toma_estado">Toma de Estado</a></li>
                <li><a data-toggle="tab" href="#relectura">Relectura</a></li>
                <li><a data-toggle="tab" href="#notificacion">Notificación</a></li>
                <li><a data-toggle="tab" href="#inspeccion_interna">Inspeccion Interna</a></li>
                <li><a data-toggle="tab" href="#inspeccion_externa">Inspeccion Externa</a></li>
              </ul>
              <div class="tab-content">
                <div id="toma_estado" class="tab-pane fade in active">
                  <div class="row" id="tabla_lecturas" style="margin: 15px;">
                    <div class="col-md-12 table-responsive">
                      <table id="lecturas_realizadas" class="table table-bordered table-striped" style="font-size:12px">
                        <thead>
                          <tr>
                            <th>Orden Trabajo</th>
                            <th>Ciclo</th>
                            <th>Nombre</th>
                            <th>Medidor</th>
                            <th>Lectura</th>
                            <th>Observación</th>
                            <th>Fecha Lectura</th>
                          </tr>
                        </thead>
                        <tbody id="cuerpo_lecturas_realzidas">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="relectura" class="tab-pane fade ">
                  <div class="row" id="tabla_relecturas" style="margin: 15px;">
                    <div class="col-md-12 table-responsive">
                      <table id="relecturas_realizadas" class="table table-bordered table-striped" style="font-size:12px">
                        <thead>
                          <tr>
                            <th>Orden Trabajo</th>
                            <th>Ciclo</th>
                            <th>Nombre</th>
                            <th>Medidor</th>
                            <th>Relectura</th>
                            <th>Observación</th>
                            <th>Fecha Relectura</th>
                            <th>Lectura</th>
                            <th>Fecha Lectura</th>
                            <th>Orden Trabajo Lectura</th>
                          </tr>
                        </thead>
                        <tbody id="cuerpo_relecturas_realzidas">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="notificacion" class="tab-pane fade ">
                  <div class="row" id="tabla_notificacion" style="margin: 15px;">
                    <div class="col-md-12 table-responsive">
                      <table id="notificacion_realizadas" class="table table-bordered table-striped" style="font-size:12px">
                        <thead>
                          <tr>
                            <th>Orden Trabajo</th>
                            <th>N° Visitas</th>
                            <th>Entrega Titular</th>
                            <th>Persona Distinta</th>
                            <th>Obs 1ra Visita</th>
                            <th>Obs 2da Visita</th>
                            <th>Fecha Entrega</th>
                            <th>Tipo Entrega</th>
                            <th>Documentos</th>
                          </tr>
                        </thead>
                        <tbody id="cuerpo_notificacion_realzidas">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="inspeccion_interna" class="tab-pane fade ">
                  <div class="row" id="tabla_inspeccion_interna" style="margin: 15px;">
                    <div class="col-md-12 table-responsive">
                      <table id="inspeccion_interna_realizadas" class="table table-bordered table-striped" style="font-size:12px">
                        <thead>
                          <tr>
                            <th>Orden Trabajo</th>
                            <th>N° Reclamo</th>
                            <th>Fecha Inspección</th>
                            <th>Hora Inspección</th>
                            <th>N° Habitantes</th>
                            <th>N° Pisos</th>
                            <th>Unidades de Uso</th>
                            <th>Uso de Inmueble</th>
                            <th>Lectura</th>
                            <th>Observacion</th>
                            <th>Fotos</th>
                            <th>Ficha</th>
                          </tr>
                        </thead>
                        <tbody id="cuerpo_inspeccion_interna_realzidas">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="inspeccion_externa" class="tab-pane fade ">
                  <div class="row" id="tabla_inspeccion_externa" style="margin: 15px;">
                    <div class="col-md-12 table-responsive">
                      <table id="inspeccion_externa_realizadas" class="table table-bordered table-striped" style="font-size:12px">
                        <thead>
                          <tr>
                            <th>Orden Trabajo</th>
                            <th>N° Reclamo</th>
                            <th>Fecha Inspección</th>
                            <th>Hora Inspección</th>
                            <th>Estado Medidor</th>
                            <th>Lectura</th>
                            <th>Fuga</th>
                            <th>Observacion</th>
                            <th>Fotos</th>
                            <th>Ficha</th>
                          </tr>
                        </thead>
                        <tbody id="cuerpo_inspeccion_externa_realzidas">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
  <br>
  <!-- end pasar a produccción -->
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-success">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-3 col-sm-3">
              <h4 class="box-title titulo_box text-info" style="margin: 0px;"> <i class="fa fa-user" aria-hidden="true"></i>  DATOS CLIENTE</h4>
            </div>
            <?php if  (in_array(array("BTNGENNOMRE" => "VER_UNIDADES"), $opciones) && $grupo != "0000000") { ?>
                <div class='col-md-3 col-sm-3 label_input'>
                    <div class="input-group">
                        <span class="input-group-addon hidden-sm hidden-xs title_label" >DEUDA CAPITAL</span>
                        <span class="input-group-addon hidden-md hidden-lg title_label" >DEU. CAP.</span>
                        <input type="text" class="form-control derecha" id="deuda_capital" style="color:#990000;font-size:1em;font-weight:bold" disabled>
                    </div>
                </div>
                <div class='col-md-4 col-sm-4 label_input'>
                    <div class="input-group">
                        <span class="input-group-addon hidden-sm hidden-xs title_label">CUO. CONVEN.</span>
                        <span class="input-group-addon hidden-md hidden-lg title_label">CUO. CON.</span>
                        <input type="text" class="form-control derecha" value="S./ <?php echo number_format($monto_convenios['TOTAL'], 2, '.', ''); ?>" style="color:#990000;font-size:1em;font-weight:bold" disabled>
                    </div>
                </div>
                <div class='col-md-2 col-sm-2 label-input'>
                    <?php if(isset($datos_usuario['CLIGRUCOD']) && intval($datos_usuario['CLIGRUCOD']) > 20) { ?>
                        <a class="badge bg-yellow" onclick="ver_unidades('<?php echo $datos_usuario['CLIGRUCOD'] ?>','<?php echo $datos_usuario['CLIGRUSUB'] ?>')">VER UNIDADES</a>
                    <?php } ?>
                    <?php if (in_array(array("BTNGENNOMRE" => "VER_AGRUPADO"), $opciones)) { ?>
                        <?php if($grupo != "0000000") { $grupo = substr($grupo,0,3)."0000".substr($grupo,3,4); ?>
                            <br><a href="<?php  echo  $this->config->item('ip').'cuenta_corriente/mostrar_cartera/'.$grupo; ?>" class="badge bg-blue" >VER AGRUPADO</a>
                        <?php } ?>
                    <?php } ?>
                    <div class="box-tools pull-right">              
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            <?php } else {?>
                <div class='col-md-4 col-sm-4 label_input'>
                    <div class="input-group">
                        <span class="input-group-addon hidden-sm hidden-xs title_label" >DEUDA CAPITAL</span>
                        <span class="input-group-addon hidden-md hidden-lg title_label" >DEU. CAP.</span>
                        <input type="text" class="form-control derecha" id="deuda_capital" style="color:#990000;font-size:1em;font-weight:bold" disabled>
                    </div>
                </div>
                <div class='col-md-4 col-sm-4 label_input'>
                    <div class="input-group">
                        <span class="input-group-addon hidden-sm hidden-xs title_label">CONVENENIOS</span>
                        <span class="input-group-addon hidden-md hidden-lg title_label">CUO. CON.</span>
                        <input type="text" class="form-control derecha" value="S./ <?php echo number_format($monto_convenios['TOTAL'], 2, '.', ''); ?>" style="color:#990000;font-size:1em;font-weight:bold" disabled>
                    </div>
                </div>
                <div class="col-md-1 col-sm-1 derecha">              
                    <!--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
                </div>
            <?php } ?>
          </div>          
        </div>
        <div class="panel-body">
           <div class="row">
            <div class="col-md-4 col-sm-4 label_input" >
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs media_xs title_label1">SUMINISTRO </span>
                <span class="input-group-addon hidden-md hidden-lg title_label1">SUM. </span>
                <input type="text" class="form-control" value="<?php echo $sum_real ?>" disabled>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 label_input">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1">DEUDA EXIGIBLE</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1">DEU. EXIG.</span>
                <input type="text" class="form-control" id="deuda_exigible" style="color:#990000;font-size:1em;font-weight:bold" disabled>
              </div>
            </div>
            <div class="col-md-4 col-sm-4" style="margin-top: 5px">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1" >DEUDA FINAL</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1">DEU. FIN.</span>
                <input type="text" class="form-control" id="deuda_final" style="color:#990000;font-size:1em;font-weight:bold" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-6" style="margin-top: 5px">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1" >NOMBRE</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1" >NOM.</span>
                <input type="text" class="form-control" value="<?php echo $user_datos['CLINOMBRE'] ?>" disabled>
              </div>
            </div>
            <div class="col-md-6 col-sm-6" style="margin-top: 5px">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1" >DIRECCIÓN</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1" >DIR.</span>
                <input type="text" class="form-control" value="<?php echo $user_datos['URBDES']." ".$user_datos["CALDES"]." ".$user_datos["CLIMUNNRO"] ?>" disabled>
              </div>
            </div>
          </div>
          <div class="row"  >
            <div class="col-md-3 col-sm-3 col-xs-6" style="margin-top: 5px">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1" >CICLO</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1" >CIC.</span>
                <input type="text" class="form-control" value="<?php echo $dataUser." ".$desCiclo['FACCICDES']; ?>" disabled>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6" style="margin-top: 5px">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1" >ESTADO</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1" >EST.</span>
                <input type="text" class="form-control" value="<?php echo $est_cli['DESESCLTE'] ?>" disabled>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6" style="margin-top: 5px">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1" >GRUPO</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1" >GRUP.</span>
                <input type="text" class="form-control" value="<?php echo $grupo1  ?>" disabled>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6" style="margin-top: 5px">
              <div class="input-group">
                <span class="input-group-addon hidden-sm hidden-xs title_label1" >MEDIDOR</span>
                <span class="input-group-addon hidden-md hidden-lg title_label1" >MED.</span>
                <input type="text" class="form-control" value="<?php echo $medidor ?>" disabled/>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
            <?php if (in_array(array("BTNGENNOMRE" => "IMPRIMIR_CUENTA_CORRIENTE"), $opciones)) { ?>
               <a onclick="imprimir_cuenta_corriente('<?php echo $user_datos['CLICODFAC']; ?>')" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="IMPRIMIR CUENTA CORRIENTE"><i class="fa fa-print" aria-hidden="true"></i></a> 
            <?php } ?>
               <h3 class="box-title" style="font-family:'Ubuntu';font-weight: bold">&nbsp;CUENTA CORRIENTE</h3>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
            <?php if (in_array(array("BTNGENNOMRE" => "VER_RECIBOS_SERIE_90-91"), $opciones)) { ?>
              <?php if(sizeof($recibos_pendientes_90_91) > 0) {?>
                <input type="checkbox" id='deuda_90_91' value=""> <label for="deuda_90_91">VER DEUDA SERIE 90 - 91</label>
              <?php } ?>
            <?php } ?>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-12" style="text-align: right;">
            <?php if (in_array(array("BTNGENNOMRE" => "VER_RECIBOS_ANULADOS_TOTALMENTE"), $opciones)) { ?>
              <?php if(isset($recibos_anulados)) { ?>
                <input type="checkbox" id="notas_recibos">&nbsp;<label for="notas_recibos">RECIBOS DESCONTADOS TOTALMENTE</label>
              <?php } ?>
            <?php } ?>
              <div class="box-tools pull-right">           
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="box-body ">
          <div class="table-responsive" >
            <table id="recibos_pendientes" class="table table-bordered table-striped" >
              <thead>
                <tr>
                  <th>EMISION</th>
                    <th>SERIE</th>
                    <th>N° DOCUMENTO</th>
                    <th>DESCCRIPCIÓN</th>
                    <th>TARIFA</th>
                    <th>RECLAMO</th>
                    <th>ESTADO</th>
                    <th>CARGO</th>
                    <th>ABONO</th>
                    <th>TOTAL</th>
                    <th>OPCIONES</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $cargo = 0; $abono = 0; $total = 0; $sum_recibo = 0; $sum_recibo2 = 0; $i = 0; $sum_notasC = 0; $NOTASc = 0; $sum_notasD = 0;$NOTASd = 0;
                  foreach ($recibos_pendientes as $recibo) { 
                    if($recibo['FACTOTAL'] != $recibo['monto_nota']) {
                ?>
                    <tr>
                      <td><?php echo $recibo['FACEMIFEC']; ?></td>
                      <td class="derecha"><?php echo $recibo['FACSERNRO']; ?></td>
                      <td class="derecha"><?php echo $recibo['FACNRO']; ?></td>
                      <td><?php echo ($recibo['volumen'] != NULL) ? "RECIBO ".$recibo['volumen']." m<sup>3</sup>" : "RECIBO "; if($recibo['NC'] != NULL){ echo " NC = ".sizeof($recibo['NC']); } ;echo  " ".$recibo['FACTARIFA']." FV: ".$recibo['FACVENFEC'] ?></td>
                      <td><?php echo $recibo['FACTARIFA']; ?></td>
                      <td class="derecha text-blue"><?php echo ($recibo['reclamo'] != NULL) ? $recibo['reclamo']['SERNRO']."-".$recibo['reclamo']['RECID'] : "0"; ?></td>
                      <td class="derecha text-blue"><?php echo ($recibo['reclamo'] != NULL) ? $recibo['reclamo']['SSITDES'] : "";?></td>
                      <td class="derecha text-red"><?php echo number_format(floatval($recibo['FACTOTAL']), 2, '.', '');  $cargo += floatval($recibo['FACTOTAL']); ?></td>
                      <td class="derecha text-blue"><?php echo "0.00"; ?></td>
                      <td class="derecha"><?php echo number_format(floatval($recibo['FACTOTAL']), 2, '.', ''); $total+= floatval($recibo['FACTOTAL']); ?></td>
                      <td class="center">
                        <div class="dropdown drop">
                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-filter" aria-hidden="true"></i> Opciones<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right bg_color">
                                <?php if (in_array(array("BTNGENNOMRE" => "VER_DETALLE_RECIBO"), $opciones)) { ?>
                                    <li>  
                                        <a onclick="ver_detalle('<?php echo $recibo['FACSERNRO']; ?>','<?php echo $recibo['FACNRO']; ?>')" id="detalle" class="hover_yellow" >
                                            <i class="fa fa-plus-square" aria-hidden="true"></i> DETALLE RECIBO
                                        </a>
                                    </li>
                                <?php } ?>   
                                <?php if (in_array(array("BTNGENNOMRE" => "DUPLICADO_DE_RECIBO"), $opciones) && $recibo['proceso']) { ?>
                                    <li class="divider"></li>  
                                    <li>
                                      <a onclick="window.open('<?php echo $this->config->item('ip').'facturacion/creo_recibo_a4/'.$sum_real.'/'.$recibo['proceso']; ?>')" class="hover_yellow">
                                        <i class="fa fa-file-text" aria-hidden="true"></i> DUPLICADO RECIBO A4<!--duplico_recibo -->
                                      </a>
                                    </li>
                                    <li class="divider"></li>  
                                    <li>
                                      <a onclick="window.open('<?php echo $this->config->item('ip').'facturacion/creo_recibo/'.$sum_real.'/'.$recibo['proceso']; ?>')" class="hover_yellow">
                                        <i class="fa fa-file-text" aria-hidden="true"></i> DUPLICADO RECIBO A5<!--duplico_recibo -->
                                      </a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array(array("BTNGENNOMRE" => "GENERAR_NCA"), $opciones)) { ?>
                                    <?php if($recibo['autorizacion'] && in_array(array("BTNGENNOMRE" => "AUTORIZACIONES"), $opciones)) {?>
                                        <li class="divider"></li>  
                                        <li>
                                            <a id='gen_nc' onclick="generar_nota_autorizacion('<?php echo $recibo['autorizacion'] ?>')"  class="hover_yellow">
                                                <i class="fa fa-refresh" aria-hidden="true"></i>GENERAR NOTA DE CRÉDITO
                                            </a>
                                        </li>
                                    <?php } else if ($recibo['reclamo']) { ?>
                                        <li class="divider"></li>  
                                        <li>
                                            <a id='gen_nc' onclick="generar_nota('<?php echo $user_datos['CLICODFAC']; ?>','<?php echo $recibo['FACSERNRO']; ?>','<?php echo $recibo['FACNRO']; ?>')"  class="hover_yellow">
                                                <i class="fa fa-refresh" aria-hidden="true"></i>GENERAR NOTA DE CRÉDITO
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                      </td>
                    </tr>
                    <?php 
                      if(dateDiff(date('Y-m-d'),substr($recibo['FACVENFEC'],6,4).'-'.substr($recibo['FACVENFEC'],3,2)."-".substr($recibo['FACVENFEC'],0,2)) < 0) $sum_recibo += floatval($recibo['FACTOTAL']);
                      else $sum_recibo2 += floatval($recibo['FACTOTAL']);
                      $i++;
                    ?>
                    <!-- notas de crédito   --> 
                    <?php foreach ($recibo['NC'] as $notaC) { ?>
                      <tr>
                        <td class='text-red'><?php echo $notaC['NCAFECHA'];  ?></td>
                        <td class="derecha text-red"><?php echo $notaC['NCASERNRO']; ?></td>
                        <td class="derecha text-red"><?php echo $notaC['NCANRO']; ?></td>
                        <td class="text-red">NOTA DE CRÉDITO. Recibo: <?php echo $notaC['TOTFAC_FACSERNRO']."-".$notaC['TOTFAC_FACNRO']; ?></td>
                        <td></td>
                        <td class="derecha text-blue">0</td>
                        <td ></td>
                        <td class="derecha text-red">0.00</td>
                        <td class="derecha text-blue"><?php echo number_format(floatval($notaC["NCATOTDIF"]),2,'.',''); $abono += floatval($notaC["NCATOTDIF"]); ?></td>
                        <td class="derecha">0.00</td>
                        <td class="center">
                            <div class="dropdown drop">
                                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-filter" aria-hidden="true"></i> Opciones<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right bg_color1">
                                    <?php if (in_array(array("BTNGENNOMRE" => "IMPRIMIR_NCA"), $opciones)) { ?>
                                        <li>
                                            <a id="ver_nc" onclick="ver_notaCredito('<?php echo $key; ?>','<?php echo $notaC['NCASERNRO']; ?>','<?php echo $notaC['NCANRO']; ?>')" class="hover_green">
                                                <i class="fa fa-print"></i> IMPRIMIR NOTA DE CRÉDITO
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(array("BTNGENNOMRE" => "DETALLE_NCA"), $opciones)) { ?>
                                        <li class="divider"></li>
                                        <li>
                                            <a onclick="detalle_nota('<?php echo $user_datos['CLICODFAC']; ?>','<?php echo $notaC['NCASERNRO']; ?>','<?php echo $notaC['NCANRO']; ?>')" class="hover_green">
                                                <i class="fa fa-eye" aria-hidden="true"></i> DETALLE NOTA DE CRÉDITO
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(array("BTNGENNOMRE" => "EDITAR_NCA"), $opciones) && substr($notaC['NCAFECHA'],3,2) == date("m")) { ?>
                                        <li class="divider"></li>
                                        <li>
                                            <a onclick="generar_nota('<?php echo $user_datos['CLICODFAC']; ?>','<?php echo $recibo['FACSERNRO']; ?>','<?php echo $recibo['FACNRO']; ?>')" class="hover_green">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDITAR NOTA DE CRÉDITO
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </td>
                      </tr>
                      <?php  $sum_notasC += floatval($notaC["NCATOTDIF"]);$NOTASc++;  ?>
                    <?php } ?>

                    <!-- NOTA DE DÉBITO -->
                    <?php foreach ($recibo['ND'] as $notaD) { ?>
                      <tr>
                        <td><?php echo date('d/m/Y'); ?></td>
                        <td class="derecha"><?php echo $notaD['NCASERNRO']; ?></td>
                        <td class="derecha"><?php echo $notaD['NCANRO']; ?></td>
                        <td>NOTA DE DÉBITO. Recibo: <?php echo $notaD['TOTFAC_FACSERNRO']."-".$notaD['TOTFAC_FACNRO']; ?></td>
                        <td></td>
                        <td class="derecha text-blue">0</td>
                        <td ></td>
                        <td class="derecha text-red"><?php echo number_format(floatval($notaD["NCATOTDIF"]),2,'.',''); ?></td>
                        <td class="derecha text-red">0.00</td>
                        <td class="derecha">0.00</td>
                        <td></td>
                      </tr>
                      <?php $sum_notasD += floatval($notaD["NCATOTDIF"]); $NOTASd++; ?>
                    <?php } ?>
                <?php
                    } 
                  }
                  $deuda_real = $sum_recibo + $sum_notasD - $sum_notasC;
                ?>
                <?php if($sum_recibo > 0) {?>
                  <tr>
                    <td><?php echo date('d/m/Y');?></td>
                    <td class="derecha">0</td>
                    <td class="derecha">900</td>
                    <td>INTERESES MORATORIOS</td>
                    <td></td>
                    <td class="derecha text-blue">0</td>
                    <td></td>
                    <td class="derecha text-red"><?php echo $interes_moratorio; $cargo += number_format($interes_moratorio,2,'.',''); ?></td>
                    <td class="derecha text-blue">0.00</td>
                    <td class="derecha"><?php echo $interes_moratorio; $total += $interes_moratorio; ?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><?php echo date('d/m/Y');?></td>
                    <td class="derecha">0</td>
                    <td class="derecha">902</td>
                    <td>GASTOS COBRANZA</td>
                    <td></td>
                    <td class="derecha text-blue">0</td>
                    <td></td>
                    <td class="derecha text-red"><?php  $moratorio = $deuda_real*0.10; echo number_format( $moratorio, 2, '.', ''); $cargo += number_format($moratorio,2,'.',''); ?></td>
                    <td class="derecha text-blue">0.00</td>
                    <td class="derecha"><?php echo number_format($moratorio,2,'.',''); $total += number_format($moratorio,2,'.',''); ?></td>
                    <td></td>
                  </tr>
                  <tr>
                      <td><?php echo date('d/m/Y');?></td>
                      <td class="derecha">0</td>
                      <td class="derecha">903</td>
                      <td>IGV DE GASTOS COBRANZA</td>
                      <td></td>
                      <td class="derecha text-blue">0</td>
                      <td></td>
                      <td class="derecha text-red"><?php echo number_format(($moratorio*0.18), 2, '.', ''); $cargo += ($moratorio*0.18); ?></td>
                      <td class="derecha text-blue">0.00</td>
                      <td class="derecha"><?php echo number_format(($moratorio*0.18), 2, '.', ''); $total += ($moratorio*0.18);  ?></td>
                      <td></td>
                  </tr>
                <?php } ?>
                <?php if($i > 0) {?>
                  <tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td style="text-align:right;color:#990000;font-weight: bold">TOTAL</td>
                    <td style="text-align:right;font-weight: bold"><?php echo number_format($cargo,2,'.',''); ?></td>
                    <td style="text-align:right;font-weight: bold"><?php echo number_format($abono,2,'.',''); ?></td>
                    <td style="text-align:right;font-weight: bold"><?php echo number_format($total,2,'.',''); ?></td>
                    <td></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="box box-primary"> <!-- collapsed-box -->
          <div class="box-header with-border">
            <h3 class="box-title" style="font-family:'Ubuntu'">RESUMEN</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="resumen" class="table table-bordered table-striped">
                <thead>
                  <tr role="row">
                    <th>NÚMERO</th>
                    <th>DOCUMENTO</th>
                    <th>CANTIDAD</th>
                    <th>MONTO</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>RECIBOS</td>
                    <td style="text-align:right"><?php echo $i; ?></td>
                    <td style="text-align:right"><?php echo number_format(($sum_recibo2 + $sum_recibo), 2, '.', ''); ?></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>NOTA DE CRÉDITO</td>
                    <td style="text-align:right"><?php echo $NOTASc; ?></td>
                    <td style="text-align:right"><?php echo number_format($sum_notasC, 2, '.', ''); ?></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>NOTA DE DÉBITO</td>
                    <td style="text-align:right"><?php echo $NOTASd; ?></td>
                    <td style="text-align:right"><?php echo number_format($sum_notasD, 2, '.', ''); ?></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>LETRAS PENDIENTES</td>
                    <td style="text-align:right"><?php echo $monto_convenios['CANTIDAD'] ?></td>
                    <td style="text-align:right"><?php echo number_format($monto_convenios['TOTAL'], 2, '.', ''); ?></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>GASTOS COBRANZA</td>
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;"><?php echo number_format($moratorio,2,'.',''); ?></td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>IGV DE GASTOS COBRANZA</td>
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;"><?php echo number_format(($moratorio*0.18),2,'.',''); ?></td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>INTERESE MORATORIOS</td>
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;"><?php echo number_format($interes_moratorio,2,'.',''); ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="derecha">TOTAL</td>
                    <td style="text-align: right;color: #990000"><b><?php $total_resumen = $sum_recibo2 + $sum_recibo - $sum_notasC + $sum_notasD + floatval($monto_convenios['TOTAL']) + $moratorio + ($moratorio * 0.18) + $interes_moratorio; echo number_format($total_resumen,2,'.',''); ?></b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php if (in_array(array("BTNGENNOMRE" => "VER_UNIDADES"), $opciones)) { ?>
<div class="modal fade" id="unidades" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('unidades')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-compass" aria-hidden="true"></i> UNIDADES DE USO</h4>
      </div>
      <div class="modal-body cuerpo_scroll">
        <div class="table-responsive">
            <table id="lista_unidades" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>SUMINISTRO</th>
                  <th>NOMBRE</th>
                  <th>CICLO</th>
                  <th>TARIFA</th>
                  <th>ESTADO CLIENTE</th>
                  <th>T. SERVICIO</th>
                  <th>EST. CONX. AGUA</th>
                  <th>EST. CONX. DESAGÜE</th>
                  <th>MEDIDOR</th>
                  <th>GRUPO Y SUBGRUPO</th>
                  <th>LOCALIDAD</th>
                  <th class="center">OPCIONES</th>
                </tr>
              </thead>
              <tbody id='cuerpo_unidades'>
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('unidades')"> 
                <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR
            </button>
          </div>
          <div class="col-md-4 col-sm-4"> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php if (in_array(array("BTNGENNOMRE" => "ANULACIONES"), $opciones)) { ?>
<div class="modal fade" id="anulaciones" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('anulaciones')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp; NOTAS DE CRÉDITO ANULADAS</h4>
      </div>
      <div class="modal-body cuerpo_scroll" >
        <div class="table-responsive">
            <table id="notas_credito" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>SUMINISTRO</th>
                  <th>SERIE</th>
                  <th>NÚMERO</th>
                  <th>MONTO</th>
                  <th>FECHA</th>
                  <th>USUARIO</th>
                  <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody id='cuerpo_anulaciones'>
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('anulaciones')"> <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</button>
          </div>
          <div class="col-md-4 col-sm-4"> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>


<?php if (in_array(array("BTNGENNOMRE" => "VER_DETALLE_RECIBO"), $opciones)) { ?>
<div id="detalle_recibo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('detalle_recibo')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp; DETALLE DEL RECIBO <span id='serie_numero_recibo'></span></h4>
      </div>
      <div class="modal-body cuerpo_scroll">
        <div class="box-primary">
          <div class="box-body" id='cabecera_detalle_recibo'>
            
          </div>
        </div>
        <div class="box-warning">
          <div class="box-body" id='cuerpo_detalle_recibo'></div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('detalle_recibo')"> <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
  <!-- pasar a producción -->
  <?php if (in_array(array("BTNGENNOMRE" => "INFORMACION_CAMPO"), $opciones)) { ?>
      <div class="modal fade" id="imagen_lectura" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-info" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> IMAGEN DE LECTURA - <b>Lectura: </b><span id="metros_cubicos_lectura"></span>m<sup>3</sup> - <b>Fecha: </b><span id="fecha_lectura"></span></h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen lectura" id="imagen_lectura_1">
            </div>
            <div class="modal-footer borde_footer bg-info" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_opcional_lectura" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-success" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> IMAGEN OPCIONAL DE LECTURA - <b>Lectura: </b><span id="metros_cubicos_lectura_opcional"></span>m<sup>3</sup> - <b>Fecha: </b><span id="fecha_lectura_opcional"></span></h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen lectura" id="imagen_opcional_lectura_1">
            </div>
            <div class="modal-footer borde_footer bg-success" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_observacion_lectura" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-warning" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> OBSERVACIÓN DE LECTURA - <b>Obs: </b><span id="observacion_lectura"></h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen lectura" id="imagen_observacion_lectura_1">
            </div>
            <div class="modal-footer borde_footer bg-warning" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_relectura" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-info" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> IMAGEN DE RELECTURA - <b>Relectura: </b><span id="metros_cubicos_relectura"></span>m<sup>3</sup> - <b>Fecha: </b><span id="fecha_relectura"></span></h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen relectura" id="imagen_relectura_1">
            </div>
            <div class="modal-footer borde_footer bg-info" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_opcional_relectura" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-success" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> IMAGEN OPCIONAL DE RELECTURA - <b>Relectura: </b><span id="metros_cubicos_relectura_opcional"></span>m<sup>3</sup> - <b>Fecha: </b><span id="fecha_relectura_opcional"></span></h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen lectura" id="imagen_opcional_relectura_1">
            </div>
            <div class="modal-footer borde_footer bg-success" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_observacion_relectura" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-warning" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> OBSERVACIÓN DE RELECTURA - <b>Obs: </b><span id="observacion_relectura"></h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Observación relectura" id="imagen_observacion_relectura_1">
            </div>
            <div class="modal-footer borde_footer bg-warning" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_notificacion" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-success" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> FOTO NOTIFICACIÓN </h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen notificacion" id="imagen_notificacion_1">
            </div>
            <div class="modal-footer borde_footer bg-success" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_opcional_notificacion" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-success" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> FOTO OPCIONAL NOTIFICACIÓN </h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen notificacion" id="imagen_opcional_notificacion_1">
            </div>
            <div class="modal-footer borde_footer bg-success" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="imagen_inspeccion" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content contenido_modal">
            <div class="modal-header bg-success" style="border-radius:5px">
              <button type="button" class=" btn btn-danger btn-xs pull-right" data-dismiss="modal" >&times;</button>
              <h4 class="modal-title titulo_modal"><i class="fa fa-camera" aria-hidden="true"></i> FOTO INSPECCIÓN </h4>
            </div>
            <div class="modal-body text-center">
              <img src="" class="img-responsive img-thumbnail" alt="Imagen inspección" id="imagen_inspeccion_1">
            </div>
            <div class="modal-footer borde_footer bg-success" style="border-radius:5px">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> 
                      <b><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Cerrar</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php } ?>
    <!-- end pasar a producción -->


</section>


<?php if (in_array(array("BTNGENNOMRE" => "VER_RECIBOS_SERIE_90-91"), $opciones)) { ?>
<div class="modal fade" id="serie_90_91" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#deuda_90_91').removeAttr( 'checked' ); ocultar_modal('serie_90_91')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-file-text" aria-hidden="true"></i> RECIBOS SERIE 9X</h4>
      </div>
      <div class="modal-body cuerpo_scroll">
        <div class="table-responsive">
            <table id="lista_serie_90_91" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>EMISION</th>
                  <th>SERIE</th>
                  <th>N° DOCUMENTO</th>
                  <th>DESCCRIPCIÓN</th>
                  <th>TARIFA</th>
                  <th>RECLAMO</th>
                  <th>ESTADO</th>
                  <th>CARGO</th>
                  <th>ABONO</th>
                  <th>TOTAL</th>
                  <th class="center">OPCIONES</th>
                </tr>
              </thead>
              <tbody id='cuerpo_serie_90_91'>
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="$('#deuda_90_91').removeAttr( 'checked' ); ocultar_modal('serie_90_91')"> 
              <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR
            </button>
          </div>
          <div class="col-md-4 col-sm-4"> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "VER_RECIBOS_ANULADOS_TOTALMENTE"), $opciones)) { ?>
<div class="modal fade" id="recibos_descontados" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#notas_recibos').removeAttr( 'checked' ); ocultar_modal('recibos_descontados')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-file-text" aria-hidden="true"></i> RECIBOS DESCONTADOS TOTALMENTE</h4>
      </div>
      <div class="modal-body cuerpo_scroll">
        <div class="table-responsive">
            <table id="lista_recibos_descontados" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>EMISION</th>
                  <th>SERIE</th>
                  <th>N° DOCUMENTO</th>
                  <th>DESCCRIPCIÓN</th>
                  <th>TARIFA</th>
                  <th>RECLAMO</th>
                  <th>ESTADO</th>
                  <th>CARGO</th>
                  <th>ABONO</th>
                  <th>TOTAL</th>
                  <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody id='cuerpo_recibos_descontados'>
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="$('#notas_recibos').removeAttr( 'checked' ); ocultar_modal('recibos_descontados')"> 
              <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR
            </button>
          </div>
          <div class="col-md-4 col-sm-4"> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php if (in_array(array("BTNGENNOMRE" => "CAMBIOS_CATASTRALES"), $opciones)) { ?>
<div id="cambios_catastrales" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('cambios_catastrales')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-compress" aria-hidden="true"></i>&nbsp; CAMBIOS CATASTRALES</h4>
      </div>
      <div class="modal-body cuerpo_scroll">
        <div class="table-responsive">
          <table id="cambios_catastrales_cuerpo" class="table table-bordered table-striped">
            <thead >
              <tr role="row">
                <th>COD. CAMBIO</th>
                <th>FECHA PROCESO</th>
                <th>HORA CAMBIO</th>
                <th>REFERENCIA</th>
                <th>USUARIO</th>
                <th>VALOR ANTERIOR</th>
                <th>VALOR DESPUES</th>
              </tr>
            </thead>
            <tbody id='camcat_cuerpo' >
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('cambios_catastrales')"> <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php if (in_array(array("BTNGENNOMRE" => "FACTURACION"), $opciones)) { ?>
<div id="facturacion_suministro" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-file-code-o" aria-hidden="true"></i> &nbsp; FACTURACIÓN</h4>
      </div>
      <div class="modal-body">
        <div class="box box-primary">
          <div class="box-body">
            <div class="row">
              <div class="col-md-8"></div>
              <div class="col-md-4 derecha">
                <input type="checkbox" id='facturacion_total'> <label for="facturacion_total">OBTENER FACTURACION COMPLETA</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4 label_input">
                  <div class="input-group">
                    <span class="input-group-addon hidden-sm hidden-xs title_label" >SUMINISTRO</span>
                    <span class="input-group-addon hidden-md hidden- title_label">SUM.</span>
                    <input type="text" class="form-control" id="faturacion_suministro" disabled>
                  </div>
              </div>
              <div class="col-md-4 col-sm-4 label_input">
                <div class="input-group">
                  <span class="input-group-addon hidden-sm hidden-xs title_label" >PER. INICIO</span>
                  <span class="input-group-addon hidden-md hidden-lg title_label" >PER. INI.</span>
                  <select class="form-control" id="facturacion_periodos_inicio" onchange="validar_segundo_pediodo()">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 label_input" >
                <div class="input-group">
                  <span class="input-group-addon hidden-sm hidden-xs title_label">PER. FINAL</span>
                  <span class="input-group-addon hidden-md hidden-lg title_label">PER. FIN.</span>
                  <select class="form-control" id="facturacion_periodos_fin" disabled>
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-danger btn-total" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i> &nbsp; CERRAR</button>
          </div>
          <div class="col-md-4 col-sm-4"></div>
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-primary btn-total" onclick="visualizar_facturacion()"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; VISUALIZAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "ESTADOS_CATASTRALES"), $opciones)) { ?>
<div id="estados_catastrales" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" name="button" class="close" data-dismiss='modal' onclick="ocultar_modal('estados_catastrales')">&times;</button>
        <h4 class="modal-title titulo_modal" ><i class="fa fa-bookmark" aria-hidden="true"></i> &nbsp; ESTADO CATASTRAL</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 col-sm-6 label_input" >
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs media_xs title_label">ESTADO CLIENTE </span>
              <span class="input-group-addon hidden-md hidden-lg title_label" >EST. CLT.</span>
              <input type="text" class="form-control" id="estado_cliente" disabled="">
            </div>
          </div>
          <div class="col-md-6 col-sm-6 label_input" >
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs media_xs title_label" >CONEXIÓN AGUA </span>
              <span class="input-group-addon hidden-md hidden-lg title_label" >CNX. AGUA</span>
              <input type="text" class="form-control" id="conexion_agua" disabled="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-6 label_input">
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs media_xs title_label" >CONEXIÓN DESAGÜE</span>
              <span class="input-group-addon hidden-md hidden-lg title_label" >CNX. DESA.</span>
              <input type="text" class="form-control" id="conexion_desague" disabled="">
            </div>
          </div>
          <div class="col-md-6 col-sm-6 label_input">
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs media_xs title_label" >TIPO SERVICIO</span>
              <span class="input-group-addon hidden-md hidden-lg title_label" >T. SERV.</span>
              <input type="text" class="form-control" id="tipo_servicio" disabled="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-6 label_input" >
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs media_xs title_label">MEDIDOR</span>
              <span class="input-group-addon hidden-md hidden-lg title_label" >MED.</span>
              <input type="text" class="form-control" id="est_cat_medidor" disabled="">
            </div>
          </div>
          <div class="col-md-6 col-sm-6 label_input">
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs media_xs title_label">LOCALIDAD</span>
              <span class="input-group-addon hidden-md hidden-lg title_label" >LOCAL.</span>
              <input type="text" class="form-control" id="est_cat_localidad" disabled="">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('estados_catastrales')"> 
              <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp;CERRAR
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "AMPLIAR_PLAZOS_DE_CORTES"), $opciones)) { ?> 
<div id="ampliaciones_cortes" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" name="button" class="close" data-dismiss='modal' onclick='ocultar_modal("ampliaciones_cortes")'>&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> &nbsp; AMPLIAR FECHA DE RECIBOS</h4>
      </div>
      <div class="modal-body">  
        <div class="callout callout-info cuadro_dialogo">
          <h5 class="dialogo_titulo"><i class="fa fa-info"></i> IMPORTANTE</h5>
          <p style="margin:0">Para dar ampliación de plazo debe tener en cuenta lo siguiente: </p>
          <ul>
            <li>Que el recibo no este vencido.</li>
            <li>Fecha máxima de plazo será el ultimo día del mes de vencimiento</li>
            <li>Los clientes que soliciten ampliación de plazo seran los primeros en salir a cortes en las sucesivas ordenes de corte</li>
          </ul>
        </div>
        <div class="box box-success">
          <div class="box-body">
            <div class="row">
              <div class="col-md-7 col-sm-12 col-xs-12">
                <div class="table-responsive">
                  <table id="lista_recibos" class="table table-bordered table-striped">
                    <thead>
                      <tr role="row">
                        <th>SERIE</th>
                        <th>NUMERO</th>
                        <th>EMISION</th>
                        <th>VENCIMIENTO</th>
                        <th>AMPLIAR PLAZO</th>
                      </tr>
                    </thead>
                    <tbody id='cuerpo_recibos_pendientes'>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="input-group label_input" >
                  <span class="input-group-addon title_label" >RECIBO</span>
                  <input type="text" class="form-control" id="numero_recibo" disabled>
                </div>
                <div class="input-group label_input">
                  <span class="input-group-addon hidden-xs hidden-sm title_label" >F. EMISIÓN</span>
                  <span class="input-group-addon hidden-md hidden-lg title_label" >F. EMI.</span>
                  <input type="text" class="form-control" id="emision_recibo" disabled>
                </div>
                <div class="input-group label_input">
                  <span class="input-group-addon hidden-xs hidden-sm title_label">F. VENCIMIENTO</span>
                  <span class="input-group-addon hidden-md hidden-lg title_label">F. VENC.</span>
                  <input type="text" class="form-control" id="vencimiento_recibo"  disabled>
                </div>
                <div class="input-group label_input">
                  <span class="input-group-addon hidden-xs hidden-sm title_label">AMPLIAR PLAZO HASTA</span>
                  <span class="input-group-addon hidden-md hidden-lg title_label">AMPLIAR</span>
                  <input type="text" class="form-control" id="fecha_plazo" onclick="colocar_fecha()" disabled>
                </div>
                <div class="input-group label_input">
                  <span class="input-group-addon title_label">GLOSA</span>
                  <input type="text" class="form-control" id="glosa_plazo">
                </div>
                <div class="row" style="margin-top: 10px">
                  <div class="col-md-6">
                    <a class="btn btn-success btn-total" id='btn_ampliacion' disabled><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; CONFIRMAR</a>
                  </div>
                  <div class="col-md-6">
                    <a class="btn btn-danger btn-total" onclick='ocultar_modal("ampliaciones_cortes")'><i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "VER_AMPLIACIONES"), $opciones)) {  ?>
<div class="modal fade" id='ampliaciones' role='dialog'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green"> 
        <button type="button" name="button" class="close" data-dismiss='modal' onclick='ocultar_modal("ampliaciones")'>&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> &nbsp; AMPLIACIONES DE RECIBOS</h4>
      </div>
      <div class="modal-body cuerpo_scroll">
        <div class="row">
          <div class="col-md-12"><br>
            <div class="table-responsive">
              <table id="ampliaciones_lista" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>SERIE</th>
                    <th>NUMERO</th>
                    <th>VENC./ORIG.</th>
                    <th>GLOSA</th>
                    <th>LOGIN</th>
                    <th>USUARIO</th>
                    <th>VENCE/CORTE</th>
                  </tr>
                </thead>
                <tbody id='cuerpo_ampliaciones'>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('ampliaciones')"> 
              <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "DETALLE_NCA"), $opciones)) { ?>
<div class="modal fade" id="modal_nota_credito" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('modal_nota_credito')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; DETALLE DE LA NOTA CRÉDITO <span id='serie_numero'></span> </h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
          <div class='box-header borde_box'>
                <div class='row'>
                    <div class='col-md-4 col-sm-4 label_input'>
                        <div class='input-group'>
                            <span class="input-group-addon title_label">FECHA</span>
                            <input type="text" class="form-control derecha" id="detalle_nca_fecha" disabled="">
                        </div>
                    </div>
                    <div class='col-md-4 col-sm-4 label_input'>
                        <div class='input-group'>
                            <span class="input-group-addon title_label">REFERENCIA</span>
                            <input type="text" class="form-control derecha" id="detalle_nca_referencia" disabled="">
                        </div>
                    </div>
                    <div class='col-md-4 col-sm-4 label_input'>
                        <div class='input-group'>
                            <span class="input-group-addon title_label">CREADO</span>
                            <input type="text" class="form-control derecha" id="detalle_nca_usuario" disabled="">
                        </div>
                    </div>
                </div>
            </div>
          <div class="box-body">
            <div class="table-responsive">
                <table id="notas_credito" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nº CONCEPTO</th>
                      <th>CONCEPTO</th>
                      <th>MONTO</th>
                      <th>DESCUENTO</th>
                      <th>DIFERENCIA</th>
                    </tr>
                  </thead>
                  <tbody id='cuerpo_detalle'>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('modal_nota_credito')"> 
              <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "AUTORIZACIONES"), $opciones)) { ?>
<div class="modal fade" id="autorizaciones" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('autorizaciones')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-gavel" aria-hidden="true"></i> &nbsp;AUTORIZACIONES DE RECIBO</h4>
      </div>
      <div class="modal-body">
          <div class="box box-primary">
              <div class='box-body'>
                  <div class="table-responsive">
                    <table id="notas_credito" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>N°</th>
                          <th>SUMINISTRO</th>
                          <th>SERIE</th>
                          <th>NÚMERO</th>
                          <th>FECHA MÁXIMA</th>
                          <th>TIPO</th>
                          <th>OPCIONES</th>
                        </tr>
                      </thead>
                      <tbody id='cuerpo_autorizaciones'>
                      </tbody>
                    </table>
                </div>
              </div>
          </div>  
      </div>
      <div class="modal-footer borde_footer">
        <div class="row">
          <div class="col-md-4 col-sm-4">
              <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('autorizaciones')"> <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp;CANCELAR</button>
          </div>
          <div class="col-md-4 col-sm-4"> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "IMPRIMIR_PAGOS_RANGOS"), $opciones)) { ?>
<div class="modal fade" id="rangos_pagos" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('rangos_pagos')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-print" aria-hidden="true"></i> &nbsp; IMPRIMIR POR RANGOS </h4>
      </div>
      <div class="modal-body">
        <div class="callout callout-info cuadro_dialogo">
          <h5 class="dialogo_titulo"><i class="fa fa-info"></i> IMPORTANTE</h5>
          <p style="margin:0">Para imprimir por rango los pagos: </p>
          <ul>
            <li>Debe seleccionar el periodo de inicio y el periodo de fin.</li>
            <li>Si solo selecciona el periodo de inicio este imprimira desde este periodo hasta el actual</li>
          </ul>
        </div>  
        <div class="row">
          <div class="col-md-4 col-sm-4 label_input">
            <div class="input-group ">
              <span class="input-group-addon hidden-sm hidden-xs title_label">SUMINISTRO</span>
              <span class="input-group-addon hidden-md hidden-lg title_label">SUM.</span>
              <input type="text" class="form-control" id="rango_suministro" value="" disabled>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 label_input">
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs title_label">PER. INICIO</span>
              <span class="input-group-addon hidden-md hidden-lg title_label">PER. INI.</span>
              <select class="form-control" id="rango_inicio" onchange="validar_segundo_pediodo_rangos()">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 label_input" >
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs title_label">PER. FINAL</span>
              <span class="input-group-addon hidden-md hidden-lg title_label">PER. FIN.</span>
              <select class="form-control" id="rango_fin" disabled>
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4 col-xs-12 label_input">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('rangos_pagos')"> 
              <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR
          </button>
        </div>
        <div class="col-md-4 col-sm-4"></div>
        <div class="col-md-4 col-sm-4 col-xs-12 label_input">
            <button type="button" class="btn btn-success btn-total" id='btn_visualizar'><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; VISUALIZAR</button>
          </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php  if (in_array(array("BTNGENNOMRE" => "DUPLICADO_DE_RECIBO"), $opciones)) { ?>
		<div class="modal fade" id="duplicado_recibo" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content contenido_modal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title titulo_modal"><i class="fa fa-file-text" aria-hidden="true"></i> &nbsp; Duplicado de recibos</h4>
					</div>
					<div class="modal-body">
						<div class='row'>
							<div class='col-md-12'>
								<div class="callout bg-success cuadro_dialogo">
									<h5 class="dialogo_titulo"><i class="fa fa-info"></i> IMPORTANTE</h5>
									<p style="margin:0">Para obtener el duplicado del recibo: </p>
									<ul>
									<li>Debe seleccionar algún periodo del que se muestra en el combo.</li>
									<li>Si el recibo es a partir del 2017, saldra con el nuevo diseño de duplicado.</li>
									<li>Si el recibo es de años anteriores al 2017 saldra con el diseño antiguo.</li>
									</ul>
								</div> 
							</div>
						</div><br>
						<div class="row">
							<div class="col-md-6 col-sm-6 ">
								<div class="input-group">
									<span class="input-group-addon hidden-sm hidden-xs bg-blue" style="border:none; border-radius: 4px 0px 0px 4px;">PERIODO</span>
									<span class="input-group-addon hidden-md hidden-lg bg-blue" style="border:none; border-radius: 4px 0px 0px 4px;">PER.</span>
									<select class="form-control" id="periodo_inicio">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="col-md-2 col-sm-2 ">
								<button class="btn btn-success btn-sm btn-total" onclick="buscar_duplicado('<?php echo $sum_real ?>')"> <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Buscar</button>
							</div>
							<div class="col-md-2 col-sm-2 " style='display:none' id="buscar_duplciado">
								<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
							</div>
						</div><br>
						<div class="row">
							<div class="col-md-12 table-responsive">
								<table class="table table-bordered table-striped" id="tabla_duplicados" style="font-size:13px; display:none">
									<thead>
										<tr>
											<th>Serie - Número</th>
											<th>Volumen</th>
											<th>Fch. Emisión</th>
											<th>Fch. Vencimiento</th>
											<th>Monto (S/)</th>
											<th>Estado</th>
											<th>Opciones</th>
										</tr>
									</thead>
									<tbody id="cuerpo_tabla_duplicados">
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="modal-footer borde_footer">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								<button type="button" class="btn btn-danger btn-sm btn-total" data-dismiss="modal" > <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; Cerrar</button>
							</div>
							<div class="col-md-4 col-sm-4"> </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php if (in_array(array("BTNGENNOMRE" => "VER_HISTORIAL_DE_CONSUMOS"), $opciones)) {?>
<div class="modal fade" id="consumos" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido_modal">
            <div class="modal-header head_green">
                <button type="button" class="close" data-dismiss="modal" onclick="ocultar_model('consumos')">&times;</button>
                <h4 class="modal-title titulo_modal"><i class="fa fa-bar-chart" aria-hidden="true"></i> &nbsp; HISTORIAL DE CONSUMOS</h4>
            </div>
            <div class="modal-body">
                <center>
                <div id='grafico'></div>
                </center>
            </div>
            <div class="modal-footer borde_footer">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('consumos')"> 
                            <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CANCELAR
                        </button>
                    </div>
                    <div class="col-md-4 col-sm-4"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/dist/js/Genesys/cuenta_corriente/cuenta_corriente.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/hightchart/highcharts.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/hightchart/data.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/hightchart/sand-signika.js"></script>
<script>
  $('#deuda_capital').val("<?php echo "S./ ".number_format(($sum_recibo2 + $sum_recibo + $sum_notasD - $sum_notasC), 2, '.', '');  ?>");
  $('#deuda_exigible').val("<?php echo "S./".number_format((floatval($monto_convenios['TOTAL']) + $sum_recibo2 + $sum_recibo + $sum_notasD - $sum_notasC), 2, '.', ''); ?>");
  $('#deuda_final').val("<?php $interes = number_format(($moratorio*0.18),2,'.',''); echo "S./ ".number_format(($sum_recibo2 + $sum_recibo + $sum_notasD + floatval($monto_convenios['TOTAL']) - $sum_notasC + $interes_moratorio+$moratorio+floatval($interes)), 2, '.', '');  ?>");
</script>
<?php function dateDiff($start, $end) { $start_ts = strtotime($start); $end_ts = strtotime($end); $diff = $end_ts - $start_ts;return round($diff / 86400);} ?>
