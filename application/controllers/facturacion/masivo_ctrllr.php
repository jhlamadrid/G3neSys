<?php

class masivo_ctrllr extends CI_Controller{
     public function __construct() {
       parent::__construct();
        $this->load->model('acceso/Usuario_model');
        //$this->load->model('acceso/Perfil_model');
        //$this->load->model('acceso/Cargo_model');
        $this->load->model('facturacion/Datos_recibo_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Genera recibo ';
        $this->data['menu']['padre'] = 'atencion_cliente';
        $this->data['menu']['hijo'] = 'genera_recibo';
        $this->direccion_barra = 'assets/recibo/';
    }

    public function ver_masivo(){
        
        $this->data['titulo']="Generar Recibo";
        $this->data['view'] = 'facturacion/masivo_view';
        $this->data['breadcrumbs'] = array(array('Masivo', ''),array('Genera Recibo',''));
        $this->load->view('template/Master', $this->data);
               

    }

}

?>