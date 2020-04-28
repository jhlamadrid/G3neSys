<script type="text/javascript">
  var servidor = "<?php echo $this->config->item('ip'); ?>";
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-bordear">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-sx-4">
              <a type="button" onclick='abrir_modal()' class="btn btn-success btn-block">
                <i class="fa fa-plus" aria-hidden="true"></i> NUEVO ROL
              </a>
            </div>
            <div class="col-md-4 col-sm-4 col-sx-4"></div>
            <div class="col-md-4 col-sm-4 col-sx-4"></div>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id='roles' class="table table-bordered table-striped">
                  <thead>
                    <tr role='row'>
                      <th>CÓDIGO</th>
                      <th>NOMBRE</th>
                      <th>FECHA CREACIÓN</th>
                      <th>OPCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($roles as $rol) { ?>
                      <tr>
                        <td><?php echo $rol['ID_ROL'] ?></td>
                        <td><?php echo $rol['ROLDESC'] ?></td>
                        <td><?php echo $rol['ROLFECH'] ?></td>
                        <td style="text-align:center">
                          <a class="btn btn-default" onclick="ver_detalle('<?php echo $rol['ID_ROL'] ?>')" data-toggle="tooltip" data-placement="bottom" title="VER DETALLE" ><i class="fa fa-eye"></i></a>
                          <a class="btn btn-default" onclick="editar_actividades('<?php echo $rol['ID_ROL'] ?>')" data-toggle="tooltip" data-placement="bottom" title="EDITAR ROL" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        </td>
                      </tr>
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
<div class="modal inmodal fade" id="detalle_rol" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" style="font-family:'Ubuntu'">DETALLE <span id="nombre_rol"></span></h4>
      </div>
      <div class="modal-body">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>
<!--  MODAL CREACR NUEVO -->
<div class="modal inmodal fade" id="nuevo_rol" data-keyboard="false" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only" onclick="limpiar_array1()">Cerrar</span></button>
        <h4 class="modal-title" style="font-family:'Ubuntu'">NUEVO ROL </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 cols-sm-6">
            <div class="input-group">
              <span class="input-group-addon" style="background:#dd4b39;color:#FFF">NOMBRE :</span>
              <input type="text" class="form-control" style="text-transform:uppercase" id="nombre_rol_nuevo" value="">
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="input-group">
              <span class="input-group-addon" style="background:#dd4b39;color:#FFF">MENU :</span>
              <select class="form-control" id="menus1" onchange="obtener_actividades1()" disabled="disabled">
              </select>
            </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="table-container">
                  <ul class="list-group" id='lista_actividades2'>
                  </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-sx-4">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id='btn_cerrar_nuevo'><i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CERRAR</button>
          </div>
          <div class="col-md-4 col-sm-4 col-sx-4"></div>
          <div class="col-md-4 col-sm-4 col-sx-4">
              <button type="button" class="btn btn-success btn-block" id='btn_save1' disabled="disabled"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; GUARDAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL EDITAR -->
<div class="modal inmodal fade" id="editar_rol" tabindex="-1" role="dialog" data-keyboard="false"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" style="font-family:'Ubuntu'">EDITAR <span id="nombre_rol1"></span></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 cols-sm-6"> </div>
          <div class="col-md-6 col-sm-6">
            <div class="input-group">
              <span class="input-group-addon">MENU :</span>
              <select class="form-control" id="menus" onchange="obtener_actividades()">
              </select>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="table-container">
                  <ul class="list-group" id='lista_actividades'>
                  </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-4">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" onclick="limpiar_array()"><i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp; CANCELAR</button>
          </div>
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <button type="button" class="btn btn-success btn-block" id='btn_save' disabled="disabled"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; GUARDAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip') ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
  $('#roles').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});
  var actividades =  new Array();
  var actividades_agregadas =  new Array();
  var actividades_quitadas =  new Array();
  var actividades_nueva = new Array();
  function abrir_modal(){
    $.ajax({
      type : 'POST',
      url : servidor+'permisos/administrar_roles/menus1?ajax=true',
      data : ({
      }),
      cache :false,
      dataType : 'json',
      success : function(data){
        if(data.result){
          $("#nuevo_rol").modal('show')
          $("#menus1").empty()
          $("#menus1").append(data.menus)
        } else {
          swal("",data.mensaje,"warning")
        }
      }, error :  function(jqXHR,textStatus,errorThrown){
        swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
      }
    })
  }

  function ver_detalle(id){
    $.ajax({
      type : 'POST',
      url : servidor+'permisos/administrar_roles/detalle_rol?ajax=true',
      data : ({
        rol : id
      }),
      cache :false,
      dataType : 'json',
      success : function(data){
        if(data.result){
          $("#accordion").empty();
          $("#accordion").append(data.detalle);
          $("#nombre_rol").html(data.rol['ROLDESC'].toUpperCase())
          $("#detalle_rol").modal('show')
        } else {
          swal("",data.mensaje,"warning")
        }
      }, error :  function(jqXHR,textStatus,errorThrown){
        swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
      }
    })
  }

  function editar_actividades(id){
    $.ajax({
      type : 'POST',
      url : servidor+'permisos/administrar_roles/menus?ajax=true',
      data : ({
        rol : id
      }),
      cache :false,
      dataType : 'json',
      success : function(data){
        if(data.result){
          $("#editar_rol").modal('show')
          $("#menus").empty()
          $("#menus").append(data.menus)
          $("#nombre_rol1").html(data.rol['ROLDESC'].toUpperCase())
        } else {
          swal("",data.mensaje,"warning")
        }
      }, error :  function(jqXHR,textStatus,errorThrown){
        swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
      }
    })
  }

  function obtener_actividades(){
    var val = $("#menus").val();
    var val1 = $("#nombre_rol1").html();
    $.ajax({
      type : 'POST',
      url : servidor+'permisos/administrar_roles/actividades?ajax=true',
      data : ({
        menu : val,
        rol : val1,
        actividades : actividades_agregadas,
        actividades1 : actividades_quitadas
       }),
      cache :false,
      dataType : 'json',
      success : function(data){
        if(data.result){
          agregar_actividades(data.act);
          console.log(actividades)
          $("#lista_actividades").empty();
          $("#lista_actividades").append(data.actividades);
        } else {
          swal("",data.mensaje,"warning")
        }
      }, error :  function(jqXHR,textStatus,errorThrown){
        swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
      }
    })
  }

  function agregar(id){
    actividades_agregadas.push(id)
    var indice = actividades_quitadas.indexOf(id);
    if(indice >= 0){
      var indice1 = actividades_agregadas.indexOf(id);
      actividades_quitadas.splice(indice,1)
      actividades_agregadas.splice(indice1,1)
    }
    console.log(actividades_quitadas,actividades_agregadas)
    $("#lista_"+id).addClass('seleccionado')
    $("#icono_"+id).removeClass('fa fa-plus').addClass('fa fa-minus')
    $("#btn_"+id).attr('onclick','quitar('+id+')')
    $("#sin_asignar_"+id).html("ASIGNADO");
    $("#sin_asignar_"+id).removeClass("text-red").addClass('text-green');
    $("#sin_asignar_"+id).attr('id','asignar_'+id)
    validar_btn();
  }

  function quitar(id){
    actividades_quitadas.push(id)
    var indice = actividades_agregadas.indexOf(id);
    if(indice >= 0) {
      var indice1 = actividades_quitadas.indexOf(id);
       actividades_agregadas.splice(indice,1)
      actividades_quitadas.splice(indice1,1)
    }
    $("#lista_"+id).removeClass('seleccionado')
    $("#icono_"+id).removeClass('fa fa-minus').addClass('fa fa-plus')
    $("#btn_"+id).attr('onclick','agregar('+id+')')
    $("#asignar_"+id).html("SIN ASIGNAR");
    $("#asignar_"+id).removeClass("text-green").addClass('text-red');
    $("#asignar_"+id).attr('id','sin_asignar_'+id)
    validar_btn();
  }

  function validar_btn(){
    if ( actividades_agregadas.length > 0 || actividades_quitadas.length > 0){
      $("#btn_save").attr('disabled',false)
    } else {
      $("#btn_save").attr('disabled',true)
    }
  }

  function agregar_actividades(val){
    var tam =  val.length ;
    for(i = 0; i < tam; i++){
      let index = actividades.indexOf(val[i])
      if(index < 0){
        actividades.push(val[i]);
      }
    }
  }

  function limpiar_array(){
    actividades_quitadas.length = 0;
    actividades_agregadas.length = 0;
    $("#lista_actividades").empty();
  }

  function obtener_actividades1(){
    var val = $("#menus1").val();
    $.ajax({
      type : 'POST',
      url : servidor+'permisos/administrar_roles/actividades1?ajax=true',
      data : ({
        menu : val,
        actividades : actividades_nueva
       }),
      cache :false,
      dataType : 'json',
      success : function(data){
        if(data.result){
          $("#lista_actividades2").empty();
          $("#lista_actividades2").append(data.actividades);
        } else {
          swal("",data.mensaje,"warning")
        }
      }, error :  function(jqXHR,textStatus,errorThrown){
        swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
      }
    })
  }

  function agregar_actividad(id){
    actividades_nueva.push(id)
    $("#lista1_"+id).addClass("seleccionado");
    $("#asignar1_"+id).html("ASIGNADO")
    $("#asignar1_"+id).removeClass("text-red").addClass("text-green")
    $("#icono1_"+id).removeClass("fa fa-plus").addClass("fa fa-minus")
    $("#btn1_"+id).attr("onclick","desagregar_actividad("+id+")")
    if (actividades_nueva.length > 0) $("#btn_save1").attr("disabled",false)
  }

  function desagregar_actividad(id){
    var indice =  actividades_nueva.indexOf(id);
    actividades_nueva.splice(indice,1)
    $("#lista1_"+id).removeClass("seleccionado");
    $("#asignar1_"+id).html("SIN ASIGNAR")
    $("#asignar1_"+id).removeClass("text-green").addClass("text-red")
    $("#icono1_"+id).removeClass("fa fa-minus").addClass("fa fa-plus")
    $("#btn1_"+id).attr("onclick","agregar_actividad("+id+")")
    if (actividades_nueva.length == 0) $("#btn_save1").attr("disabled",true)
  }

  $( "#nombre_rol_nuevo" ).keyup(function(event) {
      if($("#nombre_rol_nuevo").val().trim() != ""){
        $("#menus1").attr('disabled',false)
      } else {
        $("#menus1").attr('disabled',true)
        $("#lista_actividades2").empty();
        var select = $('#menus1');
        select.val($('option:first', select).val());
      }
  });

  function limpiar_array1(){
    actividades_nueva.length = 0;
  }

  $("#btn_cerrar_nuevo").click(function(){
    limpiar_array1();
    $("#lista_actividades2").empty();
    $("#menus1").attr('disabled',true);
    $("#nombre_rol_nuevo").val("");
  });

  $("#btn_save1").click(function(){
    if(actividades_nueva.length > 0){
      $.ajax({
        type : 'POST',
        url : servidor+'permisos/administrar_roles/get_actividades?ajax=true',
        data : ({
          actividades : actividades_nueva,
          rol : $("#nombre_rol_nuevo").val()
         }),
        cache :false,
        dataType : 'json',
        success : function(data){
          if(data.result){
            swal({
              title: "<span style='fontt:family:\"Ubuntu\"'>¿Quiere agregar estas actividades al rol "+$("#nombre_rol_nuevo").val()+"?</span>",
              text: "<ol style='margin-left: 20%;'>"+data.actividades+"</ol>",
              type: "warning",
              html: true,
              showCancelButton: true,
              closeOnConfirm: false,
              confirmButtonText: "SÍ!",
              showLoaderOnConfirm: true,
              confirmButtonColor: "#296fb7"
              }, function() {
                $.ajax({
                  type : 'POST',
                  url : servidor+'permisos/administrar_roles/guardar_rol?ajax=true',
                  data : ({
                    rol : $("#nombre_rol_nuevo").val(),
                    actividades : actividades_nueva
                   }),
                  cache :false,
                  dataType : 'json',
                  success : function(data){
                    if(data.result){
                      swal("",data.mensaje,"success")
                      setTimeout(function(){
                        window.location.assign(servidor+"permisos/administrar_roles");
                      },1000)
                    } else {
                      swal("",data.mensaje,"warning")
                    }
                  }, error :  function(jqXHR,textStatus,errorThrown){
                    swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
                  }
                })
              }
            )
          } else {
            swal("",data.mensaje,"warning")
          }
        }, error :  function(jqXHR,textStatus,errorThrown){
          swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
        }
      })
    }

  })

  $("#btn_save").click(function(){
    console.log(actividades_quitadas);
    $.ajax({
      type : 'POST',
      url : servidor+'permisos/administrar_roles/get_actividades1?ajax=true',
      data : ({
        actividades : actividades_agregadas,
        actividades1 : actividades_quitadas,
        rol : $("#nombre_rol1").html()
       }),
      cache :false,
      dataType : 'json',
      success : function(data){
          if(data.result){
            swal({
              title: "<span style='fontt:family:\"Ubuntu\"'>¿Deseas actualizar el rol "+$("#nombre_rol1").html()+"?</span>",
              text: data.actividades,
              type: "warning",
              html: true,
              showCancelButton: true,
              closeOnConfirm: false,
              confirmButtonText: "SÍ!",
              showLoaderOnConfirm: true,
              confirmButtonColor: "#296fb7"
              }, function() {
                $.ajax({
                  type : 'POST',
                  url : servidor+'permisos/administrar_roles/update_roles?ajax=true',
                  data : ({
                    rol : $("#nombre_rol1").html(),
                    actividades : actividades_agregadas,
                    actividades1 :  actividades_quitadas
                   }),
                  cache :false,
                  dataType : 'json',
                  success : function(data){
                    if(data.result){
                      swal("",data.mensaje,"success")
                      setTimeout(function(){
                        window.location.assign(servidor+"permisos/administrar_roles");
                      },1000)
                    } else {
                      swal("",data.mensaje,"warning")
                    }
                  }, error :  function(jqXHR,textStatus,errorThrown){
                    swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
                  }
                })
              }
            )
          } else {
            swal("",data.mensaje,"warning")
          }
      }, error :  function(jqXHR,textStatus,errorThrown){
        swal("","OCURRIÓ UN PROBLEMA EN EL SERVIDOR","error")
      }
    })
  })

</script>

<style media="screen">
  .seleccionado {background:#eee;}
</style>
