<?php

class Estados_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_permiso_cuenta_corriente($usuario,$hijo){
      $query = $this->oracle->query("SELECT  DISTINCT ACT.*,GRP.MENUGENPDR FROM PRDDBFCOMERCIAL.USER_ROL NR
                                      JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                      WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND ACT.ACTIVIHJO = ?",array($usuario,$hijo));
      return $query->row_array();
    }

    public function get_notas_credito_del_dia(){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCAURSCOD = ? AND BFNCAFECHEMI = ? AND BFNCATIPO = 'A' ORDER BY BFNCANRO DESC",array($_SESSION['user_id'],date("d/m/Y")));
      return $query->result_array();
    }

    public function get_notas_credito_rango($tipo,$fecha_inicio,$fecha_fin){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCATIPO = ? AND BFNCAURSCOD = ? AND BFNCAFECHEMI BETWEEN ? AND ? ORDER BY BFNCANRO DESC",array($tipo,$_SESSION['user_id'],$fecha_inicio,$fecha_fin));
      return $query->result_array();
    }

}
