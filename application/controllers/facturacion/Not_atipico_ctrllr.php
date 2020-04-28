<?php
class Not_atipico_ctrllr extends CI_Controller{
     public function __construct() {
       parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Genera notificación a los usuarios';
        $this->data['menu']['padre'] = 'facturacion';
        $this->data['menu']['hijo'] = 'not_atipico';
    }

    public function ver (){
      $this->load->model('mail/Mail_model');
      $ciclos = $this->Mail_model->get_ciclos();
      $this->data['ciclos'] = $ciclos;
      $this->data['titulo']="Notificación de Atipicos";
      $this->data['view'] = 'facturacion/Not_atipico_view';
      $this->data['breadcrumbs'] = array(array('Not. Atipicos', ''));
      $this->load->view('template/Master', $this->data);
    }


   public function crear($periodo,$ciclo){

     
        $this->load->model('facturacion/Not_Atipicos_model');
        $this->load->model('facturacion/SIAC/SIAC_Not_atipico');
        $anio= (int) substr($periodo , 0 , 4);
        $mes = (int) substr($periodo, 4 , strlen($periodo));
        $anio2 = $anio ;
        $mes2= $mes - 1;
        if($mes2<10){
            if($mes2==0){
                $anio2 = $anio - 1;
                $mes2 = 12;
                $periodo2 =$anio2.$mes2;
            }else{
                $periodo2 =$anio.'0'.$mes2;
            }
             
        }else{
            $periodo2 =$anio.$mes2;
        }
        
        if($mes[0]=='0'){
            $mes =$mes[1]; 
        }

        $ciclos = explode("-", $ciclo);
        $suministros = $this->Not_Atipicos_model->Get_Suministro($periodo2, $ciclos);
        $this->load->library('tcp_not_atipico');
        $notifica = $this->tcp_not_atipico->cargar();
        $notifica->setPrintHeader(false);
        $notifica->setPrintFooter(false);
        // set default monospaced font
        $notifica->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $notifica->SetMargins(0, PDF_MARGIN_TOP, 0);
        // set auto page breaks
        $notifica->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $notifica->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // add a page
        $notifica->SetAutoPageBreak(false, 0);
        $i=0;
        $meses = array(
                "01" => "Enero",
                "02" => "Febrero",
                "03" => "Marzo",
                "04" => "Abril",
                "05" => "Mayo",
                "06" => "Junio",
                "07" => "Julio",
                "08" => "Agosto",
                "09" => "Septiembre",
                "10" => "Octubre",
                "11" => "Noviembre",
                "12" => "Diciembre",
        );

        while ($i<count($suministros)) {

            $notifica->AddPage('P', 'A4');
            $nombre = $suministros[$i]["NOMBRE"];
            $domicilio = trim($suministros[$i]["URBANIZAC"])." ".trim($suministros[$i]["CALLE"])." ".trim($suministros[$i]["CLIMUNNRO"]);
            $ciclo_sum=  $suministros[$i]["CICLO"];
            $suministro = $suministros[$i]["CLICODFAC"]; 
            $lectura = $suministros[$i]["LECTURA"];
            $consumo = $suministros[$i]["CONZUMO"];
            if( ($mes + 1) == 13){
                $anio = $anio +1 ;
                $mes = 0;
            }
            $image_letura = $this->SIAC_Not_atipico->Image_Lectura_Atipico($anio2, $mes2 , $ciclo_sum,$suministro);
            //$image_letura = $this->SIAC_Not_atipico->Image_Lectura_Atipico($anio, ( $mes +1 ) , $ciclo_sum,$suministro); 
            if($image_letura == null){
                $fecha_lectura = '';
                $cadena = null;
            }else{
                $fecha_lectura = $image_letura[0]['fecha_lectura'];
                if ($image_letura[0]['ruta_img1'] == null) {
                    $cadena = null;
                }else{
                    $cadena = $this->config->item('externalIP').$image_letura[0]['ruta_img1'];
                }  
            }
            $horas_inspeccion =$this->SIAC_Not_atipico->Fecha_notificacion_Atipico( $periodo, $ciclo_sum,$suministro);
            $domicilio =$domicilio." - PROVINCIA : ".trim($horas_inspeccion[0]["provincia"]); 
            $fecha_inicio_sup = date_create($horas_inspeccion [0]['Fecha_Inicio']);
            $fecha_fin_sup = date_create($horas_inspeccion [0]['Fecha_Fin']);
            $notifica = $this->tcp_not_atipico->cargo_plantilla($notifica, $nombre, $domicilio, $ciclo_sum, $suministro, $periodo, $lectura, $consumo, $cadena,$fecha_lectura,($i+1),date_format($fecha_inicio_sup , 'd-m-Y'),date_format($fecha_inicio_sup , 'H.i A'),date_format($fecha_fin_sup , 'H.i A') );
            
            $i++;
        }
    
        $notifica->Output('Notificacion.pdf', 'I');
      }

