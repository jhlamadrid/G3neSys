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


function ListarAdjuntos (cod_doc) {

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

var ListarDocsReferencias = function (idMovimiento, cod_doc, NOMBREDOCUMENTO, NUMERODOCUMENTO, ANIO, SIGLA_AREA, SIGLAS_PERSONAL) {
    
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
            console.log(data);
            $("#sp_doc_ref").html(NOMBREDOCUMENTO + ' NRO. ' + NUMERODOCUMENTO + ' - ' + ANIO + ' - SEDALIB S.A. - '+SIGLA_AREA  +((SIGLAS_PERSONAL == null)? '' :('/'+SIGLAS_PERSONAL) )  );
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
                    Alerta("ERROR", "Tardo el tiempo de petición!", "2");
                }, 900)
            } else {
                setTimeout(function () {
                    Alerta("ERROR", "Error al obtener referencias!", "2");
                }, 900)
            }
        }
    });
}

var ListarAdjuntosReferencia = function (cod_doc) {
    $('#modal_refs').modal('hide');
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

var REPORTES = function () {

    
    var chart;

    var initDatables = function () {
        var parms = {
            data: null,
            info: false,
            fixedHeader: true,
            order: [],
            aaSorting: false,
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data) {
                        return data.NOMBRE + " Nro. <span style ='color:#E91E63'>" + data.NUMERO + " - " + data.ANIO +" </span> - SEDALIB S.A. - " + data.SIGLA_AREA +((data.SIGLAS_PERSONAL ==null )? '' :('/'+data.SIGLAS_PERSONAL) );
                    }
                },
                {data: "ASUNTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '13px');
                    }
                },
                {data: "OBSERVACIONES",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '13px');
                    }
                },
                {data: "TIEMPO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                        $(td).css('color', '#E91E63');
                    },
                    type: "date"
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var get_Select = $("#cmbTipoBuscar").val();
                        var cadena = "";
                        if(get_Select =='1'){
                            if(data.CANTIDAMOVIMIENTO == data.CANTIDARECIBIDOS){
                                cadena = cadena + "<span  style='font-size: 1.1em;'> \n\
                                    <i style='color: #1c84c6;' class='fa fa-file-text-o'>RECEPCIONADO</i>\n\
                                    </span>";
                            }else{
                                if(data.CANTIDARECIBIDOS == 0){
                                    cadena = cadena + "<span  style='font-size: 1.1em;'> \n\
                                        <i style='color: #ed5565;' class='fa fa-file-text-o'>NO RECEPCIONADO</i>\n\
                                    </span>";
                                }else{
                                    cadena = cadena + "<span  style='font-size: 1.1em;'> \n\
                                        <i style='color: #f8ac59;' class='fa fa-file-text-o'>EN PROCESO</i>\n\
                                    </span>";
                                }
                            }
                        }else{
                            if(data.ESTADOMOVIMIENTO=='1'){
                                cadena = cadena + "<span  style='font-size: 1.1em;'> \n\
                                    <i style='color: #1c84c6;' class='fa fa-check'> ATENDIDO</i>\n\
                                    </span>";
                            }else{
                                if(data.ESTADOMOVIMIENTO=='2'){
                                    cadena = cadena + "<span  style='font-size: 1.1em;'> \n\
                                        <i style='color: #D73925;' class='fa fa-briefcase'> ARCHIVADO</i>\n\
                                    </span>";
                                }else{
                                    cadena = cadena + "<span  style='font-size: 1.1em;'> \n\
                                        <i style='color: #f8ac59;' class='fa fa-times'> PENDIENTE</i>\n\
                                    </span>";
                                }
                                
                            }
                        }
                        return cadena;
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        
                        return ' <button type="button" class="btnAdjuntos btn btn-primary tooltips" title="Adjuntos" onclick="ListarAdjuntos('+data.IDDOCUMENTO+')"><i class="fa fa-paperclip"></i></button>\n\
                                 <button type="button" class="btnVerRef btn btn-warning " data-toggle="tooltip" data-placement="bottom" title="Referencias"  onclick="ListarDocsReferencias('+data.IDMOVIMIENTO +','+ data.IDDOCUMENTO +',\''+ data.NOMBRE +'\',\''+ data.NUMERO +'\',\''+ data.ANIO +'\',\''+ data.SIGLA_AREA  +'\',\''+ data.SIGLAS_PERSONAL+'\')"> <i class="fa fa-sitemap"></i></button>';
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i style="color:#3c8dbc;" class="fa fa-files-o"></i> Copiar',
                    "className": 'btn btn-primary',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i style="color:green" class="fa fa-file-excel-o"></i> Excel',
                    "className": 'btn  btn-primary',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                
                {
                    //extend: 'pdfHtml5',
                    text: '<i style="color:red;" class="fa fa-file-pdf-o"></i> PDF', "className": 'btn  btn-success',
                    action: function ( e, dt, node, config ) {
                        ExportarPdf();
                    }
                    /*exportOptions: {
                        columns: ':visible'
                    }*/
                }
            ]
        };

        oTable_Data = $("#tbl_report_data").dataTable(parms);
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
                        return '<button type="button" class="btnAdjuntos_red btn btn-primary tooltips"  onclick="ListarAdjuntosReferencia('+data.IDDOCUMENTO+')"    title="Archivos adjuntos"><i class="fa fa-paperclip"></i></button>';
                    }
                }
            ]
        }
        oTable_Refs = $("#tbl_referencias").dataTable(parms);
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

    

