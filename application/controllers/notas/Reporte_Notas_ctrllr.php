<?php
class Reporte_Notas_ctrllr extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('notas/Reporte_Notas_model'); 
        $this->load->library('session'); 
        $this->load->library('acceso_cls'); 
        $this->data['actividad'] = 'reportes'; 
        $this->data['rol'] = $this->Reporte_Notas_model->get_rol($_SESSION['user_id']); 
        $this->acceso_cls->isLogin(); 
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata(); 
        $permiso = $this->Reporte_Notas_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']); 
        if($permiso){ 
            $this->data['proceso'] = $permiso['ACTIVINOMB'];  
            $this->data['id_actividad'] = $permiso['ID_ACTIV']; 
            $this->data['menu']['padre'] =  $permiso['MENUGENPDR']; 
            $this->data['menu']['hijo'] =  $permiso['ACTIVIHJO']; 
        } else { 
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function listar(){
        $permiso = $this->Reporte_Notas_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
        if($permiso){
            $this->data['view'] = 'notas/Reporte_Notas_view';
            $this->data['breadcrumbs'] = array(array('REPORTE NOTAS', ''));
            $this->load->view('template/Master', $this->data);
        } else {
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function getAgencias(){
        $permiso = $this->Reporte_Notas_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
        if($permiso){
            $ajax = $this->input->get('ajax');
            if($ajax){
                $agencias = $this->Reporte_Notas_model->getAllAgencias();
                if($agencias){
                    $json = array('result' => true, 'mensaje' => 'ok', 'agencias' => $agencias);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                } else {
                    $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_vacio'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        } else {
            $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }

    public function putNotas(){
        $permiso = $this->Reporte_Notas_model->get_permiso_cuenta_corriente($_SESSION['user_id'],$this->data['actividad']);
        if($permiso){
            $ajax = $this->input->get('ajax');
            if($ajax){
                $todas = $this->input->post('todas');
                $cheked = $this->input->post('cheked');
                $fechaInicio = $this->input->post('fechaInicio');
                $fechaFin = $this->input->post('fechaFin');
                if($todas == 'true'){
                    $series = $this->Reporte_Notas_model->getAllSeries();
                } else {
                    $series = $this->Reporte_Notas_model->getSeriesXOficina($cheked);
                }
                $notas = $this->Reporte_Notas_model->getNotasCredito($series, $fechaInicio, $fechaFin);
                if($notas){
                    $json = array('result' => true, 'mensaje' => 'ok', 'notas' => $notas);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                } else {
                    $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_vacio'));
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                }
            } else {
                $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
            }
        } else {
            $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_error'));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }

    public function cleanData(&$str){
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    public function exportExcel(){
        $data = $this->input->post('input_1');
        $r = json_decode($data);
        $this->load->library("excel");
        $objPHPExcel = new PHPExcel();
        // Agregaremos los datos de nuestro documento
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'RECIBO');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'NOTA DE CRÉDITO');
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->mergeCells('H1:S1');
        $objPHPExcel->getActiveSheet()->getStyle("A1:G1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("H1:S1")->applyFromArray($style);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'CODIGO')
                    ->setCellValue('B2', 'SERIE')
                    ->setCellValue('C2', 'NUMERO')
                    ->setCellValue('D2', 'FECHA EMISIÓN')
                    ->setCellValue('E2', 'SUBTOTAL')
                    ->setCellValue('F2', 'I.G.V.')
                    ->setCellValue('G2', 'TOTAL')
                    ->setCellValue('H2', 'SERIE')
                    ->setCellValue('I2', 'NUMERO')
                    ->setCellValue('J2', 'ESTADO')
                    ->setCellValue('K2', 'FECHA EMISIÓN')
                    ->setCellValue('L2', 'SUBTOTAL')
                    ->setCellValue('M2', 'IGV')
                    ->setCellValue('M2', 'TOTAL')
                    ->setCellValue('O2', 'REFERENCIA')
                    ->setCellValue('P2', 'HECHO POR')
                    ->setCellValue('Q2', 'MES')
                    ->setCellValue('R2', 'AÑO')
                    ->setCellValue('S2', 'OFICINA');
        $objPHPExcel->getActiveSheet()->setTitle('REPORTE NOTA DE CRÉDITO');
                     
        //Seleccionamos la hoja que estara seleccionada al abrir el documento
        $objPHPExcel->setActiveSheetIndex(0);
        $i = 0;
        $j = 3 ;
        $tam = sizeof($r);
        while($i < $tam){
            $style = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$j, 'oficina: '.$r[$i]->oficod.'  '.$r[$i]->agen.' - '.$r[$i]->des);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$j.':S'.$j);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':S'.$j)->applyFromArray($style);
            $tam1 = sizeof($r[$i]->notas);
            $j++;
            for($k = 0; $k < $tam1; $k++){
                $mes = $this->obetner_mes(substr($r[$i]->notas[$k]->NCAFECHA,3,2));
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$j, $r[$i]->notas[$k]->NCACLICODF)
                            ->setCellValue('B'.$j, $r[$i]->notas[$k]->TOTFAC_FACSERNRO)
                            ->setCellValue('C'.$j, $r[$i]->notas[$k]->TOTFAC_FACNRO)
                            ->setCellValue('D'.$j, $r[$i]->notas[$k]->NCAFACEMIF)
                            ->setCellValue('E'.$j, $r[$i]->notas[$k]->NCAFACTOTS)
                            ->setCellValue('F'.$j, $r[$i]->notas[$k]->NCAFACIGV)
                            ->setCellValue('G'.$j, $r[$i]->notas[$k]->NCAFACTOTA)
                            ->setCellValue('H'.$j, $r[$i]->notas[$k]->NCASERNRO)
                            ->setCellValue('I'.$j, $r[$i]->notas[$k]->NCANRO)
                            ->setCellValue('J'.$j, $r[$i]->notas[$k]->NCAFACESTA)
                            ->setCellValue('K'.$j, $r[$i]->notas[$k]->NCAFECHA)
                            ->setCellValue('L'.$j, $r[$i]->notas[$k]->NCASUBDIF)
                            ->setCellValue('M'.$j, $r[$i]->notas[$k]->NCAIGVDIF)
                            ->setCellValue('N'.$j, $r[$i]->notas[$k]->NCATOTDIF)
                            ->setCellValue('O'.$j, $r[$i]->notas[$k]->NCAREFE)
                            ->setCellValue('P'.$j, $r[$i]->notas[$k]->NNOMBRE)
                            ->setCellValue('Q'.$j, $mes)
                            ->setCellValue('R'.$j, substr($r[$i]->notas[$k]->NCAFECHA,6,4))
                            ->setCellValue('S'.$j, $r[$i]->des);
                $j++; 
            }
            $i++;
        }             
        // Guardamos el archivo Excel
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteNotasCredito.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
	
    }

    private function obetner_mes($str){
        $int = intval($str);
        switch($int){
            case 1: return 'ENERO';break;
            case 2: return 'FEBRERO';break;
            case 3: return 'MARZO';break;
            case 4: return 'ABRIL';break;
            case 5: return 'MAYO';break;
            case 6: return 'JUNIO';break;
            case 7: return 'JULIO';break;
            case 8: return 'AGOSTO';break;
            case 9: return 'SETIEMBRE';break;
            case 10: return 'OCTUBRE';break;
            case 11: return 'NOVIEMBRE';break;
            case 12: return 'DICIEMBRE';break;
        }
    }

    public function exportarPDF(){
        $data = $this->input->post('input_1');
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $r = json_decode($data);
        var_dump($fecha2);
        $this->load->library('pdf1');
        $mpdf = $this->pdf1->load('utf-8', 'A4', 0, '', 5, 5, 30, 5, 5, 5,'L');
        $mpdf->SetHTMLHeader('<table width="100%" style="font-size:11px;font-family: Arial">'.
                                  '<tr>'.
                                    '<td style="text-align:left;width:25%">GENESYS WEB</td>'.
                                    '<td style="width:45%;text-align:center"><h3 style="font-family: Arial">REPORTE DE NOTAS DE CRÉDITO</h3></td>'.
                                    '<td style="text-align:right"><b>FECHA: </b></td>'.
                                    '<td style="width:7%">'.date('d/m/y').'</td>'.
                                  '</tr>'.
                                  '<tr>'.
                                    '<td></td>'.
                                    '<td style="text-align:center">DEL '.$fecha1.' AL '.$fecha2.'</td>'.
                                    '<td style="text-align:right"><b>HORA: </b></td>'.
                                    '<td>'.date('H:i:s').'</td>'.
                                  '</tr>'.
                                  '<tr>'.
                                    '<td></td>'.
                                    '<td style="text-align:center"></td>'.
                                    '<td style="text-align:right"><b>PÁGINA: </b></td>'.
                                    '<td>{PAGENO}</td>'.
                                  '</tr>'.
                                '</table>'.
                                '<table width="100%" style="font-size:11px;font-family: Arial;font-weight:bold" cellpading="0" >'.
                                    '<tr>'.
                                        '<td></td>'.
                                        '<td colspan="5" style="text-align:center;border-bottom:1px solid #000;border-left:1px solid #FFF">RECIBO</td>'.
                                        '<td colspan="6" style="text-align:center;border-bottom:1px solid #000;border-left:1px solid #FFF">NOTAS DE CRÉDITO EMITIDAS</td>'.
                                        '<td></td>'.
                                        '<td></td>'.
                                    '</tr>'.
                                    '<tr>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:8%">CODIGO</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:8%"></td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">F. EMIS.</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">SUBT.</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">I.G.V.</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">TOTAL</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:7%">NUMERIC</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:3%">EST.</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">F.EMIS.</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">SUBT.</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">I.G.V.</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:6%">TOTAL</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF;width:12%">REFERENCIA</td>'.
                                        '<td style="border-bottom:1px solid #000;border-left:1px solid #FFF">HECHO POR</td>'.
                                    '</tr>'.
                                '</table>');
        $html = '<table style="font-size:10px;font-family: Arial" width="100%">';
        $r = json_decode($data);
        $tam = sizeof($r);
        $i = 0;
        while($i < $tam){
            $html .= '<tr>'.
                        '<td colspan="14"><b>oficina: '.$r[$i]->oficod.'  '.$r[$i]->agen.' - '.$r[$i]->des.'</b></td>'.
                    '</tr>';
            $tam1 = sizeof($r[$i]->notas);
            for($k = 0; $k < $tam1; $k++){
                $html .= '<tr>'.
                            '<td style="width:8%">'.$r[$i]->notas[$k]->NCACLICODF.'</td>'.
                            '<td style="width:8%">'.$r[$i]->notas[$k]->TOTFAC_FACSERNRO.' '.$r[$i]->notas[$k]->TOTFAC_FACNRO.'</td>'.
                            '<td style="width:6%">'.$r[$i]->notas[$k]->NCAFACEMIF.'</td>'.
                            '<td style="width:6%; text-align:right">'.number_format($r[$i]->notas[$k]->NCAFACTOTS,2,'.',' ').'</td>'.
                            '<td style="width:6%; text-align:right">'.number_format($r[$i]->notas[$k]->NCAFACIGV,2,'.',' ').'</td>'.
                            '<td style="width:6%; text-align:right">'.number_format($r[$i]->notas[$k]->NCAFACTOTA,2,'.',' ').'</td>'.
                            '<td style="width:7%; text-align:right">'.$r[$i]->notas[$k]->NCASERNRO.' '.$r[$i]->notas[$k]->NCANRO.'</td>'.
                            '<td style="width:3%; text-align:center">'.$r[$i]->notas[$k]->NCAFACESTA.'</td>'.
                            '<td style="width:6%">'.$r[$i]->notas[$k]->NCAFECHA.'</td>'.
                            '<td style="width:6%; text-align:right">'.number_format($r[$i]->notas[$k]->NCASUBDIF,2,'.',' ').'</td>'.
                            '<td style="width:6%; text-align:right">'.number_format($r[$i]->notas[$k]->NCAIGVDIF,2,'.',' ').'</td>'.
                            '<td style="width:6%; text-align:right">'.number_format($r[$i]->notas[$k]->NCATOTDIF,2,'.',' ').'</td>'.
                            '<td style="width:12%;padding-left:10px">'.substr($r[$i]->notas[$k]->NCAREFE,0,20).'</td>'.
                            '<td>'.substr($r[$i]->notas[$k]->NNOMBRE,0,22).'</td>'.
                        '</tr>';
            }
            
            $html .= '<tr>'.
                        '<td></td>'.
                        '<td></td>'.
                        '<td></td>'.
                        '<td></td>'.
                        '<td colspan="2" style="border-top:1px solid #000;border-left:1px solid #FFF"><b>Nro. Registros: </b></td>'.
                        '<td style="border-top:1px solid #000;border-left:1px solid #FFF">'.$r[$i]->cantidad.'</td>'.
                        '<td colspan="2" style="border-top:1px solid #000;border-left:1px solid #FFF"><b>Importes: </b></td>'.
                        '<td style="text-align:right;border-top:1px solid #000;border-left:1px solid #FFF">'.$r[$i]->subtotal.'</td>'.
                        '<td style="text-align:right;border-top:1px solid #000;border-left:1px solid #FFF">'.$r[$i]->igv.'</td>'.
                        '<td style="text-align:right;border-top:1px solid #000;border-left:1px solid #FFF">'.$r[$i]->total.'</td>'.
                        '<td></td>'.
                        '<td></td>'.
                    '</tr>';
            $i++;
        }
        $html .= '</table>';
        $mpdf->AddPage('L');
        $mpdf->WriteHTML($html);
        $content = $mpdf->Output('ReporteNotas'.date('dmY').'.pdf', 'D');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();

    }
}