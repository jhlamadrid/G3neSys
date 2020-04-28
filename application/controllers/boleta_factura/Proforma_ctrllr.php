<?php

class Proforma_ctrllr extends CI_Controller {

    //var
    public function __construct() {

        parent::__construct();
        //modelos
        //$this->load->model('acceso/Usuario_model');
        //$this->load->model('acceso/Perfil_model');
        //$this->load->model('acceso/Cargo_model');
        $this->load->model('general/Propie_model');
        $this->load->model('Financiamiento/Financiamiento_model');
        $this->load->model('general/Catalogo_model');
        $this->load->model('general/Oordpag_model');
        $this->load->model('boleta_factura/Comprobante_pago_model');
        $this->load->model('general/PersonaEmpresa_model');
        // librerias de sesion
        $this->load->library('session');
        $this->load->library('acceso_cls');
        //var_dump(date('d-m-Y'));
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Proforma';
        $this->data['menu']['padre'] = 'comprobantes';
        $this->data['menu']['hijo'] = 'proformas';

        $igv = $this->Catalogo_model->get_igv();
        $_SESSION['IGV'] = $igv['FACTORPORCENTAJE'];
        //NSEMPCOD, NSOFICOD REG, ZON, LOC
        $regzonloc = $this->Catalogo_model->get_regzonloc($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD']);
        $_SESSION['FSCREGION'] = $regzonloc['REG'];
        $_SESSION['FSCZONA'] =    $regzonloc['ZON'];
        $_SESSION['FSCSECTOR'] =  0;
        $_SESSION['FSCLOCALID'] = $regzonloc['LOC'];

        //var_dump($_SESSION);

        // CARGAMOS LA SERIE DE LA BOLETA (SEDALIB) QUE LE CORRESPONDE POR EMPRESA, OFICINA Y AREA
        $serie_boleta = $this->Catalogo_model->get_serie($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD'], $_SESSION['user_data']['NSARECOD'], 2);
        if(empty($serie_boleta)){
            $_SESSION['BOLETA']['serie'] = null;
            redirect(base_url().'inicio');
            return;
        }
        $_SESSION['BOLETA']['serie'] = $serie_boleta['SERNRO'];
        // ======================================================================================================================

        // CARGAMOS LA SERIE DE LA FACTURA (SEDALIB) QUE LE CORRESPONDE POR EMPRESA, OFICINA Y AREA
        $serie_factura = $this->Catalogo_model->get_serie($_SESSION['user_data']['NSEMPCOD'], $_SESSION['user_data']['NSOFICOD'], $_SESSION['user_data']['NSARECOD'], 1);

        if(empty($serie_factura)){
            $_SESSION['FACTURA']['serie'] = null;
            redirect(base_url().'inicio');
            return;
        }
        $_SESSION['FACTURA']['serie'] = $serie_factura['SERNRO'];
        // =================================================================================================


        //$_SESSION['BOLETA']['serie'] = 100;
        //$_SESSION['FACTURA']['serie'] = 100;
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

    private function calcular_precios($unitario, $cantidad, $tiene_igv){
        $igv = $_SESSION['IGV']/100;

        $usinigv = ($tiene_igv)? ($unitario/(1+$igv)):0;
        $u_igv =  round($usinigv*$igv,2);
        $usinigv = $unitario-$u_igv;

        $precios = array(
            'UNIT'=> $unitario,
            'UNIT_SINIGV' => $usinigv,
            'UNIT_IGV' => $u_igv,
            'CANT' => $cantidad,
            'SUBTOT' => round($usinigv*$cantidad,2),
            'SUBIGV' => round($u_igv*$cantidad, 2),
            'TOT' => $unitario*$cantidad
        );
        return $precios;
    }

    private function calcular_precio($unitario, $cantidad, $tiene_igv, $gratuito){
        $igv = $_SESSION['IGV']/100;
        if($tiene_igv >=10 && $tiene_igv <=17 ){
            $usinigv = $unitario/(1+$igv);
        }else{
            $usinigv = 0;
        }
        $u_igv =  round($usinigv*$igv,2);
        $usinigv = $unitario-$u_igv;

        $precios = array(
            'UNIT'=> $unitario,
            'UNIT_SINIGV' => $usinigv,
            'UNIT_IGV' => $u_igv,
            'CANT' => $cantidad,
            'SUBTOT' => ($gratuito=='1')? round($usinigv*$cantidad,2) : round($usinigv*$cantidad,2),
            'SUBIGV' => ($gratuito=='1')? round($u_igv*$cantidad, 2) : round($u_igv*$cantidad, 2),
            'TOT' => ($gratuito=='1')? $unitario*$cantidad : $unitario*$cantidad
        );
        return $precios;
    }

// MOSTRAR PROFORMAS

    public function editar_proforma($tipo, $serie, $numero){//boletasfacturas(){
        $this->data['proforma']['cliente'] = $this->Comprobante_pago_model->get_cabecera_boletafactura_sinpagar($tipo, $serie, $numero);
        $this->data['proforma']['descripcion'] = $this->Comprobante_pago_model->get_descripcion_boletafactura_sinpagar($tipo, $serie, $numero);
        //var_dump($this->data['proforma']['cliente']);
        $profns = $this->Comprobante_pago_model->get_profns($tipo, $serie, $numero);

        $profns2 = $this->Oordpag_model->get_oordpag($profns['EMPCODNS'], $profns['OFICODNS'], $profns['ARECODNS'], $profns['CTDCODNS'], $profns['DOCCODNS'], $profns['SERNRONS'], $profns['ORPNRONS']);
        if(count($profns2)>0){
            $this->data['profns'] = $profns2;
        }
        $this->data['propie'] = $this->Propie_model->get_propie($this->data['proforma']['cliente']['FSCCLIUNIC']);
        if(empty($this->data['propie'])){
            $this->data['propie'] = $this->Propie_model->get_default_propie();
        }

        //$this->data['tipo_registro']='boleta';
        $this->data['view']='boleta_factura/Proforma_editar_view';
        $this->data['breadcrumbs'] = array(array('Profromas', 'documentos/boletas_facturas'),array('Pago de Boleta',''));
        //$this->data['conceptos'] = $this->Comprobante_pago_model->get_concep();
        $this->load->view('template/Master', $this->data);
    }

    public function mostrar_proformas(){
        $permiso = $this->Financiamiento_model->get_permiso( $_SESSION['user_id'], $this->data['menu']['hijo'] );
        if(count($permiso)>0){
        
        //$rol=$this->Catalogo_model->get_rol($_SESSION['user_id']);
        //if( ($rol[0]['ID_ROL'] ==10) || ($rol[0]['ID_ROL'] ==15) ){
            $variable = 0;
            foreach($_SESSION['TAREAS'] as $tareas){
                if($tareas['MENUGENDESC'] == 'COMPROBANTE' && $tareas['ACTIVDESC'] == 'PROFORMAS') {
                    $this->data['consulta'] = 'multiple';
                    $this->data['comprobantes'] = $this->Comprobante_pago_model->get_all_proforma();//get_boletasfacturas_sinpagar();
                    $this->data['view'] = 'boleta_factura/Proformas_view';
                    $this->data['titulo'] = 'Proformas';
                    $this->data['breadcrumbs'] = array(array('Documentos', ''),array('Proforma',''));
                    $this->load->view('template/Master', $this->data);
                $variable = 1;
                    break;
                }
            }
            if($variable == 0){
                $this->load->view('errors/html/error_404', $this->data);
            }
        }else{
            redirect(base_url() . 'inicio');
            //var_dump($rol);
        }
        
    }

    public function mostrar_registro_proforma_boleta($array = null){//ver_registro(){
        $variable = 0;
        foreach($_SESSION['TAREAS'] as $tareas){

            if($tareas['MENUGENDESC'] == 'COMPROBANTE' && $tareas['ACTIVDESC'] == 'PROFORMAS' && $tareas['BTNGENDESC'] == 'NUEVA PROFORMA BOLETA') {
                // =====================================================================
                $usuario=null;
                $oordpag = null;
                $oordserv = null;
                $conceptos = null;
                if($array != null && count($array) == 8){
                    //$array = json_decode($this->input->post('codigo_orden_pago'));
                    $oordpag = $this->Oordpag_model->get_oordpag($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6]);
                    $oordserv = $this->Oordpag_model->get_oordserv($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6]);
                    $conceptos = $this->Oordpag_model->get_concep_oordpag($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6]);

                    //VERIFICA USUARIO  
                     if($oordserv != null){

                        $veri_usuario= $this->Oordpag_model->existe_usuario($oordserv); 
                        
                        if(strlen(trim($veri_usuario[0]["MCSNRODOC"]))!=8){
                        $this->session->set_flashdata('mensaje', array('error', 'Alerta:Debe de realizarse  una FACTURA ya que el cliente hizo el tramite con RUC'.$oordserv ["STAEMPCOD"].'-'.$oordserv ["STAOFICOD"].'-'.$oordserv ["STAARECOD"].'-'.$oordserv ["STACTDCOD"].'-'.$oordserv ["STADOCCOD"].'-'.$oordserv ["STASERNRO"].'-'.$oordserv ["CDANRO"].'-'.$array[0].'-'. $array[1].'-'. $array[2].'-'. $array[3].'-'. $array[4].'-'. $array[5].'-'. $array[6],""));
                        redirect(base_url() . 'documentos/proformas');
                        }else{
                           
                           $existe=  $this->PersonaEmpresa_model->get_persona(rtrim($veri_usuario[0]["MCSNRODOC"]),"1");
                           if($existe==null){
                                $apellidos=rtrim ($veri_usuario[0]["MCSAPE"]);
                                
                                $i=0;
                                $ap_paterno="";
                                $tam=0;
                                while ( $i< strlen($apellidos)) {
                                    
                                    if(ord($apellidos[$i]) != 32){
                                     $ap_paterno=$ap_paterno.$apellidos[$i];
                                     $tam=$tam +1;  
                                    }else{
                                        if($tam <= 3){
                                          $ap_paterno=$ap_paterno.$apellidos[$i];
                                          $tam=0; 
                                        }else{
                                            break;
                                        }
                                    }
                                     
                                    $i=$i+1;
                                }
                                $ap_materno=substr($apellidos,$i,strlen($apellidos) );
                                
                                $temporal=rtrim($veri_usuario[0]["CGPDES"]);
                                $zona="";
                                $i=0;
                                while($i< strlen($temporal)){
                                    if(ord($temporal[$i]) != 32){
                                        $zona=$zona.$temporal[$i];
                                    }
                                    else{
                                        break;
                                    }
                                    $i=$i+1;
                                }
                                $zona1=substr($temporal,$i,strlen($temporal) );
                                

                                $temporal=rtrim($veri_usuario[0]["MVIDES"]);
                                $via="";
                                $i=0;
                                while($i< strlen($temporal)){
                                    if(ord($temporal[$i]) != 32){
                                        $via=$via.$temporal[$i];
                                    }
                                    else{
                                        break;
                                    }
                                    $i=$i+1;
                                }
                                $via1=substr($temporal,$i,strlen($temporal) );
                                $veri_usuario[0]["MCSNOM"]=rtrim($veri_usuario[0]["MCSNOM"]);
                                $this->PersonaEmpresa_model->insert_persona(rtrim($veri_usuario[0]["MCSNRODOC"]),"1",$ap_paterno,$ap_materno,$veri_usuario[0]["MCSNOM"],$zona,$zona1,$via,$via1,$veri_usuario[0]["MCSTLF1"]);
                                $usuario=  $this->PersonaEmpresa_model->get_persona(rtrim($veri_usuario[0]["MCSNRODOC"]),"1");

                           }else{
                            $usuario=  $this->PersonaEmpresa_model->get_persona(rtrim($veri_usuario[0]["MCSNRODOC"]),"1");
                           }

                        }

                     }
                    
                    //$this->data['ocendoc'] = $array;
                    //var_dump($oordserv);
                }else{
                    $conceptos = $this->Comprobante_pago_model->get_concep();
                    $this->data['modal_concepto'] = 'propie/Concepto_view';
                }
                $this->data['usuario']=$usuario;
                $this->data['oordpag'] = $oordpag;
                $this->data['oordserv'] = $oordserv;
                $this->data['conceptos'] = $conceptos;

                //var_dump($conceptos);
                // ======================================================================

                $this->data['suministro_default'] = $this->Propie_model->get_default_propie();
                $this->data['proceso'] = 'Nueva Proforma';
                $this->data['modal_persona'] = 'propie/RegistroPersona_view';
                $this->data['view']='boleta_factura/Proforma_boleta_nuevo_view';
                $this->data['breadcrumbs'] = array(array('Proformas', 'documentos/proformas'),array('Nueva Proforma',''));
                //$this->data['conceptos'] = $this->Comprobante_pago_model->get_concep();
                $this->data['titulo'] = 'Nueva Proforma de Boleta';

                $this->data['tipos_docident'] = $this->Catalogo_model->get_tipodoc_persona();
                $this->data['tipo_afectacion_igv'] = $this->Catalogo_model ->get_tipo_afectacion();
                //WEB SUNAT
                $this->data['rutabsq1'] = 'https://cel.reniec.gob.pe/valreg/valreg.do;jsessionid=97657851cf84a1b5e8e57db400289a1dfe6deb1635f.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaMa3D3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaPb3aPbhiTbN4xf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_';
                //$this->data['modal_persona'] = 'propie/RegistroPersona_view';
                $this->data['tipo_via'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(25);
                $this->data['codigo_zona'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(26);
                $this->load->view('template/Master', $this->data);
                $variable = 1;
                break;
            }
        }
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    public function mostrar_registro_proforma_factura($array = null){//ver_registro(){
        $variable = 0;
        foreach($_SESSION['TAREAS'] as $tareas){
            if($tareas['MENUGENDESC'] == 'COMPROBANTE' && $tareas['ACTIVDESC'] == 'PROFORMAS' && $tareas['BTNGENDESC'] == 'NUEVA PROFORMA FACTURA') {
                // =====================================================================
                $oordpag = null;
                $oordserv = null;
                $conceptos = null;
                $empresa = null;
                if($array != null && count($array) == 8){
                    //$array = json_decode($this->input->post('codigo_orden_pago'));
                    $oordpag = $this->Oordpag_model->get_oordpag($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6]);
                    $oordserv = $this->Oordpag_model->get_oordserv($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6]);
                    $conceptos = $this->Oordpag_model->get_concep_oordpag($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6]);
                    //VERIFICA USUARIO  
                    if($oordserv != null){

                        $veri_usuario= $this->Oordpag_model->existe_usuario($oordserv);
                        //var_dump($veri_usuario);
                        //strlen($veri_usuario["MCSNRODOC"]);
                        if(strlen(rtrim($veri_usuario[0]["MCSNRODOC"]))!=11){
                        $this->session->set_flashdata('mensaje', array('error', 'Alerta:Debe de  ralizarse una BOLETA ya que el cliente hiso el tramite con DNI',""));
                        redirect(base_url() . 'documentos/proformas');
                        }else{
                            $existe=  $this->PersonaEmpresa_model->get_empresa($veri_usuario[0]["MCSNRODOC"]);
                            //var_dump($existe);
                           if($existe == null){
                                $temporal=rtrim($veri_usuario[0]["CGPDES"]);
                                $zona="";
                                $i=0;
                                while($i< strlen($temporal)){
                                    if(ord($temporal[$i]) != 32){
                                        $zona=$zona.$temporal[$i];
                                    }
                                    else{
                                        break;
                                    }
                                    $i=$i+1;
                                }
                                $zona1=substr($temporal,$i,strlen($temporal) );
                                

                                $temporal=rtrim($veri_usuario[0]["MVIDES"]);
                                $via="";
                                $i=0;
                                while($i< strlen($temporal)){
                                    if(ord($temporal[$i]) != 32){
                                        $via=$via.$temporal[$i];
                                    }
                                    else{
                                        break;
                                    }
                                    $i=$i+1;
                                }
                                $via1=substr($temporal,$i,strlen($temporal) );
                                $razon_social=rtrim ($veri_usuario[0]["MCSAPE"])." ".rtrim($veri_usuario[0]["MCSNOM"]);
                                $this->PersonaEmpresa_model->insert_empresa(rtrim($veri_usuario[0]["MCSNRODOC"]),$razon_social,$zona,$zona1,$via,$via1);
                                $empresa=  $this->PersonaEmpresa_model->get_empresa(rtrim($veri_usuario[0]["MCSNRODOC"]));
                                //var_dump(rtrim($veri_usuario[0]["MCSNRODOC"]),rtrim ($veri_usuario[0]["MCSAPE"]),$veri_usuario[0]["MCSNOM"],$zona,$zona1,$via,$via1,$veri_usuario[0]["MCSTLF1"]);
                           }else{
                             $empresa=  $this->PersonaEmpresa_model->get_empresa(rtrim($veri_usuario[0]["MCSNRODOC"]));
                           }
                        }

                     }
                }else{
                    $conceptos = $this->Comprobante_pago_model->get_concep();
                    $this->data['modal_concepto'] = 'propie/Concepto_view';
                }
                $this->data['empresa']= $empresa;
                $this->data['oordpag'] = $oordpag;
                $this->data['oordserv'] = $oordserv;
                $this->data['conceptos'] = $conceptos;
                // ======================================================================

                $this->data['suministro_default'] = $this->Propie_model->get_default_propie();
                $this->data['proceso'] = 'Nueva Proforma';

                $this->data['view']='boleta_factura/Proforma_factura_nuevo_view';
                $this->data['breadcrumbs'] = array(array('Proformas', 'documentos/proformas'),array('Nueva Proforma',''));
                //$this->data['conceptos'] = $this->Comprobante_pago_model->get_concep();
                $this->data['titulo'] = 'Nueva Proforma de Factura';
                $this->data['tipo_afectacion_igv'] = $this->Catalogo_model ->get_tipo_afectacion();
                $this->data['tipo_via'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(25);
                $this->data['codigo_zona'] = $this->Catalogo_model->get_deta_catalogo_by_catalogo(26);
                //var_dump($this->data['tipo_via']);
                // CONSULTA RUC
                $this->data['rutabsq2'] = 'http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias';
                $this->data['modal_empresa'] = 'propie/RegistroEmpresa_view';
                $this->data['modal_concepto'] = 'propie/Concepto_view';

                $this->load->view('template/Master', $this->data);
                $variable = 1;
                break;
            }
        }
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    public function mostrar_registro_proforma_orden_pago(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('codigo_orden_pago'));
            if($array[7] == 'BOLETA'){
                $this->mostrar_registro_proforma_boleta($array);
            }else if($array[7] == 'FACTURA'){
                $this->mostrar_registro_proforma_factura($array);
            }else{
                redirect(base_url().'inicio');
            }

        }else{
            redirect(base_url().'inicio');
        }
    }

