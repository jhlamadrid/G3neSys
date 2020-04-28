<section class="content">
	<div class="row">
		<div class="col-xs-12">
        <?php if (isset($_SESSION['mensaje'])) { ?>
        		<div class="alert bg-<?php echo $_SESSION['mensaje'][0]; ?> alert-dismissible">
            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            		<?php echo $_SESSION['mensaje'][1]; ?>
        		</div><br>
        	<?php } ?>

			<div class="row">
                <div class="col-md-12 text-blue" style="font-size: 24px; text-align: center">
                    <label>Formulario de Respuesta</label>
                </div>
			</div>
		</div>
	</div>
    <div class="panel panel-success">
        <div class="panel-heading borde_box">
            <h5>Respuesta de la Observación N° <?php echo str_pad( $obs['CODIGO'], 6, '0', STR_PAD_LEFT)."-".$obs['ANIO']; ?></h5>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">Nombre</div>
                        <input type="text" class="form-control" id="nombre" value="<?php echo $obs['NOMBRE']." ".$obs["APEPAT"]." ".$obs["APEMAT"] ?> " readonly>
                    </div><br>
                    <div class="input-group">
                        <div class="input-group-addon">DNI</div>
                        <input type="text" class="form-control" id="dni" value="<?php echo $obs['NRODOC'] ?> " readonly>
                    </div><br>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">Fecha de Registro</div>
                        <input type="text" class="form-control" id="fechaRegistro" value="<?php echo $obs['FECREG'] ?> " readonly>
                    </div><br>
                    <div class="input-group">
                        <div class="input-group-addon">DOMICILIO</div>
                        <input type="text" class="form-control" id="domicilio" value="<?php echo $obs['DOMICILIO'] ?> " readonly>
                    </div><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-addon">Detalle</div>
                        <textarea class="form-control" rows="4" readonly><?php echo $obs['DETALLE']; ?></textarea>
                    </div><br>
                </div>
            </div>
            
            <hr>

            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label for="fchRes" class="col-sm-2 control-label">Fecha Respuesta</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fchRes" value="<?php echo  date('d/m/Y')?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="respuesta" class="col-sm-2 control-label">Respuesta</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="respuesta" name="respuesta" rows="4"  required></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success" style="width:100%"> <i class="fa fa-location-arrow" aria-hidden="true"></i> Enviar Respuesta</button>
                    </div>
                </div>
            </form>
                
            
        </div>
    </div>
</div>