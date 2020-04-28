<?php

class Roles_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_all_roles(){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ROLES");
      return $query->result_array();
    }

    public function get_menu_x_rol($rol){
      $query = $this->oracle->query("SELECT DISTINCT MEN.* FROM PRDDBFCOMERCIAL.ACTIVIDADES ACT INNER JOIN
                                      PRDDBFCOMERCIAL.ROL_ACT RAC ON ACT.ID_ACTIV = RAC.ID_ACTIV INNER JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT MAC ON ACT.ID_ACTIV = MAC.ID_ACTIV INNER JOIN
                                      PRDDBFCOMERCIAL.MENUGEN MEN ON MEN.ID_MENUGEN = MAC.ID_MENUGEN
                                      WHERE RAC.ID_ROL = ? AND RAC.ESTADO = 1 ORDER BY MEN.ID_MENUGEN",array($rol));
      return $query->result_array();
    }

    public function get_actividades_x_menu($menu,$rol){
      $query = $this->oracle->query("SELECT ACT.* FROM PRDDBFCOMERCIAL.ACTIVIDADES ACT JOIN
                                      PRDDBFCOMERCIAL.ROL_ACT RAC ON RAC.ID_ACTIV = ACT.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT MACT ON ACT.ID_ACTIV =  MACT.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN  MEN ON MACT.ID_MENUGEN =  MEN.ID_MENUGEN WHERE MEN.ID_MENUGEN = ? AND RAC.ID_ROL = ? AND RAC.ESTADO = 1",array($menu,$rol));
      return $query->result_array();
    }

    public function get_actividades_x_menu1($menu){
      $query = $this->oracle->query("SELECT ACT.* FROM PRDDBFCOMERCIAL.ACTIVIDADES ACT JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT MACT ON ACT.ID_ACTIV =  MACT.ID_ACTIV JOIN
                                      PRDDBFCOMERCIAL.MENUGEN  MEN ON MACT.ID_MENUGEN =  MEN.ID_MENUGEN WHERE MEN.ID_MENUGEN = ? ",array($menu));
      return $query->result_array();
    }

    public function get_one_rol($rol){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ROLES WHERE ID_ROL = ? ",array($rol));
      return $query->row_array();
    }

    public function get_all_menus(){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.MENUGEN");
      return $query->result_array();
    }

    public function get_actividades_x_menu_x_rol($menu,$rol){
      $query = $this->oracle->query("SELECT ACT.* FROM PRDDBFCOMERCIAL.ACTIVIDADES ACT INNER JOIN
                                      PRDDBFCOMERCIAL.ROL_ACT RAC ON  ACT.ID_ACTIV = RAC.ID_ACTIV INNER JOIN
                                      PRDDBFCOMERCIAL.ROLES ROL ON RAC.ID_ROL = ROL.ID_ROL INNER JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT  MAN ON ACT.ID_ACTIV = MAN.ID_ACTIV
                                      WHERE ROL.ROLDESC = ? AND MAN.ID_MENUGEN = ? AND RAC.ESTADO = 1 ORDER BY ACT.ID_ACTIV",array($rol,$menu));
      return $query->result_array();
    }

    public function get_one_actividad($id){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ACTIVIDADES WHERE ID_ACTIV = ?",array($id));
      return $query->row_array();
    }

    public function get_rol_nombre($nombre){
      $query = $this->oracle->query("SELECT ROLDESC FROM PRDDBFCOMERCIAL.ROLES WHERE ROLDESC like '%".$nombre."%' ");
      return $query->row_array()['ROLDESC'];
    }

    public function guardar_rol($actividades,$rol){
      $this->oracle->trans_begin();
      $query1 = $this->oracle->query("SELECT ID_ROL FROM PRDDBFCOMERCIAL.ROLES ORDER BY ID_ROL DESC");
      $siguiente = intval($query1->row_array()['ID_ROL']) + 1 ;
      $query = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.ROLES (ID_ROL,ROLDESC,ROLFECH) VALUES (?,?,?)",array($siguiente,$rol,date('d/m/Y')));
      if(!$query){
        $this->oracle->trans_rollback();
        return false;
      }
      foreach ($actividades as $act) {
        $query3 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.ROL_ACT (ID_ROL,ID_ACTIV,ESTADO) VALUES (?,?,?)",array($siguiente,$act,1));
        if(!$query3){
          $this->oracle->trans_rollback();
          return false; break;
        }
      }
      $this->oracle->trans_commit();
      return true;
    }

    public function get_rol_nombre1($nombre){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ROLES WHERE ROLDESC = ?  ",array($nombre));
      return $query->row_array();
    }

    public function update_rol($actividades,$actividades1,$rol){
      $this->oracle->trans_begin();
      $rol_update = $this->get_rol_nombre1($rol);
      if($actividades1 != NULL){
      foreach ($actividades1 as $value) {
          $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.ROL_ACT SET ESTADO = 0 WHERE ID_ROL = ?  AND ID_ACTIV = ? ",array($rol_update['ID_ROL'],$value));
          if(!$query){
            $this->oracle->trans_rollback();
            return false; break;
          }
      }
    }

    if($actividades != NULL){
      foreach ($actividades as $value) {
          $query2 = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.ROL_ACT WHERE ID_ROL = ?  AND ID_ACTIV = ?",array($rol_update['ID_ROL'],$value));
          if($query2->num_rows()>0){
            $query3 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.ROL_ACT SET ESTADO = 1 WHERE ID_ROL = ?  AND ID_ACTIV = ? ",array($rol_update['ID_ROL'],$value));
            if(!$query3){
              $this->oracle->trans_rollback();
              return false; break;
            }
          } else {
            $query3 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.ROL_ACT (ID_ROL,ID_ACTIV,ESTADO) VALUES (?,?,?)",array($rol_update['ID_ROL'],$value,1));
            if(!$query3){
              $this->oracle->trans_rollback();
              return false; break;
            }
          }
      }
    }
      $this->oracle->trans_commit();
      return true;
    }
}
