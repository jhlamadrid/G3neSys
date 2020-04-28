<?php

class Estados_Nota_Credito_ctrllr extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->model('acceso/Usuario_model');
      $this->load->model('notas/Estados_model');
      $this->load->library('session');
      $this->load->library('acceso_cls');
      $this->acceso_cls->isLogin();
      $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
      $this->data['userdata'] = $this->acceso_cls->get_userdata();
      $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO";
      $this->mensaje_vacio = "ALERTA: 999 \n No se encontraron datos disponibles para la solicitud";
      $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS.";
      $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO";
      $this->data['permiso'] = $this->Estados_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'estados_nc');
      if($this->data['permiso']){
        $this->data['proceso'] = $this->data['permiso']['ACTIVINOMB'];
        $this->data['id_actividad'] = $this->data['permiso']['ID_ACTIV'];
        $this->data['menu']['padre'] =  $this->data['permiso']['MENUGENPDR'];
        $this->data['menu']['hijo'] =  $this->data['permiso']['ACTIVIHJO'];
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect(base_url().'inicio');
        return;
      }
  }

  public function lista_estados(){
    $permiso = $this->Estados_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'estados_nc');
    if($permiso){
      $this->data['notas'] = $this->Estados_model->get_notas_credito_del_dia();
      $this->data['view'] = 'notas/Estados_view';
      $this->data['breadcrumbs'] = array(array('Estados Notas Crédito', ''));
      $this->load->view('template/Master', $this->data);
    } else {
      $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
      redirect(base_url().'inicio');
      return;
    }
  }

  public function buscar_notas_bf(){
    $permiso = $this->Estados_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'estados_nc');
    if($permiso){
      $ajax = $this->input->get('ajax');
      if($ajax){
        $tipo = $this->input->post("tipo");
        $fecha_inicio = $this->input->post("fecha_inicio");
        $fecha_fin = $this->input->post("fecha_fin");
        $notas = $this->Estados_model->get_notas_credito_rango($tipo,$fecha_inicio,$fecha_fin);
        $n= "";
        foreach ($notas as $nota) {
          $n .= "<tr>".
            "<td>".$nota['BFNCATLET'].$nota['BFNCASERNRO']."</td>".
            "<td>".$nota['BFNCANRO']."</td>".
            "<td>".(($nota['BFSFACTIPC'] == 0) ? "<b>BOLETA</b>" : "<b>FACTURA</b>").": ".$nota['SFACTURA_FSCSERNRO']."-".$nota['SFACTURA_FSCNRO']."</td>".
            "<td>".$nota['BFNCASUNSERNRO']."-".$nota['BFNCASUNFACNRO']."</td>".
            "<td>".$nota['BFNCAFECHEMI']." ".$nota['BFNCAHRAEMI']."</td>".
            "<td style='text-align:right'>".number_format($nota['BFNCATOTDIF'],2,'.','')."</td>".
            "<td style='text-align:center'>";
            if($nota['BFNCAESTSUN'] == 1) {
              $n .= "<span class='badge bg-yellow'>EMITIDA</span>";
            } else if($nota['BFNCAESTSUN'] == 3) {
              $n .= "<span class='badge bg-green'>ACEPTADA</span>";
            } else if($nota['BFNCAESTSUN'] == 4){
              $n .= "<span class='badge bg-red'>RECHAZADO</span>";
            } else if($nota['BFNCAESTSUN'] == 5) {
              $n .= "<span class='badge bg-gray'>OBSERVADO</span>";
            } else if($nota['BFNCAESTSUN'] == 6) {
              $n .= "<span class='badge bg-orange'>NO ATENDIDO</span>";
            }
            $n .= "</td>".
                  "<td style='text-align:center'>".
                  "<a onclick=\"visualizar_detalle_nota_credito('".$nota['BFNCATIPO']."','".$nota['BFNCATLET']."',".(intval($nota['BFNCASERNRO'])*958).",".(intval($nota['BFNCANRO'])*235).")\" class='btn btn-default' data-toggle='tooltip' data-placement='bottom' title='VISUALIZAR NOTA CRÉDITO'>".
                  "<i class='fa fa-eye'></i>".
                  "</a>";
            if($nota['BFSFACDIRARCHPDF']) {
                $n .= "<a class='btn btn-default' href='".base_url().$nota['BFSFACDIRARCHPDF']." target='_blank' data-toggle='tooltip' data-placement='bottom' title='IMPRIMIR NOTA CRÉDITO'>".
                      "<i class='fa fa-file-pdf-o' aria-hidden='true'></i>".
                      "</a>";
            }
            if($nota['BFNCAESTSUN'] == 6) {
              $n .=  "<a class='btn btn-default' onclick=\"enviar_sunat('".$nota['BFNCATIPO']."','".$nota['BFNCATLET']."','".$nota['BFNCASERNRO']."','".$nota['BFNCANRO']."')\"  target='_blank' data-toggle='tooltip' data-placement='bottom' title='ENVIAR SUNAT'>".
                      "<i class='fa fa-cloud-upload' aria-hidden='true'></i>".
                      "</a>";
             }
            $n .= "</td></tr>";
        }
        if($notas){
          $json = array('result' => true, 'mensaje' => "ok", 'notas' => $n);
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

}
