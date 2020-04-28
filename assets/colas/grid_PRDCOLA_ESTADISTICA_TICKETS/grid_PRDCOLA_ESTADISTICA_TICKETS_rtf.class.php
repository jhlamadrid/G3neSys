<?php

class grid_PRDCOLA_ESTADISTICA_TICKETS_rtf
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $nm_data;
   var $Texto_tag;
   var $Arquivo;
   var $Tit_doc;
   var $sc_proc_grid; 
   var $NM_cmp_hidden = array();

   //---- 
   function grid_PRDCOLA_ESTADISTICA_TICKETS_rtf()
   {
      $this->nm_data   = new nm_data("es");
      $this->Texto_tag = "";
   }

   //---- 
   function monta_rtf()
   {
      $this->inicializa_vars();
      $this->gera_texto_tag();
      $this->grava_arquivo_rtf();
      $this->monta_html();
   }

   //----- 
   function inicializa_vars()
   {
      global $nm_lang;
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      $this->Arquivo    = "sc_rtf";
      $this->Arquivo   .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->Arquivo   .= "_grid_PRDCOLA_ESTADISTICA_TICKETS";
      $this->Arquivo   .= ".rtf";
      $this->Tit_doc    = "grid_PRDCOLA_ESTADISTICA_TICKETS.rtf";
   }

   //----- 
   function gera_texto_tag()
   {
     global $nm_lang;
      global
             $nm_nada, $nm_lang;

      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_PRDCOLA_ESTADISTICA_TICKETS']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_PRDCOLA_ESTADISTICA_TICKETS']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_PRDCOLA_ESTADISTICA_TICKETS']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['usr_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['php_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->cdatecodcola = $Busca_temp['cdatecodcola']; 
          $tmp_pos = strpos($this->cdatecodcola, "##@@");
          if ($tmp_pos !== false)
          {
              $this->cdatecodcola = substr($this->cdatecodcola, 0, $tmp_pos);
          }
          $this->cdatecodcola_2 = $Busca_temp['cdatecodcola_input_2']; 
          $this->oficodcola = $Busca_temp['oficodcola']; 
          $tmp_pos = strpos($this->oficodcola, "##@@");
          if ($tmp_pos !== false)
          {
              $this->oficodcola = substr($this->oficodcola, 0, $tmp_pos);
          }
          $this->mvtnabr = $Busca_temp['mvtnabr']; 
          $tmp_pos = strpos($this->mvtnabr, "##@@");
          if ($tmp_pos !== false)
          {
              $this->mvtnabr = substr($this->mvtnabr, 0, $tmp_pos);
          }
      } 
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq_filtro'];
      $this->nm_where_dinamico = "";
      $_SESSION['scriptcase']['grid_PRDCOLA_ESTADISTICA_TICKETS']['contr_erro'] = 'on';
 


?>
<style>
.malo_rojo {
	color: red;
	}	
