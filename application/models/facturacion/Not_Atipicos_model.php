<?php

class Not_Atipicos_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }
   
    public function Get_Suministro($periodo, $ciclos){
       $i = 0;
      $cadena_ciclo = '';
      while ($i < count($ciclos)) {
        if($i == 0){
          $cadena_ciclo = $cadena_ciclo."CICLO =".$ciclos[$i];
        }else{
          $cadena_ciclo = $cadena_ciclo."OR CICLO =".$ciclos[$i];
        }
        $i++;
      }
      $this->load->database();
      $query = $this->db->query("SELECT NOMBRE, CICLO, PERIODO, URBANIZAC, CALLE, CLIMUNNRO, CLICODFAC, LECTURA, CONZUMO, ESTADO, MARCA, MEDCODYGO FROM PRDDBFCOMERCIAL.ATIPICOS WHERE PERIODO =".$periodo." AND (".$cadena_ciclo.") ORDER BY CICLO asc");
      return $query->result_array();
      
     
    }
    
   
}

?>