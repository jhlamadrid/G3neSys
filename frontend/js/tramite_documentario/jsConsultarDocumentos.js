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

var CONSULTARDOCUMENTOS = function () {
    
    var initDatables_obtener_expedientes = function () {

        var parms = {
            columns: [
                {data: "Parte"},
                {data: null, render: function (data, type, full, meta) {
                        return '<span class="bold">' + data.Documento.trim() + " "
                        + (data.indCopia == 1 ? "(COPIA)" : "") + '</span>';
                    }
                
                },
                {data: null, render: function (data, type, full, meta) {
                       var interesado =  data.nom_int == null ? ""  : data.nom_int.trim() + " " + data.ape_int.trim() ;
                         return "Nombre: " + interesado +  "<br>Dir: " + data.dir_int;
//                        return data.tipoDoc.trim() + ": " + data.numDoc.trim() + prueba ahi xd xdxd
//                        "<br>Nombre: " + data.nom_int.trim() + " " + data.ape_int.trim() + "<br>Dir: " + data.dir_int;
                    }
                },
                {data: null, render: function (data, type, full, meta) {
                        return data.NOM_PRO;
                    }
                },
                {data: "Asunto"},
                {data: "obsTerminado"},
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var icon = data.indTerminado == 0 ? 'green-haze' : (data.indTerminado == 1 ? 'red-haze' : 'red-haze');
                        return '<button type="button" class="btn ' + icon + ' btn-circle btn-xl">';
                }},
                {data: "observaciones"},
                {data: "Fecha"},
                {data: "folios"},
                {data: "idMovimiento"},
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnVerMovimientosTotales btn blue btn-outline tooltips" data-container="body" data-placement="top" title="Seguimiento"><i class="fa fa-file"></i></button>';
                    }
                }
            ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "aoColumnDefs": [
                        { 'sWidth': "100%", 'aTargets': [ 0 ] }
                       ]
        }
        oTable_obtener_expedientes = $("#tbl_listar_expedientes").dataTable(parms);
        
         
    }

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
     
    
    var initDatables_obtener_documentos = function () {

        var parms = {
            columns: [
                {data: null, className: 'dt-body-left',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '18px');
                    },
                   render: function (data, type, full, meta) {
                        var autor = '';
                        if(data.SIGLAPERSONAGEN !=null){
                            autor = autor + '/' +data.SIGLAPERSONAGEN ;
                        }
                        return '<span class="bold">' + data.NOMBREDOCUMENTO + " Nro. <span style='color:#ed5565'> " + data.NUMERODOCUMENTO + ' - '+ data.ANIO+ '</span> SEDALIB S.A. - '+ data.SIGLAAREAGEN+ '</span>' +autor }
                },
                {data: "ASUNTO"},
                {data: "OBSERVACIONES"},
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-weight', 'bold');
                        $(td).css('color', '#000');
                        $(td).css('font-size', '14px');
                    },
                    render: function (data, type, full, meta) {
                        return '<span > ' + data.FECHACREACION + '</span>' }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-weight', 'bold');
                        $(td).css('color', '#ed5565');
                        $(td).css('font-size', '23px');
                    },
                    render: function (data, type, full, meta) {
                        return '<span >' + data.FOLIOSTOTALES + '</span>' }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnVerMovimientosDocumentos btn btn-primary  btn-circle btn-lg tooltips" data-container="body" data-placement="top" title="Seguimiento"><i class="fa fa-file"></i></button>';
                    }
                }
            ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "aoColumnDefs": [
                        { 'sWidth': "100%", 'aTargets': [  ] }
                       ]
        }
        oTable_obtener_documentos = $("#tbl_listar_documentos").dataTable(parms);
        
         
    }
 
    var initDatables_Ver_Movimientos_por_documento = function () {
        var parms = {
            
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '15px');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = '';
                        if(data.INDCOPIA ==1){
                            cadena= cadena +'<span  style="font-size: 20px;" ><i style="color: #4caf50;" class="fa fa-file"></i>&nbsp;COPIA</span>';
                        }

                        return cadena ;

                    }

                },
                {data: null, className: 'dt-body-left',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '15px');
                    },
                   render: function (data, type, full, meta) {
                        var autor = '';
                        if(data.SIGLAS_PERSONAL != null){
                            autor = autor + '/' +data.SIGLAS_PERSONAL ;
                        }
                        return '<span class="bold">' + data.NOMBREDOCUMENTO + " Nro. <span style='color:#ed5565'> " + data.NUMERODOCUMENTO + ' - '+ data.ANIO+ '</span> SEDALIB S.A. - '+ data.AREA_GENERA+ '</span>'+autor }
                },
                {data: null, className: 'dt-body-center',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-weight', 'bold');
                        $(td).css('color', '#ed5565');
                        $(td).css('font-size', '23px');
                    },
                   render: function (data, type, full, meta) {
                        return '<span >' + data.FOLIOS + '</span>' }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                    },
                     render: function (data, type, full, meta) {
                        return '<span>' +  ((data.INDEXTER == '1') ? 'EXTERNO': ((data.PERSONA_ENVIA == 'vacio') ? '': (data.PERSONA_ENVIA+"<br>") ))  + '</span>' + "<span style='font-weight:bold;'> " + ((data.AREA_CREA == null) ? '' : data.AREA_CREA) + '</span>' +
                        "<br> <span style='font-weight:bold; color:#3c8dbc'> Enviado: </span> " + data.FECHACREACION + ' ' +data.HORA_CREO; //moment(data.FECHACREACION).format("DD/MM/YYYY hh:mm a"); 
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                    },
                    render: function (data, type, full, meta) {
                        
                        return '<span class="bold">' + ((data.INDEXTER == '1') ? 'EXTERNO' : ((data.PERSONA_RECIBE == 'vacio')? '': data.PERSONA_RECIBE+ "<br>" ))  + '</span>' + " <span style='font-weight:bold;'>  " + ((data.AREA_ENVIA == null) ? '' : data.AREA_ENVIA) + '</span>'+
                        "<br> <span style='font-weight:bold; color:#3c8dbc'> Recibido: </span> " + (data.FECHARECEPCION == null ? "Aún no lo recibe" : data.FECHARECEPCION + ' ' + data.HORA_RECEPCIONA );
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var icon = data.ESTADOENVIO == 2 ? '1c84c6' : 'ed5565';
                        return '<button type="button"style="background-color:#'+ icon+'"  class="btn btn-circle btn-lg"><i class="fa fa-file-text-o"></i>';
                }},
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return ' <button type="button" class="btnVerRef btn btn-warning " data-toggle="tooltip" data-placement="bottom" title="Referencias"><i class="fa fa-sitemap"></i></button>\n\
                        <button type="button" class="btnDetalleDoc btn btn-primary" title="Archivos Anexados"><i class="fa fa-paperclip"></i></button>';  
                    }
                }
                
            ],
            
            "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "dom": 'Bfrtip',
                    "buttons": [
                                {
                                    text: '<i style="color:red;" class="fa fa-file-pdf-o"></i> PDF', 
                                    "className": 'btn btn-primary',
                                    action: function ( e, dt, node, config ) {
                                        ExportarDocumentoPdf();
                                    }
                                   
                                },
                                { 
                                    extend: 'excel', 
                                    "className": 'btn  btn-primary',
                                    text: '<i style="color:green" class="fa fa-file-excel-o"></i> Excel'
                                    
                                }

                               ]
                    
        };
        
 
        oTable_Ver_Movimientos_por_documento = $("#tbl_ver_movimientos_por_documento").dataTable(parms);
    };
    var initDatables_Ver_Movimientos_por_documento_persona = function () {
        var parms = {
            
            columns: [
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '15px');
                    },
                    render: function (data, type, full, meta) {
                        var cadena = '';
                        if(data.INDCOPIA ==1){
                            cadena= cadena +'<span  style="font-size: 20px;" ><i style="color: #4caf50;" class="fa fa-file"></i>&nbsp;COPIA</span>';
                        }

                        return cadena ;

                    }
                },
                {data: null, className: 'dt-body-left',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '15px');
                    },
                   render: function (data, type, full, meta) {
                        var autor = '';
                        if(data.SIGLAS_PERSONAL != null ){
                            autor = autor + '/' +data.SIGLAS_PERSONAL ;
                        }
                        return '<span class="bold">' + data.NOMBREDOCUMENTO + " Nro. <span style='color:#ed5565'> " + data.NUMERODOCUMENTO + ' - '+ data.ANIO+ '</span> SEDALIB S.A. - '+ data.AREA_GENERA+ '</span>'+autor }
                },
                {data: null, className: 'dt-body-center',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-weight', 'bold');
                        $(td).css('color', '#ed5565');
                        $(td).css('font-size', '23px');
                    },
                   render: function (data, type, full, meta) {
                        return '<span >' + data.FOLIOS + '</span>' }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                    },
                     render: function (data, type, full, meta) {
                        return '<span>' +  ((data.INDEXTER == '1') ? 'EXTERNO': ((data.SIGLAS_PERSONAL == null) ? '': (data.PERSONA_ENVIA+"<br>") ))  + '</span>' + "<span style='font-weight:bold;'> " + ((data.AREA_CREA == null) ? '' : data.AREA_CREA) + '</span>' +
                        "<br> <span style='font-weight:bold; color:#3c8dbc'> Enviado: </span> " + data.FECHACREACION + ' ' +data.HORA_CREO; //moment(data.FECHACREACION).format("DD/MM/YYYY hh:mm a"); 
                    }
                },
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-size', '16px');
                    },
                    render: function (data, type, full, meta) {
                        
                        return '<span class="bold">' + ((data.INDEXTER == '1') ? 'EXTERNO' : ((data.PERSONA_RECIBE ==null)? '': data.PERSONA_RECIBE+ "<br>" ))  + '</span>' + " <span style='font-weight:bold;'>  " + ((data.AREA_ENVIA == null) ? '' : data.AREA_ENVIA) + '</span>'+
                        "<br> <span style='font-weight:bold; color:#3c8dbc'> Recibido: </span> " + (data.FECHARECEPCION == null ? "Aún no lo recibe" : data.FECHARECEPCION + ' ' + data.HORA_RECEPCIONA );
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        var icon = data.ESTADOENVIO == 2 ? '1c84c6' : 'ed5565';
                        return '<button type="button"style="background-color:#'+ icon+'"  class="btn btn-circle btn-lg"><i class="fa fa-file-text-o"></i>';
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return ' <button type="button" class="btnVerRef btn btn-warning " data-toggle="tooltip" data-placement="bottom" title="Referencias"><i class="fa fa-sitemap"></i></button>\n\
                        <button type="button" class="btnDetalleDocPersona btn btn-primary" title="Archivos Anexados"><i class="fa fa-paperclip"></i></button>';  
                    }
                }
                
            ],
            
            "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "dom": 'Bfrtip',
                    "buttons": [
                                {
                                    text: '<i style="color:red;" class="fa fa-file-pdf-o"></i> PDF', 
                                    "className": 'btn btn-primary',
                                    action: function ( e, dt, node, config ) {
                                        ExportarDocumentoPersonaPdf();
                                    }
                                
                                },
                                { 
                                    extend: 'excel', 
                                    "className": 'btn  btn-primary',
                                    text: '<i style="color:green" class="fa fa-file-excel-o"></i> Excel'
                                    
                                }

                               ]
                    
        };
        
 
        oTable_Ver_Movimientos_por_documento_persona = $("#tbl_ver_movimientos_por_documento_persona").dataTable(parms);
    };

    var ExportarDocumentoPdf = function(){
        
        if (oTable_Ver_Movimientos_por_documento.fnGetData().length == 0 ) {
            Alerta("ADVERTENCIA", "No existen datos en la tabla", "4");
            return false;
        }else{
            Cargando(1);
            json = JSON.stringify(new Array(
                idDocumento,
                datosDocumento
            ));
            event.preventDefault();
            var form = jQuery('<form>', {
                    'action': "Consulta/imprimir_persona_pdf",
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
        console.log("exporto documento 1");
    }

    var ExportarDocumentoPersonaPdf = function (){
        if (oTable_Ver_Movimientos_por_documento_persona.fnGetData().length == 0 ) {
            Alerta("ADVERTENCIA", "No existen datos en la tabla", "4");
            return false;
        }else{
            Cargando(1);
            json = JSON.stringify(new Array(
                idDocumentoPersona,
                datosDocumento_persona
            ));
            event.preventDefault();
            var form = jQuery('<form>', {
                    'action': "Consulta/imprimir_persona_pdf",
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
        console.log("exporto documento 2");
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

    var initDatables_Documentos_Persona = function () {
        var parms = {
            columns: [
                {data: null, className: 'dt-body-left',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'left');
                        $(td).css('font-weight', 'bold');
                        $(td).css('font-size', '18px');
                    },
                   render: function (data, type, full, meta) {
                        var autor = '';
                        if(data.SIGLAPERSONAGEN !=null){
                            autor = autor + '/' +data.SIGLAPERSONAGEN ;
                        }
                        return '<span class="bold">' + data.NOMBREDOCUMENTO + " Nro. <span style='color:#ed5565'> " + data.NUMERODOCUMENTO + ' - '+ data.ANIO+ '</span> SEDALIB S.A. - '+ data.SIGLAAREAGEN+ '</span>'+ autor }
                },
                {data: "ASUNTO"},
                {data: null,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                        $(td).css('font-weight', 'bold');
                        $(td).css('color', '#ed5565' );
                        $(td).css('font-size', '23px');
                    },
                    render: function (data, type, full, meta) {
                        return '<span >' + data.FOLIOSTOTALES + '</span>' 
                    }
                },
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnSeguimientoPersona btn btn-primary  btn-circle btn-lg" data-container="body" data-placement="top" title="Seguimiento"><i class="fa fa-file-text"></i></button>';
                    }
                }
            ],
            
            "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "aoColumnDefs": [
                        { 'sWidth': "100%", 'aTargets': [  ] }
                       ]
            
        };
        oTable_Documentos = $("#table_documentos").dataTable(parms);
    };
    
    
    var initDatables_Documentos_Asunto = function () {
        var parms = {
            columns: [
                {data: null, targets: 'no-sort', orderable: false,
                    render: function (data, type, full, meta) {
                        return  data.Documento + (data.idTipoDoc == 1 ? "-" + data.Parte : "");
                    }
                },
                {data: "Asunto"},
                {data: "Folios"},
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnSeguimientoAsunto btn blue btn-outline tooltips" data-container="body" data-placement="top" title="Seguimiento"><i class="fa fa-file-text"></i></button>';
                    }
                }
            ],
            
            "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "aoColumnDefs": [
                        { 'sWidth': "100%", 'aTargets': [  ] }
                       ]
            
        };
        oTable_Documentos_Asunto = $("#table_consultar_asunto").dataTable(parms);
    };
    
    
    
    var initDatables_Documentos_Interesado = function () {
        var parms = {
            columns: [
                {data: null, targets: 'no-sort', orderable: false,
                    render: function (data, type, full, meta) {
                        return  data.Documento + (data.idTipoDoc == 1 ? "-" + data.Parte : "");
                    }
                },
                {data: "Asunto"},
                {data: "Folios"},
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnSeguimientoInteresado btn blue btn-outline tooltips" data-container="body" data-placement="top" title="Seguimiento"><i class="fa fa-file-text"></i></button>';
                    }
                }
            ],
            
            "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "aoColumnDefs": [
                        { 'sWidth': "100%", 'aTargets': [  ] }
                       ]
            
        };
        oTable_Documentos_Interesado = $("#table_consultar_Interesado").dataTable(parms);
    };
    
    
    
    var initDatables_Expedientes_partes = function () {
        var parms = {
            columns: [
                {data: null, targets: 'no-sort', orderable: false,
                    render: function (data, type, full, meta) {
                        return  data.Documento + (data.idTipoDoc == 1 ? "-" + data.Parte : "");
                    }
                },
                {data: "Asunto"},
                {data: "Folios"},
                {data: null, targets: 'no-sort', orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center');
                    },
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btnSeguimientoInteresado btn blue btn-outline tooltips" data-container="body" data-placement="top" title="Seguimiento"><i class="fa fa-file-text"></i></button>';
                    }
                }
            ],
            "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    "language": {
                        search: "Buscar: ",
                        info: "Total registrados: _MAX_",
                        zeroRecords: "No se encontraron coincidencias para su busqueda",
                        infoEmpty: "",
                        infoFiltered: "",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente",
                            first: "Inicio",
                            last: "Fin"
                        }
                    },
                    "aoColumnDefs": [
                        { 'sWidth': "100%", 'aTargets': [  ] }
                       ]
            
        };
        oTable_Expedientes_partes = $("#table_consultar_partes").dataTable(parms);
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
    
    
    
    var plugins = function () {
        
        $(".select2").select2({placeholder: "Selecciona opción..."});
        
    };

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
        
        $("#cbo_tipo_concepto").on("change", function (e) {
            var valor = $(this).val();
            $(".clear_interesado").val('');
            if (valor === 'dni') {
                $("input[name='txt_descripcion']").inputmask("9{1,8}");
            } else if (valor === 'ruc') {
                $("input[name='txt_descripcion']").inputmask("9{1,11}");
            } else if (valor === 'carne' || valor === 'pasaporte') {
                $("input[name='txt_descripcion']").inputmask("9{1,12}");
            } else if (valor === 'oficio' || valor === 'carta') {
                $("input[name='txt_descripcion']").inputmask("remove");
            }
        }
        );
        
        $('#tbl_referencias tbody').on('click', '.btnAdjuntos_red', function () {
            var pos = oTable_Refs.api(true).row($(this).parents("tr")[0]).index();
            var data = oTable_Refs.fnGetData(pos);
            $('#modal_refs').modal('hide');
            ListarAdjuntosReferencia(data.IDDOCUMENTO);
        });
        $("#cerrarArchiDocRef").click(function () {
            $('#modal_refs').modal('show');
            $('#modalArchivosRefe').modal('hide');
        });
        
        
        $('#tbl_listar_expedientes tbody').on('click', '.btnVerMovimientosTotales', function () {
            var pos = oTable_obtener_expedientes.api(true).row($(this).parents("tr")[0]).index();
            var row = oTable_obtener_expedientes.fnGetData(pos);
            datosDocumento = row;
            Ver_movimientos_por_documento(row.idMovimiento, row.idDocumento);
        });
        
        
        $('#tbl_listar_documentos tbody').on('click', '.btnVerMovimientosDocumentos', function () {
            var pos = oTable_obtener_documentos.api(true).row($(this).parents("tr")[0]).index();
            var row = oTable_obtener_documentos.fnGetData(pos);
            idDocumento = row.IDDOCUMENTO;
            datosDocumento = row;
            Ver_movimientos_por_documento(row.IDDOCUMENTO,1);

        });
        
        $('#table_documentos tbody').on('click', '.btnSeguimientoPersona', function () {

            var pos = oTable_Documentos.api(true).row($(this).parents("tr")[0]).index();
            var row = oTable_Documentos.fnGetData(pos);
            datosDocumento_persona = row;
            idDocumentoPersona = row.IDDOCUMENTO;
            Ver_movimientos_por_documento(row.IDDOCUMENTO,2);
        });
        
        
        $('#table_consultar_asunto tbody').on('click', '.btnSeguimientoAsunto', function () {

            var pos = oTable_Documentos_Asunto.api(true).row($(this).parents("tr")[0]).index();
            var row = oTable_Documentos_Asunto.fnGetData(pos);
            var cbo_tipos_documentos_asunto = $('#cbo_tipos_documentos_asunto').val();
            
            switch (cbo_tipos_documentos_asunto) {
                    case "1":
                            $("#lista_expedientes").show();
                            $("#lista_documentos").hide();
                            Obtener_expediente_persona(row.idTipoDoc, row.Numero, row.Parte, row.Anio, row.Siglas);
                        break;
                     default:
                            
                            $("#lista_documentos").show();
                            $("#lista_expedientes").hide();
                            Obtener_documentos_persona(row.idTipoDoc, row.Numero, row.Anio, row.Siglas);
                        break;
                }

        });

        $('#tbl_ver_movimientos_por_documento tbody').on('click', '.btnVerRef', function () {
            var pos = oTable_Ver_Movimientos_por_documento.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_Ver_Movimientos_por_documento.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc_ref").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.AREA_GENERA+ autor);
            ListarDocsReferencias(data.IDMOVIMIENTO, data.IDDOCUMENTO);
        });
        
        $('#tbl_ver_movimientos_por_documento_persona tbody').on('click', '.btnDetalleDocPersona', function () {
            var pos = oTable_Ver_Movimientos_por_documento_persona.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_Ver_Movimientos_por_documento_persona.fnGetData(pos);
            console.log(data);
            ListarAdjuntos(data.IDDOCUMENTO);
        });
        $('#tbl_ver_movimientos_por_documento tbody').on('click', '.btnDetalleDoc', function () {
            
            var pos = oTable_Ver_Movimientos_por_documento.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_Ver_Movimientos_por_documento.fnGetData(pos);
            console.log(data);
            ListarAdjuntos(data.IDDOCUMENTO);
        });


        $('#tbl_ver_movimientos_por_documento_persona tbody').on('click', '.btnVerRef', function () {
            var pos = oTable_Ver_Movimientos_por_documento_persona.api(true).row($(this).parents("tr")[0]).index(),
            data = oTable_Ver_Movimientos_por_documento_persona.fnGetData(pos);
            var autor = '';
            if(data.SIGLAS_PERSONAL !=null){
                autor = autor + '/' +data.SIGLAS_PERSONAL ;
            }
            $("#sp_doc_ref").html(data.NOMBREDOCUMENTO + ' Nro. ' + data.NUMERODOCUMENTO + ' - ' + data.ANIO+' - SEDALIB S.A. - '+ data.AREA_GENERA+ autor);
            ListarDocsReferencias(data.IDMOVIMIENTO, data.IDDOCUMENTO);
        });
        
        
        
        $('#table_consultar_Interesado tbody').on('click', '.btnSeguimientoInteresado', function () {

            var pos = oTable_Documentos_Interesado.api(true).row($(this).parents("tr")[0]).index();
            var row = oTable_Documentos_Interesado.fnGetData(pos);
            var cbo_tipos_conceptos = $('#cbo_tipo_concepto').val();
            $("#lista_expedientes").show();
            $("#lista_documentos").hide();
            Obtener_expediente_persona(row.idTipoDoc, row.Numero, row.Parte, row.Anio, row.Siglas);
            

        });
        
        $("#btns-radio label").click(function () {
            var tipo = $(this).find("input").val();
            $("section").addClass("hide");
            $("#section_" + tipo).removeClass("hide");
        });
        
        $('#cbo_tipos_documentos').change(function(){
//            listar_anios_documentos();
            var idTipoDoc = $("#cbo_tipos_documentos").val();
            //Listar_siglas_documento(idTipoDoc);
            fillAnios();
    })
    
        $('#cbo_tipoDocumento_persona').change(function(){
//            listar_anios_documentos();
            //var idTipoDoc = $("#cbo_tipoDocumento_persona").val();
            ListarDependencias();
    })
    
        $('#cbo_dependencia_persona').change(function(){
//            listar_anios_documentos();
            var id = $("#cbo_dependencia_persona").val();
            Listar_personal_x_dependencia(id);
            
            fillAnios();
    })
    
        
        $('#cbo_tipos_documentos_asunto').change(function(){
//            listar_anios_documentos();
            //var idTipoDoc = $("#cbo_tipoDocumento_persona").val();
            fillAnios();
    })
    
    
        $('#cbo_tipo_concepto').change(function(){
            fillAnios();
    })
    
    
    
    $( "#btnBuscarTipoDocumento" ).click(function() {
        
        //var cbo_tipos_documentos = $('#cbo_tipos_documentos').val();
        $("#lista_documentos").show();
        //$("#lista_expedientes").hide();
        Obtener_documentos();    
                  
    });

    $( "#btnBuscar_persona" ).click(function() {
        console.log("he dado click");
        $("#table_container").show();
        //$("#table_documentos").show();
        Consultar_Persona(); 
     
    });
        
