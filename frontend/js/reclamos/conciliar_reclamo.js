var conciliar_reclamo = function () {

    var carga_inicial = function(){
        
    }

    var plugins = function () {
        
        
    }
    var eventos = function(){
        $( "#Buscar_suministro" ).click(function() {
            buscar_reclamo();
        });
        $( "#editar_reclamante" ).click(function() {
            if(correctaBusqueda =='1'){
                $("#tip_negocia_cliente").prop('disabled', false);
                $("#nombre_reclamante").prop('readonly', false);
                $("#DNI_reclamante").prop('readonly', false);
                $("#numero_descripcion_reclamante").prop('readonly', false);
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

        $( "#Limpiar_suministro" ).click(function() {
            location.reload();
        });

        $( "#registrar_negocia" ).click(function() {
            Guardar_conciliacion();
        });

        $( "#imprimir_negociacion" ).click(function() {
            imprimir_conciliacion();
        });

        $( "#MODAL_SOLICITUD_OK" ).click(function() {
            obtener_solicitud();
        });
        $( "#costo_proceso" ).keypress(function(event) {
            if(event.which < 45 || event.which > 58 || event.which == 47 ) {
                return false;
                  event.preventDefault();
              } // prevent if not number/dot
      
              if(event.which == 46 && this.value.indexOf('.') != -1) {
                  return false;
                  event.preventDefault();
              } // prevent if already dot
            
              if(event.which == 45 && this.value.indexOf('-') != -1) {
                  return false;
                  event.preventDefault();
              } // prevent if already dot
              
              if(event.which == 45 && this.value.length>0) {
                  event.preventDefault();
              } // prevent if already -
      
          return true;
        });

        $( "#MODAL_SOLICITUD_CANCEL" ).click(function() {
            $('#MODAL_SOLICITUD').modal('hide');
        });

        $( "#cerrar_reclamante" ).click(function() {
            if(correctaBusqueda =='1'){
                $("#tip_negocia_cliente").prop('disabled', true);
                $("#nombre_reclamante").prop('readonly', true);
                $("#DNI_reclamante").prop('readonly', true);
                $("#numero_descripcion_reclamante").prop('readonly', true);    
            }
        });
        
    }

    var imprimir_conciliacion = function(){
        json = JSON.stringify(new Array(
            ($("#empresa_cliente").val()).trim(),
            ($("#oficina_cliente").val()).trim(),
            ($("#area_cliente").val()).trim(),
            ($("#cate_cliente").val()).trim(),
            ($("#doc_cliente").val()).trim(),
            ($("#serie_cliente").val()).trim(),
            ($("#nroReclamo_cliente").val()).trim()
        ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "imprimir_conciliacion/nuevo",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'imprimir_conciliacion',
                'value': json,
                'type': 'hidden'
            }));
        $(document.body).append(form);
        form.submit();
    }

    var Guardar_conciliacion = function(){
        var empresa =   ($("#empresa_cliente").val()).trim();
        var oficina =   ($("#oficina_cliente").val()).trim();
        var area    =   ($("#area_cliente").val()).trim();
        var ctdcod  =   ($("#cate_cliente").val()).trim();
        var doccod  =   ($("#doc_cliente").val()).trim();
        var serie   =   ($("#serie_cliente").val()).trim();
        var reclamo =   ($("#nroReclamo_cliente").val()).trim();
        var prop_reclamante   =($("#txtAreaTrabajaReclamante").val()).trim();
        var prop_eps          = ($("#txtAreaTrabajaEps").val()).trim();
        var costo_concilia    =($("#costo_proceso").val()).trim();
        var puntos_acuerdo    =($("#puntos_en_acuerdo").val()).trim();
        var puntos_desacuerdo = ($("#puntos_en_desacuerdo").val()).trim();
        var radio_subsis_reclamo  = $("input[name='subsisteReclamo']:checked").val();
        var radio_conciliador_reclamo  = $("input[name='cataPoder_negocia']:checked").val();
        var obs_reclamante = ($("#observaciones_reclamante").val()).trim();
        var nom_reclamante = ($("#nombre_reclamante").val()).trim();
        var dni_reclamante = ($("#DNI_reclamante").val()).trim(); 
        var doc_reclamante = ($("#numero_descripcion_reclamante").val()).trim(); 
        var hora_inicio = ($("#hora_real_concilia").val()).trim();
        var hora_conciliacion = ($("#hora_conciliacion").val()).trim();
        var resultado_negocia = ($("#tipo_de_resultado").val()).trim();
        var codigo_intervine = ($("#tip_negocia_cliente").val()).trim();
        if(prop_reclamante =='' || prop_eps =='' || puntos_acuerdo =='' || puntos_desacuerdo =='' ){
            (prop_reclamante == '') ? $('#txtAreaTrabajaReclamante').css('border-color','red') : $('#txtAreaTrabajaReclamante').css('border-color','') ;
            (prop_eps == '') ? $('#txtAreaTrabajaEps').css('border-color','red') : $('#txtAreaTrabajaEps').css('border-color','') ;
            (puntos_acuerdo == '') ? $('#puntos_en_acuerdo').css('border-color','red') : $('#puntos_en_acuerdo').css('border-color','') ;
            (puntos_desacuerdo == '') ? $('#puntos_en_desacuerdo').css('border-color','red') : $('#puntos_en_desacuerdo').css('border-color','') ;
        
        }else{
            $('#txtAreaTrabajaReclamante').css('border-color','');
            $('#txtAreaTrabajaEps').css('border-color','');
            $('#puntos_en_acuerdo').css('border-color','');
            $('#puntos_en_desacuerdo').css('border-color','');
            show_swal('info', 'GUARDANDO DATOS ', 'Espere mientras se guarda los datos', false, false, false);
            $.ajax({
                type: "POST",
                url: "guardar_registro_concilia?ajax=true",
                data: {
                    empre: empresa, 
                    oficod: oficina,
                    arecod: area ,
                    ctdco : ctdcod ,
                    docCod: doccod ,
                    ser: serie ,
                    recla: reclamo,
                    pro_recla: prop_reclamante,
                    pro_eps: prop_eps ,
                    cost_concilia: costo_concilia ,
                    pto_acuerdo: puntos_acuerdo  ,
                    pto_desacuerdo: puntos_desacuerdo,
                    hra_inicio : hora_inicio,
                    rd_subsis_recla : radio_subsis_reclamo,
                    observa_recla : obs_reclamante,
                    rd_conciliador: radio_conciliador_reclamo,
                    nom_recla: nom_reclamante,
                    dni_recla:  dni_reclamante,
                    hora_concilia : hora_conciliacion,
                    documento_reclamante : doc_reclamante,
                    result_negocia : resultado_negocia,
                    cod_inter: codigo_intervine
                },
                dataType: 'json',
                success: function(data) {
                    if(data.result) {
                        swal.close();
                        $("#registrar_negocia").prop('disabled', true);
                        //$("#registar_y_cerrar_negocia").prop('disabled', true);
                        $("#imprimir_negociacion").prop('disabled', false);
                        return true;
                    }else{
                        sweetAlert(data.titulo, data.mensaje, data.tipo);
                        return false;
                    }
                }
            });

        }
    
    }

    var obtener_solicitud = function(){
        var datos = $('#tbl_busqueda_solicitud').DataTable().row('.selected').data();
        console.log(datos);
        $.ajax({
            type: "POST",
            url: "reclamo_conciliar?ajax=true",
            data: {
                'conciliacion': JSON.stringify(datos)
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    console.log(data);
                    correctaBusqueda = '1';
                    $("#text_busqueda").prop('readonly', true);
                    $("#empresa_cliente").val(datos.EMPCOD);
                    $("#oficina_cliente").val(datos.OFICOD);
                    $("#area_cliente").val(datos.ARECOD);
                    $("#cate_cliente").val(datos.CTDCOD);
                    $("#doc_cliente").val(datos.DOCCOD);
                    $("#serie_cliente").val(datos.SERNRO);
                    $("#nroReclamo_cliente").val(datos.RECID);
                    $("#numero_descripcion_reclamante").val((datos.RECDOCPODER).trim());
                    $("#tip_negocia_cliente").val(datos.TREPCOD); 
                    $("#tip_negocia_cliente").prop('disabled', true);; 
                    $("#negocia_cliente").val(1); 
                    $("#txtAreaTrabajaEps").prop('readonly', false);
                    $("#txtAreaTrabajaReclamante").prop('readonly', false);
                    $("#costo_proceso").prop('readonly', false);
                    $("#puntos_en_acuerdo").prop('readonly', false);
                    $("#puntos_en_desacuerdo").prop('readonly', false);
                    $("#observaciones_reclamante").prop('readonly', false);
                    $("#hora_real_concilia").val(data.hora);
                    $("#hora_conciliacion").val(data.hora_concilia);
                    $("#nombre_reclamante").val((data.reclamante.PRENOM).trim()+' '+ (data.reclamante.PREAPEPAT).trim() +' '+(data.reclamante.PREAPEMAT).trim());
                    $("#DNI_reclamante").val((data.reclamante.PREDOCID).trim());
                    $("#registrar_negocia").prop('disabled', false);
                    //$("#registar_y_cerrar_negocia").prop('disabled', false);
                    $('#MODAL_SOLICITUD').modal('hide');
                }
            }
        });
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
        Num_dato = Num_dato.trim();
        var  des_documento = "SUMINISTRO";
    	if (Num_dato !="") {

            if (Num_dato.length ==11 || Num_dato.length ==7 ) {
    			verifico_dato(Num_dato, des_documento);
            }else{
                swal("Atención", "Ingresó "+des_documento+" Incorrecto", "error");
            }	
    	}else{
			swal("Atención", "No ingresó ningun suministro", "error");
		}
    }
    var buscar_dato_suministro = function (Num_dato){
        show_swal('info', 'Buscando Suministro: '+Num_dato, 'Espere mientras buscamos al usuario', false, false, false);
        $.ajax({
            type: "POST",
            url: "buscar_reclamo_concilia?ajax=true",
            data: {
                documento: Num_dato
            },
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    swal.close();
                    if(data.suministros.length == 1){
                        console.log(data);
                        correctaBusqueda = '1';
                        $("#text_busqueda").prop('readonly', true);
                        $("#empresa_cliente").val(data.suministros[0].EMPCOD);
                        $("#oficina_cliente").val(data.suministros[0].OFICOD);
                        $("#area_cliente").val(data.suministros[0].ARECOD);
                        $("#cate_cliente").val(data.suministros[0].CTDCOD);
                        $("#doc_cliente").val(data.suministros[0].DOCCOD);
                        $("#serie_cliente").val(data.suministros[0].SERNRO);
                        $("#nroReclamo_cliente").val(data.suministros[0].RECID);
                        $("#numero_descripcion_reclamante").val((data.suministros[0].RECDOCPODER).trim());
                        $("#tip_negocia_cliente").val(data.suministros[0].TREPCOD); 
                        $("#tip_negocia_cliente").prop('disabled', true);
                        $("#negocia_cliente").val(1); 
                        $("#txtAreaTrabajaEps").prop('readonly', false);
                        $("#txtAreaTrabajaReclamante").prop('readonly', false);
                        $("#costo_proceso").prop('readonly', false);
                        $("#puntos_en_acuerdo").prop('readonly', false);
                        $("#puntos_en_desacuerdo").prop('readonly', false);
                        $("#observaciones_reclamante").prop('readonly', false);
                        $("#hora_real_concilia").val(data.hora);
                        $("#hora_conciliacion").val(data.hora_concilia);
                        $("#nombre_reclamante").val((data.reclamante.PRENOM).trim()+' '+ (data.reclamante.PREAPEPAT).trim() +' '+(data.reclamante.PREAPEMAT).trim());
                        $("#DNI_reclamante").val((data.reclamante.PREDOCID).trim()); 
                        $("#registrar_negocia").prop('disabled', false);
                        //$("#registar_y_cerrar_negocia").prop('disabled', false);
                        //console.log(data.suministros.length);

                    }else{
                        $('#MODAL_SOLICITUD').modal('show');
                        Tabla_solicitud.fnClearTable();
                        Tabla_solicitud.fnAddData(data.suministros);
                        console.log(data.suministros);
                    
                    }
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
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

    var carga_tablas = function(){
        
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
    }

    var datos_globales= function (){
        fecha_actual ='';
        correctaBusqueda = '';
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