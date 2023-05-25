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
            <h3 class="box-title">Detalle de Perfil</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="id_perfil">*Perfil</label>
                    <select name="id_perfil" id="id_perfil" class="form-control select">
                      <option value=""></option>
                      <?php
                      $cadena_perfil = "SELECT id, nombre FROM perfil WHERE activo = '1'";
                      $consulta_perfil = mysqli_query($conexion, $cadena_perfil);
                      while ($row_perfil = mysqli_fetch_row($consulta_perfil)) {
                        ?>
                        <option value="<?php echo $row_perfil[0] ?>"><?php echo $row_perfil[1] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="id_modulo">*Módulos</label>
                    <select name="modulos[]" id="id_modulo" class="form-control select" multiple="multiple">
                      <option value=""></option>
                      <?php
                      $cadena_modulos = "SELECT id, nombre FROM modulos WHERE activo = '1'";
                      $consulta_modulos = mysqli_query($conexion, $cadena_modulos);
                      while ($row_modulos = mysqli_fetch_row($consulta_modulos)) {
                        ?>
                        <option value="<?php echo $row_modulos[0] ?>"><?php echo $row_modulos[1] ?></option>
                      <?php
                      }
                      ?>
                    </select>
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
                <?php include 'tabla_detalle_perfil.php'; ?>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-more.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <!-- Page script -->
  <script>
    function cargar_modulos(perfil) {
      var url = "select_modulos.php";
      $.ajax({
        type: "POST",
        url: url,
        data: 'id_perfil=' + perfil, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#id_modulo').html(respuesta);
        }
      });
    }
  </script>
  <script>
    function estilo_tablas() {
      $('#lista_perfiles').DataTable({
        'paging': true,
        "dom": 'Bfrtip',
        buttons: [
                    {
						extend: 'pageLength',
						text: 'Registros',
						className: 'btn btn-default'
					},
					{
						extend: 'excel',
						text: 'Exportar a Excel',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'copy',
						text: 'Copiar registros',
						className: 'btn btn-default',
						copyTitle: 'Ajouté au presse-papiers',
						copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
						copySuccess: {
							_: '%d lignes copiées',
							1: '1 ligne copiée'
						}
					}
				],
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
        var url = "insertar_detalle.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro insertado correctamente");
            }
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
  <script>
    $(function() {
      $('.select').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      })
    })
  </script>
</body>

</html>