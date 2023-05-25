<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha_ant = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$fecha = date('Y-m-d');
$hora = date("h:i:s");
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
            <h3 class="box-title">Libro Diario | Filtros</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_inicial" name="fecha_inicial">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Visualizar Información</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Libro Diario | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='libro_diario' class='table table-striped table-bordered' cellspacing='0' width='105%'>
                    <thead>
                      <tr>
                        <th width="5%">Folio</th>
                        <th width="5%">C.F.</th>
                        <th width="5%">ESCARG</th>
                        <th>Proveedor</th>
                        <th width="5%">Recibo</th>
                        <th width="10%">Factura</th>
                        <th width="5%">Suma</th>
                        <th width="5%">Inicio</th>
                        <th width="5%">Final</th>
                        <th width="5%">Total</th>
                        <th width="10%">Obsrv.</th>
                        <th width="5%">Suc.</th>
                        <th width="5%">Quemar</th>
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
    <?php include 'modal_escarg.php'; ?>
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
    $(document).ready(function(e) {
      libro_diario();
    });
    $("#btn-guardar").click(function() {
      libro_diario();
    });

    function libro_diario() {
      fecha_inicio = $("#fecha_inicial").val();
      fecha_fin = $("#fecha_final").val();
      $('#libro_diario').dataTable().fnDestroy();
      $('#libro_diario').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        'order': [
          [0, "desc"]
        ],
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
            title: 'Libro de Entrada',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            download: 'open',
            orientation: 'landscape',
            pageSize: 'LEGAL'
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
            extend: 'print',
            title: 'Libro de Entrada',
            text: 'Imprimir registros',
            orientation: 'landscape',
            exportOptions: {
              columns: ':visible'
            }
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "consulta_libroDiario.php",
          "dataSrc": "",
          "data": {
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin
          }
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "generar_carta"
          },
          {
            "data": "escarg"
          },
          {
            "data": "no_proveedor"
          },
          {
            "data": "fecha_entrada"
          },
          {
            "data": "factura"
          },
          {
            "data": "total"
          },
          {
            "data": "hora_inicio"
          },
          {
            "data": "hora_final"
          },
          {
            "data": "tiempo_total"
          },
          {
            "data": "observaciones"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "cancelar"
          }
        ]
      });
    };

    function tabla_escarg(ficha_entrada) {
      $('#detalle_escarg').dataTable().fnDestroy();
      $('#detalle_escarg').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        'order': [
          [0, "desc"]
        ],
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'Libro de Entrada',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            download: 'open',
            orientation: 'landscape',
            pageSize: 'LEGAL'
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
            extend: 'print',
            title: 'Libro de Entrada',
            text: 'Imprimir registros',
            orientation: 'landscape',
            exportOptions: {
              columns: ':visible'
            }
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_escarg.php",
          "dataSrc": "",
          "data": {
            ficha_entrada: ficha_entrada
          }
        },
        "columns": [{
            "data": "artc_articulo",
            "width": "20%"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "artc_cantidad",
            "width": "10%"
          },
          {
            "data": "opciones",
            "width": "5%"
          }
        ]
      });
    }

    $(document).ready(function(e) {
      $('#modal-escarg').on('show.bs.modal', function(e) {
        var nota = $(e.relatedTarget).data().nota;
        $("#nota_entrada").val(nota);
        tabla_escarg(nota);
      });
    });

    function eliminar_escarg(id_escarg) {
      var url = 'eliminar_escarg.php';
      var ficha_entrada = $("#nota_entrada").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_escarg: id_escarg
        },
        success: function(respuesta) {
          tabla_escarg(ficha_entrada);
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      return false;
    }

    function cancelar_registro(id_devolucion) {
      //var id_devolucion = "";
      swal({
          title: "¿Está seguro de cancelar el recibo?",
          text: "Folio Entrada: " + id_devolucion,
          icon: "warning",
          buttons: ["Cancelar", "Iniciar"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal({
                closeOnClickOutside: false,
                closeOnEsc: false,
                title: "Motivo de la cancelación del folio",
                content: {
                  element: "input",
                  placeholder: "Ingresa aqui el motivo",
                  required: "true",
                }
              })
              .then((value) => {
                cambiar_status(id_devolucion, `${value}`);
                swal("La cancelacion del folio no." + id_devolucion + " ha sido realizada correctamente.", {
                  icon: "success",
                });
              })
          } else {
            swal("La cancelacion del folio no. " + id_devolucion + " ha sido cancelada.", {
              icon: "error",
            });
          }
        });
    }
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

    function cambiar_status(id_libroDiario, comentario) {
      var url = "cancelar_registro.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_libroDiario: id_libroDiario,
          comentario: comentario
        },
        success: function(respuesta) {

        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      libro_diario();
      return false;
    }

    function imp_folio(oc) {
      window.open("../mLiberar_orden/imprimir_folio.php?foc=" + oc, "folio", "width=320,height=900,menubar=no,titlebar=no");
    }

    function cantidad_escarg(id_escarg) {
      var url = "editar_cantidad.php";
      var cantidad = $("#folio_" + id_escarg).val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          cantidad: cantidad,
          id_escarg: id_escarg
        },
        success: function(respuesta) {
          alertify.success("La cantidad ha sido actualizada");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      return false;
    }
  </script>
</body>

</html>