<?php
class Afiliados_ctrllr extends CI_Controller{
     
    public function __construct() {
       parent::__construct();
        //$this->load->model('acceso/Usuario_model');
        //$this->load->model('acceso/Perfil_model');
        //$this->load->model('acceso/Cargo_model');
        $this->load->model('Atencion_al_cliente/Afiliados_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Total de Afiliados';
        $this->data['menu']['padre'] = 'atencion_cliente';
        $this->data['menu']['hijo'] = 'ver_afiliados';
     }
    
    public function total_afiliado(){
        $variable = 0;
        foreach($_SESSION['ACTIVIDADES'] as $GRP1){ 
            if($GRP1['MENUGENDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'RECIBO'){
                $this->data['afiliados'] = $this->Afiliados_model->get_afiliados();
                $this->data['titulo']="Total de Afiliados";
                $this->data['view'] = 'Atencion_al_cliente/Afiliados_view';
                $this->data['breadcrumbs'] = array(array('Atencion al cliente', ''),array('Total Afiliados',''));
                $this->load->view('template/Master', $this->data);
                $variable = 1;
                break;
            }
        }
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }
}
?>