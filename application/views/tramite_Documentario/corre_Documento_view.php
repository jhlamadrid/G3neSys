<link href="<?php echo $this->config->item('ip'); ?>/frontend/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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

    .select2-container {
        width: 100% !important;
        padding: 0;
    }

    .modal-header{
        background-color: #2F71AB;
        color:#fff;
    }
    .modal-footer{
        background-color: #2F71AB;
        color:#fff;
    }
</style>

<section class="content">
    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">CORREGIR DOCUMENTOS </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class ='col-md-12'>
                            <div class="panel panel-danger">
                                <div class="panel-heading"> Buscar Documento </div>
                                <div class="panel-body"> 

                                    <form class="row" id="frmBuscar">
                                        <section id="section_si1">
                                            <div class="col-lg-3 col-md-5">
                                                <div class="form-group">
                                                    <label>Número Documento</label>
                                                    <input class="form-control search-item si1" placeholder="1099 (Ejemplo)"   style="color: blue;font-weight: bold"  id="txt_nroDocumento" name="txt_nroDocumento" type="text" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Año</label>
                                                    <div class="input-group">
                                                        <select class="form-control" style="width:100%;" data-name="anios" id="cbo_comboAnio">
                                                        </select>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-primary" id="btnFiltrar" metodo="recibir"><i class="fa fa-search"></i></button>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class ='col-lg-4 col-md-4'>
                                                <button type="button" style ="margin-top:23px;"  class="btn btn-primary" id="btnNuevaBusqueda" metodo="recibir" disabled><i class="fa fa-retweet"> Nueva Busqueda</i></button>
                                            </div>
                                        </section>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class ='col-md-12'>
                            <div class='col-md-12' style="display: none;" id="divCorreccion">
                               
                                <div class="note note-warning"  >
                                    <h1 class="block"><i style='color:#ff6961' class="fa fa-file-text-o"></i>&nbsp;&nbsp;
                                        <span id="spTipoDoc" style="font-weight:bold"> - </span>&nbsp;
                                        <span id="spNumDoc" style="color:#da2934;font-weight: bold">-</span>
                                        <span id="spDescriDoc" style="font-weight: bold">-</span>
                                    </h1>
                                </div>
                                <div class="row" style='margin-top:15px;' >
                                    <ul class="nav nav-tabs ">
                                        <li class="active">
                                            <a href="#tab_5_1" data-toggle="tab"> Documento </a>
                                        </li>
                                        <li>
                                            <a href="#tab_5_2" data-toggle="tab"> Folios </a>
                                        </li>
                                        <li >
                                            <a href="#tab_5_3" data-toggle="tab"> Destinatario </a>
                                        </li>
                                        <li>
                                            <a href="#tab_5_4" data-toggle="tab"> Referencias </a>
                                        </li>
                                        <!--
                                        <li>
                                            <a href="#tab_5_5" data-toggle="tab"> Resolver </a>
                                        </li> -->
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_5_1">
                                            <div class ='row' style='margin:10px;'>
                                                <div class='col-md-12' style='margin-top:15px;'>
                                                    <div class="row" >
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">ASUNTO DOCUMENTO</label>
                                                                <input class="form-control" name="txtAsuntoDoc" id="txtAsuntoDoc" style="color: blue;font-size: 14px;font-weight: bold;"/>
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
                                                                <input class="form-control" name="txtObservaciones" id='txtObservaciones' placeholder="Observaciones" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">CONTENIDO</label>
                                                                <textarea  class="form-control" name="txtContenido" rows="3" id='txtContenido' placeholder="Pegue aqui contenido documento"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">FOLIOS DOCUMENTO</label>
                                                                <input class="form-control" name="txtFolioDoc" id="txtFolioDoc" style="color: blue;font-size: 20px;font-weight: bold;"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label"> ARCHIVO(S) ADJUNTADO(S)</label>
                                                                <button  class="btn btn-block btn-primary"  cod_doc="" id="btnArchAdjunto"><i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div action="SubirArchivos/SubidaSingular"  name="userfile"  class="dropzone dropzone-file-area" id="my-dropzone" style="width: 100%;">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='row'style ="margin-top:20px;">
                                                        <div class ='col-md-4 col-md-offset-8'>
                                                            <button type="submit" class="btn btn-block btn-primary"  cod_doc="" id="btnUpdFolios">GUARDAR</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_5_2">
                                            <br>
                                            <div class="row" style='margin:10px;'>

                                                <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                                                    <div class="form-group">
                                                        &nbsp;&nbsp;
                                                        <span style="font-size: 30px;"><i style="color: #4caf50;" class="fa fa-file"></i>&nbsp;COPIA</span> &nbsp;
                                                        <span style="font-size: 30px;"><i style="color: #e41d20;" class="fa fa-file"></i>&nbsp;RESUELTO</span> 
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row" style='margin:10px;'>
                                                <div class="col-xs-12 col-md-5">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input class="form-control" id="txtFoTT" name="txtFoTT" placeholder="Folios Totales" style="color: blue;font-size: 20px;font-weight: bold;" />
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-primary" id="btnSaveFoTT" data-toggle="tooltip" data-placement="right" title="Actualiza Folios Totales"><i class="fa fa-refresh"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style='margin:10px;'>

                                                <div class="col-md-12 ">
                                                    <table id="tbl_folios" class="table table-condensed table-bordered  table-sm table-hover">
                                                        <thead style="background-color:#fafafa;color:black">
                                                            <tr >
                                                                <th  style="text-align: center;width: 2%;"></th>
                                                                <th  style="text-align: left;width: 40%"> DOCUMENTO</th>
                                                                <th  style="text-align: left;width: 40%"> FOLIOS</th>
                                                                <th  style="text-align: left;width: 40%"> DESTINO</th>
                                                                <th  style="text-align: left;width: 40%"> ACCION</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <br><br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_5_3">
                                            <br>
                                            <h3 style="color:#337ab7; margin:10px; font-weight: bold">DESTINATARIOS</h3>
                                            <div class="row" style='margin:10px;'>
                                                <div class="col-xs-12 col-md-5" id="divAddDestinoCorreccion" style="display:block">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select class="form-control" id="cmbNombre" name="cmbNombre">
                                                            </select>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-primary" id="btnAgregar" derivado="0" data-toggle="tooltip" data-placement="right" title="Agregar Destinatario"><i class="fa fa-plus"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style='margin:10px;'>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <table id="tbl_sis_destinatarios" class="table table-condensed table-bordered  table-sm table-hover">
                                                            <thead style="background-color:#fafafa;color:black">
                                                                <tr role="row">
                                                                    <th class="all" style="text-align: left;width: 35%">DESTINATARIO</th>
                                                                    <th class="all" style="text-align: center;width: 10%">ACCION</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='Ing_exter_doc'>
                                                <h3 style="color:#337ab7; margin:10px; font-weight: bold">DESTINATARIOS (COPIAS)</h3>
                                                <div class="row" style='margin:10px;'>
                                                    <div class="col-xs-12 col-md-5">
                                                        <div class="form-group">
                                                            <select class="form-control" id="cmbNombre2" name="cmbNombre2">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-3">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input class="form-control" id="txtCantFoliosCC" placeholder="Folios copias" name="txtCantFoliosCC" style="color: blue;font-size: 20px;font-weight: bold;"/>
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-primary" id="btnAgregar2" derivado="0" data-toggle="tooltip" data-placement="right" title="Agregar Destinatario Copia"><i class="fa fa-plus"></i></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row" style='margin:10px;'>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <table id="tbl_sis_destinatarios_cc" class="table table-condensed table-bordered  table-sm table-hover">
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
                                               
                                        </div>
                                        <div class="tab-pane" id="tab_5_4">
                                            <br>
                                            <div class="row" style='margin:10px;'>
                                                <div class="col-xs-12 col-md-2">
                                                    <button type="button" class="btn btn-success" id="btnBuscarRefs" expediente="0"><i class="fa fa-search"></i>&nbsp;&nbsp;BUSCAR REFERENCIA</button>
                                                </div>
                                            </div>
                                            <div class="row" style='margin:10px;'>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <table id="tbl_refs" class="table table-condensed table-bordered  table-sm">
                                                            <thead style="background-color:#fafafa;color:black">
                                                                <tr role="row">
                                                                    <th class="all" style="text-align: left;width: 15%">DOCUMENTO</th>
                                                                    <th class="all" style="text-align: left;width: 15%">FECHA</th>                                            
                                                                    <th class="all" style="text-align: left;width: 30%">DEPENDENCIA</th>
                                                                    <th class="all" style="text-align: left;width: 30%">ESTADO</th>
                                                                    <th class="all" style="text-align: center;width: 10%">ELIMINAR</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <div class=" col-md-2 col-md-offset-9">
                                                    <button type="button" class="btn btn-primary" id="btnGuardarEstRef" style="margin:10px;" expediente="0"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;GUARDAR ESTADO DE REFERENCIA(S)</button>
                                                </div>
                                            </div>  
                                        </div>
                                        <!--
                                        <div class="tab-pane" id="tab_5_5">
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-3" >
                                                    <div class="md-checkbox-inline">
                                                        <div class="md-checkbox has-error">
                                                            <input type="checkbox" id="chkResuelto" class="md-check">
                                                            <label for="chkResuelto" style="font-weight:bold !important">
                                                                <span class="inc"></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> Resolver Documentos. </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <table id="tbl_docsResueltos" class="table table-condensed table-bordered  table-sm">
                                                            <thead style="background-color:#fafafa;color:black">
                                                                <tr role="row">
                                                                    <th style="text-align: left;width: 5%"></th>
                                                                    <th class="all" style="text-align: left;width: 20%">TIPO DOC.</th>
                                                                    <th class="all" style="text-align: left;width: 45%">DOCUMENTO</th>                                            
                                                                    <th class="all" style="text-align: left;width: 30%">DEPENDENCIA</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                        -->
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
<div id="modal_busqueda" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> DOCUMENTOS CON LA NUMERACIÓN </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                        <div class="form-group">
                            <div class="input-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                                <input type="text" class="form-control" id="txt_buscar"  placeholder="Filtrar aquí" style="  color:#0072c6;font-weight: bold;text-transform: uppercase">
                                <span class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 ">
                        <table id="tbl_busqueda" class="table table-condensed table-bordered  table-sm table-hover" style="width: 100%">
                            <thead style="background-color: #337ab7;color:white;font-weight: bold ">
                                <tr >

                                    <td  style="text-align: left;width: 18%;">TIPO DOCUMENTO</td>
                                    <td  style="text-align: left;width: 40%;"> DOCUMENTO</td>
                                    <td  style="text-align: center;width: 2%;"></td>
                                </tr>
                            </thead>
                        </table>
                        <br><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger " data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div id="modalEditFolios" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> FOLIOS TOTALES DE ENVIO </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-12 col-md-12">
                        <div class="form-group">
                            <label class="control-label"> FOLIOS TOTALES </label>
                            <input class="form-control" name="txtFolioT" id="txtFolioT" style="color: blue;font-size: 20px;font-weight: bold;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger " data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary" id="btnEditFolio" cod_mov="">GUARDAR</button>
            </div>
        </div>
    </div>
