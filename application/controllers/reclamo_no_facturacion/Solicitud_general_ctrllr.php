<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    
    class Solicitud_general_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'solicitud_general';
            
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']); 
            //$this->Global_model->findRol($_SESSION['userCod']); 
            //$this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['userCod']); 

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
            if($permiso){ 
                $this->data['proceso'] = $permiso['ACTIVINOMB'];  
                $this->data['id_actividad'] = $permiso['ID_ACTIV']; 
                $this->data['menu']['padre'] =  $permiso['MENUGENPDR'];  
                $this->data['menu']['hijo'] =  $permiso['ACTIVIHJO']; 
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function inicio(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                if($_SESSION['accesoReclamos'] == null ||$_SESSION['accesoReclamos']['ARECOD'] == null){
                    $this->session->set_flashdata('mensaje', array('error', 'No se encuentra registrado en el sistema de reclamos. Los reclamos que ingresen no podrán ser registrados'));
                }
                $this->data['reclamos'] = $this->Reclamo_no_facturacion_model->getReclamosGeneralesList();
                $this->data['view'] = 'reclamo_no_facturacion/Solicitud_general_panel';
                $this->data['breadcrumbs'] = array(array('Solicitud General', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function nuevoReclamo(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                if($this->input->server('REQUEST_METHOD') == 'POST'){
                    $this->load->library('form_validation');
                    //$this->form_validation->set_rules('suministro', 'Suministro del cliente', 'required');
                    $this->form_validation->set_rules('apellido', 'Apellido Paterno del cliente', 'required');
                    $this->form_validation->set_rules('apellidoM', 'Apellido Materno del cliente', 'required');
                    $this->form_validation->set_rules('nombre', 'Nombre del cliente', 'required');
                    $this->form_validation->set_rules('numero', 'Numero del documento', 'required');
                    $this->form_validation->set_rules('calle', 'Calle donde vive el solicitante', 'required');
                    $this->form_validation->set_rules('descripcion', 'Descripción del problema ', 'required');
                    if($this->form_validation->run()){
                        $suministro = $this->input->post('suministro');
                        $modalidad = $this->input->post('modalidad');
                        $apellidoP = $this->input->post('apellido');
                        $apellidoM = $this->input->post('apellidoM');
                        $nombre = $this->input->post('nombre');
                        $tipoDoc1 = $this->input->post('tipoDoc1');
                        $numero = $this->input->post('numero');
                        $razonSocial = $this->input->post('razonSocial');
                        $calle = $this->input->post('calle');
                        $numeroM = $this->input->post('numeroM');
                        $manzana = $this->input->post('manzana');
                        $lote = $this->input->post('lote');
                        $urbanizacion = $this->input->post('urbanizacion');
                        $provincia = $this->input->post('provincia');
                        $distrito = $this->input->post('distrito');
                        $grupo_pobla = $this->input->post('grupo_poblacional');
                        $via = $this->input->post('via_pobla');
                        $telefono = $this->input->post('telefono');
                        $problema = $this->input->post('problema');
                        $presentacion = $this->input->post('descripcion');
                        
                        $textmodalidad = $this->Reclamo_no_facturacion_model->getNombreModalidad($modalidad);
                        $problemas = explode("-", $problema);

                        $usuario = null;
                        if(trim($suministro) !=''){
                            $existe_suministro = $this->Reclamo_no_facturacion_model->get_dire_sumin($suministro);
                            if(count($existe_suministro)>0){
                                if($tipoDoc1 == 6){

                                } else {
                                    $usuario = $this->Reclamo_no_facturacion_model->searchUsuario($tipoDoc1, $numero);
                                    if(!$usuario) $this->Reclamo_no_facturacion_model->saveUsuario($apellidoM, $apellidoP, $nombre, 
                                                                                                    $tipoDoc1, $numero, $telefono, $email);
                                    else $this->Reclamo_no_facturacion_model->updateUsuario($apellidoM, $apellidoP, $nombre, 
                                                                                            $tipoDoc1, $numero, $telefono, $email);
                                }
        
                                $resp = $this->Reclamo_no_facturacion_model->almacenarReclamo2(
                                    $suministro, $presentacion, $modalidad, 
                                    $numero, $lote, $urbanizacion,
                                    $provincia, $distrito, $grupo_pobla, $via, $telefono,
                                    $problemas, $numeroM, 
                                    $manzana, $tipoDoc1, $razonSocial
                                );
        
                                $this->session->set_flashdata('mensaje', array('success', 'Se ha registrado la Solicitu Particular correctamente.'));
                                redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_general');
                            }else{
                                $this->session->set_flashdata('mensaje', array('error', 'Debe de ingresar un codigo de suministro correcto'));
                                redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_general/nuevo');
                            }
                        }else{
                            if($tipoDoc1 == 6){

                            } else {
                                $usuario = $this->Reclamo_no_facturacion_model->searchUsuario($tipoDoc1, $numero);
                                if(!$usuario) $this->Reclamo_no_facturacion_model->saveUsuario($apellidoM, $apellidoP, $nombre, 
                                                                                                $tipoDoc1, $numero, $telefono, $email);
                                else $this->Reclamo_no_facturacion_model->updateUsuario($apellidoM, $apellidoP, $nombre, 
                                                                                        $tipoDoc1, $numero, $telefono, $email);
                            }
    
                            $resp = $this->Reclamo_no_facturacion_model->almacenarReclamo2(
                                $suministro, $presentacion, $modalidad, 
                                $numero, $lote, $urbanizacion,
                                $provincia, $distrito, $grupo_pobla, $via, $telefono,
                                $problemas, $numeroM, 
                                $manzana, $tipoDoc1, $razonSocial
                            );
    
                            $this->session->set_flashdata('mensaje', array('success', 'Se ha registrado la Solicitu Particular correctamente.'));
                            redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_general');
                        }


                    } else {
                        $this->session->set_flashdata('mensaje', array('error', 'Debe completar todos los campos con (*)'));
                        redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_general/nuevo');
                    }
                }
                $this->data['areas'] = $this->Reclamo_no_facturacion_model->getAreas();
                $this->data['provincias'] = $this->Reclamo_no_facturacion_model->getProvincias();
                $this->data['distritos'] = $this->Reclamo_no_facturacion_model->getDistritos($this->data['provincias'][0]['CPVCOD']);
                $this->data['grupo_pobla'] = $this->Reclamo_no_facturacion_model->getGrupo_pobla($this->data['distritos'][0]['CPVCOD'], $this->data['distritos'][0]['CDSCOD']);
                $this->data['via_pobla'] = $this->Reclamo_no_facturacion_model->getVia_pobla($this->data['grupo_pobla'][0]['CDPCOD'],$this->data['grupo_pobla'][0]['CPVCOD'], $this->data['grupo_pobla'][0]['CDSCOD'], $this->data['grupo_pobla'][0]['CGPCOD'] );
                $this->data['medios'] = $this->Reclamo_no_facturacion_model->getMedios();
                $this->data['tipoDoc'] = $this->Reclamo_no_facturacion_model->getTipoDocumento();
                $this->data['reclamos'] = $this->Reclamo_no_facturacion_model->getReclamosGenerales();
                $this->data['view'] = 'reclamo_no_facturacion/Solicitud_general';
                $this->data['breadcrumbs'] = array(array('Solicitud General', ''), array('Nuevo', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function buscar(){

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	    if($permiso){
                $ajax = $this->input->get('ajax');
                if($ajax){
                    $numero = $this->input->post('numero');
                    $tipo = $this->input->post('tipo');
                    $resp = $this->Reclamo_no_facturacion_model->getPersona($tipo, $numero);
                    if($resp){
                        $json = array('res' => true, 'msg' => 'ok', 'persona' => $resp);
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    } else {
                        $json = array('res' => false, 'msg' => $this->config->item('_mensaje_vacio'));
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
                } else {
                    $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        }
    
        public function cambiarProvincia(){

            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	    if($permiso){
                $ajax = $this->input->get('ajax');
                if($ajax){
                    $provincia = $this->input->post('provincia');
                    $resp = $this->Reclamo_no_facturacion_model->getDistritos($provincia);
                    $grupo_pobla='';
                    $via_pobla = '';
                    if(count($resp)>0){
                        $grupo_pobla = $this->Reclamo_no_facturacion_model->getGrupo_pobla($resp[0]['CPVCOD'], $resp[0]['CDSCOD']);
                        if(count($grupo_pobla)>0){
                            $via_pobla = $this->Reclamo_no_facturacion_model->getVia_pobla($grupo_pobla[0]['CDPCOD'], $grupo_pobla[0]['CPVCOD'], $grupo_pobla[0]['CDSCOD'], $grupo_pobla[0]['CGPCOD'] );
                        }
                    }
                    if($resp){
                        $json = array('res' => true, 'msg' => 'ok', 'distritos' => $resp , 'grupo_pobla' => $grupo_pobla , 'via' => $via_pobla );
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    } else {
                        $json = array('res' => false, 'msg' => $this->config->item('_mensaje_vacio'));
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
                } else {
                    $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        }

        public function cambiarDistrito(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	    if($permiso){
                $ajax = $this->input->get('ajax');
                if($ajax){
                    $provincia = $this->input->post('provincia');
                    $distrito = $this->input->post('distrito');
                    $grupo_pobla='';
                    $via_pobla = '';
                    $grupo_pobla = $this->Reclamo_no_facturacion_model->getGrupo_pobla($provincia, $distrito);
                    if(count($grupo_pobla)>0){
                        $via_pobla = $this->Reclamo_no_facturacion_model->getVia_pobla($grupo_pobla[0]['CDPCOD'], $grupo_pobla[0]['CPVCOD'], $grupo_pobla[0]['CDSCOD'], $grupo_pobla[0]['CGPCOD'] );
                    }
                    if($grupo_pobla){
                        $json = array('res' => true, 'msg' => 'ok',  'grupo_pobla' => $grupo_pobla , 'via' => $via_pobla );
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    } else {
                        $json = array('res' => false, 'msg' => $this->config->item('_mensaje_vacio'));
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
                } else {
                    $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        }

        public function cambiarGrupoPobla(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	    if($permiso){
                $ajax = $this->input->get('ajax');
                if($ajax){
                    $provincia = $this->input->post('provincia');
                    $distrito = $this->input->post('distrito');
                    $grupo_pobla=$this->input->post('grupo_pobla');
                    $via_pobla = '';
                    $via_pobla = $this->Reclamo_no_facturacion_model->getVia_pobla(13, $provincia, $distrito, $grupo_pobla );
                    if($via_pobla){
                        $json = array('res' => true, 'msg' => 'ok', 'via' => $via_pobla );
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    } else {
                        $json = array('res' => false, 'msg' => $this->config->item('_mensaje_vacio'));
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
                } else {
                    $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json = array('res' => false, 'msg' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        }

        public function verPDF($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID){
            $reclamo = $this->Reclamo_no_facturacion_model->getReclamo($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID);
            $persona = $this->Reclamo_no_facturacion_model->getPersona($reclamo['DOCIDENT_TIPDOC'], $reclamo['DOCIDENT_NRODOC']);
            $problemas = [$reclamo['CPID'], $reclamo['TIPPROBID'], $reclamo['SCATPROBID'], $reclamo['PROBID']];
            $resp = [$EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID];
            $this->pdfSolicitud($reclamo['UUCOD'], $reclamo['MOACOD'], $persona['APEPAT'], 
                                                $persona['NOMBRE'], $reclamo['DOCIDENT_TIPDOC'], $reclamo['DOCIDENT_NRODOC'],
                                                $reclamo['RAZSOCIAL'],$persona['TIPO_DE_VIA']." ".$persona['NOMBRE_DE_VIA'], $reclamo['RECDPNMUN'],
                                                $persona['MANZANA'], $persona['LOTE'], $persona['TIPO_DE_ZONA'],
                                                $reclamo['CPVCODDPR'], $reclamo['CDSCODDPR'], $reclamo['RECDPTELF'],
                                                $reclamo['RECDESC'], $persona['APEMAT'], $reclamo['RECDPMAIL'],
                                                $problemas, $resp,$reclamo['RECFCH'], $reclamo['RECHRA'], $persona['NUMERO']);
        }


        private function pdfSolicitud($suministro, $textmodalidad, $apellidoP, $nombre, $tipoDoc1, $numero, $razonSocial, $calle, $numeroM, $manzana, $lote, $urbanizacion, $provincia, $distrito, $telefono, $presentacion, $apellidoM, $email, $problema, $resp, $fecha, $hora, $numeroCalle){
            $presentacion = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $presentacion);
            $nombreProvincia = $this->Reclamo_no_facturacion_model->getNombreProvincia($provincia);
            $nombreDistrito = $this->Reclamo_no_facturacion_model->getNombreDistrito($provincia, $distrito);
            $textmodalidad = $this->Reclamo_no_facturacion_model->getNombreModalidad($textmodalidad);
            $cabecera = '';
            if($problema[0] == 2 && $problema[1] == 2){
                $cabecera = 'PROBLEMAS COMERCIALES NO RELATIVO A LA FACTURACION';
            } else {
                $cabecera = 'PROBLEMA OPERACIONALES';
            }

            $detalle = $this->Reclamo_no_facturacion_model->getDetalleReclamo($problema);
            
            $this->load->library('tcp'); 
            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->SetFont('dejavusans', '', 8, '', true);
            $pdf->AddPage();
            $html = '<img src="'.$this->config->item('ip').'img/logo3.png" style=" height:30px">'.
                    '<h3 style="text-align:center"> ANEXO 6 </h3>'.
                    '<h4 style="text-align:center">Solicitud de Atención de Problema de Alcance General</h4>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td style="width:32%"></td>'.
                            '<td style="width:22%"></td>'.
                            '<td style="width:10%"></td>'.
                            '<td colspan="2" style="width:20%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;">CODIGO DE SOLICITUD N°</td>'.
                            '<td style="width:15%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000"> '.$resp[0].'-'.$resp[1].'-'.$resp[2].'-'.$resp[3].'-'.$resp[4].'-'.$resp[5].'-'.$resp[6].'</td>'.
                        '</tr>'.
                    '</table><br /><br /><table width="100%" style="margin-top:5px">'.
                        '<tr>'.
                            '<td style="width:32%">N° DE SUMINISTRO</td>'.
                            '<td style="width:22%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000">'.$suministro.'</td>'.
                            '<td style="width:10%"></td>'.
                            '<td style="width:10%"></td>'.
                            '<td style="width:10%"></td>'.
                            '<td style="width:15%"></td>'.
                        '</tr>'.
                    '</table><br /><br /><table width="100%" style="margin-top:5px">'.
                        '<tr>'.
                            '<td style="width:60%" colspan="2">MODALIDAD DE ATENCIÓN DE LA SOLICITUD (ESCRITO/ TELEFONO/ WEB)</td>'.
                            '<td colspan ="4" style="width:40%;border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000">'.$textmodalidad.'</td>'.
                        '</tr>'.
                    '</table><br /><br /><table width="100%">'.
                        '<tr>'.
                            '<td style="width:35%">MOMENTO DE REGISTRO DE SOLICITUD</td>'.
                            '<td style="width:25%"></td>'.
                            '<td style="width:10%">FECHA</td>'.
                            '<td style="width:10%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000">'.$fecha.'</td>'.
                            '<td style="width:10%"> HORA</td>'.
                            '<td  style="width:10%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000">'.$hora.'</td>'.
                        '</tr>'.
                    '</table><br><br>'.
                    '<h5>NOMBRE DEL SOLICITANTE O REPRESENTANTE</h5>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center"> '.$apellidoP.'</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center"> '.$apellidoM.'</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000"; text-align:center> '.$nombre.'</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">Apellido Paterno</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">Apellido Materno</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000; text-align:center">Nombres</td>'.
                        '</tr>'.
                    '</table><br><br>'.
                    '<table width="100%">'.
                    '<tr>'.
                            '<td style="width:66%">NÚMERO DE DOCUMENTO DE INDENTIDAD (DNI, LE, CI)</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">'.$numero.'</td>'.
                        '</tr>'.
                    '</table><br><br>'.
                    '<table width="100%">'.
                    '<tr>'.
                            '<td style="width:33%">RAZÓN SOCIAL</td>'.
                            '<td style="width:66%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">'.$razonSocial.'</td>'.
                        '</tr>'.
                    '</table><br></br>'.
                    '<h5>DATOS DEL SOLICITANTE</h5>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td colspan="2" style="width:66%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> '.$calle.'</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> '.$numeroCalle.'</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> '.$manzana.'</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">'.$lote.'</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td colspan="2" style="width:66%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center"> (Calle, Jiron, Avenida)</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;&nbsp;N°</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;&nbsp;Mz</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000"> &nbsp;&nbsp;Lote</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">'.$urbanizacion.'</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">'.$nombreDistrito.'</td>'.
                            '<td colspan="3" style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000; text-align:center">'.$nombreProvincia.'</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">(Urbanización, barrio)</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">Distrito</td>'.
                            '<td colspan="3" style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000; text-align:center">Provincia</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td style="width:33%; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">'.$telefono.'</td>'.
                            '<td colspan="4" ></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td style="width:33%; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">Telefono</td>'.
                            
                            '<td colspan="4" ></td>'.
                        '</tr>'.
                    '</table><br>'.
                    '<h5>INFORMACIÓN DE LA SOLICITUD</h5>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td style="width:25%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000">Tipo de Problema</td>'.
                            '<td style="width:75%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">'.$detalle.'</td>'.
                        '</tr>'.
                    '</table><br>'. 
                    '<h5>BREVE DESCRIPCIÓN DEL PROBLEMA PRESENTADO</h5>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td style="width:100%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">'.$presentacion.'</td>'.
                        '</tr>'.
                    '</table><br><br>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td colspan="2" style="border-top: 1px solid #000; border-left: 1px solid #000; border-right:1px solid #000"><b>'.$cabecera.'</b></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td style="width:20%; text-align:center; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;'.$problema[0]."-".$problema[1]."-".$problema[2].'</td>'.
                            '<td style="width:80%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000"> &nbsp;&nbsp;&nbsp;'.$detalle.'</td>'.
                        '</tr>'.
                        '</table>'.
                    '<br><br><br><br><br>'.
                    '<b>CONFORMIDAD DEL SOLICITANTE</b><br>'.
                    'Mediante el presente, yo <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> identificado con DNI N°
                    <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> declaro estar conforme con la
                    solución de la EPS  <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> al problema presentado, descrito en la presente solicitud';
            // $html .= $cabeceraNoFacturacion;
            // if($nofacturacion){
            //     foreach($nofacturacion as $p){
            //         $html .= '<tr>'.
            //                     '<td style="width:8%; text-align:center; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;'.$p->cpid.'-'.$p->tipprobid.'-'.$p->scatprobid.'-'.$p->probid.'</td>'.
            //                     '<td style="width:20%;text-align:center; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;&nbsp;&nbsp;'.$p->tipo_problema.'</td>'.
            //                     '<td style="width:72%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000"> &nbsp;&nbsp;&nbsp;'.$p->descripcion.'</td>'.
            //                 '</tr>';
            //     }
            // }
            // $html .= $cabeceraOperacional;
            // if($operacional){
            //     foreach($operacional as $p){
            //         $html .= '<tr>'.
            //                     '<td style="width:8%; text-align:center; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;'.$p->cpid.'-'.$p->tipprobid.'-'.$p->scatprobid.'-'.$p->probid.'</td>'.
            //                     '<td style="width:20%;text-align:center; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;&nbsp;&nbsp;'.$p->tipo_problema.'</td>'.
            //                     '<td style="width:72%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000"> &nbsp;&nbsp;&nbsp;'.$p->descripcion.'</td>'.
            //                 '</tr>';
            //     }
            // }

            //$html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            //$pdf->lastPage();
            ob_end_clean();
            $pdf->Output( 'reclamo.pdf', 'D');
            redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_particular');
            exit;                    

        }


    }