<?php
class Autorizacion_model extends CI_Model {
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

	public function get_rol($id){
		$query = $this->oracle->query("SELECT ROL.ID_ROL FROM PRDDBFCOMERCIAL.ROLES ROL INNER JOIN PRDDBFCOMERCIAL.USER_ROL USR ON ROL.ID_ROL = USR.ID_ROL WHERE USR.NCODIGO = ?",array($id));
		return $query->row_array()['ID_ROL'];
	}

    public function get_usuarios(){
      $query = $this->oracle->query("SELECT USR.* FROM PRDDBFCOMERCIAL.NUSERS USR INNER JOIN PRDDBFCOMERCIAL.USER_ROL ROL ON USR.NCODIGO = ROL.NCODIGO WHERE
USR.OFICOD = ? AND USR.OFIAGECOD = ? AND USR.NCODIGO <> ? AND USR.NESTADO = 1 AND ROL.ID_ROL = 10",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id']));
      return $query->result_array();
    }

    public function seacrh_bf($tipo,$serie,$numero){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.SFACTURA where FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ? AND FSCOFI = ? AND FSCAGE = ? AND SUNESTADO = ? ",
                                    array($serie,$numero,$tipo,$_SESSION['OFICOD'],$_SESSION['OFIAGECOD'], 3));
      return $query->row_array();
    }

