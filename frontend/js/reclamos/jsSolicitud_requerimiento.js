function Cargando(estado) {

    if (estado == '0') {
        $.LoadingOverlay('hide');
    }
    else
    {
        $.LoadingOverlay('show');
    }

}

var Solicitud_requerimiento = function () {

    var carga_inicial = function(){
        
    }
    var plugins = function () {
        $(".select2").select2({
            placeholder: "Selecciona opción...",
            dropdownParent: $('#MODAL_DERIVACION')
        });
    }
    var carga_tablas = function(){
        var parametro = {
            data: null,
            info: false,
            bFilter: true,
            bSort:false,
            select: true,
            order: [[0, "asc"]],
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data) {
                        return data.EMPCOD+"-"+data.OFICOD+"-"+data.ARECOD+"-"+data.CTDCOD+"-"+data.DOCCOD+"-"+data.SERNRO+"-"+data.RECID ;
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data) {
                        return data.DOCIDENT_NRODOC ;
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                        $(td).css('font-weight', 'bold');
                    },
                    render: function (data) {
                        return data.RECFCH+" "+data.RECHRA ;
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data) {
                        return data.RECDESC ;
                    }
                },
                {data:  null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data) {
                        return  (data.TIPO_SOLICITUD == 'GENERAL' ? '<span class="badge bg-blue">General</span>' : '<span class="badge bg-green">Particular</span>') ;
                    }
                },
                {data:  null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data) {
                        return  (data.TIPO_PROBLEMA == 'OPERACIONAL' ? '<span class="badge bg-warning ">Operacional</span>' : '<span class="badge bg-blue">Comercial</span>') ;
                    }
                },
                {data:  null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data) {
                        return  (data.SRECCOD == 1 ? '<span class="badge label-danger">Pendiente</span>' : '<span class="badge label-primary">Atendido</span>') ;
                    }
                },
                {data:  null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data) {
                        var cade= '<button type="button" class="btnDerivar btn bg-blue "  data-toggle="tooltip" data-placement="bottom" title="DERIVAR"><i class="fa fa-check"></i></button> \n\ ';
                        if(data.PROBID == null){
                            cade = cade+'<a  class="btn bg-blue "  href="'+document.location.origin+'/GeneSys4/relativo_no_facturacion/solicitud_general/ver/'+data.EMPCOD+'/'+data.OFICOD+'/'+data.ARECOD+'/'+data.CTDCOD+'/'+data.DOCCOD+'/'+data.SERNRO+'/'+data.RECID +'" >  <i class="fa fa-print" aria-hidden="true"></i></a>';
                        }else{
                            cade = cade+'<a  class="btn bg-blue "  href="'+document.location.origin+'/GeneSys4/relativo_no_facturacion/solicitud_particular/ver/'+data.EMPCOD+'/'+data.OFICOD+'/'+data.ARECOD+'/'+data.CTDCOD+'/'+data.DOCCOD+'/'+data.SERNRO+'/'+data.RECID +'" >  <i class="fa fa-print" aria-hidden="true"></i></a>';
                        }
                        return  cade ;
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: [
                
                {
                    extend: 'excelHtml5',
                    text: '<i style="color:green" class="fa fa-file-excel-o"></i> Excel',
                    "className": 'btn  btn-primary',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                
                {
                    text: '<i style="color:red;" class="fa fa-file-pdf-o"></i> REPORTE DETALLADO', "className": 'btn  btn-success',
                    action: function ( e, dt, node, config ) {
                        ExportarPdf();
                    }
                },

                {
                    text: '<i style="color:red;" class="fa fa-file-pdf-o"></i> REPORTE GENERAL', "className": 'btn  btn-success',
                    action: function ( e, dt, node, config ) {
                        ExportarPdfGeneral();
                    }
                }
            ]
        }

        Tabla_solicitud_reclamo = $("#tbl_solicitud").dataTable(parametro);
        
    
    }

    var eventos = function(){
        obtener_fecha_actual();
        $("#sel_tipo_problema").change(function() {
            swal({
                title: "Buscando Solicitudes...",
                text: "",
                showConfirmButton: false
            });
            cargar_reclamo_intervalo();
        });
        
        $( "#sel_tipo_sol" ).change(function() {
            swal({
                title: "Buscando Solicitudes...",
                text: "",
                showConfirmButton: false
            });
            cargar_reclamo_intervalo();
        });

        $( "#sel_tipo_problema" ).change(function() {
            swal({
                title: "Buscando Solicitudes...",
                text: "",
                showConfirmButton: false
            });
            cargar_reclamo_intervalo();
        });

        $( "#sel_estado_sol" ).change(function() {
            swal({
                title: "Buscando Solicitudes...",
                text: "",
                showConfirmButton: false
            });
            cargar_reclamo_intervalo();
        });

        $("#NSUM-INI").change(function(){
            swal({
              title: "Buscando Solicitudes...",
              text: "",
              showConfirmButton: false
            });
            cargar_reclamo_intervalo();
        });

        $("#NSUM-FIN").change(function(){
            swal({
              title: "Buscando Solicitudes...",
              text: "",
              showConfirmButton: false
            });
            cargar_reclamo_intervalo();
        });

        $('#tbl_lista_reclamo tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                cambiar_estado_botones(1);
            }else{
                Tabla_lista_reclamos.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                cambiar_estado_botones(2);
            }
            
        });

        $('#selec_area_deriva').change(function(){
            var codigo = $(this).val().split('*');
            var texto  = $(this).find("option:selected").text().split('*');
            pintar_areas_derivacion(codigo, texto);
        });

        $('#tbl_reclamo_deriva tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                cambiar_estado_botones_derivacion(1);
            }else{
                Tabla_reclamos_deriva.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                cambiar_estado_botones_derivacion(2);
            }
            
        });

        $('#tbl_solicitud tbody').on('click', '.btnDerivar', function () {
            var pos = Tabla_solicitud_reclamo.api(true).row($(this).parents("tr")[0]).index(),
            data = Tabla_solicitud_reclamo.fnGetData(pos);
            
            if(data.PROBID == null) {
                var tipo = 0; // general 
            }else{
                var tipo = 1; // particular
            } 
            Verifico_orden_servicio();
            
        });

        $('#tbl_busqueda_grupo tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }else{
                Tabla_busqueda_grupo.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
            
        });

        $('#tbl_busqueda_solicitud tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }else{
                Tabla_solicitud.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
            
        });

        $( "#tipo_doc_reclamante" ).change(function() {
            var texto = $("#tipo_doc_reclamante option:selected").text();
            $("#texto_documento_reclamante").text("DOCUMENTO( "+texto+" ):");
        });

        
        
        
        $("#MODREGPER-CELULAR").numeric();
        $("#doc_representacion").numeric();
        $( "#Form-Id" ).keypress(function(e) {
            if (!e) e = window.event;
                var keyCode = e.keyCode || e.which;
                if (keyCode == '13'){
                    var tipo_documento = $("#tipo_doc_reclamante").val();
                    var texto = $("#tipo_doc_reclamante option:selected").text();
                    if(tipo_documento =='1'){
                        validar_dni(8,texto );
                    }else{
                        if(tipo_documento =='3'){
                            validar_dni(11,texto);
                        }else{
                            if(tipo_documento =='2'){
                                validar_otro(12,texto);
                            }else{
                                validar_otro(12,texto);
                            }
                        }
                    } 
                }
          });
    }


    var Verifico_orden_servicio = function(){
        $(location).attr('href','Generar_solicitud/'+data.EMPCOD+'/'+data.OFICOD+'/'+data.ARECOD+'/'+data.CTDCOD+'/'+data.DOCCOD+'/'+data.SERNRO+'/'+data.RECID+'/'+tipo );
    }

    var cargar_reclamo_intervalo = function(){
        $.ajax({
            type: "POST",
            url: "intevalo_reclamos?ajax=true",
            data: {
                inicio: $("#NSUM-INI").val(), 
                fin: $("#NSUM-FIN").val(),
                tipo: $("#sel_tipo_sol").val(),
                tipo_problema: $("#sel_tipo_problema").val(),
                estado: $("#sel_estado_sol").val()
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    console.log(data.lista_reclamos);
                    swal.close();
                    Tabla_solicitud_reclamo.fnClearTable();
                    if((data.lista_reclamos).length > 0){
                        Tabla_solicitud_reclamo.fnAddData(data.lista_reclamos);
                    }
                    
                    return true;
                }
            }
        });
    }



    var ExportarPdfGeneral = function(){
        Cargando(1);
        json = JSON.stringify(new Array(
            $("#NSUM-INI").val(), 
            $("#NSUM-FIN").val(),
            $("#sel_tipo_sol").val(),
            $("#sel_estado_sol").val(),
            $("#sel_tipo_problema").val()
        ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "Reportes/imprimir_pdf_general",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_reporte_general',
                'value': json,
                'type': 'hidden'
            }));
        $(document.body).append(form);
        form.submit();
        Cargando(0);
    }
   

    var ExportarPdf = function(){
        Cargando(1);
        json = JSON.stringify(new Array(
            $("#NSUM-INI").val(), 
            $("#NSUM-FIN").val(),
            $("#sel_tipo_sol").val(),
            $("#sel_estado_sol").val(),
            $("#sel_tipo_problema").val()
        ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "Reportes/imprimir_pdf",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_reporte',
                'value': json,
                'type': 'hidden'
            }));
        $(document.body).append(form);
        form.submit();
        Cargando(0);
    }

    var obtener_fecha_actual = function(){
        $.ajax({
            type: "POST",
            url: "fecha_actual?ajax=true",
            data: {
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    Tabla_solicitud_reclamo.fnClearTable();
                    console.log(data.lista_reclamos);
                    if((data.lista_reclamos).length > 0){
                        Tabla_solicitud_reclamo.fnAddData(data.lista_reclamos);
                    }
                    fecha_actual = data.fecha;
                   
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

                    $("#NSUM-INI").val(data.min_fecha);
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
                }
            }
        });
    }
 
   
    
    
   

    var show_swal = function  (tipo, titulo, mensaje, cancelbtn, clsconfirm, shconfirmbtn){
        swal({
            title: titulo,
            text: mensaje,
            type: tipo,
            showCancelButton: cancelbtn,
            closeOnConfirm: clsconfirm,
            confirmButtonColor: "#296fb7",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showConfirmButton : shconfirmbtn
        }, function(valor){
            return valor;
        });
    }


    var datos_globales= function (){
        fecha_actual ='';
    }

    return {

        init: function (){
            datos_globales();
            carga_tablas();
            plugins();
            carga_inicial();
            eventos();
        }
    };
}();
