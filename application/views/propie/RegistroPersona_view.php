<script type="text/javascript"></script>
<section>
    <div class="modal fade" id="MODREGPER" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title" id="MODREGPER-TITULO">REGISTRAR PERSONA</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="MODREGPER-FORM">
                            <div class="col-md-12" id="MODREGPER-MSJ" style="display:hidden"></div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>DOC. IDENTIDAD: <a target="_blank" href="<?php echo $rutabsq1; ?>"><i class="fa fa-eye"></i></a></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-TIPDOC" type="text" codigo="-1" tipo="-1" longitud="-1" disabled/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>DOCUMENTO: </label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-DNI" type="text" disabled/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO PATERNO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-AP" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO MATERNO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-AM" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-12 col-sm-12">
                                <label>NOMBRE:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-NM" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>EMAIL:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-EMAIL" type="text"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>EMAIL 2:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-EMAIL2" type="text"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>FIJO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-FIJO" type="text" maxlength="9" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>FIJO 2:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-FIJO2" type="text" maxlength="9" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>CELULAR:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-CELULAR" type="text" maxlength="9" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>CELULAR 2:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-CELULAR2" type="text" maxlength="9" />
                                </div>  
                            </div>
                            
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>ZONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <select class="form-control" id="MODREGPER-CZONA" name="tipo-comprobante">
                                        <option value="-1">NINGUNO</option>
                                        <?php if(isset($codigo_zona)) foreach ($codigo_zona as $codigo) { ?>
                                            <option value="<?php echo $codigo['DOC_NAME']?>"><?php echo $codigo['DESCRIPCIO']?></option>
                                        <?php }?>
                                    </select>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-12">
                                <label>NOMBRE DE ZONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-NMZONA" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>VIA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <select class="form-control" id="MODREGPER-TVIA" name="tipo-comprobante">
                                        <option value="-1">NINGUNO</option>
                                        <?php if(isset($tipo_via)) foreach ($tipo_via as $tipo) { ?>
                                            <option value="<?php echo $tipo['DOC_NAME']?>"><?php echo $tipo['DESCRIPCIO']?></option>
                                        <?php }?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-12">
                                <label>NOMBRE DE VIA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-NMVIA" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>NUMERO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-NRO" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>KILOMETRO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-KM" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>MANZANA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-MNZ" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>INTERIOR:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-INT" type="text" style='text-transform:uppercase;'/>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>DEPARTAMENTO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-DEP" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>LOTE:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-LT" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <!--div class="form-group control-group col-md-12 col-sm-12">
                                <label>DIRECCION:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-DIR" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div-->
                        </form>
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="MODREGPER-OK">Registrar</button>
                    <button type="button" class="btn btn-danger" id="MODREGPER-CANCEL" >Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var accion_modregper = '-1';

    $(document).ready(function(){
        $("#MODREGPER-TVIA").change(function(){
            if($("#MODREGPER-TVIA option:selected").attr('value')=='-1'){
                $("#MODREGPER-NMVIA").val('');
                $("#MODREGPER-NMVIA").attr('disabled', true);
            }else{
                $("#MODREGPER-NMVIA").attr('disabled', false);
            }
        });
        $("#MODREGPER-FIJO").keydown(function(event) {
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
        $("#MODREGPER-FIJO2").keydown(function(event) {
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
        $("#MODREGPER-CELULAR").keydown(function(event) {
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
        $("#MODREGPER-CELULAR2").keydown(function(event) {
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
        $("#MODREGPER-CZONA").change(function(){
            if($("#MODREGPER-CZONA option:selected").attr('value')=='-1'){
                $("#MODREGPER-NMZONA").val('');
                $("#MODREGPER-NMZONA").attr('disabled', true);
            }else{
                $("#MODREGPER-NMZONA").attr('disabled', false);
            }
        });

        // MASCARAS
            $("#MODREGPER-EMAIL").inputmask('email');
            $("#MODREGPER-EMAIL2").inputmask('email');
            $(".limpia").inputmask('Regex',{
                regex: '[a-zA-ZÑñ]+( [a-zA-ZÑñ]+)*'
            });
        //

        $("#MODREGPER-CANCEL").on("click", function(){
            $('#MODREGPER').modal("hide");
            $("#Form-Id").focus();
        });

        $("#MODREGPER-OK").on("click", function(){
            if(accion_modregper=='registrar'){
                $("#MODREGPER-MSJ").empty();
                if(!validar_modregper()){
                    return false;
                }else{
                    registrar_modregper();
                }
            }else if(accion_modregper=='editar'){
                $("#MODREGPER-MSJ").empty();
                if(!validar_modregper()){
                    return false;
                }else{
                    actualizar_modregper();
                }
            }
        });

        $("#MODREGPER").on('hidden.bs.modal', function () {
            accion_modregper = '-1';
            $("#MODREGPER-FORM")[0].reset();
            
        });

        $(".limpia").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $(".sin_espacio").keypress(function(e){
            var keyCode = e.keyCode || e.which;
            if (keyCode == '32'){
                return false;
            }
        });
              
    });

    function registrar_modregper(){
        
        var tipdoc = $("#MODREGPER-TIPDOC").attr('codigo');
        var dni = $("#MODREGPER-DNI").val();
        var apepat = $("#MODREGPER-AP").val().toUpperCase();
        var apemat = $("#MODREGPER-AM").val().toUpperCase();
        var nm = $("#MODREGPER-NM").val().toUpperCase();
        //var email = $("#MODREGPER-EMAIL").val();
        //var dir = $("#MODREGPER-DIR").val();
        var email = $("#MODREGPER-EMAIL").val();
        var email2 = $("#MODREGPER-EMAIL2").val();
        var fijo = $("#MODREGPER-FIJO").val();
        var fijo2 = $("#MODREGPER-FIJO2").val();
        var celular = $("#MODREGPER-CELULAR").val();
        var celular2 = $("#MODREGPER-CELULAR2").val();
        var tvia = $("#MODREGPER-TVIA option:selected").attr('value');
        var nmvia = $("#MODREGPER-NMVIA").val().toUpperCase();
        var czona = $("#MODREGPER-CZONA option:selected").attr('value');
        var nmzona = $("#MODREGPER-NMZONA").val().toUpperCase();
        var nro = $("#MODREGPER-NRO").val();
        var km = $("#MODREGPER-KM").val();
        var mnz = $("#MODREGPER-MNZ").val();
        var inte = $("#MODREGPER-INT").val();
        var dep = $("#MODREGPER-DEP").val();
        var lt = $("#MODREGPER-LT").val();
        
        tvia = (tvia=='-1')? '':tvia;
        czona = (czona=='-1')? '':czona;

        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>registrar/persona?ajax=true",
            data: { TIPDOC: tipdoc, DNI: dni, APEPAT:apepat, APEMAT:apemat, NOMPER:nm, 
                    EMAIL:email, EMAIL2:email2, CELULAR:celular, CELULAR2:celular2, 
                    FIJO:fijo, FIJO2:fijo2, TIPO_DE_VIA:tvia, NOMBRE_DE_VIA:nmvia, KILOMETRO:km, 
                    MANZANA:mnz, LOTE:lt, NUMERO:nro, 
                    DEPARTAMENTO:dep, INTERIOR:inte, CODIGO_DE_ZONA:czona, 
                    TIPO_DE_ZONA:nmzona},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    usr=null;
                    usr = data.persona;
                    $('#Form-Id').attr('disabled', true);
                    $('#Form-Id').val(usr['NRODOC']);
                    $('#Form-Nom').val(usr['APEPAT']+' '+usr['APEMAT']+' '+usr['NOMBRE']);
                    $('#Form-Correo').val(usr['EMAIL']);
                    $('#Form-Dir').val(usr['DIREC']);
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    $('#MODREGPER').modal('hide');
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function actualizar_modregper(){
        var tipdoc = $("#MODREGPER-TIPDOC").attr('codigo');
        var dni = $("#MODREGPER-DNI").val();
        var apepat = $("#MODREGPER-AP").val().toUpperCase();
        var apemat = $("#MODREGPER-AM").val().toUpperCase();
        var nm = $("#MODREGPER-NM").val().toUpperCase();
        //var email = $("#MODREGPER-EMAIL").val();
        //var dir = $("#MODREGPER-DIR").val();
        var email = $("#MODREGPER-EMAIL").val();
        var email2 = $("#MODREGPER-EMAIL2").val();
        var fijo = $("#MODREGPER-FIJO").val();
        var fijo2 = $("#MODREGPER-FIJO2").val();
        var celular = $("#MODREGPER-CELULAR").val();
        var celular2 = $("#MODREGPER-CELULAR2").val();
        var tvia = $("#MODREGPER-TVIA option:selected").attr('value');
        var nmvia = $("#MODREGPER-NMVIA").val().toUpperCase();
        var czona = $("#MODREGPER-CZONA option:selected").attr('value');
        var nmzona = $("#MODREGPER-NMZONA").val().toUpperCase();
        var nro = $("#MODREGPER-NRO").val();
        var km = $("#MODREGPER-KM").val();
        var mnz = $("#MODREGPER-MNZ").val();
        var inte = $("#MODREGPER-INT").val();
        var dep = $("#MODREGPER-DEP").val();
        var lt = $("#MODREGPER-LT").val();
        
        tvia = (tvia=='-1')? '':tvia;
        czona = (czona=='-1')? '':czona;

        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>actualizar/persona?ajax=true",
            data: { TIPDOC: tipdoc, DNI: dni, APEPAT:apepat, APEMAT:apemat, NOMPER:nm, 
                    EMAIL:email, EMAIL2:email2, CELULAR:celular, CELULAR2:celular2, 
                    FIJO:fijo, FIJO2:fijo2, TIPO_DE_VIA:tvia, NOMBRE_DE_VIA:nmvia, KILOMETRO:km, 
                    MANZANA:mnz, LOTE:lt, NUMERO:nro, 
                    DEPARTAMENTO:dep, INTERIOR:inte, CODIGO_DE_ZONA:czona, 
                    TIPO_DE_ZONA:nmzona},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    usr = null;
                    usr = data.persona;
                    $('#Form-Id').attr('disabled', true);
                    $('#Form-Id').val(usr['NRODOC']);
                    $('#Form-Nom').val(usr['APEPAT']+' '+usr['APEMAT']+' '+usr['NOMBRE']);
                    $('#Form-Correo').val(usr['EMAIL']);
                    $('#Form-Dir').val(usr['DIREC']);
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    $('#MODREGPER').modal('hide');
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function cambiar_tipo_modregper(tipo){
        accion_modregper = tipo;
        if(accion_modregper=='editar'){
            $("#MODREGPER-OK").empty();
            $("#MODREGPER-OK").html('Actualizar');
            $("#MODREGPER-TITULO").empty();
            $("#MODREGPER-TITULO").html('ACTUALIZAR PERSONA');
            abrir_editar_persona();
        }else if(accion_modregper=='registrar'){
            $("#MODREGPER-OK").empty();
            $("#MODREGPER-OK").html('Registrar');
            $("#MODREGPER-TITULO").empty();
            $("#MODREGPER-TITULO").html('REGISTRAR PERSONA');
        }
    }

    function validar_campo_modregper(exp_reg, texto){
        texto = texto.toUpperCase();
        //console.log(texto);
        //console.log(exp_reg);
        str = exp_reg.exec(texto);
        console.log(str);
        if(str == null){
            return false;
        }
        return (str[0] == texto);
    }

    function validar_modregper(){
        var codigo = $("#MODREGPER-TIPDOC").attr('codigo');
        var dni = $("#MODREGPER-DNI").val();
        var apepat = $("#MODREGPER-AP").val().toUpperCase();
        var apemat = $("#MODREGPER-AM").val().toUpperCase();
        var nm = $("#MODREGPER-NM").val().toUpperCase();
        var email = $("#MODREGPER-EMAIL").val();
        var email2 = $("#MODREGPER-EMAIL2").val();
        var fijo = $("#MODREGPER-FIJO").val();
        var fijo2 = $("#MODREGPER-FIJO2").val();
        var celular = $("#MODREGPER-CELULAR").val();
        var celular2 = $("#MODREGPER-CELULAR2").val();
        //var dir = $("#MODREGPER-DIR").val();

        var tipo = $("#Form-TDIdent option:selected").attr("tipo");
        var l = $("#Form-TDIdent option:selected").attr("longitud");
        var tf = false;
        //console.log(tipo);
        //console.log(l);
            
        if(tipo=='N'){
            $('#Form-Id').inputmask('Regex', {
                regex:'[0-9]{'+l+'}'
            });
            var er = new RegExp('[0-9]{'+l+'}');
            tf = validar_campo(er, $('#Form-Id').val());
        }else{
            var er = new RegExp('[0-9A-Za-z]{5,'+l+'}');
            $('#Form-Id').inputmask('Regex', {
                regex:'[0-9A-Za-z]{'+l+'}'
            });
            tf = validar_campo(er, $('#Form-Id').val());
        }

        /*if(!validar_campo_modregper(/[0-9]{8}/, dni)){
            put_modregper_message('error', 'DNI no valido');
            $("#MODREGPER-DNI").focus();
            return false;
        }*/

        if(email != '' && !validar_campo_modregper(/\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,4})+/, email)){
            put_modregper_message('error', 'Email no valido');
            $("#MODREGPER-EMAIL").focus();
            return false;
        }

        if(!validar_campo_modregper(/[A-ZÑ]+( [A-ZÑ]+)*/, apepat)){
            put_modregper_message('error', 'Apellido Paterno no valido');
            $("#MODREGPER-AP").focus();
            return false;
        }

        if(!validar_campo_modregper(/[A-ZÑ]+( [A-ZÑ]+)*/, apemat)){
            put_modregper_message('error', 'Apellido Materno no valido');
            $("#MODREGPER-AM").focus();
            return false;
        }

        if(!validar_campo_modregper(/[A-ZÑ]+( [A-ZÑ]+)*/, nm)){
            put_modregper_message('error', 'Nombre no valido');
            $("#MODREGPER-NM").focus();
            return false;
        }
        return true;
    }

    function buscar_persona(nro_dni){
        show_swal('info', 'Buscando DNI: '+nro_dni, 'Espere mientras buscamos al usuario', false, false, false);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>consulta/buscar-dni?ajax=true",
            data: {dni: nro_dni, tipdoc: documento_identidad},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.dni){
                        usr = data.persona;
                        console.log(usr);
                        $('#Form-Id').attr('disabled', true);
                        $('#Form-Id').val(usr['NRODOC']);
                        $('#Form-Nom').val(usr['APEPAT']+' '+usr['APEMAT']+' '+usr['NOMBRE']);
                        $('#Form-Correo').val(usr['EMAIL']);
                        $('#Form-Dir').val(usr['DIREC']);

                        swal.close();
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                    }else{
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                        put_modregper_message(data.tipo, data.mensaje);
                        accion_modregper = 'registrar';
                        //console.log($('Form-TDIdent option:selected').attr('tipo'));
                        $('#MODREGPER-TIPDOC').val($('#Form-TDIdent option:selected').text());
                        $('#MODREGPER-TIPDOC').attr('codigo', $('#Form-TDIdent option:selected').val());
                        $('#MODREGPER-TIPDOC').attr('tipo', $('#Form-TDIdent option:selected').attr('tipo'));
                        $('#MODREGPER-TIPDOC').attr('longitud', $('#Form-TDIdent option:selected').attr('longitud'));
                        $('#MODREGPER-DNI').val(nro_dni);
                        if(suministro != null && suministro['CLIELECT'] != null){
                           $('#MODREGPER-NM').val(suministro['CLINOMBR1']+' '+suministro['CLINOMBR2']); 
                           $('#MODREGPER-AP').val(suministro['CLIAPELLPE']);
                           $('#MODREGPER-AM').val(suministro['CLIAPELLM']);
                        }
                        cambiar_tipo_modregper('registrar');
                        $('#MODREGPER').modal("show");//CLIAPELLPE, CLIAPELLM, CLINOMBR1, CLINOMBR2
                        
                        swal.close();
                        //$('#MODREGPER-NM').focus();
                        $("#Form-Id").val(nro_dni);
                    }
                    //sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function abrir_editar_persona(){
        
        var tipo = $("#Form-TDIdent option:selected").attr("tipo");
        var l = $("#Form-TDIdent option:selected").attr("longitud");
        var codigo = $("#Form-TDIdent option:selected").val();
        // , TIPDOC, , , , TIPO_DE_VIA, , CODIGO_DE_ZONA, , , , , , , , NUSRCOD,
        // , , , , , TIPDOCDESCABR, , 
        $("#MODREGPER-TIPDOC").attr('codigo', codigo);
        $("#MODREGPER-TIPDOC").attr('tipo', l);
        $("#MODREGPER-TIPDOC").attr('longitud', tipo);
        $("#MODREGPER-TIPDOC").val($("#Form-TDIdent option:selected").text());
        $("#MODREGPER-DNI").val(usr['NRODOC']);
        $("#MODREGPER-AP").val(usr['APEPAT']);
        $("#MODREGPER-AM").val(usr['APEMAT']);
        $("#MODREGPER-NM").val(usr['NOMBRE']);
        $("#MODREGPER-EMAIL").val(usr['EMAIL']);
        //var dir = $("#MODREGPER-DIR").val();
        $("#MODREGPER-EMAIL2").val(usr['EMAIL2']);
        $("#MODREGPER-FIJO").val(usr['TELFIJ']);
        $("#MODREGPER-FIJO2").val(usr['TELFIJ2']);
        $("#MODREGPER-CELULAR").val(usr['TELCEL']);
        $("#MODREGPER-CELULAR2").val(usr['TELCEL2']);
        $("#MODREGPER-TVIA option[value='"+usr['TIPO_DE_VIA']+"']").attr('selected', true);
        $("#MODREGPER-NMVIA").val(usr['NOMBRE_DE_VIA']);
        $("#MODREGPER-CZONA option[value='"+usr['CODIGO_DE_ZONA']+"']").attr('selected', true);
        $("#MODREGPER-NMZONA").val(usr['TIPO_DE_ZONA']);
        $("#MODREGPER-NRO").val(usr['NUMERO']);
        $("#MODREGPER-KM").val(usr['KILOMETRO']);
        $("#MODREGPER-MNZ").val(usr['MANZANA']);
        $("#MODREGPER-INT").val(usr['INTERIOR']);
        $("#MODREGPER-DEP").val(usr['DEPARTAMENTO']);
        $("#MODREGPER-LT").val(usr['LOTE']);
        //accion_modregper = 'editar';
    }

    function put_modregper_message(tipo, mensaje){
        $("#MODREGPER-MSJ").empty();
        $("#MODREGPER-MSJ").append(     '<div class="alert alert-'+tipo+' alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                                        mensaje+
                                        '</div>');
    }
</script>