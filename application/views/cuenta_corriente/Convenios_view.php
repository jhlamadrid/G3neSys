<script type="text/javascript">
var servidor = '<?php echo $this->config->item('ip'); ?>';
var suministro = '<?php echo $suministro; ?>';
var detalle_convenio = '<?php echo $detalle_convenio; ?>';
var imprimir_convenio = '<?php echo $imprimir_convenio; ?>';
</script>
<?php $sum_convenios = 0; ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/cuenta_corriente/app.css">
<section class="content">
  <div class="row">
      <div class="col-md-2 col-sm-2">
           <h4 class="titulo_box text-info" style="margin:0;font-size: 22px !important"><i class="fa fa-user" aria-hidden="true"></i> &nbsp; CONVENIOS</h4>
      </div> 
    <div class="col-md-3 col-sm-3 label_input">
      <div class="input-group">
          <span class="input-group-addon hidden-xs hidden-sm title_label">SUMINISTRO</span>
          <span class="input-group-addon hidden-md hidden-lg title_label">SUM.</span>
          <input type="text" class="form-control" value="<?php echo $suministro ?>" disabled>
      </div>
    </div>
    <div class="col-md-3 col-sm-3 label_input">
      <div class="input-group">
        <span class="input-group-addon hidden-xs hidden-sm title_label">SALDO CONVENIOS</span>
        <span class="input-group-addon hidden-md hidden-lg title_label">SALDO</span>
        <input type="text" class="form-control" value="<?php echo number_format($monto['TOTAL'],2,'.',''); ?>" disabled>
      </div>
    </div>
      <div class="col-md-2 col-sm-2 label_input center" style="border: 1px solid #8fb2e6;padding-top: 5px;">
      <input type="checkbox" id='cta_939_940' value=""> 
      <label for="cta_939_940"><i class="fa fa-eye" aria-hidden="true"></i> VER CTA. 939 - 940</label> 
    </div>
    <div class="col-md-2 col-sm-2 label_input">
      <a href="" class="btn btn-danger btn-total" style="float:right" onclick="window.close()">  <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</a>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body table-responsive">
          <table id="convenios" class="table table-bordered table-striped">
            <thead>
              <tr role="row">
                <th>OFICINA</th>
                <th>AGENCIA</th>
                <th>NÚMERO</th>
                <th>FECHA</th>
                <th>DEUDA</th>
                <th>INICIAL</th>
                <th>ESTADO</th>
                <th>CUENTA.</th>
                <th>CONCEPTO</th>
                <th>REFERENCIA</th>
                <th>SALDO</th>
                <th>HECHO POR</th>
                <th>OPCIONES</th>
              </tr>
            </thead>
            <tbody id="cuerpo_convenios">
            <?php foreach($convenios as $convenio){ ?>
              <tr>
                <td class='derecha'><?php echo $convenio['AGENCI_OFICIN_OFICOD'] ?></td>
                <td class='derecha'><?php echo $convenio['AGENCI_OFIAGECOD'] ?></td>
                <td><?php echo $convenio['CREDNRO'] ?></td>
                <td><?php echo $convenio['CREDFECHA'] ?></td>
                <td class="derecha"><?php echo number_format($convenio['DEUDATOTAL'],2,'.','') ?></td>
                <td class='derecha'><?php echo number_format($convenio['CTAINICIAL'],2,'.','') ?></td>
                <td><?php echo $convenio['CREDSTATUS'] ?></td>
                <td class="derecha"><?php echo $convenio['CONCEP_FACCONCOD'] ?></td>
                <td><?php echo $convenio['FACCONDES'] ?></td>
                <td><?php echo $convenio['CREREFDOC'] ?></td>
                <?php $bandera = 0;foreach($convenios_pendientes as $pendiente) {
                        if($pendiente['CREDNRO'] == $convenio['CREDNRO']){$bandera = 1;$sum_convenios += (floatval($convenio['DEUDATOTAL'])-floatval($convenio['CTAINICIAL']));break;}
                }?>
                <?php if($bandera == 1 ){?>
                <td class="derecha text-blue"><?php echo number_format((floatval($convenio['DEUDATOTAL'])-floatval($convenio['CTAINICIAL'])),2,'.','') ?></td>
                <?php }else{ ?>
                <td class='derecha'><?php echo number_format((floatval($convenio['DEUDATOTAL'])-floatval($convenio['CTAINICIAL'])),2,'.','') ?></td>
                <?php } ?>
                <td><?php echo $convenio['NNOMBRE'] ?></td>
                <td class="center" style="vertical-align: middle;">
                    <div class="dropdown drop">
                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fa fa-filter" aria-hidden="true"></i> Opciones<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right bg_color">
                            <?php if($detalle_convenio) { ?>
                                <li>  
                                    <a onclick="ver_detalle_convenido('<?php echo $convenio['AGENCI_OFICIN_OFICOD']; ?>','<?php echo $convenio['AGENCI_OFIAGECOD']; ?>','<?php echo $convenio['CREDNRO']; ?>')"  class="hover_yellow" >
                                        <i class="fa fa-eye" aria-hidden="true"></i> DETALLE CONVENIO
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if($imprimir_convenio) { ?>
                                <li class="divider"></li>
                                <li>  
                                    <a onclick="imprimir_convenio('<?php echo $convenio['AGENCI_OFICIN_OFICOD']; ?>','<?php echo $convenio['AGENCI_OFIAGECOD']; ?>','<?php echo $convenio['CREDNRO']; ?>')"  class="hover_yellow" >
                                        <i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR CONVENIO
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
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
*                    MODAL PARA OTORGAR LAS AMPLIACIONES DE CORTES                             *
*                   -----------------------------------------------                            *
*        -> Muestra la lista de recibos pendiente de pagos                                     *
*        -> Solo se le podrá ampliar el plazo a los recibos que esten dentro del periodo       *
*        -> Solo se podrá ampliar hasta el final del periodo                                   *
************************************************************************************************
-->
<?php 
if ($detalle_convenio) { 
#Validamos que el usuario tenga acceso a la opción de "VER DETALLE DEL CONVENIO"
?> 
<div id="detalle_convenio" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green">
        <button type="button" name="button" class="close" data-dismiss='modal' onclick='ocultar_modal("detalle_convenio")'>&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-th-list" aria-hidden="true"></i> &nbsp; DETALLE DE CONVENIO</h4>
      </div>
      <div class="modal-body">  
        <div class="box box-success">
            <div class='box-header borde_box' id='cabecerra_detalle_convenio'>
                
            </div>
          <div class="box-body cuerpo_scroll1">
            <div class="row">
                <div class='col-md-12'>
                    <div class="table-responsive">
                        <table id="cuotas" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>NÚMERO</th>
                              <th>SALDO</th>
                              <th>AMORTIZA</th>
                              <th>INTERÉS</th>
                              <th>GasCob</th>
                              <th>ACCIONES</th>
                              <th>IGV</th>
                              <th>CUOTAS</th>
                              <th>VENCIMIENTO</th>
                              <th>ESTADO</th>
                              <th>RECIBO</th>    
                            </tr>
                          </thead>
                          <tbody id='cuerpo_letras'>
                          </tbody>
                        </table>
                    </div>  
                </div>
            </div>
          </div>
        </div>
      </div>
       <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" onclick="ocultar_modal('detalle_convenio')"> 
              <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script>
    var convenios = <?php echo json_encode($convenios); ?>;
    var convenios939_940 = <?php echo json_encode($convenios_939_940); ?>;
    var convenios_pendientes = <?php echo json_encode($convenios_pendientes); ?>;
</script>
<script type="text/javascript" src="<?php  echo $this->config->item('ip') ?>frontend/dist/js/Genesys/cuenta_corriente/convenios.min.js "></script>
