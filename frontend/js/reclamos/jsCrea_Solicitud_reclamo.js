function Cargando(estado) {

    if (estado == '0') {
        $.LoadingOverlay('hide');
    }
    else{
        $.LoadingOverlay('show');
    }

}

var Crea_Solicitud_reclamo = function () {

    var carga_inicial = function(){
        
    }
    var plugins = function () {
        $(".select2").select2();
    }
    var carga_tablas = function(){
    
    }

    var eventos = function(){
        $( "#grabar_orden_servicio" ).click(function() {
            swal({
                title: "DESEA GENERAR ORDEN DE SERVICIO",
                text: '',
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: false
            },
            function(isConfirm) {
                if(isConfirm==true){
                    swal.disableButtons();
                    crear_orden_requerimiento();
                }
                
            });  
        });
    }

    var crear_orden_requerimiento = function (){
        var url = $("#inp_ruta").val();
        var cadena = $("#inp_cadena").val();
        $.ajax({
            type: "POST",
            url: url+"Solicitud_requerimiento/crear_orden_reque?ajax=true",
            data: {
                cad: cadena,
                apePat : $("#ape_pat_sol").val(),
                apeMat : $("#ape_mat_sol").val(),
                Nombre : $("#nombre_sol").val()
            },
            dataType: 'json',
            success: function(data){
                if(data.result){
                    swal.close();
                    return true;
                }
            }
        });
    }

    var datos_globales= function (){
        ruta_basica = '';
        fecha_actual ='';

    }

    return {

        init: function (){
            datos_globales();
            carga_tablas();
            carga_inicial();
            plugins();
            eventos();
        }
    };
}();