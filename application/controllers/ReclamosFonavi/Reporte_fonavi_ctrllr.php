

<?php
    // if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
   

    class Reporte_fonavi_ctrllr extends CI_Controller{
        /* [CONSTRUCTOR]*/
        public function __construct() {
            parent::__construct();
            $this->load->model('acceso/Usuario_model'); //PERMITE OBTENER ACCESO AL MODELO PARA PODER UTILIZAR SUS FUNCIONES
            $this->load->model('ReclamosFonavi/ReporteFonavi_model'); // **
            $this->load->model('cuenta_corriente/Cuentas_corrientes_model'); // **
            $this->load->model('ReclamosFonavi/ReclamoFonavi_model'); // **
            // $this->load->model('notas/Nota_Credito_model');
            $this->load->library('session'); // PERMITE EL ACCESO A LAS LIBRERIAS DE SESION
            $this->load->library('acceso_cls'); // **
            $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']); // [GENERAL] -> OBTIENE EL MENU DE OPCIONES DE LA PARTE IZQUIERDA DEL PROYECTO
            $this->acceso_cls->isLogin();
            $this->data['userdata'] = $this->acceso_cls->get_userdata(); // [GENERAL] -> OBTIENE LA DATA DEL USUARIO
            $this->data['permiso'] = $this->Cuentas_corrientes_model->get_permiso_cuenta_corriente($_SESSION['user_id'],'Reporte_Reclamo/Reporte_Fonavi'); // OBTIENE LOS PERMISOS DEL USUARIO PARA EL MODULO
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
    
        public function listaReporte(){
            $this->data['usuarios'] = $this->ReporteFonavi_model->get_usuarios_nc_recibos();
            $this->data['view'] = 'ReclamosFonavi/ReporteFonavi_view';
            $this->data['breadcrumbs'] = array(array('Reporte Solicitud Reclamo', ''));
            $this->load->view('template/Master', $this->data);
        }

        public function generarReporte(){
          $ajax = $this->input->get('ajax');
          if(!$ajax){
              $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
              echo json_encode($json);
              return;
          }
          $estadoRep = $this->input->post('EstadoRec');
          $inicio = $this->input->post('inicio');
          $fin = $this->input->post('fin');
          $result = $this->ReporteFonavi_model->generar_reporte_SolicitudReclamo($estadoRep, $inicio, $fin);
          $total = count($result);
          $json = array('result' => true, 'reclamosRep' => $result, 'total' => $total);
          header('Access-Control-Allow-Origin: *');
          header('Content-Type: application/x-json; charset=utf-8');
          echo json_encode($json);
        }


        public function CrearExcel(){
          if($this->input->server('REQUEST_METHOD') == 'POST'){
                  $array = json_decode($this->input->post('reporte'));
                  // var_dump($array);
                  // EXTRAIGO DATOS  
                  $data = $this->ReporteFonavi_model->generar_reporte_SolicitudReclamo($array[0],$array[1],$array[2]);
                  // var_dump($data);
                  if (count($data)>0) {
                      //cargo data;    
                      $this->load->library("excel");
                      $objPHPExcel = new PHPExcel();
                     

                      // CABECERA PARA EL DOCUMENTO EXCEL GENERADO
                      $objPHPExcel->setActiveSheetIndex(0)
                                  ->setCellValue('A1', 'COD')
                                  ->setCellValue('B1', 'CODIGO PRESTATARIO')
                                  ->setCellValue('C1', 'FECHA REGISTRO')
                                  ->setCellValue('D1', 'HORA REGISTRO')
                                  ->setCellValue('E1', 'SUMINISTRO')
                                  ->setCellValue('F1', 'PROYECTO')
                                  ->setCellValue('G1', 'PRESTATARIO')
                                  ->setCellValue('H1', 'SOLICITANTE')
                                  ->setCellValue('I1', 'USUARIO')
                                  ->setCellValue('J1', 'ESTADO');                          
                      $i=0;
                      $j=2;
                      while ($i<count($data)) {
                         // DATOS A MOSTRAR 
                          $objPHPExcel->setActiveSheetIndex(0)
                                  ->setCellValue('A'.$j, $data[$i]['COD_REC'])
                                  ->setCellValue('B'.$j, $data[$i]['CODIGO'])
                                  ->setCellValue('C'.$j, $data[$i]['FEC_REG'])
                                  ->setCellValue('D'.$j, $data[$i]['HORA_REG'])
                                  ->setCellValue('E'.$j, $data[$i]['SUMINISTRO'])
                                  ->setCellValue('F'.$j, $data[$i]['PROYECTO'])
                                  ->setCellValue('G'.$j, $data[$i]['PRESTATARIO'])
                                  ->setCellValue('H'.$j, $data[$i]['NOMBRE'].", ".$data[$i]['APEPAT']." ".$data[$i]['APEMAT'])
                                  ->setCellValue('I'.$j, $data[$i]['USUARIO'])
                                  ->setCellValue('J'.$j, $data[$i]['ESTADO_DESC']); 
  
                          $i = $i + 1 ;
                          $j = $j + 1 ;
                      }
                       
                      // Rename worksheet
                    $objPHPExcel->getActiveSheet()->setTitle('ReclamosFonavi');
     
                    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $styleArray = array(
                        'font'  => array(
                            'bold'  => true,
                            'color' => array('rgb' => 'FFFFFF'),
                            'size'  => 10,
                            'name'  => 'Verdana'
                        ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                            'rotation' => 90,
                            'startcolor' => array(
                                'rgb' => '0470B6'
                            )
                        ),
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleArray);
                    foreach(range('A1','J1') as $columnID) {
                        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                            ->setAutoSize(true);
                    }

                      // Establezca el índice de hoja activa en la primera hoja, por lo que Excel abre esto como la primera hoja
                      $objPHPExcel->setActiveSheetIndex(0);
                       
                      // Guardamos el archivo Excel

                      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                      ob_end_clean();
                      // We'll be outputting an excel file
                      header('Content-type: application/vnd.ms-excel');
                      // It will be called file.xls
                      header('Content-Disposition: attachment;filename="ArchivoMail_'.$array[1].$array[0].'_'.$array[2].'.xlsx"');
                      $objWriter->save('php://output');
                      exit;
                  }else{
                      $this->session->set_flashdata('mensaje', array('error', 'Alerta: no se encontraron reclamos cargados ',""));
                      //echo "<script lenguaje=\'JavaScript\''>window.close();</script>";
                      echo "No se encuentran subidos los recibos";
                      //redirect(base_url() . 'mail/CrearExcel');
                      
                      //return ;
                  }
                  
            }
        }
        

        public function SendReportPDF(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                        $array = json_decode($this->input->post('imprimir_reporte'));
                        $lista_reclamos = $this->ReclamoFonavi_model->get_Reclamos_viewDetalle($array[0]);

                        $this->load->library('Reporte_sol_req');
                        $pdfR = new Reporte_sol_req(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                        // var_dump($lista_reclamos);
                        // set header and footer fonts
                        $pdfR->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            
                        // set default monospaced font
                        $pdfR->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                        
                        // set margins
                        $pdfR->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                        $pdfR->SetHeaderMargin(0);
                        $pdfR->SetFooterMargin(0);
                        // remove default footer
                        $pdfR->setPrintFooter(false);
            
                        // set auto page breaks 
                        $pdfR->SetAutoPageBreak(TRUE, 0);
  
                        // set image scale factor
                        $pdfR->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
                        // add a page
                        $pdfR->AddPage('P', 'A4');
                        
                        $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                        $pdf = $this->genero_cabecera($pdfR, $style);

                        $medios = "";

                        $doc  = $lista_reclamos[0]['REC_DOC'];
                        $porcion = explode("-", $doc);
                        foreach ($porcion as &$array) {
                            switch ($array) {
                                case '1': $medios = $medios.'* Copia legible del documento de identidad-'; break;
                                case '2': $medios = $medios.'* Copia de la liquidación por conexión domiciliaria objetivo del reclamo-';break;
                                case '3': $medios = $medios.'* Recibos de consumo (copia simple)-';break;
                                case '4': $medios = $medios.'* Constancia de pago otorgada por la concesionaria o quien haga sus veces (original y solo en caso no presenten recibos)</p>-';break;
                                case '5': $medios = $medios.'* Depósitos bancarios y otros ( copia simple de cada recibo), de ser el caso-';break;
                            }
                        }
                        $docMedios = explode("-", substr($medios,0 ,-1));
                        
                        
                        $pdf = $this->genera_detalle($pdfR, $lista_reclamos, $docMedios, $style);
                        // var_dump($data);

                        $table = '
                            <table cellspacing="0" cellpadding="1" border="0" style="margin-left: 40;">
                                <tr style ="font-size: 8px; font-weight: bold; color:#000;">
                                    <td height="15" width="80" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;"  >NUMERO RECIBO</td>
                                    <td height="15" width="80" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >SUMINISTRO</td>
                                    <td height="15" width="70" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >EMISION</td>
                                    <td height="15" width="70" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >PERIODO</td>
                                    <td height="15" width="70" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >ESTADO</td>
                                    <td height="15" width="70" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >MONTO</td>
                                    <td height="15" width="80" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >LOCALIDAD</td>
                                    <td height="15" width="60" align="center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;"  >MONTO FONAVI</td>
                                </tr>';
                        
                        $tbl = '';
                        for ($i = 0; $i <= strlen($lista_reclamos); $i++) {
                            $tbl = $tbl .'<tr style ="font-size: 8px; color:#000;">
                                                <td height="20" align="center">'.$lista_reclamos[$i]["SERIE_RECIBO"].' - '.$lista_reclamos[$i]["NUMERO_RECIBO"].'</td>
                                                <td height="20" align="center">'.$lista_reclamos[$i]["SUMINISTRO"].'</td>
                                                <td height="20" align="center">'.$lista_reclamos[$i]["FECHA_EMISION_RECIBO"].'</td>
                                                <td height="20" align="center">'.$lista_reclamos[$i]["PERIODO"].'</td>';

                            if($lista_reclamos[$i]['ESTADO_RECIBO'] == 'I') $tbl = $tbl.= '<td height="20" align="center">PENDIENTE</td>';
                            else if($lista_reclamos[$i]['ESTADO_RECIBO'] == 'P') $tbl = $tbl.= '<td height="20" align="center">PAGADO</td>';
                            else if($lista_reclamos[$i]['ESTADO_RECIBO'] == 'R') $tbl = $tbl.='<td height="20" align="center">REFINANCIADO</td>';
                            else if($lista_reclamos[$i]['ESTADO_RECIBO'] == 'C') $tbl = $tbl.= '<td height="20" align="center">CONVENIO</td>';

                            $tbl = $tbl . '<td height="20" align="center">'.$lista_reclamos[$i]["TOTAL_RECIBO"].'</td>
                                            <td height="20" align="center">'.$lista_reclamos[$i]["LOCALIDAD"].'</td>
                                            <td height="20" align="center"><b>'.$lista_reclamos[$i]["IMPORTE_FONAVI"].'</b></td>
                                        </tr>';
                        }
                                
                        $contador = 0;
                        
                        $tabla = $table.$tbl."</table>";
                        // $tabla = "";
                        $pdf->SetXY(21 ,210);
                        $pdf->SetFont('helvetica', '', 7);
                        $pdf->writeHTML($tabla, true, false, false, false, '');

  
                        ob_end_clean();
              $pdf->Output(date("d/m/Y_H:i:s").'_Reporte_solicitud.pdf', 'I');
            }
        }

        private function genero_cabecera($pdf, $style){
            //Valores de configuracion
            $fijo = 170;
            $pdf->Image( base_url()."img/logo4.jpg", 4, 4, 45, 11, '', '', '', false, 300, '', false, false, 0);
            $pdf->SetFont('helveticaB', '',12);
            $pdf->writeHTMLCell($fijo, 5, 50, 12 ,"<p><h3><u>MODELO DE SOLICITUD DE RECLAMACIÓN</u></h3></p>", 0, 1, 0, true, 'L',  true); 
            $pdf->SetFont('helvetica', '',7.2);
            $pdf->writeHTMLCell($fijo, 5, 90, 28 ,"<p>(Tramite gratuito)</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell($fijo, 5, 75, 32 ,"<p ><h3>RECURSO DE RECLAMACIÓN</h3></p>", 0, 1, 0, true, 'L',  true);

            $pdf->writeHTMLCell($fijo, 5, 15, 48 ,"<p>Señores</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell($fijo, 5, 15 , 52 ,"<p>SECRETARIA TECNICA DE APOYO A LA</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell($fijo, 5, 15, 56 ,"<p>COMISION AD HOC LEY N°296225.</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell($fijo, 5, 15, 60 ,"<p>Jr. Cuzco 177-Lima</p>", 0, 1, 0, true, 'L',  true);

            $pdf->writeHTMLCell($fijo, 5, 110, 64 ,"<p><u>Atención:</u> Sub Dirección de Recuperaciones cobranzas e</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell($fijo, 5, 121, 68 ,"<p>Inversiones</p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helvetica', '',7);
            $pdf->writeHTMLCell($fijo, 5, 165, 6 ,"<p>FECHA: ".date("d/m/Y  H:i:s")." </p>", 0, 1, 0, true, 'L',  true);
            return $pdf;
        }
        private function genera_detalle($pdf, $data, $medios, $style){
        
            $pdf->writeHTMLCell(170, 5, 15, 75 ,"<p>1.  DATOS GENERALES</p>", 0, 1, 0, true, 'L',  true);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(170, 5, 22, 85 ,"<p>1.1. Del Proyecto</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 26, 90 ,"<p>Código: ".$data[0]['COD_PROY']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 26, 94 ,"<p>Ubicación: ".$data[0]['UBIPROYEC']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 54, 90 ,"<p>Nombre: ".$data[0]['PROYECTO']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 117, 94 ,"<p>Concesionaria: ".$data[0]['CONCESIONARIO']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->Line(20, 82 ,195, 82 , $style);
            $pdf->Line(20, 102 ,195, 102 , $style);
            $pdf->Line(20, 102 ,20, 82 , $style);
            $pdf->Line(195, 102 ,195, 82 , $style);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(170, 5, 22, 110 ,"<p>1.2. Del Prestatario</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 26, 115 ,"<p>Código: ".$data[0]['CODIGO']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 54, 115 ,"<p>Nombre: ".$data[0]['PRESTATARIO']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 26, 119 ,"<p>Dirección: ".$data[0]['DIRECCION_P']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->Line(20, 106 ,195, 106 , $style);
            $pdf->Line(20, 125 ,195, 125 , $style);
            $pdf->Line(20, 125 ,20, 106 , $style);
            $pdf->Line(195, 125 ,195, 106 , $style);


            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(170, 5, 15, 130 ,"<p>2.  MOTIVO DE LA RECLAMACIÓN</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(160, 5, 23, 135 ,"<p>".$data[0]['REC_MOTIV']."</p>", 0, 50, 0, true, 'L',  true);
            $pdf->Line(20, 135 ,180, 135 , $style);
            $pdf->Line(20, 145 ,180, 145 , $style);
            $pdf->Line(20, 145 ,20, 135 , $style);
            $pdf->Line(180, 145 ,180, 135 , $style);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(170, 5, 15, 150 ,"<p>3.  MEDIOS PROBATORIOS: Documentos probatorios de sustento:</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 23, 156 ,"<p>".$medios[0]."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 23, 159 ,"<p>".$medios[1]."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 23, 162 ,"<p>".$medios[2]."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 23, 165 ,"<p>".$medios[3]."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 23, 168 ,"<p>".$medios[4]."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->Line(20, 155 ,180, 155 , $style);
            $pdf->Line(20, 175 ,180, 175 , $style);
            $pdf->Line(20, 175 ,20, 155 , $style);
            $pdf->Line(180, 175 ,180, 155 , $style);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(170, 5, 15, 180 ,"<p>4.  OBSERVACIONES</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(160, 5, 23, 185 ,"<p>".$data[0]['REC_OBS']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->Line(20, 185 ,180, 185 , $style);
            $pdf->Line(20, 200 ,180, 200 , $style);
            $pdf->Line(20, 200 ,20, 185 , $style);
            $pdf->Line(180, 200 ,180, 185 , $style);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(170, 5, 15, 240,"<p>5.  SOLICITANTE</p>", 0, 1, 0, true, 'L',  true);
            $pdf->Line(20, 245 ,85, 245 , $style);
            $pdf->Line(20, 267 ,85, 267 , $style);
            $pdf->Line(20, 267 ,20, 245 , $style);
            $pdf->Line(85, 267 ,85, 245 , $style);

            $pdf->writeHTMLCell(170, 5, 22, 246 ,"<p>Nombre: ".$data[0]['NOMBRE']." ".$data[0]['APEPAT']." ".$data[0]['APEMAT']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 22, 251 ,"<p>DNI: ".$data[0]['NRODOC']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 22, 256 ,"<p>Firma: </p>", 0, 1, 0, true, 'L',  true);



            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(170, 5, 120, 240,"<p>ENTIDAD RECEPTORA</p>", 0, 1, 0, true, 'L',  true);
            $pdf->Line(120, 245 ,185, 245 , $style);
            $pdf->Line(120, 267 ,185, 267 , $style);
            $pdf->Line(120, 267 ,120, 245 , $style);
            $pdf->Line(185, 267 ,185, 245 , $style);

            $pdf->writeHTMLCell(170, 5, 122, 246 ,"<p>Nombre: ".$data[0]['USUARIO']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 122, 251 ,"<p>Fecha recepción: ".$data[0]['FEC_REG']."</p>", 0, 1, 0, true, 'L',  true);
            $pdf->writeHTMLCell(170, 5, 122, 256 ,"<p>Sello o firma: </p>", 0, 1, 0, true, 'L',  true);


            return $pdf;
        }

    }
?>