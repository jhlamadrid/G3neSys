<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class crea_Documento_ctrllr extends CI_Controller{
        
        public function __construct() { 

            parent::__construct();
            $this->load->model('reclamo_no_facturacion/Reclamo_no_facturacion_model'); 

            $this->load->library('session');
            $this->load->library('acceso_cls');
            
            // Verificar si tiene acceso al sistema 
            $this->acceso_cls->isLogin();
            $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
            $this->data['userdata'] = $this->acceso_cls->get_userdata(); 
            $this->data['actividad'] = 'CREA_DOCUMENTO';
            
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
                $this->load->model('Tramite_documentario/Documento_model');
                $this->data['tipo_doc'] = $this->Documento_model->getTipoxTipoDoc();
                $this->data['view'] = 'tramite_Documentario/crear_Documento_view';
                $this->data['breadcrumbs'] = array(array('Crear Documentos', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function  verificar_cargo(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $resp = $this->Documento_model->verifico_cargo();
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function verifico_Subida_archivo(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $resp = $this->Documento_model->verifico_Subida_archivo();
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function crearDocInterno() {

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $this->load->model('Tramite_documentario/Documento_model');
                $idPersona = $_SESSION['user_id'];
                $oficina = $_SESSION['NSOFICOD'];
                $area = $_SESSION['NSARECOD'];
                $tipdoc_int = $this->input->post("cbo_tipo_doc");
                $asunto = $this->input->post("txtAsunto");
                $observaciones = $this->input->post("observaciones");
                $contenido = $this->input->post("contenido");
                $observaciones = trim(preg_replace('/\s\s+/', ' ', $observaciones));
                $folios = $this->input->post("folios");
                $foliosDoc = $this->input->post("folioDoc");
                $tipo_cargo = $this->input->post("tipo_cargo");
                $destinatarios = json_decode($_POST["destinatarios"]);
                $copias = json_decode($_POST["copias"]);
                $refes = json_decode($_POST["refes"]);
                $tipoDocDesc = $this->input->post("tipo_doc_desc");
                $indResolver = $this->input->post("ind_resolver");
                $indExterno = $this->input->post("indExterno");
                $indPersonal = $this->input->post("indPersonal");
                $fechaMaxAtencion = $this->input->post("fechaAtencion");
                $fechaMax = strtotime($fechaMaxAtencion);
                $fechaMaxima = date('d/m/Y', $fechaMax);
                $Param_documento =  array(
                    'AREADOC'        => $area ,
                    'OFICINADOC'     => $oficina ,
                    'IDTIPDOCUMENTO' => $tipdoc_int,
                    'IDPERSONACREA'  => $idPersona,
                    'NUMERODOCUMENTO'=> '',
                    'ASUNTO'         => $asunto,
                    'OBSERVACIONES'  => $observaciones,
                    'CONTENIDO'      => $contenido,
                    'FOLIOSDOC'      => $foliosDoc,
                    'FOLIOSTOTALES'  => $folios,
                    'TIPO_EXTERNO'   => $indExterno,
                    'ANIO'           => date("Y"),
                    'FECHACREACION'  => date("d/m/Y"),
                    'HORA_CREACION'  => date("h:i:s"),
                    'FECHAMAXATENCION'=> $fechaMaxima,
                    'ESTADO'         => 1,
                    'AREACREA'       => $_SESSION['DEPENDENCIA_ORIGEN'],
                    'INDGERENCIA'    => $_SESSION['IND_GERENCIA'],
                    'SIGLAAREAGEN'   => $_SESSION['SIGLA_AREA'],
                    'SIGLAPERSONAGEN'=> (($_SESSION['IND_GERENCIA'] == 1) ? '' : $_SESSION['SIGLA_USUARIO'] )
                );
                $resp = $this->Documento_model->regDocumentoInterno($Param_documento, $idPersona,$destinatarios, $copias, $refes, $tipoDocDesc, $indExterno,$tipdoc_int,$tipo_cargo,$indPersonal, $fechaMaxima);
    
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }

            
        }


        public function SubidaSingular() {
            $this->load->model('Tramite_documentario/Documento_model');
            $idDocumento = json_decode($this->input->post("idDocumento"), true);
            $archivos = array();
            $extension = explode(".", $_FILES["file"]["name"] );
            $tam = count($extension);
            $_FILES["file"]["name"] = "traDocInt_".date('d_m_Y_H_i_s').'_'.$idDocumento."_".rand(1, 15000).".".$extension[$tam-1];
            $target_file = URL_ARCHIVOS_TRAMITE_INTERNO.basename($_FILES["file"]["name"]);
            $uploadfolder = $_SERVER['DOCUMENT_ROOT'].URL_ARCHIVOS_TRAMITE_INTERNO;
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
                        echo json_encode(array("type" => "success", "code" => "1", "title" => "CORRECTO", "message" => "Archivos subidos correctamente." ,"ruta" => $target_file));
                        return ;
                    }
                    
                } else {
                    echo json_encode(array("type" => "danger", "code" => "2", "title" => "ERROR", "message" => "No se pudo subir el archivo"));
                    return;
                }
            }
             
        }
    
        public function Listar_tipos_documento() {
    
            $dni = $this->session->userdata('cDNI');
            $cargo = $this->session->userdata('c_cargo');
            $this->load->model('sistram/Crear_model');
            $data = $this->Crear_model->Listar_tipos_documento($dni, $cargo);
            return $data;
        }

        public function fecha_actual(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $data['result'] = true;
                $data['fecha']  = date("d-m-Y");
                $fecha_actual = date("d-m-Y");
                $data['fecha_anterior']  = date("d-m-Y",strtotime($fecha_actual."- 180 days"));
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }
    
        public function Listar_gerentes_y_subgerentes() {
    
            $this->load->model('sistram/Crear_model');
            $data = $this->Crear_model->Listar_gerentes_y_subgerentes();
    
            $cod_depen = trim($this->session->userdata('id_depen_aux'));
            if (count($data) > 0) {
                $arr = null;
                  $j = 0;
                for ($i = 0; $i < count($data); $i++) {
                   if (trim($data[$i]->id) != $cod_depen) {
                        $arr[$j] = array("id" => $data[$i]->id, "dependencia" => $data[$i]->dependencia );
                           $j++;
                    }
                 
                }
            }
    
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
    
        public function Listar_personal_dependencia_actual() {
            $id = $this->session->userdata('id_depen_aux');
            $depen_actual = $this->session->userdata('nombreDependencia');
            $this->load->model('sistram/Crear_model');
            $data = $this->Crear_model->Listar_personal_x_dependencia($id);
            foreach ($data as $k => $v) {
                $data[$k]->id = $id;
                $data[$k]->dependencia = $depen_actual;
            }
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    
        public function getDocumentosRefs() {
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $iddepen = $_SESSION['DEPENDENCIA_ORIGEN'];
                $idper = $_SESSION['user_id'] ;
                $numero = $this->input->post("numero");
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getDocumentosRefs($idper, $numero,$iddepen);
          
                header('Content-Type: application/json');
                echo json_encode($data);
            }else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function Listar_personal_x_gerencia(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $iddepen = $_SESSION['DEPENDENCIA_ORIGEN'];
                $idper = $_SESSION['user_id'];
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getPersonalArea($idper, $iddepen);
                header('Content-Type: application/json');
                echo json_encode($data);
            }else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function Listar_personal_x_gerencia_general(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $iddepen  = $this->input->post("id");
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getPersonalArea_general( $iddepen);
                header('Content-Type: application/json');
                echo json_encode($data);
            }else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }
    
        public function getDocsCreadosUsuario() {
            $idper = $_SESSION['user_id'];
            $this->load->model('Tramite_documentario/Documento_model');
            $tip_documento  = $this->input->post("tip_doc");
            $fecha_inicio   = $this->input->post("fecha_ini");
            $fecha_fin      = $this->input->post("fecha_fin");
            $estado_doc     = $this->input->post("esta_mis_doc");
            $data = $this->Documento_model->getDocsCreadosUsuario($idper, $tip_documento, $fecha_inicio, $fecha_fin, $estado_doc);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function Listar_dependencias_internos_general(){
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->Listar_dependencias();
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function Listar_dependencias_internos(){
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->Listar_dependencias_crea();
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    
        public function getAdjuntos() {
            $iddoc = $this->input->post("iddoc");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getAdjuntos($iddoc);
            $cont = 1;
            $arr_final = null;
            
            if (count($data) > 0) {
                $arr = null;
                for ($i = 0; $i < count($data); $i++) {
                    $arr = array(
                                "adjunto"          => "ARCHIVO - " . $cont, 
                                "ruta"             => MAIN_URL.$data[$i]->ENLACEDOCUMENTO, 
                                "rutaEnlace"       => $data[$i]->ENLACEDOCUMENTO, 
                                "DOCREFERENCIA"    =>$data[$i]->DOCREFERENCIA,
                                "IDENLACEARCHIVO"  =>$data[$i]->IDENLACEARCHIVO );
                    $arr_final[$i] = $arr;
                    $cont = $cont + 1;
                }
            }
    
    
    
            header('Content-Type: application/json');
            echo json_encode($arr_final);
        }

        public function getAreasRecepcionaron(){

            $iddoc = $this->input->post("iddoc");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getAreasRecepcionaron($iddoc);

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    
        public function getTipoDocxCargo() {
           $idcarg = $this->session->userdata('cargo_usuario');
           $idDepen = $this->session->userdata('id_depen_aux');
           $idPersona = $this->session->userdata('nPerId');
           
           
          if(($idcarg*1) != 81 && ($idcarg*1) != 80 && ($idcarg*1) != 3 &&
                  ($idcarg*1) != 51 && ($idcarg*1) != 52 && ($idcarg*1) != 57 && 
                  ($idcarg*1) != 58 && ($idcarg*1) != 17 && ($idcarg*1) != 26 && 
                  ($idcarg*1) != 166 && ($idcarg*1) != 167 && ($idcarg*1) != 168 && ($idcarg*1) != 31 && ($idcarg*1) != 72 ){
             
                $idcarg = 102 ;
            }	
           
              
            $this->load->model('sistram/Documento_model');
            $data = $this->Documento_model->getTipoDocxCargo($idcarg,$idDepen,$idPersona);
    
            return $data;
        }
        
        private function creo_codi_barras($numero,$mensaje){
            $this->load->library('codi_barra_lib');
            $mensaje = trim($mensaje);
            $barcode=$this->codi_barra_lib->cargar($mensaje);
            $barcode->setEanStyle(false);
            $barcode->setShowText(false);
            $barcode->setPixelWidth(2);
            $barcode->setBorderWidth(0);
            $nombre ='CODI_BARRA_CARGO'.trim($numero).$_SESSION['login'].date("d-m-Y_h_i_s");
            $barcode->saveBarcode('assets/Tramite_documentario/codigo_barras/'.$nombre.'.jpg');
            return $nombre;
        }

        public function imprimir_cargo(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('imprimir_cargo'));
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->getDatoMovimiento($array[0]);
                if(count($data)>0){
                    $this->load->library('Reporte_tramite_cargo');
                    $pdf = new Reporte_tramite_cargo(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    // set header and footer fonts
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    // set default monospaced font
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                    // set margins
                    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $pdf->SetHeaderMargin(0);
                    $pdf->SetFooterMargin(0);

                    // remove default footer
                    $pdf->setPrintFooter(false);

                    // set auto page breaks
                    //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                    // set image scale factor
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                    // add a page
                    $pdf->AddPage('P', 'A5');
                    $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                    $styleBar = array(
                        'position' => '',
                        'align' => 'C',
                        'stretch' => false,
                        'fitwidth' => true,
                        'cellfitalign' => '',
                        'border' => true,
                        'hpadding' => 'auto',
                        'vpadding' => 'auto',
                        'fgcolor' => array(0,0,0),
                        'bgcolor' => false, //array(255,255,255),
                        'text' => true,
                        'font' => 'helvetica',
                        'fontsize' => 8,
                        'stretchtext' => 4
                    );
                    $codigo_barra = $this->creo_codi_barras($array[0], 'E*'. $data[0]->PERSONA_ENVIA . '-'.$data[0]->FECHACREACION .'-' . $data[0]->HORA_CREO . 'R*' . $data[0]->PERSONA_RECIBE . '-' . $data[0]->FECHARECEPCION . '-' . $data[0]->HORA_RECEPCIONA);
                    $pdf->Image( base_url()."img/logo4.jpg", 3, 3, 40, 10, '', '', '', false, 300, '', false, false, 0);
                    $pdf->SetFont('helveticaB', '',12);
                    $pdf->writeHTMLCell(170, 5, 42, 12 ,"<p>CONSTANCIA DE RECEPCIÓN</p>", 0, 1, 0, true, 'L',  true);
                    //$pdf->Line(40, 17, 110, 17, $style);
                    $pdf->SetFont('helvetica', '',8);
                    $pdf->writeHTMLCell(90, 5, 103, 4 ,"<p>Fecha de Impresión :".date("d/m/Y")."</p>", 0, 1, 0, true, 'L',  true);
                    $pdf->SetFont('helveticaB', '',9);
                    $pdf->writeHTMLCell(70, 5, 5, 20 ,"<p> » AREA DE ENVÍO:  </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 5, 26 ,"<p> » PERSONA DE ENVÍO: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 5, 32 ,"<p> » FECHA DE ENVÍO: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 80, 32 ,"<p> » HORA DE ENVÍO: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->Line(5, 37, 143, 37, $style);
                    $pdf->writeHTMLCell(70, 5, 5, 40 ,"<p> » AREA DE RECEPCIÓN: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 5, 46 ,"<p> » PERSONA QUE RECEPCIONÓ: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 5, 52 ,"<p> » FECHA DE RECEPCIÓN: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 80, 52 ,"<p> » HORA DE RECEPCIÓN: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->Line(5, 57, 143, 57, $style);
                    $pdf->writeHTMLCell(70, 5, 5, 60 ,"<p> » ASUNTO: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 5, 90 ,"<p> » OBSERVACIÓN: </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 5, 120 ,"<p> » CONTENIDO: </p>", 0, 1, 0, true, 'L',  true);
                    // ASUNTO
                    $pdf->Line(5, 68 , 143, 68 , $style);
                    $pdf->Line(143, 68 ,143, 85 , $style);
                    $pdf->Line(143, 85 ,5, 85 , $style);
                    $pdf->Line(5, 85 ,5, 68, $style);
                    // OBSERVACION
                    $pdf->Line(5, 96 , 143, 96 , $style);
                    $pdf->Line(143, 96 ,143, 115 , $style);
                    $pdf->Line(143, 115 ,5, 115 , $style);
                    $pdf->Line(5, 115 ,5, 96, $style);
                    //CONTENIDO
                    $pdf->Line(5, 127 , 143, 127 , $style);
                    $pdf->Line(143, 127 ,143, 167 , $style);
                    $pdf->Line(143, 167 ,5, 167 , $style);
                    $pdf->Line(5, 167, 5, 127, $style);
                    // PARA EL CODIGO DE BARRAS 

                    $pdf->SetFont('helvetica', '',7);
                    $pdf->writeHTMLCell(137, 5, 7, 70 ,"<p> ".$data[0]->ASUNTO." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(137, 5, 7, 98 ,"<p> ".$data[0]->OBSERVACIONES." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(137, 5, 7, 130 ,"<p> ".$data[0]->CONTENIDO." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->SetFont('helvetica', '',7.2);
                    $pdf->writeHTMLCell(130, 5, 38, 20 ,"<p> ".$data[0]->AREA_CREA." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(150, 5, 43, 26 ,"<p> ".$data[0]->PERSONA_ENVIA." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(150, 5, 40, 32 ,"<p> ".$data[0]->FECHACREACION." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 110, 32 ,"<p> ".$data[0]->HORA_CREO." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(130, 5, 45, 40 ,"<p> ".$data[0]->AREA_ENVIA." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(150, 5, 56, 46 ,"<p> ".$data[0]->PERSONA_RECIBE."  </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(150, 5, 49, 52 ,"<p> ".$data[0]->FECHARECEPCION." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->writeHTMLCell(70, 5, 119, 52 ,"<p> ".$data[0]->HORA_RECEPCIONA." </p>", 0, 1, 0, true, 'L',  true);
                    $pdf->SetXY(5,170);
                    $pdf->Image('assets/Tramite_documentario/codigo_barras/'.$codigo_barra.'.jpg', 2, 168, 144, 21, '', '', '', false, 300, '', false, false, 0);

                    $pdf->Output('CARGO.pdf', 'I');
                    unlink('assets/Tramite_documentario/codigo_barras/'.$codigo_barra.'.jpg');
                }
                 
            }
        }
    
        public function getTipoxTipoDoc() {
            //$iddoc = $this->input->post("iddoc");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getTipoxTipoDoc();
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    
        public function Listar_personal_x_dependencia() {
    
            $id = $this->session->userdata('id_depen_aux');
            $dni = trim($this->session->userdata('cDNI'));
            $this->load->model('sistram/Crear_model');
            $data = $this->Crear_model->Listar_personal_x_dependencia($id);
            if (count($data) > 0) {
                $arr = null;
                for ($i = 0; $i < count($data); $i++) {
                    if (trim($data[$i]->dni) != $dni     ) { //&& (trim($data[$i]->acargo)*1) != 1
                        $arr[$i] = array("nombre" => $data[$i]->nombre, "dni" => $data[$i]->dni, "iddepend" => $id ,"cargo" => $data[$i]->acargo);
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
        
        
        public function Listar_personal_x_dependencia_total() {
    
            $id = $this->session->userdata('id_depen_aux');
            $dni = trim($this->session->userdata('cDNI'));
            $this->load->model('sistram/Crear_model');
            $data = $this->Crear_model->Listar_personal_x_dependencia($id);
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    
        public function getFuncionario() {
            $iddepen = $this->input->post("iddepen");
            $this->load->model('sistram/Documento_model');
            $data = $this->Documento_model->getFuncionario($iddepen);
            if (count($data) <= 0 || count($data) > 1) {
                $data = null;
            }
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        
        public function getDependenciaJeraquia() {
            $cod_depen = trim($this->session->userdata('id_depen_aux'));
            $tipo = $this->input->post("tipo");
            $this->load->model('sistram/Documento_model');
            $data = $this->Documento_model->getDependenciaJeraquia($cod_depen,$tipo);
            if (count($data) <= 0 ) {
                $data = null;
            }
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }

    }
?>