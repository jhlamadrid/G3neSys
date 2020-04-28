<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title> Ver Boleta y Factura</title>
	<link rel="stylesheet" href="<?php base_url();?>assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php base_url();?>assets/sweetalert/dist/sweetalert.css">
	<link rel="stylesheet" href="<?php base_url();?>assets/fecha/css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="<?php base_url();?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php base_url();?>assets/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>
	<style type="text/css">
		body {
		  /* Ubicación de la imagen */
		  background-image: url(assets/img/fondo.jpg);
		  background-position: center center;
		  background-repeat: no-repeat;
		  background-attachment: fixed;
		  background-size: cover;
		  overflow-x: hidden;
		}

	</style>

</head>
<body >
<div class="row">
	<div class="center-block">
		<img src="<?php base_url();?>assets/img/logo.png" class="img-responsive center-block" alt="Cinque Terre" width="504" height="436">
		<br>
	</div>
	<div class="container">
		<div class="panel-group">
			<div class="panel panel-primary">
		      <div class="panel-heading">COMPROBANTES ELECTRONICOS </div>
		      <div class="panel-body">
		      		<div class="row">
		      			<div class="col-md-12">
		      				<div class="col-md-3 col-sm-3 col-xs-6">
		      					<label for="usr">FECHA:</label>
		      						<div class="input-group">
									    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									   <input type="text" class="form-control" id="FECHA" readonly >
									</div>
		      				</div>
		      				<div class="col-md-3 col-sm-3 col-xs-6">
		      					<label for="usr">T. DE DOC.:</label>
  									<div class="input-group">
									    <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
									    <select class="form-control" id="TIPO_DOCUMENTO">
										    <option value="1">RUC</option>
										    <option value="2">DNI</option>
										    <option value="3">CARNET DE EXTRANJERIA</option>
										    
										 </select>
									</div>
		      				</div>
		      				<div class="col-md-3 col-sm-3  col-xs-6">
		      					<label for="usr">RUC/DNI/C. EXT.:</label>

  									<!--<input type="text" class="form-control" id="RUC" maxlength="11">-->
  									<div class="input-group">
									    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									    <input id="DOCUMENTO" type="text" class="form-control" name="email" placeholder="Documento de identificación">
									 </div>
		      				</div>

		      				
		      				<div class="col-md-3 col-sm-3 col-xs-6">
		      					<label for="usr">MONTO:</label>
  								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
									<input id="MONTO" type="text" class="form-control" name="email" placeholder="monto del comprobante">
								</div>
		      				</div>
		      			
		      			</div>
		      		
		      		</div>
		      		<hr>
		      		<div class="row">
		      			<div class="col-md-12">
		      				<div class="col-md-4 col-sm-4 col-xs-6">
		      					<label for="usr">TIPO DE COMPROBANTE :</label>
  									<div class="input-group">
									    <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
									    <select class="form-control" id="TIPO_COMPROBANTE">
										    <option value="0">BOLETA</option>
										    <option value="1">FACTURA</option>
										 </select>
									</div>
		      				</div>
		      				<div class="col-md-4 col-sm-4 col-xs-6">
		      					<label for="usr">SERIE:</label>
  								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-copy"></i></span>
									<input type="text" class="form-control" id="SERIE" >
								</div>
		      				</div>
		      				<div class="col-md-4 col-sm-4 col-xs-6">
		      					<label for="usr">NUMERO:</label>
  								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-paste"></i></span>
									<input type="text" class="form-control" id="NUMERO" maxlength="5">
								</div>
		      				</div>
		      				
		      			</div>
		      		</div>
		      		<hr>
		      		<div class="row">
		      		     <div class="col-md-12">
		      		     	<div class="col-md-6 col-sm-6  col-xs-6">
		      			     <label for="usr">CAPTCHA:</label>
  								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-paste"></i></span>
									<input type="text" class="form-control" id="CAPTCHA" maxlength="6">
								</div>
		      			 	</div>
		      			 	<div class="col-md-6 col-sm-6 col-xs-6 ">
		      			 		<label for="captcha" style="margin-top: 15px;" id="Img_captcha"><?php echo $captcha['image']; ?></label>
		      			 	</div>
		      		     </div>
		      			
		      		</div>
		      		<hr>
		      		<div class="row">
		      			<div class="col-md-12">
		      				<button type="button" class="btn btn-primary form-control" id="BUSCAR">BUSCAR</button>
		      			</div>
		      		</div>
		      		
		      		<div class="row">
		      			<div class="col-md-12 ">
							 <div class="col-md-12" id="Alerta">
							 	<br>
							 </div>
							<br><br>
								<div class="col-md-12" id="tabla">

									<!--<table id="example" class="display" cellspacing="0" width="100%">
								        <thead>
								            <tr>
								            	<th>Correlacion</th>
								                <th>Tipo</th>
								                <th>Serie-Numero</th>
								                <th>Fecha</th>
								                <th>Nombre</th>
								                <th>Dirección</th>
								                <th>Operación</th>
								            </tr>
								        </thead>
								        <tbody>
								            
								        </tbody>
								    </table>-->
								</div>
						</div>
		      		</div>
		      		
		      </div>
		    </div>
		</div>
	</div>
	

	
