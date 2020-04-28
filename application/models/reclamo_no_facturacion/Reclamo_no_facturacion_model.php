<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    /**
    *   MODELO Boleta_Factura_model
    *   -------------------------------------------------
    *   Modelo creado para las Proformas de Boletas y facturas
    *   Creado: JALO (Jhon A. Leon Ortecho)
    *   Fecha: 22/03/2019
    *   
    */

    class Reclamo_no_facturacion_model extends CI_Model {
        function __construct() {
            parent::__construct();
            $this->load->database();
            $this->oracle = $this->load->database('oracle', TRUE);
            //$this->oracle = $this->load->database('oracle', TRUE);
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

        public function getReclamosParticulares(){
            $query = $this->oracle->query("SELECT  * FROM PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 INNER JOIN 
            PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE M3.ALCANCE_PROBLEMA='P'");
            return $query->result_array();
        }

        public function get_Espe_problema( $tipo_sol, $tipo_pro ){
            $dato ='';
            if($tipo_sol == 1){
                $dato = 'P';
            }else{
                $dato = 'G';
            }
            $query = $this->oracle->query("SELECT M3.CPID, M3.TIPPROBID, M3.SCATPROBID, M3.PROBID, M3.PROBABR FROM PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 INNER JOIN 
            PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE M3.ALCANCE_PROBLEMA='".$dato."' AND  MP.CPID = ".$tipo_pro);
            return $query->result_array();
        }

        public function getReclamosGenerales(){
            $query = $this->oracle->query("SELECT  * FROM PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 INNER JOIN 
            PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE M3.ALCANCE_PROBLEMA='G'");
            return $query->result_array();
        }

        public function getTipoDocumento(){
            $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.TIPDOC');
            return $query->result_array();
        }

        public function getPersona($tipo, $numero){
            if($tipo == 8){
                if(strlen($numero) == 7){
                    $grupo = substr($numero, 0, 3);
                    $subgrupo = substr($numero, 3, 4);
                    $query = $this->oracle->query("SELECT CLIENT.CLICODFAC, GR.CODGRUPO, GR.CLINOMBRE, TRIM(SUBSTR(LOCALI.LOCDES,6,60)) AS LOCALIDAD, GR.CLIAPELLPE, GR.CLIAPELLM, GR.CLINOMBR1, GR.CLINOMBR2,
                    TRIM(RLURBA.URBDES) AS URBANIZACION ,TRIM(RLCALL.CALDES) AS CALLE, PREDIO.PREMUNI AS NUMERO,  
                    GR.CLIELECT AS DNI, GR.CLIRUC AS RUC, GR.CONTRA AS CONTRATO, GR.TARIFA, GR.CODCATTAR, TARIFA.DESCATTAR AS CATEGTARIF, AMBITO.AMBDES, REGLOC.REGDES, PREDIO.PREREGION, 
                    PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO, PREDIO.MANZANAOK, PREDIO.LOTEOK, 
                    PREDIO.SECCEN, PREDIO.MANZCEN, PREDIO.LOTECEN, PREDIO.PRELOCALI, LOCALI.LOCDES AS LOCALIDAD, PREDIO.PREURBA, RLURBA.URBDES AS URBANIZACION, PREDIO.PRECALLE, 
                    RLCALL.CALDES AS CALLE, PREDIO.PREMUNI AS NUMMUNICIPAL, PREDIO.FACCICCOD AS CICLO, PREDIO.PREFRONT AS FRONTERA, PREDIO.PREINMPIS AS NROPISOS, PREDIO.PRECLINRO AS NROCLIE, 
                    CLIENT.CLIPERSNO AS NROPERSON, PREDIO.CODESTPRE, ESTPRE.DESESTPRE AS ESTADOPREDIO, PREDIO.CODTIPINM, TIPINM.DESTIPINM AS TIPOINMUEBLE, PREDIO.CODTIPRES, 
                    RESEVO.DESTIPRES AS TIPOALMAC, PREDIO.CODMATCON, MATCON.DESMATCON AS MATCONSTRUC, PREDIO.PISCINCOD, PISCIN.PISCONDES AS PISCINA, PREDIO.CLLPAVCOD, TPAVIM.PAVDESC AS TIPOPAVIM, 
                    PREDIO.VDAMATCOD, MATVER.DESMATVER AS MATERVEREDA, PREDIO.PREREDAGU AS PASAAGUA, PREDIO.PREREDDES AS PASADESG, PREDIO.PRECONAGU AS NROCNXAG, 
                    PREDIO.PRECONDES AS NROCNXDSG, COAGUA.CONESTADO, ESTCON.CONESTDES AS ESTADOCONXAG, CLIENT.INMUSOCOD, USOINM.INMUSODES AS USOINMUEB, CLIENT.CLIGRUCOD AS GRUPO, 
                    CLIENT.CLIGRUSUB AS SUBGRUPO, CLIENT.CODSCATTA AS SUBCATEGORIA, CLIENT.CIRPROY AS CIRCUITPROY, CLIENT.CEMVOLCONA AS CLASE, CLIENT.FECCEN, CLIENT.CODESCLTE , ESCLTE.DESESCLTE AS ESTADOCLI, 
                    CLIENT.CODTIPSER, TIPSER.DESTIPSER AS TIPOSERVICIO, CLIENT.CODTIPTEN, TIPTEN.DESTIPTEN AS TIPOTENENCIA, CLIENT.CODABASAG, TABSAG.DESABASAG AS ABASTECAGUA, CLIENT.CODABASDE, 
                    TABSDE.DESABASDE AS ABASTECDSG, NVL(COAGUA.CONCAJA,0) AS CONCAJA, COAGUA.CONCODTIP, COAGUA.CONCODIGO, COAGUA.NIVPRES, COAGUA.CONDIACOD, DICOAG.CONDIADES AS DIAMCNXAGUA, 
                    COAGUA.CNAMATCOD, TMCXAG.CNAMATDES AS MATERCONXAGUA, COAGUA.AGUTABCOD, TBPCJA.AGUTABDES AS MATERTAPAAGUA, COAGUA.ESTTAPCOD, TBTPST.ESTTAPDES AS ESTADOTAPAGUA, COAGUA.CONUBICAJ, 
                    UBIMED.UBICAJDES AS UBICAJAAGUA, COAGUA.CONCAJMAT, MATCJA.CONCAJDES AS MATERCAJAAGUA, COAGUA.CAJESTCOD AS CODESTCAJAG, ESCJAG.CAJESTDES AS ESTCAJAG, COAGUA.CONENTEJX, EJECCNXAGUA.ENTEEJEAGUDES, 
                    COAGUA.CONCIRCUI, COAGUA.ACONTRATO, COAGUA.MEDCODIGO AS CORRMEDIDOR, MEDIDO.MEDCODYGO AS MEDIDOR, MEDIDO.MEDFECINS, MEDIDO.DIAMEDCOD, 
                    TRIM(DICOAGMED.DIAMEDDES) || ' \"' AS DIAMEDIDOR,
                    MEDIDO.MEDESTCOD, ESMEDI.MESESTDES, MEDIDO.MEDTIPCODX, TIPMED.MEDTIPDES, MEDIDO.MEDMARCODX, 
                    TMARMED.MAMDES, MEDIDO.MEDMODCODX, TMARMEDLEVEL1.MOMDES, MEDIDO.MEDFECFAC, MEDIDO.MEDFECRET, MEDIDO.MEDFECREG, MEDIDO.MEDLLACOD, 
                    MEDIDO.MEDCONCOD, TMEDCONDICION.MEDCONDES, NVL(CODESA.CONDCAJA,0) AS CONDCAJA, CODESA.CONDESTAD, ESTCONDE.CONDESDES, CODESA.CONDIDCOD, 
                    DICODE.CONDIDDES, CODESA.DCONTRATO, CODESA.CONCODTDE, CODESA.CONCODDES, CODESA.CONDENTEJX, CODESA.CAJESTCOD AS CODESTCAJDSG, ESCJAG.CAJESTDES AS ESTCAJDSG, 
                    CODESA.CAJMATCOD, MATCJADE.CAJMATDES, CODESA.CONDUBICA, UBIMEDDES.CONDUBIDES, CODESA.DESTAPCOD, TBPCJAD.DESTAPDES, 
                    CODESA.STDTAPCOD, TBTPSTDES.STDTAPDES, CLIENT.PORTARIFA, CLIENT.ORDENRL, CLIENT.CARGARL, GR.CARGARD, GR.ORDENRD, 
                    CODESA.DCONFECFIR, CODESA.CODFECING, ENTEJE.ENTEJEDES, PROVIN.PROVINDES, ZONASEC.ZONASECSRV, 
                    TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS FECHAPROCESO, TO_CHAR(SYSDATE, 'HH24:MI:SS') AS HORAPROCESO 
                    FROM PRDCOMCATMEDLEC.PREDIO 
                    INNER JOIN PRDCOMCATMEDLEC.CLIENT ON (PREDIO.PREREGION = CLIENT.PREREGION) AND (PREDIO.PREZONA = CLIENT.PREZONA) AND (PREDIO.PRESECTOR = CLIENT.PRESECTOR) AND (PREDIO.PREMZN = CLIENT.PREMZN) AND (PREDIO.PRELOTE = CLIENT.PRELOTE) 
                    AND CLIENT.CLIGRUCOD =  ? AND CLIENT.CLIGRUSUB = ? 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.COAGUA ON (PREDIO.PREREGION = COAGUA.PREREGION) AND (PREDIO.PREZONA = COAGUA.PREZONA) AND (PREDIO.PRESECTOR = COAGUA.PRESECTOR) AND (PREDIO.PREMZN = COAGUA.PREMZN) AND (PREDIO.PRELOTE = COAGUA.PRELOTE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ZONASEC ON (ZONASEC.PREREGION = PREDIO.PREREGION) AND (ZONASEC.PREZONA = PREDIO.PREZONA) AND (ZONASEC.PRESECTOR = PREDIO.PRESECTOR) AND (ZONASEC.PRELOCALI = PREDIO.PRELOCALI) 
                    INNER JOIN PRDCOMCATMEDLEC.RLURBA ON (RLURBA.PREREGION = PREDIO.PREREGION) AND (RLURBA.PRELOCALI = PREDIO.PRELOCALI) AND (RLURBA.PREURBA = PREDIO.PREURBA) 
                    INNER JOIN PRDCOMCATMEDLEC.RLCALL ON (RLCALL.PREREGION = PREDIO.PREREGION) AND (RLCALL.PRELOCALI = PREDIO.PRELOCALI) AND (RLCALL.PRECALLE = PREDIO.PRECALLE) 
                    INNER JOIN PRDCOMCATMEDLEC.LOCALI ON (LOCALI.PREREGION = PREDIO.PREREGION) AND (LOCALI.PRELOCALI = PREDIO.PRELOCALI) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.CODESA ON (PREDIO.PREREGION = CODESA.PREREGION) AND (PREDIO.PREZONA = CODESA.PREZONA) AND (PREDIO.PRESECTOR = CODESA.PRESECTOR) AND (PREDIO.PREMZN = CODESA.PREMZN) AND (PREDIO.PRELOTE = CODESA.PRELOTE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTPRE ON (ESTPRE.CODESTPRE = PREDIO.CODESTPRE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCON ON (MATCON.CODMATCON = PREDIO.CODMATCON) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATVER ON (CODMATVER = VDAMATCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.PISCIN ON (PISCIN.PISCINCOD = PREDIO.PISCINCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.PROVIN ON (PROVINCOD = PREPROVIN) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.RESEVO ON (RESEVO.CODTIPRES = PREDIO.CODTIPRES) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPINM ON (TIPINM.CODTIPINM = PREDIO.CODTIPINM) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TPAVIM ON (PAVICOD = CLLPAVCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ENTEJE ON (ENTEJE.CONDENTEJX = CODESA.CONDENTEJX) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCJAG ON (ESCJAG.CAJESTCOD = CODESA.CAJESTCOD) AND (ESCJAG.CAJESTCOD = COAGUA.CAJESTCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MEDIDO ON (MEDIDO.MEDCODIGO = COAGUA.MEDCODIGO) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAGMED ON (DICOAGMED.DIAMEDCOD = MEDIDO.DIAMEDCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESMEDI ON (ESMEDI.MEDESTCOD = MEDIDO.MEDESTCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPMED ON (TIPMED.MEDTIPCODX = MEDIDO.MEDTIPCODX) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMEDCONDICION ON (TMEDCONDICION.MEDCONCOD = MEDIDO.MEDCONCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MMEDIDORFAB ON (MMEDIDORFAB.MEDCODYGO = MEDIDO.MEDCODYGO) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMED ON (TMARMED.MAMCOD = MMEDIDORFAB.MAMCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMEDLEVEL1 ON (TMARMEDLEVEL1.MAMCOD = MMEDIDORFAB.MAMCOD) AND (TMARMEDLEVEL1.MOMCOD = MMEDIDORFAB.MOMCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAG ON (DICOAG.CONDIACOD = COAGUA.CONDIACOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.EJECCNXAGUA ON (EJECCNXAGUA.CONENTEJX = COAGUA.CONENTEJX) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCON ON (ESTCON.CONESTADO = COAGUA.CONESTADO) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJA ON (MATCJA.CONCAJMAT = COAGUA.CONCAJMAT) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJA ON (TBPCJA.AGUTABCOD = COAGUA.AGUTABCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPST ON (TBTPST.ESTTAPCOD = COAGUA.ESTTAPCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMCXAG ON (TMCXAG.CNAMATCOD = COAGUA.CNAMATCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMED ON (UBIMED.CONUBICAJ = COAGUA.CONUBICAJ) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCONDE ON (ESTCONDE.CONDESTAD = CODESA.CONDESTAD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJADE ON (MATCJADE.CAJMATCOD = CODESA.CAJMATCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJAD ON (TBPCJAD.DESTAPCOD = CODESA.DESTAPCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPSTDES ON (TBTPSTDES.STDTAPCOD = CODESA.STDTAPCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMEDDES ON (UBIMEDDES.CONDUBICA = CODESA.CONDUBICA) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.DICODE ON (DICODE.CONDIDCOD = CODESA.CONDIDCOD) 
                    INNER JOIN (SELECT PROPIE.*, SUBSTR(TRIM(PROPIE.CLICODFAC),1,3) || SUBSTR(TRIM(PROPIE.CLICODFAC),8,4) AS CODGRUPO FROM PRDCOMCATMEDLEC.PROPIE WHERE  SUBSTR(TRIM(PROPIE.CLICODFAC),4,4) = '0000') GR ON GR.CLICODFAC =  TRIM(TO_CHAR(CLIENT.CLIGRUCOD,'000')) || '0000'|| TRIM(TO_CHAR(CLIENT.CLIGRUSUB,'0000')) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.REGLOC ON (REGLOC.PREREGION = GR.PREREGION) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TARIFA ON (TARIFA.CODCATTAR = GR.CODCATTAR) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCLTE ON (ESCLTE.CODESCLTE = CLIENT.CODESCLTE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSAG ON (TABSAG.CODABASAG = CLIENT.CODABASAG) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSDE ON (TABSDE.CODABASDE = CLIENT.CODABASDE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPSER ON (TIPSER.CODTIPSER = CLIENT.CODTIPSER) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPTEN ON (TIPTEN.CODTIPTEN = CLIENT.CODTIPTEN) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.USOINM ON (USOINM.INMUSOCOD = CLIENT.INMUSOCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.AMBITO ON (AMBITO.AMBCOD = LOCALI.AMBCOD) 
                    WHERE ROWNUM = 1        
                    ORDER BY PREDIO.PREREGION, PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO ", array($grupo, $subgrupo));
                } else {
                    $query = $this->oracle->query("SELECT CLIENT.CLICODFAC, TRIM(PROPIE.CLINOMBRE) AS NOMBRE, TRIM(SUBSTR(LOCALI.LOCDES,6,60)) AS LOCALIDAD,  PROPIE.CLIAPELLPE, PROPIE.CLIAPELLM, PROPIE.CLINOMBR1, PROPIE.CLINOMBR2,
                    TRIM(RLURBA.URBDES) AS URBANIZACION ,TRIM(RLCALL.CALDES) AS CALLE, PREDIO.PREMUNI AS NUMERO, 
                    NVL(PROPIE.CLIELECT,' ') AS DNI, NVL(PROPIE.CLIRUC,' ') AS RUC, PROPIE.CONTRA AS CONTRATO, PROPIE.TARIFA, PROPIE.CODCATTAR, TARIFA.DESCATTAR AS CATEGTARIF, REGLOC.REGDES, PREDIO.PREREGION, 
                    PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, LOCALI.AMBCOD, AMBITO.AMBDES, CLIENT.CLICODID, CLIENT.CLICODIGO, PREDIO.MANZANAOK, PREDIO.LOTEOK, 
                    PREDIO.SECCEN, PREDIO.MANZCEN, PREDIO.LOTECEN, PREDIO.PRELOCALI, LOCALI.LOCDES AS LOCALIDAD, PREDIO.PREURBA, RLURBA.URBDES AS URBANIZACION, PREDIO.PRECALLE, 
                    RLCALL.CALDES AS CALLE, PREDIO.PREMUNI AS NUMMUNICIPAL, PREDIO.FACCICCOD AS CICLO, PREDIO.PREFRONT AS FRONTERA, PREDIO.PREINMPIS AS NROPISOS, PREDIO.PRECLINRO AS NROCLIE, 
                    CLIENT.CLIPERSNO AS NROPERSON, PREDIO.CODESTPRE, ESTPRE.DESESTPRE AS ESTADOPREDIO, PREDIO.CODTIPINM, TIPINM.DESTIPINM AS TIPOINMUEBLE, PREDIO.CODTIPRES, 
                    RESEVO.DESTIPRES AS TIPOALMAC, PREDIO.CODMATCON, MATCON.DESMATCON AS MATCONSTRUC, PREDIO.PISCINCOD, PISCIN.PISCONDES AS PISCINA, PREDIO.CLLPAVCOD, TPAVIM.PAVDESC AS TIPOPAVIM, 
                    PREDIO.VDAMATCOD, MATVER.DESMATVER AS MATERVEREDA, PREDIO.PREREDAGU AS PASAAGUA, PREDIO.PREREDDES AS PASADESG, PREDIO.PRECONAGU AS NROCNXAG, 
                    PREDIO.PRECONDES AS NROCNXDSG, COAGUA.CONESTADO, ESTCON.CONESTDES AS ESTADOCONXAG, CLIENT.INMUSOCOD, USOINM.INMUSODES AS USOINMUEB, CLIENT.CLIGRUCOD AS GRUPO, 
                    CLIENT.CLIGRUSUB AS SUBGRUPO, CLIENT.CODSCATTA AS SUBCATEGORIA, CLIENT.CIRPROY AS CIRCUITPROY, CLIENT.CEMVOLCONA AS CLASE, CLIENT.FECCEN, CLIENT.CODESCLTE , ESCLTE.DESESCLTE AS ESTADOCLI, 
                    CLIENT.CODTIPSER, TIPSER.DESTIPSER AS TIPOSERVICIO, CLIENT.CODTIPTEN, TIPTEN.DESTIPTEN AS TIPOTENENCIA, CLIENT.CODABASAG, TABSAG.DESABASAG AS ABASTECAGUA, CLIENT.CODABASDE, 
                    TABSDE.DESABASDE AS ABASTECDSG, NVL(COAGUA.CONCAJA,0) AS CONCAJA, COAGUA.CONCODTIP, COAGUA.CONCODIGO, COAGUA.NIVPRES, COAGUA.CONDIACOD, DICOAG.CONDIADES AS DIAMCNXAGUA, 
                    COAGUA.CNAMATCOD, TMCXAG.CNAMATDES AS MATERCONXAGUA, COAGUA.AGUTABCOD, TBPCJA.AGUTABDES AS MATERTAPAAGUA, COAGUA.ESTTAPCOD, TBTPST.ESTTAPDES AS ESTADOTAPAGUA, COAGUA.CONUBICAJ, 
                    UBIMED.UBICAJDES AS UBICAJAAGUA, COAGUA.CONCAJMAT, MATCJA.CONCAJDES AS MATERCAJAAGUA, COAGUA.CAJESTCOD AS CODESTCAJAG, ESCJAG.CAJESTDES AS ESTCAJAG, COAGUA.CONENTEJX, EJECCNXAGUA.ENTEEJEAGUDES, 
                    COAGUA.CONCIRCUI, COAGUA.ACONTRATO, COAGUA.MEDCODIGO AS CORRMEDIDOR, MEDIDO.MEDCODYGO AS MEDIDOR, MEDIDO.MEDFECINS, MEDIDO.DIAMEDCOD, 
                    TRIM(DICOAGMED.DIAMEDDES) || ' \"' AS DIAMEDIDOR, 
                    MEDIDO.MEDESTCOD, ESMEDI.MESESTDES, MEDIDO.MEDTIPCODX, TIPMED.MEDTIPDES, MEDIDO.MEDMARCODX, 
                    TMARMED.MAMDES, MEDIDO.MEDMODCODX, TMARMEDLEVEL1.MOMDES, MEDIDO.MEDFECFAC, MEDIDO.MEDFECRET, MEDIDO.MEDFECREG, MEDIDO.MEDLLACOD, 
                    MEDIDO.MEDCONCOD, TMEDCONDICION.MEDCONDES, NVL(CODESA.CONDCAJA,0) AS CONDCAJA, CODESA.CONDESTAD, ESTCONDE.CONDESDES, CODESA.CONDIDCOD, 
                    DICODE.CONDIDDES, CODESA.DCONTRATO, CODESA.CONCODTDE, CODESA.CONCODDES, CODESA.CONDENTEJX, CODESA.CAJESTCOD AS CODESTCAJDSG, ESCJAG.CAJESTDES AS ESTCAJDSG, 
                    CODESA.CAJMATCOD, MATCJADE.CAJMATDES, CODESA.CONDUBICA, UBIMEDDES.CONDUBIDES, CODESA.DESTAPCOD, TBPCJAD.DESTAPDES, 
                    CODESA.STDTAPCOD, TBTPSTDES.STDTAPDES, CLIENT.PORTARIFA, CLIENT.ORDENRL, CLIENT.CARGARL, PROPIE.CARGARD, PROPIE.ORDENRD, 
                    CODESA.DCONFECFIR, CODESA.CODFECING, ENTEJE.ENTEJEDES, PROVIN.PROVINDES, ZONASEC.ZONASECSRV, 
                    TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS FECHAPROCESO, TO_CHAR(SYSDATE, 'HH24:MI:SS') AS HORAPROCESO 
                    FROM PRDCOMCATMEDLEC.PREDIO 
                    INNER JOIN PRDCOMCATMEDLEC.CLIENT ON (PREDIO.PREREGION = CLIENT.PREREGION) AND (PREDIO.PREZONA = CLIENT.PREZONA) AND (PREDIO.PRESECTOR = CLIENT.PRESECTOR) AND (PREDIO.PREMZN = CLIENT.PREMZN) AND (PREDIO.PRELOTE = CLIENT.PRELOTE) 
                    AND CLIENT.CLICODFAC = ?
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.COAGUA ON (PREDIO.PREREGION = COAGUA.PREREGION) AND (PREDIO.PREZONA = COAGUA.PREZONA) AND (PREDIO.PRESECTOR = COAGUA.PRESECTOR) AND (PREDIO.PREMZN = COAGUA.PREMZN) AND (PREDIO.PRELOTE = COAGUA.PRELOTE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ZONASEC ON (ZONASEC.PREREGION = PREDIO.PREREGION) AND (ZONASEC.PREZONA = PREDIO.PREZONA) AND (ZONASEC.PRESECTOR = PREDIO.PRESECTOR) AND (ZONASEC.PRELOCALI = PREDIO.PRELOCALI) 
                    INNER JOIN PRDCOMCATMEDLEC.RLURBA ON (RLURBA.PREREGION = PREDIO.PREREGION) AND (RLURBA.PRELOCALI = PREDIO.PRELOCALI) AND (RLURBA.PREURBA = PREDIO.PREURBA) 
                    INNER JOIN PRDCOMCATMEDLEC.RLCALL ON (RLCALL.PREREGION = PREDIO.PREREGION) AND (RLCALL.PRELOCALI = PREDIO.PRELOCALI) AND (RLCALL.PRECALLE = PREDIO.PRECALLE) 
                    INNER JOIN PRDCOMCATMEDLEC.LOCALI ON (LOCALI.PREREGION = PREDIO.PREREGION) AND (LOCALI.PRELOCALI = PREDIO.PRELOCALI) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.CODESA ON (PREDIO.PREREGION = CODESA.PREREGION) AND (PREDIO.PREZONA = CODESA.PREZONA) AND (PREDIO.PRESECTOR = CODESA.PRESECTOR) AND (PREDIO.PREMZN = CODESA.PREMZN) AND (PREDIO.PRELOTE = CODESA.PRELOTE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTPRE ON (ESTPRE.CODESTPRE = PREDIO.CODESTPRE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCON ON (MATCON.CODMATCON = PREDIO.CODMATCON) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATVER ON (CODMATVER = VDAMATCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.PISCIN ON (PISCIN.PISCINCOD = PREDIO.PISCINCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.PROVIN ON (PROVINCOD = PREPROVIN) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.RESEVO ON (RESEVO.CODTIPRES = PREDIO.CODTIPRES) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPINM ON (TIPINM.CODTIPINM = PREDIO.CODTIPINM) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TPAVIM ON (PAVICOD = CLLPAVCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ENTEJE ON (ENTEJE.CONDENTEJX = CODESA.CONDENTEJX) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCJAG ON (ESCJAG.CAJESTCOD = CODESA.CAJESTCOD) AND (ESCJAG.CAJESTCOD = COAGUA.CAJESTCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MEDIDO ON (MEDIDO.MEDCODIGO = COAGUA.MEDCODIGO) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAGMED ON (DICOAGMED.DIAMEDCOD = MEDIDO.DIAMEDCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESMEDI ON (ESMEDI.MEDESTCOD = MEDIDO.MEDESTCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPMED ON (TIPMED.MEDTIPCODX = MEDIDO.MEDTIPCODX)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMEDCONDICION ON (TMEDCONDICION.MEDCONCOD = MEDIDO.MEDCONCOD)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MMEDIDORFAB ON (MMEDIDORFAB.MEDCODYGO = MEDIDO.MEDCODYGO)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMED ON (TMARMED.MAMCOD = MMEDIDORFAB.MAMCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMARMEDLEVEL1 ON (TMARMEDLEVEL1.MAMCOD = MMEDIDORFAB.MAMCOD) AND (TMARMEDLEVEL1.MOMCOD = MMEDIDORFAB.MOMCOD)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.DICOAG ON (DICOAG.CONDIACOD = COAGUA.CONDIACOD)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.EJECCNXAGUA ON (EJECCNXAGUA.CONENTEJX = COAGUA.CONENTEJX) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCON ON (ESTCON.CONESTADO = COAGUA.CONESTADO)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJA ON (MATCJA.CONCAJMAT = COAGUA.CONCAJMAT)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJA ON (TBPCJA.AGUTABCOD = COAGUA.AGUTABCOD)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPST ON (TBTPST.ESTTAPCOD = COAGUA.ESTTAPCOD)
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TMCXAG ON (TMCXAG.CNAMATCOD = COAGUA.CNAMATCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMED ON (UBIMED.CONUBICAJ = COAGUA.CONUBICAJ) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESTCONDE ON (ESTCONDE.CONDESTAD = CODESA.CONDESTAD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.MATCJADE ON (MATCJADE.CAJMATCOD = CODESA.CAJMATCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBPCJAD ON (TBPCJAD.DESTAPCOD = CODESA.DESTAPCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TBTPSTDES ON (TBTPSTDES.STDTAPCOD = CODESA.STDTAPCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.UBIMEDDES ON (UBIMEDDES.CONDUBICA = CODESA.CONDUBICA) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.DICODE ON (DICODE.CONDIDCOD = CODESA.CONDIDCOD) 
                    INNER JOIN PRDCOMCATMEDLEC.PROPIE ON (CLIENT.CLICODFAC = PROPIE.CLICODFAC) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.REGLOC ON (REGLOC.PREREGION = PROPIE.PREREGION) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TARIFA ON (TARIFA.CODCATTAR = PROPIE.CODCATTAR) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.ESCLTE ON (ESCLTE.CODESCLTE = CLIENT.CODESCLTE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSAG ON (TABSAG.CODABASAG = CLIENT.CODABASAG) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TABSDE ON (TABSDE.CODABASDE = CLIENT.CODABASDE) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPSER ON (TIPSER.CODTIPSER = CLIENT.CODTIPSER) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.TIPTEN ON (TIPTEN.CODTIPTEN = CLIENT.CODTIPTEN) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.USOINM ON (USOINM.INMUSOCOD = CLIENT.INMUSOCOD) 
                    LEFT OUTER JOIN PRDCOMCATMEDLEC.AMBITO ON (AMBITO.AMBCOD = LOCALI.AMBCOD) 
                    ORDER BY PREDIO.PREREGION, PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO", array($numero));
                }
            } elseif($tipo == 6) {
                $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.PSUNAT WHERE RUC = ?', array($numero));
            } else {
                $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.DOCIDENT WHERE NRODOC = ? AND TIPDOC = ?', array($numero, $tipo));
            }
            return $query->row_array();
        }

        public function getMedios(){
            $query = $this->oracle->query('SELECT * FROM PRDGESTIONCOMERCIAL.MMODOATE');
            return $query->result_array();
        }

        public function getProvincias(){
            $query = $this->oracle->query('SELECT * FROM PRDGESTIONCOMERCIAL.CUBIGEO1');
            return $query->result_array();
        }

        public function getProvinciasEspe($prov){
            $query = $this->oracle->query('SELECT * FROM PRDGESTIONCOMERCIAL.CUBIGEO1 where CPVCOD = ?', array($prov));
            return $query->result_array();
        }

        public function getDistritos($id){
            $query = $this->oracle->query('SELECT * FROM PRDGESTIONCOMERCIAL.CUBIGEO2 WHERE CPVCOD = ? AND CDSDES IS NOT NULL ', array($id));
            return $query->result_array();
        }
        public function getDistritoEspe($CPVCODDPR, $CDSCODDPR){
            $query = $this->oracle->query('SELECT * FROM PRDGESTIONCOMERCIAL.CUBIGEO2 WHERE CPVCOD = ? AND CDSCOD = ? ', array($CPVCODDPR, $CDSCODDPR));
            return $query->result_array();
        }

        public function  getGrupo_pobla($codProv, $codDis){
            $query = $this->oracle->query('SELECT * FROM PRDGESTIONCOMERCIAL.CUBIGEO3 WHERE CPVCOD = ? AND CDSCOD= ? AND CGPDES IS NOT NULL', array($codProv, $codDis));
            return $query->result_array();
        }

        public function  getGrupoPoblaEspe($CPVCODDPR, $CDSCODDPR, $CGPCODDPR){
            $query = $this->oracle->query('SELECT * FROM PRDGESTIONCOMERCIAL.CUBIGEO3 WHERE CPVCOD = ? AND CDSCOD= ? AND CGPCOD =?', array($CPVCODDPR, $CDSCODDPR, $CGPCODDPR));
            return $query->result_array();
        }

        public function  getVia_pobla($codDep, $codProv, $codDis, $codGrup){
            $query = $this->oracle->query('SELECT VIAS.MVICOD, VIAS.MVIDES FROM PRDGESTIONCOMERCIAL.CVIGRPO CVP ,PRDGESTIONCOMERCIAL.MVIAS VIAS 
            WHERE CVP.CDPCOD = ? AND CVP.CPVCOD =? AND CVP.CDSCOD=? AND CVP.CGPCOD=?   AND    VIAS.MVICOD = CVP.MVICOD AND VIAS.MVIDES IS NOT NULL  ', array($codDep, $codProv, $codDis, $codGrup));
            return $query->result_array();
        }
        public function  getVia_pobla_Espe($codDep, $codProv, $codDis, $codGrup, $codVia){
            $query = $this->oracle->query('SELECT VIAS.MVICOD, VIAS.MVIDES FROM PRDGESTIONCOMERCIAL.CVIGRPO CVP ,PRDGESTIONCOMERCIAL.MVIAS VIAS 
            WHERE CVP.CDPCOD = ? AND CVP.CPVCOD =? AND CVP.CDSCOD=? AND CVP.CGPCOD=?   AND    VIAS.MVICOD = ? AND VIAS.MVIDES IS NOT NULL  ', array($codDep, $codProv, $codDis, $codGrup, $codVia));
            return $query->result_array();
        }

        public function getNombreModalidad($id){
            $query = $this->oracle->query('SELECT MOADES FROM PRDGESTIONCOMERCIAL.MMODOATE WHERE MOACOD = ?', array($id));
            return $query->row_array()['MOADES'];
        }


        public function getAllProblemasXTipo($tip, $cpi){
            $query = $this->oracle->query('SELECT  * FROM PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE M1.TIPPROBID = ? AND M1.CPID = ?', array($tip, $cpi));
            return $query->result_array();
        }

        public function getAllProblemasDetalle($tip, $cpi, $sca){
            $query = $this->oracle->query('SELECT  * FROM PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 INNER JOIN 
            PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE M1.TIPPROBID = ? AND M1.CPID = ? AND M2.SCATPROBID = ?', array($tip, $cpi, $sca));
            return $query->result_array();
        }

        public function getNombreProvincia($id){
            $query = $this->oracle->query('SELECT CPVDES FROM PRDGESTIONCOMERCIAL.CUBIGEO1 WHERE CPVCOD = ?', array($id));
            return $query->row_array()['CPVDES'];
        }

        public function getNombreDistrito($id, $dis){
            $query = $this->oracle->query('SELECT CDSDES FROM PRDGESTIONCOMERCIAL.CUBIGEO2 WHERE CPVCOD = ? AND CDSCOD = ?', array($id, $dis));
            return $query->row_array()['CDSDES'];
        }

        public function getDetalleReclamo($p){
            $this->oracle->select("SCATPROBDESC");
            $this->oracle->from("PRDGESTIONCOMERCIAL.MPROBLEMAS2");
            $this->oracle->where("CPID", $p[0]);
            $this->oracle->where("TIPPROBID", $p[1]);
            $this->oracle->where("SCATPROBID", $p[2]);
            return $this->oracle->get()->row_array()['SCATPROBDESC'];
        }

        public function getDetalleReclamo1($p){
            $this->oracle->select("PROBDESC");
            $this->oracle->from("PRDGESTIONCOMERCIAL.MPROBLEMAS3");
            $this->oracle->where("CPID", $p[0]);
            $this->oracle->where("TIPPROBID", $p[1]);
            $this->oracle->where("SCATPROBID", $p[2]);
            $this->oracle->where("PROBID", $p[3]);
            return $this->oracle->get()->row_array()['PROBDESC'];
        }

        public function searchUsuario($tipo, $numero){
            $this->oracle->select("NRODOC");
            $this->oracle->from("PRDDBFCOMERCIAL.DOCIDENT");
            $this->oracle->where("TIPDOC", $tipo);
            $this->oracle->where("NRODOC", $numero);
            return $this->oracle->get()->row_array()['NRODOC'];
        }
        public function searchUsuario2($tipo, $numero){
            $this->oracle->select("*");
            $this->oracle->from("PRDDBFCOMERCIAL.DOCIDENT");
            $this->oracle->where("TIPDOC", $tipo);
            $this->oracle->where("NRODOC", $numero);
            return $this->oracle->get()->row_array();
        }

        public function saveUsuario($apellidoM, $apellidoP, $nombre, 
                                    $tipoDoc1, $numero,$telefono, $email){
            $this->oracle->trans_begin();
            $data = array(
                "NRODOC" => $numero,
                "TIPDOC" => $tipoDoc1,
                "APEPAT" => $apellidoP,
                "APEMAT" => $apellidoM,
                "NOMBRE" => $nombre,
                "EMAIL" => $email, 
                "TELCEL" => $telefono
            );

            $this->oracle->insert('PRDDBFCOMERCIAL.DOCIDENT', $data);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            } else {
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function updateUsuario($apellidoM, $apellidoP, $nombre, 
                                    $tipoDoc1, $numero,  $telefono, $email){
            $this->oracle->trans_begin();
            $data = array(
                "APEPAT" => $apellidoP,
                "APEMAT" => $apellidoM,
                "NOMBRE" => $nombre,
                "EMAIL" => $email, 
                "TELCEL" => $telefono
            );
            $this->oracle->where('NRODOC', $numero);
            $this->oracle->where('TIPDOC', $tipoDoc1);
            $this->oracle->update('PRDDBFCOMERCIAL.DOCIDENT', $data);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            } else {
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function getAreas(){
            $this->oracle->select("*");
            $this->oracle->from("PRDDBFCOMERCIAL.MAREAS");
            $this->oracle->where("SARCOD", 1);
            return $this->oracle->get()->result_array();
        }

        public function get_dire_sumin($suministro){
            $this->oracle->select("CDPCOD, CPVCOD, CDSCOD, CGPCOD, MVICOD, UUNROMUN");
            $this->oracle->from("PRDGESTIONCOMERCIAL.MUNIUSO");
            $this->oracle->where("UUCOD", $suministro);
            return $this->oracle->get()->result_array();
        }

        public function almacenarReclamo($suministro, $detalle1, $modalidad, $numero, $telefono, $email, $problemas, $tipoDoc1, $razonSocial, $direccion){
            $this->oracle->trans_begin();

            $serie = $this->getSerie($_SESSION['accesoReclamos'], 4, 5);
            $numero1 = $this->getNumero($serie);
            $data = array(
                "EMPCOD" => $_SESSION['accesoReclamos']['EMPCOD'],
                "OFICOD" => $_SESSION['accesoReclamos']['OFICOD'],
                "ARECOD" => $_SESSION['accesoReclamos']['ARECOD'],
                "CTDCOD"  => 4,
                "DOCCOD" => 5,
                "SERNRO" => $serie,
                "RECID" => $numero1,
                "UUCOD" => $suministro,
                "RECDESC" => $detalle1,
                "RECFCH" => date('d/m/Y'),
                "RECANIOREC" => date('Y'), 
                "RECMESREC" => date('m'),
                "RECHRA" => date('H:i:s'),
                "CPID" => $problemas[0],
                "TIPPROBID" => $problemas[1],
                "SCATPROBID" => $problemas[2],
                "PROBID" => ( isset($problemas[3]) ? $problemas[3] : null) ,
                "CDPCODDPR" => $direccion[0]['CDPCOD'],
                "CPVCODDPR" => $direccion[0]['CPVCOD'],
                "CDSCODDPR" => $direccion[0]['CDSCOD'],
                "CGPCODDPR" => $direccion[0]['CGPCOD'],
                "MVICODDPR" => $direccion[0]['MVICOD'],
                "RECDPNMUN" => $direccion[0]['UUNROMUN'],
                "RECDPTELF" => $telefono,
                "RECDPMAIL" => $email,
                "MOACOD" => $modalidad, 
                "SRECCOD" => 1,
                "USRCODER" => $_SESSION['user_id'],
                "DOCIDENT_NRODOC" => $numero,
                "DOCIDENT_TIPDOC" => $tipoDoc1, 
                "RAZSOCIAL" => $razonSocial
            );
            $this->oracle->insert('PRDDBFCOMERCIAL.RECNORELFACT', $data);
            /*
            $correlativo = $this->getCorrelativoMareasXNoFac();
            $data1 = array(
                "RECNORARECOD" => $correlativo,
                "FECREGDERV" => date('d/m/Y'),
                "ESTREGDERV" => 1,
                "USRREGDERV" => $_SESSION['user_id'],
                "DESCRIPCDERV" => $glosa,
                "RECNORELFACT_EMPCOD" => $_SESSION['accesoReclamos']['EMPCOD'],
                "RECNORELFACT_OFICOD" => $_SESSION['accesoReclamos']['OFICOD'],
                "RECNORELFACT_ARECOD" => $_SESSION['accesoReclamos']['ARECOD'],
                "RECNORELFACT_CTDCOD"  => 4,
                "RECNORELFACT_DOCCOD" => 5,
                "RECNORELFACT_SERNRO" => $serie,
                "RECNORELFACT_RECID" => $numero1,
                "MAREA_ARECOD" => $area
            );
            $this->oracle->insert('PRDDBFCOMERCIAL.RECNORELFACTXMAREAS', $data1);*/
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            } else {
                $this->oracle->trans_commit();
                return [$_SESSION['accesoReclamos']['EMPCOD'], $_SESSION['accesoReclamos']['OFICOD'], $_SESSION['accesoReclamos']['ARECOD'], 4, 5, $serie, $numero1];
            }

        }


        public function almacenarReclamo2($suministro, $detalle1, $modalidad, $numero, $lote, $urbanizacion, $provincia, $distrito, $grupo_pobla, $via, $telefono,  $problemas, $numeroM,  $manzana, $tipoDoc1, $razonSocial){
            $this->oracle->trans_begin();
            $serie = $this->getSerie($_SESSION['accesoReclamos'], 4, 5);
            $numero1 = $this->getNumero($serie);
            $data = array(
                "EMPCOD" => $_SESSION['accesoReclamos']['EMPCOD'],
                "OFICOD" => $_SESSION['accesoReclamos']['OFICOD'],
                "ARECOD" => $_SESSION['accesoReclamos']['ARECOD'],
                "CTDCOD"  => 4,
                "DOCCOD" => 5,
                "SERNRO" => $serie,
                "RECID" => $numero1,
                "UUCOD" => $suministro,
                "RECDESC" => $detalle1,
                "RECFCH" => date('d/m/Y'),
                "RECANIOREC" => date('Y'), 
                "RECMESREC" => date('m'),
                "RECHRA" => date('H:i:s'),
                "CPID" => $problemas[0],
                "TIPPROBID" => $problemas[1],
                "SCATPROBID" => $problemas[2],
                "PROBID" => ( isset($problemas[3]) ? $problemas[3] : null) ,
                "CDPCODDPR" => 13,
                "CPVCODDPR" => $provincia,
                "CDSCODDPR" => $distrito,
                "CGPCODDPR" => $grupo_pobla,
                "MVICODDPR" => $via,
                "RECDPNMUN" => $numeroM,
                "RECDPMZN" => $manzana,
                "RECDPLOTE" => $lote,
                "RECDPTELF" => $telefono,
                "MOACOD" => $modalidad, 
                "SRECCOD" => 1,
                "USRCODER" => $_SESSION['user_id'],
                "DOCIDENT_NRODOC" => $numero,
                "DOCIDENT_TIPDOC" => $tipoDoc1, 
                "RAZSOCIAL" => $razonSocial
            );
            $this->oracle->insert('PRDDBFCOMERCIAL.RECNORELFACT', $data);
            /*
            $correlativo = $this->getCorrelativoMareasXNoFac();
            $data1 = array(
                "RECNORARECOD" => $correlativo,
                "FECREGDERV" => date('d/m/Y'),
                "ESTREGDERV" => 1,
                "USRREGDERV" => $_SESSION['user_id'],
                "DESCRIPCDERV" => $glosa,
                "RECNORELFACT_EMPCOD" => $_SESSION['accesoReclamos']['EMPCOD'],
                "RECNORELFACT_OFICOD" => $_SESSION['accesoReclamos']['OFICOD'],
                "RECNORELFACT_ARECOD" => $_SESSION['accesoReclamos']['ARECOD'],
                "RECNORELFACT_CTDCOD"  => 4,
                "RECNORELFACT_DOCCOD" => 5,
                "RECNORELFACT_SERNRO" => $serie,
                "RECNORELFACT_RECID" => $numero1,
                "MAREA_ARECOD" => $area
            );
            $this->oracle->insert('PRDDBFCOMERCIAL.RECNORELFACTXMAREAS', $data1);*/
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            } else {
                $this->oracle->trans_commit();
                return [$_SESSION['accesoReclamos']['EMPCOD'], $_SESSION['accesoReclamos']['OFICOD'], $_SESSION['accesoReclamos']['ARECOD'], 4, 5, $serie, $numero1];
            }

        }

        private function getCorrelativoMareasXNoFac(){
            $this->oracle->select("RECNORARECOD");
            $this->oracle->from ("PRDDBFCOMERCIAL.RECNORELFACTXMAREAS");
            $this->oracle->order_by("RECNORARECOD", "desc");
            return $this->oracle->get()->row_array()['RECNORARECOD'] + 1;
        }

        private function getSerie($codigos, $CTDCOD, $DOCCOD){
            $this->oracle->select("SERNRO");
            $this->oracle->from ("PRDGESTIONCOMERCIAL.CSERIES");
            $this->oracle->where("EMPCOD", $codigos['EMPCOD']);
            $this->oracle->where("OFICOD", $codigos['OFICOD']);
            $this->oracle->where("ARECOD", $codigos['ARECOD']);
            $this->oracle->where("CTDCOD", $CTDCOD);
            $this->oracle->where("DOCCOD", $DOCCOD);
            return $this->oracle->get()->row_array()['SERNRO'];
        }

        private function getNumero($serie){
            $this->oracle->select("RECID");
            $this->oracle->from ("PRDDBFCOMERCIAL.RECNORELFACT");
            $this->oracle->order_by("RECID", "desc");
            $this->oracle->where("SERNRO", $serie);
            return $this->oracle->get()->row_array()['RECID'] + 1;
        }

        public function getReclamosParticularesList(){
            $query = $this->oracle->query("SELECT  RELATIVO.* FROM PRDDBFCOMERCIAL.RECNORELFACT RELATIVO
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 ON M3.CPID = RELATIVO.CPID AND M3.TIPPROBID = RELATIVO.TIPPROBID AND M3.SCATPROBID = RELATIVO.SCATPROBID AND M3.PROBID = RELATIVO.PROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE M3.ALCANCE_PROBLEMA ='P'");
            return $query->result_array();
           
        }

        public function getReclamosGeneralesList(){
            $query = $this->oracle->query("SELECT  RELATIVO.* FROM PRDDBFCOMERCIAL.RECNORELFACT RELATIVO
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 ON M3.CPID = RELATIVO.CPID AND M3.TIPPROBID = RELATIVO.TIPPROBID AND M3.SCATPROBID = RELATIVO.SCATPROBID AND M3.PROBID = RELATIVO.PROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE M3.ALCANCE_PROBLEMA ='G'");
            return $query->result_array();
        }

        public function get_Datos_numero_tipo($min, $hoy, $tipo, $tipo_problema, $datos_problema){
            $tip='';
            $tipo_pro = '';
            if($tipo == '1'){
                $tip = $tip ." M3.ALCANCE_PROBLEMA ='P' AND ";
            }else{
                $tip = $tip ." M3.ALCANCE_PROBLEMA ='G' AND ";
            }
            if($tipo_problema == '1'){
                $tipo_pro = $tipo_pro ." RELATIVO.CPID = 1  AND ";
            }else{
                $tipo_pro = $tipo_pro ." RELATIVO.CPID = 2  AND ";
            }
            $sql = "SELECT  
                    SUM(CASE WHEN SRECCOD= '1' THEN 1 ELSE 0 END) PENDIENTE,
                    SUM(CASE WHEN SRECCOD= '2' THEN 1 ELSE 0 END) ATENDIDO,
                    SUM(CASE WHEN SRECCOD= '3' THEN 1 ELSE 0 END) ELIMINADO 
                    FROM PRDDBFCOMERCIAL.RECNORELFACT RELATIVO
                    INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 ON M3.CPID = RELATIVO.CPID AND M3.TIPPROBID = RELATIVO.TIPPROBID AND M3.SCATPROBID = RELATIVO.SCATPROBID AND M3.PROBID = RELATIVO.PROBID
                    INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
                    INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
                    INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
                    WHERE ".$tip.$tipo_pro."  RELATIVO.RECFCH  BETWEEN TO_DATE('".$min."', 'DD/MM/YYYY') AND TO_DATE('".$hoy."', 'DD/MM/YYYY') AND RELATIVO.TIPPROBID =".$datos_problema['TIPPROBID']." AND  RELATIVO.SCATPROBID = ".$datos_problema['SCATPROBID']." AND  RELATIVO.PROBID =".$datos_problema['PROBID'];
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;

        }


        public function getReclamosList2($min, $hoy, $tipo, $estado, $tipo_problema){
            $tip='';
            $est ='';
            $tipo_pro = '';
            if($tipo == '0'){
                $tip = '';
            }else{
                if($tipo == '1'){
                    $tip = $tip ." M3.ALCANCE_PROBLEMA ='P' AND ";
                }else{
                    $tip = $tip ." M3.ALCANCE_PROBLEMA ='G' AND ";
                }
            }
            if($estado == '0'){
                $est = '';
            }else{
                if($estado == '1'){
                    $est = $est ." RELATIVO.SRECCOD = 2 AND ";
                }else{
                    $est = $est ." RELATIVO.SRECCOD = 1 AND ";
                }
            }
            if($tipo_problema == '0'){
                $tipo_pro = '';
            }else{
                if($tipo_problema == '1'){
                    $tipo_pro = $tipo_pro ." RELATIVO.CPID = 1  AND ";
                }else{
                    $tipo_pro = $tipo_pro ." RELATIVO.CPID = 2  AND ";
                }
            }
            $sql = "SELECT  RELATIVO.*, CASE M3.ALCANCE_PROBLEMA WHEN 'G' THEN 'GENERAL' ELSE 'PARTICULAR' END AS TIPO_SOLICITUD, CASE MP.CPID WHEN 1 THEN 'OPERACIONAL' ELSE 'COMERCIAL' END AS TIPO_PROBLEMA  
            FROM PRDDBFCOMERCIAL.RECNORELFACT RELATIVO
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS3 M3 ON M3.CPID = RELATIVO.CPID AND M3.TIPPROBID = RELATIVO.TIPPROBID AND M3.SCATPROBID = RELATIVO.SCATPROBID AND M3.PROBID = RELATIVO.PROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS2 M2 ON M3.CPID = M2.CPID AND M3.TIPPROBID = M2.TIPPROBID AND M3.SCATPROBID = M2.SCATPROBID
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1 M1 ON M1.CPID = M2.CPID AND M1.TIPPROBID = M2.TIPPROBID 
            INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS  MP ON MP.CPID = M1.CPID
            WHERE ".$tip.$est.$tipo_pro."  RELATIVO.RECFCH  BETWEEN TO_DATE('".$min."', 'DD/MM/YYYY') AND TO_DATE('".$hoy."', 'DD/MM/YYYY')  ORDER BY RELATIVO.RECFCH DESC ";
            $outValue = $this->oracle->query($sql)->result();
            return $outValue;
        }

        public function getReclamosList(){
            $this->oracle->select("*");
            $this->oracle->from("PRDDBFCOMERCIAL.RECNORELFACT");
            $this->oracle->order_by("RECFCH", "DESC");
            $this->oracle->order_by("RECHRA", "DESC");
            return $this->oracle->get()->result_array();
        }

        public function getReclamo($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID){
            $this->oracle->select("*");
            $this->oracle->from("PRDDBFCOMERCIAL.RECNORELFACT");
            $this->oracle->where("EMPCOD", $EMPCOD);
            $this->oracle->where("OFICOD", $OFICOD);
            $this->oracle->where("ARECOD", $ARECOD);
            $this->oracle->where("CTDCOD", $CTDCOD);
            $this->oracle->where("DOCCOD", $DOCCOD);
            $this->oracle->where("SERNRO", $SERNRO);
            $this->oracle->where("RECID", $RECID);
            return $this->oracle->get()->row_array();
        }

        public function setOrden_reclamo($solicitud, $apePaterno, $apeMaterno, $nombre){
            /* BUSCO EN LA TABLA DE LAS SERIES  */
            $this->oracle->select("SERNRO, SERULTNRO, SERININRO, SERFINNRO ");
            $this->oracle->from("PRDGESTIONCOMERCIAL.CSERIES");
            $this->oracle->where("EMPCOD", $solicitud['EMPCOD']);
            $this->oracle->where("OFICOD", $solicitud['OFICOD']);
            $this->oracle->where("ARECOD", $solicitud['ARECOD']);
            $this->oracle->where("CTDCOD", 2);
            $this->oracle->where("DOCCOD", 1);
            $respuesta =  $this->oracle->get()->row_array();
            if(((int)$respuesta['SERULTNRO']+1)> (int)$respuesta['SERFINNRO']){
                return  array('rpta' => false, 'mensaje' => 'La cantidad de ordenes de requerimiento supero el maximo' );
            }else{
                $this->oracle->trans_begin();
                $data = array(
                    "SERULTNRO" => ((int)$respuesta['SERULTNRO']+1)
                );
                $this->oracle->where("EMPCOD", $solicitud['EMPCOD']);
                $this->oracle->where("OFICOD", $solicitud['OFICOD']);
                $this->oracle->where("ARECOD", $solicitud['ARECOD']);
                $this->oracle->where("CTDCOD", 2);
                $this->oracle->where("DOCCOD", 1);
                $this->oracle->update('PRDGESTIONCOMERCIAL.CSERIES', $data);
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return  array('rpta' => false, 'mensaje' => 'Ocurrio un error en el guardado de las series' );
                }else{
                    $data = array(
                        "EMPCOD" => $solicitud['EMPCOD'],
                        "OFICOD" => $solicitud['OFICOD'],
                        "ARECOD" => $solicitud['ARECOD'],
                        "CTDCOD" => 2,
                        "DOCCOD" => 1,
                        "SERNRO" =>$respuesta['SERNRO'],
                        "SAPNRO" => ((int)$respuesta['SERULTNRO']+1),
                        "SOACOD" => 0 ,
                        "SCACOD" => 0 ,
                        "SPRCOD" => 0 , 
                        "SAPFCHREG" => date('d/m/Y'),
                        "SAPHRAREG" => date('H:i:s'),
                        "TMACOD" => 0 ,
                        "SAPAPPSOL" =>  $apePaterno,
                        "SAPAPMSOL" =>  $apeMaterno,
                        "SAPNOMSOL" =>  $nombre,
                        "SAPNRODOCL" => $solicitud['DOCIDENT_NRODOC'],
                        "SAPSUMI" =>    $solicitud['UUCOD'],
                        "SAPRAZSOC" =>  $solicitud['RAZSOCIAL'],
                        "SAPCALSOL" => 0 ,
                        "CDPCOD" => $solicitud['CDPCODDPR'],
                        "CPVCOD" => $solicitud['CPVCODDPR'],
                        "CDSCOD" => $solicitud['CDSCODDPR'],
                        "CGPCOD" => $solicitud['CGPCODDPR'],
                        "MVICOD" => $solicitud['MVICODDPR'],
                        "SAPNROSOL" => $solicitud['RECDPNMUN'],
                        "SAPDIRREF" => 0 ,
                        "SAPURBSOL" => 0 ,
                        "SAPTLFSOL" =>  $solicitud['RECDPTELF'],
                        "SAPMAILSOL" => $solicitud['RECDPMAIL'],
                        "SAPDESPRO" =>  $solicitud['RECDESC'],
                        "SSOCOD" => 0 ,
                        "USRCOD" => $_SESSION["user_id"],
                        "STUSRSORUPD" => 0 ,
                        "SAPFCHUPD" => date('d/m/Y'),
                        "SAPHRAUPD" => date('H:i:s'),
                        "SAPGLS01" => 0
                    );        
                }
            }
        }

        public function saveRespuesta($EMPCOD, $OFICOD, $ARECOD, $CTDCOD, $DOCCOD, $SERNRO, $RECID, $DESC){
            $this->oracle->trans_begin();
            $data = array(
                "RESPUFEC" => date('d/m/Y'),
                "RESPUHOR" => date('H:i:s'),
                "RESPUREQ" => $DESC,
                "RESUSR" => $_SESSION["user_id"],
                "SRECOD" => 2
            );
            $this->oracle->where('EMPCOD', $EMPCOD);
            $this->oracle->where('OFICOD', $OFICOD);
            $this->oracle->where('ARECOD', $ARECOD);
            $this->oracle->where('CTDCOD', $CTDCOD);
            $this->oracle->where('DOCCOD', $DOCCOD);
            $this->oracle->where('SERNRO', $SERNRO);
            $this->oracle->where('RECID', $RECID);
            $this->oracle->update('PRDDBFCOMERCIAL.RECNORELFACT', $data);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            } else {
                $this->oracle->trans_commit();
                return true;
            }
        }
        /* para registrar reclamo  */

        public function get_dni_reclamo($dni){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.MRECLAMANTE");
            $this->oracle->where("PREDOCID", $dni);
            return $this->oracle->get()->row_array();
        }

        public function get_reclamante_concilia($codi_reclamante){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.MRECLAMANTE");
            $this->oracle->where("PRECOD", $codi_reclamante);
            return $this->oracle->get()->row_array();
        }


        public function get_hora_consumo($resultado){
            $this->oracle->select("CNCHORINI");
            $this->oracle->from("PRDGESTIONCOMERCIAL.OCONCILIA");
            $this->oracle->where('EMPCOD', $resultado['EMPCOD']);
            $this->oracle->where('OFICOD', $resultado['OFICOD']);
            $this->oracle->where('ARECOD', $resultado['ARECOD']);
            $this->oracle->where('CTDCOD', $resultado['CTDCOD']);
            $this->oracle->where('DOCCOD', $resultado['DOCCOD']);
            $this->oracle->where('SERNRO', $resultado['SERNRO']);
            $this->oracle->where('RECID', $resultado['RECID']);
            return $this->oracle->get()->row_array();
        }

        public function get_reclamante_edicion($codigo){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.MRECLAMANTE where PRECOD = ?",array($codigo));
            return $query->row_array();
        }

        public function get_empresa(){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.CEMPRES");
            return $this->oracle->get()->row_array(); 
        }

        public function set_reclamante($parametros){
            $this->oracle->trans_begin();
            $query = $this->oracle->query("SELECT max(precod) as Maximo FROM PRDGESTIONCOMERCIAL.MRECLAMANTE");
            $dato = $query->row_array();
            $parametros['PRECOD'] = (int)$dato['MAXIMO']+1;
            $this->oracle->insert('PRDGESTIONCOMERCIAL.MRECLAMANTE', $parametros);

            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function guardar_reclamo_nuevo($parametros, $paraConcilia){
            $this->oracle->trans_begin();
            $query = $this->oracle->query("SELECT max(RECID) as Maximo FROM PRDGESTIONCOMERCIAL.ORECLAMO WHERE  EMPCOD = ".$parametros['EMPCOD']." AND OFICOD = ".$parametros['OFICOD']." AND ARECOD = ".$parametros['ARECOD']." AND CTDCOD =".$parametros['CTDCOD']." AND DOCCOD = ".$parametros['DOCCOD']." AND SERNRO = ".$parametros['SERNRO'] );
            $dato = $query->row_array();
            $parametros['RECID'] = (int)$dato['MAXIMO']+1;
            $paraConcilia['RECID'] = $parametros['RECID'];
            $this->oracle->insert('PRDGESTIONCOMERCIAL.ORECLAMO', $parametros);
            $rpta =  array();
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                $rpta =  array('respuesta' => false );
                return $rpta;
            }else{
                $this->oracle->insert('PRDGESTIONCOMERCIAL.OCONCILIA', $paraConcilia);
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    $rpta =  array('respuesta' => false );
                    return $rpta;
                }else{
                    $this->oracle->trans_commit();
                    $rpta =  array('respuesta' => true,
                                   'id_recla' => $parametros['RECID']  
                                );
                    return $rpta;
                }
                
            }
        }

        public function set_update_reclamante($parametros, $codigo){
            $this->oracle->trans_begin();
            $this->oracle->where('PRECOD', $codigo);
            $this->oracle->update('PRDGESTIONCOMERCIAL.MRECLAMANTE', $parametros);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            }else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function get_dire_reclamante($CDPCOD, $CPVCOD, $CDSCOD, $CGPCOD, $MVICOD){
            $query = $this->oracle->query("SELECT CVP.CDPCOD, CU0.CDPDES, CVP.CPVCOD, CU1.CPVDES, CVP.CDSCOD, CU2.CDSDES, CVP.CGPCOD, CU3.CGPDES,  CVP.MVICOD, MVI.MVIDES
            FROM PRDGESTIONCOMERCIAL.CVIGRPO CVP
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO3 CU3 ON CU3.CDPCOD = CVP.CDPCOD AND CU3.CPVCOD = CVP.CPVCOD AND CU3.CDSCOD = CVP.CDSCOD AND CU3.CGPCOD = CVP.CGPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO2 CU2 ON CU2.CDPCOD = CVP.CDPCOD AND CU2.CPVCOD = CVP.CPVCOD AND CU2.CDSCOD = CVP.CDSCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO1 CU1 ON CU1.CDPCOD = CVP.CDPCOD AND CU1.CPVCOD = CVP.CPVCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO  CU0 ON CU0.CDPCOD = CVP.CDPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.MVIAS    MVI ON MVI.MVICOD = CVP.MVICOD
            WHERE CVP.CDPCOD = ? AND CVP.CPVCOD= ? AND   CVP.CDSCOD= ? AND   CVP.CGPCOD = ? AND   CVP.MVICOD= ? ",array($CDPCOD, $CPVCOD, $CDSCOD, $CGPCOD, $MVICOD));
            return $query->row_array();
        }

        public function get_reclamo($empresa, $oficina, $area, $ctcod, $doccod, $serie, $idReclamo){
            $query = $this->oracle->query("SELECT * FROM  PRDGESTIONCOMERCIAL.ORECLAMO
            WHERE EMPCOD = ? AND OFICOD= ? AND   ARECOD= ? AND   CTDCOD = ? AND  DOCCOD= ? AND SERNRO =? AND RECID =? ",array($empresa, $oficina, $area, $ctcod, $doccod, $serie, $idReclamo));
            return $query->row_array();

        }

        

        public function get_serie(){
            $query = $this->oracle->query("SELECT  CSE.SERNRO
            FROM PRDGESTIONCOMERCIAL.MUSUARIO MUS
                INNER JOIN PRDGESTIONCOMERCIAL.CSERIES CSE ON CSE.EMPCOD = MUS.EMPCOD AND CSE.OFICOD = MUS.OFICOD  AND CSE.ARECOD = MUS.ARECOD AND CTDCOD = 4 AND DOCCOD = 5
            WHERE MUS.USRLOG = ?",array($_SESSION['login']));
        return $query->row_array();
        }

        public function get_documento_reclamo($suministro){
            $query = $this->oracle->query("SELECT CLIENT.CLICODFAC, TRIM(PROPIE.CLINOMBRE) AS NOMBRE, 
            TRIM(TRIM(SUBSTR(LOCALI.LOCDES,6,60)) || ' - ' || TRIM(RLURBA.URBDES) || ' ' || TRIM(RLCALL.CALDES) || ' ' || TRIM(PREDIO.PREMUNI)) AS DIRECCION, 
            NVL(PROPIE.CLIELECT,' ') AS DNI, NVL(PROPIE.CLIRUC,' ') AS RUC, PROPIE.TARIFA, PROPIE.CODCATTAR, TARIFA.DESCATTAR AS CATEGTARIF, 
            PREDIO.FACCICCOD AS CICLO,  MEDIDO.MEDCODYGO AS MEDIDOR,
            TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS FECHAPROCESO, TO_CHAR(SYSDATE, 'HH24:MI:SS') AS HORAPROCESO 
            FROM PRDCOMCATMEDLEC.PREDIO 
            INNER JOIN PRDCOMCATMEDLEC.CLIENT ON (PREDIO.PREREGION = CLIENT.PREREGION) AND (PREDIO.PREZONA = CLIENT.PREZONA) AND (PREDIO.PRESECTOR = CLIENT.PRESECTOR) AND (PREDIO.PREMZN = CLIENT.PREMZN) AND (PREDIO.PRELOTE = CLIENT.PRELOTE) 
            AND CLIENT.CLICODFAC = ?
            INNER JOIN PRDCOMCATMEDLEC.RLURBA ON (RLURBA.PREREGION = PREDIO.PREREGION) AND (RLURBA.PRELOCALI = PREDIO.PRELOCALI) AND (RLURBA.PREURBA = PREDIO.PREURBA) 
            INNER JOIN PRDCOMCATMEDLEC.RLCALL ON (RLCALL.PREREGION = PREDIO.PREREGION) AND (RLCALL.PRELOCALI = PREDIO.PRELOCALI) AND (RLCALL.PRECALLE = PREDIO.PRECALLE) 
            INNER JOIN PRDCOMCATMEDLEC.LOCALI ON (LOCALI.PREREGION = PREDIO.PREREGION) AND (LOCALI.PRELOCALI = PREDIO.PRELOCALI) 
            INNER JOIN PRDCOMCATMEDLEC.PROPIE ON (CLIENT.CLICODFAC = PROPIE.CLICODFAC) 
            LEFT OUTER JOIN PRDCOMCATMEDLEC.COAGUA ON (PREDIO.PREREGION = COAGUA.PREREGION) AND (PREDIO.PREZONA = COAGUA.PREZONA) AND (PREDIO.PRESECTOR = COAGUA.PRESECTOR) AND (PREDIO.PREMZN = COAGUA.PREMZN) AND (PREDIO.PRELOTE = COAGUA.PRELOTE) 
            LEFT OUTER JOIN PRDCOMCATMEDLEC.MEDIDO ON (MEDIDO.MEDCODIGO = COAGUA.MEDCODIGO) 
            LEFT OUTER JOIN PRDCOMCATMEDLEC.TARIFA ON (TARIFA.CODCATTAR = PROPIE.CODCATTAR) 
            ORDER BY PREDIO.PREREGION, PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO ",array($suministro));
            return $query->row_array();
        }

        public function get_documento7di_reclamo($grupo, $sub_grupo) {
            $query = $this->oracle->query("SELECT CLIENT.CLICODFAC, TRIM(GR.CLINOMBRE) AS NOMBRE, 
            TRIM(TRIM(SUBSTR(LOCALI.LOCDES,6,60)) || ' - ' || TRIM(RLURBA.URBDES) || ' ' || TRIM(RLCALL.CALDES) || ' ' || TRIM(PREDIO.PREMUNI)) AS DIRECCION, 
            NVL(GR.CLIELECT,' ') AS DNI, NVL(GR.CLIRUC,' ') AS RUC, GR.TARIFA, GR.CODCATTAR, TARIFA.DESCATTAR AS CATEGTARIF, 
            PREDIO.FACCICCOD AS CICLO,  MEDIDO.MEDCODYGO AS MEDIDOR,
            TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS FECHAPROCESO, TO_CHAR(SYSDATE, 'HH24:MI:SS') AS HORAPROCESO 
            FROM PRDCOMCATMEDLEC.PREDIO 
            INNER JOIN PRDCOMCATMEDLEC.CLIENT ON (PREDIO.PREREGION = CLIENT.PREREGION) AND (PREDIO.PREZONA = CLIENT.PREZONA) AND (PREDIO.PRESECTOR = CLIENT.PRESECTOR) AND (PREDIO.PREMZN = CLIENT.PREMZN) AND (PREDIO.PRELOTE = CLIENT.PRELOTE) 
            AND CLIENT.CLIGRUCOD =  ? AND CLIENT.CLIGRUSUB = ?
            INNER JOIN PRDCOMCATMEDLEC.RLURBA ON (RLURBA.PREREGION = PREDIO.PREREGION) AND (RLURBA.PRELOCALI = PREDIO.PRELOCALI) AND (RLURBA.PREURBA = PREDIO.PREURBA) 
            INNER JOIN PRDCOMCATMEDLEC.RLCALL ON (RLCALL.PREREGION = PREDIO.PREREGION) AND (RLCALL.PRELOCALI = PREDIO.PRELOCALI) AND (RLCALL.PRECALLE = PREDIO.PRECALLE) 
            INNER JOIN PRDCOMCATMEDLEC.LOCALI ON (LOCALI.PREREGION = PREDIO.PREREGION) AND (LOCALI.PRELOCALI = PREDIO.PRELOCALI) 
            INNER JOIN 
                    (SELECT PROPIE.*, 
                    SUBSTR(TRIM(PROPIE.CLICODFAC),1,3) || SUBSTR(TRIM(PROPIE.CLICODFAC),8,4) AS CODGRUPO 
                    FROM PRDCOMCATMEDLEC.PROPIE 
                    WHERE  SUBSTR(TRIM(PROPIE.CLICODFAC),4,4) = '0000') GR 
                    ON GR.CLICODFAC =  TRIM(TO_CHAR(CLIENT.CLIGRUCOD,'000')) || '0000'|| TRIM(TO_CHAR(CLIENT.CLIGRUSUB,'0000')) 
            LEFT OUTER JOIN PRDCOMCATMEDLEC.COAGUA ON (PREDIO.PREREGION = COAGUA.PREREGION) AND (PREDIO.PREZONA = COAGUA.PREZONA) AND (PREDIO.PRESECTOR = COAGUA.PRESECTOR) AND (PREDIO.PREMZN = COAGUA.PREMZN) AND (PREDIO.PRELOTE = COAGUA.PRELOTE) 
            LEFT OUTER JOIN PRDCOMCATMEDLEC.MEDIDO ON (MEDIDO.MEDCODIGO = COAGUA.MEDCODIGO) 
            LEFT OUTER JOIN PRDCOMCATMEDLEC.TARIFA ON (TARIFA.CODCATTAR = GR.CODCATTAR) 
            WHERE ROWNUM = 1        
            ORDER BY PREDIO.PREREGION, PREDIO.PREZONA, PREDIO.PRESECTOR, PREDIO.PREMZN, PREDIO.PRELOTE, CLIENT.CLICODID, CLIENT.CLICODIGO",array($grupo, $sub_grupo));
            return $query->row_array();
        }

        public function get_solicitud_reclamo($suministro){
            $query = $this->oracle->query("SELECT EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, RECID, UUCOD, RECDESC, RECFCH, RECHRA, 
                                           CPID, TIPPROBID, SCATPROBID, PROBID, CDPCODDPR, CPVCODDPR, CDSCODDPR   FROM PRDDBFCOMERCIAL.RECNORELFACT 
                                           WHERE  UUCOD =? AND  SRECCOD ='1'",array($suministro));
            return $query->result_array();
        }

        public function get_ultimo_reclamo($serie){
            //var_dump($_SESSION['user_data']['NSEMPCOD'].'--'.$_SESSION['user_data']['NSOFICOD'].'--'.$_SESSION['user_data']['NSARECOD'].'--'.$serie);
            $this->oracle->select("EMPCOD, OFICOD, ARECOD, CTDCOD, DOCCOD, SERNRO, MAX(RECID) AS ULTNRORECLAMO");
            $this->oracle->from("PRDGESTIONCOMERCIAL.ORECLAMO");
            $this->oracle->where("EMPCOD", $_SESSION['user_data']['NSEMPCOD']);
            $this->oracle->where("OFICOD", $_SESSION['user_data']['NSOFICOD']);
            $this->oracle->where("ARECOD", $_SESSION['user_data']['NSARECOD']);
            $this->oracle->where("CTDCOD", '4');
            $this->oracle->where("DOCCOD", '5');
            $this->oracle->where("SERNRO", $serie);
            $this->oracle->group_by(array('EMPCOD', 'OFICOD', 'ARECOD', 'CTDCOD', 'DOCCOD', 'SERNRO'));
            return $this->oracle->get()->row_array();
        }

        public function get_descri_reclamo($resultado){
            
            $query = $this->oracle->query("SELECT MP3.CPID, MP.CPDESC, MP3.TIPPROBID, MP1.TIPPROBDESC, MP3.SCATPROBID, MP2.SCATPROBDESC, MP3.PROBID, MP3.PROBDESC, 
            MP3.PROBREQCON, MP3.PROBREQINS, MP3.PRBPZOREC, MP3.PRBPZOINS, MP3.PRBPZOCON, MP3.PRBPZORESS, MP3.PRBPZONOTS, MP3.PRBPZORCS, MP3.PRBPZORCNP, 
            MP3.PRBELVRCS, MP3.PRBRESRCO, MP3.PRBPZORSRC, MP3.PRBPZONORR, MP3.PRBPZOSAP, MP3.PRBPZOSAPE, MP3.PRBRESSGIN, MP3.PRBPZONOSG, MP3.PRBPZOPROT, 
            MP3.PRBPZOSAN, MP3.PRBPZOQJA, MP3.PRBPZOQJAD, MP3.PRBPZOQJAE, MP3.PRBPZOQJAR, MP3.TALCCOD, TAP.TALDES, MP3.SPROCOD, SPR.SPRODES,
            MP3.SOLATDIAS, MP3.SOLATHRS
            FROM PRDGESTIONCOMERCIAL.MPROBLEMAS3 MP3
                INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS2  MP2 ON MP2.CPID = MP3.CPID AND MP2.TIPPROBID = MP3.TIPPROBID AND MP2.SCATPROBID = MP3.SCATPROBID 
                INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS1  MP1 ON MP1.CPID = MP3.CPID AND MP1.TIPPROBID = MP3.TIPPROBID 
                INNER JOIN PRDGESTIONCOMERCIAL.MPROBLEMAS   MP  ON MP.CPID  = MP3.CPID
                LEFT  JOIN PRDGESTIONCOMERCIAL.TALCPRB      TAP ON TAP.TALCOD = MP3.TALCCOD
                LEFT  JOIN PRDGESTIONCOMERCIAL.SPROBLEMAS   SPR ON SPR.SPROCOD = MP3.SPROCOD
            WHERE MP3.CPID  = ? AND MP3.TIPPROBID = ? AND MP3.SCATPROBID = ? AND MP3.PROBID = ? 
            ORDER BY MP3.CPID, MP3.TIPPROBID, MP3.SCATPROBID, MP3.PROBID ",array($resultado['CPID'], $resultado['TIPPROBID'], $resultado['SCATPROBID'], $resultado['PROBID']));
            return $query->result_array();
        }

        public function get_fecha_maxima($hoy, $dias_reclamo){
            $query = $this->oracle->query("SELECT PRDGESTIONCOMERCIAL.Sumar_Dias_Reclamos (TO_DATE(?,'DD/MM/YYYY'),?) as fechafinnn from dual",array($hoy, $dias_reclamo));
            return $query->result_array();
        }

        public function moda_atencion(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.MMODOATE");
            return $query->result_array();
        }

        public function repre_reclamante(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.TREPRESEN");
            return $query->result_array();
        }
        
        public function repre_recla(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.TPERCON");
            return $query->result_array();
        }

        public function interval_horas(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.XPSETEOS_REC WHERE pseetq = 'INTERVCNCL' ORDER BY pseval1act");
            return $query->result_array(); 
        }

        public function tipo_persona(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.TPERSONA");
            return $query->result_array(); 
        }

        public function estado_persona(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.SSOLICITANTE");
            return $query->result_array();
        }

        public function sit_relcamo(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.SSITREC");
            return $query->result_array();
        }

        public function tipo_documento(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.TDOCIDE");
            return $query->result_array();
        }

        public function ofi_Areas(){
            $query = $this->oracle->query("SELECT CRUCE.EMPCOD, EMPRESA.EMPDES, CRUCE.OFICOD, 
            OFICINA.OFIDES, CRUCE.ARECOD, AREAS.AREDES  
            FROM PRDGESTIONCOMERCIAL.CEMPRES2 CRUCE, 
                   PRDGESTIONCOMERCIAL.MAREAS AREAS,
                   PRDGESTIONCOMERCIAL.CEMPRES1 OFICINA,
                   PRDGESTIONCOMERCIAL.CEMPRES  EMPRESA
                   WHERE 
                   CRUCE.EMPCOD = EMPRESA.EMPCOD AND 
                   CRUCE.OFICOD = OFICINA.OFICOD AND 
                   CRUCE.ARECOD = AREAS.ARECOD");
            return $query->result_array();
        }

        public function set_deriva_reclamo($Parametros, $empresa, $area, $oficina, $ctdcod,  $doccod, $serie, $recid  ){
            $query = $this->oracle->query("SELECT DERIVA.EMPCOD, DERIVA.OFICOD, DERIVA.ARECOD, DERIVA.CTDCOD, DERIVA.DOCCOD, DERIVA.SERNRO 
            FROM PRDGESTIONCOMERCIAL.ODERIVACION DERIVA 
            WHERE
                 DERIVA.EMPCOD = ".$empresa." AND 
                 DERIVA.OFICOD = ".$oficina." AND 
                 DERIVA.ARECOD = ".$area." AND 
                 DERIVA.CTDCOD = ".$ctdcod." AND
                 DERIVA.DOCCOD = ".$doccod." AND 
                 DERIVA.SERNRO = ".$serie." AND 
                 DERIVA.RECID  = ".$recid);
            $cantidad =  $query->result_array();
            if(count($cantidad)> 0){  // cantidad mayor a la derivacion 
                $correlativo = count($cantidad);
                $Parametros['ARDCOD'] = $correlativo+1; 
                $this->oracle->insert('PRDGESTIONCOMERCIAL.ODERIVACION', $Parametros);
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                } else {
                    $this->oracle->trans_commit();
                    return true;
                }
            }else{  // si es que recien se ingresa
                $Parametros['ARDCOD'] = 1; 
                $this->oracle->insert('PRDGESTIONCOMERCIAL.ODERIVACION', $Parametros);
                if ($this->oracle->trans_status() === FALSE){
                    $this->oracle->trans_rollback();
                    return false;
                } else {
                    $this->oracle->trans_commit();
                    return true;
                }
            }
        }

        public function set_deriva__edita_reclamo($Parametros, $empresa, $area, $oficina, $ctdcod,  $doccod, $serie, $recid, $id_reclamo){
            $this->oracle->where('EMPCOD', $empresa);
            $this->oracle->where('ARECOD', $area);
            $this->oracle->where('OFICOD', $oficina);
            $this->oracle->where('CTDCOD', $ctdcod);
            $this->oracle->where('DOCCOD', $doccod);
            $this->oracle->where('SERNRO', $serie);
            $this->oracle->where('RECID', $recid);
            $this->oracle->where('ARDCOD', $id_reclamo);
            $this->oracle->update('PRDGESTIONCOMERCIAL.ODERIVACION', $Parametros);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            } else{
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function get_rango_reclamos($min, $hoy){
            $query = $this->oracle->query("SELECT RECLAMO.SERNRO, RECLAMO.EMPCOD, RECLAMO.OFICOD, RECLAMO.ARECOD, RECLAMO.CTDCOD, RECLAMO.DOCCOD, 
            RECLAMO.RECID, RECLAMO.UUCOD, RECLAMO.RECDESC, RECLAMO.RECFCH, RECLAMO.SERNRO, RECLAMO.RECID,
            RECLAMANTE.PRENOM, RECLAMANTE.PREAPEPAT, RECLAMANTE.PREAPEMAT, PROBLEMA.CPDESC, INSTANCIA.TINSDES,
            ESTADO.SRECDES, AREAS.AREDES, OFICINA.OFIDES  
            FROM PRDGESTIONCOMERCIAL.ORECLAMO RECLAMO, 
                 PRDGESTIONCOMERCIAL.MRECLAMANTE RECLAMANTE,
                 PRDGESTIONCOMERCIAL.MPROBLEMAS PROBLEMA,
                 PRDGESTIONCOMERCIAL.TINSTANCIA INSTANCIA,
                 PRDGESTIONCOMERCIAL.SRECLAMO ESTADO,
                 PRDGESTIONCOMERCIAL.MAREAS AREAS, 
                 PRDGESTIONCOMERCIAL.CEMPRES1 OFICINA
           WHERE RECLAMO.PRECOD = RECLAMANTE.PRECOD AND PROBLEMA.CPID= RECLAMO.CPID AND RECLAMO.ARECOD = AREAS.ARECOD   AND RECLAMO.TINSCOD = INSTANCIA.TINSCOD  AND ESTADO.SRECCOD = RECLAMO.SRECCOD AND OFICINA.OFICOD = RECLAMO.OFICOD  AND    TRUNC (RECFCH) BETWEEN TO_DATE('".$min."', 'DD-MM-YYYY') AND TO_DATE('".$hoy."', 'DD-MM-YYYY') ");
            return $query->result_array();
        }


        public function get_derivados_reclamo($empresa, $oficina, $area, $ctdcod, $doccod, $serie, $reclamo ){
            $query = $this->oracle->query("SELECT DERIVA.EMPCOD, DERIVA.OFICOD, DERIVA.ARECOD, DERIVA.CTDCOD, DERIVA.DOCCOD, DERIVA.SERNRO, 
            DERIVA.RECID, DERIVA.ARDCOD, DERIVA.DRVFSOL, DERIVA.DRVSOL, DERIVA.DRVFPZO, DERIVA.DRVRES,
            DERIVA.USRCODDE, DERIVA.SARDCOD, DERIVA.ARECODDE, DERIVA.OFICODDE, DERIVA.EMPCODDE, AREAS.AREDES DESCRIAREA ,
            OFICINA.OFIDES DESCRIOFICINA , EMPRESA.EMPDES DESCRIEMPRESA, ESTADODERIVA.SARDDES DESCRIESTADO
             FROM PRDGESTIONCOMERCIAL.ODERIVACION DERIVA , 
                  PRDGESTIONCOMERCIAL.MAREAS AREAS,
                  PRDGESTIONCOMERCIAL.CEMPRES1 OFICINA,
                  PRDGESTIONCOMERCIAL.CEMPRES EMPRESA,
                  PRDGESTIONCOMERCIAL.SDERIVACION ESTADODERIVA
             WHERE
                  DERIVA.SARDCOD ! = 3 AND 
                  DERIVA.ARECODDE = AREAS.ARECOD AND
                  DERIVA.OFICODDE = OFICINA.OFICOD AND 
                  DERIVA.EMPCODDE = EMPRESA.EMPCOD AND
                  DERIVA.SARDCOD = ESTADODERIVA.SARDCOD AND 
                  DERIVA.EMPCOD = ".$empresa." AND 
                  DERIVA.OFICOD = ".$oficina." AND 
                  DERIVA.ARECOD = ".$area." AND 
                  DERIVA.CTDCOD = ".$ctdcod." AND
                  DERIVA.DOCCOD = ".$doccod." AND 
                  DERIVA.SERNRO = ".$serie." AND 
                  DERIVA.RECID  = ".$reclamo." ORDER BY ARDCOD  ");
            return $query->result_array();
        }

        public function resultado_reclamante(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.TRESUACU");
            return $query->result_array();
        }

        public function get_codigo_reclamo(){
            $query = $this->oracle->query("SELECT  PRDGESTIONCOMERCIAL.RECLAMOS_PASS_WEB as codigo_rec_web from dual");
            return $query->result_array();
        }

        public function operadores_telefonicos(){
            $query = $this->oracle->query("SELECT * FROM PRDGESTIONCOMERCIAL.TOPETELF");
            return $query->result_array();
        }

        public function get_estado_reclamo(){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.SRECLAMO");
            return $this->oracle->get()->result_array();
        }

        public function get_etapa_reclamo(){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.TETAPREC");
            return $this->oracle->get()->result_array();
        }

        public function get_instancia_reclamo(){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.TINSTANCIA");
            return $this->oracle->get()->result_array();
        }


        public function get_reclamo_concilia($suministro){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.ORECLAMO");
            $this->oracle->where('UUCOD', $suministro);
            $this->oracle->where('SSITCOD', '1');
            return $this->oracle->get()->result_array();
        }

        public function set_conciliacion($empresa, $oficina, $area, $ctdcod, $doccod, $serie , $reclamo , $parametros){
            
            $this->oracle->trans_begin();
            $this->oracle->where('EMPCOD', $empresa);
            $this->oracle->where('OFICOD', $oficina);
            $this->oracle->where('ARECOD', $area);
            $this->oracle->where('CTDCOD', $ctdcod);
            $this->oracle->where('DOCCOD', $doccod);
            $this->oracle->where('SERNRO', $serie);
            $this->oracle->where('RECID', $reclamo);
            $this->oracle->update('PRDGESTIONCOMERCIAL.OCONCILIA', $parametros);
            if ($this->oracle->trans_status() === FALSE){
                $this->oracle->trans_rollback();
                return false;
            } else {
                $this->oracle->trans_commit();
                return true;
            }
        }

        public function get_concilia_reclamo($reclamo){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.OCONCILIA");
            $this->oracle->where('EMPCOD', $reclamo['EMPCOD']);
            $this->oracle->where('OFICOD', $reclamo['OFICOD']);
            $this->oracle->where('ARECOD', $reclamo['ARECOD']);
            $this->oracle->where('CTDCOD', $reclamo['CTDCOD']);
            $this->oracle->where('DOCCOD', $reclamo['DOCCOD']);
            $this->oracle->where('SERNRO', $reclamo['SERNRO']);
            $this->oracle->where('RECID', $reclamo['RECID']);
            $this->oracle->where('SCNCOD', '1');
            return $this->oracle->get()->row_array();
        }

        public function get_impre_concilia($reclamo){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.OCONCILIA");
            $this->oracle->where('EMPCOD', $reclamo[0]);
            $this->oracle->where('OFICOD', $reclamo[1]);
            $this->oracle->where('ARECOD', $reclamo[2]);
            $this->oracle->where('CTDCOD', $reclamo[3]);
            $this->oracle->where('DOCCOD', $reclamo[4]);
            $this->oracle->where('SERNRO', $reclamo[5]);
            $this->oracle->where('RECID', $reclamo[6]);
            $this->oracle->where('SCNCOD', '1');
            return $this->oracle->get()->row_array();
        }

        public function get_situacion_cierre(){
            $this->oracle->select("*");
            $this->oracle->from("PRDGESTIONCOMERCIAL.TMOCIERE");
            return $this->oracle->get()->result_array();
        }

        public function busqueda_direccion_ambos($grupo_poblacional, $via){
            $query = $this->oracle->query("SELECT CVP.CDPCOD, CU0.CDPDES, CVP.CPVCOD, CU1.CPVDES, CVP.CDSCOD, CU2.CDSDES, CVP.CGPCOD, CU3.CGPDES,  CVP.MVICOD, MVI.MVIDES
            FROM PRDGESTIONCOMERCIAL.CVIGRPO CVP
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO3 CU3 ON CU3.CDPCOD = CVP.CDPCOD AND CU3.CPVCOD = CVP.CPVCOD AND CU3.CDSCOD = CVP.CDSCOD AND CU3.CGPCOD = CVP.CGPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO2 CU2 ON CU2.CDPCOD = CVP.CDPCOD AND CU2.CPVCOD = CVP.CPVCOD AND CU2.CDSCOD = CVP.CDSCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO1 CU1 ON CU1.CDPCOD = CVP.CDPCOD AND CU1.CPVCOD = CVP.CPVCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO  CU0 ON CU0.CDPCOD = CVP.CDPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.MVIAS    MVI ON MVI.MVICOD = CVP.MVICOD
            WHERE  UPPER(CU3.CGPDES) LIKE '%".$grupo_poblacional."%' AND UPPER(MVI.MVIDES) LIKE '%".$via."%'
            ORDER BY CVP.CGPCOD, CU3.CGPDES, MVI.MVIDES ");
            return $query->result_array();
        }

        public function busqueda_direccion_grupo($grupo_poblacional){
            $query = $this->oracle->query("SELECT CVP.CDPCOD, CU0.CDPDES, CVP.CPVCOD, CU1.CPVDES, CVP.CDSCOD, CU2.CDSDES, CVP.CGPCOD, CU3.CGPDES,  CVP.MVICOD, MVI.MVIDES
            FROM PRDGESTIONCOMERCIAL.CVIGRPO CVP
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO3 CU3 ON CU3.CDPCOD = CVP.CDPCOD AND CU3.CPVCOD = CVP.CPVCOD AND CU3.CDSCOD = CVP.CDSCOD AND CU3.CGPCOD = CVP.CGPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO2 CU2 ON CU2.CDPCOD = CVP.CDPCOD AND CU2.CPVCOD = CVP.CPVCOD AND CU2.CDSCOD = CVP.CDSCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO1 CU1 ON CU1.CDPCOD = CVP.CDPCOD AND CU1.CPVCOD = CVP.CPVCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO  CU0 ON CU0.CDPCOD = CVP.CDPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.MVIAS    MVI ON MVI.MVICOD = CVP.MVICOD
            WHERE UPPER(CU3.CGPDES) LIKE '%".$grupo_poblacional."%'
            ORDER BY CVP.CGPCOD, CU3.CGPDES, MVI.MVIDES");
            return $query->result_array();
        }

        public function busqueda_direccion_via($via){
            $query = $this->oracle->query("SELECT CVP.CDPCOD, CU0.CDPDES, CVP.CPVCOD, CU1.CPVDES, CVP.CDSCOD, CU2.CDSDES, CVP.CGPCOD, CU3.CGPDES,  CVP.MVICOD, MVI.MVIDES
            FROM PRDGESTIONCOMERCIAL.CVIGRPO CVP
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO3 CU3 ON CU3.CDPCOD = CVP.CDPCOD AND CU3.CPVCOD = CVP.CPVCOD AND CU3.CDSCOD = CVP.CDSCOD AND CU3.CGPCOD = CVP.CGPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO2 CU2 ON CU2.CDPCOD = CVP.CDPCOD AND CU2.CPVCOD = CVP.CPVCOD AND CU2.CDSCOD = CVP.CDSCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO1 CU1 ON CU1.CDPCOD = CVP.CDPCOD AND CU1.CPVCOD = CVP.CPVCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.CUBIGEO  CU0 ON CU0.CDPCOD = CVP.CDPCOD 
                INNER JOIN PRDGESTIONCOMERCIAL.MVIAS    MVI ON MVI.MVICOD = CVP.MVICOD
            WHERE UPPER(MVI.MVIDES) LIKE '%".$via."%'
            ORDER BY CVP.CGPCOD, CU3.CGPDES, MVI.MVIDES");
            return $query->result_array();
        }

    }