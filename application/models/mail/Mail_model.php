<?php

class Mail_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
   
    public function get_datos($mes,$anio,$ciclo){
      if ($ciclo ==0) {
          $query = $this->db->query("SELECT /*+ USE_HASH(PM,RF) */ RF.PERIODO, 
                                RF.CLICODFAX, 
                                RF.CLINOMBRE, 
                                trim(RF.DESURBA) || ' ' || trim(DESCALLE) || ' ' || trim(RF.NUMERO) DIRECCION_CLIENTE, 
                                PM.CORREO, 
                                RF.FCICLO, 
                                CASE WHEN TRIM(RF.CLASE) IS NULL THEN 'NORMAL' 
                                ELSE 'ESPECIAL' END AS CLASE, 
                                RF.FACSERNRO, 
                                RF.FACNRO, 
                                'https://dcsvpsws02.sedalib.com.pe/GeneSys/RECIBO_MAIL/".$anio.$mes."/' || RF.RECTOKEN URL, 
                                TO_DATE(sysdate, 'dd/mm/yyyy') FECHA 
                                FROM PRDDBFCOMERCIAL.REPFACIMP RF 
                                INNER JOIN PRDDBFCOMERCIAL.PROPIE_MAIL PM 
                                ON TRIM (RF.CLICODFAX) = TRIM (PM.CLICODFAC) 
                                WHERE RF.PERIODO =".$anio.$mes." 
                                ORDER BY PM.CLICODFAC");
      }else{
        $query = $this->db->query("SELECT /*+ USE_HASH(PM,RF) */ RF.PERIODO, 
                                RF.CLICODFAX, 
                                RF.CLINOMBRE, 
                                trim(RF.DESURBA) || ' ' || trim(DESCALLE) || ' ' || trim(RF.NUMERO) DIRECCION_CLIENTE, 
                                PM.CORREO, 
                                RF.FCICLO, 
                                CASE WHEN TRIM(RF.CLASE) IS NULL THEN 'NORMAL' 
                                ELSE 'ESPECIAL' END AS CLASE, 
                                RF.FACSERNRO, 
                                RF.FACNRO, 
                                'https://dcsvpsws02.sedalib.com.pe/GeneSys/RECIBO_MAIL/".$anio.$mes."/' || RF.RECTOKEN URL, 
                                TO_DATE(sysdate, 'dd/mm/yyyy') FECHA 
                                FROM PRDDBFCOMERCIAL.REPFACIMP RF 
                                INNER JOIN PRDDBFCOMERCIAL.PROPIE_MAIL PM 
                                ON TRIM (RF.CLICODFAX) = TRIM (PM.CLICODFAC) 
                                WHERE RF.PERIODO =".$anio.$mes." AND RF.FCICLO = ".$ciclo."
                                ORDER BY PM.CLICODFAC");
      }
      
        return $query->result_array();
    }

    public function get_ciclos(){
        $query = $this->db->query("SELECT FACCICCOD,FACCICDES FROM PRDDBFCOMERCIAL.CICLOS");
        return $query->result_array();
    }
   
}

?>