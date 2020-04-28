<?php
class Ope_boleta_factura_ctrllr extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('acceso/Usuario_model');
                $this->load->model('boleta_factura/Comprobante_pago_model');
		$this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Boletas y Facturas';
        $this->data['menu']['padre'] = 'Operacional';
        $this->data['menu']['hijo'] = 'Boleta_factura';
	 }

	public function operaciones(){

        $this->data['view'] = 'Operacional/Oper_boleta_factura_view';
        $this->data['titulo'] = 'Operacional Boleta y Factura Operacional';
        $this->data['comprobantes'] = $this->Comprobante_pago_model->get_all_proforma();
        $this->data['breadcrumbs'] = array(array('Operacional', ''),array('Boletas y Facturas',''));
        $this->load->view('template/Master', $this->data);
	}
}
?>