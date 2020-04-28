<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    
    class Registro_reclamo_ctrllr extends CI_Controller{

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
            $this->data['actividad'] = 'REG_RECLAMO';
            
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

        public function imprimir_reclamo(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $array = json_decode($this->input->post('imprimir_reclamo'));
                $empresa = explode("-", $array[1]) ; //empresa
                $reclamo = $this->Reclamo_no_facturacion_model->get_reclamo($empresa[0], $_SESSION['NSOFICOD'], $_SESSION['NSARECOD'], 4, 5, $array[0], $array[2]);
                $reclamante = $this->Reclamo_no_facturacion_model->get_reclamante_concilia($reclamo['PRECOD']);
                $direccion = $this->Reclamo_no_facturacion_model->get_dire_reclamante($reclamante['CDPCOD'], $reclamante['CPVCOD'], $reclamante['CDSCOD'], $reclamante['CGPCOD'], $reclamante['MVICOD']);
                $direccion_procesal = $this->Reclamo_no_facturacion_model->get_dire_reclamante($reclamante['CDPCODDP'], $reclamante['CPVCODDP'], $reclamante['CDSCODDP'], $reclamante['CGPCODDP'], $reclamante['MVICODDP']);
                $descri_problema = $this->Reclamo_no_facturacion_model->get_descri_reclamo($reclamo);
                $conciliacion = $this->Reclamo_no_facturacion_model->get_concilia_reclamo($reclamo);
                //var_dump($conciliacion);
                //var_dump( $descri_problema);
                //var_dump( $reclamo); 
                //var_dump($reclamante);
                //var_dump($direccion);
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
                $resultado = $this->lib_tcpdf-> imprimir_reclamo($pdf, $reclamo, $reclamante, $direccion, $direccion_procesal, $descri_problema, $empresa[1],$conciliacion );
                $resultado->Output('Ficha_reclamo.pdf', 'I'); 
            }
        }

        public function registro(){
        
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $serie = $this->Reclamo_no_facturacion_model->get_serie();
                $this->data['empresa'] = $this->Reclamo_no_facturacion_model->get_empresa();
                $this->data['ultimo_reclamo'] = $this->Reclamo_no_facturacion_model->get_ultimo_reclamo($serie['SERNRO']);
                // modalidad de atencion
                $this->data['moda_atencion'] = $this->Reclamo_no_facturacion_model->moda_atencion();
                // REPRESENTACION RECLAMANTE
                $this->data['repre_reclamante'] = $this->Reclamo_no_facturacion_model->repre_reclamante();
                // INTERVALO DE HORAS 
                $this->data['interva_horas'] = $this->Reclamo_no_facturacion_model->interval_horas();
                // operadores telefonicos
                $this->data['operador_telefonico'] = $this->Reclamo_no_facturacion_model->operadores_telefonicos();
                // TIPO DE PERSONA 
                $this->data['tipo_persona'] = $this->Reclamo_no_facturacion_model->tipo_persona();
                // ESTADO DE PERSONA
                $this->data['estado_persona'] = $this->Reclamo_no_facturacion_model->estado_persona();
                /* TIPO DE DOCUMENTO  */
                $this->data['tipo_documento'] = $this->Reclamo_no_facturacion_model->tipo_documento();
                /* OFICINAS Y AREAS  */
                $this->data['Ofi_areas'] = $this->Reclamo_no_facturacion_model->ofi_Areas();
                //WEB SUNAT
                $this->data['rutabsq1'] = 'https://cel.reniec.gob.pe/valreg/valreg.do;jsessionid=97657851cf84a1b5e8e57db400289a1dfe6deb1635f.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaMa3D3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaPb3aPbhiTbN4xf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_';
                $this->data['view'] = 'reclamo_no_facturacion/Registrar_reclamo_view';
                $this->data['breadcrumbs'] = array(array('Registrar_reclamo', ''));
                $this->load->view('template/Master', $this->data);
            } else {
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            } 
        }


        public function guardar_derivados(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                
                $empresa        =  explode('-', $this->input->post('empresa'));
                $oficina        =  explode('-', $this->input->post('oficina'));
                $area           =  explode('-', $this->input->post('area'));
                $serie          =  trim( $this->input->post('serie'));
                $ctdcod         =  explode('-', $this->input->post('ctdcod'));
                $doccod         =  explode('-', $this->input->post('doccod'));
                $recid          =  trim($this->input->post('recid'));
                if($this->input->post('tipo_opera') !='3'){
                    $fecha_max      =  $this->input->post('fech_max');
                    $fecha_actual   =  $this->input->post('fech_actual');
                    $area_deriva    =  explode('-', $this->input->post('area_deri'));
                    $ofi_deriva     =  explode('-', $this->input->post('oficina_deriva'));
                    $empresa_deriva =  explode('-', $this->input->post('empresa_deriva'));
                    $descri_deriva  =  $this->input->post('descri_deriva');
                    if($this->input->post('tipo_opera') =='1'){
                        $Parametros = array(
                            'EMPCOD' => $empresa[0],
                            'ARECOD' => $area[0],
                            'OFICOD' => $oficina[0],
                            'CTDCOD' => $ctdcod[0],
                            'DOCCOD' => $doccod[0],
                            'SERNRO' => $serie,
                            'RECID' => $recid,
                            'ARDCOD' => '',
                            'DRVFSOL' => trim($fecha_actual),
                            'DRVSOL' => trim($descri_deriva),
                            'DRVFPZO' => trim($fecha_max ),
                            'USRCODDE' => $_SESSION['user_id'],
                            'SARDCOD' => 1,
                            'ARECODDE' => $area_deriva[0],
                            'OFICODDE' => $ofi_deriva[0],
                            'EMPCODDE' => $empresa_deriva[0]);
                        $resultado = $this->Reclamo_no_facturacion_model->set_deriva_reclamo($Parametros, $empresa[0], $area[0], $oficina[0], $ctdcod[0],  $doccod[0], $serie, $recid  );
                    }else{
                        if( $this->input->post('tipo_opera') == '2' ){
                            $id_reclamo = trim($this->input->post('dato_deriva'));
                            $Parametros = array(
                                'DRVFSOL' => trim($fecha_actual),
                                'DRVSOL' => trim($descri_deriva),
                                'DRVFPZO' => trim($fecha_max ),
                                'ARECODDE' => $area_deriva[0],
                                'OFICODDE' => $ofi_deriva[0],
                                'EMPCODDE' => $empresa_deriva[0]);
                            $resultado = $this->Reclamo_no_facturacion_model->set_deriva__edita_reclamo($Parametros, $empresa[0], $area[0], $oficina[0], $ctdcod[0],  $doccod[0], $serie, $recid, $id_reclamo);
                        }
                    }
                }else{
                    $id_reclamo = trim($this->input->post('dato_deriva'));
                    $Parametros = array(
                        'SARDCOD' => 3);
                    $resultado = $this->Reclamo_no_facturacion_model->set_deriva__edita_reclamo($Parametros, $empresa[0], $area[0], $oficina[0], $ctdcod[0],  $doccod[0], $serie, $recid, $id_reclamo);
                }
                
                
                $json = array('respuesta' => $resultado);
                echo json_encode($json);
                
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function buscar_para_edicion(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $codigo =  $this->input->post('codi');
                $resultado = $this->Reclamo_no_facturacion_model->get_reclamante_edicion($codigo);
                if( count($resultado)>0 ){
                    $direccion = $this->Reclamo_no_facturacion_model->get_dire_reclamante($resultado['CDPCOD'], $resultado['CPVCOD'], $resultado['CDSCOD'], $resultado['CGPCOD'], $resultado['MVICOD']);
                    $dire_procesal = $this->Reclamo_no_facturacion_model->get_dire_reclamante($resultado['CDPCODDP'], $resultado['CPVCODDP'], $resultado['CDSCODDP'], $resultado['CGPCODDP'], $resultado['MVICODDP']);
                    $json = array('respuesta' => true,'persona' => $resultado, 'direccion' => $direccion, 'dire_procesal' => $dire_procesal, 'tipo' => 'success', 'mensaje' => '', 'titulo' => '-- encontrado exitosamente');
                    echo json_encode($json);
                }
                
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function buscar_dni(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $id = $this->input->post('dni');
                $resultado = $this->Reclamo_no_facturacion_model->get_dni_reclamo($id);
                if(!is_null($resultado)){
                    $direccion = $this->Reclamo_no_facturacion_model->get_dire_reclamante($resultado['CDPCOD'], $resultado['CPVCOD'], $resultado['CDSCOD'], $resultado['CGPCOD'], $resultado['MVICOD']);
                    $json = array('result' => true, 'dni'=>true, 'persona' => $resultado, 'direccion' => $direccion  ,'tipo' => 'success', 'mensaje' => '', 'titulo' => '-- encontrado exitosamente');
                    echo json_encode($json);
                }else{
                    $json = array('result' => true, 'dni'=>false, 'tipo' => 'info', 'mensaje' => '--'.$id.' no se encuentra registrado', 'titulo' => '');
                    echo json_encode($json);
                }
                
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function buscar_direccion(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $grupo_poblacional = $this->input->post('grupo_pobla');
                $via = $this->input->post('via_pobla');
                if($grupo_poblacional != '' && $via != '' ){
                    $resultado =  $this->Reclamo_no_facturacion_model->busqueda_direccion_ambos($grupo_poblacional, $via);
                }else{
                    if ($grupo_poblacional != ''){
                        $resultado =  $this->Reclamo_no_facturacion_model->busqueda_direccion_grupo($grupo_poblacional);
                    }else{
                        $resultado =  $this->Reclamo_no_facturacion_model->busqueda_direccion_via($via);
                    }
                }
                if(count($resultado)>0){
                    $dato = array(
                        'respuesta'=> true,
                        'datos' => $resultado
                    );
                }else{
                    $dato = array(
                        'respuesta'=> false,
                        'datos' => 0
                    );
                }
                header('Content-Type: application/json');
                echo json_encode($dato);

            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }

        }

        public function guardar_reclamante(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $depa_dire = explode("-", $this->input->post('depa_dire'));
                $pro_dire  = explode("-", $this->input->post('prov_dire'));
                $dis_dire  = explode("-", $this->input->post('distrito_dire'));
                $grup_pobla= explode("-", $this->input->post('grup_pobla'));
                $via_pobla = explode("-", $this->input->post('via_dire')) ;
                // para domicilio procesal
                $depa_procesal = explode("-", $this->input->post('depa_procesal'));
                $pro_procesal  = explode("-", $this->input->post('prov_procesal'));
                $dis_procesal  = explode("-", $this->input->post('dist_procesal'));
                $grup_procesal= explode("-", $this->input->post('grup_procesal'));
                $via_procesal = explode("-", $this->input->post('vi_procesal'));
                // obtengo la data 
                $parametros = array(
                    'PREDES' => 'PROPIETARIO',
                    'PREAPEPAT' => $this->input->post('ape_paterno'),
                    'PREAPEMAT' => $this->input->post('ape_materno'),
                    'TOTELCOD' => $this->input->post('tip_operador'),
                    'TPERSCOD' => $this->input->post('tip_persona'),
                    'SSOLPCOD' => $this->input->post('est_persona'),
                    'TDICOD' => $this->input->post('tip_docu'),
                    'PRENOM' => $this->input->post('nom'),
                    'PREDOCID' => $this->input->post('documento'),
                    'PREMAIL' => $this->input->post('corr'),
                    'PRETEL' => $this->input->post('cel'),
                    'PREDPMAIL' => $this->input->post('corr'),
                    'PREDPTELF' => $this->input->post('cel'),
                    'PRERAZSOC' => $this->input->post('razon_social'),
                    'CDPCOD' => $depa_dire[0],
                    'CPVCOD' => $pro_dire[0],
                    'CDSCOD' => $dis_dire[0],
                    'CGPCOD' => $grup_pobla[0],
                    'MVICOD' => $via_pobla[0],
                    'PRENROM' => $this->input->post('numero_dire'),
                    'PREMZN' => $this->input->post('mna_dire'),
                    'PRELOT' => $this->input->post('lot_dire'),
                    'CDPCODDP' => $depa_procesal[0],
                    'CPVCODDP' => $pro_procesal[0],
                    'CDSCODDP' => $dis_procesal[0],
                    'CGPCODDP' => $grup_procesal[0],
                    'MVICODDP' => $via_procesal[0],
                    'PREDPNMUN' => $this->input->post('nro_procesal'),
                    'PREDPMZN' => $this->input->post('man_procesal'),
                    'PREDPLOTE' => $this->input->post('lot_procesal')
                );
                $operacion = $this->input->post('tip_opera');
                if($operacion =='1') {
                    $respuesta = $this->Reclamo_no_facturacion_model->set_reclamante($parametros);
                    if($respuesta){
                        $json = array('result' => $respuesta,'mensaje' => 'Registro exitoso', 'titulo' => '');
                    }else{
                        $json = array('result' => $respuesta,'mensaje' => 'No se pudo registrar', 'titulo' => '');
                    }
                    
                    echo json_encode($json);
                }else{
                    $codigo = $this->input->post('cod');
                    if($codigo !=''){
                        $respuesta = $this->Reclamo_no_facturacion_model->set_update_reclamante($parametros, $codigo);
                        if($respuesta){
                            $json = array('result' => $respuesta,'mensaje' => 'Edición exitosa', 'titulo' => '');
                        }else{
                            $json = array('result' => $respuesta,'mensaje' => 'No se pudo editar', 'titulo' => '');
                        }
                        
                        echo json_encode($json);
                    }else{
                        $json = array('result' => false,'mensaje' => 'No se pudó editar', 'titulo' => '');
                        echo json_encode($json);

                    }
                }
                
                
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function intevalo_reclamos(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $hoy = $this->input->post('fin');
                $min = $this->input->post('inicio');
                $lista_reclamos = $this->Reclamo_no_facturacion_model->get_rango_reclamos($min, $hoy);
                $json = array('result' => true,  'lista_reclamos'=> $lista_reclamos);
                echo json_encode($json);
                return;
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function obtener_derivados(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $empresa =  $this->input->post('empresa');
                $oficina =  $this->input->post('oficina');
                $area =  $this->input->post('area');
                $ctdcod =  $this->input->post('ctdcod');
                $doccod =  $this->input->post('doccod');
                $serie =  $this->input->post('serie');
                $reclamo =  $this->input->post('reclamo'); 

                //var_dump( array($empresa, $oficina, $area, $ctdcod, $doccod, $serie, $reclamo));
                //exit();
                $lista_reclamos = $this->Reclamo_no_facturacion_model->get_derivados_reclamo($empresa, $oficina, $area, $ctdcod, $doccod, $serie, $reclamo );
                if(count($lista_reclamos)>0){
                    $json = array('result' => true,  'lista_derivados_reclamo'=> $lista_reclamos);
                }else{
                    $json = array('result' => true,  'lista_derivados_reclamo'=> 0);
                }
                
                echo json_encode($json);
                return;
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function fecha_actual(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $hoy = date("d-m-Y"); 
                $min = strtotime ( '-30 day' , strtotime ( $hoy ) );
                $min= date ( 'd-m-Y' , $min );
                $bandera = date("d/m/Y"); 
                $fecha_maxima = $this->Reclamo_no_facturacion_model->get_fecha_maxima($bandera, '10');
                $lista_reclamos = $this->Reclamo_no_facturacion_model->get_rango_reclamos($min, $hoy);
                $fecha_maxima = $fecha_maxima[0]['FECHAFINNN'];
                $conciliacion = str_replace ( '/' , '-' , $fecha_maxima  );
                $json = array('result' => true, 'fecha' => $hoy, 'fecha_conciliacion' => $conciliacion, 'min_fecha' =>  $min, 'lista_reclamos'=> $lista_reclamos);
                echo json_encode($json);
                return;
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function solicitud_seleccionada(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                $data = json_decode($_POST['solicitud']);
                $arreglo  = get_object_vars( $data  );
                $descri_reclamo = $this->Reclamo_no_facturacion_model->get_descri_reclamo($arreglo);
                $hoy = date("d/m/Y"); 
                $fecha_maxima = $this->Reclamo_no_facturacion_model->get_fecha_maxima($hoy, $descri_reclamo[0]['PRBPZOREC']);
                $fecha_maxima_res_simple = $this->Reclamo_no_facturacion_model->get_fecha_maxima($hoy, $descri_reclamo[0]['PRBPZORESS']);
                $json = array('result' => true,   'descri_reclamo' => $descri_reclamo, 
                            'dias_reclamo' => $descri_reclamo[0]['PRBPZOREC'],'fecha_maxima' => $fecha_maxima[0], 'fecha_resolucion' => $fecha_maxima_res_simple,
                            'tipo' => 'success', 'mensaje' => '', 'titulo' => '-- encontrado exitosamente');
                echo json_encode($json);
                return ;

            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        public function guardar_reclamo_nuevo(){
            $permiso = $this->Reclamo_no_facturacion_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
            if($permiso){
                $ajax = $this->input->get('ajax'); 
                if(!$ajax){
                    $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
                    echo json_encode($json);
                    return;
                }
                
                // obtengo la data 
                $empresa = $this->Reclamo_no_facturacion_model->get_empresa();
                $resultado = $this->Reclamo_no_facturacion_model->get_dni_reclamo($this->input->post('num_doc'));
                $codigo_reclamo = $this->Reclamo_no_facturacion_model->get_codigo_reclamo();
                $CPID  = explode("-", $this->input->post('cat_cli')) ; //CPID
                $SCATPROBID  = explode("-", $this->input->post('sub_cat_cli')); // SCATPROBID
                $TIPPROBID = explode("-", $this->input->post('tip_prob') ); // TIPPROBID
                $PROBID     = explode("-", $this->input->post('pro_cli') ); // PROBID
                //
                $ETARECLAMO  = explode("-", $this->input->post('tipo_eta_recla'));
                $INSTARECLA  = explode("-", $this->input->post('inst_recla')); 
                $CIERRERELCAMO  = explode("-", $this->input->post('cierre_recla')); 
                $SITRECLA  = explode("-", $this->input->post('sit_recla')); 
                $parametros = array(
                    'EMPCOD' => $empresa['EMPCOD'],
                    'OFICOD' => $_SESSION['NSOFICOD'],
                    'ARECOD' => $_SESSION['NSARECOD'],
                    'CTDCOD' => 4,
                    'DOCCOD' => 5,
                    'SERNRO' => $this->input->post('ser'),
                    'RECID' => '',
                    'UUCOD' => $this->input->post('cod'),
                    'RECDESC' => $this->input->post('descri_recla'),
                    'RECFUNDA' => $this->input->post('fund_recla'),
                    'RECFCH' => date('d/m/Y'),
                    'RECPZOAT' => $this->input->post('pla_max'),
                    'RECFCHPZOA' => $this->input->post('fe_pla_max'),
                    'CDPCODDPR' => $resultado['CDPCODDP'],
                    'CPVCODDPR' => $resultado['CPVCODDP'],
                    'CDSCODDPR' => $resultado['CDSCODDP'],
                    'CGPCODDPR' => $resultado['CGPCODDP'],
                    'MVICODDPR' => $resultado['MVICODDP'],
                    'RECDPNMUN' => $resultado['PREDPNMUN'],
                    'RECDPMZN' =>  $resultado['PREDPMZN'],
                    'RECDPLOTE' => $resultado['PREDPLOTE'],
                    'RECDPCODP' => '',
                    'RECDPTELF' => $this->input->post('tel'),
                    'RECDPMAIL' => $this->input->post('corr'),
                    'RECCARTILLA' => $this->input->post('rad_cart'),
                    'RECDECLA' => $this->input->post('rad_contra'),
                    'CPID' => trim($CPID[0]),
                    'TIPPROBID' => trim($TIPPROBID[0]),
                    'SCATPROBID' => trim($SCATPROBID[0]),
                    'PROBID' => trim($PROBID[0]),
                    'MOACOD' => $this->input->post('mot_aten'),
                    'PRECOD' => $resultado['PRECOD'],
                    'TREPCOD' => $this->input->post('tip_representa'),
                    'RECDOCPODER' => $this->input->post('doc_representa'),
                    'RECDOCPODVIG' => $this->input->post('fech_vig_repre'),
                    'SRECCOD' => 1, // preguntar al ing estado de reclamo
                    'USRCODER' => $_SESSION['user_id'],
                    'TETACOD' => trim($ETARECLAMO[0]),
                    'RESFCHET' => $this->input->post('fech_eta_recla'),
                    'TINSCOD' => trim($INSTARECLA[0]),
                    'RESFCHIN' => $this->input->post('fech_insta_recla'),
                    'SSITCOD' => trim($SITRECLA[0]),  // SITUACION DE RECLAMO (PREGUNTAR AL ING)
                    'RECFCIE' => $this->input->post('fe_cierre_recla'),
                    'TMCRCOD' => trim($CIERRERELCAMO[0]),
                    "RECASAC" => "N",
                    "RECRSPD" => "N",
                    "RSLFCHMAXEMI" => $this->input->post('fch_max_res'),
                    "RECANIOREC" => date("Y"),
                    "RECMESREC"  => date("m"),
                    "ORECMAILSN" =>$this->input->post('rad_correo'),
                    "RECPASSWEB" => $codigo_reclamo[0]['CODIGO_REC_WEB']
                     
                );

                $ParaConcilia = array(
                    'EMPCOD' => $empresa['EMPCOD'],
                    'OFICOD' => $_SESSION['NSOFICOD'],
                    'ARECOD' => $_SESSION['NSARECOD'],
                    'CTDCOD' => 4,
                    'DOCCOD' => 5,
                    'SERNRO' => $this->input->post('ser'),
                    'RECID'  => '',
                    'CNCDES' => trim($this->input->post('descri_conci')),
                    'CNCCOD' => 0,
                    'CNCFORIMP' => 0,
                    'USRCODCN'  => 0,
                    'CNCFCH' =>  $this->input->post('fecha_con'),
                    'CNCHORINI' => $this->input->post('hra_concilia'),
                    'TPCOCOD' => 0,
                    'SCNCOD' => 1,
                    'TRACUCOD' => 0,
                    'USRCODCONCGE' => 1,

                );

                $rpta = $this->Reclamo_no_facturacion_model->guardar_reclamo_nuevo($parametros, $ParaConcilia);
                if($rpta['respuesta']){
                    $json = array('result' => true, 'titulo' => 'RECLAMO', 'reclamo' => $rpta['id_recla'],   'mensaje' => 'SE GUARDO EXITOSAMENTE', 'tipo' =>'info' );
                    echo json_encode($json);
                    return;
                }else{
                    $json = array('result' => false, 'titulo' => 'RECLAMO', 'mensaje' => 'NO SE PUDO GUARDAR', 'tipo' =>'danger' );
                    echo json_encode($json);
                    return;
                }
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return; 
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
                if( strlen($id) == 11 ){
                    $resultado = $this->Reclamo_no_facturacion_model->get_documento_reclamo($id);
                }else{
                    $grupo = substr($id,0,3);
                    $sub_grupo = substr($id,3,strlen($id));
                    $resultado = $this->Reclamo_no_facturacion_model->get_documento7di_reclamo($grupo, $sub_grupo);
                }
                
                if(!is_null($resultado)){
                    /* PARA OBTENER LA SOLICITUD DE RECLAMO */
                    $sol_reclamo = $this->Reclamo_no_facturacion_model->get_solicitud_reclamo($id);
                    if(count($sol_reclamo)>0){
                        // para el estado del reclamo 
                        $estado_reclamo  = $this->Reclamo_no_facturacion_model->get_estado_reclamo();
                        // etapa de reclamo 
                        $etapa_reclamo  = $this->Reclamo_no_facturacion_model->get_etapa_reclamo();
                        // tipo de instancia
                        $tipo_instancia  = $this->Reclamo_no_facturacion_model->get_instancia_reclamo();
                        // situacion de cierre 
                        $situacion  = $this->Reclamo_no_facturacion_model->get_situacion_cierre();
                        // SITUACION DE RECLAMO 
                        $sit_reclamo = $this->Reclamo_no_facturacion_model->sit_relcamo();
                        // FECHA ACTUAL
                        $hoy = date("d/m/Y"); 
                        // VERIFICO LA CANTIDAD DE SOLICITUDES
                        if(count($sol_reclamo)==1){
                            $descri_reclamo = $this->Reclamo_no_facturacion_model->get_descri_reclamo($sol_reclamo[0]);
                            $fecha_maxima = $this->Reclamo_no_facturacion_model->get_fecha_maxima($hoy, $descri_reclamo[0]['PRBPZOREC']);
                            $fecha_maxima_res_simple = $this->Reclamo_no_facturacion_model->get_fecha_maxima($hoy, $descri_reclamo[0]['PRBPZORESS']);
                            $json = array('result' => true, 'dni'=>true, 'documento' => $resultado, 'descri_reclamo' => $descri_reclamo, 
                                        'fecha_hoy' => $hoy, 'dias_reclamo' => $descri_reclamo[0]['PRBPZOREC']  ,'fecha_maxima' => $fecha_maxima[0] , 
                                        'estado_reclamo' => $estado_reclamo[0], 'etapa_reclamo' => $etapa_reclamo[0],  'tipo_instancia' => $tipo_instancia[0],
                                        'sitacion_cierre'=> $situacion[0], 'sit_recla' => $sit_reclamo[0], 'fecha_resolucion' => $fecha_maxima_res_simple,
                                        'tipo' => 'success', 'mensaje' => '', 'titulo' => '-- encontrado exitosamente');
                            echo json_encode($json);
                            return;
                        }else{
                            $json = array('result' => true, 'dni'=>false, 'solicitud' => $sol_reclamo, 'documento' => $resultado, 
                            'fecha_hoy' => $hoy, 'estado_reclamo' => $estado_reclamo[0], 'etapa_reclamo' => $etapa_reclamo[0],  'tipo_instancia' => $tipo_instancia[0],
                            'sitacion_cierre'=> $situacion[0], 'sit_recla' => $sit_reclamo[0], 'tipo' => 'success', 'mensaje' => '', 'titulo' => '-- encontrado exitosamente');
                            echo json_encode($json);
                        }
                        
                    }else{
                        $json = array('result' => false, 'dni'=>false, 'tipo' => 'warning', 'mensaje' => 'El suministro no tiene solicitudes pendientes de reclamo', 'titulo' => 'RECLAMOS');
                        echo json_encode($json);
                        return;
                    }
                   
                    
                }else{
                    $json = array('result' => false, 'dni'=>false, 'tipo' => 'warning', 'mensaje' => 'Codigo de suministro no valido', 'titulo' => 'RECLAMOS');
                    echo json_encode($json);
                }
            }else{
                $this->session->set_flashdata('mensaje', array('error', $this->config->item('msg_error')));
                redirect($this->config->item('ip').'inicio');
                return;
            }
        }

        
    }