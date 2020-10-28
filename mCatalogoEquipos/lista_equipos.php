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
            <h3 class="box-title">Catálogo de Equipos | Lista Completa</h3>
          </div>
          <div class="box-body">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id='lista_equipos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                      <thead>
                        <tr>
                          <th width="7%">#</th>
                          <th width="10%">Clave</th>
                          <th>Equipo</th>
                          <th width="10%">Suc.</th>
                          <th width="10%">Grupo</th>
                          <th width="10%">Tipo</th>
                          <th width="10%">Area</th>
                          <th width="12%">Adjuntar</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Clave</th>
                          <th>Equipo</th>
                          <th>Sucursal</th>
                          <th>Grupo</th>
                          <th>Tipo</th>
                          <th>Area</th>
                          <th>Adjuntar</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
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
  <?php include 'modal_imagenes.php'; ?>
  <?php include 'modal_archivos.php'; ?>
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
      $('#lista_equipos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_equipos').dataTable().fnDestroy();
      var table = $('#lista_equipos').DataTable({
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
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_equipos.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "num"
          },
          {
            "data": "clave"
          },
          {
            "data": "equipo"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "grupo"
          },
          {
            "data": "tipo"
          },
          {
            "data": "area"
          },
          {
            "data": "adjuntar"
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
    $(document).ready(function() {
      cargar_tabla();
      $('#modal-imagenes').on('show.bs.modal', function(e) {
        var id_equipo = $(e.relatedTarget).data().id;
        $(this).find('#id_equipo').val(id_equipo);
      });
      $('#modal-archivos').on('show.bs.modal', function(e) {
        var id_equipo = $(e.relatedTarget).data().id;
        $(this).find('#id_equipoS').val(id_equipo);
      });
    });
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#formDatos2').submit(function(e) {
      var data = new FormData(this); //Creamos los datos a enviar con el formulario
      $.ajax({
        url: 'guardar_imagen.php', //URL destino
        data: data,
        processData: false, //Evitamos que JQuery procese los datos, daría error
        contentType: false, //No especificamos ningún tipo de dato
        type: 'POST',
        success: function(resultado) {
          if (resultado == "ok") {
            $('#modal-imagenes').modal('hide');
            swal("Satisfactorio!!", "La imagen fue anexada sin inconvenientes", "success");
          } else if (resultado == "invalido") {
            alertify.error("El archivo que intenta subir no es válido");
          }
          $(":text").val("");
        }
      });

      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });
    $('#formDatos3').submit(function(e) {
      var data = new FormData(this); //Creamos los datos a enviar con el formulario
      $.ajax({
        url: 'guardar_archivo.php', //URL destino
        data: data,
        processData: false, //Evitamos que JQuery procese los datos, daría error
        contentType: false, //No especificamos ningún tipo de dato
        type: 'POST',
        success: function(resultado) {
          if (resultado == "ok") {
            $('#modal-archivos').modal('hide');
            swal("Satisfactorio!!", "El archivo fue anexado sin inconvenientes", "success");
          } else if (resultado == "invalido") {
            alertify.error("El archivo que intenta subir no es válido");
          }
          $(":text").val("");
        }
      });

      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });
  </script>
</body>

</html>