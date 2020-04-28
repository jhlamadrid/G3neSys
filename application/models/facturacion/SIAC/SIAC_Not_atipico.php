<?php

class SIAC_Not_atipico extends CI_Model {

    function __construct() {
        parent::__construct();
    }
   
    public function Inspectores($ciclos){
      $i = 0;
      $cadena_ciclo = '';
      while ($i < count($ciclos)) {
        if($i == 0){
          $cadena_ciclo = $cadena_ciclo.' "IprdCic"= \''.$ciclos[$i].'\'';
        }else{
          $cadena_ciclo = $cadena_ciclo.' OR "IprdCic"= \''.$ciclos[$i].'\'';
        }
        $i++;
      }
      $this->db_b = $this->load->database('pg', TRUE);
  	  $query = $this->db_b->query('SELECT "IprdDni" AS "DNI","IprdIprId" AS "ID_INSPECTOR","IprdNom" AS "NOMBRE",
                                    "IprdCic" as "SUBCICLO","IprdFch","IprdEli","IprdCntId" FROM "Inspectores_disponibles"
                                    WHERE "IprdFch"=\'2017-10-04\' AND "IprdEli" IS NOT TRUE  AND ('.$cadena_ciclo.') ORDER BY "IprdCic" asc ');
	    return $query->result_array();
    }

    public function Fecha_notificacion_Atipico( $periodo, $ciclo,$suministro){
      $this->db_b = $this->load->database('pg', TRUE);
      $query = $this->db_b->query('SELECT "InoFchMinIns" AS "Fecha_Inicio", "InoFchMaxIns" AS "Fecha_Fin" , "InoSacId" AS "ciclo" ,"InoSum" AS  "suministro" , "InoPreLoc" AS "provincia" , "InoPreUrb" as "distrito" FROM "Suborden_inspecciones" AS "sub" INNER JOIN "Inspeccion_otra" AS "ins" ON "sub"."SoinId" = "ins"."InoSoinId"
          WHERE "InoPerd" = \''.$periodo.'\' AND "InoPreCic" = \''.$ciclo.'\'  AND  "InoSum" = \''.$suministro.'\'  AND  "InoSacId" = \'9\' AND "SoinTipIns" = \'79\' AND "SoinTipId" = \'16\'');
      return $query->result_array();
    }

    public function Image_Lectura_Atipico($anio, $mes, $ciclo,$sumi){

      $this->db_b = $this->load->database('pg', TRUE);
      $query = $this->db_b->query('SELECT "RlecCodFc" as "suministro","LecFchRgMov" as "fecha_lectura","LecImg" as "ruta_img1","GprCod" as "Subciclo"
                  FROM "Relectura" 
                  JOIN "Suborden_relectura" ON "RlecSorlId" = "SorlId"
                  JOIN "Orden_trabajo_relectura" on "SorlOrelId"="OrelId"
                  JOIN "Lectura" ON "LecCodFc"="RlecCodFc" AND "LecEli" IS FALSE
                  JOIN "Suborden_lectura" ON "SolId"="LecSolId" AND "SolTipId"=16 AND "SolEli" IS FALSE
                  JOIN "Orden_trabajo" ON "SolOrtId" = "OrtId"
                  JOIN "Periodo" ON "OrtPrdId"="PrdId"
                  JOIN "Grupo_predio" ON "LecGprId"="GprId"
                  WHERE "RlecEli" = FALSE AND "LecImg" IS NOT NULL 
                  AND "LecQCImg"=TRUE  AND "PrdAni"=\''.$anio.'\' AND "PrdOrd"=\''.$mes.'\' AND  "GprCod"=\''.$ciclo.'\' AND "RlecCodFc" = \''.$sumi.'\'
                  AND "OrelEli" IS FALSE AND "SolOrtId" = "OrelOrtId"
                  ORDER BY "RlecId"');
      
      return $query->result_array();
    }
    
}

?>