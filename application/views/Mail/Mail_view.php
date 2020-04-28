<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" type="text/css">
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<!--<section class="content">
 <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 col-offset-1">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h4 class="text-center">CREAR EXCEL PARA MAIL</h4>
                        </div>
                        <form action="<?php echo base_url();?>mail/Genera_Excel" method="post"  id="formulario">
                           <div class="box-body">
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                            <label for="email">MES :</label>
                                            <select class="form-control"  id="mes" name="mes">
                                                <option value="01">Enero</option>
                                                <option value="02">Febrero</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Mayo</option>
                                                <option value="06">Junio</option>
                                                <option value="07">Julio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                            <label for="email">AÑO :</label>
                                            <select class="form-control" id="anio" name="anio">
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                            <label for="email">CICLO :</label>
                                            <select class="form-control" id="ciclo" name="ciclo">
                                                <?php 
                                                    $i=0; 
                                                    while ($i<count($ciclos)) {
                                                ?>
                                                <option value="<?php echo $ciclos[$i]['FACCICCOD'];?>"><?php echo $ciclos[$i]['FACCICCOD'].'-'.$ciclos[$i]['FACCICDES']; ?></option>
                                                <?php
                                                        $i++;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="button" id="crear_excel" class="btn  btn-block btn-primary btn-flat" style="height:25; margin-top:-5px;" >Crear</button>
                                    </div>
                                </div>  
                                                          
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
</section>-->

<section class="content">
 <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 col-offset-1">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h4 class="text-center">CREAR EXCEL PARA MAIL</h4>
                        </div>
                           <div class="box-body">
                            <?php if (isset($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <?php echo $_SESSION['mensaje'][1]; ?>
                                </div><br>
                            <?php } ?>
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                            <label for="email">MES :</label>
                                            <select class="form-control"  id="mes" name="mes">
                                                <option value="01">Enero</option>
                                                <option value="02">Febrero</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Mayo</option>
                                                <option value="06">Junio</option>
                                                <option value="07">Julio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                            <label for="email">AÑO :</label>
                                            <select class="form-control" id="anio" name="anio">
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                            <label for="email">CICLO :</label>
                                            <select class="form-control" id="ciclo" name="ciclo">
                                                <?php 
                                                    $i=0; 
                                                    while ($i<count($ciclos)) {
                                                ?>
                                                <option value="<?php echo $ciclos[$i]['FACCICCOD'];?>"><?php echo $ciclos[$i]['FACCICCOD'].'-'.$ciclos[$i]['FACCICDES']; ?></option>
                                                <?php
                                                        $i++;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="text" id="crear_excel" class="btn  btn-block btn-primary btn-flat" style="height:25; margin-top:-5px;" >Crear</button>
                                    </div>
                                </div>  
                   
                            </div>                        
                    </div>
                </div>
            </div>
</section>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#crear_excel").on("click", function(){
            swal({
              title: "Excel para Mail",
              text: "¿Está seguro que desea generar el archivo Excel?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, estoy seguro",
              closeOnConfirm: false
            },
            function(){
              
              swal("Generando Archivo", "Puede consultar en sus archivos de descarga", "success");
              imprimir1();

            });
            
        });
    });
    function imprimir1(){
        
        var json = JSON.stringify(new Array($('#mes').val(), $('#anio').val(), $('#ciclo').val() ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php echo $this->config->item('ip').'mail/Genera_Excel'; ?>",
                'target': '_blank',
                'method': 'post',
                'type': 'hidden'
        }).append(jQuery('<input>', {
                'name': 'reporte',
                'value': json,
                'type': 'hidden'
        }));
        $('body').append(form);
        form.submit(); 
    }
</script>
