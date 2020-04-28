<?php

class Administracion_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('acceso/Perfil_model');
        $this->load->model('acceso/Cargo_model');
        $this->load->model('cuenta_corriente/Administracion_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Administración de Carteras';
        $this->data['menu']['padre'] = 'cuenta_corriente';
        $this->data['menu']['hijo'] = 'administracion_carteras';
    }
    
    public function administrar_carteras(){
        $this->data['view'] = 'cuenta_corriente/Administracion_carteras_view';
        $this->data['breadcrumbs'] = array(array('Cuenta Corriente', ''),array('Administración de Carteras',''));
        $this->load->view('template/Master', $this->data);
    }
    
}