<?php

class Afiliados_model extends CI_MODEL {

    var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }
    
    public function get_afiliados(){
        $db_prueba = $this->load->database('oracle', TRUE);  
        $query = $db_prueba->query("select * from PRDDBFCOMERCIAL.SOLAFDES");
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    
    
   
    
    
    
    
    
 }
?>