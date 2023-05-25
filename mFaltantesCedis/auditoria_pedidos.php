<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>

</head>
<style>
  #modal_detalle {
    width: 100% !important;
  }
</style>

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
            <h3 class="box-title">Control de Pedidos | Historial de pedidos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Folio</th>
                        <th>Pedido</th>
                        <th width='10%'>Fecha</th>
                        <th width='10%'>Artículos</th>
                        <th width='15%'>Solicita</th>
                        <th width='10%'>Sucursal</th>
                        <th width='10%'>Estatus</th>
                        <th width='5%'></th>
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
    <?php include 'modal_detalle.php'; ?>
    <?php //include 'modal_comentario.php'; 
    ?>
    <?php //include 'modal_negar.php'; 
    ?>
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
    $(document).ready(function(e) {
      cargar_tabla();
    });
    $('#modal-detalle').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().folio;
      var salida = $(e.relatedTarget).data().salida;
      $("#folio").val(folio);
      $("#traspaso_salida").val(salida);
      tabla_articulos();
    });

    function finalizar_pedido() {
      var folio = $("#folio").val();
      var url = 'finalizar_pedido.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          swal("Listo!", "El pedido ha sido finalizado correctamente", "success");
          $("#modal-detalle").modal("hide");
          //cargar_tabla();
        }
      });
    }

    function cargar_tabla() {
      $('#lista_codigos').dataTable().fnDestroy();
      var table = $('#lista_codigos').DataTable({
        "initComplete": function(settings, json) {

        },
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "order": [
          [0, "desc"]
        ],
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'FaltantesLista',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'FaltantesLista',
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
        "deferRender": true,
        "ajax": {
          "type": "POST",
          "url": "tabla_auditoria.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "pedido"
          },
          {
            "data": "fecha"
          },
          {
            "data": "articulos"
          },
          {
            "data": "solicita"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "estatus"
          },
          {
            "data": "opciones"
          }
        ]
      });
    }

    function tabla_articulos() {
      var folio = $("#folio").val();
      $('#lista_articulos').dataTable().fnDestroy();
      $('#lista_articulos').DataTable({
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
            title: 'FaltantesLista',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'FaltantesLista',
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
          {
            text: 'Finalizar pedido',
            className: 'red',
            action: function() {
              finalizar_pedido();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            folio: folio
          },
        },
        "columns": [{
            "data": "codigo",
            "width": "10%"
          },
          {
            "data": "descripcion",
            "width": "60%"
          },
          {
            "data": "pedido",
            "width": "10%"
          },
          {
            "data": "salida",
            "width": "10%"
          },
          {
            "data": "entrada",
            "width": "10%"
          }
        ],
        "rowCallback": function(row, data, index) {
          if (data.salida == "") {
            $('td', row).css('background-color', '#F7DC6F');
          } else if (data.salida != "" && data.pedido < data.salida) {
            $('td', row).css('background-color', '#EDBB99');
          } else if (data.salida != "" && data.pedido > data.salida) {
            $('td', row).css('background-color', '#EDBB99');
          } else if (data.salida != "" && data.entrada != "" && data.salida > data.entrada) {
            $('td', row).css('background-color', '#E74C3C');
          } else if (data.salida != "" && data.entrada != "" && data.salida < data.entrada) {
            $('td', row).css('background-color', '#E74C3C');
          }
        }
      });
    };
  </script>
</body>

</html>