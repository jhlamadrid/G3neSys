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

function ValidateForm(form, rules, callback) {
    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);
    form.validate({
        doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: rules,
        errorPlacement: function (error, element) { // render error placement for each input type
            error.insertAfter(element); // for other inputs, just perform default behavior
        },
        invalidHandler: function (event, validator) { //display error alert on form submit   
            success.hide();
            error.show();
            App.scrollTo(error, -200);
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                    .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                label
                        .closest('.form-group').removeClass('has-error').addClass('has-success');
                label.remove(); // remove error label here
            } else { // display success icon for other inputs
                label
                        .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            }
        },
        submitHandler: function (form) {
            success.show();
            error.hide();
            callback();
            //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
        }

    });
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

    var accion = '';

    var Validate = function () {
        var form = $("#frm1");
        var rules = {
            tipdoc_int: {
                required: true
            },
            nrodoc_int: {
                required: true,
                maxlength: 100
            },
            correo_int: {
                email: true,
                maxlength: 150
            },
            nom_int: {
                required: true,
                maxlength: 100
            },
            dir_int: {
                required: true,
                maxlength: 400
            },
            folios: {
                required: true,
                number: true
            },
            foliosDoc: {
                required: true,
                number: true
            },
            cbo_tipo_doc: {
                required: true
            }
        };
        ValidateForm(form, rules, Registra);
    };

    var initDatables = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: "nombre",
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
                        return '<button type="button" class="btnEliminar btn btn-danger" ><i class="fa fa-remove"></i></button>';
                    }
                }
            ]
        };
        oTable_Data = $("#tbl_sis_destinatarios").dataTable(parms);
    };

    var initDatablesCopias = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: "nombre",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#3F51B5');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    },

                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {

                        var cant = $('#txtFolioDoc').val();
                        if (cant === "") {
                            cant = 0;
                        }
                        $(td).html('<input type="text" class="input-folios" value="' + cant + '"/>');
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
        oTable_Copias = $("#tbl_sis_copias").dataTable(parms);

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
                        var cadena = data.NOMBREDOCUMENTO+' Nro. <span  style="color:#e41d20;">  '+data.NUMERODOCUMENTO+' - '+data.ANIO+' </span> - '+'SEDALIB S.A. - '+  data.SIGLA_AREA;
                        if(data.SIGLAS_PERSONAL != null){
                            cadena = cadena + '/' +  data.SIGLAS_PERSONAL;
                        }
                        return cadena;
                    }

                },
                {data: "FOLIOS",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('color', '#E91E63');
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

                        $(td).html('<select class="form-control selEstaDoc" > <option value ="A"> ATENDIDO </option> <option value ="P">PENDIENTE</option> </select>');
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnVerRef btn btn-warning " data-toggle="tooltip" data-placement="bottom" title="Referencias"><i class="fa fa-sitemap"></i></button>\n\
                                 <button type="button" class="btnEliminar btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i class="fa fa-remove"></i></button>';
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
                        return '<button type="button" class="btnSelectRef btn green-jungle btn-xs" data-toggle="tooltip" data-placement="top" title="Seleccionar"><i class="fa fa-check"></i></button>';
                    }
                }

            ]
        }
        oTable_SRefs = $("#tbl_search_refs").dataTable(parms);
    };

    var initDatablesMisDocs = function (){
        var parms = {
            data: null,
            info: false,
            searching: true,
            info: false,
            paging: true,
            ordering: false,
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '18px');
                    },
                    render: function (data) {
                        var cadena = data.NOMBREDOCUMENTO+' Nro. <span  style="color:#e41d20;">  '+data.NUMERODOCUMENTO+' - '+data.ANIO+' </span> - '+'SEDALIB S.A. - '+ data.SIGLAAREAGEN;
                        if(data.SIGLAPERSONAGEN != null){
                            
                            cadena = cadena + '/' +  data.SIGLAPERSONAGEN;
                        }
                        return cadena;

                    }

                },
                {data: "ASUNTO",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#000');
                        $(td).css('font-weight', 'normal');
                        $(td).css('font-size', '14px');
                    }
                },
                {data: "FECHACREACION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('color', '#000');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '15px');
                    }
                },
                {data: "FECHAMAXATENCION",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('color', '#000');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '15px');
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data) {
                        var cadena = "";
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
                        return cadena;

                    }

                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnAdjuntos btn btn-primary tooltips" title="Adjuntos"><i class="fa fa-paperclip"></i></button>\n\
                        <button type="button" class="btnVerRef btn btn-warning " data-toggle="tooltip" data-placement="bottom" title="Referencias"><i class="fa fa-sitemap"></i></button>\n\
                        <button type="button" class="btnDetalleDoc btn btn-success tooltips" title="Detalle de envios"><i class="fa fa-search"></i></button>';
                    }
                }
            ]
        }
        oTable_MyDocs = $("#tbl_docint_creados").dataTable(parms);
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

    var initDatablesArchiCargo = function () {
        var parms = {
            data: null,
            info: false,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            columns: [
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var cadena ='';
                        if(data.INDCOPIA == 1){
                            cadena = cadena + '<span  style="font-size: 20px;" ><i style="color: #4caf50;" class="fa fa-file"></i>&nbsp;COPIA</span>';
                        }
                        return cadena;
                    }

                },
                {data: "NOMBREAREA",
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '14px');
                    }

                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var cadena ='';
                        if(data.ESTADOENVIO == 1){
                            cadena = cadena + '<span > <i  style="color: #ed5565;" class="fa fa-file-text-o"></i> NO RECEPCIONADO </span>';
                        }else{
                            cadena = cadena + '<span > <i  style="color: #1c84c6;" class="fa fa-file-text-o"></i> RECEPCIONADO </span>';
                        }
                        return cadena;
                    }

                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var cadena ='';
                        if(data.ESTADOENVIO == 2){
                            cadena = cadena + '<button type="button" class="btnCargArchi btn btn-success "  data-toggle="tooltip" data-placement="bottom" title="Cargo de documento"><i class="fa fa-file-pdf-o"></i></button>';
                        }
                        return cadena;
                    }
                }
            ]
        }
        oTable_ArchiCargo = $("#tbl_archi_cargo").dataTable(parms);
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
                    fecha_anterior= data.fecha_anterior;
                    $("#NSUM-INI").val(fecha_actual);
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
                        "startDate": fecha_actual,
                        "minDate": fecha_actual,
                        //"maxDate": fecha_actual,
                        //"maxDate" : convert_dmy(sumar_date(get_date(max), (-1*24*60*1000))),
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

                    /* PARA LAS FECHAS DE MIS DOCUMENTOS */
                    $("#MISDOC-INI").val(fecha_anterior);
                    $('#MISDOC-INI').daterangepicker({
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
                        "startDate": fecha_anterior,
                        "maxDate": fecha_actual,
                        //"maxDate": fecha_actual,
                        //"maxDate" : convert_dmy(sumar_date(get_date(max), (-1*24*60*1000))),
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

                    $("#MISDOC-FIN").val(fecha_actual);
                    $('#MISDOC-FIN').daterangepicker({
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
                        "startDate": fecha_actual,
                        "maxDate": fecha_actual,
                        //"maxDate": fecha_actual,
                        //"maxDate" : convert_dmy(sumar_date(get_date(max), (-1*24*60*1000))),
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
                    ListarDocsCreados();
                }
            }
        });
    }

    var initDatablesRefsModal = function () {
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
        oTable_RefModal = $("#tbl_referencias").dataTable(parms);
    }



    var eventos = function () {
        $("#txtFolioDoc").val(0);
        $("#txtFolios").numeric();
        $("#txtFolioDoc").numeric();
        $("#txtFolios").on("keyup", function (e) {
            var valor = $(this).val(),
                    suma = 0,
                    data = oTable_Refs.fnGetData(),
                    total = 0;

            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    suma = suma + parseInt(data[i].FOLIOS);
                }
            }
            if ($.isNumeric(valor)) {
                valor = valor * 1;
            } else {
                valor = 0;
            }

            total = suma + valor;
            $("#txtFolioDoc").val(total);

        });
        $("#MISDOC-INI").change(function(){
            ListarDocsCreados();
        });
        $("#MISDOC-FIN").change(function(){
            ListarDocsCreados();
        });
        $( "#selMisDoc" ).change(function() {
            ListarDocsCreados();
        });
        $( "#selEstaMisDoc" ).change(function() {
            ListarDocsCreados();
        });
        $("#btnAgregarPer").click(function () {
            $(this).blur();
            var len = oTable_Data.fnGetData().length,
                    row = oTable_Data.fnGetData(),
                    dni = $("#cmbPersonal").val();

            if ($("#cmbPersonal").val() === 'N') {
                Alerta("ADVERTENCIA", "Selecciona una persona por favor!", "4");
                return;
            }
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    if (row[i].dni.trim() === dni.trim()) {
                        Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                        return;
                    }
                }

            }


            var data = {
                "dni": $("#cmbPersonal").val(),
                "idDepend": $("#cmbNombre").val(),
                "nombre": $("#cmbNombre option:selected").text() + "____" + $("#cmbPersonal option:selected").text()
            };
            Agregar_destinatario_tbl(data);
            $("#cmbPersonal").val('N').trigger('change');



        });

        $("#txtFolioDoc").on("keypress", function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message      
                return false;
            }
        });


        $("#tbl_sis_copias").on("keypress", '.input-folios', function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message      
                return false;
            }
        });


        $("#txtBuscarRef").on("keypress", function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message      
                return false;
            }
        });

        $("#ok").click(function () {
            location.reload();
        });

        $("#btnBuscarRefe").click(function () {
            $(this).blur();

            getRefs();
        });

        $("#btnBuscarRefs").click(function () {
            $(this).blur();
            $("#txtBuscarRef").val("");
            oTable_SRefs.fnClearTable();
            $("#modal_refs").modal("show");
        });

        $("#btnAgregar").click(function () {
            $(this).blur();
            if ($("#cmbNombre").val() === 'N') {
                Alerta("ADVERTENCIA", "Selecciona una persona por favor!", "4");
                return;
            }

            var tipo = $("#btnAgregar").attr("tipo");
            tipo ='P';
            if (tipo === 'P') {

                var len = oTable_Data.fnGetData().length,
                        row = oTable_Data.fnGetData(),
                        dni = $("#cmbNombre").val();


                var dataCopias = oTable_Copias.fnGetData(),
                    lenCopias = oTable_Copias.fnGetData().length;
                if (lenCopias > 0) {
                    for (var i = 0; i < lenCopias; i++) {
                        if (dataCopias[i].dni.trim() === dni.trim()) {
                            Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                            return;
                        }
                    }
                }


                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        if (row[i].dni.trim() === dni.trim()) {
                            Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                            return;
                        }
                    }

                }
                var data = {
                    "dni": $("#cmbNombre").val(),
                    "idDepend": $("#cmbNombre option:selected").attr("cod_depen"),
                    "nombre": $("#cmbNombre option:selected").text()
                };
                Agregar_destinatario_tbl(data);
                $("#cmbNombre").val('N').trigger('change');
            } else if (tipo === 'D') {
                var entExterna = $('#chkEntExt').is(":checked");
                if (entExterna) {
                    var len = oTable_Data.fnGetData().length;
                    if (len === 1) {
                        Alerta("ADVERTENCIA", "No se puede agregar mas de un destinatario!", "4");
                        return;
                    }

                    var data = {
                        "dni": '99999999',
                        "idDepend": $("#cmbNombre").val(),
                        "nombre": $("#cmbNombre option:selected").text(),
                        "indGerente": 1
                    };

                    Agregar_destinatario_tbl(data);
                    $("#cmbNombre").val('N').trigger('change');
                    return;
                }



                if ($("#cmbNombre").val() !== 'T') {
                    getFuncionario();
                    return;
                }

                oTable_Data.fnClearTable();
                Listar_gerentes_y_subgerentes();

            }


        });

        $("#btnAgregar2").click(function () {
            $(this).blur();
            var len = oTable_Data.fnGetData().length;
            var tipo = $("#btnAgregar2").attr("tipo");
            tipo ='P';
            if (len === 0) {
                Alerta("ADVERTENCIA", "No se puede agregar copias, Agregar primero un destinatario por favor!", "4");
                return;
            }

            if ($("#cmbNombre2").val() === 'N') {
                Alerta("ADVERTENCIA", "Selecciona una persona por favor!", "4");
                return;
            }
            if (tipo === 'P') {

                var row = oTable_Data.fnGetData(),
                        dni = $("#cmbNombre2").val(),
                        lenCopias = oTable_Copias.fnGetData().length,
                        rowCopias = oTable_Copias.fnGetData();
                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        if (row[i].dni.trim() === dni.trim()) {
                            Alerta("ADVERTENCIA", "No se puede agregar una copia al mismo destinatario!", "4");
                            return;
                        }
                    }
                }



                if (lenCopias > 0) {
                    for (var i = 0; i < lenCopias; i++) {
                        if (rowCopias[i].dni.trim() === dni.trim()) {
                            Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                            return;
                        }
                    }

                }

                var data = {
                    "dni": $("#cmbNombre2").val(),
                    "idDepend": $("#cmbNombre2 option:selected").attr("cod_depen"),
                    "nombre": $("#cmbNombre2 option:selected").text()
                };
                Agregar_destinatario_copia_tbl(data);
                $("#cmbNombre2").val('N').trigger('change');


            } else if (tipo === 'D') {
                getFuncionario2();

            }


        });


        $("#btnAgregarTotal").click(function () {
            $(this).blur();
            var tipo = $("#cmbDestinatarioTotal").val();
            if (tipo === '1') {
                oTable_Data.fnClearTable();
                Listar_gerentes_y_subgerentes();
            } else if (tipo === '2') {
                oTable_Data.fnClearTable();
                Listar_personal_dependencia_actual();
            }

        });

        $("#btnLimpiar").click(function () {
            $(this).blur();
            oTable_Data.fnClearTable();
        });


        $("#chkPersonal").click(function () {
            var valor = $("#chkPersonal").is(":checked");
            $("#divCboPersonal").attr("style", "display:none;");
            $("#btnAgregar").show();
            $("#cmbNombre").unbind("change");
            oTable_Data.fnClearTable();
            oTable_Copias.fnClearTable();

            if (valor) {

                ListarPersonalxDependencias(valor);

            } else {
                Listar_dependencia2(3);
                //$('#opTG').prop('disabled', !$('#opTG').prop('disabled'));
                //$('select').select2();
            }

        });



        $("#btnGuardar").click(function () {
            $(this).blur();
            Registra();
        });
        $('#tbl_sis_destinatarios tbody').on('click', '.btnEliminar ', function () {

            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                    len = 0;
            oTable_Data.fnDeleteRow(pos);
            len = oTable_Data.fnGetData().length;
            if (len === 0) {
                oTable_Copias.fnClearTable();
            }


        });

        $('#tbl_sis_copias tbody').on('click', '.btnEliminar', function () {

            var pos = oTable_Copias.api(true).row($(this).parents("tr")[0]).index();
            oTable_Copias.fnDeleteRow(pos);
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

            oTable_Refs.fnAddData(dataRefAdd);
            calcularSumaFolios();
            if ($("#divResolver").hasClass("hide")) {
                $("#divResolver").removeClass("hide");
            }
            $('[data-toggle="tooltip"]').tooltip();
            $("#msgExito").show().delay(1500).fadeOut();
        });

        $('#tbl_refs tbody').on('click', '.btnEliminar', function () {

            var pos = oTable_Refs.api(true).row($(this).parents("tr")[0]).index();
            oTable_Refs.fnDeleteRow(pos);
            calcularSumaFolios();
            var data = oTable_Refs.fnGetData();
            if (data.length <= 0) {
                if (!$("#divResolver").hasClass("hide")) {
                    if ($("#chkResolver").is(":checked")) {
                        $("#chkResolver").click();
                    }
                    $("#divResolver").addClass("hide");
                }
            }

        });

        $('#tbl_docint_creados tbody').on('click', '.btnAdjuntos', function () {
            var pos = oTable_MyDocs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_MyDocs.fnGetData(pos);
            ListarAdjuntos(data.IDDOCUMENTO);
        });

        $('#tbl_referencias tbody').on('click', '.btnAdjuntos_red', function () {
            var pos = oTable_RefModal.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_RefModal.fnGetData(pos);
            $('#modal_refsInfo').modal('hide');
            ListarAdjuntosReferencia(data.IDDOCUMENTO);
        });

        $('#tbl_docint_creados tbody').on('click', '.btnVerRef', function () {
            var pos = oTable_MyDocs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_MyDocs.fnGetData(pos);
            console.log(data);
            $("#sp_doc_ref").html(data.NOMBREDOCUMENTO + ' NRO. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO + ' - SEDALIB S.A. - '+data.SIGLAAREAGEN  +((data.SIGLAPERSONAGEN == null )? '' :('/'+ data.SIGLAPERSONAGEN ) )  );
            ListarDocsReferencias(data.PRIMOVIMIENTO);
        });
        

        // Para el boton de cargo 
        $('#tbl_archi_cargo tbody').on('click', '.btnCargArchi', function () {
            var pos = oTable_ArchiCargo.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_ArchiCargo.fnGetData(pos);
            imprimir_cargo(data.IDMOVIMIENTO);
        });

        $('#tbl_docint_creados tbody').on('click', '.btnDetalleDoc', function () {
            var pos = oTable_MyDocs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_MyDocs.fnGetData(pos);
            ListarAreaRecepcionaron(data.IDDOCUMENTO);
        });
        

        $("#cbo_tipo_doc").on("change", function (e) {
            oTable_Data.fnClearTable();
            oTable_Copias.fnClearTable();
            $('#chkEntExt').removeAttr('checked');
			$("#chkEntExt").attr("disabled", false);
            $("#divInputEntExt").attr("style","display:none");
            $("#divChkPersonal").attr("style", "display:none;");
            $("#divBtnAddDestinos").attr("style", "display:block;");
            
            if(tipo_cargo == 1){
                $("#divEntExt").removeClass("hide");
                $("#divCopias").attr("style","display:block");
                $("#divOpcMemo").attr("style","display:none");
                $("#divChkPersonal").attr("style", "display:block;margin-bottom: 1%;");
                $("#radio14").prop("checked", true);
                $("#btnAgregar").show();
                $("#cmbNombre").unbind("change");
                $('#cmbPersonal').html("");
            }else{
                console.log("imprimiendo");
                $("#divCopias").attr("style","display:none");
                $("#sec_destinatario").attr("style","display:none");
            }
            
            

            getTipoxTipoDoc();

        });
        
        
         $(".md-radiobtn").click(function(){
            var radioValue = $("input[name='radio2']:checked").val();
          
            oTable_Data.fnClearTable();
            oTable_Copias.fnClearTable();
            
            if(radioValue){
              if(radioValue === 'd'){
                    $("#divCboPersonal").attr("style", "display:none;");
                     $("#divBtnAddDestinos").attr("style", "display:block;");
                        $("#divInputEntExt").attr("style", "display:none;");   
                    $("#btnAgregar").show();
                    $("#cmbNombre").unbind("change");
                    $('#cmbPersonal').html("");
                    Listar_depend_Jerarquia(1);
                    
                    
                    
              }else if(radioValue === 'p'){
                    $("#divCboPersonal").attr("style", "display:block;");
                     $("#divBtnAddDestinos").attr("style", "display:block;");
                      $("#divInputEntExt").attr("style", "display:none;");     
                    $("#btnAgregar").hide();
                    
                    
                    $("#cmbNombre").on("change", function (e) {
                    var valor = $(this).val();
                    if (valor !== 'N' && valor !== 'T') {
                        ListarPersonalxDependencias(valor);
                    }
                });
                  Listar_depend_Jerarquia(2);   
              }else if(radioValue === 'e'){
                    $("#divCboPersonal").attr("style", "display:none;");
                     $("#divBtnAddDestinos").attr("style", "display:none;");
                     $("#txtEntidadExterna").val('');
                     $("#divInputEntExt").attr("style", "display:block;");     
                    $("#cmbNombre").unbind("change");
                    $('#cmbPersonal').html(""); 
              }
            }
        });


        $('#tbl_refs tbody').on('click', '.btnVerRef', function () {
            var pos = oTable_Refs.api(true).row($(this).parents("tr")[0]).index(),
                    data = oTable_Refs.fnGetData(pos);
            console.log(data);
            $("#sp_doc_ref").html(data.NOMBREDOCUMENTO + ' NRO. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO + ' - SEDALIB S.A. - '+data.SIGLA_AREA  +((data.SIGLAS_PERSONAL == null)? '' :('/'+data.SIGLAS_PERSONAL) )  );
            ListarDocsReferencias(data.IDMOVIMIENTO);

        });

        $('#chkEntExt').on('click', function () {
            var estado = $('#chkEntExt').is(":checked");
            oTable_Data.fnClearTable();
            oTable_Copias.fnClearTable();
            oTable_Refs.fnClearTable();

            if (estado) {
               $("#txtEntidadExterna").val('TRAMITE DOCUMENTARIO');
               $("#txtEntidadExterna").attr("disabled", true);
               $("#divCopias").attr("style","display:none");
               $("#divBtnAddDestinos").hide();
               $("#divChkPersonal").attr("style", "display:none;");
               $("#divInputEntExt").show();
               
            } else {
                $("#divCopias").attr("style","display:block");
                $("#divBtnAddDestinos").show();
                $("#divChkPersonal").attr("style", "display:block;");
                $("#divInputEntExt").hide();
                getTipoxTipoDoc();
            }



        });
        
        $("#cerrarArchiDocRef").click(function () {
            $('#modal_refsInfo').modal('show');
            $('#modalArchivosRefe').modal('hide');
        });
        
         $("#btnAgregarExt").click(function () {
            $(this).blur();
              var entExterna = $("#chkEntExt").is(":checked") ||  $("#radio16").is(":checked")
              
              
              
            if ($("#txtEntidadExterna").val() === '') {
                Alerta("ADVERTENCIA", "Ingresa una entidad externa por favor!", "4");
                return;
            }

            
                if (entExterna) {
                    var len = oTable_Data.fnGetData().length,
					     tipo_doc = $("#cbo_tipo_doc").val()*1;
					
					
					if(tipo_doc === 6){ // para q permita agregar muchos destinos
						len = 0;
					}
					
					
					
                    if (len === 1) {
                        Alerta("ADVERTENCIA", "No se puede agregar mas de un destinatario!", "4");
                        return;
                    }

                    var data = {
                        "dni": '61',
                        "idDepend": 61,
                        "nombre": $("#txtEntidadExterna").val().toUpperCase(),
                        "indGerente": 1
                    };

                    Agregar_destinatario_tbl(data);
                   //$("#txtEntidadExterna").val('');
                    return;
                }

        });


    };


    var imprimir_cargo = function(id_movimiento){
        json = JSON.stringify(new Array(
            id_movimiento
        ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "imprimir_cargo/nuevo",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_cargo',
                'value': json,
                'type': 'hidden'
            }));
        $(document.body).append(form);
        form.submit();
    }



    var GuardarDocInt = function () {
        
        var asunto  = ($("#txtAsunto").val()).trim();
        var observaciones    = ($("#observaciones").val()).trim();
        var contenido = ($("#contenido").val()).trim();  
        var folios = ($("#txtFolios").val()).trim();
        var fechaAtencion = ($("#NSUM-INI").val()).trim();


        if(asunto ==''  || contenido =='' || folios =='' || fechaAtencion ==''){
            (asunto == '') ? $('#txtAsunto').css('border-color','red') : $('#txtAsunto').css('border-color','') ;
            (folios == '') ? $('#txtFolios').css('border-color','red') : $('#txtFolios').css('border-color','') ;
            (fechaAtencion == '') ? $('#NSUM-INI').css('border-color','red') : $('#NSUM-INI').css('border-color','') ;
            
        }else{

            $('#txtAsunto').css('border-color','');
            $('#txtFolios').css('border-color','');
            $('#NSUM-INI').css('border-color','');
            var folioDoc = $("#txtFolios").val(),
            folioTot = $("#txtFolioDoc").val(),
            boolChkper = $("#chkPersonal").is(":checked");
            if(tipo_cargo == 1){
                if (oTable_Data.fnGetData().length == 0 ) {
                    Alerta("ADVERTENCIA", "Agregue al menos un destinatario", "4");
                    return false;
                }
            }
            //VALIDACION FOLIOS 0
            if (folioTot == 0) {
                Alerta("ADVERTENCIA", "Ingrese número folios Totales mayor a 0", "4");
                return false;
            }
            if (folioDoc == 0) {
                Alerta("ADVERTENCIA", "Ingrese número folios Documento mayor a 0", "4");
                return false;
            }

            var tam_archi = Dropzone.instances[0].files.length;
            if(obli_archivo==1){ // ES OBLIGATORIO ADJUNTAR ARCHIVO
                if(tam_archi<=0){
                    Alerta("ADVERTENCIA", "Es obligatorio que adjunte el archivo", "4");
                    return false;
                }
            }
            
            var destinatarios = [];
            destinatarios = Obtener_destinatarios();
            var datos = $('#frm1').serializeArray();

            var destinoCopias = Obtener_destinatarios_copias();
            var refs = Obtener_referencias();
            var tipo_doc_desc = $("#cbo_tipo_doc option:selected").text();
            var cod_tipo_doc = $("#cbo_tipo_doc").val();
            var boolExterno = $("#chkEntExt").is(":checked") ||  $("#radio16").is(":checked");
            var boolPersonal = $("#chkPersonal").is(":checked");
            var indPersonal = (boolPersonal ? 1 : 0);
            var indExterno = (boolExterno ? 1 : 0);
            if(indExterno == 1){
                if(cod_tipo_doc !=2 && cod_tipo_doc !=6 ){
                    Alerta("ADVERTENCIA", "A una entidad externa solo puede enviar CARTAS Y OFICIOS", "4");
                    return false;
                }
                if(refs.length>0){
                    Alerta("ADVERTENCIA", "No se puede ingresar referencias para documentos externos", "4");
                    return false;
                }
            }
            
            $("#btnGuardar").attr("disabled", true);
            datos.push({name: "txtAsunto", value: asunto});
            datos.push({name: "observaciones", value: observaciones});
            datos.push({name: "cbo_tipo_doc", value: $("#cbo_tipo_doc").val()});
            datos.push({name: "contenido", value: contenido});
            datos.push({name: "tipo_cargo", value: tipo_cargo});
            datos.push({name: "folioDoc", value: folioDoc});
            datos.push({name: "folios", value: folioTot});
            datos.push({name: "destinatarios", value: JSON.stringify(destinatarios)});
            datos.push({name: "copias", value: JSON.stringify(destinoCopias)});
            datos.push({name: "refes", value: JSON.stringify(refs)});
            datos.push({name: "tipo_doc_desc", value: tipo_doc_desc});
            datos.push({name: "indExterno", value: indExterno});
            datos.push({name: "indPersonal", value: indPersonal});
            datos.push({name: "fechaAtencion", value: fechaAtencion});
            datos.push({name: "ind_resolver", value: ($("#chkResolver").is(":checked") ? 1 : 0)});

             Cargando(1);
            $.ajax({
                url: "CrearInterno/crearDocInterno",
                datatype: "json",
                type: "post",
                data: datos,
                success: function (data) {

                    var len_files = Dropzone.instances[0].files.length;
                    if (!isEmpty(data)) {

                        if (len_files > 0) {
                            FormDropzone.setMovimientos(data.coddoc);
                            Dropzone.instances[0].processQueue();
                        }
                        $("#doc_generado").html(data.document_created);
                        $("#modal_resp").modal("show");

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

    };

    var Registra = function () {
        GuardarDocInt();
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



    var Listar_gerentes_y_subgerentes = function () {
        Cargando(1);
        $.ajax({
            url: "CrearInterno/Listar_gerentes_y_subgerentes",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {

                if (!isEmpty(data)) {
                    $("#hdValor").val(data.length); // almaceno total de subgerencias y gerencias para al grabar comparar con esta cantidad y proceder a guardar
                    for (var i = 0; i < data.length; i++) {
                        //valida funcionario uno por uno
                        getFuncionarioTotal(data[i].id, data[i].dependencia);
                    }
                }



            },

            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de dependencias!", "2");
                }, 900)
            }
        });
    };

    var Listar_personal_dependencia_actual = function (data) {
        Cargando(1);
        $.ajax({
            url: "CrearInterno/Listar_personal_dependencia_actual",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                Agregar_destinatario_tbl(data, true);
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de dependencias!", "2");
                }, 900)
            }
        });
    };

    var Agregar_destinatario_tbl = function (data) {
        if((data.nombre).trim() != ''){
            oTable_Data.fnAddData(data);
        }
    };


    var Agregar_destinatario_copia_tbl = function (data) {
        
        oTable_Copias.fnAddData(data);
        
    };

    var Obtener_destinatarios = function () {
        var destinatarios = [];
        var l = oTable_Data.fnGetData().length;
        if(tipo_cargo == 1){
            for (var i = 0; i < l; i++) {

                var e = {
                    "id": oTable_Data.fnGetData(i).dni,
                    "depen": oTable_Data.fnGetData(i).idDepend,
                    //"indGerente": (isEmpty(oTable_Data.fnGetData(i).indGerente) ? 0 : oTable_Data.fnGetData(i).indGerente),
                     "nombre": oTable_Data.fnGetData(i).nombre
                };
                destinatarios.push(e);
            }
        }else{
            var e = {
                "id": 1,
                "depen": 2,
                "nombre": 3
            };
            destinatarios.push(e);
        }
        
        return destinatarios;
    };

    var Obtener_destinatarios_copias = function () {
        var destinatarios = [];
        var l = oTable_Copias.fnGetData().length;
        for (var i = 0; i < l; i++) {

            var e = {
                "id": oTable_Copias.fnGetData(i).dni,
                "depen": oTable_Copias.fnGetData(i).idDepend,
                "folios": $(oTable_Copias.fnGetNodes(i)).find('input').val(),
                //"indGerente": (isEmpty(oTable_Copias.fnGetData(i).indGerente) ? 0 : oTable_Copias.fnGetData(i).indGerente)
            };
//            if (_input.attr("data-checked") == 1) {
//                e.copia = 1;
//            }
            destinatarios.push(e);
        }
        return destinatarios;
    };


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

    var CargaInicial = function () {

        $("#cbo_tipo_doc").change();
        $('[data-toggle="tooltip"]').tooltip();

    }


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
                oTable_SRefs.fnClearTable();
                if (data.length > 0) {
                    oTable_SRefs.fnAddData(data);
                }
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener referencias!", "2");
                }, 900)
            }
        });
    }

    var ListarDocsCreados = function () {
        console.log($("#MISDOC-INI").val());
        Cargando(1);
        $.ajax({
            url: "CrearInterno/getDocsCreadosUsuario",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "tip_doc"     : $("#selMisDoc").val(),
                "fecha_ini"   : $("#MISDOC-INI").val(),
                "fecha_fin"   : $("#MISDOC-FIN").val(),
                "esta_mis_doc": $("#selEstaMisDoc").val()
            },
            success: function (data) {
                Cargando(0);
                oTable_MyDocs.fnClearTable();
                if (data.length > 0) {
                    oTable_MyDocs.fnAddData(data);
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

    var ListarAreaRecepcionaron = function(cod_doc){
        Cargando(1);
        $.ajax({
            url: "CrearInterno/getAreasRecepcionaron",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddoc": cod_doc
            },
            success: function (data) {
                Cargando(0);
                console.log(data);
                
                oTable_ArchiCargo.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_ArchiCargo.fnAddData(data);
                    $("#modal_archi_cargo").modal("show");
                }else{
                    Alerta("ALERTA", "No se encontro ningun envio", "4");
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
    
    var ListarAdjuntosReferencia = function (cod_doc) {

        Cargando(1);
        $.ajax({
            url: "CrearInterno/getAdjuntos",
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


    var ListarAdjuntos = function (cod_doc) {
        Cargando(1);
        $.ajax({
            url: "CrearInterno/getAdjuntos",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddoc": cod_doc
            },
            success: function (data) {
                Cargando(0);
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

    var getTipoxTipoDoc = function () {
      var tipo_doc = $("#cbo_tipo_doc").val() *1;
        Cargando(1);
        
        $.ajax({
            url: "CrearInterno/getTipoxTipoDoc",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddoc": $("#cbo_tipo_doc").val()
            },
            success: function (data) {
                Cargando(0);
                console.log(data.length);
                if(data.length > 0){
                    Listar_dependencia2(3);
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
	

    var Listar_dependencia2 = function (tipo_doc) {
        Cargando(1);
        $.ajax({
            url: "CrearInterno/Listar_dependencias_internos",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {

                Cargando(0);
                
                var html = "<option value='N'>Selecciona un destinatario</option>";

                if (tipo_doc === '6' || tipo_doc === '3') {
                    html += "<option id='opTG' value='T'>AGREGAR TODOS LOS GERENTES Y SUBGERENTES</option>";
                }


                $.each(data, function (index, item) {

                    html += '<option value="' + item.IDORGANIGRAMA + '" >' + item.NOMBREAREA + '</option>';
                });


                $("#cmbNombre").html(html);
                $("#cmbNombre").select2();

                $("#cmbNombre2").html(html);
                $("#cmbNombre2").select2();

                if (tipo_doc === '6' || tipo_doc === '3') {
                    $("#cmbNombre2 option[value='T']").remove();
                }



            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la listar dependencias!", "2");
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
                    var len = oTable_Data.fnGetData().length,
                            row = oTable_Data.fnGetData(),
                            dni = data[0].c_traba_dni;


                    var dataCopias = oTable_Copias.fnGetData(),
                            lenCopias = oTable_Copias.fnGetData().length;
                    if (lenCopias > 0) {
                        for (var i = 0; i < lenCopias; i++) {
                            if (dataCopias[i].dni.trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                                return;
                            }
                        }
                    }


                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (row[i].dni.trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }

                    }

                    var data = {
                        "dni": data[0].c_traba_dni,
                        "idDepend": $("#cmbNombre").val(),
                        "nombre": $("#cmbNombre option:selected").text() + ' ____' + data[0].nombre,
                        "indGerente": 1
                    };
                    Agregar_destinatario_tbl(data);
                    $("#cmbNombre").val('N').trigger('change');
                } else {
                    Alerta("ATENCION", "No existe funcionario activo en la dependencia seleccionada", "4");
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
                    var len = oTable_Data.fnGetData().length;
                    var row = oTable_Data.fnGetData(),
                            dni = data[0].c_traba_dni,
                            lenCopias = oTable_Copias.fnGetData().length,
                            rowCopias = oTable_Copias.fnGetData();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (row[i].dni.trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "No se puede agregar una copia al mismo destinatario!", "4");
                                return;
                            }
                        }
                    }



                    if (lenCopias > 0) {
                        for (var i = 0; i < lenCopias; i++) {
                            if (rowCopias[i].dni.trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }

                    }

                    var data = {
                        "dni": data[0].c_traba_dni,
                        "idDepend": $("#cmbNombre2").val(),
                        "nombre": $("#cmbNombre2 option:selected").text(),
                        "indGerente": 1
                    };
                    Agregar_destinatario_copia_tbl(data);
                    $("#cmbNombre2").val('N').trigger('change');
                } else {
                    Alerta("ATENCION", "No existe funcionario activo en la dependencia seleccionada", "4");
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

    var getFuncionarioTotal = function (cod_depen, nombre_depen) {

        // Cargando(1);
        $.ajax({
            url: "CrearInterno/getFuncionario",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddepen": cod_depen
            },
            success: function (data) {
                //  Cargando(0);
                if (!isEmpty(data)) {
                    var len = oTable_Data.fnGetData().length,
                            row = oTable_Data.fnGetData(),
                            dni = data[0].c_traba_dni;


                    var dataCopias = oTable_Copias.fnGetData(),
                            lenCopias = oTable_Copias.fnGetData().length;
                    if (lenCopias > 0) {
                        for (var i = 0; i < lenCopias; i++) {
                            if (dataCopias[i].dni.trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "No se puede agregar un destinatario al mismo destinatario de la copia", "4");
                                return;
                            }
                        }
                    }


                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (row[i].dni.trim() === dni.trim()) {
                                Alerta("ADVERTENCIA", "El destinatario ya existe en la lista!", "4");
                                return;
                            }
                        }

                    }

                    var data = {
                        "dni": data[0].c_traba_dni,
                        "idDepend": cod_depen,
                        "nombre": nombre_depen,
                        "indGerente": 1
                    };
                    Agregar_destinatario_tbl(data);
                    $("#cmbNombre").val('N').trigger('change');
                } else {
                    //Alerta("ATENCION", "No existe funcionario activo en la dependencia seleccionada", "4");
                }

            },
            complete: function () {
                Cargando(0);

            },
            error: function (msg) {

                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error al obtener datos!", "2");
                }, 900)
            }
        });
    }

    var ListarDocsReferencias = function (idMovimiento) {

        Cargando(1);
        $.ajax({
            url: "Recibir/getReferenciasDocRecibir",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "cod_mov": idMovimiento,
                "cod_doc": 1
            },
            success: function (data) {
                Cargando(0);
                console.log(data);
                oTable_RefModal.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_RefModal.fnAddData(data);
                    $("#modal_refsInfo").modal("show");
                } else {
                    Alerta("ATENCION", "El documento no posee referencias", 4);
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

    


    var calcularSumaFolios = function () {

        var data = oTable_Refs.fnGetData(),
            suma = 0,
            folioDoc = $("#txtFolios").val();
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                suma = suma + parseInt(data[i].FOLIOS);
            }
        }
        folioDoc = parseInt(folioDoc); 
        if (Number.isInteger(folioDoc)) {
            folioDoc = folioDoc * 1;
            suma = suma + folioDoc;
        }
        $("#txtFolioDoc").val(suma);
    };


    var getFuncionarioCrear = function (iddepen) {

        Cargando(1);
        $.ajax({
            url: "CrearInterno/getFuncionario",
            datatype: "json",
            type: "post",
            async: false,
            data: {
                "iddepen": iddepen
            },
            success: function (data) {
                //  Cargando(0);
                if (!isEmpty(data)) {
                    //oTable_Data.fnGetData(0).dni = data[0].c_traba_dni;
                    $("#btnGuardar").attr("dniGerente", data[0].c_traba_dni);
                } else {
                    Cargando(0);
                    Alerta("ATENCION", "No existe funcionario activo en la dependencia seleccionada", "4");
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
        tipo_cargo =0;
        obli_archivo = 0;
    }

    var verifico_cargo= function(){
        $.ajax({
            url: "CrearInterno/verificar_cargo",
            datatype: "json",
            type: "post",
            async: false,
            success: function (data) {
                if(data){
                    tipo_cargo = 1;  // cuando el usuario esta encargado de una gerencia 
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

    var verifico_Subida_archivo = function(){
        $.ajax({
            url: "CrearInterno/verifico_Subida_archivo",
            datatype: "json",
            type: "post",
            async: false,
            success: function (data) {
                if(data){
                    obli_archivo = 1;  // cuando es obligatorio adjuntar el archivo
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

    return {
        init: function () {
            datos_globales();
            initDatables();
            initDatablesCopias();
            initDatablesRefs();
            initDatablesSearchRefs();
            initDatablesMisDocs();
            initDatablesAdjuntos();
            initDatablesAdjuntosRefe();
            initDatablesRefsModal();
            initDatablesArchiCargo();
            obtener_fecha_actual();
            verifico_cargo();
            verifico_Subida_archivo();
            eventos();
            Validate();
            CargaInicial();
        }
    };
}();