</div>


<div id="modal_confirm_del_mov" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> CONFIRMACIÓN </h4>
            </div>
            <div class="modal-body">
                <br>
                <div class="row" style="text-align: center">
                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 col-sm-12" >
                        <i style="font-size: 60px;color: #607D8B" class="fa fa-question-circle"></i> 
                    </div>
                </div><br>
                <div class="row" style="text-align: center">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <span style="font-size: 20px;" id="spPregunta"></span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <table class="table table-striped">  
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 18px;color: #3F51B5;font-weight: bold;"><span id="sp_mov"></span> </td>
                                </tr>  
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDelMov" cod_mov="">CONFIRMAR</button>
            </div>

        </div>
    </div>
</div>




<div id="modal_confirm_del_ref" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> CONFIRMACIÓN </h4>
            </div>
            <div class="modal-body">
                <br>
                <div class="row" style="text-align: center">
                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 col-sm-12" >
                        <i style="font-size: 60px;color: #607D8B" class="fa fa-question-circle"></i> 
                    </div>
                </div><br>
                <div class="row" style="text-align: center">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <span style="font-size: 20px;">¿Está seguro que deseas eliminar la referencia?</span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <table class="table table-striped">  
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 18px;color: #3F51B5;font-weight: bold;"><span id="sp_doc"></span> </td>
                                </tr>  
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDelRef" cod_mov="">CONFIRMAR</button>
            </div>

        </div>
    </div>
