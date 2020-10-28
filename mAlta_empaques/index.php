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
      <?php include 'menuV.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <form method="POST" id="form-catalogo" enctype="multipart/form-data">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Unidades de empaque | Importador de registros</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="documento">*Documento</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                    <input type="file" name="file">
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="btn-guardar">Cargar Archivo</button>
            </div>
          </div>
        </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Unidades de empaque | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_ue" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="15%">Articulo</th>
                        <th>Descripcion</th>
                        <th>U. Emp.</th>
                        <th width="10%">Cantidad</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="15%">Articulo</th>
                        <th>Descripcion</th>
                        <th>U. Emp.</th>
                        <th width="10%">Cantidad</th>
                      </tr>
                    </tfoot>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#form-catalogo').submit(function(e) {
      var data = new FormData(this); //Creamos los datos a enviar con el formulario
      $.ajax({
        url: 'importar_empaques.php', //URL destino
        data: data,
        processData: false, //Evitamos que JQuery procese los datos, daría error
        contentType: false, //No especificamos ningún tipo de dato
        type: 'POST',
        success: function(resultado) {
          if (resultado == "ok") {
            alertify.success("Catálogo importado correctamente");
          } else if (resultado == "invalido") {
            alertify.error("El archivo que intenta subir no es válido");
          }
          $(":text").val("");
        }
      });

      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });

    function cargar_tabla(parametro) {
      $('#lista_ue thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_ue').dataTable().fnDestroy();
      var table = $('#lista_ue').DataTable({
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
            text: 'Mostrar registros',
            action: function() {
              cargar_tabla("lleno");
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "registro_empaques.php",
          "dataSrc": "",
          data: {
            parametro: parametro
          }
        },
        "columns": [{
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "unidad_empaque"
          },
          {
            "data": "cantidad"
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
    $(document).ready(function() {
      cargar_tabla("vacio");
    })
  </script>
</body>

</html>