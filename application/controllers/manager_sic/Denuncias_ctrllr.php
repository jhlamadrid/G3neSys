<?php

class Denuncias_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('manager_sic/Denuncias_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Denuncias';
        $this->data['menu']['padre'] = 'manager_sic';
        $this->data['menu']['hijo'] = 'denuncias';
    }

    public function administrador_denuncias(){
      $variable = 0;
      foreach($_SESSION['ACTIVIDADES'] as $GRP1){
          if($GRP1['MENUGENDESC'] == 'MANAGER_SIC' && $GRP1['ACTIVDESC'] == 'DENUNCIAS'){
            $this->data['denuncias'] = $this->Denuncias_model->get_denuncias();
            $this->data['view'] = 'denuncias/Denuncias_view';
            $this->data['breadcrumbs'] = array(array('Denuncias', ''));
            $this->load->view('template/Master', $this->data);
            $variable = 1;
            break;
          }
        }
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    public function get_one_denuncia(){
      $ajax = $this->input->get('ajax');
      $id = $this->input->post('denuncia');
      if($ajax){
        $info_denuncia = $this->Denuncias_model->get_one_denuncia_id($id);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        if($info_denuncia != NULL){
          $json = array('result' => true, 'mensaje' => 'OK','denuncia'=>$info_denuncia);
        } else {
          $json = array('result' => true, 'mensaje' => 'Ocurrió un error no se pudo obtener la denuncia');
        }
         echo json_encode($json);
      } else {
        $this->load->view('errors/html/error_404', $this->data);
      }
    }

  }
