  <link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert/sweetalert2.css" type="text/css">
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<section class="content">
    <form action="<?php echo $this->config->item('ip').'regimen/generar_pdf/'.$pk ?>" method="post" class="form-horizontal">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <input type="submit" class="btn btn-success btn-block btn-flat" value='GENERAR REGIMEN'>
            </div>
        </div><br>
        <?php $i = 0; foreach($recibos as $recibo){ ?>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 col-offset-1">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h5>INFORME DE FACTURACIÓN PERIÓDO - <?php echo $periodo[$i]; ?></h5>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="<?php echo $this->config->item('ip').'img/logo.png'; ?>" alt="Logo Empresa" class="img-responsive">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    PROCESO DE FACTURACIÓN
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10 col-offset-1" style="text-align:center">
                                    <b><h4>RÉGIMEN DE FACTURACIÓN 2519-16 - SEDALIB S.A.-8100-SGPV/FACT</h4></b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">Fecha: </div>
                                <div class="col-md-3"><?php echo date('d-m-Y'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>RECLAMO Nº</b></div>
                                <div class="col-md-3"><?php echo $num_reclamo; ?></div>
                                <div class="col-md-3"><b>Ciclo Comercial</b></div>
                                <div class="col-md-3"><?php echo $ciclo_comercial; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Mes(es) Reclamado(s):</b></div>
                                <div class="col-md-3"><?php for($j = 0;$j<sizeof($periodo);$j++){if($j==(sizeof($periodo)-1)){ echo $periodo[$j]; }else{echo $periodo[$j].',';}} ?></div>
                                <div class="col-md-3"><b>Categoría Tarifaria</b></div>
                                <div class="col-md-3"><?php echo (( strlen($suministro) == 7 ) ? mostrar_tarifas($tarifas) : $cabecera[0]['FACTARIFA']) ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Código Sumnistro: </b></div>
                                <div class="col-md-3"><b><?php echo $suministro; ?></b></div>
                                <div class="col-md-3"><b>Medidor: </b></div>
                                <div class="col-md-3"><?php echo $tipo_regimenes[$i]["MEDIDOR"]; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Unidades de Uso: </b></div>
                                <div class="col-md-3"><?php echo $unidades ?></div>
                                <div class="col-md-3"><b>Horario de Abastecimiento: </b></div>
                                <div class="col-md-3"><?php echo $horario['HOPDES'] ?></div>
                            </div>
                            <hr style="width:100%;height:1px;background:#000">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">Régimen de Facturación</div>
                                        <div class="col-md-6"><?php if($tipo_regimenes[$i]['TIPVOLFAC'] == "M"){echo "DIFERENCIA DE LECTURAS"; }else if($tipo_regimenes[$i]['TIPVOLFAC'] == "P"){ echo "PROMEDIO"; } else { echo "ASIGNADO"; } ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Período de Facturación</div>
                                        <div class="col-md-6"><?php echo $periodo[$i]; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Lectura Actual: </div>
                                        <div class="col-md-6"><?php echo $tipo_regimenes[$i]['LECTURA']." - ".$tipo_regimenes[$i]['FECLEC'] ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Lectura Anteior: </div>
                                          <div class="col-md-6"><?php if(isset($tipo_regimenes[$i])){ echo $tipo_regimenes[$i]['LECANT']; }  if(isset($tipo_regimenes1[$i]['LECTURA']) && isset($tipo_regimenes1[$i]['FECLEC'])){ echo ' - '.$tipo_regimenes1[$i]['FECLEC']; } ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Consumo  Facturado (m<sup>3</sup>)</div>
                                        <div class="col-md-6"><?php echo $tipo_regimenes[$i]['VOLFAC'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12" style="text-align:center">DATOS REFERENCIALES</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">Observación: </div>
                                        <div class="col-md-7"><?php echo $tipo_regimenes[$i]['OBSLEC']." ".$observaciones[$i];  ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">Consumo Asignado: </div>
                                        <div class="col-md-7"><?php   echo ((strlen($suministro) == 7) ? sumar_consumos($consumos[$i])  : $consumos_asignados[0])." m<sup>3</sup>" ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">Consumo Promedio: </div>
                                        <div class="col-md-7"><?php if(isset($consumos_validos[$i])){ echo $consumos_validos[$i]['PROMEDIO']; } else { if(isset($consumos_validos[$i-1])) { echo $consumos_validos[$i-1]['PROMEDIO']; }} ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">Consumos Válidos</div>
                                        <div class="col-md-7">
                                          <?php  if(isset($consumos_validos[$i])) {

                                                    if($consumos_validos[$i]["CONSUMO01"] != 0){
                                                        echo cambiar_mes(substr($consumos_validos[$i]['FECLEC01'],3,2),substr($consumos_validos[$i]['FECLEC01'],6,4))." [".$consumos_validos[$i]["CONSUMO01"]."]";
                                                    }
                                                    if($consumos_validos[$i]["CONSUMO02"] != 0){
                                                       echo  " - ".cambiar_mes(substr($consumos_validos[$i]['FECLEC02'],3,2),substr($consumos_validos[$i]['FECLEC02'],6,4))." [".$consumos_validos[$i]["CONSUMO02"]."]";
                                                    }
                                                    if($consumos_validos[$i]["CONSUMO03"] != 0){
                                                        echo " - ".cambiar_mes(substr($consumos_validos[$i]['FECLEC03'],3,2),substr($consumos_validos[$i]['FECLEC03'],6,4))." [".$consumos_validos[$i]["CONSUMO03"]."]";
                                                    }
                                                    if($consumos_validos[$i]["CONSUMO04"] != 0){
                                                        echo " - ".cambiar_mes(substr($consumos_validos[$i]['FECLEC04'],3,2),substr($consumos_validos[$i]['FECLEC04'],6,4))." [".$consumos_validos[$i]["CONSUMO04"]."]";
                                                    }
                                                    if($consumos_validos[$i]["CONSUMO05"] != 0){
                                                        echo " - ".cambiar_mes(substr($consumos_validos[$i]['FECLEC05'],3,2),substr($consumos_validos[$i]['FECLEC05'],6,4))." [".$consumos_validos[$i]["CONSUMO05"]."]";
                                                    }
                                                    if($consumos_validos[$i]["CONSUMO06"] != 0){
                                                        echo " - ".cambiar_mes(substr($consumos_validos[$i]['FECLEC06'],3,2),substr($consumos_validos[$i]['FECLEC06'],6,4))." [".$consumos_validos[$i]["CONSUMO06"]."]";
                                                    }

                                            }?>
                                        </div>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <span>OBSERVACIÓN</span><br>
                                    <textarea name="texto<?php echo $i; ?>" id="texto<?php echo $i; ?>"  style="width:100%;height:90px"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <b>BASE LEGAL: </b><br>
                                    <b>Resolución de Consejo Directivo 088-2007-SUNASS-CD</b> modificacion del Reglamento General de Reclamos de Usuaurio de Servicios de Saneamiento, aprobado mediante Resolución Nº 066-2006-SUNASS-CD
                                    <ul>
                                        <li>Artículo 87º <b>"Consideraciones a tomarse en cuenta en la facuración basada en Diferencias de Lecturas."</b></li>
                                        <li>Artículo 88º <b>"Control de Calidad de facturaciones en Diferencias de Lecturas."</b></li>
                                        <li>Artículo 89º <b>"Determinación del Volúmen a facturar por Agua Potable"</b></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-3" style="text-align:center">
                                    <img src="<?php echo $this->config->item('ip').'img/firma2.png'?>" class="img-responsive" style='margin-bottom:-25px' alt="Firma Jefe Facturación"><br>
                                    <hr style='width:100%;height:1px;background:#000'>
                                    <h5>JEFE DE PROCESO DE FACTURACIÓN</h5>
                                </div>
                                <div class="col-md-3" style="text-align:center">
                                    <img src="<?php echo $this->config->item('ip').'img/firma1.png'?>" class="img-responsive" style='margin-bottom:-25px' alt="Firma Auxiliar Facturación"><br>
                                    <hr style='width:100%;height:1px;background:#000'>
                                    <h5>AUXILIAR DE PROCESO DE FACTURACIÓN</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php $i++; } ?>
    </form>
</section>


<?php
function cambiar_mes($cadena,$str){
    $cadena = intval($cadena)+1;
    if($cadena < 10){ $cadena = "0".$cadena; }
    else if($cadena == 13){ $cadena = "01"; $str = intval($str)+1; }
    else{ $cadena = $cadena; }
    switch($cadena){
        case "01":return "ENE-".$str;break;
        case "02":return "FEB-".$str;break;
        case "03":return "MAR-".$str;break;
        case "04":return "ABR-".$str;break;
        case "05":return "MAY-".$str;break;
        case "06":return "JUN-".$str;break;
        case "07":return "JUL-".$str;break;
        case "08":return "AGO-".$str;break;
        case "09":return "SET-".$str;break;
        case "10":return "OCT-".$str;break;
        case "11":return "NOV-".$str;break;
        case "12":return "DIC-".$str;break;
    }
}
    function mostrar_tarifas($tarifas){
      $D01 = 0;
      $S01 = 0;
      $E01 = 0;
      $C01 = 0;
      $I01 = 0;
      $C03 = 0;
      foreach ($tarifas as $tarifa) {
        switch ($tarifa) {
          case 'D01':
            $D01++;
            break;
          case 'S01':
            $S01++;
            break;
          case 'E01':
            $E01++;
            break;
          case 'C01':
            $C01++;
            break;
          case 'I01':
            $I01++;
            break;
          case 'C03':
            $C03++;
            break;
        }
      }
      $resultado = "";
      if($D01 > 0){ $resultado .= "D01 - [".$D01."]"; }
      if($S01 > 0){
        if($resultado == ""){ $resultado .= "S01 - [".$S01."]"; }
        else { $resultado .= "; S01 - [".$S01."]"; }
      }
      if($E01 > 0){
        if($resultado == ""){ $resultado .= "E01 - [".$E01."]"; }
        else { $resultado .= "; E01 - [".$E01."]"; }
      }
      if($C01 > 0){
        if($resultado == ""){ $resultado .= "C01 - [".$C01."]"; }
        else { $resultado .= "; C01 - [".$C01."]";  }
      }
      if($I01 > 0){
        if($resultado == ""){ $resultado .= "I01 - [".$I01."]"; }
        else {  $resultado .= "; I01 - [".$I01."]"; }
      }
      if($C03 > 0){
        if($resultado == ""){ $resultado .= "C03 - [".$C03."]"; }
        else { $resultado .= "; C03 - [".$C03."]";  }
      }
      return $resultado;
    }

    function sumar_consumos($valor){
      $total = 0;
      foreach ($valor as $key) {
         $total += $key;
      }
      return $total;
    }

?>
