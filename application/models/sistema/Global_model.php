<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Global_model extends CI_Model {
    
    function __construct() { 
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function findMenu($usuario){
        $query = $this->oracle->query('SELECT DISTINCT GRP.ID_MENUGEN, MENUGENNOM, MENUGENDESC, MENUGENICON, MENUGENPDR
                                      FROM PRDDBFCOMERCIAL.USER_ROL NR JOIN
                                      PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL JOIN
                                      PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL JOIN
                                      PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                      WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 ORDER BY GRP.MENUGENDESC',array($usuario));
        return $query->result_array();
    }

    public function findActividades($usuario, $menu){
        $query = $this->oracle->query('SELECT  DISTINCT ACT.ID_ACTIV, ACTIVINOMB, ACTIVIICON, ACTIVIHJO, ACTIVIRUTA
                                        FROM PRDDBFCOMERCIAL.USER_ROL NR
                                        JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                        JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                        JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                        JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                        JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                        WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND GRP.ID_MENUGEN = ? ',array($usuario,$menu));
        return $query->result_array();
    }

    public function findRol($usuario){ 
        $this->oracle->select('PRDDBFCOMERCIAL.ROLES.ID_ROL');
        $this->oracle->from('PRDDBFCOMERCIAL.ROLES');
        $this->oracle->join('PRDDBFCOMERCIAL.USER_ROL', 'PRDDBFCOMERCIAL.ROLES.ID_ROL = PRDDBFCOMERCIAL.USER_ROL.ID_ROL');
        $this->oracle->where('NCODIGO', $usuario);
        return $this->oracle->get()->row_array()['ID_ROL'];
    }

    public function findPermiso($usuario,$hijo){ 
        $query = $this->oracle->query("SELECT  DISTINCT ACT.ID_ACTIV,ACT.ACTIVINOMB,ACT.ACTIVIHJO,GRP.MENUGENPDR, RO.ID_ROL 
                                        FROM PRDDBFCOMERCIAL.USER_ROL NR
                                        JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                        JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                        JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                        JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV 
                                        JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                        WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND ACT.ACTIVIHJO = ?",array($usuario,$hijo));
        return $query->row_array();
    }

    public function findOficina($cod){
        $this->oracle->select('OFIDES');
        $this->oracle->from("PRDDBFCOMERCIAL.CEMPRES1");
        $this->oracle->where('OFICOD', $cod);
        return $this->oracle->get()->row_array()['OFIDES']; 
    }

    public function findArea($cod){
        $this->oracle->select('AREDES');
        $this->oracle->from("PRDDBFCOMERCIAL.MAREAS");
        $this->oracle->where('ARECOD', $cod);
        return $this->oracle->get()->row_array()['AREDES'];
    }

    public function insertOneLog($fch, $hra,  $ip, $infoOS, $usuario, $infoIP, $hostname, $token){
        $this->oracle->trans_begin();
            $this->oracle->select_max('SESCOD');
            $query = $this->oracle->get('PRDDBFCOMERCIAL.SESIONES'); 
            $cod = intval($query->row_array()['SESCOD']) + 1;
            $data = array(
                "SESCOD" => $cod,
                "SESFEC" => $fch,
                "SESHRA" => $hra,
                "SESIP"  => $ip,
                "SESNAVEGADOR" => $infoOS['browser'],
                "SESSO" => $infoOS['os'],
                "SESVERSSO" => (isset($infoOS['version']) ? $infoOS['version'] : null),
                "SESCODUSR" => $usuario,
                "SESCIUDAD" => (isset($infoIP) ? $infoIP : null),
                "SESHOSTNAME" => $hostname,
                "SESTOKEN" => $token
            );
            $this->oracle->insert('PRDDBFCOMERCIAL.SESIONES', $data);
        if ($this->oracle->trans_status() === FALSE){
            $this->oracle->trans_rollback();
            return false;
        } else {
            $this->oracle->trans_commit();
            return true;
        }
    }

    public function obtenerToken($codigo){
        $this->oracle->select("SESTOKEN");
        $this->oracle->from("PRDDBFCOMERCIAL.SESIONES");
        $this->oracle->where("SESCODUSR", $codigo);
        $this->oracle->order_by("SESFEC", 'DESC');
        $this->oracle->order_by("SESHRA", 'DESC');                    
        return $this->oracle->get()->row_array()['SESTOKEN'];
    }

    public function finPermisos($actID){
        $this->oracle->select("BTNGENNOMRE");
        $this->oracle->from("PRDDBFCOMERCIAL.ACT_BTNGEN");
        $this->oracle->join("PRDDBFCOMERCIAL.BTNGEN", "ACT_BTNGEN.ID_BTNGEN = BTNGEN.ID_BTNGEN", "INNER");
        $this->oracle->where("ESTADO", 1);
        $this->oracle->where("ID_ACTIV", $actID);
        return $this->oracle->get()->result_array() ;
    }


    public function getIGV(){
        $this->oracle->select("*");
        $this->oracle->from("SPRING.IMPUESTOS");
        $this->oracle->where("IMPUESTO",'IGV');
        return $this->oracle->get()->row_array();
    }

    public function getRegionZonaLocalidad($empresa, $oficina){
        $this->oracle->select("*");
        $this->oracle->from("PRDDBFCOMERCIAL.CEMPRES1");
        $this->oracle->where("EMPCOD", $empresa);
        $this->oracle->where("OFICOD", $oficina);
        return $this->oracle->get()->row_array();
    }

    public function getSerie($empresa, $oficina, $area, $tipo_doc){
        $this->oracle->select("*");
        $this->oracle->from("PRDDBFCOMERCIAL.CSERIES");
        $this->oracle->where("EMPCOD", $empresa);
        $this->oracle->where("OFICOD", $oficina);
        $this->oracle->where("ARECOD", $area);
        $this->oracle->where("CTDCOD", 1);
        $this->oracle->where("DOCCOD", $tipo_doc);
        return $this->oracle->get()->row_array();
        
    }

    public function getOpcionIndividual( $str ){
        $this->oracle->select("ID_BTNGEN");
        $this->oracle->from("PRDDBFCOMERCIAL.BTNGEN");
        $this->oracle->where("BTNGENNOMRE", $str);
        return $this->oracle->get()->row_array()['ID_BTNGEN'] ;
    }

    public function getAllOpciones($rol, $actividad){
        $this->oracle->select("PRDDBFCOMERCIAL.BTNGEN.BTNGENNOMRE");
        $this->oracle->from("PRDDBFCOMERCIAL.ROL_ACT_BTN");
        $this->oracle->join("PRDDBFCOMERCIAL.BTNGEN", "ROL_ACT_BTN.ID_BTNGEN = BTNGEN.ID_BTNGEN", "INNER");
        $this->oracle->where("ROL_ACT_BTN.ID_ROL", intval($rol));
        $this->oracle->where("ROL_ACT_BTN.ID_ACTIV", $actividad);
        $this->oracle->where("ROL_ACT_BTN.ESTADO", 1);
        return  $this->oracle->get()->result_array();
    }

    public function getDefaultPropie(){
        $this->oracle->select("CLICODFAC, CLINOMBRE, CLIELECT, CLIRUC");
        $this->oracle->from("PRDCOMCATMEDLEC.PROPIE");
        $this->oracle->where("CLICODFAC","99999999999");
        return $this->oracle->get()->row_array();
    }

    public function getDetaCatalagoByCatalago($id){
        $this->oracle->select("*");
        $this->oracle->from("PRDDBFCOMERCIAL.FE_DETA_CATALOGO");
        $this->oracle->where("CATALOGO_I", $id);
        return $this->oracle->get()->result_array();
    }

}