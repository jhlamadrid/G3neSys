<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class reporte_Documento_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'REPORTE_DOCUMENTO';
            
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']); 
        
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
                $this->data['view'] = 'tramite_Documentario/reporte_Documento_view';
                $this->data['breadcrumbs'] = array(array('Reporte Documentos', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function Listar_tipos_documento() {

            //$dni = $this->session->userdata('cDNI');
            //$cargo = $this->session->userdata('c_cargo');
            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->getTipoxTipoDoc();
            
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function Listar_anios_documento() {
            $id = $this->input->post('idTipoDoc');
            $data[0]['anio'] = date("Y");
            //$this->load->model('sistram/Documento_model');
            //$data = $this->Documento_model->Listar_anios_documento($id);

            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function Obtener_documentos_creados() {
            $idper = $_SESSION['user_id'];
            $filtro_doc = $this->Parse_filtro_documentos();
            $filtro_depen = $this->Parse_filtro_dependencias();
            $filtro_fecha = $this->Parse_filtro_fechas();
            //var_dump($idper, $filtro_doc, $filtro_depen, $filtro_fecha );
            $this->load->model('Tramite_documentario/Documento_model');
            $documentos["graph"] = $this->Documento_model->Obtener_documentos_creados_graph($idper, $filtro_doc, $filtro_depen, $filtro_fecha);
            $documentos["table"] = $this->Documento_model->Obtener_documentos_creados($idper, $filtro_doc, $filtro_depen, $filtro_fecha);
    
            header('Content-Type: application/json');
            echo json_encode($documentos);
        }


        public function Obtener_documentos_recibidos(){
            $idper = $_SESSION['user_id'];
            $filtro_doc = $this->Parse_filtro_documentos();
            $filtro_depen = $this->Parse_filtro_dependencias();
            $filtro_fecha = $this->Parse_filtro_fechas();

            $this->load->model('Tramite_documentario/Documento_model');
            $documentos["graph"] = $this->Documento_model->Obtener_documentos_recibidos_graph($idper, $filtro_doc, $filtro_depen, $filtro_fecha);
            $documentos["table"] = $this->Documento_model->Obtener_documentos_recibidos($idper, $filtro_doc, $filtro_depen, $filtro_fecha);
    
            header('Content-Type: application/json');
            echo json_encode($documentos);
        }

        public function Obtener_documentos_por_recibir(){
            $idper = $_SESSION['user_id'];
            $filtro_doc = $this->Parse_filtro_documentos();
            $filtro_depen = $this->Parse_filtro_dependencias();
            $filtro_fecha = $this->Parse_filtro_fechas();

            $this->load->model('Tramite_documentario/Documento_model');
            $documentos["graph"] = $this->Documento_model->Obtener_documentos_por_recibidos_graph($idper, $filtro_doc, $filtro_depen, $filtro_fecha);
            $documentos["table"] = $this->Documento_model->Obtener_documentos_por_recibidos($idper, $filtro_doc, $filtro_depen, $filtro_fecha);
    
            header('Content-Type: application/json');
            echo json_encode($documentos);
        }

        private function genero_cabecera($pdf, $tipo, $fecha){
            $pdf->Image( base_url()."img/logo4.jpg", 4, 4, 45, 11, '', '', '', false, 300, '', false, false, 0);
            $pdf->SetFont('helveticaB', '',12);
            $pdf->writeHTMLCell(170, 5, 107, 8 ,"<p>REPORTES DE TRAMITE DOCUMENTARIO</p>", 0, 1, 0, true, 'L',  true); 
            $pdf->SetFont('helveticaB', '',9.5);
            $pdf->writeHTMLCell(170, 5, 5, 18 ,"<p>TIPO : ".$tipo." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 120, 18 ,"<p>FECHA INICIO : ".$fecha['inicio']." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 220, 18 ,"<p>FECHA FIN : ".$fecha['fin']." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helvetica', '',7);
            $pdf->writeHTMLCell(170, 5, 235, 3 ,"<p>FECHA GENERADO : ".date("d/m/Y  H:i:s")." </p>", 0, 1, 0, true, 'L',  true);

            return $pdf;
        }


        public function imprimir_pdf(){
            //var_dump("imprimiendo pdf");
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('imprimir_reporte'));
                $this->load->model('Tramite_documentario/Documento_model');
                $idper = $_SESSION['user_id'];
                $fecha = $array[0]->fecha;
                //var_dump($fecha);
                //exit();
                if (empty($fecha)) {
                    $fecha =  false;
                }else{
                    $fecha['inicio'] = $fecha[0]->inicio;
                    $fecha['fin'] = $fecha[0]->fin;
                }
                $documentos = $array[0]->documentos;
                if (empty($documentos)) {
                    $documentos =  false;
                }else{
                    $documentos = implode(",", $documentos);
                }
                $dependencias = $array[0]->dependencias;
                if (empty($dependencias)) {
                    $dependencias = false;
                }else{
                    $dependencias = implode(",", $dependencias);
                }
                $tipo = '';
                $bad_Atend = 0;
                if($array[1]=='1'){
                    $resultados = $this->Documento_model->Obtener_documentos_creados($idper, $documentos, $dependencias, $fecha);
                    $tipo = 'DOCUMENTOS CREADOS';
                    $bad_Atend = 1;
                }
                if($array[1]=='2'){
                    $resultados = $this->Documento_model->Obtener_documentos_recibidos($idper, $documentos, $dependencias, $fecha);
                    $tipo = 'DOCUMENTOS RECIBIDOS';
                }
                if($array[1]=='3'){
                    $resultados = $this->Documento_model->Obtener_documentos_por_recibidos($idper, $documentos, $dependencias, $fecha);
                    $tipo = 'DOCUMENTOS POR RECIBIR';
                }

                if(count($resultados)>0){
                    //var_dump($resultados);
                    
                    $this->load->library('Reporte_tramite_doc');
                    $pdf = new Reporte_tramite_doc(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
                    
                    $pdf = $this->genero_cabecera($pdf, $tipo, $fecha);
                    
                    $cab_tbl = '
                        <table cellspacing="0" cellpadding="1" border="0">
                        
                            <tr style ="font-size: 12px; font-weight: bold; color:#337ab7;">
                                <td height="20" width="32" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >ITEM</td>
                                <td height="20" width="246" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >DOCUMENTO</td>
                                <td height="20" width="260" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >ASUNTO</td>
                                <td height="20" width="310" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >OBSERVACIONES</td>
                                <td height="20" width="70" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >ESTADO</td>
                                <td height="20" width="96" align="center" style="border-bottom: 1px solid #000;"  >F. EMISIÓN </td>
                            </tr>
                        ';
                    $i = 0;
                    $tbl='';
                    $contador = 0;
                    $cadena ='';
                    while(count($resultados)>$i){
                        $cadena="";
                        if($contador ==40){
                            $tabla = $cab_tbl.$tbl."</table>";
                            $pdf->SetXY(5 ,24);
                            $pdf->writeHTML($tabla, true, false, false, false, '');
                            $pdf->SetFont('helvetica', '', 8);
                            $pdf->writeHTMLCell(250,  5, 250, 198,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." DE ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                            $pdf->AddPage('L', 'A4');
                            $pdf = $this->genero_cabecera($pdf, $tipo, $fecha);
                            $contador=0;
                            $tbl ='';
                        }

                        if($bad_Atend ==1){
                            if($resultados[$i]->CANTIDAMOVIMIENTO == $resultados[$i]->CANTIDARECIBIDOS){
                                $cadena =  "RECEPCIONADO";
                            }else{
                                if($resultados[$i]->CANTIDARECIBIDOS == 0){
                                    $cadena = "NO RECEPCIONADO";
                                }else{
                                    $cadena = "EN PROCESO";
                                }
                            }
                        }else{
                            if($resultados[$i]->ESTADOMOVIMIENTO=='1'){
                                $cadena = "ATENDIDO";
                            }else{
                                if($resultados[$i]->ESTADOMOVIMIENTO=='2'){
                                    $cadena = "ARCHIVADO";
                                }else{
                                    $cadena = "PENDIENTE";
                                }
                                
                            }
                        }

                        $tbl = $tbl .'<tr style ="font-size: 9.5px;">
                                    <td  width="32" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >'.($i+1).'</td>
                                    <td  width="246" align="left" style="border-bottom: 1px solid #000; font-size:7.5px; border-right: 1px solid #000;">'.$resultados[$i]->NOMBRE . ' Nro. <span style ="color:#E91E63">' . $resultados[$i]->NUMERO . ' - ' . $resultados[$i]->ANIO .' </span> - SEDALIB S.A. - ' . $resultados[$i]->SIGLA_AREA . '</td>
                                    <td  width="260" align="left" style="border-bottom: 1px solid #000; font-size:8px; border-right: 1px solid #000;">'. substr(trim($resultados[$i]->ASUNTO), 0, 45).'</td>
                                    <td  width="310" align="left" style="border-bottom: 1px solid #000; font-size:8px;   border-right: 1px solid #000;">'.substr(trim($resultados[$i]->OBSERVACIONES), 0, 52).'</td>
                                    <td  width="70" align="center" style="border-bottom: 1px solid #000; font-size:6.5px;   border-right: 1px solid #000;">'.$cadena.'</td>
                                    <td  width="96" align="center" style="border-bottom: 1px solid #000; ">'.$resultados[$i]->TIEMPO.'</td>
                                </tr>';
                        
                        $contador++;
                        $i++;
                    }
                    if($contador <=40){
                        $tabla = $cab_tbl.$tbl."</table>";
                        $pdf->SetXY(5 ,24);
                        $pdf->writeHTML($tabla, true, false, false, false, '');
                        $pdf->SetFont('helvetica', '', 8);
                        $pdf->writeHTMLCell(250,  5, 250, 198,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." DE ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                    }
                    
                    $pdf->Output('Reporte_tramite_documentario.pdf', 'D');
                    
                    //$pdf->Output('Reporte_tramite_documentario.pdf', 'I');
                }
                 
            }
        }


        private function Parse_filtro_fechas() {
            $dependencias = $this->input->post("fecha");
            if (empty($dependencias)) {
                return false;
            }
            return $dependencias[0];
        }


        public function Listar_dependencias() {

            $this->load->model('Tramite_documentario/Documento_model');
            $data = $this->Documento_model->Listar_dependencias();
            header('Content-Type: application/json');
            echo json_encode($data);
        }


        private function Parse_filtro_documentos() {
            $documentos = $this->input->post("documentos");
            if (empty($documentos)) {
                return false;
            }
            return implode(",", $documentos);
        }


        private function Parse_filtro_dependencias() {
            $dependencias = $this->input->post("dependencias");
            if (empty($dependencias)) {
                return false;
            }
            return implode(",", $dependencias);
        }


    }
?>