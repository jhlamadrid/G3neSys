<?php 
class Propie_ctrllr extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('general/Propie_model');
        $this->load->model('general/PersonaEmpresa_model');

        $this->load->library('session');
        $this->load->library('acceso_cls');
    }

    private function limpieza($cadena){
        $cadena = trim($cadena);
        //echo $cadena;
        while ( $cadena != str_replace("  "," ", $cadena) ) {
            $cadena = str_replace("  "," ", $cadena);
            //echo $cadena;
        }
        return $cadena;
    }

    private function generate_address($tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona){
        $direc = $tvia.' '.$nmvia.' '.(($km=='' || $km==null)? '':('KM. '.$km)).' '.(($mnz=='' || $mnz==null)? '':('MNZ. '.$mnz)).' '.(($lt=='' || $lt==null)? '':('LT. '.$lt)).' '.(($nro=='' || $nro==null)? '':('NRO. '.$nro)).' '.(($dep=='' || $dep==null)? '':('DPTO. '.$dep)).' '.(($inte=='' || $inte==null)? '':('NRO. '.$inte)).' '.$czona.' '.$nmzona;
        //echo $direc; 
        //str_replace("world","Peter","Hello world!");
        
        return $this->limpieza($direc);
    }

    private function buscar_persona($tipdoc, $nro){
        $dato = $this->PersonaEmpresa_model->get_persona($nro, $tipdoc);
        return $dato;
    }

    private function buscar_empresa($ruc){
        $dato = $this->PersonaEmpresa_model->get_empresa($ruc);
        return $dato;
    }

    public function obtener_propie(){
    	$ajax = $this->input->get('ajax'); 
    	if(!$ajax){
    		$json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
    		return;
    	}
    	$cod_sum = $this->input->post('codigo_suministro');

        $propie = $this->Propie_model->get_propie($cod_sum);
        if(is_null($propie)){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Intente nuevamente', 'titulo' => 'Suministro no encontrado');
            echo json_encode($json);
            return;
        }

    	$json = array('result' => true, 'propie' => $propie);
        echo json_encode($json);
    }

    public function buscar_dni(){
        $ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $id = $this->input->post('dni');
        $tipo_doc = $this->input->post('tipdoc');
        if(is_null($id)){
            $json = array('result' => true, 'tipo' => 'warning', 'mensaje' => '', 'titulo' => 'Suministro no presenta DNI asociado');
            echo json_encode($json);
            return;
        }
        $dato = $this->PersonaEmpresa_model->get_persona($id, $tipo_doc);
        if(!is_null($dato)){
            $direc = $this->generate_address($dato['TIPO_DE_VIA'], $dato['NOMBRE_DE_VIA'], $dato['KILOMETRO'], $dato['MANZANA'], $dato['LOTE'], $dato['NUMERO'], $dato['DEPARTAMENTO'], $dato['INTERIOR'], $dato['CODIGO_DE_ZONA'], $dato['TIPO_DE_ZONA']);
            $dato['DIREC'] = $direc;
            $json = array('result' => true, 'dni'=>true, 'persona' => $dato, 'tipo' => 'success', 'mensaje' => '', 'titulo' => '-- encontrado exitosamente');
            echo json_encode($json);
        }else{
            $json = array('result' => true, 'dni'=>false, 'tipo' => 'info', 'mensaje' => '--'.$id.' no se encuentra registrado', 'titulo' => '');
            echo json_encode($json);
        }
    }

    public function buscar_ruc(){
        $ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $id = $this->input->post('ruc');
        if(is_null($id)){
            $json = array('result' => true, 'tipo' => 'warning', 'mensaje' => '', 'titulo' => 'Suministro no presenta RUC asociado');
            echo json_encode($json);
            return;
        }
        $dato = $this->PersonaEmpresa_model->get_empresa($id);
        if(!is_null($dato)){
            $direc = $this->generate_address($dato['TIPO_DE_VIA'], $dato['NOMBRE_DE_VIA'], $dato['KILOMETRO'], $dato['MANZANA'], $dato['LOTE'], $dato['NUMERO'], $dato['DEPARTAMENTO'], $dato['INTERIOR'], $dato['CODIGO_DE_ZONA'], $dato['TIPO_DE_ZONA']);
            $dato['DIREC'] = $direc;
            $json = array('result' => true, 'ruc'=>true, 'persona' => $dato, 'tipo' => 'success', 'mensaje' => '', 'titulo' => 'RUC encontrado exitosamente');
            echo json_encode($json);
        }else{
            $json = array('result' => true, 'ruc'=>false, 'tipo' => 'info', 'mensaje' => 'El RUC '.$id.' no se encuentra registrado', 'titulo' => '');
            echo json_encode($json);
        }
    }

    public function registrar_persona(){
        $ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $tipdoc = $this->input->post('TIPDOC');

        $tipo_doc = $this->PersonaEmpresa_model->get_documentoById($tipdoc);
        if(is_null($tipo_doc)){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Tipo de documento "DNI" no encontrado en la base de datos comuniquese con los operadores', 'titulo' => 'BASE DE DATOS INCOMPLETA');
            echo json_encode($json);
            return;
        }

        $dni = $this->input->post('DNI');
        $apepat = $this->input->post('APEPAT');
        $apemat = $this->input->post('APEMAT');
        $nombre = $this->input->post('NOMPER');
        $email = $this->input->post('EMAIL');
        //$direc = $this->input->post('DIREC');
        $tvia = $this->input->post('TIPO_DE_VIA');
        $nmvia = $this->input->post('NOMBRE_DE_VIA');
        $km = $this->input->post('KILOMETRO');
        $mnz = $this->input->post('MANZANA');
        $lt = $this->input->post('LOTE');
        $nro = $this->input->post('NUMERO');
        $dep = $this->input->post('DEPARTAMENTO');
        $inte = $this->input->post('INTERIOR');
        $czona = $this->input->post('CODIGO_DE_ZONA');
        $nmzona = $this->input->post('TIPO_DE_ZONA');
        $email = $this->input->post('EMAIL');
        $email2 = $this->input->post('EMAIL2');
        $celular = $this->input->post('CELULAR');
        $celular2 = $this->input->post('CELULAR2');
        $telefono = $this->input->post('FIJO');
        $telefono2 = $this->input->post('FIJO2');

        $email = (empty($email))? null:$email;
        
        if(is_null($dni) || is_null($apepat) || is_null($apemat) || is_null($nombre) ){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe ingresar todos los campos solicitados', 'titulo' => 'No se pudo registrar');
            echo json_encode($json);
            return;
        }
        $query = false;
        //var_dump($tipo_doc['TIPDOCCOD']);
        $query = $this->PersonaEmpresa_model->set_persona($tipdoc, $dni, $apepat, $apemat, $nombre, $email, $email2, $celular, $celular2, $telefono, $telefono2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
        if($query){
            $dato = $this->buscar_persona($tipdoc, $dni);
            $direc = $this->generate_address($tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
            $dato['DIREC'] = $direc;
            $json = array('result' => true, 'tipo' => 'success', 'mensaje' => 'Persona registrada exitosamente', 'titulo' => 'Registro exitoso', 'persona' => $dato);//'persona' => array('NRODOC'=>$dni, 'APEPAT'=>$apepat, 'APEMAT'=>$apemat, 'NOMBRE'=>$nombre, 'TIPDOC'=>$tipo_doc, 'EMAIL'=>$email, 'DIREC' => $direc ) );
            echo json_encode($json);
            return;
        }else{
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Se produjo un error al intentar guardar estos datos', 'titulo' => 'Error');
            echo json_encode($json);
            return;
        }
    }

    public function registrar_empresa(){
        $ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $ruc = $this->input->post('RUC');
        $rs  = $this->input->post('RS');
        //$dir = $this->input->post('DIR');
        $email = $this->input->post('EMAIL');
        $tvia = $this->input->post('TIPO_DE_VIA');
        $nmvia = $this->input->post('NOMBRE_DE_VIA');
        $km = $this->input->post('KILOMETRO');
        $mnz = $this->input->post('MANZANA');
        $lt = $this->input->post('LOTE');
        $nro = $this->input->post('NUMERO');
        $dep = $this->input->post('DEPARTAMENTO');
        $inte = $this->input->post('INTERIOR');
        $czona = $this->input->post('CODIGO_DE_ZONA');
        $nmzona = $this->input->post('TIPO_DE_ZONA');
        $email = $this->input->post('EMAIL');
        $email2 = $this->input->post('EMAIL2');
        $celular = $this->input->post('CELULAR');
        $celular2 = $this->input->post('CELULAR2');
        $telefono = $this->input->post('FIJO');
        $telefono2 = $this->input->post('FIJO2');

        $email = (empty($email))? null:$email;
        $tvia = (empty($tvia))? null:$tvia;
        $nmvia = (empty($nmvia))? null:$nmvia;
        $km = (empty($km))? null:$km;
        $mnz = (empty($mnz))? null:$mnz;
        $lt = (empty($lt))? null:$lt;
        $nro = (empty($nro))? null:$nro;
        $dep = (empty($dep))? null:$dep;
        $inte = (empty($inte))? null:$inte;
        $czona = (empty($czona))? null:$czona;
        $nmzona = (empty($nmzona))? null:$nmzona;

        if(is_null($ruc) || is_null($rs) ){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe ingresar todos los campos solicitados', 'titulo' => 'No se pudo registrar');
            echo json_encode($json);
            return;
        }
        $query = $this->PersonaEmpresa_model->set_empresa($ruc, $rs, $email, $email2, $celular, $celular2, $telefono, $telefono2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
        if($query){
            $dato = $this->buscar_empresa($ruc);
            $direc = $this->generate_address($tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
            $dato['DIREC'] = $direc;
            $json = array('result' => true, 'tipo' => 'success', 'mensaje' => 'Empresa registrada exitosamente', 'titulo' => 'Registro exitoso', /*'empresa' => array('RUC'=>$ruc, 'RS'=>$rs, 'EMAIL'=>$email, 
                'TIPO_DE_VIA'=>$tvia, 'NOMBRE_DE_VIA'=>$nmvia, 'KILOMETRO'=>$km, 
                                         'MANZANA'=>$mnz, 'LOTE'=>$lt, 'NUMERO'=>$nro, 
                                         'DEPARTAMENTO'=>$dep, 'INTERIOR'=>$inte, 'CODIGO_DE_ZONA'=>$czona, 
                                         'TIPO_DE_ZONA'=>$nmzona, 'DIREC'=>$direc
                ) */ 'empresa'=>$dato);
            echo json_encode($json);
            return;
        }else{
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Se produjo un error al intentar guardar estos datos', 'titulo' => 'Error');
            echo json_encode($json);
            return;
        }
    }

    public function actualizar_persona(){
        $ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $tipdoc = $this->input->post('TIPDOC');

        $tipo_doc = $this->PersonaEmpresa_model->get_documentoById($tipdoc);
        if(is_null($tipo_doc)){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Tipo de documento "DNI" no encontrado en la base de datos comuniquese con los operadores', 'titulo' => 'BASE DE DATOS INCOMPLETA');
            echo json_encode($json);
            return;
        }

        $dni = $this->input->post('DNI');
        $apepat = $this->input->post('APEPAT');
        $apemat = $this->input->post('APEMAT');
        $nombre = $this->input->post('NOMPER');
        $email = $this->input->post('EMAIL');
        //$direc = $this->input->post('DIREC');
        $tvia = $this->input->post('TIPO_DE_VIA');
        $nmvia = $this->input->post('NOMBRE_DE_VIA');
        $km = $this->input->post('KILOMETRO');
        $mnz = $this->input->post('MANZANA');
        $lt = $this->input->post('LOTE');
        $nro = $this->input->post('NUMERO');
        $dep = $this->input->post('DEPARTAMENTO');
        $inte = $this->input->post('INTERIOR');
        $czona = $this->input->post('CODIGO_DE_ZONA');
        $nmzona = $this->input->post('TIPO_DE_ZONA');
        $email = $this->input->post('EMAIL');
        $email2 = $this->input->post('EMAIL2');
        $celular = $this->input->post('CELULAR');
        $celular2 = $this->input->post('CELULAR2');
        $telefono = $this->input->post('FIJO');
        $telefono2 = $this->input->post('FIJO2');

        $email = (empty($email))? null:$email;
        
        if(is_null($dni) || is_null($apepat) || is_null($apemat) || is_null($nombre) ){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe ingresar todos los campos solicitados', 'titulo' => 'No se pudo registrar');
            echo json_encode($json);
            return;
        }
        $query = false;
        //var_dump($tipo_doc['TIPDOCCOD']);
        $query = $this->PersonaEmpresa_model->update_persona($tipdoc, $dni, $apepat, $apemat, $nombre, $email, $email2, $celular, $celular2, $telefono, $telefono2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
        if($query){
            $dato = $this->buscar_persona($tipdoc, $dni);
            $direc = $this->generate_address($tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
            $dato['DIREC'] = $direc;
            $json = array('result' => true, 'tipo' => 'success', 'mensaje' => 'Persona registrada exitosamente', 'titulo' => 'Actualizacion exitosa', 'persona' => $dato);//'persona' => array('NRODOC'=>$dni, 'APEPAT'=>$apepat, 'APEMAT'=>$apemat, 'NOMBRE'=>$nombre, 'TIPDOC'=>$tipo_doc, 'EMAIL'=>$email, 'DIREC' => $direc ) );
            echo json_encode($json);
            return;
        }else{
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Se produjo un error al intentar actualizar estos datos', 'titulo' => 'Error');
            echo json_encode($json);
        } 
    }

    public function actualizar_empresa(){
        $ajax = $this->input->get('ajax'); 
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido');
            echo json_encode($json);
            return;
        }
        $ruc = $this->input->post('RUC');
        $rs  = $this->input->post('RS');
        //$dir = $this->input->post('DIR');
        $email = $this->input->post('EMAIL');
        $tvia = $this->input->post('TIPO_DE_VIA');
        $nmvia = $this->input->post('NOMBRE_DE_VIA');
        $km = $this->input->post('KILOMETRO');
        $mnz = $this->input->post('MANZANA');
        $lt = $this->input->post('LOTE');
        $nro = $this->input->post('NUMERO');
        $dep = $this->input->post('DEPARTAMENTO');
        $inte = $this->input->post('INTERIOR');
        $czona = $this->input->post('CODIGO_DE_ZONA');
        $nmzona = $this->input->post('TIPO_DE_ZONA');
        $email = $this->input->post('EMAIL');
        $email2 = $this->input->post('EMAIL2');
        $celular = $this->input->post('CELULAR');
        $celular2 = $this->input->post('CELULAR2');
        $telefono = $this->input->post('FIJO');
        $telefono2 = $this->input->post('FIJO2');

        $email = (empty($email))? null:$email;
        $tvia = (empty($tvia))? null:$tvia;
        $nmvia = (empty($nmvia))? null:$nmvia;
        $km = (empty($km))? null:$km;
        $mnz = (empty($mnz))? null:$mnz;
        $lt = (empty($lt))? null:$lt;
        $nro = (empty($nro))? null:$nro;
        $dep = (empty($dep))? null:$dep;
        $inte = (empty($inte))? null:$inte;
        $czona = (empty($czona))? null:$czona;
        $nmzona = (empty($nmzona))? null:$nmzona;

        if(is_null($ruc) || is_null($rs) ){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe ingresar todos los campos solicitados', 'titulo' => 'No se pudo registrar');
            echo json_encode($json);
            return;
        }
        $query = $this->PersonaEmpresa_model->update_empresa($ruc, $rs, $email, $email2, $celular, $celular2, $telefono, $telefono2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
        if($query){
            $dato = $this->buscar_empresa($ruc);
            $direc = $this->generate_address($tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona);
            $dato['DIREC'] = $direc;
            $json = array('result' => true, 'tipo' => 'success', 'mensaje' => 'Empresa registrada exitosamente', 'titulo' => 'Registro exitoso', /*'empresa' => array('RUC'=>$ruc, 'RS'=>$rs, 'EMAIL'=>$email, 
                'TIPO_DE_VIA'=>$tvia, 'NOMBRE_DE_VIA'=>$nmvia, 'KILOMETRO'=>$km, 
                                         'MANZANA'=>$mnz, 'LOTE'=>$lt, 'NUMERO'=>$nro, 
                                         'DEPARTAMENTO'=>$dep, 'INTERIOR'=>$inte, 'CODIGO_DE_ZONA'=>$czona, 
                                         'TIPO_DE_ZONA'=>$nmzona, 'DIREC'=>$direc
                ) */ 'empresa'=>$dato);
            echo json_encode($json);
            return;
        }else{
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Se produjo un error al intentar guardar estos datos', 'titulo' => 'Error');
            echo json_encode($json);
            return;
        }
    }

}