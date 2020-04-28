<?php
class Mail_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->load->model('mail/Mail_model');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Creacion de Excel';
        $this->data['menu']['padre'] = 'facturacion';
        $this->data['menu']['hijo'] = 'mail';
    }

    public function VerMail(){
    	$this->data['view'] = 'Mail/Mail_view';
        $ciclos = $this->Mail_model->get_ciclos();
        $this->data['ciclos'] = $ciclos;
        $this->data['breadcrumbs'] = array(array('Mail', ''));
        $this->load->view('template/Master', $this->data);
    }

    public function CrearExcel(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('reporte'));

                // EXTRAIGO DATOS  
                $data = $this->Mail_model->get_datos($array[0],$array[1],$array[2]);
                if (count($data)>0) {
                    //cargo data;    
                    $this->load->library("excel");
                    $objPHPExcel = new PHPExcel();
                    // Agregaremos los datos de nuestro documento
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', 'Suministro')
                                ->setCellValue('B1', 'Nombre')
                                ->setCellValue('C1', 'Dirección')
                                ->setCellValue('D1', 'Correo')
                                ->setCellValue('E1', 'Ciclo')
                                ->setCellValue('F1', 'Clase')
                                ->setCellValue('G1', 'Serie')
                                ->setCellValue('H1', 'Numero')
                                ->setCellValue('I1', 'Url')
                                ->setCellValue('J1', 'Fecha');

                    $i=0;
                    $j=2;
                    while ($i<count($data)) {
                       // Agregaremos los datos de nuestro documento
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$j, $data[$i]['CLICODFAX'])
                                ->setCellValue('B'.$j, $data[$i]['CLINOMBRE'])
                                ->setCellValue('C'.$j, $data[$i]['DIRECCION_CLIENTE'])
                                ->setCellValue('D'.$j, $data[$i]['CORREO'])
                                ->setCellValue('E'.$j, $data[$i]['FCICLO'])
                                ->setCellValue('F'.$j, $data[$i]['CLASE'])
                                ->setCellValue('G'.$j, $data[$i]['FACSERNRO'])
                                ->setCellValue('H'.$j, $data[$i]['FACNRO'])
                                ->setCellValue('I'.$j, $data[$i]['URL'])
                                ->setCellValue('J'.$j, $data[$i]['FECHA']); 

                        $i = $i + 1 ;
                        $j = $j + 1 ;
                    }
                     
                    // Renombrando hoja activa
                    $objPHPExcel->getActiveSheet()->setTitle('Ejemplo');
                     
                    //Seleccionamos la hoja que estara seleccionada al abrir el documento
                    $objPHPExcel->setActiveSheetIndex(0);
                     
                    // Guardamos el archivo Excel
                    // Redirect output to a client’s web browser (Excel2007)
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="ArchivoMail_'.$array[1].$array[0].'_'.$array[2].'.xlsx"');
                    header('Cache-Control: max-age=0');
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    $objWriter->save('php://output');
                    exit;
                }else{
                    $this->session->set_flashdata('mensaje', array('error', 'Alerta: no se encontraron recibos cargados ',""));
                    //echo "<script lenguaje=\'JavaScript\''>window.close();</script>";
                    echo "No se encuentran subidos los recibos";
                    //redirect(base_url() . 'mail/CrearExcel');
                    
                    //return ;
                }
                
        }
        
      
    }
}

?>