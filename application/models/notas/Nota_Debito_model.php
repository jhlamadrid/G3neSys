<?php

class Nota_Debito_model extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->database();
        //  $db_prueba = $this->load->database('prueba', TRUE);
    }
    
     public function get_notas_debito(){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT *  FROM (select * from PRDDBFCOMERCIAL.NCA where NCAFECHA > '01/01/2016' AND NCATIPO ='C' ORDER BY NCAFECHA DESC) WHERE ROWNUM < 500");
        return $query->result_array();
    }
    
    public function get_facturasyboletas($serie,$numero,$tipodoc){
        $db_prueba = $this->load->database('oracle', TRUE);
        if($tipodoc == "1"){
            $query = $db_prueba->query("SELECT *  FROM PRDDBFCOMERCIAL.SFACTURA WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = 1", array($serie,$numero));
        } else if($tipodoc == "0"){
            $query = $db_prueba->query("SELECT *  FROM PRDDBFCOMERCIAL.SFACTURA WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = 0", array($serie,$numero));
        }
        return $query->row_array();
    }
    
    public function get_igv(){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT FACTORPORCENTAJE FROM SPRING.IMPUESTOS WHERE IMPUESTO = 'IGV'");
        $valor = $query->row_array();
        return $valor['FACTORPORCENTAJE'];
    }

    
    public function get_facturasyboletas_detalle($serie,$numero,$numero1){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("select SF.*,CO.* from PRDDBFCOMERCIAL.SFACTUR1 SF JOIN PRDDBFCOMERCIAL.CONCEP CO ON SF.FACCONCOD = CO.FACCONCOD  where SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND SFACTURA_FSCTIPO = ? ", array($serie,$numero,$numero1));
        return $query->result_array();
    }
    
    public function get_oficina($oficod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT OFIDES FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($oficod));
        return $query->row_array()['OFIDES'];
    }
    
    public function get_direccion_sede($oficod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT OFIDIR FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($oficod));
        return $query->row_array()['OFIDIR'];
    }
    
    public function get_area($arecod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT AREDES FROM PRDDBFCOMERCIAL.MAREAS WHERE ARECOD = ? ", array($arecod));
        return $query->row_array()['AREDES'];
    }
    
    public function get_nombre_sede($oficod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT (PROV || ' - ' ||DEPTO) AS DIRECCION,DIST FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($oficod));
        return $query->row_array();
    }
    
}