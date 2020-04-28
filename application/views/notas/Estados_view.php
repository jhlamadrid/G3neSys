<section class="content">
  <div class="row">
    <div class="col-md-12">
      <h2 style="font-family:'Ubuntu'" class="text-red text-center">ESTADOS DE LAS NOTAS DE CRÉDITO</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
              <div class="input-group" style="margin-top:5px">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:120px">TIPO DOCUMENTO</button>
                </div>
                <select class="form-control" id="documento" >
                  <option value="1">NOTA CRÉDITO</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="input-group" style="margin-top:5px">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">FECHA INICIO</button>
                </div>
                <input type="text" class="form-control" id="fecha_inicio" value="<?php echo date('d/m/Y') ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="input-group" style="margin-top:5px">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">FECHA FIN</button>
                </div>
                <input type="text" class="form-control" id="fecha_fin" value="<?php echo date('d/m/Y') ?>">
              </div>
            </div>
            <div class="col-md-3">
              <a onclick="buscar_notas()" class="btn btn-success btn-block">BUSCAR</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <a onclick="envio_masivo()" class="btn btn-warning"> <i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp; ENVIAR MASIVAMENTE NOTAS CRÉDITO</a>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="notas_credito" class="table table-bordered table-striped">
                  <thead>
                    <tr role="row">
                      <th>SERIE NOTA</th>
                      <th>N° NOTA</th>
                      <th>DOCUMENTO</th>
                      <th>SUNAT</th>
                      <th>FECHA EMISIÓN</th>
                      <th>MONTO</th>
                      <th>ESTADO</th>
                      <th>OPCIONES</th>
                    </tr>
                  </thead>
                  <tbody id='cuerpo_notas'>
                    <?php foreach ($notas as $nota) { ?>
                      <tr>
                        <td><?php echo $nota['BFNCATLET'].$nota['BFNCASERNRO'] ?></td>
                        <td><?php echo $nota['BFNCANRO'] ?></td>
                        <td><?php echo (($nota['BFSFACTIPC'] == 0) ? "<b>BOLETA</b>" : "<b>FACTURA</b>"); echo ": ".$nota['SFACTURA_FSCSERNRO']."-".$nota['SFACTURA_FSCNRO']; ?></td>
                        <td><?php echo $nota['BFNCASUNSERNRO']."-".$nota['BFNCASUNFACNRO']; ?></td>
                        <td><?php echo $nota['BFNCAFECHEMI']." ".$nota['BFNCAHRAEMI']?></td>
                        <td style="text-align:right"><?php echo number_format($nota['BFNCATOTDIF'],2,'.',''); ?></td>
                        <td style="text-align:center"><?php if($nota['BFNCAESTSUN'] == 1) { echo "<span class='badge bg-yellow'>EMITIDA</span>"; } else if($nota['BFNCAESTSUN'] == 3) { echo "<span class='badge bg-green'>ACEPTADA</span>"; }
                        else if($nota['BFNCAESTSUN'] == 4){echo "<span class='badge bg-red'>RECHAZADO</span>"; } else if($nota['BFNCAESTSUN'] == 5) { echo "<span class='badge bg-gray'>OBSERVADO</span>";}
                        else if($nota['BFNCAESTSUN'] == 6) { echo "<span class='badge bg-orange'>NO ATENDIDO</span>";}?></td>
                        <td style="text-align:center">
                          <a onclick="visualizar_detalle_nota_credito('<?php echo $nota['BFNCATIPO'] ?>','<?php echo $nota['BFNCATLET'] ?>',<?php echo intval($nota['BFNCASERNRO'])*958 ?>,<?php echo intval($nota['BFNCANRO'])*235 ?>)" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="VISUALIZAR NOTA CRÉDITO">
                            <i class="fa fa-eye"></i>
                          </a>
                          <?php if($nota['BFSFACDIRARCHPDF']) { ?>
                            <a class="btn btn-default" href="<?php echo base_url().$nota['BFSFACDIRARCHPDF'] ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="IMPRIMIR NOTA CRÉDITO">
                              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </a>
                          <?php } ?>
                          <?php if($nota['BFNCAESTSUN'] == 6) { ?>
                            <a class="btn btn-default" onclick="enviar_sunat('<?php echo $nota['BFNCATIPO'] ?>','<?php echo $nota['BFNCATLET'] ?>','<?php echo $nota['BFNCASERNRO'] ?>','<?php echo $nota['BFNCANRO'] ?>')"  target="_blank" data-toggle="tooltip" data-placement="bottom" title="ENVIAR SUNAT">
                              <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                            </a>
                          <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="detalleNC" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <h4 class="modal-title text-info" style="font-family:'Ubuntu'">DETALLE DE LA NOTA DE CRÉDITO <span id='deta_serie'></span>-<span id='deta_numero'></span></h4>
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-3">
            <div class="input-group pull-right">
              <div class="input-group-btn">
                <button type="button" style="width:100px" class="btn btn-success">SUBTOTAL: </button>
              </div>
              <input type="text" class="form-control" id='deta_sub_total' style="text-align:right">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group pull-right">
              <div class="input-group-btn">
                <button type="button" style="width:100px" class="btn btn-success">IGV: </button>
              </div>
              <input type="text" class="form-control" id='deta_igv' style="text-align:right">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group pull-right">
              <div class="input-group-btn">
                <button type="button" style="width:100px" class="btn btn-success">TOTAL: </button>
              </div>
              <input type="text" class="form-control" id='deta_monta' style="text-align:right">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="box box-success">
          <div class="box-header with-border">
            <div class="row">
              <div class="col-md-6">
                <div class="input-group">
                  <div class="input-group-btn">
                    <button type="button" style="width:100px" class="btn btn-success">CLIENTE: </button>
                  </div>
                  <input type="text" class="form-control" id='deta_cliente'>
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <div class="input-group-btn">
                    <button type="button" style="width:100px" class="btn btn-success">SER. & NUM: </button>
                  </div>
                  <input type="text" class="form-control" id='deta_ser_num'>
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <div class="input-group-btn">
                    <button type="button" style="width:100px" class="btn btn-success">SUNAT: </button>
                  </div>
                  <input type="text" class="form-control" id='deta_sunat'>
                </div>
              </div>
            </div>
          </div>
          <div class="box-body">
            <h5 style="font-family:'Ubuntu'">CONCEPTOS: </h5><hr>
            <div class="table-responsive">
              <table id="notas_credito" class="table table-bordered table-striped">
                <thead>
                  <tr role="row">
                    <th>CONCEPTO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>MONTO</th>
                    <th>DESCUENTO</th>
                    <th>RESTO</th>
                  </tr>
                </thead>
                <tbody id='conceptos_nc'>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4"></div>
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var servidor = "<?php echo $this->config->item('ip'); ?>";
</script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/Waiting.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $('#notas_credito').DataTable({bFilter: true, bInfo: false,"bLengthChange": false,"bSort": false});
    function visualizar_detalle_nota_credito(tipo,letra,serie,numero){
      $.ajax({
        type : "POST",
        url : servidor+"nota_credito/detalle_nota_credito?ajax=true",
        data : ({
          'tipo' : tipo,
          'letra' : letra,
          'serie' : serie,
          'numero' : numero
        }),
        cache : false,
        dataType : 'json',
        success : function(data){
          if(data.result ==  true){
            $("#deta_serie").html(data.cabecera['BFNCATLET']+data.cabecera['BFNCASERNRO'])
            $("#deta_numero").html(data.cabecera['BFNCANRO'])
            $("#deta_cliente").val(data.cabecera['FSCCLINOMB'])
            $("#deta_monta").val(parseFloat(data.cabecera['BFNCATOTDIF']).toFixed(2))
            $("#deta_igv").val(parseFloat(data.cabecera['BFNCAIGVDIF']).toFixed(2))
            $("#deta_sub_total").val(parseFloat(data.cabecera['BFNCASUBDIF']).toFixed(2))
            $("#deta_sunat").val(data.cabecera['BFNCASUNSERNRO']+"-"+data.cabecera['BFNCASUNFACNRO'])
            $("#deta_ser_num").val(data.cabecera['SFACTURA_FSCSERNRO']+"-"+data.cabecera['SFACTURA_FSCNRO'])
            $("#conceptos_nc").empty()
            $("#conceptos_nc").append(data.detalle)
            $("#detalleNC").modal("show");
          } else {
            swal({
              "title": "",
              "text" : data.mensaje,
              "type" : "warning"
            })
          }
        }, error :  function(jqXHR,textStatus,errorThrown){
            if (jqXHR.status === 0) swal("","ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.","error")
            else if (jqXHR.status == 404) swal("","ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.","error")
            else if (jqXHR.status == 500) swal("","ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.","error")
            else if (textStatus === 'parsererror') swal("","ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR","error")
            else if (textStatus === 'timeout') swal("","ERROR DE TIEMPO DE ESPERA.","error")
            else if (textStatus === 'abort')  swal("","SOLICITUD CANCELADA.","error")
            else swal("","ERROR NO DETECTADO: \n" + jqXHR.responseText,"error")
        }
      })
    }

    function buscar_notas(){
      tipo = $("#documento").val();
      fecha_inicio = $("#fecha_inicio").val();
      fecha_fin = $("#fecha_fin").val();
      if(fecha_fin != "" && fecha_inicio != ""){
        $.ajax({
          type : "POST",
          url : servidor+"nota_credito/buscar_notas?ajax=true",
          data : ({
            'tipo' : tipo,
            'fecha_inicio' : fecha_inicio,
            'fecha_fin' : fecha_fin
          }),
          cache : false,
          dataType : 'json',
          success : function(data){
            if(data.result){
              $("#cuerpo_notas").empty();
              $("#notas_credito").dataTable().fnDestroy();
              $("#cuerpo_notas").append(data.notas);
              $('#notas_credito').DataTable({bFilter: true, bInfo: false,"bLengthChange": false,"bSort": false});
            } else {
              $("#cuerpo_notas").empty();
              $("#notas_credito").dataTable().fnDestroy();
              $('#notas_credito').DataTable({bFilter: true, bInfo: false,"bLengthChange": false,"bSort": false});
              swal("",data.mensaje,"warning")
            }
          }, error : function (jqXHR,textStatus,errorThrown){
            if (jqXHR.status === 0) swal("","ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.","error")
            else if (jqXHR.status == 404) swal("","ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.","error")
            else if (jqXHR.status == 500) swal("","ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.","error")
            else if (textStatus === 'parsererror') swal("","ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR","error")
            else if (textStatus === 'timeout') swal("","ERROR DE TIEMPO DE ESPERA.","error")
            else if (textStatus === 'abort')  swal("","SOLICITUD CANCELADA.","error")
            else swal("","ERROR NO DETECTADO: \n" + jqXHR.responseText,"error")
          }
        })
      } else {
        if(fecha_fin == "" && fecha_inicio == ""){
          swal("","DEBE SELECCIONAR UNA FECHA DE INICIO Y UNA FECHA DE FIN","warning");
        } else if(fecha_inicio == ""){
          swal("","DEBE SELECCIONAR UNA FECHA DE INICIO","warning")
        } else if($fecha_fin == ""){
          swal("","DEBE SELECCIONAR UNA FECHA DE FIN","warning")
        }
      }
    }

    function enviar_sunat(tipo,letra,serie,numero){
      waitingDialog.show('ENVIANDO A SUNAT LA NOTA CRÉDITO...', {dialogSize: 'lg', progressType: 'danger'});
      $.ajax({
        type : "POST",
        url : servidor+"nota_credito/reenviar_sunat?ajax=true",
        data : ({
          'tipo' : tipo,
          'letra' : letra,
          'serie' : serie,
          'numero' : numero
        }),
        cache : false,
        dataType : 'json',
        success : function(data){
          if(data.result ==  true){
            waitingDialog.hide();
            swal("",data.mensaje,"success")
            /*setTimeout(function(){
              window.location.assign(servidor+"notas/estados")
            },1500)*/
          } else {
              waitingDialog.hide();
            swal("",data.mensaje,"warning");
          }
        }, error :  function(jqXHR,textStatus,errorThrown){
          waitingDialog.hide();
          if (jqXHR.status === 0) swal("","ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.","error")
          else if (jqXHR.status == 404) swal("","ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.","error")
          else if (jqXHR.status == 500) swal("","ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.","error")
          else if (textStatus === 'parsererror') swal("","ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR","error")
          else if (textStatus === 'timeout') swal("","ERROR DE TIEMPO DE ESPERA.","error")
          else if (textStatus === 'abort')  swal("","SOLICITUD CANCELADA.","error")
          else swal("","ERROR NO DETECTADO: \n" + jqXHR.responseText,"error")
        }
      })
    }

    $("#fecha_inicio").focus(function() {
      $("#fecha_inicio").datepicker({ language: 'es', autoclose: true}).datepicker("show");
      $("#fecha_fin").attr("disabled",false);
      $("#fecha_fin").datepicker("destroy");
      $("#fecha_fin").val("");
    });

    $("#fecha_fin").focus(function() {
      if ($("#fecha_inicio").val()) {
        var fechaActual = getFechaActual();
        var fecha2 = $("#fecha_inicio").val();
        var dias = restaFechas(getFechaActual(),$("#fecha_inicio").val());
        var dias = parseInt(dias) + 1;
        if(dias >= 0 ){
          dias = "+"+dias;
        }
        $("#fecha_fin").datepicker({language: 'es', startDate : dias+'d', autoclose: true}).datepicker("show");
      }
    });

    function envio_masivo(){
      waitingDialog.show('ENVIANDO A SUNAT LAS NOTAS CRÉDITO PENDIENTES...', {dialogSize: 'lg', progressType: 'danger'});
      tipo = $("#documento").val();
      fecha_inicio = $("#fecha_inicio").val();
      fecha_fin = $("#fecha_fin").val();
      if(fecha_fin != "" && fecha_inicio != ""){
        $.ajax({
          type : "POST",
          url : servidor+"nota_credito/envio_masivo?ajax=true",
          data : ({
            'tipo' : tipo,
            'fecha_inicio' : fecha_inicio,
            'fecha_fin' : fecha_fin
          }),
          cache : false,
          dataType : 'json',
          success : function(data){
            if(data.result ==  true){
              waitingDialog.hide();
              window.location.assign(servidor+"notas/estados");
            } else {
              waitingDialog.hide();
              swal("",data.mensaje,"warning");
            }
          },error :  function(jqXHR,textStatus,errorThrown){
            if (jqXHR.status === 0) swal("","ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.","error")
            else if (jqXHR.status == 404) swal("","ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.","error")
            else if (jqXHR.status == 500) swal("","ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.","error")
            else if (textStatus === 'parsererror') swal("","ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR","error")
            else if (textStatus === 'timeout') swal("","ERROR DE TIEMPO DE ESPERA.","error")
            else if (textStatus === 'abort')  swal("","SOLICITUD CANCELADA.","error")
            else swal("","ERROR NO DETECTADO: \n" + jqXHR.responseText,"error")
          }
        })
    } else {

    }
  }

    function getFechaActual(){ var hoy = new Date(); var dd = hoy.getDate(); var mm = hoy.getMonth()+1;  var yyyy = hoy.getFullYear(); if(dd<10) dd='0'+dd; if(mm<10) mm='0'+mm; return dd+'/'+mm+'/'+yyyy; }
    restaFechas = function(f1,f2) { var aFecha1 = f1.split('/'); var aFecha2 = f2.split('/'); var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); var dif = fFecha2 - fFecha1; var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); return dias;}

</script>
