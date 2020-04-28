<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="SEDALIB SA" content="">
        <title><?php echo $titulo; ?></title>
        <style>
            .sub_total_serie td {
                border-top: 1px solid #000;
                border-collapse: collapse;
                margin-top: 10px;
                padding-top: 5px;
            }
            .serie th {
                border-top: 1px solid #000;
                border-collapse: collapse;
                padding-bottom: 5px;
                margin-bottom: 10px;
            }
            .principal tbody {
                border-top: 1px solid #000;
                border-collapse: collapse;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <!--table style="width:100%;">
            <tr>
                <td style="width:33%;">
                    <b>SEDALIB S.A,</b>
                    <br>
                    <b>R.U.C.</b> 20131911310
                    <br>
                    <b>Desde: </b> <?php echo $inicio;?>
                    <b>Hasta: </b> <?php echo $fin;?>
                    <br>
                    <b>Documento: </b> <?php echo ($tipo==0)? 'BOLETA':'FACTURA';?>
                </td>
                <td style="text-align: center;">Registro de Ventas</td>
                <td style="width:33%; text-align: right;">
                    <b>Fecha: </b> <?php echo date('d-m-Y');?>
                    <br>
                    <b>Hora: </b> <?php echo date('h:i:s');?>
                    <br>
                    <b>Pagina: </b> <?php echo $pag; ?>
                    <br>
                </td>
            </tr>
        </table-->
        <table class="principal" style="width:100%;">
            <thead>
                <tr>
                    <td colspan="10">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:60px;">
                                    <img src="<?php echo base_url().'img/sedalito.png'?>" style="width:50px;">
                                </td>
                                <td style="width:30%; border-bottom:1px solid black;" colspan="3">

                                    <b>SEDALIB S.A,</b>
                                    <br>
                                    <b>R.U.C.</b> 20131911310
                                    <br>
                                    <b>Documento: </b> <?php echo ($tipo==0)? 'BOLETA DE VENTA':'FACTURA';?>
                                </td>
                                <td style="text-align: center;" colspan="4">
                                    <span style="font-size: 14px;">REGISTRO DE VENTAS</span> <br>
                                    <span style="font-size: 10px;"><b>DESDE: </b> <?php echo $inicio;?> - <b>HASTA: </b> <?php echo $fin;?></span>
                                </td>
                                <td style="width:30%; text-align: right;" colspan="2">
                                    <b>Fecha: </b> <?php echo date('d-m-Y');?>
                                    <br>
                                    <b>Hora: </b> <?php echo date('h:i:s');?>
                                    <br>
                                    <b>Usuario: </b> <?php echo $_SESSION['user_nom']; ?>
                                    <br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr >
                    <th colspan="7" style="text-align: left;">Serie <?php echo $oficina['SERNRO']; ?> Oficina asignada <?php echo $oficina['OFIDES']; ?> </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="serie" style="font-size: 10px;">
                    <th style="text-align:center; font-size: 10px;">item</th>
                    <th style="text-align:center; font-size: 10px;">Ser. Nro.</th>
                    <th style="text-align:center; font-size: 10px;">Fecha Emision</th>
                    <th style="text-align:center; font-size: 10px;">Cod. Suministro</th>
                    <th style="text-align:center; font-size: 10px; width:40%">Nombre de Cliente</th>
                    <th style="text-align:center; font-size: 10px;">Tip. Doc.</th>
                    <th style="text-align:center; font-size: 10px;">Nro. Doc.</th>
                    <th style="text-align:center; font-size: 10px;">Subtotal</th>
                    <th style="text-align:center; font-size: 10px;">I.G.V.</th>
                    <th style="text-align:center; font-size: 10px;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $item = 1;
                    $subtota = 0;
                    $igv = 0;
                    $total = 0;
                    foreach ($oficina['COMPROBANTES'] as $comprobante) { ?>
                <tr>
                    <td style="font-size: 10px; text-align:center;"><?php echo $item; $item++;?></td>
                    <td style="font-size: 10px; text-align:center;"><?php echo $comprobante['FSCSERNRO'].' - '.$comprobante['FSCNRO']; ?></td>
                    <td style="font-size: 10px; text-align:center;"><?php echo $comprobante['FSCFECH']; ?></td>
                    <td style="font-size: 10px; text-align:center;"><?php echo $comprobante['FSCCLIUNIC']; ?></td>
                    <td style="font-size: 10px;"><?php echo $comprobante['FSCCLINOMB']; ?></td>
                    <td style="font-size: 10px; text-align:center;"><?php echo $comprobante['FSCTIPDOC'].(($comprobante['FSCTIPDOC']==1)? ' DNI ':' RUC '); ?></td>
                    <td style="font-size: 10px; text-align:center;"><?php echo (($comprobante['FSCTIPDOC']==1)? $comprobante['FSCNRODOC']:$comprobante['FSCCLIRUC']); ?></td>
                    <td style="font-size: 10px; text-align: right;"><?php echo number_format($comprobante['FSCSUBTOTA'],2,'.',''); $subtota+= $comprobante['FSCSUBTOTA']; ?></td>
                    <td style="font-size: 10px; text-align: right;"><?php echo number_format($comprobante['FSCSUBIGV'],2,'.',''); $igv+= $comprobante['FSCSUBIGV']; ?></td>
                    <td style="font-size: 10px; text-align: right;"><?php echo number_format($comprobante['FSCTOTAL'],2,'.',''); $total+= $comprobante['FSCTOTAL']; ?></td>
                    <!--td></td-->
                </tr>
                <?php } ?>
                <tr class="sub_total_serie">
                    <td style="font-size: 10px; text-align:right;" colspan="6"><b><?php echo 'Total Serie N°'.$oficina['SERNRO'].': S/';?></b></td>
                    <td></td>
                    <td style="font-size: 10px; text-align: right;"><b><?php echo $subtota; ?></b></td>
                    <td style="font-size: 10px; text-align: right;"><b><?php echo $igv; ?></b></td>
                    <td style="font-size: 10px; text-align: right;"><b><?php echo $total; ?></b></td>
                    <!--td></td-->
                </tr>
            </tbody>
            <tfoot>
                <!--tr>
                    <th colspan="7" style="font-size: 10px; text-align: right;">Total Serie</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr-->
            </tfoot>
        </table>
    </body>
</html>
