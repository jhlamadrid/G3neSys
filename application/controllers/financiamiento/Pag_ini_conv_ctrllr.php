<?php

class Pag_ini_conv_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->model('general/Catalogo_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['Inicial_Convenio'] = 'Inicial_Convenio';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['Inicial_Convenio'] );
        if(count($permiso)>0){
            $this->data['proceso'] = 'PAGAR LA INICIAL DE UN CONVENIO';
            $this->data['titulo'] = 'INICIAL DE CONVENIO';
            $this->data['menu']['padre'] = 'comprobantes';
            $this->data['menu']['hijo'] = 'Inicial_Convenio';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function lista(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso) > 0){
            $this->data['view'] = 'Financiamiento/Pagar_ini_conv_view';
            $this->data['comprobantes'] = $this->Financiamiento_model->get_all_proforma();
            $this->data['pagados'] = $this->Financiamiento_model->get_all_pagados();
            $this->data['breadcrumbs'] = array(array('Pagar Inicial', 'financiamiento/pagar/ini_conv'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function mostrar_pago($oficina, $agencia, $num_credito,$tipo){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso) > 0){
            //echo "hola mundo ";
            $this->data['view'] = 'Financiamiento/Datos_pago_view';
            $this->data['datos_user'] = $this->Financiamiento_model->get_pago_inicial($oficina, $agencia, $num_credito);
            $this->data['tipo_pago'] = $tipo;
            $this->data['breadcrumbs'] = array(array('Lista de pagos', 'financiamiento/pagar/ini_conv'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function ver_pago($oficina, $agencia, $num_credito){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso) > 0){
            $this->data['view'] = 'Financiamiento/ver_pago_view';
            $this->data['datos_user'] = $this->Financiamiento_model->get_pago_inicial($oficina, $agencia, $num_credito);
            $this->data['breadcrumbs'] = array(array('Lista de pagos', 'financiamiento/pagar/ini_conv'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function relizo_pago(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso) > 0){
            if($this->input->server('REQUEST_METHOD') != 'POST'){
                $this->session->set_flashdata('mensaje', array('error', 'Error al acceder a la ruta'));
                redirect($this->config->item('ip').'inicio');
                return;
            }
            $aux = $this->input->post('arreglo_pago');
            $datos_pago = json_decode($aux, true);
            $respuesta = $this->Financiamiento_model->realizar_pago_inicial($datos_pago[0], $datos_pago[1], $datos_pago[2]);
            if($respuesta[0] == true){
                $this->session->set_flashdata('respuesta', array('mensaje', 'PAGO REALIZADO'));
                redirect($this->config->item('ip')  . 'financiamiento/ver_pago/'.$datos_pago[0].'/'.$datos_pago[1].'/'.$datos_pago[2]);
            }else{
                $this->session->set_flashdata('respuesta', array('error', 'Hubo un problema interno. '));
                redirect($this->config->item('ip')  . 'inicio');
            }
            
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public  function extorno_pago(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso)>0){
            if($this->input->server('REQUEST_METHOD') != 'POST'){
                $this->session->set_flashdata('mensaje', array('error', 'Error al acceder a la ruta'));
                redirect($this->config->item('ip').'inicio');
                return;
            }
            $aux = $this->input->post('arreglo_pago');
            $datos_pago = json_decode($aux, true);
            $respuesta = $this->Financiamiento_model->extorno_pago_inicial($datos_pago[0], $datos_pago[1], $datos_pago[2]);
            if($respuesta[0] == true){
                $this->session->set_flashdata('respuesta', array('mensaje', 'EXTORNO REALIZADO'));
                redirect($this->config->item('ip')  . 'financiamiento/ver_pago/'.$datos_pago[0].'/'.$datos_pago[1].'/'.$datos_pago[2]);
            }else{

            }
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return; 
        }
    }

    public function impr_ticket($oficina, $agencia, $numero){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso) > 0){
            $this->load->library('NumberToText');
            $ntt = $this->numbertotext->load(NULL);
            $cab = $this->Financiamiento_model->get_pago_inicial($oficina, $agencia, $numero);  
            $num_amortiza = $this->Financiamiento_model->get_amortiza($oficina, $agencia, $numero);
            $usuario = $this->Catalogo_model->get_usuario($_SESSION['user_id']);
            //$usuario = $this->Catalogo_model->get_usuario($cab[0]['DIGCOD']);  
            $oficina = $this->Catalogo_model->get_regzonloc($_SESSION['NSEMPCOD'], $_SESSION['NSOFICOD']);    
            $letra = $ntt->numtoletras($cab[0]['INICIAL']); 
            $this->load->view("template/Ticket_Financiamiento", array('cab'=>$cab, 'usuario'=>$usuario, 'oficina'=>$oficina, 'total_letra'=>$letra ,'amortiza' =>$num_amortiza[0]['AMONRO']));
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function caso(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso) > 0){
            $this->load->view("template/Ticket_Financiamiento_caso");
            
        }
        
    }
    
    


}
?>