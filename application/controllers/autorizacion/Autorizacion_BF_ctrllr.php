<?php
class Autorizacion_BF_ctrllr extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('autorizacion/Autorizacion_model');
        $this->load->library('session');
		$this->load->library('acceso_cls');
		$this->data['actividad'] = 'nc_boletas_facturas';
		$this->data['rol'] = $this->Autorizacion_model->get_rol($_SESSION['user_id']); 
				$this->acceso_cls->isLogin();
				$this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $permiso = $this->Autorizacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
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

    public function listar_autorizaciones(){
		$permiso = $this->Autorizacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
		if($permiso){
			$autorizaciones = $this->Autorizacion_model->get_autorizaciones_x_user();
				foreach ($autorizaciones as $key => $aut) {
				$nombre = $this->Autorizacion_model->get_nombre_operador($aut['AUT_OPE']);
				$autorizaciones[$key]['NNOMBRE'] = $nombre;
			}
			$this->data['autorizaciones'] = $autorizaciones;
			$this->data['usuarios'] = $this->Autorizacion_model->get_usuarios();
			$this->data['view'] = 'autorizacion/Autorizacion_BF_view';
			$this->data['breadcrumbs'] = array(array('Autorización nota crédito Boletas y Facturas', ''));
			$this->load->view('template/Master', $this->data);
		} else {
			$this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
		}
    }

    public function buscar_factura_boleta(){
		$permiso = $this->Autorizacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
		if($permiso){
			$ajax = $this->input->get('ajax');
			if($ajax){
			  	$tipo = $this->input->post('tipo');
			  	$serie = $this->input->post('serie');
			  	$numero = $this->input->post('numero');
			  	$resp = $this->Autorizacion_model->seacrh_bf($tipo,$serie,$numero);
			  	$nota = $this->Autorizacion_model->search_notas($tipo,$serie,$numero);
			  	$autorizacion = $this->Autorizacion_model->search_autorizacion($tipo,$serie,$numero);
			  	$monto = $this->Autorizacion_model->get_monto_factura_boleta($tipo,$serie,$numero);
			  	if($resp){
					$json = array('result' => true, 'mensaje' => 'OK','resp' => $resp,'autorizaciones' => $autorizacion, 'monto'=>$monto,'notas' => $nota);
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json);
			  	} else {
					if($tipo == 0) $json = array('result' => false, 'mensaje' => 'No se ecnontro la boleta que está buscando.');
					else $json = array('result' => false, 'mensaje' => 'No se ecnontro la factura que está buscando.');
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

    public function registrar_autorizacion(){
		$permiso = $this->Autorizacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
		if($permiso){
			$ajax = $this->input->get('ajax');
			if($ajax){
			  	$vigencia = $this->input->post('vigencia');
			  	$serie = $this->input->post('serie');
			  	$numero = $this->input->post('numero');
			  	$usuario = $this->input->post('usuario');
			  	$glosa = $this->input->post('glosa');
			  	$tipo = $this->input->post('tipo');
			  	$rep = $this->Autorizacion_model->save_autorizacion($vigencia,$serie,$numero,$usuario,$glosa,$tipo);
			  	if($rep['resultado']){
					$json = array('result' => true, 'mensaje' => $rep['rpta']);
					header('Access-Control-Allow-Origin: *');
					header('Content-Type: application/x-json; charset=utf-8');
					echo json_encode($json);
			  	} else {
					$json = array('result' => false, 'mensaje' => $rep['rpta']);
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
}
