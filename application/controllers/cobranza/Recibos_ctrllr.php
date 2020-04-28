<?php

class Recibos_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('acceso/Perfil_model');
        $this->load->model('acceso/Cargo_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Cobranza';
        $this->data['menu']['padre'] = 'cobranza';
        $this->data['menu']['hijo'] = 'recibos';
    }
    
    public function cobranza_recibos(){
        $this->data['view'] = 'cobranza/Recibos_view';
        $this->data['breadcrumbs'] = array(array('Cobranza', ''),array('Recibos',''));
        $this->load->view('template/Master', $this->data);
    }
    
}