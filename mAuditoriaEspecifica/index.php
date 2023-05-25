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
            <h3 class="box-title">Auditoría específica | Inicio</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="auditor">*Auditor</label>
                  <select name="auditor" id="auditor" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="categoria">*Categoría</label>
                  <select name="categoria" id="categoria" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="iniciar_auditoria">Iniciar Auditoría</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Áreas de inventario | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_folio" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th width='10%'>Auditoría</th>
                        <th width='10%'>Código</th>
                        <th>Descripción</th>
                        <th width='10%'>Área</th>
                        <th width='10%'>Conteo</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-success" id="btnFinalizar">Finalizar auditoría</button>
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
      tabla_detalle();
    })
    $('#auditor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_auditor.php",
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
    $('#categoria').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_categoria.php",
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
    $("#iniciar_auditoria").click(function() {
      if ($("#auditor").val() == "" || $("#categoria").val() == "" || $("#area").val() == "") {
        alertify.error("Existen campos vacíos");
      } else {
        var url = "iniciar_auditoria.php";
        var auditor = $("#auditor").val();
        var categoria = $("#categoria").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            auditor: auditor,
            categoria: categoria
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "pendientes") {
              alertify.error("Existe una auditoría pendiente, favor de finalizarla");
            } else {
              alertify.success("Auditoría iniciada correctamente");
              tabla_detalle();
            }
          }
        });
      }
    });

    function tabla_detalle() {
      $('#lista_folio').dataTable().fnDestroy();
      $('#lista_folio').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
            title: 'ListaCategorias',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'ListaCategorias',
						exportOptions: {
							columns: ':visible'
						}
					},
          {
            extend: 'copy',
            text: 'Copiar registros',
            className: 'btn btn-default',
            copyTitle: 'Ajouté au presse-papiers',
            copyKeys: '',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
          {
            text: 'Saltar área',
            action: function() {
              saltar_area();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_folio.php",
          "dataSrc": "",
          data: {

          }
        },
        "columns": [{
            "data": "id",
          },
          {
            "data": "id_auditoria",
          },
          {
            "data": "artc_articulo",
          },
          {
            "data": "descripcion",
          },
          {
            "data": "area",
          },
          {
            "data": "cantidad",
          },
          {
            "data": "opciones",
          }
        ]
      });
    };

    function captura(folio, descripcion) {
      var url = "insertar_conteo.php";
      swal(descripcion, {
          content: {
            element: "input",
            attributes: {
              placeholder: "Ingresa la cantidad:",
              type: "number",
            },
          },
        })
        .then((value) => {
          var cantidad = value;
          $.ajax({
            type: "POST",
            url: url,
            data: {
              folio: folio,
              cantidad: cantidad
            },
            success: function(respuesta) {
              alertify.success("Cantidad ingresada con éxito");
              tabla_detalle();
            }
          });
        });
    };
    $("#btnFinalizar").click(function() {
      var url = "finalizar_auditoria.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {

        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "no_finalizado") {
            alertify.error("Existen conteos incompletos");
          } else {
            alertify.success("La auditoría ha sido finalizada correctamente");
          }
        }
      });
    });

    function saltar_area() {
      var url = "saltar_area.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {

        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          tabla_detalle();
        }
      });
    }
  </script>
</body>

</html>