<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/alertify.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/alertify/css/themes/semantic.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('ip') ?>/frontend/plugins/daterangepicker/daterangepicker-bs3.css">
<style>
    .daterangepicker .calendar th,
    .daterangepicker .calendar td{
        font-family: Ubuntu;
    }
</style>
<section class="content">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h5 class="box-title text-uppercase" style='font-family:"Ubuntu"'><i class="fa fa-list-alt"></i> Reporte Notas de Crédito</h5>
        </div>
        <div class="panel-body">
            <form role='form'>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Seleccionar Agencias</b>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id='todas'> Todas las Oficinas
                                </label>
                                <a data-toggle="tooltip" onclick="obtener_oficinas()" data-placement="bottom" data-original-title="Seleccionar Oficinas">
                                    <i class="fa fa-cog fa-1x fa-fw" style="color:#5cb85c; cursor:pointer"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <b>Intervalo de fechas</b>
                            <div class="form-inline form-group">
                                <input id="fechaInicio" name="fechaInicio" class="form-control" value="<?php echo date ( 'd/m/Y' , strtotime ( '-1 year' , strtotime ( date('d-m-Y') ) )) ?>" style="background: white;" readonly="" type="text">
                                <span> hasta </span>
                                <input id="fechaFin" name="fechaFin" class="form-control" value="<?php echo date('d/m/Y') ?>"  style="background: white;" readonly="" type="text">
                            </div>
                        </div>
                        <div class="col-md-2" style="line-height: 65px; ">
                            <a class="btn btn-success btn-sm" style="width:100%" onclick="buscar_notas()"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="box-body" id="tablas">
            </div>
        </div>
    </div>
</section>
<div class="modal fade bs-example-modal-sm" id="actModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel" style='font-family:Ubuntu'>Oficinas de SEDALIB S.A.</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Seleccione Oficina para consultar:</label><br>
                        <div id="cuerpo_oficnas"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="oficinas_detalle()" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/alertify/alertify.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!--<script src='https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>-->
