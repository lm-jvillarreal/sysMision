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
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Órdenes de Compra | Mis órdenes pendientes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <br>
                <div class="table-responsive">
                  <table id="lista_ordenes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="10%">Folio</th>
                        <th>Proveedor</th>
                        <th width="10%">Orden</th>
                        <th width="15%">Arribo</th>
                        <th width="10%">Retraso</th>
                        <th width="10%">Sucursal</th>
                        <th width="5%">Ver</th>
                        <th width="5%">Elim.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>Folio</th>
                        <th>Proveedor</th>
                        <th>No. orden</th>
                        <th>Fecha llegada</th>
                        <th>Retraso</th>
                        <th>Sucursal</th>
                        <th>Ver</th>
                        <th>Elim.</th>
                      </tr>
                    </tbody>
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
  <!-- Page script -->
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    function ordenes_compra() {
      $('#lista_ordenes thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_ordenes').dataTable().fnDestroy();
      var table = $('#lista_ordenes').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
            title: 'ListadoOCPendientes',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'ListadoOCPendientes',
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
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "t_ordenes_compra.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "no_orden"
          },
          {
            "data": "fecha_llegada"
          },
          {
            "data": "retraso"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "ver"
          },
          {
            "data": "eliminar"
          }
        ]
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
    }
    $(document).ready(function(e) {
      ordenes_compra();
      calendario();
    });

    function calendario() {
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
    }

    function actualiza_fecha(id_orden) {
      var url = "actualiza_fecha.php";
      var fecha = $("#fecha_" + id_orden).val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_orden: id_orden,
          fecha: fecha
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("La fecha ha sido actualizada con éxito");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      ordenes_compra();
      return false;
    }

    function eliminar(id_orden) {
      var url = "eliminar_orden.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_orden: id_orden
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("La OC ha sido eliminada exitosamente");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      //ordenes_compra();
      return false;
    }
  </script>

</html>