</div>
<div id="modal_confirm_add_ref" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> CONFIRMACIÓN </h4>
            </div>
            <div class="modal-body">
                <br>
                <div class="row" style="text-align: center">
                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 col-sm-12" >
                        <i style="font-size: 60px;color: #607D8B" class="fa fa-question-circle"></i> 
                    </div>
                </div><br>
                <div class="row" style="text-align: center">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <span style="font-size: 20px;">¿Está seguro que deseas agregar la referencia?</span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <table class="table table-striped">  
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 18px;color: #3F51B5;font-weight: bold;"><span id="sp_docRefAdd"></span> </td>
                                </tr>  
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary" id="btnConfirmAddRef" cod_mov="" cod_doc="">CONFIRMAR</button>
            </div>

        </div>
    </div>
</div>

<div id="modal_refs" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> AGREGAR REFERENCIA</h4>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <table id="tbl_search_refs" class="table table-condensed table-bordered  table-sm">
                                <thead style="background-color:#fafafa;color:black">
                                    <tr role="row">
                                        <th class="all" style="text-align: left;width: 30%">DOCUMENTO</th>
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
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">CERRAR</button>
            </div>

        </div>
    </div>
</div>


<div id="modal_editDestino" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" > <i class="fa fa-cubes" aria-hidden="true"></i> Actualizar Destino de <span id="sp_doc_dev" style="color: #ff6961; font-weight: bold"></span></h4>
            </div>
            <div class="modal-body">
                
				<div class="row">
                    <!--
					<div class="col-xs-12 col-md-12" id="divEntExt" style="margin-bottom: 1%;margin-top:2%;">
                        <div class="md-checkbox-inline">
                            <div class="md-checkbox has-error">
                                <input type="checkbox" id="chkEntExt" class="md-check">
                                <label for="chkEntExt" style="font-weight:bold !important">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Destino Entidad Externa </label>
                            </div>
                        </div>
                    </div> -->
				</div>
                <div class="row">
                    <div class="col-xs-12 col-md-7" id="divInputDestino" style="display:block;">
                        <div class="form-group">           
                            <select style="width: 100%" class="form-control" id="cmbPersonalA" name="cmbPersonalA">
                            </select>
                        </div>
                    </div>
                </div>  
				<div class="row">
                     
                            
                              <div class="col-xs-12 col-md-9 col-lg-9" id="divInputEntExt" style="display:none;">
                                <div class="form-group">
                                   
                                       <input id="txtEntidadExterna" style="color:#3F51B5;font-weight: bold;text-transform: uppercase" class="form-control" placeholder="Ingresa aquí nombre Entidad Externa">
                                       
                                </div>
                            </div>
                            
                </div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id="btnUpdDestino" cod_mov="" indExterno="0" indMovExterno="0">ACTUALIZAR</button>
            </div>
        </div>
    </div>
