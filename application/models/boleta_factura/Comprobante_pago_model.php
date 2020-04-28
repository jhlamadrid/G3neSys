<?php

class Comprobante_pago_model extends CI_MODEL {

    var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
        $this->oracle->save_queries = false;
    }


/**
    FUNCIONES PARA PROFORMA
**/
    public function get_all_proforma(){
        $db_prueba = $this->load->database('oracle', TRUE); //FSCSUBTOTA, FSCSUBIGV,
        $query = $db_prueba->query("SELECT *
                                    FROM
                                        (SELECT /*+ INDEX (SFACTURAAUX,INDEX_FECHEMI) */
                                                FSCTIPO, FSCSERNRO, FSCNRO, to_char(FSCFECH, 'DD-MM-YYYY HH24:MI:SS') AS FSCFECH,
                                                FSCSUBTOTA, FSCSUBIGV, FSCTOTAL,  STPSERNRO, CDPNRO, FSCTIPDOC,
                                                FSCNRODOC, FSCCLIRUC, FSCCLINOMB, FSCESTADO, TIPDOCDESCABR,
                                                (CASE
                                                      WHEN STAEMPCOD IS NOT NULL AND STAOFICOD IS NOT NULL AND STAARECOD IS NOT NULL AND STACTDCOD IS NOT NULL AND STADOCCOD IS NOT NULL AND STASERNRO IS NOT NULL AND CDANRO IS NOT NULL AND
                                                        STPEMPCOD IS NOT NULL AND STPOFICOD IS NOT NULL AND STPARECOD IS NOT NULL AND STPCTDCOD IS NOT NULL AND STPDOCCOD IS NOT NULL AND STPSERNRO IS NOT NULL AND CDPNRO IS NOT NULL
                                                        THEN 1
                                                      WHEN STAEMPCOD IS NULL AND STAOFICOD IS NULL AND STAARECOD IS NULL AND STACTDCOD IS NULL AND STADOCCOD IS NULL AND STASERNRO IS NULL AND CDANRO IS NULL AND
                                                        STPEMPCOD IS NULL AND STPOFICOD IS NULL AND STPARECOD IS NULL AND STPCTDCOD IS NULL AND STPDOCCOD IS NULL AND STPSERNRO IS NULL AND CDPNRO IS NULL
                                                        THEN 0
                                                      ELSE NULL
                                                  END) AS CONORDPAG
                                        FROM PRDDBFCOMERCIAL.SFACTURAAUX
                                        INNER JOIN PRDDBFCOMERCIAL.TIPDOC
                                        ON PRDDBFCOMERCIAL.SFACTURAAUX.FSCTIPDOC = PRDDBFCOMERCIAL.TIPDOC.TIPDOCCOD
                                        WHERE (FSCTIPO = 1 OR FSCTIPO = 0) AND
                                               TO_CHAR(FSCFECH,'YYYYMMDD') = TO_CHAR(SYSDATE,'YYYYMMDD')
                                        ORDER BY PRDDBFCOMERCIAL.SFACTURAAUX.FSCFECH DESC )
                                    WHERE ROWNUM <=700"); // AND
                                              //(FSCESTADO = 0)
        $lista = $query->result_array();
        
        return $lista;
    }

    public function max_nro_proforma($serie, $tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MAX(FSCNRO) NRO FROM PRDDBFCOMERCIAL.SFACTURAAUX WHERE FSCSERNRO = ? AND FSCTIPO = ?", array($serie, $tipo));
        return $query->row_array();
    }
    public function editar_proforma($tipo,$proforma, $detalle){
      $this->oracle->trans_begin();
      if($tipo==1)
      {
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SFACTURAAUX
                                SET FSCSUBTOTA= ? , FSCSUBIGV = ? , FSCTOTAL = ?
                                WHERE FSCTIPO = ? AND
                                    FSCSERNRO = ? AND
                                    FSCNRO = ? ",
                                 $proforma);
      }else{
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SFACTURAAUX
                                SET FSCTOTAL = ?
                                WHERE FSCTIPO = ? AND
                                    FSCSERNRO = ? AND
                                    FSCNRO = ? ",
                                 $proforma);
      }

      if(!$query){
            $this->oracle->trans_rollback();
            return false;
        }
      foreach ($detalle as $item) {
                $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SFACTUR1AUX
                                SET PUNIT= ? , CANT = ? , ELIM = ?
                                WHERE FACCONCOD= ? AND
                                    SFACTURA_FSCSERNRO = ? AND
                                    SFACTURA_FSCNRO = ? AND
                                    SFACTURA_FSCTIPO = ? ",
                                 $item);
                if(!$query){
                    $this->oracle->trans_rollback();
                    return false;
                }
            }
        $this->oracle->trans_commit();
      return true;
    }
    public function registrar_proforma($cabecera, $detalle){
        $this->oracle->trans_begin();
        $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTURAAUX
                                            ( FSCTIPO, FSCSERNRO, FSCNRO,
                                              FSCFECH, FSCREGION, FSCZONA,
                                              FSCSECTOR, FSCLOCALID, FSCESTADO,
                                              FSCFCONT, FSCFCFEC, FSCSUBTOTA,
                                              FSCSUBIGV, FSCTOTAL, FSCCLIUNIC,
                                              FSCCLINOMB, FSCCLIRUC, FSCOFI,
                                              FSCAGE, FSCDIGCOD, SFACTUR1, FSCIGVREF,
                                              FSCTIPDOC, FSCNRODOC, FSDIREC,
                                              EMAIL, OBSDOC,
                                              STAEMPCOD, STAOFICOD, STAARECOD,
                                              STACTDCOD, STADOCCOD, STASERNRO,
                                              CDANRO, STPEMPCOD, STPOFICOD,
                                              STPARECOD, STPCTDCOD, STPDOCCOD,
                                              STPSERNRO, CDPNRO,GEMPCOD,GFICOD,
                                              GARECOD,GCTDCOD,GDOCCOD,GSERNRO,
                                              GNRO,CONCEPT_GRATUITO, TIP_AFEC_IGV,
                                              FSCTOTAL_EXO, FSCTOTAL_INAF, FSCTOTAL_GRATUITO,
                                              FSCTOTAL_GRAB )
                                              VALUES
                                            ( ?, ?, ?,
                                              SYSDATE, ?, ?,
                                              ?, ?, ?,
                                              ?, SYSDATE, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?, ?,?,
                                              ?, ?, ?, ? 
                                            )",
                                        $cabecera);
            if(!$query){
                $this->oracle->trans_rollback();
                return false;
            }

            foreach ($detalle as $item) {
                $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTUR1AUX
                                                ( SFACTURA_FSCSERNRO, SFACTURA_FSCNRO, SFACTURA_FSCTIPO,
                                                  FACCONCOD, SERFCONT, CANT,
                                                  PUNIT, FSCPRECIO, PRECIGV,
                                                  SERCOD, DRC, SERVIDOR,
                                                  OBSFACAUX, AFECIGV, GRAT,
                                                  ELIM )
                                              VALUES(
                                                    ?, ?, ?,
                                                    ?, ?, ?,
                                                    ?, ?, ?,
                                                    ?, ?, ?,
                                                    ?, ?, ?,
                                                    0
                                                )",
                                            $item);
                if(!$query){
                    $this->oracle->trans_rollback();
                    return false;
                }
            }
        $this->oracle->trans_commit();
        //$this->oracle->trans_rollback();
        return $query;
    }

    public function registrar_proforma_orden_pago($cabecera, $detalle, $orden_pago){
        $this->oracle->trans_begin();
            $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTURAAUX
                                            ( FSCTIPO, FSCSERNRO, FSCNRO,
                                              FSCFECH, FSCREGION, FSCZONA,
                                              FSCSECTOR, FSCLOCALID, FSCESTADO,
                                              FSCFCONT, FSCFCFEC, FSCSUBTOTA,
                                              FSCSUBIGV, FSCTOTAL, FSCCLIUNIC,
                                              FSCCLINOMB, FSCCLIRUC, FSCOFI,
                                              FSCAGE, FSCDIGCOD, SFACTUR1, FSCIGVREF,
                                              FSCTIPDOC, FSCNRODOC, FSDIREC,
                                              EMAIL, OBSDOC )
                                              VALUES
                                            ( ?, ?, ?,
                                              SYSDATE, ?, ?,
                                              ?, ?, ?,
                                              ?, SYSDATE, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?)",
                                        $cabecera);
            if(!$query){
                $this->oracle->trans_rollback();
                return false;
            }
            $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.PROFNS
                                            ( FSCTIPONS, FSCSERNRONS, FSCNRONS,
                                              EMPCODNS, OFICODNS, ARECODNS,
                                              CTDCODNS, DOCCODNS, SERNRONS,
                                              ORPNRONS )
                                            VALUES (
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?, ?, ?,
                                              ?
                                            )",
                                        $orden_pago);
            if(!$query){
                $this->oracle->trans_rollback();
                return false;
            }
            foreach ($detalle as $item) {
                $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTUR1AUX
                                                ( SFACTURA_FSCSERNRO, SFACTURA_FSCNRO, SFACTURA_FSCTIPO,
                                                  FACCONCOD, SERFCONT, CANT,
                                                  PUNIT, FSCPRECIO, PRECIGV,
                                                  SERCOD, DRC, SERVIDOR,
                                                  OBSFACAUX, AFECIGV, GRAT )
                                              VALUES(
                                                    ?, ?, ?,
                                                    ?, ?, ?,
                                                    ?, ?, ?,
                                                    ?, ?, ?,
                                                    ?, ?, ?
                                                )",
                                            $item);
                if(!$query){
                    $this->oracle->trans_rollback();
                    return false;
                }
            }
        $this->oracle->trans_commit();
        //$this->oracle->trans_rollback();
        return $query;
    }

    public function get_comprobante_sinpagar($documento, $serie, $comprobante){
        $data['cliente'] = $this->get_cabecera_boletafactura_sinpagar($documento, $serie, $comprobante);
        $data['descripcion'] = $this->get_descripcion_boletafactura_sinpagar($documento, $serie, $comprobante);
        return $data;
    }
    public function existe_factura($tipo, $serie, $numero){
      $db_prueba = $this->load->database('oracle', TRUE);
      $query = $db_prueba->query("SELECT
                                        SFACTURA.SUNESTADO SUNESTADO
                                    FROM PRDDBFCOMERCIAL.SFACTURA
                                    INNER JOIN PRDDBFCOMERCIAL.TIPDOC
                                    ON PRDDBFCOMERCIAL.SFACTURA.FSCTIPDOC = PRDDBFCOMERCIAL.TIPDOC.TIPDOCCOD

                                    WHERE FSCTIPO = ? AND FSCSERNRO = ? AND FSCNRO = ?", array($tipo, $serie, $numero));
        return $query->row_array();
    }

    public function get_documento_comprobante($tipo, $serie, $numero){
      $db_prueba = $this->load->database('oracle', TRUE);
      $query = $db_prueba->query("SELECT
                                        *
                                    FROM PRDDBFCOMERCIAL.SFACTURA
                                    INNER JOIN PRDDBFCOMERCIAL.TIPDOC
                                    ON PRDDBFCOMERCIAL.SFACTURA.FSCTIPDOC = PRDDBFCOMERCIAL.TIPDOC.TIPDOCCOD

                                    WHERE FSCTIPO = ? AND FSCSERNRO = ? AND FSCNRO = ?", array($tipo, $serie, $numero));
        return $query->row_array();
    }

    public function get_documento_comprobante_detalle($tipo, $serie, $numero){
       $db_prueba = $this->load->database('oracle', TRUE);
       $query = $db_prueba->query("SELECT
                                        CONCEP.FACCONCOD FACCONCOD,
                                        CONCEP.FACCONDES FACCONDES,
                                        CONCEP.GRATUITO GRATUITO,
                                        CONCEP.EXONERADO EXONERADO,
                                        CONCEP.FACIGVCOB FACIGVCOB,
                                        SFACTUR1.CANT CANT,
                                        SFACTUR1.PUNIT PUNIT,
                                        SFACTUR1.FSCPRECIO FSCPRECIO,
                                        SFACTUR1.PRECIGV PRECIGV,
                                        SFACTUR1.AFECIGV AFECIGV,
                                        SFACTUR1.GRAT GRAT
                                    FROM PRDDBFCOMERCIAL.SFACTUR1 SFACTUR1
                                    INNER JOIN PRDDBFCOMERCIAL.CONCEP CONCEP ON (CONCEP.FACCONCOD = SFACTUR1.FACCONCOD)
                                    WHERE SFACTUR1.SFACTURA_FSCTIPO = ? AND SFACTUR1.SFACTURA_FSCSERNRO = ? AND SFACTUR1.SFACTURA_FSCNRO = ? ",
                                    array($tipo, $serie, $numero));
        return $query->result_array();
    }

    public function get_cabecera_boletafactura_sinpagar($documento, $serie, $comprobante){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT
                                        *
                                    FROM PRDDBFCOMERCIAL.SFACTURAAUX 
                                    INNER JOIN PRDDBFCOMERCIAL.TIPDOC
                                    ON PRDDBFCOMERCIAL.SFACTURAAUX.FSCTIPDOC = PRDDBFCOMERCIAL.TIPDOC.TIPDOCCOD

                                    WHERE FSCTIPO = ? AND FSCSERNRO = ? AND FSCNRO = ?", array($documento, $serie, $comprobante));
        return $query->row_array();
    }

    public function get_cabecera_boletafactura_sinpagar3($documento, $serie, $comprobante){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT
                                        *
                                    FROM PRDDBFCOMERCIAL.SFACTURAAUX 
                                    INNER JOIN PRDDBFCOMERCIAL.TIPDOC
                                    ON PRDDBFCOMERCIAL.SFACTURAAUX.FSCTIPDOC = PRDDBFCOMERCIAL.TIPDOC.TIPDOCCOD

                                    WHERE FSCTIPO = ? AND stpsernro = ? AND cdpnro = ?", array($documento, $serie, $comprobante));
        return $query->row_array();
    }


    public function get_descripcion_boletafactura_sinpagar($documento, $serie, $comprobante){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT
                                        CONCEP.FACCONCOD FACCONCOD,
                                        CONCEP.FACCONDES FACCONDES,
                                        CONCEP.GRATUITO GRATUITO,
                                        CONCEP.EXONERADO EXONERADO,
                                        CONCEP.FACIGVCOB FACIGVCOB,
                                        SFACTUR1AUX.CANT CANT,
                                        SFACTUR1AUX.PUNIT PUNIT,
                                        SFACTUR1AUX.FSCPRECIO FSCPRECIO,
                                        SFACTUR1AUX.PRECIGV PRECIGV,
                                        SFACTUR1AUX.OBSFACAUX OBSFACAUX,
                                        SFACTUR1AUX.AFECIGV AFECIGV,
                                        SFACTUR1AUX.GRAT GRAT,
                                        SFACTUR1AUX.ELIM ELIM
                                    FROM PRDDBFCOMERCIAL.SFACTUR1AUX SFACTUR1AUX
                                    INNER JOIN PRDDBFCOMERCIAL.CONCEP CONCEP ON (CONCEP.FACCONCOD = SFACTUR1AUX.FACCONCOD)
                                    WHERE SFACTUR1AUX.SFACTURA_FSCTIPO = ? AND SFACTUR1AUX.SFACTURA_FSCSERNRO = ? AND SFACTUR1AUX.SFACTURA_FSCNRO = ? AND SFACTUR1AUX.ELIM = 0",
                                    array($documento, $serie, $comprobante));
        return $query->result_array();
    }

    public function get_descripcion_boletafactura_sinpagar2($documento, $serie, $comprobante){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT
                                        CONCEP.FACCONCOD FACCONCOD,
                                        CONCEP.FACCONDES FACCONDES,
                                        CONCEP.GRATUITO GRATUITO,
                                        CONCEP.EXONERADO EXONERADO,
                                        CONCEP.FACIGVCOB FACIGVCOB,
                                        SFACTUR1AUX.*

                                    FROM PRDDBFCOMERCIAL.SFACTUR1AUX SFACTUR1AUX
                                    INNER JOIN PRDDBFCOMERCIAL.CONCEP CONCEP ON (CONCEP.FACCONCOD = SFACTUR1AUX.FACCONCOD)
                                    WHERE SFACTUR1AUX.SFACTURA_FSCTIPO = ? AND SFACTUR1AUX.SFACTURA_FSCSERNRO = ? AND SFACTUR1AUX.SFACTURA_FSCNRO = ?",
                                    array($documento, $serie, $comprobante));
        /*
        $query = $db_prueba->query("SELECT
                                        *
                                    FROM PRDDBFCOMERCIAL.SFACTUR1AUX SFACTUR1AUX
                                    WHERE SFACTUR1AUX.SFACTURA_FSCTIPO = ? AND SFACTUR1AUX.SFACTURA_FSCSERNRO = ? AND SFACTUR1AUX.SFACTURA_FSCNRO = ?",
                                    array($documento, $serie, $comprobante));*/
        return $query->result_array();
    }

    public function get_cabecera_proforma($documento, $serie, $comprobante){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT *
                                    FROM PRDDBFCOMERCIAL.SFACTURAAUX
                                    WHERE FSCTIPO = ? AND FSCSERNRO = ? AND FSCNRO = ?", array($documento, $serie, $comprobante));
        return $query->row_array();
    }

    public function get_oordpag($tipo, $serie, $numero){
        $query = $this->oracle->query('SELECT *
                                FROM PRDDBFCOMERCIAL.PROFNS
                                INNER JOIN PRDGESTIONCOMERCIAL.OORDPAG
                                ON
                                    EMPCOD = EMPCODNS AND
                                    OFICOD = OFICODNS AND
                                    ARECOD = ARECODNS AND
                                    CTDCOD = CTDCODNS AND
                                    DOCCOD = DOCCODNS AND
                                    SERNRO = SERNRONS AND
                                    ORPNRO = ORPNRONS
                                WHERE
                                    FSCSERNRONS = ? AND
                                    FSCNRONS = ? AND
                                    FSCTIPONS = ?',
                            array($tipo, $serie, $numero));
        return $query;
    }

    public function get_profns($tipo, $serie, $numero){
        $query = $this->oracle->query('SELECT *
                                        FROM PRDDBFCOMERCIAL.PROFNS
                                        WHERE
                                            FSCSERNRONS = ? AND
                                            FSCNRONS = ? AND
                                            FSCTIPONS = ?',
                                        array($serie, $numero, $tipo));
        return $query->row_array();
    }

