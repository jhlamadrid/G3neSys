<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
 

    class Atender_reclamo_ctrllr extends CI_Controller{
        
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
            $this->data['actividad'] = 'ATENDER_RECLAMO';
            
            $this->data['rol'] = $this->Reclamo_no_facturacion_model->get_rol($_SESSION['user_id']); 
            //$this->Global_model->findRol($_SESSION['userCod']); 
            //$this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['userCod']); 

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
                $this->data['repre_reclamante'] = $this->Reclamo_no_facturacion_model->repre_recla();
                $this->data['resultado'] = $this->Reclamo_no_facturacion_model->resultado_reclamante();
                $this->data['view'] = 'reclamo_no_facturacion/Atender_reclamo_view';
                $this->data['breadcrumbs'] = array(array('Atender Reclamo', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function imprimir_conciliacion(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('imprimir_conciliacion'));
                $conciliacion = $this->Reclamo_no_facturacion_model->get_impre_concilia($array);
                $reclamo = $this->Reclamo_no_facturacion_model->get_reclamo($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6]);
                $reclamante = $this->Reclamo_no_facturacion_model->get_reclamante_concilia($reclamo['PRECOD']);
                $descri_problema = $this->Reclamo_no_facturacion_model->get_descri_reclamo($reclamo);
                //var_dump($conciliacion);
                //var_dump($reclamo);
                //var_dump($descri_problema);
                //exit();
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
                $pdf->AddPage('P', 'A4');
                $pdf->SetAutoPageBreak(false, 0);
                $resultado = $this->lib_tcpdf-> imprimir_conciliacion($pdf,$conciliacion,$reclamo,$reclamante,$descri_problema);
                $resultado->Output('Ficha_reclamo.pdf', 'I'); 
            }
        }

        public function buscar_reclamo(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $id = $this->input->post('documento');
                $resultado = $this->Reclamo_no_facturacion_model->get_reclamo_concilia($id);
                $hora_sistema = date("H:i:s A");
                if( count($resultado) > 0 ){
                    if(count($resultado) == 1){
                        $Hora_inicio = $this->Reclamo_no_facturacion_model->get_hora_consumo($resultado[0]);
                        $reclamante = $this->Reclamo_no_facturacion_model->get_reclamante_concilia($resultado[0]['PRECOD']);
                        $json = array('result' => true,  'suministros' => $resultado, 'hora' => $hora_sistema, 'hora_concilia' => $Hora_inicio['CNCHORINI'], 'reclamante'=> $reclamante );
                    }
                    else{
                        $json = array('result' => true,  'suministros' => $resultado);
                    }
                    
                }else{
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => '-- No se encontro reclamo pendiente para conciliar', 'titulo' => 'CONCILIACIÓN');
                }
                echo json_encode($json);
                return;
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }


        public function guardar_registro_concilia(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $empresa = trim($this->input->post('empre'));
                $oficina = trim($this->input->post('oficod'));
                $area    = trim($this->input->post('arecod'));
                $ctdcod  = trim($this->input->post('ctdco'));
                $doccod  = trim($this->input->post('docCod')); 
                $serie   = trim($this->input->post('ser')); 
                $reclamo = trim($this->input->post('recla'));
                $parametros = array(
                    "CNCFORREC" =>  trim($this->input->post('pro_recla')) ,
                    "CNCFOREPS" =>  trim($this->input->post('pro_eps')),
                    "CNCFORIMP" =>  trim($this->input->post('cost_concilia')),
                    "USRCODCN" =>   $_SESSION['user_id'],
                    "CNCCOD" =>   '1',
                    "CNCFCH" =>     date('d/m/Y'),
                    "CNCHORINI" =>  trim($this->input->post('hora_concilia')) ,
                    "CNCHORINIREAL" =>  trim($this->input->post('hra_inicio')) ,
                    "CNCHORFIN" =>  date("H:i:s"),
                    "CNCPTOSACU" => trim($this->input->post('pto_acuerdo')) ,
                    "CNCPTOSDES" => trim($this->input->post('pto_desacuerdo')) ,
                    "CNCSUBSIS"  =>  trim($this->input->post('rd_subsis_recla')) ,
                    "CNCOBSREC"  =>  trim($this->input->post('observa_recla')),
                    "TPCOCOD"    =>  trim($this->input->post('cod_inter')),
                    //"SCNCOD"     => ,   // PREGUNTAR AL ING
                    "TRACUCOD"   => trim($this->input->post('result_negocia')) ,
                    "CNCPD" =>      trim($this->input->post('rd_conciliador')),
                    "CNCPDDOC" =>   trim($this->input->post('documento_reclamante')),
                    "CNCPDNOM" =>   trim($this->input->post('nom_recla')),
                    "CNCPDDNI" =>   trim($this->input->post('dni_recla')),
                    //"USRCODCONCGE" => 
                );
                $Respuesta = $this->Reclamo_no_facturacion_model->set_conciliacion($empresa, $oficina, $area, $ctdcod, $doccod, $serie, $reclamo, $parametros);

                if($Respuesta){
                    $json = array( 'result' => true, 'mensaje' => 'Se gravo con exito la conciliación', 'tipo' => 'success' );
                    echo json_encode($json);
                }else{
                    $json = array( 'result' => false, 'mensaje' => 'No se pudo gravar los datos', 'tipo' => 'error' );
                    echo json_encode($json);
                }

                return;
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function reclamo_conciliar(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $data = json_decode($_POST['conciliacion']);
                $arreglo  = get_object_vars($data);
                $hora_sistema = date("H:i:s A");
                $Hora_inicio = $this->Reclamo_no_facturacion_model->get_hora_consumo($arreglo);
                $reclamante = $this->Reclamo_no_facturacion_model->get_reclamante_concilia($arreglo['PRECOD']);
                $json = array('result' => true, 'hora' => $hora_sistema, 'hora_concilia' => $Hora_inicio['CNCHORINI'], 'reclamante'=> $reclamante );
                echo json_encode($json);
                return;
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

    }