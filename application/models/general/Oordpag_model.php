<?php

class Oordpag_model extends CI_MODEL {

	var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    function get_all_oordpag($inicio, $fin){

        $dateinicio = str_replace('-', '/', $inicio);
        $datefin = str_replace('-', '/', $fin);

        //var_dump($dateinicio.' al '.$datefin);
        /*var_dump($_SESSION['user_emp']);$_SESSION['NSEMPCOD'], $_SESSION['NSOFICOD'], $_SESSION['NSARECOD'],
        var_dump($_SESSION['user_ofi']);
        var_dump($_SESSION['user_area']);/*AND
                                    ? <= ORPFCHEMI AND ? >= ORPFCHEMI
                                    , $dateinicio, $datefin
                                    */
        //AND EMPCOD = ? AND
                                    //OFICOD = ? AND
                                    //ARECOD = ? AND
                                    //to_date(?,'DD/MM/YYYY') <= ORPFCHEMI AND to_date(?,'DD/MM/YYYY') >= ORPFCHEMI
    	$query = $this->oracle->query("SELECT *
                              FROM PRDGESTIONCOMERCIAL.OORDPAG
                              WHERE
                                    CTDCOD = 3 AND
                                    DOCCOD = 4 AND
                                    SORCOD = 1 AND
                                    ORPTOT > 0 AND
                                    TRUNC (ORPFCHEMI) BETWEEN TO_DATE(?, 'DD/MM/YYYY') AND TO_DATE(?, 'DD/MM/YYYY')
                              ORDER BY ORPFCHEMI DESC",
                              array(
                                    $dateinicio, $datefin));
        /*$query = $this->oracle->query("SELECT *
    						  FROM PRDGESTIONCOMERCIAL.OORDPAG
    						  WHERE
    						  		CTDCOD = 3 AND
    						  		DOCCOD = 4 AND
    						  		SORCOD = 1 AND
                                    ORPTOT > 0
    						  ORDER BY ORPFCHEMI DESC",
                              array($_SESSION['NSEMPCOD'], $_SESSION['NSOFICOD'], $_SESSION['NSARECOD']));*/
    	//var_dump($query);
        return $query->result_array();
    }

    function get_oordpag($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $ORPNRO){
        $query = $this->oracle->query("SELECT *
                              FROM PRDGESTIONCOMERCIAL.OORDPAG
                              WHERE EMPCOD = ? AND
                                    OFICOD = ? AND
                                    ARECOD = ? AND
                                    CTDCOD = ? AND
                                    DOCCOD = ? AND
                                    SERNRO = ? AND
                                    ORPNRO = ? AND
                                    SORCOD = 1
                              ORDER BY ORPFCHEMI DESC",
                              array($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $ORPNRO));
        return $query->result_array();
    }


    function get_oordserv($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $ORPNRO){
        $query = $this->oracle->query("SELECT *
                                        FROM PRDGESTIONCOMERCIAL.OCENDOC
                                        WHERE   STPEMPCOD = ? AND
                                                STPOFICOD = ? AND
                                                STPARECOD = ? AND
                                                STPCTDCOD = ? AND
                                                STPDOCCOD = ? AND
                                                STPSERNRO = ? AND
                                                CDPNRO = ?",
                                        array($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $ORPNRO));
        //var_dump(array($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $ORPNRO));
        return $query->row_array();

    }

    function get_concep_oordpag($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $ORPNRO){
        $query = $this->oracle->query("SELECT
                                            PRDGESTIONCOMERCIAL.OORDPAG1.ORPCNT,
                                            PRDGESTIONCOMERCIAL.OORDPAG1.STOPCUMCOD,
                                            PRDGESTIONCOMERCIAL.OORDPAG1.ORPPRE,
                                            PRDDBFCOMERCIAL.CONCEP.*
                                        FROM PRDGESTIONCOMERCIAL.OORDPAG1
                                        INNER JOIN PRDDBFCOMERCIAL.CONCEP
                                        ON PRDDBFCOMERCIAL.CONCEP.FACCONCOD = PRDGESTIONCOMERCIAL.OORDPAG1.CPTCOD
                                        WHERE   EMPCOD = ? AND
                                                OFICOD = ? AND
                                                ARECOD = ? AND
                                                CTDCOD = ? AND
                                                DOCCOD = ? AND
                                                SERNRO = ? AND
                                                ORPNRO = ?",
                                    array($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $ORPNRO));
        return $query->result_array();
    }

