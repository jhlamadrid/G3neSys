<script type="text/javascript">
  let servidor = '<?php echo $this->config->item('ip'); ?>';
  let suministro = '<?php echo $suministro; ?>';
  var key = '<?php echo $key; ?>';
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/cuenta_corriente/template.css">
<section class="content">
  <div class="box box-success">
    <div class="box-body borde_head">
      <div class="row">
        <div class='col-md-3 col-sm-3'>
          <h3 class="box-title text-info title_window"> <i class="fa fa-history" aria-hidden="true"></i> HISTÓRICO DE PAGOS </h3>
        </div>
        <div class='col-md-4 col-sm-4'>
          <div class="input-group drop">
            <span class="input-group-addon bordes"><?php echo $suministro; ?></span>
            <input type="text" class="form-control" value="<?php echo $user['CLINOMBRE']; ?>" disabled="disabled">
          </div>
        </div>
        <div class='col-md-3 col-sm-3 center'>
          <div class="dropdown drop">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-filter" aria-hidden="true"></i> Opciones
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu bg_color">
              <?php if($imprimir_pagos) { ?>
                <li><a id="imprimir_pagos"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR TODOS LOS PAGOS</a></li>
              <?php } ?>
              <?php if($imprimir_pagos_rangos) { ?>
                <li role="separator" class="divider"></li>
                <li><a id="imprimir_rangos"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR POR RANGO</a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-2">
          <a class="btn btn-danger drop" onclick="window.close()"><i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR VENTANA</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="box box-success">
        <div class="box-body table-responsive">
          <span class="text-red"><b>* LOS PAGOS EXTORNADOS ESTAN CON ROJO</b></span>
          <table id="resumen" class="table table-bordered table-striped">
            <thead>
              <tr role="row">
                <th>SERIE</th>
                <th>NÚMERO</th>
                <th class="hidden-xs">FCH. EMI</th>
                <th class="hidden-xs">FCH. VEN.</th>
                <th>FCH. PAG.</th>
                <th class="hidden-sm hidden-xs">RETRAZO</th>
                <th class="hidden-md hidden-sm hidden-xs">HORA</th>
                <th>FACTURADO</th>
                <th>NOT. CRÉD.</th>
                <th>NOT. DEBI.</th>
                <th>PAGADO</th>
                <th class="hidden-md hidden-sm hidden-xs">OFI.</th>
                <th class="hidden-md hidden-sm hidden-xs">AGE.</th>
                <th>PUNTO COBRANZA</th>
                <th>OPCIONES</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($pagos as $pago) { ?>
              <tr <?php echo (($pago['HISCOBTIP'] == 'E') ? "style='color:#F00'" : ""); ?>>
                <td><?php echo $pago['TOTFAC_FACSERNRO'] ?></td>
                <td><?php echo $pago['TOTFAC_FACNRO'] ?></td>
                <td class="hidden-xs"><?php echo $pago['HISEMIFEC'] ?></td>
                <td class="hidden-xs"><?php echo $pago['FACVENFEC'] ?></td>
                <td><?php echo $pago['HISCOBFEC'] ?></td>
                <td class="hidden-sm hidden-xs derecha">
                  <?php 
                    $diferencia = dateDiff((substr($pago['FACVENFEC'],6,4)."-".substr($pago['FACVENFEC'],3,2)."-".substr($pago['FACVENFEC'],0,2)),(substr($pago['HISCOBFEC'],6,4)."-".substr($pago['HISCOBFEC'],3,2)."-".substr($pago['HISCOBFEC'],0,2)));
                    if($diferencia<0) echo 0;
                    else echo $diferencia;
                  ?>
                </td>
                <td class="hidden-md hidden-sm hidden-xs" style="text-align:right"><?php echo $pago['HISCOBHRS'] ?></td>
                <td class="derecha"><?php echo number_format(floatval($pago['HISPAGO']),2,'.','') ?></td>
                <td class="derecha"><?php echo (($pago['monto_credito'] > 0) ? "<span style='color:#dd4b39'>-".number_format(floatval($pago['monto_credito']),2,'.','')."</span>" : "0.00"); ?></td>
                <td class="derecha"><?php echo number_format(floatval($pago['monto_debito']),2,'.',''); ?></td>
                <td class="derecha"><?php echo number_format(floatval($pago['HISPAGO']) - floatval($pago['monto_credito']) + floatval($pago['monto_debito']) ,2,'.','') ?></td>
                <td class="hidden-md hidden-sm hidden-xs"><?php echo $pago['AGENCI_OFICIN_OFICOD']?></td>
                <td class="hidden-md hidden-sm hidden-xs"><?php echo $pago['AGENCI_OFIAGECOD']?></td>
                <td ><?php echo $pago['OFIAGEDES']?></td>
                <td class="center">
                  <?php echo $pago['opciones']; ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</section>
<!--
************************************************************************************************
*                             DETALLE FACTURADO DE UN RECIBO                                   *
*                  --------------------------------------------------------                    *
*        -> Muestra la lista de conceptos facturados a un recibo de un cliente                 *
*        -> Muestra la información del usuario                                                 *
*        -> Muestra los montos que se facturaron por cada concepto                             *
************************************************************************************************
-->
<?php 
if (isset($detalle_recibo)) { 
  #Validamos que el usuario tenga acceso a la opción de "VER DETALLE DEL RECIBO"
?>
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
          <button type="button" class="btn btn-danger btn-block pull-left" data-dismiss="modal" onclick="ocultar_modal('detalle_recibo')"> 
            <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<!--
************************************************************************************************
*                     MODAL PARA VER EL DETALLE DE LA NOTA DE CRÉDITO                          *
*                    --------------------------------------------------                        *
*         -> Muestra los conceptos del recibo con su monto facturado, además de                *
*           mostrar su descuento y el valor que queda (CONCEPTOS SIN IGV)                      *
************************************************************************************************
-->
<?php 
if (isset($detalle_nca)) { 
#Validamos que el usuario tenga acceso a la opción de "DETALLE DE LA NOTA DE CRÉDITO"
?>
<div class="modal fade" id="modal_nota_credito" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('modal_nota_credito')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-info" aria-hidden="true"></i> DETALLE DE LA NOTA CRÉDITO <span id='serie_numero'></span> </h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="input-group drop">
                  <span class="input-group-addon bordes">VOL. FACTURADO</span>
                  <input class="form-control" id="volFacturado" disabled="disabled" type="text">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group drop">
                  <span class="input-group-addon bordes">VOL. DESCONTADO</span>
                  <input class="form-control" id="volDescontado" disabled="disabled" type="text">
                </div>
              </div>
            </div><br>
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
          <button type="button" class="btn btn-danger btn-block pull-left" data-dismiss="modal" onclick="ocultar_modal('modal_nota_credito')"> 
            <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<!--
************************************************************************************************
*                         MODAL PARA IMPRIMIR LOS PAGOS POR RANGOS                             *
*                ------------------------------------------------------------                  *
*         -> Muestra los conceptos del recibo con su monto facturado, además de                *
*           mostrar su descuento y el valor que queda (CONCEPTOS SIN IGV)                      *
************************************************************************************************
-->
<?php 
if (isset($imprimir_pagos_rangos)) { 
#Validamos que el usuario tenga acceso a la opción de "IMPRIMIR POR RANGOS"
?>
<div class="modal fade" id="rangos_pagos" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" onclick="ocultar_modal('rangos_pagos')">&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR POR RANGOS </h4>
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
              <span class="input-group-addon hidden-sm hidden-xs bordes">SUMINISTRO</span>
              <span class="input-group-addon hidden-md hidden-lg bordes">SUM.</span>
              <input type="text" class="form-control" id="faturacion_suministro" value="" disabled>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 label_input">
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs bordes">PER. INICIO</span>
              <span class="input-group-addon hidden-md hidden-lg bordes">PER. INI.</span>
              <select class="form-control" id="facturacion_periodos_inicio" onchange="validar_segundo_pediodo()">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 label_input" >
            <div class="input-group">
              <span class="input-group-addon hidden-sm hidden-xs bordes">PER. FINAL</span>
              <span class="input-group-addon hidden-md hidden-lg bordes">PER. FIN.</span>
              <select class="form-control" id="facturacion_periodos_fin" disabled>
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4 col-xs-12 label_input">
          <button type="button" class="btn btn-danger btn-block pull-left" data-dismiss="modal" onclick="ocultar_modal('rangos_pagos')"> 
            <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR
          </button>
        </div>
        <div class="col-md-4 col-sm-4"></div>
        <div class="col-md-4 col-sm-4 col-xs-12 label_input">
            <button type="button" class="btn btn-success btn-block" id='btn_visualizar'><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; VISUALIZAR</button>
          </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/dist/js/Genesys/cuenta_corriente/pagos.js"></script>
<?php
  function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
  }

