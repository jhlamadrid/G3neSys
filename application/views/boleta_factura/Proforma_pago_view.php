<section class="content">   
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $_SESSION['mensaje'][1]."<br>"; ?>
                    <?php echo $_SESSION['mensaje'][2]; ?>
                </div><br>
            <?php } ?>
            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $proceso; ?></h3>
                </div>
                <div class="box-body" >
                    <?php if($proforma['oordpag']=='con_orden') { ?>
                            <?php if (isset($profns)){?>
                		<div class="container-fluid">
                			<div class="form-group control-group col-md-3 col-sm-12">
	                    		<label for="tipo-comprobante">ORDEN DE PAGO:</label>
	                            <div class="controls">
	                                <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-file-text"></i> 
                                        </div>
	                                    <input class="form-control" type="text" value="<?php echo str_pad($profns[0]['SERNRO'], 3, '0', STR_PAD_LEFT).' - '.str_pad($profns[0]['ORPNRO'], 6, '0', STR_PAD_LEFT); ?>" readonly>
                                        
	                                </div>
	                            </div>	
	                    	</div>
	                    	<div class="form-group control-group col-md-9 col-sm-12">
	                    		<label for="tipo-comprobante">NOMBRE DE REFERENCIA:</label>
	                            <div class="controls">
	                                <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-file-text"></i> 
                                        </div>
	                                    <input class="form-control" type="text" value="<?php echo $profns[0]['ORPNOMREF']; ?>" readonly>
	                                </div>
	                            </div>	
	                    	</div>
                		</div>
                        <?php }?>
                    <?php } ?>

                    	<div class="container-fluid">
                			<div class="form-group control-group col-md-3 col-sm-12">
	                    		<label for="tipo-comprobante">CODIGO DE SUMINISTRO:
                                <?php if($proforma['cliente']['FSCTIPO']==1){?>
                                
                                <a target="_blank" href="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" data-toggle="tooltip" data-placement="bottom" title data-original-title="Ir a web"><i class="fa fa-eye"></i></a>
                                <?php } else{ ?>
                                <a target="_blank" href="https://cel.reniec.gob.pe/valreg/valreg.do;jsessionid=97657851cf84a1b5e8e57db400289a1dfe6deb1635f.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaMa3D3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaPb3aPbhiTbN4xf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_" data-toggle="tooltip" data-placement="bottom" title data-original-title="Ir a web"><i class="fa fa-eye"></i></a>
                                <?php }?>
                                </label>
	                            <div class="controls">
	                                <div class="input-group">
	                                	<div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i> 
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo str_pad($propie['CLICODFAC'], 4, '0', STR_PAD_LEFT); ?>" readonly>
	                                </div>
	                            </div>	
	                    	</div>
	                    	<div class="form-group control-group col-md-9 col-sm-12">
	                    		<label for="tipo-comprobante">NOMBRE DE SUMINISTRO:</label>
	                            <div class="controls">
	                                <div class="input-group">
	                                	<div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i> 
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo $propie['CLINOMBRE']; ?>" readonly>
	                                </div>
	                            </div>	
	                    	</div>
                		</div>

                		<div class="container-fluid">
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
	                            <label for="documento"><?php echo ($proforma['cliente']['FSCTIPDOC']!=6)? $proforma['cliente']['TIPDOCDESCABR'].':':'RUC:'; ?></label>
	                            <div class="controls">
	                                <div class="input-group">
	                                    <div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i> 
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo ($proforma['cliente']['FSCTIPDOC']!=6)? $proforma['cliente']['FSCNRODOC']:$proforma['cliente']['FSCCLIRUC'] ?>" readonly>
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
                            <div class="form-group control-group col-md-12" id="div-Nom">
                                <label for="nombre">OBSERVACION:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="basic-url" value="<?php echo $proforma['cliente']['OBSDOC'] ?>" readonly>
                                    <!--span class="glyphicon glyphicon-warning-sign form-control-feedback" id="Aviso-Nom" aria-hidden="true" style="color:#f0ad4e;"></span>
                                    <span class="sr-only">(1)</span-->
                                </div>
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
                                            <!--th style="text-align:center;">OPCIONES</th-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($proforma['descripcion'] as $fila) { 
                                            $p_unit = ($proforma['cliente']['FSCTIPO']==1)? $fila['PUNIT']: $fila['PUNIT']*(1+$proforma['cliente']['FSCIGVREF']/100);
                                            $p_importe = $fila['FSCPRECIO']+$fila['PRECIGV'];
                                            $observacion = ($fila['OBSFACAUX'] == '' || $fila['OBSFACAUX'] == null)? '':(' - '.$fila['OBSFACAUX']);
                                        ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $fila['FACCONCOD']; ?></td>
                                                <td><?php echo $fila['FACCONDES'].$observacion; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($fila['PUNIT'], 2); ?></td>
                                                <td style="text-align: right;"><?php echo $fila['CANT']; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($fila['PUNIT']*$fila['CANT'], 2); ?></td>
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
                            <button class="btn btn-success" id="btn-pagar">EMITIR COMPROBANTE</button>
                        </div>
                  
                </div>
            </div>
        </div>
    </div> 
</section>

<script type="text/javascript">
	$("#btn-pagar").click(function(){
        //swal();
        swal({
            title: "Desea ******************* emitir "+"<?php echo ($proforma['cliente']['FSCTIPO']==1)? 'Factura':'Boleta de Venta'; ?>"+" de esta proforma",
            text: '',
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false
        },
        function(isConfirm) {
            if(isConfirm==true){
                swal.disableButtons();

                json = JSON.stringify(new Array("<?php echo $proforma['cliente']['FSCTIPO']; ?>",
                                                "<?php echo $proforma['cliente']['FSCSERNRO']; ?>",
                                                "<?php echo $proforma['cliente']['FSCNRO']; ?>"));
                event.preventDefault();
                var form = jQuery('<form>', {
                        'action': "<?php echo $this->config->item('ip'); ?>documentos/boletas_factura/pagar_proforma_ose",           
                        'target': '_top',
                        'method': 'post',
                        'type': 'hidden'
                }).append(jQuery('<input>', {
                        'name': 'comprobante',
                        'value': json,
                        'type': 'hidden'
                    }));
                $('body').append(form);
                //document.body.appendChild(form);
                form.submit();

                /*var proforma = {};
                proforma['tipo'] = "<?php echo $proforma['cliente']['FSCTIPO']; ?>";
                proforma['serie'] = "<?php echo $proforma['cliente']['FSCSERNRO']; ?>";
                proforma['numero'] = "<?php echo $proforma['cliente']['FSCNRO']; ?>";

                jsoncliente = JSON.stringify(proforma);
                pago(jsoncliente);*/  
            }
            
            //window.location.replace('<?php echo base_url()."documentos/boletas_facturas"?>');
        });    
                
    });

    function pago(jsoncliente){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip'); ?>documentos/boletas_factura/pagar_proforma?ajax=true",
            data: "documento="+jsoncliente,
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    //var r = mostrarpdf(data.comprobante['tipo'], data.comprobante['serie'], data.comprobante['numero']);
                    //var r2 = mostrarticket(data.comprobante['tipo'], data.comprobante['serie'], data.comprobante['numero']);
                    if(data.result){
                        window.location.replace("<?php echo $this->config->item('ip'); ?>documentos/boletas_factura/mostrar/"+data.comprobante['tipo']+'/'+data.comprobante['serie']+'/'+data.comprobante['numero']);
                        swal({
                            title: "Se genero el comprobante de pago con exito",
                            text: '',
                            type: "success",                      
                            closeOnConfirm: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }/*,
                        function(isConfirm) {
                            swal.disableButtons();
                            window.location.replace('<?php echo base_url()."documentos/boletas_factura/mostrar/"?>'+data.comprobante['tipo']+'/'+data.comprobante['serie']+'/'+data.comprobante['numero']);
                        }*/);
                    }
                    
                }else{
                    sweetAlert("Datos Incorrectos", data.mensaje, "error");
                }
            }
        });
    }

    function mostrarticket(tipo, serie, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip'); ?>documentos/boletas_facturas/mostrar_ticket/"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
        return true;
        /*console.log(new Array(tipo, serie, numero));
        var json = JSON.stringify(new Array(tipo, serie, numero));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo base_url().'documentos/boletas_facturas/mostrar_pdf'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'reporte',
                'value': json,
                'type': 'hidden'
            }));
        form.submit();
        return false;*/

        //window.location.replace('<?php echo base_url()."documentos/boletas_facturas"?>');
    }

    function mostrarpdf(tipo, serie, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip'); ?>documentos/boletas_facturas/mostrar_pdf/"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
        return true;
        /*console.log(new Array(tipo, serie, numero));
        var json = JSON.stringify(new Array(tipo, serie, numero));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo base_url().'documentos/boletas_facturas/mostrar_pdf'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'reporte',
                'value': json,
                'type': 'hidden'
            }));
        form.submit();
        return false;*/

        //window.location.replace('<?php echo base_url()."documentos/boletas_facturas"?>');
    }
</script>