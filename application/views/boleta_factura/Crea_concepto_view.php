<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/autocomplete/jquery.auto-complete.css">

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/autocomplete/jquery.auto-complete.js" type="text/javascript"></script>
<script src='<?php echo $this->config->item('ip'); ?>frontend/dist/js/jquery.number.min.js'></script>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<style>
    .modal-header-info {
        color:#fff;
        padding:9px 15px;
        border-bottom:1px solid #eee;
        background-color: #5bc0de;
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-radius-topleft: 5px;
        -moz-border-radius-topright: 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $titulo; ?></h3>
                </div>
                <div class="box-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class = "col-md-4">
                                <label for="sel1">Escoja</label>
                                <select class="form-control" id="Escoja_concepto">
                                    <option value="1">TODOS</option>
                                    <option value="2">ACTIVOS</option>
                                </select>
                            </div>
                            <div class = "col-md-4 col-md-offset-8">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Crea_concepto" style="width:100%;">
                                    <span class="glyphicon glyphicon-ok-sign"></span> AGREGAR CONCEPTO
                                </button>
                            </div>
                        </div>
                        <div class = "row" style="margin-top:20px;">
                            <div class = "col-md-12">
                                <table class="table" id="tabla_conceptos" >
                                    <thead>
                                        <tr>
                                            <th> Item</th>
                                            <th>Codigo Concepto</th>
                                            <th>Descripción</th>
                                            <th>Afectación IGV</th>
                                            <th>Codigo Contable</th>
                                            <th>Estado</th>
                                            <th>Opción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach($conceptos as $concepto){ ?>
                                        <tr>
                                            <td>
                                                <?php echo ($i+1); ?>
                                            </td>
                                            <td>
                                                <?php echo $concepto['FACCONCOD']; ?>
                                            </td>
                                            <td>
                                                <?php echo $concepto['FACCONDES']; ?>
                                            </td>
                                            <td>
                                                <?php echo $concepto['FACIGVCOB']; ?>
                                            </td>
                                            <td>
                                                <?php echo $concepto['FACCONTAB']; ?>
                                            </td>
                                            <td>
                                                <?php  if($concepto['ESTADO'] == 1){ ?>
                                                    <span class="label label-success">Activado</span>
                                                <?php }else{?>
                                                    <span class="label label-danger">Desactivado</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm" onclick="Editar_Concepto(<?php echo $concepto['FACCONCOD']; ?>)">
                                                    <span class="glyphicon glyphicon-pencil"></span> Editar
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                   
        </div>
    </div>
    <div id="Crea_concepto" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="Titulo_modal"><i class="glyphicon glyphicon-thumbs-up"></i> Crear Concepto</h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class="col-md-6">
                        <div class="form-group"> <!-- Full Name -->
                            <label for="full_name_id" class="control-label">Codigo de Concepto</label>
                            <input type="text" class="form-control" id="cod_concepto" name="full_name" placeholder="CODIGO CONCEPTO">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <label for="full_name_id" class="control-label">Precio de Concepto</label>
                            <input type="text" class="form-control" id="precio_concepto" name="full_name" placeholder="PRECIO DE CONCEPTO">
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-md-12">
                        <div class="form-group"> <!-- Full Name -->
                            <label for="full_name_id" class="control-label">Descripción de Concepto</label>
                            <input type="text" class="form-control" id="Descri_concepto" name="full_name" placeholder="DESCRIPCIÓN DE CONCEPTO">
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-6">
                      <div class="form-group">
                        <label for="sel1">Tipo Afectación:</label>
                        <select class="form-control" id="afectacion_igv">
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
                    <div class="form-group control-group col-md-6 col-sm-6">
                            <label>GRATUITO: </label>
                            <div class="input-group">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" id="Form-gratuito" >
                                     Presione 
                                </label>
                            </div>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-6">
                        <div class="form-group"> <!-- Full Name -->
                            <label for="full_name_id" class="control-label">Codigo Contable</label>
                            <input type="text" class="form-control" id="codigo_contable" name="full_name" placeholder="CODIGO CONTABLE" maxlength="5">
                        </div>
                    </div>
                    <div class = "col-md-6">
                        <div class="form-group">
                            <label for="sel1">Estado:</label>
                            <select class="form-control" id="Estado_concepto">
                                <option value = "1">Activado</option>
                                <option value = "0">Desactivado</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-info" id="Guardar_concepto" >GUARDAR</button>
                <button type="button" class="btn btn-warning"  id ="Cerrar_modal">CERRAR</button>
            </div>
            </div>

        </div>
    </div>
</section>
<script type="text/javascript">
  var table = null;
  var Estado_modal = 0;
  $('#cod_concepto').inputmask('integer');
  $('#codigo_contable').inputmask('integer');
  $('#precio_concepto').inputmask('currency', {
            prefix: "",
            groupSeparator: "",
            allowPlus: false,
            allowMinus: false,
        });
  $(document).ready(function() {
    table = $('#tabla_conceptos').DataTable({scrollX: true, 
    bFilter: true, 
    bInfo: false, 
    bSort:false,
    "lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],
    "columns": [
        { "width": "5%" },
        { "width": "5%" },
        { "width": "35%" },
        { "width": "10%" },
        { "width": "15%" },
        null,
        null
    ]
    });
    
    $('#Escoja_concepto').on('change',function(){
        var valor = $(this).val();
        filtrar(valor);
        //alert(valor);
    });

    $( "#Guardar_concepto" ).click(function() {
        if(Estado_modal == 0){
            guardar_concepto();
        }else{
            guarda_edicion_concepto();
        }
        
    });
    $( "#Cerrar_modal" ).click(function() {
        Estado_modal = 0;
        $("#Guardar_concepto").text("GUARDAR");
        $('#cod_concepto').val('');
        $("#cod_concepto").prop("readonly", false);
        $('#precio_concepto').val('');
        $("#Descri_concepto").val('');
        $("#Form-gratuito").attr('checked',false);
        $('#Estado_concepto').val('1');
        $("#codigo_contable").val('');
        $('#Crea_concepto').modal('toggle');
        
    });

  });

  function guarda_edicion_concepto(){
    var codigo_concepto = $("#cod_concepto").val();
    var precio_concepto = $("#precio_concepto").val();
    var codigo_contable  = $("#codigo_contable").val();
    var descripcion_concepto = $("#Descri_concepto").val();
    var tipo_afectacion  = $("#afectacion_igv").val();
    var Gratuito=$("#Form-gratuito").is(":checked");
    var Estado_concepto = $("#Estado_concepto").val();
    if(codigo_concepto =='' || precio_concepto =='' || codigo_contable=='' || descripcion_concepto ==''){
        var campos_vacios = '';
        campos_vacios = campos_vacios + ((codigo_concepto =='') ? ', CODIGO DE CONCEPTO' :'' );
        campos_vacios = campos_vacios + ((precio_concepto =='') ? ', PRECIO DE CONCEPTO' :'' );
        campos_vacios = campos_vacios + ((codigo_contable =='') ? ', CODIGO CONTABLE' :'' ); 
        campos_vacios = campos_vacios + ((descripcion_concepto =='') ? ', DESCRIPCIÓN DE CONCEPTO' :'' );

        swal("Alerta!", "FALTA INGRESAR " + campos_vacios , "error");

    }else{
        if(codigo_concepto>=1000){
            swal("Alerta!", "EL CODIGO DEL CONCEPTO DEBE TENER MAXIMO 3 DIGITOS" , "error");
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo $this->config->item('ip'); ?>CREA_CONCEPTO/GUARDA_EDITAR?ajax=true",
                data: {
                    concep_codigo: codigo_concepto,
                    concep_precio: precio_concepto,
                    concep_codigo_contable: codigo_contable,
                    concep_descrip: descripcion_concepto,
                    afecta_tipo: tipo_afectacion,
                    Grat: Gratuito,
                    Est_concep: Estado_concepto
                },
                dataType: 'json',
                success: function(data) {
                    
                    if(data.result) {

                        Estado_modal = 0;
                        $("#Guardar_concepto").text("GUARDAR");
                        swal({
                            title: "CONCEPTO",
                            text: "El concepto fue editado con exito",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: true,
                            confirmButtonColor: "#296fb7",
                            confirmButtonText: "Aceptar",
                            showConfirmButton : true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }, function(valor){
                            window.location.replace('<?php echo $this->config->item('ip')."CREA_CONCEPTO/INICIO"?>');
                        });
                        //console.log(data.rpta);
                        return true;
                    }else{

                    }
                }
            });
        }
    }
      
  }

  function guardar_concepto(){
    $("#Titulo_modal").text("Crear Concepto");
    var codigo_concepto = $("#cod_concepto").val();
    var precio_concepto = $("#precio_concepto").val();
    var codigo_contable  = $("#codigo_contable").val();
    var descripcion_concepto = $("#Descri_concepto").val();
    var tipo_afectacion  = $("#afectacion_igv").val();
    var Gratuito=$("#Form-gratuito").is(":checked");
    var Estado_concepto = $("#Estado_concepto").val();
    if(codigo_concepto =='' || precio_concepto =='' || codigo_contable=='' || descripcion_concepto ==''){
        var campos_vacios = '';
        campos_vacios = campos_vacios + ((codigo_concepto =='') ? ', CODIGO DE CONCEPTO' :'' );
        campos_vacios = campos_vacios + ((precio_concepto =='') ? ', PRECIO DE CONCEPTO' :'' );
        campos_vacios = campos_vacios + ((codigo_contable =='') ? ', CODIGO CONTABLE' :'' ); 
        campos_vacios = campos_vacios + ((descripcion_concepto =='') ? ', DESCRIPCIÓN DE CONCEPTO' :'' );

        swal("Alerta!", "FALTA INGRESAR " + campos_vacios , "error");

    }else{

        if(codigo_concepto>=1000){
            swal("Alerta!", "EL CODIGO DEL CONCEPTO DEBE TENER MAXIMO 3 DIGITOS" , "error");
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo $this->config->item('ip'); ?>GUARDA_CONCEPTO/GUARDAR?ajax=true",
                data: {
                    concep_codigo: codigo_concepto,
                    concep_precio: precio_concepto,
                    concep_codigo_contable: codigo_contable,
                    concep_descrip: descripcion_concepto,
                    afecta_tipo: tipo_afectacion,
                    Grat: Gratuito,
                    Est_concep: Estado_concepto
                    },
                dataType: 'json',
                success: function(data) {
                    if(data.result) {
                        swal({
                            title: "CONCEPTO",
                            text: "El concepto fue registrado con exito",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: true,
                            confirmButtonColor: "#296fb7",
                            confirmButtonText: "Aceptar",
                            showConfirmButton : true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }, function(valor){
                            window.location.replace('<?php echo $this->config->item('ip')."CREA_CONCEPTO/INICIO"?>');
                        });
                    }else{
                        swal({
                            title: "CONCEPTO",
                            text: data.mensaje,
                            type: "error",
                            showCancelButton: false,
                            closeOnConfirm: true,
                            confirmButtonColor: "#296fb7",
                            confirmButtonText: "Aceptar",
                            showConfirmButton : true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }, function(valor){
                            //window.location.replace('<?php echo $this->config->item('ip')."CREA_CONCEPTO/INICIO"?>');
                        });
                    }
                }
            });
        }
         
    }
    
  }

  function Editar_Concepto(codi_cocepto){
    Estado_modal = 1;
    $("#Guardar_concepto").text("EDITAR");
    $("#Titulo_modal").text("Editar Concepto");
    $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>CREA_CONCEPTO/EDITAR?ajax=true",
            data: {
                valor_concepto: codi_cocepto
            },
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {
                    console.log(data.rpta);
                    $('#cod_concepto').val(data.rpta[0]['FACCONCOD']);
                    $("#cod_concepto").prop("readonly", true);
                    $('#precio_concepto').val(data.rpta[0]['PRECIO']);
                    $("#Descri_concepto").val(data.rpta[0]['FACCONDES']);
                    if(data.rpta[0]['GRATUITO'] != 'undefined'){
                        if(data.rpta[0]['GRATUITO'] == 1){
                            $("#Form-gratuito").attr('checked',true);
                        }
                           
                    }else{
                        $("#Form-gratuito").attr('checked',flase);
                    }
                    $('#Estado_concepto').val(data.rpta[0]['ESTADO']);
                    $("#codigo_contable").val(data.rpta[0]['FACCONTAB']);
                    $('#Crea_concepto').modal('show');
                    return true;
                }else{

                    /*sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false; */
                }
            }
        });

  }

  function filtrar(valor){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>CREA_CONCEPTO/FILTRAR?ajax=true",
            data: {valor_filtro: valor},
            dataType: 'json',
            success: function(data) {
                
                if(data.result) {
                    
                    table.clear().draw();

                    for(var i=0; i<data.conceptos_filtrados.length;i++){

                        table.row.add( [ 
                            (i+1),
                            data.conceptos_filtrados[i]['FACCONCOD'],
                            data.conceptos_filtrados[i]['FACCONDES'],
                            data.conceptos_filtrados[i]['FACIGVCOB'],
                            data.conceptos_filtrados[i]['FACCONTAB'],
                            (data.conceptos_filtrados[i]['ESTADO']==1)? '<span class="label label-success">Activado</span>' :'<span class="label label-danger">Desactivado</span>',
                            '<button type="button" class="btn btn-default btn-sm" onclick="Editar_Concepto(' + data.conceptos_filtrados[i]['FACCONCOD'] + ')"> <span class="glyphicon glyphicon-pencil"></span> Editar </button>'
                        ] ).draw( false );

                    }
                    //swal.close();
                    return true;
                }else{
                    /*sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false; */
                }
            }
        });
  }
</script>