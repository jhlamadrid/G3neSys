<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    

    class Genera_solicitud_requerimiento_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'SOL_REQUERIMIENTO';
            
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']); 
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
                //$this->data['reclamos'] = $this->Reclamo_no_facturacion_model->getReclamosList();
                $this->data['view'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_view';
                $this->data['breadcrumbs'] = array(array('Generar Solicitud de Requerimientos', ''));
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
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $hoy = date("d-m-Y"); 
                $min = strtotime ( '-30 day' , strtotime ( $hoy ) );
                $min= date ( 'd-m-Y' , $min );
                $tipo = '0';
                $estado = '0';
                $tipo_problema = '0';
                $lista_reclamos = $this->Reclamo_no_facturacion_model->getReclamosList2($min, $hoy, $tipo, $estado, $tipo_problema);
                $json = array('result' => true, 'fecha' => $hoy, 'min_fecha' =>  $min, 'lista_reclamos'=> $lista_reclamos);
                echo json_encode($json);
                return;
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        private function genero_cabecera($pdf, $filtros, $cantidad, $style){
            if($filtros[2]=='0'){
                $tipo = 'TODOS';
            }else{
                if($filtros[2]=='1'){
                    $tipo = 'PARTICULAR';
                }else{
                    $tipo = 'GENERAL';
                }
            }
            if($filtros[3]=='0'){
                $estados = 'TODOS';
            }else{
                if($filtros[3]=='1'){
                    $estados = 'ATENDIDOS';
                }else{
                    $estados = 'PENDIENTE';
                }
            }

            if($filtros[4]=='0'){
                $problema = 'TODOS';
            }else{
                if($filtros[4]=='1'){
                    $problema = 'OPERACIONAL';
                }else{
                    $problema = 'COMERCIAL';
                }
            }
            $pdf->Image( base_url()."img/logo4.jpg", 4, 4, 45, 11, '', '', '', false, 300, '', false, false, 0);
            $pdf->SetFont('helveticaB', '',12);
            $pdf->writeHTMLCell(170, 5, 100, 8 ,"<p>REPORTE DETALLADO DE SOLICITUDES INGRESADAS</p>", 0, 1, 0, true, 'L',  true); 
            $pdf->SetFont('helvetica', '',7.2);
            $pdf->writeHTMLCell(170, 5, 5, 18 ,"<p>TIPO DE SOLICITUD : <b> ".$tipo." </b>  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 75, 18 ,"<p>TIPO DE PROBLEMA : <b> ".$problema." </b>  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 140, 18 ,"<p>FECHA INICIO :  <b>".$filtros[0]." </b>  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 177, 18 ,"<p >FECHA FIN : <b> ".$filtros[1]." </b>  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 210, 18 ,"<p>ESTADOS : <b> ".$estados." </b>  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helvetica', '',7);
            $pdf->writeHTMLCell(170, 5, 235, 3 ,"<p>FECHA GENERADO : ".date("d/m/Y  H:i:s")." </p>", 0, 1, 0, true, 'L',  true);
            $pdf->Line(248, 8 , 248, 21 , $style);
            $pdf->Line(248, 21 ,275, 21 , $style);
            $pdf->Line(275, 21 ,275, 8 , $style);
            $pdf->Line(275, 8 , 248, 8, $style);
            $pdf->SetFont('helvetica', '',6);
            $pdf->writeHTMLCell(70, 5, 248, 9 ,"<p>CANTIDAD: </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helveticaB', '',21);
            $pdf->writeHTMLCell(70, 5, 252, 11 ,"<p>".$cantidad." </p>", 0, 1, 0, true, 'L',  true);
            return $pdf;
        }

        private function genero_cabecera_general($pdf, $filtros, $cantidad, $style){
            if($filtros[2]=='0'){
                $tipo = 'TODOS';
            }else{
                if($filtros[2]=='1'){
                    $tipo = 'PARTICULAR';
                }else{
                    $tipo = 'GENERAL';
                }
            }

            if($filtros[3]=='0'){
                $estados = 'TODOS';
            }else{
                if($filtros[3]=='1'){
                    $estados = 'ATENDIDOS';
                }else{
                    $estados = 'PENDIENTE';
                }
            }

            if($filtros[4]=='0'){
                $problema = 'TODOS';
            }else{
                if($filtros[4]=='1'){
                    $problema = 'OPERACIONAL';
                }else{
                    $problema = 'COMERCIAL';
                }
            }
            $pdf->Image( base_url()."img/logo4.jpg", 4, 4, 45, 11, '', '', '', false, 300, '', false, false, 0);
            $pdf->SetFont('helveticaB', '',12);
            $pdf->writeHTMLCell(170, 5, 63, 8 ,"<p>REPORTES GENERAL DE SOLICITUDES INGRESADAS</p>", 0, 1, 0, true, 'L',  true); 
            $pdf->SetFont('helvetica', '',9);
            $pdf->writeHTMLCell(170, 5, 15, 18 ,"<p>FECHA INICIO :  <b>".$filtros[0]." </b>  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 100, 18 ,"<p >FECHA FIN : <b> ".$filtros[1]." </b>  </p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helvetica', '',7);
            $pdf->writeHTMLCell(170, 5, 145, 3 ,"<p>FECHA GENERADO : ".date("d/m/Y  H:i:s")." </p>", 0, 1, 0, true, 'L',  true);
            return $pdf;
        }

        public function imprimir_pdf_general(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('imprimir_reporte_general'));
                $lista_reclamos = $this->Reclamo_no_facturacion_model->getReclamosList2( $array[0], $array[1], $array[2], $array[3], $array[4] );
                $this->load->library('Reporte_sol_general');
                $pdf = new Reporte_sol_general(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
                $pdf->AddPage('P', 'A4');
                $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                $pdf = $this->genero_cabecera_general($pdf, $array, count($lista_reclamos), $style);
                $pdf->SetFont('helveticaB', '',11);
                $pdf->writeHTMLCell(170, 5, 5, 25 ,"<p>TIPO DE SOLICITUDES:</p>", 0, 1, 0, true, 'L',  true);
                $ancho = 10;
                $altura  = 32; 
                if($array[2]=='0'){
                    $cantidad =2;
                }else{
                    $cantidad =1;
                }
                if($array[4]=='0'){
                    $cant_prob =2;
                }else{
                    $cant_prob =1;
                }
                for($i=0; $i<$cantidad; $i++){
                    $pdf->SetFont('helvetica', '',10);
                    $tipo_sol =0;
                    if($cantidad== 2){
                        if($i == 0){
                            $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>A)</b> PARTICULAR:</p>", 0, 1, 0, true, 'L',  true);
                            $tipo_sol =1;
                        }else{
                            $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>B)</b> GENERAL:</p>", 0, 1, 0, true, 'L',  true);
                            $tipo_sol =2;
                        }
                    }else{
                        if($array[2]=='1'){
                            $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>A)</b> PARTICULAR:</p>", 0, 1, 0, true, 'L',  true);
                            $tipo_sol =1;
                        }else{
                            if($array[2]=='2'){
                                $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>A)</b> GENERAL:</p>", 0, 1, 0, true, 'L',  true);
                                $tipo_sol =2;
                            }
                            
                        }
                    }
                    // bucle para los tipos de problema
                    
                    for($j=0; $j<$cant_prob; $j++){
                        if($j==0){
                            $ancho = $ancho + 10;
                        }
                        $altura  =  $altura +7; 
                        $tipo_pro =0;
                        $pdf->SetFont('helvetica', '',9.5);
                        if($cant_prob== 2){
                            if($j == 0){
                                $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>I)</b> OPERACIONAL:</p>", 0, 1, 0, true, 'L',  true);
                                $pdf->SetDrawColor(0,128,255);
                                $pdf->SetFillColor(255,255,128);
                                $pdf->SetXY(($ancho+101), ($altura-1));
                                $pdf->Cell(20, 5, 'ATENDIDO', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+121), ($altura-1));
                                $pdf->Cell(20, 5, 'PENDIENTE', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+141), ($altura-1));
                                $pdf->Cell(20, 5, 'ELIMINADO', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+161), ($altura-1));
                                $pdf->SetFillColor(255, 105, 97);
                                $pdf->Cell(20, 5, 'TOTAL', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $tipo_pro =1;
                            }else{
                                $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>II)</b> COMERCIAL:</p>", 0, 1, 0, true, 'L',  true);
                                $pdf->SetDrawColor(0,128,255);
                                $pdf->SetFillColor(255,255,128);
                                $pdf->SetXY(($ancho+101), ($altura-1));
                                $pdf->Cell(20, 5, 'ATENDIDO', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+121), ($altura-1));
                                $pdf->Cell(20, 5, 'PENDIENTE', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+141), ($altura-1));
                                $pdf->Cell(20, 5, 'ELIMINADO', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+161), ($altura-1));
                                $pdf->SetFillColor(255, 105, 97);
                                $pdf->Cell(20, 5, 'TOTAL', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $tipo_pro =2;
                            }
                        }else{
                            if($array[4]=='1'){
                                $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>I)</b> OPERACIONAL:</p>", 0, 1, 0, true, 'L',  true);
                                $pdf->SetDrawColor(0,128,255);
                                $pdf->SetFillColor(255,255,128);
                                $pdf->SetXY(($ancho+101), ($altura-1));
                                $pdf->Cell(20, 5, 'ATENDIDO', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+121), ($altura-1));
                                $pdf->Cell(20, 5, 'PENDIENTE', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+141), ($altura-1));
                                $pdf->Cell(20, 5, 'ELIMINADO', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $pdf->SetXY(($ancho+161), ($altura-1));
                                $pdf->SetFillColor(255, 105, 97);
                                $pdf->Cell(20, 5, 'TOTAL', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                $tipo_pro =1;
                            }else{
                                if($array[4]=='2'){
                                    $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>I)</b> COMERCIAL:</p>", 0, 1, 0, true, 'L',  true);
                                    $pdf->SetDrawColor(0,128,255);
                                    $pdf->SetFillColor(255,255,128);
                                    $pdf->SetXY(($ancho+101), ($altura-1));
                                    $pdf->Cell(20, 5, 'ATENDIDO', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                    $pdf->SetXY(($ancho+121), ($altura-1));
                                    $pdf->Cell(20, 5, 'PENDIENTE', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                    $pdf->SetXY(($ancho+141), ($altura-1));
                                    $pdf->Cell(20, 5, 'ELIMINADO', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                    $pdf->SetXY(($ancho+161), ($altura-1));
                                    $pdf->SetFillColor(255, 105, 97);
                                    $pdf->Cell(20, 5, 'TOTAL', 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                    $tipo_pro =2;
                                }
                            }
                        }
                        //PARA SACAR LA ESPECIFICACIÓN DE LOS PROBLEMAS DE ACUERDO AL TIPO DE SOLICITUD Y TIPO DE PROBLEMA
                        $Esp_problema = $this->Reclamo_no_facturacion_model->get_Espe_problema( $tipo_sol, $tipo_pro);
                        if(count($Esp_problema)>0){
                            $pdf->SetFont('helvetica', '',9);
                            $suma_atendido = 0;
                            $suma_pendiente = 0;
                            $suma_eliminado = 0;
                            $suma_total = 0;
                            for($k=0; $k<count($Esp_problema); $k++){
                                if($k==0){
                                    $ancho = $ancho + 10;  
                                }
                                if($altura  == 274){
                                    $pdf->SetFont('helvetica', '', 8);
                                    $pdf->writeHTMLCell(250,  5, 175, 283,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." / ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                                    $pdf->AddPage('P', 'A4');
                                    $pdf = $this->genero_cabecera_general($pdf, $array, count($lista_reclamos), $style);
                                    $pdf->SetFont('helvetica', '',9);
                                    $altura  = 26; 
                                }
                                //CONSULTA PARA LOS DOCUMENTOS 
                                $datos_numeros = $this->Reclamo_no_facturacion_model->get_Datos_numero_tipo($array[0], $array[1],$tipo_sol,$tipo_pro, $Esp_problema[$k]);
                                $altura  =  $altura +6;
                                $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p><b>".($k+1).")</b> ".$Esp_problema[$k]['PROBABR'].":</p>", 0, 1, 0, true, 'L',  true);
                                $pdf->SetDrawColor(0,128,255);
                                $pdf->SetFillColor(255,255,255);
                                $pdf->SetXY(($ancho+91), ($altura-1));
                                $sumador = 0;
                                if(is_null($datos_numeros[0]->PENDIENTE) ){
                                    $pdf->Cell(20, 5, '0', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                }else{
                                    $pdf->Cell(20, 5, $datos_numeros[0]->PENDIENTE, 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                    $sumador = $sumador + (int)($datos_numeros[0]->PENDIENTE);
                                    $suma_pendiente = $suma_pendiente + (int)($datos_numeros[0]->PENDIENTE);
                                }
                                $pdf->SetXY(($ancho+111), ($altura-1));
                                if(is_null($datos_numeros[0]->ATENDIDO) ){
                                    $pdf->Cell(20, 5, '0', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                }else{
                                    $pdf->Cell(20, 5, $datos_numeros[0]->ATENDIDO, 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                    $sumador = $sumador + (int)($datos_numeros[0]->ATENDIDO);
                                    $suma_atendido = $suma_atendido+ (int)($datos_numeros[0]->ATENDIDO);
                                }
                                
                                $pdf->SetXY(($ancho+131), ($altura-1));
                                if(is_null($datos_numeros[0]->ELIMINADO) ){
                                    $pdf->Cell(20, 5, '0', 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                }else{
                                    $pdf->Cell(20, 5, $datos_numeros[0]->ELIMINADO, 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                    $sumador = $sumador + (int)($datos_numeros[0]->ELIMINADO);
                                    $suma_eliminado = $suma_eliminado + (int)($datos_numeros[0]->ELIMINADO); 
                                }
                                $suma_total = $suma_total + $sumador;
                                $pdf->SetXY(($ancho+151), ($altura-1));   
                                $pdf->Cell(20, 5, $sumador, 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                                
                            }
                            /* PARA PONER EL TOTAL DE LA BASE */
                            $altura  =  $altura +6;
                            $pdf->writeHTMLCell(170, 5, $ancho, $altura ,"<p> *************** SUMA TOTAL ****************</p>", 0, 1, 0, true, 'L',  true);
                            $pdf->SetDrawColor(0,128,255);
                            $pdf->SetFillColor(205,205,205);
                            $pdf->SetXY(($ancho+91), ($altura-1));
                            $pdf->Cell(20, 5, $suma_pendiente, 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                            $pdf->SetXY(($ancho+111), ($altura-1));
                            $pdf->Cell(20, 5, $suma_atendido, 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                            $pdf->SetXY(($ancho+131), ($altura-1));
                            $pdf->Cell(20, 5, $suma_eliminado, 'LB', 1, 'C', 1, '', 0, false, 'T', 'C');
                            $pdf->SetXY(($ancho+151), ($altura-1));
                            $pdf->Cell(20, 5, $suma_total, 'LRB', 1, 'C', 1, '', 0, false, 'T', 'C');
                            $ancho = $ancho - 10; 
                        }
                    }

                    $ancho = $ancho - 10;
                    $altura  =  $altura +7; 
                }

                $pdf->SetFont('helvetica', '', 8);
                $pdf->writeHTMLCell(250,  5, 175, 283,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." / ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                $pdf->Output(date("d/m/Y_H:i:s").'_Reporte_solicitud_General.pdf', 'I');
            }
        }

        public function imprimir_pdf(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('imprimir_reporte'));
                $lista_reclamos = $this->Reclamo_no_facturacion_model->getReclamosList2( $array[0], $array[1], $array[2], $array[3], $array[4] );
                $this->load->library('Reporte_sol_req');
                $pdf = new Reporte_sol_req(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
                $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                $pdf = $this->genero_cabecera($pdf, $array, count($lista_reclamos), $style);
                $cab_tbl = '
                        <table cellspacing="0" cellpadding="1" border="0">
                        
                            <tr style ="font-size: 12px; font-weight: bold; color:#000;">
                                <td height="20" width="32" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >ITEM</td>
                                <td height="20" width="140" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >CODIGO</td>
                                <td height="20" width="95" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >DNI</td>
                                <td height="20" width="100" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >FECHA/HORA</td>
                                <td height="20" width="410" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >DESCRIPCIÓN</td>
                                <td height="20" width="80" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >TIP. SOL.</td>
                                <td height="20" width="80" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >TIP. PRO.</td>
                                <td height="20" width="80" align="center" style="border-bottom: 1px solid #000;"  >ESTADO</td>
                            </tr>
                        ';
                $i = 0;
                $tbl='';
                $contador = 0;
                while(count($lista_reclamos)>$i){
                        if($contador ==36){
                            $tabla = $cab_tbl.$tbl."</table>";
                            $pdf->SetXY(5 ,24);
                            $pdf->writeHTML($tabla, true, false, false, false, '');
                            $pdf->SetFont('helvetica', '', 8);
                            $pdf->writeHTMLCell(250,  5, 250, 198,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." / ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                            $pdf->AddPage('L', 'A4');
                            $pdf = $this->genero_cabecera($pdf, $array, count($lista_reclamos), $style);
                            $contador=0;
                            $tbl ='';
                        }
                        $descri = mb_convert_case($lista_reclamos[$i]->RECDESC, MB_CASE_LOWER, "UTF-8");
                        $tbl = $tbl .'<tr style ="font-size: 8px; font-weight: normal;">
                                        <td  width="32" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  > '.($i+1).'</td>
                                        <td  width="140" align="left" style="font-size: 11px;  border-bottom: 1px solid #000; border-right: 1px solid #000;"  > '.$lista_reclamos[$i]->EMPCOD."-".$lista_reclamos[$i]->OFICOD."-".$lista_reclamos[$i]->ARECOD."-".$lista_reclamos[$i]->CTDCOD."-".$lista_reclamos[$i]->DOCCOD."-".$lista_reclamos[$i]->SERNRO."-".$lista_reclamos[$i]->RECID.'</td>
                                        <td  width="95" align="left" style="font-size: 10px; border-bottom: 1px solid #000; border-right: 1px solid #000;"  > '.$lista_reclamos[$i]->DOCIDENT_NRODOC.'</td>
                                        <td  width="100" align="left" style=" font-size: 9px; border-bottom: 1px solid #000; border-right: 1px solid #000;"  > '.$lista_reclamos[$i]->RECFCH." ".$lista_reclamos[$i]->RECHRA.'</td>
                                        <td  width="410" align="left" style="font-size: 8px; border-bottom: 1px solid #000; border-right: 1px solid #000;"  > '.substr($descri, 0, 105) .'</td>
                                        <td  width="80" align="center" style=" font-size: 10px; border-bottom: 1px solid #000; border-right: 1px solid #000;"  >'.($lista_reclamos[$i]->TIPO_SOLICITUD == 'GENERAL' ? '<p>General</p>' : '<p>Particular</p>').'</td>
                                        <td  width="80" align="center" style=" font-size: 10px; border-bottom: 1px solid #000; border-right: 1px solid #000;"  >'.($lista_reclamos[$i]->TIPO_PROBLEMA == 'OPERACIONAL' ? '<p>Operacional</p>' : '<p>Comercial</p>').'</td>
                                        <td  width="80" align="center" style=" font-size: 10px; border-bottom: 1px solid #000;"  >'.($lista_reclamos[$i]->SRECCOD == 1 ? '<p>Pendiente</p>' : '<p>Atendido</p>').'</td>
                                    </tr>';
                        
                        $contador++;
                        $i++;
                }
                if($contador <=36){
                    $tabla = $cab_tbl.$tbl."</table>";
                    $pdf->SetXY(5 ,24);
                    $pdf->writeHTML($tabla, true, false, false, false, '');
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->writeHTMLCell(250,  5, 250, 198,"<p><strong>PAGINA </strong> ".$pdf->getAliasNumPage()." / ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
                }
                $pdf->Output(date("d/m/Y_H:i:s").'_Reporte_solicitud_requerimiento.pdf', 'D');
            }
        }

        public function intevalo_reclamos(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $hoy = $this->input->post('fin');
                $min = $this->input->post('inicio');
                $tipo = $this->input->post('tipo');
                $estado = $this->input->post('estado');
                $tipo_problema = $this->input->post('tipo_problema');
                $lista_reclamos = $this->Reclamo_no_facturacion_model->getReclamosList2($min, $hoy, $tipo, $estado, $tipo_problema);
                $json = array('result' => true,  'lista_reclamos'=> $lista_reclamos);
                echo json_encode($json);
                return;
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function Genera_Solicitud($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID, $TIPO){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $solicitud = $this->Reclamo_no_facturacion_model->getReclamo($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID);
                if($TIPO == 1){ // general 0
                    $direccion['CDPCOD'] = 13;
                    $direccion['CDPDES'] = 'LA LIBERTAD';
                    $prov =  $this->Reclamo_no_facturacion_model->getProvinciasEspe($solicitud['CPVCODDPR']);
                    $direccion['CPVCOD'] = $prov[0]['CPVCOD'];
                    $direccion['CPVDES'] = $prov[0]['CPVDES'];
                    $dist = $this->Reclamo_no_facturacion_model->getDistritoEspe($solicitud['CPVCODDPR'], $solicitud['CDSCODDPR']);
                    $direccion['CDSCOD'] = $dist[0]['CDSCOD'];
                    $direccion['CDSDES'] = $dist[0]['CDSDES'];
                    // para el grupo poblacional 
                    if($solicitud['CGPCODDPR'] != null){
                        $grupo_pobla = $this->Reclamo_no_facturacion_model->getGrupoPoblaEspe($solicitud['CPVCODDPR'], $solicitud['CDSCODDPR'], $solicitud['CGPCODDPR']);
                        if(count($grupo_pobla)>0){
                            $direccion['CGPCOD'] = $grupo_pobla[0]['CGPCOD']; 
                            $direccion['CGPDES'] = $grupo_pobla[0]['CGPDES'];
                            $via = $this->Reclamo_no_facturacion_model->getVia_pobla_Espe( 13,$solicitud['CPVCODDPR'], $solicitud['CDSCODDPR'], $solicitud['CGPCODDPR'], $solicitud['MVICODDPR']);
                            if(count($via)>0){
                                $direccion['MVICOD'] = $via[0]['MVICOD'];
                                $direccion['MVIDES'] = $via[0]['MVIDES'];
                            }else{
                                $direccion['MVICOD'] = '-';
                                $direccion['MVIDES'] = '-';
                            }
                            
                        }else{
                            $direccion['MVICOD'] = '-';
                            $direccion['MVIDES'] = '-';
                            $direccion['CGPCOD'] = '-'; 
                            $direccion['CGPDES'] = '-';
                        }
                    }else{
                        $direccion['CGPCOD'] = '-';
                        $direccion['CGPDES'] = '-';
                        $direccion['MVICOD'] = '-';
                        $direccion['MVIDES'] = '-';
                    }

                }else{  // particular 1
                    $direccion =  $this->Reclamo_no_facturacion_model->get_dire_reclamante($solicitud['CDPCODDPR'], $solicitud['CPVCODDPR'], $solicitud['CDSCODDPR'], $solicitud['CGPCODDPR'], $solicitud['MVICODDPR']);
                    
                }
                // extraigo  el nombre y apellido
                $dato_Nombre =  $this->Reclamo_no_facturacion_model->searchUsuario2($solicitud['DOCIDENT_TIPDOC'], $solicitud['DOCIDENT_NRODOC']);
                // EXTRAIGO LA DESCRIPCIÓN DEL RECLAMO
                $decri_recla['CPID']       =$solicitud['CPID']      ;
                $decri_recla['TIPPROBID']  =$solicitud['TIPPROBID'] ;
                $decri_recla['SCATPROBID'] =$solicitud['SCATPROBID'];
                $decri_recla['PROBID']     =$solicitud['PROBID'];
                $recla_descripcion =  $this->Reclamo_no_facturacion_model->get_descri_reclamo($decri_recla);
                $this->data['Nombre_Solicitante'] = $dato_Nombre;
                $this->data['recla_descripcion'] = $recla_descripcion;
                $this->data['areas'] = $this->Reclamo_no_facturacion_model->getAreas();
                $this->data['solicitud'] = $solicitud;
                $this->data['direccion'] = $direccion;
                $this->data['tipo'] = $TIPO;
                $this->data['cadena'] = $EMPCOD.'-'.$OFICOD.'-'.$ARECOD.'-'.$CTDCOD.'-'.$DOCCOD.'-'.$SERNRO.'-'.$RECID.'-'.$TIPO;
                $this->data['empresa'] = $this->Reclamo_no_facturacion_model->get_empresa();
                $this->data['view'] = 'reclamo_no_facturacion/Crea_sol_req_view';
                $this->data['breadcrumbs'] = array(array('Crea Solicitud de Requerimiento', ''));
                $this->load->view('template/Master', $this->data);
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return; 
            }
        }


        public function Crear_orden_req(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $cadena = $this->input->post('cad');
                $apePaterno = $this->input->post('apePat');
                $apeMaterno = $this->input->post('apeMat');
                $nombre = $this->input->post('Nombre');
                $cadena = explode("-", $cadena);
                $solicitud = $this->Reclamo_no_facturacion_model->getReclamo($cadena[0], $cadena[1], $cadena[2], $cadena[3], $cadena[4], $cadena[5], $cadena[6]);
                $Rpta_reclamo = $this->Reclamo_no_facturacion_model->setOrden_reclamo($solicitud,$apePaterno,$apeMaterno,$nombre);
                //$json = array('result' => true,  'lista_reclamos'=> $lista_reclamos);
                echo json_encode($json);
                return;
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }

        }

    }