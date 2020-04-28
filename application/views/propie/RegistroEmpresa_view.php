<section>
    <div class="modal fade" id="MODREGEMP" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">REGISTRAR EMPRESA</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-12" id="MODREGEMP-MSJ" style="display:hidden"></div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>RUC: <a target="_blank" href="<?php echo $rutabsq2; ?>"><i class="fa fa-eye"></i></a></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-RUC" type="text" disabled/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>EMAIL:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-EMAIL" type="text"/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>EMAIL 2:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-EMAIL2" type="text"/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-3 col-sm-12">
                            <label>CELULAR:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-CEL" type="text" maxlength="9" />
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-3 col-sm-12">
                            <label>CELULAR 2:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-CEL2" type="text" maxlength="9"/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-3 col-sm-12">
                            <label>FIJO:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-FIJO" type="text" maxlength="9"/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-3 col-sm-12">
                            <label>FIJO 2:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-FIJO2" type="text" maxlength="9"/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-12 col-sm-12">
                            <label>RAZON SOCIAL:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-RS" type="text" style='text-transform:uppercase;'>
                            </div>  
                        </div>
                        
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>ZONA:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i> 
                                </div>
                                <select class="form-control" id="MODREGEMP-CZONA" name="tipo-comprobante">
                                    <option value="-1">NINGUNO</option>
                                    <?php foreach ($codigo_zona as $codigo) { ?>
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
                                <input class="form-control" id="MODREGEMP-NMZONA" type="text" style='text-transform:uppercase;'/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>VIA:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i> 
                                </div>
                                <select class="form-control" id="MODREGEMP-TVIA" name="tipo-comprobante">
                                    <option value="-1">NINGUNO</option>
                                    <?php foreach ($tipo_via as $tipo) { ?>
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
                                <input class="form-control" id="MODREGEMP-NMVIA" type="text" style='text-transform:uppercase;'/>
                            </div>  
                        </div>
                        
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>NUMERO:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-NRO" type="text" style='text-transform:uppercase;'/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>KILOMETRO:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-KM" type="text" style='text-transform:uppercase;'/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>MANZANA:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-MNZ" type="text" style='text-transform:uppercase;'/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>INTERIOR:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-INT" type="text" style='text-transform:uppercase;'/>
                            </div>
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>DEPARTAMENTO:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-DEP" type="text" style='text-transform:uppercase;'/>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label>LOTE:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <input class="form-control" id="MODREGEMP-LT" type="text" style='text-transform:uppercase;'/>
                            </div>  
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="MODREGEMP-OK">Registrar</button>
                    <button type="button" class="btn btn-danger" id="MODREGEMP-CANCEL" >Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var accion_modregemp = '-1';
    // SI TIPO ES 'editar'
    // SI TIPO ES 'registrar'
    $(document).ready(function(){
        restablecer_modregemp();
        $("#MODREGEMP-EMAIL").inputmask('email');
        $("#MODREGEMP-EMAIL2").inputmask('email');
        $("#MODREGEMP-CEL").keydown(function(event) {
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
        $("#MODREGEMP-CEL2").keydown(function(event) {
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
        $("#MODREGEMP-FIJO").keydown(function(event) {
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
        $("#MODREGEMP-FIJO2").keydown(function(event) {
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
        $("#MODREGEMP-TVIA").change(function(){
            if($("#MODREGEMP-TVIA option:selected").attr('value')=='-1'){
                $("#MODREGEMP-NMVIA").val('');
                $("#MODREGEMP-NMVIA").attr('disabled', true);
            }else{
                $("#MODREGEMP-NMVIA").attr('disabled', false);
            }
        });

        $("#MODREGEMP-CZONA").change(function(){
            if($("#MODREGEMP-CZONA option:selected").attr('value')=='-1'){
                $("#MODREGEMP-NMZONA").val('');
                $("#MODREGEMP-NMZONA").attr('disabled', true);
            }else{
                $("#MODREGEMP-NMZONA").attr('disabled', false);
            }
        });

        $("#MODREGEMP-CANCEL").on("click", function(){
            $('#MODREGEMP').modal("hide");
            $("#Form-Id").focus();
            restablecer_modregemp();
        });

        $("#MODREGEMP-OK").on("click", function(){
            $("#MODREGEMP-MSJ").empty();

            if(!validar_modregemp()){
                return false;
            }
            console.log(accion_modregemp);
            if(accion_modregemp=='registrar'){
                registrar_empresa();
            }else if(accion_modregemp=='editar'){

                actualizar_empresa();
            }
            
        });



        $("#MODREGEMP-RS").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-EMAIL").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-NMVIA").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-NMZONA").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-NRO").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-KM").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-MNZ").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-INT").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-DEP").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $("#MODREGEMP-LT").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        /*$("#MODREGEMP-EMAIL").focusout(function(){
            var text = $(this).val();
            var vld = validar_campo_modregemp(/\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,4})+/, text);
            if(vld){
                $("#MODREGEMP-EMAIL2").attr('disabled', false);
                $("#MODREGEMP-EMAIL2").focus();
            }else{
                $("#MODREGEMP-EMAIL2").attr('disabled', true);
            }
        });*/
    });

    function buscar_ruc(nro_ruc){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>consulta/buscar-ruc?ajax=true",
            data: {ruc: nro_ruc},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.ruc){
                        usr = data.persona;
                        usr['RUC'] = ("0000000000" + usr['RUC']).slice (-11);
                        //alert(usr);(“00” + h).slice (-3);
                        $('#Form-Id').val(usr['RUC']);
                        $('#Form-Id').attr('disabled', true);
                        $('#Form-Nom').val(usr['NOMBRE_O_RAZON_SOCIAL']);
                        $('#Form-Correo').val(usr['EMAIL']);
                        /*/$('#Form-Dir')
                        var direc = '';
                        if(usr['TIPO_DE_VIA']!=null && usr['TIPO_DE_VIA']!=''){
                            direc += usr['TIPO_DE_VIA'];
                        }
                        if(usr['NOMBRE_DE_VIA']!=null && usr['NOMBRE_DE_VIA']!=''){
                            direc += (' '+usr['NOMBRE_DE_VIA']);
                        }
                        if(usr['KILOMETRO']!=null && usr['KILOMETRO']!=''){
                            direc += (' KM. '+usr['KILOMETRO']);
                        }
                        if(usr['MANZANA']!=null && usr['MANZANA']!=''){
                            direc += (' MNZ. '+usr['MANZANA']);
                        }
                        if(usr['LOTE']!=null && usr['LOTE']!=''){
                            direc += (' LT. '+usr['LOTE']);
                        }
                        if(usr['NUMERO']!=null && usr['NUMERO']!=''){
                            direc += (' NRO. '+usr['NUMERO']);
                        }
                        if(usr['DEPARTAMENTO']!=null && usr['DEPARTAMENTO']!=''){
                            direc += (' DPTO. '+usr['DEPARTAMENTO']);
                        }
                        if(usr['INTERIOR']!=null && usr['INTERIOR']!=''){
                            direc += (' INT. '+usr['INTERIOR']);
                        }
                        if(usr['CODIGO_DE_ZONA']!=null && usr['CODIGO_DE_ZONA']!=''){
                            direc += (' '+usr['CODIGO_DE_ZONA']);
                        }
                        if(usr['TIPO_DE_ZONA']!=null && usr['TIPO_DE_ZONA']!=''){
                            direc += (' '+usr['TIPO_DE_ZONA']);
                        }
                        direc = direc.trim();
                        while(direc != direc.replace('  ', ' ')){
                            direc = direc.replace('  ', ' ');
                        } */
                        $('#Form-Dir').val(usr['DIREC']);
                        //TIPO_DE_VIA, NOMBRE_DE_VIA, KILOMETRO, MANZANA, LOTE, 
                        //NUMERO, DEPARTAMENTO, INTERIOR, CODIGO_DE_ZONA, TIPO_DE_ZONA
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                        swal.close();
                    }else{
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                        put_modregemp_message(data.tipo, data.mensaje);
                        $('#MODREGEMP-RUC').val(nro_ruc);
                        $('#MODREGEMP').modal("show");
                        cambiar_tipo_modregemp('registrar');
                        swal.close();
                        //$('#MODREGEMP-NM').focus();
                        $("#Form-Id").val(nro_ruc);
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

    function validar_campo_modregemp(exp_reg, texto){
        texto = texto.toUpperCase();
        str = exp_reg.exec(texto);
        //console.log(str);
        if(str == null){
            return false;
        }
        return (str[0] == texto);
    }

    function validar_modregemp(){
        var ruc = $("#MODREGEMP-RUC").val();
        var rs = $("#MODREGEMP-RS").val();
        var email = $("#MODREGEMP-EMAIL").val();
        var tvia = $("#MODREGEMP-TVIA option:selected").attr('value');
        var nmvia = $("#MODREGEMP-NMVIA").val();
        var czona = $("#MODREGEMP-CZONA option:selected").attr('value');
        var nmzona = $("#MODREGEMP-NMZONA").val();
        var nro = $("#MODREGEMP-NRO").val();
        var km = $("#MODREGEMP-KM").val();
        var mnz = $("#MODREGEMP-MNZ").val();
        var inte = $("#MODREGEMP-INT").val();
        var dep = $("#MODREGEMP-DEP").val();
        var lt = $("#MODREGEMP-LT").val();
        var email = $("#MODREGEMP-EMAIL").val();
        var email2 = $("#MODREGEMP-EMAIL2").val();
        var fijo = $("#MODREGEMP-FIJO").val();
        var fijo2 = $("#MODREGEMP-FIJO2").val();
        var celular = $("#MODREGEMP-CELULAR").val();
        var celular2 = $("#MODREGEMP-CELULAR2").val();
        var direc = '';

        if(!validar_campo_modregemp(/[0-9]{11}/, ruc)){
            put_modregemp_message('error', 'RUC no valido');
            $("#MODREGEMP-RUC").focus();
            return false;
        }

        if(email != '' && !validar_campo_modregemp(/\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,4})+/, email)){
            put_modregemp_message('error', 'Email no valido');
            $("#MODREGEMP-EMAIL").focus();
            return false;
        }

        if(rs == ''){
            put_modregemp_message('error', 'Razon Social no valido');
            $("#MODREGEMP-RS").focus();
            return false;
        }

        if(tvia != '-1' && nmvia == ''){
            put_modregemp_message('error', 'Indique el nombre de la via');
            $("#MODREGEMP-NMVIA").focus();
            return false;
        }else if(tvia != '-1' && nmvia != ''){
            direc = direc + ' ' + tvia + ' ' + nmvia;
        }

        direc = direc + ' ' + km + ' ' + mnz + ' ' + lt + ' ' + nro + ' ' + dep + ' ' + inte;

        if(czona != '-1' && nmzona == ''){
            put_modregemp_message('error', 'Indique el nombre de la zona');
            $("#MODREGEMP-NMZONA").focus();
            return false;
        }else if(czona != '-1' && nmzona != ''){
            direc = direc + ' ' + czona + ' ' + nmzona;
        }

        direc = direc.trim();
        while(direc != direc.replace('  ', ' ')){
            direc = direc.replace('  ', ' ');
        }

        if(direc == ''){
            swal({
                title: "Direccion de la empresa esta vacia",
                text: "Desea registrar de todos modos",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                }, function(valor){
                    if(valor==true){
                        $("#MODREGEMP-NMVIA").focus();
                        return true;
                    }else{
                        return true;
                    }
                    
            });
        }else{
            return true;
        }
    }

    function put_modregemp_message(tipo, mensaje){
        $("#MODREGEMP-MSJ").empty();
        $("#MODREGEMP-MSJ").append(     '<div class="alert alert-'+tipo+' alert-dismissible">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                                        mensaje+
                                        '</div>');
    }

    function restablecer_modregemp(){
        $('#MODREGEMP-RUC').val('');
        $('#MODREGEMP-RS').val('');
        $('#MODREGEMP-EMAIL').val('');
        $('#MODREGEMP-EMAIL2').val('');
        $('#MODREGEMP-CEL').val('');
        $('#MODREGEMP-CEL2').val('');
        $('#MODREGEMP-FIJO').val('');
        $('#MODREGEMP-FIJO2').val('');
        $('#MODREGEMP-TVIA').val(-1);
        $("#MODREGEMP-NMVIA").val('');
        $('#MODREGEMP-CZONA').val(-1);
        $("#MODREGEMP-NMZONA").val('');
        $("#MODREGEMP-NRON").val('');
        $("#MODREGEMP-KM").val('');
        $("#MODREGEMP-DEP").val('');
        $("#MODREGEMP-INT").val('');
        $("#MODREGEMP-MNZ").val('');
        $("#MODREGEMP-LT").val('');
        $("#MODREGEMP-NMVIA").attr('disabled', true);
        $("#MODREGEMP-NMZONA").attr('disabled', true);
        //$("#MODREGEMP-EMAIL2").attr('disabled', true);
        //$("#MODREGEMP-FIJO2").attr('disabled', true);
        //$("#MODREGEMP-CEL2").attr('disabled', true);
    }

    function cambiar_tipo_modregemp(tipo){

        accion_modregemp = tipo;
        if(accion_modregemp=='editar'){
            $("#MODREGEMP-OK").empty();
            $("#MODREGEMP-OK").html('Actualizar');
            $("#MODREGEMP-TITULO").empty();
            $("#MODREGEMP-TITULO").html('ACTUALIZAR EMPRESA');
            abrir_editar_empresa();
        }else if(accion_modregemp=='registrar'){
            $("#MODREGEMP-OK").empty();
            $("#MODREGEMP-OK").html('Registrar');
            $("#MODREGEMP-TITULO").empty();
            $("#MODREGEMP-TITULO").html('REGISTRAR EMPRESA');
        }
    }

    function registrar_empresa(){
        var ruc = $("#MODREGEMP-RUC").val();
        var rs = $("#MODREGEMP-RS").val();
        var email = $("#MODREGEMP-EMAIL").val();
        var tvia = $("#MODREGEMP-TVIA option:selected").attr('value');
        var nmvia = $("#MODREGEMP-NMVIA").val();
        var czona = $("#MODREGEMP-CZONA option:selected").attr('value');
        var nmzona = $("#MODREGEMP-NMZONA").val();
        var nro = $("#MODREGEMP-NRO").val();
        var km = $("#MODREGEMP-KM").val();
        var mnz = $("#MODREGEMP-MNZ").val();
        var inte = $("#MODREGEMP-INT").val();
        var dep = $("#MODREGEMP-DEP").val();
        var lt = $("#MODREGEMP-LT").val();
        var email = $("#MODREGEMP-EMAIL").val();
        var email2 = $("#MODREGEMP-EMAIL2").val();
        var fijo = $("#MODREGEMP-FIJO").val();
        var fijo2 = $("#MODREGEMP-FIJO2").val();
        var celular = $("#MODREGEMP-CELULAR").val();
        var celular2 = $("#MODREGEMP-CELULAR2").val();
        //return false;
        tvia = (tvia=='-1')? '':tvia;
        czona = (czona=='-1')? '':czona;

        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>registrar/empresa?ajax=true",
            data: {RUC: ruc, RS:rs, EMAIL:email,
                    EMAIL2:email2, CELULAR:celular, CELULAR2:celular2, 
                    FIJO:fijo, FIJO2:fijo2, 
                    TIPO_DE_VIA:tvia, NOMBRE_DE_VIA:nmvia, KILOMETRO:km, 
                    MANZANA:mnz, LOTE:lt, NUMERO:nro, 
                    DEPARTAMENTO:dep, INTERIOR:inte, CODIGO_DE_ZONA:czona, 
                    TIPO_DE_ZONA:nmzona},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    usr = data.empresa;
                    $('#Form-Id').attr('disabled', true);
                    $('#Form-Nom').val(usr['NOMBRE_O_RAZON_SOCIAL']);
                    $('#Form-Correo').val(usr['EMAIL']);
                    /*var direc = '';
                    if(usr['TIPO_DE_VIA']!=null && usr['TIPO_DE_VIA']!=''){
                        direc += usr['TIPO_DE_VIA'];
                    }
                    if(usr['NOMBRE_DE_VIA']!=null && usr['NOMBRE_DE_VIA']!=''){
                        direc += (' '+usr['NOMBRE_DE_VIA']);
                    }
                    if(usr['KILOMETRO']!=null && usr['KILOMETRO']!=''){
                        direc += (' KM. '+usr['KILOMETRO']);
                    }
                    if(usr['MANZANA']!=null && usr['MANZANA']!=''){
                        direc += (' MNZ. '+usr['MANZANA']);
                    }
                    if(usr['LOTE']!=null && usr['LOTE']!=''){
                        direc += (' LT. '+usr['LOTE']);
                    }
                    if(usr['NUMERO']!=null && usr['NUMERO']!=''){
                        direc += (' NRO. '+usr['NUMERO']);
                    }
                    if(usr['DEPARTAMENTO']!=null && usr['DEPARTAMENTO']!=''){
                        direc += (' DPTO. '+usr['DEPARTAMENTO']);
                    }
                    if(usr['INTERIOR']!=null && usr['INTERIOR']!=''){
                        direc += (' INT. '+usr['INTERIOR']);
                    }
                    if(usr['CODIGO_DE_ZONA']!=null && usr['CODIGO_DE_ZONA']!=''){
                        direc += (' '+usr['CODIGO_DE_ZONA']);
                    }
                    if(usr['TIPO_DE_ZONA']!=null && usr['TIPO_DE_ZONA']!=''){
                        direc += (' '+usr['TIPO_DE_ZONA']);
                    }
                    direc = direc.trim();
                    while(direc != direc.replace('  ', ' ')){
                        direc = direc.replace('  ', ' ');
                    }
                    direc = direc.trim();
                    while(direc != direc.replace('  ', ' ')){
                        direc = direc.replace('  ', ' ');
                    }*/
                    $('#Form-Dir').val(usr['DIREC']);
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    $('#MODREGEMP').modal('hide');
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function actualizar_empresa(){
        var ruc = $("#MODREGEMP-RUC").val();
        var rs = $("#MODREGEMP-RS").val();
        var email = $("#MODREGEMP-EMAIL").val();
        var tvia = $("#MODREGEMP-TVIA option:selected").attr('value');
        var nmvia = $("#MODREGEMP-NMVIA").val();
        var czona = $("#MODREGEMP-CZONA option:selected").attr('value');
        var nmzona = $("#MODREGEMP-NMZONA").val();
        var nro = $("#MODREGEMP-NRO").val();
        var km = $("#MODREGEMP-KM").val();
        var mnz = $("#MODREGEMP-MNZ").val();
        var inte = $("#MODREGEMP-INT").val();
        var dep = $("#MODREGEMP-DEP").val();
        var lt = $("#MODREGEMP-LT").val();
        var email = $("#MODREGEMP-EMAIL").val();
        var email2 = $("#MODREGEMP-EMAIL2").val();
        var fijo = $("#MODREGEMP-FIJO").val();
        var fijo2 = $("#MODREGEMP-FIJO2").val();
        var celular = $("#MODREGEMP-CELULAR").val();
        var celular2 = $("#MODREGEMP-CELULAR2").val();
        //console.log(obj);
        //return false;
        tvia = (tvia=='-1')? '':tvia;
        czona = (czona=='-1')? '':czona;

        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>actualizar/empresa?ajax=true",
            data: {RUC: ruc, RS:rs, EMAIL:email, 
                    EMAIL2:email2, CELULAR:celular, CELULAR2:celular2, 
                    FIJO:fijo, FIJO2:fijo2, 
                    TIPO_DE_VIA:tvia, NOMBRE_DE_VIA:nmvia, KILOMETRO:km, 
                    MANZANA:mnz, LOTE:lt, NUMERO:nro, 
                    DEPARTAMENTO:dep, INTERIOR:inte, CODIGO_DE_ZONA:czona, 
                    TIPO_DE_ZONA:nmzona},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    usr = data.empresa;
                    $('#Form-Id').attr('disabled', true);
                    $('#Form-Nom').val(usr['NOMBRE_O_RAZON_SOCIAL']);
                    $('#Form-Correo').val(usr['EMAIL']);
                    /*var direc = '';
                    if(usr['TIPO_DE_VIA']!=null && usr['TIPO_DE_VIA']!=''){
                        direc += usr['TIPO_DE_VIA'];
                    }
                    if(usr['NOMBRE_DE_VIA']!=null && usr['NOMBRE_DE_VIA']!=''){
                        direc += (' '+usr['NOMBRE_DE_VIA']);
                    }
                    if(usr['KILOMETRO']!=null && usr['KILOMETRO']!=''){
                        direc += (' KM. '+usr['KILOMETRO']);
                    }
                    if(usr['MANZANA']!=null && usr['MANZANA']!=''){
                        direc += (' MNZ. '+usr['MANZANA']);
                    }
                    if(usr['LOTE']!=null && usr['LOTE']!=''){
                        direc += (' LT. '+usr['LOTE']);
                    }
                    if(usr['NUMERO']!=null && usr['NUMERO']!=''){
                        direc += (' NRO. '+usr['NUMERO']);
                    }
                    if(usr['DEPARTAMENTO']!=null && usr['DEPARTAMENTO']!=''){
                        direc += (' DPTO. '+usr['DEPARTAMENTO']);
                    }
                    if(usr['INTERIOR']!=null && usr['INTERIOR']!=''){
                        direc += (' INT. '+usr['INTERIOR']);
                    }
                    if(usr['CODIGO_DE_ZONA']!=null && usr['CODIGO_DE_ZONA']!=''){
                        direc += (' '+usr['CODIGO_DE_ZONA']);
                    }
                    if(usr['TIPO_DE_ZONA']!=null && usr['TIPO_DE_ZONA']!=''){
                        direc += (' '+usr['TIPO_DE_ZONA']);
                    }
                    direc = direc.trim();
                    while(direc != direc.replace('  ', ' ')){
                        direc = direc.replace('  ', ' ');
                    }
                    direc = direc.trim();
                    while(direc != direc.replace('  ', ' ')){
                        direc = direc.replace('  ', ' ');
                    }*/
                    $('#Form-Dir').val(usr['DIREC']);
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    $('#MODREGEMP').modal('hide');
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function abrir_editar_empresa(){
        $("#MODREGEMP-RUC").val(usr['RUC']);
        $("#MODREGEMP-RS").val(usr['NOMBRE_O_RAZON_SOCIAL']);
        $("#MODREGEMP-EMAIL").val(usr['EMAIL']);
        //var dir = $("#MODREGPER-DIR").val();
        $("#MODREGEMP-EMAIL2").val(usr['EMAIL2']);
        $("#MODREGEMP-FIJO").val(usr['TELFIJ']);
        $("#MODREGEMP-FIJO2").val(usr['TELFIJ2']);
        $("#MODREGEMP-CELULAR").val(usr['TELCEL']);
        $("#MODREGEMP-CELULAR2").val(usr['TELCEL2']);
        $("#MODREGEMP-TVIA option[value='"+usr['TIPO_DE_VIA']+"']").attr('selected', true);
        $("#MODREGEMP-NMVIA").val(usr['NOMBRE_DE_VIA']);
        $("#MODREGEMP-CZONA option[value='"+usr['CODIGO_DE_ZONA']+"']").attr('selected', true);
        $("#MODREGEMP-NMZONA").val(usr['TIPO_DE_ZONA']);
        $("#MODREGEMP-NRO").val(usr['NUMERO']);
        $("#MODREGEMP-KM").val(usr['KILOMETRO']);
        $("#MODREGEMP-MNZ").val(usr['MANZANA']);
        $("#MODREGEMP-INT").val(usr['INTERIOR']);
        $("#MODREGEMP-DEP").val(usr['DEPARTAMENTO']);
        $("#MODREGEMP-LT").val(usr['LOTE']);
    }

</script>