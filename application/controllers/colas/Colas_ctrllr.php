<?php
class Colas_ctrllr extends CI_Controller {
  	public function __construct() { 
    	parent::__construct();
    	$this->load->model('colas/Colas_model'); 
		$this->load->library('session'); 
		$this->load->library('acceso_cls'); 
		$this->data['actividad'] = 'reporte'; 
		$this->data['rol'] = $this->Colas_model->get_rol($_SESSION['user_id']); 
		$this->acceso_cls->isLogin(); 
		$this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
		$this->data['userdata'] = $this->acceso_cls->get_userdata(); 
		$permiso = $this->Colas_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']); 
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

    public function inicio(){
        $permiso = $this->Colas_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
    	if($permiso){
            $this->data['view'] = 'colas/Reporte_view';
			$this->data['breadcrumbs'] = array(array('Reporte de Colas', ''));
			$this->load->view('template/Master', $this->data);
        } else{
            $this->session->set_flashdata('mensaje', array('danger', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
        }
    }
}