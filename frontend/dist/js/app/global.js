var base_url = window.location.origin
var app = `GeneSys4` 

var btnCerrarSesion = document.querySelector("#btnCerrarSesion")
var btnPanelCerrarSession = document.querySelector("#btnPanelCerrarSession")
if(btnCerrarSesion != null) btnCerrarSesion.addEventListener('click', cerrarSession)
if(btnPanelCerrarSession != null) btnPanelCerrarSession.addEventListener('click', cerrarSession)

function showAlert(msg, type){
    if(type == `error`)
        alertify.alert('<span class="text-red font-text"><i class="fa fa-times" aria-hidden="true"></i> Error</span>', msg)
    else if(type == `alert`)
        alertify.alert('<span class="text-yellow font-text"><i class="fa fa-exclamation" aria-hidden="true"></i> Alerta</span>', msg)
    else if(type == `ok`)
        alertify.alert('<span class="text-green font-text"><i class="fa fa-check" aria-hidden="true"></i> Ok</span>', msg)
}

function cerrarSession(){
    alertify.confirm('Cerrar Sesión', '¿Esta seguro que desea cerrar sesión?', 
                    function(){ 
                        window.location.href = `${base_url}/${app}/logout`;
                    }
                , function(){ });
}

function errorAjax(xhr, status, error){
    let message = ``
    if(xhr.status === 0) message = `No se puede conexta, verifique su conexión a Internet.`
    else if(xhr.status == 404) message = `No se puedo encontrar la solicitud requerida.`
    else if(xhr.status == 500) message = `Ocurrió un error interno en el servidor.`
    else if(status == 'parsererror') message = `La solicitud requerida falló.`
    else if(status == 'timeout') message = `Caduco el tiempo de solicitud.`
    else if(status == 'abort') message = `La solicitud ha sido cancelada.`
    showAlert(message, `error`)
}