      public function crear_excel ($periodo,$ciclo){
            $this->load->model('facturacion/Not_Atipicos_model');
            $this->load->model('facturacion/SIAC/SIAC_Not_atipico');
            $anio= (int) substr($periodo , 0 , 4);
            $mes = (int) substr($periodo, 4 , strlen($periodo));
        
            $mes2= $mes - 1;
            if($mes2<10){
                if($mes2==0){
                    //var_dump($anio);
                    $anio2 = $anio - 1;
                    $mes2 = 12;
                    $periodo2 = $anio2.$mes2;
                }else{
                    $periodo2 =$anio.'0'.$mes2;
                }
                
            }else{
                $periodo2 =$anio.$mes2;
            }
            $ciclos = explode("-", $ciclo);
            //var_dump($periodo2, $ciclos);
            //exit();
            $suministros = $this->Not_Atipicos_model->Get_Suministro($periodo2, $ciclos);
            //var_dump($suministros);
            //exit();
            $this->load->library("excel");
            $objPHPExcel = new PHPExcel();
            // Agregaremos los datos de nuestro documento
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'Nro')
                        ->setCellValue('B1', 'Clicodfac')
                        ->setCellValue('C1', 'Nombre')
                        ->setCellValue('D1', 'Urbranización')
                        ->setCellValue('E1', 'Calle')
                        ->setCellValue('F1', 'CliMunNro')
                        ->setCellValue('G1', 'CicloReal')
                        ->setCellValue('H1', 'Fecnotimed')
                        ->setCellValue('I1', 'HoraNotificacion')
                        ->setCellValue('J1', 'MedCodigo');
            //var_dump($suministros);
            $i = 0;
            $j= 2 ;
            while ($i<count($suministros)) {
                $suministro_individual = $suministros[$i]['CLICODFAC'] ;
                $ciclo_sum  =  $suministros[$i]['CICLO'] ;
                $horas_inspeccion =$this->SIAC_Not_atipico->Fecha_notificacion_Atipico( $periodo, $ciclo_sum,$suministro_individual);
                //var_dump($horas_inspeccion);
                $fecha_inicio_sup =date_format(date_create($horas_inspeccion [0]['Fecha_Inicio']) , 'd-m-Y ') ;
                $hora_inicio = date_format(date_create($horas_inspeccion [0]['Fecha_Inicio']) , 'H.i A');
                $hora_fin = date_format(date_create($horas_inspeccion [0]['Fecha_Fin']) , 'H.i A') ;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$j, ($i+1))
                        ->setCellValue('B'.$j, $suministros[$i]['CLICODFAC'])
                        ->setCellValue('C'.$j, $suministros[$i]['NOMBRE'])
                        ->setCellValue('D'.$j, $suministros[$i]['URBANIZAC'])
                        ->setCellValue('E'.$j, $suministros[$i]['CALLE'])
                        ->setCellValue('F'.$j, $suministros[$i]['CLIMUNNRO'])
                        ->setCellValue('G'.$j, $suministros[$i]['CICLO'])
                        ->setCellValue('H'.$j, $fecha_inicio_sup)
                        ->setCellValue('I'.$j, $hora_inicio.' a '. $hora_fin)
                        ->setCellValue('J'.$j, $suministros[$i]['MEDCODYGO']);
                $i = $i + 1 ;
                $j = $j + 1 ;                
            }
            //exit();
            // Renombrando hoja activa
            $objPHPExcel->getActiveSheet()->setTitle('Ejemplo');
                     
            //Seleccionamos la hoja que estara seleccionada al abrir el documento
            $objPHPExcel->setActiveSheetIndex(0);
                     
            // Guardamos el archivo Excel
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Not_atipicos.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }
      
    //}
      
}

?>