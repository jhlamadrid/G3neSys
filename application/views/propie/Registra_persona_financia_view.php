
<script type="text/javascript"></script>

    <!-- MODAL PARA EL CALCULO -->
    <div class="modal fade" id="MOD_RECALCULAR" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1"  >
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <h5><span class="glyphicon glyphicon-usd"></span> RECALCULAR</h5>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
           <div class="row">
               <div class="col-md-12">
                   <div class="alert alert-danger alert-dismissible" id="mensaje_alerta" style=" display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <p id="recalcular_mensaje">
                                  
                              </p>
                    </div>
               </div>
           </div>
           <div class="row">
                <div class="form-group control-group col-md-6 ">
                    <label>INICIAL: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                          <input class="form-control" id="Mod_inicial" type="text" />
                        </div>  
                </div>
                <div class="form-group control-group col-md-6 ">
                    <label>NUMERO DE CUOTAS: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                          <input class="form-control" id="Mod_num_cuotas" type="text"  />
                        </div>  
                </div>
           </div>

           <div class="row">
               <div class="col-md-12">
                   
               </div>
           </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-flat " id="Guardar_recal">
               <span class="glyphicon glyphicon-floppy-saved"></span> Guardar
            </button>
            <button type="button" class="btn btn-danger btn-flat " data-dismiss="modal">
                <span class="glyphicon glyphicon-remove"></span> Cancelar
            </button>
            
        </div>
      </div>
      
    </div>
  </div> 
    <!--FIN MODAL DE CALCULO -->
<form action="#" enctype="multipart/form-data" method="post">
<!-- MODAL TITULAR -->
<div class="modal fade" id="ModalTitular" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR ARCHIVOS DE TITULAR</h5>
      </div>
      <div class="modal-body">
        <div class="file-loading">
          <input id="titular-es" name="titular-es[]" type="file" multiple>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" title="" id="Gardar_File_titular">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DEL MODAL TITULAR-->

<!-- MODAL REPRESENTATE -->
<div class="modal fade" id="ModalRepresentante" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR ARCHIVOS DEL REPRESENTANTE</h5>
      </div>
      <div class="modal-body">
        <div class="file-loading">
          <input id="representante-es" name="representante-es[]" type="file" multiple>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" title="" id="Gardar_File_Representante">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DEL MODAL REPRESENTANTE-->
</form>
    <!-- Modal representante  -->
  <div class="modal fade" id="REPRESENTANTE" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" >
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <h5><span class="glyphicon glyphicon-lock"></span> REPRESENTANTE</h5>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
           <div class="row">
                <div class="form-group control-group col-md-6 ">
                    <label>DOC. IDENTIDAD: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                         <select class="form-control" id="Tip_documento_ident">
                            <option value="1">DNI</option>
                            <option value="4">CEXT</option>
                            <option value="2">PASAPORTE</option>
                          </select>
                        </div>  
                </div>
                <div class="form-group control-group col-md-6 ">
                    <label>DOCUMENTO: 
                        <a id="Form-Edit" data-toggle="tooltip" data-placement="bottom" title data-original-title="Editar datos del usuario"><i class="fa fa-pencil"></i></a>
                    </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                          <input class="form-control" id="Repre_doc" type="text" codigo="-1" tipo="-1" longitud="-1"   maxlength="8"/>
                        </div>  
                </div>
                <div class="form-group control-group col-md-8 ">
                    <label>NOMBRE: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                          <input class="form-control" id="Repre_nom" type="text" codigo="-1" tipo="-1" longitud="-1" readonly="true" />
                        </div>  
                </div>
                <div class="form-group control-group col-md-4 ">
                    <label>CORREO: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                          <input class="form-control" id="Repre_correo" type="text" codigo="-1" tipo="-1" longitud="-1" readonly="true" />
                        </div>  
                </div>
                <div class="form-group control-group col-md-8 ">
                    <label>DIRECCIÓN: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                          <input class="form-control" id="Repre_dire" type="text" codigo="-1" tipo="-1" longitud="-1" readonly="true" />
                        </div>  
                </div>
                <div class="form-group control-group col-md-4 ">
                    <label>TELEFONO: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                            </div>
                          <input class="form-control" id="Repre_tel" type="text" codigo="-1" tipo="-1" longitud="-1" readonly="true" />
                        </div>  
                </div>
           </div>
           <div class="row">
               <div class="col-md-12">
                   
               </div>
           </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-flat " id="Guardar_repre">
               <span class="glyphicon glyphicon-floppy-saved"></span> Guardar
            </button>
            <button type="button" class="btn btn-warning btn-flat " id="Repre_limpiar">
               <span class="glyphicon glyphicon-refresh"></span> Limpiar
            </button>
            <button type="button" class="btn btn-danger btn-flat " id="Repre_cancel">
                <span class="glyphicon glyphicon-remove"></span> Cancelar
            </button>
          
        </div>
      </div>
      
    </div>
  </div> 
<!--FIN MODAL-->

<!-- Modal de los recibos con deuda-->
<div class="modal fade" id="sum_deuda" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" >
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <h5><span class="	glyphicon glyphicon-file"></span> SUMINISTROS CON DEUDA</h5>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
           <div class="row">
                <h4 class="box-title">
				    <ul style="list-style-type:circle">
					    <li>
						    <b>UNIDADES DE USO RELACIONADAS A ESTE CODIGO</b>
						</li>
					</ul>
				</h4>
			    <hr>
           </div>
           <div class="row">
                <div class='col-md-12' style="margin-top:15px;">
                    <table class=' table display' id='deuda_suministro' >
                        <thead>
                            <th>Item</th>
                            <th>Suministro</th>
                            <th>Nombre</th>
                            <th>Fecha Emi.</th>
                            <th>Fecha Ven.</th>
                            <th>Serie</th>
                            <th>Numero</th>
                            <th>Imp. Real</th>
                            <th>Estado</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
           </div>
           <div class = "row">
                <div class="form-group control-group col-md-6 ">
                    <label>DEUDA CAPITAL: </label>
                       <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-money"></i>
                            </div>
                          <input class="form-control" id="Suministro_deuda_capital" type="text" codigo="-1" tipo="-1" longitud="-1" readonly="true" />
                        </div>  
                </div>
           </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-flat " id="Aceptar_sum_deuda">
               <span class="glyphicon glyphicon-floppy-saved"></span>Aceptar
            </button>
            
          
        </div>
      </div>
      
    </div>
  </div> 
