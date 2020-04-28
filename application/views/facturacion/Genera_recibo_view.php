<!-- sweetAlert. -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/dist/css/estilos_detalle_recibo.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 

<section class="content">
    <div class="row">
        <div class="col-md-12 text-blue" style="font-size: 24px; text-align: center">
            <label>Genera Recibo</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12" id="alerta">
                </div>
            </div>
            <div class="box  box-success">
                <!--datos de nuevo usuario-->
                <div class="box-header with-border">
                    <div class="col-md-6 col-sm-9">
                        <h1 class="box-title"><?php echo $titulo; ?></h1>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                              <input class="form-control" id="suministro"  maxlength="12" placeholder="Escriba el codigo de suministro">  
                            </div>
                            <div class="col-md-6 ">
                                <button class="btn btn-info" id="buscar">
                                    BUSCAR
                                </button>
                                <!--<a target="_blank" href="http://150.10.9.48/Enlace/Genera_recibo/recibo/10010003020/43434/2323" class="home-link">
                                    Descargar recibo
                                </a>-->
                            </div>
                        </div>
                    </div> 
                    <div class="row" >
                        <div class="col-md-12" id="pdf">
                            <h2 style="text-align:center">    DESCRIPCIÓN DE LAS PARTES DEL RECIBO</h2>
                          <div class="col-md-9 col-md-offset-2"> 
                            <div class="mapa_imagen">
                              <img src="<?php echo $this->config->item('ip'); ?>img/recibo_completo.png"  />
                                <div class="sec1 ">
                                  <div id="nota1" class="not1 " ><p class="oval-thought-border">Numero de recibo y código de suministro</p></div>
                                </div>
                               <div class="sec2 ">
                                <div id="nota2" class="not2 " ><p >Mes y fecha de emision</p></div>
                                </div>
                              <div class="sec3">
                                <div id="nota3" class="not3  " ><p  >Grafico de consumo</p></div>
                              </div>
                              <div class="sec4">
                                <div id="nota4" class="not4  " ><p  >Logo</p></div>
                              </div>
                              <div class="sec5">
                                <div id="nota5" class="not5 " ><p  >Datos de Cliente</p></div>
                              </div>
                              <div class="sec6">
                                <div id="nota6" class="not6 " ><p  >Detalle de concepto Facturacion</p></div>
                              </div>
                              <div class="sec7">
                                <div id="nota7" class="not7  " ><p  >Codigo de Barra</p></div>
                              </div>
                              <div class="sec8">
                                <div id="nota8" class="not8  " ><p  >Avisos de la empresa</p></div>
                              </div>
                              <div class="sec9">
                                <div id="nota9" class="not9  " ><p  >Fecha de vencimiento</p></div>
                              </div>
                              <div class="sec10">
                                <div id="nota10" class="not10  "><p  >  Mes y monto total</p></div>
                              </div>
                              <div class="sec11">
                                <div id="nota11" class="not11  " ><p  > Codigo de usuario</p></div>
                              </div>
                              <div class="sec12">
                                <div id="nota12" class="not12 " ><p  > Ruta</p></div>
                              </div>
                               <div class="sec13">
                                <div id="nota13" class="not13  " ><p  >Datos de lectura y consumo</p></div>
                              </div>
                              <div class="sec14">
                                <div id="nota14" class="not14  " ><p  >Código catastral</p></div>
                              </div>
                              <div class="sec15">
                                <div id="nota15" class="not15 " ><p >Ciclo de facturación</p></div>
                              </div>

                            </div> 
                          </div>

                        </div>
                    </div>
                     
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script>
  //$('#recibos').DataTable({ bInfo: false,bFilter: true,"ordering": false,"lengthMenu": [[5, 20, 50, 100, -1],[5, 20, 50, 100, "Todos"]],});
  
</script>
<script>
  
$( "#buscar" ).click(function() {
  var valor= document.getElementById("suministro").value;
  if(valor==''){
        swal("Atención!", "Ingrese el numero de suminstro a buscar")
    }
  else{
        $.ajax({
          type: 'POST',
          url : '<?php echo $this->config->item('ip'); ?>facturacion/grafico_pdf?ajax=true',
          data: ({
            suministro : valor,
          }),
          cache: false,
          dataType: 'json',
          beforeSend: function(){
                       $('#alerta').empty();
                       $('#pdf').empty();
                       $("#pdf").append("<img src='<?php echo $this->config->item('ip'); ?>./img/loading.gif' style='margin-left:45%;  margin-top:10%;' />");
                   },
          success: function(data){
            //console.log(data.direccion);
            if(data.result){
              //console.log(data.dato_meses[0].DESMES);
              $('#pdf').empty();
              var cuerpo="";
              var i=0;
              while(data.dato_meses.length >i){
                cuerpo =cuerpo + "<tr><td>" + data.dato_meses[i].PERIODO + "</td><td>"+data.dato_meses[i].CLINOMBRE+"</td><td>"+data.dato_meses[i].CLICODFAX+"</td><td>"+data.dato_meses[i].DESMES+"</td><td>"+data.dato_meses[i].PERIODO.substring(0, 4) +"</td><td><a target='_blank' href='<?php echo $this->config->item('ip'); ?>"+"facturacion/creo_recibo/"+data.dato_meses[i].CLICODFAX.trim()+"/"+data.dato_meses[i].PERIODO+"' ><button>Recibo con Fondo</button></a><a target='_blank' href='<?php echo $this->config->item('ip'); ?>"+"facturacion/creo_recibo_a4/"+data.dato_meses[i].CLICODFAX.trim()+"/"+data.dato_meses[i].PERIODO+"' ><button>Recibo Fondo A4(I)</button></a></td></tr>";
                i=i+1;
              }
              $('#pdf').append("<br><div class='row'><div class='col-md-12'> <div class='col-md-12'> <table id='recibos' class='table table-bordered table-striped'><thead><tr role='row'><th>PERIODO</th><th>NOMBRE</th><th>SUMINISTRO</th><th>MES</th><th>AÑO</th><th>GENERA DOCUMENTO</th></tr></thead><tbody >"+cuerpo+"</tbody></table></div></div></div>");
              var recibos = $('#recibos').DataTable({ bInfo: false,bFilter: true,bSort:false});
            /*   $('#pdf').empty(); 
                $('#pdf').append("<embed src='<?php echo base_url(); ?>"+data.direccion+"#zoom=150' style='width:100%;  height:850px;margin-top:5%;'>");
                $('#alerta').empty();
                $('#alerta').append("<div class='alert alert-success alert-dismissable fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Exito!</strong>Se genero exitosamente el PDF</div>");   */
            }
            else{
               $('#pdf').empty();
               swal("", data.mensaje, "error");    
            }
            
            
          }, error : function(jqHRX, textStatus, errorThrown){
            swal("", "Ocurrió un problema con el Servidor", "error");
            $('#pdf').empty();
          }
        });
  }
});
 //$('#suministro').inputmask('integer');  
    
</script>