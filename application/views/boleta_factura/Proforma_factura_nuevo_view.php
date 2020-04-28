<!-- sweetAlert. -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/autocomplete/jquery.auto-complete.css">

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/autocomplete/jquery.auto-complete.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>


<script>
    var usr = null;
    var default_suministro = <?php echo json_encode($suministro_default); ?>;
    var suministro = null;
    var suma = 0;

    function validar_campo(exp_reg, texto){
        texto = texto.toUpperCase();
        console.log(texto);
        console.log(exp_reg);
        str = exp_reg.exec(texto);
        console.log(str);
        if(str == null){
            return false;
        }
        return (str[0] == texto);
    }

    function obtener_subTotal(){
        suma = 0;
        var sub_tot = 0;
        var igv = 0;
        var val_igv = <?php echo $_SESSION['IGV']/100; ?>;
        $('#detalle tbody tr').each(function(){ //filas con clase 'dato', especifica una clase, asi no tomas el nombre de las columnas
            //console.log($(this).attr('gratuito'));
            var precio_Unitario = $(this).find('td').eq(2).text();
            precio_Unitario = precio_Unitario.replace(",","");
            var precunit = parseFloat(precio_Unitario||0, 10);
            var cantidad = parseFloat($(this).find('td').eq(3).text()||0, 10);
            if($(this).attr('gratuito')!='1'){
                if($(this).attr('conigv2')=='S'){
                    var presunitinigv = precunit/(1+val_igv);
                    var igvunit = (presunitinigv*val_igv).toFixed(2);
                    presunitinigv = precunit - igvunit;

                    sub_tot += presunitinigv * cantidad;
                    igv += igvunit * cantidad;
                    //console.log(new Array(presunitinigv, igvunit));
                }else{
                    sub_tot += precunit * cantidad;
                }
                suma += precunit * cantidad;
            }
        });
        $("#sub-total").empty();
        $('#igv').empty();
        $("#total").empty();

        $('#igv').append(igv.toFixed(2));
        $("#sub-total").append(sub_tot.toFixed(2));
        $("#total").append(suma.toFixed(2));
    }
</script>

<?php
    if (isset($modal_empresa)) {
        $this->load->view($modal_empresa, $this->data);
    }
    if (isset($modal_concepto)) {
        $this->load->view($modal_concepto);
    }
?>

