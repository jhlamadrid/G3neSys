<?php
class Atipicos_ctrllr extends CI_Controller{
     public function __construct() {
       parent::__construct();
        $this->load->helper('form');
        $this->load->model('acceso/Usuario_model');
        $this->load->model('facturacion/Atipicos_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'VER CASOS ATIPICOS';
        $this->data['menu']['padre'] = 'facturacion';
        $this->data['menu']['hijo'] = 'atipico';
    }

    public function ver (){
      $this->data['titulo']="Ver ATIPICOS";
      $this->data['view'] = 'facturacion/Atipicos_view';
      $this->data['breadcrumbs'] = array(array('Atipicos', ''));
      $this->load->view('template/Master', $this->data);
    }

    public function buscar (){
      $ajax = $this->input->get('ajax');
        if($ajax=true){
          $suministro=$this->input->post('suministro');
          $i = 0 ;
          $bandera =0;  
          while ( strlen($suministro) > $i ){
            if (ord($suministro[$i]) <= 47 ||  ord($suministro[$i]) > 57) {
              $bandera =1;
            }
            $i++;
          }
          if ($bandera ==1) {
             $json =  array('result' => false, 'mensaje' => 'INGRESE UN CODIGO DE SUMINISTRO CORRECTO ' );
                echo json_encode($json);
          }
          else{
              $atipico = $this->Atipicos_model->get_atipicos($suministro);
              $atipico_siac = $this->Atipicos_model->get_atipico_siac($suministro);
              if (strlen($suministro)==7){
                  $dato_nombre = $this->Atipicos_model -> obtengo_dato_nombre_tam7($suministro);
                  $dato_detalle = $this->Atipicos_model -> obtengo_dato_tam7($suministro);
                  if($dato_detalle != null){
                    $json =  array('result' =>  true, 'mensaje' => 'LLEGO CON EXITO', 'rpta' => $atipico , 'deta_atipico' => $dato_detalle[0] ,'data_nombre' => $dato_nombre[0] , 'atipico_siac' => $atipico_siac , 'tam' =>7 );
                    echo json_encode($json);
                  }else{
                    $json =  array('result' => false, 'mensaje' => 'NO SE ENCONTRO SUMINISTRO' );
                    echo json_encode($json);
                  }
                  
              }else{
                if (strlen($suministro)==11) {
                  $dato_detalle = $this->Atipicos_model -> obtengo_dato_tam11($suministro);
                  if($dato_detalle != null){
                    $json =  array('result' =>  true, 'mensaje' => 'LLEGO CON EXITO', 'rpta' => $atipico , 'deta_atipico' => $dato_detalle[0] , 'atipico_siac' => $atipico_siac , 'tam' => 11 );
                    echo json_encode($json);
                  }else{
                    $json =  array('result' => false, 'mensaje' => 'NO SE ENCONTRO SUMINISTRO' );
                    echo json_encode($json);
                  }
                  
                }else{
                    $json =  array('result' => false, 'mensaje' => 'INGRESE UN CODIGO DE SUMINISTRO CORRECTO ' );
                    echo json_encode($json);
                }
              }
          }
          
        }
    }

    public function ver_detalle($suministro,$periodo){
      $this->data['titulo']="DETALLE DE ATIPICOS ";
      $this->data['view'] = 'facturacion/Atipico_detalle_view';
      $this->data['detalle_atipico'] = $this->Atipicos_model->get_archivos($suministro,$periodo);
      $dato_periodo = (int) (substr($periodo,4,strlen($periodo)));
      $dato_anio = substr($periodo,0,4);
      $meses[1]='ENERO';
      $meses[2]='FEBRERO';
      $meses[3]='MARZO';
      $meses[4]='ABRIL';
      $meses[5]='MAYO';
      $meses[6]='JUNIO';
      $meses[7]='JULIO';
      $meses[8]='AGOSTO';
      $meses[9]='SEPTIEMBRE';
      $meses[10]='OCTUBRE';
      $meses[11]='NOVIEMBRE';
      $meses[12]='DICIEMBRE';
      if (strlen($suministro)==7){
              $dato_nombre = $this->Atipicos_model -> obtengo_dato_nombre_tam7($suministro);
              $dato_detalle = $this->Atipicos_model -> obtengo_dato_tam7($suministro);
              $this->data['datos_atipicos'] = $dato_detalle[0];
              $this->data['periodo'] = $meses[$dato_periodo+1];
              $this->data['peri'] = $dato_periodo;
              $this->data['anio'] = $dato_anio;
              $this->data['data_nombre'] = $dato_nombre[0];
              $this->data['tam'] = 7;
              $this->data['breadcrumbs'] = array(array('Atipicos', ''));
              $this->load->view('template/Master', $this->data);
        }else{
          if (strlen($suministro)==11) {
              $dato_detalle = $this->Atipicos_model -> obtengo_dato_tam11($suministro);
              $this->data['datos_atipicos'] = $dato_detalle[0];
              $this->data['periodo'] = $meses[$dato_periodo+1];
              $this->data['peri'] = $dato_periodo;
              $this->data['anio'] = $dato_anio;
              $this->data['tam'] = 11;
              $this->data['breadcrumbs'] = array(array('Atipicos', ''));
              $this->load->view('template/Master', $this->data);
            }else{

            }
          }

    }
    public function ver_detalle_SIAC($suministro,$ciclo,$periodo){
      $this->data['titulo']="DETALLE DE ATIPICOS ";
      $this->data['view'] = 'facturacion/Atipico_detalle_SIAC_view';
      $this->data['detalle_atipico'] = $this->Atipicos_model->get_archivos_SIAC($suministro,$ciclo,$periodo);
      $dato_periodo = (int) (substr($periodo,4,strlen($periodo)));
      $dato_anio = substr($periodo,0,4);
      if(($dato_periodo + 1) == 13){
        $dato_periodo = 0 ; 
        $dato_anio = (int)$dato_anio + 1;
      }
      $meses[1]='ENERO';
      $meses[2]='FEBRERO';
      $meses[3]='MARZO';
      $meses[4]='ABRIL';
      $meses[5]='MAYO';
      $meses[6]='JUNIO';
      $meses[7]='JULIO';
      $meses[8]='AGOSTO';
      $meses[9]='SEPTIEMBRE';
      $meses[10]='OCTUBRE';
      $meses[11]='NOVIEMBRE';
      $meses[12]='DICIEMBRE';
      //$deta_atipico = $this->Atipicos_model->detalle_suministro($suministro, $periodo);
       if (strlen($suministro)==7){
              $dato_nombre = $this->Atipicos_model -> obtengo_dato_nombre_tam7($suministro);
              $dato_detalle = $this->Atipicos_model -> obtengo_dato_tam7($suministro);
              $this->data['datos_atipicos'] = $dato_detalle[0];
              $this->data['data_nombre'] = $dato_nombre[0];
              $this->data['periodo'] = $meses[$dato_periodo+1];
              $this->data['peri'] = $dato_periodo;
              $this->data['anio'] = $dato_anio;
              $this->data['tam'] = 7;
              $this->data['breadcrumbs'] = array(array('Atipicos' , ''));
              $this->load->view('template/Master', $this->data);
        }else{
          if (strlen($suministro)==11) {
              $dato_detalle = $this->Atipicos_model -> obtengo_dato_tam11($suministro);
              $this->data['datos_atipicos'] = $dato_detalle[0];
              $this->data['periodo'] = $meses[$dato_periodo+1];
              $this->data['peri'] = $dato_periodo;
              $this->data['anio'] = $dato_anio;
              $this->data['tam'] = 11;
              $this->data['breadcrumbs'] = array(array('Atipicos', ''));
              $this->load->view('template/Master', $this->data);
            }else{

            }
        } 
    }


    public function reporte_imagen(){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        $array = json_decode($this->input->post('reporte_atipico'),true);
        $this->load->library('lib_tcpdf');
        $pdf = $this->lib_tcpdf->cargar();
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
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage('P', 'A4');
        $resultado = $this->lib_tcpdf-> plantilla_reporte_atipico($pdf,$array[0], $array[1], $array[2], $array[3], $array[4]);
        $resultado->Output('reporte_atipico.pdf', 'I');
      }
    }

