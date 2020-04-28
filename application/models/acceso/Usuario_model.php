<?php
class Usuario_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database(); 
        $this->oracle = $this->load->database('oracle', TRUE);
    }
    public function validarUsuario($nombreUsuario, $password) {
        $query = $this->oracle->query("SELECT NUSERS.*, CASE WHEN ( NENDS > SYSDATE ) THEN 0 ELSE 1 END AS VENCIDO FROM PRDDBFCOMERCIAL.NUSERS WHERE LOGIN = ? AND NCLAVE=? AND NESTADO = 1", array($nombreUsuario, $password));//sha1($password)));
        return $query->row_array();
    }

    public function obtener_oficina($oficod){
        $query = $this->oracle->query('SELECT OFIDES FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ?', array($oficod));
        return $query->row_array()['OFIDES'];
    }

    public function obtener_area($arecod){
        $query = $this->oracle->query('SELECT AREDES FROM PRDDBFCOMERCIAL.MAREAS WHERE ARECOD = ?', array($arecod));
        return $query->row_array()['AREDES'];
    }

    public function get_one_usuario($idUsuario) {
        $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = ?', array($idUsuario));
        return $query->row_array();
    }

    public function get_cempres_usuario($emp){//NSEMPCOD, NSOFICOD, NSARECOD
        $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.CEMPRES WHERE EMPCOD = ?', array($emp));
        return $query->row_array();
    }

    public function get_grupo_actividades($usuario){
        $query = $this->oracle->query('SELECT DISTINCT GRP.*
                                      FROM PRDDBFCOMERCIAL.USER_ROL NR JOIN
                                      PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL JOIN
                                      PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL JOIN
                                      PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                      WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 ORDER BY GRP.MENUGENDESC',array($usuario));
        return $query->result_array();
    }

    public function get_actividad_x_usuario($usuario,$id_menu){
      $query = $this->oracle->query('SELECT  DISTINCT ACT.* FROM PRDDBFCOMERCIAL.USER_ROL NR
                                      JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                      WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND GRP.ID_MENUGEN = ? ',array($usuario,$id_menu));
      return $query->result_array();
    }

    public function get_actividades($usuario){
        $query = $this->oracle->query('SELECT /*RO.ROLDESC,*/ DISTINCT ACT.ACTIVDESC,GRP.MENUGENDESC FROM PRDDBFCOMERCIAL.USER_ROL NR JOIN PRDDBFCOMERCIAL.ROLES  RO ON NR.ID_ROL = RO.ID_ROL
                                    JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                    JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                    JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                    JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                    WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1',array($usuario));
        return $query->result_array();
    }

    public function get_tareas($usuario){
        $query = $this->oracle->query('SELECT ACT.ACTIVDESC,GRP.MENUGENDESC,TAR.BTNGENDESC FROM PRDDBFCOMERCIAL.USER_ROL NR JOIN PRDDBFCOMERCIAL.ROLES  RO ON NR.ID_ROL = RO.ID_ROL
                                        JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                        JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                        JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                        JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                        JOIN PRDDBFCOMERCIAL.ACT_BTNGEN ACRT ON ACT.ID_ACTIV = ACRT.ID_ACTIV
                                        JOIN PRDDBFCOMERCIAL.BTNGEN TAR ON ACRT.ID_BTNGEN = TAR.ID_BTNGEN
                                        WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND ACRT.ESTADO = 1',array($usuario));
        return $query->result_array();
    }

    public function get_user($id){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = ?",array($id));
      return $query->row_array();
    }

    public function get_rol_user($id){
      $query = $this->oracle->query("SELECT ROL.ROLDESC FROM PRDDBFCOMERCIAL.ROLES ROL INNER JOIN
                                    PRDDBFCOMERCIAL.USER_ROL URL ON ROL.ID_ROL =  URL.ID_ROL WHERE URL.NCODIGO = ?",array($id));
      return $query->row_array()['ROLDESC'];
    }

    public function update_psw($psw,$new,$codigo){
        $data = array(
          'NCLAVE' => $new,
          'ESTCRYP' => 2
        );
        $this->oracle->where('NCODIGO', $codigo);
        $this->oracle->where('NCLAVE', $psw);
        $this->oracle->update('PRDDBFCOMERCIAL.NUSERS', $data); 
        return $this->oracle->affected_rows();
    }

    public function get_fecha_expiracion($id){
        $query = $this->oracle->query("SELECT NENDS FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = ?",array($id));
        return $query->row_array()['NENDS'];
    }

    public function findUsuarioReclamo($usuario){
        $this->oracle->select("USRCOD, EMPCOD, OFICOD, ARECOD");
        $this->oracle->from("PRDGESTIONCOMERCIAL.MUSUARIO");
        $this->oracle->where("USRLOG", $usuario);
        return $this->oracle->get()->row_array();
    }

}
