<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.dataTables.min.css">
<style type="text/css">
    .portlet.blue, .portlet.box.blue>.portlet-title, .portlet>.portlet-body.blue {
    /*background-color: #337AB7;*/
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

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
    .btn-circle.btn-lg {
        width: 50px;
        height: 50px;
        padding: 10px 16px;
        font-size: 18px;
        line-height: 1.33;
        border-radius: 25px;
    }
</style>

<section class="content">
    <div class="row font-text">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">CONSULTAR DOCUMENTOS </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="tabbable-line">
                                <ul class="nav nav-tabs  " id="tab_consultar">
                                    <li class="active">
                                        <a href="#tab_15_3_1" data-toggle="tab"><B>TIPOS DE DOCUMENTO</B>  </a>
                                    </li>  
                                    <li>
                                        <a href="#tab_15_4_1" data-toggle="tab"><B>PERSONA</B> </a>
                                    </li>  
                                    
                                </ul>
                                
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_15_3_1">

                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <!--         BEGIN Portlet PORTLET-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <br>
                                                        <div class ='col-md-12'>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <div class="panel panel-primary"> 
                                                                        <div class="panel-heading">
                                                                            FILTROS   
                                                                        </div>
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div id="col-md-12" style ='margin:5px;'>
                                                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" >
                                                                                        <div class="form-group">
                                                                                            <label>Tipo de Documento</label>
                                                                                            <select class="form-control select2" style="width:100%;" id="cbo_tipos_documentos" name="cbo_tipos_documentos" >
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="height: 58px;">                                  
                                                                                            <label>Número</label>
                                                                                            <input type="number" min="1" class="form-control" placeholder="N°" id="txt_numero" name="txt_numero"/>
                                                    
                                                                                    </div>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                                        <div class="form-group">
                                                                                            <label>Año</label>
                                                                                            <select class="form-control select2" style="width:100%;" id="cbo_anio" data-name="cbo_anio">
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                                        <div class="form-group">
                                                                                            <label style="color: #FFFFFF">Consultar</label><br>
                                                                                            <button type="submit"  class="btn btn-primary" id="btnBuscarTipoDocumento"> <i class="fa fa-search"></i> CONSULTAR </button> 
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class ='col-md-12'>
                                                            <div class="row" style='margin-top:20px;'>
                                                                <div class="col-md-12"  id="lista_documentos">
                                                                    <!--         BEGIN Portlet PORTLET-->
                                                                    <div class="portlet box box-primary">
                                                                        <div class="portlet-title">
                                                                            <div class="caption font-white">
                                                                                <span style =' font-size:35px;'> <i style ="margin:10px;  color:#ff6961;" class="fa fa-file-text-o" aria-hidden="true"></i> DOCUMENTOS </span>      
                                                                            </div>
                                                                            <div class="tools"> </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <br>
                                                                            
                                                                            <div class='row'>
                                                                                <div  class='col-md-12'>
                                                                                    <table id="tbl_listar_documentos" class="display responsive table table-striped table-bordered dataTable">
                                                                                        <thead style="background-color: #9c9c9c;color:white;font-weight: bold ">
                                                                                            <tr role="row">
                                                                                                <th class="all" style="text-align: left;width: 15%">DOCUMENTO</th>
                                                                                                <th class="all" style="text-align: left;width: 15%">ASUNTO</th>
                                                                                                <th class="none" style="text-align: center;width: 10%">OBSERVACIONES</th>
                                                                                                <th class="none" style="text-align: center;width: 5%">FECHA</th>
                                                                                                <th class="all" style="text-align: center;width: 5%">FOLIOS</th>
                                                                                                <th class="all" style="text-align: center;width: 10%">ACCIONES</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="txt_idUsu" >
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12"  id="lista_movimientos">
                                                                    <!--         BEGIN Portlet PORTLET-->
                                                                    <div class="portlet box box-primary">
                                                                        <div class="portlet-title">
                                                                            <div class="caption font-white">
                                                                                <span style =' font-size:35px;'> <i style ="margin:10px;  color:#ff6961;" class="fa fa-exchange" aria-hidden="true"></i> MOVIMIENTOS </span>      
                                                                            </div>
                                                                            <div class="tools"> </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <br>
                                                                            <div class="row ">
                                                                                <div class="col-xs-12 table-responsive">
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                            <tr> <th class="invoice-title  ">
                                                                                                    <i style='color:#1c84c6' class="fa fa-file-text-o"></i> Recibido 
                                                                                                    <i style='color:#ed5565' class="fa fa-file-text-o"></i> Sin Recibir
                                                                                                    <i style='color:#1ab394'  class="fa fa-file-text-o"></i> Copia
                                                                                                </th>
                                                                                                <th class="invoice-title uppercase text-right"></th>

                                                                                            </tr>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12" >
                                                                                    <table id="tbl_ver_movimientos_por_documento" class="table responsive table-bordered table-hover" style="width: 100%">
                                                                                        <thead style="background-color: #9c9c9c;color:white;font-weight: bold ">
                                                                                            <tr role="row">
                                                                                                <th class="all"></th>
                                                                                                <th class="all">Documento</th>
                                                                                                <th class="all">Folios</th>
                                                                                                <th class="all">Emisor</th>
                                                                                                <th class="all">Receptor</th>
                                                                                                <th class="all">Estado</th>
                                                                                                <th class="all">Opciones</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row ">
                                                                                <input id="hddPosTablaPrincipal" type="hidden">
                                                                                <input id="hddPosTablaMultiple" type="hidden">
                                                                                <input id="hddNroTramitePrincipal" type="hidden">
                                                                                <input id="hddidDocumento" type="hidden">
                                                                                <input id="hddNumero" type="hidden">
                                                                                <input id="hddAnio" type="hidden">
                                                                            </div>

                                                                        </div>
                                                                        <input type="hidden" id="txt_idUsu" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="txt_idUsu" >
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_15_4_1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row" style ='margin-top:18px;'>
                                                    <div class="col-md-12">
                                                        <div class='col-md-12'>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <div class="panel panel-primary"> 
                                                                        <div class="panel-heading">
                                                                            FILTROS   
                                                                        </div>
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                                                        <div class="form-group">
                                                                                            <label>Tipo de Documento</label>
                                                                                            <select class="form-control select2" style="width:100%;"  id="cbo_tipoDocumento_persona" name="cbo_tipoDocumento_persona">
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                                                        <div class="form-group">
                                                                                            <label>Dependencia</label>
                                                                                            <select class="form-control" id="cbo_dependencia_persona" name="cbo_dependencia_persona" style="width: 100%;">
                                                                                                <option value="">Seleccione una dependencia</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                                                        <div class="form-group">
                                                                                            <label>Persona</label>
                                                                                            <select class="form-control" id="cbo_trabajador_persona" name="cbo_trabajador_persona">
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-1 col-md-4 col-sm-3 col-xs-12">
                                                                                        <div class="form-group">
                                                                                            <label>Año</label>
                                                                                            <select class="form-control" style="width:100%;" id="cbo_anio_persona" name="cbo_anio_persona">
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                                        <div class="form-group">
                                                                                            <label style="color: #FFFFFF">Consultar</label><br>
                                                                                            <button   class="btn btn-primary" id="btnBuscar_persona"> <i class="fa fa-search"></i> CONSULTAR </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        

                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <div  style='margin-top:20px;'>
                                                                    <div class="col-md-12"  id="table_container">
                                                                        <div class="portlet box box-primary">
                                                                            <div class="portlet-title">
                                                                                <div class="caption font-white">
                                                                                    <span style =' font-size:35px;'> <i style ="margin:10px;  color:#ff6961;" class="fa fa-file-text-o" aria-hidden="true"></i> DOCUMENTOS DE PERSONA </span>      
                                                                                </div>
                                                                                <div class="tools"> </div>
                                                                            </div>
                                                                            <div class="portlet-body">
                                                                                <br>
                                                                                <div class='row'>
                                                                                    <div class="col-md-12" >
                                                                                        <table id="table_documentos" class="display responsive table table-striped table-bordered dataTable">
                                                                                            <thead style="background-color: #9c9c9c;color:white;font-weight: bold ">
                                                                                                <tr role="row">
                                                                                                    <th class="all" style="text-align: center;width: 20%">DOCUMENTO</th>
                                                                                                    <th class="min-tablet-l" style="text-align: center;width: 40%">ASUNTO</th>
                                                                                                    <th class="all" style="text-align: center;width: 5%">FOLIOS</th>
                                                                                                    <th class="all" style="text-align: center;width: 5%">ACCIONES</th>
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

                                                        <div class="col-md-12">
                                                                <div id="lista_movimientos_persona">
                                                                    <!--         BEGIN Portlet PORTLET-->
                                                                    <div class="portlet box box-primary">
                                                                        <div class="portlet-title">
                                                                            <div class="caption font-white">
                                                                                <span style =' font-size:35px;'> <i style ="margin:10px;  color:#ff6961;" class="fa fa-exchange" aria-hidden="true"></i> MOVIMIENTOS DE DOCUMENTO </span>      
                                                                            </div>
                                                                            <div class="tools"> </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <br>
                                                                        
                                                                            <div class="row ">
                                                                                <div class="col-xs-12 table-responsive">
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                            <tr> <th class="invoice-title  ">
                                                                                                    <i style='color:#1c84c6' class="fa fa-file-text-o"></i> Recibido 
                                                                                                    <i style='color:#ed5565' class="fa fa-file-text-o"></i> Sin Recibir
                                                                                                    <i style='color:#1ab394'  class="fa fa-file-text-o"></i> Copia
                                                                                                </th>
                                                                                                <th class="invoice-title uppercase text-right"></th>

                                                                                            </tr>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12" >
                                                                                    <table id="tbl_ver_movimientos_por_documento_persona" class="table table-striped table-bordered table-hover dt-responsive">
                                                                                        <thead  style="background-color: #9c9c9c; color:white; font-weight: bold ">
                                                                                            <tr role="row">
                                                                                                <th class="all"></th>
                                                                                                <th>Documento</th>
                                                                                                <th>Folios</th>
                                                                                                <th>Emisor</th>
                                                                                                <th>Receptor</th>
                                                                                                <th>Estado</th>
                                                                                                <th>Opciones</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row ">
                                                                                <input id="hddPosTablaPrincipal_per" type="hidden">
                                                                                <input id="hddPosTablaMultiple_per" type="hidden">
                                                                                <input id="hddNroTramitePrincipal_per" type="hidden">
                                                                                <input id="hddidDocumento_per" type="hidden">
                                                                                <input id="hddNumero_per" type="hidden">
                                                                                <input id="hddAnio_per" type="hidden">
                                                                            </div>

                                                                        </div>
                                                                        <input type="hidden" id="txt_idUsu" >
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
                </div>
            </div>
        </div>
    </div>
</section>

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


<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/moment.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/loadingoverlay.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.colVis.min.js" type="text/javascript"></script> 
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/jsConsultarDocumentos.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        CONSULTARDOCUMENTOS.init();
    });

</script>