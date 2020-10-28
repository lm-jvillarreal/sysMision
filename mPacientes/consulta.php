<?php
include '../global_seguridad/verificar_sesion.php';
$id_paciente = $_GET['id_paciente'];

date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
$prefijo = date("Y") . date("m") . date("d");

$turno_consulta = mysqli_query($conexion, "SELECT consecutivo FROM turnos WHERE prefijo='$prefijo' ORDER BY consecutivo DESC LIMIT 1");
$row_turno = mysqli_fetch_array($turno_consulta);
$turno = $row_turno[0];

$sql = "SELECT*FROM pacientes where id='$id_paciente'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {

  while ($row = $result->fetch_assoc()) {

    $nombreCompleto = "" . $row["nombre"] . " " . $row["ap_paterno"] . " " . $row["ap_materno"] . "";
    $edad = "" . $row["edad"] . " años";
    $alergias = "" . $row["desc_alergia"] . "";
  }
} else { }


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
            <h3 class="box-title">Consultas Médica</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <input type="hidden" name="paciente_id" id="paciente_id" value="<?php echo $id_paciente ?>">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="id_paciente">*Nombre del paciente</label>
                    <input type="text" name="id_paciente" id="id_paciente" class="form-control" value="<?php echo $nombreCompleto ?>" readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_edad">*Edad del paciente</label>
                    <input type="text" name="id_edad" id="id_edad" class="form-control" value="<?php echo $edad ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="id_alergias">*Alergias</label>
                    <input type="text" name="id_alergias" id="id_alergias" class="form-control" value="<?php echo $alergias ?>" readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="turno">*Turno</label>
                    <input type="text" name="turno" id="turno" class="form-control" placeholder="Turno del ticket">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="temperatura">*Temperatura</label>
                    <input type="text" name="temperatura" id="temperatura" class="form-control" placeholder="Ingrese la temperatura del paciente ej. 17°" value="NA">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="peso">*Peso</label>
                    <input type="text" name="peso" id="peso" class="form-control" placeholder="Ingrese el peso del paciente ej. 70kg" value="NA">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="presion">*Presión</label>
                    <input type="text" name="presion" id="presion" class="form-control" placeholder="Ingrese la presión del paciente" value="NA">
                  </div>
                </div>
              </div>
              <!-- prueba-->
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="malestar">*Malestar</label>
                    <input type="text" name="malestar" id="malestar" class="form-control" placeholder="Malestares del paciente" value="NA">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exploracion_fisica">*Exploración fisica</label>
                    <input type="text" name="exploracion_fisica" id="exploracion_fisica" class="form-control" placeholder="Exploración fisica del paciente" value="NA">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="diagnostico">*Diagnostico</label>
                    <input type="text" name="diagnostico" id="diagnostico" class="form-control" placeholder="Diagnostico General" value="NA">
                  </div>
                </div>
              </div>
              <!--finprueb-->
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Consultas Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_consulta" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="60%">Nombre del Paciente</th>
                        <th width='10%'>Turno</th>
                        <th width='10%'>Fecha</th>
                        <th width='10%'>Generar Receta</th>
                      </tr>
                    </thead>
                  </table>
                </div>
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
  <!-- Page script -->
  <script>
    function cargar_tabla() {
      var consulta = $("#Consulta").val();
      $('#lista_consulta').dataTable().fnDestroy();
      $('#lista_consulta').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": true,
        "order": [
          [0, "desc"]
        ],
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_consulta.php",
          "dataSrc": "",
          "data": {
            consulta: consulta
          }
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "nombre_completo"
          },
          {
            "data": "turno"
          },
          {
            "data": "fecha"
          },
          {
            "data": "receta"
          }
        ]
      });
    }
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_consulta.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro guardado correctamente");
              cargar_tabla();
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
            $(":text").val(''); //Limpiar los campos tipo Text
            cargar_tabla();
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          temperatura: "required",
          peso: "required",
          presion: "required",
          malestar: "required",
          exploracion_fisica: "required",
          diagnostico: "required",
          turno: "required"

        },
        messages: {
          temperatura: "campo requerido",
          peso: "campo requerido",
          presion: "campo requerido",
          malestar: "campo requerido",
          exploracion_fisica: "campo requerido",
          diagnostico: "campo requerido",
          turno: "campo requerido"
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
          $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
      });
      cargar_tabla();
    });

    $(document).ready(function() {
      $("#turno").change(function() {
        var turno_impreso = '<?php echo $turno; ?>'
        var inputs = $("#turno");
        var turno = $(inputs).val();
        var ti = parseInt(turno_impreso)
        var t = parseInt(turno)
        if (t <= ti) {
          $(this).css("border", "1px solid green");
          swal("Turno Disponible", {
            icon: "success",
          });
        } else {

          $(this).css("border", "1px solid red");
          swal("Esté turno no se ha impreso", {
            icon: "error",
          });
          $(this).focus();
        }

      });
    });
  </script>
</body>

</html>