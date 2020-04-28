<?php

class Boleta_Factura_ctrllr extends CI_Controller {

    //var $list_comprobante;
    var $direccion_pdf;
    var $direccion_xml;
    var $direccion_qrtemp;
    var $nombre;
    var $digitos;
    
    //Nuevas direcciones archivos
    var $new_pdf;
    var $new_xml;
    
    public function __construct() {
        parent::__construct();

        $this->load->model('general/Propie_model');
        $this->load->model('general/Catalogo_model');
        $this->load->model('general/Oordpag_model');
        $this->load->model('boleta_factura/Comprobante_pago_model');

        $this->load->library('session');
        $this->load->library('acceso_cls');

        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['userdata']['oficina'] = $this->Catalogo_model->get_oficina($this->data['userdata']['NSOFICOD']);
        $this->data['userdata']['area'] = $this->Catalogo_model->get_oficina($this->data['userdata']['NSARECOD']);
        
        $this->data['proceso'] = 'Boletas y Facturas';
        $this->data['menu']['padre'] = 'comprobantes';
        $this->data['menu']['hijo'] = 'boletas_facturas';

        $this->direccion_pdf = 'assets/comprobante/boleta_factura/pdf/';
        $this->direccion_xml = 'assets/comprobante/boleta_factura/xml/';
        $this->direccion_qrtemp = 'assets/comprobante/boleta_factura/';
        $this->nombre = '/GeneSys/';
        $this->digitos = 6;
        
        //Nuevas direcciones de archivos
        $this->new_pdf = 'assets/comprobante/new_pdf/';
        $this->new_xml = 'assets/comprobante/new_xml/';                

        $igv = $this->Catalogo_model->get_igv();
        $_SESSION['IGV'] = $igv['FACTORPORCENTAJE'];

        $regzonloc = $this->Catalogo_model->get_regzonloc($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD']);
        $_SESSION['FSCREGION'] = $regzonloc['REG'];
        $_SESSION['FSCZONA'] =    $regzonloc['ZON'];
        $_SESSION['FSCSECTOR'] =  0;
        $_SESSION['FSCLOCALID'] = $regzonloc['LOC'];
        $rol=$this->Catalogo_model->get_rol($_SESSION['user_id']);
        if($rol==1){
          $rol=1;
        }else{
        // ===============================================================================
            $serie_boleta = $this->Catalogo_model->get_serie($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD'], $_SESSION['user_data']['NSARECOD'], 2);
            /*if(empty($serie_boleta)){
                redirect(base_url().'inicio');
                return;
            }*/
            $_SESSION['BOLETA']['serie'] = $serie_boleta['SERNRO'];
            $_SESSION['BOLETA']['serie_sunat'] = $serie_boleta['SUNSERNRO'];
            $serie_factura = $this->Catalogo_model->get_serie($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD'], $_SESSION['user_data']['NSARECOD'], 1);
        // ===============================================================================  
        
        // ===============================================================================
            /*if(empty($serie_factura)){
                redirect(base_url().'inicio');
                return;
            }*/
            $_SESSION['FACTURA']['serie'] = $serie_factura['SERNRO'];
            $_SESSION['FACTURA']['serie_sunat'] = $serie_factura['SUNSERNRO'];
        // ================================================================================
        }
           
    }

    private function calcular_precio($unitario, $cantidad, $tiene_igv, $gratuito){
        
        $igv = $_SESSION['IGV']/100;
        if($tiene_igv >= 10 && $tiene_igv <= 17){
            $usinigv = $unitario/(1+$igv);
        }else{
            $usinigv = 0 ;
        }
        $u_igv =  round($usinigv*$igv,2);
        $usinigv = $unitario-$u_igv;
        $precios = array(
            'UNIT'=> $unitario,
            'UNIT_SINIGV' => $usinigv,
            'UNIT_IGV' => $u_igv,
            'CANT' => $cantidad,
            'SUBTOT' => ($gratuito == '1')? 0:round($usinigv*$cantidad,2),
            'SUBIGV' => ($gratuito == '1')? 0:round($u_igv*$cantidad, 2),
            'TOT' => ($gratuito == '1')? 0:$unitario*$cantidad
        );
        return $precios;
    }

    private function sanear_string($string) {
     
        $string = trim($string);
     
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
     
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
     
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
     
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
     
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
     
        $string = str_replace(
            array('ç', 'Ç'),
            array('c', 'C',),
            $string
        );
     
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "<code>", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":",
                 "."),
            '',
            $string
        );
     
     
        return $string;
    }

    private function creo_QR($RUC,$tipo,$serie,$mto_total_igv,$mto_total,$fecha_emi) {
        $this->load->library('barcode_generador');
        $bar = $this->barcode_generador->cargar();
        //$bar = new BARCODE();
        $qr_values[0]    = $RUC ."|".$tipo ."|".$serie ."|".$mto_total_igv ."|".$mto_total ."|".$fecha_emi ;
        //$bar->QRCode_save('text', $qr_values, 'qr_imagen', './imagen/','png',50,2,'#ffffff','#000000','L',false);
        ///GeneSys/assets/comprobante/boleta_factura/ = $this->nombre.$this->direccion_qrtemp
        $bar->QRCode_save('text', $qr_values, $serie, $_SERVER['DOCUMENT_ROOT'].$this->nombre.$this->direccion_qrtemp,'png',50,2,'#ffffff','#000000','L',false);
        return base_url().$this->direccion_qrtemp.$serie.'.png';
    }

    private function facturax( $serie, $numero, $tipo, $refer, $firma, $tipDoc, $adi_cabecera, $adi_base, $tvvog, $montoletras, $tvvoi, $tvvoe, $tvvogr, $totdesc, $s_num, $fecEmision,
        $tipMoneda, $rucCliente, $tipDocCliente, $nomCliente, $monto_total_igv,
        $importe_total, $detalle,$direCliente,$oficina,$usuario,$docReferencia,$invoiceTypeCode,$anticipo,$descuentoGlobal,$guia_rem,$guia_trans){
        //var_dump($tipo);
        $i=0;
        $dire_img = base_url()."img/logo2.png";
        $sumador=0;
        $conta_cuerpo=0;
        $valor=1800;  
        $tam = sizeof($detalle);
        $cusAssignedAccountID = '20131911310';
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);
        /**********************************************************************
        * +realizo el estructurado del detalle del a factura                  *
        * +si es que sobrepasa una pagina inmediatamente salta a la siguiente *
        ***********************************************************************/
             while($i < $tam) {              
                   //28 filas
                  if(strlen($detalle[$i][10])<=94)
                  {
                    $sumador= $sumador +94;
                  }  
                  else
                  {
                     $div=strlen($detalle[$i][10])/94;
                     $mod=strlen($detalle[$i][10])%94;
                     if ($mod > 0) {
                        $sumador= $sumador + (($div+1)*94) ;
                        $valor=$valor +(($div+1) *29);
                      }
                      else
                      {
                        $sumador= $sumador + ($div*94) ;
                        $valor=$valor +($div*29);
                       
                      } 
                  }
                    
                  //echo "-->".$sumador."<--";

                  $precio = $this->calcular_precio($detalle[$i][3], $detalle[$i][1], ($detalle[$i]['AFECIGV']=='10'), $detalle[$i]['GRAT']);
                  //$valor_unitario = ($detalle[$i]['GRAT']=='1')? 0: (($tipo=='0')? $precio['UNIT']:$precio['UNIT_SINIGV']);
                  $valor_unitario = ($detalle[$i]['GRAT']=='1')? (($tipo=='0')? $precio['UNIT'] : $precio['UNIT_SINIGV']): (($tipo=='0')? $precio['UNIT']:$precio['UNIT_SINIGV']);
                  //var_dump($precio);
                  $fila_uno = "<tr style='border: 0.7px solid #000; '>
                                    <td style='border-bottom: 0.7px solid #000; border-left: 0.7px solid #000;border-right: 0.7px solid #000;text-align:center; '>".$detalle[$i][0]."</td>
                                    <td style='border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; text-align:center; '>".
                                        $detalle[$i][11].
                                    "</td>
                                    <td style='border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '><p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".
                                        $detalle[$i][10].
                                    "</p></td>".
                                    //"<td style='border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; text-align:center; '>".
                                        //$detalle[$i][13].
                                    //"</td>" .
                                    "<td style='text-align:right; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '> <span style='margin-right:5px;'>".
                                        $detalle[$i][1].
                                    "</span></td>
                                    <td style='text-align:right; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '> <span style='margin-right:5px;'>".
                                        //number_format($detalle[$i][12], 2, '.', '').
                                        number_format($valor_unitario, 2, '.', '').
                                    "</span></td>
                                    <td style='text-align:right;  border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '> <span style='margin-right:5px;'>".
                                        number_format(($detalle[$i][1]*$valor_unitario), 2, '.', '').
                                    "</span></td> 
                                      </tr>";
                  if($sumador>=$valor)
                  {
                    
                    $valor=1800; 

    
               
                    //$sumador=0;
                    if(isset($cuerpo[0])){
                        $conta_cuerpo = 0;
                    } else {
                        $conta_cuerpo = $conta_cuerpo + 1;
                    }

                        if(!isset($cuerpo[$conta_cuerpo])) {
                           $cuerpo[$conta_cuerpo]='';
                           $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo].$fila_uno;
                        } else {
                           $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo].$fila_uno;
                        }
                        
                    $sumador=strlen($detalle[$i][10]);           
                    
                  } else {
                        //$sumador=$sumador +20;
                        if(!isset($cuerpo[$conta_cuerpo])) {
                            $cuerpo[$conta_cuerpo]='';
                             $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo].$fila_uno;
                        } else {
                          $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo].$fila_uno;
                        }
                      
                  }
                  $i++;
             }

            /********************************************************
            * +realizo el graficado de la factura                   *
            * + aca se encuentra todo el html que dibuja la factura *
            *********************************************************/
            $adicional="<div style=' height: 80px; width:35% ;position:absolute; margin-left:31%;'>
                                 <div style='height:30px ; width:100% ; margin-top:-5px;'>
                                      <div style='height:30px; width:32% ; '>
                                       
                                           <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Oficina:
                                           </i>
                                           </strong>
                                           <br>
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                          ". $oficina ."
                                          </i>
                                      </div>
                                      <div  style=' margin-left:33%;position:absolute; height:30px; width:32% ;'>
                                         <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Usuario:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                            ". $usuario ."
                                          </i>
                                      </div>
                                      <div style=' margin-left:66%;position:absolute; height:30px; width:32% ; '>
                                        <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Doc Referencia:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                          ". $docReferencia ."
                                          </i>
                                      </div>

                                  </div>

                                  <div style='height:30px; width:100% ; margin-top:-5px;'>
                                      <div style='height:30px; width:32% ; '>
                                         <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           O. de Compra:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                            2016000203
                                          </i>
                                      </div>
                                      <div  style=' margin-left:33%;position:absolute; height:30px; width:32% ;'>
                                         <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Tipo de Moneda:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                            PEN-SOL
                                          </i>
                                      </div>
                                      <div style=' margin-left:66%;position:absolute; height:30px; width:32% ; '>
                                         <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Tipo de Moneda:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                            PEN-SOL
                                          </i>
                                      </div>

                                  </div>

                                  <div style='height:30px; width:100% ; margin-top:-5px;'>
                                      <div style='height:30px; width:32% ; '>
                                          <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Tipo de Moneda:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                            PEN-SOL
                                          </i>
                                      </div>
                                      <div  style=' margin-left:33%;position:absolute; height:30px; width:32% ;'>
                                         <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Tipo de Moneda:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                            PEN-SOL
                                          </i>
                                      </div>
                                      <div style=' margin-left:66%;position:absolute; height:30px; width:32% ; '>
                                         <strong style='margin-top:-2px;'>
                                           <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                           Tipo de Moneda:
                                           </i>
                                           </strong>
                                        
                                          <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                            PEN-SOL
                                          </i>
                                      </div>
                                  </div>
                          </div>
                            ";

            $cab_img =  "<div style='   height: 80px; width:30% ; text-align:center;'>".
                            "<img src='".base_url().'img/logo3.png'."' style='height:60px;'><br>".
                            (($this->data['userdata']['oficina']['DIST']!='TRUJILLO')? 
                                        (   "<span style='font-size:7px;'>".$this->data['userdata']['oficina']['OFIDIR']."</span><br>".
                                            "<span style='font-size:7px;'>".
                                                $this->data['userdata']['oficina']['DIST']." - ".
                                                $this->data['userdata']['oficina']['PROV']." - ".
                                                $this->data['userdata']['oficina']['DEPTO']).
                                            "</span>"
                                        :   '').
                        "</div>";
            $cab_det =  "<div style=' height: 80px; width:33% ;position:absolute; margin-left:67%;'>".
                            "<div style=' height: 80px; width:100% ; border-radius: 10px 10px 10px 10px;border: 0.7px solid #000000;' >".
                                "<h3  style='margin-top:10px; margin-bottom:5px;text-align:center;font-size:13px;'>".
                                    (($tipo==0)? 'BOLETA DE VENTA ELECTRONICA':'FACTURA ELECTRONICA').
                                "</h3>".
                                "<h3  style=' margin-top:2px; margin-bottom:5px; text-align:center; font-size:12px;'>".
                                    utf8_encode("R.U.C N° ").$cusAssignedAccountID.
                                "</h3>".
                                "<h3  style='margin-top:2px; margin-bottom:5px;text-align:center; margin-top:-12px ; font-size:14px;'> ".
                                    $s_num.
                                "</h3>".
                            "</div>".
                        "</div>";

            $cab =       "<div  style='   height: 110px; width:100% ; margin-top:15px;font-size:10px'>".
                            "<table style='border-spacing: 0px; border: 0px solid #000;  width:100%;  height: 45px;'>".
                                "<tr>".
                                    "<td  style='border-radius: 6px 0 0 0; border-left: 0.7px solid #000;border-right: 0.7px solid #000;border-top: 0.7px solid #000;width:10%; '>".
                                        "<span style='margin-left:5px;'> ".
                                            'NOMBRE'.
                                        "</span>".
                                    "</td>".
                                    "<td colspan='9' style=' border-radius: 0 6px 0 0; border-top: 0.7px solid #000;border-right: 0.7px solid #000; '>".
                                        "<span style='margin-left:5px;'>".
                                            $nomCliente.
                                        "</span>".
                                    "</td>". 
                                "</tr>".
                                "<tr>".
                                    "<td  style='border:0.7px solid #000; width:10%;'>".
                                        "<span style='margin-left:5px;'>".
                                            utf8_encode("DIRECCIÓN:").
                                        "</span>".
                                    "</td>".
                                    "<td colspan='9' style='border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'>".
                                        "<span style='margin-left:5px;'>".
                                            $direCliente.
                                        "</span>".
                                    "</td>".
                                "</tr>".
                                "<tr>".
                                    "<td  style='width:10%; border-left: 0.7px solid #000;border-right: 0.7px solid #000; border-top: 0.7px solid #000;'>".
                                        "<span style='margin-left:5px;'>".
                                            //(($tipo == 1)? utf8_encode($tipDoc." N°:"):utf8_encode("D.N.I. N°:")).
                                            utf8_encode($tipDoc." N°:").
                                        "</span>".
                                    "</td>".
                                    "<td  style='width:10%;border-right: 0.7px solid #000;' colspan='2' >".
                                        "<span style='margin-left:5px;'>".
                                            "<b>".$rucCliente."</b>".
                                        "</span>".
                                    "</td>". 
                                    "<td  style='width:12%;border-right: 0.7px solid #000; '>".
                                        "<span style='margin-left:5px;'>".
                                            (($tipo == 1)? utf8_encode("Guia Rem. N°:"):'').
                                        "</span>".
                                    "</td>".
                                    "<td  style='width:10%;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '>".
                                        "<span style='margin-left:5px;'>".
                                            (($tipo == 1)? $guia_rem:'').
                                        "</span>".
                                    "</td>".
                                    "<td  style='width:12%; border-right: 0.7px solid #000; text-align:right;  '>".
                                        "<span style='margin-right:3px;'>".
                                            (($tipo == 1)? utf8_encode("Guia Transp. N°:"):'').
                                        "</span>".
                                    "</td>". 
                                    "<td  style='width:10%;border-right: 0.7px solid #000; '>".
                                        "<span style='margin-left:5px;'>".
                                            (($tipo == 1)? $guia_trans:'').
                                        "</span>".
                                    "</td>".
                                    "<td  style='width:16%;border-right: 0.7px solid #000;  '>".
                                        "<span style='margin-left:5px;'>".
                                            "Fecha de Emision:".
                                        "</span>".
                                    "</td>".
                                    "<td  style='border-right: 0.7px solid #000;text-align:center;'  colspan='2' >".
                                        "<span style='margin-left:5px;'>".
                                            date("d-m-Y", strtotime($fecEmision)).
                                        "</span>".
                                    "</td>".  
                                "</tr>".
                                "<tr>".
                                    "<td  style='border:0.7px solid #000; border-bottom: 0.7px solid #000; width:10%; border-radius: 0 0 0 6px;'>".
                                        "<span style='margin-left:5px;'> ".
                                            'OBS.'.
                                        "</span>".
                                    "</td>".
                                    "<td colspan='9' style='border-radius: 0 0 6px 0; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'>".
                                        "<span style='margin-left:5px;'>".
                                             $refer." (".$serie."-".$numero.") ".
                                        "</span>".
                                    "</td>".
                                "<tr>".
                            "</table>".
                        "</div>";

           if($adi_cabecera=="1") {
                $cabecera =     "<div style=' height: 160px;width:100% ; margin-top:-25px;'>".
                                    "<div  style='   height: 80px; width:100% ;  position:relative; '>".
                                        $cab_img.
                                        $adicional.
                                        $cab_det.
                                    "</div>".   
                                    $cab.
                                "</div>";
           } else {
                $cabecera =     "<div style=' height: 160px;width:100% ; margin-top:-30px;'>".
                                    "<div  style='   height: 80px; width:100% ;  position:relative; '>".
                                        $cab_img.
                                        $cab_det.
                                    "</div>".   
                                    $cab.
                                "</div>";
           }
           
           $base="<div style='width:100%; height:80px;'>";
           /**********************************************
           *  - Creo la imagen del codigo de barras     * 
           **********************************************/

           $qrfile = $this->creo_QR($cusAssignedAccountID,$invoiceTypeCode,$s_num,$monto_total_igv,$importe_total,$fecEmision,$tipDocCliente,$rucCliente);
           //++++++++++++++++++++++++++++++++++++++++++++ 
           //var_dump($qrfile);
           $agrego_img="<div style='width:20%; height:80px; position:absolute; margin-top:30px;'>
                            <img src='".$qrfile."' style='width: 90%; height:80px; '>
                        </div>";
            
           $tranfe= "";
            if($tvvogr>0){
              $tranfe = "<tr>
                              <td style='font-size:9px;'>".
                                                "<strong> TRANSFERENCIA GRATUITA </strong>".
                                            "</td>".
                                            "<td style='border-radius: 5px 5px 5px 5px; border:0.7px solid #000;'>".
                                                "<span style='margin-left:5px;'>".''
                                                    /*number_format($tvvogr, 2, '.', '')*/.
                                                "</span>".
                                            "</td>".
                        "</tr>";
            }

            $base_centro =      "<div>".
                                    "<table style=' width:100% ; font-size:7px;'>".
                                        "<tr>".
                                            "<td colspan='2' style='border-radius: 5px 5px 5px 5px; border: 0.7px solid #000;'>".
                                                "Son: ".$ntt->numtoletras(($tvvogr>0) ? 0 : $importe_total).
                                            "</td>".
                                        "</tr>".$tranfe.
                                    "</table>".
                                "</div>";    

            $base_centro_inf =  "<div>".
                                    "<table style='border-spacing: 0px 0px 0px 0px;  width:100%;  height: 50px; margin-top:2px;font-size:8px;'>".
                                        "<tr>".
                                            "<td colspan='3' style='text-align:center; border-radius: 6px 0 0 0; border: 0.7px solid #000;'> FECHA</td>".
                                                "<td style='text-align:center; border-radius: 0 6px 0 0;  border-right: 0.7px solid #000; border-top: 0.7px solid #000; border-bottom: 0.7px solid #000;  '> CANCELADO</td>".
                                        "</tr>".
                                        "<tr>".
                                            "<td style=' border-bottom: 0.7px solid #000; border-left: 0.7px solid #000; border-right: 0.7px solid #000; text-align:center;height: 17px; '> DIA </td>".
                                            "<td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000;height: 17px; '> MES</td>".
                                            "<td style='text-align:center; border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000;height: 17px; '>".utf8_encode("AÑO")."</td>".
                                            "<td rowspan='2' style='  border-radius: 0 0 6px 0;  border-bottom: 0.7px solid #000; border-right: 0.7px solid #000; height: 34px;  '> </td>".
                                        "</tr>".
                                        "<tr>".
                                           "<td style='text-align:center; border-radius: 0 0 0 6px;border-bottom: 0.7px solid #000; border-left: 0.7px solid #000; border-right: 0.7px solid #000; height: 17px;'>".date("d", strtotime($fecEmision))."  </td>".
                                           "<td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000; height: 17px; '>".date("m", strtotime($fecEmision))."  </td>" .
                                           "<td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000;height: 17px;'>".date("Y", strtotime($fecEmision))." </td>".
                                         
                                        "</tr>".

                                    "</table>".
                                "</div>";

            $monto_total_otros = '';
            $monto_total_op_otros_cargos = '';

            $anticipo = (($anticipo=='')? 0:$anticipo);
            $anticipo = number_format($anticipo, 2, '.', '');
            $descuentoGlobal = (($descuentoGlobal=='')? 0:$descuentoGlobal);
            $descuentoGlobal = number_format($descuentoGlobal, 2, '.', '');
            $monto_total_igv = (($monto_total_igv=='')? 0:$monto_total_igv);
            $monto_total_igv = number_format($monto_total_igv, 2, '.', '');
            $tvvog = (($tvvog=='')? 0:$tvvog);
            $tvvog = number_format($tvvog, 2, '.', '');
            $monto_total_otros = (($monto_total_otros=='')? 0:$monto_total_otros);
            $monto_total_otros = number_format($monto_total_otros, 2, '.', '');
            $monto_total_op_otros_cargos = (($monto_total_op_otros_cargos=='')? 0:$monto_total_op_otros_cargos);
            $monto_total_op_otros_cargos = number_format($monto_total_op_otros_cargos, 2, '.', '');
            $importe_total = number_format($importe_total, 2, '.', '');
            $base_der =     "<table style='border-spacing: 0px 0px 0px 0px;  width:100%;  height: 80px;font-size:7px; margin-top:3px; '>
                                      <tr >
                                        <td style='border-radius: 6px 0 0 ".(($tipo=='0')? "6px":"0")."; border: 0.7px solid #000;width:30%;height: 23px;  '> <span style='margin-left:5px;'>".
                                            //(($tipo=='0')? "":"Sub-total: " ). 
                                            (($tipo=='0')? "TOTAL: S/":"Valor venta: S/" ).
                                        "</span></td>
                                        <td style='text-align:right; border-radius: 0 6px ".(($tipo=='0')? "6px":"0")." 0; border-right: 0.7px solid #000; border-top: 0.7px solid #000; border-bottom: 0.7px solid #000; width:70%;height: 23px; '> <span style='margin-right:5px;'>".
                                            //number_format((($tvvog=='')? 0:$tvvog), 2, '.', '').
                                            (($tipo=='0')? ( ($tvvogr>0) ? '0.00' : $importe_total  ):(($tvvogr>0)? '0.00' : $tvvog) ).
                                        " </span></td>
                                      </tr>
                                      <tr >
                                        <td style='".
                                                (($tipo=='0')? "":"border-left:0.7px solid #000;  border-bottom:0.7px solid #000; border-right: 0.7px solid #000; " ). 
                                            "width:30%;height: 23px;'><span style='margin-left:5px;'>".
                                            (($tipo=='0')? "":("I.G.V.(". $_SESSION['IGV']."%): S/") ). 
                                        "</span></td>
                                        <td style='".
                                                (($tipo=='0')? "":"text-align:right; border-right:0.7px solid #000; border-bottom:0.7px solid #000;" ).
                                            "width:70%; height: 23px;'> <span style='margin-right:5px;'> ".
                                            (($tipo=='0')? "":(($tvvogr>0) ? '0.00':$monto_total_igv) ).
                                        " </span></td>
                                      </tr>
                                      <tr >
                                        <td style='".
                                                (($tipo=='0')? "":"border-radius: 0 0 0 6px; border-left:0.7px solid #000;  border-bottom:0.7px solid #000; border-right: 0.7px solid #000; " ).
                                            "width:30%;height: 23px;'><span style='margin-left:5px;'>".
                                            (($tipo=='0')? "":"TOTAL: S/" ).
                                        "</span></td>
                                        <td style='".
                                            (($tipo=='0')? "":"border-radius: 0 0 6px 0; text-align:right; border-right:0.7px solid #000; border-bottom:0.7px solid #000; ").
                                            " width:70%;height: 23px;'> <span style='margin-right:5px;'> ".
                                            (($tipo=='0')? "":( ($tvvogr>0) ? '0.00':$importe_total) ).
                                        " </span></td>
                                      </tr>
                            </table>";

            if($adi_base==1) {
                $base=  $base.
                        $agrego_img.
                        "<div style='margin-left:21%; width:44%; height:80px; position:absolute; margin-top:30px;'>".
                            $base_centro.
                            $base_centro_inf.
                        "</div>".
                "
                <div style='margin-left:66%; width:34%; height:80px; position:absolute; margin-top:30px;'>".
                  $base_der.
                  "<h5 style='position:absolute;margin-left:-465px ;  font-size:9px; margin-top:5px;'> Documento aprobado:".utf8_encode("RESOLUCION DE INTENDENCIA REGIONAL-N° 062-005-0000246/SUNAT ").
                  "<br>firma: ".$firma."</h5>";
          }
          else
          {
            $base=$base."
            <div style='margin-left:21%; width:44%; height:80px; position:absolute; margin-top:30px;'>
                  <div>
                    <table style=' width:100% ; font-size:7px;'>
                              <tr>
                                <td colspan='2' style='border-radius: 5px 5px 5px 5px; border: 0.7px solid #000;'>
                                    Son:".$ntt->numtoletras($importe_total)." 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Valor de venta de operaciones Gratuitas
                                </td>
                                <td style='border-radius: 5px 5px 5px 5px; border:0.7px solid #000;'>
                                  <span style='margin-left:5px;'>  0.00 </span>
                                </td>
                              </tr>
                    </table>
                  </div>
                  <div>
                     <table style='border-spacing: 0px 0px 0px 0px;  width:100%;  height: 50px; margin-top:5px;font-size:8px;'>
                                    <tr>
                                      <td colspan='3' style='text-align:center; border-radius: 6px 0 0 0; border: 0.7px solid #000;'> FECHA</td>
                                      <td style='text-align:center; border-radius: 0 6px 0 0;  border-right: 0.7px solid #000; border-top: 0.7px solid #000; border-bottom: 0.7px solid #000;  '> CANCELADO</td> 
                                    </tr>
                                    <tr>
                                      <td style=' border-bottom: 0.7px solid #000; border-left: 0.7px solid #000; border-right: 0.7px solid #000; text-align:center; '> DIA </td>
                                      <td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000; '> MES</td>
                                      <td style='text-align:center; border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000; '>".utf8_encode("AÑO")."</td>
                                      <td rowspan='2' style='  border-radius: 0 0 6px 0;  border-bottom: 0.7px solid #000; border-right: 0.7px solid #000; height: 17px;  '> </td> 
                                    </tr>
                                    <tr>
                                      <td style='text-align:center; border-radius: 0 0 0 6px;border-bottom: 0.7px solid #000; border-left: 0.7px solid #000; border-right: 0.7px solid #000; height: 17px;'>".date("d", strtotime($fecEmision))."  </td>
                                      <td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000; height: 17px; '>".date("m", strtotime($fecEmision))."  </td>
                                      <td style='text-align:center;border-bottom: 0.7px solid #000;  border-right: 0.7px solid #000;height: 17px;'>".date("Y", strtotime($fecEmision))." </td>
                                     
                                    </tr>

                    </table>
                  </div>
                </div>
                <div style='margin-left:66%; width:34%; height:80px; position:absolute; margin-top:30px;'>".
                  $base_der.
                 "<h5 style='position:absolute;margin-left:-465px ;  font-size:9px; margin-top:5px;'> Documento aprobado:".utf8_encode("RESOLUCION DE INTENDENCIA REGIONAL-N° 062-005-0000246/SUNAT ").
                  "<br>firma: ".$firma."</h5>";
          }
          
          $html="
        <html lang='es'>
            <head>
            <title>Sedalib</title> 
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            </head>
            <body style='font-family:sans-serif;'>";
            $pagina=$cabecera."
               <div  style=' height: 205px;width:100% ; ' >
                  <table style='border-spacing: 0px 0px 0px 0px; border: 0px solid #000;  width:100%;   font-size:8px; margin-bottom: 5px;'>
                            <tr   style='border: 0.7px solid #000; border-collapse: collapse; '>
                                <th  style=' text-align:center; border-radius: 6px 0 0 0; border: 0.7px solid #000; width:4%; '>ITEM </td>  
                                <th  style=' text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:6%; '>CODIGO</th>  
                                <th  style=' text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:54%; '>".utf8_encode("DESCRIPCIÓN")." </th> 
                                ".
                                //"<th  style=' text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;width:4%;  '>UNID.  </th>".
                                "
                                <th  style='text-align:center; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:6%;'>CANT. </th> 
                                <th  style='  text-align:center;border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:15%; '>VALOR UNIT. </th> ".
                                "<th  style='  text-align:center;  border-radius: 0 6px 0 0; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:15%;'>VALOR TOTAL</th>  
                            </tr>";

        /**********************************************************
        * +realizo la concatenacion de toda la cadena             *
        * + en esta cadena concateno el cuerpo y el detalle de la *
        * factura                                                 *
        ***********************************************************/
        $i=0;
        while ($i<=$conta_cuerpo) {
            
          if ($i==0) 
            {
               $html=$html.$pagina.$cuerpo[$i]." </table> </div>".$base."<i style='margin-left:190px ; margin-top:55px; font-size:9px;'> pagina ".($i+1)."/".($conta_cuerpo+1)."</i></div></div>";  
             } 
          else
            {
                $html=$html."<div style='page-break-after:always;'></div>".$pagina.$cuerpo[$i]." </table> </div>".$base."<i style=' margin-left:190px ; margin-top:25px; font-size:9px;'> pagina ".($i+1)."/".($conta_cuerpo+1)."</i></div></div>";
            }
              $i=$i +1;
        }
        $html=$html."</body> </html>";

        $html2 = preg_replace('/\r\n+|\r+|\n+|\t+/i','', $html); 

        return $html2;
    }



    public function mostrar_boletasfacturas(){
        $rol=$this->Catalogo_model->get_rol($_SESSION['user_id']);
        //var_dump($rol, $_SESSION['user_id']);
        if($rol[0]['ID_ROL'] ==1){
          $this->data['consulta'] = 'multiple'; 
          $this->data['comprobantes'] = $this->Comprobante_pago_model->get_all_proforma();
          $this->data['view'] = 'boleta_factura/BoletaFactura_lista_view';
          $this->data['titulo'] = 'Boletas y Facturas';
          $this->data['boletas_facturas'] = $this->Comprobante_pago_model->get_first100_comprobantes();
          $this->data['breadcrumbs'] = array(array('Documentos', ''),array('Boletas y Facturas',''));
          $this->load->view('template/Master', $this->data);
        }else{
          redirect(base_url() . 'inicio');
        }
        
    }

