<link rel="stylesheet" href="<?php echo $this->config->item('ip');  ?>frontend/plugins/sweetalert/sweetalert2.css" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<section class="content">
 <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 col-offset-1">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h4 class="text-center">VER CASOS ATIPICOS</h4>
                        </div>
                        <div class="box-body">
                            
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        Suministro:
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input type="text" id="suministro"  name="suministro" class="form-control"  placeholder="Suministro" style="width:100%;" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <button type="button" id="buscar_atipico" class="btn  btn-block btn-primary btn-flat" style="height:25; margin-top:-5px;" >Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="row" id="detallado">
                                     <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                        NOMBRE
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control" id="NOMBRE" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                        DIRECCIÓN
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control" id="DIRECCION" value="" disabled>
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                        SUMINISTRO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  value="" id="SUMINISTRO" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                        ESTADO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  id="ESTADO" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                        TIP.SERVICIO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control" id="TIP_SERVICIO" value="" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:140px">
                                                        CICLO COMERCIAL
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  value="" id="C_COMERCIAL" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                        GRUPO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  id="GRUPO" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:100px">
                                                      MEDIDOR
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control" id="MEDIDOR" value="" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:150px">
                                                        CONEX. AGUA
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  value="" id="CONEX_AGUA" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" style="width:150px">
                                                        CONEX. DESAGUE
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  id="CONEX_DESAGUE" value="" disabled>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                
                                <div class="col-md-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12" id="pdf">
                                        
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
<script type="text/javascript">
    $( "#buscar_atipico" ).click(function() {
      $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>atipico/buscar?ajax=true",
            data: {
                suministro: $("#suministro").val().trim()
            },
            dataType: 'json',
            beforeSend: function(){
                       $('#pdf').empty();
                       $("#pdf").append("<img src='<?php echo $this->config->item('ip'); ?>img/loading.gif' style='margin-left:45%;  margin-top:10%;' />");
                   },
            success: function(data) {
                //alert(data.result);
                if(data.result) {

                  $('#pdf').empty();
                  
                  if(data.tam == 11){
                    $("#NOMBRE").val(data.deta_atipico.NOMBRE);
                    $("#DIRECCION").val(data.deta_atipico.DIRECCION);
                    $("#SUMINISTRO").val(data.deta_atipico.CLICODFAC);
                    $("#ESTADO").val(data.deta_atipico.ESTADOCLI);
                    $("#TIP_SERVICIO").val(data.deta_atipico.TIPOSERVICIO);
                    $("#C_COMERCIAL").val(data.deta_atipico.CICLO);
                    $("#GRUPO").val(data.deta_atipico.GRUPO);
                    $("#MEDIDOR").val(data.deta_atipico.MEDIDOR);
                    $("#GRUPO").val(data.deta_atipico.GRUPO);
                    $("#CONEX_AGUA").val(data.deta_atipico.ESTADOCONXAG);
                    $("#CONEX_DESAGUE").val(data.deta_atipico.CONDESDES);
                  }else{
                    if(data.tam == 7){
                        $("#NOMBRE").val(data.data_nombre.CLINOMBRE);
                        $("#DIRECCION").val(data.deta_atipico.DIRECCION);
                        $("#SUMINISTRO").val(data.deta_atipico.CLICODFAC);
                        $("#ESTADO").val(data.deta_atipico.ESTADOCLI);
                        $("#TIP_SERVICIO").val(data.deta_atipico.TIPOSERVICIO);
                        $("#C_COMERCIAL").val(data.deta_atipico.CICLO);
                        $("#GRUPO").val(data.deta_atipico.GRUPO);
                        $("#MEDIDOR").val(data.deta_atipico.MEDIDOR);
                        $("#GRUPO").val(data.deta_atipico.GRUPO);
                        $("#CONEX_AGUA").val(data.deta_atipico.ESTADOCONXAG);
                        $("#CONEX_DESAGUE").val(data.deta_atipico.CONDESDES);
                    }
                  }

                  var cuerpo="";
                  var i=0;
                  var bandera = 0 ;
                  var meses = [] ;
                  meses[1] = 'ENERO';
                  meses[2] = 'FEBRERO';
                  meses[3] = 'MARZO';
                  meses[4] = 'ABRIL';
                  meses[5] = 'MAYO';
                  meses[6] = 'JUNIO';
                  meses[7] = 'JULIO';
                  meses[8] = 'AGOSTO';
                  meses[9] = 'SEPTIEMBRE';
                  meses[10] = 'OCTUBRE';
                  meses[11] = 'NOVIEMBRE';
                  meses[12] = 'DICIEMBRE';
                  while(data.rpta.length >i){
                    var dato_periodo = data.rpta[i].PERIODO;
                    var mes_facturacion =parseInt (dato_periodo.substring(4 , data.rpta[i].PERIODO.length ) );
                    if((mes_facturacion+1)==13){
                        mes_facturacion = 0;
                    }
                    cuerpo =cuerpo + "<tr><td>" + data.rpta[i].CLICODFAC + "</td><td>"+data.rpta[i].PERIODO+"</td><td>"+meses[mes_facturacion + 1]+"</td><td><a href='<?php echo $this->config->item('ip');?>atipico/verificar_detalle/"+data.rpta[i].CLICODFAC+"/"+data.rpta[i].PERIODO+"'><button class= 'btn btn-primary'>VER DETALLE</button></a></td></tr>";
                    bandera = 1;
                    i=i+1;
                  }
                  var i=0;
                  while(data.atipico_siac.length >i){
                    var dato_periodo =data.atipico_siac[i].PERIODO;
                    var mes_facturacion =parseInt (dato_periodo.substring(4 , data.atipico_siac[i].PERIODO.length ) );
                    if((mes_facturacion+1)==13){
                        mes_facturacion = 0;
                    }
                    cuerpo =cuerpo + "<tr><td>" + data.atipico_siac[i].CLICODFAC + "</td><td>"+data.atipico_siac[i].PERIODO+"</td><td>"+meses[mes_facturacion + 1]+"</td><td><a href='<?php echo $this->config->item('ip');?>atipico/verificar_detalle_SIAC/"+data.atipico_siac[i].CLICODFAC+"/"+data.atipico_siac[i].CICLO+"/"+data.atipico_siac[i].PERIODO+"'><button class= 'btn btn-primary'>VER DETALLE</button></a></td></tr>";
                    bandera = 1;
                    i=i+1;
                  }
                  $('#pdf').append("<br><div class='row'><div class='col-md-12'> <div class='col-md-12'> <table id='recibos' class='table table-bordered table-striped'><thead><tr role='row'><th>SUMINISTRO</th><th>PERIODO</th><th>FACTURACIÓN</th><th>OPCIONES</th></tr></thead><tbody >"+cuerpo+"</tbody></table></div></div></div>");
                  var recibos = $('#recibos').DataTable({ bInfo: false,bFilter: true,bSort:false});
                  console.log(bandera);
                  if (bandera == 0) {
                    swal(
                      '¡ALERTA!',
                      '¡ NO SE ENCONTRARON REGISTROS ATIPICOS !',
                      'error'
                    ); 
                  }

                    return true;
                }else{
                   // return false;
                   $('#pdf').empty();
                   swal(
                      '¡ALERTA!',
                      data.mensaje,
                      'error'
                    );
                }
            }
        });
    });

    function detalle(suministro){
        
        //alert(suministro);
        window.location="<?php echo $this->config->item('ip'); ?>atipico/verificar_detalle/"+suministro;
    }
</script>