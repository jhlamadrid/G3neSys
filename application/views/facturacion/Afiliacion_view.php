<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<section class="content">
    <form method="post" action="<?php echo $this->config->item('ip').'facturacion/afiliacion_pdf' ?>"  class="form-horizontal">

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 col-offset-1">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h4 class="text-center">SOLICITUD DE AFILIACIÓN Y DESAFILIACIÓN AL RECIBO DIGITAL POR CORREO ELECTRÓNICO</h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                         Señores de  SEDALIB , por la presente acepto la :
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-3">
                                    <div class="form-check">
                                      Afiliación
                                      <input class="form-check-input" type="radio" name="afilia" id="radio" value="afiliacion" checked>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                     <div class="form-check">
                                      Desafiliación
                                      <input class="form-check-input" type="radio" name="afilia" id="radio" value="desafiliacion" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                         Tipo de Persona:
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-3 col-md-offset-1">
                                    <div class="form-check">
                                      Natural
                                      <input class="form-check-input" type="radio" name="tipo_per" id="natural" value="natural" checked>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                     <div class="form-check">
                                      Juridica
                                      <input class="form-check-input" type="radio" name="tipo_per" id="natural" value="juridica" >
                                    </div>
                                </div>
                                </div>
                                
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        Suministro:
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <input type="text" id="suministro"  name="suministro" class="form-control"  placeholder="Suministro" style="width:100%;" required>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" id="buscar_suministro" class="btn  btn-block btn-primary btn-flat" style="height:25; margin-top:-5px;" >Buscar</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        Nombres y Apellidos del Titular de la Conexión<sup>(1)</sup>:
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="nombre" name="dato_apellido" placeholder="Nombres y Apellidos" style="width:100%;" readonly >
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-12">
                                    <div class="col-md-12" >
                                         Nro.DNI/C. Ident. / C. Extranj. / RUC:    
                                    </div> 
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="documento" name="documento" placeholder="Documento de identificación" style="width:100%;"  readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-12">
                            
                                    <div class="col-md-6">
                                        Teléfono fijo:
                                    </div>
                                    <div class="col-md-6">
                                        Celular:
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" style="width:100%;"  readonly maxlength="9">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="celular" name="celular"  placeholder="Celular" style="width:100%;"  readonly required maxlength="9">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                             <div class="col-md-12">
                                  <div class="col-md-6">
                                      Corre Electrónico:
                                  </div>
                                  <div class="col-md-6">
                                      Correo Electrónico alterno<sup>(2)</sup>:
                                  </div>
                             </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                             <div class="col-md-12">
                                  <div class="col-md-6">
                                      <input type="email" class="form-control" id="correo1" name="correo1"  placeholder="correo 1" style="width:100%;" readonly required>
                                  </div>
                                  <div class="col-md-6">
                                     <input type="email" class="form-control" id="correo2" name="correo2"  placeholder="correo 2" style="width:100%;" readonly>
                                  </div>
                             </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                             <div class="col-md-12">
                                  <div class="col-md-6">
                                      Dirección Web <sup>(3)</sup>:
                                  </div>
                                  <div class="col-md-6">
                                      Twiter<sup>(3)</sup>:
                                  </div>
                             </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                             <div class="col-md-12">
                                  <div class="col-md-6">
                                      <input type="text" class="form-control" id="direccion1" name="direccion1"  placeholder="Dirección Web" style="width:100%;" readonly>
                                  </div>
                                  <div class="col-md-6">
                                     <input type="text" class="form-control" id="twitter" name="twitter"  placeholder="Twiter" style="width:100%;" readonly>
                                  </div>
                             </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                             <div class="col-md-12">
                                  <div class="col-md-6">
                                      Facebook <sup>(3)</sup>:
                                  </div>
                                  <div class="col-md-6">
                                      WhatsApp<sup>(3)</sup>:
                                  </div>
                             </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                             <div class="col-md-12">
                                  <div class="col-md-6">
                                      <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook" style="width:100%;" readonly>
                                  </div>
                                  <div class="col-md-6">
                                     <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="WhatsApp" style="width:100%;" readonly>
                                  </div>
                             </div>
                            </div>
                            <!--<div class="row" style="margin-top:15px">
                                <div class="col-md-12">
                                    <div class="col-md-1">
                                        Firma :    
                                    </div>
                                    <div class="col-md-3" style="border-bottom: 1px solid #000;  height: 17px;">
                                            
                                    </div>
                                </div>
                            </div>-->
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success btn-block btn-flat" id="formulario"  readonly>
                    GENERAR SOLICITUD
                </button>
                
            </div>
        </div><br>
    </form>
