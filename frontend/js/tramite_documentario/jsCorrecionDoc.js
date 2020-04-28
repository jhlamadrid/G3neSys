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

var INIT = function () {

    var initDatables = function () {
        var parms = {
            data: null,
            info: false,
            searching: true,
            paging: false,
            fixedHeader: true,
            ordering: false,
            columns: [

                {data: "NOMBREDOCUMENTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '15px');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: "NUMERODOCUMENTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '15px');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnSelect btn btn-success btn-xs" title="Seleccionar"><i class="fa fa-check"></i></button>';
                    }
                }


            ]
        }
        oTable_Data = $("#tbl_busqueda").dataTable(parms);
        $("#tbl_busqueda_filter").hide();


        var table = $('#tbl_busqueda').DataTable();
        $('#txt_buscar').on('keyup', function () {
            table.search(this.value).draw();
        });
    };

    var initDatablesFolios = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            paging: false,
            fixedHeader: true,
            ordering: false,
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data) {
                        if (data.INDCOPIA == '1') {
                            return "<span  style='font-size: 1.3em;'> \n\
                                        <i style='color: #4caf50;' class='fa fa-file'></i>\n\
                                    </span>";
                        }  else {
                            return "";
                        }

                    }
                },

                {data: null,// "NOMBREDOCUMENTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = data.NOMBREDOCUMENTO+' Nro. <span  style="color:#e41d20;">  '+data.NUMERODOCUMENTO+' - '+data.ANIO+' </span> - '+'SEDALIB S.A. - '+ data.SIGLA_AREA;
                        if(tipo_cargo ==0){
                            if(data.SIGLAS_PERSONAL != null){
                            
                                cadena = cadena + '/' +  data.SIGLAS_PERSONAL;
                            }
                        }
                        
                        return cadena;
                    }

                },
                {data: "FOLIOS",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
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
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnEdit btn btn-primary " title="Eitar Folios"><i class="fa fa-pencil"></i></button>';
                    }
                }
            ]
        }
        oTable_Folios = $("#tbl_folios").dataTable(parms);
    };

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
                },
                {data: null, className: 'dt-body-center',
                   render: function (data, type, full, meta) {
                        return '<span class="btn btn-danger btnEliminarAdjunto">Eliminar</span> ' }
                }
            ]
        }
        oTable_adjuntos = $("#tbl_docint_adjuntos").dataTable(parms);
    };

    var initDatablesDestinatarios = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    },

                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnEliminar btn btn-danger tooltips" data-container="body" data-placement="top" title="Remover"><i class="fa fa-remove"></i></button>\n\
                                 <button type="button" class="btnEditDestino btn btn-primary tooltips" data-container="body" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></button>';
                    }
                }
            ]
        }
        oTable_Destinatarios = $("#tbl_sis_destinatarios").dataTable(parms);
    };

    var initDatablesDestinatariosCC = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    },

                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnEliminar btn btn-danger tooltips" data-container="body" data-placement="top" title="Remover"><i class="fa fa-remove"></i></button>';
                    }
                }
            ]
        }
        oTable_DestinatariosCC = $("#tbl_sis_destinatarios_cc").dataTable(parms);
    };

    var initDatablesRefs = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: null,// "NOMBREDOCUMENTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = data.NOMBREDOCUMENTO+' Nro. <span  style="color:#e41d20;">  '+data.NUMERODOCUMENTO+' - '+data.ANIO+' </span> - '+'SEDALIB S.A. - '+ data.SIGLA_AREA;
                        if(data.SIGLAS_PERSONAL != null){
                            
                            cadena = cadena + '/' +  data.SIGLAS_PERSONAL;
                        }
                        return cadena;
                    }

                },
                {data: "FECHACREACION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        console.log(rowData);
                        var atendido  = "";
                        var pendiente = "";
                        if(rowData.ESTADOMOVIMIENTO =="1"){
                            atendido = "selected";
                        }else{
                            if(rowData.ESTADOMOVIMIENTO =="0"){
                                pendiente = "selected";
                            }
                        }
                        $(td).html('<select class="form-control selEstaDoc" > <option value ="A" '+atendido+'> ATENDIDO </option> <option value ="P"  '+ pendiente+'>PENDIENTE</option> </select>');
                    }
                },

                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnEliminar btn btn-danger tooltips" data-container="body" data-placement="top" title="Remover"><i class="fa fa-remove"></i></button>';
                    }
                }
            ]
        }
        oTable_Refs = $("#tbl_refs").dataTable(parms);
    };

    var initDatablesSearchRefs = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [

                {data: null,// "NOMBREDOCUMENTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = data.NOMBREDOCUMENTO+' Nro. <span  style="color:#e41d20;">  '+data.NUMERODOCUMENTO+' - '+data.ANIO+' </span> - '+'SEDALIB S.A. - '+ data.SIGLA_AREA;
                        if(data.SIGLAS_PERSONAL != null){
                            
                            cadena = cadena + '/' +  data.SIGLAS_PERSONAL;
                        }
                        return cadena;
                    }

                },
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: "FOLIOS",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnSelectRef btn btn-success btn-xs" title="Seleccionar"><i class="fa fa-check"></i></button>';
                    }
                },
            ]
        }
        oTable_SRefs = $("#tbl_search_refs").dataTable(parms);
    };

    var initDatablesDocsResueltos = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data) {
                        if ((data.indTerminado * 1) === 1) {
                            return "<span style='font-size:  1.3em;'> \n\
                                        <i style='color: #e41d20;' class='fa fa-file'></i>\n\
                                    </span>";
                        } else {
                            return "";
                        }

                    }
                },

                {data: "cNombre",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: "NumAnoSigla",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: "Depen_emisor",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                }


            ]
        };
        oTable_Docs_Resolver = $("#tbl_docsResueltos").dataTable(parms);
    };


    var eventos = function () {

        $("#txt_nroDocumento").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $("#txtFolioDoc").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $("#txtFoTT").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $("#txtFolioT").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $("#txtCantFoliosCC").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });


        $("#btnFiltrar").click(function () {
            $(this).blur();
            var valor = $("#txt_nroDocumento").val();
            if (valor === "") {
                Alerta("ADVERTENCIA", "Ingresa un número de documento válido, por favor ingresa nuevamente el número de documento.", "4");
                return;
            }

            ListarDocsFiltro();
        });



        $("#chkResuelto").click(function () {

            var lenResueltos = oTable_Docs_Resolver.fnGetData().length;
            var valor = $("#chkResuelto").is(":checked");

            if (lenResueltos <= 0) {
                if (valor) {
                    $("#chkResuelto").prop('checked', false);
                } else {
                    $("#chkResuelto").prop('checked', true);
                }
                Alerta("ADVERTENCIA", "No existe documentos que resolver", "4");
                return;
            }




            if (valor) {
                $("#btnConfirmResolver").attr("accion", "resolver");
                $("#btnConfirmResolver").html("Resolver");
                $("#spPreguntaResuelto").html("¿Está seguro que deseas Resolver el documento y todas sus referencias?");
                $("#sp_doc_resolver").html($("#spTipoDoc").html() + ' ' + $("#spNumDoc").html());
            } else {
                $("#btnConfirmResolver").attr("accion", "desresolver");
                $("#btnConfirmResolver").html("Desresolver");
                $("#spPreguntaResuelto").html("¿Está seguro que deseas Desresolver el documento y todas sus referencias?");
                $("#sp_doc_resolver").html($("#spTipoDoc").html() + ' ' + $("#spNumDoc").html());
            }


            $("#modal_info_resolver").modal("show");
        });

        $("#btnCancelarResolver").click(function () {
            var valor = $("#chkResuelto").is(":checked");
            if (valor) {
                $("#chkResuelto").prop('checked', false);
            } else {
                $("#chkResuelto").prop('checked', true);
            }
        });



        $('#tbl_busqueda tbody').on('click', '.btnSelect', function () {
            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Data.fnGetData(pos),
                    codTipoDoc = data.IDTIPDOCUMENTO,
                    cod_doc = data.IDDOCUMENTO,
                    tipo_doc = data.NOMBREDOCUMENTO,
                    documento = data.NUMERODOCUMENTO,
                    foliosDoc = data.FOLIOSDOC,
                    indDerivado = data.indDerivado,
                    indPersonal = data.INDPERSONAL,
                    indTerminado = data.indTerminado,
                    Ing_externo = data.TIPO_EXTERNO,
                    movi_Externo = data.INDEXTER,
					asunto = data.ASUNTO;

        
            console.log(data);
            //CHEKED RESOLVER CORRECION
            var valorChk = $("#chkResuelto").is(":checked");
            checkResolver(valorChk, indTerminado);
            var siglaPersonal = '';
            if(data.IDENCARGADO != data.PERSONACREA && tipo_cargo == 0){
                siglaPersonal = ' / '+  data.SIGLA_WORKFLOW;
            }

            $("#btnUpdDestino").attr('indExterno', Ing_externo);
			$("#btnUpdDestino").attr('indmovexterno', Ing_externo);
            $("#btnUpdFolios").attr('cod_doc', cod_doc);
            $("#btnSaveFoTT").attr('cod_doc', cod_doc);
            $("#btnSaveFoTT").attr('tipo_doc', codTipoDoc);
            $("#btnAgregar2").attr('cod_doc', cod_doc).attr("derivado", indDerivado);
            $("#btnAgregar2").attr('ind_personal', indPersonal);
            $("#btnAgregar").attr('cod_doc', cod_doc).attr("derivado", indDerivado);
            $("#btnAgregar").attr('ind_personal', indPersonal);
            getTipoxTipoDoc(cod_doc);
            ListarMovsFolios(cod_doc);
            ListarMovsCorrecion(cod_doc);
            ListarMovsCorrecionCopia(cod_doc);
            ListarRefDocCorrecion(cod_doc);
            $("#btnConfirmAddRef").attr('cod_doc', cod_doc);
            $("#btnConfirmResolver").attr('cod_doc', cod_doc);
            $("#btnBuscarRefs").attr('derivado', indDerivado);
            $("#btnBuscarRefs").attr('expediente', (codTipoDoc === 1 ? '1' : '0'));
            $("#btnConfirmDelMov").attr('derivado', indDerivado);
            $("#spTipoDoc").html(tipo_doc +' Nro.');
            $("#spNumDoc").html(documento + ' - ' + data.ANIO);
            $("#spDescriDoc").html('-SEDALIB S.A.-'+data.SIGLA_AREA + siglaPersonal);
            $("#txtFolioDoc").val(foliosDoc);
            $("#txtAsuntoDoc").val(asunto);
            $("#txtFoTT").val(data.FOLIOSTOTALES);
            $("#txtObservaciones").val(data.OBSERVACIONES);
            $("#txtContenido").val(data.CONTENIDO);
            ruta_archivo = data.RUTA_ARCHIVO;
            $("#txt_nroDocumento").val("");
            $("#sp_doc_dev").html(tipo_doc + " " + documento);
            $("#modal_busqueda").modal('hide');
            $("#divCorreccion").slideDown();
            if(Ing_externo == 0){
                if(movi_Externo == 1){
                    var hrefStr = "a[href='#tab_5_4']";
                    $( hrefStr ).closest("li").remove();
                    var hrefStr2 = "a[href='#tab_5_2']";
                    $( hrefStr2 ).closest("li").remove();
                    var hrefStr3 = "a[href='#tab_5_3']"
                    $( hrefStr3 ).closest("li").remove();
                }else{
                    if(tipo_cargo == 0){ // si no es usuario encargador deshabilito los botones para editar 
                        var hrefStr = "a[href='#tab_5_3']"
                        $( hrefStr ).closest("li").remove();
                    }
                }
                
            }else{
                $("#Ing_exter_doc").hide();
                var hrefStr = "a[href='#tab_5_4']";
                $( hrefStr ).closest("li").remove();
                var hrefStr2 = "a[href='#tab_5_2']";
                $( hrefStr2 ).closest("li").remove();
                $('#btnAgregar').prop('disabled', true);
            }

            $("#NSUM-INI").val(data.FECHAMAXATENCION);

            $('#NSUM-INI').daterangepicker({
                "showDropdowns": true,
                "autoApply": true,
                "timePickerIncrement": 1,
                "singleDatePicker": true,
                "timePicker": false,
                "timePicker12Hour": false,
                "timePicker24Hour": false,
                "timePickerSeconds": false,
                "autoclose": true,
                "format": "DD-MM-YYYY",
                "startDate": data.FECHACREACION,
                "minDate": data.FECHACREACION,
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
                }
            });
            

        });

        

        $("#btnArchAdjunto").on('click', function(){
            id_documento =  $("#btnUpdFolios").attr('cod_doc');
            obtener_archivos_relacionados(id_documento, 1);
             
        });


        $('#tbl_folios tbody').on('click', '.btnEdit', function () {
            var pos = oTable_Folios.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Folios.fnGetData(pos),
                    idMov = data.IDMOVIMIENTO;
            $("#txtFolioT").val('');
            $("#btnEditFolio").attr('cod_mov', idMov);
            $("#modalEditFolios").modal('show');
        });


        $('#tbl_sis_destinatarios tbody').on('click', '.btnEditDestino', function () {
            var pos = oTable_Destinatarios.api(true).row($(this).parents("tr")[0]).index(),
                data = oTable_Destinatarios.fnGetData(pos),
                cod_mov = data.IDMOVIMIENTO,
				len = oTable_Destinatarios.fnGetData().length;
            $("#btnUpdDestino").attr("cod_mov", cod_mov);
            $("#modal_editDestino").modal('show');
			
			 $('#chkEntExt').removeAttr('checked');
			 
			 $("#divInputEntExt").hide();
			 $("#divInputDestino").show();
			 
			 $("#btnUpdDestino").attr("indmovexterno",data.INDEXTER);
			 $("#btnUpdDestino").attr("indexterno",0);
			 $("#cmbPersonalA").val("N").trigger('change');
			 
			 if (len > 1 ){
				 $("#divEntExt").hide();
			 }else{
				  $("#divEntExt").show();
			 }
			
        });
		
		
		$('#chkEntExt').on('click', function () {
            var estado = $('#chkEntExt').is(":checked");
           

            if (estado) {
               $("#txtEntidadExterna").val('');
               $("#divInputEntExt").show();
			   $("#divInputDestino").hide();
			   $("#btnUpdDestino").attr("indExterno","1");
               
            } else {
              $("#divInputEntExt").hide();
              $("#divInputDestino").show();
			  $("#btnUpdDestino").attr("indExterno","0");
            }



        });
		
		$('#tbl_docint_adjuntos tbody').on('click', '.btnEliminarAdjunto', function () {
            
            var pos = oTable_adjuntos.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_adjuntos.fnGetData(pos)
            idDoc = data.DOCREFERENCIA;
            idEnlace = data.IDENLACEARCHIVO,
            ruta = data.rutaEnlace,
            cantidad = oTable_adjuntos.fnGetData().length;
            console.log(data);
            if(cantidad<=1){
                Alerta("ERROR", "Alerta, debe tener relacionado almenos un archivo!", "2");
            }else{
                eliminar_archivo_relacionado(idDoc, idEnlace,ruta);
            }
            
        });

        $('#tbl_sis_destinatarios tbody').on('click', '.btnEliminar', function () {
            var pos = oTable_Destinatarios.api(true).row($(this).parents("tr")[0]).index(),
                data = oTable_Destinatarios.fnGetData(pos)
                idMov = data.IDMOVIMIENTO,
                nombre = data.NOMBREAREA,
                indDerivado = data.indDerivado,
                idDocumento = data.IDDOCUMENTO,
                idPersonaCrea = data.IDPERSONACREA,
                id_depen_crea = data.IDPERSONACREA;
            console.log(data);
            indDerivado =2;
            if (indDerivado == 1) {
                $("#spPregunta").html("¿Está seguro que deseas eliminar el destinatario?\nPor ser una derivacion volvera al destino anterior.");
                $("#sp_mov").html(nombre);
                $("#btnConfirmDelMov").attr('cod_mov', idMov);
                $("#btnConfirmDelMov").attr('cod_doc', idDocumento);
                $("#btnConfirmDelMov").attr('idPersonaCrea', idPersonaCrea);
                $("#btnConfirmDelMov").attr('id_depen_crea', id_depen_crea);
                $("#modal_confirm_del_mov").modal('show');
                return;
            } else {
                if (oTable_Destinatarios.fnGetData().length <= 1) {
                    Alerta("Atención", "No se puede eliminar el último destinatario", "4");
                    return;
                }
            }

            $("#spPregunta").html("¿Está seguro que deseas eliminar el destinatario?");
            $("#sp_mov").html(nombre);

            $("#btnConfirmDelMov").attr('cod_mov', idMov);
            $("#modal_confirm_del_mov").modal('show'); 
        });

        $('#tbl_sis_destinatarios_cc tbody').on('click', '.btnEliminar', function () {
            var pos = oTable_DestinatariosCC.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_DestinatariosCC.fnGetData(pos),
                    idMov = data.IDMOVIMIENTO,
                    nombre = data.NOMBREAREA;

            $("#spPregunta").html("¿Está seguro que deseas eliminar el destinatario copia?");
            $("#sp_mov").html(nombre);
            $("#btnConfirmDelMov").attr('cod_mov', idMov);
            $("#modal_confirm_del_mov").modal('show');
        });

        $('#tbl_refs tbody').on('click', '.btnEliminar', function () {
            var pos = oTable_Refs.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Refs.fnGetData(pos),
                    idMov = data.IDMOVIMIENTO,
                    tipoDoc = data.NOMBREDOCUMENTO,
                    Documento = data.NUMERODOCUMENTO;
            $("#sp_doc").html(tipoDoc + ' Nr. ' + Documento + ' - '+ data.ANIO + ' - SEDALIB S.A. - ' +data.SIGLA_AREA +((data.SIGLAS_PERSONAL == null )? '' :('/'+data.SIGLAS_PERSONAL) ) );
            $("#btnConfirmDelRef").attr('cod_mov', idMov);
            $("#modal_confirm_del_ref").modal('show');
        });


        $("#btnUpdFolios").click(function () {
            $(this).blur();
            var folioDoc = $("#txtFolioDoc").val(),
			    asunto = $("#txtAsuntoDoc").val();
            if (folioDoc === "" || folioDoc === "0") {
                Alerta("Atención", "Ingrese número de folios mayor a 0", 4);
                return;
            }
			 if (asunto === "" ) {
                Alerta("Atención", "Ingrese un asunto valido que no sea vacío", 4);
                return;
            }

            ActualizarFolios();
        });

        $("#btnSaveFoTT").click(function () {
            $(this).blur();
            var folios = $("#txtFoTT").val();
            if (folios === "" || folios === "0") {
                Alerta("Atención", "Ingrese número de folios mayor a 0", 4);
                return;
            }

            ActualizarFoliosTotal();
        });

        $("#btnEditFolio").click(function () {
            $(this).blur();
            var folios = $("#txtFolioT").val();
            if (folios === "" || folios === "0") {
                Alerta("Atención", "Ingrese número de folios mayor a 0", 4);
                return;
            }

            ActualizarFoliosTotalMov();
        });

        $("#btnConfirmDelMov").click(function () {
            $(this).blur();
            var indDerivado = $("#btnConfirmDelMov").attr('derivado');
            var indDerivado ='2';
            if (indDerivado === '1') {
                delMovDerivacion();
            } else {
                delMovimiento();
            }

        });


        $("#btnConfirmResolver").click(function () {
            $(this).blur();
            var accion = $("#btnConfirmResolver").attr('accion'),
                    cod_doc = $("#btnConfirmResolver").attr('cod_doc'),
                    documento = $("#spTipoDoc").html() + ' ' + $("#spNumDoc").html();
            if (accion === 'resolver') {
                resolverDocumento(cod_doc, 0, documento);
            } else if (accion === 'desresolver') {
                desresolverDocumento(cod_doc, 0);
            }

        });

        $("#btnConfirmDelRef").click(function () {
            $(this).blur();

            eliminarRefCorreccion();
        });

        $("#btnNuevaBusqueda").click(function () {
            $(this).blur();
            location.reload();
        });
        
        $("#btnAgregar").click(function () {
            $(this).blur();
            var tipo = $("#btnAgregar").attr("tipo"),
                    indDerivado = $("#btnAgregar").attr("derivado"),
                    lenTD = oTable_Destinatarios.fnGetData().length;
            var indPersonal =    $("#btnAgregar").attr("ind_personal");   

            if ($("#cmbNombre").val() === 'N') {
                Alerta("ADVERTENCIA", "Selecciona una persona por favor!", "4");
                return;
            }

            /*
            if (indDerivado === '1' && lenTD === 1) {
                Alerta("ADVERTENCIA", "No se puede agregar mas de un destinatario en una derivación", "4");
                return;
            } */

            tipo ='P';

            if (tipo === 'P') {
                $("#btnAgregar").attr("disabled", true);
                var len = oTable_Destinatarios.fnGetData().length,
                        row = oTable_Destinatarios.fnGetData(),
                        dni = $("#cmbNombre").val();

                var dataCopias = oTable_DestinatariosCC.fnGetData(),
                        lenCopias = oTable_DestinatariosCC.fnGetData().length;
                //console.log(dataCopias);
                //console.log(dni);
                if (lenCopias > 0) {
                    for (var i = 0; i < lenCopias; i++) {
                        if(indPersonal == 0){
                            if ((dataCopias[i]['IDDEPENDENCIAENVIA']).trim() === dni.trim()) {
                                $("#btnAgregar").attr("disabled", false);
                                Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                                return;
                            }
                        }else{
                            if ((dataCopias[i]['IDPERSONAENVIA']).trim() === dni.trim()) {
                                $("#btnAgregar").attr("disabled", false);
                                Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                                return;
                            }
                        }
                        
                    }
                }

                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        if(indPersonal == 0){
                            if ( (row[i]['IDDEPENDENCIAENVIA']).trim() === dni.trim()   ) {
                                $("#btnAgregar").attr("disabled", false);
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }else{
                            if ( (row[i]['IDPERSONAENVIA']).trim() === dni.trim()   ) {
                                $("#btnAgregar").attr("disabled", false);
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }
                        
                    }

                }
                
                addMovCorrecion($("#cmbNombre").val(),
                        $("#cmbNombre option:selected").attr("cod_depen"),
                        oTable_Destinatarios.fnGetData(0).IDMOVIMIENTO,
                        oTable_Destinatarios.fnGetData(0).IDTIPDOCUMENTO,
                        oTable_Destinatarios.fnGetData(0).IDDOCUMENTO,
                        oTable_Destinatarios.fnGetData(0).FOLIOS,
                        0, indPersonal);
                $("#cmbNombre").val('N').trigger('change');
            } else if (tipo === 'D') {
                if ($("#cmbNombre").val() !== 'T') {
                    $("#btnAgregar").attr("disabled", true);
                    getFuncionario();
                    return;
                }

            }


        });

        $("#btnAgregar2").click(function () {
            $(this).blur();
            var len = oTable_Destinatarios.fnGetData().length;
            var tipo = $("#btnAgregar2").attr("tipo"),
                    indDerivado = $("#btnAgregar2").attr("derivado"),
                    foliosCc = $("#txtCantFoliosCC").val();
            var indPersonal =    $("#btnAgregar2").attr("ind_personal");  
            if ($("#cmbNombre2").val() === 'N') {
                Alerta("ADVERTENCIA", "Selecciona una persona por favor!", "4");
                return;
            }


            if (foliosCc === "" || foliosCc === "0") {
                Alerta("Atención", "Ingrese número de folios mayor a 0", 4);
                return;
            }

            if (indDerivado === '1') {
                Alerta("ADVERTENCIA", "No se puede agregar copias en una derivación", "4");
                return;
            }

            if (len === 0) {
                Alerta("ADVERTENCIA", "No se puede agregar copias, Agregar primero un destinatario por favor!", "4");
                return;
            }

            tipo='P';
            if (tipo == 'P') {
                $("#btnAgregar2").attr("disabled", true);
                var row = oTable_Destinatarios.fnGetData(),
                        dni = $("#cmbNombre2").val(),
                        lenCopias = oTable_DestinatariosCC.fnGetData().length,
                        rowCopias = oTable_DestinatariosCC.fnGetData();
                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        if(indPersonal == 0){
                            if ((row[i]['IDDEPENDENCIAENVIA']).trim() === dni.trim()) {
                                $("#btnAgregar2").attr("disabled", false);
                                Alerta("ADVERTENCIA", "No se puede agregar una copia al mismo destinatario!", "4");
                                return;
                            }
                        }else{
                            if ((row[i]['IDPERSONAENVIA']).trim() === dni.trim()) {
                                $("#btnAgregar2").attr("disabled", false);
                                Alerta("ADVERTENCIA", "No se puede agregar una copia al mismo destinatario!", "4");
                                return;
                            }
                        }
                        
                    }
                }

                if (lenCopias > 0) {
                    for (var i = 0; i < lenCopias; i++) {
                        if(indPersonal == 0){
                            if ((rowCopias[i]['IDDEPENDENCIAENVIA']).trim() === dni.trim()){
                                $("#btnAgregar2").attr("disabled", false);
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }else{
                            if ((rowCopias[i]['IDPERSONAENVIA']).trim() === dni.trim()){
                                $("#btnAgregar2").attr("disabled", false);
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }
                        
                    }
                }

                addMovCopiaCorrecion($("#cmbNombre2").val(),
                        $("#cmbNombre2 option:selected").attr("cod_depen"),
                        oTable_Destinatarios.fnGetData(0).IDMOVIMIENTO,
                        oTable_Destinatarios.fnGetData(0).IDTIPDOCUMENTO,
                        0,
                        $("#txtCantFoliosCC").val(),
                        $("#btnAgregar2").attr('cod_doc'),indPersonal);

                $("#cmbNombre2").val('N').trigger('change');


            } else if (tipo === 'D') {
                $("#btnAgregar2").attr("disabled", true);
                getFuncionario2();

            }


        });

        $("#btnBuscarRefs").click(function () {
            $(this).blur();
            var derivado = $("#btnBuscarRefs").attr('derivado'),
                    exp = $("#btnBuscarRefs").attr('expediente');
            if (derivado === '1') {
                Alerta("Atención", "No es posible agregar referencia a una derivación", 4);
                return;
            } else {
                if (exp === '1') {
                    Alerta("Atención", "No es posible agregar referencia a un expediente", 4);
                    return;
                }
            }
            $("#txtBuscarRef").val("");
            oTable_SRefs.fnClearTable();
            $("#modal_refs").modal("show");
        });

        $("#btnGuardarEstRef").click(function () {
            var tam = oTable_Refs.fnGetData().length;
            if(tam >=1){
                var referencias =  Obtener_referencias();
                guardoEstRef(referencias);
            }else{
                Alerta("ALERTA", "La tabla de referencias se encuentra vacia", "4");
            }

        });

        $("#btnBuscarRefe").click(function () {
            $(this).blur();
            getRefs();
        });

        $('#tbl_search_refs tbody').on('click', '.btnSelectRef', function () {

            var pos = oTable_SRefs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_Refs.fnGetData();
            var dataRefAdd = oTable_SRefs.fnGetData(pos);
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    if (data[i].IDMOVIMIENTO === dataRefAdd.IDMOVIMIENTO) {
                        Alerta("ADVERTENCIA", "El documento ya se agrego en la lista de referencias!", "4");
                        return;
                    }
                }
            }

            $("#sp_docRefAdd").html(dataRefAdd.NOMBREDOCUMENTO + ' Nr. ' + dataRefAdd.NUMERODOCUMENTO + ' - '+ dataRefAdd.ANIO + ' - SEDALIB S.A. - ' +dataRefAdd.SIGLA_AREA +((dataRefAdd.SIGLAS_PERSONAL == null)? '' :('/'+dataRefAdd.SIGLAS_PERSONAL) ));
            $("#btnConfirmAddRef").attr('cod_mov', dataRefAdd.IDMOVIMIENTO);
            $("#modal_refs").modal("hide");
            $("#modal_confirm_add_ref").modal("show");

        });

        $("#btnConfirmAddRef").click(function () {
            $(this).blur();
            agregaRefCorreccion();
        });


        $("#btnUpdDestino").click(function () {
            $(this).blur();
            var tipo          = $("#btnAgregar").attr("tipo"),
			    indExterno    = $("#btnUpdDestino").attr("indExterno");
				//indMovExterno = $("#btnUpdDestino").attr("indmovexterno");
            var indPersona    = $("#btnAgregar").attr("ind_personal");	
            
            if ($("#cmbPersonalA").val() === 'N') {
                Alerta("ADVERTENCIA", "Selecciona una dependencia por favor!", "4");
                return;
            }
            tipo ='P';
            if (tipo === 'P'){

                var len = oTable_Destinatarios.fnGetData().length,
                        row = oTable_Destinatarios.fnGetData(),
                        dni = $("#cmbPersonalA").val();

                var dataCopias = oTable_DestinatariosCC.fnGetData(),
                        lenCopias = oTable_DestinatariosCC.fnGetData().length;
                
                if (lenCopias > 0) {
                    for (var i = 0; i < lenCopias; i++) {
                        if(indPersona ==0){
                            if ((dataCopias[i]['IDDEPENDENCIAENVIA']).trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                                return;
                            }
                        }else{  
                            if ((dataCopias[i]['IDPERSONAENVIA']).trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                                return;
                            }
                        }
                        
                    }
                }

                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        if(indPersona ==0){
                            if ((row[i]['IDDEPENDENCIAENVIA']).trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }else{
                            if ((row[i]['IDPERSONAENVIA']).trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }
                        
                    }

                }
                updMovDocumento($("#cmbPersonalA").val(),
                        $("#cmbPersonalA option:selected").attr("cod_depen"),
                        $("#btnUpdDestino").attr("cod_mov"), indPersona, indExterno);
                
                $("#cmbPersonalA").val('N').trigger('change');

            } 

        });


    };

    var guardoEstRef = function(referencias){
        $.ajax({
            url: "CorreccionDoc/guardoEstRef",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "referencia"   : referencias
            },
            success: function (data) {
                if(data){
                    Alerta("LISTO", "Se completo la actualización de las referencias", "1");
                }else{
                    Alerta("ERROR", "Error, no se pudo cambiar estado de referencias", "2");
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

    var eliminar_archivo_relacionado = function (idDoc, idEnlace, ruta){
        $.ajax({
            url: "CorreccionDoc/setDeleteFile",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "idDoc"   : idDoc,
                "IdEnlace": idEnlace,
                "ruta"    : ruta
            },
            success: function (data) {
                if(data){
                    obtener_archivos_relacionados(idDoc,2);
                }else{
                    Alerta("ERROR", "Error, no se pudo eliminar el archivo!", "2");
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

    var obtener_archivos_relacionados = function (id_documento, tipo){
        Cargando(1);
        $.ajax({
            url: "CorreccionDoc/getDocsAnexados",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "idDoc": id_documento
            },
            success: function (data) {
                Cargando(0);
                oTable_Data.fnClearTable();
                console.log(data);
                oTable_adjuntos.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_adjuntos.fnAddData(data);
                    if(tipo==1){
                        $('#modalArchiAdjuntado').modal('show');
                    }
                }else{
                    Alerta("ALERTA", "No se subio archivos del Documento", "4");
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

    var Obtener_referencias = function () {
        var refs = [];
        var l = oTable_Refs.fnGetData().length;
        for (var i = 0; i < l; i++) {

            var e = {
                "idMovimiento": oTable_Refs.fnGetData(i).IDMOVIMIENTO,
                "estado_ref": $(oTable_Refs.fnGetNodes(i)).find('select').val(),
            };
            refs.push(e);
        }
        return refs;
    };

    var fillAnios = function () {
        var currentYear = (new Date).getFullYear();
        for (var i = currentYear; i >= 1980; i--) {
            $('#cbo_comboAnio').append("<option value='" + (i) + "'>" + (i) + "</option");
        }


    };

    var checkResolver = function (valorChk, indTerminado) {

        if ((indTerminado * 1) === 1) {
            if (!valorChk) {
                $("#chkResuelto").prop('checked', true);
            }
        } else {
            if (valorChk) {
                $("#chkResuelto").prop('checked', false);
            }
        }


    };



    var ListarDocsFiltro = function () {

        Cargando(1);
        var numero = $("#txt_nroDocumento").val() === '' ? '%' : $("#txt_nroDocumento").val();
        $.ajax({
            url: "CorreccionDoc/getDocsCreadosxUsu",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "numero": numero,
                "anio": $("#cbo_comboAnio").val()
            },
            success: function (data) {
                Cargando(0);
                oTable_Data.fnClearTable();
                console.log(data);
                if (data.length > 0) {
                    oTable_Data.fnAddData(data);
                    $("#modal_busqueda").modal('show');
                    $('#btnFiltrar').attr("disabled", true);
                    $('#btnNuevaBusqueda').attr("disabled", false);
                } else {
                    Alerta("Atención", "Documento recepcionado, no puede editar un documento recepcionado", "4");
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


    var ActualizarFolios = function () {
        $("#modal_info").modal("hide");
        Cargando(1);
        var codigo = $("#btnUpdFolios").attr('cod_doc');
        $.ajax({
            url: "CorreccionDoc/actualizarFoliosCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc"      : $("#btnUpdFolios").attr("cod_doc"),
                "foliosDoc"    : $("#txtFolioDoc").val(),
                "asunto"       : $("#txtAsuntoDoc").val(),
                "observaciones": $("#txtObservaciones").val(),
                "contenido"    : $("#txtContenido").val(),
                "fe_max_ate"   : $("#NSUM-INI").val()
            },
            success: function (data) {
                
                if (data.respuesta === 'ok') {
                    var len_files = Dropzone.instances[0].files.length;
                    if (len_files > 0) {
                        FormDropzone.setMovimientos(codigo);
                        Dropzone.instances[0].processQueue();

                    }else{
                        Alerta("LISTO", "Se completo la actualización de los datos", "1");
                    }
                    
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }

                Cargando(0);
                

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al actualizar folios!", "2");
                }, 900);
            }
        });

    };

    var ActualizarFoliosTotal = function () {
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/actualizarFoliosTotalCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": $("#btnSaveFoTT").attr("cod_doc"),
                "folios": $("#txtFoTT").val()
            },
            success: function (data) {
                //$("#txtFoTT").val('');
                Cargando(0);

                if (!isEmpty(data)) {
                    if (data.respuesta === 'ok') {
                        ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                        Alerta("LISTO", "Se completo la actualizacion de los folios.", "1");
                    } else if (data.respuesta === 'del') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                    } else if (data.respuesta === 'rec') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                    } else {
                        Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                    }

                }

            },
            error: function (msg) {
                setTimeout(function () {
                    $("#txtFoTT").val('');
                    Cargando(0);
                    Alerta("ERROR", "Error al actualizar folios!", "2");
                }, 900);
            }
        });

    };

    var ActualizarFoliosTotalMov = function () {
        $("#modalEditFolios").modal("hide");
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/actualizarFoliosTotalMovCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": $("#btnEditFolio").attr("cod_mov"),
                "folios": $("#txtFolioT").val()
            },
            success: function (data) {
                 Cargando(0);
                if (data.respuesta === 'ok') {
                    ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                    Alerta("LISTO", "Se completo la actualizacion de los folios.", "1");
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }

                

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);

                    Alerta("ERROR", "Error al actualizar folios!", "2");
                }, 900);
            }
        });

    };

    var ListarPersonalxDependencias = function (id) {
        Cargando(1);
        $.ajax({
            url: "CrearDocumento/Listar_personal_x_dependencia",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "id": id
            },
            success: function (data) {

                var html = "<option value='N'>Selecciona una persona</option>";
                $.each(data, function (index, item) {
                    html += '<option value="' + item.NCODIGO + '">' + item.NNOMBRE + '</option>';
                });
                $("#cmbNombre").html(html);
                $("#cmbNombre").select2();

                $("#cmbNombre2").html(html);
                $("#cmbNombre2").select2();
                $("#cmbPersonalA").html(html);
                $("#cmbPersonalA").select2();
                //$("#cmbPersonal").html(html);
                //$("#cmbPersonal").select2();
                Cargando(0);
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de personal!", "2");
                }, 900)
            }
        });
    };

    var getTipoxTipoDoc = function (codDoc, indDerivado) {

        Cargando(1);
        $.ajax({
            url: "CrearInterno/getTipoxTipoDoc",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddoc": codDoc
            },
            success: function (data) {
                Cargando(0);
                if(data.length > 0){
                    // CARGO AL PERSONAL 
                    ListarPersonalxDependencias(true);
                }else{
                    // CARGO A LAS AREAS 
                    Listar_dependencia2();  
                }

            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener datos!", "2");
                }, 900)
            }
        });
    };
	
	
	    var Listar_depend_Jerarquia = function (tipo) {
        Cargando(1);
        $.ajax({
            url: "CrearInterno/getDependenciaJeraquia",
            datatype: "json",
            type: "post",
            async: true,
            data:{
                tipo : tipo
            },
            success: function (data) {
                Cargando(0);
                var html = "<option value='N'>Selecciona un destinatario</option>";
                if(!isEmpty(data)){
                $.each(data, function (index, item) {
                    html += '<option value="' + item.id + '" >' + item.nombre + '</option>';
                });
                 }
                $("#cmbNombre").html(html);
                $("#cmbNombre").select2();
                $("#cmbNombre2").html(html);
                $("#cmbNombre2").select2();
               
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la listar dependencias!", "2");
                }, 900)
            }
        });
    };

    var Listar_personal_x_dependencia2 = function () {
        Cargando(1);
        $.ajax({
            url: "CrearInterno/Listar_personal_x_dependencia",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                var html = "<option value='N'>Selecciona un destinatario</option>";
                $.each(data, function (index, item) {

                    html += '<option value="' + item.dni + '" cod_depen="' + item.iddepend + '" >' + item.nombre + '</option>';
                });
                $("#cmbNombre").html(html);
                $("#cmbNombre2").html(html);
                $("#cmbPersonalA").html(html);
                $("#cmbNombre").select2();
                $("#cmbNombre2").select2();
                $("#cmbPersonalA").select2();
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista del personal de la dependencia seleccionada!", "2");
                }, 900)
            }
        });
    };

    var Listar_dependencia2 = function () {
        Cargando(1);
        $.ajax({
            url: "CrearDocumento/Listar_dependencias",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                var html = "<option value='N'>Selecciona un destinatario</option>";
                $.each(data, function (index, item) {
                    html += '<option value="' + item.IDORGANIGRAMA + '" >' + item.NOMBREAREA + '</option>';
                });
                $("#cmbNombre").html(html);
                $("#cmbNombre").select2();

                $("#cmbNombre2").html(html);
                $("#cmbNombre2").select2();

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


    var ListarMovsFolios = function (cod_doc) {

        Cargando(1);
        $.ajax({
            url: "CorreccionDoc/getMovFoliosCorreccion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": cod_doc
            },
            success: function (data) {
                Cargando(0);
                oTable_Folios.fnClearTable();
                if (data.length > 0) {
                    oTable_Folios.fnAddData(data);
                }
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener folios!", "2");
                }, 900)
            }
        });
    };

    var ListarMovsCorrecion = function (cod_doc) {

        Cargando(1);
        $.ajax({
            url: "CorreccionDoc/getMovsCorreccion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": cod_doc,
                "indCopia": 0
            },
            success: function (data) {
                Cargando(0);
                console.log(data);
                oTable_Destinatarios.fnClearTable();
                if (data.length > 0) {
                    oTable_Destinatarios.fnAddData(data);
					var indExterno = data[0].indExterno;
					if((indExterno*1) === 1){
						$("#divAddDestinoCorreccion").hide();
					}else{
						$("#divAddDestinoCorreccion").show();
					}
					
					
                }
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener movimientos!", "2");
                }, 900)
            }
        });
    }

    var ListarMovsCorrecionCopia = function (cod_doc) {

        Cargando(1);
        $.ajax({
            url: "CorreccionDoc/getMovsCorreccion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": cod_doc,
                "indCopia": 1
            },
            success: function (data) {
                Cargando(0);
                oTable_DestinatariosCC.fnClearTable();
                if (data.length > 0) {
                    oTable_DestinatariosCC.fnAddData(data);
                }
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener movimientos!", "2");
                }, 900)
            }
        });
    };

    var ListarRefDocCorrecion = function (cod_doc) {
        console.log($("#btnSaveFoTT").attr('tipo_doc'));
        Cargando(1);
        $.ajax({
            url: "CorreccionDoc/getReferenciasDocCorreccion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": cod_doc,
                "tipo_doc" : $("#btnSaveFoTT").attr('tipo_doc')
            },
            success: function (data) {
                Cargando(0);
                oTable_Refs.fnClearTable();
                if (data.length > 0) {
                    oTable_Refs.fnAddData(data);
                }
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener referencias!", "2");
                }, 900)
            }
        });
    }

    var delMovimiento = function () {
        $("#modal_confirm_del_mov").modal("hide");
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/eliminarMovCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": $("#btnConfirmDelMov").attr("cod_mov")
            },
            success: function (data) {

                if (data.respuesta === 'ok') {
                    ListarMovsCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                    ListarMovsCorrecionCopia($("#btnSaveFoTT").attr("cod_doc"));
                    ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                    Alerta("LISTO", "Se ha eliminado el destinatario correctamente.", "1");
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }

                
                Cargando(0);
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al eliminar destinatario!", "2");
                }, 900);
            }
        });

    };

    var delMovDerivacion = function () {
        $("#modal_confirm_del_mov").modal("hide");
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/eliminarMovCorrecionDerivacion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": $("#btnConfirmDelMov").attr("cod_mov"),
                "cod_doc": $("#btnConfirmDelMov").attr("cod_doc"),
                "idPersona": $("#btnConfirmDelMov").attr("idPersonaCrea"),
                "idDepend": $("#btnConfirmDelMov").attr("id_depen_crea")
            },
            success: function (data) {

                if (!isEmpty(data)) {
                    if (data.respuesta === 'ok') {
                        $("#divCorreccion").slideUp();
                        Alerta("LISTO", "Se ha eliminado el destinatario correctamente.", "1");
                    } else if (data.respuesta === 'del') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                    } else if (data.respuesta === 'rec') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                    } else {
                        Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                    }

                }
                Cargando(0);
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al eliminar destinatario!", "2");
                }, 900);
            }
        });

    };

    var getFuncionario = function () {

        Cargando(1);
        $.ajax({
            url: "CrearInterno/getFuncionario",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddepen": $("#cmbNombre").val()
            },
            success: function (data) {
                Cargando(0);
                if (!isEmpty(data)) {
                    var len = oTable_Destinatarios.fnGetData().length,
                            row = oTable_Destinatarios.fnGetData(),
                            dni = data[0].c_traba_dni;


                    var dataCopias = oTable_DestinatariosCC.fnGetData(),
                            lenCopias = oTable_DestinatariosCC.fnGetData().length;
                    if (lenCopias > 0) {
                        for (var i = 0; i < lenCopias; i++) {
                            if (dataCopias[i].dni.trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                                $("#btnAgregar").attr("disabled", false);
                                return;
                            }
                        }
                    }


                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (row[i].dni.trim() === dni.trim() && $("#cmbNombre").val() === row[i].idDepend.trim() ) {
                                $("#btnAgregar").attr("disabled", false);
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");

                                return;
                            }
                        }

                    }


                    addMovCorrecion(data[0].c_traba_dni,
                            $("#cmbNombre").val(),
                            oTable_Destinatarios.fnGetData(0).idMovimiento,
                            1);

                } else {
                    $("#btnAgregar").attr("disabled", false);
                    Alerta("ATENCION", "No existe funcionario activo en la dependencia seleccionada", "4");
                }

            },
            error: function (msg) {

                setTimeout(function () {
                    $("#btnAgregar").attr("disabled", false);
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener datos!", "2");
                }, 900)
            }
        });
    };

    var getFuncionario2 = function () {

        Cargando(1);
        $.ajax({
            url: "CrearInterno/getFuncionario",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddepen": $("#cmbNombre2").val()
            },
            success: function (data) {
                Cargando(0);
                if (!isEmpty(data)) {
                    var len = oTable_Destinatarios.fnGetData().length;
                    var row = oTable_Destinatarios.fnGetData(),
                            dni = data[0].c_traba_dni,
                            lenCopias = oTable_DestinatariosCC.fnGetData().length,
                            rowCopias = oTable_DestinatariosCC.fnGetData();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (row[i].dni.trim() === dni.trim()) {
                                $("#btnAgregar2").attr("disabled", false);
                                Alerta("ADVERTENCIA", "No se puede agregar una copia al mismo destinatario!", "4");
                                return;
                            }
                        }
                    }



                    if (lenCopias > 0) {
                        for (var i = 0; i < lenCopias; i++) {
                            if (rowCopias[i].dni.trim() === dni.trim()) {
                                $("#btnAgregar2").attr("disabled", false);
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }

                    }


                    addMovCopiaCorrecion(data[0].c_traba_dni,
                            $("#cmbNombre2").val(),
                            oTable_Destinatarios.fnGetData(0).idMovimiento,
                            1,
                            $("#txtCantFoliosCC").val(),
                            $("#btnAgregar2").attr('cod_doc'));

                    $("#cmbNombre2").val('N').trigger('change');
                } else {
                    $("#btnAgregar2").attr("disabled", false);
                    Alerta("ATENCION", "No existe funcionario activo en la dependencia seleccionada", "4");
                }

            },
            error: function (msg) {

                setTimeout(function () {
                    $("#btnAgregar2").attr("disabled", false);
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener datos!", "2");
                }, 900)
            }
        });
    };

    var addMovCorrecion = function (dni, idDepend, cod_mov, tipo_documento, id_documento, folios, indGerente, indPersonal) {
        Cargando(1);
        $.ajax({
            url: "CorreccionDoc/agregarDestinoCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "dni"        : dni,
                "idDepend"   : idDepend,
                "cod_mov"    : cod_mov,
                "tip_doc"    : tipo_documento,
                "id_doc"     : id_documento,
                'foli'       : folios,
                "indGerente" : indGerente,
                "indPersonal": indPersonal
            },
            success: function (data) {
                $("#btnAgregar").attr("disabled", false);
                Cargando(0);
                if (data.respuesta === 'ok') {
                    $("#cmbNombre").val('N').trigger('change');
                    ListarMovsCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                    ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                    Alerta("LISTO", "Se completo la actualizacion de los folios.", "1");
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }

                

            },
            error: function (msg) {
                setTimeout(function () {
                    $("#btnAgregar").attr("disabled", false);
                    Cargando(0);
                    Alerta("ERROR", "Error al agregar destinatario!", "2");
                }, 900);
            }
        });

    };

    var updMovDocumento = function (dni, idDepend, cod_mov, ind_Personal, indExterno) {
        $("#modal_editDestino").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/actualizaMovDestino",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "dni"          : dni,
                "idDepend"     : idDepend,
                "cod_mov"      : cod_mov,
                "ind_personal" : ind_Personal,
                "indExterno"   : indExterno
            },
            success: function (data) {
                if (data.respuesta === 'ok') {
                    $("#cmbPersonalA").val('N').trigger('change');
                    ListarMovsCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                    ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                    Alerta("LISTO", "Se completo la actualizacion de los folios.", "1");
                    Cargando(0);
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }

                

            },
            error: function (msg) {
                setTimeout(function () {
                    $("#btnAgregar").attr("disabled", false);
                    Cargando(0);
                    Alerta("ERROR", "Error al agregar destinatario!", "2");
                }, 900);
            }
        });

    };


    var addMovCopiaCorrecion = function (dni, idDepend, cod_mov, tipo_documento, indGerente, folios, cod_doc, indPersonal) {
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/agregarDestinoCopiaCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "dni": dni,
                "idDepend": idDepend,
                "cod_mov": cod_mov,
                "tip_doc" : tipo_documento,
                "indGerente": indGerente,
                "folios": folios,
                "cod_doc": cod_doc,
                "indPersonal": indPersonal
            },
            success: function (data) {
                $("#btnAgregar2").attr("disabled", false);
                Cargando(0);
                if (data.respuesta === 'ok') {
                    $("#cmbNombre2").val('N').trigger('change');
                    $("#txtCantFoliosCC").val('');
                    ListarMovsCorrecionCopia($("#btnSaveFoTT").attr("cod_doc"));
                    ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                    Alerta("LISTO", "Se completo la actualizacion de los folios.", "1");
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }

                

            },
            error: function (msg) {
                setTimeout(function () {
                    $("#btnAgregar2").attr("disabled", false);
                    Cargando(0);
                    Alerta("ERROR", "Error al agregar destinatario!", "2");
                }, 900);
            }
        });

    };


    var eliminarRefCorreccion = function () {
        $("#modal_confirm_del_ref").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/eliminaRefCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": $("#btnConfirmDelRef").attr("cod_mov"),
                "cod_doc": $("#btnUpdFolios").attr("cod_doc")
            },
            success: function (data) {
                Cargando(0);
                
                if (data.respuesta === 'ok') {
                    ListarRefDocCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                    ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                    Alerta("LISTO", "Se completo la eliminacion de la referencia.", "1");
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }

                

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al eliminar referencia!", "2");
                }, 900);
            }
        });

    };


    var getRefs = function () {

        Cargando(1);
        $.ajax({
            url: "CrearInterno/getDocumentosRefs",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "numero": $("#txtBuscarRef").val()
            },
            success: function (data) {
                Cargando(0);
                console.log(data);
                oTable_SRefs.fnClearTable();
                if (data.length > 0) {
                    oTable_SRefs.fnAddData(data);
                }
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener referencias!", "2");
                }, 900)
            }
        });
    }


    var agregaRefCorreccion = function () {
        $("#modal_confirm_add_ref").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/agregaRefCorrecion",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": $("#btnConfirmAddRef").attr("cod_doc"),
                "cod_mov": $("#btnConfirmAddRef").attr("cod_mov")
            },
            success: function (data) {
                Cargando(0);
                
                if (data.respuesta === 'ok') {
                    ListarRefDocCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                    ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                    Alerta("LISTO", "Se agrego la referencia correctamente.", "1");
                } else if (data.respuesta === 'del') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                } else if (data.respuesta === 'rec') {
                    Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                } else {
                    Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                }


            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al eliminar referencia!", "2");
                }, 900);
            }
        });

    };

    var CargaInicial = function () {
        $('[data-toggle="tooltip"]').tooltip();
    }


    var desresolverDocumento = function (cod_doc, cod_mov) {
        $("#modal_info_resolver").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/correccionDesresolver",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": cod_doc,
                "cod_mov": cod_mov
            },
            success: function (data) {

                if (!isEmpty(data)) {
                    if (data.respuesta === 'ok') {

                        ListarRefDocCorrecion($("#btnConfirmResolver").attr("cod_doc"));
                        Alerta("LISTO", "Se elimino el resolver correctamente.", "1");
                    } else if (data.respuesta === 'del') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                    } else if (data.respuesta === 'rec') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                    } else {
                        Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                    }

                }

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al desresolver!", "2");
                }, 900);
            }
        });

    };

    var resolverDocumento = function (cod_doc, cod_mov, documento) {
        $("#modal_info_resolver").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/correccionResolver",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": cod_doc,
                "cod_mov": cod_mov,
                "documento": documento
            },
            success: function (data) {

                if (!isEmpty(data)) {
                    if (data.respuesta === 'ok') {

                        ListarRefDocCorrecion($("#btnConfirmResolver").attr("cod_doc"));
                        Alerta("LISTO", "Se elimino el resolver correctamente.", "1");
                    } else if (data.respuesta === 'del') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                    } else if (data.respuesta === 'rec') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                    } else {
                        Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                    }

                }

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al desresolver!", "2");
                }, 900);
            }
        });

    };
	
	
	 var CorreccionEntidadExterna = function () {
        $("#modal_editDestino").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/CorreccionEntidadExterna",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "descEntExt": $("#txtEntidadExterna").val(),
                "cod_doc": $("#btnUpdFolios").attr("cod_doc")
            },
            success: function (data) {
                //  Cargando(0);
                if (!isEmpty(data)) {
                    if (data.respuesta === 'ok') {
                         ListarMovsCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                        ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                        Alerta("LISTO", "Se completo la correccion del destino.", "1");
                    } else if (data.respuesta === 'del') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                    } else if (data.respuesta === 'rec') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                    } else {
                        Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                    }

                }

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al editar entidad externa!", "2");
                }, 900);
            }
        });

    };
	
	
	 var CambiarEntidadExternaToDependencia = function (cod_doc,cod_mov,cod_depen,dni_persona) {
        $("#modal_editDestino").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/CambiarExternaDependencia",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_doc": cod_doc,
                "cod_mov": cod_mov,
				"iddepen": cod_depen,
				"dnipersona": dni_persona
            },
            success: function (data) {
                //  Cargando(0);
                if (!isEmpty(data)) {
                    if (data.respuesta === 'ok') {
                         ListarMovsCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                         ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                          Alerta("LISTO", "Se completo la correccion del detino.", "1");
						  $("#divAddDestinoCorreccion").show();
						  
						  
                    } else if (data.respuesta === 'del') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                    } else if (data.respuesta === 'rec') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                    } else {
                        Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                    }

                }

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al editar entidad externa!", "2");
                }, 900);
            }
        });

    };
	
	var CambiarDependenciaToEntidadExterna = function () {
        $("#modal_editDestino").modal('hide');
        Cargando(1);

        $.ajax({
            url: "CorreccionDoc/CambiarDependenciaExterna",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "descEntExterna": $("#txtEntidadExterna").val(),
                "cod_mov": $("#btnUpdDestino").attr("cod_mov")
            },
            success: function (data) {
                //  Cargando(0);
                if (!isEmpty(data)) {
                    if (data.respuesta === 'ok') {
                        ListarMovsCorrecion($("#btnSaveFoTT").attr("cod_doc"));
                         ListarMovsFolios($("#btnSaveFoTT").attr("cod_doc"));
                          Alerta("LISTO", "Se completo la correccion del detino.", "1");
						  $("#divAddDestinoCorreccion").hide();
                    } else if (data.respuesta === 'del') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento ha sido eliminado", 4);
                    } else if (data.respuesta === 'rec') {
                        Alerta("Atención", "No fue posible actualizar folios, el documento se ha recibido", 4);
                    } else {
                        Alerta("ERROR", "No se pudo actualizar folios los documentos.", "2");
                    }

                }

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al editar entidad externa!", "2");
                }, 900);
            }
        });

    };
    var datos_globales= function (){
        tipo_cargo =0;
        ruta_archivo = '';
    }

    var verifico_cargo= function(){
        $.ajax({
            url: "CrearInterno/verificar_cargo",
            datatype: "json",
            type: "post",
            async: false,
            success: function (data) {
                if(data){
                    tipo_cargo = 1; // cuando el usuario esta encargado de una gerencia 
                }
                console.log(tipo_cargo);

            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener datos!", "2");
                }, 900)
            }
        });
    }

    return {
        init: function () {

            datos_globales();
            initDatables();
            initDatablesFolios();
            initDatablesDestinatarios();
            initDatablesDestinatariosCC();
            initDatablesRefs();
            initDatablesAdjuntos();
            initDatablesSearchRefs();
            initDatablesDocsResueltos();
            verifico_cargo();
            eventos();
            fillAnios();
            CargaInicial();


        }
    };
}();



