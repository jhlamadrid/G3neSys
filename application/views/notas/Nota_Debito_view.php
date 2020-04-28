<section class="content">
    
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6 col-md-offset-3" style='text-align:center'><h3  class="text-success">NOTAS DE DÉBITO</h3></div>
        </div>
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                   <div class="row">
                         <div class="col-sm-6 col-md-4">
                            <a class="btn btn-block btn-warning" style="margin:10px 0px" aria-label="Left Align" data-toggle="modal" data-target="#myModal">  <span class="fa fa-plus" aria-hidden="true"></span> &nbsp;&nbsp;Reportes</a>
                         </div>
                          <!--<div class="col-sm-6 col-md-3">
                              <a class="btn btn-block btn-danger" style="margin:10px 0px" aria-label="Left Align" data-toggle="modal" data-target="#myModal1">  <span class="fa fa-plus" aria-hidden="true"></span> &nbsp;&nbsp;Generar N.D. Masivas</a>
                          </div>-->
                           <div class="col-sm-6 col-md-4">
                               <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
                               <a class="btn btn-block btn-danger" style="margin:10px 0px" aria-label="Left Align" data-toggle="modal" data-target="#myModal1">  <span class="fa fa-plus" aria-hidden="true"></span> &nbsp;&nbsp;Generar Nota débito Recibos</a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                               <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
                               <a class="btn btn-block btn-danger" style="margin:10px 0px" aria-label="Left Align" data-toggle="modal" data-target="#myModal2">  <span class="fa fa-plus" aria-hidden="true"></span> &nbsp;&nbsp;N.D. Boleta y Factura</a>
                           </div>
                   </div>
                    
                </div>
                <ul class="nav nav-tabs" role="tablist" id="TABPROFORMA">
                    <li role="presentation" class="active">
                        <a href="#nd-recibos" aria-controls="Proformas" role="tab" data-toggle="tab">
                            <h4>Nota Débito Recibos</h4>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#nd-facbol" aria-controls="Comprobantes" role="tab" data-toggle="tab">
                            <h4>Nota Débito Boletas-Facturas</h4> 
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="nd-recibos">
                        <div class="box-body">
                   <div class="row">
                    <div class="col-md-12 col-sm-12">
                           <form class="form-inline" method="post">
                             <div class="form-group">
                                  <label >Buscar Por:</label>
                                  <select  class="form-control" name='tipo'>
                                    <!--<option value='0'>Suministro</option>-->
                                    <option value='1'>N° Nota Débito</option>
                                    <option value='2'>N° Recibo</option>
                                    <!--<option value="3">Factura o Boleta</option>-->
                                  </select>
                            </div>
                              <div class="form-group">
                                <label for="">Serie: </label>
                                <input type="text" class="form-control" onkeypress="return justNumbers(event);" id="serie" name='serie' required>
                              </div>
                              <div class="form-group">
                                <label for="">Número: </label>
                                <input type="text" class="form-control" onkeypress="return justNumbers(event);" id="numero" name='numero'  required>
                              </div>
                              <div class="form-group">
                                  <input type='submit' class="btn btn-success btn-block"  value="Buscar" style="height: 35px;line-height: 2px;">
                              </div> 
                              <div class="form-group">
                                  <a class="btn btn-primary btn-block" href="<?php echo base_url().'notas/notas_debito' ?>" style="height: 35px;line-height: 15px;">Ver Todas</a>
                              </div>
                           </form>  
                           
                       </div>
                    </div><br/>
                   
                   
                   
                    <div class="table-responsive">
                        <table id="notas_debito" class="table table-bordered table-striped">
                            <thead>
                                <tr role="row">
                                    <th>SERIE NOTA</th>
                                    <th>N° NOTA</th>
                                    <th>SERIE RECIBO</th>
                                    <th>N° RECIBO</th>
                                    <th>FECHA NOTA</th>
                                    <th>MES RECIBO</th>
                                    <th>SUMINISTRO</th>
                                    <th>TOTAL</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($notas)){?>
                            <?php foreach($notas as $nota) {?>
                               <?php $background = 'color:#000';if($nota['NCAFACESTA'] == 'I'){$background = 'color:#dd4b39';}else if($nota['NCAFACESTA'] == 'P'){$background = 'color:#337ab7';} else if($nota['NCAFACESTA'] == 'C'){$background = 'color:#e08e0b';}else{$background = 'color:#00acd6';}?>
                                <tr style="text-align:right;font-size:1.2em;<?php echo $background; ?>">
                                    <td><?php echo $nota['NCASERNRO'] ?></td>
                                    <td><?php echo $nota['NCANRO'] ?></td>
                                    <td><?php echo $nota['TOTFAC_FACSERNRO'] ?></td>
                                    <td><?php echo $nota['TOTFAC_FACNRO'] ?></td>
                                    <td><?php echo $nota['NCAFECHA'] ?></td> 
                                    <td><?php echo $nota['NCAFACEMIF'] ?></td>
                                    <td><?php echo $nota['NCACLICODF'] ?></td>
                                    <td style="text-align:right"><?php echo number_format($nota['NCATOTDIF'],2,'.','') ?></td>
                                    <td style='text-align:center'>
                                          <a href="#" onclick="ver_notaCredito(<?php echo $nota['NCACLICODF']; ?>,<?php echo $nota['NCASERNRO']; ?>,<?php echo $nota['NCANRO']; ?>)"  id="ver_nc" class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="bottom" title="Imprimir Nota Credito">
                                           <i class="fa fa-print"></i>
                                          </a>
                                    </td>
                                </tr>
                            <?php }}else{ ?>
                            <?php $background = 'color:#000';if($notaOne['NCAFACESTA'] == 'I'){$background = 'color:#dd4b39';}else if($notaOne['NCAFACESTA'] == 'P'){$background = 'color:#337ab7';} else if($notaOne['NCAFACESTA'] == 'C'){$background = 'color:#e08e0b';}else{$background = 'color:#00acd6';}?>
                            <tr style="text-align:right;font-size:1.2em;<?php echo $background; ?>">
                                    <td><?php echo $notaOne['NCASERNRO'] ?></td>
                                    <td><?php echo $notaOne['NCANRO'] ?></td>
                                    <td><?php echo $notaOne['TOTFAC_FACSERNRO'] ?></td>
                                    <td><?php echo $notaOne['TOTFAC_FACNRO'] ?></td>
                                    <td><?php echo $notaOne['NCAFECHA'] ?></td> 
                                    <td><?php echo $notaOne['NCAFACEMIF'] ?></td>
                                    <td><?php echo $notaOne['NCACLICODF'] ?></td>
                                    <td style='text-align:right'><?php echo $notaOne['NCATOTDIF'] ?></td>
                                    <td style='text-align:center'>
                                          <a href="#" id="ver_nc" class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="bottom" title="Imprimir Nota Credito">
                                           <i class="fa fa-print"></i>
                                          </a>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div><br>
                    
                    <div class="row">
                        <div class="col-md-3 col-xs-6" style="margin-top:8px">
                            <span class="label label-danger" style="text-shadow:none;font-size:1.2em"> </span>&nbsp; Nota Crédito Pendiente &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 col-xs-6" style="margin-top:8px">
                            <span class="label label-primary" style="text-shadow:none;font-size:1.2em"> </span>&nbsp; Nota Crédito Pagada &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 col-xs-6" style="margin-top:8px">
                            <span class="label label-info" style="text-shadow:none;font-size:1.2em"> </span>&nbsp; Nota Crédito Refinanciada &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 col-xs-6" style="margin-top:8px">
                            <span class="label label-warning" style="text-shadow:none;font-size:1.2em"> </span>&nbsp; Nota Crédito Convenio &nbsp;&nbsp;
                        </div>
                    </div>
                    
                </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id='nd-facbol'></div>
                </div>
            </div>
        </div>
    </div>
</section>


 <!-- Modal -->
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-info" style="font-family:'Ubuntu Condensed', sans-serif;">Generar Nota de Créditos Masivos</h4>
        </div>
        <div class="modal-body">
            <label>Opción: </label>
            <input type='text' id='suministro1' onkeypress="return justNumbers(event);"  required />
            <a class='btn btn-info' onclick="devolver_recibos()">Consultar</a>
            <br>
            <hr>
            <div class="table-responsive">
                        <table id="notas_credito_bf" class="table table-bordered table-striped">
                            <thead>
                                <tr role="row">
                                    <th>SERIE</th>
                                    <th>NÚMERO</th>
                                    <th>F. EMISIÓN</th>
                                    <th>F. VENCIMIENTO</th>
                                    <th>VALOR</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody id='cuerpo1'>
                            </tbody>
                </table>
            </div>
        </div>
        <span id='ik' style="display:none"></span>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>    
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-info" style="font-family:'Ubuntu Condensed', sans-serif;">Crear Nueva Nota Crédito a Factura o Boleta</h4>
        </div>
        <div class="modal-body">
           <div class="row" >
               <div class="col-md-5">
                    <select style="width:120px;font-size: 14px;" onchange="verificar_tipo()" id='tipo_doc'>
                        <option value='-1'>SELECCIONE UNA OPCIÓN</option>
                        <option value='1'>FACTURA</option>
                        <option value='2'>BOLETA</option>
                    </select>
                    <script>
                    verificar_tipo =  function(){
                        opcion = $( "#tipo_doc option:selected" ).text()
                        if(opcion == "FACTURA"){
                            $( "#busquedas" ).empty()
                            $( "#busquedas" ).prop('disabled',false)
                            var option = document.createElement("option");
                            var x = document.getElementById("busquedas")
                            option.text = 'SERIE Y NUMERO'
                            var option1 = document.createElement("option");
                            option1.text = 'RUC'
                            x.add(option);
                            x.add(option1);
                            $( "#SERIE_NUMERO" ).css("display","block")
                            $( "#RUC" ).css("display","none")
                            $( "#DNI" ).css("display","none")
                        } else  if(opcion == "BOLETA"){
                            $( "#busquedas" ).prop('disabled',false)
                            $( "#busquedas" ).empty()
                            var option = document.createElement("option");
                            var x = document.getElementById("busquedas")
                            option.text = 'SERIE Y NUMERO'
                            var option1 = document.createElement("option");
                            option1.text = 'DNI'
                            x.add(option);
                            x.add(option1);
                            $( "#SERIE_NUMERO" ).css("display","block")
                            $( "#RUC" ).css("display","none")
                            $( "#DNI" ).css("display","none")
                        }  else{
                            $( "#busquedas" ).prop('disabled',false)
                            $( "#busquedas" ).empty()
                            $( "#SERIE_NUMERO" ).css("display","none")
                            $( "#RUC" ).css("display","none")
                            $( "#DNI" ).css("display","none")
                        }
                    }
                    
                    visualizar_campos =  function(){
                        opcion = $( "#busquedas option:selected" ).text()
                        if(opcion == "SERIE Y NUMERO"){
                            $( "#SERIE_NUMERO" ).css("display","block")
                            $( "#RUC" ).css("display","none")
                            $( "#DNI" ).css("display","none")
                        } else if(opcion == 'RUC'){
                            $( "#SERIE_NUMERO" ).css("display","none")
                            $( "#RUC" ).css("display","block")
                            $( "#DNI" ).css("display","none")
                        } else {
                            $( "#SERIE_NUMERO" ).css("display","none")
                            $( "#RUC" ).css("display","none")
                            $( "#DNI" ).css("display","block")
                        }
                    }
                    </script>
                    <select style="width:150px;font-size: 14px;" id='busquedas' onchange="visualizar_campos()" disabled>

                    </select>
               </div>
               <div class="col-md-5" id='SERIE_NUMERO' style='display:none;margin-left: -50px;'>
                   SERIE: &nbsp;&nbsp;&nbsp;<input type='tel' id='bf_serie' onkeypress="return justNumbers(event);" style='width:50px;text-align:right'  required />
                    NÚMERO: &nbsp;&nbsp;&nbsp;<input type='tel' id='bf_numero' onkeypress="return justNumbers(event);" style='width:100px;text-align:right' required />
               </div> 
                <div class="col-md-5" id='RUC' style='display:none'>
                    RUC: &nbsp;&nbsp;&nbsp;<input type='tel' id='bf_ruc' onkeypress="return justNumbers(event);"  required />
                </div>
                <div class="col-md-5" id='DNI' style='display:none'>
                    DNI: &nbsp;&nbsp;&nbsp;<input type='tel' id='bf_dni' onkeypress="return justNumbers(event);"  required />
                </div>
                <div class="col-md-2">
                    <a class='btn btn-info' onclick="consultar()">Consultar</a>
                </div>
            </div>
            
            <hr>
            <div class="table-responsive">
                        <table id="notas_credito" class="table table-bordered table-striped">
                            <thead>
                                <tr role="row">
                                    <th>SERIE</th>
                                    <th>NÚMERO</th>
                                    <th>F. EMISIÓN</th>
                                    <th>CLIENTE</th>
                                    <th>MONTO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody id='cuerpo2'>
                            </tbody>
                </table>
            </div>
        </div>
        <span id='ik' style="display:none"></span>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>    
      </div>
      
    </div>
  </div>
<script src="./frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="./frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script>
 var data = new Array();
     $(document).ready(function() {
        var table = $('#notas_debito').DataTable({bFilter: false, bInfo: false,"bLengthChange": false,"bSort": false});
        $('#resumen tbody').on('click', 'tr', function () {
            $('#resumen > tbody  > tr').each(function() {
                this.style.background = "#fff";
            });
            data = table.row( this ).data();
            this.style.background ="#b9dbff";
        } );
    } );
    
    
    
    function devolver_recibos(data){
        var suministro = $('#suministro1').val();
        $('#cuerpo1').empty();
        if(suministro.length>6 && suministro.length<12){
            waitingDialog.show();
            //setTimeout(function () {waitingDialog.hide();}, 3000);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>notasD/ver_recibos?ajax=true",
                data: "suministro="+suministro,
                dataType: 'json',
                success: function(data)
                {
                    console.log(data.reclamos)
                    if(data.result === true)
                    {
                        for(var i1=0;i1<data.data.length;i1++){
                            var cuerpo = document.getElementById('cuerpo1');
                            var tr = document.createElement('tr')
                            tr.setAttribute("style","text-align:right;font-size:1.2em")
                            var td = document.createElement('td')
                            td.innerHTML = data.data[i1]['FACSERNRO'];
                            var td1 = document.createElement('td')
                            td1.innerHTML = data.data[i1]['FACNRO'];
                            var td2 = document.createElement('td')
                            td2.innerHTML = data.data[i1]['FACEMIFEC'];
                            var td3 = document.createElement('td')
                            td3.innerHTML = data.data[i1]['FACVENFEC'];
                            var td4 = document.createElement('td')
                            td4.innerHTML = data.data[i1]['FACTOTAL'];
                            var td5 = document.createElement('td')
                            
                            var a = document.createElement('a')
                            var i = document.createElement('i')
                            a.setAttribute('class','btn btn-default btn-flat')
                            a.setAttribute('title','Generar Nota Débito')
                            a.setAttribute('data-toggle','tooltip')
                            a.setAttribute('data-placement','bottom')
                            i.setAttribute('class','fa fa-spinner')
                            a.setAttribute('href','<?php echo base_url().'notasD/ver_recibo/'?>'+data.data[i1]['CLICODFAX']+'/'+data.data[i1]['FACSERNRO']+'/'+data.data[i1]['FACNRO'])
                            td5.appendChild(a);
                            td5.setAttribute('style','text-align:center');
                            a.appendChild(i);
                            tr.appendChild(td);
                            tr.appendChild(td1);
                            tr.appendChild(td2);
                            tr.appendChild(td3);
                            tr.appendChild(td4);
                            tr.appendChild(td5);
                            cuerpo.appendChild(tr);
                        }
                        
                        $('#notas_credito_bf').DataTable();
                        //document.getElementById('ik').innerHTML = data.mensaje;
                        //document.getElementById('ik').style.display = 'block';
                        //alert(data.data[1]['FACNRO']);
                        //window.location.href = "<?php #echo base_url();?>cuenta_corriente/mostrar_cartera/"+data.suministro;
                        waitingDialog.hide();
                    }else{
                        alert("error");
                        //sweetAlert("Datos Incorrectos", data.mensaje, "error");
                    }
                }
            });
            
        }else{
            sweetAlert("Suministro Incorrecto", '', "error");
        }

    }
    
    
    
    function consultar(){
        opcion = $( "#busquedas option:selected" ).text()
        opcion1 = $( "#tipo_doc option:selected" ).text()
        console.log(opcion1)
        $( "#cuerpo2" ).empty() 
        if(opcion == "SERIE Y NUMERO" && opcion1 == "FACTURA"){
            var serie = $('#bf_serie').val();
            var numero = $('#bf_numero').val();
            waitingDialog.show();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>notasD/ver_facturas?ajax=true",
                data: "serie="+serie+"&numero="+numero+"&tipo="+opcion+"&tipo_doc="+1,
                dataType: 'json',
                success: function(data)
                {
                    console.log(data)
                    if(data.result === true){
                        //notas_credito_bf
                        var cuerpo = document.getElementById("cuerpo2")
                        var tr = document.createElement('tr')
                        tr.setAttribute("style","text-align:right;font-size:1.2em")
                        var td = document.createElement('td')
                        td.innerHTML = data.data['FSCSERNRO'];
                        var td1 = document.createElement('td')
                        td1.innerHTML = data.data['FSCNRO'];
                        var td2 = document.createElement('td')
                        td2.innerHTML = data.data['FSCFECH'];
                        var td3 = document.createElement('td')
                        td3.innerHTML = data.data['FSCCLINOMB'];
                        var td4 = document.createElement('td')
                        td4.innerHTML = data.data['FSCTOTAL'];
                        var td5 = document.createElement('td')
                        var a = document.createElement('a')
                        var i = document.createElement('i')
                        a.setAttribute('class','btn btn-default btn-flat')
                        a.setAttribute('data-toggle','tooltip')
                        a.setAttribute('title','Generar Nota Crédito')
                        a.setAttribute('data-placement','bottom')
                        a.setAttribute('href','<?php echo base_url().'notaD/ver_boleta_factura/'?>'+data.data['FSCSERNRO']+'/'+data.data['FSCNRO']+'/1')
                        i.setAttribute('class','fa fa-print')
                        td5.appendChild(a);
                        a.appendChild(i);
                        tr.appendChild(td);
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tr.appendChild(td3);
                        tr.appendChild(td4);
                        tr.appendChild(td5);
                        cuerpo.appendChild(tr);
                        waitingDialog.hide();
                    } else {
                         waitingDialog.hide();
                        swal({
                          title: "",
                          text: "¡Documento no encontrado!",
                          imageUrl: "<?php echo base_url(); ?>img/preocupado.png"
                        });
                       
                    }
                }
            })
        }
        else if(opcion == "SERIE Y NUMERO" && opcion1 == "BOLETA"){
            var serie = $('#bf_serie').val();
            var numero = $('#bf_numero').val();
            console.log("aqui")
            waitingDialog.show();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>notasD/ver_facturas?ajax=true",
                data: "serie="+serie+"&numero="+numero+"&tipo="+opcion+"&tipo_doc="+0,
                dataType: 'json',
                success: function(data)
                {
                    console.log(data)
                    if(data.result === true){
                        //notas_credito_bf
                        var cuerpo = document.getElementById("cuerpo2")
                        var tr = document.createElement('tr')
                        tr.setAttribute("style","text-align:right;font-size:1.2em")
                        var td = document.createElement('td')
                        td.innerHTML = data.data['FSCSERNRO'];
                        var td1 = document.createElement('td')
                        td1.innerHTML = data.data['FSCNRO'];
                        var td2 = document.createElement('td')
                        td2.innerHTML = data.data['FSCFECH'];
                        var td3 = document.createElement('td')
                        td3.innerHTML = data.data['FSCCLINOMB'];
                        var td4 = document.createElement('td')
                        td4.innerHTML = data.data['FSCTOTAL'];
                        var td5 = document.createElement('td')
                        var a = document.createElement('a')
                        var i = document.createElement('i')
                        a.setAttribute('class','btn btn-default btn-flat')
                        a.setAttribute('data-toggle','tooltip')
                        a.setAttribute('title','Generar Nota Crédito')
                        a.setAttribute('data-placement','bottom')
                        a.setAttribute('href','<?php echo base_url().'notaD/ver_boleta_factura/'?>'+data.data['FSCSERNRO']+'/'+data.data['FSCNRO']+'/0')
                        i.setAttribute('class','fa fa-print')
                        td5.appendChild(a);
                        a.appendChild(i);
                        tr.appendChild(td);
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tr.appendChild(td3);
                        tr.appendChild(td4);
                        tr.appendChild(td5);
                        cuerpo.appendChild(tr);
                        waitingDialog.hide();
                    } else {
                         waitingDialog.hide();
                        swal({
                          title: "",
                          text: "¡Documento no encontrado!",
                          imageUrl: "<?php echo base_url(); ?>img/preocupado.png"
                        });
                       
                    }
                }
            })
        }
    }
    
    
    function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
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
				message = 'Cargando Recibos';
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