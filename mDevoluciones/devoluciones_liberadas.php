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
            <h3 class="box-title">Lista de Devoluciones</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="lista_devoluciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th width="5%">Folio</th>
                    <th width="10%">Movimiento</th>
                    <th>Proveedor</th>
                    <th width="10%">Sucursal</th>
                    <th width="5%">Fecha</th>
                    <th width="10%">Usuario</th>
                  </tr>
                </thead>
                <tfooter>
                  <tr>
                    <th>#</th>
                    <th>Folio</th>
                    <th>Movimiento</th>
                    <th>Proveedor</th>
                    <th>Sucursal</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                  </tr>
                </tfooter>
              </table>
            </div>
          </div>
          <div class="box-footer"></div>
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
    function liberar_devolucion(id_devolucion) {
      //var id_devolucion = "";
      swal({
          title: "¿Está seguro de liberar la devolución?",
          text: "No. Devolución: " + id_devolucion,
          icon: "warning",
          buttons: ["Cancelar", "Iniciar"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            cambiar_status(id_devolucion);
            swal("La devolución no." + id_devolucion + " ha sido liberada.", {
              icon: "success",
            });
            cargar_tabla();
          } else {
            swal("La liberación de la devolución no. " + id_devolucion + " ha sido cancelada.", {
              icon: "error",
            });
          }
        });
    }
  </script>
  <script>
    function cambiar_status(id) {
      var url = "liberar_devolucion.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          ide: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          console.log(respuesta);
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
  </script>
  <script>
    $(document).ready(function() {
      cargar_tabla();
      // $('.select2').select2({
      //   placeholder: 'Seleccione una opcion',
      //   lenguage: 'es'
      // });
    })

    function cargar_tabla() {
      $('#lista_devoluciones thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_devoluciones').dataTable().fnDestroy();
      var table = $('#lista_devoluciones').DataTable({
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
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "lista_devLib.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "no"
          },
          {
            "data": "folio"
          },
          {
            "data": "movimiento"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fecha"
          },
          {
            "data": "usuario"
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
  </script>
</body>

</html>