<?php

class Genera_recibo_ctrllr extends CI_Controller{
     public function __construct() {
       parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('facturacion/Datos_recibo_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Genera recibo ';
        $this->data['menu']['padre'] = 'facturacion';
        $this->data['menu']['hijo'] = 'genera_recibo';
        $this->direccion_barra = 'assets/recibo/';
    }

    public function genera_recibo(){
        //$variable = 0; 
        //foreach($_SESSION['ACTIVIDADES'] as $GRP1){
            //if($GRP1['MENUGENDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'RECIBO'){
                $this->data['titulo']="Generar Recibo";
                $this->data['view'] = 'facturacion/Genera_recibo_view';
                $this->data['breadcrumbs'] = array(array('Facturación', ''),array('Genera Recibo',''));
                $this->load->view('template/Master', $this->data);
                $variable = 1;
                //break;
            //}
        //}
        //if($variable == 0){
          //  $this->load->view('errors/html/error_404', $this->data);
        //}

    }
     //recibo con fondo 
    public function creo_recibo($suministro,$periodo){
          //echo "el suministro es ".$suministro."y el periodo es " .$periodo;
      $dato_general=$this->Datos_recibo_model->get_dato_general($suministro,$periodo);// datos generales
      if(count($dato_general)>0){
        $dato_detalle=$this->Datos_recibo_model->get_dato_detalle($dato_general[0]['FACNRO'],$dato_general[0]['FACSERNRO']);//datos detalle
        //$this ->cargo_dompdf($dato_general,$dato_detalle);
        $this ->cargo_tcpdf($dato_general,$dato_detalle);
      }

    }

    public function cargo_tcpdf($dato_general,$dato_detalle){
       $this->load->library('lib_tcpdf');
       $this->creo_codi_barras($dato_general[0]['BARCOD']);//codigo de barras
      if(trim($dato_general[0]['FMEDIDOR']) != ""){
          $this->creo_grafico_barras($dato_general[0]['CON01'],$dato_general[0]['CON02'],$dato_general[0]['CON03'],$dato_general[0]['CON04'],$dato_general[0]['CON05'],$dato_general[0]['CON06'],$dato_general[0]['CON07'],$dato_general[0]['CON08'],$dato_general[0]['CON09'], $dato_general[0]['CON10'],$dato_general[0]['CON11'],$dato_general[0]['CON12'],$dato_general[0]['CON13'],$dato_general[0]['MES01'],$dato_general[0]['MES02'],$dato_general[0]['MES03'],$dato_general[0]['MES04'],$dato_general[0]['MES05'],$dato_general[0]['MES06'],$dato_general[0]['MES07'],$dato_general[0]['MES08'],$dato_general[0]['MES09'],$dato_general[0]['MES10'],$dato_general[0]['MES11'],$dato_general[0]['MES12'],$dato_general[0]['MES13']);
      }
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
       $pdf->AddPage('P', 'A5');
       $pdf->SetAutoPageBreak(false, 0);
       $resultado = $this->lib_tcpdf -> cargo_plantilla($pdf,$dato_general,$dato_detalle);
       if(trim($dato_general[0]['FMEDIDOR']) != ""){
        unlink('assets/recibo/grafico_barras.jpg');
       }
       unlink('assets/recibo/codi_barra.png');
       $resultado->Output('example_021.pdf', 'I');
    } 

    public function creo_recibo_a4($suministro,$periodo){
      //echo "hola mundo";
      $dato_general=$this->Datos_recibo_model->get_dato_general($suministro,$periodo);// datos generales
      if(count($dato_general)>0){
        $dato_detalle=$this->Datos_recibo_model->get_dato_detalle($dato_general[0]['FACNRO'],$dato_general[0]['FACSERNRO']);//datos detalle
        //$this ->cargo_dompdf_sin_fondo($dato_general,$dato_detalle);
        $this ->cargo_tcpdf_a4($dato_general,$dato_detalle);
      }
    }

    public function cargo_tcpdf_a4($dato_general,$dato_detalle){
       $this->load->library('lib_tcpdf');
       $this->creo_codi_barras($dato_general[0]['BARCOD']);//codigo de barras
      if(trim($dato_general[0]['FMEDIDOR']) != ""){
          $this->creo_grafico_barras($dato_general[0]['CON01'],$dato_general[0]['CON02'],$dato_general[0]['CON03'],$dato_general[0]['CON04'],$dato_general[0]['CON05'],$dato_general[0]['CON06'],$dato_general[0]['CON07'],$dato_general[0]['CON08'],$dato_general[0]['CON09'], $dato_general[0]['CON10'],$dato_general[0]['CON11'],$dato_general[0]['CON12'],$dato_general[0]['CON13'],$dato_general[0]['MES01'],$dato_general[0]['MES02'],$dato_general[0]['MES03'],$dato_general[0]['MES04'],$dato_general[0]['MES05'],$dato_general[0]['MES06'],$dato_general[0]['MES07'],$dato_general[0]['MES08'],$dato_general[0]['MES09'],$dato_general[0]['MES10'],$dato_general[0]['MES11'],$dato_general[0]['MES12'],$dato_general[0]['MES13']);
      }
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
       $resultado = $this->lib_tcpdf -> cargo_plantilla($pdf,$dato_general,$dato_detalle);
       if(trim($dato_general[0]['FMEDIDOR']) != ""){
        unlink('assets/recibo/grafico_barras.jpg');
       }
       unlink('assets/recibo/codi_barra.png');
       $resultado->Output('example_021.pdf', 'I');
    } 

    public function grafico_pdf(){
        $ajax = $this->input->get('ajax');
        if($ajax=true){
          $suministro=$this->input->post('suministro');
          $dato_meses=$this->Datos_recibo_model->get_dato_fechas($suministro); // dato por meses
          if(count($dato_meses)>0 ){
            $json =  array('result' =>  true, 'mensaje' => 'LLEGO CON EXITO', 'dato_meses' => $dato_meses);
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
          }else{
           $json =  array('result' =>  false, 'mensaje' => 'NO EXISTE NUMERO DE SUMINISTRO');
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
          }
        }

    }

    private function creo_codi_barras($mensaje){
        $this->load->library('codi_barra_lib');
        //$mensaje=substr(str_replace(' ', '', substr(utf8_decode($mensaje),1,-1)),0,-1);
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
        $barcode->saveBarcode('assets/recibo/codi_barra.png');

    }
    private function creo_grafico_barras($con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13,
                                        $mes01,$mes02,$mes03,$mes04,$mes05,$mes06,$mes07,$mes08,$mes09,$mes10,$mes11,$mes12,$mes13){
        $this->load->library('grafico_barras');
        $this->grafico_barras->cargar();
        $grafico_barras=new Graph(450, 250, "auto");
        /*ingreso los valores de cada mes  */
        $ydata = array($con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13);
        /* datos en la cuadrante x  del grafico*/
        $datax = array(trim($mes01),trim($mes02),trim($mes03),trim($mes04),trim($mes05),trim($mes06),trim($mes07),trim($mes08),trim($mes09),trim($mes10),trim($mes11),trim($mes12),trim($mes13));
        $grafico_barras->SetScale("textlin");
        $grafico_barras->img->SetMargin(40, 40, 40, 40);
        /*titulo del grafico*/
        $grafico_barras->title->Set("CONSUMOS MENSUALES (en m3)");
        $grafico_barras->xaxis->title->Set("" );
        $grafico_barras->yaxis->title->Set("" );
        $grafico_barras->xaxis->SetTickLabels($datax);
        $grafico_barras->SetMarginColor('white');
        $barplot =new BarPlot($ydata);
        /*color de las barras del grafico*/
        $barplot->SetColor("black");
        $barplot->value->SetFormat('%01.0f');

        $barplot->value->Show();

        $grafico_barras->Add($barplot);
        $grafico_barras->Stroke('assets/recibo/grafico_barras.jpg');

    }

}


?>
