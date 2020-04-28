<?php
class Cuentas_Corrientes_ctrllr extends CI_Controller {
  	public function __construct() { 
    	parent::__construct();
    	$this->load->model('cuenta_corriente/Cuentas_corrientes_model'); 
		$this->load->model('notas/Nota_Credito_model'); 
		$this->load->library('session'); 
		$this->load->library('acceso_cls'); 
		$this->data['actividad'] = 'cuentas_corrientes'; 
		$this->data['rol'] = $this->Cuentas_corrientes_model->get_rol($_SESSION['user_id']); 
    $this->acceso_cls->isLogin(); 
    $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
		$this->data['userdata'] = $this->acceso_cls->get_userdata(); 
		$permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']); 
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
	}
	  
  	public function cuentas_corrientes(){
    	$permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    	if($permiso){
			$rol = $this->Cuentas_corrientes_model->get_rol($_SESSION['user_id']); 
			$opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_CUENTA'); 
			$opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('BUSCAR_POR_RECIBO'); 
			$opcion2 = $this->Cuentas_corrientes_model->get_opcion_individual('BUSQUEDA_COMBINADA'); 
			$opcion3 = $this->Cuentas_corrientes_model->get_opcion_individual('VER_GIS'); 
			$this->data['ver_cuenta'] = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion,$this->data['id_actividad']); 
			$this->data['ver_gis'] = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion3,$this->data['id_actividad']); 
			$this->data['busqueda1'] = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion1,$this->data['id_actividad']); 
			$this->data['busqueda2'] = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion2,$this->data['id_actividad']); 
			if($this->input->server('REQUEST_METHOD') == 'POST'){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('suministro',"Suministro Cliente",'required');
				if($this->form_validation->run() == TRUE){
					$suministro = $this->input->post('suministro');
					$suministro = strtoupper($suministro);
					$tipo_busqueda = $this->input->post('tipo_busqueda');
					if(strlen($suministro) > 5) {
						$resultado = array();
						$result1 = $this->Cuentas_corrientes_model->get_one_client_1($suministro,$tipo_busqueda);
            			if(strlen($suministro) == 7){
							$resultado = array_merge($result1,$this->Cuentas_corrientes_model->agrupados(substr($suministro,0,3).'0000'.substr($suministro,3,4)));
						}
            			if($resultado) $this->data['one_cliente'] = $resultado;
            			else  $this->data['one_cliente'] = $result1;
            			foreach ($this->data['one_cliente'] as $key => $value) {
              				if(substr($value['CLICODFAC'], 3,4) == "0000"){
								$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente1(substr($value['CLICODFAC'],0,3),substr($value['CLICODFAC'], 7,4));
							} else {
								$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente($value['CLICODFAC']);
							}
							$this->data['one_cliente'][$key]['tipo'] = $tipo;
							unset($tipo);
            			}
            			$this->data['one_cliente'] = $this->data['one_cliente'];
            			if(!$this->data['one_cliente']){
							$this->session->set_flashdata('mensaje', array('danger', $this->config->item('_mensaje_vacio_post')));
							$this->data['consulta'] = 'multiple';
							$this->data['clientes'] = $this->Cuentas_corrientes_model->get_all_client();
							foreach ($this->data['clientes'] as $key => $value) {
								if(substr($value['CLICODFAC'],3,4) == "0000"){
									$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente1(substr($value['CLICODFAC'],0,3),substr($value['CLICODFAC'], 7,4));
								} else {
									$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente($value['CLICODFAC']);
								}
								$this->data['clientes'][$key]['tipo'] = $tipo;
								unset($tipo);
							}
              				$this->data['clientes'] = $this->data['clientes'];
            			} else {
              				$this->session->set_flashdata('mensaje', array('success', $this->config->item('_mensaje_get')));
              				$this->data['consulta'] = 'unica'; }
          			} else {
						$this->session->set_flashdata('mensaje', array('warning', $this->config->item('_mensaje_busqueda')));
						redirect($this->config->item('ip').'cuenta_corriente/cuenta');
						return;
          			}
        		} else {
					$this->data['consulta'] = 'multiple';
					$this->data['clientes'] = $this->Cuentas_corrientes_model->get_all_client();
          			foreach ($this->data['clientes'] as $key => $value) {
						if(substr($value['CLICODFAC'],3,4) == "0000"){
							$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente1(substr($value['CLICODFAC'],0,3),substr($value['CLICODFAC'], 7,4));
						} else {
							$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente($value['CLICODFAC']);
						}
						$this->data['clientes'][$key]['tipo'] = $tipo;
						unset($tipo);
					}
          			$this->data['clientes'] = $this->data['clientes'];
        		}
      		} else {
				$this->data['consulta'] = 'multiple';
				$this->data['clientes'] = $this->Cuentas_corrientes_model->get_all_client();
				foreach ($this->data['clientes'] as $key => $value) {
					if(substr($value['CLICODFAC'],3,4) == "0000"){
						$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente1(substr($value['CLICODFAC'],0,3),substr($value['CLICODFAC'], 7,4));
					} else {
						$tipo = $this->Cuentas_corrientes_model->get_tipo_cliente($value['CLICODFAC']);
					}
					$this->data['clientes'][$key]['tipo'] = $tipo;
					unset($tipo);
				}
       			 $this->data['clientes'] = $this->data['clientes'];
      		}
			$this->data['view'] = 'cuenta_corriente/Cuentas_corrientes_view';
			$this->data['breadcrumbs'] = array(array('CUENTAS CORRIENTES', ''));
			$this->load->view('template/Master', $this->data);
    	} else {
			$this->session->set_flashdata('mensaje', array('danger', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
    	}
	}
	  
  	public function buscar_cliente(){
    	$permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    	if($permiso){
      		$opcion = $this->Cuentas_corrientes_model->get_opcion_individual('BUSCAR_POR_RECIBO');  
      		$acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      		if($acceso){
        		if($this->input->get('ajax')){
          			$serie = $this->input->post('serie');
          			$numero = $this->input->post('numero');
          			$suministro = $this->Cuentas_corrientes_model->get_user_x_recibo($serie,$numero);
          			if($suministro){
            			if(strlen($suministro) == 7) $suministro = substr ($suministro, 0,3)."0000".substr ($suministro, 3,4);
                  $cliente = $this->Cuentas_corrientes_model->get_one_client_1($suministro,'suministro');
            			if(substr($cliente[0]['CLICODFAC'], 3,4)=="0000") $tipo = $this->Cuentas_corrientes_model->get_tipo_cliente1(substr($cliente[0]['CLICODFAC'],0,3),substr($cliente[0]['CLICODFAC'], 7,4));
            			else $tipo = $this->Cuentas_corrientes_model->get_tipo_cliente($suministro);
            			$rol = $this->Cuentas_corrientes_model->get_rol($_SESSION['user_id']); 
            			$opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_CUENTA'); 
            			$ver_cuenta = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion,$this->data['id_actividad']);
            			$opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('VER_GIS'); 
            			$ver_gis = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion1,$this->data['id_actividad']);
            			$_data = "";
            			foreach ($cliente as $clt) {
              				$_data .= '<tr>'.
										'<td>'.$clt['CLICODFAC'].'</td>'.
										'<td>'.$clt['CLINOMBRE'].'</td>'.
										'<td class="hidden-sm hidden-xs">'.(($clt['CLIELECT']) ? $clt['CLIELECT'] : $clt['CLIRUC']).'</td>'.
										'<td class="hidden-xs hidden-sm">'.$tipo.'</td>'.
										'<td>'.$clt['URBDES'].'</td>'.
										'<td>'.$clt['CALDES'].'</td>'.
										'<td class="hidden-xs" >'.$clt['CLIMUNNRO'].'</td>'.
										'<td class="hidden-sm hidden-xs">'.$clt['TARIFA'].'</td>'.
										'<td style="text-align:center">';
               				if($ver_cuenta){
                  				$_data .= 	'<a id="btn_cta_corriente" onclick="enviar_suministro(\''.$clt['CLICODFAC'].'\')" class="btn btn-success btn-xs">'.
                              					'<i class="fa fa-eye"></i> Cuenta corriente'.
                            				'</a>';
               				}
                			if($ver_gis){
                  				$_data .=  '<a id="btn_cta_gis" href="https://land.sedalib.com.pe/gis-sedalib/GisCorporativo/map_genexus.phtml?config=configs\grales\config_metropolitano&xlocal=03&xlocal2=03&resetsession=ALL&sumi='.((substr($clt['CLICODFAC'],3,4) == "0000") ? substr($clt['CLICODFAC'],0,3).substr($clt['CLICODFAC'],7,4) : $clt['CLICODFAC'] ).'" target="_blank" class="btn btn-info btn-xs">'.
                              					'<i class="fa fa-map-marker"></i> Ubicación GIS'.
                            				'</a>';
                			}
                			$_data .=  '</td>'.
                        			'</tr>';
            			}
						$json = array('result' => true, 'mensaje' => 'ok', 'cliente' => $_data);
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
    	} else {
			$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/x-json; charset=utf-8');
			echo json_encode($json);
    	}
	}
	  
  	public function busqueda_multiple(){
		$permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
		if($permiso){
			$opcion = $this->Cuentas_corrientes_model->get_opcion_individual('BUSQUEDA_COMBINADA');  
			$acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
			if($acceso){
				if($this->input->get('ajax')){
					$urbanizacion = $this->input->post('u');
					$direccion = $this->input->post('d');
					$numero = $this->input->post('n');
					$nombre = $this->input->post('ot');
					$cc = $this->Cuentas_corrientes_model->busqueda_cc_multiple($urbanizacion,$direccion,$numero,$nombre);  
					if($cc){
						foreach ($cc as $key => $c) {
							if(substr($c['CLICODFAC'], 3,4)=="0000") $tipo = $this->Cuentas_corrientes_model->get_tipo_cliente1(substr($c['CLICODFAC'],0,3),substr($c['CLICODFAC'], 7,4));
							else $tipo = $this->Cuentas_corrientes_model->get_tipo_cliente($c['CLICODFAC']);
							$cc[$key]['clase'] = $tipo;
						}
						$rol = $this->Cuentas_corrientes_model->get_rol($_SESSION['user_id']); 
						$opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_CUENTA'); 
						$ver_cuenta = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion,$this->data['id_actividad']);
						$opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('VER_GIS'); 
						$ver_gis = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion1,$this->data['id_actividad']);
						$data = "";
						foreach ($cc as $clt) {
							$data .= '<tr>'.
										'<td>'.$clt['CLICODFAC'].'</td>'.
										'<td>'.$clt['CLINOMBRE'].'</td>'.
										'<td class="hidden-sm hidden-xs">'.(($clt['CLIELECT']) ? $clt['CLIELECT'] : $clt['CLIRUC']).'</td>'.
										'<td class="hidden-xs hidden-sm">'.$clt['clase'].'</td>'.
										'<td>'.$clt['URBDES'].'</td>'.
										'<td>'.$clt['CALDES'].'</td>'.
										'<td class="hidden-xs" >'.$clt['CLIMUNNRO'].'</td>'.
										'<td class="hidden-sm hidden-xs">'.$clt['TARIFA'].'</td>'.
										'<td style="text-align:center">';
							if($ver_cuenta){
								$data .= '<a id="btn_cta_corriente" onclick="enviar_suministro(\''.$clt['CLICODFAC'].'\')" class="btn btn-success btn-xs" >'.
												'<i class="fa fa-eye"></i> Cuenta corriente'.
												'</a>';
							}
							if($ver_gis){
								$data .= '<a id="btn_cta_gis" href="https://land.sedalib.com.pe/gis-sedalib/GisCorporativo/map_genexus.phtml?config=configs\grales\config_metropolitano&xlocal=03&xlocal2=03&resetsession=ALL&sumi='.((substr($clt['CLICODFAC'],3,4) == "0000") ? substr($clt['CLICODFAC'],0,3).substr($clt['CLICODFAC'],7,4) : $clt['CLICODFAC'] ).'" target="_blank" class="btn btn-info btn-xs">'.
												'<i class="fa fa-map-marker"></i> Ubicación GIS'.
											'</a>';
							}
							$data .=  '</td>'.
                        				'</tr>';
            			}
						$json = array('result' => true, 'mensaje' => 'ok', 'cliente' => $data);
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
		} else {
			$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/x-json; charset=utf-8');
			echo json_encode($json);
		}
	}
	
	public function ver_cuenta(){
		$permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
		if($permiso){
		  	$opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_CUENTA');  
		  	$acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
		  	if($acceso){
				$ajax = $this->input->get('ajax');
				$valor = $this->input->post('suministro');
				if ($ajax) { 
					$cc = $this->Cuentas_corrientes_model->get_one_client($valor);
					if($cc){
						$json = array('result' => true, 'mensaje' => 'OK','suministro'=>$valor);
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
		} else {
			$json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/x-json; charset=utf-8');
			echo json_encode($json);
		}
	}

  	public function mostrar_cuenta($valor){ 
    	$permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    	if($permiso){
			$opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_CUENTA');  
			$acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      		if($acceso){
				$_cuenta_corriente = $this->Cuentas_corrientes_model->get_one_client($valor);
				$rol = $this->Cuentas_corrientes_model->get_rol($_SESSION['user_id']); 
				$this->data['opciones'] = $this->Cuentas_corrientes_model->get_all_botones($rol,$this->data['id_actividad'] ); 
				if(!$_cuenta_corriente){ 
					$_cuenta_corriente = $this->Cuentas_corrientes_model->get_one_client(substr($valor,0,3).substr($valor,7,4));
					$_suministro = substr($valor,0,3).substr($valor,7,4);
				}
        		if($_cuenta_corriente) {
					$interes_moratorio = 0;
					$interes_moratorio1 = 0;
					$datos_usuario = $this->Cuentas_corrientes_model->get_datos_usuarios($valor);
					$_suministro = $valor;
					if(!$datos_usuario) {
						$datos_usuario = $this->Cuentas_corrientes_model->get_datos_usuarios1(substr($valor,0,3),substr($valor,7,4));
					}
          if(substr($valor, 3,4) == "0000") $_suministro = substr($valor,0,3).substr($valor,7,4);
          $coagua = $this->Cuentas_corrientes_model->obtener_medcodigo($datos_usuario);
					$this->data['medidor'] = $this->Cuentas_corrientes_model->obetner_medidor($coagua);
					$this->data['datos_usuario'] = $datos_usuario;
					$dataUser = $this->Cuentas_corrientes_model->get_all_data($datos_usuario);
					$this->data['dataUser'] = $dataUser;
					$this->data['desCiclo'] = $this->Cuentas_corrientes_model->get_ciclo($dataUser);
					$this->data['user_datos'] = $this->Cuentas_corrientes_model->get_one_client($valor);
					if(!$this->data['user_datos']) $this->data['user_datos'] = $this->Cuentas_corrientes_model->get_one_client(substr($valor,0,3).substr($valor,7,4));
					$this->data['key'] = $this->encriptar($_suministro);
					$this->data['cuenta_corriente'] = $this->Cuentas_corrientes_model->cuenta_corriente($valor);
					if(!$this->data['cuenta_corriente']) $this->data['cuenta_corriente'] = $this->Cuentas_corrientes_model->cuenta_corriente(substr($valor,0,3).substr($valor,7,4));
					$this->data['est_cli'] = $this->Cuentas_corrientes_model->estado_cliente( $this->data['cuenta_corriente']['CODESTCTE']);
					$this->data['ciclo'] = $this->Cuentas_corrientes_model->get_ciclo($this->data['cuenta_corriente']['CICLOFAC']);
					$recibos_pendientes = $this->Cuentas_corrientes_model->recibos_pendientes($valor);
					if(!$recibos_pendientes) $recibos_pendientes = $this->Cuentas_corrientes_model->recibos_pendientes(substr($valor,0,3).substr($valor,7,4));
					$j = 0; 
          			foreach ($recibos_pendientes as $key => $recibo) {
						$volumen = $this->Cuentas_corrientes_model->volumen_leido($recibo['FACSERNRO'],$recibo['FACNRO']);
						$reclamo = $this->Cuentas_corrientes_model->reclamos($recibo['FACSERNRO'],$recibo['FACNRO']);
						$notas_credito = $this->Cuentas_corrientes_model->notas_credito1($recibo['FACSERNRO'],$recibo['FACNRO']);
						$notas_debito = $this->Cuentas_corrientes_model->notas_debito1($recibo['FACSERNRO'],$recibo['FACNRO']);
						$valor5 = $this->Cuentas_corrientes_model->get_autoizacion($recibo['FACSERNRO'],$recibo['FACNRO']);
						$monto_nc = $this->Cuentas_corrientes_model->monto_nc($recibo['FACSERNRO'],$recibo['FACNRO']); 
						$proceso_facturacion = $this->Cuentas_corrientes_model->obetner_periodo1($_suministro,$recibo['FACSERNRO'],$recibo['FACNRO']);
						if(!$proceso_facturacion) $proceso_facturacion = $this->Cuentas_corrientes_model->obetner_periodo1(substr($valor,0,3).substr($valor,7,4),$recibo['FACSERNRO'],$recibo['FACNRO']);
						if($this->validar_fecha(date('Y-m-d'),substr($recibo['FACVENFEC'],6,4).'-'.substr($recibo['FACVENFEC'],3,2)."-".substr($recibo['FACVENFEC'],0,2)) < 0 && $recibo['FACTOTAL'] != $monto_nc){
							$fechaaxu = $this->sumar_fecha(substr($recibo['FACVENFEC'],6,4).'-'.substr($recibo['FACVENFEC'],3,2).'-'.substr($recibo['FACVENFEC'],0,2));
							$tamdia = $this->Cuentas_corrientes_model->tasa(substr($fechaaxu,8,2)."/".substr($fechaaxu,5,2)."/".substr($fechaaxu,0,4));
							$interes_moratorio += floatval($recibo['FACTOTAL'])*floatval($tamdia['TAMACU']);
            			} 
						if($recibo['FACTOTAL'] == $monto_nc){
							$j++;
						}
						$recibos_pendientes[$key]['volumen'] = $volumen;
						$recibos_pendientes[$key]['reclamo'] = $reclamo;
						$recibos_pendientes[$key]['NC'] = $notas_credito;
						$recibos_pendientes[$key]['ND'] = $notas_debito;
						$recibos_pendientes[$key]['autorizacion'] = $valor5;
						$recibos_pendientes[$key]['proceso'] = $proceso_facturacion;
						$recibos_pendientes[$key]['monto_nota'] = $monto_nc;
          			}
					if($j > 0) $this->data['recibos_anulados'] = $j;
					$this->data['recibos_pendientes'] = $recibos_pendientes;
					$recibos_pendientes_90_91 = $this->Cuentas_corrientes_model->recibos_pendientes_90_91($valor);
					if($recibos_pendientes_90_91 == NULL) $recibos_pendientes_90_91 = $this->Cuentas_corrientes_model->recibos_pendientes_90_91(substr($valor,0,3).substr($valor,7,4));
					$this->data['recibos_pendientes_90_91'] = $recibos_pendientes_90_91;
					$this->data['monto_convenios'] = $this->Cuentas_corrientes_model->get_monto_convenios($valor);
					if(!$this->data['monto_convenios']['TOTAL']) $this->data['monto_convenios'] = $this->Cuentas_corrientes_model->get_monto_convenios(substr($valor,0,3).substr($valor,7,4));
					$this->data['interes_moratorio'] = number_format($interes_moratorio,2,'.','');
					$this->data['interes_moratorio1'] = number_format($interes_moratorio1,2,'.','');
					$this->data['view'] = 'cuenta_corriente/Cuenta_user_view';
					$this->data['sum_real'] = $_suministro;
					$this->data['breadcrumbs'] = array(array('CUENTAS CORRIENTES', 'cuenta_corriente/cuenta'),array('USUARIO '.$valor,''));
					$this->load->view('template/Master', $this->data);
        		} else {
					$this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
					redirect($this->config->item('ip').'cuenta_corriente/cuenta');
					return;
        		}
      		} else {
				$this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
				redirect($this->config->item('ip').'cuenta_corriente/cuenta');
				return;
      		}
    	} else {
			$this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
    	}
	}
	  
  public function obtener_90_91(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_RECIBOS_SERIE_90-91');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          if(substr($this->input->post('suministro'), 3,7) == "0000") $suministro = substr($this->input->post('suministro'), 0,3).substr($this->input->post('suministro'), 7,4);
          else $suministro = $this->input->post('suministro');
          $recibos = $this->Cuentas_corrientes_model->recibos_pendientes_90_91($suministro);
          if($recibos){
            $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_RECIBO');  
            $opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('DUPLICADO_DE_RECIBO');  
            $detalle_recibo = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
            $duplicado = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion1,$this->data['id_actividad']); 
            $contenido = "";
            foreach ($recibos as $r) {
              $volumen = $this->Cuentas_corrientes_model->volumen_leido($r['FACSERNRO'],$r['FACNRO']);
              $reclamo = $this->Cuentas_corrientes_model->reclamos($r['FACSERNRO'],$r['FACNRO']);
              $notas_credito = $this->Cuentas_corrientes_model->notas_credito1($r['FACSERNRO'],$r['FACNRO']);
              $notas_debito = $this->Cuentas_corrientes_model->notas_debito1($r['FACSERNRO'],$r['FACNRO']);
              $periodo = $this->Cuentas_corrientes_model->obetner_periodo1($suministro,$r['FACSERNRO'],$r['FACNRO']);
              $contenido .= '<tr>'.
                              '<td>'.$r['FACEMIFEC'].'</td>'.
                              '<td class="derecha">'.$r['FACSERNRO'].'</td>'.
                              '<td class="derecha">'.$r['FACNRO'].'</td>'.
                              '<td>'.(($volumen != NULL) ? "RECIBO ".$volumen." m<sup>3</sup>" : "RECIBO ").(($notas_credito != NULL) ?  " NC = ".sizeof($notas_credito) : "")." ".$r['FACTARIFA']." FV: ".$r['FACVENFEC'].'</td>'.
                              '<td>'.$r['FACTARIFA'].'</td>'.
                              '<td class="derecha text-blue">'.(($reclamo != NULL) ? $reclamo['SERNRO']."-".$reclamo['RECID'] : "0").'</td>'.
                              '<td class="derecha text-blue">'.(($reclamo != NULL) ? $reclamo['SSITDES'] : "" ).'</td>'.
                              '<td class="derecha text-red">'.number_format(floatval($r['FACTOTAL']), 2, '.', '').'</td>'.
                              '<td class="derecha text-blue">0.00</td>'.
                              '<td class="derecha ">'.number_format(floatval($r['FACTOTAL']), 2, '.', '').'</td>'.
                              '<td class="center">'.
                                ' <div class="dropdown drop">'.
                                    '<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.
                                        '<i class="fa fa-filter" aria-hidden="true"></i> Opciones<span class="caret"></span>'.
                                    '</button>'.
                                    '<ul class="dropdown-menu dropdown-menu-right bg_color">';
              if($detalle_recibo){
                $contenido .=   '<li>'.
                                    '<a onclick="ver_detalle(\''.$r['FACSERNRO'].'\',\''.$r['FACNRO'].'\')" id="detalle" class="hover_yellow">'.
                                        '<i class="fa fa-plus-square"></i> DETALLE RECIBO'.
                                    '</a>'.
                                '</li>';
              }
              if($duplicado && $periodo){
                $contenido .=   '<li class="divider"></li>'.
                                '<li>'.
                                    '<a onclick="window.open(\''.$this->config->item('ip').'facturacion/creo_recibo_a4/'.$suministro.'/'.$periodo.'\')" class="hover_yellow">'.
                                        '<i class="fa fa-file-text" aria-hidden="true"></i> DUPLICADO DE RECIBO'.
                                    '</a>'.
                                '</li>';
              }
              $contenido .= '</ul></div></td></tr>';
            }
            $json = array('result' => true, 'mensaje' => 'ok', 'recibos' => $contenido);
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  private function validar_fecha($start, $end){
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
  }
  private function sumar_fecha($fechaFFase){
    $nuevafecha = date('Y-m-d', strtotime($fechaFFase) + 86400);
    $nuevafecha = date('Y-m-d', strtotime("$fechaFFase + 1 day"));
    return $nuevafecha;
  }
  
  public function get_unidades(){ 
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_UNIDADES');
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        if($this->input->get('ajax')){
          $grupo = $this->input->post('grupo');
          $subgrupo = $this->input->post('subgrupo');
          $predio = $this->Cuentas_corrientes_model->get_predio($grupo,$subgrupo);
          $unidades = $this->Cuentas_corrientes_model->get_unidades_grupo($predio);
          foreach ($unidades as $key => $unidad) {
            $propie = $this->Cuentas_corrientes_model->get_tarifa($unidad['CLICODFAC']);
            $predio = $this->Cuentas_corrientes_model->get_all_data($unidad);
            $cuenta_corriente = $this->Cuentas_corrientes_model->cuenta_corriente($unidad['CLICODFAC']);
            $nombre = $this->Cuentas_corrientes_model->get_user_name($unidad['CLICODFAC']);
            $estado = $this->Cuentas_corrientes_model->estado_cliente( $cuenta_corriente['CODESTCTE']);
            $catastro = $this->Cuentas_corrientes_model->get_estado_cliente($unidad['CLICODFAC']);
            $localidad = $this->Cuentas_corrientes_model->get_localidad($propie['PREREGION'],$propie['PRELOCALI']);
            $unidades[$key]['propie'] = $propie;
            $unidades[$key]['predio'] = $predio;
            $unidades[$key]['estado'] = $estado['DESESCLTE'];
            $unidades[$key]['catastro'] = $catastro;
            $unidades[$key]['medidor'] = $cuenta_corriente['MEDIDOR'];
            $unidades[$key]['localidad'] = $localidad;
            $unidades[$key]['nombre'] = $nombre;
            unset($propie);
            unset($predio);
            unset($cuenta_corriente);
            unset($nombre);
            unset($estado);
            unset($localidad);
          }
          if($unidades) {
            $cuerpo = ""; $i = 1;
            foreach ($unidades as $un) {
              $cuerpo .= '<tr>'.
                          '<td>'.$un['CLICODFAC'].'</td>'.
                          '<td>'.$un['nombre']['CLINOMBRE'].'</td>'.
                          '<td>'.$un['predio'].'</td>'.
                          '<td>'.$un['propie']['TARIFA'].'</td>'.
                          '<td>'.$un['estado'].'</td>'.
                          '<td>'.$un['catastro']['DESTIPSER'].'</td>'.
                          '<td>'.$un['catastro']['CONESTDES'].'</td>'.
                          '<td>'.$un['catastro']['CONDESDES'].'</td>'.
                          '<td>'.$un['medidor'].'</td>'.
                          '<td>'.((strlen($un['CLIGRUCOD']) == 2) ? "0".$un['CLIGRUCOD'] : $un['CLIGRUCOD'])." ".((strlen($un['CLIGRUSUB']) == 3 ) ? "0".$un['CLIGRUSUB']  : $un['CLIGRUSUB']).'</td>'.
                          '<td>'.$un['localidad'].'</td>'.
                          '<td style="text-align:center;vertical-align: middle">'.
                            '<a id="btn_cta_corriente" onclick="enviar_suministro(\''.$un['CLICODFAC'].'\')" class="btn btn-success btn-xs">'.
                              '<i class="fa fa-eye"></i> VER CUENTA'.
                            '</a>'.
                          '</td>'.
                         '</tr>';
              $i++;
            }
            $json = array('result' => true, 'mensaje' => 'OK','unidades'=>$cuerpo);
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function recibos_anulados_totalmente(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_RECIBOS_SERIE_90-91');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          if(substr($this->input->post('suministro'), 3,7) == "0000") $suministro = substr($this->input->post('suministro'), 0,3).substr($this->input->post('suministro'), 7,4);
          else $suministro = $this->input->post('suministro');
          $recibos = $this->Cuentas_corrientes_model->recibos_pendientes($suministro);
          $contenido = "";
          $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_RECIBO');  
          $opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('DUPLICADO_DE_RECIBO');  
          $opcion2 = $this->Cuentas_corrientes_model->get_opcion_individual('DETALLE_NCA');  
          $opcion3 = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_NCA');  
          $opcion4 = $this->Cuentas_corrientes_model->get_opcion_individual('EDITAR_NCA');  
          $detalle_recibo = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
          $duplicado = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion1,$this->data['id_actividad']); 
          $detalle_nc = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion2,$this->data['id_actividad']); 
          $imprimir_nc = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion3,$this->data['id_actividad']); 
          $editar_nc = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion3,$this->data['id_actividad']); 
          $key = $this->encriptar($suministro);
          foreach ($recibos as $r) {
            $monto_nc = $this->Cuentas_corrientes_model->monto_nc($r['FACSERNRO'],$r['FACNRO']);
            if($monto_nc == $r['FACTOTAL']){
              $volumen = $this->Cuentas_corrientes_model->volumen_leido($r['FACSERNRO'],$r['FACNRO']);
              $reclamo = $this->Cuentas_corrientes_model->reclamos($r['FACSERNRO'],$r['FACNRO']);
              $notas_credito = $this->Cuentas_corrientes_model->notas_credito1($r['FACSERNRO'],$r['FACNRO']);
              $periodo = $this->Cuentas_corrientes_model->obetner_periodo1($suministro,$r['FACSERNRO'],$r['FACNRO']);
              $contenido .= "<tr>".
                              '<td>'.$r['FACEMIFEC'].'</td>'.
                              '<td class="derecha">'.$r['FACSERNRO'].'</td>'.
                              '<td class="derecha">'.$r['FACNRO'].'</td>'.
                              '<td>'.(($volumen != NULL) ? "RECIBO ".$volumen." m<sup>3</sup>" : "RECIBO ").(($notas_credito != NULL) ?  " NC = ".sizeof($notas_credito) : "")." ".$r['FACTARIFA']." FV: ".$r['FACVENFEC'].'</td>'.
                              '<td>'.$r['FACTARIFA'].'</td>'.
                              '<td class="derecha text-blue">'.(($reclamo != NULL) ? $reclamo['SERNRO']."-".$reclamo['RECID'] : "0").'</td>'.
                              '<td class="derecha text-blue">'.(($reclamo != NULL) ? $reclamo['SSITDES'] : "" ).'</td>'.
                              '<td class="derecha text-red">'.number_format(floatval($r['FACTOTAL']), 2, '.', '').'</td>'.
                              '<td class="derecha text-blue">0.00</td>'.
                              '<td class="derecha ">'.number_format(floatval($r['FACTOTAL']), 2, '.', '').'</td>'.
                              '<td class="center">';
              if($detalle_recibo){
                $contenido .= '<a onclick="ver_detalle(\''.$r['FACSERNRO'].'\',\''.$r['FACNRO'].'\')" id="detalle" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="DETALLE RECIBO">'.
                                  '<i class="fa fa-plus-square"></i>'.
                                '</a>';
              }
              if($duplicado && $periodo){
                $contenido .= ' <a onclick="window.open(\''.$this->config->item('ip').'facturacion/creo_recibo/'.$suministro.'/'.$periodo.'\')" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="DUPLICADO RECIBO">'.
                              '<i class="fa fa-file-text" aria-hidden="true"></i>'.
                            '</a>';
              }
              $contenido .= "</td></tr>";
              foreach ($notas_credito as $nc) {
                $contenido .= "<tr>".
                                "<td class='text-red'>".$nc['NCAFECHA']."</td>".
                                "<td class='derecha text-red'>".$nc['NCASERNRO']."</td>".
                                "<td class='derecha text-red'>".$nc['NCANRO']."</td>".
                                "<td class='text-red'>NOTA DE CRÉDITO. Recibo: ".$nc['TOTFAC_FACSERNRO']." - ".$nc['TOTFAC_FACNRO']."</td>".
                                "<td></td>".
                                "<td class='text-blue derecha'>0</td>".
                                "<td></td>".
                                "<td class='derecha text-red'>0.00</td>".
                                "<td class='derecha text-blue'>".number_format(floatval($nc["NCATOTDIF"]),2,'.','')."</td>".
                                "<td class='derecha'>0.00</td>".
                                "<td class='center'>";
                if($detalle_nc){
                  $contenido .= '<a onclick="detalle_nota(\''.$suministro.'\',\''.$nc['NCASERNRO'].'\',\''.$nc['NCANRO'].'\')" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="DETALLE NOTA CRÉDITO">'.
                                  '<i class="fa fa-eye" aria-hidden="true"></i>'.
                                '</a>';
                }
                if($imprimir_nc){
                  $contenido .= '<a href="#" id="ver_nc" onclick="ver_notaCredito(\''.$key.'\',\''.$nc['NCASERNRO'].'\',\''.$nc['NCANRO'].'\')" class="btn btn-default" data-toggle=bottom" title="IMPRIMIR NOTA CRÉDITO">'.
                                  '<i class="fa fa-print"></i>'.
                                '</a>';
                }
                if($editar_nc){
                  if(substr($nc['NCAFECHA'],3,2) == date("m")){
                    $contenido .= '<a onclick="generar_nota(\''.$suministro.'\',\''.$r['FACSERNRO'].'\',\''.$r['FACNRO'].'\')" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="EDITAR NOTA CRÉDITO">'.
                                    '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'.
                                  '</a>';
                  }
                }
                $contenido .= "</td></tr>";
              }
            }
          }
          if($contenido){
            $json = array('result' => true, 'mensaje' => 'ok', 'recibos' => $contenido);
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function verificar_pagos(){ 
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_PAGOS');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          $_suministro = $this->input->post('suministro');
          $suministro = $this->desencriptar($_suministro);
          $pagos= $this->Cuentas_corrientes_model->get_pagos($suministro);
          if($pagos){
            $json = array('result' => true, 'mensaje' => 'OK');
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function ver_pagos($_suministro){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_PAGOS');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $this->data['key'] = $_suministro;
        $suministro = $this->desencriptar($_suministro);
        $pagos= $this->Cuentas_corrientes_model->get_pagos($suministro);
        if($pagos){
          $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_RECIBO'); 
          $opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_NCA'); 
          $opcion2 = $this->Cuentas_corrientes_model->get_opcion_individual('DUPLICADO_DE_RECIBO'); 
          $opcion3 = $this->Cuentas_corrientes_model->get_opcion_individual('DETALLE_NCA'); 
          $opcion4 = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_PAGOS'); 
          $opcion5 = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_PAGOS_RANGOS'); 
          $this->data['detalle_recibo'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
          $this->data['imprimir_nca'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion1,$this->data['id_actividad']); 
          $this->data['duplicado_recibo'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion2,$this->data['id_actividad']); 
          $this->data['detalle_nca'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion3,$this->data['id_actividad']); 
          $this->data['imprimir_pagos'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion4,$this->data['id_actividad']); 
          $this->data['imprimir_pagos_rangos'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion5,$this->data['id_actividad']); 
          $this->data['suministro'] = $suministro;
          $pagos= $this->Cuentas_corrientes_model->get_pagos($suministro);
          foreach($pagos as $key => $pago){
            $notas = $this->Cuentas_corrientes_model->get_nota_credito_pago($pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
            $monto_credito = $this->Cuentas_corrientes_model->get_nota_credito_importe($pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
            $monto_debito = $this->Cuentas_corrientes_model->get_nota_debito_importe($pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
            $proceso_facturacion = $this->Cuentas_corrientes_model->obetner_periodo1($suministro,$pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
            $contenido =  '<div class="dropdown drop">'.
                            '<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.
                              '<i class="fa fa-filter" aria-hidden="true"></i> Opciones'.
                              '<span class="caret"></span>'.
                            '</button>'.
                            '<ul class="dropdown-menu dropdown-menu-right bg_color">';
            if (isset($this->data['detalle_recibo'])) $contenido .= '<li>'.
                                                        '<a class="hover_yellow" onclick="ver_detalle(\''.$pago['TOTFAC_FACSERNRO'].'\',\''.$pago['TOTFAC_FACNRO'].'\')">'.
                                                          '<i class="fa fa-plus-square" aria-hidden="true"></i> DETALLE RECIBO'.
                                                        '</a>'.
                                                      '</li>';
            if (isset($this->data['duplicado_recibo']) && $proceso_facturacion) 
              $contenido .= '<li role="separator" class="divider"></li>'.
                              '<li>'.
                                '<a class="hover_yellow" onclick="window.open(\''.$this->config->item('ip').'facturacion/creo_recibo_a4/'.$suministro.'/'.$proceso_facturacion.'\')">'.
                                  '<i class="fa fa-file-text" aria-hidden="true"></i> DUPLICADO RECIBO'.
                                '</a>'.
                              '</li>';
            if ($notas && $this->data['imprimir_nca']){
              $i = 1;
              foreach ($notas as $n) {
                $contenido .= '<li role="separator" class="divider"></li>'.
                              '<li>'.
                                '<a class="hover_yellow" onclick="imprimir_nota(\''.$n['NCASERNRO'].'\',\''.$n['NCANRO'].'\')">'.
                                  '<i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR NCA: '.$n['NCASERNRO'].'-'.$n['NCANRO'].
                                '</a>'.
                              '</li>';
              }
            }
            if ($notas && $this->data['detalle_nca']){
              $i = 1;
              foreach ($notas as $n) {
                $contenido .= '<li role="separator" class="divider"></li>'.
                              '<li>'.
                                '<a class="hover_yellow" onclick="detalle_nota(\''.$suministro.'\',\''.$n['NCASERNRO'].'\',\''.$n['NCANRO'].'\')">'.
                                  '<i class="fa fa-eye" aria-hidden="true"></i> DETALLE NCA: '.$n['NCASERNRO'].'-'.$n['NCANRO'].
                                '</a>'.
                              '</li>';
              }
            }
            $contenido .= '</ul>'.
                          '</div>';
            $pagos[$key]['opciones'] = $contenido;
            $pagos[$key]['notas'] = $notas; 
            $pagos[$key]['monto_credito'] = $monto_credito; 
            $pagos[$key]['monto_debito'] = $monto_debito;
            $pagos[$key]['periodo'] = $proceso_facturacion;
            unset($contenido);
            unset($notas);
            unset($monto_credito);
            unset($monto_debito);
            unset($proceso_facturacion);
          }
          $this->data['user'] = $this->Cuentas_corrientes_model->get_user_name($suministro);
          if($this->data['user'] == null){
            $suministro1 = substr($suministro,0,3)."0000".substr($suministro,3,4);
            $this->data['user'] = $this->Cuentas_corrientes_model->get_user_name($suministro1);
          }
          $this->data['pagos'] = $pagos;
          $this->data['title'] = 'PAGOS - '.$suministro;
          $this->data['view'] = 'cuenta_corriente/Pagos_view';
          $this->load->view('cuenta_corriente/Template', $this->data);
        } else {
          $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
          redirect($this->config->item('ip').'cuenta_corriente/cuenta');
          return;
        } 
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
        redirect($this->config->item('ip').'404');
        return;
      }  
    } else {
      $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
      redirect($this->config->item('ip').'404');
      return;
    } 
  }
  private function encriptar($cadena){ 
      $str = "";
      $l = strlen($cadena);
      for ($i=0; $i < $l ; $i++) { 
        switch ($cadena[$i]) {
          case '0':
            $str .= "A4";
            break;
          case '1' :
            $str .= '5B';
            break;
          case '2':
            $str .= 'R3';
            break;
          case '3':
            $str .= 'T7';
            break;
          case '4':
            $str .= 'P8';
            break;
          case '5':
            $str .= 'W2';
            break;
          case '6':
            $str .= 'Y9';
            break;
          case '7':
            $str .= 'A6';
            break;
          case '8':
            $str .= 'Q1';
            break;
          case '9':
            $str .= 'I0';
            break;
        }
      }
      return $str; 
    }
  private function desencriptar($cadena){ 
    $str = "";
    $tam = strlen($cadena);
    for ($i=0; $i < $tam-1 ; $i++) { 
      switch ($cadena[$i].$cadena[$i+1]) {
        case 'A4':
          $str .= "0"; $i++;
          break;
        case '5B' :
          $str .= '1'; $i++;
          break;
        case 'R3':
          $str .= '2'; $i++;
          break;
        case 'T7':
          $str .= '3'; $i++;
          break;
        case 'P8':
          $str .= '4'; $i++;
          break;
        case 'W2':
          $str .= '5'; $i++;
          break;
        case 'Y9':
          $str .= '6'; $i++;
          break;
        case 'A6':
          $str .= '7'; $i++;
          break;
        case 'Q1':
          $str .= '8'; $i++;
          break;
        case 'I0':
          $str .= '9'; $i++;
          break;
      }
    }
    return $str; 
  }
  public function imprimir_pagos($_suministro){ 
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_PAGOS');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        clearstatcache();
        $suministro = $this->desencriptar($_suministro);
        if(strlen($suministro) == 7) $user = $this->Cuentas_corrientes_model->get_user_name(substr($suministro, 0,3)."0000".substr($suministro, 3,4));
        else $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
        $pagos = $this->Cuentas_corrientes_model->get_pagos($suministro);
        $uministro_real = $suministro;
        if(!$pagos){
          $suministro1 = substr($suministro,0,3).substr($suministro,7,4);
          $pagos = $this->Cuentas_corrientes_model->get_pagos($suministro1);
          $uministro_real = $suministro1;
        }
        foreach ($pagos as $key => $pago) {
          $monto_credito = $this->Cuentas_corrientes_model->get_nota_credito_importe($pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
          $monto_debito =  $this->Cuentas_corrientes_model->get_nota_debito_importe($pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
          $pagos[$key]['monto_credito'] = $monto_credito;
          $pagos[$key]['monto_debito'] = $monto_debito;
          unset($monto_credito);
          unset($monto_debito);
        }
        if(sizeof($pagos)>0){
          $this->load->library('ciqrcode');
          $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
          $params['level'] = 'H';
          $params['size'] = 1;
          $params['savename'] = FCPATH.'tes.png';
          $this->ciqrcode->generate($params);
          $this->load->library('pdf');
          $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);
          $mpdf->SetTitle('PAGOS '.$suministro);
          $i= 0;
          $var = sizeof($pagos);
          $var1 = intval($var / 50);
          $var2 = $var%50;
          $mf = 0;
          $mp = 0;
          $mnc = 0;
          $mnd = 0;
          if($var2 > 0) $var1++;
          $mpdf->SetHTMLHeader('<table width="100%" style="font-size:11px;font-family: Arial">'.
                                  '<tr>'.
                                    '<td style="text-align:left;width:25%"><img src="'.$this->config->item('ip').'/img/logo3.png" style="width:20%" /></td>'.
                                    '<td style="width:55%;text-align:center"><h3 style="font-size:18px;font-family: Arial">RELACIÓN DE PAGOS</h3></td>'.
                                    '<td style="text-align:right"><b>FECHA: </b>'.date('d/m/y').'<br><b>HORA: </b>'.date('H:i:s').'<br><b>Página: </b>{PAGENO}</td>'.
                                    '<td style="width:7%"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                                  '</tr>'.
                                '</table>');
          for($i;$i<$var;$i++){
            if($i % 26 == 0){
              if($i % 26 == 0 && $i != 0){
                $html .= "</table>";
                $mpdf->WriteHTML($html);
              }
              $mpdf->AddPage('L');
              $mpdf->SetHTMLHeader('<table width="100%" style="font-size:11px;font-family: Arial">'.
                                  '<tr>'.
                                    '<td style="text-align:left;width:25%"><img src="'.$this->config->item('ip').'/img/logo3.png" style="width:20%" /></td>'.
                                    '<td style="width:55%;text-align:center"><h3 style="font-size:18px;font-family: Arial">RELACIÓN DE PAGOS</h3></td>'.
                                    '<td style="text-align:right"><b>FECHA: </b>'.date('d/m/y').'<br><b>HORA: </b>'.date('H:i:s').'<br><b>Página: </b>{PAGENO}</td>'.
                                    '<td style="width:7%"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                                  '</tr>'.
                                '</table>');
              $html = '<br><br>'.
                    '<table width="100%">'.
                      '<tr>'.
                        '<td style="font-size:12px;width:10%;font-family: Arial"><b style="font-size:12px;font-family: Arial">SUMINISTRO: </b> '.$suministro.'</td>'.
                        '<td style="font-size:12px;width:20%;font-family: Arial"><b style="font-size:12px;font-family: Arial">NOMBRE: </b> '.$user['CLINOMBRE'].'</td>'.
                        '<td style="font-size:12px;width:20%;font-family: Arial"><b style="font-size:12px;font-family: Arial">DIRECCIÓN: </b> '.$user['URBDES'].' '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
                        '<td style="font-size:12px;width:15%;font-family: Arial;text-align:right"><b style="font-size:12px;font-family: Arial">TARIFA: </b> '.$user['TARIFA'].'</td>'.
                      '</tr>'.
                    '</table>'.
                    '<br>'.
                    '<table width="100%" style="font-size:11px" cellpadding="0" cellspacing="0">'.
                      '<tr>'.
                        '<td style="border: 1px solid #000;font-size:12px;text-align:center;width:5%;padding-top:8px;padding-bottom:8px"><b style="font-family:Arial">SERIE</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:9%"><b style="font-family:Arial">NUMERO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:10%"><b style="font-family:Arial">FECHA PAGO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:10%"><b style="font-family:Arial">FECHA EMISIÓN</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:13%"><b style="font-family:Arial">FECHA VENCIMIENTO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">FACTURADO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">N CRÉDITO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">N DÉBITO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">PAGADO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center"><b style="font-family:Arial">PUNTO COBRANZA</b></td>'.
                      '</tr>';
            }
            $html .=  "<tr>".
                        "<td style='text-align:center;padding:3px;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['TOTFAC_FACSERNRO']."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:15px;font-family:Arial'>".$pagos[$i]['TOTFAC_FACNRO']."</td>".
                        "<td style='text-align:center;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['HISCOBFEC']."</td>".
                        "<td style='text-align:center;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['HISEMIFEC']."</td>".
                        "<td style='text-align:center;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['FACVENFEC']."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial'>".number_format($pagos[$i]['FACTOTAL'],2,'.','')."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial'>".((!$pagos[$i]['monto_credito']) ? "0.00" : "<span style='color:#990000'>-".number_format($pagos[$i]['monto_credito'],2,'.','') ) ."</span></td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial'>".((!$pagos[$i]['monto_debito']) ? "0.00" : number_format($pagos[$i]['monto_debito'],2,'.','') ) ."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold'>".number_format(floatval($pagos[$i]['HISPAGO']) - floatval($pagos[$i]['monto_credito']) + floatval($pagos[$i]['monto_debito']) ,2,'.','')."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial;padding-right:15px;'>".$pagos[$i]['OFIAGEDES']."</td>".
                        "</tr>";
            $mf += floatval($pagos[$i]['FACTOTAL']);
            $mnc += floatval($pagos[$i]['monto_credito']);
            $mnd += floatval($pagos[$i]['monto_debito']);
            $mp += (floatval($pagos[$i]['FACTOTAL']) + floatval($pagos[$i]['monto_debito'])  - floatval($pagos[$i]['monto_credito']));
          }
          if($var % 26 != 0){
            $html .=  '<tr>'.
                        '<td colspan="5" style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;font-weight:bold;font-family:Arial;padding-right:30px">TOTAL</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.number_format($mf,2,'.','').'</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.(($mnc > 0) ? '<span style="color:#990000"> -'.number_format($mnc,2,'.','').'</span>' : '0.00').'</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.number_format($mnd,2,'.','').'</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.number_format($mp,2,'.','').'</td>'.
                        '<td style="border-bottom:1px solid #999;border-left:1px solid #FFF"></td>'.
                      '</tr>';
            $html .= "</table>";
            $mpdf->WriteHTML($html);
          }
          $content = $mpdf->Output('', 'S');
          $content = chunk_split(base64_encode($content));
          $mpdf->Output();
          unset($content);
          unset($mpdf);
          unset($this->pdf);
          unset($this->ciqrcode);
          unset($params);
          unset($pagos);
          exit;
        } 
      } else {
        redirect($this->config->item('ip').'404');
        return;
      }
    } else {
      redirect($this->config->item('ip').'404');
      return;
    }
  }
  public function obtener_rangos(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_PAGOS_RANGOS');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          if(substr($this->input->post('suministro'),3,4) == "0000") $suministro = substr($this->input->post('suministro'),0,3).substr($this->input->post('suministro'), 7,4);
          else $suministro = $this->input->post('suministro');
          $fecha1 = $this->Cuentas_corrientes_model->get_init($suministro);
          $fecha2 = $this->Cuentas_corrientes_model->get_finish($suministro);
          if($fecha1){
            $json = array('result' => true, 'mensaje' => 'ok','fecha' => $fecha1,'fin' => $fecha2);
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function imprimir_rangos($suministro,$fecha1,$fecha2 = null){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_PAGOS_RANGOS');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        if(strlen($suministro) == 7) $user = $this->Cuentas_corrientes_model->get_user_name(substr($suministro, 0,3)."0000".substr($suministro, 3,4));
        else $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
        if($fecha2 == 0) $fecha2 = date('Ym'); 
        $month = substr($fecha2, 0,4).'-'. substr($fecha2, 4,2);
        $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
        $ultimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
        $fecha_inicio = "01/".substr($fecha1, 4,2)."/". substr($fecha1, 0,4);
        $fecha_final = substr($ultimo_dia,8,2)."/".substr($ultimo_dia, 5,2)."/".substr($ultimo_dia, 0,4);
        $pagos = $this->Cuentas_corrientes_model->get_pagos_rangos($suministro,$fecha_inicio,$fecha_final);
        $uministro_real = $suministro;
        if(!$pagos){
          $suministro1 = substr($suministro,0,3).substr($suministro,7,4);
          $pagos = $this->Cuentas_corrientes_model->get_pagos($suministro1);
          $uministro_real = $suministro1;
        }
        foreach ($pagos as $key => $pago) {
          $monto_credito = $this->Cuentas_corrientes_model->get_nota_credito_importe($pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
          $monto_debito =  $this->Cuentas_corrientes_model->get_nota_debito_importe($pago['TOTFAC_FACSERNRO'],$pago['TOTFAC_FACNRO']);
          $pagos[$key]['monto_credito'] = $monto_credito;
          $pagos[$key]['monto_debito'] = $monto_debito;
          unset($monto_credito);
          unset($monto_debito);
        }
        if(sizeof($pagos)>0){
          $this->load->library('ciqrcode');
          $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
          $params['level'] = 'H';
          $params['size'] = 1;
          $params['savename'] = FCPATH.'tes.png';
          $this->ciqrcode->generate($params);
          $this->load->library('pdf');
          $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);
          $mpdf->SetTitle('PAGOS '.$suministro);
          $i= 0;
          $var = sizeof($pagos);
          $var1 = intval($var / 50);
          $var2 = $var%50;
          $mf = 0;
          $mp = 0;
          $mnc = 0;
          $mnd = 0;
          if($var2 > 0) $var1++;
          //$mpdf->SetProtection(array(), 'AlexJL', '12345678');
          $mpdf->SetHTMLHeader('<table width="100%" style="font-size:11px;font-family: Arial">'.
                                  '<tr>'.
                                    '<td style="text-align:left;width:25%"><img src="'.$this->config->item('ip').'/img/logo4.jpg" style="width:22%" /></td>'.
                                    '<td style="width:55%;text-align:center"><h3 style="font-size:18px;font-family: Arial">RELACIÓN DE PAGOS</h3></td>'.
                                    '<td style="text-align:right"><b>FECHA: </b>'.date('d/m/y').'<br><b>HORA: </b>'.date('H:i:s').'<br><b>Página: </b>{PAGENO}</td>'.
                                    '<td style="width:7%"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                                  '</tr>'.
                                '</table>');
          for($i;$i<$var;$i++){
            if($i % 26 == 0){
              if($i % 26 == 0 && $i != 0){
                $html .= "</table>";
                $mpdf->WriteHTML($html);
              }
              $mpdf->AddPage('L');
              $mpdf->SetHTMLHeader('<table width="100%" style="font-size:11px;font-family: Arial">'.
                                  '<tr>'.
                                    '<td style="text-align:left;width:25%"><img src="'.$this->config->item('ip').'/img/logo4.jpg" style="width:22%" /></td>'.
                                    '<td style="width:55%;text-align:center"><h3 style="font-size:18px;font-family: Arial">RELACIÓN DE PAGOS</h3></td>'.
                                    '<td style="text-align:right"><b>FECHA: </b>'.date('d/m/y').'<br><b>HORA: </b>'.date('H:i:s').'<br><b>Página: </b>{PAGENO}</td>'.
                                    '<td style="width:7%"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                                  '</tr>'.
                                '</table>');
              $html = '<br><br>'.
                    '<table width="100%">'.
                      '<tr>'.
                        '<td style="font-size:12px;width:10%;font-family: Arial"><b style="font-size:12px;font-family: Arial">SUMINISTRO: </b> '.$suministro.'</td>'.
                        '<td style="font-size:12px;width:20%;font-family: Arial"><b style="font-size:12px;font-family: Arial">NOMBRE: </b> '.$user['CLINOMBRE'].'</td>'.
                        '<td style="font-size:12px;width:20%;font-family: Arial"><b style="font-size:12px;font-family: Arial">DIRECCIÓN: </b> '.$user['URBDES'].' '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
                        '<td style="font-size:12px;width:15%;font-family: Arial;text-align:right"><b style="font-size:12px;font-family: Arial">TARIFA: </b> '.$user['TARIFA'].'</td>'.
                      '</tr>'.
                    '</table>'.
                    '<br>'.
                    '<table width="100%" style="font-size:11px" cellpadding="0" cellspacing="0">'.
                      '<tr>'.
                        '<td style="border: 1px solid #000;font-size:12px;text-align:center;width:5%;padding-top:8px;padding-bottom:8px"><b style="font-family:Arial">SERIE</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:9%"><b style="font-family:Arial">NUMERO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:10%"><b style="font-family:Arial">FECHA PAGO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:10%"><b style="font-family:Arial">FECHA EMISIÓN</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:13%"><b style="font-family:Arial">FECHA VENCIMIENTO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">FACTURADO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">N CRÉDITO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">N DÉBITO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center;width:8%"><b style="font-family:Arial">PAGADO</b></td>'.
                        '<td style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;text-align:center"><b style="font-family:Arial">PUNTO COBRANZA</b></td>'.
                      '</tr>';
            }
            $html .=  "<tr>".
                        "<td style='text-align:center;padding:3px;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['TOTFAC_FACSERNRO']."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:15px;font-family:Arial'>".$pagos[$i]['TOTFAC_FACNRO']."</td>".
                        "<td style='text-align:center;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['HISCOBFEC']."</td>".
                        "<td style='text-align:center;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['HISEMIFEC']."</td>".
                        "<td style='text-align:center;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial'>".$pagos[$i]['FACVENFEC']."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial'>".number_format($pagos[$i]['FACTOTAL'],2,'.','')."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial'>".((!$pagos[$i]['monto_credito']) ? "0.00" : "<span style='color:#990000'>-".number_format($pagos[$i]['monto_credito'],2,'.','') ) ."</span></td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial'>".((!$pagos[$i]['monto_debito']) ? "0.00" : number_format($pagos[$i]['monto_debito'],2,'.','') ) ."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold'>".number_format(floatval($pagos[$i]['HISPAGO']) - floatval($pagos[$i]['monto_credito']) + floatval($pagos[$i]['monto_debito']) ,2,'.','')."</td>".
                        "<td style='text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;font-family:Arial;padding-right:15px;'>".$pagos[$i]['OFIAGEDES']."</td>".
                        "</tr>";
            $mf += floatval($pagos[$i]['FACTOTAL']);
            $mnc += floatval($pagos[$i]['monto_credito']);
            $mnd += floatval($pagos[$i]['monto_debito']);
            $mp += (floatval($pagos[$i]['FACTOTAL']) + floatval($pagos[$i]['monto_debito'])  - floatval($pagos[$i]['monto_credito']));
          }
          if($var % 26 != 0){
            $html .=  '<tr>'.
                        '<td colspan="5" style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;font-weight:bold;font-family:Arial;padding-right:30px">TOTAL</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.number_format($mf,2,'.','').'</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.(($mnc > 0) ? '<span style="color:#990000"> -'.number_format($mnc,2,'.','').'</span>' : '0.00').'</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.number_format($mnd,2,'.','').'</td>'.
                        '<td style="font-size:12px;text-align:right;border-bottom:1px solid #999;border-left:1px solid #FFF;padding-right:10px;font-family:Arial;font-weight:bold;">'.number_format($mp,2,'.','').'</td>'.
                        '<td style="border-bottom:1px solid #999;border-left:1px solid #FFF"></td>'.
                      '</tr>';
            $html .= "</table>";
            $mpdf->WriteHTML($html);
          }
          $content = $mpdf->Output('', 'S');
          $content = chunk_split(base64_encode($content));
          $mpdf->Output();
          unset($content);
          unset($mpdf);
          unset($this->pdf);
          unset($this->ciqrcode);
          unset($params);
          unset($pagos);
          exit;
        } 
      } else {
        redirect($this->config->item('ip').'404');
        return;
      }
    } else {
      redirect($this->config->item('ip').'404');
      return;  
    }
  }
  public function imprimir_notaC($_suministro,$serie,$nro){ 
    ini_set('memory_limit','-1');
    ini_set('max_execution_time',360000);
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_NCA');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $suministro = $this->desencriptar($_suministro);
        $notaCredito = $this->Cuentas_corrientes_model->get_notaCredito($serie,$nro);
        $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
        if($user == null) $user = $this->Cuentas_corrientes_model->get_user_name(substr($suministro,0,3)."0000".substr($suministro,3,4));
        $nca1 = $this->Cuentas_corrientes_model->get_nca1($serie,$nro);
        $nca2 = $this->Cuentas_corrientes_model->get_nca2($serie,$nro);
        $user_crea = $this->Cuentas_corrientes_model->get_nuser($notaCredito['NCACREA']);
        $cuenta_corriente = $this->Cuentas_corrientes_model->get_cuenta_fac($notaCredito['TOTFAC_FACSERNRO'],$notaCredito['TOTFAC_FACNRO']);
        $medidor = $this->Cuentas_corrientes_model->get_medidor($notaCredito['TOTFAC_FACSERNRO'],$notaCredito['TOTFAC_FACNRO']);
        $recibo = $this->Cuentas_corrientes_model->get_recibo($notaCredito['TOTFAC_FACSERNRO'],$notaCredito['TOTFAC_FACNRO']);
        $volumen = $this->Cuentas_corrientes_model->volumen_leido($notaCredito['TOTFAC_FACSERNRO'],$notaCredito['TOTFAC_FACNRO']);
        $PROCESOFAC =  $cuenta_corriente['PROCESOFAC'];
        $ANIO = intval(substr($PROCESOFAC,0,4));
        $MES = intval(substr($PROCESOFAC,4,2));
        $MESANTERIOR =  $MES - 1;
        if($MESANTERIOR == 0) $MESANTERIOR = 12;$ANIO=$ANIO - 1;
        if($MESANTERIOR <10) $PERIODO = $ANIO.'0'.$MESANTERIOR;
        else $PERIODO = $ANIO.$MESANTERIOR;
        $lectura_anterior = $this->Cuentas_corrientes_model->get_cuenta_anterior($PERIODO,$suministro);
        if( !$medidor ) $medidor = "";
        else $medidor =  $medidor;
        $direccion = $user['URBDES']." ".$user['CALDES']." ".$user['CLIMUNNRO'];
        if(strlen($direccion)>32) $direccion = substr($direccion,0,32);
        $arreglo = array();
        foreach($nca1 as $nc){
          if($nc['DEUDA'] != 0) array_push($arreglo,$nc);
        }
        foreach($nca2 as $nc1){
          if($nc1['DEUDA'] != 0 || $nc1['DEUDA'] == NULL) array_push($arreglo,$nc1);
        }
        $detalle = "<div>";
        $detalle .= "<table width='100%' cellpadding='0' cellspacing='0' style='margin-left:-30px;margin-right:40px'>";
        for($i = 0; $i < sizeof($arreglo); $i++){
          $detalle.= "<tr>".
                        "<td style='width:5%;border-right:1px solid #000;border-left:1px solid #000;padding-bottom:7px;text-align:center'>".($i+2)."</td>".
                        "<td style='width:55%; padding-left:10px;padding-bottom:7px;border-right:1px solid #000;'>".$arreglo[$i]['NUMERO']." ".$arreglo[$i]['CONCEPTO']."</td>".
                        "<td style='width:20%;padding-bottom:7px;border-right:1px solid #000;'></td>".
                        "<td style='text-align:right;padding-right:10px;padding-bottom:7px;border-right:1px solid #000;'>".number_format($arreglo[$i]['DEUDA'],2,'.','')."</td>".
                      "</tr>";
        }
        $numero_restante = 13 - count($arreglo);
        if($numero_restante > 0){
          for($j = 0; $j < $numero_restante; $j++){
              $detalle.= "<tr>".
                            "<td style='width:5%;padding-bottom:7px;color: rgba(255,255,255,1)'>".($i+2)."</td>".
                            "<td style='width:55%; padding-left:10px;padding-bottom:7px;color: rgba(255,255,255,1)'>AAAAAA</td>".
                            "<td style='width:20%;padding-bottom:7px;color: rgba(255,255,255,1)'></td>".
                            "<td style='text-align:right;padding-right:40px;padding-bottom:7px;color: rgba(255,255,255,1)'>AAAAAAA</td>".
                          "</tr>";
          }
        }
        $detalle .= "</table></div>";
        $detalle1 = "<div>";
        $detalle1 .= "<table width='110%' cellpadding='0' cellspacing='0' style='margin-left:20px;margin-right:20px;font-family:Arial'>";
        $cant = count($arreglo);
        for($i = 0; $i < $cant; $i++){
          $detalle1.= "<tr>".
                        "<td style='width:4%;border-right:1px solid #000;border-left:1px solid #000;padding-bottom:7px;text-align:center'>".($i+2)."</td>".
                        "<td style='width:50%; border-right:1px solid #000;padding-left:10px;padding-bottom:7px'>".$arreglo[$i]['NUMERO']." ".$arreglo[$i]['CONCEPTO']."</td>".
                        "<td style='width:35%;padding-bottom:7px;border-right:1px solid #000;'></td>".
                        "<td style='text-align:right;padding-right:10px;padding-bottom:7px;border-right:1px solid #000;'>".number_format($arreglo[$i]['DEUDA'],2,'.','')."</td>".
                      "</tr>";
        }
        $numero_restante = 13 - count($arreglo);
        if($numero_restante > 0){
          for($j = 0; $j < $numero_restante; $j++){
            $detalle1.= "<tr>".
                          "<td style='width:5%;padding-bottom:7px;color: rgba(255,255,255,1)'>".($i+2)."</td>".
                          "<td style='width:55%; padding-left:10px;padding-bottom:7px;color: rgba(255,255,255,1)'>AAAAAA</td>".
                          "<td style='width:20%;padding-bottom:7px;color: rgba(255,255,255,1)'></td>".
                          "<td style='text-align:right;padding-right:40px;padding-bottom:7px;color: rgba(255,255,255,1)'>AAAAAAA</td>".
                        "</tr>";
          }
        }
        $detalle1 .= "</table></div>";
        
        $this->load->library('pdf');
        $html = "<style> @page {margin-top: 0px;}</style>";
        echo memory_get_usage()."<br>";
        $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);
        $mpdf->cacheTables = true;
        $mpdf->packTableData=true;
        $mpdf->AddPage('L');
        $mpdf->SetTitle('NOTA DE CRÉDITO '.$serie." - ".$nro);
        $html .= "<table width='100%' style='font-size:11.5px;font-family:Arial'>";
        $html .= "<tr><td style='width:50%'>";
        #pagina 1
        $html .= "<table width='100%' style='margin-top:-20px;margin-left:-30px'>".
                    "<tr>".
                      "<td rowspan='3' style='width:60%;text-align:center'><img src='".$this->config->item('ip')."/img/logo3.png' style='width:30%'></td>".
                      "<td><b>NOTA CREDITO: ".$serie."-".$nro."</b></td>".
                    "</tr>".
                    "<tr>".
                      "<td><b>FECHA DE EMISIÓN: </b>".$notaCredito['NCAFECHA']."</td>".
                    "</tr>".
                    "<tr>".
                      "<td><b>CÓDIGO: </b>".$suministro."</td>".
                    "</tr>".
                    "<tr>".
                      "<td style='width:60%'><b>CLIENTE:</b> ".$user['CLINOMBRE']."</td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td style='width:60%'><b>DIRECCIÓN: </b>".utf8_encode($direccion)."</td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td style='width:60%'>".(($user['CLIELECT'] == NULL) ? '<b>R.U.C.: </b>'.$user['CLIRUC'] : '<b>D.N.I.: </b>'.$user['CLIELECT'])."</td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td style='width:60%'>".
                        "<table width='100%'>".
                          "<tr>".
                            "<td style='width:40%'><b>MEDIDOR: </b></td>".
                            "<td>".$medidor."</td>".
                            "<td><b>TARIFA: </b></td>".
                            "<td>".$recibo['FACTARIFA']." - ".$recibo['FSETIPCOD']."</td>".
                          "</tr>".
                          "<tr>".
                            "<td style='width:40%'><b>ULTIMA LECTURA: </b></td>".
                            "<td  style='width:20%'>".$cuenta_corriente['LECTURA']."</td>".
                            "<td style='width:20%'></td>".
                            "<td></td>".
                          "</tr>".
                          "<tr>".
                            "<td style='width:40%'><b>LECTURA ANTERIOR: </b></td>".
                            "<td>".$lectura_anterior
                            ."</td>".
                            "<td></td>".
                            "<td></td>".
                          "</tr>".
                          "<tr>".
                            "<td style='width:40%'><b>CONSUMO m<sup>3</sup>: </b></td>".
                            "<td>".$volumen."</td>".
                            "<td></td>".
                            "<td></td>";
        if(isset($notaCredito['NCA_VOLDIF']))
          $html .=  "</tr>".
                    "<tr>".
                      "<td><b>CONSUMO DESC. m<sup>3</sup>: </b></td>".
                      "<td>".$notaCredito['NCA_VOLDIF']."</td>".
                      "<td></td>".
                      "<td></td>";
        $html .= "</tr>".
              "</table>".
            "</td>".
            "<td></td>".
          "</tr>";
        $html .= "</table><br /><br />";
        $html .= $detalle;
        $html .= "<table width='100%' style='font-size:11.5px;margin-left:-30px'>".
                  "<tr>".
                    "<td>".
                      "<table><tr>".
                        "<td><b>Ref.: </b>RECIBO: </td>".
                        "<td>".$notaCredito['TOTFAC_FACSERNRO']."-".$notaCredito['TOTFAC_FACNRO']."-".$notaCredito['NCAFACCHED']."</td>".
                      "</tr><tr>".
                        "<td>Mes: </td>".
                        "<td>".$this->devolver_mes(substr($notaCredito['NCAFACEMIF'],3,2))."</td>".
                      "</tr><tr>".
                        "<td>Emisión: </td>".
                        "<td>".$notaCredito['NCAFACEMIF']." Venc.: ".$notaCredito['NCAFACVENF']."</td>".
                      "</tr><tr>".
                        "<td>Referencia: </td>".
                        "<td >".$notaCredito['NCAREFE']."</td>".
                      "</tr><tr>".
                        "<td>Reclamo: </td>".
                        "<td>".(($notaCredito['REC_NRO'] == NULL) ? 0 : $notaCredito['REC_NRO'])." Tipo: ".(($notaCredito['REC_TIP'] == NULL) ? 0 : $notaCredito['REC_TIP'])."</td>".
                      "</tr>".
                      "</table>".
                    "</td>".
                    "<td>".
                      "<table style='width:80%'><tr>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td> SUB TOTAL: </td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCASUBDIF'],2,'.','')."</b></td>".
                      "</tr><tr>".
                        "<td> I.G.V.:</td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCAIGVDIF'],2,'.','')."</b></td>".
                      "</tr><tr>".
                        "<td>TOTAL: </td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCATOTDIF'],2,'.','')."</b></td>".
                      "</tr>".
                      "</table>".
                    "</td>".
                  "</tr>".
                  "</table>";
        $html .=  "<table width='100%' style='font-size:11.5px;margin-left:-30px'>".
                    "<tr>".
                      "<td style='width:15%'>Autoriza</td>".
                      "<td style='width:10%'>".(($notaCredito['AUT_NRO'] == NULL) ? 0 : $notaCredito['AUT_NRO'] )."</td>".
                      "<td style='width:10%'></td>".
                      "<td style='width:15%'></td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td>Usr. Red: </td>".
                      "<td>".$notaCredito['AUT_NRO']."</td>".
                      "<td>Glosa: </td>".
                      "<td></td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td>Generador: </td>".
                      "<td colspan='3'>".$notaCredito['NCACREA']." ".$user_crea."</td>".
                      "<td style='text-align:right;padding-right:45px'><b>NOTA CRÉDITO: ".$notaCredito['NCASERNRO']."-".$notaCredito['NCANRO']."</b></td>".
                    "</tr>".
                    "<tr>".
                      "<td></td>".
                      "<td></td>".
                      "<td></td>".
                      "<td></td>".
                      "<td style='text-align:right;padding-right:45px'>Fecha de Emisión: ".$notaCredito['NCAFECHA']."</td>".
                    "</tr>".  
                    "</table>";         
        $html .= "<table width='100%' style='margin-left:-30px;margin-bottom:0px'>".
                    "<tr>".
                      "<td colspan='2'><b>CLIENTE: ".$user['CLINOMBRE']."</b></td>".
                      "<td style='text-align:right;padding-right:45px'><b>Código: </b>".$suministro."</td>".
                    "</tr>".
                    "<tr>".
                      "<td width='30%'><b>Mes: </b>".$this->devolver_mes(substr($notaCredito['NCAFACEMIF'],3,2))."</td>".
                      "<td><b>Ref. RECIBO: </b>".$notaCredito['TOTFAC_FACSERNRO']."-".$notaCredito['TOTFAC_FACNRO']."-".$notaCredito['NCAFACCHED']."</td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td></td>".
                      "<td><b>Emisión: </b>".$notaCredito['NCAFACEMIF']."</td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td></td>".
                      "<td><b>Vencimiento: </b>".$notaCredito['NCAFACVENF']."</td>".
                      "<td></td>".
                    "</tr>".
                    "<tr>".
                      "<td></td>".
                      "<td style='font-size:14px'>".$notaCredito['NCAREFE']."</td>".
                      "<td style='font-size:14px; text-align:right;padding-right:45px'><b>Total: ".number_format($notaCredito['NCATOTDIF'],2,'.','')."</b></td>".
                    "</tr>".
                    "</table>";           
        $html .= "</td><td>";

        #pagina 2
        $html .= "<table width='120%' style='margin-left:20px;margin-right:20px;margin-top:-20px;'>".
                 "<tr>".
                 "<td rowspan='3' style='width:60%;text-align:center'><img src='".$this->config->item('ip')."/img/logo3.png' style='width:30%' ></td>".
                 "<td><b>NOTA CREDITO: ".$serie."-".$nro."</b></td>".
                 "</tr><tr>".
                 "<td><b>FECHA DE EMISIÓN: </b>".$notaCredito['NCAFECHA']."</td>".
                 "</tr><tr>".
                 "<td><b>CÓDIGO: </b>".$suministro."</td>".
                 "</tr><tr>".
                 "<td style='width:60%'><b>CLIENTE: </b>".$user['CLINOMBRE']."</td>".
                 "<td></td>".
                 "</tr><tr>".
                 "<td style='width:60%'><b>DIRECCIÓN: </b>".utf8_encode($direccion)."</td>".
                 "<td ></td>".
                 "</tr><tr>".
                 "<td style='width:60%'>".(($user['CLIELECT'] == NULL) ? '<b>R.U.C.: </b>'.$user['CLIRUC'] : '<b>D.N.I.: </b>'.$user['CLIELECT'])."</td>".
                 "<td></td>".
                 "</tr><tr>".
                 "<td style='width:60%'>".
                    "<table width='100%'>".
                      "<tr>".
                        "<td style='width:40%'><b>MEDIDOR: </b></td>".
                        "<td style='width:20%'>".$medidor."</td>".
                        "<td style='width:20%'><b>TARIFA: </b></td>".
                        "<td>".$recibo['FACTARIFA']." - ".$recibo['FSETIPCOD']."</td>".
                      "</tr><tr>".
                        "<td style='width:40%'><b>ULTIMA LECTURA: </b></td>".
                        "<td>".$cuenta_corriente['LECTURA']."</td>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td style='width:40%'><b>LECTURA ANTERIOR: </b></td>".
                        "<td>".$lectura_anterior."</td>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td style='width:40%'><b>CONSUMO m<sup>3</sup>: </b></td>".
                        "<td>".$volumen."</td>".
                        "<td></td>".
                        "<td></td>";
        if(isset($notaCredito['NCA_VOLDIF']))
          $html .= "</tr><tr>".
                    "<td><b>CONSUMO DESC. m<sup>3</sup>: </b></td>".
                    "<td>".$notaCredito['NCA_VOLDIF']."</td>".
                    "<td></td>".
                    "<td></td>";
        $html .= "</tr>".
                "</table>".
                 "<td>".
                 "<td></td>".
                 "</tr>";
        $html .= "</table><br /><br />";
        $html .= $detalle1;
        $html .= "<table width='120%' style='font-size:11.5px;margin-left:20px;margin-right:20px;'>".
                  "<tr>".
                    "<td style='width:60%'>".
                      "<table><tr>".
                        "<td><b>Ref.: </b>RECIBO: </td>".
                        "<td>".$notaCredito['TOTFAC_FACSERNRO']."-".$notaCredito['TOTFAC_FACNRO']."-".$notaCredito['NCAFACCHED']."</td>".
                      "</tr><tr>".
                        "<td>Mes: </td>".
                        "<td>".$this->devolver_mes(substr($notaCredito['NCAFACEMIF'],3,2))."</td>".
                      "</tr><tr>".
                        "<td>Emisión: </td>".
                        "<td>".$notaCredito['NCAFACEMIF']." Venc.: ".$notaCredito['NCAFACVENF']."</td>".
                      "</tr><tr>".
                        "<td>Referencia: </td>".
                        "<td>".$notaCredito['NCAREFE']."</td>".
                      "</tr><tr>".
                        "<td>Reclamo: </td>".
                        "<td>".(($notaCredito['REC_NRO'] == NULL) ? 0 : $notaCredito['REC_NRO'])." Tipo: ".(($notaCredito['REC_TIP'] == NULL) ? 0 : $notaCredito['REC_TIP'])."</td>".
                      "</tr>".
                      "</table>".
                    "</td>".
                    "<td>".
                      "<table width='70%'><tr>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td> SUB TOTAL: </td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCASUBDIF'],2,'.','')."</b></td>".
                      "</tr><tr>".
                        "<td> I.G.V.:</td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCAIGVDIF'],2,'.','')."</b></td>".
                      "</tr><tr>".
                        "<td>TOTAL: </td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCATOTDIF'],2,'.','')."</b></td>".
                      "</tr>".
                      "</table>".
                    "</td>".
                  "</tr>".
                  "</table>";
        $html .= "<table width='120%' style='font-size:11.5px;margin-left:20px;margin-right:20px;'><tr>".
                "<td style='width:15%'>Autoriza</td>".
                "<td style='width:10%'>".(($notaCredito['AUT_NRO'] == NULL) ? 0 : $notaCredito['AUT_NRO'] )."</td>".
                "<td style='width:10%'></td>".
                "<td style='width:15%'></td>".
                "<td></td>".
                "</tr><tr>".
                  "<td>Usr. Red: </td>".
                  "<td>".$notaCredito['AUT_NRO']."</td>".
                  "<td>Glosa: </td>".
                  "<td></td>".
                  "<td></td>".
                "</tr><tr>".
                  "<td>Generador: </td>".
                  "<td colspan='3'>".$notaCredito['NCACREA']." ".$user_crea."</td>".
                  "<td style='text-align:right;padding-right:75px'><b>NOTA CRÉDITO: ".$notaCredito['NCASERNRO']."-".$notaCredito['NCANRO']."</b></td>".
                "</tr><tr>".
                  "<td></td>".
                  "<td></td>".
                  "<td></td>".
                  "<td></td>".
                  "<td style='text-align:right;padding-right:75px'>Fecha de Emisión: ".$notaCredito['NCAFECHA']."</td>".
                "</tr>".
                "</table>";
        $html .= "<table width='120%'  style='font-size:11.5px;margin-left:20px;margin-right:20px;'><tr>".
                  "<td colspan='2'><b>CLIENTE: ".$user['CLINOMBRE']."</b></td>".
                  "<td><b>Código: </b>".$suministro."</td>".
                  "</tr><tr>".
                  "<td width='30%'><b>Mes: </b>".$this->devolver_mes(substr($notaCredito['NCAFACEMIF'],3,2))."</td>".
                  "<td><b>Ref. RECIBO: </b>".$notaCredito['TOTFAC_FACSERNRO']."-".$notaCredito['TOTFAC_FACNRO']."-".$notaCredito['NCAFACCHED']."</td>".
                  "<td></td>".
                  "</tr><tr>".
                  "<td></td>".
                  "<td><b>Emisión: </b>".$notaCredito['NCAFACEMIF']."</td>".
                  "<td></td>".
                  "</tr><tr>".
                  "<td></td>".
                  "<td><b>Vencimiento: </b>".$notaCredito['NCAFACVENF']."</td>".
                  "<td></td>".
                  "</tr><tr>".
                  "<td></td>".
                  "<td style='font-size:14px'>".$notaCredito['NCAREFE']."</td>".
                  "<td style='font-size:14px'><b>Total: ".number_format(floatval($notaCredito['NCATOTDIF']),2,'.','')."</b></td>".
                  "</tr>".
                  "</table>";
        $html .= "</td></tr>";
        $html .= "</table>";
        $mpdf->WriteHTML($html);
        $mpdf->AddPage('L');
        $html1 = "<table width='100%' style='font-size:11.5px'>";
        $html1 .= "<tr><td style='width:50%'>";
        #pagina 3
        $html1 .= "<table width='100%' style='margin-top:-20px;margin-left:-30px'>".
                 "<tr>".
                 "<td rowspan='3' style='width:60%;text-align:center'><img src='".$this->config->item('ip')."/img/logo3.png' style='width:30%'></td>".
                 "<td><b>NOTA CREDITO: ".$serie."-".$nro."</b></td>".
                 "</tr><tr>".
                 "<td><b>FECHA DE EMISIÓN: </b>".$notaCredito['NCAFECHA']."</td>".
                 "</tr><tr>".
                 "<td><b>CÓDIGO: </b>".$suministro."</td>".
                 "</tr><tr>".
                 "<td style='width:60%'><b>CLIENTE: </b>".$user['CLINOMBRE']."</td>".
                 "<td></td>".
                 "</tr><tr>".
                 "<td style='width:60%'><b>DIRECCIÓN </b>: ".utf8_encode($direccion)."</td>".
                 "<td></td>".
                 "</tr><tr>".
                 "<td style='width:60%'>".(($user['CLIELECT'] == NULL) ? '<b>R.U.C.: </b>'.$user['CLIRUC'] : '<b>D.N.I.: </b>'.$user['CLIELECT'])."</td>".
                 "<td></td>".
                 "</tr><tr>".
                 "<td style='width:60%'>".
                    "<table width='100%'>".
                      "<tr>".
                        "<td style='width:40%'><b>MEDIDOR: </b></td>".
                        "<td style='width:20%'>".$medidor."</td>".
                        "<td style='width:20%'><b>TARIFA: </b></td>".
                        "<td>".$recibo['FACTARIFA']." - ".$recibo['FSETIPCOD']."</td>".
                      "</tr><tr>".
                        "<td style='width:40%'><b>ULTIMA LECTURA: </b></td>".
                        "<td>".$cuenta_corriente['LECTURA']."</td>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td style='width:40%'><b>LECTURA ANTERIOR: </b></td>".
                        "<td>".$lectura_anterior."</td>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td style='width:40%'><b>CONSUMO m<sup>3</sup>: </b></td>".
                        "<td>".$volumen."</td>".
                        "<td></td>".
                        "<td></td>";
        if(isset($notaCredito['NCA_VOLDIF']))
          $html1 .= "</tr><tr>".
                    "<td><b>CONSUMO DESC. m<sup>3</sup>: </b></td>".
                    "<td>".$notaCredito['NCA_VOLDIF']."</td>".
                    "<td></td>".
                    "<td></td>";
        $html1 .= "</tr>".
                 "</table>".
                 "<td>".
                 "<td></td>".
                 "</tr>";
        $html1 .= "</table><br /><br />";
        $html1 .= $detalle;
        $html1 .= "<table width='100%' style='font-size:11.5px;margin-left:-30px'>".
                  "<tr>".
                    "<td>".
                      "<table><tr>".
                        "<td><b>Ref.: </b>RECIBO: </td>".
                        "<td>".$notaCredito['TOTFAC_FACSERNRO']."-".$notaCredito['TOTFAC_FACNRO']."-".$notaCredito['NCAFACCHED']."</td>".
                      "</tr><tr>".
                        "<td>Mes: </td>".
                        "<td>".$this->devolver_mes(substr($notaCredito['NCAFACEMIF'],3,2))."</td>".
                      "</tr><tr>".
                        "<td>Emisión: </td>".
                        "<td>".$notaCredito['NCAFACEMIF']." Venc.: ".$notaCredito['NCAFACVENF']."</td>".
                      "</tr><tr>".
                        "<td>Referencia: </td>".
                        "<td>".$notaCredito['NCAREFE']."</td>".
                      "</tr><tr>".
                        "<td>Reclamo: </td>".
                        "<td>".(($notaCredito['REC_NRO'] == NULL) ? 0 : $notaCredito['REC_NRO'])." Tipo: ".(($notaCredito['REC_TIP'] == NULL) ? 0 : $notaCredito['REC_TIP'])."</td>".
                      "</tr>".
                      "</table>".
                    "</td>".
                    "<td>".
                      "<table width='80%'><tr>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td></td>".
                        "<td></td>".
                      "</tr><tr>".
                        "<td> SUB TOTAL: </td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCASUBDIF'],2,'.','')."</b></td>".
                      "</tr><tr>".
                        "<td> I.G.V.:</td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCAIGVDIF'],2,'.','')."</b></td>".
                      "</tr><tr>".
                        "<td>TOTAL: </td>".
                        "<td style='text-align:right'><b>".number_format($notaCredito['NCATOTDIF'],2,'.','')."</b></td>".
                      "</tr>".
                      "</table>".
                    "</td>".
                  "</tr>".
                  "</table>";
        $html1 .= "<table width='100%' style='font-size:11.5px;margin-left:-30px'><tr>".
                  "<td style='width:15%'>Autoriza</td>".
                  "<td style='width:10%'>".(($notaCredito['AUT_NRO'] == NULL) ? 0 : $notaCredito['AUT_NRO'] )."</td>".
                  "<td style='width:10%'></td>".
                  "<td style='width:15%'></td>".
                  "<td></td>".
                  "</tr><tr>".
                    "<td>Usr. Red: </td>".
                    "<td>".$notaCredito['AUT_NRO']."</td>".
                    "<td>Glosa: </td>".
                    "<td></td>".
                    "<td></td>".
                  "</tr><tr>".
                    "<td>Generador: </td>".
                    "<td colspan='3'>".$notaCredito['NCACREA']." ".$user_crea."</td>".
                    "<td style='text-align:right;padding-right:45px'><b>NOTA CRÉDITO: ".$notaCredito['NCASERNRO']."-".$notaCredito['NCANRO']."</b></td>".
                  "</tr><tr>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td style='text-align:right;padding-right:45px'>Fecha de Emisión: ".$notaCredito['NCAFECHA']."</td>".
                  "</tr>".
                  "</table>";
        $html1 .= "<table width='100%' style='margin-left:-30px;margin-bottom:0px'><tr>".
                  "<td colspan='2'><b>CLIENTE: ".$user['CLINOMBRE']."</b></td>".
                  "<td style='text-align:right;padding-right:45px'><b>Código: </b>".$suministro."</td>".
                  "</tr><tr>".
                  "<td width='30%'><b>Mes: </b>".$this->devolver_mes(substr($notaCredito['NCAFACEMIF'],3,2))."</td>".
                  "<td><b>Ref. RECIBO: </b>".$notaCredito['TOTFAC_FACSERNRO']."-".$notaCredito['TOTFAC_FACNRO']."-".$notaCredito['NCAFACCHED']."</td>".
                  "<td></td>".
                  "</tr><tr>".
                  "<td></td>".
                  "<td><b>Emisión: </b>".$notaCredito['NCAFACEMIF']."</td>".
                  "<td></td>".
                  "</tr><tr>".
                  "<td></td>".
                  "<td><b>Vencimiento: </b>".$notaCredito['NCAFACVENF']."</td>".
                  "<td></td>".
                  "</tr><tr>".
                  "<td></td>".
                  "<td style='font-size:14px'>".$notaCredito['NCAREFE']."</td>".
                  "<td style='font-size:14px; text-align:right;padding-right:45px'><b>Total: ".number_format($notaCredito['NCATOTDIF'],2,'.','')."</b></td>".
                  "</tr>".
                  "</table>";
        $html1 .= "</td><td>";
        $html1 .= "</td></tr>";
        $html1 .= "</table>";

        $mpdf->WriteHTML($html1);
        $content = $mpdf->Output('', 's');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit();
      } else {
        redirect($this->config->item('ip').'404');
        return;
      }
    } else {
      redirect($this->config->item('ip').'404');
      return;
    }
  }
  public function buscar_autorizaciones(){ 
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('AUTORIZACIONES');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax =  $this->input->get('ajax');
        if($ajax){
          $_suministro = $this->input->post('suministro');
          $recibos = $this->Cuentas_corrientes_model->get_recibos_x_autorizacion($_suministro);
          $rol = $this->Cuentas_corrientes_model->get_rol($_SESSION['user_id']); 
          $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('GENERAR_NCA'); 
          $opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('ANULAR_NCA'); 
          $generar_nc = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion,$this->data['id_actividad']);
          $anular_nc = $this->Cuentas_corrientes_model->ver_opcion($rol,$opcion1,$this->data['id_actividad']);
          if(!$recibos) $recibos = $this->Cuentas_corrientes_model->get_recibos_x_autorizacion(substr($_suministro, 0,3).substr($_suministro,7,4));
          if($recibos){
            $cuerpo = "";
            foreach ($recibos as $recibo) {
              $cuerpo .= "<tr>".
                          "<td>".$recibo['AUT_NRO']."</td>".
                          "<td>".$recibo['CLIUNICOD']."</td>".
                          "<td>".$recibo['AUT_SER']."</td>".
                          "<td>".$recibo['AUT_REC']."</td>".
                          "<td>".$recibo['AUT_VIGFEC']."</td>".
                          "<td>".(($recibo['AUT_TIPO'] == '1') ? "GENERAR" : "ANULAR" )."</td>";
              if($recibo['AUT_TIPO'] == '1' && $generar_nc) 
                $cuerpo .= "<td style='text-align:center'>".
                            "<a onclick=\"generar_nota_autorizacion('".$recibo['AUT_NRO']."')\"  class='btn btn-primary btn-xs'>".
                                "<i class='fa fa-spinner' aria-hidden='true'></i> GENERAR NOTA CRÉDITO".
                            "</a>".
                           "</td>".
                        "</tr>";
              else if($recibo['AUT_TIPO'] == '2' && $anular_nc) 
                $cuerpo .=  "<td style='text-align:center'>".
                                "<a onclick=\"anular_nota_credito('".$recibo['AUT_NRO']."','".$recibo['OFICOD']."','".$recibo['OFIAGECOD']."','".$recibo['CLIUNICOD']."')\"  class='btn btn-warning btn-xs'>".
                                    "<i class='fa fa-trash' aria-hidden='true'></i> ANULAR NOTA CRÉDITO".
                                "</a>".
                            "</td>".
                        "</tr>";
            }
            $json = array('result' => true, 'mensaje' => 'OK','autorizaciones'=>$cuerpo);
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
          $json = array('result' => false, 'mensaje' => $this->config->item('_mensje_error'));
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
  public function detalle_nota_credito(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_NCA');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax =  $this->input->get('ajax'); 
        if($ajax){ 
          $suministro = $this->input->post('suministro');
          $serie = $this->input->post('serie');
          $nro = $this->input->post('nro');
          $nca = $this->Cuentas_corrientes_model->get_nca($suministro,$serie,$nro);
          if($nca){
            if($nca['NCACREA']) $creo = $this->Cuentas_corrientes_model->get_usuario($nca['NCACREA']);
            else $creo = "";
            $nca1 = $this->Cuentas_corrientes_model->get_nca_1($suministro,$serie,$nro);
            $nca2 = $this->Cuentas_corrientes_model->get_nca_2($suministro,$serie,$nro);
            $contenido = "";
            foreach ($nca1 as $n1) {
              $contenido .= "<tr>".
                              "<td>".$n1['CONCEP_FACCONCOD']."</td>".
                              "<td>".$n1['FACCONDES']."</td>".
                              "<td style='text-align:right'>".number_format($n1['NCAFACPREC'],2,'.','')."</td>".
                              "<td style='text-align:right'>".(($n1['NCAPREDIF']) ? '<span class="text-red">-'.number_format($n1['NCAPREDIF'],2,'.','').'</span>' : "0.00")."</td>".
                              "<td style='text-align:right'>".number_format($n1['NCAPREOK'],2,'.','')."</td>".
                            "</tr>";
            }
            foreach ($nca2 as $n1) {
              $contenido .= "<tr>".
                              "<td>".$n1['CONCEP_FACCONCOD']."</td>".
                              "<td>".$n1['FACCONDES']."</td>".
                              "<td style='text-align:right'>".number_format($n1['NCACRECUOM'],2,'.','')."</td>".
                              "<td style='text-align:right'>".(( !$n1['NCAMONDIF'] ) ? "0.00" : "<span class='text-red'>-".number_format($n1['NCAMONDIF'],2,'.','')."</span>")."</td>".
                              "<td style='text-align:right'>".number_format($n1['NCAMONOK'],2,'.','')."</td>".
                            "</tr>";
            }
            $json = array('result' => true, 'mensaje' => 'OK', 'nca' => $nca,'nota'=>$contenido ,'usuario' => $creo);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else {
          $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    } else {
      $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function visualizar_ampliaciones(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_AMPLIACIONES');
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax =  $this->input->get('ajax'); 
        if($ajax){
          if(substr($this->input->post('suministro'),3,4) == "0000") $suministro = substr($this->input->post('suministro'), 0,3).substr($this->input->post('suministro'), 7,4); 
          else $suministro = $this->input->post('suministro'); 
          $ampliaciones = $this->Cuentas_corrientes_model->get_ampliaciones($suministro);
          if($ampliaciones){
            $contenido = "";
            foreach ($ampliaciones as $a) {
              $contenido .= "<tr>".
                              "<td>".$a['CUT_FEC']."</td>".
                              "<td>".$a['CUT_HRA']."</td>".
                              "<td>".$a['CUT_SER']."</td>".
                              "<td>".$a['CUT_NUM']."</td>".
                              "<td>".$a['CUT_VEN']."</td>".
                              "<td>".$a['CUT_GLO']."</td>".
                              "<td>".$a['CUT_NET']."</td>".
                              "<td>".$a['NCODIGO']."</td>".
                              "<td>".$a['CUT_NWF']."</td>".
                            "</tr>";
            }
            $json = array('result' => true, 'mensaje' => 'OK','ampliaciones'=>$contenido);
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
          $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    } else {
      $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function estados_catastrales(){ 
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('ESTADOS_CATASTRALES');
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
          $ajax  = $this->input->get('ajax');
          if($ajax){
            $suministro = $this->input->post('suministro');
            if(substr($suministro,3,4) == "0000"){
                $grupo = substr($suministro,0,3);
                $subgrupo = substr($suministro,7,4);
                $predio = $this->Cuentas_corrientes_model->get_predio($grupo,$subgrupo);
                $estado = $this->Cuentas_corrientes_model->get_estado_cliente($predio['CLICODFAC']);
                $propie = $this->Cuentas_corrientes_model->get_tarifa($predio['CLICODFAC']);
                $cuenta_corriente = $this->Cuentas_corrientes_model->cuenta_corriente($predio['CLICODFAC']);
                $localidad = $this->Cuentas_corrientes_model->get_localidad($propie['PREREGION'],$propie['PRELOCALI']);
                $cliente = $this->Cuentas_corrientes_model->obtener_client_grupo($grupo, $subgrupo);				
                $medcodigo = $this->Cuentas_corrientes_model->obtener_medcodigo($cliente);
                $medidor = $this->Cuentas_corrientes_model->obetner_medidor($medcodigo);
            } else {
                $estado = $this->Cuentas_corrientes_model->get_estado_cliente($suministro);
                $propie = $this->Cuentas_corrientes_model->get_tarifa($suministro);
                $cuenta_corriente = $this->Cuentas_corrientes_model->cuenta_corriente($suministro);
                $localidad = $this->Cuentas_corrientes_model->get_localidad($propie['PREREGION'],$propie['PRELOCALI']);
                $cliente = $this->Cuentas_corrientes_model->obtener_client_suministro($suministro);
                $medcodigo = $this->Cuentas_corrientes_model->obtener_medcodigo($cliente);
                $medidor = $this->Cuentas_corrientes_model->obetner_medidor($medcodigo);
            }
            if($estado !=  NULL){
                $json =  array('result' =>  true, 'mensaje' => 'OK', 'estado' => $estado,'cuenta' => $cuenta_corriente,'localidad'=>$localidad, 'medidor' => $medidor);
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            } else {
                $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function cambios_catastrales(){ 
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){ 
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('CAMBIOS_CATASTRALES');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          if(substr($this->input->post('suministro'),3,4) == "0000") $suministro = substr($this->input->post('suministro'), 0,3).substr($this->input->post('suministro'), 7,4); 
          else $suministro = $this->input->post('suministro'); 
          $cambios = $this->Cuentas_corrientes_model->get_cambios_catastrales($suministro);
          if($cambios){ 
            $contenido = "";
            foreach ($cambios as $c) {
              $contenido .= "<tr>".
                              "<td>".$c['HISCAMBIO']." - ".$c['DESCAMBIO']."</td>".
                              "<td>".$c['HISCAMFEC']."</td>".
                              "<td>".$c['HISCAMHRS']."</td>".
                              "<td>".$c['HISREFER']."</td>".
                              "<td>".$c['HISUSUAR']."</td>".
                              "<td>".$c['HISVALANT']."</td>".
                              "<td>".trim($c['HISVALDES'])."</td>".
                            "</tr>";
            }
            $json = array('result' => true, 'mensaje' => 'OK','cambios'=>$contenido);
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function detalle_recibo(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){ 
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('CAMBIOS_CATASTRALES');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          $suministro = $this->input->post('suministro'); 
          $serie = $this->input->post('serie');
          $numero = $this->input->post('numero');
          $cliente = $this->Cuentas_corrientes_model->get_one_client($suministro);
          $recibo = $this->Cuentas_corrientes_model->get_recibo($serie,$numero);
          $faclin = $this->Cuentas_corrientes_model->get_faclin($serie,$numero);
          $letfac = $this->Cuentas_corrientes_model->get_letfac($serie,$numero);
          if($recibo){
            $ser_nro = $recibo['FACSERNRO']."-".$recibo['FACNRO'];
            $cabecera = '<div class="row">'.
                          '<div class="col-md-6 col-sm-6 label_input">'.
                            '<div class="input-group">'.
                              '<span class="input-group-addon hidden-sm title_label">CLIENTE</span>'.
                              '<span class="input-group-addon hidden-xs hidden-md hidden-lg title_label">CLT.</span>'.
                              '<input type="text" class="form-control" value="'.$cliente['CLINOMBRE'].'" disabled>'.
                            '</div>'.
                          '</div>'.
                          '<div class="col-md-6 col-sm-6 label_input">'.
                            '<div class="input-group">'.
                              '<span class="input-group-addon hidden-sm title_label">DIRECCIÓN</span>'.
                              '<span class="input-group-addon hidden-xs hidden-md hidden-lg title_label">DIR.</span>'.
                              '<input type="text" class="form-control" value="'.$cliente['URBDES'].' '.$cliente['CALDES'].' '.$cliente["CLIMUNNRO"].'" disabled>'.
                            '</div>'.
                          '</div>'.
                        '</div>'.
                        '<div class="row">'.
                          '<div class="col-md-4 col-sm-4 label_input">'.
                            '<div class="input-group">'.
                              '<span class="input-group-addon hidden-sm title_label">SUMINISTRO</span>'.
                              '<span class="input-group-addon hidden-xs hidden-md hidden-lg title_label">SUM.</span>'.
                              '<input type="text" class="form-control" value="'.$cliente['CLICODFAC'].'" disabled>'.
                            '</div>'.
                          '</div>'.
                          '<div class="col-md-4 col-sm-4 label_input">'.
                            '<div class="input-group">'.
                              '<span class="input-group-addon hidden-sm title_label" >PERIODO</span>'.
                              '<span class="input-group-addon hidden-xs hidden-md hidden-lg title_label">PER.</span>'.
                              '<input type="text" class="form-control" value="'.strtoupper($this->devolver_mes(substr($recibo['FACEMIFEC'],3,2))).' - '.substr($recibo['FACEMIFEC'],6,4).'" disabled>'.
                            '</div>'.
                          '</div>'. 
                          '<div class="col-md-4 col-sm-4 label_input">'.
                            '<div class="input-group">'.
                              '<span class="input-group-addon hidden-sm title_label">FECHA VENCIMIENTO:</span>'.
                              '<span class="input-group-addon hidden-xs hidden-md hidden-lg title_label">FCH. VEN.</span>'.
                              '<input type="text" class="form-control" value="'.$recibo['FACVENFEC'].'" disabled>'.
                            '</div>'.
                          '</div>'.
                        '</div>'.
                        '<div class="row">'.
                          '<div class="col-md-4 col-sm-4 label_input">'.
                            '<div class="input-group">'.
                              '<span class="input-group-addon title_label">CICLO:</span>'.
                              '<input type="text" class="form-control" value="'.$recibo['FCICLO'].'" disabled>'.
                            '</div>'.
                          '</div>'.
                          '<div class="col-md-4 col-sm-4 label_input">'.
                            '<div class="input-group">'.
                              '<span class="input-group-addon title_label">TARIFA:</span>'.
                              '<input type="text" class="form-control" value="'.$recibo['FACTARIFA'].'" disabled>'.
                            '</div>'.
                          '</div>'.
                          '<div class="col-md-4 col-sm-4 label_input">'.
                          '</div>'.
                        '</div>';
            $cuerpo = '<div class="table-responsive">'.
                        '<table id="clientes" class="table table-bordered table-striped">'.
                          '<thead>'.
                            '<tr role="row">'.
                              '<th>NÚMERO</th>'.
                              '<th>NÚMERO CONCEPTO</th>'.
                              '<th>CONCEPTO</th>'.
                              '<th style="text-align:right">IMPORTE (S./)</th>'.
                            '</tr>'.
                          '</thead>'.
                          '<tbody>';
            $i = 1;
            foreach ($faclin as $fac) {
              $cuerpo .= '<tr>'.
                              '<td>'.$i.'</td>'.
                              '<td>'.$fac['FACCONCOD'].'</td>'.
                              '<td>'.$fac['FACCONDES'].'</td>'.
                              '<td class="derecha">'.number_format(floatval($fac['FACPRECI']), 2, '.', '').'</td>'.
                            '</tr>';
              $i++;
            }
            foreach ($letfac as $let) {
              $cuerpo .= '<tr>'.
                              '<td>'.$i.'</td>'.
                              '<td>'.$let['FACCONCOD'].'</td>'.
                              '<td>'.$let['FACCONDES'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$let['LTNUM']."/".$let['CRECUONRO'].' &nbsp;&nbsp;['.$let['CREDNRO'].']</td>'.
                              '<td class="derecha">'.number_format(floatval($let['CRECUOMON']), 2, '.', '').'</td>'.
                            '</tr>';
              $i++;
            }
            $cuerpo .= '<tr>'.
                        '<td class="derecha" colspan="3">SUB TOTAL</td>'.
                        '<td class="derecha">'.number_format(floatval($recibo['FACTOTSUB']), 2, '.', '').'</td>'.
                       '</tr>'.
                       '<tr>'.
                          '<td class="derecha" colspan="3">I.G.V.</td>'.
                          '<td class="derecha">'.number_format(floatval($recibo['FACIGV']), 2, '.', '').'</td>'.
                       '</tr>'.
                       '<tr>'.
                          '<td class="derecha" colspan="3">TOTAL</td>'.
                          '<td class="derecha text-red">'.number_format(floatval($recibo['FACTOTAL']), 2, '.', '').'</td>'.
                       '</tr>';
            $cuerpo .= '</tbody>'.
                        '</table>'.
                        '</div>';
            $json = array('result' => true, 'mensaje' => 'OK','cabecera'=>$cabecera,'ser_nro' => $ser_nro,'cuerpo' => $cuerpo);
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
    } else {
      $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  } 
  private function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
  }
  public function verificar_ampliaciones(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){ 
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('AMPLIAR_PLAZOS_DE_CORTES');  
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax =  $this->input->get('ajax'); 
        if($ajax){ 
          if(substr($this->input->post('suministro'),3,4) == "0000") $suministro = substr($this->input->post('suministro'), 0,3).substr($this->input->post('suministro'), 7,4); 
          else $suministro = $this->input->post('suministro'); 
          $recibos = $this->Cuentas_corrientes_model->recibos_pendientes_ampliacion($suministro);
          if($recibos){ 
            $contenido = "";
            $mes = date('m');
            foreach ($recibos as $c) {
              $contenido .= "<tr>".
                              "<td>".$c['FACSERNRO']."</td>".
                              "<td>".$c['FACNRO']."</td>".
                              "<td>".$c['FACEMIFEC']."</td>".
                              "<td>".$c['FACVENFEC']."</td><td style='text-align:center'>";
              if(substr($c['FACVENFEC'], 3,2) == $mes){
                $contenido .= '<a id="ampliar_plazo" onclick="ampliar(\''.$c['FACSERNRO'].'\',\''.$c['FACNRO'].'\',\''.$c['FACEMIFEC'].'\',\''.$c['FACVENFEC'].'\')" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="AMPLIAR PLAZO"><i class="fa fa-calendar"></i></a>';
              } else {
                $contenido .= '<a id="ampliar_plazo" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="AMPLIAR PLAZO" disabled><i class="fa fa-calendar"></i></a>';
              }
              $contenido .="</td></tr>";
            }
            $json = array('result' => true, 'mensaje' => 'OK','recibos'=>$contenido);
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
          $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else { 
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    } else { 
      $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }    
  }
  public function notas_anuladas(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('ANULACIONES');
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax =  $this->input->get('ajax');
        if($ajax){
          if(substr($this->input->post('suministro'),3,4) == "0000") $suministro = substr($this->input->post('suministro'), 0,3).substr($this->input->post('suministro'), 7,4); 
          else $suministro = $this->input->post('suministro'); 
          $notas = $this->Cuentas_corrientes_model->get_notas_anuladas($suministro);
          if($notas){
            $i = 1;
            $contenido = "";
            foreach ($notas as $nota) {
              $usuario = $this->Cuentas_corrientes_model->user_anulador($nota['NCASERNRO'],$nota['NCANRO'],$suministro);
              $contenido .= "<tr>".
                          "<td>".$i."</td>".
                          "<td>".$nota['NCACLICODF']."</td>".
                          "<td>".$nota['NCASERNRO']."</td>".
                          "<td>".$nota['NCANRO']."</td>".
                          "<td>".number_format(floatval($nota['NCATOTDIF']),2,'.','')."</td>".
                          "<td>".$nota['NCAFECHA']."</td>".
                          "<td>".$usuario."</td>".
                          "<td style='text-align:center'><a class='btn btn-success btn-xs' onclick='detalle_nota(\"".$nota['NCACLICODF']."\",\"".$nota['NCASERNRO']."\",\"".$nota['NCANRO']."\")' ><i class='fa fa-eye' aria-hidden='true'><i> DETALLE NOTA</a></td>".
                        "</tr>";
              $i++;
            }
            $json = array('result' => true, 'mensaje' => 'OK','anulaciones'=>$contenido);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else {
          $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensje_error'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    } else {
      $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
  public function anular_nota(){
      $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
      if($permiso){
        $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('ANULAR_NCA');
        $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
        if($acceso){
            $ajax =  $this->input->get('ajax');
            if($ajax){
              $nro = $this->input->post('numero');
              $oficod = $this->input->post('oficod');
              $ofiagecod = $this->input->post('ofiagecod');
              $suministro = $this->input->post('suministro');
              $resp = $this->Cuentas_corrientes_model->_anular_nota($nro,$oficod,$ofiagecod,$suministro);
              if($resp){
                $this->Cuentas_corrientes_model->actualizar_autorizacion($nro,$oficod,$ofiagecod,$suministro);
                $json = array('result' => true, 'mensaje' => '<b>ÉXITO<b></br>NOTA DE CRÉDITO ANULADA');
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
              } else {
                $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_creado'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
              }
            } else {
              $json = array('result' => false, 'mensaje' => $this->config->item('_mensje_error'));
              header('Access-Control-Allow-Origin: *');
              header('Content-Type: application/x-json; charset=utf-8');
              echo json_encode($json);
            }
        } else {
            $json = array('result' => false, 'mensaje' => $this->config->item('_mensje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->config->item('_mensje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json); 
      }  
   }
  public function get_periodo(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
        $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('FACTURACION');
        $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
        if($acceso){
            $ajax = $this->input->get('ajax');
            if($ajax == true){
                $suministro = $this->input->post('suministro');
                $fecha = $this->Cuentas_corrientes_model->get_fecha_emision($suministro);
                $fecha1 = $this->Cuentas_corrientes_model->get_fecha_emision1($suministro);
                if(!$fecha) $fecha = $this->Cuentas_corrientes_model->get_fecha_emision(substr($suministro, 0,3).substr($suministro, 7,4));
                if(!$fecha1) $fecha1 = $this->Cuentas_corrientes_model->get_fecha_emision1(substr($suministro, 0,3).substr($suministro, 7,4));
                if($fecha){
                   $json = array('result' => true, 'mensaje' => 'OK','fecha' => $fecha, 'fech' => $fecha1);
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
                $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        } else {
            $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    } else {
        $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
    }
  } 
  public function get_facturacion($suministro,$inicio,$fin){ 
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
        $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('FACTURACION');
        $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
        if($acceso){
            $this->data['user_datos'] = $this->Cuentas_corrientes_model->get_one_client($suministro);
            $_suministro = $suministro;
            if($this->data['user_datos'] == null){
              $suministro1 = substr($suministro,0,3)."0000".substr($suministro,3,4);
              $_suministro = $suministro1;
              $this->data['user_datos'] = $this->Cuentas_corrientes_model->get_one_client($suministro1);
            }
            if(substr($suministro, 3,4) == "0000") $_suministro = substr($suministro,0,3).substr($suministro,7,4);
            $this->data['suministro'] = $_suministro;
            $this->data['inicio'] = $inicio;
            $this->data['fin'] = $fin;
            if($inicio == 0 && $fin == 0){
                $recibos = $this->Cuentas_corrientes_model->get_recibos_x_cliente($_suministro."%");
                foreach ($recibos as $key => $value) {
                    $NC = $this->Cuentas_corrientes_model->get_nca_x_cliente($_suministro,$value['FACSERNRO'],$value['FACNRO'],'A');
                    $ND = $this->Cuentas_corrientes_model->get_nca_x_cliente($_suministro,$value['FACSERNRO'],$value['FACNRO'],'C');
                    $volumen = $this->Cuentas_corrientes_model->volumen_leido($value['FACSERNRO'],$value['FACNRO']);
                    $proceso = $this->Cuentas_corrientes_model->get_periodo_duplicado2($value['FACSERNRO'],$value['FACNRO']);
                    $recibos[$key]['NC'] = $NC;
                    $recibos[$key]['ND'] = $ND;
                    $recibos[$key]['vol'] = $volumen;
                    $recibos[$key]['proceso'] = $proceso;
                    unset($NC);
                    unset($ND);
                    unset($volumen);
                }
                $this->data['recibos'] = $recibos;
            } else if ($inicio != 0 && $fin == 0){
                $fecha = "01/".substr($inicio,4,2)."/".substr($inicio,0,4);
                $recibos = $this->Cuentas_corrientes_model->get_recibos_x_cliente2($_suministro,$fecha);
                foreach ($recibos as $key => $value) {
                    $NC = $this->Cuentas_corrientes_model->get_nca_x_cliente($_suministro,$value['FACSERNRO'],$value['FACNRO'],'A');
                    $ND = $this->Cuentas_corrientes_model->get_nca_x_cliente($_suministro,$value['FACSERNRO'],$value['FACNRO'],'C');
                    $volumen = $this->Cuentas_corrientes_model->volumen_leido($value['FACSERNRO'],$value['FACNRO']);
                    $proceso = $this->Cuentas_corrientes_model->get_periodo_duplicado2($value['FACSERNRO'],$value['FACNRO']);
                    $recibos[$key]['NC'] = $NC;
                    $recibos[$key]['ND'] = $ND;
                    $recibos[$key]['vol'] = $volumen;
                    $recibos[$key]['proceso'] = $proceso;
                    unset($NC);
                    unset($ND);
                    unset($volumen);
                }
                $this->data['recibos'] = $recibos;
            } else {
                $fecha = "01/".substr($inicio,4,2)."/".substr($inicio,0,4);
                $month = substr($fin,0,4).'-'.substr($fin,4,2);
                $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
                $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
                $fecha1 = substr($last_day,8,2)."-".substr($last_day,5,2)."-".substr($last_day,0,4);
                $recibos = $this->Cuentas_corrientes_model->get_recibos_x_cliente3($_suministro,$fecha,$fecha1);
                foreach ($recibos as $key => $value) {
                    $NC = $this->Cuentas_corrientes_model->get_nca_x_cliente($_suministro,$value['FACSERNRO'],$value['FACNRO'],'A');
                    $ND = $this->Cuentas_corrientes_model->get_nca_x_cliente($_suministro,$value['FACSERNRO'],$value['FACNRO'],'C');
                    $volumen = $this->Cuentas_corrientes_model->volumen_leido($value['FACSERNRO'],$value['FACNRO']);
                    $proceso = $this->Cuentas_corrientes_model->get_periodo_duplicado2($value['FACSERNRO'],$value['FACNRO']);
                    $recibos[$key]['NC'] = $NC;
                    $recibos[$key]['ND'] = $ND;
                    $recibos[$key]['vol'] = $volumen;
                    $recibos[$key]['proceso'] = $proceso;
                    unset($NC);
                    unset($ND);
                    unset($volumen);
                }
                $this->data['recibos'] = $recibos;
            }
            $this->data['title'] = 'FACTURACIÓN - '.$_suministro;
            $this->data['view']='cuenta_corriente/Facturacion_view';
            $this->load->view('cuenta_corriente/Template', $this->data);
        } else {
            redirect($this->config->item('ip').'404');
            return;
        }
    } else {
      redirect($this->config->item('ip').'404');
      return;
    }
  }
  public function verificar_convendios(){
        $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
        if($permiso){
            $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('FACTURACION');
            $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
            if($acceso){
                $ajax = $this->input->get('ajax');
                if($ajax){
                    if(substr($this->input->post('suministro'), 3,4) == '0000') $suministro = substr ($this->input->post('suministro'), 0,3).substr ($this->input->post('suministro'),7,4);
                    else $suministro = $this->input->post('suministro');
                    $r = $this->Cuentas_corrientes_model->get_count_convenios($suministro);
                    if($r){
                        $json =  array('result' =>  true, 'mensaje' => 'ok');
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    } else {
                        $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_vacio'));
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }     
                } else {
                    $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_error'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
               $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json); 
            }
        } else {
           $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json); 
        }
  }
  public function consultar_convenio($suministro){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
        $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('FACTURACION');
        $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
        if($acceso){
            if(substr($suministro,3,4) == "0000") $suministro = substr ($suministro, 0,3).substr ($suministro,7,4);
            $this->data['suministro'] = $suministro;
            $this->data['convenios'] = $this->Cuentas_corrientes_model->get_convenios($suministro);
            $this->data['convenios_939_940'] = $this->Cuentas_corrientes_model->get_convenidos_939_940($suministro);
            $this->data['convenios_pendientes'] = $this->Cuentas_corrientes_model->get_convenios_sin_pagar($suministro);
            $this->data['monto'] = $this->Cuentas_corrientes_model->get_monto_convenios($suministro);
            $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_CONVENIO');
            $opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('IMPRIMIR_DETALLE_CONVENIO');
            $this->data['detalle_convenio'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
            $this->data['imprimir_convenio'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion1,$this->data['id_actividad']); 
            $this->data['title'] = 'CONVENIO - '.$suministro;
            $this->data['view'] = 'cuenta_corriente/Convenios_view';
            $this->load->view('cuenta_corriente/template', $this->data);
        } else {
            redirect($this->config->item('ip').'404');
            return;
        }
    } else {
        redirect($this->config->item('ip').'404');
        return;
    }
  }
  public function detalle_convenio(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
        $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_CONVENIO');
        $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
        if($acceso){
            $ajax = $this->input->get('ajax');
            if($ajax){
                $oficina = $this->input->post('oficina');
                $agencia = $this->input->post('agencia');
                $credito = $this->input->post('credito');
                if(substr($this->input->post('suministro'), 3,4) == "0000") $suministro = substr ($this->input->post('suministro'), 0,3).substr ($this->input->post('suministro'), 7,4);
                else $suministro = $this->input->post('suministro');
                $letras = $this->Cuentas_corrientes_model->get_detalles_convenios($oficina,$agencia,$credito);
                if($letras){
                    $convenio = $this->Cuentas_corrientes_model->get_one_convenio($suministro,$credito);
                    $user =  $this->Cuentas_corrientes_model->get_user_name($suministro);
                    if($user == NULL) $user = $this->Cuentas_corrientes_model->get_user_name(substr($suministro,0,3).'0000'.substr($suministro,3,4));
                    $monto_deuda = $this->Cuentas_corrientes_model->deuda_x_convenio($oficina, $agencia, $credito);
                    $letras_pendientes = $this->Cuentas_corrientes_model->num_letras_pendientes($oficina, $agencia, $credito); 
                    $cabecera = "<div class='row'>".
                                    "<div class='col-md-3 col-sm-3 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>CREDITO</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>CDT.</span>".
                                            "<input type='text' class='form-control' value = ".$convenio['CREDNRO']." disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-3 col-sm-3 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon title_label'>TIPO</span>".
                                            "<input type='text' class='form-control' value = ".(($convenio['CREDTIPO'] == 'Y') ? 'COLATERAL' : 'REFINANCIADO')." disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-4 col-sm-4 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>CONCEPTO</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>CONC.</span>".
                                            "<input type='text' class='form-control' value = '".$convenio['CONCEP_FACCONCOD']." - ".$convenio['FACCONDES']."' disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-2 col-sm-2 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>CUOTAS</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>CUO.</span>".
                                            "<input type='text' class='form-control derecha' value = '".$convenio['NROLTS']."' disabled>".       
                                        "</div>".
                                    "</div>".
                                "</div>".
                                "<div class='row'>".
                                    "<div class='col-md-3 col-sm-3 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>SUMINISTRO</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>SUM.</span>".
                                            "<input type='text' class='form-control' value = ".$suministro." disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-6 col-sm-6 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>NOMBRE</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>NOM.</span>".
                                            "<input type='text' class='form-control' value = '".$user['CLINOMBRE']."' disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-3 col-sm-3 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>MONTO CONVENIO</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>MONT. CONV.</span>".
                                            "<input type='text' class='form-control derecha' value = '".number_format(floatval($convenio['DEUDATOTAL']),2,'.','')."' disabled>".       
                                        "</div>".
                                    "</div>".
                                "</div>".
                                "<div class='row'>".
                                    "<div class='col-md-3 col-sm-3 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon title_label'>DEUDA</span>".
                                            "<input type='text' class='form-control derecha' value = '".number_format(floatval($monto_deuda))."' disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-2 col-sm-2 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>PAGADAS</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>PAG.</span>".
                                            "<input type='text' class='form-control derecha' value = '".( $convenio['NROLTS'] -intval($letras_pendientes))."' disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-4 col-sm-4 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>REFERENCIA</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>REF.</span>".
                                            "<input type='text' class='form-control derecha' value = '".$convenio['CREDREFE']."' disabled>".       
                                        "</div>".
                                    "</div>".
                                    "<div class='col-md-3 col-sm-3 label_input'>".
                                        "<div class='input-group'>".
                                            "<span class='input-group-addon hidden-xs hidden-sm title_label'>FECHA</span>".
                                            "<span class='input-group-addon hidden-md hidden-lg title_label'>FCH.</span>".
                                            "<input type='text' class='form-control derecha' value = '".$convenio['CREDFECHA']."' disabled>".       
                                        "</div>".
                                    "</div>".
                                "</div>";
                    $detalle = ""; $i = 1;
                    foreach ($letras as $l){
                        $detalle .= "<tr>".
                                        "<td>".$i."</td>".
                                        "<td class='derecha'>".number_format(floatval($l['LTSALDO']),2,'.','')."</td>".
                                        "<td class='derecha'>".(( $l['LTVALOR'] ) ? number_format(floatval($l['LTVALOR']),2,'.','') : "0.00" )."</td>".
                                        "<td class='derecha'>".(( $l['LTINTER'] ) ? number_format(floatval($l['LTINTER']),2,'.','') : "0.00" )."</td>".
                                        "<td class='derecha'>".(( $l['LTGACOBZ'] ) ? number_format(floatval($l['LTGACOBZ']),2,'.','') : "0.00" )."</td>".
                                        "<td class='derecha'>".(( $l['LTACCION'] ) ? number_format(floatval($l['LTACCION']),2,'.','') : "0.00" )."</td>".
                                        "<td class='derecha'>".(( $l['LTIGV'] ) ? number_format(floatval($l['LTIGV']),2,'.','') : "0.00" )."</td>".
                                        "<td class='derecha'>".(( $l['LTCUOTA'] ) ? number_format(floatval($l['LTCUOTA']),2,'.','') : "0.00" )."</td>".
                                        "<td>".$l['LTVENCIM']."</td>".
                                        "<td>".$l['LTSTATUS']."</td>".
                                        "<td>".(($l['FACSERNROX']) ? $l['FACSERNROX'] : '0')." - ".(($l['FACNROX']) ? $l['FACNROX'] : "0")."</td>".
                                    "</tr>";
                        $i++;
                    }
                    
                    $json =  array('result' =>  true, 'mensaje' =>'ok', 'cabecera' => $cabecera, 'detalle' => $detalle);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json); 
                } else {
                    $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json); 
                }
            } else {
                $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json); 
            }
        } else {
            $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json); 
        }
    } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json); 
    }
  }
  public function imprimir_convenio($suministro,$oficina,$agencia,$credito){
        $detalles = $this->Cuentas_corrientes_model->get_detalles_convenios($oficina,$agencia,$credito);
        $credito = $this->Cuentas_corrientes_model->get_one_convenio($suministro,$credito);
        $agencia = $this->Cuentas_corrientes_model->get_agencia($oficina,$agencia);
        $nombre = $this->Cuentas_corrientes_model->get_user_name($suministro);
        if(!$nombre){
          $nombre = $this->Cuentas_corrientes_model->get_user_name(substr($suministro,0,3)."0000".substr($suministro,3,4));
        }
        $cuotainicial = 0;
        if(!$credito['CTAINICIAL']){ $cuotainicial = number_format(floatval($credito['CTAINICIAL']),2,'.',''); } else { $cuotainicial = 0.00; }
        $cuerpo="";
        $i = 1;$gastos = 0;
        foreach($detalles as $detalle){
            $cuerpo .= "<tr>".
                        "<td>".$i."</td>".
                        "<td>".number_format(floatval($detalle['LTSALDO']),2,'.','')."</td>".
                        "<td>".number_format(floatval($this->validar($detalle['LTVALOR'])),2,'.','')."</td>".
                        "<td>".number_format(floatval($this->validar($detalle['LTINTER'])),2,'.','')."</td>".
                        "<td>".number_format(floatval($this->validar($detalle['LTGACOBZ'])),2,'.','')."</td>".
                        "<td>".number_format(floatval($this->validar($detalle['LTACCION'])),2,'.','')."</td>".
                        "<td>".number_format(floatval($this->validar($detalle['LTIGV'])),2,'.','')."</td>".
                        "<td>".number_format(floatval($this->validar($detalle['LTCUOTA'])),2,'.','')."</td>".
                        "<td>".$detalle['LTVENCIM']."</td><td>".$detalle['LTSTATUS']."</td>".
                        "<td>";
            if($detalle['LTSTATUS'] == 'I'){ $gastos += floatval($detalle['LTCUOTA']);}
            if($detalle['LTFECCANC'] == NULL){
                $cuerpo .= " / / </td></tr>";
            }else{
                $cuerpo .= $detalle['LTFECCANC']."</td></tr>";
            }
            $i++;
        }
        $cuerpo .= '</table>';

        $this->load->library('ciqrcode');
        $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
        $params['level'] = 'H';
        $params['size'] = 1;
        $params['savename'] = FCPATH.'tes.png';
        $this->ciqrcode->generate($params);
        $estado = "";
        switch ($credito['CREDSTATUS']) {
          case 'P':
            $estado = "PAGADO";
            break;
          case 'I':
            $estado = "IMPAGO";
            break;
          case 'C':
            $estado = "CREDITO";
            break;
          case 'A':
            $estado = "ANULADO";
            break;
          case 'F':
            $estado = "FACTURADO";
            break;
          default:
            $estado = "";
            break;
        }

        $this->load->library('pdf');
        $mpdf = $this->pdf->load();

        $mpdf->SetHTMLHeader('<h2 style="text-align:center;font-size:16px">Empresa de Servicio de Agua Potable y Alcantarillado de la Libertad S.A.</h2>');
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $mpdf->SetHTMLFooter("<hr style='width:140%;border:none;background:#000;'><table width='100%' style='font-size:12px'><tr><td><img src='".$this->config->item('ip')."tes.png' /></td><td>".$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y')."</td><td>Hora: ".strftime('%I:%M:%S %p')."</td><td>Página N° {PAGENO}</td></tr></table>");
        $html = "<table width='100%'><tr><td style='text-align:left'>SEDALIB S.A. R.U.C. 20131911310</td><td style='text-align:right'>".$agencia['OFIAGEDES']."</td></tr></table>".
            "<h1 style='text-align:center;font-size:22px'>CONVENIO DE PAGO N°: ".$credito['CREDNRO']."</h1>".
            "<hr style='width:140%;border:none;background:#000;margin-top:-10px'>".
            "<table width='100%'><tr><td style='width:33%'>Fecha de Convenio: ".$credito['CREDFECHA']."</td><td>Ref.:".$credito['CREDREFE']."</td><td>Cuenta: ".$credito['CONCEP_FACCONCOD']."</td><td>Estado: ".$estado."</td></tr></table>".
            "<hr style='width:140%;border:none;background:#000'>".
            "<div style='text-align:justify'>Por el presente documento, el Sr.(Sra). ".$nombre['CLINOMBRE']." (".$suministro.") identificado(a) con L.E. ".$nombre['CLIELECT']." y domiciliado(a) en ".$nombre['URBDES']." - ".$nombre['CALDES']." - # ".$nombre['CLIMUNNRO'].", que tiene una deuda por ".$credito['FACCONDES']." de S./ ". number_format(floatval($credito['DEUDATOTAL']),2,'.','').", suscribe una convenio de pago con la empresa SEDALIB S.A. para hacer efectivo dicha deuda en un total de ".$credito['NROLTS']." Cuotas, dando la suma de  S./ ".$cuotainicial." como amortización inicial</div><br>".
            "<table style='width:100%'  cellpadding='0' cellspacing='0'>".
            "<tr><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>N°</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Saldo</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Capital</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Interes</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>GasCob</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Acciones</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>IGV</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Cuota</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Vencimiento</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Estado</td><td style='border-top:1px solid #000;padding-top:3px;padding-bottom:3px;border-bottom:1px solid #000'>Cancelación</td></tr>";
        $html .= $cuerpo;
        $html .= "<br><hr style='width:140%;border:none;background:#000;'>".
            "<div style='text-align:center;font-size:15px'>".$this->data['credito']['NROLTS']." CUOTA(S) PENDIENTE(S) DE EMITIR POR ----> ".number_format(floatval($gastos),2,'.','')." </div><hr style='width:140%;border:none;background:#000;'>";
        $mpdf->WriteHTML($html);
        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit;
    }
  public function validar($valor){
    if(!$valor) return 0;
    else return $valor;
  }
  public function getConsumos(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
        $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_CONVENIO');
        $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
        if($acceso){
            $ajax = $this->input->get('ajax');
            if($ajax){
                $suministro = $this->input->post("suministro");
                $resp = $this->Cuentas_corrientes_model->obtenerConsumos($suministro);
                if($resp){
                    $cuerpo = "";
                    /*for($i = 1; $i < 14; $i++){
                        $cuerpo .= "<tr>". 
                                        "<td>".$resp[(($i < 10) ? "FECLEC0".$i : "FECLEC".$i) ]."</td>".
                                        "<td></td>".
                                    "</tr>";
                    }*/
                    $json =  array('result' =>  true, 'mensaje' => 'ok','consumos' => $resp,'cuerpo' => $cuerpo);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                } else {
                    $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json); 
            }
        } else{
            $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json); 
        }
    } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json); 
    }

}
  public function acciones_ejecutadas(){
    $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    if($permiso){
      $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('ACCIONES_EJECUTADAS');
      $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
      if($acceso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          $suministro = $this->input->post('suministro');
          if(substr($suministro,3,4) == "0000") $suministro = substr($suministro,0,3).substr($suministro,7,4);
          $acciones = $this->Cuentas_corrientes_model->get_count_acciones_coercitivas($suministro);
          if($acciones > 0){
            $json =  array('result' =>  true, 'mensaje' => 'ok');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else {
          $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json); 
        }
      } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    } else {
      $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json); 
    }
  }
  public function listar_acciones_ejecutudas($suministro){
      $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
      if($permiso){
          $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('ACCIONES_EJECUTADAS');
          $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
          if($acceso){
              $this->data['suministro'] = $suministro;
              if(substr($suministro,3,4) == "0000") $suministro = substr($suministro,0,3).substr($suministro,7,4);
              $acciones = $this->Cuentas_corrientes_model->get_acciones_coercitivas($suministro);
              foreach ($acciones as $key => $accion) {
                  $valor1 = $this->Cuentas_corrientes_model->get_orden_corte($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM']);
                  $valor2 = $this->Cuentas_corrientes_model->get_acciones_reconexion($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
                  $valor = $this->Cuentas_corrientes_model->get_acciadd($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
                  $acciones[$key]['orden_corte'] = $valor1;
                  $acciones[$key]['ACCIADO'] = $valor;
                  $acciones[$key]['reconexion'] = $valor2;
              }
              foreach ($acciones as $key => $accion) {
                  if($accion['ACCIADO'] != NULL){
                      foreach ($accion['ACCIADO'] as $key2 => $valor7) {
                          $niveles = $this->Cuentas_corrientes_model->get_nivel_corte($valor7['PNIVELCO_NIV_CODI']);
                          $observacion = $this->Cuentas_corrientes_model->get_observacion_corte($valor7['TOBSERVA_OBS_CODI']);
                          $detalle_deuda = $this->Cuentas_corrientes_model->get_recibos_x_corte1($valor7['TCORTADO_ORDENCOR_OC_OFI'],$valor7['TCORTADO_ORDENCOR_OC_AGE'],$valor7['TCORTADO_ORDENCOR_ORC_NUM'],$valor7['TCORTADO_CLIUNICOD']);
                          $accion['ACCIADO'][$key2]['nivel'] = $niveles;
                          $accion['ACCIADO'][$key2]['OBSERVACION'] = $observacion;
                          $accion['ACCIADO'][$key2]['deuda'] = $detalle_deuda;
                      }
                  }
                  if($accion['reconexion'] != NULL){
                      $service = $this->Cuentas_corrientes_model->get_service1($accion['reconexion']['REA_CRT']);
                      $cab_fecha = $this->Cuentas_corrientes_model->get_fecha_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
                      $cab_hora = $this->Cuentas_corrientes_model->get_hora_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
                      $obs = $this->Cuentas_corrientes_model->get_obs($accion['reconexion']['REA_OBR']);
                      $accion['reconexion']['service'] = $service;
                      $accion['reconexion']['REA_FEC'] = $cab_fecha;
                      $accion['reconexion']['REA_HRA'] = $cab_hora;
                      $accion['reconexion']['OBS_DETA'] = $obs;
                  }
                  $valor1 = $this->Cuentas_corrientes_model->get_cartera($accion['orden_corte']['TACCORTE_ACC_CODIGO']);
                  $acciones[$key]['cartera'] = $valor1;
                  $acciones[$key]['ACCIADO'] = $accion['ACCIADO'];
                  $acciones[$key]['reconexion'] = $accion['reconexion'];
        }
        $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_RECIBO');
        $this->data['ver_detalle'] = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
              $this->data['acciones']  = $acciones;
              $this->data['title'] = 'ACCIONES EJECUTADAS - '.$suministro;
              $this->data['view'] = 'cuenta_corriente/Acciones_Ejecutadas_view';
              $this->load->view('cuenta_corriente/Template', $this->data);
          } else {
              $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
              redirect($this->config->item('ip').'cuenta_corriente/mostrar_cartera/'.$suministro);
              return;
          }
      } else {
          $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
          redirect($this->config->item('ip').'cuenta_corriente/mostrar_cartera/'.$suministro);
          return;
      }
  }

/** siac en genesys */

public function informe_siac(){
  $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
  if($permiso){
    $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('INFORMACION_CAMPO');
    $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
    if($acceso){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $suministro = $this->input->post('suministro');
        $lecturas = $this->Cuentas_corrientes_model->getLecturas($suministro);
        $relecturas = $this->Cuentas_corrientes_model->getRelecturas($suministro);
        $notificaciones = $this->Cuentas_corrientes_model->getNotificacionesFacturacion($suministro);
        $inspeccion_interna = $this->Cuentas_corrientes_model->getInspeccionesInternas($suministro);
        $inspeccion_externa = $this->Cuentas_corrientes_model->getInspeccionesExternas($suministro);
        if($lecturas || $relecturas || $notificaciones || $inspeccion_interna || $inspeccion_externa){
          $cuerpo_lecturas = "";
          $cuerpo_relecturas = "";
          $cuerpo_notificaciones = "";
          $cuerpo_inspeccion_interna = "";
          $cuerpo_inspeccion_externa = "";
          foreach($lecturas as $l){
            $cuerpo_lecturas .= '<tr>'.
                                    '<td>'.$l['ORDEN_TRABAJO'].'</td>'.
                                    '<td>'.$l['CICLO'].'</td>'.
                                    '<td>'.$l['NOMBRE'].'</td>'.
                                    '<td>'.$l['MEDCODYGO'].'</td>'.
                                    '<td>'.
                                      (( $l['LECTURA'] > 0 ) ? $l['LECTURA'].'m<sup>3</sup> ' : '' ).
                                      (( $l['IMGLEC'] ) ? ' &nbsp; <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Foto lectura" onclick="ver_imagen_lectura(\''.$l['IMGLEC'].'\',\''.$l['LECTURA'].'\',\''.$l['FECLEC'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                      </a> ' : '').
                                      (( $l['IMGOPC'] ) ? '&nbsp; <a class="btn btn-success btn-xs" data-toggle="tooltip" title="Foto lectura Opcional" onclick="ver_imagen_opcional_lectura(\''.$l['IMGOPC'].'\',\''.$l['LECTURA'].'\',\''.$l['FECLEC'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                      </a> ' : '').
                                    '</td>'.
                                    '<td>'.
                                      (( $l['OBS'] != "0") ? "<b>OBS: </b>".$l['OBS'] : '').
                                      (( $l['OBS2'] != "0" ? "<br><b>OBS 2:</b>".$l['OBS2'] : ' ' )).
                                      (( $l['IMGSOBS'] ) ? '<a class="btn btn-warning btn-xs" data-toggle="tooltip" title="Foto Observacion lectura" onclick="ver_imagen_obs_lectura(\''.$l['OBS'].'\', \''.$l['IMGSOBS'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                      </a> ' : '').
                                    '</td>'.
                                    '<td>'.$l['FECLEC'].'</td>'.
                                  '</tr>';
          }
          foreach($relecturas as $r){
            $cuerpo_relecturas .= '<tr>'.
                                    '<td>'.$r['ORDEN_TRABAJO'].'</td>'.
                                    '<td>'.$r['CICLO'].'</td>'.
                                    '<td>'.$r['NOMBRE'].'</td>'.
                                    '<td>'.$r['MEDCODYGO'].'</td>'.
                                    '<td>'.
                                      (( $r['RELECTURA'] > 0 ) ? $r['RELECTURA'].'m<sup>3</sup> ' : '' ).
                                      (( $r['IMGRLEC'] ) ? ' &nbsp; <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Foto relectura" onclick="ver_imagen_relectura(\''.$r['IMGRLEC'].'\',\''.$r['RELECTURA'].'\',\''.$r['FECRLEC'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                    </a> ' : '').
                                    (( $r['IMGOPC'] ) ? '&nbsp; <a class="btn btn-success btn-xs" data-toggle="tooltip" title="Foto relectura Opcional" onclick="ver_imagen_opcional_relectura(\''.$r['IMGOPC'].'\',\''.$r['RELECTURA'].'\',\''.$r['FECRLEC'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                    </a> ' : '').
                                    '</td>'.
                                    '<td>'.
                                      (( $r['OBS'] != "0") ? "<b>OBS: </b>".$r['OBS'] : '').
                                      (( $r['OBS2'] != "0" ? "<br><b>OBS 2:</b>".$r['OBS2'] : ' ' )).
                                      (( $r['IMGSOBS'] ) ? '<a class="btn btn-warning btn-xs" data-toggle="tooltip" title="Foto Observacion lectura" onclick="ver_imagen_obs_relectura(\''.$r['OBS'].'\', \''.$r['IMGSOBS'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                    </a> ' : '').
                                    '</td>'.
                                    '<td>'.$r['FECRLEC'].'</td>'.
                                    '<td>'.
                                      (( $r['LecVal'] > 0 ) ? $r['LecVal'].'m<sup>3</sup> ' : '' ).
                                      (( $r['LecImg'] ) ? ' &nbsp; <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Foto lectura" onclick="ver_imagen_lectura(\''.$r['LecImg'].'\',\''.$r['LecVal'].'\',\''.$r['FECLEC'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                      </a> ' : '').
                                      (( $r['LecImg2'] ) ? '&nbsp; <a class="btn btn-success btn-xs" data-toggle="tooltip" title="Foto lectura Opcional" onclick="ver_imagen_opcional_lectura(\''.$r['LecImg2'].'\',\''.$r['LecVal'].'\',\''.$r['FECLEC'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                      </a> ' : '').
                                    '<td>'.$r['FECLEC'].'</td>'.
                                    '<td>'.$r['OrtNum'].'</td>'.
                                  '</tr>';
          }
          foreach($notificaciones as $i){
            $cuerpo_notificaciones .= '<tr>'.
                                      '<td>'.$i['ORDEN_TRABAJO'].'</td>'.
                                      '<td>'.$i['NRO_VIS'].'</td>'.
                                      '<td>'.
                                        (( $i['PRMVIS_RCL'] ) ? '<b>1ra V.: </b>'.$i['PRMVIS_RCL'].'<br>' : '<b>1ra V.: </b> -- <br>').
                                        (( $i['SEGVIS_RCL'] ) ? '<b>2da V.: </b>'.$i['SEGVIS_RCL'].'<br>' : '<b>2da V.: </b> -- <br>').
                                        (( $i['DNI_RCL'] ) ? '<b>D.N.I.: </b>'.$i['DNI_RCL'].'<br>' : '<b>D.N.I.: </b> -- <br>').
                                        (( $i['FIR_RCL'] ) ? '<b>Firma: </b>'.$i['FIR_RCL'].'<br>' : '<b>Firma: </b> -- <br>').
                                      '</td>'.
                                      '<td>'.
                                        (( $i['PRMVIS_PER_DIS'] ) ? '<b>1ra V.: </b>'.$i['PRMVIS_PER_DIS'].'<br>' : '<b>1ra V.: </b> -- <br>').
                                        (( $i['SEGVIS_PER_DIS'] ) ? '<b>2da V.: </b>'.$i['SEGVIS_PER_DIS'].'<br>' : '<b>2da V.: </b> -- <br>').
                                        (( $i['DNI_PER_DIS'] ) ? '<b>D.N.I.: </b>'.$i['DNI_PER_DIS'].'<br>' : '<b>D.N.I.: </b> -- <br>').
                                        (( $i['FIR_PER_DIS'] ) ? '<b>Firma: </b>'.$i['FIR_PER_DIS'].'<br>' : '<b>Firma: </b> -- <br>').
                                        (( $i['PARENTEZCO'] ) ? '<b>Parentesco: </b>'.$i['PARENTEZCO'].'<br>' : '<b>Parentesco: </b> -- <br>').
                                      '</td>'.
                                      '<td>'.$i['OBS_PRMVIS'].'</td>'.
                                      '<td>'.$i['OBS_SEGVIS'].'</td>'.
                                      '<td>'.$i['FECHA'].' '.$i['HORA'].'</td>'.
                                      '<td>'.$i['TIPO_ENTREGA'].'</td>'.
                                      '<td style="text-align:center">'.
                                        (( $i['IMGNOT'] ) ? '<a class="btn btn-xs btn-success" onclick="ver_foto_notificacion(\''.$i['IMGNOT'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                        Foto</a>' : '').
                                        (( $i['IMGOPC'] ) ? '<a class="btn btn-xs btn-warning" onclick="ver_foto_opcional_notificacion(\''.$i['IMGOPC'].'\')"><i class="fa fa-camera" aria-hidden="true"></i>
                                        Foto opcional</a>' : '').
                                        (( $i['Ficha'] ) ? '<a class="btn btn-xs btn-info" onclick="ver_foto_ficha_notificacion(\''.$i['Ficha'].'\')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        Ficha notificacion</a>' : '').
                                        (( $i['FichaPre'] ) ? '<a class="btn btn-xs btn-danger" onclick="ver_foto_ficha_notificacion(\''.$i['FichaPre'].'\')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        Pre notificacion</a>' : '').
                                      '</td>'.
                                    '</tr>';
          }
          foreach($inspeccion_interna as $i){
            $unidadesDeUso  = '';
            if($i['TipoUnidUso'] != '') {
              $idParametro = $this->Cuentas_corrientes_model->get_one_parametro('tipo_unidad_uso');
              $tiposUnidUso = $this->Cuentas_corrientes_model->get_all_detParamFicha($idParametro);
              $tipUniUso = array();
              if(!is_null($i['TipoUnidUso'])){
                $array = explode(",", $i['TipoUnidUso']);
                foreach($tiposUnidUso as $tipoUnidUso){
                  if(in_array($tipoUnidUso['DprId'], $array)){
                    array_push($tipUniUso, $tipoUnidUso['DprDes']);
                  }
                }
              }
              $unidadesDeUso = implode(',', $tipUniUso);
            }
            $foto = "";
            if($i['ImgIno'] != null) {
              $fotos = explode(',', $i['ImgIno']);
              foreach($fotos as $f){
                $foto .= '<a class="btn btn-xs btn-success" onclick="ver_foto_inspeccion(\''.$f.'\')"><i class="fa fa-camera" aria-hidden="true"></i></a>';
              }
            }
            $cuerpo_inspeccion_interna .= '<tr>'.
                                            '<td>'.$i['ORDEN_TRABAJO'].'</td>'.
                                            '<td>'.$i['NumReclamo'].'</td>'.
                                            '<td>'.$i['FechInsp'].'</td>'.
                                            '<td>'.$i['HoraInsp'].'</td>'.
                                            '<td>'.$i['NumHabts'].'</td>'.
                                            '<td>'.$i['NumPisos'].'</td>'.
                                            '<td>'.$unidadesDeUso.'</td>'.
                                            '<td>'.$i['UsoInmueble'].'</td>'.
                                            '<td>'.$i['Lectura'].'m<sup>3</sup></td>'.
                                            '<td>'.$i['Observacion'].'</td>'.
                                            '<td>'.$foto.'</td>'.
                                            '<td>'.(( $i['Ficha'] ) ? '<a class="btn btn-xs btn-info" onclick="ver_foto_ficha_notificacion(\''.$i['Ficha'].'\')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>' : '').'</td>'.
                                          '</tr>';
          }
          foreach($inspeccion_externa as $i){
            $foto = "";
            if($i['ImgIno'] != null) {
              $fotos = explode(',', $i['ImgIno']);
              foreach($fotos as $f){
                $foto .= '<a class="btn btn-xs btn-success" onclick="ver_foto_inspeccion(\''.$f.'\')"><i class="fa fa-camera" aria-hidden="true"></i></a>';
              }
            }
            $cuerpo_inspeccion_externa .= '<tr>'.
                                            '<td>'.$i['ORDEN_TRABAJO'].'</td>'.
                                            '<td>'.$i['NumReclamo'].'</td>'.
                                            '<td>'.$i['FechInsp'].'</td>'.
                                            '<td>'.$i['HoraInsp'].'</td>'.
                                            '<td>'.$i['EstadoMed'].'</td>'.
                                            '<td>'.$i['Lectura'].'m<sup>3</sup></td>'.
                                            '<td>'.$i['Fuga'].'</td>'.
                                            '<td>'.$i['Observacion'].'</td>'.
                                            '<td>'.$foto.'</td>'.
                                            '<td>'.(( $i['Ficha'] ) ? '<a class="btn btn-xs btn-info" onclick="ver_foto_ficha_notificacion(\''.$i['Ficha'].'\')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>' : '').'</td>'.
                                          '</tr>';
          }
          $json =  array(
                    'result' =>  true, 
                    'mensaje' => 'ok', 
                    'lecturas' => $cuerpo_lecturas, 
                    'relecturas' => $cuerpo_relecturas, 
                    'notificacion' => $cuerpo_notificaciones, 
                    'inspeccionInterna' => $cuerpo_inspeccion_interna,
                    'isnpeccionExterna' => $cuerpo_inspeccion_externa
                  );
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json); 
        } else {
          $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json); 
        }

      } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json); 
      }
    } else {
      $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json); 
    }
  } else {
    $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/x-json; charset=utf-8');
    echo json_encode($json); 
  }
}
/** end siac en genesys */

  public function ver_deuda_corte(){
      $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
      if($permiso){
          $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('ACCIONES_EJECUTADAS');
          $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
          if($acceso){
              $ajax = $this->input->get('ajax');
              if($ajax ){
          $suministro = $this->input->post('suministro');
          if(substr($suministro,3,4) == "0000") $suministro = substr($suministro,0,3).substr($suministro,7,4);
                  $ofi = $this->input->post('ofi');
                  $age = $this->input->post('age');
                  $num = $this->input->post('num');
                  $recibos = $this->Cuentas_corrientes_model->get_recibos_x_corte($ofi,$age,$num,$suministro);
                   if($recibos){
                      $contenido = "";
                      $i = 1;
            $saldo = 0;
            $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('VER_DETALLE_RECIBO');
            $detalle = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
                      foreach($recibos as $r){
                          $contenido .= "<tr>".
                                          "<td>".$r['FACSERNRO']."</td>".
                                          "<td>".$r['FACNRO']."</td>".
                                          "<td>".(($r['NW_FECHA'] == null) ? " -- " : $r['NW_FECHA'])."</td>".
                                          "<td style='text-align:right'>".number_format($r['REC_SALDO'],2,'.',' ')."</td>".
                                          "<td style='text-align:center'>";
                          if($r['NW_ST'] == 'P') $contenido .= "PAGADO</td>";
                          else if($r['NW_ST'] == 'R') $contenido .= "REFINACIADO</td>";
                          else if($r['NW_ST'] == 'I') $contenido .= "PENDIENTE</td>";
                          else if($r['NW_ST'] == 'C') $contenido .= "CONVENIO</td>";
                          else if($r['NW_ST'] == 'Q') $contenido .= "QUIEBRE</td>";
                          else if($r['NW_ST'] == 'N') $contenido .= "NOTA CONTABLE</td>"; 
                          $contenido .= "<td style='text-align:center'>".
                                              "<a id='duplicado' onclick='duplicado_recibo(\"".$r['FACSERNRO']."\",\"".$r['FACNRO']."\",\"".$suministro."\")' class='btn btn-warning btn-xs' disabled>".
                                                  "<i class='fa fa-print'></i> &nbsp; DUPLICADO RECIBO".
                        "</a>&nbsp;&nbsp;";
              if($detalle){
                $contenido .= "<a onclick='ver_detalle(\"".$r['FACSERNRO']."\",\"".$r['FACNRO']."\",\"".$suministro."\")' id='detalle' class='btn btn-success btn-xs'>".
                          "<i class='fa fa-plus-square' aria-hidden='true'></i> DETALLE RECIBO".
                        "</a>";
              }
                        $contenido .= "</td>".
                                        "</tr>";
                          $saldo += $r['REC_SALDO']; 
                      }
                      $json =  array('result' =>  true, 'mensaje' => 'OK', 'RECIBOS' => $recibos,'cuerpo' => $contenido,'saldo' => number_format($saldo,2,'.',' '));
                      header('Access-Control-Allow-Origin: *');
                      header('Content-Type: application/x-json; charset=utf-8');
                      echo json_encode($json);
                  } else {
                      $json =  array('result' =>  false, 'mensaje' =>  $this->config->item('_mensaje_vacio'));
                      header('Access-Control-Allow-Origin: *');
                      header('Content-Type: application/x-json; charset=utf-8');
                      echo json_encode($json);
                  }
              } else {
                  $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
                  header('Access-Control-Allow-Origin: *');
                  header('Content-Type: application/x-json; charset=utf-8');
                  echo json_encode($json);
              }
          } else {
              $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
              header('Access-Control-Allow-Origin: *');
              header('Content-Type: application/x-json; charset=utf-8');
              echo json_encode($json); 
          }
      } else {
          $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json); 
      }
      
  }
  public function otros_cortes(){
      $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
      if($permiso){
          $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('ACCIONES_EJECUTADAS');
          $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
          if($acceso){
            $ajax = $this->input->get('ajax');
            if($ajax){
                $suministro = $this->input->post('suministro');
                if(substr($suministro,3,4) == "0000") $suministro = substr($suministro,0,3).substr($suministro,7,4);
                $cortes = $this->Cuentas_corrientes_model->get_otros_cortes($suministro);
                foreach ($cortes as $key => $corte) {
                  $service = $this->Cuentas_corrientes_model->get_service2($corte['TCORTADO_ORDENCOR_OC_OFI'], $corte['TCORTADO_ORDENCOR_OC_AGE'], $corte['TCORTADO_ORDENCOR_ORC_NUM']);
                  $cortes[$key]['service'] = $service;
                }
                if($cortes != NULL){
            $contenido = "";
            foreach ($cortes as $c) {
              $contenido .= "<tr>".
                      "<td>".$c['DONEFECH']."<br />".$c['DONEHORA']."</td>".
                      "<td>".$c['PNIVELCO_NIV_CODI']."</td>". 
                      "<td>".$c['NIV_DETA']."</td>".
                      "<td>".$c['TOBSERVA_OBS_CODI']."</td>".
                      "<td>".$c['OBS_DETA']."</td>".
                      "<td>".$c['TCORTADO_ORDENCOR_OC_OFI']."</td>".
                      "<td>".$c['TCORTADO_ORDENCOR_OC_AGE']."</td>".
                      "<td>".$c['TCORTADO_ORDENCOR_ORC_NUM']."</td>".
                      "<td>".$c['service']."</td>".
                      "</tr>";
            }
            $json =  array('result' =>  true, 'mensaje' => 'OK', 'cortes' => $cortes,'cuerpo' => $contenido);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
                } else {
            $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
                }
            } else {
          $json =  array('result' =>  true, 'mensaje' => $this->config->item('_mensaje_error'));
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
            }
          } else {
        $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json); 
          }
      } else {
      $json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json); 
      }	 
  }
  public function imprimir_cuenta($valor){
    if(substr($valor,3,4) == "0000") $suministro = substr($valor,0,3).substr($valor,7,4);
    else $suministro = $valor;
    //$suministro_real = $valor;
    $user_datos = $this->Cuentas_corrientes_model->get_one_client($valor);
    $cuotas_x_emitir = $this->Cuentas_corrientes_model->get_monto_convenios($suministro);
    $codigo_catastral = $this->Cuentas_corrientes_model->get_codigo_catastral($suministro);
    $medcodigo = $this->Cuentas_corrientes_model->obtener_medcodigo($codigo_catastral);
		$medidor = $this->Cuentas_corrientes_model->obetner_medidor($medcodigo);
    $cuenta_corriente = $this->Cuentas_corrientes_model->cuenta_corriente($suministro);
    if(substr($valor,3,4) == "0000") $datos_usuario = $this->Cuentas_corrientes_model->get_datos_usuarios1(substr($valor,0,3),substr($valor,7,4));
    else $datos_usuario = $this->Cuentas_corrientes_model->get_datos_usuarios($suministro);
    $ciclo = $this->Cuentas_corrientes_model->get_all_data($datos_usuario);
    $desciclo = $this->Cuentas_corrientes_model->get_ciclo($ciclo);
    $recibos_pendientes = $this->Cuentas_corrientes_model->recibos_pendientes($suministro);
    $interes_moratorio = 0;
    foreach ($recibos_pendientes as $key => $recibo) {
        $valor1 = $this->Cuentas_corrientes_model->volumen_leido($recibo['FACSERNRO'],$recibo['FACNRO']);
        $valor2 = $this->Cuentas_corrientes_model->notas_credito_cantidad($recibo['FACSERNRO'],$recibo['FACNRO']);
        $valor4 = $this->Cuentas_corrientes_model->notas_credito1($recibo['FACSERNRO'],$recibo['FACNRO']);
        $valor3 = $this->Cuentas_corrientes_model->notas_debito1($recibo['FACSERNRO'],$recibo['FACNRO']);
        $monto_nc = $this->Cuentas_corrientes_model->monto_nc($recibo['FACSERNRO'],$recibo['FACNRO']);
        if($this->validar_fecha(date('Y-m-d'),substr($recibo['FACVENFEC'],6,4).'-'.substr($recibo['FACVENFEC'],3,2)."-".substr($recibo['FACVENFEC'],0,2)) < 0  && $recibo['FACTOTAL'] != $monto_nc){
            $fechaaxu = $this->sumar_fecha(substr($recibo['FACVENFEC'],6,4).'-'.substr($recibo['FACVENFEC'],3,2).'-'.substr($recibo['FACVENFEC'],0,2));
            $tamdia = $this->Cuentas_corrientes_model->tasa(substr($fechaaxu,8,2)."/".substr($fechaaxu,5,2)."/".substr($fechaaxu,0,4));
            $interes_moratorio += floatval($recibo['FACTOTAL'])*floatval($tamdia['TAMACU']);
        }
        $recibos_pendientes[$key]['volumen'] = $valor1;
        $recibos_pendientes[$key]['nota_credito'] = $valor2;
        $recibos_pendientes[$key]['notas_creditos'] = $valor4;
        $recibos_pendientes[$key]['notas_debitos'] = $valor3;
        $recibos_pendientes[$key]['monto_nc'] = $monto_nc;
    }
    $this->load->library('ciqrcode');
    $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
    $params['level'] = 'H';
    $params['size'] = 1;
    $params['savename'] = FCPATH.'tes.png';
    $this->ciqrcode->generate($params);
    $this->load->library('pdf');
    $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);
    $mpdf->SetHTMLHeader('<table width="100%" style="font-size:13px;font-family:Arial">'.
                       '<tr>'.
                        '<td style="text-align:center;font-weight:bold">EMPRESA DE SERVICIO DE AGUA POTABLE Y ALCANTARILLADO DE LA LIBERTAD S.A.</td>'.
                        '</tr></table>');
    $mpdf->SetHTMLFooter('<table width="100%" style="font-size:13px;font-family:Arial">'.
                          '<tr>'.
                          '<td></td>'.
                          '<td>Impreso por: '.$_SESSION['user_nom'].'</td>'.
                          '<td>Impreso el día:  '.date('d-m-Y H:i:s').'</td>'.
                          '</tr></table>');
    #cabecera
    $html = "<table width='100%' style='font-weight:bold;font-size:11px;font-family:Arial'>".
                "<tr>".
                    "<td style='width:35%'>SEDALIB S.A. R.U.C.: &nbsp; 20131911310</td>".
                    "<td style='width:35%'>OFICINA: &nbsp; ".$_SESSION['OFICINA']."</td>".
                    "<td style='text-align:right;width:13%'>Medidor: </td>".
                    "<td style='text-align:left'>".$medidor."</td>".
                "</tr>".
                "<tr>".
                    "<td colspan='2' rowspan='2' style='font-size:14px !important;text-align:center'>CUENTA CORRIENTE Nº ".$suministro."</td>".
                    "<td style='text-align:right'>Cod. Cat.:</td>";
    if($codigo_catastral == NULL ) $html .= "<td style='text-align:left'>0-0-0-0-0-0-0</td>";
    else  $html .= "<td style='text-align:left'>".
                    $codigo_catastral['PREREGION']."-".
                    $codigo_catastral['PREZONA']."-".
                    $codigo_catastral['PRESECTOR']."-".
                    $codigo_catastral['PREMZN']."-".
                    $codigo_catastral['PRELOTE']."-".
                    $codigo_catastral['CLICODID']."-".
                    $codigo_catastral['CLICODIGO']."</td>";

    $html .= "</tr>".
             "<tr>".
                "<td style='text-align:right'>Gru/SubGru:</td>";
    if(strlen($cuenta_corriente['CLICODFAC']) == 7) $html .= "<td style='text-align:left'>&nbsp;&nbsp;0&nbsp;&nbsp;&nbsp;&nbsp;0&nbsp;&nbsp;&nbsp;</td>";
    else $html .= "<td style='text-align:left'>".$cuenta_corriente['CODGRUPO']."</td>";
    $html .=   "</tr>".
         "</table>";
    $html .= '<table width="100%" style="font-size:11px;font-weight:bold;font-family:Arial">'.
           '<tr>'.
            '<td style="width:9%;">Cliente</td>'.
            '<td style="width:1%;">:</td>'.
            '<td style="width:35%;">'.$user_datos['CLINOMBRE'].'</td>'.
            '<td style="width:10%;"></td>'.
            '<td style="width:12%;"></td>'.
            '<td style="width:12%;text-align:right">Ciclo: </td>'.
            '<td>'.$ciclo.' '.$desciclo['FACCICDES'].'</td>'.
           '</tr>'.
           '<tr>'.
            '<td>Dirección</td>'.
            '<td style="width:1%;">:</td>'.
            '<td colspan="3" >'.$user_datos['CALDES'].' '.$user_datos['CLIMUNNRO'].' '.$user_datos['URBDES'].'</td>'.
            '<td style="text-align:right">F. Emisión: </td>'.
            '<td>'.date('d/m/Y').'</td>'.
           '</tr>'.
           '<tr>'.
            '<td>Electoral</td>'.
            '<td style="width:1%;">:</td>'.
            '<td> '.$user_datos['CLIELECT'].' R.U.C.: '.$user_datos['CLIRUC'].'</td>'.
            '<td>Telefono: </td>'.
            '<td></td>'.
            '<td style="text-align:right">Nº Contrato: </td>'.
            '<td>'.$user_datos['CONTRA'].'</td>'.
           '</tr>'.
           '<tr>'.
            '<td></td>'.
            '<td></td>'.
            '<td></td>'.
            '<td></td>'.
            '<td></td>'.
            '<td></td>'.
            '<td></td>'.
           '</tr>'.
           '</table>';
    $html .= '<hr style="height:2px; border:none; background:#000">';
    $html .= '<table style="width:100%;font-size:10px;font-weight:bold;font-family:Arial" cellpadding = "0" cellspacing = "0">'.
          '<tr>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Fecha</td>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Serie</td>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Num.Doc.</td>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Documento</td>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Cargo</td>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Abono</td>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Cuota Terceros</td>'.
            '<td style="border:1px solid;border-top:0;border-right:0;border-left:1px solid #FFF;text-align:center">Total</td>'.
          '<tr>';
    $sum_recibo = 0;
    $sum_recibo2 = 0;
    $cargos = 0;
    $abonos  = 0;
    $terceros = 0;
    $suma_notaC = 0;
    $suma_notaD = 0;
    $cant_recibos = sizeof($recibos_pendientes);
    foreach ($recibos_pendientes as $recibo) {
        if(floatval($recibo['FACTOTAL']) != floatval($recibo['monto_nc'])) {
            $html .= '<tr>'.
                        '<td style="width:11%;">'.$recibo['FACEMIFEC'].'</td>'.
                        '<td style="width:5%;text-align:right">'.$recibo['FACSERNRO'].' </td>'.
                        '<td style="width:8%;text-align:right">'.$recibo['FACNRO'].'</td>'.
                        '<td style="width:34%">&nbsp;&nbsp;RECIBO '.$recibo['volumen'].'m<sup>3</sup> '.(($recibo['nota_credito'] > 0) ? 'NC = '.$recibo['nota_credito'].' ' : '').$recibo['FACTARIFA'].' FV: '.$recibo['FACVENFEC'].'</td>'.
                        '<td style="width:10.5%;text-align:right">'.number_format(floatval($recibo['FACTOTAL']), 2, '.', '').'</td>'.
                        '<td style="width:10.5%;text-align:right">0.00</td>'.
                        '<td style="width:10.5%;text-align:right">0.00</td>'.
                        '<td style="width:10.5%;text-align:right">'.number_format(floatval($recibo['FACTOTAL']), 2, '.', '').'</td>'.
                    '</tr>';

            if($recibo['notas_creditos'] != NULL){
                foreach ($recibo['notas_creditos'] as $nota) {
                    $html .= '<tr>'.
                                '<td style="width:11%">'.$nota['NCAFECHA'].'</td>'.
                                '<td style="width:5%;text-align:right">'.$nota['NCASERNRO'].' </td>'.
                                '<td style="width:8%;text-align:right">'.$nota['NCANRO'].'</td>'.
                                '<td style="width:34%">&nbsp;&nbsp;NOTA DE CRÉDITO. Recibo: '.$nota['TOTFAC_FACSERNRO'].'-'.$nota['TOTFAC_FACNRO'].'</td>'.
                                '<td style="width:10.5%;text-align:right">0.00</td>'.
                                '<td style="width:10.5%;text-align:right">'.number_format(floatval($nota['NCATOTDIF']),2,'.','').'</td>'.
                                '<td style="width:10.5%;text-align:right">0.00</td>'.
                                '<td style="width:10.5%;text-align:right">0.00</td>'.
                            '</tr>';
                            $suma_notaC += floatval($nota["NCATOTDIF"]);
                }
            }
            if($recibo['notas_debitos'] != NULL){
                foreach ($recibo['notas_debitos'] as $nota) {
                    $html .= '<tr>'.
                            '<td style="width:11%">'.$nota['NCAFECHA'].'</td>'.
                            '<td style="width:5%;text-align:right">'.$nota['NCASERNRO'].' </td>'.
                            '<td style="width:8%;text-align:right">'.$nota['NCANRO'].'</td>'.
                            '<td style="width:34%">&nbsp;&nbsp;NOTA DE DÉBITO. Recibo: '.$nota['TOTFAC_FACSERNRO'].'-'.$nota['TOTFAC_FACNRO'].'</td>'.
                            '<td style="width:10.5%;text-align:right">'.number_format(floatval($nota['NCATOTDIF']),2,'.','').'</td>'.
                            '<td style="width:10.5%;text-align:right">0.00</td>'.
                            '<td style="width:10.5%;text-align:right">0.00</td>'.
                            '<td style="width:10.5%;text-align:right">'.number_format(floatval($nota['NCATOTDIF']),2,'.','').'</td>'.
                        '</tr>';
                        $suma_notaD += floatval($nota["NCATOTDIF"]);
                }
            }
            if($this->dateDiff(date('Y-m-d'),substr($recibo['FACVENFEC'],6,4).'-'.substr($recibo['FACVENFEC'],3,2)."-".substr($recibo['FACVENFEC'],0,2)) < 0) $sum_recibo += floatval($recibo['FACTOTAL']);
            else $sum_recibo2 += floatval($recibo['FACTOTAL']);$i++; 
        }
      #$sum_recibo += floatval($recibo['FACTOTAL']);
    }

    $deuda_real = $suma_notaD + $sum_recibo - $suma_notaC;
    $moratorio = $deuda_real*0.10;
    $cargo += $moratorio;
    if($sum_recibo > 0) {
      $html .= '<tr>'.
                '<td>'. date('d/m/Y').'</td>'.
                '<td style="text-align:right"> 0 </td>'.
                '<td style="text-align:right">900</td>'.
                '<td>&nbsp;&nbsp;INTERESES MORATORIOS</td>'.
                '<td style="text-align:right">'.number_format($interes_moratorio,2,'.','').'</td>'.
                '<td style="text-align:right">0.00</td>'.
                '<td style="text-align:right">0.00</td>'.
                '<td style="text-align:right">'.number_format($interes_moratorio,2,'.','').'</td>'.
              '</tr>';
      $html .= '<tr>'.
                  '<td>'.date('d/m/Y').'</td>'.
                  '<td style="text-align:right"> 0 </td>'.
                  '<td style="text-align:right"> 902 </td>'.
                  '<td> &nbsp;&nbsp;GASTOS DE COBRANZA</td>'.
                  '<td  style="text-align:right">'.number_format( $moratorio, 2, '.', '').'</td>'.
                  '<td  style="text-align:right">0.00</td>'.
                  '<td  style="text-align:right">0.00</td>'.
                  '<td  style="text-align:right">'.number_format( $moratorio, 2, '.', '').'</td>'.
                '</tr>';
      $html .= '<tr>'.
                  '<td>'.date('d/m/Y').'</td>'.
                  '<td style="text-align:right"> 0</td>'.
                  '<td style="text-align:right"> 903</td>'.
                  '<td> &nbsp;&nbsp;IGV GASTOS DE COBRANZA</td>'.
                  '<td  style="text-align:right">'.number_format(($moratorio*0.18), 2, '.', '').'</td>'.
                  '<td  style="text-align:right">0.00</td>'.
                  '<td  style="text-align:right">0.00</td>'.
                  '<td  style="text-align:right">'.number_format(($moratorio*0.18), 2, '.', '').'</td>'.
                '</tr>';
      $interes1 = number_format(($moratorio*0.18),2,'.','');
      $deuda_total += $deuda_real + $interes_moratorio + $moratorio + $interes1 + $sum_recibo2;

    }
    $deuda1 = $suma_notaD + $sum_recibo + $sum_recibo2;
    if($sum_recibo > 0){
      $interes = number_format(($moratorio*0.18),2,'.','');
      $deuda1 += $interes_moratorio + $moratorio + floatval($interes);
    }
    $html .= '<tr>'.
                '<td ></td>'.
                '<td ></td>'.
                '<td ></td>'.
                '<td ></td>'.
                '<td  style="text-align:right;border-top:1px solid">'.number_format(($deuda1), 2, '.', '').'</td>'.
                '<td  style="text-align:right;border-top:1px solid">'.number_format($suma_notaC,2,'.','').'</td>'.
                '<td  style="text-align:right;border-top:1px solid">0.00</td>'.
                '<td  style="text-align:right;border-top:1px solid">'.number_format(($deuda1), 2, '.', '').'</td>'.
              '</tr>';
    $html .= '</table>';
    $html .= '<hr style="height:3px;background:#000; border:none">';
    $html .= '<table width="100%" style="font-family:Arial">'.
            '<tr>'.
              '<td style="font-size:10px !important">'.$cant_recibos.' MES(ES) DE DEUDA</td>'.
            '<td></td>'.
            '<td style="text-align:right;font-size:12px !important;border-bottom:1px solid;border-right:1px solid #FFF">CUOTAS DE CREDITOS POR EMITIR: </td>'.
            '<td style="text-align:right;font-size:12px !important;border-bottom:1px solid;border-right:1px solid #FFF">'.number_format(floatval($cuotas_x_emitir['TOTAL']),2,'.','').'</td>'.
          '</tr>'.
          '<tr>'.
            '<td style="font-size:10px !important">TOTAL DE DEUDA CAPITAL</td>'.
            '<td style="text-align:left;font-size:10px !important;">'.number_format($deuda_real + $sum_recibo2 ,2,'.','').'</td>'.
            '<td style="text-align:right;font-size:12px !important;">TOTAL DE LA DEUDA SEDALIB: </td>'.
            '<td style="font-size:12px !important;text-align:right">'.number_format(floatval($deuda_total + floatval($cuotas_x_emitir['TOTAL']) ),2,'.','').'</td>'.
          '</tr>'.
          '<tr>'.
            '<td></td>'.
            '<td></td>'.
            '<td style="text-align:right;font-size:12px !important">TOTAL DEUDA POR ENCARGO DE TERCEROS: </td>'.
            '<td style="font-size:12px !important;text-align:right">0.00</td>'.
          '</tr>'.
          '<tr>'.
            '<td></td>'.
            '<td></td>'.
            '<td style="text-align:right;font-size:12px !important">TOTAL GENERAL: </td>'.
            '<td style="font-size:12px !important;text-align:right">'.number_format(floatval($deuda_total + floatval($cuotas_x_emitir['TOTAL'])),2,'.','').'</td>'.
          '</tr>'.
         '</table>';
   $mpdf->WriteHTML($html);
   $content = $mpdf->Output('', 'S');
   $content = chunk_split(base64_encode($content));
   $mpdf->Output();
   exit;

}
  
public function duplicado_recibo_antiguo($suministro,$periodo,$serie,$numero){
  $cabecera = $this->Cuentas_corrientes_model->get_duplicado_recibo($serie,$numero,$suministro);
  $datos["PREREGION"] = $cabecera['PREREGIOX'];
  $datos["PREZONA"] = $cabecera['PREZONX'];
  $datos["PRESECTOR"] = $cabecera['PRESECTOX'];
  $datos["PREMZN"] = $cabecera['PREMZN'];
  $datos["PRELOTE"] = $cabecera['PRELOTE'];
  $volumen = $this->Cuentas_corrientes_model->volumen_leido($serie,$numero);
  $ciclo = $this->Cuentas_corrientes_model->get_all_data($datos);
  $faclin = $this->Cuentas_corrientes_model->get_duplicado_recibo_faclin($serie,$numero);
  $letfac = $this->Cuentas_corrientes_model->get_duplicado_recibo_letfac($serie,$numero);
  if(strlen($suministro) == 7)  $cliente = $this->Cuentas_corrientes_model->get_one_client(substr($suministro,0,3)."0000".substr($suministro,3,7));
  else $cliente = $this->Cuentas_corrientes_model->get_one_client($suministro);
  $lecturas = $this->Cuentas_corrientes_model->get_lecturas($suministro,$periodo);
  $this->load->library('pdf1');
  $mpdf = $this->pdf1->load("utf-8", "A4", 0, "", 4, 4, 3, 3, 0, 0,"L");
  $mpdf->AddPage('L');
  $html = "<table width='100%' style='font-family:Arial;'>".
            "<tr>".
              "<td style='width:50%'></td>".
              "<td style='width:50%'>".
                "<table width='100%' style='font-size:12px'>".
                  "<tr>".
                    "<td width='33%'>Cod. Cat.: ".$cabecera['PREREGIOX']."-".$cabecera['PREZONX']."-".$cabecera['PRESECTOX']."-".$cabecera['PREMZN']."-".$cabecera['PRELOTE']."-".$cabecera['CLICODID']."-".$cabecera['CLICODIGO']."</td>".
                    "<td width='30%'>CICLO: ".$ciclo."</td>".
                    "<td>Recibo N°: ".$cabecera['FACSERNRO']."-".$cabecera['FACNRO']."-".$cabecera['FACCHEDIG']."</td>".
                  "</tr>".
                  "<tr>".
                    "<td></td>".
                    "<td>Código: ".$suministro."</td>".
                    "<td></td>".
                  "</tr>".
                  "<tr>".
                    "<td></td>".
                    "<td></td>".
                    "<td>Mes de Facturación: ".$this->devolver_mes(substr($cabecera['FACVENFEC'],3,2))."</td>".
                  "</tr>".
                  "<tr>".
                    "<td></td>".
                    "<td></td>".
                    "<td>Fecha de Emisión: ".$cabecera['FACEMIFEC']."</td>".
                  "</tr>".
                "</table>".  
                "<span style='font-size:12px'>Cliente: <b>".$cliente['CLINOMBRE']."</b></span><br>".
                "<span style='font-size:12px'>Domicilio: <b>".$cliente['URBDES']." ".$cliente['CALDES']."</b></span><br>".
                "<span style='font-size:12px'>R.U.C. / D.N.I. : <b>".(($cliente['CLIELECT'] != null) ? $cliente['CLIELECT'] : $cliente['CLIRUC'])."</b></span></br>".
                "<table style='font-size:12px'>".
                  "<tr>".
                    "<td>MEDIDOR: </td>".
                    "<td>".$cabecera['FMEDIDOR']."</td>".
                    "<td>TARIFA: </td>".
                    "<td>".$cabecera['FACTARIFA']."</td>".
                    "<td>T/S: </td>".
                    "<td>".$cabecera['FSETIPCOD']."</td>".
                    "<td></td>".
                  "</tr>".
                  "<tr>".
                    "<td>LECTURA ACTUAL: </td>".
                    "<td>".$lecturas['LECTURA']."</td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                  "</tr>".
                  "<tr>".
                    "<td>LECTURA ANTERIOR: </td>".
                    "<td>".$lecturas['LECANT']."</td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                  "</tr>".
                  "<tr>".
                    "<td>CONSUMO M3: </td>".
                    "<td>".$volumen." m<sup>3</sup></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                  "</tr>".
                "</table><br><table cellpading='0' style='font-size:12px'>";
                for($i = 0; $i< sizeof($faclin); $i++) {
                  $html .= "<tr>". 
                            "<td width='5%'>".$faclin[$i]['FACLINRO']."</td>".
                            "<td width='70%'>".$faclin[$i]['CONCEP_FACCONCOD']." ".$faclin[$i]['FACCONDES']."</td>".
                            "<td></td>".
                            "<td width='12%' style='text-align:right'>".number_format($faclin[$i]['FACPRECI'],2,'.',' ')."</td>".
                          "</tr>";
                } 
                for($i = 0; $i< sizeof($letfac); $i++) {
                  $html .= "<tr>". 
                            "<td>".$letfac[$i]['FACCUOLIN']."</td>".
                            "<td>".$letfac[$i]['CONCEP_FACCONCOD']." ".$letfac[$i]['FACCONDES']." ".$letfac[$i]['LTNUM']."/".$letfac[$i]['CRECUONRO']." [".$letfac[$i]['CREDNRO']."]</td>".
                            "<td></td>".
                            "<td style='text-align:right'>".number_format($letfac[$i]['CRECUOMON'],2,'.',' ')."</td>".
                          "</tr>";
                } 
                $tam = sizeof($faclin) + sizeof($letfac);
                if($tam < 12) {
                  for($i = $tam; $i< 13; $i++) {
                    $html .= "<tr>". 
                              "<td style='color: rgba(255,255,255,0)'></td>".
                              "<td style='color: rgba(255,255,255,0)'>dfgdf</td>".
                              "<td></td>".
                              "<td style='color: rgba(255,255,255,0)'>4545</td>".
                            "</tr>";
                  } 
                }
                $html .= "<tr>". 
                          "<td></td>".
                          "<td></td>".
                          "<td><b>SUBTOTAL: </b></td>".
                          "<td style='text-align:right;font-size:14px'>".number_format($cabecera['FACTOTSUB'],2,'.',' ')."</td>".
                        "</tr>".
                        "<tr>". 
                          "<td></td>".
                          "<td></td>".
                          "<td><b>I.G.V.: </b></td>".
                          "<td style='text-align:right;font-size:14px'>".number_format($cabecera['FACIGV'],2,'.',' ')."</td>".
                        "</tr>".
                        "<tr>". 
                          "<td></td>".
                          "<td></td>".
                          "<td><b>TOTAL: </b></td>".
                          "<td style='text-align:right;font-size:14px'>".number_format($cabecera['FACTOTAL'],2,'.',' ')."</td>".
                        "</tr>";
                $html .= "</table>".   
                "<span>SEGUNDO ORIGINAL</span>".    
                "<table width='100%'>".
                  "<tr>".
                    "<td>SEGUNDO ORIGINAL</td>".
                    "<td>Recibo N°: ".$cabecera['FACSERNRO']."-".$cabecera['FACNRO']."-".$cabecera['FACCHEDIG']."</td>".
                  "</tr>".
                  "<tr>".
                    "<td>CLIENTE:  ".$cliente['CLINOMBRE']."</td>".
                    "<td></td>".
                  "</tr>".
                  "<tr>".
                    "<td></td>".
                    "<td>COD: ".$suministro."  </td>".
                  "</tr>".
                "</table><br/><br/>".
                "<table width='100%'>".
                  "<tr>".
                    "<td>CICLO: ".$ciclo."</td>".
                    "<td></td>".
                    "<td></td>".
                    "<td style='font-size:12px' width='30%'>Mes Facturación: </td>".
                    "<td><b>".$this->devolver_mes(substr($cabecera['FACVENFEC'],3,2))."</b></td>". 
                  "</tr>".
                  "<tr>".
                    "<td>Cód. Cat.: ".$cabecera['PREREGIOX']."-".$cabecera['PREZONX']."-".$cabecera['PRESECTOX']."-".$cabecera['PREMZN']."-".$cabecera['PRELOTE']."-".$cabecera['CLICODID']."-".$cabecera['CLICODIGO']."</td>".
                    "<td></td>".
                    "<td></td>".
                    "<td style='font-size:12px'>Fecha de Emisión: </td>".
                    "<td><b>".$cabecera['FACEMIFEC']."</b></td>". 
                  "</tr>". 
                  "<tr>".
                    "<td></td>".
                    "<td></td>".
                    "<td style='font-size:16px;text-align:center !important' width='15%'><b>".number_format($cabecera['FACTOTAL'],2,'.',' ')."</b></td>".
                    "<td style='font-size:12px'>Fecha de Vencimiento:</td>".
                    "<td><b>".$cabecera['FACVENFEC']."</b></td>". 
                  "</tr>". 
                  "<tr>".
                    "<td colspan='2'></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>". 
                  "</tr>".
                  "<tr>".
                    "<td></td>".
                    "<td></td>".
                    "<td></td>".
                    "<td>Total: </td>".
                    "<td style='font-size:16px'><b>".number_format($cabecera['FACTOTAL'],2,'.',' ')."</b>  </td>". 
                  "</tr>". 
                "</table>". 
              "</td>".
            "</tr>".
          "</table>";
      
  $mpdf->WriteHTML($html);
  $content = $mpdf->Output('', 'S');
  $content = chunk_split(base64_encode($content));
  $mpdf->Output();
  exit;
}
	
public function obtener_recibo_duplciado(){
	$permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
	if($permiso){
		  $opcion = $this->Cuentas_corrientes_model->get_opcion_individual('INFORMACION_CAMPO');
		  $acceso = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
		  if($acceso){
			$ajax = $this->input->get('ajax');
			if($ajax){
				$suministro = $this->input->post('suministro');
				if(substr($suministro,3,4) == '0000'){
					$suministro = substr($suministro,0,3).substr($suministro,7,4);
				}
				$periodo = $this->input->post('periodo');
				$fecha1 = "01/".substr($periodo,5,2)."/".substr($periodo,0,4);
				$fecha2 = $this->obtenerUltimoDiaMes($periodo);#."/".substr($periodo,5,2)."/".substr($periodo,0,4);
				$fecha2 = substr($fecha2, 8,2)."/".substr($fecha2,5,2)."/".substr($fecha2,0,4);
				$recibo = $this->Cuentas_corrientes_model->getReciboPorFecha($suministro, $fecha1, $fecha2);
				if($recibo){
					$opcion1 = $this->Cuentas_corrientes_model->get_opcion_individual('DUPLICADO_DE_RECIBO');
					$imprimir_duplicado = $this->Cuentas_corrientes_model->ver_opcion($this->data['rol'],$opcion1,$this->data['id_actividad']); 
					$volumen = $this->Cuentas_corrientes_model->volumen_leido($recibo['FACSERNRO'],$recibo['FACNRO']);
					$proceso = $this->Cuentas_corrientes_model->get_periodo_duplicado2($recibo['FACSERNRO'],$recibo['FACNRO']);
					$proceso_facturacion = $this->Cuentas_corrientes_model->obetner_periodo1($suministro,$recibo['FACSERNRO'],$recibo['FACNRO']);
					$cuerpo = 	'<tr>'.
									'<td class="text-right">'.$recibo['FACSERNRO'].' - '.$recibo['FACNRO'].'</td>'.
									'<td class="text-right">'.$volumen.'m<sup>3</sup></td>'.
									'<td class="text-right">'.$recibo['FACEMIFEC'].'</td>'.
									'<td class="text-right">'.$recibo['FACVENFEC'].'</td>'.
									'<td class="text-right">'.number_format($recibo['FACTOTAL'],2,'.',' ').'</td><td class="text-center">';
					if($recibo['FACESTADO'] == 'C') { 
						$cuerpo .= "<span class='label bg-info text-black' style='font-weight:100 !important;'>". $recibo['FACESTADO'] ." - Convenio</span>"; 
					} elseif($recibo['FACESTADO'] == 'P'){  
						$cuerpo .=  "<span class='label bg-success text-black' style='font-weight:100 !important;'>".$recibo['FACESTADO']." - Pagado</span>";
					} else if($recibo['FACESTADO'] == 'I') {
						$cuerpo .= "<span class='label bg-primary text-white' style='font-weight:100 !important;'>".$recibo['FACESTADO']." - Pendinte</span>" ; 
					} else { 
						$cuerpo .= "<span class='label bg-warning text-black' style='font-weight:100 !important;'>".$recibo['FACESTADO']." - Refinanciado</span>"; 
					}
					
					$cuerpo .= '</td><td>'.
									"<div class='btn-group' role='group'>".
											"<button type='button'".
												"class='btn btn- btn-xs dropdown-toggle'".
												"style='padding:1px 6px; background: #00a65a;color: #FFF;'".
												"data-toggle='dropdown'".
												"aria-haspopup='true'".
												"aria-expanded='false'>".
												"<span class='caret'></span>".
												"Opciones".
											"</button>".
											'<ul class="dropdown-menu" style="border: 1px solid #00a65a ;top: -150%; left: -120%;margin-left:-80px">';
					if($imprimir_duplicado){
						if($proceso_facturacion){
							$cuerpo .= 	'<li>'.
											'<a  style="font-size:12px;color: #00a65a ;font-weight: bold; padding: 3px 10px;cursor:pointer" onclick="window.open(\''.$this->config->item('ip').'facturacion/creo_recibo_a4/'.$suministro.'/'.$proceso_facturacion.'\')">'.
												'<i class="fa fa-file-text" aria-hidden="true"></i> Duplicado recibo A4'.
											'</a>'.
										'</li>'.
										'<li>'.
											'<a  style="font-size:12px;color: #00a65a ;font-weight: bold; padding: 3px 10px;cursor:pointer" onclick="window.open(\''.$this->config->item('ip').'facturacion/creo_recibo/'.$suministro.'/'.$proceso_facturacion.'\')" >'.
												'<i class="fa fa-file-text" aria-hidden="true"></i> Duplicado recibo A5'.
											'</a>'.
										'</li>';
						} elseif($proceso){
							$cuerpo .= 	'<li>'.
											'<a target="_blank" style="font-size:12px;color: #00a65a ;font-weight: bold; padding: 3px 10px;cursor:pointer" href="'.$this->config->item('ip').'cuenta_corriente/duplicado2/'. $suministro.'/'.$proceso.'/'.$recibo['FACSERNRO'].'/'.$recibo['FACNRO'].'" >'.
												'<i class="fa fa-file-text" aria-hidden="true"></i> Duplicado antiguo'.
											'</a>'.
										'</li>';
						}
					}
					$cuerpo .= '</td>'.
								'</tr>';
					$json =  array('result' =>  true, 'mensaje' => 'ok', 'recibo' => $cuerpo);
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json); 
				} else {
					$json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_vacio'));
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json); 
				}
			} else {
				$json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/x-json; charset=utf-8');
				echo json_encode($json); 
			}
		} else {
			$json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/x-json; charset=utf-8');
			echo json_encode($json); 
		}
	} else {
		$json =  array('result' =>  false, 'mensaje' => $this->config->item('_mensaje_error'));
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($json); 
	}
}
    
private function obtenerUltimoDiaMes($month){
  $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
  $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
  return $last_day;
}
    
    
  
 public function generar_nota_credito($suministro,$serie,$numero){ //# función para visualizar la pantalla de generación de la nota de crédito
    $this->data['serie_usuario'] = $this->Cuentas_corrientes_model->get_serie_nc($_SESSION['OFICOD'],$_SESSION['OFIAGECOD']);
    $this->data['user_datos'] = $this->Cuentas_corrientes_model->get_one_client($suministro);
    $this->data['key'] = $this->encriptar($suministro);
    if(!$this->data['user_datos']){
      $suministro1 = substr($suministro,0,3)."0000".substr($suministro,3,4);
      $this->data['key'] = $this->encriptar($suministro1);
      $this->data['user_datos'] = $this->Cuentas_corrientes_model->get_one_client($suministro1);
    }
    $this->data['serie'] =  $serie;
    $this->data['numero'] = $numero;
    $this->data['MONTO'] = $this->Cuentas_corrientes_model->get_total_recibo($serie,$numero);
    $this->data['volumen'] = $this->Cuentas_corrientes_model->volumen_leido($serie,$numero);
    $notas = $this->Nota_Credito_model->get_notas_credito2($serie,$numero);
    $nca1 = array();
    $nca2 =  array();
    foreach ($notas as $key => $nota) {
      $nca_1 = $this->Cuentas_corrientes_model->get_nca_1($suministro,$nota['NCASERNRO'],$nota['NCANRO']);
      $nca_2 = $this->Cuentas_corrientes_model->get_nca_2($suministro,$nota['NCASERNRO'],$nota['NCANRO']);
      $notas[$key]['nca1'] = $nca_1;
      $notas[$key]['nca2'] = $nca_2;
    }
    $conceptos = array();
    $this->data['tipo'] = 0;
    if($notas){
      $fecha = Date('m');
      if(substr($notas[0]['NCAFECHA'],3,2) == $fecha  && $notas[0]['NCAFACESTA'] == 'I') $this->data['tipo'] = 2;
      else $this->data['tipo'] = 1;
    }
    foreach ($notas as $nc) {
      array_push($nca1,$this->Cuentas_corrientes_model->get_nca_1($suministro,$nc['NCASERNRO'],$nc['NCANRO']));
      array_push($nca2,$this->Cuentas_corrientes_model->get_nca_2($suministro,$nc['NCASERNRO'],$nc['NCANRO']));
    }
    $tam = $this->Cuentas_corrientes_model->get_num_faclin($serie,$numero);
    $tam1 = $this->Cuentas_corrientes_model->get_num_letfac($serie,$numero);
    $conceptos = array();
    for($j = 0; $j < $tam+$tam1; $j++){ array_push($conceptos,0); }
    if($this->data['tipo'] == 1){
      foreach ($nca1 as $nc ) {
        for ($i=0; $i < $tam ; $i++) { 
          $conceptos[$i] += floatval($nc[$i]['NCAPREDIF']); 
        }
      }
      $k = $tam;
      foreach ($nca2 as $nc ) {
        if(sizeof($nc) > 0){
          $j = $k;
          for ($i=0; $i < $tam1  ; $i++) { 
            $conceptos[$j] += floatval($nc[$i]['NCACREFUEN']); 
            $j++;
          }
        }
      }
    } else if($this->data['tipo'] == 2 && sizeof($notas) > 1){
      $z = 0;
      foreach ($nca1 as $nc ) {
        if($z == 0){

        } else {
        for ($i=0; $i < $tam ; $i++) { 
            $conceptos[$i] += floatval($nc[$i]['NCAPREDIF']); 
          }
        }
        $z++;
      }
      $k = $tam; $p = 0;
      foreach ($nca2 as $nc ) {
        if(sizeof($nc) > 0){  
          if($p == 0){

          } else {
            $j = $k;
            for ($i=0; $i < $tam1  ; $i++) { 
              $conceptos[$j] += floatval($nc[$i]['NCACREFUEN']); 
              $j++;
            }
          }
          $p++;
        }
      }
    }
    $this->data['conceptos'] = $conceptos;
    $this->data['nca1'] = $nca1;
    $this->data['nca2'] = $nca2;
    $this->data['notas_credito'] = $notas;
    $faclin = $this->Cuentas_corrientes_model->get_faclin($serie,$numero);
    $lecfac = $this->Cuentas_corrientes_model->get_letfac($serie,$numero);
    if($this->data['tipo'] == 1 || ($this->data['tipo'] == 2 && sizeof($notas)>1)){
      $k = 0;
      foreach ($faclin as $key=>$fac) {
        $valor = floatval($fac['FACPRECI'] ) - $conceptos[$k];
        $faclin[$key]['FACPRECI'] = $valor;
        $k++;
      }
      #$k--;
      foreach($lecfac as $key=>$lec){
        $valor1 = floatval($lec['CRECUOMON']) - $conceptos[$k];
        $lecfac[$key]['CRECUOMON'] = $valor1;
        $k++;
      }
    }
    $reclamo = $this->Cuentas_corrientes_model->reclamos($serie,$numero);
    if($reclamo) $this->data['reclamo'] = 'REC. '.$reclamo['SERNRO']."-".$reclamo['RECID'];
    $this->data['faclin'] = $faclin;
    $this->data['letfac'] = $lecfac;
    $this->data['igv'] = $this->Nota_Credito_model->get_igv();
    $this->data['recibo'] = $this->Cuentas_corrientes_model->get_recibo($serie,$numero);
    $this->data['view'] = 'cuenta_corriente/NotaCredito_view';
    $this->data['title'] = 'GENERAR NOTA CRÉDITO - '.$suministro;
    $this->load->view('cuenta_corriente/Template', $this->data);
  }
  public function anular_recibo(){ #funcion para anular completamente el recibo
    $ajax = $this->input->get('ajax');
    if($ajax){
      $suministro = $this->input->post('suministro');
      $serie_recibo = $this->input->post('serie');
      $numero_recibo = $this->input->post('numero');
      $referencia = $this->input->post('referencia');
      $serie_usuario = $this->input->post('serie_user');
      $tipo = $this->input->post('tipo');
      $serie_nc = $this->input->post('serie_nc');
      $numero_nc = $this->input->post('numero_nc');
      if($tipo == 1) $resp = $this->Cuentas_corrientes_model->anular_total_recibo($suministro,$serie_recibo,$numero_recibo,$referencia,$serie_usuario);
      else if($tipo == 2) $resp = $this->Cuentas_corrientes_model->anular_total_recibo2($suministro,$serie_recibo,$numero_recibo,$referencia,$serie_usuario,$serie_nc,$numero_nc);
      else if($tipo == 0) $resp = $this->Cuentas_corrientes_model->anular_total_recibo($suministro,$serie_recibo,$numero_recibo,$referencia,$serie_usuario);
      if($resp){
        if(substr($suministro, 3,4) == "0000") $key = $this->encriptar(substr($suministro, 0,3).substr($suministro, 7,4));
        else $key = $this->encriptar($suministro);
        $json = array('result' => true, 'mensaje' => 'OK','serie' => $serie_usuario,'numero' => $resp,'suministro' => $key);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      } else {
        $json = array('result' => false, 'mensaje' => 'NO SE PUDO GENERAR LA NOTA DE CRÉDITO');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    } else {
      $json = array('result' => false, 'mensaje' => 'Ocuarrio un error al momento de generar la Nota de Crédito');
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/x-json; charset=utf-8');
      echo json_encode($json);
    }
  }
 




    
    
    
    # funcion para obtener las localidades
    public function obtener_localidades(){
      $ajax =  $this->input->get('ajax');
      if($ajax == true){
        $localidades = $this->Cuentas_corrientes_model->get_localidades();
        $categorias = $this->Cuentas_corrientes_model->get_categorias();
        $mensaje = $this->Cuentas_corrientes_model->get_mensaje();
        if($localidades != NULL){
          $json = array('result' => true, 'mensaje1' => 'OK','localidades'=>$localidades,'mensaje'=>$mensaje,'categorias'=>$categorias);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'No se encontraron localidades');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => 'Se encontro un problema en la petición');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }
    #funcion para obtener tarifas
    public function obtener_tarifas(){
      $ajax =  $this->input->get('ajax');
      if($ajax == true){
        $ambito = $this->input->post('localidad');
        $categoria = $this->input->post('categoria');
        $tarifas = $this->Cuentas_corrientes_model->get_all_tarifas($ambito,$categoria);
        if($tarifas != NULL){
          $json = array('result' => true, 'mensaje1' => 'OK','tarifas'=>$tarifas);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'No se encontraron localidades');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => 'Se encontro un problema en la petición');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

   

    public function get_autorizacion(){
      $ajax =  $this->input->get('ajax');
      if($ajax){
        $_nro = $this->input->post('numero');
        $autorizacion = $this->Cuentas_corrientes_model->get_autorizacion_nro($_nro);
        if($autorizacion){
          $json = array('result' => true, 'mensaje' => 'OK','autorizacion'=>$autorizacion);
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
        $json = array('result' => false, 'mensaje' => $this->config->item('_mensje_error'));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }





   

   

 
    

    public function save_nota_credito(){
      ini_set('max_execution_time', 500);
      $ajax = $this->input->get('ajax');
      if($ajax == true){
        $suministro = $this->input->post('suministro');
        $serie_recibo = $this->input->post('serie');
        $numero_recibo = $this->input->post('numero');
        $referencia = $this->input->post("referencia");
        $serie_user = $this->input->post('serie_user');
        $conceptos = $this->input->post('conceptosFac');
        $conceptos1 = $this->input->post('conceptosLec');
        $montos = $this->input->post('montos');
        $faclin = $this->input->post('faclin');
        $letfac = $this->input->post('letfac');
        $tipo = $this->input->post('tipo');
        $serie_nc = $this->input->post('serie_nc');
        $numero_nc = $this->input->post('numero_nc');
        $subtotal = $this->input->post('subtotal');
        $metros = $this->input->post('metros');
        if(substr($suministro, 3,4) == "0000") { 
          $existe = $this->Cuentas_corrientes_model->get_nota_exitente($serie_recibo,$numero_recibo,substr($suministro, 0,3).substr($suministro,7,4));
        } else {
          $existe = $this->Cuentas_corrientes_model->get_nota_exitente($serie_recibo,$numero_recibo,$suministro);
        }
        if($existe){
          $resp = $this->Cuentas_corrientes_model->update_nc($suministro,$serie_recibo,$numero_recibo,$referencia,$serie_user,$conceptos,$conceptos1,$montos,$serie_nc,$numero_nc,$subtotal,$faclin,$letfac,$metros);
        } else {
          if(substr($suministro, 3,4) == "0000"){
            $sum = substr($suministro, 0,3).substr($suministro,7,4);
          } else {
            $sum = $suministro;
          }
          $resp = $this->Cuentas_corrientes_model->save_new_nc($sum,$serie_recibo,$numero_recibo,$referencia,$serie_user,$conceptos,$conceptos1,$montos,$subtotal,$faclin,$letfac,$metros);
        }
        if($resp){
          if(substr($suministro, 3,4) == "0000")  $key = $this->encriptar(substr($suministro, 0,3).substr($suministro, 7,4));
          else  $key = $this->encriptar($suministro);
          $json = array('result' => true, 'mensaje' => 'OK','serie' => $serie_recibo,'numero' => $resp,'suministro' => $key);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'NO SE PUDO GENERAR LA NOTA DE CRÉDITO');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => 'Ocuarrio un error al momento de generar la Nota de Crédito');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function extornar_pago(){
        $ajax = $this->input->get('ajax');
        $var = $this->input->post('serie');
        $var1 = $this->input->post('nro');
        //Preguntar si tiene permiso o autorización para realizar el extorno
        $fecha_pago = $this->Cuentas_corrientes_model->get_fech_pago($var,$var1);
        $fecha_actual = date('Y-m-d');
        $diferencia = $this->validar_fecha($fecha_actual,(substr($fecha_pago['HISCOBFEC'],6,4)."-".substr($fecha_pago['HISCOBFEC'],3,2)."-".substr($fecha_pago['HISCOBFEC'],0,2)));

        if($diferencia > 1 && $diferencia<0){
            $ajax = true;
        }else{
            $ajax = false;
        }
        if ($ajax == true) {
            $json = array('result' => true, 'mensaje' => 'OK','serie'=>$var,'nro'=>$diferencia);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        } else{
            $json = array('result' => false, 'mensaje' => 'Extono no procede');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }
    
    
    

    #funcion para imprimir la facturacion
    public function imprimir_facturacion($suministro,$inicio,$fin){
      $datos = $this->Cuentas_corrientes_model->get_one_client($suministro);
      if($datos == null){
        $suministro1 = substr($suministro,0,3)."0000".substr($suministro,3,4);
        $datos = $this->Cuentas_corrientes_model->get_one_client($suministro1);
      }
      if(substr($suministro, 3,4) == "0000") $suministro = substr($suministro,0,3).substr($suministro,7,4);
      if($inicio == 0 && $fin == 0){
        $recibos = $this->Cuentas_corrientes_model->get_recibos_x_cliente($suministro."%");
        foreach ($recibos as $key => $value) {
          $NC = $this->Cuentas_corrientes_model->get_nca_x_cliente($suministro,$value['FACSERNRO'],$value['FACNRO'],'A');
          $ND = $this->Cuentas_corrientes_model->get_nca_x_cliente($suministro,$value['FACSERNRO'],$value['FACNRO'],'C');
          $recibos[$key]['NC'] = $NC;
          $recibos[$key]['ND'] = $ND;
        }
      } else if ($inicio != 0 && $fin == 0){
        $fecha = "01/".substr($inicio,4,2)."/".substr($inicio,0,4);
        $recibos = $this->Cuentas_corrientes_model->get_recibos_x_cliente2($suministro,$fecha);
        foreach ($recibos as $key => $value) {
          $NC = $this->Cuentas_corrientes_model->get_nca_x_cliente($suministro,$value['FACSERNRO'],$value['FACNRO'],'A');
          $ND = $this->Cuentas_corrientes_model->get_nca_x_cliente($suministro,$value['FACSERNRO'],$value['FACNRO'],'C');
          $recibos[$key]['NC'] = $NC;
          $recibos[$key]['ND'] = $ND;
        }
        $this->data['recibos'] = $recibos;
      } else {
        $fecha = "01/".substr($inicio,4,2)."/".substr($inicio,0,4);
        $month = substr($fin,0,4).'-'.substr($fin,4,2);
        $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
        $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
        $fecha1 = substr($last_day,8,2)."-".substr($last_day,5,2)."-".substr($last_day,0,4);
        $recibos = $this->Cuentas_corrientes_model->get_recibos_x_cliente3($suministro,$fecha,$fecha1);
        foreach ($recibos as $key => $value) {
          $NC = $this->Cuentas_corrientes_model->get_nca_x_cliente($suministro,$value['FACSERNRO'],$value['FACNRO'],'A');
          $ND = $this->Cuentas_corrientes_model->get_nca_x_cliente($suministro,$value['FACSERNRO'],$value['FACNRO'],'C');
          $recibos[$key]['NC'] = $NC;
          $recibos[$key]['ND'] = $ND;
        }
        $this->data['recibos'] = $recibos;
      }
       $this->load->library('ciqrcode');
       $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
       $params['level'] = 'H';
       $params['size'] = 1;
       $params['savename'] = FCPATH.'tes.png';
       $this->ciqrcode->generate($params);
       $this->load->library('pdf');
       $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);

       $mpdf->SetHTMLHeader('<table width="100%" style="font-size:12px">'.
                            '<tr>'.
                               '<td style="text-align:left;width:33%"><b>SEDALIB S.A.</b></td>'.
                               '<td style="width:15%"></td><td style="text-align:right;width:33%"><b>FECHA: </b>'.date('d/m/y').'</td>'.
                             '</tr><tr>'.
                               '<td rowspan="2"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                               '<td style="text-align:center;font-size:14px;color:#296fb7;width:50%"><b>FACTURACIÓN DEL CLIENTE</b></td>'.
                               '<td style="text-align:right"><b>HORA: </b>'.date('H:i:s').'</td>'.
                             '</tr><tr>'.
                               '<td></td>'.
                               '<td style="text-align:right"><b>Página: </b>{PAGENO}</td>'.
                               '</tr></table>');

        $html = '<br><br><table width="100%">'.
             '<tr>'.
                '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$datos['CLINOMBRE'].'</b> </td>'.
              '</tr><tr>'.
                '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$datos['URBDES'].' - '.$datos['CALDES'].' '.$datos['CLIMUNNRO'].'</td>'.
              '</tr></table>';
         $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                  '<tr>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">SERIE</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">NÚMERO</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">FECHA EMISIÓN</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">FECHA VENCIMIENTO</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">MONTO</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF; ">ESTADO</td>'.
                  '</tr>';
          $k = 0;
          foreach ($recibos as $recibo) {
            $k ++;
            $k += sizeof($recibo['NC']);
            $k += sizeof($recibo['ND']);
            if($k > 37 ){
              $html .= "</table>";
              $mpdf->WriteHTML($html);
              $mpdf->AddPage();
              $html = '<br><br><table width="100%">'.
                   '<tr>'.
                      '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$datos['CLINOMBRE'].'</b> </td>'.
                    '</tr><tr>'.
                      '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$datos['URBDES'].' - '.$datos['CALDES'].' '.$datos['CLIMUNNRO'].'</td>'.
                    '</tr></table>';
               $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                        '<tr>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">SERIE</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">NÚMERO</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">FECHA EMISIÓN</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">FECHA VENCIMIENTO</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF;width:16.50% ">MONTO</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid ; border-left:0px;border-right:1px solid #FFF; ">ESTADO</td>'.
                        '</tr>';
              $k = 0;
              $k += sizeof($recibo['NC']);
              $k += sizeof($recibo['ND']);
            }
            $tipo = "";
            switch ($recibo['FACESTADO']) {
              case 'P': $tipo = "PAGADO";
                break;
              case 'I': $tipo = "IMPAGO";
                break;
              case 'C': $tipo = "CONVENIO";
                break;
              case 'F': $tipo = "REFINANCIADO";
                break;
            }
            $html .= '<tr >'.
                        '<td style="font-size:12px !important;text-align:center">'.$recibo['FACSERNRO'].'</td>'.
                        '<td style="font-size:12px !important;text-align:right">'.$recibo['FACNRO'].'</td>'.
                        '<td style="font-size:12px !important;text-align:center">'.$recibo['FACEMIFEC'].'</td>'.
                        '<td style="font-size:12px !important;text-align:center">'.$recibo['FACVENFEC'].'</td>'.
                        '<td style="font-size:12px !important;text-align:right">'.number_format($recibo['FACTOTAL'],2,'.','').'</td>'.
                        '<td style="font-size:12px !important;text-align:right">'.$tipo.'</td>'.
                     '</tr>';
            if(sizeof($recibo['NC']) > 0){
              foreach ($recibo['NC'] as $NC) {
                $html .= '<tr >'.
                            '<td style="font-size:12px !important;color:#990000;text-align:center">'.$NC['NCASERNRO'].'</td>'.
                            '<td style="font-size:12px !important;color:#990000;text-align:right">'.$NC['NCANRO'].'</td>'.
                            '<td style="font-size:12px !important;text-align:center;color:#990000">'.$NC['NCAFECHA'].'</td>'.
                            '<td style="font-size:12px !important;text-align:center;color:#990000"></td>'.
                            '<td style="font-size:12px !important;text-align:right;color:#990000"> - '.number_format($NC['NCATOTDIF'],2,'.','').'</td>'.
                            '<td style="font-size:12px !important;text-align:right;color:#990000"></td>'.
                         '</tr>';
              }
            }

            #notas de DEBITO
            if(sizeof($recibo['ND']) > 0){
              foreach ($recibo['ND'] as $ND) {
                $html .= '<tr >'.
                            '<td colspan="2" style="font-size:12px !important;color:#296FB7;text-align:right">NOTA DÉBITO = '.$ND['NCASERNRO'].' - '.$ND['NCANRO'].'</td>'.
                            '<td style="font-size:12px !important;text-align:center;color:#296FB7">'.$ND['NCAFECHA'].'</td>'.
                            '<td style="font-size:12px !important;text-align:center;color:#296FB7"></td>'.
                            '<td style="font-size:12px !important;text-align:right;color:#296FB7">'.number_format($ND['NCATOTDIF'],2,'.','').'</td>'.
                            '<td style="font-size:12px !important;text-align:right;color:#296FB7"></td>'.
                         '</tr>';
              }
            }

        }
        $html .= "</table>";
        $mpdf->WriteHTML($html);
        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit;
    }
    
    # función para obtner el mes a partir de un número
    public function devolver_mes($cadena){
        switch($cadena){
            case '01': return "Enero";break;
            case '02': return "Febrero";break;
            case '03': return "Marzo";break;
            case '04': return "Abril";break;
            case '05': return "Mayo";break;
            case '06': return "Junio";break;
            case '07': return "Julio";break;
            case '08': return "Agosto";break;
            case '09': return "Setiembre";break;
            case '10': return "octubre";break;
            case '11': return "Noviembre";break;
            case '12': return "Diciembre";break;
        }
    }
    
  
  


  
    #funcion para imprimir el detalle de los cortes
  public function imprimir_acciones($suministro){
    $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
    $acciones = $this->Cuentas_corrientes_model->get_acciones_coercitivas($suministro);
    foreach ($acciones as $key => $accion) {
      $valor1 = $this->Cuentas_corrientes_model->get_orden_corte($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM']);
      $valor2 = $this->Cuentas_corrientes_model->get_acciones_reconexion($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
      $valor = $this->Cuentas_corrientes_model->get_acciadd($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
      $acciones[$key]['orden_corte'] = $valor1;
      $acciones[$key]['ACCIADO'] = $valor;
      $acciones[$key]['reconexion'] = $valor2;
    }
    foreach ($acciones as $key => $accion) {
      if($accion['ACCIADO'] != NULL){
        foreach ($accion['ACCIADO'] as $key2 => $valor7) {
          $niveles = $this->Cuentas_corrientes_model->get_nivel_corte($valor7['PNIVELCO_NIV_CODI']);
          $observacion = $this->Cuentas_corrientes_model->get_observacion_corte1($valor7['TOBSERVA_OBS_CODI']);
          $detalle_deuda = $this->Cuentas_corrientes_model->get_recibos_x_corte1($valor7['TCORTADO_ORDENCOR_OC_OFI'],$valor7['TCORTADO_ORDENCOR_OC_AGE'],$valor7['TCORTADO_ORDENCOR_ORC_NUM'],$valor7['TCORTADO_CLIUNICOD']);
          $accion['ACCIADO'][$key2]['nivel'] = $niveles;
          $accion['ACCIADO'][$key2]['OBSERVACION'] = $observacion;
          $accion['ACCIADO'][$key2]['deuda'] = $detalle_deuda;;
        }
      }
      if($accion['reconexion'] != NULL){
        $service = $this->Cuentas_corrientes_model->get_service1($accion['reconexion']['REA_CRT']);
        $cab_fecha = $this->Cuentas_corrientes_model->get_fecha_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
        $cab_hora = $this->Cuentas_corrientes_model->get_hora_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
        $obs = $this->Cuentas_corrientes_model->get_observacion_corte1($accion['reconexion']['REA_OBR']);
        $accion['reconexion']['service'] = $service;
        $accion['reconexion']['REA_FEC'] = $cab_fecha;
        $accion['reconexion']['REA_HRA'] = $cab_hora;
        $accion['reconexion']['OBS_DETA'] = $obs;
      }
      $valor1 = $this->Cuentas_corrientes_model->get_cartera($accion['orden_corte']['TACCORTE_ACC_CODIGO']);
      $acciones[$key]['cartera'] = $valor1;
      $acciones[$key]['ACCIADO'] = $accion['ACCIADO'];
      $acciones[$key]['reconexion'] = $accion['reconexion'];
    }
    //$this->data['acciones']  = $acciones;
    $this->load->library('ciqrcode');
    $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
    $params['level'] = 'H';
    $params['size'] = 1;
    $params['savename'] = FCPATH.'tes.png';
    $this->ciqrcode->generate($params);
    $this->load->library('pdf');
    $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);
    $mpdf->SetHTMLHeader('<table width="100%" style="font-size:12px">'.
                          '<tr>'.
                             '<td style="text-align:left;width:33%"><b>SEDALIB S.A.</b></td>'.
                             '<td style="width:15%"></td><td style="text-align:right;width:33%"><b>FECHA: </b>'.date('d/m/y').'</td>'.
                           '</tr><tr>'.
                             '<td rowspan="2"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                             '<td style="text-align:center;font-size:14px;color:#296fb7;width:50%"><b>ACCIONES DE CORTE Y REPOSICIÓN EJECUTADAS EN CAMPO</b></td>'.
                             '<td style="text-align:right"><b>HORA: </b>'.date('H:i:s').'</td>'.
                           '</tr><tr>'.
                             '<td></td>'.
                             '<td style="text-align:right"><b>Página: </b>{PAGENO}</td>'.
                             '</tr></table>');
    $mpdf->AddPage('L');
    $html = '<br><br><table width="100%">'.
            '<tr>'.
              '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
            '</tr><tr>'.
              '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
            '</tr></table>';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
              '<tr>'.
                '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                '<td></td>'.
              '</tr>'.
              '<tr>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #FF0000; border-left:0px;border-right:1px solid #FFF;color:#ff0000; width:10%;margin-bottom:10px">Días sin Servicio</td>'.
                  '</tr>';
        $j = 0;
        foreach ($acciones as $accion) {
          $j = $j + 1;
          $j = $j + sizeof($accion['ACCIADO']);
          if($j>20){
            $html .= "</table>";
            $mpdf->WriteHTML($html);
            $mpdf->AddPage('L');
            $html = "";
            $html = '<br><br><table width="100%">'.
                   '<tr>'.
                      '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
                    '</tr><tr>'.
                      '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
                    '</tr></table>';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                        '<tr>'.
                            '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                            '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                            '<td></td>'.
                        '</tr>'.
                        '<tr>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #FF0000; border-left:0px;border-right:1px solid #FFF;color:#ff0000; width:10%;margin-bottom:10px">Días sin Servicio</td>'.
                        '</tr>';
            $j = 0;
            $j = sizeof($accion['ACCIADO']) + 1;
          }
          $tam = strlen($accion['ORDENCOR_ORC_NUM']);
          $tam1 = strlen(number_format($accion['H_CAL_MONT'],2,'.',''));
          $tam2 = strlen(number_format($accion['H_NW_SALD'],2,'.',''));
          $tam3 = strlen($accion['reconexion']['service']);
          $tam4 = strlen($accion['cartera']);
          $orc = $accion['ORDENCOR_ORC_NUM'];
          $monto = number_format($accion['H_CAL_MONT'],2,'.','');
          $monto1 = number_format($accion['H_NW_SALD'],2,'.','');
          $service = $accion['reconexion']['service'];
          $cartera =  $accion['cartera'];
          for ($i=$tam; $i < 10; $i++) {
            $orc = "&nbsp;".$orc;
          }
          switch ($tam1) {
            case 4:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 5:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 6:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 7:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
          }
          switch ($tam2) {
            case 4:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 5:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 6:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 7:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
          }
          switch ($tam4) {
            case 6:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 9:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;";
              break;
          }
          switch ($tam3) {
            case 0:
              $service = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 5:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 6:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
          }
          $html .= '<tr style="background:#aaddec;">'.
                   '<td colspan="9" style="border:1px solid;padding-top:7px;font-size:11px !important;padding-left:5px;color:#296fb7">'.
                      '<span>O/C. Nro.</span><span style="background:#FFF">'.$accion['ORDENCOR_OC_OFI'].'</span> <span style="background:#FFF"> '.$accion['ORDENCOR_OC_AGE'].' </span>   &nbsp; <span style="background:#FFF">&nbsp;&nbsp;&nbsp;&nbsp;'.$orc.'</span>&nbsp;&nbsp;'.
                      '<span>F.Emisión: </span><span style="background:#FFF">'.$accion['orden_corte']['ORC_FECH'].'</span> <span>F. Cierre: </span><span style="background:#FFF">'.(($accion['orden_corte']['ORC_STFECH'] == NULL ) ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : $accion['orden_corte']['ORC_STFECH']).'</span>'.
                      ' <span>Tarifa: </span><span style="background:#FFF">'.$accion['H_TARIFA'].'&nbsp;&nbsp;</span>'.
                      ' <span>Deuda de Corte </span><span style="background:#FFF;">'.$monto.'</span>'.
                      ' <span>Saldo Actual </span><span style="background:#FFF;">'.$monto1.'</span>'.
                      ' <span> Service </span><span style="background:#FFF">'.$service.'</span>'.
                      ' <span> Ciclo: </span><span style="background:#FFF">'.$accion['orden_corte']['FACCICCOD'].'</span>'.
                      ' <span> Cartera: </span><span style="background:#FFF">'.$cartera.'</span>'.
                   '</td>'.
                   '</tr>';


          foreach ($accion['ACCIADO'] as $valor) {
            $html .= '<tr>'.
                      '<td style="font-size:10.5px !important">'.$valor['DONEFECH'].' '.$valor['DONEHORA'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['nivel'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['OBSERVACION'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$accion['reconexion']['REA_CAB_REA_OFI'].' '.$accion['reconexion']['REA_CAB_REA_AGE'].' '.$accion['reconexion']['REA_CAB_REA_NRO'].'</td>'.
                      '<td style="font-size:10.5px !important"></td>'.
                      '<td style="font-size:10.5px !important">'.$accion['reconexion']['OBS_DETA'].'</td>'.
                      '<td style="font-size:10.5px !important">'.(($accion['reconexion']['REA_FOB'] != NULL) ? $accion['reconexion']['REA_FOB'] : " / /" ).' '.(($accion['reconexion']['REA_HOB'] != "00:00:00") ? $accion['reconexion']['REA_HOB']  : "").'</td>'.
                      '<td></td>';
            $direrencia = $this->dateDiff((substr($valor['DONEFECH'],6,4).'-'.substr($valor['DONEFECH'],3,2).'-'.substr($valor['DONEFECH'],0,2)),(substr($accion['reconexion']['REA_FOB'],6,4)."-".substr($accion['reconexion']['REA_FOB'],3,2).'-'.substr($accion['reconexion']['REA_FOB'],0,2)));

              $html .= '<td style="font-size:10.5px !important;text-align:center">'.(($direrencia < 0 ) ? "0" : $direrencia) .'</td>'.
                     '</tr>';
          }
        }

        //if($j < 19){
          $html .= "</table>";
          $mpdf->WriteHTML($html);
        //}

        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit;
    }
    
    #función para imprimir el detalle de los cortes y reconexiones
   public function imprimir_acciones1($suministro){
      $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
      $acciones = $this->Cuentas_corrientes_model->get_acciones_coercitivas($suministro);
      foreach ($acciones as $key => $accion) {
        $valor1 = $this->Cuentas_corrientes_model->get_orden_corte($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM']);
        $valor2 = $this->Cuentas_corrientes_model->get_acciones_reconexion($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $valor = $this->Cuentas_corrientes_model->get_acciadd($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $acciones[$key]['orden_corte'] = $valor1;
        $acciones[$key]['ACCIADO'] = $valor;
        $acciones[$key]['reconexion'] = $valor2;
      }
      foreach ($acciones as $key => $accion) {
        if($accion['ACCIADO'] != NULL){
          foreach ($accion['ACCIADO'] as $key2 => $valor7) {
            $niveles = $this->Cuentas_corrientes_model->get_nivel_corte($valor7['PNIVELCO_NIV_CODI']);
            $observacion = $this->Cuentas_corrientes_model->get_observacion_corte1($valor7['TOBSERVA_OBS_CODI']);
            $detalle_deuda = $this->Cuentas_corrientes_model->get_recibos_x_corte1($valor7['TCORTADO_ORDENCOR_OC_OFI'],$valor7['TCORTADO_ORDENCOR_OC_AGE'],$valor7['TCORTADO_ORDENCOR_ORC_NUM'],$valor7['TCORTADO_CLIUNICOD']);
            $accion['ACCIADO'][$key2]['nivel'] = $niveles;
            $accion['ACCIADO'][$key2]['OBSERVACION'] = $observacion;
            $accion['ACCIADO'][$key2]['deuda'] = $detalle_deuda;;
          }
        }

        if($accion['reconexion'] != NULL){
          $service = $this->Cuentas_corrientes_model->get_service1($accion['reconexion']['REA_CRT']);
          $cab_fecha = $this->Cuentas_corrientes_model->get_fecha_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $cab_hora = $this->Cuentas_corrientes_model->get_hora_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $obs = $this->Cuentas_corrientes_model->get_observacion_corte1($accion['reconexion']['REA_OBR']);
          $accion['reconexion']['service'] = $service;
          $accion['reconexion']['REA_FEC'] = $cab_fecha;
          $accion['reconexion']['REA_HRA'] = $cab_hora;
          $accion['reconexion']['OBS_DETA'] = $obs;
        }
        $valor1 = $this->Cuentas_corrientes_model->get_cartera($accion['orden_corte']['TACCORTE_ACC_CODIGO']);
        $acciones[$key]['cartera'] = $valor1;
        $acciones[$key]['ACCIADO'] = $accion['ACCIADO'];
        $acciones[$key]['reconexion'] = $accion['reconexion'];

      }
      $this->data['acciones']  = $acciones;
      $this->load->library('ciqrcode');
     $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
     $params['level'] = 'H';
     $params['size'] = 1;
     $params['savename'] = FCPATH.'tes.png';
     $this->ciqrcode->generate($params);
     $this->load->library('pdf');
     $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);

     $mpdf->SetHTMLHeader('<table width="100%" style="font-size:12px">'.
                          '<tr>'.
                             '<td style="text-align:left;width:33%"><b>SEDALIB S.A.</b></td>'.
                             '<td style="width:15%"></td><td style="text-align:right;width:33%"><b>FECHA: </b>'.date('d/m/y').'</td>'.
                           '</tr><tr>'.
                             '<td rowspan="2"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                             '<td style="text-align:center;font-size:14px;color:#296fb7;width:50%"><b>ACCIONES DE CORTE Y REPOSICIÓN EJECUTADAS EN CAMPO</b></td>'.
                             '<td style="text-align:right"><b>HORA: </b>'.date('H:i:s').'</td>'.
                           '</tr><tr>'.
                             '<td></td>'.
                             '<td style="text-align:right"><b>Página: </b>{PAGENO}</td>'.
                             '</tr></table>');
        $mpdf->AddPage('L');
        $html = '<br><br><table width="100%">'.
             '<tr>'.
                '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
              '</tr><tr>'.
                '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
              '</tr></table>';
         $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                  '<tr>'.
                      '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                      '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                      '<td></td>'.
                  '</tr>'.
                  '<tr>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #FF0000; border-left:0px;border-right:1px solid #FFF;color:#ff0000; width:10%;margin-bottom:10px">Días sin Servicio</td>'.
                  '</tr>';
        $j = 0;
        foreach ($acciones as $accion) {
          $j = $j + 1;
          $j = $j + sizeof($accion['ACCIADO']);
          if($j > 18 ){
            $html .= "</table>";
            $mpdf->WriteHTML($html);
              $mpdf->AddPage('L');
              $html = "";
              $html = '<br><br><table width="100%">'.
                   '<tr>'.
                      '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
                    '</tr><tr>'.
                      '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
                    '</tr></table>';
               $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                        '<tr>'.
                            '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                            '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                            '<td></td>'.
                        '</tr>'.
                        '<tr>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #FF0000; border-left:0px;border-right:1px solid #FFF;color:#ff0000; width:10%;margin-bottom:10px">Días sin Servicio</td>'.
                        '</tr>';
              $j = 0;
              $j = sizeof($accion['ACCIADO']) + 1;
          }
          $tam = strlen($accion['ORDENCOR_ORC_NUM']);
          $tam1 = strlen(number_format($accion['H_CAL_MONT'],2,'.',''));
          $tam2 = strlen(number_format($accion['H_NW_SALD'],2,'.',''));
          $tam3 = strlen($accion['reconexion']['service']);
          $tam4 = strlen($accion['cartera']);
          $orc = $accion['ORDENCOR_ORC_NUM'];
          $monto = number_format($accion['H_CAL_MONT'],2,'.','');
          $monto1 = number_format($accion['H_NW_SALD'],2,'.','');
          $service = $accion['reconexion']['service'];
          $cartera =  $accion['cartera'];
          for ($i=$tam; $i < 10; $i++) {
            $orc = "&nbsp;".$orc;
          }
          switch ($tam1) {
            case 4:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 5:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 6:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 7:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
          }

          switch ($tam2) {
            case 4:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 5:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 6:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 7:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
          }

          switch ($tam4) {
            case 6:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 9:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;";
              break;
          }

          switch ($tam3) {
            case 0:
              $service = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 5:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 6:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $service = $service."&nbsp;&nbsp;&nbsp;";
              break;
          }

          if($accion['orden_corte']['ORC_DESC'] == 'ACTIVA'){
            $btn = '&nbsp;<span style="background:#0F0;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else if($accion['orden_corte']['ORC_DESC'] == 'CERRADA'){
            $btn = '&nbsp;<span style="background:#FF0;border:1px solid" >&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else {
            $btn = '&nbsp;<span style="background:#F00;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          }

          $html .= '<tr style="background:#aaddec;">'.
                   '<td colspan="9" style="border:1px solid;padding-top:7px;font-size:11px !important;padding-left:5px;color:#296fb7">'.
                      '<span>O/C. Nro.</span><span style="background:#FFF">'.$accion['ORDENCOR_OC_OFI'].'</span> <span style="background:#FFF"> '.$accion['ORDENCOR_OC_AGE'].' </span>   &nbsp; <span style="background:#FFF">&nbsp;&nbsp;&nbsp;&nbsp;'.$orc.'</span> '.$btn.
                      '<span>F.Emisión: </span><span style="background:#FFF">'.$accion['orden_corte']['ORC_FECH'].'</span> <span>F. Cierre: </span><span style="background:#FFF">'.(($accion['orden_corte']['ORC_STFECH'] == NULL ) ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : $accion['orden_corte']['ORC_STFECH']).'</span>'.
                      ' <span>Tarifa: </span><span style="background:#FFF">'.$accion['H_TARIFA'].'&nbsp;&nbsp;</span>'.
                      ' <span>Deuda de Corte </span><span style="background:#FFF;">'.$monto.'</span>'.
                      ' <span>Saldo Actual </span><span style="background:#FFF;">'.$monto1.'</span>'.
                      ' <span> Service </span><span style="background:#FFF">'.$service.'</span>'.
                      ' <span> Ciclo: </span><span style="background:#FFF">'.$accion['orden_corte']['FACCICCOD'].'</span>'.
                      ' <span> Cartera: </span><span style="background:#FFF">'.$cartera.'</span>'.
                   '</td>'.
                   '</tr>';


          foreach ($accion['ACCIADO'] as $valor) {
            $html .= '<tr>'.
                      '<td style="font-size:10.5px !important">'.$valor['DONEFECH'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['DONEHORA'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['nivel'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['OBSERVACION'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$accion['reconexion']['REA_CAB_REA_OFI'].' '.$accion['reconexion']['REA_CAB_REA_AGE'].' '.$accion['reconexion']['REA_CAB_REA_NRO'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$accion['reconexion']['OBS_DETA'].'</td>'.
                      '<td style="font-size:10.5px !important">'.(($accion['reconexion']['REA_FOB'] != NULL) ? $accion['reconexion']['REA_FOB'] : " / /" ).' '.(($accion['reconexion']['REA_HOB'] != "00:00:00") ? $accion['reconexion']['REA_HOB']  : "").'</td>'.
                      '<td></td>';
            $direrencia = $this->dateDiff((substr($valor['DONEFECH'],6,4).'-'.substr($valor['DONEFECH'],3,2).'-'.substr($valor['DONEFECH'],0,2)),(substr($accion['reconexion']['REA_FOB'],6,4)."-".substr($accion['reconexion']['REA_FOB'],3,2).'-'.substr($accion['reconexion']['REA_FOB'],0,2)));

              $html .= '<td style="font-size:10.5px !important;text-align:center">'.(($direrencia < 0 ) ? "0" : $direrencia) .'</td>'.
                     '</tr>';
          }
        }
        /*if($j < 19){
          $html .= "</table>";
          $html .= "<h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        } else {*/
          $html .= "</table><h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        //}


        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit;
    }
    #función para imprimir acciones de manera detallada
   /* public function imprimir_acciones2($suministro){
      $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
      if($user== NULL){
        $user = $this->Cuentas_corrientes_model->get_user_name(substr($suministro,0,3).'0000'.substr($suministro,3,4));
      }
      $acciones = $this->Cuentas_corrientes_model->get_acciones_coercitivas($suministro);
      foreach ($acciones as $key => $accion) {
        $valor1 = $this->Cuentas_corrientes_model->get_orden_corte($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM']);
        $valor2 = $this->Cuentas_corrientes_model->get_acciones_reconexion($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $valor = $this->Cuentas_corrientes_model->get_acciadd($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $valor3 = $this->Cuentas_corrientes_model->get_recibos_x_corte2($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $acciones[$key]['orden_corte'] = $valor1;
        $acciones[$key]['ACCIADO'] = $valor;
        $acciones[$key]['reconexion'] = $valor2;
        $acciones[$key]['recibos'] = $valor3;
      }
      foreach ($acciones as $key => $accion) {
        if($accion['ACCIADO'] != NULL){
          foreach ($accion['ACCIADO'] as $key2 => $valor7) {
            $niveles = $this->Cuentas_corrientes_model->get_nivel_corte($valor7['PNIVELCO_NIV_CODI']);
            $observacion = $this->Cuentas_corrientes_model->get_observacion_corte1($valor7['TOBSERVA_OBS_CODI']);
            $detalle_deuda = $this->Cuentas_corrientes_model->get_recibos_x_corte2($valor7['TCORTADO_ORDENCOR_OC_OFI'],$valor7['TCORTADO_ORDENCOR_OC_AGE'],$valor7['TCORTADO_ORDENCOR_ORC_NUM'],$valor7['TCORTADO_CLIUNICOD']);
            $accion['ACCIADO'][$key2]['nivel'] = $niveles;
            $accion['ACCIADO'][$key2]['OBSERVACION'] = $observacion;
            $accion['ACCIADO'][$key2]['deuda'] = $detalle_deuda;;
          }
        }

        if($accion['reconexion'] != NULL){
          $service = $this->Cuentas_corrientes_model->get_service1($accion['reconexion']['REA_CRT']);
          $cab_fecha = $this->Cuentas_corrientes_model->get_fecha_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $cab_hora = $this->Cuentas_corrientes_model->get_hora_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $obs = $this->Cuentas_corrientes_model->get_observacion_corte1($accion['reconexion']['REA_OBR']);
          $accion['reconexion']['service'] = $service;
          $accion['reconexion']['REA_FEC'] = $cab_fecha;
          $accion['reconexion']['REA_HRA'] = $cab_hora;
          $accion['reconexion']['OBS_DETA'] = $obs;
        }
        $valor1 = $this->Cuentas_corrientes_model->get_cartera($accion['orden_corte']['TACCORTE_ACC_CODIGO']);
        $acciones[$key]['cartera'] = $valor1;
        $acciones[$key]['ACCIADO'] = $accion['ACCIADO'];
        $acciones[$key]['reconexion'] = $accion['reconexion'];

      }
      $this->data['acciones']  = $acciones;
      $this->load->library('ciqrcode');
     $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
     $params['level'] = 'H';
     $params['size'] = 1;
     $params['savename'] = FCPATH.'tes.png';
     $this->ciqrcode->generate($params);
     $this->load->library('pdf');
     $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);

     $mpdf->SetHTMLHeader('<table width="100%" style="font-size:12px">'.
                          '<tr>'.
                             '<td style="text-align:left;width:33%"><b>SEDALIB S.A.</b></td>'.
                             '<td style="width:15%"></td><td style="text-align:right;width:33%"><b>FECHA: </b>'.date('d/m/y').'</td>'.
                           '</tr><tr>'.
                             '<td rowspan="2"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                             '<td style="text-align:center;font-size:14px;color:#296fb7;width:50%"><b>ACCIONES DE CORTE Y REPOSICIÓN EJECUTADAS EN CAMPO</b></td>'.
                             '<td style="text-align:right"><b>HORA: </b>'.date('H:i:s').'</td>'.
                           '</tr><tr>'.
                             '<td></td>'.
                             '<td style="text-align:right"><b>Página: </b>{PAGENO}</td>'.
                             '</tr></table>');
        $mpdf->AddPage('L');
        $html = '<br><br><table width="100%">'.
             '<tr>'.
                '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
              '</tr><tr>'.
                '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
              '</tr></table>';
         $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                  '<tr>'.
                      '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                      '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                      '<td></td>'.
                  '</tr>'.
                  '<tr>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a; width:10%;margin-bottom:10px">Reaperturado por</td>'.
                  '</tr>';
        $j = 0;
        $i = 0;
        foreach ($acciones as $accion) {
          $j = $j + 1;
          $i++;
          if(sizeof($accion['recibos']) > 0 ){
            $j = $j + 1;
          }
          $j = $j + sizeof($accion['ACCIADO']);
          $j = $j + sizeof($accion['recibos']);
          if($j >= 22 ){
            $html .= "</table>";
            $mpdf->WriteHTML($html);
            if($i < sizeof($acciones)){
              $mpdf->AddPage('L');
              $html = '<br><br><table width="100%">'.
                   '<tr>'.
                      '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
                    '</tr><tr>'.
                      '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
                    '</tr></table>';
               $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                        '<tr>'.
                            '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                            '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                            '<td></td>'.
                        '</tr>'.
                        '<tr>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a; width:10%;margin-bottom:10px">Reaperturado por</td>'.
                        '</tr>';
              $j = 0;
              $j = $j + sizeof($accion['ACCIADO']);
              $j = $j + sizeof($accion['recibos']);
            }

          }
          $tam = strlen($accion['ORDENCOR_ORC_NUM']);
          $tam1 = strlen(number_format($accion['H_CAL_MONT'],2,'.',''));
          $tam2 = strlen(number_format($accion['H_NW_SALD'],2,'.',''));
          $tam3 = strlen($accion['reconexion']['service']);
          $tam4 = strlen($accion['cartera']);
          $orc = $accion['ORDENCOR_ORC_NUM'];
          $monto = number_format($accion['H_CAL_MONT'],2,'.','');
          $monto1 = number_format($accion['H_NW_SALD'],2,'.','');
          $service = $accion['reconexion']['service'];
          $cartera =  $accion['cartera'];
          for ($i=$tam; $i < 10; $i++) {
            $orc = "&nbsp;".$orc;
          }
          switch ($tam1) {
            case 4:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 5:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 6:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 7:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
          }

          switch ($tam2) {
            case 4:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 5:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 6:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 7:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
          }

          switch ($tam4) {
            case 6:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 9:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;";
              break;
          }

          switch ($tam3) {
            case 0:
              $service = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 5:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 6:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $service = $service."&nbsp;&nbsp;&nbsp;";
              break;
          }

          if($accion['orden_corte']['ORC_DESC'] == 'ACTIVA'){
            $btn = '&nbsp;<span style="background:#0F0;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else if($accion['orden_corte']['ORC_DESC'] == 'CERRADA'){
            $btn = '&nbsp;<span style="background:#FF0;border:1px solid" >&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else {
            $btn = '&nbsp;<span style="background:#F00;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          }

          $html .= '<tr style="background:#aaddec;">'.
                   '<td colspan="9" style="border:1px solid;padding-top:7px;font-size:11px !important;padding-left:5px;color:#296fb7">'.
                      '<span>O/C. Nro.</span><span style="background:#FFF">'.$accion['ORDENCOR_OC_OFI'].'</span> <span style="background:#FFF"> '.$accion['ORDENCOR_OC_AGE'].' </span>   &nbsp; <span style="background:#FFF">&nbsp;&nbsp;&nbsp;&nbsp;'.$orc.'</span> '.$btn.
                      '<span>F.Emisión: </span><span style="background:#FFF">'.$accion['orden_corte']['ORC_FECH'].'</span> <span>F. Cierre: </span><span style="background:#FFF">'.(($accion['orden_corte']['ORC_STFECH'] == NULL ) ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : $accion['orden_corte']['ORC_STFECH']).'</span>'.
                      ' <span>Tarifa: </span><span style="background:#FFF">'.$accion['H_TARIFA'].'&nbsp;&nbsp;</span>'.
                      ' <span>Deuda de Corte </span><span style="background:#FFF;">'.$monto.'</span>'.
                      ' <span>Saldo Actual </span><span style="background:#FFF;">'.$monto1.'</span>'.
                      ' <span> Service </span><span style="background:#FFF">'.$service.'</span>'.
                      ' <span> Ciclo: </span><span style="background:#FFF">'.$accion['orden_corte']['FACCICCOD'].'</span>'.
                      ' <span> Cartera: </span><span style="background:#FFF">'.$cartera.'</span>'.
                   '</td>'.
                   '</tr>';

          $valor2 = sizeof($accion['ACCIADO']);
          $k = 0;
          foreach ($accion['ACCIADO'] as $valor) {
            $k++;
            if($k == $valor2){
              $html .= '<tr>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #8448c1;border-right:1px solid #FFF">'.$valor['DONEFECH'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #8448c1;border-right:1px solid #FFF">'.$valor['DONEHORA'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #8448c1;border-right:1px solid #FFF">'.$valor['nivel'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$valor['OBSERVACION'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$accion['reconexion']['REA_CAB_REA_OFI'].' '.$accion['reconexion']['REA_CAB_REA_AGE'].' '.$accion['reconexion']['REA_CAB_REA_NRO'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$accion['reconexion']['OBS_DETA'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.(($accion['reconexion']['REA_FOB'] != NULL) ? $accion['reconexion']['REA_FOB'] : " / /" ).' '.(($accion['reconexion']['REA_HOB'] != "00:00:00") ? $accion['reconexion']['REA_HOB']  : "").'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF"></td>';

                $html .= '<td style="font-size:10.5px !important;text-align:center;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$accion['reconexion']['service'].'</td>'.
                       '</tr>';
            } else {
              $html .= '<tr>'.
                        '<td style="font-size:10.5px !important">'.$valor['DONEFECH'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$valor['DONEHORA'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$valor['nivel'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$valor['OBSERVACION'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$accion['reconexion']['REA_CAB_REA_OFI'].' '.$accion['reconexion']['REA_CAB_REA_AGE'].' '.$accion['reconexion']['REA_CAB_REA_NRO'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$accion['reconexion']['OBS_DETA'].'</td>'.
                        '<td style="font-size:10.5px !important">'.(($accion['reconexion']['REA_FOB'] != NULL) ? $accion['reconexion']['REA_FOB'] : " / /" ).' '.(($accion['reconexion']['REA_HOB'] != "00:00:00") ? $accion['reconexion']['REA_HOB']  : "").'</td>'.
                        '<td></td>';
              $html .= '<td style="font-size:10.5px !important;text-align:center">'.$accion['reconexion']['service'] .'</td>'.
                       '</tr>';
            }


          }
          if(sizeof($accion['recibos']) > 0 ){
            $html .= '<tr>'.
                      '<td></td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF;text-align:center;width:10%">Item</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Recibo</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">F. Emisión</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Regularización</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Est.</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Saldo</td>'.
                      '<td></td>'.
                      '<td></td>'.
                     '</tr>';
          }
          $LL = 1;
          foreach ($accion['recibos'] as $valor1) {
            $html .= '<tr>'.
                      '<td></td>'.
                      '<td style="font-size:10px !important;text-align:center">'.$LL.'</td>'.
                      '<td style="font-size:10px !important;">'.$valor1['FACSERNRO'].' &nbsp;&nbsp; '.$valor1['FACNRO'].'</td>'.
                      '<td style="font-size:10px important;">'.(($valor1['FACEMIFEC'] != NULL) ? $valor1['FACEMIFEC'] : " / / ").'</td>'.
                      '<td style="font-size:10px !important;">'.(($valor1['NW_FECHA'] != NULL) ? $valor1['NW_FECHA'] : " / / ").'</td>'.
                      '<td style="font-size:10px !important;">'.$valor1['NW_ST'].'</td>'.
                      '<td style="font-size:10px !important;">'.number_format($valor1['NW_SALDO'],2,'.','').'</td>'.
                     '</tr>';
            $LL++;
          }
        }
        if($j < 19){
          $html .= "</table>";
          $html .= "<h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        } else {
          $html .= "<h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        }


        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit;
    }*/

    #función para imprimir el detalle de los cortes y reconexiones
   /* public function imprimir_acciones1($suministro){
      $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
      $acciones = $this->Cuentas_corrientes_model->get_acciones_coercitivas($suministro);
      foreach ($acciones as $key => $accion) {
        $valor1 = $this->Cuentas_corrientes_model->get_orden_corte($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM']);
        $valor2 = $this->Cuentas_corrientes_model->get_acciones_reconexion($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $valor = $this->Cuentas_corrientes_model->get_acciadd($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $acciones[$key]['orden_corte'] = $valor1;
        $acciones[$key]['ACCIADO'] = $valor;
        $acciones[$key]['reconexion'] = $valor2;
      }
      foreach ($acciones as $key => $accion) {
        if($accion['ACCIADO'] != NULL){
          foreach ($accion['ACCIADO'] as $key2 => $valor7) {
            $niveles = $this->Cuentas_corrientes_model->get_nivel_corte($valor7['PNIVELCO_NIV_CODI']);
            $observacion = $this->Cuentas_corrientes_model->get_observacion_corte1($valor7['TOBSERVA_OBS_CODI']);
            $detalle_deuda = $this->Cuentas_corrientes_model->get_recibos_x_corte1($valor7['TCORTADO_ORDENCOR_OC_OFI'],$valor7['TCORTADO_ORDENCOR_OC_AGE'],$valor7['TCORTADO_ORDENCOR_ORC_NUM'],$valor7['TCORTADO_CLIUNICOD']);
            $accion['ACCIADO'][$key2]['nivel'] = $niveles;
            $accion['ACCIADO'][$key2]['OBSERVACION'] = $observacion;
            $accion['ACCIADO'][$key2]['deuda'] = $detalle_deuda;;
          }
        }

        if($accion['reconexion'] != NULL){
          $service = $this->Cuentas_corrientes_model->get_service1($accion['reconexion']['REA_CRT']);
          $cab_fecha = $this->Cuentas_corrientes_model->get_fecha_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $cab_hora = $this->Cuentas_corrientes_model->get_hora_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $obs = $this->Cuentas_corrientes_model->get_observacion_corte1($accion['reconexion']['REA_OBR']);
          $accion['reconexion']['service'] = $service;
          $accion['reconexion']['REA_FEC'] = $cab_fecha;
          $accion['reconexion']['REA_HRA'] = $cab_hora;
          $accion['reconexion']['OBS_DETA'] = $obs;
        }
        $valor1 = $this->Cuentas_corrientes_model->get_cartera($accion['orden_corte']['TACCORTE_ACC_CODIGO']);
        $acciones[$key]['cartera'] = $valor1;
        $acciones[$key]['ACCIADO'] = $accion['ACCIADO'];
        $acciones[$key]['reconexion'] = $accion['reconexion'];

      }
      $this->data['acciones']  = $acciones;
      $this->load->library('ciqrcode');
     $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
     $params['level'] = 'H';
     $params['size'] = 1;
     $params['savename'] = FCPATH.'tes.png';
     $this->ciqrcode->generate($params);
     $this->load->library('pdf');
     $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);

     $mpdf->SetHTMLHeader('<table width="100%" style="font-size:12px">'.
                          '<tr>'.
                             '<td style="text-align:left;width:33%"><b>SEDALIB S.A.</b></td>'.
                             '<td style="width:15%"></td><td style="text-align:right;width:33%"><b>FECHA: </b>'.date('d/m/y').'</td>'.
                           '</tr><tr>'.
                             '<td rowspan="2"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                             '<td style="text-align:center;font-size:14px;color:#296fb7;width:50%"><b>ACCIONES DE CORTE Y REPOSICIÓN EJECUTADAS EN CAMPO</b></td>'.
                             '<td style="text-align:right"><b>HORA: </b>'.date('H:i:s').'</td>'.
                           '</tr><tr>'.
                             '<td></td>'.
                             '<td style="text-align:right"><b>Página: </b>{PAGENO}</td>'.
                             '</tr></table>');
        $mpdf->AddPage('L');
        $html = '<br><br><table width="100%">'.
             '<tr>'.
                '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
              '</tr><tr>'.
                '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
              '</tr></table>';
         $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                  '<tr>'.
                      '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                      '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                      '<td></td>'.
                  '</tr>'.
                  '<tr>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #FF0000; border-left:0px;border-right:1px solid #FFF;color:#ff0000; width:10%;margin-bottom:10px">Días sin Servicio</td>'.
                  '</tr>';
        $j = 0;
        foreach ($acciones as $accion) {
          $j = $j + 1;
          $j = $j + sizeof($accion['ACCIADO']);
          if($j > 23 ){
            $html .= "</table>";
            $mpdf->WriteHTML($html);
              $mpdf->AddPage('L');
              $html = "";
              $html = '<br><br><table width="100%">'.
                   '<tr>'.
                      '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
                    '</tr><tr>'.
                      '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
                    '</tr></table>';
               $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                        '<tr>'.
                            '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                            '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                            '<td></td>'.
                        '</tr>'.
                        '<tr>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #FF0000; border-left:0px;border-right:1px solid #FFF;color:#ff0000; width:10%;margin-bottom:10px">Días sin Servicio</td>'.
                        '</tr>';
              $j = 0;
              $j = sizeof($accion['ACCIADO']) + 1;
            

          }
          $tam = strlen($accion['ORDENCOR_ORC_NUM']);
          $tam1 = strlen(number_format($accion['H_CAL_MONT'],2,'.',''));
          $tam2 = strlen(number_format($accion['H_NW_SALD'],2,'.',''));
          $tam3 = strlen($accion['reconexion']['service']);
          $tam4 = strlen($accion['cartera']);
          $orc = $accion['ORDENCOR_ORC_NUM'];
          $monto = number_format($accion['H_CAL_MONT'],2,'.','');
          $monto1 = number_format($accion['H_NW_SALD'],2,'.','');
          $service = $accion['reconexion']['service'];
          $cartera =  $accion['cartera'];
          for ($i=$tam; $i < 10; $i++) {
            $orc = "&nbsp;".$orc;
          }
          switch ($tam1) {
            case 4:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 5:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 6:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 7:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
          }

          switch ($tam2) {
            case 4:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 5:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 6:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 7:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
          }

          switch ($tam4) {
            case 6:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 9:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;";
              break;
          }

          switch ($tam3) {
            case 0:
              $service = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 5:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 6:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
              break;
            case 7:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $service = $service."&nbsp;&nbsp;&nbsp;";
              break;
          }

          if($accion['orden_corte']['ORC_DESC'] == 'ACTIVA'){
            $btn = '&nbsp;<span style="background:#0F0;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else if($accion['orden_corte']['ORC_DESC'] == 'CERRADA'){
            $btn = '&nbsp;<span style="background:#FF0;border:1px solid" >&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else {
            $btn = '&nbsp;<span style="background:#F00;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          }

          $html .= '<tr style="background:#aaddec;">'.
                   '<td colspan="9" style="border:1px solid;padding-top:7px;font-size:11px !important;padding-left:5px;color:#296fb7">'.
                      '<span>O/C. Nro.</span><span style="background:#FFF">'.$accion['ORDENCOR_OC_OFI'].'</span> <span style="background:#FFF"> '.$accion['ORDENCOR_OC_AGE'].' </span>   &nbsp; <span style="background:#FFF">&nbsp;&nbsp;&nbsp;&nbsp;'.$orc.'</span> '.$btn.
                      '<span>F.Emisión: </span><span style="background:#FFF">'.$accion['orden_corte']['ORC_FECH'].'</span> <span>F. Cierre: </span><span style="background:#FFF">'.(($accion['orden_corte']['ORC_STFECH'] == NULL ) ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : $accion['orden_corte']['ORC_STFECH']).'</span>'.
                      ' <span>Tarifa: </span><span style="background:#FFF">'.$accion['H_TARIFA'].'&nbsp;&nbsp;</span>'.
                      ' <span>Deuda de Corte </span><span style="background:#FFF;">'.$monto.'</span>'.
                      ' <span>Saldo Actual </span><span style="background:#FFF;">'.$monto1.'</span>'.
                      ' <span> Service </span><span style="background:#FFF">'.$service.'</span>'.
                      ' <span> Ciclo: </span><span style="background:#FFF">'.$accion['orden_corte']['FACCICCOD'].'</span>'.
                      ' <span> Cartera: </span><span style="background:#FFF">'.$cartera.'</span>'.
                   '</td>'.
                   '</tr>';


          foreach ($accion['ACCIADO'] as $valor) {
            $html .= '<tr>'.
                      '<td style="font-size:10.5px !important">'.$valor['DONEFECH'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['DONEHORA'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['nivel'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$valor['OBSERVACION'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$accion['reconexion']['REA_CAB_REA_OFI'].' '.$accion['reconexion']['REA_CAB_REA_AGE'].' '.$accion['reconexion']['REA_CAB_REA_NRO'].'</td>'.
                      '<td style="font-size:10.5px !important">'.$accion['reconexion']['OBS_DETA'].'</td>'.
                      '<td style="font-size:10.5px !important">'.(($accion['reconexion']['REA_FOB'] != NULL) ? $accion['reconexion']['REA_FOB'] : " / /" ).' '.(($accion['reconexion']['REA_HOB'] != "00:00:00") ? $accion['reconexion']['REA_HOB']  : "").'</td>'.
                      '<td></td>';
            $direrencia = $this->dateDiff((substr($valor['DONEFECH'],6,4).'-'.substr($valor['DONEFECH'],3,2).'-'.substr($valor['DONEFECH'],0,2)),(substr($accion['reconexion']['REA_FOB'],6,4)."-".substr($accion['reconexion']['REA_FOB'],3,2).'-'.substr($accion['reconexion']['REA_FOB'],0,2)));

              $html .= '<td style="font-size:10.5px !important;text-align:center">'.(($direrencia < 0 ) ? "0" : $direrencia) .'</td>'.
                     '</tr>';
          }
        }
        if($j < 19){
          $html .= "</table>";
          $html .= "<h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        } else {
          $html .= "<h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        }


        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit;
  }*/
    #función para imprimir acciones de manera detallada
    public function imprimir_acciones2($suministro){
      $user = $this->Cuentas_corrientes_model->get_user_name($suministro);
      if($user== NULL){
        $user = $this->Cuentas_corrientes_model->get_user_name(substr($suministro,0,3).'0000'.substr($suministro,3,4));
      }
      $acciones = $this->Cuentas_corrientes_model->get_acciones_coercitivas($suministro);
      foreach ($acciones as $key => $accion) {
        $valor1 = $this->Cuentas_corrientes_model->get_orden_corte($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM']);
        $valor2 = $this->Cuentas_corrientes_model->get_acciones_reconexion($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $valor = $this->Cuentas_corrientes_model->get_acciadd($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $valor3 = $this->Cuentas_corrientes_model->get_recibos_x_corte2($accion['ORDENCOR_OC_OFI'],$accion['ORDENCOR_OC_AGE'],$accion['ORDENCOR_ORC_NUM'],$suministro);
        $acciones[$key]['orden_corte'] = $valor1;
        $acciones[$key]['ACCIADO'] = $valor;
        $acciones[$key]['reconexion'] = $valor2;
        $acciones[$key]['recibos'] = $valor3;
      }
      foreach ($acciones as $key => $accion) {
        if($accion['ACCIADO'] != NULL){
          foreach ($accion['ACCIADO'] as $key2 => $valor7) {
            $niveles = $this->Cuentas_corrientes_model->get_nivel_corte($valor7['PNIVELCO_NIV_CODI']);
            $observacion = $this->Cuentas_corrientes_model->get_observacion_corte1($valor7['TOBSERVA_OBS_CODI']);
            $detalle_deuda = $this->Cuentas_corrientes_model->get_recibos_x_corte2($valor7['TCORTADO_ORDENCOR_OC_OFI'],$valor7['TCORTADO_ORDENCOR_OC_AGE'],$valor7['TCORTADO_ORDENCOR_ORC_NUM'],$valor7['TCORTADO_CLIUNICOD']);
            $accion['ACCIADO'][$key2]['nivel'] = $niveles;
            $accion['ACCIADO'][$key2]['OBSERVACION'] = $observacion;
            $accion['ACCIADO'][$key2]['deuda'] = $detalle_deuda;;
          }
        }

        if($accion['reconexion'] != NULL){
          $service = $this->Cuentas_corrientes_model->get_service1($accion['reconexion']['REA_CRT']);
          $cab_fecha = $this->Cuentas_corrientes_model->get_fecha_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $cab_hora = $this->Cuentas_corrientes_model->get_hora_cab($accion['reconexion']['REA_CAB_REA_OFI'],$accion['reconexion']['REA_CAB_REA_AGE'],$accion['reconexion']['REA_CAB_REA_NRO']);
          $obs = $this->Cuentas_corrientes_model->get_observacion_corte1($accion['reconexion']['REA_OBR']);
          $accion['reconexion']['service'] = $service;
          $accion['reconexion']['REA_FEC'] = $cab_fecha;
          $accion['reconexion']['REA_HRA'] = $cab_hora;
          $accion['reconexion']['OBS_DETA'] = $obs;
        }
        $valor1 = $this->Cuentas_corrientes_model->get_cartera($accion['orden_corte']['TACCORTE_ACC_CODIGO']);
        $acciones[$key]['cartera'] = $valor1;
        $acciones[$key]['ACCIADO'] = $accion['ACCIADO'];
        $acciones[$key]['reconexion'] = $accion['reconexion'];

      }
      $this->data['acciones']  = $acciones;
      $this->load->library('ciqrcode');
      $params['data'] = 'IMPRESO POR:  '. $_SESSION['user_nom'].' FECHA: '.date('d/m/Y').' HORA: '.date('H:i:s');
      $params['level'] = 'H';
      $params['size'] = 1;
      $params['savename'] = FCPATH.'tes.png';
      $this->ciqrcode->generate($params);
      $this->load->library('pdf');
      $mpdf = $this->pdf->load('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);

      $mpdf->SetHTMLHeader('<table width="100%" style="font-size:12px">'.
                          '<tr>'.
                             '<td style="text-align:left;width:33%"><b>SEDALIB S.A.</b></td>'.
                             '<td style="width:15%"></td><td style="text-align:right;width:33%"><b>FECHA: </b>'.date('d/m/y').'</td>'.
                           '</tr><tr>'.
                             '<td rowspan="2"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                             '<td style="text-align:center;font-size:14px;color:#296fb7;width:50%"><b>ACCIONES DE CORTE Y REPOSICIÓN EJECUTADAS EN CAMPO</b></td>'.
                             '<td style="text-align:right"><b>HORA: </b>'.date('H:i:s').'</td>'.
                           '</tr><tr>'.
                             '<td></td>'.
                             '<td style="text-align:right"><b>Página: </b>{PAGENO}</td>'.
                             '</tr></table>');
        $mpdf->AddPage('L');
        $html = '<br><br><table width="100%">'.
             '<tr>'.
                '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
              '</tr><tr>'.
                '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
              '</tr></table>';
         $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                  '<tr>'.
                      '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                      '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                      '<td></td>'.
                  '</tr>'.
                  '<tr>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                    '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a; width:10%;margin-bottom:10px">Reaperturado por</td>'.
                  '</tr>';
        $j = 0;
        $i = 0;
        foreach($acciones as $accion){
          $j = $j + 1;
          $j = $j + sizeof($accion['ACCIADO']);
          if(sizeof($accion['recibos']) > 0 ){
            $j = $j + 1;
            $j = $j + sizeof($accion['recibos']);
          }
          if($j >= 22 ){
            $html .= "</table>";
            $mpdf->WriteHTML($html);
              $mpdf->AddPage('L');
              $html = "";
              $html = '<br><br><table width="100%">'.
                   '<tr>'.
                      '<td style="font-size:11px !important"><b style="font-size:10px !important">Cliente: '.$suministro.' &nbsp;&nbsp; '.$user['CLINOMBRE'].'</b> </td>'.
                    '</tr><tr>'.
                      '<td style="font-size:11px"><b style="font-size:10px !important">Dirección: '.$user['URBDES'].' - '.$user['CALDES'].' '.$user['CLIMUNNRO'].'</td>'.
                    '</tr></table>';
               $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0px 8px">'.
                        '<tr>'.
                            '<td colspan="3" style="text-align:center;color:#8448c1;"><b>ACCION COERCITIVA</b></td>'.
                            '<td colspan="5" style="text-align:center;color:#00a65a;"><b>REAPERTURA DEL SERVICIO SEGUN ACCION DE CORTE</b></td>'.
                            '<td></td>'.
                        '</tr>'.
                        '<tr>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Fecha/Hra Acción</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Nivel</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #8448c1; border-left:0px;border-right:1px solid #FFF;color:#8448c1;width:11.00% ">Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25% ">Nº.O/Reapertura</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Generación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.25%">Observacion</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.75% ">Fecha/Hra. Observación</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a;width:11.00% ">Glosa</td>'.
                          '<td style="font-size:10.5px !important;padding-top:8px;text-align:center;border: 1px solid #00a65a; border-left:0px;border-right:1px solid #FFF;color:#00a65a; width:10%;margin-bottom:10px">Reaperturado por</td>'.
                        '</tr>';
              $j = 0;
              $j = $j + sizeof($accion['ACCIADO']);
              if(sizeof($accion['recibos']) > 0 ){
                $j = $j + 1;
                $j = $j + sizeof($accion['recibos']);
              }
            

          }



          $tam = strlen($accion['ORDENCOR_ORC_NUM']);
          $tam1 = strlen(number_format($accion['H_CAL_MONT'],2,'.',''));
          $tam2 = strlen(number_format($accion['H_NW_SALD'],2,'.',''));
          $tam3 = strlen($accion['reconexion']['service']);
          $tam4 = strlen($accion['cartera']);
          $orc = $accion['ORDENCOR_ORC_NUM'];
          $monto = number_format($accion['H_CAL_MONT'],2,'.','');
          $monto1 = number_format($accion['H_NW_SALD'],2,'.','');
          $service = $accion['reconexion']['service'];
          $cartera =  $accion['cartera'];
          for ($i=$tam; $i < 10; $i++) {
            $orc = "&nbsp;".$orc;
          }
          switch ($tam1) {
            case 4:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 5:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 6:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
            case 7:
              $monto = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto;
              break;
          }

          switch ($tam2) {
            case 4:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 5:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 6:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
            case 7:
              $monto1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$monto1;
              break;
          }

          switch ($tam4) {
            case 6:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 9:
              $cartera = $cartera."&nbsp;&nbsp;&nbsp;";
              break;
          }

          switch ($tam3) {
            case 0:
              $service = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 5:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 6:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 7:
              $service = $service."&nbsp;&nbsp;&nbsp;&nbsp;";
              break;
            case 8:
              $service = $service."&nbsp;&nbsp;&nbsp;";
              break;
          }

          if($accion['orden_corte']['ORC_DESC'] == 'ACTIVA'){
            $btn = '&nbsp;<span style="background:#0F0;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else if($accion['orden_corte']['ORC_DESC'] == 'CERRADA'){
            $btn = '&nbsp;<span style="background:#FF0;border:1px solid" >&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          } else {
            $btn = '&nbsp;<span style="background:#F00;border:1px solid">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
          }

          $html .= '<tr style="background:#aaddec;">'.
                   '<td colspan="9" style="border:1px solid;padding-top:7px;font-size:11px !important;padding-left:5px;color:#296fb7">'.
                      '<span>O/C. Nro.</span><span style="background:#FFF">'.$accion['ORDENCOR_OC_OFI'].'</span> <span style="background:#FFF"> '.$accion['ORDENCOR_OC_AGE'].' </span>   &nbsp; <span style="background:#FFF">&nbsp;&nbsp;&nbsp;&nbsp;'.$orc.'</span> '.$btn.
                      '<span>F.Emisión: </span><span style="background:#FFF">'.$accion['orden_corte']['ORC_FECH'].'</span> <span>F. Cierre: </span><span style="background:#FFF">'.(($accion['orden_corte']['ORC_STFECH'] == NULL ) ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : $accion['orden_corte']['ORC_STFECH']).'</span>'.
                      ' <span>Tarifa: </span><span style="background:#FFF">'.$accion['H_TARIFA'].'&nbsp;&nbsp;</span>'.
                      ' <span>Deuda de Corte </span><span style="background:#FFF;">'.$monto.'</span>'.
                      ' <span>Saldo Actual </span><span style="background:#FFF;">'.$monto1.'</span>'.
                      ' <span> Service </span><span style="background:#FFF">'.$service.'</span>'.
                      ' <span> Ciclo: </span><span style="background:#FFF">'.$accion['orden_corte']['FACCICCOD'].'</span>'.
                      ' <span> Cartera: </span><span style="background:#FFF">'.$cartera.'</span>'.
                   '</td>'.
                   '</tr>';
          $valor2 = sizeof($accion['ACCIADO']);
          $k = 0;
          foreach ($accion['ACCIADO'] as $valor) {
            $k++;
            if($k == $valor2){
              $html .= '<tr>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #8448c1;border-right:1px solid #FFF">'.$valor['DONEFECH'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #8448c1;border-right:1px solid #FFF">'.$valor['DONEHORA'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #8448c1;border-right:1px solid #FFF">'.$valor['nivel'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$valor['OBSERVACION'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$accion['reconexion']['REA_CAB_REA_OFI'].' '.$accion['reconexion']['REA_CAB_REA_AGE'].' '.$accion['reconexion']['REA_CAB_REA_NRO'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$accion['reconexion']['OBS_DETA'].'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.(($accion['reconexion']['REA_FOB'] != NULL) ? $accion['reconexion']['REA_FOB'] : " / /" ).' '.(($accion['reconexion']['REA_HOB'] != "00:00:00") ? $accion['reconexion']['REA_HOB']  : "").'</td>'.
                        '<td style="font-size:10.5px !important;border-bottom:1px solid #00a65a;border-right:1px solid #FFF"></td>';

                $html .= '<td style="font-size:10.5px !important;text-align:center;border-bottom:1px solid #00a65a;border-right:1px solid #FFF">'.$accion['reconexion']['service'].'</td>'.
                       '</tr>';
            } else {
              $html .= '<tr>'.
                        '<td style="font-size:10.5px !important">'.$valor['DONEFECH'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$valor['DONEHORA'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$valor['nivel'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$valor['OBSERVACION'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$accion['reconexion']['REA_CAB_REA_OFI'].' '.$accion['reconexion']['REA_CAB_REA_AGE'].' '.$accion['reconexion']['REA_CAB_REA_NRO'].'</td>'.
                        '<td style="font-size:10.5px !important">'.$accion['reconexion']['OBS_DETA'].'</td>'.
                        '<td style="font-size:10.5px !important">'.(($accion['reconexion']['REA_FOB'] != NULL) ? $accion['reconexion']['REA_FOB'] : " / /" ).' '.(($accion['reconexion']['REA_HOB'] != "00:00:00") ? $accion['reconexion']['REA_HOB']  : "").'</td>'.
                        '<td></td>';
              $html .= '<td style="font-size:10.5px !important;text-align:center">'.$accion['reconexion']['service'] .'</td>'.
                       '</tr>';
            }


          }
          if(sizeof($accion['recibos']) > 0 ){
            $html .= '<tr>'.
                      '<td></td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF;text-align:center;width:10%">Item</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Recibo</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">F. Emisión</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Regularización</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Est.</td>'.
                      '<td style="font-size:10px !important;border-bottom:1px solid ;border-right:1px solid #FFF">Saldo</td>'.
                      '<td></td>'.
                      '<td></td>'.
                     '</tr>';
          }
          $LL = 1;
          foreach ($accion['recibos'] as $valor1) {
            $html .= '<tr>'.
                      '<td></td>'.
                      '<td style="font-size:10px !important;text-align:center">'.$LL.'</td>'.
                      '<td style="font-size:10px !important;">'.$valor1['FACSERNRO'].' &nbsp;&nbsp; '.$valor1['FACNRO'].'</td>'.
                      '<td style="font-size:10px important;">'.(($valor1['FACEMIFEC'] != NULL) ? $valor1['FACEMIFEC'] : " / / ").'</td>'.
                      '<td style="font-size:10px !important;">'.(($valor1['NW_FECHA'] != NULL) ? $valor1['NW_FECHA'] : " / / ").'</td>'.
                      '<td style="font-size:10px !important;">'.$valor1['NW_ST'].'</td>'.
                      '<td style="font-size:10px !important;">'.number_format($valor1['NW_SALDO'],2,'.','').'</td>'.
                     '</tr>';
            $LL++;
          }

        }
       /* if($j < 19){
          $html .= "</table>";
          $html .= "<h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        } else {*/
          $html .= "</table><h3 style='border:1px solid;font-size:11.5px !important;padding:6px'>&nbsp;&nbsp;&nbsp;<span style='background:#F00;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;Orden de Corte Anulada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#FF0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Cerrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
                   "&nbsp;&nbsp;&nbsp;<span style='background:#0F0;border:1px solid'>&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp; Orden de Corte Activa; genera orden de reconexion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>";
          $mpdf->WriteHTML($html);
        //}


        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        exit;
    }


   

    #funcion para guardar la ampliaciones
    public function ampliacion_recibo(){
      $ajax =  $this->input->get('ajax');
      if($ajax ==  true){
        $suministro = $this->input->post('suministro');
        $json = array('result' => true, 'mensaje' => 'OK','suministro'=>$suministro);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }else {
        $json =  array('result' =>  true, 'mensaje' => 'OCURRIO UN ERROR, NO SE PUEDE REALIZAR LA OPERACIÓN');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

   



}
