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
            <form method="POST" id="form_datos">
              <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Registro de Formatos</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="nombre">*Nombre del Archivo:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del Archivo">
                        <input type="hidden" name="id_registro" id="id_registro">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="formato">*Formato:</label>
                        <input name="action" type="hidden" value="upload" id="action" />
                        <input type="file" name="archivos" id="archivos">
                        <br>
                        <center>
                          <a style="display: none;" target="_blank" id="archivos"><i class="fa fa-download fa-3x" aria-hidden="true"></i></a>
                        </center>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer text-right">
                    <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Lista de Formatos</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_formatos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Nombre</th>
                            <th width="5%">Activo</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Nombre</th>
                            <th width="5%">Activo</th>
                          </tr>
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
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
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
          $('#lista_formatos').dataTable().fnDestroy();
          $('#lista_formatos').DataTable({
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
              "url": "tabla_formatos.php",
              "dataSrc": ""
            },
            "columns": [{
                "data": "id_incidencia"
              },
              {
                "data": "nombre"
              },
              {
                "data": "activo"
              }
            ]
          });
        }
        $(function() {
          cargar_tabla();
        })
        $.validator.setDefaults({
          submitHandler: function() {
            var parametros = new FormData($("#form_datos")[0]);
            $.ajax({
              data: parametros,
              url: 'insertar_formato.php', // El script a dónde se realizará la petición.
              type: 'POST',
              dataType: 'html',
              contentType: false,
              processData: false,
              success: function(respuesta) {
                if (respuesta == "ok_nuevo") {
                  alertify.success("Registro guardado correctamente");
                } else if (respuesta == "ok_actualizado") {
                  alertify.success("Registro actualizado correctamente");
                } else if (respuesta == "duplicado") {
                  alertify.error("El registro ya existe");
                } else {
                  alertify.error("Ha ocurrido un error");
                }
                $(":text").val(''); //Limpiar los campos tipo Text
                cargar_tabla();
              }
            });
            // Evitar ejecutar el submit del formulario.
            return false;
          }
        });
        $(":file").filestyle('buttonText', 'Seleccionar');
        $(":file").filestyle('size', 'sm');
        $(":file").filestyle('input', true);
        $(":file").filestyle('disabled', false);
        $(document).ready(function() {
          $("#form_datos").validate({
            rules: {
              nombre:   "required",
              formato:  "required",

            },
            messages: {
              nombre:   "Campo requerido",
              formato:  "Campo requerido",
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
              // Add the `help-block` class to the error element
              error.addClass("help-block");

              if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
              } else {
                error.insertAfter(element);
              }
            },
            highlight: function(element, errorClass, validClass) {
              $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
              $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
              $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
              $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
              $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
              $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
            }
          });
        });
      </script>
    </body>
  </html>