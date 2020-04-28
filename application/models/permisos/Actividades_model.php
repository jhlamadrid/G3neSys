<?php

class Actividades_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_permiso_cuenta_corriente($usuario,$hijo){
      $query = $this->oracle->query("SELECT  DISTINCT ACT.*,GRP.MENUGENPDR FROM PRDDBFCOMERCIAL.USER_ROL NR
                                      JOIN PRDDBFCOMERCIAL.ROLES RO ON NR.ID_ROL = RO.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ROL_ACT ACR ON RO.ID_ROL = ACR.ID_ROL
                                      JOIN PRDDBFCOMERCIAL.ACTIVIDADES ACT ON ACR.ID_ACTIV = ACT.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN_ACT ACTG ON ACT.ID_ACTIV = ACTG.ID_ACTIV
                                      JOIN PRDDBFCOMERCIAL.MENUGEN GRP ON ACTG.ID_MENUGEN = GRP.ID_MENUGEN
                                      WHERE NR.NCODIGO = ? AND NR.ESTADO = 1 AND ACR.ESTADO = 1 AND ACTG.ESTADO = 1 AND ACT.ACTIVIHJO = ?",array($usuario,$hijo));
      return $query->row_array();
    }

    public function get_all_menus(){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.MENUGEN');
      return $query->result_array();
    }

    public function get_all_actividades($id_menu){
      $query = $this->oracle->query('SELECT ACT.* FROM PRDDBFCOMERCIAL.ACTIVIDADES ACT JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT MACT ON ACT.ID_ACTIV =  MACT.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN  MEN ON MACT.ID_MENUGEN =  MEN.ID_MENUGEN WHERE MEN.ID_MENUGEN = ?',array($id_menu));
      return $query->result_array();
    }

    public function get_one_actividad($id){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ACTIVIDADES WHERE ID_ACTIV = ? ",array($id));
      return $query->row_array();
    }

    public function update_actividad($id,$nombre,$abreviatura,$icono,$desripcion){
       $this->oracle->trans_begin();
       $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.ACTIVIDADES  SET ACTIVINOMB = ?, ACTIVIABRV = ?, ACTIVIICON = ?, ACTIVDESC = ? WHERE ID_ACTIV = ? ",array($nombre,$abreviatura,$icono,$desripcion,$id));
       if(!$query){
           $this->oracle->trans_rollback();
           return false;
       }
       $this->oracle->trans_commit();
       return true;
    }

    public function save_actividad($menu,$actividad){
      $this->oracle->trans_start();
      $query = $this->oracle->query('SELECT ID_MENUGEN FROM PRDDBFCOMERCIAL.MENUGEN ORDER BY ID_MENUGEN DESC');
      $next = intval($query->row_array()['ID_MENUGEN']) + 1;
      $query1 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.MENUGEN (ID_MENUGEN,MENUGENDESC,MENUGENABR,MENUGENNOM,MENUGENICON,MENUGENPDR,MENUGENFECH)
                                      VALUES (?,?,?,?,?,?,?)", array($next,$menu['descripcion'],$menu['abreviatura'],$menu['nombre'],$menu['icono'],$menu['padre'],date('d/m/Y')));
      $query3 = $this->oracle->query('SELECT ID_ACTIV FROM PRDDBFCOMERCIAL.ACTIVIDADES ORDER BY ID_ACTIV DESC');
      $next2 = intval($query3->row_array()['ID_ACTIV']) + 1;
      $query2 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.ACTIVIDADES (ID_ACTIV,ACTIVDESC,ACTIVIABRV,ACTIVINOMB,ACTIVIICON,ACTIVIHJO,ACTIVIRUTA,ACTIVIFECHA,SISTEMA_ID)
                                      VALUES (?,?,?,?,?,?,?,?,?)",array($next2,$actividad['descripcion'],$actividad['abreviatura'],$actividad['nombre'],$actividad['icono'],$actividad['hijo'],$actividad['ruta'],date('d/m/Y'),8));
      $query4 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.MENUGEN_ACT (ID_MENUGEN,ID_ACTIV,ESTADO,FECHCREA) VALUES (?,?,?,?)",array($next,$next2,1,date('d/m/Y')));
      $this->oracle->trans_complete();
      if ($this->oracle->trans_status() === FALSE) {
        $this->oracle->trans_rollback();
        return false;
      } else {
        $this->oracle->trans_commit();
        return true;
      }
    }

    public function save_actividad1($actividad){
      $this->oracle->trans_start();
      $query3 = $this->oracle->query('SELECT ID_ACTIV FROM PRDDBFCOMERCIAL.ACTIVIDADES ORDER BY ID_ACTIV DESC');
      $next2 = intval($query3->row_array()['ID_ACTIV']) + 1;
      $query2 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.ACTIVIDADES (ID_ACTIV,ACTIVDESC,ACTIVIABRV,ACTIVINOMB,ACTIVIICON,ACTIVIHJO,ACTIVIRUTA,ACTIVIFECHA,SISTEMA_ID)
                                      VALUES (?,?,?,?,?,?,?,?,?)",array($next2,$actividad['descripcion'],$actividad['abreviatura'],$actividad['nombre'],$actividad['icono'],$actividad['hijo'],$actividad['ruta'],date('d/m/Y'),8));
      $query4 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.MENUGEN_ACT (ID_MENUGEN,ID_ACTIV,ESTADO,FECHCREA) VALUES (?,?,?,?)",array($actividad['padre'],$next2,1,date('d/m/Y')));
      $this->oracle->trans_complete();
      if ($this->oracle->trans_status() === FALSE) {
        $this->oracle->trans_rollback();
        return false;
      } else {
        $this->oracle->trans_commit();
        return true;
      }
    }

}
?>
