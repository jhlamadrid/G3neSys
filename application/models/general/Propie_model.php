<?php

class Propie_model extends CI_MODEL {

	function __construct() {
        parent::__construct();
    }

    public function get_propie($cod_sum){
    	$db_prueba = $this->load->database('oracle', TRUE); 

    	$query = $db_prueba->query("SELECT * 
    							    FROM PRDCOMCATMEDLEC.PROPIE 
    							    WHERE CLICODFAC = ?", 
    							    array($cod_sum));
    	return $query->row_array();
    }


    public function get_default_propie(){
        $db_prueba = $this->load->database('oracle', TRUE); 

        $query = $db_prueba->query("SELECT CLICODFAC, CLINOMBRE, CLIELECT, CLIRUC
                                    FROM PRDCOMCATMEDLEC.PROPIE 
                                    WHERE CLICODFAC = '99999999999'");
        return $query->row_array();
    }
}