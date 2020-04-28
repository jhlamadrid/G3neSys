<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/datepicker3.css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<section class="content">
    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu"> <i class="fa fa-file-text" aria-hidden="true"></i> GENERAR SOLICITUD DE REQUERIMIENTO </h3>
                </div>
                <div class="box-body">
                    <div class ="row">
                        <div class ='col-md-12'>
							<div class="form-group control-group col-md-2">
								<label>FECHA INICIO :</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar" aria-hidden="true"></i>
									</span>
									<input type="text" class="form-control" id="NSUM-INI" readonly>
								</div>
						    </div>
							<div class="form-group control-group col-md-2 ">
								<label>FECHA FIN : </label>
							    <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar" aria-hidden="true"></i>
									</span>
									<input type="text" class="form-control" id="NSUM-FIN" readonly>
								</div>
							</div>
                            <div class="form-group control-group col-md-3 ">
								<label>TIPO DE SOLICITUD :</label>
							    <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-eyedropper" aria-hidden="true"></i>
									</span>
									<select class="form-control" id="sel_tipo_sol">
                                        <option value="0">Todos</option>
                                        <option value="1">Solicitud Particular</option>
                                        <option value="2">Solicitud General</option>
                                    </select>
								</div>
							</div>
                            <div class="form-group control-group col-md-3 ">
								<label>TIPO DE PROBLEMA :</label>
							    <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-eyedropper" aria-hidden="true"></i>
									</span>
									<select class="form-control" id="sel_tipo_problema">
                                        <option value="0">Todos</option>
                                        <option value="1">Operacional</option>
                                        <option value="2">Comercial</option>
                                    </select>
								</div>
							</div>
                            <div class="form-group control-group col-md-2 ">
								<label>ESTADO :</label>
							    <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-history" aria-hidden="true"></i>
									</span>
									<select class="form-control" id="sel_estado_sol">
                                        <option value="0">Todos</option>
                                        <option value="1">Atendido</option>
                                        <option value="2">Pendiente</option>
                                    </select>
								</div>
							</div>
						</div>
                    </div>
                    <div class="row" style='margin-top:15px;'>
                        <div class="col-md-12">
                            <table id="tbl_solicitud" class="table table-bordered table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>Código</th>
                                        <th>DNI</th>
                                        <th>Fecha/Hora</th>
                                        <th>Descripción</th>
                                        <th>Tipo de Solicitud</th>
                                        <th>Tipo de Problema</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/loadingoverlay.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/FixedHeader-3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.colVis.min.js" type="text/javascript"></script> 
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/jquery.numeric.js"></script>
<script  type="text/javascript"  src="<?php echo $this->config->item('ip') ?>frontend/js/reclamos/jsSolicitud_requerimiento.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        Solicitud_requerimiento.init();
    });
</script>