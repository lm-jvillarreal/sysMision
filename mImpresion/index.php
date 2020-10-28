<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script type="text/javascript" src="funciones.js?v=<?php echo (rand()) ?>"></script>
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
            <h3 class="box-title">Impresión de Mapeos</h3>
          </div>
          <div class="box-body">

          </div>
          <div class="box-footer">
            <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Sin imprimir</a>
            <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Impresos</a>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Impresión de Mapeos | Lista</h3>
          </div>
          <div class="box-body">
            <div class="col-lg-12">
              <div class="collapse multi-collapse" id="multiCollapseExample1">
                <div class="card card-body" id="contenedor_sin">
                  <?php include 'mapeos_admin.php'; ?>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="collapse multi-collapse" id="multiCollapseExample2">
                <div class="card card-body" id="contenedor_ya">
                  <?php include 'tabla_impresos.php'; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <a href="rpt_detalle_mapeos.php" class="btn btn-success">Descargar detalle</a>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  <script type="text/javascript">
    function cambiar_estado(id) {
      let datos = {
        id: id
      };

      $.ajax({
        url: "cambiar_estado.php",
        type: "POST",
        dateType: "html",
        data: datos,
        success: function(respuesta) {
          $('#contenedor_sin').load('mapeos_admin_reload.php');
          $('#contenedor_ya').load('tabla_impresos_reload.php');
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function desmarcar(id) {
      let datos = {
        id: id
      };

      $.ajax({
        url: "desmarcar.php",
        type: "POST",
        dateType: "html",
        data: datos,
        success: function(respuesta) {
          $('#contenedor_sin').load('mapeos_admin_reload.php');
          $('#contenedor_ya').load('tabla_impresos_reload.php');
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
    $(document).ready(function() {
      $('#example thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      var table = $('#example').DataTable({
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'NuevoMapeo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'NuevoMapeo',
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
        "lengthMenu": [
          [-1],
          ["All"]
        ],

        "language": {
          "url": "../assets/js/Spanish.json"
        }
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    });
    $(document).ready(function() {
      $('#impresos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      var table = $('#impresos').DataTable({
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'NuevoMapeo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'NuevoMapeo',
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
        "lengthMenu": [
          [-1],
          ["All"]
        ],

        "language": {
          "url": "../assets/js/Spanish.json"
        }
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    });
  </script>
</body>

</html>