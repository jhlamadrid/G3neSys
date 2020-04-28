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
            <div class="box  box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $proceso; ?></h3>
                </div>
                <div class="box-body" >
                    <div class="container-fluid">
                            <div class="form-group control-group col-md-3 col-sm-12">
                                <label for="tipo-comprobante">CODIGO DE SUMINISTRO:</label>
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
                                        <input class="form-control" type="text" value="<?php echo ($cliente['FSCTIPO']==1)? 'PROFORMA FACTURA':'PROFORMA BOLETA'; ?>" readonly>
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
                                        <input class="form-control" type="text" value="<?php echo $cliente['FSCSERNRO'].'-'.str_pad($cliente['FSCNRO'], 6, '0', STR_PAD_LEFT); ?>" readonly>
                                    </div><!-- /.input group -->
                                </div>
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label for="documento"><?php echo ($cliente['FSCTIPDOC']!=6)? $cliente['TIPDOCDESCABR'].':':'RUC:'; ?></label>
                                <div class="controls">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                        <input class="form-control" type="text" value="<?php echo ($cliente['FSCTIPDOC']!=6)? $cliente['FSCNRODOC']:$cliente['FSCCLIRUC'] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-12" id="div-Nom">
                                <label for="nombre">NOMBRE:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="basic-url" value="<?php echo $cliente['FSCCLINOMB'] ?>" readonly>
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
                                    <input type="text" class="form-control" id="basic-url" value="<?php echo $cliente['OBSDOC'] ?>" readonly>
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
                                        <?php foreach($detalle as $fila) {
                                            $p_unit = ($cliente['FSCTIPO']==1)? $fila['PUNIT']: $fila['PUNIT']*(1+$cliente['FSCIGVREF']/100);
                                            $p_importe = $fila['FSCPRECIO']+$fila['PRECIGV'];
                                            //$observacion = ($fila['OBSFACAUX'] == '' || $fila['OBSFACAUX'] == null)? '':(' - '.$fila['OBSFACAUX']);
                                        ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $fila['FACCONCOD']; ?></td>
                                                <td><?php echo $fila['FACCONDES']; ?></td>
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
                                                <?php if ($cliente['FSCTIPO']==1) { ?>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">SUB TOTAL</th>
                                                    <td style="text-align:right"><?php echo number_format(floatval($cliente['FSCSUBTOTA']),2); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">I.G.V.</th>
                                                    <td style="text-align:right"><?php echo number_format(floatval($cliente['FSCSUBIGV']), 2, '.', ''); ?></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">TOTAL</th>
                                                    <td style="text-align:right;color:#f00;font-size:20px"><?php echo number_format(floatval($cliente['FSCTOTAL']), 2, '.', ''); ?></td>
                                                </tr>
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 " >
                            <div class="col-md-4">
                                <button class="btn btn-warning" id="btn-pagar">CONTINUAR PROCESO</button>
                            </div>
                            <div class="col-md-4 col-md-offset-4">
                                <!--
                                <button class="btn btn-success" id="btn-pdf">IMPRIMIR COMPROBANTE</button> 
                                -->
                                <button class="btn btn-success" id="btn-ticket">IMPRIMIR TICKET</button>
                            </div>

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
            title: "Desea continuar proceso de esta  "+"<?php echo ($cliente['FSCTIPO']==1)? 'Factura':'Boleta de Venta'; ?>"+" ?",
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

                json = JSON.stringify(new Array("<?php echo $cliente['FSCTIPO']; ?>",
                                                "<?php echo $cliente['FSCSERNRO']; ?>",
                                                "<?php echo $cliente['FSCNRO']; ?>"));
                event.preventDefault();
                var form = jQuery('<form>', {
                        //'action': "<?php echo $this->config->item('ip');?>documentos/boletas_factura/continuar_Proceso",
                        'action': "<?php echo $this->config->item('ip');?>documentos/boletas_factura/continuar_Proceso_ose",
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


            }

        });

    });
     $('#btn-pdf').click(function(){
        mostrarpdf(<?php echo $cliente['FSCTIPO'].','.$cliente['FSCSERNRO'].','.$cliente['FSCNRO']; ?>);
    });

    $('#btn-ticket').click(function(){
        mostrarticket(<?php echo $cliente['FSCTIPO'].','.$cliente['FSCSERNRO'].','.$cliente['FSCNRO']; ?>);
    });

    function mostrarticket(tipo, serie, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip').'documentos/boletas_facturas/mostrar_ticket/'; ?>"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
        return true;
    }

    function mostrarpdf(tipo, serie, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip').'documentos/boletas_facturas/mostrar_pdf/'; ?>"+tipo+"/"+serie+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
        return true;
    }

</script>
