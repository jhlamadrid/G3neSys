<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.dataTables.min.css">
<style type="text/css">
    
    .modal-header{
        background-color: #2F71AB;
        color:#fff;
    }
    .modal-footer{
        background-color: #2F71AB;
        color:#fff;
    }
    .tabbable-custom .nav-tabs li.active {
        border-top: 4px solid #337ab7;
        margin-top: 0;
        position: relative;
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
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">CAMBIAR CARGO </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class='col-md-12'>
                            <div class="" id="aa">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_5_1" data-toggle="tab" aria-expanded="true"> CAMBIAR DE CARGO </a>
                                    </li>
                                    <li class="">
                                        <a href="#tab_5_2" data-toggle="tab" aria-expanded="false"> CAMBIAR DE AREA </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_5_1">
                                        <div class='row'>
                                            <div class ='col-md-12'>
                                                <div class="row">
                                                    <div class ='col-md-12'>
                                                        <div class ='col-md-12' style="margin-top:12px;">
                                                            <h3 class='text-center'>
                                                                <strong>
                                                                    LISTA DE LAS AREAS CON SUS RESPECTIVOS REPRESENTANTES
                                                                </strong>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='row' style='margin-top:20px;'>
                                                    <div  class='col-md-12'>
                                                        <table id="tbl_listar_documentos" class="display responsive table table-striped table-bordered dataTable">
                                                            <thead style="background-color: #337ab7;color:white;font-weight: bold ">
                                                                <tr role="row">
                                                                    <th class="all" style="text-align: center; width: 25%">AREA</th>
                                                                    <th class="none" style="text-align: center; width: 20%">NOMBRE DEL ENCARGADO</th>
                                                                    <th class="none" style="text-align: center; width: 15%">FECHA DE ASIGNACIÓN</th>
                                                                    <th class="all" style="text-align: center; width: 20%">SIGLAS</th>
                                                                    <th class="all" style="text-align: center; width: 10%">ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane" id="tab_5_2">
                                        <div class ='row'>
                                            <div class='col-md-12'>
                                                <div class="row">
                                                    <div class ='col-md-12'>
                                                        <div class ='col-md-12' style="margin-top:12px;">
                                                            <h3 class='text-center'>
                                                                <strong>
                                                                    LISTA DE USUARIOS 
                                                                </strong>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class ='row' style='margin-top:20px;'>
                                                    <div class='col-md-12'>
                                                        <table id="tbl_listar_usuarios" class="display responsive table table-striped table-bordered dataTable">
                                                            <thead style="background-color: #337ab7;color:white;font-weight: bold ">
                                                                <tr role="row">
                                                                    <th class="none" style="text-align: center; width: 20%">NOMBRE DEL USUARIO</th>
                                                                    <th class="none" style="text-align: center; width: 15%">LOGIN</th>
                                                                    <th class="all" style="text-align: center; width: 20%">DIRECCIÓN</th>
                                                                    <th class="all" style="text-align: center; width: 10%">ACCIONES</th>
                                                                </tr>
                                                            </thead>
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
    </div>
</section>

<div id="modal_areas" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i>  AREA : <span id="sp_doc_ref" style="color: #ff6961;font-weight: bold"></span></h3>
            </div>
            <div class="modal-body">
                <div class = 'row' >
                    <div class ='col-md-12'>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label>FECHA CREACIÓN : </label>
                                <span style='margin-top:15px; color:#2F71AB; font-size:20px;'  id='txtFechaCrea' > </span>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-md-offset-6">
                            <div class="form-group">
                                <label> ESTADO: </label>
                                <span style='margin-top:15px; color: #1ab394; font-size:20px;'  id='txtEstado' > </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class ='row'>
                    <div class ='col-md-12'>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>ASIGNAR NUEVO ENCARGADO</label>
                                <select class="form-control select2" id="cbo_nuevo_representante" name="cbo_nuevo_representante" style="width: 100%;">
                                    <?php foreach( $usuario_habilitado as $posicion=>$clave ) { ?>
                                        <option value="<?php echo $clave->NCODIGO; ?>"><?php echo $clave->NNOMBRE; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class ='row'>
                    <div class ='col-md-12'>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>ACTUAL ENCARGADO : </label>
                                <input class="form-control" name="txtEncargadoActual" id='txtEncargadoActual'  placeholder="Actual Encargado" disabled/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label> SIGLAS AREA: </label>
                                <input class="form-control" name="txtSiglasActual" id='txtSiglasActual'  placeholder="Sigla Actual" maxlength="10" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn  btn-primary" id="btnGuardarDato">GUARDAR</button>
                <button type="button" class="btn  btn-danger" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
<!--  MODAL PARA EL CAMBIO DE AREA -->
<div id="modal_usuarios" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> CAMBIO DE AREA  </h4>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class ='col-md-12'>
                        <div class ='col-md-12'>
                            <div class="form-group">
                                <label for="area_actual">Area Actual:</label>
                                <input type="text" class="form-control" style=' color: #000; font-size:20px;' id="area_actual" disabled>
                            </div>
                        </div>
                    </div>
                    <div class ='col-md-12'>
                        <div class ='col-md-12'>
                            <div class="form-group">
                                <label for="jefe_area">Nombre:</label>
                                <input type="text" class="form-control" style=' color: #000; font-size:20px;' id="jefe_area" disabled>
                            </div>
                        </div>
                    </div>
                    <div class ='col-md-12'>
                        <div class ='col-md-12'>
                            <div class="form-group">
                                <label for="estado_usuario">Area para cambiar:</label>
                                <select class="form-control select2" id="sel_AreaCambiar" name="sel_AreaCambiar" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class ="col-md-12">
                        <div class ='col-md-6'>
                            <div class="form-group">
                                <label for="estado_usuario">Estado de Usuario:</label>
                                <input type="text" class="form-control" id="estado_usuario" style=' color: #1ab394; font-size:20px;' value='HABILITADO' disabled>
                            </div>
                        </div>
                        <div class ='col-md-6'>
                            <div class="form-group">
                                <label for="sigla_usuario">Siglas de Usuario:</label>
                                <input type="text" class="form-control" id="sigla_usuario" maxlength="7"  onkeypress='return soloLetras(event)' onblur='limpia()'  style='color: #000; font-size:20px; text-transform:uppercase;'>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn  btn-primary" id="btnGuardarDato_Usuario">GUARDAR</button>
                <button type="button" class="btn  btn-danger" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>






<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/loadingoverlay.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.colVis.min.js" type="text/javascript"></script> 
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/vfs_fonts.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/jsCambiarCargo.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        CambiarCargo.init();
    });

</script>