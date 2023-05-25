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
            <h3 class="box-title">Áreas de inventario | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_auditorias" class="table table-striped table-bordered" cellspacing="0" width="120%">
                    <thead>
                      <tr style="font-weight: bold;">
                        <td width='5%'>#</td>
                        <td width='8%'>Categoría</td>
                        <td width='15%'>Vigilante</td>
                        <td width='10%'>Artículo</td>
                        <td>Descripción</td>
                        <td width='5%'>Conteo</td>
                        <td width='5%'>Teórico</td>
                        <td width='5%'>Dif.</td>
                        <td width='8%'>Sucursal</td>
                        <td width='10%'>Fecha</td>
                        <td width='5%'></td>
                      </tr>
                      <tr>
                        <th width='5%'>#</th>
                        <td width='8%'>Categoría</td>
                        <th width='15%'>Vigilante</th>
                        <th width='10%'>Artículo</th>
                        <th>Descripción</th>
                        <th width='5%'>Conteo</th>
                        <th width='5%'>Teórico</th>
                        <th width='5%'>Dif.</th>
                        <th width='8%'>Sucursal</th>
                        <th width='10%'>Fecha</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-success" id="btnFinalizar">Finalizar auditoría</button>
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
    $(document).ready(function() {
      tabla_detalle();
    });

    function tabla_detalle() {
      $('#lista_auditorias thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_auditorias').dataTable().fnDestroy();
      var table = $('#lista_auditorias').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
            title: 'ListaAuditorias',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'ListaAuditorias',
						exportOptions: {
							columns: ':visible'
						}
					},
          {
            extend: 'copy',
            text: 'Copiar registros',
            className: 'btn btn-default',
            copyTitle: 'Ajouté au presse-papiers',
            copyKeys: '',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_reconteo.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "categoria"
          },
          {
            "data": "vigilante"
          },
          {
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "conteo"
          },
          {
            "data": "teorico"
          },
          {
            "data": "diferencia"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fechahora"
          },
          {
            "data": "opciones"
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
    };

    function captura(folio, descripcion) {
      var url = "insertar_conteo.php";
      swal(descripcion, {
          content: {
            element: "input",
            attributes: {
              placeholder: "Ingresa la cantidad:",
              type: "number",
            },
          },
        })
        .then((value) => {
          var cantidad = value;
          if (cantidad == null || cantidad.length < 1) {

          } else {
            $.ajax({
              type: "POST",
              url: url,
              data: {
                folio: folio,
                cantidad: cantidad
              },
              success: function(respuesta) {
                alertify.success("Cantidad ingresada con éxito");
                tabla_detalle();
              }
            });
          }
        });
    };
    $("#btnFinalizar").click(function() {
      var url = "finalizar_auditoria.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {

        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "no_finalizado") {
            alertify.error("Existen conteos incompletos");
          } else {
            alertify.success("La auditoría ha sido finalizada correctamente");
          }
        }
      });
    });
  </script>
</body>

</html>