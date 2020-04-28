<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class corregir_Documento_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'CORRE_DOC';
            
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
                $this->data['view'] = 'tramite_Documentario/corre_Documento_view';
                $this->data['breadcrumbs'] = array(array('Crear Documentos', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }
        public function getDocsCreadosxUsu() {
            $idper = $_SESSION['user_id'];
            $numero = $this->input->post("numero");
            $anio = $this->input->post("anio");
    
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getDocsCreadosxUsu($idper, $numero, $anio);
    
            header('Content-Type: application/json');
            echo json_encode($data); 
        }

        public function getMovsCorreccion() {
            $cod_doc = $this->input->post("cod_doc");
            $indCopia = $this->input->post("indCopia");
            $idper = $_SESSION['user_id'];
        
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getMovsCorreccion($cod_doc, $indCopia, $idper);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }


        public function getTipoxTipoDoc(){
            $cod_doc = $this->input->post("iddoc");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->CargoPersonalArea($cod_doc);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }


        public function actualizarFoliosCorrecion() {
            $cod_doc       = $this->input->post("cod_doc");
            $foliosDoc     = $this->input->post("foliosDoc");
            $asunto        = $this->input->post("asunto");
            $observaciones = $this->input->post("observaciones");
            $contenido     = $this->input->post("contenido");
            $fechaAtencion = $this->input->post("fe_max_ate");
            $fechaMax = strtotime($fechaAtencion);
            $fechaMaxima = date('d/m/Y', $fechaMax);
            $Param_documento =  array(
                'ASUNTO'            => $asunto,
                'FOLIOSDOC'         => $foliosDoc,
                'OBSERVACIONES'     => $observaciones,
                'CONTENIDO'         => $contenido,
                'FECHAMAXATENCION'  => $fechaMaxima
            );
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->actualizarFoliosCorrecion($Param_documento, $cod_doc, $fechaMaxima);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function actualizarFoliosTotalCorrecion() {
            $cod_doc = $this->input->post("cod_doc");
            $folios = $this->input->post("folios");
            $this->load->model('Tramite_documentario/Documento_model');
            $Param_documento =  array(
                'FOLIOSTOTALES' => $folios
            );
            $data = $this->Documento_model->actualizarFoliosCorrecion($Param_documento, $cod_doc);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function actualizaMovDestino() {   
            $dni         = $this->input->post("dni");   
            $idDepend    = $this->input->post("idDepend");
            $idMov       = $this->input->post("cod_mov");   
            $indPersonal = $this->input->post("ind_personal");
            $indExterno  = $this->input->post("indExterno");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->actualizaMovDestino($dni, $idDepend, $idMov, $indPersonal, $indExterno);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function getMovFoliosCorreccion() {
            $cod_doc = $this->input->post("cod_doc");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getMovFoliosCorreccion($cod_doc);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }


        public function actualizarFoliosTotalMovCorrecion() {
            $cod_mov = $this->input->post("cod_mov");
            $folios = $this->input->post("folios");
    
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->actualizarFoliosTotalMovCorrecion($cod_mov, $folios);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        

        public function eliminarMovCorrecion() {
            $cod_mov = $this->input->post("cod_mov");
            
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->eliminarMovCorrecion($cod_mov);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }


        public function SubidaSingular() {
            $idDocumento = json_decode($this->input->post("idDocumento"), true);
            $this->load->model('Tramite_documentario/Documento_model');
            $archivos = array();
            $extension = explode(".", $_FILES["file"]["name"] );
            $tam = count($extension);
            $_FILES["file"]["name"] = "tram_doc_int".date('d_m_Y_H_i_s').'_'.$idDocumento."_".rand(1, 15000).".".$extension[$tam-1];
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
                        echo json_encode(array("type" => "success", "code" => "1", "title" => "CORRECTO", "message" => "Datos Actualizados correctamente.", "ruta" => $target_file ));
                        return ;
                    }
                } else {
                    echo json_encode(array("type" => "danger", "code" => "2", "title" => "ERROR", "message" => "No se pudo subir el archivo"));
                    return;
                }
            }
             
        }

        public function getDocsAnexados(){
            $iddoc = $this->input->post("idDoc");
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

        public function setDeleteFile(){
            $iddoc = $this->input->post("idDoc");
            $IdEnlace = $this->input->post("IdEnlace");
            $ruta = $this->input->post("ruta");
            $this->load->model('Tramite_documentario/Documento_model');
            $estado = array(
                'ESTADO' => "0"
            );
            $data = $this->Documento_model->setDeleteFile($iddoc, $IdEnlace, $estado);
            if($data){
                unlink($_SERVER['DOCUMENT_ROOT'].$ruta);
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    
        public function guardoEstRef(){
            $referencia = $this->input->post("referencia");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->guardoEstRef($referencia);
            header('Content-Type: application/json');
            echo json_encode($data);
        }




        public function agregarDestinoCorrecion() {
      
            $idPersona          = $_SESSION['user_id'];
            $dniReceptor        = $this->input->post("dni");
            $tip_doc            = $this->input->post("tip_doc");
            $foli               = $this->input->post("foli");
            $id_doc             = $this->input->post("id_doc");
            $depenReceptor      = $this->input->post("idDepend");
            $cod_mov            = $this->input->post("cod_mov");
            $indGerente         = $this->input->post("indGerente");
            $indPersonal        = $this->input->post("indPersonal");
            $movimiento         = array($idPersona, 'NUEVO MOVIMIENTO CORRECCION');
            $encargado = 0;
            $this->load->model('Tramite_documentario/Documento_model');
            if($indPersonal == 0){
                $encargado = $this->Documento_model->getEncargadoEntidad($dniReceptor); 
            }
            $ParamMovimiento  = array(
                'IDDOCUMENTO'          =>$id_doc ,
                'IDPERSONACREA'        => $idPersona,
                'IDDEPENDENCIACREA'    =>$_SESSION['DEPENDENCIA_ORIGEN'], 
                'OFICINADOC'           =>$_SESSION['NSOFICOD'],
                'IDTIPDOCUMENTO'       =>$tip_doc ,
                'IDDEPENDENCIAENVIA'   => (($indPersonal == 1)  ? ($_SESSION['DEPENDENCIA_ORIGEN']) : ($dniReceptor) )  ,
                'IDPERSONAENVIA'       => (($indPersonal == 1) ? ($dniReceptor) : ($encargado) ) ,
                'FECHACREACION'        =>date("d/m/Y"),
                'FECHARECEPCION'       =>'',
                'FOLIOS'               =>$foli ,
                'INDCOPIA'             =>0,
                'ESTADOENVIO'          =>1,
                'ESTADOELIMINADO'      =>0,
                'INDGERENCIA'          => (($indPersonal == 1 ) ? 0 : 1),
                'INDREF'               =>0,
                'INDDERIVA'            =>'0',
                'IDMOVIMIDERIVADO'     =>0,
                'INDEXTER'             => 0,
                'INDPERSONAL'          => $indPersonal 
            );
            $data = $this->Documento_model->agregarDestinoCorrecion($ParamMovimiento);
    
            header('Content-Type: application/json');
            echo json_encode($data); 
        }


        public function agregarDestinoCopiaCorrecion() {
      
            $idPersona      = $_SESSION['user_id'];
            $dniReceptor    = $this->input->post("dni");
            $depenReceptor  = $this->input->post("idDepend");
            $tip_doc        = $this->input->post("tip_doc");
            $indGerente     = $this->input->post("indGerente");
            $cod_doc        = $this->input->post("cod_doc");
            $cod_mov        = $this->input->post("cod_mov");
            $folios         = $this->input->post("folios");
            $indPersonal    = $this->input->post("indPersonal");
            $this->load->model('Tramite_documentario/Documento_model');
            if($indPersonal == 0){
                $encargado = $this->Documento_model->getEncargadoEntidad($dniReceptor); 
            }
            $ParamMovimiento  = array(
                'IDDOCUMENTO'          => $cod_doc ,
                'IDPERSONACREA'        => $idPersona,
                'IDDEPENDENCIACREA'    =>$_SESSION['DEPENDENCIA_ORIGEN'], 
                'OFICINADOC'           =>$_SESSION['NSOFICOD'],
                'IDTIPDOCUMENTO'       =>$tip_doc ,
                'IDDEPENDENCIAENVIA'   => (($indPersonal == 1)  ? ($_SESSION['DEPENDENCIA_ORIGEN']) : ($dniReceptor) )  ,
                'IDPERSONAENVIA'       => (($indPersonal == 1) ? ($dniReceptor) : ($encargado) ) ,
                'FECHACREACION'        =>date("d/m/Y"),
                'FECHARECEPCION'       =>'',
                'FOLIOS'               =>$folios ,
                'INDCOPIA'             =>1,
                'ESTADOENVIO'          =>1,
                'ESTADOELIMINADO'      =>0,
                'INDGERENCIA'          => (($indPersonal == 1 ) ? 0 : 1),
                'INDREF'               =>0,
                'INDDERIVA'            =>'0',
                'IDMOVIMIDERIVADO'     =>0,
                'INDEXTER'             => 0,
                'INDPERSONAL'          => $indPersonal 
            );
            $data = $this->Documento_model->agregarDestinoCorrecion($ParamMovimiento);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function getReferenciasDocCorreccion(){
            $idper = $_SESSION['user_id'];
            $numero = $this->input->post("cod_doc");
            $tipo_Doc = $this->input->post("tipo_doc");
            $iddepen = $_SESSION['DEPENDENCIA_ORIGEN'];
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getDocumentosRefsedit($idper, $numero,$iddepen, $tipo_Doc);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function eliminaRefCorrecion(){
            $idper = $_SESSION['user_id'];
            $iddepen = $_SESSION['DEPENDENCIA_ORIGEN'];
            $cod_mov = $this->input->post("cod_mov");
            $cod_doc = $this->input->post("cod_doc");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->eliminaRefCorrecion($idper, $iddepen, $cod_mov, $cod_doc);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function agregaRefCorrecion(){
            $idper = $_SESSION['user_id'];
            $iddepen = $_SESSION['DEPENDENCIA_ORIGEN'];
            $cod_mov = $this->input->post("cod_mov");
            $cod_doc = $this->input->post("cod_doc");
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->agregarRefCorrecion($idper, $iddepen, $cod_mov, $cod_doc);
            header('Content-Type: application/json');
            echo json_encode($data);
        }


    }
?>