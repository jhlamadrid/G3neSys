<?php 

class PersonaEmpresa_model extends CI_MODEL {

	function __construct() {
        parent::__construct();
    }

    public function get_persona($id_persona, $tipo_doc){
    	$db_prueba = $this->load->database('oracle', TRUE);
    	$query = $db_prueba->query("SELECT * 
    							    FROM PRDDBFCOMERCIAL.DOCIDENT
    							    WHERE NRODOC = ? AND TIPDOC = ?", 
    							    array($id_persona, $tipo_doc));
    	return $query->row_array();
    }

    public function get_empresa($id_empresa){
    	$db_prueba = $this->load->database('oracle', TRUE); 
    	$query = $db_prueba->query("SELECT * 
    							    FROM PRDDBFCOMERCIAL.PSUNAT
    							    WHERE RUC = ?", 
    							    array($id_empresa));
    	return $query->row_array();
    }

    public function get_documento($tipo_abr){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * 
                                    FROM PRDDBFCOMERCIAL.TIPDOC
                                    WHERE TIPDOCDESCABR = ?", 
                                    array($tipo_abr));
        return $query->row_array();
    }

    public function get_documentoById($tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * 
                                    FROM PRDDBFCOMERCIAL.TIPDOC
                                    WHERE TIPDOCCOD = ?", 
                                    array($tipo));
        return $query->row_array();
    }    
     public function insert_persona($nrdoc,$tipdoc,$ap_paterno,$ap_materno,$nombre,$zona,$zona1,$via,$via1,$telf){
        //var_dump($veri_usuario);
        $db_prueba = $this->load->database('oracle', TRUE); 
        $db_prueba->trans_begin();
        $valido = $db_prueba->query("INSERT INTO  PRDDBFCOMERCIAL.DOCIDENT
                                        (NRODOC, TIPDOC ,APEPAT ,
                                         APEMAT ,NOMBRE, CODIGO_DE_ZONA,
                                         TIPO_DE_ZONA, TIPO_DE_VIA, NOMBRE_DE_VIA,
                                         TELCEL )
                                    VALUES 
                                        (?, ?, ?,
                                         ?, ?, ?,
                                         ?, ?, ?,
                                         ?
                                        )", 
                                    array($nrdoc,$tipdoc,$ap_paterno,
                                          $ap_materno,$nombre,$zona,
                                          $zona1,$via,$via1,$telf)); 
        
        if(!$valido){ 
            $db_prueba->trans_rollback(); 
        } else{ 
            //$db_prueba->trans_rollback();
            $db_prueba->trans_commit(); 
        }
        return $valido;
    }

    public function set_persona($tipo_doc, $dni, $apepat, $apemat, $nombre, $email, $email2, $celular, $celular2, $telefono, $telefon2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona){
        $db_prueba = $this->load->database('oracle', TRUE); 
        $db_prueba->trans_begin();
        $valido = $db_prueba->query("INSERT INTO  PRDDBFCOMERCIAL.DOCIDENT
                                        (   TIPDOC, NRODOC, APEPAT, APEMAT, 
                                            NOMBRE, TIPO_DE_VIA, NOMBRE_DE_VIA, CODIGO_DE_ZONA, 
                                            TIPO_DE_ZONA, NUMERO, INTERIOR, LOTE, 
                                            DEPARTAMENTO, MANZANA, KILOMETRO, NUSRCOD, 
                                            EMAIL, EMAIL2, TELCEL, TELCEL2, 
                                            TELFIJ, TELFIJ2)
                                    VALUES 
                                        (?, ?, ?, ?,
                                         ?, ?, ?, ?,
                                         ?, ?, ?, ?,
                                         ?, ?, ?, ?,
                                         ?, ?, ?, ?,
                                         ?, ?)", 
                                    array($tipo_doc, $dni, $apepat, $apemat, 
                                          $nombre, $tvia, $nmvia, $czona, 
                                          $nmzona, $nro, $lt,  $inte,
                                          $dep, $mnz, $km, $_SESSION['user_id'], 
                                          $email, $email2, $celular, $celular2, 
                                          $telefono, $telefon2 )); 
        
        if(!$valido){ 
            $db_prueba->trans_rollback(); 
        } else{ 
            //$db_prueba->trans_rollback();
            $db_prueba->trans_commit(); 
        }
        return $valido;
    }

    public function set_empresa($ruc, $rs, $email, $email2, $celular, $celular2, $telefono, $telefon2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona){
        $db_prueba = $this->load->database('oracle', TRUE); 
        $db_prueba->trans_begin();
        $valido = $db_prueba->query("INSERT INTO  PRDDBFCOMERCIAL.PSUNAT
                                        (RUC, NOMBRE_O_RAZON_SOCIAL, TIPO_DE_VIA, 
                                         NOMBRE_DE_VIA, KILOMETRO, MANZANA, 
                                         LOTE, NUMERO, DEPARTAMENTO, 
                                         INTERIOR, CODIGO_DE_ZONA, TIPO_DE_ZONA, 
                                         NUSRCOD, EMAIL, EMAIL2, 
                                         TELCEL, TELCEL2, TELFIJ, 
                                         TELFIJ2)
                                    VALUES 
                                        (?, ?, ?, 
                                         ?, ?, ?, 
                                         ?, ?, ?, 
                                         ?, ?, ?,
                                         ?, ?, ?,
                                         ?, ?, ?,
                                         ?)", 
                                    array(  $ruc, $rs, $tvia, 
                                            $nmvia, $km, $mnz,  
                                            $lt, $nro, $dep, 
                                            $inte, $czona, $nmzona, 
                                            $_SESSION['user_id'], $email, $email2, 
                                            $celular, $celular2, $telefono, 
                                            $telefon2,));
        if(!$valido){ $db_prueba->trans_rollback(); }
        else{ $db_prueba->trans_commit(); }
        return $valido;
    }

    public function update_persona($tipo_doc, $dni, $apepat, $apemat, $nombre, $email, $email2, $celular, $celular2, $telefono, $telefon2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona){
        //NRODOC, TIPDOC, 
        $db_prueba = $this->load->database('oracle', TRUE);
        $db_prueba->trans_begin();
        $query = $db_prueba->query("UPDATE PRDDBFCOMERCIAL.DOCIDENT
                                    SET APEPAT = ?, APEMAT = ?, NOMBRE = ?, 
                                        TIPO_DE_VIA = ?, NOMBRE_DE_VIA = ?, CODIGO_DE_ZONA = ?, 
                                        TIPO_DE_ZONA = ?, NUMERO = ? , INTERIOR = ?, 
                                        LOTE = ?, DEPARTAMENTO = ?, MANZANA = ?, 
                                        KILOMETRO = ?, EMAIL = ?, EMAIL2 = ?, 
                                        TELCEL = ?, TELCEL2 = ?, TELFIJ = ?, 
                                        TELFIJ2 = ?
                                    WHERE NRODOC = ? AND TIPDOC = ?", 
                                    array(  $apepat, $apemat, $nombre,
                                            $tvia, $nmvia, $czona, 
                                            $nmzona, $nro, $inte,
                                            $lt, $dep, $mnz,
                                            $km, $email, $email2, 
                                            $celular, $celular2, $telefono, 
                                            $telefon2,
                                            $dni, $tipo_doc));
        if(!$query){
            $db_prueba->trans_rollback();
            return false;
        }else{
            $db_prueba->trans_commit();
            //var_dump($query);
            return true;
        }
    }

    public function update_empresa($ruc, $rs, $email, $email2, $celular, $celular2, $telefono, $telefon2, $tvia, $nmvia, $km, $mnz, $lt, $nro, $dep, $inte, $czona, $nmzona){
        $db_prueba = $this->load->database('oracle', TRUE);
        $db_prueba->trans_begin();
        $query = $db_prueba->query("UPDATE PRDDBFCOMERCIAL.PSUNAT
                                    SET NOMBRE_O_RAZON_SOCIAL = ?, 
                                        TIPO_DE_VIA = ?, NOMBRE_DE_VIA = ?, CODIGO_DE_ZONA = ?, 
                                        TIPO_DE_ZONA = ?, NUMERO = ? , INTERIOR = ?, 
                                        LOTE = ?, DEPARTAMENTO = ?, MANZANA = ?, 
                                        KILOMETRO = ?, EMAIL = ?, EMAIL2 = ?, 
                                        TELCEL = ?, TELCEL2 = ?, TELFIJ = ?, 
                                        TELFIJ2 = ?
                                    WHERE RUC = ?", 
                                    array(  $rs,
                                            $tvia, $nmvia, $czona, 
                                            $nmzona, $nro, $inte,
                                            $lt, $dep, $mnz,
                                            $km, $email, $email2, 
                                            $celular, $celular2, $telefono, 
                                            $telefon2,
                                            $ruc));
        if(!$query){
            $db_prueba->trans_rollback();
            return false;
        }else{
            $db_prueba->trans_commit();
            //var_dump($query);
            return true;
        }
    }

}