/**
    FUNCIONES PARA LA TABLA FACTURA
**/
    /*public function max_nro_comprobante_sunat($serie, $tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MAX(TO_NUMBER(SUNFACNRO)) NRO
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCSERNRO = ? AND FSCTIPO = ?",
                                    array($serie, $tipo));
        return $query->row_array();
    }*/

    public function max_nro_comprobante_sunat2($serie_sunat, $tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MAX(TO_NUMBER(SUNFACNRO)) NRO
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE SUNSERNRO = ? AND FSCTIPO = ?",
                                    array($serie_sunat, $tipo));
        return $query->row_array();
    }

    public function max_nro_comprobante_sedalib($serie, $tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MAX(FSCNRO) NRO
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCSERNRO = ? AND FSCTIPO = ?",
                                    array($serie, $tipo));
        return $query->row_array();
    }

    /*public function get_ultima_factura_boleta_ingresada($serie, $tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query('SELECT *
                                        FROM PRDGESTIONCOMERCIAL.CSERIES
                                        WHERE EMPCOD=? AND OFICOD=? AND ARECOD=? AND
                                        CTDCOD = 1 AND DOCCOD = ? AND SERNRO = ?',
                                    array($_SESSION['NSEMPCOD'], $_SESSION['NSOFICOD'], $_SESSION['NSARECOD'], $serie, $tipo));
        return $query->row_array();
    }*/

    public function get_cabecera_boletafactura($tipo, $serie, $numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT *
                                    FROM PRDDBFCOMERCIAL.SFACTURA
                                    INNER JOIN PRDDBFCOMERCIAL.TIPDOC
                                    ON PRDDBFCOMERCIAL.SFACTURA.FSCTIPDOC = PRDDBFCOMERCIAL.TIPDOC.TIPDOCCOD
                                    WHERE FSCTIPO = ? AND FSCSERNRO = ? AND FSCNRO = ?", array($tipo, $serie, $numero));
        return $query->row_array();
    }

    public function get_descripcion_boletafactura($tipo, $serie, $numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT
                                        CONCEP.FACCONCOD FACCONCOD,
                                        CONCEP.FACCONDES FACCONDES,
                                        CONCEP.GRATUITO GRATUITO,
                                        CONCEP.EXONERADO EXONERADO,
                                        CONCEP.FACIGVCOB FACIGVCOB,
                                        SFACTUR1.CANT CANT,
                                        SFACTUR1.PUNIT PUNIT,
                                        SFACTUR1.FSCPRECIO FSCPRECIO,
                                        SFACTUR1.PRECIGV PRECIGV,
                                        SFACTUR1.OBSFACAUX OBSFACAUX,
                                        SFACTUR1.AFECIGV AFECIGV,
                                        SFACTUR1.GRAT GRAT
                                    FROM PRDDBFCOMERCIAL.SFACTUR1 SFACTUR1
                                    INNER JOIN PRDDBFCOMERCIAL.CONCEP CONCEP ON (CONCEP.FACCONCOD = SFACTUR1.FACCONCOD)
                                    WHERE SFACTUR1.SFACTURA_FSCTIPO = ? AND SFACTUR1.SFACTURA_FSCSERNRO = ? AND SFACTUR1.SFACTURA_FSCNRO = ?",
                                    array($tipo, $serie, $numero));
        return $query->result_array();
    }

     public function registrar_factura_metodo2($cliente, $descripcion, $serie_prof, $nv_nro_sunat, $nv_nro_sedalib, $dir_ws, $dir_pdf, $firma){

        // CARGAMOS TIPOS DE COMPROBANTES SEGUN LA BASE DE DATOS PRDGESTIONCOMERCIAL
        // PARA LA BASE DE DATOS PRDDBFCOMERCIAL LOS TIPOS SON LOS SIGUIENTES
        //      0 = BOLETA
        //      1 = FACTURA
        $l_comprobantes = $this->get_tipos_comprobante();
        //BUSCAMOS EL TIPO DE DOCUMENTO PERTENECIENTE A LA PROFORMA
        $idx = -1;
        $doc_tip=0;
        $dato_oracle_11g=-1;
        if($cliente['FSCTIPO']=='0'){
            $doc_tip=2;
            $dato_oracle_11g=5;
            $idx = array_search('BOLETA', array_column($l_comprobantes, 'DOCABR'));
        }else if($cliente['FSCTIPO']=='1'){
            $doc_tip=1;
            $dato_oracle_11g=4;
            $idx = array_search('FACTURA', array_column($l_comprobantes, 'DOCABR'));
        }else{
            return false;
        }
        $aux['CTDCOD'] = $l_comprobantes[$idx]['CTDCOD'];
        $aux['DOCCOD'] = $l_comprobantes[$idx]['DOCCOD'];
        $orden_pag= -1;
        if($cliente['CDPNRO'] != null){
          $orden_pag=$cliente['CDPNRO'];
        }
        // REGISTRAMOS EN SFACTURA

        $relacion_empre= $this -> Empre_pagos();
        // para la tabla de pagos 
        $dato_cajera = $this -> obtengo_cajera();
        $maximo_de_pagos = $this -> maximo_de_pagos($dato_oracle_11g, $serie_prof, $nv_nro_sedalib);
        if( $relacion_empre != null  && $dato_cajera != null ){
            $this->oracle->trans_begin();
            
            $resulta = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTURA
                                              (   FSCSERNRO,
                                                  FSCNRO, FSCTIPO,
                                                  FSCFECH,
                                                  FSCREGION, FSCZONA, FSCSECTOR, FSCLOCALID,
                                                  FSCESTADO,
                                                  FSCFCONT,
                                                  FSCFCFEC,
                                                  FSCSUBTOTA, FSCSUBIGV, FSCTOTAL,
                                                  FSCCLIUNIC, FSCCLINOMB, FSCCLIRUC,
                                                  FSCOFI, FSCAGE, FSCDIGCOD,
                                                  FSCESFEC,
                                                  SFACTUR1,
                                                  DRC,
                                                  FSCOFIPAG, FSCAGEPAG, FSCUSRPAG,
                                                  FSCTICKT,
                                                  FSCIGVREF,
                                                  FSCTIPDOC, FSCNRODOC,
                                                  FRECWS,
                                                  SUNSERNRO, SUNFACNRO,
                                                  DIRARCHWS,DIRARCHPDF,SUNFIRMA,
                                                  OBSWS,
                                                  FSDIREC, EMAIL, OBSDOC,
                                                  SUNESTADO,FSCHRA , CONCEPT_GRATUITO,
                                                  TOT_EXONERADO, TOT_INAFECTO, TOT_GRATUITO,
                                                  TOT_GRABADO
                                              ) VALUES (
                                                  ?, ?, ?,
                                                  TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  ?, ?, ?, ?,
                                                  1,
                                                  0,
                                                  TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  0,
                                                  0,
                                                  ?, ?, ?,
                                                  0,
                                                  ?,
                                                  ?, ?,
                                                  null,
                                                  ?, ?,
                                                  ?, ?, ?,
                                                  null,
                                                  ?, ?, ?,
                                                  ?, TO_CHAR(SYSDATE,'HH:MI:SS'), ?,
                                                  ?, ?, ?,
                                                  ? ) ",
                                          array( $cliente['FSCSERNRO'],
                                                  $nv_nro_sedalib, $cliente['FSCTIPO'],
                                                  //FECHA DE REGISTRO POR EL SISTEMA
                                                  $_SESSION['FSCREGION'], $_SESSION['FSCZONA'], $_SESSION['FSCSECTOR'], $_SESSION['FSCLOCALID'],
                                                  //0 PENDIENTE A PAGO, 1 PAGADO, 2 ANULADO
                                                  //0
                                                  //FECHA POR EL SISTEMA
                                                  $cliente['FSCSUBTOTA'], $cliente['FSCSUBIGV'], $cliente['FSCTOTAL'],
                                                  $cliente['FSCCLIUNIC'], $cliente['FSCCLINOMB'], $cliente['FSCCLIRUC'],
                                                  $cliente['FSCOFI'], $cliente['FSCAGE'], $cliente['FSCDIGCOD'],
                                                  //
                                                  //
                                                  //
                                                  $_SESSION['OFICOD'], $_SESSION['OFIAGECOD'], $_SESSION['user_id'],
                                                  //
                                                  $cliente['FSCIGVREF'],
                                                  $cliente['FSCTIPDOC'], $cliente['FSCNRODOC'],
                                                  //FECHA DE ENVIO A WEB-SERVICE
                                                  ($cliente['FSCTIPO']==1)? 'F'.$cliente['FSCSERNRO']:'B'.$cliente['FSCSERNRO'], $nv_nro_sunat,
                                                  $dir_ws,$dir_pdf, $firma,
                                                  //
                                                  $cliente['FSDIREC'], $cliente['EMAIL'], $cliente['OBSDOC'],
                                                  // ESTADO SUNAT
                                                  // 1    EMITIDO Comprobante de Pago Creada en Base de Datos
                                                  1, $cliente['CONCEPT_GRATUITO'], $cliente['FSCTOTAL_EXO'],
                                                  $cliente['FSCTOTAL_INAF'], $cliente['FSCTOTAL_GRATUITO'], $cliente['FSCTOTAL_GRAB'] ));
            
            //echo var_dump($resulta);
            
            //exit();
            
            
            if($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }
            $this->oracle->query("INSERT INTO PRDGESTIONCOMERCIAL.OCOMPAG
                                            ( EMPCOD, OFICOD, ARECOD,
                                              CTDCOD, DOCCOD,
                                              SERNRO,
                                              CMPNRO,
                                              CMPFCHEMI, CMPFCHVEN,
                                              CLICOD,
                                              SCPCOD,
                                              USRCOD,
                                              STUSRCOMUPD,
                                              CMPFCHUPD, CMPHRAUPD,
                                              CMPCLINOM, CMPCLIDIR, CMPCLIDOC,
                                              CMPIGVREF,
                                              CMPSUMVTA, CMPSUMIGV, CMPTOTGRL
                                            )
                                            VALUES(
                                                ?, ?, ?,
                                                ?, ?, ?, ?,
                                               TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS'),
                                                ?, ?, ?,
                                                ?,
                                                ?, ?, ?
                                            )",
                                        array($cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                              $cliente['GCTDCOD'], $cliente['GDOCCOD'],
                                              $cliente['GSERNRO'],
                                              $nv_nro_sedalib,
                                              "99999999999",
                                              2, // 1 PENDIENTE DE PAGO, 2 PAGADO, 3 ANULADO
                                              $_SESSION['user_comercial'], 
                                              //$cliente['FSCDIGCOD'], // USUARIO QUE REGISTRO LA PROFORMA
                                              //$_SESSION['user_id'], // USUARIO QUE REGISTRA PAGO
                                              $_SESSION['user_comercial'],
                                              //
                                              substr($cliente['FSCCLINOMB'], 0, 59), substr($cliente['FSDIREC'], 0, 59), (($cliente['FSCCLIRUC']!=null)? $cliente['FSCCLIRUC']:$cliente['FSCNRODOC'] ),
                                              $cliente['FSCIGVREF'],
                                              $cliente['FSCSUBTOTA'], $cliente['FSCSUBIGV'], $cliente['FSCTOTAL']
                                              ));
            if($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }
          //detalle de la factura
          foreach($descripcion as $item){
                $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTUR1
                                           ( SFACTURA_FSCSERNRO, SFACTURA_FSCNRO, SFACTURA_FSCTIPO,
                                              FACCONCOD, SERFCONT, SERFCFEC,
                                              CANT, PUNIT, FSCPRECIO,
                                              PRECIGV, SERCOD, DRC, SERVIDOR,
                                              OBSFACAUX, AFECIGV, GRAT
                                            )
                                            VALUES
                                                  ( ?, ?, ?,
                                                    ?, ? ,?,
                                                    ?, ?, ?,
                                                    ?, ?, ?, ?,
                                                    ?, ?, ?
                                                  )",
                                      array( $cliente['FSCSERNRO'], $nv_nro_sedalib, $item['SFACTURA_FSCTIPO'],
                                             $item['FACCONCOD'], $item['SERFCONT'], $item['SERFCFEC'],
                                             $item['CANT'], $item['PUNIT'], $item['FSCPRECIO'],
                                            $item['PRECIGV'], $item['SERCOD'], $item['DRC'], $item['SERVIDOR'],
                                            $item['OBSFACAUX'], $item['AFECIGV'], $item['GRAT']));
                if($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                }

                $this->oracle->query("INSERT INTO PRDGESTIONCOMERCIAL.OCOMPAG1
                                                  ( EMPCOD, OFICOD, ARECOD,
                                                    CTDCOD, DOCCOD, SERNRO,
                                                    CMPNRO, CPTCOD, CMPCNT,
                                                    STUNDOCPCOD, CMPPREUNT,
                                                    CMPPREVTA, CMPIGVVAL, CMPIMP)
                                                  VALUES (
                                                      ?, ?, ?,
                                                      ?, ?, ?,
                                                      ?, ?, ?,
                                                      0, ?,
                                                      ?, ?, ?
                                                      )",
                                              array($cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                                    $cliente['GCTDCOD'], $cliente['GDOCCOD'],
                                                    $cliente['GSERNRO'],
                                                    $nv_nro_sedalib,
                                                    $item['FACCONCOD'], $item['CANT'], $item['PUNIT'],
                                                    $item['FSCPRECIO'], $item['PRECIGV'], ($item['FSCPRECIO']+$item['PRECIGV'])
                                              ));
                if($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                }
          }

          if($cliente['STAEMPCOD'] != NULL && $cliente['STAOFICOD'] != NULL && $cliente['STAARECOD'] != NULL &&
              $cliente['STACTDCOD'] != NULL && $cliente['STADOCCOD'] != NULL && $cliente['STASERNRO'] != NULL &&
              $cliente['CDANRO'] != NULL && $cliente['STPEMPCOD'] != NULL && $cliente['STPOFICOD'] != NULL && $cliente['STPARECOD'] != NULL ){


              //Relaciono al cliente con el comprobante de pago (boleta o factura)

                $this->oracle->query("INSERT INTO PRDGESTIONCOMERCIAL.OCENDOC
                                              (   STAEMPCOD, STAOFICOD, STAARECOD,
                                                  STACTDCOD, STADOCCOD, STASERNRO,
                                                  CDANRO,
                                                  STPEMPCOD, STPOFICOD, STPARECOD,
                                                  STPCTDCOD, STPDOCCOD,
                                                  STPSERNRO,
                                                  CDPNRO
                                              ) VALUES (
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  ?,
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  ?
                                              )",
                                          array($cliente['STAEMPCOD'], $cliente['STAOFICOD'], $cliente['STAARECOD'],
                                                  $cliente['STACTDCOD'], $cliente['STADOCCOD'], $cliente['STASERNRO'],
                                                  $cliente['CDANRO'],
                                                 $cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                                 $cliente['GCTDCOD'], $cliente['GDOCCOD'],
                                                 $cliente['GSERNRO'],
                                                  $nv_nro_sedalib));
              if($this->oracle->trans_status() === FALSE){
                  $this->oracle->trans_rollback();
                  return false;
              }
               
               /*var_dump( array($_SESSION['user_comercial'],
                                                  $cliente['STPEMPCOD'], $cliente['STPOFICOD'], $cliente['STPARECOD'],
                                                  3, 4, $cliente['STASERNRO'], $orden_pag ));*/
              if($orden_pag != -1){
                    $this->oracle->query("UPDATE PRDGESTIONCOMERCIAL.OORDPAG
                                                  SET
                                                  SORCOD = 2, STUSROOPUPD = ?
                                                  WHERE EMPCOD = ? AND OFICOD = ? AND ARECOD = ? AND
                                                  CTDCOD = ? AND DOCCOD = ? AND SERNRO = ?
                                                  AND ORPNRO = ? AND SORCOD = 1 AND
                                                  ORPTOT > 0
                                          ",
                                          array($_SESSION['user_comercial'],
                                                  $cliente['STPEMPCOD'], $cliente['STPOFICOD'], $cliente['STPARECOD'],
                                                  3, 4, $cliente['STPSERNRO'], $orden_pag ));

                    if($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
                    }
              }
             
          }
          //******* INSERCION EN OPAGOS *******
          $max_correlativo= $this -> max_correlativo();
          $maximo_correlativo = $max_correlativo[0]["NRO"] + 1 ; // LA EMPRESA RELACIONADA
          
          $this->oracle->query("INSERT INTO  PRDGESTIONCOMERCIAL.OPAGOS
                                              ( EMPCOD, OFICOD, ARECOD,CTDCOD,DOCCOD,SERNRO,
                                                CMPNRO, PAGNROOPE , EMSCOD , CCBCOD , STUSRPAGCOD, PAGIMP,
                                                PAGFCHREG , PAGFCHPAG , PAGFCHPEF , PAGHRAPEF , STPGEMPCOD ,STPGOFICOD ,
                                                STPGARECOD , SPGCOD) VALUES
                                                (? , ? , ? , ? ,
                                                 ? , ? , ? , ? ,
                                                 ? , ? , ? , ? ,
                                                 TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                 TO_CHAR(SYSDATE,'HH:MI:SS'),
                                                 ? , ? , ? , ? )" ,
                                            array( $cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                                  1 , $doc_tip , $serie_prof ,$nv_nro_sedalib ,$maximo_correlativo ,
                                                  $relacion_empre[0]["EMSCOD"] ,$relacion_empre[0]["CCBCOD"] , $relacion_empre[0]["USRCOD"] ,
                                                  $cliente['FSCTOTAL'] ,$cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'], 1));
          if($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
          }
          //REVISAR SI LA PROFORMA VIENE DE UNA ORDEN DE PAGO
          // SI ES ASI GUARDAR EN OORDPAG SINO CONCLUYO EL PROCESO
          // ACTUALIZAR SFACTURAAUX ESTADO DE 0 a 1
            $this->oracle->query('UPDATE PRDDBFCOMERCIAL.SFACTURAAUX
                                      SET FSCESTADO = 1 , STPCTDCOD = ? , STPDOCCOD = ? , STPSERNRO = ? , CDPNRO = ?
                                      WHERE FSCSERNRO = ? AND
                                          FSCNRO = ? AND
                                          FSCTIPO = ? ',
                                      array(1 , $doc_tip , $serie_prof ,$nv_nro_sedalib , $cliente['FSCSERNRO'], $cliente['FSCNRO'], $cliente['FSCTIPO'],

                                  ));
            if($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
            }
          
          // PARA LA INSERCION EN EL PRDRECAUDACIONORA11G

            $this->oracle->query("INSERT INTO  PRDRECAUDACIONORA12C.MDOCGLB
                                              ( ESECOD, MDCCOD, MDGSERDOC, MDGNRODOC, MDGCODACC1, MDGCODACC2,MDGCODACC3, MDGFCHEMIDOC,MDGFCHVTODOC,MDGFCHVTOCOB,MDGFCHREG, MDGHRAREG, MDGIMPTOT, OPSCOD, SDGCOD, MDGMSJFIN, MDGFCHLSTUPD, MDGHRALSTUPD, MDGDNINUM, MDGDNIFREG, MDGDNIHREG ) VALUES
                                                (?, ?, ?, ?, ?, ?, ?,
                                                 TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS') , ?, ?, ?,
                                                 ?, TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS'), ?, TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS') )" ,
                                            array(1, $dato_oracle_11g, $serie_prof, $nv_nro_sedalib, 0,  ($cliente['FSCCLIRUC']!=null) ? trim($cliente['FSCCLIRUC']) : trim($cliente['FSCNRODOC']), substr($cliente['FSCCLINOMB'], 0, 64),
                                                $cliente['FSCTOTAL'], NULL, 2,
                                                NULL, ($cliente['FSCNRODOC']!=null) ? trim($cliente['FSCNRODOC']) : NULL ));
            if($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }

            if($maximo_de_pagos !=null){
                $maximo_de_pagos1 = $maximo_de_pagos[0]["NRO"] + 1 ;
            }else{
                $maximo_de_pagos1=1;
            }
          
            $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.OPAGOS
                                              ( ESECOD, MDCCOD, MDGSERDOC, MDGNRODOC, OPGNROOPE, OPGFCHREG, OPGHRAREG, OPGFCHPAG,
                                                OPGHRAPAG, OPGFCHPEF, OPGHRAPEF, OPGIMPPAG, OPCCOD, ECOCOD, PTCCOD, CJACOD,
                                                STECOCOD, VOEITEM, USRCOD, OPCJITM, TPGCOD, SPGCOD, OPGIMPCAR, OPGIMPINT, 
                                                OPGIMPENT, OPGEMPVUE, OPGREFBO, OPGPAGINTSW, OPGPAGCARSW, OPGUSRAUX, OPGFCHAUX, OPGHRAAUX,
                                                OPGADDIP) VALUES
                                                ( ?, ?, ?, ?, ?,TO_CHAR(SYSDATE,'DD-MON-YYYY') ,TO_CHAR(SYSDATE,'HH:MI:SS'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  TO_CHAR(SYSDATE,'HH:MI:SS'), TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'HH:MI:SS'), ?, ?, ?, ?, ?,
                                                  ?, ?, ?, ?, ?, ?, ?, ?,
                                                  ?, ?, ?, ?, ?, ?, ?, ?,
                                                  ? )" ,
                                            array(1, $dato_oracle_11g, $serie_prof, $nv_nro_sedalib,$maximo_de_pagos1,
                                                  $cliente['FSCTOTAL'],0, $dato_cajera[0]['ECOCOD'], $dato_cajera[0]['PTCCOD'], $dato_cajera[0]['CJACOD'],
                                                  $dato_cajera[0]['STECOCOD'], 1, $dato_cajera[0]['USRCOD'],0 ,1 ,1, 0, 0,
                                                  0, 0, 0, 0, 0, 0, NULL, NULL,
                                                  NULL ));
            if($this->oracle->trans_status() === FALSE){
                        $this->oracle->trans_rollback();
                        return false;
            }

          $this->oracle->trans_commit();
          return true;


        }else{
          return false;
        }
       
    }

    public function Gravar_Error($serie_sedalib,$nro_sedalib,$tipo,$serie_sunat,$nro_sunat,$log_error){
      $this->oracle->trans_begin();
      $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.LOG_ERROR_FE
                                              ( FSCSERNRO ,                                       
                                                FSCNRO ,
                                                FSCTIP ,
                                                SUNSERNRO ,
                                                SUNNRO ,
                                                LOG_FECH ,
                                                LOG_HRA ,
                                                LOG_ERROR   
                                              ) VALUES (
                                                  ?, 
                                                  ?,
                                                  ?,
                                                  ?,
                                                  ?, 
                                                  TO_CHAR(SYSDATE,'DD-MON-YYYY'), 
                                                  TO_CHAR(SYSDATE,'HH:MI:SS'), 
                                                  ?  ) ",
                                              array( $serie_sedalib,
                                                 $nro_sedalib, 
                                                 $tipo, 
                                                 $serie_sunat,
                                                 $nro_sunat,
                                                 substr($log_error, 0, 1500)
                                               ) );
       if(!$query){
        $this->oracle->trans_rollback();
        return false;
      }
      $this->oracle->trans_commit();
      return true ;
    }

    public function registrar_factura($cliente, $descripcion, $serie_prof, $nv_nro_sunat, $nv_nro_sedalib){

        // CARGAMOS TIPOS DE COMPROBANTES SEGUN LA BASE DE DATOS PRDGESTIONCOMERCIAL
        // PARA LA BASE DE DATOS PRDDBFCOMERCIAL LOS TIPOS SON LOS SIGUIENTES
        //      0 = BOLETA
        //      1 = FACTURA
        $l_comprobantes = $this->get_tipos_comprobante();
        //BUSCAMOS EL TIPO DE DOCUMENTO PERTENECIENTE A LA PROFORMA
        $idx = -1;
        $doc_tip=0;
        $dato_oracle_11g=-1;
        if($cliente['FSCTIPO']=='0'){
            $doc_tip=2;
            $dato_oracle_11g=5;
            $idx = array_search('BOLETA', array_column($l_comprobantes, 'DOCABR'));
        }else if($cliente['FSCTIPO']=='1'){
            $doc_tip=1;
            $dato_oracle_11g=4;
            $idx = array_search('FACTURA', array_column($l_comprobantes, 'DOCABR'));
        }else{
            return false;
        }
        $aux['CTDCOD'] = $l_comprobantes[$idx]['CTDCOD'];
        $aux['DOCCOD'] = $l_comprobantes[$idx]['DOCCOD'];
        $orden_pag= -1;
        if($cliente['CDPNRO'] != null){
          $orden_pag=$cliente['CDPNRO'];
        }
        // REGISTRAMOS EN SFACTURA

        $relacion_empre= $this -> Empre_pagos();
        // para la tabla de pagos 
        $dato_cajera = $this -> obtengo_cajera();
        $maximo_de_pagos = $this -> maximo_de_pagos($dato_oracle_11g, $serie_prof, $nv_nro_sedalib);
        if( $relacion_empre != null  && $dato_cajera != null ){
          $this->oracle->trans_begin();
          $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTURA
                                              (   FSCSERNRO,
                                                  FSCNRO, FSCTIPO,
                                                  FSCFECH,
                                                  FSCREGION, FSCZONA, FSCSECTOR, FSCLOCALID,
                                                  FSCESTADO,
                                                  FSCFCONT,
                                                  FSCFCFEC,
                                                  FSCSUBTOTA, FSCSUBIGV, FSCTOTAL,
                                                  FSCCLIUNIC, FSCCLINOMB, FSCCLIRUC,
                                                  FSCOFI, FSCAGE, FSCDIGCOD,
                                                  FSCESFEC,
                                                  SFACTUR1,
                                                  DRC,
                                                  FSCOFIPAG, FSCAGEPAG, FSCUSRPAG,
                                                  FSCTICKT,
                                                  FSCIGVREF,
                                                  FSCTIPDOC, FSCNRODOC,
                                                  FRECWS,
                                                  SUNSERNRO, SUNFACNRO,
                                                  DIRARCHWS,
                                                  OBSWS,
                                                  FSDIREC, EMAIL, OBSDOC,
                                                  SUNESTADO
                                              ) VALUES (
                                                  ?, ?, ?,
                                                  TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  ?, ?, ?, ?,
                                                  1,
                                                  0,
                                                  TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  0,
                                                  0,
                                                  ?, ?, ?,
                                                  0,
                                                  ?,
                                                  ?, ?,
                                                  null,
                                                  ?, ?,
                                                  null,
                                                  null,
                                                  ?, ?, ?,
                                                  ?) ",
                                          array( $cliente['FSCSERNRO'],
                                                  $nv_nro_sedalib, $cliente['FSCTIPO'],
                                                  //FECHA DE REGISTRO POR EL SISTEMA
                                                  $_SESSION['FSCREGION'], $_SESSION['FSCZONA'], $_SESSION['FSCSECTOR'], $_SESSION['FSCLOCALID'],
                                                  //0 PENDIENTE A PAGO, 1 PAGADO, 2 ANULADO
                                                  //0
                                                  //FECHA POR EL SISTEMA
                                                  $cliente['FSCSUBTOTA'], $cliente['FSCSUBIGV'], $cliente['FSCTOTAL'],
                                                  $cliente['FSCCLIUNIC'], $cliente['FSCCLINOMB'], $cliente['FSCCLIRUC'],
                                                  $cliente['FSCOFI'], $cliente['FSCAGE'], $cliente['FSCDIGCOD'],
                                                  //
                                                  //
                                                  //
                                                  $_SESSION['OFICOD'], $_SESSION['OFIAGECOD'], $_SESSION['user_id'],
                                                  //
                                                  $cliente['FSCIGVREF'],
                                                  $cliente['FSCTIPDOC'], $cliente['FSCNRODOC'],
                                                  //FECHA DE ENVIO A WEB-SERVICE
                                                  ($cliente['FSCTIPO']==1)? 'F'.$cliente['FSCSERNRO']:'B'.$cliente['FSCSERNRO'], $nv_nro_sunat,
                                                  $cliente['FSDIREC'], $cliente['EMAIL'], $cliente['OBSDOC'],
                                                  // ESTADO SUNAT
                                                  // 1    EMITIDO Comprobante de Pago Creada en Base de Datos
                                                  1 ));
          if(!$query){
              $this->oracle->trans_rollback();
              return false;
          }
          $query = $this->oracle->query("INSERT INTO PRDGESTIONCOMERCIAL.OCOMPAG
                                            ( EMPCOD, OFICOD, ARECOD,
                                              CTDCOD, DOCCOD,
                                              SERNRO,
                                              CMPNRO,
                                              CMPFCHEMI, CMPFCHVEN,
                                              CLICOD,
                                              SCPCOD,
                                              USRCOD,
                                              STUSRCOMUPD,
                                              CMPFCHUPD, CMPHRAUPD,
                                              CMPCLINOM, CMPCLIDIR, CMPCLIDOC,
                                              CMPIGVREF,
                                              CMPSUMVTA, CMPSUMIGV, CMPTOTGRL
                                            )
                                            VALUES(
                                                ?, ?, ?,
                                                ?, ?, ?, ?,
                                               TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS'),
                                                ?, ?, ?,
                                                ?,
                                                ?, ?, ?
                                            )",
                                        array($cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                              $cliente['GCTDCOD'], $cliente['GDOCCOD'],
                                              $cliente['GSERNRO'],
                                              $nv_nro_sedalib,
                                              $cliente['FSCCLIUNIC'],
                                              2, // 1 PENDIENTE DE PAGO, 2 PAGADO, 3 ANULADO
                                              $_SESSION['user_comercial'], 
                                              //$cliente['FSCDIGCOD'], // USUARIO QUE REGISTRO LA PROFORMA
                                              //$_SESSION['user_id'], // USUARIO QUE REGISTRA PAGO
                                              $_SESSION['user_comercial'],
                                              //
                                              substr($cliente['FSCCLINOMB'], 0, 59), substr($cliente['FSDIREC'], 0, 59), (($cliente['FSCCLIRUC']!=null)? $cliente['FSCCLIRUC']:$cliente['FSCNRODOC'] ),
                                              $cliente['FSCIGVREF'],
                                              $cliente['FSCSUBTOTA'], $cliente['FSCSUBIGV'], $cliente['FSCTOTAL']
                                              ));
          if(!$query){
              $this->oracle->trans_rollback();
              return false;
          }
          //detalle de la factura
          foreach($descripcion as $item){
              $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.SFACTUR1
                                                  ( SFACTURA_FSCSERNRO,SFACTURA_FSCNRO, SFACTURA_FSCTIPO,
                                                    FACCONCOD, SERFCONT, SERFCFEC,
                                                    CANT, PUNIT, FSCPRECIO,
                                                    PRECIGV, SERCOD, DRC, SERVIDOR,
                                                    OBSFACAUX, AFECIGV, GRAT
                                                  )
                                                  VALUES
                                                  ( ?, ?, ?,
                                                    ?, ? ,?,
                                                    ?, ?, ?,
                                                    ?, ?, ?, ?,
                                                    ?, ?, ?
                                                  )",
                                         array( $cliente['FSCSERNRO'], $nv_nro_sedalib, $item['SFACTURA_FSCTIPO'],
                                                  $item['FACCONCOD'], $item['SERFCONT'], $item['SERFCFEC'],
                                                  $item['CANT'], $item['PUNIT'], $item['FSCPRECIO'],
                                                  $item['PRECIGV'], $item['SERCOD'], $item['DRC'], $item['SERVIDOR'],
                                                  $item['OBSFACAUX'], $item['AFECIGV'], $item['GRAT']));
              if(!$query){
                  $this->oracle->trans_rollback();
                  return false;
              }

              $query = $this->oracle->query("INSERT INTO PRDGESTIONCOMERCIAL.OCOMPAG1
                                                  ( EMPCOD, OFICOD, ARECOD,
                                                    CTDCOD, DOCCOD, SERNRO,
                                                    CMPNRO, CPTCOD, CMPCNT,
                                                    STUNDOCPCOD, CMPPREUNT,
                                                    CMPPREVTA, CMPIGVVAL, CMPIMP)
                                                  VALUES (
                                                      ?, ?, ?,
                                                      ?, ?, ?,
                                                      ?, ?, ?,
                                                      0, ?,
                                                      ?, ?, ?
                                                      )",
                                              array($cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                                    $cliente['GCTDCOD'], $cliente['GDOCCOD'],
                                                    $cliente['GSERNRO'],
                                                    $nv_nro_sedalib,
                                                    $item['FACCONCOD'], $item['CANT'], $item['PUNIT'],
                                                    $item['FSCPRECIO'], $item['PRECIGV'], ($item['FSCPRECIO']+$item['PRECIGV'])
                                              ));
              if(!$query){
                  $this->oracle->trans_rollback();
                  return false;
              }
          }

          if($cliente['STAEMPCOD'] != NULL && $cliente['STAOFICOD'] != NULL && $cliente['STAARECOD'] != NULL &&
              $cliente['STACTDCOD'] != NULL && $cliente['STADOCCOD'] != NULL && $cliente['STASERNRO'] != NULL &&
              $cliente['CDANRO'] != NULL && $cliente['STPEMPCOD'] != NULL && $cliente['STPOFICOD'] != NULL && $cliente['STPARECOD'] != NULL ){


              //Relaciono al cliente con el comprobante de pago (boleta o factura)

              $query = $this->oracle->query("INSERT INTO PRDGESTIONCOMERCIAL.OCENDOC
                                              (   STAEMPCOD, STAOFICOD, STAARECOD,
                                                  STACTDCOD, STADOCCOD, STASERNRO,
                                                  CDANRO,
                                                  STPEMPCOD, STPOFICOD, STPARECOD,
                                                  STPCTDCOD, STPDOCCOD,
                                                  STPSERNRO,
                                                  CDPNRO
                                              ) VALUES (
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  ?,
                                                  ?, ?, ?,
                                                  ?, ?, ?,
                                                  ?
                                              )",
                                          array($cliente['STAEMPCOD'], $cliente['STAOFICOD'], $cliente['STAARECOD'],
                                                  $cliente['STACTDCOD'], $cliente['STADOCCOD'], $cliente['STASERNRO'],
                                                  $cliente['CDANRO'],
                                                 $cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                                 $cliente['GCTDCOD'], $cliente['GDOCCOD'],
                                                 $cliente['GSERNRO'],
                                                  $nv_nro_sedalib));
              if(!$query){
                  $this->oracle->trans_rollback();
                  return false;
              }
               
               /*var_dump( array($_SESSION['user_comercial'],
                                                  $cliente['STPEMPCOD'], $cliente['STPOFICOD'], $cliente['STPARECOD'],
                                                  3, 4, $cliente['STASERNRO'], $orden_pag ));*/
              if($orden_pag != -1){
                 $query = $this->oracle->query("UPDATE PRDGESTIONCOMERCIAL.OORDPAG
                                                  SET
                                                  SORCOD = 2, STUSROOPUPD = ?
                                                  WHERE EMPCOD = ? AND OFICOD = ? AND ARECOD = ? AND
                                                  CTDCOD = ? AND DOCCOD = ? AND SERNRO = ?
                                                  AND ORPNRO = ? AND SORCOD = 1 AND
                                                  ORPTOT > 0
                                          ",
                                          array($_SESSION['user_comercial'],
                                                  $cliente['STPEMPCOD'], $cliente['STPOFICOD'], $cliente['STPARECOD'],
                                                  3, 4, $cliente['STPSERNRO'], $orden_pag ));

                if(!$query){
                    $this->oracle->trans_rollback();
                    return false;
                }
              }
             
          }
          //******* INSERCION EN OPAGOS *******
          $max_correlativo= $this -> max_correlativo();
          $maximo_correlativo = $max_correlativo[0]["NRO"] + 1 ; // LA EMPRESA RELACIONADA
          
          $query = $this->oracle->query("INSERT INTO  PRDGESTIONCOMERCIAL.OPAGOS
                                              ( EMPCOD, OFICOD, ARECOD,CTDCOD,DOCCOD,SERNRO,
                                                CMPNRO, PAGNROOPE , EMSCOD , CCBCOD , STUSRPAGCOD, PAGIMP,
                                                PAGFCHREG , PAGFCHPAG , PAGFCHPEF , PAGHRAPEF , STPGEMPCOD ,STPGOFICOD ,
                                                STPGARECOD , SPGCOD) VALUES
                                                (? , ? , ? , ? ,
                                                 ? , ? , ? , ? ,
                                                 ? , ? , ? , ? ,
                                                 TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                 TO_CHAR(SYSDATE,'HH:MI:SS'),
                                                 ? , ? , ? , ? )" ,
                                            array( $cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'],
                                                  1 , $doc_tip , $serie_prof ,$nv_nro_sedalib ,$maximo_correlativo ,
                                                  $relacion_empre[0]["EMSCOD"] ,$relacion_empre[0]["CCBCOD"] , $relacion_empre[0]["USRCOD"] ,
                                                  $cliente['FSCTOTAL'] ,$cliente['GEMPCOD'], $cliente['GFICOD'],  $cliente['GARECOD'], 1));
          if(!$query){
                    $this->oracle->trans_rollback();
                    return false;
          }
          //REVISAR SI LA PROFORMA VIENE DE UNA ORDEN DE PAGO
          // SI ES ASI GUARDAR EN OORDPAG SINO CONCLUYO EL PROCESO
          // ACTUALIZAR SFACTURAAUX ESTADO DE 0 a 1
          $query = $this->oracle->query('UPDATE PRDDBFCOMERCIAL.SFACTURAAUX
                                      SET FSCESTADO = 1 , STPCTDCOD = ? , STPDOCCOD = ? , STPSERNRO = ? , CDPNRO = ?
                                      WHERE FSCSERNRO = ? AND
                                          FSCNRO = ? AND
                                          FSCTIPO = ? ',
                                      array(1 , $doc_tip , $serie_prof ,$nv_nro_sedalib , $cliente['FSCSERNRO'], $cliente['FSCNRO'], $cliente['FSCTIPO'],

                                  ));
          if(!$query){
                  $this->oracle->trans_rollback();
                  return false;
          }
          
          // PARA LA INSERCION EN EL PRDRECAUDACIONORA12C

          $query = $this->oracle->query("INSERT INTO  PRDRECAUDACIONORA12C.MDOCGLB
                                              ( ESECOD, MDCCOD, MDGSERDOC, MDGNRODOC, MDGCODACC1, MDGCODACC2,MDGCODACC3, MDGFCHEMIDOC,MDGFCHVTODOC,MDGFCHVTOCOB,MDGFCHREG, MDGHRAREG, MDGIMPTOT, OPSCOD, SDGCOD, MDGMSJFIN, MDGFCHLSTUPD, MDGHRALSTUPD, MDGDNINUM, MDGDNIFREG, MDGDNIHREG ) VALUES
                                                (?, ?, ?, ?, ?, ?, ?,
                                                 TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS') , ?, ?, ?,
                                                 ?, TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS'), ?, TO_CHAR(SYSDATE,'DD-MON-YYYY'), TO_CHAR(SYSDATE,'HH:MI:SS') )" ,
                                            array(1, $dato_oracle_11g, $serie_prof, $nv_nro_sedalib, 0,  ($cliente['FSCCLIRUC']!=null) ? $cliente['FSCCLIRUC'] : $cliente['FSCNRODOC'], substr($cliente['FSCCLINOMB'], 0, 64),
                                                $cliente['FSCTOTAL'], NULL, 2,
                                                NULL, ($cliente['FSCNRODOC']!=null) ? trim($cliente['FSCNRODOC']) : NULL ));
          if(!$query){
                    $this->oracle->trans_rollback();
                    return false;
          }

          if($maximo_de_pagos !=null){
            $maximo_de_pagos1 = $maximo_de_pagos[0]["NRO"] + 1 ;
          }else{
            $maximo_de_pagos1=1;
          }
          
          $query = $this->oracle->query("INSERT INTO  PRDRECAUDACIONORA12C.OPAGOS
                                              ( ESECOD, MDCCOD, MDGSERDOC, MDGNRODOC, OPGNROOPE, OPGFCHREG, OPGHRAREG, OPGFCHPAG,
                                                OPGHRAPAG, OPGFCHPEF, OPGHRAPEF, OPGIMPPAG, OPCCOD, ECOCOD, PTCCOD, CJACOD,
                                                STECOCOD, VOEITEM, USRCOD, OPCJITM, TPGCOD, SPGCOD, OPGIMPCAR, OPGIMPINT, 
                                                OPGIMPENT, OPGEMPVUE, OPGREFBO, OPGPAGINTSW, OPGPAGCARSW, OPGUSRAUX, OPGFCHAUX, OPGHRAAUX,
                                                OPGADDIP) VALUES
                                                ( ?, ?, ?, ?, ?,TO_CHAR(SYSDATE,'DD-MON-YYYY') ,TO_CHAR(SYSDATE,'HH:MI:SS'),TO_CHAR(SYSDATE,'DD-MON-YYYY'),
                                                  TO_CHAR(SYSDATE,'HH:MI:SS'), TO_CHAR(SYSDATE,'DD-MON-YYYY'),TO_CHAR(SYSDATE,'HH:MI:SS'), ?, ?, ?, ?, ?,
                                                  ?, ?, ?, ?, ?, ?, ?, ?,
                                                  ?, ?, ?, ?, ?, ?, ?, ?,
                                                  ? )" ,
                                            array(1, $dato_oracle_11g, $serie_prof, $nv_nro_sedalib,$maximo_de_pagos1,
                                                  $cliente['FSCTOTAL'],0, $dato_cajera[0]['ECOCOD'], $dato_cajera[0]['PTCCOD'], $dato_cajera[0]['CJACOD'],
                                                  $dato_cajera[0]['STECOCOD'], 1, $dato_cajera[0]['USRCOD'],0 ,1 ,1, 0, 0,
                                                  0, 0, 0, 0, 0, 0, NULL, NULL,
                                                  NULL ));
          if(!$query){
                    $this->oracle->trans_rollback();
                    return false;
          }



          $this->oracle->trans_commit();
          //$this->oracle->trans_rollback();
          return true;










        }else{
          return false;
        }      
    }


    public function obtengo_cajera(){
       $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MUSUARIO.USRCOD, COPECAJ.ECOCOD, PTCCOD, USRLOG, USRNOM, SUSCOD, TUSCOD, 
                                    EMPCOD, OFICOD, ARECOD, CJACOD, STECOCOD, ECODES, SECCOD 
                                    FROM PRDRECAUDACIONORA12C.COPECAJ 
                                    INNER JOIN PRDRECAUDACIONORA12C.MEMPCOB ON (COPECAJ.ECOCOD = MEMPCOB.ECOCOD) 
                                    INNER JOIN PRDRECAUDACIONORA12C.MUSUARIO ON (MUSUARIO.USRCOD = COPECAJ.USRCOD) 
                                    WHERE SECCOD = 1  
                                    AND TRIM(USRLOG) = ?
                                    ORDER BY COPECAJ.ECOCOD", array( $_SESSION['login'] ));
        if(!$query){
            $this->oracle->trans_rollback();
            return false;
        }
        return $query->result_array();
    }

    public function maximo_de_pagos( $mdccod, $mdgserdoc, $mdgnrodoc){
      /*$db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MAX(OPGNROOPE) NRO FROM PRDRECAUDACIONORA12C.OPAGOS");
        if(!$query){
            $this->oracle->trans_rollback();
            return false;
        }
        return $query->result_array();*/
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MAX(OPGNROOPE) NRO FROM PRDRECAUDACIONORA12C.OPAGOS WHERE ESECOD=1 AND MDCCOD= ? AND MDGSERDOC= ?  AND MDGNRODOC= ? " , array( $mdccod, $mdgserdoc, $mdgnrodoc ));
        if(!$query){
            $this->oracle->trans_rollback();
            return false;
        }
        return $query->result_array();

    }

    public  function Empre_pagos(){
      $db_prueba = $this->load->database('oracle', TRUE);
       $query = $db_prueba->query("SELECT * FROM  PRDGESTIONCOMERCIAL.CCTOCOB1
                                  INNER JOIN PRDGESTIONCOMERCIAL.MEMPSER ON CCTOCOB1.EMSCOD = MEMPSER.EMSCOD AND MEMPSER.SEMCOD = 1
                                  WHERE USRCOD= ?" , array($_SESSION['user_comercial']));
      /*$query = $db_prueba->query("SELECT * FROM  PRDGESTIONCOMERCIAL.CCTOCOB1
                                  INNER JOIN PRDGESTIONCOMERCIAL.MEMPSER ON CCTOCOB1.EMSCOD = MEMPSER.EMSCOD AND MEMPSER.SEMCOD = 1
                                  WHERE USRCOD= ?" , 239);*/
      if(!$query){
            $this->oracle->trans_rollback();
            return false;
        }
      return $query->result_array();
    }

    public function max_correlativo(){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT MAX(PAGNROOPE) NRO FROM PRDGESTIONCOMERCIAL.OPAGOS ");
        if(!$query){
            $this->oracle->trans_rollback();
            return false;
        }
        return $query->result_array();
    }

    /*public function actualizar_factura($tipo, $serie, $numero, $campos, $datos){
        if(is_array($campos) && is_array($datos)){
            if(count($campos) == count($datos)){
                $consulta = "UPDATE PRDDBFCOMERCIAL.SFACTURA SET CADENA WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?";
                $substr = '';
                for($idx = 0; $idx<count($campos); $idx++){
                    $substr = $substr.$campos[$idx].' = ? ';
                    if($idx!=count($campos)-1){
                        $substr = $substr.' AND ';
                    }
                }
                //$consulta = str_replace('CADENA', $substr, $consulta);
                //array_push($datos, $serie, $numero, $tipo);
                $query = $this->oracle->query($consulta, $datos);
                if($query==true){
                    return true;
                }else{
                    return false;
                }

                //return $consulta;
            }else{
                return false;
            }
        }else{
            //echo 'campo o datos incorrectos';
            return false;
        }
    }*/

    public function actualizar_firma($tipo, $serie, $numero, $firma){
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SFACTURA
                                        SET SUNFIRMA = ?
                                        WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?",
                                        array($firma, $serie, $numero, $tipo));
    }

    public function actualizar_estado_sunat($tipo, $serie, $numero, $sunat_estado){
        // 1   EMITIDO Comprobante de Pago Creada en Base de Datos
        // 2   ENVIADO Comprobante de Pago Enviada en espera de la Firma
        // 3   ACEPTADO    Comprobante de Pago Enviada a SUNAT y Aceptada
        // 4   RECHAZADO   Comprobante de Pago Enviada a SUNAT y Rechazada
        // 5   OBSERVACION Comprobante de Pago Enviada a SUNAT y Devuelta con Observaciones
        // 6   NO ATENDIDO Comprobante de Pago Enviada a SUNAT pero no se obtuvo respuesta
        // 7   FIRMADO
        // 8   NO SE CONSIGUIO FIRMA
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SFACTURA
                                        SET SUNESTADO = ?
                                        WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?",
                                        array($sunat_estado, $serie, $numero, $tipo));
    }
    public function actualizar_estado_sunat_metodo2($tipo, $serie, $numero, $sunat_estado,$observacion){
        // 1   EMITIDO Comprobante de Pago Creada en Base de Datos
        // 2   ENVIADO Comprobante de Pago Enviada en espera de la Firma
        // 3   ACEPTADO    Comprobante de Pago Enviada a SUNAT y Aceptada
        // 4   RECHAZADO   Comprobante de Pago Enviada a SUNAT y Rechazada
        // 5   OBSERVACION Comprobante de Pago Enviada a SUNAT y Devuelta con Observaciones
        // 6   NO ATENDIDO Comprobante de Pago Enviada a SUNAT pero no se obtuvo respuesta
        // 7   FIRMADO
        // 8   NO SE CONSIGUIO FIRMA
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.SFACTURA
                                        SET SUNESTADO = ? , OBSWS = ?
                                        WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?",
                                        array($sunat_estado,$observacion, $serie, $numero, $tipo));
    }



    public function actualizar_respuestaWS($cliente, $nro_sedalib, $dir_file, $dir_pdf){
        $query = $this->oracle->query('UPDATE PRDDBFCOMERCIAL.SFACTURA
                                                SET DIRARCHWS = ?, DIRARCHPDF = ?
                                                WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?',
                                            array(  $dir_file, $dir_pdf,
                                                    ($cliente['FSCSERNRO']),
                                                    $nro_sedalib, $cliente['FSCTIPO']));

    }

    public function actualizar_estado_proforma($cliente){
      $query = $this->oracle->query('UPDATE PRDDBFCOMERCIAL.SFACTURAAUX
                                            SET FSCESTADO = 1
                                            WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?',
                                        array( $cliente['FSCSERNRO'], $cliente['FSCNRO'], $cliente['FSCTIPO'] ));
    }

    public function confirmar_pago($cliente, $profns, $nro_sedalib, $valido, $obs, $dir_file, $dir_pdf){

    }

    public function actualizar_respuesta_ws($cliente, $nro_sedalib, $valido, $obs){
        // CARGAMOS TIPOS DE COMPROBANTES SEGUN LA BASE DE DATOS PRDGESTIONCOMERCIAL
        // PARA LA BASE DE DATOS PRDDBFCOMERCIAL LOS TIPOS SON LOS SIGUIENTES
        //      0 = BOLETA
        //      1 = FACTURA
        $l_comprobantes = $this->get_tipos_comprobante();
        //BUSCAMOS EL TIPO DE DOCUMENTO PERTENECIENTE A LA PROFORMA
        $idx = -1;
        if($cliente['FSCTIPO']=='0'){
            $idx = array_search('BOLETA', array_column($l_comprobantes, 'DOCABR'));
        }else if($cliente['FSCTIPO']=='1'){
            $idx = array_search('FACTURA', array_column($l_comprobantes, 'DOCABR'));
        }else{
            return false;
        }
        $aux['CTDCOD'] = $l_comprobantes[$idx]['CTDCOD'];
        $aux['DOCCOD'] = $l_comprobantes[$idx]['DOCCOD'];

        $tipo_prof = $cliente['FSCTIPO'];
        $this->oracle->trans_begin();
        // LA VARIABLE VALIDO DETERMINARA SI EL WEB SERVICE ACEPTO LA PROFORMA
        if($valido){
            $query = $this->oracle->query('UPDATE PRDGESTIONCOMERCIAL.OCOMPAG
                                            SET SCPCOD = 2
                                            WHERE   EMPCOD =? AND OFICOD =? AND
                                                    ARECOD =? AND CTDCOD =? AND
                                                    DOCCOD =? AND SERNRO =? AND
                                                    CMPNRO =?',
                                        array(  $_SESSION['NSEMPCOD'], $_SESSION['NSOFICOD'],
                                                $_SESSION['NSARECOD'], $aux['CTDCOD'],
                                                $aux['DOCCOD'], (($tipo_prof == '0')? $_SESSION['BOLETA']['serie']:$_SESSION['FACTURA']['serie']),
                                                $nro_sedalib));
            //var_dump($this->oracle->affected_rows());
            /*if($this->oracle->affected_rows()>0){

            }*/
            $query = $this->oracle->query('UPDATE PRDDBFCOMERCIAL.SFACTURA
                                                SET FSCESTADO = 1, FRECWS = SYSDATE,
                                                    OBSWS = ?
                                                WHERE FSCSERNRO = ?
                                                        AND FSCNRO = ? AND FSCTIPO = ?',
                                            array(  $obs,
                                                    (($tipo_prof == '0')? $_SESSION['BOLETA']['serie']:$_SESSION['FACTURA']['serie']),
                                                    $nro_sedalib, $cliente['FSCTIPO']));
            $query = $this->oracle->query('UPDATE PRDDBFCOMERCIAL.SFACTURAAUX
                                                SET FSCESTADO = 1
                                                WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?',
                                            array( $cliente['FSCSERNRO'], $cliente['FSCNRO'], $cliente['FSCTIPO'] ));
            /*if(!is_null($profns) && !empty($profns)){
                $query = $this->oracle->query('UPDATE PRDGESTIONCOMERCIAL.OORDPAG
                                                    SET SORCOD = 2
                                                    WHERE   EMPCOD = ? AND OFICOD = ? AND ARECOD = ? AND
                                                            CTDCOD = ? AND DOCCOD = ? AND
                                                            SERNRO = ? AND
                                                            ORPNRO = ?',
                                                array(  $profns['EMPCODNS'], $profns['OFICODNS'], $profns['ARECODNS'],
                                                        $profns['CTDCODNS'], $profns['DOCCODNS'],
                                                        (($tipo_prof == '0')? $_SESSION['BOLETA']['serie']:$_SESSION['FACTURA']['serie']),
                                                        $profns['ORPNRONS']));
            }*/
        }else{
            $query = $this->oracle->query('UPDATE PRDGESTIONCOMERCIAL.OCOMPAG
                                            SET SCPCOD = 3
                                            WHERE   EMPCOD =? AND OFICOD =? AND
                                                    ARECOD =? AND CTDCOD =? AND
                                                    DOCCOD =? AND SERNRO =? AND
                                                    CMPNRO =?',
                                        array(  $_SESSION['NSEMPCOD'], $_SESSION['NSOFICOD'],
                                                $_SESSION['NSARECOD'], $aux['CTDCOD'],
                                                $aux['DOCCOD'],
                                                (($tipo_prof == '0')? $_SESSION['BOLETA']['serie']:$_SESSION['FACTURA']['serie']),
                                                $nro_sedalib));
            $query = $this->oracle->query('UPDATE PRDDBFCOMERCIAL.SFACTURA
                                                SET FSCESTADO = 2, FRECWS = SYSDATE,
                                                    DIRARCHWS = ?, OBSWS = ?
                                                WHERE FSCSERNRO = ?
                                                      AND FSCNRO = ? AND FSCTIPO = ?',
                                            array(  $obs,
                                                    (($tipo_prof == '0')? $_SESSION['BOLETA']['serie']:$_SESSION['FACTURA']['serie']),
                                                    $nro_sedalib, $cliente['FSCTIPO']));
            // OCOMPAG NO SERA MODIFICADO PUES SU ESTADO DEBERIA ESTAR EN 1 (PENDIENTE DE PAGO)
            /*

            if(!is_null($profns) && !empty($profns)){
                $query = $this->oracle->query('UPDATE PRDGESTIONCOMERCIAL.OORDPAG
                                                    SET SORCOD = 3
                                                    WHERE   EMPCOD = ? AND OFICOD = ? AND ARECOD = ? AND
                                                            CTDCOD = ? AND DOCCOD = ? AND SERNRO = ? AND
                                                            ORPNRO ?',
                                                array(  $profns['EMPCODNS'], $profns['OFICODNS'], $profns['ARECODNS'],
                                                        $profns['CTDCODNS'], $profns['DOCCODNS'], $profns['SERNRONS'],
                                                        $profns['ORPNRONS']));
            }*/
        }
        //$this->oracle->trans_rollback();
        $this->oracle->trans_commit();
    }

    //public function get_
