<?php

class Reporte_ctrllr extends CI_Controller {


    //var
    public function __construct() {

        parent::__construct();
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->load->library('grafico_barras');
        $this->grafico_barras->cargar();
        $this->load->model('general/Catalogo_model');
        $this->load->model('boleta_factura/Comprobante_pago_model');
        //var_dump(date('d-m-Y'));
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Reporte';
        $this->data['menu']['padre'] = 'comprobantes';
        $this->data['menu']['hijo'] = 'reporte';
        //var_dump($_SESSION);

    }

    public function mostrar_reporte(){
        $rol=$this->Catalogo_model->get_rol($_SESSION['user_id']);
        $this->data['ROL'] = $rol[0]['ID_ROL'];
        // var_dump($rol);
        $this->data['view'] = 'boleta_factura/Reporte_lista_view';
        $this->data['titulo'] = 'Reporte de Boleas y Facturas';
        $this->data['breadcrumbs'] = array(array('Reporte', ''));
        $this->load->view('template/Master', $this->data);
    }

    public function mostrar_reporte_diario(){
        $rol=$this->Catalogo_model->get_rol($_SESSION['user_id']);
        if($rol[0]['ID_ROL'] == 1){
            $this->data['menu']['hijo'] = 'Rep Diario';
            $this->data['view'] = 'boleta_factura/Reporte_diario_view';
            $this->data['titulo'] = 'Reporte Diario de Boleas y Facturas';
            $this->data['breadcrumbs'] = array(array('Reporte', ''));
            $this->load->view('template/Master', $this->data);
        }else{
             redirect($this->config->item('ip') . 'inicio');
        }

    }

    public function reporte_formato_2 (){
        
        if($this->input->server('REQUEST_METHOD') == 'POST'){

            $array = json_decode($this->input->post('reporte'));
            $oficinas = $this->Comprobante_pago_model->obtener_oficinas($array[0]);
            for($i=0; $i<count($oficinas); $i++){
                $oficinas[$i]['COMPROBANTES'] = $this->Comprobante_pago_model->comprobante_by_intervalo($array[0], $oficinas[$i]['SERNRO'], $array[1], $array[2], $array[3]);
            }
            $tipo_documento = "";
            $doc_tipo="";
            if($array[0]=="0")
            {
                $doc_tipo="03";
                $tipo_documento = "B";
            }
            else{
                $doc_tipo="01";
                $tipo_documento = "F";
            }
            $monto="";
            if($array[3]>0){
                $monto="<p><strong>MONTO MAYOR A ".$array[3]."</strong></p>";
            }
            $this->load->library('Reporte_antiguo_tcpdf');
            // create new PDF document
            $pdf = new Reporte_antiguo_tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf ->agregar_datos( $array[1], $array[2], date('d-m-Y'), date('h:i:s A'),$_SESSION['user_nom']);
            $PDF_MARGIN_BOTTOM = 0;
            $pdf->SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);
            // add a page
            $pdf->AddPage('L', 'A4');
            $cab = '<table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                      <td width="15" align="center" rowspan="2">Itm</td>
                      <td width="20" rowspan="2" > Ser. </td>
                      <td width="20" align="center" rowspan="2">Nro.</td>
                      <td width="50" align="center" rowspan="2">Fecha Emision</td>
                      <td width="50" align="center" rowspan="2">Fec. Vcto.</td>
                      <td width="15" align="center" rowspan="2">Tip</td>
                      <td width="50" align="center" rowspan="2">Codigo Cliente</td>
                      <td width="190" align="center" rowspan="2">Nombre de Cliente</td>
                      <td width="30" align="center" rowspan="2">Tip. Doc.</td>
                      <td width="50" align="center" rowspan="2">Num. Doc.</td>
                      <td width="50" align="center" rowspan="2">Valor de Exp.</td>
                      <td width="50" align="center" rowspan="2">Base Imp. Op. Grab.</td>
                      <td width="40" align="center" rowspan="2">I.G.V.</td>
                      <td width="40" align="center" rowspan="2">Otros Carg.</td>
                      <td width="40" align="center" rowspan="2">Total</td>
                      <td width="40" align="center" rowspan="2">Fecha</td>
                      <td width="60" align="center" colspan="3">Referencia</td>
                     </tr>
                     <tr>
                       <td width="20" align="center">Tip.</td>
                       <td width="20" align="center">Ser.</td>
                       <td width="20" align="center">Nro.</td>
                     </tr>

                    </table>';
            //cabecera 
            $pdf->SetFont('helvetica', '', 6);
            $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
            $style = array('width' => 0.2, 'cap' =>'butt','join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $pdf->Line(4,28, 290, 28, $style);
            $contador = 31;
            $total_subto=0;
            $total_igv=0;
            $total_total=0;
            foreach ($oficinas as $oficina) {
               if ($contador >= 195) {
                  $pdf->AddPage('L', 'A4');
                  $pdf->SetFont('helvetica', '', 6);
                  $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                  $pdf->Line(4,28, 290, 28, $style);
                  $contador =31;
                }
                //detalle de inicio
                if(count($oficina['COMPROBANTES'])>0){
                    $item=1;
                    $suma_subto=0;
                    $suma_igv=0;
                    $suma_total=0;
                    $pdf->writeHTMLCell(280,  0, 4, $contador,"<p><strong>Serie ". $oficina['SERNRO']." Oficina asignada". $oficina['OFIDES']."</strong></p>", 0, 1, 0, true, 'L',  true);
                    $contador = $contador + 3;
                    foreach ($oficina['COMPROBANTES'] as $comprobante){
                         if ($contador >= 195) {
                              $pdf->AddPage('L', 'A4');
                              $pdf->SetFont('helvetica', '', 6);
                              $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                              $pdf->Line(4,28, 290, 28, $style);
                              $contador =31;
                         }
                         $cuerpo = $this->Detalle_doc_formato2($item,$tipo_documento.'-'.$oficina['SERNRO'],$doc_tipo,$comprobante['SUNFACNRO'],$comprobante['FSCFECH'],$comprobante['FSCCLIUNIC'],$comprobante['FSCCLINOMB'],$comprobante['FSCTIPDOC']."-".(($comprobante['FSCTIPDOC']==1)? ' DNI ':' RUC '),(($comprobante['FSCTIPDOC']==1)? $comprobante['FSCNRODOC']:$comprobante['FSCCLIRUC']),number_format($comprobante['FSCSUBTOTA'],2,'.',''),number_format($comprobante['FSCSUBIGV'],2,'.',''),number_format($comprobante['FSCTOTAL'],2,'.',''));
                         $pdf->writeHTMLCell(280,  0, 4, $contador,$cuerpo, 0, 1, 0, true, 'L',  true);
                         $suma_subto=$suma_subto+$comprobante['FSCSUBTOTA'];
                         $suma_igv=$suma_igv+$comprobante['FSCSUBIGV'];
                         $suma_total=$suma_total+$comprobante['FSCTOTAL'];
                         $item =$item +1;
                         $contador = $contador + 3;
                        }
                        if ($contador >= 195) {
                              $pdf->AddPage('L', 'A4');
                              $pdf->SetFont('helvetica', '', 6);
                              $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                              $pdf->Line(4,28, 290, 28, $style);
                              $contador =31;
                         }
                        $SubTotaEscribro = '<table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                              <td width="490" align="right" ><strong>TOTAL SERIE</strong></td>
                              <td width="50" align="center" ></td>
                              <td width="50" align="right" ><strong>'.$suma_subto.'</strong></td>
                              <td width="40" align="right" ><strong>'.$suma_igv.'</strong></td>
                              <td width="40" align="center" ></td>
                              <td width="40" align="right" ><strong>'.$suma_total.'</strong></td>
                             </tr>
                            </table>';
                        $pdf->writeHTMLCell(280,  0, 4, ($contador+1),$SubTotaEscribro, 0, 1, 0, true, 'L',  true);
                        $contador = $contador + 3;
                         $total_subto=$total_subto + $suma_subto;
                         $total_igv= $total_igv + $suma_igv;
                         $total_total= $total_total + $suma_total;
                }


            }

            if ($contador >= 195) {
                $pdf->AddPage('L', 'A4');
                $pdf->SetFont('helvetica', '', 6);
                $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                $pdf->Line(4,28, 290, 28, $style);
                $contador =31;
            }
            $pdf->Line(150,($contador+2), 260, ($contador+2), $style);
            $TotaEscribro = '<table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                              <td width="490" align="right" ><strong>TOTAL GENERAL</strong></td>
                              <td width="50" align="center" ></td>
                              <td width="50" align="right" ><strong>'.$total_subto.'</strong></td>
                              <td width="40" align="right" ><strong>'.$total_igv.'</strong></td>
                              <td width="40" align="center" ></td>
                              <td width="40" align="right" ><strong>'.$total_total.'</strong></td>
                             </tr>
                            </table>';
            $pdf->writeHTMLCell(280,  0, 4, ($contador+3),$TotaEscribro, 0, 1, 0, true, 'L',  true);
            $pdf->Line(150,($contador+6), 260, ($contador+6), $style);
            //$contador = $contador + 3;
            $pdf->Output('Recibo_Sedalib.pdf', 'I');

        }
        else{
            redirect($this->config->item('ip').'inicio');
        }           
    }


