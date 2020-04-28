<?php 
class Ordenes_Trabajo_ctrllr extends CI_Controller{
    public function __construct() { 
        parent::__construct();
        $this->load->model('facturacion/Ordenes_Trabajo_model'); 
        $this->load->model('siac/Ordenes_Trabajo_SIAC_model'); 
        $this->load->library('session'); 
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();  
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['actividad'] = 'ordenes_trabajo'; 
        $this->data['rol'] = $this->Ordenes_Trabajo_model->get_rol($_SESSION['user_id']); 
        $this->data['userdata'] = $this->acceso_cls->get_userdata(); 
        $permiso = $this->Ordenes_Trabajo_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
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
    public function ver(){
        $permiso = $this->Ordenes_Trabajo_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
        if($permiso){
            $ordenes = $this->Ordenes_Trabajo_SIAC_model->get_ordenes_registradas();
            foreach($ordenes as $key => $o){
                $ciclos = $this->Ordenes_Trabajo_SIAC_model->getCiclosxOrden($o['OrtId']);
                $ordenes[$key]['ciclos'] = $ciclos;
            } 
            $this->data['ordenes'] = $ordenes;
            $this->data['ciclos'] = $this->Ordenes_Trabajo_model->get_ciclos();
            $this->data['view'] = 'facturacion/Ordenes_Trabajo_view';
            $this->data['breadcrumbs'] = array(array('ORDENES DE TRABAJO', ''));
            $this->load->view('template/Master', $this->data);
        } else {
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return; 
        }
    }
    public function generar(){
        $permiso = $this->Ordenes_Trabajo_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
        if($permiso){
            $ajax = $this->input->get('token');
            if($ajax){
                $periodo = $this->input->post('periodo');
                $ciclos = $this->input->post('ciclos');
                $fechaInspeccion = $this->input->post('fechaInspeccion');
                $cantxhoras = $this->input->post('cantxhoras');
                $descripcion = $this->input->post('descripcion');
                $observaciones = $this->input->post('observaciones');
                $maxEntregaNot = $this->input->post('maxEntregaNot');
                $maxEntregaIns = $this->input->post('maxEntregaIns');
                $resp = $this->Ordenes_Trabajo_model->get_fecha_apta($fechaInspeccion);
                if($resp){
                    $carga = $this->Ordenes_Trabajo_model->get_carga_x_ciclo($ciclos,$periodo);
                    if(sizeof($carga) > 0) { 
                        foreach($carga as $key => $c){
                            $datos = $this->Ordenes_Trabajo_model->get_dato_x_cliente($c['CLICODFAC']);
                            $localizacion = $this->Ordenes_Trabajo_model->get_localic_provi($datos['PREREGION'],$datos['PRELOCALI']);
                            $carga[$key]['TARIFA'] = $datos['TARIFA'];
                            $carga[$key]['DNI'] = $datos['CLIELECT'];
                            $carga[$key]['RUC'] = $datos['CLIRUC'];
                            $carga[$key]['TELEFONO'] = $datos['CLICOBTEL'];
                            $carga[$key]['PROVINCIA'] = $localizacion['PROVINDES'];
                            $carga[$key]['LOCALIDAD'] = $localizacion['LOCDES'];
                        }
                        $numSub = intval(sizeof($carga)/48);
                        if(sizeof($carga) % 48 > 0) $numSub++;
                        $numSubInsp = intval(sizeof($carga) / 24);
                        if(sizeof($carga) % 24 > 0) $numSubInsp++;
                        $resp1 = $this->Ordenes_Trabajo_SIAC_model->insert_carga_notificacion($periodo, $descripcion, $observaciones,$resp,$maxEntregaNot,$numSub,$carga,$fechaInspeccion,$cantxhoras,$maxEntregaIns,$numSubInsp);
                        if($resp1){
                            $json = array('result' => true, 'mensaje' => 'ok');
                            header('Access-Control-Allow-Origin: *');
                            header('Content-Type: application/x-json; charset=utf-8');
                            echo json_encode($json);
                        } else {
                            $json = array('result' => false, 'mensaje' => 'error');
                            header('Access-Control-Allow-Origin: *');
                            header('Content-Type: application/x-json; charset=utf-8');
                            echo json_encode($json);
                        }
                    } else {
                        $json = array('result' => false, 'mensaje' => 'error');
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
                } else {
                    $json = array('result' => false, 'mensaje' => 'Debe seleccionar una fecha para la inspección hábil');
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
    
}