    public function guardar_edicion(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        else{
            if(!isset($_SESSION['BOLETA']['serie']) || $_SESSION['FACTURA']['serie'] == null){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'El area a la que pertenece no tiene serie asignada', 'titulo' => 'No se encontro Serie para esta proforma');
            echo json_encode($json);
            return;
            }else{
                $aux = $this->input->post('envio');
                $ajax_proforma = json_decode($aux, true);

                if($ajax_proforma['total']<0 )
                {
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'no debe de ingresar numeros negativos', 'titulo' => 'No se encontro Serie para esta proforma');
                    echo json_encode($json);
                    return;
                }
                if($ajax_proforma['proforma']['tipdoc']==1){
                    if($ajax_proforma['sub_total']<0 || $ajax_proforma['igv']<0 ){
                        $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'no debe de ingresar numeros negativos', 'titulo' => 'No se encontro Serie para esta proforma');
                        echo json_encode($json);
                        return;
                    }
                        $subtotal = 0;
                        $subtotaligv = 0;
                        $total = 0;
                        $detalle = array();
                        foreach ($ajax_proforma['detalle'] as $item) {

                            if($item['cantidad']<0 )
                            {
                                $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'no debe de ingresar numeros negativos', 'titulo' => 'No debe de ingresar numeros negativos');
                                echo json_encode($json);
                                return;
                            }
                            if($item['estado']){
                                $item['estado']=1;
                            }else{
                                if(trim($item['afectacion'])=="GRAVADO"){
                                    $importe=round(($item['cantidad']*($item['precio']/(1+$ajax_proforma['base_igv']))),2);
                                    //$dif_igv=round(($item['precio']/(1+$ajax_proforma['base_igv'])),2);
                                    $subtotaligv = $subtotaligv + (($item['precio']*$item['cantidad'])-$importe);
                                    $subtotal = $subtotal + $importe;
                                    $item['estado']=0;
                                }else{
                                    $importe=round(($item['cantidad']*$item['precio']),2);
                                    $subtotal = $subtotal + $importe;
                                    $item['estado']=0;
                                }
                                
                            }

                            $item_aux = array(
                                "PUNIT" =>               $item['precio'],
                                "CANT" =>                $item['cantidad'],
                                "ELIM" =>                $item['estado'],
                                "FACCONCOD" =>           $item['codigo'],
                                "SFACTURA_FSCSERNRO" =>  $ajax_proforma['proforma']['seriedoc'],
                                "SFACTURA_FSCNRO"    =>  $ajax_proforma['proforma']['numerodoc'],
                                "SFACTURA_FSCTIPO"   =>  $ajax_proforma['proforma']['tipdoc']
                            );
                            array_push($detalle, $item_aux);
                        }
                        $total=$subtotal + $subtotaligv;
                        $proforma = array(
                            'FSCSUBTOTA' => $subtotal,
                            'FSCSUBIGV' =>  $subtotaligv,
                            'FSCTOTAL' =>   $total,
                            'FSCTIPO' =>    $ajax_proforma['proforma']['tipdoc'], // 0: BOLETA, 1:FACTURA
                            'FSCSERNRO' =>  $ajax_proforma['proforma']['seriedoc'],
                            'FSCNRO' =>     $ajax_proforma['proforma']['numerodoc'] //MAS ADELANTE SE UTILIZARA
                        );
                }
                else{
                       $total=0;
                       $detalle = array();
                       foreach ($ajax_proforma['detalle'] as $item) {

                            if($item['cantidad']<0 )
                            {
                                $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'no debe de ingresar numeros negativos', 'titulo' => 'No debe de ingresar numeros negativos');
                                echo json_encode($json);
                                return;
                            }
                            if($item['estado']){
                                $item['estado']=1;
                            }else{
                                $importe=round(($item['cantidad']*$item['precio']),2);
                                $total= $total + $importe ;
                                $item['estado']=0;
                            }

                            $item_aux = array(
                                "PUNIT" =>               $item['precio'],
                                "CANT" =>                $item['cantidad'],
                                "ELIM" =>                $item['estado'],
                                "FACCONCOD" =>           $item['codigo'],
                                "SFACTURA_FSCSERNRO" =>  $ajax_proforma['proforma']['seriedoc'],
                                "SFACTURA_FSCNRO"    =>  $ajax_proforma['proforma']['numerodoc'],
                                "SFACTURA_FSCTIPO"   =>  $ajax_proforma['proforma']['tipdoc']
                            );
                            array_push($detalle, $item_aux);
                        }
                        $proforma = array(
                            'FSCTOTAL'   =>    $total,
                            'FSCTIPO'    =>    $ajax_proforma['proforma']['tipdoc'], // 0: BOLETA, 1:FACTURA
                            'FSCSERNRO'  =>    $ajax_proforma['proforma']['seriedoc'],
                            'FSCNRO'     =>    $ajax_proforma['proforma']['numerodoc'] //MAS ADELANTE SE UTILIZARA
                        );
                    }

                    $val = $this->Comprobante_pago_model->editar_proforma($ajax_proforma['proforma']['tipdoc'],$proforma, $detalle);
                    //respuesta
                    $json = array('result' => $val, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido', 'numero' => $ajax_proforma['proforma']['numerodoc'] , 'serie' => $ajax_proforma['proforma']['seriedoc']);
                    echo json_encode($json);
                    return;
            }
        }
    }
