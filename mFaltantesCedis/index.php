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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Auditoría de faltantes - CEDIS | Filtros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="proveedor">*Proveedor:</label>
                  <select name="proveedor" id="proveedor" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button id="btn-filtrar" class="btn btn-warning">Filtrar registros</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Auditoría Piso de Venta | Lista de registros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <form action="" method="POST" id="frm-pedido">
                    <input type="hidden" id="folio" name="folio">
                    <table id='lista_registros' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                      <thead>
                        <tr>
                          <td width='5%'><strong>Codigo</strong></td>
                          <td><strong>Descripcion</strong></td>
                          <td width='6%'><strong>U. Emp.</strong></td>
                          <td width='6%'><strong>S. Min.</strong></td>
                          <td width='6%'><strong>Ventas</strong></td>
                          <td width='6%'><strong>Teórico</strong></td>
                          <td width='6%'><strong>CEDIS</strong></td>
                          <td width='8%'><strong>Días Inv.</strong></td>
                          <td width='6%'><strong>Faltante</strong></td>
                          <td width='6%'><strong>F. Cajas</strong></td>
                          <td width='15%'><strong>Pedido</strong></td>
                        </tr>
                        <tr>
                          <th width='5%'>Codigo</th>
                          <th>Descripcion</th>
                          <th width='6%'>U. Emp.</th>
                          <th width='6%'>S. Min.</th>
                          <th width='6%'>Ventas</th>
                          <th width='6%'>Teórico</th>
                          <th width='6%'>CEDIS</th>
                          <th width='8%'>Días Inv.</th>
                          <th width='6%'>Faltante</th>
                          <th width='6%'>F. Cajas</th>
                          <th width='15%'>Pedido</th>
                        </tr>
                      </thead>
                    </table>
                  </form>
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
    function finaliza_pedido() {
      var url = "crear_pedido.php";
      swal("Ingresa una descripción para el pedido", {
          content: "input",
        })
        .then((value) => {
          var descripcion = `${value}`;
          var codigo = [];
          var artc_descripcion = [];
          var cantidad = [];
          var sugerido = [];
          $("input[name=articulos]").each(function(index) {
            if ($(this).is(':checked')) {
              var id = ($(this).attr("id"));
              var cod = $("#" + id).val();
              var artc_desc = $("#artc_descripcion_" + id).val();
              var sug = $("#sugerido_" + id).val();
              var cant = $("#cantidad_" + id).val();
              codigo.push(cod);
              artc_descripcion.push(artc_desc);
              cantidad.push(cant);
              sugerido.push(sug);
            }
          });
          $.ajax({
            type: "POST",
            url: url,
            data: {
              descripcion: descripcion,
              codigo: codigo,
              artc_descripcion: artc_descripcion,
              sugerido: sugerido,
              cantidad: cantidad
            }, // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              swal("Listo!", "Pedido creado satisfactoriamente", "success")
              cargar_tabla("no");
            }
          });
        });
    };
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_proveedores.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });

    function cargar_tabla(condicion) {
      var proveedor = $("#proveedor").val();
      $('#lista_registros thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_registros').dataTable().fnDestroy();
      var table = $('#lista_registros').DataTable({
        "initComplete": function(settings, json) {
          if (condicion == 'si') {
            swal("Registros cargados", "En este listado solo aparecen los códigos que tienen existencia en CEDIS", "success");
          } else {

          }
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
						title: 'AuditoriaPV',
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
              table
                .search('')
                .columns().search('')
                .draw();
              finaliza_pedido();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_articulos.php",
          "dataSrc": "",
          "data": {
            proveedor: proveedor
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
            "data": "stock_minimo"
          },
          {
            "data": "ventas"
          },
          {
            "data": "teorico"
          },
          {
            "data": "cedis"
          },
          {
            "data": "dias_inv"
          },
          {
            "data": "faltante"
          },
          {
            "data": "faltante_cajas"
          },
          {
            "data": "pedido"
          }
        ],
        "rowCallback": function(row, data, index) {
          if ((parseInt(data.teorico, 10) < parseInt(data.ventas, 10))&&(parseInt(data.teorico,10)>0)) {
            $('td', row).css('background-color', '#E0F2D5');
          }
        }
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
      cargar_tabla("no");
    })
    $("#btn-filtrar").click(function() {
      cargar_tabla("si");
    });

    function pedido(artc_articulo, id_registro) {
      if ($("#" + id_registro).prop('checked')) {
        var cantidad = $('#cantidad_' + id_registro).val();
        $('#cantidad_' + id_registro).removeAttr('readonly');
      } else {
        $('#cantidad_' + id_registro).attr('readonly', true);
      }
    }
  </script>
</body>

</html>