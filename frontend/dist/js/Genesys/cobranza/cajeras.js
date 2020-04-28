/*
*/
	function cambiar_oficina(_ofi,_cod_ofi,_cod,_usr){
		$("#oficina").val(_ofi);
		$("#usuario").val(_usr);
		$("#usuario").attr("codigo",_cod);
		$("#selector option").each(function(){
			if($(this).attr('value') == _cod_ofi){
				$(this).attr('disabled',true)
			} else {
				$(this).attr('disabled',false)
			}
		});
		$("#localidades").modal({backdrop: 'static', keyboard: false,  show :"show" });
	}
/*
**************************************************************************************
*                                                                                    *
*                 FUNCIÓN PARA ACOMODAR LO QUE DESACOMODA EL MODAL                    *
*              -----------------------------------------------------                 *
*     -> Vuelve a la posición inicial el body despues de renderizar el modal         *
*                                                                                    *
**************************************************************************************
*/
  function ocultar_modal (id) {
    $("#"+id).modal('hide');
    setTimeout(function(){ 
      $('.sidebar-mini').css("padding-right","0px") 
    }, 600)
  }
/*
**************************************************************************************
*                                                                                    *
*                 FUNCIÓN PARA ACTUALIZAR LA OFICINA DE LA CAJERA                    *
*              -----------------------------------------------------                 *
*     -> Envia la cajera y la nueva oficina que se le colocara para su punto de      *
*			cobranza que se le asigne                                                   *
*                                                                                    *
**************************************************************************************
*/
 	$("#btn-guardar").click(function(){
 		var val = $("#selector").val();
 		if(val != -1){
 			$.ajax({
 				type : 'POST',
 				url : servidor+'cobranza/actualizar_cajera?ajax=true',
 				data:({
 					cajera : $("#usuario").attr('codigo'),
 					oficina : val
 				}),
 				cache : false,
 				dataType : 'json',
 				success :  function(data){
 					if(data.result){
 						swal({'title' : '', 'text' : "<b>ACTUALIZACIÓN CORRECTA</b>", 'type' : "success", 'html' : true});
 						setTimeout(function(){
 							location.reload();
 						},500)
 					}
 					else swal({'title' : '', 'text' : data.mensaje, 'type' : "warning", 'html' : true});
 				}, error :  function(jqXHR,textStatus,errorThrown){
 					_error(jqXHR,textStatus,errorThrown);
 				}
 			})
 		} else {
 			swal({title:'',text:'<b>ALERTA</b><br>DEBEBE SELECCIONAR UNA OFICINA',type:'warning',html:true})
 		}
 	})
/*
**************************************************************************************
*                                                                                    *
*            FUNCIÓN PARA TRATAR EL ERROR QUE SE OBTIENE DEL SERVIDOR                *
*       ---------------------------------------------------------------------        *
*     ->  Captura el error del servidor y de acuerdo al tipo de error muestra        *
*         un mensaje al usuario, para su tratameinto                                 *
*                                                                                    *
**************************************************************************************
*/
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