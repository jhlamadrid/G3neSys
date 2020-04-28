<link href="<?php echo $this->config->item('ip'); ?>/frontend/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('ip') ?>frontend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css">
<style>
    hr.style-seven {
        overflow: visible; /* For IE */
        height: 30px;
        border-style: solid;
        border-color: black;
        border-width: 1px 0 0 0;
        border-radius: 20px;
    }
    hr.style-seven:before { /* Not really supposed to work, but does */
        display: block;
        content: "";
        height: 30px;
        margin-top: -31px;
        border-style: solid;
        border-color: black;
        border-width: 0 0 1px 0;
        border-radius: 20px;
    }
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

    /* para el radio button  */
    .list_per_area {
        appearance: none;
        margin: 0 20px;
        width: 15px;
        height: 15px;
        background: #eee;
        box-shadow: inset 0 0 0 0.4em white, 0 0 0 0.3em;
        border-radius: 50%;
        transition: 0.2s;
        cursor: pointer;
        color: #363945;
    }
    .list_per_area :hover, .list_per_area:checked {
        background: #363945;
        box-shadow: inset 0 0 0 0.6em white, 0 0 0 0.3em;
    }
    .list_per_area:checked {
        background: #56be8e;
        box-shadow: inset 0 0 0 0.4em white, 0 0 0 0.3em #56be8e;
    }
    .list_per_area:focus {
        outline: 0;
    }

    /* ESTILO PARA EL CHECKBOX */
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
                    <h3 class="box-title text-uppercase text-info titulo_box" style="font-family:Ubuntu">RECIBIR DOCUMENTOS </h3>
                </div>
                <div class="box-body">
                    <div class='row'>
                        <div class ='col-md-12'>
                                <div class="row no-print well"  style="
                                    border-width: 1px;
                                    border-style: solid;
                                    border-color: #7191bf42;
                                    background: #e4e4e41a;
                                    margin-left: 0px;
                                    margin-right: 0px;
                                    ">

                                    <div class="clearfix">
                                        <div class="btn-group" id="btns-radio" data-toggle="buttons">
                                            <label class="btn btn-default active">
                                                <input type="radio" class="toggle" name="inp-radio" value="si1"> N° Documento </label>
                                        </div>
                                    </div>
                                    <br>
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


                                        </section>
                                    </form>
                                </div> 
                        </div>
                    </div>
                    <div class ='row'>
                        <div class ='col-md-12'>
                                <div class="" id="aaa">
                                    <ul class="nav nav-tabs " style="margin-bottom: 0;" id="tabs_listas">
                                        <li  id="li1" class="active">
                                            <a href="#tab_1"   data-toggle="tab" aria-expanded="true"> Documentos Sin Recibir </a>
                                        </li>
                                        <li id="li2" class="">
                                            <a href="#tab_2"  data-toggle="tab" aria-expanded="true"> Documentos Recepcionados </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1" style=" border-radius: 0px 0px 5px 5px;padding: 10px;">                  
                                        <br>
                                        <div class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                                                <div class="form-group">
                                                    &nbsp;&nbsp;
                                                    <span  style="font-size: 20px;" ><i style="color: #4caf50;" class="fa fa-file"></i>&nbsp;COPIA</span> &nbsp;
                                                    <span  style="font-size: 20px;" ><i style="color: #e41d20;" class="fa fa-file"></i>&nbsp;DERIVADO</span> &nbsp;
                                                    <span  style="font-size: 20px;" ><i style="color: #f0ad4e;" class="fa fa-file"></i>&nbsp;EXTERNO</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-md-offset-8">
                                                <div class="form-group">
                                                    <div class="input-group col-md-12 ">
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
                                                <table id="tbl_sis_recibir" class="table table-condensed table-bordered  table-sm table-hover">
                                                    <thead style="background-color: #337ab7;color:white;font-weight: bold ">
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 2%;"></th>
                                                            <th class="all" style="text-align: left;width: 18%">TIPO DOCUMENTO</th> 
                                                            <th class="min-tablet-l" style="text-align: center;width: 2%">FOLIOS</th>
                                                            <th class="min-tablet-l" style="text-align: left;width: 10%">AREA</th>
                                                            <th class="none" style="text-align: center;width: 10%">F. EMISIÓN</th>
                                                            <th class="none" style="text-align: center;width: 10%">F. MAX. ATENCIÓN</th>
                                                            <th class="none" style="text-align: center;width: 10%">DIAS PARA ATENCIÓN</th>
                                                            <th class="all" style="text-align: left;width: 10%">ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_2" style="border-radius: 0px 0px 5px 5px;padding: 10px;">
                                        <br>
                                        <div class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                                                <div class="form-group">
                                                    &nbsp;&nbsp;
                                                    <span  style="font-size: 20px;" ><i style="color: #4caf50;" class="fa fa-file"></i>&nbsp;COPIA</span> &nbsp;
                                                    <span  style="font-size: 20px;" ><i style="color: #e41d20;" class="fa fa-file"></i>&nbsp;DERIVADO</span> &nbsp;
                                                    <span  style="font-size: 20px;" ><i style="color: #f0ad4e;" class="fa fa-file"></i>&nbsp;EXTERNO</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
                                                <div class="form-group">
                                                    <div class="input-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                                                        <input type="text" class="form-control" id="txt_buscar_recep"  placeholder="Filtrar aquí" style="  color:#0072c6;font-weight: bold;text-transform: uppercase">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-search"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3" id="divEntExt" style="margin-bottom: 1%;">
                                                <div class="md-checkbox-inline">
                                                        <label class="container">Ver Archivados
                                                            <input type="checkbox" id="chkArchivados">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12 ">
                                                <table id="tbl_sis_recepcionados" class="table table-condensed table-bordered  table-sm table-hover">
                                                    <thead style="background-color: #337ab7;color:white;font-weight: bold ">
                                                        <tr role="row">
                                                            <th class="all" style="text-align: center;width: 2%;"></th>
                                                            <th class="all" style="text-align: left;width: 18%">TIPO DOCUMENTO</th> 
                                                            <th class="min-tablet-l" style="text-align: center;width: 2%">FOLIOS</th>
                                                            <th class="min-tablet-l" style="text-align: left;width: 10%">AREA</th>
                                                            <th class="none" style="text-align: center;width: 10%">F. EMISIÓN</th>
                                                            <th class="none" style="text-align: center;width: 10%">F. MAX. ATENCIÓN</th>
                                                            <th class="none" style="text-align: center;width: 10%">DIAS ATENCIÓN</th>
                                                            <th class="all" style="text-align: left;width: 10%">ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <br><br>
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

