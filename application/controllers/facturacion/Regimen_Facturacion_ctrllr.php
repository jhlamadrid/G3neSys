<?php

class Regimen_Facturacion_ctrllr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('acceso/Usuario_model');
        $this->load->model('facturacion/Regimen_Facturacion_model');
        $this->load->library('session');
        $this->load->library('acceso_cls');
        $this->data['menuG'] = $this->acceso_cls->findMenu($_SESSION['user_id']);
        $this->acceso_cls->isLogin();
        $this->data['userdata'] = $this->acceso_cls->get_userdata();
        $this->data['proceso'] = 'Regimen Facturación';
        $this->data['menu']['padre'] = 'facturacion';
        $this->data['menu']['hijo'] = 'regimenes';
    }

    public function ver_regimenes(){
        $variable = 0;
        foreach($_SESSION['ACTIVIDADES'] as $GRP1){
            if($GRP1['MENUGENDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'REGIMEN'){
                if($this->input->server('REQUEST_METHOD') == 'POST'){
                    $estado = $this->input->post('estados');
                    $FchIn = $this->input->post('FchIn');
                    $FchFn = $this->input->post('FchFn');
                    $oficina = $this->input->post('oficinas');
                    $suministro = $this->input->post('suministro');
                    $this->data['reclamos'] = $this->Regimen_Facturacion_model->resultado($estado,$FchIn,$FchFn,$oficina,$suministro);
                    $this->data['cantidad_regimenes'] = $this->Regimen_Facturacion_model->get_cantidad_regimenes1($estado,$FchIn,$FchFn,$oficina,$suministro);
                    $this->data['ofi'] = $oficina;
                    $this->data['est'] = $estado;
                    $this->data['sumi'] = $suministro;
                    $this->data['FIn'] = $FchIn;
                    $this->data['FFn'] = $FchFn;
                } else {
                    $this->data['reclamos'] = $this->Regimen_Facturacion_model->get_reclamos();
                    $this->data['cantidad_regimenes'] = $this->Regimen_Facturacion_model->get_cantidad_regimenes();
                }
                $this->data['view'] = 'facturacion/Regimen_Facturacion_view';
                $this->data['estados'] = $this->Regimen_Facturacion_model->get_estados();
                $this->data['oficinas'] = $this->Regimen_Facturacion_model->get_oficinas();
                $this->data['breadcrumbs'] = array(array('Facturación', ''),array('Regimen de Facturación',''));
                $this->load->view('template/Master', $this->data);
                $variable = 1;
                break;
            }
        }
        if($variable == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    public function generar_regimen($variable){
        $variable1 = 0;
        foreach($_SESSION['ACTIVIDADES'] as $GRP1){
            if($GRP1['MENUGENDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'REGIMEN'){
                $valores = array(); // Array para almacenar los valores pasados
                $cadena = "";
                for($i = 0; $i < strlen($variable); $i++){
                    if(substr($variable,$i,1) != "-"){
                        $cadena = $cadena.substr($variable,$i,1);
                    } else {
                        array_push($valores,$cadena);
                        $cadena = "";
                    }
                }
                array_push($valores,$cadena);
                $this->data['tarifas'] = array();
                $tarifas_ambitos = array();
                $this->data['pk'] = $variable;
                $this->data['recibos'] = $this->Regimen_Facturacion_model->get_recibos($valores); //Obtenemos los recibos que se generarn sus regimen de faturación
                $this->data['num_reclamo'] = $valores[6];  //Almacena el número del Reclamo
                $this->data['suministro'] = $valores[7];  //Almacena el suministro del Cliente
                $this->data['horario'] = $this->Regimen_Facturacion_model->get_horario($valores[7]);
                if(strlen($valores[7]) == 7){
                    $codigos = $this->Regimen_Facturacion_model->getCodigo($valores[7]);
                    $grupo_1 = substr($codigos,0,3);
                    $sub_grupo = substr($codigos,3,4);
                    $this->data['unidades'] = $this->Regimen_Facturacion_model->get_unidades1($grupo_1,$sub_grupo);
                    //$suministro1 = substr($valores[7],0,3).'0000'.substr($valores[7],3,4);
                    $suministros_agrupado = $this->Regimen_Facturacion_model->get_suministros($grupo_1,$sub_grupo);
                    $predio = $this->Regimen_Facturacion_model->get_predio($grupo_1,$sub_grupo);
                    $ciclo_comercial = $this->Regimen_Facturacion_model->get_ciclo_comercial($predio['PREREGION'],$predio['PREZONA'],$predio['PRESECTOR'],$predio['PREMZN'],$predio['PRELOTE']);
                    foreach ($suministros_agrupado as $suministro3){
                      if(strlen($suministro3['CLICODFAC']) == 7){
                        $suministro_aux = substr($suministro3['CLICODFAC'],0,3).'0000'.substr($suministro3['CLICODFAC'],3,4);
                        array_push($tarifas_ambitos,$this->Regimen_Facturacion_model->get_tarifa_multiple($suministro_aux));
                      } else {
                        array_push($tarifas_ambitos,$this->Regimen_Facturacion_model->get_tarifa_multiple($suministro3['CLICODFAC']));
                      }
                    }
                    foreach ($tarifas_ambitos as $key ) {
                        array_push($this->data['tarifas'],$key['TARIFA']);
                    }
                    //$this->data['tarifa_multiple'] =  $this->Regimen_Facturacion_model->get_tarifa_multiple($suministro1);
                    $suministro_multiple =  $this->Regimen_Facturacion_model->get_suministro_multiple($codigos);
                } else {
                    $this->data['unidades'] = $this->Regimen_Facturacion_model->get_unidades($valores[7]);
                    $predio = $this->Regimen_Facturacion_model->get_predio1($valores[7]);
                    $ciclo_comercial = $this->Regimen_Facturacion_model->get_ciclo_comercial($predio['PREREGION'],$predio['PREZONA'],$predio['PRESECTOR'],$predio['PREMZN'],$predio['PRELOTE']);
                }
                $this->data['ciclo_comercial'] = $ciclo_comercial;
                $cabecera = array(); //Alamacena la cabecera de los recibos
                $periodos = array(); //Alamacena los periodos de los recibos
                $periodos_ayuda = array(); //Alamacena los periodos de los recibos
                $periodos_ayuda1 = array(); //Alamacena los periodos de los recibos
                $tipo_regimenes = array(); //Alamacena los tipos de regimenes
                $tipo_regimenes1 = array(); //Alamacena los tipos de regimenes
                $observaciones = array(); //Almacenas las observaciones de los recibos
                $consumos_validos = array(); //Almacenas los consumos validos
                $consumos_asignados = array(); //Almacenas los consumos asignados
                foreach($this->data['recibos'] as $recibo){
                    array_push($cabecera,$this->Regimen_Facturacion_model->get_datos($recibo['OFACSERNRO'],$recibo['OFACNRO']));
                }
                foreach($cabecera as $cabecera1){
                    array_push($periodos,$this->devolver_mes(substr($cabecera1['FACEMIFEC'],3,2))." ".substr($cabecera1['FACEMIFEC'],6,4));
                    array_push($periodos_ayuda,substr($cabecera1['FACEMIFEC'],6,4).substr($cabecera1['FACEMIFEC'],3,2));
                    array_push($periodos_ayuda1,$this->restar_fechas(substr($cabecera1['FACEMIFEC'],6,4),substr($cabecera1['FACEMIFEC'],3,2)));
                }
                foreach($periodos_ayuda as $periodo){
                    array_push($tipo_regimenes,$this->Regimen_Facturacion_model->get_tipo_regimenes($valores[7],$periodo));
                }
                foreach($periodos_ayuda1 as $periodo){
                    array_push($tipo_regimenes1,$this->Regimen_Facturacion_model->get_tipo_regimenes($valores[7],$periodo));
                    if(strlen($valores[7]) == 7){
                      foreach ($suministro_multiple as $suministro) {
                        $consumos = $this->Regimen_Facturacion_model->get_consumos($suministro,$periodo);
                        if($consumos != NULL){
                          array_push($consumos_validos,$consumos);
                          break;
                        }
                      }
                      if($consumos == NULL){
                        array_push($consumos_validos,$consumos);
                      }
                    } else {
                      array_push($consumos_validos,$this->Regimen_Facturacion_model->get_consumos($valores[7],$periodo));
                    }

                }
                foreach($tipo_regimenes as $regimen){
                    array_push($observaciones,$this->Regimen_Facturacion_model->get_observaciones($regimen['OBSLEC']));
                }
                $this->data['cabecera'] = $cabecera;
                $this->data['periodo'] = $periodos;
                $this->data['tipo_regimenes'] = $tipo_regimenes;
                $this->data['tipo_regimenes1'] = $tipo_regimenes1;
                $this->data['observaciones'] = $observaciones;
                $this->data['consumos_validos'] = $consumos_validos;

                $consumos =array();
                if(strlen($valores[7]) == 7){
                  foreach ($periodos_ayuda1 as $periodo ) {
                    $consumo = array();
                    foreach ($tarifas_ambitos as $key => $tarifa2 ) {
                      $asignado =  $this->Regimen_Facturacion_model->get_consumo_asignado_domestico($tarifa2['CLICODFAC'],$periodo);
                      if($tarifa2['TARIFA'] == 'D01'){
                        if($tarifa2['AMBCOD'] == 1){
                          if($asignado['DIASXSEMAN'] <= 4){
                            if($asignado['HORCNT'] < 5){
                              //$tarifas_ambitos[$key]['asignado'] = 8;
                              array_push($consumo,8);
                            }else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT'] <= 10){
                              //$tarifas_ambitos[$key]['asignado'] = 10;
                              array_push($consumo,10);
                            } else if($asignado['HORCNT'] > 10 ){
                              array_push($consumo,12);
                              //$tarifas_ambitos[$key]['asignado'] = 12;
                            }
                          } else if($asignado['DIASXSEMAN'] > 4){
                            if($asignado['HORCNT'] < 5){
                              array_push($consumo,10);
                              //$tarifas_ambitos[$key]['asignado'] = 10;
                            }else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT'] <= 10){
                              array_push($consumo,12);
                              //$tarifas_ambitos[$key]['asignado'] = 12;
                            } else if($asignado['HORCNT'] > 10 ){
                              array_push($consumo,19);
                              //$tarifas_ambitos[$key]['asignado'] = 19;
                            }
                          }
                        } else {
                          if($asignado['HORCNT'] < 5){
                            array_push($consumo,10);
                            //$tarifas_ambitos[$key]['asignado'] = 10;
                          } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT'] <= 10){
                            array_push($consumo,12);
                            //$tarifas_ambitos[$key]['asignado'] = 12;
                          } else {
                            array_push($consumo,19);
                            //$tarifas_ambitos[$key]['asignado'] = 19;
                          }
                        }
                      } else{
                       $CONSU =   $this->Regimen_Facturacion_model->get_consumo_asignado1($tarifa2['TARIFA']);
                       array_push($consumo,intval($CONSU));
                      //$tarifas_ambitos[$key]['asignado'] = $CONSU;
                      }
                    }
                    array_push($consumos,$consumo);
                    $consumo = array();
                  }
                } else {
                  if(intval($cabecera[0]['FAMBITO']) == 1){
                          if($cabecera[0]['FACTARIFA'] == "D01"){
                              $ayuda_asigandos = array();
                              foreach($periodos_ayuda1 as $periodo){
                                  array_push($ayuda_asigandos,$this->Regimen_Facturacion_model->get_consumo_asignado_domestico($valores[7],$periodo));
                              }
                              foreach($ayuda_asigandos as $asignado){
                                  if($asignado['DIASXSEMAN'] <= 4){
                                      if($asignado['HORCNT'] < 5){
                                          array_push($consumos_asignados,8);
                                      } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT']<= 10){
                                          array_push($consumos_asignados,10);
                                      } else {
                                          array_push($consumos_asignados,12);
                                      }

                                  } else {
                                      if($asignado['HORCNT'] < 5){
                                          array_push($consumos_asignados,10);
                                      } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT']<= 10){
                                          array_push($consumos_asignados,12);
                                      } else {
                                          array_push($consumos_asignados,19);
                                      }
                                  }
                              }
                          } else {
                              array_push($consumos_asignados,$this->Regimen_Facturacion_model->get_consumo_asignado($cabecera[0]['FACTARIFA'],$cabecera[0]['FAMBITO']));
                          }
                      } else {
                          if($cabecera[0]['FACTARIFA'] == "D01"){
                              $ayuda_asigandos = array();
                              foreach($periodos_ayuda1 as $periodo){
                                  array_push($ayuda_asigandos,$this->Regimen_Facturacion_model->get_consumo_asignado_domestico($valores[7],$periodo));
                              }
                              foreach($ayuda_asigandos as $asignado){
                                  if($asignado['HORCNT'] < 5){
                                      array_push($consumos_asignados,10);
                                  } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT']<= 10){
                                      array_push($consumos_asignados,12);
                                  } else {
                                      array_push($consumos_asignados,19);
                                  }
                              }
                          } else {
                            if(strlen($valores[7]) > 7){
                              array_push($consumos_asignados,$this->Regimen_Facturacion_model->get_consumo_asignado($cabecera[0]['FACTARIFA'],$cabecera[0]['FAMBITO']));
                            } else {
                              array_push($consumos_asignados,$this->Regimen_Facturacion_model->get_consumo_asignado1($this->data['tarifa_multiple']));
                            }
                          }
                      }
                }
                $this->data['consumos'] = $consumos;
                $this->data['consumos_asignados'] = $consumos_asignados;
                $this->data['view'] = 'facturacion/Regimen_view';
                $this->data['breadcrumbs'] = array(array('Regimines Facturacion','facturacion/ver_regimenes'),array('Regimen',''));
                $this->load->view('template/Master',$this->data);
                $variable1 = 1;
                break;
            }
        }
        if($variable1 == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    private function devolver_mes($cadena){
        switch($cadena){
            case "01": return "ENERO";break;
            case "02": return "FEBRERO";break;
            case "03": return "MARZO";break;
            case "04": return "ABRIL";break;
            case "05": return "MAYO";break;
            case "06": return "JUNIO";break;
            case "07": return "JULIO";break;
            case "08": return "AGOSTO";break;
            case "09": return "SETIEMBRE";break;
            case "10": return "OCTUBRE";break;
            case "11": return "NOVIEMBRE";break;
            case "12": return "DICIEMBRE";break;
        }
    }

    private function restar_fechas($fecha1,$fecha2){
        $valor = intval($fecha2) - 1;
        if($valor < 10 && $valor > 0){
            return $fecha1."0".$valor;
        } else if($valor == 0){
            $aux = intval($fecha1) - 1;
            return $aux."12";
        } else {
            return $fecha1.$valor;
        }
    }

    public function generar_pdf($variable){
        $variable1 = 0;
        foreach($_SESSION['ACTIVIDADES'] as $GRP1){
            if($GRP1['MENUGENDESC'] == 'REGIMEN DE FACTURACION' && $GRP1['ACTIVDESC'] == 'REGIMEN'){
                $valores = array(); // Array para almacenar los valores pasados
                $cadena = "";
                for($i = 0; $i < strlen($variable); $i++){
                    if(substr($variable,$i,1) != "-"){
                        $cadena = $cadena.substr($variable,$i,1);
                    } else {
                        array_push($valores,$cadena);
                        $cadena = "";
                    }
                }
                array_push($valores,$cadena);
                $this->data['pk'] = $variable;
                $this->data['recibos'] = $this->Regimen_Facturacion_model->get_recibos($valores); //Obtenemos los recibos que se generarn sus regimen de faturación
                $this->data['num_reclamo'] = $valores[6];  //Almacena el número del Reclamo
                $this->data['suministro'] = $valores[7];  //Almacena el suministro del Cliente
                $cabecera = array(); //Alamacena la cabecera de los recibos
                $periodos = array(); //Alamacena los periodos de los recibos
                $periodos_ayuda = array(); //Alamacena los periodos de los recibos
                $periodos_ayuda1 = array(); //Alamacena los periodos de los recibos
                $tipo_regimenes = array(); //Alamacena los tipos de regimenes
                $tipo_regimenes1 = array(); //Alamacena los tipos de regimenes
                $observaciones = array(); //Almacenas las observaciones de los recibos
                $consumos_validos = array(); //Almacenas los consumos validos
                $consumos_asignados = array(); //Almacenas los consumos asignados
                $horario = $this->Regimen_Facturacion_model->get_horario($valores[7]);
                $tarifas_ambitos = array();
                $tarifas = array();
                if(strlen($valores[7]) == 7){
                    $codigos = $this->Regimen_Facturacion_model->getCodigo($valores[7]);
                    $grupo_1 = substr($codigos,0,3);
                    $sub_grupo = substr($codigos,3,4);
                    $unidades = $this->Regimen_Facturacion_model->get_unidades1($grupo_1,$sub_grupo);
                    //$suministro1 = substr($valores[7],0,3).'0000'.substr($valores[7],3,4);
                    $suministros_agrupado = $this->Regimen_Facturacion_model->get_suministros($grupo_1,$sub_grupo);
                    $predio = $this->Regimen_Facturacion_model->get_predio($grupo_1,$sub_grupo);
                    $ciclo_comercial = $this->Regimen_Facturacion_model->get_ciclo_comercial($predio['PREREGION'],$predio['PREZONA'],$predio['PRESECTOR'],$predio['PREMZN'],$predio['PRELOTE']);
                    foreach ($suministros_agrupado as $suministro3){
                      if(strlen($suministro3['CLICODFAC']) == 7){
                        $suministro_aux = substr($suministro3['CLICODFAC'],0,3).'0000'.substr($suministro3['CLICODFAC'],3,4);
                        array_push($tarifas_ambitos,$this->Regimen_Facturacion_model->get_tarifa_multiple($suministro_aux));
                      } else {
                        array_push($tarifas_ambitos,$this->Regimen_Facturacion_model->get_tarifa_multiple($suministro3['CLICODFAC']));
                      }
                    }
                    foreach ($tarifas_ambitos as $key ) {
                        array_push($tarifas,$key['TARIFA']);
                    }

                    //$this->data['tarifa_multiple'] =  $this->Regimen_Facturacion_model->get_tarifa_multiple($suministro1);
                    $suministro_multiple =  $this->Regimen_Facturacion_model->get_suministro_multiple($codigos);
                } else {
                    $unidades = $this->Regimen_Facturacion_model->get_unidades($valores[7]);
                    $predio = $this->Regimen_Facturacion_model->get_predio1($valores[7]);
                    $ciclo_comercial = $this->Regimen_Facturacion_model->get_ciclo_comercial($predio['PREREGION'],$predio['PREZONA'],$predio['PRESECTOR'],$predio['PREMZN'],$predio['PRELOTE']);
                }

                foreach($this->data['recibos'] as $recibo){
                    array_push($cabecera,$this->Regimen_Facturacion_model->get_datos($recibo['OFACSERNRO'],$recibo['OFACNRO']));
                }
                foreach($cabecera as $cabecera1){
                    array_push($periodos,$this->devolver_mes(substr($cabecera1['FACEMIFEC'],3,2))." ".substr($cabecera1['FACEMIFEC'],6,4));
                    array_push($periodos_ayuda,substr($cabecera1['FACEMIFEC'],6,4).substr($cabecera1['FACEMIFEC'],3,2));
                    array_push($periodos_ayuda1,$this->restar_fechas(substr($cabecera1['FACEMIFEC'],6,4),substr($cabecera1['FACEMIFEC'],3,2)));
                }
                foreach($periodos_ayuda as $periodo){
                    array_push($tipo_regimenes,$this->Regimen_Facturacion_model->get_tipo_regimenes($valores[7],$periodo));
                }
                foreach($periodos_ayuda1 as $periodo){
                    array_push($tipo_regimenes1,$this->Regimen_Facturacion_model->get_tipo_regimenes($valores[7],$periodo));
                    if(strlen($valores[7]) == 7){
                      foreach ($suministro_multiple as $suministro) {
                        $consumos = $this->Regimen_Facturacion_model->get_consumos($suministro,$periodo);
                        if($consumos != NULL){
                          array_push($consumos_validos,$consumos);
                          break;
                        }
                      }
                      if($consumos == NULL){
                        array_push($consumos_validos,$consumos);
                      }
                    } else {
                      array_push($consumos_validos,$this->Regimen_Facturacion_model->get_consumos($valores[7],$periodo));
                    }
                }
                foreach($tipo_regimenes as $regimen){
                    array_push($observaciones,$this->Regimen_Facturacion_model->get_observaciones($regimen['OBSLEC']));
                }
                $this->data['cabecera'] = $cabecera;
                $this->data['periodo'] = $periodos;
                $this->data['tipo_regimenes'] = $tipo_regimenes;
                $this->data['tipo_regimenes1'] = $tipo_regimenes1;
                $this->data['observaciones'] = $observaciones;
                $this->data['consumos_validos'] = $consumos_validos;
                $consumos =array();
                if(strlen($valores[7]) == 7){
                  foreach ($periodos_ayuda1 as $periodo ) {
                    $consumo = array();
                    foreach ($tarifas_ambitos as $key => $tarifa2 ) {
                      $asignado =  $this->Regimen_Facturacion_model->get_consumo_asignado_domestico($tarifa2['CLICODFAC'],$periodo);
                      if($tarifa2['TARIFA'] == 'D01'){
                        if($tarifa2['AMBCOD'] == 1){
                          if($asignado['DIASXSEMAN'] <= 4){
                            if($asignado['HORCNT'] < 5){
                              //$tarifas_ambitos[$key]['asignado'] = 8;
                              array_push($consumo,8);
                            }else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT'] <= 10){
                              //$tarifas_ambitos[$key]['asignado'] = 10;
                              array_push($consumo,10);
                            } else if($asignado['HORCNT'] > 10 ){
                              array_push($consumo,12);
                              //$tarifas_ambitos[$key]['asignado'] = 12;
                            }
                          } else if($asignado['DIASXSEMAN'] > 4){
                            if($asignado['HORCNT'] < 5){
                              array_push($consumo,10);
                              //$tarifas_ambitos[$key]['asignado'] = 10;
                            }else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT'] <= 10){
                              array_push($consumo,12);
                              //$tarifas_ambitos[$key]['asignado'] = 12;
                            } else if($asignado['HORCNT'] > 10 ){
                              array_push($consumo,19);
                              //$tarifas_ambitos[$key]['asignado'] = 19;
                            }
                          }
                        } else {
                          if($asignado['HORCNT'] < 5){
                            array_push($consumo,10);
                            //$tarifas_ambitos[$key]['asignado'] = 10;
                          } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT'] <= 10){
                            array_push($consumo,12);
                            //$tarifas_ambitos[$key]['asignado'] = 12;
                          } else {
                            array_push($consumo,19);
                            //$tarifas_ambitos[$key]['asignado'] = 19;
                          }
                        }
                      } else{
                       $CONSU =   $this->Regimen_Facturacion_model->get_consumo_asignado1($tarifa2['TARIFA']);
                       array_push($consumo,intval($CONSU));
                      //$tarifas_ambitos[$key]['asignado'] = $CONSU;
                      }
                    }
                    array_push($consumos,$consumo);
                    $consumo = array();
                  }
                } else {
                  if(intval($cabecera[0]['FAMBITO']) == 1){
                          if($cabecera[0]['FACTARIFA'] == "D01"){
                              $ayuda_asigandos = array();
                              foreach($periodos_ayuda1 as $periodo){
                                  array_push($ayuda_asigandos,$this->Regimen_Facturacion_model->get_consumo_asignado_domestico($valores[7],$periodo));
                              }
                              foreach($ayuda_asigandos as $asignado){
                                  if($asignado['DIASXSEMAN'] <= 4){
                                      if($asignado['HORCNT'] < 5){
                                          array_push($consumos_asignados,8);
                                      } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT']<= 10){
                                          array_push($consumos_asignados,10);
                                      } else {
                                          array_push($consumos_asignados,12);
                                      }

                                  } else {
                                      if($asignado['HORCNT'] < 5){
                                          array_push($consumos_asignados,10);
                                      } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT']<= 10){
                                          array_push($consumos_asignados,12);
                                      } else {
                                          array_push($consumos_asignados,19);
                                      }
                                  }
                              }
                          } else {
                              array_push($consumos_asignados,$this->Regimen_Facturacion_model->get_consumo_asignado($cabecera[0]['FACTARIFA'],$cabecera[0]['FAMBITO']));
                          }
                      } else {
                          if($cabecera[0]['FACTARIFA'] == "D01"){
                              $ayuda_asigandos = array();
                              foreach($periodos_ayuda1 as $periodo){
                                  array_push($ayuda_asigandos,$this->Regimen_Facturacion_model->get_consumo_asignado_domestico($valores[7],$periodo));
                              }
                              foreach($ayuda_asigandos as $asignado){
                                  if($asignado['HORCNT'] < 5){
                                      array_push($consumos_asignados,10);
                                  } else if($asignado['HORCNT'] >= 5 && $asignado['HORCNT']<= 10){
                                      array_push($consumos_asignados,12);
                                  } else {
                                      array_push($consumos_asignados,19);
                                  }
                              }
                          } else {
                            if(strlen($valores[7]) > 7){
                              array_push($consumos_asignados,$this->Regimen_Facturacion_model->get_consumo_asignado($cabecera[0]['FACTARIFA'],$cabecera[0]['FAMBITO']));
                            } else {
                              array_push($consumos_asignados,$this->Regimen_Facturacion_model->get_consumo_asignado1($this->data['tarifa_multiple']));
                            }
                          }
                      }
                }
                $MESES = "";
                for($i = 0; $i < sizeof($periodos) ; $i++){
                    if($i == (sizeof($periodos) - 1)){
                        $MESES .= $periodos[$i];
                    } else {
                        $MESES .= $periodos[$i]." - ";
                    }
                }
                $this->load->library('pdf');
                $pdf = $this->pdf->load();
		        for($i=0;$i<sizeof($this->data['recibos']);$i++){
                    $tipo_regimen = "";
                    $lectura_anterior ="";
                    $fecha_lectura_anterior ="";
                    $consumo_asignado = "";
                    $consumo_promedio = "";
                    if(sizeof($consumos_asignados)>1){
                        $consumo_asignado2 = $consumos_asignados[$i];
                    } else {
                        $consumo_asignado2 =  $consumos_asignados[0];
                    }
                    if(sizeof($consumos_validos[$i])>0){
                        $consumo_promedio =  $consumos_validos[$i]["PROMEDIO"];
                    } else {
                      $consumo_promedio = $consumos_validos[0]['PROMEDIO'];
                    }
                    if(isset($tipo_regimenes1[$i]["FECLEC"])){
                      $fecha_lectura_anterior = $tipo_regimenes1[$i]["FECLEC"];
                    } else {
                        $fecha_lectura_anterior = " / / ";
                    }
                    if(isset($tipo_regimenes[$i]['LECANT'])){
                      $lectura_anterior =$tipo_regimenes[$i]['LECANT'];
                    } else {
                      $lectura_anterior = 0;
                    }
                    $variable_aux = str_replace("\r","<br>",$this->input->post("texto".$i));
                    if($tipo_regimenes[$i]["TIPVOLFAC"] == "M"){
                        $tipo_regimen =  "DIFERENCIA DE LECTURAS";
                    } else if($tipo_regimenes[$i]["TIPVOLFAC"] == "P"){
                        $tipo_regimen =  "PROMEDIO";
                    } else {
                        $tipo_regimen =  "ASIGNADO";
                    }
                    $consumos_validos11 = "";
                    if(sizeof($consumos_validos)>0){
                      /*  $consumos_validos11 .= $this->cambiar_mes(substr($consumos_validos[$i]['FECLEC01'],3,2))."-".substr($consumos_validos[$i]['FECLEC01'],6,4)." [".$consumos_validos[$i]["CONSUMO01"]."] - ".
                                                    $this->cambiar_mes(substr($consumos_validos[$i]['FECLEC02'],3,2))."-".substr($consumos_validos[$i]['FECLEC02'],6,4)." [".$consumos_validos[$i]["CONSUMO02"]."] - ".
                                                    $this->cambiar_mes(substr($consumos_validos[$i]['FECLEC03'],3,2))."-".substr($consumos_validos[$i]['FECLEC03'],6,4)." [".$consumos_validos[$i]["CONSUMO03"]."] - ".
                                                    $this->cambiar_mes(substr($consumos_validos[$i]['FECLEC04'],3,2))."-".substr($consumos_validos[$i]['FECLEC04'],6,4)." [".$consumos_validos[$i]["CONSUMO04"]."] - ".
                                                    $this->cambiar_mes(substr($consumos_validos[$i]['FECLEC05'],3,2))."-".substr($consumos_validos[$i]['FECLEC05'],6,4)." [".$consumos_validos[$i]["CONSUMO05"]."] - ".
                                                    $this->cambiar_mes(substr($consumos_validos[$i]['FECLEC06'],3,2))."-".substr($consumos_validos[$i]['FECLEC06'],6,4)." [".$consumos_validos[$i]["CONSUMO06"]."]";*/
                        if($consumos_validos[$i]["CONSUMO01"] != 0){
                            $consumos_validos11 .= $this->cambiar_mes(substr($consumos_validos[$i]['FECLEC01'],3,2),substr($consumos_validos[$i]['FECLEC01'],6,4))." [".$consumos_validos[$i]["CONSUMO01"]."]";
                        }
                        if($consumos_validos[$i]["CONSUMO02"] != 0){
                           $consumos_validos11 .=  " - ".$this->cambiar_mes(substr($consumos_validos[$i]['FECLEC02'],3,2),substr($consumos_validos[$i]['FECLEC02'],6,4))." [".$consumos_validos[$i]["CONSUMO02"]."]";
                        }
                        if($consumos_validos[$i]["CONSUMO03"] != 0){
                            $consumos_validos11 .= " - ".$this->cambiar_mes(substr($consumos_validos[$i]['FECLEC03'],3,2),substr($consumos_validos[$i]['FECLEC03'],6,4))." [".$consumos_validos[$i]["CONSUMO03"]."]";
                        }
                        if($consumos_validos[$i]["CONSUMO04"] != 0){
                            $consumos_validos11 .= " - ".$this->cambiar_mes(substr($consumos_validos[$i]['FECLEC04'],3,2),substr($consumos_validos[$i]['FECLEC04'],6,4))." [".$consumos_validos[$i]["CONSUMO04"]."]";
                        }
                        if($consumos_validos[$i]["CONSUMO05"] != 0){
                            $consumos_validos11 .= " - ".$this->cambiar_mes(substr($consumos_validos[$i]['FECLEC05'],3,2),substr($consumos_validos[$i]['FECLEC05'],6,4))." [".$consumos_validos[$i]["CONSUMO05"]."]";
                        }
                        if($consumos_validos[$i]["CONSUMO06"] != 0){
                            $consumos_validos11 .= " - ".$this->cambiar_mes(substr($consumos_validos[$i]['FECLEC06'],3,2),substr($consumos_validos[$i]['FECLEC06'],6,4))." [".$consumos_validos[$i]["CONSUMO06"]."]";
                        }

                    }
                $pdfFilePath = FCPATH."/reportes/ayuda.pdf";
			     $html = "<div><img src='img/logo2.png' width='150px'></div>".
				"<h5 style='margin-bottom:-10px'><i>PROCESO DE FACTURACIÓN</i></h5>".
				"<div style='text-align:center;margin-bottom:-10px'><h4>INFORME DE FACTURACIÓN 25195-16 - SEDALIB S.A.-81000-SGPCV/FACT</h4></div>".
				"<h5 style='margin-bottom:5px;margin-top:-10px'>Fecha : ".date('d/m/Y')." </h5>".
				"<table width=100%>".
				"<tr>".
				"<td  style='width:22%;font-size:11px'><b>RECLAMO N°: </b></td>".
				"<td style='font-size:12px'>".$valores[6]."</td>".
				"<td style='width:25%;font-size:11px'><b>Ciclo Comercial: </b></td>".
				"<td style='font-size:12px'>".$ciclo_comercial."</td></tr>".
				"<tr><td style='width:22%;font-size:11px'><b>Mes(es) Reclamado(s): </b></td>".
				"<td style='font-size:12px'>".$MESES."</td>".
				"<td style='width:25%;font-size:11px !important'><b>Categoría Tarifaria: </b></td>".
				"<td style='font-size:12px'>".(( strlen($valores[7]) == 7 ) ? $this->mostrar_tarifas($tarifas) : $cabecera[0]['FACTARIFA']) ."</td></tr>".
				"<tr><td style='width:22%;font-size:11px'><b>Código Suministro</b></td>".
				"<td style='font-size:12px'>".$valores[7]."</td>".
				"<td style='width:25%;font-size:11px'><b>Medidor: </b></td>".
				"<td style='font-size:12px'>".$tipo_regimenes[$i]["MEDIDOR"]."</td></tr>".
				"<tr><td style='width:22%;font-size:11px'><b> Unidades de Uso: </b></td>".
				"<td style='font-size:12px'>".$unidades."</td>".
				"<td style='width:25%;font-size:11px'><b>Horario de Abastecimiento: </b></td>".
				"<td style='font-size:12px'>".$horario['HOPDES']."</td>".
				"</tr></table><hr>".
				"<table>".
				"<tr>".
				"<td width='47%'>".
				"<table><tr><td style='font-size:11px'>Régimen de Facturación:</td><td style='font-size:12px'>".$tipo_regimen."</td></tr><tr><td style='font-size:11px'>Período de Facturación:</td><td style='font-size:12px'>".$periodos[$i]."</td></tr><tr><td style='font-size:11px'>Lectura Actual: </td><td style='font-size:12px'>".$tipo_regimenes[$i]["LECTURA"]." - ".$tipo_regimenes[$i]["FECLEC"]."</td></tr><tr><td style='font-size:11px'>Lectura Anterior: </td><td style='font-size:12px'>".$lectura_anterior." - ".$fecha_lectura_anterior."</td></tr><tr><td style='font-size:11px'>Consumo Facturado (m<sup>3</sup>):</td><td style='font-size:12px'>".$tipo_regimenes[$i]["VOLFAC"]."</td></tr></table></td>".
				"<td style='text-align:center'>"."<b style='font-size:12px'>DATOS REFERENCIALES<b>".
				"<table><tr style='text-align:center'>".
				"<tr><td style='font-size:11px;width:35%;text-align:left !important'><b>Observación: </b></td><td style='font-size:11px;text-align:left !important'>".$tipo_regimenes[$i]["OBSLEC"]." ".$observaciones[$i]." </td></tr>".
				"<tr><td style='font-size:11px;width:35%;text-align:left !important'><b>Consumo Asignado: </b></td><td style='font-size:11px;text-align:left !important'>".((strlen($valores[7]) == 7) ? $this->sumar_consumos($consumos[$i])  : $consumo_asignado2)." m<sup>3</sup></td></tr>".
				"<tr><td style='font-size:11px;text-align:left !important'><b>Consumo Promedio: </b></td><td style='font-size:11px;text-align:left !important'>".$consumo_promedio."</td></tr>".
				"<tr><td style='font-size:11px;text-align:left !important'><b>Consumo Válidos: </b></td><td style='font-size:11px;text-align:left !important'>".$consumos_validos11."</td></tr>".
				"</table></td>".
				"</tr>".
				"</table>".
				"<h4>OBSERVACIÓN</h4><div style='border: 1px solid;border-radius: 5px;padding:10px;height:80px'>".$variable_aux."</div><div>".
				"<h5><b>BASE LEGAL: </b></h5><p style='font-size:12px'><b>Resolución de Consejo Directivo 088-2007-SUNASS-CD</b> modificacion del Reglamento General de Reclamos de Usuarios de Servicios de Saneamiento , aporbado mediante Resolución N° 066-2006-SUNASS-CD.</p><ul><li style='font-size:12px'>Artículo 87° <b>\" Consideraciones a tomarse en cuenta en la facturación basada en Diferencias de Lecturas \"</b></li><li style='font-size:12px'>Artículo 88° <b>\"Control de Calidad de facturaciones basadas en Diferencia de Lecturas\"</b></li><li style='font-size:12px'>Artículo 89° <b>\"Determinación del Volúmen a facturar por Agua Potable\"</b></li></ul></div>".
				"<div style='width:100%'><br><br>Atte.".
				"<table style='width:100%'>".
				"<tr>".
				"<td style='width:10%'></td>".
				"<td style='text-align:center;align:center;width:40%'>".
				"<img src='img/firma2.png' style='margin-bottom:-40px'>".
				"<hr style='width:80%'>".
				"<h4>JEFE DE PROCESO DE FACTURACIÓN</h4></td>".
				"<td style='text-align:center;width:40%'><img src='img/firma1.png' style='margin-bottom:-40px;margin-left:10px'><hr style='width:80%'><h4>AUXILIAR DE PROCESO DE FACTURACIÓN</h4></td>".
				"<td style='width:10%'></td>".
				"</tr></table>".
				"</div>";


                $pdf->WriteHTML($html); // write the HTML into the PDF
                if($i<sizeof($this->data['recibos'])-1){
                    $pdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="a" suppress="off" />');
                    }

                }
		      $pdf->Output(date('m-Y').$i.'.pdf', 'D'); // save to file because we can*/
                $variable1 = 1;
                break;
            }
        }
        if($variable1 == 0){
            $this->load->view('errors/html/error_404', $this->data);
        }
    }

    private function sumar_consumos($valor){
      $total = 0;
      foreach ($valor as $key) {
         $total += $key;
      }
      return $total;
    }

    private function mostrar_tarifas($tarifas){
      $D01 = 0;
      $S01 = 0;
      $E01 = 0;
      $C01 = 0;
      $I01 = 0;
      $C03 = 0;
      foreach ($tarifas as $tarifa) {
        switch ($tarifa) {
          case 'D01':
            $D01++;
            break;
          case 'S01':
            $S01++;
            break;
          case 'E01':
            $E01++;
            break;
          case 'C01':
            $C01++;
            break;
          case 'I01':
            $I01++;
            break;
          case 'C03':
            $C03++;
            break;
        }
      }
      $resultado = "";
      if($D01 > 0){ $resultado .= "D01 - [".$D01."]"; }
      if($S01 > 0){
        if($resultado == ""){ $resultado .= "S01 - [".$S01."]"; }
        else { $resultado .= "; S01 - [".$S01."]"; }
      }
      if($E01 > 0){
        if($resultado == ""){ $resultado .= "E01 - [".$E01."]"; }
        else { $resultado .= "; E01 - [".$E01."]"; }
      }
      if($C01 > 0){
        if($resultado == ""){ $resultado .= "C01 - [".$C01."]"; }
        else { $resultado .= "; C01 - [".$C01."]";  }
      }
      if($I01 > 0){
        if($resultado == ""){ $resultado .= "I01 - [".$I01."]"; }
        else {  $resultado .= "; I01 - [".$I01."]"; }
      }
      if($C03 > 0){
        if($resultado == ""){ $resultado .= "C03 - [".$C03."]"; }
        else { $resultado .= "; C03 - [".$C03."]";  }
      }
      return $resultado;
    }

    private function cambiar_mes($cadena,$str){
      $cadena = intval($cadena)+1;
      if($cadena < 10){ $cadena = "0".$cadena; }
      else if($cadena == 13){ $cadena = "01"; $str = intval($str)+1; }
      else{ $cadena = $cadena; }
      switch($cadena){
          case "01":return "ENE-".$str;break;
          case "02":return "FEB-".$str;break;
          case "03":return "MAR-".$str;break;
          case "04":return "ABR-".$str;break;
          case "05":return "MAY-".$str;break;
          case "06":return "JUN-".$str;break;
          case "07":return "JUL-".$str;break;
          case "08":return "AGO-".$str;break;
          case "09":return "SET-".$str;break;
          case "10":return "OCT-".$str;break;
          case "11":return "NOV-".$str;break;
          case "12":return "DIC-".$str;break;
      }
    }

}
