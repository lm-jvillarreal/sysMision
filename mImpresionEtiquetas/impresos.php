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
        <div class="box box-danger" id="contenedor_tabla">
          <div class="box-header">
            <h3 class="box-title">Etiquetas | Etiquetas Impresas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha inicial:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="text-right">
                  <button id="btnTabla" class="btn btn-danger">Actualizar información</button>
                  <br><br><br><br>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_impresos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="10%">Sucursal</th>
                        <th>Nombre</th>
                        <th width="10%">Formato</th>
                        <th width="10%">Fecha</th>
                        <th width="20%">Usuario</th>
                        <th width="5%">Ver</th>
                        <th width="5%">Eliminar</th>
                        <th width="5%">Cancelar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Nombre</th>
                        <th>Formato</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Ver</th>
                        <th>Eliminar</th>
                        <th>Cancelar</th>
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
    function cargar_tabla() {
      var fecha_inicial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      $('#lista_impresos').dataTable().fnDestroy();
      $('#lista_impresos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
          "url": "lista_impresos.php",
          "dataSrc": "",
          "data": {
            fecha_inicial: fecha_inicial,
            fecha_final: fecha_final
          }
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
            "data": "fecha"
          },
          {
            "data": "usuario"
          },
          {
            "data": "ver"
          },
          {
            "data": "eliminar"
          },
          {
            "data": "cancelar"
          }
        ]
      });
    }
    $(document).ready(function(e) {
      cargar_tabla();
    });

    function eliminar(registro) {
      var id_solicitud = registro;
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
            alertify.success("El registro ha sido eliminado");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function cancelar_impreso(registro) {
      var id_solicitud = registro;
      var url = 'cambiar_estatus2.php';
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
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
    $("#btnTabla").click(function() {
      cargar_tabla();
    });
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
  </script>
</body>

</html>