<div id="modal_info" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
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
                        <span id="titulo_envia_devolver" style="font-size: 20px;">¿Está seguro que desea recibir?</span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <table class="table table-striped">  
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 22px;color: #3F51B5;font-weight: bold;"><span id="sp_doc"></span> </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 15px;color: #009688;font-weight: bold;"><span id="sp_area"></span></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 15px;color: #e43a45;font-weight: bold;"><span id="sp_folios"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger " data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary" id="btnConfirmRecibir" cod_mov="">RECIBIR</button>
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


<div id="modal_derivar" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> DERIVACIÓN</h4>
            </div>
            <div class="modal-body">
                <h4>Proveer el <span id="sp_doc_dev" style="color: #3F51B5;font-weight: bold"></span></h4>
                <div class ='row'>
                    <div class ="col-md-12">
                        <hr class='style-seven'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> 
                                DESTINATARIO  &nbsp; &nbsp; 
                                <span id="derivar_destinatario">
                                    <label class="radio-inline" ><input type="radio" class ="list_per_area" value="P" name="btnliper_area" checked> &nbsp; <span style=" font-size:17px;">Listar Personal </span> </label>
                                    <label class="radio-inline"><input type="radio" class ="list_per_area" value="A"  name="btnliper_area"> &nbsp; <span style=" font-size:17px;">Listar Areas </span></label>
                                </span>
                            </label>           
                            <select style="width: 100%" class="form-control" id="cmbPersonalA" name="cmbPersonalA">
                            </select>
                        </div>
                    </div>
                    <div class="form-group control-group col-md-6 ">
                        <label>FECHA <span style='color:red;'>MAXIMA</span> DE ATENCIÓN </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control " id="NSUM-INI" readonly>
                        </div>
                    </div>
                </div>  
                <div class="row">
                     <div class="col-xs-12 col-md-12">
                            <div class="form-group">           
                                <textarea id="txtMotivoDeriva" spellcheck="false" style="color:black;font-weight: bold" class="form-control" rows="5" placeholder="Ingresa aquí un motivo"></textarea>
                            </div>
                        </div>
                </div>
				<div class="row">
                        <div class="col-xs-12 col-md-2">
                            <button type="button" class="btn btn-primary btn-sm" id="btnAdicionarFolios"><i class="fa fa-plus"></i>&nbsp;&nbsp;Adicionar Folios</button>
                        </div>
                    </div>
					<hr>
				<div class="row" id="divFoliosProveido" style="display:none;">
				    <div class="col-xs-12 col-md-12">
                        <div class="form-group">   
							<label>Folios</label>							
                            <input id="txtFoliosDeriva" style="color:black;font-weight: bold;font-size:20px;" class="form-control"  ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger " data-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id="btnDerivar" mov="">DERIVAR</button>
            </div>
        </div>
    </div>
