<!-- sweetAlert. -->

<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script> 

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
                            <div class="col-md-4">
                              <input class="form-control" id="cantidad"  maxlength="12" placeholder="cantidad">  
                            </div>
                            <div class="col-md-4">
                              <select class="form-control" id="periodo">
                                <option value="201701">Enero</option>
                                <option value="201702">Febrero</option>
                                <option value="201703">Marzo</option>
                                <option value="201704">Abril</option>
                                <option value="201705">Mayo</option>
                                <option value="201706">Junio</option>
                                <option value="201707">Julio</option>
                                <option value="201708">Agosto</option>
                                <option value="201709">Septiembre</option>
                                <option value="201710">Octubre</option>
                                <option value="201711">Noviembre</option>
                                <option value="201712">Diciembre</option>
                              </select>  
                            </div>
                            <div class="col-md-4 ">
                                <button class="btn btn-info" id="buscar">
                                    BUSCAR
                                </button>
                                
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                      <div id="pdf">
                        
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
  function ajax_recursivo(inicio,fin){
     $.ajax({
          type: 'POST',
          url : '<?php echo $this->config->item('ip'); ?>facturacion/grafico_pdf?ajax=true',
          data: ({
            inicio : inicio,
            fin : fin
          }),
          cache: false,
          dataType: 'json',
          beforeSend: function(){
                       
                       $('#pdf').empty();
                       $("#pdf").append("<img src='<?php echo $this->config->item('ip'); ?>./img/loading.gif' style='margin-left:45%;  margin-top:10%;' />");
                   },
          success: function(data){
            if(data.result){
              $('#pdf').empty();
            }else{
              
            }
          },
          error : function(jqHRX, textStatus, errorThrown){
            swal("", "Ocurrió un problema con el Servidor", "error");
            $('#pdf').empty();
          }
          });

  }

$( "#buscar" ).click(function() {
  
  var cantidad = $("#cantidad").val();
  var periodo = $("#periodo").val();
  console.log("-->"+ cantidad + "-->" + periodo);
  $("#cantidad").prop("readonly",true);
  ajax_recursivo(1,3);
       /* $.ajax({
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
                cuerpo =cuerpo + "<tr><td>" + data.dato_meses[i].PERIODO + "</td><td>"+data.dato_meses[i].CLINOMBRE+"</td><td>"+data.dato_meses[i].CLICODFAX+"</td><td>"+data.dato_meses[i].DESMES+"</td><td>"+data.dato_meses[i].PERIODO.substring(0, 4) +"</td><td><a target='_blank' href='<?php echo $this->config->item('ip'); ?>"+"facturacion/creo_recibo/"+data.dato_meses[i].CLICODFAX.trim()+"/"+data.dato_meses[i].PERIODO+"' ><button>Recibo con Fondo</button></a><a target='_blank' href='<?php echo $this->config->item('ip'); ?>"+"facturacion/creo_recibo/1/"+data.dato_meses[i].CLICODFAX.trim()+"/"+data.dato_meses[i].PERIODO+"' ><button>Recibo sin Fondo</button></a></td></tr>";
                i=i+1;
              }
              $('#pdf').append("<br><div class='row'><div class='col-md-12'> <div class='col-md-12'> <table id='recibos' class='table table-bordered table-striped'><thead><tr role='row'><th>PERIODO</th><th>NOMBRE</th><th>SUMINISTRO</th><th>MES</th><th>AÑO</th><th>GENERA DOCUMENTO</th></tr></thead><tbody >"+cuerpo+"</tbody></table></div></div></div>");
              var recibos = $('#recibos').DataTable({ bInfo: false,bFilter: true,bSort:false});
           
            }
            else{
               $('#pdf').empty();
               swal("", data.mensaje, "error");    
            }
            
            
          }, 
          error : function(jqHRX, textStatus, errorThrown){
            swal("", "Ocurrió un problema con el Servidor", "error");
            $('#pdf').empty();
          }
        });*/
  
});

</script>