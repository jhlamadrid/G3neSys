<link href="<?php echo $this->config->item('ip'); ?>/frontend/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/datepicker3.css">
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
<style>
    .tabbable-custom .nav-tabs li.active {
        border-top: 4px solid #337ab7;
        margin-top: 0;
        position: relative;
    }

    .select2-container {
        width: 100% !important;
        padding: 0;
    }

    .nav-tabs
	{
	border-color:#1A3E5E;
	}

	.nav-tabs > li a { 
		border: 1px solid #1A3E5E;
		background-color:#2F71AB; 
		color:#fff;
		}

	.nav-tabs > li.active > a,
	.nav-tabs > li.active > a:focus,
	.nav-tabs > li.active > a:hover{
		background-color:#fff;
		color:#000;
		border: 1px solid #1A3E5E;
		border-bottom-color: transparent;
		}

	.nav-tabs > li > a:hover{
	background-color: #fff !important;
		border-radius: 5px;
		color:#000;

	} 

    .modal-header{
        background-color: #2F71AB;
        color:#fff;
    }
    .modal-footer{
        background-color: #2F71AB;
        color:#fff;
    }

	.tab-pane {
		border:solid 1px #1A3E5E;
		border-top: 0; 
		background-color:#fff;
		padding:5px;

	}
    
</style>

<section class="content">

    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu"> INGRESAR DOCUMENTO EXTERNO </h3>
                </div>
                <div class="box-body">
                    <div class ='row'>
                        <div class="col-md-12">
                            <div class="col-md-12" id="aa">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_5_1" data-toggle="tab" aria-expanded="true"> INGRESAR EXTERNOS </a>
                                    </li>
                                    <li class="">
                                        <a href="#tab_5_2" data-toggle="tab" aria-expanded="false"> LISTA DE EXTERNOS INGRESADOS </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_5_1">
                                        <div class="row" style='margin:5px;'>
                                            <div class="col-md-12">
                                                <div class ='row'>
                                                    <div class ='col-md-12'>
                                                        <div class ='col-md-12' style="margin-top:12px;">
                                                            <h3 class='text-center'>
                                                                <strong>
                                                                    INGRESAR LOS DOCUMENTOS EXTERNOS 
                                                                </strong>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>1. ASUNTO Y OBSERVACIÓN</td></tr></table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Remintente</label>
                                                            <input class="form-control" name="Solicitante" id='Solicitante' placeholder="Remitente" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Suministro</label>
                                                            <input class="form-control" name="txtSuministro" id='txtSuministro' maxlength="11"  placeholder="Suministro" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Tip. Documento</label>
                                                            <select class="form-control" id="SelecTipDoc">
                                                                <option value="1">DNI</option>
                                                                <option value="2">RUC</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">NUM. DOCUMENTO</label>
                                                            <input class="form-control" name="txtNumDoc" id='txtNumDoc' maxlength="8"  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label class="control-label">Asunto</label>
                                                            <input class="form-control" name="txtAsunto" id='txtAsunto'  placeholder="Asunto" />
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-5">
                                                        <label>FECHA <span style='color:red;'>MAXIMA</span> DE ATENCIÓN </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            </span>
                                                            <input type="text" class="form-control" id="NSUM-INI-MAXI" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Observaciones</label>
                                                            <input class="form-control" name="observaciones" id='observaciones' placeholder="Observaciones" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Correo</label>
                                                            <input class="form-control" name="Correo" id='txtCorreo' placeholder="Correo" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Telefono</label>
                                                            <input class="form-control" name="telefono" id='txtTelefono' placeholder="telefono" maxlength="9" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Contenido</label>
                                                            <textarea  class="form-control" name="contenido" rows="3" id='contenido' placeholder="Pegue aqui contenido documento"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label" style="font-weight: bolder;">Folios Totales</label>
                                                            <input class="form-control" name="folios"  id="txtFolios" style="color: blue;font-weight: bold;font-size: 20px;"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div action="SubirArchivos/SubidaSingular/externo"  name="userfile"  class="dropzone dropzone-file-area" id="my-dropzone" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>2. DESTINATARIO </td></tr></table>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class="col-xs-12 col-md-5">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <select class="form-control" id="cmbNombre" name="cmbNombre">
                                                                </select>
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-primary" id="btnAgregar" data-toggle="tooltip" data-placement="right" title="Agregar Destinatario"><i class="fa fa-plus"></i></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <table id="tbl_sis_destinatarios" class="table table-condensed table-bordered  table-sm table-hover">
                                                                <thead style="background-color:#fafafa;color:black">
                                                                    <tr role="row">
                                                                        <th class="all" style="text-align: left;width: 35%">DESTINATARIO</th>
                                                                        <th class="all" style="text-align: center;width: 10%">ELIMINAR</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class ='row'>
                                                    <div class="form-actions right">
                                                        <div class="col-md-3 col-md-offset-6" style='margin-top:15px;'>
                                                            <button  id="btnGuardar" class="btn btn-success btn-block" >Guardar</button>
                                                        </div>
                                                        <div class="col-md-3" style='margin-top:15px;'>
                                                            <button  id="btnImprimir" class="btn btn-primary btn-block" >Imprimir</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane" id="tab_5_2">
                                            <div class ='row'>
												<div class ='col-md-12'>
													<div class ='col-md-12' style="margin-top:12px;">
														<h3 class='text-center'>
															<strong>
																LISTA DE DOCUMENTOS EXTERNOS INGRESADOS
															</strong>
														</h3>
													</div>
												</div>
												<div class ='col-md-12'>
													<div class="form-group control-group col-md-6 col-sm-12">
														<label>FECHA INICIO</label>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" aria-hidden="true"></i>
															</span>
															<input type="text" class="form-control" id="NSUM-INI" readonly>
														</div>
													</div>
													<div class="form-group control-group col-md-6 col-sm-12">
														<label>FECHA FIN</label>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" aria-hidden="true"></i>
															</span>
															<input type="text" class="form-control" id="NSUM-FIN" readonly>
														</div>
													</div>
												</div>
												<div class ='col-md-12'>
													<div class ='col-md-12'>
														<table class=' table display' id='tbl_lista_reclamo'>
															<thead>
																<th>Documento</th>
																<th>Suministro</th>
																<th>Asunto</th>
																<th>Fecha Registro</th>
																<th>Folios</th>
																<th>Opciones</th>	
															</thead>
															<tbody>
															</tbody>
														</table>
													</div>
													
												</div>
											</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<div id="modal_resp" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p style="text-align: center;font-size: xx-large;color: green;"> Se registro con éxito! </p>
                <div style="text-align: center;font-size: xx-large;color: #337ab7;font-weight: bold;">
                    <span style="font-size: x-large;color:black" id="doc_generado"></span><br><br>
                    <button type="submit" id="ok" class="btn btn-primary" tipo="exp">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>frontend/plugins/dropzoneform/form_externo_dropzone.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/loadingoverlay.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/jquery.numeric.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/FixedHeader-3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/jsExterDocumento.js?v=<?php echo(rand()); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {

        DocExterno.init();


    });
</script> 