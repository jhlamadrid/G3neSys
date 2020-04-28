<?php

class Administracion_Cajeras_ctrllr extends CI_Controller {
   public function __construct() {
      parent::__construct();
      $this->load->model('cobranza/Administracion_Cajeras_model'); 
      $this->load->library('session');
      $this->load->library('acceso_cls');
      $this->acceso_cls->isLogin();
      $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
      $this->data['actividad'] = 'admin_cajeras'; 
      $this->data['rol'] = $this->Administracion_Cajeras_model->get_rol($_SESSION['user_id']); 
      $this->data['userdata'] = $this->acceso_cls->get_userdata();
      $permiso = $this->Administracion_Cajeras_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
      if($permiso){ 
         $this->data['proceso'] = $permiso['ACTIVINOMB'];  
         $this->data['id_actividad'] = $permiso['ID_ACTIV']; 
         $this->data['menu']['padre'] =  $permiso['MENUGENPDR']; 
         $this->data['menu']['hijo'] =  $permiso['ACTIVIHJO']; 
      } else { 
         $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
         redirect($this->config->item('ip').'inicio');
         return;
      } 
   }
    
   public function inicio(){
      $permiso = $this->Administracion_Cajeras_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
      if($permiso){
         $opcion = $this->Administracion_Cajeras_model->get_opcion_individual('CAMBIAR_OFICINA'); 
         $this->data['cambiar_localidad'] = $this->Administracion_Cajeras_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
         $this->data['cajeras'] = $this->Administracion_Cajeras_model->get_cajeras();
         $this->data['oficinas'] = $this->Administracion_Cajeras_model->get_oficinas();
         $this->data['view'] = 'cobranza/Administrar_cajeras_view';
         $this->data['breadcrumbs'] = array(array('Cobranza', ''),array('Recibos',''));
         $this->load->view('template/Master', $this->data);
      } else {
         $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
         redirect($this->config->item('ip').'inicio');
         return;
      }
   }
    
   public function update_cajera(){
      $permiso = $this->Administracion_Cajeras_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
      if($permiso){
         $opcion = $this->Administracion_Cajeras_model->get_opcion_individual('CAMBIAR_OFICINA');  
         $acceso = $this->Administracion_Cajeras_model->ver_opcion($this->data['rol'],$opcion,$this->data['id_actividad']); 
         if($acceso){
            $cajera = $this->input->post('cajera');
            $oficina = $this->input->post('oficina');
            $resp = $this->Administracion_Cajeras_model->actualizar_cajera($cajera,$oficina);
            if($resp){
               $json = array('result' => true, 'mensaje' => 'ok');
               header('Access-Control-Allow-Origin: *');
               header('Content-Type: application/x-json; charset=utf-8');
               echo json_encode($json);
            } else {
               $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error_actualizar'));
               header('Access-Control-Allow-Origin: *');
               header('Content-Type: application/x-json; charset=utf-8');
               echo json_encode($json);
            }
         } else {
            $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
         }
      } else {
         $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
         header('Access-Control-Allow-Origin: *');
         header('Content-Type: application/x-json; charset=utf-8');
         echo json_encode($json);
      }
   }
}