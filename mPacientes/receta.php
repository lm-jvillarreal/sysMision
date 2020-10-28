<?php
include '../global_seguridad/verificar_sesion.php';
$id_paciente = $_GET['id_paciente'];
$id_consulta = $_GET['id'];
$sql = "SELECT * FROM pacientes where id='$id_paciente'";
$result = $conexion->query($sql);
//$name;
if ($result->num_rows > 0) {
  //output date of each row
  while ($row = $result->fetch_assoc()) {

    $nombreCompleto = "" . $row["nombre"] . " " . $row["ap_paterno"] . " " . $row["ap_materno"] . "";
    $edad = "" . $row["edad"] . " años";
    $alergias = "" . $row["desc_alergia"] . "";
  }

$cadena_cons = "SELECT temperatura, peso, presion FROM consulta WHERE id = '$id_consulta'";
$consulta_cons = mysqli_query($conexion, $cadena_cons);
$row_cons = mysqli_fetch_array($consulta_cons);
} else { }
?>
<!DOCTYPE html>
<html>

<head>
  <style>
    #popup {
      visibility: hidden;
      opacity: 0;
      margin-top: -350px;
    }

    #popup:target {
      visibility: visible;
      opacity: 1;
      background-color: rgba(0, 0, 0, 0.8);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      margin: 0;
      z-index: 999;
      transition: all 1s;
    }

    .popup-contenedor {
      position: relative;
      margin: 7% auto;
      padding: 30px 50px;
      background-color: #fafafa;
      color: #333;
      border-radius: 3px;
      width: 50%;
    }

    a.popup-cerrar {
      position: absolute;
      top: 3px;
      right: 3px;
      background-color: #333;
      padding: 7px 10px;
      font-size: 20px;
      text-decoration: none;
      line-height: 1;
      color: #fff;
    }

    @media print {

      .oculto-impresion,
      .oculto-impresion * {

        display: none !important;

      }

    }

    .rojo {

      color: #D50101;
      font-family: 'Baskerville Old Face';
    }

    .logo {

      padding-left: 20px;
      width: 100px;
      height: 90px;
      align-content: center;
    }

    .logomision {

      padding-left: 10px;
      width: 140px;
      height: 90px;
      align-content: center;
    }

    .cursiva {

      font-size: 43px;
      font-family: 'French Script MT';
      text-align: center;

    }

    .calibri {
      font-family: 'Calibri';
      font-size: 19px;
      text-align: center;

    }

    table.borde {
      width: 90%;
      border: solid 1px #D8D8D8;
      margin: auto;
    }

    td.transparente {
      text-align: left;
      border: solid 0px #55DD44;
    }
  </style>
  <?php include '../head.php'; ?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <h3 class="box-title">Generar Receta Médica</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <input type="hidden" name="paciente_id" id="paciente_id" value="<?php echo $id_paciente ?>">
              <input type="hidden" name="consulta_id" id="consulta_id" value="<?php echo $id_consulta ?>">
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
                    <label for="desc_alergia">*Alergias</label>
                    <input type="text" name="desc_alergia" id="desc_alergia" class="form-control" value="<?php echo $alergias ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="temperatura">Temperatura</label>
                    <input type="text" name="temperatura" id="temperatura" class="form-control" value="<?php echo $row_cons[0]; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="peso">Peso</label>
                    <input type="text" name="peso" id="peso" class="form-control" value="<?php echo $row_cons[1]; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="presion">Presión</label>
                    <input type="text" name="presion" id="presion" class="form-control" value="<?php echo $row_cons[2]; ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Agregar Medicamento</button>
                    <br>
                    <br>
                    <input type="hidden" id="ListaPro" name="ListaPro" value="" />
                    <table id="TablaPro" class="table table-striped table-bordered table-responsive" width="100%">
                      <thead>

                        <tr>
                          <th style="font-size: small">*Nombre del Medicamento (Genérico)</th>
                          <th style="font-size: small">*Nombre del Medicamento (Farmacia)</th>
                          <th style="font-size: small">*Dosis</th>
                          <th style="font-size: small">*Presentación</th>
                          <th style="font-size: small">*Via de administración</th>
                          <th style="font-size: small">*Duración de Medicación</th>

                        </tr>
                      </thead>
                      <tbody id="ProSelected"> </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="notas">*Nota Medica</label> <br>
                    <textarea name="notas" id="notas" cols="100%" rows="5" class="form-control"></textarea>
                    <br><br>
                    <div align="center">
                      <button type="submit" class="btn btn-warning" id="dominio">Generar Receta</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Agregar medicamento</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label>*Nombre del Medicamento (Genérico)</label>
                        <input class="form-control" id="NameMedicamento" name="total" required />
                      </div>
                    </div>
                    <div class="modal-footer">
                      <!--Uso la funcion onclick para llamar a la funcion en javascript-->
                      <button type="button" onclick="agregarProducto()" class="btn btn-danger" data-dismiss="modal">Agregar</button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          </form>
        </div>
      </section>
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

  <!-- Page script -->
  <script type="text/javascript">
    function RefrescaProducto() {
      var ip = [];
      var i = 0;
      $('#guardar').attr('disabled', 'disabled');
      $('.iProduct').each(function(index, element) {
        i++;
        ip.push({
          id_pro: $(this).val()
        });
      });

      if (i > 0) {
        $('#guardar').removeAttr('disabled', 'disabled');
      }
      var ipt = JSON.stringify(ip);
      $('#ListaPro').val(encodeURIComponent(ipt));
    }

    function agregarProducto() {


      var sel = document.getElementById('NameMedicamento').value;


      var newtr = '<tr class="item" data-id="' + sel + '">';
      newtr = newtr + '<td> <input class="form-control" id="nombre_generico" value="' + sel + '" name="nombre_generico[]"/></td>';

      newtr = newtr + '<td> <input name="nombre_farmacia[]" id="nombre_farmacia" class="form-control"  /></td>';
      newtr = newtr + '<td><input name="dosis[]" id="dosis" class="form-control"  /></td>';
      newtr = newtr + '<td><input name="presentacion[]" id="presentacion" class="form-control"   /></td>';
      newtr = newtr + '<td><input name="via_adm[]" id="via_adm" class="form-control"   /></td>';
      newtr = newtr + '<td><input name="duracion_tratamiento[]" id="duracion_tratamiento" class="form-control"   /></td>';
      newtr = newtr + '<td><button type="button" class="btn btn-danger btn-s remove-item"><i class="fa fa-times"></i></button></td></tr>';

      $('#ProSelected').append(newtr);

      RefrescaProducto();

      $('.remove-item').off().click(function(e) {
        $(this).parent('td').parent('tr').remove();
        if ($('#ProSelected tr.item').length == 0)
          $('#ProSelected .no-item').slideDown(300);
        RefrescaProducto();
      });
      $('.iProduct').off().change(function(e) {
        RefrescaProducto();
      });
      $('#NameMedicamento').val("");
    }
  </script>
  <script>
    $(function() {})
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_datos.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          beforeSend: function(respuesta) {
            console.log('before');
          },
          success: function(data) {
            console.log('success');
            console.log(data);
            window.open('pdfReceta.php?id=<?php echo $id_paciente ?>', '_blank');
            window.location.href = "index.php";
          },
          error: function(e) {
            $("#loading").hide();
            console.log('error');
            console.log(e);
          }

        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          nombre_generico: "required",
          nombre_farmacia: "required",
          dosis: "required",
          presentacion: "required",
          via_adm: "required",
          duracion_tratamiento: "required",
          notas: "required"
        },
        messages: {
          nombre_generico: "Campo requerido",
          nombre_farmacia: "Campo requerido",
          dosis: "Campo requerido",
          presentacion: "campo requerido",
          via_adm: "Campo requerido",
          duracion_tratamiento: "Campo requerido",
          notas: "Campo requerido"
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
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-10").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-12").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-10").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-12").addClass("has-success").removeClass("has-error");
        }
      });
    });
  </script>
</body>

</html>