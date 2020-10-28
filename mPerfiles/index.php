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
            <h3 class="box-title">Registro de perfiles de usuario</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nombre_modulo">*Perfil</label>
                    <input type="text" name="nombre_perfil" id="nombre_perfil" class="form-control" placeholder="Nombre del perfil">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descripcion_perfil">*Descripci&oacute;n</label>
                    <input type="text" name="descripcion_perfil" id="descripcion_perfil" class="form-control" placeholder="A&ntilde;ade una descripci&oacute;n">
                  </div>
                </div>
              </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Perfiles Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <?php include 'tabla_perfiles.php'; ?>
              </div>
            </div>
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
    function estilo_tablas() {
      $('#lista_perfiles').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        }
      })
    }
    $(function() {
      estilo_tablas();
    })
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_perfil.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro guardado correctamente");
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
            $(":text").val(''); //Limpiar los campos tipo Text
            $("#lista_perfiles").DataTable().destroy();
            $("#tabla").load("tabla_perfiles.php");
            $("#lista_perfiles").DataTable();
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          nombre_perfil: "required",
          descripcion_perfil: "required"
        },
        messages: {
          nombre_perfil: "Campo requerido",
          descripcion_perfil: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
          // Add the `help-block` class to the error element
          error.addClass("help-block");

          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
      });
    });
  </script>
</body>

</html>