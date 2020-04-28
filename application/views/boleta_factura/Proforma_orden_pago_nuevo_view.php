<!-- sweetAlert. -->
<link rel="stylesheet" href="./frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="./frontend/plugins/autocomplete/jquery.auto-complete.css">

<script src="./frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="./frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="./frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="./frontend/plugins/autocomplete/jquery.auto-complete.js" type="text/javascript"></script>
<script src="./frontend/plugins/input-mask/jquery.inputmask.js"></script>
<script src="./frontend/plugins/input-mask/jquery.inputmask.regex.extensions.js"></script>
<script>
    var usr = null;
</script>

<?php
    if (isset($modal_empresa)) {
        $this->load->view($modal_empresa, $this->data);
    }
    if (isset($modal_persona)) {
        $this->load->view($modal_persona);
    }
?>

<script>
    
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
            var precunit = parseFloat($(this).find('td').eq(2).text()||0, 10);
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

<section class="content">
    <div class="box  box-success">
        <div class="box-header with-border">
            <div class="col-md-6 col-sm-9">
                <h1 class="box-title"><?php echo $titulo; ?></h1>
            </div>
            <div class="col-md-6 col-sm-3" style="text-align:right;">
                <!--h1 class="box-title"><b>SERIE: </b>100</h1-->
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
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
                    <label class="control-label">SOL. ACCESO SERVICIO</label>
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
                        <input type="text" class="form-control" id="OORDPAG-CSUMCOD" disabled value="<?php echo $oordpag[0]['CLICOD'];?>" style='text-transform:uppercase;'>
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
                <div class="form-group col-md-4 col-sm-12">
                    <label for="tipo-comprobante">TIPO DE PROFORMA:</label>
                    <div class="controls">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i> 
                            </div>
                            <select class="form-control" id="Form-TComp" name="tipo-comprobante">
                                <!--option disabled selected value='-1'> -- selecciona una opcion -- </option-->
                                <option value="BOLETA">BOLETA</option>
                                <option value="FACTURA">FACTURA</option>
                            </select>
                            
                        </div>
                    </div>  
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for="documento">
                        DOCUMENTO: 
                        <a target="_blank" id="Form-Help"><i class="fa fa-eye"></i></a>
                        <a><i class="fa fa-times" id="Form-Reset"></i></a>
                    </label>
                    <div class="controls">
                        <div class="input-group">
                            <span class="input-group-addon" id="Form-TId">DNI</span>
                            <input class="form-control" id="Form-Id" name="documento" type="text">
                        </div>
                    </div>  
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for="tipo-comprobante">CORREO:</label>
                    <div class="controls input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope"></i> 
                        </div>
                        <input type="text" class="form-control" id="Form-Correo">
                    </div>
                </div>
                <div class="form-group col-md-12" id="div-Nom">
                    <label for="nombre">NOMBRE:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </div>
                        <input class="form-control" id="Form-Nom"  name="nombre" type="text" disabled>
                    </div>
                </div>
                <div class="form-group control-group col-md-12" id="div-Nom">
                    <label for="nombre">DIRECCION:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-home"></i>
                        </div>
                        <input class="form-control" id="Form-Dir"  name="nombre" type="text" style='text-transform:uppercase;'>
                    </div>
                </div>
                <div class="form-group control-group col-md-12 col-sm-12">
                    <label>OBSERVACION: </label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-eye"></i>
                        </span>
                        <input type="text" class="form-control" id="Form-Obs" style='text-transform:uppercase;'>
                    </div>
                </div>
            </div>
            <div class="row">
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
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-md-offset-8 col-sm-offset-8 col-xs-offset-0">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr id="precio-total">
                                            <tr id="precio-sub-total" style="display:none;">
                                                <th style="padding-right:10px;  text-align:right;">SUB TOTAL: S/</th>
                                                <td id="sub-total" style="text-align:right; font-size:20px;">0</td>
                                            </tr>
                                            <tr id="precio-igv" style="display:none;">
                                                <th style="padding-right:10px; text-align:right;">I.G.V. (<?php echo $_SESSION['IGV']; ?>%): S/</th>
                                                <td id="igv" style="text-align:right; font-size:20px;">0</td>
                                            </tr>
                                            <tr id="precio-total">
                                                <th style="padding-right:10px; text-align:right;">TOTAL: S/</th>
                                                <td id="total" style="text-align:right; color:#00f; font-size:20px;">--</td>
                                            </tr>
                                        </tr>
                                    </tbody>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="form-group col-md-12 col-sm-12" >
                <button class="btn btn-success" id="btn-registrar">REGISTRAR</button>
            </div>
        </div>
    </div>
</section> 


