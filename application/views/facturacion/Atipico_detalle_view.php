<link rel="stylesheet" href="<?php echo $this->config->item('ip');  ?>frontend/plugins/sweetalert/sweetalert2.css" type="text/css">
<script src="<?php echo $this->config->item('ip');  ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<style type="text/css">
    .gallery
    {
        display: inline-block;
        margin-top: 20px;
    }
</style>
<section class="content">
 <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 col-offset-1">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h4 class="text-center" id="titulo">DETALLE DE ATIPICO <?php echo $periodo."-".$anio; ?></h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                     <button class= 'btn btn-md btn-warning' id="atras_boton" style="width: 100%" ><i class="fa fa-reply" aria-hidden="true"></i> Atras</button>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="row" id="detallado">
                                     <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:100px">
                                                        NOMBRE
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <?php if ($tam == 7) {?>
                                                <input type="text" class="form-control" id="NOMBRE" value="<?php echo $data_nombre['CLINOMBRE']; ?>" disabled>    
                                                <?php } ?>
                                                <?php if ($tam == 11) {?>
                                                <input type="text" class="form-control" id="NOMBRE" value="<?php echo $datos_atipicos['NOMBRE']; ?>" disabled>    
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:100px">
                                                        DIRECCIÓN
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control" id="DIRECCION" value="<?php echo $datos_atipicos['DIRECCION'];?>" disabled>
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:100px">
                                                        SUMINISTRO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  value="<?php echo $datos_atipicos['CLICODFAC'];?>" id="SUMINISTRO" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:100px">
                                                        ESTADO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  id="ESTADO" value="<?php echo $datos_atipicos['ESTADOCLI'];?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:100px">
                                                        TIPO SERVICIO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control" id="TIP_SERVICIO" value="<?php echo $datos_atipicos['TIPOSERVICIO'];?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:140px">
                                                        CICLO COMERCIAL
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  value="<?php echo $datos_atipicos['CICLO'];?>" id="C_COMERCIAL" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:100px">
                                                        GRUPO
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  id="GRUPO" value="<?php echo $datos_atipicos['GRUPO'];?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:100px">
                                                      MEDIDOR
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control" id="MEDIDOR" value="<?php echo $datos_atipicos['MEDIDOR'];?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-top:10px">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:150px">
                                                        CONEX. AGUA
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  value="<?php echo $datos_atipicos['ESTADOCONXAG'];?>" id="CONEX_AGUA" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-warning" style="width:150px">
                                                        CONEX. DESAGUE
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="text" class="form-control"  id="CONEX_DESAGUE" value="<?php echo $datos_atipicos['CONDESDES'];?>" disabled>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                
                                <div class="col-md-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12" id="pdf">
                                        
                                    </div>
                                    
                                </div>
                            </div>   
                            <div class="row">
                                <div class='list-group gallery'>
                                    <?php $i= 0;
                                          $bandera = 0; 
                                    while (count($detalle_atipico)>$i) {
                                        $tam = strlen($detalle_atipico[$i]["NOMIMG"]);
                                        $formato = substr($detalle_atipico[$i]["NOMIMG"],($tam-4),$tam);
                                        if($formato !='.pdf' && $formato !='.PDF')
                                        {
                                            $anio = substr($detalle_atipico[$i]["PERIODO"], 0, 4);
                                            $periodo = substr($detalle_atipico[$i]["PERIODO"], (strlen($detalle_atipico[$i]["PERIODO"])-2), strlen($detalle_atipico[$i]["PERIODO"])) ;
                                       
                                    ?>

                                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                        <a class="thumbnail fancybox" rel="ligthbox" href="https://dcsvpsws02.sedalib.com.pe/atipicos/<?php echo $anio;?>/<?php echo $periodo; ?>/<?php echo $detalle_atipico[$i]["NOMBRE_IMG_CORREGIDO"]; ?>">
                                            <img class="img-responsive"   alt=""  src="https://dcsvpsws02.sedalib.com.pe/atipicos/<?php echo $anio;?>/<?php echo $periodo; ?>/<?php echo $detalle_atipico[$i]["NOMBRE_IMG_CORREGIDO"]; ?>" />
                                            <div class='text-right'>
                                                <small class='text-muted'><?php echo $detalle_atipico[$i]["NOMIMG"]; ?></small>
                                            </div> <!-- text-right / end -->
                                        </a>
                                    </div> <!-- col-6 / end -->
                                    <?php
                                        }else{
                                            $bandera = 1 ;
                                        }      
                                            $i=$i+1;
                                        }
                                    ?>
                                    
                                </div> <!-- list-group / end -->
                            </div> <!-- row / end -->    
                             <?php
                              if ($bandera ==1) {
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        ARCHIVOS EN PDF 
                                    </h3>
                                    <table class="table">
                                    <thead>
                                      <tr>
                                        <th>NOMBRE </th>
                                        <th>PERIDO</th>
                                        <th>ARCHIVO</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      
                                      <?php $i= 0;
                                         
                                       while (count($detalle_atipico)>$i) {
                                        $tam = strlen($detalle_atipico[$i]["NOMBRE_IMG_CORREGIDO"]);
                                        $formato = substr($detalle_atipico[$i]["NOMBRE_IMG_CORREGIDO"],($tam-4),$tam);
                                            if($formato =='.pdf' || $formato =='.PDF')
                                            {
                                                $anio = substr($detalle_atipico[$i]["PERIODO"], 0, 4);
                                                $periodo = substr($detalle_atipico[$i]["PERIODO"], (strlen($detalle_atipico[$i]["PERIODO"])-2), strlen($detalle_atipico[$i]["PERIODO"])) ;
                                           
                                            ?>
                                            <tr>
                                            <td><?php echo $detalle_atipico[$i]["NOMIMG"];?></td>
                                            <td><?php echo $detalle_atipico[$i]["PERIODO"];?></td>
                                            <td><a href="https://dcsvpsws02.sedalib.com.pe/atipicos/<?php echo $anio;?>/<?php echo $periodo; ?>/<?php echo $detalle_atipico[$i]["NOMBRE_IMG_CORREGIDO"]; ?>" target="_blank"><img src="<?php echo $this->config->item('ip'); ?>frontend/recibo/pdf-icon.png"></a></td>
                                          </tr>
                                        
                                        <?php
                                            }      
                                            $i=$i+1;
                                        }
                                    ?>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                            <?php
                              }
                            ?> 
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-7" style="margin-top: 15px;">
                                                <h5 class="box-title">
                                                    SELECCIONAR IMAGENES A IMPRIMIR
                                                </h5>
                                            </div>
                                            <div class="col-md-5" style="margin-top: 15px;">
                                                <h5 class="box-title">
                                                    IMAGENES SELECCIONADAS A IMPRIMIR
                                                </h5>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-md-12" style="margin-top: 15px;">
                                            <div class="col-xs-5">
                                                <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                                                <?php $i= 0;
                                                $bandera = 0; 
                                                while (count($detalle_atipico)>$i) {
                                                    $tam = strlen($detalle_atipico[$i]["NOMIMG"]);
                                                    $formato = substr($detalle_atipico[$i]["NOMIMG"],($tam-4),$tam);
                                                    if($formato !='.pdf' && $formato !='.PDF')
                                                    {
                                                        $anio = substr($detalle_atipico[$i]["PERIODO"], 0, 4);
                                                        $periodo = substr($detalle_atipico[$i]["PERIODO"], (strlen($detalle_atipico[$i]["PERIODO"])-2), strlen($detalle_atipico[$i]["PERIODO"])) ;
                                                   
                                                ?>
                                                <option value="https://dcsvpsws02.sedalib.com.pe/atipicos/<?php echo $anio;?>/<?php echo $periodo; ?>/<?php echo $detalle_atipico[$i]["NOMBRE_IMG_CORREGIDO"]; ?>"><?php echo $detalle_atipico[$i]["NOMIMG"]; ?>  </option>
                                                
                                                <?php
                                                    }     
                                                        $i=$i+1;
                                                    }
                                                ?>
                                                 
                                                </select>
                                            </div>
                                            
                                            <div class="col-xs-2">
                                                <button type="button" id="search_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                                <button type="button" id="search_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                                <button type="button" id="search_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                                <button type="button" id="search_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                            </div>
                                            
                                            <div class="col-xs-5">
                                                <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple"></select>
                                            </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 " style="margin-top: 15px;">
                                    <button class= 'btn btn-md btn-primary' id="Imp_boton"  style="width: 100%;">Imprimir Imagen(s) </button>    
                                </div>
                                <div class="col-md-4" style="margin-top: 15px;">
                                    <button class= 'btn btn-md btn-primary' id="Imp_Lectura"  style="width: 100%;">Lectura </button>    
                                </div>
                                <div class="col-md-4" style="margin-top: 15px;">
                                    <button class= 'btn btn-md btn-primary' id="Imp_re_Lectura"  style="width: 100%;">Relectura </button>    
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
</section>
<script src="<?php echo $this->config->item('ip');  ?>frontend/multi_select/multi_select.js"></script>
<script type="text/javascript">
    var periodo = '<?php echo $peri ?>';
    var nombre_anio = '<?php echo $periodo ?>';
    var anio =  '<?php echo $anio ?>';
    var suministro = '<?php  echo $datos_atipicos['CLICODFAC']; ?>';
    $(document).ready(function(){
        //FANCYBOX
        //https://github.com/fancyapps/fancyBox
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
        $("#Imp_boton").click(function(event){
                Imprimir_acta(event);
        });
        $("#Imp_Lectura").click(function(event){
                Imprimir_lectura(event);
        });
        $("#Imp_re_Lectura").click(function(event){
                Imprimir_re_lectura(event);
        });
        $("#atras_boton").click(function(){
                location.href = "<?php echo $this->config->item('ip'); ?>atipico/ver";
        });
         $('#search').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Buscar Observación" />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Buscar Observación" />',
                },
                fireSearch: function(value) {
                    return value.length > 3;
                }
            });
    });

    function Imprimir_re_lectura(evt){
        var json = JSON.stringify(new Array( suministro, periodo, anio , nombre_anio ));
        evt.preventDefault();
         var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'atipico/reporte/re_lectura'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_re_lectura',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }

    function Imprimir_lectura(evt){
        var json = JSON.stringify(new Array( suministro, periodo, anio, nombre_anio ));
        evt.preventDefault();
         var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'atipico/reporte/lectura'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_lectura',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }

    function Imprimir_acta(event){
        var tabla = [];
        var i=0;
        $('#search_to').find('option').each(function() {
            
            tabla[i] = $(this).val();
            i++;
        });
        var json = JSON.stringify(new Array( tabla,  $('#titulo').text(), $('#NOMBRE').val(), $('#SUMINISTRO').val(), $('#DIRECCION').val()  ));
         event.preventDefault();
         var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'atipico/reporte/imagen'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
            }).append(jQuery('<input>', {
                'name': 'reporte_atipico',
                'value': json,
                'type': 'hidden'
            }));
        $('body').append(form);
        form.submit();
    }

   
</script>