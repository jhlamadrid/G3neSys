<script type="text/javascript">
	var servidor = '<?php echo $this->config->item('ip'); ?>';
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('ip') ?>frontend/dist/css/Genesys/cobranza/cajeras.css">
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border borde_box">
					<div class="row">
						<div class="col-md-5">
							<h2 class="box-title text-uppercase text-info titulo_box" style=""><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; LISTA DE CAJERAS</h2>
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
	               <table id="cajeras" class="table table-bordered table-striped">
	                  <thead>
	                    <tr>
	                      <th>NOMBRE</th>
	                      <th>DNI</th>
	                      <th>LOGIN</th>
	                      <th>OFICINA</th>
	                      <th>FECHA EXPIRACIÓN</th>
	                      <th>ESTADO</th>
	                      <th>OPCIONES</th>
	                    </tr>
	                  </thead>
	                  <tbody id='cuerpo_cajeras'>
	                  	<?php foreach($cajeras as $c) {?>
	                  		<tr>
	                  			<td><?php echo $c['NNOMBRE']; ?></td>
	                  			<td><?php echo $c['NDNI']; ?></td>
	                  			<td><?php echo $c['LOGIN']; ?></td>
	                  			<td><?php echo $c['OFIDES']; ?></td>
	                  			<td class="derecha"><?php echo $c['NENDS']; ?></td>
	                  			<td class="center">
	                  				<?php if($c['NESTADO'] == 1) { ?>
	                  					<small class="label bg-green">ACTIVO</small>
	                  				<?php } else if($c['NESTADO'] == 0) { ?>
	                  					<small class="label bg-yellow">INCATIVO</small>
	                  				<?php } else if($c['NESTADO'] == 2) { ?>
	                  					<small class="label bg-red">ELIMINADO</small>
	                  				<?php } else { ?>
	                  					<small class="label bg-blue">MANTENIMIENTO</small>
	                  				<?php } ?>
	                  			</td>
	                  			<td class="center">
	                  				<button type="button" class="btn btn-warning btn-xs" onclick="cambiar_oficina('<?php echo $c['OFIDES'] ?>','<?php echo $c['NSOFICOD'];?>','<?php echo $c['NCODIGO']; ?>','<?php echo $c['NNOMBRE']; ?>')">
	                  					<i class="fa fa-location-arrow" aria-hidden="true"></i> Cambiar Oficina
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
</section>
<?php if (isset($cambiar_localidad)) { ?>
<div class="modal fade" id='localidades' role='dialog'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content contenido_modal">
      <div class="modal-header head_green"> 
        <button type="button" name="button" class="close" data-dismiss='modal' onclick='ocultar_modal("localidades")'>&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-location-arrow" aria-hidden="true"></i> CAMBIAR OFICINAS</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-md-6 col-sm-6">
      			<div class="input-group ">
	              <span class="input-group-addon hidden-sm hidden-xs bordes">OFICINA ACTUAL</span>
	              <span class="input-group-addon hidden-md hidden-lg bordes">OF. ACT.</span>
	              <input type="text" class="form-control" id="oficina"  disabled>
	            </div>
      		</div>
      		<div class="col-md-6 col-sm-6">
      			<div class="input-group ">
	              <span class="input-group-addon hidden-sm hidden-xs bordes">USUARIO</span>
	              <span class="input-group-addon hidden-md hidden-lg bordes">USR.</span>
	              <input type="text" class="form-control" codigo="" id="usuario"  disabled>
	            </div>
      		</div>
      	</div><br>
      	<div class="row">
      		<div class="col-md-3"></div>
      		<div class="col-md-6">
      			<div class="input-group ">
	      			<span class="input-group-addon hidden-sm hidden-xs bordes">OFICINAS</span>
	      			<span class="input-group-addon hidden-md hidden-lg bordes">OF.</span>
	      			<select class="form-control" id='selector'>
	      				<option value="-1">SELECCIONE UNA OPCIÓN</option>
	      				<?php foreach ($oficinas as $o) { ?>
	      					<option value='<?php echo $o['OFICOD'] ?>'><?php echo $o['OFIDES']; ?></option>
	      				<?php } ?>
	      			</select>
      			</div>
      		</div>
      	</div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" onclick="ocultar_modal('localidades')"> 
            <i class="fa fa-times-circle" aria-hidden="true"></i> CERRAR
          </button>
        </div>
        <div class="col-md-4 col-sm-4"></div>
        <div class="col-md-4 col-sm-4">
            <button type="button" id='btn-guardar' class="btn btn-success btn-block">
            	<i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp; ACTUALIZAR
            </button>
         </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/dist/js/Genesys/cobranza/cajeras.js" type="text/javascript"></script>
<script type="text/javascript">
	$('#cajeras').DataTable({"bFilter": true, "bInfo": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
	


</script>