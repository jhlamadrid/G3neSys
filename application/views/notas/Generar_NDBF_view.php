<script src='<?php echo base_url()?>frontend/dist/js/jquery.number.min.js'></script>
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
                                    <!-- /btn-group -->
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
                                <!-- /btn-group -->
                                <input type="text" class="form-control" id='user-nombre' value="<?php echo $factura['FSCCLINOMB'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-3" style="margin-top:10px">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger" style="width:100px">SERIE</button>
                                </div>
                                <!-- /btn-group -->
                                <input type="text" class="form-control" id="user-serie" value="<?php echo $factura['FSCSERNRO'] ?>" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                       <div class='col-md-3'  style="margin-top:10px">
                          <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-danger" style="width:100px">MONTO TOTAL</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" value="<?php echo number_format($factura['FSCTOTAL'],2,'.','') ?>" disabled>
                            </div>
                        </div>
                        <div class='col-md-6'  style="margin-top:10px">
                          <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-danger" style="width:100px">DIRECCIÓN</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" id='direccion_user' value="<?php echo $factura['FSDIREC'] ?>" disabled>
                            </div>
                        </div>
                        <div class='col-md-3'  style="margin-top:10px">
                          <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-danger" style="width:100px">NÚMERO</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" id="user-numero" value="<?php echo $factura['FSCNRO'] ?>" disabled>
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
                      <div class="col-md-1"></div>
                       <div class="col-md-10">
                          <label class="title">Ingrese el motivo de la Nota de Dédito</label>
                           <textarea class="form-control" rows="3" id='motivo_nota'></textarea>
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
                  <label for="" class="title">Lista de Item</label>
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
                                   <th>MONTO</th>
                                   <th>SUBTOTAL</th>
                                   <!--<th>TOTAL (CON IGV)</th>-->
                               </tr>
                           </thead>
                           <tbody>
                               <?php $i = 1;foreach($factura_detalle as $detalle){ ?>
                                   <tr>
                                       <td><?php echo $i; ?></td>
                                       <td id='numero_concep_<?php echo $i; ?>'><?php echo $detalle['FACCONCOD'] ?></td>
                                       <td><?php echo $detalle['FACCONDES'] ?></td>
                                       <td id='monto_fac<?php echo $i;?>'><?php echo number_format(floatval($detalle['FSCPRECIO']),2,'.','') ?></td>
                                       <?php if($detalle['GRAT'] != 1) {?>
                                       <td style="text-align:center"><input class='money' afectoigv<?php echo $i; ?> = '<?php echo $detalle['AFECIGV']; ?>' id='descuento<?php echo $i ?>' type="text" style="text-align:right" onkeyup="validar_monto(<?php echo  $detalle['FSCPRECIO'] ?>,this,'<?php echo $i; ?>','<?php echo $detalle['FACIGVCOB'] ?>',event)"><br><span id='error<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                                       <?php } else { ?>
                                           <td style="text-align:center"><input class='money' id='descuento<?php echo $i ?>' type="text" style="text-align:right" disabled><br><span id='error<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                                       <?php } ?>
                                       <td><input type="number" id='subtotal<?php echo $i ?>' style="text-align:right" value=<?php echo  number_format(floatval($detalle['FSCPRECIO']),2,'.','') ?> disabled></td>
                                       <!--<td><input type="number" id='total<?php #echo $i ?>' style="text-align:right" readonly></td>-->
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
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <label for="" class="title">
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
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <label for="" class="title">
                        NOTA CRÉDITO
                        <?php echo " "."100-001"; ?>
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
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button class="btn btn-success btn-block" onclick="guardar()"><i class="fa fa-floppy-o" aria-hidden="true"></i>
GUARDAR</button>
        </div>
    </div>
</section>
<script>
    $('.money').number( true, 2 );
    guardar = function(){
        if($( "#factura_total" ).text() == $( "#nc_total" ).text() || $( "#motivo_nota" ).val().trim() == ""){
            swal("Algo va mal ...", "Debe ingresar alguna cantidad para poder crear la Nota de Débito y el Motivo por la cual lo está creando", "warning")
        } else{
            documento = { "subtotal" : $( "#factura_subtotal" ).text() ,
                          "IGV" : $( "#factura_igv" ).text(),
                          "TOTAL" : $( "#factura_total" ).text() }
            documento1 = { "subtotal" : $( "#nc_subtotal").text(),
                           "IGV" : $( "#nc_igv" ).text(),
                           "TOTAL" : $( "#nc_total").text() }
            conceptos = <?php echo json_encode($factura_detalle); ?>;
            //console.log(conceptos)
            datos_usuario = {"usuario":$( "#user-nombre" ).val(),
                             "serie" : $( "#user-serie" ).val(),
                             "numero" : $( "#user-numero" ).val()}
            nota_debito = []
            total_conceptos = <?php echo sizeof($factura_detalle); ?>;
            for(var i = 0; i < total_conceptos;i++){

                nota_debito.push({"descuento":  (isNaN(parseFloat($( "#descuento"+(i+1) ).val())) ? 0 : parseFloat($( "#descuento"+(i+1) ).val())),
                                   "interes": (($("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10") ? (isNaN((parseFloat($( "#descuento"+(i+1) ).val()) * igvBase).toFixed(2)) ? 0 : (parseFloat($( "#descuento"+(i+1) ).val()) * igvBase).toFixed(2) ) : 0),
                                   "subtotal": $( "#subtotal"+(i+1) ).val()})
            }
            console.log(conceptos)
            motivo = $( "#motivo_nota" ).val();
            nombre = $( "#user-nombre" ).val();
            direccion = $( "#direccion_user" ).val();
            tipo = $( "#tipo_user" ).val()
            console.log(nota_debito);
            swal({
              title: "",
              text: "¿Quién autorizó la Nota Débito?",
              type: "input",
              showCancelButton: true,
              closeOnConfirm: false,
              animation: "slide-from-top",
              inputPlaceholder: "Write something"
            },
            function(inputValue){
              if (inputValue === false) return false;

              if (inputValue === "") {
                swal.showInputError("Necesita ingresar la persona que lo autorizó");
                return false
              }
              if(inputValue != ""){
                  swal({   title: "¿Está seguro de generar la Nota Débito?",
                         text: "La nota de Débito se descontara del monto total del Recibo",
                         type: "warning",
                         showCancelButton: true,
                         confirmButtonColor: "#296fb7",
                         confirmButtonText: "¡Sí!, Estoy seguro",
                         closeOnConfirm: false
                     }, function(){
                      $(".sweet-overlay").css('display','none')
                      $(".sweet-alert").css('display','none')
                      waitingDialog.show();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url();?>notas/generar_notaD_fb?ajax=true",
                            data: "documento="+JSON.stringify(documento)+"&documento1="+JSON.stringify(documento1)+"&conceptos="+JSON.stringify(conceptos)+"&datos_usuario="+JSON.stringify(datos_usuario)+"&nota_debito="+JSON.stringify(nota_debito)+"&nombre="+nombre+"&direccion="+direccion+"&tipo="+tipo+"&motivo="+motivo,
                            dataType: 'json',
                            success: function(data)
                            {
                                console.log(data)
                                if(data.result === true){
                                    waitingDialog.hide();
                                    var myWindow = window.open("<?php echo base_url(); ?>"+data.data, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
                                    myWindow.focus();
                                    myWindow.print();
                                    window.location.href = "<?php echo base_url().'notas/notas_debito'; ?>"
                                } else {
                                    waitingDialog.hide();
                                    swal("Ocurrio un error!",data.mensaje , "error")
                                }
                            }
                        })


                    });
                }
            });




        }

    }
    validar_monto = function(monto,valor,indice,igv,event){
        if((event.which >= 48 && event.which <= 57 ) || (event.which >= 97 && event.which <= 105) ){
                $( "#subtotal"+indice ).val((parseFloat(monto)+parseFloat(valor.value)).toFixed(2))
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento"+(i) ).val())) ? 0 : parseFloat($( "#descuento"+(i) ).val()));
                    if( $("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10"){
                        igv += (isNaN(parseFloat($( "#descuento"+(i) ).val())) ? 0 : parseFloat($( "#descuento"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#nc_subtotal" ).html(subtotal.toFixed(2))
                $( "#nc_igv" ).html(igv.toFixed(2))
                $( "#nc_total" ).html((subtotal + igv).toFixed(2))
        } else if(event.which == 40 || event.which == 38 || event.which == 37 || event.which == 39){

        } else {
            if(valor.value==""){
                $( "#subtotal"+indice ).val(parseFloat($( "#monto_fac"+indice ).text()).toFixed(2))
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento"+(i) ).val())) ? 0 : parseFloat($( "#descuento"+(i) ).val()));
                    if( $("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10"){
                        igv += (isNaN(parseFloat($( "#descuento"+(i) ).val())) ? 0 : parseFloat($( "#descuento"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#nc_subtotal" ).html(subtotal.toFixed(2))
                $( "#nc_igv").html(igv.toFixed(2))
                $( "#nc_total" ).html((subtotal + igv).toFixed(2))
            } else{
                $( "#subtotal"+indice ).val((parseFloat(monto)-parseFloat(valor.value)).toFixed(2))
                total_conceptos = <?php echo sizeof($factura_detalle); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento"+(i) ).val())) ? 0 : parseFloat($( "#descuento"+(i) ).val()));
                    if( $("#descuento"+(i+1)).attr("afectoigv"+(i+1)) == "10"){
                        igv += (isNaN(parseFloat($( "#descuento"+(i) ).val())) ? 0 : parseFloat($( "#descuento"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#nc_subtotal" ).html(subtotal.toFixed(2))
                $( "#nc_igv").html(igv.toFixed(2))
                $( "#nc_total" ).html((subtotal + igv).toFixed(2))
            }
        }

    }

     var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	// Creating modal dialog's DOM
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content">' +
			'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
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
				message = 'Generando Nota de Débito';
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
</script>
