<?php
class Libro_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
        $this->oracle->save_queries = false;
    }

    public function get_rol($usuario){ 
        $query = $this->oracle->query("SELECT ROL.ID_ROL FROM PRDDBFCOMERCIAL.ROLES ROL INNER JOIN
                                        TESTPRDDBFCOMERCIAL.USER_ROL USR ON ROL.ID_ROL = USR.ID_ROL WHERE USR.NCODIGO = ? ",array($usuario));
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

    public function obtenerObs($oficina){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.LOBSERVACIONES INNER JOIN PRDDBFCOMERCIAL.LOBSUSR ON LOBSERVACIONES.LUSRCOD = LOBSUSR.LUSRCOD 
                                        INNER JOIN PRDDBFCOMERCIAL.CEMPRES1 ON LOBSERVACIONES.OFICOD = CEMPRES1.OFICOD
                                        INNER JOIN PRDDBFCOMERCIAL.TIPDOC ON LOBSUSR.TIPDOCCOD = TIPDOC.TIPDOCCOD
                                        WHERE LOBSERVACIONES.OFICOD = ?", array($oficina));
        return $query->result_array();
    }

    public function obtenerObsGeneral(){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.LOBSERVACIONES INNER JOIN PRDDBFCOMERCIAL.LOBSUSR ON LOBSERVACIONES.LUSRCOD = LOBSUSR.LUSRCOD 
                                        INNER JOIN PRDDBFCOMERCIAL.CEMPRES1 ON LOBSERVACIONES.OFICOD = CEMPRES1.OFICOD
                                        INNER JOIN PRDDBFCOMERCIAL.TIPDOC ON LOBSUSR.TIPDOCCOD = TIPDOC.TIPDOCCOD");
        return $query->result_array();
    }

    public function obtenerObs1($codigo){
        $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.LOBSERVACIONES INNER JOIN PRDDBFCOMERCIAL.LOBSUSR ON LOBSERVACIONES.LUSRCOD = LOBSUSR.LUSRCOD 
                                    INNER JOIN PRDDBFCOMERCIAL.CEMPRES1 ON LOBSERVACIONES.OFICOD = CEMPRES1.OFICOD
                                  WHERE  LOBSCOD = ?', array($codigo));
        return $query->row_array();
    }

    public function guardarRespuesta($respuesta, $codigo, $usuario){
        $query = $this->oracle->query('UPDATE PRDDBFCOMERCIAL.LOBSERVACIONES SET RESPUESTA = ?, FECRPTA = ?, HRARPTA = ?, ESTADO = ?, USRCOD = ? WHERE LOBSCOD = ?', array($respuesta, date('d/m/Y'), date('H:i:s'), 2, $usuario, $codigo));
        return $query;
    }

    public function obtenerTipDoc(){
        $query = $this->oracle->query("SELECT TIPDOCCOD, TIPDOCDESC FROM PRDDBFCOMERCIAL.TIPDOC");
        return $query->result_array();
    }

    public function obtenerObsBus($oficina, $tipo, $numero){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.LOBSERVACIONES INNER JOIN PRDDBFCOMERCIAL.LOBSUSR ON LOBSERVACIONES.LUSRCOD = LOBSUSR.LUSRCOD 
                                        INNER JOIN PRDDBFCOMERCIAL.CEMPRES1 ON LOBSERVACIONES.OFICOD = CEMPRES1.OFICOD
                                        INNER JOIN PRDDBFCOMERCIAL.TIPDOC ON LOBSUSR.TIPDOCCOD = TIPDOC.TIPDOCCOD
                                        WHERE LOBSERVACIONES.OFICOD = ? AND LOBSUSR.TIPDOCCOD = ? AND LOBSUSR.NRODOC = ?", array($oficina, $tipo, $numero));
        return $query->result_array();
    }
}