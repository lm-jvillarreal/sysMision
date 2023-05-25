<?php
include '../global_seguridad/verificar_sesion.php';
$fecha_inicio = date("Y-m-01");
$fecha_fin = date("Y-m-d");
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
            <h3 class="box-title">Resumen de Vales de caja | Filtros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha inicial:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_inicio ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_inicio ?>" id="fecha_inicio" name="fecha_inicio">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_fin ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_fin ?>" id="fecha_fin" name="fecha_fin">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Sucursal:</label>
                  <select name="sucursal" id="sucursal" class="form-control"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-consultar">Filtrar información</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen de Vales de caja | Resumen</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <form action="" method="POST" id="frm-pedido">
                    <input type="hidden" id="folio" name="folio">
                    <table id='lista_resumen' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                      <thead>
                        <tr>
                          <td width='5%'><strong>Cantidad</strong></td>
                          <td width='10%'><strong>Artículo</strong></td>
                          <td><strong>Descripción</strong></td>
                          <td width='18%'><strong>Departamento</strong></td>
                          <td width='8%'><strong>Precio</strong></td>
                          <td width='8%'><strong>Cambio</strong></td>
                          <td width='8%'><strong>Dif.</strong></td>
                          <td width='8%'><strong>Total</strong></td>
                          <td width='12%'><strong>Fecha</strong></td>
                        </tr>
                        <tr>
                          <th width='5%'>Cantidad</th>
                          <th width='10%'>Artículo</th>
                          <th>Descripción</th>
                          <th width='18%'>Departamento</th>
                          <th width='8%'>Precio</th>
                          <th width='8%'>Cambio</th>
                          <th width='8%'>Dif.</th>
                          <th width='8%'>Total</th>
                          <th width='12%'>Fecha</th>
                        </tr>
                      </thead>
                    </table>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">

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
      $("#sucursal").select2("trigger", "select", {
        data: {
          id: "<?php echo $id_sede; ?>",
          text: "<?php echo $nombre_sede; ?>"
        }
      });
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

    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_sucursales.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    })

    $("#btn-consultar").click(function() {
      cargar_tabla();
    });

    function cargar_tabla() {
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();
      var sucursal = $("#sucursal").val();
      $('#lista_resumen thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_resumen').dataTable().fnDestroy();
      var table = $('#lista_resumen').DataTable({
        "initComplete": function(settings, json) {

        },
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
            title: 'AuditoriaPV',
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
          {
            text: 'Realizar corte',
            className: 'red',
            action: function() {
              realizar_corte();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_resumen.php",
          "dataSrc": "",
          "data": {
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            sucursal: sucursal
          }
        },
        "columns": [{
            "data": "cantidad"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "departamento"
          },
          {
            "data": "artc_precio"
          },
          {
            "data": "artc_cambioprecio"
          },
          {
            "data": "artc_diferencia"
          },
          {
            "data": "total"
          },
          {
            "data": "fecha"
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

    function realizar_corte() {
      var url = "realizar_corte.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {

        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          swal("¡Listo!", "El corte ha sido realizado correctamente", "success");
        }
      });
      return false;
    };
  </script>
</body>

</html>