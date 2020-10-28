<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
            <h3 class="box-title">Ofertas | Control de Ofertas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="artc_articulo">*Artículo</label>
                  <input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Detalle de Artículo | Listado de Ofertas Vigentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_ofertas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Artículo</th>
                        <th>Descripción</th>
                        <th width='10%'>Folio</th>
                        <th>Desc. Oferta</th>
                        <th width='15%'>Sucursal</th>
                        <th width='10%'>P. Oferta</th>
                        <th width='10%'>Vigencia</th>
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
      cargar_tabla();
    })
    $("#mostrar_datos").click(function() {
      cargar_tabla();
    })

    function cargar_tabla() {
      var artc_articulo = $("#artc_articulo").val();
      $('#lista_ofertas').dataTable().fnDestroy();
      $('#lista_ofertas').DataTable({
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
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_ofertas.php",
          "dataSrc": "",
          "data": {
            artc_articulo: artc_articulo
          }
        },
        "columns": [{
            "data": "articulo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "folio"
          },
          {
            "data": "desc_oferta"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "precio_oferta"
          },
          {
            "data": "vigencia"
          },
          {
            "data": "baja"
          }
        ]
      });
    }

    function baja(folio_oferta) {
      var folio_oferta = folio_oferta;
      var artc_articulo = $("#artc_articulo").val();
      var url = 'baja_articulo_oferta.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          folio_oferta: folio_oferta,
          artc_articulo: artc_articulo
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Artículo deshabilitado correctamente");
            //cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
    }
  </script>
</body>

</html>