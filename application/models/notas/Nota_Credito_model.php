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

    public function get_generacion_pendiente($serie,$numero,$tipo){
	  $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNGX_LETS WHERE AUT_TIPC = ? AND AUT_NCASER = ? AND AUT_NCANRO = ? AND OFICOD = ? AND OFIAGECOD = ? AND AUT_EST = 2",
	  									array($tipo,$serie,$numero,$_SESSION['OFICOD'],$_SESSION['OFIAGECOD']));
      return $query->row_array();
    }
    
    public function get_rol($id){
      $query = $this->oracle->query("SELECT ROL.ID_ROL FROM PRDDBFCOMERCIAL.ROLES ROL INNER JOIN PRDDBFCOMERCIAL.USER_ROL USR ON ROL.ID_ROL = USR.ID_ROL WHERE USR.NCODIGO = ?",array($id));
      return $query->row_array()['ID_ROL'];
    }

    public function get_notas_credito_boleta_facturas($serie){
      $query = $this->oracle->query("SELECT BFNCATLET, BFNCASERNRO, BFNCANRO, SFACTURA_FSCSERNRO, SFACTURA_FSCNRO, BFNCASUNSERNRO, BFNCASUNFACNRO, BFNCAFECHEMI, BFNCAHRAEMI, BFNCATOTDIF, BFNCAESTSUN, BFNCATIPO, BFSFACDIRARCHPDF
	  								 FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCATIPO = 'A' AND BFNCASERNRO = ?  ORDER BY BFNCAFECHEMI DESC, BFNCAHRAEMI DESC",array($serie));
      return $query->result_array();
    }

    public function get_notas_credito_boleta_facturas1($serie){
      $query = $this->oracle->query("SELECT BFNCATLET, BFNCASERNRO, BFNCANRO, SFACTURA_FSCSERNRO, SFACTURA_FSCNRO, BFNCASUNSERNRO, BFNCASUNFACNRO, BFNCAFECHEMI, BFNCAHRAEMI, BFNCATOTDIF, BFNCAESTSUN, BFNCATIPO, BFSFACDIRARCHPDF
	  								 FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCATIPO = 'A' AND BFNCAURSCOD = ?  ORDER BY BFNCAFECHEMI DESC, BFNCAHRAEMI DESC",$serie);
      return $query->result_array();
    }
    //1
    public function get_serie_user1($id){
      $query = $this->oracle->query("SELECT AGE.SERNRO FROM PRDDBFCOMERCIAL.AGENCI AGE INNER JOIN PRDDBFCOMERCIAL.NUSERS USR ON USR.OFICOD = AGE.OFICIN_OFICOD AND USR.OFIAGECOD = AGE.OFIAGECOD WHERE NCODIGO = ?",array($id));
      return $query->row_array();
    }
    //1
    public function notas_x_autorizacion($serie,$numero,$tipo){
      $query = $this->oracle->query("SELECT SUM(BFNCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.BFNCA WHERE SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND BFSFACTIPC = ? AND BFNCAEST <> ?",array($serie,$numero,$tipo,'A'));
      return $query->row_array()['TOTAL'];
    }
    //1
    public function get_detalle_nc1($letra,$serie,$numero){
      $query = $this->oracle->query("SELECT CONCEP_FACCONCOD,NCAPREDIF FROM PRDDBFCOMERCIAL.BFNCA1 WHERE BFNCA_NCATIPO = 'A' AND BFNCA_BFNNCALET = ? AND BFNCA_BFNCASERNRO = ? AND BFNCA_BFNCANRO = ?",array($letra,$serie,$numero));
      return $query->result_array();
    }
    //1
    public function buscar_nc($tipo,$serie,$numero,$documento){
      if($tipo == 1){
        $query = $this->oracle->query("SELECT *  FROM PRDDBFCOMERCIAL.BFNCA WHERE SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND BFSFACTIPC = ? ",array($serie,$numero,1));
      } else if($tipo == 2){
        $query = $this->oracle->query("SELECT *  FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCASUNSERNRO = ? AND BFNCASUNFACNRO = ? AND BFSFACTIPC = ? ",array($serie,$numero,1));
      } else if($tipo == 3){
        $query = $this->oracle->query("SELECT *  FROM PRDDBFCOMERCIAL.BFNCA WHERE SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND BFSFACTIPC = ? ",array($serie,$numero,0));
      } else if($tipo == 4){
        $query = $this->oracle->query("SELECT *  FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCASUNSERNRO = ? AND BFNCASUNFACNRO = ? AND BFSFACTIPC = ? ",array($serie,$numero,0));
      } else if($tipo == 5){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCATIPO = ? AND BFNCATLET = ? AND BFNCASERNRO = ? AND BFNCANRO = ? ",array('A',substr($serie,0,1),substr($serie,1,strlen($serie)),$numero));
      } else if($tipo == 6){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE BFSFACTIPDOC = ? AND BFSFACNRODOC = ? ",array(1,$documento));
      } else if($tipo == 7){
        $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE BFSFACTIPDOC = ? AND BFSFACNRODOC = ? ",array(6,$documento));
      }
      return $query->result_array();
    }

    public function get_notas_autorizadas1(){
      	$query = $this->oracle->query("SELECT SFA.*,AUT_OPE FROM PRDDBFCOMERCIAL.BFNGX_LETS BFL INNER JOIN PRDDBFCOMERCIAL.SFACTURA SFA ON BFL.AUT_NCASER = SFA.FSCSERNRO
                                      AND BFL.AUT_NCANRO = SFA.FSCNRO AND BFL.AUT_TIPC = SFA.FSCTIPO WHERE AUT_OPE IN (?,0)  AND BFL.OFICOD = ? AND BFL.OFIAGECOD = ?
                                      AND AUT_EST = 2 AND AUT_VIG >= ?",
                                      array($_SESSION['user_id'],$_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],date('d/m/Y')));
      	return $query->result_array();
    }
    //1
    public function actualizar_autorizacion($serie,$numero,$tipo){
      $query1 = $this->oracle->query("SELECT AUT_OPE FROM PRDDBFCOMERCIAL.BFNGX_LETS WHERE AUT_TIPC = ? AND AUT_NCASER = ? AND AUT_NCANRO = ? AND OFICOD = ? AND OFIAGECOD = ?",array($tipo,$serie,$numero,$_SESSION['OFICOD'],$_SESSION['OFIAGECOD']));
      $operador = $query1->row_array()['AUT_OPE'];
      if($operador == 0){
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.BFNGX_LETS SET AUT_EST = 1,AUT_OPE = ? WHERE AUT_TIPC = ? AND AUT_NCASER = ? AND AUT_NCANRO = ? AND OFICOD = ? AND OFIAGECOD = ?",
                                      array($_SESSION['user_id'],$tipo,$serie,$numero,$_SESSION['OFICOD'],$_SESSION['OFIAGECOD']));
      } else {
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.BFNGX_LETS SET AUT_EST = 1 WHERE AUT_TIPC = ? AND AUT_NCASER = ? AND AUT_NCANRO = ? AND OFICOD = ? AND OFIAGECOD = ?",
                                      array($tipo,$serie,$numero,$_SESSION['OFICOD'],$_SESSION['OFIAGECOD']));
      }

      return $query;
    }
    //1
    public function get_cabecera_nc($tipo,$letra,$serie,$numero){
      $serie = $serie / 958;
      $numero = $numero / 235;
      $query = $this->oracle->query("SELECT BFN.*,SFA.FSCCLINOMB FROM PRDDBFCOMERCIAL.BFNCA BFN INNER JOIN PRDDBFCOMERCIAL.SFACTURA SFA ON BFN.SFACTURA_FSCSERNRO = SFA.FSCSERNRO AND BFN.SFACTURA_FSCNRO =  SFA.FSCNRO
        AND BFN.BFSFACTIPC = SFA.FSCTIPO WHERE BFNCATIPO = ? AND BFNCATLET = ? AND BFNCASERNRO = ? AND BFNCANRO = ?",array($tipo,$letra,$serie,$numero));
      return $query->row_array();
    }
    //1
    public function get_detalle_nc($tipo,$letra,$serie,$numero){
      $serie = $serie / 958;
      $numero = $numero / 235;
      $query = $this->oracle->query("SELECT BFN.*, CON.FACCONDES FROM PRDDBFCOMERCIAL.BFNCA1 BFN INNER JOIN PRDDBFCOMERCIAL.CONCEP CON ON BFN.CONCEP_FACCONCOD = CON.FACCONCOD
        WHERE BFNCA_NCATIPO = ? AND BFNCA_BFNNCALET = ? AND BFNCA_BFNCASERNRO = ? AND BFNCA_BFNCANRO = ?",array($tipo,$letra,$serie,$numero));
      return $query->result_array();
    }

    /*public function get_one_nota($serie,$numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.NCA WHERE NCASERNRO = ? AND NCANRO = ?",array($serie,$numero));
        return $query->row_array();
    }

    public function get_one_nota1($serie,$numero){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
        return $query->row_array();
    }*/
    //1
    public function get_facturasyboletas($serie,$numero,$tipodoc){
        if($tipodoc == "1"){
            $query = $this->oracle->query("SELECT *  FROM PRDDBFCOMERCIAL.SFACTURA WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = 1", array($serie,$numero));
        } else if($tipodoc == "0"){
            $query = $this->oracle->query("SELECT *  FROM PRDDBFCOMERCIAL.SFACTURA WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = 0", array($serie,$numero));
        }
        return $query->row_array();
    }
    //1
    public function get_facturasyboletas_detalle($serie,$numero,$numero1){
        $query = $this->oracle->query("select SF.*,CO.* from PRDDBFCOMERCIAL.SFACTUR1 SF JOIN PRDDBFCOMERCIAL.CONCEP CO ON SF.FACCONCOD = CO.FACCONCOD  where SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND SFACTURA_FSCTIPO = ? ", array($serie,$numero,$numero1));
        return $query->result_array();
    }
    //1
    public function get_igv(){
        $query = $this->oracle->query("SELECT FACTORPORCENTAJE FROM SPRING.IMPUESTOS WHERE IMPUESTO = 'IGV'");
        return $valor = $query->row_array()['FACTORPORCENTAJE'];
    }

    public function get_serie_notas($empresa,$oficina,$area,$tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT SERNRO FROM PRDDBFCOMERCIAL.CSERIES WHERE EMPCOD = ? AND OFICOD = ? AND ARECOD = ? AND CTDCOD = 1 AND DOCCOD = 3",array($empresa,$oficina,$area));
        return $query->result_array();
    }

    public function get_serie($serie,$numero,$tipo){
        $db_prueba = $this->load->database('oracle',TRUE);
        $query = $db_prueba->query("select SUNSERNRO||'-'||SUNFACNRO AS SERIE from PRDDBFCOMERCIAL.sfactura where FSCSERNRO = ? and FSCNRO = ? and FSCTIPO = ?",array($serie,$numero,$tipo));
        return $query->row_array()['SERIE'];
    }

    private function get_serie1($serie,$numero,$tipo){
        $db_prueba = $this->load->database('oracle',TRUE);
        $query = $db_prueba->query("select SUNSERNRO,SUNFACNRO,FSCFECH,FSCREGION,FSCZONA,FSCSECTOR,FSCLOCALID,FSCESTADO,FSCCLIRUC,FSCCLIUNIC,FSCTIPDOC,FSCNRODOC,FSCIGVREF,
                                    FSCDIGCOD,FSCUSRPAG,FSCSUBTOTA,FSCSUBIGV,FSCTOTAL from PRDDBFCOMERCIAL.sfactura where FSCSERNRO = ? and FSCNRO = ? and FSCTIPO = ?",array($serie,$numero,$tipo));
        return $query->row_array();
    }

    public function get_serie_user($user){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT SERNRO FROM PRDDBFCOMERCIAL.AGENCI AGE INNER JOIN
PRDDBFCOMERCIAL.NUSERS NUS ON NUS.OFICOD = AGE.OFICIN_OFICOD AND NUS.OFIAGECOD = AGE.OFIAGECOD WHERE NCODIGO = ?",array($user));
      return $query->row_array()['SERNRO'];
    }

    public function obtener_ultimo_numero($serie,$tipo_doc,$tipo_nota){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT BFNCANRO FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCATIPO = ? AND BFNCATLET = ? AND BFNCASERNRO = ? ORDER BY BFNCANRO DESC",array($tipo_nota,$tipo_doc,$serie));
      return intval($query->row_array()['BFNCANRO'])+1;
    }

    public function save_nc_fb($tipo_nc,$serie,$numero,$cabecera,$datos_usuario,$tipo1,$nota_credito,$dir_file,$dir_pdf,$firma,$motivo,$seleccionado){
      $db_prueba = $this->load->database('oracle',TRUE);
      $db_prueba->trans_begin();
      $tipo_doc = ($cabecera[13] == "01") ? 'F' : 'B';
      $respuesta = $this->get_serie1($datos_usuario->serie,$datos_usuario->numero,$tipo1);
      $serie_sunat = $respuesta['SUNSERNRO'];
      $numero_sunat = $respuesta['SUNFACNRO'];
      $fecha_emision = $respuesta['FSCFECH'];
      $diferencia = 0; $igv = 0; $total = 0;
      foreach ($nota_credito as $nc) {
        $diferencia += $nc->descuento;
        $igv += $nc->interes;
        $total += $nc->descuento + $nc->interes;
      }
      $diferencia1 = number_format((floatval($respuesta['FSCSUBTOTA']) - $diferencia),2,'.','');
      $igv1 = number_format((floatval($respuesta['FSCSUBIGV']) - $igv),2,'.','');
      $total1 =   number_format((floatval($respuesta['FSCTOTAL']) - $total),2,'.','');
      $numero_doc = "";
      if($respuesta['FSCTIPDOC'] == 6){
        $numero_doc = $respuesta['FSCCLIRUC'];
      } else {
        $numero_doc = $respuesta['FSCNRODOC'];
      }
      $query = $db_prueba->query("INSERT INTO PRDDBFCOMERCIAL.BFNCA (BFNCATIPO,BFNCATLET,BFNCASERNRO,BFNCANRO,SFACTURA_FSCSERNRO,SFACTURA_FSCNRO,BFSFACTIPC,
                                  BFNCASUNSERNRO,BFNCASUNFACNRO,BFSFACFECH,BFNCAFECHEMI,BFSFACREG,BFSFACZON,BFSFACSEC,
                                  BFSFACLOC, BFSFACEST, BFSFACCLIUNIC,BFSFACTIPDOC,BFSFACNRODOC,BFNCAIGVREF,BFSFACUSRGEN,
                                  BFSFACUSRPAG,BFNCASUBDIF,BFNCASUBOK,BFNCAIGVDIF,BFNCAIGVOK,BFNCATOTDIF,BFNCATOTOK,BFNCAEST,BFNCAESTSUN,
                                  BFSFACDIRARCHWS,BFSFACDIRARCHPDF,BFSFACSUNFIRMA,BFNCAURSCOD,BFNCAREF,BFNCAHRAEMI,BFNCATIPEMI)
                                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                  array($tipo_nc,$tipo_doc,intval($serie),$numero,intval($datos_usuario->serie),intval($datos_usuario->numero),$tipo1,
                                  $serie_sunat,$numero_sunat,$fecha_emision,date('d/m/Y'),$respuesta['FSCREGION'],$respuesta['FSCZONA'],$respuesta['FSCSECTOR'],
                                  $respuesta['FSCLOCALID'],$respuesta['FSCESTADO'],$respuesta['FSCCLIUNIC'],$respuesta['FSCTIPDOC'],$numero_doc,$respuesta['FSCIGVREF'],$respuesta['FSCDIGCOD'],
                                  $respuesta['FSCUSRPAG'],$diferencia,$diferencia1,$igv,$igv1,$total,$total1,'I',1,
                                  $dir_file,$dir_pdf,$firma,$_SESSION['user_id'],$motivo,date("H:i:s"),$seleccionado));
      if(!$query){
          $db_prueba->trans_rollback();
          return array('resultado'=>false, 'rpta'=>"NO SE PUEDO ALMACENAR LA CABEZERA");
      }
      $conceptos = $this->get_conceptos_sfactura($datos_usuario->serie,$datos_usuario->numero,$tipo1);

      $i = 1;
      foreach ($conceptos as $con) {
        $descuento = number_format((floatval($con['FSCPRECIO']) - $nota_credito[$i-1]->descuento),2,'.','');
        $query1 = $db_prueba->query("INSERT INTO PRDDBFCOMERCIAL.BFNCA1 (BFNCA_NCATIPO,BFNCA_BFNNCALET,BFNCA_BFNCASERNRO,BFNCA_BFNCANRO,NCAFACLINR,CONCEP_FACCONCOD,NCAFACPREC,NCAPREDIF,NCAPREOK)
                                    VALUES (?,?,?,?,?,?,?,?,?)",
                                    array($tipo_nc,$tipo_doc,intval($serie),$numero,$i,$con['FACCONCOD'],$con['FSCPRECIO'],$nota_credito[$i-1]->descuento,$descuento));
        if(!$query){
            $db_prueba->trans_rollback();
            return array('resultado'=>false, 'rpta'=>"NO SE PUEDO ALMACENAR EL DETALLE");
        }
        $i++;
      }
      $db_prueba->trans_commit();
      return array('resultado'=>true, 'serie'=>$serie,'numero' =>$numero,'tipo_nc' =>$tipo_nc,'tipo_doc' => $tipo_doc );
    }

    public function get_conceptos_sfactura($serie,$numero,$tipo1){
      $db_prueba = $this->load->database('oracle',TRUE);
      $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.sfactur1 where SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND SFACTURA_FSCTIPO = ?",array($serie,$numero,$tipo1));
      return $query->result_array();
    }

    public function actualizar_estado_sunat($tipo_nc,$tipo_doc,$serie,$numero,$estado){
      $db_prueba = $this->load->database('oracle',TRUE);
      //$db_prueba->trans_begin();
      $query = $db_prueba->query("UPDATE PRDDBFCOMERCIAL.BFNCA SET BFNCAESTSUN = ? WHERE BFNCATIPO = ? AND BFNCATLET = ? AND BFNCASERNRO = ? AND BFNCANRO = ?",array($estado,$tipo_nc,$tipo_doc,$serie,$numero));
      /*if(!$query){
          $db_prueba->trans_rollback();
          return array('resultado'=>false, 'rpta'=>"NO SE PUEDO ALMACENAR LA CABEZERA");
      }*/
      return array('resultado'=>true,'rpta' => "SE ACTUALIZO LA BASE DE DATOS");
    }

    public function actualizar_estado_sunat1($tipo_nc,$tipo_doc,$serie,$numero,$estado,$mensaje){
      $db_prueba = $this->load->database('oracle',TRUE);
      //$db_prueba->trans_begin();
      $query = $db_prueba->query("UPDATE PRDDBFCOMERCIAL.BFNCA SET BFNCAESTSUN = ?,BFRPTASUN = ? WHERE BFNCATIPO = ? AND BFNCATLET = ? AND BFNCASERNRO = ? AND BFNCANRO = ?",array($estado,$mensaje,$tipo_nc,$tipo_doc,$serie,$numero));
      /*if(!$query){
          $db_prueba->trans_rollback();
          return array('resultado'=>false, 'rpta'=>"NO SE PUEDO ALMACENAR LA CABEZERA");
      }*/
      return array('resultado'=>true,'rpta' => "SE ACTUALIZO LA BASE DE DATOS");
    }

	public function anular_nota_credito($tipo_nc,$tipo_doc,$serie,$numero){
		$db_prueba = $this->load->database('oracle',TRUE);
		$query = $db_prueba->query("UPDATE PRDDBFCOMERCIAL.BFNCA SET BFNCAEST = ? WHERE BFNCATIPO = ? AND BFNCATLET = ? AND BFNCASERNRO = ? AND BFNCANRO = ?", array($tipo_nc,$tipo_doc,$serie,$numero));
	}

    public function get_ruc_cliente($serie,$numero,$tipo){
        $db_prueba = $this->load->database('oracle',TRUE);
        $query = $db_prueba->query("select FSCCLIRUC from PRDDBFCOMERCIAL.sfactura where FSCSERNRO = ? and FSCNRO = ? and FSCTIPO = ?",array($serie,$numero,$tipo));
        return $query->row_array()['FSCCLIRUC'];
    }

    public function get_dni_cliente($serie,$numero,$tipo){
        $db_prueba = $this->load->database('oracle',TRUE);
        $query = $db_prueba->query("select FSCNRODOC from PRDDBFCOMERCIAL.sfactura where FSCSERNRO = ? and FSCNRO = ? and FSCTIPO = ?",array($serie,$numero,$tipo));
        return $query->row_array()['FSCNRODOC'];
    }
    //1
    public function get_oficina(){
        $query = $this->oracle->query("SELECT OFIDES FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($_SESSION['NSOFICOD']));
        return $query->row_array()['OFIDES'];
    }

    public function get_direccion_sede(){
        $query = $this->oracle->query("SELECT OFIDIR FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($_SESSION['NSOFICOD']));
        return $query->row_array()['OFIDIR'];
    }

    public function get_area($arecod){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT AREDES FROM PRDDBFCOMERCIAL.MAREAS WHERE ARECOD = ? ", array($arecod));
        return $query->row_array()['AREDES'];
    }

    public function get_igv_referencia($serie,$numero,$tipo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT FSCIGVREF FROM PRDDBFCOMERCIAL.SFACTURA WHERE FSCSERNRO = ? and FSCNRO = ? and FSCTIPO = ? ", array($serie,$numero,$tipo));
        return $query->row_array()['FSCIGVREF'];
    }

    public function recibos_pendientes($codigo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.TOTFAC WHERE CLICODFAX = ? ORDER BY FACEMIFEC DESC",array($codigo));
        return $query->result_array();
    }

    public function documentos_reclamdos($codigo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT ORCL.OFACSERNRO , ORCL.OFACNRO,ORCL.RECID,OREC.UUCOD
                                    FROM PRDGESTIONCOMERCIAL.ORECLAMO OREC INNER JOIN PRDGESTIONCOMERCIAL.ORECLAFAC ORCL
                                    ON (ORCL.EMPCOD=OREC.EMPCOD) AND (ORCL.OFICOD=OREC.OFICOD) AND (ORCL.ARECOD=OREC.ARECOD)
                                    AND (ORCL.CTDCOD=OREC.CTDCOD)AND (ORCL.DOCCOD=OREC.DOCCOD) AND (ORCL.SERNRO=OREC.SERNRO) AND (ORCL.RECID=OREC.RECID)
                                    WHERE PRDGESTIONCOMERCIAL.OREC.UUCOD=?",array($codigo));
        return $query->result_array();
    }
    //1
     public function get_nombre_sede(){
        $query = $this->oracle->query("SELECT (PROV || ' - ' ||DEPTO) AS DIRECCION,DIST FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD = ? ", array($_SESSION['NSOFICOD']));
        return $query->row_array();
    }

    public function get_tipo_nc(){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT ID, CODIGO, DESCRIPCIO, CATALOGO_I, ACTIVO
                                    FROM PRDDBFCOMERCIAL.FE_DETA_CATALOGO
                                    Where CATALOGO_I = 9 AND ACTIVO=1");
        return $query->result_array();
    }

    public function get_notas_credito2($serie,$numero){
        $query = $this->oracle->query("SELECT *  FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCAFACESTA = 'I' ORDER BY NCAFECHA DESC",array($serie,$numero));
        return $query->result_array();
    }

    public function get_notas_credito1($serie,$numero,$numero1){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND BFSFACTIPC = ? AND BFNCAEST <> ?",array($serie,$numero,$numero1, 'A'));
      return $query->result_array();
    }

    public function get_notas_que_masivas($tipo,$fecha_inicio,$fecha_fin){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE BFNCATIPO = ? AND BFNCAURSCOD = ? AND BFNCAFECHEMI BETWEEN ? AND ? AND BFNCAESTSUN = 6 ORDER BY BFNCANRO DESC",array($tipo,$_SESSION['user_id'],$fecha_inicio,$fecha_fin));
      return $query->result_array();
    }

}
