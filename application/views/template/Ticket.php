<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="SEDALIB SA" content="">
        <title><?php echo ($cab['FSCTIPO']=='0')? 'BOLETA DE VENTA':'FACTURA'; ?></title>


    </head>
    <body>
        <table style="width:100%; font-family:Arial, Helvetica, sans-serif;">
            <tr>
                <td style="text-align:center">
                    <b>SEDALIB S.A.</b>
                    <br>
                    <b style="font-size:12px;">RUC - 20131911310</b>
                    <br>
                    <b style="font-size:10px;">Of. Principal: AV. FEDERICO VILLARREAL N° 1300 URB. SEMI RUSTICA "EL BOSQUE"</b>
                    <br>

                    <b style="font-size:11px;">
                        <?php
                            if(trim($oficina['OFIABR'])!='CENTRAL'){
                                echo 'Of. Atencion: '.$oficina['OFIDIR'].'<br>';
                            }
                            echo '<b>'. $oficina['DIST']." - ".
                                        $oficina['PROV']." - ".
                                        $oficina['DEPTO'].
                                '</b>';
                        ?>
                    <br>
                    <?php echo ($copia)? ('<b style="font-size:20px;">COPIA DE </b><br>'):''; ?>
                    <b style="font-size:20px;"><?php echo ($cab['FSCTIPO']=='0')? 'BOLETA DE VENTA':'FACTURA'; ?></b>
                    <br>
                    <b style="font-size:12px;"><?php echo $cab['SUNSERNRO'].'-'.str_pad($cab['SUNFACNRO'], 6, "0", STR_PAD_LEFT); ?></b>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    =========================
                </td>
            </tr>
            <tr>
                <td style="font-size:11px; vertical-align:top;">
                    <table style="width:100%;">
                        <tr>
                            <td>
                                <b>FECHA EMISION:</b>
                            </td>
                            <td>
                                <?php
                                    $strfecha = explode('/', $cab['FSCFECH']);
                                    echo $strfecha[0].'-'.$strfecha[1].'-'.$strfecha[2];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>CORRELATIVO:</b>
                            </td>
                            <td>
                                <?php echo $cab['FSCSERNRO'].'-'.str_pad($cab['FSCNRO'], 6, "0", STR_PAD_LEFT); ?>
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
                                <b>MONEDA:</b>
                            </td>
                            <td>
                                SOLES
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>FECHA-HORA IMPRESION:</b>
                            </td>
                            <td>
                                <?php echo date('d-m-Y H:i:s');?>
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
                    <table style="width:100%;">
                        <tr>
                            <td>
                                <b>NOMBRE:</b>
                            </td>
                            <td>
                                <?php echo $cab['FSCCLINOMB']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>DIRECCION:</b>
                            </td>
                            <td>
                                <?php echo $cab['FSDIREC'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo ($cab['FSCTIPO']=='0')? 'DNI':'RUC'; ?>:</b>
                            </td>
                            <td>
                                <?php echo ($cab['FSCTIPO']=='0')? $cab['FSCNRODOC']:$cab['FSCCLIRUC']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>REF:</b>
                            </td>
                            <td>
                                <?php echo ($cab['OBSDOC']==null || $cab['OBSDOC']=='')? '(ninguna)':$cab['OBSDOC']; ?>
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
                <td style="font-size:10px;">
                    <table style="width:100%;">
                        <tr>
                            <td style="width:10%;">
                                ITEM
                            </td>
                            <td style="text-align:center;">
                                CONCEPTO
                            </td>
                            <td style="width:10%; text-align:center;">
                                CANT
                            </td>
                            <td style="width:20%; text-align:center;">
                                PRECIO
                            </td>

                        <tr>
                        <?php foreach ($descripcion as $item) { ?>
                            <tr>
                                <td style="width:10%;">
                                    <?php echo $item['FACCONCOD']; ?>
                                </td>
                                <td style="text-align:justify;">
                                    <?php echo $item['FACCONDES']; ?>
                                </td>
                                <td style="width:10%; text-align:center;">
                                    <?php echo $item['CANT']; ?>
                                </td>
                                <td style="width:20%; text-align:right;">
                                    <?php echo number_format($item['PUNIT'],2,'.',','); ?>
                                </td>
                            <tr>
                        <?php } ?>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    =========================
                </td>
            </tr>
            <!--<tr>
                <td style="font-size:12px;">
                    <table style="width:100%; font-size:12px;">
                    <?php if($cab['FSCTIPO']=='1'){ ?>
                        <tr>
                            <td>
                                <b>Valor Venta:</b>
                            </td>
                            <td style="text-align:right;">
                                <?php echo number_format($cab['FSCSUBTOTA'],2,'.',','); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>I.G.V. (<?php echo $cab['FSCIGVREF']; ?>%):</b>
                            </td>
                            <td style="text-align:right;">
                                <?php echo number_format($cab['FSCSUBIGV'],2,'.',','); ?>
                            </td>
                        </tr>
                    <?php } ?>

                        <tr>
                            <td>
                                <b>Total:</b>
                            </td>
                            <td style="text-align:right;">
                                <?php echo number_format($cab['FSCTOTAL'],2,'.',','); ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    Total a pagar: <?php echo $total_letra; ?>

                <td>
            </tr>-->
            <tr>
                <td style="font-size:12px;">
                    <table style="width:100%; font-size:12px;">
                    <?php if($cab['FSCTIPO']=='1'){ ?>
                        <tr>
                            <td>
                                <b>Valor Venta:</b>
                            </td>
                            <td style="text-align:right;">
                                <?php 
                                    if($cab['CONCEPT_GRATUITO']==1){
                                        echo number_format(0,2,'.',','); 
                                    }else{
                                        echo number_format($cab['FSCSUBTOTA'],2,'.',',');
                                    }
                                     
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>I.G.V. (<?php echo $cab['FSCIGVREF']; ?>%):</b>
                            </td>
                            <td style="text-align:right;">
                                <?php
                                    if($cab['CONCEPT_GRATUITO']==1){
                                        echo number_format(0,2,'.',',');
                                    }else{
                                        echo number_format($cab['FSCSUBIGV'],2,'.',',');
                                    } 
                                     
                                ?>
                            </td>
                        </tr>
                    <?php } ?>

                        <tr>
                            <td>
                                <b>Total:</b>
                            </td>
                            <td style="text-align:right;">
                                <?php 
                                    if($cab['CONCEPT_GRATUITO']==1){
                                        echo number_format(0,2,'.',',');
                                    }else{
                                        echo number_format($cab['FSCTOTAL'],2,'.',',');
                                    }
                                 
                                ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    Total a pagar: <?php echo $total_letra; ?>
                    <?php if($cab['CONCEPT_GRATUITO']==1){?>
                        <br>
                        <b>Varlor Referencial:<b> <?php echo number_format($cab['FSCTOTAL'],2,'.',','); ?>
                        <center>
                            <strong> TRANSFERENCIA GRATUITA </strong>
                        </center>
                    <?php }?>

                <td>
            </tr>
            <tr>
                <td style="text-align:center; font-size:12px;">
                    <img src="<?php echo $imagen; ?>" style="padding:10px;"><br>
                    FIRMA DIGITAL<br>
                    <?php echo $cab['SUNFIRMA']; ?>
                <td>
            </tr>
        </table>
    </body>
</html>