//

// REGISTRAR PROFORMAS
    public function registrar_proforma_boleta(){
        //return;
        $ajax = $this->input->get('ajax');
        if(!$ajax){ 
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }

        if(!isset($_SESSION['BOLETA']['serie']) || $_SESSION['FACTURA']['serie'] == null){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'El area a la que pertenece no tiene serie asignada', 'titulo' => 'No se encontro Serie para esta proforma');
            echo json_encode($json);
            return;
        }

        $aux = $this->input->post('envio');
        $val = false;
        $ajax_proforma = json_decode($aux, true);
        //var_dump($ajax_proforma['proforma']);
        $serie = null;
        $tipo_comprobante = null;
        $tipo_identificacion = null;

        $oordserv = null;
        if(isset($ajax_proforma['proforma']['ordserv'])){
            $oordserv = $ajax_proforma['proforma']['ordserv'];
        }
        $oorpag = null;
        if(isset($ajax_proforma['proforma']['ordpag'])){
            $oorpag = $ajax_proforma['proforma']['ordpag'];
        }

        // =============  VALIDAMOS EL TIPO DE COMPROBANTE A RECEPCIONAR =============  //
            if($ajax_proforma['proforma']['tipo-comprobante']=="BOLETA"){
                $tipo_comprobante = 0;
                $serie = $_SESSION['BOLETA']['serie'];
            }else if($ajax_proforma['proforma']['tipo-comprobante']=="FACTURA"){
                $tipo_comprobante = 1;
                $serie = $_SESSION['FACTURA']['serie'];
            }else{
                $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Tipo de comprobante no valido', 'titulo' => 'Ingreso restringido');
                echo json_encode($json);
                return;
            }
        // ==============================================================================


        // =============  VALIDAMOS EL TIPO DE IDENTIFICACION A RECEPCIONAE ==========  //
            // 1   DNI
            // 4   CARNET DE EXTRANJERIA
            // 6   REGISTRO UNICO DE CONTRIBUYENTES
            // 7   PASAPORTE
            $tipo_identificacion = $ajax_proforma['proforma']['tipdoc'];
            /*if($ajax_proforma['proforma']['tipo_identificacion']=="DNI"){
                $tipo_identificacion = 1;
            }else if($ajax_proforma['proforma']['tipo_identificacion']=="RUC"){
                $tipo_identificacion = 6;
            }else{
                $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Tipo de documento no valido', 'titulo' => 'Ingreso restringido');
                echo json_encode($json);
                return;
            }*/
            //$tipo_identificacion = ($ajax_proforma['proforma']['tipo_identificacion']=="DNI")? 1:6;
        // ==============================================================================

        $var2 = $ajax_proforma['proforma'];
        $proforma = array(

            'FSCTIPO' =>    $tipo_comprobante, // 0: BOLETA, 1:FACTURA
            'FSCSERNRO' =>  $serie,
            'FSCNRO' =>     0, //MAS ADELANTE SE UTILIZARA
            //'FSCFECH' =>  FECHA EMISION
            'FSCREGION' =>  $_SESSION['FSCREGION'],
            'FSCZONA' =>    $_SESSION['FSCZONA'],
            'FSCSECTOR' =>  $_SESSION['FSCSECTOR'],
            'FSCLOCALID' => $_SESSION['FSCLOCALID'],

            'FSCESTADO' =>  0, // 0:PAGADO 1: NO PAGADO
            'FSCFCONT' =>   0,
            //'FSCFCFEC' =>   $var2[''], FECHA EMISION
            'FSCSUBTOTA' => 0,
            'FSCSUBIGV' =>  0,
            'FSCTOTAL' =>   0,
            'FSCCLIUNIC' =>  $var2['FSCCLIUNIC'],//SERA REFERENCIADO DE ALGUN SUMINISTRO
            'FSCCLINOMB' =>  $var2['FSCCLINOMB'],
            'FSCCLIRUC' =>  null,//($tipo_identificacion==6)? $var2['FSCDOC']:null,

            'FSCOFI' => $_SESSION['OFICOD'],
            'FSCAGE' =>     $_SESSION['OFIAGECOD'],
            'FSCDIGCOD' =>  $_SESSION['user_id'],
            //'FSCESFEC' =>   $var2[''],
            'SFACTUR1' =>   0,

            'FSCIGVREF' =>  $_SESSION['IGV'],
            'FSCTIPDOC' =>  $tipo_identificacion,
            'FSCNRODOC' =>  $var2['FSCDOC'],//($tipo_identificacion==1)? $var2['FSCDOC']:null,
            'FSDIREC' =>    $var2['FSDIREC'],
            'EMAIL' =>      $var2['EMAIL'],
            'OBSDOC' =>     $var2['OBSERVACION'],

            'STAEMPCOD'=> ($oordserv==null)? null: $oordserv['STAEMPCOD'],
            'STAOFICOD'=> ($oordserv==null)? null: $oordserv['STAOFICOD'],
            'STAARECOD'=> ($oordserv==null)? null: $oordserv['STAARECOD'],
            'STACTDCOD'=> ($oordserv==null)? null: $oordserv['STACTDCOD'],
            'STADOCCOD'=> ($oordserv==null)? null: $oordserv['STADOCCOD'],
            'STASERNRO'=> ($oordserv==null)? null: $oordserv['STASERNRO'],
            'CDANRO'=> ($oordserv==null)? null: $oordserv['CDANRO'],
            'STPEMPCOD'=> ($oordserv==null)? null: $oordserv['STPEMPCOD'],
            'STPOFICOD'=> ($oordserv==null)? null: $oordserv['STPOFICOD'],
            'STPARECOD'=> ($oordserv==null)? null: $oordserv['STPARECOD'],
            'STPCTDCOD'=> ($oordserv==null)? null: $oordserv['STPCTDCOD'],
            'STPDOCCOD'=> ($oordserv==null)? null: $oordserv['STPDOCCOD'],
            'STPSERNRO'=> ($oordserv==null)? null: $oordserv['STPSERNRO'] ,
            'CDPNRO'=> ($oordserv==null)? null:$oordserv['CDPNRO'],
            'GEMPCOD'=> $_SESSION['NSEMPCOD'], 
            'GFICOD'=> $_SESSION['NSOFICOD'], 
            'GARECOD'=> $_SESSION['NSARECOD'], 
            'GCTDCOD'=> 1, 
            'GDOCCOD'=> 2, 
            'GSERNRO'=>  $serie, 
            'GNRO'=>  0,
            'CONCEPT_GRATUITO' => $var2['GRATUITO'],
            'TIP_AFEC_IGV'=> $var2['tip_afecta_igv']
            
        );

        $proforma['FSCNRO'] = $this->Comprobante_pago_model->max_nro_proforma($serie, $tipo_comprobante)['NRO'] + 1;

        $detalle = array();
        $subtotal = 0;
        $subtotaligv = 0;
        $total = 0;
        $total_exoneradas = 0;
        $total_inafecta = 0;
        $total_gratuito = 0;
        foreach ($ajax_proforma['detalle'] as $item) {
        
            $afecigv = $var2['tip_afecta_igv'] ;
            $con_igv =  $var2['tip_afecta_igv'] ;
            $precios = $this->calcular_precio($item['precio'], $item['cantidad'], $con_igv, $item['gratuito']);
            $item_aux = array(
                "SFACTURA_FSCSERNRO" =>     $proforma['FSCSERNRO'],
                "SFACTURA_FSCNRO" =>        $proforma['FSCNRO'],
                "SFACTURA_FSCTIPO" =>       $proforma['FSCTIPO'],
                "FACCONCOD" =>              $item['codigo'],
                "SERFCONT" =>               -1,
                "CANT" =>                   $precios['CANT'],
                "PUNIT" =>                  $precios['UNIT'],
                "FSCPRECIO" =>              $precios['TOT']-$precios['SUBIGV'],
                "PRECIGV" =>                $precios['SUBIGV'],
                "SERCOD" =>                 -1,
                "DRC" =>                    0,
                "SERVIDOR" =>               $_SESSION['user_data']['SERVIDOR'],
                'OBSFACAUX' =>              isset($item['observacion'])? $item['observacion']:null,
                'AFECIGV' =>                $afecigv,
                'GRAT' =>                   $item['gratuito']

            );
            if($var2['tip_afecta_igv'] >= 10 && $var2['tip_afecta_igv'] <= 17 ){
                $subtotaligv += $item_aux['PRECIGV'];
                $total += $item_aux['FSCPRECIO']+$item_aux['PRECIGV'];
                $subtotal += $item_aux['FSCPRECIO'];
            }
            if($var2['tip_afecta_igv']  == 20 ){
                $total_exoneradas += $item_aux['FSCPRECIO'];
            }
            if ($var2['tip_afecta_igv'] == 21 ){
                $total_gratuito += $item_aux['FSCPRECIO'];
            }
            if($var2['tip_afecta_igv'] >= 30 && $var2['tip_afecta_igv'] <= 36){
                $total_inafecta += $item_aux['FSCPRECIO']; 
            }
            array_push($detalle, $item_aux);
        }

        //$proforma['FSCSUBTOTA'] = ($subtotal > 0) ? $subtotal : 0;
        $proforma['FSCSUBTOTA'] = $subtotal + $total_exoneradas + $total_inafecta + $total_gratuito   ;
        $proforma['FSCSUBIGV'] = ($subtotaligv > 0 ) ? $subtotaligv : 0 ;
        $proforma['FSCTOTAL'] = $total + $total_exoneradas + $total_inafecta + $total_gratuito  ;
        $proforma['FSCTOTAL_EXO'] = ($total_exoneradas > 0 ) ? $total_exoneradas : 0 ; 
        $proforma['FSCTOTAL_INAF'] = ($total_inafecta > 0) ? $total_inafecta : 0 ;
        $proforma['FSCTOTAL_GRATUITO'] = ($total_gratuito > 0 ) ? $total_gratuito : 0 ; 
        $proforma['FSCTOTAL_GRAB'] = ($total > 0) ? $total  : 0 ;
        $val = $this->Comprobante_pago_model->registrar_proforma($proforma, $detalle);
        if ($ajax == true) {
            $json = array('result' => $val, 'mensaje' => 'OK', 'codigo' => array($proforma, $detalle));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }

    public function registrar_proforma_factura(){
        $ajax = $this->input->get('ajax');

        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }

        $aux = $this->input->post('envio');
        $val = false;
        //$ajax_proforma = json_decode($aux, true);
        $ajax_proforma = $aux;
        //var_dump($ajax_proforma);
        //var_dump($ajax_proforma['proforma']);
        $serie = null;
        $tipo_comprobante = null;

        $oordserv = null;
        if(isset($ajax_proforma['proforma']['ordserv'])){
            $oordserv = $ajax_proforma['proforma']['ordserv'];
        }
        $oorpag = null;
        if(isset($ajax_proforma['proforma']['ordpag'])){
            $oorpag = $ajax_proforma['proforma']['ordpag'];
        }

        // =============  VALIDAMOS EL TIPO DE COMPROBANTE A RECEPCIONAR =============  //
            if($ajax_proforma['proforma']['tipo-comprobante']=="BOLETA"){
                $tipo_comprobante = 0;
                $serie = $_SESSION['BOLETA']['serie'];
            }else if($ajax_proforma['proforma']['tipo-comprobante']=="FACTURA"){
                $tipo_comprobante = 1;
                $serie = $_SESSION['FACTURA']['serie'];
            }else{
                $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Tipo de comprobante no valido', 'titulo' => 'Ingreso restringido');
                echo json_encode($json);
                return;
            }
        // ==============================================================================


        // =============  VALIDAMOS EL TIPO DE IDENTIFICACION A RECEPCIONAE ==========  //
            // 1: DNI
            // 6: RUC
            /*if($ajax_proforma['proforma']['tipo_identificacion']=="DNI"){
                $tipo_identificacion = 1;
            }else*/ if($ajax_proforma['proforma']['tipo_identificacion']=="RUC"){
                $tipo_identificacion = 6;
            }else{
                $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Tipo de documento no valido', 'titulo' => 'Ingreso restringido');
                echo json_encode($json);
                return;
            }
            //$tipo_identificacion = ($ajax_proforma['proforma']['tipo_identificacion']=="DNI")? 1:6;
        // ==============================================================================

        /*if($ajax_proforma['proforma']['tipo-comprobante']=="BOLETA"){
            $tipo_comprobante = 0;
            $serie = $_SESSION['BOLETA']['serie'];
        }else{
            $tipo_comprobante = 1;
            $serie = $_SESSION['FACTURA']['serie'];
        }*/

        // 1: DNI
        // 6: RUC
        $tipo_identificacion = ($ajax_proforma['proforma']['tipo_identificacion']=="DNI")? 1:6;


        $var2 = $ajax_proforma['proforma'];
        $proforma = array(

            'FSCTIPO' =>    $tipo_comprobante, // 0: BOLETA, 1:FACTURA
            'FSCSERNRO' =>  $serie,
            'FSCNRO' =>     0, //MAS ADELANTE SE UTILIZARA
            //'FSCFECH' =>  FECHA EMISION

            'FSCREGION' =>  $_SESSION['FSCREGION'],
            'FSCZONA' =>    $_SESSION['FSCZONA'],
            'FSCSECTOR' =>  $_SESSION['FSCSECTOR'],
            'FSCLOCALID' => $_SESSION['FSCLOCALID'],

            'FSCESTADO' =>  0, // 0:PAGADO 1: NO PAGADO
            'FSCFCONT' =>   0,
            //'FSCFCFEC' =>   $var2[''], FECHA EMISION
            'FSCSUBTOTA' => 0,
            'FSCSUBIGV' =>  0,
            'FSCTOTAL' =>   0,
            'FSCCLIUNIC' =>  $var2['FSCCLIUNIC'],//SERA REFERENCIADO DE ALGUN SUMINISTRO
            'FSCCLINOMB' =>  $var2['FSCCLINOMB'],
            'FSCCLIRUC' =>  ($tipo_identificacion==6)? $var2['FSCDOC']:null,

            'FSCOFI' => $_SESSION['OFICOD'],
            'FSCAGE' =>     $_SESSION['OFIAGECOD'],
            'FSCDIGCOD' =>  $_SESSION['user_id'],
            //'FSCESFEC' =>   $var2[''],
            'SFACTUR1' =>   0,
            //'DRC' =>    $var2[''],

            //'FSCOFIPAG' =>  $var2[''],
            //'FSCAGEPAG' =>  $var2[''],
            //'FSCUSRPAG' =>  $var2[''],
            //'FSCTICKT' =>   $var2[''],
            'FSCIGVREF' =>  $_SESSION['IGV'],
            'FSCTIPDOC' =>  $tipo_identificacion,
            'FSCNRODOC' =>  ($tipo_identificacion==1)? $var2['FSCDOC']:null,
            'FSDIREC' =>    $var2['FSDIREC'],
            'EMAIL' =>    $var2['EMAIL'],
            'OBSDOC' =>     $var2['OBSERVACION'],
            // STAEMPCOD, STAOFICOD, STAARECOD, STACTDCOD,
            // STADOCCOD, STASERNRO, CDANRO, STPEMPCOD,
            // STPOFICOD, STPARECOD, STPCTDCOD, STPDOCCOD, STPSERNRO, CDPNRO
            'STAEMPCOD'=> ($oordserv==null)? null: $oordserv['STAEMPCOD'],
            'STAOFICOD'=> ($oordserv==null)? null: $oordserv['STAOFICOD'],
            'STAARECOD'=> ($oordserv==null)? null: $oordserv['STAARECOD'],
            'STACTDCOD'=> ($oordserv==null)? null: $oordserv['STACTDCOD'],
            'STADOCCOD'=> ($oordserv==null)? null: $oordserv['STADOCCOD'],
            'STASERNRO'=> ($oordserv==null)? null: $oordserv['STASERNRO'],
            'CDANRO'=> ($oordserv==null)? null: $oordserv['CDANRO'],
            'STPEMPCOD'=> ($oordserv==null)? null: $oordserv['STPEMPCOD'],
            'STPOFICOD'=> ($oordserv==null)? null: $oordserv['STPOFICOD'],
            'STPARECOD'=> ($oordserv==null)? null: $oordserv['STPARECOD'],
            'STPCTDCOD'=> ($oordserv==null)? null: $oordserv['STPCTDCOD'],
            'STPDOCCOD'=> ($oordserv==null)? null: $oordserv['STPDOCCOD'],
            'STPSERNRO'=> ($oordserv==null)? null: $oordserv['STPSERNRO'] ,
            'CDPNRO'=> ($oordserv==null)? null:$oordserv['CDPNRO'],
            'GEMPCOD'=> $_SESSION['NSEMPCOD'], 
            'GFICOD'=> $_SESSION['NSOFICOD'], 
            'GARECOD'=> $_SESSION['NSARECOD'], 
            'GCTDCOD'=> 1, 
            'GDOCCOD'=> 1, 
            'GSERNRO'=>  $serie, 
            'GNRO'=>  0, 
            'CONCEPT_GRATUITO' => $var2['GRATUITO'],
            'TIP_AFEC_IGV'=> $var2['tip_afecta_igv']
        );

        $proforma['FSCNRO'] = $this->Comprobante_pago_model->max_nro_proforma($serie, $tipo_comprobante)['NRO'] + 1;

        //$detalle_aux = $ajax_proforma['detalle'];
        $detalle = array();
        $subtotal = 0;
        $subtotaligv = 0;
        $total = 0;
        $total_exoneradas = 0;
        $total_inafecta = 0;
        $total_gratuito = 0;
        foreach ($ajax_proforma['detalle'] as $item) {
            $afecigv = $var2['tip_afecta_igv'] ;
            $con_igv =  $var2['tip_afecta_igv'] ;
            $precios = $this->calcular_precio($item['precio'], $item['cantidad'], $con_igv, $item['gratuito']);

            $item_aux = array(
                "SFACTURA_FSCSERNRO" =>     $proforma['FSCSERNRO'],
                "SFACTURA_FSCNRO" =>        $proforma['FSCNRO'],
                "SFACTURA_FSCTIPO" =>       $proforma['FSCTIPO'],
                "FACCONCOD" =>              $item['codigo'],
                "SERFCONT" =>               -1,
                "CANT" =>                   $precios['CANT'],
                "PUNIT" =>                  $precios['UNIT'],
                "FSCPRECIO" =>              $precios['TOT']-$precios['SUBIGV'],
                "PRECIGV" =>                $precios['SUBIGV'],
                "SERCOD" =>                 -1,
                "DRC" =>                    0,
                "SERVIDOR" =>               $_SESSION['user_data']['SERVIDOR'],
                'OBSFACAUX' =>              isset($item['observacion'])? $item['observacion']:null,
                'AFECIGV' =>                $afecigv,
                'GRAT' =>                   $item['gratuito']
            );

            if($var2['tip_afecta_igv'] >= 10 && $var2['tip_afecta_igv'] <= 17 ){
                $subtotaligv += $item_aux['PRECIGV'];
                $total += $item_aux['FSCPRECIO']+$item_aux['PRECIGV'];
                $subtotal += $item_aux['FSCPRECIO'];
            }
            if($var2['tip_afecta_igv']  == 20 ){
                $total_exoneradas += $item_aux['FSCPRECIO'];
            }
            if ($var2['tip_afecta_igv'] == 21 ){
                $total_gratuito += $item_aux['FSCPRECIO'];
            }
            if($var2['tip_afecta_igv'] >= 30 && $var2['tip_afecta_igv'] <= 36){
                $total_inafecta += $item_aux['FSCPRECIO']; 
            }
            array_push($detalle, $item_aux);
        }

        $proforma['FSCSUBTOTA'] = $subtotal + $total_exoneradas + $total_inafecta + $total_gratuito   ;
        $proforma['FSCSUBIGV'] = ($subtotaligv > 0 ) ? $subtotaligv : 0 ;
        $proforma['FSCTOTAL'] = $total + $total_exoneradas + $total_inafecta + $total_gratuito  ;
        $proforma['FSCTOTAL_EXO'] = ($total_exoneradas > 0 ) ? $total_exoneradas : 0 ; 
        $proforma['FSCTOTAL_INAF'] = ($total_inafecta > 0) ? $total_inafecta : 0 ;
        $proforma['FSCTOTAL_GRATUITO'] = ($total_gratuito > 0 ) ? $total_gratuito : 0 ; 
        $proforma['FSCTOTAL_GRAB'] = ($total > 0) ? $total  : 0 ;

        $val = $this->Comprobante_pago_model->registrar_proforma($proforma, $detalle);
        if ($val) {
            $json = array('result' => true, 'mensaje' => 'OK', 'codigo' => array($proforma, $detalle));
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }

    public function registrar_proforma_orden_pago(){
        $ajax = $this->input->get('ajax');
        $aux = $this->input->post('envio');
        $val = false;
        $ajax_proforma = json_decode($aux, true);

        $serie = null;
        $tipo_comprobante = null;

        if($ajax_proforma['proforma']['tipo-comprobante']=="BOLETA"){
            $tipo_comprobante = 0;
            $serie = $_SESSION['BOLETA']['serie'];
        }else{
            $tipo_comprobante = 1;
            $serie = $_SESSION['FACTURA']['serie'];
        }
        // 1: DNI
        // 6: RUC
        $tipo_identificacion = ($ajax_proforma['proforma']['tipo_identificacion']=="DNI")? 1:6;

        $var2 = $ajax_proforma['proforma'];
        $proforma = array(
            'FSCTIPO' =>    $tipo_comprobante, // 0: BOLETA, 1:FACTURA
            'FSCSERNRO' =>  $serie,
            'FSCNRO' =>     0, //MAS ADELANTE SE UTILIZARA
            //'FSCFECH' =>  FECHA EMISION

            'FSCREGION' =>  $_SESSION['FSCREGION'],
            'FSCZONA' =>    $_SESSION['FSCZONA'],
            'FSCSECTOR' =>  $_SESSION['FSCSECTOR'],
            'FSCLOCALID' => $_SESSION['FSCLOCALID'],

            'FSCESTADO' =>  0, // 0:PAGADO 1: NO PAGADO
            'FSCFCONT' =>   0,
            //'FSCFCFEC' =>   $var2[''], FECHA EMISION
            'FSCSUBTOTA' => 0,
            'FSCSUBIGV' =>  0,
            'FSCTOTAL' =>   0,
            'FSCCLIUNIC' =>  $var2['FSCCLIUNIC'],//SERA REFERENCIADO DE ALGUN SUMINISTRO
            'FSCCLINOMB' =>  $var2['FSCCLINOMB'],
            'FSCCLIRUC' =>  ($tipo_identificacion==6)? $var2['FSCDOC']:null,

            'FSCOFI' => $_SESSION['OFICOD'],
            'FSCAGE' =>     $_SESSION['OFIAGECOD'],
            'FSCDIGCOD' =>  $_SESSION['user_id'],
            //'FSCESFEC' =>   $var2[''],
            'SFACTUR1' =>   0,
            //'DRC' =>    $var2[''],

            //'FSCOFIPAG' =>  $var2[''],
            //'FSCAGEPAG' =>  $var2[''],
            //'FSCUSRPAG' =>  $var2[''],
            //'FSCTICKT' =>   $var2[''],
            'FSCIGVREF' =>  $_SESSION['IGV'],
            'FSCTIPDOC' =>  $tipo_identificacion,
            'FSCNRODOC' =>  ($tipo_identificacion==1)? $var2['FSCDOC']:null,
            'FSDIREC' =>    $var2['FSDIREC'],
            'EMAIL' =>    $var2['EMAIL'],
            'OBSDOC' =>     $var2['OBSERVACION']
        );

        $proforma['FSCNRO'] = $this->Comprobante_pago_model->max_nro_proforma($serie, $tipo_comprobante)['NRO'] + 1;

        //$detalle_aux = $ajax_proforma['detalle'];
        $detalle = array();
        $subtotal = 0;
        $subtotaligv = 0;
        $total = 0;
        foreach ($ajax_proforma['detalle'] as $item) {
            //////////////////////////////////////////////////////////////
            $afecigv = ($item['exonerado'] == '1')? '20':
                        (  ($item['conigv']=='S')? '10': '30' );
            $con_igv = ($afecigv == '10');
            /////////////////////////////////////////////////////////////

            $precios = $this->calcular_precio($item['precio'], $item['cantidad'], ($con_igv), ($item['gratuito']=='1'));
            //$precios = $this->calcular_precios($item['precio'], $item['cantidad'], ($item['conigv']=='SI'));
            $item_aux = array(
                "SFACTURA_FSCSERNRO" =>     $proforma['FSCSERNRO'],
                "SFACTURA_FSCNRO" =>        $proforma['FSCNRO'],
                "SFACTURA_FSCTIPO" =>       $proforma['FSCTIPO'],
                "FACCONCOD" =>              $item['codigo'],
                "SERFCONT" =>               -1,
                "CANT" =>                   $precios['CANT'],
                "PUNIT" =>                  $precios['UNIT'],
                "FSCPRECIO" =>              $precios['TOT']-$precios['SUBIGV'],
                "PRECIGV" =>                $precios['SUBIGV'],
                "SERCOD" =>                 -1,
                "DRC" =>                    0,
                "SERVIDOR" =>               $_SESSION['user_data']['SERVIDOR'],
                'OBSFACAUX' =>              $item['observacion'],
                'AFECIGV' =>                $afecigv,
                'GRAT' =>                   $item['gratuito']
            );
            $subtotaligv += $item_aux['PRECIGV'];
            $total += $item_aux['FSCPRECIO']+$item_aux['PRECIGV'];
            $subtotal += $item_aux['FSCPRECIO'];
            array_push($detalle, $item_aux);
        }

        $proforma['FSCSUBTOTA'] = $subtotal;
        $proforma['FSCSUBIGV'] = $subtotaligv;
        $proforma['FSCTOTAL'] = $total;

        // IRA A LA TABLA PROFNS
        $var1 = $ajax_proforma['profns'];
        $profns = array(
            'FSCTIPO' => $tipo_comprobante,
            'FSCSERNRO' => $serie,
            'FSCNRO' => $proforma['FSCNRO'], // MAS ADELANTE SE ACTUALIZARA MAS ADELANTE
            'EMPCOD' => $var1['EMPCOD'],
            'OFICOD' => $var1['OFICOD'],
            'ARECOD' => $var1['ARECOD'],
            'CTDCOD' => $var1['CTDCOD'],
            'DOCCOD' => $var1['DOCCOD'],
            'SERNRO' => $var1['SERNRO'],
            'ORPNRO' => $var1['ORPNRO']
        );
        $val=false;
        $val = $this->Comprobante_pago_model->registrar_proforma_orden_pago($proforma, $detalle ,$profns);
        if ($ajax == true) {
            $json = array('result' => $val, 'mensaje' => 'OK', 'codigo' => array($profns, $proforma, $detalle));

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }
    }

    public function imprimir_documento($documento, $serie, $comprobante){

        $this->load->library('NumberToText');
        $ntt = $this->numbertotext->load(NULL);

        $d = $this->Comprobante_pago_model->get_comprobante_sinpagar($documento, $serie, $comprobante);
        $d['max_filas'] = 7;
        $max_iter = ceil(count($d['descripcion'])/$d['max_filas']);
        $d["max_iter"] = ($max_iter==0)? 1:$max_iter;
        $d['tot'] = $ntt->numtoletras($d['cliente']['FSCTOTAL']);

        //$d['iter'] = 0;
        //$this->load->view('template/Template_Boleta', $d);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load('"","A5","","",5,5,5,5,0,0');


        //$mpdf->SetWatermarkText("SEDALIB S.A.");
        //$mpdf->showWatermarkText = true;
        //$mpdf->watermark_font = 'DejaVuSansCondensed';
        //$mpdf->watermarkTextAlpha = 0.5;

        for($i=0; $i<$max_iter; $i++){
            $mpdf->AddPage('L', NULL, NULL, NULL, 10, 10, 10, 10);

            $d['iter'] = $i;
            $html = $this->load->view('template/Template_Proforma', $d, true);
            $mpdf->WriteHTML($html);
            //$this->load->view('template/Template_Proforma', $d);
            //return;
            //
        }

        //load the view and saved it into $html variable


        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        ob_flush();
        exit;
    }
//

    public function buscar_oordpag(){
        $ajax = $this->input->get('ajax');
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $ini = $this->input->post('inicio');
        $fin = $this->input->post('fin');

        $oordpag = $this->Oordpag_model->get_all_oordpag($ini, $fin);


        $json = array('result' => true, 'oordpag' => $oordpag);
        echo json_encode($json);
    }


    /*==================================================================================*/
}
