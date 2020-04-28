<?php

class Opciones_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('permisos/Opciones_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['permiso'] = $this->Opciones_model->get_permiso($_SESSION['user_id'],'admin_opciones');
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

    public function listar_opciones(){
      $permiso = $this->Opciones_model->get_permiso($_SESSION['user_id'],'admin_opciones');
      if($permiso){
        $roles = $this->Opciones_model->get_all_roles();
        $this->data['roles'] = $roles;
        $this->data['view'] = 'permisos/Opciones_view';
        $this->data['breadcrumbs'] = array(array('Administracion Opciones', ''));
        $this->load->view('template/Master', $this->data);
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect($this->config->item('ip').'inicio');
        return;
      }
    }

    public function get_actividades(){
      $permiso = $this->Opciones_model->get_permiso($_SESSION['user_id'],'admin_opciones');
      if($permiso){
         $ajax = $this->input->get('ajax');
         if($ajax){
            $rol = $this->input->post('rol');
            $resp = $this->Opciones_model->get_actividades($rol);
            if($resp){
               $cuerpo = "";
               $cuerpo .= "<option value='-1'>SELECCIONE UNA OPCIÓN</option>";
               foreach ($resp as $act) {
                  $cuerpo .= "<option value='".$act['ID_ACTIV']."'>".$act['ACTIVINOMB']."</option>";
               }
               $json = array('result' => true, 'mensaje' => 'ok', 'actividades' => $cuerpo);
               header('Access-Control-Allow-Origin: *');
               header('Content-Type: application/x-json; charset=utf-8');
               echo json_encode($json);
            } else {
               $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_vacio'));
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

   public function get_procesos(){
      $permiso = $this->Opciones_model->get_permiso($_SESSION['user_id'],'admin_opciones');
      if($permiso){
         $ajax = $this->input->get('ajax');
         if($ajax){
            $rol = $this->input->post('rol');
            $actividad = $this->input->post('actividad');
            $botones = $this->Opciones_model->get_botones($actividad);
            $botones_asignados = $this->Opciones_model->get_botones_asignados($rol,$actividad);
            if($botones){
               $cuerpo = "";
               $cuerpo1 = "";
               $tipo = 'par';
               foreach ($botones as $btn) {
                  $ban = 0;
                  foreach ($botones_asignados as $btn1) {
                     if($btn['ID_BTNGEN'] == $btn1['ID_BTNGEN']){
                        $ban = 1; break;
                     }
                  }
                  if($ban == 0){
                     if($tipo == 'par'){
                        $cuerpo .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista_'.$btn['ID_BTNGEN'].'" >
                                     <div class="row">
                                       <div class="col-md-2 col-sm-2 col-xs-2">
                                         <a class="btn btn-warning"><i class="" aria-hidden="true"></i></a>
                                       </div>
                                       <div class="col-md-5 col-sm-5 col-xs-5">
                                         <span style="text-transform: uppercase;"><b id="nombre_'.$btn['ID_BTNGEN'].'">'.$btn['BTNGENNOMRE'].'</b></span><br>
                                         <span>'.$btn['BTNGENDESC'].'</span>
                                       </div>
                                       <div class="col-md-3 col-sm-3 col-xs-3" style="line-height: 40px;">
                                           <span class="text-red" id="asignar_'.$btn['ID_BTNGEN'].'">SIN ASIGNAR</span>
                                       </div>
                                       <div class="col-md-2 col-sm-2 col-xs-2" style="line-height: 40px;text-align:center">
                                         <a class="btn" style="border: 1px solid" onclick="agregar('.$btn['ID_BTNGEN'].')" id="btn_'.$btn['ID_BTNGEN'].'"><i id="icono_'.$btn['ID_BTNGEN'].'" class="fa fa-plus" aria-hidden="true"></i></a>
                                       </div>
                                     </div>
                                    </li><hr style="height: 1px;background: #337ab7;">'; 
                        $tipo = 'impar';
                     } else {
                        $cuerpo1 .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista_'.$btn['ID_BTNGEN'].'">
                                     <div class="row">
                                       <div class="col-md-2 col-sm-2 col-xs-2">
                                         <a class="btn btn-warning"><i class="" aria-hidden="true"></i></a>
                                       </div>
                                       <div class="col-md-5 col-sm-5 col-xs-5">
                                         <span style="text-transform: uppercase;"><b id="nombre_'.$btn['ID_BTNGEN'].'" >'.$btn['BTNGENNOMRE'].'</b></span><br>
                                         <span>'.$btn['BTNGENDESC'].'</span>
                                       </div>
                                       <div class="col-md-3 col-sm-3 col-xs-3" style="line-height: 40px;">
                                           <span class="text-red" id="asignar_'.$btn['ID_BTNGEN'].'">SIN ASGINAR</span>
                                       </div>
                                       <div class="col-md-2 col-sm-2 col-xs-2" style="line-height: 40px;text-align:center">
                                         <a class="btn" style="border: 1px solid" onclick="agregar('.$btn['ID_BTNGEN'].')" id="btn_'.$btn['ID_BTNGEN'].'"><i id="icono_'.$btn['ID_BTNGEN'].'" class="fa fa-plus" aria-hidden="true"></i></a>
                                       </div>
                                     </div>
                                   </li><hr style="height: 1px;background: #337ab7;">'; 
                        $tipo = 'par';
                     }
                  } else {
                     if($tipo == 'par'){
                        $cuerpo .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista_'.$btn['ID_BTNGEN'].'" class="seleccionado">
                                     <div class="row">
                                       <div class="col-md-2 col-sm-2 col-xs-2">
                                         <a class="btn btn-warning"><i class="" aria-hidden="true"></i></a>
                                       </div>
                                       <div class="col-md-5 col-sm-5 col-xs-5">
                                         <span style="text-transform: uppercase;"><b id="nombre_'.$btn['ID_BTNGEN'].'" >'.$btn['BTNGENNOMRE'].'</b></span><br>
                                         <span>'.$btn['BTNGENDESC'].'</span>
                                       </div>
                                       <div class="col-md-3 col-sm-3 col-xs-3" style="line-height: 40px;">
                                           <span class="text-green" id="asignar_'.$btn['ID_BTNGEN'].'">ASIGNADO</span>
                                       </div>
                                       <div class="col-md-2 col-sm-2 col-xs-2" style="line-height: 40px;text-align:center">
                                         <a class="btn" style="border: 1px solid" onclick="quitar('.$btn['ID_BTNGEN'].')" id="btn_'.$btn['ID_BTNGEN'].'"><i id="icono_'.$btn['ID_BTNGEN'].'" class="fa fa-minus" aria-hidden="true"></i></a>
                                       </div>
                                     </div>
                                    </li><hr style="height: 1px;background: #337ab7;">'; 
                        $tipo = 'impar';
                     } else {
                        $cuerpo1 .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista_'.$btn['ID_BTNGEN'].'" class="seleccionado">
                                     <div class="row">
                                       <div class="col-md-2 col-sm-2 col-xs-2">
                                         <a class="btn btn-warning"><i class="" aria-hidden="true"></i></a>
                                       </div>
                                       <div class="col-md-5 col-sm-5 col-xs-5">
                                         <span style="text-transform: uppercase;"><b id="nombre_'.$btn['ID_BTNGEN'].'">'.$btn['BTNGENNOMRE'].'</b></span><br>
                                         <span>'.$btn['BTNGENDESC'].'</span>
                                       </div>
                                       <div class="col-md-3 col-sm-3 col-xs-3" style="line-height: 40px;">
                                           <span class="text-green" id="asignar_'.$btn['ID_BTNGEN'].'">ASIGNADO</span>
                                       </div>
                                       <div class="col-md-2 col-sm-2 col-xs-2" style="line-height: 40px;text-align:center">
                                         <a class="btn" style="border: 1px solid" onclick="quitar('.$btn['ID_BTNGEN'].')" id="btn_'.$btn['ID_BTNGEN'].'"><i id="icono_'.$btn['ID_BTNGEN'].'" class="fa fa-minus" aria-hidden="true"></i></a>
                                       </div>
                                     </div>
                                    </li><hr style="height: 1px;background: #337ab7;">'; 
                        $tipo = 'par';
                     }
                  }
               }
               $json = array('result' => true, 'mensaje' => 'ok','lista1' => $cuerpo,'lista2' => $cuerpo1);
               header('Access-Control-Allow-Origin: *');
               header('Content-Type: application/x-json; charset=utf-8');
               echo json_encode($json);
            } else {
               $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_vacio'));
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

   public function guardar_botones(){
      $permiso = $this->Opciones_model->get_permiso($_SESSION['user_id'],'admin_opciones');
      if($permiso){
         $ajax = $this->input->get('ajax');
         if($ajax){
            $agregar = $this->input->post('agregar');
            $quitar = $this->input->post('quitar');
            $rol = $this->input->post('rol');
            $actividad = $this->input->post('actividad');
            $resp = $this->Opciones_model->update_botones($agregar,$quitar,$rol,$actividad);
            if($resp){
               $json = array('result' => true, 'mensaje' => $this->config->item('_mensaje_actualizar'));
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