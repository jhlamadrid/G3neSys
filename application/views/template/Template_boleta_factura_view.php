<!DOCTYPE html>
<html lang='es'>
    <head>
        <title>Sedalib</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <style>
        	/*.descripcion, .descripcion th, .descripcion td {
			    border: 1px solid black;
			    border-collapse: collapse;
			    padding: 5px;
			}
			.desciption th {
				text-align: center;
			}*/
        </style>
    </head>
    <body style='font-family:sans-serif;'>
        <table style="height: 90px; width:100%;">
            <thead>
                <tr>
                    <th style="width: 30%;">
                        <img src="<?php echo $dire_img; ?>" style="height:80px;">
                    </th>
                    <th style="width:40%;">
                    	<?php if($tiene_cabecera) { ?>
	                        <table style="height:90px; width:100%;">
	                            <tbody>
	                                <tr style="height:30px;">
	                                    <td style="width:30%;">
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                </tr>
	                                <tr style="height:30px;" data-pg-collapsed>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                </tr>
	                                <tr style="height:30px;" data-pg-collapsed>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                    <td style="width:30%;" data-pg-collapsed>
	                                        <strong style='margin-top:-2px;'><i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
	           									Oficina:</i></strong>
	                                        <br>
	                                        <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
	          									SAPITOS</i>
	                                    </td>
	                                </tr>
	                            </tbody>
	                        </table>
                        <?php } ?>
                    </th>
                    <th style="width: 30%;">
	                    <div style="width:100%; height: 80px; border-radius: 10px 10px 10px 10px; border: 1px solid black;">
	                    	<table style="height:80px; width:100%;">
	                            <tbody>
	                                <tr>
	                                    <td style=' padding: 7px; margin-top:10px; margin-bottom:5px; text-align:center; background-color: #FBFB91;'>
	                                        <h4 >
	                                        	<?php if($cabecera[14]=='03') { ?>
	                                        		BOLETA DE VENTA ELECTRONICA
	                                        	<?php } else { ?>
	                                        		FACTURA ELECTRONICA
	                                        	<?php } ?>
	                                        </h4>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style='padding: 7px; margin-top:2px; margin-bottom:5px; text-align:center;'>
	                                        <h3 >
	                                        	R.U.C N° 20131911310 
	                                        </h3>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style='padding: 7px; margin-top:2px; margin-bottom:5px;text-align:center; margin-top:12px;'>
	                                        <h4> 
	                                        	<?php echo $cabecera[6]; ?>
	                                        </h4>
	                                    </td>
	                                </tr>
	                            </tbody>
	                        </table>
	                    </div>
                        
                    </th>
                </tr>
                <tr>
                    <th style="height: 90px; width: 30%;" colspan="3">
                        <table>
                            <tr>
                                <td style='border-radius: 6px 0 0 0; border-left: 0.7px solid #000; border-right: 0.7px solid #000;border-top: 0.7px solid #000; width:5%;'> <!-- border-radius: 6px 0 0 0; border-left: 0.7px solid #000; border-right: 0.7px solid #000;border-top: 0.7px solid #000; width:5%; --> 
                                    <span style='margin-left:5px; font-size: 12px;'>
                                    	NOMBRE: 
                                    </span>
                                </td>
                                <td colspan='7' style='border-radius: 0 6px 0 0; border-top: 0.7px solid #000; border-right: 0.7px solid #000; text-align:left;'> <!-- style='border-radius: 0 6px 0 0; border-top: 0.7px solid #000; border-right: 0.7px solid #000; text-align:left;'--> 
                                    <span style='margin-left:5px; text-align:left; font-size: 12px;'>
                                    	<?php echo $cabecera[11]; ?>
                                    </span> 
                                </td>
                            </tr>
                            <tr>
                                <td style='border:0.7px solid #000; width:5%; '>
                                    <span style='margin-left:5px; font-size: 12px;'>DIRECCIÓN:</span>
                                </td>
                                <td colspan='7' style='border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'>
                                    <span style='margin-left:5px; text-align:left; font-size: 12px;'>
                                    	<?php echo $cabecera[17]; ?>
                                    </span> 
                                </td>
                            </tr>
                            <tr>
                                <td style='width:10%; background-color: #FBFB91;border-radius: 0 0 0 6px;border-left: 0.7px solid #000;border-right: 0.7px solid #000; border-bottom: 0.7px solid #000; ' data-pg-collapsed>
                                    <span style='margin-left:5px; font-size: 12px;'>
                                    	<?php echo ($cabecera[10]=='1')? 'R.U.C. ':'D.N.I. '; ?>
                                    </span>
                                </td>
                                <td style='width:10%;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'
                                	<?php echo ($cabecera[14]=='03')? 'colspan="5"':''; ?>
                                >
                                    <span style='margin-left:3px;'>
                                    	<?php echo $cabecera[9]; ?>
                                    </span> 
                                </td>
                                <?php if($cabecera[14]=='01') { ?>
	                                <td style='width:10%; background-color: #FBFB91;border-radius: 0 0 0 0;border-left: 0.7px solid #000;border-right: 0.7px solid #000; border-bottom: 0.7px solid #000; '>
	                                    <span style='margin-left:5px;  font-size: 12px;'>Guia Rem. N°: </span>
	                                </td>
	                                <td style='width:10%;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'>
	                                    <span style='margin-left:3px;'></span> 
	                                </td>
	                                <td style='width:10%; background-color: #FBFB91;border-radius: 0 0 0 0;border-left: 0.7px solid #000;border-right: 0.7px solid #000; border-bottom: 0.7px solid #000; '>
	                                    <span style='margin-left:5px;  font-size: 12px;'>Guia Transp. N°: </span>
	                                </td>
	                                <td style='width:10%;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'>
	                                    <span style='margin-left:3px;'></span> 
	                                </td>
                                <?php } ?>
                                <td style='width:16%;background-color: #FBFB91;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;  '>
                                    <span style='margin-left:5px;  font-size: 12px;'> Fecha de Emision:</span>
                                </td>
                                <td style='  border-radius: 0 0 6px 0;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;text-align:center;'>
                                    <span style='margin-left:5px;'><?php echo $cabecera[7]; ?></span> 
                                </td>
                            </tr>
                        </table>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr style='width:100% ; '>
                    <td colspan='3'>
                        <div style='width:100% ; '>
                            <table class="descripcion" style='border-spacing: 0px 0px 0px 0px; border: 0px solid #000;  width:100%;   font-size:8px; margin-bottom: 5px;' data-pg-collapsed>
                                <tr style='border: 0.7px solid #000;'>
                                    <th style=' text-align:center; border-radius: 6px 0 0 0; border: 0.7px solid #000; width:4%; '>ITEM </th>
                                    <th style=' text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:6%; '>CODIGO</th>
                                    <th style=' text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:50%; '>DESCRIPCIÓN </th>
                                    <th style=' text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;width:4%;  '>UNID.</th>
                                    <th style='text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:6%;'>CANT.</th>
                                    <th style='  text-align:center;border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:10%; '>PRECIO UNIT.</th>
                                    <th style='  text-align:center;border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;  width:10%; '></th>
                                    <th style='  text-align:center;  border-radius: 0 6px 0 0; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:10%;'>SUB TOTAL</th>
                                </tr>
                                <?php foreach ($detalle as $item) { ?>
	                                <tr style='border: 0.7px solid #000; '>
	                                    <td style='border-bottom: 0.7px solid #000; border-left: 0.7px solid #000;border-right: 0.7px solid #000;text-align:center; '>
	                                    	<?php echo $item[0]; ?>
	                                    </td>
	                                    <td style='border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; text-align:center; '>
	                                    	<?php echo $item[11]; ?>
	                                    </td>
	                                    <td style='border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '>
	                                        <p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>
	                                        	<?php echo $item[10]; ?>
	                                        </p>
	                                    </td>
	                                    <td style='border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; text-align:center; '>
	                                    	<?php echo $item[13]; ?>
	                                    </td>
	                                    <td style='text-align:right; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '> 
	                                        <span style='margin-right:5px;'>
	                                        	<?php echo $item[1]; ?>
	                                        </span>
	                                    </td>
	                                    <td style='text-align:right; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '> 
	                                        <span style='margin-right:5px;'>
	                                        	<?php echo $item[3]; ?>
	                                        </span>
	                                    </td>
	                                    <td style='text-align:right; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'> 
	                                        <span style='margin-right:5px;'></span>
	                                    </td>
	                                    <td style='text-align:right;  border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '> 
	                                        <span style='margin-right:5px;'>
	                                        	
	                                        </span>
	                                    </td>
	                                </tr> 
	                            <?php } ?>                                
                            </table>                             
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <htmlpagefooter name="footer">	
			<div style='width:100%; height:80px;'>
	            <table class="" style="width:100%; height:80px;">
	                <tbody class="">
	                    <tr class="">
	                        <td style="width:20%;">
	                            <img src='<?php echo $qrfile; ?>' style='height:15%; '>
	                        </td>
	                        <td style="width:44%;">
	                            <table style=' width:100% ; font-size:8px;'>
	                                <tr>
	                                    <td colspan='2' style='border-radius: 5px 5px 5px 5px; border: 0.7px solid #000; background-color: #FBFB91;'>
	                                        Son: <?php echo $cabecera[1]; ?>
									</td>
	                                </tr>
	                                <tr>
	                                    <td>
	                                        Valor de venta de operaciones Gratuitas
										</td>
	                                    <td style='border-radius: 5px 5px 5px 5px; border:0.7px solid #000;'>
	                                        <span style='margin-left:5px;'>  0.00 </span>
	                                    </td>
	                                </tr>
	                            </table>
	                            <table style='width:100%;  height: 50px; font-size:9px;'>
	                                <tr>
	                                    <td colspan='3' style='text-align:center; border-radius: 6px 0 0 0; border: 0.7px solid #000;'> FECHA</td>
	                                    <td style='text-align:center; border-radius: 6px 0 0 0; border: 0.7px solid #000;'> CANCELADO</td>
	                                </tr>
	                                <tr>
	                                    <td style='text-align:center; height: 17px; border: 1px solid black; border-collapse: collapse;'> DIA </td>
	                                    <td style='text-align:center; border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000;height: 17px; '> MES</td>
	                                    <td style='text-align:center; border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000;height: 17px; '>AÃO</td>
	                                    <td rowspan='2' style='  border-radius: 0 0 6px 0;  border-bottom: 0.7px solid #000; border-right: 0.7px solid #000; height: 34px;  '> </td>
	                                </tr>
	                                <tr>
	                                    <td style='text-align:center; border-radius: 0 0 0 6px;border-bottom: 0.7px solid #000; border-left: 0.7px solid #000; border-right: 0.7px solid #000; height: 17px;'>22  </td>
	                                    <td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000; height: 17px; '>11  </td>
	                                    <td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000;height: 17px;'>2016 </td>
	                                </tr>
	                            </table>
	                        </td>
	                        <td class="" data-pg-collapsed>
	                            <table style='border-spacing: 0px 0px 0px 0px; border: 0px solid #000;  width:100%;  height: 80px;font-size:7px; margin-top:3px; ' data-pg-collapsed>
	                                <tr>
	                                    <td style='border-radius: 6px 0 0 0; border: 0.7px solid #000;width:25%;height: 18px;  '> 
	                                        <span style='margin-left:5px;'>Anticipos: </span>
	                                    </td>
	                                    <td style='text-align:right;  border-bottom: 0.7px solid #000; border-top: 0.7px solid #000; width:20%;height: 18px; '> 
	                                        <span style='margin-right:5px;'>0.00 </span>
	                                    </td>
	                                    <td style=' border: 0.7px solid #000;width:25%;height: 18px;  '> 
	                                        <span style='margin-left:5px;'>Sub-total: </span>
	                                    </td>
	                                    <td style='text-align:right; border-radius: 0 6px 0 0; border-right: 0.7px solid #000; border-top: 0.7px solid #000; border-bottom: 0.7px solid #000; width:30%;height: 18px; '> 
	                                        <span style='margin-right:5px;'>18.64 </span>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style=' border-left:0.7px solid #000;  border-bottom:0.7px solid #000; border-right: 0.7px solid #000; width:25%;height: 18px;  '> 
	                                        <span style='margin-left:5px;'>Descuentos: </span>
	                                    </td>
	                                    <td style='text-align:right;  border-bottom: 0.7px solid #000; width:20%;height: 18px; '> 
	                                        <span style='margin-right:5px;'>0.00 </span>
	                                    </td>
	                                    <td style='border-left:0.7px solid #000;  border-bottom:0.7px solid #000; border-right: 0.7px solid #000;  width:25%;height: 18px;'>
	                                        <span style='margin-left:5px;'>I.G.V.( ): </span>
	                                    </td>
	                                    <td style='text-align:right; border-right:0.7px solid #000; border-bottom:0.7px solid #000; width:30%;height: 18px;'> 
	                                        <span style='margin-right:5px;'> 3.36 </span>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style=' border-left:0.7px solid #000;  border-bottom:0.7px solid #000; border-right: 0.7px solid #000; width:25%;height: 17px;  '> 
	                                        <span style='margin-left:5px;'>Otros Tributos </span>
	                                    </td>
	                                    <td style='text-align:right;  border-bottom: 0.7px solid #000; width:20%;height: 17px; '> 
	                                        <span style='margin-right:5px;'></span>
	                                    </td>
	                                    <td style='border-left:0.7px solid #000;  border-bottom:0.7px solid #000; border-right: 0.7px solid #000;  width:25%;height: 17px;'>
	                                        <span style='margin-left:5px;'>Varlor Venta: </span>
	                                    </td>
	                                    <td style='text-align:right; border-right:0.7px solid #000; border-bottom:0.7px solid #000; width:30%;height: 17px;'> 
	                                        <span style='margin-right:5px;'> 18.64 </span>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style='border-radius: 0 0 0 6px; border-left:0.7px solid #000;  border-bottom:0.7px solid #000; border-right: 0.7px solid #000; width:25%;height: 16px;  '> 
	                                        <span style='margin-left:5px;'>Otros Cargos </span>
	                                    </td>
	                                    <td style='text-align:right;  border-bottom: 0.7px solid #000; width:20%;height: 16px; '> 
	                                        <span style='margin-right:5px;'> </span>
	                                    </td>
	                                    <td style=' border-left:0.7px solid #000; border-right:0.7px solid #000; border-bottom:0.7px solid #000;  width:25%;height: 16px;  '>
	                                        <span style='margin-left:5px;'>TOTAL </span>
	                                    </td>
	                                    <td style='text-align:right; border-radius: 0 0 6px 0;border-right:0.7px solid #000; border-bottom:0.7px solid #000;  width:30%; height: 16px;'> 
	                                        <span style='margin-right:5px;'>22.00 </span>
	                                    </td>
	                                </tr>
	                            </table>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td colspan="2">
	                            <i style=' font-size:9px;'> Documento aprobado  por la SUNAT</i>
	                        </td>
	                        <td style="text-align:right;">
	                            <i style='font-size:9px;'> pagina 1/1</i>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>
	        </div>
		</htmlpagefooter>
		<sethtmlpagefooter name="footer" value="on" /> 
    </body> 
	      
</html>