<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|----------------------------------------------------------------------------
| Acceso al Sistema y Configuración
|----------------------------------------------------------------------------
|
*/
		$route['login'] 									= 'acceso/Acceso_ctrllr/mostrar';
		$route['login1'] 									= 'acceso/Acceso_ctrllr/mostrar1';
		$route['ingresar'] 									= 'acceso/Acceso_ctrllr/login';
		$route['logout'] 									= 'acceso/Acceso_ctrllr/logout';
		$route['inicio'] 									= 'acceso/Acceso_ctrllr/inicio';
		$route['configurar/usuario'] 						= 'acceso/Acceso_ctrllr/configurar_usuario';
		$route['update_psw']	 							= 'acceso/Acceso_ctrllr/actualizar_psw';


		/*$route['libro_observaciones'] = 'externo/Libro_ctrllr/inicio';
		$route['libro_observaciones/dni'] = 'externo/Libro_ctrllr/buscar';
		$route['libro_observaciones/pdf/(:any)'] = 'externo/Libro_ctrllr/exportPDF/$1';*/

		$route['libro_observaciones'] = 'externo/Libro_ctrllr/inicio';
		$route['libro_observaciones/dni'] = 'externo/Libro_ctrllr/buscar';
		$route['libro_observaciones/buscar'] = 'externo/Libro_ctrllr/buscarObservaciones';
		$route['libro_observaciones/pdf/(:any)'] = 'externo/Libro_ctrllr/exportPDF/$1';


		$route['libro_obs/administrar'] = 'libro/Libro_Observaciones_ctrllr/listar';
		$route['libro_obs/administrar/detalle/(:any)'] = 'libro/Libro_Observaciones_ctrllr/ver/$1';
		$route['libro_obs/administrar/buscar'] = 'libro/Libro_Observaciones_ctrllr/buscar';

/*********** START ROUTES PERMISOS *******/
$route['permisos/administrar_usuarios'] = 'permisos/Usuarios_ctrllr/listar_usuarios';
$route['permisos/administrar_usuarios/editar/(:num)'] = 'permisos/Usuarios_ctrllr/editar_usuario/$1';
$route['permisos/administrar_usuarios/agregar'] = 'permisos/Usuarios_ctrllr/crear_usuario';
$route['permisos/administrar_usuarios/validar_login'] = 'permisos/Usuarios_ctrllr/validar_login';
$route['permisos/get_areas'] = 'permisos/Usuarios_ctrllr/get_areas';
$route['permisos/guardar_usuario'] = 'permisos/Usuarios_ctrllr/guardar_usuario';
$route['permisos/get_users'] = 'permisos/Usuarios_ctrllr/buscar_usaurios';
$route['permisos/get_user'] = 'permisos/Usuarios_ctrllr/buscar_usuario';
$route['permisos/get_actividades_x_rol'] = 'permisos/Usuarios_ctrllr/get_actividades';

$route['permisos/administrar_actividades'] = 'permisos/Actividades_ctrllr/listar_actividades';
$route['permisos/administrar_actividades/nueva_actividad'] = 'permisos/Actividades_ctrllr/crear_actividad';
$route['permisos/administrar_actividades/editar_actividad'] = 'permisos/Actividades_ctrllr/editar_actividad';
$route['permisos/administrar_actividades/actualizar_actividad'] = 'permisos/Actividades_ctrllr/actualizar_actividad';

$route['permisos/administrar_roles'] = 'permisos/Roles_ctrllr/listar_roles';
$route['permisos/administrar_roles/detalle_rol'] = 'permisos/Roles_ctrllr/get_menus_actividades';
$route['permisos/administrar_roles/menus'] = 'permisos/Roles_ctrllr/get_menus';
$route['permisos/administrar_roles/actividades'] = 'permisos/Roles_ctrllr/get_actividades';
$route['permisos/administrar_roles/actividades1'] = 'permisos/Roles_ctrllr/get_actividades1';
$route['permisos/administrar_roles/get_actividades'] = 'permisos/Roles_ctrllr/get_actividades2';
$route['permisos/administrar_roles/get_actividades1'] = 'permisos/Roles_ctrllr/get_actividades3';
$route['permisos/administrar_roles/update_roles'] = 'permisos/Roles_ctrllr/actualizar_rol';
$route['permisos/administrar_roles/menus1'] = 'permisos/Roles_ctrllr/get_menus1';
$route['permisos/administrar_roles/guardar_rol'] = 'permisos/Roles_ctrllr/save_rol';

$route['permisos/administrar_opciones'] = 'permisos/Opciones_ctrllr/listar_opciones';
$route['permisos/administrar_opciones/get_actividades'] = 'permisos/Opciones_ctrllr/get_actividades';
$route['permisos/administrar_opciones/get_botones'] = 'permisos/Opciones_ctrllr/get_procesos';
$route['permisos/administrar_opciones/save_botones'] = 'permisos/Opciones_ctrllr/guardar_botones';

/***********  END ROUTES PERMISOS *******/

/**************************************************************************************************************************************************************************************************************************
*																			AUTORIZACIONES PARA NOTA DE CRÉDITO																													  *
***************************************************************************************************************************************************************************************************************************/
		#1.0 Autorizaciones para generar nota de crédito a boletas y facturas
			$route['autorizacion/boletas_facturas'] 			= 'autorizacion/Autorizacion_BF_ctrllr/listar_autorizaciones';
			$route['autorizacion/buscar_factura_boleta'] 		= 'autorizacion/Autorizacion_BF_ctrllr/buscar_factura_boleta';
			$route['autorizacion/registrar_autorizacion'] 		= 'autorizacion/Autorizacion_BF_ctrllr/registrar_autorizacion';

#recibos
$route['autorizacion/recibos'] = 'autorizacion/Autorizacion_Recibos_ctrllr/listar_autorizaciones';
$route['autorizacion/recibos/busqueda'] = 'autorizacion/Autorizacion_Recibos_ctrllr/buscar_recibo';
$route['autorizacion/recibos/autorizar_recibos'] = 'autorizacion/Autorizacion_Recibos_ctrllr/save_autorizacion';

#anulación nota crédito
$route['autorizacion/anular_nota_credito'] = 'autorizacion/Autorizacion_Nota_ctrllr/listar_autorizaciones';
$route['autorizacion/nota_credito/busqueda'] = 'autorizacion/Autorizacion_Nota_ctrllr/bsucar_nota_credito';
$route['autorizacion/nota_credito/autorizar_anulacion'] = 'autorizacion/Autorizacion_Nota_ctrllr/save_autorizacion';

/******** END AUTORIZACIONES  ************/

/*
***********************************************************************************************************************************
*                                        RUTAS PARA LA ACTIVIDAD DE CUENTAS CORRIENTES                                            *
*                                      -------------------------------------------------                                          *
***********************************************************************************************************************************
*/

	#1.0 SIAC
		$route['cuenta_corriente/siac'] 					= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/informe_siac';

	#2.0 CUENTAS CORRIENTES - Panel de búsquedas
		$route['cuenta_corriente/cuenta'] 					= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/cuentas_corrientes';
		$route['cuenta_corriente/buscar_cliente'] 			= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/buscar_cliente';
		$route['cuenta_corriente/busqueda_multiple'] 		= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/busqueda_multiple';
		$route['cuenta_corriente/consultar_cartera'] 		= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/ver_cuenta';
		$route['cuenta_corriente/mostrar_cartera/(:num)']	= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/mostrar_cuenta/$1';
	#2.4 CUENTAS CORRIENTES - Otras opciones
		$route['cuenta_corriente/get_pediodo_facturacion'] 							= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/get_periodo';
		$route['cuenta_corriente/obtener_duplicado']								= 'cuenta_corriente/Cuentas_Corrientes_ctrllr/obtener_recibo_duplciado';




		