// PROFORMAS
     private function url_exists( $url = NULL ) {
 
        if( empty( $url ) ){
            return false;
        }
     
        $options['http'] = array(
            'method' => "HEAD",
            'ignore_errors' => 1,
            'max_redirects' => 0
        );
        $body = @file_get_contents( $url, NULL, stream_context_create( $options ) );
        
        // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
        if( isset( $http_response_header ) ) {
            sscanf( $http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode );
     
            //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
            $accepted_response = array( 200, 301, 302 );
            if( in_array( $httpcode, $accepted_response ) ) {
                return true;
            } else {
                return false;
            }
         } else {
             return false;
         }
    }
    public function mostrar_pago($tipo, $serie, $numero){
        
        //verifica si webservice esta levantado
        //verifica si webservice esta levantado
        $respuesta  = $this->url_exists("https://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL");
        if(!$respuesta) {
          $this->session->set_flashdata('mensaje', array('error', 'Alerta: No se Pudo Conectar con WEB-SERVICE',""));
          redirect($this->config->item('ip')  . 'documentos/boletas_facturas');
          return ; 
        }
        //COMPRUEBO SI EXISTE  EL COMPROBANTE GRAVADO
        $estado_comprobante= $this->Comprobante_pago_model->existe_factura($tipo, $serie, $numero);
        //var_dump($estado_comprobante);
        if($estado_comprobante["SUNESTADO"] != null){
            $cliente= $this->Comprobante_pago_model->get_documento_comprobante($tipo, $serie, $numero);
            $detalle= $this->Comprobante_pago_model->get_documento_comprobante_detalle($tipo, $serie, $numero);
            $this->data['propie'] = $this->Propie_model->get_propie($cliente['FSCCLIUNIC']);
            if(empty($this->data['propie'])){
                $this->data['propie'] = $this->Propie_model->get_default_propie();
            }
            $this->data['detalle']=$detalle;
            $this->data['cliente']=$cliente;
            $this->data['tipo_registro']='boleta';
            $this->data['view']='boleta_factura/Completa_pro_view';
            $this->data['breadcrumbs'] = array(array('Profromas', 'documentos/boletas_facturas'),array('Pago de Boleta',''));
            
            $this->load->view('template/Master', $this->data);
        }else{
          //EXTRAIGO DATOS DE PROFORMA
          $cliente = $this->Comprobante_pago_model->get_cabecera_boletafactura_sinpagar($tipo, $serie, $numero);
          $this->data['proforma']['cliente'] = $cliente;
          $this->data['proforma']['descripcion'] = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar($tipo, $serie, $numero);
          $rpta1 = $cliente['STPEMPCOD'] != NULL && $cliente['STPOFICOD'] != NULL && $cliente['STPARECOD'] != NULL && 
                $cliente['STPCTDCOD'] != NULL && $cliente['STPDOCCOD'] != NULL && $cliente['STPSERNRO'] != NULL && 
                $cliente['CDPNRO'] != NULL;
          $rpta2 = $rpta = $cliente['STPEMPCOD'] == NULL && $cliente['STPOFICOD'] == NULL && $cliente['STPARECOD'] == NULL && 
                  $cliente['STPCTDCOD'] == NULL && $cliente['STPDOCCOD'] == NULL && $cliente['STPSERNRO'] == NULL && 
                  $cliente['CDPNRO'] == NULL;        
          $this->data['proforma']['oordpag'] = ($rpta1)? 'con_orden': (($rpta2)? 'sin_orden':'error'); 
          
          if($this->data['proforma']['oordpag']=='con_orden'){
              $profns2 = $this->Oordpag_model->get_oordpag($cliente['STPEMPCOD'], $cliente['STPOFICOD'], $cliente['STPARECOD'],$cliente['STPCTDCOD'], $cliente['STPDOCCOD'], $cliente['STPSERNRO'], $cliente['CDPNRO']);
              if(count($profns2)>0){
                  $this->data['profns'] = $profns2;
              }
          }
          $this->data['propie'] = $this->Propie_model->get_propie($this->data['proforma']['cliente']['FSCCLIUNIC']);
          if(empty($this->data['propie'])){
              $this->data['propie'] = $this->Propie_model->get_default_propie();
          }

          $this->data['tipo_registro']='boleta';
          $this->data['view']='boleta_factura/Proforma_pago_view';
          $this->data['breadcrumbs'] = array(array('Profromas', 'documentos/boletas_facturas'),array('Pago de Boleta',''));
          //$this->data['conceptos'] = $this->Comprobante_pago_model->get_concep();
          $this->load->view('template/Master', $this->data);
        }    
    }

    private function veri_tip_ser_num($tipo_prof,$serie_prof,$numero_prof){

        if( !is_numeric($tipo_prof) ){
              $this->session->set_flashdata('mensaje', array('error', 'No se identifico el tipo de la proforma'));
              redirect($this->config->item('ip').'documentos/boletas_facturas');
              return;
          }

          if( !is_numeric($serie_prof) ){
              $this->session->set_flashdata('mensaje', array('error', 'No se identifico la serie de la proforma'));
              redirect( $this->config->item('ip').'documentos/boletas_facturas');
              return;
          }

          if( !is_numeric($numero_prof) ){
              $this->session->set_flashdata('mensaje', array('error', 'No se identifico el numero de la proforma'));
              redirect( $this->config->item('ip') . 'documentos/boletas_facturas');
              return;
          }
    }

    public function continuar_Proceso(){
      if($this->input->server('REQUEST_METHOD') != 'POST'){
        
            $this->session->set_flashdata('mensaje', array('error', 'Error al acceder a la ruta'));
            redirect($this->config->item('ip') . 'documentos/boletas_facturas');
            return;
        }
      $aux = $this->input->post('comprobante');
      $ajax_proforma = json_decode($aux, true);
      // PROFORMA
      $tipo_prof = (!isset($ajax_proforma[0]))? null:$ajax_proforma[0];
      $serie_prof = (!isset($ajax_proforma[1]))? null:$ajax_proforma[1];
      $numero_prof = (!isset($ajax_proforma[2]))? null:$ajax_proforma[2];
      //var_dump($tipo_prof);
      //var_dump($serie_prof);
      //var_dump($numero_prof);
      //VARIABLE PARA LISTAR ERRORES 
      //var_dump($tipo_prof,$serie_prof,$numero_prof);
        
      $this->veri_tip_ser_num($tipo_prof,$serie_prof,$numero_prof);
      //PASO1 : VERIFICO EN QUE ESTADO SE QUEDO 
      $estado_comprobante= $this->Comprobante_pago_model->existe_factura($tipo_prof, $serie_prof, $numero_prof);
      //PASO2 : CONECTO CON WS
      try {
        $client = new SoapClient("https://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL");
        $cabecera = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo_prof, $serie_prof,$numero_prof);
        $cuerpo = $this->Comprobante_pago_model->get_descripcion_boletafactura($tipo_prof, $serie_prof,$numero_prof);
        $cliente = $this->Comprobante_pago_model->get_cabecera_boletafactura_sinpagar3($tipo_prof, $serie_prof, $numero_prof);
        $descripcion = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar2($tipo_prof, $cliente['FSCSERNRO'], $cliente['FSCNRO']);
        $ruc = '20131911310';
        $str_tipo = ($tipo_prof=='1')? '01':'03';
        $str2 = $ruc.'-'.$str_tipo.'-';
        $detalles = "";
        // PARA CONSEGUIR FIRMA 
        //var_dump();
        if ($estado_comprobante["SUNESTADO"]==1) {
          $estado_comprobante["SUNESTADO"]=8;
        }
        if ($estado_comprobante["SUNESTADO"]==8) {

              $rpta = $this->enviar_ws( $tipo_prof, $serie_prof, $numero_prof, $client, $cabecera, $cuerpo, $cliente, $descripcion );
              // EVALUAMOS LA RESPUESTA DE WS
              if($rpta['resultado']==false){
                  $this->session->set_flashdata('mensaje', array('error', 'Alerta: No se Pudo conseguir Firma',$detalles));
                  redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                  return ;
              }
              else{
                $detalles= $detalles."* Se emitio comprobante  <br>";
                // AGREGAMOS LA FIRMA EN LA BASE DE DATOS
                $rpta_ws = $rpta['rpta'];
                $this->Comprobante_pago_model->actualizar_firma( $tipo_prof, $serie_prof, $numero_prof, $rpta_ws[3]);
                // ACTUALIZAMOS ESTADO
                $this->Comprobante_pago_model->actualizar_estado_sunat( $tipo_prof, $serie_prof,$numero_prof,6);
                $estado_comprobante["SUNESTADO"]=6;
                //CREO DOCUMENTOS 
                // GENERAMOS XML
                $xml = base64_decode ( $rpta_ws[count($rpta_ws)-1] );
                $dir_file = $this->direccion_xml.$str2.$rpta['sunat'][0].'.xml';
                file_put_contents($_SERVER['DOCUMENT_ROOT'].$this->nombre.$dir_file, $xml);
                ob_flush();
                $detalles= $detalles."* Se creo documento XML <br>";  
                // GENERAMOS PDF
                $pdf = $this->generar_pdf1($cabecera,$cuerpo,$cliente, $descripcion, $rpta_ws[3]);
                //CARGO LIBRERIA  y GUARDAMOS LA DIRECCION DEL XML Y LA FIRMA
                $this->creo_pdf_xml($pdf,$cabecera,$numero_prof,$dir_file,$str2,$rpta,0);      
                $detalles= $detalles."* Se creo documento PDF <br>";
              }
        
          }
        if ($estado_comprobante["SUNESTADO"]==7) {
          $rpta = $this->enviar_ws( $tipo_prof, $serie_prof, $numero_prof, $client);
          $rpta_sunat = $this->enviar_sunat($rpta['sunat'], $client);
          if(!$rpta_sunat['resultado']){
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT no atendio peticion',$detalles));
            redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
            return ;      
          }else{
            $detalles= $detalles."* SUNAT atendio peticion <br>";
            $rpta_aux = $rpta_sunat['rpta'];
            $this->guardo_rpta_sunat($rpta_aux,$cabecera,$numero_prof,$cuerpo,$tipo_prof,$serie_prof);
          }
        }

        if ($estado_comprobante["SUNESTADO"]==6) {
           //$rpta = $this->enviar_ws( $tipo_prof, $serie_prof, $numero_prof, $client);
           $rpta[0]=$cabecera["SUNSERNRO"].'-'. str_pad($cabecera["SUNFACNRO"], 6, "0", STR_PAD_LEFT);
           //$rpta[0]='FFFF-'.$cabecera["SUNFACNRO"];
           if($cabecera["FSCTIPO"]==0){
            $rpta[1]="03";
           }
           if($cabecera["FSCTIPO"]==1){
            $rpta[1]="01";
           }
            $rpta[2]="produccion";
            $rpta[3]="1";
           $rpta_sunat = $this->enviar_sunat($rpta, $client);
           //echo var_dump($rpta_sunat);
           //exit();
           if(!$rpta_sunat['resultado']){
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT no atendio petición del estado 6',$detalles));
            redirect($this->config->item('ip').'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
            return ;      
          }else{
            $detalles= $detalles."* SUNAT atendio peticion <br>";
            $rpta_aux = $rpta_sunat['rpta'];
            //$this->guardo_rpta_sunat($rpta_aux,$cabecera,$numero_prof,$cuerpo,$tipo_prof,$serie_prof);
            $this->guardo_rpta_sunat_metodo2($rpta_aux,$cabecera,$numero_prof,$cuerpo,$tipo_prof,$serie_prof);
          }
        }


      } catch (SoapFault $fault) {
        $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT no atendio petición del estado 6',$detalles));
        redirect($this->config->item('ip').'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
        return ;  
      }


    }


    public function continuar_Proceso_ose(){
        if($this->input->server('REQUEST_METHOD') != 'POST'){
          
              $this->session->set_flashdata('mensaje', array('error', 'Error al acceder a la ruta'));
              redirect($this->config->item('ip') . 'documentos/boletas_facturas');
              return;
          }
        $aux = $this->input->post('comprobante');
        $ajax_proforma = json_decode($aux, true);
        // PROFORMA
        $tipo_prof = (!isset($ajax_proforma[0]))? null:$ajax_proforma[0];
        $serie_prof = (!isset($ajax_proforma[1]))? null:$ajax_proforma[1];
        $numero_prof = (!isset($ajax_proforma[2]))? null:$ajax_proforma[2];
        //var_dump($tipo_prof);
        //var_dump($serie_prof);
        //var_dump($numero_prof);
        //VARIABLE PARA LISTAR ERRORES 
        //var_dump($tipo_prof,$serie_prof,$numero_prof);
          
        $this->veri_tip_ser_num($tipo_prof,$serie_prof,$numero_prof);
        //PASO1 : VERIFICO EN QUE ESTADO SE QUEDO 
        $estado_comprobante= $this->Comprobante_pago_model->existe_factura($tipo_prof, $serie_prof, $numero_prof);
              
        $cabecera = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo_prof, $serie_prof,$numero_prof);
        $cuerpo = $this->Comprobante_pago_model->get_descripcion_boletafactura($tipo_prof, $serie_prof,$numero_prof);
        $cliente = $this->Comprobante_pago_model->get_cabecera_boletafactura_sinpagar3($tipo_prof, $serie_prof, $numero_prof);
        $descripcion = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar2($tipo_prof, $cliente['FSCSERNRO'], $cliente['FSCNRO']);
        $ruc = '20131911310';
        $str_tipo = ($tipo_prof=='1')? '01':'03';
        $str2 = $ruc.'-'.$str_tipo.'-';
        $detalles = "";
        
        //PASO2 : CONECTO CON WS
        try {        
  
          if ($estado_comprobante["SUNESTADO"]==6) {
             //$rpta = $this->enviar_ws( $tipo_prof, $serie_prof, $numero_prof, $client);
             $rpta[0]=$cabecera["SUNSERNRO"].'-'. str_pad($cabecera["SUNFACNRO"], 7, "0", STR_PAD_LEFT);
             //$rpta[0]='FFFF-'.$cabecera["SUNFACNRO"];
             if($cabecera["FSCTIPO"]==0){
              $rpta[1]="03";
              $dato_nro = $rpta[0];
             }
             if($cabecera["FSCTIPO"]==1){
              $rpta[1]="01";
              $dato_nro = $rpta[0];
             }
              $rpta[2]="produccion";
              $rpta[3]="1";
             
              $txt_respuesta = 'C:/v3.0_pruebas/conector/cpe/txtrespuesta/20131911310-' . $rpta[1] . '-' . $dato_nro . '.txt';
              
              if(file_exists($txt_respuesta)){                
                  
                  $file = fopen($txt_respuesta, "r"); // or exit("No se encontro el archivo!");
                  //Output a line of the file until the end is reached
                  while (!feof($file)) {
                      $log_resultado = fgets($file) . ",";
                  }
                  fclose($file);
  
                  if (substr($log_resultado, 0, 1) == '0') {
  
                      $rpta_sunat[] = 'xml enviado'; // posicion 1
  
                      $rpta_sunat[] = $_SERVER['REMOTE_ADDR'];  // posicion 2 ip de quien envia                                      
  
                      $rpta_sunat[] = date('l dS \of F Y h:i:s A'); // posicion 3 la fecha y hora de envio
  
                      $rpta_sunat[] = $rpta[1] . '-' . $rpta[0];
  
                      $rpta_sunat[] = '0';
  
                      $rpta_sunat[] = $log_resultado;
  
                      $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'], $nro_sedalib, $cliente['FSCTIPO'], $dato_sunat, $nro_sunat, $log_resultado);
                      //DE ACUERDO A LA RESPUESTA DE LA SUNAT GUARDO LOS ESTADOS 
                      
                      //$this->guardo_rpta_sunat_metodo2($rpta_sunat, $cliente, $nro_sedalib, $detalles, $tipo_prof, $serie_prof);
                      
                      
                      $detalles= $detalles."* SUNAT atendio peticion <br>";
                      
                      //$rpta_aux = $rpta_sunat['rpta'];
                      //$this->guardo_rpta_sunat($rpta_aux,$cabecera,$numero_prof,$cuerpo,$tipo_prof,$serie_prof);
                      
                      $this->guardo_rpta_sunat_metodo2($rpta_sunat,$cabecera,$numero_prof,$cuerpo,$tipo_prof,$serie_prof);                                        
                      
                  } else {
                      
                      //$log_resultado = implode(",", $e[0]);
                      $log_resultado = "SUNAT tardo en responder";
                      $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'], $nro_sedalib, $cliente['FSCTIPO'], $dato_sunat, $nro_sunat, $log_resultado);
                      //GUARDO ESTADO
                      $this->Comprobante_pago_model->actualizar_estado_sunat($cliente['FSCTIPO'], $cliente['FSCSERNRO'], $nro_sedalib, 6);
                      $detalles = $detalles . "* No se obtuvo ninguna respuesta de SUNAT <br>";
  
                      $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT tardo en responder', $detalles));
                      //redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/' . $tipo_prof . '/' . $serie_prof . '/' . $nro_sedalib);
                      redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/' . $tipo_prof . '/' . $serie_prof . '/' . $numero_prof);
                      return;
                      
                  }
              } else {
                  
                  $this->Comprobante_pago_model->actualizar_estado_sunat($cliente['FSCTIPO'], $cliente['FSCSERNRO'], $nro_sedalib,6);
                  $detalles= $detalles."* No se encontro respuesta del OSE <br>";
                  $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT tardo en responder',$detalles));
                  redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'. $numero_prof );                              
              }                       
              
             /*
             
             if(!$rpta_sunat['resultado']){
              $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT no atendio petición del estado 6',$detalles));
              redirect($this->config->item('ip').'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
              return ;      
            }else{
              $detalles= $detalles."* SUNAT atendio peticion <br>";
              $rpta_aux = $rpta_sunat['rpta'];
              //$this->guardo_rpta_sunat($rpta_aux,$cabecera,$numero_prof,$cuerpo,$tipo_prof,$serie_prof);
              $this->guardo_rpta_sunat_metodo2($rpta_aux,$cabecera,$numero_prof,$cuerpo,$tipo_prof,$serie_prof);
            }
            
            */
          }
  
  
        } catch (Exception $e) {
          $this->session->set_flashdata('mensaje', array('error', 'Alerta: No se encontro respuesta del OSE del estado 6',$detalles));
          redirect($this->config->item('ip').'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
          return ;  
        }
  
  
      }

    /*public function pagar_proforma(){
        
        if($this->input->server('REQUEST_METHOD') != 'POST'){
            $this->session->set_flashdata('mensaje', array('error', 'Error al acceder a la ruta'));
            redirect($this->config->item('ip') . 'documentos/boletas_facturas');
            return;
        }
        
        $aux = $this->input->post('comprobante');
        $val = false;
        $ajax_proforma = json_decode($aux, true);
        // PROFORMA
        $tipo_prof = (!isset($ajax_proforma[0]))? null:$ajax_proforma[0];
        $serie_prof = (!isset($ajax_proforma[1]))? null:$ajax_proforma[1];
        $numero_prof = (!isset($ajax_proforma[2]))? null:$ajax_proforma[2];

        $this->veri_tip_ser_num($tipo_prof,$serie_prof,$numero_prof);
        
        $detalles = "";

        //OBTENEMOS CABECERA E ITEMS DE LA PROFORMA
        $cliente = $this->Comprobante_pago_model->get_cabecera_boletafactura_sinpagar($tipo_prof, $serie_prof, $numero_prof);
        $descripcion = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar2($tipo_prof, $serie_prof, $numero_prof);
        
        // EVALUAMOS EL ESTADO DE LA PROFORMA
        if($cliente['FSCESTADO']!=0){
            redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: No se emitio comprobante debido a que la proforma ya fue emitida'));
            return;
        }

        $ruc = '20131911310';
        $str_tipo = ($tipo_prof=='1')? '01':'03';
        $str2 = $ruc.'-'.$str_tipo.'-';
        //PRIMERO VERIFICAMOS CONEXION CON EL WEB-SERVICE
            try {

                  $client = new SoapClient("https://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL");
                  // AL MOMENTO DE GRAVAR COLOCAR ESTADO
                  // EMITIMOS LA BOLETA DE VENTA O FACTURA
                  // OBTENEMOS EL ULTIMO NUMERO DE BOLETA O FACTURA DEPENDIENDO DE LA SERIE
                  // LA SERIE DE SEDALIB ES CORRELATIVA A LA SERIE DE LA SUNAT  EJEMPLO 102 = F102
                  // POR MOTIVO DE SER PRUEBA SE USARAN FF11:BB11
                  if($cliente['FSCTIPO']==0){
                    $dato_sunat='B'.$cliente['FSCSERNRO'];
                  }else{
                    $dato_sunat='F'.$cliente['FSCSERNRO'];
                  }
                  
                  $nro_sunat = $this->Comprobante_pago_model->max_nro_comprobante_sunat2($dato_sunat, $tipo_prof)['NRO'];
                      $nro_sunat = ((is_null($nro_sunat) || empty($nro_sunat))? 0:$nro_sunat)+1;
          
                  $nro_sedalib = $this->Comprobante_pago_model->max_nro_comprobante_sedalib($cliente['FSCSERNRO'], $tipo_prof);
                      $nro_sedalib = (is_null($nro_sedalib) || empty($nro_sedalib))? 1:$nro_sedalib['NRO']+1;

                  $var = true;
                  $var = $this->Comprobante_pago_model->registrar_factura($cliente, $descripcion, $serie_prof, $nro_sunat, $nro_sedalib);
                  if(!$var){

                    $this->session->set_flashdata('mensaje', array('error', 'Error: No se encuentra autorizada para los Pagos ',"COMUNIQUESE CON INFORMATICA"));
                    redirect($this->config->item('ip'). 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                    return;
                  
                  }
                  $detalles= $detalles." * Se gravo comprobante en BD <br>";
                  //$serie = ($cliente['FSCTIPO']==1)? $_SESSION['FACTURA']['serie']:$_SESSION['BOLETA']['serie'];    
                  $serie=$cliente['FSCSERNRO'];
                  // ENVIAMOS LA BOLETA DE VENTA O FACTURA AL WEB SERVICE PARA GENERAR FIRMA Y XML
                      //  0 : "xml generado"
                      //  1 : "xml guardado"
                      //  2 : "documento firmado"
                      //  3 : Firma
                      //  4 : "zip creado"
                      //  5 : XML encriptado
                  $rpta = $this->enviar_ws( $cliente['FSCTIPO'], $serie, $nro_sedalib, $client);
                  // EVALUAMOS LA RESPUESTA DE WS
                  //var_dump($rpta);
                  if($rpta['resultado']==false){

                      $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'],$nro_sedalib,8);

                      $this->session->set_flashdata('mensaje', array('error', 'Alerta: No se Pudo conseguir Firma',$detalles));
                      redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'. $nro_sedalib );
                      return ;
                  }
                  $detalles= $detalles."* Se firmo el comprobante  <br>";
                  // AGREGAMOS LA FIRMA EN LA BASE DE DATOS
                  $rpta_ws = $rpta['rpta'];
                  $this->Comprobante_pago_model->actualizar_firma( $cliente['FSCTIPO'], $serie, $nro_sedalib, $rpta_ws[3]);
                  // ACTUALIZAMOS ESTADO
                  $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'] ,$nro_sedalib,7);
                  // GENERAMOS XML
                  $xml = base64_decode ( $rpta_ws[count($rpta_ws)-1] );

                  $dir_file = $this->direccion_xml.$str2.$rpta['sunat'][0].'.xml';
                  file_put_contents($_SERVER['DOCUMENT_ROOT'].$this->nombre.$dir_file, $xml);
                  ob_flush();
                  $detalles= $detalles."* Se creo documento XML <br>";  
                  // GENERAMOS PDF
                  $pdf = $this->generar_pdf(  $cliente['FSCTIPO'],$cliente['FSCSERNRO'],$nro_sedalib,$rpta_ws[3]);
                  //CARGO LIBRERIA  y GUARDAMOS LA DIRECCION DEL XML Y LA FIRMA
                  $this->creo_pdf_xml($pdf,$cliente,$nro_sedalib,$dir_file,$str2,$rpta,1);      
                  $detalles= $detalles."* Se creo documento PDF <br>";
                      
                  // ENVIAMOS A SUNAT

                  $rpta_sunat = $this->enviar_sunat($rpta['sunat'], $client);
                  // EVALUAMOS RESPUESTA DEL ENVIO A SUNAT
                  if(!$rpta_sunat['resultado']){
                      $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,6);

                      $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT no atendio peticion',$detalles));
                      redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'. $nro_sedalib );
                      return ;      
                  }
                  $detalles= $detalles."* SUNAT atendio peticion <br>";
                  $rpta_aux = $rpta_sunat['rpta'];
                  //DE ACUERDO A LA RESPUESTA DE LA SUNAT GUARDO LOS ESTADOS 
                  $this->guardo_rpta_sunat($rpta_aux,$cliente,$nro_sedalib,$detalles,$tipo_prof,$serie_prof);
                          
            } 
            catch (SoapFault $fault) {
                
                $this->session->set_flashdata('mensaje', array('error', 'Alerta: No Se pudo conectar con el WEB-SERVICE',"Intente mas tarde"));
                 redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                return ;
             
            }

    }*/

    public function pagar_proforma(){
        
        if($this->input->server('REQUEST_METHOD') != 'POST'){
            $this->session->set_flashdata('mensaje', array('error', 'Error al acceder a la ruta'));
            redirect($this->config->item('ip') . 'documentos/boletas_facturas');
            return;
        }
        
        $aux = $this->input->post('comprobante');
        $val = false;
        $ajax_proforma = json_decode($aux, true);
        // PROFORMA
        $tipo_prof = (!isset($ajax_proforma[0]))? null:$ajax_proforma[0];
        $serie_prof = (!isset($ajax_proforma[1]))? null:$ajax_proforma[1];
        $numero_prof = (!isset($ajax_proforma[2]))? null:$ajax_proforma[2];

        $this->veri_tip_ser_num($tipo_prof,$serie_prof,$numero_prof);
        
        $detalles = "";

        //OBTENEMOS CABECERA E ITEMS DE LA PROFORMA
        $cliente = $this->Comprobante_pago_model->get_cabecera_boletafactura_sinpagar($tipo_prof, $serie_prof, $numero_prof);
        $descripcion = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar2($tipo_prof, $serie_prof, $numero_prof);
        
        // EVALUAMOS EL ESTADO DE LA PROFORMA
        if($cliente['FSCESTADO']!=0){
            redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: No se emitio comprobante debido a que la proforma ya fue emitida'));
            return;
        }

        $ruc = '20131911310';
        $str_tipo = ($tipo_prof=='1')? '01':'03';
        $str2 = $ruc.'-'.$str_tipo.'-';
        //PRIMERO VERIFICAMOS CONEXION CON EL WEB-SERVICE
            try {

                  $client = new SoapClient("https://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL");
                  // AL MOMENTO DE GRAVAR COLOCAR ESTADO
                  // EMITIMOS LA BOLETA DE VENTA O FACTURA
                  // OBTENEMOS EL ULTIMO NUMERO DE BOLETA O FACTURA DEPENDIENDO DE LA SERIE
                  // LA SERIE DE SEDALIB ES CORRELATIVA A LA SERIE DE LA SUNAT  EJEMPLO 102 = F102
                  // POR MOTIVO DE SER PRUEBA SE USARAN FF11:BB11
                  if($cliente['FSCTIPO']==0){
                      $dato_sunat='B'.$cliente['FSCSERNRO'];
                  }else{
                      $dato_sunat='F'.$cliente['FSCSERNRO'];
                  }
                  //OBTENGO MAXIMO SUNAT(CORRELATIVO)
                  $nro_sunat = $this->Comprobante_pago_model->max_nro_comprobante_sunat2($dato_sunat, $tipo_prof)['NRO'];
                  $nro_sunat = ((is_null($nro_sunat) || empty($nro_sunat))? 0:$nro_sunat)+1;
                  //OBTENGO MAXIMO SEDALIB (CORRELATIVO)
                  $nro_sedalib = $this->Comprobante_pago_model->max_nro_comprobante_sedalib($cliente['FSCSERNRO'], $tipo_prof);
                  $nro_sedalib = (is_null($nro_sedalib) || empty($nro_sedalib))? 1:$nro_sedalib['NRO']+1;

                  //SERIE
                  $serie=$cliente['FSCSERNRO'];
                  //PASO 1: OBTENEMOS LA ESTRUCTURA PARA EL ENVIO A WEB SERVICE
                  $cmp = $this->obtener_estructura($cliente, $descripcion, $nro_sunat, $nro_sedalib);
                  //PASO 2: HACEMOS EL ENVIO  AL WEB SERVICE
                  //echo "************************"."<br>";
                  //echo var_dump($cmp);
                                    
                  $resultado_sunat = $client->metodo1($cmp[0], $cmp[1]);
                 
                  if(isset($resultado_sunat)){
                    // ENVIAMOS LA BOLETA DE VENTA O FACTURA AL WEB SERVICE PARA GENERAR FIRMA Y XML
                      //  0 : "xml generado"
                      //  1 : "xml guardado"
                      //  2 : "documento firmado"
                      //  3 : Firma
                      //  4 : "zip creado"
                      //  5 : XML encriptado
                      if (count($resultado_sunat) == 7) {
                        //echo "<br> resultado optimo tam = 7";
                        if($resultado_sunat[2] =="documento firmado"){
                          //echo "<br> se firmo correctamente el documento ";
                          if( ($resultado_sunat[4] =="zip creado") and (strlen($resultado_sunat[6]) > 150)){
                            // GENERAMOS XML
                            $xml = base64_decode($resultado_sunat[6]);
                            //echo "<br>".$xml;
                            $dir_file = $this->direccion_xml.$str2.$cmp[0][6].'.xml';
                            //echo "<br> direccion del xml : ".$dir_file;
                            //GUARDAMOS EL DOCUMENTO XML 
                            file_put_contents($_SERVER['DOCUMENT_ROOT'].$this->nombre.$dir_file, $xml);
                            //echo "<br> documento xml guardado ";
                            ob_flush();
                            // GENERAMOS PDF
                            $pdf = $this->generar_pdf($cliente,$descripcion,$nro_sedalib,$nro_sunat,$resultado_sunat[3]);
                            //CARGO Y GUARDO PDF
                            $dir_pdf = $this->creo_pdf_xml_metodo2($pdf, $cliente, $nro_sedalib, $str2, $cmp[0][6], 1);
                            //echo "<br> documento PDF guardado ";
                            //GUARDO LOS DATOS EN LA BD
                            
                            $var = $this->Comprobante_pago_model->registrar_factura_metodo2($cliente, $descripcion, $serie, $nro_sunat, $nro_sedalib, $dir_file, $dir_pdf, $resultado_sunat[3] );
                            if ($var) {
                              //ARMAMOS LA ESTRUCTURA PARA ENVIAR A SUNAT  
                                  //$rpta[0]='FFFF-'.$cabecera["SUNFACNRO"];
                                  if($cliente['FSCTIPO']==0){
                                    $rpta[0]='B'.$serie.'-'. str_pad($nro_sunat, 6, "0", STR_PAD_LEFT);
                                    $rpta[1]="03";
                                  } 
                                  if($cliente['FSCTIPO']==1){
                                    $rpta[0]='F'.$serie.'-'. str_pad($nro_sunat, 6, "0", STR_PAD_LEFT);
                                    $rpta[1]="01";
                                  }
                                  $rpta[2]="produccion";
                                  $rpta[3]="1";
                                  try {
                                      $rpta_sunat = $client->metodo6($rpta);
                                      if(isset($rpta_sunat)){
                                        $log_resultado = implode(",", $rpta_sunat);
                                        $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'],$nro_sedalib,$cliente['FSCTIPO'],$dato_sunat,$nro_sunat,$log_resultado);
                                        //DE ACUERDO A LA RESPUESTA DE LA SUNAT GUARDO LOS ESTADOS 
                                        $this->guardo_rpta_sunat_metodo2($rpta_sunat,$cliente,$nro_sedalib,$detalles,$tipo_prof,$serie_prof);
                                      }
                                  } catch (Exception $e) {
                                    
                                     //$log_resultado = implode(",", $e[0]);
                                     $log_resultado = "SUNAT tardo en responder";
                                     $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'],$nro_sedalib,$cliente['FSCTIPO'],$dato_sunat,$nro_sunat,$log_resultado);
                                     //GUARDO ESTADO
                                    $this->Comprobante_pago_model->actualizar_estado_sunat($cliente['FSCTIPO'], $cliente['FSCSERNRO'], $nro_sedalib,6);
                                    $detalles= $detalles."* No se obtuvo ninguna respuesta de SUNAT <br>";
                                    $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT tardo en responder',$detalles));
                                    redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'. $nro_sedalib );
                                    return;
                                  }
                                
                              //echo "se gravaron los datos correctamente ";
                            }else{
                              var_dump($var);
                              //exit();
                              //$var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'],$nro_sedalib,$cliente['FSCTIPO'],$dato_sunat,$nro_sunat,"no se pudieron gravar los datos ");
                              //echo "no se pudieron gravar los datos ";
                              //$this->session->set_flashdata('mensaje', array('error', 'ocurrio un problema,No se pudo guardar los datos ',$detalles));
                              //redirect($this->config->item('ip')  . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                            }
                          }else{
                            $log_land= implode(",", $resultado_sunat );                   
                            $var_resultado = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'],$nro_sedalib,$cliente['FSCTIPO'],$dato_sunat,$nro_sunat,$log_land);
                            $this->session->set_flashdata('mensaje', array('error', 'ocurrio un problema , NO se pudo ZIPEAR documento',$detalles.$log_land));
                             redirect($this->config->item('ip')  . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                          }
                        }else{
                          $log_land= implode(",", $resultado_sunat );                   
                          $var_resultado = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'],$nro_sedalib,$cliente['FSCTIPO'],$dato_sunat,$nro_sunat,$log_land);
                          $this->session->set_flashdata('mensaje', array('error', 'ocurrio un problema , NO se pudo FIRMAR documento',$detalles.$log_land));
                         redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                        }
                      }else{
                        $log_land= implode(",", $resultado_sunat );                   
                        $var_resultado = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'],$nro_sedalib,$cliente['FSCTIPO'],$dato_sunat,$nro_sunat,$log_land);
                        $this->session->set_flashdata('mensaje', array('error', 'ocurrio un problema , NO obtuvo la estructura del documento',$detalles.$log_land));
                         redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                      }
                  }else{
                    $log_land= implode(",", $resultado_sunat );                   
                    $var_resultado = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'],$nro_sedalib,$cliente['FSCTIPO'],$dato_sunat,$nro_sunat,$log_land);
                    $this->session->set_flashdata('mensaje', array('error', 'ocurrio un problema en WEB-SERVICE ',$detalles.$log_land));
                     redirect($this->config->item('ip')  . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                  }
                  
                          
            } 
            catch (SoapFault $fault) {
                
                $this->session->set_flashdata('mensaje', array('error', 'Alerta: No Se pudo conectar con el WEB-SERVICE 2',"Intente mas tarde"));
                 redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'.$numero_prof);
                return ;
             
            }

    }    
    
    public function pagar_proforma_ose() {

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->session->set_flashdata('mensaje', array('error', 'Error al acceder a la ruta'));
            redirect($this->config->item('ip') . 'documentos/boletas_facturas');
            return;
        }

        $aux = $this->input->post('comprobante');
        $val = false;
        $ajax_proforma = json_decode($aux, true);
        // PROFORMA
        $tipo_prof = (!isset($ajax_proforma[0])) ? null : $ajax_proforma[0];
        $serie_prof = (!isset($ajax_proforma[1])) ? null : $ajax_proforma[1];
        $numero_prof = (!isset($ajax_proforma[2])) ? null : $ajax_proforma[2];

        $this->veri_tip_ser_num($tipo_prof, $serie_prof, $numero_prof);

        $detalles = "";

        //OBTENEMOS CABECERA E ITEMS DE LA PROFORMA
        $cliente = $this->Comprobante_pago_model->get_cabecera_boletafactura_sinpagar($tipo_prof, $serie_prof, $numero_prof);
        $descripcion = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar2($tipo_prof, $serie_prof, $numero_prof);

        // EVALUAMOS EL ESTADO DE LA PROFORMA
        if ($cliente['FSCESTADO'] != 0) {
            redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/' . $tipo_prof . '/' . $serie_prof . '/' . $numero_prof);
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: No se emitio comprobante debido a que la proforma ya fue emitida'));
            return;
        }

        $ruc = '20131911310';
        $str_tipo = ($tipo_prof == '1') ? '01' : '03';
        $str2 = $ruc . '-' . $str_tipo . '-';

        if ($cliente['FSCTIPO'] == 0) {
            $dato_sunat = 'B' . $cliente['FSCSERNRO'];
        } else {
            $dato_sunat = 'F' . $cliente['FSCSERNRO'];
        }
        //OBTENGO MAXIMO SUNAT(CORRELATIVO)
        $nro_sunat = $this->Comprobante_pago_model->max_nro_comprobante_sunat2($dato_sunat, $tipo_prof)['NRO'];
        $nro_sunat = ((is_null($nro_sunat) || empty($nro_sunat)) ? 0 : $nro_sunat) + 1;
        //OBTENGO MAXIMO SEDALIB (CORRELATIVO)
        $nro_sedalib = $this->Comprobante_pago_model->max_nro_comprobante_sedalib($cliente['FSCSERNRO'], $tipo_prof);
        $nro_sedalib = (is_null($nro_sedalib) || empty($nro_sedalib)) ? 1 : $nro_sedalib['NRO'] + 1;

        //SERIE
        $serie = $cliente['FSCSERNRO'];
        //PASO 1: OBTENEMOS LA ESTRUCTURA PARA EL ENVIO A WEB SERVICE
        $cmp = $this->obtener_estructura($cliente, $descripcion, $nro_sunat, $nro_sedalib);

        if ($cliente['FSCTIPO'] == 0) {
            $dato_sunat = 'B' . $cliente['FSCSERNRO'];
            $tipi = '03';
            $dato_nro = 'B' . $cliente['FSCSERNRO'] . '-' . str_pad($nro_sunat, 7, "0", STR_PAD_LEFT);
        } else {
            $dato_sunat = 'F' . $cliente['FSCSERNRO'];
            $tipi = '01';
            $dato_nro = 'F' . $cliente['FSCSERNRO'] . '-' . str_pad($nro_sunat, 7, "0", STR_PAD_LEFT);
        }
        
        $dir_file ="C:/v3.0_pruebas/conector/cpe/descargas/".$this->config->item('dir_cpes_externo') .$tipi.'-'.$dato_nro.'.xml';
        $dir_pdf ="C:/v3.0_pruebas/conector/cpe/descargas/".$this->config->item('dir_cpes_externo') .$tipi.'-'.$dato_nro.'.pdf';
        
        $resultado_sunat[3] = '';

        $res_emision = $this->verif_emision_ose($serie_prof, $numero_prof, $tipo_prof);
        
        $var = $this->Comprobante_pago_model->registrar_factura_metodo2($cliente, $descripcion, $serie, $nro_sunat, $nro_sedalib, $dir_file, $dir_pdf, $resultado_sunat[3]);
        
        try {
        
        if ($var) {
                       
            //if ($res_emision) {

                //$txt_respuesta = 'C:/v3.0/conector/cpe/txtrespuesta/20131911310-' . $tipi . '-' . $cliente['FSCSERNRO'] . '-'.$nro_sunat.'.txt';
            $txt_respuesta = 'C:/v3.0_pruebas/conector/cpe/txtrespuesta/20131911310-' . $tipi . '-' . $dato_nro . '.txt';
                
            if(file_exists($txt_respuesta)){
                
                
                $file = fopen($txt_respuesta, "r"); // or exit("No se encontro el archivo!");
                //Output a line of the file until the end is reached
                while (!feof($file)) {
                    $log_resultado = fgets($file) . ",";
                }
                fclose($file);

                if (substr($log_resultado, 0, 1) == '0') {

                    $rpta_sunat[] = 'xml enviado'; // posicion 1

                    $rpta_sunat[] = $_SERVER['REMOTE_ADDR'];  // posicion 2 ip de quien envia                                      

                    $rpta_sunat[] = date('l dS \of F Y h:i:s A'); // posicion 3 la fecha y hora de envio

                    $rpta_sunat[] = $rpta[1] . '-' . $rpta[0];

                    $rpta_sunat[] = '0';

                    $rpta_sunat[] = $log_resultado;

                    $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'], $nro_sedalib, $cliente['FSCTIPO'], $dato_sunat, $nro_sunat, $log_resultado);
                    //DE ACUERDO A LA RESPUESTA DE LA SUNAT GUARDO LOS ESTADOS 
                    $this->guardo_rpta_sunat_metodo2($rpta_sunat, $cliente, $nro_sedalib, $detalles, $tipo_prof, $serie_prof);
                    
                } else {
                    
                    //$log_resultado = implode(",", $e[0]);
                    $log_resultado = "SUNAT tardo en responder";
                    $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'], $nro_sedalib, $cliente['FSCTIPO'], $dato_sunat, $nro_sunat, $log_resultado);
                    //GUARDO ESTADO
                    $this->Comprobante_pago_model->actualizar_estado_sunat($cliente['FSCTIPO'], $cliente['FSCSERNRO'], $nro_sedalib, 6);
                    $detalles = $detalles . "* No se obtuvo ninguna respuesta de SUNAT <br>";

                    $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT tardo en responder', $detalles));
                    redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/' . $tipo_prof . '/' . $serie_prof . '/' . $nro_sedalib);
                    return;
                    
                }
            } else {
                
                $this->Comprobante_pago_model->actualizar_estado_sunat($cliente['FSCTIPO'], $cliente['FSCSERNRO'], $nro_sedalib,6);
                $detalles= $detalles."* No se encontro respuesta del OSE <br>";
                $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT tardo en responder',$detalles));
                redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'. $nro_sedalib );                              
            }
            
        } else {

            $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'], $nro_sedalib, $cliente['FSCTIPO'], $dato_sunat, $nro_sunat, "no se pudieron gravar los datos ");
            //echo "no se pudieron gravar los datos ";
            $this->session->set_flashdata('mensaje', array('error', 'ocurrio un problema,No se pudo guardar los datos ', $detalles));
            redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/' . $tipo_prof . '/' . $serie_prof . '/' . $numero_prof);
        }                                                    
        
        } catch (Exception $e) {
                $var = $this->Comprobante_pago_model->Gravar_Error($cliente['FSCSERNRO'], $nro_sedalib, $cliente['FSCTIPO'], $dato_sunat, $nro_sunat, "no se pudieron gravar los datos ");
                //echo "no se pudieron gravar los datos ";
                $this->session->set_flashdata('mensaje', array('error', 'EL OSE TARDO EN RESPONDER ', $e->getMessage()));
                redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/' . $tipo_prof . '/' . $serie_prof . '/' . $numero_prof);
        }

    }

    private function verif_emision_ose($serie_prof,$numero_prof,$tipo_prof) {                

        $cpe_ose = $this->Comprobante_pago_model->ose_gen_txt($serie_prof,$numero_prof,$tipo_prof);
        
        $nombre_archivo = 'C:/v3.0_pruebas/conector/cpe/txt/20131911310-'.$cpe_ose[0]['COM_TIPDOC'].'-'.$cpe_ose[0]['COM_SERCORR'].'.txt';                                    
        
        $file = fopen($nombre_archivo, "w");
                         
        $emi = $cpe_ose[0]['EMI_CODID'].'|';    //EMI
        $emi .= $cpe_ose[0]['EMI_RUC'].'|';   //RUC
        $emi .= $cpe_ose[0]['EMI_NOMCOM'].'|';   //NOMCOM
        $emi .= $cpe_ose[0]['EMI_LUGEXP'].'|';   //LUGEXP
        $emi .= $cpe_ose[0]['EMI_DOMFIS'].'|';   //DOMFIS
        $emi .= $cpe_ose[0]['EMI_URBA'].'|';   //URBA
        $emi .= $cpe_ose[0]['EMI_DIST'].'|';   //DIST
        $emi .= $cpe_ose[0]['EMI_PROV'].'|';   //PROV
        $emi .= $cpe_ose[0]['EMI_DEPT'].'|';   //DEPT
        $emi .= $cpe_ose[0]['EMI_CODPAIS'].'|';   //CODPAIS
        $emi .= $cpe_ose[0]['EMI_UBIGEO'].'|';   //UBIGEO
        $emi .= $cpe_ose[0]['EMI_RESER'].'|';   //RESER

        $rec = $cpe_ose[0]['REC_CODID'].'|';    //REC
        $rec .= $cpe_ose[0]['REC_TIPDOC'].'|';   //TIPCOD
        $rec .= $cpe_ose[0]['REC_RAZSOC'].'|';   //RAZSOC
        $rec .= $cpe_ose[0]['REC_DIRECC'].'|';   //DIRECC
        $rec .= $cpe_ose[0]['REC_DIST'].'|';   //DIST                  
        $rec .= $cpe_ose[0]['REC_PROV'].'|';   //PROV
        $rec .= $cpe_ose[0]['REC_DEPT'].'|';   //DEPT
        $rec .= $cpe_ose[0]['REC_CODPAIS'].'|';   //CODPAIS
        $rec .= $cpe_ose[0]['REC_UBIGEO'].'|';   //UBIGEO
        $rec .= $cpe_ose[0]['REC_TELEF'].'|';   //TELEF
        $rec .= $cpe_ose[0]['REC_NOTIF'].'|';   //NOTIF
        $rec .= $cpe_ose[0]['REC_EMAIL'].'|';   //EMAIL
        
        $com = $cpe_ose[0]['COM_CODID'].'|';   //COM
        $com .= $cpe_ose[0]['COM_FECHA_HORA'].'|';   //FECHA_EMISION
        $com .= $cpe_ose[0]['COM_TIPDOC'].'|';   //TIPDOC
        $com .= $cpe_ose[0]['COM_SERCORR'].'|';   //serie-correlativo
        $com .= $cpe_ose[0]['COM_TIPOPER'].'|';   //tipo de operacion
        $com .= $cpe_ose[0]['COM_FECVEC'].'|';   //fecha de vencimiento
        
        
        fwrite($file, $emi . PHP_EOL);
        fwrite($file, $rec . PHP_EOL);
        fwrite($file, $com . PHP_EOL);
        
        
        for ($index = 0; $index < count($cpe_ose[1]); $index++) {
            
            $plu = $cpe_ose[1][$index]['PLU_CODID'].'|';   //PLU
            $plu .= $cpe_ose[1][$index]['PLU1_NROORDEN'].'|';   //Nro de Orden
            $plu .= $cpe_ose[1][$index]['PLU2_CODITEM'].'|';   //Codigo de Item
            $plu .= $cpe_ose[1][$index]['PLU3_CODSUNAT'].'|';
            $plu .= $cpe_ose[1][$index]['PLU4_CODGS1'].'|';
            $plu .= $cpe_ose[1][$index]['PLU5_UNIMED'].'|';
            $plu .= $cpe_ose[1][$index]['PLU6_DESCRIP'].'|';
            $plu .= $cpe_ose[1][$index]['PLU7_CANT'].'|';
            $plu .= number_format(((float)$cpe_ose[1][$index]['PLU8_PUNI']/(int)$cpe_ose[1][$index]['PLU7_CANT']), 2, '.', '') .'|';
            $plu .= number_format(((float)$cpe_ose[1][$index]['PLU9_VALREFUNI']/(int)$cpe_ose[1][$index]['PLU7_CANT']), 2, '.', '').'|';
            $plu .= number_format((float)$cpe_ose[1][$index]['PLU10_PVENUNI'], 2, '.', '').'|';
            $plu .= number_format((float)$cpe_ose[1][$index]['PLU11_VALVEN'], 2, '.', '').'|';
            $plu .= $cpe_ose[1][$index]['PLU12_NUMPLACVEH'].'|';
            $plu .= number_format((float)$cpe_ose[1][$index]['PLU13_MONTOTINP'], 2, '.', '').'|';
            $plu .= PHP_EOL;
            
            $plu .= $cpe_ose[1][$index]['PLUG_CODID'].'|';
            $plu .= $cpe_ose[1][$index]['PLUG1_PORCIGV'].'|';
            $plu .= $cpe_ose[1][$index]['PLUG2_TIPIGV'].'|';
            $plu .= number_format((float)$cpe_ose[1][$index]['PLUG3_MONTOIGV'], 2, '.', '').'|';
            $plu .= number_format((float)$cpe_ose[1][$index]['PLUG4_FSCPRECIO'], 2, '.', '').'|';
            
            fwrite($file, $plu . PHP_EOL);
        }                   
        
        $tot = $cpe_ose[0]['TOT_CODID'].'|';   //TOT
        $tot .= number_format((float)$cpe_ose[0]['TOT1_SUMTOT_DESC'], 2, '.', '').'|';   
        $tot .= number_format((float)$cpe_ose[0]['TOT2_SUMTOT_OP_GRAT'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT3_TOT_VAL_VEN'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT4_ISC'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT5_TOT_IGV'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT6_TOT_IVAP'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT7_TOT_OTROS_TRIB'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT8_MONT_TOT_IMP'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT9_MONTO_REDONDEO'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT10_MON_ANTICIPOS'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT11_IMPTOT_VENTA'], 2, '.', '').'|';
        $tot .= number_format((float)$cpe_ose[0]['TOT12_IMPTOT_PAGAR'], 2, '.', '').'|';
                          
        $tots = $cpe_ose[0]['TOT_S_CODID'].'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_IGV'], 2, '.', '').'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_IVAP'], 2, '.', '').'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_EXON'], 2, '.', '').'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_INAF'], 2, '.', '').'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_GRAT'], 2, '.', '').'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_EXPORT'], 2, '.', '').'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_ISC'], 2, '.', '').'|';
        $tots .= number_format((float)$cpe_ose[0]['TOT_S_SUB_TOT_VEN_OTR_IMP'], 2, '.', '').'|';
        
                          
        $pag = $cpe_ose[0]['PAG_CODID'].'|';
        $pag .= $cpe_ose[0]['PAG_MET_PAG'].'|';
        $pag .= $cpe_ose[0]['PAG_FECH_INI_CIC_FAC'].'|';
        $pag .= $cpe_ose[0]['PAG_FECH_FINC_CIC_FAC'].'|';
        $pag .= $cpe_ose[0]['PAG_MONEDA'].'|';
        $pag .= $cpe_ose[0]['PAG_TIPO_CAMB'].'|';   
        
        if( $cpe_ose[0]['GRATUITO'] == 1){
            $leyenda = $cpe_ose[0]['PAG_LEYENDA'].'|1|';
            $leyenda .= 'LEYENDA'.'|';
            $leyenda .= 'TRANSFERENCIA GRATUITA'.'|';
 
        }else{
            if($cpe_ose[0]['CONORDPAG'] == 1){
                $leye2 = $cpe_ose[0]['PAG_LEYENDA'].'|1|';
                $leye2 .= 'LEYENDA'.'|';
                $leye2 .= 'NUEVOS SUMINISTROS'.'|';
            }
        }

        
      fwrite($file, $tot . PHP_EOL);
      fwrite($file, $tots . PHP_EOL);
      fwrite($file, $pag . PHP_EOL);
      if( $cpe_ose[0]['GRATUITO'] == 1){
        fwrite($file, $leyenda . PHP_EOL);
      }else{
        if($cpe_ose[0]['CONORDPAG'] == 1){
            fwrite($file, $leye2 . PHP_EOL); 
        }
      }

      fclose($file);
        
      //echo var_dump($cpe_ose);
       
      $txt_aceptado = 'C:/v3.0_pruebas/conector/cpe/txtaceptados/20131911310-'.$cpe_ose[0]['COM_TIPDOC'].'-'.$cpe_ose[0]['COM_SERCORR'].'.txt';                                 
                        
      $nowq = time();
      $last = time();

      for ($i = 0; $i < 15; $i++) {

          if(file_exists($txt_aceptado) || $last - $nowq > 15){

              $resultado = true;
              break;		
          
          } else {

              usleep(1200000);		
              $last = time();
              $resultado = false;		
          }      				
      }
      
      
      /*
      if(file_exists($txt_aceptado)){ 
                  //GUARDO LOS DATOS EN LA BD                    
          $resultado = true;        

      } else {
          $resultado = false;
      }        
      */
      
      
