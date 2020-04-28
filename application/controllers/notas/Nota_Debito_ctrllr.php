<?php

class Nota_Debito_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('acceso/Perfil_model');
        $this->load->model('acceso/Cargo_model');
        $this->load->model('notas/Nota_Credito_model');
        $this->load->model('notas/Nota_Debito_model');
        $this->load->model('cuenta_corriente/Cuentas_corrientes_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Administración Notas Credito';
        $this->data['menu']['padre'] = 'Notas';
        $this->data['menu']['hijo'] = 'nota_debito';

        $this->direccion_pdf = 'assets/comprobante/nota_debito/pdf/';
        $this->direccion_xml = 'assets/comprobante/nota_debito/xml/';
        $this->direccion_qrtemp = 'assets/comprobante/nota_debito/';
    }

    public function administrar_notasDebito(){
       if($this->input->server('REQUEST_METHOD') == 'POST'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('serie',"Serie del Documento",'required');
            $this->form_validation->set_rules('numero',"Numero del Documento",'required');
            if($this->form_validation->run() == TRUE){
                $tipo = $this->input->post('tipo');
                $serie = $this->input->post('serie');
                $numero = $this->input->post('numero');
                if($tipo == 1){
                    $this->data['notaOne'] = $this->Nota_Credito_model->get_one_nota($serie,$numero);
                }else{
                    $this->data['notaOne'] = $this->Nota_Credito_model->get_one_nota1($serie,$numero);
                }
            }else{

            }
        }else{
            $this->data['notas'] = $this->Nota_Debito_model->get_notas_debito();
        }
        $this->data['view'] = 'notas/Nota_Debito_view';
        $this->data['breadcrumbs'] = array(array('Notas', ''),array('Nota Debito',''));
        $this->load->view('template/Master', $this->data);
    }


    public function ver_recibos(){
        $ajax = $this->input->get('ajax');
        $var = $this->input->post('suministro');
        $this->data['recibos'] = $this->Nota_Credito_model->recibos_pendientes($var);
        $this->data['reclamados'] = $this->Nota_Credito_model->documentos_reclamdos($var);
        #$this->data['recibos'] =
        if ($ajax == true) {
            $json = array('result' => true, 'mensaje' => 'OK','data'=>$this->data['recibos'],'reclamos' => $this->data['reclamados']);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }

     public function ver_recibo($suministro,$serie,$numero){
         $this->data['user_datos'] = $this->Cuentas_corrientes_model->get_one_client($suministro);
         $this->data['recibo'] = $this->Cuentas_corrientes_model->get_recibo($serie,$numero);
         $this->data['faclin'] = $this->Cuentas_corrientes_model->get_faclin($serie,$numero);
         $this->data['letfac'] = $this->Cuentas_corrientes_model->get_letfac($serie,$numero);
         $this->data['igv'] = $this->Nota_Credito_model->get_igv();
         $this->data['view'] = 'notas/Generar_ND_view';
         $this->data['proceso'] = 'Generación Notas Debito';
         $this->data['breadcrumbs'] = array(array('Notas', ''),array('Nota Débito','notas/nota_credito'),array('Generar Nota Débito',''));
         $this->load->view('template/Master', $this->data);
    }

    public function ver_facturas(){
        $ajax = $this->input->get('ajax');
        $serie = $this->input->post('serie');
        $numero = $this->input->post('numero');
        $tipo = $this->input->post('tipo');
        $tipodoc = $this->input->post('tipo_doc');
        $this->data['factuas'] = null;
        if($tipo == "SERIE Y NUMERO"){
            $this->data['factuas'] = $this->Nota_Debito_model->get_facturasyboletas($serie,$numero,$tipodoc);
        } if($tipo == 'RUC'){

        }
        if ($ajax == true) {
            if($this->data['factuas'] != null){
                $json = array('result' => true, 'mensaje' => 'OK','data'=>$this->data['factuas']);
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            } else {
                $json = array('result' => false, 'mensaje' => 'No se ecnontro el documento');
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }

        }
    }

    public function ver_boleta_factura($serie,$numero,$numero1){
        $this->data['view'] = 'notas/Generar_NDBF_view';
        //$this->data['serie'] = $this->Nota_Credito_model->get_serie_notas($_SESSION['NSEMPCOD'],$_SESSION['NSOFICOD'],$_SESSION['NSARECOD'],$numero1);
        $this->data['igv'] = $this->Nota_Debito_model->get_igv();
        $this->data['factura'] = $this->Nota_Debito_model->get_facturasyboletas($serie,$numero,$numero1);
        $this->data['factura_detalle'] = $this->Nota_Debito_model->get_facturasyboletas_detalle($serie,$numero,$numero1);
        $this->data['proceso'] = 'Generación Notas Débito de Facturas y Boletas';
        $this->data['breadcrumbs'] = array(array('Notas', ''),array('Nota Débito','notas/notas_debito'),array('Generar Nota Débito Boleta y Factura',''));
        $this->load->view('template/Master', $this->data);
    }

    #FUNCIÓN PARA GENERAR LA NOTA DE CRÉDITO PARA BOLETA O FACTURA
    public function generar_ndbf(){
        $ajax = $this->input->get('ajax');
        $documento = json_decode($this->input->post("documento"));
        $documento1 = json_decode($this->input->post("documento1"));
        $conceptos = json_decode($this->input->post("conceptos"));
        $datos_usuario = json_decode($this->input->post("datos_usuario"));
        $nota_debito = json_decode($this->input->post("nota_debito"));
        $nombre = $this->input->post("nombre");
        $tipo = $this->input->post("tipo");
        $tipoAux = $tipo;
        $motivo = $this->input->post("motivo");
        $oficina = $this->Nota_Debito_model->get_oficina($_SESSION['OFICOD']);
        $__DIR_OFICINA = $this->Nota_Debito_model->get_direccion_sede($_SESSION['OFICOD']);
        $___UBICACION = $this->Nota_Debito_model->get_nombre_sede($_SESSION['OFICOD']);
        $__UBICACION = "";
        if($___UBICACION['DIST'] == 'TRUJILLO'){
            $__UBICACION = $___UBICACION['UBICACION'];
        } else {
            $__UBICACION = $___UBICACION['DIST'].' - '.$___UBICACION['DIRECCION'];
        }
        $area = $this->Nota_Debito_model->get_area($_SESSION['NSARECOD']);
        ini_set('default_charset','ISO-8859-1');

        $cabecera = array();
        $detalle = array();
        $tipo1 = 0;
        if($tipo == 'FACTURA'){
            $tipo1 = 1;
        }
        $serie_sunat = $this->Nota_Credito_model->get_serie($datos_usuario->serie,$datos_usuario->numero,$tipo1);
        $serie_numero_nd = $datos_usuario->serie."-".$datos_usuario->numero;
        $tvvog = 0;
        $intereses = 0;
        for($i = 0;$i<sizeof($nota_debito);$i++){
            $tvvog += floatval($nota_debito[$i]->descuento) + floatval($nota_debito[$i]->interes);
            $intereses += floatval($nota_debito[$i]->interes);
        }

        $cabecera[0] = ''.number_format($tvvog,2,'.','');
        $cabecera[1] = $tvvoi ='';
        $cabecera[2] = $tvvoe = '';

        $cabecera[3] = $tototrostributos = '';
        $cabecera[4] = $otroscargo1 = '';
        $cabecera[5] = $otroscargo2 = '';
        $cabecera[6] = $totdescuentos = '';
        if($tipo == 'FACTURA'){
            $cabecera[7] = $ser_num = 'FF11-1105';
            $cabecera[13] = $tip_doc_modificado = '01';  // factura 01 y boltea 03
            $ruc_cliente = $this->Nota_Credito_model->get_ruc_cliente($datos_usuario->serie,$datos_usuario->numero,$tipo1);
            $cabecera[18] = $ru_cliente = $ruc_cliente;  //ruc del cliente
            $cabecera[19] = $iden_doc_cliente = '6';  //tipo del documento identidad del cliente
        } else {
            $cabecera[7] = $ser_num = 'BF11-1305';
            $cabecera[13] = $tip_doc_modificado = '03';  // factura 01 y boltea 03
            $dni_cliente = $this->Nota_Credito_model->get_dni_cliente($datos_usuario->serie,$datos_usuario->numero,$tipo1);
            $cabecera[18] = $ru_cliente = $dni_cliente;  //ruc del cliente
            $cabecera[19] = $iden_doc_cliente = '1';  //tipo del documento identidad del cliente
        }
        $cabecera[10] = $num_relac = $serie_sunat;
        $cabecera[8] = $f_emision = date("Y-m-d");
        $cabecera[9] = $t_moneda = 'PEN';

        $cabecera[11] = $tip_nota_debito = '02';  //responsecode 01,02,03...
        $cabecera[12] = $descrip_nota_debito = $motivo;
        $cabecera[14] = $refe_tip_doc = '';  //serie-numero de guia de transporte
        $cabecera[15] = $refe_cod_doc = '';  //tipo de guia ejemplo 09 catalogo 01 sunat
        $cabecera[16] = $ad_tip_doc = '';  //en caso de emitir nota de credito por anulaciÛn por error en el RUC (factura emitida a un adquirente o usuario equivocado), y cuando con anterioridad a la emisiÛn de esta nota de crÈdito, se hubiere emitido la factura correcta (al adquirente o usario correcto), se consignar· en este elemento la referencia a Èsta ˙ltima. Para este fin se utilizar· el tag cac:AdditionalDocumentReference, consignando como cÛdigo de tipo de documento (cbc:DocumentTypeCode) el valor ?01? (Factura ? emitida para corregir error en el RUC) del cat·logo 12 y en el campo cbc:ID, se consignar· la serie y n˙mero de dicha factura, separado por guiÛn.
        $cabecera[17] = $ad_cod_doc = '';  //tipo de documento adicional
        $cabecera[20] = $nom_cliente = $nombre;  //nombre del cliente
        $cabecera[21] = $mon_total_isc = '';
        $cabecera[22] = $mon_total_igv = ''.number_format($intereses,2,'.','');
        $cabecera[23] = $mon_total_otros = '';
        $cabecera[24] = $importe_total = ''.number_format($tvvog,2,'.',''); //IMPORTE TOTAL
        $cabecera[25] = $sum_otros_cargos = '';

        $cabecera[26] = $invoiceTypeCode='08';

        $cabecera[27] = $ambiente = 'beta';  //valores 'homologacion','beta','produccion'
        $valor_referencia = $this->Nota_Credito_model->get_igv_referencia($datos_usuario->serie,$datos_usuario->numero,$tipo1);

        $cabecera[28] = $tipo = '1';  // Factura. Notas vinculadas. Servicios P˙blicos. Resumen Diario. ComunicaciÛn de Baja. Lotes de Facturas.
        for($i = 0; $i<sizeof($conceptos);$i++){
            $detalle[$i][0] = ($i+1);
            $detalle[$i][1] = 'ZZ';
            $detalle[$i][2] = $conceptos[$i]->CANT;
            $detalle[$i][3] = 'PEN';
            $PSIGV = (floatval($conceptos[$i]->PUNIT)/(1+floatval($valor_referencia)/100));
            $IGV_1 = number_format(($PSIGV * (floatval($valor_referencia)/100)),2,'.','');
            $precio_sin_igv = number_format((floatval($conceptos[$i]->PUNIT) - $IGV_1),2,'.','');
            $valor_venta = number_format(($precio_sin_igv * intval($conceptos[$i]->CANT)),2,'.','');
            $detalle[$i][4] = $valor_venta;
            $detalle[$i][5] = $conceptos[$i]->PUNIT;
            $detalle[$i][6] = '01';
            $detalle[$i][7] = $nota_debito[$i]->interes;
            $detalle[$i][8] = $nota_debito[$i]->interes;
            $detalle[$i][9] = '10';
            $detalle[$i][10] = '1000';
            $detalle[$i][11] = 'IGV';
            $detalle[$i][12] = 'VAT';
            $detalle[$i][13] = '';
            $detalle[$i][14] = '';
            $detalle[$i][15] = $conceptos[$i]->FACCONDES;
            $detalle[$i][16] = $conceptos[$i]->FACCONCOD;
            $detalle[$i][17] = 'PEN';
            $detalle[$i][18] = $nota_debito[$i]->descuento;
        }

        //Item 1
        //$detalle[0][0] = $item = '1';  // item
        //$detalle[0][1] = $unid_med = 'NIU';
        //$detalle[0][2] = $cantidad = '1';
        //$detalle[0][3] = $moneda = 'PEN';
        //$detalle[0][4] = $valorventa  = '16.95';  // LineExtensionAmount
        //$detalle[0][5] = $precio = '2.00';  // precio
        //$detalle[0][6] = $tipoprecio = '01';  // tipo de precio catalogo 16

        //$detalle[0][7] = $totaltaxamount = '3.05';
        //$detalle[0][8] = $subtotaltaxamount = '3.05';
        //$detalle[0][9] = $taxexemptionreasoncode = '10';

        //$detalle[0][10] = $ID = '1000';  // ID del impuesto
        //$detalle[0][11] = $ImpuestoIGV = 'IGV';  // Impuesto IGV
        //$detalle[0][12] = $TaxTypeCode = 'VAT';  // Codigo en SUNAT

        //$detalle[0][13] = $UnitCode = '';  // Siempre cadena vacia por favor
        //$detalle[0][14] = $CreditedQuantity = '';  //Siempre cadena vacia por favor

        //$detalle[0][15] = $descripcion = 'Ampliacion de garantia articulo 1';  // description
        //$detalle[0][16] = $ID = 'ART1';  // Codigo del concepto producto en los sistemas internos

        //$detalle[0][17] = $moneda = 'PEN';  // Precio del Item sin IGV
        //$detalle[0][18] = $precio = '1.69';  // Precio del Item sin IGV

        //item2


        //$detalle[1][0] = $item = '2';  // item
        //$detalle[1][1] = $unid_med = 'NIU';
        //$detalle[1][2] = $cantidad = '1';
        //$detalle[1][3] = $moneda = 'PEN';
        //$detalle[1][4] = $valorventa  = '8.47';  // LineExtensionAmount
        //$detalle[1][5] = $precio = '10.00';  // precio
        //$detalle[1][6] = $tipoprecio = '01';  // tipo de precio catalogo 16

        //$detalle[1][7] = $totaltaxamount = '1.53';
        //$detalle[1][8] = $subtotaltaxamount = '1.53';
        //$detalle[1][9] = $taxexemptionreasoncode = '10';

        //$detalle[1][10] = $ID = '1000';  // ID del impuesto
        //$detalle[1][11] = $ImpuestoIGV = 'IGV';  // Impuesto IGV
        //$detalle[1][12] = $TaxTypeCode = 'VAT';  // Codigo en SUNAT

        //$detalle[1][13] = $UnitCode = '';  // NIU
        //$detalle[1][14] = $CreditedQuantity = '';

        //$detalle[1][15] = $descripcion = 'Articulo 2';  // description
        //$detalle[1][16] = $ID = 'ART2';  // Codigo del concepto producto en los sistemas internos

        //$detalle[1][17] = $moneda = 'PEN';  // Precio del Item sin IGV
        //$detalle[1][18] = $precio = '8.47';
        $nota_debito_guardar = ['C'];
        try {

        $sClient = new SoapClient('https://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL', array('trace' => 1,'encoding' => 'ISO-8859-1'));
        //$sClient = new SoapClient('http://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL', array('trace' => 1,'encoding' => 'ISO-8859-1'));

            $result = $sClient->__call('metodo3', array($cabecera, $detalle));
            if($result[10] == 0){
                $adi = 1;
                $adi_base = 1;
                $direccion = $this->input->post("direccion");
                $mont_total_op_gravada = 0;
                $subtotal_vista = 0;
                $dire_img = $this->config->item('ip')."img/logo3.png";
                foreach($nota_debito as $nc => $val){
                    $mont_total_op_gravada += floatval($val->interes);
                    $subtotal_vista += floatval($val->descuento);
                }
                $v_num_corre = $cabecera[7];
                $cod_num_rel = $cabecera[7];
                $r_emisor = "20131911310"; // RUC DE SEDALIB OBLIGATORIO
                $ident_documento = $ru_cliente; // DOCUMENTO DEL USUARIO
                $seri_doc_modificado = $serie_sunat;
                $im_total = $mont_total_op_gravada + $subtotal_vista;
                $parte_factura = $conceptos;
                $parte_factura1 = $nota_debito;
                $respuesta = $this->agrega_datos( $adi_base, $dire_img,$direccion, $mont_total_op_gravada, $v_num_corre, $f_emision, $t_moneda, $cod_num_rel, $tip_nota_debito, $descrip_nota_debito, $seri_doc_modificado, $tip_doc_modificado, $refe_tip_doc, $refe_cod_doc, $ad_tip_doc, $ad_cod_doc, $r_emisor, $ident_documento, $ru_cliente, $nombre, $mon_total_isc, $mon_total_igv, $mon_total_otros, $im_total, $sum_otros_cargos, $parte_factura,$parte_factura1, $adi,$tipoAux,$num_relac,$motivo,$oficina,$__DIR_OFICINA,$area,$subtotal_vista,$__UBICACION);
                /****  GENERANDO EL XML  ****/
                $xml = base64_decode ( $result[count( $result )-1] );
                $dir_file = $this->direccion_xml.$result[9].'.xml';
                //'assets/comprobante/boleta_factura/'.$result[9].'.xml';
                file_put_contents($_SERVER['DOCUMENT_ROOT'].'/GeneSys/'.$dir_file, $xml);
                /****  GENERANDO EL PDF  ****/
                $this->load->library('dompdf_pdf');
                $mipdf = $this->dompdf_pdf->cargar();
                $mipdf->set_paper('A5', 'landscape');
                $mipdf->load_html(utf8_decode($respuesta));
                $mipdf->render();
                $output = $mipdf->output();
                $dir_pdf = $this->direccion_pdf.$ser_num.'.pdf';
                //$file_to_save = $dir_pdf.$result2[2].'.pdf';
                file_put_contents($_SERVER['DOCUMENT_ROOT'].'/GeneSys/'.$dir_pdf, $output);

                    if ($ajax == true){
                        $json = array('result' => true, 'mensaje' => 'OK','data'=>$dir_pdf);
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
            } else if(sizeof($result)<11){
                $json = array('result' => false, 'mensaje' => 'No se pudo generar la Nota de Débito '.$ser_num, 'result2'=>$result);
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            } else if($result[10]=='2380'){
                $obs = $result[10].' '.$result[11];
                $json = array('result' => false, 'mensaje' => 'No se pudo generar la Nota de Débito '.$ser_num, 'result2'=>$obs);
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
            }
            else {
                $json = array('result' => false, 'mensaje' =>"No se pudo generar la Nota Débito".$ser_num);
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        } catch (SoapFault $fault) {

            echo 'Fallo el Web Service - codigo de Error:<br><br>';
            echo var_dump($fault->faultcode . '<br><br>');
            echo var_dump($fault->faultstring . '<br><br>');
            echo var_dump($fault);
        }

    }

    public function creo_QR($RUC,$tipo,$serie,$mto_total_igv,$mto_total,$fecha_emi) {
        $this->load->library('barcode_generador');
        $bar = $this->barcode_generador->cargar();
        //$bar = new BARCODE();
        $qr_values[0]    = $RUC ."|".$tipo ."|".$serie ."|".$mto_total_igv ."|".$mto_total ."|".$fecha_emi ;
        //$bar->QRCode_save('text', $qr_values, 'qr_imagen', './imagen/','png',50,2,'#ffffff','#000000','L',false);
        $bar->QRCode_save('text', $qr_values, $serie, $_SERVER['DOCUMENT_ROOT'].'/GeneSys/assets/comprobante/nota_debito/','png',50,2,'#ffffff','#000000','L',false);
        return $this->config->item('ip').$this->direccion_qrtemp.$serie.'.png';
    }

    function  agrega_datos( $adi_base,$dire_img, $direccion, $mont_total_op_gravada, $v_num_corre, $f_emision, $t_moneda, $cod_num_rel, $tip_nota_debito, $descrip_nota_debito, $seri_doc_modificado, $tip_doc_modificado, $refe_tip_doc, $refe_cod_doc, $ad_tip_doc, $ad_cod_doc, $r_emisor, $ident_documento, $ru_cliente, $n_cliente, $mon_total_isc, $mon_total_igv, $mon_total_otros, $im_total, $sum_otros_cargos, $parte_factura, $parte_factura1,$adi,$tipoAux,$num_relac,$motivo,$oficina,$__DIR_OFICINA,$area,$subtotal_vista,$__UBICACION){
       $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);

         setlocale(LC_ALL,"es_ES");

         /**************************************************************************
         * +en esta seccion calculo en cuantas paginas ira el contenido            *
         * de la nota de debito                                                    *
         * +se divide de acuerdo a toda la informacion  proveniente de la variable *
         *                                                                         *
         ***************************************************************************/
         $i=0;
         $sub_total=0;
         $sumador=0;
         $conta_cuerpo=0;
         $suplente='';
         while($i<sizeof($parte_factura))
         {
              if(strlen($parte_factura[$i]->FACCONDES)<129)
              {
                $sumador= $sumador +129;
              }
              else
              {
                 if((strlen($parte_factura[$i]->FACCONDES)%129)==0)
                  {
                    $sumador= $sumador +strlen($parte_factura[$i]->FACCONDES);
                  }
                  else
                  {
                    $sumador= $sumador + (((strlen($parte_factura[$i]->FACCONDES)/129)*129) + (strlen($parte_factura[$i]->FACCONDES)%129))+ 100;
                   // echo "**** ".strlen($parte_factura[$i][0])."******";
                  }
              }

              //echo "-->".$sumador."<--";


              if($sumador>=3200)
              {



                $sumador=0;
                $conta_cuerpo= $conta_cuerpo +1;

                    if(!isset($cuerpo[$conta_cuerpo]))
                    {
                        $cuerpo[$conta_cuerpo]='';
                        $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                    <td style='text-align:center; border-bottom: 0.7px solid #000; border-left: 0.7px solid #000;border-right: 0.7px solid #000;'>".$parte_factura[$i]->FACCONCOD."</td>
                                    <td style='text-align:left; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'><p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$parte_factura[$i]->FACCONDES."</p></td>
                                    <td style='text-align:right;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($parte_factura1[$i]->descuento), 2, '.', '') : (number_format((floatval($parte_factura1[$i]->descuento) + floatval($parte_factura1[$i]->interes)),2,'.','')))."</span></td>
                                  </tr>";
                    }
                  /*

                                    <td style='text-align:center; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'><span style='margin-right:5px;'>".number_format($parte_factura[$i][2], 2, '.', '')."</span></td>
                                    <td style='text-align:right; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '><span style='margin-right:5px;'>".number_format($parte_factura[$i][3], 2, '.', '')."</span></td>
                                    <td style='text-align:right;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'><span style='margin-right:5px;'>".number_format($parte_factura[$i][4], 2, '.', '')."</span></td>
                  */
                    else
                    {
                       $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                    <td style='text-align:center; border-bottom: 0.7px solid #000; border-left: 0.7px solid #000;border-right: 0.7px solid #000;'>".$parte_factura[$i]->FACCONCOD."</td>
                                    <td style='text-align:left; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'><p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$parte_factura[$i]->FACCONDES."</p></td>
                                    <td style='text-align:right;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($parte_factura1[$i]->descuento), 2, '.', '') : (number_format((floatval($parte_factura1[$i]->descuento) + floatval($parte_factura1[$i]->interes)),2,'.','')))."</span></td>
                                  </tr>";
                    }

                $sumador=strlen($parte_factura[$i][1]);

              }
              else
              {
                    $sumador=$sumador +15;
                    if(!isset($cuerpo[$conta_cuerpo]))
                    {
                        $cuerpo[$conta_cuerpo]='';
                         $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                    <td style='text-align:center; border-bottom: 0.7px solid #000; border-left: 0.7px solid #000;border-right: 0.7px solid #000;'>".$parte_factura[$i]->FACCONCOD."</td>
                                    <td style='text-align:left; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'><p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$parte_factura[$i]->FACCONDES."</p></td>
                                    <td style='text-align:right;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($parte_factura1[$i]->descuento), 2, '.', '') : (number_format((floatval($parte_factura1[$i]->descuento) + floatval($parte_factura1[$i]->interes)),2,'.','')))."</span></td>
                                  </tr>";
                    }
                    else
                    {
                        $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                    <td style='text-align:center; border-bottom: 0.7px solid #000; border-left: 0.7px solid #000;border-right: 0.7px solid #000;'>".$parte_factura[$i]->FACCONCOD."</td>
                                    <td style='text-align:left; border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;'><p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$parte_factura[$i]->FACCONDES."</p></td>
                                    <td style='text-align:right;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; '><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($parte_factura1[$i]->descuento), 2, '.', '') : (number_format((floatval($parte_factura1[$i]->descuento) + floatval($parte_factura1[$i]->interes)),2,'.','')))."</span></td>
                                  </tr>";
                    }

              }


          $sub_total= $sub_total + $parte_factura1[$i]->descuento;
          $i=$i+1;
         }
         $IGV=(0.18)*$sub_total;
         $TOTAL=$sub_total + $IGV;

         /****************************************************************************
          * + en esta seccion se empieza a escribir todo el html para el dibujado de *
          * la nota de debito                                                        *
          * + se divide en cabecera ,cuerpo y base                                   *
          * + para el debujado utilizo cadenas que contienen html                    *
          * + la libreria interpreta la cadena y genera el pdf                       *
          ****************************************************************************/
         $adicional="<div  style=' height:100px;width:40% ;position:absolute;  margin-top:-25px; margin-left:31%;'>
                        <table width='100%'>
                            <tr>
                                <td style='width:50%'>
                                    <strong style='margin-top:-2px;'>
                                        <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                        Oficina:
                                        </i>
                                   </strong><br>
                                   <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>".$oficina."</i>
                                </td>
                                <td style='width:50%'>
                                    <strong style='margin-top:-2px;'>
                                        <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                        Area:
                                        </i>
                                   </strong><br>
                                   <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>".$area."</i>
                                </td>
                            </tr>
                            <tr>
                                <td style='width:25%'>
                                    <strong style='margin-top:-2px;'>
                                       <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                       Referencia:
                                       </i>
                                   </strong><br>
                                   <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>".$num_relac."</i>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='3'>
                                    <strong style='margin-top:-2px;'>
                                       <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                            Motivo:
                                       </i>
                                    </strong>
                                    <br>
                                      <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                        ".$motivo."
                                      </i>
                                </td>
                            </tr>
                        </table>
                          <div style='height:30px; width:100% ; margin-top:-5px;'>

                          </div>
                    </div>";
        /*
        <div style='height:30px; width:100% ; margin-top:-5px;'>
                              <div style='height:30px; width:32% ; '>
                                 <strong style='margin-top:-2px;'>
                                   <i style='margin-top:0px; text-align:left;margin-left:6px; font-size:8px; border-bottom:0.7px solid #000;'>
                                   Referencia:
                                   </i>
                                   </strong>

                                  <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>
                                    FF11-26
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
            <div style='height:30px; width:32% ; '>

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
        */
         $cabecera =" <div style='margin-left:10px; height: 145px;width:100% ; '>
             <div  style=' height: 80px;width:100% ; position:relative '>
                  <div  style=' height:100px;width:30% ;position:absolute;  margin-top:-25px;text-align:center'>
                  <img src='".$dire_img."' style=' max-width: 100%; height: auto;margin-bottom:-10px '><br><i style='font-size:7px;margin-top:-20px;'>".$__DIR_OFICINA."</i><br><i style='font-size:7px;'>".$__UBICACION."</i>
                  </div>";
         $resto_cabe= "<div style='position:absolute; height: 100px; width:30% ; border-radius: 18px 18px 18px 18px;border: 0.7px solid #000;margin-top:-25px; margin-left:70%;' >
                        <h5  style=' text-align:center;margin-top:10px ;margin-bottom:10px;'>".utf8_encode("R.U.C N ° ")."". $r_emisor." </h5>
                        <h5  style='text-align:center; margin-top:-4px ; width:99%; margin-left:0.5%; margin-bottom:10px;'> NOTA DE DEBITO</h5>
                        <h5  style='text-align:center; margin-top:-4px ;'>".$cod_num_rel."</h5>
                    </div>

               </div>
               <div  style='  height: 130px;width:100% ;  '>
                 <div  style=' height: 90px;width:70% ; position:absolute; margin-top:10px ; '>
                      <table style=' border-spacing: 0; font-size:10px; width:100%;'>
                        <tr>
                          <td >".utf8_encode("Señor(es):")."<td>
                          <td style='border-bottom: 0.7px solid #000; width:80%'>".$n_cliente."<td>
                        </tr>
                        <tr>
                          <td >".utf8_encode("Dirección:")."<td>
                          <td style='border-bottom: 0.7px solid #000; width:90%'> ".$direccion."<td>
                        </tr>
                        <tr>
                          <td  > Documento:<td>
                          <td style='border-bottom: 0.7px solid #000; width:90%' >".(($tipoAux == 'FACTURA') ? "(R.U.C.) ".$ru_cliente : "(D.N.I.) ".$ru_cliente)."<td>
                        </tr>
                      </table>
                    </div>

                 <div style=' height: 50px; width:30% ; margin-top:10px; margin-left:71%;'>
                     <div style='  height: 30px; width:30% ; maring-top:50px;margin-top:20px '>
                        <span style='text-align:right; font-size:10.7px;top:20%'> TRUJILLO</span>
                     </div>
                     <div style=' height: 30px; width:70% ;  position:absolute; margin-left:30%;  '>
                            <table style='text-align:center;font-size:10.7px; border-spacing: 0px 0px; width:95%;  height: 30px;margin-top:10px'>
                              <tr >
                                <td style=' border-radius: 10 0 0 10;border:0.7px solid #000;  '>".date("d")."</td>
                                <td style='  border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-top:0.7px solid #000;  '>".date("m")."</td>
                                <td style='border-radius: 0 10 10 0;  border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-top:0.7px solid #000; '>".date("Y")."</td>
                              </tr>
                            </table>
                     </div>
                 </div>
             </div>
           </div>";

      if($adi==1)
        {
           $cabecera=$cabecera.$adicional.$resto_cabe;
        }
        else
        {
             $cabecera=$cabecera.$resto_cabe;
        }

      $base="<div style='margin-left:10px; height: 30px;width:100% ;   position:relative; '>
            <div style='position:absolute; margin-top:30px;'>
               <div style=' height: 115px;width:79% ;  margin-top: 10px ;'>";
        /**************************************************************************/
         // creo la imagen
        $img =  $this->creo_QR($r_emisor,$ident_documento,$v_num_corre,$mon_total_igv,$im_total,$f_emision);
        /**************************************************************************/
      $agrego_base="<div style='position:absolute;height:100px; width:35%;text-align:center'>
                  <img src='".$img."' style='margin-top:30px;width: 50%; height:85px; '>
                  </div>";
      if($adi_base==1)
      {
       $base=$base.$agrego_base."<div style=' position:absolute; margin-left:36%; height:100px; width:64%;'>
                    <table style='font-size:7px; border-radius: 10px 10px 10px 10px; border: 0.7px solid #000; width:100% ;margin-top:30px;'>
                          <tr>
                            <td>
                                Son: ". $ntt->numtoletras($im_total) ."
                            </td>
                          </tr>
                    </table>
                    <table  style='border-spacing: 0; font-size:10px; text-align:center;    width:100%; margin-top:5px;' >
                              <tr   >
                                <td style='border-radius: 10px 0px 0px 0px;  border: 0.7px solid #000; ' colspan='3' > FECHA</td>
                                <td style=' border-radius: 0px 10px 0px 0px; border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-top:0.7px solid #000; '> CANCELADO</td>
                              </tr>
                              <tr  >
                                <td style=' border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000;  '> DIA </td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000; '> MES</td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000; ' >".utf8_encode("AÑO")."</td>
                                <td style=' border-radius: 0px 0px 10px 0px;  border-right:0.7px solid #000; border-bottom:0.7px solid #000;' rowspan='2' > </td>
                              </tr>
                              <tr   >
                                <td style=' border-radius: 0px 0px 0px 10px; height: 15px; border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000; '>".date("d")."</td>
                                <td style='height: 15px; border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> ".date("m")."</td>
                                <td style=' height: 15px;border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> ".date("Y")."</td>

                              </tr>

                            </table>
                  </div>

               </div>
               <div style=' height: 100px;width:20% ;   position:absolute; margin-left:80%; margin-top:-20px '>
                  <div style=' height: 100px; width:100% ; margin-top:30px;' >
                      <table style='font-size:10px;    width:100%;  border-spacing: 0; margin-top:10px'>".
                                ((($tipoAux != "FACTURA"))? "<tr>
                                <td style='border-radius: 10px 0px 0px 0px; border: 0.7px solid #000;  width:55% ;height: 23px; text-align:left;'></td>
                                <td style='text-align:right; border-radius: 00px 10px 0px 0px;border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-top:0.7px solid #000;  width:45% ;height: 23px;  '></td>
                                </tr>
                                <tr>
                                <td style='border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000; width:55% ; height: 23px;text-align:left;'></td>
                                <td style='text-align:right;border-right:0.7px solid #000; border-bottom:0.7px solid #000; width:45% ; height: 23px;'></td>
                                </tr>" : "<tr >
                                  <td style='border-radius: 10px 0px 0px 0px; border: 0.7px solid #000;  width:55% ;height: 23px; text-align:left;'><span style='margin-left:5px;'>SUB TOTAL</span></td>
                                  <td style='text-align:right; border-radius: 00px 10px 0px 0px;border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-top:0.7px solid #000;  width:45% ;height: 23px;  '><span style='margin-right:5px;'>".number_format($subtotal_vista, 2, '.', '')."</span></td>
                                </tr>
                                <tr >
                                  <td style='border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000; width:55% ; height: 23px;text-align:left;'><span style='margin-left:5px;'>I.G.V.</span></td>
                                  <td style='text-align:right;border-right:0.7px solid #000; border-bottom:0.7px solid #000; width:45% ; height: 23px;'><span style='margin-right:5px;'>".number_format($mont_total_op_gravada, 2, '.', '')."</span></td>
                                </tr>")."
                                <tr >
                                  <td style='border-radius: 0px 0px 0px 10px; border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000; width:55% ; height: 22px;text-align:left;'><span style='margin-left:5px;'>TOTAL</span></td>
                                  <td style='text-align:right; border-radius: 0px 0px 10px 0px; border-right:0.7px solid #000; border-bottom:0.7px solid #000;  width:45% ; height: 22px;'><span style='margin-right:5px;'>".number_format($im_total, 2, '.', '')."</span></td>
                                </tr>
                      </table>
                  </div>


               </div>";
      }
      else
      {
        $base=$base."<div style=' position:absolute; margin-left:21%; height:100px; width:79%;'>
                    <table style='font-size:7px; border-radius: 10px 10px 10px 10px; border: 0.7px solid #000; width:100% ;margin-top:30px;'>
                          <tr>
                            <td>
                                Son: ". $ntt->numtoletras($im_total) ."
                            </td>
                          </tr>
                    </table>
                    <table  style='border-spacing: 0; font-size:10px; text-align:center;    width:100%; margin-top:5px;' >
                              <tr   >
                                <td style='border-radius: 10px 0px 0px 0px;  border: 0.7px solid #000; ' colspan='3' > FECHA</td>
                                <td style=' border-radius: 0px 10px 0px 0px; border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-top:0.7px solid #000; '> CANCELADO</td>
                              </tr>
                              <tr  >
                                <td style=' border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000;  '> DIA </td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000; '> MES</td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000; ' >".utf8_encode("AÑO")."</td>
                                <td style=' border-radius: 0px 0px 10px 0px;  border-right:0.7px solid #000; border-bottom:0.7px solid #000;' rowspan='2' > </td>
                              </tr>
                              <tr   >
                                <td style=' border-radius: 0px 0px 0px 10px; height: 15px; border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000; '>".date("d")."</td>
                                <td style='height: 15px; border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> ".date("m")."</td>
                                <td style=' height: 15px;border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> ".date("Y")."</td>

                              </tr>

                            </table>
                  </div>

               </div>
               <div style=' height: 100px;width:20% ;   position:absolute; margin-left:80%; margin-top:-20px '>
                  <div style=' height: 100px; width:100% ; margin-top:30px;' >
                       <table style='font-size:10px;    width:100%;  border-spacing: 0; margin-top:10px'>".
                                (($tipoAux != "FACTURA") ? "" : "<tr >
                                  <td style='border-radius: 10px 0px 0px 0px; border: 0.7px solid #000;  width:55% ;height: 23px; text-align:left;'><span style='margin-left:5px;'>SUB TOTAL:</span></td>
                                  <td style='text-align:right; border-radius: 00px 10px 0px 0px;border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-top:0.7px solid #000;  width:45% ;height: 23px;  '><span style='margin-right:5px;'>".number_format($subtotal_vista, 2, '.', '')."</span></td>
                                </tr>
                                <tr >
                                  <td style='border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000; width:55% ; height: 23px;text-align:left;'><span style='margin-left:5px;'>I.G.V.( )</span></td>
                                  <td style='text-align:right;border-right:0.7px solid #000; border-bottom:0.7px solid #000; width:45% ; height: 23px;'><span style='margin-right:5px;'>".number_format($mont_total_op_gravada, 2, '.', '')."</span></td>
                                </tr>")."
                                <tr >
                                  <td style='border-radius: 0px 0px 0px 10px; border-left:0.7px solid #000; border-bottom:0.7px solid #000; border-right:0.7px solid #000; width:55% ; height: 22px;text-align:left;'><span style='margin-left:5px;'>TOTAL</span></td>
                                  <td style='text-align:right; border-radius: 0px 0px 10px 0px; border-right:0.7px solid #000; border-bottom:0.7px solid #000;  width:45% ; height: 22px;'><span style='margin-right:5px;'>".number_format($im_total, 2, '.', '')."</span></td>
                                </tr>
                      </table>
                  </div>


               </div>";
      }


         // encabezado del html
         $html="
      <html lang='es'>
        <head>
        <title>Sedalib</title>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

        </head>
        <body style='font-family:sans-serif;'>
        ";
        //para generar las paginas

         $pagina=$cabecera."

         <div style='margin-left:10px; height: 180px;width:100% ; margin-top:-80px;'>
             <table   style='border-spacing: 0px 0px 0px 0px; border: 0px solid #000;  width:100%;   font-size:8px; margin-bottom: 5px; ' >
                            <tr >
                                <th style='text-align:center; border-radius: 6px 0 0 0; border: 0.7px solid #000; width:6%; '>Item</th>
                                <th style='text-align:center;border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:74%;'>".utf8_encode("Descripción")."</th>
                                <th style='border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;  width:20%;'>Importe</th>
                            </tr>";

/*

                                <th style='border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000;width:8%; '>Importe</th>
                              <th style='border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:8%; '>Precio Unitario</th>
                              <th style=' border-radius: 0 6px 0 0; border-top: 0.7px solid #000;border-bottom: 0.7px solid #000;border-right: 0.7px solid #000; width:9%; '>Valor de Venta</th>
*/
  /************************************************************************************
  * + en esta seccion se realiza el concatenado de todas las cadenas                  *
  * + despues de concatenar la cadena se retorna para porder graficar con la libreria *
  *************************************************************************************/

        $i=0;
        while ($i<=$conta_cuerpo)
        {
          //ob_clean();
         if ($i==0)
         {
            $html=$html.$pagina.$cuerpo[$i]." </table> </div>".$base."<i style=' font-size:8px;margin-top: 190px; width:75%; margin-left:0px;'>Documento aprobado por la SUNAT </i>"."<i style='font-size:8px;width:25%; margin-top: 180px; margin-left:650px;'>pagina ".($i+1)."/".($conta_cuerpo+1)."</i>  </div> </div>";
          }
          else
          {
              $html=$html."<div style='page-break-after:always;'></div>".$pagina.$cuerpo[$i]." </table> </div>".$base."<i style='font-size:8px;margin-top: 190px; width:75%;margin-left:0px;'>Documento aprobado por la SUNAT</i>"."<i style='font-size:8px;width:25%;margin-top: 180px; margin-left:650px;'>pagina ".($i+1)."/".($conta_cuerpo+1)."</i>  </div> </div>";
          }
          $i=$i +1;
        }

      $html=$html."</body> </html>";


  //se eliminan todos los caracteres que no competen al dibujado de la nota de debito

        $html2 = preg_replace('/\r\n+|\r+|\n+|\t+/i','', $html);
        return $html2;
    }

}
?>
