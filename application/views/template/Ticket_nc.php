<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="SEDALIB SA" content="">
    <title><?php echo "NOTA CRÉDITO ".((($cab['BFNCATLET']) == 'B') ? "BOLETA" : "FACTURA"); ?></title>
  </head>
  <body>
    <table style="width:100%; font-family:Arial, Helvetica, sans-serif;">
      <tr>
        <td style="text-align:center">
          <b>SEDALIB S.A.</b><br>
          <b style="font-family:12px">RUC - 20131911310</b><br>
          <b style="font-size:10px">Of. Principal: AV. FEDERICO VOLLAREAL N° 1300 URB. SEMI RUSTICA "EL BOSQUE"</b><br>
          <b style="font-size:11px;">
            <?php if(trim($oficina['OFIABR'] != 'CENTRAL')) echo 'Of. Atencion: '.$oficina['OFIDIR'].'<br>';
              echo '<b>'.$oficina['DIST']." - ".$oficina['PROV']." - ".$oficina['DEPTO'].'</b>';
            ?>
          </b><br>
          <?php echo isset($copia) ? '<b style="font-size:20px;">COPIA DE </b></br>' : '' ;  ?>
          <b style="font-size:20px"><?php  echo "NOTA CRÉDITO ".((($cab['BFNCATLET']) == 'B') ? "BOLETA" : "FACTURA"); ?></b><br>
          <b style="font-size:12px"><?php echo $cab['BFNCATLET'].$cab['BFNCASERNRO']."-".$cab['BFNCANRO']; ?></b>
        </td>
      </tr>
      <tr>
        <td style="text-align:center">
          =========================
        </td>
      </tr>
      <tr>
        <td style="font-size:11px;vertical-align:top">
          <table style="width:100%;">
            <tr>
              <td>
                <b>FECHA EMISION:</b>
              </td>
              <td>
                <?php $strfecha = explode('/',$cab['BFNCAFECHEMI']); echo $strfecha[0]."-".$strfecha[1].'-'.$strfecha[2]; ?>
              </td>
            </tr>
            <tr>
              <td>
                <b>FECHA PAGO: </b>
              </td>
              <td>
                <?php $strfecha = explode('/',$cab['BFNCAFECHPAG']); echo $strfecha[0]."-".$strfecha[1].'-'.$strfecha[2]; ?>
              </td>
            </tr>
            <tr>
              <td>
                <b>FECHA EMISION <?php echo ($cab['BFNCATLET'] == 'F') ? "FACTURA:" : "BOLETA:" ?></b>
              </td>
              <td>
                <?php $strfecha = explode('/',$cab['BFSFACFECH']); echo $strfecha[0]."-".$strfecha[1].'-'.$strfecha[2]; ?>
              </td>
            </tr>
            <tr>
              <td>
                <b>FECHA PAGO <?php echo ($cab['BFNCATLET'] == 'F') ? "FACTURA:" : "BOLETA:" ?></b>
              </td>
              <td>
                <?php $strfecha = explode('/',$cab['BFSFACFECH']); echo $strfecha[0]."-".$strfecha[1].'-'.$strfecha[2]; ?>
              </td>
            </tr>
            <tr>
              <td>
                <b>CAJERO(A):</b>
              </td>
              <td>
                <?php echo $usuario['NNOMBRE']; ?>
              </td>
            </tr>
            <tr>
              <td>
                <b>MONEDA</b>
              </td>
              <td>
                SOLES
              </td>
            </tr>
            <tr>
              <td>
                <b>FECHA-HORA IMPRESION: </b>
              </td>
              <td>
                <?php echo date('d-m-Y H:i:s') ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="text-align:center">
            =========================
        </td>
      </tr>
      <tr>
        <td style="font-size:11px;">
          <table style="width:100%">
            <tr>
              <td><b>NOMBRE:</b></td>
              <td><?php echo $cab['FSCCLINOMB'] ?></td>
            </tr>
            <tr>
              <td><b>DIRECCIÓN: </b></td>
              <td><?php echo $cab['FSDIREC'] ?></td>
            </tr>
            <tr>
              <td><b><?php echo ($cab['BFSFACTIPDOC'] == 6) ? "RUC: ":"DNI: "; ?></b></td>
              <td><?php echo $cab['BFSFACNRODOC']; ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="text-align:center">
          =========================
        </td>
      </tr>
      <tr>
        <td style="font-size:10px">
          <table style="width:100%">
            <tr>
              <td style="width:10%">ITEM</td>
              <td style="text-align:center">CONCEPTO</td>
              <td style="width:20%; text-align:left">MONTO</td>
            </tr>
            <?php foreach ($detalle as $det) { ?>
              <?php if(floatval($det['NCAPREDIF']) > 0) { ?>
              <tr>
                <td style="width:10%">
                  <?php echo $det['CONCEP_FACCONCOD']; ?>
                </td>
                <td style="text-align:justify">
                  <?php echo $det['FACCONDES']; ?>
                </td>
                <?php if($cab['BFNCATLET'] == 'F') { ?>
                <td style="width:20%; text-align:right">
                  <?php echo number_format($det['NCAPREDIF'],2,'.',','); ?>
                </td>
                <?php } else { ?>
                  <td style="width:20%; text-align:right">
                    <?php $igv = floatval($det['NCAPREDIF']) * ($cab['BFNCAIGVREF'] / 100);  echo number_format(floatval($det['NCAPREDIF']) + $igv,2,'.',','); ?>
                  </td>
                <?php } ?>
              </tr>
              <?php } ?>
            <?php } ?>
          </table>
        </td>
      </tr>
      <tr>
        <td style="text-align:center">
            =========================
        </td>
      </tr>
      <tr>
        <td style="font-size:12px">
          <table style="width:100%; font-size:12px">
            <?php if($cab['BFNCATLET'] == 'F') { ?>
              <tr>
                <td><b>SUB TOTAL:</b></td>
                <td style="text-align:right">
                  <?php echo number_format($cab['BFNCASUBDIF'],2,'.',','); ?>
                </td>
              </tr>
              <tr>
                <td><b>I.G.V.: </b></td>
                <td style="text-align:right">
                  <?php echo  number_format($cab['BFNCAIGVDIF'],2,'.',','); ?>
                </td>
              </tr>
            <?php } ?>
            <tr>
              <td>
                <b>TOTAL: </b>
              </td>
              <td style="text-align:right">
                <?php echo number_format($cab['BFNCATOTDIF'],2,'.',','); ?>
              </td>
            </tr>
          </table>
          <br>
          TOTAL: <?php echo $total_letra; ?>
        </td>
      </tr>
      <tr>
        <td style="text-align:center; font-size:12px;">
          <img src="<?php echo $imagen; ?>" style="padding:10px"><br>
          FIRMA DIGITAL <br>
          <?php echo $cab['BFSFACSUNFIRMA']; ?>
        </td>
      </tr>
    </table>
  </body>
</html>
