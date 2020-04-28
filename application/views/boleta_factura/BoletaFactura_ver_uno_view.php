<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $proceso; ?> </h3>
                    <span class="label label-default">
                        *<?php switch ($boleta_factura['cliente']['SUNESTADO']) {
                            case '1':
                                echo 'EMITIDO, PENDIENTE DE FIRMA';
                                break;
                            case '2':
                                echo 'SE ENVIO EN ESPERA DE FIRMA';
                                break;
                            case '3':
                                echo 'EMITIDO Y ACEPTADO POR SUNAT';
                                break;
                            case '4':
                                echo 'EMITIDO Y RECHAZADO POR SUNAT';
                                break;
                            case '5':
                                echo 'EMITIDO Y CON OBSERVACIONES POR SUNAT';
                                break;
                            case '6':
                                echo 'EMITIDO PERO NO SE CONECTO CON SUNAT';
                                break;
                            case '7':
                                echo 'EMITIDO, FIRMADO PERO SIN ENVIAR A SUNAT';
                                break;
                            case '8':
                                echo 'EMITIDO PERO NO SE CONSIGUIO FIRMA';
                                break;
                            default:
                                echo 'NO ESPECIFICADO';
                                break;
                            } ?>
                    </span>
                    <!--?php if($boleta_factura['cliente']['FSCESTADO']==1){
                            echo '<span class="label label-success">Aceptado</span>';
                    }elseif($boleta_factura['cliente']['FSCESTADO']==0){
                        echo '<span class="label label-warning">Pendiente de envio</span>';
                    }elseif ($boleta_factura['cliente']['FSCESTADO']==1) {
                        echo '<span class="label label-danger">Rechazado</span>';
                    } ?-->
                    <?php
                    //echo $boleta_factura['cliente']['FSCFECH'];
                    //$d = DateTime::createFromFormat('d-M-y H.i.s.u', $boleta_factura['cliente']['FSCFECH']);
                    //echo $d;
                    //echo $d->format('d-m-Y');
            ?>
                </div>

                <div class="box-body" >
                    <?php if(isset($profns)) { ?>
                		<div class="container-fluid">
                			<div class="form-group control-group col-md-3 col-sm-12">
	                    		<label for="tipo-comprobante">ORDEN DE PAGO:</label>
	                            <div class="controls">
	                                <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-file-text"></i>
                                        </div>
	                                    <input class="form-control" type="text" value="<?php echo str_pad($profns[0]['SERNRO'], 4, '0', STR_PAD_LEFT).' - '.str_pad($profns[0]['ORPNRO'], 6, '0', STR_PAD_LEFT); ?>" readonly>
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
                    <?php } ?>

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
	                                    <input class="form-control" type="text" value="<?php echo ($boleta_factura['cliente']['FSCTIPO']==1)? 'FACTURA':'BOLETA'; ?>" readonly>
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
	                                    <input class="form-control" type="text" value="<?php echo $boleta_factura['cliente']['FSCSERNRO'].'-'.str_pad($boleta_factura['cliente']['FSCNRO'], 6, '0', STR_PAD_LEFT); ?>" readonly>
	                                </div><!-- /.input group -->
	                            </div>
	                        </div>
	                        <div class="form-group control-group col-md-4 col-sm-12">
	                            <label for="documento"><?php echo ($boleta_factura['cliente']['FSCTIPDOC']==1)? "DNI:":"RUC:" ?></label>
	                            <div class="controls">
	                                <div class="input-group">
	                                    <div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i>
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo ($boleta_factura['cliente']['FSCTIPDOC']==1)? $boleta_factura['cliente']['FSCNRODOC']:$boleta_factura['cliente']['FSCCLIRUC'] ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="form-group control-group col-md-12" id="div-Nom">
	                            <label for="nombre">NOMBRE:</label>
	                            <div class="input-group">
	                                <div class="input-group-addon">
	                                    <i class="fa fa-user"></i>
	                                </div>
	                                <input type="text" class="form-control" id="basic-url" value="<?php echo $boleta_factura['cliente']['FSCCLINOMB'] ?>" readonly>
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
                                        <?php foreach($boleta_factura['descripcion'] as $fila) {
                                            //$p_unit = ($boleta_factura['cliente']['FSCTIPO']==1)? $fila['PUNIT']: $fila['PUNIT']*(1+$boleta_factura['cliente']['FSCIGVREF']/100);
                                            //$p_importe = ($boleta_factura['cliente']['FSCTIPO']==1)? $fila['FSCPRECIO']: ($fila['FSCPRECIO']+$fila['PRECIGV']);
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
                                                <?php if ($boleta_factura['cliente']['FSCTIPO']==1) { ?>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">SUB TOTAL</th>
                                                    <td style="text-align:right"><?php echo number_format(floatval($boleta_factura['cliente']['FSCSUBTOTA']),2); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">I.G.V.</th>
                                                    <td style="text-align:right"><?php echo number_format(floatval($boleta_factura['cliente']['FSCSUBIGV']), 2, '.', ''); ?></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">TOTAL</th>
                                                    <td style="text-align:right;color:#f00;font-size:20px"><?php echo number_format(floatval($boleta_factura['cliente']['FSCTOTAL']), 2, '.', ''); ?></td>
                                                </tr>
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 col-sm-12" >
                            <button class="btn btn-success" id="btn-pdf">IMPRIMIR COMPROBANTE</button>
                            <button class="btn btn-success" id="btn-ticket">IMPRIMIR TICKET</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(isset($_SESSION['msj_ws'])) { ?>
    <section>
        <div class="modal fade" id="modalMsj" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">RESPUESTA DE WEB SERVICE</h4>
                    </div>
                    <div class="modal-body">
                        <?php
                            $rpta = $_SESSION['msj_ws'][2][5];
                            echo $rpta;
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </section>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#modalMsj').modal('show');
        });
    </script>
<?php } ?>
<script type="text/javascript">
    $('#btn-pdf').click(function(){
        //alert("hola");
        mostrarpdf(<?php echo $boleta_factura['cliente']['FSCTIPO'].','.$boleta_factura['cliente']['FSCSERNRO'].','.$boleta_factura['cliente']['FSCNRO']; ?>);
    });

    $('#btn-ticket').click(function(){
        mostrarticket(<?php echo $boleta_factura['cliente']['FSCTIPO'].','.$boleta_factura['cliente']['FSCSERNRO'].','.$boleta_factura['cliente']['FSCNRO']; ?>);
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
