<!-- sweetAlert. -->
<link rel="stylesheet" href="./frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="./frontend/plugins/autocomplete/jquery.auto-complete.css">

<script src="./frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="./frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="./frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="./frontend/plugins/autocomplete/jquery.auto-complete.js" type="text/javascript"></script>

<section class="content">   
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $_SESSION['mensaje'][1]; ?>
                </div><br>
            <?php } ?>
            
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
                                <!--span class="glyphicon glyphicon-warning-sign form-control-feedback" id="Aviso-Nom" aria-hidden="true" style="color:#f0ad4e;"></span>
                                <span class="sr-only">(1)</span-->
                            </div>
                        </div>
                        <!--div class="form-group col-md-12 col-sm-12" style="text-align:right;" >
                            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal1" onclick="abrirModalAnadir()">
                                AÑADIR CONCEPTO
                            </button>
                        </div-->
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
                                            <!--th style="text-align:center;">OPCIONES</th-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($proforma['descripcion'] as $fila) { 
                                            $p_unit = ($proforma['cliente']['FSCTIPO']==1)? $fila['PUNIT']: $fila['PUNIT']*(1+$proforma['cliente']['FSCIGVREF']/100);
                                            $p_importe = ($proforma['cliente']['FSCTIPO']==1)? $fila['FSCPRECIO']: ($fila['FSCPRECIO']+$fila['PRECIGV']);
                                            $observacion = ($fila['OBSFACAUX'] == '' || $fila['OBSFACAUX'] == null)? '':(' - '.$fila['OBSFACAUX']);
                                            var_dump($proforma['descripcion']);
                                        ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $fila['FACCONCOD']; ?></td>
                                                <td><?php echo $fila['FACCONDES'].' - '.$fila['FACCONDES'].$observacion; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($p_unit, 2); ?></td>
                                                <td style="text-align: right;"><?php echo $fila['CANT']; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($p_importe, 2); ?></td>
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
                                                <?php if ($proforma['cliente']['FSCTIPO']==1) { ?> 
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">SUB TOTAL</th>
                                                    <td style="text-align:right"><?php echo number_format(floatval($proforma['cliente']['FSCSUBTOTA']),2); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">I.G.V.</th>
                                                    <td style="text-align:right"><?php echo number_format(floatval($proforma['cliente']['FSCSUBIGV']), 2, '.', ''); ?></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">TOTAL</th>
                                                    <td style="text-align:right;color:#f00;font-size:20px"><?php echo number_format(floatval($proforma['cliente']['FSCTOTAL']), 2, '.', ''); ?></td>
                                                </tr>
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-sm-12" >
                            <!--form role="form" action="<?php echo base_url().'documentos/boletas_facturas/accion_pagar'; ?>" enctype="multipart/form-data" accept-charset="utf-8">
                                <input input="hidden" value='<?php echo $proforma['cliente']['FSCTIPO']; ?>' name="tipo" hidden/>
                                <input input="hidden" value='<?php echo $proforma['cliente']['FSCSERNRO']; ?>' name="serie" hidden/>
                                <input input="hidden" value='<?php echo $proforma['cliente']['FSCNRO']; ?>' name="numero" hidden/>
                                <button class="btn btn-success" id="btn-pagar" type="submit" >PAGAR</button>
                            </form-->
                            <!--button class="btn btn-success" id="btn-pagar" onclick="pagar">PAGAR</button-->

                            <button class="btn btn-success" id="btn-pagar">REGISTRAR</button>
                        </div>
                </div>
                <p id="json"></p>
                <!-- Modal -->
                <!--div class="modal fade" id="modal1" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="closeModal1()"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="modal1-label"></h4>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <div class="form-group control-group col-md-12">
                                        <label for="tipo_identificacion">BUSQUE DESCRIPCION:</label>
                                        <div class="controls">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </div>
                                                <div onsubmit="$('#bscdesc').blur(); return false;" class="pure-form">
                                                    <input class="form-control" id="bscdesc" autofocus type="text" name="Mod-bqda" disabled/>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="box box-primary col-md-12 col-sm-12" style="width:95%; margin-left:20px; padding-top:10px;">
                                        <div class="form-group control-group col-md-12">
                                            <label for="modal1-codigo">CODIGO:</label>
                                            <div class="controls">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-dot-circle-o"></i>
                                                    </div>
                                                    <input class="form-control" id="modal1-codigo" name="modal1-codigo" type="text" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group control-group col-md-12">
                                            <label for="modal1-descripcion">DESCRIPCION:</label>
                                            <div class="controls">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-file-text"></i>
                                                    </div>
                                                    <input class="form-control" id="modal1-descripcion" name="modal1-descripcion" type="text" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group control-group col-sm-6">
                                            <label for="modal1-precio">PRECIO:</label>
                                            <div class="controls">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-usd"></i>
                                                    </div>
                                                    <input class="form-control" id="modal1-precio" name="modal1-precio" type="text" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group control-group col-sm-6">
                                            <label for="modal1-cantidad">CANTIDAD:</label>
                                            <div class="controls">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-cubes"></i>
                                                    </div>
                                                    <input class="form-control" id="modal1-cantidad" name="modal1-cantidad" type="text" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="modal1-ok" onclick="okModal1();">Aceptar</button>
                                <button type="button" class="btn btn-warning" id="modal1-reset" onclick="resetModal1();">Limpiar</button>
                                <button type="button" class="btn btn-danger" id="modal1-close" data-dismiss="modal" onclick="closeModal1()">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div-->
            </div>
        </div>
    </div> 
</section>

<script>
    
    $("#btn-pagar").click(function(){
        
        
        alert('boton de pago');
        
        return false;
        
        
        var proforma = {};
        proforma['tipo'] = "<?php echo $proforma['cliente']['FSCTIPO']; ?>";
        proforma['serie'] = "<?php echo $proforma['cliente']['FSCSERNRO']; ?>";
        proforma['numero'] = "<?php echo $proforma['cliente']['FSCNRO']; ?>";

        jsoncliente = JSON.stringify(proforma);

        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>documentos/boletas_facturas/accion_pagar?ajax=true",
            data: "documento="+jsoncliente,
            dataType: 'json',
            success: function(data) {
                /*var msj = "";
                for(var i=0; i<7; i++){
                    msj = msj+data["respuesta"][i]+"\n";
                }*/
                //alert(data["respuesta"].length);
                console.log(data.result);
                if(data.result) {
                    var i = data["respuesta"].length;
                    swal({
                      title: "Respuesta del service",
                      text: data["respuesta"][i-2]+" "+data["respuesta"][i-1],
                      type: "info",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Si",
                      cancelButtonText: "No",
                      closeOnConfirm: true
                    },
                    function(isConfirm) {
                        window.location.replace("<?php echo $this->config->item('ip'); ?>documentos/boletas_facturas");
                    });
                    //alert("Ok");
                    
                    //window.location.href = "<?php echo base_url();?>cuenta_corriente/mostrar_cartera/"+data.suministro;
                }else{
                    sweetAlert("Datos Incorrectos", data.mensaje, "error");
                }
            }
        });
        
        
                
    });

</script>