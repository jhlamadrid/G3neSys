<?php

class Usuarios_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_last_user(){
      $query = $this->oracle->query('SELECT * FROM (SELECT * FROM PRDDBFCOMERCIAL.NUSERS WHERE NESTADO = 1 ORDER BY NFECHAE DESC) WHERE ROWNUM < 9');
      return $query->result_array();
    }

    public function get_all_user(){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.NUSERS ORDER BY NFECHAE DESC');
      return $query->result_array();
    }

    public function get_one_user($codigo){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.NUSERS WHERE NCODIGO = ?', array($codigo));
      return $query->row_array();
    }

    public function get_oficinas(){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.OFICIN WHERE OFESTA = 1 ORDER BY OFICOD');
      return $query->result_array();
    }

    public function get_areas($oficina){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.AGENCI WHERE OFICIN_OFICOD = ? AND AGESTA = 1',array($oficina));
      return $query->result_array();
    }

    public function get_estados(){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.TESTAPERM');
      return $query->result_array();
    }

    public function save_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,$rol,$fichero){
      $nsempcod = 0;
      $nsoficod = 0;
      if($userOfi == 10 && $userArea == 6){
        $nsempcod = 1;
        $nsoficod = 1;
      } elseif ($userOfi == 13 && $userArea == 0){
        $nsempcod = 1;
        $nsoficod = 2;
      } elseif ($userOfi == 13 && $userArea == 3) {
        $nsempcod = 1;
        $nsoficod = 3;
      }  elseif ($userOfi == 12 && $userArea == 4) {
        $nsempcod = 1;
        $nsoficod = 4;
      }  elseif ($userOfi == 12 && $userArea == 2) {
        $nsempcod = 1;
        $nsoficod = 5;
      } elseif ($userOfi == 12 && $userArea == 3) {
        $nsempcod = 1;
        $nsoficod = 6;
      } elseif ($userOfi == 13 && $userArea == 1) {
        $nsempcod = 1;
        $nsoficod = 7;
      } elseif ($userOfi == 13 && $userArea == 5) {
        $nsempcod = 1;
        $nsoficod = 8;
      } elseif ($userOfi == 13 && $userArea == 2) {
        $nsempcod = 1;
        $nsoficod = 9;
      } elseif ($userOfi == 21 && $userArea == 0) {
        $nsempcod = 1;
        $nsoficod = 10;
      } elseif ($userOfi == 12 && $userArea == 0) {
        $nsempcod = 1;
        $nsoficod = 11;
      }elseif ($userOfi == 21 && $userArea == 2) {
        $nsempcod = 1;
        $nsoficod = 13;
      }
      $query3 = $this->oracle->query("SELECT LOGIN FROM PRDDBFCOMERCIAL.NUSERS WHERE LOGIN = ? ",array($userLog));
      if($query3->row_array()['LOGIN'] == NULL){
      $this->oracle->trans_begin();
      $query = $this->oracle->query('SELECT NCODIGO FROM PRDDBFCOMERCIAL.NUSERS ORDER BY NCODIGO DESC');
      $id = intval($query->row_array()['NCODIGO']) + 1;
      $query = $this->oracle->query('INSERT INTO PRDDBFCOMERCIAL.NUSERS("NCODIGO","NNOMBRE","NDIRECC","NTELEFO","NDNI","NCLAVE","LOGIN","OFICOD","OFIAGECOD","NESTADO","NFECHAE","NENDS", "NSEMPCOD", "NSOFICOD")
                                     VALUES (?,?,?,?,?,?,?,?,?,?,?,?, ?, ?)',array($id,$userNom,$userDir,$userCel,$userDni,$psw,$userLog,$userOfi,$userArea,$userEst,$userIni,$userfin,$nsempcod, $nsoficod));
       if(!$query){
         $this->oracle->trans_rollback();
         return array('result' => false,'mensaje' =>'NO SE PUDO CREAR EL NUEVO USUARIO');
       } 
       $query2 = $this->oracle->query('INSERT INTO PRDDBFCOMERCIAL.USER_ROL (NCODIGO,ID_ROL,ESTADO) VALUES (?,?,?)',array($id,$rol,$userEst));
       if(!$query2){
         $this->oracle->trans_rollback();
         return array('result' => false, 'mensaje'  => 'NO SE PUEDE CREAR EL NUEVO ROL');
       }
       if($fichero != NULL){
         $query4 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NUSERS SET RUTIMAGEN = ? WHERE NCODIGO = ? ",array($fichero,$id));
         if(!$query4){
           $this->oracle->trans_rollback();
           return array('result' => false, 'mensaje'  => 'NO SE PUEDE ALAMCENAR LA IMAGEN');
         }
       }
       $this->oracle->trans_commit();
       return array('result' => true, 'mensaje' => 'OK');
     } else {
       return array('result' => false ,'mensaje' => 'EL LOGIN DEL USUARIO YA EXISTE');
     }
    }

    public function get_all_usuarios($key){
      $query = $this->oracle->query("SELECT * FROM TESTPRDGESTIONCOMERCIAL.MUSUARIO WHERE USRNOM LIKE '%".$key."%'");
      return $query->result_array();
    }

    public function get_one_user_comercial($id){
      $query = $this->oracle->query("SELECT * FROM TESTPRDGESTIONCOMERCIAL.MUSUARIO WHERE USRCOD = ? ",array($id));
      return $query->row_array();
    }

    public function get_roles(){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.ROLES');
      return $query->result_array();
    }

    public function get_actividades_x_rol($rol){
      $query  = $this->oracle->query("SELECT DISTINCT MEN.* FROM PRDDBFCOMERCIAL.ACTIVIDADES ACT INNER JOIN
                                      PRDDBFCOMERCIAL.ROL_ACT RAC ON ACT.ID_ACTIV = RAC.ID_ACTIV INNER JOIN
                                      PRDDBFCOMERCIAL.MENUGEN_ACT MAC ON ACT.ID_ACTIV = MAC.ID_ACTIV INNER JOIN
                                      PRDDBFCOMERCIAL.MENUGEN MEN ON MEN.ID_MENUGEN = MAC.ID_MENUGEN
                                      WHERE RAC.ID_ROL = ? ORDER BY MEN.ID_MENUGEN",array($rol));
      return $query->result_array();
    }

    public function get_actividades_x_menu($id){
      $query = $this->oracle->query("SELECT ACT.* FROM PRDDBFCOMERCIAL.ACTIVIDADES ACT JOIN
                                    PRDDBFCOMERCIAL.MENUGEN_ACT MACT ON ACT.ID_ACTIV =  MACT.ID_ACTIV JOIN
                                    PRDDBFCOMERCIAL.MENUGEN  MEN ON MACT.ID_MENUGEN =  MEN.ID_MENUGEN WHERE MEN.ID_MENUGEN = ? ",array($id));
      return $query->result_array();
    }

    //nuevo codigo
    public function get_one_usuario($user){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NUSERS  WHERE NCODIGO = ? ",array($user));
      return $query->row_array();
    }

    public function update_user($userNom,$userDir,$userCel,$userDni,$userLog,$userOfi,$userArea,$userIni,$userfin,$psw,$userEst,$codigo,$rol,$fichero){
        $nsempcod = 0;
        $nsoficod = 0;
        if($userOfi == 10 && $userArea == 6){
          $nsempcod = 1;
          $nsoficod = 1;
        } elseif ($userOfi == 13 && $userArea == 0){
          $nsempcod = 1;
          $nsoficod = 2;
        } elseif ($userOfi == 13 && $userArea == 3) {
          $nsempcod = 1;
          $nsoficod = 3;
        }  elseif ($userOfi == 12 && $userArea == 4) {
          $nsempcod = 1;
          $nsoficod = 4;
        }  elseif ($userOfi == 12 && $userArea == 2) {
          $nsempcod = 1;
          $nsoficod = 5;
        } elseif ($userOfi == 12 && $userArea == 3) {
          $nsempcod = 1;
          $nsoficod = 6;
        } elseif ($userOfi == 13 && $userArea == 1) {
          $nsempcod = 1;
          $nsoficod = 7;
        } elseif ($userOfi == 13 && $userArea == 5) {
          $nsempcod = 1;
          $nsoficod = 8;
        } elseif ($userOfi == 13 && $userArea == 2) {
          $nsempcod = 1;
          $nsoficod = 9;
        } elseif ($userOfi == 21 && $userArea == 0) {
          $nsempcod = 1;
          $nsoficod = 10;
        } elseif ($userOfi == 12 && $userArea == 0) {
          $nsempcod = 1;
          $nsoficod = 11;
        }elseif ($userOfi == 21 && $userArea == 2) {
          $nsempcod = 1;
          $nsoficod = 13;
        }
        $this->oracle->trans_begin();
        $query = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NUSERS SET NNOMBRE = ?, NCLAVE = ?, NDIRECC = ?, NTELEFO = ?, NDNI = ?, LOGIN = ?,OFICOD = ?,
                                      OFIAGECOD = ?, NESTADO = ?, NFECHAE = ?,NENDS = ?, NSEMPCOD = ?, NSOFICOD = ?  WHERE NCODIGO = ?",
                                      array($userNom, $psw, $userDir, $userCel, $userDni, $userLog, $userOfi, 
                                      $userArea, $userEst,$userIni,$userfin, $nsempcod, $nsoficod, $codigo));
        if(!$query){
          $this->oracle->trans_rollback();
           return array('result' => false,'mensaje' =>'NO SE PUDO CREAR EL NUEVO USUARIO');
        }
        $query3 = $this->oracle->query("SELECT ID_ROL FROM PRDDBFCOMERCIAL.USER_ROL WHERE NCODIGO = ?",array($codigo));
        if($query3->row_array()['ID_ROL']){
          $query2 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.USER_ROL SET ID_ROL = ?, ESTADO = ? WHERE NCODIGO = ?", array($rol,$userEst,$codigo));
          if(!$query2){
            $this->oracle->trans_rollback();
            return array('result' => false, 'mensaje'  => 'NO SE PUEDE CREAR EL NUEVO ROL');
          }
        } else {
          $query2 = $this->oracle->query("INSERT INTO PRDDBFCOMERCIAL.USER_ROL (NCODIGO,ID_ROL,ESTADO) VALUES (?,?,?)",array($codigo,$rol,$userEst));
          if(!$query2){
            $this->oracle->trans_rollback();
            return array('result' => false, 'mensaje'  => 'NO SE PUEDE CREAR EL NUEVO ROL');
          }
        }
        if($fichero != NULL){
          $query4 = $this->oracle->query("UPDATE PRDDBFCOMERCIAL.NUSERS SET RUTIMAGEN = ? WHERE NCODIGO = ? ",array($fichero,$codigo));
          if(!$query4){
            $this->oracle->trans_rollback();
            return array('result' => false, 'mensaje'  => 'NO SE PUEDE ALAMCENAR LA IMAGEN');
          }
        }
        $this->oracle->trans_commit();
        return array('result' => true, 'mensaje' => 'OK');
    }

    public function validate_user($login){
      $query = $this->oracle->query("SELECT * FROM PRDDBFCOMERCIAL.NUSERS  WHERE LOGIN = ?",array($login));
      return $query->row_array();
    }

    public function get_one_rol($codigo){
      $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.USER_ROL WHERE NCODIGO = ?',array($codigo));
      return $query->row_array();
    }

}
