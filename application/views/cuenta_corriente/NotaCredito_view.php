<style> #unidad1 > tr > td{ border: 1px solid !important; } .formato{padding: 5px 0px 0px 10px;} .formato2{padding: 2px 3px 2px 5px;}</style>
<script type="text/javascript">
  var tipo = <?php echo $tipo;  ?>;
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 col-sm-3" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger hidden-sm hidden-xs" style="width:90px">SUMINISTRO</button>
                  <button type="button" class="btn btn-danger hidden-md hidden-lg" style="width:70px">SUM.</button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo $user_datos['CLICODFAC']; ?>" disabled="">
              </div>
            </div>
            <div class="col-md-6 col-sm-6" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger hidden-sm hidden-xs" style="width:90px">NOMBRE</button>
                  <button type="button" class="btn btn-danger hidden-md hidden-lg" style="width:70px">NOM.</button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo $user_datos['CLINOMBRE']; ?>" disabled="">
              </div>
            </div>
            <div class="col-md-3 col-sm-3" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger hidden-xs hidden-sm" style="width:90px">RECIBO</button>
                  <button type="button" class="btn btn-danger hidden-md hidden-lg" style="width:70px">REC.</button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo $serie."-".$numero; ?>" disabled="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger hidden-sm hidden-xs" style="width:90px">TARIFA</button>
                  <button type="button" class="btn btn-danger hidden-md hidden-lg" style="width:70px">TAR.</button>
                </div>
                <input type="text" name="" class='form-control'id='tarifa_recibo' value="<?php echo $recibo['FACTARIFA']; ?>" disabled="">
              </div>
              </div>
              <div class="col-md-6 col-sm-5" style="margin-top:5px">
                <div class="input-group">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger hidden-sm hidden-xs" style="width:90px">DIRECCIÓN</button>
                    <button type="button" class="btn btn-danger hidden-md hidden-lg" style="width:70px">DIR.</button>
                  </div>
                  <input type="text" name="" class='form-control' value="<?php echo $user_datos['URBDES'].' '.$user_datos['CALDES'].' '.$user_datos['CLIMUNNRO']; ?>" disabled="">
                </div>
              </div>
              <div class="col-md-2 col-sm-3" style="margin-top:5px">
                <div class="input-group">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger hidden-sm hidden-xs" style="width:90px">MONTO</button>
                    <button type="button" class="btn btn-danger hidden-md hidden-lg" style="width:70px">MON.</button>
                  </div>
                  <input type="text" name="" class='form-control' value="<?php echo number_format($MONTO,2,'.',''); ?>" disabled="">
                </div>
              </div>
              <div class="col-md-2 col-sm-2" style="margin-top:5px">
                <div class="input-group">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger hidden-sm hidden-xs" style="width:90px">VOLUMEN</button>
                    <button type="button" class="btn btn-danger hidden-md hidden-lg" style="width:60px">VOL.</button>
                  </div>
                  <input type="text" name="" value="<?php echo $volumen."m³"; ?>" class="form-control" disabled="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h4 class="box-title" style="margin:0;font-family:'Ubuntu';font-weight: bold">NOTAS DE CRÉDITO ASOCIADAS</h4>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id='notas_creditos' class="table table-bordered table-striped">
                <thead role='row'>
                  <th>SERIE NOTA</th>
                  <th>N° NOTA</th>
                  <th>FECHA NOTA</th>
                  <th>MES RECIBO</th>
                  <th>SUMINISTRO</th>
                  <th>TOTAL</th>
                  <th>OPCIONES</th>
                </thead>
                <tbody>
                <?php foreach ($notas_credito as $NC  ) { ?>
                  <tr>
                  <td><?php echo $NC['NCASERNRO']; ?></td>
                  <td><?php echo $NC['NCANRO']; ?></td>
                  <td><?php echo $NC['NCAFECHA']; ?></td>
                  <td><?php echo $NC['NCAFACEMIF']; ?></td>
                  <td><?php echo $NC['NCACLICODF']; ?></td>
                  <td style="text-align:right"><?php echo number_format($NC['NCATOTDIF'],2,'.',''); ?></td>
                  <td style='text-align:center'>
                    <a onclick="ver_notaCredito('<?php echo $key; ?>','<?php echo $NC['NCASERNRO']; ?>','<?php echo $NC['NCANRO']; ?>')"  id="ver_nc" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="IMPRIMIR">
                      <i class="fa fa-print"></i>
                    </a>
                    <a onclick="detalle_nota('<?php echo $NC['NCACLICODF']; ?>','<?php echo $NC['NCASERNRO']; ?>','<?php echo $NC['NCANRO']; ?>')" id='detalle_nc' class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="DETALLE">
                      <i class="fa fa-eye" aria-hidden="true"></i>
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
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-2 col-sm-2 col-sx-2">
              <a class="btn btn-primary btn-block hidden-xs hidden-sm" onclick="abrir_calculadora()"><i class="fa fa-calculator" aria-hidden="true"></i> &nbsp; CALCULADORA</a>
              <a class="btn btn-primary btn-block hidden-md hidden-lg" onclick="abrir_calculadora()"><i class="fa fa-calculator" aria-hidden="true"></i> &nbsp; CALC.</a>
            </div>
            <div class="col-md-2 col-sm-2 col-sx-2">
              <a class="btn btn-success btn-block hidden-xs hidden-sm" onclick="anular_recibo()"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp; ANULAR RECIBO</a>
              <a class="btn btn-success btn-block hidden-md hidden-lg" onclick="anular_recibo()"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp; ANULAR</a>
            </div>
            <div class="col-md-2 col-sm-2 col-sx-2 ">
                <a class="btn btn-warning btn-block hidden-xs hidden-sm" onclick="manual_recibo()"><i class="fa fa-hand-spock-o" aria-hidden="true"></i> &nbsp; MANUAL</a>
                <a class="btn btn-warning btn-block hidden-md hidden-lg" onclick="manual_recibo()"><i class="fa fa-hand-spock-o" aria-hidden="true"></i> &nbsp; MANU.</a>
            </div>
            <div class="col-md-2 col-sm-2">

            </div>
            <div class="col-md-4 col-sm-4 col-sx-6">
              <div class="form-group">
                <b><span class="text-red">REFERENCIA: </span></b>
                <input type="text" id='referencia_nc' class="form-control" value="<?php echo ((isset($reclamo)) ? $reclamo : "" ) ?>" />
              </div>
            </div>
          </div>
        </div>
        <div class="box-body" style="font-size:1.1em">
          <div class="row">
            <div class="col-md-12 col-sm-12" >
              <div class="table-responsive">
                <table id="recibos_pendientes" class="table table-bordered table-striped">
                  <thead>
                    <tr role="row">
                      <th>N°</th>
                      <th>CONCEPTO</th>
                      <th>IMPORTE</th>
                      <th>DESCUENTO</th>
                      <th>VALOR RESULTANTE</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $monto_real = 0; $subtotal = 0; $IGV = 0; $i = 0;foreach($faclin as $fac){ ?>
                    <tr>
                      <td class="concep"><?php echo $fac['FACCONCOD'] ?></td>
                      <td><?php echo $fac['FACCONDES'] ?></td>
                      <?php if($fac['FACCONCOD'] == '201') {?>
                        <td style="text-align:right" id='monto_agua' class="fac_recibo" id='agua_recibo'><?php echo number_format($fac['FACPRECI'],2,'.','') ?></td>
                        <td style="text-align:right !important"><input type="text" class='money2 faclin'  id='subtotal_agua' style="text-align:right" value='<?php echo number_format(0,2,'.','') ?>' onkeyup="validar_monto2(<?php echo $fac['FACPRECI'] ?>,this,event,'agua',<?php echo $i ?>)" disabled/><br><span id='error1<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                        <td style="text-align:right !important"><input type="text" style="text-align:right" id='agua'  disabled  class='money8' value="<?php echo number_format($fac['FACPRECI'],2,'.','') ?>" /></td>
                        <?php $monto_real += $fac['FACPRECI'];  ?>
                      <?php } else if($fac['FACCONCOD'] == '301') {?>
                        <td style="text-align:right" id='monto_desague' class="fac_recibo"><?php echo number_format($fac['FACPRECI'],2,'.','') ?></td>
                        <td style="text-align:right !important"><input type="text" style="text-align:right"id='subtotal_desague'  disabled class='money2 faclin' value='<?php echo number_format(0,2,'.','') ?>' onkeyup="validar_monto2(<?php echo $fac['FACPRECI'] ?>,this,event,'desague',<?php echo $i ?>)" disabled/><br><span id='error1<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                        <td style="text-align:right !important"><input type="text" id='desague'  style="text-align:right" class='money8' disabled value="<?php echo number_format($fac['FACPRECI'],2,'.','') ?>" /></td>

                        <?php $monto_real += $fac['FACPRECI'];  ?>
                      <?php } else { ?>
                        <td style="text-align:right" class="fac_recibo" id='monto_fac1<?php echo $i; ?>'><?php echo number_format($fac['FACPRECI'],2,'.','') ?></td>
                        <td style="text-align:right !important"><input type="text" style="text-align:right" id='descuento1<?php echo $i; ?>' class='money2 faclin' value="0.00"  onkeyup="validar_monto(<?php echo $fac['FACPRECI'] ?>,this,'<?php echo $i; ?>',event)" /><br><span id='error1<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                        <td style="text-align:right !important"><input type="text" id='subtotal1<?php echo $i; ?>' class='money8' style="text-align:right" value='<?php echo number_format($fac['FACPRECI'],2,'.','') ?>' disabled/></td>
                        <?php $monto_real += $fac['FACPRECI'];  ?>
                      <?php } ?>
                    </tr>
                    <?php $i++; $subtotal = $subtotal + floatval($fac['FACPRECI']); $IGV +=(floatval($fac['FACPRECI']) *(intval($igv)/100)) ;}?>
                    <?php $i = 0;foreach($letfac as $let){ ?>
                    <tr>
                      <td class="concep1"><?php echo $let['FACCONCOD'] ?></td>
                      <td><?php echo $let['FACCONDES'] ?></td>
                      <td style="text-align:right" class='let_recibo' id='monto_fac2<?php echo $i; ?>'><?php echo number_format($let['CRECUOMON'],2,'.','') ?></td>
                      <?php $monto_real += $let['CRECUOMON'];  ?>
                      <?php if(floatval($let['CRECUOMON'])<0) {?>
                        <td style="text-align:right !important"><input type="text" style="text-align:right" id='descuento2<?php echo $i; ?>' value="0.00" class='money2 letfac' disabled/></td>
                      <?php } else { ?>
                        <td style="text-align:right !important"><input type="text" style="text-align:right" id='descuento2<?php echo $i; ?>' value="0.00" onkeyup="validar_monto1(<?php echo $let['CRECUOMON'] ?>,this,'<?php echo $i; ?>',event)" class='money2 letfac'/><br><span id='error2<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                      <?php } ?>
                      <td style="text-align:right !important"><input type="text" style="text-align:right !important" class='money8' id='subtotal2<?php echo $i; ?>' value='<?php echo number_format($let['CRECUOMON'],2,'.','') ?>' disabled/></td>
                    </tr>
                    <?php $i++; $subtotal = $subtotal + floatval($let['CRECUOMON']);$IGV +=(floatval($let['CRECUOMON']) *(intval($igv)/100)) ;} ?>
                    <tr>
                      <td colspan="2"  style="text-align:right;color:#990000">TOTAL</td>
                      <td style="text-align:right;color:#990000"><?php echo $monto_real ?></td>
                      <td style="text-align:right;color:#990000" id='subtotal1'></td>
                      <td style="text-align:right;color:#990000" id='subtotal2'></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5 col-md-4">
              <a class="btn btn-danger btn-block" onclick=" window.close();"><i class="fa fa-ban" aria-hidden="true"></i>  CANCELAR</a>
            </div>
            <div class="col-sm-2 col-md-4">
            </div>
            <div class=" col-sm-5 col-md-4">
              <a class='btn btn-primary btn-block' onclick="generar_nota_credito()" id="btn_generar_nota_credito"> <i class="fa fa-spinner" aria-hidden="true"></i> GENERAR NOTA CRÉDITO</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal_calculadora" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" style="color:#f00">&times;</button>
            <div class="row">
              <div class="col-md-2">
                  <h4 class="modal-title text-info" style="font-family:'Ubuntu'">CALCULADORA</h4>
              </div>
              <div class="col-md-3"> RECIBO:
                  <span id='serie_numero1' style="font-family:'Ubuntu';font-size:16px;color:#296fb7"></span> -
                  <span id='serie_numero2' style="font-family:'Ubuntu';font-size:16px;color:#296fb7"></span>
              </div>
              <div class="col-md-3">
                <label class="radio-inline"><input type="radio" id='individual' name="calculadora" checked>CALCULADORA SIMPLE</label>
              </div>
              <div class="col-md-3">
                <label class="radio-inline"><input type="radio" id='multiple' name="calculadora">CALCULADORA MULTIPLE</label>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <?php if( $notas_credito ) { ?>
                <?php $fecha = Date('m'); ?>
                <?php if(substr($notas_credito[0]['NCAFECHA'],3,2) == $fecha && $notas_credito[0]['NCAFACESTA'] == 'I') {?>
                  <div class="callout callout-warning">
                    SE EDITARA LA NOTA DE CREDITO EXISTENTE <?php echo $notas_credito[0]['NCASERNRO'].' - '.$notas_credito[0]['NCANRO']; ?>
                  </div>
                <?php } else {?>
                  <div class="callout callout-success">
                    SE CREARA UNA NUEVA NOTA DE CRÉDITO
                  </div>
                <?php } ?>
            <?php } ?>
            <div class="box box-success" id="calculadora_simple" style="display:block">
              <div class="box-body">
                <h4 style="text-align:center;font-family:'Ubuntu';color:#990000">CALCULADORA INDIVIDUAL</h4>
                <table width="100%" style="background: antiquewhite;">
                  <tr>
                    <td style="width:30%" class="formato"> <label>LOCALIDAD:</label>  </td>
                    <td>
                      <select  id="localidades" onchange="reseleccionar_categoria()">
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato"><label>CATEGORIA:</label></td>
                    <td>
                      <select  id="categorias" onchange="traer_tarifas()">
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato"><label>TARIFA:</label> </td>
                    <td>
                      <select  id="tarifas" disabled onchange="cambio_tarifa()">
                        <option value="-1">Todas las Tarifas</option>
                      </select><strong> <span style="color:#296fb7">(1)</span></strong>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato">Ingrese Volúmen (consumo en m<sup>3</sup>)</td>
                    <td>
                      <input type="number" name="" value="" id='monto_calcular'>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato">Seleccionar Servicios</td>
                    <td>
                      <label class="radio-inline"><input type="radio" name="servicio1" id="agua1" value='1' checked>Agua y Alcantarillado</label>
                      <label class="radio-inline"><input type="radio" name="servicio1" id="agua2" value='2'>Sólo Agua</label>
                      <label class="radio-inline"><input type="radio" name="servicio1" id="agua3" value='3'>Sólo Alcantarillado</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato">Distribución de Rangos</td>
                    <td>
                      <label class="radio-inline"><input type="radio" name="rango1" value='1' id='distribucion' checked>Distribución Normal</label>
                      <label class="radio-inline"><input type="radio" name="rango1" value='2'>Todo a Primer Rango</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato">Estado de Conexión</td>
                    <td>
                      <label class="radio-inline"><input type="radio" name="conexion1" id='conexion' checked>Ignorar</label>
                      <label class="radio-inline"><input type="radio" name="conexion1">Considerar Activa</label>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td style="text-align:right"><a class="btn btn-success" style="margin: 0px 10px 10px 0px;" onclick="calcular_monto()"><i class="fa fa-calculator" aria-hidden="true"></i> CALCULAR</a></td>
                  </tr>
                  <!--<tr>
                    <td colspan="2" style="padding-top: 7px;" class='mensaje_resolucion'>
                    </td>
                  </tr>-->
                </table ><br>
                <h5 style="text-align:center;font-family:'Ubuntu';color:#990000">RESULTADOS DEL SISTEMA</h5>
                <table width="100%" style="border: 1px solid;background: aliceblue;">
                    <tr>
                      <td colspan="6" class="formato2" style="border: 1px solid">
                        <strong>Rangos Validos para la Tarifa Seleccionada : </strong><span id='rangos'></span>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="border: 1px solid"></td>
                      <td class="formato2" style="text-align:center;border: 1px solid;"><strong>Rango 1</strong></td>
                      <td class="formato2" style="text-align:center;border: 1px solid;"><strong>Rango 2</strong></td>
                      <td class="formato2" style="text-align:center;border: 1px solid;"><strong>Rango 3</strong></td>
                      <td class="formato2" style="text-align:center;border: 1px solid;"><strong>Sub Total</strong></td>
                    </tr>
                    <tr>
                      <td class="formato2" rowspan="3"  style="border: 1px solid"><strong>Estrucutura Tarifaria</strong></td>
                      <td class="formato2" style="border: 1px solid"><strong>Rangos de Consumo (en m<sup>3</sup>)</strong></td>
                      <td id='descripcion_rango1' style="text-align:center;border: 1px solid"></td>
                      <td id='descripcion_rango2' style="text-align:center;border: 1px solid"></td>
                      <td id='descripcion_rango3' style="text-align:center;border: 1px solid"></td>
                      <td style="text-align:center;border: 1px solid"></td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m<sup>3</sup> de Agua (S/. / m<sup>3</sup>)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='precioa_rango1'>0,0000</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='precioa_rango2'>0,0000</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='precioa_rango3'>0,0000</td>
                      <td style="text-align:right;border: 1px solid"></td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m <sup>3</sup> de Alcantarillado (S/. / m <sup>3</sup>)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='preciod_rango1'>0,0000</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='preciod_rango2'>0,0000</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='preciod_rango3'>0,0000</td>
                      <td class="formato2" style="text-align:right;border: 1px solid"></td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid" rowspan="3"><strong>Resultados del cálculo</strong></td>
                      <td class="formato2" style="border: 1px solid"><strong> Consumo Distribuido por Rango (m <sup>3</sup>)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_rango1'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_rango2'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_rango3'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_total'>0,00</td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid"><strong>Importe por Agua en cada rango (S/.)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='importea_rango1'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='importea_rango2'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='importea_rango3'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='importea_total'>0,00</td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid"><strong>Importe Alcantarillado en cada rango (S/.)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='imported_rango1'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='imported_rango2'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='imported_rango3'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='imported_total'>0,00</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="formato2" style="text-align:right;border: 1px solid"><strong>Cargo Fijo</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='cargo_fijo'>0,0000</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="formato2" style="text-align:right;border: 1px solid"><strong>I.G.V. ( 18% ) </strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='igv'><strong>0,00</strong></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="formato2" style="text-align:right;border: 1px solid"><strong>TOTAL</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='total'><strong>0,00</strong></td>
                    </tr>
                  </table>
              </div>
            </div>
            <div class="box box-success" id="calculadora_multiple" style="display:none">
              <div class="box-body">
                <h4 style="text-align:center;font-family:'Ubuntu';color:#990000">CALCULAR MÚLTIPLES</h4>
                <table width="100%" style="background: antiquewhite;">
                  <tr>
                    <td style="width:25%"></td>
                    <td class="formato" style="width:25%; text-align:center"><strong>Primera Categoria</strong></td>
                    <td class="formato" style="width:25%; text-align:center"><strong>Segunda Categoria</strong></td>
                    <td class="formato" style="width:25%; text-align:center"><strong>Tercera Categoria</strong></td>
                  </tr>
                  <tr>
                    <td class="formato" style="width:25%"> <label>LOCALIDAD</label>  </td>
                    <td  class="formato" style="width:25%">
                      <select  id="localidades1" onchange="reseleccionar_categoria1()">
                      </select>
                    </td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formato" style="width:25%"> <label>CATEGORIA</label>  </td>
                    <td class="formato">
                      <select  id="categorias1" onchange="traer_tarifas1(1)">
                      </select>
                    </td>
                    <td class="formato">
                      <select  id="categorias2" onchange="traer_tarifas1(2)">
                      </select>
                    </td>
                    <td class="formato">
                      <select  id="categorias3" onchange="traer_tarifas1(3)">
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato"><label>Tarifa</label> </td>
                    <td class="formato">
                      <select  id="tarifas1" onchange="activar_unidades(1)">
                        <option value="-1">Todas las tarifas</option>
                      </select>
                    </td>
                    <td class="formato">
                      <select  id="tarifas2" onchange="activar_unidades(2)">
                        <option value='-1'>Todas las tarifas</option>
                      </select>
                    </td>
                    <td class="formato">
                      <select  id="tarifas3" onchange="activar_unidades(3)">
                        <option value='-1'>Todas las tarifas</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato"><label>Ingrese Volúmen ( consumo en m <sup>3</sup>):</label></td>
                    <td class="formato"><input type="number" name="" value="" id='volumen_multiple'></td>
                    <td class="formato"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formato"><label>Ingrese Número Unidades Uso:</label></td>
                    <td class="formato"><input type="number" name="" value="" id='unidades1' disabled></td>
                    <td class="formato"><input type="number" name="" value="" id='unidades2' disabled></td>
                    <td class="formato"><input type="number" name="" value="" id='unidades3' disabled></td>
                  </tr>
                  <tr>
                    <td class="formato"><label>Seleccionar Servicios</label></td>
                    <td colspan="3" class="formato">
                      <label class="radio-inline"><input type="radio" id='magua1' name="servicio" checked>Agua y Alcantarillado</label>
                      <label class="radio-inline"><input type="radio" id='magua2' name="servicio">Sólo Agua</label>
                      <label class="radio-inline"><input type="radio" id='magua3' name="servicio">Sólo Alcantarillado</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato"><label>Distribución de Rangos</label></td>
                    <td colspan="3" class="formato">
                      <label class="radio-inline"><input type="radio" name="rango" id='distribucion_multiple' checked>Distribución Normal</label>
                      <label class="radio-inline"><input type="radio" name="rango">Todo a Primer Rango</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato"><label>Estado de Conexión</label></td>
                    <td colspan="3" class="formato">
                      <label class="radio-inline"><input type="radio" name="conexion" id='conexion_multiple' checked>Ignorar</label>
                      <label class="radio-inline"><input type="radio" name="conexion">Considerar Activa</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="formato"><label>m<sup>3</sup> por Unidad de Uso:</label></td>
                    <td class="formato" style="color:#900" id='porcentaje'>0,00</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right"><a class="btn btn-success" onclick="calcular_multiple()" style="margin:0px 10px 10px 0px"><i class="fa fa-calculator" aria-hidden="true"></i> CALCULAR</a></td>
                  </tr>
                  <!--<tr>
                    <td colspan="4" style="padding-top: 7px;" class="mensaje_resolucion">
                    </td>
                  </tr>-->
                </table>
                <h5 style="text-align:center;font-family:'Ubuntu';color:#990000">RESULTADOS DE LA SIMULACIÓN</h5>
              <!-- start fisrt table range 1 -->
                <table width="100%" id='unidad1' style="display:none;border: 1px solid;background: aliceblue;" >
                  <tr>
                    <td class="formato2" colspan="6" style="border: 1px solid #000;background:#008080;color:#fff">Rangos Validos para la Tarifa <span id='multiple_rango1'></span> Seleccionada : <span id='cantidad_rango1'> 3 </span></td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 1</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 2</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 3</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Sub Total</strong></td>
                  </tr>
                  <tr>
                    <td class="formato2" rowspan="3" style="border: 1px solid"><strong>Estructura Tarifaria</strong></td>
                    <td class="formato2" style="border: 1px solid;border: 1px solid"><strong>Rango de Consumo (en m<sup>3</sup>)</strong></td>
                    <td id='tabla1_rango1' style="text-align:center;border: 1px solid"></td>
                    <td id='tabla1_rango2' style="text-align:center;border: 1px solid"></td>
                    <td id='tabla1_rango3' style="text-align:center;border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m<sup>3</sup> de Agua (S/ ./ m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla1_precio_unitario1_agua' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla1_precio_unitario2_agua' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla1_precio_unitario3_agua' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" style="border: 1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m<sup>3</sup> de Alcantarillado (S/ ./ m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla1_precio_unitario1_desague' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla1_precio_unitario2_desague' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla1_precio_unitario3_desague' style="text-align:right;border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" rowspan="3" style="border: 1px solid"><strong>Resultado  del cálculo</strong></td>
                    <td class="formato2" style="border: 1px solid"><strong>Consumo Distribuido por Rango (m<sup>3</sup>)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb1_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb1_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb1_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_consumo_total'>0,00</td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Importe por Agua en cada rango (S/.)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_agua_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_agua_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_agua_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_agua_total'>0,00</td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Importe Alcantarillado en cada rango (S/.)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_desague_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_desague_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_desague_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_desague_total'>0,00</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:right;border: 1px solid"><strong>Cargo Fijo</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla1_cargo_fijo'>0,0000</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2"  style="text-align:right;border: 1px solid"><strong>I.G.V.</strong></td>
                    <td class="formato2"  style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla1_igv'><strong>0,0000</strong></td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2"  style="text-align:right;border: 1px solid"><strong>TOTAL</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla1_total'><strong>0,00</strong>/td>
                  </tr>
                </table><br>
              <!-- end first table -->
              <!-- start second table -->
                <table width="100%" id='unidad2' style="display:none;border: 1px solid; background: aliceblue;">
                  <tr>
                    <td colspan="6" style="border: 1px solid  #000;background:#4e92d6;color:#fff">Rangos Validos para la Tarifa <span id='tabla2_multiple_rango1'></span> Seleccionada : <span id='tabla2_antidad_rango1'> 2 </span></td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 1</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 2</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 3</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Sub Total</strong></td>
                  </tr>
                  <tr>
                    <td class="formato2" rowspan="3" style="border: 1px solid"><strong>Estructura Tarifaria</strong></td>
                    <td class="formato2" style="border: 1px solid"><strong>Rango de Consumo (en m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla2_rango1' style="text-align:center;border: 1px solid"></td>
                    <td class="formato2" id='tabla2_rango2' style="text-align:center;border: 1px solid"></td>
                    <td class="formato2" id='tabla2_rango3' style="text-align:center;border: 1px solid"></td>
                    <td style="border:1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m<sup>3</sup> de Agua (S/ ./ m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla2_precio_unitario1_agua' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla2_precio_unitario2_agua' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla2_precio_unitario3_agua' style="text-align:right;border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m<sup>3</sup> de Alcantarillado (S/ ./ m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla2_precio_unitario1_desague' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla2_precio_unitario2_desague' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla2_precio_unitario3_desague' style="text-align:right;border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" rowspan="3" style="border: 1px solid"><strong>Resultado  del cálculo</strong></td>
                    <td class="formato2" style="border: 1px solid"><strong>Consumo Distribuido por Rango (m<sup>3</sup>)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb2_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb2_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb2_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_consumo_total'>0,00</td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Importe por Agua en cada rango (S/.)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_agua_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_agua_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_agua_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_agua_total'>0,00</td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Importe Alcantarillado en cada rango (S/.)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_desague_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_desague_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_desague_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_desague_total'>0,00</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:right;border: 1px solid"><strong>Cargo Fijo</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla2_cargo_fijo'>0,0000</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:right;border: 1px solid"><strong>I.G.V.</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla2_igv'>0,0000</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:right;border: 1px solid"><strong>TOTAL</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla2_total'>0,00</td>
                  </tr>
                </table><br>
              <!-- end second table -->
              <!-- strat thard table -->
                <table width="100%" id='unidad3' style="display:none;border: 1px solid;background: aliceblue;">
                  <tr>
                    <td colspan="6" style="border: 1px solid #000;background:#dfffdf">Rangos Validos para la Tarifa <span id='tabla3_multiple_rango1'></span> Seleccionada : <span id='tabla3_antidad_rango1'>1</span></td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 1</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 2</strong></td>
                    <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 3</strong></td>
                    <td class="formato2"style="text-align:center;border: 1px solid"><strong>Sub Total</strong></td>
                  </tr>
                  <tr>
                    <td class="formato2" rowspan="3" style="border: 1px solid"><strong>Estructura Tarifaria</strong></td>
                    <td class="formato2" style="border: 1px solid"><strong>Rango de Consumo (en m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla3_rango1' style="text-align:center;border: 1px solid"></td>
                    <td class="formato2" id='tabla3_rango2' style="text-align:center;border: 1px solid"></td>
                    <td class="formato2" id='tabla3_rango3' style="text-align:center;border: 1px solid"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m<sup>3</sup> de Agua (S/ ./ m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla3_precio_unitario1_agua' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla3_precio_unitario2_agua' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla3_precio_unitario3_agua' style="text-align:right;border: 1px solid"></td>
                    <td  style="border: 1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Precio Unitario por m<sup>3</sup> de Alcantarillado (S/ ./ m<sup>3</sup>)</strong></td>
                    <td class="formato2" id='tabla3_precio_unitario1_desague' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla3_precio_unitario2_desague' style="text-align:right;border: 1px solid"></td>
                    <td class="formato2" id='tabla3_precio_unitario3_desague' style="text-align:right;border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                  </tr>
                  <tr>
                    <td class="formato2" rowspan="3" style="border: 1px solid"><strong>Resultado  del cálculo</strong></td>
                    <td class="formato2" style="border: 1px solid"><strong>Consumo Distribuido por Rango (m<sup>3</sup>)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb3_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb3_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb3_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_consumo_total'>0,00</td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Importe por Agua en cada rango (S/.)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_agua_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_agua_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_agua_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_agua_total'>0,00</td>
                  </tr>
                  <tr>
                    <td class="formato2" style="border: 1px solid"><strong>Importe Alcantarillado en cada rango (S/.)</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_desague_rango1'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_desague_rango2'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_desague_rango3'>0,00</td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_desague_total'>0,00</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:right;border: 1px solid"><strong>Cargo Fijo</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid" id='tabla3_cargo_fijo'>0,0000</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:right;border: 1px solid"><strong>I.G.V.</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla3_igv'>0,0000</td>
                  </tr>
                  <tr>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>
                    <td class="formato2" style="text-align:right;border: 1px solid"><strong>TOTAL</strong></td>
                    <td class="formato2" style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla3_total'>0,00</td>
                  </tr>
                </table><br>
                <!-- end second table -->
                <!-- strat table final -->
                  <table width="100%" id='tabla4' style="display:none;border: 1px solid;background: aliceblue;">
                    <tr>
                      <td colspan="6" style="text-align:center;border: 1px solid #000; background: #ffffc0;color:#990000">Tarifa Total Múltiple</td>
                    </tr>
                    <tr>
                      <td style="border: 1px solid"></td>
                      <td style="border: 1px solid"></td>
                      <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 1</strong></td>
                      <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 2</strong></td>
                      <td class="formato2" style="text-align:center;border: 1px solid"><strong>Rango 3</strong></td>
                      <td class="formato2" style="text-align:center;border: 1px solid"><strong>Sub Total</strong></td>
                    </tr>
                    <tr>
                      <td class="formato2" rowspan="3" style="border: 1px solid"><strong>Resultado  del cálculo</strong></td>
                      <td class="formato2" style="border: 1px solid"><strong>Consumo Distribuido por Rango (m<sup>3</sup>)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb4_rango1'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='consumo_tb4_rango2'>0,00</td>
                      <td class="formato2"style="text-align:right;border: 1px solid" id='consumo_tb4_rango3'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_consumo_total'>0,00</td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid"><strong>Importe por Agua en cada rango (S/.)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_agua_rango1'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_agua_rango2'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_agua_rango3'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_agua_total'>0,00</td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid"><strong>Importe Alcantarillado en cada rango (S/.)</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_desague_rango1'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_desague_rango2'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_desague_rango3'>0,00</td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_desague_total'>0,00</td>
                    </tr>
                    <tr>
                      <td class="formato2" style="border: 1px solid"></td>
                      <td class="formato2" style="border: 1px solid"></td>
                      <td class="formato2" style="border: 1px solid"></td>
                      <td class="formato2" style="border: 1px solid"></td>
                      <td class="formato2" style="text-align:right;border: 1px solid"><strong>Cargo Fijo</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid" id='tabla4_cargo_fijo'>0,0000</td>
                    </tr>
                    <tr>
                      <td style="border: 1px solid"></td>
                      <td style="border: 1px solid"></td>
                      <td style="border: 1px solid"></td>
                      <td style="border: 1px solid"></td>
                      <td class="formato2" style="text-align:right;border: 1px solid"><strong>I.G.V.</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla4_igv'>0,0000</td>
                    </tr>
                    <tr>
                      <td style="border: 1px solid"></td>
                      <td style="border: 1px solid"></td>
                      <td style="border: 1px solid"></td>
                      <td style="border: 1px solid"></td>
                      <td class="formato2" style="text-align:right;border: 1px solid"><strong>TOTAL</strong></td>
                      <td class="formato2" style="text-align:right;border: 1px solid;font-weight: bold;" id='tabla4_total'>0,00</td>
                    </tr>
                  </table>
                <!-- end table final -->
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-md-4 col-sm-4 col-sx-4">
                  <button type="button" class="btn btn-danger btn-block pull-left" onclick="limpiar_calculadora();limpiar_calculadora_individual()"  data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</button>
              </div>
              <div class="col-md-4 col-sm-4 col-sx-4"></div>
              <div class="col-md-4 col-sm-4 col-sx-4">
                <button type="button" class="btn btn-primary btn-block"  onclick="aceptar_calculo()"><i class="fa fa-check-square" aria-hidden="true"></i> ACEPTAR</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- End modal-->
  <!-- Modal para ver detalle de la Nota Crédito-->
    <div class="modal fade" id="modal_nota_credito" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-info" style="font-family:'Ubuntu'">DETALLE DE LA NOTA CRÉDITO <span id='serie_numero'></span> </h4>
          </div>
          <div class="modal-body">
            <div class="box box-info">
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
          <span id='ik' style="display:none"></span>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End modal-->
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
  <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
  <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
  <script src='<?php echo $this->config->item('ip')?>frontend/dist/js/jquery.number.min.js'></script>
  <script type="text/javascript">
    $('#notas_creditos').DataTable({bFilter: false, bInfo: false,bSort : false, bLengthChange : false});
    igvBase = <?php echo $igv; ?>;
    igvBase = (parseInt(igvBase)/100).toFixed(2)
    faclin = <?php echo json_encode($faclin); ?>;
    lectfac = <?php echo json_encode($letfac); ?>;
    $('input.money2').number( true, 2 )
    console.log(igvBase)
    guardar = function(){
        swal({   title: "¿Está seguro de generar la Nota Crédito?",   text: "La nota de Crédito se descontara del monto total del Documento",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#296fb7",   confirmButtonText: "¡Sí!, Estoy seguro",   closeOnConfirm: false }, function(){   swal("Nota de Crédito Creada", "", "success"); });
    }

    validar_monto2 =  function(monto,valor,event,text,indice){
      var val = valor.value;
      var val1  =  val.replace(new RegExp(',', 'g'), '')
      if((event.which >= 48 && event.which <= 57) || (event.which >= 95 && event.which <= 105)){
        if(monto<parseFloat(val1)){
          $("#error1"+indice).css("display","inline").fadeOut(2000);
          $("#"+valor.id).val("")
          //$( "#agua" ).val(parseFloat($( "#agua_recibo" ).text()).toFixed(2))
          $( "#"+text ).val("0.00")
        } else {
            $( "#"+text ).val((parseFloat(monto)-parseFloat(val1)).toFixed(2))
            total_conceptos = <?php echo sizeof($faclin); ?>;
            total_conceptos1 = <?php echo  sizeof($letfac); ?>;
            subtotal = 0;
            igv = 0
            for(var i = 0; i < total_conceptos;i++){
              if(faclin[i]['FACCONCOD'] == "201"){
                subtotal += (isNaN(parseFloat( $("#subtotal_agua").val() )) ? 0 : parseFloat( $( "#subtotal_agua").val() ));
                if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#subtotal_agua" ).val())) ? 0 : parseFloat($( "#subtotal_agua" ).val())) * igvBase
              } else if (faclin[i]['FACCONCOD'] == "301"){
                subtotal += (isNaN(parseFloat($( "#subtotal_desague" ).val())) ? 0 : parseFloat($( "#subtotal_desague" ).val()));
                if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#subtotal_desague" ).val())) ? 0 : parseFloat($( "#subtotal_desague" ).val())) * igvBase
              } else {
                subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
              }
            }
            for(var i = 0; i< total_conceptos1; i++){
              subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
              if(lectfac[i]['FACIGVCOB'] == 'S')  igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
            }
            $( "#subtotal1" ).html(subtotal.toFixed(2))
        }
      } else if(event.which == 40 || event.which == 38 || event.which == 37 || event.which == 39){

      } else {
        if(valor.value==""){
          if(valor.id == "subtotal_agua") $( "#"+text ).val(parseFloat($( "#monto_agua" ).text()).toFixed(2))
          else if (valor.id == "subtotal_desague") $( "#"+text ).val(parseFloat($( "#monto_desague" ).text()).toFixed(2))
          total_conceptos = <?php echo sizeof($faclin); ?>;
          total_conceptos1 = <?php echo  sizeof($letfac); ?>;
          subtotal = 0;
          igv = 0
          for(var i = 0; i < total_conceptos;i++){
            if(faclin[i]['FACCONCOD'] == "201"){
              subtotal += (isNaN(parseFloat( $("#subtotal_agua").val() )) ? 0 : parseFloat( $( "#subtotal_agua").val() ));
              if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#subtotal_agua" ).val())) ? 0 : parseFloat($( "#subtotal_agua" ).val())) * igvBase
            } else if (faclin[i]['FACCONCOD'] == "301"){
              subtotal += (isNaN(parseFloat($( "#subtotal_desague" ).val())) ? 0 : parseFloat($( "#subtotal_desague" ).val()));
              if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#subtotal_desague" ).val())) ? 0 : parseFloat($( "#subtotal_desague" ).val())) * igvBase
            } else {
              subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
              if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
            }
          }
          for(var i = 0; i< total_conceptos1; i++){
              subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
              if(lectfac[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
            }
          $( "#subtotal1" ).html(subtotal.toFixed(2))
            //$( "#igv1").html(igv.toFixed(2))
            //$( "#total1" ).html((subtotal + igv).toFixed(2))
        } else{
            if(valor.id == "subtotal_agua") $( "#monto_agua" ).val((parseFloat(monto)-parseFloat(val1)).toFixed(2))
            else if (valor.id == "subtotal_desague") $( "#monto_desague" ).val((parseFloat(monto)-parseFloat(val1)).toFixed(2))
            total_conceptos = <?php echo sizeof($faclin); ?>;
            total_conceptos1 = <?php echo  sizeof($letfac); ?>;
            subtotal = 0;
            igv = 0
            for(var i = 0; i < total_conceptos;i++){
              if(faclin[i]['FACCONCOD'] == "201"){
                subtotal += (isNaN(parseFloat( $("#subtotal_agua").val() )) ? 0 : parseFloat( $( "#subtotal_agua").val() ));
                if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#subtotal_agua" ).val())) ? 0 : parseFloat($( "#subtotal_agua" ).val())) * igvBase
              } else if (faclin[i]['FACCONCOD'] == "301"){
                subtotal += (isNaN(parseFloat($( "#subtotal_desague" ).val())) ? 0 : parseFloat($( "#subtotal_desague" ).val()));
                if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#subtotal_desague" ).val())) ? 0 : parseFloat($( "#subtotal_desague" ).val())) * igvBase
              } else {
                subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                if(faclin[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
              }
            }
            for(var i = 0; i< total_conceptos1; i++){
              subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
              if(lectfac[i]['FACIGVCOB'] == 'S') igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
            }
            $( "#subtotal1" ).html(subtotal.toFixed(2))
            //$( "#igv1").html(igv.toFixed(2))
            //$( "#total1" ).html((subtotal + igv).toFixed(2))
        }
      }
      var suma1 = 0;
      $(".money8").each(function (index) {
        if($(this).val() != ""){
          suma1 += parseFloat($(this).val())
        }
      })
      $("#subtotal2").html(suma1.toFixed(2))
    }
    //Función para validar montos que no sean mayores al observado. faclin

    validar_monto =  function( monto, valor, indice, event){
      val = valor.value;
      val1  =  val.replace(new RegExp(',', 'g'), '')
      if((event.which >= 48 && event.which <= 57) || (event.which >= 95 && event.which <= 105)){
        if(monto<parseFloat(val1)){
            $("#error1"+indice).css("display","inline").fadeOut(2000);
            $("#"+valor.id).val("")
            $( "#subtotal1"+indice ).val(parseFloat($( "#monto_fac1"+indice ).text()).toFixed(2))
            $( "#subtotal1"+indice ).val("0.00")
            console.log(parseFloat($( "#monto_fac1"+indice ).text()))
        } else {
            $( "#subtotal1"+indice ).val((parseFloat(monto)-parseFloat(val1)).toFixed(2))
            total_conceptos = <?php echo sizeof($faclin); ?>;
            total_conceptos1 = <?php echo  sizeof($letfac); ?>;
            subtotal = 0;
            igv = 0
            for(var i = 0; i < total_conceptos;i++){
                subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                if(faclin[i]['FACIGVCOB'] == 'S'){
                    igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                }
                console.log(igv.toFixed(2));
            }
            for(var i = 0; i< total_conceptos1; i++){
                subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                if(lectfac[i]['FACIGVCOB'] == 'S'){
                    igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                }
                console.log(igv.toFixed(2));
            }
            $( "#subtotal1" ).html(subtotal.toFixed(2))
            $( "#subtotal1" ).html(subtotal.toFixed(2))
            $( "#igv1" ).html(igv.toFixed(2))
            $( "#total1" ).html((subtotal + igv).toFixed(2))
        }
      } else if(event.which == 40 || event.which == 38 || event.which == 37 || event.which == 39){

      } else {
        if(valor.value==""){
            $( "#subtotal1"+indice ).val(parseFloat($( "#monto_fac1"+indice ).text()).toFixed(2))
            total_conceptos = <?php echo sizeof($faclin); ?>;
            total_conceptos1 = <?php echo  sizeof($letfac); ?>;
            subtotal = 0;
            igv = 0
            for(var i = 0; i < total_conceptos;i++){
                subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                if(faclin[i]['FACIGVCOB'] == 'S'){
                    igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                }
                console.log(igv.toFixed(2));
            }
            for(var i = 0; i< total_conceptos1; i++){
                subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                if(lectfac[i]['FACIGVCOB'] == 'S'){
                    igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                }
                console.log(igv.toFixed(2));
            }
            $( "#subtotal1" ).html(subtotal.toFixed(2))
            $( "#igv1").html(igv.toFixed(2))
            $( "#total1" ).html((subtotal + igv).toFixed(2))
        } else{
            $( "#subtotal1"+indice ).val((parseFloat(monto)-parseFloat(val1)).toFixed(2))
            total_conceptos = <?php echo sizeof($faclin); ?>;
            total_conceptos1 = <?php echo  sizeof($letfac); ?>;
            subtotal = 0;
            igv = 0
            for(var i = 0; i < total_conceptos;i++){
                subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                if(faclin[i]['FACIGVCOB'] == 'S'){
                    igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                }
                console.log(igv.toFixed(2));
            }
            for(var i = 0; i< total_conceptos1; i++){
                subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                if(lectfac[i]['FACIGVCOB'] == 'S'){
                    igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                }
                console.log(igv.toFixed(2));
            }
            $( "#subtotal1" ).html(subtotal.toFixed(2))
            $( "#igv1").html(igv.toFixed(2))
            $( "#total1" ).html((subtotal + igv).toFixed(2))
        }
      }

      suma = 0;
      suma1 = 0;
      $(".money2").each(function (index) {
        if($(this).val() != ""){
          suma += parseFloat($(this).val())
        }
      })

      $(".money8").each(function (index) {
        if($(this).val() != ""){
          suma1 += parseFloat($(this).val())
        }
      })

      $("#subtotal1").html(suma.toFixed(2))
      $("#subtotal2").html(suma1.toFixed(2))

    }
    //Función para valdiar montos que no sean mayores a los observador. letfac
    validar_monto1 = function(monto,valor,indice,event){
      val = valor.value;
      val1  =  val.replace(new RegExp(',', 'g'), '')
        if((event.which >= 48 && event.which <= 57)  || (event.which >= 95 && event.which <= 105)){
            if(monto<parseFloat(val1)){
                $("#error2"+indice).css("display","inline").fadeOut(2000);
                $("#"+valor.id).val("")
                $( "#subtotal2"+indice ).val(parseFloat($( "#monto_fac2"+indice ).text()).toFixed(2))
                $( "#subtotal2"+indice ).val("0.00")
                console.log(parseFloat($( "#monto_fac2"+indice ).text()))
            } else {
                $( "#subtotal2"+indice ).val((parseFloat(monto)-parseFloat(val1)).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1" ).html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            }
        } else if(event.which == 40 || event.which == 38 || event.which == 37 || event.which == 39){

        } else {
            if(valor.value==""){
                $( "#subtotal2"+indice ).val(parseFloat($( "#monto_fac2"+indice ).text()).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1").html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            } else{
                $( "#subtotal2"+indice ).val((parseFloat(monto)-parseFloat(val1)).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1").html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            }
        }
        suma = 0;
        suma1 = 0;
        $(".money2").each(function (index) {
          if($(this).val() != ""){
            suma += parseFloat($(this).val())
          }
        })

        $(".money8").each(function (index) {
          if($(this).val() != ""){
            suma1 += parseFloat($(this).val())
          }
        })

        $("#subtotal1").html(suma.toFixed(2))
        $("#subtotal2").html(suma1.toFixed(2))
    }
    // --> Función para imprimir la nota de credito
    function ver_notaCredito(suministro,serie,nro){
      console.log(suministro);
        var myWindow = window.open("<?php echo $this->config->item('ip') . 'cuenta_corriente/notaCredito/' ?>"+suministro+"/" + serie + "/"+nro, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
    }
    //--> función para ver detalle nota
    detalle_nota = function(suministro,serie,nro){
      $.ajax({
        type: 'POST',
        url: '<?php echo $this->config->item('ip').'cuenta_corriente/ver_detalle_nota?ajax=true'; ?>',
        data: ({
          'suministro' : suministro,
          'serie' : serie,
          'nro' : nro
        }),
        cache: false,
        dataType: 'text',
        success: function(data){
          resultado = JSON.parse(data);
          console.log(resultado);
          if(resultado.result ==  true){
            $("#serie_numero").html(resultado.nca.NCASERNRO+"-"+resultado.nca.NCANRO)
            $("#cuerpo_detalle").empty();
            cuerpo = "";
            for(var i = 0; i < resultado.nca1.length; i++){
              cuerpo += "<tr>"+
                        "<td>"+resultado.nca1[i]['CONCEP_FACCONCOD']+"</td>"+
                        "<td>"+resultado.nca1[i]['FACCONDES']+"</td>"+
                        "<td style='text-align:right'>"+parseFloat(resultado.nca1[i]['NCAFACPREC']).toFixed(2)+"</td>"+
                        "<td style='text-align:right'>"+parseFloat(resultado.nca1[i]['NCAPREDIF']).toFixed(2)+"</td>"+
                        "<td style='text-align:right'>"+parseFloat(resultado.nca1[i]['NCAPREOK']).toFixed(2)+"</td>"+
                        "</tr>"
            }
            for(var i = 0; i< resultado.nca2.length; i++){
              cuerpo += "<tr>"+
                        "<td>"+resultado.nca2[i]['CONCEP_FACCONCOD']+"</td>"+
                        "<td>"+resultado.nca2[i]['FACCONDES']+"</td>"+
                        "<td style='text-align:right'>"+parseFloat(resultado.nca2[i]['NCACRECUOM']).toFixed(2)+"</td>"+
                        "<td style='text-align:right'>"+parseFloat((resultado.nca2[i]['NCAMONDIF'] == null) ? 0 : resultado.nca2[i]['NCAMONDIF']).toFixed(2)+"</td>"+
                        "<td style='text-align:right'>"+parseFloat(resultado.nca2[i]['NCAMONOK']).toFixed(2)+"</td>"+
                        "</tr>"

            }
            $("#cuerpo_detalle").append(cuerpo);
            $("#modal_nota_credito").modal('show');

          } else {

          }
          //$("#serie_numero").html(resultado.nca);
        }, error: function(jqHXR,textSuccess,errorThrown){

        }
      })
    }
    //funcion para limpiar las tablas calculadora multiple
    let limpiar_calculadora = () => {
      // tabla 1
      $("#tabla1_rango1").text("");
      $("#tabla1_rango2").text("");
      $("#tabla1_rango3").text("");
      $("#tabla1_precio_unitario1_agua").text("0,000");
      $("#tabla1_precio_unitario2_agua").text("0,000");
      $("#tabla1_precio_unitario3_agua").text("0,000");
      $("#tabla1_precio_unitario1_desague").text("0,000");
      $("#tabla1_precio_unitario2_desague").text("0,000");
      $("#tabla1_precio_unitario3_desague").text("0,000");
      $("#consumo_tb1_rango1").text("0,000");
      $("#consumo_tb1_rango2").text("0,000");
      $("#consumo_tb1_rango3").text("0,000");
      $("#tabla1_consumo_total").text("0,000");
      $("#tabla1_agua_rango1").text("0,000");
      $("#tabla1_agua_rango2").text("0,000");
      $("#tabla1_agua_rango3").text("0,000");
      $("#tabla1_agua_total").text("0,000");
      $("#tabla1_desague_rango1").text("0,000");
      $("#tabla1_desague_rango2").text("0,000");
      $("#tabla1_desague_rango3").text("0,000");
      $("#tabla1_desague_total").text("0,000");
      $("#tabla1_desague_total").text("0,000");
      $("#tabla1_igv").text("0,000");
      $("#tabla1_total").text("0,000");
      //tabla2
      $("#tabla2_rango1").text("");
      $("#tabla2_rango2").text("");
      $("#tabla2_rango3").text("");
      $("#tabla2_precio_unitario1_agua").text("0,000");
      $("#tabla2_precio_unitario2_agua").text("0,000");
      $("#tabla2_precio_unitario3_agua").text("0,000");
      $("#tabla2_precio_unitario1_desague").text("0,000");
      $("#tabla2_precio_unitario2_desague").text("0,000");
      $("#tabla2_precio_unitario3_desague").text("0,000");
      $("#consumo_tb2_rango1").text("0,000");
      $("#consumo_tb2_rango2").text("0,000");
      $("#consumo_tb2_rango3").text("0,000");
      $("#tabla2_consumo_total").text("0,000");
      $("#tabla2_agua_rango1").text("0,000");
      $("#tabla2_agua_rango2").text("0,000");
      $("#tabla2_agua_rango3").text("0,000");
      $("#tabla2_agua_total").text("0,000");
      $("#tabla2_desague_rango1").text("0,000");
      $("#tabla2_desague_rango2").text("0,000");
      $("#tabla2_desague_rango3").text("0,000");
      $("#tabla2_desague_total").text("0,000");
      $("#tabla2_cargo_fijo").text("0,000");
      $("#tabla2_igv").text("0,000");
      $("#tabla2_total").text("0,000");
      //TABLA 3
      $("#tabla3_rango1").text("");
      $("#tabla3_rango2").text("");
      $("#tabla3_rango3").text("");
      $("#tabla3_precio_unitario1_agua").text("0,000");
      $("#tabla3_precio_unitario2_agua").text("0,000");
      $("#tabla3_precio_unitario3_agua").text("0,000");
      $("#tabla3_precio_unitario1_desague").text("0,000");
      $("#tabla3_precio_unitario2_desague").text("0,000");
      $("#tabla3_precio_unitario3_desague").text("0,000");
      $("#consumo_tb3_rango1").text("0,000");
      $("#consumo_tb3_rango2").text("0,000");
      $("#consumo_tb3_rango3").text("0,000");
      $("#tabla3_consumo_total").text("0,000");
      $("#tabla3_agua_rango1").text("0,000");
      $("#tabla3_agua_rango2").text("0,000");
      $("#tabla3_agua_rango3").text("0,000");
      $("#tabla3_agua_total").text("0,000");
      $("#tabla3_desague_rango1").text("0,000");
      $("#tabla3_desague_rango2").text("0,000");
      $("#tabla3_desague_rango3").text("0,000");
      $("#tabla3_desague_total").text("0,000");
      $("#tabla3_cargo_fijo").text("0,000");
      $("#tabla3_igv").text("0,000");
      $("#tabla3_total").text("0,000");
      //TABLA 4
      $("#consumo_tb4_rango1").text("0,000");
      $("#consumo_tb4_rango2").text("0,000");
      $("#consumo_tb4_rango3").text("0,000");
      $("#tabla4_consumo_total").text("0,000");
      $("#tabla4_agua_rango1").text("0,000");
      $("#tabla4_agua_rango2").text("0,000");
      $("#tabla4_agua_rango3").text("0,000");
      $("#tabla4_agua_total").text("0,000");
      $("#tabla4_desague_rango1").text("0,000");
      $("#tabla4_desague_rango2").text("0,000");
      $("#tabla4_desague_rango3").text("0,000");
      $("#tabla4_desague_total").text("0,000");
      $("#tabla4_cargo_fijo").text("0,000");
      $("#tabla4_igv").text("0,000");
      $("#tabla4_total").text("0,000");

      $("#multiple_rango1").text("");
      $("#multiple_rango2").text("");
      $("#multiple_rango3").text("");

      //cabecerqa
     $("#unidades1").val("");
     $("#unidades2").val("");
     $("#unidades3").val("");
     $("#volumen_multiple").val("");
     $("#unidades1").attr('disabled','disabled')
     $("#unidades2").attr('disabled','disabled')
     $("#unidades3").attr('disabled','disabled')

     var select = $('#localidades1');
     select.val($('option:first', select).val());
     var select = $('#categorias1');
     select.val($('option:first', select).val());
     var select = $('#categorias2');
     select.val($('option:first', select).val());
     var select = $('#categorias3');
     select.val($('option:first', select).val());


     $("#tarifas1").empty()
     $("#tarifas2").empty()
     $("#tarifas3").empty()
     $("#tarifas1").append("<option value='-1'>Seleccione una tarifa</option>")
     $("#tarifas2").append("<option value='-1'>Seleccione una tarifa</option>")
     $("#tarifas3").append("<option value='-1'>Seleccione una tarifa</option>")

     $("#magua1").prop('checked',true);
     $("#distribucion_multiple").prop('checked',true);
     $("#conexion_multiple").prop('checked',true);

     $("#porcentaje").text("0.00")

      $("#unidad1").fadeOut('slow')
      $("#unidad2").fadeOut('slow')
      $("#unidad3").fadeOut('slow')
      $("#tabla4").fadeOut('slow')

    }

    function limpiar_multiple(){
      $("#tb1_rango1").text("0,000");
      $("#consumo_tb1_rango2").text("0,000");
      $("#consumo_tb1_rango3").text("0,000");
      $("#tabla1_consumo_total").text("0,000");
      $("#tabla1_agua_rango1").text("0,000");
      $("#tabla1_agua_rango2").text("0,000");
      $("#tabla1_agua_rango3").text("0,000");
      $("#tabla1_agua_total").text("0,000");
      $("#tabla1_desague_rango1").text("0,000");
      $("#tabla1_desague_rango2").text("0,000");
      $("#tabla1_desague_rango3").text("0,000");
      $("#tabla1_desague_total").text("0,000");
      $("#tabla1_desague_total").text("0,000");
      $("#tabla1_igv").text("0,000");
      $("#tabla1_total").text("0,000");
      //tabla2
      $("#tabla2_rango1").text("");
      $("#tabla2_rango2").text("");
      $("#tabla2_rango3").text("");
      $("#tabla2_precio_unitario1_agua").text("0,000");
      $("#tabla2_precio_unitario2_agua").text("0,000");
      $("#tabla2_precio_unitario3_agua").text("0,000");
      $("#tabla2_precio_unitario1_desague").text("0,000");
      $("#tabla2_precio_unitario2_desague").text("0,000");
      $("#tabla2_precio_unitario3_desague").text("0,000");
      $("#consumo_tb2_rango1").text("0,000");
      $("#consumo_tb2_rango2").text("0,000");
      $("#consumo_tb2_rango3").text("0,000");
      $("#tabla2_consumo_total").text("0,000");
      $("#tabla2_agua_rango1").text("0,000");
      $("#tabla2_agua_rango2").text("0,000");
      $("#tabla2_agua_rango3").text("0,000");
      $("#tabla2_agua_total").text("0,000");
      $("#tabla2_desague_rango1").text("0,000");
      $("#tabla2_desague_rango2").text("0,000");
      $("#tabla2_desague_rango3").text("0,000");
      $("#tabla2_desague_total").text("0,000");
      $("#tabla2_cargo_fijo").text("0,000");
      $("#tabla2_igv").text("0,000");
      $("#tabla2_total").text("0,000");
      //TABLA 3
      $("#tabla3_rango1").text("");
      $("#tabla3_rango2").text("");
      $("#tabla3_rango3").text("");
      $("#tabla3_precio_unitario1_agua").text("0,000");
      $("#tabla3_precio_unitario2_agua").text("0,000");
      $("#tabla3_precio_unitario3_agua").text("0,000");
      $("#tabla3_precio_unitario1_desague").text("0,000");
      $("#tabla3_precio_unitario2_desague").text("0,000");
      $("#tabla3_precio_unitario3_desague").text("0,000");
      $("#consumo_tb3_rango1").text("0,000");
      $("#consumo_tb3_rango2").text("0,000");
      $("#consumo_tb3_rango3").text("0,000");
      $("#tabla3_consumo_total").text("0,000");
      $("#tabla3_agua_rango1").text("0,000");
      $("#tabla3_agua_rango2").text("0,000");
      $("#tabla3_agua_rango3").text("0,000");
      $("#tabla3_agua_total").text("0,000");
      $("#tabla3_desague_rango1").text("0,000");
      $("#tabla3_desague_rango2").text("0,000");
      $("#tabla3_desague_rango3").text("0,000");
      $("#tabla3_desague_total").text("0,000");
      $("#tabla3_cargo_fijo").text("0,000");
      $("#tabla3_igv").text("0,000");
      $("#tabla3_total").text("0,000");
      //TABLA 4
      $("#consumo_tb4_rango1").text("0,000");
      $("#consumo_tb4_rango2").text("0,000");
      $("#consumo_tb4_rango3").text("0,000");
      $("#tabla4_consumo_total").text("0,000");
      $("#tabla4_agua_rango1").text("0,000");
      $("#tabla4_agua_rango2").text("0,000");
      $("#tabla4_agua_rango3").text("0,000");
      $("#tabla4_agua_total").text("0,000");
      $("#tabla4_desague_rango1").text("0,000");
      $("#tabla4_desague_rango2").text("0,000");
      $("#tabla4_desague_rango3").text("0,000");
      $("#tabla4_desague_total").text("0,000");
      $("#tabla4_cargo_fijo").text("0,000");
      $("#tabla4_igv").text("0,000");
      $("#tabla4_total").text("0,000");

      $("#multiple_rango1").text("");
      $("#multiple_rango2").text("");
      $("#multiple_rango3").text("");
    }
    /// función para limpiar calculadora individula
    let limpiar_calculadora_individual = () => {
      $("#rangos").text("")
      var select = $('#localidades');
      select.val($('option:first', select).val());
      var select = $('#categorias');
      select.val($('option:first', select).val());

      $("#tarifas").empty();
      $("#tarifas").append("<option value='-1'>Seleccione una tarifa</option>")
      $("#monto_calcular").val("")

      $("#agua1").prop('checked',true);
      $("#distribucion").prop('checked',true);
      $("#conexion").prop('checked',true);

      $("#agua1").prop('disabled',false);
      $("#agua2").prop('disabled',false);
      $("#agua3").prop('disabled',false);

      //$("#rangos").text(ta['RANGOS']);
      $("#descripcion_rango1").text("");
      $("#descripcion_rango2").text("");
      $("#descripcion_rango3").text("");
      $("#consumo_rango1").text("0,00");
      $("#consumo_rango2").text("0,00");
      $("#consumo_rango3").text("0,00");
      $("#consumo_total").text('0,00')
      $("#importea_rango1").text("0,00");
      $("#importea_rango2").text("0,00");
      $("#importea_rango3").text("0,00");
      $("#precioa_rango1").text("0,00");
      $("#precioa_rango2").text("0,00");
      $("#precioa_rango3").text("0,00");
      $("#preciod_rango1").text("0,00");
      $("#preciod_rango2").text("0,00");
      $("#preciod_rango3").text("0,00");
      $("#imported_rango1").text("0,00");
      $("#imported_rango2").text("0,00");
      $("#imported_rango3").text("0,00");
      $("#importea_total").text("0,00")
      $("#imported_total").text("0,00")
      $("#cargo_fijo").text("0,00")
      $("#igv").text("0,00")
      $("#total").text("0,00")

    }

    reseleccionar_categoria =  function(){
      //$("#categorias option[value=-1]").attr("selected",true);
      $("#categorias").val($("#categorias").find('option:first').val())
      $("#tarifas").empty();
      $("#tarifas").append("<option value='-1'>Seleccione una tarifa</option>")
      //$('#categorias').find('option:first').attr('selected', 'selected').parent('select');
    }

    reseleccionar_categoria1 =  function(){
      //$("#categorias option[value=-1]").attr("selected",true);
      $("#categorias1").val($("#categorias1").find('option:first').val())
      $("#categorias2").val($("#categorias2").find('option:first').val())
      $("#categorias3").val($("#categorias3").find('option:first').val())
      $("#tarifas1").empty();
      $("#tarifas2").empty();
      $("#tarifas3").empty();
      $("#tarifas1").append("<option value='-1'>Seleccione una tarifa</option>")
      $("#tarifas2").append("<option value='-1'>Seleccione una tarifa</option>")
      $("#tarifas3").append("<option value='-1'>Seleccione una tarifa</option>")
      //$('#categorias').find('option:first').attr('selected', 'selected').parent('select');
    }
// Funcion calculadora multiplw
    var servidor = "<?php echo $this->config->item('ip'); ?>";
    activar_unidades = function(valor){
     opcion =   $("#tarifas"+valor).val();
     if(opcion != -1){
       $("#unidades"+valor).prop('disabled',false);
     } else {
       $("#unidades"+valor).prop('disabled',true);
     }
     tarifa = $( "#tarifas1" ).val();
     if(tarifa != -1){
       for(var i = 0;  i < tarifas1.length; i++){
         if(tarifas1[i]['TARIFA'] == tarifa){;
           if(tarifas1[i]['IMPPRIRAN'] != 0 && tarifas1[i]['DIMPPRIRAN'] != 0){
             $("#magua1").prop('disabled',false);
             $("#magua2").prop('disabled',false);
             $("#magua3").prop('disabled',false);
             $("#magua1").prop('checked',true);
           } else if(tarifas1[i]['IMPPRIRAN'] == 0 && tarifas1[i]['DIMPPRIRAN'] != 0){
             $("#magua1").prop('disabled',true);
             $("#magua2").prop('disabled',true);
             $("#magua3").prop( "checked" ,true)
             $("#magua3").prop('disabled',true);
           } else {
             $("#magua1").prop('disabled',true);
             $("#magua2").prop('disabled',true);
             $("#magua2").prop( "checked",true )
             $("#magua3").prop('disabled',true);
           }
           break;
         }
       }
     } else {
       swal("", "Debe seleccionar una tarifa", "warning")
     }
    }

    calcular_monto =  function(){
      cantidad = $("#monto_calcular").val();
      TAR = $("#tarifas").val();
      if(cantidad != "" && TAR != -1){
        tarifa_recibo = $("#tarifa_recibo").val();
        if(tarifa_recibo == TAR){
          cantidad = parseFloat(cantidad);
          seleccionado = $("input[name='servicio1']:checked").val();
          seleccionado1 = $("input[name='rango1']:checked").val();
          tarifa = $( "#tarifas" ).val();
          ta = "";
          for(var i = 0;  i <tarifas.length; i++){
            if(tarifas[i]['TARIFA'] == tarifa){
              ta = tarifas[i];
              break;
            }
          }
          $("#rangos").text(ta['RANGOS']);
          $("#descripcion_rango1").text("");
          $("#descripcion_rango2").text("");
          $("#descripcion_rango3").text("");
          $("#consumo_rango1").text("0,00");
          $("#consumo_rango2").text("0,00");
          $("#consumo_rango3").text("0,00");
          $("#consumo_total").text(cantidad.toFixed(2))
          $("#importea_rango1").text("0,00");
          $("#importea_rango2").text("0,00");
          $("#importea_rango3").text("0,00");
          $("#imported_rango1").text("0,00");
          $("#imported_rango2").text("0,00");
          $("#imported_rango3").text("0,00");
          $("#importea_total").text("0,00")
          $("#imported_total").text("0,00")

          if(seleccionado1 == 1){
            if(ta['VOLPRIRAN'] != 0){
              if(ta['VOLPRIRAN'] != '9999999999'){
                $("#descripcion_rango1").text("de 0 a "+ta['VOLPRIRAN']);
                if(cantidad > parseInt(ta['VOLPRIRAN'])){
                  $("#consumo_rango1").text(parseFloat(ta['VOLPRIRAN']).toFixed(2))
                  cantidad = cantidad - parseInt(ta['VOLPRIRAN']);
                } else {
                  $("#consumo_rango1").text(parseFloat(cantidad).toFixed(2))
                  cantidad = cantidad - parseInt(ta['VOLPRIRAN']);
                }
              } else {
                $("#descripcion_rango1").text("de 0 a más");
                $("#consumo_rango1").text(parseFloat(cantidad).toFixed(2))
              }
            }
            if(ta['VOLSEGRAN'] != 0){ //segundo rango
              if(ta['VOLSEGRAN'] != '9999999999'){
                $("#descripcion_rango2").text("de "+ (parseInt(ta['VOLPRIRAN']) + 1)+" a "+ta['VOLSEGRAN'])
                valor_opcional = parseInt(ta['VOLSEGRAN']) - parseInt(ta['VOLPRIRAN'])
                if(cantidad > valor_opcional){
                  $("#consumo_rango2").text(parseFloat(valor_opcional).toFixed(2))
                  cantidad = cantidad - parseInt(valor_opcional);
                } else if(cantidad > 0) {
                  $("#consumo_rango2").text(parseFloat(cantidad).toFixed(2))
                  cantidad = cantidad - parseInt(valor_opcional);
                }
              } else {
                  $("#descripcion_rango2").text("de "+(parseInt(ta['VOLPRIRAN'])+1)+" a más")
                  if(cantidad > 0){
                  $("#consumo_rango2").text(parseFloat(cantidad).toFixed(2))
                }
              }
            }
            if(ta['VOLTERRAN'] != 0){//tercer rango
              if(ta['VOLTERRAN'] != '9999999999'){
                $("#descripcion_rango3").text("de "+(parseInt(ta['VOLSEGRAN']) + 1)+" a "+ta['VOLTERRAN'])
                valor_opcional = parseInt(ta['VOLTERRAN']) - parseInt(ta['VOLSEGRAN'])
                if(cantidad > valor_opcional){
                  $("#consumo_rango3").text(parseFloat(valor_opcional).toFixed(2))
                  cantidad = cantidad - parseInt(valor_opcional);
                } else if(cantidad > 0){
                  $("#consumo_rango3").text(parseFloat(cantidad).toFixed(2))
                }
              } else{
                $("#descripcion_rango3").text("de "+(parseInt(ta['VOLSEGRAN']) + 1)+" a más")
                if(cantidad > 0 ){
                  $("#consumo_rango3").text(parseFloat(cantidad).toFixed(2))
                }
              }
            }
          } else {
            $("#descripcion_rango1").text("de 0 a más");
            $("#consumo_rango1").text(cantidad.toFixed(2))
          }
          $("#precioa_rango1").text(parseFloat(ta['IMPPRIRAN']).toFixed(4))
          $("#preciod_rango1").text(parseFloat(ta['DIMPPRIRAN']).toFixed(4))
          $("#precioa_rango2").text(parseFloat(ta['IMPSEGRAN']).toFixed(4))
          $("#preciod_rango2").text(parseFloat(ta['DIMPSEGRAN']).toFixed(4))
          $("#precioa_rango3").text(parseFloat(ta['IMPTERRAN']).toFixed(4))
          $("#preciod_rango3").text(parseFloat(ta['DIMPTERRAN']).toFixed(4))
          if(seleccionado1 == 1){
            if(seleccionado == 1 || seleccionado == 2){
              agua_rango1 = parseFloat($("#precioa_rango1").text()) * (parseFloat($("#consumo_rango1").text()));
              agua_rango2 = parseFloat($("#precioa_rango2").text()) * (parseFloat($("#consumo_rango2").text()));
              agua_rango3 = parseFloat($("#precioa_rango3").text()) * (parseFloat($("#consumo_rango3").text()));
              $("#importea_rango1").text(agua_rango1.toFixed(2))
              $("#importea_rango2").text(agua_rango2.toFixed(2))
              $("#importea_rango3").text(agua_rango3.toFixed(2))
              $("#importea_total").text((agua_rango3 + agua_rango2 + agua_rango1).toFixed(2))
            }
            if(seleccionado == 1 || seleccionado == 3){
              deagua_rango1 = parseFloat($("#preciod_rango1").text()) * (parseFloat($("#consumo_rango1").text()));
              deagua_rango2 = parseFloat($("#preciod_rango2").text()) * (parseFloat($("#consumo_rango2").text()));
              deagua_rango3 = parseFloat($("#preciod_rango3").text()) * (parseFloat($("#consumo_rango3").text()));
              $("#imported_rango1").text(deagua_rango1.toFixed(2))
              $("#imported_rango2").text(deagua_rango2.toFixed(2))
              $("#imported_rango3").text(deagua_rango3.toFixed(2))
              $("#imported_total").text((deagua_rango1 + deagua_rango2 + deagua_rango3).toFixed(2))
            }
          } else {
              if(seleccionado == 1 || seleccionado == 2){
                  agua_rango1 = parseFloat($("#precioa_rango1").text()) * (parseFloat($("#consumo_rango1").text()));
                  $("#importea_rango1").text(agua_rango1.toFixed(2))
                  $("#importea_total").text((agua_rango1).toFixed(2))
              }
              if(seleccionado == 1 || seleccionado == 3){
                deagua_rango1 = parseFloat($("#preciod_rango1").text()) * (parseFloat($("#consumo_rango1").text()));
                $("#imported_rango1").text(deagua_rango1.toFixed(2))
                $("#imported_total").text((deagua_rango1).toFixed(2))
              }
          }
          $("#cargo_fijo").text(parseFloat(ta['NCARGOFIJO']).toFixed(4))
          total = parseFloat(ta['NCARGOFIJO'])+parseFloat($("#imported_total").text())+parseFloat($("#importea_total").text())
          //total = total*parseFloat()
          $("#igv").text((total*parseFloat(ta['ETIGV'])).toFixed(2));
          igv =  (total*parseFloat(ta['ETIGV'])).toFixed(2);
          total = total + parseFloat(igv)
          $("#total").text(total.toFixed(2))
        } else {
          swal("","La tarifa debe de ser igual a la del recibo","warning")
        }

      } else {
        if(cantidad == ''){
          swal("", "Debe ingresar un volumen, para realizar el cálculo", "warning")
        } else {
          swal("", "Debe seleccionar una tarifa", "warning")
        }
      }
  }

    calcular_multiple = function(){
      limpiar_multiple();
      cantidad = $("#volumen_multiple").val();
      TAR = $("#tarifas1").val();
      TAR1 = $("#tarifas2").val();
      TAR2 = $("#tarifas3").val();
      unidades1 = $("#unidades1").val();
      unidades2 = $("#unidades2").val();
      unidades3 = $("#unidades3").val();
      console.log(cantidad);
      console.log(TAR);
      if(cantidad != "" && (TAR != -1 || TAR1 != -1 || TAR2 != -1) && (unidades1 != "" || unidades2 != "" || unidades3 != "")){
        cantidad = parseFloat(cantidad);
        seleccionado = $("input[name='servicio1']:checked").val();
        seleccionado1 = $("#distribucion_multiple").is(':checked');
        tarifa = $( "#tarifas1" ).val();
        tarifa2 = $( "#tarifas2" ).val();
        tarifa3 = $( "#tarifas3" ).val();
        ta = "";
        ta1 = "";
        ta2 = "";
        if(tarifa != -1){
          for(var i = 0;  i <tarifas1.length; i++){
            if(tarifas1[i]['TARIFA'] == tarifa){
              ta = tarifas1[i];
              break;
            }
          }
        }
        if(tarifa2 != -1){
          for(var i = 0;  i <tarifas2.length; i++){
            if(tarifas2[i]['TARIFA'] == tarifa2){
              ta2 = tarifas2[i];
              break;
            }
          }
        }

        if(tarifa3 != -1){
          for(var i = 0;  i <tarifas3.length; i++){
            if(tarifas3[i]['TARIFA'] == tarifa3){
              ta3 = tarifas3[i];
              break;
            }
          }
        }
        total = 0;
        if(unidades1 != ""){
          total += parseFloat(unidades1);
          $("#unidad1").fadeIn("slow");
        } else {
          $("#unidad1").fadeOut("slow");
        }
        if(unidades2 != ""){
          total += parseFloat(unidades2);
          $("#unidad2").fadeIn("slow");
        } else {
          $("#unidad2").fadeOut("slow");
        }
        if(unidades3 != ""){
          total +=  parseFloat(unidades3);
          $("#unidad3").fadeIn("slow");
        } else {
          $("#unidad3").fadeOut("slow");
        }
        //total = parseInt(unidades1)+parseInt(unidades2)+parseInt(unidades3);
        porcentaje =  (cantidad/parseFloat(total)).toFixed(2);
        porcentaje1 =  (cantidad/parseFloat(total)).toFixed(2);
        porcentaje2 =  (cantidad/parseFloat(total)).toFixed(2);
        $("#porcentaje").text(porcentaje);
        if(unidades1 != ""){
          $("#multiple_rango1").text($("#tarifas1").val())
          $("#tabla1_consumo_total").text(parseFloat(porcentaje).toFixed(2))
          if(seleccionado1 == 1){
            if(ta['VOLPRIRAN'] != 0){
              if(ta['VOLPRIRAN'] != '9999999999'){
                $("#tabla1_rango1").text("de 0 a "+ta['VOLPRIRAN']);
                if(porcentaje > parseInt(ta['VOLPRIRAN'])){
                  $("#consumo_tb1_rango1").text(parseFloat(ta['VOLPRIRAN']).toFixed(2))
                  porcentaje = porcentaje - parseInt(ta['VOLPRIRAN']);
                } else {
                  $("#consumo_tb1_rango1").text(parseFloat(porcentaje).toFixed(2))
                  porcentaje = porcentaje - parseInt(ta['VOLPRIRAN']);
                }
              } else {
                $("#tabla1_rango1").text("de 0 a más");
                $("#consumo_tb1_rango1").text(parseFloat(porcentaje).toFixed(2))
              }
            }
            if(ta['VOLSEGRAN'] != 0){ //segundo rango
              if(ta['VOLSEGRAN'] != '9999999999'){
                $("#tabla1_rango2").text("de "+ (parseInt(ta['VOLPRIRAN']) + 1)+" a "+ta['VOLSEGRAN'])
                valor_opcional = parseInt(ta['VOLSEGRAN']) - parseInt(ta['VOLPRIRAN'])
                if(porcentaje > valor_opcional){
                  $("#consumo_tb1_rango2").text(parseFloat(valor_opcional).toFixed(2))
                  porcentaje = porcentaje - parseInt(valor_opcional);
                } else if(porcentaje > 0) {
                  $("#consumo_tb1_rango2").text(parseFloat(porcentaje).toFixed(2))
                  porcentaje = porcentaje - parseInt(valor_opcional);
                }
              } else {
                  $("#tabla1_rango2").text("de "+(parseInt(ta['VOLPRIRAN'])+1)+" a más")
                  if(porcentaje > 0){
                    $("#consumo_tb1_rango2").text(parseFloat(porcentaje).toFixed(2))
                  }
              }
            }
            if(ta['VOLTERRAN'] != 0){//tercer rango
              if(ta['VOLTERRAN'] != '9999999999'){
                $("#tabla1_rango3").text("de "+(parseInt(ta['VOLSEGRAN']) + 1)+" a "+ta['VOLTERRAN'])
                valor_opcional = parseInt(ta['VOLTERRAN']) - parseInt(ta['VOLSEGRAN']) 
                if(porcentaje > valor_opcional){
                  $("#consumo_tb1_rango3").text(parseFloat(valor_opcional).toFixed(2))
                  porcentaje = porcentaje - parseInt(valor_opcional);
                } else if(porcentaje > 0){
                  $("#consumo_tb1_rango3").text(parseFloat(porcentaje).toFixed(2))
                }
              } else{
                $("#tabla1_rango3").text("de "+(parseInt(ta['VOLSEGRAN']) + 1)+" a más")
                if(porcentaje > 0 ){
                  $("#consumo_tb1_rango3").text(parseFloat(porcentaje).toFixed(2))
                }
              }
            }
          } else {
            $("#tabla1_rango1").text("de 0 a más");
            $("#consumo_tb1_rango1").text(parseFloat(porcentaje).toFixed(2))
          }
          $("#tabla1_precio_unitario1_agua").text(parseFloat(ta['IMPPRIRAN']).toFixed(4))
          $("#tabla1_precio_unitario1_desague").text(parseFloat(ta['DIMPPRIRAN']).toFixed(4))

          $("#tabla1_precio_unitario2_agua").text(parseFloat(ta['IMPSEGRAN']).toFixed(4))
          $("#tabla1_precio_unitario2_desague").text(parseFloat(ta['DIMPSEGRAN']).toFixed(4))

          $("#tabla1_precio_unitario3_agua").text(parseFloat(ta['IMPTERRAN']).toFixed(4))
          $("#tabla1_precio_unitario3_desague").text(parseFloat(ta['DIMPTERRAN']).toFixed(4))

          if(seleccionado1 == 1){
            if(seleccionado == 1 || seleccionado == 2){
              agua_rango1 = parseFloat($("#tabla1_precio_unitario1_agua").text()) * (parseFloat($("#consumo_tb1_rango1").text()));
              agua_rango2 = parseFloat($("#tabla1_precio_unitario2_agua").text()) * (parseFloat($("#consumo_tb1_rango2").text()));
              agua_rango3 = parseFloat($("#tabla1_precio_unitario3_agua").text()) * (parseFloat($("#consumo_tb1_rango3").text()));
              $("#tabla1_agua_rango1").text(agua_rango1.toFixed(2))
              $("#tabla1_agua_rango2").text(agua_rango2.toFixed(2))
              $("#tabla1_agua_rango3").text(agua_rango3.toFixed(2))
              $("#tabla1_agua_total").text((agua_rango3 + agua_rango2 + agua_rango1).toFixed(2))
            }
            if(seleccionado == 1 || seleccionado == 3){
              deagua_rango1 = parseFloat($("#tabla1_precio_unitario1_desague").text()) * (parseFloat($("#consumo_tb1_rango1").text()));
              deagua_rango2 = parseFloat($("#tabla1_precio_unitario2_desague").text()) * (parseFloat($("#consumo_tb1_rango2").text()));
              deagua_rango3 = parseFloat($("#tabla1_precio_unitario3_desague").text()) * (parseFloat($("#consumo_tb1_rango3").text()));
              $("#tabla1_desague_rango1").text(deagua_rango1.toFixed(2))
              $("#tabla1_desague_rango2").text(deagua_rango2.toFixed(2))
              $("#tabla1_desague_rango3").text(deagua_rango3.toFixed(2))
              $("#tabla1_desague_total").text((deagua_rango1 + deagua_rango2 + deagua_rango3).toFixed(2))
            }
          } else {
              if(seleccionado == 1 || seleccionado == 2){
                  agua_rango1 = parseFloat($("#tabla1_precio_unitario1_agua").text()) * (parseFloat($("#consumo_tb1_rango1").text()));
                  $("#tabla1_agua_rango1").text(agua_rango1.toFixed(2))
                  $("#tabla1_agua_total").text((agua_rango1).toFixed(2))
              }
              if(seleccionado == 1 || seleccionado == 3){
                deagua_rango1 = parseFloat($("#tabla1_precio_unitario1_desague").text()) * (parseFloat($("#consumo_tb1_rango1").text()));
                $("#tabla1_desague_rango1").text(deagua_rango1.toFixed(2))
                $("#tabla1_desague_total").text((deagua_rango1).toFixed(2))
              }
          }
          $("#tabla1_cargo_fijo").text(parseFloat(ta['NCARGOFIJO']).toFixed(4))
          total = parseFloat(ta['NCARGOFIJO'])+parseFloat($("#tabla1_desague_total").text())+parseFloat($("#tabla1_agua_total").text())
          //total = total*parseFloat()
          $("#tabla1_igv").text((total*parseFloat(ta['ETIGV'])).toFixed(2));
          igv =  (total*parseFloat(ta['ETIGV'])).toFixed(2);
          total = total + parseFloat(igv)
          $("#tabla1_total").text(total.toFixed(2))

        }
        if(unidades2 != ""){
          console.log(ta2);
          $("#multiple_rango2").text($("#tarifas2").val())
          $("#tabla2_consumo_total").text(parseFloat(porcentaje1).toFixed(2))
          if(seleccionado1 == 1){
            if(ta2['VOLPRIRAN'] != 0){
              if(ta2['VOLPRIRAN'] != '9999999999'){
                $("#tabla2_rango1").text("de 0 a "+ta2['VOLPRIRAN']);
                if(porcentaje1 > parseInt(ta2['VOLPRIRAN'])){
                  $("#consumo_tb2_rango1").text(parseFloat(ta2['VOLPRIRAN']).toFixed(2))
                  porcentaje1 = porcentaje1 - parseInt(ta2['VOLPRIRAN']);
                  //cantidad = cantidad - parseInt(ta['VOLPRIRAN']);
                } else {
                  $("#consumo_tb2_rango1").text(parseFloat(porcentaje1).toFixed(2))
                  porcentaje1 = porcentaje1 - parseInt(ta2['VOLPRIRAN']);
                }
              } else {
                $("#tabla2_rango1").text("de 0 a más");
                $("#consumo_tb2_rango1").text(parseFloat(porcentaje1).toFixed(2))
              }
            }
            if(ta2['VOLSEGRAN'] != 0){ //segundo rango
              if(ta2['VOLSEGRAN'] != '9999999999'){
                $("#tabla2_rango2").text("de "+ (parseInt(ta2['VOLPRIRAN']) + 1)+" a "+ta2['VOLSEGRAN'])
                valor_opcional = parseInt(ta2['VOLSEGRAN']) - parseInt(ta2['VOLPRIRAN'])
                if(porcentaje1 > valor_opcional){
                  $("#consumo_tb2_rango2").text(parseFloat(valor_opcional).toFixed(2))
                  porcentaje1 = porcentaje1 - parseInt(valor_opcional);
                } else if(porcentaje1 > 0) {
                  $("#consumo_tb2_rango2").text(parseFloat(porcentaje1).toFixed(2))
                  porcentaje1 = porcentaje1 - parseInt(valor_opcional);
                }
                console.log(porcentaje1);
              } else {
                  $("#tabla2_rango2").text("de "+(parseInt(ta2['VOLPRIRAN'])+1)+" a más")
                  if(porcentaje1 > 0){
                    $("#consumo_tb2_rango2").text(parseFloat(porcentaje1).toFixed(2))
                  }
              }
            }
            if(ta2['VOLTERRAN'] != 0){//tercer rango
              if(ta2['VOLTERRAN'] != '9999999999'){
                $("#tabla2_rango3").text("de "+(parseInt(ta2['VOLSEGRAN']) + 1)+" a "+ta2['VOLTERRAN'])
                valor_opcional = parseInt(ta2['VOLTERRAN']) - parseInt(ta2['VOLSEGRAN']) 
                if(porcentaje1 > valor_opcional){
                  $("#consumo_tb2_rango3").text(parseFloat(valor_opcional).toFixed(2))
                  porcentaje1 = porcentaje1 - parseInt(valor_opcional);
                } else if(porcentaje1 > 0){
                  $("#consumo_tb2_rango3").text(parseFloat(porcentaje1).toFixed(2))
                }
              } else{
                console.log(porcentaje1);
                $("#tabla2_rango3").text("de "+(parseInt(ta2['VOLSEGRAN']) + 1)+" a más")
                if(porcentaje1 > 0 ){
                  $("#consumo_tb2_rango3").text(parseFloat(porcentaje1).toFixed(2))
                }
              }
            }
          } else {
            $("#tabla2_rango1").text("de 0 a más");
            $("#consumo_tb2_rango1").text(parseFloat(porcentaje1).toFixed(2))
          }
          $("#tabla2_precio_unitario1_agua").text(parseFloat(ta2['IMPPRIRAN']).toFixed(4))
          $("#tabla2_precio_unitario1_desague").text(parseFloat(ta2['DIMPPRIRAN']).toFixed(4))

          $("#tabla2_precio_unitario2_agua").text(parseFloat(ta2['IMPSEGRAN']).toFixed(4))
          $("#tabla2_precio_unitario2_desague").text(parseFloat(ta2['DIMPSEGRAN']).toFixed(4))

          $("#tabla2_precio_unitario3_agua").text(parseFloat(ta2['IMPTERRAN']).toFixed(4))
          $("#tabla2_precio_unitario3_desague").text(parseFloat(ta2['DIMPTERRAN']).toFixed(4))

          if(seleccionado1 == 1){
            if(seleccionado == 1 || seleccionado == 2){
              agua_rango1 = parseFloat($("#tabla2_precio_unitario1_agua").text()) * (parseFloat($("#consumo_tb2_rango1").text()));
              agua_rango2 = parseFloat($("#tabla2_precio_unitario2_agua").text()) * (parseFloat($("#consumo_tb2_rango2").text()));
              agua_rango3 = parseFloat($("#tabla2_precio_unitario3_agua").text()) * (parseFloat($("#consumo_tb2_rango3").text()));
              $("#tabla2_agua_rango1").text(agua_rango1.toFixed(2))
              $("#tabla2_agua_rango2").text(agua_rango2.toFixed(2))
              $("#tabla2_agua_rango3").text(agua_rango3.toFixed(2))
              $("#tabla2_agua_total").text((agua_rango3 + agua_rango2 + agua_rango1).toFixed(2))
            }
            if(seleccionado == 1 || seleccionado == 3){
              deagua_rango1 = parseFloat($("#tabla2_precio_unitario1_desague").text()) * (parseFloat($("#consumo_tb2_rango1").text()));
              deagua_rango2 = parseFloat($("#tabla2_precio_unitario2_desague").text()) * (parseFloat($("#consumo_tb2_rango2").text()));
              deagua_rango3 = parseFloat($("#tabla2_precio_unitario3_desague").text()) * (parseFloat($("#consumo_tb2_rango3").text()));
              $("#tabla2_desague_rango1").text(deagua_rango1.toFixed(2))
              $("#tabla2_desague_rango2").text(deagua_rango2.toFixed(2))
              $("#tabla2_desague_rango3").text(deagua_rango3.toFixed(2))
              $("#tabla2_desague_total").text((deagua_rango1 + deagua_rango2 + deagua_rango3).toFixed(2))
            }
          } else {
              if(seleccionado == 1 || seleccionado == 2){
                  agua_rango1 = parseFloat($("#tabla2_precio_unitario1_agua").text()) * (parseFloat($("#consumo_tb2_rango1").text()));
                  $("#tabla2_agua_rango1").text(agua_rango1.toFixed(2))
                  $("#tabla2_agua_total").text((agua_rango1).toFixed(2))
              }
              if(seleccionado == 1 || seleccionado == 3){
                deagua_rango1 = parseFloat($("#tabla2_precio_unitario1_desague").text()) * (parseFloat($("#consumo_tb2_rango1").text()));
                $("#tabla2_desague_rango1").text(deagua_rango1.toFixed(2))
                $("#tabla2_desague_total").text((deagua_rango1).toFixed(2))
              }
          }
          $("#tabla2_cargo_fijo").text(parseFloat(ta['NCARGOFIJO']).toFixed(4))
          total = parseFloat(ta['NCARGOFIJO'])+parseFloat($("#tabla2_desague_total").text())+parseFloat($("#tabla2_agua_total").text())
          //total = total*parseFloat()
          $("#tabla2_igv").text((total*parseFloat(ta['ETIGV'])).toFixed(2));
          igv =  (total*parseFloat(ta['ETIGV'])).toFixed(2);
          total = total + parseFloat(igv)
          $("#tabla2_total").text(total.toFixed(2))


        }

        if(unidades3 != ""){
          $("#multiple_rango3").text($("#tarifas3").val())
          $("#tabla3_consumo_total").text(parseFloat(porcentaje2).toFixed(2))
          if(seleccionado1 == 1){
            if(ta3['VOLPRIRAN'] != 0){
              if(ta3['VOLPRIRAN'] != '9999999999'){
                $("#tabla3_rango1").text("de 0 a "+ta3['VOLPRIRAN']);
                if(porcentaje2 > parseInt(ta3['VOLPRIRAN'])){
                  $("#consumo_tb3_rango1").text(parseFloat(ta3['VOLPRIRAN']).toFixed(2))
                  porcentaje2 =  porcentaje2 - parseInt(ta3['VOLPRIRAN']);
                  //cantidad = cantidad - parseInt(ta['VOLPRIRAN']);
                } else {
                  $("#consumo_tb3_rango1").text(parseFloat(porcentaje2).toFixed(2))
                  porcentaje2 = porcentaje2 - parseInt(ta3['VOLPRIRAN']);
                }
              } else {
                $("#tabla3_rango1").text("de 0 a más");
                $("#consumo_tb3_rango1").text(parseFloat(porcentaje2).toFixed(2))
              }
            }
            if(ta3['VOLSEGRAN'] != 0){ //segundo rango
              if(ta3['VOLSEGRAN'] != '9999999999'){
                $("#tabla3_rango2").text("de "+ (parseInt(ta3['VOLPRIRAN']) + 1)+" a "+ta3['VOLSEGRAN'])
                valor_opcional = parseInt(ta3['VOLSEGRAN']) - parseInt(ta3['VOLPRIRAN'])
                if(porcentaje2 > valor_opcional){
                  $("#consumo_tb3_rango2").text(parseFloat(valor_opcional).toFixed(2))
                  porcentaje2 = porcentaje2 - parseInt(valor_opcional);
                } else if(porcentaje2 > 0) {
                  $("#consumo_tb3_rango2").text(parseFloat(porcentaje2).toFixed(2))
                  porcentaje2 = porcentaje2 - parseInt(valor_opcional);
                }
              } else {
                  $("#tabla3_rango2").text("de "+(parseInt(ta3['VOLPRIRAN'])+1)+" a más")
                  if(porcentaje1 > 0){
                    $("#consumo_tb3_rango2").text(parseFloat(porcentaje2).toFixed(2))
                  }
              }
            }
            if(ta3['VOLTERRAN'] != 0){//tercer rango
              if(ta3['VOLTERRAN'] != '9999999999'){
                $("#tabla3_rango3").text("de "+(parseInt(ta3['VOLSEGRAN']) + 1)+" a "+ta3['VOLTERRAN'])
                valor_opcional = parseInt(ta3['VOLTERRAN']) - parseInt(ta3['VOLSEGRAN']) 
                if(porcentaje2 > valor_opcional){
                  $("#consumo_tb3_rango3").text(parseFloat(valor_opcional).toFixed(2))
                  porcentaje2 = porcentaje2 - parseInt(valor_opcional);
                } else if(porcentaje2 > 0){
                  $("#consumo_tb3_rango3").text(parseFloat(porcentaje2).toFixed(2))
                }
              } else{
                $("#tabla3_rango3").text("de "+(parseInt(ta3['VOLSEGRAN']) + 1)+" a más")
                if(porcentaje2 > 0 ){
                  $("#consumo_tb3_rango3").text(parseFloat(porcentaje2).toFixed(2))
                }
              }
            }
          } else {
            $("#tabla3_rango1").text("de 0 a más");
            $("#consumo_tb3_rango1").text(parseFloat(porcentaje1).toFixed(2))
          }
          $("#tabla3_precio_unitario1_agua").text(parseFloat(ta3['IMPPRIRAN']).toFixed(4))
          $("#tabla3_precio_unitario1_desague").text(parseFloat(ta3['DIMPPRIRAN']).toFixed(4))

          $("#tabla3_precio_unitario2_agua").text(parseFloat(ta3['IMPSEGRAN']).toFixed(4))
          $("#tabla3_precio_unitario2_desague").text(parseFloat(ta3['DIMPSEGRAN']).toFixed(4))

          $("#tabla3_precio_unitario3_agua").text(parseFloat(ta3['IMPTERRAN']).toFixed(4))
          $("#tabla3_precio_unitario3_desague").text(parseFloat(ta3['DIMPTERRAN']).toFixed(4))

          if(seleccionado1 == 1){
            if(seleccionado == 1 || seleccionado == 2){
              agua_rango1 = parseFloat($("#tabla3_precio_unitario1_agua").text()) * (parseFloat($("#consumo_tb3_rango1").text()));
              agua_rango2 = parseFloat($("#tabla3_precio_unitario2_agua").text()) * (parseFloat($("#consumo_tb3_rango2").text()));
              agua_rango3 = parseFloat($("#tabla3_precio_unitario3_agua").text()) * (parseFloat($("#consumo_tb3_rango3").text()));
              $("#tabla3_agua_rango1").text(agua_rango1.toFixed(2))
              $("#tabla3_agua_rango2").text(agua_rango2.toFixed(2))
              $("#tabla3_agua_rango3").text(agua_rango3.toFixed(2))
              $("#tabla3_agua_total").text((agua_rango3 + agua_rango2 + agua_rango1).toFixed(2))
            }
            if(seleccionado == 1 || seleccionado == 3){
              deagua_rango1 = parseFloat($("#tabla3_precio_unitario1_desague").text()) * (parseFloat($("#consumo_tb3_rango1").text()));
              deagua_rango2 = parseFloat($("#tabla3_precio_unitario2_desague").text()) * (parseFloat($("#consumo_tb3_rango2").text()));
              deagua_rango3 = parseFloat($("#tabla3_precio_unitario3_desague").text()) * (parseFloat($("#consumo_tb3_rango3").text()));
              $("#tabla3_desague_rango1").text(deagua_rango1.toFixed(2))
              $("#tabla3_desague_rango2").text(deagua_rango2.toFixed(2))
              $("#tabla3_desague_rango3").text(deagua_rango3.toFixed(2))
              $("#tabla3_desague_total").text((deagua_rango1 + deagua_rango2 + deagua_rango3).toFixed(2))
            }
          } else {
              if(seleccionado == 1 || seleccionado == 2){
                  agua_rango1 = parseFloat($("#tabla3_precio_unitario1_agua").text()) * (parseFloat($("#consumo_tb3_rango1").text()));
                  $("#tabla3_agua_rango1").text(agua_rango1.toFixed(2))
                  $("#tabla3_agua_total").text((agua_rango1).toFixed(2))
              }
              if(seleccionado == 1 || seleccionado == 3){
                deagua_rango1 = parseFloat($("#tabla3_precio_unitario1_desague").text()) * (parseFloat($("#consumo_tb3_rango1").text()));
                $("#tabla3_desague_rango1").text(deagua_rango1.toFixed(2))
                $("#tabla3_desague_total").text((deagua_rango1).toFixed(2))
              }
          }
          $("#tabla3_cargo_fijo").text(parseFloat(ta3['NCARGOFIJO']).toFixed(4))
          total = parseFloat(ta3['NCARGOFIJO'])+parseFloat($("#tabla3_desague_total").text())+parseFloat($("#tabla3_agua_total").text())
          //total = total*parseFloat()
          $("#tabla3_igv").text((total*parseFloat(ta3['ETIGV'])).toFixed(2));
          igv =  (total*parseFloat(ta3['ETIGV'])).toFixed(2);
          total = total + parseFloat(igv)
          $("#tabla3_total").text(total.toFixed(2))
        }

        // para el total de la tarifa multiple
        let agua_tabla1 = 0;
        let agua_tabla2 = 0;
        let agua_tabla3 = 0;
        let monto_agua_tabla1 = 0;
        let monto_agua_tabla2 = 0;
        let monto_agua_tabla3 = 0;
        let monto_desague_tabla1 = 0;
        let monto_desague_tabla2 = 0;
        let monto_desague_tabla3 = 0;
        if(unidades1 != ""){
          agua_tabla1 += parseFloat($("#consumo_tb1_rango1").text()) * parseFloat(unidades1);
          agua_tabla2 += parseFloat($("#consumo_tb1_rango2").text()) * parseFloat(unidades1);
          agua_tabla3 += parseFloat($("#consumo_tb1_rango3").text()) * parseFloat(unidades1);

          monto_agua_tabla1 += parseFloat($("#tabla1_agua_rango1").text()) * parseFloat(unidades1)
          monto_agua_tabla2 += parseFloat($("#tabla1_agua_rango2").text()) * parseFloat(unidades1)
          monto_agua_tabla3 += parseFloat($("#tabla1_agua_rango3").text()) * parseFloat(unidades1)

          monto_desague_tabla1 += parseFloat($("#tabla1_desague_rango1").text()) * parseFloat(unidades1)
          monto_desague_tabla2 += parseFloat($("#tabla1_desague_rango2").text()) * parseFloat(unidades1)
          monto_desague_tabla3 += parseFloat($("#tabla1_desague_rango3").text()) * parseFloat(unidades1)

        }
        if(unidades2 != ""){
          agua_tabla1 += parseFloat($("#consumo_tb2_rango1").text()) * parseFloat(unidades2);
          agua_tabla2 += parseFloat($("#consumo_tb2_rango2").text()) * parseFloat(unidades2);
          agua_tabla3 += parseFloat($("#consumo_tb2_rango3").text()) * parseFloat(unidades2);

          monto_agua_tabla1 += parseFloat($("#tabla2_agua_rango1").text()) * parseFloat(unidades2)
          monto_agua_tabla2 += parseFloat($("#tabla2_agua_rango2").text()) * parseFloat(unidades2)
          monto_agua_tabla3 += parseFloat($("#tabla2_agua_rango3").text()) * parseFloat(unidades2)

          monto_desague_tabla1 += parseFloat($("#tabla2_desague_rango1").text()) * parseFloat(unidades2)
          monto_desague_tabla2 += parseFloat($("#tabla2_desague_rango2").text()) * parseFloat(unidades2)
          monto_desague_tabla3 += parseFloat($("#tabla2_desague_rango3").text()) * parseFloat(unidades2)
        }
        if(unidades3 != ""){
          agua_tabla1 += parseFloat($("#consumo_tb3_rango1").text()) * parseFloat(unidades3);
          agua_tabla2 += parseFloat($("#consumo_tb3_rango2").text()) * parseFloat(unidades3);
          agua_tabla3 += parseFloat($("#consumo_tb3_rango3").text()) * parseFloat(unidades3);

          monto_agua_tabla1 += parseFloat($("#tabla3_agua_rango1").text()) * parseFloat(unidades3)
          monto_agua_tabla2 += parseFloat($("#tabla3_agua_rango2").text()) * parseFloat(unidades3)
          monto_agua_tabla3 += parseFloat($("#tabla3_agua_rango3").text()) * parseFloat(unidades3)

          monto_desague_tabla1 += parseFloat($("#tabla3_desague_rango1").text()) * parseFloat(unidades3)
          monto_desague_tabla2 += parseFloat($("#tabla3_desague_rango2").text()) * parseFloat(unidades3)
          monto_desague_tabla3 += parseFloat($("#tabla3_desague_rango3").text()) * parseFloat(unidades3)

        }

        $("#consumo_tb4_rango1").text(parseFloat(agua_tabla1).toFixed(2))
        $("#consumo_tb4_rango2").text(parseFloat(agua_tabla2).toFixed(2))
        $("#consumo_tb4_rango3").text(parseFloat(agua_tabla3).toFixed(2))
        $("#tabla4_consumo_total").text(parseFloat(agua_tabla1+ agua_tabla2 + agua_tabla3).toFixed(2))
        $("#tabla4_agua_rango1").text(parseFloat(monto_agua_tabla1).toFixed(2))
        $("#tabla4_agua_rango2").text(parseFloat(monto_agua_tabla2).toFixed(2))
        $("#tabla4_agua_rango3").text(parseFloat(monto_agua_tabla3).toFixed(2))
        $("#tabla4_agua_total").text(parseFloat(monto_agua_tabla3 + monto_agua_tabla2 + monto_agua_tabla1).toFixed(2))
        $("#tabla4_desague_rango1").text(parseFloat(monto_desague_tabla1).toFixed(2))
        $("#tabla4_desague_rango2").text(parseFloat(monto_desague_tabla2).toFixed(2))
        $("#tabla4_desague_rango3").text(parseFloat(monto_desague_tabla3).toFixed(2))
        $("#tabla4_desague_total").text(parseFloat(monto_desague_tabla3 + monto_desague_tabla2 + monto_desague_tabla1).toFixed(2))
        $("#tabla4_cargo_fijo").text(parseFloat($("#tabla1_cargo_fijo").text()).toFixed(4))
        let subtotal = parseFloat($("#tabla4_agua_total").text()) + parseFloat($("#tabla4_cargo_fijo").text()) + parseFloat($("#tabla4_desague_total").text())
        let igv5 =  (subtotal*parseFloat(ta['ETIGV'])).toFixed(2);
        $("#tabla4_igv").text(parseFloat(igv5).toFixed(2))
        $("#tabla4_total").text(parseFloat(parseFloat(igv5) + parseFloat(subtotal)).toFixed(2))
        $("#tabla4").fadeIn("slow");

      }else {
        if(cantidad == ""){
          swal("", "Debe ingresar un volumen, para realizar el cálculo", "warning")
        } else if(TAR == -1 && TAR1 == -1 && TAR2 == -1){
          swal("", "Debe seleccionar alguna tarifa", "warning")
        } else if(unidades1 == "" && unidades2 == "" && unidades3 == ""){
          swal("", "Debe ingresar al menos una unidad de uso", "warning")
        }
      }
    }
    tarifas ;
    tarifas1 = "";
    tarifas2 = "";
    tarifas3 = "" ;
    traer_tarifas =  function(){
      localidad = $( "#localidades" ).val();
      categoria = $( "#categorias" ).val();
      if(localidad != -1 && categoria != -1){
        $.ajax({
          type: 'POST',
          url: '<?php echo $this->config->item('ip').'cuenta_corriente/obtener_tarifas?ajax=true'; ?>',
          data: ({
            'localidad' : localidad,
            'categoria' : categoria
          }),
          cache: false,
          dataType: 'text',
          success: function(data){
            console.log(data);
            resultado = JSON.parse(data);
            tarifas =  resultado.tarifas;
            $("#tarifas").empty()
            $('#tarifas').prop('disabled', false);
            $("#tarifas").append("<option value='-1'>Seleccione una tarifa</option>")
            for(var  i  = 0; i <resultado.tarifas.length;i++){
              $("#tarifas").append("<option value='"+resultado.tarifas[i]['TARIFA']+"'>"+resultado.tarifas[i]['TARIFA']+"</option>");
            }

          }, error: function(jqHXR,textSuccess,errorThrown){
            swal("", "Hubo un problema en la conexión", "warning")
          }
        })
      } else {
        swal("", "Debe seleccionar una localidad y una categoria", "warning")
      }
    }

    traer_tarifas1 =  function(valor){
      localidad = $( "#localidades1" ).val();
      categoria = $( "#categorias"+valor ).val();
      if(localidad != -1 && categoria != -1){
        $.ajax({
          type: 'POST',
          url: '<?php echo $this->config->item('ip').'cuenta_corriente/obtener_tarifas?ajax=true'; ?>',
          data: ({
            'localidad' : localidad,
            'categoria' : categoria
          }),
          cache: false,
          dataType: 'text',
          success: function(data){
            console.log(data);
            resultado = JSON.parse(data);
            if(valor == 1){
              tarifas1 =  resultado.tarifas;
            } else if(valor == 2){
              tarifas2 =  resultado.tarifas;
            } else if(valor == 3){
              tarifas3 =  resultado.tarifas;
            }
            $("#tarifas"+valor).empty()
            $('#tarifas'+valor).prop('disabled', false);
            $("#tarifas"+valor).append("<option value='-1'>Seleccione una tarifa</option>")
            for(var  i  = 0; i <resultado.tarifas.length;i++){
              $("#tarifas"+valor).append("<option value='"+resultado.tarifas[i]['TARIFA']+"'>"+resultado.tarifas[i]['TARIFA']+"</option>");
            }
          }, error: function(jqHXR,textSuccess,errorThrown){
            swal("", "Hubo un problema en la conexión", "warning")
          }
        })
      } else {
        swal("", "Debe seleccionar una localidad y una categoria", "warning")
      }
    }

    cambio_tarifa =  function(){
      tarifa = $( "#tarifas" ).val();
      if(tarifa != -1){
        for(var i = 0;  i <tarifas.length; i++){
          if(tarifas[i]['TARIFA'] == tarifa){
            console.log(tarifas[i]['DIMPPRIRAN']);
            if(tarifas[i]['IMPPRIRAN'] != 0 && tarifas[i]['DIMPPRIRAN'] != 0){
              $("#agua1").prop('disabled',false);
              $("#agua2").prop('disabled',false);
              $("#agua3").prop('disabled',false);
              $("#agua1").prop('checked',true);
            } else if(tarifas[i]['IMPPRIRAN'] == 0 && tarifas[i]['DIMPPRIRAN'] != 0){
              $("#agua1").prop('disabled',true);
              $("#agua2").prop('disabled',true);
              $("#agua3").prop( "checked" ,true)
              $("#agua3").prop('disabled',true);
            } else {
              $("#agua1").prop('disabled',true);
              $("#agua2").prop('disabled',true);
              $("#agua2").prop( "checked",true )
              $("#agua3").prop('disabled',true);
            }
            break;
          }
        }
      } else {
        swal("", "Debe seleccionar una tarifa", "warning")
      }
    }

    function manual_recibo(){
      $("#subtotal_agua").attr("disabled",false);
      $("#subtotal_desague").attr("disabled",false);
    }

    abrir_calculadora =  function(){
      $.ajax({
        type: 'POST',
        url: '<?php echo $this->config->item('ip').'cuenta_corriente/obtener_localidades?ajax=true'; ?>',
        data: ({
        }),
        cache: false,
        dataType: 'text',
        success: function(data){
          console.log(data);
          resultado = JSON.parse(data);
          if(resultado.result ==  true){
            //$("#serie_numero").html("pruebassss");
            $("#serie_numero1").html(<?php echo $serie; ?>);
            $("#serie_numero2").html(<?php echo $numero; ?>);
            $(".mensaje_resolucion").html();
            $(".mensaje_resolucion").html(resultado.mensaje['RCDDES']);
            $("#localidades").empty();
            $("#localidades1").empty();
            $("#categorias").empty();
            $("#categorias1").empty();
            $("#categorias2").empty();
            $("#categorias3").empty();
            $("#localidades").append("<option value ='-1'>Todas las localidades</option>")
            $("#localidades1").append("<option value ='-1'>Todas las localidades</option>")
            $("#categorias").append("<option value ='-1'>Todas las categorias</option>")
            $("#categorias1").append("<option value ='-1'>Todas las categorias</option>")
            $("#categorias2").append("<option value ='-1'>Todas las categorias</option>")
            $("#categorias3").append("<option value ='-1'>Todas las categorias</option>")
            for(var i = 0 ; i <resultado.localidades.length; i++){
              $("#localidades").append("<option value = '"+resultado.localidades[i]['AMBITO']+"'>"+resultado.localidades[i]['LOCDES']+"</option>");
              $("#localidades1").append("<option value = '"+resultado.localidades[i]['AMBITO']+"'>"+resultado.localidades[i]['LOCDES']+"</option>");
            }
            for(var i = 0; i< resultado.categorias.length; i++){
                $("#categorias").append("<option value ='"+resultado.categorias[i]['CATEGORIA']+"'>"+resultado.categorias[i]['DESCATTAR']+"</option>")
                $("#categorias1").append("<option value ='"+resultado.categorias[i]['CATEGORIA']+"'>"+resultado.categorias[i]['DESCATTAR']+"</option>")
                $("#categorias2").append("<option value ='"+resultado.categorias[i]['CATEGORIA']+"'>"+resultado.categorias[i]['DESCATTAR']+"</option>")
                $("#categorias3").append("<option value ='"+resultado.categorias[i]['CATEGORIA']+"'>"+resultado.categorias[i]['DESCATTAR']+"</option>")
            }
          } else {
            swal("", resultado.mensaje, "warning")
          }

        }, error: function(jqHXR,textSuccess,errorThrown){
          swal("", "Hubo un problema en la conexión", "warning")
        }
      })
      $('#modal_calculadora').modal({backdrop: 'static', keyboard: false})
      $("#subtotal_agua").attr('disabled',true)
      $("#subtotal_agua").val('0.00')
      $("#agua").val(parseFloat($("#monto_agua").html()))
      $("#subtotal_desague").attr('disabled',true)
      $("#subtotal_desague").val('0.00')
      $("#desague").val(parseFloat($("#monto_desague").html()))
      $("#modal_calculadora").modal('show');
    }

    $("input[name=calculadora]:radio").change(function () {
        valor = $('input[type=radio][name=calculadora]:checked').attr('id');
        if(valor == 'individual' ){
          $("#calculadora_multiple").fadeOut("slow");
          $("#calculadora_simple").fadeIn("slow");
          limpiar_calculadora_individual()
        } else if(valor == 'multiple'){
          $("#calculadora_simple").fadeOut("slow");
          $("#calculadora_multiple").fadeIn("slow");
          limpiar_calculadora()
        }
    })
    var metros = 0;
    function aceptar_calculo(){
      if($("#individual").is(':checked')){
          total_agua = parseFloat($("#importea_total").text());

          total_desague = parseFloat($("#imported_total").text());
          suma = 0;
          suma1 = 0;
          
          if(parseFloat($("#monto_agua").text()) < total_agua || parseFloat($("#monto_desague").text()) < total_desague){
            swal("", "Los montos no pueden ser mayores a los", "warning")
          } else {
            metros = parseFloat($("#monto_calcular").val());
              if(parseFloat(total_agua) > 0 || parseFloat(total_desague) > 0){
                
                if(parseFloat(total_agua)>0){
                  $("#agua").val(parseFloat(total_agua));
                  $("#subtotal_agua").val((parseFloat($("#monto_agua").text())-parseFloat(total_agua)).toFixed(2));
                }
                if(parseFloat(total_desague) > 0){
                  $("#desague").val(parseFloat(total_desague));
                  $("#subtotal_desague").val((parseFloat($("#monto_desague").text())-parseFloat(total_desague)).toFixed(2));
                }
                 $(".money2").each(function (index) {
                   if($(this).val() != ""){
                     suma += parseFloat($(this).val())
                   }
                 })
                 $(".money8").each(function (index) {
                   if($(this).val() != ""){
                     suma1 += parseFloat($(this).val())
                   }
                 })
                 $("#subtotal1").html(suma.toFixed(2))
                 $("#subtotal2").html(suma1.toFixed(2))
                 $("#modal_calculadora").modal("hide")
              } else {
                swal("", "Debe calcular primero el nuevo pago", "warning")
              }
        }
      } else {
        total_agua = $("#tabla4_agua_total").text();
        total_desague = $("#tabla4_desague_total").text();
        suma = 0;
        suma1 = 0;
        if(parseFloat($("#monto_agua").text()) < total_agua || parseFloat($("#monto_desague").text()) < total_desague){
          swal("", "Los montos no pueden ser mayores a los", "warning")
        } else {
          metros = parseFloat($("#monto_calcular").val());
          if(parseInt(total_agua) > 0 || parseInt(total_desague) > 0){
            if(parseInt(total_agua)>0){
              $("#agua").val(parseFloat(total_agua));
              $("#subtotal_agua").val((parseFloat($("#monto_agua").text())-parseFloat(total_agua)).toFixed(2));
            }
            if(parseInt(total_desague) > 0){
              $("#desague").val(parseFloat(total_desague));
              $("#subtotal_desague").val((parseFloat($("#monto_desague").text())-parseFloat(total_desague)).toFixed(2));
            }
             $(".money2").each(function (index) {
               if($(this).val() != ""){
                 suma += parseFloat($(this).val())
               }
             })

             $(".money8").each(function (index) {
               if($(this).val() != ""){
                 suma1 += parseFloat($(this).val())
               }
             })

             $("#subtotal1").html(suma.toFixed(2))
             $("#subtotal2").html(suma1.toFixed(2))
             $("#modal_calculadora").modal("hide")
          } else {
            swal("", "Debe calcular primero el nuevo pago", "warning")
          }
        }
      }
      //if()
    }

    function generar_nota_credito  () {
      if(parseFloat($("#subtotal2").html()) > 0){
        var suministro = '<?php echo $user_datos['CLICODFAC']; ?>';
        var serie_user = '<?php echo $serie_usuario; ?>';
        var serie_nc  = "";
        var numero_nc = "";
        if(tipo == 2){
          var serie_nc = '<?php echo (isset($notas_credito[0]['NCASERNRO']) ? $notas_credito[0]['NCASERNRO'] : 0); ?>';
          var numero_nc = '<?php echo  (isset($notas_credito[0]['NCANRO']) ? $notas_credito[0]['NCANRO'] : 0); ?>';
        }
        var conceptos = new Array();
        var conceptos1 = new Array();
        var montos = new Array();
        var faclin = new Array();
        var letfac = new Array();
        if( $("#subtotal2").text() != "" && $("#referencia_nc").val() != ""){
          $(".concep").each(function (index) {
            conceptos.push($(this).html());
          })
          $(".concep1").each(function (index) {
            conceptos1.push($(this).html());
          })
          $(".money2").each(function (index) {
            montos.push($(this).val());
          })
          $(".faclin").each(function (index) {
            if($(this).val() == "") faclin.push(0);
            else faclin.push($(this).val());
          })
          $(".letfac").each(function (index) {
            if($(this).val() == "") letfac.push(0);
            else letfac.push($(this).val())
          })
          var subtotal = $("#subtotal1").html();
          console.log(faclin);
          /*$(".concep").parent("tr").find("td").each(function() {
            alert("hola");
            alert($(this).html())
          })*/
          nota_redito = parseFloat($("#subtotal2").text());
          swal({
            title: "<span style='fontt:family:\"Ubuntu\"'>¿Estas seguro que quieres generar la nota de Crédito?</span>",
            text: "",
            type: "warning",
            html: true,
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "SÍ!",
            showLoaderOnConfirm: true,
            confirmButtonColor: "#296fb7"
              }, function() {
                  $.ajax({
                      type: "POST",
                      url: "<?php echo $this->config->item('ip'); ?>" + "cuenta_corriente/save_nota_credito?ajax=true",
                      data: {
                        'suministro' : suministro,
                        'serie' : <?php echo $serie; ?>,
                        'numero' : <?php echo $numero; ?>,
                        'referencia' : $("#referencia_nc").val(),
                        'serie_user' : serie_user,
                        'conceptosFac' : conceptos,
                        'conceptosLec' : conceptos1,
                        'montos' : montos,
                        'tipo' : tipo,
                        'serie_nc' : serie_nc,
                        'numero_nc' : numero_nc,
                        'subtotal' : subtotal,
                        'letfac' : letfac,
                        'faclin' : faclin,
                        'metros' : metros
                      },
                      success: function(data){
                        console.log(data);
                      }
                  })
                .done(function(data) {
                  resultado = data;
                  if(resultado.result == true){
                    swal("Generado!", "Se ha generado la Nota de Crédito con exito", "success");
                    location.reload();
                    //$("#btn_generar_nota_credito").attr("onclick","");
                    var myWindow = window.open(servidor+"cuenta_corriente/notaCredito/"+resultado.suministro+"/" + resultado.serie + "/"+resultado.numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");myWindow.focus();myWindow.print();
                  } else {
                    swal({title : "",text : resultado.mensaje,type:'warning',html:true });
                  }
                })
                .error(function(data) {
                  swal("Oops", "No se pudo conectar con el servidor!", "error");
                });
              })
        } else {
          swal("", "Debe primero calcular la nota de crédito y rellenar el campo de referencia", "warning")
        }
      } else {
        swal({title : "", text  : "<b>No puede quedar un saldo negativo para el recibo, si desea anular el recibo totalmente seleccione la opción de 'ANULAR RECIBO'</b>", type: "warning",html:true})
      }

    }
    function anular_recibo(){
      var suministro = '<?php echo $user_datos['CLICODFAC']; ?>';
      var serie_user = '<?php echo $serie_usuario; ?>';
      var serie_nc  = "";
      var numero_nc = "";
      if(tipo == 2){
        var serie_nc = '<?php echo (isset($notas_credito[0]['NCASERNRO']) ? $notas_credito[0]['NCASERNRO'] : 0); ?>';
        var numero_nc = '<?php echo  (isset($notas_credito[0]['NCANRO']) ? $notas_credito[0]['NCANRO'] : 0); ?>';
      }
      if($("#referencia_nc").val() != ""){
        swal({
        title: "<span style='fontt:family:\"Ubuntu\"'>¿Estas seguro que quieres anular todo el Recibo con una nota de Crédito?</span>",
        text: "",
        type: "warning",
        html: true,
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "SÍ!",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#296fb7"
        }, function() {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->config->item('ip'); ?>" + "cuenta_corriente/anular_nota_credito?ajax=true",
                data: {
                  'suministro' : suministro,
                  'serie' : <?php echo $serie; ?>,
                  'numero' : <?php echo $numero; ?>,
                  'referencia' : $("#referencia_nc").val(),
                  'serie_user' : serie_user,
                  'tipo' : tipo,
                  'serie_nc' : serie_nc,
                  'numero_nc' : numero_nc
                },
                success: function(data){
                  console.log(data);
                }
            })
          .done(function(data) {
            resultado = data;
            if(resultado.result == true){
              swal("Generado!", "SE HA GENERADO LA NOTA DE CRÉDITO CON ÉXITO", "success");
              var myWindow = window.open(servidor+"cuenta_corriente/notaCredito/"+resultado.suministro+"/" + resultado.serie + "/"+resultado.numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");myWindow.focus();myWindow.print();
              window.close();
              //$("#btn_generar_nota_credito").attr("onclick","");
              
            } else {
              swal({title :"",text:resultado.mensaje,type:"warning"});
            }
          })
          .error(function(data) {
            swal("Oops", "No se pudo conectar con el servidor!", "error");
          });
        })
      } else {
        swal({ 'title' : "" , 'text' : "DEBE INGRESAR LA REFERENCIA PARA PODER ANULAR LA NOTA DE CRÉDITO",'type' : 'warning'})
      }
    }
  </script>
</body>
</html>
