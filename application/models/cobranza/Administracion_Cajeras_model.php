<?php
class Administracion_Cajeras_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->oracle = $this->load->database('oracle', TRUE);
    $this->oracle->save_queries = false;
  }
  public function get_rol($usuario){ 
    $query = $this->oracle->query("SELECT ROL.ID_ROL FROM PRDDBFCOMERCIAL.ROLES ROL INNER JOIN
                                    PRDDBFCOMERCIAL.USER_ROL USR ON ROL.ID_ROL = USR.ID_ROL WHERE USR.NCODIGO = ? ",array($usuario));
    return $query->row_array()['ID_ROL'];
  }
  public function get_permiso($usuario,$hijo){ 
    $query = $this->oracle->query("SELECT  DISTINCT ACT.ID_ACTIV,ACT.ACTIVINOMB,ACT.ACTIVIHJO,GRP.MENUGENPDR FROM PRDDBFCOMERCIAL.USER_ROL NR
                                    JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                    JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                    JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                    JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                    JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                    WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND ACT.ACTIVIHJO = ?",array($usuario,$hijo));
    return $query->row_array();
  }
	public function get_cajeras(){
		$query = $this->oracle->query("SELECT USR.NCODIGO,USR.NNOMBRE,USR.LOGIN,USR.NENDS,USR.NESTADO,USR.NDNI, CEMP.OFIDES, USR.NSOFICOD FROM PRDDBFCOMERCIAL.NUSERS USR INNER JOIN
													PRDDBFCOMERCIAL.CEMPRES1 CEMP ON USR.NSOFICOD = CEMP.OFICOD INNER JOIN 
													PRDDBFCOMERCIAL.USER_ROL USL ON USR.NCODIGO = USL.NCODIGO INNER JOIN
													PRDDBFCOMERCIAL.ROLES ROL ON USL.ID_ROL =  ROL.ID_ROL WHERE ROL.ROLDESC = 'CAJERO'");
		return $query->result_array();
	}
	public function get_oficinas(){
		$query = $this->oracle->query("SELECT OFICOD,OFIDES FROM PRDDBFCOMERCIAL.CEMPRES1");
		return $query->result_array();
	}
  public function get_opcion_individual($str){ 
    $query = $this->oracle->query("SELECT ID_BTNGEN FROM PRDDBFCOMERCIAL.BTNGEN WHERE BTNGENNOMRE = ?",array($str));
    return $query->row_array()['ID_BTNGEN'];
  }
  public function ver_opcion($rol,$opcion,$actividad){
    $query = $this->oracle->query("SELECT ID_ROL FROM PRDDBFCOMERCIAL.ROL_ACT_BTN WHERE ID_ROL = ? AND ID_ACTIV = ? AND ID_BTNGEN = ? AND ESTADO = 1",array($rol,$actividad,$opcion));
    return $query->row_array()['ID_ROL'];
  }
  public function actualizar_cajera($id,$of){
    $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NUSERS SET NSOFICOD = ?, OFICOD = ? WHERE  NCODIGO = ?",array($of,$of,$id));
    return $query;
  }
}