<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/autocomplete/jquery.auto-complete.css">

<div class="content">

<?php if(isset($_SESSION['mensaje'])) { ?>
    <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="font-text"><i class="icon fa fa-<?php echo ($_SESSION['mensaje'][0] == 'error') ? "ban" : "check" ?>"></i> <?php echo  ($_SESSION['mensaje'][0] == 'error') ? 'Error' : 'Ok'; ?></h4>
        <?php echo $_SESSION['mensaje'][1]; ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title" style="font-family:Ubuntu">Solicitud de Atención de Problemas de Alcance General</h4>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group m-0"> 
                            <label class="control-label text-blue">Busqueda por:</label>
                            <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i> 
                                </div>
                                <select class="form-control select2" id="tipoDoc" onchange="cambiarTipoDoc1()" >
                                    <?php foreach($tipoDoc as $t) {?>
                                        <option value="<?php echo $t['TIPDOCCOD']?>" <?php echo ($t['TIPDOCDESCABR'] == 'DNI' ? "selected" : "")?>><?php echo $t['TIPDOCDESCABR']; ?></option>
                                    <?php }?>
                                    <option value="8">SUMINISTRO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="form-group m-0"> 
                            <label class="control-label text-blue">Número de Documento</label>
                            <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i> 
                                </div>
                                <input type="text" id="numeroDoc" name="numeroDoc" class="form-control" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-info btn-sm" style="margin-top:30px;width:100%" onclick="buscarPersona()">Buscar</a>
                    </div>
                </div>
                <hr class="hr">

                <form style="margin:10px 20px 10px 20px" name="formularioSolicitudParticular" role="form" method="post" onsubmit="return validateMyForm();">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0">  
                                <label class="control-label text-blue">N° de Suministro</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-compass"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="suministro" name="suministro" onKeyUp="return limitar(event,this.value,11)" onKeyDown="return limitar(event,this.value,11)">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Modalidad de Atención</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-th-large"></i> 
                                    </div>
                                    <select class="form-control select2" name="modalidad" id="modalidad">
                                        <?php $k = 0; foreach($medios as $m) {?>    
                                            <option value="<?php echo $m['MOACOD']; ?>" <?php echo ($k == 0 ? 'selected' : ''); ?>><?php echo $m['MOADES'] ?></option>
                                        <?php $k++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h5 class="text-green" style="font-family:Ubuntu">Nombre del solicitante o representante</h5 >
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Apellido Paterno <span style='color:red;'>(*)</span> </label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Apellido Materno <span style='color:red;'>(*)</span></label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="apellidoM" name="apellidoM" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue"> Nombres <span style='color:red;'>(*)</span></label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Tipo de Documento</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <select class="form-control select2" id="tipoDoc1" name="tipoDoc1" onchange="cambiarTipoDoc()">
                                        <?php foreach($tipoDoc as $t) {?>
                                            <option value="<?php echo $t['TIPDOCCOD']?>" <?php echo ($t['TIPDOCDESCABR'] == 'DNI' ? "selected" : "")?>><?php echo $t['TIPDOCDESCABR']; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Documento <span style='color:red;'>(*)</span></label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" name="numero" id="numero" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Razon Social</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-building"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="razonSocial">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h5 class="text-green" style="font-family:Ubuntu">Datos del solicitante</h5>
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Calle, Jiron, Avenida <span style='color:red;'>(*)</span></label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="calle" name="calle">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">N°</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="numeroM" name="numeroM">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Mz</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="manzana" name="manzana">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Lote</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="lote" name="lote">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Provincia</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2" id="provincia" name="provincia" >
                                        <?php $k=0;foreach($provincias as $p){?>
                                            <option value="<?php echo $p['CPVCOD']; ?>" <?php echo ($k == 0 ? 'selected' : '') ?>><?php echo trim($p['CPVDES']) ?></option>
                                        <?php $k++;} ?> 
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Distrito</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2"  id="distrito" name="distrito" >
                                        <?php $k=0;foreach($distritos as $d){?>
                                            <option value="<?php echo $d['CDSCOD']; ?>" <?php echo ($k == 0 ? 'selected' : '') ?>><?php echo $d['CDSDES'] ?></option>
                                        <?php $k++;} ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Grupo poblacional</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2"  id="grupo_poblacional" name="grupo_poblacional" >
                                        <?php $k=0;foreach($grupo_pobla as $d){?>
                                            <option value="<?php echo $d['CGPCOD']; ?>" <?php echo ($k == 0 ? 'selected' : '') ?>><?php echo $d['CGPDES'] ?></option>
                                        <?php $k++;} ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Via</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2"  id="via_pobla" name="via_pobla">
                                        <?php $k=0;foreach($via_pobla as $d){?>
                                            <option value="<?php echo $d['MVICOD']; ?>" <?php echo ($k == 0 ? 'selected' : '') ?>><?php echo $d['MVIDES'] ?></option>
                                        <?php $k++;} ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Urbanización , Barrio</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="urbanizacion" name="urbanizacion">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Telefono</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="telefono" name="telefono" onKeyUp = "return limitar(event,this.value,9)" onKeyDown = "return limitar(event,this.value,9)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h5 class="text-green" style="font-family:Ubuntu">INFORMACIÓN DE LA SOLICITUD</h5>
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Tipo de problema</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-exclamation-circle"></i> 
                                    </div>
                                    <select class="form-control select2" id="problema" name="problema" >
                                        <?php foreach($reclamos as $r){?>
                                            <option value="<?php echo $r['CPID']."-".$r['TIPPROBID']."-".$r['SCATPROBID']."-".$r['PROBID']; ?>"><?php echo $r['PROBABR']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Breve descripción del problema presentado</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fa-keyboard-o"></i> 
                                    </div>
                                    <textarea class="form-control" name="descripcion" id="descripcion"  rows="5" style="width:100%"></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <!--
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-blue">Área de Derivación</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-exclamation-circle"></i> 
                                    </div>
                                
                                    <select class="form-control select2" id="area" name="area">
                                        <?php $k = 0; foreach($areas as $r){?>
                                            <option value="<?php echo $r['ARECOD']; ?>" <?php (($k == 0) ? "selected" : "") ?>><?php echo $r['AREDES']; ?></option>
                                        <?php $k++;} ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label text-blue">Glosa Derivación</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fa-keyboard-o"></i> 
                                    </div>
                                    <textarea class="form-control" name="glosa" id="glosa"  rows="3" style="width:100%" required></textarea>
                                </div>   
                        </div>
                    </div> -->
                    <div class="row" style ='margin-top:15px;'>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button class="btn btn-success btn-block">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <center>
            <img style="margin-top:25%" src="<?php echo $this->config->item('ip').'frontend/img/load.gif'; ?>" alt="">
        </center>
    </div>
</div>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/autocomplete/jquery.auto-complete.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/>
<script>

var base_url = window.location.origin
var app = `GeneSys4` 

    $(".select2").select2();

    $(document).ready(function() {
        $('#provincia').on('select2:select', function (e) {
            cambiarProvincia();
        });

        $('#distrito').on('select2:select', function (e) {
            cambiarDistrito();
        });
        
        $('#grupo_poblacional').on('select2:select', function (e) {
            cambiarGrupoPobla();
        });
        
    });

    function buscarPersona(){
        $("#modal1").modal('show')
        limpiar();
        let numero =  $("#numeroDoc").val();
        let tipo =  $("#tipoDoc").val();
        jQuery.ajax({
            type: 'POST',
            url : `${base_url}/${app}/relativo_no_facturacion/solicitud_general/buscar?ajax=true`,
            data: ({
                numero, 
                tipo
            }),
            dataType: 'json',
            cache:  false,
            success : function (data, status, xhr) {
                $("#modal1").modal('hide')
                if(data.res){
                    if(tipo != 8 && tipo != 6){
                        $("#apellido").val(data.persona.APEPAT);
                        $("#apellidoM").val(data.persona.APEMAT);
                        $("#nombre").val(data.persona.NOMBRE);
                        $("#calle").val(data.persona.TIPO_DE_VIA+" "+data.persona.NOMBRE_DE_VIA);
                        $("#numeroM").val(data.persona.NUMERO);
                        $("#urbanizacion").val(data.persona.CODIGO_DE_ZONA+" "+data.persona.TIPO_DE_ZONA);
                        $("#telefono").val(data.persona.TELCEL);
                        $('#tipoDoc1').val(tipo).trigger('change');
                        cambiarTipoDoc();
                        $("#numero").val(data.persona.NRODOC); 
                    } else if(tipo == 6) {
                        console.log(data.persona);
                        $("#razonSocial").val(data.persona.NOMBRE_O_RAZON_SOCIAL)
                        $("#urbanizacion").val(data.persona.TIPO_DE_ZONA)
                        $("#calle").val(data.persona.TIPO_DE_VIA + " " +data.persona.NOMBRE_DE_VIA)
                        $("#numeroM").val(data.persona.NUMERO)
                        $("#manzana").val(data.persona.MANZANA)
                        $("#lote").val(data.persona.LOTE)
                        $("#telefono").val(data.persona.TELCEL)
                        $('#tipoDoc1').val(6).trigger('change'); 
                        cambiarTipoDoc();
                        $("#numero").val(data.persona.RUC)
                    } else {
                        $("#suministro").val(data.persona.CLICODFAC);
                        $("#apellido").val(data.persona.CLIAPELLM);
                        $("#apellidoM").val(data.persona.CLIAPELLPE);
                        $("#nombre").val(data.persona.CLINOMBR1+ " "+ data.persona.CLINOMBR2);
                        $("#numeroM").val(data.persona.NUMERO);
                        $("#urbanizacion").val(data.persona.URBANIZACION);
                        if( data.persona.DNI != null) $('#tipoDoc').val(1).trigger('change');
                        else $('#tipoDoc1').val(6).trigger('change');
                        cambiarTipoDoc();
                        $("#numero").val( data.persona.DNI != null ? data.persona.DNI : data.persona.RUC);
                    }
                    //window.location.reload();
                } else {
                    alertify.error(`No se encontro al usuario buscado, rellene todos los campos`);
                    //showAlert(data.msg, `alert`);
                }
            }
        }).fail( function(xhr,status,error){
            $("#modal1").modal('hide')
            errorAjax(xhr, status, error);   
        });
    }

    function errorAjax(xhr, status, error){
        let message = ``
        if(xhr.status === 0) message = `No se puede conexta, verifique su conexión a Internet.`
        else if(xhr.status == 404) message = `No se puedo encontrar la solicitud requerida.`
        else if(xhr.status == 500) message = `Ocurrió un error interno en el servidor.`
        else if(status == 'parsererror') message = `La solicitud requerida falló.`
        else if(status == 'timeout') message = `Caduco el tiempo de solicitud.`
        else if(status == 'abort') message = `La solicitud ha sido cancelada.`
        showAlert(message, `error`)
    }

    function showAlert(msg, type){
        if(type == `error`)
            alertify.alert('<span class="text-red font-text"><i class="fa fa-times" aria-hidden="true"></i> Error</span>', msg)
        else if(type == `alert`)
            alertify.alert('<span class="text-yellow font-text"><i class="fa fa-exclamation" aria-hidden="true"></i> Alerta</span>', msg)
        else if(type == `ok`)
            alertify.alert('<span class="text-green font-text"><i class="fa fa-check" aria-hidden="true"></i> Ok</span>', msg)
    }

    function limpiar(){
       
       $("#apellidoP").val("");
       $("#apellidoM").val("");
       $("#nombre").val("");
       $("#numero").val("");
       $("#calle").val("");
       $("#numeroM").val("");
       $("#urbanizacion").val("");
       $("#telefono").val("");
       $("#razonSocial").val("");

   }


   function cambiarProvincia(){
       let provincia = $("#provincia").val();
       jQuery.ajax({
            type: 'POST',
            url : `${base_url}/${app}/relativo_no_facturacion/solicitud_general/cambiarProvincia?ajax=true`,
            data: ({
                provincia
            }),
            dataType: 'json',
            cache:  false,
            success : function (data, status, xhr) {
                if(data.res){
                    /* DISTRITO */
                    //$('#distrito').val(null).trigger('change');
                    $("#distrito").html("");
                    let contenido =  "";
                    let i = 0;
                    data.distritos.forEach( e => {
                        if(i == 0) var newOption = new Option(e.CDSDES, e.CDSCOD, true, false);
                        else var newOption = new Option(e.CDSDES, e.CDSCOD, false, false);
                        // Append it to the select
                        $('#distrito').append(newOption).trigger('change');
                        i++;
                    })
                    /* GRUPO POBLACIONAL */ 
                    $('#grupo_poblacional').val(null).trigger('change');
                    $("#grupo_poblacional").html("");
                    if(data.grupo_pobla != ''){
                        contenido =  "";
                        i = 0;
                        data.grupo_pobla.forEach( e => {
                            if(i == 0) var newOption = new Option(e.CGPDES, e.CGPCOD, true, false);
                            else var newOption = new Option(e.CGPDES, e.CGPCOD, false, false);
                            // Append it to the select
                            $('#grupo_poblacional').append(newOption).trigger('change');
                            i++;
                        })
                    }
                    /*VIA*/
                    $('#via_pobla').val(null).trigger('change');
                    $("#via_pobla").html("");
                    if(data.via != ''){
                        contenido =  "";
                        i = 0;
                        data.via.forEach( e => {
                            if(i == 0) var newOption = new Option(e.MVIDES, e.MVICOD, true, false);
                            else var newOption = new Option(e.MVIDES, e.MVICOD, false, false);
                            // Append it to the select
                            $('#via_pobla').append(newOption).trigger('change');
                            i++;
                        })
                    }
                } else {
                    showAlert(data.msg, `alert`);
                }
            }
        }).fail( function(xhr,status,error){
            errorAjax(xhr, status, error);   
        });
   }


  function cambiarDistrito(){
    let provincia = $("#provincia").val();
    let distrito = $("#distrito").val();
       jQuery.ajax({
            type: 'POST',
            url : `${base_url}/${app}/relativo_no_facturacion/solicitud_general/cambiarDistrito?ajax=true`,
            data: ({
                provincia,
                distrito
            }),
            dataType: 'json',
            cache:  false,
            success : function (data, status, xhr) {
                if(data.res){
                    
                    /* GRUPO POBLACIONAL */ 
                    
                    $('#grupo_poblacional').val(null).trigger('change');
                    $("#grupo_poblacional").html("");
                    let contenido =  "";
                    let i = 0;
                    if(data.grupo_pobla != ''){
                        data.grupo_pobla.forEach( e => {
                            if(i == 0) var newOption = new Option(e.CGPDES, e.CGPCOD, true, false);
                            else var newOption = new Option(e.CGPDES, e.CGPCOD, false, false);
                            // Append it to the select
                            $('#grupo_poblacional').append(newOption).trigger('change');
                            i++;
                        })
                    }
                    /*VIA*/
                    $('#via_pobla').val(null).trigger('change');
                    $("#via_pobla").html("");
                    if(data.via != ''){
                        contenido =  "";
                        i = 0;
                        data.via.forEach( e => {
                            if(i == 0) var newOption = new Option(e.MVIDES, e.MVICOD, true, false);
                            else var newOption = new Option(e.MVIDES, e.MVICOD, false, false);
                            // Append it to the select
                            $('#via_pobla').append(newOption).trigger('change');
                            i++;
                        })
                    }
                } else {
                    /* GRUPO POBLACIONAL */ 
                    $('#grupo_poblacional').val(null).trigger('change');
                    $("#grupo_poblacional").html("");
                    /*VIA*/
                    $('#via_pobla').val(null).trigger('change');
                    $("#via_pobla").html("");
                }
            }
        }).fail( function(xhr,status,error){
            errorAjax(xhr, status, error);   
        });
    }



    function cambiarGrupoPobla(){
        let provincia = $("#provincia").val();
        let distrito = $("#distrito").val();
        let grupo_pobla = $("#grupo_poblacional").val();
        if(grupo_pobla != null){
            jQuery.ajax({
                type: 'POST',
                url : `${base_url}/${app}/relativo_no_facturacion/solicitud_general/cambiarGrupoPobla?ajax=true`,
                data: ({
                    provincia,
                    distrito ,
                    grupo_pobla
                }),
                dataType: 'json',
                cache:  false,
                success : function (data, status, xhr) {
                    if(data.res){
                        /*VIA*/
                        $('#via_pobla').val(null).trigger('change');
                        $("#via_pobla").html("");
                        let contenido =  "";
                        let i = 0;
                        if(data.via != ''){
                            data.via.forEach( e => {
                                if(i == 0) var newOption = new Option(e.MVIDES, e.MVICOD, true, false);
                                else var newOption = new Option(e.MVIDES, e.MVICOD, false, false);
                                $('#via_pobla').append(newOption).trigger('change');
                                i++;
                            })
                        }
                    }else{
                        /*VIA*/
                        $('#via_pobla').val(null).trigger('change');
                        $("#via_pobla").html("");
                    }
                }
            }).fail( function(xhr,status,error){
                errorAjax(xhr, status, error);   
            });
        }

    }



    function limitar(e, contenido, tam){
        var unicode=e.keyCode? e.keyCode : e.charCode;
        if (unicode < 48){
            if(unicode==8 || unicode==46 || unicode==13 || unicode==9 || unicode==37 || unicode==39 || unicode==38 || unicode==40) return true;
            else return false    
        } else if(((unicode >= 48 && unicode <= 57) || (unicode >= 96 && unicode <= 105) ) && contenido.length<=tam-1){
            return unicode
        } else {
            return false
        }
    }

    function limitar1(e, contenido, tam){
        var unicode=e.keyCode? e.keyCode : e.charCode;
        if(unicode==8 || unicode==46 || unicode==13 || unicode==9 || unicode==37 || unicode==39 || unicode==38 || unicode==40) 
            return true;
        if(contenido.length>=tam)
            return false;
        return true;
    }

    const validateMyForm = () => true

    function cambiarTipoDoc(){
        let valor = $("#tipoDoc1").val();
        $("#numero").val("");
        if(valor == 1){
            $("#numero").attr('onKeyUp', "return limitar(event,this.value,8)");
            $("#numero").attr('onKeyDown', "return limitar(event,this.value,8)");
        } else if(valor == 6){
            $("#numero").attr('onKeyUp', "return limitar(event,this.value,11)");
            $("#numero").attr('onKeyDown', "return limitar(event,this.value,11)");
        } else if(valor == 4 || valor == 7){
            $("#numero").attr('onKeyUp', "return limitar1(event,this.value,12)")
            $("#numero").attr('onKeyDown', "return limitar1(event,this.value,12)")
        } else {
            $("#numero").attr('onKeyUp', "return limitar1(event,this.value,15)")
            $("#numero").attr('onKeyDown', "return limitar1(event,this.value,15)")
        }
    }

    function cambiarTipoDoc1(){
        $("#numeroDoc").val("")
        let valor = $("#tipoDoc").val();
        if(valor == 1){
            $("#numeroDoc").attr('onKeyUp', "return limitar(event,this.value,8)");
            $("#numeroDoc").attr('onKeyDown', "return limitar(event,this.value,8)");
        } else if(valor == 6 || valor == 8){
            $("#numeroDoc").attr('onKeyUp', "return limitar(event,this.value,11)");
            $("#numeroDoc").attr('onKeyDown', "return limitar(event,this.value,11)");
        } else if(valor == 4 || valor == 7){
            $("#numeroDoc").attr('onKeyUp', "return limitar1(event,this.value,12)")
            $("#numeroDoc").attr('onKeyDown', "return limitar1(event,this.value,12)")
        } else {
            $("#numeroDoc").attr('onKeyUp', "return limitar1(event,this.value,15)")
            $("#numeroDoc").attr('onKeyDown', "return limitar1(event,this.value,15)")
        }
    }

</script>