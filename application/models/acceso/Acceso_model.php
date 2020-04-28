<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Acceso_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function findOneUsuario($login, $pass){
        $query = $this->oracle->query("SELECT   LOGIN, RUTIMAGEN, NNOMBRE, NCODIGO, NSUSRCOD, NFECHAE, WF_ORGANIGRAMA, TIPOUSER, SIGLA_WORKFLOW,
                                                NSEMPCOD, NSOFICOD, NSARECOD, OFICOD, OFIAGECOD,  SERVIDOR,
                                                CASE WHEN ( NENDS > SYSDATE ) THEN 0 ELSE 1 END AS VENCIDO 
                                                FROM PRDDBFCOMERCIAL.NUSERS WHERE LOGIN = ? AND 
                                                NCLAVE = ? AND NESTADO = 1", array($login, $pass));
        return $query->row_array();
    }
    public function getSiglaArea($organigrama){
        $query = $this->oracle->query("SELECT SIGLA_AREA FROM PRDDBFCOMERCIAL.WF_ORGANIGRAMA WHERE IDORGANIGRAMA=? ", array($organigrama));
        return $query->row_array();
    }

    public function findOneUsuarioCod($cod){
        $this->oracle->select('NNOMBRE, NCODIGO, NDIRECC, LOGIN, RUTIMAGEN, NTELEFO, NDNI, NENDS, NSEMPCOD, NSOFICOD, NSARECOD, SERVIDOR'); //Agregar a producción NSUSRMAIL
        $query = $this->oracle->get_where("PRDDBFCOMERCIAL.NUSERS", array("NCODIGO" => $cod));
        return $query->row_array();
    } 

    public function findRol($cod){
        $this->oracle->select("PRDDBFCOMERCIAL.ROLES.ROLDESC");
        $this->oracle->from("PRDDBFCOMERCIAL.ROLES");
        $this->oracle->join("PRDDBFCOMERCIAL.USER_ROL","PRDDBFCOMERCIAL.USER_ROL.ID_ROL  = PRDDBFCOMERCIAL.ROLES.ID_ROL" );
        $this->oracle->where("NCODIGO", $cod);
        return $this->oracle->get()->row_array()['ROLDESC'];
    }

    public function findFechaExpiracion($cod){
        $this->oracle->select("TO_CHAR(NENDS, 'YYYY-MM-DD') AS EXP");
        $this->oracle->from("PRDDBFCOMERCIAL.NUSERS");
        $this->oracle->where("NCODIGO", $cod);
        return $this->oracle->get()->row_array()["EXP"];
    }

    public function findNotasCredito(){
        $date = date('d/m/Y');
        $query = $this->oracle->query("SELECT COUNT(NCASERNRO) AS CANTIDAD, SUM(NCATOTDIF) AS MONTO,  NCAFICOD, NCAFIAGECO, OFIDES FROM PRDDBFCOMERCIAL.NCA INNER JOIN 
                                        PRDDBFCOMERCIAL.CEMPRES1 ON NCAFICOD = OFICOD_GENESYS AND NCAFIAGECO = OFIAGECOD_GENESYS
                                        WHERE NCATIPO = 'A' AND NCAFECHA = ?  AND NCAFACESTA <> 'A' GROUP BY NCAFICOD, NCAFIAGECO, OFIDES", array('20/07/2017'));
        return $query->result_array();
    }

    public function findLastSession($usuario){
        $this->oracle->select("(SESFEC || ' '|| SESHRA) AS SESION");
        $this->oracle->from('PRDDBFCOMERCIAL.SESIONES');
        $this->oracle->where('SESCODUSR', $usuario);
        $this->oracle->order_by('SESFEC', 'DESC');
        $this->oracle->order_by('SESHRA', 'DESC');
        return $this->oracle->get()->result_array()[1]['SESION'];
    }

    public function updatePsw($psw, $id){
        $this->oracle->trans_begin();
            $data['NCLAVE'] = sha1($psw);
            $this->oracle->where('NCODIGO', $id);
            $this->oracle->update('PRDDBFCOMERCIAL.NUSERS', $data);
        if ($this->oracle->trans_status() === FALSE){
            $this->oracle->trans_rollback();
            return false;
        } else {
            $this->oracle->trans_commit();
            return true;
        }
        
    }

    public function findUsuarioReclamo($usuario){
        $this->oracle->select("USRCOD, EMPCOD, OFICOD, ARECOD");
        $this->oracle->from("PRDGESTIONCOMERCIAL.MUSUARIO");
        $this->oracle->where("USRLOG", $usuario);
        return $this->oracle->get()->row_array();
    }



}