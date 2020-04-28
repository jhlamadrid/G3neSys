<?php

class Regimen_Facturacion_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_estados(){
        $query = $this->db->query("SELECT * FROM PRDGESTIONCOMERCIAL.SDERIVACION");
        return $query->result_array();
    }

    public function get_oficinas(){
        $query = $this->db->query("SELECT * FROM PRDGESTIONCOMERCIAL.CEMPRES1 WHERE EMPCOD = 1");
        return $query->result_array();
    }

    public function resultado($estado,$FchIn,$FchFn,$oficina,$suministro){
        $campos = array();
        $caso = "SELECT
            ODE.EMPCOD, ODE.OFICOD, ODE.ARECOD,
            ODE.CTDCOD, ODE.DOCCOD, ODE.SERNRO,
            ODE.RECID, ODE.ARDCOD, ODE.DRVFSOL FECHA1,
            DRVSOL SOLUCION, DRVFPZO, DRVRES,
            DRVFRES, USRCODDE, SARDCOD,
            ARECODDE, OFICODDE, EMPCODDE,
            DRVTXTAT, ORE.UUCOD
            FROM PRDGESTIONCOMERCIAL.ODERIVACION ODE INNER JOIN PRDGESTIONCOMERCIAL.ORECLAMO ORE ON (ODE.EMPCOD=ORE.EMPCOD) AND (ODE.OFICOD=ORE.OFICOD)
            AND (ODE.ARECOD=ORE.ARECOD) AND (ODE.CTDCOD=ORE.CTDCOD) AND (ODE.DOCCOD=ORE.DOCCOD) AND (ODE.SERNRO=ORE.SERNRO) AND (ODE.RECID=ORE.RECID)
            WHERE ";
            #AND ROWNUM <=600
        $base = "ARECODDE = 3 AND EMPCODDE = 1  and regexp_like(DRVSOL, 'REGIMEN|regimen|régimen|Regimen|reg|Reg|RÉGIMEN')  ORDER BY ODE.RECID DESC";
        //Si hay fecha de  Inicio
        if($FchIn != ""){
            $caso .= "DRVFSOL >= TO_DATE ('".$FchIn."','DD/MM/YYYY') AND ";
        } else {
            $caso .= "DRVFSOL >= TO_DATE ('01/07/2015','DD/MM/YYYY') AND ";
        }
        //Si hay fecha de fin
        if($FchFn != ""){
            $caso .= "DRVFSOL <= TO_DATE ('".$FchFn."','DD/MM/YYYY') AND ";
        }

        //Si hay estado
        if($estado != "0"){
            $caso .= "SARDCOD = ? AND ";
            array_push($campos,$estado);
        }

        //Si hay oficina
        if($oficina != "0"){
            $caso .= "ODE.OFICOD = ? AND ";
            array_push($campos,$oficina);
        }

        //si hay suministro
        if($suministro != ""){
            $caso .= "ORE.UUCOD = ? AND ";
            array_push($campos,$suministro);
        }

        $caso .= $base;
        $query = $this->db->query($caso,$campos);
        return $query->result_array();

    }

    public function get_cantidad_regimenes(){
        $query = $this->db->query("SELECT COUNT(*) CANTIDAD
		FROM PRDGESTIONCOMERCIAL.ODERIVACION ODE INNER JOIN PRDGESTIONCOMERCIAL.ORECLAMO ORE ON (ODE.EMPCOD=ORE.EMPCOD) AND (ODE.OFICOD=ORE.OFICOD)
		AND (ODE.ARECOD=ORE.ARECOD) AND (ODE.CTDCOD=ORE.CTDCOD) AND (ODE.DOCCOD=ORE.DOCCOD) AND (ODE.SERNRO=ORE.SERNRO) AND (ODE.RECID=ORE.RECID)
		WHERE DRVFSOL >= TO_DATE ('01/07/2015','DD/MM/YYYY') AND SARDCOD = '1' AND ARECODDE = '3' AND EMPCODDE = '1' and regexp_like(DRVSOL, 'REGIMEN|regimen|régimen|Regimen|reg|Reg|RÉGIMEN') ORDER BY ODE.DRVFSOL DESC");
        return $query->row_array()['CANTIDAD'];
    }

    public function get_cantidad_regimenes1($estado,$FchIn,$FchFn,$oficina,$suministro){
        $campos = array();
        $caso = "SELECT COUNT(*) CANTIDAD
            FROM PRDGESTIONCOMERCIAL.ODERIVACION ODE INNER JOIN PRDGESTIONCOMERCIAL.ORECLAMO ORE ON (ODE.EMPCOD=ORE.EMPCOD) AND (ODE.OFICOD=ORE.OFICOD)
            AND (ODE.ARECOD=ORE.ARECOD) AND (ODE.CTDCOD=ORE.CTDCOD) AND (ODE.DOCCOD=ORE.DOCCOD) AND (ODE.SERNRO=ORE.SERNRO) AND (ODE.RECID=ORE.RECID)
            WHERE ";
        $base = "ARECODDE = 3 AND EMPCODDE = 1  and regexp_like(DRVSOL, 'REGIMEN|regimen|régimen|Regimen|reg|Reg|RÉGIMEN') AND ROWNUM <=600 ORDER BY ODE.DRVFSOL DESC";
        //Verificamos si ha enviado un intervalo de fechas (Fecha Inicial)
        if($FchIn != ""){
            $caso .= "DRVFSOL >= TO_DATE ('".$FchIn."','DD/MM/YYYY') AND ";
        } else {
            $caso .= "DRVFSOL >= TO_DATE ('01/07/2015','DD/MM/YYYY') AND ";
        }
        if($FchFn != ""){ //Verificamos si ha enviado un intervalo de fechas (Fecha final)
            $caso .= "DRVFSOL <= TO_DATE ('".$FchFn."','DD/MM/YYYY') AND ";
        }
        if($estado != "0"){ //Verificamos que estado se esta buscando (pendiente, atendido,anulado)
            $caso .= "SARDCOD = ? AND ";
            array_push($campos,$estado);
        }
        if($oficina != "0"){ //Verificamos que se haya enviado una oficina
            $caso .= "ODE.OFICOD = ? AND ";
            array_push($campos,$oficina);
        }
        if($suministro != ""){ // Verificamos que se haya enviado un suministro
            $caso .= "ORE.UUCOD = ? AND ";
            array_push($campos,$suministro);
        }
        $caso .= $base;
        $query = $this->db->query($caso,$campos);
        return $query->row_array()['CANTIDAD'];

    }

    public function get_reclamos(){
        $query = $this->db->query("SELECT
		ODE.EMPCOD, ODE.OFICOD, ODE.ARECOD,
		ODE.CTDCOD, ODE.DOCCOD, ODE.SERNRO,
		ODE.RECID, ODE.ARDCOD, ODE.DRVFSOL FECHA1,
		DRVSOL SOLUCION, DRVFPZO, DRVRES,
		DRVFRES, USRCODDE, SARDCOD,
		ARECODDE, OFICODDE, EMPCODDE,
		DRVTXTAT, ORE.UUCOD
		FROM PRDGESTIONCOMERCIAL.ODERIVACION ODE INNER JOIN PRDGESTIONCOMERCIAL.ORECLAMO ORE ON (ODE.EMPCOD=ORE.EMPCOD) AND (ODE.OFICOD=ORE.OFICOD)
		AND (ODE.ARECOD=ORE.ARECOD) AND (ODE.CTDCOD=ORE.CTDCOD) AND (ODE.DOCCOD=ORE.DOCCOD) AND (ODE.SERNRO=ORE.SERNRO) AND (ODE.RECID=ORE.RECID)
		WHERE DRVFSOL >= TO_DATE ('01/07/2015','DD/MM/YYYY') AND SARDCOD = '1' AND ARECODDE = '3' AND EMPCODDE = '1'  and regexp_like(DRVSOL, 'REGIMEN|regimen|régimen|Regimen|reg|Reg|RÉGIMEN')
        ORDER BY ODE.RECID DESC");
        return $query->result_array();
    }

    public function get_recibos($var){
        $query = $this->db->query("SELECT * FROM PRDGESTIONCOMERCIAL.ORECLAFAC WHERE EMPCOD = ".$var[0]." AND OFICOD = ".$var[1]."  AND ARECOD = ".$var[2]."  AND CTDCOD = ".$var[3]."  AND DOCCOD = ".$var[4]."  AND SERNRO = ".$var[5]."  AND RECID = ".$var[6]);
        return $query->result_array();
    }

    public function get_datos($serie,$numero){
        $query = $this->db->query("SELECT FACEMIFEC,FCICLO,FMEDIDOR,FACTARIFA,FAMBITO FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACNRO = ? AND FACSERNRO = ? ",array($numero,$serie));
        return $query->row_array();
    }

    public function get_horario($codigo){
      $query = $this->db->query("SELECT * FROM PRDDBFCOMERCIAL.HORABAST WHERE TRIM(CLICODFAC) = ? ORDER BY PERIODO DESC ",array($codigo));
      return $query->row_array();
    }

    public function get_datos2($serie,$numero){
        $query = $this->db->query("SELECT * FROM PRDGESTIONCOMERCIAL.ORECIFAC WHERE OFACSERNRO = ? AND OFACNRO = ? ",array($serie,$numero));
        return $query->row_array();
    }

    public function get_tipo_regimenes($suministro,$mes){
        $query = $this->db->query("SELECT * FROM PRDDBFCOMERCIAL.CTACTEFAC WHERE CLICODFAC = ? AND PROCESOFAC = ? ",array($suministro,$mes));
        return $query->row_array();
    }

    public function getCodigo($suministro){
        $query = $this->db->query("SELECT CODGRUPO FROM (SELECT CODGRUPO FROM PRDDBFCOMERCIAL.CTACTEFAC WHERE CLICODFAC = ? ORDER BY PROCESOFAC DESC) WHERE ROWNUM < 2",array($suministro));
        return $query->row_array()['CODGRUPO'];
    }

    public function get_suministro_multiple($grupo){
        $query = $this->db->query("SELECT DISTINCT CLICODFAC FROM PRDDBFCOMERCIAL.CTACTEFAC WHERE CODGRUPO = ? AND LENGTH(TRIM(CLICODFAC)) > 7",array($grupo));
        return $query->result_array();
    }

    public function get_unidades($suministro){
      $query = $this->db->query("SELECT COUNT(*) AS TOTAL FROM PRDCOMCATMEDLEC.CLIENT WHERE CLICODFAC = ? GROUP BY PREREGION,PREZONA,PRESECTOR,PREMZN, PRELOTE",array($suministro));
      return $query->row_array()['TOTAL'];
    }

    public function get_unidades1($grupo,$sub_grupo){
      $query = $this->db->query("SELECT COUNT(*) AS TOTAL FROM PRDCOMCATMEDLEC.CLIENT WHERE CLIGRUCOD = ? AND CLIGRUSUB = ?  AND CODTIPSER IN(1,3)",array($grupo,$sub_grupo));
      return $query->row_array()['TOTAL'];
    }

    public function get_suministros($grupo,$sub_grupo){
      $query = $this->db->query("SELECT CLICODFAC,CODTIPSER FROM PRDCOMCATMEDLEC.CLIENT WHERE CLIGRUCOD = ? AND CLIGRUSUB = ? AND CODTIPSER IN(1,3)",array($grupo,$sub_grupo));
      return $query->result_array();
    }

    public function get_tarifa_multiple($suministro){
      $query = $this->db->query("SELECT LO.AMBCOD,PRO.PREREGION,PRO.PRELOCALI,PRO.CLICODFAC,PRO.TARIFA FROM PRDCOMCATMEDLEC.LOCALI LO INNER JOIN
                                  PRDCOMCATMEDLEC.PROPIE PRO ON PRO.PREREGION = LO.PREREGION AND PRO.PRELOCALI =  LO.PRELOCALI WHERE PRO.CLICODFAC =   ?",array($suministro));
      return $query->row_array();
    }

    public function get_observaciones($obslec){
        $query = $this->db->query("SELECT MEDOBSDES FROM PRDDBFCOMERCIAL.OBSLEC WHERE MEDOBSCOD = ? ",array($obslec));
        return $query->row_array()['MEDOBSDES'];
    }

    public function get_consumos($suministro,$periodo){
        $query = $this->db->query("SELECT * FROM PRDDBFCOMERCIAL.CONS_PROM WHERE CLICODFAC = ? AND PERIODO = ? ", array($suministro,$periodo));
        return $query->row_array();
    }

    public function get_predio($grupo,$sub_grupo){
        $query = $this->db->query("SELECT * FROM PRDCOMCATMEDLEC.CLIENT WHERE CLIGRUCOD = ? AND CLIGRUSUB = ? ", array($grupo,$sub_grupo));
        return $query->row_array();
    }

    public function get_predio1($suministro){
        $query = $this->db->query("SELECT * FROM PRDCOMCATMEDLEC.CLIENT WHERE CLICODFAC = ? ", array($suministro));
        return $query->row_array();
    }

    public function get_ciclo_comercial($region,$zona,$sector,$mzn,$lote){
        $query = $this->db->query(" SELECT FACCICCOD FROM PRDCOMCATMEDLEC.PREDIO WHERE PREREGION = ? AND PREZONA = ? AND PRESECTOR = ? AND PREMZN = ? AND PRELOTE = ? ", array($region,$zona,$sector,$mzn,$lote));
        return $query->row_array()['FACCICCOD'];
    }

    public function get_consumo_asignado_domestico($suministro,$periodo){
        $query = $this->db->query("SELECT * FROM PRDDBFCOMERCIAL.HORABAST WHERE CLICODFAC = ? AND PERIODO = ? ", array($suministro,$periodo));
        return $query->row_array();
    }

    public function get_consumo_asignado($tarifa,$ambito){
        $query = $this->db->query("SELECT ASIGNADO FROM PRDDBFCOMERCIAL.EST_TAR WHERE TARIFA = ? AND AMBITO = ? ",array($tarifa,$ambito));
        return $query->row_array()['ASIGNADO'];
    }

    public function get_region_localidad($suministro){
        $query = $this->db->query("SELECT PREREGION,PRELOCALI FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array($suministro));
        return $query->row_array();
    }

    public function get_ambitos($region,$localidad){
        $query = $this->db->query("SELECT AMBCOD FROM PRDCOMCATMEDLEC.LOCALI where PREREGION = ? and PRELOCALI = ?",array($region,$localidad));
        return $query->row_array()['AMBCOD'];
    }

    public function get_consumo_asignado1($tarifa){
        $query = $this->db->query("SELECT ASIGNADO FROM PRDDBFCOMERCIAL.EST_TAR WHERE TARIFA = ?  ",array($tarifa));
        return $query->row_array()['ASIGNADO'];
    }

}
