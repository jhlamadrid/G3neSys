<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title" style="font-family:'Ubuntu'">Datos Personales</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <div class="input-group">
                <span class="input-group-addon" id="Rcliente">CLIENTE:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo $usuario['CLINOMBRE'] ?>" disabled>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="input-group">
                <span class="input-group-addon" id="Rdireccion">DIRECCIÓN:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo $usuario['URBDES']." ".$usuario['CALDES']." ".$usuario["CLIMUNNRO"]; ?>" disabled>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="input-group">
                <span class="input-group-addon" id="Rsuministro">SUMINISTRO:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo $usuario['CLICODFAC'] ?>" aria-describedby="basic-addon3" disabled>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="input-group">
                <span class="input-group-addon" id="Rnumero">NÚMERO DE RECIBO:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo $recibo['FACSERNRO']."-".$recibo['FACNRO'] ?>" aria-describedby="basic-addon3" disabled>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="input-group">
                <span class="input-group-addon" id="Rnumero">FECHA VENCIMIENTO:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo $recibo['FACVENFEC']; ?>" aria-describedby="basic-addon3" disabled>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="input-group">
                <span class="input-group-addon" id="Rciclo">CICLO:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo $recibo['FCICLO']; ?>" disabled>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="input-group">
                <span class="input-group-addon" id="Rtarifa">TARIFA:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo $recibo['FACTARIFA'] ?>" disabled>
              </div>
            </div>
             <div class="col-md-4 col-sm-4">
              <div class="input-group">
                <span class="input-group-addon" id="Rmes">FACTURACIÓN - MES:</span>
                <input type="text" class="form-control" id="basic-url" style="color:#00a65a;font-size:16px" value="<?php echo devolver_mes(substr($recibo['FACEMIFEC'],3,2)).' - '.substr($recibo['FACEMIFEC'],6,4) ?>"  disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title" style="font-family:'Ubuntu'">Detalle de Recibo</h3>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="clientes" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th>NÚMERO</th>
                  <th>NÚMERO CONCEPTO</th>
                  <th>CONCEPTO</th>
                  <th style="text-align:right">IMPORTE (S./)</th>
                </tr>
              </thead>
              <tbody>
              <?php $i=1; foreach($faclin as $fac){ ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $fac['FACCONCOD']; ?></td>
                  <td><?php echo $fac['FACCONDES']; ?></td>
                  <td style="text-align:right"><?php echo number_format(floatval($fac['FACPRECI']), 2, '.', ''); ?></td>
                </tr>
              <?php $i++;} ?>
              <?php foreach($letfac as $let){?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $let['FACCONCOD']; ?></td>
                  <td><?php echo $let['FACCONDES']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$let['LTNUM']."/".$let['CRECUONRO']." &nbsp;&nbsp;[".$let['CREDNRO']."]"; ?></td>
                  <td style="text-align:right"><?php echo number_format(floatval($let['CRECUOMON']), 2, '.', ''); ?></td>
                </tr>
              <?php $i++; } ?>
                <tr>
                  <td style="text-align:right;padding-right:30px" colspan="3">SUB TOTAL</td>
                  <td style="text-align:right"><?php echo number_format(floatval($recibo['FACTOTSUB']), 2, '.', ''); ?></td>
                </tr>
                <tr>
                  <td style="text-align:right;padding-right:30px" colspan="3">I.G.V.</td>
                  <td style="text-align:right"><?php echo number_format(floatval($recibo['FACIGV']), 2, '.', ''); ?></td>
                </tr>
                <tr>
                  <td style="text-align:right;padding-right:30px" colspan="3">TOTAL</td>
                  <td style="text-align:right;color:#f00;font-size:20px"><?php echo number_format(floatval($recibo['FACTOTAL']), 2, '.', ''); ?></td>
                </tr>
              </tbody>
            </table>
          </div><br />
        </div>
      </div>
    </div>
  </div>
</section>
  <?php
    function devolver_mes($valor){
        switch($valor){
            case "01":return "ENERO";break;
            case "02":return "FEBRERO";break;
            case "03":return "MARZO";break;
            case "04":return "ABRIL";break;
            case "05":return "MAYO";break;
            case "06":return "JUNIO";break;
            case "07":return "JULIO";break;
            case "08":return "AGOSTO";break;
            case "09":return "SETIEMBRE";break;
            case "10":return "OCTUBRE";break;
            case "11":return "NOVIEMBRE";break;
            case "12":return "DICIEMBRE";break;
        }
    }
?>