</section>
<script>
    $("#suministro").keydown(function(event) {
	   if(event.shiftKey)
	   {
	        event.preventDefault();
	   }

	   if (event.keyCode == 46 || event.keyCode == 8)    {
	   }
	   else {
	        if (event.keyCode < 95) {
	          if (event.keyCode < 48 || event.keyCode > 57) {
	                event.preventDefault();
	          }
	        } 
	        else {
	              if (event.keyCode < 96 || event.keyCode > 105) {
	                  event.preventDefault();
	              }
	        }
	      }
	   });
    $("#documento").keydown(function(event) {
     if(event.shiftKey)
     {
          event.preventDefault();
     }

     if (event.keyCode == 46 || event.keyCode == 8)    {
     }
     else {
          if (event.keyCode < 95) {
            if (event.keyCode < 48 || event.keyCode > 57) {
                  event.preventDefault();
            }
          } 
          else {
                if (event.keyCode < 96 || event.keyCode > 105) {
                    event.preventDefault();
                }
          }
        }
     });
    $("#whatsapp").keydown(function(event) {
     if(event.shiftKey)
     {
          event.preventDefault();
     }

     if (event.keyCode == 46 || event.keyCode == 8)    {
     }
     else {
          if (event.keyCode < 95) {
            if (event.keyCode < 48 || event.keyCode > 57) {
                  event.preventDefault();
            }
          } 
          else {
                if (event.keyCode < 96 || event.keyCode > 105) {
                    event.preventDefault();
                }
          }
        }
     });
     $("#telefono").keydown(function(event) {
	   if(event.shiftKey)
	   {
	        event.preventDefault();
	   }

	   if (event.keyCode == 46 || event.keyCode == 8)    {
	   }
	   else {
	        if (event.keyCode < 95) {
	          if (event.keyCode < 48 || event.keyCode > 57) {
	                event.preventDefault();
	          }
	        } 
	        else {
	              if (event.keyCode < 96 || event.keyCode > 105) {
	                  event.preventDefault();
	              }
	        }
	      }
	   });
    $("#celular").keydown(function(event) {
	   if(event.shiftKey)
	   {
	        event.preventDefault();
	   }

	   if (event.keyCode == 46 || event.keyCode == 8)    {
	   }
	   else {
	        if (event.keyCode < 95) {
	          if (event.keyCode < 48 || event.keyCode > 57) {
	                event.preventDefault();
	          }
	        } 
	        else {
	              if (event.keyCode < 96 || event.keyCode > 105) {
	                  event.preventDefault();
	              }
	        }
	      }
	   });
    $( "#buscar_suministro" ).click(function() {
          var valor= document.getElementById("suministro").value;
          //alert($('input:radio[name=afilia]:checked').val());
          var estado=$('input:radio[name=afilia]:checked').val();
          if(valor.length==7){
                var inicio = valor.substring(0, 3);
                var final=valor.substring(3,7 );
                valor=inicio + "0000" + final;
            }
          if(valor==''){
                swal("Atención!", "Ingrese el numero de suminstro a buscar")
            }
          else{
                $.ajax({
                  type: 'POST',
                  url : '<?php echo $this->config->item('ip'); ?>Atencion_al_cliente/busca_sumi?ajax=true',
                  data: ({
                    suministro : valor,
                    estado_cliente: estado,
                  }),
                  cache: false,
                  dataType: 'json',
                  success: function(data){
                    if(data.result){
                        if(data.estado == 0)
                        {
                            cliente=data.dato_general;
                            $('#buscar_suministro').prop('disabled', true);
                            $('#suministro').prop('readonly', true);
                            $('#telefono').prop('readonly', false);
                            $('#celular').prop('readonly', false);
                            $('#correo1').prop('readonly', false);
                            $('#correo2').prop('readonly', false);
                            $('#direccion1').prop('readonly', false);
                            $('#twitter').prop('readonly', false);
                            $('#facebook').prop('readonly', false);
                            $('#whatsapp').prop('readonly', false);
                            $('#formulario').prop('readonly', false);
                            // para el nombre
                            var i=0;
                            var nombre='';
                            var recorro= String(cliente[0]['CLINOMBRE']);
                            while(i<recorro.length){
                               if(!(recorro.charCodeAt(i)>=48 && recorro.charCodeAt(i)<=57) ){
                                 nombre= nombre.concat(recorro.charAt(i));
                               }

                                i=i+1;
                            }
                            document.getElementById('nombre').value =nombre ;
                            // para el documento
                            var tipo_per=$('input:radio[name=tipo_per]:checked').val();
                            if (tipo_per=="natural" && cliente[0]['CLIELECT'] !=null) {
                                document.getElementById('documento').value =cliente[0]['CLIELECT'];
                                $('#documento').prop('readonly',false);
                            }
                            else{
                               if(tipo_per=="juridica" && cliente[0]['CLIRUC'] !=null){
                                  document.getElementById('documento').value =cliente[0]['CLIRUC'];
                                  $('#documento').prop('readonly',false);
                               }else{
                                  $('#documento').prop('readonly',false);
                               }
                               
                            }
                            if(cliente[0]['CLIELECT'] ==null && cliente[0]['CLIRUC']==null){
                              $('#documento').prop('readonly',false);  
                            }
                            // telefono
                            if (cliente[0]['CLICOBTEL'] !="0"){
                                    document.getElementById('telefono').value =cliente[0]['CLICOBTEL'] ;      
                            }
                        }else{
                          if(data.estado == 1){
                             // quiero desafiliar usuario
                              cliente=data.usuario_afiliado;
                              $('#buscar_suministro').prop('disabled', true);
                              $('#suministro').prop('readonly', true);
                              $('#nombre').prop('readonly', true);
                              $('#telefono').prop('readonly', true);
                              $('#celular').prop('readonly', true);
                              $('#correo1').prop('readonly', true);
                              $('#correo2').prop('readonly', true);
                              $('#direccion1').prop('readonly', true);
                              $('#twitter').prop('readonly', true);
                              $('#facebook').prop('readonly', true);
                              $('#whatsapp').prop('readonly', true);
                              $('#formulario').prop('readonly', false);
                              document.getElementById('suministro').value=cliente[0]['CLICODFAC'];
                              document.getElementById('documento').value=cliente[0]['CLIDOCIDENT'];
                              document.getElementById('telefono').value=cliente[0]['CLITELEF'];
                              document.getElementById('nombre').value=cliente[0]['CLINOM'];
                              document.getElementById('celular').value=cliente[0]['CLICEL'];
                              document.getElementById('correo1').value=cliente[0]['CLIEMAIL1'];
                              document.getElementById('correo2').value=cliente[0]['CLIEMAIL2'];
                              document.getElementById('direccion1').value=cliente[0]['CLIDIRWEB'];
                              document.getElementById('twitter').value=cliente[0]['CLITWITTER'];
                              document.getElementById('facebook').value=cliente[0]['CLIFACEBOOK'];
                              document.getElementById('whatsapp').value=cliente[0]['CLIWHATSAPP'];
                          }
                          if(data.estado == 2){
                             // quiero desafiliar usuario
                              cliente=data.usuario_afiliado;
                              $('#buscar_suministro').prop('disabled', true);
                              $('#suministro').prop('readonly', true);
                              $('#nombre').prop('readonly', true);
                              $('#telefono').prop('readonly', false);
                              $('#celular').prop('readonly', false);
                              $('#correo1').prop('readonly', false);
                              $('#correo2').prop('readonly', false);
                              $('#direccion1').prop('readonly', false);
                              $('#twitter').prop('readonly', false);
                              $('#facebook').prop('readonly', false);
                              $('#whatsapp').prop('readonly', false);
                              $('#formulario').prop('readonly', false);
                              document.getElementById('suministro').value=cliente[0]['CLICODFAC'];
                              document.getElementById('documento').value=cliente[0]['CLIDOCIDENT'];
                              document.getElementById('telefono').value=cliente[0]['CLITELEF'];
                              document.getElementById('nombre').value=cliente[0]['CLINOM'];
                              document.getElementById('celular').value=cliente[0]['CLICEL'];
                              document.getElementById('correo1').value=cliente[0]['CLIEMAIL1'];
                              document.getElementById('correo2').value=cliente[0]['CLIEMAIL2'];
                              document.getElementById('direccion1').value=cliente[0]['CLIDIRWEB'];
                              document.getElementById('twitter').value=cliente[0]['CLITWITTER'];
                              document.getElementById('facebook').value=cliente[0]['CLIFACEBOOK'];
                              document.getElementById('whatsapp').value=cliente[0]['CLIWHATSAPP'];
                          }
                        }
                        
                        
                        
                    
                        //console.log(data.direccion);
                        
                    }
                    else{
                       swal("", data.mensaje + " ..", "error"); 
                    }
                    
                  }, error : function(jqHRX, textStatus, errorThrown){
                    swal("", "Ocurrió un problema con el Servidor", "error");
                    $('#pdf').empty();
                  }
                });
          }
        });
</script>