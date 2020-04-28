$('#OTs').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]});
function generarOT (){
    var select = $("#gruposPredio").val();
    var periodo = $("#iperiodo").val();
    var fechaInspeccion = $("#ifecha").val();
    var carga = $("#ihoras").val();
    var descripcion = $("#idescripcion").val();
    var observaciones = $("#iobservaciones").val();
    var maxEntregaNot = $("#ifechaMaxNot").val();
    var maxEntregaIns = $("#ifechaMaxInsp").val();
    if(select != null && periodo != -1 && fechaInspeccion != "" && carga != "" && maxEntregaIns != "" && maxEntregaIns != ""){
        waitingDialog.show('Cargando Información...', {dialogSize: 'lg', progressType: 'warning'});
        $.ajax({
            type: "POST",
            url : servidor+"facturacion/generar_orden?token=true",
            data:({
                ciclos : select,
                periodo :  periodo,
                fechaInspeccion : fechaInspeccion,
                cantxhoras : carga,
                descripcion : descripcion,
                observaciones : observaciones,
                maxEntregaNot :  maxEntregaNot,
                maxEntregaIns :  maxEntregaIns 
            }),
            cache : false,
            dataType: 'json',
            success : function(data){
                waitingDialog.hide();
                if(data.result){
                    window.location.reload();
                } else {
                    swal({title : "",text:+data.mensaje,type : "warning"})
                }
            }, error :  function(jqXHR, textStatus, errorThrown){
                _error(jqXHR,textStatus,errorThrown);
            }
        })
    } else {
        if(select == null) swal({title : "",text:"DEBE SELECCIONAR MINIMO UN CICLO",type : "warning"})
        else if (fechaInspeccion == "") swal({title : "",text:"DEBE SELECCIONAR LA FECHA DE LA INSPECCIÓN",type : "warning"})
        else if (carga == "") swal({title : "",text:"DEBE SELECCIONAR EL NÚMERO DE INPSECCIONES POR RANGO DE 2 HORAS",type : "warning"})
        else if (maxEntregaIns == "") swal({title : "",text:"DEBE SELECCIONAR LA FECHA MÁXIMA DE ENTREGA DE LAS NOTIFIACIONES TRABAJADAS",type : "warning"})
        else if (maxEntregaIns == "") swal({title : "",text:"DEBE SELECCIONAR LA FECHA MÁXIMA DE ENTREGA DE LAS INSPECCIONES TRABAJADAS",type : "warning"})
    }
    
}

var waitingDialog = waitingDialog || (function ($) { 'use strict';
var $dialog = $('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;"><div class="modal-dialog modal-m"><div class="modal-content" style="border-radius:5px">' +
  '<div class="modal-header"><h3 style="margin:0;font-family:\'Ubuntu\'"></h3></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>');
return { show: function (message, options) { if (typeof options === 'undefined') options = {}; if (typeof message === 'undefined') message = 'Cargando Recibos'; var settings = $.extend({ dialogSize: 'm', progressType: '', onHide: null  }, options);$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);$dialog.find('.progress-bar').attr('class', 'progress-bar');
  if (settings.progressType) $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType); $dialog.find('h3').text(message);
  if (typeof settings.onHide === 'function') { $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) { settings.onHide.call($dialog); }); } $dialog.modal();},hide: function () { $dialog.modal('hide'); }
};})(jQuery);

function _error(jqXHR,textStatus,errorThrown){
    waitingDialog.hide(); 
    if (jqXHR.status === 0)  
      swal({title : "",text : "<b>ERROR</b><br>VERIFIQUE SU CONEXIÓN A INTERNET",type : "error", html : true});
    else if (jqXHR.status == 404) 
      swal({title : "",text : "<b>ERROR</b><br>EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO",type : "error" ,html : true});
    else if (jqXHR.status == 500) 
      swal({title : "",text : "<b>ERROR</b><br>ERROR INTERNO DEL SERVIDOR",type : "error", html : true});
    else if (textStatus === 'parsererror') 
      swal({'title' : "",'text' : "ERROR EN LA CONSULTA",'type' : "error",html : true});
    else if (textStatus === 'timeout') 
      wal({title : "",text : "<b>ERROR</b><br>ERROR EN EL TIEMPO DE CONEXIÓN",type : "error", html : true});
    else if (textStatus === 'abort') 
      swal({'title' : "",'text' : "PETICIÓN CANCELADA",'type' : "error"});
    else 
      swal({title : "", text : "<b>ERROR </b><br>ERROR DESCONOCIDO: "+jqXHR.responseText, type : "error", html : true});
  }
//reset select2 $("#customers_select").select2("val", "");