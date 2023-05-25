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
            <h3 class="box-title">Articulos descatalogados | Importar Folio</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-catalogo" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="documento">*Documento</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                    <input type="file" name="file">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion">*Sucursal</label>
                    <select name="sucursal" id="sucursal" class="form-control">
                      <option value=""></option>
                      <option value="1">Díaz ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas </option>
                      <option value="4">Allende</option>
                      <option value="5">Petaca</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-6 text-left">
                <button class="btn btn-primary" id="btnConsultar">Mostrar datos</button>
              </div>
              <div class="col-md-6 text-right">
                <button class="btn btn-warning" id="btn-guardar">Cargar Archivo</button>
              </div>
            </div>
          </div>
        </div>

        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Folios Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_descatalogados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width='15%'>Artículo</th>
                        <th>Descripción</th>
                        <th width="10%">Sucursal</th>
                        <th width="15%">Fecha</th>
                        <th width="10%">Usuario</th>
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
    <?php include 'modal_teoricos.php'; ?>
    <?php include 'modal_compartir.php'; ?>
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
    });
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
    });
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $("#btn-guardar").click(function(){
      $("#form-catalogo").submit();
    });
    $('#form-catalogo').submit(function(e) {
      if ($("#action").val() == "" || $("#sucursal").val() == "") {
        alertify.error("Datos incompletos.");
      } else {
        var data = new FormData(this); //Creamos los datos a enviar con el formulario
        $.ajax({
          url: 'importar_lista.php', //URL destino
          data: data,
          processData: false, //Evitamos que JQuery procese los datos, daría error
          contentType: false, //No especificamos ningún tipo de dato
          type: 'POST',
          success: function(resultado) {
            if (resultado == "ok") {
              swal("Satisfactorio!!", "La actualización de artículos se realizó sin inconvenientes.", "success");
            } else if (resultado == "invalido") {
              alertify.error("El archivo que intenta subir no es válido");
            }
            $(":text").val("");
            cargar_tabla();
          }
        });
      }
      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });

    function cargar_tabla() {
      var sucursal = $("#sucursal").val();
      $('#lista_descatalogados').dataTable().fnDestroy();
      $('#lista_descatalogados').DataTable({
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
            title: 'Modulos-Lista',
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
            text: 'Lista de Modulos',
            action: function() {
              alert('hola');
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_descatalogados.php",
          "dataSrc": "",
          "data": {
            sucursal: sucursal
          }
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fecha"
          },
          {
            "data": "usuario"
          }
        ]
      });
    }
    $("#btnConsultar").click(function() {
      if ($("#sucursal").val() == "") {
        alertify.error("Seleccionar una sucursal");
      } else {
        cargar_tabla();
      }
    })
  </script>
</body>

</html>