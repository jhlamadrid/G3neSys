<?php

class Administrador_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('external/Administracion_model');
    }
    
    public function duplicado($suministro,$periodo){
        
        $dato_general=$this->Administracion_model->get_dato_general($suministro,$periodo);// datos generales
        if(count($dato_general)>0){
            $dato_detalle=$this->Administracion_model->get_dato_detalle($dato_general[0]['FACNRO'],$dato_general[0]['FACSERNRO']);
            $this ->cargo_tcpdf($dato_general,$dato_detalle);
        }
    } 
    
    public function cargo_tcpdf($dato_general,$dato_detalle){
        $this->load->library('lib_tcpdf');
        $this->creo_codi_barras($dato_general[0]['BARCOD']);
        if(trim($dato_general[0]['FMEDIDOR']) != ""){
            $this->creo_grafico_barras($dato_general[0]['CON01'],$dato_general[0]['CON02'],$dato_general[0]['CON03'],$dato_general[0]['CON04'],$dato_general[0]['CON05'],$dato_general[0]['CON06'],$dato_general[0]['CON07'],$dato_general[0]['CON08'],$dato_general[0]['CON09'], $dato_general[0]['CON10'],$dato_general[0]['CON11'],$dato_general[0]['CON12'],$dato_general[0]['CON13'],$dato_general[0]['MES01'],$dato_general[0]['MES02'],$dato_general[0]['MES03'],$dato_general[0]['MES04'],$dato_general[0]['MES05'],$dato_general[0]['MES06'],$dato_general[0]['MES07'],$dato_general[0]['MES08'],$dato_general[0]['MES09'],$dato_general[0]['MES10'],$dato_general[0]['MES11'],$dato_general[0]['MES12'],$dato_general[0]['MES13']);
        }
        $pdf = $this->lib_tcpdf->cargar();  
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage('P', 'A5');
        $pdf->SetAutoPageBreak(false, 0);
        $resultado = $this->lib_tcpdf -> cargo_plantilla($pdf,$dato_general,$dato_detalle);
        if(trim($dato_general[0]['FMEDIDOR']) != ""){
            unlink('assets/recibo/grafico_barras.jpg');
        }
        unlink('assets/recibo/codi_barra.png');
        $resultado->Output('duplicado.pdf', 'I');
    } 
    
    private function creo_codi_barras($mensaje){
        $this->load->library('codi_barra_lib');
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