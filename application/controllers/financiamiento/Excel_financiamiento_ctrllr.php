<?php

class Excel_financiamiento_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['Excel_financiamiento'] = 'ex_fina';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['Excel_financiamiento'] );
        if(count($permiso)>0){
            $this->data['proceso'] = 'Financiamiento';
            $this->data['menu']['padre'] = 'FINANCIAMIENTO';
            $this->data['menu']['hijo'] = 'ex_fina';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function  Excel_financiamiento(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso)>0){
            $this->data['view'] = 'Financiamiento/excel_financiamiento_view';
            $this->data['breadcrumbs'] = array(array('Excel Financiamiento', 'financiamiento/excel'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }


    public function busco_financiamiento(){
      $ajax = $this->input->get('ajax');
      if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $fecha_inicio = $this->input->post('inicio');
            $fecha_fin = $this->input->post('fin');
            $tipo = $this->input->post('tipo');
            $concepto_redondeo = $this->input->post('concepto_redondeo');
            $fina_anulado = $this->input->post('financiamiento_anulado');
            $concep_847 = $this->input->post('concepto_847');
            $estado_financiamiento = $this->input->post('esta_deuda');
            $valor_oficinas = $this->input->post('oficinas');
            $resultado  = $this->Financiamiento_model -> get_financiamientos($fecha_inicio, $fecha_fin, $tipo,$concepto_redondeo, $fina_anulado, $concep_847,  $estado_financiamiento, $valor_oficinas);
            if(count($resultado)>0){
                $json = array('result' => true, 'respuesta' => $resultado);
                echo json_encode($json);
                return;
            }else{
                $json = array('result' => false);
                echo json_encode($json);
                return;
            }

        }
    }

    public function reporte_financiamiento(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('reporte_pdf'),true);
            //var_dump($array);
            $this->load->library('lib_tcpdf');
           $pdf = $this->lib_tcpdf->cargar();
           $pdf->setPrintHeader(false);
           //$pdf->setPrintFooter(false);
           // set default monospaced font
           $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
           // set margins
           $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
           // set auto page breaks
           $pdf->SetAutoPageBreak(true, 0);
           // set image scale factor
           $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
           // add a page
           $pdf->AddPage('L', 'A4');
           $pdf->SetAutoPageBreak(false, 0);
           //var_dump($array);
           $resultado = $this->lib_tcpdf-> plantilla_repo_financiamiento($pdf, $array[0], $array[1], $array[2], $array[3]);
           $resultado->Output('reporte_financiamiento.pdf', 'I'); 
        }
    }
}
?>