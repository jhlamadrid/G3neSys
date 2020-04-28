<?php

class Anula_Convenio_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['menu']['padre'] = 'FINANCIAMIENTO';
        $this->data['proceso'] = 'Financiamiento';
        /*$this->data['Anula_colateral'] = 'ANUCOLATERALES';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['Anula_colateral'] );
        if(count($permiso)>0){
            
            $this->data['menu']['padre'] = 'FINANCIAMIENTO';
            $this->data['menu']['hijo'] = 'ANUCOLATERALES';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }*/
        
    }
    
    public function calculo(){   
        $this->data['menu']['hijo'] = 'ANUCOLATERALES';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso)>0){
            $this->data['view'] = 'Financiamiento/Anula_Colateral_view';
            $this->data['breadcrumbs'] = array(array('Financiamiento', 'ANULA COLATERAL'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function busca_suministro(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $codigo_suministro = $this->input->post('suministro');
            $tipo_convenio = $this->input->post('tipo');
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_final  = $this->input->post('fecha_final');
            if (strlen($codigo_suministro)==7) {
                $dato_nombre = $this->Financiamiento_model -> obtengo_dato_nombre_tam7($codigo_suministro);
                $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam7($codigo_suministro);
                if ($dato_detalle) {
                    if ($tipo_convenio != 'Y') {
                        $Creditos = $this->Financiamiento_model -> Obtener_Credito_extorno($codigo_suministro, $tipo_convenio, $fecha_inicio, $fecha_final );
                        $json = array('result' => true ,'tam' =>11 , 'detalle' => $dato_detalle , 'respuesta' => $Creditos );
                        echo json_encode($json);
                        return;
                    }else{
                        
                        $Creditos = $this->Financiamiento_model -> Obtener_credito($codigo_suministro, $tipo_convenio, $fecha_inicio, $fecha_final );
                        $json = array('result' => true ,'tam' =>7 , 'detalle' => $dato_detalle , 'respuesta' => $Creditos);
                        echo json_encode($json);
                        return;
                    }
                    
                }
            }else{
                if (strlen($codigo_suministro)==11) {
                    $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam11($codigo_suministro);
                    if ($dato_detalle) {
                        if ($tipo_convenio != 'Y') {
                            $Creditos = $this->Financiamiento_model -> Obtener_Credito_extorno($codigo_suministro, $tipo_convenio, $fecha_inicio, $fecha_final );
                            $json = array('result' => true ,'tam' =>11 , 'detalle' => $dato_detalle , 'respuesta' => $Creditos );
                            echo json_encode($json);
                            return;
                        }else{
                            $Creditos = $this->Financiamiento_model -> Obtener_credito($codigo_suministro, $tipo_convenio, $fecha_inicio, $fecha_final );
                            $json = array('result' => true ,'tam' =>7 , 'detalle' => $dato_detalle , 'respuesta' => $Creditos);
                            echo json_encode($json);
                            return;
                        }
                        
                    }
                } 
            }
        }
    }


    public function busca_letras (){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $Dato_tabla = $this->input->post('Datos_tabla');

            if(count($Dato_tabla) > 0){
                $i =0;
                while($i < count($Dato_tabla)){
                    $Numero_letras[$i] = $this->Financiamiento_model -> obtengo_Letras($Dato_tabla[$i]);
                    $i++;
                }

                $json = array('result' => true ,'tam' =>11 ,'respuesta' => $Numero_letras );
                echo json_encode($json);
                return;


                
            }
        }  
    }

    public function ejecuta_proceso(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
           $Dato_tabla = $this->input->post('Datos_tabla'); 
           $tipo_deuda = $this->input->post('tipo_deuda'); 
           $suministro =  $this->input->post('suministro');
           $referencia =  $this->input->post('referencia');

           if($tipo_deuda == 'Z'){
                //EXTORNA LA DEUDA
                //var_dump("reviritiendo deuda");
                //exit();
                $i = 0;
                while ( $i < count($Dato_tabla) ) {
                    $respuesta  = $this->Financiamiento_model -> Extorno_deuda($Dato_tabla[$i], $suministro, $referencia);
                    $i++;
                }

                if ($respuesta) {

                    $json = array('result' => true , 'respuesta' => $respuesta );
                    echo json_encode($json);
                    return;

                }else{
                    $json = array('result' => false , 'mensaje' =>  " NO SE PUDO MODIFICAR LA DATA" );
                    echo json_encode($json);
                    return;                    
                }

           }else{
                //ANULACION DE COLATERALES
                $i = 0;
                while ( $i < count($Dato_tabla) ) {
                    $respuesta  = $this->Financiamiento_model -> Anular_Colaterales($Dato_tabla[$i], $suministro, $referencia);
                    if($respuesta == false){
                        break;
                    }
                    $i++;
                }
                
                if ($respuesta) {
                    $json = array('result' => true , 'respuesta' => $respuesta );
                    echo json_encode($json);
                    return;
                }else{
                    $json = array('result' => false , 'mensaje' =>  "NO SE PUDO MODIFICAR LA DATA" );
                    echo json_encode($json);
                    return;   
                }
            }

        }
    }

    public function autorizo_extorno(){
        
        $this->data['EXTORN_RECIBO'] = 'EXTORN_RECIBO';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['EXTORN_RECIBO'] );
        if(count($permiso)>0){
            $this->data['proceso'] = 'PAGAR LA INICIAL DE UN CONVENIO';
            $this->data['titulo'] = 'LISTA DE FINANCIAMIENTO DE RECIBOS A EXTORNAR';
            $this->data['menu']['hijo'] = 'EXTORN_RECIBO';
            //$this->data['pagados'] = $this->Financiamiento_model->get_all_pagados();
            $respuesta = $this->Financiamiento_model->get_all_pagados();
            
            $i=0;
            while($i <count($respuesta)){
                $permiso = $this->Financiamiento_model->get_permiso_fina($respuesta[$i]['OFICOD'],$respuesta[$i]['OFIAGECOD'],$respuesta[$i]['CREDNRO']);
                if(count($permiso)>0){
                    $respuesta[$i]['GENERADO'] = 1;
                }else{
                    $respuesta[$i]['GENERADO'] = 0;
                }
                $i++;
            }
            $this->data['pagados'] = $respuesta ; 
            $this->data['view'] = 'Financiamiento/Ver_recibos_extorn_view';
            $this->data['breadcrumbs'] = array(array('ver_pagos', 'autoriza/extorno/recibo'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function genero_extorno($oficina, $agencia, $num_credito){
        $this->data['EXTORN_RECIBO'] = 'EXTORN_RECIBO';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['EXTORN_RECIBO'] );
        if(count($permiso)>0){
            $this->load->model('autorizacion/Autorizacion_model');
            $this->data['proceso'] = 'DETALLE DEL CONVENIO A EXTORNAR';
            $this->data['titulo'] = 'LISTA DE FINANCIAMIENTO DE RECIBOS A EXTORNAR';
            $this->data['menu']['hijo'] = 'EXTORN_RECIBO';
            $this->data['datos_user'] = $this->Financiamiento_model->get_pago_inicial($oficina, $agencia, $num_credito);
            $this->data['view'] = 'Financiamiento/Detalle_autoriza_view';
            $this->data['usuarios'] = $this->Autorizacion_model->get_usuarios_nc_recibos();
            $this->data['breadcrumbs'] = array(array('ver_pagos', 'autoriza/extorno/recibo'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
    }

    public function gravo_autorizacion(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $oficina = $this->input->post('ofic');
            $agencia = $this->input->post('agen');
            $numero_credito = $this->input->post('num_credit');
            $observacion = $this->input->post('obser');
            $operador = $this->input->post('usuario_ejecutor');
            $resultado = $this->Financiamiento_model->grabar_autorizacion($oficina, $agencia, $numero_credito, $observacion, $operador);
            if($resultado[0]== true){
                $json = array('result' => true ,'mensaje' => "SE GRABÓ LA AUTORIZACIÓN", 'tipo' => "success");
                echo json_encode($json);
                return;
            }else{
                $json = array('result' => false ,'mensaje' => "NO SE PUDO GRABAR LA AUTORIZACIÓN", 'tipo' => "error");
                echo json_encode($json);
                return;
            }
            
        }
    }

    
    
}