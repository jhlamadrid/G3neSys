
<?php
class ReporteFonavi_model extends CI_Model {
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


    public function generar_reporte_SolicitudReclamo($estadoRep, $inicio, $fin){
        $query = $this->oracle->query("SELECT REC.COD_REC,PRESF.CODIGO, TO_DATE(REC.FEC_REG, 'dd/mm/yyyy') AS FEC_REG, REC.HORA_REG,PRESF.SUMINISTRO,
                                        RTRIM(PROYF.DESCRIPCION) AS PROYECTO, PRESF.NOMBRE AS PRESTATARIO, 
                                        DOC.NOMBRE, DOC.APEPAT, DOC.APEMAT, USU.LOGIN AS USUARIO, NVL(REC.ESTADO_RECLAMO,0) AS ESTADO,
                                        CASE
                                          WHEN NVL(REC.ESTADO_RECLAMO,0) = 1
                                          THEN 'REGISTRADO'
                                          WHEN NVL(REC.ESTADO_RECLAMO,0) = 0
                                          THEN 'ANULADO'
                                        END AS ESTADO_DESC
                                        FROM PRDDBFCOMERCIAL.PRESTATARIO_FONAVI PRESF
                                        INNER JOIN PRDDBFCOMERCIAL.PROYECTO_FONAVI PROYF ON PROYF.CODIGO = PRESF.CODIGO_PROYECTO
                                        INNER JOIN PRDDBFCOMERCIAL.RECFONAVI REC ON REC.CODIGO_PRESTATARIO = PRESF.CODIGO
                                        INNER JOIN PRDDBFCOMERCIAL.DOCIDENT DOC ON DOC.NRODOC = REC.DOCIDENT_NRODOC  AND TIPDOC = 1
                                        INNER JOIN PRDDBFCOMERCIAL.NUSERS USU ON USU.NCODIGO = REC.REC_USU
                                        WHERE REC.FEC_REG >= TO_DATE(?, 'dd/mm/yyyy') AND REC.FEC_REG <= TO_DATE(?,'dd/mm/yyyy') + 1  
                                        AND (REC.ESTADO_RECLAMO = ? OR ? = 2) ORDER BY REC.FEC_REG",array($inicio, $fin, $estadoRep, $estadoRep));
        return $query->result_array();
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


