<link rel="stylesheet" href="<?php echo $this->config->item('url') ?>frontend/appbuild/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('url') ?>frontend/appbuild/autocomplete/jquery.auto-complete.css">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Reclamo por el servicio de monitoreo y Géstion de Uso de Aguas Subterraneas</h4>
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
                                <input type="text" id="numeroDoc" name="numeroDoc" class="form-control" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)" >
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
                                <label class="control-label text-green">N° de Suministro</label>
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
                                    <select class="form-control select2" name="modalidad" id="madalidad">
                                        <?php $k = 0; foreach($medios as $m) {?>    
                                            <option value="<?php echo $m['MOACOD']; ?>"><?php echo $m['MOADES'] ?></option>
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
                                <label class="control-label text-green">Apellido Paterno</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="apellidoP" name="apellidoP" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Apellido Materno</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="apellidoM"¨name="apellidoM" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Nombres</label>
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
                                    <input type="text" class="form-control" id="numero" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)" required>
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
                                    <input type="text" class="form-control" id="razonSocial">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h6>Ubicación del Predio / Fuente de Agua o  Pozo</h6>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Avenida, Calle, Jirón, Pasaje, Carretera, Otro</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="direccion" name="dirrecion">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Número</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="numeroPozo" name="numeroPozo" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Mz.</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="manzanaPozo" name="manzanaPozo" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Lote.</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="lotePozo" name="lotePozo" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Kilométro</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="kilometroPozo" name="kilometroPozo" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Departamento</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2" id="departamento" >
                                        <option value="<?php echo $departamento['CDPCOD']; ?>"><?php echo $departamento['CDPDES'] ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Provincia</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2" id="provincia"  onchange="cambiarProvincia()">
                                        <?php foreach($provincias as $p){?>
                                            <option value="<?php echo $p['CPVCOD']; ?>"><?php echo $p['CPVDES'] ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Distrito</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2"  id="distrito">
                                        <?php foreach($distritos as $d){?>
                                            <option value="<?php echo $d['CDSCOD']; ?>"><?php echo $d['CDSDES'] ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                            
                    </div>

                    <div class="row">
                        <h6>Domicilio Procesal</h6>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Avenida, Calle, Jirón, Pasaje, Carretera, Otro</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="direccionP" name="dirrecion">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Número</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="numeroPorcesal" name="numeroPorcesal" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Mz.</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="manzanaProcesal" name="manzanaProcesal" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Lote.</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="loteProcesal" name="loteProcesal" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Kilométro</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="kilometroProcesal" name="kilometroProcesal" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Departamento</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2" id="departamentoP" >
                                        <option value="<?php echo $departamento['CDPCOD']; ?>"><?php echo $departamento['CDPDES'] ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Provincia</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2" id="provinciaP" onchange="cambiarProvincia1()">
                                        <?php foreach($provincias as $p){?>
                                            <option value="<?php echo $p['CPVCOD']; ?>"><?php echo $p['CPVDES'] ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Distrito</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <select class="form-control select2"  id="distritoP">
                                        <?php foreach($distritos as $d){?>
                                            <option value="<?php echo $d['CDSCOD']; ?>"><?php echo $d['CDSDES'] ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                            
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Código Postal</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="codigoPostal" name="codigoPostal"  onKeyUp = "return limitar(event,this.value,6)" onKeyDown = "return limitar(event,this.value,6)">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Télefono / Celular</label>
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
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Licencia de uso de agua subterráneas</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="licencia" name="licencia">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Materia Reclamada</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file"></i> 
                                    </div>
                                    <input type="text" class="form-control" id="materia" name="materia">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">Breve descripción del Reclamo</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fa-keyboard-o"></i> 
                                    </div>
                                    <textarea class="form-control" name="descripcion" id="descripcion"  rows="5" style="width:100%"></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">FUNDAMENTO DEL RECLAMO (En caso de ser necesario, se podrán adjuntar páginas adicionales)</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fa-keyboard-o"></i> 
                                    </div>
                                    <textarea class="form-control" name="fundamento" id="fundamento"  rows="5" style="width:100%"></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-0"> 
                                <label class="control-label text-green">MEDIOS PROBATORIOS</label>
                                <div class="input-group" style="    margin: 0px 0px 5px 10px;">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fa-keyboard-o"></i> 
                                    </div>
                                    <textarea class="form-control" name="medios" id="medios"  rows="5" style="width:100%"></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>


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
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <center>
            <img style="margin-top:25%" src="<?php echo $this->config->item('url').'frontend/img/load.gif'; ?>" alt="">
        </center>
    </div>
</div>
<script src="<?php echo $this->config->item('url') ?>frontend/appbuild/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo $this->config->item('url') ?>frontend/appbuild/autocomplete/jquery.auto-complete.js" type="text/javascript"></script>
<script>
    $('.select2').select2()

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

    function buscarPersona(){
        $("#modal1").modal('show')
        limpiar();
        let numero =  $("#numeroDoc").val();
        let tipo =  $("#tipoDoc").val();
        jQuery.ajax({
            type: 'POST',
            url : `${base_url}/${app}/relativo_no_facturacion/solicitud_particular/buscar`,
            data: ({
                token :  localStorage.getItem('token'),
                numero, 
                tipo
            }),
            dataType: 'json',
            cache:  false,
            success : function (data, status, xhr) {
                $("#modal1").modal('hide')
                if(data.res){
                    if(tipo != 8 && tipo != 6){
                        $("#apellidoP").val(data.persona.APEPAT);
                        $("#apellidoM").val(data.persona.APEMAT);
                        $("#nombre").val(data.persona.NOMBRE);
                        $("#direccionP").val(data.persona.TIPO_DE_VIA+" "+data.persona.NOMBRE_DE_VIA);
                        $("#numeroPorcesal").val(data.persona.NUMERO);
                        //$("#direccionP").val(data.persona.CODIGO_DE_ZONA+" "+data.persona.TIPO_DE_ZONA);
                        $("#telefono").val(data.persona.TELCEL);
                        $('#tipoDoc1').val(tipo).trigger('change');
                        cambiarTipoDoc();
                        $("#numero").val(data.persona.NRODOC);
                    } else if(tipo == 6) {
                        console.log(data.persona);
                        $("#razonSocial").val(data.persona.NOMBRE_O_RAZON_SOCIAL)
                        //$("#direccionP").val(data.persona.TIPO_DE_ZONA)
                        $("#direccionP").val(data.persona.TIPO_DE_VIA + " " +data.persona.NOMBRE_DE_VIA)
                        $("#numeroPorcesal").val(data.persona.NUMERO)
                        $("#manzana").val(data.persona.MANZANA)
                        $("#lote").val(data.persona.LOTE)
                        $("#telefono").val(data.persona.TELCEL)
                        $('#tipoDoc1').val(6).trigger('change');
                        cambiarTipoDoc();
                        $("#numero").val(data.persona.RUC)
                    } else {
                        $("#suministro").val(data.persona.CLICODFAC);
                        $("#apellidoM").val(data.persona.CLIAPELLM);
                        $("#direccionP").val(data.persona.CLIAPELLPE);
                        $("#nombre").val(data.persona.CLINOMBR1+ " "+ data.persona.CLINOMBR2);
                        $("#numeroPorcesal").val(data.persona.NUMERO);
                        $("#direccionP").val(data.persona.URBANIZACION);
                        if( data.persona.DNI != null) $('#tipoDoc').val(1).trigger('change');
                        else $('#tipoDoc1').val(6).trigger('change');
                        cambiarTipoDoc();
                        $("#numero").val( data.persona.DNI != null ? data.persona.DNI : data.persona.RUC);
                    }
                    
                    //window.location.reload();
                } else {
                    showAlert(data.msg, `alert`);
                }
            }
        }).fail( function(xhr,status,error){
            $("#modal1").modal('hide')
            errorAjax(xhr, status, error);   
        });
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
            url : `${base_url}/${app}/relativo_no_facturacion/agua_subterranea/cambiarProvincia`,
            data: ({
                token :  localStorage.getItem('token'),
                provincia
            }),
            dataType: 'json',
            cache:  false,
            success : function (data, status, xhr) {
                if(data.res){
                    $("#distrito").html("");
                    let contenido =  "";
                    data.distritos.forEach( e => {
                        contenido += `<option value="${e.CDSCOD}">${e.CDSDES}</option>`;
                    })
                    $("#distrito").html(contenido);
                    console.log(data.distritos)
                } else {
                    showAlert(data.msg, `alert`);
                }
            }
        }).fail( function(xhr,status,error){
            errorAjax(xhr, status, error);   
        });
   }

   function cambiarProvincia1(){
       let provincia = $("#provinciaP").val();
       jQuery.ajax({
            type: 'POST',
            url : `${base_url}/${app}/relativo_no_facturacion/agua_subterranea/cambiarProvincia`,
            data: ({
                token :  localStorage.getItem('token'),
                provincia
            }),
            dataType: 'json',
            cache:  false,
            success : function (data, status, xhr) {
                if(data.res){
                    $("#distritoP").html("");
                    let contenido =  "";
                    data.distritos.forEach( e => {
                        contenido += `<option value="${e.CDSCOD}">${e.CDSDES}</option>`;
                    })
                    $("#distritoP").html(contenido);
                    console.log(data.distritos)
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

    function validateMyForm(){
        return true;
    }

</script>