<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class Documento_externo_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'INGRE_EXTERNO';
            
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
                $this->data['view'] = 'tramite_Documentario/externo_Documento_view';
                $this->data['breadcrumbs'] = array(array('Ingresar Externos', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function fecha_actual(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $dias = $this->Documento_model->verifico_Max_Dias_Externo();
                $data['result'] = true;
                $data['fecha'] = date("d-m-Y");
                $fecha_actual = date("d-m-Y");
                $data['fecha_posterior']  = date("d-m-Y",strtotime($fecha_actual."+ ".$dias." days"));
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function IngresarExterno(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $idPersona = $_SESSION['user_id'];
                $oficina = $_SESSION['NSOFICOD'];
                $area = $_SESSION['NSARECOD'];
                $asunto = $this->input->post("txtAsunto");
                $observaciones = $this->input->post("observaciones");
                $contenido = $this->input->post("contenido");
                $suministro = $this->input->post("suministro");
                $numDocumento = $this->input->post("numDocumento");
                $correoEmisor = $this->input->post("correoEmisor");
                $telefonoEmisor = $this->input->post("telefonoEmisor");
                $Tipo_doc = $this->input->post("Tipo_doc");
                $observaciones = trim(preg_replace('/\s\s+/', ' ', $observaciones));
                $foliosDoc = $this->input->post("folioDoc");
                $solicitante = $this->input->post("Solicitante"); 
                $destinatarios = json_decode($_POST["destinatarios"]);
                //var_dump($asunto, $observaciones, $contenido, $suministro, $foliosDoc);
                $fechaMaxAtencion = $this->input->post("fecha_maxima");
                $fechaMax = strtotime($fechaMaxAtencion);
                $fechaMaxima = date('d/m/Y', $fechaMax);
                $Param_documento =  array(
                    'AREADOC'        => $area,
                    'OFICINADOC'     => $oficina,
                    'IDTIPDOCUMENTO' => 21,
                    'IDPERSONACREA'  => $idPersona,
                    'NUMERODOCUMENTO'=> '',
                    'ASUNTO'         => $asunto,
                    'OBSERVACIONES'  => $observaciones,
                    'CONTENIDO'      => $contenido,
                    'FOLIOSDOC'      => $foliosDoc,
                    'FOLIOSTOTALES'  => $foliosDoc,
                    'DOCIDENTIFICACION'  => $Tipo_doc,
                    'NUMDOCIDENTI'   => $numDocumento,
                    'CORREOCLIENTE'  => $correoEmisor,
                    'TELEFONO'       => $telefonoEmisor,
                    'SUMINISTRO_EXTERNO' => ( (strlen(trim($suministro)) !=0) ? $suministro : ''),
                    'SOLICITANTE_EXTERNO' => trim($solicitante),
                    'TIPO_EXTERNO'   => 1,
                    'HORA_CREACION'  => date("h:i:s"),
                    'ANIO'           => date("Y"),
                    'FECHACREACION'  => date("d/m/Y"),
                    'ESTADO'         => 1,
                    'AREACREA'       => $_SESSION['DEPENDENCIA_ORIGEN'],
                    'INDGERENCIA'    => $_SESSION['IND_GERENCIA'],
                    'SIGLAAREAGEN'   => $_SESSION['SIGLA_AREA'],
                    'SIGLAPERSONAGEN'=> (($_SESSION['IND_GERENCIA'] == 1) ? '' : $_SESSION['SIGLA_USUARIO'] )
                );
                $resp = $this->Documento_model->regDocumentoExterno($Param_documento, $idPersona,$destinatarios, $asunto, $observaciones, $contenido, $suministro, $foliosDoc, $fechaMaxima);
                header('Content-Type: application/json');
                echo json_encode($resp);
                
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function ListarDocExterno(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $fecha_inicio = $this->input->post("fecha_inicio");
                $fecha_fin = $this->input->post("fecha_fin");
                $data = $this->Documento_model->get_list_externos($fecha_inicio, $fecha_fin);
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function SubidaSingular(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $idDocumento = json_decode($this->input->post("idDocumento"), true);
                $this->load->model('Tramite_documentario/Documento_model');
                $archivos = array();
                $extension = explode(".", $_FILES["file"]["name"] );
                $tam = count($extension);
                $_FILES["file"]["name"] = "traDocExt_".date('d_m_Y_H_i_s').'_'.$idDocumento."_".rand(1, 15000).".".$extension[$tam-1];
                $target_file = URL_ARCHIVOS_TRAMITE_EXTERNO.basename($_FILES["file"]["name"]);
                $uploadfolder = $_SERVER['DOCUMENT_ROOT'].URL_ARCHIVOS_TRAMITE_EXTERNO;
                $filename = $_FILES['file']['name'];
                if (file_exists($target_file)) {
                    echo json_encode(array("type" => "danger", "code" => "2", "title" => "ERROR", "message" => "Archivo ya existe"));
                    return;
                }else{
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfolder.$filename)) {
                        $archivos = array(
                            "DOCREFERENCIA"   => $idDocumento,
                            "ENLACEDOCUMENTO" => $target_file,
                            "ESTADO"          => "1"
                        );
                        $respuesta =  $this->Documento_model->insertArchivo($idDocumento, $archivos);
                        if($respuesta){
                            echo json_encode(array("type" => "success", "code" => "1", "title" => "CORRECTO", "message" => "Datos Actualizados correctamente.", "ruta" => $target_file ));
                            return ;
                        }
                    } else {
                        echo json_encode(array("type" => "danger", "code" => "2", "title" => "ERROR", "message" => "No se pudo subir el archivo"));
                        return;
                    }
                }
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        private function creo_codi_barras($numero,$mensaje){
            $this->load->library('codi_barra_lib');
            $mensaje = trim($mensaje);
            $barcode=$this->codi_barra_lib->cargar($mensaje);
            $barcode->setEanStyle(false);
            $barcode->setShowText(false);
            $barcode->setPixelWidth(2);
            $barcode->setBorderWidth(0);
            $nombre ='CODI_BARRA'.trim($numero).$_SESSION['login'].date("d-m-Y_h_i_s");
            $barcode->saveBarcode('assets/Tramite_documentario/codigo_barras/'.$nombre.'.jpg');
            return $nombre;
        }

        public function crear_ticket(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                if($this->input->server('REQUEST_METHOD') == 'POST'){
                    $array = json_decode($this->input->post('imprimir_ticket'));
                    $this->load->model('Tramite_documentario/Documento_model');
                    $resp = $this->Documento_model->getTicketExterno($array[0]);
                    $idper = $_SESSION['user_id'];
                    $this->load->library('Imprimir_ticket_tramite');
                    $width = 300;  
                    $height = 82; 
                    $pageLayout = array($width, $height);
                    $pdf = new Imprimir_ticket_tramite('L', 'pt', $pageLayout, true, 'UTF-8', false);
                    // set header and footer fonts

                    // set margins
                    $pdf->SetLeftMargin(0);
                    $pdf->SetRightMargin(0);
                    $pdf->SetTopMargin(0);
                    $pdf->setPrintHeader(false);
                    $pdf->SetFooterMargin(0);
                    $pdf->setPrintFooter(false);
                    $pdf->setCellPaddings(0,0,0,0);

                    // set auto page breaks
                    $pdf->SetAutoPageBreak(false, 0);

                    // set image scale factor
                    //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    // add a page

                    $codigo_barra = $this->creo_codi_barras($resp[0]->NUMERODOCUMENTO, '*'.str_pad($resp[0]->NUMERODOCUMENTO, 9, "0", STR_PAD_LEFT).'*');
                    /*generar el codigo de barras  */
                    if ($resp[0]->DOCIDENTIFICACION == "1"){
                        $tipo ='DNI:'; 
                    }else{
                        $tipo ='RUC:';
                    }
                    $pdf->AddPage();
                    $pdf->SetFont('helveticaB', '',6.7);
                    $mitad=150;
                    $pdf->writeHTMLCell(60, 5, 55, 12 ,"<p>SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(60, 5, ($mitad+55), 12 ,"<p>SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
                    $pdf->SetFont('helvetica', '',6);
                    $pdf->SetXY(7,21); 
                    $pdf->Write(0, 'Solicitante:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(40,21); 
                    $pdf->Write(0, $resp[0]->SOLICITANTE_EXTERNO, '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(7,30); 
                    $pdf->Write(0, $tipo, '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(22,30); 
                    $pdf->Write(0, $resp[0]->NUMDOCIDENTI ,'', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(70,30); 
                    $pdf->Write(0, 'Pag.:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(90,30); 
                    $pdf->Write(0, $resp[0]->FOLIOSDOC, '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(7,40); 
                    $pdf->Write(0,'NR:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helveticaB', '',7);
                    $pdf->SetXY(19,39); 
                    $pdf->Write(0,str_pad($resp[0]->NUMERODOCUMENTO, 9, "0", STR_PAD_LEFT), '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helvetica', '',16);
                    $pdf->SetXY(23,50); 
                    //$pdf->Write(0,'*'.str_pad($resp[0]->NUMERODOCUMENTO, 9, "0", STR_PAD_LEFT).'*', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->Image('assets/Tramite_documentario/codigo_barras/'.$codigo_barra.'.jpg', 23, 51.5, 100, 16.5, '', '', '', false, 300, '', false, false, 0);
                    $pdf->SetFont('helvetica', '',6);
                    $pdf->SetXY(70,40); 
                    $pdf->Write(0,'FR:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(80,40); 
                    $pdf->Write(0,$resp[0]->FECHACREACION.'  '.$resp[0]->HORA_CREACION, '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helvetica', '',5);
                    $pdf->SetXY(5,70);
                    $pdf->Write(0,'Tra. Documentario', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helvetica', '',6.5);
                    $pdf->SetXY(49,70);
                    $pdf->Write(0,'(No es señal de aceptación)', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helvetica', '',6);
                    /* la otra mitad */
                    $pdf->SetXY(($mitad + 7),21); 
                    $pdf->Write(0, 'Solicitante:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(($mitad+40),21); 
                    $pdf->Write(0, $resp[0]->SOLICITANTE_EXTERNO, '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(($mitad +7),30); 
                    $pdf->Write(0, $tipo, '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(($mitad+22),30); 
                    $pdf->Write(0, $resp[0]->NUMDOCIDENTI ,'', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(($mitad+70),30); 
                    $pdf->Write(0, 'Pag.:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(($mitad+90),30); 
                    $pdf->Write(0, $resp[0]->FOLIOSDOC, '', 0, 'L', true, 0, false, false, 0); 
                    $pdf->SetXY(($mitad+7),40); 
                    $pdf->Write(0,'NR:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(($mitad+70),40); 
                    $pdf->Write(0,'FR:', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetXY(($mitad+80),40); 
                    $pdf->Write(0,$resp[0]->FECHACREACION.'  '.$resp[0]->HORA_CREACION, '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helveticaB', '',7);
                    $pdf->SetXY(($mitad+19),39); 
                    $pdf->Write(0,str_pad($resp[0]->NUMERODOCUMENTO, 9, "0", STR_PAD_LEFT), '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helvetica', '',16);
                    $pdf->SetXY(($mitad+23),50); 
                    //$pdf->Write(0,'*'.str_pad($resp[0]->NUMERODOCUMENTO, 9, "0", STR_PAD_LEFT).'*', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->Image('assets/Tramite_documentario/codigo_barras/'.$codigo_barra.'.jpg', ($mitad+23), 51.5, 100, 16.5, '', '', '', false, 300, '', false, false, 0);
                    $pdf->SetFont('helvetica', '',5);
                    $pdf->SetXY(($mitad+5),70);
                    $pdf->Write(0,'Tra. Documentario', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('helvetica', '',6.5);
                    $pdf->SetXY(($mitad+49),70);
                    $pdf->Write(0,'(No es señal de aceptación)', '', 0, 'L', true, 0, false, false, 0);
                    
                    /* imprimo el pdf */
                    $pdf->Output('ticket.pdf', 'I');
                    unlink('assets/Tramite_documentario/codigo_barras/'.$codigo_barra.'.jpg');
                }
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        

    }
?>