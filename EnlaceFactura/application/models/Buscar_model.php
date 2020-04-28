<?php 

class Buscar_model extends CI_MODEL {

	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_datos_factura($documento,$tipo,$fecha,$serie,$numero, $monto){
    	$db_prueba = $this->load->database('oracle', TRUE);
    	$query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.SFACTURA WHERE  FSCCLIRUC = ? AND FSCTIPO= ? AND FSCSERNRO = ? AND TO_CHAR(FSCFECH,'DD-MM-YYYY') = ? AND SUNFACNRO = ? AND FSCTOTAL= ?", array($documento,$tipo,$serie,$fecha, $numero, $monto));
        return $query->result_array();
    }
    public function get_datos_boleta($documento,$tipo,$fecha,$serie,$numero,$monto){
    	$db_prueba = $this->load->database('oracle', TRUE);
    	$query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.SFACTURA WHERE  FSCNRODOC = ? AND FSCTIPO= ? AND FSCSERNRO = ? AND TO_CHAR(FSCFECH,'DD-MM-YYYY') = ? AND SUNFACNRO = ? AND FSCTOTAL= ? ", array($documento,$tipo,$serie,$fecha, $numero, $monto));
        return $query->result_array();
    }
}

?>