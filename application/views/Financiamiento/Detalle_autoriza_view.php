<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
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
	                    	<div class="form-group control-group col-md-6 col-sm-12">
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
                            <div class="form-group control-group col-md-3 col-sm-12">
	                    		<label for="tipo-comprobante">FECHA:</label>
	                            <div class="controls">
	                                <div class="input-group">
	                                	<div class="input-group-addon">
	                                        <i class="fa fa-file-text"></i> 
	                                    </div>
	                                    <input class="form-control" type="text" value="<?php echo date("d/m/Y"); ?>" readonly>
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
	                        <div class="form-group control-group col-md-8" id="div-Nom">
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
                            <div class="form-group control-group col-md-4" id="div-Nom">
	                            <label for="nombre">OFICINA</label>
	                            <div class="input-group">
	                                <div class="input-group-addon">
	                                    <i class="fa fa-bullseye"></i>
	                                </div>
	                                <input type="text" class="form-control" id="basic-url" value="<?php echo $_SESSION['OFICINA']; ?>" readonly>
	                                
	                            </div>
	                        </div>
                            <div class="form-group control-group col-md-8" id="div-Nom">
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
                            <div class="form-group control-group col-md-4" id="div-Nom">
	                            <label for="nombre">USUARIO</label>
	                            <div class="input-group">
	                                <div class="input-group-addon">
	                                    <i class="fa fa-bookmark"></i>
	                                </div>
	                                <input type="text" class="form-control" id="basic-url" value="<?php echo $_SESSION['user_nom']; ?>" readonly>
	                                
	                            </div>
	                        </div>
                            <div class="form-group control-group col-md-8" >
	                            <label for="nombre">OBSERVACIÓN</label>
	                            <div class="input-group">
	                                <div class="input-group-addon">
	                                    <i class="fa fa-bookmark"></i>
	                                </div>
	                                <input type="text" class="form-control" id="user_obser" >
	                                
	                            </div>
	                        </div>	
                            <div class="form-group control-group col-md-4" >
	                            <label for="nombre">SELECCIONAR PERSONAL</label>
	                            <div class="input-group">
	                                <div class="input-group-addon">
	                                    <i class="fa fa-bookmark"></i>
	                                </div>
	                                <select class="form-control" id="user_personal">
                                        <option selected="true" disabled="disabled" value='0'>seleccione usuario</option>
                                        <?php
                                        foreach($usuarios as $usuario){ 
                                        ?>
                                            <option value='<?php echo  $usuario['NCODIGO']; ?>'><?php echo $usuario['NNOMBRE']; ?></option>
                                        <?php }?>
                                    </select>
	                                
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
                            <button class="btn btn-success" id="btn-autorizacion">GENERO AUTORIZACIÓN</button>
                        </div>
                  
                </div>
            </div>
        </div>
    </div> 
</section>

<script type="text/javascript">
    var oficina = '<?php echo $datos_user[0]['OFICOD'];?>' ;
    var agencia = '<?php echo $datos_user[0]['OFIAGECOD'];?>';
    var numero_credit = '<?php echo $datos_user[0]['CREDNRO'];?>' ;
    $(document).ready(function() {
        $("#btn-autorizacion").click(function() {
            genero_autorizacion();
        });
    });

    function genero_autorizacion(){
    
        var observacion = $('#user_obser').val();
        var operador = $('#user_personal').val();
        if(operador == null){
            sweetAlert("Alerta", "SELECCIONE AL PERSONAL QUE REALIZARA EL EXTORNO","error");
        }
        else{
            if(observacion.trim()==""){
                sweetAlert("Alerta", "INGRESE LA OBSERVACIÓN POR LA CUAL SE HACE EL EXTORNO","error");
            }else{
                swal({
                        title: "AUTORIZACIÓN",
                        text: "Esta seguro que quiere da la autorización",
                        type: "info",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                        }, function () {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo $this->config->item('ip');?>fina/extorno/autorizacion_registro?ajax=true",
                                data: {
                                    ofic: oficina, 
                                    agen: agencia,
                                    num_credit: numero_credit,
                                    obser: observacion,
                                    usuario_ejecutor: operador
                                },
                                dataType: 'json',
                                success: function(data) {
                                    
                                    if(data.result) {
                                        swal({
                                            title: "EXTORNO",
                                            text: data.mensaje,
                                            type: data.tipo,
                                            showCancelButton: false,
                                            closeOnConfirm: true,
                                            confirmButtonColor: "#296fb7",
                                            confirmButtonText: "Aceptar",
                                            showConfirmButton : true,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        }, function(valor){
                                            location.href ="<?php echo $this->config->item('ip');?>autoriza/extorno/recibo";
                                        });
                                        
                                        
                                    }else{
                                        swal({
                                            title: "EXTORNO",
                                            text: data.mensaje,
                                            type: data.tipo,
                                            showCancelButton: false,
                                            closeOnConfirm: true,
                                            confirmButtonColor: "#296fb7",
                                            confirmButtonText: "Aceptar",
                                            showConfirmButton : true,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        }, function(valor){
                                            location.href ="<?php echo $this->config->item('ip');?>autoriza/extorno/recibo";
                                        });
                                    }
                                },
                                error: function(data){
							swal({
								title: "EXTORNO",
								text: "NO SE PUDO GRABAR LA AUTORIZACIÓN " ,
								type: "error",
								showCancelButton: false,
								closeOnConfirm: true,
								confirmButtonColor: "#296fb7",
								confirmButtonText: "Aceptar",
								showConfirmButton : true,
								allowOutsideClick: false,
								allowEscapeKey: false,
							}, function(valor){
								console.log("error de grabado en servidor");
							});
							
						}
                            });
                        }
                    );
            }
        }
        /**/
    }

</script>