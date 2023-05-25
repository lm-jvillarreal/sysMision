<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_codigos {
    width: 80% !important;
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
      <?php include 'menuV.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger" id="contenedor_tabla">
          <div class="box-header">
            <h3 class="box-title">Etiquetas | Pendientes de autorizar</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_pendientes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="10%">Sucursal</th>
                        <th>Nombre</th>
                        <th width="5%">Formato</th>
                        <th width="5%">Tipo</th>
                        <th width="12%">Fecha</th>
                        <th width="17%">Usuario</th>
                        <th width="8%">Tiempo</th>
                        <th width="5%">Cant.</th>
                        <th width="12%">Autorizar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Nombre</th>
                        <th>Formato</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Tiempo</th>
                        <th>Cant.</th>
                        <th>Autorizar</th>
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
    <?php include 'modal_codigos.php'; ?>
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
    function cargar_tabla() {
      $('#lista_pendientes').dataTable().fnDestroy();
      $('#lista_pendientes').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "asc"]
        ],
        "searching": true,
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
					}
				],
        "ajax": {
          "type": "POST",
          "url": "tabla_pendientes.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "nombre"
          },
          {
            "data": "formato"
          },
          {
            "data": "tipo"
          },
          {
            "data": "fecha"
          },
          {
            "data": "usuario"
          },
          {
            "data": "tiempo"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "autorizar"
          }
        ]
      });
    }
    $(document).ready(function(e) {
      cargar_tabla();
      $('#modal-codigos').on('show.bs.modal', function(e) {
        $('#tabla').html("<h2>Cargando datos, por favor espere...</h2>");
        var folio = $(e.relatedTarget).data().folio;
        //alert(id);
        var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            folio: folio
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#tabla').html(respuesta);
            cargar_tabla2();
          }
        });
      });
    });

    function impreso(registro) {
      var id_solicitud = registro;
      var url = 'cambiar_estatus.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_solicitud: id_solicitud
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("El estatus ha sido cambiado");
            cargar_tabla();
            llenar_notificaciones();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function autorizar(id_solicitud) {
      var url = 'autorizar.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_solicitud: id_solicitud
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("La solicitud ha sido autorizada para impresión");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function eliminar(id_solicitud) {
      var url = 'eliminar_solicitud.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_solicitud: id_solicitud
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("La solicitud ha sido eliminada");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function cargar_tabla2() {
      $('#lista_teoricos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_teoricos').dataTable().fnDestroy();
      var table = $('#lista_teoricos').DataTable({
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
            text: 'Actualizar tabla',
            className: 'red',
            action: function() {
              actualizaDescripcion();
            },
            counter: 1
          },
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