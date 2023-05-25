<?php
include '../global_seguridad/verificar_sesion.php';
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Detalle de existencias | Consulta</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="codigo">*Código Artículo</label>
                    <input type="text" name="codigo" id="codigo" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="existencia">Teórico INFOFIN</label>
                    <input type="text" name="existencia" id="existencia" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ventas_pendientes">Vtas. Pte. Afect. (SALXVE)</label>
                    <input type="text" name="ventas_pendientes" id="ventas_pendientes" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="sirota">SIROTA (MERCADOS)</label>
                    <input type="text" name="sirota" id="sirota" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ventas_proceso">Vtas. en proceso (SUC.)</label>
                    <input type="text" name="ventas_proceso" id="ventas_proceso" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="teorico_calculado">Existencia calculada</label>
                    <input type="text" name="teorico_calculado" id="teorico_calculado" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-guardar">Guardar registro</button>
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
      $("#codigo").focus();
    });
    $("#codigo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_articulo.php"; // El script a dónde se realizará la petición.
        var codigo = $("#codigo").val();
        $("#articulo").val($("#codigo").val());
        $("#codigo").attr("readonly", true);
        Swal.fire({
          title: 'Espere por favor',
          html: 'consultando información ...', // add html attribute if you want or remove
          allowOutsideClick: false,
          onBeforeOpen: () => {
            Swal.showLoading()
          },
        });

        $.ajax({
          type: "POST",
          url: url,
          data: {
            codigo: codigo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              swal("Error de captura", "El código que intenta ingresar no existe", "error");
              $("#codigo").val("");
              $("#codigo").focus();
            } else {
              $("#codigo").removeAttr("readonly");
              var array = eval(respuesta);
              $("#descripcion").val(array[1]);
              $("#existencia").val(array[2]);
              $("#ventas_pendientes").val(array[3]);
              $("#sirota").val(array[4]);
              $("#ventas_proceso").val(array[5]);
              $("#teorico_calculado").val(array[6]);
            }
            Swal.close();
          }
        });
        return false;
      }
    });
    $("#btn-guardar").click(function() {
      var url = "insertar_articulo.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $("#form_datos").serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("El artículo ha sido registrado", {
              position: 'top-end',
              icon: "success",
              closeOnClickOutside: false,
              buttons: false,
              timer: 1500
            });
          } else {
            swal("El artículo ya existe", {
              position: 'top-end',
              icon: "error",
              closeOnClickOutside: false,
              buttons: false,
              timer: 1500
            });
          }
          //alertify.success("Artículo registrado correctamente");
          $("#form_datos")[0].reset();
          $("#codigo").focus();
        },
        error: function(xhr, status) {
          alert("error");
        }
      });
    });
  </script>
</body>

</html>