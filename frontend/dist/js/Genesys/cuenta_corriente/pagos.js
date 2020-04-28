$('#resumen').DataTable({"bFilter": true, "bInfo": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
$("#imprimir_pagos").click(function (){ var myWindow = window.open(servidor+"cuenta_corriente/imprimir_pagos/"+key, "_blank"); myWindow.document.title = "PAGOS "+ suministro; myWindow.focus(); myWindow.print(); });
$("#imprimir_rangos").click(function (){ 
    waitingDialog.show("Cargando Información...",{dialogSize: 'lg' , progressType: 'warning'});
    $.ajax({  type: 'POST',  url: servidor+'cuenta_corriente/obtener_rangos?ajax=true', data: ({ 'suministro' : suministro }),  cache: false, dataType: 'json',
    success: function(resultado){ waitingDialog.hide(); if(resultado.result){  var periodo =  resultado.fecha.slice(-4) + "-" + resultado.fecha.substr(3,2); var periodo1 =  resultado.fin.slice(-4) + "-" + resultado.fin.substr(3,2);
    var mes = parseInt(resultado.fecha.substr(3,2));var anio = parseInt(resultado.fecha.slice(-4)); $("#facturacion_periodos_inicio").empty(); $("#facturacion_periodos_fin").empty(); $("#facturacion_periodos_inicio").append("<option value='-1'>Selecciones una opción </option>"); $("#facturacion_periodos_fin").append("<option value='0'>Selecciones una opción </option>");
    while(periodo1 != periodo){ if(mes < 13){  $("#facturacion_periodos_inicio").append("<option value='"+anio+((mes<10) ? "0"+mes : mes)+"'>"+anio+"-"+((mes < 10 ) ? "0"+mes : mes)+"</option>");  $("#facturacion_periodos_fin").append("<option value='"+anio+((mes<10) ? "0"+mes : mes)+"'>"+anio+"-"+((mes < 10 ) ? "0"+mes : mes)+"</option>");
    periodo = anio+"-"+((mes < 10) ? "0"+mes : mes); mes++; } else { anio ++;mes = 1;}} 
    $("#faturacion_suministro").val(suministro); $("#rangos_pagos").modal({backdrop: 'static', keyboard: false,  show :"show" }); } else { swal({title : '',text : resultado.mensaje, type: 'warning', html :true}); }
    }, error: function(jqHXR,textSuccess,errorThrown){   _error(jqHXR,textSuccess,errorThrown); } })
});
function validar_segundo_pediodo(){ var min = $("#facturacion_periodos_inicio").val(); $("#facturacion_periodos_fin").attr('disabled',false);  var minusage = parseInt(min); var select = $('#facturacion_periodos_fin');  select.val($('option:first', select).val());
    $("#facturacion_periodos_fin option").each(function(){ if(minusage >= parseInt($(this).val()) && parseInt($(this).val()) != -1) { $(this).attr('disabled','disabled'); } else {  $(this).attr('disabled',false); } });}
function imprimir_nota( serie , nro ){  var myWindow1 = window.open(servidor + "cuenta_corriente/notaCredito/"+key+"/"+serie+"/"+nro, "_blank"); myWindow1.document.title = "NOTA CRÉDITO "+serie+" - "+nro; myWindow1.focus(); myWindow1.print();}
function detalle_nota (suministro,serie,nro){ 
    waitingDialog.show("Cargando Información...",{dialogSize: 'lg' , progressType: 'warning'});
    $.ajax({  type: 'POST',  url: servidor+'cuenta_corriente/ver_detalle_nota?ajax=true', data: ({ 'suministro' : suministro, 'serie' : serie, 'nro' : nro }),  cache: false,  dataType: 'json',
      success: function(resultado){  waitingDialog.hide();  if(resultado.result){ $("#serie_numero").html(resultado.nca.NCASERNRO+"-"+resultado.nca.NCANRO);  $("#volFacturado").val(resultado.nca['NCA_VOLFAC']); $("#volDescontado").val(resultado.nca['NCA_VOLDIF']); $("#cuerpo_detalle").empty(); $("#cuerpo_detalle").append(resultado.nota); $("#modal_nota_credito").modal({backdrop: 'static', keyboard: false,  show :"show" });
        } else { swal({title : '',text : resultado.mensaje, type: 'warning', html :true}); }
      }, error: function(jqHXR,textSuccess,errorThrown){ _error(jqXHR,textStatus,errorThrown); } })}
function ocultar_modal (id) { $("#"+id).modal('hide'); setTimeout(function(){ $('body').css("padding-right","0px") ; }, 600);}
function ver_detalle (serie,numero) {  
    waitingDialog.show('Cargando Información...', {dialogSize: 'lg', progressType: 'warning'});
    $.ajax({ type : "POST", url : servidor+"cuenta_corriente/obtener_detalle_recibo?ajax=true", data : ({ suministro : suministro, serie : serie,numero : numero }), cache : false, dataType  : 'json',
    success : function(resultado){  waitingDialog.hide(); if(resultado.result){ $("#cabecera_detalle_recibo").empty(); $("#serie_numero_recibo").empty(); $("#cuerpo_detalle_recibo").empty(); $("#cuerpo_detalle_recibo").append(resultado.cuerpo); $("#serie_numero_recibo").append(resultado.ser_nro); $("#cabecera_detalle_recibo").append(resultado.cabecera); $("#detalle_recibo").modal({backdrop: 'static', keyboard: false, show:"show"});
    } else {  swal({title : "",text : resultado.mensaje, type: "warning",html :true}) ; }
      }, error : function(jqXHR,textStatus,errorThrown){  _error(jqXHR,textStatus,errorThrown); } });}
var waitingDialog = waitingDialog || (function ($) { 'use strict';
var $dialog = $('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;"><div class="modal-dialog modal-m"><div class="modal-content" style="border-radius:5px">' +
    '<div class="modal-header"><h3 style="margin:0;font-family:\'Ubuntu\'"></h3></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>');
  return { show: function (message, options) { if (typeof options === 'undefined') options = {}; if (typeof message === 'undefined') message = 'Cargando Recibos'; var settings = $.extend({ dialogSize: 'm', progressType: '', onHide: null  }, options);$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);$dialog.find('.progress-bar').attr('class', 'progress-bar');
    if (settings.progressType) $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType); $dialog.find('h3').text(message);
    if (typeof settings.onHide === 'function') { $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) { settings.onHide.call($dialog); }); } $dialog.modal();},hide: function () { $dialog.modal('hide'); }
  };})(jQuery);
