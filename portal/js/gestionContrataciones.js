$(document).ready(function () {

    $('#ct_id').mask('#.###.###.###.###', { reverse: true });
    $('#ctSalario').mask('#.##0,00', { reverse: true });
})

$("#frmNuevaContratacion").submit(function (e) {
    e.preventDefault();
    /*var error= 0
    $("#mdAñadirContratacion input").each(function () {
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

    $("#mdAñadirContratacion select").each(function () {
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
      }*/
    var frmNuevaContratacion = new FormData($("#frmNuevaContratacion")[0]);
    frmNuevaContratacion.append("exe", "añadirContratacion");
    //frmAñadirContratacion.append("id_auditora", $("#btnLogout").attr("name"));
    $.ajax({
        type: "POST",
        url: "class/consultaManejoContrataciones.php",
        data: frmNuevaContratacion,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            //var data = jQuery.parseJSON(data);
            if (data == 1) {
                //loadingSiglo("show", "Enviando Correo de Firma...");
                Swal.fire({
                    type: "success",
                    title: "Contratacion agregada exitosamente",
                    showConfirmButton: true,
                });

            } else {
                Swal.fire({
                    type: "error",
                    title: "ha ocurrido un error",
                    showConfirmButton: true,
                });
            }
        },
    });


});