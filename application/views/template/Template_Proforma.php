<!DOCTYPE html>
<html>
<head>
	<title>  </title>

	<style>
		.descripcion, .descripcion th, .descripcion td {
		    border: 1px solid #AAAAAA;
		    border-collapse: collapse;
		    padding: 5px;
		}
		.desciption th {
			text-align: center;
		}

		.pago, .pago th, .pago td{
			border: 1px solid black;
		    border-collapse: collapse;
		    padding: 7px;
		}

		.documento {
			border: 1px solid black;
			border-radius: 5px;
		    border-collapse: collapse;
		    padding: 7px;  

		}
		.documento td {
			padding: 7px;
		}
		.dato, .dato th, .dato td{
			border-collapse: collapse;
		    padding: 5px;
		}
		.dato th {

			text-align: left;
		}
	</style>
	
</head>
<body >
	<table style="width:100%">
		<tr>
			<td>
				<img src="<?php echo base_url().'img/logo2.png' ?>" style="height:80px;">
			</td>
			<td style="width:20%;"> </td>
			<td style="text-align: center;">
				<table class="documento" style="width: 100%; height: 100%; border: 1px solid black;">
					<tr><td><h2>R.U.C. N° 20131911310</h2></td></tr>
					<tr style="background-color: yellow;">
						<td><h1><?php echo ($cliente['FSCTIPO']==1)? "PROFORMA-FACTURA":"PROFORMA-BOLETA"; ?></h1></td>
					</tr>
					<tr>
						<td><h2><?php echo $cliente['FSCSERNRO'].'-'.str_pad($cliente['FSCNRO'], 6, "0", STR_PAD_LEFT); ?></h2></td>
					</tr>
				</table>
			</td>
	  	</tr>
	</table>
	<br>
    <table class="dato" style="width:100%;">
    	<tr>
			<th style="width:11%;"><?php echo ($cliente['FSCTIPDOC']==1)? "DNI:":"RUC:" ?></th>
			<td><?php echo ($cliente['FSCTIPDOC']==1)? $cliente['FSCNRODOC']:$cliente['FSCCLIRUC']; ?></td>
			<th style="width:11%;">FECHA:</th>
			<td style="width:10%;"><?php 
					//$d = DateTime::createFromFormat('d-M-y H.i.s.u', $cliente['FSCFECH']);
					//echo $d;
					echo date('d-m-Y');
			?></td>
		</tr>
		<tr>
			<th style="width:11%;">NOMBRE:</th>
			<td><?php echo $cliente['FSCCLINOMB']; ?></td>
			<th style="width:11%;"></th>
			<td style="width:10%;"></td>
		</tr>
		<tr>
			<th style="width:11%;">REF.:</th>
			<td><?php echo $cliente['OBSDOC']; ?></td>
			<th style="width:11%;"></th>
			<td style="width:10%;"></td>
		</tr>
    </table>
    <br>
    <table class="descripcion" style="width:100%;">
    	<tr role="row">
            <th style="font-size:14px;" width="10%">ITEM</th>
            <th style="font-size:14px;" width="10%">CODIGO</th>
            <th style="font-size:14px;" width="50%">DESCRIPCION</th>
            <th style="font-size:14px;" width="10%">CANTIDAD</th>
            <th style="font-size:14px;" width="10%">P. UNIT.</th>
            <th style="font-size:14px;" width="10%">IMPORTE</th>
        </tr>
        
        <?php for($i = $iter*$max_filas; $i<$iter*$max_filas+$max_filas; $i++) { ?>
        	<?php if($i<count($descripcion)) {
        		$aux = ''; 
        		if($descripcion[$i]['GRAT']=='1'){
        			$aux = 'Gratuito';
        			$descripcion[$i]['PUNIT'] = 0;
        		}else if($descripcion[$i]['AFECIGV']=='30'){
        			$aux = 'Inafecto';
        		}
        		$observacion = ($descripcion[$i]['OBSFACAUX'] == '' || $descripcion[$i]['OBSFACAUX'] == null)? '':(' - '.$descripcion[$i]['OBSFACAUX']);
        	?>
		        <tr>
		        	<td style="text-align: center; font-size:10px;"><?php echo $i+1; ?></td>
		        	<td style="text-align: center; font-size:10px;"><?php echo $descripcion[$i]['FACCONCOD']; ?></td>
		        	<td style="font-size:10px;"><?php echo $descripcion[$i]['FACCONDES'].$observacion; ?></td>
		        	<td style="text-align: right; font-size:10px;"><?php echo $descripcion[$i]['CANT']; ?></td>
		        	<td style="text-align: right; font-size:10px;">
		        		<?php echo number_format($descripcion[$i]['PUNIT'],2); ?>
		        		<br>
		        		<?php echo $aux; ?>
		        	</td>
		        	<td style="text-align: right; font-size:10px;"><?php echo number_format($descripcion[$i]['CANT']*$descripcion[$i]['PUNIT'],2); ?></td>
		        </tr>
	        <?php } else { ?>
		        <tr>
		        	<td style="text-align: center; font-size:10px;"><?php echo $i+1; ?></td>
		        	<td> </td>
		        	<td> </td>
		        	<td> </td>
		        	<td> </td>
		        	<td> </td>
		        </tr>
	        <?php } ?>
	        	
        <?php } ?>
    </table>
    <br>
    <htmlpagefooter name="footer">
		<div id="footer">	
			<table class="" style="width:100%;">
				<tr>
					<td style="width:22%; vertical-align: bottom;">
						<h5>Proforma realizada por Sedlib S.A.</h5> 
					</td>
					<td style="text-align: center; vertical-align: top;">
						Son: <?php echo $tot; ?>
					</td>
					<td style="width:20%; text-align: right; vertical-align: bottom;">
						<table class="pago" style="width:100%;">
							<?php if($cliente['FSCTIPO']==1){ ?>
								<tr>
									<th>SUBTOTA</th>
									<td style="text-align: right;"><?php echo number_format($cliente['FSCSUBTOTA'],2); ?></td>
								</tr>
								<tr>
									<th>I.G.V. (<?php echo $_SESSION['IGV']?>)%</th>
									<td style="text-align: right;"><?php echo number_format($cliente['FSCSUBIGV'],2); ?></td>
								</tr>
							<?php } ?>
							<tr>
								<th>TOTAL</th>
								<td style="text-align: right;"><?php echo number_format($cliente['FSCTOTAL'],2); ?></td>
							</tr>
						</table>
						<h6>PAGINA <?php echo $iter+1; ?>/<?php echo $max_iter; ?></h6> 
					</td>
				</tr>
			</table>
		</div>
	</htmlpagefooter>
	<sethtmlpagefooter name="footer" value="on" />
</body>
</html>