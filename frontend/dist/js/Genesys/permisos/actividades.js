var tipo = 0;
$("#listar_actividades").DataTable({
  bFilter: true,
  bInfo: false,
  ordering: false,
  lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Todos"]]
});

function abrir_modal() {
  $("#newActividad").modal("show");
  $("#padres").attr("disabled", false);
}

function select_icon(text) {
  if (tipo == 1) {
    $("#icono_seleccionado").attr("class", text);
    $("#icono_seleccionado").attr("name", text);
  } else if (tipo == 2) {
    $("#icono_seleccionado1").attr("class", text);
    $("#icono_seleccionado1").attr("nombre", text);
  } else if (tipo == 3) {
    $("#icono_seleccionado2").attr("class", text);
    $("#icono_seleccionado2").attr("nombre", text);
  }
  $("#iconos").modal("hide");
}
function agregar_nuevo_menu() {
  $("#nuevo_menu").modal("show");
}
function guardar_menu() {
  if (
    $("#nombre_menu").val() != "" &&
    $("#descripcion_menu").val() != "" &&
    $("#padre_menu").val() != "" &&
    $("#icono_seleccionado1").attr("nombre") != ""
  ) {
    $("#nombre_padre").val($("#nombre_menu").val());
    $("#padres").attr("disabled", true);
    $("#nuevo_menu").modal("hide");
  } else {
    if ($("#nombre_menu").val() == "") {
      swal("", "DEBE RELLENAR UN NOMBRE", "warning");
    } else if ($("#descripcion_menu").val() == "") {
      swal("", "DEBE RELLENAR UNA DESCRIPCIÓN", "warning");
    } else if ($("#padre_menu").val() == "") {
      swal("", "DEBE RELLENAR UN PADRE", "warning");
    } else if ($("#icono_seleccionado1").attr("nombre") == "") {
      swal("", "DEBE SELECCIONAR UN ICONO", "warning");
    }
  }
}
function guardar_actividad() {
  if ($("#nombre_padre").val()) {
    waitingDialog.show("Cargando Información...", {
      dialogSize: "sm",
      progressType: "warning"
    });
    if (
      $("#nombre")
        .val()
        .trim() != "" &&
      $("#descripcion")
        .val()
        .trim() != "" &&
      $("#hijo")
        .val()
        .trim() != "" &&
      $("#ruta")
        .val()
        .trim() != "" &&
      $("#icono_seleccionado").attr("name") != ""
    ) {
      var menu = {
        nombre: $("#nombre_menu").val(),
        abreviatura: $("#abreviatura_menu").val(),
        padre: $("#padre_menu").val(),
        descripcion: $("#descripcion_menu").val(),
        icono: $("#icono_seleccionado1").attr("nombre")
      };
      var actividad = {
        nombre: $("#nombre").val(),
        descripcion: $("#descripcion").val(),
        abreviatura: $("#abreviatura").val(),
        hijo: $("#hijo").val(),
        ruta: $("#ruta").val(),
        icono: $("#icono_seleccionado").attr("name")
      };
      $.ajax({
        type: "POST",
        url:
          servidor +
          "permisos/administrar_actividades/nueva_actividad?ajax=true",
        data: {
          menu: menu,
          actividad: actividad,
          tipo: "1"
        },
        dataType: "text",
        cache: false,
        success: function(data) {
          console.log(data);
          var resultado = JSON.parse(data);
          if (resultado.result == true) {
            waitingDialog.hide();
            swal("¡ÉXITO!", "La Actividad se ha creado con éxito");
            //window.location.assign('permisos/administrar_actividades');
            Window.location.reload();
          } else {
            waitingDialog.hide();
            swal("", resultado.mensaje, "warning");
          }
        },
        error: function(error, textSucess, errorThrown) {
          waitingDialog.hide();
          if (jqXHR.status === 0)
            swal(
              "",
              "ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.",
              "error"
            );
          else if (jqXHR.status == 404)
            swal(
              "",
              "ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.",
              "error"
            );
          else if (jqXHR.status == 500)
            swal(
              "",
              "ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.",
              "error"
            );
          else if (textStatus === "parsererror")
            swal("", "ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR", "error");
          else if (textStatus === "timeout")
            swal("", "ERROR DE TIEMPO DE ESPERA.", "error");
          else if (textStatus === "abort")
            swal("", "SOLICITUD CANCELADA.", "error");
          else swal("", "ERROR NO DETECTADO: \n" + jqXHR.responseText, "error");
        }
      });
    } else {
      if (
        $("#nombre")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UN NOMBRE PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#descripcion")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UNA DESCRIPCIÓN PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#hijo")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UN HIJO PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#ruta")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UNA RUTA PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#icono_seleccionado")
          .attr("name")
          .trim() == ""
      ) {
        swal("", "DEBE SELECCIONAR UN ICONO", "warning");
      }
    }
  } else {
    if (
      $("#padres").val() != -1 &&
      $("#nombre")
        .val()
        .trim() != "" &&
      $("#descripcion")
        .val()
        .trim() != "" &&
      $("#hijo")
        .val()
        .trim() != "" &&
      $("#ruta")
        .val()
        .trim() != "" &&
      $("#icono_seleccionado").attr("name") != ""
    ) {
      var actividad = {
        nombre: $("#nombre").val(),
        descripcion: $("#descripcion").val(),
        abreviatura: $("#abreviatura").val(),
        hijo: $("#hijo").val(),
        ruta: $("#ruta").val(),
        icono: $("#icono_seleccionado").attr("name"),
        padre: $("#padres").val()
      };
      $.ajax({
        type: "POST",
        url:
          servidor +
          "permisos/administrar_actividades/nueva_actividad?ajax=true",
        data: {
          actividad: actividad,
          tipo: "2"
        },
        dataType: "text",
        cache: false,
        success: function(data) {
          console.log(data);
          var resultado = JSON.parse(data);
          if (resultado.result == true) {
            waitingDialog.hide();
            swal("¡ÉXITO!", "La Actividad se ha creado con éxito");
            window.location.assign(
              servidor + "permisos/administrar_actividades"
            );
          } else {
            waitingDialog.hide();
            swal("", resultado.mensaje, "warning");
          }
        },
        error: function(error, textSucess, errorThrown) {
          waitingDialog.hide();
          if (jqXHR.status === 0)
            swal(
              "",
              "ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.",
              "error"
            );
          else if (jqXHR.status == 404)
            swal(
              "",
              "ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.",
              "error"
            );
          else if (jqXHR.status == 500)
            swal(
              "",
              "ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.",
              "error"
            );
          else if (textStatus === "parsererror")
            swal("", "ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR", "error");
          else if (textStatus === "timeout")
            swal("", "ERROR DE TIEMPO DE ESPERA.", "error");
          else if (textStatus === "abort")
            swal("", "SOLICITUD CANCELADA.", "error");
          else swal("", "ERROR NO DETECTADO: \n" + jqXHR.responseText, "error");
        }
      });
    } else {
      if (
        $("#nombre")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UN NOMBRE PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#descripcion")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UNA DESCRIPCIÓN PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#hijo")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UN HIJO PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#ruta")
          .val()
          .trim() == ""
      ) {
        swal("", "DEBE RELLENAR UNA RUTA PARA LA ACTIVIDAD", "warning");
      } else if (
        $("#icono_seleccionado")
          .attr("name")
          .trim() == ""
      ) {
        swal("", "DEBE SELECCIONAR UN ICONO", "warning");
      } else if ($("#padres").val() == -1) {
        swal(
          "",
          "DEBE SELECCIONAR UN PADRE PARA LA ACTIVIDAD O CREAR UNO",
          "warning"
        );
      }
    }
  }
}
function editar_actividad(id) {
  $.ajax({
    type: "POST",
    url:
      servidor + "permisos/administrar_actividades/editar_actividad?ajax=true",
    data: {
      id: id
    },
    dataType: "json",
    cache: false,
    success: function(data) {
      if (data.result == true) {
        $("#contenido").empty();
        $("#contenido").append(data.actividad);
        $("#editar_actividad").modal("show");
      } else {
        swal("", data.mensaje, "warning");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      if (jqXHR.status === 0)
        swal(
          "",
          "ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.",
          "error"
        );
      else if (jqXHR.status == 404)
        swal(
          "",
          "ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.",
          "error"
        );
      else if (jqXHR.status == 500)
        swal(
          "",
          "ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.",
          "error"
        );
      else if (textStatus === "parsererror")
        swal("", "ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR", "error");
      else if (textStatus === "timeout")
        swal("", "ERROR DE TIEMPO DE ESPERA.", "error");
      else if (textStatus === "abort")
        swal("", "SOLICITUD CANCELADA.", "error");
      else swal("", "ERROR NO DETECTADO: \n" + jqXHR.responseText, "error");
    }
  });
}

function actualizar_actividad() {
  var nombre = $("#edit_nombre").val();
  var descripcion = $("#edit_descripcion").val();
  var abreviatura = $("#edit_abreviatura").val();
  var icono = $("#icono_seleccionado2").attr("nombre");
  var id_actividad = $("#edit_id_actividad").html();
  if (nombre.trim() != "" && descripcion != "" && abreviatura != "") {
    $.ajax({
      type: "POST",
      url:
        servidor +
        "permisos/administrar_actividades/actualizar_actividad?ajax=true",
      data: {
        id: id_actividad,
        nombre: nombre,
        abreviatura: abreviatura,
        icono: icono,
        descripcion: descripcion
      },
      dataType: "json",
      cache: false,
      success: function(data) {
        if (data.result == true) {
          swal("", data.mensaje, "success");
          setTimeout(function() {
            window.location.assign(
              servidor + "permisos/administrar_actividades"
            );
          }, 1000);
        } else {
          swal("", data.mensaje, "warning");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0)
          swal(
            "",
            "ERROR:\n NO SE PUEDE CONECTAR CON EL SERVICIO.\nVERIFIQUE SU CONEXIÓN A INTERNET.",
            "error"
          );
        else if (jqXHR.status == 404)
          swal(
            "",
            "ERROR: 404 \n EL RECURSOS SOLICITADO NO SE PUEDE ENCONTRAR, PERO PUEDE ESTAR DISPONIBLE EN EL FUTURO.",
            "error"
          );
        else if (jqXHR.status == 500)
          swal(
            "",
            "ERROR: 500 \n ERROR INTERNO DEL SERVIDOR, EL SERVIDOR ENCONTRÓ UNA CONDICIÓN INESPERADA QUE LE IMPIDIÓ CUMPLIR CON LA SOLICITUD.",
            "error"
          );
        else if (textStatus === "parsererror")
          swal("", "ERROR AL ANALIZAR LA RESPUESTA DEL SERVIDOR", "error");
        else if (textStatus === "timeout")
          swal("", "ERROR DE TIEMPO DE ESPERA.", "error");
        else if (textStatus === "abort")
          swal("", "SOLICITUD CANCELADA.", "error");
        else swal("", "ERROR NO DETECTADO: \n" + jqXHR.responseText, "error");
      }
    });
  } else {
    if (nombre.trim() == "") {
      swal("", "DEBE RELLENAR UN NOMBRE A LA ACTIVIDAD", "warning");
    } else if (descripcion.trim() == "") {
      swal("", "DEBE RELLENAR UNA DESCRIPCION A LA ACTIVIDAD", "warning");
    } else if (abreviatura.trim() == "") {
      swal("", "DEBE RELLENAR UNA ABREVIATURA A LA ACTIVIDAD", "warning");
    }
  }
  /**/
}
