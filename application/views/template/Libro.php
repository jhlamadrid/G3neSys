<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Libro de Observaciones - SEDALIB S.A.</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="<?php echo $this->config->item('ip') ?>frontend/dist/img/favicon.ico" />
    <link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/externo.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>
<body id="fondo">
    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['mensaje'][0]; ?> alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
            <?php echo $_SESSION['mensaje'][1]; ?>
        </div><br>
        <?php if(isset($_SESSION['mensaje'][2])) {  ?>
            <script>
                window.open('<?php echo $this->config->item("ip"). "libro_observaciones/pdf/".$_SESSION['mensaje'][2]; ?>','_blank');
                //window.location = '<?php echo base_url(). "libro_observaciones/pdf/".$_SESSION['mensaje'][2]; ?>';
            </script>
        <?php }?>
    <?php } ?>
    <div class="container mt-4" >
        <h1>Libro de Observaciones</h1>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card" >
                    <div class="card-body">

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#registro">Registro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  data-toggle="tab" href="#seguimiento">Seguimiento</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="registro" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-12 mt-3 ">
                                        <h5> Registro en el Libro de Observaciones </h5>
                                        <form method="post">
                                            <hr>
                                            <div class="form-group row">
                                                <label for="oficina" class="col-sm-3 col-form-label">Oficina Reclamada</label>
                                                <div class="col-sm-9">
                                                    <select name="oficina" id="oficina" class="form-control" required>
                                                        <option  value="">Seleccione una oficina de la empresa....</option>
                                                        <?php foreach($oficinas as $o) { ?>
                                                            <option value="<?php echo $o['OFICOD'] ?>"><?php echo $o['OFIDES'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="fecha" class="col-sm-3 col-form-label">Fecha Registro</label>
                                                <div class="col-sm-9">
                                                    <input type="text" value="<?php echo date('Y-m-d');?>" class="form-control" name="fecha" id="fecha" readonly>
                                                </div>
                                            </div>
                                            <hr>
                                            <small class="text-success">Si ya haz presentado alguna observación, digita tu número de documento y presiona el icono de buscar, para cargar tus datos personales.</small><br><br>
                                            <div class="form-group row">
                                                <label for="tipoDoc" class="col-sm-3 col-form-label">Tipo de Documento</label>
                                                <div class="col-sm-9">
                                                    <select name="tipoDoc" id="tipoDoc" class="form-control" onchange="cambiarTipo()">
                                                        <?php foreach($tipos as $t) { ?>
                                                            <option value="<?php echo $t['TIPDOCCOD'] ?>" <?php echo (($t['TIPDOCDESC'] == 'DNI') ? 'selected' : '') ?>><?php echo $t['TIPDOCDESC'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="numDoc" class="col-sm-3 col-form-label">Número de Documento</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                    
                                                        <input type="text" class="form-control" id="numDoc" name="numDoc" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)"  required>
                                                        <div class="input-group-prepend" onclick="buscarDNI()">
                                                            <span class="input-group-text" id="buscarUsuario"> <i class="fas fa-search"></i> </span>
                                                        </div>
                                                    </div>
                                                    <!--<input type="text" class="form-control" name="numDoc" id="numDoc" required>-->
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label for="nombres" class="col-sm-3 col-form-label" >Nombres</label>
                                                <div class="col-sm-9">
                                                    <input type="text"  class="form-control" name="nombres" id="nombres" required disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="apellidoP" class="col-sm-3 col-form-label">Apellido Paterno</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="apellidoP" id="apellidoP" required disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="apellidoM" class="col-sm-3 col-form-label">Apellido Materno</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="apellidoM" id="apellidoM" required disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="domicilio" class="col-sm-3 col-form-label">Domicilio</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="domicilio" id="domicilio" disabled>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="celular" class="col-sm-3 col-form-label">Celular</label>
                                                <div class="col-sm-9">
                                                    <input type="tel" class="form-control" name="celular" id="celular" onKeyUp="return limitar(event,this.value,9)" onKeyDown="return limitar(event,this.value,9)" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">Correo Electrónico</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" name="email" id="email" required disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="suministro" class="col-sm-3 col-form-label">Suministro</label>
                                                <div class="col-sm-9">
                                                    <input type="tel" class="form-control" name="suministro" id="suministro" onKeyUp="return limitar(event,this.value,11)" onKeyDown="return limitar(event,this.value,11)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="detalle" class="col-sm-3 col-form-label">Detalle</label>
                                                <div class="col-sm-9">
                                                    <textarea type="email" rows="5" class="form-control" name="detalle" id="detalle" onKeyUp="return limitar(event,this.value,450)"  onKeyDown="return limitar(event,this.value,450)" required></textarea>
                                                    <small>El número máximo de caracteres permitidos es de 450.</small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="enviar" name="enviar">
                                                    <label class="form-check-label" for="enviar">
                                                        Enviar al correo electrónico el formato de registro
                                                    </label>
                                                </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-outline-success btn-block" id="btnEnviar"> <i class="fas fa-location-arrow"></i> Registrar </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                


                            </div>
                            <div class="tab-pane fade" id="seguimiento" role="tabpanel" aria-labelledby="profile-tab"> 
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <form >
                                            <div class="form-group row">
                                                <label for="tipoDoc" class="col-sm-3 col-form-label">Tipo de Documento</label>
                                                <div class="col-sm-9">
                                                    <select name="tipoDoc1" id="tipoDoc1" class="form-control">
                                                        <?php $k = 0; foreach($tipos as $t) { ?>
                                                            <option value="<?php echo $t['TIPDOCCOD'] ?>" <?php echo (($k == 0) ? 'selected' : '') ?>><?php echo $t['TIPDOCDESC'] ?></option>
                                                        <?php $k++;} ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="numDoc" class="col-sm-3 col-form-label">Número de Documento</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="numDoc1" name="numDoc1"  required>
                                                    </div>
                                                    <!--<input type="text" class="form-control" name="numDoc" id="numDoc" required>-->
                                                </div>
                                            </div>
                                            <div class="form-group row float-right">
                                                <a class="btn btn-outline-info mr-3" onclick="buscar()"> <i class="fas fa-search"></i> Buscar</a>
                                            </div>
                                        </form>
                                        
                                    </div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="resultado" class="table" style="display:none">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-center">Ficha N°</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cuerpo">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>












                       
                    </div>
                </div>
            </div>
        </div>
    </div><br>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
 var waitingDialog = waitingDialog || (function ($) { 'use strict';
        var $dialog = $('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;"><div class="modal-dialog modal-m"><div class="modal-content" style="border-radius:5px">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>');
        return { show: function (message, options) { if (typeof options === 'undefined') options = {}; if (typeof message === 'undefined') message = 'Cargando Recibos'; var settings = $.extend({ dialogSize: 'm', progressType: '', onHide: null  }, options);$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);$dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType); $dialog.find('h3').text(message);
            if (typeof settings.onHide === 'function') { $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) { settings.onHide.call($dialog); }); } $dialog.modal();},hide: function () { $dialog.modal('hide'); }
        };})(jQuery);


    function buscar(){
        if($("#numDoc1").val() != ""){
            waitingDialog.show("Buscando persona....");
            $.ajax({ 
                type : "POST",
                url : "<?php echo $this->config->item('ip'); ?>libro_observaciones/buscar?ajax=true", 
                data : ({ 
                    tipo : $("#tipoDoc1").val(), 
                    numero: $("#numDoc1").val()
                }),
                cache : false, 
                dataType  : 'json',
                success : function(resultado){ 
                    waitingDialog.hide();
                    $("#cuerpo").html("");
                    if(resultado.result){
                        
                        $("#resultado").show("slow");
                        let contenido = '';
                        var pad = "000000"
                        resultado.obs.map((o) => {
                            contenido += `<tr >
                                            <td class="text-right">${pad.substring(0, pad.length - o['CODIGO'].length) + o['CODIGO']}-${o['ANIO']}</td>
                                            <td class="text-right">${o['FECREG']}</td>
                                            <td class="text-right"><span class="badge badge-pill badge-${(o['ESTADO'] == 1) ? 'danger': 'primary'}">${(o['ESTADO'] == 1) ? 'En proceso': 'Atendido'}</span></td>
                                            <td class="text-center">
                                                <a class="btn btn-outline-primary" href="<?php echo base_url().'libro_observaciones/pdf/'; ?>${o['LOBSCOD']}" target="_blank"> <i class="far fa-eye"></i> Ficha</a>
                                            </td>
                                        <tr>`;
                        });
                        $("#cuerpo").html(contenido);
                        setTimeout(() => {
                            waitingDialog.hide();
                        }, 500);
                    } else { 
                        setTimeout(() => {
                            waitingDialog.hide();
                            swal({title : "", text : resultado.mensaje, type: "warning"}) 
                        }, 500);
                        
                    }
                }, error : function(jqXHR,textStatus,errorThrown){ 
                    _error(jqXHR,textStatus,errorThrown);
                }
            })
        } else {
            swal({title : "", text : "Debe completar el número del documento", type: "warning"}) 
        }
    }


    function buscarDNI(){
        if($("#numDoc").val() != ""){
            waitingDialog.show("Buscando persona....");
            $.ajax({ 
                type : "POST",
                url : "<?php echo $this->config->item('ip'); ?>libro_observaciones/dni?ajax=true", 
                data : ({ 
                    tipo : $("#tipoDoc").val(), 
                    numero: $("#numDoc").val()
                }),
                cache : false, 
                dataType  : 'json',
                success : function(resultado){ 
                    waitingDialog.hide();
                    if(resultado.result){
                        //console.log(resultado.usuario);
                        $("#nombres").val(resultado.usuario.NOMBRE);
                        $("#apellidoP").val(resultado.usuario.APEPAT);
                        $("#apellidoM").val(resultado.usuario.APEMAT);
                        $("#domicilio").val(resultado.usuario.DOMICILIO);
                        $("#celular").val(resultado.usuario.NROCELULAR);
                        $("#email").val(resultado.usuario.EMAIL);
                        
                        setTimeout(() => {
                            waitingDialog.hide();
                        }, 500);
                    } else { 
                        setTimeout(() => {
                            waitingDialog.hide();
                            swal({title : "", text : resultado.mensaje, type: "warning"}) 
                        }, 500);
                        
                    }
                    $("#nombres").prop('disabled', false);
                        $("#apellidoP").prop('disabled', false);
                        $("#apellidoM").prop('disabled', false);
                        $("#domicilio").prop('disabled', false);
                        $("#celular").prop('disabled', false);
                        $("#email").prop('disabled', false);
                }, error : function(jqXHR,textStatus,errorThrown){ 
                    _error(jqXHR,textStatus,errorThrown);
                }
            })
        } else {
            swal({title : "", text : "Debe completar el número del documento", type: "warning"}) 
        }
    }

        $('#numDoc').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                buscarDNI();
            }
        });


       
    function _error(jqXHR,textStatus,errorThrown){
        waitingDialog.hide(); 
        if (jqXHR.status === 0)  
            swal({title : "",text : "<b>ERROR</b><br>VERIFIQUE SU CONEXIÓN A INTERNET",type : "error", html : true});
        else if (jqXHR.status == 404) 
            swal({title : "",text : "<b>ERROR</b><br>EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO",type : "error" ,html : true});
        else if (jqXHR.status == 500) 
            swal({title : "",text : "<b>ERROR</b><br>ERROR INTERNO DEL SERVIDOR",type : "error", html : true});
        else if (textStatus === 'parsererror') 
            swal({'title' : "",'text' : "ERROR EN LA CONSULTA",'type' : "error",html : true});
        else if (textStatus === 'timeout') 
            swal({title : "",text : "<b>ERROR</b><br>ERROR EN EL TIEMPO DE CONEXIÓN",type : "error", html : true});
        else if (textStatus === 'abort') 
            swal({'title' : "",'text' : "PETICIÓN CANCELADA",'type' : "error"});
        else 
            swal({title : "", text : "<b>ERROR </b><br>ERROR DESCONOCIDO: "+jqXHR.responseText, type : "error", html : true});
    }

    $("#enviar").change(function() {
        if(this.checked) {
           $("#btnEnviar").html(`<i class="fas fa-location-arrow"></i> Registrar y Enviar `)
        } else {
            $("#btnEnviar").html(`<i class="fas fa-location-arrow"></i> Registrar `)
        }
    });

    function limitar(e, contenido, tam){
        var unicode=e.keyCode? e.keyCode : e.charCode;
        // Permitimos las siguientes teclas:
        // 8 backspace
        // 46 suprimir
        // 13 enter
        // 9 tabulador
        // 37 izquierda
        // 39 derecha
        // 38 subir
        // 40 bajar
        if(unicode==8 || unicode==46 || unicode==13 || unicode==9 || unicode==37 || unicode==39 || unicode==38 || unicode==40)
            return true;
        // Si ha superado el limite de caracteres devolvemos false
        if(contenido.length>=tam)
            return false;
        return true;
    }

    function cambiarTipo(){
        //tipoDoc
        //numDoc
        let tipo = $("#tipoDoc").val();
        console.log(tipo);
        if(tipo == 1){
            $("#numDoc").val("");
            $("#numDoc").attr("onKeyUp", "return limitar(event,this.value,8)");
            $("#numDoc").attr("onKeyDown", "return limitar(event,this.value,8)");
        } else if(tipo == 4 || tipo == 7) {
            $("#numDoc").val("");
            $("#numDoc").attr("onKeyUp", "return limitar(event,this.value,12)");
            $("#numDoc").attr("onKeyDown", "return limitar(event,this.value,12)");
        } else if(tipo == 6) {
            $("#numDoc").val("");
            $("#numDoc").attr("onKeyUp", "return limitar(event,this.value,11)");
            $("#numDoc").attr("onKeyDown", "return limitar(event,this.value,11)");
        }  else {
            $("#numDoc").val("");
            $("#numDoc").attr("onKeyUp", "return limitar(event,this.value,15)");
            $("#numDoc").attr("onKeyDown", "return limitar(event,this.value,15)");
        }
    }

</script>
</body>
</html>