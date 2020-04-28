
<link href="<?php echo $this->config->item('ip'); ?>/frontend/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.dataTables.min.css">
<style type="text/css">
    .portlet.blue, .portlet.box.blue>.portlet-title, .portlet>.portlet-body.blue {
    background-color: #337AB7;
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
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">REPORTE DOCUMENTOS </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <!--         BEGIN Portlet PORTLET-->
                            <div class="row">
                                
                                <div class="col-md-12 cuerpo_reporte ">
                                    <form class="row" id="frmBuscar">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style='font-size:20px'><b>Tipo de Reporte</b></label>
                                                <select class="form-control" id="cmbTipoBuscar">
                                                    <option value="1" selected>Documentos Creados</option>
                                                    <option value="2">Documentos Recibidos</option>
                                                    <option value="3">Documentos por Recibir</option>
                                                </select>
                                            </div>
                                        </div>
                                        <section class="section_basico">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h3 class="block"><b>Filtros</b></h3>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="btn-group">
                                                        <div id="reportrange" class="btn btn-default">
                                                            <i class="fa fa-calendar"></i> &nbsp;
                                                            <span> </span>
                                                            <b class="fa fa-angle-down"></b>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group" id="filter_documents">
                                                        <button type="button" class="btn btn-default">Documentos</button>
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu hold-on-click input-large dropdown-checkboxes" role="menu" style="height: 250px; overflow: auto;">
                                                            <span class="select2-search select2-search--dropdown">
                                                                <input class="filter-field form-control" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox">
                                                            </span>
                                                            <label>
                                                                <input type="checkbox" checked="" value="0"> TODOS </label>
                                                            <label>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group hide" id="filter_dependencias">
                                                        <button type="button" class="btn btn-default">Dependencia</button>
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu hold-on-click input-large dropdown-checkboxes" role="menu" style="height: 250px; overflow: auto;">
                                                            <span class="select2-search select2-search--dropdown">
                                                                <input class="filter-field form-control" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox">
                                                            </span>
                                                            <label>
                                                                <input type="checkbox" checked="" value="0"> TODAS </label>

                                                        </div>
                                                    </div>

                                                    <div class="btn-group">
                                                        <button type="button"  class="btn btn-primary btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </form>
                                    <br>
                                    <section class="section_basico">
                                        <div class="row" id="filter_settings">
                                            <div class="container-fluid">
                                                <div class="col-sm-12">
                                                    <div class="portlet light bordered">
                                                        <div class="portlet-title">
                                                            <div class="caption ">
                                                                <span  style='font-size:20px; font-weight: bold;' class="caption-subject font-dark bold uppercase">Descripción</span>
                                                                <span style='font-size:20px; font-weight: bold;' class="caption-helper">Filtros</span>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <span class="todo-tasklist-badge badge badge-roundless hide" style="margin-left: 5px;" id="parent-badge">Cualquiera</span>
                                                            <div id="settings_tiempo">
                                                                <span style='font-weight: bold;' class="todo-tasklist-date">
                                                                    <i   class="fa fa-filter"></i> Periodo: </span>
                                                                <span class="todo-tasklist-badge badge badge-roundless">Cualquiera</span>
                                                            </div>
                                                            <div id="settings_documentos">
                                                                <span style='font-weight: bold;' class="todo-tasklist-date">
                                                                    <i class="fa fa-filter"></i> Tipos Documentos: 
                                                                </span>
                                                                <span class="todo-tasklist-badge badge badge-roundless">TODOS</span>
                                                            </div>
                                                            <div id="settings_dependencias">
                                                                <span style='font-weight: bold;' class="todo-tasklist-date">
                                                                    <i class="fa fa-filter"></i> Dependencia: 
                                                                </span>
                                                                <span class="todo-tasklist-badge badge badge-roundless">TODAS</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="container-fluid">
                                                <div class="col-sm-12" style='margin-top:15px;'>
                                                    <div class="portlet light bordered">
                                                        <div class="portlet-title" style='color:#2F71AB; font-weight: bold; font-size:25px;'>
                                                            <div class="caption">
                                                                <span class="caption-subject bold uppercase" id="title-report">REPORTE GRAFICO</span>
                                                                <span class="caption-helper">DE CANTIDAD DE DOCUMENTOS</span>
                                                            </div>
                                                            <div class="actions">
                                                                <!--                                            <a href="#" class="btn btn-circle btn-default">
                                                                                                                <i class="fa fa-pencil"></i> Export </a>
                                                                                                            <a href="#" class="btn btn-circle btn-default">
                                                                                                                <i class="fa fa-print"></i> Print </a>
                                                                                                            <a class="btn btn-circle btn-icon-only btn-default" href="#">
                                                                                                                <i class="icon-wrench"></i>
                                                                                                            </a>
                                                                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#"> </a> -->
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body" >
                                                            <div id="dashboard_chart" style ='height: 450px;' class="CSSAnimationChart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row hide" id="data-table" style ='margin-top:15px;'>
                                            <div class="container-fluid">
                                                <div class="col-sm-12">
                                                    <div class="portlet light bordered">
                                                        <div class="portlet-title">
                                                            <div class="caption " style='color:#2F71AB; font-weight: bold; font-size:25px;'>
                                                                <span class="caption-subject font-dark bold uppercase" id="title-report">REPORTE DE RESULTADOS</span>
                                                                <span class="caption-helper">EN TABLA</span>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body " style ='margin-top:15px;'>
                                                            <table id="tbl_report_data" class="table table-condensed table-bordered  table-sm table-hover" >
                                                                <thead style="background-color: #337ab7;color:white;font-weight: bold ">
                                                                    <tr role="row">
                                                                        <th class="all" style="text-align: center;width: 30%">DOCUMENTO</th>
                                                                        <th class="min-tablet-l" style="text-align: center;width: 15%">ASUNTO</th>
                                                                        <th class="min-tablet-l" style="text-align: center;width: 25%">OBSERVACIONES</th>
                                                                        <th class="min-tablet-l" style="text-align: center;width: 15%">FECHA EMISIÓN</th>
                                                                        <th class="min-tablet-l" style="text-align: center;width: 15%">ESTADO</th>
                                                                        <th class="min-tablet-l" style="text-align: center;width: 15%">OPCIONES</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="section_avanzado fiscalizacion hide">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Dependencia</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbDependencia"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Inicio</label>
                                                    <input type="text" class="form-control  datepicker-control" id="txtFecIni" data-name="txtFecIni"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Fin</label>
                                                    <input type="text" class="form-control  datepicker-control" id="txtFecFin" data-name="txtFecFin"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3 margin-top-20">
                                                <div class="form-group margin-bottom-25">
                                                    <button type="button"  class="btn dark btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tbl_report_fiscalizacion" class="display responsive table table-striped table-bordered dataTable" style="width:100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 15%">PROCEDIMIENTO</th>
                                                            <th class="all" style="text-align: center;width: 10%">NUMERO</th>
                                                            <th class="all" style="text-align: center;width: 15%">AÑO</th>
                                                            <th class="all" style="text-align: center;width: 10%">SIGLA</th>
                                                            <th class="all" style="text-align: center;width: 10%">PARTE</th>
                                                            <th class="all" style="text-align: center;width: 10%">FECHA</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="section_avanzado Expefechas hide">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Dependencia</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbDependenciaFecha"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Inicio</label>
                                                    <input type="text" class="form-control  datepicker-control" id="txtFecIniFecha" data-name="txtFecIniFecha"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Fin</label>
                                                    <input type="text" class="form-control  datepicker-control" id="txtFecFinFecha" data-name="txtFecFinFecha"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3 margin-top-20">
                                                <div class="form-group margin-bottom-25">
                                                    <button type="button"  class="btn dark btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tbl_report_Fecha" class="display responsive table table-striped table-bordered dataTable" style="width:100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 15%">PROCEDIMIENTO</th>
                                                            <th class="all" style="text-align: center;width: 10%">NUMERO</th>
                                                            <th class="all" style="text-align: center;width: 15%">AÑO</th>
                                                            <th class="all" style="text-align: center;width: 10%">SIGLA</th>
                                                            <th class="all" style="text-align: center;width: 10%">PARTE</th>
                                                            <th class="all" style="text-align: center;width: 10%">FECHA</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="section_avanzado silencio hide">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" id="ckAutomatico" name="ckAutomatico" value="8"> Automatico
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" id="ckNegativa" name="ckNegativa" value="8"> Eval. Negativa
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" id="ckPositiva" name="ckPositiva" value="8"> Eval. Positva
                                                    </label>
                                                </div>
                                            </div> 
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Inicio</label>
                                                    <input type="text" class="form-control datepicker-control" id="txtFecIniS" data-name="txtFecIniS"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Fin</label>
                                                    <input type="text" class="form-control datepicker-control" id="txtFecFinS" data-name="txtFecFinS"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3 margin-top-20">
                                                <div class="form-group margin-bottom-25">
                                                    <button type="button"  class="btn dark btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tbl_report_silencio" class="display responsive table table-striped table-bordered dataTable" style="width:100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 5%">NUMERO</th>
                                                            <th class="all" style="text-align: center;width: 5%">AÑO</th>
                                                            <th class="all" style="text-align: center;width: 5%">SIGLA</th>
                                                            <th class="all" style="text-align: center;width: 5%">PARTE</th>
                                                            <th class="all" style="text-align: center;width: 5%">FECHA</th>
                                                            <th class="all" style="text-align: center;width: 20%">PROCEDIMIENTO</th>
                                                            <th class="all" style="text-align: center;width: 5%">DIAS</th>
                                                            <th class="all" style="text-align: center;width: 20%">DEPENDENCIA</th>
                                                            <th class="all" style="text-align: center;width: 20%">INTERESADO</th>
                                                            <th class="all" style="text-align: center;width: 5%">EXCESO</th>
                                                            <th class="all" style="text-align: center;width: 5%">F.TERMINO</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="section_avanzado docdepen hide">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Dependencia</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbDepenGm"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Personal</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbPersonal"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject bold font-grey-gallery uppercase"> Día de Ingreso </span>
                                                            <span class="caption-helper">
                                                                <input type="checkbox" class="make-switch" name="ch_rango" id="ch_rango" data-on-text="SI" data-off-text="NO" data-on-color="primary" data-off-color="danger">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 hide" id="time_section_3">
                                                <div class="form-group">
                                                    <label>Fecha Inicio</label>
                                                    <input type="text" class="form-control datepicker" id="txtDiaIngreso" data-name="txtDiaIngreso"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Fecha Fin</label>
                                                    <input type="text" class="form-control datepicker" id="txtDiaFin" data-name="txtDiaFin"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3 margin-top-20">
                                                <div class="form-group margin-bottom-25">
                                                    <button type="button"  class="btn dark btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <i class="icon-doc font-red"></i> Sin Recibir
                                                    <i class="icon-doc font-yellow"></i> Recibido 
                                                    <i class="icon-doc font-green"></i> Respondido 
                                                    <i class="icon-doc font-purple-soft"></i> Sin Respuesta 
                                                    <i class="icon-doc font-blue-sharp"></i> Archivado
                                                </div>
                                                <table id="tbl_report_docdepen" class="display responsive table table-striped table-bordered dataTable" style="width:100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 3%">N°</th>
                                                            <th class="all" style="text-align: center;width: 8%">FECHA RECEPCION</th>
                                                            <th class="min-tablet-l" style="text-align: center;width: 15%">DOC. RECEPCIONADO</th>  
                                                            <th class="all" style="text-align: center;width: 15%">DOC. RESPUESTA</th>
                                                            <th class="all" style="text-align: center;width: 15%">ASUNTO RESPUESTA</th>
                                                            <th class="all" style="text-align: center;width: 8%">FECHA EMISIÓN</th>
                                                            <th class="all" style="text-align: center;width: 8%">ESTADO</th>
                                                            <th class="min-tablet-l" style="text-align: center;width: 10%">ASIGNADO A</th>

                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <!--REPORTE GENERAL DE EXPEDIENTES-->
                                    <section class="section_avanzado repExpReg hide">
                                        <div class="row" style="
                                            border-width: 1px;
                                            border-style: solid;
                                            border-color: #7191bf42;
                                            background: #e4e4e41a;
                                            margin-left: 0px;
                                            margin-right: 0px;
                                            ">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Siglas</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbSiglasExpRep" data-name="siglas"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Año</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbAnioExpRep" data-name="anios"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Mes</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbMesExpRep" data-name="mes">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" >
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject bold font-grey-gallery uppercase"> INCLUIR ÁREA </span>
                                                            <span class="caption-helper">
                                                                <input type="checkbox" class="make-switch" name="ch_rg_area" id="ch_rg_area" data-on-text="SI" data-off-text="NO" data-on-color="primary" data-off-color="danger">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" div_area" style="display: none">
                                                <div class="form-group col-md-2">
                                                    <label><strong>Ubicación</strong></label>
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="opRUbi" id="opRUbi1" value="1" checked=""> Inicial
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="opRUbi" id="opRUbi2" value="2"> Actual
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Área</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbDepExpArea" ></select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 margin-top-20">
                                                <div class="form-group margin-bottom-25">
                                                    <button type="button"  class="btn dark btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-md-5 col-sm-6 col-xs-12 col-lg-2">
                                                <div class="alert alert-info fade in" style="font-size: 20px">
                                                    <strong>CANTIDAD TOTAL &nbsp;<span style="color:#E91E63" id="span_total">0</span></strong>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <table id="tbl_report_expReg" class="display responsive table table-striped table-bordered dataTable" style="width:100%;">
                                                    <thead style="background-color: #4287ef ; color:white;">
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 12%">EXPEDIENTE</th>
                                                            <th class="all" style="text-align: center;width: 8%">FECHA INGRESO</th>
                                                            <th class="all" style="text-align: center;width: 12%">ASUNTO</th>
                                                            <th class="all" style="text-align: center;width: 10%">OBSERVACION</th>
                                                            <th class="all" style="text-align: center;width: 10%">UBICACIÓN</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <!--REPORTE GENERAL DE Tramifacil-->
                                    <section class="section_avanzado repExpTramifacil hide">
                                        <div class="row" style="
                                            border-width: 1px;
                                            border-style: solid;
                                            border-color: #7191bf42;
                                            background: #e4e4e41a;
                                            margin-left: 0px;
                                            margin-right: 0px;
                                            ">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Siglas</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbSiglasTra" data-name="siglas" disabled></select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Año</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbAnioTra" data-name="anios"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Mes</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbMesTra" data-name="mes">
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-3 margin-top-20">
                                                <div class="form-group margin-bottom-25">
                                                    <button type="button"  class="btn dark btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                </div>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="row">

                                            <div class="col-md-5 col-sm-6 col-xs-12 col-lg-2">
                                                <div class="alert alert-info fade in" style="font-size: 20px">
                                                    <strong>CANTIDAD TOTAL &nbsp;<span style="color:#E91E63" id="span_total_tf">0</span></strong>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <table id="tbl_tramifacil" class="display responsive table table-striped table-bordered dataTable" style="width:100%;">
                                                    <thead style="background-color: #4287ef ; color:white;">
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 12%">EXPEDIENTE</th>
                                                            <th class="all" style="text-align: center;width: 8%">FECHA INGRESO</th>
                                                            <th class="all" style="text-align: center;width: 12%">ASUNTO</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <!--DOCUMENTOS PENDIENTES POR AREA/PERSONAL-->
                                    <section class="section_avanzado docPenAP hide">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Área</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbDepDocP"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Personal</label>
                                                    <select class="form-control" style="width: 100%;" id="cmbDepPer"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 margin-top-20">
                                                <div class="form-group margin-bottom-25">
                                                    <button type="button"  class="btn dark btnGenerar"> <i class="fa fa-refresh"></i> GENERAR </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tbl_report_pendientes" class="display responsive table table-striped table-bordered dataTable" style="width:100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 15%">DOCUMENTO</th>
                                                            <th class="min-tablet-l" style="text-align: center;width: 10%">AREA</th>
                                                            <th class="min-tablet-l" style="text-align: center;width: 15%">ASUNTO</th>
                                                            <th class="min-tablet-l" style="text-align: center;width: 10%">FECHA</th>
                                                            <th class="min-tablet-l" style="text-align: center;width: 15%">RESPUESTA A</th>
                                                            <th class="min-tablet-l" style="text-align: center;width: 10%">DIAS</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <input type="hidden" id="txt_idUsu" > </div>
                                <input type="hidden" id="txt_depen" value="<?php echo $this->session->userdata("id_depen"); ?>" >
                                <input type="hidden" id="txt_cargo" value="<?php echo $this->session->userdata("c_cargo"); ?>" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                        <th class="all" style="text-align: left;width: 30%">ARCHIVO(S)</th>
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

<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amcharts/pie.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amcharts/radar.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amcharts/themes/light.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/ammap/ammap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/ammap/maps/js/worldLow.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/amstockcharts/amstock.js" type="text/javascript"></script> 

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/loadingoverlay.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>/frontend/plugins/jquery-validation/js/messages_es_PE.min.js"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/moment.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/FixedHeader-3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/buttons.colVis.min.js" type="text/javascript"></script> 
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/vfs_fonts.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script  type="text/javascript"  src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/jsReportes.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        REPORTES.init();
    });

</script>