return $resultado;        

}
    
    
    private function guardo_rpta_sunat_metodo2($rpta_aux,$cliente,$nro_sedalib,$detalles,$tipo_prof,$serie_prof){
       if($rpta_aux[4] == '0'){
            $this->Comprobante_pago_model->actualizar_estado_sunat_metodo2( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,3 , $rpta_aux[5] );
            $this->Comprobante_pago_model->actualizar_respuesta_ws($cliente, $nro_sedalib, true, $rpta_aux[5]);          
            $this->enviar_correo($cliente['FSCTIPO'],$cliente['FSCSERNRO'],$nro_sedalib);
            $this->session->set_flashdata('msj_ws', array('error', 'La proforma ya se encuentra emitida', $rpta_aux));
            redirect($this->config->item('ip').'documentos/boletas_factura/mostrar/'.$cliente['FSCTIPO'].'/'.$cliente['FSCSERNRO'].'/'.$nro_sedalib);
        }else if($rpta_aux[4] == '2380'){
            $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,5,$rpta_aux[5] );
            $this->Comprobante_pago_model->actualizar_respuesta_ws($cliente, $nro_sedalib, true, $rpta_aux[5]);
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: El comprobante se encuentra con observaciones ',$detalles));
            redirect($this->config->item('ip') .'documentos/boletas_facturas/mostrar_pago/'.$cliente['FSCTIPO'].'/'.$cliente['FSCSERNRO'].'/'.$nro_sedalib);
        }else{
            $resultado = strpos($rpta_aux[4], $serie_prof);
            if($resultado !== FALSE){
                $this->Comprobante_pago_model->actualizar_estado_sunat_metodo2( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,3 , $rpta_aux[5] );
                $this->session->set_flashdata('msj_ws', array('error', 'La proforma ya se encuentra emitida', $rpta_aux));
                redirect($this->config->item('ip').'documentos/boletas_factura/mostrar/'.$cliente['FSCTIPO'].'/'.$cliente['FSCSERNRO'].'/'.$nro_sedalib);
            }else{
                $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,6,$rpta_aux[5] );
                $this->Comprobante_pago_model->actualizar_respuesta_ws($cliente, $nro_sedalib, true, $rpta_aux[5]);
                $this->session->set_flashdata('mensaje', array('error', 'Alerta:  SUNAT TARDO EN RESPONDER PERO PUEDE EMITIR COMPROBANTE',$detalles));
                redirect($this->config->item('ip') .'documentos/boletas_facturas/mostrar_pago/'.$cliente['FSCTIPO'].'/'.($cliente['FSCSERNRO']).'/'.$nro_sedalib);
            }          
            
        }
    }
    private function guardo_rpta_sunat($rpta_aux,$cliente,$nro_sedalib,$detalles,$tipo_prof,$serie_prof){
       if(!isset($rpta_aux[4])){
            $this->Comprobante_pago_model->actualizar_estado_sunat($cliente['FSCTIPO'], $cliente['FSCSERNRO'], $nro_sedalib,6);
            $detalles= $detalles."* No se obtuvo ninguna respuesta de SUNAT <br>";
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: SUNAT no atendio peticion',$detalles));
            redirect($this->config->item('ip') . 'documentos/boletas_facturas/mostrar_pago/'.$tipo_prof.'/'.$serie_prof.'/'. $nro_sedalib );
            return ;
                        
        }else if($rpta_aux[4] == '0'){
            $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,3);

            $this->Comprobante_pago_model->actualizar_respuesta_ws($cliente, $nro_sedalib, true, $rpta_aux[5]);
                      
            $this->enviar_correo($cliente['FSCTIPO'],$cliente['FSCSERNRO'],$nro_sedalib);
            $this->session->set_flashdata('msj_ws', array('error', 'La proforma ya se encuentra emitida', $rpta_aux));
            redirect($this->config->item('ip').'documentos/boletas_factura/mostrar/'.$cliente['FSCTIPO'].'/'.$cliente['FSCSERNRO'].'/'.$nro_sedalib);
        }else if($rpta_aux[4] == '2380'){
            $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,5);
            $this->Comprobante_pago_model->actualizar_respuesta_ws($cliente, $nro_sedalib, true, $rpta_aux[5]);
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: El comprobante se encuentra con observaciones ',$detalles));
            redirect($this->config->item('ip').'documentos/boletas_factura/mostrar/'.$cliente['FSCTIPO'].'/'.$cliente['FSCSERNRO'].'/'.$nro_sedalib);
        }else{
                      
            $this->Comprobante_pago_model->actualizar_estado_sunat( $cliente['FSCTIPO'],$cliente['FSCSERNRO'], $nro_sedalib,4);
            $this->Comprobante_pago_model->actualizar_respuesta_ws($cliente, $nro_sedalib, true, $rpta_aux[5]);
            $this->session->set_flashdata('mensaje', array('error', 'Alerta: El comprobante fue rechazado por la SUNAT ',$detalles));
            redirect($this->config->item('ip').'documentos/boletas_factura/mostrar/'.$cliente['FSCTIPO'].'/'.($cliente['FSCSERNRO']).'/'.$nro_sedalib);
        }
    }

    private function creo_pdf_xml_metodo2($pdf,$cliente,$nro_sedalib,$str2,$rpta,$bandera){
        $this->load->library('dompdf_pdf');
        $mipdf = $this->dompdf_pdf->cargar();
        $mipdf->set_paper('A5', 'landscape');
        $mipdf->load_html(utf8_decode($pdf));
        $mipdf->render();
        $output = $mipdf->output();
        $dir_pdf = $this->direccion_pdf.$str2.$rpta.'.pdf';
        file_put_contents($_SERVER['DOCUMENT_ROOT'].$this->nombre.$dir_pdf, $output);
        ob_flush();
        return $dir_pdf;
    }
    private function creo_pdf_xml($pdf,$cliente,$nro_sedalib,$dir_file,$str2,$rpta,$bandera){
        $this->load->library('dompdf_pdf');
        $mipdf = $this->dompdf_pdf->cargar();
        $mipdf->set_paper('A5', 'landscape');
        $mipdf->load_html(utf8_decode($pdf));
        $mipdf->render();
        $output = $mipdf->output();
        $dir_pdf = $this->direccion_pdf.$str2.$rpta['sunat'][0].'.pdf';
        file_put_contents($_SERVER['DOCUMENT_ROOT'].$this->nombre.$dir_pdf, $output);
        ob_flush();
        if($bandera==1){
          // GUARDAMOS LA DIRECCION DEL XML Y LA FIRMA
          $this->Comprobante_pago_model->actualizar_respuestaWS($cliente, $nro_sedalib, $dir_file, $dir_pdf);
          $this->Comprobante_pago_model->actualizar_estado_proforma($cliente);
        }else{
          $this->Comprobante_pago_model->actualizar_respuestaWS($cliente, $nro_sedalib, $dir_file, $dir_pdf);
        }
        

    }

    private function enviar_correo($tipo, $serie, $numero){
        $cab = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo, $serie, $numero);  
        // $this->direccion_pdf.'B130-005.pdf'
        $pathToUploadedFile = $_SERVER['DOCUMENT_ROOT'].$this->nombre.$cab['DIRARCHPDF'];
        $motivo = ($cab['FSCTIPO']==0)? 'SEDALIB SA - BOLETA DE VENTA ELECTRONICA':'SEDALIB SA - FACTURA ELECTRONICA';
        $mensaje = 'Usuario '.$cab['FSCCLINOMB'].' la empresa SEDALIB SA le esta entregando su comprobante de pago electronico.';
        // <center><img style="width=100px" src="'.base_url().'img/logo2.png'.'"></center>
        $mensaje = '<br><br><br><p> Usuario <strong>'.$cab['FSCCLINOMB'].'</strong></p>
                    <p>La empresa SEDALIB S.A. genero con exito su '.(($cab['FSCTIPO']=='0')? 'Boleta de Venta':'Factura').'.</p>
                    <p>En este correo estamos adjuntando su comprobante con la serie y numero: '.
                    $cab['SUNSERNRO'].'-'.str_pad($cab['SUNFACNRO'], 6, "0", STR_PAD_LEFT).   
                    '.</p>
                    <p>Atentamente</p>
                    <p>SEDALIB S.A.</p>
                    <hr style="border:none;background:#296fb7;height:2px"><center><h4>SEDALIB S.A. '.date('Y').'</h4></center>';
        
        // PRUEBA CON CODEIGNITER
        $this->load->library("email");
        $configGmail = array(
                     'protocol' => 'smtp',
                     'smtp_host' => 'mail.sedalib.com.pe',
                     'smtp_port' => 25,
                     'smtp_user' => 'cpe@sedalib.com.pe',
                     'smtp_pass' => 'C53abc123@*.',
                     'mailtype' => 'html',
                     'charset' => 'utf-8',
                     'wordwrap' => false,
                     'newline' => "\r\n"
                     );
                     $this->email->initialize($configGmail);
                     $this->email->set_newline("\r\n");
                     $this->email->from('cpe@sedalib.com.pe');
                     $this->email->to($cab['EMAIL']);//'cpe@sedalib.com.pe');//
                     $this->email->subject($motivo);
                     $this->email->message($mensaje);
                     $this->email->attach($pathToUploadedFile);
                     $this->email->send();
        // ==================================================== /
    }

    private function enviar_ws($tipo, $serie, $numero, $client, $cliente, $descripcion, $cliente1, $descripcion1){
        try {
            $cmp = $this->obtener_estructura1($cliente1, $descripcion1, $cliente, $descripcion);
            //var_dump($cmp);
            $result = $client->metodo1($cmp[0], $cmp[1]);
            //var_dump($result);
            return array('resultado'=>true, 'sunat'=>array($cmp[0][6], $cmp[0][14], $cmp[0][27], $cmp[0][28]), 'rpta'=>$result);
        } catch (Exception $e) {
            return array('resultado'=>false, 'rpta'=>$e);
        }
    }

    private function enviar_sunat($mensaje, $client){
        try {
            $result = $client->metodo6($mensaje);
            return array('resultado'=>true, 'rpta'=>$result);
        } catch (Exception $e) {
            return array('resultado'=>false, 'rpta'=>$e);
        }
    }

    private function generar_pdf($cab,$det, $numero_sedalib,$nro_sunat, $firma){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);

        //$documento = json_decode($var, true);
        //$cab = $this->Comprobante_pago_model->get_cabecera_proforma($tipo, $serie, $numero);
        //$det = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar($tipo, $serie, $numero);

        //$cab = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo, $serie, $numero);
        //$det = $this->Comprobante_pago_model->get_descripcion_boletafactura($tipo, $serie, $numero);
        //$serie_pdf=$serie;
        //var_dump($cab);

        $serie = ($cab['FSCTIPO']==1)? "F".$cab['FSCSERNRO']."-":"B".$cab['FSCSERNRO']."-";//($cab['FSCTIPO']==1)? "FF11-":"BB11-";
        
        $cabecera[0] = $tvvog = floatval($cab['FSCSUBTOTA']); //SUB TOTAL'59.32'; $tvvog =  '';
        $cabecera[1] = $montoletras = $ntt->numtoletras($cab['FSCTOTAL']); //TOTAL CON PRECIO 'SETENTA CON 00/100';
        $cabecera[2] = $tvvoi = 0;
        $cabecera[3] = $tvvoe = '';
        $cabecera[4] = $tvvogr = 0;
        $cabecera[5] = $totdesc = '';
        $cabecera[6] = $s_num = $serie.str_pad($nro_sunat, 6, "0", STR_PAD_LEFT);//'FF11-101'; +1000// SERIE - NUMERO
        $cabecera[7] = $fecEmision = date("Y-m-d"); //'2016-10-17'; 
        $cabecera[8] = $tipMoneda = 'PEN';
        $cabecera[9] = $rucCliente = ($cab['FSCTIPDOC']!=6)? trim($cab['FSCNRODOC']):trim($cab['FSCCLIRUC']); //'10415562824';
        $cabecera[10] = $tipDocCliente = $cab['FSCTIPDOC'];//($cab['FSCTIPDOC']==1)?  "1":"6"; // 6:DNI 1:RUC TIPO DE DOCUMENTO;
        $cabecera[11] = $nomCliente = $this->sanear_string($cab['FSCCLINOMB']);//'JOSE MERCEDES VENEGAS ACEVEDO';
        $cabecera[12] = $monto_total_igv = floatval($cab['FSCSUBIGV']);// SUB TOTAL IGV'10.68';
        $cabecera[13] = $importe_total = floatval($cab['FSCTOTAL']);
        $cabecera[14] = $invoiceTypeCode = ($cab['FSCTIPO']==1)? "01":"03";//"PROFORMA-FACTURA":"PROFORMA-BOLETA";//'01';  

        $cabecera[15] = $adi_cabecera = '0';        
        $cabecera[16] = $adi_base = '1'; 

        $cabecera[17] = $direCliente = $cab['FSDIREC']; 

        $cabecera[18] = $oficina = ''; 
        $cabecera[19] = $usuario = $_SESSION['user_nom']; 
        $cabecera[20] = $docReferencia = ''; 

        $cabecera[21] = $anticipo = ''; 
        $cabecera[22] = $descuentoGlobal = ''; 

        $cabecera[23] = $otrosTributos = ''; 
        $cabecera[24] = $otrosCargos = '';

        $cabecera[25] = $numeroguiaremitente = '';  //0001-002020 

        $cabecera[26] = $numeroguiatransportista = '';  //0001-002020 

        $cabecera[27] = $ambiente = 'produccion';  //valores 'homologacion','beta','produccion'

        $cabecera[28] = $tipo = '1';  // Factura. Notas vinculadas. Servicios Públicos. Resumen Diario. Comunicación de Baja. Lotes de Facturas.

        $guia_rem = '';
        $guia_trans = '';

        $detalle = array();
        $i=0;
        foreach ($det as $conep) {
            //Item 1
            //var_dump($conep);
            $afecigv = ($conep['EXONERADO'] == '1')? '20':
                        (  ($conep['AFECIGV']=='S')? '10': '30' );
            $con_igv = ($afecigv == '10');
            $precio = $this->calcular_precio($conep['PUNIT'], $conep['CANT'], ($con_igv), ($conep['GRAT']=='1') );
            //var_dump($precio);
            $i++;
            $aux[0] = $item = $i;  // iten
            $aux[1] = $cantidad = $conep['CANT'];//'10';  // cantidad 
            $aux[2] = $valVenta = $conep['FSCPRECIO'];//'42.37';  // valor de venta por item LineExtensionAmount
            $aux[3] = $precioVenta = floatval($conep['PUNIT']);//'5.00';  // Precio de Venta Alternative Condition Price
            $aux[4] = $codTipoPrecio = '01';  // Price Type Code //
            $aux[5] = $IGVItem = floatval($conep['PRECIGV']);//'7.63';  // IGV del Item TaxTotal, taxAmount taxSubtotal, taxAmount
            $aux[6] = $exemptionReasonCode = (floatval($conep['PRECIGV'])!=0)? '10':'20';  // Tax Exemption Reason Code 10 - IGV, 20 Exonerado - Operaciones Onerosas
            
            if($conep['GRAT']=='1'){ 
                $tvvogr += $precio['UNIT_SINIGV'];
            }if($exemptionReasonCode == '30'){
                $tvvoi += $precio['UNIT_SINIGV'];
            }


            $aux[7] = $ID = '1000';  // ID del impuesto
            $aux[8] = $ImpuestoIGV = 'IGV';  // Impuesto IGV
            $aux[9] = $CodSunat = 'VAT';  // Codigo en SUNAT
            $aux[10] = $descripcion = $this->sanear_string($conep['FACCONDES']);//'Concepto 1 o Producto 1';  // description
            $aux[11] = $ID = $conep['FACCONCOD'];//'ART1';  // Codigo del concepto producto en los sistemas internos
            $aux[12] = $ID = $precio['UNIT_SINIGV'];//'4.24';  // Precio del Item sin IGV
            $aux[13] = $unidades = 'NIU';
            $aux['GRAT'] = $conep['GRAT'];
            $aux['AFECIGV'] = $conep['AFECIGV'];
            
            array_push($detalle, $aux);
        }
        $html = '';

        $cabecera[0] = $tvvog = ($tvvog==0)? '':$tvvog;
        $cabecera[2] = $tvvoi = ($tvvoi==0)? '':$tvvoi;
        $cabecera[12] = $monto_total_igv = ($monto_total_igv==0)? '0.00':$monto_total_igv;
        $cabecera[13] = $importe_total = ($importe_total==0)? '0.00':$importe_total;


        $cusAssignedAccountID = '20131911310';
        $qrfile = $this->creo_QR($cusAssignedAccountID,$invoiceTypeCode,$s_num,$monto_total_igv,$importe_total,$fecEmision,$tipDocCliente,$rucCliente);
        $html = $this->facturax( $serie, $numero_sedalib,$cab['FSCTIPO'], $cab['OBSDOC'], $firma, $cab['TIPDOCDESCABR'], $adi_cabecera, $adi_base, $tvvog, $montoletras, $tvvoi, $tvvoe, $tvvogr, $totdesc, $s_num, $fecEmision, $tipMoneda, $rucCliente, $tipDocCliente, $nomCliente, $monto_total_igv, $importe_total, $detalle,$direCliente,$oficina,$usuario,$docReferencia,$invoiceTypeCode,$anticipo,$descuentoGlobal,$guia_rem,$guia_trans);
        
        return $html;
    }


    private function generar_pdf1($cab1,$det1, $cab,$det, $firma){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);

        //$documento = json_decode($var, true);
        //$cab = $this->Comprobante_pago_model->get_cabecera_proforma($tipo, $serie, $numero);
        //$det = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar($tipo, $serie, $numero);

        //$cab = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo, $serie, $numero);
        //$det = $this->Comprobante_pago_model->get_descripcion_boletafactura($tipo, $serie, $numero);
        //$serie_pdf=$serie;
        //var_dump($cab);

        $serie = $cab1['SUNFACNRO']."-";//($cab['FSCTIPO']==1)? "FF11-":"BB11-";
        
        $cabecera[0] = $tvvog = floatval($cab['FSCSUBTOTA']); //SUB TOTAL'59.32'; $tvvog =  '';
        $cabecera[1] = $montoletras = $ntt->numtoletras($cab['FSCTOTAL']); //TOTAL CON PRECIO 'SETENTA CON 00/100';
        $cabecera[2] = $tvvoi = 0;
        $cabecera[3] = $tvvoe = '';
        $cabecera[4] = $tvvogr = 0;
        $cabecera[5] = $totdesc = '';
        $cabecera[6] = $s_num = $serie.str_pad($cab1['SUNFACNRO'], 6, "0", STR_PAD_LEFT);//'FF11-101'; +1000// SERIE - NUMERO
        $cabecera[7] = $fecEmision = ($cab1['FSCTIPDOC']!=6)? trim($cab1['FSCNRODOC']):trim($cab1['FSCCLIRUC']); //'2016-10-17'; 
        $cabecera[8] = $tipMoneda = 'PEN';
        $cabecera[9] = $rucCliente = ($cab['FSCTIPDOC']!=6)? trim($cab['FSCNRODOC']):trim($cab['FSCCLIRUC']); //'10415562824';
        $cabecera[10] = $tipDocCliente = $cab['FSCTIPDOC'];//($cab['FSCTIPDOC']==1)?  "1":"6"; // 6:DNI 1:RUC TIPO DE DOCUMENTO;
        $cabecera[11] = $nomCliente = $this->sanear_string($cab['FSCCLINOMB']);//'JOSE MERCEDES VENEGAS ACEVEDO';
        $cabecera[12] = $monto_total_igv = floatval($cab['FSCSUBIGV']);// SUB TOTAL IGV'10.68';
        $cabecera[13] = $importe_total = floatval($cab['FSCTOTAL']);
        $cabecera[14] = $invoiceTypeCode = ($cab['FSCTIPO']==1)? "01":"03";//"PROFORMA-FACTURA":"PROFORMA-BOLETA";//'01';  

        $cabecera[15] = $adi_cabecera = '0';        
        $cabecera[16] = $adi_base = '1'; 

        $cabecera[17] = $direCliente = $cab['FSDIREC']; 

        $cabecera[18] = $oficina = ''; 
        $cabecera[19] = $usuario = $_SESSION['user_nom']; 
        $cabecera[20] = $docReferencia = ''; 

        $cabecera[21] = $anticipo = ''; 
        $cabecera[22] = $descuentoGlobal = ''; 

        $cabecera[23] = $otrosTributos = ''; 
        $cabecera[24] = $otrosCargos = '';

        $cabecera[25] = $numeroguiaremitente = '';  //0001-002020 

        $cabecera[26] = $numeroguiatransportista = '';  //0001-002020 

        $cabecera[27] = $ambiente = 'produccion';  //valores 'homologacion','beta','produccion'

        $cabecera[28] = $tipo = '1';  // Factura. Notas vinculadas. Servicios Públicos. Resumen Diario. Comunicación de Baja. Lotes de Facturas.

        $guia_rem = '';
        $guia_trans = '';

        $detalle = array();
        $i=0;
        foreach ($det as $conep) {
            //Item 1
            //var_dump($conep);
            $afecigv = ($conep['EXONERADO'] == '1')? '20':
                        (  ($conep['AFECIGV']=='S')? '10': '30' );
            $con_igv = ($afecigv == '10');
            $precio = $this->calcular_precio($conep['PUNIT'], $conep['CANT'], ($con_igv), ($conep['GRAT']=='1') );
            //var_dump($precio);
            $i++;
            $aux[0] = $item = $i;  // iten
            $aux[1] = $cantidad = $conep['CANT'];//'10';  // cantidad 
            $aux[2] = $valVenta = $conep['FSCPRECIO'];//'42.37';  // valor de venta por item LineExtensionAmount
            $aux[3] = $precioVenta = floatval($conep['PUNIT']);//'5.00';  // Precio de Venta Alternative Condition Price
            $aux[4] = $codTipoPrecio = '01';  // Price Type Code //
            $aux[5] = $IGVItem = floatval($conep['PRECIGV']);//'7.63';  // IGV del Item TaxTotal, taxAmount taxSubtotal, taxAmount
            $aux[6] = $exemptionReasonCode = (floatval($conep['PRECIGV'])!=0)? '10':'20';  // Tax Exemption Reason Code 10 - IGV, 20 Exonerado - Operaciones Onerosas
            
            if($conep['GRAT']=='1'){ 
                $tvvogr += $precio['UNIT_SINIGV'];
            }if($exemptionReasonCode == '30'){
                $tvvoi += $precio['UNIT_SINIGV'];
            }


            $aux[7] = $ID = '1000';  // ID del impuesto
            $aux[8] = $ImpuestoIGV = 'IGV';  // Impuesto IGV
            $aux[9] = $CodSunat = 'VAT';  // Codigo en SUNAT
            $aux[10] = $descripcion = $this->sanear_string($conep['FACCONDES']);//'Concepto 1 o Producto 1';  // description
            $aux[11] = $ID = $conep['FACCONCOD'];//'ART1';  // Codigo del concepto producto en los sistemas internos
            $aux[12] = $ID = $precio['UNIT_SINIGV'];//'4.24';  // Precio del Item sin IGV
            $aux[13] = $unidades = 'NIU';
            $aux['GRAT'] = $conep['GRAT'];
            $aux['AFECIGV'] = $conep['AFECIGV'];
            
            array_push($detalle, $aux);
        }
        $html = '';

        $cabecera[0] = $tvvog = ($tvvog==0)? '':$tvvog;
        $cabecera[2] = $tvvoi = ($tvvoi==0)? '':$tvvoi;
        $cabecera[12] = $monto_total_igv = ($monto_total_igv==0)? '0.00':$monto_total_igv;
        $cabecera[13] = $importe_total = ($importe_total==0)? '0.00':$importe_total;


        $cusAssignedAccountID = '20131911310';
        $qrfile = $this->creo_QR($cusAssignedAccountID,$invoiceTypeCode,$s_num,$monto_total_igv,$importe_total,$fecEmision,$tipDocCliente,$rucCliente);
        $html = $this->facturax( $serie, $cab1['SUNFACNRO'] ,$cab['FSCTIPO'], $cab['OBSDOC'], $firma, $cab['TIPDOCDESCABR'], $adi_cabecera, $adi_base, $tvvog, $montoletras, $tvvoi, $tvvoe, $tvvogr, $totdesc, $s_num, $fecEmision, $tipMoneda, $rucCliente, $tipDocCliente, $nomCliente, $monto_total_igv, $importe_total, $detalle,$direCliente,$oficina,$usuario,$docReferencia,$invoiceTypeCode,$anticipo,$descuentoGlobal,$guia_rem,$guia_trans);
        
        return $html;
    }
    private function obtener_estructura($cab,$det,$nro_sunat,$nro_sedalib){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);
        $cab['SUNFACNRO'] = $nro_sunat ;
        date_default_timezone_set('America/Lima');
        $serie = ($cab['FSCTIPO']==1)? "F".$cab['FSCSERNRO']."-":"B".$cab['FSCSERNRO']."-";//($cab['FSCTIPO']==1)? "FF11-":"BB11-";
        if($cab['CONCEPT_GRATUITO'] == 1){
            $cabecera[0] = $tvvog = 0;//(floatval($cab['FSCSUBTOTA']) > 0 ) ? floatval($cab['FSCSUBTOTA']) : 0 ; //SUB TOTAL'59.32'; $tvvog =  '';
            $cabecera[1] = $montoletras =  $ntt->numtoletras(0); //TOTAL CON PRECIO 'SETENTA CON 00/100';   
            $cabecera[2] = $tvvoi = 0;//(floatval($cab['FSCTOTAL_INAF'])> 0) ? floatval($cab['FSCTOTAL_INAF']) : 0 ;
            $cabecera[3] = $tvvoe = 0;//(floatval($cab['FSCTOTAL_EXO'])> 0) ? floatval($cab['FSCTOTAL_EXO']) : 0;
            $cabecera[4] = $tvvogr = floatval($cab['FSCTOTAL']) ;//(floatval($cab['FSCTOTAL_GRATUITO'])> 0) ? floatval($cab['FSCTOTAL_GRATUITO']) : 0;  
        }else{
            $cabecera[0] = $tvvog =(floatval($cab['FSCSUBTOTA']) > 0 ) ? floatval($cab['FSCSUBTOTA']) : 0 ; //SUB TOTAL'59.32'; $tvvog =  '';
            $cabecera[1] = $montoletras =  $ntt->numtoletras($cab['FSCTOTAL']); //TOTAL CON PRECIO 'SETENTA CON 00/100';
            $cabecera[2] = $tvvoi = (floatval($cab['FSCTOTAL_INAF'])> 0) ? floatval($cab['FSCTOTAL_INAF']) : 0 ;
            $cabecera[3] = $tvvoe = (floatval($cab['FSCTOTAL_EXO'])> 0) ? floatval($cab['FSCTOTAL_EXO']) : 0;
            $cabecera[4] = $tvvogr =  0;
        }

        $cabecera[5] = $totdesc = '';
        $cabecera[6] = $s_num = $serie.str_pad($cab['SUNFACNRO'], 6, "0", STR_PAD_LEFT);//'FF11-101'; +1000// SERIE - NUMERO
        $cabecera[7] = $fecEmision = date("Y-m-d"); //'2016-10-17'; 
        $cabecera[8] = $tipMoneda = 'PEN';
        $cabecera[9] = $rucCliente = ($cab['FSCTIPDOC']!=6)? trim($cab['FSCNRODOC']):trim($cab['FSCCLIRUC']); //'10415562824';
        $cabecera[10] = $tipDocCliente = $cab['FSCTIPDOC']; //($cab['FSCTIPDOC']=='1')?  "1":"6"; // 1:DNI 6:RUC TIPO DE DOCUMENTO;
        $cabecera[11] = $nomCliente = $this->sanear_string($cab['FSCCLINOMB']);//'JOSE MERCEDES VENEGAS ACEVEDO';
        $cabecera[12] = $monto_total_igv = ($cab['CONCEPT_GRATUITO'] == 1) ? 0 : floatval($cab['FSCSUBIGV']);// SUB TOTAL IGV'10.68';
        $cabecera[13] = $importe_total = ($cab['CONCEPT_GRATUITO'] == 1) ? 0 : floatval($cab['FSCTOTAL']);
        $cabecera[14] = $invoiceTypeCode = ($cab['FSCTIPO']==1)? "01":"03";//"PROFORMA-FACTURA":"PROFORMA-BOLETA";//'01';  

        $cabecera[15] = $adi_cabecera = '0';        
        $cabecera[16] = $adi_base = '1'; 

        $cabecera[17] = $direCliente = $cab['FSDIREC']; 

        $cabecera[18] = $oficina = ''; 
        $cabecera[19] = $usuario = $_SESSION['user_nom']; 
        $cabecera[20] = $docReferencia = ''; 

        $cabecera[21] = $anticipo = ''; 
        $cabecera[22] = $descuentoGlobal = ''; 

        $cabecera[23] = $otrosTributos = ''; 
        $cabecera[24] = $otrosCargos = '';

        $cabecera[25] = $numeroguiaremitente = '';  //0001-002020 

        $cabecera[26] = $numeroguiatransportista = '';  //0001-002020 

        $cabecera[27] = $ambiente = 'produccion';  //valores 'homologacion','beta','produccion'

        $cabecera[28] = $tipo = '1';  // Factura. Notas vinculadas. Servicios Públicos. Resumen Diario. Comunicación de Baja. Lotes de Facturas.



        $guia_rem = '';
        $guia_trans = '';

        $detalle = array();
        $i=0;
        foreach ($det as $conep) {
            
            $con_igv = $cab['TIP_AFEC_IGV'];
            $precio = $this->calcular_precio( $conep['PUNIT'], $conep['CANT'], $con_igv, $conep['GRAT'] );
            $i++;
            $aux[0] = $item = $i;  // iten
            $aux[1] = $cantidad = $conep['CANT'];//'10';  // cantidad 
            $aux[2] = $valVenta = ($conep['GRAT'] == '1') ? 0 : floatval($conep['FSCPRECIO']);//'42.37';  // valor de venta por item LineExtensionAmount
            $aux[3] = $precioVenta = floatval($conep['PUNIT']);//'5.00';  // Precio de Venta Alternative Condition Price
            $aux[4] = $codTipoPrecio = ($conep['GRAT'] == '1') ? '02' : '01';  // Price Type Code //
            $aux[5] = $IGVItem = ($conep['GRAT'] == '1') ? 0 : floatval($conep['PRECIGV']);//'7.63';  // IGV del Item TaxTotal, taxAmount taxSubtotal, taxAmount
            $aux[6] = $exemptionReasonCode =$cab['TIP_AFEC_IGV'];  // Tax Exemption Reason Code 10 - IGV, 20 Exonerado - Operaciones Onerosas
            
            $aux[7] = $ID = '1000';  // ID del impuesto
            $aux[8] = $ImpuestoIGV = 'IGV';  // Impuesto IGV
            $aux[9] = $CodSunat = 'VAT';  // Codigo en SUNAT
            $aux[10] = $descripcion = $this->sanear_string($conep['FACCONDES']);//'Concepto 1 o Producto 1';  // description
            $aux[11] = $ID = $conep['FACCONCOD'];//'ART1';  // Codigo del concepto producto en los sistemas internos
            $aux[12] = $ID = ($conep['GRAT'] == '1')? 0:$precio['UNIT_SINIGV'];//'4.24';  // Precio del Item sin IGV
            $aux[13] = $unidades = 'NIU';
        
            array_push($detalle, $aux);
        }
        $html = '';

        $cabecera[0] = $tvvog = ($tvvog==0)? '':$tvvog;
        $cabecera[2] = $tvvoi = ($tvvoi==0)? '':$tvvoi;
        $cabecera[12] = $monto_total_igv = ($monto_total_igv==0)? '0.00':$monto_total_igv;
        $cabecera[13] = $importe_total = ($importe_total==0)? '0.00':$importe_total;
        
        return array($cabecera, $detalle);
    }


    private function obtener_estructura1($cab,$det, $cab1, $det1){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);
        $cab['SUNFACNRO'] = $cab1['SUNFACNRO'] ;
        date_default_timezone_set('America/Lima');
        $serie = $cab1['SUNSERNRO']."-";//($cab['FSCTIPO']==1)? "FF11-":"BB11-";
        if($cab['CONCEPT_GRATUITO'] == 1){
            $cabecera[0] = $tvvog = 0;//(floatval($cab['FSCSUBTOTA']) > 0 ) ? floatval($cab['FSCSUBTOTA']) : 0 ; //SUB TOTAL'59.32'; $tvvog =  '';
            $cabecera[1] = $montoletras =  $ntt->numtoletras(0); //TOTAL CON PRECIO 'SETENTA CON 00/100';   
            $cabecera[2] = $tvvoi = 0;//(floatval($cab['FSCTOTAL_INAF'])> 0) ? floatval($cab['FSCTOTAL_INAF']) : 0 ;
            $cabecera[3] = $tvvoe = 0;//(floatval($cab['FSCTOTAL_EXO'])> 0) ? floatval($cab['FSCTOTAL_EXO']) : 0;
            $cabecera[4] = $tvvogr = floatval($cab['FSCTOTAL']) ;//(floatval($cab['FSCTOTAL_GRATUITO'])> 0) ? floatval($cab['FSCTOTAL_GRATUITO']) : 0;  
        }else{
            $cabecera[0] = $tvvog =(floatval($cab['FSCSUBTOTA']) > 0 ) ? floatval($cab['FSCSUBTOTA']) : 0 ; //SUB TOTAL'59.32'; $tvvog =  '';
            $cabecera[1] = $montoletras =  $ntt->numtoletras($cab['FSCTOTAL']); //TOTAL CON PRECIO 'SETENTA CON 00/100';
            $cabecera[2] = $tvvoi = (floatval($cab['FSCTOTAL_INAF'])> 0) ? floatval($cab['FSCTOTAL_INAF']) : 0 ;
            $cabecera[3] = $tvvoe = (floatval($cab['FSCTOTAL_EXO'])> 0) ? floatval($cab['FSCTOTAL_EXO']) : 0;
            $cabecera[4] = $tvvogr =  0;
        }

        $cabecera[5] = $totdesc = '';
        $cabecera[6] = $s_num = $serie.str_pad($cab1['SUNFACNRO'], 6, "0", STR_PAD_LEFT);//'FF11-101'; +1000// SERIE - NUMERO
        $cabecera[7] = $fecEmision = substr($cab1['FSCFECH'],6,4)."-".substr($cab1['FSCFECH'],3,2)."-".substr($cab1['FSCFECH'],0,2); //'2016-10-17'; 
        $cabecera[8] = $tipMoneda = 'PEN';
        $cabecera[9] = $rucCliente = ($cab['FSCTIPDOC']!=6)? trim($cab['FSCNRODOC']):trim($cab['FSCCLIRUC']); //'10415562824';
        $cabecera[10] = $tipDocCliente = $cab['FSCTIPDOC']; //($cab['FSCTIPDOC']=='1')?  "1":"6"; // 1:DNI 6:RUC TIPO DE DOCUMENTO;
        $cabecera[11] = $nomCliente = $this->sanear_string($cab['FSCCLINOMB']);//'JOSE MERCEDES VENEGAS ACEVEDO';
        $cabecera[12] = $monto_total_igv = ($cab['CONCEPT_GRATUITO'] == 1) ? 0 : floatval($cab['FSCSUBIGV']);// SUB TOTAL IGV'10.68';
        $cabecera[13] = $importe_total = ($cab['CONCEPT_GRATUITO'] == 1) ? 0 : floatval($cab['FSCTOTAL']);
        $cabecera[14] = $invoiceTypeCode = ($cab['FSCTIPO']==1)? "01":"03";//"PROFORMA-FACTURA":"PROFORMA-BOLETA";//'01';  

        $cabecera[15] = $adi_cabecera = '0';        
        $cabecera[16] = $adi_base = '1'; 

        $cabecera[17] = $direCliente = $cab['FSDIREC']; 

        $cabecera[18] = $oficina = ''; 
        $cabecera[19] = $usuario = $_SESSION['user_nom']; 
        $cabecera[20] = $docReferencia = ''; 

        $cabecera[21] = $anticipo = ''; 
        $cabecera[22] = $descuentoGlobal = ''; 

        $cabecera[23] = $otrosTributos = ''; 
        $cabecera[24] = $otrosCargos = '';

        $cabecera[25] = $numeroguiaremitente = '';  //0001-002020 

        $cabecera[26] = $numeroguiatransportista = '';  //0001-002020 

        $cabecera[27] = $ambiente = 'produccion';  //valores 'homologacion','beta','produccion'

        $cabecera[28] = $tipo = '1';  // Factura. Notas vinculadas. Servicios Públicos. Resumen Diario. Comunicación de Baja. Lotes de Facturas.



        $guia_rem = '';
        $guia_trans = '';

        $detalle = array();
        $i=0;
        foreach ($det as $conep) {
            
            $con_igv = $cab['TIP_AFEC_IGV'];
            $precio = $this->calcular_precio( $conep['PUNIT'], $conep['CANT'], $con_igv, $conep['GRAT'] );
            $i++;
            $aux[0] = $item = $i;  // iten
            $aux[1] = $cantidad = $conep['CANT'];//'10';  // cantidad 
            $aux[2] = $valVenta = ($conep['GRAT'] == '1') ? 0 : floatval($conep['FSCPRECIO']);//'42.37';  // valor de venta por item LineExtensionAmount
            $aux[3] = $precioVenta = floatval($conep['PUNIT']);//'5.00';  // Precio de Venta Alternative Condition Price
            $aux[4] = $codTipoPrecio = ($conep['GRAT'] == '1') ? '02' : '01';  // Price Type Code //
            $aux[5] = $IGVItem = ($conep['GRAT'] == '1') ? 0 : floatval($conep['PRECIGV']);//'7.63';  // IGV del Item TaxTotal, taxAmount taxSubtotal, taxAmount
            $aux[6] = $exemptionReasonCode =$cab['TIP_AFEC_IGV'];  // Tax Exemption Reason Code 10 - IGV, 20 Exonerado - Operaciones Onerosas
            
            $aux[7] = $ID = '1000';  // ID del impuesto
            $aux[8] = $ImpuestoIGV = 'IGV';  // Impuesto IGV
            $aux[9] = $CodSunat = 'VAT';  // Codigo en SUNAT
            $aux[10] = $descripcion = $this->sanear_string($conep['FACCONDES']);//'Concepto 1 o Producto 1';  // description
            $aux[11] = $ID = $conep['FACCONCOD'];//'ART1';  // Codigo del concepto producto en los sistemas internos
            $aux[12] = $ID = ($conep['GRAT'] == '1')? 0:$precio['UNIT_SINIGV'];//'4.24';  // Precio del Item sin IGV
            $aux[13] = $unidades = 'NIU';
        
            array_push($detalle, $aux);
        }
        $html = '';

        $cabecera[0] = $tvvog = ($tvvog==0)? '':$tvvog;
        $cabecera[2] = $tvvoi = ($tvvoi==0)? '':$tvvoi;
        $cabecera[12] = $monto_total_igv = ($monto_total_igv==0)? '0.00':$monto_total_igv;
        $cabecera[13] = $importe_total = ($importe_total==0)? '0.00':$importe_total;
        
        return array($cabecera, $detalle);
    }

    public function imprimir_ticket($tipo, $serie, $numero){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);
        $cab = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo, $serie, $numero);
        $det = $this->Comprobante_pago_model->get_descripcion_boletafactura($tipo, $serie, $numero);
        $usuario = $this->Catalogo_model->get_usuario($cab['FSCUSRPAG']);
        $oficina = $this->Catalogo_model->get_oficina2($cab['FSCREGION'], $cab['FSCZONA'], $cab['FSCLOCALID']);
        if($cab['CONCEPT_GRATUITO']==1){
            $letra = $ntt->numtoletras(0);
        }else{
            $letra = $ntt->numtoletras($cab['FSCTOTAL']);
        }
        $qr = $this->config->item('ip').$this->direccion_qrtemp.$cab['SUNSERNRO'].'-'.str_pad($cab['SUNFACNRO'], 6, "0", STR_PAD_LEFT).'.png';
        $this->load->view("template/Ticket", array('cab'=>$cab, 'descripcion'=>$det, 'usuario'=>$usuario, 'oficina'=>$oficina, 'copia'=>false, 'total_letra'=>$letra, 'imagen'=>$qr));
    }
    
    public function imprimir_copia_ticket($tipo, $serie, $numero){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);
        $cab = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo, $serie, $numero);
        $det = $this->Comprobante_pago_model->get_descripcion_boletafactura($tipo, $serie, $numero);
        $usuario = $this->Catalogo_model->get_usuario($cab['FSCUSRPAG']);
        $oficina = $this->Catalogo_model->get_oficina2($cab['FSCREGION'], $cab['FSCZONA'], $cab['FSCLOCALID']);
        if($cab['CONCEPT_GRATUITO']==1){
            $letra = $ntt->numtoletras(0);
        }else{
            $letra = $ntt->numtoletras($cab['FSCTOTAL']);
        }
        $qr = $this->config->item('ip').$this->direccion_qrtemp.$cab['SUNSERNRO'].'-'.str_pad($cab['SUNFACNRO'], 6, "0", STR_PAD_LEFT).'.png';
        $this->load->view("template/Ticket", array('cab'=>$cab, 'descripcion'=>$det, 'usuario'=>$usuario, 'oficina'=>$oficina, 'copia'=>true, 'total_letra'=>$letra, 'imagen'=>$qr));
    }

    public function mostrar_boleta_factura($tipo, $serie, $numero){
        $this->data['boleta_factura']['cliente'] = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo, $serie, $numero);
        $this->data['boleta_factura']['descripcion'] = $this->Comprobante_pago_model->get_descripcion_boletafactura($tipo, $serie, $numero);

        $this->data['propie'] = $this->Propie_model->get_propie($this->data['boleta_factura']['cliente']['FSCCLIUNIC']);
        if(empty($this->data['propie'])){
            $this->data['propie'] = $this->Propie_model->get_default_propie();
        }

        $this->data['tipo_registro']='boleta';
        $this->data['view']='boleta_factura/BoletaFactura_ver_uno_view';
        $this->data['breadcrumbs'] = array(array('Comprobante', 'documentos/boletas_facturas'),array('Detalle',''));
        //$this->data['conceptos'] = $this->Comprobante_pago_model->get_concep();
        $this->load->view('template/Master', $this->data);
    }

    public function mostrar_pdf($tipo, $serie, $numero){
        $comprobante = $this->Comprobante_pago_model->get_cabecera_boletafactura($tipo, $serie, $numero);
        if(empty($comprobante)){
            redirect($this->config->item('ip').'inicio');
        }else if($comprobante['DIRARCHPDF']!=null){
            $this->output->set_content_type('application/pdf')->set_output(file_get_contents($comprobante['DIRARCHPDF']));
        }else{
            redirect($this->config->item('ip').'inicio');
        }
    }
}