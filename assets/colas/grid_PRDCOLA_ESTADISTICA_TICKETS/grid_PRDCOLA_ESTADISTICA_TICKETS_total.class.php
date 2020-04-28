<?php

class grid_PRDCOLA_ESTADISTICA_TICKETS_total
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;

   var $nm_data;

   //----- 
   function grid_PRDCOLA_ESTADISTICA_TICKETS_total($sc_page)
   {
      $this->sc_page = $sc_page;
      $this->nm_data = new nm_data("es");
      if (isset($_SESSION['sc_session'][$this->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['campos_busca']) && !empty($_SESSION['sc_session'][$this->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['campos_busca']))
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
          $cdatecodcola_2 = $Busca_temp['cdatecodcola_input_2']; 
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
   }

   //---- 
   function quebra_geral()
   {
      global $nada, $nm_lang , $oficodcola, $usrcodcola;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['contr_total_geral'] == "OK") 
      { 
          return; 
      } 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['tot_geral'] = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['tot_geral'][0] = "" . $this->Ini->Nm_lang['lang_msgs_totl'] . ""; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['tot_geral'][1] = $rt->fields[0] ; 
      $rt->fields[1] = str_replace(",", ".", $rt->fields[1]);
      $rt->fields[1] = (string)$rt->fields[1]; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['tot_geral'][2] = $rt->fields[1]; 
      $rt->fields[2] = str_replace(",", ".", $rt->fields[2]);
      $rt->fields[2] = (string)$rt->fields[2]; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['tot_geral'][3] = $rt->fields[2]; 
      $rt->Close(); 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['contr_total_geral'] = "OK";
   } 

   //-----  oficodcola
   function quebra_oficodcola_sc_free_group_by($oficodcola, $Where_qb) 
   {
      global $tot_oficodcola , $oficodcola, $usrcodcola;  
      $tot_oficodcola = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'])) 
      { 
         $nm_comando .= " where " . $Where_qb ; 
      } 
      else 
      { 
         $nm_comando .= " and " . $Where_qb ; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }  
      $tot_oficodcola[0] = NM_encode_input(sc_strip_script($oficodcola)) ; 
      $tot_oficodcola[1] = $rt->fields[0] ; 
      $rt->fields[1] = str_replace(",", ".", $rt->fields[1]);
      $tot_oficodcola[2] = (string)$rt->fields[1]; 
      $rt->fields[2] = str_replace(",", ".", $rt->fields[2]);
      $tot_oficodcola[3] = (string)$rt->fields[2]; 
      $rt->Close(); 
   } 

   //-----  cdatecodcola
   function quebra_cdatecodcola_sc_free_group_by($cdatecodcola, $Where_qb) 
   {
      global $tot_cdatecodcola , $oficodcola, $usrcodcola, $Sc_groupby_cdatecodcola;  
      $tot_cdatecodcola = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'])) 
      { 
         $nm_comando .= " where " . $Where_qb ; 
      } 
      else 
      { 
         $nm_comando .= " and " . $Where_qb ; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }  
      $tot_cdatecodcola[0] = NM_encode_input(sc_strip_script($cdatecodcola)) ; 
      $tot_cdatecodcola[1] = $rt->fields[0] ; 
      $rt->fields[1] = str_replace(",", ".", $rt->fields[1]);
      $tot_cdatecodcola[2] = (string)$rt->fields[1]; 
      $rt->fields[2] = str_replace(",", ".", $rt->fields[2]);
      $tot_cdatecodcola[3] = (string)$rt->fields[2]; 
      $rt->Close(); 
   } 

   //-----  tickabr
   function quebra_tickabr_sc_free_group_by($tickabr, $Where_qb) 
   {
      global $tot_tickabr , $oficodcola, $usrcodcola, $Sc_groupby_cdatecodcola;  
      $tot_tickabr = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'])) 
      { 
         $nm_comando .= " where " . $Where_qb ; 
      } 
      else 
      { 
         $nm_comando .= " and " . $Where_qb ; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }  
      $tot_tickabr[0] = sc_strip_script($tickabr) ; 
      $tot_tickabr[1] = $rt->fields[0] ; 
      $rt->fields[1] = str_replace(",", ".", $rt->fields[1]);
      $tot_tickabr[2] = (string)$rt->fields[1]; 
      $rt->fields[2] = str_replace(",", ".", $rt->fields[2]);
      $tot_tickabr[3] = (string)$rt->fields[2]; 
      $rt->Close(); 
   } 

   //-----  usrcodcola
   function quebra_usrcodcola_sc_free_group_by($usrcodcola, $Where_qb) 
   {
      global $tot_usrcodcola , $oficodcola, $usrcodcola, $Sc_groupby_cdatecodcola;  
      $tot_usrcodcola = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'])) 
      { 
         $nm_comando .= " where " . $Where_qb ; 
      } 
      else 
      { 
         $nm_comando .= " and " . $Where_qb ; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }  
      $tot_usrcodcola[0] = NM_encode_input(sc_strip_script($usrcodcola)) ; 
      $tot_usrcodcola[1] = $rt->fields[0] ; 
      $rt->fields[1] = str_replace(",", ".", $rt->fields[1]);
      $tot_usrcodcola[2] = (string)$rt->fields[1]; 
      $rt->fields[2] = str_replace(",", ".", $rt->fields[2]);
      $tot_usrcodcola[3] = (string)$rt->fields[2]; 
      $rt->Close(); 
   } 

   //-----  cdatecodcola
   function quebra_cdatecodcola_mes1($cdatecodcola, $arg_sum_cdatecodcola) 
   {
      global $tot_cdatecodcola , $oficodcola, $usrcodcola, $Sc_groupby_cdatecodcola;  
      $Sc_groupby_cdatecodcola = "CDATECODCOLA";
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      {
          $Sc_groupby_cdatecodcola = "convert(char(23),CDATECODCOLA,121)";
      }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      {
          $Sc_groupby_cdatecodcola = "TO_DATE(TO_CHAR(CDATECODCOLA, 'yyyy-mm-dd hh24:mi:ss'), 'yyyy-mm-dd hh24:mi:ss')";
      }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      {
          $Sc_groupby_cdatecodcola = "str_replace (convert(char(10),CDATECODCOLA,102), '.', '-') + ' ' + convert(char(8),CDATECODCOLA,20)";
      }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres))
      {
          $Sc_groupby_cdatecodcola = "to_char(CDATECODCOLA, 'YYYY-MM-DD HH24:MI:SS')";
      }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      {
          $Sc_groupby_cdatecodcola = "EXTEND(CDATECODCOLA, YEAR TO SECOND)";
      }
      $tot_cdatecodcola = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq']; 
      } 
      if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'])) 
      { 
         $nm_comando .= " where " .  $Sc_groupby_cdatecodcola . $arg_sum_cdatecodcola ; 
      } 
      else 
      { 
         $nm_comando .= " and " .  $Sc_groupby_cdatecodcola . $arg_sum_cdatecodcola ; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }  
      $tot_cdatecodcola[0] = NM_encode_input(sc_strip_script($cdatecodcola)) ; 
      $tot_cdatecodcola[1] = $rt->fields[0] ; 
      $rt->fields[1] = str_replace(",", ".", $rt->fields[1]);
      $tot_cdatecodcola[2] = (string)$rt->fields[1]; 
      $rt->fields[2] = str_replace(",", ".", $rt->fields[2]);
      $tot_cdatecodcola[3] = (string)$rt->fields[2]; 
      $rt->Close(); 
   } 


   //----- 
   function resumo_sc_free_group_by($destino_resumo, &$array_total_oficodcola, &$array_total_cdatecodcola, &$array_total_tickabr, &$array_total_usrcodcola)
   {
      global $nada, $nm_lang, $espera_usuario, $tiempo_muerto, $oficodcola, $usrcodcola;
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
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq_filtro'];
   $temp = "";
   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['SC_Gb_Free_sql'] as $cmp_gb => $ord)
   {
       $temp .= (empty($temp)) ? $cmp_gb . " " . $ord : ", " . $cmp_gb . " " . $ord;
   }
   $nmgp_order_by = (!empty($temp)) ? " order by " . $temp : "";
   $free_group_by = "";
   $all_sql_free  = array();
   $all_sql_free[] = "OFICODCOLA";
   $all_sql_free[] = "CDATECODCOLA";
   $all_sql_free[] = "TICKABR";
   $all_sql_free[] = "USRCODCOLA";
   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['SC_Gb_Free_sql'] as $cmp_gb => $ord)
   {
       $free_group_by .= (empty($free_group_by)) ? $cmp_gb : ", " . $cmp_gb;
   }
   foreach ($all_sql_free as $cmp_gb)
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['SC_Gb_Free_sql'][$cmp_gb]))
       {
           $free_group_by .= (empty($free_group_by)) ? $cmp_gb : ", " . $cmp_gb;
       }
   }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
         $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, OFICODCOLA, str_replace (convert(char(10),CDATECODCOLA,102), '.', '-') + ' ' + convert(char(8),CDATECODCOLA,20), TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by " . $free_group_by . "  " . $nmgp_order_by;
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, OFICODCOLA, convert(char(23),CDATECODCOLA,121), TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by " . $free_group_by . "  " . $nmgp_order_by;
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
         $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, OFICODCOLA, CDATECODCOLA, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela . " " . $this->sc_where_atual . " group by " . $free_group_by . "  " . $nmgp_order_by;
      } 
      else 
      { 
         $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, OFICODCOLA, CDATECODCOLA, TICKABR, USRCODCOLA from " . $this->Ini->nm_tabela . " " . $this->sc_where_atual . " group by " . $free_group_by . "  " . $nmgp_order_by;
      } 
      if ($destino_resumo != "gra") 
      {
          $comando = str_replace("avg(", "sum(", $comando); 
      }
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($comando))
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit;
      }
      $array_db_total = $this->get_array($rt);
      $rt->Close();
      foreach ($array_db_total as $registro)
      {
         $oficodcola      = $registro[3];
         $oficodcola_orig = $registro[3];
         $conteudo = $registro[3];
         $this->Lookup->lookup_oficodcola($conteudo , $oficodcola_orig) ; 
         $oficodcola = $conteudo;
         if (null === $oficodcola)
         {
             $oficodcola = '';
         }
         if (null === $oficodcola_orig)
         {
             $oficodcola_orig = '';
         }
         $val_grafico_oficodcola = $oficodcola;
         $registro[4] = substr($registro[4], 0, 7);
         $cdatecodcola      = $registro[4];
         $cdatecodcola_orig = $registro[4];
         $conteudo = $registro[4];
        $conteudo_x = $conteudo;
        nm_conv_limpa_dado($conteudo_x, "YYYY-MM");
        if (is_numeric($conteudo_x) && $conteudo_x > 0) 
        { 
            $this->nm_data->SetaData($conteudo, "YYYY-MM");
            $conteudo = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "mmaaaa"));
        } 
         $cdatecodcola = $conteudo;
         if (null === $cdatecodcola)
         {
             $cdatecodcola = '';
         }
         if (null === $cdatecodcola_orig)
         {
             $cdatecodcola_orig = '';
         }
         $val_grafico_cdatecodcola = $cdatecodcola;
         $tickabr      = $registro[5];
         $tickabr_orig = $registro[5];
         $conteudo = $registro[5];
         $tickabr = $conteudo;
         if (null === $tickabr)
         {
             $tickabr = '';
         }
         if (null === $tickabr_orig)
         {
             $tickabr_orig = '';
         }
         $val_grafico_tickabr = $tickabr;
         $usrcodcola      = $registro[6];
         $usrcodcola_orig = $registro[6];
         $conteudo = $registro[6];
         $this->Lookup->lookup_usrcodcola($conteudo , $usrcodcola_orig) ; 
         $usrcodcola = $conteudo;
         if (null === $usrcodcola)
         {
             $usrcodcola = '';
         }
         if (null === $usrcodcola_orig)
         {
             $usrcodcola_orig = '';
         }
         $val_grafico_usrcodcola = $usrcodcola;
         $registro[1] = str_replace(",", ".", $registro[1]);
         $registro[1] = (strpos(strtolower($registro[1]), "e")) ? (float)$registro[1] : $registro[1]; 
         $registro[1] = (string)$registro[1];
         if ($registro[1] == "") 
         {
             $registro[1] = 0;
         }
         $registro[2] = str_replace(",", ".", $registro[2]);
         $registro[2] = (strpos(strtolower($registro[2]), "e")) ? (float)$registro[2] : $registro[2]; 
         $registro[2] = (string)$registro[2];
         if ($registro[2] == "") 
         {
             $registro[2] = 0;
         }
         $oficodcola_orig        = NM_encode_input(sc_strip_script($oficodcola_orig));
         $val_grafico_oficodcola = NM_encode_input(sc_strip_script($val_grafico_oficodcola));
         $cdatecodcola_orig        = NM_encode_input(sc_strip_script($cdatecodcola_orig));
         $val_grafico_cdatecodcola = NM_encode_input(sc_strip_script($val_grafico_cdatecodcola));
         $usrcodcola_orig        = NM_encode_input(sc_strip_script($usrcodcola_orig));
         $val_grafico_usrcodcola = NM_encode_input(sc_strip_script($val_grafico_usrcodcola));
         $contr_arr = "";
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['SC_Gb_Free_cmp'] as $cmp_gb => $resto)
         {
             $temp       = $cmp_gb . "_orig";
             $contr_arr .= "[\"" . str_replace('"', '\"', $$temp) . "\"]";
             $arr_name   = "array_total_" . $cmp_gb . $contr_arr;
            eval ('
             if (!isset($' . $arr_name . '))
             {
                 $' . $arr_name . '[0] = ' . $registro[0] . ';
                 $' . $arr_name . '[1] = ' . $registro[1] . ';
                 $' . $arr_name . '[3] = $val_grafico_' . $cmp_gb . ';
                 $' . $arr_name . '[4] = "' . str_replace('"', '\"', $$temp) . '";
             }
             else
             {
                 $' . $arr_name . '[0] += ' . $registro[0] . ';
                 $' . $arr_name . '[1] += ' . $registro[1] . ';
             }
            ');
         }
      }
   }

   //----- 
   function resumo_mes1($destino_resumo, &$array_total_cdatecodcola)
   {
      global $nada, $nm_lang, $espera_usuario, $tiempo_muerto, $oficodcola, $usrcodcola;
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
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_PRDCOLA_ESTADISTICA_TICKETS']['where_pesq_filtro'];
   $nmgp_order_by = " order by CDATECODCOLA asc"; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
         $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, str_replace (convert(char(10),CDATECODCOLA,102), '.', '-') + ' ' + convert(char(8),CDATECODCOLA,20) from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by CDATECODCOLA  " . $nmgp_order_by;
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, convert(char(23),CDATECODCOLA,121) from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by CDATECODCOLA  " . $nmgp_order_by;
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
         $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, CDATECODCOLA from " . $this->Ini->nm_tabela . " " . $this->sc_where_atual . " group by CDATECODCOLA  " . $nmgp_order_by;
      } 
      else 
      { 
         $comando  = "select count(*), 0 as S_tiempo_muerto, 0 as A_tiempo_muerto, CDATECODCOLA from " . $this->Ini->nm_tabela . " " . $this->sc_where_atual . " group by CDATECODCOLA  " . $nmgp_order_by;
      } 
      if ($destino_resumo != "gra") 
      {
          $comando = str_replace("avg(", "sum(", $comando); 
      }
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($comando))
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit;
      }
      $array_db_total = $this->get_array($rt);
      $rt->Close();
      foreach ($array_db_total as $registro)
      {
         $registro[3] = substr($registro[3], 0, 7);
         $cdatecodcola      = $registro[3];
         $cdatecodcola_orig = $registro[3];
         $conteudo = $registro[3];
        $conteudo_x = $conteudo;
        nm_conv_limpa_dado($conteudo_x, "YYYY-MM");
        if (is_numeric($conteudo_x) && $conteudo_x > 0) 
        { 
            $this->nm_data->SetaData($conteudo, "YYYY-MM");
            $conteudo = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "mmaaaa"));
        } 
         $cdatecodcola = $conteudo;
         if (null === $cdatecodcola)
         {
             $cdatecodcola = '';
         }
         if (null === $cdatecodcola_orig)
         {
             $cdatecodcola_orig = '';
         }
         $val_grafico_cdatecodcola = $cdatecodcola;
         $registro[1] = str_replace(",", ".", $registro[1]);
         $registro[1] = (strpos(strtolower($registro[1]), "e")) ? (float)$registro[1] : $registro[1]; 
         $registro[1] = (string)$registro[1];
         if ($registro[1] == "") 
         {
             $registro[1] = 0;
         }
         $registro[2] = str_replace(",", ".", $registro[2]);
         $registro[2] = (strpos(strtolower($registro[2]), "e")) ? (float)$registro[2] : $registro[2]; 
         $registro[2] = (string)$registro[2];
         if ($registro[2] == "") 
         {
             $registro[2] = 0;
         }
         $cdatecodcola_orig = NM_encode_input(sc_strip_script($cdatecodcola_orig));
         if (isset($cdatecodcola_orig))
         {
            //-----  cdatecodcola
            if (!isset($array_total_cdatecodcola[$cdatecodcola_orig]))
            {
               $array_total_cdatecodcola[$cdatecodcola_orig][0] = $registro[0];
               $array_total_cdatecodcola[$cdatecodcola_orig][1] = $registro[1];
               $array_total_cdatecodcola[$cdatecodcola_orig][3] = NM_encode_input(sc_strip_script($val_grafico_cdatecodcola));
               $array_total_cdatecodcola[$cdatecodcola_orig][4] = $cdatecodcola_orig;
            }
            else
            {
               $array_total_cdatecodcola[$cdatecodcola_orig][0] += $registro[0];
               $array_total_cdatecodcola[$cdatecodcola_orig][1] += $registro[1];
            }
         } // isset
      }
   }
   //-----
   function get_array($rs)
   {
       if ('ado_mssql' != $this->Ini->nm_tpbanco)
       {
           return $rs->GetArray();
       }

       $array_db_total = array();
       while (!$rs->EOF)
       {
           $arr_row = array();
           foreach ($rs->fields as $k => $v)
           {
               $arr_row[$k] = $v . '';
           }
           $array_db_total[] = $arr_row;
           $rs->MoveNext();
       }
       return $array_db_total;
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
