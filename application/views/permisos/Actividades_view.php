<script type="text/javascript">
  var servidor = '<?php echo $this->config->item('ip'); ?>';
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a type="button" onclick='abrir_modal()' class="btn btn-success font-new">
              <i class="fa fa-plus" aria-hidden="true"></i> NUEVA ACTIVIDAD
            </a>
          </h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="listar_actividades" class="table table-bordered table-striped">
                  <thead>
                    <tr role="row">
                      <th>NOMBRE</th>
                      <th>DESCRIPCIÓN</th>
                      <th>ICONO</th>
                      <th>FECHA CREACIÓN</th>
                      <th>OPCIONES</th>
                    </tr>
                  </thead>
                    <tbody>
                      <?php foreach ($actividades as $actividad) { ?>
                        <tr>
                          <td colspan="5" style="text-transform:uppercase;color: #ffffff;background: cadetblue;"><li class="<?php echo $actividad['MENUGENICON'] ?>"></li> &nbsp;&nbsp; <?php echo $actividad['MENUGENNOM']; ?></td>
                          <td style="display:none"></td>
                          <td style="display:none"></td>
                          <td style="display:none"></td>
                          <td style="display:none"></td>
                        </tr>
                        <?php  foreach ($actividad['actividades'] as $value) { ?>
                          <tr>
                            <td><?php echo $value['ACTIVINOMB']; ?></td>
                            <td><?php echo $value['ACTIVDESC']; ?></td>
                            <td style="text-align:center"><a class="btn"><i class="<?php echo $value['ACTIVIICON'] ?>" aria-hidden="true"></i></a></td>
                            <td><?php echo $value['ACTIVIFECHA']; ?></td>
                            <td style="text-align:center">
                              <a onclick="editar_actividad('<?php echo $value['ID_ACTIV'] ?>')" class="btn btn-default"  data-toggle="tooltip" data-placement="bottom" title="EDITAR ACTIVIDAD">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </a>
                            </td>
                          </tr>
                        <?php } ?>
                      <?php } ?>
                    </tbody>
                  </table>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>
<div id="newActividad" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-family:Ubuntu">CREAR NUEVA ACTIVIDAD</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              SELECCIONE PADRE ACTIVIDAD
              <select class="form-control" id="padres" style="text-transform:uppercase !important">
                <option value="-1">SELECCIONE UNA OPCIÓN</option>
                <?php foreach ($actividades as $act) { ?>
                  <option value="<?php echo $act['ID_MENUGEN']; ?>" style="text-transform:uppercase !important"><?php echo $act['MENUGENNOM']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group margin">
              <div class="input-group-btn">
                <button type="button" class="btn btn-success" onclick="agregar_nuevo_menu()">NUEVO MENU</button>
              </div>
              <input type="text" class="form-control" id="nombre_padre" disabled>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              NOMBRE <span class="text-red">*</span>
              <input type="text" class="form-control" id='nombre' name="" value="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              DESCRIPCIÓN <span class="text-red">*</span>
              <input type="text" class="form-control" id='descripcion' value="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              ABREVIATURA
              <input type="text" class="form-control" id='abreviatura' value="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              HIJO <span class="text-red">*</span>
              <input type="text" class="form-control" id='hijo' value="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              RUTA <span class="text-red">*</span>
              <input type="text" class="form-control" id='ruta' value="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <a class="btn btn-primary" onclick="$('#iconos').modal('show');tipo = 1"> SELECCIONAR ICONO <span class="text-red">*</span></a>
              <a class="btn pull-right"><i class="" id='icono_seleccionado' name="" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> CANCELAR</button>
        <button type="button" class="btn btn-success" onclick="guardar_actividad()"><i class="fa fa-floppy-o" aria-hidden="true" ></i> GUARDAR</button>
      </div>
    </div>
  </div>
</div>
<div id="editar_actividad" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-family:Ubuntu">EDITAR ACTIVIDAD</h4>
      </div>
      <div class="modal-body">
        <div id="contenido">
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> <i class="fa fa-times-circle" aria-hidden="true"></i> CANCELAR</button>
          </div>
          <div class="col-md-4 col-sm-4"></div>
          <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-success btn-block" onclick="actualizar_actividad()"><i class="fa fa-floppy-o" aria-hidden="true"></i> ACTUALIZAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="nuevo_menu" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-family:Ubuntu">AGREGAR NUEVO MENU</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              NOMBRE <span class="text-red">*</span>
              <input type="text" class="form-control" id="nombre_menu" value="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              DESCRIPCIÓN <span class="text-red">*</span>
              <input type="text" class="form-control" id="descripcion_menu" value="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              PADRE <span class="text-red">*</span>
              <input type="text" class="form-control" id="padre_menu" value="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              ABREVIATURA
              <input type="text" class="form-control" id="abreviatura_menu" value="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <a class="btn btn-primary" onclick="$('#iconos').modal('show');tipo = 2"> SELECCIONAR ICONO <span class="text-red">*</span></a>
            <a class="btn pull-right"><i class="" id='icono_seleccionado1' nombre="" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> CANCELAR</button>
        <button type="button" class="btn btn-success" onclick="guardar_menu()"><i class="fa fa-floppy-o" aria-hidden="true"></i> ACEPTAR</button>
      </div>
    </div>
  </div>
</div>
<div id="iconos" class="modal fade" role="dialog">
  <div class="modal-dialog modal-success">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-family:Ubuntu">ICONOS</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <a class="btn btn-default" onclick="select_icon('fa fa-trash-o')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-camera-retro')"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-compass')"><i class="fa fa-compass" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-compress')"><i class="fa fa-compress" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-universal-access')"><i class="fa fa-universal-access" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-tint')"><i class="fa fa-tint" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-exclamation-triangle')"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-bus')"><i class="fa fa-bus" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-refresh')"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-cog')"><i class="fa fa-cog" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-pie-chart')"><i class="fa fa-pie-chart" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-bars')"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-map-o')"><i class="fa fa-map-o" aria-hidden="true"></i></a>
          </div>
          <div class="col-md-12" style="    margin-top: 10px;">
            <a class="btn btn-default" onclick="select_icon('fa fa-map-marker')"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-industry')"><i class="fa fa-industry" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-picture-o')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-hourglass-end')"><i class="fa fa-hourglass-end" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-plus-circle')"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-hand-o-right')"><i class="fa fa-hand-o-right" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-life-ring')"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-usd')"><i class="fa fa-usd" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-magic')"><i class="fa fa-magic" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-cc-mastercard')"><i class="fa fa-cc-mastercard" aria-hidden="true"></i></a>
          </div>
          <div class="col-md-12" style="margin-top: 10px;">
            <a class="btn btn-default" onclick="select_icon('fa fa-wrench')"><i class="fa fa-wrench" aria-hidden="true"></i></a>
            <a class="btn btn-default" onclick="select_icon('fa fa-list-alt')"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('ip'); ?>frontend/dist/css/Genesys/Waiting.min.js"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/dist/js/Genesys/permisos/actividades.js" type="text/javascript"></script>