</div>

<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/mascara.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/fecha/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/fecha/locales/bootstrap-datepicker.es.min.js"></script>
<script src="<?php echo base_url();?>assets/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>
<script type="text/javascript">
 	
	var table = null;
	var rango = "<?php echo $_SESSION['clave']; ?>";
	$(document).ready(function() {
		$('#SERIE').inputmask('Regex', {
                regex:'[0-9]{'+3+'}'
            	});
		$('#NUMERO').inputmask('integer');
		$('#DOCUMENTO').inputmask('Regex', {
                regex:'[0-9]{'+11+'}'
            	});

	    $('#TIPO_DOCUMENTO').change(function(){ 
			if($(this).val()==1){
				$('#DOCUMENTO').inputmask('Regex', {
                regex:'[0-9]{'+11+'}'
            	});
			}
			if($(this).val()==2){
				$('#DOCUMENTO').inputmask('Regex', {
                regex:'[0-9]{'+8+'}'
            	});
			}
			if($(this).val()==3){
				$('#DOCUMENTO').inputmask('Regex', {
                regex:'[0-9]{'+12+'}'
            	});
			}  
		});
	    
	    $('#FECHA').datepicker({
	    	format: 'dd-mm-yyyy',
	    	language: "es",
	    	autoclose: true
	    	
	    });
	   

	    $('#MONTO').inputmask('currency', {
            prefix: "",
            groupSeparator: "",
            allowPlus: false,
            allowMinus: false,
        });


	     $("#BUSCAR").on("click", function(){

            imprimir();
            
        });
	   
	    $("#FECHA").mask("99-99-9999");
	    $("#TIPO_DOCUMENTO").select(function(){
			alert("Texto seleccionado");
		});

	} );

	function imprimir(){
		var documento = $("#DOCUMENTO").val();
		var fecha = $("#FECHA").val();
		var ser = $("#SERIE").val();
		var monto = $("#MONTO").val();
		var nro = $('#NUMERO').val();
		var TipDoc = $('#TIPO_DOCUMENTO').val();
		var TipComp= $('#TIPO_COMPROBANTE').val();
		var captcha = $('#CAPTCHA').val();
		if (documento=="" || fecha=="" || ser=="" || monto=="" || nro=="" || captcha =="") {
			swal({
				  title: "¡Error !",
				  text: "Se encontraron <span style='color:#F00'>Campos<span> vacios.",
				  html: true
				});
		}else{
			
			if( (TipDoc == "1") && (documento.length < 11) ){
				swal({
				  title: "¡Error !",
				  text: "Se ingreso  <span style='color:#F00'>Mal<span> el numero de RUC.",
				  html: true
				});
			}else{
				if( (TipDoc == "2") && (documento.length < 8) ){
					swal({
						  title: "¡Error !",
						  text: "Se ingreso  <span style='color:#F00'>Mal<span> el documento de identidad",
						  html: true
						});
				}else{
					if( (TipDoc == "3") && (documento.length < 12) ){
						swal({
						  title: "¡Error !",
						  text: "Se ingreso  <span style='color:#F00'>Mal<span> el carnet de extranjeria",
						  html: true
						});
					}else{
						
						
						if(captcha == rango){
							swal({
				              title: "Buscando Datos.....",
				              text: "",
				              showConfirmButton: false
				            });
							$.ajax({
						            type: "POST",
						            url: "<?php echo base_url();?>Welcome/buscar?ajax=true",
						            data: {Aruc: documento,
						            	   Afecha: fecha ,
						            	   Aser:ser,
						            	   Anro:nro,
						            	   Amonto:monto,
						            	   Atipo:TipComp
						            	},
						            dataType: 'json',
						            success: function(data) {
						                if(data.result) {
						                    $("#Img_captcha").empty();
						                    rango = data.numero;
						                    $("#Img_captcha").append(data.captcha.image);
						                    //$("#Img_captcha").innerHTML= data.captcha.image ;
						                    console.log(data.captcha.image);
						                    $("#tabla").empty();
						                    var cuerpo="";
						                    for(var i=0; i<data.busqueda.length;i++){
						                    	
						                    	if(data.busqueda[i]['FSCTIPO']==1){
						                    		var tipo="FACTURA";
						                    	}else{
						                    		var tipo="BOLETA";
						                    	}

						                    	cuerpo =cuerpo + "<tr><td>"+tipo+"</td><td>"+data.busqueda[i]['SUNSERNRO']+"-"+data.busqueda[i]['SUNFACNRO']+"</td><td>"+data.busqueda[i]['FSCFECH']+ "</td><td>" + data.busqueda[i]['FSCCLINOMB'] + "</td><td>" +
						                    	 	data.busqueda[i]['FSDIREC']+ "</td><td>"+data.busqueda[i]['FSCTOTAL']+"</td><td><a href='https://dcsvpsws02.sedalib.com.pe/GeneSys/"+data.busqueda[i]['DIRARCHPDF']+"'  class='btn btn-default btn-flat' TARGET='_blank' ><i class='fa fa-print'></i></a><a TARGET='_blank' class='btn btn-default btn-flat' href='https://dcsvpsws02.sedalib.com.pe/GeneSys/"+data.busqueda[i]['DIRARCHWS']+"' ><i class='fa fa-ticket'></i></a></td></tr>";
						                      
						                    }
						                    $("#Alerta").empty();
						                    $("#Alerta").append("<br><div class='alert alert-success'><strong>Bien Hecho !!</strong> Se obtuvo Resultados</div>");
						                     $("#tabla").append("<br> <table id='recibos' class='table table-striped' ><thead class='thead-inverse ' ><tr><th>Tipo</th><th>Serie-Numero</th><th>Fecha</th><th>Nombre</th><th>Dirección</th><th>MONTO</th><th>Operación</th></tr></thead><tbody >"+cuerpo+"</tbody></table>");
						                     
						                    swal.close();
						                    return true;
						                }else{
						                	 $("#tabla").empty();
						                     $("#Alerta").empty();
						                     $("#Alerta").append("<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong>No se obtuvieron Resultados</div>");
						                    
						                     swal.close();
						                    
							                }
							            }
							    });
						}else{
							swal({
							  title: "¡Error !",
							  text: "No Coincide el  <span style='color:#F00'>Codigo<span> captcha",
							  html: true
							});
						}
						
					}
				}

			}


			
		}
		//console.log(ruc,fecha,sernro,monto);
	}
</script>
</body>
</html>