<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$prefijo = date("Y") . date("m") . date("d");
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
            <h3 class="box-title">Vale Provisional de Caja | Consulta de ticket</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form_registro">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="prefijo">*Prefijo</label>
                    <input type="text" name="prefijo" id="prefijo" class="form-control" value="<?php echo $prefijo; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="consecutivo">*Consecutivo</label>
                    <input type="number" name="consecutivo" id="consecutivo" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal</label>
                    <input type="text" name="sucursal" id="sucursal" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="subtotal">*Total</label>
                    <input type="number" id="total" name="total" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cajero">*Cajero(a)</label>
                    <input type="text" name="cajero" id="cajero" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Vale Provisional de Caja | Detalle de ticket</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_ticket" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="15%">Articulo</th>
                        <th>Descripcion</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">C.U.</th>
                        <th width="10%">Total</th>
                        <th width="5%"></th>
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
    <?php include 'modal_cambio.php'; ?>
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
      $("#consecutivo").focus();
      cargar_tabla();
    });

    $('#modal-cambio').on('show.bs.modal', function(e) {
      var prefijo = $(e.relatedTarget).data().prefijo;
      var consecutivo = $(e.relatedTarget).data().consecutivo;
      var artc_articulo = $(e.relatedTarget).data().articulo;
      var artc_cantidad = $(e.relatedTarget).data().cantidad;
      var folio = prefijo + "" + consecutivo;
      var url = "consulta_datos.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          prefijo: prefijo,
          consecutivo: consecutivo
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#m_sucursal').val(array[0]);
          $('#m_total').val(array[1]);
          $('#m_cajero').val(array[2]);
          $('#m_idCajero').val(array[3]);
          $("#folio").val(folio);
          $.ajax({
            type: "POST",
            url: "consulta_detalle.php",
            data: {
              prefijo: prefijo,
              consecutivo: consecutivo,
              artc_articulo: artc_articulo,
              artc_cantidad: artc_cantidad
            }, // Adjuntar los campos del formulario enviado.
            success: function(resp) {
              var array_detalle = eval(resp);
              $('#m_codigo').val(array_detalle[0]);
              $('#m_artc_descripcion').val(array_detalle[1]);
              $('#m_cantidad').val(array_detalle[2]);
              $('#m_precio').val(array_detalle[3]);
              $('#m_familia').val(array_detalle[5]);
            }
          });
        }
      });

    });

    $("#consecutivo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_datos.php"; // El script a dónde se realizará la petición.
        var prefijo = $("#prefijo").val();
        var consecutivo = $("#consecutivo").val();
        //alert(folio);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            prefijo: prefijo,
            consecutivo: consecutivo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              swal("Verifica!", "El folio de ticket que intentas ingresar no fue encontrado en el sistema.", "error");
              $("#form_registro")[0].reset();
              $("#consecutivo").focus();
            } else {
              var array = eval(respuesta);
              $('#sucursal').val(array[0]);
              $('#total').val(array[1]);
              $('#cajero').val(array[2]);
              cargar_tabla();
            }
          }
        });
        return false;
      }
    });
    $('#m_autoriza').select2({
      width: '100%',
      dropdownParent: $("#modal-cambio"),
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_gerentes.php",
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
    })

    function cargar_tabla() {
      var prefijo = $("#prefijo").val();
      var consecutivo = $("#consecutivo").val();
      $('#lista_ticket').dataTable().fnDestroy();
      $('#lista_ticket').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "desc"]
        ],
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
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          data: {
            prefijo: prefijo,
            consecutivo: consecutivo
          }, // Adjuntar los campos del formulario enviado.
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "artc_cantidad"
          },
          {
            "data": "precio"
          },
          {
            "data": "total"
          },
          {
            "data": "opciones"
          }
        ]
      });
    }
    $("#btnCambio").click(function() {
      var url = "insertar_cambio.php";
      if ($("#m_cambio").val() == "" || $("#m_nombre_cliente").val() == "" || $("#comentario").val() == "" || $("#m_autoriza").val().trim() === '') {
        alertify.error("Favor de ingresar los datos solicitados");
      } else {
        $.ajax({
          type: "POST",
          url: "insertar_cambio.php",
          data: $("#form-detalle").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(resp) {
            $("#form-detalle")[0].reset();
            $('#modal-cambio').modal('hide');
            window.open("vale_provisional.php?id=" + resp, "vale", "width=290,height=900,menubar=no,titlebar=no");
          }
        });
      }
    })
  </script>
</body>

</html>