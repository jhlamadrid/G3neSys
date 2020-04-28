<?php

class Reporte_model extends CI_MODEL { 

	var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
        $this->oracle->save_queries = false;
    }


    public function obtener_comprobante($tipo, $inicio, $fin){
    	$query = $this->oracle->query("SELECT * 
    									FROM PRDDBFCOMERCIAL.SFACTURA 
										WHERE 	FSCTIPO = ? AND 
												TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY')
										ORDER BY FSCSERNRO, FSCNRO",
										array($tipo, $inicio, $fin)); 
    }

    public function obtener_serie_by_oficina($CTDCOD, $DOCCOD){
    	$query = $this->oracle->query("SELECT 
	          								PRDGESTIONCOMERCIAL.CSERIES.EMPCOD, 
											PRDGESTIONCOMERCIAL.CSERIES.OFICOD,
											PRDGESTIONCOMERCIAL.CSERIES.CTDCOD,
											PRDGESTIONCOMERCIAL.CSERIES.DOCCOD,
											PRDGESTIONCOMERCIAL.CSERIES.SERNRO	      
											FROM 	PRDGESTIONCOMERCIAL.CSERIES	  
											WHERE 	PRDGESTIONCOMERCIAL.CSERIES.CTDCOD = ? AND 
											      	PRDGESTIONCOMERCIAL.CSERIES.DOCCOD = ? 	  
											GROUP BY
											        PRDGESTIONCOMERCIAL.CSERIES.EMPCOD, 
											        PRDGESTIONCOMERCIAL.CSERIES.OFICOD,
											        PRDGESTIONCOMERCIAL.CSERIES.CTDCOD,
											        PRDGESTIONCOMERCIAL.CSERIES.DOCCOD,
											        PRDGESTIONCOMERCIAL.CSERIES.SERNRO							        
											ORDER BY PRDGESTIONCOMERCIAL.CSERIES.EMPCOD, 
											        PRDGESTIONCOMERCIAL.CSERIES.OFICOD,
											        PRDGESTIONCOMERCIAL.CSERIES.CTDCOD,
											        PRDGESTIONCOMERCIAL.CSERIES.DOCCOD,
											        PRDGESTIONCOMERCIAL.CSERIES.SERNRO;",
									array($CTDCOD, $DOCCOD));
		return $query->result_array();
    }

    

}