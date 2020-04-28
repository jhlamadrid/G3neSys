<?php

class Sugerencias_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('manager_sic/Sugerencias_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Sugerencias';
        $this->data['menu']['padre'] = 'manager_sic';
        $this->data['menu']['hijo'] = 'sugerencias';
    }

    public function administrador_sugerencias(){
      $variable = 0;
      foreach($_SESSION['ACTIVIDADES'] as $GRP1){
          if($GRP1['MENUGENDESC'] == 'MANAGER_SIC' && $GRP1['ACTIVDESC'] == 'SUGERENCIAS'){
            $this->data['sugerencias'] = $this->Sugerencias_model->get_sugerencias();
            $this->data['view'] = 'sugerencias/Sugerencias_view';
            $this->data['breadcrumbs'] = array(array('Sugerencias', ''));
            $this->load->view('template/Master', $this->data);
            $variable = 1;
            break;
          }
        }
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    public function responder($idSugerencia){
      $pathToUploadedFile = "";
      $this->load->library("email");
      $this->load->library('upload');
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        if($_FILES['archivo']['size'] > 0) {
          $aConfig['upload_path']      = FCPATH.'/someUploadDir/';
          $aConfig['allowed_types']    = 'doc|docx|pdf|jpg|png';
          $aConfig['max_size']         = '3000';
          $aConfig['max_width']        = '1280';
          $aConfig['max_height']       = '1024';
          $this->upload->initialize($aConfig);
          if($this->upload->do_upload('archivo')){
            $ret = $this->upload->data();
            $pathToUploadedFile = $ret['full_path'];
          }
      }
      $this->load->library('form_validation');
        #$this->form_validation->set_rules('inputDestinario1','Destinario','required');
        #$this->form_validation->set_rules('inputRemitente','Remitente','required');
        $this->form_validation->set_rules('inputMotivo','Motivo','required');
        $this->form_validation->set_rules('text_manesaje1','Cuerpo','required');
        if($this->form_validation->run() == TRUE){
          $destinatario =  $this->input->post('inputDestinario1');
          $remitente = $this->input->post('inputRemitente');
          $motivo = $this->input->post('inputMotivo');
          $mensaje = $this->input->post('text_manesaje1');
          $mensaje = htmlspecialchars_decode($mensaje);

           $configGmail = array(
             'protocol' => 'smtp',
             'smtp_host' => 'mail.sedalib.com.pe',
             'smtp_port' => 25,
             'smtp_user' => 'sicmoviles@sedalib.com.pe',
             'smtp_pass' => '12345678',
             'mailtype' => 'html',
             'charset' => 'utf-8',
             'newline' => "\r\n"
             );
           $this->email->initialize($configGmail);
           $this->email->from('soporte@sedalib.com.pe');
           $this->email->to($destinatario);
           $this->email->subject($motivo);
           $this->email->message($mensaje);
           $this->email->attach($pathToUploadedFile);
           $this->email->send();
           $this->email->to('jleon@sedalib.com.pe');
           $this->email->send();
          $this->Sugerencias_model->estado_sugerencia($idSugerencia);
          redirect($this->config->item('ip') . 'manager_sic/sugerencias');
           //con esto podemos ver el resultado
           //var_dump($this->email->print_debugger());
        }
        else{
          $this->session->set_flashdata('mensaje', array('error', 'Complete los Campos.'));
          redirect($this->config->item('ip') . 'sugerencias/responder/'.$idSugerencia);
        }
      }
      /*$this->data['userdata'] = $this->acceso_cls->get_userdata($_SESSION['usuario_id']);*/
      $this->data['usr_sugerencia'] = $this->Sugerencias_model->get_usuario($idSugerencia);
      /*$this->data['denuncias_reg'] = $this->Usuario_model->get_five_denuncias();
      $this->data['sugerencias_reg'] = $this->Usuario_model->get_five_sugerencias();*/
      if( $this->data['usr_sugerencia'] == NULL){
        $this->session->set_flashdata('mensaje', array('error', 'SUGERENCIA NO ENCONTRADA'));
        redirect($this->config->item('ip') . 'manager_sic/sugerencias');
      }
      if(trim($this->data['usr_sugerencia']['PTGTTICK_ESTADO']) == "0" || $this->data['usr_sugerencia']['PTGTTICK_ESTADO'] == NULL){
        $this->data['view'] = 'sugerencias/Sugerencia_respuesta_view';
        $this->data['breadcrumbs'] = array(array('Panel Sugerencias','panel_sugerencias'),array('Sugerencias','manager_sic/sugerencias'),array('Responder Sugerencia',''));
        $this->load->view('template/Master',$this->data);
      } else {
        $this->session->set_flashdata('mensaje', array('error', 'LA SUGERENCIA YA HA SIDO ATENDIDA'));
        redirect($this->config->item('ip') . 'manager_sic/sugerencias');
     }
}


}
