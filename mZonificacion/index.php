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
            <h3 class="box-title">Zonificación | Registro de muebles</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="frmDatos">
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
                    <input type="number" class="form-control" name="mueble" id="mueble">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tipo_mueble">*Tipo de mueble:</label>
                    <select name="tipo_mueble" id="tipo_mueble" class="form-control">
                      <option value=""></option>
                      <option value="GONDOLA">GÓNDOLA</option>
                      <option value="PROMOCIONAL">PROMOCIONAL</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="comentarios">*Comentarios</label>
                    <textarea name="comentarios" id="comentarios" cols="100%" rows="2" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="fijar" name="fijar" value='1'>
                    <label class="form-check-label" for="gridCheck">
                      Fijar mueble
                    </label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="guardar">Registrar mueble</button>
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
              <table id="lista_muebles" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width='5%'>#</th>
                    <th width='10%'>Sucursal</th>
                    <th width='10%'>Área</th>
                    <th width='10%'>Zona</th>
                    <th width='10%'>Mueble</th>
                    <th width='10%'>Tipo</th>
                    <th width='30%'>Comentarios</th>
                    <th width='5%'></th>
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
    <?php include 'modal_caras.php'; ?>
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
      ultima_area();
      ultima_zona();
      tabla_zonas();
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
    $('#tipo_mueble').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });

    function guardarMueble() {
      if ($("#area").val() == "" || $("#zona").val() == "" || $("#mueble").val() == "" || $("#tipo_mueble").val() == "" || $("#comentarios").val() == "") {
        alertify.error("Favor de rellenar todos los campos");
      } else {
        var url = "insertar_mueble.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#frmDatos').serialize(),
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Datos actualizados correctamente");
              tabla_zonas();
            } else if (respuesta == "no_permitido") {
              alertify.error("Ya existe un mueble fijado");
            }
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
        return false;
      }
    };
    $("#guardar").click(function() {
      guardarMueble();
      ultima_area();
      ultima_zona();
      $("#mueble").val("");
      $("#comentarios").val("");
      $("#tipo_mueble").select2("trigger", "select", {
        data: {
          id: "",
          text: ""
        }
      });

    })

    function ultima_area() {
      var url = "ultima_area.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {},
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#area").select2("trigger", "select", {
            data: {
              id: array[0],
              text: array[1]
            }
          });
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
      return false;
    }

    function ultima_zona() {
      var url = "ultima_zona.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {},
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#zona").select2("trigger", "select", {
            data: {
              id: array[0],
              text: array[0]
            }
          });
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
      return false;
    }

    function tabla_zonas() {
      $('#lista_muebles').dataTable().fnDestroy();
      $('#lista_muebles').DataTable({
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
          "url": "tabla_muebles.php",
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
            "data": "area",
          },
          {
            "data": "zona",
          },
          {
            "data": "mueble",
          },
          {
            "data": "tipo_mueble",
          },
          {
            "data": "comentarios",
          },
          {
            "data": "opciones",
          }
        ]
      });
    };

    function tabla_caras(id) {
      $('#lista_caras').dataTable().fnDestroy();
      $('#lista_caras').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Exportar a Excel',
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
            text: 'Agregar cara',
            action: function() {
              agregar_cara();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_caras.php",
          "dataSrc": "",
          data: {
            id: id
          }
        },
        "columns": [{
            "data": "id",
          },
          {
            "data": "tipo_mueble",
          },
          {
            "data": "cara_mueble",
          },
          {
            "data": "motivo_baja",
          },
          {
            "data": "opciones",
          },
        ]
      });
    };

    function ver(id) {
      $("#modal-caras").modal('show');
      $("#id").val(id);
      tabla_caras(id);
    }

    function baja(id) {
      var url = "baja_cara.php";
      swal("Ingresa el motivo de la baja", {
          content: {
            element: "input",
            attributes: {
              placeholder: "motivo:",
              type: "text",
            },
          },
        })
        .then((value) => {
          var motivo = value;
          $.ajax({
            type: "POST",
            url: url,
            data: {
              id: id,
              motivo: motivo
            },
            success: function(respuesta) {
              alertify.success("Cara descontinuada con éxito");
              tabla_caras($("#id").val());
            }
          });
        });
    }

    function agregar_cara() {
      var id = $("#id").val();
      var url = "insertar_cara.php";
      swal("Ingresa el nombre de la cara", {
          content: {
            element: "input",
            attributes: {
              placeholder: "nombre:",
              type: "text",
            },
          },
        })
        .then((value) => {
          var nombre = value;
          $.ajax({
            type: "POST",
            url: url,
            data: {
              id: id,
              nombre: nombre
            },
            success: function(respuesta) {
              alertify.success("Cara agregada con éxito");
              tabla_caras($("#id").val());
            }
          });
        });
    }
  </script>
</body>

</html>