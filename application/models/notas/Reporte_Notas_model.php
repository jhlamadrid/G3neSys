<?php
class Reporte_Notas_model extends CI_Model {
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

    public function get_permiso_cuenta_corriente($usuario,$hijo){ 
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
        $query = $this->oracle->query("SELECT ID_BTNGEN FROM PRDDBFCOMERCIAL.BTNGEN WHERE BTNGENNOMRE = ?",array($str));
        return $query->row_array()['ID_BTNGEN'];
    }
    
    public function ver_opcion($rol,$opcion,$actividad){
        $query = $this->oracle->query("SELECT ID_ROL FROM PRDDBFCOMERCIAL.ROL_ACT_BTN WHERE ID_ROL = ? AND ID_ACTIV = ? AND ID_BTNGEN = ? AND ESTADO = 1",array($rol,$actividad,$opcion));
        return $query->row_array()['ID_ROL'];
    }

    public function getAllAgencias(){
        $query = $this->oracle->query("SELECT OFIDES, OFICOD FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD_GENESYS IS NOT NULL");
        return $query->result_array();
    }

    public function getAllSeries(){
        $query = $this->oracle->query("SELECT OFICOD_GENESYS, OFIAGECOD_GENESYS, OFIDES, OFICOD FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD_GENESYS IS NOT NULL");
        return $query->result_array();
    }

    public function getSeriesXOficina($checked){
        $series = array();
        foreach($checked as $c){
            $query = $this->oracle->query("SELECT OFICOD_GENESYS, OFIAGECOD_GENESYS, OFIDES, OFICOD FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ?",array(intval($c)));
            array_push($series, $query->row_array());
        }
        return $series;
    }

    public function getNotasCredito($series, $fechaInicio, $fechaFin){
        $notas = array();
        foreach($series as $s){
            $query =  $this->oracle->query("SELECT NCACLICODF, TOTFAC_FACSERNRO, NCAFACEMIF, TOTFAC_FACNRO, NCAFACTOTS, NCAFACIGV, NCAFACTOTA, NCASERNRO, NCANRO, NCAFACESTA, NCAFECHA, NCASUBDIF, NCAIGVDIF, NCATOTDIF, NCAREFE, NNOMBRE 
                                            FROM PRDDBFCOMERCIAL.NCA INNER JOIN PRDDBFCOMERCIAL.NUSERS ON NCA.NCACREA = NUSERS.NCODIGO WHERE NCATIPO = ? AND NCAFECHA BETWEEN ? AND ? AND NCAFICOD = ? AND NCAFIAGECO = ? AND NCAFACESTA <> 'A'",
                                            array('A', $fechaInicio, $fechaFin, $s['OFICOD_GENESYS'], $s['OFIAGECOD_GENESYS']));
            
            if(sizeof($query->result_array()) > 0 ) {
                $query1 = $this->oracle->query("SELECT COUNT(NCASERNRO) AS CANTIDAD, SUM(NCASUBDIF) AS SUBTOTAL, SUM(NCAIGVDIF) AS IGV, SUM(NCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA WHERE NCATIPO = ? AND NCAFECHA BETWEEN ? AND ? AND NCAFICOD = ? AND NCAFIAGECO = ? AND NCAFACESTA <> 'A'",array('A', $fechaInicio, $fechaFin, $s['OFICOD_GENESYS'], $s['OFIAGECOD_GENESYS']));
                array_push($notas, (object)array("oficod" => $s['OFICOD_GENESYS'], 
                                                 "agen" => $s['OFIAGECOD_GENESYS'], 
                                                 "des" => $s['OFIDES'], 
                                                 "OFICOD" => $s['OFICOD'],
                                                 "notas" => $query->result_array(), 
                                                 "cantidad" => $query1->row_array()['CANTIDAD'], 
                                                 "total" => number_format($query1->row_array()['TOTAL'],2,',',' '),
                                                 "subtotal" => number_format($query1->row_array()['SUBTOTAL'],2,',',' '),
                                                 "igv" => number_format($query1->row_array()['IGV'],2,',',' ')
                                                 )
                                                );
            }
        }
        return $notas;
    }
}