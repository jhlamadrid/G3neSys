<?php

class Fina_colateral_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['colateral'] = 'FINANCIA_COLATERAL';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['colateral']);
        if(count($permiso)>0){
            $this->data['proceso'] = 'Financiamiento';
            $this->data['menu']['padre'] = 'FINANCIAMIENTO';
            $this->data['menu']['hijo'] = 'FINANCIA_COLATERAL';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }
    
    public function Fina_colateral(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo']);
        if(count($permiso)>0){
            $this->data['view'] = 'Financiamiento/Fina_colateral_view';
            $this->data['breadcrumbs'] = array(array('Financiamiento', 'Financiar Colateral'));
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
        }
        else{
            $codigo_suministro = $this->input->post('suministro');
            $varifica = $this->Financiamiento_model -> suministro_en_proceso_judicial($codigo_suministro);
            if(count($varifica)>0){
                $json = array('result' => false ,'mensaje' => "Suministro se encuentra en proceso Judicial, favor de comunicarse con el area respectiva para que pueda realizar el convenio");
                echo json_encode($json);
                return;
            }else{
                if (strlen($codigo_suministro)==7) {
                    $dato_nombre = $this->Financiamiento_model -> obtengo_dato_nombre_tam7($codigo_suministro);
                    
                    $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam7($codigo_suministro);
                    // CALCULO SI ES DEUDA PROVISIONADA , NO PROVISIONADA O DEL PERIODO
                    if( (count($dato_nombre) == 0) || (count($dato_detalle) == 0) ){
                        $json = array('result' => false ,'mensaje' => "Numero de Suministro NO Encontrado");
                        echo json_encode($json);
                        return;
                    }else{
                        /* EXTRAIGO LOS CONCEPTOS */
                        $dato_bandera_colateral = $this->Financiamiento_model -> Obtengo_bandera_colateral();
                        $conceptos = $this->Financiamiento_model->obtengo_conceptos();
                        $inte_847 = $this->Financiamiento_model->obtengo_interes();
                        $tasa_tam = $this->Financiamiento_model->tasa_interes();
                        $json = array('result' => true ,'tam' =>7, 'nombre' => $dato_nombre[0] , 'detalle' => $dato_detalle[0], 'concepto' => $conceptos, 'Interes_847' => $inte_847[0],'tasa_tam' => $tasa_tam , 'bandera_colateral' => $dato_bandera_colateral[0] );
                        echo json_encode($json);
                        return;
                    }
                        
                }else{
                    if (strlen($codigo_suministro)==11) {
                        $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam11($codigo_suministro);
                        // CALCULO SI ES DEUDA PROVISIONADA , NO PROVISIONADA O DEL PERIODO 
                        if(count($dato_detalle)== 0){
                            $json = array('result' => false ,'mensaje' => "Numero de Suministro NO Encontrado");
                            echo json_encode($json);
                            return;
                        }else{
                            /* EXTRAIGO LOS CONCEPTOS */
                            $dato_bandera_colateral = $this->Financiamiento_model -> Obtengo_bandera_colateral();
                            $conceptos = $this->Financiamiento_model->obtengo_conceptos();
                            $inte_847 = $this->Financiamiento_model->obtengo_interes();
                            $tasa_tam = $this->Financiamiento_model->tasa_interes();
                            $json = array('result' => true ,'tam' =>11 , 'detalle' => $dato_detalle[0], 'concepto' => $conceptos , 'Interes_847' => $inte_847[0], 'tasa_tam' => $tasa_tam , 'bandera_colateral' => $dato_bandera_colateral[0] );
                            echo json_encode($json);
                            return;
                        }
                    }
                }
            }
              
        }
    }

    public function busca_suministro_judicial(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $codigo_suministro = $this->input->post('suministro');
            
            if (strlen($codigo_suministro)==7) {
                $dato_nombre = $this->Financiamiento_model -> obtengo_dato_nombre_tam7($codigo_suministro);
                $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam7($codigo_suministro);
                // CALCULO SI ES DEUDA PROVISIONADA , NO PROVISIONADA O DEL PERIODO
                if( (count($dato_nombre) == 0) || (count($dato_detalle) == 0) ){
                    $json = array('result' => false ,'mensaje' => "Numero de Suministro NO Encontrado");
                    echo json_encode($json);
                    return;
                }else{
                    
                    $json = array('result' => true ,'tam' =>7, 'nombre' => $dato_nombre[0] , 'detalle' => $dato_detalle[0] );
                    echo json_encode($json);
                    return;
                }
                        
            }else{
                if (strlen($codigo_suministro)==11) {
                    $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam11($codigo_suministro);
                        // CALCULO SI ES DEUDA PROVISIONADA , NO PROVISIONADA O DEL PERIODO 
                    if(count($dato_detalle)== 0){
                        $json = array('result' => false ,'mensaje' => "Numero de Suministro NO Encontrado");
                        echo json_encode($json);
                        return;
                    }else{
                        /* EXTRAIGO LOS CONCEPTOS */
                        $conceptos = $this->Financiamiento_model->obtengo_conceptos();
                        $inte_847 = $this->Financiamiento_model->obtengo_interes();
                        $tasa_tam = $this->Financiamiento_model->tasa_interes();
                        $json = array('result' => true ,'tam' =>11 , 'detalle' => $dato_detalle[0], 'concepto' => $conceptos , 'Interes_847' => $inte_847[0], 'tasa_tam' => $tasa_tam );
                        echo json_encode($json);
                        return;
                    }
                }
            }
            
              
        }
    }
    public function grabo_datos(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            $oficina = $this->input->post('ofi');
            $agencia = $this->input->post('age');
            $suministro = $this->input->post('sumi');
            $nombre = $this->input->post('nom');
            $direccion  = $this->input->post('dire');
            $monto = $this->input->post('mont');
            $numero_cuota = $this->input->post('numero_cuota');
            $mont_inicial = $this->input->post('mont_inicial');
            $capital_financiar = $this->input->post('capital_financiar');
            $concep = $this->input->post('concep');
            $tas_interes = $this->input->post('tas_interes');
            $servidor = $this->input->post('servi');
            $letras = $this->input->post('letras');
            $referencia = $this->input->post('refe');
            $texto_concepto = $this->input->post('texto_concepto');
            $tasa_frc = $this->input->post('tasa_frc');
            $fecha = $this->input->post('fecha');
            //var_dump($letras);
            //exit();
            $respuesta = $this->Financiamiento_model -> Grabar_Colateral($oficina, $agencia, $suministro, $nombre, $direccion, $monto, $numero_cuota, $mont_inicial, $capital_financiar, $concep, $tas_interes, $letras, $servidor, $referencia, $texto_concepto, $tasa_frc, $fecha);
            
            if($respuesta[0]){
                $json = array('result' => true ,'respuesta' => $respuesta );
                echo json_encode($json);
                return;
            }
        }
    }

    public function grabo_archivos(){
        if (empty($_FILES['titular-es'])) {
            $output = array('estado' => 'ok' ,
                            'mensaje' => 'no se pudieron cargar los archivos'
                           );
            echo json_encode($output);             
            return; // terminate
        }else{
            //recibo los archivos y datos 
            $archivos = $_FILES['titular-es'];
            $paths= [];
            $nombre_archivos = $archivos['name'];
            $suministro = empty($_POST['num_suministro']) ? '' : $_POST['num_suministro'];   
            $nro_credito = empty($_POST['num_credito']) ? '' : $_POST['num_credito']; 
            $fecha_registro = date("Y-m-d");
            $nombre_financiamiento = "colateral-credi_".$nro_credito."-".$suministro."-".$fecha_registro;
            $dire ='assets/uploads/financiamiento/'.$nombre_financiamiento;
            // creo la carpeta para financiamiento
            if(mkdir( $dire, 0777, true)){
                if(mkdir($dire.'/titular', 0777, true)){
                    // GUARDO LOS ARCHIVOS 
                    $success = null;
                    $dire_tabla = "";
                    for($i=0; $i < count($nombre_archivos); $i++){
                        $ext = explode('.', basename($nombre_archivos[$i]));
                        $target = $dire.'/titular/'.$suministro.'-'.str_pad(($i+1), 4, "0", STR_PAD_LEFT) . "." . array_pop($ext);
                        if(move_uploaded_file($archivos['tmp_name'][$i], $target)) {
                            $success = true;
                            $paths[] = $target;
                            if($i == 0 ){
                                $dire_tabla = $dire_tabla.$target;
                            }else{
                                $dire_tabla = $dire_tabla."*****".$target;
                            }
                        } else {
                            $success = false;
                            break;
                        }
                    }
                    // VERIFICO
                    if ($success === true) {
                        $varifica = $this->Financiamiento_model ->guardo_dire_titula($suministro,$nro_credito,$dire_tabla);
                        $output = array('estado' => 'OK',
                                        'ruta' =>$dire 
                                        );
                    }
                    echo json_encode($output);
                
                }
            }
        }
    }

    public function reporte_cronograma(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
        
            $array = json_decode($this->input->post('reporte_cronograma'),true);
            //var_dump($array);
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
            //var_dump($array);
            $resultado = $this->lib_tcpdf-> colateral_cronograma($pdf, $array[0],$array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7], $array[8], $array[9], $array[10], $array[11], $array[12] );
            $resultado->Output('reporte_cronograma.pdf', 'I'); 
        } 
    }
    
}


?>