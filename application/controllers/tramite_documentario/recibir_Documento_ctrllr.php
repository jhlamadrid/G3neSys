<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class recibir_Documento_ctrllr extends CI_Controller{
        
        /**
         * Constructor
         */

        public function __construct() { 

            parent::__construct();
            $this->load->model('reclamo_no_facturacion/Reclamo_no_facturacion_model'); 

            $this->load->library('session');
            $this->load->library('acceso_cls');
            
            // Verificar si tiene acceso al sistema 
            $this->acceso_cls->isLogin();
            $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
            $this->data['userdata'] = $this->acceso_cls->get_userdata(); 
            $this->data['actividad'] = 'RECIBIR_DOCUMENTOS';
            
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']); 
            //$this->Global_model->findRol($_SESSION['userCod']); 
            //$this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['userCod']); 

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
            if($permiso){ 
                $this->data['proceso'] = $permiso['ACTIVINOMB'];  
                $this->data['id_actividad'] = $permiso['ID_ACTIV']; 
                $this->data['menu']['padre'] =  $permiso['MENUGENPDR'];  
                $this->data['menu']['hijo'] =  $permiso['ACTIVIHJO']; 
                if($_SESSION['DEPENDENCIA_ORIGEN'] == null){
                    $this->session->set_flashdata('mensaje', array('error', "El usuario no tiene asignada una dependecia motivo por el cual no puede al sistema WorkFlow, comunicarse con el area correspondiente para que le dén los permisos"));
                    redirect($this->config->item('ip').'inicio');
                    return;
                }else{
                    if($_SESSION['SIGLA_AREA'] ==''){
                        $this->session->set_flashdata('mensaje', array('error', "Ocurrio un problema con el area designada, comunicarse con el area correspondiente para que le dén los permisos"));
                        redirect($this->config->item('ip').'inicio');
                        return;
                    }else{
                        if($_SESSION['SIGLA_USUARIO'] == null){
                            $this->session->set_flashdata('mensaje', array('error', "EL usuario no tiene asignada una sigla de documento, comunicarse con el area correspondiente para que le dén los permisos"));
                            redirect($this->config->item('ip').'inicio');
                            return;
                        }
                    }
                } 
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function inicio(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->data['view'] = 'tramite_Documentario/recibir_Documento_view';
                $this->data['breadcrumbs'] = array(array('Recibir Documentos', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }


        public function getDocsRecibirUsuario() {

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $idper = $_SESSION['user_id'];
                $idDependencia = $_SESSION['DEPENDENCIA_ORIGEN'];
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getDocXrecibir($idper, $idDependencia);
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
            
        }

        public function fecha_actual(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $data['result'] = true;
                $data['fecha'] = date("Y-m-d");
                $data['fechaformato2'] = date("d-m-Y");
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function getDocsRecepcionados(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $idper = $_SESSION['user_id'];
                $idDependencia = $_SESSION['DEPENDENCIA_ORIGEN'];
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getDocXrecibidos($idper, $idDependencia, false);
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function recibirDocumento() {
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $idMov = $this->input->post("cod_mov");
                $tipo_mov_realiza = $this->input->post("tipo_mov_realiza");
                $this->load->model('Tramite_documentario/Documento_model');
                //var_dump($tipo_mov_realiza);
                //exit();
                if($tipo_mov_realiza  == '0'){
                    
                    $ParamMov  = array(
                        'ESTADOENVIO'       => 2,
                        'FECHARECEPCION'    =>date("d/m/Y"),
                        'HORA_RECEPCIONA'   =>date("H:i:s")

                    );
                    $data = $this->Documento_model->RecibirDocumentoUsuario($idMov, $ParamMov);
                   
                }else{
                    $data = $this->Documento_model->DevolverDocDeriva($idMov);
                    
                }
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
            
        }

        public function devolverDocumento(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $idMov = $this->input->post("cod_mov");
                $this->load->model('Tramite_documentario/Documento_model');
                $ParamMov  = array(
                    'ESTADOENVIO'       => 1,
                    'FECHARECEPCION'    => null,
                    'HORA_RECEPCIONA'   =>null
                );
                $data = $this->Documento_model->tranRecibirDocumeno($idMov, $ParamMov);
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }


        public function getDocsRecibirUsuarioFiltro(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $numero      = $this->input->post("numero");
                $metodo      = $this->input->post("metodo");
                $anio        = $this->input->post("anio");
                $archivado   = $this->input->post("archivado");
                if($archivado=='false'){
                    $archivado = false;
                }else{
                    $archivado = true;
                }
                $idper       = $_SESSION['user_id'];
                $idDependencia = $_SESSION['DEPENDENCIA_ORIGEN'];
                $this->load->model('Tramite_documentario/Documento_model');
                if($metodo =='recibir'){
                    if($numero=='%'){
                        $data = $this->Documento_model->getDocXrecibir($idper, $idDependencia);
                    }else{
                        $data = $this->Documento_model->getDocXrecibir_filtro($idper, $idDependencia, $numero, $anio);
                    }
                }else{
                    if($numero=='%'){
                        $data = $this->Documento_model->getDocXrecibidos($idper, $idDependencia, $archivado);
                    }else{
                        $data = $this->Documento_model->getDocXrecibidos_filtro($idper, $idDependencia, $numero, $anio ,$archivado);
                        
                    }   
                }
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }



        public function Listar_personal_x_dependencia(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $persona_Envia = $this->input->post("cod_mov");
                $data = $this->Documento_model->getListaPersonalArea($persona_Envia);
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function getReferenciasDocRecibir(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $idMov = $this->input->post("cod_mov");
                $idDoc = $this->input->post("cod_doc");
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getReferenciasDocRecibir($idMov);
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }


        public function derivarDocumento(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $movimiento_Deriva = json_decode($this->input->post("mov_dev"));
                $observacionDeriva = $this->input->post("obs");
                $personalDerivar   = $this->input->post("dni_dev");
                $folio_adicional   = $this->input->post("folios_adicionales");
                $fecha_maxima   = $this->input->post("fecha_maxima");
                $tipo_envio   = $this->input->post("tipo_envio");
                $fechaMax = strtotime($fecha_maxima);
                $fechaMaxima = date('d/m/Y', $fechaMax);
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->derivarDocumento($movimiento_Deriva, $observacionDeriva, $personalDerivar, $folio_adicional, $fechaMaxima, $tipo_envio);
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function archivarDocumento(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $Movimiento    = $this->input->post("cod_mov");
                $observacion   = $this->input->post("obs");
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->archivarDocumento($Movimiento, $observacion);
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function desArchivarDocumento(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $Movimiento    = $this->input->post("cod_mov");
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->desArchivarDocumento($Movimiento);
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }


        public function getDocsArchivados(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $idper = $_SESSION['user_id'];
                $idDependencia = $_SESSION['DEPENDENCIA_ORIGEN'];
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getDocXrecibidos_Aarchi($idper, $idDependencia);
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }






    }
?>