/*
|-----------------------------------------------------------------------------
| Acceso a Reclamos opercionales y comerciales relativos a la no facturación
|-----------------------------------------------------------------------------
|
|       Acceso a la actividad de registro de los reclamos con respecto a 
|       la no facturación y operacionales.
|       
|
*/

        #1.0 Solicitud General
        $route['relativo_no_facturacion/solicitud_general']                                     = 'reclamo_no_facturacion/Solicitud_general_ctrllr/inicio';
        $route['relativo_no_facturacion/solicitud_general/nuevo']                               = 'reclamo_no_facturacion/Solicitud_general_ctrllr/nuevoReclamo';
        $route['relativo_no_facturacion/solicitud_general/buscar']                              = 'reclamo_no_facturacion/Solicitud_general_ctrllr/buscar';
		$route['relativo_no_facturacion/solicitud_general/cambiarProvincia']                    = 'reclamo_no_facturacion/Solicitud_general_ctrllr/cambiarProvincia';
		$route['relativo_no_facturacion/solicitud_general/cambiarDistrito']                     = 'reclamo_no_facturacion/Solicitud_general_ctrllr/cambiarDistrito';
		$route['relativo_no_facturacion/solicitud_general/cambiarGrupoPobla']                   = 'reclamo_no_facturacion/Solicitud_general_ctrllr/cambiarGrupoPobla';
        $route['relativo_no_facturacion/solicitud_general/ver/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)']     = 'reclamo_no_facturacion/Solicitud_general_ctrllr/verPDF/$1/$2/$3/$4/$5/$6/$7';


        #2.0 Solicitud Particular
        $route['relativo_no_facturacion/solicitud_particular']                                  = 'reclamo_no_facturacion/Solicitud_particular_ctrllr/inicio';
        $route['relativo_no_facturacion/solicitud_particular/nuevo']                            = 'reclamo_no_facturacion/Solicitud_particular_ctrllr/nuevoReclamo';
        $route['relativo_no_facturacion/solicitud_particular/buscar']                           = 'reclamo_no_facturacion/Solicitud_particular_ctrllr/buscar';
        $route['relativo_no_facturacion/solicitud_particular/cambiarProvincia']                 = 'reclamo_no_facturacion/Solicitud_particular_ctrllr/cambiarProvincia';
		$route['relativo_no_facturacion/solicitud_particular/ver/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)']     = 'reclamo_no_facturacion/Solicitud_particular_ctrllr/verPDF/$1/$2/$3/$4/$5/$6/$7';
		
		#3.0 Respuestas a las solicitudes
		$route['relativo_no_facturacion/respuesta'] = 'reclamo_no_facturacion/Respuesta_ctrllr/inicio';
		$route['relativo_no_facturacion/almacenarRespuesta']	= 'reclamo_no_facturacion/Respuesta_ctrllr/guardar';

		#4.0 Registrar reclamos
		$route['registrar_reclamo/registro'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/registro';
		$route['registrar_reclamo/buscar_dni'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/buscar_dni';
		$route['registrar_reclamo/buscar_reclamo'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/buscar_reclamo';
		$route['registrar_reclamo/buscar_direccion'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/buscar_direccion';
		$route['registrar_reclamo/guardar_reclamante'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/guardar_reclamante';
		$route['registrar_reclamo/buscar_para_edicion'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/buscar_para_edicion';
		$route['registrar_reclamo/fecha_actual'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/fecha_actual';
		$route['registrar_reclamo/intevalo_reclamos'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/intevalo_reclamos';
		$route['registrar_reclamo/guardar_derivados'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/guardar_derivados';
		$route['registrar_reclamo/obtener_derivados'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/obtener_derivados';
		$route['registrar_reclamo/solicitud_seleccionada'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/solicitud_seleccionada';
		$route['registrar_reclamo/guardar_reclamo_nuevo'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/guardar_reclamo_nuevo';
		$route['registrar_reclamo/imprimir_reclamo/nuevo'] = 'reclamo_no_facturacion/Registro_reclamo_ctrllr/imprimir_reclamo';
		#5.0 conciliar reclamo
		$route['reclamo/AtenderReclamo'] = 'reclamo_no_facturacion/Atender_reclamo_ctrllr/inicio';
		$route['reclamo/buscar_reclamo_concilia'] = 'reclamo_no_facturacion/Atender_reclamo_ctrllr/buscar_reclamo';
		$route['reclamo/reclamo_conciliar'] = 'reclamo_no_facturacion/Atender_reclamo_ctrllr/reclamo_conciliar';
		$route['reclamo/guardar_registro_concilia'] = 'reclamo_no_facturacion/Atender_reclamo_ctrllr/guardar_registro_concilia';
		$route['reclamo/imprimir_conciliacion/nuevo'] = 'reclamo_no_facturacion/Atender_reclamo_ctrllr/imprimir_conciliacion';


		#6.0  Generar solicitud de requerimiento

		$route['Solicitud_requerimiento/Generar'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_ctrllr/inicio';
		$route['Solicitud_requerimiento/fecha_actual'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_ctrllr/fecha_actual';
		$route['Solicitud_requerimiento/intevalo_reclamos'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_ctrllr/intevalo_reclamos';
		$route['Solicitud_requerimiento/Reportes/imprimir_pdf'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_ctrllr/imprimir_pdf';
		$route['Solicitud_requerimiento/Reportes/imprimir_pdf_general'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_ctrllr/imprimir_pdf_general';
		$route['Solicitud_requerimiento/Generar_solicitud/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_ctrllr/Genera_Solicitud/$1/$2/$3/$4/$5/$6/$7/$8';
		$route['Solicitud_requerimiento/crear_orden_reque'] = 'reclamo_no_facturacion/Genera_solicitud_requerimiento_ctrllr/Crear_orden_req';
		






		$route['cuenta_corriente/administracion'] = 'cuenta_corriente/Administracion_ctrllr/administrar_carteras';





//$route['cuenta_corriente/detalle_recibo/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/detalle/$1/$2/$3';
$route['cuenta_corriente/obtener_detalle_recibo'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/detalle_recibo';
$route['cuenta_corriente/duplicado/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/duplicado/$1/$2/$3';
$route['cuenta_corriente/verificar_convenios'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/verificar_convendios';
$route['cuenta_corriente/consultar_convenio/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/consultar_convenio/$1';
$route['cuenta_corriente/detalle_convenio'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/detalle_convenio';
$route['cuenta_corriente/detalle_credito/(:num)/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/detalle_contrado/$1/$2/$3/$4'; // borrar ruta
$route['cuenta_corriente/imprimir_credito/(:num)/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_convenio/$1/$2/$3/$4';
$route['cuenta_corriente/ver_pagos/(:any)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/ver_pagos/$1';
$route['cuenta_corriente/obtener_rangos'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/obtener_rangos';
$route['cuenta_corriente/imprimir_rangos/(:any)/(:any)/(:any)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_rangos/$1/$2/$3';
$route['cuenta_corriente/buscar_pagos'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/verificar_pagos';
$route['cuenta_corriente/imprimir_pagos/(:any)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_pagos/$1';
$route['cuenta_corriente/notaCredito/(:any)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_notaC/$1/$2/$3';
$route['cuenta_corriente/imprimir_cuenta_corriente/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_cuenta/$1';
$route['cuenta_corriente/obtener_localidades'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/obtener_localidades';
$route['cuenta_corriente/duplicado2/(:any)/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/duplicado_recibo_antiguo/$1/$2/$3/$4'; 

$route['cuenta_corriente/buscar_autorizaciones'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/buscar_autorizaciones';
$route['cuenta_corriente/get_autorizacion'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/get_autorizacion';
$route['cuenta_corriente/eliminar_nc'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/anular_nota';
$route['cuenta_corriente/get_anulaciones'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/notas_anuladas';
$route['cuenta_corriente/get_unidades'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/get_unidades';
$route['cuenta_corriente/view_ampliaciones'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/visualizar_ampliaciones';

$route['cuenta_corriente/obtener_recibos_serie_90_91'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/obtener_90_91';
$route['cuenta_corriente/recibos_anulados'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/recibos_anulados_totalmente';

## Para accciones Concitivas
$route['cuenta_corriente/cambios_catastrales'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/cambios_catastrales';
$route['cuenta_corriente/estados_catastrales'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/estados_catastrales';
$route['cuenta_corriente/acciones_ejecutadas'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/acciones_ejecutadas';
$route['cuenta_corriente/listar_acciones_ejecutudas/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/listar_acciones_ejecutudas/$1';
$route['cuenta_corriente/ver_deuda_corte'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/ver_deuda_corte';
$route['cuenta_corriente/acciones/impimir_acciones/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_acciones/$1';
$route['cuenta_corriente/impirmir_lista_de_acciones/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_acciones1/$1';
$route['cuenta_corriente/impirmir_lista_de_acciones_detalladas/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_acciones2/$1';
$route['cuenta_corriente/ampliacion_cortes'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/verificar_ampliaciones';
$route['cuenta_corriente/ampliacion_recibo'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/ampliacion_recibo';
$route['cuenta_corriente/ver_otra_deuda_corte'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/otros_cortes';

##### Para notas de crédito
$route['cuenta_corriente/ver_detalle_nota'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/detalle_nota_credito';
$route['cuenta_corriente/generar_nota_credito/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/generar_nota_credito/$1/$2/$3';
$route['cuenta_corriente/save_nota_credito'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/save_nota_credito';
$route['cuenta_corriente/obtener_tarifas'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/obtener_tarifas';

$route['cuenta_corriente/facturacion/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/get_facturacion/$1/$2/$3';
$route['cuenta_corriente/imrpimir_facturacion/(:num)/(:num)/(:num)'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/imprimir_facturacion/$1/$2/$3';
$route['cuenta_corriente/anular_nota_credito'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/anular_recibo';


$route['cuenta_corriente/consumos'] = 'cuenta_corriente/Cuentas_Corrientes_ctrllr/getConsumos';
/**
	PROFORMA
*/
	$route['documentos/proformas'] = 'boleta_factura/Proforma_ctrllr/mostrar_proformas';
	$route['documentos/proformas/guardar_edicion']='boleta_factura/Proforma_ctrllr/guardar_edicion';
	$route['documentos/proformas/proforma-boleta/nuevo'] = 'boleta_factura/Proforma_ctrllr/mostrar_registro_proforma_boleta';
	$route['documentos/proformas/proforma-factura/nuevo'] = 'boleta_factura/Proforma_ctrllr/mostrar_registro_proforma_factura';
	$route['documentos/proformas/proforma-orden-pago/nuevo'] = 'boleta_factura/Proforma_ctrllr/mostrar_registro_proforma_orden_pago';
	$route['documentos/proformas/editar/(:num)/(:num)/(:num)'] = 'boleta_factura/Proforma_ctrllr/editar_proforma/$1/$2/$3';
	//$route['documentos/proformas/nuevo'] = 'boleta_factura/Proforma_ctrllr/mostrar_registro_proforma';
	//$route['documentos/proformas/registrar_profoma'] = 'boleta_factura/Proforma_ctrllr/registrar_proforma';
	$route['documentos/proformas/registrar_profoma/boleta'] = 'boleta_factura/Proforma_ctrllr/registrar_proforma_boleta';
	$route['documentos/proformas/registrar_profoma/factura'] = 'boleta_factura/Proforma_ctrllr/registrar_proforma_factura';
	//$route['documentos/proformas/registrar_profoma/orden-pago'] = 'boleta_factura/Proforma_ctrllr/registrar_proforma_orden_pago';

	$route['documentos/proforma/imprimir/(:num)/(:num)/(:num)'] = 'boleta_factura/Proforma_ctrllr/imprimir_documento/$1/$2/$3';

	$route['buscar/buscar_oordpag'] = 'boleta_factura/Proforma_ctrllr/buscar_oordpag';

/* 
COPIA RECIBO
*/
$route['Copia_Recibo/Genera'] = 'boleta_factura/Reporte_ctrllr/masivos_inicial';
$route['recibo/masivo/mando_masivo'] = 'boleta_factura/Reporte_ctrllr/masivos_rango';
$route['recibo/masivo/recibos_rango/(:num)/(:num)/(:any)/(:num)'] = 'boleta_factura/Reporte_ctrllr/obtengo_recibos_rango/$1/$2/$3/$4';
$route['recibo/masivo/genero_imagenes'] = 'boleta_factura/Reporte_ctrllr/imagenes_rango_masivo';
$route['recibo/rango/mando_suministro'] = 'boleta_factura/Reporte_ctrllr/suministro_rango_recibo';
$route['recibo/suministro/rango_recibo'] = 'boleta_factura/Reporte_ctrllr/generando_suministro_rango_recibo';
$route['recibo/rango/suministro_individual'] = 'boleta_factura/Reporte_ctrllr/generando_recibo_individual';
$route['recibo/suministro/imprimir/recibo/individual'] = 'boleta_factura/Reporte_ctrllr/imprimir_recibo_individual';
/**
	FACTURAS Y BOLETAS
*/
/* crear nuevo concepto */
$route['CREA_CONCEPTO/INICIO'] = 'boleta_factura/Concepto_ctrllr/inicio';
$route['CREA_CONCEPTO/FILTRAR'] = 'boleta_factura/Concepto_ctrllr/filtrar';
$route['GUARDA_CONCEPTO/GUARDAR'] = 'boleta_factura/Concepto_ctrllr/guardar';
$route['CREA_CONCEPTO/EDITAR'] = 'boleta_factura/Concepto_ctrllr/editar';
$route['CREA_CONCEPTO/GUARDA_EDITAR'] = 'boleta_factura/Concepto_ctrllr/guarda_edicion';
// *************
$route['documentos/boletas_facturas'] = 'boleta_factura/Boleta_Factura_ctrllr/mostrar_boletasfacturas';
$route['documentos/boletas_facturas/mostrar_pago/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/mostrar_pago/$1/$2/$3';
$route['documentos/boletas_factura/pagar_proforma'] = 'boleta_factura/Boleta_Factura_ctrllr/pagar_proforma';
$route['documentos/boletas_factura/pagar_proforma_ose'] = 'boleta_factura/Boleta_Factura_ctrllr/pagar_proforma_ose';
$route['documentos/boletas_factura/continuar_Proceso'] ='boleta_factura/Boleta_Factura_ctrllr/continuar_Proceso';
$route['documentos/boletas_factura/continuar_Proceso_ose'] ='boleta_factura/Boleta_Factura_ctrllr/continuar_Proceso_ose';
$route['documentos/boletas_factura/mostrar/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/mostrar_boleta_factura/$1/$2/$3';
$route['documentos/boletas_facturas/mostrar_pdf/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/mostrar_pdf/$1/$2/$3';
$route['documentos/boletas_facturas/mostrar_ticket/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/imprimir_ticket/$1/$2/$3';
$route['documentos/boletas_facturas/mostrar_copia_ticket/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/imprimir_copia_ticket/$1/$2/$3';
	/*

	$route['documentos/boletas_facturas/imprimir/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/imprimir_documento/$1/$2/$3';
	$route['documentos/boletas_facturas/detallar/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/detallar_documento/$1/$2/$3';

	$route['documentos/boletas_facturas/registrar'] = 'boleta_factura/Boleta_Factura_ctrllr/ver_registro';
	$route['documentos/boletas_facturas/accion_registrar'] = 'boleta_factura/Boleta_Factura_ctrllr/registrar';

	$route['documentos/boleta_factura/pagar/(:num)/(:num)/(:num)'] = 'boleta_factura/Boleta_Factura_ctrllr/ver_pago/$1/$2/$3';
	$route['documentos/boletas_facturas/accion_pagar'] = 'boleta_factura/Boleta_Factura_ctrllr/pagar';
	*/
/**

*/
$route['documentos/boletas_facturas/estados'] = 'boleta_factura/Estados_ctrllr/mostrar_estados';
$route['documentos/boletas_facturas/reporte'] = 'boleta_factura/Reporte_ctrllr/mostrar_reporte';
$route['documentos/boletas_facturas/reporte_diario'] = 'boleta_factura/Reporte_ctrllr/mostrar_reporte_diario';
$route['documentos/reporte/reporte2'] = 'boleta_factura/Reporte_ctrllr/imprimir_reporteDiario';
$route['documentos/reporte/reporte1'] = 'boleta_factura/Reporte_ctrllr/imprimir_reporte1';
$route['documentos/reporte/reporte_sunat'] = 'boleta_factura/Reporte_ctrllr/imprimir_reporte2';
$route['documentos/reporte/reporte_formato_2'] = 'boleta_factura/Reporte_ctrllr/reporte_formato_2';
$route['buscar/buscar_comprobante_intervalo'] = 'boleta_factura/Reporte_ctrllr/mostrar_reporte_intervalo';
$route['buscar/buscar_comprobante_intervalo_diario'] = 'boleta_factura/Reporte_ctrllr/mostrar_reporte_intervalo_diario';
$route['buscar/buscar_comprobante_estados'] = 'boleta_factura/Estados_ctrllr/mostrar_reporte_estado';

$route['documentos/nota_credito'] = 'boleta_factura/Nota_Credito_ctrllr/listar_notas';
$route['documentos/nota_credito/buscar_nota'] = 'boleta_factura/Nota_Credito_ctrllr/bsucar_nota';
$route['documentos/nota_credito/pagar/(:any)/(:num)'] = 'boleta_factura/Nota_Credito_ctrllr/pagar_nota/$1/$2';
$route['documentos/nota_credito/buscar_nota_pagada'] = 'boleta_factura/Nota_Credito_ctrllr/buscar_nota_pagada';
$route['documentos/nota_credito/imprimir_ticket_nc/(:any)/(:num)/(:num)'] = 'boleta_factura/Nota_Credito_ctrllr/imprimir_ticket1/$1/$2/$3';
$route['documentos/nota_credito/imprimir_ticket_nc_duplicado/(:any)/(:num)/(:num)'] = 'boleta_factura/Nota_Credito_ctrllr/imprimir_ticket2/$1/$2/$3';
/**
	GENERAL
*/
	$route['consulta/codigo-suministro'] = 'general/Propie_ctrllr/obtener_propie';
	$route['consulta/buscar-dni'] = 'general/Propie_ctrllr/buscar_dni';
	$route['consulta/buscar-ruc'] = 'general/Propie_ctrllr/buscar_ruc';
	$route['registrar/persona'] = 'general/Propie_ctrllr/registrar_persona';
	$route['actualizar/persona'] = 'general/Propie_ctrllr/actualizar_persona';
	$route['registrar/empresa'] = 'general/Propie_ctrllr/registrar_empresa';
	$route['actualizar/empresa'] = 'general/Propie_ctrllr/actualizar_empresa';
/**

*/

//$route['documentos/boletas_facturas/registrar'] = 'boleta_factura/Boleta_Factura_ctrllr/ver_registro';
//$route['documentos/boletas_facturas/accion_registrar'] = 'boleta_factura/Boleta_Factura_ctrllr/registrar';


/***
ADMINISTRADOR SIC
***/
$route['manger_sic/denuncias'] = 'manager_sic/Denuncias_ctrllr/administrador_denuncias';
$route['denuncias/get_denuncia'] = 'manager_sic/Denuncias_ctrllr/get_one_denuncia';

$route['manager_sic/sugerencias'] = 'manager_sic/Sugerencias_ctrllr/administrador_sugerencias';
$route['sugerencias/responder/(:num)'] = 'manager_sic/Sugerencias_ctrllr/responder/$1';


/**************************************************************************************************************************************************************************************************************************
*																			NOTAS (CREDITO Y DEBITO)																													  *
***************************************************************************************************************************************************************************************************************************/
		# REPORTE DE NOTAS DE CRÉDITO DE RECIBOS
			$route['notas/reportes']					= 'notas/Reporte_Notas_ctrllr/listar';
			$route['notas/reportes/agencias']			= 'notas/Reporte_Notas_ctrllr/getAgencias';
			$route['notas/reportes/obtener']			= 'notas/Reporte_Notas_ctrllr/putNotas';
			$route['notas/reportes/excel']				= 'notas/Reporte_Notas_ctrllr/exportExcel';
			$route['notas/reportes/pdf']				= 'notas/Reporte_Notas_ctrllr/exportarPDF';

		#NOTAS DE CRÉDITO PARA BOLETAS Y FACTURAS
			$route['notas/nota_credito'] 					= 'notas/Nota_Credito_ctrllr/administrar_notasCedito';
			$route['nota_credito/get_autorizaciones'] 		= 'notas/Nota_Credito_ctrllr/get_autorizaciones';
			$route['nota_credito/detalle_nota_credito']		= 'notas/Nota_Credito_ctrllr/get_detalle_notas';
			$route['nota_credito/busqueda_nota_credito'] 	= 'notas/Nota_Credito_ctrllr/buscar_notas';


//$route['notas/ver_recibos'] = 'notas/Nota_Credito_ctrllr/ver_recibos';
$route['notas/ver_recibo/(:num)/(:num)/(:num)'] = 'notas/Nota_Credito_ctrllr/ver_recibo/$1/$2/$3';
#BOLETAS Y FACTURAS

$route['notas/ver_facturas'] = 'notas/Nota_Credito_ctrllr/ver_facturas';
$route['notas/ver_boleta_factura/(:num)/(:num)/(:num)'] = 'notas/Nota_Credito_ctrllr/ver_boleta_factura/$1/$2/$3';
$route['notas/generar_nota_fb'] = 'notas/Nota_Credito_ctrllr/generar_ncbf';
$route['notas/enviar_sunat'] = 'notas/Nota_Credito_ctrllr/enviar_sunat';
$route['nota_credito/reenviar_sunat'] = 'notas/Nota_Credito_ctrllr/reenviar_sunat';
$route['notas/actulizar_nota_credito'] = 'notas/Nota_Credito_ctrllr/actualizar_nc';


$route['nota_credito/buscar_notas'] = 'notas/Estados_Nota_Credito_ctrllr/buscar_notas_bf';
$route['nota_credito/envio_masivo'] = 'notas/Nota_Credito_ctrllr/envio_masivo_nc';
$route['notas/estados'] = 'notas/Estados_Nota_Credito_ctrllr/lista_estados';
#NOTA DEBITO
$route['notas/notas_debito'] = 'notas/Nota_Debito_ctrllr/administrar_notasDebito';
$route['notasD/ver_recibos'] = 'notas/Nota_Debito_ctrllr/ver_recibos';
$route['notasD/ver_recibo/(:num)/(:num)/(:num)'] = 'notas/Nota_Debito_ctrllr/ver_recibo/$1/$2/$3';
#BOLETAS Y FACTURAS
$route['notasD/ver_facturas'] = 'notas/Nota_Credito_ctrllr/ver_facturas';
$route['notaD/ver_boleta_factura/(:num)/(:num)/(:num)'] = 'notas/Nota_Debito_ctrllr/ver_boleta_factura/$1/$2/$3';
$route['notas/generar_notaD_fb'] = 'notas/Nota_Debito_ctrllr/generar_ndbf';


/******************************************************************
**
** FACTURACIÓN
**
*******************************************************************/
#Regimen de facturación
$route['facturacion/ver_regimenes'] = 'facturacion/Regimen_Facturacion_ctrllr/ver_regimenes';
$route['regimenes/busqueda_regimenes'] = 'facturacion/Regimen_Facturacion_ctrllr/buscar_regimen';
$route['regimen/ver_regimen/([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)'] = 'facturacion/Regimen_Facturacion_ctrllr/generar_regimen/$1-$2-$3-$4-$5-$6-$7-$8';
$route['regimen/generar_pdf/([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)'] = 'facturacion/Regimen_Facturacion_ctrllr/generar_pdf/$1-$2-$3-$4-$5-$6-$7-$8';

$route['facturacion/genera_recibo']='facturacion/Genera_recibo_ctrllr/genera_recibo';
$route['facturacion/creo_recibo/(:num)/(:num)']='facturacion/Genera_recibo_ctrllr/creo_recibo/$1/$2';//con fondo
$route['facturacion/duplico_recibo/(:num)/(:num)']='facturacion/Genera_recibo_ctrllr/duplico_recibo/$1/$2';//con fondo
$route['facturacion/creo_recibo_a4/(:num)/(:num)']='facturacion/Genera_recibo_ctrllr/creo_recibo_a4/$1/$2';//sin fondo
$route['facturacion/grafico_pdf']='facturacion/Genera_recibo_ctrllr/grafico_pdf';

$route['recibo/masivo'] = 'facturacion/masivo_ctrllr/ver_masivo';
$route['recibo/masivo/mando'] = 'facturacion/masivo_ctrllr/generar';
//**************************************************************

#Afilación
//**************************************************************
$route['facturacion/afiliacion']='facturacion/Afiliacion_ctrllr/afilia';
$route['facturacion/afiliacion_pdf']='facturacion/Afiliacion_ctrllr/afilia_pdf';
#Firmas de Régimen de Facturación
$route['facturacion/administrar_firmas'] = 'facturacion/Administrar_Firmas_ctrllr/inicio';

/***************** END FACTURACIÓN ***********/
/* COBRANZA */
$route['cobranza/recibos'] = 'cobranza/Recibos_ctrllr/cobranza_recibos';
$route['cobranza/facturas_boletas'] = 'cobranza/Facturas_Boletas_ctrllr/cobranza_facturas_boletas';
$route['cobranza/credito_debito'] = 'cobranza/Credito_Debito_ctrllr/cobranza_credito_debito';


//DEFAULT CONTROLLER
$route['default_controller'] = 'Default_ctrllr/inicio';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
/******************************************************************
**
** Atencion al cliente
**
*******************************************************************/
$route['Atencion_al_cliente/busca_sumi'] = 'Atencion_al_cliente/afiliacion_ctrllr/busca_sumi';
$route['Atencion_al_cliente/adjunta_doc/(:num)'] = 'Atencion_al_cliente/afiliacion_ctrllr/adjunta_doc/$1';
$route['Atencion_al_cliente/sub_arch'] = 'Atencion_al_cliente/afiliacion_ctrllr/sub_arch';
$route['Atencion_al_cliente/ver_afiliados'] = 'Atencion_al_cliente/Afiliados_ctrllr/total_afiliado';
/******************************************************************
**
** PERMISOS
**
*******************************************************************/

$route['permisos/usuarios'] = 'permisos/Usuarios_ctrllr/listar_usuarios';
$route['permisos/crear_usuario'] = 'permisos/Crear_usuario_ctrllr/crear_usuario';
$route['permisos/tipo_permiso']='permisos/Crear_usuario_ctrllr/tipo_permiso';

/*******************************
******notificacion atipico******
********************************/
$route['facturacion/not_atipico'] = 'facturacion/Not_atipico_ctrllr/ver';
$route['facturacion/crear_atipico/(:num)/(:any)'] = 'facturacion/Not_atipico_ctrllr/crear/$1/$2';
$route['facturacion/crear_excel/(:num)/(:any)'] = 'facturacion/Not_atipico_ctrllr/crear_excel/$1/$2';

/*******************************************************************
**
** OPERACIONAL
**
********************************************************************/
$route['operacional/boleta_facutra']='Operacional/Ope_boleta_factura_ctrllr/operaciones';
$route['documentos/operaciones/proforma-boleta/nuevo'] = 'Operacional/Ope_boleta_factura_ctrllr/mostrar_registro_proforma_boleta';
$route['documentos/operaciones/proforma-factura/nuevo'] = 'Operacional/Ope_boleta_factura_ctrllr/mostrar_registro_proforma_factura';
$route['operacional/boleta_factura'] = 'Operacional/Ope_boleta_factura_ctrllr/genera_boleta_factura';
$route['documentos/Operacional/mostrar_pago/(:num)/(:num)/(:num)'] =  'Operacional/Ope_boleta_factura_ctrllr/mostrar_pago/$1/$2/$3';
$route['documentos/boletas_factura/pagar_proforma_operacional'] = 'boleta_factura/Boleta_Factura_ctrllr/pagar_proforma_operacional';

$route['operacion/pagar'] = 'Operacional/Ope_boleta_factura_ctrllr/pagar';

$route['Operacional/pagar/boleta_factura/(:num)/(:num)/(:num)'] = 'Operacional/Ope_boleta_factura_ctrllr/paga_boleta_factura/$1/$2/$3';
$route['operacion/pagar/exito/(:num)/(:num)/(:num)'] = 'Operacional/Ope_boleta_factura_ctrllr/operacional_pagar_exito/$1/$2/$3';
$route['operacional/pagando_comprobante'] = 'Operacional/Ope_boleta_factura_ctrllr/pagando_comprobante';


//MAIL RECIBO

$route['RECIBO_MAIL/(:num)/(:any)'] = 'facturacion/recibo_digital_mail_ctrllr/mail_recibo/$1/$2';
/*
***********************************************************************************************************************************
*                                   RUTAS PARA LA ACTIVIDAD DE ADMINISTRACIÓN DE COBRANZAS                                        *
*                                  --------------------------------------------------------                                       *
***********************************************************************************************************************************
*/
$route['cobranza/admin_cajeras'] = 'cobranza/Administracion_Cajeras_ctrllr/inicio';
$route['cobranza/actualizar_cajera'] = 'cobranza/Administracion_Cajeras_ctrllr/update_cajera';

$route['duplicado_recibo/(:any)/(:num)'] = 'external/Administrador_ctrllr/duplicado/$1/$2';

/* *************************************  ATIPICOS ***********************  */

$route['atipico/ver'] = 'facturacion/Atipicos_ctrllr/ver';
$route['atipico/buscar'] = 'facturacion/Atipicos_ctrllr/buscar';
$route['atipico/reporte/imagen'] = 'facturacion/Atipicos_ctrllr/reporte_imagen';
$route['atipico/reporte/lectura'] = 'facturacion/Atipicos_ctrllr/reporte_lectura';
$route['atipico/reporte/re_lectura'] = 'facturacion/Atipicos_ctrllr/reporte_re_lectura';
$route['atipico/verificar_detalle/(:num)/(:num)'] = 'facturacion/Atipicos_ctrllr/ver_detalle/$1/$2';
$route['atipico/verificar_detalle_SIAC/(:num)/(:num)/(:num)'] = 'facturacion/Atipicos_ctrllr/ver_detalle_SIAC/$1/$2/$3';
/*******************************
******notificacion atipico******
********************************/
$route['facturacion/not_atipico'] = 'facturacion/Not_atipico_ctrllr/ver';
$route['facturacion/crear_atipico'] = 'facturacion/Not_atipico_ctrllr/crear';

/**********************************
************  MAIL ****************           
***********************************/
$route['mail/CrearExcel'] = 'mail/Mail_ctrllr/VerMail';
$route['mail/Genera_Excel'] = 'mail/Mail_ctrllr/CrearExcel';

/*************************************
*********** FINANCIAMIENTOS **********
**************************************/

$route['financiamiento/calculo'] = 'financiamiento/Financiamiento_ctrllr/calculo';
$route['financiamiento/buscar_suministro'] = 'financiamiento/Financiamiento_ctrllr/buscar_suministro';
$route['financiamiento/buscar_cuotas'] = 'financiamiento/Financiamiento_ctrllr/buscar_cuotas';
$route['financiamiento/guarda_datos_titular'] = 'financiamiento/Financiamiento_ctrllr/guarda_datos_titular';
$route['financiamiento/guarda_datos_representante'] = 'financiamiento/Financiamiento_ctrllr/guarda_datos_representante';
$route['financiamiento/guarda_datos_texto'] = 'financiamiento/Financiamiento_ctrllr/guarda_datos_texto'; 
$route['financiamiento/reporte/acta'] = 'financiamiento/Financiamiento_ctrllr/reporte_acta'; 
$route['financiamiento/reporte/caja'] = 'financiamiento/Financiamiento_ctrllr/reporte_caja';
$route['financiamiento/reporte/recibo_reporte'] = 'financiamiento/Financiamiento_ctrllr/reporte_recibo';
$route['financiamiento/reporte/cronograma'] = 'financiamiento/Financiamiento_ctrllr/reporte_cronograma';
$route['financiamiento/reporte/proforma'] = 'financiamiento/Financiamiento_ctrllr/proforma_cronograma';
$route['financiamiento/editar/titular'] = 'financiamiento/Financiamiento_ctrllr/editar_titular';

// PARA EL REPORTE DE LOS FINANCIAMIENTOS
$route['financiamiento/reporte_financiamiento'] = 'financiamiento/Financiamiento_ctrllr/vista';
$route['financiamiento/buscar/suministro_reporte'] = 'financiamiento/Financiamiento_ctrllr/suministro_reporte';
$route['financiamiento/reporteador/recono_deuda'] =  'financiamiento/Financiamiento_ctrllr/Repor_Recono_deuda';
$route['financiamiento/reporteador/crono_pagos'] =  'financiamiento/Financiamiento_ctrllr/Repor_crono_pagos';
$route['financiamiento/reporteador/Reci_caja'] =  'financiamiento/Financiamiento_ctrllr/Repor_reci_caja';
$route['financiamiento/reporteador/Cta_Corri_convenio'] =  'financiamiento/Financiamiento_ctrllr/Repor_Corri_convenio';
$route['financiamiento/buscar/suministro_archivos'] =  'financiamiento/Financiamiento_ctrllr/Repor_dire_archivos';
// ANULACION DE CREDITO FINANCIAMIENTOS

$route['financiamiento/anu_colaterales'] =  'financiamiento/Anula_Convenio_ctrllr/calculo';
$route['financiamiento/anula_fina/suministro'] =  'financiamiento/Anula_Convenio_ctrllr/busca_suministro';
$route['financiamiento/anula_fina/busca_letras'] =  'financiamiento/Anula_Convenio_ctrllr/busca_letras';
$route['financiamiento/anula_fina/ejecuta_proceso'] = 'financiamiento/Anula_Convenio_ctrllr/ejecuta_proceso';

//   FINANCIAMIENTO DE COLATERALES

$route['financiamiento/colateral'] =  'financiamiento/Fina_colateral_ctrllr/Fina_colateral';
$route['financiamiento/colateral/busca_suministro'] =  'financiamiento/Fina_colateral_ctrllr/busca_suministro';
$route['financiamiento/judicial/busca_suministro'] =  'financiamiento/Fina_colateral_ctrllr/busca_suministro_judicial';
$route['financiamiento/colateral/reporte_cronograma'] =  'financiamiento/Fina_colateral_ctrllr/reporte_cronograma';
$route['financiamiento/colateral/grabar_dato'] =  'financiamiento/Fina_colateral_ctrllr/grabo_datos';
$route['financiamiento/colateral/guardo_archivo'] =  'financiamiento/Fina_colateral_ctrllr/grabo_archivos';

// TRAMITE JUDICIAL 
$route['financiamiento/tramite_judicial'] = 'financiamiento/Tramite_judicial_ctrllr/inicio';
$route['financiamiento/tramite_judicial/nuevo'] = 'financiamiento/Tramite_judicial_ctrllr/nuevo';
$route['financiamiento/tramite_judicial/suministros'] = 'financiamiento/Tramite_judicial_ctrllr/suministros' ; 
$route['financiamiento/tramite_judicial/suministro_editar'] = 'financiamiento/Tramite_judicial_ctrllr/suministro_editar' ; 
$route['financiamiento/tramite_judicial/suministro_guardar'] = 'financiamiento/Tramite_judicial_ctrllr/suministro_guardar' ; 
$route['financiamiento/tramite_judicial/suministro_guardo_edicion'] = 'financiamiento/Tramite_judicial_ctrllr/suministro_guarda_edicion' ; 

// Excel financiamiento 
$route['financiamiento/excel'] = 'financiamiento/Excel_financiamiento_ctrllr/Excel_financiamiento';
$route['financiamiento/excel/reporte'] = 'financiamiento/Excel_financiamiento_ctrllr/busco_financiamiento';
$route['financiamiento/excel/reporte/pdf'] = 'financiamiento/Excel_financiamiento_ctrllr/reporte_financiamiento'; 

// Para los recibos financiados 
$route['financiamiento/Rep_recibo_financiado'] = 'financiamiento/Recibos_financiamiento_ctrllr/recibos_financiados';
$route['financiamiento/recibos_financiados/reporte'] = 'financiamiento/Recibos_financiamiento_ctrllr/creditos_realizados';
$route['financiamiento/mostrar_pdf/recibos_reporte/(:num)/(:num)/(:num)'] = 'financiamiento/Recibos_financiamiento_ctrllr/crear_reporte_recibo_ind/$1/$2/$3';

// Para pagar la inicial de convenio 
$route['financiamiento/pagar/ini_conv'] = 'financiamiento/Pag_ini_conv_ctrllr/lista';
$route['financiamiento/mostrar_inicial/(:num)/(:num)/(:num)/(:num)'] = 'financiamiento/Pag_ini_conv_ctrllr/mostrar_pago/$1/$2/$3/$4';
$route['financiamiento/extorna/inicial/(:num)/(:num)/(:num)/(:num)'] = 'financiamiento/Ver_actualizacion_ctrllr/mostrar_pago/$1/$2/$3/$4';
$route['financiamiento/ver_pago/(:num)/(:num)/(:num)'] = 'financiamiento/Pag_ini_conv_ctrllr/ver_pago/$1/$2/$3';
$route['financiamiento/mostrar_ticket/(:num)/(:num)/(:num)'] = 'financiamiento/Pag_ini_conv_ctrllr/impr_ticket/$1/$2/$3';
$route['financiamiento/pagar_inicial'] = 'financiamiento/Pag_ini_conv_ctrllr/relizo_pago';
$route['financiamiento/extornar_inicial'] = 'financiamiento/Ver_actualizacion_ctrllr/extorno_pago';
// caso ticket
$route['financiamiento/caso/ticket'] = 'financiamiento/Pag_ini_conv_ctrllr/caso';
// Autorizacion extorno recibo 
$route['autoriza/extorno/recibo'] = 'financiamiento/Anula_Convenio_ctrllr/autorizo_extorno';
$route['financiamiento/detalle_extorno/(:num)/(:num)/(:num)'] = 'financiamiento/Anula_Convenio_ctrllr/genero_extorno/$1/$2/$3';
$route['fina/extorno/autorizacion_registro'] = 'financiamiento/Anula_Convenio_ctrllr/gravo_autorizacion';
$route['financiamiento/autorizacion/ver_autoriza'] = 'financiamiento/Ver_actualizacion_ctrllr/ver_autorizacion';

// caso ticket

/**
	ORDENES DE TRABAJO PARA NOTIFICACIONES E INSPECCIONES INTERNAS Y EXTERNAS
**/
$route['facturacion/ordenes_trabajo'] = 'facturacion/Ordenes_Trabajo_ctrllr/ver';
$route['facturacion/generar_orden'] = 'facturacion/Ordenes_Trabajo_ctrllr/generar';


$route['colas/reporte'] = 'colas/Colas_ctrllr/inicio';



/* TRAMITE DOCUMENTARIO */

/* CREAR DOCUMENTO */
$route['TRAMITE/Crea_documento'] = 'tramite_documentario/crea_Documento_ctrllr/inicio';
$route['TRAMITE/CrearInterno/getDocsCreadosUsuario'] = 'tramite_documentario/crea_Documento_ctrllr/getDocsCreadosUsuario';
$route['TRAMITE/CrearInterno/getTipoxTipoDoc'] = 'tramite_documentario/crea_Documento_ctrllr/getTipoxTipoDoc';
$route['TRAMITE/CrearInterno/crearDocInterno'] = 'tramite_documentario/crea_Documento_ctrllr/crearDocInterno';
$route['TRAMITE/CrearInterno/Listar_personal_x_dependencia'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_personal_x_dependencia'; 
$route['TRAMITE/CrearInterno/Listar_gerentes_y_subgerentes'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_gerentes_y_subgerentes';
$route['TRAMITE/CrearInterno/Listar_personal_dependencia_actual'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_personal_dependencia_actual';
$route['TRAMITE/CrearInterno/getDocumentosRefs'] = 'tramite_documentario/crea_Documento_ctrllr/getDocumentosRefs';
$route['TRAMITE/CrearInterno/getAdjuntos'] = 'tramite_documentario/crea_Documento_ctrllr/getAdjuntos';
$route['TRAMITE/CrearInterno/getAreasRecepcionaron'] = 'tramite_documentario/crea_Documento_ctrllr/getAreasRecepcionaron';
$route['TRAMITE/CrearInterno/Listar_dependencias_internos'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_dependencias_internos';
$route['TRAMITE/CrearInterno/Listar_dependencias_internos_total'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_dependencias_internos_total';
$route['TRAMITE/CrearInterno/getDependenciaJeraquia'] = 'tramite_documentario/crea_Documento_ctrllr/getDependenciaJeraquia';
$route['TRAMITE/CrearInterno/getFuncionario'] = 'tramite_documentario/crea_Documento_ctrllr/getFuncionario';
$route['TRAMITE/SubirArchivos/SubidaSingular'] = 'tramite_documentario/crea_Documento_ctrllr/SubidaSingular';
$route['TRAMITE/CrearInterno/verificar_cargo'] = 'tramite_documentario/crea_Documento_ctrllr/verificar_cargo';
$route['TRAMITE/CrearInterno/verifico_Subida_archivo'] = 'tramite_documentario/crea_Documento_ctrllr/verifico_Subida_archivo';
$route['TRAMITE/CrearDocumento/Listar_personal_x_dependencia'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_personal_x_gerencia';
$route['TRAMITE/imprimir_cargo/nuevo'] = 'tramite_documentario/crea_Documento_ctrllr/imprimir_cargo';
$route['TRAMITE/Recibir/getReferenciasDocRecibir'] = 'tramite_documentario/recibir_Documento_ctrllr/getReferenciasDocRecibir';
$route['TRAMITE/fecha_actual'] = 'tramite_documentario/crea_Documento_ctrllr/fecha_actual';


/* PARA RECIBIR DOCUMENTO */
$route['tramite_documento/recibir_documentos'] = 'tramite_documentario/recibir_Documento_ctrllr/inicio';
$route['tramite_documento/Recibir/getDocsRecibirUsuario'] = 'tramite_documentario/recibir_Documento_ctrllr/getDocsRecibirUsuario';
$route['tramite_documento/Recibir/getDocsRecepcionados'] = 'tramite_documentario/recibir_Documento_ctrllr/getDocsRecepcionados';
$route['tramite_documento/Recibir/recibirDocumento'] = 'tramite_documentario/recibir_Documento_ctrllr/recibirDocumento';
$route['tramite_documento/Recibir/devolverDocumento'] = 'tramite_documentario/recibir_Documento_ctrllr/devolverDocumento';
$route['tramite_documento/Recibir/Listar_personal_x_dependencia'] = 'tramite_documentario/recibir_Documento_ctrllr/Listar_personal_x_dependencia';
$route['tramite_documento/Recibir/getReferenciasDocRecibir'] = 'tramite_documentario/recibir_Documento_ctrllr/getReferenciasDocRecibir';
$route['tramite_documento/Recibir/derivarDocumento'] = 'tramite_documentario/recibir_Documento_ctrllr/derivarDocumento';
$route['tramite_documento/Recibir/getDocsRecibirUsuarioFiltro'] = 'tramite_documentario/recibir_Documento_ctrllr/getDocsRecibirUsuarioFiltro';
$route['tramite_documento/Recibir/getAdjuntos'] = 'tramite_documentario/crea_Documento_ctrllr/getAdjuntos';
$route['tramite_documento/fecha_actual'] = 'tramite_documentario/recibir_Documento_ctrllr/fecha_actual';
$route['tramite_documento/CrearInterno/Listar_dependencias_internos'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_dependencias_internos';
$route['tramite_documento/CrearInterno/verificar_cargo'] = 'tramite_documentario/crea_Documento_ctrllr/verificar_cargo';
$route['tramite_documento/Recibir/archivarDocumento'] = 'tramite_documentario/recibir_Documento_ctrllr/archivarDocumento';
$route['tramite_documento/Recibir/getDocsArchivados'] = 'tramite_documentario/recibir_Documento_ctrllr/getDocsArchivados';
$route['tramite_documento/Recibir/desArchivarDocumento'] = 'tramite_documentario/recibir_Documento_ctrllr/desArchivarDocumento';




/* PARA CORREGIR DOCUMENTO */
$route['tramite_documentario/Corregir_documento'] = 'tramite_documentario/corregir_Documento_ctrllr/inicio';
$route['tramite_documentario/CorreccionDoc/getDocsCreadosxUsu'] = 'tramite_documentario/corregir_Documento_ctrllr/getDocsCreadosxUsu';
$route['tramite_documentario/CrearInterno/getTipoxTipoDoc'] = 'tramite_documentario/corregir_Documento_ctrllr/getTipoxTipoDoc';
$route['tramite_documentario/CrearDocumento/Listar_dependencias'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_dependencias_internos';
$route['tramite_documentario/CorreccionDoc/getMovsCorreccion'] = 'tramite_documentario/corregir_Documento_ctrllr/getMovsCorreccion';
$route['tramite_documentario/CrearDocumento/Listar_personal_x_dependencia'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_personal_x_gerencia'; 
$route['tramite_documentario/CorreccionDoc/actualizarFoliosCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/actualizarFoliosCorrecion';
$route['tramite_documentario/CorreccionDoc/actualizaMovDestino'] = 'tramite_documentario/corregir_Documento_ctrllr/actualizaMovDestino';
$route['tramite_documentario/CorreccionDoc/getMovFoliosCorreccion'] = 'tramite_documentario/corregir_Documento_ctrllr/getMovFoliosCorreccion';
$route['tramite_documentario/CorreccionDoc/actualizarFoliosTotalMovCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/actualizarFoliosTotalMovCorrecion';
$route['tramite_documentario/CorreccionDoc/actualizarFoliosTotalCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/actualizarFoliosTotalCorrecion';
$route['tramite_documentario/CorreccionDoc/eliminarMovCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/eliminarMovCorrecion';
$route['tramite_documentario/CorreccionDoc/agregarDestinoCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/agregarDestinoCorrecion';
$route['tramite_documentario/CorreccionDoc/agregarDestinoCopiaCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/agregarDestinoCopiaCorrecion';
$route['tramite_documentario/CorreccionDoc/getReferenciasDocCorreccion'] = 'tramite_documentario/corregir_Documento_ctrllr/getReferenciasDocCorreccion';
$route['tramite_documentario/CorreccionDoc/eliminaRefCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/eliminaRefCorrecion';
$route['tramite_documentario/CrearInterno/getDocumentosRefs'] = 'tramite_documentario/crea_Documento_ctrllr/getDocumentosRefs';
$route['tramite_documentario/CorreccionDoc/agregaRefCorrecion'] = 'tramite_documentario/corregir_Documento_ctrllr/agregaRefCorrecion';
$route['tramite_documentario/CrearInterno/verificar_cargo'] = 'tramite_documentario/crea_Documento_ctrllr/verificar_cargo';
$route['tramite_documentario/SubirArchivos/SubidaSingular'] = 'tramite_documentario/corregir_Documento_ctrllr/SubidaSingular';
$route['tramite_documentario/CorreccionDoc/getDocsAnexados'] = 'tramite_documentario/corregir_Documento_ctrllr/getDocsAnexados';
$route['tramite_documentario/CorreccionDoc/setDeleteFile'] = 'tramite_documentario/corregir_Documento_ctrllr/setDeleteFile';
$route['tramite_documentario/CorreccionDoc/guardoEstRef'] = 'tramite_documentario/corregir_Documento_ctrllr/guardoEstRef';




/* PARA GENERAR UN REPORTE  */
$route['Tramite_documentario/genera_reporte'] = 'tramite_documentario/reporte_Documento_ctrllr/inicio';
$route['Tramite_documentario/CrearDocumento/Listar_tipos_documento'] = 'tramite_documentario/reporte_Documento_ctrllr/Listar_tipos_documento';
$route['Tramite_documentario/ConsultarDocumento/Listar_anios_documento'] = 'tramite_documentario/reporte_Documento_ctrllr/Listar_anios_documento';
$route['Tramite_documentario/Reportes/Obtener_documentos_creados'] = 'tramite_documentario/reporte_Documento_ctrllr/Obtener_documentos_creados';
$route['Tramite_documentario/Reportes/Obtener_documentos_recibidos'] = 'tramite_documentario/reporte_Documento_ctrllr/Obtener_documentos_recibidos';
$route['Tramite_documentario/Reportes/Obtener_documentos_por_recibir'] = 'tramite_documentario/reporte_Documento_ctrllr/Obtener_documentos_por_recibir';
$route['Tramite_documentario/CrearDocumento/Listar_dependencias'] = 'tramite_documentario/reporte_Documento_ctrllr/Listar_dependencias';
$route['Tramite_documentario/Reportes/imprimir_pdf'] = 'tramite_documentario/reporte_Documento_ctrllr/imprimir_pdf';
$route['Tramite_documentario/Recibir/getAdjuntos'] = 'tramite_documentario/crea_Documento_ctrllr/getAdjuntos';
$route['Tramite_documentario/Recibir/getReferenciasDocRecibir'] = 'tramite_documentario/recibir_Documento_ctrllr/getReferenciasDocRecibir';



/* PARA CONSULTAR UN DOCUMENTO */
$route['tramite_documentario/Consultar_documento'] = 'tramite_documentario/consultar_Documento_ctrllr/inicio';
$route['tramite_documentario/ConsultarDocumentoMovimientos/Listar_tipos_documentos'] = 'tramite_documentario/consultar_Documento_ctrllr/Listar_tipos_documentos';
$route['tramite_documentario/ConsultarDocumentoMovimientos/Obtener_documentos'] = 'tramite_documentario/consultar_Documento_ctrllr/Obtener_documentos';
$route['tramite_documentario/ConsultarDocumentoMovimientos/Ver_movimientos_por_documento'] = 'tramite_documentario/consultar_Documento_ctrllr/Ver_movimientos_por_documento';
$route['tramite_documentario/CrearDocumento/Listar_dependencias'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_dependencias_internos_general';
$route['tramite_documentario/ConsultarDocumentoMovimientos/Consultar_Persona'] = 'tramite_documentario/consultar_Documento_ctrllr/Consultar_Persona';
$route['tramite_documentario/Recibir/getReferenciasDocRecibir'] = 'tramite_documentario/recibir_Documento_ctrllr/getReferenciasDocRecibir';
$route['tramite_documentario/Consulta/imprimir_persona_pdf'] = 'tramite_documentario/consultar_Documento_ctrllr/generar_reporte_persona';
$route['tramite_documentario/CrearDocumento/Listar_personal_x_dependencia_general'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_personal_x_gerencia_general';
$route['tramite_documentario/Recibir/getAdjuntos'] = 'tramite_documentario/crea_Documento_ctrllr/getAdjuntos'; 

/* PARA INGRESAR UN DOCUMENTO EXTERNO */
$route['Tramite_Documentario/Externo'] = 'tramite_documentario/Documento_externo_ctrllr/inicio';
$route['Tramite_Documentario/CrearExterno/IngresarExterno'] = 'tramite_documentario/Documento_externo_ctrllr/IngresarExterno';
$route['Tramite_Documentario/Listar_externo/Documentos'] = 'tramite_documentario/Documento_externo_ctrllr/ListarDocExterno';
$route['Tramite_Documentario/imprimir_ticket/nuevo'] = 'tramite_documentario/Documento_externo_ctrllr/crear_ticket';
$route['Tramite_Documentario/fecha_actual'] = 'tramite_documentario/Documento_externo_ctrllr/fecha_actual';
$route['Tramite_Documentario/CrearInterno/getTipoxTipoDoc'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_dependencias_internos_general';
$route['Tramite_Documentario/CrearInterno/Listar_dependencias_internos'] = 'tramite_documentario/crea_Documento_ctrllr/Listar_dependencias_internos_general';
$route['Tramite_Documentario/SubirArchivos/SubidaSingular/externo'] = 'tramite_documentario/Documento_externo_ctrllr/SubidaSingular';


/* CAMBIAR CARGO */
$route['Tramite_Documentario/Cambiar_Cargo'] = 'tramite_documentario/Cambiar_Cargo_ctrllr/inicio';
$route['Tramite_Documentario/Cambiar_Cargo/listarAreas'] = 'tramite_documentario/Cambiar_Cargo_ctrllr/listarAreas';
$route['Tramite_Documentario/CambiarUser/Update'] = 'tramite_documentario/Cambiar_Cargo_ctrllr/UpdateUser';
$route['Tramite_Documentario/Cambiar_Cargo/listaUsuarios'] = 'tramite_documentario/Cambiar_Cargo_ctrllr/listaUsuarios';
$route['Tramite_Documentario/CambiarUser/getAreaInicial'] = 'tramite_documentario/Cambiar_Cargo_ctrllr/getAreaInicial';
$route['Tramite_Documentario/CambiarUser/setDatosArea'] = 'tramite_documentario/Cambiar_Cargo_ctrllr/setDatosArea';


/* TUTAS PARA EL ACCESO DE LAS FUNCIONES DE FONAVI */
$route['Reporte_Reclamo/Reclamo_Fonavi'] = 'ReclamosFonavi/Reclamos_fonavi_ctrllr/lista_estados';
$route['Reporte_Reclamo/BusquedaRecibo'] = 'ReclamosFonavi/Reclamos_fonavi_ctrllr/buscar_recibo';
$route['Reporte_Reclamo/EnvioReclamo'] = 'ReclamosFonavi/Reclamos_fonavi_ctrllr/save_reclamoFonavi';
$route['Reporte_Reclamo/InvalidarSolicitud'] = 'ReclamosFonavi/Reclamos_fonavi_ctrllr/invalidar_solicitud';
$route['Reporte_Reclamo/ViewSolicDetalle'] = 'ReclamosFonavi/Reclamos_fonavi_ctrllr/ViewDetalleReclamo';

$route['Reporte_Reclamo/Reporte_Fonavi'] = 'ReclamosFonavi/Reporte_fonavi_ctrllr/listaReporte';
$route['Reporte_Reclamo/Reporte_Fonavi/Reporte'] = 'ReclamosFonavi/Reporte_fonavi_ctrllr/generarReporte';
$route['Reporte_Reclamo/Reporte_Fonavi/Genera_Excel'] = 'ReclamosFonavi/Reporte_fonavi_ctrllr/CrearExcel';
$route['Reporte_Reclamo/Reporte_Fonavi/Reporte_pdf'] = 'ReclamosFonavi/Reporte_fonavi_ctrllr/SendReportPDF';
// $route['Reclamos/Fonavi'] = 'ReclamosFonavi/Reclamos_fonavi_ctrllr/inicio';
// $route['Reclamos/BusquedaRecibo'] = 'ReclamosFonavi/Reclamos_fonavi_ctrllr/inicio';