    public function save_autorizacion($vigencia,$serie,$numero,$usuario,$glosa,$tipo){
      $this->oracle->trans_begin();
      $query1 = $this->oracle->query("SELECT AUT_NRO FROM PRDDBFCOMERCIAL.BFNGX_LETS ORDER BY AUT_NRO DESC");
      $query2 = $this->oracle->query("SELECT LOGIN FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = ?",array($_SESSION['user_id']));
      $numero1 = intval($query1->row_array()['AUT_NRO']) + 1;
      $login = $query2->row_array()['LOGIN'];
      $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.BFNGX_LETS (OFICOD,OFIAGECOD,AUT_NRO,AUT_FEC,AUT_VIG,NCODIGO,AUT_RED,AUT_GLO,AUT_OPE,AUT_TIPC,AUT_NCASER,AUT_NCANRO,AUT_EST,AUT_HRA)
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                    array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$numero1,date('d/m/Y'),$vigencia,$_SESSION['user_id'],$login,$glosa,$usuario,$tipo,$serie,$numero,2,date('H:i:s')));
      if(!$query){
        $this->oracle->trans_rollback();
        return array('resultado'=>false, 'rpta'=>"Hubo un error al momento de generar la autorización");
      }
      $this->oracle->trans_commit();
      return array('resultado'=>true, 'rpta'=>"Autorización generada con éxito");
    }

    public function search_autorizacion($tipo,$serie,$numero){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNGX_LETS WHERE AUT_TIPC = ? AND AUT_NCASER = ? AND AUT_NCANRO = ? AND AUT_EST = ? AND AUT_VIG >= ?",array($tipo,$serie,$numero,2,date('d/m/Y')));
      return $query->row_array();
    }

    public function get_autorizaciones_x_user(){
      $query = $this->oracle->query("SELECT *FROM PRDDBFCOMERCIAL.BFNGX_LETS
                                    WHERE OFICOD = ? AND OFIAGECOD = ? AND NCODIGO = ? ORDER BY AUT_FEC DESC,AUT_HRA DESC",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id']));
      return $query->result_array();
    }

    public function get_nombre_operador($operador){
      $query = $this->oracle->query("SELECT NNOMBRE FROM PRDDBFCOMERCIAL.NUSERS
                                    WHERE NCODIGO = ? ",array($operador));
      return $query->row_array()['NNOMBRE'];
    }

    public function get_monto_factura_boleta($tipo, $serie,$numero){
      $query = $this->oracle->query("SELECT FSCTOTAL  FROM PRDDBFCOMERCIAL.SFACTURA WHERE FSCSERNRO = ? AND FSCNRO = ? AND FSCTIPO = ?",array($serie,$numero,$tipo));
      $monto = floatval($query->row_array()['FSCTOTAL']);
      $query1 = $this->oracle->query("SELECT SUM(BFNCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.BFNCA WHERE SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND BFSFACTIPC = ? AND BFNCAEST <> ? ",array($serie,$numero,$tipo, 'A'));
      $descuento = floatval($query1->row_array()['TOTAL']);
      return ($monto - $descuento);
    }

    public function search_notas($tipo,$serie,$numero){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.BFNCA WHERE SFACTURA_FSCSERNRO = ? AND SFACTURA_FSCNRO = ? AND BFSFACTIPC = ? AND BFNCAEST <> ?",array($serie,$numero,$tipo,'A'));
      return $query->result_array();
    }

    #recibos
    public function get_autorizaciones_recibo($tipo){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NGX_LETS
                                    WHERE OFICOD = ? AND OFIAGECOD = ? AND NCODIGO = ? AND AUT_TIPO = ? ORDER BY AUT_FEC DESC,AUT_HRA DESC",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id'],$tipo));
      return $query->result_array();
    }

    public function get_usuarios_nc_recibos(){
      $query = $this->oracle->query("SELECT USR.* FROM PRDDBFCOMERCIAL.NUSERS USR INNER JOIN PRDDBFCOMERCIAL.USER_ROL ROL ON USR.NCODIGO = ROL.NCODIGO WHERE
                                    USR.OFICOD = ? AND USR.OFIAGECOD = ? AND USR.NCODIGO <> ? AND USR.NESTADO = 1 AND ROL.ID_ROL = 10",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$_SESSION['user_id']));
      return $query->result_array();
    }

    public function get_recibos($suministro){
      $query = $this->oracle->query("SELECT /*+ INDEX(CLICODFAX) */FACSERNRO, FACNRO, FACEMIFEC, CLICODFAX, FACESTADO, FACTOTAL FROM PRDDBFCOMERCIAL.TOTFAC WHERE 
                                      CLICODFAX = ? ORDER BY FACEMIFEC DESC",array($suministro));
      return $query->result_array();
    }

    public function get_recibos1($serie,$numero){
      $query = $this->oracle->query("SELECT /*+ INDEX(FACSERNRO, FACNRO) */ FACSERNRO, FACNRO, FACEMIFEC, CLICODFAX, FACESTADO, FACTOTAL FROM 
                                    PRDDBFCOMERCIAL.TOTFAC WHERE FACSERNRO = ? AND FACNRO = ? ",array($serie,$numero));
      return $query->result_array();
    }

    public function nca_x_recibo($serie,$numero){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ?",array($serie,$numero));
      return $query->result_array();
    }

    public function get_monto_notas($serie,$numero){
      $query = $this->oracle->query("SELECT SUM(NCATOTDIF) AS TOTAL FROM PRDDBFCOMERCIAL.NCA WHERE TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCATIPO = 'A' AND NCAFACESTA <> 'A'",array($serie,$numero));
      return $query->row_array()['TOTAL'];
    }

    public function get_nombre($suministro){
      if(strlen($suministro) == 7 ){
        $suministro = substr($suministro,0,3)."0000".substr($suministro,3,4);
      }
      $query = $this->oracle->query("SELECT CLINOMBRE FROM PRDCOMCATMEDLEC.PROPIE WHERE CLICODFAC = ? ",array($suministro));
      return $query->row_array()['CLINOMBRE'];
    }

    public function get_autorizacion_pendiente($serie,$numero,$suministro,$tipo){
      $query = $this->oracle->query("SELECT AUT_NRO FROM PRDDBFCOMERCIAL.NGX_LETS WHERE AUT_SER = ?  AND AUT_REC = ? AND CLIUNICOD = ? AND AUT_EST = 2 AND AUT_TIPO = ? AND AUT_VIGFEC > ?",array($serie,$numero,$suministro,$tipo,date('d/m/Y')));
      return $query->row_array()['AUT_NRO'];
    }

    public function create_autorizaciones($recibos,$vigencia,$glosa,$usuario){
      $this->oracle->trans_begin();
      foreach ($recibos as $recibo) {
        $query1 = $this->oracle->query("SELECT AUT_NRO FROM PRDDBFCOMERCIAL.NGX_LETS WHERE OFICOD = ?  AND OFIAGECOD = ? ORDER BY AUT_NRO DESC",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD']));
        $valor = intval($query1->row_array()['AUT_NRO']) + 1;
        $nombre = $this->get_nombre_operador($_SESSION['user_id']);
        $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.NGX_LETS (OFICOD,OFIAGECOD,AUT_NRO,CLIUNICOD,
                                                                            AUT_FEC,NCODIGO,AUT_HRA,AUT_RED,
                                                                            AUT_VIGFEC,AUT_GLO,AUT_OPE,AUT_SER,
                                                                            AUT_REC,AUT_EST,AUT_TIPO
                                                                            )
                                      VALUES (?,?,?,?,
                                        ?,?,?,?,
                                        ?,?,?,?,?,?,?)",
                                      array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$valor,$recibo['suministro'],
                                      date('d/m/Y'),$_SESSION['user_id'],date('H:i:s'),$nombre,
                                      $vigencia,$glosa,$usuario,$recibo['serie'],$recibo['numero'],2,1));
        if(!$query){
          $this->oracle->trans_rollback();
          return false; break;
        }
      }
      $this->oracle->trans_commit();
      return true;
    }

    public function create_autorizaciones_anulaciones($recibos,$vigencia,$glosa,$usuario){
      $this->oracle->trans_begin();
      foreach ($recibos as $recibo) {
        $query1 = $this->oracle->query("SELECT AUT_NRO FROM PRDDBFCOMERCIAL.NGX_LETS WHERE OFICOD = ?  AND OFIAGECOD = ? ORDER BY AUT_NRO DESC",array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD']));
        $valor = intval($query1->row_array()['AUT_NRO']) + 1;
        $nombre = $this->get_nombre_operador($_SESSION['user_id']);
        $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.NGX_LETS (OFICOD,OFIAGECOD,AUT_NRO,CLIUNICOD,
                                                                            AUT_FEC,NCODIGO,AUT_HRA,AUT_RED,
                                                                            AUT_VIGFEC,AUT_GLO,AUT_OPE,AUT_SER,
                                                                            AUT_REC,AUT_EST,AUT_TIPO
                                                                            )
                                      VALUES (?,?,?,?,
                                        ?,?,?,?,
                                        ?,?,?,?,?,?,?)",
                                      array($_SESSION['OFICOD'],$_SESSION['OFIAGECOD'],$valor,$recibo['suministro'],
                                      date('d/m/Y'),$_SESSION['user_id'],date('H:i:s'),$nombre,
                                      $vigencia,$glosa,$usuario,$recibo['serie'],$recibo['numero'],2,2));
        if(!$query){
          $this->oracle->trans_rollback();
          return false; break;
        }
      }
      $this->oracle->trans_commit();
      return true;
    }

    public function get_notas_credito2($serie,$numero){
      $fecha1 = '01/'.date('m/Y');
      $fecha2 = $this->ultimo_dia().'/'.date('m/Y');
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NCA WHERE NCATIPO = 'A' AND TOTFAC_FACSERNRO = ? AND TOTFAC_FACNRO = ? AND NCAFACESTA = 'I' AND NCAFECHA BETWEEN ? AND ?",array($serie,$numero,$fecha1,$fecha2));
      return $query->result_array();
    }

    public function get_nota_credito1($suministro){
      $fecha1 = '01/'.date('m/Y');
      $fecha2 = $this->ultimo_dia().'/'.date('m/Y');
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NCA WHERE NCATIPO = 'A' AND NCACLICODF = ? AND NCAFACESTA = 'I' AND NCAFECHA BETWEEN ? AND ?",array($suministro,$fecha1,$fecha2));
      return $query->result_array();
    }

    public function get_notas_credito($serie,$numero){
      $fecha1 = '01/'.date('m/Y');
      $fecha2 = $this->ultimo_dia().'/'.date('m/Y');
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NCA WHERE NCATIPO = 'A' AND NCASERNRO = ? AND NCANRO = ? AND NCAFACESTA = 'I' AND NCAFECHA BETWEEN ? AND ?",array($serie,$numero,$fecha1,$fecha2));
      return $query->result_array();
    }

    private function ultimo_dia(){
      $fecha = new DateTime();
      $fecha->modify('last day of this month');
      return $fecha->format('d');
    }

  }
  ?>
