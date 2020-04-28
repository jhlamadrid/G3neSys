<?php

class Actividades_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('permisos/Actividades_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO";
        $this->mensaje_vacio = "ALERTA: 999 \n No se encontraron datos disponibles para la solicitud";
        $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS.";
        $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO";
        $this->mensaje_create =  "ALERTA: 582 \n NO SE PUDO CREAR EL REGISTRO ENVIADO";
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['permiso'] = $this->Actividades_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'admin_actividades');
        if($this->data['permiso']){
          $this->data['proceso'] = $this->data['permiso']['ACTIVINOMB'];
          $this->data['id_actividad'] = $this->data['permiso']['ID_ACTIV'];
          $this->data['menu']['padre'] =  $this->data['permiso']['MENUGENPDR'];
          $this->data['menu']['hijo'] =  $this->data['permiso']['ACTIVIHJO'];
        } else {
          $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
          redirect($this->config->item('ip').'inicio');
          return;
        }

    }

    public function listar_actividades(){
      $permiso = $this->Actividades_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'admin_actividades');
      if($permiso){
        $menus = $this->Actividades_model->get_all_menus();
        foreach ($menus as $key => $menu) {
          $actividades = $this->Actividades_model->get_all_actividades($menu['ID_MENUGEN']);
          $menus[$key]['actividades'] = $actividades;
        }
        $this->data['actividades'] = $menus;
        $this->data['view'] = 'permisos/Actividades_view';
        $this->data['breadcrumbs'] = array(array('Administracion Actividades', ''));
        $this->load->view('template/Master', $this->data);
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect($this->config->item('ip').'inicio');
        return;
      }
    }

    public function crear_actividad(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $tipo = $this->input->post('tipo');
        if($tipo == 1){
          $menu = $this->input->post('menu');
          $actividad = $this->input->post('actividad');
          $resp = $this->Actividades_model->save_actividad($menu,$actividad);
          if($resp) {
            $json = array('result' => true, 'mensaje' => 'OK');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json = array('result' => false, 'mensaje' => $this->mensaje_create);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else if($tipo == 2){
          $actividad = $this->input->post('actividad');
          $resp = $this->Actividades_model->save_actividad1($actividad);
          if($resp) {
            $json = array('result' => true, 'mensaje' => 'OK');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json = array('result' => false, 'mensaje' => $this->mensaje_create);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function editar_actividad(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $id = $this->input->post('id');
        $actividad = $this->Actividades_model->get_one_actividad($id);
        $cuerpo_actividad = '<div class="row"><div class="col-md-6">
            <div class="form-group">
              NOMBRE <span class="text-red">*</span>
              <input type="text" class="form-control" id="edit_nombre" value="'.$actividad['ACTIVINOMB'].'">
            </div>
          </div>
          <div class="col-md-6">
            <span id="edit_id_actividad" style="display:none">'.(intval($actividad['ID_ACTIV'])*329).'</span>
            <div class="form-group">
              DESCRIPCIÓN <span class="text-red">*</span>
              <input type="text" class="form-control" id="edit_descripcion" value="'.$actividad['ACTIVDESC'].'">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              ABREVIATURA <span class="text-red">*</span>
              <input type="text" class="form-control" id="edit_abreviatura" value="'.$actividad['ACTIVIABRV'].'">
            </div>
          </div>
          <div class="col-md-6">
            <a class="btn btn-primary" onclick="$(\'#iconos\').modal(\'show\');tipo = 3"> CAMBIAR ICONO <span class="text-red">*</span></a>
            <a class="btn pull-right"><i class="'.$actividad['ACTIVIICON'].'" id=\'icono_seleccionado2\' nombre="'.$actividad['ACTIVIICON'].'" aria-hidden="true"></i></a>
          </div>
        </div>';
        if($actividad){
          $json = array('result' => true, 'mensaje' => 'OK','actividad' => $cuerpo_actividad);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => $this->mensaje_vacio);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function actualizar_actividad(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $id = intval($this->input->post('id'))/329;
        $nombre = $this->input->post('nombre');
        $abreviatura = $this->input->post('abreviatura');
        $icono = $this->input->post('icono');
        $desripcion = $this->input->post('descripcion');
        $rep = $this->Actividades_model->update_actividad($id,$nombre,$abreviatura,$icono,$desripcion);
        if($rep){
          $json = array('result' => true, 'mensaje' => $this->mensaje_actualizar);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => $this->mensaje_error_actualizar);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

}
