<?php

class Administracion_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_dato_general($suministro,$periodo){
        $query = $this->db->query("select   ROWNUM,BARCOD, PORDESEXC,CLINOMBRE, CONREALMED, VOLFAC ,CLIELECT,".
                                  "CLIRUC ,PERIODO,CLICODFAX,DESCALLE,DESURBA,DESMES,FACEMIFEC,FECACT,FECANT,".
                              " FMEDIDOR,DESIMPORTE,CONSUMO,FSETIPCOD, TIPIMP , DESCRIREG ,OBSLEC, FACVENFEC,
                                CON01,CON02,CON03,CON04,CON05,CON06,CON07,CON08,CON09,CON10,CON11,CON12,CON13,".
                              "MES01,MES02,MES03,MES04,MES05,MES06,MES07,MES08,MES09,MES10,MES11,MES12,MES13,FACTOTAL,".
                              " FACSALDO,HORARIO,FGRUCOD,FGRUSUB,HORABS,FCICLO,DXSEM,PRECICFAC, LECACT,
                                LECANT,FACNRO,FACSERNRO,FACTARIFA,FACCHEDIG,CODCIM,
                                NUMERO,CARGARD,DESPREM,SUBTOT_ANT,ORDENRD,".
                             " DESFH ,MENSAJE2,MENSAJE,FACTOTSUB,FACIGV,REDONACT,REDONANT,".
                             " MENSCORTES,FACCICCOR,MENSCORTES,DESLOCAL FROM PRDDBFCOMERCIAL.REPFACIMP  WHERE CLICODFAX=".$suministro."AND PERIODO=".$periodo);
        return $query->result_array();
    }
    
     public function get_dato_detalle($numero_recibo,$serie_recibo){
    $query = $this->db->query("select FACLINRO,DESCONCEP,IMPPRIRANG,IMPSEGRANG,IMPTERRANG,FACPRECI,REPFACIMP_FACNRO,REPFACIMP_FACSERNRO FROM PRDDBFCOMERCIAL.REPLINIMP WHERE REPFACIMP_FACNRO=".$numero_recibo.
			                 " AND REPFACIMP_FACSERNRO= ".$serie_recibo);
        return $query->result_array();
    }
    
}