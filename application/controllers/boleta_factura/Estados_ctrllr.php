<?php

class Estados_ctrllr extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
        $this->load->library('acceso_cls');
        $this->load->model('boleta_factura/Comprobante_pago_model');
        $this->load->model('general/Catalogo_model');

        
        $this->acceso_cls->isLogin();

        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Estados';

        $this->data['menu']['padre'] = 'comprobantes';
        $this->data['menu']['hijo'] = 'estados';
	}

	public function mostrar_estados(){
		$rol=$this->Catalogo_model->get_rol($_SESSION['user_id']);
        //if( $rol[0]['ID_ROL'] ==10){
            $this->data['titulo'] = 'Estados de  Boleas y Facturas';
            $this->data['view']='boleta_factura/Estados_view';
            $this->data['breadcrumbs'] = array(array('Boletas y facturas ', 'documentos/boletas_facturas'),array('Estado',''));
            //$this->data['conceptos'] = $this->Comprobante_pago_model->get_concep();
            $this->load->view('template/Master', $this->data);
        //}else{
        //    redirect(base_url() . 'inicio');
        //}
			
		
	}

	public function mostrar_reporte_estado(){
		$ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $tipo = $this->input->post('tipo');
        $inicio = $this->input->post('inicio');
        $fin = $this->input->post('fin');
        $result = $this->Comprobante_pago_model->buscar_comprobante_estados($tipo, $inicio, $fin);

        $json = array('result' => true, 'comprobante' => $result);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
	}

}

?>