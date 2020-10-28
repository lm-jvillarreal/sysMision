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
            <h3 class="box-title">Categorías | Registro</h3>
          </div>

          <div class="box-body">
            <form action="" method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nombre_categoria">*Categoría</label>
                    <input type="hidden" id="id_categoria" name="id_categoria">
                    <input type="text" id="nombre_categoria" name="nombre_categoria" class="form-control" placeholder="ingresa el nombre de la categoría">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descripcion_categoria">*Descripción</label>
                    <input type="text" id="desc_categoria" name="desc_categoria" class="form-control" placeholder="Describe la categoría">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id='btnGuardar'>Guardar Datos</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Categorías Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_categorias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width="5%">#</th>
                      <th width="20%">Categoría</th>
                      <th>Descripción</th>
                      <th width="5%">Activo</th>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <th width="5%">#</th>
                      <th width="20%">Categoría</th>
                      <th>Descripción</th>
                      <th width="5%">Activo</th>
                    </tfoot>
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
    function cargar_tabla() {
      $('#lista_categorias').dataTable().fnDestroy();
      $('#lista_categorias').DataTable({
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
            title: 'Control Equipos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Equipos',
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
          "url": "tabla_categorias.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "id_categoria"
          },
          {
            "data": "nombre_categoria"
          },
          {
            "data": "desc_categoria"
          },
          {
            "data": "activo_categoria"
          }
        ]
      });
    };

    $("#btnGuardar").click(function() {
      var url = "insertar_categoria.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro guardado correctamente");
            cargar_tabla();
          } else if (respuesta == "duplicado") {
            alertify.error("El registro ya existe");
          } else {
            alertify.error("Ha ocurrido un error");
          }
          $(":text").val(''); //Limpiar los campos tipo Text
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    })

    function activo(registro) {
      var id_registro = registro;
      var url = 'cambiar_estado.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Cambio modificado correctamente");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function datos_editar(id) {
      var url = "consulta_datos_editar.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_categoria').val(array[0]);
          $('#nombre_categoria').val(array[1]);
          $('#desc_categoria').val(array[2]);
        }
      });
    };
    $(document).ready(function() {
      cargar_tabla();
    });
  </script>
</body>

</html>