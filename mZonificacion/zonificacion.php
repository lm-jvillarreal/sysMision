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
        <div class="box box-danger">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6">
                <h3 class="box-title">Zonificación | Áreas por Sucursal</h3>
              </div>
              <div class="col-md-6">
                <h3 class="box-title">Zonificación | Zonas por Sucursal</h3>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_areas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th>Área</th>
                        <th width='10%'>Sucursal</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_sucursales" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th>Sucursal</th>
                        <th width='10%'>Zonas</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="guardar">Guardar</button>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'modal_areas.php'; ?>
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
    $(document).ready(function() {
      tabla_areas();
      tabla_zonas();
    });
    $('#sucursal').select2({
      width: '100%',
      dropdownParent: $("#modal-area"),
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_sucursal.php",
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

    function tabla_areas() {
      $('#lista_areas').dataTable().fnDestroy();
      $('#lista_areas').DataTable({
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
            text: 'Agregar área',
            action: function() {
              agregar_area();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_areas.php",
          "dataSrc": "",
          data: {

          }
        },
        "columns": [{
            "data": "id",
          },
          {
            "data": "area",
          },
          {
            "data": "sucursal",
          },
          {
            "data": "opciones",
          }
        ]
      });
    };

    function tabla_zonas() {
      $('#lista_sucursales').dataTable().fnDestroy();
      $('#lista_sucursales').DataTable({
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
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_zonas.php",
          "dataSrc": "",
          data: {

          }
        },
        "columns": [{
            "data": "id",
          },
          {
            "data": "sucursal",
          },
          {
            "data": "zonas",
          },
          {
            "data": "opciones",
          }
        ]
      });
    };

    function agregar_area() {
      $("#id").val("");
      $("#area").val("");
      $("#sucursal").select2("trigger", "select", {
        data: {
          id: "",
          text: ""
        }
      });
      $('#modal-area').modal('show');
    }
    $("#btn-guardar").click(function() {
      if ($("#sucursal").val() == "" || $("#area").val() == "") {
        alertify.error("Favor de rellenar todos los campos");
      } else {
        var url = 'insertar_area.php';
        var id = $("#id").val();
        var sucursal = $("#sucursal").val();
        var area = $("#area").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id: id,
            sucursal: sucursal,
            area: area
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok_insert") {
              alertify.success("Área agregada correctamente");
            } else if (respuesta == "ok_update") {
              alertify.success("Área actualizada correctamente");
            }
            tabla_areas();
            $('#modal-area').modal('toggle');
          }
        });
      }
    });

    function editar(id) {
      var url = 'consulta_area.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#modal-area').modal('show');
          var array = eval(respuesta);
          $("#id").val(array[0]);
          $("#area").val(array[3]);
          $("#sucursal").select2("trigger", "select", {
            data: {
              id: array[1],
              text: array[2]
            }
          });
        }
      });
    };

    function editarZonas(id, sucursal) {
      var url = "actualizar_zonas.php";
      swal("ingresa la cantidad de zonas para " + sucursal, {
          content: {
            element: "input",
            attributes: {
              placeholder: "Ingresa la cantidad de zonas:",
              type: "number",
            },
          },
        })
        .then((value) => {
          var cantidad = value;
          if (cantidad == null || cantidad == "") {

          } else {
            $.ajax({
              type: "POST",
              url: url,
              data: {
                id: id,
                cantidad: cantidad
              },
              success: function(respuesta) {
                alertify.success("Cantidad de zonas actualizada con éxito");
                tabla_zonas();
              }
            });
          }
        });
    }
  </script>
</body>

</html>