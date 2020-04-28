<?php

class Nota_Credito_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
        $this->oracle->save_queries = false;
    }

    public function get_permiso($usuario,$hijo){
      $query = $this->oracle->query("SELECT  DISTINCT ACT.*,GRP.MENUGENPDR FROM PRDDBFCOMERCIAL.USER_ROL NR
                                      JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                      WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND ACT.ACTIVIHJO = ?",array($usuario,$hijo));
      return $query->row_array();
    }

    public function get_notas_pendientes(){
      $query = $this->oracle->query("SELECT FAC.FSCCLINOMB,FAC.FSCCLIRUC,FSCNRODOC, BFN.* FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA FAC
                                      ON BFN.SFACTURA_FSCSERNRO = FAC.FSCSERNRO
                                      AND BFN.SFACTURA_FSCNRO = FAC.FSCNRO AND BFN.BFSFACTIPC =  FAC.FSCTIPO
                                      WHERE BFNCATIPO = 'A' AND BFNCAEST = 'I' AND BFNCAESTSUN = 3 ORDER BY BFN.BFNCAFECHEMI DESC, BFN.BFNCAHRAEMI DESC");
      return $query->result_array();
    }

    public function get_one_nota($letra,$serie,$numero){
      $query = $this->oracle->query("SELECT FAC.FSCCLINOMB,FAC.FSCCLIRUC,FAC.FSDIREC ,FSCNRODOC, BFN.* FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA FAC
                                      ON BFN.SFACTURA_FSCSERNRO = FAC.FSCSERNRO
                                      AND BFN.SFACTURA_FSCNRO = FAC.FSCNRO AND BFN.BFSFACTIPC =  FAC.FSCTIPO
                                      WHERE BFNCATIPO = 'A' AND BFNCATLET = ? AND BFNCASERNRO = ? AND BFNCANRO = ? AND BFNCAESTSUN = 3 ",array($letra,$serie,$numero));
      return $query->row_array();
    }

    public function get_detalle_one_nota($letra,$serie,$numero){
      $query = $this->oracle->query("SELECT FB1.*,CON.FACCONDES FROM PRDDBFCOMERCIAL.BFNCA1  FB1 INNER JOIN PRDDBFCOMERCIAL.CONCEP CON ON FB1.CONCEP_FACCONCOD = CON.FACCONCOD
                                    WHERE BFNCA_NCATIPO = 'A' AND BFNCA_BFNNCALET = ? AND BFNCA_BFNCASERNRO = ? AND BFNCA_BFNCANRO = ?",array($letra,$serie,$numero));
      return $query->result_array();
    }

    public function actualizar_bfnca($letra,$serie,$numero){
      $this->oracle->trans_begin();
      $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.BFNCA SET BFNCAEST = 'P',BFNCAFECHPAG = ? , BFNCAHRAPAG = ?, BFNCAUSRPAG = ? WHERE BFNCATIPO = 'A'  AND BFNCATLET = ?
                                    AND BFNCASERNRO = ? AND BFNCANRO = ? AND BFNCAESTSUN = 3",array(date('d/m/Y'),date('H:i:s'), $_SESSION['user_id'] , $letra,$serie,$numero));
      if(!$query){
          $this->oracle->trans_rollback();
          return false;
      }
      $query3 = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCATIPO = 'A' AND BFNCATLET = ? AND BFNCASERNRO = ? AND BFNCANRO = ? AND BFNCAESTSUN = 3",array($letra,$serie,$numero));
      $respuesta = $query3->row_array();
      $tipo_doc = "";
      $tipo_doc1 = "";
      if($letra == 'F'){
        $query2 = $this->oracle->query("SELECT MDCCOD FROM PRDRECAUDACIONORA12C.MDOCCOB WHERE MDCABR = 'N/C FAC'");
        $query5 = $this->oracle->query("SELECT MDCCOD FROM PRDRECAUDACIONORA12C.MDOCCOB WHERE MDCABR = 'FACTURA'");
        $tipo_doc1 = $query5->row_array()['MDCCOD'];
        $tipo_doc = $query2->row_array()['MDCCOD'];
      } else {
        $query2 = $this->oracle->query("SELECT MDCCOD FROM PRDRECAUDACIONORA12C.MDOCCOB WHERE MDCABR = 'N/C BOL'");
        $query5 = $this->oracle->query("SELECT MDCCOD FROM PRDRECAUDACIONORA12C.MDOCCOB WHERE MDCABR = 'BOLETA'");
        $tipo_doc = $query2->row_array()['MDCCOD'];
        $tipo_doc1 = $query5->row_array()['MDCCOD'];
      }
      $dni = "";
      if($respuesta['BFSFACTIPDOC'] == 1){
        $dni = $respuesta['BFSFACNRODOC'];
      }
      $query8 = $this->oracle->query("SELECT FSCCLINOMB FROM PRDDBFCOMERCIAL.SFACTURA WHERE FSCSERNRO = ?  AND FSCNRO = ? AND FSCTIPO = ?",array($respuesta['SFACTURA_FSCSERNRO'],$respuesta['SFACTURA_FSCNRO'],$respuesta['BFSFACTIPC']));
      $nombre_cliente = $query8->row_array()['FSCCLINOMB'];
      $query1 = $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.MDOCGLB (ESECOD,MDCCOD,MDGSERDOC,MDGNRODOC,MDGCODACC1,MDGCODACC2,MDGFCHEMIDOC,MDGFCHVTODOC,MDGFCHVTOCOB,MDGFCHREG,MDGHRAREG,
                                      MDGIMPTOT,SDGCOD,MDGFCHLSTUPD,MDGHRALSTUPD,MDGDNINUM,MDGDNIFREG,MDGDNIHREG,MDGCODACC3)
                                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                      array(1,$tipo_doc,$serie,$numero,$respuesta['BFSFACNRODOC'],0,date('d/m/Y'),date('d/m/Y'),date('d/m/Y'),date('d/m/Y'),date('H:i:s'),
                                      $respuesta['BFNCATOTDIF'],2,date('d/m/Y'),date('H:i:s'),$dni,date('d/m/Y'),date('H:i:s'),$nombre_cliente));
      if(!$query1){
          $this->oracle->trans_rollback();
          return false;
      }
      $query4 = $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.MDOCRLC (STAESECOD,STAMDCCOD,STAMDGSERDOC,STAMDGNRODOC,STBESECOD,STBMDCCOD,STBMDGSERDOC,STBMDGNRODOC)
                                      VALUES (?,?,?,?,?,?,?,?)",
                                      array(1,$tipo_doc1,$respuesta['SFACTURA_FSCSERNRO'],$respuesta['SFACTURA_FSCNRO'],1,$tipo_doc,$serie,$numero));
      if(!$query4){
          $this->oracle->trans_rollback();
          return false;
      }
      $query9 = $this->oracle->query("SELECT MUSUARIO.USRCOD, COPECAJ.ECOCOD, PTCCOD, USRLOG, USRNOM, SUSCOD, TUSCOD,
                                      EMPCOD, OFICOD, ARECOD, CJACOD, STECOCOD, ECODES, SECCOD
                                      FROM PRDRECAUDACIONORA12C.COPECAJ
                                      INNER JOIN PRDRECAUDACIONORA12C.MEMPCOB ON (COPECAJ.ECOCOD = MEMPCOB.ECOCOD)
                                      INNER JOIN PRDRECAUDACIONORA12C.MUSUARIO ON (MUSUARIO.USRCOD = COPECAJ.USRCOD)
                                      WHERE SECCOD = 1
                                      AND TRIM(USRLOG) = ?
                                      ORDER BY COPECAJ.ECOCOD",array($_SESSION['login']));
      $cajera = $query9->row_array();
      $query6 = $this->oracle->query("INSERT INTO PRDRECAUDACIONORA12C.OPAGOS (ESECOD,MDCCOD,MDGSERDOC,MDGNRODOC,OPGNROOPE,OPGFCHREG,OPGHRAREG,OPGFCHPAG,OPGHRAPAG,OPGFCHPEF,OPGHRAPEF,OPGIMPPAG,
                                      OPCCOD,ECOCOD,PTCCOD,CJACOD,STECOCOD,VOEITEM,USRCOD,OPCJITM,TPGCOD,SPGCOD,OPGIMPCAR,OPGIMPINT,OPGIMPENT,
                                      OPGEMPVUE,OPGREFBO,OPGPAGINTSW,OPGPAGCARSW,OPGUSRAUX)
                                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                      array(1,$tipo_doc,$serie,$numero,1,date('d/m/Y'),date('H:i:s'),date('d/m/Y'),date('H:i:s'),date('d/m/Y'),date('H:i:s'),$respuesta['BFNCATOTDIF'],
                                      0,$cajera['ECOCOD'],$cajera['PTCCOD'],$cajera['CJACOD'],$cajera['STECOCOD'],1,$cajera['USRCOD'],0,1,1,0,0,0,
                                      0,0,0,0,0));
      if(!$query6){
          $this->oracle->trans_rollback();
          return false;
      }
      $this->oracle->trans_commit();
      return true;
    }

    public function get_notas_pagadas(){
      $query = $this->oracle->query("SELECT FAC.FSCCLINOMB,FAC.FSCCLIRUC,FSCNRODOC, BFN.* FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA FAC
                                      ON BFN.SFACTURA_FSCSERNRO = FAC.FSCSERNRO
                                      AND BFN.SFACTURA_FSCNRO = FAC.FSCNRO AND BFN.BFSFACTIPC =  FAC.FSCTIPO
                                      WHERE BFNCATIPO = 'A' AND BFNCAEST = 'P' AND BFNCAUSRPAG = ? AND BFNCAFECHPAG = ?  ORDER BY BFN.BFNCAFECHEMI DESC, BFN.BFNCAHRAEMI DESC",array($_SESSION['user_id'],date('d/m/Y')));
      return $query->result_array();
    }

    public function get_nota_pagada($letra,$serie,$numero){
      $query = $this->oracle->query("SELECT FAC.FSCCLINOMB,FAC.FSCCLIRUC,FSCNRODOC, BFN.* FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA FAC
                                      ON BFN.SFACTURA_FSCSERNRO = FAC.FSCSERNRO
                                      AND BFN.SFACTURA_FSCNRO = FAC.FSCNRO AND BFN.BFSFACTIPC =  FAC.FSCTIPO
                                      WHERE BFNCATIPO = 'A' AND BFNCAEST = 'P' AND BFNCAUSRPAG = ? AND BFN.BFNCATLET = ?  AND BFN.BFNCASERNRO = ? AND BFN.BFNCANRO = ?  ORDER BY BFN.BFNCAFECHEMI DESC, BFN.BFNCAHRAEMI DESC",array($_SESSION['user_id'],$letra,$serie,$numero));
      return $query->result_array();
    }

    public function get_nota_pagada_nombre($nombre){
      $query = $this->oracle->query("SELECT FAC.FSCCLINOMB,FAC.FSCCLIRUC,FSCNRODOC, BFN.* FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA FAC
                                      ON BFN.SFACTURA_FSCSERNRO = FAC.FSCSERNRO
                                      AND BFN.SFACTURA_FSCNRO = FAC.FSCNRO AND BFN.BFSFACTIPC =  FAC.FSCTIPO
                                      WHERE BFNCATIPO = 'A' AND BFNCAEST = 'P' AND BFNCAUSRPAG = ? AND FAC.FSCCLINOMB LIKE '%".$nombre."%' ORDER BY BFN.BFNCAFECHEMI DESC, BFN.BFNCAHRAEMI DESC",array($_SESSION['user_id']));
    return $query->result_array();
    }

    public function get_nota_pagada_fechas($fecha1,$fecha2){
      $query = $this->oracle->query("SELECT FAC.FSCCLINOMB,FAC.FSCCLIRUC,FSCNRODOC, BFN.* FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA FAC
                                      ON BFN.SFACTURA_FSCSERNRO = FAC.FSCSERNRO
                                      AND BFN.SFACTURA_FSCNRO = FAC.FSCNRO AND BFN.BFSFACTIPC =  FAC.FSCTIPO
                                      WHERE BFNCATIPO = 'A' AND BFNCAEST = 'P' AND BFNCAUSRPAG = ? AND BFN.BFNCAFECHPAG BETWEEN ?  AND ? ORDER BY BFN.BFNCAFECHEMI DESC, BFN.BFNCAHRAEMI DESC",array($_SESSION['user_id'],$fecha1,$fecha2));
    return $query->result_array();
    }

    public function get_nota_pagada_dni($tipo,$dni){
      $query = $this->oracle->query("SELECT FAC.FSCCLINOMB,FAC.FSCCLIRUC,FSCNRODOC, BFN.* FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA FAC
                                      ON BFN.SFACTURA_FSCSERNRO = FAC.FSCSERNRO
                                      AND BFN.SFACTURA_FSCNRO = FAC.FSCNRO AND BFN.BFSFACTIPC =  FAC.FSCTIPO
                                      WHERE BFNCATIPO = 'A' AND BFNCAEST = 'P' AND BFNCAUSRPAG = ? AND BFN.BFSFACTIPDOC = ? AND BFN.BFSFACNRODOC = ? ORDER BY BFN.BFNCAFECHEMI DESC, BFN.BFNCAHRAEMI DESC",array($_SESSION['user_id'],$tipo,$dni));
    return $query->result_array();
    }

}
