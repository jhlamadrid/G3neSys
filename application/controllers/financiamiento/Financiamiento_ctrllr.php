<?php

class Financiamiento_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['financiamiento'] = 'FINANCIA_RECIBOS';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['financiamiento'] );
        if(count($permiso)>0){
            $this->data['proceso'] = 'Financiamiento';
            $this->data['menu']['padre'] = 'FINANCIAMIENTO';
            $this->data['menu']['hijo'] = 'FINANCIA_RECIBOS';
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }
    
    public function calculo(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso)>0){
            $this->load->model('general/Catalogo_model');
            $this->data['tipo_via'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(25);
            $this->data['codigo_zona'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(26);
            $this->data['rutabsq1'] = 'https://cel.reniec.gob.pe/valreg/valreg.do;jsessionid=97657851cf84a1b5e8e57db400289a1dfe6deb1635f.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaMa3D3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaPb3aPbhiTbN4xf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_';
            $this->data['modal_persona'] = 'propie/Registra_persona_financia_view';
            $this->data['view'] = 'Financiamiento/financiamiento_view';
            $this->data['breadcrumbs'] = array(array('Financiamiento', ''));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }
    private function verifico_rec_pendiente_pago($deuda,$rec_pendiente){
        $i = 0;
        $conta_temporal = 0;
        $temporal  = array();
        while ( $i < count($deuda)){
            if( (float)$deuda[$i]['DIASVENCID'] == 0){
                if( $rec_pendiente == 1 ){
                    $temporal[$conta_temporal] = $deuda[$i]; 
                    $conta_temporal = $conta_temporal + 1 ;    
                }
            }else{
                $temporal[$conta_temporal] = $deuda[$i]; 
                $conta_temporal = $conta_temporal + 1 ; 
            }
            $i++;
        }

        return  $temporal ; 
    }

    private function verifico_reclamo_vigente( $deuda, $reclamo_vigente){
        $i = 0;
        $conta_temporal = 0;
        $temporal  = array();
        while ( $i < count($deuda)){
            $verifico_reclamo = $this->Financiamiento_model -> veri_reclamo($deuda[$i]['FACSERNRO'] , $deuda[$i]['FACNRO']);
            if($reclamo_vigente == 1){
                $temporal[$conta_temporal] = $deuda[$i]; 
                $conta_temporal = $conta_temporal + 1 ; 
            }else{
                if(count($verifico_reclamo) > 0){
                    if($verifico_reclamo[0]['SRECCOD'] == 2  && $verifico_reclamo[0]['SSITCOD'] == 2 ){
                        $temporal[$conta_temporal] = $deuda[$i]; 
                        $conta_temporal = $conta_temporal + 1 ;
                    }
                }else{
                    $temporal[$conta_temporal] = $deuda[$i]; 
                    $conta_temporal = $conta_temporal + 1 ;
                }
            }
            $i++;
        }

        return $temporal;
    }
    private function verifico_tip_financiamiento ($dato_deuda){
        $anio = date("Y");
        $anio_base  = $anio ;
        $i = 0;
        while($i < count($dato_deuda) ){
            $anio_recibo = substr($dato_deuda[0]['FACEMIFEC'],6, strlen($dato_deuda[0]['FACEMIFEC']) ) ;
            if((int)$anio > (int)$anio_recibo){
                $anio = $anio_recibo;
            }
            $i++;
        }
        $tipo_fi = (int)$anio_base - (int)$anio;
        if($tipo_fi==0){
            $datpar = 11;
        }
        if ($tipo_fi==1) {
            $datpar = 10;
        }
        if($tipo_fi>=2){
         $datpar = 9;   
        }

        return $datpar;
    }
    public function buscar_suministro(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }
        else{
            // codigo de suministro 
            $codigo_suministro = $this->input->post('codigo_suministro');
            // los tipos de recibo a extraer (con reclamo y que aun no vencen )
            // y las cuotas pendientes 
            $rec_pendiente = $this->input->post('rec_pendiente');
            $reclamo_vigente = $this->input->post('reclamo_vigente');
            $cuot_pendiente = $this->input->post('cuot_pendiente');
            $varifica = $this->Financiamiento_model -> suministro_en_proceso_judicial($codigo_suministro);
            if(count($varifica)>0){
                $json = array('result' => false ,'mensaje' => "Suministro se encuentra en proceso Judicial, favor de comunicarse con el area respectiva para que pueda realizar el convenio");
                    echo json_encode($json);
                        return;
            }else{
                if (strlen($codigo_suministro)==7) {
                    $dato_nombre = $this->Financiamiento_model -> obtengo_dato_nombre_tam7($codigo_suministro);
                    $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam7($codigo_suministro);
                    if((count($dato_nombre)==0) || (count($dato_detalle)== 0)){
                        $json = array('result' => false ,'mensaje' => "Numero de Suministro NO Encontrado");
                        echo json_encode($json);
                        return;
                    }else{
                        //+++++++++++
                        $Suministro_relacionados = $this->Financiamiento_model -> sum_relacionados($codigo_suministro);
                        $i = 0;
                        $bandera = 0;  
                        $conta_deuda = 0;
                        $recibos_en_deuda = array();
                        while($i<count($Suministro_relacionados)){
                            $dato_deuda_recibo = $this->Financiamiento_model -> obtengo_deuda($Suministro_relacionados[$i]['CLICODFAC']);
                            if(count($dato_deuda_recibo)>0){
                                $bandera = 1;
                                $recibos_en_deuda[$conta_deuda] = $dato_deuda_recibo[0]; 
                                $conta_deuda = $conta_deuda + 1;
                            }
                            $i++;
                        }
                        //+++++++++++
                        if($bandera == 0){
                            // VERIFICO SI ES QUE ES ENTIDAD PUBLICA 
                            $dato_publico = $this->Financiamiento_model -> get_entidad_publica($codigo_suministro);
                            $es_entidad = 0;
                            if( count($dato_publico) > 0 ){
                                $es_entidad = 1;
                            }
                            $dato_deuda = $this->Financiamiento_model -> obtengo_deuda($codigo_suministro);
                           
                            // VERIFICO RECIBO PENDIENTE DE PAGO 
                            $dato_deuda = $this->verifico_rec_pendiente_pago($dato_deuda,$rec_pendiente);
                            //VERIFICO RECLAMO VIGENTE
                            $dato_deuda = $this->verifico_reclamo_vigente( $dato_deuda, $reclamo_vigente);
                            // CALCULO SI ES DEUDA PROVISIONADA , NO PROVISIONADA O DEL PERIODO
                            
                            //** TIPOS DE PLANES 
                            $dato_tipo_financiamiento = $this->Financiamiento_model->tipo_financimiento();
                            $datpar = $this->verifico_tip_financiamiento ($dato_deuda);
                            
                            $plan_financiamiento = $this ->Financiamiento_model -> obtengo_planes_financiamiento($dato_detalle[0]["TARIFA"], $dato_detalle[0]["AMBCOD"], count($dato_deuda),$datpar);
                            $observaciones = $this->Financiamiento_model -> obtengo_Observaciones();
                            $gerente_actual = $this->Financiamiento_model -> get_gerente();
                            $credito_1_cuota = $this->Financiamiento_model -> get_fecha_12meses($codigo_suministro);
                            $credito_Pendiente =  array();
                            if($cuot_pendiente == 1){
                                $credito_Pendiente = $this->Financiamiento_model -> Credit_prendiente($codigo_suministro);
                                //var_dump($credito_Pendiente);
                            }
                            //$gerente_actual = $this->Financiamiento_model -> get_gerente();
                            $tasa_inte =  $this->Financiamiento_model -> tasa_interes();
                            if (count($dato_nombre) >=1 && count($dato_detalle) >=1) {
                                //$json = array('result' => true ,'tam' =>7, 'nombre' => $dato_nombre , 'detalle' => $dato_detalle[0] , 'deuda' => $dato_deuda , 'plan_financiamiento' => $plan_financiamiento, 'observaciones' => $observaciones, 'credito_Pendiente' => $credito_Pendiente, 'tasa_interes' => $tasa_inte, 'tipo_financiamiento' => $datpar, 'gerente' => $gerente_actual, 'nota_credito_debito' => $dato_nota_credito_debito, 'credit_1_cuota' => $credito_1_cuota );
                                $json = array('result' => true ,'tam' =>7, 'nombre' => $dato_nombre , 'detalle' => $dato_detalle[0] , 'deuda' => $dato_deuda , 'plan_financiamiento' => $plan_financiamiento, 'observaciones' => $observaciones, 'credito_Pendiente' => $credito_Pendiente, 'tasa_interes' => $tasa_inte, 'tipo_financiamiento' => $datpar, 'gerente' => $gerente_actual,  'credit_1_cuota' => $credito_1_cuota, 'es_entidad' => $es_entidad, 'entidad_publica' => $dato_publico );
                                echo json_encode($json);
                                return;
                            }
                        }else{
                            $json = array('result' => false ,'mensaje' => "Existen deudas en las unidades de uso, no podrá hacer financiamiento hasta que dichas deudas sean regularizadas" , 'recibos_deuda' => $recibos_en_deuda, 'nombre_usuario' => $dato_nombre);
                            echo json_encode($json);
                            return;
                        }

                    }
                    
                    
                    
                }else{
                    if (strlen($codigo_suministro)==11) {
                        $dato_deuda = $this->Financiamiento_model -> obtengo_deuda($codigo_suministro);
                        $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam11($codigo_suministro);
                        //$dato_nota_credito_debito = $this->Financiamiento_model -> buscar_nota_credito_debito($codigo_suministro);
                        if(count($dato_detalle)== 0){
                            $json = array('result' => false ,'mensaje' => "Numero de Suministro NO Encontrado");
                            echo json_encode($json);
                            return;
                        }
                        // VERIFICO SI ES QUE ES ENTIDAD PUBLICA 
                        $dato_publico = $this->Financiamiento_model -> get_entidad_publica($codigo_suministro);
                        $es_entidad = 0;
                        if( count($dato_publico) > 0 ){
                            $es_entidad = 1;
                        }
                        // VERIFICO RECIBO PENDIENTE DE PAGO 
                        $dato_deuda = $this->verifico_rec_pendiente_pago($dato_deuda,$rec_pendiente);
                        //VERIFICO RECLAMO VIGENTE
                        $dato_deuda = $this->verifico_reclamo_vigente( $dato_deuda, $reclamo_vigente);      
                        //** TIPOS DE PLANES 
                        $dato_tipo_financiamiento = $this ->Financiamiento_model->tipo_financimiento();
                        // CALCULO SI ES DEUDA PROVISIONADA , NO PROVISIONADA O DEL PERIODO 
                        $datpar = $this->verifico_tip_financiamiento ($dato_deuda);
                        
                        $plan_financiamiento = $this ->Financiamiento_model -> obtengo_planes_financiamiento($dato_detalle[0]["TARIFA"], $dato_detalle[0]["AMBCOD"], count($dato_deuda),$datpar);
                        $observaciones = $this->Financiamiento_model -> obtengo_Observaciones();
                        $credito_1_cuota = $this->Financiamiento_model -> get_fecha_12meses($codigo_suministro);
                        $credito_Pendiente =  array();
                        if($cuot_pendiente == 1){
                            $credito_Pendiente = $this->Financiamiento_model -> Credit_prendiente($dato_detalle[0]["CLICODFAC"]);
                        }
                        $gerente_actual = $this->Financiamiento_model->get_gerente();
                        $tasa_inte =  $this->Financiamiento_model -> tasa_interes();
                        if ( count($dato_detalle) >= 1 ) {
                            //$json = array('result' => true ,'tam' =>11 , 'detalle' => $dato_detalle , 'deuda' => $dato_deuda, 'plan_financiamiento' => $plan_financiamiento, 'observaciones' => $observaciones, 'credito_Pendiente' => $credito_Pendiente, 'tasa_interes' => $tasa_inte, 'tipo_financiamiento' => $datpar, 'gerente' => $gerente_actual, 'nota_credito_debito' => $dato_nota_credito_debito, 'credit_1_cuota' => $credito_1_cuota);
                            $json = array('result' => true ,'tam' =>11 , 'detalle' => $dato_detalle , 'deuda' => $dato_deuda, 'plan_financiamiento' => $plan_financiamiento, 'observaciones' => $observaciones, 'credito_Pendiente' => $credito_Pendiente, 'tasa_interes' => $tasa_inte, 'tipo_financiamiento' => $datpar, 'gerente' => $gerente_actual,  'credit_1_cuota' => $credito_1_cuota, 'es_entidad' => $es_entidad, 'entidad_publica' => $dato_publico);
                            echo json_encode($json);
                            return;  
                        }
                          
                    }else{
                        $json = array('result' => false ,'mensaje' => "Numero de Suministro Incorrecto");
                        echo json_encode($json);
                        return; 
                    }
                }  
            }
              
        }
    }

    public function buscar_cuotas(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $oficina = $this->input->post('oficina');
            $agencia = $this->input->post('agencia');
            $CreditoNro = $this->input->post('CreditoNro');
            $num_cuotas = $this->Financiamiento_model -> obtengo_NumCuotas($oficina,$agencia,$CreditoNro);
            if (count($num_cuotas)>0) {
                $json = array('result' => true ,'num_cuotas' => $num_cuotas);
                  echo json_encode($json);
                  return;
            }
        }
    }

    public function guarda_datos_titular(){
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
            //$fecha_registro = date("Y-m-d-h-i-s");
            $fecha_registro = date("Y-m-d");
            $nombre_financiamiento = "financia-credi_".$nro_credito."-".$suministro."-".$fecha_registro; 
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

    public function editar_titular(){

      $ajax = $this->input->get('ajax');
      if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $email = $this->input->post('email');
            $dni = $this->input->post('dni');
            $ruc = $this->input->post('ruc');
            $telefono = $this->input->post('telefono');
            $nombre = $this->input->post('nombre');
            $apepat = $this->input->post('apepat');
            $apemat = $this->input->post('apemat');
            $Selector_zona = $this->input->post('Selector_zona');
            $zona = $this->input->post('zona');
            $Selector_via = $this->input->post('Selector_via');
            $via = $this->input->post('via');
            $Numero = $this->input->post('Numero');
            $Interior = $this->input->post('Interior');
            $Kilometro = $this->input->post('Kilometro');
            $Departamento = $this->input->post('Departamento');
            $Manzana = $this->input->post('Manzana');
            $Lote = $this->input->post('Lote');
            $bandera = $this->input->post('Bandera');
            $suministro =  $this->input->post('suministro');
            $oficina = $this->input->post('oficina');
            $agencia = $this->input->post('agencia');
            $resultado  = $this->Financiamiento_model -> Edit_titular($email, $dni, $ruc, $telefono, $nombre, $apemat, $apepat, $Selector_zona, $zona, $Selector_via, $via, $Numero, $Interior, $Kilometro, $Departamento, $Manzana, $Lote, $bandera, $suministro, $oficina, $agencia);
            if($resultado){
                $json = array('result' => true,'nombre' => $nombre.' '.$apepat.' '.$apemat , 'direccion' => $Selector_zona.' '.$zona.' '.$Selector_via.' '.$via.' '.$Numero.' '.$Interior.' '.$Kilometro.' '.$Departamento.' '.$Manzana.' '.$Lote , 'dni' => $dni, 'ruc' => $ruc , 'correo' => $email , 'telefono' => $telefono);
                echo json_encode($json);
                return;
            } 
        }

    }
    public function guarda_datos_representante(){
        if (empty($_FILES['representante-es'])) {
            $output = array('estado' => 'ok',
                            'mensaje' => 'no se pudieron cargar los archivos'
                           );
            echo json_encode($output);             
            return; // terminate
        }else{
            $archivos = $_FILES['representante-es'];
            $paths= [];
            $nombre_archivos = $archivos['name'];
            $suministro = empty($_POST['num_suministro']) ? '' : $_POST['num_suministro'];
            $ruta_carpeta = empty($_POST['rut_carpeta']) ? '' : $_POST['rut_carpeta']; 
            $nro_credito = empty($_POST['num_credito']) ? '' : $_POST['num_credito'];    
            $dire =$ruta_carpeta; 
            // creo la carpeta para financiamiento
            if(mkdir($dire.'/representante', 0777, true)){
                // GUARDO LOS ARCHIVOS 
                $success = null;
                $dire_tabla = "";
                for($i=0; $i < count($nombre_archivos); $i++){
                    $ext = explode('.', basename($nombre_archivos[$i]));
                    //$target = $dire.'/representante/'. md5(uniqid()) . "." . array_pop($ext);
                    $target = $dire.'/representante/'.$suministro.'-'.str_pad(($i+1), 4, "0", STR_PAD_LEFT). "." . array_pop($ext);
                    if(move_uploaded_file($archivos['tmp_name'][$i], $target) ) {
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
                    $varifica = $this->Financiamiento_model ->guardo_dire_representante($suministro,$nro_credito,$dire_tabla);
                    $output = array('estado' => 'OK' );
                }
                echo json_encode($output);
            } 
        }
    }

    public function guarda_datos_texto(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $oficina = $this->input->post('oficina');
            $agencia = $this->input->post('agencia');
            $suministro = $this->input->post('suministro');
            $inicial = $this->input->post('inicial');
            $nro_cuota = $this->input->post('nro_cuota'); 
            $saldo = $this->input->post('saldo');
            $descri_plan = $this->input->post('descri_plan');
            $int_moratorio = $this->input->post('int_moratorio');
            $gasto_cobranza = $this->input->post('gasto_cobranza');
            $observacion = $this->input->post('observacion');
            $tabla_simulacion = $this->input->post('tabla_simulacion');
            $tasa_interes  = $this ->input->post('tasa_int'); 
            $tasa_frc = $this ->input->post('tasa_frc');
            $fecha_vencimiento = $this ->input->post('fecha_vencimiento'); 
            $tabla_SolRepre = $this ->input->post('tabla_SolRepre');
            $tabla_recibo = $this ->input->post('tabla_recibo');
            $tabla_deuda_anterior = $this ->input->post('Anterior_Deuda');
            $servidor = $this ->input->post('Servidor_suministro');
            $observaciones  = $this ->input->post('Observacion');
            $numero_financimiento = $this ->input->post('num_fina');
            $gerente = $this ->input->post('gere');
            //$nota_credito_debito = $this ->input->post('not_cred_deb');
            $saldo_financiamiento = $this ->input->post('deuda_financiamiento');
            $respuesta = $this->Financiamiento_model -> Grabar_Credit($oficina,$agencia,$suministro, $inicial, $nro_cuota, $saldo, $descri_plan, $int_moratorio, $gasto_cobranza,$_SESSION['user_id'], $observacion,$tabla_simulacion, $tasa_interes, $tasa_frc, $fecha_vencimiento, $tabla_SolRepre, $tabla_recibo, $tabla_deuda_anterior, $servidor, $observaciones, $numero_financimiento, $gerente,  $saldo_financiamiento);
            if ($respuesta[0]) {
                if (isset($respuesta[3])) {
                   $json = array('result' => true ,'Nro_credit' => $respuesta[1], 'Nro_amortiza' => $respuesta[2] , 'Ser_not_debito' => $respuesta[3] , 'num_not_debito' =>$respuesta[4] );
                    echo json_encode($json);
                    return;  
                }else{
                    $json = array('result' => true ,'Nro_credit' => $respuesta[1], 'Nro_amortiza' => $respuesta[2]);
                    echo json_encode($json);
                    return;
                }
                   
            }else{
                $json = array('result' => false ,'mensaje' => $respuesta[1]);
                echo json_encode($json);
            }
            
        }
    }

    public function reporte_acta(){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        $array = json_decode($this->input->post('reporte_acta'),true);
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
        // add a page
        $pdf->AddPage('P', 'A4');
        $pdf->SetAutoPageBreak(false, 0);
        $NRO_CREDITO = $array[10][0]["MAXIMO"];
        $fechas[0] ="dato";
        $resultado = $this->lib_tcpdf-> plantilla_acta($pdf,$array[0], $array[1], $array[2],$array[3][0]['DNI'], $array[4],$array[5], $array[6], $array[7], $array[8], $array[9], $NRO_CREDITO, $array[12],$fechas, $array[3], $array[11],'Z', 'I');
        $resultado->Output('reporte_acta.pdf', 'I');
      } 
    }

    public function reporte_caja(){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
         $array = json_decode($this->input->post('reporte_caja'),true);
         //var_dump($array);
         //exit();
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
         // add a page
         $pdf->AddPage('P', 'A4');
         $pdf->SetAutoPageBreak(false, 0);
         $distancia = 0 ;
         $Dato_credito = $array[8][0]['MAXIMO'];
         $fecha = "fecha actual";
         $resultado = $this->lib_tcpdf-> plantilla_caja($pdf, $distancia, $array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7], $Dato_credito, $array[9] , $array[10], $array[11], $fecha ,$array[12],'Z', 'I' );
         $distancia = 145 ;
         $resultado = $this->lib_tcpdf-> plantilla_caja($resultado, $distancia,  $array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7], $Dato_credito, $array[9], $array[10], $array[11], $fecha, $array[12], 'Z','I');
         $resultado->Output('reporte_acta.pdf', 'I');
      }       
    }

    public function reporte_cronograma(){

       if($this->input->server('REQUEST_METHOD') == 'POST'){

           $array = json_decode($this->input->post('reporte_cronograma'),true);
           $this->load->library('lib_tcpdf');
           //var_dump($array);
           //exit();
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
           $resultado = $this->lib_tcpdf-> plantilla_cronograma($pdf, $array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7], $array[8],$array[9],$array[10], $array[11], $array[12] , $array[13] , $array[14] );
           $resultado->Output('reporte_cronograma.pdf', 'I'); 
       }     
    }

    public function proforma_cronograma(){

        if($this->input->server('REQUEST_METHOD') == 'POST'){
 
            $array = json_decode($this->input->post('proforma_cronograma'),true);
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
            $resultado = $this->lib_tcpdf-> proformA_cronograma($pdf, $array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7], $array[8],$array[9],$array[10], $array[11] );
            $resultado->Output('reporte_cronograma.pdf', 'I'); 
        }     
     }

    public function reporte_recibo(){
      if($this->input->server('REQUEST_METHOD') == 'POST'){
        $array = json_decode($this->input->post('reporte_recibo'),true);
        //var_dump($array);
        //exit();
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
        // add a page
        $pdf->AddPage('P', 'A4');
        $pdf->SetAutoPageBreak(false, 0);
        $resultado = $this->lib_tcpdf-> plantilla_recibos($pdf,$array[0], $array[1], $array[2],$array[3], $array[4],$array[5], $array[6], $array[7], $array[8], $array[9], $array[10], $array[11], $array[12], $array[13]);
        $resultado->Output('reporte_recibos.pdf', 'I');
      }
    }

    public function Repor_Recono_deuda(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('recono_deuda'),true);
            // OBTENGO LOS DATOS GENERALES PARA EL CONVENIO
            //var_dump($array);
            if($array[0][0][10] =='837'){
                $Nro_credito =(int) $array[0][0][3] - 1 ;
                $dato_titular = $this->Financiamiento_model -> Dato_titular($array[0][0][1],$array[0][0][2],$Nro_credito);
                $respuesta = $this->Financiamiento_model -> Dato_CONVLINK_colateral($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                $nombre_catastral =$this->Financiamiento_model -> Get_nombre_catastral($respuesta[0]['CLIUNICOD']);
            }else{
                $respuesta = $this->Financiamiento_model -> Dato_CONVLINK($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                $nombre_catastral =$this->Financiamiento_model -> Get_nombre_catastral($respuesta[0]['CLIUNICOD']);
                $dato_titular = $this->Financiamiento_model -> Dato_titular($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            } 
        
            //exit();
            if ($respuesta) {
                //var_dump($dato_titular);
                //exit();
                $tabla[0]['Nombre'] = $dato_titular[0]['SOLICINOM'];
                $tabla[0]['DNI'] = $dato_titular[0]['SOLICIDNI'];
                if($dato_titular[0]['REPSOLNOM'] != null){
                    $tabla[1]['Nombre'] = $dato_titular[0]['REPSOLNOM'];
                    $tabla[1]['DNI'] = $dato_titular[0]['REPSOLDNI'];
                }
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
                // add a page
                $pdf->AddPage('P', 'A4');
                $pdf->SetAutoPageBreak(false, 0);
                $fechas[0] = $dato_titular[0]['CREDFECHA'];
                $fechas[1] ='A' ;
                $resultado = $this->lib_tcpdf-> plantilla_acta($pdf,$respuesta[0]['CLIUNICOD'], $dato_titular[0]['SOLICIDIRE'], $dato_titular[0]['SOLICINOM'],$dato_titular[0]['SOLICIDNI'], $respuesta[0]['DEUDATOTAL'],$respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'], $respuesta[0]['PRIMVENCI'], $array[0][0][1],$array[0][0][2],$array[0][0][3],$array[0][0][12],$fechas, $tabla, $nombre_catastral[0]['CLINOMBRE'], $array[0][0][7], $dato_titular[0]['ESTADOACTA']);
                $resultado->Output('reporte_acta.pdf', 'I');
            }
            
        }
    }

    public function Repor_crono_pagos(){

        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('crono_pagos'),true);
            // OBTENGO LOS DATOS GENERALES PARA EL CONVENIO 
            
            if($array[0][0][7] != 'Y'){
                $respuesta = $this->Financiamiento_model -> Dato_CONVLINK($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                $nombre_catastral =$this->Financiamiento_model -> Get_nombre_catastral($respuesta[0]['CLIUNICOD']);
                $dato_titular = $this->Financiamiento_model -> Dato_titular($array[0][0][1],$array[0][0][2],$array[0][0][3]); 
                $dato_letras  = $this->Financiamiento_model -> Dato_Letras($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                
                if ($respuesta) {

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
                    // add a page
                    $pdf->AddPage('P', 'A4');
                    $pdf->SetAutoPageBreak(false, 0);
                    $resultado = $this->lib_tcpdf-> Report_planti_cronograma($pdf,$respuesta[0]['CLIUNICOD'], $dato_titular[0]['SOLICIDIRE'],
                    $dato_titular[0]['SOLICINOM'], $respuesta[0]['DEUDATOTAL'],$respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'] , $array[0][0][1],$array[0][0][2],$dato_letras, ((float)$respuesta[0]['DEUDATOTAL']-(float)$respuesta[0]['CTAINICIAL'] ), 
                    $respuesta[0]['CREDFECHA'],$respuesta[0]['TASAINT'], $respuesta[0]['CUOTAFIJA'] , 
                    $array[0][0][3], $dato_titular[0]['CREDFECHA'], $nombre_catastral[0]['CLINOMBRE'], $array[0][0][7], $dato_titular[0]['ESTADOACTA']);
                    $resultado->Output('reporte_acta.pdf', 'I');
                }
            }else{
                //var_dump($array);
                if($array[0][0][10] == '847'){ // entre al interes 
                    $dato_letras  = $this->Financiamiento_model->Dato_Letras($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                    $respuesta = $this->Financiamiento_model -> Dato_CONVLINK_colateral($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                    $nombre_catastral =$this->Financiamiento_model -> Get_nombre_catastral($respuesta[0]['CLIUNICOD']);
                    if($respuesta){
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
                        // add a page
                        $pdf->AddPage('P', 'A4');
                        $pdf->SetAutoPageBreak(false, 0);
                        $resultado = $this->lib_tcpdf-> Report_planti_cronograma($pdf,$array[3], $array[2],
                        $array[1], $respuesta[0]['DEUDATOTAL'],$respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'] , $array[0][0][1],$array[0][0][2],$dato_letras, ((float)$respuesta[0]['DEUDATOTAL']-(float)$respuesta[0]['CTAINICIAL'] ), 
                        $respuesta[0]['CREDFECHA'],$respuesta[0]['TASAINT'], $respuesta[0]['CUOTAFIJA'] , $array[0][0][3], $array[0][0][3], 
                        $nombre_catastral[0]['CLINOMBRE'], $array[0][0][7], $array[0][0][6]);
                        $resultado->Output('reporte_acta.pdf', 'I');
                    }
                    
                    //var_dump("entre al interes ");
                }else{
                    $dato_letras  = $this->Financiamiento_model -> Dato_Letras($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                    $respuesta = $this->Financiamiento_model -> Dato_CONVLINK($array[0][0][1],$array[0][0][2],$array[0][0][3]);
                    $nombre_catastral =$this->Financiamiento_model -> Get_nombre_catastral($respuesta[0]['CLIUNICOD']);
                    if($respuesta){
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
                        // add a page
                        $pdf->AddPage('P', 'A4');
                        $pdf->SetAutoPageBreak(false, 0);
                        $resultado = $this->lib_tcpdf-> Report_planti_cronograma($pdf,$array[3], $array[2],
                        $array[1], $respuesta[0]['DEUDATOTAL'],$respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'] , $array[0][0][1],$array[0][0][2],$dato_letras, ((float)$respuesta[0]['DEUDATOTAL']-(float)$respuesta[0]['CTAINICIAL'] ), 
                        $respuesta[0]['CREDFECHA'],$respuesta[0]['TASAINT'], $respuesta[0]['CUOTAFIJA'] , $array[0][0][3], $array[0][0][3], 
                        $nombre_catastral[0]['CLINOMBRE'], $array[0][0][7], $array[0][0][6]);
                        $resultado->Output('reporte_acta.pdf', 'I');
                    }
                    
                    //var_dump("estoy en el otro colateral ");
                }
            }
        /*  $respuesta = $this->Financiamiento_model -> Dato_CONVLINK($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            $dato_titular = $this->Financiamiento_model -> Dato_titular($array[0][0][1],$array[0][0][2],$array[0][0][3]); 
            $dato_letras  = $this->Financiamiento_model -> Dato_Letras($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            
            if ($respuesta ) {
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
                // add a page
                $pdf->AddPage('P', 'A4');
                $pdf->SetAutoPageBreak(false, 0);
                $resultado = $this->lib_tcpdf-> Report_planti_cronograma($pdf,$respuesta[0]['CLIUNICOD'], $dato_titular[0]['SOLICIDIRE'],
                $dato_titular[0]['SOLICINOM'], $respuesta[0]['DEUDATOTAL'],$respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'] , $array[0][0][1],$array[0][0][2],$dato_letras, ((float)$respuesta[0]['DEUDATOTAL']-(float)$respuesta[0]['CTAINICIAL'] ), $respuesta[0]['CREDFECHA'],$respuesta[0]['TASAINT'], $respuesta[0]['CUOTAFIJA'] , $array[0][0][3], $dato_titular[0]['CREDFECHA']);
                $resultado->Output('reporte_acta.pdf', 'I');
            }*/
            
        }
    }

    public function Repor_reci_caja(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('Reci_caja'),true);
            // OBTENGO LOS DATOS GENERALES PARA EL CONVENIO 
            $respuesta = $this->Financiamiento_model -> Dato_CONVLINK($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            $nombre_catastral =$this->Financiamiento_model -> Get_nombre_catastral($respuesta[0]['CLIUNICOD']);
            $dato_titular = $this->Financiamiento_model -> Dato_titular($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            $dato_Amortiza = $this->Financiamiento_model -> Dato_Amortiza($array[0][0][1],$array[0][0][2],$array[0][0][3]);  
            if ($respuesta ) {

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
                // add a page
                $pdf->AddPage('P', 'A4');
                $pdf->SetAutoPageBreak(false, 0);
                $tipo = 2;
                $distancia = 0 ;
                $resultado = $this->lib_tcpdf-> plantilla_caja($pdf, $distancia,$dato_titular[0]['SOLICINOM'], $dato_titular[0]['SOLICIDIRE'], $respuesta[0]['DEUDATOTAL'], $respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'], ((float)$respuesta[0]['DEUDATOTAL']-(float)$respuesta[0]['CTAINICIAL'] ), $array[0][0][1],$array[0][0][2],$array[0][0][3], $dato_Amortiza[0]['AMONRO'], $respuesta[0]['CLIUNICOD'], $tipo, $dato_titular[0]['CREDFECHA'], $nombre_catastral[0]['CLINOMBRE'], $array[0][0][7], $dato_titular[0]['ESTADOACTA'] );
                $distancia = 145 ;
                $resultado = $this->lib_tcpdf-> plantilla_caja($pdf, $distancia,$dato_titular[0]['SOLICINOM'], $dato_titular[0]['SOLICIDIRE'], $respuesta[0]['DEUDATOTAL'], $respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'], ((float)$respuesta[0]['DEUDATOTAL']-(float)$respuesta[0]['CTAINICIAL'] ), $array[0][0][1],$array[0][0][2],$array[0][0][3], $dato_Amortiza[0]['AMONRO'], $respuesta[0]['CLIUNICOD'], $tipo, $dato_titular[0]['CREDFECHA'], $nombre_catastral[0]['CLINOMBRE'], $array[0][0][7], $dato_titular[0]['ESTADOACTA']);
                $resultado->Output('reporte_acta.pdf', 'I');
            }  
        }
    }   
     
    public function Repor_Corri_convenio(){

        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('CTA_corri_convenio'),true);
            // OBTENGO LOS DATOS GENERALES PARA EL CONVENIO 
        
            $respuesta = $this->Financiamiento_model -> Dato_CONVLINK($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            $nombre_catastral =$this->Financiamiento_model -> Get_nombre_catastral($respuesta[0]['CLIUNICOD']);
            $dato_titular = $this->Financiamiento_model -> Dato_titular($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            $dato_recibos = $this->Financiamiento_model -> Dato_Corri_convenio($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            $dato_credito =  $this->Financiamiento_model -> get_credit($array[0][0][1],$array[0][0][2],$array[0][0][3]);
            
            $i = 0;
            while($i < count($dato_recibos)){
                //CLICODFAX, FACSERNRO, FACNRO
                $recibos = $this->Financiamiento_model->Obtengo_dato_recibo($dato_recibos[$i]['CLICODFAX'], $dato_recibos[$i]['FACSERNRO'], $dato_recibos[$i]['FACNRO']); 
                $dato_NCA =  $this->Financiamiento_model -> get_ncaconv($array[0][0][1], $array[0][0][2], $array[0][0][3], $dato_recibos[$i]['FACSERNRO'], $dato_recibos[$i]['FACNRO']);
                if(count($dato_NCA)>0){
                    $recibos[0]['NCA'] =(float)$dato_NCA[0]['NCATOTDIF'] * -1;   
                }else{
                    $recibos[0]['NCA'] =0;
                }
                $dato_recibos[$i]= $recibos[0]; 
                $i++;
            }

            if ($respuesta ) {

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
                // add a page
                $pdf->AddPage('P', 'A4');
                $pdf->SetAutoPageBreak(false, 0);
                /* $pdf, $sum_recibo, $direccion_cliente, $nombre_cliente, $tabla, $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred, $int_mora, $gast_cobra */
                $resultado = $this->lib_tcpdf-> Repo_plantilla_recibos($pdf, $respuesta[0]['CLIUNICOD'], $dato_titular[0]['SOLICIDIRE'], $dato_titular[0]['SOLICINOM'], $dato_recibos, $respuesta[0]['DEUDATOTAL'], $respuesta[0]['CTAINICIAL'], $respuesta[0]['NROLTS'], $dato_titular[0]['CREDFECHA'], $array[0][0][1], $array[0][0][2], $array[0][0][3],$dato_credito[0]['CLIINTER'], $dato_credito[0]['CLGCOBZA'], $nombre_catastral[0]['CLINOMBRE'], $array[0][0][7], $dato_titular[0]['ESTADOACTA']);
                $resultado->Output('reporte_acta.pdf', 'I');    
            }  
        } 
    }

    public function vista(){

        $this->data['menu']['hijo'] = 'REPORTE_FINANCIAMIENTO';
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo']);
        if(count($permiso)>0){
            $this->data['view'] = 'Financiamiento/reporte_financiamiento_view';
            $this->data['breadcrumbs'] = array(array('Financiamiento', 'REPORTE FINANCIAMIENTO'));
            $this->load->view('template/Master', $this->data);
        }else{
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
            redirect($this->config->item('ip').'inicio');
            return;
        }
        
    }

    public function suministro_reporte(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
            $inicio = $this->input->post('inicio');
            $fin = $this->input->post('fin');
            $tipo =  $this->input->post('tipo');
            $suministro =  $this->input->post('suministro');
            
            
            if (strlen($suministro)==7) {
                $dato_nombre = $this->Financiamiento_model -> obtengo_dato_nombre_tam7($suministro);
                $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam7($suministro);
                if ($dato_nombre) {
                   $respuesta = $this->Financiamiento_model -> Busco_Suministro_reporte($inicio, $fin, $tipo, $suministro);
                    $json = array('result' => true ,'mensaje' => "Datos encontrados" , 'respuesta' => $respuesta , 'detalle' => $dato_detalle, 'tam' => 7 );
                    echo json_encode($json);
                }else{
                    $json = array('result' => false );
                    echo json_encode($json); 
                }
            }
            if (strlen($suministro)==11) {
                $dato_detalle = $this->Financiamiento_model -> obtengo_dato_tam11($suministro);
                
                if (count($dato_detalle)>0) {
                    $respuesta = $this->Financiamiento_model -> Busco_Suministro_reporte($inicio, $fin, $tipo, $suministro);
                    $json = array('result' => true ,'mensaje' => "Datos encontrados" , 'respuesta' => $respuesta , 'detalle' => $dato_detalle , 'tam' => 11);
                    echo json_encode($json);      
                }else{
                    $json = array('result' => false  );
                    echo json_encode($json);
                }
            }
            

        }
    }


    public function Repor_dire_archivos(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false , 'mensaje' => "Esta intentando Ingresar de forma inadecuada");
            echo json_encode($json);
            return;
        }else{
                $numero_credito = $this->input->post('num_credito');
                $cod_suministro = $this->input->post('num_suministro') ;
                $respuesta = $this->Financiamiento_model -> Busco_archi_reporte($numero_credito, $cod_suministro);
                $json = array('result' => true ,'mensaje' => "Datos encontrados" , 'respuesta' => $respuesta  );
                echo json_encode($json);

        }  
    }
}