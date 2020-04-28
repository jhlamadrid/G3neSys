<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    /**
    *   CONTROLADOR Respuesta_ctrllr
    *   -------------------------------------------------
    *   Controlador creado para las respuestas a las solicitudes generales y particulares
    *   Creado: JALO (Jhon A. Leon Ortecho)
    *   Fecha: 07/08/2019
    *   
    */

    class Respuesta_ctrllr extends CI_Controller{
        
        /**
         * Constructor
         */

        public function __construct() { 

            parent::__construct();
            $this->load->model('reclamo_no_facturacion/Reclamo_no_facturacion_model'); 

            $this->load->library('session');
            $this->load->library('acceso_cls');
            
            // Verificar si tiene acceso al sistema 
            $this->acceso_cls->isLogin();
            $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
            $this->data['userdata'] = $this->acceso_cls->get_userdata(); 
            $this->data['actividad'] = 'respuesta';
            
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']); 
            //$this->Global_model->findRol($_SESSION['userCod']); 
            //$this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['userCod']); 

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
            if($permiso){ 
                $this->data['proceso'] = $permiso['ACTIVINOMB'];  
                $this->data['id_actividad'] = $permiso['ID_ACTIV']; 
                $this->data['menu']['padre'] =  $permiso['MENUGENPDR'];  
                $this->data['menu']['hijo'] =  $permiso['ACTIVIHJO']; 
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function inicio(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->data['reclamos'] = $this->Reclamo_no_facturacion_model->getReclamosList();
                $this->data['view'] = 'reclamo_no_facturacion/Respuesta';
                $this->data['breadcrumbs'] = array(array('Respuestas Solicitudes', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function guardar(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	    if($permiso){
                $ajax = $this->input->get('ajax');
                if($ajax){
                    $EMPCOD = $this->input->post('EMPCOD');
                    $OFICOD = $this->input->post('OFICOD');
                    $ARECOD = $this->input->post('ARECOD');
                    $CTDCOD = $this->input->post('CTDCOD');
                    $DOCCOD = $this->input->post('DOCCOD');
                    $SERNRO = $this->input->post('SERNRO');
                    $RECID = $this->input->post('RECID');
                    $DESC = $this->input->post('desc');
                    $resp = $this->Reclamo_no_facturacion_model->saveRespuesta($EMPCOD, $OFICOD, $ARECOD, 
                                                                                    $CTDCOD, $DOCCOD, $SERNRO,
                                                                                $RECID, $DESC);
                    if($resp){
                        $json = array('res' => true, 'msg' => 'ok'); 
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    } else {
                        $json = array('res' => false, 'msg' => $this->config->item('_mensaje_vacio'));
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
                } else {
                    $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        }
    }