<!--MODAL EDITAR TITULAR -->
<div class="modal fade" id="MODEDITITU" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title" id="MODEDITITU-TITULO">EDITAR TITULAR</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row">
                           <div class="col-md-12">
                               <div class="alert alert-danger alert-dismissible" id="MODEDITITU_alerta" style=" display: none;">
                                       <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                          <p id="MODEDITITU_mensaje">
                                              
                                          </p>
                                </div>
                           </div>
                       </div>
                      <div class="row">
                        <div class="col-md-2 col-md-offset-10">
                         <a class='btn btn-success btn-sm  right centrado' id='btnAddInstancia' data-toggle="collapse" data-target="#Mostrar_datos" aria-expanded="false">
                                <i class="fa fa-pencil" aria-hidden="true"></i> DATOS ACTUALES 
                          </a> 
                        </div>
                      </div>
                      <div class="collapse" id="Mostrar_datos">
                        <div class="well" style="margin-top: 13px;">
                          <div class="row">
                            <div class="form-group  col-md-8 col-sm-12">
                              <label>NOMBRE:</label>
                              <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                  </div>
                                  <input class="form-control limpia" id="MODEDITITU-NOMBRE" type="text" style='text-transform:uppercase;' disabled="true" />
                              </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>DNI:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-credit-card"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-DNI" type="text" style='text-transform:uppercase; background : #fff;' disabled="true" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-12 col-sm-12">
                                <label>DIRECCIÓN</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-universal-access"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-DIRECCION" type="text" style='text-transform:uppercase;' disabled="true" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>RUC</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-RUC" type="text" style='text-transform:uppercase;' disabled="true" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>TELEFONO</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-phone"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-TELEFONO" type="text" style='text-transform:uppercase;' disabled="true" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>CORREO</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-CORREO" type="text" style='text-transform:uppercase;' disabled="true" />
                                </div>  
                            </div>
                          </div>
                          
                        </div>
                      </div>
                            
                          <div class="form-group  col-md-8 col-sm-12">
                              <label>NOMBRE:</label>
                              <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                  </div>
                                  <input class="form-control limpia" id="MODEDITITU-NOMBRE-NUEVO" type="text" style='text-transform:uppercase;' />
                              </div>  
                          </div>
                          <div class="form-group control-group col-md-4 col-sm-12">
                                <label>DNI:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-credit-card"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-DNI-NUEVO" type="text" style='text-transform:uppercase;' maxlength="8" />
                                </div>  
                          </div>
                          <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO PATERNO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-AP-NUEVO" type="text" style='text-transform:uppercase;'/>
                                </div>  
                          </div>
                          <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO MATERNO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-AM-NUEVO" type="text" style='text-transform:uppercase;' />
                                </div>  
                          </div>
                          <div class="form-group control-group col-md-4 col-sm-12">
                                <label>RUC</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-RUC-NUEVO" type="text" style='text-transform:uppercase;' maxlength="11" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>TELEFONO</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-phone"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-TELEFONO-NUEVO" type="text" style='text-transform:uppercase;' maxlength="9"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>CORREO</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODEDITITU-CORREO-NUEVO" type="email" style='text-transform:uppercase;' />
                                </div>  
                            </div>
                          <div class="form-group control-group col-md-4 col-sm-12">
                                <label>ZONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <select class="form-control" id="MODEDITITU-CZONA-NUEVO" name="tipo-comprobante">
                                        <option value="-1">NINGUNO</option>
                                        <?php if(isset($codigo_zona)) foreach ($codigo_zona as $codigo) { ?>
                                            <option value="<?php echo $codigo['DOC_NAME']?>"><?php echo $codigo['DESCRIPCIO']?></option>
                                        <?php }?>
                                    </select>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-12">
                                <label>NOMBRE DE ZONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-NMZONA-NUEVO" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>VIA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <select class="form-control" id="MODEDITITU-TVIA-NUEVO" name="tipo-comprobante">
                                        <option value="-1">NINGUNO</option>
                                        <?php if(isset($tipo_via)) foreach ($tipo_via as $tipo) { ?>
                                            <option value="<?php echo $tipo['DOC_NAME']?>"><?php echo $tipo['DESCRIPCIO']?></option>
                                        <?php }?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-12">
                                <label>NOMBRE DE VIA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODEDITITU-NMVIA-NUEVO" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>NUMERO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-NRO-NUEVO" type="text" style='text-transform:uppercase;' maxlength="5"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>KILOMETRO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-KM-NUEVO" type="text" style='text-transform:uppercase;' maxlength="5"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>MANZANA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-MNZ-NUEVO" type="text" style='text-transform:uppercase;' maxlength="5"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>INTERIOR:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-INT-NUEVO" type="text" style='text-transform:uppercase;' maxlength="5"/>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>DEPARTAMENTO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-DEP-NUEVO" type="text" style='text-transform:uppercase;' maxlength="5"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>LOTE:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODEDITITU-LT-NUEVO" type="text" style='text-transform:uppercase;' maxlength="5"/>
                                </div>  
                            </div>
                      
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="MODEDITITU-OK">Guardar</button>
                    <button type="submit" class="btn btn-danger btn-flat pull-right" id="MODEDITITU-CANCELAR"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!-- FIN MODAL EDITAR TITULAR -->
    <div class="modal fade" id="MODREGPER" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
                    <h4 class="modal-title" id="MODREGPER-TITULO">REGISTRAR PERSONA</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="MODREGPER-FORM">
                            <!--<div class="col-md-12" id="MODREGPER-MSJ" style="display:hidden"></div>-->
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>DOC. IDENTIDAD: <a target="_blank" href="<?php echo $rutabsq1; ?>"><i class="fa fa-eye"></i></a></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-TIPDOC" type="text" codigo="-1" tipo="-1" longitud="-1" disabled/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>DOCUMENTO: </label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-DNI" type="text" disabled/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO PATERNO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-AP" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-6 col-sm-12">
                                <label>APELLIDO MATERNO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-AM" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-12 col-sm-12">
                                <label>NOMBRE:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control limpia" id="MODREGPER-NM" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>EMAIL:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-EMAIL" type="text"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>EMAIL 2:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-EMAIL2" type="text"/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>FIJO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-FIJO" type="text" maxlength="9" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>FIJO 2:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-FIJO2" type="text" maxlength="9" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>CELULAR:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-CELULAR" type="text" maxlength="9" />
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>CELULAR 2:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                    <input class="form-control sin_espacio" id="MODREGPER-CELULAR2" type="text" maxlength="9" />
                                </div>  
                            </div>
                            
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>ZONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <select class="form-control" id="MODREGPER-CZONA" name="tipo-comprobante">
                                        <option value="-1">NINGUNO</option>
                                        <?php if(isset($codigo_zona)) foreach ($codigo_zona as $codigo) { ?>
                                            <option value="<?php echo $codigo['DOC_NAME']?>"><?php echo $codigo['DESCRIPCIO']?></option>
                                        <?php }?>
                                    </select>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-12">
                                <label>NOMBRE DE ZONA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-NMZONA" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>VIA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i> 
                                    </div>
                                    <select class="form-control" id="MODREGPER-TVIA" name="tipo-comprobante">
                                        <option value="-1">NINGUNO</option>
                                        <?php if(isset($tipo_via)) foreach ($tipo_via as $tipo) { ?>
                                            <option value="<?php echo $tipo['DOC_NAME']?>"><?php echo $tipo['DESCRIPCIO']?></option>
                                        <?php }?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group control-group col-md-8 col-sm-12">
                                <label>NOMBRE DE VIA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-NMVIA" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>NUMERO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-NRO" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>KILOMETRO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-KM" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>MANZANA:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-MNZ" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>INTERIOR:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-INT" type="text" style='text-transform:uppercase;'/>
                                </div>
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>DEPARTAMENTO:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-DEP" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <div class="form-group control-group col-md-4 col-sm-12">
                                <label>LOTE:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-LT" type="text" style='text-transform:uppercase;'/>
                                </div>  
                            </div>
                            <!--div class="form-group control-group col-md-12 col-sm-12">
                                <label>DIRECCION:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <input class="form-control" id="MODREGPER-DIR" type="text" style='text-transform:uppercase;' />
                                </div>  
                            </div-->
                        </form>
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="MODREGPER-OK">Registrar</button>
                    <button type="submit" class="btn btn-danger btn-flat pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

