
<?php
class ReclamoFonavi_model extends CI_Model {
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

  public function create_ReclamoFonavi($dni, $motivo, $docs, $observ, $prestatario, $user){
      $this->oracle->trans_begin();
        $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.RECFONAVI (DOCIDENT_NRODOC,REC_MOTIV,
                                                                             REC_DOC, CODIGO_PRESTATARIO, REC_OBS,
                                                                             REC_USU,DOCIDENT_TIPDOC, NUSERS_NCODIGO,ESTADO_RECLAMO)
                                     VALUES(?,?,?,?,
                                          ?,?,?,?,?)",array($dni,$motivo,$docs,$prestatario,$observ, 
                                                              $user, 1, 1, 1));
        $query1 = $this->oracle->query("SELECT MAX(COD_REC) AS COD_REC FROM PRDDBFCOMERCIAL.RECFONAVI");
        $cod = intval($query1->row_array()['COD_REC']);
        if(!$query){
            $this->oracle->trans_rollback();
            return array('result'=>false, 'mensaje'=>"NO SE PUEDE HACER EL REGISTRO");
        }
        // $valor = intval($query1->row_array()['COD_REC']);
      $this->oracle->trans_commit(); 
      return $cod;
  }

  public function create_ReclamoFonavi_det($LstRecibos, $id){
    $this->oracle->trans_begin();
      foreach ($LstRecibos as $recibo) {
        $exist = $this->oracle->query("SELECT RECIBOS_FACT_FONAVI_CODIGO FROM PRDDBFCOMERCIAL.DETRECFONAVI 
                                        WHERE ESTADO_REC_RECIBO = ? AND RECIBOS_FACT_FONAVI_CODIGO = ?",array(1,(int)$recibo['codFac']));
        $cod = intval($exist->row_array()['RECIBOS_FACT_FONAVI_CODIGO']);
          if($cod!=0){
            $this->oracle->trans_rollback();
            return false; /*array('result'=>false, 'mensaje'=>"EL RECIBO ".$recibo['serie']."-".$recibo['numero']." YA SE ENCUENTRA EN RECLAMO");*/
          }
        $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.DETRECFONAVI (RECFONAVI_COD_REC, RECIBOS_FACT_FONAVI_CODIGO, ESTADO_REC_RECIBO)
                                       VALUES (?,?,?)",
                                      array((int)$id, (int)$recibo['codFac'],1));
                                    
        if(!$query){
          $this->oracle->trans_rollback();
          return false;
        }

      }
      $this->oracle->trans_commit();
      return true;
  }
  // ********* Lista de Recibos con estado de reclamdo ****** //
  public function get_LstRecibos_reclamados($codPrest){
    $query = $this->oracle->query("SELECT REC.COD_REC,PRESF.CODIGO, REC.FEC_REG, REC.HORA_REG,PRESF.SUMINISTRO,
                                    PROYF.DESCRIPCION AS PROYECTO, PRESF.NOMBRE AS PRESTATARIO, 
                                    DOC.NOMBRE, DOC.APEPAT, DOC.APEMAT, USU.LOGIN AS USUARIO, REC.ESTADO_RECLAMO AS ESTADO
                                    FROM PRDDBFCOMERCIAL.PRESTATARIO_FONAVI PRESF
                                    INNER JOIN PRDDBFCOMERCIAL.PROYECTO_FONAVI PROYF ON PROYF.CODIGO = PRESF.CODIGO_PROYECTO
                                    INNER JOIN PRDDBFCOMERCIAL.RECFONAVI REC ON REC.CODIGO_PRESTATARIO = PRESF.CODIGO
                                    INNER JOIN PRDDBFCOMERCIAL.DETRECFONAVI DET ON DET.RECFONAVI_COD_REC = REC.COD_REC
                                    INNER JOIN PRDDBFCOMERCIAL.DOCIDENT DOC ON DOC.NRODOC = REC.DOCIDENT_NRODOC  AND TIPDOC = 1
                                    INNER JOIN PRDDBFCOMERCIAL.NUSERS USU ON USU.NCODIGO = REC.REC_USU
                                    WHERE PRESF.CODIGO = ? ORDER BY REC.COD_REC",array($codPrest));
    return $query->result_array();
  }
   // ********************* END ************************** //

   // ********* Lista de Solicitudes de Reclamo --> Detalle ****** //
  public function get_Reclamos_viewDetalle($codPrest){
    $query = $this->oracle->query("SELECT REC.COD_REC,PRESF.CODIGO, REC.FEC_REG, REC.REC_MOTIV, REC.REC_DOC, REC.REC_OBS, REC.HORA_REG, PRESF.SUMINISTRO, PRESF.DIRECCION AS DIRECCION_P,
                                          PROYF.DESCRIPCION AS PROYECTO, PROYF.CODIGO AS COD_PROY , PROYF.UBICACION AS UBIPROYEC,PROYF.CONCESIONARIO, PRESF.NOMBRE AS PRESTATARIO, 
                                          DOC.NOMBRE, DOC.APEPAT, DOC.APEMAT, DOC.NRODOC,DOC.EMAIL, DOC.TELFIJ,  USU.LOGIN AS USUARIO, REC.ESTADO_RECLAMO AS ESTADO,
                                          RECIBO.PERIODO, RECIBO.SERIE_RECIBO, RECIBO.NUMERO_RECIBO,
                                          RECIBO.FECHA_EMISION_RECIBO, RECIBO.TARIFA, RECIBO.MEDIDOR,
                                          RECIBO.SUBTOTAL_RECIBO, RECIBO.IGV_RECIBO, RECIBO.TOTAL_RECIBO, DET.RECIBOS_FACT_FONAVI_CODIGO,
                                          RECIBO.ESTADO_RECIBO, RECIBO.FECHA_MOV_RECIBO, RECIBO.PRESTATARIO_FONAVI_CODIGO,
                                          RECIBO.LOCALIDAD,RECIBO.IMPORTE_FONAVI
                                          FROM PRDDBFCOMERCIAL.PRESTATARIO_FONAVI PRESF
                                          INNER JOIN PRDDBFCOMERCIAL.PROYECTO_FONAVI PROYF ON PROYF.CODIGO = PRESF.CODIGO_PROYECTO
                                          INNER JOIN PRDDBFCOMERCIAL.RECFONAVI REC ON REC.CODIGO_PRESTATARIO = PRESF.CODIGO
                                          INNER JOIN PRDDBFCOMERCIAL.DETRECFONAVI DET ON DET.RECFONAVI_COD_REC = REC.COD_REC
                                          INNER JOIN PRDDBFCOMERCIAL.DOCIDENT DOC ON DOC.NRODOC = REC.DOCIDENT_NRODOC  AND TIPDOC = 1
                                          INNER JOIN PRDDBFCOMERCIAL.NUSERS USU ON USU.NCODIGO = REC.REC_USU
                                          INNER JOIN ( SELECT RECIF.PERIODO, RECIF.TOTFAC_FACSERNRO AS SERIE_RECIBO, RECIF.TOTFAC_FACNRO AS NUMERO_RECIBO, RECIF.PRESTATARIO_FONAVI_CODIGO,
                                                        TOTF.FECHA_EMISION_RECIBO, TOTF.TARIFA, TOTF.MEDIDOR, TOTF.SUBTOTAL_RECIBO, TOTF.IGV_RECIBO, TOTF.TOTAL_RECIBO, TOTF.ESTADO_RECIBO,
                                                        TOTF.FECHA_MOV_RECIBO, TOTF.LOCALIDAD, TOTF.IMPORTE_FONAVI
                                                        FROM PRDDBFCOMERCIAL.RECIBOS_FACT_FONAVI RECIF
                                                        INNER JOIN ( SELECT TOTFAC.FACSERNRO, TOTFAC.FACNRO,
                                                        TOTFAC.FACEMIFEC AS FECHA_EMISION_RECIBO, NVL(TOTFAC.FACTARIFA,' ' ) AS TARIFA, NVL(TOTFAC.FMEDIDOR,' ') AS MEDIDOR,
                                                        TOTFAC.FACTOTSUB AS SUBTOTAL_RECIBO, TOTFAC.FACIGV AS IGV_RECIBO, TOTFAC.FACTOTAL AS TOTAL_RECIBO, TOTFAC.FACESTADO AS ESTADO_RECIBO,
                                                        TOTFAC.FACESTFECH AS FECHA_MOV_RECIBO, LOCALI.LOCDES AS LOCALIDAD, LETFON.IMPORTE_FONAVI
                                                        FROM PRDDBFCOMERCIAL.TOTFAC
                                                        LEFT JOIN PRDDBFCOMERCIAL.LOCALI ON TOTFAC.PREREGIOX = REGCOD AND TOTFAC.PRELOCALX = LOCCOD
                                                        INNER JOIN ( SELECT LETFAC.TOTFAC_FACSERNRO AS SERIE, LETFAC.TOTFAC_FACNRO AS NUMERO, SUM(LETFAC.CRECUOMON) AS IMPORTE_FONAVI
                                                        FROM PRDDBFCOMERCIAL.LETFAC
                                                        WHERE CONCEP_FACCONCOD = 942 OR CONCEP_FACCONCOD BETWEEN 120 AND 190
                                                        GROUP BY LETFAC.TOTFAC_FACSERNRO, LETFAC.TOTFAC_FACNRO ) LETFON
                                                        ON TOTFAC.FACSERNRO = LETFON.SERIE AND TOTFAC.FACNRO = LETFON.NUMERO ) TOTF
                                                        ON RECIF.TOTFAC_FACSERNRO = TOTF.FACSERNRO AND RECIF.TOTFAC_FACNRO = TOTF.FACNRO
                                                        ORDER BY RECIF.PRESTATARIO_FONAVI_CODIGO ) RECIBO ON RECIBO.PRESTATARIO_FONAVI_CODIGO = PRESF.CODIGO
                                        WHERE REC.COD_REC = ? ORDER BY REC.COD_REC",array($codPrest));
    return $query->result_array();
  }
   // ********************* END ************************** //


    // ********************* [DETALLE] BLOQUE DE BUSQUEDAS POR EL TIPO DE DOCUMENTO ******************
    public function get_recibos_suministro($suministro){
      $query = $this->oracle->query("SELECT PRESF.CODIGO, PRESF.NOMBRE, PRESF.DIRECCION, PRESF.CODIGO_PROYECTO, PRESF.SUMINISTRO,
          PROYF.DESCRIPCION, PROYF.CONCESIONARIO,
          RECIBO.PERIODO, RECIBO.SERIE_RECIBO, RECIBO.NUMERO_RECIBO,
          RECIBO.FECHA_EMISION_RECIBO, RECIBO.TARIFA, RECIBO.MEDIDOR,
          RECIBO.SUBTOTAL_RECIBO, RECIBO.IGV_RECIBO, RECIBO.TOTAL_RECIBO,
          RECIBO.ESTADO_RECIBO, RECIBO.FECHA_MOV_RECIBO, RECIBO.COD_FACT
          FROM PRDDBFCOMERCIAL.PRESTATARIO_FONAVI PRESF
          INNER JOIN PRDDBFCOMERCIAL.PROYECTO_FONAVI PROYF ON PROYF.CODIGO = PRESF.CODIGO_PROYECTO
          INNER JOIN ( SELECT RECIF.CODIGO AS COD_FACT, RECIF.PERIODO, RECIF.TOTFAC_FACSERNRO AS SERIE_RECIBO, RECIF.TOTFAC_FACNRO AS NUMERO_RECIBO, RECIF.PRESTATARIO_FONAVI_CODIGO,
          TOTF.FACEMIFEC AS FECHA_EMISION_RECIBO, NVL(TOTF.FACTARIFA,' ' ) AS TARIFA, NVL(TOTF.FMEDIDOR,' ') AS MEDIDOR,
          TOTF.FACTOTSUB AS SUBTOTAL_RECIBO, TOTF.FACIGV AS IGV_RECIBO, TOTF.FACTOTAL AS TOTAL_RECIBO, TOTF.FACESTADO AS ESTADO_RECIBO, TOTF.FACESTFECH AS FECHA_MOV_RECIBO
          FROM PRDDBFCOMERCIAL.RECIBOS_FACT_FONAVI RECIF
          INNER JOIN PRDDBFCOMERCIAL.TOTFAC TOTF ON RECIF.TOTFAC_FACSERNRO = TOTF.FACSERNRO AND RECIF.TOTFAC_FACNRO = TOTF.FACNRO
          ORDER BY RECIF.PRESTATARIO_FONAVI_CODIGO ) RECIBO ON RECIBO.PRESTATARIO_FONAVI_CODIGO = PRESF.CODIGO
          WHERE SUMINISTRO = ? ORDER BY FECHA_EMISION_RECIBO DESC",array($suministro));
      return $query->result_array();
    }

    public function get_recibos_numeroSerie($serie,$numero){
      $query = $this->oracle->query("SELECT PRESF.CODIGO, PRESF.NOMBRE, PRESF.DIRECCION, PRESF.CODIGO_PROYECTO, PRESF.SUMINISTRO,
          PROYF.DESCRIPCION, PROYF.CONCESIONARIO,
          RECIBO.PERIODO, RECIBO.SERIE_RECIBO, RECIBO.NUMERO_RECIBO,
          RECIBO.FECHA_EMISION_RECIBO, RECIBO.TARIFA, RECIBO.MEDIDOR,
          RECIBO.SUBTOTAL_RECIBO, RECIBO.IGV_RECIBO, RECIBO.TOTAL_RECIBO,
          RECIBO.ESTADO_RECIBO, RECIBO.FECHA_MOV_RECIBO, RECIBO.COD_FACT
          FROM PRDDBFCOMERCIAL.PRESTATARIO_FONAVI PRESF
          INNER JOIN PRDDBFCOMERCIAL.PROYECTO_FONAVI PROYF ON PROYF.CODIGO = PRESF.CODIGO_PROYECTO
          INNER JOIN ( SELECT RECIF.CODIGO AS COD_FACT, RECIF.PERIODO, RECIF.TOTFAC_FACSERNRO AS SERIE_RECIBO, RECIF.TOTFAC_FACNRO AS NUMERO_RECIBO, RECIF.PRESTATARIO_FONAVI_CODIGO,
          TOTF.FACEMIFEC AS FECHA_EMISION_RECIBO, NVL(TOTF.FACTARIFA,' ' ) AS TARIFA, NVL(TOTF.FMEDIDOR,' ') AS MEDIDOR,
          TOTF.FACTOTSUB AS SUBTOTAL_RECIBO, TOTF.FACIGV AS IGV_RECIBO, TOTF.FACTOTAL AS TOTAL_RECIBO, TOTF.FACESTADO AS ESTADO_RECIBO, TOTF.FACESTFECH AS FECHA_MOV_RECIBO
          FROM PRDDBFCOMERCIAL.RECIBOS_FACT_FONAVI RECIF
          INNER JOIN PRDDBFCOMERCIAL.TOTFAC TOTF ON RECIF.TOTFAC_FACSERNRO = TOTF.FACSERNRO AND RECIF.TOTFAC_FACNRO = TOTF.FACNRO
          ORDER BY RECIF.PRESTATARIO_FONAVI_CODIGO ) RECIBO ON RECIBO.PRESTATARIO_FONAVI_CODIGO = PRESF.CODIGO
          WHERE SERIE_RECIBO = ? AND NUMERO_RECIBO = ? ORDER BY FECHA_EMISION_RECIBO DESC ",array($serie,$numero));
          return $query->result_array();
    }
    
    public function get_recibos_prestatario($prestatario){
      $query = $this->oracle->query("SELECT PRESF.CODIGO, PRESF.NOMBRE, PRESF.DIRECCION, PRESF.CODIGO_PROYECTO, PRESF.SUMINISTRO,
            PROYF.DESCRIPCION, PROYF.CONCESIONARIO,
            RECIBO.PERIODO, RECIBO.SERIE_RECIBO, RECIBO.NUMERO_RECIBO,
            RECIBO.FECHA_EMISION_RECIBO, RECIBO.TARIFA, RECIBO.MEDIDOR,
            RECIBO.SUBTOTAL_RECIBO, RECIBO.IGV_RECIBO, RECIBO.TOTAL_RECIBO,
            RECIBO.ESTADO_RECIBO, RECIBO.FECHA_MOV_RECIBO, RECIBO.COD_FACT
            FROM PRDDBFCOMERCIAL.PRESTATARIO_FONAVI PRESF
            INNER JOIN PRDDBFCOMERCIAL.PROYECTO_FONAVI PROYF ON PROYF.CODIGO = PRESF.CODIGO_PROYECTO
            INNER JOIN ( SELECT RECIF.CODIGO AS COD_FACT, RECIF.PERIODO, RECIF.TOTFAC_FACSERNRO AS SERIE_RECIBO, RECIF.TOTFAC_FACNRO AS NUMERO_RECIBO, RECIF.PRESTATARIO_FONAVI_CODIGO,
            TOTF.FACEMIFEC AS FECHA_EMISION_RECIBO, NVL(TOTF.FACTARIFA,' ' ) AS TARIFA, NVL(TOTF.FMEDIDOR,' ') AS MEDIDOR,
            TOTF.FACTOTSUB AS SUBTOTAL_RECIBO, TOTF.FACIGV AS IGV_RECIBO, TOTF.FACTOTAL AS TOTAL_RECIBO, TOTF.FACESTADO AS ESTADO_RECIBO, TOTF.FACESTFECH AS FECHA_MOV_RECIBO
            FROM PRDDBFCOMERCIAL.RECIBOS_FACT_FONAVI RECIF
            INNER JOIN PRDDBFCOMERCIAL.TOTFAC TOTF ON RECIF.TOTFAC_FACSERNRO = TOTF.FACSERNRO AND RECIF.TOTFAC_FACNRO = TOTF.FACNRO
            ORDER BY RECIF.PRESTATARIO_FONAVI_CODIGO ) RECIBO ON RECIBO.PRESTATARIO_FONAVI_CODIGO = PRESF.CODIGO
            WHERE PRESF.CODIGO = ? ORDER BY FECHA_EMISION_RECIBO DESC",array($prestatario));
      return $query->result_array();
    }
    // ************************** END -- BUSQUEDA ***************************** //
  
    // ********************* [CABECERA] BLOQUE DE BUSQUEDAS POR EL TIPO DE DOCUMENTO ******************
    public function get_General_Proyecto($tipo){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NGX_LETS
                                    WHERE OFICOD = ? AND OFIAGECOD = ? AND NCODIGO = ? AND AUT_TIPO = ? ORDER BY AUT_FEC DESC,AUT_HRA DESC",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id'],$tipo));
      return $query->result_array();
    }
    public function get_General_Prestatario($tipo){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NGX_LETS
                                    WHERE OFICOD = ? AND OFIAGECOD = ? AND NCODIGO = ? AND AUT_TIPO = ? ORDER BY AUT_FEC DESC,AUT_HRA DESC",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id'],$tipo));
      return $query->result_array();
    }
    // ************************** END -- BUSQUEDA ***************************** //

    public function upd_estadoReclamo($codRec, $codUsu){
      $this->oracle->trans_begin();
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.RECFONAVI
                                        SET ESTADO_RECLAMO = 0,
                                            REC_USUPD = ?,
                                            FEC_UPD = SYSDATE,
                                            HORA_UPD = to_char(SYSDATE, 'HH24:MI:SS')
                                        WHERE COD_REC = ? ",array($codUsu, $codRec));

        $query2 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.DETRECFONAVI
                                                  SET ESTADO_REC_RECIBO = 0
                                                  WHERE RECFONAVI_COD_REC = ?",array($codRec));
        if(!$query || !$query2){
            $this->oracle->trans_rollback();
            return false;
        }
        $this->oracle->trans_commit();
        return true;
    }

    public function get_nombre_operador($operador){
      $query = $this->oracle->query("SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS
                                    WHERE NCODIGO = ? ",array($operador));
      return $query->row_array()['NNOMBRE'];
    }
    public function get_autorizacion_pendiente($serie,$numero,$suministro,$tipo){
      $query = $this->oracle->query("SELECT AUT_NRO FROM PRDDBFCOMERCIAL.NGX_LETS WHERE AUT_SER = ?  AND AUT_REC = ? AND CLIUNICOD = ? AND AUT_EST = 2 AND AUT_TIPO = ? AND AUT_VIGFEC > ?",array($serie,$numero,$suministro,$tipo,date('d/m/Y')));
      return $query->row_array()['AUT_NRO'];
    }
    
    public function get_EstadoReclamo($codFac){
      $query = $this->oracle->query("SELECT RECIBOS_FACT_FONAVI_CODIGO FROM PRDDBFCOMERCIAL.DETRECFONAVI WHERE RECIBOS_FACT_FONAVI_CODIGO = ? AND ESTADO_REC_RECIBO = ?",array($codFac,1));
      return $query->row_array()['RECIBOS_FACT_FONAVI_CODIGO'];
    }

    public function get_monto_notas($serie,$numero){
      $query = $this->oracle->query("SELECT SUM(NCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A'",array($serie,$numero));
      return $query->row_array()['TOTAL'];
    }
    

    // recibos
    
    public function get_usuarios_nc_recibos(){
      $query = $this->oracle->query("SELECT USR.* FROM PRDDBFCOMERCIAL.NUSERS USR INNER JOIN PRDDBFCOMERCIAL.USER_ROL ROL ON USR.NCODIGO = ROL.NCODIGO WHERE
                                    USR.OFICOD = ? AND USR.OFIAGECOD = ? AND USR.NCODIGO <> ? AND USR.NESTADO = 1 AND ROL.ID_ROL = 10",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id']));
      return $query->result_array();
    }
    public function get_autorizaciones_recibo($tipo){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NGX_LETS
                                    WHERE OFICOD = ? AND OFIAGECOD = ? AND NCODIGO = ? AND AUT_TIPO = ? ORDER BY AUT_FEC DESC,AUT_HRA DESC",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id'],$tipo));
      return $query->result_array();
    }

  }
  ?>
