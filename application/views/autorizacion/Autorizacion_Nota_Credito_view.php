<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 style="font-family:'Ubuntu'" class="text-red text-center">ANULAR NOTA DE CRÉDITO DE RECIBOS</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">OFICINA</button>
                </div>
                <input type="text" class="form-control" id='oficina' value="<?php echo  $_SESSION['OFICOD'] ?>" disabled>
              </div>
            </div>
            <div class="col-md-3" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" name="button">AGENCIA</button>
                </div>
                <input type="text" class="form-control" id='agencia' value="<?php echo $_SESSION['OFIAGECOD'] ?>" disabled>
              </div>
            </div>
            <div class="col-md-6" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" name="button">RESPONSABLE</button>
                </div>
                <input type="text" class="form-control" id='nombre' value="<?php echo $_SESSION['user_id']." ".$_SESSION['user_nom'] ?>" disabled>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12">
              <h4 style="font-family:'Ubuntu';font-weight:bold" class="text-green">BUSCAR NOTA DE CRÉDITO</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-sm-3" id="opt_srn_nro">
              <div class="form-group">
                <label for="">Tipo: </label>
                <select class="form-control" name="tipo" id='tipo'>
                  <option value="0">RECIBO</option>
                  <option value="1">SUMINISTRO</option>
                  <option value="2">NOTA CRÉDITO</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-sm-6" id="cuerpo_busqueda">
              <div class="row">
                <div class="col-md-6 col-sm-6" id="opt_srn_nro">
                  <div class="form-group">
                    <label >SERIE: </label>
                    <input type="number" class="form-control" onkeypress="return justNumbers(event);" id="serie" name="serie" required="">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6" id="opt_srn_nro">
                  <div class="form-group">
                    <label >NÚMERO: </label>
                    <input type="number" class="form-control" onkeypress="return justNumbers(event);" id="numero" name="numero" required="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-3">
              <div class="form-group">
                <a class="btn btn-primary btn-block" style="margin-top:20px" id="buscar"><i class="fa fa-search" aria-hidden="true" ></i> BUSCAR</a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="notas_credito" class="table table-bordered table-striped" style="display:none">
                  <thead>
                    <tr role="row">
                      <th>OPCION</th>
                      <th>SERIE NC</th>
                      <th>NUMERO NC</th>
                      <th>SUMINISTRO</th>
                      <th>FECHA</th>
                      <th>NOMBRE</th>
                      <th>MONTO</th>
                    </tr>
                  </thead>
                  <tbody id="recibos">
                  </tbody>
                </table>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-4 col-sm-4" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" name="button" style="width:100px">VIGENCIA</button>
                </div>
                <input type="text" class="form-control" id='vigencia' value="" disabled>
              </div>
            </div>
            <div class="col-md-4 col-sm-4" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" name="button" style="width:100px">GLOSA</button>
                </div>
                <input type="text" class="form-control" id='gloasa' value="" disabled>
              </div>
            </div>
            <div class="col-sm-4 col-md-4" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px"  name="button">USUARIO</button>
                </div>
                <select class="form-control" id="usuario" disabled="">
                  <option value="0">CUALQUIER USUARIO</option>
                  <?php foreach ($usuarios as $user) { ?>
                  <option value="<?php echo $user['NCODIGO'] ?>"><?php echo $user['NNOMBRE'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div> <br>
          <div class="row">
            <div class="col-md-6 col-sm-6">
            </div>
            <div class="col-md-6 col-sm-6">
              <a class="btn btn-success btn-block" id='save_autorizacion' onclick='enviar_autorizacion()' ><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 style="font-family:'Ubuntu'" class="text-red text-center">LISTA DE AUTORIZACIONES</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="autorizaciones" class="table table-bordered table-striped">
                  <thead>
                    <tr role="row">
                      <th>NÚMERO</th>
                      <th>FECHA</th>
                      <th>HORA</th>
                      <th>SUMINISTRO</th>
                      <th>VIGENCIA</th>
                      <th>OPERADOR</th>
                      <th>SERIE NÚMERO</th>
                      <th>ESTADO</th>
                    </tr>
                  </thead>
                  <tbody id="autorizacion">
                    <?php foreach ($autorizaciones as $aut) { ?>
                      <tr>
                        <td><?php echo $aut['AUT_NRO']; ?></td>
                        <td><?php echo $aut['AUT_FEC']; ?></td>
                        <td><?php echo $aut['AUT_HRA']; ?></td>
                        <td><?php echo $aut['CLIUNICOD']; ?></td>
                        <td><?php echo $aut['AUT_VIGFEC']; ?></td>
                        <td><?php echo (($aut['NNOMBRE']) ? $aut['NNOMBRE'] : "CUALQUIERA"); ?></td>
                        <td style="text-align:right"><?php echo $aut['AUT_SER']."-".$aut['AUT_REC']; ?></td>
                        <td style="text-align:center">
                          <?php if($aut['AUT_EST'] == 2) { ?>
                          <span class="badge bg-yellow">PENDIENTE</span></td>
                          <?php } else if($aut['AUT_EST'] == 1) { ?>
                            <span class="badge bg-green">ATENDIDO</span></td>
                          <?php } else {?>
                            <span class="badge bg-red">VENCIDO</span></td>
                          <?php } ?>
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
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/Waiting.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
$('#autorizaciones').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
$("#tipo").change(function(){
  var valor = $("#tipo").val()
  if(valor == 1){
    $("#cuerpo_busqueda").empty();
    $("#cuerpo_busqueda").append(`<div class='col-md-12'>
                                    <div class="form-group">
                                      <label>SUMINISTRO: </label>
                                      <input type="text" class="form-control" id="suministro" required="">
                                    </div>
                                  </div>`);

  } else if (valor == 0 || valor == 2){
      $("#cuerpo_busqueda").empty();
      $("#cuerpo_busqueda").append(`<div class="row">
        <div class="col-md-6 col-sm-6" id="opt_srn_nro">
          <div class="form-group">
            <label >SERIE: </label>
            <input type="number" class="form-control" onkeypress="return justNumbers(event);" id="serie" required="">
          </div>
        </div>
        <div class="col-md-6 col-sm-6" id="opt_srn_nro">
          <div class="form-group">
            <label >NÚMERO: </label>
            <input type="number" class="form-control" onkeypress="return justNumbers(event);" id="numero" required="">
          </div>
        </div>
      </div>`);
  }
})

$("#buscar").click(function(){
  var tipo = $("#tipo").val();
  if($("#suministro").val() != "" || ($("#serie").val() != "" && $("#numero").val() != "")){
    waitingDialog.show('BUSCANDO DOCUMENTO...', {dialogSize: 'lg', progressType: 'warning'});
    $("#notas_credito").fadeOut();
    if(tipo == 1){
      data = ({tipo : tipo , suministro : $("#suministro").val()})
    } else {
      data = ({tipo : tipo, serie : $("#serie").val() , numero : $("#numero").val() })
    }
    $.ajax({
      type: 'POST',
      url : '<?php echo $this->config->item('ip') ?>autorizacion/nota_credito/busqueda?ajax=true',
      data : data,
      cache : false,
      dataType : 'json',
      success :  function (data) {
        if(data.result){
          waitingDialog.hide();
          $("#recibos").empty();
          $("#recibos").append(data.recibos);
          $("#notas_credito").fadeIn(300)
          $("#vigencia").attr('disabled',false)
          $("#gloasa").attr('disabled',false)
          $("#usuario").attr('disabled',false)
        } else {
          $("#vigencia").attr('disabled',true)
          $("#gloasa").attr('disabled',true)
          $("#usuario").attr('disabled',true)
          waitingDialog.hide();
          swal("",data.mensaje,"warning")
        }
      }, error : function(jqXHR, textStatus,errorThrown){
        waitingDialog.hide();
        $("#vigencia").attr('disabled',true)
        $("#gloasa").attr('disabled',true)
        $("#usuario").attr('disabled',true)
        swal("","HUBO UN ERROR EN EL SERVIDOR","error")
      }
    })
  } else {
    if(tipo == 1){
      swal("","DEBE RELLENAR EL SUMINISTRO","warning");
    } else {
      if($("#serie").val() == "" && $("#numero").val() == ""){
        swal("","DEBE RELLENAR LA SERIE Y NÚMERO","warning");
      } else if($("#serie").val() == ""){
        swal("","DEBE RELLENAR LA SERIE","warning");
      } else {
        swal("","DEBE RELLENAR EL NUMERO","warning");
      }
    }
  }
})
$("#vigencia").focus(function() {
  $("#vigencia").datepicker({ language: 'es', autoclose: true,startDate:"+0d"}).datepicker("show");
});
function justNumbers(e){
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46)) return true;
  return /\d/.test(String.fromCharCode(keynum));
}
  var recibos = new Array();
function enviar_autorizacion(){
  recibos.length = 0;
  $(".chekeado").each(function(){
    if($(this).prop('checked')){
      data = ({
        serie: $(this).parent().parent().get(0).childNodes[1].textContent,
        numero : $(this).parent().parent().get(0).childNodes[2].textContent,
        suministro : $(this).parent().parent().get(0).childNodes[3].textContent
      })
      recibos.push(data);
    }
  });
  if(recibos.length > 0 && $("#vigencia").val() != "" && $("#gloasa").val() != ""){
    $("#save_autorizacion").attr('disabled',true)
    $("#save_autorizacion").attr('onclick','')
    waitingDialog.show('CREANDO AUTORIZACIONES...', {dialogSize: 'lg', progressType: 'warning'});
    $.ajax({
      type: 'POST',
      url : '<?php echo $this->config->item('ip') ?>autorizacion/nota_credito/autorizar_anulacion?ajax=true',
      data : ({
         recibos : recibos,
         vigencia : $("#vigencia").val(),
         glosa : $("#gloasa").val(),
         usuario : $("#usuario").val()
       }),
      cache : false,
      dataType : 'json',
      success :  function (data) {
        if(data.result){
          waitingDialog.hide();
          swal("",data.mensaje,"success");
          location.reload();
        } else {
          waitingDialog.hide();
          swal("",data.mensaje,"warning");
          $("#save_autorizacion").attr('disabled',false)
          $("#save_autorizacion").attr('onclick','enviar_autorizacion')
        }
      }, error :  function (jqXHR,textStatus,errorThrown){
        waitingDialog.hide();
        $("#save_autorizacion").attr('disabled',false)
        $("#save_autorizacion").attr('onclick','enviar_autorizacion')
        swal("","HUBO UN ERROR EN EL SERVIDOR","error")
      }
    })
  } else {
    if(recibos.length <= 0){
      swal("","DEBE SELECCIONAR LAS NOTAS DE CREDITO A ANULAR","warning")
    } else if($("#vigencia").val() == ""){
      swal("","DEBE SELECCIONAR LA FECHA DE VIGENCIA DE LA AUTORIZACION","warning")
    } else if($("#gloasa").val() == ""){
      swal("","DEBE SELECCIONAR EL MOTIVO PORQUE SE ESTA AUTORIZANDO","warning")
    }
  }
}

</script>
