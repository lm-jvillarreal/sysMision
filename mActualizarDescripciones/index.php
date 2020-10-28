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
        <form method="POST" id="form-catalogo" enctype="multipart/form-data">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Control de Artículos | Modificación de Descripciones</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="documento">*Documento</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                    <input type="file" name="file">
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="btn-guardar">Cargar Archivo</button>
            </div>
          </div>
        </form>
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
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#form-catalogo').submit(function(e) {
      var data = new FormData(this); //Creamos los datos a enviar con el formulario
      $.ajax({
        url: 'importar_descripcion.php', //URL destino
        data: data,
        processData: false, //Evitamos que JQuery procese los datos, daría error
        contentType: false, //No especificamos ningún tipo de dato
        type: 'POST',
        success: function(resultado) {
          if (resultado == "ok") {
            swal("Satisfactorio!!", "La actualización de artículos se realizó sin inconvenientes.", "success");
          } else if (resultado == "invalido") {
            alertify.error("El archivo que intenta subir no es válido");
          }
          $(":text").val("");
        }
      });

      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });
  </script>
</body>

</html>