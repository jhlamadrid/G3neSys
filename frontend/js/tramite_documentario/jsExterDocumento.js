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


var DocExterno = function () {

    var accion = '';

   

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
                        return '<button type="button" class="btnEliminar btn red " ><i class="fa fa-remove"></i></button>';
                    }
                }
            ]
        };
        oTable_Data = $("#tbl_sis_destinatarios").dataTable(parms);
    };

    var listaExterDatables = function () {
        var parms = {
            data: null,
            info: false,
            searching: true,
            paging: true,
            ordering: false,
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = data.NOMBREDOCUMENTO+' Nro. <span  style="color:#e41d20;">  '+data.NUMERODOCUMENTO+' - '+data.ANIO+' </span> ';
                        
                        return cadena;
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data, type, full, meta) {
                        return data.SUMINISTRO_EXTERNO;
                    }
                },
                {data: "ASUNTO"},
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data, type, full, meta) {
                        return data.FECHACREACION;
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('color', '#779ECB');
                        $(td).css('font-size', '20px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data, type, full, meta) {
                        return data.FOLIOSDOC;
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = '<button type="button" class="btnImpTick btn btn-success "  data-toggle="tooltip" data-placement="bottom" title="Imprimo Ticket"><i class="fa fa-file-pdf-o"></i></button>';
                        
                        return cadena;
                    }
                }
                
            ]
        };
        oTable_Data_Externo = $("#tbl_lista_reclamo").dataTable(parms);
    };

    var listar_documentos_externos = function(){

        var fecha_inicio = $("#NSUM-INI").val();
        var fecha_fin    = $("#NSUM-FIN").val();
        console.log(fecha_inicio);
        console.log(fecha_fin);
        $.ajax({
            url: "Listar_externo/Documentos",
            datatype: "json",
            type: "post",
            data:{
                'fecha_inicio' : fecha_inicio,
                'fecha_fin'    : fecha_fin
            },
            success: function (data) {
                oTable_Data_Externo.fnClearTable();
                if (!isEmpty(data)) {
                    oTable_Data_Externo.fnAddData(data);
                   
                }
                swal.close();


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


    var eventos = function () {
        $("#btnImprimir").attr("disabled", true);
        $("#txtFolioDoc").val(0);
        $("#txtFolios").numeric();
        $("#txtFolioDoc").numeric();
        $("#txtSuministro").numeric();
        $("#txtNumDoc").numeric();
        $("#txtTelefono").numeric();
        $("#txtFolios").on("keyup", function (e) {
            var valor = $(this).val(),
                    suma = 0,
                    //data = oTable_Refs.fnGetData(),
                    total = 0;
            if ($.isNumeric(valor)) {
                valor = valor * 1;
            } else {
                valor = 0;
            }

            total = suma + valor;
            $("#txtFolioDoc").val(total);

        });

        $("#NSUM-INI").change(function(){
            swal({
              title: "Buscando Externos...",
              text: "",
              showConfirmButton: false
            });
            listar_documentos_externos();
        });


        $("#NSUM-FIN").change(function(){
            swal({
              title: "Buscando Externos...",
              text: "",
              showConfirmButton: false
            });
            listar_documentos_externos();
        });

        /* para el tipo de documento  */
        $("#SelecTipDoc").change(function(){
            var dato = $("#SelecTipDoc").val();
            $("#txtNumDoc").val("");
            if(dato =='1'){
                $("#txtNumDoc").attr("maxlength", 8);
            }else{
                $("#txtNumDoc").attr("maxlength", 11);
            }
            
        });
        /* fin del tipo de documento  */

        $('#tbl_lista_reclamo tbody').on('click', '.btnImpTick', function () {

            var pos = oTable_Data_Externo.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_Data_Externo.fnGetData(pos);
            console.log(data);
            imprimir_cargo(data.IDDOCUMENTO);
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

        $("#ok").click(function () {
            //location.reload();
            $("#modal_resp").modal("hide");
            $("#btnImprimir").attr("disabled", false);
            listar_documentos_externos();
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

                if(len>0){
                    console.log("he entrado "+len);
                    Alerta("ADVERTENCIA", "Soló debe de seleccionar un destinatario", "4");
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

        $("#btnImprimir").click(function () {
            imprimir_cargo(documento);
        });
        
        $('#tbl_sis_destinatarios tbody').on('click', '.btnEliminar ', function () {

            var pos = oTable_Data.api(true).row($(this).parents("tr")[0]).index(),
                    len = 0;
            oTable_Data.fnDeleteRow(pos);
            len = oTable_Data.fnGetData().length;
            /*
            if (len === 0) {
                oTable_Copias.fnClearTable();
            }*/


        });

        $('#tbl_docint_creados tbody').on('click', '.btnAdjuntos', function () {
            var pos = oTable_MyDocs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_MyDocs.fnGetData(pos);
            console.log(data);
            ListarAdjuntos(data.IDDOCUMENTO);
        });

        // Para el boton de cargo 
        $('#tbl_archi_cargo tbody').on('click', '.btnCargArchi', function () {

            var pos = oTable_ArchiCargo.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_ArchiCargo.fnGetData(pos);
            console.log(data);
            imprimir_cargo(data.IDMOVIMIENTO);
        });

        $('#tbl_docint_creados tbody').on('click', '.btnDetalleDoc', function () {

            var pos = oTable_MyDocs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_MyDocs.fnGetData(pos);
            console.log(data);
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
                //$("#divCboPersonal").attr("style", "display:none;");
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
                    console.log(data);
                    fecha_actual= data.fecha;
                    fecha_poste = data.fecha_posterior;
                    $('#NSUM-FIN').daterangepicker({
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
                        //"minDate": convert_dmy(get_date(min)),
                        "maxDate" : fecha_actual,
                        "locale": {
                            "format": "DD-MM-YYYY HH:mm:ss",
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

                    

                    $("#NSUM-INI").val(fecha_actual);
                    $("#NSUM-INI-MAXI").val(fecha_poste);
                    $("#NSUM-FIN").val(fecha_actual);
            
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
                        "startDate": data.min_fecha,
                        "maxDate": fecha_actual,
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
                        }//,
                        //onSelect: function() {  alert("dd"); }
                    });

                    $('#NSUM-INI-MAXI').daterangepicker({
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
                        "startDate": fecha_poste,
                        "minDate": fecha_actual,
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
                        }//,
                        //onSelect: function() {  alert("dd"); }
                    });
                    listar_documentos_externos();
                }
            }
        });
    }

    var imprimir_cargo = function(id_documento){
        json = JSON.stringify(new Array(
            id_documento
        ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "imprimir_ticket/nuevo",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_ticket',
                'value': json,
                'type': 'hidden'
            }));
        $(document.body).append(form);
        form.submit();
    }

    var validarCorre = function(correo){
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if (regex.test(correo)) {
            return true;
        } else {
            return false;
        }
    }

    var GuardarDocInt = function () {
        
        var asunto  = ($("#txtAsunto").val()).trim();
        var observaciones    = ($("#observaciones").val()).trim();
        var contenido = ($("#contenido").val()).trim();  
        var folios = ($("#txtFolios").val()).trim();
        var suministro = ($("#txtSuministro").val()).trim();
        var Solicitante = ($("#Solicitante").val()).trim();
        var numDocumento = ($("#txtNumDoc").val()).trim();
        var correoEmisor = ($("#txtCorreo").val()).trim();
        var telefonoEmisor = ($("#txtTelefono").val()).trim();
        var fecha_maxima = $("#NSUM-INI-MAXI").val();
        if( asunto =='' || observaciones =='' ||  folios =='' || Solicitante =='' || numDocumento =='' || correoEmisor =='' || telefonoEmisor ==''){
            (asunto == '') ? $('#txtAsunto').css('border-color','red') : $('#txtAsunto').css('border-color','') ;
            (observaciones == '') ? $('#observaciones').css('border-color','red') : $('#observaciones').css('border-color','') ;
            (Solicitante == '') ? $('#Solicitante').css('border-color','red') : $('#Solicitante').css('border-color','') ;
            (folios == '') ? $('#txtFolios').css('border-color','red') : $('#txtFolios').css('border-color','') ;
            (numDocumento == '') ? $('#txtNumDoc').css('border-color','red') : $('#txtNumDoc').css('border-color','') ;
            (correoEmisor == '') ? $('#txtCorreo').css('border-color','red') : $('#txtCorreo').css('border-color','') ;
            (telefonoEmisor == '') ? $('#txtTelefono').css('border-color','red') : $('#txtTelefono').css('border-color','') ;
        }else{
            $('#observaciones').css('border-color','');
            $('#txtAsunto').css('border-color','');
            $('#txtFolios').css('border-color','');
            $('#Solicitante').css('border-color','');
            $('#txtNumDoc').css('border-color','');
            $('#txtCorreo').css('border-color','');
            $('#telefonoEmisor').css('border-color','');
            var bandera = 0;
            if(suministro.length > 0){
                if(suministro.length != 7 && suministro.length != 11 ){
                    Alerta("ADVERTENCIA", "Ingrese número de suministro correcto ", "4");
                    return false;
                }
                for(var i =0; i<suministro.length; i++ ){
                    if( suministro.charCodeAt(i) < 48 || suministro.charCodeAt(i) > 57 ){
                        bandera = 1;
                    }
                }
                if(bandera ==1){
                    Alerta("ADVERTENCIA", "Ingrese datos numericos en el suministro ", "4");
                    return false;
                }
            }
            bandera = 0;
            for(var i =0; i<numDocumento.length; i++ ){
                if( numDocumento.charCodeAt(i) < 48 || numDocumento.charCodeAt(i) > 57 ){
                    bandera = 1;
                }
            }
            if(bandera ==1){
                Alerta("ADVERTENCIA", "Ingrese datos numericos en el numero de documento ", "4");
                return false;
            }
            var Tipo_doc = $("#SelecTipDoc").val();
            if(Tipo_doc=='1'){
                if(numDocumento.length != 8){
                    Alerta("ADVERTENCIA", "Numero de DNI incorrecto ", "4");
                    return false;
                }
            }else{
                if(numDocumento.length != 11){
                    Alerta("ADVERTENCIA", "Numero de RUC incorrecto ", "4");
                    return false;
                }
            }
            /* VALIDAR EL CORREO */
            var respuestaCorreo = validarCorre(correoEmisor);
            if(!respuestaCorreo){
                Alerta("ADVERTENCIA", "Correo Incorrecto ", "4");
                return false;
            }
            /* PARA TELEFONO */
            bandera=0;
            for(var i =0; i<telefonoEmisor.length; i++ ){
                if( telefonoEmisor.charCodeAt(i) < 48 || telefonoEmisor.charCodeAt(i) > 57 ){
                    bandera = 1;
                }
            }
            if(bandera==1){
                Alerta("ADVERTENCIA", "Ingrese datos numericos en el telefono", "4");
                return false;
            }
            if(telefonoEmisor.length != 9){
                Alerta("ADVERTENCIA", "Numero de telefono incorrecto ", "4");
                return false;
            }
            var folioDoc = $("#txtFolios").val();
            if (oTable_Data.fnGetData().length == 0 ) {
                Alerta("ADVERTENCIA", "Agregue al menos un destinatario", "4");
                return false;
            }
            //VALIDACION FOLIOS 0

            if (folioDoc == 0) {
                Alerta("ADVERTENCIA", "Ingrese número folios Documento mayor a 0", "4");
                return false;
            }

            var destinatarios = [];
            destinatarios = Obtener_destinatarios();
            var datos = $('#frm1').serializeArray();
           
            $("#btnGuardar").attr("disabled", true);
            datos.push({name: "txtAsunto", value: asunto});
            datos.push({name: "observaciones", value: observaciones});
            datos.push({name: "suministro", value: suministro});
            datos.push({name: "numDocumento", value: numDocumento});
            datos.push({name: "correoEmisor", value: correoEmisor});
            datos.push({name: "telefonoEmisor", value: telefonoEmisor});
            datos.push({name: "Tipo_doc", value: Tipo_doc});
            datos.push({name: "cbo_tipo_doc", value: $("#cbo_tipo_doc").val()});
            datos.push({name: "contenido", value: contenido});
            datos.push({name: "folioDoc", value: folioDoc});
            datos.push({name: "fecha_maxima", value: fecha_maxima});
            datos.push({name: "Solicitante", value: Solicitante});
            datos.push({name: "destinatarios", value: JSON.stringify(destinatarios)});

            Cargando(1);
            $.ajax({
                url: "CrearExterno/IngresarExterno",
                datatype: "json",
                type: "post",
                data: datos,
                success: function (data) {

                    if (!isEmpty(data)) {
                        var len_files = Dropzone.instances[0].files.length;
                        if (len_files > 0) {
                            FormDropzone.setMovimientos(data.coddoc);
                            Dropzone.instances[0].processQueue();
                        }
                        $("#doc_generado").html(data.document_created);
                        $("#modal_resp").modal("show");
                        documento = data.coddoc;
                        $("#txtAsunto").val("");
                        $("#observaciones").val("");
                        $("#contenido").val("");
                        $("#txtFolios").val("");
                        $("#txtSuministro").val("");
                        $("#Solicitante").val("");
                        $("#txtNumDoc").val("");
                        $("#txtCorreo").val("");
                        $("#txtTelefono").val("");
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
        //console.log("entro a registrar");
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

    var Obtener_destinatarios = function () {
        var destinatarios = [];
        var l = oTable_Data.fnGetData().length;
        for (var i = 0; i < l; i++) {
                var e = {
                    "id": oTable_Data.fnGetData(i).dni,
                    "depen": oTable_Data.fnGetData(i).idDepend,
                    //"indGerente": (isEmpty(oTable_Data.fnGetData(i).indGerente) ? 0 : oTable_Data.fnGetData(i).indGerente),
                     "nombre": oTable_Data.fnGetData(i).nombre
                };
                destinatarios.push(e);
        }
        
        
        return destinatarios;
    };

    var CargaInicial = function () {
        getTipoxTipoDoc()
       // $("#cbo_tipo_doc").change();
        $('[data-toggle="tooltip"]').tooltip();

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



    var getTipoxTipoDoc = function () {
      var tipo_doc = $("#cbo_tipo_doc").val() *1;
        Cargando(1);
        
        $.ajax({
            url: "CrearInterno/getTipoxTipoDoc",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "iddoc": 1
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
    


    var datos_globales= function (){
        tipo_cargo =0;
        documento = "";
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

            initDatables();
            listaExterDatables();
            datos_globales();
            //verifico_cargo();
            obtener_fecha_actual();
            eventos();
            //Validate();
            CargaInicial();

        }
    };
}();