<script>
    var servidor = '<?php echo $this->config->item('ip'); ?>';
    var checked = [];
    var temporal;
    function _error(jqXHR,textStatus,errorThrown){
        if (jqXHR.status === 0)  swal({ title: "" , text: '<b> Error</b></br>Verifique su conexión a Internet. No se ha podido conectar con el Servidor.',type: 'warning'});
        else if (jqXHR.status == 404) swal({title : "",text : "<b>ERROR</b><br>EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO",type : "error" ,html : true});
        else if (jqXHR.status == 500) swal({title : "",text : "<b>ERROR</b><br>ERROR INTERNO DEL SERVIDOR",type : "error", html : true});
        else if (textStatus === 'parsererror') alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>Hubo un error en el servidor, el recurso solicitado tiene unos pequeños problemas.</strong>');
        else if (textStatus === 'timeout') swal({title : "",text : "<b>ERROR</b><br>ERROR EN EL TIEMPO DE CONEXIÓN",type : "error", html : true});
        else if (textStatus === 'abort') swal({'title' : "",'text' : "PETICIÓN CANCELADA",'type' : "error"});
        else swal({title : "", text : "<b>ERROR </b><br>ERROR DESCONOCIDO: "+jqXHR.responseText, type : "error", html : true});
    }
    function obtener_oficinas(){
        $.ajax({
            type : 'POST',
            url : servidor + 'notas/reportes/agencias?ajax=true',
            data : ({            }),
            cache : false,
            dataType : 'json',
            success : function (d){
                if(d.result){
                    var tam = d.agencias.length;
                    $("#todas").prop('checked',false)
                    $("#cuerpo_oficnas").html("");
                    var contenido = "";
                    for(var i = 0; i < tam; i++){
                        contenido += `<div class="checkbox"> 
                                        <label>
                                            <input name="oficinas[]" value="${d.agencias[i]['OFICOD']}" type="checkbox"> ${d.agencias[i]['OFIDES']}
                                        </label>
                                        </div>`; 
                    }
                    $("#cuerpo_oficnas").html(contenido);
                    $("#actModal").modal('show');
                } else {
                    alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>'+d.mensaje+'</strong>');
                }
            }, error :  function (x,y,z){
                swal.close();
                _error(x,y,z);
            }
        });
    }

    function oficinas_detalle(){
        checked = []
        $("input[name='oficinas[]']:checked").each(function ()
        {
            checked.push(parseInt($(this).val()));
        });
        console.log(checked);
    }

    
    date_data = {
        "showDropdowns": true,
        "singleDatePicker": true,
        "autoApply": false,
        "autoclose": true,
        "format": "DD/MM/YYYY",
        "separator": " / ",
        "startDate": null,
        "minDate": null,
//        "maxDate" : fchMax2,
        "drops": "down",
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "autoclose": true,
            "daysOfWeek": [
                "Dom","Lun","Mar","Mie","Jue","Vie","Sab"
            ],
            "monthNames": [
                "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                "Agosto","Septiembre","Octubre","Noviembre","Diciembre"
            ],
            "firstDay": 1
        }
    };
    date_data['startDate'] =  $('#fechaInicio').val();
    $('#fechaInicio').daterangepicker(date_data);
    date_data['startDate'] =  $('#fechaFin').val();
    date_data['minDate'] =  $('#fechaInicio').val();
    $('#fechaFin').daterangepicker(date_data);
    $('#fechaInicio').on('change', function(){
        $("#imprimirLects").css({"display":"none"});
        date_data['startDate'] = $('#fechaInicio').val();
        date_data['minDate'] =  $('#fechaInicio').val();
        $('#fechaFin').val($('#fechaInicio').val());
        $('#fechaFin').daterangepicker(date_data);
    });
    $('#fechaFin').on('change', function(){
        $("#imprimirLects").css({"display":"none"});
    });

    function buscar_notas(){
        var todas = $("#todas").prop('checked');
        if(todas == true || checked.length > 0){
            swal({
                title: "",
                text: "<h3 style='font-family:Ubuntu;font-weight:bold'>¿Está seguro que quiere obtener las notas de crédito?</h3>",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                html : true
                },function(){
                    $.ajax({
                        type : 'POST',
                        url : servidor + 'notas/reportes/obtener?ajax=true',
                        data : ({
                            todas : todas,
                            cheked : checked,
                            fechaInicio : $("#fechaInicio").val(),
                            fechaFin : $("#fechaFin").val()
                        }),
                        cache : false,
                        dataType : 'json',
                        success : function (d){
                            swal.close();
                            if(d.result){
                                $("#tablas").html("");
                                var tam = d.notas.length;
                                var contenido = "";
                                if(tam > 0){
                                    contenido += `
                                                    <div class="row">
                                                        <div class="col-md-3 col-md-offset-6">
                                                            <form id="formData1">
                                                                <input type="hidden" name="input_1" id="input_1" />
                                                                <input type="text" name='fecha1' id="fecha1" style="display:none"/>
                                                                <input type="text" name='fecha2' id="fecha2" style="display:none"/>
                                                            </form>
                                                            <a class="btn btn-success btn-sm" onclick="exportarExcel()" style="width:100%">Exportar EXCEL</a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a class="btn btn-danger btn-sm" onclick="exportarPDF()" style="width:100%">Exportar PDF</a>
                                                        </div>
                                                    </div>
                                    ` 
                                }
                                for(var i = 0; i <tam; i++){
                                    if(d.notas[i]['notas'].length > 0) {
                                        $('#oficina_'+d.notas[i]['OFICOD']).dataTable().fnDestroy();
                                        contenido += `<div class="row">
                                                        <div class="col-md-12">
                                                            <h3 style='font-family:Ubuntu' class="text-blue">${d.notas[i]['des']}</h3>
                                                            <h5><b> N° REGISTROS: </b> ${d.notas[i]['cantidad']} <b>IMPORTE: </b> ${d.notas[i]['total']}</h5>
                                                        </div>
                                                        <div class="col-md-12 table-responsive">
                                                            <table id="oficina_${d.notas[i]['OFICOD']}" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th>SUMINISTRO</th>  
                                                                        <th>RECIBO</th>
                                                                        <th>FECHA RECIBO</th>
                                                                        <th>MONTO RECIBO</th>  
                                                                        <th>NOTA</th>
                                                                        <th>FECHA NOTA</th>
                                                                        <th>MONTO NOTA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>`;
                                        for(var j = 0; j < d.notas[i]['notas'].length; j++){
                                            contenido += `
                                                            <tr>
                                                                <td class="text-right">${d.notas[i]['notas'][j]['NCACLICODF']}</td>
                                                                <td class="text-right">${d.notas[i]['notas'][j]['TOTFAC_FACSERNRO'] + "-" + d.notas[i]['notas'][j]['TOTFAC_FACNRO']}</td>
                                                                <td class="text-right">${d.notas[i]['notas'][j]['NCAFACEMIF']}</td>
                                                                <td class="text-right">${ parseFloat(d.notas[i]['notas'][j]['NCAFACTOTA']).toFixed(2)}</td>
                                                                <td class="text-right">${d.notas[i]['notas'][j]['NCASERNRO'] + "-" + d.notas[i]['notas'][j]['NCANRO']}</td>
                                                                <td class="text-right">${d.notas[i]['notas'][j]['NCAFECHA']}</td>
                                                                <td class="text-right">${ parseFloat(d.notas[i]['notas'][j]['NCATOTDIF']).toFixed(2)}</td>
                                                            </tr>
                                            `;
                                        }
                                        contenido += `</tbody>    
                                                            </table>
                                                        </div>
                                                    </div><hr style="background:#00a65a;height: 2px;border: none;">`;  
                                        
                                    }
                                }
                                temporal = d.notas;
                                $("#tablas").html(contenido);
                                for(var i = 0; i <tam; i++){
                                    $('#oficina_'+d.notas[i]['OFICOD']).DataTable({ 
                                        //dom: 'Bfrtip',
        /*buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],*/ 
        bInfo: false,"ordering": false,"lengthMenu": [[5, 10, 15, 20, -1],[5, 10, 15, 20, "Todos"]]});
                                }
                                //checked = [];
                                //$("#todas").prop('checked', false);
                                alertify.alert('<span class="text-success"><i class="fa fa-check-square" aria-hidden="true"></i> Éxito</span>', '<strong>'+d.mensaje+'</strong>');
                                console.log(d.notas)
                            } else {
                                alertify.alert('<span class="text-red"><i class="fa fa-times-circle" aria-hidden="true"></i> Error</span>', '<strong>'+d.mensaje+'</strong>');
                            }
                        }, error :  function (x,y,z){ 
                            swal.close();
                            _error(x,y,z);
                        }
                    });
                });
        } else {
            if(todas == false && checked.length == 0)
            alertify.alert('<span class="text-yellow"><i class="fa fa-times-circle" aria-hidden="true"></i> Alerta</span>', '<strong>Debe seleccionar todas o una oficina para ver las notas de crédito</strong>');
        }
    }

    function exportarExcel(){
        var form2 = $('#formData1');
        form2.attr('action',"<?php echo $this->config->item('ip')."notas/reportes/excel" ?>");
        $("#input_1").val(JSON.stringify(temporal));
        form2.attr('method','POST');
        form2.submit();
    }

    function exportarPDF(){
        var form2 = $('#formData1');
        form2.attr('action',"<?php echo $this->config->item('ip')."notas/reportes/pdf" ?>");
        $("#input_1").val(JSON.stringify(temporal));
        $("#fecha1").val($("#fechaInicio").val())
        $("#fecha2").val($("#fechaFin").val())
        form2.attr('method','POST');
        form2.submit();
    }

</script>