</div>


<div id="modal_archivar" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" > <i class="fa fa-cubes" aria-hidden="true"></i> ARCHIVACIÓN</h4>
            </div>
            <div class="modal-body">
                <h4>Archivar el <span id="sp_doc_arch" style="color: #3F51B5;font-weight: bold"></span></h4>
                <div class="row">
                     <div class="col-xs-12 col-md-12">
                            <div class="form-group">           
                                <textarea id="txtMotivoArch" style="color:#e7505a;font-weight: bold" class="form-control" rows="5" placeholder="Ingresa aquí un motivo"></textarea>
                            </div>
                        </div>
                </div>  
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger " data-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id="btnArchivar" mov="">ARCHIVAR</button>
            </div>
        </div>
    </div>
</div>




<div id="modal_detalle" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> DETALLE DEL DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <span id="sp_doc_det" style="font-size: 20px;font-weight: bold;color: #000;"></span>
                <br>
                <div class="row" style='margin-top: 15px;'>
                    <div class="col-md-12">
                        <table class="table table-striped ">  
                            <tbody>
                                <tr>
                                    <td style="font-size: 15px;color: #3F51B5;font-weight: bold; width: 35%;"> FECHA EMISIÓN </td>
                                    <td style="font-size: 17px;color: black;font-weight: bold; width: 65%;"> <span id="sp_fe_emision"></span></td>
                                </tr>
                                <tr>
                                    <td  style="font-size: 15px;color: #3F51B5;font-weight: bold; width: 35%;"> FECHA MAXIMA ATENCIÓN </td>
                                    <td  style="font-size: 17px;color: black;font-weight: bold; width: 65%;"><span id="sp_max_atencion"></span></td>
                                </tr>
                                <tr>
                                    <td  style="font-size: 15px;color: #3F51B5;font-weight: bold; width: 35%;"> DIAS ATENCIÓN </td>
                                    <td  style="font-size: 17px;color: black;font-weight: bold; width: 65%;"><span id="sp_dias_atencion"></span></td>
                                </tr>
                                <tr>
                                    <td  style="font-size: 15px;color: #3F51B5;font-weight: bold; width: 35%;">ASUNTO </td>
                                    <td  style="font-size: 17px;color: black;font-weight: bold; width: 65%;"><span id="sp_asunto"></span></td>
                                </tr>  
                                <tr>
                                    <td  style="font-size: 15px;color: #3F51B5;font-weight: bold; width: 35%;">OBSERVACIONES </td>
                                    <td  style="font-size: 17px;color: black;font-weight: bold; width: 65%;"><span id="sp_procedimiento"></span></td>
                                </tr>
                                <tr id="derivado_mensaje">
                                    <td  style="font-size: 15px;color: #3F51B5;font-weight: bold; width: 35%;">MENSAJE DE DERIVACIÓN </td>
                                    <td  style="font-size: 17px;color: black;font-weight: bold; width: 65%;"><span id="sp_men_derivado"></span></td>
                                </tr>
                            </tbody>
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


<div id="modal_info_desarchivar" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> CONFIRMACIÓN</h4>
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
                        <span style="font-size: 20px;">¿Está seguro que deseas desarchivar?</span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <table class="table table-striped">  
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 22px;color: #3F51B5;font-weight: bold;"><span id="sp_doc_desarch"></span> </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 15px;color: #009688;font-weight: bold;"><span id="sp_area_desarch"></span></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 15px;color: #e43a45;font-weight: bold;"><span id="sp_folios_desarch"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer center">
                <button type="button" class="btn  btn-danger" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDesarchivar" cod_mov="">DESARCHIVAR</button>
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


<div id="modal_devolver" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa fa-cubes" aria-hidden="true"></i> CONFIRMAR DEVOLUCIÓN</h4>
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
                        <span style="font-size: 20px;">¿Está seguro que deseas devolver?</span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <table class="table table-striped">  
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 22px;color: #3F51B5;font-weight: bold;"><span id="sp_doc_devolver"></span> </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 15px;color: #009688;font-weight: bold;"><span id="sp_area_devolver"></span></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 15px;color: #e43a45;font-weight: bold;"><span id="sp_folios_devolver"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id="btnDevolver" mov="">DEVOLVER</button>
            </div>
        </div>
    </div>
</div>
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
<script  type="text/javascript"  src="<?php echo $this->config->item('ip') ?>frontend/js/tramite_documentario/jsRecibirDoc.js?v=<?php echo(rand()); ?>"></script>
<script type="text/javascript">


    $(document).ready(function () {
        RECIBIR.init();
    });

</script>