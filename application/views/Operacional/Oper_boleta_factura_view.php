<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<section class="content">   
    <div class="row">
        <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="col-md-12">
            <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $_SESSION['mensaje'][1]; ?>
            </div><br>
        </div>
        <?php } ?>
        <div class="col-md-12">   
            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $titulo; ?></h3>
                </div>
                <div class="box-body">
                    <div class="container-fluid">
                        
                        <div class='container-fluid'>
                           <div class="row">
                               <?php foreach($_SESSION['TAREAS'] as $tareas) {?>
                               <?php if($tareas['MENUGENDESC'] == 'COMPROBANTE' && $tareas['ACTIVDESC'] == 'PROFORMAS' && $tareas['BTNGENDESC'] == 'NUEVA PROFORMA BOLETA') {?>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <a class="btn btn-info" style="width:100% " href="<?php echo $this->config->item('ip'); ?>documentos/proformas/proforma-boleta/nuevo">Nueva Proforma-Boleta</a>
                                </div>
                                <?php } ?>
                                <?php if($tareas['MENUGENDESC'] == 'COMPROBANTE' && $tareas['ACTIVDESC'] == 'PROFORMAS' && $tareas['BTNGENDESC'] == 'NUEVA PROFORMA BOLETA') {?>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <a class="btn btn-info" style="width:100% " href="<?php echo $this->config->item('ip'); ?>documentos/proformas/proforma-factura/nuevo">Nueva Proforma-Factura</a>
                                </div>
                                <?php } ?>
                                <?php } ?>
                            </div><br> 
                        </div> 
                        <div class='container-fluid'>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#proforma" data-toggle="tab" aria-expanded="true">
                                        Proformas 
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="proforma">
                                   <div class="row">
                                       <div class="col-md-12">
                                            
                                           <br>
                                           <table id="boletas" class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th>EMISION</th>
                                                    <th>TIPO</th>
                                                    <th>SERIE - NUMERO</th>
                                                    <th>NOMBRE USUARIO</th>
                                                    <th>DOCUMENTO</th>

                                                    <th>TOTAL</th>
                                                    <!--th>ORDEN DE PAGO</th-->
                                                    <th>OPCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($comprobantes as $comprobante){ ?>
                                                <tr>
                                                    <td><?php echo $comprobante['FSCFECH']; ?></td>
                                                    <td>
                                                        <?php echo ($comprobante['FSCTIPO'] == 1)? 'FACTURA':'BOLETA'; ?>
                                                    </td>
                                                    <td><?php echo $comprobante['FSCSERNRO'].'-'.str_pad($comprobante['FSCNRO'], 6, "0", STR_PAD_LEFT); ?></td>
                                                    <td><?php echo $comprobante['FSCCLINOMB']; ?></td>
                                                    <td>
                                                        <?php echo ($comprobante['FSCTIPDOC']!=6)? '<b>'.$comprobante['TIPDOCDESCABR'].': </b><br>'.$comprobante['FSCNRODOC']:'<b>RUC: </b><br>'.$comprobante['FSCCLIRUC']; ?>
                                                    </td>
                                                    <td style="text-align:right;">
                                                        <?php echo number_format($comprobante['FSCTOTAL'],2); ?>
                                                        <br>
                                                        <?php if($comprobante['CONORDPAG']==1){ ?>
                                                            <span class="label label-default">Con Orden de Pago</span>
                                                        <?php } else if($comprobante['CONORDPAG']==0) { ?>
                                                            <span class="label label-default">Sin Orden de Pago</span>
                                                        <?php } else { ?>
                                                            <span class="label label-error">Error</span>
                                                        <?php } ?>
                                                    </td>
                                                    <!--td style="text-align:center">

                                                    </td-->
                                                    <td style="text-align:center">
                                                        <!--a class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-placement="bottom" title="Imprimir" target="_blank"
                                                           onclick="imprimir(<?php echo $comprobante['FSCTIPO']; ?>, <?php echo $comprobante['FSCSERNRO']; ?>, <?php echo $comprobante['FSCNRO']; ?>)">
                                                           <i class="fa fa-print"></i>
                                                        </a-->
                                                        <?php if($comprobante['FSCESTADO']==1) { ?>
                                                            <span class="label label-success">Pagado</span>
                                                        <?php } else { ?>
                                                            <a class="btn btn-default btn-flat btn-sm" id="editar-prof" data-toggle="tooltip" data-placement="bottom" title="Editar"
                                                                href="<?php echo $this->config->item('ip').'documentos/proformas/editar/'.$comprobante['FSCTIPO'].'/'.$comprobante['FSCSERNRO'].'/'.$comprobante['FSCNRO']; ?>"
                                                                tipo = "<?php echo $comprobante['FSCTIPO']; ?>" serie="<?php echo $comprobante['FSCSERNRO']; ?>" numero="<?php echo $comprobante['FSCNRO']; ?>" >
                                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                            </a>

                                                        <?php } ?>
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
                    </div>    
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    
    $(document).ready(function(){
        table_ordpag =$('#boletas').DataTable({
              responsive: true,
              bSort:false,
              bInfo: false,
              scrollX: true,
              "autoWidth": true,
           });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
              $($.fn.dataTable.tables(true)).DataTable()
                 .columns.adjust();
           });
    });
</script>
