<?php
class Nota_Credito_ctrllr extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('notas/Nota_Credito_model');
        $this->load->model('notas/Estados_model');
        $this->load->model('cuenta_corriente/Cuentas_corrientes_model');
        $this->load->library('session');
    $this->load->library('acceso_cls');
    $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
		$this->data['actividad'] = 'nota_credito';
		$this->data['rol'] = $this->Nota_Credito_model->get_rol($_SESSION['user_id']); 
        $this->acceso_cls->isLogin();
		$this->data['userdata'] = $this->acceso_cls->get_userdata();
		$permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
		if($permiso){ 
			$this->data['proceso'] = $permiso['ACTIVINOMB'];  
			$this->data['id_actividad'] = $permiso['ID_ACTIV']; 
			$this->data['menu']['padre'] =  $permiso['MENUGENPDR']; 
			$this->data['menu']['hijo'] =  $permiso['ACTIVIHJO']; 
		} else { 
			$this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
		}
        $this->direccion_pdf = 'assets/comprobante/nota_credito/pdf/';
        $this->direccion_xml = 'assets/comprobante/nota_credito/xml/';
        $this->direccion_qrtemp = 'assets/comprobante/nota_credito/';
        $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO";
        $this->mensaje_vacio = "ALERTA: 999 \n NO SE ENCONTRARON DATOS DISPONIBLES PARA LA SOLICITUD";
        $this->mensaje_acceso = "ALERTA: 996 \n NO SE PUDO REALIZAR LA OPERACIÓN";
        $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS.";
        $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO";
    }

    public function administrar_notasCedito(){
      	$permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
      	if($permiso){
			$rol = $this->Nota_Credito_model->get_rol($_SESSION['user_id']);
			if($rol == 15){
				$serie = $this->Nota_Credito_model->get_serie_user1($_SESSION['user_id']);
				$this->data['notas'] = $this->Nota_Credito_model->get_notas_credito_boleta_facturas($serie);
			} else {
				$this->data['notas'] = $this->Nota_Credito_model->get_notas_credito_boleta_facturas1($_SESSION['user_id']);
				$this->data['notas_autorizadas'] = $this->Nota_Credito_model->get_notas_autorizadas1();
			}
			$this->data['view'] = 'notas/Nota_Credito_view';
			$this->data['breadcrumbs'] = array(array('Nota Crédito - Boletas y Facturas',''));
			$this->load->view('template/Master', $this->data);
		} else {
			$this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
		}
    }

    public function buscar_notas(){
      
      	$permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
      	if($permiso){
        	$ajax = $this->input->get('ajax');
        	if($ajax){
				$tipo = $this->input->post('tipo');
				$serie = $this->input->post('serie');
				$numero = $this->input->post('numero');
				$documento = $this->input->post('documento');
				$resp = $this->Nota_Credito_model->buscar_nc($tipo,$serie,$numero,$documento);
				if($resp){
					$json = array('result' => true, 'mensaje' => 'OK','notas'=>$resp);
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json);
				} else {
					$json = array('result' => false, 'mensaje' =>  $this->config->item('_mensaje_vacio'));
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json);
          		}
        	} else {
				$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/x-json; charset=utf-8');
				echo json_encode($json);
        	}
		} else {
			$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/x-json; charset=utf-8');
			echo json_encode($json);
		}
    }

    public function get_autorizaciones(){
      	$permiso =  $this->Nota_Credito_model->get_permiso($_SESSION['user_id'], $this->data['actividad']);
      	if($permiso){
        	$ajax =  $this->input->get('ajax');
        	if($ajax){
          		$autorizaciones = $this->Nota_Credito_model->get_notas_autorizadas1();
				foreach ($autorizaciones as $key => $aut) {
					$nota = $this->Nota_Credito_model->notas_x_autorizacion($aut['FSCSERNRO'],$aut['FSCNRO'],$aut['FSCTIPO']);
					$valor_real = floatval($aut['FSCTOTAL']) - floatval($nota);
					$autorizaciones[$key]['FSCTOTAL'] = $valor_real;
				}
				if($autorizaciones){
					$autorizacion = "";
					foreach ($autorizaciones as $aut) {
						$autorizacion .= "<tr>".
											"<td>".$aut['FSCSERNRO']."</td>".
											"<td>".$aut['FSCNRO']."</td>".
											"<td>".(($aut['FSCTIPO'] == 0) ? "BOLETA" : "FACTURA")."</td>".
											"<td>".$aut['FSCFECH']."</td>".
											"<td>".$aut['FSCCLINOMB']."</td>".
											"<td style='text-align:right'>".number_format($aut['FSCTOTAL'],2,'.','')."</td>".
											"<td>".(($aut['AUT_OPE'] == 0) ? "CUALQUIERA" : $_SESSION['user_nom'])."</td>".
											"<td style='text-align:center'>".
												"<a data-placement='bottom' class='btn btn-default' data-toggle='tooltip' title='GENERAR NOTA DE CRÉDITO' href='".$this->config->item('ip')."notas/ver_boleta_factura/".$aut['FSCSERNRO']."/".$aut['FSCNRO']."/".$aut['FSCTIPO']."'>".
													"<i class='fa fa-spinner' aria-hidden='true'></i>".
												"</a>".
											"</td>".
										"</tr>";
					}
					$json = array('result' => true, 'mensaje' => "ok", 'autorizacion' => $autorizacion);
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json);
          		} else {
					$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_vacio'));
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json);
          		}
			}  else {
				$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/x-json; charset=utf-8');
				echo json_encode($json);
			}
      	} else {
			$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/x-json; charset=utf-8');
			echo json_encode($json);
      	}
    }

    public function get_detalle_notas(){
      	$permiso =  $this->Nota_Credito_model->get_permiso($_SESSION['user_id'], $this->data['actividad']);
      	if($permiso){
        	$ajax = $this->input->get("ajax");
        	if($ajax == true){
				$tipo = $this->input->post('tipo');
				$letra = $this->input->post('letra');
				$serie = $this->input->post('serie');
				$numero = $this->input->post('numero');
				$cabecera = $this->Nota_Credito_model->get_cabecera_nc($tipo,$letra,$serie,$numero);
				$detalle = $this->Nota_Credito_model->get_detalle_nc($tipo,$letra,$serie,$numero);
				$detalle1 = "";
				$subtotal = 0; $nota = 0; $diferencia = 0;
          		foreach ($detalle as $det) {
            		$detalle1 .= "<tr>".
                      				"<td>".$det['CONCEP_FACCONCOD']."</td>".
                      				"<td>".$det['FACCONDES']."</td>".
                      				"<td style='text-align:right'>".number_format(floatval($det['NCAFACPREC']),2,'.','')."</td>".
                      				"<td style='text-align:right'>".number_format(floatval($det['NCAPREDIF']),2,'.','')."</td>".
                      				"<td style='text-align:right'>".number_format(floatval($det['NCAPREOK']),2,'.','')."</td>".
                      			"</tr>";
           			$subtotal += floatval($det['NCAFACPREC']);
           			$nota += floatval($det['NCAPREDIF']);
           			$diferencia += floatval($det['NCAPREOK']);
          		}
          		$detalle1 .= "<tr><td></td>".
                       			"<td style='text-align:right' class='text-red'>TOTAL</td>".
								"<td style='text-align:right' class='text-red'>".number_format($subtotal,2,'.','')."</td>".
								"<td style='text-align:right' class='text-red'>".number_format($nota,2,'.','')."</td>".
								"<td style='text-align:right' class='text-red'>".number_format($diferencia,2,'.','')."</td>".
                       		"</tr>";
          		if($detalle){
            		$json = array('result' => true, 'mensaje' => "OK", "cabecera" =>$cabecera, "detalle" => $detalle1);
            		header('Access-Control-Allow-Origin: *');
            		header('Content-Type: application/x-json; charset=utf-8');
            		echo json_encode($json);
          		} else {
            		$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_vacio'));
            		header('Access-Control-Allow-Origin: *');
            		header('Content-Type: application/x-json; charset=utf-8');
            		echo json_encode($json);
          		}
        	} else {
          		$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
          		header('Access-Control-Allow-Origin: *');
          		header('Content-Type: application/x-json; charset=utf-8');
          		echo json_encode($json);
        	}
      	} else {
        	$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
        	header('Access-Control-Allow-Origin: *');
        	header('Content-Type: application/x-json; charset=utf-8');
        	echo json_encode($json);
      	}
    }

    public function ver_boleta_factura($serie,$numero,$numero1){
        $permiso =  $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'nota_credito');
        $rol  = $this->Nota_Credito_model->get_rol($_SESSION['user_id']);
        if($permiso && $rol == 10){
          $autorizacion  = $this->Nota_Credito_model->get_generacion_pendiente($serie,$numero,$numero1);
          if($autorizacion){
            $this->data['view'] = 'notas/Generar_NCBF_view';
            $this->data['igv'] = $this->Nota_Credito_model->get_igv();
            $this->data['factura'] = $this->Nota_Credito_model->get_facturasyboletas($serie,$numero,$numero1);
            $monto = $this->Nota_Credito_model->notas_x_autorizacion($serie,$numero,$numero1);
            $this->data['factura']['FSCTOTAL'] = floatval($this->data['factura']['FSCTOTAL']) - floatval($monto);
            $detalle = $this->Nota_Credito_model->get_facturasyboletas_detalle($serie,$numero,$numero1);
            $notas = $this->Nota_Credito_model->get_notas_credito1($serie,$numero,$numero1);
            $conceptos = array();
            foreach ($notas as $nc) {
              array_push($conceptos,$this->Nota_Credito_model->get_detalle_nc1($nc['BFNCATLET'], $nc['BFNCASERNRO'],$nc['BFNCANRO']));
            }
            foreach ($conceptos as $con) {
              $k = 0;
              foreach ($con as $valor) {
                $detalle[$k]['FSCPRECIO'] = floatval($detalle[$k]['FSCPRECIO']) - $valor['NCAPREDIF'];
                $k++;
              }
            }
            $this->data['factura_detalle'] =  $detalle;
            $this->data['tipo_nc'] = $this->Nota_Credito_model->get_tipo_nc();
            $this->data['proceso'] = 'Generación Notas Credito de Facturas y Boletas';
            $this->data['breadcrumbs'] = array(array('Notas', ''),array('Nota Crédito','notas/nota_credito'),array('Generar Nota Crédito Boleta y Factura',''));
            $this->load->view('template/Master', $this->data);
          } else {
            $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
            redirect($this->config->item('ip').'notas/nota_credito');
            return;
          }
        } else {
          $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
          redirect($this->config->item('ip').'inicio');
          return;
        }
    }

    public function generar_ncbf(){
        $permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'nota_credito');
        if($permiso){
          $datos_usuario = json_decode($this->input->post("datos_usuario"));
          $tipo = $this->input->post("tipo");
          $tipo1 = 0;
          if($tipo == 'FACTURA'){
              $tipo1 = 1;
          }
          $pendiente = $this->Nota_Credito_model->get_generacion_pendiente($datos_usuario->serie,$datos_usuario->numero,$tipo1);
          if($pendiente){
            $ajax = $this->input->get('ajax');
            $documento = json_decode($this->input->post("documento"));
            $documento1 = json_decode($this->input->post("documento1"));
            $conceptos = json_decode($this->input->post("conceptos"));
            $nota_credito = json_decode($this->input->post("nota_credito"));
            $nombre = $this->input->post("nombre");
            $seleccionado = $this->input->post("seleccionado");
            $motivo = $this->input->post("motivo");
            $direccion = $this->input->post("direccion");
            $oficina = $this->Nota_Credito_model->get_oficina();
            $__DIR_OFICINA = $this->Nota_Credito_model->get_direccion_sede();
            $___UBICACION = $this->Nota_Credito_model->get_nombre_sede();
            $__UBICACION = "";
            if($___UBICACION['DIST'] == 'TRUJILLO'){
                $__UBICACION = (isset($___UBICACION['UBICACION']) ? $___UBICACION['UBICACION'] : "");
            } else {
                $__UBICACION = $___UBICACION['DIST'].' - '.$___UBICACION['DIRECCION'];
            }
            $area = $this->Nota_Credito_model->get_area($_SESSION['NSARECOD']);
            $tipoAux = $tipo;
            header('Content-Type: text/html; charset=ISO-8859-1');
            $cabecera = array();
            $detalle = array();
            $tvvog = 0;
            $tvvoi = 0;
            $intereses = 0;
            for($i = 0;$i<sizeof($nota_credito);$i++){
                $tvvog += (floatval($nota_credito[$i]->descuento) + floatval($nota_credito[$i]->interes));
                $intereses += floatval($nota_credito[$i]->interes);
            }
            $serie_sunat = $this->Nota_Credito_model->get_serie($datos_usuario->serie,$datos_usuario->numero,$tipo1);
            $serie_usuario = $this->Nota_Credito_model->get_serie_user($_SESSION['user_id']);
            $cabecera[0] = ''.number_format($tvvog,2,'.','');
            $cabecera[1] = '';//.$tvvoi;
            $cabecera[2] = $tvvoe = '';
            $cabecera[3] = $tototrostributos = '';
            $cabecera[4] = $otroscargo1 = '';
            $cabecera[5] = $otroscargo2 = '';
            $cabecera[6] = $totdescuentos = '';
            if($tipo == 'FACTURA'){
              $ultimo_num = $this->Nota_Credito_model->obtener_ultimo_numero($serie_usuario,'F','A');
                $cabecera[7] = $ser_num = 'F'.$serie_usuario.'-'.$ultimo_num;
            } else {
              $ultimo_num = $this->Nota_Credito_model->obtener_ultimo_numero($serie_usuario,'B','A');
                $cabecera[7] = $ser_num = 'B'.$serie_usuario.'-'.$ultimo_num;
            }
            $cabecera[8] = $f_emision = date('Y-m-d');
            $cabecera[9] = $t_moneda = 'PEN';
            $cabecera[10] = $num_relac = $serie_sunat;
            $cabecera[11] = $tip_nota_credito = $seleccionado;  //responsecode 01,02,03... -> Devolución parcial
            $cabecera[12] = $descrip_nota_credito = $motivo;//'Comentario de la NC Devolucion Parcial Productos defectuosos';
            if($tipo == 'FACTURA'){
                $cabecera[13] = $tip_doc_modificado = '01';  // factura 01 y boltea 03
            } else {
                $cabecera[13] = $tip_doc_modificado = '03';  // factura 01 y boltea 03
            }
            $cabecera[14] = $refe_tip_doc = '';  //serie-numero de guia de transporte
            $cabecera[15] = $refe_cod_doc = '';  //tipo de guia ejemplo 09 catalogo 01 sunat
            $cabecera[16] = $ad_tip_doc = '';  //en caso de emitir nota de credito por anulación por error en el RUC (factura emitida a un adquirente o usuario equivocado), y cuando con anterioridad a la emisión de esta nota de crédito, se hubiere emitido la factura correcta (al adquirente o usario correcto), se consignar· en este elemento la referencia a Èsta ˙ltima. Para este fin se utilizar· el tag cac:AdditionalDocumentReference, consignando como cÛdigo de tipo de documento (cbc:DocumentTypeCode) el valor ?01? (Factura ? emitida para corregir error en el RUC) del cat·logo 12 y en el campo cbc:ID, se consignar· la serie y número de dicha factura, separado por guión.
            $cabecera[17] = $ad_cod_doc = '';  //tipo de documento adicional
            if($tipo == 'FACTURA'){
                $ruc_cliente = $this->Nota_Credito_model->get_ruc_cliente($datos_usuario->serie,$datos_usuario->numero,$tipo1);
                $cabecera[18] = $ru_cliente = $ruc_cliente;  //ruc del cliente
                $cabecera[19] = $iden_doc_cliente = '6';  //tipo del documento identidad del cliente
            } else {
                $dni_cliente = $this->    Nota_Credito_model->get_dni_cliente($datos_usuario->serie,$datos_usuario->numero,$tipo1);
                $cabecera[18] = $ru_cliente = $dni_cliente;  //ruc del cliente
                $cabecera[19] = $iden_doc_cliente = '1';  //tipo del documento identidad del cliente
            }
            $cabecera[20] = $nom_cliente = $nombre;  //nombre del cliente
            $cabecera[21] = $mon_total_isc = '';  //Sumatoria ISC
            $cabecera[22] = $mon_total_igv = ''.number_format($intereses,2,'.','');  //Sumatoria IGV
            $cabecera[23] = $mon_total_otros = ''; //SUMATORIA OTROS TRIBUTOS
            $cabecera[24] = $importe_total = ''.$tvvog; //IMPORTE TOTAL
            $cabecera[25] = $sum_otros_cargos = ''; //SUMATORIA OTROS CARGOS
            $cabecera[26] = $invoiceTypeCode='07';
            $cabecera[27] = $ambiente = 'produccion';  //valores 'homologacion','beta','produccion'
            $cabecera[28] = $tipo = '1';  // Factura. Notas vinculadas. Servicios P˙blicos. Resumen Diario. ComunicaciÛn de Baja. Lotes de Facturas.
            $valor_referencia = $this->Nota_Credito_model->get_igv_referencia($datos_usuario->serie,$datos_usuario->numero,$tipo1);
            for($i = 0;$i<sizeof($conceptos);$i++){
                $detalle[$i][0] = ($i+1);
                $detalle[$i][1] = 'ZZ';
                $detalle[$i][2] = $conceptos[$i]->CANT;
                $detalle[$i][3] = 'PEN';
                $detalle[$i][6] = '01';
                $detalle[$i][7] = $nota_credito[$i]->interes;
                $detalle[$i][8] = $nota_credito[$i]->interes;
                $detalle[$i][9] = '10';
                $PSIGV = (floatval($conceptos[$i]->PUNIT)/(1+floatval($valor_referencia)/100));
                $IGV_1 = number_format(($PSIGV * (floatval($valor_referencia)/100)),2,'.','');
                $precio_sin_igv = number_format((floatval($conceptos[$i]->PUNIT) - $IGV_1),2,'.','');
                $valor_venta = number_format(($precio_sin_igv * intval($conceptos[$i]->CANT)),2,'.','');
                $detalle[$i][4] = $valor_venta;
                $detalle[$i][5] = $conceptos[$i]->PUNIT;
                $detalle[$i][10] = '1000';
                $detalle[$i][11] = 'IGV';
                $detalle[$i][12] = 'VAT';
                $detalle[$i][13] = '';
                $detalle[$i][14] = '';
                $detalle[$i][15] = $conceptos[$i]->FACCONDES;
                $detalle[$i][16] = $conceptos[$i]->FACCONCOD;
                $detalle[$i][17] = 'PEN';
                $detalle[$i][18] = $nota_credito[$i]->descuento;
            }
            try {
                $sClient = new SoapClient('https://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL', array('trace' => 1,'encoding' => 'ISO-8859-1'));
                $result = $sClient->__call('metodo2', array($cabecera, $detalle));
                if(isset($result[3]) && $result[3] != ""){
                    $mont_total_op_gravada = 0;
                    $subtotal_vista = 0;
                    $dire_img = $this->config->item('ip')."img/logo3.png";
                    foreach($nota_credito as $nc => $val){
                        $mont_total_op_gravada += floatval($val->interes);
                        $subtotal_vista += floatval($val->descuento);
                    }
                    $seri_doc_modificado = $serie_sunat;
                    $r_emisor = "20131911310"; //RUC de SEDALIB
                    $im_total = $mont_total_op_gravada + $subtotal_vista;
                    $valor = $this->nota_credito($result[3],1, 1, $direccion, $dire_img, date("d"), date("m"), date("Y"), $mont_total_op_gravada, "20.00", "", "", "2.0", "", $cabecera[7], $f_emision, $t_moneda, "", $tip_nota_credito, $descrip_nota_credito, $seri_doc_modificado, $tip_doc_modificado, $cabecera[14] , $refe_cod_doc, $ad_tip_doc, $ad_cod_doc, $r_emisor, $cabecera[18], $cabecera[20], $mon_total_isc,$mon_total_igv, $mon_total_otros,$im_total, $sum_otros_cargos, $conceptos, $nota_credito,$oficina, $__DIR_OFICINA, $area,$num_relac,$motivo,$tipoAux,$__UBICACION);
                    /****  GENERANDO EL XML  ****/
                   $xml = base64_decode ( $result[count( $result )-1] );
                    $dir_file = $this->direccion_xml.$cabecera[7].'.xml';
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/GeneSys/'.$dir_file, $xml);
                    ob_flush();
                   $this->load->library('dompdf_pdf');
                    $mipdf = $this->dompdf_pdf->cargar();
                    $mipdf->set_paper('A5', 'landscape');
                    $mipdf->load_html(utf8_decode($valor));
                    $mipdf->render();
                    $output = $mipdf->output();
                    $dir_pdf = $this->direccion_pdf.$cabecera[7] .'.pdf';
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/GeneSys/'.$dir_pdf, $output);
                    $guardado = $this->Nota_Credito_model->save_nc_fb('A',$serie_usuario,$ultimo_num,$cabecera,$datos_usuario,$tipo1,$nota_credito,$dir_file,$dir_pdf,$result[3],$motivo,$seleccionado);
                    if($guardado['resultado']){
                      $this->Nota_Credito_model->actualizar_autorizacion($datos_usuario->serie,$datos_usuario->numero,$tipo1);
                      $document[0] = $cabecera[7]; // 'FF11-1'; // serie y numero
                      $document[1] = $cabecera[26]; // invoiceTypeCode 07
                      $document[2] = $cabecera[27]; // 'beta'; // ambiente al que se envia
                      $document[3] = $cabecera[28]; // '1'; // servidor al que se envia
                      $json = array('result' => true, 'mensaje' => "ok" , 'sunat' => $document,'guardado' => $guardado);
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    } else {
                      $json = array('result' => false, 'mensaje' => $guardado['rpta']);
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
               } else {
                  $json = array('result' => false, 'mensaje' =>"NO SE PUDO GENERAR LA NOTA CRÉDITO");
                  header('Access-Control-Allow-Origin: *');
                  header('Content-Type: application/x-json; charset=utf-8');
                  echo json_encode($json);
                }
            } catch (SoapFault $fault) {
                    $json = array('result' => false, 'mensaje' =>"No se pudo generar la Nota Crédito".$fault->faultcode." - ".$fault->faultstring);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
            }
          } else {
            $json = array('result' => false, 'mensaje' =>"NO HAY AUTORIZACIONES PARA GENERAR NOTAS DE CRÉDITO O YA FUERON REALIZADAS",'tipo' => 2);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else {
          $json = array('result' => false, 'mensaje' =>"NO SE PUEDE GENERAR NOTAS DE CRÉDITO", 'tipo' => 2);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
    }


    public function actualizar_nc(){
      $permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'nota_credito');
      if($permiso){
        $ajax =  $this->input->get('ajax');
        if($ajax){
          $sunat = $this->input->post('sunat');
          $guardado = $this->input->post('guardado');
          $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat( $guardado['tipo_nc'], $guardado['tipo_doc'], $guardado['serie'],$guardado['numero'],6);
          if($respuesta['resultado']){
            $json = array('result' => true, 'mensaje' => 'SE EMITIO EL DOCUMENTO, PERO NO NO HA SIDO ATENDIDO POR SUNAT');
              header('Access-Control-Allow-Origin: *');
              header('Content-Type: application/x-json; charset=utf-8');
              echo json_encode($json);
          } else {
            $json = array('result' => false, 'mensaje' => 'DOCUMENTO NO ATENDIDO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
              header('Access-Control-Allow-Origin: *');
              header('Content-Type: application/x-json; charset=utf-8');
              echo json_encode($json);
          }
        } else {
          $json = array('result' => false, 'mensaje' =>$this->mensaje_error);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' =>$this->mensaje_acceso);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function enviar_sunat(){
      $permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'nota_credito');
      if($permiso){
        $ajax =  $this->input->get('ajax');
        if($ajax){
          $sunat = $this->input->post('sunat');
          $guardado = $this->input->post('guardado');
          $resp = $this->enviar_ws($sunat);
          if(!$resp['resultado']){
            $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat( $guardado['tipo_nc'], $guardado['tipo_doc'], $guardado['serie'],$guardado['numero'],6);
            if($respuesta['resultado']){
              $json = array('result' => true, 'mensaje' => 'SE EMITIO EL DOCUMENTO, PERO NO NO HA SIDO ATENDIDO POR SUNAT');
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            } else {
              $json = array('result' => false, 'mensaje' => 'DOCUMENTO NO ATENDIDO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
          } else {
            $rpta_aux = $resp['rpta'];
            $this->guardo_rpta_sunat($guardado['tipo_nc'], $guardado['tipo_doc'], $guardado['serie'],$guardado['numero'],$rpta_aux);
          }
        } else {
          $json = array('result' => false, 'mensaje' =>$this->mensaje_error);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' =>$this->mensaje_acceso);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function envio_masivo_nc(){
      $permiso = $this->Estados_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'estados_nc');
      if($permiso){
        $ajax =  $this->input->get('ajax');
        if($ajax ==  true){
          $tipo = $this->input->post("tipo");
          $fecha_inicio = $this->input->post("fecha_inicio");
          $fecha_fin = $this->input->post("fecha_fin");
          $notas = $this->Nota_Credito_model->get_notas_que_masivas($tipo,$fecha_inicio,$fecha_fin);
          $rep = array();
          foreach ($notas as $nota) {
            $document[0] = $nota['BFNCATLET'].$nota['BFNCASERNRO']."-".$nota['BFNCANRO']; // 'FF11-1'; // serie y numero
            $document[1] =  '07'; // invoiceTypeCode 07
            $document[2] = 'produccion'; // 'beta'; // ambiente al que se envia
            $document[3] = '1'; // '1'; // servidor al que se envia
            $resp = $this->enviar_ws($document);
            $docuemnto = $nota['BFNCATLET'].$nota['BFNCASERNRO']."-".$nota['BFNCANRO'];
            if(!$resp['resultado']){
               $rep1 = array('result'=> false, 'mensaje' => "EL DOCUMENTO NO HA SIDO ATENDIDO POR SUNAT");
                array_push($rep,array('nota' =>$docuemnto , $rep1 ) );
            } else {
              $rpta_aux = $resp['rpta'];
              $respuesta = $this->guardo_rpta_sunat2($nota['BFNCATIPO'], $nota['BFNCATLET'], $nota['BFNCASERNRO'], $nota['BFNCANRO'],$rpta_aux);
              array_push($rep,array('nota' => $nota['BFNCATLET'].$nota['BFNCASERNRO']."-".$nota['BFNCANRO'], $respuesta));
            }
          }
          if($notas){
            $json = array('result' => true, 'mensaje' => "ok", "respuesta" => $rep);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json = array('result' => false, 'mensaje' => $this->mensaje_vacio);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else {
          $json = array('result' => false, 'mensaje' => $this->mensaje_error);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function reenviar_sunat(){
      $ajax =  $this->input->get('ajax');
      if($ajax){
        $tipo = $this->input->post('tipo');
        $serie = $this->input->post('serie');
        $numero = $this->input->post('numero');
        $letra = $this->input->post('letra');
        $invoiceTypeCode = '07';
        $document[0] = $letra.$serie."-".$numero; // 'FF11-1'; // serie y numero
        $document[1] = $invoiceTypeCode; // invoiceTypeCode 07
        $document[2] = 'produccion'; // 'beta'; // ambiente al que se envia
        $document[3] = '1'; // '1'; // servidor al que se envia
        $resp = $this->enviar_ws($document);
        if(!$resp['resultado']){
          //$respuesta = $this->Nota_Credito_model->actualizar_estado_sunat( $tipo, $letra, $serie, $numero,6);
            $json = array('result' => false, 'mensaje' => ' EL DOCUMENTO NO HA SIDO ATENDIDO POR SUNAT');
              header('Access-Control-Allow-Origin: *');
              header('Content-Type: application/x-json; charset=utf-8');
              echo json_encode($json);
        } else {
          $rpta_aux = $resp['rpta'];
          $this->guardo_rpta_sunat1($tipo, $letra, $serie, $numero,$rpta_aux);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    private function guardo_rpta_sunat2($tipo_nc,$tipo_doc,$serie,$numero,$rpta_aux){
      if(!isset($rpta_aux[4])){
        $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat($tipo_nc,$tipo_doc,$serie,$numero,6);
        if($respuesta['resultado']){
          return array('result' => true, 'mensaje' => 'EL DOCUMENTO NO HA SIDO ATENDIDO POR SUNAT');
        } else {
          return array('result' => false, 'mensaje' => 'DOCUMENTO NO HA SIDO ATENDIDO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
        }
      } else if($rpta_aux[4] == '0'){
          $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,3, $rpta_aux[5]);
           if($respuesta['resultado']){
             return array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIO A SUNAT CON ÉXITO');
           } else {
             return array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIO A SUNAT CON ÉXITO, ERROR AL ALMACENAR EN LA BASE DE DATOS');
           }
       }else if($rpta_aux[4] == '2380'){
         $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,5, $rpta_aux[5]);
         if($respuesta['resultado']){
           return array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIÓ A SUNAT, PERO SE ENCUENTRA CON OBSERVACIONES');
         } else {
           return array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIÓ A SUNAT, PERO SE ENCUENTRA CON OBSERVACIONES, ERROR AL ALMACENAR EN LA BASE DE DATOS');
         }
       }else{
         $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,4, $rpta_aux[5]);
         if($respuesta['resultado']){
           return  array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO FUE RECHAZADO POR SUNAT');
         } else {
           return array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO FUE RECHAZADO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
         }
       }
    }

    private function guardo_rpta_sunat1($tipo_nc,$tipo_doc,$serie,$numero,$rpta_aux){
      if(!isset($rpta_aux[4])){
        $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat($tipo_nc,$tipo_doc,$serie,$numero,6);
        if($respuesta['resultado']){
          $json = array('result' => true, 'mensaje' => 'EL DOCUMENTO NO HA SIDO ATENDIDO POR SUNAT');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'DOCUMENTO NO HA SIDO ATENDIDO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
      } else if($rpta_aux[4] == '0'){
          $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,3, $rpta_aux[5]);
           if($respuesta['resultado']){
             $json = array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIO A SUNAT CON ÉXITO');
             header('Access-Control-Allow-Origin: *');
             header('Content-Type: application/x-json; charset=utf-8');
             echo json_encode($json);
           } else {
             $json = array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIO A SUNAT CON ÉXITO, ERROR AL ALMACENAR EN LA BASE DE DATOS');
               header('Access-Control-Allow-Origin: *');
               header('Content-Type: application/x-json; charset=utf-8');
               echo json_encode($json);
           }
       }else if($rpta_aux[4] == '2380'){
         $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,5, $rpta_aux[5]);
         if($respuesta['resultado']){
           $json = array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIÓ A SUNAT, PERO SE ENCUENTRA CON OBSERVACIONES');
           header('Access-Control-Allow-Origin: *');
           header('Content-Type: application/x-json; charset=utf-8');
           echo json_encode($json);
         } else {
           $json = array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENVIÓ A SUNAT, PERO SE ENCUENTRA CON OBSERVACIONES, ERROR AL ALMACENAR EN LA BASE DE DATOS');
             header('Access-Control-Allow-Origin: *');
             header('Content-Type: application/x-json; charset=utf-8');
             echo json_encode($json);
         }
       }else{
         $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,4, $rpta_aux[5]);
         if($respuesta['resultado']){
           $this->Nota_Credito_model->anular_nota_credito($tipo_nc,$tipo_doc,$serie,$numero);
           $json = array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO FUE RECHAZADO POR SUNAT');
           header('Access-Control-Allow-Origin: *');
           header('Content-Type: application/x-json; charset=utf-8');
           echo json_encode($json);
         } else {
           $json = array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO FUE RECHAZADO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
             header('Access-Control-Allow-Origin: *');
             header('Content-Type: application/x-json; charset=utf-8');
             echo json_encode($json);
         }
       }
    }


    private function guardo_rpta_sunat($tipo_nc,$tipo_doc,$serie,$numero,$rpta_aux){
      if(!isset($rpta_aux[4])){
        $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat($tipo_nc,$tipo_doc,$serie,$numero,6);
        if($respuesta['resultado']){
          //echo $rpta_aux[4];
          $json = array('result' => true, 'mensaje' => 'SE EMITIO EL DOCUMENTO, PERO NO HA SIDO ATENDIDO POR SUNAT');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'DOCUMENTO NO ATENDIDO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
      } else if($rpta_aux[4] == '0'){
          $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,3, $rpta_aux[5]);
           //$this->Comprobante_pago_model->actualizar_respuesta_ws($cliente, $nro_sedalib, true, $rpta_aux[5]);
           if($respuesta['resultado']){
             //echo $rpta_aux[4] ."- ".$rpta_aux[5];
             $json = array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO SE GENERO CON ÉXITO');
             header('Access-Control-Allow-Origin: *');
             header('Content-Type: application/x-json; charset=utf-8');
             echo json_encode($json);
           } else {
             $json = array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO SE GENERO CON ÉXITO, ERROR AL ALMACENAR EN LA BASE DE DATOS');
               header('Access-Control-Allow-Origin: *');
               header('Content-Type: application/x-json; charset=utf-8');
               echo json_encode($json);
           }
       }else if($rpta_aux[4] == '2380'){
         $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,5, $rpta_aux[5]);
         if($respuesta['resultado']){
           //echo $rpta_aux[4] ."- ".$rpta_aux[5];
           $json = array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENCUENTRA CON OBSERVACIONES');
           header('Access-Control-Allow-Origin: *');
           header('Content-Type: application/x-json; charset=utf-8');
           echo json_encode($json);
         } else {
           $json = array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO SE ENCUENTRA CON OBSERVACIONES, ERROR AL ALMACENAR EN LA BASE DE DATOS');
             header('Access-Control-Allow-Origin: *');
             header('Content-Type: application/x-json; charset=utf-8');
             echo json_encode($json);
         }
       }else{
         $respuesta = $this->Nota_Credito_model->actualizar_estado_sunat1( $tipo_nc,$tipo_doc,$serie,$numero,4, $rpta_aux[5]);
         if($respuesta['resultado']){
           //echo $rpta_aux[4] ."- ".$rpta_aux[5];
           $json = array('result' => true, 'mensaje' => 'LA NOTA DE CRÉDITO FUE RECHAZADO POR SUNAT','data'=> $dir_pdf);
           header('Access-Control-Allow-Origin: *');
           header('Content-Type: application/x-json; charset=utf-8');
           echo json_encode($json);
         } else {
           $json = array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO FUE RECHAZADO POR SUNAT, ERROR AL ALMACENAR EN LA BASE DE DATOS');
             header('Access-Control-Allow-Origin: *');
             header('Content-Type: application/x-json; charset=utf-8');
             echo json_encode($json);
         }
       }
    }

    private function enviar_ws($doc){
      try {
        $sClient = new SoapClient('https://land.sedalib.com.pe/paraSeda/fele41ss/ws/gWSDL1.php?WSDL', array('trace' => 1,'encoding' => 'ISO-8859-1'));
        $result = $sClient->__call('metodo6', array($doc));
           if($result){
             return array('resultado'=>true, 'rpta'=>$result);
           }
        } catch (SoapFault $fault) {
            return array('resultado'=>false, 'rpta'=>$fault);
            /*echo 'Fallo el Web Service - codigo de Error:<br><br>';
            echo var_dump($fault->faultcode . '<br><br>');
            echo var_dump($fault->faultstring . '<br><br>');
            echo var_dump($fault);*/
        }
    }

     public function creo_QR($RUC,$tipo,$serie,$mto_total_igv,$mto_total,$fecha_emi) {
        $this->load->library('barcode_generador');
        $bar = $this->barcode_generador->cargar();
        //$bar = new BARCODE();
        $qr_values[0]    = $RUC ."|".$tipo ."|".$serie ."|".$mto_total_igv ."|".$mto_total ."|".$fecha_emi ;
        //$bar->QRCode_save('text', $qr_values, 'qr_imagen', './imagen/','png',50,2,'#ffffff','#000000','L',false);
        $bar->QRCode_save('text', $qr_values, $serie, $_SERVER['DOCUMENT_ROOT'].'/GeneSys/assets/comprobante/nota_credito/','png',50,2,'#ffffff','#000000','L',false);
        return $this->config->item('ip').$this->direccion_qrtemp.$serie.'.png';
    }

    public function nota_credito($firma,$adi_cabecera, $adi_base, $dire_cliente, $dire_img, $fecha_dia, $fecha_mes, $fecha_anio, $mont_total_op_gravada, $mont_total_op_inafectadas, $monto_total_op_exoneradas, $monto_total_op_otros_cargos, $t_ubl, $est_doc, $v_num_corre, $f_emision, $t_moneda, $cod_num_rel, $tip_nota_credito, $descrip_nota_credito, $seri_doc_modificado, $tip_doc_modificado, $refe_tip_doc, $refe_cod_doc, $ad_tip_doc, $ad_cod_doc, $r_emisor, $ru_cliente, $n_cliente, $mon_total_isc, $mon_total_igv, $mon_total_otros, $im_total, $sum_otros_cargos, $nota_credito,$nota_credito1,$oficina, $__DIR_OFICINA, $area,$num_relac,$motivo,$tipoAux,$__UBICACION){

         $i=0;
         $sub_total=0;
         $sumador=0;
         $conta_cuerpo=0;
         $this->load->library('NumberToText');
         $ntt = $this->numbertotext->load(NULL);
         while($i<sizeof($nota_credito)){
              if(strlen($nota_credito[$i]->FACCONDES)<129){
                $sumador= $sumador +210;
              }
              else
              {
                 if((strlen($nota_credito[$i]->FACCONDES)%129)==0)
                  {
                    $sumador= $sumador +strlen($nota_credito[$i]->FACCONDES);
                  }
                  else
                  {
                    $sumador= $sumador + (((strlen($nota_credito[$i]->FACCONDES)/129)*129) + (strlen($nota_credito[$i]->FACCONDES)%129))+ 180;
                   // echo "**** ".strlen($nota_credito[$i][0])."******";
                  }
              }

              //echo "-->".$sumador."<--";


              if($sumador>=3900)
              {



                $sumador=0;
                $conta_cuerpo= $conta_cuerpo +1;

                    if(!isset($cuerpo[$conta_cuerpo]))
                    {

                        $cuerpo[$conta_cuerpo]='';
                        $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                <td style=' text-align:center; border-bottom:0.7px solid #000; border-left:0.7px solid #000;border-right:0.7px solid #000;'>".$nota_credito[$i]->FACCONCOD."</td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> <p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$nota_credito[$i]->FACCONDES."</p></td>
                                <td style='text-align:right;border-bottom:0.7px solid #000; border-right:0.7px solid #000;'><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($nota_credito1[$i]->descuento), 2, '.', '') : (number_format((floatval($nota_credito1[$i]->descuento) + floatval($nota_credito1[$i]->interes)),2,'.','')))."</span></td>
                                  </tr>";
                    }
                    else
                    {
                         $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                <td style=' text-align:center; border-bottom:0.7px solid #000; border-left:0.7px solid #000;border-right:0.7px solid #000;'>".$nota_credito[$i]->FACCONCOD."</td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> <p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$nota_credito[$i]->FACCONDES."</p></td>
                                <td style='text-align:right;border-bottom:0.7px solid #000; border-right:0.7px solid #000;'><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($nota_credito1[$i]->descuento), 2, '.', '') : (number_format((floatval($nota_credito1[$i]->descuento) + floatval($nota_credito1[$i]->interes)),2,'.','')))."</span></td>
                                  </tr>";

                    }

                $sumador=strlen($nota_credito[$i][1]);

              }
              else
              {
                  /*
                                <td style='text-align:right;border-bottom:0.7px solid #000; border-right:0.7px solid #000;'><span style='margin-right:5px;'>".number_format($nota_credito[$i][2], 2, '.', '')."</span></td>
                                <td style='text-align:right;border-bottom:0.7px solid #000;border-right:0.7px solid #000;'><span style='margin-right:5px;'>".number_format($nota_credito[$i][3], 2, '.', '')."</span></td> */
                    $sumador=$sumador +40;
                    if(!isset($cuerpo[$conta_cuerpo]))
                    {
                        $cuerpo[$conta_cuerpo]='';
                         $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                <td style=' text-align:center; border-bottom:0.7px solid #000; border-left:0.7px solid #000;border-right:0.7px solid #000;'>".$nota_credito[$i]->FACCONCOD."</td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> <p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$nota_credito[$i]->FACCONDES."</p></td>
                                <td style='text-align:right;border-bottom:0.7px solid #000; border-right:0.7px solid #000;'><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($nota_credito1[$i]->descuento), 2, '.', '') : (number_format((floatval($nota_credito1[$i]->descuento) + floatval($nota_credito1[$i]->interes)),2,'.',''))) ."</span></td>
                                  </tr>";

                    }
                    else
                    {
                         $cuerpo[$conta_cuerpo]=$cuerpo[$conta_cuerpo]."<tr>
                                <td style=' text-align:center; border-bottom:0.7px solid #000; border-left:0.7px solid #000;border-right:0.7px solid #000;'>".$nota_credito[$i]->FACCONCOD."</td>
                                <td style=' border-bottom:0.7px solid #000; border-right:0.7px solid #000;'> <p style='font-size:8px; margin-left:5px; margin-top:0px; margin-bottom:0px;'>".$nota_credito[$i]->FACCONDES."</p></td>
                                <td style='text-align:right;border-bottom:0.7px solid #000; border-right:0.7px solid #000;'><span style='margin-right:5px;'>".(($tipoAux == 'FACTURA') ? number_format(floatval($nota_credito1[$i]->descuento), 2, '.', '') : (number_format((floatval($nota_credito1[$i]->descuento) + floatval($nota_credito1[$i]->interes)),2,'.','')))."</span></td>
                                  </tr>";
                    }

              }
             $sub_total +=  $nota_credito1[$i]->descuento;
            $i=$i+1;
          }
  /**************************************************************************/
   // creo la imagen
   $qr =  $this->creo_QR($ru_cliente,"07",$v_num_corre,$mont_total_op_gravada,$im_total,date("Y-m-d"));
   // cambio el tamaño de la imagen
   //cambia_tamanio();
  /**************************************************************************/
  /***************************************************************************
  * + en esta seccion se empieza a escribir todo el html para el dibujado de *
  * la nota de credito                                                       *
  * + se divide en cabecera ,cuerpo y base                                   *
  * + para el debujado utilizo cadenas que contienen html                    *
  * + la libreria interpreta la cadena y genera el pdf                       *
  ****************************************************************************/
  $cabecera="<div style='width:100% ; height:150px; margin-top:-30px; '>
            <div style='width:100% ; height:100px;'>
                <div style='height:100px; width:33%; '>
                  <div style='height:85px; width:90%;text-align:center '>
                     <img src='".$dire_img."' style='width: 100%; height:60px;margin-bottom:4px;margin-bottom:-10px'><br><i style='font-size:7px !important;margin-top:-20px;'>".$__DIR_OFICINA."</i><br><i style='font-size:7px;'>".$__UBICACION."</i>
                  </div>
                  <div style='height:15px; width:70%; '>
                     <table style='height:15px; width:100%; font-size:8px; '>
                        <tr>
                          <td style=' text-align:center; border-bottom-style:dotted;border-width: 0.7px; width:20%;'>
                          ".$fecha_dia."
                          </td>
                          <td style=' width:2%;'>
                           de
                          </td>
                          <td style='text-align:center;border-bottom-style:dotted; border-width: 0.7px; width:45%;' >
                           ".$fecha_mes."
                          </td>
                          <td style=' width:3%;'>
                            del
                          </td>
                          <td style='text-align:center;border-bottom-style:dotted;border-width: 0.7px;  width:30%;' >
                            ".$fecha_anio."
                          </td>
                        </tr>
                     </table>
                  </div>

                </div>";
  $adi_datos="<div  style=' height:100px;width:40% ;position:absolute;  margin-top:-25px; margin-left:30%;'>
                        <table width='100%' cellpading='1' cellspacing='1'>
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
                                   <i style='margin-top:2px; text-align:left;margin-left:6px; font-size:8px; '>".$num_relac." - ".$tipoAux."</i>
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
  if($adi_cabecera==1)
  {
    $cabecera=$cabecera.$adi_datos." <div style='position:absolute; height:100px; width:30%; margin-left:70%;border-style:solid; border-width:0.7px;border-radius: 10px 10px 10px 10px; margin-top:10px;'>
                    <h6 style='font-size:12px;text-align:center; margin-top:10px; margin-bottom:5px;'>
                         ".utf8_encode("R.U.C. 	N°").$r_emisor."
                    </h6>
                    <h6 style='font-size:12px; text-align:center;margin-top:10px; margin-bottom:5px; width:99%; margin-left:0.5%;'>
                        NOTA DE CREDITO
                    </h6>
                    <h6 style='font-size:12px; text-align:center; margin-top:10px;  margin-bottom:4px;'>
                        ".$v_num_corre."
                    </h6>
                </div>
            </div>
            <div style='width:100% ; height:50px;'>
                <table style='width:100% ; margin-top:5px; font-size:8px;'>
                  <tr>
                    <td style='width:10% ;'>
                      USUARIO :
                    </td>
                    <td colspan='3' style='border-bottom:0.7px solid #000;' >
                      ".$n_cliente."
                    </td>
                  </tr>
                  <tr>
                    <td style='width:10% ;'>
                     ".utf8_encode("DIRECCIÓN :")."
                    </td>
                    <td style='width:50% ;border-bottom:0.7px solid #000;'>
                      ".$dire_cliente."
                    </td>
                    <td style='width:10% ;'>
                     Documento:
                    </td>
                    <td style='width:30% ;border-bottom:0.7px solid #000;'>
                      ".(($tipoAux == "FACTURA") ? "(R.U.C.) ".$ru_cliente : "(D.N.I.) ".$ru_cliente)."
                    </td>
                  </tr>
                  <tr>
                    <td colspan='4'>
                        Hemos Abonado a su cuenta lo siguiente:
                    </td>
                  </tr>
                </table>
            </div>
        </div>";
  }
  else
  {
    $cabecera=$cabecera." <div style='position:absolute; height:100px; width:30%; margin-left:70%;border-style:solid; border-width:0.7px;border-radius: 10px 10px 10px 10px;'>
                    <h6 style='font-size:12px;text-align:center; margin-top:10px; margin-bottom:5px;'>
                         ".utf8_encode("R.U.C. 	N°").$r_emisor."
                    </h6>
                    <h6 style='font-size:12px; text-align:center;margin-top:10px; margin-bottom:5px;'>
                        NOTA DE CREDITO
                    </h6>
                    <h6 style='font-size:12px; text-align:center; margin-top:10px;  margin-bottom:4px;'>
                        ".$v_num_corre."
                    </h6>
                </div>
            </div>
            <div style='width:100% ; height:50px;'>
                <table style='width:100% ; margin-top:5px; font-size:8px;'>
                  <tr>
                    <td style='width:10% ;'>
                      USUARIO :
                    </td>
                    <td colspan='3' style='border-bottom:0.7px solid #000;' >
                      ".$n_cliente."
                    </td>
                  </tr>
                  <tr>
                    <td style='width:10% ;'>
                     ".utf8_encode("DIRECCIÓN :")."
                    </td>
                    <td style='width:50% ;border-bottom:0.7px solid #000;'>
                      ".$dire_cliente."
                    </td>
                    <td style='width:10% ;'>
                     Documento :
                    </td>
                    <td style='width:30% ;border-bottom:0.7px solid #000;'>
                      ".(($tipoAux == "FACTURA") ? "(R.U.C.) ".$ru_cliente : "(D.N.I.) ".$ru_cliente)."
                    </td>
                  </tr>
                </table>
            </div>
        </div>";
  }
  $base="<div style=' margin-top:5px; width:100%; height:50px;'>";
  $agrego_base="
          <div style='position:absolute;  width:35%; text-align:center'>
          <img src='".$qr."' style='width: 40%; height:80px; '>
          </div>";
  if($adi_base==1)
  {
    $base=$base.$agrego_base."<div style='position:absolute; margin-left:36%;  width:34%; '>
           <table style='width:100%;font-size:8px;'>
           <tr>
                <td colspan='5' style='text-align:center;border:0.7px solid #000;'>
                SON: ".$ntt->numtoletras($im_total)."
                </td>
           </tr>
              <tr>
                <td colspan='5' style='text-align:center;'>
                    CANCELADO
                </td>
              </tr>
              <tr>
                <td  style='text-align:center; width:15%; border-bottom: 0.7px dotted #000;'>
                  ".$fecha_dia."
                </td>
                <td style=' width:5%;'>
                  de
                </td>
                <td style='text-align:center; width:60%; border-bottom: 0.7px dotted #000;'>
                ".$fecha_mes."
                </td>
                <td style=' width:5%;' >
                  de
                </td>
                <td style='text-align:center;  width:15%; border-bottom: 0.7px dotted #000;'>
                ".$fecha_anio."
                </td>
              </tr>
              <tr>
                <td colspan='5' style='height:15px; border-bottom:0.7px solid #000;' >
                </td>
              </tr>
              <tr>
                <td colspan='5' style='text-align:center;' >
                  p. SEDALIB S.A.
                </td>
              </tr>

           </table>
          </div>
          <div style='position:absolute; margin-left:82%;  width:18%;'>
              <table style='width:100%; border-spacing:0px 5px; font-size:8px;' cellpading='0' cellspacing='0'>".
                (($tipoAux != "FACTURA") ?
                 "<tr>
                    <td style ='width:45%; height:20px;'>
                      SUBTOTAL
                    </td>
                    <td style ='width:30%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                        <span style='margin-right:5px;'></span>
                    <td>
                  </tr>
                  <tr>
                      <td style ='width:45%; height:20px;'>
                          I.G.V.(%)
                       </td>
                       <td style ='width:30%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                        <span style='margin-right:5px;'></span>
                        <td>
                    </tr>" : "<tr>
                    <td style ='width:45%; height:20px;'>
                      SUBTOTAL
                    </td>
                    <td style ='width:30%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                        <span style='margin-right:5px;'>".number_format($sub_total, 2, '.', '')."</span>
                    <td>
                </tr>
                <tr>
                    <td style ='width:45%; height:20px;'>
                      I.G.V.(%)
                    </td>
                    <td style ='width:30%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                        <span style='margin-right:5px;'>".number_format($mont_total_op_gravada, 2, '.', '')."</span>
                    <td>
                </tr>")."
                <tr>
                    <td style ='width:45%;height:20px;'>
                      TOTAL
                    </td>
                    <td style ='width:30%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                        <span style='margin-right:5px;'>".number_format($im_total, 2, '.', '')."</span>
                    <td>
                </tr>
                <tr>
                    <td style ='width:45%;height:20px;'>

                    </td>
                    <td style ='width:55%; text-align:center'>
                      USUARIO
                    </td>
                </tr>

              </table>
              <i style='position:absolute;margin-left:-570px ;  font-size:9px;'>Documento Autorizado por Resolucion de Intendencia Regional - N° 062-005-0000246/SUNAT &nbsp; CODIGO: ".$firma." </i>
              ";
  }
  else
  {
    $base=$base."<div style='position:absolute; margin-left:36%;  width:34%; '>
           <table style='width:100%;font-size:8px;'>
           <tr>
                <td colspan='5' style='text-align:center;border:0.7px solid #000; '>
                SON: ".$ntt->numtoletras($im_total)."
                </td>
           </tr>
              <tr>
                <td colspan='5' style='text-align:center;'>
                    CANCELADO
                </td>
              </tr>
              <tr>
                <td  style='text-align:center; width:15%; border-bottom: 0.7px dotted #000;'>
                  ".$fecha_dia."
                </td>
                <td style=' width:5%;'>
                  de
                </td>
                <td style='text-align:center; width:60%; border-bottom: 0.7px dotted #000;'>
                ".$fecha_mes."
                </td>
                <td style=' width:5%;' >
                  de
                </td>
                <td style='text-align:center;  width:15%; border-bottom: 0.7px dotted #000;'>
                ".$fecha_anio."
                </td>
              </tr>
              <tr>
                <td colspan='5' style='height:15px; border-bottom:0.7px solid #000;' >
                </td>
              </tr>
              <tr>
                <td colspan='5' style='text-align:center;' >
                  p. SEDALIB S.A.
                </td>
              </tr>

           </table>
          </div>
          <div style='position:absolute; margin-left:82%;  width:18%;'>
               <table style='width:100%; border-spacing:0px 5px; font-size:8px;'>".
                (($tipoAux != "FACTURA") ? "<tr>
                    <td style ='width:45%; height:20px;'>
                      SUBTOTAL
                    </td>
                    <td style ='width:55%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'><td>
                    </tr>
                    <tr>
                        <td style ='width:45%; height:20px;'>
                          I.G.V.(%)
                        </td>
                        <td style ='width:55%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                        <span style='margin-right:5px;'></span>
                        </td>
                    </tr>" : "<tr>
                    <td style ='width:45%; height:20px;'>
                      SUBTOTAL
                    </td>
                    <td style ='width:55%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                     <span style='margin-right:5px;'>".number_format($sub_total, 2, '.', '')."</span>
                    </td>
                </tr>
                <tr>
                    <td style ='width:45%; height:20px;'>
                      I.G.V.(%)
                    </td>
                    <td style ='width:55%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                     <span style='margin-right:5px;'>".number_format($mont_total_op_gravada, 2, '.', '')."</span>
                    </td>
                </tr>")."
                <tr>
                    <td style ='width:45%;height:20px;'>
                      TOTAL
                    </td>
                    <td style ='width:55%;border:0.7px solid #000; border-radius:5px 5px 5px 5px; text-align:right;'>
                    <span style='margin-right:5px;'>".number_format($im_total, 2, '.', '')."</span>
                    </td>
                </tr>
                <tr>
                    <td style ='width:45%;height:20px;'>

                    </td>
                    <td style ='width:55%; text-align:center'>
                      USUARIO
                    </td>
                </tr>
              </table>
              <i style='position:absolute;margin-left:-570px ;  font-size:9px;'>Documento Autorizado por Resolucion de Intendencia Regional - N° 062-005-0000246/SUNAT &nbsp; CODIGO: ".$firma." </i>
              ";
  }

  $html="
<html lang='es'>
    <head>
    <title>Sedalib</title>
    <meta charset='utf-8'/>
    </head>
    <body style='font-family:sans-serif;'>";


          $pagina=$cabecera."
        <div style='width:100% ; height:270px; border-bottom:0.7px solid #000; '>
            <table style=' width:100%; font-size:8px; border-spacing: 0;'>
            <tr>
              <td style='text-align:center; border:0.7px solid #000; border-radius:10px 0 0 0 ;width:8%;'>
                CODIGO
              </td>
              <td style=' text-align:center;border-top:0.7px solid #000; border-right:0.7px solid #000; border-bottom:0.7px solid #000; width:78% ;'>
               ".utf8_encode("DESCRIPCIÓN")."
              </td>
              <td style='text-align:center; border-top:0.7px solid #000; border-right:0.7px solid #000; border-bottom:0.7px solid #000; border-radius:0 10px 0 0 ; width:14%;'>
              IMPORTE
              </td>
            </tr>
      ";

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
            $html=$html.$pagina.$cuerpo[$i]." </table> </div>".$base."&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10px;'> Pag. ".($i+1)."/".($conta_cuerpo+1)."</span></div></div>";
          }
          else
          {
              $html=$html."<div style='page-break-after:always;'></div>".$pagina.$cuerpo[$i]." </table> </div>".$base."&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10px'> Pag. ".($i+1)."/".($conta_cuerpo+1)."</span></div></div>";
          }
          $i=$i +1;
    }
$html=$html."</body> </html>";
//se eliminan todos los caracteres que no competen al dibujado de la nota de credito
$html2 = preg_replace('/\r\n+|\r+|\n+|\t+/i','', $html);
return $html2;


}



}
