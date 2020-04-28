 <script src='<?php echo $this->config->item('ip'); ?>frontend/dist/js/jquery.number.min.js'></script>
<script>
    var igvBase = <?php echo $igv; ?>;
    igvBase = (parseInt(igvBase)/100).toFixed(2)
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <div class="row">
            <div class='col-md-3' style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">DOCUMENTO</button>
                </div>
                <?php if($factura['FSCTIPO'] == 1) {?>
                <input type="text" class="form-control" id='tipo_user' value="FACTURA" disabled>
                <?php } else { ?>
                <input type="text" class="form-control" id='tipo_user' value="BOLETA" disabled>
                <?php } ?>
              </div>
            </div>
            <div class="col-md-6" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">NOMBRE</button>
                </div>
                <input type="text" class="form-control" id='user-nombre' value="<?php echo $factura['FSCCLINOMB'] ?>" disabled>
              </div>
            </div>
            <div class="col-md-3" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">SERIE</button>
                </div>
                <input type="text" class="form-control" id="user-serie" value="<?php echo $factura['FSCSERNRO']; ?>" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class='col-md-3'  style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">MONTO TOTAL</button>
                </div>
                <input type="text" class="form-control" value="<?php echo number_format($factura['FSCTOTAL'],2,'.','') ?>" disabled>
              </div>
            </div>
            <div class='col-md-6'  style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">DIRECCIÓN</button>
                </div>
                <input type="text" class="form-control" id='direccion_user' value="<?php echo $factura['FSDIREC'] ?>" disabled>
              </div>
            </div>
            <div class='col-md-3'  style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" style="width:100px">NÚMERO</button>
                </div>
                <input type="text" class="form-control" id="user-numero" value="<?php echo $factura['FSCNRO']; ?>" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3" style="margin-top:10px">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" name="button" style="width:100px">SUNAT</button>
                </div>
                <input type="text" class="form-control" name="" value="<?php echo $factura['SUNSERNRO']."-".$factura['SUNFACNRO']; ?>" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <label class="title">MOTIVO DE LA NOTA DE CRÉDITO</label>
              <textarea class="form-control" rows="3" id='motivo_nota'></textarea>
            </div>
             <div class='col-md-6'>
               <div class="form-group">
                 <label class="title">TIPO DE NOTA DE CRÉDITO</label>
                 <select id='tipo_nc' onchange="cambiar_tiponc()" class="form-control">
                    <?php if($factura['FSCTIPO'] == 1){ ?>
                         <option value="00">SELECCIONE UNA OPCIÓN</option>
                          <?php foreach ($tipo_nc as $nc) {?>
                             <option value="<?php echo $nc['CODIGO'] ?>"><?php echo $nc['DESCRIPCIO'] ?></option>
                         <?php }  ?>
                     <?php  } else { ?>
                     <option value="00">SELECCIONE UNA OPCIÓN</option>
                     <?php foreach($tipo_nc as $nc) {?>

                         <?php if($nc['CODIGO'] == '04' || $nc['CODIGO'] == '05'  || $nc['CODIGO'] == '08') {?>

                         <?php } else {?>
                             <option value="<?php echo $nc['CODIGO'] ?>"><?php echo $nc['DESCRIPCIO'] ?></option>
                         <?php } ?>
                     <?php } } ?>
                 </select>
               </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class='row'>
    <div class='col-md-12'>
      <div class="box box-success">
        <div class="box-header">
          <label class="title">CONCEPTOS</label>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id='item-doc' class='table table-bordered table-striped'>
              <thead>
                <tr role='row'>
                  <th>ITEM</th>
                  <th>Nº</th>
                  <th>CONCEPTO</th>
                  <th>IMPORTE</th>
                  <th>DESCUENTO</th>
                  <th>SUBTOTAL</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1;foreach($factura_detalle as $detalle){ ?>
                   <tr>
                     <td><?php echo $i; ?></td>
                     <td id='numero_concep_<?php echo $i; ?>'><?php echo $detalle['FACCONCOD'] ?></td>
                     <td><?php echo $detalle['FACCONDES'] ?></td>
                     <td id='monto_fac<?php echo $i;?>'><?php echo number_format(floatval($detalle['FSCPRECIO']),2,'.','') ?></td>
                     <?php if($detalle['GRATUITO'] != 1) {?>
                     <td style="text-align:center">
                       <input class='money' afectoigv<?php echo $i; ?> = '<?php echo $detalle['AFECIGV']; ?>' id='descuento<?php echo $i ?>' type="text" style="text-align:right" onkeyup="validar_monto(<?php echo  $detalle['FSCPRECIO'] ?>,this,'<?php echo $i; ?>','<?php echo $detalle['FACIGVCOB'] ?>',event)" <?php echo (floatval($detalle['FSCPRECIO']) <= 0) ? 'disabled' : '' ?>>
                       <br><span id='error<?php echo $i ?>' style='display:none;color:#f00'>Error</span>
                     </td>
                     <?php } else { ?>
                         <td style="text-align:center"><input class='money' id='descuento<?php echo $i ?>' type="text" style="text-align:right" disabled><br><span id='error<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                     <?php } ?>
                     <td style="text-align:center"><input type="number" id='subtotal<?php echo $i ?>' style="text-align:right" value=<?php echo  number_format(floatval($detalle['FSCPRECIO']),2,'.','') ?> disabled></td>
                   </tr>
                 <?php $i++; } ?>
               </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="box box-success">
        <div class="box-header">
          <label class="title">
              <?php if($factura['FSCTIPO'] == 1) { echo "FACTURA";
                     } else { echo "BOLETA"; } ?>
              <?php echo " ".$factura['FSCSERNRO']." - ".$factura['FSCNRO']; ?>
          </label>
        </div>
        <div class='box-body'>
          <div class="table-responsive">
            <table id='factura' class="table table-bordered table-striped">
              <tbody>
                <?php if($factura['FSCTIPO'] == 1) { ?>
                <tr>
                  <td>SUBTOTAL</td>
                  <td style='text-align:right' id="factura_subtotal"> <?php $subtotal = 0; foreach($factura_detalle as $detalle){ $subtotal += floatval($detalle['FSCPRECIO']); } echo number_format($subtotal,2,'.',''); ?></td>
                </tr>
                <tr>
                  <td>IGV</td>
                  <td style='text-align:right' id="factura_igv"><?php $IGV = 0; foreach($factura_detalle as $detalle){ $IGV += floatval($detalle['PRECIGV']); } echo number_format($IGV,2,'.',''); ?></td>
                </tr>
                <?php } else {?>
                <tr style="display:none">
                  <td>SUBTOTAL</td>
                  <td style='text-align:right' id="factura_subtotal"> <?php $subtotal = 0; foreach($factura_detalle as $detalle){ $subtotal += floatval($detalle['FSCPRECIO']); } echo number_format($subtotal,2,'.',''); ?></td>
                </tr>
                <tr style="display:none">
                  <td>IGV</td>
                  <td style='text-align:right' id="factura_igv"><?php $IGV = 0; foreach($factura_detalle as $detalle){ $IGV += floatval($detalle['PRECIGV']); } echo number_format($IGV,2,'.',''); ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td>TOTAL</td>
                  <td style='text-align:right' id='factura_total'><?php echo number_format(($IGV + $subtotal),2,'.','')?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-success">
        <div class="box-header">
          <label class="title">
            NOTA CRÉDITO
            <?php echo " "."***-****"; ?>
          </label>
        </div>
        <div class='box-body'>
          <div class="table-responsive">
            <table id='nota-credito' class="table table-bordered table-striped">
              <tbody>
                <?php if($factura['FSCTIPO'] == 1) { ?>
                  <tr>
                    <td>SUBTOTAL</td>
                    <td id='nc_subtotal' style='text-align:right'>0.00</td>
                  </tr>
                  <tr>
                    <td>IGV</td>
                    <td id='nc_igv' style='text-align:right'>0.00</td>
                  </tr>
                <?php } else {?>
                  <tr style="display:none">
                    <td>SUBTOTAL</td>
                    <td id='nc_subtotal' style='text-align:right'>0.00</td>
                  </tr>
                  <tr style="display:none">
                    <td>IGV</td>
                    <td id='nc_igv' style='text-align:right'>0.00</td>
                  </tr>
                <?php } ?>
                <tr>
                  <td>TOTAL</td>
                  <td id='nc_total' style='text-align:right'>0.00</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-success">
        <div class="box-header">
          <label class="title">
            MONTO RESULTANTE
          </label>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id='resultado' class="table table-bordered table-striped">
              <tbody>
                <?php if($factura['FSCTIPO'] == 1) { ?>
                  <tr>
                    <td>SUBTOTAL</td>
                    <td id='resultado_subtotal' style='text-align:right'><?php $subtotal = 0; foreach($factura_detalle as $detalle){ $subtotal += floatval($detalle['FSCPRECIO']); } echo number_format($subtotal,2,'.',''); ?></td>
                  </tr>
                  <tr>
                    <td>IGV</td>
                    <td style='text-align:right' id="resultado_igv"><?php $IGV = 0; foreach($factura_detalle as $detalle){ $IGV += floatval($detalle['PRECIGV']); } echo number_format($IGV,2,'.',''); ?></td>
                  </tr>
                <?php } else {?>
                  <tr style="display:none">
                    <td>SUBTOTAL</td>
                    <td style='text-align:right' id="resultado_subtotal"> <?php $subtotal = 0; foreach($factura_detalle as $detalle){ $subtotal += floatval($detalle['FSCPRECIO']); } echo number_format($subtotal,2,'.',''); ?></td>
                  </tr>
                  <tr style="display:none">
                    <td>IGV</td>
                    <td style='text-align:right' id="resultado_igv"><?php $IGV = 0; foreach($factura_detalle as $detalle){ $IGV += floatval($detalle['PRECIGV']); } echo number_format($IGV,2,'.',''); ?></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td>TOTAL</td>
                  <td style='text-align:right' id='resultado_total'><?php echo number_format(($IGV + $subtotal),2,'.','')?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <button class="btn btn-success btn-block" id='btn_enviar' onclick="guardar()"><i class="fa fa-spinner" aria-hidden="true"></i> EMITIR NOTA CRÉDITO</button>
    </div>
  </div>
</section>
<script>
    $('.money').number( true, 2 );
    guardar = function(){
        var seleccionado = $( "select#tipo_nc option:selected").val()
        if($( "#nc_total" ).text() == "0.00"  || $( "#motivo_nota" ).val().trim() == "" || seleccionado == "00"){
          if($( "#motivo_nota" ).val().trim() == "" ){
            swal("","DEBE COLOCA EL MÓTIVO POR EL CUAL SE ESTA REALIZANDO LA NOTA DE CRÉDITO","warning");
          } else if(seleccionado == "00"){
            swal("","DEBE SELECCIONAR EL TIPO DE NOTA DE CRÉDITO QUE VA GENERAR","warning")
          } else {
            swal("","DEBE REALIZAR LOS DESCUENTOS PARA GENERAR LA NOTA DE CRÉDITO","warning")
          }
        } else{
            documento = { "subtotal" : $( "#factura_subtotal" ).text() ,
                          "IGV" : $( "#factura_igv" ).text(),
                          "TOTAL" : $( "#factura_total" ).text() }
            documento1 = { "subtotal" : $( "#nc_subtotal").text(),
                           "IGV" : $( "#nc_igv" ).text(),
                           "TOTAL" : $( "#nc_total").text() }
            conceptos = <?php echo json_encode($factura_detalle); ?>;

            datos_usuario = {"usuario":$( "#user-nombre" ).val(),
                             "serie" : $( "#user-serie" ).val(),
                             "numero" : $( "#user-numero" ).val()}
            nota_credito = []
            total_conceptos = <?php echo sizeof($factura_detalle); ?>;
            for(var i = 0; i < total_conceptos;i++){
                var valor22 = (($("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10") ? (parseFloat($( "#descuento"+(i+1) ).val()) * igvBase).toFixed(2) : 0);


                nota_credito.push({"descuento": (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val())),
                                   "interes": (isNaN(valor22) ? 0 : parseFloat(valor22)),
                                   "subtotal": isNaN($( "#subtotal"+(i+1) ).val()) ? 0 : parseFloat($( "#subtotal"+(i+1) ).val()),
                                    "afectado" : $("#descuento"+(i+1)).attr("afectoigv"+(i+1))
                                  })
            }
            var seleccionado = $( "select#tipo_nc option:selected").val()
            motivo = $( "#motivo_nota" ).val();
            nombre = $( "#user-nombre" ).val();
            direccion = $( "#direccion_user" ).val();
            console.log(conceptos)
            tipo = $( "#tipo_user" ).val();
            swal({   title: "¿Está seguro de generar la Nota Crédito?",
                   text: "La nota de Crédito se descontara del monto total del Recibo",
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonColor: "#296fb7",
                   confirmButtonText: "¡Sí!, Estoy seguro",
                   closeOnConfirm: false
               }, function(){
                $(".sweet-overlay").css('display','none')
                $(".sweet-alert").css('display','none')
                waitingDialog.show('EMITIENDO NOTA CRÉDITO...', {dialogSize: 'lg', progressType: 'warning'});
                  $.ajax({
                      type: "POST",
                      url: "<?php echo $this->config->item('ip') ?>notas/generar_nota_fb?ajax=true",
                      data: "documento="+JSON.stringify(documento)+"&documento1="+JSON.stringify(documento1)+"&conceptos="+JSON.stringify(conceptos)+"&datos_usuario="+JSON.stringify(datos_usuario)+"&nota_credito="+JSON.stringify(nota_credito)+"&nombre="+nombre+"&direccion="+direccion+"&tipo="+tipo+"&motivo="+motivo+"&seleccionado="+seleccionado,
                      dataType: 'json',
                      success: function(data)
                      {
                          console.log(data)
                          if(data.result === true){
                              enviar_sunat(data.sunat,data.guardado);
                          } else {
                            waitingDialog.hide();
                            if(data.tipo){
                              $("#btn_enviar").attr('onclick',"")
                              swal("Ocurrio un error!",data.mensaje , "error")
                              setTimeout(function(){
                                window.location.href = "<<?php echo $this->config->item('ip').'notas/nota_credito'; ?>";
                              },800)
                            } else {
                              swal("Ocurrio un error!",data.mensaje , "error")
                            }
                          }
                      }, error : function(jqXHR,textStatus,errorThrown){
                        waitingDialog.hide();
                        console.log(jqXHR);
                        swal("ERROR","OCURRIO UN ERROR AL EMITIR LA NOTA DE CRÉDITO. NOTA DE CRÉDITO NO CREADA." , "error")
                        setTimeout(function(){
                          window.location.href = "<?php echo $this->config->item('ip').'notas/nota_credito'; ?>";
                        },800)
                        console.log(respt);
                        console.log("error: "+textStatus+errorThrown);
                      }
                  })
              });
        }
    }

    function enviar_sunat(sunat,guardado){
        waitingDialog.show('ENVIANDO A SUNAT LA  NOTA CRÉDITO...', {dialogSize: 'lg', progressType: 'warning'});
      $.ajax({
          type: "POST",
          url: "<?php echo $this->config->item('ip'); ?>notas/enviar_sunat?ajax=true",
          data: ({
            'sunat' :  sunat,
            'guardado' : guardado
          }),
          dataType: 'json',
          success: function(data){
            if(data.result == true){
              console.log(sunat);
                waitingDialog.hide();
                swal("",data.mensaje,"success");
                setTimeout(function(){  window.location.href = "<?php echo $this->config->item('ip').'notas/nota_credito'; ?>"; }, 2000);

            } else {
              waitingDialog.hide();
              swal("",data.mensaje,"warning");
            }
          }, error : function(jqHXR,textStatus,errorThrown){
            actualizar_estado_nota_credito(sunat,guardado);
          }
        })
    }

    function actualizar_estado_nota_credito(sunat,guardado){
      $.ajax({
          type: "POST",
          url: "<?php echo $this->config->item('ip'); ?>notas/actulizar_nota_credito?ajax=true",
          data: ({
            'sunat' :  sunat,
            'guardado' : guardado
          }),
          dataType: 'json',
          success: function(data){
            if(data.result ==  true){
              console.log(sunat);
                waitingDialog.hide();
                swal("",data.mensaje,"success")
                window.location.href = "<?php echo $this->config->item('ip').'notas/nota_credito'; ?>"
            } else {
              waitingDialog.hide();
              swal("",data.mensaje,"warning")
            }
          }, error : function(jqHXR,textStatus,errorThrown){
            waitingDialog.hide();
            swal("ERROR","NOTA DE CRÉDITO EMITIDA.\n OCURRIO UN ERROR AL ENVIAR  LA NOTA DE CRÉDITO." , "error")
            actualizar_estado_nota_credito(sunat,guardado);
          }
        })
    }

    function replaceAll( text, busca, reemplaza ){
      while (text.toString().indexOf(busca) != -1)
      text = text.toString().replace(busca,reemplaza);
      return text;
    }


    validar_monto = function(monto,valor,indice,igv,event){
        if((event.which >= 48 && event.which <= 57) || (event.which >= 96 && event.which <= 105) ){
          var str = valor.value;
          var valor_resultante = replaceAll(str,",", "");
          console.log(valor_resultante);
            if(monto<parseFloat(valor_resultante)){
                $("#error"+indice).css("display","inline").fadeOut(2000);
                $("#"+valor.id).val("")
                $( "#subtotal"+indice ).val(parseFloat($( "#monto_fac"+indice ).text()).toFixed(2))
            } else {
                $( "#subtotal"+indice ).val((parseFloat(monto)-parseFloat(valor_resultante)).toFixed(2))
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                subtotal = 0;
                igv = 0
                igv1 = 0
                subtotal1 = 0;
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val()));
                    if( $("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10"){
                        igv += (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val())) * igvBase
                        igv1 += (isNaN(parseFloat($( "#subtotal"+(i+1) ).val())) ? 0 : parseFloat($( "#subtotal"+(i+1) ).val())) * igvBase
                        //console.log(parseFloat($( "#subtotal"+(i+1) ).val()) * igvBase)
                    }
                    subtotal1 += (isNaN(parseFloat($( "#subtotal"+(i+1) ).val())) ? 0 : parseFloat($( "#subtotal"+(i+1) ).val()));
                    //console.log(igv.toFixed(2));
                }
                $( "#nc_subtotal" ).html(subtotal.toFixed(2))
                $( "#resultado_subtotal" ).html(subtotal1.toFixed(2))
                $( "#nc_igv" ).html(igv.toFixed(2))
                $( "#resultado_igv" ).html(igv1.toFixed(2))
                $( "#nc_total" ).html((subtotal + igv).toFixed(2))
                $( "#resultado_total" ).html((subtotal1 + igv1).toFixed(2))
            }
        } else if(event.which == 40 || event.which == 38 || event.which == 37 || event.which == 39){
        } else {
            if(valor.value==""){
                $( "#subtotal"+indice ).val(parseFloat($( "#monto_fac"+indice ).text()).toFixed(2))
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                subtotal = 0;
                subtotal1 = 0;
                igv = 0
                igv1 = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val()));
                    if( $("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10"){
                        igv += (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val())) * igvBase
                        igv1 += (isNaN(parseFloat($( "#subtotal"+(i+1) ).val())) ? 0 : parseFloat($( "#subtotal"+(i+1) ).val())) * igvBase
                    }
                    subtotal1 += (isNaN(parseFloat($( "#subtotal"+(i+1) ).val())) ? 0 : parseFloat($( "#subtotal"+(i+1) ).val()));
                    //console.log(igv.toFixed(2));
                }
                $( "#nc_subtotal" ).html(subtotal.toFixed(2))
                $( "#resultado_subtotal" ).html(subtotal1.toFixed(2))
                $( "#nc_igv").html(igv.toFixed(2))
                $( "#resultado_igv" ).html(igv1.toFixed(2))
                $( "#nc_total" ).html((subtotal + igv).toFixed(2))
                $( "#resultado_total" ).html((subtotal1 + igv1).toFixed(2))
            } else{
                $( "#subtotal"+indice ).val((parseFloat(monto)-parseFloat(valor.value)).toFixed(2))
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                subtotal = 0;
                subtotal1 = 0;
                igv = 0
                igv1 = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val()));
                    if( $("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10"){
                        igv += (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val())) * igvBase
                        igv1 += (isNaN(parseFloat($( "#subtotal"+(i+1) ).val())) ? 0 : parseFloat($( "#subtotal"+(i+1) ).val())) * igvBase
                    }
                    subtotal1 += (isNaN(parseFloat($( "#subtotal"+(i+1) ).val())) ? 0 : parseFloat($( "#subtotal"+(i+1) ).val()));
                    //console.log(igv.toFixed(2));
                }
                $( "#nc_subtotal" ).html(subtotal.toFixed(2))
                $( "#resultado_subtotal" ).html(subtotal1.toFixed(2))
                $( "#nc_igv").html(igv.toFixed(2))
                $( "#resultado_igv" ).html(igv1.toFixed(2))
                $( "#nc_total" ).html((subtotal + igv).toFixed(2))
                $( "#resultado_total" ).html((subtotal1 + igv1).toFixed(2))
            }
        }

    }
    var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	// Creating modal dialog's DOM
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content" style="border-radius:5px">' +
			'<div class="modal-header"><h3 style="margin:0;font-family:\'Ubuntu\'"></h3></div>' +
			'<div class="modal-body">' +
				'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
			'</div>' +
		'</div></div></div>');

	return {
		/**
		 * Opens our dialog
		 * @param message Custom message
		 * @param options Custom options:
		 * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
		 * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
		 */
		show: function (message, options) {
			// Assigning defaults
			if (typeof options === 'undefined') {
				options = {};
			}
			if (typeof message === 'undefined') {
				message = 'Generando la Nota de Crédito';
			}
			var settings = $.extend({
				dialogSize: 'm',
				progressType: '',
				onHide: null // This callback runs after the dialog was hidden
			}, options);

			// Configuring dialog
			$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
			$dialog.find('.progress-bar').attr('class', 'progress-bar');
			if (settings.progressType) {
				$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
			}
			$dialog.find('h3').text(message);
			// Adding callbacks
			if (typeof settings.onHide === 'function') {
				$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					settings.onHide.call($dialog);
				});
			}
			// Opening dialog
			$dialog.modal();
		},
		/**
		 * Closes dialog
		 */
		hide: function () {
			$dialog.modal('hide');
		}
	};

})(jQuery);

    cambiar_tiponc = function(){
        var seleccionado = $( "select#tipo_nc option:selected").val()

        switch(seleccionado){
            case "00": break;
            case "01":
            case "02":
            case "06":
            case "04":
            case "03": {
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                for(var i = 0; i < total_conceptos;i++){
                    $( "#descuento"+(i+1) ).val(parseFloat($( "#monto_fac"+(i+1) ).text()).toFixed(2));
                    $( "#subtotal"+(i+1) ).val("0.00")
                    $( "#descuento"+(i+1) ).prop('disabled',true)
                }
                $( "#nc_subtotal" ).html( parseFloat($( "#factura_subtotal" ).text()).toFixed(2) )
                $( "#nc_igv").html(parseFloat($( "#factura_igv" ).text()).toFixed(2))
                $( "#nc_total" ).html(parseFloat($( "#factura_total" ).text()).toFixed(2))
                $( "#resultado_subtotal" ).html("0.00")
                $( "#resultado_igv" ).html("0.00")
                $( "#resultado_total" ).html("0.00")
                break;
            }
            case "09":
            case "05":
            case "07": {
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                for(var i = 0; i < total_conceptos;i++){
                    $( "#descuento"+(i+1) ).val("")
                    $( "#subtotal"+(i+1) ).val(parseFloat($( "#monto_fac"+(i+1) ).text()).toFixed(2))
                    $( "#descuento"+(i+1) ).prop('disabled',false)
                }
                $( "#resultado_subtotal" ).html( parseFloat($( "#factura_subtotal" ).text()).toFixed(2) )
                $( "#resultado_igv" ).html(parseFloat($( "#factura_igv" ).text()).toFixed(2))
                $( "#resultado_total" ).html(parseFloat($( "#factura_total" ).text()).toFixed(2))
                $( "#nc_subtotal" ).html( "0.00")
                $( "#nc_igv").html("0.00")
                $( "#nc_total" ).html("0.00")
            }
        }
    }
</script>