</style>
<?php
$_SESSION['scriptcase']['grid_PRDCOLA_ESTADISTICA_TICKETS']['contr_erro'] = 'off'; 
      if  (!empty($this->nm_where_dinamico)) 
      {   
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'] .= $this->nm_where_dinamico;
      }   
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['rtf_name']))
      {
          $this->Arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['rtf_name'];
          $this->Tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['rtf_name'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['rtf_name']);
      }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
          $nmgp_select = "SELECT OFICODCOLA, USRNOM, MVTNABR, str_replace (convert(char(10),CDATECODCOLA,102), '.', '-') + ' ' + convert(char(8),CDATECODCOLA,20), TICKNRO, TICKHORAGEN, TICKHORATE, TICKHORATEFIN, TICKDURATEMIN, OFIDES, MVTNCOD, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT OFICODCOLA, USRNOM, MVTNABR, CDATECODCOLA, TICKNRO, TICKHORAGEN, TICKHORATE, TICKHORATEFIN, TICKDURATEMIN, OFIDES, MVTNCOD, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
       $nmgp_select = "SELECT OFICODCOLA, USRNOM, MVTNABR, convert(char(23),CDATECODCOLA,121), TICKNRO, TICKHORAGEN, TICKHORATE, TICKHORATEFIN, TICKDURATEMIN, OFIDES, MVTNCOD, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
          $nmgp_select = "SELECT OFICODCOLA, USRNOM, MVTNABR, CDATECODCOLA, TICKNRO, TICKHORAGEN, TICKHORATE, TICKHORATEFIN, TICKDURATEMIN, OFIDES, MVTNCOD, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      { 
          $nmgp_select = "SELECT OFICODCOLA, USRNOM, MVTNABR, EXTEND(CDATECODCOLA, YEAR TO DAY), TICKNRO, TICKHORAGEN, TICKHORATE, TICKHORATEFIN, TICKDURATEMIN, OFIDES, MVTNCOD, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT OFICODCOLA, USRNOM, MVTNABR, CDATECODCOLA, TICKNRO, TICKHORAGEN, TICKHORATE, TICKHORATEFIN, TICKDURATEMIN, OFIDES, MVTNCOD, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_resumo'])) 
      { 
          if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'])) 
          { 
              $nmgp_select .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_resumo']; 
          } 
          else
          { 
              $nmgp_select .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_resumo'] . ")"; 
          } 
      } 
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['order_grid'];
      $nmgp_select .= $nmgp_order_by; 
      if (!empty($this->Ini->nm_col_dinamica)) 
      {
          foreach ($this->Ini->nm_col_dinamica as $nm_cada_col => $nm_nova_col)
          {
                   $nmgp_select = str_replace($nm_cada_col, $nm_nova_col, $nmgp_select); 
          }
      }
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
      $rs = $this->Db->Execute($nmgp_select);
      if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }

      $this->Texto_tag .= "<table>\r\n";
      $this->Texto_tag .= "<tr>\r\n";
      foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['field_order'] as $Cada_col)
      { 
          $SC_Label = (isset($this->New_label['oficodcola'])) ? $this->New_label['oficodcola'] : "OFICINA"; 
          if ($Cada_col == "oficodcola" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usrnom'])) ? $this->New_label['usrnom'] : "Atendido por"; 
          if ($Cada_col == "usrnom" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['mvtnabr'])) ? $this->New_label['mvtnabr'] : "MVTNABR"; 
          if ($Cada_col == "mvtnabr" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['cdatecodcola'])) ? $this->New_label['cdatecodcola'] : "FECHA"; 
          if ($Cada_col == "cdatecodcola" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ticknro'])) ? $this->New_label['ticknro'] : "TICKNRO"; 
          if ($Cada_col == "ticknro" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['tickhoragen'])) ? $this->New_label['tickhoragen'] : "Hora de Generac"; 
          if ($Cada_col == "tickhoragen" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['tickhorate'])) ? $this->New_label['tickhorate'] : "Usuario"; 
          if ($Cada_col == "tickhorate" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['tickhoratefin'])) ? $this->New_label['tickhoratefin'] : "Fin Atencion"; 
          if ($Cada_col == "tickhoratefin" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['tickduratemin'])) ? $this->New_label['tickduratemin'] : "Durac Minutos"; 
          if ($Cada_col == "tickduratemin" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['espera_usuario'])) ? $this->New_label['espera_usuario'] : "Espera del Usuario"; 
          if ($Cada_col == "espera_usuario" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['tiempo_muerto'])) ? $this->New_label['tiempo_muerto'] : "Perm Usuario"; 
          if ($Cada_col == "tiempo_muerto" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ofides'])) ? $this->New_label['ofides'] : "OFIDES"; 
          if ($Cada_col == "ofides" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['mvtncod'])) ? $this->New_label['mvtncod'] : "MVTNCOD"; 
          if ($Cada_col == "mvtncod" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['tickabr'])) ? $this->New_label['tickabr'] : "TIPO TICKET"; 
          if ($Cada_col == "tickabr" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
      } 
      $this->Texto_tag .= "</tr>\r\n";
      while (!$rs->EOF)
      {
         $this->Texto_tag .= "<tr>\r\n";
         $this->oficodcola = $rs->fields[0] ;  
         $this->oficodcola = (string)$this->oficodcola;
         $this->usrnom = $rs->fields[1] ;  
         $this->mvtnabr = $rs->fields[2] ;  
         $this->cdatecodcola = $rs->fields[3] ;  
         $this->ticknro = $rs->fields[4] ;  
         $this->ticknro = (string)$this->ticknro;
         $this->tickhoragen = $rs->fields[5] ;  
         $this->tickhorate = $rs->fields[6] ;  
         $this->tickhoratefin = $rs->fields[7] ;  
         $this->tickduratemin = $rs->fields[8] ;  
         $this->tickduratemin =  str_replace(",", ".", $this->tickduratemin);
         $this->tickduratemin = (string)$this->tickduratemin;
         $this->ofides = $rs->fields[9] ;  
         $this->mvtncod = $rs->fields[10] ;  
         $this->mvtncod = (string)$this->mvtncod;
         $this->tickabr = $rs->fields[11] ;  
         $this->usrcodcola = $rs->fields[12] ;  
         $this->usrcodcola = (string)$this->usrcodcola;
         //----- lookup - oficodcola
         $this->look_oficodcola = $this->oficodcola; 
         $this->Lookup->lookup_oficodcola($this->look_oficodcola, $this->oficodcola) ; 
         $this->look_oficodcola = ($this->look_oficodcola == "&nbsp;") ? "" : $this->look_oficodcola; 
         $this->sc_proc_grid = true; 
         $_SESSION['scriptcase']['grid_PRDCOLA_ESTADISTICA_TICKETS']['contr_erro'] = 'on';
 $duracion  = $this->tickduratemin ;

if ($this->tickduratemin  > 15 ) {	
	$this->tickduratemin  = "<span class='malo_rojo'>".$this->tickduratemin .'</span>';
}



$horagen = $this->tickhoragen ;
$horaten = $this->tickhorate ;

$horaInicio = new DateTime($horagen);
$horaTermino = new DateTime($horaten);

$interval = $horaInicio->diff($horaTermino);
$dato = $interval->format('%i');


if ($dato < 16 ) {
	$valor = $dato;
} else {
	$valor = "<span class='malo_rojo'>".$dato.'</span>';
}

$this->espera_usuario  = $valor;

$this->tiempo_muerto  = $dato + $duracion;




	






$_SESSION['scriptcase']['grid_PRDCOLA_ESTADISTICA_TICKETS']['contr_erro'] = 'off'; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['field_order'] as $Cada_col)
         { 
            if (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off")
            { 
                $NM_func_exp = "NM_export_" . $Cada_col;
                $this->$NM_func_exp();
            } 
         } 
         $this->Texto_tag .= "</tr>\r\n";
         $rs->MoveNext();
      }
      $this->Texto_tag .= "</table>\r\n";

      $rs->Close();
   }
   //----- oficodcola
   function NM_export_oficodcola()
   {
         nmgp_Form_Num_Val($this->look_oficodcola, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         if (!NM_is_utf8($this->look_oficodcola))
         {
             $this->look_oficodcola = sc_convert_encoding($this->look_oficodcola, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->look_oficodcola = str_replace('<', '&lt;', $this->look_oficodcola);
         $this->look_oficodcola = str_replace('>', '&gt;', $this->look_oficodcola);
         $this->Texto_tag .= "<td>" . $this->look_oficodcola . "</td>\r\n";
   }
   //----- usrnom
   function NM_export_usrnom()
   {
         $this->usrnom = html_entity_decode($this->usrnom, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->usrnom = strip_tags($this->usrnom);
         if (!NM_is_utf8($this->usrnom))
         {
             $this->usrnom = sc_convert_encoding($this->usrnom, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->usrnom = str_replace('<', '&lt;', $this->usrnom);
         $this->usrnom = str_replace('>', '&gt;', $this->usrnom);
         $this->Texto_tag .= "<td>" . $this->usrnom . "</td>\r\n";
   }
   //----- mvtnabr
   function NM_export_mvtnabr()
   {
         $this->mvtnabr = html_entity_decode($this->mvtnabr, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->mvtnabr = strip_tags($this->mvtnabr);
         if (!NM_is_utf8($this->mvtnabr))
         {
             $this->mvtnabr = sc_convert_encoding($this->mvtnabr, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->mvtnabr = str_replace('<', '&lt;', $this->mvtnabr);
         $this->mvtnabr = str_replace('>', '&gt;', $this->mvtnabr);
         $this->Texto_tag .= "<td>" . $this->mvtnabr . "</td>\r\n";
   }
   //----- cdatecodcola
   function NM_export_cdatecodcola()
   {
         $conteudo_x = $this->cdatecodcola;
         nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
         if (is_numeric($conteudo_x) && $conteudo_x > 0) 
         { 
             $this->nm_data->SetaData($this->cdatecodcola, "YYYY-MM-DD");
             $this->cdatecodcola = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
         } 
         if (!NM_is_utf8($this->cdatecodcola))
         {
             $this->cdatecodcola = sc_convert_encoding($this->cdatecodcola, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->cdatecodcola = str_replace('<', '&lt;', $this->cdatecodcola);
         $this->cdatecodcola = str_replace('>', '&gt;', $this->cdatecodcola);
         $this->Texto_tag .= "<td>" . $this->cdatecodcola . "</td>\r\n";
   }
   //----- ticknro
   function NM_export_ticknro()
   {
         nmgp_Form_Num_Val($this->ticknro, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         if (!NM_is_utf8($this->ticknro))
         {
             $this->ticknro = sc_convert_encoding($this->ticknro, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->ticknro = str_replace('<', '&lt;', $this->ticknro);
         $this->ticknro = str_replace('>', '&gt;', $this->ticknro);
         $this->Texto_tag .= "<td>" . $this->ticknro . "</td>\r\n";
   }
   //----- tickhoragen
   function NM_export_tickhoragen()
   {
         $this->tickhoragen = html_entity_decode($this->tickhoragen, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->tickhoragen = strip_tags($this->tickhoragen);
         if (!NM_is_utf8($this->tickhoragen))
         {
             $this->tickhoragen = sc_convert_encoding($this->tickhoragen, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->tickhoragen = str_replace('<', '&lt;', $this->tickhoragen);
         $this->tickhoragen = str_replace('>', '&gt;', $this->tickhoragen);
         $this->Texto_tag .= "<td>" . $this->tickhoragen . "</td>\r\n";
   }
   //----- tickhorate
   function NM_export_tickhorate()
   {
         $this->tickhorate = html_entity_decode($this->tickhorate, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->tickhorate = strip_tags($this->tickhorate);
         if (!NM_is_utf8($this->tickhorate))
         {
             $this->tickhorate = sc_convert_encoding($this->tickhorate, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->tickhorate = str_replace('<', '&lt;', $this->tickhorate);
         $this->tickhorate = str_replace('>', '&gt;', $this->tickhorate);
         $this->Texto_tag .= "<td>" . $this->tickhorate . "</td>\r\n";
   }
   //----- tickhoratefin
   function NM_export_tickhoratefin()
   {
         $this->tickhoratefin = html_entity_decode($this->tickhoratefin, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->tickhoratefin = strip_tags($this->tickhoratefin);
         if (!NM_is_utf8($this->tickhoratefin))
         {
             $this->tickhoratefin = sc_convert_encoding($this->tickhoratefin, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->tickhoratefin = str_replace('<', '&lt;', $this->tickhoratefin);
         $this->tickhoratefin = str_replace('>', '&gt;', $this->tickhoratefin);
         $this->Texto_tag .= "<td>" . $this->tickhoratefin . "</td>\r\n";
   }
   //----- tickduratemin
   function NM_export_tickduratemin()
   {
         $this->tickduratemin = html_entity_decode($this->tickduratemin, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->tickduratemin = strip_tags($this->tickduratemin);
         if (!NM_is_utf8($this->tickduratemin))
         {
             $this->tickduratemin = sc_convert_encoding($this->tickduratemin, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->tickduratemin = str_replace('<', '&lt;', $this->tickduratemin);
         $this->tickduratemin = str_replace('>', '&gt;', $this->tickduratemin);
         $this->Texto_tag .= "<td>" . $this->tickduratemin . "</td>\r\n";
   }
   //----- espera_usuario
   function NM_export_espera_usuario()
   {
         $this->espera_usuario = html_entity_decode($this->espera_usuario, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->espera_usuario = strip_tags($this->espera_usuario);
         if (!NM_is_utf8($this->espera_usuario))
         {
             $this->espera_usuario = sc_convert_encoding($this->espera_usuario, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->espera_usuario = str_replace('<', '&lt;', $this->espera_usuario);
         $this->espera_usuario = str_replace('>', '&gt;', $this->espera_usuario);
         $this->Texto_tag .= "<td>" . $this->espera_usuario . "</td>\r\n";
   }
   //----- tiempo_muerto
   function NM_export_tiempo_muerto()
   {
         nmgp_Form_Num_Val($this->tiempo_muerto, "", ",", "0", "", "", "", "N:2", "-") ; 
         if (!NM_is_utf8($this->tiempo_muerto))
         {
             $this->tiempo_muerto = sc_convert_encoding($this->tiempo_muerto, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->tiempo_muerto = str_replace('<', '&lt;', $this->tiempo_muerto);
         $this->tiempo_muerto = str_replace('>', '&gt;', $this->tiempo_muerto);
         $this->Texto_tag .= "<td>" . $this->tiempo_muerto . "</td>\r\n";
   }
   //----- ofides
   function NM_export_ofides()
   {
         $this->ofides = html_entity_decode($this->ofides, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->ofides = strip_tags($this->ofides);
         if (!NM_is_utf8($this->ofides))
         {
             $this->ofides = sc_convert_encoding($this->ofides, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->ofides = str_replace('<', '&lt;', $this->ofides);
         $this->ofides = str_replace('>', '&gt;', $this->ofides);
         $this->Texto_tag .= "<td>" . $this->ofides . "</td>\r\n";
   }
   //----- mvtncod
   function NM_export_mvtncod()
   {
         nmgp_Form_Num_Val($this->mvtncod, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         if (!NM_is_utf8($this->mvtncod))
         {
             $this->mvtncod = sc_convert_encoding($this->mvtncod, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->mvtncod = str_replace('<', '&lt;', $this->mvtncod);
         $this->mvtncod = str_replace('>', '&gt;', $this->mvtncod);
         $this->Texto_tag .= "<td>" . $this->mvtncod . "</td>\r\n";
   }
   //----- tickabr
   function NM_export_tickabr()
   {
         $this->tickabr = html_entity_decode($this->tickabr, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->tickabr = strip_tags($this->tickabr);
         if (!NM_is_utf8($this->tickabr))
         {
             $this->tickabr = sc_convert_encoding($this->tickabr, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->tickabr = str_replace('<', '&lt;', $this->tickabr);
         $this->tickabr = str_replace('>', '&gt;', $this->tickabr);
         $this->Texto_tag .= "<td>" . $this->tickabr . "</td>\r\n";
   }

   //----- 
   function grava_arquivo_rtf()
   {
      global $nm_lang, $doc_wrap;
      $rtf_f = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo, "w");
      require_once($this->Ini->path_third      . "/rtf_new/document_generator/cl_xml2driver.php"); 
      $text_ok  =  "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n"; 
      $text_ok .=  "<DOC config_file=\"" . $this->Ini->path_third . "/rtf_new/doc_config.inc\" >\r\n"; 
      $text_ok .=  $this->Texto_tag; 
      $text_ok .=  "</DOC>\r\n"; 
      $xml = new nDOCGEN($text_ok,"RTF"); 
      fwrite($rtf_f, $xml->get_result_file());
      fclose($rtf_f);
   }

   function nm_conv_data_db($dt_in, $form_in, $form_out)
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT")
       {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT")
       {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       nm_conv_form_data($dt_out, $form_in, $form_out);
       return $dt_out;
   }
   //---- 
   function monta_html()
   {
      global $nm_url_saida, $nm_lang;
      include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['rtf_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['rtf_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS'][$path_doc_md5][1] = $this->Tit_doc;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE>Estadistica de Atención al Cliente :: RTF</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
<?php
if ($_SESSION['scriptcase']['proc_mobile'])
{
?>
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<?php
}
?>
  <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
  <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
  <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
  <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
  <META http-equiv="Pragma" content="no-cache"/>
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Ini->Str_btn_css ?>" /> 
</HEAD>
<BODY class="scExportPage">
<?php echo $this->Ini->Ajax_result_set ?>
<table style="border-collapse: collapse; border-width: 0; height: 100%; width: 100%"><tr><td style="padding: 0; text-align: center; vertical-align: middle">
 <table class="scExportTable" align="center">
  <tr>
   <td class="scExportTitle" style="height: 25px">RTF</td>
  </tr>
  <tr>
   <td class="scExportLine" style="width: 100%">
    <table style="border-collapse: collapse; border-width: 0; width: 100%"><tr><td class="scExportLineFont" style="padding: 3px 0 0 0" id="idMessage">
    <?php echo $this->Ini->Nm_lang['lang_othr_file_msge'] ?>
    </td><td class="scExportLineFont" style="text-align:right; padding: 3px 0 0 0">
     <?php echo nmButtonOutput($this->arr_buttons, "bexportview", "document.Fview.submit()", "document.Fview.submit()", "idBtnView", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bdownload", "document.Fdown.submit()", "document.Fdown.submit()", "idBtnDown", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.F0.submit()", "document.F0.submit()", "idBtnBack", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "");
 ?>
    </td></tr></table>
   </td>
  </tr>
 </table>
</td></tr></table>
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->Arquivo ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grid_PRDCOLA_ESTADISTICA_TICKETS_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="grid_PRDCOLA_ESTADISTICA_TICKETS"> 
<input type="hidden" name="nm_name_doc" value="<?php echo $path_doc_md5 ?>"> 
</form>
<FORM name="F0" method=post action="./"> 
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="volta_grid"> 
</FORM> 
</BODY>
</HTML>
<?php
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($cont2 >= $tam_campo)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $trab_saida;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $trab_saida;
   } 
}

?>
