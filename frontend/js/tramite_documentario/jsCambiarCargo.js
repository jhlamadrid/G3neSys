function Cargando(estado) {

    if (estado == '0') {
        $.LoadingOverlay('hide');
    }
    else
    {
        $.LoadingOverlay('show');
    }

}

function isEmpty(strIn)
{
    if (strIn === undefined)
    {
        return true;
    }
    else if(strIn == null)
    {
        return true;
    }
    else if(strIn == "")
    {
        return true;
    }
    else
    {
        return false;
    }
}

function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = [8, 37, 39, 46];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}

function limpia() {
    var val = document.getElementById("sigla_usuario").value;
    var tam = val.length;
    for(i = 0; i < tam; i++) {
        if(!isNaN(val[i]))
            document.getElementById("sigla_usuario").value = '';
    }
}

function Alerta(titulo, mensaje, tipo) {

    if (tipo == '1')
    {
        swal({
            title: titulo,
            text: mensaje,
            type: "success",
            confirmButtonClass: "btn-success",
            confirmButtonText: "Ok",
            closeOnConfirm: false,
            html: true
        });
    }
    if (tipo == '2')
    {
        swal({
            title: titulo,
            text: mensaje,
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ok",
            closeOnConfirm: false,
            html: true
        });

    }

    if (tipo == '3')
    {
        swal({
            title: titulo,
            text: mensaje,
            type: "info",
            confirmButtonClass: "btn-info",
            confirmButtonText: "Ok",
            closeOnConfirm: false,
            html: true
        });
    }

    if (tipo == '4')
    {
        swal({
            title: titulo,
            text: mensaje,
            type: "warning",
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Ok",
            closeOnConfirm: false,
            html: true
        });


    }
}


