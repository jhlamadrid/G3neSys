<?php

class Libro_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('externo/Libro_model');
        $this->load->library('session');
        //$this->load->library('acceso_cls');
    }


    public function inicio(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombres', 'Nombres del cliente', 'required');
            $this->form_validation->set_rules('apellidoP', 'apellido paterno del cliente', 'required');
            $this->form_validation->set_rules('apellidoM', 'apellido materno del cliente', 'required');
            $this->form_validation->set_rules('numDoc', 'Número de documento del cliente', 'required');
            $this->form_validation->set_rules('email', 'Email del cliente', 'required');
            $this->form_validation->set_rules('detalle', 'Detalle del reclamo del cliente', 'required');
            $this->form_validation->set_rules('oficina', 'Oficina del reclamo del cliente', 'required');
            if($this->form_validation->run()){
                $nombres = $this->input->post('nombres');
                $apellidoP = $this->input->post('apellidoP');
                $apellidoM = $this->input->post('apellidoM');
                $numDoc = $this->input->post('numDoc');
                $tipoDoc = $this->input->post('tipoDoc');
                $domicilio = $this->input->post('domicilio');
                $celular = $this->input->post('celular');
                $email = $this->input->post('email');
                $detalle = $this->input->post('detalle');
                $enviar = $this->input->post('enviar');
                $oficina = $this->input->post('oficina');
                $suministro = $this->input->post('suministro');
                $band = $this->Libro_model->buscarDNI($tipoDoc, $numDoc);
                if($band){
                    $resp = $this->Libro_model->guardar_observacion1($detalle, $band['LUSRCOD'], $oficina, $suministro);
                } else {
                    $resp = $this->Libro_model->guardar_observacion($nombres, $apellidoP, $apellidoM, $numDoc, $tipoDoc, $domicilio, $celular, $email, $detalle, $oficina, $suministro);
                }
                if($enviar){
                    //enviar correo electronico
                    $this->load->library("email");
                    $motivo = "Copia de Registro en el Libro de Observaciones";
                    $destinatario = $email;

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

                                                Estimado Cliente: '.$nombres.' '.$apellidoP.' '.$apellidoM.'<br><br>
                                                Este mensaje contiene información importante para acceder a la observación que registro en el Libro de Observaciones de
                                                la plataforma de SEDALIB S.A.
                                                Para ello, deves hacer clic en <a href="http://150.10.9.48/GeneSys2/libro_observaciones/pdf/'.$resp.'">Ver Documento</a>.
                                                <br><br>
                                                Te pedimos que puedas gurdar este mensaje para futuras consultas.<br><br>
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

                    $this->session->set_flashdata('mensaje', array('success', 'SE HA REGISTRO CON ÉXITO TU OBSERVACIÓN Y SE TE HA ENVIADO EL FORMATO DE REGISTRO A SU CORREO'));
                    //$this->exportPDF();
                    redirect(base_url().'libro_observaciones');
                } else {
                    $this->session->set_flashdata('mensaje', array('success', 'SE HA REGISTRO CON ÉXITO TU OBSERVACIÓN ', $resp));
                    //$this->exportPDF();
                    redirect(base_url().'libro_observaciones');
                }
            } else {
                $this->session->set_flashdata('mensaje', array('danger', 'DEBE COMPLETAR TODOS LOS CAMPOS PARA EL REGISTRO'));
                redirect(base_url().'libro_observaciones');
            }
        }
        $this->data['oficinas'] = $this->Libro_model->obtenerOficinas();
        $this->data['tipos'] = $this->Libro_model->obtenerTipDoc();
        $this->load->view('template/Libro', $this->data);
    }

    public function exportPDF($codigo){
        $obs = $this->Libro_model->obtener_observacion($codigo);
        $this->load->library('ciqrcode');
        $params['data'] = 'OFICINA:  '. $obs['OFICOD'].' FECHA: '.$obs['FECREG'].' HORA: '.$obs['HRAREG'].' FICHA: '.$obs['LOBSCOD'];
        $params['level'] = 'H';
        $params['size'] = 2;
        $params['savename'] = FCPATH.'tes.png';
        $this->ciqrcode->generate($params);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load('utf-8', 'A4', 10, 20, 10, 10, 10, 5, 0, 0,'P');
        $mpdf->AddPage('P');
        $mpdf->SetWatermarkText('SEDALIB S.A.');
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $html = '<table width="100%" cellpading="0" cellspacing="0">'.
                    '<tr>'.
                        '<td colspan="4" style="text-align:center;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; border-top:1px solid #000">'.
                            '<b>LIBRO DE OBSERVACIONES DEL USUARIO O <br> POSIBLE CLIENTE</b>'.
                        '</td>'.
                        '<td rowspan="2" style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000; border-top:1px solid #000"> <b>FICHA DE OBSERVACIÓN</b> <br> (N°'.str_pad( $obs['CODIGO'], 6, '0', STR_PAD_LEFT).' - '.$obs['ANIO'].')</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td style="text-align:center;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000"><b>FECHA: </b></td>'.
                        '<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000">DÍA <br>'.substr($obs['FECREG'],0,2).'</td>'.
                        '<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000">MES <br>'.substr($obs['FECREG'],3,2).'</td>'.
                        '<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000">AÑO <br>'.substr($obs['FECREG'],6,4).'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="2" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">NOMBRE DE LA EPS </td>'.
                        '<td colspan="3" style="border-bottom:1px solid #000;border-right:1px solid #000">SEDALIB S.A.</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="3" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">DOMICILIO DE LA OFICINA COMERCIAL</td>'.
                        '<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000">'.$obs['OFIDIR'].'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="5" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000"><b>1. IDENTIFICACIÓN DEL USUARIO O POSIBLE CLIENTE</b></td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="4" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">NOMBRE: '.$obs['NOMBRE'].' '.$obs['APEPAT'].' '.$obs['APEMAT'].'</td>'.
                        '<td style="border-bottom:1px solid #000;border-right:1px solid #000">SUMINISTRO: '.$obs['CLICODFAC'].'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="5" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">DOMICILIO: '.$obs['DOMICILIO'].'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="2" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">DNI/CE: '.$obs['NRODOC'].'</td>'.
                        '<td colspan="3" style="border-bottom:1px solid #000;border-right:1px solid #000">TELEFONO / EMAIL: '.$obs['NROCELULAR'].' / '.$obs['EMAIL'].'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="5" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000"><b>2. DETALLE DE LA OBSERVACIÓN</b></td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="4" rowspan="2" style="text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">'.$obs['DETALLE'].'</td>'.
                        '<td  style="padding-top:20px;padding-bottom:20px;border-bottom:1px solid #000;border-right:1px solid #000; text-align:center"><img src="'.$this->config->item('ip').'tes.png" /></td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td  style="border-bottom:1px solid #000;border-right:1px solid #000"><b>FIRMA DE REPRESENTANTE EPS: </b></td>'.
                    '</tr>';
            if($obs['RESPUESTA'] != null){ 
                $params['data'] = 'OFICINA:  '. $obs['OFICOD'].' FECHA: '.$obs['FECRPTA'].' HORA: '.$obs['HRAPTA'].' FICHA: '.$obs['USRCOD'];
                $params['level'] = 'H';
                $params['size'] = 2;
                $params['savename'] = FCPATH.'tes1.png';
                $this->ciqrcode->generate($params);
                    $html .= '<tr>'.
                        '<td colspan="5" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000"><b>3. OBSERVACIÓN Y ACCIÓN ADOPTADA POR LA EPS</b></td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td style="text-align:center;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">FECHA DE LA RESPUESTA: </td>'.
                        '<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000">DÍA <br>'.substr($obs['FECRPTA'],0,2).'</td>'.
                        '<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000">MES <br>'.substr($obs['FECRPTA'],3,2).'</td>'.
                        '<td style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #000">AÑO <br>'.substr($obs['FECRPTA'],6,4).'</td>'.
                        '<td rowspan="2" style="border-right:1px solid #000"></td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td colspan="4" rowspan="3" style="'.(($obs['RESPUESTA'] != null) ? "" : "padding-top:80px;padding-bottom:80px;").'text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">'.$obs['RESPUESTA'].'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td  style="padding-top:20px ;padding-bottom:20px;border-bottom:1px solid #000;border-right:1px solid #000; text-align:center"><img src="'.$this->config->item('ip').'tes1.png" /></td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td  style="padding-top:5px;padding-bottom:5px;border-bottom:1px solid #000;border-right:1px solid #000"><b>FIRMA DE REPRESENTANTE EPS: </b></td>'.
                    '</tr>';
            }
            $html .=       '<tr>'.
                        '<td colspan="5" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">'.
                            '<b>OBSERVACIÓN: </b> Es la disconformidad o insatisfacción del usuario o posible cliente con el trabajo brindado por la EPS, diferente al reclamo o queja contemplados en el Reglamento General de Reclamos de Usuarios de Servicios de Saneamiento, aprobado por Resolución de Consejo Directivo N° 066-2006-SUNASS-CD. <br> <br><br> * La EPS deberá dar resúesta a la observación en un plazo no mayor de dies (10) días hábiles.'.
                        '</td>'.
                    '</tr>'.
                    '<tr>'.
                    '<td colspan="5" style="padding-top:10px;padding-bottom:10px;text-align:left;border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">'.
                        'Copia del usuario o posible cliente / Copia de la EPS / Copia a SUNASS; según corresponda.'.
                    '</td>'.
                '</tr>'.
                "</table>";
        $mpdf->WriteHTML($html);
        $content = $mpdf->Output('', 'S');
        $content = chunk_split(base64_encode($content));
        $mpdf->Output();
        //redirect($this->config->item('url').'libro_observaciones');
        exit;
    }

    public function buscar(){
        $ajax = $this->input->get('ajax');
        if($ajax){
            $tipo = $this->input->post("tipo");
            $numero = $this->input->post("numero");
            $usuario = $this->Libro_model->buscarDNI($tipo, $numero);
            if($usuario){
                $json = array('result' => true, 'mensaje' => 'ok', 'usuario' => $usuario);
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
        
    }

    public function buscarObservaciones(){
        $ajax = $this->input->get('ajax');
        if($ajax){
            $tipo = $this->input->post("tipo");
            $numero = $this->input->post("numero");
            $observaciones = $this->Libro_model->buscarObs($tipo, $numero);
            if($observaciones){
                $json = array('result' => true, 'mensaje' => 'ok', 'obs' => $observaciones);
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
    }
    
}
