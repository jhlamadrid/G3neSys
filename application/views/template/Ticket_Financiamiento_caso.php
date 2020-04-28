<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="SEDALIB SA" content="">
        <title><?php echo "PAGO DEINICIAL DE CONVENIO"; ?></title>


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
                           
                            echo '<b> TRUJILLO - TRUJILLO  - LA LIBERTAD </b>';
                        ?>
                    <br>
                    <?php //echo ($copia)? ('<b style="font-size:20px;">COPIA DE </b><br>'):''; ?>
                    <b style="font-size:20px;"><?php echo 'INICIAL CONVENIO'; ?></b>
                    <br>
                    <b style="font-size:12px;"><?php echo '10 - 6 - 442184'; ?></b>
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
                                    //$strfecha = explode('/', $cab[0]['FSCFECH']);
                                    echo '20-06-2018';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>SUMINISTRO: </b>
                            </td>
                            <td>
                                <?php
                                    //$strfecha = explode('/', $cab[0]['FSCFECH']);
                                    echo '12080605938';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>CORRELATIVO:</b>
                            </td>
                            <td>
                                <?php echo '442184'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>CAJERO(A):</b>
                            </td>
                            <td>
                                <?php echo 'LAVADO JAIME'; ?>
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
                                <?php echo '20-06-2018 14:14:55';?>
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
                                <?php echo 'LEZAMA ALVARADO DE SOLORZANO CONSUELO'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>DIRECCION:</b>
                            </td>
                            <td>
                                <?php echo 'VICTOR LARCO - URBA BUENOS AIRES SUR'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo 'DNI'; ?>:</b>
                            </td>
                            <td>
                                <?php echo '18036524'; ?>
                            </td>
                        </tr>
                        <!--<tr>
                            <td>
                                <b>REF:</b>
                            </td>
                            <td>
                            </td>
                        </tr>-->
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
                       
                        <tr>
                            <td style="width:10%;">
                                    <?php echo 1; ?>
                            </td>
                            <td style="text-align:justify;">
                                    <?php echo "PAG. INICIAL CONV."; ?>
                            </td>
                            <td style="width:10%; text-align:center;">
                                    <?php echo 1; ?>
                            </td>
                            <td style="width:20%; text-align:right;">
                                    <?php echo '170.18'; ?>
                            </td>
                        <tr>
                        

                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    =========================
                </td>
            </tr>
            <tr>
                <td style="font-size:12px;">
                    <table style="width:100%; font-size:12px;">
                    

                        <tr>
                            <td>
                                <b>Total:</b>
                            </td>
                            <td style="text-align:right;">
                                <?php 
                                    echo '170.18';
                                ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    Total a pagar: <?php echo 'CIENTO SETENTA Y 18/100 SOLES'; ?>
                    

                <td>
            </tr>
            
        </table>
    </body>
</html>
