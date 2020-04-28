<?php

class Acceso_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model'); //Antiguo, por retirar despues de probar
        $this->load->model('acceso/Acceso_model');
        $this->load->model('sistema/Global_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->load->library('operaciones');
        $this->load->library('implement');
    }

    public function mostrar() {
        if (isset($_SESSION['user_nom']) && isset($_SESSION['user_id'])) {
            redirect($this->config->item('url') . 'inicio');
        } else { 
            session_unset();
            $this->session->sess_destroy();
            $this->load->view('acceso/Login');
        }
        //$this->load->view('acceso/Soporte');
    }

    public function inicio() {
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata($_SESSION['user_id']);
        if (isset($this->data['userdata']['NCODIGO'])) {
            $fecha = date('Y-m-d'); 
            $contenido = "";
            $fecha1 = $this->Usuario_model->get_fecha_expiracion($_SESSION['user_id']);
            $fecha2 = substr($fecha1,6,4)."-".substr($fecha1,3,2)."-".substr($fecha1,0,2);
            $contenido .= '<li class="list-group-item">'.
            '<b>SU ACCESO VENCE EN </b><a class="pull-right">'.$this->dateDiff($fecha,$fecha2).' días</a></li>';
            $valor = $this->Usuario_model->get_rol_user($this->data['userdata']['NCODIGO']);

            $hoy = date('Y-m-d'); 
            $fchExp = $this->Acceso_model->findFechaExpiracion($this->data['userdata']['NCODIGO']);
            $this->data['daysExp'] = $this->operaciones->dateDiff($hoy,$fchExp);

            $this->data['rol'] = $this->Acceso_model->findRol($this->data['userdata']['NCODIGO']);;
            $this->data['cuerpo'] = $contenido;
            $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
            $this->data['view'] = 'acceso/Inicio';
            $this->data['proceso'] = 'Dashboard';
            $this->data['menu']['padre'] = 'no_importa';
            $this->data['menu']['hijo'] = 'no_importa';
            $this->data['breadcrumbs'] = array();
            $this->load->view('template/Master', $this->data);
        }
    }

    public function login() {
        if(!$this->input->is_ajax_request()){
            show_404();
        } else {
            $ajax = $this->input->get('ajax');
            if (isset($_SESSION['user_nom']) && isset($_SESSION['user_id'])) {
                redirect($this->config->item('url') . 'inicio');
            } else {
                session_unset();
                //$this->load->library('form_validation');
                //$this->form_validation->set_rules('username', 'Nombre de Usuario', 'required');
                //$this->form_validation->set_rules('password', 'Contraseña', 'required');
                //if ($this->form_validation->run() == TRUE) {
                $usuario = $this->Acceso_model->findOneUsuario($this->input->post('username'), $this->input->post('password') );
                if(!$usuario) $usuario = $this->Acceso_model->findOneUsuario($this->input->post('username'), sha1($this->input->post('password')));
                if (count($usuario) > 0) {
                    if($usuario['VENCIDO']==1){
                        $json = array('res' => false, 'message' => 'La cuenta del usuario ha expirado. Comuniquese con el administrador');
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                        return;
                    }
                    $sigla_area = array( );
                    if($usuario['WF_ORGANIGRAMA'] != null){
                        $sigla_area = $this->Acceso_model->getSiglaArea( $usuario['WF_ORGANIGRAMA'] );
                    }

                    $_SESSION['login'] = $usuario['LOGIN'];
                    $_SESSION['imagen'] = $usuario['RUTIMAGEN'];
                    $_SESSION['user_nom'] = $usuario['NNOMBRE'];
                    $_SESSION['user_id'] = $usuario['NCODIGO'];
                    $_SESSION['user_comercial']= $usuario['NSUSRCOD'];
                    $_SESSION['fchReg'] = $usuario['NFECHAE'];
                    $_SESSION['NSEMPCOD'] = $usuario['NSEMPCOD'];
                    $_SESSION['NSOFICOD'] = $usuario['NSOFICOD'];
                    $_SESSION['NSARECOD'] = $usuario['NSARECOD'];
                    $_SESSION['OFICOD'] = $usuario['OFICOD'];
                    $_SESSION['IND_GERENCIA'] = $usuario['TIPOUSER'];
                    $_SESSION['DEPENDENCIA_ORIGEN'] = $usuario['WF_ORGANIGRAMA'];
                    $_SESSION['SIGLA_AREA'] = ((count($sigla_area)>0) ? $sigla_area['SIGLA_AREA'] : '' );
                    $_SESSION['SIGLA_USUARIO'] = $usuario['SIGLA_WORKFLOW'];
                    $_SESSION['OFICINA'] = $this->Global_model->findOficina($_SESSION['NSOFICOD']);
                    $_SESSION['oficina'] = $this->Global_model->findOficina($_SESSION['NSOFICOD']);
                    $_SESSION['AREA'] = $this->Global_model->findArea($_SESSION['NSARECOD']);
                    //$_SESSION['AREA'] = $this->Usuario_model->obtener_area($_SESSION['NSARECOD']);
                    $_SESSION['area'] = $this->Global_model->findArea($_SESSION['NSARECOD']);
                    $_SESSION['OFIAGECOD'] = $usuario['OFIAGECOD'];
                    $_SESSION['accesoReclamos']  = $this->Acceso_model->findUsuarioReclamo($this->input->post('username'));

                        // $actividades = $this->Usuario_model->get_grupo_actividades($_SESSION['user_id']);
                        // foreach ($actividades as $key => $value) {
                        //     $resultado = $this->Usuario_model->get_actividad_x_usuario($_SESSION['user_id'],$value['ID_MENUGEN']);
                        //     $actividades[$key]['actividades'] = $resultado;
                        // }
                        // $_SESSION['GRUPO_ACTIVIDADES'] = $this->Usuario_model->get_grupo_actividades($_SESSION['user_id']);
                        // $_SESSION['MENU'] = $actividades;
                        // $_SESSION['ACTIVIDADES'] = $this->Usuario_model->get_actividades($_SESSION['user_id']);
                        $_SESSION['TAREAS'] = $this->Usuario_model->get_tareas($_SESSION['user_id']);
                    
                    $_SESSION['user_ticked'] = 0;

                    $tokenData['uniqueId'] = $usuario['NCODIGO'];
                    $tokenData['role'] = $this->Acceso_model->findRol($usuario['NCODIGO']);
                    $tokenData['timeStamp'] = date('Y-m-d h:i:s');
                    $jwtToken = $this->implement->generateToken($tokenData);

                    $_SESSION['ROL'] = $this->Usuario_model->get_rol_user($usuario['NCODIGO']);  //por modificar e iliminar

                     //valores a guardar en el log
                     $ip = $this->operaciones->getClientIP();
                     $infoIP = $this->operaciones->getIPInfo($ip, "Country");
                     $hostname = gethostname();
                     $infoOS = $this->operaciones->getOS();
                     $this->Global_model->insertOneLog(date('d/m/Y'), date('H:i:s'), $ip, $infoOS, $usuario['NCODIGO'], $infoIP, $hostname, $jwtToken);


                     $this->session->set_flashdata('mensaje', array('success', 'Bienvenido '.$_SESSION['user_nom'] ));
                     $json = array('res' => true, 'message' => 'OK', 'token' => $jwtToken);
                     header('Access-Control-Allow-Origin: *');
                     header('Content-Type: application/x-json; charset=utf-8');
                     echo json_encode($json);

                } else {
                    $json = array('res' => false, 'message' => 'Usuario o password incorrectos, vuelva a intentarlo nuevamente.');
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
                // } else {
                //     $json = array('result' => false, 'mensaje' => 'Complete los campos.');
                //     header('Access-Control-Allow-Origin: *');
                //     header('Content-Type: application/x-json; charset=utf-8');
                //     echo json_encode($json);
                // }
            }
        }
    }

    

    public function logout() {
        session_unset();
        redirect($this->config->item('ip') . 'login');
    }

    public function configurar_usuario(){
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata($_SESSION['user_id']);
        $this->data['usuario'] = $this->Usuario_model->get_user($_SESSION['user_id']);
        $this->data['rol'] = $this->Usuario_model->get_rol_user($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata($_SESSION['user_id']);
        $this->data['psw'] = $this->data['usuario']['NCLAVE'];
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['view'] = 'acceso/Configuracion_view';
        $this->data['proceso'] = 'Configuración Usuario';
        $this->data['menu']['padre'] = 'no_importa';
        $this->data['menu']['hijo'] = 'no_importa';
        $this->data['breadcrumbs'] = array();
        $this->load->view('template/Master', $this->data);
    }

    private function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    public function actualizar_psw(){
        $ajax = $this->input->get('ajax');
        if($ajax){
            $psw = $this->input->post('psw');
            $new = $this->input->post('new');
            $usuario = $this->input->post('usuario');
            $new = sha1($new);
            $psw1 = sha1($psw);
            $resp = $this->Usuario_model->update_psw($psw1,$new,$usuario);
            if($resp == 0){
                $resp = $this->Usuario_model->update_psw($psw,$new,$usuario);
            }
            if($resp > 0){
                $json = array('result' => true, 'mensaje' => $this->config->item('_mensaje_actualizar_ajax'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            } else {
                $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error_actualizar_ajax'));
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