    public function reporte_lectura(){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        $array = json_decode($this->input->post('reporte_lectura'),true);
        $respuesta= $this->Atipicos_model->get_lectura_sumi($array[0], $array[1], $array[2]);
        $this->load->library('lib_tcpdf');
        $pdf = $this->lib_tcpdf->cargar(); 
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
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage('P', 'A4');
        $resultado = $this->lib_tcpdf-> plantilla_reporte_lectura($pdf,$respuesta[0], $array[1], $array[2], $array[3],$respuesta[1]);
        $resultado->Output('reporte_lectura.pdf', 'I');
      }
    }

    public function reporte_re_lectura(){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        $array = json_decode($this->input->post('reporte_re_lectura'),true);
        $respuesta= $this->Atipicos_model->get_re_lectura_sumi($array[0], $array[1], $array[2]);
        if($respuesta[2] == true){
          $this->load->library('lib_tcpdf');
          $pdf = $this->lib_tcpdf->cargar();
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
          $pdf->SetAutoPageBreak(false, 0);
          $pdf->AddPage('P', 'A4');
          $resultado = $this->lib_tcpdf-> plantilla_reporte_re_lectura($pdf,$respuesta[0], $array[1], $array[2], $array[3],$respuesta[1]);
          $resultado->Output('reporte_re_lectura.pdf', 'I');
        }else{
          $this->load->library('lib_tcpdf');
          $pdf = $this->lib_tcpdf->cargar();
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
          $pdf->SetAutoPageBreak(false, 0);
          $pdf->AddPage('P', 'A4');
          $pdf->SetFont('helveticaB', '',9);
          $pdf->writeHTMLCell(170, 5, 30, 20 ,"<p>NO SE ENCONTRO RE-LECTURA</p>", 0, 1, 0, true, 'L',  true);
          $pdf->Output('reporte_re_lectura.pdf', 'I');
        }
        
      }
    }
            
}

?>