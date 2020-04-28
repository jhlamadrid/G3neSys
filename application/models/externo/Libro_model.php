<?php
class Libro_model extends CI_Model {
  function __construct() {
    parent::__construct();
    $this->oracle = $this->load->database('oracle', TRUE);
    $this->oracle->save_queries = false;
  }

  public function obtenerOficinas(){
    $query = $this->oracle->query("SELECT OFIDES, OFICOD FROM PRDDBFCOMERCIAL.CEMPRES1 WHERE OFICOD_GENESYS IS NOT NULL");
    return $query->result_array();
  }

  public function obtenerTipDoc(){
      $query = $this->oracle->query("SELECT TIPDOCCOD, TIPDOCDESC FROM PRDDBFCOMERCIAL.TIPDOC");
      return $query->result_array();
  }

  public function buscarDNI($tipo, $numero){
    $query = $this->oracle->query("SELECT LUSRCOD, NOMBRE, APEPAT, APEMAT, DOMICILIO, NROCELULAR, EMAIL FROM PRDDBFCOMERCIAL.LOBSUSR WHERE TIPDOCCOD = ? AND NRODOC = ?", array($tipo, $numero));
    return $query->row_array();
  }

  public function guardar_observacion($nombres, $apellidoP, $apellidoM, $numDoc, $tipoDoc, $domicilio, $celular, $email, $detalle, $oficina, $suministro){
    $query = $this->oracle->query('SELECT LUSRCOD FROM PRDDBFCOMERCIAL.LOBSUSR ORDER BY LUSRCOD DESC');
    $codigo = intval($query->row_array()['LUSRCOD']) + 1;
    $query = $this->oracle->query('INSERT INTO PRDDBFCOMERCIAL.LOBSUSR (LUSRCOD, NOMBRE, APEPAT, APEMAT, DOMICILIO, NROCELULAR, EMAIL, TIPDOCCOD, NRODOC) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                                  array($codigo, strtoupper ($nombres), strtoupper ($apellidoP),strtoupper ( $apellidoM), strtoupper ($domicilio), $celular, $email, $tipoDoc, $numDoc));
    $query = $this->oracle->query('SELECT LOBSCOD FROM PRDDBFCOMERCIAL.LOBSERVACIONES ORDER BY LOBSCOD DESC ');
    $codigo1 = intval($query->row_array()['LOBSCOD']) + 1; 
    $query = $this->oracle->query('SELECT CODIGO FROM PRDDBFCOMERCIAL.LOBSERVACIONES WHERE ANIO = ? ORDER BY CODIGO DESC', array(date('Y')));
    $codigo_ = intval($query->row_array()['CODIGO']) + 1;
    $query = $this->oracle->query('INSERT INTO PRDDBFCOMERCIAL.LOBSERVACIONES (LOBSCOD, CODIGO, FECREG, HRAREG, DETALLE, ESTADO, LUSRCOD, ANIO, OFICOD, CLICODFAC) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($codigo1, $codigo_, date('d/m/Y'), date('H:i:s'), $detalle, 1, $codigo, date('Y'), $oficina, $suministro));
    return $codigo1;
  }

  public function guardar_observacion1($detalle, $codigo, $oficina, $suministro){
    $query = $this->oracle->query('SELECT LOBSCOD FROM PRDDBFCOMERCIAL.LOBSERVACIONES ORDER BY LOBSCOD DESC ');
    $codigo1 = intval($query->row_array()['LOBSCOD']) + 1;
    
    $query = $this->oracle->query('SELECT CODIGO FROM PRDDBFCOMERCIAL.LOBSERVACIONES WHERE ANIO = ? ORDER BY CODIGO DESC', array(date('Y')));
    $codigo_ = intval($query->row_array()['CODIGO']) + 1;
    
    $query = $this->oracle->query('INSERT INTO PRDDBFCOMERCIAL.LOBSERVACIONES (LOBSCOD, CODIGO, FECREG, HRAREG, DETALLE, ESTADO, LUSRCOD, ANIO, OFICOD, CLICODFAC) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($codigo1, $codigo_, date('d/m/Y'), date('H:i:s'), $detalle, 1, $codigo, date('Y'), $oficina, $suministro));
    return $codigo1;
  }

  public function obtener_observacion($codigo){
    $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.LOBSERVACIONES INNER JOIN PRDDBFCOMERCIAL.LOBSUSR ON LOBSERVACIONES.LUSRCOD = LOBSUSR.LUSRCOD 
                                    INNER JOIN PRDDBFCOMERCIAL.CEMPRES1 ON LOBSERVACIONES.OFICOD = CEMPRES1.OFICOD
                                  WHERE  LOBSCOD = ?', array($codigo));
    return $query->row_array();
  }

  public function buscarObs($tipo, $numero){
    $query = $this->oracle->query('SELECT * FROM PRDDBFCOMERCIAL.LOBSERVACIONES INNER JOIN PRDDBFCOMERCIAL.LOBSUSR ON LOBSERVACIONES.LUSRCOD = LOBSUSR.LUSRCOD 
                                    INNER JOIN PRDDBFCOMERCIAL.CEMPRES1 ON LOBSERVACIONES.OFICOD = CEMPRES1.OFICOD
                                  WHERE TIPDOCCOD = ? AND NRODOC = ?', array($tipo, $numero));
    return $query->result_array();
  }

}