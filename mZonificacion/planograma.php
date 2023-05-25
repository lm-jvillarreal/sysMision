<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <style>
    #modal_articulos {
      width: 100%;
    }
  </style>
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Zonificación | Registro de muebles</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="area">*Área:</label>
                  <select name="area" id="area" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="zona">*Zona:</label>
                  <select name="zona" id="zona" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="mueble">*Mueble:</label>
                  <select name="mueble" id="mueble" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="cara">*Cara:</label>
                  <select name="cara" id="cara" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="guardar">Seleccionar Cara</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">
              Zonificación | Lista de muebles
            </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="lista_fracciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width='5%'>#</th>
                    <th>Sucursal</th>
                    <th width='10%'>Área</th>
                    <th width='10%'>Zona</th>
                    <th width='10%'>Tipo</th>
                    <th width='10%'>Mueble</th>
                    <th width='10%'>Cara</th>
                    <th width='10%'>Fraccion</th>
                    <th width='10%'></th>
                  </tr>
                </thead>
              </table>
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
    <?php include 'modal_detalle.php'; ?>
    <?php include 'modal_articulos.php'; ?>
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
      tabla_fracciones($("#cara").val());
    });
    $('#area').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      ajax: {
        url: "select_area.php",
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
    $('#zona').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "select_zona.php",
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
    $('#mueble').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: 'select_mueble.php',
        type: "post",
        dataType: 'json',
        data: function(params) {
          var area = $("#area").val();
          var zona = $("#zona").val();
          var query = {
            searchTerm: params.term,
            area: area,
            zona: zona
          }
          return query;
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });
    $('#cara').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: 'select_cara.php',
        type: "post",
        dataType: 'json',
        data: function(params) {
          var area = $("#area").val();
          var zona = $("#zona").val();
          var mueble = $("#mueble").val();
          var query = {
            searchTerm: params.term,
            area: area,
            zona: zona,
            mueble: mueble
          }
          return query;
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });
    $("#guardar").click(function() {
      if ($("#area").val() == "" || $("#zona").val() == "" || $("#mueble").val() == "" || $("#cara").val() == "") {
        alertify.error("Debes seleccionar todos los campos requeridos");
      } else {
        var url = "validar_fracciones.php";
        var cara = $("#cara").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            cara: cara
          },
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              guardar();
            } else {
              $("#area").attr("disabled",true);
              $("#zona").attr("disabled",true);
              $("#mueble").attr("disabled",true);
              $("#cara").attr("disabled",true);
              tabla_fracciones($("#cara").val());
            }
          }
        });
      }
    });

    function guardar() {
      var url = "insertar_fracciones.php";
      swal("Ingresa el número de fracciones:", {
          content: {
            element: "input",
            attributes: {
              placeholder: "Cantidad:",
              type: "number",
            },
          },
        })
        .then((value) => {
          var partes = value;
          if (partes == "" || partes == null || partes == '0') {
            alertify.error("Debe ingresar un valor mayor a cero");
          } else {
            var area = $("#area").val();
            var zona = $("#zona").val();
            var mueble = $("#mueble").val();
            var cara = $("#cara").val();
            $.ajax({
              type: "POST",
              url: url,
              data: {
                partes: partes,
                area: area,
                zona: zona,
                mueble: mueble,
                cara: cara
              },
              success: function(respuesta) {
                alertify.success("Registro creado correctamente");
                tabla_fracciones($("#cara").val());
              }
            });
          }
        });
    }

    function tabla_fracciones(id_cara) {
      $('#lista_fracciones').dataTable().fnDestroy();
      $('#lista_fracciones').DataTable({
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
          "url": "tabla_fracciones.php",
          "dataSrc": "",
          data: {
            cara: id_cara
          }
        },
        "columns": [{
            "data": "id",
          },
          {
            "data": "sucursal",
          },
          {
            "data": "area",
          },
          {
            "data": "zona",
          },
          {
            "data": "tipo_mueble",
          },
          {
            "data": "mueble",
          },
          {
            "data": "cara",
          },
          {
            "data": "fraccion",
          },
          {
            "data": "opciones",
          }
        ]
      });
    };

    function tabla_articulos(id_fraccion) {
      $('#lista_articulos').dataTable().fnDestroy();
      $('#lista_articulos').DataTable({
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
          "url": "tabla_articulos.php",
          "dataSrc": "",
          data: {
            fraccion: id_fraccion
          }
        },
        "columns": [{
            "data": "id",
          },
          {
            "data": "sucursal",
          },
          {
            "data": "area",
          },
          {
            "data": "zona",
          },
          {
            "data": "tipo_mueble",
          },
          {
            "data": "mueble",
          },
          {
            "data": "cara",
          },
          {
            "data": "fraccion",
          },
          {
            "data": "nivel",
          },
          {
            "data": "artc_articulo",
          },
          {
            "data": "artc_descripcion",
          },
          {
            "data": "artc_frente",
          },
          {
            "data": "artc_fondo",
          },
          {
            "data": "artc_capacidad",
          },
          {
            "data": "opciones",
          },
        ]
      });
    };

    function tabla_ultimo(id_fraccion) {
      $('#lista_ultimo').dataTable().fnDestroy();
      $('#lista_ultimo').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "searching":false,
        "ajax": {
          "type": "POST",
          "url": "tabla_ultimo.php",
          "dataSrc": "",
          data: {
            id_fraccion: id_fraccion
          }
        },
        "columns": [{
            "data": "artc_articulo",
          },
          {
            "data": "artc_descripcion",
          },
          {
            "data": "frente",
          },
          {
            "data": "fondo",
          },
          {
            "data": "alto",
          },
          {
            "data": "capacidad",
          }
        ]
      });
    };

    function articulo(id_fraccion) {
      $("#modal-fraccion").modal("show");
      $("#fraccion").val(id_fraccion);
      nivel(id_fraccion);
      tabla_ultimo(id_fraccion);
    };
    $('#modal-fraccion').on('shown.bs.modal', function() {
      $("#artc_articulo").focus();
      $("#lblArea").html('Area: '+$("#area").text());
      $("#lblZona").html('Zona: '+$("#zona").text());
      $("#lblMueble").html('Mueble: '+$("#mueble").text());
      $("#lblCara").html('Zona: '+$("#cara").text());
    });
    $("#artc_articulo").keypress(function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = 'consulta_descripcion.php';
        var artc_articulo = $("#artc_articulo").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            artc_articulo: artc_articulo
          },
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              alertify.error("El artículo no existe");
            } else {
              var array = eval(respuesta);
              $("#artc_descripcion").val(array[0]);
              $("#frente").focus();
            }
          }
        });
      }
    });
    $("#btnArticulo").click(function() {
      var area = $("#area").val();
      var zona = $("#zona").val();
      var mueble = $("#mueble").val();
      var cara = $("#cara").val();
      var fraccion = $("#fraccion").val();
      var nivel = $("#nivel").val();
      var artc_articulo = $("#artc_articulo").val();
      var artc_descripcion = $("#artc_descripcion").val();
      var artc_frente = $("#frente").val();
      var artc_alto = $("#alto").val();
      var artc_fondo = $("#fondo").val();
      var url = "insertar_detalle.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          area: area,
          zona: zona,
          mueble: mueble,
          cara: cara,
          fraccion: fraccion,
          nivel: nivel,
          artc_articulo: artc_articulo,
          artc_descripcion: artc_descripcion,
          artc_frente: artc_frente,
          artc_alto: artc_alto,
          artc_fondo: artc_fondo
        },
        success: function(respuesta) {
          alertify.success("Artículo agregado correctamente");
          $("#artc_articulo").val('');
          $("#artc_descripcion").val('');
          $("#frente").val('');
          $("#fondo").val('');
          $("#artc_articulo").focus();
          tabla_ultimo(fraccion);
        }
      });
    });

    function nivel(id_cara) {
      var url = 'consulta_nivel.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_cara: id_cara
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#nivel").val(array[0]);
        }
      });
    };
    $("#btnNivel").click(function() {
      var nivel = parseInt($("#nivel").val()) + 1;
      $("#nivel").val(nivel);
    });

    function ver(fraccion) {
      $("#modal-articulos").modal("show");
      tabla_articulos(fraccion);
    }

    function eliminar_articulo(id_detalle,fraccion) {
      var url = 'eliminar_detalle.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_detalle: id_detalle
        },
        success: function(respuesta) {
          alertify.success("Artículo eliminado del mueble");
          tabla_articulos(fraccion);
        }
      });
    }
  </script>
</body>

</html>