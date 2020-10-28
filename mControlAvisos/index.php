<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
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
            <h3 class="box-title">Control de Avisos | Registro</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="titulo_aviso">*Título:</label>
                    <input type="text" name="titulo_aviso" id="titulo_aviso" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_vigencia">*Vigencia:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_vigencia" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_vigencia" name="fecha_vigencia">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cantidad_apariciones">*Apariciones:</label>
                    <input type="number" id="cantidad_apariciones" name="cantidad_apariciones" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="perfil">*Perfil:</label>
                    <select name="perfil" id="perfil" class="form-control"></select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="detalle_aviso">*Aviso:</label>
                    <textarea name="detalle_aviso" id="detalle_aviso" cols="30" rows="5" class="form-control rounded-0"></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="guardar">Guardar Aviso</button>
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
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $('#perfil').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_perfiles.php",
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
    });
    $("#guardar").click(function() {
      if ($("#titulo_aviso").val() == "" || $("#fecha_vigencia").val() == "" || $("#cantidad_vigencia").val() == "" || $("#perfil").val() == "" || $("#detalle_aviso").val() == "") {
        alertify.error("Favor de rellenar todos los campos");
      } else {
        var url = "insertar_aviso.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form-datos').serialize(),
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Aviso programado correctamente");
            } else {
              alertify.error("Existió un error");
            }
            $("#form-datos")[0].reset();
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        });
      }
    })
  </script>
</body>

</html>