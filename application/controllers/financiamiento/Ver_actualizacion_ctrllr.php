<?php

class Ver_actualizacion_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['AUT_FINA'] = 'AUT_FINANCIA';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['AUT_FINA'] );
        if(count($permiso)>0){
            $this->data['proceso'] = 'Financiamiento';
            $this->data['menu']['padre'] = 'FINANCIAMIENTO';
            $this->data['menu']['hijo'] = 'AUT_FINA';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }
    
    public function ver_autorizacion(){
        $this->data['AUT_FINA'] = 'AUT_FINANCIA';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['AUT_FINA']);
        if(count($permiso)>0){
            $this->data['proceso'] = 'LISTA DE PERMISOS PARA EXTORNAR';
            $this->data['titulo'] = 'FINANCIAMIENTOS A EXTORNAR';
            $this->data['menu']['hijo'] = 'AUT_FINA';
            $this->data['datos_user'] = $this->Financiamiento_model->Lista_a_extornar();
            
            $this->data['view'] = 'Financiamiento/Lista_extorno_view';
            $this->data['breadcrumbs'] = array(array('ver_pagos', 'autoriza/extorno/recibo'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function mostrar_pago($oficina, $agencia, $num_credito, $tipo){
        $this->data['AUT_FINA'] = 'AUT_FINANCIA';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['AUT_FINA'] );
        if(count($permiso) > 0){
            //echo "hola mundo ";
            $tipo =2;
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

    public  function extorno_pago(){
        //var_dump("hola mundo ");
        //exit();
        $this->data['AUT_FINA'] = 'AUT_FINANCIA';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['AUT_FINA'] );
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
                redirect($this->config->item('ip')  . 'financiamiento/autorizacion/ver_autoriza');
            }else{

            }
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return; 
        }
    }
    
}