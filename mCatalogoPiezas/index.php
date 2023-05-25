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
            <h3 class="box-title">Catálogo de Piezas | Registro de Catálogo</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="familia">*Familia</label>
                    <select name="familia" id="familia" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="interno">*Interno</label>
                    <input type="text" name="interno" id="interno" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="desc">*Descripción</label>
                    <input type="text" name="desc" id="desc" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="desc_det">Descripción detallada</label>
                  <input type="text" name="desc_det" id="desc_det" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="uni_m">*Unidad de Medida</label>
                    <select name="uni_m" id="uni_m" class="form-control">
                      <option value=""></option>
                      <option value="Pieza">Pieza</option>
                      <option value="Juego">Juego</option>
                      <option value="Metro">Metro</option>
                      <option value="Kilogramo">Kilogramo</option>
                      <option value="Litro">Litro</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="max">*Máximo</label>
                    <input type="number" name="max" id="max" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="min">*Mínimo</label>
                    <input type="number" name="min" id="min" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="reorden">*Reorden</label>
                    <input type="text" name="reorden" id="reorden" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="documento">*Seleccionar Fotografía</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                    <input type="file" name="archivos" id="archivos">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-3">
                  <label for="rack">*Rack:</label>
                  <input type="text" name="rack" class="form-control" id="rack" required>
                </div>
                <div class="form-group col-md-3">
                  <label for="columna">*Columna: </label>
                  <input type="text" name="columna" class="form-control" id="columna" required>
                </div>
                <div class="form-group col-md-3">
                  <label for="fila">*Fila:</label>
                  <input type="text" name="fila" class="form-control" id="fila" required>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Guardar Información</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Catálogo de Piezas | Listado de Piezas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <table id="lista_piezas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Código Interno</th>
                      <th>Familia</th>
                      <th>Descripción</th>
                      <th>Detalles</th>
                      <th>Foto</th>
                      <th>Ultimo Costo</th>
                      <th>Costo Promedio</th>
                      <th width="5%">Max</th>
                      <th width="5%">Min</th>
                      <th width="5%">Editar</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
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
      codigo_interno();
      cargar_tabla();
    });

    function cargar_tabla() {
      $('#lista_piezas').dataTable().fnDestroy();
      $('#lista_piezas').DataTable({
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
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_piezas.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "codigo_interno"
          },
          {
            "data": "familia"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "detalles"
          },
          {
            "data": "foto"
          },
          {
            "data": "ultimo_costo"
          },
          {
            "data": "costo_promedio"
          },
          {
            "data": "maximo"
          },
          {
            "data": "minimo"
          },
          {
            "data": "editar"
          }
        ]
      });
    };
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#familia').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_familias.php",
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
    $('#uni_m').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $("#btn-guardar").click(function() {
      var parametros = new FormData($("#form-datos")[0]);
      $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'insertar_pieza.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        contentType: false,
        processData: false,
        success: function(response) {
          swal("Registro exitoso", "La imagen ha sido actualizada correctamente", "success");
          $("#form-datos")[0].reset();
          codigo_interno();
        }
      });
    });

    function codigo_interno() {
      var url = 'codigo_interno.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#interno").val(array[0]);
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
  </script>
</body>

</html>