<?php 
class Ordenes_Trabajo_SIAC_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->pg1 = $this->load->database('pg', TRUE);
        $this->pg1->save_queries = false;
    }
    public function insert_carga_notificacion($periodo, $descripcion, $observaciones,$resp,$maxEntregaNot,$numSub,$carga,$fechaInspeccion,$cantxhoras,$maxEntregaIns, $numSubInsp){
        //obtenemos el numero de la orden
        $codOrden = $this->get_numero_orden("distribucion_con_cedula","distribucion");
        $codOrdenInspExt = $this->get_numero_orden1("inspeccion_externa","inspeccion");
        $codOrdenInspInt = $this->get_numero_orden1("inspeccion_interna_uso_unico","inspeccion");
        $detalle_parametro = $this->get_one_detParam_x_codigo('no_rec');
        $actividad = $this->get_Id_actividad('distribucion');
        $actividad1 = $this->get_Id_actividad('inspeccion');
        $anio = intval(substr($periodo,0,4));
        $mes = intval(substr($periodo,4,2)) + 1;
        if($mes == 13){
            $mes = 1;
            $anio++;
        }
        $periodo = $anio.(($mes < 10) ? "0".$mes : $mes);
        $periodo1 = $this->get_Id_periodo($anio,$mes);
        $idContratante = $this->getContratante();
        $ultimonivel = $this->get_min_nivel($idContratante);
        $this->pg1->trans_begin();
        // SE INSERTA LA ORDEN DE TRABAJO PARA NOTIFICACIONES
        $query = $this->pg1->query('INSERT INTO "Orden_trabajo"("OrtNum","OrtDes","OrtObs",
		                            "OrtFchEj","OrtFchFin","OrtFchEn",
		                            "OrtFchEm","OrtEli","OrtFchRg",
		                            "OrtFchAc","OrtEstId","OrtConId",
                                    "OrtActId","OrtPrdId","OrtUsrEn",
                                    "OrtCntId","OrtNgrId") 
	                                VALUES (?,?,?,
		                            ?,?,?,
		                            ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?)',array('2017'.$codOrden,$descripcion,$observaciones,
                                    $resp['FMX1'],$resp['FMX2'],date("Y-m-d H:i:s"),
                                    $resp['FMX1'],false, date("Y-m-d H:i:s"),
                                    date("Y-m-d H:i:s"),$detalle_parametro,2,
                                    $actividad,$periodo1,136,
                                    $idContratante,$ultimonivel));
        $idOrden = $this->pg1->insert_id();
        // SE INSERTA LA ORDEN DE TRABAJO PARA INSPECCION INTERNA
        $query5 = $this->pg1->query('INSERT INTO "Orden_trabajo"("OrtNum","OrtDes","OrtObs",
		                            "OrtFchEj","OrtFchFin","OrtFchEn",
		                            "OrtFchEm","OrtEli","OrtFchRg",
		                            "OrtFchAc","OrtEstId","OrtConId",
                                    "OrtActId","OrtPrdId","OrtUsrEn",
                                    "OrtCntId","OrtNgrId") 
	                                VALUES (?,?,?,
		                            ?,?,?,
		                            ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?)',array('2017'.$codOrdenInspInt,$descripcion,$observaciones,
                                    $fechaInspeccion,$fechaInspeccion,date("Y-m-d H:i:s"),
                                    $maxEntregaIns,false, date("Y-m-d H:i:s"),
                                    date("Y-m-d H:i:s"),$detalle_parametro,2,
                                    $actividad1,$periodo1,136,
                                    $idContratante,$ultimonivel));
        $idOrdenInsInt = $this->pg1->insert_id();
        // SE INSERTA LA ORDEN DE TRABAJO PARA INSPECCION EXTERNA
        $query5 = $this->pg1->query('INSERT INTO "Orden_trabajo"("OrtNum","OrtDes","OrtObs",
		                            "OrtFchEj","OrtFchFin","OrtFchEn",
		                            "OrtFchEm","OrtEli","OrtFchRg",
		                            "OrtFchAc","OrtEstId","OrtConId",
                                    "OrtActId","OrtPrdId","OrtUsrEn",
                                    "OrtCntId","OrtNgrId") 
	                                VALUES (?,?,?,
		                            ?,?,?,
		                            ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?)',array('2017'.$codOrdenInspExt,$descripcion,$observaciones,
                                    $fechaInspeccion,$fechaInspeccion,date("Y-m-d H:i:s"),
                                    $maxEntregaIns,false, date("Y-m-d H:i:s"),
                                    date("Y-m-d H:i:s"),$detalle_parametro,2,
                                    $actividad1,$periodo1,136,
                                    $idContratante,$ultimonivel));
        $idOrdenInsExt = $this->pg1->insert_id();
        
        if ($this->pg1->trans_status() === FALSE) {
            $this->pg1->trans_rollback();
            return false;
        } else {

            $query31 = $this->pg1->query('INSERT INTO "Ordenes_asociadas" ("OrdAsOrdId", "OrdAsSacId", "OrdAsRefer") VALUES (?, ?, ?)', array($idOrden, 6, $idOrdenInsInt));
            $query32 = $this->pg1->query('INSERT INTO "Ordenes_asociadas" ("OrdAsOrdId", "OrdAsSacId", "OrdAsRefer") VALUES (?, ?, ?)', array($idOrdenInsInt, 9, $idOrdenInsInt));
            $query33 = $this->pg1->query('INSERT INTO "Ordenes_asociadas" ("OrdAsOrdId", "OrdAsSacId", "OrdAsRefer") VALUES (?, ?, ?)', array($idOrdenInsExt, 12, $idOrdenInsInt));
            //INSERTAMOS LAS SUBORDENES DE TRABAJO PARA NOTIFIACIONES
            $tipoSubOrden = $this->get_one_detParam_x_codigo('so_reg');
            $k = 1; 
            for($i = 0; $i < $numSub; $i++){
                $inicio = $i * 48;
                if(($i+1) <  $numSub) {
                    $montoCarga = 48;
                    $fin = ($i +1 )*$montoCarga;
                }
                else {
                    $montoCarga = sizeof($carga) % 48;
                    $fin = sizeof($carga);
                }
                
                $query1 = $this->pg1->query('INSERT INTO "Suborden_notificacion" ( "SonCod", "SonFchEj","SonEli",
                                            "SonFchRg", "SonFchAc", "SonTipId",
                                            "SonOrtId","SonMetPl","SonMetEj",
                                            "SonFchEjMovil","SonTipNt") VALUES (?,?,?,
                                            ?,?,?,
                                            ?,?,?,
                                            ?,?)',array(($i+1),$resp['FMX1'],false,
                                            date("Y-m-d H:i:s"), date("Y-m-d H:i:s"),$tipoSubOrden,
                                            $idOrden, $montoCarga, 0,
                                            $resp['FMX1'], 79));
                $idSubOrden = $this->pg1->insert_id();
                // buscar en la tabla detalle parametro  el numero 79 que es Facturación
                //INSERTAMOS LAS NOTIFICACIONES 
                $tipoNot = $this->get_one_detParam_x_codigo('nt_reg');
                $subActividad = $this->get_Id_subactividad('distribucion_con_cedula');
                for($j = $inicio; $j  < $fin; $j++){
                    $codigoCiclo = $this->get_one_gprPredio($carga[$j]['CICLO'],$ultimonivel);
                    $query2 = $this->pg1->query('INSERT INTO "Notificacion" ( "NtNmSu", "NtSacId","NtPrd",
                                                "NtFchEm","NtApeNom","NtPreCic","NtPreUrb",
                                                "NtPreCal","NtPreNroMun","NtPreMed","NtEli",
                                                "NtFchRg","NtSonId","NtTipId",
                                                "NtCntId","NtNumVis","NtFchAc",
                                                "NtTmImg","NtPreTar","NtPreCon","NtPreLecUlt","NtGprId","NtOrd") VALUES ( ?, ?, ?,
                                                ?, ?, ?, ?,
                                                ?, ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?, ?, ?, ?)',
                                                array( $carga[$j]['CLICODFAC'], $subActividad, $periodo,
                                                 date("Y-m-d H:i:s"), $carga[$j]['NOMBRE'], $carga[$j]['CICLO'], $carga[$j]['URBANIZAC'],
                                                 $carga[$j]['CALLE'], $carga[$j]['CLIMUNNRO'], $carga[$j]['MEDCODYGO'], false,
                                                 date("Y-m-d H:i:s"), $idSubOrden, $tipoNot,
                                                 $idContratante, 1, date("Y-m-d H:i:s"),
                                                 true, $carga[$j]['TARIFA'], $carga[$j]['CONZUMO'], $carga[$j]['LECTURA'],$codigoCiclo,$k));
                    $k++;
                }
            }
            $numSubInsp = intval(sizeof($carga) / 24);
            if(sizeof($carga) % 24 > 0) $numSubInsp++;
            #echo $numSubInsp."\n";
            $tipoNot = $this->get_one_detParam_x_codigo('nt_reg');
            for($i = 0; $i < $numSubInsp; $i++){
                #echo $i."\n";
                $inicio = $i * 24;
                if(($i+1) <  $numSubInsp) {
                    $fin = ($i +1 )*24;
                }  else { 
                    $fin = sizeof($carga);
                }
                #echo "inicio : ".$inicio."\n";
                #echo "finc : ".$fin."\n";

                $init = 8;
                for($j = $inicio; $j  < $fin; $j++){
                    #echo "sub: ".$j."\n";
                    if ($j % 3 == 0 && $j != 0 && $j % 24 != 0 ){
                        $init += 1;
                        if($init == 13) $init++;
                        $inici2o = $fechaInspeccion." ".$init.":00:00";
                        $fi2n = $fechaInspeccion." ".($init+1).":00:00";
                    } else {
                        $inici2o = $fechaInspeccion." ".$init.":00:00";
                        $fi2n = $fechaInspeccion." ".($init+1).":00:00";
                    }
                     
                    $query3 = $this->pg1->query('UPDATE "Notificacion" SET "NtFchMinIns" = ?, "NtFchMaxIns" = ? WHERE "NtNmSu" = ? AND "NtPrd" = ? AND "NtTipId" = ?',
                                                array($inici2o,$fi2n,$carga[$j]['CLICODFAC'],$periodo,$tipoNot));
                }
            }
            
            $tamanioMuestra = $this->get_tamanio_muestra_distribucion_supervision(sizeof($carga), 'z');
            //suborden de supervisión de notificación
            $idSupervisionNot = $numSub + 1;
            $idSupervisor = $this->get_distribuidor_supervisor($idContratante);
            $SonTipId = $this->get_one_detParam_x_codigo('so_sup');
            $query = $this->pg1->query('INSERT INTO "Suborden_notificacion" ("SonCod","SonFchEj","SonEli",
                                        "SonFchRg","SonFchAc","SonTipId",
                                        "SonOrtId","SonDbrId","SonMetPl",
                                        "SonMetEj","SonFchEjMovil","SonTipNt" ) 
                                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)'
                                            , array($idSupervisionNot, $resp['FMX1'], false, 
                                            date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $SonTipId , 
                                            $idOrden, $idSupervisor, $tamanioMuestra,
                                            0, $resp['FMX1'], 79));
            $idSubOrdenSup = $this->pg1->insert_id();
            $cargaNotificacion = $carga;
            $NtTipIdSup = $this->get_one_detParam_x_codigo('nt_sup');
            $k = 1;
            for ($i = 0; $i < $tamanioMuestra; $i++) {
                $rand=array_rand($cargaNotificacion);
                $idDistribucion = $cargaNotificacion[$rand];
                $codigoCiclo = $this->get_one_gprPredio($idDistribucion['CICLO'],$ultimonivel);
                $query = $this->pg1->query('INSERT INTO "Notificacion" ("NtNmSu","NtSacId","NtPrd",
                                "NtFchEm","NtApeNom","NtPreCic",
                                "NtPreUrb","NtPreCal","NtPreNroMun",
                                "NtPreMed","NtEli","NtFchRg",
                                "NtSonId","NtTipId","NtCntId",
                                "NtNumVis","NtFchAc","NtTmImg",
                                "NtPreTar","NtPreCon","NtPreLecUlt","NtGprId","NtOrd") 
                                VALUES (?,?,?,
                                ?,?,?,
                                ?,?,?,
                                ?,?,?,
                                ?,?,?,
                                ?,?,?,
                                ?,?,?,?, ?)' , array( $idDistribucion['CLICODFAC'], $subActividad, $periodo,
                                date("Y-m-d H:i:s"), $idDistribucion['NOMBRE'], $idDistribucion['CICLO'],
                                $idDistribucion['URBANIZAC'], $idDistribucion['CALLE'], $idDistribucion['CLIMUNNRO'],
                                $idDistribucion['MEDCODYGO'], false,  date("Y-m-d H:i:s"),
                                $idSubOrdenSup, $NtTipIdSup, $idContratante, 
                                1, date("Y-m-d H:i:s"), true, 
                                $idDistribucion['TARIFA'], $idDistribucion['CONZUMO'], $idDistribucion['LECTURA'],$codigoCiclo,$k));
                $k++;
                unset($cargaNotificacion[$rand]);
            }

            //INSERTAMOS LAS SUBORDENES DE TRABAJO DE INSPECCIÓN INTERNA
            $k = 1;
            for($i = 0; $i < $numSubInsp; $i++){
                $inicio = $i * 24;
                if(($i+1) <  $numSubInsp) {
                    $montoCarga = 24;
                    $fin = ($i +1 )*$montoCarga;
                }
                else {
                    $montoCarga = sizeof($carga) % 24;
                    $fin = sizeof($carga);
                }
                $query1 = $this->pg1->query('INSERT INTO "Suborden_inspecciones" ("SoinCod","SoinFchEj","SoinEli",
                                            "SoinFchRg","SoinFchAc","SoinTipId",
                                            "SoinOrtId","SoinMetPl","SoinMetEj",
                                            "SoinFchEjMovil","SoinTipIns" )
                                            VALUES (?,?,?,
                                            ?,?,?,
                                            ?,?,?,
                                            ?,?)',array(($i+1),$fechaInspeccion,false,
                                            date("Y-m-d H:i:s"), date("Y-m-d H:i:s"),$tipoSubOrden,
                                            $idOrdenInsInt, $montoCarga, 0,
                                            $fechaInspeccion, 79));
                $idSubOrdenInsInt = $this->pg1->insert_id();
                $tipoInspInt = $this->get_one_detParam_x_codigo('ins_reg');
                $subActividadInsInt = $this->get_Id_subactividad('inspeccion_interna_uso_unico');
                $init = 8;
                for($j = $inicio; $j  < $fin; $j++){
                    if ($j % 3 == 0 && $j != 0 && $j % 24 != 0 ){
                        $init += 1;
                        if($init == 13) $init++;
                        $inici2o = $fechaInspeccion." ".$init.":00:00";
                        $fi2n = $fechaInspeccion." ".($init+1).":00:00";
                    } else {
                        $inici2o = $fechaInspeccion." ".$init.":00:00";
                        $fi2n = $fechaInspeccion." ".($init+1).":00:00";
                    }
                    $codigoCiclo = $this->get_one_gprPredio($carga[$j]['CICLO'],$ultimonivel);
                    $query7 = $this->pg1->query('INSERT INTO "Inspeccion_otra" ( "InoSum", "InoSacId", "InoPerd",
                                                "InoFchEm","InoPreTel",
                                                "InoApeNom", "InoDni","InoRazSoc",
                                                "InoPreCic", "InoPrePrv", "InoPreLoc",
                                                "InoPreUrb", "InoPreCal", "InoPreNroMun",
                                                "InoPreMed","InoPreTar", "InoPreCon",
                                                "InoPreLecUlt", "InoFchMinIns","InoFchMaxIns",
                                                "InoEli", "InoFchRg", "InoFchAc",
                                                "InoSoinId", "InoTipId", "InoCntId",
                                                "InoGprId","InoOrd", "InoPreCalRef",
                                                "InoPreNroMunRef", "InoPreMzaRef", "InoPreUrbRef",
                                                "InoPrePrvRef", "InoPreLocRef") 
                                        VALUES ( ?, ?, ?,
                                                 ?, ?, ?, 
                                                 ?, ?,
                                                 ?, ?, ?,
                                                 ?, ?, ?,
                                                 ?, ?, ?,
                                                 ?, ?, ?,
                                                 ?, ?, ?,
                                                 ?, ?, ?, 
                                                 ?, ?, ?,
                                                 ?, ?, ?,
                                                 ?, ?)',
                                                array( $carga[$j]['CLICODFAC'], $subActividadInsInt, $periodo,
                                                 date("Y-m-d H:i:s"), $carga[$j]['TELEFONO'],
                                                 $carga[$j]['NOMBRE'], $carga[$j]['DNI'], $carga[$j]['RUC'],
                                                 $carga[$j]['CICLO'], $carga[$j]['PROVINCIA'], $carga[$j]['LOCALIDAD'],
                                                 $carga[$j]['URBANIZAC'], $carga[$j]['CALLE'], $carga[$j]['CLIMUNNRO'], 
                                                 $carga[$j]['MEDCODYGO'], $carga[$j]['TARIFA'], $carga[$j]['CONZUMO'],
                                                 $carga[$j]['LECTURA'],$inici2o, $fi2n,
                                                 false, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"),
                                                 $idSubOrdenInsInt, $tipoInspInt, $idContratante,
                                                 $codigoCiclo, $k, $carga[$j]['CALLE'],
                                                 $carga[$j]['CLIMUNNRO'], '', $carga[$j]['URBANIZAC'],
                                                 $carga[$j]['PROVINCIA'], $carga[$j]['LOCALIDAD']));
                    $k++;
                    $idInsIntDet = $this->pg1->insert_id();
                    $query8 = $this->pg1->query('INSERT INTO "Ficha_interna" ("FinInoId","FinTipId","FinEli","FinFchRg","FinFchAc","FinTmImg") 
                                                VALUES (?,?,?,?,?,?)',array($idInsIntDet,$tipoInspInt,false,date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),true));
                }
            }

            $idSupervisionInsInt = $numSubInsp + 1;
            $idSupervisor = $this->get_inspector_supervisor($idContratante);
            $query1 = $this->pg1->query('INSERT INTO "Suborden_inspecciones" ("SoinCod","SoinFchEj","SoinEli",
                                        "SoinFchRg","SoinFchAc","SoinTipId",
                                        "SoinOrtId","SoinMetPl","SoinMetEj",
                                        "SoinFchEjMovil","SoinTipIns","SoinIprId" )
                                        VALUES (?,?,?,
                                        ?,?,?,
                                        ?,?,?,
                                        ?,?,?)',array($idSupervisionInsInt,$fechaInspeccion,false,
                                        date("Y-m-d H:i:s"), date("Y-m-d H:i:s"),$SonTipId,
                                        $idOrdenInsInt, $tamanioMuestra, 0,
                                        $fechaInspeccion, 79,$idSupervisor));
            $idSubOrdenSup = $this->pg1->insert_id();
            $NtTipIdSup = $this->get_one_detParam_x_codigo('ins_sup');
            $cargaInspeccionInterna = $carga;
            $k = 1;
            for ($i = 0; $i < $tamanioMuestra; $i++) {
                $rand=array_rand($cargaInspeccionInterna);
                $idDistribucion = $cargaInspeccionInterna[$rand];
                $query28 = $this->pg1->query('SELECT "InoFchMinIns","InoFchMaxIns" FROM "Inspeccion_otra" WHERE "InoSum" = ? AND "InoPerd" = ?',array($idDistribucion['CLICODFAC'], $periodo));
                $fechas = $query28->row_array();
                $codigoCiclo = $this->get_one_gprPredio($idDistribucion['CICLO'],$ultimonivel);
                $query = $this->pg1->query('INSERT INTO "Inspeccion_otra" ( "InoSum", "InoSacId", "InoPerd",
                                                "InoFchEm","InoPreTel",
                                                "InoApeNom", "InoDni","InoRazSoc",
                                                "InoPreCic", "InoPrePrv", "InoPreLoc",
                                                "InoPreUrb", "InoPreCal", "InoPreNroMun",
                                                "InoPreMed","InoPreTar", "InoPreCon",
                                                "InoPreLecUlt", "InoFchMinIns","InoFchMaxIns",
                                                "InoEli", "InoFchRg", "InoFchAc",
                                                "InoSoinId", "InoTipId", "InoCntId",
                                                "InoGprId","InoOrd", "InoPreCalRef",
                                                "InoPreNroMunRef", "InoPreMzaRef", "InoPreUrbRef",
                                                "InoPrePrvRef", "InoPreLocRef") 
                                        VALUES ( ?, ?, ?,
                                                ?, ?,
                                                ?, ?, ?, 
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?, 
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?)' , array( $idDistribucion['CLICODFAC'], $subActividadInsInt, $periodo,
                                                date("Y-m-d H:i:s"), $idDistribucion['TELEFONO'],
                                                $idDistribucion['NOMBRE'], $idDistribucion['DNI'], $idDistribucion['RUC'],
                                                $idDistribucion['CICLO'], $idDistribucion['PROVINCIA'], $idDistribucion['LOCALIDAD'],
                                                $idDistribucion['URBANIZAC'], $idDistribucion['CALLE'], $idDistribucion['CLIMUNNRO'],
                                                $idDistribucion['MEDCODYGO'],$idDistribucion['TARIFA'], $idDistribucion['CONZUMO'],
                                                $idDistribucion['LECTURA'], $fechas['InoFchMinIns'], $fechas['InoFchMaxIns'],
                                                false,  date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),
                                                $idSubOrdenSup,$NtTipIdSup, $idContratante,
                                                $codigoCiclo,$k, $idDistribucion['CALLE'],
                                                $idDistribucion['CLIMUNNRO'], '', $idDistribucion['URBANIZAC'],
                                                $idDistribucion['PROVINCIA'], $idDistribucion['LOCALIDAD']
                                            ));
                $idInsIntDet = $this->pg1->insert_id();
                $k++;
                $query89 = $this->pg1->query('INSERT INTO "Ficha_interna" ("FinInoId","FinTipId","FinEli","FinFchRg","FinFchAc","FinTmImg") 
                                    VALUES (?,?,?,?,?,?)',array($idInsIntDet,$NtTipIdSup,false,date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),true));
                unset($cargaInspeccionInterna[$rand]);
            }

            //INSERTAMOS LAS SUBORDENES DE TRABAJO DE INSPECCIÓN EXTERNA
            $k = 1;
            for($i = 0; $i < $numSubInsp; $i++){
                $inicio = $i * 24;
                if(($i+1) <  $numSubInsp) {
                    $montoCarga = 24;
                    $fin = ($i +1 )*$montoCarga;
                }
                else {
                    $montoCarga = sizeof($carga) % 24;
                    $fin = sizeof($carga);
                }
                $query1 = $this->pg1->query('INSERT INTO "Suborden_inspecciones" ("SoinCod","SoinFchEj","SoinEli",
                                            "SoinFchRg","SoinFchAc","SoinTipId",
                                            "SoinOrtId","SoinMetPl","SoinMetEj",
                                            "SoinFchEjMovil","SoinTipIns" )
                                            VALUES (?,?,?,
                                            ?,?,?,
                                            ?,?,?,
                                            ?,?)',array(($i+1),$fechaInspeccion,false,
                                            date("Y-m-d H:i:s"), date("Y-m-d H:i:s"),$tipoSubOrden,
                                            $idOrdenInsExt, $montoCarga, 0,
                                            $fechaInspeccion, 79));
                $idSubOrdenInsExt = $this->pg1->insert_id();
                $tipoInspExt = $this->get_one_detParam_x_codigo('ins_reg');
                $subActividadInsExt = $this->get_Id_subactividad('inspeccion_externa');
                $init = 8;
                for($j = $inicio; $j  < $fin; $j++){
                    if ($j % 3 == 0 && $j != 0 && $j % 24 != 0 ){
                        $init += 1;
                        if($init == 13) $init++;
                        $inici2o = $fechaInspeccion." ".$init.":00:00";
                        $fi2n = $fechaInspeccion." ".($init+1).":00:00";
                    } else {
                        $inici2o = $fechaInspeccion." ".$init.":00:00";
                        $fi2n = $fechaInspeccion." ".($init+1).":00:00";
                    }
                    $codigoCiclo = $this->get_one_gprPredio($carga[$j]['CICLO'],$ultimonivel);
                    $query7 = $this->pg1->query('INSERT INTO "Inspeccion_otra" ( 
                                                "InoSum", "InoSacId", "InoPerd",
                                                "InoFchEm","InoPreTel",
                                                "InoApeNom", "InoDni","InoRazSoc",
                                                "InoPreCic", "InoPrePrv", "InoPreLoc",
                                                "InoPreUrb", "InoPreCal", "InoPreNroMun",
                                                "InoPreMed","InoPreTar", "InoPreCon",
                                                "InoPreLecUlt", "InoFchMinIns","InoFchMaxIns",
                                                "InoEli", "InoFchRg", "InoFchAc",
                                                "InoSoinId", "InoTipId", "InoCntId",
                                                "InoGprId","InoOrd", "InoPreCalRef",
                                                "InoPreNroMunRef", "InoPreMzaRef", "InoPreUrbRef",
                                                "InoPrePrvRef", "InoPreLocRef") 
                                        VALUES ( ?, ?, ?,
                                                ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?, 
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?)',
                                                array( $carga[$j]['CLICODFAC'], $subActividadInsExt, $periodo,
                                                 date("Y-m-d H:i:s"), $carga[$j]['TELEFONO'],
                                                 $carga[$j]['NOMBRE'], $carga[$j]['DNI'], $carga[$j]['RUC'],
                                                 $carga[$j]['CICLO'], $carga[$j]['PROVINCIA'], $carga[$j]['LOCALIDAD'],
                                                 $carga[$j]['URBANIZAC'], $carga[$j]['CALLE'], $carga[$j]['CLIMUNNRO'], 
                                                 $carga[$j]['MEDCODYGO'], $carga[$j]['TARIFA'], $carga[$j]['CONZUMO'],
                                                 $carga[$j]['LECTURA'],$inici2o, $fi2n,
                                                 false, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"),
                                                 $idSubOrdenInsExt, $tipoInspExt, $idContratante, 
                                                 $codigoCiclo,$k, $carga[$j]['CALLE'],
                                                 $carga[$j]['CLIMUNNRO'], '', $carga[$j]['URBANIZAC'],
                                                 $carga[$j]['PROVINCIA'], $carga[$j]['LOCALIDAD']));
                    $k++;
                    $idInsExtDet = $this->pg1->insert_id();
                    $query8 = $this->pg1->query('INSERT INTO "Ficha_externa" ("FexInoId","FexTipId","FexEli","FexFchRg","FexFchAc","FexTmImg") 
                                                VALUES (?,?,?,?,?,?)',array($idInsExtDet,$tipoInspExt,false,date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),true));
                }
            }

            $idSupervisionInsExt = $numSubInsp + 1;
            $idSupervisor = $this->get_inspector_supervisor($idContratante);
            $query1 = $this->pg1->query('INSERT INTO "Suborden_inspecciones" ("SoinCod","SoinFchEj","SoinEli",
                                        "SoinFchRg","SoinFchAc","SoinTipId",
                                        "SoinOrtId","SoinMetPl","SoinMetEj",
                                        "SoinFchEjMovil","SoinTipIns","SoinIprId" )
                                        VALUES (?,?,?,
                                        ?,?,?,
                                        ?,?,?,
                                        ?,?,?)',array($idSupervisionInsExt,$fechaInspeccion,false,
                                        date("Y-m-d H:i:s"), date("Y-m-d H:i:s"),$SonTipId,
                                        $idOrdenInsExt, $tamanioMuestra, 0,
                                        $fechaInspeccion, 79,$idSupervisor));
            $idSubOrdenSup = $this->pg1->insert_id();
            $NtTipIdSup = $this->get_one_detParam_x_codigo('ins_sup');
            $cargaInspeccionExterna = $carga;
            $k = 1;
            for ($i = 0; $i < $tamanioMuestra; $i++) {
                $rand=array_rand($cargaInspeccionExterna);
                $idDistribucion = $cargaInspeccionExterna[$rand];
                $query28 = $this->pg1->query('SELECT "InoFchMinIns","InoFchMaxIns" FROM "Inspeccion_otra" WHERE "InoSum" = ? AND "InoPerd" = ?',array($idDistribucion['CLICODFAC'], $periodo));
                $fechas = $query28->row_array();
                $codigoCiclo = $this->get_one_gprPredio($idDistribucion['CICLO'],$ultimonivel);
                $query = $this->pg1->query('INSERT INTO "Inspeccion_otra" ( "InoSum", "InoSacId", "InoPerd",
                                                "InoFchEm","InoPreTel",
                                                "InoApeNom", "InoDni","InoRazSoc",
                                                "InoPreCic", "InoPrePrv", "InoPreLoc",
                                                "InoPreUrb", "InoPreCal", "InoPreNroMun",
                                                "InoPreMed","InoPreTar", "InoPreCon",
                                                "InoPreLecUlt", "InoFchMinIns","InoFchMaxIns",
                                                "InoEli", "InoFchRg", "InoFchAc",
                                                "InoSoinId", "InoTipId", "InoCntId",
                                                "InoGprId","InoOrd", "InoPreCalRef",
                                                "InoPreNroMunRef", "InoPreMzaRef", "InoPreUrbRef",
                                                "InoPrePrvRef", "InoPreLocRef") 
                                        VALUES ( ?, ?, ?,
                                                ?, ?,
                                                ?, ?, ?, 
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?, ?, 
                                                ?, ?, ?,
                                                ?, ?, ?,
                                                ?, ?)' , 
                                            array( $idDistribucion['CLICODFAC'], $subActividadInsExt, $periodo,
                                                date("Y-m-d H:i:s"), $idDistribucion['TELEFONO'],
                                                $idDistribucion['NOMBRE'], $idDistribucion['DNI'], $idDistribucion['RUC'],
                                                $idDistribucion['CICLO'], $idDistribucion['PROVINCIA'], $idDistribucion['LOCALIDAD'],
                                                $idDistribucion['URBANIZAC'], $idDistribucion['CALLE'], $idDistribucion['CLIMUNNRO'],
                                                $idDistribucion['MEDCODYGO'],$idDistribucion['TARIFA'], $idDistribucion['CONZUMO'],
                                                $idDistribucion['LECTURA'], $fechas['InoFchMinIns'], $fechas['InoFchMaxIns'],
                                                false,  date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),
                                                $idSubOrdenSup,$NtTipIdSup, $idContratante, 
                                                $codigoCiclo, $k, $idDistribucion['CALLE'],
                                                $idDistribucion['CLIMUNNRO'], '', $idDistribucion['URBANIZAC'],
                                                $idDistribucion['PROVINCIA'], $idDistribucion['LOCALIDAD']));
                $k++;
                $idInsIntDet = $this->pg1->insert_id();
                $query89 = $this->pg1->query('INSERT INTO "Ficha_externa" ("FexInoId","FexTipId","FexEli","FexFchRg","FexFchAc","FexTmImg")
                                    VALUES (?,?,?,?,?,?)',array($idInsIntDet,$NtTipIdSup,false,date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),true));
                unset($cargaInspeccionExterna[$rand]);
            }

            $this->pg1->trans_commit();
            return true;
        }                              
    }
    private function get_numero_orden($subactividad,$actividad){
        $conCedula = $this->get_Id_subactividad($subactividad);
        $actividad = $this->get_Id_actividad($actividad);
        $idContratante = $this->getContratante();
        $idContrato = 2;
        $ordenes = $this->getOrdenesTrabajo($idContratante,$actividad, $idContrato,$conCedula, date('Y'));
        if (empty($ordenes)) $codOrden = str_pad(1, 6, '0', STR_PAD_LEFT);
        else $codOrden = str_pad(count($ordenes) + 1, 6, '0', STR_PAD_LEFT); 
        return $codOrden;
        //id contrato =  2
        //id usuario = 136
    }    

    public function get_min_nivel($CntId){
        $query = $this->pg1->query('SELECT "NgrId" FROM "Nivel_grupo" WHERE "NgrCntId" = ? AND "NgrEli" IS FALSE ORDER BY "NgrOrd" ASC LIMIT 1', array($CntId));
        return $query->row_array()["NgrId"];
    }

    public function get_tamanio_muestra_distribucion_supervision($poblacion, $variable) {
        $idContrato = 2;
        $idContratante = $this->getContratante();
        $Z = floatval($this->get_variable2_activa($idContratante, 'variable_contrato', $variable, $idContrato)['VarVal']);
        $muestra = round((pow(floatval($Z), 2) * 0.5 * 0.5 * intval($poblacion)) / (pow(0.05, 2) * (intval($poblacion) - 1) + pow(floatval($Z), 2) * 0.5 * 0.5));
        return $muestra;
    }

    public function get_one_gprPredio($id,$nivel){
        $query = $this->pg1->query('SELECT "GprId" FROM "Grupo_predio" WHERE "GprCod" = ? AND "GprNgrId" = ?', array($id,$nivel));
        return $query->row_array()["GprId"];
    }

    public function get_variable2_activa($idContratante, $codTipoVariable, $codVariable, $contrato){
        $query = $this->pg1->query('SELECT * FROM "Variable" 
            WHERE "VarConId"= ? 
            AND "VarCntId" = ? 
            AND "VarTipo" = ? 
            AND "VarCod" = ? 
            AND "VarEli" IS FALSE 
            AND DATE(NOW()) >= DATE("VarFchIn") 
            ORDER BY "VarFchIn" DESC', array($contrato, $idContratante, $codTipoVariable, $codVariable));
        return $query->row_array();
    }

    private function get_numero_orden1($subactividad,$actividad){
        $conCedula = $this->get_Id_subactividad($subactividad);
        $actividad = $this->get_Id_actividad($actividad);
        $idContratante = $this->getContratante();
        $idContrato = 2;
        $ordenes = $this->getOrdenesTrabajo1($idContratante,$actividad, $idContrato,$conCedula, date('Y'));
        if (empty($ordenes)) $codOrden = str_pad(1, 6, '0', STR_PAD_LEFT);
        else $codOrden = str_pad(count($ordenes) + 1, 6, '0', STR_PAD_LEFT); 
        return $codOrden;
        //id contrato =  2
        //id usuario = 136
    }  

    private function get_distribuidor_supervisor($idContratante){
        $query = $this->pg1->query('SELECT "DbrId" FROM "Distribuidor" JOIN "Usuario" ON "DbrUsrId" = "UsrId"
         WHERE "DbrEli" = FALSE AND "DbrSup" = TRUE AND "DbrCntId" = ?', array($idContratante));
        return $query->row_array()['DbrId'];
    }

    private function get_inspector_supervisor($idContratante){
        $query = $this->pg1->query('SELECT "IprId" FROM "Inspector" JOIN "Usuario" ON "IprUsrId" = "UsrId"
         WHERE "IprEli" = FALSE AND "IprSup" = TRUE AND "IprCntId" = ?', array($idContratante));
        return $query->row_array()['IprId'];
    }

    private function get_Id_subactividad($str){
        $query = $this->pg1->query('SELECT "SacId" FROM "Subactividad" WHERE "SacCod" = ? AND "SacEli" = FALSE',array($str));
        return $query->row_array()['SacId'];
    }
    private function get_Id_actividad($str){
        $query = $this->pg1->query('SELECT "ActId" FROM "Actividad" WHERE "ActEli" = FALSE AND "ActCod" = ? ORDER BY "ActDes" ASC',array($str));
        return $query->row_array()["ActId"];
    }
    private function getContratante(){
        $query = $this->pg1->query('SELECT "UsrCntId" FROM "Usuario" JOIN "Cargo" ON "UsrCarId" = "CarId" WHERE "UsrId" = 136');
        return $query->row_array()['UsrCntId'];
    }
    private function get_Id_periodo($anio,$mes){
        $query = $this->pg1->query('SELECT "PrdId" FROM "Periodo" WHERE "PrdOrd" = ? AND "PrdAni" = ?',array($mes,$anio));
        return $query->row_array()['PrdId'];
    }
    public function getOrdenesTrabajo($idContratante, $idActividad,$idContrato, $conCedula,$anio){
        $query = $this->pg1->query('SELECT "OrtId" FROM "Orden_trabajo"  JOIN "Suborden_notificacion" ON "SonOrtId" = "OrtId"
                                    JOIN "Notificacion" ON "NtSonId" = "SonId" WHERE "OrtActId" = ? AND "OrtCntId" = ? AND "OrtConId" = ? AND "NtSacId" = ?
                                    AND "OrtNum" LIKE  ?  AND "OrtEli" IS NOT TRUE  GROUP BY "OrtId"
                                    ORDER BY "OrtFchEj"', array($idActividad, $idContratante, $idContrato, $conCedula,'2017%')); 
        return $query->result_array();
    }

    public function getOrdenesTrabajo1($idContratante, $idActividad,$idContrato, $conCedula,$anio){
        $query = $this->pg1->query('SELECT "OrtId" FROM "Orden_trabajo"  JOIN "Suborden_inspecciones" ON "SoinOrtId" = "OrtId"
                                    JOIN "Inspeccion_otra" ON "InoSoinId" = "SoinId" WHERE "OrtActId" = ? AND "OrtCntId" = ? AND "OrtConId" = ? AND "InoSacId" = ?
                                    AND "OrtNum" LIKE ?  AND "OrtEli" IS NOT TRUE  GROUP BY "OrtId"
                                    ORDER BY "OrtFchEj"', array($idActividad, $idContratante, $idContrato, $conCedula,'2017%'));
        return $query->result_array();
    }

    public function get_one_detParam_x_codigo($codDetParam) {
        $query = $this->pg1->query('SELECT "DprId" FROM "Detalle_parametro"
                           WHERE "DprCod" = ? AND "DprEli" = FALSE', array($codDetParam));
        return $query->row_array()['DprId'];
    }

    public function get_ordenes_registradas(){
        $conCedula = $this->get_Id_subactividad('distribucion_con_cedula');
        $actividad = $this->get_Id_actividad('distribucion');
        $idContratante = $this->getContratante();
        $idContrato = 2;
        $query = $this->pg1->query('SELECT "OrtId","OrtNum","NtPrd",count("NtSonId") AS "CANT","OrtFchEj","OrtFchFin","OrtFchEm" FROM "Orden_trabajo"  JOIN "Suborden_notificacion" ON 
                                    "SonOrtId" = "OrtId" JOIN "Notificacion" ON "NtSonId" = "SonId" WHERE "OrtActId" = ? AND "OrtCntId" = ?
                                    AND "OrtConId" = ? AND "NtSacId" = ? AND "SonTipNt" = 79 AND "SonTipId" = 16 AND "OrtEli" IS NOT TRUE GROUP BY 
                                    "OrtId","NtPrd" ORDER BY "OrtFchEj" DESC',array($actividad,$idContratante,$idContrato,$conCedula));
        return $query->result_array();
    }

    public function getCiclosxOrden($id){
        $conCedula = $this->get_Id_subactividad('distribucion_con_cedula');
        $actividad = $this->get_Id_actividad('distribucion');
        $idContratante = $this->getContratante();
        $idContrato = 2;
        $query = $this->pg1->query('SELECT "NtPreCic" FROM "Orden_trabajo"  JOIN "Suborden_notificacion" ON 
                                    "SonOrtId" = "OrtId" JOIN "Notificacion" ON "NtSonId" = "SonId" WHERE "OrtActId" = ? AND "OrtCntId" = ?
                                    AND "OrtConId" = ? AND "NtSacId" = ? AND "SonTipNt" = 79 AND "OrtEli" IS NOT TRUE AND "OrtId" = ? GROUP BY 
                                    "OrtId","NtPrd","NtPreCic" ORDER BY "OrtFchEj"',array($actividad,$idContratante,$idContrato,$conCedula,$id));
        return $query->result_array();
    }
}