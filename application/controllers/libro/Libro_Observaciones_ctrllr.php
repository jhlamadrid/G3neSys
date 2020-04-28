<?php
class Libro_Observaciones_ctrllr extends CI_Controller {
  	public function __construct() { 
    	parent::__construct();
    	$this->load->model('libro/Libro_model'); 
		$this->load->library('session'); 
        $this->load->library('acceso_cls'); 
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
		$this->data['actividad'] = 'administrar'; 
		$this->data['rol'] = $this->Libro_model->get_rol($_SESSION['user_id']); 
		$this->acceso_cls->isLogin(); 
		$this->data['userdata'] = $this->acceso_cls->get_userdata(); 
		$permiso = $this->Libro_model->get_permiso($_SESSION['user_id'],$this->data['actividad']); 
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

    public function listar(){
        $permiso = $this->Libro_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	if($permiso){
            $this->data['tipos'] = $this->Libro_model->obtenerTipDoc();
            if($_SESSION['ROL'] == 'SUBGERENTE COMUNICACIONES Y ATENCION AL CLIENTE' || $_SESSION['ROL'] == 'ADMINISTRADOR') {
                $this->data['obs'] = $this->Libro_model->obtenerObsGeneral();
            } else {
                $this->data['obs'] = $this->Libro_model->obtenerObs($_SESSION['NSOFICOD']);
            }
            $this->data['view'] = 'libro/Libro_view';
            $this->data['breadcrumbs'] = array(array('Administrar Observaciones', ''));
            $this->load->view('template/Master', $this->data);
        } else {
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
        }
    }

    public function buscar(){
        $permiso = $this->Libro_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	if($permiso){
            $ajax = $this->input->get('ajax');
            if($ajax){
                $tipo = $this->input->post("tipo");
                $numero = $this->input->post("numero");
                $resp = $this->Libro_model->obtenerObsBus($_SESSION['NSOFICOD'], $tipo, $numero);
                if($resp){
                    $json = array('result' => true, 'mensaje' => 'ok', 'obs' => $resp);
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);
                } else {
                    $json = array('result' => false, 'mensaje' => $this->config->item('_mensaje_vacio'));
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

    public function ver($obs){
        $permiso = $this->Libro_model->get_permiso($_SESSION['user_id'],$this->data['actividad']);
    	if($permiso){
            $obs1 = $this->Libro_model->obtenerObs1($obs);
            if($this->input->server('REQUEST_METHOD') == 'POST'){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('respuesta', 'Respuesta al cliente', 'required');
                if($this->form_validation->run()){
                    $respuesta = $this->input->post('respuesta');
                    $rsp = $this->Libro_model->guardarRespuesta($respuesta, $obs, $_SESSION['user_id']);
                    if($rsp){
                        $this->load->library("email");
                        $motivo = "Respuesta al Registro en el Libro de Observaciones";
                        $destinatario = $obs1['EMAIL'];
                        $mensaje = '<!DOCTYPE html>
                                <html lang="es">
                                    <head>    
                                        <meta charset="UTF-8">
                                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                                        <title>ENVIO DE FORMATO DE OBSERVACIÓN</title>

                                    </head>
                                    <style>
                                        #cuerpo{
                                            background: url(http://dcsvptes01.sedalib.com.pe/sic_web/img/fondo.jpg) no-repeat center center fixed;
                                            -webkit-background-size: cover;
                                            -moz-background-size: cover;
                                            -o-background-size: cover;
                                            background-size: cover;
                                        }
                                    </style>
                                    <body id="cuerpo">
                                        <div style="width:80%;margin-left:10%">
                                            <center>
                                                <img style="width:35%" src="http://dcsvptes01.sedalib.com.pe/sic_web/img/logo.png">
                                            </center><br><br><br>

                                            Estimado Cliente: '.$obs1['NOMBRE'].' '.$obs1['APEPAT'].' '.$obs1['APEMAT'].'<br><br>
                                            Se realizó la repuesta a la observación que registro, mediante el libro de observación web.<br><br>
                                            Este mensaje contiene información importante para acceder a la observación que registro en el Libro de Observaciones de
                                            la plataforma de SEDALIB S.A.
                                            Para ello, deves hacer clic en <a href="http://150.10.9.48/GeneSys2/libro_observaciones/pdf/'.$obs.'">Ver Documento</a>.
                                            <br><br>
                                            Te pedimos que puedas guardar este mensaje para futuras consultas.<br><br>
                                            Si tiene alguna duda o quiere visualizar el estado de su observación, de clic <a href="http://150.10.9.48/GeneSys2/libro_observaciones">Aquí</a>.
                                            <br><br><br><br>
                                            <table width="100%">
                                                <tr>
                                                    <td style="width:50%">
                                                        <img style="width:100%" src="http://dcsvptes01.sedalib.com.pe/sic_web/img/banner_sic.jpg">
                                                    </td>
                                                    <td style="width:50%">
                                                        <img style="width:100%" src="http://dcsvptes01.sedalib.com.pe/sic_web/img/banner_whatsapp.jpg">
                                                    </td>
                                                </tr>
                                            </table><br><br>
                                            <table width="100%">
                                                <tr>
                                                    <td style="width:33%;text-align:center">
                                                        Síguenos en: <a href="https://web.facebook.com/SedalibOficial/"><img src="http://dcsvptes01.sedalib.com.pe/sic_web/img/facebook.png"> </a>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <small>SERVICIO AL CLIENTE</small><br>
                                                        (044) 480555
                                                    </td>
                                                    <td style="text-align:center">
                                                        <a href="http://www.sedalib.com.pe">Página Oficial de SEDALIB S.A.</a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <br>
                                            Para asegurar la entrega de nuestros e-mails en tu correo, agrege el nuestro correo  a tu libreta de contactos.<br>
                                            Por favor no responda este correo. Si necesita más información llámanos al 044-480555
                                        </div>
                                    </body>
                                </html>
                        ';

                

                        $configGmail = array(
                            'protocol' => 'smtp',
                            'smtp_host' => 'mail.sedalib.com.pe',
                            //'smtp_host' => 'https://mx.sedalib.com.pe',
                            'smtp_port' => 25,
                            'smtp_user' => 'sicmoviles@sedalib.com.pe',
                            'smtp_pass' => '12345678',
                            'mailtype' => 'html',
                            'charset' => 'utf-8',
                            'newline' => "\r\n"
                        );
                        $this->email->initialize($configGmail);
                        $this->email->from('libroobservaciones@sedalib.com.pe');
                        $this->email->to($destinatario);
                        $this->email->subject($motivo);
                        $this->email->message($mensaje);
                        $this->email->send();

                        $this->email->initialize($configGmail);
                        $this->email->from('libroobservaciones@sedalib.com.pe');
                        $this->email->to('sicmoviles@sedalib.com.pe');
                        $this->email->subject($motivo);
                        $this->email->message($mensaje);
                        $this->email->send();

                        $this->session->set_flashdata('mensaje', array('success', 'Se ha registrado con éxito la respúesta y se ha remitido al correo del cliente el formato completo al cliente.'));
                        //$this->exportPDF();
                        redirect(base_url().'libro_obs/administrar');
                    } else {
                        $this->session->set_flashdata('mensaje', array('danger', 'Hubo un problema interno al registrar la respuesta'));
                        redirect(base_url().'libro_obs/administrar/detalle/'.$obs);
                    }
                } else {
                    $this->session->set_flashdata('mensaje', array('danger', 'Debe llenar la respuesta al cliente'));
                    redirect(base_url().'libro_obs/administrar/detalle/'.$obs);
                }
            }
           
            $this->data['obs'] =$obs1;
            $this->data['view'] = 'libro/Respuesta_view';
            $this->data['breadcrumbs'] = array(array('Administrar Observaciones', 'libro_obs/administrar'), array('Responder Observación', ''));
            $this->load->view('template/Master', $this->data);
        } else {
            $this->session->set_flashdata('mensaje', array('error', $this->config->item('_mensaje_error')));
			redirect($this->config->item('ip').'inicio');
			return;
        }
    }
}