<script>

    var tipo = 'ninguno';

    $(document).ready(function(){
        obtener_subTotal();
        $("#Form-Id").inputmask("99999999");
        $("#Form-TComp").change(function(){

            var tipo = $("#Form-TComp option:selected").val();
            if(tipo == "FACTURA"){
                reset_form();
                $("#precio-sub-total").css("diplay", "block");
                $("#precio-igv").css("diplay", "block");
                
                $('#Form-TId').text('RUC');
                $('#Form-Help').attr('href', "<?php echo $rutabsq2; ?>");
                
                $("#precio-sub-total").show();
                $("#precio-igv").show();
                obtener_subTotal();
                $("#Form-Id").inputmask("99999999999");
            }else if(tipo == "BOLETA"){
                reset_form();
                $('#Form-TId').text('DNI');
                $('#Form-Help').attr('href', "<?php echo $rutabsq1; ?>");
                $("#precio-sub-total").hide();
                $("#precio-igv").hide();
                obtener_subTotal();
                $("#Form-Id").inputmask("99999999");
            }
        });

        $("#btn-registrar").click(function(){
            $("#mensaje").empty();
            //validar_registro();validar_registro()
            if(validar_registro()){
                //return;
                swal({
                    title: "Registrar proforma",
                    text: "Esta seguro que desea registrar esta proforma",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false,
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

        $("#Form-Id").focusout(function(){
            var tipo = $("#Form-TComp option:selected").val();
            if(tipo == "FACTURA"){
                if(validar_campo(/[0-9]{11}/, $('#Form-Id').val())){
                    buscar_ruc($('#Form-Id').val());
                }else{
                    $("#Form-Id").val("");
                }
                //obtener_subTotal();
            }else if(tipo == "BOLETA"){
                if(validar_campo(/[0-9]{8}/, $('#Form-Id').val())){
                    buscar_dni($('#Form-Id').val());
                }else{
                    $("#Form-Id").val("");
                }
                //obtener_subTotal();
            }
            /*if(validar_campo(/[0-9]{11}/, $('#Form-Id').val())){
                buscar_ruc($('#Form-Id').val());
            }else{
                $("#Form-Id").val("");
            }*/
        });

        $("#Form-Dir").focusout(function(){
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

        document.getElementById('Form-Id').onkeypress = function(e){
            if (!e) e = window.event;
            var keyCode = e.keyCode || e.which;
            if (keyCode != '13'){ 
                return ;
            }
            var tipo = $("#Form-TComp option:selected").val();
            if(tipo == "FACTURA"){
                if(validar_campo(/[0-9]{11}/, $('#Form-Id').val())){
                    buscar_ruc($('#Form-Id').val());
                }else{
                    $("#Form-Id").val("");
                }
                //obtener_subTotal();
            }else if(tipo == "BOLETA"){
                if(validar_campo(/[0-9]{8}/, $('#Form-Id').val())){
                    buscar_dni($('#Form-Id').val());
                }else{
                    $("#Form-Id").val("");
                }
                //obtener_subTotal();
            }
        }

        function reset_form(){
            usr = null;
            $("#Form-Id").attr('disabled', false);
            $("#Form-Id").val('');
            
            $("#Form-Correo").val('');
            $("#Form-Nom").val('');
            $("#Form-Dir").val('');
        }

        obtener_subTotal();
    });

    function buscar_dni(nro_dni){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>consulta/buscar-dni?ajax=true",
            data: {dni: nro_dni},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.dni){
                        usr = data.persona;
                        ("0000000" + usr['RUC']).slice (-8);
                        //alert(usr);
                        $('#Form-Id').attr('disabled', true);
                        $('#Form-Nom').val(usr['APEPAT']+' '+usr['APEMAT']+' '+usr['NOMBRE']);
                        $('#Form-Correo').val(usr['EMAIL']);
                        $('#Form-Dir').val(usr['DIREC']);
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                    }else{
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                        put_modregper_message(data.tipo, data.mensaje);
                        $('#MODREGPER-DNI').val(nro_dni),
                        $('#MODREGPER').modal("show");
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

    function buscar_ruc(nro_ruc){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>consulta/buscar-ruc?ajax=true",
            data: {ruc: nro_ruc},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.ruc){
                        usr = data.persona;
                        usr['RUC'] = ("0000000000" + usr['RUC']).slice (-11);
                        //alert(usr);
                        $('#Form-Id').val(usr['RUC']);
                        $('#Form-Id').attr('disabled', true);
                        $('#Form-Nom').val(usr['NOMBRE_O_RAZON_SOCIAL']);
                        //$('#Form-Dir')
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
                        }
                        $('#Form-Dir').val(direc);
                        //TIPO_DE_VIA, NOMBRE_DE_VIA, KILOMETRO, MANZANA, LOTE, 
                        //NUMERO, DEPARTAMENTO, INTERIOR, CODIGO_DE_ZONA, TIPO_DE_ZONA
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                        swal.close();
                    }else{
                        //sweetAlert(data.titulo, data.mensaje, data.tipo);
                        put_modregemp_message(data.tipo, data.mensaje);
                        $('#MODREGEMP-RUC').val(nro_ruc),
                        $('#MODREGEMP').modal("show");
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

    function validar_registro(){
        var correcto = false;
        console.log($("#Form-TI option:selected").val());
        if($("#Form-TComp option:selected").val() == "FACTURA"){
            correcto = validar_campo(/[0-9]{11}/, $('#Form-Id').val());
        }else{
            correcto = validar_campo(/[0-9]{8}/, $('#Form-Id').val());
        }
        if(!correcto){
            show_swal('warning', $("#Form-TId").text()+' incorrecto', 'Asegurese de completar correctamente el '+$("#Form-TId").text(), false, true, true);
            $('#Form-Id').focus();
            return false;
        }
        //console.log($("#detalle tbody tr").length);
        if(!validar_campo(/[A-Z]+( [A-Z]+)*/, $("#Form-Nom").val().toUpperCase())){
            $("#Form-Nom").focus();
            show_swal('warning', 'Nombre incorrecto', 'Asegurese de completar el nombre', false, true, true);
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
        return true;
    }

    function registrar(){
        var profns = {};    
            profns['EMPCOD'] = <?php echo $oordpag[0]['EMPCOD']; ?>;
            profns['OFICOD'] = <?php echo $oordpag[0]['OFICOD']; ?>;
            profns['ARECOD'] = <?php echo $oordpag[0]['ARECOD']; ?>;
            profns['CTDCOD'] = <?php echo $oordpag[0]['CTDCOD']; ?>;
            profns['DOCCOD'] = <?php echo $oordpag[0]['DOCCOD']; ?>;
            profns['SERNRO'] = <?php echo $oordpag[0]['SERNRO']; ?>;
            profns['ORPNRO'] = <?php echo $oordpag[0]['ORPNRO']; ?>;

        var proforma = {};
        proforma['tipo-comprobante'] = $("#Form-TComp option:selected").text();

        //proforma['region'] = $("#Form-Ubic option:selected").attr("region");
        //proforma['localidad'] = $("#Form-Ubic option:selected").attr("localidad")
        //proforma['zona'] = $("#Form-Ubic option:selected").attr("zona");

        proforma['tipo_identificacion'] = $('#Form-TId').text();
        //proforma['identificacion'] = $('#Form-Id').val();
        proforma['FSCCLINOMB'] = $('#Form-Nom').val().toUpperCase();
        proforma['FSDIREC'] = $('#Form-Dir').val().toUpperCase();
        proforma['FSCDOC'] = $('#Form-Id').val();
        proforma['FSCCLIUNIC'] = $('#OORDPAG-CSUMCOD').val();
        proforma['EMAIL'] = $('#Form-Correo').val();
        proforma['OBSERVACION'] = $("#Form-Obs").val().toUpperCase();
        var tabla = [];
        
        for(i=1; i<$("#detalle tr").length; i++){
            
            $('#detalle  tr').eq(i).each(function () {
                
                var fila = {};
                fila['conigv'] = $(this).attr('conigv2');
                fila['gratuito'] = $(this).attr('gratuito');
                fila['exonerado'] = $(this).attr('exonerado');
                fila['observacion'] = '';

                $(this).find('td').each(function (index) {
                    
                    switch (index){
                        case 0: fila['codigo']=$(this).text(); break;
                        case 1: break;
                        case 2: fila['precio']=$(this).text(); break;
                        case 3: fila['cantidad']=$(this).text(); break;
                        case 4: break;
                        case 5: break;
                    }
                });
                tabla.push(fila);
            });
        }
        //alert(proforma['FSDIREC']);
        var envio = {};
        envio['proforma'] = proforma;
        envio['profns'] = profns;
        envio['detalle'] = tabla;
        jsoncliente = JSON.stringify(envio);
        var resultado = null;
        console.log(jsoncliente);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>documentos/proformas/registrar_profoma/orden-pago?ajax=true",
            data: "envio="+jsoncliente,
            dataType: 'json',
            success: function(data) {
                //resultado = data.result;
                //alert(data.result);
                if(data.result) {
                    swal({
                        title: "Proforma Nro "+ data.codigo[0]['FSCSERNRO']+" - "+data.codigo[0]['FSCNRO'],
                        text: "Se registro la Proforma de Orden de Pago",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        confirmButtonColor: "#296fb7",
                        confirmButtonText: "Aceptar",
                        showConfirmButton : true
                    }, function(valor){
                        window.location.replace('<?php echo $this->config->item('ip')."documentos/proformas"?>');
                    });
                    //swal("Se registro la Proforma de Orden de Pago", "Se registro la proforma con exito", "success");
                    
                    return true;
                }else{
                    swal("No se registro la Proforma de Orden de Pago", "Se produjo un problema al momento de registrar", "error");
                    swal.close();
                    return false;
                }
            }
        });
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

