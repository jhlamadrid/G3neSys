<?php

class Opciones_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_permiso($usuario,$hijo){
      $query = $this->oracle->query("SELECT  DISTINCT ACT.*,GRP.MENUGENPDR FROM PRDDBFCOMERCIAL.USER_ROL NR
                                      JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                      WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND ACT.ACTIVIHJO = ?",array($usuario,$hijo));
      return $query->row_array();
    }

    public function get_all_roles(){
    	$query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ROLES");
    	return $query->result_array();
    }

    public function get_actividades($id){
    	$query = $this->oracle->query("SELECT ACT.* FROM PRDDBFCOMERCIAL.ROLES ROL 
													INNER JOIN PRDDBFCOMERCIAL.ROL_ACT RAC ON ROL.ID_ROL = RAC.ID_ROL
													INNER JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACT.ID_ACTIV = RAC.ID_ACTIV WHERE ROL.ID_ROL = ? ",array($id));
    	return $query->result_array();
    }

    public function get_botones($actividad){
    	$query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BTNGEN BTN INNER JOIN
													PRDDBFCOMERCIAL.ACT_BTNGEN ACBT ON BTN.ID_BTNGEN = ACBT.ID_BTNGEN 
													WHERE ACBT.ID_ACTIV = ? ",array($actividad));
    	return $query->result_array();
    }

    public function get_botones_asignados($rol,$actividad){
    	$query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ROL_ACT_BTN WHERE ID_ROL = ? AND ID_ACTIV = ? AND ESTADO = 1",array($rol,$actividad));
    	return $query->result_array();
    }

    public function update_botones($agregar,$quitar,$rol,$actividad){
    	$this->oracle->trans_begin();
    	if(sizeof($agregar) > 0){
	    	foreach ($agregar as $btn) {
	    		$result = $this->oracle->query("SELECT ID_BTNGEN FROM PRDDBFCOMERCIAL.ROL_ACT_BTN WHERE ID_ROL = ?  AND ID_ACTIV = ?  AND ID_BTNGEN = ?",array($rol,$actividad,$btn));
	    		if($result->row_array()['ID_BTNGEN']){
	    			$query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.ROL_ACT_BTN SET ESTADO = 1 WHERE ID_ROL = ? AND ID_ACTIV = ? AND ID_BTNGEN = ? ",array($rol,$actividad,$btn));
	    		} else {
	    			$query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.ROL_ACT_BTN (ID_ROL,ID_ACTIV,ID_BTNGEN,ESTADO) VALUES (?,?,?,?)",array($rol,$actividad,$btn,1));
	    		}
	    		if(!$query){
			      $this->oracle->trans_rollback();
			      return false;break;
			   }
			   $this->oracle->trans_commit();
	    	}
    	}
    	if(sizeof($quitar) > 0){
	    	foreach ($quitar as $btn) {
	    		$result = $this->oracle->query("SELECT ID_BTNGEN FROM PRDDBFCOMERCIAL.ROL_ACT_BTN WHERE ID_ROL = ?  AND ID_ACTIV = ?  AND ID_BTNGEN = ?",array($rol,$actividad,$btn));
	    		if($result->row_array()['ID_BTNGEN']){
	    			$query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.ROL_ACT_BTN SET ESTADO = 2 WHERE ID_ROL = ? AND ID_ACTIV = ? AND ID_BTNGEN = ? ",array($rol,$actividad,$btn));
	    		} else {
	    			$query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.ROL_ACT_BTN (ID_ROL,ID_ACTIV,ID_BTNGEN,ESTADO) VALUES (?,?,?,?)",array($rol,$actividad,$btn,2));
	    		}
	    		if(!$query){
			      $this->oracle->trans_rollback();
			      return false;break;
			   }
			   $this->oracle->trans_commit();
	    	}
    	}
    	return true;
    }
}