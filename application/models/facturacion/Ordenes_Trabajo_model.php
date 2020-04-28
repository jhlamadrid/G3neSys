<?php 
class Ordenes_Trabajo_model extends CI_Model{
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
    public function get_opcion_individual($str){ 
        $query = $this->oracle->query("SELECT ID_BTNGEN FROM TESTPRDDBFCOMERCIAL.BTNGEN WHERE BTNGENNOMRE = ?",array($str));
        return $query->row_array()['ID_BTNGEN'];
    }
    public function get_ciclos(){
        $query = $this->oracle->query("SELECT FACCICCOD,FACCICDES FROM PRDCOMCATMEDLEC.CICLOS");
        return $query->result_array();
    }
    public function get_fecha_apta($f){
        $query = $this->oracle->query("SELECT FMX1,FMX2 FROM PRDDBFCOMERCIAL.DIASHABILES WHERE FECHA = ? AND HABIL = 1",array($f));
        return $query->row_array();
    }
    public function get_carga_x_ciclo($ciclos,$periodo){
        $data = array();
        $text = "";
        $k = 0;
        foreach($ciclos as $c){
            array_push($data,$c);
            if($k == 0)  $text .= ' IN (? ';
            else if($k == (sizeof($ciclos)) - 1) $text .= ', ? )';
            else $text .= ', ?';
            $k++;
        }
        if($k == 1){
            $text .= ')';
        }
        array_push($data,$periodo);
        $text .= " AND PERIODO = ?";
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ATIPICOS WHERE CICLO ".$text,$data);
        return $query->result_array();

    }

    public function get_dato_x_cliente($suministro){
        $query = $this->oracle->query("SELECT TARIFA, CLIELECT, CLIRUC, PREREGION, PRELOCALI, CLICOBTEL FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array($suministro));
        return $query->row_array();
    }

    public function get_localic_provi($region, $locali){
        $query = $this->oracle->query("SELECT LOCDES, PROVINDES FROM PRDDBFCOMERCIAL.LOCALI LOC INNER JOIN PRDDBFCOMERCIAL.PROVIN PRO
                                        ON LOC.PROVINCOD = PRO.PROVINCOD WHERE LOC.REGCOD = ?  AND LOC.LOCCOD = ?",array($region, $locali));
        return $query->row_array();
    }

}