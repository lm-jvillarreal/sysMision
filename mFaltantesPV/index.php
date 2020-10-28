<?php
include '../global_seguridad/verificar_sesion.php';
if ($dia_semana != "Sunday" and $dia_semana != "Monday") {
  echo "<script language=\"javascript\">window.location=\"../mPanel_control/index.php\"</script>";
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <?php include 'menuV.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger" id="div-articulos">
          <div class="box-header">
            <h3 class="box-title">Piso de Venta | Registro de Faltantes</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="codigo">*Código Artículo</label>
                    <input type="text" name="codigo" id="codigo" class="form-control">
                    <input type="hidden" id="folio" name="folio">
                    <input type="hidden" id="id_comprador" name="id_comprador">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-finalizar">Finalizar faltante</button>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <!-- Page script -->
  <script>
    $(document).ready(function(e) {
      cargar_folio();
      cargar_tabla($("#folio").val());
      $("#codigo").focus();
    });
    $("#codigo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "inserta_faltante.php"; // El script a dónde se realizará la petición.
        var folio = $("#folio").val();
        var codigo = $("#codigo").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            codigo: codigo,
            folio: folio
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              swal("Error de captura", "El código que intenta ingresar no existe", "error");
              $("#codigo").val("");
              $("#codigo").focus();
            } else if (respuesta == "registrado") {
              $("#codigo").val("");
              $("#codigo").focus();
              alertify.error("El código ya ha sido registrado");
            } else {
              cargar_tabla($("#folio").val());
              $("#descripcion").val(respuesta);
              $("#codigo").val("");
              $("#codigo").focus();
            }
          }
        });
        return false;
      }
    });

    function cargar_folio() {
      var url = "consulta_folio.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: "", // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#folio").val(array[0]);
        }
      });
      return false;
    }

    function cargar_tabla(folio) {
      $('#lista_codigos').dataTable().fnDestroy();
      $('#lista_codigos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_faltantes.php",
          "dataSrc": "",
          "data": {
            folio: folio
          }
        },
        "columns": [{
            "data": "no"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "cantidad"
          }
        ]
      });
    }
    $("#btn-finalizar").click(function() {
      var url = "iniciar_faltante.php";
      var folio = $("#folio").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          folio: folio
        },
        success: function(respuesta) {
          alertify.success("Faltante enviado a revisión");
          window.location.href = "index.php";
        },
        error: function(xhr, status) {
          alert("error");
        }
      });
    });

    function eliminar(id) {
      var url = "elimina_articulo.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          cargar_tabla($("#folio").val());
        }
      });
      return false;
    }
    $('#comprador').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_compradores.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    })
  </script>
</body>

</html>