<?php

class Tramite_judicial_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['judicial'] = 'FINANCIA_COLATERAL';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['judicial']);
        if(count($permiso)>0){
            $this->data['proceso'] = 'Financiamiento';
            $this->data['menu']['padre'] = 'FINANCIAMIENTO';
            $this->data['menu']['hijo'] = 'tram_judicial';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function inicio(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo']);
        if(count($permiso)>0){
            $this->data['view'] = 'Financiamiento/Tramite_judicial_view';
            $this->data['breadcrumbs'] = array(array('Tramite Judicial', 'financiamiento/tramite_judicial'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function nuevo(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo']);
        if(count($permiso)>0){
            $this->data['view'] = 'Financiamiento/Tramite_judicial_nuevo_view';
            $this->data['breadcrumbs'] = array(array('Tramite Judicial', 'financiamiento/tramite_judicial'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function suministros(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $fecha_inicio = $this->input->post('f_inicio');
            $fecha_fin = $this->input->post('f_fin');

            $respuesta = $this->Financiamiento_model -> suministro_en_tramite($fecha_inicio, $fecha_fin);
            if(count($respuesta)>0){
                $json = array('result' => true , 'respuesta' => $respuesta );
                echo json_encode($json);
                return;
            }else{
                $json = array('result' => false , 'mensaje' => "No se encontro suministros" );
                echo json_encode($json);
                return; 
            }
        }
    }

    public function suministro_editar(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $suministro = $this->input->post('suministro');
            //var_dump($suministro);
            $respuesta = $this->Financiamiento_model -> suministro_judicial_editar($suministro);
            if(count($respuesta)>0){
                $json = array('result' => true , 'respuesta' => $respuesta );
                echo json_encode($json);
                return;
            }
        }
    }

    public function suministro_guardar(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $datos = array();
            $datos[0]=$suministro = $this->input->post('suministro');
			$datos[1]=$nombre= $this->input->post('nombre');
            $datos[2]=$direccion = $this->input->post('direccion');
            $datos[3]=$localidad = $this->input->post('localidad');
            $datos[4]=$conex_agua = $this->input->post('conex_agua');
            $datos[5]=$conex_desague = $this->input->post('conex_desague');
            $datos[6]=$estado_cliente = $this->input->post('estado_cliente');
            $verifico = $this->Financiamiento_model -> suministro_judicial_editar($suministro);
            if(count($verifico)>0){
                $json = array('result' => false , 'Mensaje' => "Suministro ya fue gravado anteriormente" );
                echo json_encode($json);
                return; 
            }else{
                $respuesta = $this->Financiamiento_model -> suministro_judicial_nuevo($datos);
                if($respuesta){
                    $json = array('result' => true , 'Mensaje' => "Datos Guardados Correctamente" );
                    echo json_encode($json);
                    return;
                }else{
                    $json = array('result' => false , 'Mensaje' => "No se pudieron guardar los Datos" );
                    echo json_encode($json);
                    return; 
                }
            }
            

        }
    }

    public function suministro_guarda_edicion(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $suministro = $this->input->post('suministro');
            $estado = $this->input->post('estado');
            if($estado == "EN TRAMITE"){
                $estado = 0;
            }else{
                $estado = 1;
            }
            $respuesta = $this->Financiamiento_model -> guardar_judicial_edicion($suministro, $estado );
            if($respuesta ){
                $json = array('result' => true , 'respuesta' => $respuesta );
                echo json_encode($json);
                return;
            }
        }
    }
    
}
?>