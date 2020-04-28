<script src='<?php echo $this->config->item('ip'); ?>frontend/dist/js/jquery.number.min.js'></script>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
               <div class="box-body">
                   <div class="row">
                       <div class='col-md-3' style="margin-top:10px">
                          <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-danger" style="width:100px">SUMINISTRO</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" value="<?php echo $user_datos['CLICODFAC'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-6" style="margin-top:10px">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger" style="width:100px">NOMBRE</button>
                                </div>
                                <!-- /btn-group -->
                                <input type="text" class="form-control"  value="<?php echo $user_datos['CLINOMBRE'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-3" style="margin-top:10px">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger" style="width:100px">SERIE</button>
                                </div>
                                <!-- /btn-group -->
                                <input type="text" class="form-control"  value="<?php echo $recibo['FACSERNRO'] ?>" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                       <div class='col-md-3'  style="margin-top:10px">
                          <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-danger" style="width:100px">TARIFA</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" value="<?php echo $user_datos['TARIFA'] ?>" disabled>
                            </div>
                        </div>
                        <div class='col-md-6'  style="margin-top:10px">
                          <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-danger" style="width:100px">DIRECCIÓN</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" value="<?php echo $user_datos['URBDES'].' '.$user_datos['CALDES'].' '.$user_datos['CLIMUNNRO'] ?>" disabled>
                            </div>
                        </div>
                        <div class='col-md-3'  style="margin-top:10px">
                          <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-danger" style="width:100px">NÚMERO</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" value="<?php echo $recibo['FACNRO'] ?>" disabled>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <span class="text-center text-red" style='font-size:1.15em'>NOTAS DE CRÉDITOS ASOCIADAS AL RECIBO</span>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id='notas_creditos' class="table table-bordered table-striped">
                <thead role='row'>
                  <th>SERIE NOTA</th>
                  <th>N° NOTA</th>
                  <th>FECHA NOTA</th>
                  <th>MES RECIBO</th>
                  <th>SUMINISTRO</th>
                  <th>TOTAL</th>
                  <th>OPCIONES</th>
                </thead>
                <tbody>
                  <?php foreach ($notas_credito as $NC) { ?>
                    <tr>
                      <td><?php echo $NC['NCASERNRO']; ?></td>
                      <td><?php echo $NC['NCANRO']; ?></td>
                      <td><?php echo $NC['NCAFECHA']; ?></td>
                      <td><?php echo $NC['NCAFACEMIF']; ?></td>
                      <td><?php echo $NC['NCACLICODF']; ?></td>
                      <td style="text-align:right"><?php echo number_format($NC['NCATOTDIF'],2,'.',''); ?></td>
                      <td style='text-align:center'>
                            <a href="#" onclick="ver_notaCredito('<?php echo $NC['NCACLICODF']; ?>','<?php echo $NC['NCASERNRO']; ?>','<?php echo $NC['NCANRO']; ?>')"  id="ver_nc" class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="bottom" title="Imprimir Nota Credito">
                             <i class="fa fa-print"></i>
                            </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
               <div class="box-header with-border">
                   <label class="text-red" style='font-size:1.15em'>Detalle Recibo</label>
               </div>
               <div class="box-body" style='font-size:1.1em'>
                   <div class="row">
                       <div class="col-md-12 col-sm-12" >
                           <div class="table-responsive">
                                <table id="recibos_pendientes" class="table table-bordered table-striped">
                                    <thead>
                                        <tr role="row">
                                            <th>N°</th>
                                            <th>CONCEPTO</th>
                                            <th>IMPORTE</th>
                                            <th>DESCUENTO</th>
                                            <th>IMPORTE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $subtotal = 0; $IGV = 0; $i = 0;foreach($faclin as $fac){ ?>
                                            <tr>
                                                <td><?php echo $fac['FACCONCOD'] ?></td>
                                                <td><?php echo $fac['FACCONDES'] ?></td>
                                                <td style="text-align:right" id='monto_fac1<?php echo $i; ?>'><?php echo number_format($fac['FACPRECI'],2,'.','') ?></td>
                                                <td><input type="text" style="text-align:right" id='descuento1<?php echo $i; ?>' class='money' onkeyup="validar_monto(<?php echo $fac['FACPRECI'] ?>,this,'<?php echo $i; ?>',event)" /><br><span id='error1<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                                                <td><input type="text" id='subtotal1<?php echo $i; ?>' style="text-align:right" value='<?php echo number_format($fac['FACPRECI'],2,'.','') ?>' disabled/></td>
                                            </tr>
                                        <?php $i++; $subtotal = $subtotal + floatval($fac['FACPRECI']); $IGV +=(floatval($fac['FACPRECI']) *(intval($igv)/100)) ;}?>
                                        <?php $i = 0;foreach($letfac as $let){ ?>
                                            <tr>
                                                <td><?php echo $let['FACCONCOD'] ?></td>
                                                <td><?php echo $let['FACCONDES'] ?></td>
                                                <td style="text-align:right" id='monto_fac2<?php echo $i; ?>'><?php echo number_format($let['CRECUOMON'],2,'.','') ?></td>
                                                <?php if(floatval($let['CRECUOMON'])<0) {?>
                                                    <td><input type="text" style="text-align:right" id='descuento2<?php echo $i; ?>' class='money' disabled/></td>
                                                <?php } else { ?>
                                                    <td><input type="text" style="text-align:right" id='descuento2<?php echo $i; ?>' onkeyup="validar_monto1(<?php echo $let['CRECUOMON'] ?>,this,'<?php echo $i; ?>',event)" class='money'/><br><span id='error1<?php echo $i ?>' style='display:none;color:#f00'>Error</span></td>
                                                <?php } ?>
                                                <td><input type="text" style="text-align:right" id='subtotal2<?php echo $i; ?>' value='<?php echo number_format($let['CRECUOMON'],2,'.','') ?>' disabled/></td>
                                            </tr>
                                        <?php $i++; $subtotal = $subtotal + floatval($let['CRECUOMON']);$IGV +=(floatval($let['CRECUOMON']) *(intval($igv)/100)) ;} ?>
                                    </tbody>
                               </table>
                           </div>
                       </div>
                   </div>
                   <div class="row">

                       <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header">
                                <label for="" class="title">
                                    RECIBO <?php echo $recibo['FACSERNRO'].'-'.$recibo['FACNRO']; ?>
                                </label>
                            </div>
                            <div class='box-body'>
                                <div class="table-responsive">
                                    <table id='nota-credito' class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>SUBTOTAL</td>
                                                <td id='subtotal' style='text-align:right'><?php echo number_format($subtotal,2,'.',''); ?></td>
                                            </tr>
                                            <tr>
                                                <td>IGV</td>
                                                <td id='igv' style='text-align:right'><?php echo number_format($IGV,2,'.',''); ?></td>
                                            </tr>
                                            <tr>
                                                <td>TOTAL</td>
                                                <td id='total' style='text-align:right'><?php echo number_format(($IGV + $subtotal),2,'.','')?></td>
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
                                </label>
                            </div>
                            <div class='box-body'>
                                <div class="table-responsive">
                                    <table id='nota-credito' class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>SUBTOTAL</td>
                                                <td id='subtotal1' style='text-align:right'>0.00</td>
                                            </tr>
                                            <tr>
                                                <td>IGV</td>
                                                <td id='igv1' style='text-align:right'>0.00</td>
                                            </tr>
                                            <tr>
                                                <td>TOTAL</td>
                                                <td id='total1' style='text-align:right'>0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                   </div>
                   </div>
                   <div class="row">
                       <div class="col-md-offset-10 col-md-2 col-sm-offset-4 col-sm-8">
                           <a class="btn btn-primary btn-block" onclick="guardar()">Guardar</a>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>

<script>

    $('#notas_creditos').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[5, 10, 20, 50, -1],[5, 10, 20, 50, "Todos"]],});
    igvBase = <?php echo $igv; ?>;
    igvBase = (parseInt(igvBase)/100).toFixed(2)
    faclin = <?php echo json_encode($faclin); ?>;
    lectfac = <?php echo json_encode($letfac); ?>;
    //console.log(faclin[0]['FACIGVCOB']);
    console.log(igvBase)
    $('.money').number( true, 2 );
    guardar = function(){
        swal({   title: "¿Está seguro de generar la Nota Crédito?",  
         text: "La nota de Crédito se descontara del monto total del Recibo",   
         type: "warning",  
          showCancelButton: true,   
          confirmButtonColor: "#296fb7",  
           confirmButtonText: "¡Sí!, Estoy seguro",   
           closeOnConfirm: false }, function(){   swal("Nota de Crédito Creada", "", "success"); });
    }

    function ver_notaCredito(suministro,serie,nro){
        var myWindow = window.open("<?php echo $this->config->item('ip'). 'cuenta_corriente/notaCredito/' ?>"+suministro+"/" + serie + "/"+nro, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=80, width=1100, height=800");
        myWindow.focus();
        myWindow.print();
    }


    validar_monto =  function( monto, valor, indice, event){
        if(event.which >= 48 && event.which <= 57){
            if(monto<parseFloat(valor.value)){
                $("#error1"+indice).css("display","inline").fadeOut(2000);
                $("#"+valor.id).val("")
                $( "#subtotal1"+indice ).val(parseFloat($( "#monto_fac1"+indice ).text()).toFixed(2))
                console.log(parseFloat($( "#monto_fac1"+indice ).text()))
            } else {
                $( "#subtotal1"+indice ).val((parseFloat(monto)-parseFloat(valor.value)).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1" ).html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            }
        } else if(event.which == 40 || event.which == 38 || event.which == 37 || event.which == 39){

        } else {
            if(valor.value==""){
                $( "#subtotal1"+indice ).val(parseFloat($( "#monto_fac1"+indice ).text()).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1").html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            } else{
                $( "#subtotal1"+indice ).val((parseFloat(monto)-parseFloat(valor.value)).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1").html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            }
        }
    }

    validar_monto1 = function(monto,valor,indice,event){
        if(event.which >= 48 && event.which <= 57){
            if(monto<parseFloat(valor.value)){
                $("#error2"+indice).css("display","inline").fadeOut(2000);
                $("#"+valor.id).val("")
                $( "#subtotal2"+indice ).val(parseFloat($( "#monto_fac2"+indice ).text()).toFixed(2))
                console.log(parseFloat($( "#monto_fac2"+indice ).text()))
            } else {
                $( "#subtotal2"+indice ).val((parseFloat(monto)-parseFloat(valor.value)).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1" ).html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            }
        } else if(event.which == 40 || event.which == 38 || event.which == 37 || event.which == 39){

        } else {
            if(valor.value==""){
                $( "#subtotal2"+indice ).val(parseFloat($( "#monto_fac2"+indice ).text()).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1").html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            } else{
                $( "#subtotal2"+indice ).val((parseFloat(monto)-parseFloat(valor.value)).toFixed(2))
                total_conceptos = <?php echo sizeof($faclin); ?>;
                total_conceptos1 = <?php echo  sizeof($letfac); ?>;
                subtotal = 0;
                igv = 0
                for(var i = 0; i < total_conceptos;i++){
                    subtotal += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val()));
                    if(faclin[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento1"+(i) ).val())) ? 0 : parseFloat($( "#descuento1"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                for(var i = 0; i< total_conceptos1; i++){
                    subtotal += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val()));
                    if(lectfac[i]['FACIGVCOB'] == 'S'){
                        igv += (isNaN(parseFloat($( "#descuento2"+(i) ).val())) ? 0 : parseFloat($( "#descuento2"+(i) ).val())) * igvBase
                    }
                    console.log(igv.toFixed(2));
                }
                $( "#subtotal1" ).html(subtotal.toFixed(2))
                $( "#igv1").html(igv.toFixed(2))
                $( "#total1" ).html((subtotal + igv).toFixed(2))
            }
        }
    }
</script>
