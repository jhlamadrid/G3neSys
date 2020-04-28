<?php

class Usuarios_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('permisos/Usuarios_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->load->library('encrypt');
        $this->acceso_cls->isLogin();
        $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO";
        $this->mensaje_vacio = "ALERTA: 999 \n No se encontraron datos disponibles para la solicitud";
        $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS.";
        $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO";
        $this->mensaje_create =  "ALERTA: 582 \n NO SE PUDO CREAR EL REGISTRO ENVIADO";
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'ADMINISTRACIÓN DE USUARIOS';
        $this->data['menu']['padre'] = 'Permisos';
        $this->data['menu']['hijo'] = 'admin_users';
    }

    public function listar_usuarios(){
        $this->data['usuarios'] = $this->Usuarios_model->get_all_user();
        $this->data['last_user'] = $this->Usuarios_model->get_last_user();
        $this->data['view'] = 'permisos/Usuarios_view';
        $this->data['breadcrumbs'] = array(array('Administracion Usuarios', ''));
        $this->load->view('template/Master', $this->data);
    }

    public function editar_usuario($codigo = null){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('UserNombre', 'Nombre de usuario', 'required');
        $this->form_validation->set_rules('UserDireccion', 'Direccion de usuario', 'required');
        $this->form_validation->set_rules('UserDni', 'DNI de usuario', 'required');
        $this->form_validation->set_rules('UserLogin', 'Cuenta de usuario', 'required');
        $this->form_validation->set_rules('fechaInicio', 'Fecha de inicio del usuario', 'required');
        $this->form_validation->set_rules('fechaFin', 'Fecha de fin del usuario', 'required');
        if($this->form_validation->run()){
          $userNom = $this->input->post('UserNombre');
          $userDir = $this->input->post('UserDireccion');
          $userCel = $this->input->post('UserCelular');
          $userDni = $this->input->post('UserDni');
          $userLog = $this->input->post('UserLogin');
          $userOfi = $this->input->post('oficina');
          $userArea = $this->input->post('area');
          $userIni = $this->input->post('fechaInicio');
          $userfin = $this->input->post('fechaFin');
          $userEst = $this->input->post('estado');
          $rol = $this->input->post('rol');
          $psw = $this->input->post('UserPsw');
          $usuario = $this->Usuarios_model->get_one_user(($codigo/4152));
          if($psw == $usuario['NCLAVE']) $psw = $psw;
          else $psw = sha1($psw);
          if($_FILES['imagen']['tmp_name']){
          $dir_subida = 'assets/usuarios/';
          $fichero_subido = $dir_subida . ($codigo/4152).".jpg";
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
              $resp = $this->Usuarios_model->update_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,($codigo/4152),$rol,$fichero_subido);
            } else {
                $resp = $this->Usuarios_model->update_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,($codigo/4152),$rol,NULL);
            }
          } else {
            $resp = $this->Usuarios_model->update_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,($codigo/4152),$rol,NULL);
          }
          if($resp['result']){
            $this->session->set_flashdata('mensaje', array('ok', 'SE HA ACTUALIZADO EL USUARIO CORRECTAMENTE'));
            redirect($this->config->item('ip').'permisos/administrar_usuarios');
          } else {
            $this->session->set_flashdata('mensaje', array('error', $resp['mensaje']));
            redirect($this->config->item('ip').'/permisos/administrar_usuarios/editar/'+($codigo/4152));
          }
        } else {
          $this->session->set_flashdata('mensaje', array('error', 'DEBE COMPLETAR TODOS LOS CAMPOS PARA EL REGISTRO'));
          redirect($this->config->item('ip').'/permisos/administrar_usuarios/editar/'+($codigo/4152));
        }
      } else {
        $this->data['breadcrumbs'] = array(array('Administracion Usuarios', 'permisos/administrar_usuarios'),array('Editar Usuario',''));
        $usuario = $this->Usuarios_model->get_one_usuario($codigo/4152); // codigo_nuevo
        $this->data['rol1'] = $this->Usuarios_model->get_one_rol($codigo/4152); // codigo_nuevo
        $this->data['areas'] = $this->Usuarios_model->get_areas($usuario['OFICOD']); //codigo_nuevo
        $this->data['usuario'] = $usuario;
        $oficinas = $this->Usuarios_model->get_oficinas();
        $roles = $this->Usuarios_model->get_roles();
        $this->data['oficinas'] = $oficinas;
        $this->data['roles'] = $roles;
        $this->data['estados'] = $this->Usuarios_model->get_estados();
        $this->data['view'] = 'permisos/Usuario_Edit_view';
        $this->load->view('template/Master', $this->data);
      }
    }

    public function crear_usuario(){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('UserNombre', 'Nombre de usuario', 'required');
        $this->form_validation->set_rules('UserDireccion', 'Direccion de usuario', 'required');
        $this->form_validation->set_rules('UserDni', 'DNI de usuario', 'required');
        $this->form_validation->set_rules('UserLogin', 'Cuenta de usuario', 'required');
        $this->form_validation->set_rules('fechaInicio', 'Fecha de inicio del usuario', 'required');
        $this->form_validation->set_rules('fechaFin', 'Fecha de fin del usuario', 'required');
        if($this->form_validation->run()){
          $userNom = $this->input->post('UserNombre');
          $userDir = $this->input->post('UserDireccion');
          $userCel = $this->input->post('UserCelular');
          $userDni = $this->input->post('UserDni');
          $userLog = $this->input->post('UserLogin');
          $userOfi = $this->input->post('oficina');
          $userArea = $this->input->post('area');
          $userIni = $this->input->post('fechaInicio');
          $userfin = $this->input->post('fechaFin');
          $userEst = $this->input->post('estado');
          $psw = sha1('123456');
          $rol = $this->input->post('rol');
          if($_FILES['imagen']['tmp_name']){
          $dir_subida = 'assets/usuarios/';
          $fichero_subido = $dir_subida . $userLog.".jpg";
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
              $resp = $this->Usuarios_model->save_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,$rol,$fichero_subido);
            } else {
              $resp = $this->Usuarios_model->save_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,$rol,NULL);
            }
          } else {
            $resp = $this->Usuarios_model->save_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,$rol,NULL);
          }
          if($resp['result']){
            $this->session->set_flashdata('mensaje', array('ok', 'SE HA CREADO EL USUARIO CORRECTAMENTE'));
            redirect($this->config->item('ip').'permisos/administrar_usuarios');
          } else {
            $this->session->set_flashdata('mensaje', array('error', $resp['mensaje']));
            redirect($this->config->item('ip').'/permisos/administrar_usuarios/agregar');
          }
        } else {
          $this->session->set_flashdata('mensaje', array('error', 'DEBE COMPLETAR TODOS LOS CAMPOS PARA EL REGISTRO'));
          redirect($this->config->item('ip').'/permisos/administrar_usuarios/agregar');
        }
      } else {
        $this->data['breadcrumbs'] = array(array('Administracion Usuarios', 'permisos/administrar_usuarios'),array('Crear Usuario',''));
        $oficinas = $this->Usuarios_model->get_oficinas();
        $roles = $this->Usuarios_model->get_roles();
        $this->data['oficinas'] = $oficinas;
        $this->data['roles'] = $roles;
        $this->data['estados'] = $this->Usuarios_model->get_estados();
        $this->data['view'] = 'permisos/Crear_usuario_view';
        $this->load->view('template/Master', $this->data);
      }
    }

    public function validar_login(){
      $ajax = $this->input->get('ajax');
      if($ajax == true){
        $login = $this->input->post('login');
        $rep = $this->Usuarios_model->validate_user($login);
        if($rep == NULL){
          $json = array('result' => true, 'mensaje' => 'OK');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => "YA EXISTE UN USUARIO CON ESA CUENTA");
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
      if($ajax == true){
        $rol = $this->input->post('rol');
        $resp = $this->Usuarios_model->get_actividades_x_rol($rol);
        foreach ($resp as $key => $value) {
          $actividades = $this->Usuarios_model->get_actividades_x_menu($value['ID_MENUGEN']);
          $resp[$key]['actividades'] = $actividades;
        }
        if($resp){
          $json = array('result' => true, 'mensaje' => 'OK', 'permisos' => $resp);
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

    public function buscar_usaurios(){
      $ajax = $this->input->get('ajax');
      if($ajax == true){
        $key = $this->input->post('keyword');
        $resp = $this->Usuarios_model->get_all_usuarios(strtoupper($key));
        if($resp) {
          $json = array('result' => true, 'mensaje' => 'OK', 'usuarios' => $resp);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'NO SE ENCONTRARON USUARIOS QUE COINCIDAN');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => 'EL RECURSOS SOLICITADO NO EXISTE');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function buscar_usuario(){
      $ajax = $this->input->get('ajax');
      if($ajax == true){
        $idUser = $this->input->post('idUser');
        $usuario = $this->Usuarios_model->get_one_user_comercial($idUser);
        if($usuario){
          $json = array('result' => true, 'mensaje' => 'OK', 'usuario' => $usuario);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'NO SE ENCONTRO AL USUARIO');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => 'EL RECURSOS SOLICITADO NO EXISTE');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function get_areas(){
      $ajax = $this->input->get('ajax');
      if($ajax ==  true){
        $oficina = $this->input->post('oficina');
        $areas = $this->Usuarios_model->get_areas($oficina);
        if($areas) {
          $json = array('result' => true, 'mensaje' => 'OK', 'areas' => $areas);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        } else {
          $json = array('result' => false, 'mensaje' => 'NO SE ENCONTRARON AREAS PARA LA OFICINA SELECCIONADA');
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $json = array('result' => false, 'mensaje' => 'EL RECURSOS SOLICITADO NO EXISTE');
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

}
?>
