<?php

class Concepto_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('general/Catalogo_model');
        $this->load->model('boleta_factura/Conceptos_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['userdata']['oficina'] = $this->Catalogo_model->get_oficina($this->data['userdata']['NSOFICOD']);
        $this->data['userdata']['area'] = $this->Catalogo_model->get_oficina($this->data['userdata']['NSARECOD']);
        
        $this->data['proceso'] = 'Crear Conceptos';
        $this->data['menu']['padre'] = 'comprobantes';
        $this->data['menu']['hijo'] = 'CREA_CONCEPTO';
           
    }

    public function inicio(){
        $this->data['view'] = 'boleta_factura/Crea_concepto_view';
        $this->data['titulo'] = 'Crear Concepto';
        $this->data['conceptos'] = $this->Conceptos_model->get_conceptos();
        $this->data['tipo_afectacion_igv'] = $this->Catalogo_model->get_tipo_afectacion();
        $this->data['breadcrumbs'] = array(array('Concepto', ''));
        $this->load->view('template/Master', $this->data);
    }

    public function filtrar(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax');
            echo json_encode($json);
            return;
        }
        $valor = (int) $this->input->post('valor_filtro');
        if($valor == 1){
            $conceptos_filtrados = $this->Conceptos_model->get_conceptos();
        }else{
            $conceptos_filtrados =  $this->Conceptos_model->get_conceptos_filtrados(1);
        }
        $json = array('result' => true, 'conceptos_filtrados' => $conceptos_filtrados);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
        
    }

    private function sanear_string($string) {
     
        $string = trim($string);
     
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
     
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
     
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
     
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
     
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
     
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
     
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "<code>", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":",
                 "."),
            '',
            $string
        );
     
     
        return $string;
    }

    public function guardar(){
        
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax');
            echo json_encode($json);
            return;
        }

        $concep_codigo = $this->input->post('concep_codigo');
        $concep_precio = $this->input->post('concep_precio');
        $concep_codigo_contable = $this->input->post('concep_codigo_contable');
        $concep_descrip = $this->input->post('concep_descrip');
        $afecta_tipo = $this->input->post('afecta_tipo');
        $Grat = $this->input->post('Grat');
        $Estado_concepto = $this->input->post('Est_concep');
        $descripcion=  $this->sanear_string($concep_descrip);
        if($Grat){
            $Gratuito = 1;
        }else{
            $Gratuito = 0;
        }

        $gravado = 0;
        $exonerado = 0;
        $inafecto  = 0;

        if($afecta_tipo >=10 && $afecta_tipo <=17){
            $gravado = 'S';
        }else{
            $gravado = 'N';
        }

        if($afecta_tipo >=20 && $afecta_tipo <=21){
            $exonerado = 1;
        }

        if($afecta_tipo >=30 && $afecta_tipo <=36){
            $inafecto = 1;
        }
        /* VERIFICAR SI ES QUE EXISTE  */
        $rpta_existe = $this->Conceptos_model->Existe_concepto($concep_codigo);
        if(count($rpta_existe)>0){
            $json = array('result' => false, 'mensaje' => "No se pudo ingresar CODIGO de concepto existe ");
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }else{
            $rpta_guardado =  $this->Conceptos_model->Guarda_concepto($concep_codigo, $concep_precio, $concep_codigo_contable, $descripcion, $afecta_tipo, $Gratuito,$gravado,$exonerado,$inafecto,$Estado_concepto);
            if($rpta_guardado){
                $json = array('result' => true, 'mensaje' => "Concepto Ingresado Correctamente");
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }else{
                $json = array('result' => false, 'mensaje' => "No se pudo insertar el concepto ");
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
        }
        
        
    }

    public function editar(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax');
            echo json_encode($json);
            return;
        }
        $concep_codigo = $this->input->post('valor_concepto');
        $rpta_existe = $this->Conceptos_model->Existe_concepto($concep_codigo);
        if(count($rpta_existe)>0){
            $json = array('result' => true, 'rpta' => $rpta_existe);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }

    }


    public function guarda_edicion(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax');
            echo json_encode($json);
            return;
        }
        $concep_codigo = $this->input->post('concep_codigo');
        $concep_precio = $this->input->post('concep_precio');
        $concep_codigo_contable = $this->input->post('concep_codigo_contable');
        $concep_descrip = $this->input->post('concep_descrip');
        $afecta_tipo = $this->input->post('afecta_tipo');
        $Grat = $this->input->post('Grat');
        $Estado_concepto = $this->input->post('Est_concep');
        $descripcion=  $this->sanear_string($concep_descrip);
        if($Grat){
            $Gratuito = 1;
        }else{
            $Gratuito = 0;
        }

        $gravado = 0;
        $exonerado = 0;
        $inafecto  = 0;

        if($afecta_tipo >=10 && $afecta_tipo <=17){
            $gravado = 'S';
        }else{
            $gravado = 'N';
        }

        if($afecta_tipo >=20 && $afecta_tipo <=21){
            $exonerado = 1;
        }

        if($afecta_tipo >=30 && $afecta_tipo <=36){
            $inafecto = 1;
        }
        $rpta_guardado_edicion =  $this->Conceptos_model->Guarda_edicion_concepto($concep_codigo, $concep_precio, $concep_codigo_contable, $descripcion, $afecta_tipo, $Gratuito,$gravado,$exonerado,$inafecto,$Estado_concepto);
        
        if($rpta_guardado_edicion){
            $json = array('result' => true, 'rpta' => 'Edicion Exitosa');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }

}

?>