<script>
    var accion_modregper = '-1';

    $(document).ready(function(){
        $("#MODREGPER-TVIA").change(function(){
            if($("#MODREGPER-TVIA option:selected").attr('value')=='-1'){
                $("#MODREGPER-NMVIA").val('');
                $("#MODREGPER-NMVIA").attr('disabled', true);
            }else{
                $("#MODREGPER-NMVIA").attr('disabled', false);
            }
        });
        $("#MODREGPER-FIJO").keydown(function(event) {
             if(event.shiftKey)
             {
                  event.preventDefault();
             }

             if (event.keyCode == 46 || event.keyCode == 8)    {
             }
             else {
                  if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                          event.preventDefault();
                    }
                  } 
                  else {
                        if (event.keyCode < 96 || event.keyCode > 105) {
                            event.preventDefault();
                        }
                  }
                }
            });
        $("#MODREGPER-FIJO2").keydown(function(event) {
             if(event.shiftKey)
             {
                  event.preventDefault();
             }

             if (event.keyCode == 46 || event.keyCode == 8)    {
             }
             else {
                  if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                          event.preventDefault();
                    }
                  } 
                  else {
                        if (event.keyCode < 96 || event.keyCode > 105) {
                            event.preventDefault();
                        }
                  }
                }
            });
        $("#MODREGPER-CELULAR").keydown(function(event) {
             if(event.shiftKey)
             {
                  event.preventDefault();
             }

             if (event.keyCode == 46 || event.keyCode == 8)    {
             }
             else {
                  if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                          event.preventDefault();
                    }
                  } 
                  else {
                        if (event.keyCode < 96 || event.keyCode > 105) {
                            event.preventDefault();
                        }
                  }
                }
            });
        $("#MODREGPER-CELULAR2").keydown(function(event) {
             if(event.shiftKey)
             {
                  event.preventDefault();
             }

             if (event.keyCode == 46 || event.keyCode == 8)    {
             }
             else {
                  if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                          event.preventDefault();
                    }
                  } 
                  else {
                        if (event.keyCode < 96 || event.keyCode > 105) {
                            event.preventDefault();
                        }
                  }
                }
            });
        $("#MODREGPER-CZONA").change(function(){
            if($("#MODREGPER-CZONA option:selected").attr('value')=='-1'){
                $("#MODREGPER-NMZONA").val('');
                $("#MODREGPER-NMZONA").attr('disabled', true);
            }else{
                $("#MODREGPER-NMZONA").attr('disabled', false);
            }
        });

        // MASCARAS
            $("#MODREGPER-EMAIL").inputmask('email');
            $("#MODREGPER-EMAIL2").inputmask('email');
            
            $(".limpia").inputmask('Regex',{
                regex: '[a-zñA-ZÑ0-9]+( [a-zñA-ZÑ0-9]+)*'
            });
            $(".solo_num").inputmask('Regex',{
                regex: '([0-9])*'
            });
        //

        $("#MODREGPER-CANCEL").on("click", function(){
            $('#MODREGPER').modal("toggle");
            
        });
        $("#MODEDITITU-CANCELAR").on("click", function(){
          
          limpiar_titular(); 
          $('#MODEDITITU').modal('toggle');
           
        });
         $("#Repre_limpiar").on("click", function(){
            $('#Repre_doc').attr('readonly',false);
            $('#Repre_doc').val("");
            $('#Repre_nom').val("");
            $('#Repre_correo').val("");
            $('#Repre_dire').val("");
            $('#Repre_tel').val("");
            usr = null;
            
        });

        $("#MODREGPER-OK").on("click", function(){
            if(accion_modregper=='registrar'){
                //$("#MODREGPER-MSJ").empty();
                registrar_modregper();
                
            }else if(accion_modregper=='editar'){
                //$("#MODREGPER-MSJ").empty();
                actualizar_modregper();
                
            }
        });

        $("#MODEDITITU-OK").on("click", function(){
            var respuesta = validar_titular();
            //console.log("La Respuesta es : " + respuesta);
            if (respuesta) {
              actualizar_titular();
            }
            
        });
        $("#MODREGPER").on('hidden.bs.modal', function () {
            accion_modregper = '-1';
            $("#MODREGPER-FORM")[0].reset();
            
        });

        $(".limpia").focusout(function(){
            var text = $(this).val();
            text = text.trim();
            while(text != text.replace('  ', ' ')){
                text = text.replace('  ', ' ');
            }
            $(this).val(text);
        });

        $(".sin_espacio").keypress(function(e){
            var keyCode = e.keyCode || e.which;
            if (keyCode == '32'){
                return false;
            }
        });

        $("#Guardar_repre").on("click", function(){
            if(usr != null){
                Agregar_Representante();
                $('#REPRESENTANTE').modal('hide');

            }else{
               swal("Atención", "No ingreso usuario", "error"); 
            }
        });
        $("#Gardar_File_titular").on("click", function(){
             $('#ModalTitular').modal('hide');
        });
        $("#Aceptar_sum_deuda").on("click", function(){
             $('#sum_deuda').modal('hide');
        });
        $("#Gardar_File_Representante").on("click", function(){
             $('#ModalRepresentante').modal('hide');
        });
        $('#Mod_num_cuotas').inputmask('integer');
        $('#Mod_inicial').inputmask('currency', {
            prefix: "",
            groupSeparator: "",
            allowPlus: false,
            allowMinus: false,
        });

        $('#MODEDITITU-TELEFONO-NUEVO').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });
        $('#MODEDITITU-DNI-NUEVO').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });
        $('#MODEDITITU-RUC-NUEVO').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });
        $("#Guardar_recal").on("click", function(){
            var ini_modificado = $('#Mod_inicial').val();
            var num_cuota_mod = $('#Mod_num_cuotas').val();
            validar_recalculo(ini_modificado,num_cuota_mod);
        });
        $("#Repre_cancel").on("click", function(){
            $("#slideThree").prop('checked', false); 
            $('#REPRESENTANTE').modal('hide');
        });
              
    });
  
    function limpiar_titular(){
      $('#MODEDITITU-DNI-NUEVO').val('');
      $('#MODEDITITU-TELEFONO-NUEVO').val('');
      $('#MODEDITITU-RUC-NUEVO').val('');
      $('#MODEDITITU-NOMBRE-NUEVO').val('');
      $('#MODEDITITU-AP-NUEVO').val('');
      $('#MODEDITITU-AM-NUEVO').val('');
      $('#MODEDITITU-CORREO-NUEVO').val('');
      $('#MODEDITITU-NMZONA-NUEVO').val('');
      $('#MODEDITITU-NMVIA-NUEVO').val('');
      $('#MODEDITITU-LT-NUEVO').val('');
      $('#MODEDITITU-DEP-NUEVO').val('');
      $('#MODEDITITU-INT-NUEVO').val('');
      $('#MODEDITITU-KM-NUEVO').val('');
      $('#MODEDITITU-DNI-NUEVO').attr('readonly', false);
    }
    
    function validar_titular() {
      var email = $('#MODEDITITU-CORREO-NUEVO').val();
      var dni  =  $('#MODEDITITU-DNI-NUEVO').val();
      var ruc  =  $('#MODEDITITU-RUC-NUEVO').val();
      var telefono  = $('#MODEDITITU-TELEFONO-NUEVO').val();
      var nombre = $('#MODEDITITU-NOMBRE-NUEVO').val();
      var apepat  =  $('#MODEDITITU-AP-NUEVO').val();
      var apemat = $('#MODEDITITU-AM-NUEVO').val();
      var Selector_zona = $('#MODEDITITU-CZONA-NUEVO').val();
      var zona = $('#MODEDITITU-NMZONA-NUEVO').val();
      var Selector_via = $('#MODEDITITU-TVIA-NUEVO').val();
      var via = $('#MODEDITITU-NMVIA-NUEVO').val();
      
      if(email != '' && !validar_campo_modregper(/\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,4})+/, email)){
            $('#MODEDITITU_mensaje').text('FORMATO DE CORREO INCORRECTO');
            setTimeout(Mostra_mensaje, 200);
            //alert("CORREO MAL");
            return false;
        }else{
          if((dni == '') || ( dni != '' && dni.length != 8 )){
            if (dni == '') {
              //alert("DNI VACIO");
              $('#MODEDITITU_mensaje').text('EL CAMPO DE DNI SE ENCUENTRA VACIO');
              setTimeout(Mostra_mensaje, 200);
              return false;
            }else{
              if(dni.length != 8){
                //alert("DNI INCORRECTO");
                $('#MODEDITITU_mensaje').text('TAMAÑO INCORRECTO DE DNI');
                console.log(dni.length);
                setTimeout(Mostra_mensaje, 200);
                return false;
              }
            }
            
          }else{
            if(ruc != '' &&  ruc.length !=11 ){
              $('#MODEDITITU_mensaje').text('TAMAÑO INCORRECTO DE RUC');
              setTimeout(Mostra_mensaje, 200);
              //alert("INGRESO RUC INCORRECTO");
              return false;
            }else{
              if(telefono != '' &&  telefono.length !=9 ){
                $('#MODEDITITU_mensaje').text('TAMAÑO INCORRECTO DE TELEFONO');
                setTimeout(Mostra_mensaje, 200);
                return false;
              }else{
                if (nombre == '') {
                  $('#MODEDITITU_mensaje').text('INGRESE NOMBRE');
                  setTimeout(Mostra_mensaje, 200);
                  return false;
                }else{
                  if (apepat == '') {
                    $('#MODEDITITU_mensaje').text('INGRESE APELLIDO PATERNO');
                    setTimeout(Mostra_mensaje, 200);
                    return false;
                  }else{
                    if (apemat == '') {
                      $('#MODEDITITU_mensaje').text('INGRESE APELLIDO MATERNO');
                      setTimeout(Mostra_mensaje, 200);
                      return false;
                    }else{
                      if (zona == '') {
                        $('#MODEDITITU_mensaje').text('INGRESE NOMBRE DE ZONA');
                        setTimeout(Mostra_mensaje, 200);
                        return false;
                      }else{
                        if (via == '') {
                          $('#MODEDITITU_mensaje').text('INGRESE NOMBRE  VIA');
                          setTimeout(Mostra_mensaje, 200);
                          return false;
                        }else{
                          if($('#MODEDITITU-CZONA-NUEVO').val() == -1){
                            
                            $('#MODEDITITU_mensaje').text('SELECCIONE UN TIPO DE ZONA ');
                            setTimeout(Mostra_mensaje, 200);
                            return false; 
                          }else{
                              if($('#MODEDITITU-TVIA-NUEVO').val() == -1){
                            
                                $('#MODEDITITU_mensaje').text('SELECCIONE UN TIPO DE VIA ');
                                setTimeout(Mostra_mensaje, 200);
                                return false; 
                              }else{
                                return true ;
                              }
                          }
                           
                        }
                      } 
                    }
                  }
                }
              }
            }
          }
        }
    }
    function actualizar_titular() {
      swal({
      title: "EDICION TITULAR",
      text: "¿Esta seguro de la edicion del titular?",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
      },
      function(){
        
          $.ajax({
              type: "POST",
              url: "<?php echo $this->config->item('ip');?>financiamiento/editar/titular?ajax=true",
              data: {
                  email : $('#MODEDITITU-CORREO-NUEVO').val(),
                  dni  :  $('#MODEDITITU-DNI-NUEVO').val(),
                  ruc  :  $('#MODEDITITU-RUC-NUEVO').val(),
                  telefono  : $('#MODEDITITU-TELEFONO-NUEVO').val(),
                  nombre : $('#MODEDITITU-NOMBRE-NUEVO').val(),
                  apepat  :  $('#MODEDITITU-AP-NUEVO').val(),
                  apemat : $('#MODEDITITU-AM-NUEVO').val(),
                  Selector_zona : $('#MODEDITITU-CZONA-NUEVO').val(),
                  zona : $('#MODEDITITU-NMZONA-NUEVO').val(),
                  Selector_via : $('#MODEDITITU-TVIA-NUEVO').val(),
                  via : $('#MODEDITITU-NMVIA-NUEVO').val(),
                  Numero : $('#MODEDITITU-NRO-NUEVO').val() ,
                  Interior : $('#MODEDITITU-INT-NUEVO').val() ,
                  Kilometro : $('#MODEDITITU-KM-NUEVO').val(),
                  Departamento : $('#MODEDITITU-DEP-NUEVO').val() ,
                  Manzana : $('#MODEDITITU-MNZ-NUEVO').val() ,
                  Lote :  $('#MODEDITITU-LT-NUEVO').val() ,
                  Bandera : band_edit_titu ,
                  suministro :  $('#sum_recibo').val(),
                  oficina : $("#Cal_Oficina").val(),
                  agencia : $("#Cal_agencia").val()

              },
              dataType: 'json',
              success: function(data) {
                  if(data.result) {
                    console.log(data);
                    $('#recono_table  tr').eq(1).each(function () {
                          var fila = {};
                          $(this).find('td').each(function (index) {
                                 
                                  switch (index){
                                      case 0: break;
                                      case 1: $(this).text(data.nombre); break;
                                      case 2: break;
                                      case 3: $(this).text(data.dni); break;
                                      case 4: $(this).text(data.ruc);break;
                                      case 5: $(this).text(data.telefono);break;
                                      case 6: $(this).text(data.correo);break;
                                  }
                        });
                        
                    });
                    $('#MODEDITITU').modal('toggle');
                    limpiar_titular(); 
                    swal.close();    
                  }else{
                      //sweetAlert(data.titulo, data.mensaje, data.tipo);
                      //return false;
                  }
              }
          });
        
      });
        
    }

    function validar_recalculo(ini_modificado,num_cuota_mod){
        if (ini_modificado.length==0 || num_cuota_mod.length == 0) {
            $('#recalcular_mensaje').text('SE HA ENCONTRADO CAMPOS VACIOS');
            setTimeout(showTooltip, 600);
        }else{
            if (parseFloat(ini_modificado)<=0 || parseFloat(num_cuota_mod) <= 0) {
                $('#recalcular_mensaje').text('EL NUMERO DE CUOTAS O INICIAL DEBEN DE SER MAYOR O IGUAL A 1');
                setTimeout(showTooltip, 600);
            }else{
                if(parseFloat(ini_modificado) < parseFloat(nuevo_inicial)){
                  $('#recalcular_mensaje').text('LA INICIAL NO PUEDE SER MENOR A LA PREDEFINIDA ');
                    setTimeout(showTooltip, 600);  
                }else{
                    if (parseFloat(num_cuota_mod) > parseFloat(nuevo_num_letras )) {
                        $('#recalcular_mensaje').text('EL NUMERO DE CUOTAS NO PUEDEN SER MAYOR A LA PREDEFINIDA');
                        setTimeout(showTooltip, 600);  
                    }else{
                        //alert("exito");
                        if (parseFloat(ini_modificado)> parseFloat($('#fi_deuda_total').val())) {
                            $('#recalcular_mensaje').text('EL SALDO INICIAL NO PUEDE SER MAYOR ');
                            setTimeout(showTooltip, 600);  
                        }else{
                            console.log("exito");
                            $('#Cal_inicial').val(ini_modificado);
                            $('#Cal_nro_cuota').val(num_cuota_mod);
                            $('#cal_base_nro_cuota').val(num_cuota_mod);
                            var sald_modificado = parseFloat($('#fi_deuda_total').val()) - parseFloat(ini_modificado);
                            $('#Cal_saldo').val(sald_modificado.toFixed(2));
                            $('#cal_base_saldo').val(sald_modificado.toFixed(2));
                            var i= parseFloat($('#cal_tasa_interes').val());
                            console.log(i);
                            var n= parseFloat(num_cuota_mod); 
                            console.log(n);
                            //(+B7*((1+B7)^B6))/(((1+B7)^B6)-1)
                            var resultado_frc = (i * Math.pow((1+ i),n))/(Math.pow((1+i),n)-1);
                            console.log(resultado_frc);
                            $('#cal_frc').val(resultado_frc.toFixed(7));
                            $('#MOD_RECALCULAR').modal('hide');
                            simular_financiamiento();
                        }
                    }
                }
            }
        }
        
    }
    function showTooltip()
    {
        $('#mensaje_alerta').show('slow');
        setTimeout(hideTooltip, 3000)
    }
    function Mostra_mensaje()
    {
        $('#MODEDITITU_alerta').show('slow');
        setTimeout(Ocultar_mensaje, 3000)
    }
    function Ocultar_mensaje()
      {
       $('#MODEDITITU_alerta').hide('slow');
      }
    function hideTooltip()
      {
       $('#mensaje_alerta').hide('slow');
      }
    function registrar_modregper(){
        
        var tipdoc = $("#MODREGPER-TIPDOC").attr('codigo');
        var dni = $("#MODREGPER-DNI").val();
        var apepat = $("#MODREGPER-AP").val().toUpperCase();
        var apemat = $("#MODREGPER-AM").val().toUpperCase();
        var nm = $("#MODREGPER-NM").val().toUpperCase();
        //var email = $("#MODREGPER-EMAIL").val();
        //var dir = $("#MODREGPER-DIR").val();
        var email = $("#MODREGPER-EMAIL").val();
        var email2 = $("#MODREGPER-EMAIL2").val();
        var fijo = $("#MODREGPER-FIJO").val();
        var fijo2 = $("#MODREGPER-FIJO2").val();
        var celular = $("#MODREGPER-CELULAR").val();
        var celular2 = $("#MODREGPER-CELULAR2").val();
        var tvia = $("#MODREGPER-TVIA option:selected").attr('value');
        var nmvia = $("#MODREGPER-NMVIA").val().toUpperCase();
        var czona = $("#MODREGPER-CZONA option:selected").attr('value');
        var nmzona = $("#MODREGPER-NMZONA").val().toUpperCase();
        var nro = $("#MODREGPER-NRO").val();
        var km = $("#MODREGPER-KM").val();
        var mnz = $("#MODREGPER-MNZ").val();
        var inte = $("#MODREGPER-INT").val();
        var dep = $("#MODREGPER-DEP").val();
        var lt = $("#MODREGPER-LT").val();
        
        tvia = (tvia=='-1')? '':tvia;
        czona = (czona=='-1')? '':czona;

        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>registrar/persona?ajax=true",
            data: { TIPDOC: tipdoc, DNI: dni, APEPAT:apepat, APEMAT:apemat, NOMPER:nm, 
                    EMAIL:email, EMAIL2:email2, CELULAR:celular, CELULAR2:celular2, 
                    FIJO:fijo, FIJO2:fijo2, TIPO_DE_VIA:tvia, NOMBRE_DE_VIA:nmvia, KILOMETRO:km, 
                    MANZANA:mnz, LOTE:lt, NUMERO:nro, 
                    DEPARTAMENTO:dep, INTERIOR:inte, CODIGO_DE_ZONA:czona, 
                    TIPO_DE_ZONA:nmzona},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    console.log("usuario registrado");
                    usr =null;
                    usuario=data.persona;
                    $('#Repre_doc').attr('readonly', true);
                    $('#Repre_nom').val(usuario['APEPAT']+' '+usuario['APEMAT']+' '+usuario['NOMBRE']);
                    $('#Repre_correo').val(usuario['EMAIL']);
                    $('#Repre_dire').val(usuario['DIREC']);
                    $('#Repre_tel').val(usuario['TELCEL']);
                    usr = usuario;
                    $('#MODREGPER').modal('hide');
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function actualizar_modregper(){
        var tipdoc = $("#MODREGPER-TIPDOC").attr('codigo');
        var dni = $("#MODREGPER-DNI").val();
        var apepat = $("#MODREGPER-AP").val().toUpperCase();
        var apemat = $("#MODREGPER-AM").val().toUpperCase();
        var nm = $("#MODREGPER-NM").val().toUpperCase();
        //var email = $("#MODREGPER-EMAIL").val();
        //var dir = $("#MODREGPER-DIR").val();
        var email = $("#MODREGPER-EMAIL").val();
        var email2 = $("#MODREGPER-EMAIL2").val();
        var fijo = $("#MODREGPER-FIJO").val();
        var fijo2 = $("#MODREGPER-FIJO2").val();
        var celular = $("#MODREGPER-CELULAR").val();
        var celular2 = $("#MODREGPER-CELULAR2").val();
        var tvia = $("#MODREGPER-TVIA option:selected").attr('value');
        var nmvia = $("#MODREGPER-NMVIA").val().toUpperCase();
        var czona = $("#MODREGPER-CZONA option:selected").attr('value');
        var nmzona = $("#MODREGPER-NMZONA").val().toUpperCase();
        var nro = $("#MODREGPER-NRO").val();
        var km = $("#MODREGPER-KM").val();
        var mnz = $("#MODREGPER-MNZ").val();
        var inte = $("#MODREGPER-INT").val();
        var dep = $("#MODREGPER-DEP").val();
        var lt = $("#MODREGPER-LT").val();
        
        tvia = (tvia=='-1')? '':tvia;
        czona = (czona=='-1')? '':czona;

        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>actualizar/persona?ajax=true",
            data: { TIPDOC: tipdoc, DNI: dni, APEPAT:apepat, APEMAT:apemat, NOMPER:nm, 
                    EMAIL:email, EMAIL2:email2, CELULAR:celular, CELULAR2:celular2, 
                    FIJO:fijo, FIJO2:fijo2, TIPO_DE_VIA:tvia, NOMBRE_DE_VIA:nmvia, KILOMETRO:km, 
                    MANZANA:mnz, LOTE:lt, NUMERO:nro, 
                    DEPARTAMENTO:dep, INTERIOR:inte, CODIGO_DE_ZONA:czona, 
                    TIPO_DE_ZONA:nmzona},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    //console.log("actualizado");
                    usuario=data.persona;
                    //$('#Repre_doc').attr('readonly', true);
                    $('#Repre_nom').val(usuario['APEPAT']+' '+usuario['APEMAT']+' '+usuario['NOMBRE']);
                    $('#Repre_correo').val(usuario['EMAIL']);
                    $('#Repre_dire').val(usuario['DIREC']);
                    $('#Repre_tel').val(usuario['TELCEL']);
                    usr = usuario;
                    $('#MODREGPER').modal('hide');
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    //para lo que es facturacion 
    function cambiar_tipo_modregper(tipo){
        accion_modregper = tipo;
        if(accion_modregper == 'editar'){
            $("#MODREGPER-OK").empty();
            $("#MODREGPER-OK").html('Actualizar');
            $("#MODREGPER-TITULO").empty();
            $("#MODREGPER-TITULO").html('ACTUALIZAR PERSONA');
            abrir_editar_persona();
        }else if(accion_modregper=='registrar'){
            $("#MODREGPER-OK").empty();
            $("#MODREGPER-OK").html('Registrar');
            $("#MODREGPER-TITULO").empty();
            $("#MODREGPER-TITULO").html('REGISTRAR PERSONA');
        }
    }

    function validar_campo_modregper(exp_reg, texto){
        texto = texto.toUpperCase();
        //console.log(texto);
        //console.log(exp_reg);
        str = exp_reg.exec(texto);
        console.log(str);
        if(str == null){
            return false;
        }
        return (str[0] == texto);
    }

    function validar_modregper(){
        var codigo = $("#MODREGPER-TIPDOC").attr('codigo');
        var dni = $("#MODREGPER-DNI").val();
        var apepat = $("#MODREGPER-AP").val().toUpperCase();
        var apemat = $("#MODREGPER-AM").val().toUpperCase();
        var nm = $("#MODREGPER-NM").val().toUpperCase();
        var email = $("#MODREGPER-EMAIL").val();
        var email2 = $("#MODREGPER-EMAIL2").val();
        var fijo = $("#MODREGPER-FIJO").val();
        var fijo2 = $("#MODREGPER-FIJO2").val();
        var celular = $("#MODREGPER-CELULAR").val();
        var celular2 = $("#MODREGPER-CELULAR2").val();
        //var dir = $("#MODREGPER-DIR").val();

        var tipo = $("#Form-TDIdent option:selected").attr("tipo");
        var l = $("#Form-TDIdent option:selected").attr("longitud");
        var tf = false;
        //console.log(tipo);
        //console.log(l);
            
        if(tipo=='N'){
            $('#Form-Id').inputmask('Regex', {
                regex:'[0-9]{'+l+'}'
            });
            var er = new RegExp('[0-9]{'+l+'}');
            tf = validar_campo_modregper(er, $('#Form-Id').val());
        }else{
            var er = new RegExp('[0-9A-Za-z]{5,'+l+'}');
            $('#Form-Id').inputmask('Regex', {
                regex:'[0-9A-Za-z]{'+l+'}'
            });
            tf = validar_campo_modregper(er, $('#Form-Id').val());
        }

        /*if(!validar_campo_modregper(/[0-9]{8}/, dni)){
            put_modregper_message('error', 'DNI no valido');
            $("#MODREGPER-DNI").focus();
            return false;
        }*/

        if(email != '' && !validar_campo_modregper(/\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,4})+/, email)){
            put_modregper_message('error', 'Email no valido');
            $("#MODREGPER-EMAIL").focus();
            return false;
        }

        if(!validar_campo_modregper(/[A-Z]+( [A-Z]+)*/, apepat)){
            put_modregper_message('error', 'Apellido Paterno no valido');
            $("#MODREGPER-AP").focus();
            return false;
        }

        if(!validar_campo_modregper(/[A-Z]+( [A-Z]+)*/, apemat)){
            put_modregper_message('error', 'Apellido Materno no valido');
            $("#MODREGPER-AM").focus();
            return false;
        }

        if(!validar_campo_modregper(/[A-Z]+( [A-Z]+)*/, nm)){
            put_modregper_message('error', 'Nombre no valido');
            $("#MODREGPER-NM").focus();
            return false;
        }
        return true;
    }

    function buscar_persona(nro_dni){
        swal({
              title: 'Buscando DNI: '+ nro_dni,
              text: 'Espere mientras buscamos al usuario',
              type: "info",
              showCancelButton: false,
              closeOnConfirm: false,
              showLoaderOnConfirm: false,
            });
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>consulta/buscar-dni?ajax=true",
            data: {dni: nro_dni, tipdoc: $('#Tip_documento_ident').val()},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.dni){
                        usuario=data.persona;
                        $('#Repre_doc').attr('readonly', true);
                        $('#Repre_nom').val(usuario['APEPAT']+' '+usuario['APEMAT']+' '+usuario['NOMBRE']);
                        $('#Repre_correo').val(usuario['EMAIL']);
                        $('#Repre_dire').val(usuario['DIREC']);
                        $('#Repre_tel').val(usuario['TELCEL']);
                        usr = usuario;
                        swal.close();
                        
                    }else{

                        swal.close();

                        /*$("#Form-Id").val(nro_dni); */
                        $("#MODREGPER-TIPDOC").attr('codigo', $('#Tip_documento_ident').val());
                        $("#MODREGPER-TIPDOC").val($('#Tip_documento_ident option:selected').text());
                        $("#MODREGPER-DNI").val(nro_dni);
                        cambiar_tipo_modregper('registrar');
                        $('#MODREGPER').modal("show");
                    }
                    //sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }

    function buscar_titular(nro_dni){
      swal({
            title: 'Buscando DNI: '+ nro_dni,
            text: 'Espere mientras buscamos al usuario',
            type: "info",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: false,
      });

      $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('ip');?>consulta/buscar-dni?ajax=true",
            data: {dni: nro_dni, tipdoc: 1},
            dataType: 'json',
            success: function(data) {
                if(data.result) {
                    if(data.dni){
                        console.log("encontrado");
                        var respuesta = data.persona;
                        band_edit_titu = 1;
                        $('#MODEDITITU-DNI-NUEVO').attr('readonly', true);
                        $('#MODEDITITU-AP-NUEVO').val(respuesta['APEPAT']);
                        $('#MODEDITITU-AM-NUEVO').val(respuesta['APEMAT']);
                        $('#MODEDITITU-NOMBRE-NUEVO').val(respuesta['NOMBRE']);
                        $('#MODEDITITU-CORREO-NUEVO').val(respuesta['EMAIL']);
                        $('#MODEDITITU-TELEFONO-NUEVO').val(respuesta['TELCEL']);
                        $('#MODEDITITU-NMZONA-NUEVO').val(respuesta['TIPO_DE_ZONA']);
                        $('#MODEDITITU-NMVIA-NUEVO').val(respuesta['NOMBRE_DE_VIA']);
                        $('#MODEDITITU-NRO-NUEVO').val(respuesta['NUMERO']);
                        $('#MODEDITITU-INT-NUEVO').val(respuesta['INTERIOR']);
                        $('#MODEDITITU-KM-NUEVO').val(respuesta['KILOMETRO']);
                        $('#MODEDITITU-DEP-NUEVO').val(respuesta['DEPARTAMENTO']);
                        $('#MODEDITITU-MNZ-NUEVO').val(respuesta['MANZANA']);
                        $('#MODEDITITU-LT-NUEVO').val(respuesta['LOTE']);
                        $('#MODEDITITU-CZONA-NUEVO > option[value="'+respuesta['CODIGO_DE_ZONA']+'"]').attr('selected', 'selected');
                        $('#MODEDITITU-TVIA-NUEVO > option[value="'+respuesta['TIPO_DE_VIA']+'"]').attr('selected', 'selected');
                        console.log(respuesta);
                        //usr = usuario;
                        swal.close();
                        
                    }else{

                        band_edit_titu = 0;
                        $('#MODEDITITU_mensaje').text('USUARIO NUEVO , FAVOR DE INGRESAR LOS DATOS');
                        setTimeout(Mostra_mensaje, 200);
                        swal.close();
                        
                    }
                    //sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return true;
                }else{
                    sweetAlert(data.titulo, data.mensaje, data.tipo);
                    return false;
                }
            }
        });
    }
    function abrir_editar_persona(){
        
        var tipo = $("#Form-TDIdent option:selected").attr("tipo");
        var l = $("#Form-TDIdent option:selected").attr("longitud");
        var codigo = $("#Tip_documento_ident option:selected").val();
        
        $("#MODREGPER-TIPDOC").attr('codigo', codigo);
        $("#MODREGPER-TIPDOC").attr('tipo', l);
        $("#MODREGPER-TIPDOC").attr('longitud', tipo);
        $("#MODREGPER-TIPDOC").val($("#Form-TDIdent option:selected").text());
        $("#MODREGPER-DNI").val(usr['NRODOC']);
        $("#MODREGPER-AP").val(usr['APEPAT']);
        $("#MODREGPER-AM").val(usr['APEMAT']);
        $("#MODREGPER-NM").val(usr['NOMBRE']);
        $("#MODREGPER-EMAIL").val(usr['EMAIL']);
        //var dir = $("#MODREGPER-DIR").val();
        $("#MODREGPER-EMAIL2").val(usr['EMAIL2']);
        $("#MODREGPER-FIJO").val(usr['TELFIJ']);
        $("#MODREGPER-FIJO2").val(usr['TELFIJ2']);
        $("#MODREGPER-CELULAR").val(usr['TELCEL']);
        $("#MODREGPER-CELULAR2").val(usr['TELCEL2']);
        $("#MODREGPER-TVIA option[value='"+usr['TIPO_DE_VIA']+"']").attr('selected', true);
        $("#MODREGPER-NMVIA").val(usr['NOMBRE_DE_VIA']);
        $("#MODREGPER-CZONA option[value='"+usr['CODIGO_DE_ZONA']+"']").attr('selected', true);
        $("#MODREGPER-NMZONA").val(usr['TIPO_DE_ZONA']);
        $("#MODREGPER-NRO").val(usr['NUMERO']);
        $("#MODREGPER-KM").val(usr['KILOMETRO']);
        $("#MODREGPER-MNZ").val(usr['MANZANA']);
        $("#MODREGPER-INT").val(usr['INTERIOR']);
        $("#MODREGPER-DEP").val(usr['DEPARTAMENTO']);
        $("#MODREGPER-LT").val(usr['LOTE']);
        //accion_modregper = 'editar';
    }

    function put_modregper_message(tipo, mensaje){
        $("#MODREGPER-MSJ").empty();
        $("#MODREGPER-MSJ").append(     '<div class="alert alert-'+tipo+' alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                                        mensaje+
                                        '</div>');
    }
</script>