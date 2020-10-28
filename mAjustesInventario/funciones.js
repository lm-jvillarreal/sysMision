function GenerarPdf(folio) {
  cadena = "pdf/pdfListaPedido.php?folio=" + folio;
  window.open(cadena, "_blank");
}
function Generarliberacion(folio) {
  location.href = "editar.php?folio=" + folio;
  //window.open(cadena, '_blank');
}

function llenarRequisicion() {
  $.ajax({
    url: "tabla_requisiciones.php",
    type: "POST",
    dateType: "html",
    success: function(respuesta) {
      $("#llenar_requizicion").html(respuesta);
    },
    error: function(xhr, status) {
      alert("no se muestra");
    }
  });
}

function consulta(codigo) {
  $.ajax({
    url: "consultar.php",
    type: "POST",
    dateType: "html",
    data: { codigo: codigo },
    success: function(respuesta) {
      alertify.success(respuesta, 5);
    },
    error: function(xhr, status) {
      alert("no se muestra");
    }
  });
}

function liberarpieza(id) {
  swal({
    title: "¿Estas Seguro?",
    text: "Deseas Liberar el registro!",
    icon: "warning",
    buttons: ["No", "Si"],
    dangerMode: true
  }).then(willDelete => {
    if (willDelete) {
      $.ajax({
        url: "liberar_pieza.php",
        type: "POST",
        dateType: "html",
        data: { id: id },
        success: function(respuesta) {
          // alert(respuesta);
        },
        error: function(xhr, status) {
          alert("no se muestra");
        }
      });
      alertify.success("Se Liberado Correctamente La Requisición.", 2);
      llenarRequisicion();
    } else {
      alertify.error("Operacion Cancelada.", 2);
    }
  });
}
