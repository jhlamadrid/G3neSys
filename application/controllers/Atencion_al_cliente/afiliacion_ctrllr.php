<?php
class afiliacion_ctrllr extends CI_Controller{
     
    public function __construct() {
       parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('acceso/Usuario_model');
        //$this->load->model('acceso/Perfil_model');
        //$this->load->model('acceso/Cargo_model');
        $this->load->model('Atencion_al_cliente/afiliacion_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->acceso_cls->isLogin();
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Afilio o Desafilio Usuarios';
        $this->data['menu']['padre'] = 'atencion_cliente';
        $this->data['menu']['hijo'] = 'afilio';
        $this->load->model('Atencion_al_cliente/afiliacion_model');
        
     }
    public function busca_sumi(){
        $ajax = $this->input->get('ajax');
        if($ajax=true){
            $suministro = $this->input->post('suministro');
            $estado_cliente = $this->input->post('estado_cliente');
            $dato_general=$this->afiliacion_model->get_suministro($suministro);// datos generales
            if($dato_general)
            {    
                $user_afiliado=$this->afiliacion_model->get_afilia_desafilia($suministro);// datos generales
                if($user_afiliado){
                     if($estado_cliente=='desafiliacion')
                       {
                          if( $user_afiliado[0]['ESTADO']=="A"){
                            $json =  array('result' =>  true, 'mensaje' => 'LLEGO CON EXITO', 'dato_general' => $dato_general,'usuario_afiliado' =>$user_afiliado , 'estado' => 1);
                             header('Access-Control-Allow-Origin: *');
                             header('Content-Type: application/x-json; charset=utf-8');
                             echo json_encode($json);
                          }else{
                            $json =  array('result' =>  false, 'mensaje' => 'EL USUARIO YA ESTA DESAFILIADO');
                             header('Access-Control-Allow-Origin: *');
                             header('Content-Type: application/x-json; charset=utf-8');
                             echo json_encode($json);
                          }
                          
                       }                  
                    if($estado_cliente =='afiliacion')
                       {
                           if($user_afiliado[0]['ESTADO']=="D"){
                                $json =  array('result' =>  true, 'mensaje' => 'LLEGO CON EXITO', 'dato_general' => $dato_general ,'usuario_afiliado' =>$user_afiliado , 'estado' => 2);
                                 header('Access-Control-Allow-Origin: *');
                                 header('Content-Type: application/x-json; charset=utf-8');
                                 echo json_encode($json);
                           }
                           else{
                                $json =  array('result' =>  false, 'mensaje' => 'EL USUARIO YA ESTA AFILIADO');
                             header('Access-Control-Allow-Origin: *');
                             header('Content-Type: application/x-json; charset=utf-8');
                             echo json_encode($json);
                           }
                          
                       }
                   
                }
                else{

                    if($estado_cliente =='desafiliacion'){
                        $json =  array('result' =>  false, 'mensaje' => 'PRIMERO TIENE QUE ESTAR AFILIADO EL USUARIO');
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }else{
                         $json =  array('result' =>  true, 'mensaje' => 'LLEGO CON EXITO', 'dato_general' => $dato_general, 'estado' => 0);
                         header('Access-Control-Allow-Origin: *');
                         header('Content-Type: application/x-json; charset=utf-8');
                         echo json_encode($json);
                    }    
                }
                
            }
            else{
                $json =  array('result' =>  false, 'mensaje' => 'NO EXISTE NUMERO DE SUMINISTRO');
                     header('Access-Control-Allow-Origin: *');
                     header('Content-Type: application/x-json; charset=utf-8');
                     echo json_encode($json); 
            }
            
        }
    }
    
    public function adjunta_doc($suministro){
         $variable = 0;
        /*foreach($_SESSION['ACTIVIDADES'] as $GRP1){ 
            if($GRP1['GRUPDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'RECIBO'){
                $dato_afilia=$this->afiliacion_model->get_afilia_desafilia($suministro);// datos afilia
                $this->data['suministro']=$dato_afilia[0]['CLICODFAC'];
                $this->data['nombre']=$dato_afilia[0]['CLINOM'];
                $this->data['documento']=$dato_afilia[0]['CLIDOCIDENT'];
                $this->data['estado_arch']=$dato_afilia[0]['DOCADJ'];
                $this->data['dire_arch']=$dato_afilia[0]['DIRARCH'];
                $this->data['titulo']="Adjunta Documento";
                $this->data['view'] = 'Atencion_al_cliente/Adjunta_documento_view';
                $this->data['breadcrumbs'] = array(array('Facturación', ''),array('Afiliacion/Desafiliacion',''));
                $this->load->view('template/Master', $this->data);
                $variable = 1;
                break;
            }
        }*/
        $dato_afilia=$this->afiliacion_model->get_afilia_desafilia($suministro);// datos afilia
        $this->data['suministro']=$dato_afilia[0]['CLICODFAC'];
        $this->data['nombre']=$dato_afilia[0]['CLINOM'];
        $this->data['documento']=$dato_afilia[0]['CLIDOCIDENT'];
        $this->data['estado_arch']=$dato_afilia[0]['DOCADJ'];
        $this->data['dire_arch']=$dato_afilia[0]['DIRARCH'];
        $this->data['titulo']="Adjunta Documento";
        $this->data['view'] = 'Atencion_al_cliente/Adjunta_documento_view';
        $this->data['breadcrumbs'] = array(array('Facturación', ''),array('Afiliacion/Desafiliacion',''));
        $this->load->view('template/Master', $this->data);
        $variable = 1;
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
        
    }
    
    public function sub_arch(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
                $suministro= $this->input->post('suministro');
                $user_afiliado=$this->afiliacion_model->get_afilia_desafilia($suministro); // obtengo la solicitud sin firma
                date_default_timezone_set('UTC');
                $fecha=date("d-m-Y-H-i-s");
                $config['upload_path'] = './assets/afilia/';
                $config['allowed_types'] = 'pdf';
                $config['file_name'] ="DocAdjuntado".$suministro.$fecha;
                $nombre="DocAdjuntado".$suministro.$fecha;
                // You can give video formats if you want to upload any video file.

                $this->load->library('upload', $config);

               if ( ! $this->upload->do_upload('userfile'))
                {
                        //$error = array('error' => $this->upload->display_errors());
                        //echo "archivo no se pudo subir";
                        //$this->load->view('upload_form', $error);
                        $this->session->set_flashdata('mensaje1', 'Solo debes adjuntar documentos PDF  ');
                        redirect(base_url() . 'Atencion_al_cliente/adjunta_doc/'.$suministro);
                        
                }
                else
                {      
                     $direccion="assets/afilia/".$nombre.".pdf";
                     unlink($user_afiliado[0]['DIRARCH']);
                     $respuesta=$this->afiliacion_model->set_modifica_estado($suministro,$direccion);
                     if($respuesta){
                        $this->session->set_flashdata('mensaje2', ' Bien hecho archivo adjuntado ');
                        redirect(base_url() . 'Atencion_al_cliente/adjunta_doc/'.$suministro);
                         
                      //echo "archivo subido con exito";   
                     }
                     else{
                        $variable = 0;
                         foreach($_SESSION['ACTIVIDADES'] as $GRP1){ 
                            if($GRP1['GRUPDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'RECIBO'){
                                $dato_afilia=$this->afiliacion_model->get_afilia_desafilia($suministro);// datos afilia
                                $this->data['suministro']=$dato_afilia[0]['CLICODFAC'];
                                $this->data['nombre']=$dato_afilia[0]['CLINOM'];
                                $this->data['documento']=$dato_afilia[0]['CLIDOCIDENT'];
                                $this->data['estado_arch']=$dato_afilia[0]['DOCADJ'];
                                $this->data['adjunto']=0;
                                $this->data['dire_arch']=$dato_afilia[0]['DIRARCH'];
                                $this->data['titulo']="Adjunta Documento";
                                $this->data['view'] = 'Atencion_al_cliente/Adjunta_documento_view';
                                $this->data['breadcrumbs'] = array(array('Facturación', ''),array('Afiliacion/Desafiliacion',''));
                                $this->load->view('template/Master', $this->data);
                                $variable = 1;
                                break;
                            }
                        }
                        if($variable == 0){
                            $this->load->view('errors/html/error_404', $this->data);
                        }
                        // echo "no se modifico la bd";
                     }
                      //$data = array('upload_data' => $this->upload->data());
                      
                        //$this->load->view('upload_success', $data);
                }
        }
    }
    
}

?>