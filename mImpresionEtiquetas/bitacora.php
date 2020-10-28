<?php
include '../global_seguridad/verificar_sesion.php';
function ultimo_dia()
{
  $month = date('m');
  $year = date('Y');
  $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
  return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};
/** Actual month first day **/
function primer_dia()
{
  $month = date('m');
  $year = date('Y');
  return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}
$fecha1 = primer_dia($fecha);
$fecha2 = ultimo_dia($fecha);
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
        <div class="box box-danger" id="contenedor_tabla">
          <div class="box-header">
            <h3 class="box-title">Etiquetas | Etiquetas Impresas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="filtro" value="0" id="filtro">
                <div class="col-md-6">
                  <label>*Fecha Inicio</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly name="fecha1" id="fecha1">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>*Fecha Final</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly name="fecha2" id="fecha2">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <center><span class='text-center' id='btn_filtro'></span></center>
            <div class="box-footer text-right">
              <a class="btn btn-warning" id="guardar" onclick="cargar_tabla()">Generar</a>
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
                        <th width="15%">Solicitó</th>
                        <th width="10%">Solicitud</th>
                        <th width="15%">Imprimió</th>
                        <th width="10%">Impresión</th>
                        <th width="5%">Tiempo</th>
                        <th width="5%">Calif.</th>
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
    function cargar_tabla() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();
      var filtro = $('#filtro').val();

      $('#lista_impresos').dataTable().fnDestroy();
      $('#lista_impresos thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      var tabla = $('#lista_impresos').DataTable({
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
            title: 'BitacoraEtiquetas',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'CostosCero',
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
            extend: 'copy',
            text: 'Filtrar',
            className: 'btn btn-default',
            action: function() {
              filtrar();
            },

          },
        ],
        "ajax": {
          "type": "POST",
          "url": "lista_bitacora.php",
          "dataSrc": "",
          "data": {
            'fecha1': fecha1,
            'fecha2': fecha2,
            'filtro': filtro
          },
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
            "data": "solicita"
          },
          {
            "data": "fecha_solicitud"
          },
          {
            "data": "imprime"
          },
          {
            "data": "fecha_impresion"
          },
          {
            "data": "tiempo_transcurre"
          },
          {
            "data": "calificacion"
          }
        ]
      });
      tabla.columns().every(function() {
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

    function filtrar() {
      if ($('#filtro').val() == 0) {
        $('#filtro').val("1");
        $('#btn_filtro').addClass('badge bg-red');
        $('#btn_filtro').html('Filtro');
      } else {
        $('#filtro').val("0");
        $('#btn_filtro').removeClass('badge bg-red');
        $('#btn_filtro').html('');
      }
      cargar_tabla();
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
    };
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