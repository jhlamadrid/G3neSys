
<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class Reclamos_fonavi_ctrllr extends CI_Controller{
        /* [CONSTRUCTOR]*/
        public function __construct() {
            parent::__construct();
            $this->load->model('acceso/Usuario_model'); //PERMITE OBTENER ACCESO AL MODELO PARA PODER UTILIZAR SUS FUNCIONES
            $this->load->model('ReclamosFonavi/ReclamoFonavi_model'); // **
            $this->load->model('cuenta_corriente/Cuentas_corrientes_model'); // **
            $this->load->model('autorizacion/Autorizacion_model');
            $this->load->model('general/Catalogo_model');
            $this->data['rutabsq1'] = 'https://cel.reniec.gob.pe/valreg/valreg.do;jsessionid=97657851cf84a1b5e8e57db400289a1dfe6deb1635f.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaMa3D3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaPb3aPbhiTbN4xf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_';
            $this->data['tipo_via'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(25);
            $this->data['codigo_zona'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(26);
            // $this->load->model('notas/Nota_Credito_model');
            $this->load->library('session'); // PERMITE EL ACCESO A LAS LIBRERIAS DE SESION
            $this->load->library('acceso_cls'); // **
            $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']); // [GENERAL] -> OBTIENE EL MENU DE OPCIONES DE LA PARTE IZQUIERDA DEL PROYECTO
            $this->acceso_cls->isLogin();
            $this->data['userdata'] = $this->acceso_cls->get_userdata(); // [GENERAL] -> OBTIENE LA DATA DEL USUARIO
            $this->data['modal_persona'] = 'propie/RegistroPersona_view'; //LLAMA A LA VISTA -> RegistroPersona_view
            $this->data['permiso'] = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'reclamo_fonavi'); // OBTIENE LOS PERMISOS DEL USUARIO PARA EL MODULO
            $this->mensaje_error = "ERROR: 404 \n EL RECURSO SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO"; // [GENERAL] -> MENSAJES DE ERROR
            $this->mensaje_vacio = "ALERTA: 999 \n No se encontraron datos disponibles para la solicitud"; // ** 
            $this->mensaje_error_actualizar = "ALERTA: 998 \n NO SE PUDO ACTUALIZAR EN LA BASE DE DATOS."; // **
            $this->mensaje_actualizar = "ALERTA: 997 \n REGISTRO ACTUALIZADO CON ÉXITO"; // **
            $this->mensaje_create = "ALERTA: 996 \n SE CREARON CORRECTAMENTE"; // **
            $this->mensaje_no_create = "ALERTA: 995 \n NO SE PUDO PROCESAR LA SOLICITUD CORRECTAMENTE"; // **
            $this->mensaje_no_create_sol = "ALERTA: 995 \n YA EXISTEN REGISTROS PARA ALGUN RECIBO"; // **
            if($this->data['permiso']){ // [GENERAL] -> IF EXISTEN PERMISOS DEL USUARIO 
              $this->data['proceso'] = $this->data['permiso']['ACTIVINOMB']; // NOMBRE DEL PROCESO -> PARTE SUPERIOR DEL MODULO
              $this->data['id_actividad'] = $this->data['permiso']['ID_ACTIV'];
              $this->data['menu']['padre'] =  $this->data['permiso']['MENUGENPDR'];
              $this->data['menu']['hijo'] =  $this->data['permiso']['ACTIVIHJO'];
            } else {
              $this->session->set_flashdata('mensaje', array('error', $this->mensaje_error));
              redirect($this->config->item('ip').'inicio');
              return;
            }
        }  
    
        public function lista_estados(){
            $this->data['usuarios'] = $this->ReclamoFonavi_model->get_usuarios_nc_recibos();
            $this->data['view'] = 'ReclamosFonavi/ReclamosFonavi_view';
            $this->data['breadcrumbs'] = array(array('Autorización Nota Crédito', ''));
            $this->load->view('template/Master', $this->data);
        }

        public function buscar_recibo(){
          $ajax = $this->input->get('ajax');
          if($ajax){
            $tipo = $this->input->post("tipo");
            $recibos = "";
          
            if($tipo == 1){
              $recibos = $this->ReclamoFonavi_model->get_recibos_suministro($this->input->post('suministro'));
            } else if($tipo == 0){
              $recibos = $this->ReclamoFonavi_model->get_recibos_numeroSerie($this->input->post('serie'),$this->input->post('numero'));
            } else if($tipo == 2){
              $recibos = $this->ReclamoFonavi_model->get_recibos_prestatario($this->input->post('prestatario'));
            }
            foreach ($recibos as $key => $value) {
              $reclamado = $this->ReclamoFonavi_model->get_EstadoReclamo($value['COD_FACT']); //busqueda por codigo de prestatario
              $recibos[$key]['PREST'] = $reclamado; // $autorizacion; // ACTIVAR 
            }
            if($recibos){

              // LISTA DE RECIBOS A RECLAMAR
              $cuerpo = "";

              foreach ($recibos as $value) {
                $cuerpo .= '<tr class="recibo">'.
                              '<td style="text-align:center">'.(($value['PREST'] == NULL || $value['PREST'] == 0) ? '<input type="checkbox" value="" class="chekeado" />' : '<span class="badge bg-red">en proceso</span>').'</td>'.
                              '<td>'.$value['COD_FACT'].'</td>'.
                              '<td>'.$value['SERIE_RECIBO'].'</td>'.
                              '<td>'.$value['NUMERO_RECIBO'].'</td>'.
                              '<td>'.$value['SUMINISTRO'].'</td>'.
                              '<td>'.$value['FECHA_EMISION_RECIBO'].'</td>'.
                              '<td>'.$value['PERIODO'].'</td>'.
                              '<td>'.$value['NOMBRE'].'</td>'.
                              '<td style="text-align:center">';
                if($value['ESTADO_RECIBO'] == 'I') $cuerpo .= '<span class="badge bg-red">PENDIENTE</span></td>';
                else if($value['ESTADO_RECIBO'] == 'P') $cuerpo .= '<span class="badge bg-green">PAGADO</span></td>';
                else if($value['ESTADO_RECIBO'] == 'R') $cuerpo .= '<span class="badge bg-yellow">REFINANCIADO</span></td>';
                else if($value['ESTADO_RECIBO'] == 'C') $cuerpo .= '<span class="badge bg-info">CONVENIO</span></td>';
    
                $cuerpo .= '<td style="text-align:right">'.number_format(floatval($value['TOTAL_RECIBO'])/* - floatval($value['DESCUENTO'])*/  ,2,'.','').'</td>'.
                           '</tr>';
              }

              // LISTA DE RECIBOS RECLAMADOS
              $ListReclamos = $this->ReclamoFonavi_model->get_LstRecibos_reclamados($recibos[0]['CODIGO']);
              $lstRecl = "";

              foreach ($ListReclamos as $rowLst) {
                $lstRecl .= '<tr class="lstReclamos">'.
                              '<td>'.$rowLst['COD_REC'].'</td>'.
                              '<td>'.$rowLst['FEC_REG'].'</td>'.
                              '<td>'.$rowLst['HORA_REG'].'</td>'.
                              '<td>'.$rowLst['SUMINISTRO'].'</td>'.
                              '<td>'.$rowLst['PROYECTO'].'</td>'.
                              '<td>'.$rowLst['PRESTATARIO'].'</td>'.
                              '<td>'.$rowLst['NOMBRE']." ".$rowLst['APEPAT']." ".$rowLst['APEMAT'].'</td>'.
                              '<td>'.$rowLst['USUARIO'].'</td>'.
                              '<td style="text-align:center">';
                if($rowLst['ESTADO'] == 1) $lstRecl .= '<span class="badge bg-green">REGISTRADO</span></td>';
                else if($rowLst['ESTADO'] == 0) $lstRecl .= '<span class="badge bg-red">ANULADO</span></td>';
                else  $lstRecl .= '<span class="badge bg-red">ANULADO</span></td>';
                if($rowLst['ESTADO'] == 1) $lstRecl .= '<td>'.'<div class="dropdown drop">
                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-filter" aria-hidden="true"></i> Opciones<span class="caret"></span>
                            </button>'.
                            '<ul class="dropdown-menu dropdown-menu-right bg_color">
                                  <li>  
                                      <a onclick="detalle_solicitud('.$rowLst['COD_REC'].')" id="aDetalle" class="hover_yellow" >
                                          <i class="fa fa-tasks" aria-hidden="true"></i>VER DETALLE
                                      </a>
                                  </li>
                                  <li class="divider"></li> 
                                  <li>  
                                      <a onclick="invalidar_solicitud('.$rowLst['COD_REC'].')" id="aInvalidar" class="hover_yellow" >
                                          <i class="fa fa-trash" aria-hidden="true"></i> ANULAR
                                      </a>
                                  </li>
                                  <li class="divider"></li> 
                                  <li>  
                                      <a onclick="SendReportPDF('.$rowLst['COD_REC'].')" id="aInvalidar" class="hover_yellow" >
                                          <i class="fa fa-file-pdf-o" aria-hidden="true"></i> REPORTE PDF
                                      </a>
                                  </li>'.
                    '</td>';
                    else $lstRecl .= '<td></td>';
              }

            $json = array('result' => true, 'mensaje' => 'OK','recibos' => $cuerpo, 'general' => $recibos,'reclamados' => $lstRecl);
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

        public function invalidar_solicitud(){
          $codReclamo = $this->input->post('codRec');
          $codUsu = $this->input->post('codUser');
          $ajax = $this->input->get('ajax');
          if($ajax){
               // LISTA DE RECIBOS RECLAMADOS
               $resp = $this->ReclamoFonavi_model->upd_estadoReclamo((int)$codReclamo, (int)$codUsu);
              if($resp){
                 $json = array('result' => true, 'mensaje' => 'OK');
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

        public function ViewDetalleReclamo(){
          $codPrest = $this->input->post('codPrest');
          $ajax = $this->input->get('ajax');
          if($ajax){
               // LISTA DE RECIBOS RECLAMADOS
               $ListReclamos = $this->ReclamoFonavi_model->get_Reclamos_viewDetalle($codPrest);
              if($ListReclamos){
                 $json = array('result' => true, 'mensaje' => 'OK','ResulDetalle' => $ListReclamos);
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

        public function listarReclamos($prestatario){
          $ajax = $this->input->get('ajax');
          if($ajax){
               // LISTA DE RECIBOS RECLAMADOS
               $ListReclamos = $this->ReclamoFonavi_model->get_LstRecibos_reclamados($prestatario);
               $lstRecl = "";
              if($ListReclamos){
               foreach ($ListReclamos as $rowLst) {
                 $lstRecl .= '<tr class="lstReclamos">'.
                               '<td>'.$rowLst['COD_REC'].'</td>'.
                               '<td>'.$rowLst['FEC_REG'].'</td>'.
                               '<td>'.$rowLst['HORA_REG'].'</td>'.
                               '<td>'.$rowLst['SUMINISTRO'].'</td>'.
                               '<td>'.$rowLst['PROYECTO'].'</td>'.
                               '<td>'.$rowLst['PRESTATARIO'].'</td>'.
                               '<td>'.$rowLst['NOMBRE']." ".$rowLst['APEPAT']." ".$rowLst['APEMAT'].'</td>'.
                               '<td>'.$rowLst['USUARIO'].'</td>'.
                               '<td style="text-align:center">';
                 if($rowLst['ESTADO'] == 1) $lstRecl .= '<span class="badge bg-red">PENDIENTE</span></td>';
                 else if($rowLst['ESTADO'] == 0) $lstRecl .= '<span class="badge bg-green">ANULADO</span></td>';
                 else  $lstRecl .= '<span class="badge bg-green">ANULADO</span></td>';
                 $lstRecl .= '<td>'.'<div class="dropdown drop">
                             <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                 <i class="fa fa-filter" aria-hidden="true"></i> Opciones<span class="caret"></span>
                             </button>'.
                             '<ul class="dropdown-menu dropdown-menu-right bg_color">
                                   <li>  
                                       <a onclick="detalle_solicitud('.$rowLst['COD_REC'].')" id="aDetalle" class="hover_yellow" >
                                           <i class="fa fa-tasks" aria-hidden="true"></i>VER DETALLE
                                       </a>
                                   </li>
                                   <li class="divider"></li> 
                                   <li>  
                                       <a onclick="invalidar_solicitud('.$rowLst['COD_REC'].')" id="aInvalidar" class="hover_yellow" >
                                           <i class="fa fa-trash" aria-hidden="true"></i> INVALIDAR
                                       </a>
                                   </li>'.
                 '</td>';
                }
                 $json = array('result' => true, 'mensaje' => 'OK','recibos' => $cuerpo, 'general' => $recibos,'reclamados' => $lstRecl);
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

        public function save_reclamoFonavi(){
          $recibos = $this->input->post('recibos');
          $dni = $this->input->post('dniSolic');
          $motivo = $this->input->post('motivo');
          $docs = $this->input->post('documentos');
          $observ = $this->input->post('observ');
          $sumit = $this->input->post('suminist');
          $prestatario = (int)$this->input->post('prestatario');
          $user = (int)$this->input->post('usuario');
          // echo ($recibos." / ".$dni." / ".$motivo." / ".$docs." / ".$observ." / ".$sumit." / ".$user);
          $ajax = $this->input->get('ajax');
          if($ajax){
            // $this->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);  
            $idReclamo = $this->ReclamoFonavi_model->create_ReclamoFonavi($dni, $motivo, $docs, $observ, $prestatario, $user);
            if($idReclamo != 0){
              
              $detalle = $this->ReclamoFonavi_model->create_ReclamoFonavi_det($recibos, (int)$idReclamo);
              // $detalle = $idReclamo;
                  if($detalle){
                    // $this->trans_commit(); //**** */
                    $json = array('result' => true, 'mensaje' => $this->mensaje_create);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                  } else {
                    $json = array('result' => false, 'mensaje' => $this->mensaje_no_create_sol);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    // $this->trans_rollback(); //**** */
                    echo json_encode($json);
                  }
            } else {
              $json = array('result' => false, 'mensaje' => $this->mensaje_no_create);
              header('Access-Control-Allow-Origin: *');
              header('Content-Type: application/x-json; charset=utf-8');
              // $this->trans_rollback(); //**** */
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
?>