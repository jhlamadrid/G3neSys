<?php

class Atipicos_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
   
    public function get_atipicos($suministro){
      $query = $this->db->query("SELECT *  FROM PRDDBFCOMERCIAL.FILE_ATIPICOS WHERE CLICODFAC = ".$suministro);
        return $query->result_array();
    }
    public function get_atipico_siac($suministro){
      $query = $this->db->query("SELECT CLICODFAC,PERIODO, CICLO FROM PRDDBFCOMERCIAL.ATIPICOS WHERE CLICODFAC = ".$suministro);
        return $query->result_array();
    }
    public function get_archivos($suministro, $periodo){
      $query = $this->db->query("SELECT *  FROM PRDDBFCOMERCIAL.FILE_ATIP_IMG WHERE CLICODFAC = ".$suministro."AND PERIODO = ".$periodo);
        return $query->result_array();
    }

    public function get_archivos_SIAC($suministro,$ciclo,$periodo){
      $anio = substr($periodo, 0, 4);
      $mes =  ( (int)(substr($periodo, 4, strlen($periodo))) ) + 1;
      if($mes == 13){
        $temporal = (int)$anio ; 
        $anio = $temporal + 1;
        $mes  = 1;
      }
      $this->db_b = $this->load->database('pg', TRUE);
      //--Ficha Notificacion
      $query = $this->db_b->query('SELECT "NtNmSu" as "suministro","NtFicDgl" as "ruta_img","GprCod" as "Subciclo"
        FROM "Notificacion" 
        JOIN "Suborden_notificacion" ON "NtSonId" = "SonId" 
        AND "SonTipId"=16 AND "SonEli" IS FALSE AND "SonTipNt"=79
        JOIN "Orden_trabajo" ON "SonOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "NtGprId"="GprId"
        WHERE "NtEli" = FALSE AND "NtFicDgl" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"=\''.$ciclo.'\' AND "NtNmSu"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE
        ORDER BY "NtId"');
      $datos[0] = $query->result_array();
      //--Ficha Pre-Notificacion
      $query = $this->db_b->query('SELECT "NtNmSu" as "suministro","NtFicPreNt" as "ruta_img","GprCod" as "Subciclo"
        FROM "Notificacion" 
        JOIN "Suborden_notificacion" ON "NtSonId" = "SonId" 
        AND "SonTipId"=16 AND "SonEli" IS FALSE AND "SonTipNt"=79
        JOIN "Orden_trabajo" ON "SonOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "NtGprId"="GprId"
        WHERE "NtEli" = FALSE AND "NtFicPreNt" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"= \''.$ciclo.'\' AND "NtNmSu"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE
        ORDER BY "NtId"');
       $datos[1] = $query->result_array();
       //--Foto Notificacion
       $query = $this->db_b->query('SELECT "NtNmSu" as "suministro","NtImg" as "ruta_img","GprCod" as "Subciclo"
        FROM "Notificacion" 
        JOIN "Suborden_notificacion" ON "NtSonId" = "SonId" 
        AND "SonTipId"=16 AND "SonEli" IS FALSE AND "SonTipNt"=79
        JOIN "Orden_trabajo" ON "SonOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "NtGprId"="GprId"
        WHERE "NtEli" = FALSE AND "NtImg" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"=\''.$ciclo.'\' AND "NtNmSu"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE
        ORDER BY "NtId"');
       $datos[2] = $query->result_array();
       //--Foto Opcional Notificacion
       $query = $this->db_b->query('SELECT "NtNmSu" as "suministro","NtImg2" as "ruta_img","GprCod" as "Subciclo"
        FROM "Notificacion" 
        JOIN "Suborden_notificacion" ON "NtSonId" = "SonId" 
        AND "SonTipId"=16 AND "SonEli" IS FALSE AND "SonTipNt"=79
        JOIN "Orden_trabajo" ON "SonOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "NtGprId"="GprId"
        WHERE "NtEli" = FALSE AND "NtImg2" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"=\''.$ciclo.'\' AND "NtNmSu"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE
        ORDER BY "NtId"');
       $datos[3] = $query->result_array();
       //--INSPECCION EXTERNA--
       //----------------------
       //--Ficha
       $query = $this->db_b->query('SELECT "InoSum" as "suministro","InoFicDgl" as "ruta_img","GprCod" as "Subciclo"
        FROM "Inspeccion_otra" 
        JOIN "Ficha_externa" ON "FexInoId"="InoId"
        JOIN "Suborden_inspecciones" ON "InoSoinId" = "SoinId" AND "SoinTipId"=16 
        AND "SoinEli" IS FALSE AND "SoinTipIns"=79
        JOIN "Orden_trabajo" ON "SoinOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "InoGprId"="GprId"
        WHERE "InoEli" = FALSE AND "InoFicDgl" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"=\''.$ciclo.'\' AND "InoSum"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE AND "FexEli" = FALSE
        ORDER BY "InoId"');
       $datos[4] = $query->result_array();
       //--Fotos

        $query = $this->db_b->query('SELECT "InoSum" as "suministro","FeiImgRut" as "ruta_img","GprCod" as "Subciclo"
        FROM "Inspeccion_otra" 
        JOIN "Ficha_externa" ON "FexInoId"="InoId"
        JOIN "Ficha_externa_imagenes" ON "FeiImgFexId"="FexId"
        JOIN "Suborden_inspecciones" ON "InoSoinId" = "SoinId" AND "SoinTipId"=16 
        AND "SoinEli" IS FALSE AND "SoinTipIns"=79
        JOIN "Orden_trabajo" ON "SoinOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "InoGprId"="GprId"
        WHERE "InoEli" = FALSE AND "FeiImgRut" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"=\''.$ciclo.'\' AND "InoSum"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE AND "FexEli" = FALSE AND "FeiImgEli" = FALSE
        ORDER BY "InoId"');
       $datos[5] = $query->result_array();

       //--INSPECCION INTERNA--
       //----------------------
       //--Ficha
       $query = $this->db_b->query('SELECT "InoSum" as "suministro","InoFicDgl" as "ruta_img","GprCod" as "Subciclo"
        FROM "Inspeccion_otra" 
        JOIN "Ficha_interna" ON "FinInoId"="InoId"
        JOIN "Suborden_inspecciones" ON "InoSoinId" = "SoinId" AND "SoinTipId"=16 
        AND "SoinEli" IS FALSE AND "SoinTipIns"=79
        JOIN "Orden_trabajo" ON "SoinOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "InoGprId"="GprId"
        WHERE "InoEli" = FALSE AND "InoFicDgl" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"=\''.$ciclo.'\' AND "InoSum"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE AND "FinEli" = FALSE
        ORDER BY "InoId"');
       $datos[6] = $query->result_array();

       //--Fotos
        $query = $this->db_b->query('SELECT "InoSum" as "suministro","FiiImgRut" as "ruta_img","GprCod" as "Subciclo"
        FROM "Inspeccion_otra" 
        JOIN "Ficha_interna" ON "FinInoId"="InoId"
        JOIN "Ficha_interna_imagenes" ON "FiiImgFinId"="FinId"
        JOIN "Suborden_inspecciones" ON "InoSoinId" = "SoinId" AND "SoinTipId"=16 
        AND "SoinEli" IS FALSE AND "SoinTipIns"=79
        JOIN "Orden_trabajo" ON "SoinOrtId" = "OrtId"
        JOIN "Periodo" ON "OrtPrdId"="PrdId"
        JOIN "Grupo_predio" ON "InoGprId"="GprId"
        WHERE "InoEli" = FALSE AND "FiiImgRut" IS NOT NULL 
        AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND "GprCod"=\''.$ciclo.'\' AND "InoSum"=\''.$suministro.'\'
        AND "OrtEli" IS FALSE AND "FinEli" = FALSE AND "FiiImgEli" = FALSE
        ORDER BY "InoId"');
       $datos[7] = $query->result_array();       
       return $datos;
    }

    public function detalle_suministro($suministro, $periodo){
      $query = $this->db->query("SELECT CLINOMBRE,FACSERNRO,FACNRO,CLICODFAX,CLIRUC,CLIELECT  FROM PRDDBFCOMERCIAL.REPFACIMP WHERE CLICODFAX = ".$suministro. "AND PERIODO = ".$periodo);
      return $query->result_array();
    }

    public function  obtengo_dato_nombre_tam7($codigo_suministro){
        $grupo = substr($codigo_suministro, 0,3);
        $subGrupo = substr($codigo_suministro, 3,strlen($codigo_suministro));
        $ConsPro = "";
        $ConsPro = $ConsPro . "SELECT CLINOMBRE ";
        $ConsPro = $ConsPro . "FROM PRDCOMCATMEDLEC.PROPIE ";
        $ConsPro = $ConsPro . "WHERE CLICODFAC = '" . $grupo . "0000". $subGrupo . "'";
        $query = $this->db->query($ConsPro);
        return $query->result_array();

    }

    public function get_lectura_sumi($suministro, $periodo, $anio){
      $periodo = $periodo + 1;
      if($periodo >12){
        $anio = $anio + 1;
        $periodo = 1;
      }
      
      $this->db_b = $this->load->database('pg', TRUE);
      $query = $this->db_b->query('SELECT "LecId","LecCodFc", "LecNom", "LecUrb", "LecCal", "LecMun", "LecMed", "LecVal","LecCicCod" , "LecFchRgMov"   FROM "Lectura"
                                    INNER JOIN "Suborden_lectura" ON "SolId" = "LecSolId"
                                    INNER JOIN "Orden_trabajo" ON "OrtId" = "SolOrtId"
                                    INNER JOIN "Periodo" ON "PrdId" = "OrtPrdId"
                                    WHERE 
                                    "SolTipId" = 16 AND "PrdAni" = '.$anio.' and "PrdOrd" = '.$periodo.' and "LecCodFc" = \''.$suministro.'\'');
      $datos = $query->result_array();
      $LecId = $datos[0]['LecId'];
      /* para obtener menor y mayor */
      $query = $this->db_b->query('SELECT "LecId","LecCodFc", "LecNom", "LecUrb", "LecCal", "LecMun", "LecMed", "LecVal","LecCicCod","LecFchRgMov"  FROM "Lectura"
                                  INNER JOIN "Suborden_lectura" ON "SolId" = "LecSolId"
                                  INNER JOIN "Orden_trabajo" ON "OrtId" = "SolOrtId"
                                  INNER JOIN "Periodo" ON "PrdId" = "OrtPrdId"
                                  WHERE 
                                  "SolTipId" = 16 AND "PrdAni" = ? and "PrdOrd" = ?
                                  AND "LecId" <= ? ORDER BY "LecId" DESC limit 26', array($anio, $periodo, $LecId));
      $arriba = array_reverse($query->result_array()); 
      foreach($arriba as $key=>$a){
          $observaciobn = $this->db_b->query('SELECT "ObsCod" FROM "Observaciones_Lectura"
          INNER JOIN "Observacion" ON "OleObsId" = "ObsId"
          WHERE "OleLecId" = ? AND "OleOrd" = 1',array($a['LecId']));
          $arriba[$key]['observacion'] = $observaciobn->row_array()['ObsCod'];
      }
      $query1 = $this->db_b->query('SELECT "LecId","LecCodFc", "LecNom", "LecUrb", "LecCal", "LecMun", "LecMed", "LecVal","LecCicCod" FROM "Lectura"
                                  INNER JOIN "Suborden_lectura" ON "SolId" = "LecSolId"
                                  INNER JOIN "Orden_trabajo" ON "OrtId" = "SolOrtId"
                                  INNER JOIN "Periodo" ON "PrdId" = "OrtPrdId"
                                  WHERE 
                                  "SolTipId" = 16 AND "PrdAni" = ? and "PrdOrd" = ?
                                  AND "LecId" > ? ORDER BY "LecId" ASC limit 25', array($anio, $periodo, $LecId));
      $abajo = $query1->result_array(); 
      foreach($abajo as $key=>$a){
          $observaciobn = $this->db_b->query('SELECT "ObsCod" FROM "Observaciones_Lectura"
          INNER JOIN "Observacion" ON "OleObsId" = "ObsId"
          WHERE "OleLecId" = ? AND "OleOrd" = 1',array($a['LecId']));
          $abajo[$key]['observacion'] = $observaciobn->row_array()['ObsCod'];
      }

      $arreglo = array_merge($arriba, $abajo);
      $respuest[0]=$arreglo;
      $respuest[1]= $datos;
      return $respuest; 
    }

    public function get_re_lectura_sumi($suministro, $periodo, $anio){
        
        $periodo = $periodo + 1;
        if($periodo >12){
            $anio = $anio + 1;
            $periodo = 1;
        }
        $this->db_b = $this->load->database('pg', TRUE);
        $query = $this->db_b->query('SELECT  "RlecId", "RlecCodFc", "RlecNom", "RlecUrb", "RlecCal", "RlecMun", "RlecMed", "RlecCicCod", "RlecVal", "SorlFchEj", "RlecFchRgMov" FROM "Relectura"
                                        INNER JOIN "Suborden_relectura" ON "SorlId" = "RlecSorlId"
                                        INNER JOIN "Orden_trabajo_relectura" ON "OrelId" = "SorlOrelId"
                                        INNER JOIN "Periodo" ON "PrdId" = "OrelPrdId"
                                        WHERE "SorlTipId" = 16 AND "PrdAni" ='.$anio.' and "PrdOrd" = '.$periodo.' and "RlecCodFc" = \''.$suministro.'\'');
        $datos = $query->result_array();
        //var_dump($datos);
        if(count($datos)>0){
            $LecId = $datos[0]['RlecId'];
            $query = $this->db_b->query('SELECT "RlecId", "RlecCodFc", "RlecNom", "RlecUrb", "RlecCal", "RlecMun", "RlecMed", "RlecCicCod", "RlecVal", "SorlFchEj" FROM "Relectura"
            INNER JOIN "Suborden_relectura" ON "SorlId" = "RlecSorlId"
            INNER JOIN "Orden_trabajo_relectura" ON "OrelId" = "SorlOrelId"
            INNER JOIN "Periodo" ON "PrdId" = "OrelPrdId"
            WHERE "SorlTipId" = 16 AND "PrdAni" = ? and "PrdOrd" = ? AND
            "RlecId" <= ? ORDER BY "RlecId" DESC LIMIT 26',array($anio, $periodo, $LecId));
            $arriba = array_reverse($query->result_array());
            foreach($arriba as $key => $a){
            $observaciobn = $this->db_b->query('SELECT "ObsCod" FROM "Observaciones_Relectura"
            INNER JOIN "Observacion" ON "OrleObsId" = "ObsId"
            WHERE "OrleRlecId" = ? AND "OrleOrd" = 1',array($a['RlecId']));
            $arriba[$key]['observacion'] = $observaciobn->row_array()['ObsCod'];
            }
            $query1 = $this->db_b->query('SELECT "RlecId", "RlecCodFc", "RlecNom", "RlecUrb", "RlecCal", "RlecMun", "RlecMed", "RlecCicCod", "RlecVal", "SorlFchEj" FROM "Relectura"
            INNER JOIN "Suborden_relectura" ON "SorlId" = "RlecSorlId"
            INNER JOIN "Orden_trabajo_relectura" ON "OrelId" = "SorlOrelId"
            INNER JOIN "Periodo" ON "PrdId" = "OrelPrdId"
            WHERE "SorlTipId" = 16 AND "PrdAni" = ? and "PrdOrd" = ? AND
            "RlecId" > ? ORDER BY "RlecId" ASC LIMIT 25',array($anio, $periodo, $LecId));
            $abajo = $query1->result_array();
            foreach($abajo as $key => $a){
            $observaciobn = $this->db_b->query('SELECT "ObsCod" FROM "Observaciones_Relectura"
            INNER JOIN "Observacion" ON "OrleObsId" = "ObsId"
            WHERE "OrleRlecId" = ? AND "OrleOrd" = 1',array($a['RlecId']));
            $abajo[$key]['observacion'] = $observaciobn->row_array()['ObsCod'];
            }
            $arreglo = array_merge($arriba, $abajo);
            $respuest[0]=$arreglo;
            $respuest[1]= $datos;
            $respuest[2]= true;
            return $respuest;
        }else{
            $respuest[0]=1;
            $respuest[1]= 2;
            $respuest[2]= false;
            return $respuest;
        }
        
    }
    public function obtengo_dato_tam7($codigo_suministro){
        $grupo = substr($codigo_suministro, 0,3);
        $subGrupo = substr($codigo_suministro, 3,strlen($codigo_suministro));
        $ConsCat = '';
        $ConsCat = $ConsCat . "SELECT CLIENT.CLICODFAC, TRIM(PROPIE.CLINOMBRE) AS NOMBRE, ";
        $ConsCat = $ConsCat . " TRIM(TRIM(SUBSTR(LOCALI.LOCDES,6,60)) || ' - ' || TRIM(RLURBA.URBDES) || ' ' || TRIM(RLCALL.CALDES) || ' ' || TRIM(PREDIO.PREMUNI)) AS DIRECCION, ";
        $ConsCat = $ConsCat . " NVL(PROPIE.CLIELECT,' ') AS DNI, NVL(PROPIE.CLIRUC,' ') AS RUC, PROPIE.CONTRA AS CONTRATO, PROPIE.TARIFA, PROPIE.CODCATTAR, TARIFA.DESCATTAR AS CATEGTARIF, REGLOC.REGDES, PREDIO.PREREGION,";
        $ConsCat = $ConsCat . " PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO, PREDIO.MANZANAOK, PREDIO.LOTEOK, ";
        $ConsCat = $ConsCat . " PREDIO.SECCEN, PREDIO.MANZCEN, LOCALI.AMBCOD,PREDIO.LOTECEN, PREDIO.PRELOCALI, LOCALI.LOCDES AS LOCALIDAD, PREDIO.PREURBA, RLURBA.URBDES AS URBANIZACION, PREDIO.PRECALLE, ";
        $ConsCat = $ConsCat . " RLCALL.CALDES AS CALLE, PREDIO.PREMUNI AS NUMMUNICIPAL, PREDIO.FACCICCOD AS CICLO, PREDIO.PREFRONT AS FRONTERA, PREDIO.PREINMPIS AS NROPISOS, PREDIO.PRECLINRO AS NROCLIE, ";
        $ConsCat = $ConsCat . " CLIENT.CLIPERSNO AS NROPERSON, PREDIO.CODESTPRE, ESTPRE.DESESTPRE AS ESTADOPREDIO, PREDIO.CODTIPINM, TIPINM.DESTIPINM AS TIPOINMUEBLE, PREDIO.CODTIPRES, ";
        $ConsCat = $ConsCat . " RESEVO.DESTIPRES AS TIPOALMAC, PREDIO.CODMATCON, MATCON.DESMATCON AS MATCONSTRUC, PREDIO.PISCINCOD, PISCIN.PISCONDES AS PISCINA, PREDIO.CLLPAVCOD, TPAVIM.PAVDESC AS TIPOPAVIM, ";
        $ConsCat = $ConsCat . " PREDIO.VDAMATCOD, MATVER.DESMATVER AS MATERVEREDA, PREDIO.PREREDAGU AS PASAAGUA, PREDIO.PREREDDES AS PASADESG, PREDIO.PRECONAGU AS NROCNXAG, ";
        $ConsCat = $ConsCat . " PREDIO.PRECONDES AS NROCNXDSG, COAGUA.CONESTADO, ESTCON.CONESTDES AS ESTADOCONXAG, CLIENT.INMUSOCOD, USOINM.INMUSODES AS USOINMUEB, CLIENT.CLIGRUCOD AS GRUPO, ";
        $ConsCat = $ConsCat . " CLIENT.CLIGRUSUB AS SUBGRUPO, CLIENT.CODSCATTA AS SUBCATEGORIA, CLIENT.CIRPROY AS CIRCUITPROY, CLIENT.CEMVOLCONA AS CLASE, CLIENT.FECCEN, CLIENT.CODESCLTE , ESCLTE.DESESCLTE AS ESTADOCLI, ";
        $ConsCat = $ConsCat . " CLIENT.CODTIPSER, TIPSER.DESTIPSER AS TIPOSERVICIO, CLIENT.CODTIPTEN, TIPTEN.DESTIPTEN AS TIPOTENENCIA, CLIENT.CODABASAG, TABSAG.DESABASAG AS ABASTECAGUA, CLIENT.CODABASDE, ";
        $ConsCat = $ConsCat . " TABSDE.DESABASDE AS ABASTECDSG, NVL(COAGUA.CONCAJA,0) AS CONCAJA, COAGUA.CONCODTIP, COAGUA.CONCODIGO, COAGUA.NIVPRES, COAGUA.CONDIACOD, DICOAG.CONDIADES AS DIAMCNXAGUA, ";
        $ConsCat = $ConsCat . " COAGUA.CNAMATCOD, TMCXAG.CNAMATDES AS MATERCONXAGUA, COAGUA.AGUTABCOD, TBPCJA.AGUTABDES AS MATERTAPAAGUA, COAGUA.ESTTAPCOD, TBTPST.ESTTAPDES AS ESTADOTAPAGUA, COAGUA.CONUBICAJ, ";
        $ConsCat = $ConsCat . " UBIMED.UBICAJDES AS UBICAJAAGUA, COAGUA.CONCAJMAT, MATCJA.CONCAJDES AS MATERCAJAAGUA, COAGUA.CAJESTCOD AS CODESTCAJAG, ESCJAG.CAJESTDES AS ESTCAJAG, COAGUA.CONENTEJX, EJECCNXAGUA.ENTEEJEAGUDES, ";
        $ConsCat = $ConsCat . " COAGUA.CONCIRCUI, COAGUA.ACONTRATO, COAGUA.MEDCODIGO AS CORRMEDIDOR, MEDIDO.MEDCODYGO AS MEDIDOR, MEDIDO.MEDFECINS, MEDIDO.DIAMEDCOD, ";
        $ConsCat = $ConsCat . " TRIM(DICOAGMED.DIAMEDDES) || ' " . '"' . "' AS DIAMEDIDOR, MEDIDO.MEDESTCOD, ESMEDI.MESESTDES, MEDIDO.MEDTIPCODX, TIPMED.MEDTIPDES, MEDIDO.MEDMARCODX, ";
        $ConsCat = $ConsCat . " TMARMED.MAMDES, MEDIDO.MEDMODCODX, TMARMEDLEVEL1.MOMDES, MEDIDO.MEDFECFAC, MEDIDO.MEDFECRET, MEDIDO.MEDFECREG, MEDIDO.MEDLLACOD, ";
        $ConsCat = $ConsCat . " MEDIDO.MEDCONCOD, TMEDCONDICION.MEDCONDES, NVL(CODESA.CONDCAJA,0) AS CONDCAJA, CODESA.CONDESTAD, ESTCONDE.CONDESDES, CODESA.CONDIDCOD, ";
        $ConsCat = $ConsCat . " DICODE.CONDIDDES, CODESA.DCONTRATO, CODESA.CONCODTDE, CODESA.CONCODDES, CODESA.CONDENTEJX, CODESA.CAJESTCOD AS CODESTCAJDSG, ESCJAG.CAJESTDES AS ESTCAJDSG, ";
        $ConsCat = $ConsCat . " CODESA.CAJMATCOD, MATCJADE.CAJMATDES, CODESA.CONDUBICA, UBIMEDDES.CONDUBIDES, CODESA.DESTAPCOD, TBPCJAD.DESTAPDES, ";
        $ConsCat = $ConsCat . " CODESA.STDTAPCOD, TBTPSTDES.STDTAPDES, CLIENT.PORTARIFA, CLIENT.ORDENRL, CLIENT.CARGARL, PROPIE.CARGARD, PROPIE.ORDENRD, ";
        $ConsCat = $ConsCat . " CODESA.DCONFECFIR, CODESA.CODFECING, ENTEJE.ENTEJEDES, PROVIN.PROVINDES, ZONASEC.ZONASECSRV, ";
        $ConsCat = $ConsCat . " TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS FECHAPROCESO, TO_CHAR(SYSDATE, 'HH24:MI:SS') AS HORAPROCESO ";
        $ConsCat = $ConsCat . "FROM PRDCOMCATMEDLEC.PREDIO " ;
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.CLIENT ON (PREDIO.PREREGION = CLIENT.PREREGION) AND (PREDIO.PREZONA = CLIENT.PREZONA) AND (PREDIO.PRESECTOR = CLIENT.PRESECTOR) AND (PREDIO.PREMZN = CLIENT.PREMZN) AND (PREDIO.PRELOTE = CLIENT.PRELOTE) ";
        $ConsCat = $ConsCat . " AND CLIENT.CLIGRUCOD = " . $grupo . "AND CLIENT.CLIGRUSUB = " . $subGrupo. " ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.COAGUA ON (PREDIO.PREREGION = COAGUA.PREREGION) AND (PREDIO.PREZONA = COAGUA.PREZONA) AND (PREDIO.PRESECTOR = COAGUA.PRESECTOR) AND (PREDIO.PREMZN = COAGUA.PREMZN) AND (PREDIO.PRELOTE = COAGUA.PRELOTE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ZONASEC ON (ZONASEC.PREREGION = PREDIO.PREREGION) AND (ZONASEC.PREZONA = PREDIO.PREZONA) AND (ZONASEC.PRESECTOR = PREDIO.PRESECTOR) AND (ZONASEC.PRELOCALI = PREDIO.PRELOCALI) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.RLURBA ON (RLURBA.PREREGION = PREDIO.PREREGION) AND (RLURBA.PRELOCALI = PREDIO.PRELOCALI) AND (RLURBA.PREURBA = PREDIO.PREURBA) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.RLCALL ON (RLCALL.PREREGION = PREDIO.PREREGION) AND (RLCALL.PRELOCALI = PREDIO.PRELOCALI) AND (RLCALL.PRECALLE = PREDIO.PRECALLE) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.LOCALI ON (LOCALI.PREREGION = PREDIO.PREREGION) AND (LOCALI.PRELOCALI = PREDIO.PRELOCALI) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.CODESA ON (PREDIO.PREREGION = CODESA.PREREGION) AND (PREDIO.PREZONA = CODESA.PREZONA) AND (PREDIO.PRESECTOR = CODESA.PRESECTOR) AND (PREDIO.PREMZN = CODESA.PREMZN) AND (PREDIO.PRELOTE = CODESA.PRELOTE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTPRE ON (ESTPRE.CODESTPRE = PREDIO.CODESTPRE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCON ON (MATCON.CODMATCON = PREDIO.CODMATCON) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATVER ON (CODMATVER = VDAMATCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.PISCIN ON (PISCIN.PISCINCOD = PREDIO.PISCINCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.PROVIN ON (PROVINCOD = PREPROVIN) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.RESEVO ON (RESEVO.CODTIPRES = PREDIO.CODTIPRES) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPINM ON (TIPINM.CODTIPINM = PREDIO.CODTIPINM) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TPAVIM ON (PAVICOD = CLLPAVCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ENTEJE ON (ENTEJE.CONDENTEJX = CODESA.CONDENTEJX) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCJAG ON (ESCJAG.CAJESTCOD = CODESA.CAJESTCOD) AND (ESCJAG.CAJESTCOD = COAGUA.CAJESTCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MEDIDO ON (MEDIDO.MEDCODIGO = COAGUA.MEDCODIGO) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAGMED ON (DICOAGMED.DIAMEDCOD = MEDIDO.DIAMEDCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESMEDI ON (ESMEDI.MEDESTCOD = MEDIDO.MEDESTCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPMED ON (TIPMED.MEDTIPCODX = MEDIDO.MEDTIPCODX) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMEDCONDICION ON (TMEDCONDICION.MEDCONCOD = MEDIDO.MEDCONCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MMEDIDORFAB ON (MMEDIDORFAB.MEDCODYGO = MEDIDO.MEDCODYGO) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMED ON (TMARMED.MAMCOD = MMEDIDORFAB.MAMCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMEDLEVEL1 ON (TMARMEDLEVEL1.MAMCOD = MMEDIDORFAB.MAMCOD) AND (TMARMEDLEVEL1.MOMCOD = MMEDIDORFAB.MOMCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAG ON (DICOAG.CONDIACOD = COAGUA.CONDIACOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.EJECCNXAGUA ON (EJECCNXAGUA.CONENTEJX = COAGUA.CONENTEJX) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCON ON (ESTCON.CONESTADO = COAGUA.CONESTADO) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJA ON (MATCJA.CONCAJMAT = COAGUA.CONCAJMAT) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJA ON (TBPCJA.AGUTABCOD = COAGUA.AGUTABCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPST ON (TBTPST.ESTTAPCOD = COAGUA.ESTTAPCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMCXAG ON (TMCXAG.CNAMATCOD = COAGUA.CNAMATCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMED ON (UBIMED.CONUBICAJ = COAGUA.CONUBICAJ) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCONDE ON (ESTCONDE.CONDESTAD = CODESA.CONDESTAD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJADE ON (MATCJADE.CAJMATCOD = CODESA.CAJMATCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJAD ON (TBPCJAD.DESTAPCOD = CODESA.DESTAPCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPSTDES ON (TBTPSTDES.STDTAPCOD = CODESA.STDTAPCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMEDDES ON (UBIMEDDES.CONDUBICA = CODESA.CONDUBICA) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.DICODE ON (DICODE.CONDIDCOD = CODESA.CONDIDCOD) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.PROPIE ON (CLIENT.CLICODFAC = PROPIE.CLICODFAC) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.REGLOC ON (REGLOC.PREREGION = PROPIE.PREREGION) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TARIFA ON (TARIFA.CODCATTAR = PROPIE.CODCATTAR) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCLTE ON (ESCLTE.CODESCLTE = CLIENT.CODESCLTE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSAG ON (TABSAG.CODABASAG = CLIENT.CODABASAG) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSDE ON (TABSDE.CODABASDE = CLIENT.CODABASDE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPSER ON (TIPSER.CODTIPSER = CLIENT.CODTIPSER) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPTEN ON (TIPTEN.CODTIPTEN = CLIENT.CODTIPTEN) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.USOINM ON (USOINM.INMUSOCOD = CLIENT.INMUSOCOD) ";
        $ConsCat = $ConsCat . "ORDER BY PREDIO.PREREGION, PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO ";
        $query = $this->db->query($ConsCat);
        return $query->result_array();

    }


    public function obtengo_dato_tam11($codigo_suministro){
        $ConsCat = '';
        $ConsCat = $ConsCat . "SELECT CLIENT.CLICODFAC, TRIM(PROPIE.CLINOMBRE) AS NOMBRE, ";
        $ConsCat = $ConsCat . " TRIM(TRIM(SUBSTR(LOCALI.LOCDES,6,60)) || ' - ' || TRIM(RLURBA.URBDES) || ' ' || TRIM(RLCALL.CALDES) || ' ' || TRIM(PREDIO.PREMUNI)) AS DIRECCION, ";
        $ConsCat = $ConsCat . " NVL(PROPIE.CLIELECT,' ') AS DNI, NVL(PROPIE.CLIRUC,' ') AS RUC, PROPIE.CONTRA AS CONTRATO, PROPIE.TARIFA, PROPIE.CODCATTAR, TARIFA.DESCATTAR AS CATEGTARIF, REGLOC.REGDES, PREDIO.PREREGION, ";
        $ConsCat = $ConsCat . " PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO, PREDIO.MANZANAOK, PREDIO.LOTEOK, ";
        $ConsCat = $ConsCat . " PREDIO.SECCEN, PREDIO.MANZCEN,LOCALI.AMBCOD, PREDIO.LOTECEN, PREDIO.PRELOCALI, LOCALI.LOCDES AS LOCALIDAD, PREDIO.PREURBA, RLURBA.URBDES AS URBANIZACION, PREDIO.PRECALLE, ";
        $ConsCat = $ConsCat . " RLCALL.CALDES AS CALLE, PREDIO.PREMUNI AS NUMMUNICIPAL, PREDIO.FACCICCOD AS CICLO, PREDIO.PREFRONT AS FRONTERA, PREDIO.PREINMPIS AS NROPISOS, PREDIO.PRECLINRO AS NROCLIE, ";
        $ConsCat = $ConsCat . " CLIENT.CLIPERSNO AS NROPERSON, PREDIO.CODESTPRE, ESTPRE.DESESTPRE AS ESTADOPREDIO, PREDIO.CODTIPINM, TIPINM.DESTIPINM AS TIPOINMUEBLE, PREDIO.CODTIPRES, ";
        $ConsCat = $ConsCat . " RESEVO.DESTIPRES AS TIPOALMAC, PREDIO.CODMATCON, MATCON.DESMATCON AS MATCONSTRUC, PREDIO.PISCINCOD, PISCIN.PISCONDES AS PISCINA, PREDIO.CLLPAVCOD, TPAVIM.PAVDESC AS TIPOPAVIM, ";
        $ConsCat = $ConsCat . " PREDIO.VDAMATCOD, MATVER.DESMATVER AS MATERVEREDA, PREDIO.PREREDAGU AS PASAAGUA, PREDIO.PREREDDES AS PASADESG, PREDIO.PRECONAGU AS NROCNXAG, ";
        $ConsCat = $ConsCat . " PREDIO.PRECONDES AS NROCNXDSG, COAGUA.CONESTADO, ESTCON.CONESTDES AS ESTADOCONXAG, CLIENT.INMUSOCOD, USOINM.INMUSODES AS USOINMUEB, CLIENT.CLIGRUCOD AS GRUPO, ";
        $ConsCat = $ConsCat . " CLIENT.CLIGRUSUB AS SUBGRUPO, CLIENT.CODSCATTA AS SUBCATEGORIA, CLIENT.CIRPROY AS CIRCUITPROY, CLIENT.CEMVOLCONA AS CLASE, CLIENT.FECCEN, CLIENT.CODESCLTE , ESCLTE.DESESCLTE AS ESTADOCLI, ";
        $ConsCat = $ConsCat . " CLIENT.CODTIPSER, TIPSER.DESTIPSER AS TIPOSERVICIO, CLIENT.CODTIPTEN, TIPTEN.DESTIPTEN AS TIPOTENENCIA, CLIENT.CODABASAG, TABSAG.DESABASAG AS ABASTECAGUA, CLIENT.CODABASDE, ";
        $ConsCat = $ConsCat . " TABSDE.DESABASDE AS ABASTECDSG, NVL(COAGUA.CONCAJA,0) AS CONCAJA, COAGUA.CONCODTIP, COAGUA.CONCODIGO, COAGUA.NIVPRES, COAGUA.CONDIACOD, DICOAG.CONDIADES AS DIAMCNXAGUA, ";
        $ConsCat = $ConsCat . " COAGUA.CNAMATCOD, TMCXAG.CNAMATDES AS MATERCONXAGUA, COAGUA.AGUTABCOD, TBPCJA.AGUTABDES AS MATERTAPAAGUA, COAGUA.ESTTAPCOD, TBTPST.ESTTAPDES AS ESTADOTAPAGUA, COAGUA.CONUBICAJ, ";
        $ConsCat = $ConsCat . " UBIMED.UBICAJDES AS UBICAJAAGUA, COAGUA.CONCAJMAT, MATCJA.CONCAJDES AS MATERCAJAAGUA, COAGUA.CAJESTCOD AS CODESTCAJAG, ESCJAG.CAJESTDES AS ESTCAJAG, COAGUA.CONENTEJX, EJECCNXAGUA.ENTEEJEAGUDES, ";
        $ConsCat = $ConsCat . " COAGUA.CONCIRCUI, COAGUA.ACONTRATO, COAGUA.MEDCODIGO AS CORRMEDIDOR, MEDIDO.MEDCODYGO AS MEDIDOR, MEDIDO.MEDFECINS, MEDIDO.DIAMEDCOD, ";
        $ConsCat = $ConsCat . " TRIM(DICOAGMED.DIAMEDDES) || ' " . '"' . "' AS DIAMEDIDOR, MEDIDO.MEDESTCOD, ESMEDI.MESESTDES, MEDIDO.MEDTIPCODX, TIPMED.MEDTIPDES, MEDIDO.MEDMARCODX, ";
        $ConsCat = $ConsCat . " TMARMED.MAMDES, MEDIDO.MEDMODCODX, TMARMEDLEVEL1.MOMDES, MEDIDO.MEDFECFAC, MEDIDO.MEDFECRET, MEDIDO.MEDFECREG, MEDIDO.MEDLLACOD, ";
        $ConsCat = $ConsCat . " MEDIDO.MEDCONCOD, TMEDCONDICION.MEDCONDES, NVL(CODESA.CONDCAJA,0) AS CONDCAJA, CODESA.CONDESTAD, ESTCONDE.CONDESDES, CODESA.CONDIDCOD, ";
        $ConsCat = $ConsCat . " DICODE.CONDIDDES, CODESA.DCONTRATO, CODESA.CONCODTDE, CODESA.CONCODDES, CODESA.CONDENTEJX, CODESA.CAJESTCOD AS CODESTCAJDSG, ESCJAG.CAJESTDES AS ESTCAJDSG, ";
        $ConsCat = $ConsCat . " CODESA.CAJMATCOD, MATCJADE.CAJMATDES, CODESA.CONDUBICA, UBIMEDDES.CONDUBIDES, CODESA.DESTAPCOD, TBPCJAD.DESTAPDES, ";
        $ConsCat = $ConsCat . " CODESA.STDTAPCOD, TBTPSTDES.STDTAPDES, CLIENT.PORTARIFA, CLIENT.ORDENRL, CLIENT.CARGARL, PROPIE.CARGARD, PROPIE.ORDENRD, ";
        $ConsCat = $ConsCat . " CODESA.DCONFECFIR, CODESA.CODFECING, ENTEJE.ENTEJEDES, PROVIN.PROVINDES, ZONASEC.ZONASECSRV, ";
        $ConsCat = $ConsCat . " TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS FECHAPROCESO, TO_CHAR(SYSDATE, 'HH24:MI:SS') AS HORAPROCESO ";
        $ConsCat = $ConsCat . "FROM PRDCOMCATMEDLEC.PREDIO ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.CLIENT ON (PREDIO.PREREGION = CLIENT.PREREGION) AND (PREDIO.PREZONA = CLIENT.PREZONA) AND (PREDIO.PRESECTOR = CLIENT.PRESECTOR) AND (PREDIO.PREMZN = CLIENT.PREMZN) AND (PREDIO.PRELOTE = CLIENT.PRELOTE) ";
        $ConsCat = $ConsCat . " AND CLIENT.CLICODFAC = '" . $codigo_suministro. "' ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.COAGUA ON (PREDIO.PREREGION = COAGUA.PREREGION) AND (PREDIO.PREZONA = COAGUA.PREZONA) AND (PREDIO.PRESECTOR = COAGUA.PRESECTOR) AND (PREDIO.PREMZN = COAGUA.PREMZN) AND (PREDIO.PRELOTE = COAGUA.PRELOTE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ZONASEC ON (ZONASEC.PREREGION = PREDIO.PREREGION) AND (ZONASEC.PREZONA = PREDIO.PREZONA) AND (ZONASEC.PRESECTOR = PREDIO.PRESECTOR) AND (ZONASEC.PRELOCALI = PREDIO.PRELOCALI) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.RLURBA ON (RLURBA.PREREGION = PREDIO.PREREGION) AND (RLURBA.PRELOCALI = PREDIO.PRELOCALI) AND (RLURBA.PREURBA = PREDIO.PREURBA) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.RLCALL ON (RLCALL.PREREGION = PREDIO.PREREGION) AND (RLCALL.PRELOCALI = PREDIO.PRELOCALI) AND (RLCALL.PRECALLE = PREDIO.PRECALLE) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.LOCALI ON (LOCALI.PREREGION = PREDIO.PREREGION) AND (LOCALI.PRELOCALI = PREDIO.PRELOCALI) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.CODESA ON (PREDIO.PREREGION = CODESA.PREREGION) AND (PREDIO.PREZONA = CODESA.PREZONA) AND (PREDIO.PRESECTOR = CODESA.PRESECTOR) AND (PREDIO.PREMZN = CODESA.PREMZN) AND (PREDIO.PRELOTE = CODESA.PRELOTE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTPRE ON (ESTPRE.CODESTPRE = PREDIO.CODESTPRE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCON ON (MATCON.CODMATCON = PREDIO.CODMATCON) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATVER ON (CODMATVER = VDAMATCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.PISCIN ON (PISCIN.PISCINCOD = PREDIO.PISCINCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.PROVIN ON (PROVINCOD = PREPROVIN) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.RESEVO ON (RESEVO.CODTIPRES = PREDIO.CODTIPRES) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPINM ON (TIPINM.CODTIPINM = PREDIO.CODTIPINM) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TPAVIM ON (PAVICOD = CLLPAVCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ENTEJE ON (ENTEJE.CONDENTEJX = CODESA.CONDENTEJX) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCJAG ON (ESCJAG.CAJESTCOD = CODESA.CAJESTCOD) AND (ESCJAG.CAJESTCOD = COAGUA.CAJESTCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MEDIDO ON (MEDIDO.MEDCODIGO = COAGUA.MEDCODIGO) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAGMED ON (DICOAGMED.DIAMEDCOD = MEDIDO.DIAMEDCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESMEDI ON (ESMEDI.MEDESTCOD = MEDIDO.MEDESTCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPMED ON (TIPMED.MEDTIPCODX = MEDIDO.MEDTIPCODX) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMEDCONDICION ON (TMEDCONDICION.MEDCONCOD = MEDIDO.MEDCONCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MMEDIDORFAB ON (MMEDIDORFAB.MEDCODYGO = MEDIDO.MEDCODYGO) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMED ON (TMARMED.MAMCOD = MMEDIDORFAB.MAMCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMEDLEVEL1 ON (TMARMEDLEVEL1.MAMCOD = MMEDIDORFAB.MAMCOD) AND (TMARMEDLEVEL1.MOMCOD = MMEDIDORFAB.MOMCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAG ON (DICOAG.CONDIACOD = COAGUA.CONDIACOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.EJECCNXAGUA ON (EJECCNXAGUA.CONENTEJX = COAGUA.CONENTEJX) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCON ON (ESTCON.CONESTADO = COAGUA.CONESTADO) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJA ON (MATCJA.CONCAJMAT = COAGUA.CONCAJMAT) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJA ON (TBPCJA.AGUTABCOD = COAGUA.AGUTABCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPST ON (TBTPST.ESTTAPCOD = COAGUA.ESTTAPCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TMCXAG ON (TMCXAG.CNAMATCOD = COAGUA.CNAMATCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMED ON (UBIMED.CONUBICAJ = COAGUA.CONUBICAJ) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCONDE ON (ESTCONDE.CONDESTAD = CODESA.CONDESTAD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJADE ON (MATCJADE.CAJMATCOD = CODESA.CAJMATCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJAD ON (TBPCJAD.DESTAPCOD = CODESA.DESTAPCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPSTDES ON (TBTPSTDES.STDTAPCOD = CODESA.STDTAPCOD) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMEDDES ON (UBIMEDDES.CONDUBICA = CODESA.CONDUBICA) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.DICODE ON (DICODE.CONDIDCOD = CODESA.CONDIDCOD) ";
        $ConsCat = $ConsCat . " INNER JOIN PRDCOMCATMEDLEC.PROPIE ON (CLIENT.CLICODFAC = PROPIE.CLICODFAC) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.REGLOC ON (REGLOC.PREREGION = PROPIE.PREREGION) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TARIFA ON (TARIFA.CODCATTAR = PROPIE.CODCATTAR) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCLTE ON (ESCLTE.CODESCLTE = CLIENT.CODESCLTE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSAG ON (TABSAG.CODABASAG = CLIENT.CODABASAG) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSDE ON (TABSDE.CODABASDE = CLIENT.CODABASDE) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPSER ON (TIPSER.CODTIPSER = CLIENT.CODTIPSER) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPTEN ON (TIPTEN.CODTIPTEN = CLIENT.CODTIPTEN) ";
        $ConsCat = $ConsCat . " LEFT OUTER JOIN PRDCOMCATMEDLEC.USOINM ON (USOINM.INMUSOCOD = CLIENT.INMUSOCOD) ";
        $ConsCat = $ConsCat . "ORDER BY PREDIO.PREREGION, PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO ";
        $query = $this->db->query($ConsCat);
        return $query->result_array();
    }
   
}

?>