var CambiarCargo = function () {

    var initDatables = function () {
        var parms = {
            data: null,
            info: false,
            searching: true,
            paging: true,
            fixedHeader: true,
            ordering: false,
            columns: [
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "NOMBREENCARGADO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "FECHACREACION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '17px');
                        $(td).css('font-weight', 'bold');

                    }
                },
                {data: "SIGLA_AREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var cade= '<button type="button" class="btnEditar btn btn-primary "  data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fa fa-pencil"></i></button>';
                        
                        return cade;
                    }
                }
            ]
        }
        oTable_Data = $("#tbl_listar_documentos").dataTable(parms);
        
    }
    var initDatables_Usuarios = function () {
        var parms = {
            data: null,
            info: false,
            searching: true,
            paging: true,
            fixedHeader: true,
            ordering: false,
            columns: [
                {data: "NNOMBRE",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "LOGIN",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "NDIRECC",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '15px');
                        $(td).css('font-weight', 'bold');

                    }
                },
               
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var cade= '<button type="button" class="btnEditar_usuario btn btn-primary "  data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fa fa-pencil"></i></button>';
                        
                        return cade;
                    }
                }
            ]
        }
        oTable_Data_Usuario = $("#tbl_listar_usuarios").dataTable(parms);
        
    }


    var listarEncargados = function(){
        Cargando(1);
        $.ajax({
            url: "Cambiar_Cargo/listarAreas",
            datatype: "json",
            type: "post",
            async: true,
            data: {
            },
            success: function (data) {
                Cargando(0);
                oTable_Data.fnClearTable();
                if (data.length>0) {
                    oTable_Data.fnAddData(data);
                } else {
                    Alerta("ATENCIÓN", "No se encontró ninguna Area habilitada", 4);
                } 
            },
            timeout: 20000,
            error: function(request, status, err) {
                if (status == "timeout") {
                    setTimeout(function () {
                        Cargando(0);
                        Alerta("ERROR", "Tardo el tiempo de petición!", "2");
                    }, 900)
                } else {
                    setTimeout(function () {
                        Cargando(0);
                        Alerta("ERROR", "Error al obtener referencias!", "2");
                    }, 900)
                }
            }
        });
    }

    var listarUsuariosActivos = function(){
        Cargando(1);
        $.ajax({
            url: "Cambiar_Cargo/listaUsuarios",
            datatype: "json",
            type: "post",
            async: true,
            data: {
            },
            success: function (data) {
                Cargando(0);
                oTable_Data_Usuario.fnClearTable();
                if (data.length>0) {
                    oTable_Data_Usuario.fnAddData(data);
                } else {
                    Alerta("ATENCIÓN", "No se encontró ninguna Area habilitada", 4);
                } 
            },
            timeout: 20000,
            error: function(request, status, err) {
                if (status == "timeout") {
                    setTimeout(function () {
                        Cargando(0);
                        Alerta("ERROR", "Tardo el tiempo de petición!", "2");
                    }, 900)
                } else {
                    setTimeout(function () {
                        Cargando(0);
                        Alerta("ERROR", "Error al obtener referencias!", "2");
                    }, 900)
                }
            }
        });
    }

    var eventos = function () {

        listarEncargados();
        listarUsuariosActivos();
        $("#btnGuardarDato").click(function () {
            $(this).blur();
            editar_Datos();
        });
        
        $("#btnGuardarDato_Usuario").click(function () {
            $(this).blur();
            guardar_cambio_area();
        });
        

        $('#tbl_listar_documentos tbody').on('click', '.btnEditar', function () {
            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data.fnGetData(pos);
            $("#sp_doc_ref").text(data.NOMBREAREA);
            $("#txtFechaCrea").text(data.FECHACREACION);
            $("#txtEncargadoActual").val(data.NOMBREENCARGADO);
            $("#txtSiglasActual").val(data.SIGLA_AREA);
            idRepreAnterior = data.IDENCARGADO; 
            organigrama     = data.IDORGANIGRAMA;
            if(data.ESTADOAREA ==1){ 
                $("#txtEstado").css("color", "#1ab394");
                $("#txtEstado").css("font-weight", "bold");
                $("#txtEstado").text("HABILITADO");
            }else{
                $("#txtEstado").css("color", "#ed5565");
                $("#txtEstado").css("font-weight", "bold");
                $("#txtEstado").text("DESHABILITADO");
            }
            $("#modal_areas").modal("show");
            
        });

        $('#tbl_listar_usuarios tbody').on('click', '.btnEditar_usuario', function () {
            var pos = oTable_Data_Usuario.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_Data_Usuario.fnGetData(pos);
            idUsuario = data.NCODIGO;
            $("#area_actual").val('');
            $("#jefe_area").val('');
            $("#sigla_usuario").val('');
            obtengo_jefe_area(data.WF_ORGANIGRAMA,data.NCODIGO, data.TIPOUSER);
            $("#modal_usuarios").modal("show");
        });

    };

    var guardar_cambio_area = function(){
        var dato =  $("#sel_AreaCambiar").val();
        if(dato=='N'){
            Alerta("Alerta!!!", "No ha seleccionado el area !!!", "4");
        }else{
            var sigla =  ($("#sigla_usuario").val()).trim();
            if(sigla==''){
                (sigla == '') ? $('#sigla_usuario').css('border-color','red') : $('#sigla_usuario').css('border-color','') ;
            }else{
                $('#sigla_usuario').css('border-color','');
                $.ajax({
                    url: "CambiarUser/setDatosArea",
                    datatype: "json",
                    type: "post",
                    data: {
                        "organigrama" : dato,
                        "sigla"       : sigla,
                        "usuario"     : idUsuario
                    },
                    success: function (data) {
                        if (!isEmpty(data)) {
                            if(data.resultado){
                                $("#modal_usuarios").modal("hide");
                                Alerta("EXITO !!!", data.mensaje, "1");
                                listarUsuariosActivos();
                            }else{
                                Alerta("ALERTA !!!", data.mensaje, "4");
                            }
                        }    
                    },
                    error: function (msg) {
                        setTimeout(function () {
                            Cargando(0);
                            $("#btnGuardar").attr("disabled", false);
                            Alerta("ERROR", "Error al guardar Dcoumento Interno!", "2");
                        }, 900)
                    }
                });
            }
            
        }
    }

    var obtengo_jefe_area = function(WF_ORGANIGRAMA, CODIGO, TIPOUSER){
        if(WF_ORGANIGRAMA != null){
            $.ajax({
                url: "CambiarUser/getAreaInicial",
                datatype: "json",
                type: "post",
                data: {
                    "organigrama"    : WF_ORGANIGRAMA,
                    "codigo"         : CODIGO,
                    "tipo_usuario"   : TIPOUSER
                },
                success: function (data) {
                    if (!isEmpty(data)) {
                       console.log(data);
                       $("#area_actual").val(data.jefatura[0]['NOMBREAREA']);
                       $("#jefe_area").val(data.jefatura[0]['NNOMBRE']);
                       $("#sigla_usuario").val(data.jefatura[0]['SIGLA_WORKFLOW']);
                       var html = "<option value='N'>Selecciona una persona</option>";
                       $.each(data.areas, function (index, item) {
                        html += '<option value="' + item.IDORGANIGRAMA + '">' + item.NOMBREAREA + '</option>';
                       });
                       $("#sel_AreaCambiar").html(html);
                       //$("#sel_AreaCambiar").select2();
                    }

                },
                error: function (msg) {
                    setTimeout(function () {
                        Cargando(0);
                        $("#btnGuardar").attr("disabled", false);
                        Alerta("ERROR", "Error al guardar Dcoumento Interno!", "2");
                    }, 900)
                }
            });
        }else{
            $("#area_actual").val('----------');
            $("#jefe_area").val('----------');
        }
    }

    var editar_Datos = function(){
        var Siglas = ($("#txtSiglasActual").val()).trim();
        if(Siglas ==''){
            (Siglas == '') ? $('#txtSiglasActual').css('border-color','red') : $('#txtSiglasActual').css('border-color','') ;
        }else{
            $('#txtSiglasActual').css('border-color','');
            var representante = $('#cbo_nuevo_representante').val();
            Cargando(1);
            $.ajax({
                url: "CambiarUser/Update",
                datatype: "json",
                type: "post",
                data: {
                    "repre_Anterior" : idRepreAnterior,
                    "repre_Actual"   : representante,
                    "organigrama"    : organigrama,
                    "siglas"         : Siglas
                },
                success: function (data) {
                    if (!isEmpty(data)) {
                        listarEncargados();
                        Alerta("EXITO !!!", "Se cambio el cargo de manera correcta!", "1");
                        $("#modal_areas").modal("hide");
                        Cargando(0);
                    }

                },
                error: function (msg) {
                    setTimeout(function () {
                        Cargando(0);
                        $("#btnGuardar").attr("disabled", false);
                        Alerta("ERROR", "Error al guardar Dcoumento Interno!", "2");
                    }, 900)
                }
            });
        }
    }

    var plugins = function () {
        
        $("#cbo_nuevo_representante").select2({
                placeholder: "Selecciona opción...",
                dropdownParent: $("#modal_areas")});
        $("#sel_AreaCambiar").select2({
                placeholder: "Selecciona opción...",
                dropdownParent: $("#modal_usuarios")});
        
    };

    var variableGlobal = function(){
        idRepreAnterior = '';
        organigrama     = '';
        idUsuario       = '';
    }

    return {
        init: function () {
            plugins();
            variableGlobal();
            initDatables();
            initDatables_Usuarios();
            eventos();
        }
    };
}();



