<!-- sweetAlert. -->
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>


<section class="content">   
    <div class="row">
        <div class="col-md-12">
            
            
            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $proceso; ?></h3>
                </div>

                <div class="box-body" >
                    
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label for="tipo-comprobante">TIPO:</label>
                            <div class="controls">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <input class="form-control" type="text" value="<?php echo ($proforma['cliente']['FSCTIPO']==1)? 'PROFORMA FACTURA':'PROFORMA BOLETA'; ?>" readonly>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group  control-group col-md-4 col-sm-12">
                            <label for="ubicacion">SERIE - NUMERO:</label>
                            <div class="controls">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <input class="form-control" type="text" value="<?php echo $proforma['cliente']['FSCSERNRO'].'-'.str_pad($proforma['cliente']['FSCNRO'], 6, '0', STR_PAD_LEFT); ?>" readonly>
                                </div><!-- /.input group -->
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-4 col-sm-12">
                            <label for="documento"><?php echo ($proforma['cliente']['FSCTIPDOC']==1)? "DNI:":"RUC:" ?></label>
                            <div class="controls">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <input class="form-control" type="text" value="<?php echo ($proforma['cliente']['FSCTIPDOC']==1)? $proforma['cliente']['FSCNRODOC']:$proforma['cliente']['FSCCLIRUC'] ?>" readonly>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group control-group col-md-12" id="div-Nom">
                            <label for="nombre">NOMBRE:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" id="basic-url" value="<?php echo $proforma['cliente']['FSCCLINOMB'] ?>" readonly>
                            </div>
                        </div>
                        <div class="box box-primary col-md-12 col-sm-12" style="width:95%; margin-left:20px; padding-top:10px;">
                            <div class="table-responsive">
                                <table id="detalle" class="table table-bordered table-striped">
                                    <thead>
                                        <tr role="row">
                                            <th style="text-align:center;">CODIGO</th>
                                            <th style="text-align:center;">DESCRIPCION</th>
                                            <th style="text-align:center;">PRECIO UNIT</th>
                                            <th style="text-align:center;">CANTIDAD</th>
                                            <th style="text-align:center;">IMPORTE</th>
                                            <?php if($proforma['cliente']['FSCTIPO']==1){?>
                                            <th style="text-align:center;">IGV</th>
                                            <th style="text-align:center;">AFECTACIÓN</th>
                                            <?php }?>
                                            <th style="text-align:center;">OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($proforma['descripcion'] as $fila) { 
                                            $eli = $fila['ELIM'];
                                            $dato_igv=round(($proforma['cliente']['FSCIGVREF']/100),2);
                                            $p_importe=round(($fila['CANT']*($fila['PUNIT']/(1+$dato_igv))),2);
                                            $observacion = ($fila['OBSFACAUX'] == '' || $fila['OBSFACAUX'] == null)? '':(' - '.$fila['OBSFACAUX']);
                                            //var_dump($proforma['descripcion']);
                                        ?>
                                            <tr <?php echo ($eli=='1')? 'class="danger"':''; ?> codigo="<?php echo $fila['FACCONCOD']; ?>" precio="<?php echo number_format($fila['PUNIT'], 2); ?>" cantidad="<?php echo $fila['CANT']; ?>">
                                                <td style="text-align: center;"><?php echo $fila['FACCONCOD']; ?></td>
                                                <td style="text-align: justify;"><?php echo $fila['FACCONDES']; ?></td>
                                                <td style="text-align: right;">
                                                    <input class="precio" type="text" value="<?php echo number_format($fila['PUNIT'], 2); ?>" <?php echo ($eli=='1')? 'disabled':''; ?>/>
                                                </td>
                                                <td style="text-align: right;">
                                                    <input class="cantidad" type="text" value="<?php echo $fila['CANT']; ?>" <?php echo ($eli=='1')? 'disabled':''; ?>/>
                                                    
                                                </td>
                                                <?php if($proforma['cliente']['FSCTIPO']==1){
                                                    $afecta=($fila['AFECIGV']=='10')?"GRAVADO":"INAFECTO";
                                                 ?>
                                                <td style="text-align: right;">
                                                    <?php if ($afecta=="GRAVADO"){?>
                                                    <span class="importe"> <?php echo number_format(($p_importe), 2); ?></span>
                                                    <?php } else{?>
                                                    <span class="importe"> <?php echo number_format(($fila['CANT']*$fila['PUNIT']), 2); ?></span>
                                                    <?php }?>
                                                </td>
                                                <?php }else{ ?>
                                                <td style="text-align: right;">
                                                    <span class="importe"> <?php echo number_format(($fila['PUNIT']*$fila['CANT']), 2); ?></span>
                                                </td>
                                                <?php } ?>
                                                <?php if($proforma['cliente']['FSCTIPO']==1){
                                                    
                                                ?>
                                                <td style="text-align: right;">
                                                    <?php if ($afecta=="GRAVADO"){?>
                                                    <span class="igv"> <?php echo number_format((($fila['PUNIT']*$fila['CANT'])-$p_importe), 2); ?></span>
                                                    <?php } else{?>
                                                    <span class="igv"> <?php echo number_format(0, 2); ?></span>
                                                    <?php }?>
                                                </td>
                                                <td style="text-align: right;">
                                                    <span class="afectacion"> <?php echo $afecta;?></span>
                                                </td>  
                                                <?php }?>
                                                <td style="text-align: center;">
                                                    <label><input class="anular" type="checkbox" aria-label="Anular concepto" <?php echo ($eli=='1')? 'checked':''; ?> > Quitar</label>
                                                    <br>
                                                    <a class="btn btn-default btn-xs restaurar" data-placement="bottom" title="Restaurar" type="button" <?php echo ($eli=='1')? 'style="display:none;"':''; ?> ><i class='fa fa-repeat'></i> </a>
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
                                        <table class="table table-bordered table-striped" >
                                            <tbody>
                                                <?php if ($proforma['cliente']['FSCTIPO']==1) { ?> 
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">SUB TOTAL</th>
                                                    <td style="text-align:right" ><span id="base_sub_total"><?php echo number_format(floatval($proforma['cliente']['FSCSUBTOTA']),2); ?></span></td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">I.G.V.</th>
                                                    <td style="text-align:right" ><span id="base_igv"><?php echo number_format(floatval($proforma['cliente']['FSCSUBIGV']), 2, '.', ''); ?> </span></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">TOTAL</th>
                                                    <td style="text-align:right;color:#f00;font-size:20px" ><span id="base_total"><?php echo number_format(floatval($proforma['cliente']['FSCTOTAL']), 2, '.', ''); ?></span></td>
                                                </tr>
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-sm-12" >
                            <button class="btn btn-success" id="btn-actualizar">ACTUALIZAR</button>
                        </div>
                </div>
            </div>
        </div>
    </div> 
</section>

<script>
    var tipo, serie, numero;
    igv=<?php echo round(($proforma['cliente']['FSCIGVREF']/100),2); ?>;
    tipo = <?php echo $proforma['cliente']['FSCTIPO']; ?>;
    serie = <?php echo $proforma['cliente']['FSCSERNRO']; ?>;
    numero = <?php echo $proforma['cliente']['FSCNRO']; ?>; 
    base_sub_total= <?php echo $proforma['cliente']['FSCSUBTOTA'];?>; 
    base_igv= <?php echo $proforma['cliente']['FSCSUBIGV'];?>; 
    base_total= <?php echo $proforma['cliente']['FSCTOTAL'];?>;
    //alert($("#base_sub_total").text());
    $('.cantidad').inputmask('integer');
    $('.precio').inputmask('currency', {
        prefix: "",
        groupSeparator: "",
        allowPlus: false,
        allowMinus: false,
    });

    $(document).ready(function(){

        $(".anular").change(function(){
            var padre = $(this).parents('tr');
            console.log( $(this).prop('checked') );
            if ( $(this).prop('checked') ) {
                if(tipo==1){
                    temporal_importe=$(padre).find('.importe').text();
                    temporal_igv=$(padre).find('.igv').text();
                    base_sub_total=base_sub_total - temporal_importe ;
                    base_igv=base_igv-temporal_igv;
                    base_total= base_sub_total + base_igv;
                    $("#base_sub_total").text((base_sub_total).toFixed(2));
                    $("#base_igv").text((base_igv).toFixed(2));
                    $("#base_total").text((base_total).toFixed(2));
                }
                else{
                    temporal_importe=$(padre).find('.importe').text();
                    base_total= base_total - temporal_importe;
                    $("#base_total").text((base_total).toFixed(2));
                }
                padre.find(".cantidad").attr('disabled', true);
                padre.find(".precio").attr('disabled', true);
                padre.find(".restaurar").css("display", "none");
                padre.addClass("danger");
            }else{
                padre.find(".cantidad").attr('disabled', false);
                padre.find(".precio").attr('disabled', false);
                padre.find(".restaurar").css("display", "block");
                var precio, cantidad;
                precio = padre.find(".precio").val();
                cantidad = padre.find(".cantidad").val();
                if(tipo==1){
                    var afec=$(padre).find('.afectacion').text().trim();
                    if(afec=='GRAVADO'){
                        var importe=parseFloat((cantidad*(precio/(1+igv))).toFixed(2));
                        base_sub_total= base_sub_total +importe;
                        base_igv=base_igv + ((precio*cantidad)-importe);
                        base_total= base_sub_total + base_igv;
                        padre.find(".importe").empty();
                        padre.find(".igv").empty();
                        padre.find(".importe").append((importe).toFixed(2));
                        padre.find(".igv").append(((precio*cantidad)-importe).toFixed(2));
                        $("#base_sub_total").text((base_sub_total).toFixed(2));
                        $("#base_igv").text((base_igv).toFixed(2));
                        $("#base_total").text((base_total).toFixed(2));
                    }else{
                        base_sub_total= base_sub_total + (cantidad*precio);
                        base_total= base_sub_total + base_igv;
                        padre.find(".importe").empty();
                        padre.find(".igv").empty();
                        padre.find(".importe").append((cantidad*precio).toFixed(2));
                        padre.find(".igv").append((0).toFixed(2));
                        $("#base_sub_total").text((base_sub_total).toFixed(2));
                        $("#base_igv").text((base_igv).toFixed(2));
                        $("#base_total").text((base_total).toFixed(2));
                    }

                }
                else{
                    var importe=cantidad*precio;
                    base_total= base_total + importe;
                    $("#base_total").text((base_total).toFixed(2));
                }
                padre.removeClass("danger");
                
                
            }
        });

        $(".restaurar").on('click', function(){
            if ( !$(this).prop('checked') ){
                var padre = $(this).parents('tr');
                var cantidad, precio;
                cantidad = padre.attr('cantidad');
                precio = padre.attr('precio');
                padre.find(".cantidad").val(cantidad);
                padre.find(".precio").val(precio);
                temporal_importe=$(padre).find('.importe').text();
                temporal_igv=$(padre).find('.igv').text();
                base_sub_total=base_sub_total - temporal_importe ;
                base_igv=base_igv-temporal_igv;
                //estoy agregando
                var importe=cantidad*(precio/(1+igv));
                var dif_igv=precio/(1+igv);
                padre.find(".importe").empty();
                padre.find(".igv").empty();
                if(tipo==1){
                    var afec=$(padre).find('.afectacion').text().trim();
                    if(afec=='GRAVADO'){
                        base_sub_total= base_sub_total +importe;
                        base_igv=base_igv + (cantidad*(precio - dif_igv));
                        base_total= base_sub_total + base_igv;
                        $("#base_sub_total").text((base_sub_total).toFixed(2));
                        $("#base_igv").text((base_igv).toFixed(2));
                        $("#base_total").text((base_total).toFixed(2));
                        padre.find(".importe").append((importe).toFixed(2));
                        padre.find(".igv").append((cantidad*(precio - dif_igv)).toFixed(2));
                    }else{
                        base_sub_total= base_sub_total +(precio*cantidad);
                        base_total= base_sub_total + base_igv;
                        $("#base_sub_total").text((base_sub_total).toFixed(2));
                        $("#base_igv").text((base_igv).toFixed(2));
                        $("#base_total").text((base_total).toFixed(2));
                        padre.find(".importe").append((cantidad*precio).toFixed(2));
                        padre.find(".igv").append((0).toFixed(2));
                    }
                    
                }else{
                    base_total=base_total - temporal_importe + (cantidad*precio) ;
                    $("#base_total").text((base_total).toFixed(2));
                    padre.find(".importe").append((cantidad*precio).toFixed(2));
                }
                
            }
        });



        $(".precio").focusout(function(){
            //alert($("#base_sub_total").text());
            var padre = $(this).parents('tr');
            var precio, cantidad;
            precio = $(padre).find('.precio').val();
            cantidad = $(padre).find('.cantidad').val();
            temporal_importe=$(padre).find('.importe').text();
            temporal_igv=$(padre).find('.igv').text();
            base_sub_total=base_sub_total - temporal_importe ;
            base_igv=base_igv-temporal_igv;
            var importe=parseFloat((cantidad*(precio/(1+igv))).toFixed(2));
            padre.find(".importe").empty();
            padre.find(".igv").empty();
            //alert(temporal);
            if(tipo==1){

                var afec=$(padre).find('.afectacion').text().trim();
                if(afec=='GRAVADO'){
                    base_sub_total= base_sub_total +importe;
                    base_igv=base_igv + ((precio*cantidad)-importe);
                    base_total= base_sub_total + base_igv;
                    $("#base_sub_total").text((base_sub_total).toFixed(2));
                    $("#base_igv").text((base_igv).toFixed(2));
                    $("#base_total").text((base_total).toFixed(2));
                    padre.find(".importe").append((importe).toFixed(2));
                    padre.find(".igv").append(((precio*cantidad)-importe).toFixed(2));
                }else{
                    base_sub_total= base_sub_total  + (cantidad*precio) ;
                    base_total= base_sub_total + base_igv;
                    $("#base_sub_total").text((base_sub_total).toFixed(2));
                    $("#base_igv").text((base_igv).toFixed(2));
                    $("#base_total").text((base_total).toFixed(2));
                    padre.find(".importe").append((precio*cantidad).toFixed(2));
                    padre.find(".igv").append((0).toFixed(2));
                }
            }else{
                base_total=base_total - temporal_importe + (cantidad*precio) ;
                $("#base_total").text((base_total).toFixed(2));
                padre.find(".importe").append((cantidad*precio).toFixed(2));
            }

        });

        $(".cantidad").focusout(function(){
            var padre = $(this).parents('tr');
            var precio, cantidad;
            precio = $(padre).find('.precio').val();
            cantidad = $(padre).find('.cantidad').val();
            temporal_importe=$(padre).find('.importe').text();
            temporal_igv=$(padre).find('.igv').text();
            base_sub_total=base_sub_total - temporal_importe;
            base_igv=base_igv-temporal_igv;
            padre.find(".importe").empty();
            padre.find(".igv").empty();
            var importe=parseFloat((cantidad*(precio/(1+igv))).toFixed(2));
            if(tipo==1){
                //console.log($(padre).find('.afectacion').text().trim()=='GRAVADO');
                var afec=$(padre).find('.afectacion').text().trim();
                if(afec=='GRAVADO'){
                    base_sub_total= base_sub_total +importe;
                    base_igv=base_igv + ((precio*cantidad)-importe);
                    base_total= base_sub_total + base_igv;
                    $("#base_sub_total").text((base_sub_total).toFixed(2));
                    $("#base_igv").text((base_igv).toFixed(2));
                    $("#base_total").text((base_total).toFixed(2));
                    padre.find(".importe").append((importe).toFixed(2));
                    padre.find(".igv").append(((precio*cantidad)-importe).toFixed(2));
                }else{
                    base_sub_total= base_sub_total  + (cantidad*precio) ;
                    base_total= base_sub_total + base_igv;
                    $("#base_sub_total").text((base_sub_total).toFixed(2));
                    $("#base_igv").text((base_igv).toFixed(2));
                    $("#base_total").text((base_total).toFixed(2));
                    padre.find(".importe").append((precio*cantidad).toFixed(2));
                    padre.find(".igv").append((0).toFixed(2));
                }
                
            }else{
                base_total=base_total - temporal_importe + (cantidad*precio) ;
                $("#base_total").text((base_total).toFixed(2));
                padre.find(".importe").append((cantidad*precio).toFixed(2));
            }
            
        });

        $("#btn-actualizar").click(function(){
            var proforma = {};
            proforma['tipdoc']=tipo;
            proforma['seriedoc']=serie;
            proforma['numerodoc']=numero;
            var tabla = [];
            var ban=0;
            if (tipo==1) {
                var estados=0;
                var contador=0;
                for(i=1; i<$("#detalle  tr").length; i++){
                
                    $('#detalle  tr').eq(i).each(function () {
                        var fila = {};

                        $(this).find('td').each(function (index) {
                            
                            switch (index){
                                case 0: fila['codigo']=$(this).text(); break;
                                case 1: break;
                                case 2: fila['precio']=$(this).find(".precio").val(); break;
                                case 3: fila['cantidad']=$(this).find(".cantidad").val(); break;
                                case 4: fila['importe']=$(this).find(".importe").text(); break;
                                case 5: fila['igv']=$(this).find(".igv").text(); break;
                                case 6: fila['afectacion']=$(this).find(".afectacion").text(); break;
                                case 7: fila['estado']=$(this).find(".anular").prop('checked'); break;
                            }
                        });
                        if (fila['estado']) {
                            estados = estados + 1;
                        }
                        contador =contador +1;
                        tabla.push(fila);
                    });
                }
            }else{
                var estados=0;
                var contador=0;
                
                for(i=1; i<$("#detalle  tr").length; i++){
                
                    $('#detalle  tr').eq(i).each(function () {
                        var fila = {};
                        $(this).find('td').each(function (index) {
                            if($(this).find(".cantidad").val()<=0 || $(this).find(".precio").val()<=0){
                                ban=1;
                            }
                            switch (index){
                                case 0: fila['codigo']=$(this).text(); break;
                                case 1: break;
                                case 2: fila['precio']=$(this).find(".precio").val(); break;
                                case 3: fila['cantidad']=$(this).find(".cantidad").val(); break;
                                case 4: fila['importe']=$(this).find(".importe").text(); break;
                                case 5: fila['estado']=$(this).find(".anular").prop('checked'); break;
                            }
                        });
                        if (fila['estado']) {
                            estados = estados + 1;
                        }
                        contador =contador +1;
                        tabla.push(fila);
                    });
                }

            }
            
            if(estados==contador)
            {
              swal("No se puede editar", "No debe de eliminar todas las Filas ", "error");
            }
            else{
                if(ban==0){
                    var envio = {};
                    envio['proforma'] = proforma;
                    if (tipo==1) {
                        envio['sub_total'] = $("#base_sub_total").text();
                        envio['igv'] = $("#base_igv").text();
                        envio['base_igv']=igv;
                        envio['total'] = $("#base_total").text();
                    }else{
                        envio['base_igv']=igv;
                        envio['total'] = $("#base_total").text();
                    }
                    
                    envio['detalle'] = tabla;
                    jsoncliente = JSON.stringify(envio);
                    swal({
                        title: 'Desea actualizar la proforma',
                        text: 'Se guardaran los cambios echos hasta el momento',
                        type: 'warning',
                        confirmButtonColor: "#296fb7",
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        showCancelButton: true,
                        closeOnConfirm: false
                    }, function(valor){
                        if(valor==true){
                           swal.disableButtons();
                           editar(jsoncliente);
                           //console.log(jsoncliente);
                        }
                    });
                }else{
                    swal("No se puede editar", " No debe de ingresar datos menor o igual a 0 ", "error");
                }
                
            }
            
        });
    });
    function editar(jsoncliente){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>documentos/proformas/guardar_edicion?ajax=true",
            data: "envio="+jsoncliente,
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    swal({
                        title: "Proforma Nro "+data.serie + " - " + data.numero,
                        text: "La proforma fue editada con exito",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        confirmButtonColor: "#296fb7",
                        confirmButtonText: "Aceptar",
                        showConfirmButton : true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }, function(valor){
                        window.location.replace("<?php echo $this->config->item('ip'); ?>documentos/proformas");
                    });
                    //swal("Se registro la Proforma", "Se registro la proforma con exito", "success");
                    //window.location.replace('<?php echo base_url()."documentos/proformas"?>');
                    return true;
                }else{
                    swal("No se edito la Proforma", data.mensaje, "error");
                    return false;
                }
            }
        });
    }
    function calcular_precio(){
        $('#detalle > tbody > tr').each(function(){
            var check = $(this).find('.anular');
            if( !$(check).prop('checked') ){
                var precio = $(this).find('.precio');
                var cantidad = $(this).find('.cantidad');

            }
        });
    }

</script>