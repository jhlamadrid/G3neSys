<script type="text/javascript">
  var servidor = '<?php echo $this->config->item('ip') ?>';
</script>
<section class="content">
  <div class="row">
      <div class="col-md-12 text-blue">
        <?php if (isset($_SESSION['mensaje'])) { ?>
         <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <?php echo $_SESSION['mensaje'][1]; ?>
         </div><br>
         <?php } ?>
      </div>
  </div>
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="text-center" style='font-family:"Ubuntu"'>NOTAS DE CRÉDITO</h3>
    </div>
    <div class="box-body">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#pendientes" aria-controls="pendientes" role="tab" data-toggle="tab">NOTAS PENDIENTES</a></li>
        <li role="presentation"><a href="#pagadas" aria-controls="pagadas" role="tab" data-toggle="tab">NOTAS PAGADAS</a></li>
      </ul>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="pendientes"><br>
          <div class="row">
            <div class="col-md-3 col-sm-3">
              <div class="input-group" style="margin-top:5px">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">SERIE</button>
                </div>
                <input type="text" class="form-control" id="serie" value="">
              </div>
            </div>
            <div class="col-md-3 col-sm-3">
              <div class="input-group" style="margin-top:5px">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">NÚMERO</button>
                </div>
                <input type="number" class="form-control" id="numero" value="">
              </div>
            </div>
            <div class="col-md-3 col-sm-3">
              <a class="btn btn-success btn-block" onclick="buscar_nota()"> <i class="fa fa-search" aria-hidden="true"></i> &nbsp; BUSCAR</a>
            </div>
            <div class="col-md-3 col-sm-3">
              <a  class="btn btn-warning btn-block" href="<?php echo $this->config->item('ip'); ?>documentos/nota_credito"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; PENDIENTES</a>
            </div>
          </div> <br>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="notas_pendientes" class="table table-bordered table-striped">
                  <thead>
                    <tr role="row">
                      <th>SERIE</th>
                      <th>NÚMERO</th>
                      <th>SERIE - NÚMERO DOCUMENTO</th>
                      <th>EMISIÓN</th>
                      <th>CLIENTE</th>
                      <th>DNI/RUC</th>
                      <th>TOTAL</th>
                      <th>OPCIONES</th>
                    </tr>
                  </thead>
                  <tbody id='cuerpo_notas_pendiente'>
                    <?php foreach ($notas as $nc) { ?>
                      <tr>
                        <td><?php echo $nc['BFNCATLET'].$nc['BFNCASERNRO'] ?></td>
                        <td><?php echo $nc['BFNCANRO'] ?></td>
                        <td><?php echo  (($nc['BFNCATLET'] == 'B') ? '<b>BOLETA: </b>' : '<b>FACTURA: </b>'); echo $nc['BFNCASUNSERNRO']."-".$nc['BFNCASUNFACNRO'] ?></td>
                        <td><?php echo $nc['BFNCAFECHEMI']." ".$nc['BFNCAHRAEMI']?></td>
                        <td><?php echo $nc['FSCCLINOMB'] ?></td>
                        <td><?php echo (($nc['FSCCLIRUC']) ? '<b>RUC: </b>'.$nc['FSCCLIRUC'] : '<b>DNI: </b>'.$nc['FSCNRODOC']) ?></td>
                        <td style="text-align:right"><b><?php echo number_format($nc['BFNCATOTDIF'],2,'.','') ?></b></td>
                        <td style="text-align:center">
                          <a href='<?php echo $this->config->item('ip')."documentos/nota_credito/pagar/".$nc['BFNCATLET'].( intval($nc['BFNCASERNRO']) * 97 )."/". ( intval($nc['BFNCANRO'])  * 39 ); ?>' class="btn btn-default"  data-toggle="tooltip" data-placement="bottom" title="PAGAR NOTA CRÉDITO">
                            <i class="fa fa-usd" aria-hidden="true"></i>
                          </a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="pagadas"><br>
          <div class="row">
            <div class="col-md-3">
              <div class="input-group" style="margin-top:5px">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">TIPO</button>
                </div>
                <select class="form-control" id='tipo_busqueda' onchange="cambiar_busqueda()">
                  <option value="1">SERIE Y NUMERO</option>
                  <option value="2">NOMBRE</option>
                  <option value="3">RANGO FECHAS</option>
                  <option value="4">DNI</option>
                  <option value="5">RUC</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-sm-6" id="busqueda">
              <div class='row'>
                <div class="col-md-6 col-sm-6">
                  <div class='input-group' style='margin-top:5px'>
                    <div class='input-group-btn'>
                      <button type='button' class='btn btn-danger' style='width:100px'>SERIE</button>
                    </div>
                    <input class='form-control' type='text' id='bus_serie'>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class='input-group' style='margin-top:5px'>
                    <div class='input-group-btn'>
                      <button type='button' class='btn btn-danger' style='width:100px'>NÚMERO</button>
                    </div>
                    <input class='form-control' type='number' id='bus_numero'>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <a onclick="buscar_pagadas()" class="btn btn-success btn-block"><i class="fa fa-search" aria-hidden="true"></i> &nbsp; BUSCAR</a>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="notas_pagadas" class="table table-bordered table-striped">
                  <thead>
                    <tr role="row">
                      <th>SERIE</th>
                      <th>NÚMERO</th>
                      <th>SERIE - NÚMERO DOCUMENTO</th>
                      <th>EMISIÓN</th>
                      <th>CLIENTE</th>
                      <th>DNI/RUC</th>
                      <th>TOTAL</th>
                      <th>OPCIONES</th>
                    </tr>
                  </thead>
                  <tbody id='cuerpo_notas_pagadas'>
                    <?php foreach ($pagadas as $nc) { ?>
                      <tr>
                        <td><?php echo $nc['BFNCATLET'].$nc['BFNCASERNRO'] ?></td>
                        <td><?php echo $nc['BFNCANRO'] ?></td>
                        <td><?php echo  (($nc['BFNCATLET'] == 'B') ? '<b>BOLETA: </b>' : '<b>FACTURA: </b>'); echo $nc['BFNCASUNSERNRO']."-".$nc['BFNCASUNFACNRO'] ?></td>
                        <td><?php echo $nc['BFNCAFECHEMI']." ".$nc['BFNCAHRAEMI']?></td>
                        <td><?php echo $nc['FSCCLINOMB'] ?></td>
                        <td><?php echo (($nc['FSCCLIRUC']) ? '<b>RUC: </b>'.$nc['FSCCLIRUC'] : '<b>DNI: </b>'.$nc['FSCNRODOC']) ?></td>
                        <td style="text-align:right"><b><?php echo number_format($nc['BFNCATOTDIF'],2,'.','') ?></b></td>
                        <td style="text-align:center">
                          <a onclick='window.open("<?php echo $this->config->item('ip')."documentos/nota_credito/imprimir_ticket_nc_duplicado/".$nc['BFNCATLET']."/".$nc['BFNCASERNRO']."/".$nc['BFNCANRO'] ?>","_blank", "toolbar=yes, scrollbars=yes, resizable=yes")' class="btn btn-default"  data-toggle="tooltip" data-placement="bottom" title="COMPROBANTE PAGO">
                            <i class="fa fa-ticket" aria-hidden="true"></i>
                          </a>
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
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/Waiting.min.js" type="text/javascript"></script>
<script type="text/javascript">
$('#notas_pendientes').DataTable({
  bFilter: true,
  bInfo: false,
  "ordering": false,
  "lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]
});
$('#notas_pagadas').DataTable({
  bFilter: true,
  bInfo: false,
  "ordering": false,
  "lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]
});

function cambiar_busqueda(){
  var tipo = $("#tipo_busqueda").val();
  console.log(tipo)
  $("#busqueda").empty()
  if(tipo == 1){
    $("#busqueda").append("<div class='row'>"+
                            "<div class='col-md-6 col-sm-6'>"+
                              "<div class='input-group' style='margin-top:5px'>"+
                                "<div class='input-group-btn'>"+
                                  "<button type='button' class='btn btn-danger' style='width:100px'>SERIE</button>"+
                                "</div>"+
                                "<input class='form-control' type='text' id='bus_serie'>"+
                              "</div>"+
                            "</div>"+
                            "<div class='col-md-6 col-sm-6'>"+
                              "<div class='input-group' style='margin-top:5px'>"+
                                "<div class='input-group-btn'>"+
                                  "<button type='button' class='btn btn-danger' style='width:100px'>NÚMERO</button>"+
                                "</div>"+
                                "<input class='form-control' type='number' id='bus_numero'>"+
                              "</div>"+
                            "</div>"+
                          "</div>")
  } else  if(tipo == 2){
    $("#busqueda").append("<div class='input-group' style='margin-top:5px'>"+
                            "<div class='input-group-btn'>"+
                              "<button type='button' class='btn btn-danger' style='width:100px'>NOMBRE</button>"+
                            "</div>"+
                            "<input class='form-control' type='text' id='bus_nombre'>"+
                          "</div>")
  } else if(tipo == 3){
    $("#busqueda").append("<div class='row'>"+
                            "<div class='col-md-6 col-sm-6'>"+
                              "<div class='input-group' style='margin-top:5px'>"+
                                "<div class='input-group-btn'>"+
                                  "<button type='button' class='btn btn-danger' style='width:100px'>F. INICIO</button>"+
                                "</div>"+
                                "<input class='form-control' type='text' id='bus_inicio'>"+
                              "</div>"+
                            "</div>"+
                            "<div class='col-md-6 col-sm-6'>"+
                              "<div class='input-group' style='margin-top:5px'>"+
                                "<div class='input-group-btn'>"+
                                  "<button type='button' class='btn btn-danger' style='width:100px'>F. FIN</button>"+
                                "</div>"+
                                "<input class='form-control' type='text' id='bus_fin'>"+
                              "</div>"+
                            "</div>"+
                          "</div>")
                          $("#bus_inicio").focus(function() {
                            $("#bus_inicio").datepicker({ language: 'es', autoclose: true,    orientation: "bottom left"}).datepicker("show");
                            $("#bus_fin").attr("disabled",false);
                            $("#bus_fin").datepicker("destroy");
                            $("#bus_fin").val("");
                          });

                          $("#bus_fin").focus(function() {
                            if ($("#bus_inicio").val()) {
                              var fechaActual = getFechaActual();
                              var fecha2 = $("#bus_inicio").val();
                              var dias = restaFechas(getFechaActual(),$("#bus_inicio").val());
                              var dias = parseInt(dias) + 1;
                              if(dias >= 0 ){
                                dias = "+"+dias;
                              }
                              $("#bus_fin").datepicker({language: 'es', startDate : dias+'d',   orientation: "bottom left", autoclose: true}).datepicker("show");
                            }
                          });
  } else if(tipo == 4){
    $("#busqueda").append("<div class='input-group' style='margin-top:5px'>"+
                            "<div class='input-group-btn'>"+
                              "<button type='button' class='btn btn-danger' style='width:100px'>DNI</button>"+
                            "</div>"+
                            "<input class='form-control' type='number' id='bus_dni'>"+
                          "</div>")
  } else if(tipo == 5){
    $("#busqueda").append("<div class='input-group' style='margin-top:5px'>"+
                            "<div class='input-group-btn'>"+
                              "<button type='button' class='btn btn-danger' style='width:100px'>RUC</button>"+
                            "</div>"+
                            "<input class='form-control' type='number' id='bus_ruc'>"+
                          "</div>")
  }
}

function buscar_nota(){
  var serie = $("#serie").val();
  var numero = $("#numero").val();
  if(serie != "" && numero != ""){
    $.ajax({
      type:'POST',
      url: servidor+'documentos/nota_credito/buscar_nota?ajax=true',
      data: ({
        serie : serie,
        numero : numero
      }),
      dataType: 'json',
      cache: false,
      success : function(data){
        if(data.result){
          $("#cuerpo_notas_pendiente").fadeOut(100)
          $("#notas_pendientes").dataTable().fnDestroy()
          $("#cuerpo_notas_pendiente").empty();
          $("#cuerpo_notas_pendiente").append(data.nota)
          $("#cuerpo_notas_pendiente").fadeIn(500)
          $('#notas_pendientes').DataTable({
            bFilter: true,
            bInfo: false,
            "ordering": false,
            "lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]
          });
        } else {
          swal("",data.mensaje,"warning")
        }
      },error : function(jqXHR,textSucess,errorThrown){
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
    if (serie.trim() == "" && numero.trim()) {
      swal("","DEBE COLOCAR LA SERIE Y NUMERO DE LA NOTA DE CRÉDITO","warning")
    }else if(serie == ""){
      swal("","DEBE COLOCAR LA SERIE DE LA NOTA DE CRÉDITO","warning")
    } else {
      swal("","DEBE COLOCAR EL NÚMERO DE LA NOTA DE CRÉDITO","warning")
    }
  }
}
function getFechaActual(){ var hoy = new Date(); var dd = hoy.getDate(); var mm = hoy.getMonth()+1;  var yyyy = hoy.getFullYear(); if(dd<10) dd='0'+dd; if(mm<10) mm='0'+mm; return dd+'/'+mm+'/'+yyyy; }
restaFechas = function(f1,f2) { var aFecha1 = f1.split('/'); var aFecha2 = f2.split('/'); var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); var dif = fFecha2 - fFecha1; var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); return dias;}

function buscar_pagadas(){
  var tipo = $("#tipo_busqueda").val();
  console.log(tipo);
  if(tipo == 1){
    var serie = $("#bus_serie").val();
    var numero = $("#bus_numero").val();
    if(serie.trim() !="" && numero.trim() != ""){
      datos = ({ 'letra': serie.charAt(0).toUpperCase(), 'serie' : serie.slice(1), 'numero' : numero, 'tipo' : tipo })
      realizar_busqueda(datos);
    } else {
      if(serie.trim() == "" && numero.trim() == ""){
        swal("","DEBE RELLENAR LA SERIE Y NUMERO", "warning")
      } else if(serie.trim() == "") {
        swal("","DEBE RELLENAR LA SERIE","warning")
      } else {
        swal("","DEBE RELLENAR EL NÚMERO","warning")
      }
    }
  } else if(tipo == 2){
    var nombre = $("#bus_nombre").val();
    if(nombre.trim() != ""){
      datos = ({'nombre' : nombre, 'tipo' : tipo})
      realizar_busqueda(datos);
    } else {
      swal("","DEBE RELLENAR EL NOMBRE DEL USUARIO","warning")
    }
  } else if (tipo ==  3){
    var fecha_inici = $("#bus_inicio").val();
    var fecha_fin = $("#bus_fin").val();
    if(fecha_inici.trim() != "" && fecha_fin.trim() !=""){
      datos = ({'fecha_inicio' : fecha_inici, 'fecha_fin': fecha_fin,'tipo':tipo})
      realizar_busqueda(datos)
    } else {
      if(fecha_inici.trim() == "" && fecha_fin.trim() == ""){
        swal("","DEBE COLOCAR LA FECHA DE INICIO Y LA FECHA DE FIN","warning")
      } else if(fecha_ini.trim() == ""){
        swal("","DEBE COLOCAR LA FECHA DE INICIO","warning")
      } else if(fecha_fin.trim() == ""){
        swal("","DEBE COLOCAR LA FECHA DE FIN","warning")
      }
    }
  } else if(tipo == 4){
    var dni = $("#bus_dni").val()
    if(dni.trim() != ""){
      datos = ({'dni': dni,'tipo':tipo})
      realizar_busqueda(datos)
    } else {
      swal("","DEBE RELLENAR EL CAMPO DEL DNI","warning")
    }
  } else if (tipo == 5){
    var ruc =  $("#bus_ruc").val()
    if(ruc.trim() != ""){
      datos = ({'ruc':ruc,'tipo': tipo})
      realizar_busqueda(datos)
    }else {
      swal("","DEBE RELLNAR EL CAMPO DEL RUC","warning")
    }
  }

}
function realizar_busqueda(data){
  waitingDialog.show('Buscando Información...', {dialogSize: 'lg', progressType: 'warning'});
  $.ajax({
    type: 'POST',
    url: servidor+'documentos/nota_credito/buscar_nota_pagada?ajax=true',
    data: data,
    dataType: 'json',
    cache: false,
    success : function(data){
      if(data.result ==  true){
        waitingDialog.hide();
        $("#cuerpo_notas_pagadas").fadeOut(100)
        $("#notas_pagadas").dataTable().fnDestroy()
        $("#cuerpo_notas_pagadas").empty();
        $("#cuerpo_notas_pagadas").append(data.notas)
        $("#cuerpo_notas_pagadas").fadeIn(500)
        $('#notas_pagadas').DataTable({
          bFilter: true,
          bInfo: false,
          "ordering": false,
          "lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]
        });
      } else {
        waitingDialog.hide();
        swal("",data.mensaje,"warning")
      }
    }, error : function(jqXHR,textSucess,errorThrown){
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

</script>
