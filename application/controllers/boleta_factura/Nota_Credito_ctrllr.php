<?php

class Nota_Credito_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('boleta_factura/Nota_Credito_model');
        $this->load->model('general/Catalogo_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO";
        $this->mensaje_vacio = "ALERTA: 999 \n NO SE ENCONTRARON DATOS DISPONIBLES PARA LA CONSULTA";
        $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS.";
        $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO";
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->direccion_qrtemp = 'assets/comprobante/nota_credito/';
        $this->data['permiso'] = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'documentos_nota_credito');
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

    public  function listar_notas(){
      $permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'documentos_nota_credito');
      if($permiso){
        $this->data['view'] = 'boleta_factura/Nota_Credito_view.php';
        $this->data['notas'] = $this->Nota_Credito_model->get_notas_pendientes();
        $this->data['pagadas'] = $this->Nota_Credito_model->get_notas_pagadas();
        $this->data['breadcrumbs'] = array(array('Notas Crédito Pendientes', ''));
        $this->load->view('template/Master', $this->data);
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect($this->config->item('ip').'inicio');
        return;
      }
    }

    public function bsucar_nota(){
      $permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'documentos_nota_credito');
      if($permiso){
        $ajax = $this->input->get('ajax');
        if($ajax){
          $letra = substr($this->input->post("serie"),0,1);
          $serie = substr($this->input->post("serie"),1,strlen($this->input->post("serie")));
          $numero = $this->input->post("numero");
          $nc = $this->Nota_Credito_model->get_one_nota($letra,$serie,$numero);
          if($nc == null){
            $json = array('result' => false, 'mensaje' => $this->mensaje_vacio);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else if($nc['BFNCAEST'] == 'P'){
            $json = array('result' => false, 'mensaje' => 'LA NOTA DE CRÉDITO BUSCADA, YA SE ENCUENTRA CANCELADA');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          } else {
            $notas = "<tr>".
                     "<td>".$nc['BFNCATLET'].$nc['BFNCASERNRO']."</td>".
                     "<td>".$nc['BFNCANRO']."</td>".
                     "<td>".(($nc['BFNCATLET'] == 'B') ? '<b>BOLETA: </b>' : '<b>FACTURA: </b>').$nc['BFNCASUNSERNRO']."-".$nc['BFNCASUNFACNRO']."</td>".
                     "<td>".$nc['BFNCAFECHEMI']." ".$nc['BFNCAHRAEMI']."</td>".
                     "<td>".$nc['FSCCLINOMB']."</td>".
                     "<td>".(($nc['FSCCLIRUC']) ? '<b>RUC: </b>'.$nc['FSCCLIRUC'] : '<b>DNI: </b>'.$nc['FSCNRODOC'])."</td>".
                     "<td style='text-align:right'><b>".number_format($nc['BFNCATOTDIF'],2,'.','')."</b></td>".
                     "<td style='text-align:center'>".
                     "<a href='".$this->config->item('ip')."documentos/nota_credito/pagar/".$nc['BFNCATLET'].$nc['BFNCASERNRO']."/".$nc['BFNCANRO']."' class='btn btn-default'  data-toggle='tooltip' data-placement='bottom' title='PAGAR NOTA CRÉDITO'>".
                     "<i class='fa fa-usd' aria-hidden='true'></i>".
                     "</a></td></tr>";
            $json = array('result' => true, 'mensaje' => 'ok','nota' => $notas);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
          }
        } else {
          $json = array('result' => false, 'mensaje' => $this->mensaje_vacio);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect($this->config->item('ip').'inicio');
        return;
      }
    }

    public function pagar_nota($serie,$numero){
      $permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'documentos_nota_credito');
      if($permiso){
        $letra = substr($serie,0,1);
        $serie = intval(substr($serie,1,strlen($serie)))/97;
        $numero = $numero / 39 ;
        $nota = $this->Nota_Credito_model->get_one_nota($letra,$serie,$numero);
        if($nota['BFNCAEST'] == 'I'){
          if($this->input->server('REQUEST_METHOD') == 'POST'){
            if($nota['BFNCAEST'] == 'P'){
              $this->session->set_flashdata('mensaje', array('error', "EL COMPROBANTE YA HA SIDO PAGADO"));
              redirect($this->config->item('ip').'documentos/nota_credito');
            }else{
                $rep = $this->Nota_Credito_model->actualizar_bfnca($letra,$serie,$numero);
                if($rep == true){
                  $this->data['btn_comprobante'] = '<a onclick=\'window.open("'.$this->config->item('ip').'documentos/nota_credito/imprimir_ticket_nc/'.$letra.'/'.$serie.'/'.$numero.'", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes")\';  class="btn btn-warning btn-block"><i class="fa fa-ticket" aria-hidden="true"></i> &nbsp; COMPROBANTE</a>';
                } else {
                  $this->session->set_flashdata('mensaje', array('error', "HUBO UN PROBLEMA AL PAGAR LA NOTA DE CRÉDITO: ".$letra.$serie."-".$numero));
                }
            }
          } else {
            $this->data['btn_pagar'] = '<button type="submit" class="btn btn-success btn-block"><i class="fa fa-usd" aria-hidden="true"></i> &nbsp; PAGAR</button>';
          }
          $this->data['nota'] = $nota;
          $this->data['detalle'] = $this->Nota_Credito_model->get_detalle_one_nota($letra,$serie,$numero);
          $this->data['view'] = 'boleta_factura/nota_Credito_pago_view';
          $this->data['breadcrumbs'] = array(array('Notas Crédito Pendientes', 'documentos/nota_credito'),array("Pagar Nota: ".$letra.$serie."-".$numero,""));
          $this->load->view('template/Master', $this->data);
        } else {
          $this->session->set_flashdata('mensaje', array('error', "NO SE ENCONTRO LA NOTA DE CRÉDITO SOLICITADA O YA FUE CANCELADA"));
          redirect($this->config->item('ip').'documentos/nota_credito');
        }
      } else {
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect($this->config->item('ip').'inicio');
        return;
      }
    }

    public function imprimir_ticket1($letra, $serie, $numero){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);
        $cab = $this->Nota_Credito_model->get_one_nota($letra, $serie, $numero);
        $oficina = $this->Catalogo_model->get_oficina2($cab['BFSFACREG'], $cab['BFSFACZON'], $cab['BFSFACLOC']);
        $usuario = $this->Catalogo_model->get_usuario($cab['BFNCAUSRPAG']);
        $detalle = $this->Nota_Credito_model->get_detalle_one_nota($letra,$serie,$numero);
        $qr = $this->config->item('ip').$this->direccion_qrtemp.$letra.$serie."-".$numero.".png";
        $letra = $ntt->numtoletras($cab['BFNCATOTDIF']);
        $this->load->view("template/Ticket_nc", array('cab'=>$cab,'oficina'=>$oficina,'usuario' => $usuario,'detalle'=>$detalle,'imagen'=>$qr,'total_letra'=>$letra));
    }

    public function imprimir_ticket2($letra, $serie, $numero){
        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);
        $cab = $this->Nota_Credito_model->get_one_nota($letra, $serie, $numero);
        $oficina = $this->Catalogo_model->get_oficina2($cab['BFSFACREG'], $cab['BFSFACZON'], $cab['BFSFACLOC']);
        $usuario = $this->Catalogo_model->get_usuario($cab['BFNCAUSRPAG']);
        $detalle = $this->Nota_Credito_model->get_detalle_one_nota($letra,$serie,$numero);
        $qr = $this->config->item('ip').$this->direccion_qrtemp.$letra.$serie."-".$numero.".png";
        $letra = $ntt->numtoletras($cab['BFNCATOTDIF']);
        $copia = TRUE;
        $this->load->view("template/Ticket_nc", array('cab'=>$cab,'oficina'=>$oficina,'usuario' => $usuario,'detalle'=>$detalle,'imagen'=>$qr,'total_letra'=>$letra, 'copia'=>$copia));
    }

    public function buscar_nota_pagada(){
      $permiso = $this->Nota_Credito_model->get_permiso($_SESSION['user_id'],'documentos_nota_credito');
      if($permiso){
        $ajax = $this->input->get('ajax');
        if($ajax){
            $tipo = $this->input->post('tipo');
            if($tipo == 1 ){
              $letra = $this->input->post('letra');
              $serie = $this->input->post('serie');
              $numero = $this->input->post('numero');
              $notas_pagadas = $this->Nota_Credito_model->get_nota_pagada($letra,$serie,$numero);
            } else  if($tipo == 2){
              $nombre = $this->input->post('nombre');
              $notas_pagadas = $this->Nota_Credito_model->get_nota_pagada_nombre($nombre);
            } else if ($tipo == 3){
              $fecha_inicio = $this->input->post('fecha_inicio');
              $fecha_fin = $this->input->post('fecha_fin');
              $notas_pagadas = $this->Nota_Credito_model->get_nota_pagada_fechas($fecha_inicio,$fecha_fin);
            } else if($tipo == 4){
              $dni = $this->input->post('dni');
              $notas_pagadas  = $this->Nota_Credito_model->get_nota_pagada_dni(1,$dni);
            } else if ($tipo == 5){
              $ruc = $this->input->post('ruc');
              $notas_pagadas = $this->Nota_Credito_model->get_nota_pagada_dni(6,$ruc);
            }
            $cuerpo = "";
            foreach ($notas_pagadas as $nc) {
              $cuerpo .= '<tr>'.
                          '<td>'.$nc['BFNCATLET'].$nc['BFNCASERNRO'].'</td>'.
                          '<td>'.$nc['BFNCANRO'].'</td>'.
                          '<td><b>'.(($nc['BFNCATLET'] == 'F') ? 'FACTURA: </b>' : 'BOLETA: </b>').$nc['BFNCASUNSERNRO'].'-'.$nc['BFNCASUNFACNRO'].'</td>'.
                          '<td>'.$nc['BFNCAFECHEMI'].' '.$nc['BFNCAHRAEMI'].'</td>'.
                          '<td>'.$nc['FSCCLINOMB'].'</td>'.
                          '<td><b>'.(($nc['BFSFACTIPDOC'] == 6) ? 'RUC: </b>' : 'DNI: </b>').$nc['BFSFACNRODOC'].'</td>'.
                          '<td style="text-align:right"><b>'.number_format($nc['BFNCATOTDIF'],2,'.',',').'</b></td>'.
                          '<td style="text-align:center">'.
                            '<a onclick="window.open(&quot;'.$this->config->item('ip').'/documentos/nota_credito/imprimir_ticket_nc_duplicado/'.$nc['BFNCATLET'].'/'.$nc['BFNCASERNRO'].'/'.$nc['BFNCANRO'].'&quot;,&quot;_blank&quot;,&quot;toolbar=yes, scrollbars=yes, resizable=yes&quot;)" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="COMPROBANTE PAGO">'.
                            '<i class="fa fa-ticket" aria-hidden="true"></i>'.
                          '</a>'.
                        '</td>'.
                      '</tr>';
            }
            if($cuerpo != ""){
              $json = array('result' => true, 'mensaje' => 'ok','notas' => $cuerpo);
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
        $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
        redirect($this->config->item('ip').'inicio');
        return;
      }
    }

  }
