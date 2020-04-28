<?php
class Autorizacion_Nota_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('autorizacion/Autorizacion_model');
        $this->load->model('cuenta_corriente/Cuentas_corrientes_model');
        $this->load->model('notas/Nota_Credito_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['permiso'] = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'anular_nota_credito');
        $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO";
        $this->mensaje_vacio = "ALERTA: 999 \n No se encontraron datos disponibles para la solicitud";
        $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS.";
        $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO";
        $this->mensaje_create = "ALERTA: 996 \n SE CREARON CORRECTAMENTE";
        $this->mensaje_no_create = "ALERTA: 995 \n NO SE PUDO PROCESAR LA SOLICITUD CORRECTAMENTE";
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

    public function listar_autorizaciones(){
      $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'anular_nota_credito');
      if($permiso){
        $autorizaciones = $this->Autorizacion_model->get_autorizaciones_recibo('2');
        foreach ($autorizaciones as $key => $aut) {
          $nombre = $this->Autorizacion_model->get_nombre_operador($aut['AUT_OPE']);
          $autorizaciones[$key]['NNOMBRE'] = $nombre;
        }
        $this->data['autorizaciones'] = $autorizaciones;
        $this->data['usuarios'] = $this->Autorizacion_model->get_usuarios_nc_recibos();
        $this->data['view'] = 'autorizacion/Autorizacion_Nota_Credito_view';
        $this->data['breadcrumbs'] = array(array('Autorización Nota Crédito', ''));
        $this->load->view('template/Master', $this->data);
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect($this->config->item('ip').'inicio');
        return;
      }
    }

    public function bsucar_nota_credito(){
      
      $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'anular_nota_credito');
      if($permiso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          $tipo = $this->input->post("tipo");
          $recibos = "";
          if($tipo == 0){
            $recibos = $this->Autorizacion_model->get_notas_credito2($this->input->post('serie'),$this->input->post('numero'));
          } else if($tipo == 1){
            $recibos = $this->Autorizacion_model->get_nota_credito1($this->input->post('suministro'));
          } else if($tipo == 2){
            $recibos = $this->Autorizacion_model->get_notas_credito($this->input->post('serie'),$this->input->post('numero'));
          }
          if($recibos){
            foreach ($recibos as $key => $value) {
              $nombre = $this->Autorizacion_model->get_nombre($value['NCACLICODF']);
              $autorizacion = $this->Autorizacion_model->get_autorizacion_pendiente($value['NCASERNRO'],$value['NCANRO'],$value['NCACLICODF'],2);
              $recibos[$key]['NOMBRE'] = $nombre;
              $recibos[$key]['AUT'] = $autorizacion;
            }
            $cuerpo = "";
            foreach ($recibos as $value) {
              $cuerpo .= '<tr class="recibo">'.
                            '<td style="text-align:center">'.(($value['AUT'] == NULL) ? '<input type="checkbox" value="" class="chekeado" />' : '').'</td>'.
                            '<td>'.$value['NCASERNRO'].'</td>'.
                            '<td>'.$value['NCANRO'].'</td>'.
                            '<td>'.$value['NCACLICODF'].'</td>'.
                            '<td>'.$value['NCAFECHA'].'</td>'.
                            '<td>'.$value['NOMBRE'].'</td>'.
                            '<td style="text-align:right">'.number_format(floatval($value['NCATOTDIF']),2,'.','').'</td>'.
                         '</tr>';
            }
            $json = array('result' => true, 'mensaje' => 'OK','recibos' => $cuerpo);
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
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

    public function save_autorizacion(){
      $permiso = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'anular_nota_credito');
      if($permiso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          $rep = $this->Autorizacion_model->create_autorizaciones_anulaciones($this->input->post('recibos'),$this->input->post('vigencia'),$this->input->post('glosa'),$this->input->post('usuario'));
          if($rep){
            $json = array('result' => true, 'mensaje' => $this->mensaje_create);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $json = array('result' => false, 'mensaje' => $this->mensaje_no_create);
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
      } else {
        $json = array('result' => false, 'mensaje' => $this->mensaje_error);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
      }
    }

}