    function existe_usuario($oordserv){
        $query = $this->oracle->query("select
                                        OCENDOC.STAEMPCOD, OCENDOC.STAOFICOD, OCENDOC.STAARECOD,
                                        OCENDOC.STACTDCOD, OCENDOC.STADOCCOD, OCENDOC.STASERNRO, OCENDOC.CDANRO,
                                        Y.MCSCOD, Y.MCSNOM, Y.MCSAPE, Y.MCSRZS,
                                        Y.MCSNRODOC, Y.MCSTLF1, Y.MCSTLF2, Y.MCSCEL,
                                        Y.CDPDES, Y.CPVDES, Y.CDSDES, Y.CGPDES, Y.MVIDES,Y.MCSNRO,
                                        Y.DIRECCION
                                        FROM PRDGESTIONCOMERCIAL.OCENDOC
                                        INNER JOIN (SELECT OSOLACC.EMPCOD, OSOLACC.OFICOD, OSOLACC.ARECOD,
                                        OSOLACC.CTDCOD, OSOLACC.DOCCOD, OSOLACC.SERNRO, OSOLACC.SASNRO,
                                        X.MCSCOD, X.MCSNOM, X.MCSAPE, X.MCSRZS,
                                        X.MCSNRODOC, X.MCSTLF1, X.MCSTLF2, X.MCSCEL,
                                        X.CDPDES,X.CPVDES,X.CDSDES,X.CGPDES,X.MVIDES,X.MCSNRO,
                                        X.DIRECCION
                                        FROM PRDGESTIONCOMERCIAL.OSOLACC
                                        INNER JOIN (select MCLISOL.MCSCOD, MCLISOL.MCSNOM, MCLISOL.MCSAPE, MCLISOL.MCSRZS,
                                        MCLISOL.MCSNRODOC, MCLISOL.MCSTLF1, MCLISOL.MCSTLF2, MCLISOL.MCSCEL,
                                        MCLISOL.MCSDIR,
                                        MCLISOL.CDPCOD, CUBIGEO.CDPDES,
                                        MCLISOL.CPVCOD, CUBIGEO1.CPVDES, 
                                        MCLISOL.CDSCOD, CUBIGEO2.CDSDES,
                                        MCLISOL.CGPCOD, CUBIGEO3.CGPDES,
                                        MCLISOL.MVICOD, MVIAS.MVIDES,
                                        MCLISOL.MCSNRO,
                                        TRIM(TRIM(CUBIGEO.CDPDES) || ' ' ||TRIM(CUBIGEO1.CPVDES) || ' ' ||TRIM(CUBIGEO2.CDSDES)|| ' ' ||TRIM(CUBIGEO3.CGPDES) || ' ' ||TRIM(MVIAS.MVIDES)|| ' ' ||TRIM(MCLISOL.MCSNRO)) AS DIRECCION
                                        FROM PRDGESTIONCOMERCIAL.MCLISOL
                                        INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO ON MCLISOL.CDPCOD = CUBIGEO.CDPCOD
                                        INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO1 ON MCLISOL.CDPCOD = CUBIGEO1.CDPCOD AND MCLISOL.CPVCOD = CUBIGEO1.CPVCOD
                                        INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO2 ON MCLISOL.CDPCOD = CUBIGEO2.CDPCOD AND MCLISOL.CPVCOD = CUBIGEO2.CPVCOD AND MCLISOL.CDSCOD = CUBIGEO2.CDSCOD
                                        INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO3 ON MCLISOL.CDPCOD = CUBIGEO3.CDPCOD AND MCLISOL.CPVCOD = CUBIGEO3.CPVCOD AND MCLISOL.CDSCOD = CUBIGEO3.CDSCOD AND MCLISOL.CGPCOD = CUBIGEO3.CGPCOD
                                        INNER JOIN PRDGESTIONCOMERCIAL.MVIAS ON MCLISOL.MVICOD = MVIAS.MVICOD ) X
                                        ON OSOLACC.MCSCOD = X.MCSCOD) Y
                                        ON OCENDOC.STAEMPCOD = Y.EMPCOD AND OCENDOC.STAOFICOD = Y.OFICOD AND OCENDOC.STAARECOD = Y.ARECOD AND OCENDOC.STACTDCOD = Y.CTDCOD
                                        AND OCENDOC.STADOCCOD = Y.DOCCOD AND OCENDOC.STASERNRO = Y.SERNRO AND OCENDOC.CDANRO = Y.SASNRO
                                        WHERE OCENDOC.STAEMPCOD = ".$oordserv ["STAEMPCOD"]." AND
                                              OCENDOC.STAOFICOD = ".$oordserv ["STAOFICOD"]." AND
                                              OCENDOC.STAARECOD = ".$oordserv ["STAARECOD"]." AND
                                              OCENDOC.STACTDCOD = ".$oordserv ["STACTDCOD"]." AND
                                              OCENDOC.STADOCCOD = ".$oordserv ["STADOCCOD"]." AND
                                              OCENDOC.STASERNRO = ".$oordserv ["STASERNRO"]." AND
                                              OCENDOC.CDANRO = ".$oordserv ["CDANRO"]."
                                        GROUP BY OCENDOC.STAEMPCOD, OCENDOC.STAOFICOD, OCENDOC.STAARECOD,
                                        OCENDOC.STACTDCOD, OCENDOC.STADOCCOD, OCENDOC.STASERNRO, OCENDOC.CDANRO,
                                        Y.MCSCOD, Y.MCSNOM, Y.MCSAPE, Y.MCSRZS,
                                        Y.MCSNRODOC, Y.MCSTLF1, Y.MCSTLF2, Y.MCSCEL,
                                        Y.CDPDES, Y.CPVDES, Y.CDSDES, Y.CGPDES, Y.MVIDES,Y.MCSNRO,
                                        Y.DIRECCION");
        return $query->result_array();
    }




}
