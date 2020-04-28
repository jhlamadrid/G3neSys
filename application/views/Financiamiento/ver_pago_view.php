<style>
    .modal-header, h5, .close {
      background-color: #3C8DBC;
      color:white !important;
      text-align: center;
      font-size: 20px;
	  }
	.modal-footer {
	      background-color:#3C8DBC;
	  }
</style>
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
                    

                    	<div class="container-fluid">
                			<div class="form-group control-group col-md-3 col-sm-12">
	                    		<label for="tipo-comprobante">CODIGO DE SUMINISTRO:
                                    <a target="_blank" href="https://cel.reniec.gob.pe/valreg/valreg.do;jsessionid=97657851cf84a1b5e8e57db400289a1dfe6deb1635f.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaMa3D3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaPb3aPbhiTbN4xf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_" data-toggle="tooltip" data-placement="bottom" title data-original-title="Ir a web"><i class="fa fa-eye"></i></a>
                                
                                </label>
	                            <div class="controls">
                                    <?php //var_dump($datos_user);?>
	                                <div class="input-group">
	                                	<div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i> 
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo str_pad($datos_user[0]['CLICODFAC'], 4, '0', STR_PAD_LEFT); ?>" readonly>
	                                </div>
	                            </div>	
	                    	</div>
	                    	<div class="form-group control-group col-md-9 col-sm-12">
	                    		<label for="tipo-comprobante">NUMERO DE CREDITO:</label>
	                            <div class="controls">
	                                <div class="input-group">
	                                	<div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i> 
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo $datos_user[0]['CREDNRO']; ?>" readonly>
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
	                                    <input class="form-control" type="text" value="<?php echo 'INI. CONVENIO'; ?>" readonly>
	                                </div>
	                            </div>  
	                        </div>
	                        <div class="form-group  control-group col-md-4 col-sm-12">
	                            <label for="ubicacion">OFICINA - AGENCIA:</label>
	                            <div class="controls">
	                                <div class="input-group">
	                                    <div class="input-group-addon">
	                                        <i class="fa fa-map-marker"></i>
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo $datos_user[0]['OFICOD'].'-'.$datos_user[0]['OFIAGECOD']; ?>" readonly>
	                                </div><!-- /.input group -->
	                            </div>  
	                        </div>
	                        <div class="form-group control-group col-md-4 col-sm-12">
	                            <label for="documento"><?php echo 'DNI:'; ?></label>
	                            <div class="controls">
	                                <div class="input-group">
	                                    <div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i> 
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo ($datos_user[0]['REPSOLDNI']==NULL)? $datos_user[0]['SOLICIDNI']: $datos_user[0]['REPSOLDNI'] ?>" readonly>
	                                </div>
	                            </div>  
	                        </div>
	                        <div class="form-group control-group col-md-12" id="div-Nom">
	                            <label for="nombre">NOMBRE:</label>
	                            <div class="input-group">
	                                <div class="input-group-addon">
	                                    <i class="fa fa-user"></i>
	                                </div>
	                                <input type="text" class="form-control" id="basic-url" value="<?php echo ($datos_user[0]['REPSOLNOM']==null)  ?  $datos_user[0]['SOLICINOM'] : $datos_user[0]['REPSOLNOM']; ?>" readonly>
	                                <!--span class="glyphicon glyphicon-warning-sign form-control-feedback" id="Aviso-Nom" aria-hidden="true" style="color:#f0ad4e;"></span>
	                                <span class="sr-only">(1)</span-->
	                            </div>
	                        </div>
                            <div class="form-group control-group col-md-12" id="div-Nom">
                                <label for="nombre">DIRECCIÓN:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="basic-url" value="<?php echo ($datos_user[0]['REPSOLDIRE']==null)  ?  $datos_user[0]['SOLICIDIRE'] : $datos_user[0]['REPSOLDIRE']; ?>" readonly>
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
                                        <tr>
                                            <td style="text-align:center;"><?php echo $datos_user[0]['CREDNRO']; ?></td>
                                            <td style="text-align:center;">PAG. INICIAL CONV.</td>
                                            <td style="text-align:center;"><?php echo number_format($datos_user[0]['INICIAL'], 2); ?></td>
                                            <td style="text-align:center;"><?php echo 1; ?></td>
                                            <td style="text-align:center;"><?php echo number_format($datos_user[0]['INICIAL'], 2); ?></td>
                                        </tr>
                                        
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
                                                
                                                <tr>
                                                    <th style="text-align:right;padding-right:30px" colspan="4">TOTAL</th>
                                                    <td style="text-align:right;color:#f00;font-size:20px"><?php echo number_format($datos_user[0]['INICIAL'], 2); ?></td>
                                                </tr>
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-sm-12" >
                            <button class="btn btn-success" id="btn-ticket">IMPRIMIR TICKET</button>
                        </div>
                  
                </div>
            </div>
        </div>
    </div> 
</section>
<?php if(isset($_SESSION['respuesta'])) { ?>
    <section>
        <div class="modal fade" id="modalMsj" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">RESPUESTA DE PAGO</h4>
                    </div>
                    <div class="modal-body">
                        <?php 
                            $rpta = $_SESSION['respuesta']; 
                            echo "<h3 style ='text-align: center;'><i class='fa fa-usd' aria-hidden='true'></i>".$rpta[1]."</h3>";
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
            $('#btn-ticket').click(function(){
                mostrarticket(<?php echo $datos_user[0]['OFICOD'].','.$datos_user[0]['OFIAGECOD'].','.$datos_user[0]['CREDNRO']; ?>);
            });
        });
    </script>
<?php } ?>
<script type="text/javascript">
	function mostrarticket(oficina, agencia, numero){
        var myWindow = window.open("<?php echo $this->config->item('ip').'financiamiento/mostrar_ticket/'; ?>"+oficina+"/"+agencia+"/"+numero, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
        return true;
    }

</script>