    public function mostrar_reporte_intervalo_diario(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $tipo = $this->input->post('tipo');
        $inicio = $this->input->post('inicio');
        $fin = $this->input->post('fin');
        $result = $this->Comprobante_pago_model->buscar_comprobante_intervalo_individual($tipo, $inicio, $fin);

        $json = array('result' => true, 'comprobante' => $result);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
    }
    public function mostrar_reporte_intervalo(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $tipo = $this->input->post('tipo');
        $inicio = $this->input->post('inicio');
        $fin = $this->input->post('fin');
        $monto = $this->input->post('monto');
        $result = $this->Comprobante_pago_model->buscar_comprobante_intervalo($tipo, $inicio, $fin, $monto);

        $json = array('result' => true, 'comprobante' => $result);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
    }
    public function imprimir_reporteDiario(){
         if($this->input->server('REQUEST_METHOD') == 'POST'){

            $array = json_decode($this->input->post('reporte'));
            $oficinas = $this->Comprobante_pago_model->obtener_oficinas($array[0]);
            for($i=0; $i<count($oficinas); $i++){
                $oficinas[$i]['COMPROBANTES'] = $this->Comprobante_pago_model->comprobante_by_intervalo2($array[0], $oficinas[$i]['SERNRO'], $array[1], $array[2]);
            }

            date_default_timezone_set('America/Lima');
            $this->load->library('pdf');
            $mpdf = $this->pdf->load('"","A4","","",5,5,5,5,0,L');
            $doc_tipo="";
            $tipo="";
            if($array[0]=="0")
            {
                $tipo="03";
                $doc_tipo=" Boleta de Ventas";
            }
            else{
                $tipo="01";
                $doc_tipo="Factura";
            }
            $html_header="<table style='width:100%;font-family:sans-serif;font-style:normal;font-size:8px ;'><tr><td style='width:60px;'><img src='". base_url()."img/sedalito.png' style='width:50px;'></td>
                <td style='width:20%; border-bottom:1px solid black;' colspan='3'><b>SEDALIB S.A,</b><br>
                <b>R.U.C.</b> 20131911310<br><b>Documento: </b> ".$doc_tipo."</td>
                <td style='text-align: center;' colspan='4'><span style='font-size: 14px;'>REGISTRO DE VENTAS</span> <br><span style='font-size: 10px;'><b>DESDE:".$array[1]." </b>  - <b>HASTA: ".$array[2]." </b></span></td><td style='width:30%; text-align: right;' colspan='2'>
                <b>Fecha: </b> ".date('d-m-Y')."<br><b>Hora: </b> ".date('h:i:s A')."<br>
                <b>Usuario: </b> ".$_SESSION['user_nom']."<br></td> </tr></table>";

            $nombres_tabla="<thead >
                            <tr style='padding: 10px; text-align: left;'><td style='width: 4%; border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'  >
                                    Itm
                                </td><td style='width: 3%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;'rowspan='2'>
                                    Ser.
                                </td><td style='width: 3%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                    Nro.
                                </td><td style='width: 5%; border-bottom:1px solid #000; border-right:1px solid #fff; text-align: center;' rowspan='2'>
                                    Fecha Emision
                                </td><td style='width: 5%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                    Fec. Vcto.
                                </td><td style='width: 4%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                    Tip
                                </td><td style='width: 5%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                 Codigo Cliente
                                </td><td style='width: 20%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                    Nombre de Cliente
                                </td><td style='width: 5%; border-bottom:1px solid #000; border-right:1px solid #fff; text-align: center;'rowspan='2'>
                                  Tip. Doc.
                                </td><td style='width: 5%; border-bottom:1px solid #000; border-right:1px solid #fff; text-align: center;' rowspan='2'>
                                 Num. Doc.
                                </td><td style='width: 5%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;'rowspan='2'>
                                 Valor de Exp.
                                </td><td style='width: 5%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;'rowspan='2'>
                                 Base Imp.Op. Grab.
                                </td><td style='width: 4%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                  I.G.V.
                                </td><td style='width: 4%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                  Otros Carg.
                                </td><td style='width: 5%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                  Total
                                </td><td style='width: 5%;border-bottom:1px solid #000; border-right:1px solid #fff;  text-align: center;' rowspan='2'>
                                  Fecha
                                </td><td style='width: 8%; text-align: center;' colspan='3'>
                                  Referencia
                                </td>

                            </tr>
                            <tr>
                                <td style=' text-align: center;border-bottom:1px solid #000; border-right:1px solid #fff; '>
                                  Tip.
                                </td>
                                <td style=' text-align: center;border-bottom:1px solid #000; border-right:1px solid #fff; '>
                                  Ser.
                                </td>
                                <td style=' text-align: center;border-bottom:1px solid #000; border-right:1px solid #fff; '>
                                  Nro.
                                </td>
                            </tr>

                            </thead>";
            $contador_plantilla=0;
            $plantilla[$contador_plantilla]="";
            $contador_lineas=0;
            $bandera=0;
            $total_subto=0;
            $total_igv=0;
            $total_total=0;
            foreach ($oficinas as $oficina) {
               $cabecera_tabla="<tr >
                    <td colspan='18' style='text-align: left;'> <strong>Serie ". $oficina['SERNRO']." Oficina asignada". $oficina['OFIDES']."</strong> </td>

                </tr>" ;
                if($contador_lineas<49 && count($oficina['COMPROBANTES'])>0 && $bandera==1 ){
                    $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla].$cabecera_tabla;
                    $contador_lineas=$contador_lineas +1;
                }
                //inicio
                if($bandera==0 && count($oficina['COMPROBANTES'])>0 ){
                    $plantilla[$contador_plantilla]="<br><br> <table style='font-style:normal;font-size:11px; margin-left:20px; '>".$nombres_tabla."<tbody>".$cabecera_tabla;
                    $contador_lineas=$contador_lineas +1;
                    $bandera=1;
                }
                if($contador_lineas>49 && count($oficina['COMPROBANTES'])>0){
                    $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."</tbody></table>";
                    $contador_plantilla=$contador_plantilla+1;
                    $plantilla[$contador_plantilla]="<br><br> <table style='font-style:normal;font-size:11px; margin-left:20px; '>".$nombres_tabla."<tbody>";
                    $contador_lineas=0;
                }
                //detalle de inicio
                if(count($oficina['COMPROBANTES'])>0){
                    $item=1;
                    $suma_subto=0;
                    $suma_igv=0;
                    $suma_total=0;
                    foreach ($oficina['COMPROBANTES'] as $comprobante){
                        if($contador_lineas<49){
                            $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla].$this->Detalle_doc($tipo,$item,$oficina['SERNRO'],$comprobante['FSCNRO'],$comprobante['FSCFECH'],$comprobante['FSCCLIUNIC'],$comprobante['FSCCLINOMB'],$comprobante['FSCTIPDOC']."-".(($comprobante['FSCTIPDOC']==1)? ' DNI ':' RUC '),(($comprobante['FSCTIPDOC']==1)? $comprobante['FSCNRODOC']:$comprobante['FSCCLIRUC']),number_format($comprobante['FSCSUBTOTA'],2,'.',''),number_format($comprobante['FSCSUBIGV'],2,'.',''),number_format($comprobante['FSCTOTAL'],2,'.',''));
                            $contador_lineas=$contador_lineas +1;
                        }
                        else{
                            $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."</tbody></table>";
                            $contador_plantilla=$contador_plantilla+1;
                            $plantilla[$contador_plantilla]="<br><br> <table style='font-style:normal;font-size:11px; margin-left:20px;'>".$nombres_tabla."<tbody>".$this->Detalle_doc($tipo,$item,$oficina['SERNRO'],$comprobante['FSCNRO'],$comprobante['FSCFECH'],$comprobante['FSCCLIUNIC'],$comprobante['FSCCLINOMB'],$comprobante['FSCTIPDOC']."-".(($comprobante['FSCTIPDOC']==1)? ' DNI ':' RUC '),(($comprobante['FSCTIPDOC']==1)? $comprobante['FSCNRODOC']:$comprobante['FSCCLIRUC']),number_format($comprobante['FSCSUBTOTA'],2,'.',''),number_format($comprobante['FSCSUBIGV'],2,'.',''),number_format($comprobante['FSCTOTAL'],2,'.',''));
                            $contador_lineas=0;
                        }
                        $suma_subto=$suma_subto+$comprobante['FSCSUBTOTA'];
                        $suma_igv=$suma_igv+$comprobante['FSCSUBIGV'];
                        $suma_total=$suma_total+$comprobante['FSCTOTAL'];
                        $item =$item +1;
                    }
                     $total_subto=$total_subto + $suma_subto;
                     $total_igv= $total_igv + $suma_igv;
                     $total_total= $total_total + $suma_total;
                     $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."<tr><td  style='text-align: right;' colspan='10'><strong>Total Serie  ".$oficina['SERNRO']."</strong> </td><td></td><td style='text-align: right;'><strong>".number_format($suma_subto,2,'.','')."</td></strong><td style='text-align: right;'><strong>".number_format($suma_igv,2,'.','')."</strong></td><td></td><td style='text-align: right;'><strong>".number_format($suma_total,2,'.','')."</strong> </td><td colspan='3'></td></tr>";
                     $contador_lineas=$contador_lineas +1;
                }





            }
            if($contador_lineas<49){
                $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."<tr><td colspan='9'></td><td colspan='2'  style=' border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;'><strong>TOTAL GENERAL </strong></td><td style='text-align: right; border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;'><strong>".number_format($total_subto,2,'.','')."</strong></td><td style='text-align: right; border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;'><strong>".number_format($total_igv,2,'.','')."</strong></td> <td style='text-align: right; border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;' colspan='2'><strong>".number_format($total_total,2,'.','')."</strong></td></tr>";
                $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."</tbody></table>";
            }
            else{
                $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."</tbody></table>";
                $contador_plantilla=$contador_plantilla+1;
                $plantilla[$contador_plantilla]="<br><br> <table style='font-style:normal;font-size:11px; margin-left:20px; '>".$nombres_tabla."<tbody>";
                 $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."<tr><td colspan='9'></td><td colspan='2'  style=' border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;'><strong>TOTAL GENERAL </strong></td><td style='text-align: right; border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;'><strong>".number_format($total_subto,2,'.','')."</strong></td><td style='text-align: right; border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;'><strong>".number_format($total_igv,2,'.','')."</strong></td> <td style='text-align: right; border-bottom:1px solid #000; border-right:1px solid #fff; border-top:1px solid #000;' colspan='2'><strong>".number_format($total_total,2,'.','')."</strong></td></tr>";
                $plantilla[$contador_plantilla]=$plantilla[$contador_plantilla]."</tbody></table>";
            }
            //var_dump($plantilla);
           unset($contador_lineas,$bandera,$total_subto,$total_igv,$total_total,$nombres_tabla,$item,$suma_subto,$suma_igv,$suma_total);
            $i=0;
                while ($i<=$contador_plantilla) {
                    $mpdf->AddPage('L');
                    $mpdf->SetHTMLHeader($html_header,'',true);
                    $mpdf->SetFooter('Pagina '.($i+1).' de '.($contador_plantilla+1));
                    $mpdf->WriteHTML($plantilla[$i]);
                    $i=$i+1;
                }
            //$mpdf->SetHTMLHeader($html_header,'O',true);