/**
    OTRAS FUNCIONES
**/
    public function get_concep(){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.CONCEP WHERE ESTADO = 1 AND MOSTBOLFAC = 1 ORDER BY FACCONDES");
        return $query->result_array();
    }

    public function get_tipos_comprobante(){
        $query = $this->oracle->query("SELECT CTDCOD, DOCCOD, UPPER(DOCDES) AS DOCDES, UPPER(DOCABR) AS DOCABR
                                        FROM PRDGESTIONCOMERCIAL.MDOCUM1
                                        WHERE CTDCOD = 1");
        return $query->result_array();
    }

/**
    REPORTE
**/

    public function get_first100_comprobantes(){
        $query = $this->oracle->query("SELECT *
                                        FROM ( SELECT *
                                                FROM PRDDBFCOMERCIAL.SFACTURA
                                                ORDER BY FSCFECH DESC )
                                        WHERE ROWNUM <= 500");
        return $query->result_array();
    }

    public function buscar_comprobante_intervalo($tipo, $inicio, $fin, $monto){
        $query = $this->oracle->query("SELECT *
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCTIPO = ? AND FSCTOTAL >= ? AND
                                              TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY') 
                                        ORDER BY FSCTIPO, FSCSERNRO, FSCNRO DESC",
                                        array($tipo, $monto, $inicio, $fin));
        return $query->result_array();
    }

    public function buscar_comprobante_intervalo_individual($tipo, $inicio, $fin){
     /* $query = $this->oracle->query("SELECT *
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCTIPO = ? AND FSCUSRPAG=? AND
                                              TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY') AND
                                              FSCESTADO = 1
                                        ORDER BY FSCTIPO, FSCSERNRO, FSCNRO DESC",
                                        array($tipo,$_SESSION['user_id'], $inicio, $fin)); */
        $query = $this->oracle->query("SELECT *
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCTIPO = ? AND FSCUSRPAG = ? AND
                                              TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY') 
                                        ORDER BY FSCTIPO, FSCSERNRO, FSCNRO DESC",
                                        array($tipo,$_SESSION['user_id'], $inicio, $fin));
        
        //var_dump($_SESSION['user_id']);
        return $query->result_array();

    }


    /* estados */
    public function buscar_comprobante_estados($tipo, $inicio, $fin){
       
        /* $query = $this->oracle->query("SELECT *
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCUSRPAG = ? AND FSCTIPO = ? AND
                                              TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY')
                                        ORDER BY FSCTIPO, FSCSERNRO, FSCNRO DESC",
                                        array($_SESSION['user_id'],$tipo, $inicio, $fin));
        return $query->result_array();*/
        $query = $this->oracle->query("SELECT *
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCTIPO = ? AND
                                              TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY')
                                        ORDER BY FSCTIPO, FSCSERNRO, FSCNRO DESC",
                                        array($tipo, $inicio, $fin));
        return $query->result_array();
    }
    public function obtener_oficinas($tipo){
        // LLEGARA DE PRDDBFCOMERCIAL
        // 0 BOLETA 1 FACTURA EN PRDDBFCOMERCIAL 1 FACTURA 2 BOLETA
        $query = $this->oracle->query(  "SELECT
                                              PRDDBFCOMERCIAL.CSERIES.EMPCOD,
                                              PRDDBFCOMERCIAL.CSERIES.OFICOD,
                                              PRDDBFCOMERCIAL.CSERIES.CTDCOD,
                                              PRDDBFCOMERCIAL.CSERIES.DOCCOD,
                                              PRDDBFCOMERCIAL.CSERIES.SERNRO,
                                              PRDDBFCOMERCIAL.CEMPRES1.OFIDES,
                                              PRDDBFCOMERCIAL.CEMPRES1.REG,
                                              PRDDBFCOMERCIAL.CEMPRES1.ZON,
                                              PRDDBFCOMERCIAL.CEMPRES1.LOC

                                        FROM PRDDBFCOMERCIAL.CSERIES
                                        INNER JOIN PRDDBFCOMERCIAL.CEMPRES1
                                            ON PRDDBFCOMERCIAL.CEMPRES1.EMPCOD = PRDDBFCOMERCIAL.CSERIES.EMPCOD AND
                                                PRDDBFCOMERCIAL.CEMPRES1.OFICOD = PRDDBFCOMERCIAL.CSERIES.OFICOD
                                        WHERE PRDDBFCOMERCIAL.CSERIES.CTDCOD = 1 AND
                                              PRDDBFCOMERCIAL.CSERIES.DOCCOD=?
                                        GROUP BY
                                                PRDDBFCOMERCIAL.CSERIES.EMPCOD,
                                                PRDDBFCOMERCIAL.CSERIES.OFICOD,
                                                PRDDBFCOMERCIAL.CSERIES.CTDCOD,
                                                PRDDBFCOMERCIAL.CSERIES.DOCCOD,
                                                PRDDBFCOMERCIAL.CSERIES.SERNRO,
                                                PRDDBFCOMERCIAL.CEMPRES1.OFIDES,
                                                  PRDDBFCOMERCIAL.CEMPRES1.REG,
                                                  PRDDBFCOMERCIAL.CEMPRES1.ZON,
                                                  PRDDBFCOMERCIAL.CEMPRES1.LOC

                                        ORDER BY PRDDBFCOMERCIAL.CSERIES.SERNRO ASC",
                                        array(($tipo==0)? 2:1));
        return $query->result_array();
    }

    public function comprobante_by_intervalo($tipo, $serie, $inicio, $fin, $monto){
        $query = $this->oracle->query("SELECT FSCSERNRO, FSCNRO,SUNSERNRO,SUNFACNRO, FSCFECH,FSCCLIUNIC, FSCCLINOMB,FSCTIPDOC,FSCNRODOC, FSCCLIRUC,FSCTIPO, FSCESTADO, FSCFCONT, FSCFCFEC, FSCSUBTOTA, FSCSUBIGV, FSCTOTAL,TOT_EXONERADO,TOT_INAFECTO,TOT_GRATUITO,TOT_GRABADO,CONCEPT_GRATUITO
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCTIPO = ? AND (FSCESTADO = 1 OR FSCESTADO = 2 ) AND
                                              FSCSERNRO = ? AND FSCTOTAL > ? AND
                                              TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY') 
                                        ORDER BY FSCTIPO, FSCSERNRO, FSCNRO ASC",
                                        array($tipo, $serie,$monto, $inicio, $fin));
        return $query->result_array();
    }
    public function comprobante_by_intervalo2($tipo, $serie, $inicio, $fin){
        $query = $this->oracle->query("SELECT FSCSERNRO, FSCNRO, FSCFECH,FSCCLIUNIC,SUNSERNRO,SUNFACNRO, FSCCLINOMB,FSCTIPDOC,FSCNRODOC, FSCCLIRUC,FSCTIPO, FSCESTADO, FSCFCONT, FSCFCFEC, FSCSUBTOTA, FSCSUBIGV, FSCTOTAL
                                        FROM PRDDBFCOMERCIAL.SFACTURA
                                        WHERE FSCTIPO = ? AND
                                              FSCSERNRO = ? AND
                                              FSCUSRPAG=? AND FSCESTADO = 1 AND
                                              TRUNC (FSCFECH) BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY') 
                                        ORDER BY FSCTIPO, FSCSERNRO, FSCNRO DESC",
                                        array($tipo, $serie,$_SESSION['user_id'], $inicio, $fin));
        return $query->result_array();
    }

/*
 * Funciones para OSE TXT 
 * 
 */

   public function ose_gen_txt($serie, $numero,$tipo){
                      
        $query = $this->oracle->query("SELECT 'EMI' AS EMI_CODID, '20131911310' AS EMI_RUC, 
                                    'SERVICIO DE AGUA Y ALCANTARILLADO DE LA LIBERTAD S.A' AS EMI_NOMCOM,
                                    SERIES.COD_ESTABLECI_SUNAT AS EMI_LUGEXP,
                                    SERIES.OFIDIR AS EMI_DOMFIS,
                                    SERIES.URBANIZACION AS EMI_URBA,
                                    SERIES.DIST AS EMI_DIST,
                                    SERIES.PROV AS EMI_PROV,
                                    SERIES.DEPTO AS EMI_DEPT,
                                    'PE' AS EMI_CODPAIS,
                                    SERIES.UBIGEO AS EMI_UBIGEO,
                                    '' AS EMI_RESER, 'REC' AS REC_CODID,
                                    CASE 
                                    WHEN SFACTURAAUX.FSCTIPDOC = 1 THEN '1' || '/' ||SFACTURAAUX.FSCNRODOC 
                                    WHEN SFACTURAAUX.FSCTIPDOC = 6 THEN '6' || '/' ||SFACTURAAUX.FSCCLIRUC 
                                    END as REC_TIPDOC, 
                                    SFACTURAAUX.FSCCLINOMB AS REC_RAZSOC, SFACTURAAUX.FSDIREC AS REC_DIRECC ,
                                    '' AS REC_DIST, '' AS REC_PROV, '' AS REC_DEPT,
                                    CASE 
                                    WHEN SFACTURAAUX.FSCTIPDOC =1 or SFACTURAAUX.FSCTIPDOC = 6 THEN 'PE' 
                                    END AS REC_CODPAIS,
                                    NVL(PSUNAT.UBIGEO, '') AS REC_UBIGEO, '' AS REC_TELEF, 'NO' AS REC_NOTIF,
                                    NVL(SFACTURAAUX.EMAIL, '') AS REC_EMAIL, 'COM' AS COM_CODID, 
                                    TO_CHAR(SYSDATE, 'YYYY-MM-DD HH:MM:SS' )AS COM_FECHA_HORA,
                                    TO_CHAR(SYSDATE, 'YYYY-MM-DD HH:MM:SS' )AS COM_FECHRA,
                                    CASE 
                                    WHEN SFACTURAAUX.FSCTIPO = 0 THEN '03' 
                                    WHEN SFACTURAAUX.FSCTIPO = 1 THEN '01' 
                                    END AS COM_TIPDOC, 
                                    SERIES.SUNSERNRO || '-' || trim(to_char(SERIES.MAXSUNFACNRO, '0000000')) AS COM_SERCORR,
                                    '0101' AS COM_TIPOPER, 
                                    '' AS COM_FECVEC, 
                                    SERIES.SUNSERNRO, SERIES.MAXSUNFACNRO AS SUNFACNRO, 
                                    'TOT' AS TOT_CODID, 
                                    '' AS TOT1_SUMTOT_DESC, 
                                    CASE SFACTURAAUX.CONCEPT_GRATUITO WHEN 1 THEN SFACTURAAUX.FSCSUBIGV||'' ELSE '' END AS TOT2_SUMTOT_OP_GRAT, 
                                    SFACTURAAUX.FSCSUBTOTA  AS TOT3_TOT_VAL_VEN,
                                    '' AS TOT4_ISC, 
                                    CASE SFACTURAAUX.CONCEPT_GRATUITO WHEN 1 THEN '0.00' ELSE SFACTURAAUX.FSCSUBIGV||'' END  AS TOT5_TOT_IGV, 
                                    '' AS TOT6_TOT_IVAP, 
                                    '' AS TOT7_TOT_OTROS_TRIB, 
                                    SFACTURAAUX.FSCSUBIGV AS TOT8_MONT_TOT_IMP, 
                                    '' AS TOT9_MONTO_REDONDEO, 
                                    '' AS TOT10_MON_ANTICIPOS, 
                                    SFACTURAAUX.FSCTOTAL AS TOT11_IMPTOT_VENTA, 
                                    SFACTURAAUX.FSCTOTAL_GRAB AS TOT12_IMPTOT_PAGAR,
                                    SFACTURAAUX.FSCSERNRO AS SERIE_SEDALIB, 
                                    ULTNROSEDA.MAXFSCNRO AS NUMERO_SEDALIB,
                                    SFACTURAAUX.FSCTIPO,
                                    'TOT-S' as TOT_S_CODID,
                                    CASE SFACTURAAUX.CONCEPT_GRATUITO WHEN 1 THEN '0.00' ELSE SFACTURAAUX.FSCSUBTOTA||'' END  AS TOT_S_SUB_TOT_VEN_IGV,
                                    '0.00' AS TOT_S_SUB_TOT_VEN_IVAP,
                                    '0.00' AS TOT_S_SUB_TOT_VEN_EXON,
                                    '0.00' AS TOT_S_SUB_TOT_VEN_INAF,
                                    CASE SFACTURAAUX.CONCEPT_GRATUITO WHEN 1 THEN SFACTURAAUX.FSCSUBTOTA||'' ELSE '' END  AS TOT_S_SUB_TOT_VEN_GRAT,
                                    '' AS TOT_S_SUB_TOT_VEN_EXPORT,
                                    '' AS TOT_S_SUB_TOT_VEN_ISC,
                                    '' AS TOT_S_SUB_TOT_VEN_OTR_IMP,
                                    'PAG' as PAG_CODID,
                                    '009' as PAG_MET_PAG,
                                    '' as PAG_FECH_INI_CIC_FAC,
                                    '' as PAG_FECH_FINC_CIC_FAC,
                                    SFACTURAAUX.CONCEPT_GRATUITO AS GRATUITO,
                                    (CASE
                                        WHEN STAEMPCOD IS NOT NULL AND STAOFICOD IS NOT NULL AND STAARECOD IS NOT NULL AND STACTDCOD IS NOT NULL AND STADOCCOD IS NOT NULL AND STASERNRO IS NOT NULL AND CDANRO IS NOT NULL AND
                                            STPEMPCOD IS NOT NULL AND STPOFICOD IS NOT NULL AND STPARECOD IS NOT NULL AND STPCTDCOD IS NOT NULL AND STPDOCCOD IS NOT NULL AND STPSERNRO IS NOT NULL AND CDPNRO IS NOT NULL
                                        THEN 1
                                        WHEN STAEMPCOD IS NULL AND STAOFICOD IS NULL AND STAARECOD IS NULL AND STACTDCOD IS NULL AND STADOCCOD IS NULL AND STASERNRO IS NULL AND CDANRO IS NULL AND
                                            STPEMPCOD IS NULL AND STPOFICOD IS NULL AND STPARECOD IS NULL AND STPCTDCOD IS NULL AND STPDOCCOD IS NULL AND STPSERNRO IS NULL AND CDPNRO IS NULL
                                        THEN 0
                                        ELSE NULL
                                    END) AS CONORDPAG,
                                    'PDF' AS PAG_LEYENDA,
                                    '1' AS DESCRI_LEYENDA,
                                    'PEN' as PAG_MONEDA,
                                    '' as PAG_TIPO_CAMB
                                    FROM PRDDBFCOMERCIAL.SFACTURAAUX 
                                    INNER JOIN ( SELECT FSCSERNRO, MAX(FSCNRO)+1 AS MAXFSCNRO
                                    FROM PRDDBFCOMERCIAL.SFACTURA 
                                    GROUP BY FSCSERNRO
                                    ORDER BY FSCSERNRO ) ULTNROSEDA
                                    ON ULTNROSEDA.FSCSERNRO = SFACTURAAUX.FSCSERNRO
                                    LEFT JOIN PRDDBFCOMERCIAL.PSUNAT ON (SFACTURAAUX.FSCCLIRUC = PSUNAT.RUC) 
                                    LEFT JOIN ( SELECT CSERIES.SERNRO, ULTNROCOMPRO.FSCTIPO, CSERIES.SUNSERNRO, CSERIES.EMPCOD, CSERIES.OFICOD, 
                                    CEMPRES1.OFIDES, CEMPRES1.OFIDIR, CEMPRES1.URBANIZACION, CEMPRES1.DEPTO, CEMPRES1.PROV, CEMPRES1.DIST, 
                                    CEMPRES1.UBIGEO, CEMPRES1.COD_ESTABLECI_SUNAT,
                                    ULTNROCOMPRO.MAXSUNFACNRO
                                    FROM PRDDBFCOMERCIAL.CSERIES 
                                    LEFT JOIN PRDDBFCOMERCIAL.CEMPRES1 ON CSERIES.EMPCOD = CEMPRES1.EMPCOD AND CSERIES.OFICOD = CEMPRES1.OFICOD 
                                    LEFT JOIN ( SELECT COMPRO.XCTDCOD, COMPRO.XDOCCOD, COMPRO.FSCTIPO, COMPRO.FSCSERNRO, COMPRO.SUNSERNRO, MAX(COMPRO.XSUNFACNRO)+1 AS MAXSUNFACNRO
                                    FROM 
                                    ( SELECT SFACTURA.FSCSERNRO, SFACTURA.FSCTIPO, 1 AS XCTDCOD , 
                                    CASE 
                                    WHEN SFACTURA.FSCTIPO = 0 THEN 2 
                                    WHEN SFACTURA.FSCTIPO = 1 THEN 1 
                                    END AS XDOCCOD , 
                                    SFACTURA.SUNSERNRO, CAST(SFACTURA.SUNFACNRO AS NUMBER(8)) AS XSUNFACNRO 
                                    FROM PRDDBFCOMERCIAL.SFACTURA 
                                    WHERE SFACTURA.SUNSERNRO IS NOT NULL ) COMPRO
                                    WHERE COMPRO.SUNSERNRO <> '0' 
                                    GROUP BY COMPRO.XCTDCOD, COMPRO.XDOCCOD, COMPRO.FSCTIPO, COMPRO.FSCSERNRO,COMPRO.SUNSERNRO
                                    ORDER BY COMPRO.XCTDCOD, COMPRO.XDOCCOD, COMPRO.FSCTIPO, COMPRO.FSCSERNRO,COMPRO.SUNSERNRO ) ULTNROCOMPRO
                                    ON ULTNROCOMPRO.XCTDCOD = CSERIES.CTDCOD AND ULTNROCOMPRO.XDOCCOD = CSERIES.DOCCOD AND ULTNROCOMPRO.FSCSERNRO = CSERIES.SERNRO 
                                    WHERE CSERIES.SUNSERNRO IS NOT NULL ) SERIES
                                    ON SERIES.FSCTIPO = SFACTURAAUX.FSCTIPO AND SERIES.SERNRO = SFACTURAAUX.FSCSERNRO 
                                    WHERE SFACTURAAUX.FSCESTADO = 0 AND SFACTURAAUX.FSCSERNRO = ? AND SFACTURAAUX.FSCNRO = ? AND SFACTURAAUX.FSCTIPO = ? ", array($serie, $numero,$tipo));                              

    $cabecera_ose = $query->row_array();
      
    $comprobante_ose[] = $cabecera_ose;
                     
    $query = $this->oracle->query("SELECT 'PLU' AS PLU_CODID,
                                    ROW_NUMBER() OVER (PARTITION BY SFACTUR1AUX.SFACTURA_FSCSERNRO,
                                    SFACTUR1AUX.SFACTURA_FSCNRO, 
                                    SFACTUR1AUX.SFACTURA_FSCTIPO ORDER BY SFACTURA_FSCSERNRO,
                                    SFACTUR1AUX.SFACTURA_FSCNRO,
                                    SFACTUR1AUX.SFACTURA_FSCTIPO DESC, 
                                    SFACTUR1AUX.SFACTURA_FSCSERNRO,
                                    SFACTUR1AUX.SFACTURA_FSCNRO, 
                                    SFACTUR1AUX.SFACTURA_FSCTIPO ) AS PLU1_NROORDEN ,
                                    SFACTUR1AUX.FACCONCOD AS PLU2_CODITEM,
                                    '' AS PLU3_CODSUNAT,
                                    '' AS PLU4_CODGS1,
                                    'NIU' AS PLU5_UNIMED,
                                    CONCEP.FACCONDES AS PLU6_DESCRIP, 
                                    SFACTUR1AUX.CANT AS PLU7_CANT, 
                                    SFACTUR1AUX.FSCPRECIO AS PLU8_PUNI,
                                    CASE SFACTURAAUX.CONCEPT_GRATUITO WHEN 1 THEN SFACTUR1AUX.FSCPRECIO||'' ELSE '0.00' END  AS PLU9_VALREFUNI,
                                    SFACTUR1AUX.PUNIT AS PLU10_PVENUNI ,
                                    SFACTUR1AUX.FSCPRECIO AS PLU11_VALVEN,
                                    '' AS PLU12_NUMPLACVEH,
                                    SFACTUR1AUX.PRECIGV AS PLU13_MONTOTINP,
                                    'PLU-G' AS PLUG_CODID, 
                                    SFACTURAAUX.FSCIGVREF AS PLUG1_PORCIGV, 
                                    SFACTURAAUX.TIP_AFEC_IGV AS PLUG2_TIPIGV,
                                    SFACTUR1AUX.PRECIGV AS PLUG3_MONTOIGV,
                                    SFACTUR1AUX.FSCPRECIO AS PLUG4_FSCPRECIO
                                    FROM PRDDBFCOMERCIAL.SFACTURAAUX 
                                    LEFT JOIN SFACTUR1AUX ON (SFACTURAAUX.FSCSERNRO= SFACTUR1AUX.SFACTURA_FSCSERNRO) AND (SFACTURAAUX.FSCNRO = SFACTUR1AUX.SFACTURA_FSCNRO ) AND (SFACTURAAUX.FSCTIPO = SFACTUR1AUX.SFACTURA_FSCTIPO )
                                    LEFT JOIN CONCEP ON (SFACTUR1AUX.FACCONCOD= CONCEP.FACCONCOD)
                                    WHERE SFACTURAAUX.FSCESTADO = 0 AND SFACTURAAUX.FSCSERNRO = ? AND SFACTURAAUX.FSCNRO = ? AND SFACTURAAUX.FSCTIPO = ? 
                                    ORDER BY SFACTURAAUX.FSCESFEC, SFACTURAAUX.FSCTIPO, PLU1_NROORDEN ", array($serie, $numero,$tipo));
      
      
      $detalle_ose = $query->result_array();
      
      $comprobante_ose[] = $detalle_ose;    
      
      return $comprobante_ose;
      
    }            

}
