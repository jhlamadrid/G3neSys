<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  


    class Solicitud_particular_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'solicitud_particular';
            
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']); 

            //$this->urlPDF = 'GeneSystest/assets/reclamos/reclamo_particular/';
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
                $this->data['reclamos'] = $this->Reclamo_no_facturacion_model->getReclamosParticularesList();
                $this->data['view'] = 'reclamo_no_facturacion/Solicitud_particular_panel';
                $this->data['breadcrumbs'] = array(array('Solicitud Particular', ''));
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
                    $this->form_validation->set_rules('suministro', 'Suministro del cliente', 'required');
                    //$this->form_validation->set_rules('apellidoPaterno', 'Apellido Paterno del cliente', 'required');
                    $this->form_validation->set_rules('apellidoM', 'Apellido Materno del cliente', 'required');
                    $this->form_validation->set_rules('nombre', 'Nombre del cliente', 'required');
                    $this->form_validation->set_rules('numero', 'Numero del documento', 'required');
                    //$this->form_validation->set_rules('calle', 'Calle donde vive el solicitante', 'required');
                    $this->form_validation->set_rules('presentacion', 'Descripción del problema ', 'required');
                    if($this->form_validation->run()){
                        $suministro = $this->input->post('suministro');
                        $modalidad = $this->input->post('modalidad');
                        $apellidoP = $this->input->post('apellido');
                        $apellidoM = $this->input->post('apellidoM');
                        $nombre = $this->input->post('nombre');
                        $tipoDoc1 = $this->input->post('tipoDoc1');
                        $numero = $this->input->post('numero');
                        $razonSocial = $this->input->post('razonSocial');
                        $telefono = $this->input->post('telefono');
                        $email = $this->input->post('email');
                        $problema = $this->input->post('problema');
                        $presentacion = $this->input->post('presentacion');
                        $textmodalidad = $this->Reclamo_no_facturacion_model->getNombreModalidad($modalidad);
                        $problemas = explode("-", $problema);
                        $usuario = null;
                        $existe_suministro = $this->Reclamo_no_facturacion_model->get_dire_sumin($suministro);
                        if(count($existe_suministro)>0){
                            if($tipoDoc1 == 6){
                                $this->session->set_flashdata('mensaje', array('error', 'Tiene que ser una persona natural la que ingrese el reclamo'));
                                redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_particular/nuevo');
                            } else {
                                $usuario = $this->Reclamo_no_facturacion_model->searchUsuario($tipoDoc1, $numero);
                                if(!$usuario) $this->Reclamo_no_facturacion_model->saveUsuario($apellidoM, $apellidoP, $nombre, 
                                                                                                $tipoDoc1, $numero, $telefono, $email);
                                else $this->Reclamo_no_facturacion_model->updateUsuario($apellidoM, $apellidoP, $nombre, 
                                                                                                $tipoDoc1, $numero, $telefono, $email);                                                                                            
                            }
                            $resp = $this->Reclamo_no_facturacion_model->almacenarReclamo(
                                                                                            $suministro, $presentacion, $modalidad, 
                                                                                            $numero, $telefono,
                                                                                            $email, $problemas, 
                                                                                            $tipoDoc1, $razonSocial,
                                                                                            $existe_suministro
                                                                                        );
    
                            $this->session->set_flashdata('mensaje', array('success', 'Se ha registrado la Solicitud Particular correctamente.'));
                            redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_particular');
                        }else{
                            $this->session->set_flashdata('mensaje', array('error', 'Debe de ingresar un codigo de suministro correcto'));
                            redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_particular/nuevo');
                        }
                        
                    } else{
                        $this->session->set_flashdata('mensaje', array('error', 'Debe completar todos los campos con (*)'));
                        redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_particular/nuevo');
                    }
                }
                $this->data['areas'] = $this->Reclamo_no_facturacion_model->getAreas();
                $this->data['provincias'] = $this->Reclamo_no_facturacion_model->getProvincias();
                $this->data['distritos'] = $this->Reclamo_no_facturacion_model->getDistritos($this->data['provincias'][0]['CPVCOD']);
                $this->data['medios'] = $this->Reclamo_no_facturacion_model->getMedios();
                $this->data['tipoDoc'] = $this->Reclamo_no_facturacion_model->getTipoDocumento();
                $reclamos = $this->Reclamo_no_facturacion_model->getReclamosParticulares();
               
                $this->data['reclamos']  = $reclamos;
                $this->data['view'] = 'reclamo_no_facturacion/Solicitud_particular';
                $this->data['breadcrumbs'] = array(array('Solicitudes Particulares', 'relativo_no_facturacion/solicitud_particular'), array('Nuevo', ''));
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
                    if($resp){
                        $json = array('res' => true, 'msg' => 'ok', 'distritos' => $resp);
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
            var_dump($persona);
            $problemas = [$reclamo['CPID'], $reclamo['TIPPROBID'], $reclamo['SCATPROBID'], $reclamo['PROBID']];
            $resp = [$EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID];
            $this->pdfSolicitud($reclamo['UUCOD'], $reclamo['MOACOD'], $persona['APEPAT'], 
                                                $persona['NOMBRE'], $reclamo['DOCIDENT_TIPDOC'], $reclamo['DOCIDENT_NRODOC'],
                                                $reclamo['RAZSOCIAL'],$persona['TIPO_DE_VIA']." ".$persona['NOMBRE_DE_VIA'], $reclamo['RECDPNMUN'],
                                                $persona['MANZANA'], $persona['LOTE'], $persona['TIPO_DE_ZONA'],
                                                $reclamo['CPVCODDPR'], $reclamo['CDSCODDPR'], $reclamo['RECDPTELF'],
                                                $reclamo['RECDESC'], $persona['APEMAT'], $reclamo['RECDPMAIL'],
                                                $problemas, $resp, $reclamo['RECFCH'], $reclamo['RECHRA'], $persona['NUMERO']);
        }

        private function pdfSolicitud($suministro, $textmodalidad, $apellidoP, $nombre, $tipoDoc1, $numero, $razonSocial, $calle, $numeroM, $manzana, $lote, $urbanizacion, $provincia, $distrito, $telefono, $presentacion, $apellidoM, $email, $problema, $resp, $fecha, $hora, $numeroCasa){
            $presentacion = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $presentacion);
            $nombreProvincia = $this->Reclamo_no_facturacion_model->getNombreProvincia($provincia);
            $nombreDistrito = $this->Reclamo_no_facturacion_model->getNombreDistrito($provincia, $distrito);
            $nombreModalidad = $this->Reclamo_no_facturacion_model->getNombreModalidad($textmodalidad);
            if($problema[0] == 2 && $problema[1] == 2){
                $cabecera = 'PROBLEMAS COMERCIALES NO RELATIVO A LA FACTURACION';
            } else {
                $cabecera = 'PROBLEMA OPERACIONALES';
            }

            $detalle = $this->Reclamo_no_facturacion_model->getDetalleReclamo($problema);
            $detalle1 = $this->Reclamo_no_facturacion_model->getDetalleReclamo1($problema);
            
            // $nofacturacion = array();
            // foreach($problema as $p){
            //     //$problemasNoFacturacion[$key]['detalle'] = $this->Reclamo_no_facturacion_model->getAllProblemasDetalle($p['TIPPROBID'], $p['CPID'], $p['SCATPROBID']);
            //     if($p->tipo == 'OPERACIONAL'){
            //         $cabeceraOperacional = '<tr>'.
            //                                     '<td colspan="3" style="width:100%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">PROBLEMAS OPERACIONALES</td>'.
            //                                 '</tr>';
            //         array_push($operacional, $p);
            //     } else if($p->tipo == 'NO FACTURACIÓN'){
            //         $cabeceraNoFacturacion = '<tr>'.
            //                                         '<td colspan="3" style="width:100%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">PROBLEMAS COMERCIALES NO RELATIVOS A LA FACTURACIÓN</td>'.
            //                                     '</tr>';
            //         array_push($nofacturacion, $p);
            //     }
            // }
            /*foreach($problemasOperacionales as $key => $p){
                $problemasOperacionales[$key]['detalle'] = $this->Reclamo_no_facturacion_model->getAllProblemasDetalle($p['TIPPROBID'], $p['CPID'], $p['SCATPROBID']);
            }*/
            $this->load->library('tcp'); 
            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->SetFont('dejavusans', '', 8, '', true);
            $pdf->AddPage();
            $html = '<img src="'.$this->config->item('ip').'img/logo3.png" style=" height:30px">'.
                    '<h3 style="text-align:center"> FORMATO 1 </h3>'.
                    '<h4 style="text-align:center">Formato de Solicitud de Atención  de Problemas Particulares</h4>'.
                    '<h4 style="text-align:center">Comerciales no relativos a la facturación y Problemas Operacionales</h4>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td style="width:32%"></td>'.
                            '<td style="width:22%"></td>'.
                            '<td style="width:10%"></td>'.
                            '<td colspan="2" style="width:20%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;">CODIGO DE SOLICITUD N°</td>'.
                            '<td style="width:15%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000">'.$resp[0].'-'.$resp[1].'-'.$resp[2].'-'.$resp[3].'-'.$resp[4].'-'.$resp[5].'-'.$resp[6].'</td>'.
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
                            '<td colspan ="4" style="width:40%;border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000">'.$nombreModalidad.'</td>'.
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
                            '<td colspan="2" style="width:66%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000">'.$calle.'</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000">'.$numeroCasa.'</td>'.
                            '<td style="width:11%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000">'.$manzana.'</td>'.
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
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">'.$telefono.'</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000; text-align:center">'.$email.'</td>'.
                            '<td colspan="3" ></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000; text-align:center">Telefono</td>'.
                            '<td style="width:33%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000; text-align:center; background:#eee">Correo electrónico (obligatorio web)</td>'.
                            '<td colspan="3" ></td>'.
                        '</tr>'.
                    '</table><br>'.
                    '<h5>INFORMACIÓN DE LA SOLICITUD</h5>'.
                    '<table width="100%">'.
                        '<tr>'.
                            '<td style="width:25%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000">Tipo de Problema</td>'.
                            '<td style="width:75%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000">'.$detalle1.'</td>'.
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
                        '<tr>'.
                            '<td style="width:20%; text-align:center; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000"> &nbsp;'.$problema[3].'</td>'.
                            '<td style="width:80%; border-top: 1px solid #000; border-left: 1px solid #000; border-bottom:1px solid #000;border-right: 1px solid #000"> &nbsp;&nbsp;&nbsp;'.$detalle1.'</td>'.
                        '</tr>'.
                    '</table>'.
                    '<br><br><br><br><br>'.
                    '<b>CONFORMIDAD DEL SOLICITANTE</b><br>'.
                    'Mediante el presente, yo <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u> identificado con DNI N° <u>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> declaro estar conforme con la
                    solución de la EPS  <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> al problema presentado, descrito en la presente solicitud.'
                        ;
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
            $pdf->Output( $resp[0].'-'.$resp[1].'-'.$resp[2].'-'.$resp[3].'-'.$resp[4].'-'.$resp[5].'-'.$resp[6].'.pdf', 'D');
            redirect($this->config->item('ip').'relativo_no_facturacion/solicitud_particular');
            exit;                    

        }

    }