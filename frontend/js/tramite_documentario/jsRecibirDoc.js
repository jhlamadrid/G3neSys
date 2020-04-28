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


var RECIBIR = function () {


    var initDatables = function () {
        var parms = {
            data: null,
            info: false,
            searching: true,
            paging: true,
            fixedHeader: true,
            ordering: false,
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data) {
                        var cadena ='';
                        if (data.INDCOPIA == 1) {
                            cadena = cadena+ "<span  style='font-size: 1.3em;'> \n\
                                        <i style='color: #4caf50;' class='fa fa-file'></i>\n\
                                    </span>";
                        }  
                        if(data.IDMOVIMIDERIVADO !=0){
                            //console.log(data.IDMOVIMIDERIVADO);
                            cadena = cadena+ "<span  style='font-size: 1.3em;'> \n\
                                    <i style='color: #e41d20;' class='fa fa-file'></i>\n\
                                </span>";
                        }
                            
                        if(data.TIPO_EXTERNO !=0){
                            //console.log(data.IDMOVIMIDERIVADO);
                            cadena = cadena+ "<span  style='font-size: 1.3em;'> \n\
                                    <i style='color: #f0ad4e;' class='fa fa-file'></i>\n\
                                </span>";
                        }
                        
                        return cadena;

                    }
                },

                {data:null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data) {
                        var cadena = data.NOMBREDOCUMENTO +' Nro. <span style="color:#E91E63" > ' + data.NUMERODOCUMENTO + ' - '+ data.ANIO + '</span> - SEDALIB S.A. - ' + data.SIGLA_AREA;
                        if(data.SIGLAS_PERSONAL != null){
                            
                            cadena = cadena + '/' +  data.SIGLAS_PERSONAL;
                        }
                        return cadena;

                    }
                },
                {data: "FOLIOS",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '17px');
                        $(td).css('color', '#E91E63');
                        $(td).css('font-weight', 'bold');

                    }
                },
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "FECHACREACION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "FECHAMAXATENCION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center ');
                        $(td).css('font-size', '20px');
                        $(td).css('color', '#337AB7');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data, type, full, meta){

                        if(data.FECHACREACIONF == null || data.FECHAMAXATENCIONF == null){
                            return "";
                        }else{
                            var dias = restaFechas( data.FECHACREACIONF, data.FECHAMAXATENCIONF);
                            return dias;
                        }
                        
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                    },
                    render: function (data, type, full, meta) {
                        var cade= '<button type="button" class="btnRec btn btn-success "  data-toggle="tooltip" data-placement="bottom" title="Recibir"><i class="fa fa-check"></i></button>\n\
                                <button type="button" class="btnVerRef btn btn-warning " data-toggle="tooltip" data-placement="bottom" title="Referencias"><i class="fa fa-sitemap"></i></button>\n\
                                <button type="button" class="btnVerDet btn btn-primary " data-toggle="tooltip" data-placement="bottom" title="Detalle Documento"><i class="fa fa-search"></i></button>\n\
                                <button type="button" class="btnAdjuntos btn btn-primary tooltips" title="Adjuntos"><i class="fa fa-paperclip"></i></button>';
                        if(data.IDMOVIMIDERIVADO !=0){
                            cade = cade + '\n\ <button type="button" class="btnDevoDeri btn btn-danger "  data-toggle="tooltip" data-placement="bottom" title="Devolver Derivado"><i class="fa fa-share"></i></button>'
                        }
                        return cade;
                    }
                }
            ]
        }
        oTable_Data = $("#tbl_sis_recibir").dataTable(parms);
        $("#tbl_sis_recibir_filter").hide();


        var table = $('#tbl_sis_recibir').DataTable();
        $('#txt_buscar').on('keyup', function () {
            table.search(this.value).draw();
        });
    }


    var initDatablesAdjuntos = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: "adjunto",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: null, className: 'dt-body-center',
                   render: function (data, type, full, meta) {
                        return '<a href="'+data.ruta+'" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>' }
                }
            ]
        }
        oTable_adjuntos = $("#tbl_docint_adjuntos").dataTable(parms);
    };
    var initDatablesAdjuntosRefe = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: "adjunto",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: null, className: 'dt-body-center',
                   render: function (data, type, full, meta) {
                        return '<a href="'+data.ruta+'" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>' }
                }
            ]
        }
        oTable_adjuntosRefe = $("#tbl_docint_adjuntos_refe").dataTable(parms);
    };

    var initDatablesRecepcionados = function () {
        var parms = {
            data: null,
            info: false,
            searching: true,
            paging: true,
            fixedHeader: true,
            ordering: false,
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data) {
                        var cadena ='';
                        if (data.INDCOPIA == 1) {
                            cadena = cadena+ "<span  style='font-size: 1.3em;'> \n\
                                        <i style='color: #4caf50;' class='fa fa-file'></i>\n\
                                    </span>";
                        }  
                        if(data.IDMOVIMIDERIVADO !=0){
                            //console.log(data.IDMOVIMIDERIVADO);
                            cadena = cadena+ "<span  style='font-size: 1.3em;'> \n\
                                    <i style='color: #e41d20;' class='fa fa-file'></i>\n\
                                </span>";
                        }
                            
                        if(data.TIPO_EXTERNO !=0){
                            //console.log(data.IDMOVIMIDERIVADO);
                            cadena = cadena+ "<span  style='font-size: 1.3em;'> \n\
                                    <i style='color: #f0ad4e;' class='fa fa-file'></i>\n\
                                </span>";
                        }
                        
                        return cadena;

                    }
                },

                {data:null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data) {
                        var cadena = data.NOMBREDOCUMENTO +' Nro. <span style="color:#E91E63" > ' + data.NUMERODOCUMENTO + ' - '+ data.ANIO + '</span> - SEDALIB S.A. - ' + data.SIGLA_AREA;
                        if(data.SIGLAS_PERSONAL != null){
                        
                            cadena = cadena + '/' +  data.SIGLAS_PERSONAL;
                        }
                        return cadena;

                    }
                },
                
                {data: "FOLIOS",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '17px');
                        $(td).css('color', '#E91E63');
                        $(td).css('font-weight', 'bold');

                    }
                },
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "FECHACREACION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "FECHAMAXATENCION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center ');
                        $(td).css('font-size', '20px');
                        $(td).css('color', '#337AB7');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data, type, full, meta){

                        if(data.FECHACREACIONF == null || data.FECHAMAXATENCIONF == null){
                            return "";
                        }else{
                            var dias = restaFechas( data.FECHACREACIONF, data.FECHAMAXATENCIONF);
                            return dias;
                        }
                        
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                    },
                    render: function (data, type, full, meta) {
                        var estado = $("#chkArchivados").is(":checked");
                        if(estado){
                            return '<button type="button" class="btnDesArchivar btn btn-danger " data-toggle="tooltip" data-placement="bottom" title="Desarchivar"><i class="fa fa-folder-open-o"></i></button>'
                            
                        }else{
                            return '<button type="button" class="btnDerivar btn btn-success " data-toggle="tooltip" data-placement="bottom" title="Proveer"><i class="fa fa-exchange"></i></button>\n\
                                 <button type="button" class="btnVerDet btn btn-primary " data-toggle="tooltip" data-placement="bottom" title="Detalle Documento"><i class="fa fa-search"></i></button>\n\
                                 <button type="button" class="btnAdjuntosRecepcionado btn btn-primary tooltips" title="Adjuntos"><i class="fa fa-paperclip"></i></button>\n\
                                 <button type="button" class="btnDevolver btn btn-danger " data-toggle="tooltip" data-placement="bottom" title="Devolver"><i class="fa fa-arrow-left"></i></button>\n\
                                 <button type="button" class="btnRefReci btn btn-warning " data-toggle="tooltip" data-placement="bottom" title="Referencias"><i class="fa fa-sitemap"></i></button>\n\
                                 <button type="button" class="btnArchivar btn btn-danger " data-toggle="tooltip" data-placement="bottom" title="Archivar"><i class="fa fa-briefcase"></i></button>';
                        }
                        
                    }
                }
            ]
        }
        oTable_Data_R = $("#tbl_sis_recepcionados").dataTable(parms);
        $("#tbl_sis_recepcionados_filter").hide();


        var table = $('#tbl_sis_recepcionados').DataTable();
        $('#txt_buscar_recep').on('keyup', function () {
            table.search(this.value).draw();
        });
    };

    var initDatablesRefs = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            paging: false,
            fixedHeader: true,
            ordering: false,
            columns: [
                {data: null, // "NOMBREDOCUMENTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = data.NOMBREDOCUMENTO+' Nro. <span  style="color:#e41d20;">  '+data.NUMERODOCUMENTO+' - '+data.ANIO+' </span> - '+'SEDALIB S.A. - '+ data.SIGLA_AREA;
                        if(data.SIGLAS_PERSONAL != null){
                            
                            cadena = cadena + '/' +  data.SIGLAS_PERSONAL;
                        }
                        return cadena;
                    }
                },
                {data: "ASUNTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '12px');
                        $(td).css('color', '#000000');
                        $(td).css('font-weight', 'bold');

                    }
                },
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('color', '#E91E63');
                        $(td).css('font-weight', 'bold');

                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnAdjuntos_red btn btn-primary tooltips" title="Archivos adjuntos"><i class="fa fa-paperclip"></i></button>';
                    }
                }
            ]
        }
        oTable_Refs = $("#tbl_referencias").dataTable(parms);
    }

    
    var ListarAdjuntosReferencia = function (cod_doc) {


        Cargando(1);
        $.ajax({
            url: "Recibir/getAdjuntos",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddoc": cod_doc
            },
            success: function (data) {
                Cargando(0);
                oTable_adjuntosRefe.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_adjuntosRefe.fnAddData(data);
                    $('#modalArchivosRefe').modal('show');
                }else{
                    //Alerta("ALERTA", "No se subio archivos del Documento", "4");
                    $('#modalArchivosRefe').modal('show');
                }
                
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener adjuntos!", "2");
                }, 900)
            }
        });
        
        
    }



    var eventos = function () {


        $("#btnFiltrar").click(function () {
            $(this).blur();
            var metodo = $(this).attr('metodo');
            ListarDocsXRecibirFiltro(metodo);
        
        });
        $("#cerrarArchiDocRef").click(function () {
            $('#modal_refs').modal('show');
            $('#modalArchivosRefe').modal('hide');
        });

        $('#tbl_referencias tbody').on('click', '.btnAdjuntos_red', function () {
            var pos = oTable_Refs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_Refs.fnGetData(pos);
            $('#modal_refs').modal('hide');
            ListarAdjuntosReferencia(data.IDDOCUMENTO);
        });


        $("#btnArchivar").click(function () {
            $(this).blur();
            var cod = $("#btnArchivar").attr("mov");
            cod = cod * 1;
            ArchivarDocumento(cod);
        });

        $("#btnDevolver").click(function () {
            $(this).blur();
            var cod = $("#btnDevolver").attr("mov");
            cod = cod * 1;
            devolverDocumento(cod);
        });


        $("#chkArchivados").click(function () {
            var estado = $("#chkArchivados").is(":checked");
            if (estado) {
                $("#btnFiltrar").attr('metodo', 'archivados');
                ListarDocsArchivados();
            } else {
                $("#btnFiltrar").attr('metodo', 'derivar');
                ListarDocsRecepcionados();
            }
        });




        $("#btnConfirmRecibir").click(function () {
            $(this).blur();
            var cod = $("#btnConfirmRecibir").attr("cod_mov");
            var tipo_mov_realiza =$("#btnConfirmRecibir").attr("tipo_mov_realiza"); 
            cod = cod * 1;
            console.log(tipo_mov_realiza);
            ActualizarRecibirDocumento(cod, tipo_mov_realiza);
        });

        $("#btnConfirmDesarchivar").click(function () {
            $(this).blur();
            var cod = $("#btnConfirmDesarchivar").attr("cod_mov");
            cod = cod * 1;
            DesarchivarDocumento(cod);
        });
		
		  $("#btnAdicionarFolios").click(function () {
            $(this).blur();
			 $("#divFoliosProveido").show();
			
        });

        $('input[name=btnliper_area]').change(function(){
            var valor = $( 'input[name=btnliper_area]:checked' ).val();
            if(valor=='P'){ // listo el personal del area
                Listar_personal_x_dependencia(persona_envia);
            }else{ // listo las areas 
                Listar_dependencia2();
            }
        });


        $("#btnDerivar").click(function () {
            $(this).blur();
            var valor = $("#cmbPersonalA").val();
            if (valor === 'N') {
                Alerta("ALERTA", "SELECCIONES AL PERSONAL PRIMERO", "4");
                return;
            }

            $("#btnDerivar").attr('disabled', true);
            var cod = $("#btnDerivar").attr("mov");
            DerivarDocumento(cod);
        });

        $("#txt_nroDocumento").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
		
		  $("#txtFoliosDeriva").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('#tbl_sis_recepcionados tbody').on('click', '.btnAdjuntosRecepcionado', function () {
            var pos = oTable_Data_R.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_Data_R.fnGetData(pos);
            console.log(data);
            ListarAdjuntos(data.IDDOCUMENTO);
        });

        $('#tbl_sis_recibir tbody').on('click', '.btnAdjuntos', function () {

            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_Data.fnGetData(pos);
            console.log(data);
            ListarAdjuntos(data.IDDOCUMENTO);
        });

        $('#tbl_sis_recibir tbody').on('click', '.btnRec', function () {
            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                data = oTable_Data.fnGetData(pos);
            $("#titulo_envia_devolver").text("¿Está seguro que desea recibir?");
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.SIGLA_AREA +autor);
            $("#sp_area").html(data.NOMBREAREA);
            $("#sp_folios").html(data.FOLIOS + ' FOLIOS');
            $("#btnConfirmRecibir").text("RECIBIR");
            $("#btnConfirmRecibir").attr("cod_mov", data.IDMOVIMIENTO);
            $("#btnConfirmRecibir").attr("tipo_mov_realiza", 0);
            $("#modal_info").modal("show");

        });

        $('#tbl_sis_recibir tbody').on('click', '.btnDevoDeri', function () {
            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                data = oTable_Data.fnGetData(pos);
            $("#titulo_envia_devolver").text("¿Está seguro que desea devolver el documento derivado?");
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.SIGLA_AREA +autor);
            $("#sp_area").html(data.NOMBREAREA);
            $("#sp_folios").html(data.FOLIOS + ' FOLIOS');
            $("#btnConfirmRecibir").text("DEVOLVER");
            $("#btnConfirmRecibir").attr("cod_mov", data.IDMOVIMIENTO);
            $("#btnConfirmRecibir").attr("tipo_mov_realiza", 1)
            $("#modal_info").modal("show");

        });
        
        $('#tbl_sis_recibir tbody').on('click', '.btnVerDet', function () {
            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            var  mensaje ="";
            $("#sp_men_derivado").html("");
            if(data.IDMOVIMIDERIVADO !=0){
                mensaje = "(<span style ='color:#E41D20'>DERIVADO</span>)";
                $("#derivado_mensaje").show();
                $("#sp_men_derivado").html(data.MOTIVODERIVA);
            }else{
                $("#derivado_mensaje").hide();
            }
            $("#sp_doc_det").html(data.NOMBREDOCUMENTO + ' Nro. <span style ="color:#E41D20"> ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+'</span> - SEDALIB S.A. - '+ data.SIGLA_AREA +autor+ " &nbsp; &nbsp;" + mensaje );
            $("#sp_asunto").html("");
            $("#sp_procedimiento").html("");
            $("#sp_fe_emision").html("");
            $("#sp_max_atencion").html("");
            $("#sp_dias_atencion").html("");
            $("#sp_asunto").html(data.ASUNTO);
            $("#sp_procedimiento").html(data.OBSERVACIONES);
            $("#sp_fe_emision").html(data.FECHACREACION);
            if(data.FECHAMAXATENCION == null){
                $("#sp_max_atencion").html("");
                $("#sp_dias_atencion").html("");
            }else{
                $("#sp_max_atencion").html(data.FECHAMAXATENCION);
                var  dias = restaFechas (fecha_actual, data.FECHAMAXATENCIONF);
                // var  dias = restaFechas (fecha_actual, '2020-01-10');
                if(dias > 2){
                    $("#sp_dias_atencion").css("color", "#0055A5");
                    $("#sp_dias_atencion").html( 'Quedan '+ dias + ' dias');
                }else{
                    if(dias<=2 && dias>=0){
                        $("#sp_dias_atencion").css("color", "#E08E0B");
                        $("#sp_dias_atencion").html( 'Quedan '+ dias + ' dia(s)');
                    }else{
                        $("#sp_dias_atencion").css("color", "#FF6961");
                        $("#sp_dias_atencion").html( 'Pasaron '+ -1*dias + ' dia(s)');
                    }
                }
            }
            
            console.log(dias);
            $("#modal_detalle").modal("show");

        });

        $('#tbl_sis_recepcionados tbody').on('click', '.btnDevolver', function () {
            var pos = oTable_Data_R.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data_R.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc_devolver").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.SIGLA_AREA + autor);
            $("#sp_area_devolver").html(data.NOMBREAREA);
            $("#sp_folios_devolver").html(data.FOLIOS + ' FOLIOS');
            $("#btnDevolver").attr("mov", data.IDMOVIMIENTO);
            $("#btnDevolver").attr('disabled', false);
            $("#modal_devolver").modal("show");

        });



        $('#tbl_sis_recepcionados tbody').on('click', '.btnDerivar', function () {
            var pos = oTable_Data_R.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data_R.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            console.log(data);
            $("#sp_doc_dev").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.SIGLA_AREA + autor);
            $("#btnDerivar").attr("mov", JSON.stringify(data));
            $("#btnDerivar").attr('disabled', false);
            $("#txtMotivoDeriva").val("");
			$("#txtNotaDeriva").val("");
			$("#txtFoliosDeriva").val("");
            $("#divFoliosProveido").hide();
            persona_envia = data.IDPERSONAENVIA;
            Listar_personal_x_dependencia(data.IDPERSONAENVIA);

        });

        $('#tbl_sis_recepcionados tbody').on('click', '.btnVerDet', function () {
            var pos = oTable_Data_R.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data_R.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            var  mensaje ="";
            $("#sp_men_derivado").html("");
            if(data.IDMOVIMIDERIVADO !=0){
                mensaje = "(<span style ='color:#E41D20'>DERIVADO</span>)";
                $("#derivado_mensaje").show();
                $("#sp_men_derivado").html(data.MOTIVODERIVA);
            }else{
                $("#derivado_mensaje").hide();
            }
            $("#sp_doc_det").html(data.NOMBREDOCUMENTO + ' Nro. <span style ="color:#E41D20"> ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' </span> - SEDALIB S.A. - '+ data.SIGLA_AREA + autor + " &nbsp; &nbsp;" + mensaje);
            $("#sp_asunto").html("");
            $("#sp_procedimiento").html("");
            $("#sp_fe_emision").html("");
            $("#sp_max_atencion").html("");
            $("#sp_dias_atencion").html("");
            $("#sp_asunto").html(data.ASUNTO);
            $("#sp_procedimiento").html(data.OBSERVACIONES);
            $("#sp_fe_emision").html(data.FECHACREACION);
            if(data.FECHAMAXATENCION == null){
                $("#sp_max_atencion").html("");
                $("#sp_dias_atencion").html("");
            }else{
                $("#sp_max_atencion").html(data.FECHAMAXATENCION);
                var  dias = restaFechas (fecha_actual, data.FECHAMAXATENCIONF);
                // var  dias = restaFechas (fecha_actual, '2020-01-10');
                if(dias > 2){
                    $("#sp_dias_atencion").css("color", "#0055A5");
                    $("#sp_dias_atencion").html( 'Quedan '+ dias + ' dias');
                }else{
                    if(dias<=2 && dias>=0){
                        $("#sp_dias_atencion").css("color", "#E08E0B");
                        $("#sp_dias_atencion").html( 'Quedan '+ dias + ' dia(s)');
                    }else{
                        $("#sp_dias_atencion").css("color", "#FF6961");
                        $("#sp_dias_atencion").html( 'Pasaron '+ -1*dias + ' dia(s)');
                    }
                }
            }
            
            $("#modal_detalle").modal("show");

        });


        $('#tbl_sis_recepcionados tbody').on('click', '.btnRefReci', function () {
            var pos = oTable_Data_R.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_Data_R.fnGetData(pos);
            //console.log(data);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc_ref").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.SIGLA_AREA+ autor);
            ListarDocsReferencias(data.IDMOVIMIENTO, data.IDDOCUMENTO);
        });

        $('#tbl_sis_recepcionados tbody').on('click', '.btnArchivar', function () {
            var pos = oTable_Data_R.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_Data_R.fnGetData(pos);
            var autor ="";
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#btnArchivar").attr("mov", data.IDMOVIMIENTO);
            $("#sp_doc_arch").html(data.NOMBREDOCUMENTO + ' Nro. <span style ="color:#E41D20"> ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+'</span> - SEDALIB S.A. - '+ data.SIGLA_AREA +autor );
            console.log($("#btnArchivar").attr("mov"));
            $("#modal_archivar").modal("show");
        });

        


        $('#tbl_sis_recepcionados tbody').on('click', '.btnDesArchivar', function () {
            var pos = oTable_Data_R.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data_R.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc_desarch").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.SIGLA_AREA + autor);
            $("#sp_area_desarch").html(data.NOMBREAREA);
            $("#sp_folios_desarch").html(data.FOLIOS + ' FOLIOS');
            $("#btnConfirmDesarchivar").attr("cod_mov", data.IDMOVIMIENTO);

            $("#modal_info_desarchivar").modal("show");

        });


        $('#tbl_sis_recibir tbody').on('click', '.btnVerRef', function () {
            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc_ref").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.SIGLA_AREA+ autor);
            ListarDocsReferencias(data.IDMOVIMIENTO, data.IDDOCUMENTO);

        });

        $('#tabs_listas li').on('click', function () {
            var id = $(this).attr("id");
            if (id === 'li1') {
                $("#btnFiltrar").attr('metodo', 'recibir');

            } else if (id === 'li2') {

                $("#btnFiltrar").attr('metodo', 'recibidos');

            }
        });

    };

    var obtener_fecha_actual = function(){
        $.ajax({
            type: "POST",
            url: "fecha_actual?ajax=true",
            data: {
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    fecha_actual= data.fecha;
                    fecha_actual_2= data.fechaformato2;
                    $("#NSUM-INI").val(fecha_actual_2);
            
                    $('#NSUM-INI').daterangepicker({
                        "showDropdowns": true,
                        "autoApply": true,
                        "parentEl": $('#modal_derivar'), 
                        "timePickerIncrement": 1,
                        "singleDatePicker": true,
                        "timePicker": false,
                        "timePicker12Hour": false,
                        "timePicker24Hour": false,
                        "timePickerSeconds": false,
                        "autoclose": true,
                        "format": "DD-MM-YYYY",
                        "startDate": fecha_actual_2,
                        "minDate": fecha_actual_2,
                        "locale": {
                            "format": "DD-MM-YYYY",
                            "separator": " - ",
                            "applyLabel": "Aceptar",
                            "cancelLabel": "Cancelar",
                            "fromLabel": "From",
                            "toLabel": "To",
                            "customRangeLabel": "Custom",
                            "autoclose": true,
                            "daysOfWeek": [
                                "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"
                            ],
                            "monthNames": [
                                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                                "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                            ],
                            "firstDay": 1
                        }//,
                        //onSelect: function() {  alert("dd"); }
                    });
                }
            }
        });
    }
    var restaFechas = function(f1,f2)
    {
        var fechaini = new Date(f1);
        var fechafin = new Date(f2);
        var diasdif= fechafin.getTime()-fechaini.getTime();
        var contdias = Math.round(diasdif/(1000*60*60*24));
        return contdias;
        
    }

    var ListarAdjuntos = function (cod_doc) {

        $.ajax({
            url: "Recibir/getAdjuntos",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddoc": cod_doc
            },
            success: function (data) {
                oTable_adjuntos.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_adjuntos.fnAddData(data);
                    $('#modalArchivos').modal('show');
                }else{
                    Alerta("ALERTA", "No se subio archivos del Documento", "4");
                }
                
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener adjuntos!", "2");
                }, 900)
            }
        });
    }

    var ListarDocsXRecibir = function () {

        Cargando(1);
        $.ajax({
            url: "Recibir/getDocsRecibirUsuario",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                oTable_Data.fnClearTable();
                if (data.length > 0) {
                    oTable_Data.fnAddData(data);
                }
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    }

    var ListarDocsXRecibirSuccess = function (r) {


        $.ajax({
            url: "Recibir/getDocsRecibirUsuario",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                oTable_Data.fnClearTable();
                if (data.length > 0) {
                    oTable_Data.fnAddData(data);
                }

                if (r.respuesta === 'ok') {
                    ListarDocsRecepcionados();
                    Alerta("LISTO", "Se completo la recepción de documento(s).", "1");
                } else if (r.respuesta === 'del') {
                    Alerta("Atencion", "No fue posible recibir, el movimiento ha sido eliminado", 4);
                } else if (r.respuesta === 'rec') {
                    Alerta("Atencion", "No fue posible recibir, el documento ya se ha recibido anteriormente", 4);
                } else {
                    Alerta("ERROR", "No se pudo derivar los documentos.", "2");
                }


            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    }

    var ListarDocsXRecibirFiltro = function (metodo ) {

        Cargando(1);
        var numero = $("#txt_nroDocumento").val() === '' ? '%' : $("#txt_nroDocumento").val();
        var estado = $("#chkArchivados").is(":checked");
        var archivados = estado;
            $.ajax({
                url: "Recibir/getDocsRecibirUsuarioFiltro",
                datatype: "json",
                type: "post",
                async: true,
                data: {
                    "numero": numero,
                    "metodo":metodo,
                    "archivado" : archivados,
                    "anio": $("#cbo_comboAnio").val()
                },
                success: function (data) {
                    Cargando(0);
                    if(metodo =='recibir'){
                        oTable_Data.fnClearTable();
                        if (data.length > 0) {
                            oTable_Data.fnAddData(data);
                        }
                    }else{
                        oTable_Data_R.fnClearTable();
                        if (data.length > 0) {
                            oTable_Data_R.fnAddData(data);
                        }
                    }
                    
                },
                error: function (msg) {
    
                    setTimeout(function () {
                        Cargando(0);
                        Alerta("ERROR", "Error al obtener documentos!", "2");
                    }, 900)
                }
            });  
    };

    var ListarDocsXDerivarFiltro = function () {

        Cargando(1);
        var numero = $("#txt_nroDocumento").val() === '' ? '%' : $("#txt_nroDocumento").val();
        $.ajax({
            url: "Recibir/getDocsDerivarUsuarioFiltro",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "numero": numero,
                "anio": $("#cbo_comboAnio").val()
            },
            success: function (data) {
                Cargando(0);
                oTable_Data_R.fnClearTable();
                if (data.length > 0) {
                    oTable_Data_R.fnAddData(data);
                    $('[data-toggle="tooltip"]').tooltip();
                    $(".btnDerivar").show();
                    $(".btnVerDet").show();
                    $(".btnArchivar").show();
                    $(".btnDevolver").show();
                    $(".btnDesArchivar").hide();
                }
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    }


    var ListarDocsXArchivadosFiltro = function () {

        Cargando(1);
        var numero = $("#txt_nroDocumento").val() === '' ? '%' : $("#txt_nroDocumento").val();
        $.ajax({
            url: "Recibir/getDocsArchivadosUsuarioFiltro",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "numero": numero,
                "anio": $("#cbo_comboAnio").val()
            },
            success: function (data) {
                Cargando(0);
                oTable_Data_R.fnClearTable();
                if (data.length > 0) {
                    oTable_Data_R.fnAddData(data);
                    $('[data-toggle="tooltip"]').tooltip();
                    $(".btnDerivar").hide();
                    $(".btnVerDet").hide();
                    $(".btnArchivar").hide();
                    $(".btnDevolver").hide();
                    $(".btnDesArchivar").show();
                }
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    }


    var ActualizarRecibirDocumento = function (idMovimiento, tipo_mov_realiza) {
        $("#modal_info").modal("hide");
        Cargando(1);
        $.ajax({
            url: "Recibir/recibirDocumento",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": idMovimiento,
                "tipo_mov_realiza" : tipo_mov_realiza
            },
            success: function (data) {
                //Cargando(0);
                
                ListarDocsXRecibirSuccess(data);
                

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al actualizar documentos por recibir!", "2");
                }, 900);
            }
        });

    };


    var DesarchivarDocumento = function (idMovimiento) {
        $("#modal_info_desarchivar").modal("hide");
        Cargando(1);

        $.ajax({
            url: "Recibir/desArchivarDocumento",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": idMovimiento
            },
            success: function (data) {
                if (!isEmpty(data)) {
                    Cargando(0);
                    ListarDocsArchivados();
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al desarchivar el documento!", "2");
                }, 900);
            }
        });

    };


    var ArchivarDocumento = function (idMovimiento) {
        $("#modal_archivar").modal("hide");
        Cargando(1);
        $.ajax({
            url: "Recibir/archivarDocumento",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": idMovimiento,
                "obs": $("#txtMotivoArch").val()
            },
            success: function (data) {
                Cargando(0);
                if (!isEmpty(data)) {
                    ListarDocsRecepcionados();
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al archivar documentos!", "2");
                }, 900);
            }
        });

    };

    var devolverDocumento = function (idMovimiento) {
        $("#modal_devolver").modal("hide");
        Cargando(1);
        $.ajax({
            url: "Recibir/devolverDocumento",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": idMovimiento
            },
            success: function (data) {
                Cargando(0);
                listDocsRecepPostDevolucion(data);
                
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al devolver documentos!", "2");
                }, 900);
            }
        });

    };




    var DerivarDocumento = function (movimiento) {
        $("#modal_derivar").modal("hide");
        Cargando(1);
        var fecha_maxima = $("#NSUM-INI").val();
        var tipo_envio ='';
        if(tipo_cargo== 0){ // es Gerente
            tipo_envio = 'P';
        }else{
            tipo_envio = $( 'input[name=btnliper_area]:checked' ).val();
        }
        $.ajax({
            url: "Recibir/derivarDocumento",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "mov_dev": movimiento,
                "dni_dev": $("#cmbPersonalA").val(),
                "obs": $("#txtMotivoDeriva").val(),
				"nota": $("#txtNotaDeriva").val(),
                "folios_adicionales": ($("#txtFoliosDeriva").val() == '' ? 0 :  ($("#txtFoliosDeriva").val()*1)),
                "fecha_maxima" : fecha_maxima,
                "tipo_envio": tipo_envio
            },
            success: function (data) {
                Cargando(0);
                if (data) {
                    ListarDocsXRecibir();
                    ListarDocsRecepcionados();
                    
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al actualizar documentos por derivar!", "2");
                }, 900);
            }
        });

    };

    var ListarDocsReferencias = function (idMovimiento, cod_doc) {
        //console.log(idMovimiento, cod_doc);
        Cargando(1);
        $.ajax({
            url: "Recibir/getReferenciasDocRecibir",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": idMovimiento,
                "cod_doc": cod_doc
            },
            success: function (data) {
                Cargando(0);
                console.log(data);
                oTable_Refs.fnClearTable();
                if (data.length>0) {
                    oTable_Refs.fnAddData(data);
                    $("#modal_refs").modal("show");
                } else {
                    Alerta("ATENCION", "El documento no posee referencias", 4);
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



    var fillAnios = function () {
        var currentYear = (new Date).getFullYear();
        for (var i = currentYear; i >= 1980; i--) {
            $('#cbo_comboAnio').append("<option value='" + (i) + "'>" + (i) + "</option");
        }


    };


    var ListarDocsRecepcionados = function () {

        Cargando(1);
        $.ajax({
            url: "Recibir/getDocsRecepcionados",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                oTable_Data_R.fnClearTable();
                if (data.length > 0) {
                    oTable_Data_R.fnAddData(data);
                }
                $('[data-toggle="tooltip"]').tooltip();
                $(".btnDesArchivar").hide();
                $("#chkArchivados").prop('checked', false);
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    };


    var ListarDocsArchivados = function () {

        Cargando(1);
        $.ajax({
            url: "Recibir/getDocsArchivados",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                oTable_Data_R.fnClearTable();
                if (data.length > 0) {
                    oTable_Data_R.fnAddData(data);
                }
                

            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    };
    var Listar_dependencia2 = function () {
        Cargando(1);
        $.ajax({
            url: "CrearInterno/Listar_dependencias_internos",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                var html = "<option value='N'>Selecciona un destinatario</option>";
                $.each(data, function (index, item) {
                    html += '<option value="' + item.IDORGANIGRAMA + '" >' + item.NOMBREAREA + '</option>';
                });
                $("#cmbPersonalA").html(html);
                $("#cmbPersonalA").select2();

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la listar dependencias!", "2");
                }, 900)
            }
        });
    };

    var Listar_personal_x_dependencia = function (movimientoPersona) {
        Cargando(1);
        $.ajax({
            url: "Recibir/Listar_personal_x_dependencia",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": movimientoPersona
            },
            success: function (data) {
                Cargando(0);
                var html = "<option value='N'>Selecciona un destinatario</option>";
                $.each(data, function (index, item) {
                    if(item.VENCIDO == 0){
                        html += '<option value="' + item.NCODIGO + '" cod_depen="' + item.WF_ORGANIGRAMA + '" >' + item.NNOMBRE + '</option>';
                    }
                    
                });
                $("#cmbPersonalA").html(html);
                $("#cmbPersonalA").select2();
                $("#modal_derivar").modal("show");
                
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista del personal de la dependencia seleccionada!", "2");
                }, 900)
            }
        });
    };


    var listDocsRecepPostDerivacion = function (r) {

        Cargando(1);
        $.ajax({
            url: "Recibir/getDocsRecepcionados",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);

                oTable_Data_R.fnClearTable();
                if (data.length > 0) {
                    oTable_Data_R.fnAddData(data);
                }
                $(".btnDesArchivar").hide();

                if (r.respuesta === 'ok') {
                    Alerta("Exito", "El documento se ha derivado correctamente", 1);
                } else if (r.respuesta === 'del') {
                    Alerta("Atencion", "No fue posible derivar, el movimiento ha sido eliminado", 4);
                } else if (r.respuesta === 'env') {
                    Alerta("Atencion", "No fue posible derivar, el documento ya se ha enviado anteriormente", 4);
                } else if (r.respuesta === 'arch') {
                    Alerta("Atencion", "No fue posible derivar, el documento ya se ha archivado anteriormente", 4);
                } else {
                    Alerta("ERROR", "No se pudo derivar los documentos.", "2");
                }


            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    };


    var listDocsRecepPostDevolucion = function (r) {

        Cargando(1);
        $.ajax({
            url: "Recibir/getDocsRecepcionados",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);

                oTable_Data_R.fnClearTable();
                if (data.length > 0) {
                    oTable_Data_R.fnAddData(data);
                }
                $(".btnDesArchivar").hide();

                if (r.respuesta === 'ok') {
                    Alerta("Exito", "El documento se ha devuelto correctamente", 1);
                    ListarDocsXRecibir();
                    ListarDocsRecepcionados();
                } else if (r.respuesta === 'del') {
                    Alerta("Atencion", "No fue posible devolver, el movimiento ha sido eliminado", 4);
                } else if (r.respuesta === 'env') {
                    Alerta("Atencion", "No fue posible devolver, el documento ya se ha enviado anteriormente", 4);
                } else if (r.respuesta === 'arch') {
                    Alerta("Atencion", "No fue posible devolver, el documento ya se ha archivado anteriormente", 4);
                } else if (r.respuesta === 'srec') {
                    Alerta("Atencion", "No fue posible devolver, el documento no se ha recibido aun.", 4);
                } else {
                    Alerta("ERROR", "No se pudo devolver los documentos.", "2");
                }


            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    };


    var listDocsArchivadosPostDesArch = function (r) {

        Cargando(1);
        $.ajax({
            url: "Recibir/getDocsArchivados",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);

                oTable_Data_R.fnClearTable();
                if (data.length > 0) {
                    oTable_Data_R.fnAddData(data);
                }
                $(".btnDerivar").hide();
                $(".btnVerDet").hide();
                $(".btnArchivar").hide();
                $(".btnDevolver").hide();
                $(".btnDesArchivar").show();

                if (r.respuesta === 'ok') {
                    Alerta("Exito", "El documento se ha desarchivado correctamente", 1);
                } else if (r.respuesta === 'del') {
                    Alerta("Atencion", "No fue posible desarchivar, el movimiento ha sido eliminado", 4);
                } else if (r.respuesta === 'env') {
                    Alerta("Atencion", "No fue posible desarchivar, el documento ya se ha enviado anteriormente", 4);
                } else if (r.respuesta === 'rec') {
                    Alerta("Atencion", "No fue posible desarchivar, el documento ya se ha desarchivado anteriormente", 4);
                } else {
                    Alerta("ERROR", "No se pudo desarchivar los documentos.", "2");
                }


            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener documentos!", "2");
                }, 900)
            }
        });
    };
    var verifico_cargo= function(){
        $.ajax({
            url: "CrearInterno/verificar_cargo",
            datatype: "json",
            type: "post",
            async: false,
            success: function (data) {
                if(data){
                    tipo_cargo = 1;  // cuando el usuario esta encargado de una gerencia 
                }else{
                    $("#derivar_destinatario").hide();
                }

            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener datos!", "2");
                }, 900)
            }
        });
    }

    var datos_globales= function (){
        tipo_cargo = 0;
        fecha_actual = '';
        persona_envia= '';
    }    


    return {
        init: function () {


            initDatables();
            initDatablesRefs();
            initDatablesRecepcionados();
            initDatablesAdjuntos();
            initDatablesAdjuntosRefe();
            datos_globales();
            verifico_cargo();
            obtener_fecha_actual();
            eventos();
            fillAnios();
            ListarDocsXRecibir();
            ListarDocsRecepcionados();

        }
    };
}();