            $content = $mpdf->Output('', 'S');
            clearstatcache();
            $content = chunk_split(base64_encode($content));
            clearstatcache();
            $mpdf->Output();
            clearstatcache();
            $mpdf->close();
            clearstatcache();
            ob_flush();

            exit;
        }else{
            redirect(base_url().'inicio');
        }
    }

   

    public function imprimir_reporte2(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
 
             $array = json_decode($this->input->post('reporte'));
             $oficinas = $this->Comprobante_pago_model->obtener_oficinas($array[0]);
             for($i=0; $i<count($oficinas); $i++){
                 $oficinas[$i]['COMPROBANTES'] = $this->Comprobante_pago_model->comprobante_by_intervalo($array[0], $oficinas[$i]['SERNRO'], $array[1], $array[2], $array[3]);
             }
             $doc_tipo="";
             $Serie_doc = "";
             if($array[0]=="0")
             {
                 $doc_tipo="03";
                 $Serie_doc = "B";
             }
             else{
                 $doc_tipo="01";
                 $Serie_doc="F";
             }
             $monto="";
             if($array[3]>0){
                 $monto="<p><strong>MONTO MAYOR A ".$array[3]."</strong></p>";
             }
             $this->load->library('Reporte_sunat_tcpdf');
             // create new PDF document
             $pdf = new Reporte_sunat_tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
             $pdf ->agregar_datos( $array[1], $array[2], date('d-m-Y'), date('h:i:s A'));
             $PDF_MARGIN_BOTTOM = 0;
             $pdf->SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);
             // add a page
             $pdf->AddPage('L', 'A4');
             $cab = '<table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                       <td width="15" align="center" rowspan="2">Itm</td>
                       <td width="20" rowspan="2" > Ser. </td>
                       <td width="20" align="center" rowspan="2">Nro.</td>
                       <td width="50" align="center" rowspan="2">Fecha Emision</td>
                       <td width="45" align="center" rowspan="2">Fec. Vcto.</td>
                       <td width="15" align="center" rowspan="2">Tip</td>
                       <td width="50" align="center" rowspan="2">Codigo Cliente</td>
                       <td width="190" align="center" rowspan="2">Nombre de Cliente</td>
                       <td width="30" align="center" rowspan="2">Tip. Doc.</td>
                       <td width="50" align="center" rowspan="2">Num. Doc.</td>
                       <td width="20" align="center" rowspan="2">Valor de Exp.</td>
                       <td width="50" align="center" rowspan="2">Base Imp. Op. Grab.</td>
                       <td width="45" align="center" rowspan="2">Imp. Op. Exon o Inaf</td>
                       <td width="10" align="center" rowspan="2">I.S.C.</td>
                       <td width="40" align="right" rowspan="2">I.G.V.</td>
                       <td width="20" align="right" rowspan="2">Otros Carg.</td>
                       <td width="40" align="center" rowspan="2">Total</td>
                       <td width="15" align="center" rowspan="2">T.C.</td>
                       <td width="85" align="center" colspan="4">Referencia</td>
                      </tr>
                      <tr>
                        <td width="20" align="center" >Fecha</td>
                        <td width="15" align="center">Tip.</td>
                        <td width="20" align="center">Ser.</td>
                        <td width="20" align="center">Nro.</td>
                      </tr>
 
                     </table>';
             //cabecera 
             $pdf->SetFont('helvetica', '', 6);
             $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
             $style = array('width' => 0.2, 'cap' =>'butt','join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
             $pdf->Line(4,31, 290, 31, $style);
             $contador = 31;
             $total_subto=0;
             $total_inaf_exo = 0;
             $total_igv=0;
             $total_total=0;
             $subTotal_hoja =0;
             $subtotal_inaf_exo =0;
             $igv_hoja =0;
             $total_hoja =0;
             foreach ($oficinas as $oficina) {
                if ($contador >= 190){
                   $EscribroHoja = '<table border="0" cellpadding="0" cellspacing="0">
                                     <tr>
                                     <td width="485" align="right" ><strong>TOTAL HOJA</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="50" align="right" ><strong>'.number_format($subTotal_hoja,2,'.','').'</strong></td>
                                     <td width="45" align="right" ><strong>'.number_format($subtotal_inaf_exo,2,'.','').'</strong></td>
                                     <td width="10" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($igv_hoja,2,'.','').'</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($total_hoja,2,'.','').'</strong></td>
                                     </tr>
                                     </table>';
                   $pdf->writeHTMLCell(280,  0, 4, 196,$EscribroHoja, 0, 1, 0, true, 'L',  true);
                   $subTotal_hoja =0;
                   $subtotal_inaf_exo =0;
                   $igv_hoja =0;
                   $total_hoja =0;
                   $pdf->AddPage('L', 'A4');
                   $pdf->SetFont('helvetica', '', 6);
                   $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                   $pdf->Line(4,31, 290, 31, $style);
                   $contador =31;
                 }
                 //detalle de inicio
                 if(count($oficina['COMPROBANTES'])>0){
                     $item=1;
                     $suma_subto=0;
                     $suma_inaf_exonerado = 0;
                     $suma_igv=0;
                     $suma_total=0;
                     $pdf->writeHTMLCell(280,  0, 4, $contador,"<p><strong>Serie ". $oficina['SERNRO']." Oficina asignada ". $oficina['OFIDES']."</strong></p>", 0, 1, 0, true, 'L',  true);
                     $contador = $contador + 3;
                     foreach ($oficina['COMPROBANTES'] as $comprobante){
                          if ($contador >= 190) {
                               $EscribroHoja = '<table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                     <td width="485" align="right" ><strong>TOTAL HOJA</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="50" align="right" ><strong>'.number_format($subTotal_hoja,2,'.','').'</strong></td>
                                     <td width="45" align="right" ><strong>'.number_format($subtotal_inaf_exo,2,'.','').'</strong></td>
                                     <td width="10" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($igv_hoja,2,'.','').'</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($total_hoja,2,'.','').'</strong></td>
                                    </tr>
                                   </table>';
                               $pdf->writeHTMLCell(280,  0, 4, 196,$EscribroHoja, 0, 1, 0, true, 'L',  true);
                               $subTotal_hoja =0;
                               $subtotal_inaf_exo =0;
                               $igv_hoja =0;
                               $total_hoja =0;
                               $pdf->AddPage('L', 'A4');
                               $pdf->SetFont('helvetica', '', 6);
                               $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                               $pdf->Line(4,31, 290, 31, $style);
                               $contador =31;
                          }
                          $cuerpo = $this->Detalle_doc_formato3($item,($Serie_doc.$oficina['SERNRO']),$doc_tipo,$comprobante['SUNFACNRO'],$comprobante['FSCFECH'],$comprobante['FSCCLIUNIC'],$comprobante['FSCCLINOMB'],$comprobante['FSCTIPDOC']."-".(($comprobante['FSCTIPDOC']==1)? ' DNI ':' RUC '),(($comprobante['FSCTIPDOC']==1)? $comprobante['FSCNRODOC']:$comprobante['FSCCLIRUC']),number_format($comprobante['FSCSUBTOTA'],2,'.',''),number_format($comprobante['FSCSUBIGV'],2,'.',''),number_format($comprobante['FSCTOTAL'],2,'.',''), number_format($comprobante['TOT_EXONERADO'],2,'.',''), number_format($comprobante['TOT_INAFECTO'],2,'.',''),number_format($comprobante['TOT_GRATUITO'],2,'.',''),number_format($comprobante['TOT_GRABADO'],2,'.',''));
                          $pdf->writeHTMLCell(280,  0, 4, $contador,$cuerpo, 0, 1, 0, true, 'L',  true);
                          if($comprobante['FSCESTADO']==1){
                            if( $comprobante['CONCEPT_GRATUITO']==1 ){
                                if($comprobante['TOT_GRABADO']> 0 ){
                                    $suma_subto= $suma_subto+$comprobante['FSCSUBTOTA'];
                                    $subTotal_hoja = $subTotal_hoja + $comprobante['FSCSUBTOTA'];
                                }else {
                                    $suma_inaf_exonerado = $suma_inaf_exonerado + $comprobante['FSCSUBTOTA'];
                                    $subtotal_inaf_exo = $subtotal_inaf_exo + $comprobante['FSCSUBTOTA'];
                                }
                                
                                
                            }else{
                                $suma_subto=$suma_subto+$comprobante['FSCSUBTOTA'];
                                $subTotal_hoja = $subTotal_hoja + $comprobante['FSCSUBTOTA'];
                            }
                            $suma_igv=$suma_igv+$comprobante['FSCSUBIGV'];
                            $suma_total=$suma_total+$comprobante['FSCTOTAL'];
                            $igv_hoja = $igv_hoja + $comprobante['FSCSUBIGV'];
                            $total_hoja =  $total_hoja + $comprobante['FSCTOTAL'] ;
                          }
 
                          $item =$item +1;
                          $contador = $contador + 3;
                    }
                         if ($contador >= 190) {
                               $EscribroHoja = '<table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                     <td width="485" align="right" ><strong>TOTAL HOJA</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="50" align="right" ><strong>'.number_format($subTotal_hoja,2,'.','').'</strong></td>
                                     <td width="45" align="right" ><strong>'.number_format($subtotal_inaf_exo,2,'.','').'</strong></td>
                                     <td width="10" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($igv_hoja,2,'.','').'</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($total_hoja,2,'.','').'</strong></td>
                                    </tr>
                                   </table>';
                               $pdf->writeHTMLCell(280,  0, 4, 196,$EscribroHoja, 0, 1, 0, true, 'L',  true);
                               $subTotal_hoja =0;
                               $subtotal_inaf_exo =0;
                               $igv_hoja =0;
                               $total_hoja =0;
                               $pdf->AddPage('L', 'A4');
                               $pdf->SetFont('helvetica', '', 6);
                               $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                               $pdf->Line(4,31, 290, 31, $style);
                               $contador =31;
                          }
                         $SubTotaEscribro = '<table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                               <td width="485" align="right" ><strong>TOTAL SERIE</strong></td>
                               <td width="20" align="center" ></td>
                               <td width="50" align="right" ><strong>'.number_format($suma_subto,2,'.','').'</strong></td>
                               <td width="45" align="right" ><strong>'.number_format($suma_inaf_exonerado,2,'.','').'</strong></td>
                               <td width="10" align="center" ></td>
                               <td width="40" align="right" ><strong>'.number_format($suma_igv,2,'.','').'</strong></td>
                               <td width="20" align="center" ></td>
                               <td width="40" align="right" ><strong>'.number_format($suma_total,2,'.','').'</strong></td>
                              </tr>
                             </table>';
                         $pdf->writeHTMLCell(280,  0, 4, ($contador+1),$SubTotaEscribro, 0, 1, 0, true, 'L',  true);
                         $contador = $contador + 3;
                         $total_subto=$total_subto + $suma_subto;
                         $total_inaf_exo = $total_inaf_exo + $suma_inaf_exonerado;
                         $total_igv= $total_igv + $suma_igv;
                         $total_total= $total_total + $suma_total;
                 }
 
 
             }
 
             if ($contador >= 190) {
                 $EscribroHoja = '<table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                     <td width="485" align="right" ><strong>TOTAL HOJA</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="50" align="right" ><strong>'.number_format($subTotal_hoja,2,'.','').'</strong></td>
                                     <td width="45" align="right" ><strong>'.number_format($subtotal_inaf_exo,2,'.','').'</strong></td>
                                     <td width="10" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($igv_hoja,2,'.','').'</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($total_hoja,2,'.','').'</strong></td>
                                    </tr>
                                   </table>';
                 $pdf->writeHTMLCell(280,  0, 4, 196,$EscribroHoja, 0, 1, 0, true, 'L',  true);
                 $subTotal_hoja =0;
                 $subtotal_inaf_exo = 0;
                 $igv_hoja =0;
                 $total_hoja =0;
                 $pdf->AddPage('L', 'A4');
                 $pdf->SetFont('helvetica', '', 6);
                 $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                 $pdf->Line(4,31, 290, 31, $style);
                 $contador =31;
             }
             $EscribroHoja = '<table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                     <td width="485" align="right" ><strong>TOTAL HOJA</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="50" align="right" ><strong>'.number_format($subTotal_hoja,2,'.','').'</strong></td>
                                     <td width="45" align="right" ><strong>'.number_format($subtotal_inaf_exo,2,'.','').'</strong></td>
                                     <td width="10" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($igv_hoja,2,'.','').'</strong></td>
                                     <td width="20" align="center" ></td>
                                     <td width="40" align="right" ><strong>'.number_format($total_hoja,2,'.','').'</strong></td>
                                    </tr>
                                   </table>';
             $pdf->writeHTMLCell(280,  0, 4, 196,$EscribroHoja, 0, 1, 0, true, 'L',  true);
             $pdf->Line(150,($contador+2), 260, ($contador+2), $style);
             $TotaEscribro = '<table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                               <td width="485" align="right" ><strong>TOTAL GENERAL</strong></td>
                               <td width="20" align="center" ></td>
                               <td width="50" align="right" ><strong>'.number_format($total_subto,2,'.','').'</strong></td>
                               <td width="45" align="right" ><strong>'.number_format($total_inaf_exo,2,'.','').'</strong></td>
                               <td width="10" align="center" ></td>
                               <td width="40" align="right" ><strong>'.number_format($total_igv,2,'.','').'</strong></td>
                               <td width="20" align="center" ></td>
                               <td width="40" align="right" ><strong>'.number_format($total_total,2,'.','').'</strong></td>
                              </tr>
                             </table>';
             $pdf->writeHTMLCell(280,  0, 4, ($contador+3),$TotaEscribro, 0, 1, 0, true, 'L',  true);
             $pdf->Line(150,($contador+6), 260, ($contador+6), $style);
             //$contador = $contador + 3;
             $pdf->Output('Recibo_Sedalib.pdf', 'I');
 
         }
         else{
             redirect(base_url().'inicio');
         } 
    }
 

    public function imprimir_reporte1(){

        if($this->input->server('REQUEST_METHOD') == 'POST'){

            $array = json_decode($this->input->post('reporte'));
            $tipo_doc = "";
            if ($array [0] =="0") {
                $serie = $this->Catalogo_model->get_serie($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD'], $_SESSION['user_data']['NSARECOD'], 2); //boleta
                $doc_tipo="03";
                $tipo_doc = "B";
            }else{
                $serie = $this->Catalogo_model->get_serie($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD'], $_SESSION['user_data']['NSARECOD'], 1); //factura
                $doc_tipo="01";
                $tipo_doc = "F";
            }
            $oficinas[0]['COMPROBANTES'] = $this->Comprobante_pago_model->comprobante_by_intervalo($array[0],  $serie["SERNRO"], $array[1], $array[2], $array[3]);

            $this->load->library('Reporte_antiguo_tcpdf');
            // create new PDF document
            $pdf = new Reporte_antiguo_tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf ->agregar_datos($array[1],$array[2],date('d-m-Y'),date('h:i:s A'),$_SESSION['user_nom']);
            $PDF_MARGIN_BOTTOM = 0;
            $pdf->SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);

            // add a page
            $pdf->AddPage('L', 'A4');
            $cab = '<table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                      <td width="15" align="center" rowspan="2">Itm</td>
                      <td width="20" rowspan="2" > Ser. </td>
                      <td width="20" align="center" rowspan="2">Nro.</td>
                      <td width="50" align="center" rowspan="2">Fecha Emision</td>
                      <td width="50" align="center" rowspan="2">Fec. Vcto.</td>
                      <td width="15" align="center" rowspan="2">Tip</td>
                      <td width="50" align="center" rowspan="2">Codigo Cliente</td>
                      <td width="190" align="center" rowspan="2">Nombre de Cliente</td>
                      <td width="30" align="center" rowspan="2">Tip. Doc.</td>
                      <td width="50" align="center" rowspan="2">Num. Doc.</td>
                      <td width="50" align="center" rowspan="2">Valor de Exp.</td>
                      <td width="50" align="center" rowspan="2">Base Imp. Op. Grab.</td>
                      <td width="40" align="center" rowspan="2">I.G.V.</td>
                      <td width="40" align="center" rowspan="2">Otros Carg.</td>
                      <td width="40" align="center" rowspan="2">Total</td>
                      <td width="40" align="center" rowspan="2">Fecha</td>
                      <td width="60" align="center" colspan="3">Referencia</td>
                     </tr>
                     <tr>
                       <td width="20" align="center">Tip.</td>
                       <td width="20" align="center">Ser.</td>
                       <td width="20" align="center">Nro.</td>
                     </tr>

                    </table>';
            //cabecera 
            $pdf->SetFont('helvetica', '', 6);
            $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
            $style = array('width' => 0.2, 'cap' =>'butt','join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $pdf->Line(4,28, 290, 28, $style);
            $contador = 31;
            $total_subto=0;
            $total_igv=0;
            $total_total=0;
            foreach ($oficinas as $oficina) {
               if ($contador >= 195) {
                  $pdf->AddPage('L', 'A4');
                  $pdf->SetFont('helvetica', '', 6);
                  $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                  $pdf->Line(4,28, 290, 28, $style);
                  $contador =31;
                }
                //detalle de inicio
                if(count($oficina['COMPROBANTES'])>0){
                    $item=1;
                    $suma_subto=0;
                    $suma_igv=0;
                    $suma_total=0;
                    $pdf->writeHTMLCell(280,  0, 4, $contador,"<p><strong>".$_SESSION['OFICINA']."</strong></p>", 0, 1, 0, true, 'L',  true);
                    $contador = $contador + 3;
                    foreach ($oficina['COMPROBANTES'] as $comprobante){
                         if ($contador >= 195) {
                              $pdf->AddPage('L', 'A4');
                              $pdf->SetFont('helvetica', '', 6);
                              $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                              $pdf->Line(4,28, 290, 28, $style);
                              $contador =31;
                         }
                         $cuerpo = $this->Detalle_doc_formato2($item,$tipo_doc.'-'.trim($serie["SERNRO"]),$doc_tipo,trim($comprobante['SUNFACNRO']),trim($comprobante['FSCFECH']),trim($comprobante['FSCCLIUNIC']),trim($comprobante['FSCCLINOMB']),$comprobante['FSCTIPDOC']."-".(($comprobante['FSCTIPDOC']==1)? ' DNI ':' RUC '),(($comprobante['FSCTIPDOC']==1)? $comprobante['FSCNRODOC']:$comprobante['FSCCLIRUC']),number_format($comprobante['FSCSUBTOTA'],2,'.',''),number_format($comprobante['FSCSUBIGV'],2,'.',''),number_format($comprobante['FSCTOTAL'],2,'.',''));
                         $pdf->writeHTMLCell(280,  0, 4, $contador,$cuerpo, 0, 1, 0, true, 'L',  true);
                         $suma_subto=$suma_subto+$comprobante['FSCSUBTOTA'];
                         $suma_igv=$suma_igv+$comprobante['FSCSUBIGV'];
                         $suma_total=$suma_total+$comprobante['FSCTOTAL'];
                         $item =$item +1;
                         $contador = $contador + 3;

                        }
                    if ($contador >= 195) {
                      $pdf->AddPage('L', 'A4');
                      $pdf->SetFont('helvetica', '', 6);
                      $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                      $pdf->Line(4,28, 290, 28, $style);
                      $contador =31;
                    }
                    $Cuerpo_Subtotal = '<table border="0" cellpadding="0" cellspacing="0">
                                 <tr>
                                  <td width="490" align="right" ><strong>Total Serie '.$serie["SERNRO"].'</strong></td>
                                  <td width="50" align="center" ></td>
                                  <td width="50" align="rigth" ><strong>'.number_format($suma_subto,2,'.','').'</strong></td>
                                  <td width="40" align="rigth" ><strong>'.number_format($suma_igv,2,'.','').'</strong></td>
                                  <td width="40" align="center" ></td>
                                  <td width="40" align="rigth"><strong>'.number_format($suma_total,2,'.','').'</strong></td>
                                  <td width="40" align="center" ></td>
                                  <td width="60" align="center" ></td>
                                 </tr>
                                </table>';
                     $pdf->writeHTMLCell(280,  0, 4, $contador,$Cuerpo_Subtotal , 0, 1, 0, true, 'L',  true);  
                     $contador = $contador + 3;  
                        $total_subto=$total_subto + $suma_subto;
                        $total_igv= $total_igv + $suma_igv;
                        $total_total= $total_total + $suma_total;
                         
                        
                }
            }
            if ($contador >= 195) {
                $pdf->AddPage('L', 'A4');
                $pdf->SetFont('helvetica', '', 6);
                $pdf->writeHTMLCell(280,  0, 4, 22,$cab, 0, 1, 0, true, 'L',  true);
                $pdf->Line(4,28, 290, 28, $style);
                $contador =31;
            }else{
                $contador = $contador + 3;
            }
            $pdf->Line(150,($contador-1), 260, ($contador-1), $style);
            $Cuerpo_total = '<table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="490" align="right" ><strong>TOTAL GENERAL </strong></td>
                        <td width="50" align="center" ></td>
                        <td width="50" align="rigth" ><strong>'.number_format($total_subto,2,'.','').'</strong></td>
                        <td width="40" align="rigth" ><strong>'.number_format($total_igv,2,'.','').'</strong></td>
                        <td width="40" align="center" ></td>
                        <td width="40" align="rigth"><strong>'.number_format($total_total,2,'.','').'</strong></td>
                        <td width="40" align="center" ></td>
                        <td width="60" align="center" ></td>
                    </tr>
            </table>';
            $pdf->writeHTMLCell(280,  0, 4, $contador,$Cuerpo_total , 0, 1, 0, true, 'L',  true);
            $pdf->Line(150,($contador+3), 260, ($contador+3), $style);
            $pdf->Output('Recibo_Sedalib.pdf', 'I');

        }
        else{
            redirect($this->config->item('ip').'inicio');
        }
        
    }
    private function Detalle_doc($tipo,$item,$serie_ofi,$nro_ofi,$fecha_emi,$cod_cli,$nom_cli,$tip_doc,$nro_doc,$subtotal,$igv,$total){
        $cadena="  <tr ><td>".$item."</td><td>".$serie_ofi."</td><td>".$nro_ofi."</td><td>".$fecha_emi."</td><td></td><td> ".$tipo."</td><td>".$cod_cli."</td><td style='font-style:normal;font-size:7.5px ;'>
            "."CLIENTES VARIOS - ".$nom_cli."</td><td>".$tip_doc."</td><td>".$nro_doc."</td><td></td>
            <td style='text-align: right;'>".$subtotal."</td><td style='text-align: right;'>".$igv."</td>
            <td></td><td style='text-align: right;'>  ".$total."</td><td style='text-align: right;'>
            </td><td style='text-align: right;'></td><td style='text-align: right;'> </td><td style='text-align: right;'></td>
                            </tr>";
        return  $cadena;
    }

   

    private function Detalle_doc_formato2($item,$serie_ofi,$doc_tipo,$nro_ofi,$fecha_emi,$cod_cli,$nom_cli,$tip_doc,$nro_doc,$subtotal,$igv,$total){
        
        $cuerpo = '<table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                      <td width="15" align="center" rowspan="2">'.$item.'</td>
                      <td width="20"  >'.$serie_ofi.'</td>
                      <td width="20" align="center" >'.$nro_ofi.'</td>
                      <td width="50" align="center" >'.$fecha_emi.'</td>
                      <td width="50" align="center" ></td>
                      <td width="15" align="center" >'.$doc_tipo.'</td>
                      <td width="50" align="center" >'.$cod_cli.'</td>
                      <td width="190" align="left" >'.substr($nom_cli, 0, 50).'</td>
                      <td width="30" align="center" >'.$tip_doc.'</td>
                      <td width="50" align="center" >'.$nro_doc.'</td>
                      <td width="50" align="center" ></td>
                      <td width="50" align="rigth" >'.$subtotal.'</td>
                      <td width="40" align="rigth" >'.$igv.'</td>
                      <td width="40" align="center" ></td>
                      <td width="40" align="rigth" >'.$total.'</td>
                      <td width="40" align="center" ></td>
                      <td width="20" align="center" ></td>
                      <td width="20" align="center" ></td>
                      <td width="20" align="center" ></td>
                     </tr>
                    </table>
                    ';
        return $cuerpo ;
    }
    private function Detalle_doc_formato3($item,$serie_ofi,$doc_tipo,$nro_ofi,$fecha_emi,$cod_cli,$nom_cli,$tip_doc,$nro_doc,$subtotal,$igv,$total, $tot_exonerado,$tot_inafecto,$tot_gratuito,$tot_gravado){


        $cuerpo = '<table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                      <td width="15" align="center" >'.$item.'</td>
                      <td width="20"  > '.$serie_ofi.' </td>
                      <td width="20" align="center" >'.$nro_ofi.'</td>
                      <td width="50" align="center" >'.$fecha_emi.'</td>
                      <td width="45" align="center" ></td>
                      <td width="15" align="center" >'.$doc_tipo.'</td>
                      <td width="50" align="center" >'.$cod_cli.'</td>
                      <td width="190" align="left" >'.substr($nom_cli, 0, 50).'</td>
                      <td width="30" align="center" >'.$tip_doc.'</td>
                      <td width="50" align="center" >'.$nro_doc.'</td>
                      <td width="20" align="center" ></td>
                      <td width="50" align="rigth" >'.(($tot_exonerado != 0 || $tot_inafecto!=0 || $tot_gratuito!=0 ) ? '' : $subtotal).'</td>
                      <td width="45" align="rigth" >'.(($tot_exonerado != 0 || $tot_inafecto!=0 || $tot_gratuito!=0 ) ? $subtotal: '').'</td>
                      <td width="10" align="center" ></td>
                      <td width="40" align="rigth" >'.$igv.'</td>
                      <td width="20" align="center" ></td>
                      <td width="40" align="rigth" >'.$total.'</td>
                      <td width="15" align="center" ></td>
                      <td width="85" align="center" ></td>
                     </tr>
                    </table>
                    ';
                      
        return $cuerpo ;
    }



    public function masivos_inicial(){
        $this->load->model('mail/Mail_model');
        $ciclos = $this->Mail_model->get_ciclos();
        $this->data['Ciclos'] = $ciclos;
        $this->data['proceso'] = 'RECIBOS MASIVOS ';
        $this->data['menu']['padre'] = 'comprobantes';
        $this->data['menu']['hijo'] = 'COPIA_RECIBO';
        $this->data['view'] = 'boleta_factura/recibo_masivo_view';
        $this->data['breadcrumbs'] = array(array('Masivos', ''));
        $this->load->view('template/Master', $this->data);
    }

    public function masivos_rango(){
        $ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
       
        $ciclo = $this->input->post('ciclo_fac');
        $periodo = $this->input->post('periodo_fac');
        $this->load->model('facturacion/Datos_recibo_model');
        $recibos = $this->Datos_recibo_model->get_recibo_rango($ciclo, $periodo);
        $cantidad = (int)$recibos[0]['CANTIDAD']; 
        $rango_recibos = 1000;
        if($cantidad>0){
            $cantidad_registros = array();
            $desde_hasta = '';
           if($cantidad < $rango_recibos){
               $unico  = $this->Datos_recibo_model->get_recibo_rango_varios($ciclo, $periodo, 1, $cantidad);
               $desde_hasta = '1-'.$cantidad;
               $unico[0]['DESDE_HASTA'] = $desde_hasta;
               $cantidad_registros[0] = $unico;
           }else{
               $numero_registros =(int)($cantidad/$rango_recibos);
               $i =0;
               $desde = 1;
               $hasta = $rango_recibos;
               while($i < $numero_registros){
                    $unico  = $this->Datos_recibo_model->get_recibo_rango_varios($ciclo, $periodo, $desde, $hasta);
                    $desde_hasta = $desde.'-'.$hasta;
                    $unico[0]['DESDE_HASTA'] = $desde_hasta;
                    $desde = $hasta +1 ;
                    $hasta = $hasta + $rango_recibos;
                    $cantidad_registros[$i] = $unico;
                    $i++;
               }
               $residuo =$cantidad % $rango_recibos;
               if($residuo>0){
                    $unico  = $this->Datos_recibo_model->get_recibo_rango_varios($ciclo, $periodo, $desde, (($desde-1)+ $residuo ));
                    $desde_hasta = $desde.'-'.(($desde-1)+ $residuo);
                    $unico[0]['DESDE_HASTA'] = $desde_hasta;
                    $cantidad_registros[$i] = $unico;
               }
           }
          header("Content-type:application/json"); 
          $json = array('result' => true ,'cantidad' => $cantidad,'ciclo' => $ciclo ,'periodo' => $periodo, 'respuesta' => $cantidad_registros );
          echo json_encode($json);   
        }
    }

    public function obtengo_recibos_rango($periodo, $ciclo, $rango_facturacion, $fondo){
        
        ini_set('memory_limit','5840M');
        ini_set('max_execution_time', 2000);
        $this->load->model('facturacion/Datos_recibo_model');
        $this->load->library('lib_tcpdf');
        $pdf = $this->lib_tcpdf->cargar();//cargo el dompdf   
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // set default monospaced fon
        // add a page
        $pdf->AddPage('L', 'A4');
        $pdf->SetAutoPageBreak(false, 0);
        $i = 0;
        $contador=0;
        $bandera = false;
        $nombre_grafi_barra = "";
        $rango_separado =  explode("_", $rango_facturacion);
        $recibos = $this->Datos_recibo_model->get_rangos2($periodo, $ciclo, $rango_separado);
        while($i < count($recibos)){
            $cabecera[0] =array_slice($recibos[$i], 8, 87);
            $dato_bandera = false;
            $cantidad = 0;
            $dato_detalle = array();
            $k = 0;
            while($dato_bandera == false){
                if($k == 0){
                    $dato_detalle[$k] =  array_slice($recibos[$i + $k], 0, 8);
                    //unset($recibos[$i + $k]); 
                }else{
                    if (isset($recibos[$i + $k])){
                        if($recibos[$i + $k]['FACLINRO'] == '1'){
                            $dato_bandera = true;
                        }else{
                            $dato_detalle[$k] = array_slice($recibos[$i + $k], 0, 8);
                            //unset($recibos[$i + $k]); 
                        }
                    }else{
                        $dato_bandera = true;
                    }
                }
                
                $cantidad++;
                $k++;
            }
            $nombre_codi_barra = 'CODI_BARRA'.$periodo.$ciclo.trim($cabecera[0]['CLICODFAX']).$_SESSION['login'].date("d-m-Y");
            if(trim($cabecera[0]['FMEDIDOR']) != ""){
                $nombre_grafi_barra = $this->creo_grafico_barras_rango($cabecera[0]['CLICODFAX'],$cabecera[0]['CON01'],$cabecera[0]['CON02'],$cabecera[0]['CON03'],$cabecera[0]['CON04'],$cabecera[0]['CON05'],$cabecera[0]['CON06'],$cabecera[0]['CON07'],$cabecera[0]['CON08'],$cabecera[0]['CON09'], $cabecera[0]['CON10'],$cabecera[0]['CON11'],$cabecera[0]['CON12'],$cabecera[0]['CON13'],$cabecera[0]['MES01'],$cabecera[0]['MES02'],$cabecera[0]['MES03'],$cabecera[0]['MES04'],$cabecera[0]['MES05'],$cabecera[0]['MES06'],$cabecera[0]['MES07'],$cabecera[0]['MES08'],$cabecera[0]['MES09'],$cabecera[0]['MES10'],$cabecera[0]['MES11'],$cabecera[0]['MES12'],$cabecera[0]['MES13']);
                clearstatcache();
                //$nombre_grafi_barra = $periodo.$ciclo.trim($cabecera[0]['CLICODFAX']).$_SESSION['login'].date("d-m-Y");
            }
            if($contador == 0){
                $distancia = 0;
                $bandera = false;
                $pdf = $this->lib_tcpdf->cargo_plantilla_doble1($pdf,$cabecera[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $fondo,1);
            }
            if($contador == 1){
                $distancia = 150;
                $bandera = true;
                $contador = 0 ;
                $pdf = $this->lib_tcpdf->cargo_plantilla_doble1($pdf,$cabecera[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $fondo,1);
                
                if( ( $i + ($cantidad-1) ) < count($recibos) ){
                    $pdf->AddPage('L', 'A4');
                }
                
                /*if( $i  < count($recibos) ){
                    $pdf->AddPage('L', 'A4');
                }*/
            }
            if($bandera ==false){
                $contador = $contador+1;
            }
            //$recibos = array_values($recibos);
            $i = $i + ($cantidad -1);
        }

        $files = glob('assets/recibo/*'); // obtiene todos los archivos
        foreach($files as $file){
            if(is_file($file)) // si se trata de un archivo
                unlink($file); // lo elimina
        }
        $pdf->Output('Masivo_recibo.pdf', 'I');
              
    }

    public function suministro_rango_recibo(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            
            $suministro = $this->input->post('suministro_fac');
            $periodo_inicio = $this->input->post('peri_inicio');
            $periodo_fin = $this->input->post('peri_fin');
            $this->load->model('facturacion/Datos_recibo_model');
            $obtengo_recibo_rangos =  $this->Datos_recibo_model->get_rango_recibo_unico($suministro, $periodo_inicio, $periodo_fin);
            header("Content-type:application/json"); 
            $json = array('result' => true, 'datos' => $obtengo_recibo_rangos );
            echo json_encode($json); 
        }
    }

    public function generando_suministro_rango_recibo(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('detalle_rango_recibo'),true);
            $datos = $array[0]; 
            $fondo = $array[1];
            $this->load->library('lib_tcpdf');
            $pdf = $this->lib_tcpdf->cargar();//cargo el dompdf   
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // add a page
            $pdf->AddPage('L', 'A4');
            $pdf->SetAutoPageBreak(false, 0);
            $this->load->model('facturacion/Datos_recibo_model');
            $i = 0;
            $nombre_codi_barra = '';
            $nombre_grafi_barra = '';
            $contador=0;
            $bandera = false;
            while($i < $datos['length'] ){
                $recibos = $this->Datos_recibo_model->get_recibo_ser_nro($datos[$i][4],$datos[$i][5]);
                $nombre_codi_barra = $this->creo_codi_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CODIGO_BARRA']);//'CODI_BARRA'.$periodo.$ciclo.trim($recibos[0]['CLICODFAX']).$_SESSION['login'].date("d-m-Y");
                if(trim($recibos[0]['FMEDIDOR']) != ""){
                    $nombre_grafi_barra = $this->creo_grafico_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CON01'],$recibos[0]['CON02'],$recibos[0]['CON03'],$recibos[0]['CON04'],$recibos[0]['CON05'],$recibos[0]['CON06'],$recibos[0]['CON07'],$recibos[0]['CON08'],$recibos[0]['CON09'], $recibos[0]['CON10'],$recibos[0]['CON11'],$recibos[0]['CON12'],$recibos[0]['CON13'],$recibos[0]['MES01'],$recibos[0]['MES02'],$recibos[0]['MES03'],$recibos[0]['MES04'],$recibos[0]['MES05'],$recibos[0]['MES06'],$recibos[0]['MES07'],$recibos[0]['MES08'],$recibos[0]['MES09'],$recibos[0]['MES10'],$recibos[0]['MES11'],$recibos[0]['MES12'],$recibos[0]['MES13']);
                }else{
                    if($recibos[0]['CONSUMO'] != 0  &&  $recibos[0]['LECACT'] != 0 && $recibos[0]['LECANT'] != 0 ){
                        $nombre_grafi_barra = $this->creo_grafico_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CON01'],$recibos[0]['CON02'],$recibos[0]['CON03'],$recibos[0]['CON04'],$recibos[0]['CON05'],$recibos[0]['CON06'],$recibos[0]['CON07'],$recibos[0]['CON08'],$recibos[0]['CON09'], $recibos[0]['CON10'],$recibos[0]['CON11'],$recibos[0]['CON12'],$recibos[0]['CON13'],$recibos[0]['MES01'],$recibos[0]['MES02'],$recibos[0]['MES03'],$recibos[0]['MES04'],$recibos[0]['MES05'],$recibos[0]['MES06'],$recibos[0]['MES07'],$recibos[0]['MES08'],$recibos[0]['MES09'],$recibos[0]['MES10'],$recibos[0]['MES11'],$recibos[0]['MES12'],$recibos[0]['MES13']);
                    }
                }
                $dato_detalle=$this->Datos_recibo_model->get_dato_detalle( $recibos[0]['FACNRO'], $recibos[0]['FACSERNRO']);
                if($contador == 0){
                    $distancia = 0;
                    $bandera = false ;
                    $pdf = $this ->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $fondo,1);
                }
                if($contador == 1){
                    $distancia = 150;
                    $bandera = true;
                    $contador = 0 ;
                    $pdf = $this->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $fondo,1);
                    if(($i+1)< $datos['length'] ){
                        $pdf->AddPage('L', 'A4');
                    }
                }
                if($bandera ==false){
                    $contador = $contador+1;
                }
                $i++;
            }
            $pdf->Output('Masivo_recibo.pdf', 'I');

        }
    }


    public function imprimir_recibo_individual(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('recibo_individual'),true);
            $this->load->library('lib_tcpdf');
            $pdf = $this->lib_tcpdf->cargar();//cargo el dompdf   
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $this->load->model('facturacion/Datos_recibo_model');
            if($array[0]== 5){
                $pdf->AddPage('P', 'A5');
                $pdf->SetAutoPageBreak(false, 0);
                $recibos = $this->Datos_recibo_model->get_recibo_ser_nro($array[1],$array[2]);
                if(count($recibos)>0){
                    $nombre_codi_barra = $this->creo_codi_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CODIGO_BARRA']);//'CODI_BARRA'.$periodo.$ciclo.trim($recibos[0]['CLICODFAX']).$_SESSION['login'].date("d-m-Y");
                    if(trim($recibos[0]['FMEDIDOR']) != ""){
                        $nombre_grafi_barra = $this->creo_grafico_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CON01'],$recibos[0]['CON02'],$recibos[0]['CON03'],$recibos[0]['CON04'],$recibos[0]['CON05'],$recibos[0]['CON06'],$recibos[0]['CON07'],$recibos[0]['CON08'],$recibos[0]['CON09'], $recibos[0]['CON10'],$recibos[0]['CON11'],$recibos[0]['CON12'],$recibos[0]['CON13'],$recibos[0]['MES01'],$recibos[0]['MES02'],$recibos[0]['MES03'],$recibos[0]['MES04'],$recibos[0]['MES05'],$recibos[0]['MES06'],$recibos[0]['MES07'],$recibos[0]['MES08'],$recibos[0]['MES09'],$recibos[0]['MES10'],$recibos[0]['MES11'],$recibos[0]['MES12'],$recibos[0]['MES13']);
                    }
                    $dato_detalle=$this->Datos_recibo_model->get_dato_detalle( $recibos[0]['FACNRO'], $recibos[0]['FACSERNRO']);
                    $distancia = 0;
                    $pdf = $this ->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $array[3],1);
                    $pdf->Output('Recibo_individual_A5.pdf', 'I');
                }
            }else{
                $pdf->AddPage('L', 'A4');
                $pdf->SetAutoPageBreak(false, 0);
                $recibos = $this->Datos_recibo_model->get_recibo_ser_nro($array[1],$array[2]);
                if( count($recibos)>0){
                    $nombre_codi_barra = $this->creo_codi_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CODIGO_BARRA']);//'CODI_BARRA'.$periodo.$ciclo.trim($recibos[0]['CLICODFAX']).$_SESSION['login'].date("d-m-Y");
                    if(trim($recibos[0]['FMEDIDOR']) != ""){
                        $nombre_grafi_barra = $this->creo_grafico_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CON01'],$recibos[0]['CON02'],$recibos[0]['CON03'],$recibos[0]['CON04'],$recibos[0]['CON05'],$recibos[0]['CON06'],$recibos[0]['CON07'],$recibos[0]['CON08'],$recibos[0]['CON09'], $recibos[0]['CON10'],$recibos[0]['CON11'],$recibos[0]['CON12'],$recibos[0]['CON13'],$recibos[0]['MES01'],$recibos[0]['MES02'],$recibos[0]['MES03'],$recibos[0]['MES04'],$recibos[0]['MES05'],$recibos[0]['MES06'],$recibos[0]['MES07'],$recibos[0]['MES08'],$recibos[0]['MES09'],$recibos[0]['MES10'],$recibos[0]['MES11'],$recibos[0]['MES12'],$recibos[0]['MES13']);
                    }
                    $dato_detalle=$this->Datos_recibo_model->get_dato_detalle( $recibos[0]['FACNRO'], $recibos[0]['FACSERNRO']);
                    $bandera = false;
                    if($array[4] == 1){
                        $distancia = 0;
                    }else{
                        if($array[4] == 3){
                            $distancia = 150;
                        } 
                        else{
                            $bandera = true ;
                        } 
                    }

                    if($bandera == true ){
                        $distancia = 0;
                        $pdf = $this ->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $array[3],1);
                        $distancia = 150;
                        $pdf = $this ->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $array[3],1);
                    }else{
                        $pdf = $this ->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $array[3],1);
                    }
                    $pdf->Output('Recibo_individual_A4.pdf', 'I');
                }

            }
        }
    }

    public function generando_recibo_individual(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $suministro = $this->input->post('suministro_fac');
            $periodo_inicio = $this->input->post('peri_inicio');
            $this->load->model('facturacion/Datos_recibo_model');
            $obtengo_recibo =  $this->Datos_recibo_model->get_rango_suministro_unico($suministro, $periodo_inicio);
            header("Content-type:application/json"); 
            $json = array('result' => true, 'datos' => $obtengo_recibo );
            echo json_encode($json);
        }
    }

    public function imagenes_rango_masivo(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $ciclo_facturacion = $this->input->post('ciclo_fac');
            $periodo = $this->input->post('periodo_fac');
            $rango_facturacion = $this->input->post('rango');
            $this->load->library('codi_barra_lib');
            $this->load->model('facturacion/Datos_recibo_model');
            $rango_separado =  explode("-", $rango_facturacion);
            $recibos = $this->Datos_recibo_model->get_rangos_imagenes($periodo, $ciclo_facturacion, $rango_separado);
            $i = 0 ;
            while($i < count($recibos)){
                /*
                if(trim($recibos[$i]['FMEDIDOR']) != ""){
                    $this->creo_grafico_barras($periodo,$ciclo_facturacion,$recibos[$i]['CLICODFAX'],$recibos[$i]['CON01'],$recibos[$i]['CON02'],$recibos[$i]['CON03'],$recibos[$i]['CON04'],$recibos[$i]['CON05'],$recibos[$i]['CON06'],$recibos[$i]['CON07'],$recibos[$i]['CON08'],$recibos[$i]['CON09'], $recibos[$i]['CON10'],$recibos[$i]['CON11'],$recibos[$i]['CON12'],$recibos[$i]['CON13'],$recibos[$i]['MES01'],$recibos[$i]['MES02'],$recibos[$i]['MES03'],$recibos[$i]['MES04'],$recibos[$i]['MES05'],$recibos[$i]['MES06'],$recibos[$i]['MES07'],$recibos[$i]['MES08'],$recibos[$i]['MES09'],$recibos[$i]['MES10'],$recibos[$i]['MES11'],$recibos[$i]['MES12'],$recibos[$i]['MES13']);
                }
                */
                $this->creo_codi_barras($periodo, $ciclo_facturacion, trim($recibos[$i]['CLICODFAX']),$recibos[$i]['CODIGO_BARRA']);
                $i++;
            }
            header("Content-type:application/json"); 
            $json = array('result' => true );
            echo json_encode($json);     
        }
    }
    private function creo_codi_barras($periodo,$ciclo_facturacion,$suministro,$mensaje){
        $mensaje = trim($mensaje);
        $mensaje2 = preg_replace( '/[^0-9]/', '', $mensaje );
       /* 
        $mensaje2 = "";
        for( $index = 0; $index < strlen($mensaje); $index++ )
        {
            if( is_numeric($mensaje[$index]) || $mensaje[$index]=='*' )
            {
                $mensaje2 .= $mensaje[$index];
            }
        }
        */
        $barcode=$this->codi_barra_lib->cargar($mensaje2);
        $barcode->setEanStyle(false);
        $barcode->setShowText(false);
        $barcode->setPixelWidth(2);
        $barcode->setBorderWidth(0);
        $nombre ='CODI_BARRA'.$periodo.$ciclo_facturacion.trim($suministro).$_SESSION['login'].date("d-m-Y");
        $barcode->saveBarcode('assets/recibo/'.$nombre.'.jpg');
        //return $nombre;
    }
    private function creo_codi_barras_rango($suministro,$mensaje){
        $this->load->library('codi_barra_lib');
        $mensaje = trim($mensaje);
        $mensaje2 = "";
        for( $index = 0; $index < strlen($mensaje); $index++ )
        {
            if( is_numeric($mensaje[$index]) || $mensaje[$index]=='*' )
            {
                $mensaje2 .= $mensaje[$index];
            }
        }
        $barcode=$this->codi_barra_lib->cargar($mensaje2);
        $barcode->setEanStyle(false);
        $barcode->setShowText(false);
        $barcode->setPixelWidth(2);
        $barcode->setBorderWidth(0);
        $nombre ='CODI_BARRA'.trim($suministro).$_SESSION['login'].date("d-m-Y");
        $barcode->saveBarcode('assets/recibo/'.$nombre.'.jpg');
        return $nombre;
    }

    private function creo_grafico_barras($periodo,$ciclo_facturacion,$suministro,$con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13,$mes01,$mes02,$mes03,$mes04,$mes05,$mes06,$mes07,$mes08,$mes09,$mes10,$mes11,$mes12,$mes13){
        $grafico_barras=new Graph(450, 250, "auto");
        /*ingreso los valores de cada mes  */
        $ydata = array($con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13);
        /* datos en la cuadrante x  del grafico*/
        $datax = array(trim($mes01),trim($mes02),trim($mes03),trim($mes04),trim($mes05),trim($mes06),trim($mes07),trim($mes08),trim($mes09),trim($mes10),trim($mes11),trim($mes12),trim($mes13));
        $grafico_barras->SetScale("textlin");
        $grafico_barras->img->SetMargin(40, 40, 40, 40);
        /*titulo del grafico*/
        $grafico_barras->title->Set("CONSUMOS MENSUALES (en m3)");
        $grafico_barras->xaxis->title->Set("");
        $grafico_barras->yaxis->title->Set("");
        $grafico_barras->xaxis->SetTickLabels($datax);
        $grafico_barras->SetMarginColor('white');
        $barplot =new BarPlot($ydata);
        /*color de las barras del grafico*/
        $barplot->SetColor("black");
        $barplot->value->SetFormat('%01.0f');
        $barplot->value->Show();
        $grafico_barras->Add($barplot);
        $nombre =$periodo.$ciclo_facturacion.trim($suministro).$_SESSION['login'].date("d-m-Y");
        $grafico_barras->Stroke('assets/recibo/'.$nombre.'.jpg');
        
    }
    private function creo_grafico_barras_rango($suministro,$con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13,$mes01,$mes02,$mes03,$mes04,$mes05,$mes06,$mes07,$mes08,$mes09,$mes10,$mes11,$mes12,$mes13){
        $grafico_barras=new Graph(450, 250, "auto");
        /*ingreso los valores de cada mes  */
        $ydata = array($con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13);
        /* datos en la cuadrante x  del grafico*/
        $datax = array(trim($mes01),trim($mes02),trim($mes03),trim($mes04),trim($mes05),trim($mes06),trim($mes07),trim($mes08),trim($mes09),trim($mes10),trim($mes11),trim($mes12),trim($mes13));
        $grafico_barras->SetScale("textlin");
        $grafico_barras->img->SetMargin(40, 40, 40, 40);
        /*titulo del grafico*/
        $grafico_barras->title->Set("CONSUMOS MENSUALES (en m3)");
        $grafico_barras->xaxis->title->Set("");
        $grafico_barras->yaxis->title->Set("");
        $grafico_barras->xaxis->SetTickLabels($datax);
        $grafico_barras->SetMarginColor('white');
        $barplot =new BarPlot($ydata);
        /*color de las barras del grafico*/
        $barplot->SetColor("black");
        $barplot->value->SetFormat('%01.0f');
        $barplot->value->Show();
        $grafico_barras->Add($barplot);
        /*$nombre =$periodo.$ciclo_facturacion.trim($suministro).$_SESSION['login'].date("d-m-Y");
        $grafico_barras->Stroke('assets/recibo/'.$nombre.'.jpg');*/

        $img = $grafico_barras->Stroke(_IMG_HANDLER);
        ob_start();                                            
        imagejpeg($img);
        $img_data = ob_get_contents();
        ob_end_clean();
        //$image_data_base64 = base64_encode ($img_data);
        return $img_data;
        
    }

}
