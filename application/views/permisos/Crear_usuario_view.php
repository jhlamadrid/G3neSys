<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
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
  <div class="row">
    <div class="col-md-12">
      <form id="formulario" data-toggle="validator" name="formularioUsuario" role="form" method="post" enctype="multipart/form-data">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="font-family:'Ubuntu'">Datos Personales</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12  col-sm-12 col-sx-12">
                <div class="form-group">
                  IMAGEN
                  <input type="file" name="imagen" value="" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  NOMBRE <span class="text-red">*</span>
                  <input name="UserNombre" id='UserNombre' value="" type="text" class="form-control" required="">
                  <div class="help-block with-errors">Colocar nombre completo del Usuario</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  DIRECCIÓN <span class="text-red">*</span>
                    <input name="UserDireccion" id='UserDireccion' value="" type="text" class="form-control" >
                    <div class="help-block with-errors">Colocar dirección completa del Usuario</div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                  CELULAR
                    <input name="UserCelular" id='UserCelular' value="" type="number" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  DNI <span class="text-red">*</span>
                    <input name="UserDni" id='UserDni' value="" data-minlength="8" type="number" class="form-control"  onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)"  required="">
                    <div class="help-block">Debe contener 8 digitos el DNI</div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                  USUARIO <span class="text-red">*</span>  <a class="pull-right" onclick="validar_usuario()"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                    <input name="UserLogin" id='UserLogin' value="" type="text" class="form-control" required="">
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                  CONTRASEÑA <span class="text-red">*</span>
                    <input name="UserPsw" id='UserPsw' value="123456" type="password" class="form-control" readonly="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                  OFICINA <span class="text-red">*</span>
                    <select class="form-control" id='oficina' name="oficina" onchange="get_areas()">
                      <?php foreach ($oficinas as $ofi) { ?>
                        <option value="<?php echo $ofi['OFICOD']; ?>"><?php echo $ofi['OFIDES']; ?></option>
                      <?php } ?>
                    </select>
                </div>

              </div>
              <div class="col-md-6">
                  <div class="form-group">
                  AREA <span class="text-red">*</span>
                    <select class="form-control" id='areas' name="area" required="">
                    </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  ESTADO
                  <select class="form-control" name="estado">
                    <?php foreach ($estados as $estado) { ?>
                      <option value="<?php echo $estado['ID_ESTADOS']; ?>" ><?php echo $estado['ESTNOMBRE']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  FECHA INICIO <span class="text-red">*</span>
                  <input type="text" id='fechaInicio' name="fechaInicio" class="form-control" value="" readonly="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  FECHA TERMINO <span class="text-red">*</span>
                  <input type="text" class="form-control" id='fechaFin' name="fechaFin" value="" required="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  ROL <span class="text-red">*</span>  <a class="pull-right" onclick="ver_detalle_rol()"><i class="fa fa-eye" aria-hidden="true"></i></a>
                  <select class="form-control" name="rol" id='roles'>
                    <option value="-1">SELECCIONE UN ROL</option>
                    <?php foreach ($roles as $rol) { ?>
                      <option value="<?php echo $rol['ID_ROL']; ?>" ><?php echo $rol['ROLDESC']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <a class="btn  btn-danger btn-block" href="<?php echo $this->config->item('ip'); ?>permisos/administrar_usuarios"><i class="fa fa-times" aria-hidden="true"></i> CANCELAR</a>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <button type='submit' class="btn btn-success btn-block"> <i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<div id="ListaPermisos" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-family:'Ubuntu'">ACTIVIDADES</h4>
      </div>
      <div class="modal-body">
        <div class="row" id='cuerpo_actividades'>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<style media="screen">
#country-list{float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 90%;
    position: absolute;
    max-height: 400px;
    overflow-y: scroll;border: 1px solid #cccaca;
    border-radius: 5px;}
#country-list li{padding: 10px; background: #FFF}
#country-list li:hover{    background: #3c8dbc;
    cursor: pointer;
    color: #fff;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/autocomplete/jquery.auto-complete.css">
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/autocomplete/jquery.auto-complete.js" type="text/javascript"></script>
<script type="text/javascript">
  var servidor = '<?php  echo $this->config->item('ip'); ?>';
  $('#formulario').validator()
  function limitar(e, contenido, caracteres){
            var unicode=e.keyCode? e.keyCode : e.charCode;
            if(unicode==8 || unicode==46 || unicode==13 || unicode==9 || unicode==37 || unicode==39 || unicode==38 || unicode==40) return true;
            if(contenido.length>=caracteres) return false;
            return true;
        }


  function ver_detalle_rol(){
    var val = $("#roles").val();
    if(val != -1){
      $.ajax({
        type: "POST",
        url : servidor + "permisos/get_actividades_x_rol?ajax=true",
        data: ({
          'rol' : val
        }),
        success : function(data){
          if(data.result){
            $("#cuerpo_actividades").empty();
            console.log(data);
            var cuerpo = "";
            cuerpo += "<div class='col-md-12'>"
            var tam = data.permisos.length;
            for(var i = 0; i  < tam; i++){
              if(i%4 == 0){
                if(i == 0) cuerpo += "<div class='row'>"
                else cuerpo+= "</div><div class='row'>"
              }
              cuerpo += "<div class='col-md-3'>"
              cuerpo += '<div class="box box-warning box-solid"><div class="box-header with-border"> <h3 class="box-title" style="font-family:\'Ubuntu\'">'+data.permisos[i]['MENUGENNOM'].toUpperCase()+'</h3> <div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button></div></div>';
              cuerpo += "<div class='box-body'><ul>";
              var tam1 = data.permisos[i]['actividades'].length;
              var valor = data.permisos[i]['actividades'];
              for(var j = 0; j < tam1; j++){
                cuerpo += "<li>"+valor[j]['ACTIVINOMB'].toUpperCase()+"</li>"
              }
              cuerpo += "</ul></div> </div>";
              cuerpo += '</div>'
            }
            if(tam%4 != 0){
              cuerpo += "</div>"
            }
            $("#cuerpo_actividades").append(cuerpo);
            $("#ListaPermisos").modal('show');
          } else {
            swal('',data.mensaje,'warning')
          }
        }, error : function(jqXHR,textStatus,errorThrown){

        }
      })
    } else {
      swal('','DEBE SELECCIONAR UN ROL PARA VER SU DETALLE','warning');
    }
  }

  function validar_usuario(){
    if($("#UserLogin").val().trim() != ""){
      $.ajax({
        type : 'POST',
        url : '<?php echo $this->config->item('ip'); ?>permisos/administrar_usuarios/validar_login?ajax=true',
        data : ({
          login : $("#UserLogin").val().trim()
        }),
        cache : false,
        dataType : 'json',
        success :  function(data){
          if(data.result){
            swal("","NOMBRE DE LOGIN CORRECTO","success");
          } else {
            $("#UserLogin").val("")
            swal("",data.mensaje,"warning")
          }
        }, error :  function(jqXHR,textStatus,errorThrown){

        }
      })
    } else {
      swal("","DEBE RELLENAR EL CAMPO PARA VALIDAR","warning")
    }
  }

</script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/datepicker.es.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/dist/js/Genesys/permisos/index_admin_user.min.js"></script>
