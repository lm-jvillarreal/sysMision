<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap4.min.css" rel="stylesheet" />
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <?php include 'menuV3.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Reportes | Bitácora de revisiones</h3>
          </div>
          <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
              <label for="artc_articulo">*Artículo:</label>
              <input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
              </div>
            </div>
          </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_revisiones" class="table table-striped table-bordered" cellspacing="0" width="120%">
                    <thead>
                      <tr>
                        <th width='10%'>Artículo</th>
                        <th>Descripción</th>
                        <th width='10%'>Depto.</th>
                        <th width='10%'>Suc.</th>
                        <th width='10%'>Alta</th>
                        <th width='10%'>Teórico Alta</th>
                        <th width='10%'>Liberación</th>
                        <th width='5%'>Ajuste</th>
                        <th width='15%'>Observaciones</th>
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
  <!-- Page script -->
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
  <script>
    $(document).ready(function() {
      tabla_bitacora();
      $("#artc_articulo").focus();
    })
    $('#artc_articulo').keyup(function(e) {
      if (e.keyCode == 13) {
        if($("#artc_articulo").val()==""){
          alertify.error("Debes ingresar un código de artículo");
        }else{
          tabla_bitacora($("#artc_articulo").val());
        }
      }
    });

    function tabla_bitacora(artc_articulo) {
      $('#lista_revisiones').dataTable().fnDestroy();
      $('#lista_revisiones').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "scrollX": true,
        "scrollY": "300px",
        "scrollCollapse": true,
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
            title: 'ListaCategorias',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'ListaCategorias',
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
        "ajax": {
          "type": "POST",
          "url": "tabla_bitacora.php",
          "dataSrc": "",
          data: {
            artc_articulo: artc_articulo
          }
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "depto"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fecha_revision"
          },
          {
            "data": "teorico"
          },
          {
            "data": "fecha_ajuste"
          },
          {
            "data": "teorico_ajuste"
          },
          {
            "data": "observaciones"
          }
        ]
      });
    };
  </script>
</body>

</html>