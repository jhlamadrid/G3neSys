<?php

class Roles_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('permisos/Roles_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO";
        $this->mensaje_vacio = "ALERTA: 999 \n No se encontraron datos disponibles para la solicitud";
        $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS.";
        $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO";
        $this->mensaje_create =  "ALERTA: 582 \n NO SE PUDO CREAR EL REGISTRO ENVIADO";
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'ADMINITRACIÓN ROLES';
        $this->data['menu']['padre'] = 'Permisos';
        $this->data['menu']['hijo'] = 'admin_roles';
    }

    public function listar_roles(){
      $roles = $this->Roles_model->get_all_roles();
      $this->data['roles'] = $roles;
      $this->data['view'] = 'permisos/Roles_view';
      $this->data['breadcrumbs'] = array(array('Administracion Roles', ''));
      $this->load->view('template/Master', $this->data);
    }

    public function get_menus_actividades(){
      $ajax = $this->input->get('ajax');
      if($ajax == true){
        $rol = $this->input->post('rol');
        $rol1 = $this->Roles_model->get_one_rol($rol);
        $menus = $this->Roles_model->get_menu_x_rol($rol);
        foreach ($menus as $key1 => $menu) {
          $actividades = $this->Roles_model->get_actividades_x_menu($menu['ID_MENUGEN'],$rol);
          $menus[$key1]['actividades'] = $actividades;
        }
        if($menus){
          $contenido = "";
          $i = 0;
          foreach ($menus as $menu) {
            $contenido .= '<div class="panel panel-default">'.
                            '<div class="panel-heading" role="tab" id="heading'.$menu['ID_MENUGEN'].'" style="background-color: #276FB7;color:#FFF">'.
                              '<h4 class="panel-title">'.
                                '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$menu['ID_MENUGEN'].'" aria-expanded="true" aria-controls="collapse'.$menu['MENUGENNOM'].'">'.
                                '<i class="'.$menu['MENUGENICON'].'" ></i> '.$menu['MENUGENNOM'].
                                '</a>'.
                              '</h4>'.
                            '</div>'.
                            '<div id="collapse'.$menu['ID_MENUGEN'].'" class="panel-collapse collapse '.(($i == 0) ? "in" : "").'" role="tabpanel" ><ul class="list-group">';
            foreach ($menu['actividades'] as $act) {
              $contenido .= '<li class="list-group-item"><i class="'.$act['ACTIVIICON'].'"></i> '.$act['ACTIVINOMB'].'</li>';
            }
            $contenido .= '</ul>'.
                            '</div>'.
                          '</div>';
            $i++;
          }
          $json = array('result' => true, 'mensaje' => 'ok', 'detalle' => $contenido,'rol' => $rol1);
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

    public function get_menus(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $menus = $this->Roles_model->get_all_menus();
        $rol1 = $this->Roles_model->get_one_rol($this->input->post('rol'));
        if($menus){
          $contenido = "";
          $contenido .= '<option value="">SELECCIONE UN MENU</option>';
          foreach ($menus as $menu) {
            $contenido .= '<option value="'.$menu['ID_MENUGEN'].'">'.$menu['MENUGENNOM'].'</option>';
          }
          $json = array('result' => true, 'mensaje' => 'ok', 'menus' => $contenido,'rol' => $rol1);
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

    public function get_menus1(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $menus = $this->Roles_model->get_all_menus();
        if($menus){
          $contenido = "";
          $contenido .= '<option value="">SELECCIONE UN MENU</option>';
          foreach ($menus as $menu) {
            $contenido .= '<option value="'.$menu['ID_MENUGEN'].'">'.$menu['MENUGENNOM'].'</option>';
          }
          $json = array('result' => true, 'mensaje' => 'ok', 'menus' => $contenido);
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

    public function get_actividades(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $actividades = $this->Roles_model->get_actividades_x_menu_x_rol($this->input->post('menu'),$this->input->post('rol'));
        $actividades1 = $this->Roles_model->get_actividades_x_menu1($this->input->post('menu'));
        $actividades2 = $this->input->post('actividades'); //agregadas
        $actividades3 = $this->input->post('actividades1'); //quitadas
        $act3 = array();
        if($actividades1){
          $contenido = "";
          $i = 0;
          foreach ($actividades1 as $act) {
            $band = 0;
            foreach ($actividades as $act1) {
                if($act['ID_ACTIV'] == $act1['ID_ACTIV']){
                  $band = 1;
                  array_push($act3,$act['ID_ACTIV']);
                  break;
                }
            }
            if($band == 0){
              if($actividades2 != NULL){
                foreach ($actividades2 as $act1) {
                  if($act1 == $act['ID_ACTIV']){
                    $band = 1;
                    break;
                  }
                }
              }
            }
            if($band == 1){
              if($actividades3 != NULL){
                foreach ($actividades3 as $act1) {
                  if($act1 == $act['ID_ACTIV']){
                    $band = 0;
                    break;
                  }
                }
              }
            }
            if($band == 1) {
              $contenido .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista_'.$act['ID_ACTIV'].'" class="seleccionado">
                <div class="row">
                  <div class="col-md-2 col-sm-2 col-sx-2">
                    <a class="btn btn-warning"><i class="'.$act['ACTIVIICON'].'" aria-hidden="true"></i></a>
                  </div>
                  <div class="col-md-6 col-sm-6 col-sx-6">
                    <span style="text-transform: uppercase;"><b>'.$act['ACTIVINOMB'].'</b></span><br>
                    <span>'.$act['ACTIVDESC'].'</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;">
                      <span class="text-green" id="asignar_'.$act['ID_ACTIV'].'">ASIGNADO</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;text-align:center">
                    <a class="btn" style="border: 1px solid" onclick="quitar('.$act['ID_ACTIV'].')" id="btn_'.$act['ID_ACTIV'].'"><i id="icono_'.$act['ID_ACTIV'].'" class="fa fa-minus" aria-hidden="true"></i></a>
                  </div>
                </div>
              </li><hr>';
            } else {
              $contenido .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista_'.$act['ID_ACTIV'].'" >
                <div class="row">
                  <div class="col-md-2 col-sm-2 col-sx-2">
                    <a class="btn btn-warning"><i class="'.$act['ACTIVIICON'].'" aria-hidden="true"></i></a>
                  </div>
                  <div class="col-md-6 col-sm-6 col-sx-6">
                    <span style="text-transform: uppercase;"><b>'.$act['ACTIVINOMB'].'</b></span><br>
                    <span>'.$act['ACTIVDESC'].'</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;">
                      <span class="text-red" id="sin_asignar_'.$act['ID_ACTIV'].'">SIN ASIGNAR</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;text-align:center">
                    <a class="btn" onclick="agregar('.$act['ID_ACTIV'].')" style="border: 1px solid" id="btn_'.$act['ID_ACTIV'].'" ><i id="icono_'.$act['ID_ACTIV'].'" class="fa fa-plus" aria-hidden="true"></i></a>
                  </div>
                </div>
              </li><hr>';
            }
            $i++;
          }
          $json = array('result' => true, 'mensaje' => 'ok', 'actividades' => $contenido,'act' => $act3);
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

    public function get_actividades1(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $actividades1 = $this->Roles_model->get_actividades_x_menu1($this->input->post('menu'));
        $actividades = $this->input->post('actividades');
        if($actividades1){
          $contenido = "";
          foreach ($actividades1 as $act) {
            $band  = 0;
            if($actividades != NULL) {
              foreach ($actividades as $act1) {
                if($act1 == $act['ID_ACTIV']){
                  $band = 1;
                  break;
                }
              }
            }
          if($band == 0){
              $contenido .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista1_'.$act['ID_ACTIV'].'" >
                <div class="row">
                  <div class="col-md-2 col-sm-2 col-sx-2">
                    <a class="btn btn-warning"><i class="'.$act['ACTIVIICON'].'" aria-hidden="true"></i></a>
                  </div>
                  <div class="col-md-6 col-sm-6 col-sx-6">
                    <span style="text-transform: uppercase;"><b>'.$act['ACTIVINOMB'].'</b></span><br>
                    <span>'.$act['ACTIVDESC'].'</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;">
                      <span class="text-red" id="asignar1_'.$act['ID_ACTIV'].'">SIN ASIGNAR</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;text-align:center">
                    <a class="btn" style="border: 1px solid" onclick="agregar_actividad('.$act['ID_ACTIV'].')" id="btn1_'.$act['ID_ACTIV'].'"><i id="icono1_'.$act['ID_ACTIV'].'" class="fa fa-plus" aria-hidden="true"></i></a>
                  </div>
                </div>
              </li><hr>';
            } else {
              $contenido .= '<li style="list-style:none;margin-left: 10px;padding: 10px;border-radius: 5px;" id="lista1_'.$act['ID_ACTIV'].'" class="seleccionado">
                <div class="row">
                  <div class="col-md-2 col-sm-2 col-sx-2">
                    <a class="btn btn-warning"><i class="'.$act['ACTIVIICON'].'" aria-hidden="true"></i></a>
                  </div>
                  <div class="col-md-6 col-sm-6 col-sx-6">
                    <span style="text-transform: uppercase;"><b>'.$act['ACTIVINOMB'].'</b></span><br>
                    <span>'.$act['ACTIVDESC'].'</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;">
                      <span class="text-green" id="asignar1_'.$act['ID_ACTIV'].'">ASIGNADO</span>
                  </div>
                  <div class="col-md-2 col-sm-2 col-sx-2" style="line-height: 40px;text-align:center">
                    <a class="btn" style="border: 1px solid" onclick="desagregar_actividad('.$act['ID_ACTIV'].')" id="btn1_'.$act['ID_ACTIV'].'"><i id="icono1_'.$act['ID_ACTIV'].'" class="fa fa-minus" aria-hidden="true"></i></a>
                  </div>
                </div>
              </li><hr>';
            }
          }
          $json = array('result' => true, 'mensaje' => 'ok', 'actividades' => $contenido);
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

    public function get_actividades2(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $actividades = $this->input->post('actividades');
        $rol = $this->Roles_model->get_rol_nombre($this->input->post('rol'));
        if($rol == NULL){
          $contenido = "";
          if($actividades != NULL){
            foreach ($actividades as $value) {
              $act = $this->Roles_model->get_one_actividad($value);
              $contenido .= "<li style='text-align:left'>".$act['ACTIVINOMB']."</li>";
            }
          }
          if($contenido != ""){
            $json = array('result' => true, 'mensaje' => 'ok', 'actividades' => $contenido);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json = array('result' => false, 'mensaje' => $this->mensaje_vacio );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else {
          $json = array('result' => false, 'mensaje' => 'DEBE SELECCIONAR OTRO NOMBRE PARA EL ROL YA QUE HAY UNO IGUAL O PARECIDO');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error );
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function save_rol(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $actividades = $this->input->post('actividades');
        $rol = $this->input->post('rol');
        $respuesta = $this->Roles_model->guardar_rol($actividades,$rol);
        if($respuesta){
          $json = array('result' => true, 'mensaje' => 'ROL CREADO CON EXITO',);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => $this->mensaje_create );
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error );
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    //falta sincronizar con el servidor de producccion

    public function get_actividades3(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $actividades = $this->input->post('actividades'); //agregadas
        $actividades1 = $this->input->post('actividades1'); //quitadas
        $contenido = "";
          if($actividades != NULL){
            $contenido .= "<h3 style='font-family:\"Ubuntu\"'>ACTIVIDADES AGREGADAS </h3><ol style='margin-left: 20%;'>";
            foreach ($actividades as $value) {
              $act = $this->Roles_model->get_one_actividad($value);
              $contenido .= "<li style='text-align:left'>".$act['ACTIVINOMB']."</li>";
            }
            $contenido .= "</ol>";
          }
          if($actividades1 != NULL){
            $contenido .= "<h3 style='font-family:\"Ubuntu\"'>ACTIVIDADES QUITADAS </h3><ol style='margin-left: 20%;'>";
            foreach ($actividades1 as $value) {
              $act = $this->Roles_model->get_one_actividad($value);
              $contenido .= "<li style='text-align:left'>".$act['ACTIVINOMB']."</li>";
            }
            $contenido .= "</ol>";
          }
          if($contenido != ""){
            $json = array('result' => true, 'mensaje' => 'ok', 'actividades' => $contenido);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }  else {
          $json = array('result' => false, 'mensaje' => 'DEBE SELECCIONAR OTRO NOMBRE PARA EL ROL YA QUE HAY UNO IGUAL O PARECIDO');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error );
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function actualizar_rol(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $actividades = $this->input->post('actividades'); //agregadas
        $actividades1 = $this->input->post('actividades1'); //quitadas
        $rol = $this->input->post('rol');
        $respuesta = $this->Roles_model->update_rol($actividades,$actividades1,$rol);
        if($respuesta){
          $json = array('result' => true, 'mensaje' => 'ROL ACTUALIZADO CON EXITO',);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => $this->mensaje_create );
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error );
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

}