function _error(jqXHR,textStatus,errorThrown){
    waitingDialog.hide(); 
    if (jqXHR.status === 0)  swal({title : "",text : "<b>ERROR</b><br>VERIFIQUE SU CONEXIÓN A INTERNET",type : "error", html : true});
    else if (jqXHR.status == 404) swal({title : "",text : "<b>ERROR</b><br>EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO",type : "error" ,html : true});
    else if (jqXHR.status == 500)  swal({title : "",text : "<b>ERROR</b><br>ERROR INTERNO DEL SERVIDOR",type : "error", html : true});
    else if (textStatus === 'parsererror')  swal({'title' : "",'text' : "ERROR EN LA CONSULTA",'type' : "error",html : true});
    else if (textStatus === 'timeout') swal({title : "",text : "<b>ERROR</b><br>ERROR EN EL TIEMPO DE CONEXIÓN",type : "error", html : true});
    else if (textStatus === 'abort') swal({'title' : "",'text' : "PETICIÓN CANCELADA",'type' : "error"});
    else swal({title : "", text : "<b>ERROR </b><br>ERROR DESCONOCIDO: "+jqXHR.responseText, type : "error", html : true});
}
$("#btn_visualizar").click(function(){
    if($("#facturacion_periodos_inicio").val() != -1){ myWindow = window.open(servidor+"cuenta_corriente/imprimir_rangos/"+$("#faturacion_suministro").val()+"/"+$("#facturacion_periodos_inicio").val()+"/"+$("#facturacion_periodos_fin").val(), "_blank")
        myWindow.document.title =  'PAGOS '+suministro; myWindow.focus(); myWindow.print(); $("#rangos_pagos").modal("hide");
     } else { swal({title : '', text : '<b>ALERTA</b><br>DEBE SELECCIONAR UN PERIODO DE INICIO Y/O PERIODO FINAL PARA IMPRIMIR EL REPORTE',type: 'warning',html :true}); }});