<section class="content">   
    <div class="row">
        <div class="col-md-12">
            <div id="mensaje" style="display:hidden"></div>
            <div class="box  box-success">
                <div class="box-header with-border">
                    <div class="col-md-6 col-sm-9">
                        <h1 class="box-title"><?php echo $titulo; ?></h1>
                    </div>
                    <div class="col-md-6 col-sm-3" style="text-align:right;">
                        <h1 class="box-title"><b>Serie: </b><?php echo $_SESSION['FACTURA']['serie']; ?></h1>
                    </div>
                </div>
                <div class="col-md-12" id="mensaje"></div>
                <div class="box-body">
                    <form id="Form">
                    
                        <?php if($oordpag != null) { ?>
                            <div class="form-group col-md-3 col-sm-12"> 
                                <label class="control-label">ORDEN DE PAGO</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i> 
                                    </div>
                                    <input type="text" class="form-control" disabled value="<?php echo $oordpag[0]['SERNRO'].' - '.$oordpag[0]['ORPNRO'];?>">
                                </div>
                            </div>
                            <div class="form-group col-md-3 col-sm-12"> 
                                <label class="control-label">SOL. ACC. SE.</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" disabled value="<?php echo $oordserv['STASERNRO'].' - '.$oordserv['CDANRO'];?>">
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-12"> 
                                <label class="control-label">NOMBRE DE REFERENCIA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i> 
                                    </div>
                                    <input type="text" class="form-control" disabled value="<?php echo $oordpag[0]['ORPNOMREF'];?>">
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-sm-12"> 
                                <label class="control-label">COD. SUMINISTRO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="Form-CSum" disabled value="<?php echo str_pad($oordpag[0]['CLICOD'], 11, "0", STR_PAD_LEFT);?>" style='text-transform:uppercase;'>
                                </div>
                            </div>
                            <div class="form-group col-md-8 col-sm-12"> 
                                <label class="control-label" for="formInput74">NOMBRE DE SUMINISTRO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i> 
                                    </div>
                                    <input type="text" class="form-control" disabled value="CLIENTES VARIOS" style='text-transform:uppercase;'>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>COD. SUMINISTRO: </label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" id="Form-CSum-check" type="button" data-toggle="tooltip" data-placement="bottom" title data-original-title="Ingresar suministro">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control" id="Form-CSum" disabled="true">
                                    <span class="input-group-btn" id="Form-CSum-span" >
                                        <button class="btn btn-default" id="Form-CSum-clear" type="button"><i class="fa fa-times"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-12">
                                <label for="tipo-comprobante">NOMBRE DE SUMINISTRO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="Form-NSum" disabled="true">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label for="tipo-comprobante">TIPO DE PROFORMA:</label>
                            <div class="controls">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="Form-TCom" disabled="true" value="FACTURA">
                                </div>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label for="documento">
                                DOCUMENTO: 
                                <a target="_blank" href="<?php echo $rutabsq2; ?>"><i class="fa fa-eye"></i></a>
                                <a id="Form-Edit" data-toggle="tooltip" data-placement="bottom" title data-original-title="Editar datos del usuario"><i class="fa fa-pencil"></i></a>
                                <a><i class="fa fa-times" id="Form-Reset"></i></a>
                            </label>
                            <div class="controls">
                                <div class="input-group">
                                    <span class="input-group-addon">RUC</span>
                                    <?php if($empresa){?>
                                    <input class="form-control" id="Form-Id" type="text" value="<?php echo $empresa['RUC'];?>" readonly>
                                    <?php }else{ ?>
                                    <input class="form-control" id="Form-Id" type="text">
                                    <?php }?>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label for="tipo-comprobante">CORREO:</label>
                            <div class="controls input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-envelope"></i> 
                                </div>
                                <input type="text" class="form-control" id="Form-Correo" disabled>
                            </div>
                        </div>
                        <div class="form-group control-group col-md-12" id="div-Nom">
                            <label for="nombre">NOMBRE:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <?php if($empresa){?>
                                   <input class="form-control" id="Form-Nom"  name="nombre" type="text" style='text-transform:uppercase;' value="<?php echo $empresa['NOMBRE_O_RAZON_SOCIAL'];?>" readonly>
                                <?php }else{ ?>
                                <input class="form-control" id="Form-Nom"  name="nombre" type="text" style='text-transform:uppercase;' disabled>
                                <?php }?>
                            </div>
                        </div>
                        <div class="form-group control-group col-md-12" id="div-Nom">
                            <label for="nombre">DIRECCION:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-home"></i>
                                </div>
                                <?php if($empresa){?>
                                   <input class="form-control" id="Form-Dir"  name="nombre" type="text" style='text-transform:uppercase;' value="<?php echo $empresa['TIPO_DE_VIA']." ".$empresa['NOMBRE_DE_VIA']." ".$empresa['CODIGO_DE_ZONA']." ".$empresa['TIPO_DE_ZONA'];?>" readonly>
                                <?php }else{ ?>
                                <input class="form-control" id="Form-Dir"  name="nombre" type="text" style='text-transform:uppercase;' disabled>
                                <?php }?>
                            </div>
                        </div>
                        <div class="form-group control-group col-md-5 col-sm-5">
                            <label>OBSERVACION: </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <input type="text" class="form-control" id="Form-Obs" style='text-transform:uppercase;'>
                            </div>
                        </div>
                        <div class="form-group control-group col-md-3 col-sm-3">
                            <label>GRATUITO: </label>
                            <div class="input-group">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" id="Form-gratuito" >
                                     Presione 
                                </label>
                                <!--<span class="input-group-addon">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <input type="text" class="form-control" id="Form-Obs" style='text-transform:uppercase;'>-->
                            </div>
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-4"  id = "afecta_igv">
                            <label>TIPO AFECTACIÓN IGV: </label>
                            <div class="input-group">
                            
                            <select class="form-control" id="Tip_afectacion_igv">
                               <?php
                                 $i= 0;
                                 while($i<count($tipo_afectacion_igv)){ 
                               ?>
                                <option value = "<?php echo $tipo_afectacion_igv[$i]['CODIGO']; ?>"><?php echo $tipo_afectacion_igv[$i]['DESCRIPCIO'] ;?></option>
                               <?php
                                  $i++;  
                               }?>
                                
                            </select>
                            </div>
                        </div>
                        <?php if($oordpag == null) { ?>
                            <div class="form-group col-md-12 col-sm-12" style="text-align:right;" >
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal1" onclick="abrirModalAnadir()">
                                    AÑADIR CONCEPTO
                                </button>
                            </div>
                            <div class="box box-primary col-md-12 col-sm-12" style="width:95%; margin-left:20px; padding-top:10px;">
                                <div class="table-responsive" style="display: block; height: 200px;">
                                    <table id="detalle" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th style="text-align:center; width:10%; ">CODIGO</th>
                                                <th style="text-align:center;">DESCRIPCION</th>
                                                <th style="text-align:center; width:10%;">PRECIO UNIT</th>
                                                <th style="text-align:center; width:10%;">CANTIDAD</th>
                                                <th style="text-align:center; width:10%;">IMPORTE</th>
                                                <th style="text-align:center; width:10%;">OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } else{ ?>
                            <div class="box box-primary col-md-12 col-sm-12" style="width:95%; margin-left:20px; padding-top:10px;">
                                <div class="table-responsive" style="display: block; height: 200px;">
                                    <table id="detalle" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th style="text-align:center; width:10%; ">CODIGO</th>
                                                <th style="text-align:center;">DESCRIPCION</th>
                                                <th style="text-align:center; width:10%;">PRECIO UNIT</th>
                                                <th style="text-align:center; width:10%;">CANTIDAD</th>
                                                <th style="text-align:center; width:10%;">IMPORTE</th>
                                                <th style="text-align:center; width:10%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                                
                                                foreach($conceptos as $fila) { $p_importe = $fila['ORPCNT']*$fila['ORPPRE'];  
                                                    //var_dump($fila);
                                                    $aux = '';
                                                    if($fila['EXONERADO']=="1") {
                                                        $aux = 'EXONERADO';
                                                    }else if($fila['FACIGVCOB']=="S"){
                                                        $aux = 'GRAVADO';
                                                    }else{
                                                        $aux = 'INAFECTO';
                                                    }

                                                    if($fila['GRATUITO']=="1"){
                                                        $aux = $aux +' - '+'GRATUITO';
                                                    }
                                            ?>
                                            <?php
                                                 if($p_importe != 0){
                                            ?>
                                                <tr 
                                                  conigv='<?php echo ($fila['FACIGVCOB']=="S")? "SI":"NO"; ?>'
                                                  conigv2 = '<?php echo ($fila['FACIGVCOB']=="S")? "S":"N"; ?>'
                                                  gratuito = '<?php echo ($fila['GRATUITO']=="1")? "1":"0"; ?>'
                                                  exonerado = '<?php echo ($fila['EXONERADO']=="1")? "1":"0"; ?>'
                                                >
                                                    <td style="text-align: center;"><?php echo $fila['FACCONCOD']; ?></td>
                                                    <td><?php echo $fila['FACCONDES']; ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($fila['ORPPRE'], 2); ?></td>
                                                    <td style="text-align: right;"><?php echo $fila['ORPCNT']; ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($p_importe, 2); ?></td>
                                                    <td style="text-align: center;">
                                                        <span class="label label-primary"><?php echo $aux; ?></span>
                                                    </td>
                                                </tr>
                                            <?php }
                                                } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-4 col-sm-4 col-md-offset-8 col-sm-offset-8 col-xs-offset-0">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr id="precio-sub-total">
                                                    <th style="padding-right:10px;  text-align:right;">SUB TOTAL: S/</th>
                                                    <td id="sub-total" style="text-align:right; font-size:20px;">0</td>
                                                </tr>
                                                <tr id="precio-igv">
                                                    <th style="padding-right:10px; text-align:right;">I.G.V. (<?php echo $_SESSION['IGV']; ?>%): S/</th>
                                                    <td id="igv" style="text-align:right; font-size:20px;">0</td>
                                                </tr>
                                                <tr id="precio-total">
                                                    <th style="padding-right:10px; text-align:right;">TOTAL: S/</th>
                                                    <td id="total" style="text-align:right; color:#00f; font-size:20px;">0</td>
                                                </tr>
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-group col-md-12 col-sm-12" >
                        <button class="btn btn-success" id="btn-registrar">Registrar</button>
                    </div>
                </div>
                <p id="json"></p>
            </div>
            
        </div>
    </div>

</section>



<script>

    $(document).ready(function(){
        $("#afecta_igv").hide();
        obtener_subTotal();
        <?php if($oordpag == null) { ?>
            $("#Form-CSum-check").focus();
            $("#Form-CSum").val(default_suministro['CLICODFAC']);
            $("#Form-NSum").val(default_suministro['CLINOMBRE']);
            $("#Form-CSum-clear").hide();
            $("#Form-CSum-span").hide();
            /*$("#Form-gratuito").prop( "disabled", true );*/
        <?php }else{ ?>
            $("#Form-gratuito").hide();
        <?php }?>

        $("#Form-Id").inputmask("99999999999");

        // FOCUS OUT
            document.getElementById('Form-Id').onkeypress = function(e){
                if (!e) e = window.event;
                var keyCode = e.keyCode || e.which;
                if (keyCode == '13'){

                    if(validar_campo(/[0-9]{11}/, $('#Form-Id').val())){
                        buscar_ruc($('#Form-Id').val());
                    }else{
                        $('#Form-Id').css();
                        //$("#Form-Id").val("");
                    }
                    return false;
                }
            }
            /*$("#Form-Id").focusout(function(){
                if(validar_campo(/[0-9]{11}/, $('#Form-Id').val())){
                    buscar_ruc($('#Form-Id').val());
                }else{
                    $("#Form-Id").val("");
                }
            });*/

            document.getElementById('Form-Id').onkeypress = function(e){
                if (!e) e = window.event;
                var keyCode = e.keyCode || e.which;
                if (keyCode == '13'){
                    if(validar_campo(/[0-9]{11}/, $('#Form-Id').val())){
                        buscar_ruc($('#Form-Id').val());
                    }else{
                        $("#Form-Id").val("");
                    }
                    return false;
                }
            }

            $("#Form-Dir").focusout(function(){
                var text = $(this).val();
                text = text.trim();
                while(text != text.replace('  ', ' ')){
                    text = text.replace('  ', ' ');
                }
                $(this).val(text);
            });

            $("#Form-Correo").focusout(function(){
                var text = $(this).val();
                text = text.trim();
                while(text != text.replace('  ', ' ')){
                    text = text.replace('  ', ' ');
                }
                $(this).val(text);
            });

            $("#Form-Obs").focusout(function(){
                var text = $(this).val();
                text = text.trim();
                while(text != text.replace('  ', ' ')){
                    text = text.replace('  ', ' ');
                }
                $(this).val(text);
            });
        // ==================================================
        $("#Form-Edit").on("click", function(){
                //alert("entre en el click");
                if(usr != null){
                    
                    cambiar_tipo_modregemp('editar');
                    $('#MODREGEMP').modal("show");
                }
            });
        // ON CLICK
        <?php if($oordpag == null) { ?>
            $("#Form-CSum-check").on("click", function(){
                if(suministro!=null){
                    swal({
                        title: "Desea reemplazar este suministro",
                        text: "Perdera algunos datos ingresados hasta hasta el momento",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        }, function(valor){
                            if(valor) { 
                                cargar_suministro(); 
                            }
                    });
                }else{
                    cargar_suministro();
                }
            });

            $("#Form-CSum-clear").on("click", function(){
                swal({
                        title: "Desea retirar este suministro",
                        text: "El suministro regresara a su valor por defecto",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    }, function(valor){
                        if(valor==true){ 
                            suministro = null; 
                            $("#Form-CSum").val(default_suministro['CLICODFAC']);
                            $("#Form-NSum").val(default_suministro['CLINOMBRE']);
                            $("#Form-CSum-span").hide();
                            $("#Form-CSum-check").focus();
                            reset_form();
                        }
                });
            });


        <?php } ?>
            

            $("#Form-Reset").on("click", function(){
                swal({
                        title: "Desea restaurar datos del cliente",
                        text: "Perdera algunos datos del formulario",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                    }, function(valor){
                        if(valor==true){
                            reset_form();
                        }
                });
            });

            $("#form-")

            $("#btn-registrar").on("click", function(){
                $("#mensaje").empty();
                //validar_registro();validar_registro()
                if(validar_registro()){
                    swal({
                        title: "Registrar proforma",
                        text: "Esta seguro que desea registrar esta proforma",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        //closeOnConfirm: false,
                        //showLoaderOnConfirm: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmLoadingButtonColor: true,
                    }, function(isConfirm){
                        if(isConfirm) {
                            swal.disableButtons();
                            registrar();

                            //window.location.replace('<?php echo base_url()."documentos/proformas"?>');                  
                        }
                    });
                }
            });
        // =========================================================
            
        function reset_form(){
            usr = null;
            $("#Form-Id").attr('disabled', false);
            $("#Form-Id").val('');
            
            $("#Form-Correo").val('');
            $("#Form-Nom").val('');
            $("#Form-Dir").val('');
        }

        function cargar_suministro(){
            swal({
                title: "Ingrese codigo de suministro",
                type: "input",
                //input: 'text',
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "Codigo de sumunistro",
                showLoaderOnConfirm: true,
                confirmButtonText: "Buscar",
                cancelButtonText: "Cancelar",
                }, function(inputValue){
                    if (inputValue === false) return false;
                    if (!validar_campo(/[0-9]{11}/, inputValue)) {
                        swal.showInputError("El codigo de suministro es incorrecto");
                    }else if (default_suministro['CLICODFAC'] == inputValue) {
                        swal.showInputError("Seleccione otro suministro");
                    }else if (suministro!=null && suministro['CLICODFAC'] == inputValue) {
                        swal.showInputError("Seleccione otro suministro");
                    }else{
                        swal.disableButtons();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $this->config->item('ip'); ?>consulta/codigo-suministro?ajax=true",
                            data: {codigo_suministro: inputValue, tipo_comprobante:'boleta'},
                            dataType: 'json',
                            success: function(data) {
                                if(data.result) {
                                    $("#Form-CSum-span").show();
                                    //limpiar_cabecera();
                                    reset_form();                              
                                    suministro = data.propie;
                                    usr = data.usr;
                                    $("#Form-CSum").val(suministro['CLICODFAC']);
                                    $("#Form-NSum").val(suministro['CLINOMBRE']);
                                    $("#Form-TComp").focus();
                                    if(suministro['CLIRUC'] != null) { 
                                        buscar_ruc(suministro['CLIRUC']);
                                    }else{ 
                                        sweetAlert('Suministro no presenta RUC asociado', '', 'warning'); 
                                    }//sweetAlert(data.titulo, data.mensaje, data.tipo);
                                    return true;
                                }else{
                                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                                    return false;
                                }
                            }
                        });
                    }
            });
        }

        

        
    });

    function validar_registro(){
        $('#mensaje').empty();
        var correcto = true;
        //$("#NSUM-FIN").inputmask("d-m-y");
        correcto  = correcto && validar_campo(/[0-9]{11}/, $("#Form-Id").val());
        if(!validar_campo(/[0-9]{11}/, $("#Form-Id").val())){
            $('#Form-Id').focus();
            show_swal('warning', 'RUC incorrecto', 'Asegurese de completar correctamente el RUC', false, true, true);
            return false;
        }
        if($('#Form-Correo').val()!='' && !validar_campo(/\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,4})+/, $("#Form-Correo").val())){
            $('#Form-Correo').focus();
            show_swal('warning', 'Correo electronico incorrecto', 'Asegurese de completar correctamente el correo electronico', false, true, true);
            return false;
        }
        if($("#Form-Nom").val() == ''){
            show_swal('warning', 'Razon social incorrecta', 'Asegurese de completar el Rason social', false, true, true);
            return false;
        }
        if($("#Form-Dir").val()==''){
            $("#Form-Dir").focus();
            show_swal('warning', 'Direccion incorrecta', 'Asegurese de completar la direccion', false, true, true);
            return false;
        }

        if($("#detalle tbody tr").length==0){
            show_swal('warning', 'No existen conceptos registrados', 'Asegurese de ingresar al menos un concepto', false, true, true);
            return false;
        }
        //return false;
        return correcto;
    }

    function enviar ( jsoncliente){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>documentos/proformas/registrar_profoma/factura?ajax=true",
            data: {envio :jsoncliente},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    /*swal({
                        title: "Proforma Nro "+ data.codigo[0]['FSCSERNRO']+" - "+data.codigo[0]['FSCNRO'],
                        text: "La proforma fue registrada con exito",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        confirmButtonColor: "#296fb7",
                        confirmButtonText: "Aceptar",
                        showConfirmButton : true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }, function(valor){
                        window.location.replace('<?php echo base_url()."documentos/proformas"?>');
                    });]*/
                    swal("Se registro la Proforma", "Se registro la proforma con exito", "success");
                    window.location.replace('<?php echo $this->config->item('ip')."documentos/proformas"?>');
                    return true;
                }else{
                    swal("No se registro la Proforma", "Se produjo un problema al momento de registrar", "error");
                    //swal.close();
                    return false;
                }
            }
        });
    }

    function registrar(){
        var proforma = {};
        proforma['tipo-comprobante'] = 'FACTURA';
        proforma['tipo_identificacion'] = 'RUC';
        //proforma['identificacion'] = $('#Form-Id').val();
        proforma['FSCCLINOMB'] = $('#Form-Nom').val().toUpperCase();
        proforma['FSDIREC'] = $('#Form-Dir').val().toUpperCase();
        proforma['FSCDOC'] = $('#Form-Id').val();
        proforma['FSCCLIUNIC'] = $("#Form-CSum").val();
        proforma['EMAIL'] = $("#Form-Correo").val();
        proforma['OBSERVACION'] = $("#Form-Obs").val().toUpperCase();
        <?php if($oordserv != null) { ?>
            proforma['ordserv'] = <?php echo json_encode($oordserv); ?>;
        <?php } ?>
        <?php if($oordpag != null) { ?>
            proforma['ordpag'] = <?php echo json_encode($oordpag); ?>;
        <?php } ?>
        var tabla = [];
        var banEstado1 = 0;
        var banEstado2 = 0;
        for(i=1; i<$("#detalle tr").length; i++){
            
            $('#detalle  tr').eq(i).each(function () {
                var fila = {};
                fila['conigv'] = $(this).attr('conigv2');
                fila['gratuito'] = $(this).attr('gratuito');
                fila['exonerado'] = $(this).attr('exonerado');
                fila['observacion'] = $(this).attr('observacion');
                if(fila['gratuito'] == 1){
                    banEstado1 = 1;
                }else{
                    banEstado2 = 1;
                }
                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila['codigo']=$(this).text(); break;
                        case 1: break;
                        case 2: fila['precio']=$(this).text().replace(",",""); break;
                        case 3: fila['cantidad']=$(this).text(); break;
                        case 4: break;
                        case 5: break;
                    }
                });
                tabla.push(fila);
            });
        }
        if(banEstado1 == 1 && banEstado2 == 1 ){
            swal("Atención", "No puede ingresar conceptos gravados junto con gratuitos", "error");
        }else{
            var envio = {};
            if(banEstado1 == 1 && banEstado2 == 0){ // si es que solo contiene conceptos gratuitos
                proforma['GRATUITO'] = 1 ; 
            }
            if(banEstado1 == 0 && banEstado2 == 1){ // si es que solo contiene conceptos gravados
                proforma['GRATUITO'] = 0 ; 
            }
            proforma['tip_afecta_igv'] = $('#Tip_afectacion_igv').val();
            envio['proforma'] = proforma;
            envio['detalle'] = tabla;
            if(proforma['GRATUITO'] == 1 && (proforma['tip_afecta_igv'] ==10 || proforma['tip_afecta_igv'] ==20  || proforma['tip_afecta_igv'] ==30) ){
              swal("Atención", "No puede hacer una boleta gratuita con tipo de afectaciones Onerosas", "error");             
            }else{
                //jsoncliente = JSON.stringify(envio);
                //enviar(jsoncliente);
                enviar(envio);
            }
            
        }
        
        //return resultado;
    }

    function show_swal(tipo, titulo, mensaje, cancelbtn, clsconfirm, shconfirmbtn){
        swal({
            title: titulo,
            text: mensaje,
            type: tipo,
            showCancelButton: cancelbtn,
            closeOnConfirm: clsconfirm,
            confirmButtonColor: "#296fb7",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showConfirmButton : shconfirmbtn
        }, function(valor){
            return valor;
        });
    }
</script>


