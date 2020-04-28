<?php 

class Catalogo_model extends CI_MODEL {

	var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_deta_catalogo_by_catalogo($id_catalogo){ 
        // 25 TIPO DE VIA
        // 26 CODIGO DE ZONA
        $query = $this->oracle->query("SELECT * 
                                        FROM PRDDBFCOMERCIAL.FE_DETA_CATALOGO 
                                        WHERE CATALOGO_I = ?",
                                        array($id_catalogo));
        return $query->result_array();
    }

    public function get_igv(){
        $query = $this->oracle->query("SELECT * 
                                       FROM SPRING.IMPUESTOS 
                                       WHERE IMPUESTO = 'IGV'");
        return $query->row_array();
    }

    public function get_regzonloc($emp, $ofi){
        $query = $this->oracle->query("SELECT * 
                                        FROM PRDDBFCOMERCIAL.CEMPRES1 
                                        WHERE EMPCOD = ? AND OFICOD = ?",
                                        array($emp, $ofi));
        return $query->row_array();
    }

    public function get_serie($emp, $ofi, $are, $tipo_doc){
        $query = $this->oracle->query("SELECT * 
                                        FROM PRDDBFCOMERCIAL.CSERIES
                                        WHERE EMPCOD = ? AND OFICOD = ? AND 
                                                ARECOD = ? AND CTDCOD = 1 AND DOCCOD = ?",
                                        array($emp, $ofi, $are, $tipo_doc));
        return $query->row_array();
        
    }

    /*public function get_oficina_codigo(){
        $query = $db_prueba->query("SELECT OFIDES FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($oficod));
        
    }*/
    
    public function get_oficina($oficod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($oficod));
        return $query->row_array();
    }
    
    /*public function get_direccion_sede($oficod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT OFIDIR FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($oficod));
        return $query->row_array()['OFIDIR'];
    }*/
    
    public function get_area($arecod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.MAREAS WHERE ARECOD = ? ", array($arecod));
        return $query->row_array();
    }
    
    public function get_tipo_afectacion(){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM  PRDDBFCOMERCIAL.FE_DETA_CATALOGO WHERE CATALOGO_I = 7");
        return $query->result_array();
    }
    public function get_tipodoc_persona(){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.TIPDOC
                                        WHERE TIPDOCDESCABR != 'RUC' AND TIPDOCDESCABR != 'OTROS' ");
        return $query->result_array();
    }

    public function get_usuario($usr_id){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NUSERS 
                                        WHERE NCODIGO = ?",
                                        array($usr_id));
        return $query->row_array();
    }

    public function get_oficina2($region, $zona, $localidad){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE REG = ? AND ZON = ? AND LOC = ? ", array($region, $zona, $localidad));
        return $query->row_array();
    }

    public function get_rol($id){
       $db_prueba = $this->load->database('oracle', TRUE);
       $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.USER_ROL WHERE NCODIGO = ? AND ESTADO = ?  ", array($id, 1));

       return $query->result_array();
    }
}