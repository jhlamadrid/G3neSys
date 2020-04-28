<?php
class Cuentas_corrientes_model extends CI_Model {
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
    public function get_one_client_1($codigo,$tipo){ 
        if($tipo == 'suministro') $query = $this->oracle->query("SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                                    PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                                    PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE)  WHERE P.CLICODFAC LIKE '%".$codigo."%'");
        else if($tipo == 'dni') $query = $this->oracle->query("SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                                        PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                                        PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE)  WHERE P.CLIELECT = ?",array($codigo));
        else if($tipo == 'direccion') $query = $this->oracle->query("SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                                        PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                                        PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE) WHERE RC.CALDES LIKE '%".$codigo."%'");
        else if($tipo == 'ruc') $query = $this->oracle->query("SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                                        PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                                        PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE)  WHERE P.CLIRUC = ?",array($codigo));
        else $query = $this->oracle->query("SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                                        PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                                        PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE)  WHERE P.CLINOMBRE LIKE '%".$codigo."%'");
        return $query->result_array();
    }
    public function agrupados($codigo){
        $query = $this->oracle->query("SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                                      PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                                      PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE)  WHERE P.CLICODFAC LIKE '%".$codigo."%'");
        return $query->result_array();
    }
    public function get_tipo_cliente($suministro){ 
        $query = $this->oracle->query("SELECT CLAS.CEMVOLDES FROM PRDCOMCATMEDLEC.CLIENT CLT INNER JOIN 
                                            PRDCOMCATMEDLEC.CLASECLIENTES CLAS ON CLT.CEMVOLCONA = CLAS.CEMVOLCONA WHERE CLT.CLICODFAC = ?",array($suministro));
        return $query->row_array()['CEMVOLDES'];
    } 
    public function get_tipo_cliente1($grupo,$subgrupo){ 
        $query = $this->oracle->query("SELECT CLAS.CEMVOLDES FROM PRDCOMCATMEDLEC.CLIENT CLT INNER JOIN 
                                        PRDCOMCATMEDLEC.CLASECLIENTES CLAS ON CLT.CEMVOLCONA = CLAS.CEMVOLCONA WHERE CLT.CLIGRUCOD = ? AND CLT.CLIGRUSUB = ?",array($grupo,$subgrupo));
        return $query->row_array()['CEMVOLDES'];
    }
    public function get_all_client(){ 
        $query =  $this->oracle->query("SELECT PR.CLICODFAC,PR.CLINOMBRE,PR.CLIMUNNRO,PR.CLIELECT,PR.CLIRUC,PR.TARIFA,RU.URBDES,RC.CALDES
                                        FROM PRDCOMCATMEDLEC.PROPIE PR
                                        INNER JOIN PRDCOMCATMEDLEC.RLURBA RU ON (PR.PREREGION = RU.PREREGION) AND (PR.PRELOCALI = RU.PRELOCALI) AND (PR.PREURBA = RU.PREURBA)
                                        INNER JOIN PRDCOMCATMEDLEC.RLCALL RC ON (PR.PREREGION = RC.PREREGION) AND (PR.PRELOCALI = RC.PRELOCALI) AND (PR.PRECALLE = RC.PRECALLE)
                                        WHERE ROWNUM <= 200");
        return $query->result_array();
    }
    public function get_user_x_recibo($serie,$numero){ 
        $query = $this->oracle->query("SELECT /*+ INDEX (FACSERNRO, FACNRO) */ CLICODFAX FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ?",array(intval($serie),intval($numero)));
        return $query->row_array()['CLICODFAX'];
    }
    public function busqueda_cc_multiple($u,$d,$n,$ot){
        $consulta = "SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                    PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                    PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE)  
                    WHERE ";
        if($u){
            $consulta .= " R.URBDES LIKE '%".$u."%' "; 
        } 
        if($u != "" && ($d != "" || $n != "" || $ot != "")){
            $consulta .= " AND ";
        }
        if($d){
            $consulta .= " RC.CALDES LIKE '%".$d."%' "; 
            if($n != "" || $ot != "") $consulta .= " AND ";
        }
        if( $n != ""){
            $consulta .= " P.CLIMUNNRO LIKE '%".$n."%' "; 
            if($ot) $consulta .= " AND ";
        }
        if($ot){
            $consulta .= " P.CLINOMBRE LIKE '%".$ot."%' "; 
        }
        $query = $this->oracle->query($consulta);
        return $query->result_array();
    }
    public function get_one_client($codigo){ 
        $query = $this->oracle->query("SELECT P.CLICODFAC,P.CLINOMBRE,P.CLIMUNNRO,P.CLIELECT,P.CLIRUC,P.CONTRA,P.TARIFA,R.URBDES,RC.CALDES FROM PRDCOMCATMEDLEC.PROPIE P JOIN
                                    PRDCOMCATMEDLEC.RLURBA R ON (P.PREREGION = R.PREREGION AND P.PRELOCALI = R.PRELOCALI AND P.PREURBA = R.PREURBA) JOIN
                                    PRDCOMCATMEDLEC.RLCALL RC ON (P.PREREGION = RC.PREREGION AND P.PRELOCALI = RC.PRELOCALI AND P.PRECALLE = RC.PRECALLE)  WHERE P.CLICODFAC = ?",array($codigo));
        return $query->row_array();
    }    
    public function get_all_botones($rol,$actividad){
        $query = $this->oracle->query("SELECT BTN.BTNGENNOMRE FROM PRDDBFCOMERCIAL.ROL_ACT_BTN RAB INNER JOIN PRDDBFCOMERCIAL.BTNGEN BTN ON RAB.ID_BTNGEN = BTN.ID_BTNGEN
                                        WHERE RAB.ID_ROL = ? AND RAB.ID_ACTIV = ? AND RAB.ESTADO = 1",array($rol,$actividad));
        return $query->result_array();
      }
    public function get_datos_usuarios($valor){ 
      $query = $this->oracle->query("SELECT CLIGRUCOD,CLIGRUSUB,PREREGION,PREZONA,PRESECTOR,PREMZN,PRELOTE FROM PRDCOMCATMEDLEC.CLIENT WHERE CLICODFAC = ?",array($valor));
      return $query->row_array();
    }
    public function get_datos_usuarios1($grupo,$subgrupo){ 
        $query = $this->oracle->query("SELECT CLIGRUSUB,CLIGRUCOD,PREZONA,PREREGION,PRESECTOR,PREMZN,PRELOTE FROM PRDCOMCATMEDLEC.CLIENT WHERE CLIGRUCOD = ? AND CLIGRUSUB = ?",array($grupo,$subgrupo));
        return $query->row_array();
      }  
    public function get_all_data($data){ 
        $query = $this->oracle->query("SELECT FACCICCOD FROM PRDCOMCATMEDLEC.PREDIO WHERE PREREGION = ? AND PREZONA = ? AND PRESECTOR = ? AND PREMZN = ? AND PRELOTE = ?",
                                        array($data['PREREGION'],$data['PREZONA'],$data['PRESECTOR'],$data['PREMZN'],$data['PRELOTE']));
        return $query->row_array()['FACCICCOD'];
      }
    public function cuenta_corriente($codigo){ 
        $query =  $this->oracle->query("SELECT /*+ INDEX (CLICODFAC) */ LECTURA,MEDIDOR,CODESTCTE,CICLOFAC,CODGRUPO  FROM PRDDBFCOMERCIAL.CTACTEFAC WHERE CLICODFAC = ? ORDER BY PROCESOFAC DESC",array($codigo));
        return $query->row_array();
      }  
    public function estado_cliente($estado){ 
        $query = $this->oracle->query("SELECT DESESCLTE  FROM PRDCOMCATMEDLEC.ESCLTE WHERE CODESCLTE = ?",array($estado));
        return $query->row_array();
    }
    public function get_ciclo($ciclo){ 
        $query = $this->oracle->query("SELECT FACCICDES  FROM PRDDBFCOMERCIAL.CICLOS WHERE FACCICCOD = ?",array($ciclo));
        return $query->row_array();
    }
    public function recibos_pendientes($codigo){ 
        $query = $this->oracle->query("SELECT FACSERNRO, FACNRO, FACEMIFEC, FACVENFEC, FACTOTAL,FACTARIFA FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX = ? AND FACESTADO = ? AND FACSERNRO NOT BETWEEN 90 AND 99 ORDER BY FACEMIFEC DESC",array($codigo,'I'));
        return $query->result_array();
    }
    public function volumen_leido($serie,$numero){ 
        $query = $this->oracle->query("SELECT /*+ INDEX (TOTFAC_FACSERNRO, TOTFAC_FACNRO) */ FACVOLUM FROM PRDDBFCOMERCIAL.FACLIN WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
        return $query->row_array()['FACVOLUM'];
    }
    public function reclamos($serie,$numero){ 
        $query = $this->oracle->query("SELECT OR1.SERNRO,OR1.RECID,SR.SSITDES FROM PRDGESTIONCOMERCIAL.ORECLAMO OR1 INNER JOIN PRDGESTIONCOMERCIAL.ORECLAFAC O
                                        ON  (OR1.EMPCOD = O.EMPCOD) AND (OR1.OFICOD = O.OFICOD) AND (OR1.ARECOD  = O.ARECOD) AND (OR1.CTDCOD = O.CTDCOD) AND
                                            (OR1.DOCCOD = O.DOCCOD) AND (OR1.SERNRO = O.SERNRO) AND (OR1.RECID = O.RECID)  INNER JOIN PRDGESTIONCOMERCIAL.SSITREC SR
                                        ON  (OR1.SSITCOD = SR.SSITCOD )
                                            WHERE O.OFACSERNRO = ? AND O.OFACNRO = ? AND NVL(TMCRCOD,0) <> 7 ",array($serie,$numero));
        return $query->row_array();
    } 
    public function notas_credito1($serie,$numero){ 
        $query = $this->oracle->query("SELECT TOTFAC_FACSERNRO,TOTFAC_FACNRO,NCASERNRO,NCANRO,NCAFACESTA,NCATOTDIF,NCAFACEMIF,NCAFECHA FROM PRDDBFCOMERCIAL.NCA
                                       WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = ? AND NCAFACESTA = 'I' ",array($serie,$numero,'A'));
        return $query->result_array();
    }
    public function notas_debito1($serie,$numero){ 
        $query = $this->oracle->query("SELECT TOTFAC_FACSERNRO,TOTFAC_FACNRO,NCASERNRO,NCANRO,NCAFACESTA,NCATOTDIF,NCAFECHA FROM PRDDBFCOMERCIAL.NCA 
                                        WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = ? AND NCAFACESTA = 'I'",array($serie,$numero,'C'));
        return $query->result_array();
    }
    public function get_autoizacion($serie,$numero){ 
        $query = $this->oracle->query("SELECT AUT_NRO FROM PRDDBFCOMERCIAL.NGX_LETS WHERE OFICOD = ?  AND OFIAGECOD = ? AND  AUT_OPE IN (?,?) 
                                    AND AUT_EST = 2 AND AUT_TIPO = 1 AND AUT_VIGFEC >= ? AND AUT_SER = ?  
                                    AND AUT_REC = ?",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id'],0,date('d/m/Y'),$serie,$numero));
        return $query->row_array()['AUT_NRO'];
    }
    public function obetner_periodo1($suministro,$serie,$numero){
        $query = $this->oracle->query("SELECT PERIODO FROM PRDDBFCOMERCIAL.REPFACIMP WHERE FACSERNRO = ? AND FACNRO = ? AND trim(CLICODFAX) = ?",array($serie,$numero,$suministro));
        return $query->row_array()['PERIODO'];
    }
    public function tasa($fecha){
        $query = $this->oracle->query("SELECT TAMACU FROM PRDDBFCOMERCIAL.TAMN WHERE TAMFEC = TO_DATE ('".$fecha."','DD/MM/YYYY')");
        return $query->row_array();
    }
    public function monto_nc($serie,$numero){
       $query = $this->oracle->query("SELECT  SUM(NCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A'", array($serie,$numero));
       return $query->row_array()['TOTAL'];
    }
    public function recibos_pendientes_90_91($codigo){ 
        $query = $this->oracle->query("SELECT FACSERNRO, FACNRO, FACEMIFEC, FACVENFEC, FACTOTAL,FACTARIFA FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX = ? 
                                        AND FACESTADO = ? AND FACSERNRO BETWEEN 90  AND 99  ORDER BY FACEMIFEC DESC",array($codigo,'I'));
        return $query->result_array();
      }
    public function get_monto_convenios($suministro){ 
        $query = $this->oracle->query("SELECT SUM(LE.LTCUOTA) TOTAL,COUNT(DISTINCT C1.CREDNRO) CANTIDAD FROM PRDDBFCOMERCIAL.CREDIT C1 INNER JOIN PRDDBFCOMERCIAL.LETRAS LE
                                        ON (C1.CREDNRO = LE.CREDIT_CREDNRO) AND (C1.AGENCI_OFICIN_OFICOD = LE.CREDIT_AGENCI_OFICIN_OFICOD) AND
                                        (C1.AGENCI_OFIAGECOD = LE.CREDIT_AGENCI_OFIAGECOD) WHERE C1.CLIUNICOD = ? AND C1.CREDSTATUS='I' AND LE.LTSTATUS = 'I'",array($suministro));
        return $query->row_array();
    }
    public function get_pagos($suministro){ 
        $query = $this->oracle->query(" SELECT  /*+ INDEX (CLIUNICOD) */
                                     PA.HISCOBTIP, PA.TOTFAC_FACSERNRO, PA.TOTFAC_FACNRO, PA.HISEMIFEC, PA.HISCOBFEC, PA.HISCOBHRS, PA.HISPAGO,
                                     PA.AGENCI_OFICIN_OFICOD, PA.AGENCI_OFIAGECOD, TOT.FACVENFEC, TOT.FACTOTAL, AG.OFIAGEDES FROM PRDDBFCOMERCIAL.PAGHIS PA
                                     JOIN PRDDBFCOMERCIAL.TOTFAC TOT ON  TOT.FACSERNRO = PA.TOTFAC_FACSERNRO AND TOT.FACNRO =  PA.TOTFAC_FACNRO
                                     JOIN PRDDBFCOMERCIAL.AGENCI AG ON AG.OFICIN_OFICOD = PA.AGENCI_OFICIN_OFICOD AND AG.OFIAGECOD = PA.AGENCI_OFIAGECOD
                                     WHERE CLIUNICOD = ? AND HISCOBTIP != 'E' ORDER BY TOT.FACVENFEC DESC",array($suministro));
        return $query->result_array();
    }  
    public function get_nota_credito_pago($serie,$numero){ 
        $query = $this->oracle->query("SELECT NCASERNRO, NCANRO FROM PRDDBFCOMERCIAL.NCA
                                     WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA = 'P'",array($serie,$numero));
        return $query->result_array();
    }
    public function get_nota_credito_importe($serie,$numero){ 
        $query = $this->oracle->query("SELECT SUM(NCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA
                                     WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA = 'P'",array($serie,$numero));
        return $query->row_array()['TOTAL'];
    } 
    public function get_nota_debito_importe($serie,$numero){ 
        $query = $this->oracle->query("SELECT SUM(NCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'C'",array($serie,$numero));
        return $query->row_array()['TOTAL'];
    }
    public function get_user_name($suministro){ 
        $query = $this->oracle->query("SELECT PR.CLICODFAC,PR.CLINOMBRE,PR.CLIELECT,PR.CLIRUC,PR.CLIMUNNRO,RU.URBDES,RC.CALDES,PR.TARIFA
                                    FROM PRDCOMCATMEDLEC.PROPIE PR
                                    INNER JOIN PRDCOMCATMEDLEC.RLURBA RU ON (PR.PREREGION = RU.PREREGION) AND (PR.PRELOCALI = RU.PRELOCALI) AND (PR.PREURBA = RU.PREURBA)
                                    INNER JOIN PRDCOMCATMEDLEC.RLCALL RC ON (PR.PREREGION = RC.PREREGION) AND (PR.PRELOCALI = RC.PRELOCALI) AND (PR.PRECALLE = RC.PRECALLE)
                                    WHERE PR.CLICODFAC = ?",array($suministro));
        return $query->row_array();
    }
    public function get_notas_anuladas($_suministro){
        $query = $this->oracle->query("SELECT NCACLICODF, NCASERNRO, NCANRO, NCATOTDIF, NCAFECHA FROM PRDDBFCOMERCIAL.NCA WHERE 
                                        NCAFACESTA = 'A' AND NCATIPO = 'A' AND NCACLICODF = ?",array($_suministro));
        return $query->result_array();
    }
    public function get_notaCredito($serie,$numero){ 
        $query = $this->oracle->query("SELECT NCACREA, TOTFAC_FACSERNRO, TOTFAC_FACNRO, NCAFECHA, NCA_VOLDIF, NCAFACCHED, NCAFACEMIF,NCAFACVENF, NCAREFE, 
                                        REC_NRO, REC_TIP, NCASUBDIF, NCAIGVDIF, NCATOTDIF, NCASERNRO, NCANRO FROM PRDDBFCOMERCIAL.NCA WHERE NCASERNRO = ? AND NCANRO = ?",array($serie,$numero));
        return $query->row_array();
    }
    public function get_nca1($serie,$numero){ 
        $query = $this->oracle->query("SELECT NC.NCAPREDIF DEUDA,NC.CONCEP_FACCONCOD NUMERO,CO.FACCONDES CONCEPTO FROM PRDDBFCOMERCIAL.NCA1 NC JOIN 
                                        PRDDBFCOMERCIAL.CONCEP CO ON CO.FACCONCOD = NC.CONCEP_FACCONCOD WHERE NCA_NCASERNRO = ? and NCA_NCANRO = ?",
                                        array($serie,$numero));
        return $query->result_array();
    }
    public function get_nca2($serie,$numero){ 
        $query = $this->oracle->query("SELECT NC.NCAMONDIF DEUDA,NC.CONCEP_FACCONCOD NUMERO,CO.FACCONDES CONCEPTO FROM PRDDBFCOMERCIAL.NCA2 NC JOIN 
                                        PRDDBFCOMERCIAL.CONCEP CO ON CO.FACCONCOD = NC.CONCEP_FACCONCOD WHERE NCA_NCASERNRO = ? and NCA_NCANRO = ?",
                                        array($serie,$numero));
        return $query->result_array();
    } 
    public function recibos_pendientes_ampliacion($codigo){ 
        $query = $this->oracle->query("SELECT FACSERNRO, FACNRO, FACEMIFEC, FACVENFEC FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX = ? AND FACESTADO = ? ORDER BY FACEMIFEC ASC",array($codigo,'I'));
        return $query->result_array();
    }
    public function get_nuser($user_cod){ 
        $query = $this->oracle->query("SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = ?",array($user_cod));
        return $query->row_array()['NNOMBRE'];
    }
    public function get_cuenta_fac($serie,$numero){ 
        $query = $this->oracle->query("SELECT LECTURA,PROCESOFAC FROM PRDDBFCOMERCIAL.CTACTEFAC WHERE SERIE = ? and NUMERO = ?",array($serie,$numero));
        return $query->row_array();
    }
    public function get_medidor($serie,$numero){ 
       $query = $this->oracle->query("SELECT FMEDIDOR FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? and FACNRO = ?",array($serie,$numero));
       return $query->row_array()['FMEDIDOR'];
    } 
    public function get_recibo($serie,$numero){
        $query = $this->oracle->query("SELECT /*+ INDEX (FACSERNRO,FACNRO) */ FACSERNRO, FACNRO, FACEMIFEC, FACVENFEC, FCICLO, FACTARIFA, FACTOTSUB, FACIGV, FACTOTAL FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ?",array($serie,$numero));
        return $query->row_array();
    }
    public function get_cuenta_anterior($periodo,$suministro){ 
        $query = $this->oracle->query("SELECT LECTURA FROM PRDDBFCOMERCIAL.CTACTEFAC where CLICODFAC = ? and PROCESOFAC = ?",array($suministro,$periodo));
        return $query->row_array()['LECTURA'];
    }
    public function get_init($suministro){
        $query = $this->oracle->query("SELECT /*+ INDEX (CLIUNICOD) */ MIN(HISCOBFEC) AS HISCOBFEC FROM PRDDBFCOMERCIAL.PAGHIS WHERE CLIUNICOD = ? ",array($suministro));
        return $query->row_array()['HISCOBFEC'];
    }
    public function get_finish($suministro){
        $query = $this->oracle->query("SELECT /*+ INDEX (CLIUNICOD) */ MAX(HISCOBFEC) AS HISCOBFEC FROM PRDDBFCOMERCIAL.PAGHIS WHERE CLIUNICOD = ?",array($suministro));
        return $query->row_array()['HISCOBFEC'];
    }
    public function get_pagos_rangos($s,$f1,$f2){
        $query = $this->oracle->query("SELECT  /*+ INDEX (CLIUNICOD) */
                                     PA.HISCOBTIP, PA.TOTFAC_FACSERNRO, PA.TOTFAC_FACNRO, PA.HISEMIFEC, PA.HISCOBFEC, PA.HISCOBHRS, PA.HISPAGO,
                                     PA.AGENCI_OFICIN_OFICOD, PA.AGENCI_OFIAGECOD, TOT.FACVENFEC, TOT.FACTOTAL, AG.OFIAGEDES FROM PRDDBFCOMERCIAL.PAGHIS PA
                                     JOIN PRDDBFCOMERCIAL.TOTFAC TOT ON  TOT.FACSERNRO = PA.TOTFAC_FACSERNRO AND TOT.FACNRO =  PA.TOTFAC_FACNRO
                                     JOIN PRDDBFCOMERCIAL.AGENCI AG ON AG.OFICIN_OFICOD = PA.AGENCI_OFICIN_OFICOD AND AG.OFIAGECOD = PA.AGENCI_OFIAGECOD
                                     WHERE CLIUNICOD = ? AND HISCOBFEC BETWEEN ? AND ? ORDER BY TOT.FACVENFEC DESC",array($s,$f1,$f2));
        return $query->result_array();
    }
    public function get_recibos_x_autorizacion($_suministro){ 
      $query = $this->oracle->query("SELECT AUT_NRO, CLIUNICOD, AUT_SER, AUT_REC, AUT_VIGFEC, AUT_TIPO, OFICOD, OFIAGECOD FROM PRDDBFCOMERCIAL.NGX_LETS WHERE trim(CLIUNICOD) = ? AND AUT_EST = 2 AND 
                                        AUT_VIGFEC >= ? AND OFICOD = ?  AND OFIAGECOD = ? AND AUT_OPE IN (?,0)",array($_suministro,date('d/m/Y'),$_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id']));
      return $query->result_array();
    } 
    public function get_nca($suministro,$serie,$nro){
      $query = $this->oracle->query("SELECT /*+ INDEX (NCATIPO,NCASERNRO,NCANRO) */ NCASERNRO, NCANRO, NCAREFE, NCACREA, NCAFECHA, NCA_VOLFAC, NCA_VOLDIF FROM PRDDBFCOMERCIAL.NCA WHERE NCATIPO = 'A' AND NCASERNRO = ? AND NCANRO = ? ",array($serie,$nro));
      return $query->row_array();
    }
    public function get_nca_1($suministro,$serie,$nro){
        $query = $this->oracle->query("SELECT /*+ INDEX (NCA_NCATIPO,NCA_NCASERNRO,NCA_NCANRO) */ NCA1.CONCEP_FACCONCOD, NCA1.NCAFACPREC, NCA1.NCAPREDIF, NCA1.NCAPREOK, FACCONDES FROM PRDDBFCOMERCIAL.NCA1 NCA1 INNER JOIN 
                                    PRDDBFCOMERCIAL.CONCEP CON ON NCA1.CONCEP_FACCONCOD = CON.FACCONCOD WHERE NCA_NCATIPO = 'A' AND NCA_NCASERNRO = ? AND NCA_NCANRO = ? ",array($serie,$nro));
        return $query->result_array();
    }  
    public function get_nca_2($suministro,$serie,$nro){
        $query = $this->oracle->query("SELECT /*+ INDEX (NCA_NCATIPO,NCA_NCASERNRO,NCA_NCANRO) */ NCA2.CONCEP_FACCONCOD,NCA2.NCACREFUEN, NCA2.NCACRECUOM, NCA2.NCAMONDIF, NCA2.NCAMONOK ,FACCONDES FROM PRDDBFCOMERCIAL.NCA2 NCA2 INNER JOIN 
                                    PRDDBFCOMERCIAL.CONCEP CON ON NCA2.CONCEP_FACCONCOD = CON.FACCONCOD WHERE NCA_NCATIPO = 'A' AND NCA_NCASERNRO = ? AND NCA_NCANRO = ?",array($serie,$nro));
        return $query->result_array();
    }
    public function get_ampliaciones($suministro){
      $query = $this->oracle->query("SELECT /*+ INDEX (CLIUNICOD) */ CUT_FEC, CUT_HRA, CUT_SER, CUT_NUM, CUT_VEN, CUT_GLO, CUT_NET, NCODIGO, CUT_NWF FROM PRDDBFCOMERCIAL.NOCUTTER WHERE CLIUNICOD = ?",array($suministro));
      return $query->result_array();
    }
    public function get_predio($grupo,$subgrupo){ 
       $query = $this->oracle->query("SELECT PREREGION, PREZONA, PRESECTOR, PREMZN, PRELOTE, CLICODFAC FROM PRDCOMCATMEDLEC.CLIENT WHERE CLIGRUCOD = ?  AND CLIGRUSUB = ?",array($grupo,$subgrupo));
       return $query->row_array(); 
    }
    public function get_unidades_grupo($predio){ 
        $query = $this->oracle->query("SELECT /*+ INDEX (PREREGION, PREZONA, PRESECTOR, PREMZN, PRELOTE) */ CLICODFAC, CLIGRUCOD, CLIGRUSUB, PREREGION, PREZONA, PRESECTOR, PREMZN, PRELOTE  FROM PRDCOMCATMEDLEC.CLIENT WHERE PREREGION = ? AND PREZONA = ?
                                        AND PRESECTOR = ? AND PREMZN = ? AND PRELOTE = ?",array($predio['PREREGION'],$predio['PREZONA'],$predio['PRESECTOR'],
                                        $predio['PREMZN'],$predio['PRELOTE']));
        return $query->result_array();
    }
    public function get_tarifa($suministro){
        $query = $this->oracle->query("SELECT /*+ INDEX (CLICODFAC) */ TARIFA, PREREGION, PRELOCALI FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ?",array($suministro));
        return $query->row_array();
    }
    public function get_localidad($region,$locali){
       $query = $this->oracle->query("SELECT /*+ INDEX (PREREGION, PRELOCALI) */ LOCDES FROM PRDCOMCATMEDLEC.LOCALI WHERE PREREGION = ?  AND PRELOCALI = ? ", array($region,$locali)); 
       return $query->row_array()['LOCDES'];
    }
    public function get_cambios_catastrales($suministro){
      $query = $this->oracle->query('SELECT CA.HISCAMBIO, CA.HISCAMFEC, CA.HISCAMHRS, CA.HISREFER, CA.HISUSUAR, CA.HISVALANT, CA.HISVALDES, MEA.DESCAMBIO FROM PRDCOMCATMEDLEC.CAMBIO CA 
                                        INNER JOIN PRDCOMCATMEDLEC.MAECAM MEA ON MEA.HISCAMBIO = CA.HISCAMBIO WHERE HISFACCOD = ? ',array($suministro));
      return $query->result_array();
    }
    public function get_faclin($serie,$numero){
      $query = $this->oracle->query("SELECT /*+ INDEX (TOTFAC_FACSERNRO, TOTFAC_FACNRO) */ F.FACLINRO,F.FACVOLUM,F.FACPRECI,F.MES,F.DRC,C.FACCONCOD,C.FACCONDES,C.FACIGVCOB  FROM PRDDBFCOMERCIAL.FACLIN F 
                                       INNER JOIN PRDDBFCOMERCIAL.CONCEP C ON  F.CONCEP_FACCONCOD = C.FACCONCOD WHERE F.TOTFAC_FACSERNRO = ? AND F.TOTFAC_FACNRO = ?",array($serie,$numero));
      return $query->result_array();
    }
    public function get_letfac($serie,$numero){
      $query = $this->oracle->query("SELECT  /*+ INDEX (TOTFAC_FACSERNRO, TOTFAC_FACNRO) */ L.CRECUOMON,L.CREDNRO,L.LTNUM,L.CRECUONRO,C.FACCONCOD,C.FACCONDES,C.FACIGVCOB FROM 
                                        PRDDBFCOMERCIAL.LETFAC L INNER JOIN PRDDBFCOMERCIAL.CONCEP C ON 
                                       L.CONCEP_FACCONCOD = C.FACCONCOD WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? ORDER BY C.FACCONCOD",array($serie,$numero));
        return $query->result_array();
    }
    public function user_anulador($serie,$numero,$_suministro){
      $query = $this->oracle->query("SELECT USR.NNOMBRE FROM PRDDBFCOMERCIAL.NGX_LETS NGX INNER JOIN PRDDBFCOMERCIAL.NUSERS USR ON NGX.AUT_OPE =  USR.NCODIGO
                                    WHERE CLIUNICOD = ? AND AUT_SER = ? AND AUT_REC = ?",array($_suministro,$serie,$numero));
      return $query->row_array()['NNOMBRE'];
    }
    public function _anular_nota($numero,$oficod,$ofiagecod,$suministro){
        $this->oracle->trans_begin();
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NGX_LETS WHERE OFICOD = ? AND OFIAGECOD = ?  AND AUT_NRO = ?  AND CLIUNICOD = ? AND AUT_EST = 2 AND AUT_TIPO = 2",array($oficod,$ofiagecod,$numero,$suministro));
        $serie = $query->row_array()['AUT_SER'];
        $numero = $query->row_array()['AUT_REC'];
        $fecha1 = '01/'.date('m/Y');
        $fecha2 = $this->ultimo_dia().'/'.date('m/Y');
        $query1 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NCA SET NCAFACESTA = 'A', NCAFACESTF = ? WHERE NCATIPO = 'A' AND NCASERNRO = ? AND NCANRO = ? AND NCAFECHA BETWEEN ?  AND ?", array(date('d/m/Y'),$serie,$numero,$fecha1,$fecha2));
        if(!$query1){
            $this->oracle->trans_rollback();
            return false;
        }
        /*
         *   WARNING CUIDADO ACTUALIZAR EN COBRANZA WEB 
        */
        $query2 = $this->oracle->query("UPDATE PRDRECAUDACIONORA12C.MDOCGLB SET SDGCOD = 4 WHERE ESECOD = 1 AND MDCCOD = 2 AND MDGSERDOC = ? AND MDGNRODOC = ? ",array($serie,$numero));
        if(!$query2){
            $this->oracle->trans_rollback();
            return false; 
        }
        $this->oracle->trans_commit();
        return true;
    }
    public function actualizar_autorizacion($numero,$oficod,$ofiagecod,$suministro){
        $this->oracle->trans_begin();
        $query2 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NGX_LETS SET  AUT_OPE = ?,AUT_EST = 1 WHERE OFICOD = ?  AND OFIAGECOD = ? AND AUT_NRO = ?  AND CLIUNICOD = ? AND AUT_TIPO = 2 ",
                                        array($_SESSION['user_id'],$oficod,$ofiagecod,$numero,$suministro));
      if(!$query2){
        $this->oracle->trans_rollback();
        return false; 
      }
      $this->oracle->trans_commit();
      return true;
    }
    public function get_fecha_emision($suministro){
      $query = $this->oracle->query("SELECT /*+ INDEX (CLICODFAX) */ MAX(FACEMIFEC) AS FACEMIFEC FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX =  ?",array($suministro));
      return $query->row_array()['FACEMIFEC'];
   }
    public function get_fecha_emision1($suministro){
      $query = $this->oracle->query("SELECT /*+ INDEX (CLICODFAX) */ MIN(FACEMIFEC) AS FACEMIFEC FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX =  ?",array($suministro));
      return $query->row_array()['FACEMIFEC'];
   }
    public function get_recibos_x_cliente($suministro){
      $query = $this->oracle->query('SELECT /*+ INDEX (CLICODFAX) */ FACSERNRO, FACNRO, FACEMIFEC, FACVENFEC, FACTOTAL, FACESTADO, FACESTFECH FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX LIKE ? ORDER BY FACEMIFEC DESC', array($suministro));
      return $query->result_array();
    }
    public function get_nca_x_cliente($suministro,$serie,$numero,$tipo){
      $query = $this->oracle->query("SELECT /*+ INDEX (TOTFAC_FACSERNRO, TOTFAC_FACNRO, NCACLICODF, NCATIPO) */ NCASERNRO, NCANRO, NCAFECHA, NCATOTDIF, NCAFACESTA, NCA_VOLDIF FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? 
                                       AND TOTFAC_FACNRO = ? AND NCACLICODF = ? AND NCATIPO = ?", array($serie,$numero,$suministro,$tipo));
      return $query->result_array();
    } 
    public function get_usuario($id){
        $query = $this->oracle->query('SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = ?',array($id));
        return $query->row_array()['NNOMBRE'];
    }
    public function get_convenios($suministro){
        $query = $this->oracle->query("SELECT /*+ INDEX (CLIUNICOD) */ C1.AGENCI_OFICIN_OFICOD, C1.AGENCI_OFIAGECOD, C1.CREDNRO, C1.CREDFECHA, C1.DEUDATOTAL, C1.CTAINICIAL, C1.CREDSTATUS, C1.CONCEP_FACCONCOD, C1.CREDNRO, C1.DEUDATOTAL, C1.CTAINICIAL, C1.CREREFDOC, 
                                     NS.NNOMBRE,CO.FACCONDES FROM PRDDBFCOMERCIAL.CREDIT C1
                                     INNER JOIN PRDDBFCOMERCIAL.NUSERS NS ON C1.DIGCOD = NS.NCODIGO
                                     INNER JOIN PRDDBFCOMERCIAL.CONCEP CO ON C1.CONCEP_FACCONCOD =  CO.FACCONCOD
                                     WHERE CLIUNICOD = ? AND CONCEP_FACCONCOD NOT IN(939,940) ORDER BY CREDFECHA DESC",array($suministro));
        return $query->result_array();
    }
    public function get_count_convenios($suministro){
        $query = $this->oracle->query("SELECT /*+ INDEX (CLIUNICOD) */ COUNT(*) AS TOTAL FROM PRDDBFCOMERCIAL.CREDIT C1
                                     INNER JOIN PRDDBFCOMERCIAL.NUSERS NS ON C1.DIGCOD = NS.NCODIGO
                                     INNER JOIN PRDDBFCOMERCIAL.CONCEP CO ON C1.CONCEP_FACCONCOD =  CO.FACCONCOD
                                     WHERE CLIUNICOD = ? AND CONCEP_FACCONCOD NOT IN(939,940)",array($suministro));
        return $query->row_array()['TOTAL'];
    }
    public function get_convenidos_939_940($suministro){
      $query = $this->oracle->query(" SELECT C1.AGENCI_OFICIN_OFICOD, C1.AGENCI_OFIAGECOD, C1.CREDNRO, C1.CREDFECHA, C1.DEUDATOTAL, C1.CTAINICIAL, C1.CREDSTATUS, C1.CONCEP_FACCONCOD, C1.CREDNRO, C1.DEUDATOTAL, C1.CTAINICIAL,
                                    NS.NNOMBRE,CO.FACCONDES FROM PRDDBFCOMERCIAL.CREDIT C1
                                   INNER JOIN PRDDBFCOMERCIAL.NUSERS NS ON C1.DIGCOD=NS.NCODIGO
                                   INNER JOIN PRDDBFCOMERCIAL.CONCEP CO ON C1.CONCEP_FACCONCOD =  CO.FACCONCOD
                                   WHERE CLIUNICOD = ? AND CONCEP_FACCONCOD IN(939,940) ORDER BY CREDFECHA DESC",array($suministro));
      return $query->result_array();
    }
    public function get_convenios_sin_pagar($suministro){
        $query = $this->oracle->query("SELECT CREDNRO FROM PRDDBFCOMERCIAL.CREDIT C1 INNER JOIN PRDDBFCOMERCIAL.LETRAS LE ON (C1.CREDNRO = LE.CREDIT_CREDNRO)
                                        AND (C1.AGENCI_OFICIN_OFICOD = LE.CREDIT_AGENCI_OFICIN_OFICOD) AND (C1.AGENCI_OFIAGECOD = LE.CREDIT_AGENCI_OFIAGECOD)WHERE C1.CLIUNICOD = ? AND 
                                        C1.CREDSTATUS='I' AND LE.LTSTATUS = 'I' GROUP BY C1.CREDNRO", array($suministro));
        return $query->result_array();
    }
    public function get_detalles_convenios($oficina,$agencia,$credito){
        $query = $this->oracle->query("SELECT /*+ INDEX (CREDIT_AGENCI_OFICIN_OFICOD, CREDIT_AGENCI_OFIAGECOD, CREDIT_CREDNRO) */ LET.CREDIT_AGENCI_OFICIN_OFICOD, LET.LTSALDO, LET.LTVALOR, LET.LTINTER, LET.LTGACOBZ, LET.LTACCION, 
                                    LET.LTCUOTA, LET.LTIGV, LET.CREDIT_AGENCI_OFIAGECOD, LET.LTVENCIM, LET.LTSTATUS, LET.FACNROX, LET.FACSERNROX, LET.LTFECCANC, LET.CREDIT_CREDNRO, LET.LTNUM ,MES.MESTDESC FROM PRDDBFCOMERCIAL.LETRAS 
                                    LET  INNER JOIN PRDDBFCOMERCIAL.MESTADOS MES ON LET.LTSTATUS = MES.MESTABR
                                    WHERE CREDIT_AGENCI_OFICIN_OFICOD = ? AND CREDIT_AGENCI_OFIAGECOD = ? AND CREDIT_CREDNRO = ?",array($oficina,$agencia,$credito));
        return $query->result_array();
    }
    public function get_one_convenio($suministro,$credito){
        $query = $this->oracle->query("SELECT /*+ INDEX (CLIUNICOD, CREDNRO) */ CRED.CREDNRO, CRED.CREDTIPO, CRED.CONCEP_FACCONCOD, CRED.NROLTS, CRED.CTAINICIAL, CRED.CREDREFE, CRED.CREDFECHA, CRED.DEUDATOTAL, CRED.CREDSTATUS, CRED.CREDFECHA,CON.FACCONDES FROM 
                                    PRDDBFCOMERCIAL.CREDIT CRED JOIN PRDDBFCOMERCIAL.CONCEP CON ON CRED.CONCEP_FACCONCOD = CON.FACCONCOD WHERE CLIUNICOD = ? AND CREDNRO = ? ", array($suministro,$credito));
        return $query->row_array();
    }
    public function deuda_x_convenio($oficina, $agencia,$credito){
        $query = $this->oracle->query("SELECT SUM(LTCUOTA) AS TOTAL FROM PRDDBFCOMERCIAL.LETRAS WHERE CREDIT_AGENCI_OFICIN_OFICOD = ? AND CREDIT_AGENCI_OFIAGECOD = ? AND CREDIT_CREDNRO = ?  AND LTSTATUS = 'I'",
                                        array($oficina, $agencia, $credito));
        return $query->row_array()['TOTAL'];
    }
    public function num_letras_pendientes($oficina, $agencia, $credito){
        $this->oracle->select('COUNT(LTCUOTA) AS TOTAL');
        $this->oracle->where('CREDIT_AGENCI_OFICIN_OFICOD',$oficina); 
        $this->oracle->where('CREDIT_AGENCI_OFIAGECOD',$agencia); 
        $this->oracle->where('CREDIT_CREDNRO',$credito); 
        $this->oracle->where('LTSTATUS','I'); 
        return  $this->oracle->get('PRDDBFCOMERCIAL.LETRAS')->row_array()['TOTAL'];
        $this->oracle->flush_cache();
    }
    public function obtenerConsumos($cod){
        $query = $this->oracle->query("SELECT * FROM (SELECT CTACTEFAC.PROCESOFAC AS LECPERIO,
                                        NVL(CTACTEFAC.LECTURA,0) AS LECACTUA,
                                        NVL(CTACTEFAC.VOLMED,0) AS LECCONME,
                                        CASE
                                        WHEN CTACTEFAC.TIPIMP = 'L' THEN 'IMPLANTACION DE LECTURA'
                                        WHEN CTACTEFAC.TIPIMP = 'P' THEN 'PROMEDIO'
                                        WHEN CTACTEFAC.TIPIMP = 'A' THEN 'ASIGNADO'
                                        ELSE 'LECTURA NORMAL'
                                        END AS LECTIPO,
                                        NVL(OBSLEC.MEDOBSDES, 'SIN OBSERVACION') AS REFERENCIA,
                                        NVL(CTACTEFAC.VOLFAC,0) AS LECCONFA
                                        FROM PRDDBFCOMERCIAL.CTACTEFAC
                                        LEFT JOIN PRDDBFCOMERCIAL.OBSLEC ON CTACTEFAC.OBSLEC = OBSLEC.MEDOBSCOD
                                        WHERE CLICODFAC = ?
                                        ORDER BY CLICODFAC, PROCESOFAC DESC) WHERE ROWNUM < 14",array($cod));
      return $query->result_array();
    }
    public function get_count_acciones_coercitivas($suministro){
        $query = $this->oracle->query('SELECT COUNT(ORDENCOR_OC_OFI) AS CANTIDAD FROM PRDDBFCOMERCIAL.TCORTADO WHERE CLIUNICOD = ? ', array($suministro));
        return $query->row_array()['CANTIDAD'];
    }
    public function get_acciones_coercitivas($suministro){
        $query = $this->oracle->query('SELECT ORDENCOR_OC_OFI,ORDENCOR_OC_AGE,ORDENCOR_ORC_NUM FROM PRDDBFCOMERCIAL.TCORTADO where CLIUNICOD = ? ORDER BY H_NW_FSALD DESC', array($suministro));
        return $query->result_array();
    }
    public function get_orden_corte($ofi,$age,$num){
        $query = $this->oracle->query('SELECT ORT.ORC_FECH, ORT.ORC_HORA, ORT.TACCORTE_ACC_CODIGO, ES.ORC_DESC FROM PRDDBFCOMERCIAL.ORDENCOR ORT JOIN 
                                        PRDDBFCOMERCIAL.ESTADOOT ES ON ORT.ESTADOOT_ORC_ESTADO = ES.ORC_ESTADO WHERE OC_OFI = ? AND OC_AGE = ? AND ORC_NUM = ?', array($ofi,$age,$num));
        return $query->row_array();
    }
    public function get_acciones_reconexion($of,$age,$nro,$suministro){
        $query = $this->oracle->query('SELECT REA_CRT ,REA_CAB_REA_OFI, REA_CAB_REA_AGE, REA_CAB_REA_NRO, REA_OBR, REA_HOB, REA_FOB FROM PRDDBFCOMERCIAL.REA_DET 
                                      WHERE ACCIADD_ORDENCOR_OC_OFI = ? AND ACCIADD_ORDENCOR_OC_AGE = ? AND ACCIADD_ORDENCOR_ORC_NUM = ? AND ACCIADD_CLIUNICOD = ?', array($of,$age,$nro,$suministro));
        return $query->row_array();
    }
    public function get_acciadd($ofi,$age,$num,$suministro){
        $query = $this->oracle->query('SELECT PNIVELCO_NIV_CODI,TOBSERVA_OBS_CODI,TCORTADO_ORDENCOR_OC_OFI,TCORTADO_ORDENCOR_OC_AGE,TCORTADO_ORDENCOR_ORC_NUM,TCORTADO_CLIUNICOD,DONEFECH,DONEHORA,LOADHORA
                                      FROM PRDDBFCOMERCIAL.ACCIADD where TCORTADO_ORDENCOR_OC_OFI = ? AND TCORTADO_ORDENCOR_OC_AGE = ? AND TCORTADO_ORDENCOR_ORC_NUM = ? AND TCORTADO_CLIUNICOD = ? ORDER BY DONEFECH DESC', array($ofi,$age,$num,$suministro));
        return $query->result_array();
    }
    public function  get_nivel_corte($id){
        $query = $this->oracle->query('SELECT NIV_ABRV from PRDDBFCOMERCIAL.PNIVELCO WHERE NIV_CODI = ?', array($id));
        return $query->row_array()['NIV_ABRV'];
    }
    public function get_observacion_corte($id){
        $query = $this->oracle->query('SELECT OBS_DETA from PRDDBFCOMERCIAL.TOBSERVA WHERE OBS_CODI = ?', array($id));
        return $query->row_array()['OBS_DETA'];
    }
    public function get_recibos_x_corte1($ofi,$age,$num,$suministro){
        $query = $this->oracle->query('SELECT NW_FECHA FROM PRDDBFCOMERCIAL.DETRECIB WHERE OFICOD = ? AND OFIAGECOD = ? AND ORC_NUM = ? AND CLIUNICOD = ? ORDER BY NW_FECHA DESC', array($ofi,$age,$num,$suministro));
        return $query->row_array();
    }
    public function get_service1($service){
        $query = $this->oracle->query('SELECT RCOR_ABRV FROM PRDDBFCOMERCIAL.TRESPCOR WHERE RCOR_CODI = ?', array($service));
        return $query->row_array()['RCOR_ABRV'];
    }
    public function get_fecha_cab($ofi,$age,$nro){
        $query = $this->oracle->query('SELECT REA_FEC FROM PRDDBFCOMERCIAL.REA_CAB WHERE REA_OFI = ? AND REA_AGE = ? AND REA_NRO = ?', array($ofi,$age,$nro));
        return $query->row_array()['REA_FEC'];
    }
    public function get_hora_cab($ofi,$age,$nro){
        $query = $this->oracle->query('SELECT REA_HRA FROM PRDDBFCOMERCIAL.REA_CAB WHERE REA_OFI = ? AND REA_AGE = ? AND REA_NRO = ?', array($ofi,$age,$nro));
        return $query->row_array()['REA_HRA'];
    }
    public function get_obs($id){
        $query = $this->oracle->query('SELECT OBS_DETA FROM PRDDBFCOMERCIAL.TOBSERVA WHERE OBS_CODI = ?', array($id));
        return $query->row_array()['OBS_DETA'];
    }
    public function get_cartera($codigo){
        $query = $this->oracle->query('SELECT ACC_ABRV FROM PRDDBFCOMERCIAL.TACCORTE where ACC_CODIGO = ? ', array($codigo));
        return $query->row_array()['ACC_ABRV'];
    }
    public function get_recibos_x_corte($ofi,$age,$num,$suministro){
        $query = $this->oracle->query('SELECT FACSERNRO, FACNRO, NW_FECHA, REC_SALDO, NW_ST FROM PRDDBFCOMERCIAL.DETRECIB WHERE OFICOD = ? AND OFIAGECOD = ? AND ORC_NUM = ? AND CLIUNICOD = ?', array($ofi,$age,$num,$suministro));
        return $query->result_array();
      }
    public function get_otros_cortes($suministro){
        $query = $this->oracle->query('SELECT ACC.TCORTADO_ORDENCOR_OC_OFI, ACC.TCORTADO_ORDENCOR_OC_AGE, ACC.TCORTADO_ORDENCOR_ORC_NUM ,ACC.DONEFECH, ACC.DONEHORA, TRES.NIV_DETA, ACC.PNIVELCO_NIV_CODI,
                                        ACC.TOBSERVA_OBS_CODI, TOB.OBS_DETA  FROM PRDDBFCOMERCIAL.ACCIADD ACC JOIN PRDDBFCOMERCIAL.PNIVELCO TRES ON ACC.PNIVELCO_NIV_CODI = TRES.NIV_CODI
                                        JOIN PRDDBFCOMERCIAL.TOBSERVA TOB ON ACC.TOBSERVA_OBS_CODI =  TOB.OBS_CODI WHERE TCORTADO_CLIUNICOD = ? ORDER BY DONEFECH ASC', array($suministro));
        return $query->result_array();
    }
    public function get_codigo_catastral($codigo){
        $query = $this->oracle->query("SELECT PREREGION,PREZONA,PRESECTOR,PREMZN,PRELOTE,CLICODID,CLICODIGO FROM PRDCOMCATMEDLEC.CLIENT WHERE CLICODFAC = ? ",array($codigo));
        return $query->row_array();
    }
    public function get_duplicado_recibo($serie,$numero,$suministro){
        $query = $this->oracle->query("SELECT FACSERNRO, FACNRO, FACEMIFEC, FACCHEDIG, PREREGIOX, PREZONX, PRESECTOX, PREMZN, PRELOTE, FACVENFEC, FMEDIDOR,
                                      FACTARIFA, FSETIPCOD,CLICODID, CLICODIGO, FACTOTSUB, FACIGV, FACTOTAL FROM 
                                      PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ? AND 
                                      CLICODFAX = ?",array($serie,$numero,$suministro));
        return $query->row_array();
    }
    public function getReciboPorFecha($suministro, $fecha1, $fecha2){
        $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX = ? AND FACEMIFEC BETWEEN ? AND ?', array( $suministro, $fecha1, $fecha2));
        return $query->row_array();
    }
      /**/
      public function get_duplicado_recibo_faclin($serie,$numero){
        $query = $this->oracle->query("SELECT FAC.FACLINRO, FAC.CONCEP_FACCONCOD, FAC.FACPRECI, CON.FACCONDES FROM PRDDBFCOMERCIAL.FACLIN FAC INNER JOIN 
                                        PRDDBFCOMERCIAL.CONCEP CON ON FAC.CONCEP_FACCONCOD =  CON.FACCONCOD
                                        WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
        return $query->result_array();
      }
      /**/
      public function get_duplicado_recibo_letfac($serie,$numero){
        $query = $this->oracle->query("SELECT LET.FACCUOLIN, LET.CONCEP_FACCONCOD, CON.FACCONDES,LET.CRECUOMON, LET.LTNUM, LET.CRECUONRO, LET.CREDNRO 
                                        FROM PRDDBFCOMERCIAL.LETFAC LET INNER JOIN 
                                        PRDDBFCOMERCIAL.CONCEP CON ON LET.CONCEP_FACCONCOD =  CON.FACCONCOD
                                        WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
        return $query->result_array();                                      
      }
      /**/
      public function get_lecturas($suministro,$periodo){
        $query = $this->oracle->query("SELECT LECTURA, LECANT FROM PRDDBFCOMERCIAL.CTACTEFAC WHERE CLICODFAC = ? AND PROCESOFAC = ?",array($suministro,$periodo));
        return $query->row_array();
      }
      /**/
      public function get_periodo_duplicado2($serie,$numero){
        $query = $this->oracle->query("SELECT PROCESOFAC FROM PRDDBFCOMERCIAL.CTACTEFAC WHERE SERIE = ? AND NUMERO = ?",array($serie,$numero));
        return $query->row_array()['PROCESOFAC'];
      }
      /**siac en genesys */
      public function getLecturas($suministro){
        $this->pg1 = $this->load->database('pg', TRUE);
        $query = $this->pg1->query('SELECT distinct on("LecId")
                                    "OrtNum" as "ORDEN_TRABAJO",
                                    CASE WHEN exists (SELECT "GprCod" FROM "Grupo_predio" WHERE "GprId" = "Lectura"."LecGprId" )
                                    THEN (SELECT "GprCod" FROM "Grupo_predio" WHERE "GprId" = "Lectura"."LecGprId")
                                    ELSE \'\'
                                    END AS "CICLO",
                                    "LecNom" as "NOMBRE",
                                    "LecUrb" as "URBANIZACION",
                                    "LecCal" as "CALLE",
                                    "LecMun" as "CLIMUNNRO",
                                    "LecMed" as "MEDCODYGO",
                                    CASE 
                                    WHEN ("LecVal" IS NOT NULL) THEN "LecVal"
                                    ELSE 0
                                    END as "LECTURA",
                                    CASE 
                                    WHEN ("LecQCImg" IS NOT FALSE) THEN "LecImg"
                                    ELSE NULL
                                    END as "IMGLEC",
                                    CASE 
                                    WHEN ("LecQCImg2" IS NOT FALSE) THEN "LecImg2"
                                    ELSE NULL
                                    END as "IMGOPC",
                                    CASE WHEN exists (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Lectura" INNER JOIN "Observacion" ON "ObsId" = "OleObsId" 
                                          WHERE "OleLecId" = "LecId" AND "OleOrd" = 1 GROUP BY "OleLecId", "OleObsId","ObsCod","OleOrd","ObsDes" ORDER BY MIN ("OleId") LIMIT 1)
                                    THEN (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Lectura" INNER JOIN "Observacion" ON "ObsId" = "OleObsId" 
                                          WHERE "OleLecId" = "LecId" AND "OleOrd" = 1 GROUP BY "OleLecId", "OleObsId","ObsCod","OleOrd","ObsDes" ORDER BY MIN ("OleId") LIMIT 1)
                                    ELSE \'0\'
                                    END AS "OBS",
                                    CASE WHEN exists (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Lectura" INNER JOIN "Observacion" ON "ObsId" = "OleObsId" 
                                          WHERE "OleLecId" = "LecId" AND "OleOrd" = 2 GROUP BY "OleLecId", "OleObsId","ObsCod","OleOrd","ObsDes" ORDER BY MIN ("OleId") LIMIT 1)
                                    THEN (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Lectura" INNER JOIN "Observacion" ON "ObsId" = "OleObsId" 
                                          WHERE "OleLecId" = "LecId" AND "OleOrd" = 2 GROUP BY "OleLecId", "OleObsId","ObsCod","OleOrd","ObsDes" ORDER BY MIN ("OleId") LIMIT 1)
                                    ELSE \'0\'
                                    END AS "OBS2", 
                                    (SELECT CAST((CASE WHEN ("OleQCImg" IS NOT FALSE) THEN "OleImg" ELSE NULL END) AS varchar) FROM "Observaciones_Lectura" JOIN "Observacion" ON "OleObsId" = "ObsId" AND "OleLecId" = "LecId" AND "OleEli"=FALSE) as "IMGSOBS",
                                    to_date(to_char("SolFchEj", \'DD/MM/YYYY\'), \'DD/MM/YYYY\') as "FECLEC",
                                    "LecSanMed" as "REFUBIME",
                                    CASE WHEN ((SELECT "OleObsId" FROM "Observaciones_Lectura" WHERE "OleLecId" = "LecId" LIMIT 1) = 24)
                                    THEN "LecSanMed"
                                    ELSE NULL
                                    END as "NEWMED",
                                    \'S\' as "CESTPRE"
                                    FROM "Lectura"
                                    inner join "Suborden_lectura" ON "LecSolId" = "SolId" 
                                    inner join "Orden_trabajo" ON "OrtId" = "SolOrtId"
                                    inner join "Grupo_predio" ON "GprId" = "SolGprId"
                                    WHERE "LecCodFc" = ? AND "LecEli" = FALSE AND "LecTipId" = 13  
                                    AND "OrtEli" = FALSE AND "SolEli" = FALSE ORDER BY "LecId" DESC',array($suministro));
        return $query->result_array();
      }
  
      public function getRelecturas($suministro){
        $this->pg1 = $this->load->database('pg', TRUE);
        $query = $this->pg1->query('SELECT distinct on("RlecId")
        "OrelNum" as "ORDEN_TRABAJO",
        CASE WHEN exists (SELECT "GprCod" FROM "Grupo_predio" WHERE "GprId" = "Relectura"."RlecGprId" )
        THEN (SELECT "GprCod" FROM "Grupo_predio" WHERE "GprId" = "Relectura"."RlecGprId")
        ELSE \'\'
        END AS "CICLO",
        "RlecNom" as "NOMBRE",
        "RlecUrb" as "URBANIZACION",
        "RlecCal" as "CALLE",
        "RlecMun" as "CLIMUNNRO",
        "RlecMed" as "MEDCODYGO",
        CASE 
        WHEN ("RlecVal" IS NOT NULL) THEN "RlecVal"
        ELSE 0
        END as "RELECTURA",
        "RlecImg" as "IMGRLEC",
        "RlecImg2" as "IMGOPC",
        CASE WHEN exists (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Relectura" INNER JOIN "Observacion" ON "ObsId" = "OrleObsId" 
          WHERE "OrleRlecId" = "RlecId" AND "OrleOrd" = 1 GROUP BY "OrleRlecId", "OrleObsId","ObsCod","OrleOrd","ObsDes" ORDER BY MIN ("OrleId") LIMIT 1)
          THEN (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Relectura" INNER JOIN "Observacion" ON "ObsId" = "OrleObsId" 
                     WHERE "OrleRlecId" = "RlecId" AND "OrleOrd" = 1 GROUP BY "OrleRlecId", "OrleObsId","ObsCod","OrleOrd","ObsDes" ORDER BY MIN ("OrleId") LIMIT 1)
            ELSE \'0\'
            END AS "OBS",
        CASE WHEN exists (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Relectura" INNER JOIN "Observacion" ON "ObsId" = "OrleObsId" 
                      WHERE "OrleRlecId" = "RlecId" AND "OrleOrd" = 2 GROUP BY "OrleRlecId", "OrleObsId","ObsCod","OrleOrd","ObsDes" ORDER BY MIN ("OrleId") LIMIT 1)
              THEN (SELECT "ObsCod" || \' - \' || "ObsDes" FROM "Observaciones_Relectura" INNER JOIN "Observacion" ON "ObsId" = "OrleObsId" 
                      WHERE "OrleRlecId" = "RlecId" AND "OrleOrd" = 2 GROUP BY "OrleRlecId", "OrleObsId","ObsCod","OrleOrd", "ObsDes" ORDER BY MIN ("OrleId") LIMIT 1)
             ELSE \'0\'
          END AS "OBS2", 
        (SELECT CAST("OrleImg" AS varchar) FROM "Observaciones_Relectura" JOIN "Observacion" ON "OrleObsId" = "ObsId" AND "OrleRlecId" = "RlecId" AND "OrleEli"=FALSE) as "IMGSOBS",
        to_date(to_char("SorlFchEj", \'DD/MM/YYYY\'), \'DD/MM/YYYY\') as "FECRLEC",
        "RlecSanMed" as "REFUBIME",
        CASE WHEN ((SELECT "OrleObsId" FROM "Observaciones_Relectura" WHERE "OrleRlecId" = "RlecId" LIMIT 1) = 24)
        THEN "RlecSanMed"
        ELSE NULL
        END as "NEWMED",
        \'S\' as "CESTPRE",
        "RlecFchRgMov",
        to_date(to_char("SolFchEj", \'DD/MM/YYYY\'), \'DD/MM/YYYY\') as "FECLEC",	
        "LecImg",
        "LecImg2","LecFchRgMov","LecQCImg","LecQCImg2","LecVal","LecMed","OrtNum"
        FROM "Relectura"
        inner join "Suborden_relectura" ON "RlecSorlId" = "SorlId" 
        inner join "Orden_trabajo_relectura" ON "OrelId" = "SorlOrelId"
        inner join "Grupo_predio" ON "GprId" = "SorlGprId"
        LEFT JOIN "Lectura" ON "LecCodFc"="RlecCodFc" AND "LecEli" IS FALSE
        LEFT JOIN "Suborden_lectura" ON "SolId"="LecSolId" AND "SolTipId"=16 AND "SolEli" IS FALSE
        LEFT JOIN "Orden_trabajo" ON "SolOrtId" = "OrtId"
        WHERE  "RlecCodFc" = ? AND "RlecEli" = FALSE AND "RlecTipId" = 100 
        AND "OrelEli" = FALSE AND "SorlEli" = FALSE 
        AND "SolOrtId" = "OrelOrtId"
          ORDER BY "RlecId" DESC',array($suministro));
          return $query->result_array();
      }
  
      public function getNotificacionesFacturacion($suministro){
        $this->pg1 = $this->load->database('pg', TRUE);
        $query = $this->pg1->query('SELECT 
        row_number() OVER (ORDER BY "NtId") as "ITEM",
            "SacDes" as "SUBACTIVIDAD",
            "OrtNum" as "ORDEN_TRABAJO",
            "NtDmpLoc" as "LOCALIDAD",
            "NtFchEm" as "FECHA_EMISION",
            "NtApeNom" as "USUARIO_RCLTE",
            "NtRazSoc" as "RAZON_SOCIAL",
            "NtPreCal" as "CAL_PRE",
            "NtDmpCal" as "CAL_PROC",
            "NtNroRcl" as "RECLAMO",
            "NtNmSu" as "SUMINISTRO",
            "NtTipRcl" as "TIP_RECL",
            "NtDocEm" as "DOC_EM",
            CASE WHEN exists (SELECT "NtFchRegMov" FROM "Notificacion" b WHERE "NtFchRegMov" IS NOT NULL AND a."NtId" = b."NtId" LIMIT 1)
            THEN 
            (
               CASE WHEN exists (SELECT "NtFchSegVis" FROM "Notificacion" c WHERE "NtFchSegVis" IS NOT NULL AND a."NtId" = c."NtId" LIMIT 1)
           THEN \'2\'
           ELSE \'1\'
               END
            )
            ELSE \'0\'
            END as "NRO_VIS",
        "NtNomRecRcl" as "PRMVIS_RCL",
        CASE WHEN exists (SELECT "NtFchSegVis" FROM "Notificacion" d WHERE "NtFchSegVis" IS NOT NULL AND a."NtId" = d."NtId" LIMIT 1)
        THEN "NtNomRecRcl"
        ELSE NULL
            END AS "SEGVIS_RCL",
            "NtDniRecRcl" as "DNI_RCL",
            CASE WHEN exists (SELECT "NtFirRecRcl" FROM "Notificacion" e WHERE "NtFirRecRcl"=TRUE AND a."NtId" = e."NtId" LIMIT 1)
        THEN \'SI\'
        ELSE \'NO\'
            END as "FIR_RCL",
            NULL as "PRMVIS_PER_DIS",
            NULL as "SEGVIS_PER_DIS",
            "NtNomRecPrDis" as "NOMBRE_RECPRDIS",
            "NtDniRecPrDis" as "DNI_PER_DIS",
            CASE WHEN exists (SELECT "NtFirRecPrDis" FROM "Notificacion" g WHERE "NtFirRecPrDis"=TRUE AND a."NtId" = g."NtId" LIMIT 1)
        THEN \'SI\'
        ELSE \'NO\'
            END as "FIR_PER_DIS",
            "NtPscRcl" as "PARENTEZCO",
        concat("NtCarFac",\' \',"NtSumEne") as "OBS_PRMVIS",
        CASE WHEN exists (SELECT "NtFchSegVis" FROM "Notificacion" h WHERE "NtFchSegVis" IS NOT NULL AND a."NtId" = h."NtId" LIMIT 1)
        THEN concat("NtCarFac",\' \',"NtSumEne")
        ELSE NULL
            END AS "OBS_SEGVIS",
            "NtFchRegMov"::date as "FECHA",
            "NtFchRegMov"::time as "HORA",
            \'BAJO PUERTA\' as "TIPO_ENTREGA",
            CASE WHEN exists (SELECT "ObsCod" FROM "Observaciones_Notificacion" INNER JOIN "Observacion" ON "ObsId" = "OntObsId" WHERE "OntNtId" = "NtId" LIMIT 1)
            THEN (SELECT "ObsCod" FROM "Observaciones_Notificacion" INNER JOIN "Observacion" ON "ObsId" = "OntObsId" WHERE "OntNtId" = "NtId" LIMIT 1)
            ELSE \'0\'
            END AS "OBS_MOV",
            "NtImg" as "IMGNOT",
            "NtImg2" as "IMGOPC",
            "NtFicDgl" as "Ficha",
            "NtFicPreNt" as "FichaPre"
            FROM "Notificacion" a
            inner join "Suborden_notificacion" ON "NtSonId" = "SonId" 
            inner join "Orden_trabajo" ON "OrtId" = "SonOrtId"
            INNER JOIN "Subactividad" ON "SacId" = "NtSacId"
            WHERE "NtNmSu" = ? AND "NtEli" = FALSE AND "SonTipNt" = 79
            AND "NtTipId" = 84  
            AND "OrtEli" = FALSE AND "SonEli" = FALSE ORDER BY "NtId" DESC', array($suministro));
        return $query->result_array();
      }
  
      public function getInspeccionesInternas($suministro){
        $this->pg1 = $this->load->database('pg', TRUE);
        $InoTipId = $this->get_one_detParam_x_codigo('ins_reg');
        $intReclUsoUnico = $this->get_one_subactividad_x_codigo('inspeccion_interna_reclamo_uso_unico');
        $intReclUsoMultiple = $this->get_one_subactividad_x_codigo('inspeccion_interna_reclamo_uso_multiple');
        $internaUsoUnico = $this->get_one_subactividad_x_codigo('inspeccion_interna_uso_unico');
        $internaUsoMultiple = $this->get_one_subactividad_x_codigo('inspeccion_interna_uso_multiple');
        $insConGeofono = $this->get_one_subactividad_x_codigo('inspeccion_geofono');
        $insIntExterna = $this->get_one_subactividad_x_codigo('inspeccion_externa');
        $query = $this->pg1->query('SELECT 
        "SacDes" as "SUBACTIVIDAD",
        "OrtNum" as "ORDEN_TRABAJO",
        "InoNroRcl" as "NumReclamo",
        "InoApeNom" as "NomApClte",
        "InoSum" as "CodigoFac",
        "InoPreUrb" as "Urbanizacion",
        "InoPreCal" as "Calle",
        "InoPreNroMun" as "NumeroMun",
        "InoPreMed" as "Medidor",
        "FinFchRgDig" as "FechInsp",
        CASE WHEN "FinHraIniDig" IS NOT NULL AND "FinHraFinDig" IS NOT NULL 
         THEN concat("FinHraIniDig",\' a \',"FinHraFinDig")
             ELSE \'\' 
        END as "HoraInsp",
        CASE WHEN "InoSacId" = ? OR "InoSacId" = ? OR "InoSacId" = ? OR "InoSacId" = ? OR "InoSacId" = ? THEN \'INTERNA\' 
         WHEN "InoSacId" = ? THEN \'EXTERNA\'
             ELSE \'\' 
        END as "TipoInsp",
        "FinNumHab" as "NumHabts",
        "FinNumPis" as "NumPisos",
        (SELECT string_agg(CAST("FiuDprId" AS varchar), \',\') FROM "Ficha_interna_unidad" c WHERE c."FiuFinId" = a."FinId") as "TipoUnidUso",
        "FinUsoInm" as "UsoInmueble",
        "FinUltLec" as "Lectura",
        (SELECT string_agg(concat(CAST("FiucDprId1" AS varchar),\'_\',CAST("FiucDprId2" AS varchar),\',\',CAST("FiucCant" AS varchar)), \';\') FROM "Ficha_interna_unidad_cantidad" b WHERE b."FiucFinId" = a."FinId") as "UnidadCantidad",
        CASE WHEN "FinFirPersPresInsp" IS TRUE 
        THEN \'SI\' 
        ELSE \'NO\' 
        END as "Firma",
        "FinObsInstSanit" as "Observacion",
        Xt."DprDes" AS "TipoUso",
        "FinCodFic" as "NumActa",
        (SELECT string_agg(CAST("FiiImgRut" AS varchar), \',\') FROM "Ficha_interna_imagenes" WHERE "Ficha_interna_imagenes"."FiiImgFinId" = a."FinId") as "ImgIno",
        "InoFicDgl" as "Ficha"
        FROM "Inspeccion_otra" 
        inner join "Ficha_interna" a ON "FinInoId" = "InoId"
        inner join "Suborden_inspecciones" ON "InoSoinId" = "SoinId" 
        inner join "Orden_trabajo" ON "OrtId" = "SoinOrtId"
        INNER JOIN "Subactividad" ON "SacId" = "InoSacId"
        left join "Detalle_parametro" Xt on Xt."DprId"="InoTipoUso"
        WHERE "InoSum" = ? AND "InoEli" = FALSE 
        AND "InoTipId" = ?  AND "OrtEli" = FALSE AND "SoinEli" = FALSE ORDER BY "InoId" DESC', array($intReclUsoUnico, $intReclUsoMultiple, $internaUsoUnico, $internaUsoMultiple, $insConGeofono, $insIntExterna, $suministro,  $InoTipId ));
        return $query->result_array();
      }
  
      private function get_one_detParam_x_codigo($codigo){
        $this->pg1 = $this->load->database('pg', TRUE);
        $query = $this->pg1->query('SELECT "DprId" FROM "Detalle_parametro" WHERE "DprCod" = ? AND "DprEli" = FALSE', array($codigo));
        return $query->row_array()['DprId'];
      }
  
      private function get_one_subactividad_x_codigo($codigo){
        $this->pg1 = $this->load->database('pg', TRUE);
        $query = $this->pg1->query('SELECT "SacId" FROM "Subactividad" WHERE "SacCod" = ? AND "SacEli" = FALSE', array($codigo));
        return $query->row_array()['SacId'];
      }
  
      public function getInspeccionesExternas($suministro){
        $this->pg1 = $this->load->database('pg', TRUE);
        $InoTipId = $this->get_one_detParam_x_codigo('ins_reg');
        $intReclUsoUnico = $this->get_one_subactividad_x_codigo('inspeccion_interna_reclamo_uso_unico');
        $intReclUsoMultiple = $this->get_one_subactividad_x_codigo('inspeccion_interna_reclamo_uso_multiple');
        $internaUsoUnico = $this->get_one_subactividad_x_codigo('inspeccion_interna_uso_unico');
        $internaUsoMultiple = $this->get_one_subactividad_x_codigo('inspeccion_interna_uso_multiple');
        $insConGeofono = $this->get_one_subactividad_x_codigo('inspeccion_geofono');
        $insIntExterna = $this->get_one_subactividad_x_codigo('inspeccion_externa');
        $query = $this->pg1->query('SELECT 
        "SacDes" as "SUBACTIVIDAD",
        "OrtNum" as "ORDEN_TRABAJO",
        "InoNroRcl" as "NumReclamo",
        "InoApeNom" as "NomApClte",
        "InoSum" as "CodigoFac",
        "InoPreUrb" as "Urbanizacion",
        "InoPreCal" as "Calle",
        "InoPreNroMun" as "NumeroMun",
        "InoPreMed" as "Medidor",
        "FexFchRgDig" as "FechInsp",
        CASE WHEN "FexHraIniDig" IS NOT NULL AND "FexHraFinDig" IS NOT NULL 
         THEN concat("FexHraIniDig",\' a \',"FexHraFinDig")
             ELSE \'\' 
        END as "HoraInsp",
        CASE WHEN "InoSacId" = ? OR "InoSacId" = ? OR "InoSacId" = ? OR "InoSacId" = ? OR "InoSacId" = ? THEN \'INTERNA\' 
         WHEN "InoSacId" = ? THEN \'EXTERNA\'
            ELSE \'\' 
        END as "TipoInsp",
        "FexObsMed" as "EstadoMed",
        "FexLec" as "Lectura",
        CASE WHEN "FexFugaCaj" IS TRUE THEN \'SI\' 
        WHEN "FexFugaCaj" IS FALSE THEN \'NO\'
            ELSE \'\' 
        END as "Fuga",
        "FexObsSum" as "Observacion",
        "FexDetObsMed" as "DetEstadoMed",
        Xt."DprDes" AS "TipoUso",
        "FexCodFic" as "NumActa",
        (SELECT string_agg(CAST("FeiImgRut" AS varchar), \',\') FROM "Ficha_externa_imagenes" WHERE "Ficha_externa_imagenes"."FeiImgFexId" = a."FexId") as "ImgIno",
        "InoFicDgl" as "Ficha"
        FROM "Inspeccion_otra" 
        inner join "Ficha_externa" a ON "FexInoId" = "InoId"
        inner join "Suborden_inspecciones" ON "InoSoinId" = "SoinId" 
        inner join "Orden_trabajo" ON "OrtId" = "SoinOrtId"
        INNER JOIN "Subactividad" ON "SacId" = "InoSacId"
        left join "Detalle_parametro" Xt on Xt."DprId"="InoTipoUso"
        WHERE "InoSum" = ? AND "InoEli" = FALSE 
        AND "InoTipId" = ?  AND "OrtEli" = FALSE AND "SoinEli" = FALSE ORDER BY "InoId" DESC', array( $intReclUsoUnico, $intReclUsoMultiple, $internaUsoUnico, $internaUsoMultiple, $insConGeofono, $insIntExterna, $suministro,  $InoTipId ));
        return $query->result_array();
      }
  
      public function get_one_parametro($codigo){
        $this->pg1 = $this->load->database('pg', TRUE);
        $query = $this->pg1->query('SELECT "ParId" FROM "Parametro" WHERE "ParCod" = ? AND "ParEli" = FALSE', array($codigo));
        return $query->row_array()['ParId'];
      }
  
      public function get_all_detParamFicha($codigo){
        $this->pg1 = $this->load->database('pg', TRUE);
        $query = $this->pg1->query('SELECT * FROM "Detalle_parametro" WHERE "DprParId" = ? AND "DprEli" = FALSE ORDER BY "DprId" ASC', array($codigo));
        return $query->result_array();
      }

      /** en siac en genesys */










    
    public function get_num_faclin($serie,$numero){
        $query = $this->oracle->query("SELECT COUNT(*) AS TOTAL FROM PRDDBFCOMERCIAL.FACLIN WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
        return $query->row_array()['TOTAL'];
    }
    public function get_num_letfac($serie,$numero){
        $query = $this->oracle->query("SELECT COUNT(*) AS TOTAL FROM PRDDBFCOMERCIAL.LETFAC WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
        return $query->row_array()['TOTAL'];
    }
    public function get_nota_exitente($serie,$numero,$suministro){ //valida si existe una nota de crédito
        $fecha1 = '01/'.date('m/Y');
        $fecha2 = $this->ultimo_dia().'/'.date('m/Y');
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCACLICODF = ? AND NCATIPO = 'A' AND NCAFACESTA = 'I' AND NCAFECHA BETWEEN ? AND ?",array($serie,$numero,$suministro,$fecha1,$fecha2));
        return $query->row_array();
    }



    public function  get_total_recibo($serie,$numero){
        $query =  $this->oracle->query("SELECT FACTOTAL FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO =  ?",array($serie,$numero));
        return $query->row_array()['FACTOTAL'];
    }    

    public function notas_credito($serie,$numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT TOTFAC_FACSERNRO,TOTFAC_FACNRO,NCASERNRO,NCANRO,NCAFACESTA,NCATOTDIF,NCAFACEMIF,NCAFECHA FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = ? AND NCAFACESTA = 'I' ",array($serie,$numero,'A'));
        return $query->row_array();
    }
     public function notas_credito_cantidad($serie,$numero){
      $db_prueba = $this->load->database('oracle', TRUE);
      $query = $db_prueba->query("SELECT COUNT(*) AS TOTAL FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = ? AND NCAFACESTA = 'I' ",array($serie,$numero,'A'));
      return $query->row_array()['TOTAL'];
    }

    public function notas_debito($serie,$numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT TOTFAC_FACSERNRO,TOTFAC_FACNRO,NCASERNRO,NCANRO,NCAFACESTA,NCATOTDIF,NCAFECHA FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = ?",array($serie,$numero,'C'));
        return $query->row_array();
    }

    



  

    


    public function get_agencia($oficod,$ofiagcod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("select * from PRDDBFCOMERCIAL.AGENCI where OFICIN_OFICOD = ? and OFIAGECOD = ?",array($oficod,$ofiagcod));
        return $query->row_array();
    }

    

    

    

   


    public function get_fecha_vencimiento($serie,$numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT FACVENFEC,FACTOTAL FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ?",array($serie,$numero));
        return $query->row_array();
    }

    public function get_fech_pago($serie,$numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT HISCOBFEC FROM PRDDBFCOMERCIAL.PAGHIS WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
        return $query->row_array();
    }

    

   

    

    

    

    

    

  

    public function get_estado_cliente($suministro){
      $query = $this->oracle->query('SELECT CONDESDES,CONESTDES,DESESCLTE, DESTIPSER FROM PRDCOMCATMEDLEC.CLIENT CLI JOIN
                                  PRDCOMCATMEDLEC.ESCLTE ESC ON CLI.CODESCLTE = ESC.CODESCLTE JOIN
                                  PRDCOMCATMEDLEC.TIPSER TIP ON CLI.CODTIPSER =  TIP.CODTIPSER JOIN
                                  PRDCOMCATMEDLEC.COAGUA COA ON CLI.PREREGION = COA.PREREGION AND CLI.PREZONA =  COA.PREZONA AND CLI.PRESECTOR = COA.PRESECTOR AND CLI.PREMZN =  COA.PREMZN AND CLI.PRELOTE = COA.PRELOTE  JOIN
                                  PRDCOMCATMEDLEC.ESTCON EST ON COA.CONESTADO = EST.CONESTADO JOIN
                                  PRDCOMCATMEDLEC.CODESA COD ON CLI.PREREGION =  COD.PREREGION AND CLI.PREZONA =  COD.PREZONA AND CLI.PRESECTOR =  COD.PRESECTOR  AND CLI.PREMZN =  COD.PREMZN AND CLI.PRELOTE =  COD.PRELOTE JOIN
                                  PRDCOMCATMEDLEC.ESTCONDE ESTD ON COD.CONDESTAD = ESTD.CONDESTAD
                                  WHERE CLI.CLICODFAC = ?',array($suministro));
      return $query->row_array();
    }




    public function get_service($codigo){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query('SELECT RCOR_ABRV from PRDDBFCOMERCIAL.TRESPCOR where RCOR_CODI = ? ', array($codigo));
      return $query->row_array()['RCOR_ABRV'];
    }

    


    public function get_recibos_cortes($ofi,$age,$num,$suministro){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query('SELECT * FROM PRDDBFCOMERCIAL.DETRECIB WHERE OFICOD = ? AND OFIAGECOD = ?  AND ORC_NUM = ? AND CLIUNICOD = ?', array($ofi,$age,$num,$suministro));
      return $query->result_array();
    }



    public function get_emision($facsernro,$nro){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query('SELECT FACEMIFEC FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ? ', array($facsernro,$nro));
      return $query->row_array()['FACEMIFEC'];
    }


    public function get_observacion_corte1($id){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query('SELECT OBS_ABRV from PRDDBFCOMERCIAL.TOBSERVA WHERE OBS_CODI = ?', array($id));
      return $query->row_array()['OBS_ABRV'];
    }






    public function get_recibos_x_corte2($ofi,$age,$num,$suministro){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query('SELECT DET.*,TOT.FACEMIFEC from PRDDBFCOMERCIAL.DETRECIB DET JOIN
                                  PRDDBFCOMERCIAL.TOTFAC TOT ON DET.FACSERNRO =  TOT.FACSERNRO AND DET.FACNRO =  TOT.FACNRO
                                  WHERE OFICOD = ? AND OFIAGECOD = ? AND ORC_NUM = ? AND CLIUNICOD = ? ORDER BY NW_FECHA DESC', array($ofi,$age,$num,$suministro));
      return $query->result_array();
    }

    public function save_new_nc($suministro,$serie,$numero,$referencia,$serie_user,$conceptos,$conceptos1,$montos,$subtotal,$faclin,$letfac,$metros){
      //obtener fecha de emision del recibo
      $this->oracle->trans_start();
      $volumen = $this->volumen_leido($serie,$numero);
      $vol = 0;
      if($metros != "" && $metros != NULL)  $vol = floatval($volumen) - floatval($metros);
      $query = $this->oracle->query("SELECT FACEMIFEC,FACVENFEC,FACTOTSUB,FACIGV,FACTOTAL,FACESTADO,PREMZN,PRELOTE,PREREGIOX,PREZONX,PRESECTOX,PRELOCALX,
                                      CLICODID,CLICODIGO,FACCHEDIG,FACTARIFA,FSETIPCOD,FAMBITO,FCATEGO,FSUBCATE,FAGABSCOD,FDEABSCOD,FGRUCOD,FGRUSUB,FACOFICOD,
                                      FACOFIAGE,FRUTA,FCICLO,FMEDIDOR,FACSALDO,FACINISAL,FACFINSAL,FIGVREF FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ?",array($serie,$numero));
      $recibo = $query->row_array();
      $reclamo = $this->reclamos($serie,$numero);
      $query2 = $this->oracle->query("SELECT NCANRO FROM PRDDBFCOMERCIAL.NCA WHERE NCASERNRO = ? ORDER BY NCANRO DESC ",array($serie));
      $numero_nc = intval($query2->row_array()['NCANRO']) + 1;
      $igv_monto = 0;
      $i = 0;
      $monto = 0;
      if($conceptos){
        foreach ($conceptos as $c) {
        $igv_si = $this->oracle->query("SELECT FACIGVCOB FROM PRDDBFCOMERCIAL.CONCEP WHERE FACCONCOD = ? AND ESTADO = 1 ",array($c));
        if($igv_si->row_array()['FACIGVCOB'] == 'S'){
            $monto += floatval($faclin[$i]);
            $igv_monto += floatval($faclin[$i])*intval($recibo['FIGVREF'])/100;
         } else {
            $monto += floatval($faclin[$i]);
         }
         $i++;
      }
    }
      $i = 0;
      if($conceptos1){
          foreach ($conceptos1 as $c) {
            $igv_si = $this->oracle->query("SELECT FACIGVCOB FROM PRDDBFCOMERCIAL.CONCEP WHERE FACCONCOD = ? AND ESTADO = 1",array($c));
            if($igv_si->row_array()['FACIGVCOB'] == 'S'){
                $monto += floatval($letfac[$i]);
                $igv_monto += floatval($letfac[$i])*intval($recibo['FIGVREF'])/100;
             } else {
                $monto += floatval($letfac[$i]);
             }
             $i++;
          }
      }
      //$monto = array_sum($montos);
	$fecha_aux = '01/'.date('m/Y');
	$query8 = $this->oracle->query("SELECT SUM(NCASUBDIF) AS TOTAL, SUM(NCAIGVDIF) AS IGV, SUM(NCATOTDIF) AS DIFERENCIA FROM PRDDBFCOMERCIAL.NCA WHERE
                                       TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A' AND NCAFECHA < ?",array($serie,$numero, $fecha_aux));

      /*$query8 = $this->oracle->query("SELECT SUM(NCASUBDIF) AS TOTAL, SUM(NCAIGVDIF) AS IGV, SUM(NCATOTDIF) AS DIFERENCIA FROM 
      PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA = 'P'",array($serie,$numero));*/
      $totalnc = $query8->row_array()['TOTAL'];
      $totalIGV = $query8->row_array()['IGV'];
      $totaldiferencia = $query8->row_array()['DIFERENCIA'];
      $diferencia = number_format((floatval($recibo['FACTOTSUB']) - floatval($totalnc) - $monto),2,'.','');

      $diferencia1 = number_format((floatval($recibo['FACTOTSUB']) - floatval($totalnc)),2,'.','');

      //$igv_monto = number_format($monto*intval($recibo['FIGVREF'])/100,2,'.','');

      $diferencia_igv = number_format((floatval($recibo['FACIGV']) - floatval($totalIGV) - $igv_monto),2,'.','');

      $diferencia_igv1 = number_format((floatval($recibo['FACIGV']) - floatval($totalIGV) ),2,'.','');

      $total = $monto + $igv_monto;

      $diferencia_total = number_format((floatval($recibo['FACTOTAL']) - floatval($totaldiferencia) - $total),2,'.','');
      $diferencia_total1 = number_format((floatval($recibo['FACTOTAL']) - floatval($totaldiferencia)),2,'.','');
      if($faclin) $nca1 = array_sum($faclin);
      else $nca1 = 0;
      if($letfac) $nca2 = array_sum($letfac);
      else $nca2 = 0;
      $query3 = $this->oracle->query("SELECT OFICOD,OFIAGECOD,AUT_NRO FROM PRDDBFCOMERCIAL.NGX_LETS WHERE AUT_SER  = ? AND AUT_REC = ?",array($serie,$numero));
      $autorizacion = $query3->row_array();
      $suminis_aux = "";
      if(substr($suministro,3,4) == "0000") $suminis_aux = substr($suministro, 0,3).substr($suministro,7,4);
      else $suminis_aux = $suministro;
      $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.NCA (NCATIPO,NCASERNRO,NCANRO,TOTFAC_FACSERNRO,TOTFAC_FACNRO,NCAFECHA,NCAFACEMIF,NCAFACVENF,NCAPREMZN,
                                    NCAPRELOTE,NCAPREREG,NCAPRESEC,NCAPRELOC,NCACLICODI,NCACLICOD,NCACLICODF,NCAFACCHED,
                                    NCAFACTARI,NCAFSETIPC,NCAFAMBITO,NCAFCATEGO,NCAFSUBCAT,NCAFAGABSC,NCAFDEABSC,NCAFGRUCOD,
                                    NCAFGRUSUB,NCAFACTOTS,NCAFACIGV,NCAFACTOTA,NCAFACESTA,NCAFACOFIC,NCAFACOFIA,NCAFRUTA,NCAFCICLO,
                                    NCAFMEDIDO,NCAFACSALD,NCAFACINIS,NCAFACFINS,NCAFICOD,NCAFIAGECO,NCADIGCOD,NCASUBDIF,NCASUBOK,NCAIGVDIF,NCAIGVOK,
                                    NCATOTDIF,NCATOTOK,NCAPREZONX,NCAREFE,NCA1,NCA2,REC_NRO,AUT_OFI,AUT_AGE,AUT_NRO,NCA_VOLFAC,NCA_VOLDIF,NCAHRA,NCACREA, NCAFACESTF)
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?)",
                                    array("A",$serie,$numero_nc,$serie,$numero,date('d/m/Y'),$recibo['FACEMIFEC'],$recibo['FACVENFEC'],$recibo['PREMZN'],
                                    $recibo['PRELOTE'],$recibo['PREREGIOX'],$recibo['PRESECTOX'],$recibo['PRELOCALX'],$recibo['CLICODID'],$recibo['CLICODIGO'],$suminis_aux,$recibo['FACCHEDIG'],
                                    $recibo['FACTARIFA'],$recibo['FSETIPCOD'],$recibo['FAMBITO'],$recibo['FCATEGO'],$recibo['FSUBCATE'],$recibo['FAGABSCOD'],$recibo['FDEABSCOD'],$recibo['FGRUCOD'],
                                    $recibo['FGRUSUB'],number_format($diferencia1,2,'.',''),number_format($diferencia_igv1,2,'.',''),number_format($diferencia_total1,2,'.',''),'I',$recibo['FACOFICOD'],$recibo['FACOFIAGE'],$recibo['FRUTA'],$recibo['FCICLO'],
                                    0,$recibo['FACSALDO'],$recibo['FACINISAL'],$recibo['FACFINSAL'],$_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id'],$monto,$diferencia,$igv_monto,$diferencia_igv,
                                    $total,$diferencia_total,$recibo['PREZONX'],$referencia,$nca1,$nca2,$reclamo['RECID'],$autorizacion['OFICOD'],$autorizacion['OFIAGECOD'],$autorizacion['AUT_NRO'],$volumen,$vol,date('H:i:s'),$_SESSION['user_id'], date('d/m/Y')));
      $query6 = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.FACLIN WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?',array($serie,$numero));
      $query7 = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.LETFAC WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? ORDER BY CONCEP_FACCONCOD',array($serie,$numero));
      $query9 = $this->oracle->query("SELECT N2.CONCEP_FACCONCOD, SUM(NCAPREDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                      PRDDBFCOMERCIAL.NCA1 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                      WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A' GROUP BY  N2.CONCEP_FACCONCOD ORDER BY N2.CONCEP_FACCONCOD",array($serie,$numero));
      $query10 = $this->oracle->query("SELECT N2.CONCEP_FACCONCOD, SUM(N2.NCAMONDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                       PRDDBFCOMERCIAL.NCA2 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                       WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A' GROUP BY  N2.CONCEP_FACCONCOD ORDER BY N2.CONCEP_FACCONCOD",array($serie,$numero));
      $fac = $query6->result_array();
      $let = $query7->result_array();
      $monto_fac = $query9->result_array();
      $monto_let = $query10->result_array();
      $k = 0;
   if($fac){   foreach ($fac as $fa) {
        if($monto_fac) $monto_verdadero = number_format((floatval($fa['FACPRECI']) - floatval($monto_fac[$k]['TOTAL'])),2,'.','');
        else  $monto_verdadero = number_format(floatval($fa['FACPRECI']),2,'.','');
        if($monto_fac) $descuento = number_format((floatval($fa['FACPRECI']) - floatval($monto_fac[$k]['TOTAL']) - floatval($faclin[$k])),2,'.','');
        else $descuento = number_format((floatval($fa['FACPRECI']) - floatval($faclin[$k])),2,'.','');
        $query5 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.NCA1 (NCA_NCATIPO,NCA_NCASERNRO,NCA_NCANRO,NCAFACLINR,NCAFACPREC,NCAPREDIF,CONCEP_FACCONCOD,NCAPREOK,NCAFACVOLU)
                                          VALUES (?,?,?,?,?,?,?,?,?)",array('A',$serie,$numero_nc,$fa['FACLINRO'],$monto_verdadero,$faclin[$k],$fa['CONCEP_FACCONCOD'],$descuento,$fa['FACVOLUM']));
        $k++;
      }
  }
      $k  = 0;
   if($let){   foreach ($let as $le) {
        if($monto_let) $monto_verdadero = number_format(floatval($le['CRECUOMON']) - floatval($monto_let[$k]['TOTAL']),2,'.','');
        else $monto_verdadero = number_format(floatval($le['CRECUOMON']),2,'.','');
        if($monto_let) $descuento = number_format((floatval($le['CRECUOMON']) - floatval($monto_let[$k]['TOTAL']) - floatval($letfac[$k])),2,'.','');
        else $descuento = number_format((floatval($le['CRECUOMON']) - floatval($letfac[$k])),2,'.','');
        $query8 = $this->oracle->query('INSERT INTO PRDDBFCOMERCIAL.NCA2 (NCA_NCATIPO,NCA_NCASERNRO,NCA_NCANRO,NCAFACCUOL,NCAOFICOD,CONCEP_FACCONCOD,NCAOFIAGEC,NCACREDN,NCALTNUM,NCACRECUOV,NCACRECUOM,NCACREFUEN,NCACRECUOF,NCACRECUON,NCAMONDIF,NCAMONOK,DRC)
                                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array('A',$serie,$numero_nc,$le['FACCUOLIN'],$le['OFICOD'],$le['CONCEP_FACCONCOD'],$le['OFIAGECOD'],$le['CREDNRO'],$le['LTNUM'],$le['CRECUOVEN'],
                                      $monto_verdadero,$le['CREFUENTE'],$le['CRECUOFLA'],$le['CRECUONRO'],floatval($letfac[$k]),$descuento,$le['DRC']));
        $k++;
      }
  }
      $query11 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NGX_LETS SET AUT_EST = 1,AUT_OPE = ? WHERE AUT_SER = ? AND AUT_REC = ? AND CLIUNICOD = ?", array($_SESSION['user_id'],$serie,$numero,$suministro));
      //$query4 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.DOCUM SET ULTNRO = ? WHERE OFICOD = ? AND OFIAGECOD = ? AND DOCTIP = 'NOTAABO'",array($numero_nc,$_SESSION['OFICOD'],$_SESSION['OFIAGECOD']));
      if($autorizacion) {
        $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NGX_LETS SET AUT_EST = 2 WHERE OFICOD = ? AND OFIAGECOD = ? AND AUT_NRO = ?",array($autorizacion['OFICOD'],$autorizacion['OFIAGECOD'],$autorizacion['AUT_NRO']));
      }
      $query30 = $this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array($suministro));
      if(!$query30->row_array()){
        $query30 = $this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array(substr($suministro, 0,3)."0000".substr($suministro, 3,4)));
      }
      $suministro1 = $suministro;
      if(substr($suministro, 3,4) == "0000"){
        //$this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array(substr($suministro, 0,3).substr($suministro, 7,4)));
        $suministro1 = substr($suministro, 0,3).substr($suministro, 7,4);
      }
      $nombre_cliente = $query30->row_array()['CLINOMBRE'];
      $dni = $query30->row_array()['CLIELECT'];
      $query31 = $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.MDOCGLB (ESECOD,MDCCOD,MDGSERDOC,MDGNRODOC,MDGCODACC1,MDGCODACC2,MDGFCHEMIDOC,MDGFCHVTODOC,MDGFCHVTOCOB,MDGFCHREG,MDGHRAREG,
                                      MDGIMPTOT,SDGCOD,MDGFCHLSTUPD,MDGHRALSTUPD,MDGDNINUM,MDGDNIFREG,MDGDNIHREG,MDGCODACC3)
                                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                      array(1,2,$serie,$numero_nc,0,$suministro1,date('d/m/Y'),date('d/m/Y'),date('d/m/Y'),date('d/m/Y'),date('H:i:s'),
                                      $total,1,date('d/m/Y'),date('H:i:s'),$dni,date('d/m/Y'),date('H:i:s'), substr($nombre_cliente,0,69)));
       $query32 = $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.MDOCRLC (STAESECOD,STAMDCCOD,STAMDGSERDOC,STAMDGNRODOC,STBESECOD,STBMDCCOD,STBMDGSERDOC,STBMDGNRODOC)
                                      VALUES (?,?,?,?,?,?,?,?)",
                                      array(1,1,$serie,$numero,1,2,$serie,$numero_nc));
      $this->oracle->trans_complete();
      if ($this->oracle->trans_status() === FALSE){
        $this->oracle->trans_rollback();
        return false;
      } else {
        $this->oracle->trans_commit();
        return $numero_nc;
      }
    }

    public function anular_total_recibo($suministro,$serie_recibo,$numero_recibo,$referencia,$serie_usuario){
      $this->oracle->trans_start();
      $query = $this->oracle->query("SELECT FACEMIFEC,FACVENFEC,FACTOTSUB,FACIGV,FACTOTAL,FACESTADO,PREMZN,PRELOTE,PREREGIOX,PREZONX,PRESECTOX,PRELOCALX,
                                      CLICODID,CLICODIGO,FACCHEDIG,FACTARIFA,FSETIPCOD,FAMBITO,FCATEGO,FSUBCATE,FAGABSCOD,FDEABSCOD,FGRUCOD,FGRUSUB,FACOFICOD,
                                      FACOFIAGE,FRUTA,FCICLO,FMEDIDOR,FACSALDO,FACINISAL,FACFINSAL,FIGVREF FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ?",array($serie_recibo,$numero_recibo));
      $recibo = $query->row_array();
      $reclamo = $this->reclamos($serie_recibo,$numero_recibo);
      $query2 = $this->oracle->query("SELECT NCANRO FROM PRDDBFCOMERCIAL.NCA WHERE NCASERNRO = ? ORDER BY NCANRO DESC ",array($serie_recibo));
      $numero_nc = intval($query2->row_array()['NCANRO']) + 1;
      $query8 = $this->oracle->query("SELECT SUM(NCASUBDIF) AS TOTAL, SUM(NCAIGVDIF) AS IGV, SUM(NCATOTDIF) AS DIFERENCIA FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A'",array($serie_recibo,$numero_recibo));
      $totalnc = $query8->row_array()['TOTAL'];
      $totalIGV = $query8->row_array()['IGV'];
      $totaldiferencia = $query8->row_array()['DIFERENCIA'];
      $neto = number_format((floatval($recibo['FACTOTSUB']) - floatval($totalnc)),2,'.','');
      $igv = number_format((floatval($recibo['FACIGV']) - floatval($totalIGV)),2,'.','');
      $total = number_format((floatval($recibo['FACTOTAL']) - floatval($totaldiferencia)),2,'.','');
      $query3 = $this->oracle->query("SELECT OFICOD,OFIAGECOD,AUT_NRO FROM PRDDBFCOMERCIAL.NGX_LETS WHERE AUT_SER  = ? AND AUT_REC = ?",array($serie_recibo,$numero_recibo));
      $autorizacion = $query3->row_array();
      $query6 = $this->oracle->query('SELECT SUM(FACPRECI) AS TOTAL FROM PRDDBFCOMERCIAL.FACLIN WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?',array($serie_recibo,$numero_recibo));
      $query7 = $this->oracle->query('SELECT SUM(CRECUOMON) AS TOTAL FROM PRDDBFCOMERCIAL.LETFAC WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?',array($serie_recibo,$numero_recibo));
      $query9 = $this->oracle->query("SELECT SUM(NCAPREDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                      PRDDBFCOMERCIAL.NCA1 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                      WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A' GROUP BY  N2.CONCEP_FACCONCOD ORDER BY N2.CONCEP_FACCONCOD",array($serie_recibo,$numero_recibo));
      $query10 = $this->oracle->query("SELECT SUM(N2.NCAMONDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                       PRDDBFCOMERCIAL.NCA2 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                       WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A' GROUP BY  N2.CONCEP_FACCONCOD ORDER BY N2.CONCEP_FACCONCOD",array($serie_recibo,$numero_recibo));
      $nca1 = number_format((floatval($query6->row_array()['TOTAL']) - floatval($query9->row_array()['TOTAL'])),2,'.','');
      $nca2 = number_format((floatval($query7->row_array()['TOTAL']) - floatval($query10->row_array()['TOTAL'])),2,'.','');
      $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.NCA (NCATIPO,NCASERNRO,NCANRO,TOTFAC_FACSERNRO,TOTFAC_FACNRO,NCAFECHA,NCAFACEMIF,NCAFACVENF,NCAPREMZN,
                                    NCAPRELOTE,NCAPREREG,NCAPRESEC,NCAPRELOC,NCACLICODI,NCACLICOD,NCACLICODF,NCAFACCHED,
                                    NCAFACTARI,NCAFSETIPC,NCAFAMBITO,NCAFCATEGO,NCAFSUBCAT,NCAFAGABSC,NCAFDEABSC,NCAFGRUCOD,
                                    NCAFGRUSUB,NCAFACTOTS,NCAFACIGV,NCAFACTOTA,NCAFACESTA,NCAFACOFIC,NCAFACOFIA,NCAFRUTA,NCAFCICLO,
                                    NCAFMEDIDO,NCAFACSALD,NCAFACINIS,NCAFACFINS,NCAFICOD,NCAFIAGECO,NCADIGCOD,NCASUBDIF,NCASUBOK,NCAIGVDIF,NCAIGVOK,
                                    NCATOTDIF,NCATOTOK,NCAPREZONX,NCAREFE,NCA1,NCA2,REC_NRO,AUT_OFI,AUT_AGE,AUT_NRO,NCAHRA,NCACREA,NCAFACESTF)
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                    array("A",$serie_recibo,$numero_nc,$serie_recibo,$numero_recibo,date('d/m/Y'),$recibo['FACEMIFEC'],$recibo['FACVENFEC'],$recibo['PREMZN'],
                                    $recibo['PRELOTE'],$recibo['PREREGIOX'],$recibo['PRESECTOX'],$recibo['PRELOCALX'],$recibo['CLICODID'],$recibo['CLICODIGO'],$suministro,$recibo['FACCHEDIG'],
                                    $recibo['FACTARIFA'],$recibo['FSETIPCOD'],$recibo['FAMBITO'],$recibo['FCATEGO'],$recibo['FSUBCATE'],$recibo['FAGABSCOD'],$recibo['FDEABSCOD'],$recibo['FGRUCOD'],
                                    $recibo['FGRUSUB'],number_format($neto,2,'.',''),number_format($igv,2,'.',''),number_format($total,2,'.',''),'I',$recibo['FACOFICOD'],$recibo['FACOFIAGE'],$recibo['FRUTA'],$recibo['FCICLO'],
                                    0,$recibo['FACSALDO'],$recibo['FACINISAL'],$recibo['FACFINSAL'],$_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id'],$neto,'0.00',$igv,'0.00',
                                    $total,'0.00',$recibo['PREZONX'],$referencia,$nca1,$nca2,$reclamo['RECID'],$autorizacion['OFICOD'],$autorizacion['OFIAGECOD'],$autorizacion['AUT_NRO'],date('H:i:s'),$_SESSION['user_id'], date('d/m/Y')));
      $query11 = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.FACLIN WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?',array($serie_recibo,$numero_recibo));
      $query12 = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.LETFAC WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? ORDER BY CONCEP_FACCONCOD',array($serie_recibo,$numero_recibo));
      $query13 = $this->oracle->query("SELECT N2.CONCEP_FACCONCOD, SUM(NCAPREDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                      PRDDBFCOMERCIAL.NCA1 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                      WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND N1.NCAFACESTA <> 'A' GROUP BY  N2.CONCEP_FACCONCOD ORDER BY N2.CONCEP_FACCONCOD",array($serie_recibo,$numero_recibo));
      $query14 = $this->oracle->query("SELECT N2.CONCEP_FACCONCOD, SUM(N2.NCAMONDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                       PRDDBFCOMERCIAL.NCA2 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                       WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND N1.NCAFACESTA <> 'A' GROUP BY  N2.CONCEP_FACCONCOD ORDER BY N2.CONCEP_FACCONCOD",array($serie_recibo,$numero_recibo));
      $fac = $query11->result_array();
      $let = $query12->result_array();
      $monto_fac = $query13->result_array();
      $monto_let = $query14->result_array();
      $k = 0;
      if($fac){
        foreach ($fac as $fa) {
            if($monto_fac) $monto_verdadero = number_format((floatval($fa['FACPRECI']) - floatval($monto_fac[$k]['TOTAL'])),2,'.','');
            else  $monto_verdadero = number_format(floatval($fa['FACPRECI']),2,'.','');
            $query5 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.NCA1 (NCA_NCATIPO,NCA_NCASERNRO,NCA_NCANRO,NCAFACLINR,NCAFACPREC,NCAPREDIF,CONCEP_FACCONCOD,NCAPREOK,NCAFACVOLU)
                                          VALUES (?,?,?,?,?,?,?,?,?)",array('A',$serie_recibo,$numero_nc,$fa['FACLINRO'],$monto_verdadero,$monto_verdadero,$fa['CONCEP_FACCONCOD'],"0.00",$fa['FACVOLUM']));
            $k++;
        }
    } 

      $k  = 0;
      if($let){
      foreach ($let as $le) {
        if($monto_let) $monto_verdadero = number_format(floatval($le['CRECUOMON']) - floatval($monto_let[$k]['TOTAL']),2,'.','');
        else $monto_verdadero = number_format(floatval($le['CRECUOMON']),2,'.','');
        $query8 = $this->oracle->query('INSERT INTO PRDDBFCOMERCIAL.NCA2 (NCA_NCATIPO,NCA_NCASERNRO,NCA_NCANRO,NCAFACCUOL,NCAOFICOD,CONCEP_FACCONCOD,NCAOFIAGEC,NCACREDN,NCALTNUM,NCACRECUOV,NCACRECUOM,NCACREFUEN,NCACRECUOF,NCACRECUON,NCAMONDIF,NCAMONOK,DRC)
                                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array('A',$serie_recibo,$numero_nc,$le['FACCUOLIN'],$le['OFICOD'],$le['CONCEP_FACCONCOD'],$le['OFIAGECOD'],$le['CREDNRO'],$le['LTNUM'],$le['CRECUOVEN'],
                                      $monto_verdadero,$le['CREFUENTE'],$le['CRECUOFLA'],$le['CRECUONRO'],floatval($monto_verdadero),"0.00",$le['DRC']));
        $k++;
      }
  }
    $query30 = $this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array($suministro));
    if(!$query30->row_array()){
        $query30 = $this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array(substr($suministro, 0,3)."0000".substr($suministro, 3,4)));
    }
      $suministro1 = $suministro;
      if(substr($suministro, 3,4) == "0000"){
        //$this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array(substr($suministro, 0,3).substr($suministro, 7,4)));
        $suministro1 = substr($suministro, 0,3).substr($suministro, 7,4);
      }
      $nombre_cliente = $query30->row_array()['CLINOMBRE'];
      $dni = $query30->row_array()['CLIELECT'];
      $query31 = $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.MDOCGLB (ESECOD,MDCCOD,MDGSERDOC,MDGNRODOC,MDGCODACC1,MDGCODACC2,MDGFCHEMIDOC,MDGFCHVTODOC,MDGFCHVTOCOB,MDGFCHREG,MDGHRAREG,
                                      MDGIMPTOT,SDGCOD,MDGFCHLSTUPD,MDGHRALSTUPD,MDGDNINUM,MDGDNIFREG,MDGDNIHREG,MDGCODACC3)
                                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                      array(1,2,$serie_recibo,$numero_nc,0,$suministro1,date('d/m/Y'),date('d/m/Y'),date('d/m/Y'),date('d/m/Y'),date('H:i:s'),
                                      $total,1,date('d/m/Y'),date('H:i:s'),$dni,date('d/m/Y'),date('H:i:s'), substr($nombre_cliente,0,69)));
       $query32 = $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.MDOCRLC (STAESECOD,STAMDCCOD,STAMDGSERDOC,STAMDGNRODOC,STBESECOD,STBMDCCOD,STBMDGSERDOC,STBMDGNRODOC)
                                      VALUES (?,?,?,?,?,?,?,?)",
                                      array(1,1,$serie_recibo,$numero_recibo,1,2,$serie_recibo,$numero_nc));

      $query11 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NGX_LETS SET AUT_EST = 1,AUT_OPE = ? WHERE AUT_SER = ? AND AUT_REC = ? AND CLIUNICOD = ?", array($_SESSION['user_id'],$serie_recibo,$numero_recibo,$suministro));
      $this->oracle->trans_complete();
      if ($this->oracle->trans_status() === FALSE){
        $this->oracle->trans_rollback();
        return false;
      } else {
        $this->oracle->trans_commit();
        return $numero_nc;
      }
    }

    public function anular_total_recibo2($suministro,$serie_recibo,$numero_recibo,$referencia,$serie_usuario,$serie_nc,$numero_nc){

    }

    public function update_nc($suministro,$serie_recibo,$numero_recibo,$referencia,$serie_user,$conceptos,$conceptos1,$montos,$serie_nc,$numero_nc,$subtotal,$faclin,$letfac,$metros){
      $this->oracle->trans_start();
      //$total = array_sum($montos);
      $volumen = $this->volumen_leido($serie_recibo,$numero_recibo);
      $vol = 0;
      if($metros != "" || $metros != NULL)  $vol = floatval($volumen) - floatval($metros);
      $query = $this->oracle->query("SELECT FACTOTSUB,FACIGV,FACTOTAL,FIGVREF FROM PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ?",array($serie_recibo,$numero_recibo));
      $recibo = $query->row_array();
      $query8 = $this->oracle->query("SELECT SUM(NCASUBDIF) AS TOTAL, SUM(NCAIGVDIF) AS IGV, SUM(NCATOTDIF) AS DIFERENCIA FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCASERNRO <> ? AND NCANRO <> ?",array($serie_recibo,$numero_recibo,$serie_nc,$numero_recibo));
      $totalnc = $query8->row_array()['TOTAL'];
      $totalIGV = $query8->row_array()['IGV'];
      $igv_monto = 0;
      $i = 0;
      $total = 0;
      if($conceptos){
      foreach ($conceptos as $c) {
        $igv_si = $this->oracle->query("SELECT FACIGVCOB FROM PRDDBFCOMERCIAL.CONCEP WHERE FACCONCOD = ? AND ESTADO  = 1 ",array($c));
        if($igv_si->row_array()['FACIGVCOB'] == 'S'){
            $total += floatval($faclin[$i]);
            $igv_monto += floatval($faclin[$i])*intval($recibo['FIGVREF'])/100;
         } else {
            $total += floatval($faclin[$i]);
         }
         $i++;
      }
  }
      $i = 0;
      if($conceptos1) {foreach ($conceptos1 as $c) {
        $igv_si = $this->oracle->query("SELECT FACIGVCOB FROM PRDDBFCOMERCIAL.CONCEP WHERE FACCONCOD = ? AND ESTADO  = 1 ",array($c));
        //var_dump($igv_si->row_array()['FACIGVCOB']);
        if($igv_si->row_array()['FACIGVCOB'] == 'S'){
            $total += floatval($letfac[$i]);
            $igv_monto += floatval($letfac[$i])*intval($recibo['FIGVREF'])/100;
         } else {
            $total += floatval($letfac[$i]);
         }
         $i++;
      }
  }
      //var_dump($total);
      //var_dump($igv_monto);
      $totaldiferencia = $query8->row_array()['DIFERENCIA'];
      $diferencia_total = number_format((floatval($recibo['FACTOTSUB']) - floatval($totalnc) - floatval($total)),2,'.','');
      //$igv_monto = number_format($total*intval($recibo['FIGVREF'])/100,2,'.','');
      $diferencia_igv = number_format((floatval($recibo['FACIGV']) - floatval($totalIGV) - $igv_monto),2,'.','');
      $total1 = $total + $igv_monto;
      $diferencia_total1 = number_format((floatval($recibo['FACTOTAL']) - floatval($totaldiferencia) - $total1),2,'.','');
      $nca1 = array_sum($faclin);
      if($letfac) $nca2 = array_sum($letfac);
      else $nca2 = 0;
      $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NCA SET NCASUBDIF = ?, NCASUBOK = ?,NCAIGVDIF = ?,NCAIGVOK = ?, NCATOTDIF = ?,NCATOTOK = ?,NCA1 = ?,NCA2 = ?,NCADIGCOD = ?,NCA_VOLFAC = ?,NCA_VOLDIF = ?, NCAHRA = ?, NCAFACESTF = ? 
                             WHERE NCATIPO = 'A' AND NCASERNRO = ? AND NCANRO = ?",
                            array($total,$diferencia_total,$igv_monto,$diferencia_igv,$total1,$diferencia_total1,$nca1,$nca2,$_SESSION['user_id'],$volumen,$vol,date('H:i:s'), date('d/m/Y'), $serie_nc,$numero_nc));
      $query6 = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NCA1 WHERE NCA_NCATIPO = 'A' AND NCA_NCASERNRO = ? AND NCA_NCANRO = ?",array($serie_nc,$numero_nc));
      $query7 = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NCA2 WHERE NCA_NCATIPO = 'A' AND NCA_NCASERNRO = ? AND NCA_NCANRO = ?",array($serie_nc,$numero_nc));
      $fac = $query6->result_array();
      $let = $query7->result_array();
      $k = 0;
      $query9 = $this->oracle->query("SELECT N2.CONCEP_FACCONCOD, SUM(NCAPREDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                      PRDDBFCOMERCIAL.NCA1 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                      WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A'  AND N2.NCA_NCASERNRO != ?  AND N2.NCA_NCANRO != ? GROUP BY  N2.CONCEP_FACCONCOD ORDER BY N2.CONCEP_FACCONCOD",array($serie_recibo,$numero_recibo,$serie_nc,$numero_nc));
      $query10 = $this->oracle->query("SELECT N2.CONCEP_FACCONCOD, SUM(N2.NCAMONDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA N1 INNER JOIN
                                       PRDDBFCOMERCIAL.NCA2 N2 ON N1.NCASERNRO = N2.NCA_NCASERNRO AND N1.NCANRO =  N2.NCA_NCANRO
                                       WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A'  AND N2.NCA_NCASERNRO != ?  AND N2.NCA_NCANRO != ? GROUP BY  N2.CONCEP_FACCONCOD  ORDER BY N2.CONCEP_FACCONCOD",array($serie_recibo,$numero_recibo,$serie_nc,$numero_nc));
      $monto_fac = $query9->result_array();
      $monto_let = $query10->result_array();
      foreach ($fac as $fa) {
        if($monto_fac) $monto_verdadero = number_format((floatval($fa['NCAFACPREC']) - floatval($monto_fac[$k]['TOTAL'])),2,'.','');
        else  $monto_verdadero = number_format(floatval($fa['NCAFACPREC']),2,'.','');
        if($monto_fac) $descuento = number_format((floatval($fa['NCAFACPREC']) - floatval($monto_fac[$k]['TOTAL']) - floatval($faclin[$k])),2,'.','');
        else $descuento = number_format((floatval($fa['NCAFACPREC']) - floatval($faclin[$k])),2,'.','');
          $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NCA1 SET NCAPREDIF = ?, NCAPREOK = ? WHERE NCA_NCATIPO = 'A' AND NCA_NCASERNRO = ? AND NCA_NCANRO = ? AND NCAFACLINR = ?",array(floatval($faclin[$k]),$descuento,$serie_nc,$numero_nc,$fa['NCAFACLINR']));
          $k++;
      }
      $k = 0;
      if($let){
      foreach ($let as $le) {
        if($monto_let) $monto_verdadero = number_format(floatval($le['NCACRECUOM']) - floatval($monto_let[$k]['TOTAL']),2,'.','');
        else $monto_verdadero = number_format(floatval($le['NCACRECUOM']),2,'.','');
        if($monto_let) $descuento = number_format((floatval($le['NCACRECUOM']) - floatval($monto_let[$k]['TOTAL']) - floatval($letfac[$k])),2,'.','');
        else $descuento = number_format((floatval($le['NCACRECUOM']) - floatval($letfac[$k])),2,'.','');
        $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NCA2 SET NCAMONDIF = ?, NCAMONOK = ? WHERE NCA_NCATIPO = 'A' AND NCA_NCASERNRO = ? AND NCA_NCANRO = ? AND NCAFACCUOL = ?",array(floatval($letfac[$k]),$descuento,$serie_nc,$numero_nc,$le['NCAFACCUOL']));
        $k++;
      }
  }
      $query11 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NGX_LETS SET AUT_EST = 1,AUT_OPE = ? WHERE AUT_SER = ? AND AUT_REC = ? AND CLIUNICOD = ?", array($_SESSION['user_id'],$serie_recibo,$numero_recibo,$suministro));

      $query30 = $this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array($suministro));
      $suministro1 = $suministro;
      if(substr($suministro, 3,4) == "0000"){
        //$this->oracle->query("SELECT * FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array(substr($suministro, 0,3).substr($suministro, 7,4)));
        $suministro1 = substr($suministro, 0,3).substr($suministro, 7,4);
      }
      $query31 = $this->oracle->query("UPDATE PRDRECAUDACIONORA12C.MDOCGLB SET MDGIMPTOT = ? WHERE MDCCOD = ?  AND MDGSERDOC = ? AND  MDGNRODOC = ? AND trim(MDGCODACC2) = ?",array($total1,2,$serie_nc,$numero_nc,$suministro1));
      $this->oracle->trans_complete();
      if ($this->oracle->trans_status() === FALSE){
        $this->oracle->trans_rollback();
        return false;
      } else {
        $this->oracle->trans_commit();
        return $numero_nc;
      }
    }


    #funcion para obtener todos los recibos de un suministro y fecha de inicio
    public function get_recibos_x_cliente2($suministro,$fecha){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX = ? AND FACEMIFEC > to_date( ? ,'DD/MM/YYYY') ORDER BY FACEMIFEC", array($suministro,$fecha));
      return $query->result_array();
    }
    #funcion para obtener todos los recibos de un suministro y fecha de inicio Y FIN
    public function get_recibos_x_cliente3($suministro,$fecha,$fecha1){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX = ? AND FACEMIFEC BETWEEN to_date( ? ,'DD/MM/YYYY') AND to_date( ? ,'DD/MM/YY') ORDER BY FACEMIFEC", array($suministro,$fecha,$fecha1));
      return $query->result_array();
    }
    

    public function get_all_tarifas($ambito,$categoria){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT * FROM PRDCALCULADORAFACTURACIONNE.MEST_TAR WHERE CATEGORIA = ? AND ESTET = 'A' AND AMBITO = ? ", array($categoria,$ambito));
      return $query->result_array();
    }

    public function get_localidades(){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT * FROM PRDCALCULADORAFACTURACIONNE.MLOCALI WHERE ESTL = 'A' ORDER BY LOCCOD ASC", array());
      return $query->result_array();
    }

    public function get_mensaje(){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT RCDDES FROM PRDCALCULADORAFACTURACIONNE.MRESCONDIR WHERE RCDEST = 'A'", array());
      return $query->row_array();
    }

    public function get_categorias(){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT * FROM PRDCALCULADORAFACTURACIONNE.MTARIFA WHERE ESTT = 'A'", array());
      return $query->result_array();
    }



    public function get_service2($ofi,$age,$num){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query('SELECT TRES.RCOR_ABRV FROM PRDDBFCOMERCIAL.TRESPCOR TRES
                                  JOIN PRDDBFCOMERCIAL.ORDENCOR ORD ON  TRES.RCOR_CODI = ORD.TRESPCOR_RCOR_CODI
                                  WHERE OC_OFI = ? AND OC_AGE = ? AND ORC_NUM = ?', array($ofi,$age,$num));
      return $query->row_array()['RCOR_ABRV'];
    }







    

    

   

    

    public function get_autorizacion_nro($_nro){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NGX_LETS WHERE OFICOD = ?  AND OFIAGECOD = ? AND AUT_NRO = ? AND AUT_OPE IN  (?,?) AND AUT_EST = 2 AND AUT_VIGFEC >= ?",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_nro,$_SESSION['user_id'],0,date('d/m/Y')));
      return $query->row_array();
    }

    

    

    

    private function ultimo_dia(){
      $fecha = new DateTime();
      $fecha->modify('last day of this month');
      return $fecha->format('d');
    }
    public function get_serie_nc($oficod,$ofiage){ // función para obtener la serie del usuario
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.AGENCI WHERE OFICIN_OFICOD = ? AND OFIAGECOD = ?",array($oficod,$ofiage));
        return $query->row_array()['SERNRO'];
    }

    public function obtener_medcodigo($data){
        $query = $this->oracle->query("SELECT MEDCODIGO FROM PRDCOMCATMEDLEC.COAGUA WHERE PREREGION = ? AND PREZONA = ? AND PRESECTOR = ? AND PREMZN = ? AND  PRELOTE = ?", 
                                      array($data['PREREGION'],$data['PREZONA'],$data['PRESECTOR'],$data['PREMZN'],$data['PRELOTE']));
        return $query->row_array()['MEDCODIGO'];
      }
  
      public function obetner_medidor($m){
        $query = $this->oracle->query("SELECT MEDCODYGO FROM PRDCOMCATMEDLEC.MEDIDO WHERE MEDCODIGO = ?", array($m));
        return $query->row_array()['MEDCODYGO'];
      }

      public function obtener_client_grupo($grupo, $subgrupo){
        $query = $this->oracle->query("SELECT PREREGION, PREZONA, PRESECTOR, PREMZN, PRELOTE FROM PRDCOMCATMEDLEC.CLIENT WHERE CLIGRUCOD = ?  AND CLIGRUSUB = ?", array($grupo, $subgrupo));
        return $query->row_array();
      }
  
      public function obtener_client_suministro($suministro){
        $query = $this->oracle->query("SELECT PREREGION, PREZONA, PRESECTOR, PREMZN, PRELOTE FROM PRDCOMCATMEDLEC.CLIENT WHERE CLICODFAC = ?", array($suministro));
        return $query->row_array();
      }
 

}
