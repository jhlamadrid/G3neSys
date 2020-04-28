<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    class Documento_model extends CI_Model {
        function __construct() {
            parent::__construct();
            $this->load->database();
            $this->oracle = $this->load->database('oracle', TRUE);
        }

        public function getTipoxTipoDoc(){
            $query = $this->oracle->query("SELECT TIPO.IDTIPODOCUMENTO, TIPO.NOMBREDOCUMENTO FROM 
            PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_TIPODOC_X_ORGANI CRUCE
            WHERE CRUCE.ID_TIP_DOCUENTO= TIPO.IDTIPODOCUMENTO AND CRUCE.ID_ORGANIGRAMA =".$_SESSION['DEPENDENCIA_ORIGEN']."
            AND CRUCE.ESTADO='1' AND TIPO.ESTADODOCUMENTO='1'");
            return $query->result_array();
        }

        public function getTipoxTipoDoc_general(){
            $query = $this->oracle->query("SELECT TIPO.IDTIPODOCUMENTO, TIPO.NOMBREDOCUMENTO FROM 
            PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO  WHERE TIPO.ESTADODOCUMENTO='1'  AND TIPO.IDTIPODOCUMENTO != 21 ");
            return $query->result_array();
        }
        
        public function getDocsCreadosUsuario($idPersona, $tip_documento, $fecha_inicio, $fecha_fin, $estado_doc) {
            $tipo ="";
            if($tip_documento !='T'){
                $tipo =" AND DOC.IDTIPDOCUMENTO =".$tip_documento;
            }
            $estado ="";
            if($estado_doc !='T'){
                if($estado_doc == 'R'){
                    $estado =" WHERE CANTIDAMOVIMIENTO = CANTIDARECIBIDOS ";
                }else{
                    if($estado_doc == 'NR'){
                        $estado =" WHERE CANTIDARECIBIDOS = 0 ";
                    }else{
                        $estado =" WHERE CANTIDAMOVIMIENTO != CANTIDARECIBIDOS AND CANTIDARECIBIDOS != 0 ";
                    }
                }
            }
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT * FROM  (SELECT DOC.*, TIPO.NOMBREDOCUMENTO ,  (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOC.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0) AS CANTIDAMOVIMIENTO,
            (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOC.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0 AND  MOVI.ESTADOENVIO = 2) AS CANTIDARECIBIDOS,
            (SELECT MOVI.IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOC.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0 AND  ROWNUM  = 1) AS PRIMOVIMIENTO
            FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOC, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO  TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI 
            WHERE ORGANI.IDORGANIGRAMA=".$_SESSION['DEPENDENCIA_ORIGEN']." AND DOC.AREACREA = ".$_SESSION['DEPENDENCIA_ORIGEN']."  AND  TIPO.IDTIPODOCUMENTO = DOC.IDTIPDOCUMENTO ".$tipo."  AND 
            DOC.FECHACREACION BETWEEN TO_DATE('$fecha_inicio', 'DD/MM/YYYY') AND TO_DATE('$fecha_fin', 'DD/MM/YYYY') AND DOC.INDGERENCIA=1 ORDER BY DOC.IDDOCUMENTO DESC) ".$estado;
            }else{
                $sql = "SELECT * FROM  (SELECT DOC.*, TIPO.NOMBREDOCUMENTO ,  (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOC.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0) AS CANTIDAMOVIMIENTO,
            (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOC.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0 AND  MOVI.ESTADOENVIO = 2) AS CANTIDARECIBIDOS,
            (SELECT MOVI.IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOC.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0 AND  ROWNUM  = 1) AS PRIMOVIMIENTO
            FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOC, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO  TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI 
            WHERE ORGANI.IDORGANIGRAMA=".$_SESSION['DEPENDENCIA_ORIGEN']." AND DOC.AREACREA = ".$_SESSION['DEPENDENCIA_ORIGEN']." AND  TIPO.IDTIPODOCUMENTO = DOC.IDTIPDOCUMENTO ".$tipo."  AND 
            DOC.IDPERSONACREA=".$idPersona." AND DOC.FECHACREACION BETWEEN TO_DATE('$fecha_inicio', 'DD/MM/YYYY') AND TO_DATE('$fecha_fin', 'DD/MM/YYYY') AND  DOC.INDGERENCIA=0 ORDER BY DOC.IDDOCUMENTO DESC) ".$estado;
            }
            
    
            $outValue = $this->oracle->query($sql)->result();
    
            return $outValue;
        }

        public function  CargoPersonalArea($cod_doc){
            $sql = "SELECT * FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC WHERE INDPERSONAL =1  AND  IDDOCUMENTO=".$cod_doc;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function Listar_dependencias(){
            $sql = "SELECT * FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA !=61 AND ESTADOAREA=1 ";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function Listar_dependencias_crea(){
            $sql = "SELECT * FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA !=61 AND IDORGANIGRAMA != ".$_SESSION['DEPENDENCIA_ORIGEN']." AND ESTADOAREA=1 ";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function getTicketExterno($idDocumento){
            $sql = "SELECT SOLICITANTE_EXTERNO, FOLIOSDOC, NUMERODOCUMENTO, HORA_CREACION, 
                           FECHACREACION, DOCIDENTIFICACION, NUMDOCIDENTI FROM PRDDBFCOMERCIAL.WF_DOCUMENTO WHERE IDDOCUMENTO =".$idDocumento;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function getUsuario_habilitado(){
            $sql = "SELECT USUARIOS.NNOMBRE, USUARIOS.NCODIGO, USUARIOS.NDIRECC, USUARIOS.LOGIN, USUARIOS.WF_ORGANIGRAMA, 
            USUARIOS.TIPOUSER  FROM (SELECT   LOGIN, RUTIMAGEN, NNOMBRE, NCODIGO, NSUSRCOD, NFECHAE, WF_ORGANIGRAMA, TIPOUSER,
            NSEMPCOD, NSOFICOD, NSARECOD, OFICOD, OFIAGECOD,  SERVIDOR, NDIRECC,  
            CASE WHEN ( NENDS > SYSDATE ) THEN 0 ELSE 1 END AS VENCIDO 
            FROM PRDDBFCOMERCIAL.NUSERS WHERE  NESTADO = 1 ) USUARIOS WHERE USUARIOS.VENCIDO =0";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function getUsuario_jefatura($organigrama, $codigo){
            $sql = "SELECT ORGANIGRAMA.NOMBREAREA, USUARIO.NNOMBRE, USUARIO.SIGLA_WORKFLOW  FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANIGRAMA, 
                    PRDDBFCOMERCIAL.NUSERS USUARIO WHERE ".$codigo."= USUARIO.NCODIGO AND ORGANIGRAMA.IDORGANIGRAMA=".$organigrama;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function setDatosArea($organigrama, $sigla, $idUsuario){
            $this->oracle->trans_begin();
            $ParamCorre  = array(
                'WF_ORGANIGRAMA' => $organigrama,
                'SIGLA_WORKFLOW' => $sigla,
                'TIPOUSER'       => 0
            );
            $this->oracle->where('NCODIGO', $idUsuario);
            $this->oracle->update('PRDDBFCOMERCIAL.NUSERS', $ParamCorre);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return array('resultado' => false , 'mensaje' => 'No se pudo guardar la data' );
            }else{
                $Getjefe = $this->oracle->query("SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDENCARGADO =".$idUsuario)->row();
                if(count($Getjefe)>0){
                    $this->oracle->trans_rollback();
                    return array('resultado' => false , 'mensaje' => 'El usuario es jefe del Area, no puede cambiarlo de area. primero tiene que cambiar de jefe luego cambiar al usuario de area' );
                }else{
                    $this->oracle->trans_commit();
                    return array('resultado' => true , 'mensaje' => 'Se cambio con exito al usuario' );
                }
                
            }
        }

        public function getAreas_jefatura($organigrama){
            $sql = "SELECT ORGANIGRAMA.NOMBREAREA, ORGANIGRAMA.IDORGANIGRAMA  FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANIGRAMA ";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function getEncargadoEntidad($dniEntidad){
            $destina = $this->oracle->query("SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA =".$dniEntidad)->row();
            $outValue = $destina->IDENCARGADO;
            return $outValue;
        }

        public function archivarDocumento($Movimiento, $observacion){
            $this->oracle->trans_begin();
            $ParamCorre  = array(
                'MOTIVOARCHIVACION' => $observacion,
                'ESTADOMOVIMIENTO'  => 2
            );
            $this->oracle->where('IDMOVIMIENTO', $Movimiento);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamCorre);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function desArchivarDocumento($Movimiento){
            $this->oracle->trans_begin();
            $ParamCorre  = array(
                'MOTIVOARCHIVACION' => '',
                'ESTADOMOVIMIENTO'  => 0
            );
            $this->oracle->where('IDMOVIMIENTO', $Movimiento);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamCorre);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function Cambiar_Cargo_usuario($repre_Anterior, $repre_Actual, $id_Organigrama, $siglas){
            $sql = "SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO =".$repre_Actual;
            $outValue = $this->oracle->query($sql)->result();
            
            $this->oracle->trans_begin();
            $ParamCorre  = array(
                'IDENCARGADO'       => $repre_Actual,
                'SIGLA_AREA'        => $siglas,
                'NOMBREENCARGADO'   => $outValue[0]->NNOMBRE,
                'FECHACREACION'     => date("d/m/Y")
            );
            $this->oracle->where('IDORGANIGRAMA', $id_Organigrama);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_ORGANIGRAMA', $ParamCorre);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{

                /* DESHABILITO USUARIO ANTERIOR */
                $ParamUsuario  = array(
                    'TIPOUSER'  => 0
                );
                
                $this->oracle->where('NCODIGO', $repre_Anterior);
                $this->oracle->update('PRDDBFCOMERCIAL.NUSERS', $ParamUsuario);
                
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                }
                /* HABILITO AL NUEVO USUARIO */
                $ParamUsuario  = array(
                    'TIPOUSER'       => 1,
                    'WF_ORGANIGRAMA' => $id_Organigrama
                );

                $this->oracle->where('NCODIGO', $repre_Actual);
                $this->oracle->update('PRDDBFCOMERCIAL.NUSERS', $ParamUsuario);
                
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                }else{
                    $this->oracle->trans_commit();
                    return true;
                }
            }
        }

        public function  regDocumentoExterno($Param_documento, $idPersona,$destinatarios, $asunto, $observaciones, $contenido, $suministro, $foliosDoc, $fechaMaxima){
            $this->oracle->trans_begin();
            $sql = "SELECT MAX(NUMERODOCUMENTO) AS MAXIMOCORRELATIVO FROM PRDDBFCOMERCIAL.WF_CORRELATIVODOC WHERE IDPERSONACORRELA =".$idPersona."  AND ANIO =".date("Y")." AND  IDTIPDOCUMENTO=21";
            $rpta = $this->oracle->query($sql)->row_array();
            $correlativo= '';
            if($rpta['MAXIMOCORRELATIVO']== null){ // INSERTO POR PRIMERA VEZ SU CORRELATIVO
                $ParamCorre  = array(
                    'OFICINACORRELA'   =>$_SESSION['NSOFICOD'] ,
                    'AREACORRELA'      =>$_SESSION['NSARECOD'] ,
                    'IDPERSONACORRELA' =>$_SESSION['user_id'] ,
                    'IDTIPDOCUMENTO'   =>21 ,
                    'NUMERODOCUMENTO'  => 1 ,
                    'ANIO'             => date("Y"),
                );
                $this->oracle->insert('PRDDBFCOMERCIAL.WF_CORRELATIVODOC', $ParamCorre);
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                }else{
                    $correlativo = 1;
                }
            }else{ // AUMENTO EN 1 EL CORRELATIVO 
                $correlativo = ((int)$rpta['MAXIMOCORRELATIVO']) + 1;
                $ParamCorre  = array(
                    'NUMERODOCUMENTO'  => $correlativo 
                );
                $this->oracle->where('IDPERSONACORRELA', $idPersona);
                $this->oracle->where('IDTIPDOCUMENTO',21);
                $this->oracle->update('PRDDBFCOMERCIAL.WF_CORRELATIVODOC', $ParamCorre);
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                }
            }
            // **************************************
            // PARA INSERTAR EN LA TABLA DOCUMENTOS *
            // **************************************
            $Param_documento['NUMERODOCUMENTO'] = $correlativo;
            $this->oracle->insert('PRDDBFCOMERCIAL.WF_DOCUMENTO', $Param_documento);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $row = $this->oracle->query("SELECT IDDOCUMENTO FROM PRDDBFCOMERCIAL.WF_DOCUMENTO ORDER BY IDDOCUMENTO DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY")->row();
                $id = $row->IDDOCUMENTO;
                $idDocumento = $id;
            }

            if(count($destinatarios) > 0){  // PARA LOS DESTINATARIOS 
                for ($i = 0; $i < count($destinatarios); $i++) {
                    // OBTENGO EL ENCARGADO DEL AREA
                    $destina = $this->oracle->query("SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA =".$destinatarios[$i]->id)->row();
                    
                    $desti = $destina->IDENCARGADO;
                   
                    
                    $ParamMovimiento  = array(
                        'IDDOCUMENTO'         =>$idDocumento,
                        'IDPERSONACREA'       => $idPersona,
                        'IDDEPENDENCIACREA'  =>$_SESSION['DEPENDENCIA_ORIGEN'], 
                        'OFICINADOC'          =>$_SESSION['NSOFICOD'],
                        'IDTIPDOCUMENTO'      =>21,
                        'IDPERSONAENVIA'      => $desti , 
                        'IDDEPENDENCIAENVIA'  => (int)$destinatarios[$i]->id,
                        'FECHACREACION'       =>date("d/m/Y"),
                        'HORA_CREO'           =>date("H:i:s"),
                        'FECHAMAXATENCION'    =>$fechaMaxima,
                        'FECHARECEPCION'      =>'',
                        'FOLIOS'              =>$Param_documento['FOLIOSTOTALES'],
                        'INDCOPIA'            =>0,
                        'ESTADOENVIO'         =>1,
                        'ESTADOELIMINADO'     =>0,
                        'INDGERENCIA'         =>1,
                        'INDREF'              =>0,
                        'INDDERIVA'           =>'0',
                        'IDMOVIMIDERIVADO'    =>0,
                        'INDEXTER'            => 1,
                        'INDPERSONAL'         => 0,
                        'ESTADOMOVIMIENTO'    => 0,
                        'TIENECARGO'          => $_SESSION['IND_GERENCIA']
                    );
                    $this->oracle->insert('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMovimiento);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }else{
                        $registro = $this->oracle->query("SELECT IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC ORDER BY IDMOVIMIENTO DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY")->row();
                        $idMov = $registro->IDMOVIMIENTO;
                        $idMovimiento = $idMov;
                        // INGRESANDO LA REFERENCIA INCIAL
                        $ParamReferencia  = array(
                            'IDMOVIMIENTOPADRE' => 0,
                            'IDMOVIMIENTOHIJO'  => $idMovimiento,
                            'ESTADOREFERENCIA'  => 0
                        );
                        $this->oracle->insert('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
                        if ($this->oracle->trans_status() === FALSE){
                            $this->oracle->trans_rollback();
                            return false;
                        }
                    }
                }
            }

            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                $respuesta = "DOCUMENTO EXTERNO N° " . $correlativo . "-" . date("Y") ;
            }
            return array("document_created" => $respuesta, "coddoc" => $idDocumento);

        }

        public function regDocumentoInterno($Param_documento, $idPersona,$destinatarios, $copias, $refes, $tipoDocDesc, $indExterno,$tipdoc_int, $tipo_cargo, $indPersonal, $fechaMax){
            $this->oracle->trans_begin();
            $correlativo= ''; 
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT * FROM PRDDBFCOMERCIAL.WF_CORRELATIVODOC WHERE IDTIPDOCUMENTO = ".$tipdoc_int." AND ANIO =".date("Y")." AND INDGERENCIA = 1 AND IDORGANIGRAMA = ". $_SESSION['DEPENDENCIA_ORIGEN'];
                $rpta = $this->oracle->query($sql)->row_array();
                if( $rpta['IDPERSONACORRELA'] != $idPersona ){
                    $ParamEdit  = array(
                        'IDPERSONACORRELA'  => $idPersona 
                    );
                    $this->oracle->where( 'ANIO', date("Y") );
                    $this->oracle->where( 'INDGERENCIA', 1  );
                    $this->oracle->where( 'IDTIPDOCUMENTO', $tipdoc_int );
                    $this->oracle->where( 'IDORGANIGRAMA', $_SESSION['DEPENDENCIA_ORIGEN'] );
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_CORRELATIVODOC', $ParamEdit);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }
                }
                $sql = "SELECT MAX(NUMERODOCUMENTO) AS MAXIMOCORRELATIVO FROM PRDDBFCOMERCIAL.WF_CORRELATIVODOC WHERE IDTIPDOCUMENTO = ".$tipdoc_int." AND ANIO =".date("Y")." AND INDGERENCIA = 1 AND IDORGANIGRAMA = ". $_SESSION['DEPENDENCIA_ORIGEN'];
                $rpta = $this->oracle->query($sql)->row_array();
                if($rpta['MAXIMOCORRELATIVO']== null){ // INSERTO POR PRIMERA VEZ SU CORRELATIVO
                    $ParamCorre  = array(
                        'OFICINACORRELA'   => $_SESSION['NSOFICOD'] ,
                        'AREACORRELA'      => $_SESSION['NSARECOD'] ,
                        'IDPERSONACORRELA' => $_SESSION['user_id']  ,
                        'IDTIPDOCUMENTO'   => $tipdoc_int           ,
                        'NUMERODOCUMENTO'  => 1                     ,
                        'ANIO'             => date("Y")             ,
                        'INDGERENCIA'      => 1                     ,
                        'IDORGANIGRAMA'    => $_SESSION['DEPENDENCIA_ORIGEN']
                    );
                    $this->oracle->insert('PRDDBFCOMERCIAL.WF_CORRELATIVODOC', $ParamCorre);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }else{
                        $correlativo = 1;
                    }
                }else{// AUMENTO EN 1 EL CORRELATIVO 
                    $correlativo = ((int)$rpta['MAXIMOCORRELATIVO']) + 1;
                    $ParamCorre  = array(
                        'NUMERODOCUMENTO'  => $correlativo 
                    );
                    $this->oracle->where( 'ANIO', date("Y") );
                    $this->oracle->where( 'INDGERENCIA', 1  );
                    $this->oracle->where( 'IDTIPDOCUMENTO', $tipdoc_int );
                    $this->oracle->where( 'IDORGANIGRAMA', $_SESSION['DEPENDENCIA_ORIGEN'] );
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_CORRELATIVODOC', $ParamCorre);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }

                }
                
            }else{
                $sql = "SELECT MAX(NUMERODOCUMENTO) AS MAXIMOCORRELATIVO FROM PRDDBFCOMERCIAL.WF_CORRELATIVODOC WHERE IDPERSONACORRELA =".$idPersona." AND IDTIPDOCUMENTO=".$tipdoc_int." AND ANIO =".date("Y")." AND INDGERENCIA = 0 AND IDORGANIGRAMA = ". $_SESSION['DEPENDENCIA_ORIGEN'];
                $rpta = $this->oracle->query($sql)->row_array();
                if($rpta['MAXIMOCORRELATIVO']== null){ // INSERTO POR PRIMERA VEZ SU CORRELATIVO
                    $ParamCorre  = array(
                        'OFICINACORRELA'   => $_SESSION['NSOFICOD'] ,
                        'AREACORRELA'      => $_SESSION['NSARECOD'] ,
                        'IDPERSONACORRELA' => $_SESSION['user_id']  ,
                        'IDTIPDOCUMENTO'   => $tipdoc_int           ,
                        'NUMERODOCUMENTO'  => 1                     ,
                        'ANIO'             => date("Y")             ,
                        'INDGERENCIA'      => 0                     ,
                        'IDORGANIGRAMA'    => $_SESSION['DEPENDENCIA_ORIGEN']
                    );
                    $this->oracle->insert('PRDDBFCOMERCIAL.WF_CORRELATIVODOC', $ParamCorre);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }else{
                        $correlativo = 1;
                    }
                }else{ // AUMENTO EN 1 EL CORRELATIVO 
                    $correlativo = ((int)$rpta['MAXIMOCORRELATIVO']) + 1;
                    $ParamCorre  = array(
                        'NUMERODOCUMENTO'  => $correlativo 
                    );
                    $this->oracle->where( 'ANIO', date("Y") );
                    $this->oracle->where( 'INDGERENCIA', 0  );
                    $this->oracle->where( 'IDTIPDOCUMENTO', $tipdoc_int );
                    $this->oracle->where( 'IDORGANIGRAMA', $_SESSION['DEPENDENCIA_ORIGEN'] );
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_CORRELATIVODOC', $ParamCorre);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }
                }
            }
            
            
            // **************************************
            // PARA INSERTAR EN LA TABLA DOCUMENTOS *
            // **************************************

            $Param_documento['NUMERODOCUMENTO'] = $correlativo;
            $this->oracle->insert('PRDDBFCOMERCIAL.WF_DOCUMENTO', $Param_documento);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $row = $this->oracle->query("SELECT IDDOCUMENTO FROM PRDDBFCOMERCIAL.WF_DOCUMENTO ORDER BY IDDOCUMENTO DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY")->row();
                $id = $row->IDDOCUMENTO;
                $idDocumento = $id;
            }
            if(count($destinatarios) > 0){  // PARA LOS DESTINATARIOS 
                for ($i = 0; $i < count($destinatarios); $i++) {
                    // OBTENGO EL ENCARGADO DEL AREA
                    if($indPersonal == 0){
                        if($tipo_cargo==1){
                            $destina = $this->oracle->query("SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA =".$destinatarios[$i]->id)->row();
                        }else{
                            $destina = $this->oracle->query("SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA =".$_SESSION['DEPENDENCIA_ORIGEN'])->row();
                        } 
                        $desti = $destina->IDENCARGADO;
                    }else{
                        $desti = $destinatarios[$i]->id;
                    }
                    
                    $ParamMovimiento  = array(
                        'IDDOCUMENTO'         =>$idDocumento,
                        'IDPERSONACREA'       => $idPersona,
                        'IDDEPENDENCIACREA'   =>$_SESSION['DEPENDENCIA_ORIGEN'], 
                        'OFICINADOC'          =>$_SESSION['NSOFICOD'],
                        'IDTIPDOCUMENTO'      =>$tipdoc_int,
                        'IDPERSONAENVIA'      => $desti, 
                        'IDDEPENDENCIAENVIA'  =>  (($indPersonal == 1) ? ($_SESSION['DEPENDENCIA_ORIGEN']) : (($tipo_cargo==1) ? ((int)$destinatarios[$i]->id) : ($_SESSION['DEPENDENCIA_ORIGEN']) ) )  ,
                        'FECHACREACION'       =>date("d/m/Y"),
                        'HORA_CREO'           =>date("H:i:s"),
                        'FECHAMAXATENCION'    => $fechaMax,
                        'ESTADOMOVIMIENTO'    =>'0',
                        'FECHARECEPCION'      =>'',
                        'FOLIOS'              =>$Param_documento['FOLIOSTOTALES'],
                        'INDCOPIA'            =>0,
                        'ESTADOENVIO'         =>1,
                        'ESTADOELIMINADO'     =>0,
                        'INDGERENCIA'         =>(($indPersonal== 1) ? 0 : 1 ),
                        'INDREF'              =>0,
                        'INDDERIVA'           =>'0',
                        'IDMOVIMIDERIVADO'    =>0,
                        'INDEXTER'            => $indExterno,
                        'INDPERSONAL'         => $indPersonal,
                        'TIENECARGO'          => $_SESSION['IND_GERENCIA']
                    );
                    $this->oracle->insert('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMovimiento);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }else{
                        $registro = $this->oracle->query("SELECT IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC ORDER BY IDMOVIMIENTO DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY")->row();
                        $idMov = $registro->IDMOVIMIENTO;
                        $idMovimiento = $idMov;
                        // INGRESANDO LA REFERENCIA INCIAL
                        $ParamReferencia  = array(
                            'IDMOVIMIENTOPADRE' => 0,
                            'IDMOVIMIENTOHIJO'  => $idMovimiento,
                            'ESTADOREFERENCIA'  => 0
                        );
                        $this->oracle->insert('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
                        if ($this->oracle->trans_status() === FALSE){
                            $this->oracle->trans_rollback();
                            return false;
                        }
                        // PREGUNTO POR LAS REFERENCIAS 
                        if(count($refes)>0){

                            for ($j = 0; $j<count($refes); $j++) {
                                // CAMBIO ESTADO DE LA REFERENCIA
                                $ParamEstado  = array(
                                    'INDREF'           => 1 ,
                                    'ESTADOMOVIMIENTO' => (($refes[$j]->estado_ref =='A')? '1' :'0')
                                );
                                $this->oracle->where('IDMOVIMIENTO', (int)$refes[$j]->idMovimiento);
                                $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamEstado);
                                if ($this->oracle->trans_status() === FALSE){
                                    $this->oracle->trans_rollback();
                                    return false;
                                }
                                // INSERTO A LA TABLA DE REFERENCIAS 
                                $ParamReferencia  = array(
                                    'IDMOVIMIENTOPADRE' => (int)$refes[$j]->idMovimiento,
                                    'IDMOVIMIENTOHIJO'  => $idMovimiento,
                                    'ESTADOREFERENCIA'  => 0
                                );
                                $this->oracle->insert('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
                                if ($this->oracle->trans_status() === FALSE){
                                    $this->oracle->trans_rollback();
                                    return false;
                                }
                            }

                        }

                    }
                }
            }

            if(count($copias) > 0){
                for ($i = 0; $i < count($copias); $i++) {
                    // Obtengo al encargado del area
                    if($indPersonal == 0){
                        $destina = $this->oracle->query("SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA =".$copias[$i]->id)->row();
                        $desti = $destina->IDENCARGADO;
                    }else{
                        $desti = $copias[$i]->id;
                    }
                    
                    $ParamMovimiento  = array(
                        'IDDOCUMENTO'         =>$idDocumento,
                        'IDPERSONACREA'       => $idPersona,
                        'IDDEPENDENCIACREA'  =>$_SESSION['DEPENDENCIA_ORIGEN'], 
                        'OFICINADOC'          =>$_SESSION['NSOFICOD'],
                        'IDTIPDOCUMENTO'      =>$tipdoc_int,
                        'IDPERSONAENVIA'      => $desti,
                        'IDDEPENDENCIAENVIA'  =>  (($indPersonal == 1) ? ($_SESSION['DEPENDENCIA_ORIGEN']) : ($copias[$i]->id) ) ,
                        'FECHACREACION'       =>date("d/m/Y"),
                        'HORA_CREO'           =>date("H:i:s"),
                        'FECHAMAXATENCION'    => $fechaMax,
                        'ESTADOMOVIMIENTO'    =>'0',
                        'FECHARECEPCION'      =>'',
                        'FOLIOS'              =>$copias[$i]->folios,
                        'INDCOPIA'            =>1,
                        'ESTADOENVIO'         =>1,
                        'ESTADOELIMINADO'     =>0,
                        'INDGERENCIA'         =>(($indPersonal== 1) ? 0 : 1 ),
                        'INDREF'              =>0,
                        'INDDERIVA'           =>'0',
                        'IDMOVIMIDERIVADO'    =>0,
                        'INDEXTER'            => $indExterno,
                        'INDPERSONAL'         => $indPersonal,
                        'TIENECARGO'          => $_SESSION['IND_GERENCIA']
                    );
                    $this->oracle->insert('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMovimiento);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }else{
                        $registro = $this->oracle->query("SELECT IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC ORDER BY IDMOVIMIENTO DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY")->row();
                        $idMov = $registro->IDMOVIMIENTO;
                        $idMovimiento_copia = $idMov;
                        // INGRESANDO LA REFERENCIA INCIAL
                        $ParamReferencia  = array(
                            'IDMOVIMIENTOPADRE' => 0,
                            'IDMOVIMIENTOHIJO'  => $idMovimiento_copia,
                            'ESTADOREFERENCIA'  => 0
                        );
                        $this->oracle->insert('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
                        if ($this->oracle->trans_status() === FALSE){
                            $this->oracle->trans_rollback();
                            return false;
                        }
                        // PREGUNTO POR LAS REFERENCIAS 
                        if(count($refes)>0){
                            for ($j = 0; $j<count($refes); $j++) {
                                
                                // INSERTO A LA TABLA DE REFERENCIAS 
                                $ParamReferencia  = array(
                                    'IDMOVIMIENTOPADRE' => (int)$refes[$j]->idMovimiento,
                                    'IDMOVIMIENTOHIJO'  => $idMovimiento_copia,
                                    'ESTADOREFERENCIA'  => 0
                                );
                                $this->oracle->insert('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
                                if ($this->oracle->trans_status() === FALSE){
                                    $this->oracle->trans_rollback();
                                    return false;
                                }
                            }
                        }

                    }
                }
            }

            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                $respuesta = $tipoDocDesc . " N° " . $correlativo . "-" . date("Y") ;
            }
            return array("document_created" => $respuesta, "coddoc" => $idDocumento);

        }

        function guardoEstRef($referencia){
            if(count($referencia)>0){
                for ($j = 0; $j<count($referencia); $j++) {
                    // CAMBIO ESTADO DE LA REFERENCIA
                    $ParamEstado  = array(
                        'ESTADOMOVIMIENTO' => (($referencia[$j]['estado_ref'] =='A')? '1' :'0')
                    );
                    $this->oracle->where('IDMOVIMIENTO', (int)$referencia[$j]['idMovimiento']);
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamEstado);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }
                }
                $this->oracle->trans_commit();
                return true;
            }
        }

        function getPersonalArea($idper, $iddepen){
            $sql = "SELECT USUARIO.NCODIGO, USUARIO.NNOMBRE  
            FROM (SELECT NUSERS.NCODIGO, NUSERS.NNOMBRE, NUSERS.WF_ORGANIGRAMA , CASE WHEN ( NENDS > SYSDATE ) THEN 0 ELSE 1 END AS VENCIDO FROM PRDDBFCOMERCIAL.NUSERS) USUARIO  
            WHERE USUARIO.WF_ORGANIGRAMA=".$iddepen." AND USUARIO.VENCIDO=0 AND USUARIO.NCODIGO !=".$idper;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }


        function getPersonalArea_general($iddepen){
            $sql = "SELECT USUARIO.NCODIGO, USUARIO.NNOMBRE  
            FROM (SELECT NUSERS.NCODIGO, NUSERS.NNOMBRE, NUSERS.WF_ORGANIGRAMA , CASE WHEN ( NENDS > SYSDATE ) THEN 0 ELSE 1 END AS VENCIDO FROM PRDDBFCOMERCIAL.NUSERS) USUARIO  
            WHERE USUARIO.WF_ORGANIGRAMA=".$iddepen." AND USUARIO.VENCIDO=0 ";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function updateDireccion($idDocumento, $archivos){
            $this->oracle->trans_begin();
            $this->oracle->where('IDDOCUMENTO', $idDocumento);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_DOCUMENTO', $archivos);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        function insertArchivo($idDocumento, $archivos){
            $this->oracle->trans_begin();
            $this->oracle->insert('PRDDBFCOMERCIAL.WF_ENLACEARCHIVOS', $archivos);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        function setDeleteFile($iddoc, $IdEnlace, $estado){
            $this->oracle->trans_begin();
            $this->oracle->where('IDENLACEARCHIVO', $IdEnlace);
            $this->oracle->where('DOCREFERENCIA', $iddoc);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_ENLACEARCHIVOS', $estado);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        function getDireccion($idDocumento){
            $sql = "SELECT RUTA_ARCHIVO FROM PRDDBFCOMERCIAL.WF_DOCUMENTO WHERE IDDOCUMENTO =".$idDocumento;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }


        function getAdjuntos($iddoc){
            $sql = "SELECT DOCREFERENCIA, ENLACEDOCUMENTO, IDENLACEARCHIVO
                    FROM PRDDBFCOMERCIAL.WF_ENLACEARCHIVOS  
                    WHERE  DOCREFERENCIA =".$iddoc. " AND ESTADO ='1'";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }



        function getAreasRecepcionaron($iddoc){
            $sql = "SELECT MOVI.ESTADOENVIO, MOVI.INDCOPIA,  MOVI.IDMOVIMIENTO,  (CASE WHEN MOVI.INDPERSONAL = 0 THEN (ORGANIGRAMA.NOMBREAREA || ' (' || ORGANIGRAMA.SIGLA_AREA || ')' ) ELSE (SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = MOVI.IDPERSONAENVIA   ) END) AS NOMBREAREA
            FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI ,PRDDBFCOMERCIAL.WF_TIPDOCUMENTO  TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANIGRAMA
            WHERE TIPO.IDTIPODOCUMENTO = MOVI.IDTIPDOCUMENTO AND
            ORGANIGRAMA.IDORGANIGRAMA = MOVI.IDDEPENDENCIAENVIA AND 
            MOVI.ESTADOELIMINADO =0 AND   MOVI.IDDOCUMENTO = ".$iddoc;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function getDocsCreadosxUsu($idper, $numero, $anio) {
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT MIN(MOVIMIENTO.IDMOVIMIENTO) AS IDMOVIMIENTO , MOVIMIENTO.INDEXTER, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.IDDOCUMENTO, DOCUMENTO.IDTIPDOCUMENTO, DOCUMENTO.TIPO_EXTERNO,  TIPO.NOMBREDOCUMENTO,
                        DOCUMENTO.FOLIOSTOTALES, DOCUMENTO.FECHAMAXATENCION, to_char(DOCUMENTO.FECHACREACION,'DD-MM-YYYY') AS FECHACREACION , DOCUMENTO.FOLIOSDOC,  DOCUMENTO.ANIO, ORGANIGRAMA.SIGLA_AREA, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.RUTA_ARCHIVO, DOCUMENTO.CONTENIDO, MOVIMIENTO.INDPERSONAL ,ORGANIGRAMA.IDENCARGADO AS IDENCARGADO, USUARIO.SIGLA_WORKFLOW, DOCUMENTO.IDPERSONACREA AS PERSONACREA
                         FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO , PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANIGRAMA,  PRDDBFCOMERCIAL.NUSERS USUARIO
                         WHERE TIPO.IDTIPODOCUMENTO= DOCUMENTO.IDTIPDOCUMENTO AND  MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND  USUARIO.NCODIGO = DOCUMENTO.IDPERSONACREA
                         AND MOVIMIENTO.ESTADOENVIO =1  AND MOVIMIENTO.ESTADOELIMINADO =0  AND MOVIMIENTO.IDDEPENDENCIACREA = ORGANIGRAMA.IDORGANIGRAMA
                         AND DOCUMENTO.ANIO=".$anio."  AND DOCUMENTO.AREACREA = ".$_SESSION['DEPENDENCIA_ORIGEN']."  AND DOCUMENTO.NUMERODOCUMENTO =".$numero." AND DOCUMENTO.INDGERENCIA = 1
                         GROUP BY   DOCUMENTO.NUMERODOCUMENTO,  TIPO.NOMBREDOCUMENTO ,DOCUMENTO.IDDOCUMENTO ,DOCUMENTO.IDTIPDOCUMENTO,DOCUMENTO.TIPO_EXTERNO,
                         DOCUMENTO.FOLIOSTOTALES, DOCUMENTO.FECHAMAXATENCION, DOCUMENTO.FECHACREACION, DOCUMENTO.FOLIOSDOC, DOCUMENTO.ANIO, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.RUTA_ARCHIVO, DOCUMENTO.CONTENIDO, ORGANIGRAMA.SIGLA_AREA, MOVIMIENTO.INDPERSONAL, MOVIMIENTO.INDEXTER,ORGANIGRAMA.IDENCARGADO, USUARIO.SIGLA_WORKFLOW,DOCUMENTO.IDPERSONACREA
                         HAVING  COUNT(DOCUMENTO.IDDOCUMENTO) =  (SELECT COUNT(MOVIM.IDDOCUMENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIM WHERE MOVIM.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVIM.ESTADOELIMINADO=0)";
            }else{
                $sql = "SELECT MIN(MOVIMIENTO.IDMOVIMIENTO) AS IDMOVIMIENTO , MOVIMIENTO.INDEXTER, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.IDDOCUMENTO, DOCUMENTO.IDTIPDOCUMENTO, DOCUMENTO.TIPO_EXTERNO,  TIPO.NOMBREDOCUMENTO,
                        DOCUMENTO.FOLIOSTOTALES, DOCUMENTO.FECHAMAXATENCION, to_char(DOCUMENTO.FECHACREACION,'DD-MM-YYYY') AS FECHACREACION , DOCUMENTO.FOLIOSDOC,  DOCUMENTO.ANIO, ORGANIGRAMA.SIGLA_AREA, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.RUTA_ARCHIVO, DOCUMENTO.CONTENIDO, MOVIMIENTO.INDPERSONAL ,ORGANIGRAMA.IDENCARGADO AS IDENCARGADO, USUARIO.SIGLA_WORKFLOW, DOCUMENTO.IDPERSONACREA AS PERSONACREA
                         FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO , PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANIGRAMA,  PRDDBFCOMERCIAL.NUSERS USUARIO
                         WHERE TIPO.IDTIPODOCUMENTO= DOCUMENTO.IDTIPDOCUMENTO AND  MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND  USUARIO.NCODIGO = DOCUMENTO.IDPERSONACREA
                         AND MOVIMIENTO.ESTADOENVIO =1  AND MOVIMIENTO.ESTADOELIMINADO =0  AND MOVIMIENTO.IDDEPENDENCIACREA = ORGANIGRAMA.IDORGANIGRAMA
                         AND DOCUMENTO.ANIO=".$anio."  AND DOCUMENTO.IDPERSONACREA=".$idper." AND DOCUMENTO.NUMERODOCUMENTO =".$numero." AND DOCUMENTO.INDGERENCIA = 0
                         GROUP BY   DOCUMENTO.NUMERODOCUMENTO,  TIPO.NOMBREDOCUMENTO ,DOCUMENTO.IDDOCUMENTO ,DOCUMENTO.IDTIPDOCUMENTO,DOCUMENTO.TIPO_EXTERNO,
                         DOCUMENTO.FOLIOSTOTALES, DOCUMENTO.FECHAMAXATENCION, DOCUMENTO.FECHACREACION, DOCUMENTO.FOLIOSDOC, DOCUMENTO.ANIO, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.RUTA_ARCHIVO, DOCUMENTO.CONTENIDO, ORGANIGRAMA.SIGLA_AREA, MOVIMIENTO.INDPERSONAL, MOVIMIENTO.INDEXTER,ORGANIGRAMA.IDENCARGADO, USUARIO.SIGLA_WORKFLOW,DOCUMENTO.IDPERSONACREA
                         HAVING  COUNT(DOCUMENTO.IDDOCUMENTO) =  (SELECT COUNT(MOVIM.IDDOCUMENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIM WHERE MOVIM.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVIM.ESTADOELIMINADO=0)";
            }
            
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function getMovsCorreccion($cod_doc, $indCopia, $idper){
            $sql = "SELECT MOVIMIENTO.*, DOCUMENTO.ASUNTO, (CASE WHEN MOVIMIENTO.INDPERSONAL = 0 THEN (ORGANIGRAMA.NOMBREAREA) ELSE (SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = MOVIMIENTO.IDPERSONAENVIA   ) END) AS NOMBREAREA 
                    FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANIGRAMA 
                    WHERE MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND  
                    ORGANIGRAMA.IDORGANIGRAMA=MOVIMIENTO.IDDEPENDENCIAENVIA AND  MOVIMIENTO.ESTADOELIMINADO = 0 AND 
                    MOVIMIENTO.IDDOCUMENTO =".$cod_doc." AND MOVIMIENTO.INDCOPIA =".$indCopia;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function getAreas_x_representante(){
            $sql = "SELECT * FROM  PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE ESTADOAREA=1";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function actualizarFoliosCorrecion($Param_documento, $cod_doc, $fechaMaxima){
            $this->oracle->trans_begin();
            $this->oracle->where('IDDOCUMENTO', $cod_doc);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_DOCUMENTO', $Param_documento);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else {
                $Param_doc =  array(
                    'FECHAMAXATENCION'  => $fechaMaxima
                );
                $this->oracle->where('IDDOCUMENTO', $cod_doc);
                $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $Param_doc);
                if($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                }else{
                    $this->oracle->trans_commit();
                    $respuesta = array("respuesta" => 'ok');
                }
            }
            return $respuesta;
        }

        function actualizaMovDestino($dniDestino, $idDepend, $idMovimiento, $indPersonal, $indExterno) {
            $respuesta = "";
            $this->oracle->trans_begin();
            if($indExterno == 0){
                if($indPersonal ==0){
                    $Param_documento =  array(
                        'IDDEPENDENCIAENVIA' => $dniDestino
                    );
                }else{
                    $Param_documento =  array(
                        'IDPERSONAENVIA' => $dniDestino
                    );
                }
            }else{

                $Param_documento =  array(
                    'IDDEPENDENCIAENVIA' => $dniDestino
                );

            }
            
            $this->oracle->where('IDMOVIMIENTO', $idMovimiento);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $Param_documento);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }

        function getMovFoliosCorreccion($idDocumento) {

            $sql = "SELECT MOVIMIENTO.*, DOCUMENTO.ASUNTO, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.ANIO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA, (CASE WHEN MOVIMIENTO.INDPERSONAL = 0 THEN (ORGANIGRAMA.NOMBREAREA) ELSE (SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = MOVIMIENTO.IDPERSONAENVIA   ) END) AS NOMBREAREA   , TIPO.NOMBREDOCUMENTO,
                    DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL 
                    FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANIGRAMA,PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO
                    WHERE MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND  
                    ORGANIGRAMA.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIAENVIA AND  MOVIMIENTO.ESTADOELIMINADO =0 AND 
                    TIPO.IDTIPODOCUMENTO = MOVIMIENTO.IDTIPDOCUMENTO AND   MOVIMIENTO.IDDOCUMENTO = ".$idDocumento;
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function actualizarFoliosTotalMovCorrecion($idMovimiento, $folios) {
            $respuesta = "";
            $this->oracle->trans_begin();
            $Param_documento =  array(
                'FOLIOS' => $folios
            );
            $this->oracle->where('IDMOVIMIENTO', $idMovimiento);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $Param_documento);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }

        function eliminarMovCorrecion($idMovimiento) {
            $respuesta = "";
            $this->oracle->trans_begin();
            $Param_documento =  array(
                'ESTADOELIMINADO' => 1
            );
            $this->oracle->where('IDMOVIMIENTO', $idMovimiento);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $Param_documento);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }

        function agregarDestinoCorrecion($ParamMovimiento) {
            $respuesta = "";
            $this->oracle->trans_begin();
            $this->oracle->insert('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMovimiento);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }

        function get_list_externos($fecha_inicio, $fecha_fin){
            $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.ANIO, DOCUMENTO.IDDOCUMENTO, DOCUMENTO.SOLICITANTE_EXTERNO, 
            DOCUMENTO.FECHACREACION, TIPO.NOMBREDOCUMENTO, DOCUMENTO.ASUNTO, DOCUMENTO.FOLIOSDOC, DOCUMENTO.SUMINISTRO_EXTERNO FROM  PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO 
            WHERE TIPO_EXTERNO =1 AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO AND DOCUMENTO.IDPERSONACREA = ".$_SESSION['user_id']." AND 
             DOCUMENTO.FECHACREACION BETWEEN TO_DATE('$fecha_inicio', 'DD/MM/YYYY') AND TO_DATE('$fecha_fin', 'DD/MM/YYYY')  ORDER BY DOCUMENTO.NUMERODOCUMENTO DESC";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function Obtener_documentos_creados_graph($idper, $filtro_doc = false, $filtro_depen = false, $filtro_fecha = false) {
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT DOCUMENTO.FECHACREACION AS tiempo,  COUNT(DOCUMENTO.IDDOCUMENTO) AS cantidad, COUNT(DOCUMENTO.IDDOCUMENTO) AS respuestas
                FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO
                WHERE  ";
                $sql .= "DOCUMENTO.INDGERENCIA = 1 AND DOCUMENTO.AREACREA= ".$_SESSION['DEPENDENCIA_ORIGEN']; 
                $sql .= $filtro_fecha ? "AND DOCUMENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "GROUP BY DOCUMENTO.FECHACREACION ORDER BY DOCUMENTO.FECHACREACION ASC ";
            }else{
                $sql = "SELECT DOCUMENTO.FECHACREACION AS tiempo,  COUNT(DOCUMENTO.IDDOCUMENTO) AS cantidad, COUNT(DOCUMENTO.IDDOCUMENTO) AS respuestas
                FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO
                WHERE  ";
                $sql .= "DOCUMENTO.IDPERSONACREA = ".$idper." AND DOCUMENTO.INDGERENCIA = 0 AND DOCUMENTO.AREACREA= ".$_SESSION['DEPENDENCIA_ORIGEN']; 
                $sql .= $filtro_fecha ? "AND DOCUMENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "GROUP BY DOCUMENTO.FECHACREACION ORDER BY DOCUMENTO.FECHACREACION ASC ";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        function Obtener_documentos_recibidos_graph($idper, $filtro_doc = false, $filtro_depen = false, $filtro_fecha = false) {
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT MOVIMIENTO.FECHARECEPCION AS tiempo,  COUNT(MOVIMIENTO.IDMOVIMIENTO) AS cantidad, COUNT(MOVIMIENTO.IDMOVIMIENTO) AS respuestas
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE   MOVIMIENTO.IDDOCUMENTO= DOCUMENTO.IDDOCUMENTO AND MOVIMIENTO.ESTADOELIMINADO=0 AND MOVIMIENTO.ESTADOENVIO =2 AND ";
                $sql .= " MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 1 "; 
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHARECEPCION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_depen ? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "GROUP BY MOVIMIENTO.FECHARECEPCION ORDER BY MOVIMIENTO.FECHARECEPCION ASC ";
            }else{
                $sql = "SELECT MOVIMIENTO.FECHARECEPCION AS tiempo,  COUNT(MOVIMIENTO.IDMOVIMIENTO) AS cantidad, COUNT(MOVIMIENTO.IDMOVIMIENTO) AS respuestas
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE   MOVIMIENTO.IDDOCUMENTO= DOCUMENTO.IDDOCUMENTO AND MOVIMIENTO.ESTADOELIMINADO=0 AND MOVIMIENTO.ESTADOENVIO =2 AND ";
                $sql .= " MOVIMIENTO.IDPERSONAENVIA = ".$idper." AND MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 0 " ; 
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHARECEPCION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_depen ? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "GROUP BY MOVIMIENTO.FECHARECEPCION ORDER BY MOVIMIENTO.FECHARECEPCION ASC ";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }
        function Obtener_documentos_por_recibidos_graph($idper, $filtro_doc = false, $filtro_depen = false, $filtro_fecha = false) {
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT MOVIMIENTO.FECHACREACION AS tiempo,  COUNT(MOVIMIENTO.IDMOVIMIENTO) AS cantidad, COUNT(MOVIMIENTO.IDMOVIMIENTO) AS respuestas
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE   MOVIMIENTO.IDDOCUMENTO= DOCUMENTO.IDDOCUMENTO AND MOVIMIENTO.ESTADOELIMINADO=0 AND MOVIMIENTO.ESTADOENVIO =1 AND ";
                $sql .= " MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 1  "; 
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_depen ? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "GROUP BY MOVIMIENTO.FECHACREACION ORDER BY MOVIMIENTO.FECHACREACION ASC ";
            }else{
                $sql = "SELECT MOVIMIENTO.FECHACREACION AS tiempo,  COUNT(MOVIMIENTO.IDMOVIMIENTO) AS cantidad, COUNT(MOVIMIENTO.IDMOVIMIENTO) AS respuestas
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE   MOVIMIENTO.IDDOCUMENTO= DOCUMENTO.IDDOCUMENTO AND MOVIMIENTO.ESTADOELIMINADO=0 AND MOVIMIENTO.ESTADOENVIO =1 AND ";
                $sql .= " MOVIMIENTO.IDPERSONAENVIA = ".$idper." AND MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 0 "; 
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_depen ? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "GROUP BY MOVIMIENTO.FECHACREACION ORDER BY MOVIMIENTO.FECHACREACION ASC ";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }
        
        function Obtener_documentos_creados($idper, $filtro_doc = false, $filtro_depen = false, $filtro_fecha = false) {
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT TIEMPO,COUNT(IDDOCUMENTO) AS cantidad, IDDOCUMENTO, NOMBRE, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, SIGLAS_PERSONAL, IDMOVIMIENTO, CANTIDAMOVIMIENTO,  CANTIDARECIBIDOS , ESTADOMOVIMIENTO  FROM ( SELECT DOCUMENTO.FECHACREACION AS tiempo,  DOCUMENTO.IDDOCUMENTO ,TIPO.NOMBREDOCUMENTO AS nombre, DOCUMENTO.NUMERODOCUMENTO AS NUMERO ,
                        ORGANI.NOMBREAREA AS AREA,  DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA,  DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL,
                        (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0) AS CANTIDAMOVIMIENTO,
                        (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0 AND  MOVI.ESTADOENVIO = 2) AS CANTIDARECIBIDOS,
                        MOVIMIENTO.ESTADOMOVIMIENTO,
                        (SELECT MOVI.IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVI.ESTADOELIMINADO =0 AND MOVI.INDGERENCIA =0  AND ROWNUM=1 ) AS IDMOVIMIENTO
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO AND 
                        MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND
                        MOVIMIENTO.ESTADOELIMINADO =0 AND
                        MOVIMIENTO.IDDEPENDENCIACREA   = ORGANI.IDORGANIGRAMA AND DOCUMENTO.AREACREA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND DOCUMENTO.INDGERENCIA = 1 ";
                $sql .= $filtro_fecha ? "AND DOCUMENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= " ORDER BY TIPO.NOMBREDOCUMENTO, DOCUMENTO.NUMERODOCUMENTO DESC ) GROUP BY TIEMPO, IDDOCUMENTO, NOMBRE, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, SIGLAS_PERSONAL , IDMOVIMIENTO, CANTIDAMOVIMIENTO,  CANTIDARECIBIDOS , ESTADOMOVIMIENTO ORDER BY NUMERO DESC  ";
            }else{
                $sql = "SELECT TIEMPO,COUNT(IDDOCUMENTO) AS cantidad, IDDOCUMENTO, NOMBRE, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, SIGLAS_PERSONAL, IDMOVIMIENTO, CANTIDAMOVIMIENTO,  CANTIDARECIBIDOS , ESTADOMOVIMIENTO  FROM (  SELECT DOCUMENTO.FECHACREACION AS tiempo,  DOCUMENTO.IDDOCUMENTO,  TIPO.NOMBREDOCUMENTO AS nombre, DOCUMENTO.NUMERODOCUMENTO AS NUMERO ,
                        ORGANI.NOMBREAREA AS AREA,  DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA,  DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL,
                        (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0) AS CANTIDAMOVIMIENTO,
                        (SELECT COUNT(MOVI.IDMOVIMIENTO) FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVI.ESTADOELIMINADO=0 AND  MOVI.ESTADOENVIO = 2) AS CANTIDARECIBIDOS,
                        MOVIMIENTO.ESTADOMOVIMIENTO,
                        (SELECT MOVI.IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVI WHERE MOVI.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND MOVI.ESTADOELIMINADO =0 AND MOVI.INDGERENCIA =1 AND  ROWNUM=1 ) AS IDMOVIMIENTO
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO AND 
                        MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND
                        MOVIMIENTO.ESTADOELIMINADO =0 AND
                        MOVIMIENTO.IDDEPENDENCIACREA   = ORGANI.IDORGANIGRAMA AND DOCUMENTO.AREACREA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND DOCUMENTO.INDGERENCIA = 0 AND";
                $sql .= " DOCUMENTO.IDPERSONACREA = $idper "; 
                $sql .= $filtro_fecha ? "AND DOCUMENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "ORDER BY TIPO.NOMBREDOCUMENTO, DOCUMENTO.NUMERODOCUMENTO DESC ) GROUP BY TIEMPO, IDDOCUMENTO, NOMBRE, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, SIGLAS_PERSONAL , IDMOVIMIENTO, CANTIDAMOVIMIENTO,  CANTIDARECIBIDOS , ESTADOMOVIMIENTO ORDER BY NUMERO DESC  ";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        function Obtener_documentos_recibidos($idper, $filtro_doc = false, $filtro_depen = false, $filtro_fecha = false) {
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT COUNT(IDMOVIMIENTO) AS cantidad, tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO FROM  ( SELECT MOVIMIENTO.FECHARECEPCION AS tiempo, TIPO.NOMBREDOCUMENTO AS nombre, DOCUMENTO.NUMERODOCUMENTO AS NUMERO ,
                        ORGANI.NOMBREAREA AS AREA,  DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA,  DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.IDMOVIMIENTO,
                        MOVIMIENTO.ESTADOMOVIMIENTO
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO AND 
                        MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND
                        MOVIMIENTO.ESTADOELIMINADO =0 AND MOVIMIENTO.ESTADOENVIO =2 AND
                        MOVIMIENTO.IDDEPENDENCIACREA  = ORGANI.IDORGANIGRAMA AND MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 1 "; 
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHARECEPCION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= $filtro_depen? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= "ORDER BY MOVIMIENTO.FECHARECEPCION DESC, TIPO.NOMBREDOCUMENTO, DOCUMENTO.NUMERODOCUMENTO DESC) GROUP BY tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO ";
            }else{
                $sql = "SELECT COUNT(IDMOVIMIENTO) AS cantidad, tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO FROM  (   SELECT MOVIMIENTO.FECHARECEPCION AS tiempo, TIPO.NOMBREDOCUMENTO AS nombre, DOCUMENTO.NUMERODOCUMENTO AS NUMERO ,
                        ORGANI.NOMBREAREA AS AREA,  DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA,  DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.IDMOVIMIENTO,
                        MOVIMIENTO.ESTADOMOVIMIENTO
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO AND 
                        MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND
                        MOVIMIENTO.ESTADOELIMINADO =0 AND MOVIMIENTO.ESTADOENVIO =2 AND
                        MOVIMIENTO.IDDEPENDENCIACREA  = ORGANI.IDORGANIGRAMA AND MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 0 AND ";
                $sql .= "MOVIMIENTO.IDPERSONAENVIA = ".$idper. " "; 
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHARECEPCION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= $filtro_depen? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= "ORDER BY MOVIMIENTO.FECHARECEPCION DESC, TIPO.NOMBREDOCUMENTO, DOCUMENTO.NUMERODOCUMENTO DESC ) GROUP BY tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO ";
            }
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        function Obtener_documentos_por_recibidos($idper, $filtro_doc = false, $filtro_depen = false, $filtro_fecha = false) {
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT COUNT(IDMOVIMIENTO) AS cantidad, tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO FROM  (SELECT MOVIMIENTO.FECHACREACION AS tiempo,  TIPO.NOMBREDOCUMENTO AS nombre, DOCUMENTO.NUMERODOCUMENTO AS NUMERO ,
                        ORGANI.NOMBREAREA AS AREA,  DOCUMENTO.ASUNTO,DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA,  DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.IDMOVIMIENTO,
                        MOVIMIENTO.ESTADOMOVIMIENTO
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO AND 
                        MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND
                        MOVIMIENTO.ESTADOELIMINADO =0 AND MOVIMIENTO.ESTADOENVIO =1 AND
                        MOVIMIENTO.IDDEPENDENCIACREA  = ORGANI.IDORGANIGRAMA AND MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 1 ";
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_depen? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= "ORDER BY MOVIMIENTO.FECHACREACION DESC, TIPO.NOMBREDOCUMENTO, DOCUMENTO.NUMERODOCUMENTO DESC) GROUP BY tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO ";
            }else{
                $sql = " SELECT COUNT(IDMOVIMIENTO) AS cantidad, tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO FROM  ( SELECT MOVIMIENTO.FECHACREACION AS tiempo,  TIPO.NOMBREDOCUMENTO AS nombre, DOCUMENTO.NUMERODOCUMENTO AS NUMERO ,
                        ORGANI.NOMBREAREA AS AREA,  DOCUMENTO.ASUNTO,DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA,  DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.IDMOVIMIENTO,
                        MOVIMIENTO.ESTADOMOVIMIENTO
                        FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO , PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO
                        WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO AND 
                        MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND
                        MOVIMIENTO.ESTADOELIMINADO =0 AND MOVIMIENTO.ESTADOENVIO =1 AND
                        MOVIMIENTO.IDDEPENDENCIACREA  = ORGANI.IDORGANIGRAMA AND MOVIMIENTO.IDDEPENDENCIAENVIA= ".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 0 AND ";
                $sql .= "MOVIMIENTO.IDPERSONAENVIA = $idper "; 
                $sql .= $filtro_fecha ? "AND MOVIMIENTO.FECHACREACION BETWEEN TO_DATE('$filtro_fecha[inicio]', 'DD/MM/YYYY') AND TO_DATE('$filtro_fecha[fin]', 'DD/MM/YYYY')" : "";
                $sql .= $filtro_depen? "AND MOVIMIENTO.IDDEPENDENCIACREA IN ($filtro_depen) " : "";
                $sql .= $filtro_doc ? "AND DOCUMENTO.IDTIPDOCUMENTO IN ($filtro_doc) " : "";
                $sql .= " ORDER BY MOVIMIENTO.FECHACREACION DESC, TIPO.NOMBREDOCUMENTO, DOCUMENTO.NUMERODOCUMENTO DESC ) GROUP BY tiempo, nombre, NUMERO, AREA, ASUNTO, OBSERVACIONES, ANIO, SIGLA_AREA, IDDOCUMENTO, IDMOVIMIENTO, SIGLAS_PERSONAL, ESTADOMOVIMIENTO ";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        function Obtener_documentos($idTipoDoc, $numero, $anio){
            $this->load->database();
            $sql = "SELECT DOCUMENTO.* , TIPO.NOMBREDOCUMENTO FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO,PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO  
            WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO   AND  DOCUMENTO.IDTIPDOCUMENTO =".$idTipoDoc." AND DOCUMENTO.ANIO =".$anio." AND DOCUMENTO.NUMERODOCUMENTO =".$numero;
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        function Obtener_documentos_persona($idTipoDoc, $trabajador, $anio){
            $this->load->database();
            $sql = "SELECT DOCUMENTO.*, TIPO.NOMBREDOCUMENTO FROM PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO,PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO  
            WHERE TIPO.IDTIPODOCUMENTO = DOCUMENTO.IDTIPDOCUMENTO   AND  DOCUMENTO.IDTIPDOCUMENTO =".$idTipoDoc." AND DOCUMENTO.ANIO =".$anio." AND DOCUMENTO.IDPERSONACREA = ".$trabajador." ORDER BY DOCUMENTO.IDDOCUMENTO DESC ";
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }


        function Ver_movimientos_por_documento($idDocumento){
            $this->load->database();
            $sql = "SELECT  TIPO.NOMBREDOCUMENTO, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.IDDOCUMENTO,  MOVIMIENTO.HORA_CREO, MOVIMIENTO.HORA_RECEPCIONA ,
            DOCUMENTO.ANIO, MOVIMIENTO.INDEXTER , MOVIMIENTO.FOLIOS, MOVIMIENTO.IDPERSONACREA, MOVIMIENTO.IDPERSONAENVIA, MOVIMIENTO.FECHACREACION, 
            MOVIMIENTO.INDCOPIA , MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.FECHARECEPCION , MOVIMIENTO.IDMOVIMIENTO  ,DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES,
            DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL,
            ( SELECT ORGA.NOMBREAREA FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGA WHERE ORGA.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA ) AS AREA_CREA, 
            ( SELECT ORGA.SIGLA_AREA FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGA WHERE ORGA.IDORGANIGRAMA = (SELECT USUARIO.WF_ORGANIGRAMA FROM PRDDBFCOMERCIAL.NUSERS USUARIO WHERE  USUARIO.NCODIGO= DOCUMENTO.IDPERSONACREA  )  ) AS AREA_GENERA,
            ( SELECT ORGA.NOMBREAREA FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGA WHERE ORGA.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIAENVIA ) AS AREA_ENVIA,
            (CASE WHEN ( TIENECARGO ='1' ) THEN 
            ('vacio') ELSE 
            (SELECT USUARIO.NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS USUARIO WHERE USUARIO.NCODIGO = MOVIMIENTO.IDPERSONACREA  ) END) AS PERSONA_ENVIA,
            (CASE WHEN ( MOVIMIENTO.INDPERSONAL ='0' ) THEN 
            ('vacio') ELSE 
            (SELECT USUARIO.NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS USUARIO WHERE USUARIO.NCODIGO = MOVIMIENTO.IDPERSONAENVIA  ) END) AS PERSONA_RECIBE
            FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO
            WHERE MOVIMIENTO.IDDOCUMENTO = DOCUMENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO= TIPO.IDTIPODOCUMENTO
            AND MOVIMIENTO.ESTADOELIMINADO =0   AND MOVIMIENTO.IDDOCUMENTO =".$idDocumento;
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        function getDatoMovimiento($id_mov){
            $this->load->database();
            $sql = "SELECT DOC.ASUNTO, DOC.OBSERVACIONES, DOC.CONTENIDO, MOVIMIENTO.FECHACREACION, MOVIMIENTO.HORA_CREO, MOVIMIENTO.HORA_RECEPCIONA, MOVIMIENTO.FECHARECEPCION,
            (SELECT ORGA.NOMBREAREA FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGA WHERE ORGA.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA ) AS AREA_CREA, 
            ( SELECT ORGA.NOMBREAREA FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGA WHERE ORGA.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIAENVIA ) AS AREA_ENVIA,
            (CASE WHEN ( (SELECT COUNT(ORGA.NOMBREAREA) AS CANTIDAD FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGA WHERE ORGA.IDENCARGADO = MOVIMIENTO.IDPERSONACREA) >0  ) THEN 
                       (SELECT USUARIO.NNOMBRE||'(ENCARGADO DEL AREA)' FROM PRDDBFCOMERCIAL.NUSERS USUARIO WHERE USUARIO.NCODIGO = MOVIMIENTO.IDPERSONACREA  ) ELSE 
                       (SELECT USUARIO.NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS USUARIO WHERE USUARIO.NCODIGO = MOVIMIENTO.IDPERSONACREA  ) END) AS PERSONA_ENVIA,
            (CASE WHEN ( (SELECT COUNT(ORGA.NOMBREAREA) AS CANTIDAD FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGA WHERE ORGA.IDENCARGADO = MOVIMIENTO.IDPERSONAENVIA) >0  ) THEN 
                      (SELECT USUARIO.NNOMBRE||'(ENCARGADO DEL AREA)' FROM PRDDBFCOMERCIAL.NUSERS USUARIO WHERE USUARIO.NCODIGO = MOVIMIENTO.IDPERSONAENVIA  ) ELSE 
                      (SELECT USUARIO.NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS USUARIO WHERE USUARIO.NCODIGO = MOVIMIENTO.IDPERSONAENVIA  ) END) AS PERSONA_RECIBE
          FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOC WHERE MOVIMIENTO.IDDOCUMENTO = DOC.IDDOCUMENTO AND MOVIMIENTO.IDMOVIMIENTO =".$id_mov;
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        function getDocXrecibir($idper, $idDependencia){
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ANIO,  MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( CASE WHEN (DOCUMENTO.RUTA_ARCHIVO IS NOT NULL) THEN ('".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO)  ELSE ('vacio') END ) AS RUTA_ARCHIVO, DOCUMENTO.SIGLAAREAGEN AS  SIGLA_AREA ,  MOVIMIENTO.IDMOVIMIENTO, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIDERIVADO, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                        AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 1 AND ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA  AND  MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA=1  ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }else{
                $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.SIGLAPERSONAGEN   AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( CASE WHEN (DOCUMENTO.RUTA_ARCHIVO IS NOT NULL) THEN ('".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO)  ELSE ('vacio') END ) AS RUTA_ARCHIVO, DOCUMENTO.SIGLAAREAGEN AS  SIGLA_AREA  ,  MOVIMIENTO.IDMOVIMIENTO, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIDERIVADO, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                        AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 1 AND ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND  MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND  MOVIMIENTO.IDPERSONAENVIA =".$idper." AND  MOVIMIENTO.INDGERENCIA=0 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        /* PARA LOS FILTROS */

        function getDocXrecibir_filtro($idper, $idDependencia, $numero, $anio){
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.TIPO_EXTERNO, (CASE WHEN ( ORGANI.IDENCARGADO = DOCUMENTO.IDPERSONACREA AND DOCUMENTO.INDGERENCIA =1 ) THEN ('vacio') ELSE ( SELECT SIGLA_WORKFLOW FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = DOCUMENTO.IDPERSONACREA) END ) AS SIGLAS_PERSONAL ,
                    DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( CASE WHEN (DOCUMENTO.RUTA_ARCHIVO IS NOT NULL) THEN ('".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO)  ELSE ('vacio') END ) AS RUTA_ARCHIVO, ORGANI.SIGLA_AREA ,  MOVIMIENTO.IDMOVIMIENTO, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                    MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIDERIVADO, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                    FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                    WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                    AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 1 AND DOCUMENTO.NUMERODOCUMENTO = ".$numero." AND DOCUMENTO.ANIO = ".$anio." AND  ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']."  AND  MOVIMIENTO.INDGERENCIA=1 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }else{
                $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.TIPO_EXTERNO, (CASE WHEN ( ORGANI.IDENCARGADO = DOCUMENTO.IDPERSONACREA ) THEN ('vacio') ELSE ( SELECT SIGLA_WORKFLOW FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = DOCUMENTO.IDPERSONACREA) END ) AS SIGLAS_PERSONAL ,
                    DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( CASE WHEN (DOCUMENTO.RUTA_ARCHIVO IS NOT NULL) THEN ('".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO)  ELSE ('vacio') END ) AS RUTA_ARCHIVO, ORGANI.SIGLA_AREA ,  MOVIMIENTO.IDMOVIMIENTO, DOCUMENTO.ASUNTO, DOCUMENTO.OBSERVACIONES, TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                    MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIDERIVADO, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                    FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                    WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                    AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 1 AND DOCUMENTO.NUMERODOCUMENTO = ".$numero." AND DOCUMENTO.ANIO = ".$anio." AND  ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND  MOVIMIENTO.IDPERSONAENVIA =".$idper."   AND  MOVIMIENTO.INDGERENCIA=0 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }


        function getDocXrecibidos($idper, $idDependencia, $archivado ){
            
            $cadena = "";
            if($archivado){
                $cadena = " AND MOVIMIENTO.ESTADOMOVIMIENTO = '2' ";
            }else{
                $cadena = " AND MOVIMIENTO.ESTADOMOVIMIENTO != '2' ";
            }

            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT DOCUMENTO.IDDOCUMENTO , DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ASUNTO, DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( '".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO) AS RUTA_ARCHIVO, DOCUMENTO.SIGLAAREAGEN AS  SIGLA_AREA , DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.IDPERSONACREA, MOVIMIENTO.IDPERSONAENVIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIENTO, MOVIMIENTO.IDMOVIMIDERIVADO,DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                        AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND MOVIMIENTO.INDREF = 0  ".$cadena."
                        AND MOVIMIENTO.INDDERIVA='0'  AND   ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND   MOVIMIENTO.INDGERENCIA=1 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }else{
                $sql = "SELECT DOCUMENTO.IDDOCUMENTO , DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ASUNTO, DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( '".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO) AS RUTA_ARCHIVO, DOCUMENTO.SIGLAAREAGEN AS  SIGLA_AREA , DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.IDPERSONACREA, MOVIMIENTO.IDPERSONAENVIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIENTO, MOVIMIENTO.IDMOVIMIDERIVADO, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                        AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND MOVIMIENTO.INDREF = 0  ".$cadena."
                        AND MOVIMIENTO.INDDERIVA='0'  AND   ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.IDPERSONAENVIA =".$idper." AND  MOVIMIENTO.INDGERENCIA=0 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }
        function getDocXrecibidos_Aarchi($idper, $idDependencia){

            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT DOCUMENTO.IDDOCUMENTO , DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ASUNTO, DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( '".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO) AS RUTA_ARCHIVO, DOCUMENTO.SIGLAAREAGEN AS  SIGLA_AREA , DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.IDPERSONACREA, MOVIMIENTO.IDPERSONAENVIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIENTO, MOVIMIENTO.IDMOVIMIDERIVADO,DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                        AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND MOVIMIENTO.INDREF = 0 AND MOVIMIENTO.ESTADOMOVIMIENTO = '2'
                        AND MOVIMIENTO.INDDERIVA='0'  AND   ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND   MOVIMIENTO.INDGERENCIA=1 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }else{
                $sql = "SELECT DOCUMENTO.IDDOCUMENTO , DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ASUNTO, DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( '".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO) AS RUTA_ARCHIVO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA , DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.IDPERSONACREA, MOVIMIENTO.IDPERSONAENVIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIENTO, MOVIMIENTO.IDMOVIMIDERIVADO, DOCUMENTO.IDDOCUMENTO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                        AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND MOVIMIENTO.INDREF = 0  AND MOVIMIENTO.ESTADOMOVIMIENTO = '2'
                        AND MOVIMIENTO.INDDERIVA='0'  AND   ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.IDPERSONAENVIA =".$idper." AND  MOVIMIENTO.INDGERENCIA=0 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }

        

        /*  PARA LOS FILTROS */

        function getDocXrecibidos_filtro($idper, $idDependencia, $numero, $anio, $archivado){

            $cadena = "";
            if($archivado){
                $cadena = " AND MOVIMIENTO.ESTADOMOVIMIENTO = '2' ";
            }else{
                $cadena = " AND MOVIMIENTO.ESTADOMOVIMIENTO != '2' ";
            }
            
            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT DOCUMENTO.IDDOCUMENTO , DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.NUMERODOCUMENTO,(CASE WHEN ( ORGANI.IDENCARGADO = DOCUMENTO.IDPERSONACREA AND DOCUMENTO.INDGERENCIA =1 ) THEN ('vacio') ELSE ( SELECT SIGLA_WORKFLOW FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = DOCUMENTO.IDPERSONACREA) END ) AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ASUNTO, DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF, ( '".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO) AS RUTA_ARCHIVO, ORGANI.SIGLA_AREA , DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.IDPERSONACREA, MOVIMIENTO.IDPERSONAENVIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIENTO, MOVIMIENTO.IDMOVIMIDERIVADO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO ".$cadena." AND DOCUMENTO.NUMERODOCUMENTO = ".$numero." AND DOCUMENTO.ANIO = ".$anio." AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND MOVIMIENTO.INDREF = 0  
                        AND MOVIMIENTO.INDDERIVA='0'  AND   ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND  MOVIMIENTO.INDGERENCIA=1 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }else{
                $sql = "SELECT DOCUMENTO.IDDOCUMENTO , DOCUMENTO.TIPO_EXTERNO, DOCUMENTO.NUMERODOCUMENTO,(CASE WHEN ( ORGANI.IDENCARGADO = DOCUMENTO.IDPERSONACREA ) THEN ('vacio') ELSE ( SELECT SIGLA_WORKFLOW FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = DOCUMENTO.IDPERSONACREA) END ) AS SIGLAS_PERSONAL ,
                        DOCUMENTO.ASUNTO, DOCUMENTO.ANIO, MOVIMIENTO.FECHAMAXATENCION, to_char(MOVIMIENTO.FECHAMAXATENCION, 'YYYY-MM-DD') AS FECHAMAXATENCIONF, to_char(MOVIMIENTO.FECHACREACION, 'YYYY-MM-DD') AS FECHACREACIONF,  ( '".MAIN_URL."' ||DOCUMENTO.RUTA_ARCHIVO) AS RUTA_ARCHIVO, ORGANI.SIGLA_AREA , DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, 
                        MOVIMIENTO.INDCOPIA, MOVIMIENTO.IDPERSONACREA, MOVIMIENTO.IDPERSONAENVIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.IDMOVIMIENTO, MOVIMIENTO.IDMOVIMIDERIVADO, MOVIMIENTO.MOTIVODERIVA
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO ".$cadena."  AND DOCUMENTO.NUMERODOCUMENTO = ".$numero." AND DOCUMENTO.ANIO = ".$anio." AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND MOVIMIENTO.INDREF = 0  
                        AND MOVIMIENTO.INDDERIVA='0'  AND   ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.IDPERSONAENVIA =".$idper." AND  MOVIMIENTO.INDGERENCIA=0 ORDER BY MOVIMIENTO.FECHACREACION DESC, DOCUMENTO.NUMERODOCUMENTO DESC";
            }
            
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            } else {
                return array();
            }
        }


        function verifico_cargo(){
            $this->load->database();
            $sql = "SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDENCARGADO = ".$_SESSION['user_id'];
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return true;
            } else {
                return false;
            }
        }

        function verifico_Subida_archivo(){
            $this->load->database();
            $sql = "SELECT VALPAR FROM PRDDBFCOMERCIAL.MAEPAR WHERE CODPAR='OBLISUBARCHI' ";
            $query = $this->oracle->query($sql)->result();
            if($query[0]->VALPAR== '1'){
                return true;
            }else{
                return false;
            }
        }

        function verifico_Max_Dias_Externo(){
            $this->load->database();
            $sql = "SELECT VALPAR FROM PRDDBFCOMERCIAL.MAEPAR WHERE CODPAR='MAXDIASEXTERNOS' ";
            $query = $this->oracle->query($sql)->result();
            return $query[0]->VALPAR;
        }

        function DevolverDocDeriva($idMov){
            $respuesta = "";
            $this->oracle->trans_begin();
            $destina = $this->oracle->query("SELECT ESTADOELIMINADO,IDMOVIMIDERIVADO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC WHERE IDMOVIMIENTO =".$idMov)->row();
            $ParamDeriva  = array(
                'ESTADOELIMINADO'     =>1
            );
            /* ACTUALIZO EL ESTADO DE ELIMINADO DEL DOCUMENTO */
            $this->oracle->where('IDMOVIMIENTO', $idMov);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamDeriva);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
                return false;
            } 
            /* ACTUALIZO LAS REFERENCIAS DEL DOCUMENTO */
            $ParamReferencia  = array(
                'ESTADOREFERENCIA'  => 0
            );
            $this->oracle->where('IDREFERENCIA', $idMov);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
                return false;
            }

            $ParamDerivado  = array(
                'INDDERIVA'     =>'0',
                'ESTADOMOVIMIENTO'  => 0
            );
            $this->oracle->where('IDMOVIMIENTO', $destina->IDMOVIMIDERIVADO);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamDerivado);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else{
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }

        function RecibirDocumentoUsuario($idMov, $ParamMov){
            $respuesta = "";
            $this->oracle->trans_begin();
            $this->oracle->where('IDMOVIMIENTO', $idMov);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMov);
            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }

        function tranRecibirDocumeno($idMov, $ParamMov){
            $respuesta = "";
            $this->oracle->trans_begin();
            $destina = $this->oracle->query("SELECT ESTADOELIMINADO,IDMOVIMIDERIVADO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC WHERE IDMOVIMIENTO =".$idMov)->row();
            $estado   = $destina->ESTADOELIMINADO;
            if ($estado == '0') {
                if($destina->IDMOVIMIDERIVADO == 0){
                    $this->oracle->where('IDMOVIMIENTO', $idMov);
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMov);
                }else{
                    $ParamDeriva  = array(
                        'ESTADOELIMINADO'     =>1
                    );
                    $this->oracle->where('IDMOVIMIENTO', $idMov);
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamDeriva);
                    $ParamDerivado  = array(
                        'INDDERIVA'     =>'0'
                    );
                    $this->oracle->where('IDMOVIMIENTO', $destina->IDMOVIMIDERIVADO);
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamDerivado);

                }
                
            } else {
                $respuesta = array("respuesta" => 'del');
            }

            if ($this->oracle->trans_status() === FALSE) {
                $this->oracle->trans_rollback();
            } else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }


        public function getListaPersonalArea($persona_Envia){
            $this->load->database();
            $sql = "SELECT NCODIGO, NNOMBRE, NDNI,WF_ORGANIGRAMA, CASE WHEN ( NENDS > SYSDATE ) THEN 0 ELSE 1 END AS VENCIDO   
                    FROM  PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO != ".$_SESSION['user_id']." AND NCODIGO != ".$persona_Envia."  AND  WF_ORGANIGRAMA =".$_SESSION['DEPENDENCIA_ORIGEN'];
            $query = $this->oracle->query($sql)->result();
            if (count($query) > 0) {
                return $query;
            }else{
                return array();
            }
        }


        function getDocumentosRefs($idper, $numero,$iddepen) {

            $this->load->database();
            if($_SESSION['IND_GERENCIA'] == 1){
                $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.ASUNTO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA, DOCUMENTO.SIGLAPERSONAGEN  AS SIGLAS_PERSONAL,
                        DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO ,MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, 
                        ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO
                        FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                        WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                        AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA 
                        AND DOCUMENTO.NUMERODOCUMENTO =".$numero." AND MOVIMIENTO.IDDEPENDENCIAENVIA =".$_SESSION['DEPENDENCIA_ORIGEN']." AND MOVIMIENTO.INDGERENCIA = 1 AND MOVIMIENTO.INDREF = 0 AND MOVIMIENTO.INDDERIVA = 0";
            }else{
                $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.ASUNTO, DOCUMENTO.SIGLAAREAGEN  AS SIGLA_AREA, DOCUMENTO.SIGLAPERSONAGEN  AS SIGLAS_PERSONAL,
                     DOCUMENTO.OBSERVACIONES, DOCUMENTO.ANIO ,MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, 
                    ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO
                    FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI
                    WHERE DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO AND DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO
                    AND MOVIMIENTO.ESTADOELIMINADO =0 AND  MOVIMIENTO.ESTADOENVIO= 2 AND ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA 
                    AND DOCUMENTO.NUMERODOCUMENTO =".$numero." AND MOVIMIENTO.IDPERSONAENVIA =".$idper." AND MOVIMIENTO.INDGERENCIA = 0 AND MOVIMIENTO.INDREF = 0";
            }
            
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }


        function derivarDocumento($movimiento_Deriva, $observacionDeriva, $personalDerivar, $folio_adicional, $fechaMax, $tipo_envio){
            $this->load->database();
            $this->oracle->trans_begin();
            $sql = "SELECT * FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC WHERE IDMOVIMIENTO=".$movimiento_Deriva->IDMOVIMIENTO;
            $outValue = $this->oracle->query($sql)->result();
            if(count($outValue)>0){
                
                if($tipo_envio != 'P'){
                    $destina = $this->oracle->query("SELECT IDENCARGADO FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA =".$personalDerivar)->row();
                    $desti = $destina->IDENCARGADO;
                }

                $ParamMovimiento  = array(
                    'IDDOCUMENTO'         =>$outValue[0]->IDDOCUMENTO,
                    'IDPERSONACREA'       => $_SESSION['user_id'], //$outValue[0]->IDPERSONAENVIA,
                    'IDDEPENDENCIACREA'   =>$outValue[0]->IDDEPENDENCIAENVIA, 
                    'OFICINADOC'          =>$outValue[0]->OFICINADOC,
                    'IDTIPDOCUMENTO'      =>$outValue[0]->IDTIPDOCUMENTO,
                    'IDPERSONAENVIA'      =>(($tipo_envio != 'P') ? $desti : $personalDerivar ) , 
                    'IDDEPENDENCIAENVIA'  => (($tipo_envio != 'P') ? $personalDerivar : $outValue[0]->IDDEPENDENCIAENVIA ) ,
                    'FECHACREACION'       =>date("d/m/Y"),
                    'HORA_CREO'           =>date("H:i:s"),
                    'FECHAMAXATENCION'    =>$fechaMax,
                    'FECHARECEPCION'      =>'',
                    'FOLIOS'              =>(((int)$folio_adicional != 0) ? ((int)($outValue[0]->FOLIOS)+ (int)$folio_adicional) : ((int)($outValue[0]->FOLIOS))),
                    'INDCOPIA'            =>$outValue[0]->INDCOPIA,
                    'ESTADOENVIO'         =>1,
                    'ESTADOELIMINADO'     =>0,
                    'INDGERENCIA'         =>(($tipo_envio != 'P') ? 1 : 0 ),
                    'INDPERSONAL'         =>(($tipo_envio != 'P') ? 0 : 1 ),
                    'INDREF'              =>0,
                    'INDDERIVA'           =>'0',
                    'IDMOVIMIDERIVADO'    =>$movimiento_Deriva->IDMOVIMIENTO,
                    'INDEXTER'            => $outValue[0]->INDEXTER,
                    'MOTIVODERIVA'        => $observacionDeriva,
                    'ESTADOMOVIMIENTO'    => 0,
                    'TIENECARGO'          => $_SESSION['IND_GERENCIA']
                );
                $this->oracle->insert('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMovimiento);
                
                if ($this->oracle->trans_status() === FALSE) {
                    $this->oracle->trans_rollback();
                    return false;
                } else {
                    $registro = $this->oracle->query("SELECT IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC ORDER BY IDMOVIMIENTO DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY")->row();
                    $idMovimiento = $registro->IDMOVIMIENTO;  // Movimiento recien ingresado de la referencia 

                    // CONSULTAR SI ES QUE TIENE REFERENCIAS EL MOVIMIENTO 
                    $sql = "SELECT * FROM PRDDBFCOMERCIAL.WF_REFERENCIAS WHERE  IDMOVIMIENTOHIJO = ".$movimiento_Deriva->IDMOVIMIENTO;
                    $resultRef = $this->oracle->query($sql)->result();
                    if( count($resultRef) > 0 ){

                        // INGRESANDO LA REFERENCIA INCIAL
                        for($i=0; $i< count($resultRef); $i++){
                            $ParamReferencia  = array(
                                'IDMOVIMIENTOPADRE' => $resultRef[$i]->IDMOVIMIENTOPADRE,
                                'IDMOVIMIENTOHIJO'  => $idMovimiento,
                                'ESTADOREFERENCIA'  => 0
                            );
                            $this->oracle->insert('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
                            if ($this->oracle->trans_status() === FALSE){
                                $this->oracle->trans_rollback();
                                return false;
                            }
                        }
                        
                    }
                    $ParamMovimiento  = array(
                        'INDDERIVA'           =>'1',
                        'ESTADOMOVIMIENTO'    => 1
                    );
                    $this->oracle->where('IDMOVIMIENTO', $movimiento_Deriva->IDMOVIMIENTO);
                    $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamMovimiento);
                    if ($this->oracle->trans_status() === FALSE) {
                        $this->oracle->trans_rollback();
                        return false;
                    } else {
                        $this->oracle->trans_commit();
                        return true;
                    }
                }
            }else{
                return false;
            }
            
        }


        function getDocumentosRefsedit($idper, $numero, $iddepen, $tipo_Doc){
            $this->load->database();
            $registro = $this->oracle->query("SELECT IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC WHERE IDDOCUMENTO = ".$numero.
                                            " AND IDTIPDOCUMENTO= ".$tipo_Doc." AND IDDEPENDENCIACREA =".$iddepen)->row();
            $idMov = $registro->IDMOVIMIENTO;
            
            $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.ASUNTO, DOCUMENTO.ANIO, DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL , DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, 
            ORGANI.NOMBREAREA, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA, MOVIMIENTO.FECHACREACION, MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO, MOVIMIENTO.ESTADOMOVIMIENTO
            FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_REFERENCIAS REFERENCIA
            WHERE
            REFERENCIA.IDMOVIMIENTOHIJO = ".$idMov ."              AND
            REFERENCIA.ESTADOREFERENCIA = 0                        AND
            REFERENCIA.IDMOVIMIENTOPADRE = MOVIMIENTO.IDMOVIMIENTO AND 
            DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO         AND
            DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO        AND 
            ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        function getReferenciasDocRecibir($idMov){

            $sql = "SELECT DOCUMENTO.NUMERODOCUMENTO, DOCUMENTO.IDDOCUMENTO,  DOCUMENTO.ASUNTO, DOCUMENTO.RUTA_ARCHIVO, DOCUMENTO.ANIO, DOCUMENTO.SIGLAPERSONAGEN AS SIGLAS_PERSONAL ,
            DOCUMENTO.OBSERVACIONES, MOVIMIENTO.IDMOVIMIENTO, DOCUMENTO.SIGLAAREAGEN AS SIGLA_AREA,  TIPO.NOMBREDOCUMENTO, MOVIMIENTO.FOLIOS, MOVIMIENTO.IDDEPENDENCIACREA, 
            ORGANI.NOMBREAREA, MOVIMIENTO.FECHACREACION, MOVIMIENTO.INDCOPIA, MOVIMIENTO.ESTADOENVIO
            FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC MOVIMIENTO, PRDDBFCOMERCIAL.WF_DOCUMENTO DOCUMENTO, PRDDBFCOMERCIAL.WF_TIPDOCUMENTO TIPO, PRDDBFCOMERCIAL.WF_ORGANIGRAMA ORGANI, PRDDBFCOMERCIAL.WF_REFERENCIAS REFERENCIA
            WHERE
            REFERENCIA.IDMOVIMIENTOHIJO = ".$idMov ."              AND
            REFERENCIA.ESTADOREFERENCIA = 0                        AND
            REFERENCIA.IDMOVIMIENTOPADRE = MOVIMIENTO.IDMOVIMIENTO AND 
            DOCUMENTO.IDDOCUMENTO = MOVIMIENTO.IDDOCUMENTO         AND
            DOCUMENTO.IDTIPDOCUMENTO = TIPO.IDTIPODOCUMENTO        AND 
            ORGANI.IDORGANIGRAMA = MOVIMIENTO.IDDEPENDENCIACREA";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }


        function eliminaRefCorrecion($idper, $iddepen, $cod_mov, $cod_doc){
            $this->load->database();
            $this->oracle->trans_begin();
            // CAMBIO ESTADO DE LA REFERENCIA
            $ParamEstado  = array(
                'INDREF'  => 0 
            );
            $this->oracle->where('IDMOVIMIENTO', $cod_mov);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamEstado);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }
            // INSERTO A LA TABLA DE REFERENCIAS 
            $ParamReferencia  = array(
                'ESTADOREFERENCIA'  => 1
            );
            $this->oracle->where('IDMOVIMIENTOPADRE', $cod_mov);
            $this->oracle->where('ESTADOREFERENCIA', 0);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }
            else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;
        }

        function agregarRefCorrecion($idper, $iddepen, $cod_mov, $cod_doc){
            $this->load->database();
            $this->oracle->trans_begin();
            // CAMBIO ESTADO DE LA REFERENCIA
            $ParamEstado  = array(
                'INDREF'  => 1 
            );
            $this->oracle->where('IDMOVIMIENTO', $cod_mov);
            $this->oracle->update('PRDDBFCOMERCIAL.WF_MOVIMIENTODOC', $ParamEstado);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }
            // PARA INSERTAR LAS REFERENCIAS A TODOS LOS MOVIMIENTOS 
            $sql = "SELECT IDMOVIMIENTO FROM PRDDBFCOMERCIAL.WF_MOVIMIENTODOC WHERE ESTADOELIMINADO=0  AND  IDDOCUMENTO =".$cod_doc;
            $movimientos = $this->oracle->query($sql)->result();
            if(count($movimientos)){
                for ($i = 0; $i < count($movimientos); $i++) {
                    // INSERTO A LA TABLA DE REFERENCIAS 
                    $ParamReferencia  = array(
                        'IDMOVIMIENTOPADRE' => (int)$cod_mov,
                        'IDMOVIMIENTOHIJO'  => $movimientos[$i]->IDMOVIMIENTO,
                        'ESTADOREFERENCIA'  => 0
                    );
                    $this->oracle->insert('PRDDBFCOMERCIAL.WF_REFERENCIAS', $ParamReferencia);
                    if ($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }
                }
            }
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }
            else {
                $this->oracle->trans_commit();
                $respuesta = array("respuesta" => 'ok');
            }
            return $respuesta;  
        }
    

    }