<?php

class afiliacion_model extends CI_MODEL {

    var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }
    
    public function get_suministro($suministro){
        $db_prueba = $this->load->database('oracle', TRUE);  
        $query = $db_prueba->query("select CLICODFAC, CLINOMBRE , CLIELECT,CLIRUC ,CLICOBTEL from PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC=".$suministro);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    public function set_solafdes($nombre,$documento,$suministro,$afilia,$telefono,
                                 $celular,$correo1,$correo2,$direccion1,$twitter,$facebook,
                                 $whatsapp,$dir_arch){
        if($afilia=='afiliacion'){
            $estado="A";
        }
        else{
            $estado="D";
        }

        
         $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SOLAFDES
                                            ( SOLCOD, CLICODFAC,CLINOM,CLIDOCIDENT, 
                                              DOCADJ,CLITELEF, CLICEL,
                                              CLIEMAIL1, CLIEMAIL2,CLIDIRWEB,CLITWITTER, 
                                              CLIFACEBOOK,CLIWHATSAPP,ESTADO,FECHSOL,DIRARCH )
                                            VALUES ( '"."123456789"."' ,'".$suministro."' ,'".$nombre."' , '".$documento."','"."0"."' , '".$telefono."' , '".$celular."' , '".$correo1."' , '".$correo2."' , '"
                                                     .$direccion1."' , '"
                                                     .$twitter."', '"
                                                     .$facebook." ', '"
                                                     .$whatsapp."' , '"."A"."' , sysdate,'".$dir_arch."')");
                                           
                                                    
         if(!$query){
                $this->oracle->trans_rollback();
                return false;
            }
    }
    
    public function get_afilia_desafilia($suministro){
         $db_prueba = $this->load->database('oracle', TRUE);  
        $query = $db_prueba->query("select * from PRDDBFCOMERCIAL.SOLAFDES WHERE CLICODFAC=".$suministro);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    public function set_modifica_estado($suministro,$direccion){
         $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SOLAFDES
                                SET DOCADJ = 1, DIRARCH='".$direccion."'
                                WHERE CLICODFAC =".$suministro);
        return true;
    }

    public function set_modifica_afiliacion($nombre,$documento,$suministro,$tipo_afiliacion,$telefono,$celular,$correo1,$correo2,$direccion1,$twitter,$facebook,$whatsapp,$file_to_save){
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SOLAFDES
                                SET DOCADJ = 0, DIRARCH='".$file_to_save."',CLINOM='".$nombre."',CLICODFAC='".$suministro."',CLIDOCIDENT='".$documento."', ESTADO='".$tipo_afiliacion."', FECHSOL=sysdate, CLITELEF='".$telefono."',CLICEL='".$celular."', CLIEMAIL1='".$correo1."', CLIEMAIL2='".$correo2."', CLIDIRWEB='".$direccion1."',CLITWITTER='".$twitter."',CLIFACEBOOK='".$facebook."',CLIWHATSAPP='".$whatsapp."'
                                WHERE CLICODFAC =".$suministro);
        return true;

    }
    
    
    
    
 }
?>