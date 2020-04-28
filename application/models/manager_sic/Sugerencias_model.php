<?php

class Sugerencias_model extends CI_MODEL {

	var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_sugerencias(){
      $query = $this->db->query("SELECT PTGTTICK_CODE,PTGTTICK_ASUNTO,PTGTTICK_APELLIDOS,PTGTTICK_NOMBRES,PTGTTICK_EMAIL, to_char(PTGTTICK_FECHA_ACTIVIDAD,'dd/mm/yyyy hh:mi:ss am') FECHA, PTGTTICK_TAGS,PTGTTICK_ESTADO,PTGTTICK_TTISO_CODE FROM PRDPORTALSEDALIB.PTGTTICK ORDER BY PTGTTICK_FECHA_ACTIVIDAD DESC");
		  return $query->result_array();
    }

		function get_usuario($codigo){
			$query = $this->db->query('select PTGTTICK_CODE,PTGTTICK_ASUNTO,PTGTTICK_APELLIDOS,PTGTTICK_NOMBRES,PTGTTICK_EMAIL,PTGTTICK_FECHA_ACTIVIDAD,PTGTTICK_TAGS,PTGTTICK_ESTADO FROM PRDPORTALSEDALIB.PTGTTICK WHERE PTGTTICK_CODE = ?',array($codigo));
			return $query->row_array();
		}

		function estado_sugerencia($codigo){
			$query = $this->db->query('update PRDPORTALSEDALIB.PTGTTICK set PTGTTICK_ESTADO = 1 where PTGTTICK_CODE = ?',array($codigo));
		}
}
