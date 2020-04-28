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

    /* Estilo para el checkbox */
    /* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
    
</style>

<section class="content">

    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">CREAR DOCUMENTOS </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class='col-md-12'>
                            <div class="" id="aa">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_5_1" data-toggle="tab" aria-expanded="true"> Nuevo Documento </a>
                                    </li>
                                    <li class="">
                                        <a href="#tab_5_2" data-toggle="tab" aria-expanded="false"> Mis Documentos Creados </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_5_1">
                                       <div class ='row'>
                                            <div class ='col-md-12' style ='margin-top:15px;'>
                                                <div class="row no-print well"  style="
                                                    border-width: 1px;
                                                    border-style: solid;
                                                    border-color: #7191bf42;
                                                    background: #e4e4e41a;
                                                    margin-left: 0px;
                                                    margin-right: 0px;
                                                    "> 
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>1. TIPO DOCUMENTO</td></tr></table>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="form-group">
                                                                <select class="form-control" id="cbo_tipo_doc" name="cbo_tipo_doc">
                                                                    <?php

                                                                    foreach ($tipo_doc as &$item) {
                                                                        ?>
                                                                        <option  value="<?php echo $item["IDTIPODOCUMENTO"]; ?>"><?php echo $item["NOMBREDOCUMENTO"]; ?></option>
                                                                    <?php }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>2. AGREGAR REFERENCIAS</td></tr></table>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-2">
                                                            <button type="button" class="btn btn-primary btn-sm" id="btnBuscarRefs"><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar Referencia</button>
                                                        </div>
                                                    </div>
                                                    <div class="row" style='margin-top:15px'>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <table id="tbl_refs" class="table table-condensed table-bordered  table-sm">
                                                                    <thead style="background-color:#fafafa;color:black">
                                                                        <tr role="row">
                                                                            <th class="all" style="text-align: left;width: 20%">TIPO DOC.</th>                                            
                                                                            <th class="all" style="text-align: center;width: 10%">FOLIOS</th>
                                                                            <th class="all" style="text-align: left;width: 30%">DEPENDENCIA</th>
                                                                            <th class="all" style="text-align: left;width: 20%">ESTADO</th>
                                                                            <th class="all" style="text-align: center;width: 20%">ACCIONES</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>3. ASUNTO Y OBSERVACIÓN</td></tr></table>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">ASUNTO</label>
                                                                <input class="form-control" name="txtAsunto" id='txtAsunto'  placeholder="Asunto" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group control-group col-md-6 col-sm-12">
                                                            <label>FECHA <span style='color:red;'>MAXIMA</span> DE ATENCIÓN </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                </span>
                                                                <input type="text" class="form-control" id="NSUM-INI" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">OBSERVACIONES</label>
                                                                <input class="form-control" name="observaciones" id='observaciones' placeholder="Observaciones" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">CONTENIDO</label>
                                                                <textarea  class="form-control" name="contenido" rows="3" id='contenido' placeholder="Pegue aqui contenido documento"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" >FOLIOS DOCUMENTO (a Generar)</label>
                                                                <input class="form-control" name="foliosDoc" id="txtFolios" style="font-weight: bold;font-size: 20px;"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" style="color: #337ab7;font-weight: bolder;">FOLIOS TOTALES (si adjunto referencia)</label>
                                                                <input class="form-control" name="folios"  id="txtFolioDoc" style="color: blue;font-weight: bold;font-size: 20px;"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div action="SubirArchivos/SubidaSingular"  name="userfile"  class="dropzone dropzone-file-area" id="my-dropzone" style="width: 100%;">
                                                                <!--<span class="sbold" style ='font-size:20px;'>Arrastre los archivos o haga click para subirlos</span>
                                                                <p> Seleccione los archivos adjuntos al expediente. </p>  -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="sec_destinatario" style="display:block" >
                                                        <div class="row" style='margin-top:15px;'>
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>4. DESTINATARIOS</td></tr></table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-3" id="divEntExt" style="margin-bottom: 1%;">
                                                                <div class="md-checkbox-inline">
                                                                    <label class="container">Destino Entidad Externa
                                                                        <input type="checkbox" id="chkEntExt">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                
                                                            <div class="col-xs-12 col-md-3" id="divChkPersonal" style="display: none;margin-bottom: 1%" >
                                                                <div class="md-checkbox-inline">
                                                                    <label class="container">Listar Personal
                                                                        <input type="checkbox" id="chkPersonal">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row">
                                                            <div class="col-xs-12 col-md-12" id="divOpcMemo"  style="display: none;" >
                                                                <div class="md-radio-inline">
                                                                    <div class="md-radio">
                                                                        <input type="radio" id="radio14" name="radio2" value="d" class="md-radiobtn"  checked="checked">
                                                                        <label for="radio14">
                                                                            <span class="inc"></span>
                                                                            <span class="check"></span>
                                                                            <span class="box"></span> Dependencias </label>
                                                                    </div>
                                                                    <div class="md-radio ">
                                                                        <input type="radio" id="radio15" name="radio2" value="p" class="md-radiobtn" >
                                                                        <label for="radio15">
                                                                            <span class="inc"></span>
                                                                            <span class="check"></span>
                                                                            <span class="box"></span> Personal Dependencia </label>
                                                                    </div>
                                                                    <div class="md-radio ">
                                                                        <input type="radio" id="radio16" name="radio2" value="e" class="md-radiobtn" >
                                                                        <label for="radio16">
                                                                            <span class="inc"></span>
                                                                            <span class="check"></span>
                                                                            <span class="box"></span> Externas </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-6 col-lg-6" id="divInputEntExt" style="display: none;">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input id="txtEntidadExterna" style="color:#3F51B5;font-weight: bold;text-transform: uppercase" class="form-control"  placeholder="Ingresa aquí nombre Entidad Externa"></input>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-primary" id="btnAgregarExt" data-toggle="tooltip" data-placement="right" title="Agregar Destinatario"><i class="fa fa-plus"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="display: block;" id="divBtnAddDestinos">
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
                                                            <div class="col-xs-12 col-md-5" style="display: none;" id="divCboPersonal">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <select class="form-control" id="cmbPersonal" name="cmbPersonal">
                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-primary" id="btnAgregarPer" data-toggle="tooltip" data-placement="right" title="Agregar Destinatario"><i class="fa fa-plus"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row" style="display: none;" id="divBtnClearAll">
                                                            <div class="col-xs-12 col-md-2">
                                                                <button type="button" class="btn red-sunglo btn-sm" id="btnLimpiar"><i class="fa fa-trash"></i>&nbsp;&nbsp;Limpiar Tabla</button>
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
                                                    </div>
                                                    
                                                    <div id="divCopias" style="display:block">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered"><tr style="background-color: #337ab7;color:white;font-weight: bold "><td>5. DESTINATARIOS COPIAS</td></tr></table>
                                                            </div>
                                                        </div>   
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-5">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <select class="form-control" id="cmbNombre2" name="cmbNombre2">
                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-primary" id="btnAgregar2" data-toggle="tooltip" data-placement="right" title="Agregar Destinatario Copia"><i class="fa fa-plus"></i></button>
                                                                        </span>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <table id="tbl_sis_copias" class="table table-condensed table-bordered  table-sm">
                                                                        <thead style="background-color:#fafafa;color:black">
                                                                            <tr role="row">
                                                                                <th class="all" style="text-align: left;width: 45%">DESTINATARIO COPIA</th>
                                                                                <th class="all" style="text-align: left;width: 45%">FOLIOS</th>
                                                                                <th class="all" style="text-align: center;width: 10%">ELIMINAR</th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                    <div class="form-actions right">
                                                        <div class="col-md-4 col-md-offset-8" style='margin-top:15px;'>
                                                            <button  id="btnGuardar" class="btn btn-primary btn-block" >Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="tab-pane" id="tab_5_2">
                                        <br>
                                        <div class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                                                <div class="form-group">
                                                    &nbsp;&nbsp;
                                                    <span   style="font-size: 25px;" > <span > <i  style="color: #ed5565;" class="fa fa-file-text-o"></i> </span> &nbsp;NO RECEPCIONADO</span> &nbsp;
                                                    <span  style="font-size: 25px;" ><i style="color: #f8ac59;" class="fa fa-file-text-o"></i>&nbsp;EN PROCESO </span> &nbsp;
                                                    <span  style="font-size: 25px;" ><i style="color: #1c84c6;" class="fa fa-file-text-o"></i>&nbsp;RECEPCIONADO </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class ='col-md-12'>
                                                <div class="col-md-3">
													<label>TIPO DOCUMENTO</label>
                                                    <select class="form-control" id="selMisDoc">
                                                        <option value='T'>TODOS</option>
                                                        <?php
                                                        foreach ($tipo_doc as &$item){
                                                        ?>
                                                            <option  value="<?php echo $item["IDTIPODOCUMENTO"]; ?>"><?php echo $item["NOMBREDOCUMENTO"]; ?></option>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </select>
												</div>
                                                <div class="col-md-3">
													<label>FECHA INICIO</label>
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar" aria-hidden="true"></i>
														</span>
														<input type="text" class="form-control" id="MISDOC-INI" readonly>
													</div>
												</div>
												<div class="col-md-3">
													<label>FECHA FIN</label>
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar" aria-hidden="true"></i>
														</span>
														<input type="text" class="form-control" id="MISDOC-FIN" readonly>
													</div>
                                                </div>
                                                <div class="col-md-3">
													<label>ESTADO</label>
													<select class="form-control" id="selEstaMisDoc">
                                                        <option value='T'>TODOS</option>
                                                        <option value='R'>RECEPCIONADO</option>
                                                        <option value='EP'>EN PROCESO</option>
                                                        <option value='NR'>NO RECEPCIONADO</option>
                                                    </select>
												</div>
											</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style='margin-top:15px;'>
                                                <div class="form-group">
                                                    <table id="tbl_docint_creados" class="table table-condensed table-bordered  table-sm">
                                                        <thead style="background-color:#fafafa;color:black">
                                                            <tr role="row">
                                                                <th class="all" style="text-align: left;width: 15%">DOCUMENTO</th>
                                                                <th class="all" style="text-align: left;width: 35%">ASUNTO</th>
                                                                <th class="all" style="text-align: left;width: 25%">F. EMISIÓN</th>
                                                                <th class="all" style="text-align: left;width: 25%">F. MAX. ATENCIÓN</th>
                                                                <th class="all" style="text-align: left;width: 25%">ESTADO</th>
                                                                <th class="all" style="text-align: left;width: 25%">OPCIONES</th>
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

<div id="modal_refs" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> REFERENCIAR DOCUMENTOS </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-md-5">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" name="txtBuscarRef" id="txtBuscarRef" placeholder="N° Documento" style="color: blue;font-weight: bold;"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="btnBuscarRefe"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-success" style="display:none;" id="msgExito">
                    <strong>Exito!</strong> Se agrego la referencia. </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <table id="tbl_search_refs" class="table table-condensed table-bordered  table-sm">
                                <thead style="background-color:#fafafa;color:black">
                                    <tr role="row">
                                        <th class="all" style="text-align: left;width: 15%">TIPO DOC.</th>
                                        <th class="all" style="text-align: left;width: 30%">DEPENDENCIA</th>
                                        <th class="all" style="text-align: left;width: 10%">FOLIOS</th> 
                                        <th class="all" style="text-align: left;width: 5%"></th>   
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<div id="modalArchivos" class="modal">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> ARCHIVOS ADJUNTOS</h4>
            </div>
            <div class="modal-body">
                <div class="tabbable-line">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tbl_docint_adjuntos" class="table table-condensed table-bordered  table-sm">
                                <thead style="background-color:#fafafa;color:black">
                                            <tr role="row">
                                                <th class="all" style="text-align: left;width: 50%">ITEM</th>
                                                <th class="all" style="text-align: left;width: 50%">ENLACE </th>
                                            </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div id="modalArchivosRefe" class="modal">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> ARCHIVOS ADJUNTOS( DOCUMENTO REFERENCIADO)</h4>
            </div>
            <div class="modal-body">
                <div class="tabbable-line">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tbl_docint_adjuntos_refe" class="table table-condensed table-bordered  table-sm">
                                <thead style="background-color:#fafafa;color:black">
                                    <tr role="row">
                                        <th class="all" style="text-align: left;width: 50%">ITEM</th>
                                        <th class="all" style="text-align: left;width: 50%">ENLACE </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="cerrarArchiDocRef" aria-hidden="true">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_refsInfo" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> REFERENCIAS DE DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <h3>Lista Referencias de <span id="sp_doc_ref" style="color: #3F51B5;font-weight: bold"></span></h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <table id="tbl_referencias" class="table table-condensed table-bordered  table-sm">
                                <thead style="background-color:#fafafa;color:black">
                                    <tr role="row">
                                        <th class="all" style="text-align: left;width: 15%">TIPO DOC.</th>
                                        <th class="all" style="text-align: left;width: 30%">DEPENDENCIA</th>
                                        <th class="all" style="text-align: left;width: 30%">ARCHIVO</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer center">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL PARA EL CARGO    -->
<div id="modal_archi_cargo" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> DOCUMENTACIÓN DE CARGO </h4>
            </div>
            <div class="modal-body">
                <h4>RELACION DE ENVIOS  <span id="" style="color: #3F51B5;font-weight: bold"></span></h4>
                <div class="row">
                     <div class="col-xs-12 col-md-12">
                        <table id="tbl_archi_cargo" class="table table-condensed table-bordered  table-sm">
                            <thead style="background-color:#fafafa;color:black">
                                <tr role="row">
                                    <th class="all" style="text-align: left;width: 10%" ></th>
                                    <th class="all" style="text-align: left;width: 40%">AREA</th>
                                    <th class="all" style="text-align: left;width: 20%">ESTADO</th>
                                    <th class="all" style="text-align: left;width: 30%">CARGO</th>
                                </tr>
                            </thead>
                        </table>   
                    </div>
                </div>  
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger " data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA LAS REFERENCIAS -->

<div id="modal_refs" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> Lista Referencias de <span id="sp_doc_ref" style="color: #ff6961;font-weight: bold"></span></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <table id="tbl_referencias" class="table table-condensed table-bordered  table-sm">
                                <thead style="background-color:#fafafa;color:black">
                                    <tr role="row">
                                        <th class="all" style="text-align: left;width: 30%">DOCUMENTO</th>
                                        <th class="all" style="text-align: left;width: 30%">ASUNTO</th>
                                        <th class="all" style="text-align: left;width: 30%">DEPENDENCIA</th>
                                        <th class="all" style="text-align: left;width: 30%">ARCHIVO</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn  btn-danger" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>frontend/plugins/dropzoneform/form-dropzone.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/jquery.numeric.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/loadingoverlay.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/jquery-validation/js/messages_es_PE.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/FixedHeader-3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/jsCrearDocInt.js?v=<?php echo(rand()); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {

        INIT.init();


    });
</script> 