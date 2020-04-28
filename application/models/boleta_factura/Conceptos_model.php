<?php

class Conceptos_model extends CI_MODEL {

    var $oracle;
	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function get_conceptos(){

        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT FACCONCOD, FACCONDES, FACIGVCOB, FACCONTAB, ESTADO FROM PRDDBFCOMERCIAL.CONCEP");
        $conceptos = $query->result_array();

        return $conceptos;
    }

    public function get_conceptos_filtrados($valor){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT FACCONCOD, FACCONDES, FACIGVCOB, FACCONTAB, ESTADO FROM PRDDBFCOMERCIAL.CONCEP WHERE ESTADO = ". $valor);
        $conceptos = $query->result_array();
        return $conceptos;
    }

    public function Existe_concepto($concep_codigo){
        $db_prueba = $this->load->database('oracle', TRUE);
        $query = $db_prueba->query("SELECT * FROM PRDDBFCOMERCIAL.CONCEP WHERE FACCONCOD = ". $concep_codigo);
        $conceptos = $query->result_array();
        return $conceptos;
    }

    public function Guarda_concepto($concep_codigo, $concep_precio, $concep_codigo_contable, $descripcion, $afecta_tipo, $Gratuito,$gravado,$exonerado,$inafecto,$Estado_concepto){
        $db_prueba = $this->load->database('oracle', TRUE);
        $consulta = "INSERT INTO PRDDBFCOMERCIAL.CONCEP  (FACCONCOD, FACCONDES, PRECIO, FACIGVCOB, FACCONTAB, FACFECHA, SERVIDOR, ESTADO, GRATUITO, EXONERADO, INAFECTO ) 
                    VALUES (".$concep_codigo.",'".$descripcion."',".$concep_precio.",'".$gravado ."',".$concep_codigo_contable.",". "TO_CHAR(SYSDATE,'DD-MON-YYYY')".",". "'TRUJILLO'".",".$Estado_concepto.",".$Gratuito.",".$exonerado.",".$inafecto." )";
        $query = $db_prueba->query($consulta);
        return $query; 
    }

    public function Guarda_edicion_concepto($concep_codigo, $concep_precio, $concep_codigo_contable, $descripcion, $afecta_tipo, $Gratuito,$gravado,$exonerado,$inafecto,$Estado_concepto){
        $db_prueba = $this->load->database('oracle', TRUE);
        $consulta = "UPDATE PRDDBFCOMERCIAL.CONCEP SET 
                    FACCONDES = '".$descripcion."',
                    PRECIO = ".$concep_precio.",
                    FACIGVCOB = '".$gravado."',
                    FACCONTAB = ".$concep_codigo_contable.",
                    FACFECHA = TO_CHAR(SYSDATE,'DD-MON-YYYY') ,
                    ESTADO = ".$Estado_concepto.",
                    GRATUITO = ".$Gratuito.",
                    EXONERADO = ".$exonerado.",
                    INAFECTO = ".$inafecto."
                    WHERE
                    FACCONCOD = ".$concep_codigo;
        $query = $db_prueba->query($consulta);
        return $query; 
    }

}

?>