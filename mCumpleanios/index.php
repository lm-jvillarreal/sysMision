<?php
include '../global_seguridad/verificar_sesion.php';
function nombremes($mes)
{
  setlocale(LC_TIME, 'es_ES.UTF-8');
  $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
  return $nombre;
}

date_default_timezone_set("America/Monterrey");
$num_mes = date('m');
$mes_letra = nombremes($num_mes);
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
            <h3 class="box-title">Cumpleaños del Mes | <?php echo $mes_letra; ?></h3>
          </div>
          <div class="box-body">
            <div class="row" id="contenedor">
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
    function llenar() {
      var url = 'http://200.1.1.197/SMPruebas/cumple_empleados.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {},
        success: function(respuesta) {
          //evaluar el array y separarlo para imprimir por campos
          $('#contenedor').html(respuesta);
        },
        error: function(xhr, status) {
          alert("error");
          alert(xhr);
        },
      });
    }
    $(document).ready(function(e) {
      llenar();
    });
  </script>
</body>

</html>