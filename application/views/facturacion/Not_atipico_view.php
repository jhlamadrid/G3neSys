<section class="content">   
    <div class="row">
        <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="col-md-12">
            <div class="alert alert-<?php echo ($_SESSION['mensaje'][0] == 'error') ? 'danger' : 'success'; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $_SESSION['mensaje'][1]; ?>
            </div><br>
        </div>
        <?php } ?>
        <div class="col-md-12">   
            <div class="box  box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $titulo; ?></h3>
                </div>
                <div class="box-body">
                    <div class="container-fluid">
                        <!--h5><b>REPORTES:</b></h5-->
                        <div class='container-fluid'>
                            <div class="row">
                                <div class="col-md-12">
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
                                                    $i=1; 
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
                                    
                            </div>          
                        </div>
                                
                            <div class="form-group col-md-12 col-sm-12" style="text-align:right;" >
                                <button id="PRINTREP1" type="button" class="btn btn-primary btn-md">
                                    IMPRIMIR NOTIFICACIÓN
                                </button>
                            </div>
                        </div> 
                          
                    </div>    
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $("#PRINTREP1").on("click", function(){
            imprimir1();
        });
    });
    function imprimir1(){
        //alert($('#mes').val());
        var tip = $("#Form-TComp option:selected").val();
        var json = JSON.stringify(new Array($('#mes').val(), $('#anio').val(), $('#ciclo').val() ));
        event.preventDefault();
        var form = jQuery('<form>', {
                'action': "<?php  echo $this->config->item('ip').'facturacion/crear_atipico'; ?>",
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