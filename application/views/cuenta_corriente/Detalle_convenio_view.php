<section class="content">
  <div class="row">
    <div class="col-md-2 col-sm-2">
      <div class="input-group">
        <span  class="input-group-addon" id="Ccredito">CREDITO:</span>
        <input type="text" class="form-control form-control-sm" id="ncredito" style="color:#00a65a;font-size:16px" value="<?php echo $credito['CREDNRO'] ?>" aria-describedby="basic-addon3" disabled>
      </div>
    </div>
    <div class="col-md-3 col-sm-3">
      <div class="input-group">
        <span class="input-group-addon" id="Ccredito">TIPO:</span>
        <input type="text" class="form-control" id="tcredito" style="color:#00a65a;font-size:16px" value="<?php if($credito['CREDTIPO'] == 'Y'){echo "COLATERAL"; }else{echo "REFINANCIADO";} ?>" aria-describedby="basic-addon3" disabled>
      </div>
    </div>
    <div class="col-md-5 col-sm-5">
      <div class="input-group">
        <span class="input-group-addon" id="Ccredito">CONCEPTO:</span>
        <input type="text" class="form-control" id="ccredito" style="color:#00a65a;font-size:16px" value="<?php echo $credito['CONCEP_FACCONCOD']." ".$credito['FACCONDES'] ?>" aria-describedby="basic-addon3" disabled>
      </div>
    </div>
    <div class="col-md-2 col-sm-2">
      <div class="input-group">
        <span class="input-group-addon" id="Ccredito">FECHA:</span>
        <input type="text" class="form-control" id="fcredito" style="color:#00a65a;font-size:16px" value="<?php echo $credito['CREDFECHA'] ?>" aria-describedby="basic-addon3" disabled>
      </div>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-3 col-sm-3">
      <div class="input-group">
        <span class="input-group-addon" id="Ccredito">SUMINISTRO:</span>
        <input type="text" class="form-control" id="tcredito" style="color:#00a65a;font-size:16px" value="<?php echo $credito['CLIUNICOD'] ?>" aria-describedby="basic-addon3" disabled>
      </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="input-group">
          <span class="input-group-addon" id="Ccredito">NOMBRE:</span>
          <input type="text" class="form-control" id="nomcredito" style="color:#00a65a;font-size:16px" value="<?php echo $user['CLINOMBRE'] ?>" aria-describedby="basic-addon3" disabled>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        <div class="input-group">
          <span class="input-group-addon" id="Ccredito">MONTO CREDITO:</span>
          <input type="text" class="form-control" id="fcredito" style="color:#00a65a;font-size:16px;text-align:right" value="<?php echo number_format(floatval($credito['DEUDATOTAL']),2,'.',''); ?>" aria-describedby="basic-addon3" disabled>
        </div>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-2 col-sm-2">
      <div class="input-group">
        <span class="input-group-addon" id="Ccredito">DEUDA:</span>
        <input type="text" class="form-control" id="fcredito" style="color:#00a65a;font-size:16px;text-align:right" value="<?php if($credito['CTAINICIAL'] != NULL){echo number_format(floatval($credito['CTAINICIAL']),2,'.',''); } else {echo "0.00";} ?>" aria-describedby="basic-addon3" disabled>
      </div>
    </div>
    <div class="col-md-2 col-sm-2">
      <div class="input-group">
        <span class="input-group-addon" id="Ccredito">N° CUOTAS:</span>
        <input type="text" class="form-control" id="fcredito" style="color:#00a65a;font-size:16px;text-align:right" value="<?php echo $credito['NROLTS']; ?>" aria-describedby="basic-addon3" disabled>
      </div>
    </div>
    <div class="col-md-3 col-sm-3">
      <div class="input-group">
         <?php $cuotas_faltantes = 0; foreach($detalles as $detalle) {
           if($detalle['LTSTATUS'] == 'I') $cuotas_faltantes++;
         }?>
         <span class="input-group-addon" id="Ccredito">N° CUOTAS PAGADAS:</span>
        <input type="text" class="form-control" id="fcredito" style="color:#00a65a;font-size:16px;text-align:right" value="<?php echo intval($credito['NROLTS'])-$cuotas_faltantes; ?>"  disabled>
      </div>
    </div>
    <div class="col-md-3 col-sm-3">
      <div class="input-group">
        <span class="input-group-addon" id="Ccredito">REFERENCIA:</span>
        <input type="text" class="form-control" id="refcredito" style="color:#00a65a;font-size:16px" value="<?php echo $credito['CREDREFE'] ?>"  disabled>
      </div>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">
          <div class="table-responsive">
            <table id="resumen" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                    <th>NÚMERO</th>
                    <th>SALDO</th>
                    <th>ADMORTIZA</th>
                    <th>INTERÉS</th>
                    <th>GASCOB</th>
                    <th>ACCIONES</th>
                    <th>IGV</th>
                    <th>CUOTAS</th>
                    <th>VENCIMIENTO</th>
                    <th>ESTADO</th>
                    <th>CANCEL</th>
                    <th>NRO. SERIE</th>
                    <th>RECIBO</th>
                </tr>
              </thead>
              <tbody>
              <?php $i = 0;$DEUDA = 0; foreach($detalles as $detalle) {?>
                <tr>
                  <td><?php  echo ($i+1); ?></td>
                  <td style='text-align:right'><?php echo  number_format(floatval($detalle['LTSALDO']),2,'.',''); ?></td>
                  <td style='text-align:right'><?php if($detalle['LTVALOR'] == NULL){ echo "0.00";}else{ echo  number_format(floatval($detalle['LTVALOR']),2,'.','');} ?></td>
                  <td style='text-align:right'><?php if($detalle['LTINTER'] == NULL){ echo "0.00";}else{ echo  number_format(floatval($detalle['LTINTER']),2,'.','');} ?></td>
                  <td style='text-align:right'><?php if($detalle['LTGACOBZ'] == NULL){ echo "0.00";}else{ echo  number_format(floatval($detalle['LTGACOBZ']),2,'.','');} ?></td>
                  <td style='text-align:right'><?php if($detalle['LTACCION'] == NULL){ echo "0.00";}else{ echo  number_format(floatval($detalle['LTACCION']),2,'.','');} ?></td>
                  <td style='text-align:right'><?php if($detalle['LTIGV'] == NULL){ echo "0.00";}else{ echo  number_format(floatval($detalle['LTIGV']),2,'.','');} ?></td>
                  <td style='text-align:right'><?php if($detalle['LTCUOTA'] == NULL){ echo "0.00";}else{ echo  number_format(floatval($detalle['LTCUOTA']),2,'.','');} ?></td>
                  <td><?php echo $detalle['LTVENCIM'] ?></td>
                  <td><?php echo $detalle['LTSTATUS']; if($detalle['LTSTATUS'] == 'I'){ $DEUDA += floatval($detalle['LTCUOTA']);} ?></td>
                  <td><?php if($detalle['LTFECCANC'] == NULL){ echo " / / ";}else{ echo $detalle['LTFECCANC'];}?></td>
                  <td style='text-align:right'><?php if($detalle['FACNROX'] ==  NULL){echo "0";}else{ echo $detalle['FACNROX'];}?></td>
                  <td style='text-align:right'><?php if($detalle['FACNROX'] ==  NULL){echo "0";}else{ echo $detalle['FACNROX'];}?></td>
                </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">
          <a onclick="imprimir_convenio()" class="btn btn-success"><i class="fa fa-print" aria-hidden="true"></i> &nbsp; Imprimir</a>
          <div class="col-sm-1 cold-md-1" style="float:right">
            <a href="" class="btn btn-danger" style="float:right" onclick="window.close()">Cerrar</a>
          </div>
          <div class="col-md-3 col-sm-3" style="float:right">
            <div class="input-group">
              <span class="input-group-addon" id="Ccredito">SALDO PENDIENTE:</span>
              <input type="text" class="form-control" id="fcredito" style="color:#00a65a;font-size:16px;text-align:right" value="<?php echo number_format($DEUDA,2,'.',''); ?>" disabled>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
function imprimir_convenio(){ var myWindow = window.open("<?php echo $this->config->item('ip').'cuenta_corriente/imprimir_credito/'.$credito['CLIUNICOD'].'/'.$credito['AGENCI_OFICIN_OFICOD'].'/'.$credito['AGENCI_OFIAGECOD'].'/'.$credito['CREDNRO']; ?>", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800"); myWindow.focus();myWindow.print();}

</script>
