<?php

class Recibos_financiamiento_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['recibos_financiamiento'] = 'Rep_recibo_financiado';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['recibos_financiamiento'] );
        if(count($permiso)>0){
            $this->data['proceso'] = 'Financiamiento';
            $this->data['menu']['padre'] = 'FINANCIAMIENTO';
            $this->data['menu']['hijo'] = 'Rep_recibo_financiado';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function  recibos_financiados(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso)>0){
            $this->data['view'] = 'Financiamiento/Recibos_financiados_view';
            $this->data['breadcrumbs'] = array(array('Recibos Financiados', 'financiamiento/Rep_recibo_financiado'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }


    public function creditos_realizados(){
        $ajax = $this->input->get('ajax');
      if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $fecha_inicio = $this->input->post('inicio');
            $fecha_fin = $this->input->post('fin');
            $resultado  = $this->Financiamiento_model -> get_creditos_recibos($fecha_inicio, $fecha_fin);
            if($resultado){
                $json = array('result' => true, 'respuesta' => $resultado );
                echo json_encode($json);
                return;
            }else{
                $json = array('result' => false);
                echo json_encode($json);
                return;
            }
        }
    }

    public function crear_reporte_recibo_ind($oficina, $agencia, $numero_credito){
        var_dump($oficina);
    }

}

?>