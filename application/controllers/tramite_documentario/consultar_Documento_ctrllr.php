<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class consultar_Documento_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'CONSULTAR_DOCUMENTO';
            
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
                $this->data['view'] = 'tramite_Documentario/consultar_Documento_view';
                $this->data['breadcrumbs'] = array(array('Consultar Documentos', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function Listar_tipos_documentos() {

            //$dni = $this->session->userdata('cDNI');
            //$cargo = $this->session->userdata('c_cargo');
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getTipoxTipoDoc_general();
            
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function Obtener_documentos() {
            $idTipoDoc = $this->input->post('idTipoDoc');
            $numero = $this->input->post('numero');
            $anio = $this->input->post('anio');
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->Obtener_documentos($idTipoDoc, $numero, $anio);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function Ver_movimientos_por_documento() {
            $idDocumento = $this->input->post('idDocumento');
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->Ver_movimientos_por_documento($idDocumento);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        private function genero_cabecera($pdf, $dato_Documento){
            $pdf->Image( base_url()."img/logo4.jpg", 4, 4, 45, 11, '', '', '', false, 300, '', false, false, 0);
            $pdf->SetFont('helveticaB', '',12);
            $pdf->writeHTMLCell(170, 5, 107, 8 ,"<p>REPORTE DE HISTORIA DE DOCUMENTO</p>", 0, 1, 0, true, 'L',  true); 
            $pdf->SetFont('helveticaB', '',9.5);
            $pdf->writeHTMLCell(170, 5, 5, 18 ,"<p>TIPO : ".$dato_Documento->NOMBREDOCUMENTO." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 75, 18 ,"<p>NUM. DE DOCUMENTO :  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helveticaB', '',15);
            $pdf->writeHTMLCell(170, 5, 120, 17 ,"<p>".$dato_Documento->NUMERODOCUMENTO." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helveticaB', '',9.5);
            $pdf->writeHTMLCell(170, 5, 160, 18 ,"<p>AREA GENERA : ".$dato_Documento->SIGLAAREAGEN." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 230, 18 ,"<p>FECHA DE CREACIÓN : ".$dato_Documento->FECHACREACION." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helvetica', '',7);
            $pdf->writeHTMLCell(170, 5, 235, 3 ,"<p>FECHA GENERADO : ".date("d/m/Y  H:i:s")." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helveticaB', '',7);
            return $pdf;
        }

        public function generar_reporte_persona(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('imprimir_reporte'));
                $this->load->model('Tramite_documentario/Documento_model');
                $data = $this->Documento_model->Ver_movimientos_por_documento($array[0]);
                $idper = $_SESSION['user_id'];
                if(count($data)>0){
                    $this->load->library('Reporte_Consulta_Persona');
                    $pdf = new Reporte_Consulta_Persona(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
                    $pdf->SetAutoPageBreak(TRUE, 0);

                    // set image scale factor
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                    // add a page
                    $pdf->AddPage('L', 'A4');

                    $pdf = $this->genero_cabecera($pdf, $array[1]);
                    $cab_tbl = '
                        <table cellspacing="0" cellpadding="1" border="0">
                            <tr style ="font-size: 10px; font-weight: bold; color:#337ab7;">
                                <td height="20" width="292" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >DOCUMENTO</td>
                                <td height="20" width="56" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >FOLIOS</td>
                                <td height="20" width="290" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >EMISOR</td>
                                <td height="20" width="290" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >RECEPTOR</td>
                                <td height="20" width="86" align="center" style="border-bottom: 1px solid #000;"  >ESTADO</td>
                            </tr>
                        ';
                    $i = 0;
                    $tbl='';
                    $contador = 0;
                    //var_dump($data);
                    //exit();
                    while(count($data)>$i){
                        $autor = '';
                        $estado = '';
                        if($data[$i]->SIGLAS_PERSONAL !='vacio'){
                            $autor = $autor . '/' . $data[$i]->SIGLAS_PERSONAL;
                        }
                        if($data[$i]->ESTADOENVIO == 2){
                            $estado ='Recepcionado';
                        }else{
                            $estado ='No Recepcionado';
                        }
                        
                        if($contador ==40){
                            $tabla = $cab_tbl.$tbl."</table>";
                            $pdf->SetXY(5 ,25);
                            $pdf->writeHTML($tabla, true, false, false, false, '');
                            $pdf->SetFont('helvetica', '', 8);
                            $pdf->writeHTMLCell(250,  5, 250, 198,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." DE ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                            $pdf->AddPage('L', 'A4');
                            $pdf = $this->genero_cabecera($pdf, $array[1]);
                            $contador=0;
                            $tbl ='';
                        }
                        $tbl = $tbl .'<tr style ="font-size: 9px;">
                                    <td  width="292" align="left" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >'.$data[$i]->NOMBREDOCUMENTO . ' Nro. <span style ="color:#E91E63">' . $data[$i]->NUMERODOCUMENTO . ' - ' . $data[$i]->ANIO .' </span> - SEDALIB S.A. - ' . $data[$i]->AREA_GENERA. $autor . '</td>
                                    <td  width="56" align="center" style="border-bottom: 1px solid #000; font-size:14px; border-right: 1px solid #000;">'.$data[$i]->FOLIOS.'</td>
                                    <td  width="290" align="left" style="border-bottom: 1px solid #000; font-size:8px; border-right: 1px solid #000;">'.'<span> ' .  (($data[$i]->INDEXTER == '1') ? 'EXTERNO': (($data[$i]->SIGLAS_PERSONAL =='vacio') ? '': ($data[$i]->PERSONA_ENVIA . "<br>") )  )  . '</span>' . " <span style='font-weight:bold;'> " . (($data[$i]->AREA_CREA == null) ? '' : $data[$i]->AREA_CREA) . '</span>' .
                                    "<br> <span style='font-weight:bold; color:#3c8dbc'> Enviado: </span> " . $data[$i]->FECHACREACION . ' '.$data[$i]->HORA_CREO.'</td>
                                    <td  width="290" align="left" style="border-bottom: 1px solid #000; font-size:8px;   border-right: 1px solid #000;">'.'<span class="bold"> ' . (($data[$i]->INDEXTER == '1') ? 'EXTERNO' : (( $data[$i]->PERSONA_RECIBE =='vacio')? '':  $data[$i]->PERSONA_RECIBE. "<br>" ))  . '</span>' . " <span style='font-weight:bold;'>  " . (($data[$i]->AREA_ENVIA == null) ? '' : $data[$i]->AREA_ENVIA) . '</span>'.
                                    "<br> <span style='font-weight:bold; color:#3c8dbc'> Recibido: </span> " . ($data[$i]->FECHARECEPCION == null ? "Aún no lo recibe" : $data[$i]->FECHARECEPCION . ' ' . $data[$i]->HORA_RECEPCIONA ).'</td>
                                    <td  width="86" align="center" style="border-bottom: 1px solid #000; "> '.TCPDF_FONTS::unichr(182).' <br>'.$estado.' </td>
                                </tr>';
                        
                        $contador++;
                        $i++;
                    }
                    if($contador <=40){
                        $tabla = $cab_tbl.$tbl."</table>";
                        $pdf->SetXY(5 ,25);
                        $pdf->writeHTML($tabla, true, false, true, false, '');
                        $pdf->SetFont('helvetica', '', 8);
                        $pdf->writeHTMLCell(250,  5, 250, 198,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." DE ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                    }
                    
                    $pdf->Output('Reporte_Consulta_Documento.pdf', 'I');
                }
            }
        }

        public function Consultar_Persona(){
            $idTipoDoc = $this->input->post('idTipoDoc');
            $trabajador = $this->input->post('nPerId');
            $anio = $this->input->post('anio');
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->Obtener_documentos_persona($idTipoDoc, $trabajador, $anio);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

    }
?>