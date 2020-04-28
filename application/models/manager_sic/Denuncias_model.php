<?php

class Denuncias_model extends CI_MODEL {

	var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_denuncias(){
        $query = $this->oracle->query("SELECT DENU_COD,DENU_NOM,DENU_DESC,DENU_LOGITUD,DENU_LATITUD,DENU_IMAGEN,DENU_ESTADO,to_char(DENU_FECHREG,'dd/mm/yyyy hh:mi:ss am') FECHA FROM ADMWEB.DENUNCIAS_MOVWEB ORDER BY DENU_FECHREG DESC");
        return $query->result_array();
    }

    public function get_one_denuncia_id($id){
      $query = $this->oracle->query("SELECT DENU_COD,DENU_NOM,DENU_DESC,DENU_LOGITUD,DENU_LATITUD,DENU_IMAGEN,DENU_ESTADO,to_char(DENU_FECHREG,'dd/mm/yyyy hh:mi:ss am') FECHA FROM ADMWEB.DENUNCIAS_MOVWEB WHERE DENU_COD = ?",array($id));
      return $query->row_array();
    }
}
