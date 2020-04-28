<?php
class Afiliacion_ctrllr extends CI_Controller{
     public function __construct() {
       parent::__construct();
        $this->load->helper('form');
        //$this->load->model('acceso/Usuario_model');
        //$this->load->model('acceso/Perfil_model');
        //$this->load->model('acceso/Cargo_model');
        $this->load->model('Atencion_al_cliente/afiliacion_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Afilio o Desafilio Usuarios';
        $this->data['menu']['padre'] = 'atencion_cliente';
        $this->data['menu']['hijo'] = 'afilio';
    }
    
    public function afilia(){
        $variable = 0;
        foreach($_SESSION['ACTIVIDADES'] as $GRP1){ 
            if($GRP1['MENUGENDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'RECIBO'){
                $this->data['titulo']="Afilia o Desafilia Usuarios";
                $this->data['view'] = 'facturacion/Afiliacion_view';
                $this->data['breadcrumbs'] = array(array('Facturación', ''),array('Afiliacion/Desafiliacion',''));
                $this->load->view('template/Master', $this->data);
                $variable = 1;
                break;
            }
        }
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    public function afilia_pdf(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $nombre= $this->input->post('dato_apellido');
            $documento= $this->input->post('documento');
            $suministro= $this->input->post('suministro');
            $afilia=$this->input->post('afilia');
            $telefono=$this->input->post('telefono');
            $celular=$this->input->post('celular');
            $correo1=$this->input->post('correo1');
            $correo2=$this->input->post('correo2');
            $direccion1=$this->input->post('direccion1');
            $twitter=$this->input->post('twitter');
            $facebook=$this->input->post('facebook');
            $whatsapp=$this->input->post('whatsapp');
            if($afilia=='afiliacion'){
                $estado=" afiliarme (X) o desafiliarme () ";
            }
            if($afilia=='desafiliacion'){
                $estado=" afiliarme () o desafiliarme (X) ";
            }
            //var_dump($correo2);
           $this->load->library('dompdf_pdf');
            $mipdf = $this->dompdf_pdf->cargar();//cargo el dompdf
            $mipdf ->set_paper('A4', 'portrait');       
              # Cargamos el contenido HTML.
            $html= $this->crear_pdf($nombre,$documento,$suministro,$estado,$telefono,
                                    $celular,$correo1,$correo2,$direccion1,$twitter,$facebook,
                                     $whatsapp);
            date_default_timezone_set('UTC');
            $fecha=date("d-m-Y");
            $mipdf ->load_html($html);     
               # Renderizamos el documento PDF.
           // $mipdf ->render();
            //$output = $mipdf->output();
            //$mipdf ->stream('Afiliacion.pdf'); 
            $mipdf ->render();
            $output = $mipdf->output();
            $user_afiliado=$this->afiliacion_model->get_afilia_desafilia($suministro);
            if($user_afiliado){
                if($afilia=='afiliacion'){
                    $tipo_afiliacion="A";
                    $file_to_save ="assets/afilia/afilia".$suministro.$fecha.".pdf";
                    $this->afiliacion_model->set_modifica_afiliacion($nombre,$documento,$suministro,
                           $tipo_afiliacion,$telefono,$celular,$correo1,$correo2,$direccion1,$twitter,$facebook,$whatsapp,$file_to_save);
                    file_put_contents($file_to_save, $output);
                    redirect(base_url() . 'Atencion_al_cliente/adjunta_doc/'.$suministro);
                }else{
                  $tipo_afiliacion="D";
                    $file_to_save ="assets/afilia/Desafilia".$suministro.$fecha.".pdf";
                    $this->afiliacion_model->set_modifica_afiliacion($nombre,$documento,$suministro,
                           $tipo_afiliacion,$telefono,$celular,$correo1,$correo2,$direccion1,$twitter,$facebook,$whatsapp,$file_to_save);
                    file_put_contents($file_to_save, $output);
                    redirect(base_url() . 'Atencion_al_cliente/adjunta_doc/'.$suministro);
                }
            }else{
              $file_to_save ="assets/afilia/afilia".$suministro.$fecha.".pdf";
              $this->afiliacion_model->set_solafdes($nombre,$documento,$suministro,$afilia,$telefono,
                                                         $celular,$correo1,$correo2,$direccion1,$twitter,$facebook,
                                                         $whatsapp,$file_to_save);
              file_put_contents($file_to_save, $output);
              redirect(base_url() . 'Atencion_al_cliente/adjunta_doc/'.$suministro);
            }
            
                         
            /*$this->load->helper(array('download', 'file', 'url'));
            $data = file_get_contents($file_to_save); 
            force_download("afilia.pdf",$data);*/
           
        } 
      }  

        private function crear_pdf($nombre,$documento,$suministro,$estado,$telefono,
                                    $celular,$correo1,$correo2,$direccion1,$twitter,$facebook,
                                     $whatsapp){

          $html= "<html lang='es'>
                    <head>
                    <title>Sedalib</title> 
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    </head>
                    <body style='font-family:sans-serif;'>
                        <div style='position: fixed; bottom: 10cm; left: 4.8cm; width: 10cm; height: 12cm; z-index: -1000;'>
                            <img src='".base_url()."img/sedalito2.png' height='100%' width='100%' style ='opacity: 0.2;' />
                        </div>
                        <center>
                          <h2> Solicitud de Afiliación y Desafiliación al  Recibo Digital por correo electrónico</h2>
                        </center>
                        <div>
                            Nombres y Apellidos del Titular del Suministro <sup>(1)</sup>:
                            <table style='width:100%;'>
                                <tr>
                                   <td style='width:100%;  border: 1px black solid; height:20px;'>
                                   ".$nombre."
                                   </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                           Nro. DNI /C. Ident. / C.Extranj. /RUC :
                           <table style='width:100%;'>
                                <tr>
                                   <td style='width:100%;  border: 1px black solid; height:20px;'>
                                    ".$documento."
                                   </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:33.33%; '>
                                      Suministro:
                                   </td>
                                   <td style='width:33.33%; '>
                                      Teléfono fijo:
                                   </td>
                                   <td style='width:33.33%; '>
                                      Celular:
                                   </td>
                                </tr>
                            </table>
                          </div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:33.33%; border: 1px black solid; height:20px;'>
                                     ".$suministro."
                                   </td>
                                   <td style='width:33.33%;border: 1px black solid; height:20px; '>
                                      ".$telefono."
                                   </td>
                                   <td style='width:33.33%;border: 1px black solid; height:20px; '>
                                      ".$celular."
                                   </td>
                                </tr>
                            </table>
                          </div>
                        </div>
                        <div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:50%; '>
                                      Correo electrónico:
                                   </td>
                                   <td style='width:50%; '>
                                      Correo electrónico alterno<sup>(2)</sup>:
                                   </td>
                                </tr>
                            </table>
                          </div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:50%; border: 1px black solid; height:20px;'>
                                      ".$correo1."
                                   </td>
                                   <td style='width:50%;border: 1px black solid; height:20px; '>
                                      ".$correo2."
                                   </td>
                                </tr>
                            </table>
                          </div>
                        </div>
                        <div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:50%; '>
                                      Dirección Web<sup>(3)</sup>:
                                   </td>
                                   <td style='width:50%; '>
                                      Twiter<sup>(3)</sup>:
                                   </td>
                                </tr>
                            </table>
                          </div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:50%; border: 1px black solid; height:20px;'>
                                      ".$direccion1."
                                   </td>
                                   <td style='width:50%;border: 1px black solid; height:20px; '>
                                      ".$twitter."
                                   </td>
                                </tr>
                            </table>
                          </div>
                        </div>
                        <div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:50%; '>
                                      Facebook<sup>(3)<sup>:
                                   </td>
                                   <td style='width:50%; '>
                                      WhatsApp<sup>(3)</sup>:
                                   </td>
                                </tr>
                            </table>
                          </div>
                          <div >
                              <table style='width:100%;'>
                                <tr>
                                   <td style='width:50%; border: 1px black solid; height:20px;'>
                                      ".$facebook."
                                   </td>
                                   <td style='width:50%;border: 1px black solid; height:20px; '>
                                      ".$whatsapp."
                                   </td>
                                </tr>
                            </table>
                          </div>
                        </div>
                        <div style='margin-top:15px;text-align: justify;'>
                          Señores de SEDALIB SA, acepto ".$estado." al servicio de recibo digital,para que el recibo de cobranza de consumo de agua potable y alcantarillado de mi número de Suministro <strong>".$suministro."</strong> , se me haga llegar a través del correo electrónico indicado. Con este compromiso , <u>estoy de acuerdo en no recibirlo en formato impreso </u> y en dar a conocer a SEDALIB S.A. cualquier cambio en mi correo electrónico.
                        </div>
                        <div style='margin-top:50px;'>
                            <table style='width:30%;'>
                                <tr>
                                   <td style=' border-bottom: 1px black solid; height:20px;'>
                                      
                                   </td>
                                </tr>
                                <tr>
                                   <td style=' height:20px;'>
                                      CLIENTE
                                   </td>
                                </tr>
                            </table>
                        </div>
                        <div style='margin-top:50px;'>
                            <ol>
                               <li>
                                Podrá suscribirse a este servicio solo el titular del Suministro.
                               </li>
                                <li>
                                En el suspuesto de que se presente algún fallo en la recepción del envío de su recibo (en su correo electrónico principal),éste se remitirá a su correo electrónico alterno.
                               </li>
                               <li>
                                Dato opcional.
                               </li>
                            </ol>
                        </div>
                        <div>
                           <strong>
                              NOTA:
                           </strong>
                        </div>
                        <div>
                           <ul>
                             <li>
                                En aplicación del Art. 110 del Reglamento de Calidad de Prensentación de los Servicios de Saneamiento aprobado por Resolución N° 011-2007-SUNASS-CD, el <u> retraso o la falta de entrega del recibo digital por correo o físico</u>, no suspende la obligación de pagar por la presentación del servicio.
                             </li>
                             <li>
                                SEDALIB S.A. procede en concordancia a ley 29733- Ley de proteción de datos personales , modificada por el decreto legislativo 1352.
                             </li>
                           </ul>
                        </div>
                    </body>
                    </html>";
          return $html;

        }             

            
}

?>