//DOCUMENTOS PENDIENTES AREA/TRABAJADOR
    var initDatableDocPd = function () {
        var parms = {
            data: null,
            info: false,
            fixedHeader: true,
            order: [],
            aaSorting: false,
            columns: [
                {data: null,
                    render: function (data) {
                        return data.TipoDoc + " " + data.Numero + "-" + data.Anio + "-" + data.Siglas + (data.idTipoDoc > 1 ? "-" + data.Parte : "");
                    }
                },
                {data: "Area"},
                {data: "Asunto"},
                {data: "fecha", type: "date"},
                {data: null,
                    render: function (data) {
                        return data.TipoDoc_de + " " + data.Numero_de + "-" + data.Anio_de + "-" + data.Siglas_de + (data.idTipoDoc > 1 ? "-" + data.Parte_de : "");
                    }
                },
                {data: "dias_pendiente", type: "date"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i> Copiar',
                    "className": 'btn btn-circle blue btn-default',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    "className": 'btn btn-circle green btn-default',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF', "className": 'btn btn-circle red-haze btn-default',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        };

        oTable_DocPd = $("#tbl_report_pendientes").dataTable(parms);
    };
//FISCALIZACION DE EXPEDIENTES
   

    var initDatablesFechas = function () {
        var parms = {
            data: null,
            info: true,
            fixedHeader: true,
            order: [],
            columns: [
                {data: "nomPro"},
                {data: "Numero"},
                {data: "Anio"},
                {data: "Siglas"},
                {data: "Parte"},
                {data: "Fecha", type: "date"}
            ],
            dom: 'Bfrtip',
            "buttons": [
                 { extend: 'pdf', text: 'PDF' },
                 { extend: 'excel', text: 'Excel' },

               ]
        }
        oTable_Fechas = $("#tbl_report_Fecha").dataTable(parms);
    };

    var initDatablesDocDepen = function () {
        var parms = {
            data: null,
            info: true,
            fixedHeader: true,
            order: [],
            columns: [
                {"data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }},
                {data: "f_rec_gerencia"},
                {data: "doc_referencia"},
                {data: "doc_salida",
                    createdCell: function (td, cellData, rowData, row, col) {
                        if (rowData.doc_salida_id == null) {
                            $(td).html('');
                        } else {
                            $(td).html(rowData.doc_salida);
                        }
                    }
                },
                {data: "doc_salida_asunto"},
                {data: "doc_salida_fec", type: "date"},
                {data: null,
                    render: function (data, type, row, meta) {
                        if ($("#cmbPersonal").find(':selected').data('cargo') === 1) {
                            return '<span class="label label-sm label-success">RESPONDIDO</span>';
                        } else {
                            if (data.ESTADO === 0) {
                                return '<span class="label label-sm label-danger">SIN RECIBIR</span>';
                            } else if (data.ESTADO === 1) {
                                return '<span class="label label-sm label-warning">RECIBIDO</span>';
                            } else if (data.ESTADO === 2) {
                                if (data.ARCHIVADO === 1) {
                                    return '<span class="label label-sm label-primary">ARCHIVADO</span>';
                                } else {
                                    if (data.doc_salida_id === null) {
                                        return '<span style="background-color: #b587bb" class="label label-sm ">SIN RESPUESTA</span>';
                                    } else {
                                        return '<span class="label label-sm label-success">RESPONDIDO</span>';
                                    }
                                }
                            }
                        }
                    },
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css({
                            'text-align': 'center',
                            'vertical-align': 'middle'
                        });
                    }
                },
                {data: "per_derivado"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i> Copiar',
                    "className": 'btn btn-circle blue btn-default',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    "className": 'btn btn-circle green btn-default',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                    "className": 'btn btn-circle red-haze btn-default',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        };
        oTable_DocDepen = $("#tbl_report_docdepen").dataTable(parms);
    };

    var initDatablesRepGen = function () {
        var parms = {
            data: null,
            info: false,
            fixedHeader: true,
            order: [],
            aaSorting: false,
            columns: [
                {data: "Documento"},
                {data: "Fecha"},
                {data: "Asunto"},
                {data: "Observacion"},
                {data: "Ubicacion"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i> Copiar',
                    "className": 'btn btn-circle blue btn-default',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    "className": 'btn btn-circle green btn-default',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF', "className": 'btn btn-circle red-haze btn-default',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]

        };

        oTable_RepGeneral = $("#tbl_report_expReg").dataTable(parms);
    };

    



    

    var ExportarPdf = function () {
        Cargando(1);
        var filtros = ObtenerFiltros();
        var tipo = $("#cmbTipoBuscar").val();
        json = JSON.stringify(new Array(
            filtros,
            tipo
        ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "Reportes/imprimir_pdf",
                //'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_reporte',
                'value': json,
                'type': 'hidden'
            }));
        $(document.body).append(form);
        form.submit();
        //console.log(filtros);
        Cargando(0);
    };

    var initChart = function () {
        if (typeof (AmCharts) === 'undefined' || $('#dashboard_chart').size() === 0) {
            return;
        }

        chart = AmCharts.makeChart("dashboard_chart", {
            
            "type": "serial",
            "addClassNames": true,
            "theme": "light",
            "path": "../frontend/plugins/ammap/images/",
            "autoMargins": false,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "pathToImages": "../frontend/plugins/amcharts/images/",
            "legend": {
                "equalWidths": false,
                "useGraphSettings": true,
                "valueAlign": "left",
                "valueWidth": 120
            },
            "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
            "startDuration": 1,
            "graphs": [{
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:12px;'>[[title]] el [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "fillAlphas": 1,
                    "title": "CANTIDAD",
                    "type": "column",
                    "valueField": "CANTIDAD",
                    "dashLengthField": "dashLengthColumn"
                }, {
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "useLineColorForBulletBorder": true,
                    "bulletColor": "#FFFFFF",
                    "bulletSizeField": "RESPUESTAS",
                    "descriptionField": "RESPUESTAS",
                    "legendValueText": "Docs. usados como respuesta",
                    "title": "Doc usado como respuesta",
                    "fillAlphas": 0,
                    "valueField": "RESPUESTAS",
                    "valueAxis": "latitudeAxis",
                    "id": "graph2",
                    "balloonText": "<span style='font-size:12px;'>[[title]] en [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderThickness": 3,
                }],
            "chartScrollbar": {},
            "chartCursor": {
                "categoryBalloonDateFormat": "DD",
                "cursorAlpha": 0.1,
                "cursorColor": "#000000",
                "fullWidth": true,
                "valueBalloonsEnabled": false,
                "zoomable": false
            },
            "categoryField": "TIEMPO",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0
            },
            "export": {
                "enabled": false
            }
        });
    }
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

    

    var eventos = function () {
        $(".filter-field").on("keydown", function () {
            var filter = $(this).val().toUpperCase();
            var parent = $(this).parent().parent().find("label");
            if (filter.trim().length == 0) {
                $(parent).removeClass("hide");
            } else {
                $(parent).filter(":not(:contains(" + filter + "))").addClass("hide");
                $(parent).filter(":contains(" + filter + ")").removeClass("hide");
            }
        });
        
        $("#txtDiaIngreso,#txtDiaFin").datepicker("setDate", new Date());
        $("#cmbTipoBuscar").select2();
        $('.btnGenerar').on('click', function () {
            var tipo = $("#cmbTipoBuscar").val();
            var title = $("#cmbTipoBuscar option:selected").text();
            $("#title-report").text(title);
            switch (tipo) {
                case "1":
                    Obtener_documentos_graph("Obtener_documentos_creados", 1);
                    break;
                case "2":
                    Obtener_documentos_graph("Obtener_documentos_recibidos", 2);
                    break;
                case "3":
                    Obtener_documentos_graph("Obtener_documentos_por_recibir", 3);
                    break;
                
                default:
                    break;
            }
        });

        $('#ch_rg_area').on('switchChange.bootstrapSwitch', function (event, state) {
            if (state)
            {
                $(".div_area").show();
            } else
            {
                $(".div_area").hide();
            }
        });

        $('#ch_rango').on('switchChange.bootstrapSwitch', function (event, state) {
            if (state)
            {
                $("#time_section_3").removeClass("hide");
            } else
            {
                $("#time_section_3").addClass("hide");
            }
        });

        $('#cmbTipoBuscar').on('change', function () {
            $(".cuerpo_reporte section").addClass("hide");
            var a = $(this).val() * 1;
            $("#filter_dependencias").addClass("hide");
            switch (a) {
                case 4:
                    $(".fiscalizacion").removeClass("hide");
                    break;
                case 5:
                    $(".silencio").removeClass("hide");
                    break;
                case 6:
                    $(".Expefechas").removeClass("hide");
                    break;
                case 7:
                    $(".docdepen").removeClass("hide");
                    break;
                case 8:
                    $(".repExpReg").removeClass("hide");
                    break;
                case 9:
                    $(".docPenAP").removeClass("hide");
                    $("#cmbDepDocP").prop('disabled', true);
                    var depen = $("#txt_depen").val();
                    $("#cmbDepDocP").val(depen).trigger('change');
                    var cargo = $("#txt_cargo").val();
                    if (cargo == 1) {
                        $("#cmbDepPer").prop('disabled', false);
                    } else {
                        $("#cmbDepPer").prop('disabled', true);
                    }
                    break;
                case 10:
                    $(".repExpTramifacil").removeClass("hide");
                    break;
                default:
                    $(".section_basico").removeClass("hide");
                    break;
            }
            if (a > 1) {
                return $("#filter_dependencias").removeClass("hide");
            }
        });
        $('ul[role="menu"] a').on("click", function () {
            $(this).parent().parent().parent().find(".container-name").addClass("bold").html($(this).text());
        });
        $("#cmbDepenGm").change(function () {
            var id = $(this).val();
            if (id == "") {
                return false;
            }

            $(".col-personal").removeClass("hide");
            $(".col-externo").addClass("hide");
            if (id == "99999999") {
                $(".col-personal").addClass("hide");
                $(".col-externo").removeClass("hide");
                return false;
            }

            Cargando(1);
            $.ajax({
                url: "CrearDocumento/Listar_personal_x_dependencia",
                datatype: "json",
                type: "post",
                async: true,
                data: {"id": id},
                success: function (data) {
                    Cargando(0);
                    var html = "";
                    $.each(data, function (index, item) {
//                        if (item.c_cargo ==! 1){
                        html += '<option value="' + item.dni + '" data-cargo="' + item.c_cargo + '">' + item.nombre + '</option>';
//                      }
                    });
                    $("#cmbPersonal").html(html);
                    $("#cmbPersonal").select2();
                },
                error: function (msg) {
                    setTimeout(function () {
                        Cargando(0);
                        Alerta("ERROR", "Error obtener la lista del personal de la dependencia seleccionada!", "2");
                    }, 900);
                }
            });
        });

        $("#cerrarArchiDocRef").click(function () {
            $('#modal_refs').modal('show');
            $('#modalArchivosRefe').modal('hide');
        });
        

        $("#cmbDepDocP").change(function () {
            var id = $(this).val();
            if (id == "") {
                return false;
            }
            $(".col-personal").removeClass("hide");
            $(".col-externo").addClass("hide");
            if (id == "99999999") {
                $(".col-personal").addClass("hide");
                $(".col-externo").removeClass("hide");
                return false;
            }
            Listar_personal_x_dependencia(id);
        });
        $("#cmbMesExpRep").select2();
    };

    var Listar_meses = function () {
        var mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];

        for (var i = 0; i < mes.length; i++) {
            var option = document.createElement("option");
            $(option).html(mes[i]);
            $(option).val(i + 1);
            $(option).appendTo("select[data-name='mes']");
        }
    }

    var Listar_personal_x_dependencia = function (id) {
        Cargando(1);
        $.ajax({
            url: "CrearDocumento/Listar_personal_x_dependencia",
            datatype: "json",
            type: "post",
            async: true,
            data: {"id": id},
            success: function (data) {
                Cargando(0);
                var html = '';
                $.each(data, function (index, item) {
//                    if (item.c_cargo == !1) {
                    html += '<option value="' + item.dni + '">' + item.nombre + '</option>';
//                    }
                });
                $("#cmbDepPer").html(html);
                $("#cmbDepPer").select2();
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista del personal de la dependencia seleccionada!", "2");
                }, 900);
            }
        });
    };

    var ObtenerFechas = function (data) {
        Cargando(1);
        $.ajax({
            url: "Reportes/ExpPorFechas",
            datatype: "json",
            type: "post",
            async: true,
            data: data,
            success: function (data) {
                Cargando(0);
                oTable_Fechas.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_Fechas.fnAddData(data);
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener expedientes por fecha.", "2");
                }, 900);
            }
        });
    };

    var ObtenerFiscalizacionAleatoria = function (data) {
        Cargando(1);
        $.ajax({
            url: "Reportes/Fiscalizacion_Aleatoria",
            datatype: "json",
            type: "post",
            async: true,
            data: data,
            success: function (data) {
                Cargando(0);
                oTable_Fiscalizacion.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_Fiscalizacion.fnAddData(data);
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de expedientes.", "2");
                }, 900);
            }
        });
    };

    var ObtenerSilencio = function (data) {
        Cargando(1);
        $.ajax({
            url: "Reportes/Silencio_Administrativo",
            datatype: "json",
            type: "post",
            async: true,
            data: data,
            success: function (data) {
                Cargando(0);
                oTable_Silencio.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_Silencio.fnAddData(data);
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de expedientes.", "2");
                }, 900);
            }
        });
    };

    var ObtenerDocDepen = function (data) {
        Cargando(1);
        $.ajax({
            url: "Reportes/Documento_Dep_x_Per",
            datatype: "json",
            type: "post",
            async: true,
            data: data,
            success: function (data) {
                Cargando(0);
                oTable_DocDepen.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_DocDepen.fnAddData(data);
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener obtener documentos asignados.", "2");
                }, 900);
            }
        });
    };

    var ObtenerFiltros = function () {
        var documentos = [];
        var documentos_desc = [];
        var dependencias = [];
        var dependencias_desc = [];
        var title = $("#cmbTipoBuscar option:selected").text();
        $("#filter_documents").find("input[type='checkbox']").each(function (index, item) {
            if ($(this).is(":checked")) {
                if ($(this).attr("value") == "0") {
                    return false;
                }
                documentos.push($(this).attr("value"));
                documentos_desc.push($(this).parent().text());
            }
        });
       
        $("#filter_dependencias").find("input[type='checkbox']").each(function (index, item) {
            if ($(this).is(":checked")) {
                if ($(this).attr("value") == "0") {
                    return false;
                }
                dependencias.push($(this).attr("value"));
                dependencias_desc.push($(this).parent().text());
            }
        });
        return {
            "fecha": [{
                    "inicio": $('#reportrange').data('daterangepicker').startDate.format("DD/MM/YYYY"),
                    "fin": $('#reportrange').data('daterangepicker').endDate.format("DD/MM/YYYY")
                }],
            "fecha_desc": $('#reportrange span').html(),
            "documentos": documentos,
            "documentos_desc": documentos_desc,
            "dependencias": dependencias,
            "dependencias_desc": dependencias_desc,
            "title": title
        };
    };

    
    var MostrarFiltros = function () {
        var filtros = ObtenerFiltros();
        var badge = $("#parent-badge");
        $("#settings_documentos").find(".todo-tasklist-badge").remove();
        if (filtros.documentos_desc.length > 0) {
            $(filtros.documentos_desc).each(function (index, data) {
                var clone = badge.clone().attr("id", "").removeClass("hide").text(data);
                $("#settings_documentos").append(clone);
            });
        } else {
            var clone = badge.clone().attr("id", "").removeClass("hide").text("TODOS");
            $("#settings_documentos").append(clone);
        }

        $("#settings_dependencias").find(".todo-tasklist-badge").remove();
        if (filtros.dependencias_desc.length > 0) {
            $(filtros.dependencias_desc).each(function (index, data) {
                var clone = badge.clone().attr("id", "").removeClass("hide").text(data);
                $("#settings_dependencias").append(clone);
            });
        } else {
            var clone = badge.clone().attr("id", "").removeClass("hide").text("TODAS");
            $("#settings_dependencias").append(clone);
        }

        $("#settings_tiempo").find(".todo-tasklist-badge").text(filtros.fecha_desc);
    }

    var ListarDependencias = function () {
        Cargando(1);
        $.ajax({
            url: "CrearDocumento/Listar_dependencias",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                var html = "";
                $.each(data, function (index, item) {
                    html += '<option value="' + item.IDORGANIGRAMA + '">' + item.NOMBREAREA + '</option>';
                    $("#filter_dependencias div[role='menu']")
                            .append('<label><input type="checkbox" value="' + item.IDORGANIGRAMA + '"> ' + item.NOMBREAREA + '</label><label>');
                });
                $("#cmbDependencia").html(html).select2();
                $("#cmbDependenciaFecha").html(html).select2();
                $("#cmbDepenGm").html(html).select2();
                $("#cmbDepDocP").html(html).select2();
                $("#cmbDepExpArea").html(html).select2();
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de dependencias!", "2");
                }, 900)
            }
        });
    }

    var ListarTiposDocumento = function () {
        Cargando(1);
        $.ajax({
            url: "CrearDocumento/Listar_tipos_documento",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                $.each(data, function (index, item) {
                    $("#filter_documents div[role='menu']")
                            .append('<label><input type="checkbox" value="' + item.IDTIPODOCUMENTO + '"> ' + item.NOMBREDOCUMENTO + '</label><label>');
                });
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de tipos de documento!", "2");
                }, 900);
            }
        });
    }

    var Obtener_documentos_graph = function (url, tipo) {
        Cargando(1);
        $.ajax({
            url: 'Reportes/' + url,
            type: 'POST',
            dataType: "json",
            data: ObtenerFiltros(),
            global: false,
            success: function (data) {
                Cargando(0);
                MostrarFiltros();
                chart.dataProvider = data.graph;
                chart.validateData();
                $("#data-table").addClass("hide");
                if (data.graph.length == 0) {
                    Alerta("ADVERTENCIA", "No se encontraron datos para los filtros seleccionados.", "4");
                    oTable_Data.fnClearTable();
                    $("#data-table").removeClass("hide");
                    return false;
                }
                oTable_Data.fnClearTable();
                $("#data-table").removeClass("hide");
                oTable_Data.fnAddData(data.table);
                
                if (tipo === 1) {
                    //oTable_Data.fnSetColumnVis(3, false);
                    //oTable_Data.fnSetColumnVis(4, false);
                } else if (tipo === 2) {
                    //oTable_Data.fnSetColumnVis(3, true);
                    //oTable_Data.fnSetColumnVis(4, false);
                } else if (tipo === 3) {
                    //oTable_Data.fnSetColumnVis(3, false);
                    //oTable_Data.fnSetColumnVis(4, false);
                }

                Cargando(0);
            },
            error: function () {
                Cargando(0);
                Alerta("ERROR", "Error al obtener documentos", "2");
            }
        });
    };

    var ObtenerRepGeneralExp = function (data) {
        $("#span_total").html(0);
        Cargando(1);
        $.ajax({
            url: "Reportes/Reporte_General_Tipo_Exp",
            datatype: "json",
            type: "post",
            async: true,
            data: data,
            success: function (data) {
                Cargando(0);
                if (data.length == 0) {
                    Alerta("<b>ADVERTENCIA</b>", "<b>No se encontraron datos para los filtros seleccionados.</b>", "4");
                    oTable_RepGeneral.fnClearTable();
                    $("#span_total").html(0);
                    return false;
                }
                oTable_RepGeneral.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_RepGeneral.fnAddData(data);
                }

                var table = $('#tbl_report_expReg').DataTable();
                $("#span_total").html(table.data().count());

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("<b>ERROR</b>", "<b>Error obtener obtener documentos asignados.</b>", "2");
                }, 900);
            }
        });
    }

    var ObtenerRepTramifacil = function (data) {
        $("#span_total_tf").html(0);
        Cargando(1);
        $.ajax({
            url: "Reportes/Reporte_Tramifacil",
            datatype: "json",
            type: "post",
            async: true,
            data: data,
            success: function (data) {
                Cargando(0);
                if (data.length == 0) {
                    Alerta("<b>ADVERTENCIA</b>", "<b>No se encontraron datos para los filtros seleccionados.</b>", "4");
                    oTable_Tramifacil.fnClearTable();
                    $("#span_total_tf").html(0);
                    return false;
                }
                oTable_Tramifacil.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_Tramifacil.fnAddData(data);
                }
                var table = $('#tbl_tramifacil').DataTable();
                $("#span_total_tf").html(table.data().count());

            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("<b>ERROR</b>", "<b>Error obtener obtener documentos asignados.</b>", "2");
                }, 900);
            }
        });
    }

    var ObtenerRepDocPd = function (data) {
        Cargando(1);
        $.ajax({
            url: "Reportes/Reporte_Documento_Pd",
            datatype: "json",
            type: "post",
            async: true,
            data: data,
            success: function (data) {
                Cargando(0);

                if (data.length == 0) {
                    Alerta("<b>ADVERTENCIA</b>", "<b>No se encontraron documentos pendientes.</b>", "4");
                    oTable_DocPd.fnClearTable();
                    return false;
                }

                oTable_DocPd.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_DocPd.fnAddData(data);
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("<b>ERROR</b>", "<b>Error obtener obtener documentos asignados.</b>", "2");
                }, 900);
            }
        });
    }


    var Listar_siglas_documento = function (idTipoDoc) {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumento/Listar_siglas_documento",
            datatype: "json",
            type: "post",
            async: true,
            data: {"idTipoDoc": idTipoDoc},
            success: function (data) {
                Cargando(0);
                var html = "";
                $.each(data, function (index, item) {
                    html += '<option value="' + item.siglas + '">' + item.siglas + '</option>';
                });
                $("select[data-name='siglas']").html(html).select2();
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de tipos de documento!", "2");
                }, 900);
            }
        });
    };

    var Listar_anios_documento = function (idTipoDoc) {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumento/Listar_anios_documento",
            datatype: "json",
            type: "post",
            async: true,
            data: {"idTipoDoc": idTipoDoc},
            success: function (data) {
                Cargando(0);
                var html = "";
                console.log(data);
                $.each(data, function (index, item) {
                    html += '<option value="' + item.anio + '">' + item.anio + '</option>';
                });
                $("select[data-name='anios']").html(html).select2();
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de tipos de documento!", "2");
                }, 900);
            }
        });
    };

    var CargaInicial = function () {
        $(".datepicker-control").datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#reportrange').daterangepicker({
            opens: 'right',
            startDate: moment().subtract('month', 1),
            endDate: moment(),
            maxDate: moment(),
            showDropdowns: true,
            showWeekNumbers: true,
//            ranges: {
//                'Hoy': [moment(), moment()],
//                'Ayer': [moment().subtract('days', 1), moment().subtract('days', 1)],
//                'Últimos 7 dias': [moment().subtract('days', 6), moment()],
//                'Últimos 30 dias': [moment().subtract('days', 29), moment()],
//                'Este Mes': [moment().startOf('month'), moment().endOf('month')],
//                'Último Mes': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
//            },
            buttonClasses: ['btn'],
            autoApply: true,
            format: 'DD/MM/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Apply',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                daysOfWeek: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'],
                monthNames: ['Enero', 'Febreo', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Deciembre'],
                firstDay: 1
            }
        },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
        );
        $('#reportrange span').html(moment().subtract('month', 1).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    }

    return {
        init: function () {
//             plugins();
            initChart();
            eventos();
            CargaInicial();
            //Listar_siglas_documento(1);
            Listar_anios_documento(1);
            ListarTiposDocumento();
            ListarDependencias();
            Obtener_documentos_graph("Obtener_documentos_creados", 1);
            initDatables();
            initDatablesRepGen();
            initDatablesRefs();
            initDatablesAdjuntos();
            initDatableDocPd();
            initDatablesAdjuntosRefe();
            initDatablesFechas();
            initDatablesDocDepen();
            Listar_meses();
            // Listar_usuarios();
        }
    };
}();



