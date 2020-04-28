var registrar_reclamos = function () {

    var carga_inicial = function(){
        
    }
    var plugins = function () {
        $(".select2").select2({
        placeholder: "Selecciona opción...",
        dropdownParent: $('#MODAL_DERIVACION')
    });
        $('#vig_doc_representacion').daterangepicker({
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
            //"maxDate": hoy,
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
                {data: "CDPCOD"},
                {data: "CGPDES"},
                {data: "MVIDES"},
                {data: "CDSDES"},
                {data: "CPVDES"},
                {data: "CDPDES"}
            ]
        }

        Tabla_busqueda_grupo = $("#tbl_busqueda_grupo").dataTable(parametro);

        // tabla para más de usa solicitud 
        var parametro2 = {
            data: null,
            info: false,
            bFilter: true,
            bSort:false,
            select: true,
            order: [[0, "asc"]],
            columns: [
                {data: "RECDESC"},
                {data: "RECFCH"}
            ]
        }
        Tabla_solicitud = $("#tbl_busqueda_solicitud").dataTable(parametro2);
        
        // tabla para la lista de reclamos 
        var parametro3 = {
            data: null,
            info: false,
            bFilter: true,
            bSort:false,
            select: true,
            order: [[0, "asc"]],
            columns: [
                {data: "SERNRO"},
                {data: "RECID"},
                {data: "UUCOD"},
                {data: "RECDESC"},
                {data: "RECFCH"},
                {data: "PREAPEPAT"},
                {data: "PREAPEMAT"},
                {data: "PRENOM"},
                {data: "CPDESC"},
                {data: "TINSDES"},
                {data: "SRECDES"}
            ]
        }
        Tabla_lista_reclamos = $("#tbl_lista_reclamo").dataTable(parametro3);

        // tabla derivados  reclamos 
        var parametro4 = {
            data: null,
            info: false,
            bFilter: true,
            bSort:false,
            select: true,
            order: [[0, "asc"]],
            columns: [
                {data: "ARDCOD"},
                {data: "DRVFSOL"},
                {data: "DRVSOL"},
                {data: "DRVFPZO"},
                {data: "DESCRIESTADO"},
                {data: "DESCRIAREA"},
                {data: "DESCRIOFICINA"},
                {data: "DESCRIEMPRESA"}
            ]
        }
        Tabla_reclamos_deriva = $("#tbl_reclamo_deriva").dataTable(parametro4);

    
    }

    var eventos = function(){
        $('#imprimir_reclamo').attr("disabled", true); 
        $('#guarda_reclamo_envio').attr("disabled", true);
        obtener_fecha_actual();
        $( "#Buscar_suministro" ).click(function() {
            buscar_reclamo();
        });
        $( "#MODREGPER_BUSCAR_DIRECCIÓN" ).click(function() {
            $("#MODREGPER").modal('hide');
            tipo_busqueda_domicilio ='1';
            $("#BUSCAR_GRUPO_POBLA").modal('show'); 
            Tabla_busqueda_grupo.fnClearTable();
            $('#BUSCAR_POBLA_GRUPO').val('');
            $('#BUSCAR_POBLA_VIA').val('');
        });
        $( "#MODREGPER_BUSCAR_DIRE_PROCESAL" ).click(function() {
            $("#MODREGPER").modal('hide');
            tipo_busqueda_domicilio ='2';
            $("#BUSCAR_GRUPO_POBLA").modal('show'); 
            Tabla_busqueda_grupo.fnClearTable();
            $('#BUSCAR_POBLA_GRUPO').val('');
            $('#BUSCAR_POBLA_VIA').val('');
        });
        $( "#BUSCAR_GRUPO_POBLA-CANCEL" ).click(function() {
            $("#MODREGPER").modal('show');
            $("#BUSCAR_GRUPO_POBLA").modal('hide'); 
        });
        $( "#BUSCAR_OPERACION" ).click(function() {
            buscar_direccion();
        });
        $( "#Limpiar_suministro" ).click(function() {
            location.reload();
        });
        
        $( "#Form-Reset" ).click(function() {
            if(trabajando =='1'){
                limpiar_reclamante();
            }
        });
        $( "#BUSCAR_GRUPO_POBLA-OK" ).click(function() {
            agregar_direccion();
        });
        $( "#guarda_reclamo_envio" ).click(function() {
            guarda_envio_reclamo();
        });

        $( "#MODAL_SOLICITUD_CANCEL" ).click(function() {
            $('#MODAL_SOLICITUD').modal('hide');
        });

        $("#NSUM-INI").change(function(){
            swal({
              title: "Buscando Reclamos...",
              text: "",
              showConfirmButton: false
            });
            cargar_reclamo_intervalo();
        });

        $("#NSUM-FIN").change(function(){
            swal({
              title: "Buscando Reclamos...",
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
        
        $( "#MODREGPER-CANCEL" ).click(function() {
            tipo_reclamante ='';
            $('#MODREGPER').modal("hide");
        });

        $( "#Form-Edit" ).click(function() {
            if(trabajando =='1'){
                editar_documento();
            }
            
        });
        $( "#list_recla_derivar" ).click(function() {
            ventana_derivar();
        });
        $( "#btn_derivacion_guardar" ).click(function() {
            guardar_derivacion_modal();
        });

        $( "#MODREGPER-OK" ).click(function() {
            guardar_documento();
        });
        $( "#MODAL_SOLICITUD_OK" ).click(function() {
            obtener_solicitud();
        });
        $( "#MODAL_DERIVACION_CANCEL" ).click(function() {
            $("#MODAL_DERIVACION").modal('hide');
        });
        $( "#imprimir_reclamo" ).click(function() {
            imprimir_reclamo();
        });
        $( "#btn_deriva_agrega" ).click(function() {
            nueva_derivacion();
        });
        $( "#btn_deriva_editar" ).click(function() {
            editar_derivacion();
        });
        $( "#btn_deriva_anular" ).click(function() {
            anular_derivacion();
        });

        $( "#btn_derivacion_atras" ).click(function() {
            atras_guardar_derivacion();
        });
        
        /*
        $("#MODREGPER-OK").one('click', function (event) {  
            event.preventDefault();
            guardar_documento();
            $(this).prop('disabled', true);
        });*/
        
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

    

    var guardar_derivacion_modal = function(){

        var fecha_maxima  = ($("#inp_fch_derivacion_mx").val()).trim();
        var areaderiva    = ($("#inp_deriva_area_destino").val()).trim();
        var oficinaderiva = ($("#inp_deriva_oficina_destino").val()).trim();  
        var empresaderiva = ($("#inp_deriva_empresa_destino").val()).trim();
        var descriDeriva  = ($("#txt_area_deriva_descripcion").val()).trim();

        if(fecha_maxima =='' || areaderiva =='' || oficinaderiva =='' || empresaderiva =='' || descriDeriva =='' ){
            (fecha_maxima == '') ? $('#inp_fch_derivacion_mx').css('border-color','red') : $('#inp_fch_derivacion_mx').css('border-color','') ;
            (areaderiva == '') ? $('#inp_deriva_area_destino').css('border-color','red') : $('#inp_deriva_area_destino').css('border-color','') ;
            (oficinaderiva == '') ? $('#inp_deriva_oficina_destino').css('border-color','red') : $('#inp_deriva_oficina_destino').css('border-color','') ;
            (empresaderiva == '') ? $('#inp_deriva_empresa_destino').css('border-color','red') : $('#inp_deriva_empresa_destino').css('border-color','') ;
            (descriDeriva == '') ? $('#txt_area_deriva_descripcion').css('border-color','red') : $('#txt_area_deriva_descripcion').css('border-color','') ;
        }else{
            $('#inp_fch_derivacion_mx').css('border-color','');
            $('#inp_deriva_area_destino').css('border-color','');
            $('#inp_deriva_oficina_destino').css('border-color','');
            $('#inp_deriva_empresa_destino').css('border-color','');
            $('#txt_area_deriva_descripcion').css('border-color','');

            $.ajax({
                type: "POST",
                url: "guardar_derivados?ajax=true",
                data: {
                    fech_actual : $("#inp_fch_derivacion").val(),
                    fech_max  : fecha_maxima,
                    area_deri : areaderiva,
                    oficina_deriva: oficinaderiva,
                    empresa_deriva: empresaderiva,
                    descri_deriva: descriDeriva,
                    empresa : $("#modal_deriva_empresa").val(),
                    oficina : $("#modal_deriva_oficina").val(),
                    area    : $("#modal_deriva_area").val(),
                    serie   : $("#modal_deriva_serie").val(),
                    ctdcod  : $("#modal_deriva_tipo").val(),
                    doccod  : $("#modal_deriva_documento").val(),
                    recid   : $("#modal_deriva_nro_documento").val(),
                    tipo_opera: bandera_deriva,
                    dato_deriva : deriva_id_edicion
                },
                dataType: 'json',
                success: function(data) {
                    if(data.respuesta) {
                        ventana_derivar_guardo();
                    }
                }
            });

        }
    }

    
    var anular_derivacion = function (){
        bandera_deriva = '3';
        var Datos_elimina = $('#tbl_reclamo_deriva').DataTable().row('.selected').data();
        //console.log(Datos_derivados);
        deriva_id_elimina = Datos_elimina.ARDCOD;
        swal({
            title: "ANULAR DERIVACIÓN",
            text: "¿Esta seguro que desea anular ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, Anular!",
            cancelButtonText: "No, Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: "guardar_derivados?ajax=true",
                    data: {
                        empresa : $("#modal_deriva_empresa").val(),
                        oficina : $("#modal_deriva_oficina").val(),
                        area    : $("#modal_deriva_area").val(),
                        serie   : $("#modal_deriva_serie").val(),
                        ctdcod  : $("#modal_deriva_tipo").val(),
                        doccod  : $("#modal_deriva_documento").val(),
                        recid   : $("#modal_deriva_nro_documento").val(),
                        tipo_opera: bandera_deriva,
                        dato_deriva : deriva_id_elimina
                    },
                    dataType: 'json',
                    success: function(data) {
                        if(data.respuesta) {
                            swal.close();
                            ventana_derivar_guardo();
                        }
                    }
                });
                
            } else{
                swal.close();
            }
        });
        
    }


    var ventana_derivar_guardo = function(){
        $('#btn_deriva_editar').prop('disabled', true);
        $('#btn_deriva_anular').prop('disabled', true);
        $("#seccion_detalle_derivacion").hide();
        $("#seccion_tabla_derivacion").show();
        $("#seccion_botones_derivacion").show();
        var datos = $('#tbl_lista_reclamo').DataTable().row('.selected').data();
        $("#modal_deriva_nro_documento").val(datos.RECID);
        $("#modal_deriva_serie").val(datos.SERNRO);
        $("#modal_deriva_area").val(datos.ARECOD+'-'+datos.AREDES);
        $("#modal_deriva_oficina").val(datos.OFICOD+'-'+datos.OFIDES);
        
        $.ajax({
            type: "POST",
            url: "obtener_derivados?ajax=true",
            data: {
                empresa: datos.EMPCOD, 
                oficina: datos.OFICOD,
                area   : datos.ARECOD,
                ctdcod : datos.CTDCOD,
                doccod : datos.DOCCOD,
                serie  : datos.SERNRO,
                reclamo: datos.RECID
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {

                    if(data.lista_derivados_reclamo != 0){
                        console.log(data.lista_derivados_reclamo);
                        Tabla_reclamos_deriva.fnClearTable();
                        Tabla_reclamos_deriva.fnAddData(data.lista_derivados_reclamo);
                        return true;
                    }
                    
                }
            }
        });
    }

    var pintar_areas_derivacion = function(codigo, texto){
        $("#inp_deriva_area_destino").val(codigo[0]+' - '+texto[0]);
        $("#inp_deriva_oficina_destino").val(codigo[1]+' - '+texto[1]);
        $("#inp_deriva_empresa_destino").val(codigo[2]+' - '+texto[2]);
    }

    var atras_guardar_derivacion = function(){
        $("#seccion_detalle_derivacion").hide();
        $("#seccion_tabla_derivacion").show();
        $("#seccion_botones_derivacion").show();
    }

    var editar_derivacion = function(){
        bandera_deriva = '2';
        $("#seccion_detalle_derivacion").show();
        $("#seccion_tabla_derivacion").hide();
        $("#seccion_botones_derivacion").hide();
        // extraigo para datos para la edicion 
        var Datos_derivados = $('#tbl_reclamo_deriva').DataTable().row('.selected').data();
        //console.log(Datos_derivados);
        deriva_id_edicion = Datos_derivados.ARDCOD;
        $('#selec_area_deriva').val(Datos_derivados.ARECODDE+"*"+Datos_derivados.OFICODDE+"*"+Datos_derivados.EMPCODDE).trigger('change');
        // pongo las fechas 
        $("#inp_fch_derivacion").val((Datos_derivados.DRVFSOL).replace(/[^a-z0-9\s]/gi, '-'));
        $("#inp_fch_derivacion_mx").val((Datos_derivados.DRVFPZO).replace(/[^a-z0-9\s]/gi, '-'));
        // la descripcion
        $("#txt_area_deriva_descripcion").val((Datos_derivados.DRVSOL).trim());
        $("#btn_derivacion_guardar").text("EDITAR");
        

    }

    var nueva_derivacion = function(){
        $("#inp_fch_derivacion").val(fecha_actual);
        $("#btn_derivacion_guardar").text("GUARDAR");
        $("#inp_fch_derivacion_mx").val('');
        $("#inp_deriva_area_destino").val('');
        $("#inp_deriva_oficina_destino").val('');  
        $("#inp_deriva_empresa_destino").val('');
        $("#txt_area_deriva_descripcion").val('');
        bandera_deriva = '1';
        $("#seccion_detalle_derivacion").show();
        $("#seccion_tabla_derivacion").hide();
        $("#seccion_botones_derivacion").hide();
    }

    var ventana_derivar = function(){
        $("#seccion_detalle_derivacion").hide();
        $("#seccion_tabla_derivacion").show();
        $("#seccion_botones_derivacion").show();
        $("#MODAL_DERIVACION").modal('show');
        var datos = $('#tbl_lista_reclamo').DataTable().row('.selected').data();
        console.log(datos);
        $("#modal_deriva_nro_documento").val(datos.RECID);
        $("#modal_deriva_serie").val(datos.SERNRO);
        $("#modal_deriva_area").val(datos.ARECOD+'-'+datos.AREDES);
        $("#modal_deriva_oficina").val(datos.OFICOD+'-'+datos.OFIDES);
        
        $.ajax({
            type: "POST",
            url: "obtener_derivados?ajax=true",
            data: {
                empresa: datos.EMPCOD, 
                oficina: datos.OFICOD,
                area   : datos.ARECOD,
                ctdcod : datos.CTDCOD,
                doccod : datos.DOCCOD,
                serie  : datos.SERNRO,
                reclamo: datos.RECID
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {

                    if(data.lista_derivados_reclamo != 0){
                        console.log(data.lista_derivados_reclamo);
                        Tabla_reclamos_deriva.fnClearTable();
                        Tabla_reclamos_deriva.fnAddData(data.lista_derivados_reclamo);
                        return true;
                    }
                    
                }
            }
        });

    }

    var cambiar_estado_botones= function(tipo){
        if(tipo == 1){
            $('#list_recla_derivar').prop('disabled', true);
        }else{
            $('#list_recla_derivar').prop('disabled', false);
        }
    }

    var cambiar_estado_botones_derivacion = function(tipo){
        if(tipo == 1){
            $('#btn_deriva_editar').prop('disabled', true);
            $('#btn_deriva_anular').prop('disabled', true);
        }else{
            $('#btn_deriva_editar').prop('disabled', false);
            $('#btn_deriva_anular').prop('disabled', false);
        }
    }

    var cargar_reclamo_intervalo = function(){
        $.ajax({
            type: "POST",
            url: "intevalo_reclamos?ajax=true",
            data: {
                inicio: $("#NSUM-INI").val(), 
                fin:$("#NSUM-FIN").val(),
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    Tabla_lista_reclamos.fnClearTable();
                    Tabla_lista_reclamos.fnAddData(data.lista_reclamos);
                    swal.close();
                    return true;
                }
            }
        });
    }

    var imprimir_reclamo = function(){
        json = JSON.stringify(new Array(
            ($("#serie_trab").val()).trim(),
            ($("#empresa_trab").val()).trim(),
            reclamo_global
        ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "imprimir_reclamo/nuevo",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_reclamo',
                'value': json,
                'type': 'hidden'
            }));
        $(document.body).append(form);
        form.submit();
    }

    var guarda_envio_reclamo = function(){
        var serie            = ($("#serie_trab").val()).trim();
        var empresa          = ($("#empresa_trab").val()).trim();
        var num_documento    = ($("#Form-Id").val()).trim();
        var codigo           = ($("#text_busqueda").val()).trim();
        var descri_reclamo   = ($("#descri_reclamo_cliente").val()).trim();
        var funda_reclamo    = ($("#fundamento_reclamo_cliente").val()).trim();
        var plazo_max_aten   = ($("#plazo_reclamo").val()).trim();
        var fech_palz_max    = ($("#fecha_max_atencion").val()).trim();
        var radio_cartilla   = $("input[name='cartillaRadio']:checked").val();
        var radio_contrasta  = $("input[name='contrastaRadio']:checked").val();
        var radio_correo  = $("input[name='enviaCorreoRadio']:checked").val();
        var telefono         = ($("#telefono_reclamante").val()).trim();
        var nombre_recl      = ($("#nombre_reclamante").val()).trim();
        var dire_recla       = ($("#direccion_reclamante").val()).trim();
        var correo           = ($("#correo_reclamante").val()).trim();
        var cate_cliente     = ($("#categoria_cliente").val()).trim(); //CPID
        var sub_cate_cli     = ($("#sub_cate_cliente").val()).trim(); // SCATPROBID
        var tipo_problema    = ($("#tip_problema_cliente").val()).trim(); // TIPPROBID
        var prob_cliente     = ($("#problema_cliente").val()).trim(); // PROBID
        var motivo_atencion  = ($("#atencion_reclamante").val()).trim(); // MOACOD
        var tipo_representacion     = ($("#tipo_representacio_reclamante").val()).trim(); 
        var num_doc_representacion  = ($("#doc_representacion").val()).trim(); 
        var fecha_vig_representacion =($("#vig_doc_representacion").val()).trim();
        var tipo_etapa_reclamo = ($("#etapa_reclamo").val()).trim();
        var fecha_etapa_reclamo = ($("#fecha_etapa_reclamo").val()).trim();
        var instancia_reclamo = ($("#instancia_reclamo").val()).trim();
        var fecha_instancia_reclamo = ($("#fecha_instancia_reclamo").val()).trim();
        var cierre_reclamo = ($("#motivo_cierre_reclamo").val()).trim();
        var fecha_cierre_reclamo = ($("#fecha_cierre_reclamo").val()).trim();
        var sit_reclamo = ($("#situacion_reclamo").val()).trim();
        // conciliacion
        var fecha_concilia = ($("#fecha_conciliacion").val()).trim();
        var descri_concilia = ($("#descri_conciliacion").val()).trim();
        // valido campos de reclamo 
        if(cate_cliente =='' || descri_reclamo =='' || funda_reclamo =='' || num_documento == '' || telefono =='' || correo=='' || nombre_recl=='' || dire_recla =='' || num_doc_representacion =='' || fecha_vig_representacion =='' || fecha_concilia =='' || descri_concilia =='' ){
            (cate_cliente == '') ? $('#categoria_cliente').css('border-color','red') : $('#categoria_cliente').css('border-color','') ;
            (descri_reclamo == '') ? $('#descri_reclamo_cliente').css('border-color','red') : $('#descri_reclamo_cliente').css('border-color','') ;
            (funda_reclamo == '') ? $('#fundamento_reclamo_cliente').css('border-color','red') : $('#fundamento_reclamo_cliente').css('border-color','') ;
            (num_documento == '') ? $('#Form-Id').css('border-color','red') : $('#Form-Id').css('border-color','') ;
            (telefono == '') ? $('#telefono_reclamante').css('border-color','red') : $('#telefono_reclamante').css('border-color','') ;
            (correo == '') ? $('#correo_reclamante').css('border-color','red') : $('#correo_reclamante').css('border-color','') ;
            (nombre_recl == '') ? $('#nombre_reclamante').css('border-color','red') : $('#nombre_reclamante').css('border-color','') ;
            (dire_recla == '') ? $('#direccion_reclamante').css('border-color','red') : $('#direccion_reclamante').css('border-color','') ;
            (num_doc_representacion == '') ? $('#doc_representacion').css('border-color','red') : $('#doc_representacion').css('border-color','') ;
            (fecha_vig_representacion == '') ? $('#vig_doc_representacion').css('border-color','red') : $('#vig_doc_representacion').css('border-color','') ;
            (fecha_concilia == '') ? $('#fecha_conciliacion').css('border-color','red') : $('#fecha_conciliacion').css('border-color','') ;
            (descri_concilia == '') ? $('#descri_conciliacion').css('border-color','red') : $('#descri_conciliacion').css('border-color','') ;
           
        }else{
            $('#categoria_cliente').css('border-color','');
            $('#descri_reclamo_cliente').css('border-color','');
            $('#fundamento_reclamo_cliente').css('border-color','');
            $('#Form-Id').css('border-color','');
            $('#telefono_reclamante').css('border-color','');
            $('#correo_reclamante').css('border-color','');
            $('#nombre_reclamante').css('border-color','');
            $('#direccion_reclamante').css('border-color','');
            $('#doc_representacion').css('border-color','');
            $('#vig_doc_representacion').css('border-color','');
            $('#fecha_conciliacion').css('border-color','');
            $('#descri_conciliacion').css('border-color','');
            // envio 
            $.ajax({
                type: "POST",
                url: "guardar_reclamo_nuevo?ajax=true",
                data: {
                    ser: serie,
                    empre: empresa,
                    cod: codigo,
                    num_doc : num_documento,
                    descri_recla: descri_reclamo,
                    fund_recla: funda_reclamo,
                    pla_max : plazo_max_aten,
                    fe_pla_max: fech_palz_max,
                    rad_cart: radio_cartilla,
                    rad_correo : radio_correo,
                    rad_contra: radio_contrasta,
                    tel: telefono, 
                    corr: correo,
                    cat_cli: cate_cliente,  //CPID
                    sub_cat_cli: sub_cate_cli, // SCATPROBID
                    tip_prob: tipo_problema, // TIPPROBID
                    pro_cli: prob_cliente, // PROBID
                    mot_aten: motivo_atencion, // MOACOD
                    tip_representa: tipo_representacion, 
                    doc_representa: num_doc_representacion,
                    fech_vig_repre : fecha_vig_representacion,
                    tipo_eta_recla : tipo_etapa_reclamo, 
                    fech_eta_recla : fecha_etapa_reclamo,
                    inst_recla :instancia_reclamo,
                    fech_insta_recla : fecha_instancia_reclamo,
                    cierre_recla : cierre_reclamo,
                    fe_cierre_recla : fecha_cierre_reclamo,
                    sit_recla : sit_reclamo,
                    fch_max_res: fecha_max_res,
                    fecha_con : fecha_concilia,
                    hra_concilia : $("#hora_conciliacion option:selected").text(),
                    descri_conci : descri_concilia
                },
                dataType: 'json',
                success: function(data) {
                    if(data.result) {
                        reclamo_global = data.reclamo;
                        swal({
                            title: "RECLAMOS",
                            text: "SE GUARDO DE MANERA EXITOSA EL RECLAMO",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "OK",
                            cancelButtonText: "",
                            closeOnConfirm: false,
                            closeOnCancel: false
                          },
                          function(isConfirm) {
                            if (isConfirm) {

                                $('#guarda_reclamo_envio').attr("disabled", true);
                                $('#imprimir_reclamo').attr("disabled", false);  
                                swal.close();
                            } 
                        });
                    }else{
                        sweetAlert(data.titulo, data.mensaje, data.tipo);
                    }
                }
            });
        }
        
    }

    var obtener_solicitud = function(){

        var datos = $('#tbl_busqueda_solicitud').DataTable().row('.selected').data();
        $.ajax({
            type: "POST",
            url: "solicitud_seleccionada?ajax=true",
            data: {
                'solicitud': JSON.stringify(datos)
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    problema = data.descri_reclamo;
                    fecha_maxima = data.fecha_maxima;
                    fecha_resolucion = data.fecha_resolucion;
                    trabajando ='1';
                    fecha_max_res = fecha_resolucion[0].FECHAFINNN;
                    $('#Form-Id').prop('readonly', false);
                    /* para la descripcion del reclamo */
                    $("#categoria_cliente").val(problema[0].CPID+'-'+problema[0].CPDESC);
                    $("#sub_cate_cliente").val(problema[0].SCATPROBID+'-'+problema[0].SCATPROBDESC);
                    $("#tip_problema_cliente").val(problema[0].TIPPROBID+'-'+problema[0].TIPPROBDESC);
                    $("#problema_cliente").val(problema[0].PROBID+'-'+problema[0].PROBDESC);
                    // FECHA MAXIMA DE RECLAMO Y MAXIMO DE DIAS 
                    $("#fecha_cierre_reclamo").val(fecha_maxima.FECHAFINNN);
                    $("#fecha_max_atencion").val(fecha_maxima.FECHAFINNN);
                    $("#plazo_reclamo").val(data.dias_reclamo);
                    $("#MODAL_SOLICITUD").modal('hide');
                }
            }
        });
        
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
                    $("#inp_fch_derivacion").val(data.fecha);
                    Tabla_lista_reclamos.fnClearTable();
                    Tabla_lista_reclamos.fnAddData(data.lista_reclamos);
                   fecha_actual = data.fecha;
                   $('#vig_doc_representacion').daterangepicker({
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
                        "minDate": fecha_actual,
                        //"maxDate": hoy,
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
                    $('#fecha_conciliacion').daterangepicker({
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
                        "minDate": fecha_actual,
                        "maxDate": data.fecha_conciliacion,
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

                    $('#inp_fch_derivacion_mx').daterangepicker({
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
                        //"maxDate" : fecha_actual,
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
                    $("#nom_fecha_conciliacion").text('(FECHA MAX. '+data.fecha_conciliacion+' )');
                }
            }
        });
    }
    var editar_documento = function(){
        var codigo = $( '#Form-Id').data( 'codigo' );
        if(codigo != ''){
            var tipo_documento = $("#tipo_doc_reclamante").val();
            $("#MODREGPER-DNI").val(tipo_documento);
            $( "#MODREGPER-DNI" ).prop( "disabled", true);
            // buscamos al cliente 
            $('#MODREGPER-TITULO').text('EDITAR PERSONA');
            $('#MODREGPER-OK').text('EDITAR');
            limpiar_modal();
            tipo_reclamante ='2';
            $('#MODREGPER').modal("show");
            buscar_edicion(codigo);
        }
        
    }
    var buscar_edicion = function(codigo){
        $.ajax({
            type: "POST",
            url: "buscar_para_edicion?ajax=true",
            data: {
                codi: codigo
            },
            dataType: 'json',
            success: function(data) {
                if(data.respuesta) {
                    var persona = data.persona;
                    var dire = data.direccion;
                    var dire_procesal = data.dire_procesal;
                    console.log(dire);
                    console.log(dire_procesal);
                    $("#MODREGPER-TIPDOC").val(((persona.PREDOCID !== null) ? (persona.PREDOCID).trim() :'')); 
                    $("#MODREGPER-AP").val(((persona.PREAPEPAT !== null) ? (persona.PREAPEPAT).trim() :''));
                    $("#MODREGPER-AM").val(((persona.PREAPEMAT !== null) ? (persona.PREAPEMAT).trim() :''));
                    $("#MODREGPER-NM").val(((persona.PRENOM !== null)? (persona.PRENOM).trim() :''));
                    $("#MODREGPER-EMAIL").val(((persona.PREDPMAIL !== null) ? (persona.PREDPMAIL).trim() :''));
                    $("#MODREGPER-CELULAR").val(((persona.PRETEL !== null) ? (persona.PRETEL).trim() :''));
                    $("#MODREGPER-RZSOCIAL").val(((persona.PRERAZSOC !== null) ? (persona.PRERAZSOC).trim() :''));
                    /* DIRECCION DE RECLAMANTE */
                    $("#MODREGPER-DIRECCI0N").val((dire.CGPDES).trim()+' '+ (dire.MVIDES).trim() +' '+(dire.CDSDES).trim()+'-'+(dire.CPVDES).trim()+'-'+(dire.CDPDES).trim());
                    $("#MODREGPER-GRUPO_POBLA").val(dire.CGPCOD+'-'+dire.CGPDES);
                    $("#MODREGPER-VIA").val(dire.MVICOD+'-'+dire.MVIDES);
                    $("#MODREGPER-DISTRITO").val(dire.CDSCOD+'-'+dire.CDSDES);
                    $("#MODREGPER-PROVINCIA").val(dire.CPVCOD+'-'+dire.CPVDES);
                    $("#MODREGPER-DEPARTAMENTO").val(dire.CDPCOD+'-'+dire.CDPDES);
                    $("#MODREGPER-NRO").val(((persona.PRENROM !== null) ? (persona.PRENROM).trim() :''));
                    $("#MODREGPER-MNZ").val(((persona.PREMZN !== null) ? (persona.PREMZN).trim() :''));
                    $("#MODREGPER-LT").val(((persona.PRELOT !== null) ? (persona.PRELOT).trim() :''));
                    /* DIRECCION PROCESAL */
                    $("#MODREGPER_DIRECCI0N_PROCESAL").val((dire_procesal.CGPDES).trim()+' '+ (dire_procesal.MVIDES).trim() +' '+(dire_procesal.CDSDES).trim()+'-'+(dire_procesal.CPVDES).trim()+'-'+(dire_procesal.CDPDES).trim());
                    $("#MODREGPER-GRUPO_POBLA_PROCESAL").val(dire_procesal.CGPCOD+'-'+dire_procesal.CGPDES);
                    $("#MODREGPER_VIA_PROCESAL").val(dire_procesal.MVICOD+'-'+dire_procesal.MVIDES);
                    $("#MODREGPER_DISTRITO_PROCESAL").val(dire_procesal.CDSCOD+'-'+dire_procesal.CDSDES);
                    $("#MODREGPER_PROVINCIA_PROCESAL").val(dire_procesal.CPVCOD+'-'+dire_procesal.CPVDES);
                    $("#MODREGPER_DEPARTAMENTO_PROCESAL").val(dire_procesal.CDPCOD+'-'+dire_procesal.CDPDES);
                    $("#MODREGPER_NRO_PROCESAL").val(((persona.PREDPNMUN !== null) ? (persona.PREDPNMUN).trim() :''));
                    $("#MODREGPER_MNZ_PROCESAL").val(((persona.PREDPMZN !== null) ? (persona.PREDPMZN).trim() :''));
                    $("#MODREGPER_LT_PROCESAL").val(((persona.PREDPLOTE !== null) ? (persona.PREDPLOTE).trim() :''));
                }
            }
        });
    }
    var agregar_direccion = function(){
        var data = $('#tbl_busqueda_grupo').DataTable().row('.selected').data();
        if(data){
            if(tipo_busqueda_domicilio =='1'){
                $("#BUSCAR_GRUPO_POBLA_MSJ_ERROR").empty();
                $("#MODREGPER-GRUPO_POBLA").val(data.CGPCOD+'-'+(data.CGPDES).trim());
                $("#MODREGPER-VIA").val(data.MVICOD+'-'+(data.MVIDES).trim());
                $("#MODREGPER-DISTRITO").val(data.CDSCOD+'-'+(data.CDSDES).trim());
                $("#MODREGPER-PROVINCIA").val(data.CPVCOD+'-'+(data.CPVDES).trim());
                $("#MODREGPER-DEPARTAMENTO").val(data.CDPCOD+'-'+(data.CDPDES).trim());
                $("#MODREGPER-DIRECCI0N").val((data.CGPDES).trim()+' '+ (data.MVIDES).trim() +' '+(data.CDSDES).trim()+'-'+(data.CPVDES).trim()+'-'+(data.CDPDES).trim());
                $("#MODREGPER-GRUPO_POBLA_PROCESAL").val(data.CGPCOD+'-'+(data.CGPDES).trim());
                $("#MODREGPER_VIA_PROCESAL").val(data.MVICOD+'-'+(data.MVIDES).trim());
                $("#MODREGPER_DISTRITO_PROCESAL").val(data.CDSCOD+'-'+(data.CDSDES).trim());
                $("#MODREGPER_PROVINCIA_PROCESAL").val(data.CPVCOD+'-'+(data.CPVDES).trim());
                $("#MODREGPER_DEPARTAMENTO_PROCESAL").val(data.CDPCOD+'-'+(data.CDPDES).trim());
                $("#MODREGPER_DIRECCI0N_PROCESAL").val((data.CGPDES).trim()+' '+ (data.MVIDES).trim() +' '+(data.CDSDES).trim()+'-'+(data.CPVDES).trim()+'-'+(data.CDPDES).trim());
            }
            if(tipo_busqueda_domicilio =='2'){
                $("#MODREGPER-GRUPO_POBLA_PROCESAL").val(data.CGPCOD+'-'+(data.CGPDES).trim());
                $("#MODREGPER_VIA_PROCESAL").val(data.MVICOD+'-'+(data.MVIDES).trim());
                $("#MODREGPER_DISTRITO_PROCESAL").val(data.CDSCOD+'-'+(data.CDSDES).trim());
                $("#MODREGPER_PROVINCIA_PROCESAL").val(data.CPVCOD+'-'+(data.CPVDES).trim());
                $("#MODREGPER_DEPARTAMENTO_PROCESAL").val(data.CDPCOD+'-'+(data.CDPDES).trim());
                $("#MODREGPER_DIRECCI0N_PROCESAL").val((data.CGPDES).trim()+' '+ (data.MVIDES).trim() +' '+(data.CDSDES).trim()+'-'+(data.CPVDES).trim()+'-'+(data.CDPDES).trim());
            }
            console.log(data);
            $("#MODREGPER").modal('show');
            $("#BUSCAR_GRUPO_POBLA").modal('hide'); 

        }else{
            put_modregper_message('BUSCAR_GRUPO_POBLA_MSJ_ERROR','danger', 'NO HA SELECCIONADO NINGUNA DIRECCIÓN');
        }
    }
    var buscar_direccion = function(){
        var grupo = ($('#BUSCAR_POBLA_GRUPO').val().toUpperCase()).trim();
        var via = ($('#BUSCAR_POBLA_VIA').val().toUpperCase()).trim();
        console.log(grupo);
        if(grupo =='' && via =='' ){
            put_modregper_message('BUSCAR_GRUPO_POBLA_MSJ_ERROR','danger', 'NO INGRESO DATOS PARA BUSCAR');
        }else{
            mando_busqueda(grupo, via );
        }
    }
    var mando_busqueda = function(grupo, via){
        $.ajax({
            type: "POST",
            url: "buscar_direccion?ajax=true",
            data: {
                grupo_pobla: grupo,
                via_pobla: via
            },
            dataType: 'json',
            success: function(data) {
                if(data.respuesta) {
                    $("#BUSCAR_GRUPO_POBLA_MSJ_ERROR").empty();
                    Tabla_busqueda_grupo.fnClearTable();
                    Tabla_busqueda_grupo.fnAddData(data.datos);
                    console.log(data.datos);
                }else{
                    Tabla_busqueda_grupo.fnClearTable();
                    put_modregper_message('BUSCAR_GRUPO_POBLA_MSJ_ERROR','danger', 'NO SE ENCOTRÓ REGISTRO');
                    return false;
                }
            }
        });
    }
    var limpiar_reclamante = function(){
        $('#Form-Id').attr('disabled', false);
        $('#tipo_doc_reclamante').attr('disabled', false);
        $('#Form-Id').data( 'codigo','' );
        $('#Form-Id').val('');
        $('#nombre_reclamante').val('');
        $('#correo_reclamante').val('');
        $('#telefono_reclamante').val('');
        $('#direccion_reclamante').val('');
    }
    var verifico_dato = function (Num_dato, mensaje){
        var i=0;
		var bandera = 0;
		while( i< Num_dato.length ){
			if(Num_dato.charCodeAt(i)< 48 ||   Num_dato.charCodeAt(i)> 57 ){
				bandera = 1;
			}
			i++;
		}
		if(bandera == 0){
            buscar_dato_suministro(Num_dato);
		}else{
			swal("Atención", "Ingresó "+mensaje+" Incorrecto", "error");
		}
    }
    var buscar_reclamo = function(){
        var Num_dato = $("#text_busqueda").val();
        var Tip_documento = '1';
        if(Tip_documento =='1'){
            var des_documento = 'SUMINISTRO';
        }else{
            var des_documento = 'DNI';
        }
		Num_dato = Num_dato.trim();
    	if (Num_dato !="") {
            if(Tip_documento =='1'){
                if (Num_dato.length ==11 || Num_dato.length ==7 ) {
    				verifico_dato(Num_dato, des_documento);
                }else{
                    swal("Atención", "Ingresó "+des_documento+" Incorrecto", "error");
                }
            }else{
                if (Num_dato.length ==8 ) {
    				verifico_dato(Num_dato, des_documento);
                }else{
                    swal("Atención", "Ingresó "+des_documento+" Incorrecto", "error");
                }
            }
    		
    	}else{
			swal("Atención", "Ingresó "+des_documento+" Incorrecto", "error");
		}
    }
    var buscar_dato_suministro = function (Num_dato){
        show_swal('info', 'Buscando Reclamo: '+Num_dato, 'Espere mientras buscamos al usuario', false, false, false);
        $.ajax({
            type: "POST",
            url: "buscar_reclamo?ajax=true",
            data: {
                documento: Num_dato
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    documento = data.documento;
                    fecha_hoy = data.fecha_hoy;

                    //$("#text_busqueda").val(documento.CLICODFAC);
                    $('#text_busqueda').attr('disabled', true);
                    $("#nombre_cliente").val(documento.NOMBRE);
                    $("#dire_cliente").val(documento.DIRECCION);
                    $("#medidor_cliente").val(documento.MEDIDOR);
                    $("#tarifa_cliente").val(documento.TARIFA);
                    $("#ciclo_cliente").val(documento.CICLO);
                    /* fecha actual y fecha maxima de reclamo  */
                    $("#fecha_reclamo").val(fecha_hoy);
                    $("#fecha_etapa_reclamo").val(fecha_hoy);
                    $("#fecha_instancia_reclamo").val(fecha_hoy);
                    // estado de reclamo
                    $("#estado_reclamo").val(data.estado_reclamo.SRECCOD+' - '+data.estado_reclamo.SRECDES);
                    // etapa de reclamo 
                    $("#etapa_reclamo").val(data.etapa_reclamo.TETACOD+' - '+data.etapa_reclamo.TETADES);
                    // tipo de instancia
                    $("#instancia_reclamo").val(data.tipo_instancia.TINSCOD+' - '+data.tipo_instancia.TINSDES);
                    // situacion cierre 
                    $("#motivo_cierre_reclamo").val(data.sitacion_cierre.TMCRCOD+' - '+data.sitacion_cierre.TMCRDES);
                    // situacion de reclamo 
                    $("#situacion_reclamo").val(data.sit_recla.SSITCOD+' - '+data.sit_recla.SSITDES);
                    // --- DATOS 
                    $('#guarda_reclamo_envio').attr("disabled", false);
                    if(data.dni){
                        problema = data.descri_reclamo;
                        fecha_maxima = data.fecha_maxima;
                        fecha_resolucion = data.fecha_resolucion;
                        $('#Form-Id').prop('readonly', false);
                        trabajando ='1';
                        console.log(fecha_maxima);
                        /* para la descripcion del reclamo */
                        $("#categoria_cliente").val(problema[0].CPID+'-'+problema[0].CPDESC);
                        $("#sub_cate_cliente").val(problema[0].SCATPROBID+'-'+problema[0].SCATPROBDESC);
                        $("#tip_problema_cliente").val(problema[0].TIPPROBID+'-'+problema[0].TIPPROBDESC);
                        $("#problema_cliente").val(problema[0].PROBID+'-'+problema[0].PROBDESC);
                        // FECHA MAXIMA DE RECLAMO Y MAXIMO DE DIAS 
                        $("#fecha_cierre_reclamo").val(fecha_maxima.FECHAFINNN);
                        $("#fecha_max_atencion").val(fecha_maxima.FECHAFINNN);
                        $("#plazo_reclamo").val(data.dias_reclamo);
                        fecha_max_res = fecha_resolucion[0].FECHAFINNN;
                        console.log(fecha_max_res);
                        swal.close();
                    }else{
                        swal.close();
                        $('#MODAL_SOLICITUD').modal('show');
                        Tabla_solicitud.fnClearTable();
                        Tabla_solicitud.fnAddData(data.solicitud);
                        console.log(data.solicitud);
                        /*
                        sweetAlert(data.titulo, data.mensaje, data.tipo);
                        return false; 
                        */
                    }
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }
    
    var validar_correo = function (correo){
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if (regex.test(correo)) {
            return 1;
        } else {
            return 0;
        }
    }
    var guardar_documento = function(){
        var nro_doc = ($("#MODREGPER-TIPDOC").val()).trim(); 
        var ape_pat = ($("#MODREGPER-AP").val()).trim();
        var ape_mat = ($("#MODREGPER-AM").val()).trim();
        var nombre  = ($("#MODREGPER-NM").val()).trim();
        var correo  = ($("#MODREGPER-EMAIL").val()).trim();
        var celular = ($("#MODREGPER-CELULAR").val()).trim();
        var rzsoci  =  ($("#MODREGPER-RZSOCIAL").val()).trim();
        /* DIRECCION DE RECLAMANTE */
        var dire_reclamante = ($("#MODREGPER-DIRECCI0N").val()).trim();
        var grupo_poblacional = ($("#MODREGPER-GRUPO_POBLA").val()).trim();
        var via = ($("#MODREGPER-VIA").val()).trim();
        var ditrito = ($("#MODREGPER-DISTRITO").val()).trim();
        var provincia = ($("#MODREGPER-PROVINCIA").val()).trim();
        var departamento = ($("#MODREGPER-DEPARTAMENTO").val()).trim();
        var nro_muni= ($("#MODREGPER-NRO").val()).trim();
        var manzana = ($("#MODREGPER-MNZ").val()).trim();
        var lote    =  ($("#MODREGPER-LT").val()).trim();
        /* DIRECCION PROCESAL */
        var dire_procesal =  ($("#MODREGPER_DIRECCI0N_PROCESAL").val()).trim();
        var grupo_pobla_procesal = ($("#MODREGPER-GRUPO_POBLA_PROCESAL").val()).trim();
        var via_procesal = ($("#MODREGPER_VIA_PROCESAL").val()).trim();
        var ditrito_procesal = ($("#MODREGPER_DISTRITO_PROCESAL").val()).trim();
        var provincia_procesal = ($("#MODREGPER_PROVINCIA_PROCESAL").val()).trim();
        var departamento_procesal = ($("#MODREGPER_DEPARTAMENTO_PROCESAL").val()).trim();
        var nro_muni_procesal= ($("#MODREGPER_NRO_PROCESAL").val()).trim();
        var manzana_procesal = ($("#MODREGPER_MNZ_PROCESAL").val()).trim();
        var lote_procesal    =  ($("#MODREGPER_LT_PROCESAL").val()).trim();
        /*  TIPO DE PERSONA , ESTADO DE PERSONA Y TIPO DE OPERADOR */
        var tipo_persona =  $("#MODREGPER_TIPO_PERSONA").val();
        var estado_persona = $("#MODREGPER_ESTADO_PERSONA").val();
        var tipo_operador = $("#MODREGPER_OPERADOR_TELEFONICO").val();
        var tipo_documento = $( "#MODREGPER-DNI" ).val();
        if(ape_pat =='' || ape_mat =='' || nombre =='' || dire_reclamante=='' || dire_procesal=='' || correo =='' || celular =='' || (nro_muni=='' && manzana=='' && lote == '') || (nro_muni_procesal == '' && manzana_procesal == '' && lote_procesal == '') ){
            (ape_pat == '') ? $('#MODREGPER-AP').css('border-color','red') : $('#MODREGPER-AP').css('border-color','') ;
            (ape_mat == '') ? $('#MODREGPER-AM').css('border-color','red') : $('#MODREGPER-AM').css('border-color','') ;
            (nombre == '') ? $('#MODREGPER-NM').css('border-color','red') : $('#MODREGPER-NM').css('border-color','') ;
            (dire_reclamante == '') ? $('#MODREGPER-DIRECCI0N').css('border-color','red') : $('#MODREGPER-DIRECCI0N').css('border-color','') ;
            (dire_procesal == '') ? $('#MODREGPER_DIRECCI0N_PROCESAL').css('border-color','red') : $('#MODREGPER_DIRECCI0N_PROCESAL').css('border-color','') ;
            (correo == '') ? $('#MODREGPER-EMAIL').css('border-color','red') : $('#MODREGPER-EMAIL').css('border-color','') ;
            (celular == '') ? $('#MODREGPER-CELULAR').css('border-color','red') : $('#MODREGPER-CELULAR').css('border-color','') ;
            if((nro_muni=='' && manzana=='' && lote == '') && (nro_muni_procesal == '' && manzana_procesal == '' && lote_procesal == '')){
                put_modregper_message('MODREGPER-MSJ-ERROR','danger', 'FALTA COMPLETAR DATOS EN DIRECCIÓN DE RECLAMANTE Y DIRECCIÓN PROCESAL');
            }else{
                if((nro_muni=='' && manzana=='' && lote == '')){
                    put_modregper_message('MODREGPER-MSJ-ERROR','danger', 'FALTA COMPLETAR DATOS EN DIRECCIÓN DE RECLAMANTE');
                }else{
                    put_modregper_message('MODREGPER-MSJ-ERROR','danger', 'FALTA COMPLETAR DATOS EN DIRECCIÓN PROCESAL');
                }
            }
        }else{
            $('#MODREGPER-AP').css('border-color','');
            $('#MODREGPER-AM').css('border-color','');
            $('#MODREGPER-NM').css('border-color','');
            $('#MODREGPER-EMAIL').css('border-color','');
            $('#MODREGPER-CELULAR').css('border-color','');
            $('#MODREGPER-DIRECCI0N').css('border-color','');
            $('#MODREGPER_DIRECCI0N_PROCESAL').css('border-color','');
            var resCorreo =  validar_correo(correo);
            if(resCorreo == 1){
                $("#MODREGPER-MSJ-ERROR").empty();
                var codi = $( '#Form-Id').data( 'codigo' );
                $.ajax({
                    type: "POST",
                    url: "guardar_reclamante?ajax=true",
                    data: {
                        documento: nro_doc,
                        tip_opera: tipo_reclamante,
                        tip_persona : tipo_persona,
                        est_persona : estado_persona,
                        tip_operador : tipo_operador,
                        tip_docu: tipo_documento,
                        cod : codi,
                        ape_paterno: ape_pat.toUpperCase(),
                        ape_materno: ape_mat.toUpperCase() ,
                        nom: nombre.toUpperCase() ,
                        corr: correo  ,
                        cel: celular ,
                        razon_social: rzsoci  ,
                        /* DIRECCION DE RECLAMANTE */
                        dire_recla: dire_reclamante, 
                        grup_pobla: grupo_poblacional, 
                        via_dire: via ,
                        distrito_dire: ditrito, 
                        prov_dire: provincia,
                        depa_dire: departamento, 
                        numero_dire: nro_muni,
                        mna_dire: manzana ,
                        lot_dire: lote  ,
                        /* DIRECCION PROCESAL */
                        dir_procesal: dire_procesal ,
                        grup_procesal: grupo_pobla_procesal, 
                        vi_procesal: via_procesal ,
                        dist_procesal: ditrito_procesal, 
                        prov_procesal: provincia_procesal, 
                        depa_procesal: departamento_procesal, 
                        nro_procesal: nro_muni_procesal,
                        man_procesal: manzana_procesal,
                        lot_procesal: lote_procesal
                    },
                    dataType: 'json',
                    success: function(data) {
                        if(data.result) {
                            $("#MODREGPER").modal('hide'); 
                            $('#Form-Id').attr('disabled', true);
                            $('#Form-Id').val(nro_doc);
                            buscar_persona(nro_doc);
                            /*
                            $('#nombre_reclamante').val(ape_pat+' '+ape_mat+' '+nombre);
                            $('#correo_reclamante').val(correo);
                            $('#telefono_reclamante').val(celular);
                            $('#direccion_reclamante').val( nro_muni +' '+ ((manzana !== null && manzana !='' ) ? ('MNZ. '+manzana ) :'') +' '+ ((manzana !== null && manzana !='' ) ? ('LTE. '+manzana.trim() ) :'')  );
                            */
                        }else{
                            put_modregper_message('MODREGPER-MSJ-ERROR','danger', data.mensaje);
                        }
                    }
                });
            }else{
                put_modregper_message('MODREGPER-MSJ-ERROR','danger', 'CORREO INVALIDO');
                $('#MODREGPER-EMAIL').css('border-color','red');
            }
        }
    }
    var validar_otro = function (tam, mensaje){
        var Num_dni = $("#Form-Id").val();
		Num_dni = Num_dni.trim();
    	if (Num_dni !="") {
    		if (Num_dni.length >=5 && Num_dni.length <= tam ) {
				var bandera = 0;
				if(bandera == 0){
                    buscar_persona(Num_dni);
				}else{
					swal("Atención", "Ingresó "+mensaje+" Incorrecto", "error");
				}
    				
    		}else{
    			swal("Atención", "Ingresó "+mensaje+" Incorrecto", "error");
    		}
    	}else{
			swal("Atención", "Ingresó "+mensaje+" Incorrecto", "error");
		}
    }

    var validar_dni = function (tam, mensaje){
        var Num_dni = $("#Form-Id").val();
		Num_dni = Num_dni.trim();
    	if (Num_dni !="") {
    		if (Num_dni.length ==tam) {
				var i=0;
				var bandera = 0;
				while( i< Num_dni.length ){
						if(Num_dni.charCodeAt(i)< 48 ||   Num_dni.charCodeAt(i)> 57 ){
							bandera = 1;
						}
						i++;
				}
				if(bandera == 0){
                    buscar_persona(Num_dni);
				}else{
					swal("Atención", "Ingresó "+mensaje+" Incorrecto", "error");
				}
    				
    		}else{
    			swal("Atención", "Ingresó "+mensaje+" Incorrecto", "error");
    		}
    	}else{
			swal("Atención", "Ingresó "+mensaje+" Incorrecto", "error");
		}
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

    var put_modregper_message =   function (nombre,tipo, mensaje){
        $("#"+nombre).empty();
        $("#"+nombre).append('<div class="alert alert-'+tipo+' alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                                        mensaje+
                                        '</div>');
    }

    var buscar_persona = function(Num_dni){
        var tipo_documento = $("#tipo_doc_reclamante").val();
        var texto = $("#tipo_doc_reclamante option:selected").text();
        show_swal('info', 'Buscando '+texto+': '+Num_dni, 'Espere mientras buscamos al usuario', false, false, false);
        $.ajax({
            type: "POST",
            url: "buscar_dni?ajax=true",
            data: {dni: Num_dni, tipdoc: '1'},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.dni){
                        usr = data.persona;
                        dire = data.direccion;
                        $('#Form-Id').data( 'codigo', (usr['PRECOD']).trim());
                        $('#Form-Id').attr('disabled', true);
                        $('#tipo_doc_reclamante').attr('disabled', true);
                        $('#Form-Id').val(usr['PREDOCID']);
                        $('#nombre_reclamante').val((usr['PREAPEPAT']).trim()+' '+(usr['PREAPEMAT']).trim()+' '+(usr['PRENOM']).trim());
                        $('#correo_reclamante').val(usr['PREDPMAIL']);
                        $('#telefono_reclamante').val(usr['PRETEL']);
                        $('#direccion_reclamante').val( (dire['MVIDES']).trim() +' '+(dire['CGPDES']).trim()+' '+ ((usr['PREDPNMUN'] !== null && (usr['PREDPNMUN']).trim() != '') ? (usr['PREDPNMUN']).trim() : '' )  +' '+ ((usr['PREMZN'] !== null && (usr['PREMZN']).trim() !='' ) ? ('MNZ. '+(usr['PREMZN']).trim() ) :'') +' '+ ((usr['PREDPLOTE'] !== null && (usr['PREDPLOTE']).trim() !='' ) ? ('LTE. '+(usr['PREDPLOTE']).trim() ) :'') +'-'+ (dire['CDSDES']).trim()+ '-'+(dire['CPVDES']).trim()+'-'+ (dire['CDPDES']).trim() );
                        swal.close();
                    }else{
                        $('#MODREGPER-TIPDOC').val(Num_dni);
                        $('#MODREGPER-DNI').val(tipo_documento);
                        $( "#MODREGPER-DNI" ).prop( "disabled", true);
                        $('#tipo_doc_reclamante').attr('disabled', true);
                        $('#Form-Id').data( 'codigo', '');
                        tipo_reclamante ='1';
                        // REGISTRAR 
                        $('#MODREGPER-TITULO').text('REGISTRAR PERSONA');
                        $('#MODREGPER-OK').text('REGISTRAR');
                        limpiar_modal();
                        $("#MODREGPER-OK").prop('disabled', false);
                        put_modregper_message('MODREGPER-MSJ',data.tipo, data.mensaje);
                        accion_modregper = 'registrar';
                        
                        $('#MODREGPER').modal("show");
                        swal.close();
                        $("#Form-Id").val(Num_dni);
                    }
                    //sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    var limpiar_modal = function(){
        $("#MODREGPER-AP").val('');
        $("#MODREGPER-AM").val('');
        $("#MODREGPER-NM").val('');
        $("#MODREGPER-EMAIL").val('');
        $("#MODREGPER-CELULAR").val('');
        $("#MODREGPER-NRO").val('');
        $("#MODREGPER-MNZ").val('');
        $("#MODREGPER-LT").val('');
        $("#MODREGPER-RZSOCIAL").val('');
        /* DIRECCION DE RECLAMANTE */
        $("#MODREGPER-DIRECCI0N").val('');
        $("#MODREGPER-GRUPO_POBLA").val('');
        $("#MODREGPER-VIA").val('');
        $("#MODREGPER-DISTRITO").val('');
        $("#MODREGPER-PROVINCIA").val('');
        $("#MODREGPER-DEPARTAMENTO").val('');
        $("#MODREGPER-NRO").val('');
        $("#MODREGPER-MNZ").val('');
        $("#MODREGPER-LT").val('');
        /* DIRECCION PROCESAL */
        $("#MODREGPER_DIRECCI0N_PROCESAL").val('');
        $("#MODREGPER-GRUPO_POBLA_PROCESAL").val('');
        $("#MODREGPER_VIA_PROCESAL").val('');
        $("#MODREGPER_DISTRITO_PROCESAL").val('');
        $("#MODREGPER_PROVINCIA_PROCESAL").val('');
        $("#MODREGPER_DEPARTAMENTO_PROCESAL").val('');
        $("#MODREGPER_NRO_PROCESAL").val('');
        $("#MODREGPER_MNZ_PROCESAL").val('');
        $("#MODREGPER_LT_PROCESAL").val('');
        
    }


    var datos_globales= function (){
        fecha_actual ='';
        fecha_max_res = '';
        bandera_deriva = '';
        deriva_id_edicion = '';
        trabajando  ='';
        reunion_global ='';
        enviar_reclamo = '';
        bandera_modal = 0;
        tipo_busqueda_domicilio='';
        tipo_reclamante ='';
        Tabla_busqueda_grupo =null;
        reclamo_global ='';
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
