<?php

class Autorizacion_Recibos_ctrllr extends CI_Controller {

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
        $this->data['permiso'] = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'autorizacion_recibos');
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
      $autorizaciones = $this->Autorizacion_model->get_autorizaciones_recibo('1');
      foreach ($autorizaciones as $key => $aut) {
        $nombre = $this->Autorizacion_model->get_nombre_operador($aut['AUT_OPE']);
        $autorizaciones[$key]['NNOMBRE'] = $nombre;
      }
      $this->data['autorizaciones'] = $autorizaciones;
      $this->data['usuarios'] = $this->Autorizacion_model->get_usuarios_nc_recibos();
      $this->data['view'] = 'autorizacion/Autorizacion_Recibos';
      $this->data['breadcrumbs'] = array(array('Autorización Nota Crédito', ''));
      $this->load->view('template/Master', $this->data);
    }

    public function buscar_recibo(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $tipo = $this->input->post("tipo");
        $recibos = "";
        if($tipo == 1){
          $recibos = $this->Autorizacion_model->get_recibos($this->input->post('suministro'));
        } else if($tipo == 0){
          $recibos = $this->Autorizacion_model->get_recibos1($this->input->post('serie'),$this->input->post('numero'));
        }
        foreach ($recibos as $key => $value) {
          $descuento = $this->Autorizacion_model->get_monto_notas($value['FACSERNRO'],$value['FACNRO']);
          $nombre = $this->Autorizacion_model->get_nombre($value['CLICODFAX']);
          $autorizacion = $this->Autorizacion_model->get_autorizacion_pendiente($value['FACSERNRO'],$value['FACNRO'],$value['CLICODFAX'],1);
          $recibos[$key]['DESCUENTO'] = $descuento;
          $recibos[$key]['NOMBRE'] = $nombre;
          $recibos[$key]['AUT'] = $autorizacion;
        }
        if($recibos){
          $cuerpo = "";
          foreach ($recibos as $value) {
            $cuerpo .= '<tr class="recibo">'.
                          '<td style="text-align:center">'.(($value['AUT'] == NULL) ? '<input type="checkbox" value="" class="chekeado" />' : '').'</td>'.
                          '<td>'.$value['FACSERNRO'].'</td>'.
                          '<td>'.$value['FACNRO'].'</td>'.
                          '<td>'.$value['CLICODFAX'].'</td>'.
                          '<td>'.$value['FACEMIFEC'].'</td>'.
                          '<td>'.$value['NOMBRE'].'</td>'.
                          '<td style="text-align:center">';
            if($value['FACESTADO'] == 'I') $cuerpo .= '<span class="badge bg-red">PENDIENTE</span></td>';
            else if($value['FACESTADO'] == 'P') $cuerpo .= '<span class="badge bg-green">PAGADO</span></td>';
            else if($value['FACESTADO'] == 'R') $cuerpo .= '<span class="badge bg-yellow">REFINANCIADO</span></td>';
            else if($value['FACESTADO'] == 'C') $cuerpo .= '<span class="badge bg-info">CONVENIO</span></td>';

            $cuerpo .= '<td style="text-align:right">'.number_format(floatval($value['FACTOTAL']) - floatval($value['DESCUENTO']),2,'.','').'</td>'.
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
    }

    public function save_autorizacion(){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $rep = $this->Autorizacion_model->create_autorizaciones($this->input->post('recibos'),$this->input->post('vigencia'),$this->input->post('glosa'),$this->input->post('usuario'));
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
    }

  }
