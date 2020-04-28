<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Buscar_model');
        $this->load->library('session');
        $this->load->helper('captcha');
	}
	public function index()
	{
		$this->load->helper('url');
        $random_number = substr(number_format(time() * rand(),0,'',''),0,6);
        // setting up captcha config
        $vals = array(
                 'word' => $random_number,
                 'img_path' => './captcha/',
                 'img_url' => base_url().'captcha/',
                 'img_width' => 200,
                 'img_height' => 45,
                 'expiration' => 7200,
                 'colors'        => array(
                                            'background' => array(145, 216, 248),
                                            'border' => array(0,0,0),
                                            'text' => array(0, 0, 0),
                                            'grid' => array(255, 40, 40)
                                    )
                );
        $data['captcha'] = create_captcha($vals);
        $_SESSION['clave'] = $data['captcha']['word'];
		$this->load->view('welcome_message' , $data);
	}
	public function buscar(){
        $this->load->helper('url');
        $ajax = $this->input->get('ajax');
        $random_number = substr(number_format(time() * rand(),0,'',''),0,6);
        // setting up captcha config
        $vals = array(
                 'word' => $random_number,
                 'img_path' => './captcha/',
                 'img_url' => base_url().'captcha/',
                 'img_width' => 200,
                 'img_height' => 45,
                 'expiration' => 7200,
                 'colors'        => array(
                                            'background' => array(145, 216, 248),
                                            'border' => array(0,0,0),
                                            'text' => array(0, 0, 0),
                                            'grid' => array(255, 40, 40)
                                    )
                );
        $nuevo_captcha =  create_captcha($vals);
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido' );
            echo json_encode($json);
            return;
        }else{
            $documento = $this->input->post('Aruc');
            $fecha = $this->input->post('Afecha');
            $serie = $this->input->post('Aser');
            $numero = $this->input->post('Anro');
            $monto = $this->input->post('Amonto');
            $tipo = $this->input->post('Atipo');
            if($tipo==1){
                $datos= $this->Buscar_model->get_datos_factura($documento,$tipo,$fecha,$serie,$numero,$monto);
            }else{
                $datos= $this->Buscar_model->get_datos_boleta($documento,$tipo,$fecha,$serie,$numero,$monto);
            }
            if ($datos != null) {
                $json = array('result' => true, 'busqueda' => $datos , 'captcha' => $nuevo_captcha , 'numero' => $random_number);
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);    
            }else{
                $json = array('result' => false, 'mensaje' => "Lo Sentimos no se encontro el documento requerido" , 'captcha' => $nuevo_captcha ,'numero' => $random_number );
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }

            
            //var_dump($datos);
            
        }
    }
}
