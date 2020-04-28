<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class Cambiar_Cargo_ctrllr extends CI_Controller{

        public function __construct() { 

            parent::__construct();
            $this->load->model('reclamo_no_facturacion/Reclamo_no_facturacion_model'); 

            $this->load->library('session');
            $this->load->library('acceso_cls');
            // Verificar si tiene acceso al sistema 
            $this->acceso_cls->isLogin();
            $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
            $this->data['userdata'] = $this->acceso_cls->get_userdata(); 
            $this->data['actividad'] = 'CAM_CARGO';
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']);  

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
            if($permiso){ 
                $this->data['proceso'] = $permiso['ACTIVINOMB'];  
                $this->data['id_actividad'] = $permiso['ID_ACTIV']; 
                $this->data['menu']['padre'] =  $permiso['MENUGENPDR'];  
                $this->data['menu']['hijo'] =  $permiso['ACTIVIHJO'];
                
                if($_SESSION['DEPENDENCIA_ORIGEN'] == null){
                    $this->session->set_flashdata('mensaje', array('error', "El usuario no tiene asignada una dependecia motivo por el cual no puede al sistema WorkFlow, comunicarse con el area correspondiente para que le dén los permisos"));
                    redirect($this->config->item('ip').'inicio');
                    return;
                }else{
                    if($_SESSION['SIGLA_AREA'] ==''){
                        $this->session->set_flashdata('mensaje', array('error', "Ocurrio un problema con el area designada, comunicarse con el area correspondiente para que le dén los permisos"));
                        redirect($this->config->item('ip').'inicio');
                        return;
                    }else{
                        if($_SESSION['SIGLA_USUARIO'] == null){
                            $this->session->set_flashdata('mensaje', array('error', "EL usuario no tiene asignada una sigla de documento, comunicarse con el area correspondiente para que le dén los permisos"));
                            redirect($this->config->item('ip').'inicio');
                            return;
                        }
                    }
                } 
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function inicio(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $this->data['usuario_habilitado']  = $this->Documento_model->getUsuario_habilitado();
                $this->data['view'] = 'tramite_Documentario/Cambiar_Cargo_view';
                $this->data['breadcrumbs'] = array(array('Cambiar Cargo', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function listarAreas(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getAreas_x_representante();
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function UpdateUser(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $repre_Anterior = $this->input->post('repre_Anterior');
                $repre_Actual   = $this->input->post('repre_Actual');
                $id_Organigrama = $this->input->post('organigrama');
                $siglas         = $this->input->post('siglas');
                $data = $this->Documento_model->Cambiar_Cargo_usuario($repre_Anterior, $repre_Actual, $id_Organigrama, $siglas);
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function listaUsuarios(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getUsuario_habilitado();
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function getAreaInicial(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $organigrama = $this->input->post('organigrama');
                $codigo = $this->input->post('codigo');
                $tipo_usuario   = $this->input->post('tipo_usuario');
                $data["jefatura"] = $this->Documento_model->getUsuario_jefatura($organigrama, $codigo);
                $data["areas"] = $this->Documento_model->getAreas_jefatura($organigrama);
                
                header('Content-Type: application/json');
                echo json_encode($data);
                
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function setDatosArea(){
            
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $organigrama = $this->input->post('organigrama');
                $sigla = $this->input->post('sigla');
                $idUsuario = $this->input->post('usuario');
                $data  = $this->Documento_model->setDatosArea($organigrama, $sigla, $idUsuario);
                header('Content-Type: application/json');
                echo json_encode($data);
                
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }

        }

    }
?>