</div>


<div id="modal_info_resolver" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <br>
                <div class="row" style="text-align: center">
                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 col-sm-12" >
                        <i style="font-size: 60px;color: #607D8B" class="fa fa-question-circle"></i> 
                    </div>
                </div><br>
                <div class="row" style="text-align: center">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <span style="font-size: 20px;" id="spPreguntaResuelto">¿Está seguro que deseas resolver el documento y todas sus referencias?</span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <table class="table table-striped">  
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 22px;color: #3F51B5;font-weight: bold;"><span id="sp_doc_resolver"></span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer center">
                <button type="button" class="btn " data-dismiss="modal" id="btnCancelarResolver">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmResolver"  accion="resolver" cod_doc="">Resolver</button>
            </div>

        </div>
    </div>
</div>

<!--  MODAL PARA MOSTRAR EL ARCHIVO  -->

<div id="modalArchiAdjuntado" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false"   role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> ARCHIVO(S) ADJUNTADO(S)</h4>
            </div>
            <div class="modal-body">
                <table id="tbl_docint_adjuntos" class="table table-condensed table-bordered  table-sm">
                    <thead style="background-color:#fafafa;color:black">
                        <tr role="row">
                            <th class="all" style="text-align: left;width: 50%">ITEM</th>
                            <th class="all" style="text-align: left;width: 50%">ENLACE </th>
                            <th class="all" style="text-align: left;width: 50%">OPERACIÓN </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>




<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>frontend/plugins/dropzoneform/form_corre_dropzone.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/loadingoverlay.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/jquery-validation/js/messages_es_PE.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script  type="text/javascript"  src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/jsCorrecionDoc.js"></script>
<script type="text/javascript">


    $(document).ready(function () {
        INIT.init();
    });

</script>