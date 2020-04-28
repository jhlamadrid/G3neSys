<section>
    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="closeModal1()"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal1-label"></h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="col-md-12" id="mensaje-modal" style="display:hidden"></div>
                        <div class="form-group control-group col-md-12">
                            <label for="tipo_identificacion">INGRESE DESCRIPCION:</label>
                            <div class="controls">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <div class="pure-form">
                                        <input class="form-control" id="bscdesc" autofocus type="text" name="Mod-bqda" style='text-transform:uppercase;' disabled/>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="box box-primary col-md-12 col-sm-12" style="width:95%; margin-left:20px; padding-top:10px;">
                            <div class="form-group control-group col-md-6">
                                <label for="modal1-codigo">CODIGO:</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-dot-circle-o"></i>
                                        </div>
                                        <input class="form-control" id="modal1-codigo" name="modal1-codigo" type="text" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-6">
                                <label for="modal1-codigo">AFECTO A IGV:</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-dot-circle-o"></i>
                                        </div>
                                        <input class="form-control" id="modal1-conigv" name="modal1-codigo" type="text" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-12">
                                <label for="modal1-descripcion">DESCRIPCION:</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                        <input class="form-control" id="modal1-descripcion" name="modal1-descripcion" type="text" disabled/>
                                    </div><!-- /.input group -->
                                </div>
                            </div>
                            <div class="form-group control-group col-sm-6">
                                <label for="modal1-precio">PRECIO:</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <span class="input-group-addon"><b>S/</b></span>
                                        <input class="form-control" id="modal1-precio" name="modal1-precio" type="text" disabled/>
                                    </div><!-- /.input group -->
                                </div>
                            </div>
                            <div class="form-group control-group col-sm-6">
                                <label for="modal1-cantidad">CANTIDAD:</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <input class="form-control" id="modal1-cantidad" name="modal1-cantidad" type="text" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group control-group col-sm-12" style="display:none;">
                                <label for="modal1-cantidad">OBSERVACION:</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <input class="form-control" id="modal1-observacion" style='text-transform:uppercase;' type="hidden" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal1-ok" onclick="okModal1();">Aceptar</button>
                    <button type="button" class="btn btn-warning" id="modal1-reset" onclick="resetModal1();">Limpiar</button>
                    <button type="button" class="btn btn-danger" id="modal1-close" data-dismiss="modal" onclick="closeModal1()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // ============ FUNCIONES DEL MODAL ===============
        var counter = 0;
        var modal_action = "anadir";
        var dato = [ 
                        <?php foreach ($conceptos as $concepto) {
                                echo "['".$concepto["FACCONDES"]."' , '".$concepto["FACCONCOD"]."' , '".$concepto["FACIGVCOB"]."' , '".$concepto["GRATUITO"]."' , '".$concepto["EXONERADO"]."' , '".$concepto["INAFECTO"]."'],";//"', true, ".$c."],";
                                }
                        ?>
                    ];

        $('#modal1-cantidad').inputmask('integer');
        $('#modal1-precio').inputmask('currency', {
            prefix: "",
            groupSeparator: "",
            allowPlus: false,
            allowMinus: false,
        });

        function abrirModalAnadir(){
            modal_action="anadir";
            $("#modal1-label").text("AGREGAR CONCEPTO DE PAGO");
            $("#bscdesc").attr("disabled", false);
            $("#modal1-reset").attr("style","display: inline;");
            $("#bscdesc").focus();
        }

        function abrirModalEditar(id_fila){
            modal_action="editar";

            $("#modal1-label").text("EDITAR CONCEPTO DE PAGO");
            $("#modal1-reset").attr("style","display: none;");

            var codigo = $(id_fila.cells[0]).html();
            var descripcion = $(id_fila).attr('descripcion');
            var precio = $(id_fila.cells[2]).html();
            var cantidad = $(id_fila.cells[3]).html();
            var observacion  = $(id_fila).attr('observacion');
            $("#modal1-conigv").val($(id_fila).attr('conigv'));
            $("#modal1-codigo").val(codigo);
            $("#modal1-descripcion").val(descripcion);
            $("#modal1-precio").val(precio);
            $("#modal1-cantidad").val(cantidad);
            $("#modal1-precio").attr("disabled", false);
            $("#modal1-cantidad").attr("disabled", false);
            $("#modal1-observacion").attr('disabled', false);
            $("#modal1-observacion").val(observacion);
        }

        function closeModal1(){
            $("#modal1-codigo").attr("disabled", true);
            $("#modal1-descripcion").attr("disabled", true);
            $("#bscdesc").attr("disabled", true);
            $("#modal1-precio").attr("disabled", true);
            $("#modal1-cantidad").attr("disabled", true);

            $("#bscdesc").val("");
            $("#modal1-codigo").val("");
            $("#modal1-descripcion").val("");
            $("#modal1-precio").val("");
            $("#modal1-cantidad").val("");
            $("#modal1-conigv").val('');
            $("#mensaje-modal").empty();
            $("#modal1-observacion").attr('disabled', true);
            $('#modal1-observacion').val('')
        }

        function okModal1(){
            $("#mensaje-modal").empty();
            var codigo =  $("#modal1-codigo").val();
            var descripcion = $("#modal1-descripcion").val();
            var observacion = $("#modal1-observacion").val().toUpperCase();
            var precio = parseFloat($("#modal1-precio").val());
            var cantidad = parseInt($("#modal1-cantidad").val());
            //alert(!Number.isInteger($("#modal1-cantidad").val()));
            var correcto1 = validar_campo(/[1-9][0-9]*/, $("#modal1-cantidad").val()) ;
            //alert( Number.isInteger($("#modal1-cantidad").val()) );
            //var correcto2 = validar_campo(/([1-9][0-9]*)|([0-9]+\.[0-9]{2})/, $("#modal1-precio").val());
            if(descripcion=="" || codigo=="" || isNaN(precio) || !correcto1 || precio <= 0 || cantidad <= 0 ){
                show_swal('warning', 'No se puede añadir este concepto', 'Asegurese de completar todos los campos', false, true, true);
                return false;
            }

            if(modal_action=="anadir"){
                var table = $("#detalle").find("tbody");
                var afecigv = $("#modal1-conigv").val();
                var text = '';
                var importe = ($("#modal1-conigv").attr('gratuito') == '1')? (0*0).toFixed(2):(precio*cantidad).toFixed(2);
                /*if(afecigv=='GRATUITO'){
                    text = '<span class="label label-success">'+afecigv+'</span>';
                }else if(afecigv=='EXONERADO'){
                    text = '<span class="label label-info">Info</span>';
                }else if(afecigv=='GRAVADO' || afecigv=='INAFECTO'){
                    text = '<span class="label label-primary">'+afecigv+'</span>';
                }else{
                    text = '<span class="label label-danger">ERROR</span>';
                }*/
                text = '<span class="label label-primary">'+afecigv+'</span>';

                table.append($('<tr>').attr('id', 'f'+codigo)
                                      .attr('codigo', codigo)
                                      .attr('descripcion', descripcion)
                                      .attr('observacion', observacion)
                                      .attr('conigv', afecigv) 
                                      .attr('conigv2', $("#modal1-conigv").attr('conigv')) 
                                      .attr('gratuito', $("#modal1-conigv").attr('gratuito'))
                                      .attr('exonerado', $("#modal1-conigv").attr('exonerado'))
                                      .append(
                        $('<td>').append(codigo).attr('style','text-align:center;'),
                        $('<td>').append(descripcion+((observacion=='')? '':(' -- '+observacion)) ),
                        $('<td>').append(precio.toFixed(2)).attr('style','text-align:right;'),
                        $('<td>').append(cantidad).attr('style','text-align:right;'),
                        $('<td>').attr('id', 'subTot').append(importe).attr('style','text-align:right;'),
                        $('<td>').append(
                            "<div class='btn-group btn-group-xs'>"+
                                "<a class='btn btn-default btn-flat btn-group-sm' data-placement='bottom' title='Editar' type='button'" + 
                                "data-toggle='modal' data-target='#modal1' " +
                                "onclick='abrirModalEditar(f"+ codigo +");' >"+
                                    "<i class='fa fa-pencil'></i> " +
                                "</a>" + 
                                "<a class='btn btn-default btn-flat' data-toggle='tooltip' data-placement='bottom' title='Quitar' type='button'"+
                                "onclick='$(f"+ codigo +").remove(); obtener_subTotal();'>" +
                                    "<i class='fa fa-remove'></i> " +
                                "</a><br>"+
                                "<p id='tipo_concepto'>"+text+"</p>"+
                            "</div>"
                        ).attr('style','text-align:center;')
                ));
                //alert(suma);
                closeModal1();
                abrirModalAnadir();
            }else{
                var fila = $('#f'+codigo);
                //alert(fila.cells[0]);
                $(fila).children('td')[0].innerHTML = codigo;
                $(fila).children('td')[1].innerHTML = descripcion+((observacion=='')? '':(' -- '+observacion));
                $(fila).children('td')[2].innerHTML = precio.toFixed(2);
                $(fila).children('td')[3].innerHTML = cantidad;
                $(fila).children('td')[4].innerHTML = (precio * cantidad).toFixed(2);
                $(fila).attr('observacion', observacion);
                $('#modal1').modal('toggle');
                closeModal1();
            }
            obtener_subTotal();
            $("#modal1-conigv").val('');
            return true;
        }

        function resetModal1() {
            $("#bscdesc").val("");
            $("#modal1-conigv").val("");
            $("#modal1-codigo").val("");
            $("#modal1-descripcion").val("");
            $("#modal1-precio").val("");
            $("#modal1-cantidad").val("");
            $("#modal1-conigv").val('');
            $("#bscdesc").attr("disabled", false);
            $("#modal1-precio").attr("disabled", true);
            $("#modal1-cantidad").attr("disabled", true);
            $("#mensaje-modal").empty();
            $("#modal1-observacion").attr('disabled', true);
        }

        function Autocompletado(){
            $('#bscdesc').autoComplete({
                //selector: 'input[name=&quot;q&quot;]',
                minChars: 2,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    var suggestions = [];
                    for (i=0; i<dato.length; i++)
                            if (~(dato[i][1]+' - '+dato[i][0]).toLowerCase().indexOf(term.toLowerCase())) 
                                suggestions.push(dato[i]);
                    suggest(suggestions);
                },
                renderItem: function (item, search){
                    search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                    return '<div class="autocomplete-suggestion" conigv="'+item[2]+'"" gratuito="'+item[3]+'"" exonerado="'+item[4]+'"" inafecto="'+item[5] +'"" descripcion="'+item[0]+'" codigo="'+item[1]+'" data-val="'+item[0]+'"> ' + item[1] +' - '+ item[0].replace(re, "<b>$1</b>")+'</div>';
                },
                onSelect: function(e, term, item){
                    //alert('Item "'+item[0].getAttribute('descripcion'));
                    var repetido = false;
                    var codigo = item[0].getAttribute('codigo');

                    for(i=0; i<$("#detalle tbody tr").length; i++){
                        
                        $('#detalle tbody tr').eq(i).each(function () {
                            if(codigo == $(this).attr('codigo')){
                                repetido = (repetido || codigo == $(this).attr('codigo'));
                            }
                        });
                    }
                    if(repetido){
                        show_swal('warning', 'Este concepto ya ha sido agregado', 'Intente con otro concepto o edite la informacion del concepto añadido', false, true, true);
                    }else{
                        var codigo = item[0].getAttribute('codigo');
                        var descripcion = item[0].getAttribute('descripcion');
                        var afec_igv = '';
                        var conigv = item[0].getAttribute('conigv');
                        var gratuito = item[0].getAttribute('gratuito');
                        var exonerado = item[0].getAttribute('exonerado');        
                        var inafecto = item[0].getAttribute('inafecto');
                        conigv = (conigv==null || conigv=='')? 'S':conigv;
                        gratuito = (gratuito==null || gratuito=='')? '0':gratuito;
                        exonerado = (exonerado==null || exonerado=='')? '0':exonerado;
                        inafecto = (inafecto==null || inafecto=='')? '0':inafecto;
                        if(exonerado == '1'){
                            afec_igv = 'EXONERADO';
                        }else if(conigv == 'S'){
                            afec_igv = 'GRAVADO';
                        }else if(conigv == 'N'){
                            afec_igv = 'INAFECTO';
                        }

                        if(gratuito == '1'){
                            afec_igv = afec_igv+' - GRATUITO';
                        }

                        $("#modal1-conigv").val(afec_igv);
                        $("#modal1-conigv").attr('conigv', conigv)
                                           .attr('gratuito', gratuito)
                                           .attr('exonerado', exonerado)
                                           .attr('inafecto', inafecto); 
                        $("#modal1-codigo").val(codigo);
                        $("#modal1-descripcion").val(descripcion);
                        $("#bscdesc").val('');

                        $("#bscdesc").attr('disabled', true);
                        $("#modal1-precio").attr('disabled', false);
                        $("#modal1-cantidad").attr('disabled', false);
                        $("#modal1-observacion").attr('disabled', false);
                    }
                }
            });
        }

        $(function(){

            Autocompletado();
            $("#Form-gratuito").on("click", function(){
                
                if($("#Form-gratuito").is(':checked')) {
                    $("#afecta_igv").show(); 
                    dato = [ 
                        <?php foreach ($conceptos as $concepto) {
                                if($concepto["GRATUITO"]==1){
                                    echo "['".$concepto["FACCONDES"]."' , '".$concepto["FACCONCOD"]."' , '".$concepto["FACIGVCOB"]."' , '".$concepto["GRATUITO"]."' , '".$concepto["EXONERADO"]."' , '".$concepto["INAFECTO"]."'],";//"', true, ".$c."],";
                                }
                                
                                }
                        ?>
                    ];
                    Autocompletado();
                 }
                else{
                    $("#afecta_igv").hide();
                    var select = $('#Tip_afectacion_igv');
                    select.val($('option:first', select).val());
                    dato = [ 
                        <?php foreach ($conceptos as $concepto) {
                                    if($concepto["GRATUITO"] != 1){
                                        echo "['".$concepto["FACCONDES"]."' , '".$concepto["FACCONCOD"]."' , '".$concepto["FACIGVCOB"]."' , '".$concepto["GRATUITO"]."' , '".$concepto["EXONERADO"]."' , '".$concepto["INAFECTO"]."'],";//"', true, ".$c."],";
                                    }
                                }
                        ?>
                    ];
                    Autocompletado();
                }
            });


            
        });
    // ================================================
</script>