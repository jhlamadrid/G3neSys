<?php $suministro =  ((substr($user_datos['CLICODFAC'],3,4) == "0000") ? substr($user_datos['CLICODFAC'], 0,3).substr($user_datos['CLICODFAC'], 7,4) : $user_datos['CLICODFAC']); ?>
<script>
  var servidor = '<?php echo $this->config->item('ip'); ?>';
</script>
<style>
  .contenido_modal {
    border-radius: 5px !important;
}
.head_green {
    background: #00a65a;
    border-radius: 5px 5px 0px 0px;
    color: #FFF;
}
.label_input {
    margin-top: 5px !important;
}
.title_label {
    background: #3c8dbc !important;
    color: #FFF;
    border: none !important;
}
.btn-total {
    width: 100% !important;
}
.borde_footer {
    border-top: 1px solid rgba(167, 167, 167, 0.36);
}
.borde_box {
    border-bottom: 1px solid #dadada !important;
}
.titulo_modal {
    font-family: 'Ubuntu' !important;
}
</style>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 col-sm-3" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" name="button" class="btn btn-danger hidd" style="width:100px">SUMINISTRO</button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo ((substr($user_datos['CLICODFAC'],3,4) == "0000") ? substr($user_datos['CLICODFAC'], 0,3).substr($user_datos['CLICODFAC'], 7,4) : $user_datos['CLICODFAC']); ?>" disabled>
              </div>
            </div>
            <div class="col-md-6 col-sm-6" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" name="button" class="btn btn-danger" style="width:100px">NOMBRE</button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo $user_datos['CLINOMBRE']; ?>" disabled>
              </div>
            </div>
            <div class="col-md-3 col-sm-3" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" name="button" class="btn btn-danger" style="width:100px">TARIFA</button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo $user_datos['TARIFA']; ?>" disabled>
              </div>
            </div>
          </div>
          <div class="row" >
            <div class="col-md-8 col-sm-8" style="margin-top:5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" name="button" class="btn btn-danger" style="width:100px">DIRECCIÓN</button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo $user_datos['URBDES'].(($user_datos['CALDES'] != NULL) ? " - ".$user_datos['CALDES']  : "  " ).(($user_datos['CLIMUNNRO'] != NULL) ? " - ".$user_datos['CLIMUNNRO'] : "  "); ?>" disabled>
              </div>
            </div>
            <div class="col-md-4 col-sm-4" style="margin-top: 5px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" name="button" class="btn btn-danger" style="width:100px"><?php echo (($user_datos['CLIELECT'] != NULL) ? "DNI" : "RUC") ?></button>
                </div>
                <input type="text" name="" class='form-control' value="<?php echo (($user_datos['CLIELECT'] != NULL )  ? $user_datos['CLIELECT'] : $user_datos['CLIRUC']); ?>" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-success">
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 pull-left">
              <button type="button" name="button" style="background:#990000;border:none;width:20px;height:20px"></button> Nota Crédito &nbsp;&nbsp;&nbsp;&nbsp;
              <button type="button" name="button" style="background:#296FB7;border:none;width:20px;height:20px"></button> Nota Débito
            </div>
            <div class="col-md-3 pull-right">
              <a class="btn btn-primary btn-block"  onclick="imprimir_facturacion()"> <i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR</a>
            </div>
          </div><br>
          <div class="table-responsive">
            <table id='recibos_facturacion' class="table table-bordered table-striped">
              <thead role='row'>
                <th style="text-align: center">SERIE</th>
                <th style="text-align: center">N°</th>
                <th style="text-align: center">VOLUMEN</th>
                <th style="text-align: center">FECHA EMISIÓN</th>
                <th style="text-align: center">FECHA VENCIMIENTO</th>
                <th style="text-align: center">MONTO</th>
                <th style="text-align: center">ESTADO</th>
                <th style="text-align: center">FECH. MOV.</th>
                <th style="text-align: center">OPCIONES</th>
              </thead>
              <tbody>
                <?php foreach ($recibos as $recibo) { ?>
                  <tr>
                    <td style="text-align: right;"><?php echo $recibo['FACSERNRO'] ?></td>
                    <td style="text-align: right;"><?php echo $recibo['FACNRO'] ?></td>
                    <td style="text-align: right;"><?php echo ( isset($recibo['vol']) ? $recibo['vol']."m<sup>3</sup>" : "--") ?></td>
                    <td style="text-align: right;"><?php echo $recibo['FACEMIFEC'] ?></td>
                    <td style="text-align: right;"><?php echo $recibo['FACVENFEC'] ?></td>
                    <td style="text-align:right"><?php echo number_format($recibo['FACTOTAL'],2,'.','') ?></td>
                    <td><?php if($recibo['FACESTADO'] == 'C') { 
                                echo "CONVENIO"; 
                              } elseif($recibo['FACESTADO'] == 'P'){ 
                                  echo "PAGADO"; 
                              } elseif($recibo['FACESTADO'] == 'I') {
                                echo "PENDIENTE" ; 
                              } else { echo "REFINANCIADO"; }?>
                    </td>
                    <td><?php echo $recibo['FACESTFECH']; ?></td>
                    <td style='text-align:center'>
                    <?php if($recibo['proceso'] != null)  { ?>
                        <a target='_blank' href="<?php echo $this->config->item('ip').'cuenta_corriente/duplicado2/'. ((substr($user_datos['CLICODFAC'],3,4) == "0000") ? substr($user_datos['CLICODFAC'], 0,3).substr($user_datos['CLICODFAC'], 7,4) : $user_datos['CLICODFAC']).'/'.$recibo['proceso'].'/'.$recibo['FACSERNRO'].'/'.$recibo['FACNRO']; ?>" class="btn btn-success btn-xs">
                          <i class="fa fa-file-text" aria-hidden="true"></i> DUPLICADO RECIBO 2
                        </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php  if(sizeof($recibo['NC']) > 0)  {?>
                <?php foreach ($recibo['NC'] as $NC) { ?>
                  <tr style="color:#990000">
                    <td style="text-align: right;"><?php echo  $NC['NCASERNRO']; ?></td>
                    <td style="text-align: right;"><?php echo  $NC['NCANRO']; ?></td>
                    <td></td>
                    <td style="text-align: right;"><?php echo  $NC['NCAFECHA']; ?></td>
                    <td></td>
                    <td style="text-align:right">  - <?php echo number_format($NC['NCATOTDIF'],2,'.',''); ?></td>
                    <td><?php if($NC['NCAFACESTA'] == 'C') { echo "CONVENIO"; } else if($NC['NCAFACESTA'] == 'P'){ echo "PAGADO"; } else if($NC['NCAFACESTA'] == 'I') {echo "PENDIENTE" ; } else { echo "REFINANCIADO"; }?></td>
                    <td></td>
                    <td style="text-align:center">
                      <a id="btn_cta_corriente" onclick="detalle_nota('<?php echo $suministro; ?>','<?php echo $NC['NCASERNRO']; ?>','<?php echo $NC['NCANRO']; ?>')" class="btn btn-success btn-xs">
                        <i class="fa fa-eye"></i> DETALLE NOTA
                      </a>
                    </td>
                  </tr>
                <?php } ?>
                <?php } ?>
                <?php  if(sizeof($recibo['ND']) > 0)  {?>
                <?php foreach ($recibo['ND'] as $ND) { ?>
                  <tr style="color:#296fb7">
                    <td style="text-align: right;"><?php echo  $ND['NCASERNRO']; ?></td>
                    <td style="text-align: right;"><?php echo  $ND['NCANRO']; ?></td>
                    <td></td>
                    <td style="text-align: right;"><?php echo  $ND['NCAFECHA']; ?></td>
                    <td></td>
                    <td style="text-align:right"><?php echo number_format($ND['NCATOTDIF'],2,'.',''); ?></td>
                    <td><?php if($ND['NCAFACESTA'] == 'C') { echo "CONVENIO"; } else if($ND['NCAFACESTA'] == 'P'){ echo "PAGADO"; } else if($ND['NCAFACESTA'] == 'I') {echo "PENDIENTE" ; } else { echo "REFINANCIADO"; }?></td>
                    <td></td>
                    <td></td>
                  </tr>
                <?php } ?>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal_nota_credito" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content contenido_modal">
        <div class="modal-header head_green">
        <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h4 class="modal-title titulo_modal"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; DETALLE DE LA NOTA CRÉDITO <span id='serie_numero'></span> </h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
            <div class='box-header borde_box'>
                <div class='row'>
                    <div class='col-md-4 col-sm-4 label_input'>
                        <div class='input-group'>
                            <span class="input-group-addon title_label">FECHA</span>
                            <input type="text" class="form-control derecha" id="detalle_nca_fecha" disabled="">
                        </div>
                    </div>
                    <div class='col-md-4 col-sm-4 label_input'>
                        <div class='input-group'>
                            <span class="input-group-addon title_label">REFERENCIA</span>
                            <input type="text" class="form-control derecha" id="detalle_nca_referencia" disabled="">
                        </div>
                    </div>
                    <div class='col-md-4 col-sm-4 label_input'>
                        <div class='input-group'>
                            <span class="input-group-addon title_label">CREADO</span>
                            <input type="text" class="form-control derecha" id="detalle_nca_usuario" disabled="">
                        </div>
                    </div>
                </div>
            </div>
          <div class="box-body">
            <div class="table-responsive">
                <table id="notas_credito" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nº CONCEPTO</th>
                      <th>CONCEPTO</th>
                      <th>MONTO</th>
                      <th>DESCUENTO</th>
                      <th>DIFERENCIA</th>
                    </tr>
                  </thead>
                  <tbody id='cuerpo_detalle'>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer borde_footer">
        <div class="col-md-4 col-sm-4">
          <button type="button" class="btn btn-danger btn-total" data-dismiss="modal" > 
              <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR
          </button>
        </div>
      </div>
      </div>
    </div>
  </div>
</section>

    <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript">
    function imprimir_facturacion (){ var myWindow = window.open("<?php echo $this->config->item('ip') . 'cuenta_corriente/imrpimir_facturacion/'.$suministro."/".$inicio."/".$fin; ?>", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1100, height=800");myWindow.focus();myWindow.print();}
    $('#recibos_facturacion').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});

    var waitingDialog = waitingDialog || (function ($) { 'use strict';
  var $dialog = $('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;"><div class="modal-dialog modal-m"><div class="modal-content" style="border-radius:5px">' +
    '<div class="modal-header"><h3 style="margin:0;font-family:\'Ubuntu\'"></h3></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>');
  return { show: function (message, options) { if (typeof options === 'undefined') options = {}; if (typeof message === 'undefined') message = 'Cargando Recibos'; var settings = $.extend({ dialogSize: 'm', progressType: '', onHide: null  }, options);$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);$dialog.find('.progress-bar').attr('class', 'progress-bar');
    if (settings.progressType) $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType); $dialog.find('h3').text(message);
    if (typeof settings.onHide === 'function') { $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) { settings.onHide.call($dialog); }); } $dialog.modal();},hide: function () { $dialog.modal('hide'); }
  };})(jQuery);
    function detalle_nota (suministro,serie,nro){ 
    waitingDialog.show("Cargando Información...",{dialogSize: 'lg' , progressType: 'warning'});
    $.ajax({ 
      type: 'POST', 
      url: servidor+'cuenta_corriente/ver_detalle_nota?ajax=true',
      data: ({ 'suministro' : suministro, 'serie' : serie, 'nro' : nro }), 
      cache: false, 
      dataType: 'json',
      success: function(resultado){ 
        waitingDialog.hide(); 
        if(resultado.result){ 
          $("#serie_numero").html(resultado.nca.NCASERNRO+"-"+resultado.nca.NCANRO); 
          $("#cuerpo_detalle").empty();
          $("#cuerpo_detalle").append(resultado.nota);
          $("#detalle_nca_fecha").val(resultado.nca.NCAFECHA);
          $("#detalle_nca_referencia").val(resultado.nca.NCAREFE);
          $("#detalle_nca_usuario").val(resultado.usuario);
          $("#modal_nota_credito").modal({backdrop: 'static', keyboard: false,  show :"show" });
        } else {        
          swal({title : '',text : resultado.mensaje, type: 'warning', html :true})
        }
      }, error: function(jqXHR,textStatus,errorThrown){   
        _error(jqXHR,textStatus,errorThrown)
      }
    })
  }
    </script>
