<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/autocomplete/jquery.auto-complete.css">


<section class="content">
<?php if(isset($_SESSION['mensaje'])) { ?>
    <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="font-text"><i class="icon fa fa-<?php echo ($_SESSION['mensaje'][0] == 'error') ? "ban" : "check" ?>"></i> <?php echo  ($_SESSION['mensaje'][0] == 'error') ? 'Error' : 'Ok'; ?></h4>
        <?php echo $_SESSION['mensaje'][1]; ?>
    </div>
<?php } ?>

<script>
    var reclamos = <?php echo json_encode($reclamos); ?>;
    console.table(reclamos);
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Solicitud de Atención de Problemas Particulares</h4>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group m-0"> 
                            <label class="control-label text-green">Busqueda por:</label>
                            <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i> 
                                </div>
                                <select class="form-control select2" id="tipoDoc" onchange="cambiarTipoDoc1()">
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
                            <label class="control-label text-green">Número de Documento</label>
                            <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i> 
                                </div>
                                <input type="text" id="numeroDoc" name="numeroDoc" class="form-control" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-info btn-block" style="margin-top:30px" onclick="buscarPersona()">Buscar</a>
                    </div>
                </div>
                <hr class="hr">
                <form style="margin:10px 20px 10px 20px" name="formularioSolicitudParticular" role="form" method="post" onsubmit="return validateMyForm();"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">N° de Suministro <span style='color:red;'>(*)</span></label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-compass"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="suministro" name="suministro" onKeyUp="return limitar(event,this.value,11)" onKeyDown="return limitar(event,this.value,11)" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Modalidad de Atención</label>
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
                        <h6>Nombre del solicitante o representante</h6>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Apellido Paterno <span style='color:red;'>(*)</span></label>
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
                                <label class="control-label text-green">Apellido Materno <span style='color:red;'>(*)</span> </label>
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
                                <label class="control-label text-green">Nombres <span style='color:red;'>(*)</span></label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="lista" id="lista" style="display:none" required>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Tipo de Documento</label>
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
                                <label class="control-label text-green">Documento</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="numero" name="numero" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Razon Social</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-building"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="razonSocial" name="razonSocial">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h6>Datos del solicitante</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Telefono</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="telefono" name="telefono" onKeyUp = "return limitar(event,this.value,9)" onKeyDown = "return limitar(event,this.value,9)">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Correo Electrónico</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"></i> 
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h6 >INFORMACIÓN DE LA SOLICITUD</h6>
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Tipo de problema</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-exclamation-circle"></i> 
                                    </div>
                                    <!--<input type="text" class="form-control" id="autocomplete">-->
                                    <select class="form-control select2" id="problema" name="problema" onchange="cambiarProblema()">
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
                            <!--<table id="reclamos" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoReclamos">
                                </tbody>
                            </table>-->
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Descripción del problema</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-exclamation-circle"></i> 
                                    </div>
                                    <input type="text" id="descripcion" name="descripcion" value="<?php echo $reclamos[0]['PROBDESC']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Breve descripción del problema presentado</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fa-keyboard-o"></i> 
                                    </div>
                                    <textarea class="form-control" name="presentacion" id="presentacion"  rows="5" style="width:100%" required></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <!--
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Área de Derivación</label>
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
                            <label class="control-label text-green">Glosa Derivación</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fa-keyboard-o"></i> 
                                    </div>
                                    <textarea class="form-control" name="glosa" id="glosa"  rows="3" style="width:100%" required></textarea>
                                </div>   
                        </div>
                    </div>  -->
                    <div class="row">
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
</section>
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
    var lista = []; 
    if(document.querySelector("#reclamos") !== null) $('#reclamos').DataTable({responsive: true,bSort:false,bInfo: false,"autoWidth": true,});
    /*$('#autocomplete').autocomplete({
        lookup: reclamos,
        onSelect: function (r) {
            let cuerpo = $("#cuerpoReclamos").html();
            console.log(cuerpo);
            if(cuerpo.trim() == '<tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">Sin Información en la tabla</td></tr>'){
                cuerpo = "";
            }
            $("#cuerpoReclamos").html("");
            $('#reclamos').dataTable().fnDestroy();
            cuerpo += `<tr id="${r.cpid}-${r.tipprobid}-${r.scatprobid}-${r.probid}">
                                <td>${r.cpid}-${r.tipprobid}-${r.scatprobid}-${r.probid}</td>
                                <td>${r.tipo}</td>
                                <td>${r.descripcion}</td>
                                <td class="text-center">
                                    <a class="btn btn-danger btn-icono" style="margin:0px" onclick="eliminarReclamo(${r.cpid}, ${r.tipprobid}, ${r.scatprobid}, ${r.probid})"> 
                                        <i class="fa fa-trash"></i>   
                                    </a>
                                </td>  
                            </tr>`; 
            $("#cuerpoReclamos").html(cuerpo)
            $('#reclamos').DataTable({responsive: true,bSort:false,bInfo: false,"autoWidth": true,});
            lista.push({'cpid': r.cpid, 'tipprobid' : r.tipprobid, 'scatprobid': r.scatprobid, 'probid' : r.probid, 'descripcion': r.descripcion , 'tipo' : r.tipo, 'tipo_problema':  r.tipo_problema})
            $("#lista").val(JSON.stringify(lista));
            $("#autocomplete").val("")
        }
    });*/
    $('.select2').select2()

    /*function eliminarReclamo(a, b, c, d){
        let eliminar = -1;
        lista.forEach( (e, i) => {
            if(e.cpid == a && e.tipprobid == b && e.scatprobid == c && e.probid == d){
                eliminar = i;
            }
        })
        if(eliminar != -1){
            lista.splice( eliminar, 1 );
            $("#"+a+"-"+b+"-"+c+"-"+d).remove();
            let cuerpo = $("#cuerpoReclamos").html();
            if(cuerpo.trim() == '<tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">Sin Información en la tabla</td></tr>'){
                cuerpo = "";
            }
            $("#cuerpoReclamos").html("");
            $('#reclamos').dataTable().fnDestroy();
            $("#cuerpoReclamos").html(cuerpo)
            $('#reclamos').DataTable({responsive: true,bSort:false,bInfo: false,"autoWidth": true,});
            $("#lista").val(JSON.stringify(lista));
        } else {
            alertify.error(`No se encontre el valor para eliminar`);
        }


    }*/

    /*let reclamos = <?php echo json_encode($reclamos ); ?>;

    console.log(reclamos);*/

    function cambiarProblema(){
        let opcion = $("#problema").val()
        console.log(opcion);
        var array = opcion.split("-").map(Number);
        for(let i = 0; i < reclamos.length; i++){
            if(reclamos[i]['CPID'] == array[0] && reclamos[i]['TIPPROBID'] == array[1] && reclamos[i]['SCATPROBID'] == array[2] && reclamos[i]['PROBID'] == array[3]){
                $("#descripcion").val(reclamos[i]['PROBDESC']);
            }
        }
        console.log(array);
    }

    function buscarPersona(){
        $("#modal1").modal('show')
        limpiar();
        let numero =  $("#numeroDoc").val();
        let tipo =  $("#tipoDoc").val();
        jQuery.ajax({
            type: 'POST',
            url : `${base_url}/${app}/relativo_no_facturacion/solicitud_particular/buscar?ajax=true`,
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
                        $("#apellido").val(data.persona.CLIAPELLPE);
                        $("#apellidoM").val(data.persona.CLIAPELLM);
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

    function validateMyForm() {
        let medio = $("#modalidad").val();
        // if(lista.length == 0){ 
        //     alertify.error(`Debe agregar uno o mas Tipos de Problemas`)
        //     return false;
        // }
        if(medio == 3){
            let email = $("#email").val()
            if(email.trim() == ""){
                alertify.error(`Como la modalidad de registro es web necesita un correo electrónico`);
                return false;
            }
        }
        if($("#suministro").val().length == 7 || $("#suministro").val().length == 11){
            
        } else {
            alertify.error(`El suministro debe tener 7 o 11 dígitos`);
            return false;
        }
        if($("#tipoDoc1 option:selected").text() == 'RUC'){
            let razonSocial = $("#razonSocial").val();
            if(razonSocial.trim() == ""){
                alertify.error(`Debe llenar la Razon Social de la Empresa`);
                return false;
            }
        }
        return true;
    }

    function limpiar(){
       
        $("#apellido").val("");
        $("#apellidoM").val("");
        $("#nombre").val("");
        $("#numero").val("");
        $("#calle").val("");
        $("#numeroM").val("");
        $("#urbanizacion").val("");
        $("#telefono").val("");
        $("#razonSocial").val("");
        $("#cuerpoReclamos").val("")

    }
    
    function cambiarProvincia(){
       let provincia = $("#provincia").val();
       jQuery.ajax({
            type: 'POST',
            url : `${base_url}/${app}/relativo_no_facturacion/solicitud_particular/cambiarProvincia?ajax=true`,
            data: ({
                token :  localStorage.getItem('token'),
                provincia
            }),
            dataType: 'json',
            cache:  false,
            success : function (data, status, xhr) {
                if(data.res){
                    $('#distrito').val(null).trigger('change');
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
                    //$("#distrito").html(contenido);
                    //console.log(data.distritos)
                } else {
                    showAlert(data.msg, `alert`);
                }
            }
        }).fail( function(xhr,status,error){
            errorAjax(xhr, status, error);   
        });
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