/*    
    $('#tab_consultar').on("click", "li", function (event) {         
    var activeTab = $(this).find('a').attr('href');
    switch (activeTab) {
                    case "#tab_15_3_1":
                            $("#lista_documentos").hide();
                            $("#table_container").hide();
                            $("#lista_movimientos").hide();
                        break;
                    case "#tab_15_4_1":
                            $("#lista_documentos").hide();
                            $("#table_container").hide();
                            $("#lista_movimientos").hide();
                        break;    
                    case "#tab_15_5_1":
                            $("#lista_documentos").hide();
                            $("#lista_movimientos").hide();
                        break;
                    case "#tab_15_6_1":
                            $("#lista_documentos").hide();
                            $("#lista_movimientos").hide();
                        break;
                }
});*/
        
        
    
    $( "#btnBuscar_asunto" ).click(function() {
        
        var cbo_tipos_documentos_asunto = $('#cbo_tipos_documentos_asunto').val();
            
            
            switch (cbo_tipos_documentos_asunto) {
                    case "1":
                            $("#table_consultar_asunto").show();
                            Obtener_expedientes_asunto();
                        break;
                     default:
                            $("#table_consultar_asunto").show();
                            Obtener_documentos_asunto();
                        break;
                }
        
                
        });
        
    
    $( "#btnBuscar_interesado" ).click(function() {
       
           $("#table_consultar_Interesado").show();
           Obtener_expedientes_interesado(); 
        
        });

        
    }
    
    var ListarDocsReferencias = function (idMovimiento, cod_doc) {

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
    
    
    
    var Obtener_documentos = function () {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Obtener_documentos",
            datatype: "json",
            type: "post",
            data:{
               idTipoDoc :  $("#cbo_tipos_documentos").val(),
               numero : $("#txt_numero").val(),
               anio : $("#cbo_anio").val(),
               siglas : $("#txt_siglas").val()
            },
            success: function (datos) {
                Cargando(0);
                oTable_obtener_documentos.fnClearTable();
                if(datos.length > 0){
                    oTable_obtener_documentos.fnAddData(datos);
                }else{
                    Alerta("ERROR", "No se encontro registros", "3");
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
                        Alerta("ERROR", "Error al obtener los datos ", "2");
                    }, 900)
                }
            }
            /*
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error listar documento!", "2");
                }, 900);
            } */
        });
    };
    
    
    var Obtener_expediente_persona = function (idTipoDoc, numero, parte, anio, siglas) {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Obtener_expedientes_parte/",
            datatype: "json",
            type: "post",
            data:{
               idTipoDoc :  idTipoDoc,
               numero : numero,
               parte : parte,
               anio : anio,
               siglas : siglas,
            },
            success: function (datos) {
                Cargando(0);
                oTable_obtener_expedientes.fnClearTable();
                if (!isEmpty(datos)) {
                    
                     oTable_obtener_expedientes.fnAddData(datos);
                     
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error listar documento!", "2");
                }, 900);
            }
        });
    };
    
    
    var Obtener_documentos_persona = function (idTipoDoc, numero, anio, siglas) {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Obtener_documentos/",
            datatype: "json",
            type: "post",
            data:{
               idTipoDoc :  idTipoDoc,
               numero : numero,
               anio : anio,
               siglas : siglas,
            },
            success: function (datos) {
                Cargando(0);
                oTable_obtener_documentos.fnClearTable();
                if (!isEmpty(datos)) {
                    
                     oTable_obtener_documentos.fnAddData(datos);
                     
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error listar documento!", "2");
                }, 900);
            }
        });
    };
    
    
    
    var Obtener_expedientes_asunto = function () {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Obtener_expedientes_asunto/",
            datatype: "json",
            type: "post",
            data:{
               idTipoDoc :  $("#cbo_tipos_documentos_asunto").val(),
               anio : $("#cbo_anio_asunto").val(),
               asunto : $("#txt_asunto").val()
            },
            success: function (datos) {
                Cargando(0);
                oTable_Documentos_Asunto.fnClearTable();
                if (!isEmpty(datos)) {
                    
                     oTable_Documentos_Asunto.fnAddData(datos);
                     
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error listar documento!", "2");
                }, 900);
            }
        });
    };
    
    
    
    var Obtener_documentos_asunto = function () {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Obtener_documentos_asunto/",
            datatype: "json",
            type: "post",
            data:{
               idTipoDoc :  $("#cbo_tipos_documentos_asunto").val(),
               anio : $("#cbo_anio_asunto").val(),
               asunto : $("#txt_asunto").val()
            },
            success: function (datos) {
                Cargando(0);
                oTable_Documentos_Asunto.fnClearTable();
                if (!isEmpty(datos)) {
                    
                     oTable_Documentos_Asunto.fnAddData(datos);
                     
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error listar documento!", "2");
                }, 900);
            }
        });
    };
    
    
    var Obtener_expedientes_interesado = function () {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Obtener_expedientes_interesado/",
            datatype: "json",
            type: "post",
            data:{
               accion :  $("#cbo_tipo_concepto").val(),
               criterio : $("#txt_descripcion").val(),
              // anio : $("#cbo_anio_interesado").val()
            },
            success: function (datos) {
                Cargando(0);
                oTable_Documentos_Interesado.fnClearTable();
                if (!isEmpty(datos)) {
                    
                     oTable_Documentos_Interesado.fnAddData(datos);
                     
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error listar documento!", "2");
                }, 900);
            }
        });
    };
    
    var Ver_movimientos_por_documento = function ( idDocumento, tipo) {
        Cargando(1);
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Ver_movimientos_por_documento",
            datatype: "json",
            type: "post",
            data:{
               idDocumento : idDocumento
            },
            success: function (datos) {
                Cargando(0);
                console.log(datos);
                if(tipo==1){
                    oTable_Ver_Movimientos_por_documento.fnClearTable();
                    if (datos.length> 0) {
                         console.log(datos);
                         oTable_Ver_Movimientos_por_documento.fnAddData(datos);
                    }
                }else{
                    oTable_Ver_Movimientos_por_documento_persona.fnClearTable();
                    if (datos.length> 0) {
                        oTable_Ver_Movimientos_por_documento_persona.fnAddData(datos);
                    }
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
                        Alerta("ERROR", "Error al obtener los datos!", "2");
                    }, 900)
                }
            }
            /*
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error listar movimientos!", "2");
                }, 900);
            } 
            */
        });
    };
    
    
    
    var listar_tipos_documentos = function () {
        
        $.ajax({
            url: "ConsultarDocumentoMovimientos/Listar_tipos_documentos",
            datatype: "json",
            type: "post",
            success: function (datos) {
                
                variable =   datos;
                            
                $('#cbo_tipos_documentos').empty().append("<option></option>");
                $('#cbo_tipoDocumento_persona').empty().append("<option></option>");
                $('#cbo_tipos_documentos_asunto').empty().append("<option></option>");
//               
                console.log(datos);
                for ( var i = 0; i < datos.length; i++ )
                {
                    $('#cbo_tipos_documentos').append('<option value="' + datos[i].IDTIPODOCUMENTO + '">' + datos[i].NOMBREDOCUMENTO + '</option>');
                    $('#cbo_tipoDocumento_persona').append('<option value="' + datos[i].IDTIPODOCUMENTO + '">' + datos[i].NOMBREDOCUMENTO + '</option>');
                    $('#cbo_tipos_documentos_asunto').append('<option value="' + datos[i].IDTIPODOCUMENTO + '">' + datos[i].NOMBREDOCUMENTO + '</option>');
                        
                }  
                
                
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de tipos de documento!", "2");
                }, 900);
            }
        });
        
    };
    
    var ListarDependencias = function () {

        $.ajax({
            url: "CrearDocumento/Listar_dependencias",
            datatype: "json",
            type: "post",
            async: true,
            success: function (data) {
                Cargando(0);
                var html = "";
                //console.log(data);
                $.each(data, function (index, item) {
                    html += '<option value="' + item.IDORGANIGRAMA + '">' + item.NOMBREAREA + '</option>';
                });
                $("#cbo_dependencia_persona").html(html);
                $("#cbo_dependencia_persona").select2({placeholder: "Seleccione una dependencia"});
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista de dependencias!", "2");
                }, 900)
            }
        });
    }
    
    
    var Listar_personal_x_dependencia = function (id) {
        $.ajax({
            url: "CrearDocumento/Listar_personal_x_dependencia_general",
            datatype: "json",
            type: "post",
            async: true,
            data: {id: $("#cbo_dependencia_persona").val()},
            success: function (data) {
                Cargando(0);
                var html = '';
                console.log(data);
                $.each(data, function (index, item) {
                    html += '<option value="' + item.NCODIGO + '">' + item.NNOMBRE + '</option>';
                });
                $("#cbo_trabajador_persona").html(html);
                $("#cbo_trabajador_persona").select2({placeholder: "Seleccione un trabajador"});
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener la lista del personal de la dependencia seleccionada!", "2");
                }, 900)
            }
        });
    }
    
    
    var Consultar_Persona = function () {

        $.ajax({
            url: "ConsultarDocumentoMovimientos/Consultar_Persona",
            datatype: "json",
            type: "post",
            async: true,
            data: {
                "idTipoDoc": $("#cbo_tipoDocumento_persona").val(),
                "dependencia": $("#cbo_dependencia_persona").val(),
                "nPerId": $("#cbo_trabajador_persona").val(),
                "anio": $("#cbo_anio_persona").val()
            },
            success: function (datos) {
                Cargando(0);
                oTable_Documentos.fnClearTable();
                
                if (!isEmpty(datos)) {
                    oTable_Documentos.fnAddData(datos);
                }
            },
            error: function (msg) {
                setTimeout(function () {
                    Cargando(0);
                    Alerta("ERROR", "Error obtener los documentos de la persona seleccionada!", "2");
                }, 900);
            }
        });
    };
    

    
    var fillAnios = function () {
        var currentYear = (new Date).getFullYear();
        for (var i = currentYear; i >= 1980; i--) {
            $('#cbo_anio').append("<option value='" + (i) + "'>" + (i) + "</option");
            $('#cbo_anio_persona').append("<option value='" + (i) + "'>" + (i) + "</option");
            $('#cbo_anio_asunto').append("<option value='" + (i) + "'>" + (i) + "</option");
            $('#cbo_anio_interesado').append("<option value='" + (i) + "'>" + (i) + "</option");
        }

    };
    
    
    var datos_globales= function (){
        idDocumentoPersona ='';
        datosDocumento_persona=null;
        idDocumento = '';
        datosDocumento= null;

    }

    
        
    var CargaInicial = function () {
        listar_tipos_documentos();
        
        $("#txtFecIni").datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#txtFecFin').datepicker({
            format: 'dd-mm-yyyy'
        });

    };   
    return {
        init: function () {

            //initDatables();
            datos_globales();
            initDatablesRefs();
            initDatables_obtener_expedientes();
            initDatables_Ver_Movimientos_por_documento();
            initDatables_Ver_Movimientos_por_documento_persona();
            initDatables_obtener_documentos();
            initDatables_Documentos_Persona();
            initDatablesAdjuntos();
            initDatablesAdjuntosRefe();
            initDatables_Documentos_Asunto();
            initDatables_Documentos_Interesado();
            initDatables_Expedientes_partes();
            eventos();
            plugins();
            CargaInicial();


        }
    };

}();