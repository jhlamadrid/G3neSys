<?php

class Facturas_Boletas_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('acceso/Perfil_model');
        $this->load->model('acceso/Cargo_model');
        $this->load->model('boleta_factura/Comprobante_pago_model');//Oskar
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);

        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Boletas y Facturas';
        $this->data['menu']['padre'] = 'comprobantes';
        $this->data['menu']['hijo'] = 'boletas_facturas';
    }
    
    public function cobranza_facturas_boletas(){
        $this->data['view'] = 'cobranza/Facturas_Boletas_view';
        $this->data['breadcrumbs'] = array(array('Cobranza', ''),array('Recibos',''));
        $this->load->view('template/Master', $this->data);
    }
    

    
}