$(document).ready(function () {
  $("#au_tpEntrevistado").select2();
  $("#au_aseguradora").select2();
  $("#au_ciudad_ocurrencia").select2();
  $("#auc_aseguradora").select2();
  $("#mau_tipoDoc").select2();
  $("#mau_aseguradora").select2();
  $("#mau_tipocaso").change().select2();
  $("#mau_tpEntrevistado").select2();
  $("#mau_ciudad_ocurrencia").select2();
  $("#au_tpNotificacion").select2();

  $(".deshabilitarCopiado").on("drop", function (event) {
    event.preventDefault();
    event.stopPropagation();
    Swal.fire({
      position: "top-end",
      type: "error",
      title: "¡No puede realizar esta acción! :(",
      showConfirmButton: false,
      timer: 1500,
    });
  });

  $(".deshabilitarCopiado").bind("cut copy paste", function (e) {
    e.preventDefault();
    Swal.fire({
      position: "top-end",
      type: "error",
      title: "¡No puede realizar esta acción! :(",
      showConfirmButton: false,
      timer: 1500,
    });
  });

});
$("#au_aseguradora").change(function () {
  var idAseguradora = $("#au_aseguradora option:selected").val();
  var tipoCasos = "Global";
  var selectUbicacion = "#au_tipocaso";
  var optionVacio = 1;

  $.ajax({
    type: "POST",
    url: "class/consultasBasicas.php",
    data:
      "exe=consultarAmparosAseguradora&idAseguradora=" +
      idAseguradora +
      "&tipoCasos=" +
      tipoCasos +
      "&optionVacio=" +
      optionVacio,
    beforeSend: function () {
      loadingSiglo("show", "Cargando Tipos Aseguradora...");
    },
    success: function (res) {
      if ($(selectUbicacion).hasClass("select2-hidden-accessible")) {
        $(selectUbicacion).select2("destroy");
      }
      var json_obj = $.parseJSON(res);
      var options = "";
      for (var i = 0; i < json_obj.length; i++) {
        if (json_obj[i].descripcion != "") {
          options +=
            '<option value="' +
            json_obj[i].valor +
            '">' +
            json_obj[i].descripcion +
            "</option>";
        } else {
          options +=
            '<option value="' +
            json_obj[i].valor +
            '">' +
            json_obj[i].descripcion +
            "</option>";
        }
      }
      $(selectUbicacion).html(options);
      $(selectUbicacion).select2();
      loadingSiglo("hide");
      return false;
    },
    error: function (data) {
      loadingSiglo("hide");
    },
  });
});
$("#auc_aseguradora").change(function () {
  var idAseguradora = $("#auc_aseguradora option:selected").val();
  var tipoCasos = "Global";
  var selectUbicacion = "#auc_tipocaso";
  var optionVacio = 1;

  $.ajax({
    type: "POST",
    url: "class/consultasBasicas.php",
    data:
      "exe=consultarAmparosAseguradora&idAseguradora=" +
      idAseguradora +
      "&tipoCasos=" +
      tipoCasos +
      "&optionVacio=" +
      optionVacio,
    beforeSend: function () {
      loadingSiglo("show", "Cargando Tipos Aseguradora...");
    },
    success: function (res) {
      if ($(selectUbicacion).hasClass("select2-hidden-accessible")) {
        $(selectUbicacion).select2("destroy");
      }
      var json_obj = $.parseJSON(res);
      var options = "";
      for (var i = 0; i < json_obj.length; i++) {
        if (json_obj[i].descripcion != "") {
          options +=
            '<option value="' +
            json_obj[i].valor +
            '">' +
            json_obj[i].descripcion +
            "</option>";
        } else {
          options +=
            '<option value="' +
            json_obj[i].valor +
            '">' +
            json_obj[i].descripcion +
            "</option>";
        }
      }
      $(selectUbicacion).html(options);
      $(selectUbicacion).select2();
      loadingSiglo("hide");
      return false;
    },
    error: function (data) {
      loadingSiglo("hide");
    },
  });
});
$("#mau_aseguradora").change(function () {
  var idAseguradora = $("#mau_aseguradora option:selected").val();
  var tipoCasos = "Global";
  var selectUbicacion = "#mau_tipocaso";
  var optionVacio = 1;

  $.ajax({
    type: "POST",
    url: "class/consultasBasicas.php",
    data:
      "exe=consultarAmparosAseguradora&idAseguradora=" +
      idAseguradora +
      "&tipoCasos=" +
      tipoCasos +
      "&optionVacio=" +
      optionVacio,
    beforeSend: function () {
      loadingSiglo("show", "Cargando Tipos Aseguradora...");
    },
    success: function (res) {
      if ($(selectUbicacion).hasClass("select2-hidden-accessible")) {
        $(selectUbicacion).select2("destroy");
      }
      var json_obj = $.parseJSON(res);
      var options = "";
      for (var i = 0; i < json_obj.length; i++) {
        if ($("#mau_idtipo_caso").val() == json_obj[i].valor) {
          options +=
            '<option value="' +
            json_obj[i].valor +
            '" selected>' +
            json_obj[i].descripcion +
            "</option>";
        } else {
          options +=
            '<option value="' +
            json_obj[i].valor +
            '">' +
            json_obj[i].descripcion +
            "</option>";
        }
      }
      $(selectUbicacion).html(options);
      $(selectUbicacion).select2();
      loadingSiglo("hide");
      return false;
    },
    error: function (data) {
      loadingSiglo("hide");
    },
  });
});
$("#frmNuevaAuditoria").submit(function (e) {
  e.preventDefault();

  var error = 0;

  $("#frmNuevaAuditoria input").each(function () {
    $(this)
      .parent()
      .find(".input-group-icon")
      .css("background-color", "#304f6f");
  });

  $("#frmNuevaAuditoria select").each(function () {
    $(this)
      .parent()
      .find(".input-group-icon")
      .css("background-color", "#304f6f");
  });

  if ($("#au_tpNotificacion option:selected").val() == "1") {
    $("#au_email").addClass("requerido");
    $("#au_telefono").removeClass("requerido");
  } else if ($("#au_tpNotificacion option:selected").val() == "2") {
    $("#au_telefono").addClass("requerido");
    $("#au_email").removeClass("requerido");
  }

  $("#frmNuevaAuditoria input").each(function () {
    if ($(this).hasClass("requerido")) {
      if ($(this).val() == "") {
        $(this)
          .parent()
          .find(".input-group-icon")
          .css("background-color", "#e83838");
        error++;
      }
    }
  });

  $("#frmNuevaAuditoria select").each(function () {
    if ($(this).hasClass("selectRequerido")) {
      if ($(this).val() == 0) {
        $(this)
          .parent()
          .find(".input-group-icon")
          .css("background-color", "#e83838");
        error++;
      }
    }
  });

  if (error > 0) {
    Swal.fire({
      position: "top-end",
      type: "error",
      title: "Todos los campos son requeridos",
      showConfirmButton: false,
      timer: 1500,
    });
  } else if (error == 0) {
    var frmNuevaAuditoria = new FormData($("#frmNuevaAuditoria")[0]);
    frmNuevaAuditoria.append("exe", "solicitarGuardarFirma");
    frmNuevaAuditoria.append("id_auditora", $("#btnLogout").attr("name"));
    $.ajax({
      type: "POST",
      url: "class/consultaManejoAuditorias.php",
      data: frmNuevaAuditoria,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        var data = jQuery.parseJSON(data);
        if (data.respuesta == 1) {
          loadingSiglo("show", "Enviando Correo de Firma...");

          $.ajax({
            url: "./bd/enviarCorreo.php",
            data: { id_persona: data.dato },
            type: "POST",
            dataType: "json",
            success: function (json) {
              console.log(json);
              loadingSiglo("show");
              if (json.code === "200") {
                Swal.fire({
                  position: "center",
                  type: "success",
                  title: json.mensaje,
                  showConfirmButton: true,
                });
                limpiarCampos();
              } else {
                Swal.fire({
                  position: "center",
                  type: "error",
                  title: data.respuesta,
                  showConfirmButton: true,
                });
              }
            },
          });
        } else {
          Swal.fire({
            type: "error",
            title: data.mensaje,
            showConfirmButton: true,
          });
        }
      },
    });
  }
});
$("#formConsultarAuditorias").submit(function (e) {
  e.preventDefault();

  var formConsultarAuditorias = new FormData($("#formConsultarAuditorias")[0]);
  formConsultarAuditorias.append("exe", "consultarAuditorias");
  formConsultarAuditorias.append("idUsuario", $("#btnLogout").attr("name"));
  formConsultarAuditorias.append("id_auditora", $("#auc_usuario").val());

  loadingSiglo("show", "Cargando Datos...");

  $.ajax({
    type: "POST",
    url: "class/consultaManejoAuditorias.php",
    data: formConsultarAuditorias,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      var arrayJSON = JSON.parse(data);
      $("#tb_AuditoriasRealizadas").DataTable({
        scrollX: true,
        dom: "Bfrtip",
        buttons: [
          {
            extend: "excelHtml5",
            exportOptions: {
              columns: ":visible",
            },
            title: "Auditorias",
          },
          {
            extend: "colvis",
          },
        ],
        select: true,
        destroy: true,
        data: arrayJSON.aaData,
        bPaginate: true,
        bFilter: true,
        bProcessing: true,
        pageLength: 5,
        columns: [
          { title: "BTN", mData: "btn" },
          { title: "Identificacion", mData: "identificacion" },
          { title: "Nombres", mData: "nombre" },
          { title: "Apellidos", mData: "apellido" },
          { title: "Placa", mData: "placa" },
          { title: "Poliza", mData: "poliza" },
          { title: "Contacto", mData: "contacto" },
          { title: "Estado", mData: "estado" },
          { title: "Aseguradora", mData: "aseguradora" },
          { title: "Tipo Caso", mData: "tipo_caso" },
          { title: "Fecha Creacion", mData: "fecha_creacion" },
        ],
        fnCreatedRow: function (rowEl, data) {
          $(rowEl).attr(
            "id",
            "trAuditorias" + data.id_auditoria + "_" + data.id_persona
          );
        },
        columnDefs: [
          {
            targets: [0, 7, 10],
            className: "omitir",
          },
        ],
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo:
            "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty:
            "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior",
          },
          oAria: {
            sSortAscending:
              ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
              ": Activar para ordenar la columna de manera descendente",
          },
        },
      });
      loadingSiglo("hide");
      return false;
    },
  });
  return false;
});
function mostrarAuditoria(id_auditoria, id_persona) {
  $.post(
    "class/consultaManejoAuditorias.php",
    {
      auditoria: id_auditoria,
      persona: id_persona,
      exe: "consultarEditarAuditoria",
    },
    function (datos) {
      $("#mau_id_auditoria").val(datos.id_auditoria);
      $("#mau_id_persona").val(datos.id_persona);
      $("#mau_tipoDoc").val(datos.tipo_id).change();
      $("#mau_identificacion").val(datos.identificacion);
      $("#mau_nombre").val(datos.nombres);
      $("#mau_apellidos").val(datos.apellidos);
      $("#mau_email").val(datos.correo);
      $("#mau_telefono").val(datos.telefono);
      $("#mau_placa").val(datos.placa);
      $("#mau_poliza").val(datos.poliza);
      $("#mau_aseguradora").val(datos.aseguradora).change();
      $("#mau_idtipo_caso").val(datos.tipo_caso);
      $("#mau_fAccidente").val(datos.fecha_accidente);
      $("#mau_tpEntrevistado").val(datos.tipo_entrevistado).change();
      $("#mau_lesionado").val(datos.nombre_lesionado);
      $("#mau_condicion").val(datos.condicion);
      $("#mau_ciudad_ocurrencia").val(datos.ciudad_ocurrencia).change();
      $("#modalMostrarAuditoria").modal("show");
    },
    "json"
  );
}
function editarModalAuditoria() {
  var error = 0;
  $("#modalMostrarAuditoria input").each(function () {
    if ($(this).hasClass("requerido")) {
      if ($(this).val().length == 0) {
        $(this).parent().find(".error").css("color", "red");
        error++;
      }
    }
  });
  $("#modalMostrarAuditoria select").each(function () {
    if ($(this).hasClass("selectRequerido")) {
      if ($(this).val() == 0) {
        $(this).parent().find(".error").css("color", "red");
        error++;
      }
    }
  });
  if (error > 0) {
    Swal.fire({
      position: "top-end",
      type: "error",
      title: "Debe llenar todos los campos",
      showConfirmButton: false,
      timer: 1500,
    });
  }
  if (error == 0) {
    var id_auditoria = $("#mau_id_auditoria").val();
    var id_persona = $("#mau_id_persona").val();
    var tipo_doc = $("#mau_tipoDoc").val();
    var ident = $("#mau_identificacion").val();
    var nombres = $("#mau_nombre").val();
    var apellidos = $("#mau_apellidos").val();
    var correo = $("#mau_email").val();
    var tel = $("#mau_telefono").val();
    var placa = $("#mau_placa").val();
    var poliza = $("#mau_poliza").val();
    var id_aseguradora = $("#mau_aseguradora").val();
    var tipo_caso = $("#mau_tipocaso").val();
    var fAccidente = $("#mau_fAccidente").val();
    var tp_entrevistado = $("#mau_tpEntrevistado").val();
    var nombre_lesionado = $("#mau_lesionado").val();
    var condicion = $("#mau_condicion").val();
    var ciudad_ocurrencia = $("#mau_ciudad_ocurrencia").val();

    var data = {
      1: ident,
      2: nombres,
      3: apellidos,
      4: placa,
      5: poliza,
      6: correo,
      8: $("#mau_aseguradora option:selected").text().trim(),
      9: $("#mau_tipocaso option:selected").text().trim(),
    };

    $.post(
      "class/consultaManejoAuditorias.php",
      {
        id_auditoria: id_auditoria,
        id_persona: id_persona,
        tipo_id: tipo_doc,
        ident: ident,
        nombres: nombres,
        apellidos: apellidos,
        correo: correo,
        tel: tel,
        placa: placa,
        poliza: poliza,
        aseguradora: id_aseguradora,
        tipo_caso: tipo_caso,
        fAccidente: fAccidente,
        tp_entrevistado: tp_entrevistado,
        nombre_lesionado: nombre_lesionado,
        condicion: condicion,
        ciudad_ocurrencia: ciudad_ocurrencia,
        idUsuario: $("#btnLogout").attr("name"),
        exe: "consultarEditarModalAu",
      },
      function (datos) {
        if (datos == 1) {
          $("#trAuditorias" + id_auditoria + "_" + id_persona)
            .find("td")
            .each(function (q) {
              if (!$(this).hasClass("omitir")) {
                $(this).text(data[q]);
              }
            });

          $("#modalMostrarAuditoria").modal("hide");

          $("#tb_AuditoriasRealizadas").DataTable({
            scrollX: true,
            dom: "Bfrtip",
            buttons: [
              {
                extend: "excelHtml5",
                exportOptions: {
                  columns: ":visible",
                },
                title: "Auditorias",
              },
              {
                extend: "colvis",
              },
            ],
            select: true,
            destroy: true,
            bPaginate: true,
            bFilter: true,
            bProcessing: true,
            pageLength: 5,
            language: {
              sProcessing: "Procesando...",
              sLengthMenu: "Mostrar _MENU_ registros",
              sZeroRecords: "No se encontraron resultados",
              sEmptyTable: "Ningún dato disponible en esta tabla",
              sInfo:
                "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              sInfoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
              sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
              sInfoPostFix: "",
              sSearch: "Buscar:",
              sUrl: "",
              sInfoThousands: ",",
              sLoadingRecords: "Cargando...",
              oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
              },
              oAria: {
                sSortAscending:
                  ": Activar para ordenar la columna de manera ascendente",
                sSortDescending:
                  ": Activar para ordenar la columna de manera descendente",
              },
            },
          });
          $("#tb_AuditoriasRealizadas").on("shown.bs.tab", function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

            $("html, body").animate({ scrollTop: 200 }, "slow");
          });
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Auditoria editada correctamente",
            showConfirmButton: false,
            timer: 1500,
          });
          $("#verMisAuditorias").click();
          limpiarCamposModal();
        } else {
          Swal.fire({
            position: "top-end",
            type: "error",
            title: "Error al editar auditoria",
            showConfirmButton: false,
            timer: 1500,
          });
        }
      },
      "json"
    );
  }
}
function verificarEstadoFirma(id_auditoria, id_persona) {
  loadingSiglo("show", "Consultando estado de la firma...");
  var html = "";
  code = "400";
  $.ajax({
    type: "POST",
    url: "../bd/verificarFirmado.php",
    data: { id_persona: id_persona },
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.code == "200") {
        if (data.estado == 0) {
          html = '<span class="label label-success">CREADA</span>';
        } else if (data.estado == 1) {
          html = '<span class="label label-success">CORREO ENVIADO</span>';
        } else if (data.estado == 2) {
          html = '<span class="label label-success">FIRMADA</span>';
        }

        var id_auditoria = $("#mau_id_auditoria").val();
        var id_persona = $("#mau_id_persona").val();

        $.post(
          "class/consultaManejoAuditorias.php",
          {
            id_auditoria: id_auditoria,
            id_persona: id_persona,
            html: html,
            exe: "consultarEditarModalAu",
          },
          function (datos) {
            alert(data.mensaje);
            $("#tb_AuditoriasRealizadas").DataTable({
              scrollX: true,
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "excelHtml5",
                  exportOptions: {
                    columns: ":visible",
                  },
                  title: "Auditorias",
                },
                {
                  extend: "colvis",
                },
              ],
              select: true,
              destroy: true,
              bPaginate: true,
              bFilter: true,
              bProcessing: true,
              pageLength: 5,
              language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo:
                  "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                sInfoEmpty:
                  "Mostrando registros del 0 al 0 de un total de 0 registros",
                sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                sInfoPostFix: "",
                sSearch: "Buscar:",
                sUrl: "",
                sInfoThousands: ",",
                sLoadingRecords: "Cargando...",
                oPaginate: {
                  sFirst: "Primero",
                  sLast: "Último",
                  sNext: "Siguiente",
                  sPrevious: "Anterior",
                },
                oAria: {
                  sSortAscending:
                    ": Activar para ordenar la columna de manera ascendente",
                  sSortDescending:
                    ": Activar para ordenar la columna de manera descendente",
                },
              },
            });
            $("#tb_AuditoriasRealizadas").on("shown.bs.tab", function (e) {
              $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

              $("html, body").animate({ scrollTop: 200 }, "slow");
            });
          }
        );
      } else {
        alert(data.code + ": " + data.mensaje);
      }
    },
  });
}
$("#au_limpiar").click(function () {
  limpiarCampos();
});
function limpiarCampos() {
  $("#frmNuevaAuditoria input").each(function () {
    $(this)
      .parent()
      .find(".input-group-icon")
      .css("background-color", "#304f6f");
  });

  $("#frmNuevaAuditoria select").each(function () {
    $(this)
      .parent()
      .find(".input-group-icon")
      .css("background-color", "#304f6f");
  });
  $("#au_aseguradora").val(0).change();
  $("#au_tipocaso").val();
  $("#au_placa").val("");
  $("#au_poliza").val("");
  $("#au_fAccidente").val("");
  $("#au_tipoDoc").val(0).change();
  $("#au_identificacion").val("");
  $("#au_nombre").val("");
  $("#au_apellidos").val("");
  $("#au_tpEntrevistado").val(0).change();
  $("#au_email").val("");
  $("#au_telefono").val("");
  $("#au_lesionado").val("");
  $("#au_condicion").val("");
  $("#au_ciudad_ocurrencia").val(0).change();
  $("#au_tpNotificacion").val(0).change();
  $("#au_identificacion").focus();
}
